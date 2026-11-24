<?php
// Jobs reports: applications by status, jobs by category, top jobs, monthly activity, Global Job Package sales.
// Scope: this community's jobs + global jobs (cf=all: every community).
require __DIR__ . '/_boot.php';
$all = ($_GET['cf'] ?? '') === 'all';
$jw = $all ? '1=1' : "(j.community_id=? OR j.visibility_type='global')"; $ja = $all ? [] : [$cid];
$tw = $all ? "module_key='jobs'" : "module_key='jobs' AND community_id=?"; $ta = $all ? [] : [$cid];

$byStatus = array_column(rows("SELECT a.status, COUNT(*) n FROM jobs_applications a JOIN jobs j ON j.id=a.job_id WHERE $jw GROUP BY a.status", $ja), 'n', 'status');
$byCat = [];
foreach (rows("SELECT j.category_id, COUNT(*) n FROM jobs j WHERE $jw GROUP BY j.category_id ORDER BY n DESC", $ja) as $r) $byCat[pl_cat_names()[$r['category_id']] ?? 'Uncategorised'] = (int)$r['n'];
$top = rows("SELECT j.*, COUNT(a.id) apps, SUM(a.status='shortlisted') shortlisted FROM jobs j LEFT JOIN jobs_applications a ON a.job_id=j.id WHERE $jw GROUP BY j.id ORDER BY apps DESC, j.views DESC LIMIT 10", $ja);
$months = [];
for ($i = 5; $i >= 0; $i--) $months[date('Y-m', strtotime("first day of -$i month"))] = ['jobs' => 0, 'apps' => 0];
$since = array_key_first($months) . '-01';
foreach (rows("SELECT DATE_FORMAT(j.created_at,'%Y-%m') ym, COUNT(*) n FROM jobs j WHERE $jw AND j.created_at >= ? GROUP BY ym", array_merge($ja, [$since])) as $r) if (isset($months[$r['ym']])) $months[$r['ym']]['jobs'] = (int)$r['n'];
foreach (rows("SELECT DATE_FORMAT(a.created_at,'%Y-%m') ym, COUNT(*) n FROM jobs_applications a JOIN jobs j ON j.id=a.job_id WHERE $jw AND a.created_at >= ? GROUP BY ym", array_merge($ja, [$since])) as $r) if (isset($months[$r['ym']])) $months[$r['ym']]['apps'] = (int)$r['n'];
$sales = rows("SELECT package_name, COUNT(*) n, SUM(amount) s FROM transactions WHERE $tw AND status='paid' GROUP BY package_name ORDER BY s DESC", $ta);
$revenue = array_sum(array_column($sales, 's'));
$smax = max(1, $byStatus ? max($byStatus) : 1); $cmax = max(1, $byCat ? max($byCat) : 1);

render_header('Jobs Reports', 'auto', $user, $comm); ?>
<div class="tabs anim"><a class="<?= $all ? '' : 'on' ?>" href="jobs-reports.php"><?= e($comm['name']) ?> + global jobs</a><a class="<?= $all ? 'on' : '' ?>" href="jobs-reports.php?cf=all">All communities</a></div>
<?= pl_stat_cards([
    ['Applications', array_sum($byStatus), 'fa-inbox'],
    ['Shortlisted', (int)($byStatus['shortlisted'] ?? 0), 'fa-user-check'],
    ['Packages sold', array_sum(array_column($sales, 'n')), 'fa-gift'],
    ['Package revenue', [$revenue, '₹'], 'fa-indian-rupee-sign'],
]) ?>
<div class="grid2 anim">
  <div class="card"><div class="card-h"><h3>Applications by status</h3><a class="btn btn-line btn-sm" href="manage.php?e=job_application<?= $all ? '&cf=all' : '' ?>">Open <?= icon('fa-arrow-right') ?></a></div>
    <?php foreach (PL_JOB_APP_STATUSES as $s): $n = (int)($byStatus[$s] ?? 0); ?>
      <div class="hrow"><span><?= e(pl_status_label($s)) ?></span><div class="hb"><i style="width:<?= max(4, $n / $smax * 100) ?>%"></i></div><b><?= $n ?></b></div><?php endforeach; ?></div>
  <div class="card"><div class="card-h"><h3>Jobs by category</h3><a class="btn btn-line btn-sm" href="categories.php?m=jobs">Categories <?= icon('fa-arrow-right') ?></a></div>
    <?php if (!$byCat): ?><div class="empty"><?= icon('fa-chart-simple', 'big') ?>No jobs yet.</div><?php else: foreach ($byCat as $l => $n): ?>
      <div class="hrow"><span><?= e($l) ?></span><div class="hb"><i style="width:<?= max(4, $n / $cmax * 100) ?>%"></i></div><b><?= $n ?></b></div><?php endforeach; endif; ?></div>
