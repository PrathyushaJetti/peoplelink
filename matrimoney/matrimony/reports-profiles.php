<?php
$GLOBALS['ROOT'] = '../';
require_once __DIR__ . '/../includes/auth.php'; require_once __DIR__ . '/../includes/layout.php';
[$user, $comm] = require_login(); $cid = $comm['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); $id = (int)($_POST['id'] ?? 0); $act = $_POST['action'] ?? '';
    $rep = rows('SELECT * FROM matrimony_reports WHERE id=? AND community_id=?', [$id, $cid])[0] ?? null;
    if ($rep && in_array($act, ['warn', 'deactivate', 'close'], true)) {
        $new = ['warn' => 'warned', 'deactivate' => 'deactivated', 'close' => 'closed'][$act];
        db()->prepare('UPDATE matrimony_reports SET status=? WHERE id=?')->execute([$new, $id]);
        if ($act === 'deactivate') db()->prepare('UPDATE matrimony_profiles SET is_active=0 WHERE id=? AND community_id=?')->execute([$rep['reported_profile_id'], $cid]);
        if ($act === 'warn') {
            // a real unread alert for the member (shows on the Alerts badge); old-style notice only if the profile has no user
            require_once __DIR__ . '/../includes/bridge.php';
            $wUid = (int)scalar('SELECT user_id FROM matrimony_profiles WHERE id=?', [$rep['reported_profile_id']]);
            if ($wUid && function_exists('pl_notify_user'))
                pl_notify_user($wUid, $cid, 'Warning from admin', 'Your matrimony profile was reported. Please follow the community guidelines, or your profile may be deactivated.', 'matrimony', 'matrimony_warning', null);
            else notify($cid, 'Warning from admin', 'Your profile was reported. Please follow the community guidelines.', 'warning', 'profile:' . $rep['reported_profile_id']);
        }
        flash('Report ' . $new);
    }
    back('status=' . urlencode($_POST['back_status'] ?? ''));
}
$status = $_GET['status'] ?? 'open';
$where = 'rp.community_id=?'; $p = [$cid];
if (in_array($status, ['open', 'warned', 'deactivated', 'closed'], true)) { $where .= ' AND rp.status=?'; $p[] = $status; } else $status = '';
$list = rows("SELECT rp.*, pr.full_name, pr.profile_code, pr.is_active FROM matrimony_reports rp JOIN matrimony_profiles pr ON pr.id=rp.reported_profile_id WHERE $where ORDER BY rp.id DESC", $p);
$counts = array_column(rows('SELECT status, COUNT(*) c FROM matrimony_reports WHERE community_id=? GROUP BY status', [$cid]), 'c', 'status');
$tabs = ['open' => 'Open', 'warned' => 'Warned', 'deactivated' => 'Deactivated', 'closed' => 'Closed', '' => 'All'];
render_header('Reported Profiles', 'Matrimony/Reported Profiles', $user, $comm); ?>
<div class="tabs anim"><?php foreach ($tabs as $k => $l): ?><a class="<?= $status === (string)$k ? 'on' : '' ?>" href="?status=<?= $k ?>"><?= $l ?> (<?= $k === '' ? array_sum($counts) : ($counts[$k] ?? 0) ?>)</a><?php endforeach; ?></div>
<div class="card anim">
  <?php if (!$list): ?><div class="empty"><?= icon('fa-shield-halved','big') ?>No reports here. All clear!</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Reported profile</th><th>Reported by</th><th>Reason</th><th>Date</th><th>Status</th><th>Action</th></tr></thead><tbody>
  <?php foreach ($list as $r): ?><tr>
    <td data-label="Profile"><div class="person"><div class="pi alt-pi"><?= e($r['full_name'][0]) ?></div><div><b><?= e($r['full_name']) ?></b><br><small><?= e($r['profile_code']) ?><?= $r['is_active'] ? '' : ' · inactive' ?></small></div></div></td>
    <td data-label="Reported by"><?= e($r['reporter_name']) ?></td><td data-label="Reason"><?= e($r['reason']) ?></td><td data-label="Date"><?= dshort($r['created_at']) ?></td><td data-label="Status"><?= badge($r['status']) ?></td>
    <td data-label="Action"><div class="actions"><?php if (in_array($r['status'], ['open', 'warned'], true)):
      foreach ([['warn', icon('fa-triangle-exclamation') . ' Warn', 'btn-orange', ''], ['deactivate', 'Deactivate', 'btn-red', 'Deactivate this profile?'], ['close', 'Close', 'btn-line', '']] as [$a, $l, $c, $cf]):
        if ($a === 'warn' && $r['status'] === 'warned') continue; ?>
        <form class="inline" method="post" <?= $cf ? 'data-confirm="' . $cf . '"' : '' ?>><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><input type="hidden" name="action" value="<?= $a ?>"><input type="hidden" name="back_status" value="<?= e($status) ?>"><button class="btn btn-sm <?= $c ?>"><?= $l ?></button></form>
      <?php endforeach; else: ?><small>No action needed</small><?php endif; ?></div></td></tr>
  <?php endforeach; ?></tbody></table></div><?php endif; ?></div>
<?php render_footer();
