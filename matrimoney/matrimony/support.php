<?php
$GLOBALS['ROOT'] = '../';
require_once __DIR__ . '/../includes/bridge.php'; require_once __DIR__ . '/../includes/layout.php';
[$user, $comm] = require_login(); $cid = $comm['id'];
pl_ensure_schema();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); $id = (int)($_POST['id'] ?? 0); $act = $_POST['action'] ?? '';
    $new = ['resolve' => 'resolved', 'close' => 'closed', 'reopen' => 'open'][$act] ?? null;
    if ($new && $id) {
        db()->prepare('UPDATE matrimony_support SET status=? WHERE id=? AND (community_id=? OR community_id IS NULL)')->execute([$new, $id, $cid]);
        flash('Request ' . ($new === 'open' ? 'reopened' : $new));
    }
    back('status=' . urlencode($_POST['back_status'] ?? ''));
}

$status = $_GET['status'] ?? 'open';
$where = '(s.community_id=? OR s.community_id IS NULL)'; $p = [$cid];
if (in_array($status, ['open', 'resolved', 'closed'], true)) { $where .= ' AND s.status=?'; $p[] = $status; } else $status = '';
$list = rows("SELECT s.*, u.name uname FROM matrimony_support s LEFT JOIN users u ON u.id=s.user_id WHERE $where ORDER BY s.id DESC", $p);
$counts = array_column(rows('SELECT status, COUNT(*) c FROM matrimony_support WHERE community_id=? OR community_id IS NULL GROUP BY status', [$cid]), 'c', 'status');
$tabs = ['open' => 'Open', 'resolved' => 'Resolved', 'closed' => 'Closed', '' => 'All'];
render_header('Support Requests', 'Matrimony/Support Requests', $user, $comm); ?>
<div class="tabs anim"><?php foreach ($tabs as $k => $l): ?><a class="<?= $status === (string)$k ? 'on' : '' ?>" href="?status=<?= $k ?>"><?= $l ?> (<?= $k === '' ? array_sum($counts) : ($counts[$k] ?? 0) ?>)</a><?php endforeach; ?></div>
<div class="card anim">
  <?php if (!$list): ?><div class="empty"><?= icon('fa-headset', 'big') ?>No support requests here.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Request</th><th>Type</th><th>Contact</th><th>Needed by</th><th>Date</th><th>Status</th><th>Action</th></tr></thead><tbody>
  <?php foreach ($list as $r): ?><tr>
    <td data-label="Request"><b><?= e($r['title']) ?></b><br><small><?= e(mb_strimwidth((string)$r['description'], 0, 110, '…')) ?></small></td>
    <td data-label="Type"><?= e($r['category']) ?><br><small><?= e($r['assistance_type']) ?></small></td>
    <td data-label="Contact"><?= e($r['contact_name'] ?: $r['uname']) ?><br><small><?= e($r['phone']) ?> <?= e($r['email']) ?></small></td>
    <td data-label="Needed by"><?= $r['required_by'] ? dshort($r['required_by']) : '—' ?></td>
    <td data-label="Date"><?= dshort($r['created_at']) ?></td>
    <td data-label="Status"><?= $r['status'] === 'resolved' ? badge('approved', 'resolved') : badge($r['status']) ?></td>
    <td data-label="Action"><div class="actions">
      <?php foreach ($r['status'] === 'open' ? [['resolve', 'Resolve', 'btn-blue'], ['close', 'Close', 'btn-line']] : [['reopen', 'Reopen', 'btn-orange']] as [$a, $l, $c]): ?>
        <form class="inline" method="post"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><input type="hidden" name="action" value="<?= $a ?>"><input type="hidden" name="back_status" value="<?= e($status) ?>"><button class="btn btn-sm <?= $c ?>"><?= $l ?></button></form>
      <?php endforeach; ?></div></td></tr>
  <?php endforeach; ?></tbody></table></div><?php endif; ?></div>
<?php render_footer();
