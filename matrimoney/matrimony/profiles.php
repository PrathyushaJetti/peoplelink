<?php
$GLOBALS['ROOT'] = '../';
require_once __DIR__ . '/../includes/auth.php'; require_once __DIR__ . '/../includes/layout.php';
[$user, $comm] = require_login(); $cid = $comm['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); $id = (int)($_POST['id'] ?? 0); $act = $_POST['action'] ?? '';
    $own = scalar('SELECT COUNT(*) FROM matrimony_profiles WHERE id=? AND community_id=?', [$id, $cid]);
    if ($own) {
        if ($act === 'edit') {
            $n = trim($_POST['full_name'] ?? '');
            if ($n === '') flash('Name is required.', 'error');
            else { db()->prepare('UPDATE matrimony_profiles SET full_name=?,age=?,education=?,profession=?,city=? WHERE id=?')
                ->execute([$n, (int)$_POST['age'], trim($_POST['education']), trim($_POST['profession']), trim($_POST['city']), $id]); flash('Profile details saved'); }
        } elseif (in_array($act, ['approve', 'reject', 'activate', 'deactivate'], true)) {
            $set = ['approve' => "status='approved'", 'reject' => "status='rejected'", 'activate' => 'is_active=1', 'deactivate' => 'is_active=0'][$act];
            db()->prepare("UPDATE matrimony_profiles SET $set WHERE id=?")->execute([$id]);
            if ($act === 'approve' || $act === 'reject') {
                $nm = rows('SELECT full_name FROM matrimony_profiles WHERE id=?', [$id])[0]['full_name'];
                notify($cid, $act === 'approve' ? 'Profile approved' : 'Profile needs changes', $nm . ($act === 'approve' ? ' — your matrimony profile is now live.' : ' — your matrimony profile was not approved. Please update and resubmit.'), 'approval', 'profile:' . $id);
            }
            flash('Profile ' . ['approve'=>'approved','reject'=>'rejected','activate'=>'activated','deactivate'=>'deactivated'][$act]);
        }
    }
    back(http_build_query(['status' => $_POST['back_status'] ?? '', 'q' => $_POST['back_q'] ?? '']));
}

