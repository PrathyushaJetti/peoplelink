<?php
$GLOBALS['ROOT'] = '../';
require_once __DIR__ . '/../includes/auth.php'; require_once __DIR__ . '/../includes/layout.php';
[$user, $comm] = require_login(); $cid = $comm['id'];
$total = scalar('SELECT COUNT(*) FROM matrimony_profiles WHERE community_id=?', [$cid]);
$new30 = 0; $cut = strtotime('-30 days'); foreach (rows('SELECT created_at FROM matrimony_profiles WHERE community_id=?', [$cid]) as $r) if (strtotime($r['created_at']) >= $cut) $new30++;
$sales = scalar("SELECT COUNT(*) FROM matrimony_payments WHERE community_id=? AND status='paid'", [$cid]);
$rev = scalar("SELECT COALESCE(SUM(amount),0) FROM matrimony_payments WHERE community_id=? AND status='paid'", [$cid]);
$pkgSales = rows("SELECT pk.name, COUNT(py.id) c, COALESCE(SUM(py.amount),0) amt FROM matrimony_packages pk LEFT JOIN matrimony_payments py ON py.package_id=pk.id AND py.status='paid' WHERE pk.community_id=? GROUP BY pk.id, pk.name ORDER BY amt DESC", [$cid]);
$byComm = rows('SELECT c.name, COUNT(p.id) n FROM communities c LEFT JOIN matrimony_profiles p ON p.community_id=c.id WHERE c.is_active=1 GROUP BY c.id, c.name ORDER BY n DESC');
$maxP = max(1, ...array_map(fn($x) => (int)$x['amt'], $pkgSales ?: [['amt' => 1]])); $maxC = max(1, ...array_map(fn($x) => (int)$x['n'], $byComm ?: [['n' => 1]]));
render_header('Reports', 'Matrimony/Reports', $user, $comm); ?>
<div class="stats anim">
  <div class="stat c-blue"><div class="ic"><?= icon('fa-users') ?></div><div class="n" data-count="<?= $total ?>">0</div><div class="l">Total profiles</div></div>
  <div class="stat c-purple"><div class="ic"><?= icon('fa-wand-magic-sparkles') ?></div><div class="n" data-count="<?= $new30 ?>">0</div><div class="l">New in last 30 days</div></div>
  <div class="stat c-orange"><div class="ic"><?= icon('fa-cart-shopping') ?></div><div class="n" data-count="<?= $sales ?>">0</div><div class="l">Packages sold</div></div>
  <div class="stat c-red"><div class="ic"><?= icon('fa-indian-rupee-sign') ?></div><div class="n" data-count="<?= $rev ?>" data-prefix="₹">0</div><div class="l">Package revenue</div></div>
</div>
<div class="grid2 even anim">
  <div class="card"><div class="card-h"><h3>Package sales — <?= e($comm['name']) ?></h3></div>
    <?php if (!$pkgSales): ?><div class="empty">No packages yet.</div><?php endif; foreach ($pkgSales as $s): ?>
      <div class="hbar"><div class="t"><b><?= e($s['name']) ?></b><span><?= (int)$s['c'] ?> sold · <?= money($s['amt']) ?></span></div><div class="tr"><i style="width:<?= max(2, $s['amt'] / $maxP * 100) ?>%"></i></div></div><?php endforeach; ?></div>
  <div class="card"><div class="card-h"><h3>Community-wise profiles</h3></div>
    <?php foreach ($byComm as $c): ?><div class="hbar"><div class="t"><b><?= icon('fa-people-group') ?> <?= e($c['name']) ?></b><span><?= (int)$c['n'] ?> profiles</span></div><div class="tr"><i style="width:<?= max(2, $c['n'] / $maxC * 100) ?>%"></i></div></div><?php endforeach; ?></div>
</div>
<?php render_footer();
