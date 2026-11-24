<?php
// User Profile / Account management: status, verification, devices (max active devices rule), password assist, delete requests.
require __DIR__ . '/_boot.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $id = (int)($_POST['id'] ?? 0); $act = (string)($_POST['action'] ?? '');
    $u = rows('SELECT * FROM users WHERE id=?', [$id])[0] ?? null;
    $back = 'users.php?view=' . $id;
    if (!$u) { flash('User not found.', 'error'); header('Location: users.php'); exit; }
    if ($id === (int)$user['id'] && in_array($act, ['status', 'logout_all', 'delete_approve'], true)) { flash('You cannot change your own account here.', 'error'); header('Location: ' . $back); exit; }
    switch ($act) {
        case 'status':
            $new = (string)($_POST['value'] ?? '');
            if (!in_array($new, ['active', 'inactive', 'suspended'], true)) break;
            $reason = mb_substr(trim((string)($_POST['reason'] ?? '')), 0, 255);
            db()->prepare('UPDATE users SET status=?, status_reason=? WHERE id=?')->execute([$new, $reason ?: null, $id]);
            if ($new !== 'active') pl_revoke_all_sessions($id);
            pl_audit('user:' . $new, null, $id, $u['email'] . ($reason ? ' — ' . $reason : ''), $u['community_id'] ? (int)$u['community_id'] : null);
            $msg = $new === 'active' ? 'Your PeopleLink account is active again.' : 'Your PeopleLink account has been ' . ($new === 'suspended' ? 'suspended' : 'deactivated') . ($reason ? ": $reason" : '.');
            pl_notify_user($id, $u['community_id'] ? (int)$u['community_id'] : null, 'Account ' . $new, $msg, 'account', null, null, $new === 'active');
            pl_sms($u['phone'], 'PeopleLink: ' . $msg);
            flash('Account is now ' . $new); break;
        case 'verify':
            $col = ($_POST['what'] ?? '') === 'email' ? 'email_verified' : 'phone_verified';
            db()->prepare("UPDATE users SET $col=1-$col WHERE id=?")->execute([$id]);
            pl_audit('user:verify_' . $col, null, $id, $u['email']); flash(($col === 'email_verified' ? 'Email' : 'Mobile') . ' verification updated'); break;
        case 'password':
            $pw = (string)($_POST['password'] ?? '');
            if (strlen($pw) < 8) { flash('Temporary password must be at least 8 characters.', 'error'); break; }
            db()->prepare('UPDATE users SET password_hash=? WHERE id=?')->execute([password_hash($pw, PASSWORD_DEFAULT), $id]);
            pl_revoke_all_sessions($id);
            pl_audit('user:password_reset', null, $id, $u['email']); flash('Temporary password set and all devices logged out. Share it with the user securely.'); break;
        case 'community':
            $c = (int)($_POST['community_id'] ?? 0);
            if ($c && scalar('SELECT COUNT(*) FROM communities WHERE id=?', [$c])) { db()->prepare('UPDATE users SET community_id=? WHERE id=?')->execute([$c, $id]); pl_audit('user:community', null, $id, $u['email'] . ' → ' . (pl_community_names()[$c] ?? $c)); flash('Community changed'); }
            break;
        case 'logout_device':
            flash(pl_revoke_session((int)($_POST['session_id'] ?? 0), $id) ? 'Device logged out' : 'Session not found.'); pl_audit('user:logout_device', null, $id, $u['email']); break;
        case 'logout_all':
            $n = pl_revoke_all_sessions($id); pl_audit('user:logout_all', null, $id, $u['email']); flash("$n device(s) logged out"); break;
        case 'delete_approve':
            db()->prepare("UPDATE users SET status='deleted' WHERE id=?")->execute([$id]);
            db()->prepare('UPDATE device_tokens SET is_active=0 WHERE user_id=?')->execute([$id]);
            pl_revoke_all_sessions($id);
            pl_audit('user:deleted', null, $id, $u['email']); flash('Account marked as deleted. The user can no longer log in.'); break;
        case 'delete_reject':
            db()->prepare('UPDATE users SET delete_requested_at=NULL, delete_reason=NULL WHERE id=?')->execute([$id]);
            pl_audit('user:delete_rejected', null, $id, $u['email']); flash('Delete request cleared'); break;
    }
    header('Location: ' . $back); exit;
}

