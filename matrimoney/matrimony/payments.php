<?php
$GLOBALS['ROOT'] = '../';
require_once __DIR__ . '/../includes/auth.php'; require_once __DIR__ . '/../includes/layout.php';
[$user, $comm] = require_login(); $cid = $comm['id'];
$status = $_GET['status'] ?? ''; $q = trim($_GET['q'] ?? '');
$where = 'py.community_id=?'; $p = [$cid];
if (in_array($status, ['paid', 'pending', 'failed'], true)) { $where .= ' AND py.status=?'; $p[] = $status; }
if ($q !== '') { $where .= ' AND (pr.full_name LIKE ? OR pr.profile_code LIKE ?)'; array_push($p, "%$q%", "%$q%"); }
$list = rows("SELECT py.*, pr.full_name, pr.profile_code, pk.name pkg FROM matrimony_payments py JOIN matrimony_profiles pr ON pr.id=py.profile_id JOIN matrimony_packages pk ON pk.id=py.package_id WHERE $where ORDER BY py.id DESC", $p);
$rev = scalar("SELECT COALESCE(SUM(amount),0) FROM matrimony_payments WHERE community_id=? AND status='paid'", [$cid]);
$counts = array_column(rows('SELECT status, COUNT(*) c FROM matrimony_payments WHERE community_id=? GROUP BY status', [$cid]), 'c', 'status');
$tabs = ['' => ['All', array_sum($counts)], 'paid' => ['Paid', $counts['paid'] ?? 0], 'pending' => ['Pending', $counts['pending'] ?? 0], 'failed' => ['Failed', $counts['failed'] ?? 0]];
render_header('Payments', 'Matrimony/Payments', $user, $comm); ?>
<div class="stats anim">
  <div class="stat c-blue"><div class="ic"><?= icon('fa-indian-rupee-sign') ?></div><div class="n" data-count="<?= $rev ?>" data-prefix="₹">0</div><div class="l">Total Revenue</div></div>
  <div class="stat c-purple"><div class="ic"><?= icon('fa-circle-check') ?></div><div class="n" data-count="<?= $counts['paid'] ?? 0 ?>">0</div><div class="l">Successful</div></div>
  <div class="stat c-orange"><div class="ic"><?= icon('fa-hourglass-half') ?></div><div class="n" data-count="<?= $counts['pending'] ?? 0 ?>">0</div><div class="l">Pending</div></div>
  <div class="stat c-red"><div class="ic"><?= icon('fa-triangle-exclamation') ?></div><div class="n" data-count="<?= $counts['failed'] ?? 0 ?>">0</div><div class="l">Failed</div></div>
</div>
<div class="tabs anim"><?php foreach ($tabs as $k => [$l, $n]): ?><a class="<?= $status === (string)$k ? 'on' : '' ?>" href="?status=<?= $k ?>&q=<?= urlencode($q) ?>"><?= $l ?> (<?= $n ?>)</a><?php endforeach; ?></div>
<div class="card anim">
  <form class="toolbar" method="get"><input type="hidden" name="status" value="<?= e($status) ?>"><input class="grow" name="q" value="<?= e($q) ?>" placeholder="Search by name or profile ID"><button class="btn btn-primary"><?= icon('fa-magnifying-glass') ?> Search</button></form>
  <?php if (!$list): ?><div class="empty"><?= icon('fa-credit-card','big') ?>No payments found.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>User / Profile ID</th><th>Package</th><th>Amount</th><th>Payment status</th><th>Purchase date</th></tr></thead><tbody>
  <?php foreach ($list as $r): ?><tr>
    <td data-label="User"><div class="person"><div class="pi"><?= e($r['full_name'][0]) ?></div><div><b><?= e($r['full_name']) ?></b><br><small><?= e($r['profile_code']) ?></small></div></div></td>
    <td data-label="Package"><b><?= e($r['pkg']) ?></b></td><td data-label="Amount"><b><?= money($r['amount']) ?></b></td>
    <td data-label="Status"><?= badge($r['status']) ?></td><td data-label="Date"><?= dshort($r['purchased_at']) ?></td></tr>
  <?php endforeach; ?></tbody></table></div><?php endif; ?></div>
<?php render_footer();
