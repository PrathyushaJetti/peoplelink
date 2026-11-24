<?php
$GLOBALS['ROOT'] = '../';
require_once __DIR__ . '/../includes/auth.php'; require_once __DIR__ . '/../includes/layout.php';
[$user, $comm] = require_login(); $cid = $comm['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); $id = (int)($_POST['id'] ?? 0); $a = $_POST['action'] ?? '';
    $new = $a === 'approve' ? 'approved' : ($a === 'reject' ? 'rejected' : null);
    if ($new && $id) {
        db()->prepare('UPDATE matrimony_photos SET status=? WHERE id=? AND profile_id IN (SELECT id FROM matrimony_profiles WHERE community_id=?)')->execute([$new, $id, $cid]);
        flash('Photo ' . $new);
    }
    back('status=' . urlencode($_POST['back_status'] ?? 'pending'));
}
$status = $_GET['status'] ?? 'pending'; if (!in_array($status, ['pending', 'approved', 'rejected'], true)) $status = 'pending';
$photos = rows('SELECT ph.*, p.full_name, p.profile_code FROM matrimony_photos ph JOIN matrimony_profiles p ON p.id=ph.profile_id WHERE p.community_id=? AND ph.status=? ORDER BY ph.id DESC', [$cid, $status]);
$counts = array_column(rows('SELECT ph.status, COUNT(*) c FROM matrimony_photos ph JOIN matrimony_profiles p ON p.id=ph.profile_id WHERE p.community_id=? GROUP BY ph.status', [$cid]), 'c', 'status');
render_header('Photo Approval', 'Matrimony/Photo Approval', $user, $comm); ?>
<div class="tabs anim"><?php foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $k => $l): ?><a class="<?= $status === $k ? 'on' : '' ?>" href="?status=<?= $k ?>"><?= $l ?> (<?= $counts[$k] ?? 0 ?>)</a><?php endforeach; ?></div>
<?php if (!$photos): ?><div class="card"><div class="empty"><?= icon('fa-circle-check','big') ?>No <?= e($status) ?> photos.</div></div><?php else: ?>
<div class="photos"><?php foreach ($photos as $i => $ph): ?>
  <div class="photo" style="animation-delay:<?= min($i, 8) * .05 ?>s"><div class="im"><img src="<?= e($ph['image_url']) ?>" alt="Profile photo" loading="lazy"></div>
    <div class="pb"><b><?= e($ph['full_name']) ?></b><small><?= e($ph['profile_code']) ?> · <?= dshort($ph['created_at']) ?></small>
    <?php if ($status === 'pending'): ?><div class="actions">
      <?php foreach (['approve' => [icon('fa-check') . ' Approve', 'btn-blue', ''], 'reject' => [icon('fa-xmark') . ' Reject', 'btn-red', 'Reject this photo?']] as $a => [$l, $cls, $conf]): ?>
        <form class="inline" method="post" <?= $conf ? 'data-confirm="' . $conf . '"' : '' ?>><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= (int)$ph['id'] ?>"><input type="hidden" name="action" value="<?= $a ?>"><input type="hidden" name="back_status" value="<?= e($status) ?>"><button class="btn btn-sm <?= $cls ?>"><?= $l ?></button></form><?php endforeach; ?></div>
    <?php else: ?><div class="mt"><?= badge($status) ?></div><?php endif; ?></div></div><?php endforeach; ?></div><?php endif; ?>
<?php render_footer();