$prefs = fn($u) => json_decode($u['prefs'] ?? '', true) ?: [];

if (isset($_GET['view'])):
    $u = rows('SELECT * FROM users WHERE id=?', [(int)$_GET['view']])[0] ?? null;
    if (!$u) { flash('User not found.', 'error'); header('Location: users.php'); exit; }
    $sessions = rows('SELECT * FROM user_sessions WHERE user_id=? ORDER BY revoked_at IS NULL DESC, last_seen_at DESC LIMIT 20', [$u['id']]);
    $activeIds = array_column(pl_active_sessions((int)$u['id']), 'id');
    $member = rows('SELECT * FROM members WHERE user_id=? ORDER BY id DESC LIMIT 1', [$u['id']])[0] ?? null;
    $mat = rows('SELECT id, profile_code, status FROM matrimony_profiles WHERE user_id=? ORDER BY id DESC LIMIT 1', [$u['id']])[0] ?? null;
    $pk = rows("SELECT up.*, p.name FROM user_packages up LEFT JOIN packages p ON p.id=up.package_id WHERE up.user_id=? ORDER BY up.expires_at DESC LIMIT 10", [$u['id']]);
    $p = $prefs($u);
    $st = $u['status'] ?? 'active';
    render_header('User: ' . $u['name'], 'Users/All Users', $user, $comm); ?>
<div class="card anim"><div class="card-h"><div><h3><?= e($u['name']) ?></h3><small class="muted">#<?= (int)$u['id'] ?> · <?= e($u['role']) ?> · joined <?= dshort($u['created_at']) ?></small></div>
  <div class="actions"><?= pl_status_badge($st) ?><?= $u['delete_requested_at'] && $st !== 'deleted' ? badge('pending', 'Delete requested') : '' ?></div></div>
  <div class="actions">
    <?php foreach (['active' => ['Activate', 'btn-blue'], 'inactive' => ['Deactivate', 'btn-orange'], 'suspended' => ['Suspend', 'btn-red']] as $s => [$l, $c]) if ($s !== $st && $st !== 'deleted'): ?>
      <button type="button" class="btn btn-sm <?= $c ?>" data-open="stDlg" data-fill="<?= e(json_encode(['value' => $s])) ?>" data-title="<?= e($l) ?> account"><?= e($l) ?></button><?php endif; ?>
    <button type="button" class="btn btn-sm btn-line" data-open="pwDlg"><?= icon('fa-key') ?> Set temporary password</button>
    <a class="btn btn-sm btn-line" href="users.php"><?= icon('fa-arrow-left') ?> All users</a></div></div>