</div>
<div class="card anim"><div class="card-h"><h3>Top jobs by applications</h3></div>
  <?php if (!$top): ?><div class="empty"><?= icon('fa-briefcase', 'big') ?>No jobs yet.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Job</th><th>Visibility</th><th>Status</th><th>Views</th><th>Applications</th><th>Shortlisted</th><th>Closing</th></tr></thead><tbody>
  <?php foreach ($top as $r): ?><tr><td data-label="Job"><a class="lnk" href="manage.php?e=job&view=<?= (int)$r['id'] ?>"><b><?= e($r['job_title']) ?></b></a><br><small><?= e($r['company_name']) ?></small></td>
    <td data-label="Visibility"><?= $r['visibility_type'] === 'global' ? badge('active', 'Global') : e(pl_community_names()[$r['community_id']] ?? 'Community') ?></td>
    <td data-label="Status"><?= pl_status_badge((string)$r['status']) ?></td><td data-label="Views"><?= (int)$r['views'] ?></td>
    <td data-label="Applications"><a class="lnk" href="manage.php?e=job_application&parent=<?= (int)$r['id'] ?>&cf=all"><?= (int)$r['apps'] ?></a></td><td data-label="Shortlisted"><?= (int)$r['shortlisted'] ?></td>
    <td data-label="Closing"><?= $r['closing_date'] ? dshort($r['closing_date']) : '<span class="muted">—</span>' ?></td></tr><?php endforeach; ?>
  </tbody></table></div><?php endif; ?></div>
<div class="grid2 anim">
  <div class="card"><div class="card-h"><h3>Last 6 months</h3></div>
    <div class="tw"><table class="rt"><thead><tr><th>Month</th><th>Jobs posted</th><th>Applications</th></tr></thead><tbody>
    <?php foreach ($months as $k => $v): ?><tr><td data-label="Month"><?= e(date('M Y', strtotime($k . '-01'))) ?></td><td data-label="Jobs posted"><?= $v['jobs'] ?></td><td data-label="Applications"><?= $v['apps'] ?></td></tr><?php endforeach; ?>
    </tbody></table></div></div>
  <div class="card"><div class="card-h"><h3>Global Job Package sales</h3><a class="btn btn-line btn-sm" href="transactions.php?module=jobs<?= $all ? '&cf=all' : '' ?>">Payments <?= icon('fa-arrow-right') ?></a></div>
    <?php if (!$sales): ?><div class="empty"><?= icon('fa-gift', 'big') ?>No packages sold yet.</div><?php else: ?>
    <div class="tw"><table class="rt"><thead><tr><th>Package</th><th>Sold</th><th>Revenue</th></tr></thead><tbody>
    <?php foreach ($sales as $s): ?><tr><td data-label="Package"><?= e($s['package_name']) ?></td><td data-label="Sold"><?= (int)$s['n'] ?></td><td data-label="Revenue"><b><?= money($s['s']) ?></b></td></tr><?php endforeach; ?>
    </tbody></table></div><?php endif; ?></div>
</div>
<?php render_footer();
