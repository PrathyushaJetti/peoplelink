<?php
$GLOBALS['ROOT'] = '';
require_once __DIR__ . '/includes/auth.php'; require_once __DIR__ . '/includes/layout.php';
[$user, $comm] = require_login(); $cid = $comm['id'];

$total    = scalar('SELECT COUNT(*) FROM matrimony_profiles WHERE community_id=?', [$cid]);
$pending  = scalar("SELECT COUNT(*) FROM matrimony_profiles WHERE community_id=? AND status='pending'", [$cid]);
$approved = scalar("SELECT COUNT(*) FROM matrimony_profiles WHERE community_id=? AND status='approved'", [$cid]);
$rejected = scalar("SELECT COUNT(*) FROM matrimony_profiles WHERE community_id=? AND status='rejected'", [$cid]);
$pkgs     = scalar('SELECT COUNT(*) FROM matrimony_packages WHERE community_id=? AND is_active=1', [$cid]);
$revenue  = scalar("SELECT COALESCE(SUM(amount),0) FROM matrimony_payments WHERE community_id=? AND status='paid'", [$cid]);

$months = []; for ($i = 5; $i >= 0; $i--) $months[date('Y-m', strtotime("first day of -$i month"))] = 0;
foreach (rows('SELECT created_at FROM matrimony_profiles WHERE community_id=?', [$cid]) as $r) { $k = substr($r['created_at'], 0, 7); if (isset($months[$k])) $months[$k]++; }
$max = max(1, max($months));
$recent = rows('SELECT p.*, (SELECT image_url FROM matrimony_photos WHERE profile_id = p.id AND is_primary = 1 LIMIT 1) as photo_url FROM matrimony_profiles p WHERE p.community_id=? ORDER BY p.id DESC LIMIT 6', [$cid]);
$pc = $total ? round($pending / $total * 100) : 0; $ac = $total ? round($approved / $total * 100) : 0;
$donut = "conic-gradient(var(--orange) 0 {$pc}%, var(--blue) {$pc}% " . ($pc + $ac) . "%, var(--red) " . ($pc + $ac) . "% 100%)";
if (!$total) $donut = '#eceef5';

render_header('Matrimony Dashboard', 'Matrimony/Matrimony Dashboard', $user, $comm); ?>
<div class="stats anim">
  <div class="stat c-blue"><div class="ic"><?= icon('fa-users') ?></div><div class="n" data-count="<?= $total ?>">0</div><div class="l">Total Profiles</div></div>
  <div class="stat c-orange"><div class="ic"><?= icon('fa-hourglass-half') ?></div><div class="n" data-count="<?= $pending ?>">0</div><div class="l">Pending Profiles</div></div>
  <div class="stat c-purple"><div class="ic"><?= icon('fa-circle-check') ?></div><div class="n" data-count="<?= $approved ?>">0</div><div class="l">Approved Profiles</div></div>
  <div class="stat c-red"><div class="ic"><?= icon('fa-gift') ?></div><div class="n" data-count="<?= $pkgs ?>">0</div><div class="l">Active Packages</div></div>
</div>
<div class="grid2 anim">
  <div class="card"><div class="card-h"><h3>New profiles — last 6 months</h3><span class="badge b-active">Revenue <?= money($revenue) ?></span></div>
    <div class="bars"><?php foreach ($months as $k => $n): ?>
      <div class="bar"><b><?= $n ?></b><i style="height:<?= max(3, $n / $max * 100) ?>%"></i><?= date('M', strtotime($k . '-01')) ?></div><?php endforeach; ?></div></div>
  <div class="card"><div class="card-h"><h3>Profile status</h3></div>
    <div class="donut" style="background:<?= $donut ?>"><div><span><?= $total ?><small>profiles</small></span></div></div>
    <div class="legend"><span><i style="background:var(--orange)"></i>Pending<b><?= $pending ?></b></span><span><i style="background:var(--blue)"></i>Approved<b><?= $approved ?></b></span><span><i style="background:var(--red)"></i>Rejected<b><?= $rejected ?></b></span></div></div>
</div>
<div class="card anim"><div class="card-h"><h3>Recent profiles</h3><a class="btn btn-line btn-sm" href="matrimony/profiles.php">View all <?= icon('fa-arrow-right') ?></a></div>
  <?php if (!$recent): ?><div class="empty"><?= icon('fa-users-slash','big') ?>No profiles yet for this community.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Profile</th><th>Age</th><th>City</th><th>Joined</th><th>Status</th></tr></thead><tbody>
  <?php foreach ($recent as $r): ?><tr>
    <td data-label="Profile">
      <div class="person" style="display:flex;align-items:center;gap:10px;">
        <?php if (!empty($r['photo_url'])): ?>
          <img src="<?= e($r['photo_url']) ?>" alt="" style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
        <?php else: ?>
          <div class="pi"><?= e($r['full_name'][0]) ?></div>
        <?php endif; ?>
        <div><b><?= e($r['full_name']) ?></b><br><small><?= e($r['profile_code']) ?></small></div>
      </div>
    </td>
    <td data-label="Age"><?= e($r['age']) ?></td><td data-label="City"><?= e($r['city']) ?></td><td data-label="Joined"><?= dshort($r['created_at']) ?></td><td data-label="Status"><?= badge($r['status']) ?></td></tr>
  <?php endforeach; ?></tbody></table></div><?php endif; ?></div>
<?php render_footer(); ?>