<div class="grid2 anim">
  <div class="card"><div class="card-h"><h3>User information</h3></div><div class="kv">
    <div><span>Name</span><b><?= e($u['name']) ?></b></div><div><span>Email</span><b><?= e($u['email']) ?> <?= $u['email_verified'] ? badge('approved', 'verified') : badge('pending', 'not verified') ?></b></div>
    <div><span>Mobile</span><b><?= e($u['phone'] ?: '—') ?> <?= $u['phone_verified'] ? badge('approved', 'verified') : badge('pending', 'not verified') ?></b></div>
    <div><span>Community</span><b><?= e(pl_community_names()[$u['community_id']] ?? '—') ?></b></div>
    <div><span>Registered</span><b><?= e(date('d M Y, H:i', strtotime($u['created_at']))) ?></b></div><div><span>Last login</span><b><?= $u['last_login_at'] ? e(date('d M Y, H:i', strtotime($u['last_login_at']))) : '—' ?></b></div>
    <div><span>Account status</span><b><?= pl_status_badge($st) ?> <?= $u['status_reason'] ? '<small>' . e($u['status_reason']) . '</small>' : '' ?></b></div>
    <div><span>Member profile</span><b><?= $member ? '<a class="lnk" href="manage.php?e=member&view=' . (int)$member['id'] . '">' . e($member['full_name']) . '</a> ' . pl_status_badge($member['status']) : '—' ?></b></div>
    <div><span>Matrimony profile</span><b><?= $mat ? e($mat['profile_code']) . ' ' . pl_status_badge($mat['status']) : '—' ?></b></div>
    <?php foreach (['gender' => 'Gender', 'dob' => 'Date of birth', 'city' => 'City', 'state' => 'State', 'country' => 'Country'] as $k => $l): ?><div><span><?= $l ?></span><b><?= e($u[$k] ?: '—') ?></b></div><?php endforeach; ?>
  </div>
  <div class="actions mt">
    <?php foreach (['phone' => 'mobile', 'email' => 'email'] as $w => $l): ?><form class="inline" method="post"><?= pl_csrf_field() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><input type="hidden" name="action" value="verify"><input type="hidden" name="what" value="<?= $w ?>"><button class="btn btn-sm btn-line"><?= $u[$w . '_verified'] ? 'Unverify' : 'Mark verified' ?>: <?= $l ?></button></form><?php endforeach; ?>
  </div>
  <form method="post" class="toolbar mt"><?= pl_csrf_field() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><input type="hidden" name="action" value="community"><?= pl_community_select('community_id', (string)$u['community_id']) ?><button class="btn btn-sm btn-line">Change community</button></form></div>
  <div class="card"><div class="card-h"><h3>Privacy & notifications</h3></div><div class="kv one">
    <?php foreach (['profile_visibility' => 'Profile visibility', 'mobile_visibility' => 'Mobile visibility', 'email_visibility' => 'Email visibility', 'push_enabled' => 'Push notifications', 'sms_enabled' => 'SMS', 'email_enabled' => 'Email updates'] as $k => $l): ?>
      <div><span><?= $l ?></span><b><?= e(isset($p[$k]) ? (is_bool($p[$k]) ? ($p[$k] ? 'On' : 'Off') : (PL_VISIBILITY[$p[$k]] ?? $p[$k])) : 'Default') ?></b></div><?php endforeach; ?>
    <?php if ($u['delete_requested_at']): ?><div><span>Delete request</span><b><?= dshort($u['delete_requested_at']) ?> <small><?= e($u['delete_reason']) ?></small></b></div><?php endif; ?>
  </div>
  <?php if ($u['delete_requested_at'] && $st !== 'deleted'): ?><div class="actions mt">
    <form class="inline" method="post" data-confirm="Delete this account? The user will not be able to log in again."><?= pl_csrf_field() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><input type="hidden" name="action" value="delete_approve"><button class="btn btn-sm btn-red">Approve deletion</button></form>
    <form class="inline" method="post"><?= pl_csrf_field() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><input type="hidden" name="action" value="delete_reject"><button class="btn btn-sm btn-line">Reject request</button></form></div><?php endif; ?></div>