$status = $_GET['status'] ?? ''; $q = trim($_GET['q'] ?? '');
$where = 'community_id = ?'; $p = [$cid];
if (in_array($status, ['pending', 'approved', 'rejected'], true)) { $where .= ' AND status = ?'; $p[] = $status; }
if ($q !== '') { $where .= ' AND (full_name LIKE ? OR profile_code LIKE ? OR city LIKE ?)'; array_push($p, "%$q%", "%$q%", "%$q%"); }
$list = rows("SELECT * FROM matrimony_profiles WHERE $where ORDER BY id DESC", $p);
$counts = array_column(rows('SELECT status, COUNT(*) c FROM matrimony_profiles WHERE community_id=? GROUP BY status', [$cid]), 'c', 'status');
$tabs = ['' => ['All', array_sum($counts)], 'pending' => ['Pending', $counts['pending'] ?? 0], 'approved' => ['Approved', $counts['approved'] ?? 0], 'rejected' => ['Rejected', $counts['rejected'] ?? 0]];
function pform(array $r, string $a, string $label, string $cls, string $conf, string $st, string $q): string {
    return '<form class="inline" method="post"' . ($conf ? ' data-confirm="' . e($conf) . '"' : '') . '><input type="hidden" name="csrf" value="' . csrf_token() . '"><input type="hidden" name="id" value="' . (int)$r['id'] . '"><input type="hidden" name="action" value="' . $a . '"><input type="hidden" name="back_status" value="' . e($st) . '"><input type="hidden" name="back_q" value="' . e($q) . '"><button class="btn btn-sm ' . $cls . '">' . $label . '</button></form>';
}
render_header('Profile Management', 'Matrimony/Profiles', $user, $comm); ?>
<div class="tabs anim"><?php foreach ($tabs as $k => [$label, $n]): ?><a class="<?= $status === (string)$k ? 'on' : '' ?>" href="?status=<?= $k ?>&q=<?= urlencode($q) ?>"><?= $label ?> (<?= $n ?>)</a><?php endforeach; ?></div>
<div class="card anim">
  <form class="toolbar" method="get"><input type="hidden" name="status" value="<?= e($status) ?>"><input class="grow" name="q" value="<?= e($q) ?>" placeholder="Search by name, profile ID or city"><button class="btn btn-primary"><?= icon('fa-magnifying-glass') ?> Search</button></form>
  <?php if (!$list): ?><div class="empty"><?= icon('fa-magnifying-glass','big') ?>No profiles found.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Profile</th><th>Age / Gender</th><th>Education & Work</th><th>City</th><th>Status</th><th>Visibility</th><th>Actions</th></tr></thead><tbody>
  <?php foreach ($list as $r): $fill = e(json_encode(['id' => $r['id'], 'full_name' => $r['full_name'], 'age' => $r['age'], 'education' => $r['education'], 'profession' => $r['profession'], 'city' => $r['city']])); ?><tr>
    <td data-label="Profile"><div class="person"><?php $ph = rows('SELECT image_url, status FROM matrimony_photos WHERE profile_id=? ORDER BY is_primary DESC, id LIMIT 1', [(int)$r['id']])[0] ?? null; $phUrl = $ph ? (preg_match('#^(https?:)?//|^/#', $ph['image_url']) ? $ph['image_url'] : FRONTEND_URL . ltrim($ph['image_url'], '/')) : null; ?><div class="pi" style="position:relative;overflow:hidden"><?= e($r['full_name'][0]) ?><?php if ($phUrl): ?><img src="<?= e($phUrl) ?>" alt="" title="Photo <?= e($ph['status']) ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center top" onerror="this.remove()"><?php endif; ?></div><div><b><?= e($r['full_name']) ?></b><br><small><?= e($r['profile_code']) ?></small></div></div></td>
    <td data-label="Age / Gender"><?= e($r['age']) ?> · <?= e($r['gender']) ?></td>
    <td data-label="Education & Work"><?= e($r['education']) ?><br><small><?= e($r['profession']) ?></small></td><td data-label="City"><?= e($r['city']) ?></td>
    <td data-label="Status"><?= badge($r['status']) ?></td><td data-label="Visibility"><?= badge($r['is_active'] ? 'active' : 'inactive') ?></td>
    <td data-label="Actions"><div class="actions">
      <?php if ($r['status'] !== 'approved') echo pform($r, 'approve', icon('fa-check') . ' Approve', 'btn-blue', '', $status, $q);
            if ($r['status'] !== 'rejected') echo pform($r, 'reject', icon('fa-xmark') . ' Reject', 'btn-red', 'Reject this profile?', $status, $q);
            echo $r['is_active'] ? pform($r, 'deactivate', 'Deactivate', 'btn-orange', 'Deactivate this profile?', $status, $q) : pform($r, 'activate', 'Activate', 'btn-line', '', $status, $q); ?>
      <button type="button" class="btn btn-sm btn-line" data-open="editDlg" data-fill="<?= $fill ?>"><?= icon('fa-pen') ?> Edit</button></div></td></tr>
  <?php endforeach; ?></tbody></table></div><?php endif; ?>
</div>
<dialog id="editDlg"><h3>Edit basic details</h3><small class="muted">Update the profile information.</small>
  <form method="post"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="action" value="edit"><input type="hidden" name="id" data-keep>
    <input type="hidden" name="back_status" value="<?= e($status) ?>"><input type="hidden" name="back_q" value="<?= e($q) ?>">
    <label>Full name</label><input name="full_name" required>
    <div class="row2"><div><label>Age</label><input type="number" name="age" min="18" max="80"></div><div><label>City</label><input name="city"></div></div>
    <div class="row2"><div><label>Education</label><input name="education"></div><div><label>Profession</label><input name="profession"></div></div>
    <div class="dlg-actions"><button type="button" class="btn btn-line" data-close>Cancel</button><button class="btn btn-primary">Save changes</button></div></form></dialog>
<?php render_footer();