</div>
<div class="card anim"><div class="card-h"><h3>Devices & login sessions (<?= count($activeIds) ?>/<?= pl_device_limit() ?> active)</h3>
  <?php if ($activeIds): ?><form class="inline" method="post" data-confirm="Log this user out of every device?"><?= pl_csrf_field() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><input type="hidden" name="action" value="logout_all"><button class="btn btn-sm btn-red">Logout all devices</button></form><?php endif; ?></div>
  <?php if (!$sessions): ?><div class="empty"><?= icon('fa-mobile-screen', 'big') ?>No login sessions recorded.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Device</th><th>Platform</th><th>IP</th><th>Logged in</th><th>Last seen</th><th>Status</th><th></th></tr></thead><tbody>
  <?php foreach ($sessions as $s): $on = in_array($s['id'], $activeIds); ?><tr>
    <td data-label="Device"><b><?= e($s['device_name'] ?: 'Device') ?></b><br><small><?= e(mb_strimwidth((string)$s['user_agent'], 0, 60, '…')) ?></small></td><td data-label="Platform"><?= e($s['platform']) ?></td><td data-label="IP"><?= e($s['ip']) ?></td>
    <td data-label="Logged in"><?= e(date('d M Y, H:i', strtotime($s['created_at']))) ?></td><td data-label="Last seen"><?= e(date('d M Y, H:i', strtotime($s['last_seen_at']))) ?></td>
    <td data-label="Status"><?= $on ? badge('active') : badge('inactive', $s['revoked_at'] ? 'logged out' : 'expired') ?></td>
    <td><?php if ($on): ?><form class="inline" method="post"><?= pl_csrf_field() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><input type="hidden" name="action" value="logout_device"><input type="hidden" name="session_id" value="<?= (int)$s['id'] ?>"><button class="btn btn-sm btn-orange">Logout device</button></form><?php endif; ?></td></tr>
  <?php endforeach; ?></tbody></table></div><?php endif; ?></div>
<div class="card anim"><div class="card-h"><h3>Packages</h3></div>
  <?php if (!$pk): ?><div class="empty"><?= icon('fa-gift', 'big') ?>No packages purchased.</div><?php else: ?><div class="tw"><table class="rt"><thead><tr><th>Package</th><th>Module</th><th>Starts</th><th>Expires</th><th>Status</th></tr></thead><tbody>
  <?php foreach ($pk as $r): ?><tr><td data-label="Package"><?= e($r['name'] ?? '#' . $r['package_id']) ?></td><td data-label="Module"><?= e(PL_PACKAGE_MODULES[$r['module_key']] ?? $r['module_key']) ?></td><td data-label="Starts"><?= dshort($r['starts_at']) ?></td><td data-label="Expires"><?= dshort($r['expires_at']) ?></td><td data-label="Status"><?= strtotime($r['expires_at']) > time() && $r['status'] === 'active' ? badge('active') : badge('inactive', 'expired') ?></td></tr><?php endforeach; ?>
  </tbody></table></div><?php endif; ?></div>
<dialog id="stDlg"><h3 data-dtitle>Change status</h3>
  <form method="post"><?= pl_csrf_field() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><input type="hidden" name="action" value="status"><input type="hidden" name="value" value="">
    <label>Reason (shown to the user)</label><input name="reason" maxlength="255" placeholder="Optional">
    <small class="muted">Deactivate / suspend logs the user out of all devices.</small>
    <div class="dlg-actions"><button type="button" class="btn btn-line" data-close>Cancel</button><button class="btn btn-primary">Confirm</button></div></form></dialog>
<dialog id="pwDlg"><h3>Set temporary password</h3><small class="muted">Use this only to assist a user who cannot log in. All their devices are logged out.</small>
  <form method="post"><?= pl_csrf_field() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><input type="hidden" name="action" value="password">
    <label>Temporary password (min 8 characters)</label><input name="password" minlength="8" required autocomplete="new-password">
    <div class="dlg-actions"><button type="button" class="btn btn-line" data-close>Cancel</button><button class="btn btn-primary">Set password</button></div></form></dialog>
<?php render_footer(); exit; endif;

$status = (string)($_GET['status'] ?? ''); $q = trim((string)($_GET['q'] ?? '')); $cf = (string)($_GET['cf'] ?? '');
$w = '1=1'; $a = [];
if ($cf !== 'all') { $w .= ' AND u.community_id=?'; $a[] = ctype_digit($cf) ? (int)$cf : $cid; }
if ($q !== '') { $w .= ' AND (u.name LIKE ? OR u.email LIKE ? OR u.phone LIKE ?' . (ctype_digit($q) ? ' OR u.id=?' : '') . ')'; array_push($a, "%$q%", "%$q%", "%$q%"); if (ctype_digit($q)) $a[] = (int)$q; }
$tabs = ['' => ['All', '1=1'], 'active' => ['Active', "COALESCE(u.status,'active')='active'"], 'inactive' => ['Inactive', "u.status='inactive'"], 'suspended' => ['Suspended', "u.status='suspended'"],
    'deactivated' => ['Self-deactivated', "u.status='deactivated'"], 'delete_requests' => ['Delete requests', "u.delete_requested_at IS NOT NULL AND u.status<>'deleted'"], 'deleted' => ['Deleted', "u.status='deleted'"]];
if (!isset($tabs[$status])) $status = '';
$counts = []; foreach ($tabs as $k => [, $sql]) $counts[$k] = scalar("SELECT COUNT(*) FROM users u WHERE $w AND $sql", $a);
$page = max(1, (int)($_GET['page'] ?? 1));
$win = pl_session_window();
$list = rows("SELECT u.*, (SELECT COUNT(*) FROM user_sessions s WHERE s.user_id=u.id AND s.revoked_at IS NULL AND s.last_seen_at > (NOW() - INTERVAL $win SECOND)) devices,
    (SELECT m.status FROM members m WHERE m.user_id=u.id ORDER BY m.id DESC LIMIT 1) member_status FROM users u WHERE $w AND {$tabs[$status][1]} ORDER BY u.id DESC LIMIT 25 OFFSET " . (($page - 1) * 25), $a);
render_header('Users', 'auto', $user, $comm); ?>
<div class="tabs anim"><?php foreach ($tabs as $k => [$l]): ?><a class="<?= $status === $k ? 'on' : '' ?>" href="<?= e(pl_url(['status' => $k, 'q' => $q, 'cf' => $cf], 'users.php')) ?>"><?= $l ?> (<?= (int)$counts[$k] ?>)</a><?php endforeach; ?></div>
<div class="card anim">
  <form class="toolbar" method="get"><input type="hidden" name="status" value="<?= e($status) ?>"><input class="grow" name="q" value="<?= e($q) ?>" placeholder="Search name, email, mobile or user ID"><?= pl_community_select('cf', $cf === '' ? (string)$cid : $cf, true) ?><button class="btn btn-primary"><?= icon('fa-magnifying-glass') ?> Search</button></form>
  <?php if (!$list): ?><div class="empty"><?= icon('fa-users-slash', 'big') ?>No users found.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>User</th><th>Mobile</th><th>Community</th><th>Registered</th><th>Account</th><th>Member profile</th><th>Devices</th><th></th></tr></thead><tbody>
  <?php foreach ($list as $r): ?><tr>
    <td data-label="User"><a class="person" href="users.php?view=<?= (int)$r['id'] ?>"><div class="pi"><?= e(mb_strtoupper(mb_substr($r['name'], 0, 1))) ?></div><div><b><?= e($r['name']) ?></b><br><small><?= e($r['email']) ?><?= $r['role'] === 'admin' ? ' · admin' : '' ?></small></div></a></td>
    <td data-label="Mobile"><?= e($r['phone'] ?: '—') ?> <?= $r['phone_verified'] ? icon('fa-circle-check', 'ok') : '' ?></td>
    <td data-label="Community"><?= e(pl_community_names()[$r['community_id']] ?? '—') ?></td><td data-label="Registered"><?= dshort($r['created_at']) ?></td>
    <td data-label="Account"><?= pl_status_badge($r['status'] ?? 'active') ?></td><td data-label="Member profile"><?= $r['member_status'] ? pl_status_badge($r['member_status']) : '<span class="muted">—</span>' ?></td>
    <td data-label="Devices"><?= (int)$r['devices'] ?>/<?= pl_device_limit() ?></td><td><a class="btn btn-sm btn-line" href="users.php?view=<?= (int)$r['id'] ?>"><?= icon('fa-eye') ?> View</a></td></tr>
  <?php endforeach; ?></tbody></table></div><?= pl_pager($page, (int)ceil($counts[$status] / 25)) ?><?php endif; ?>
</div>
<?php render_footer();
