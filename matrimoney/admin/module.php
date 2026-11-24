<?php
// Module dashboards: module.php?m=marketplace | members | family_tree | directory | events | support
require __DIR__ . '/_boot.php';

$DASH = [
    'marketplace' => ['Marketplace Dashboard', 'mp_listing', [
        ['Total Listings', 'mp_listing', '1=1', 'fa-store'],
        ['Pending Listings', 'mp_listing', "t.status='pending'", 'fa-hourglass-half'],
        ['Approved & Active', 'mp_listing', "t.status='approved' AND t.is_active=1 AND (t.expires_at IS NULL OR t.expires_at>=NOW())", 'fa-circle-check'],
        ['Rejected', 'mp_listing', "t.status='rejected'", 'fa-ban'],
        ['Expired / Closed', 'mp_listing', "(t.status='closed' OR t.expires_at<NOW())", 'fa-box-archive'],
        ['Featured', 'mp_listing', 't.is_featured=1', 'fa-star'],
    ]],
    'members' => ['Members & Family Dashboard', 'member', [
        ['Total Members', 'member', '1=1', 'fa-users'],
        ['Active Members', 'member', "t.status='approved' AND t.is_active=1", 'fa-user-check'],
        ['Pending Members', 'member', "t.status='pending'", 'fa-hourglass-half'],
        ['Families Registered', 'family', '1=1', 'fa-people-roof'],
        ['Pending Approvals', 'family_member', "t.status='pending'", 'fa-user-clock'],
    ]],
    'family_tree' => ['Family Tree Dashboard', 'family_tree', [
        ['Family Trees', 'family_tree', '1=1', 'fa-sitemap'],
        ['Pending Trees', 'family_tree', "t.tree_status='pending'", 'fa-hourglass-half'],
        ['Relationships', 'tree_relation', '1=1', 'fa-diagram-project'],
        ['Pending Relation Updates', 'tree_relation', "t.status='pending'", 'fa-code-pull-request'],
    ]],
    'directory' => ['Directory Dashboard', 'directory', [
        ['Total Professionals', 'directory', "t.profile_type='Professional'", 'fa-user-doctor'],
        ['Total Businesses', 'directory', "t.profile_type='Business'", 'fa-building'],
        ['Pending Profiles', 'directory', "t.status='pending'", 'fa-hourglass-half'],
        ['Approved Profiles', 'directory', "t.status='approved'", 'fa-circle-check'],
        ['Active Profiles', 'directory', "t.status='approved' AND t.is_active=1", 'fa-toggle-on'],
    ]],
    'events' => ['Events & Advertisements Dashboard', 'event', [
        ['Total Events', 'event', '1=1', 'fa-calendar-days'],
        ['Upcoming Events', 'event', "t.event_date>=CURDATE() AND t.status='approved'", 'fa-calendar-check'],
        ['Completed Events', 'event', 't.event_date<CURDATE()', 'fa-flag-checkered'],
        ['Pending Events', 'event', "t.status='pending'", 'fa-hourglass-half'],
        ['Total Advertisements', 'ad', '1=1', 'fa-rectangle-ad'],
        ['Active Ads', 'ad', "t.status='approved' AND t.is_active=1 AND (t.end_date IS NULL OR t.end_date>=CURDATE())", 'fa-bullhorn'],
        ['Pending Ads', 'ad', "t.status='pending'", 'fa-clock'],
    ]],
    'support' => ['Community Support Dashboard', 'support', [
        ['Total Requests', 'support', '1=1', 'fa-hand-holding-heart'],
        ['Pending', 'support', "t.status='pending'", 'fa-hourglass-half'],
        ['Approved', 'support', "t.status='approved'", 'fa-circle-check'],
        ['In Progress', 'support', "t.status='in_progress'", 'fa-spinner'],
        ['Resolved', 'support', "t.status='resolved'", 'fa-check-double'],
        ['Rejected', 'support', "t.status='rejected'", 'fa-ban'],
    ]],
    'jobs' => ['Jobs Dashboard', 'job', [
        ['Total Jobs', 'job', '1=1', 'fa-briefcase'],
        ['Active Jobs', 'job', "t.status='approved' AND t.is_active=1 AND (t.closing_date IS NULL OR t.closing_date>=CURDATE())", 'fa-circle-check'],
        ['Community Jobs', 'job', "t.visibility_type='community'", 'fa-people-group'],
        ['Global Jobs', 'job', "t.visibility_type='global'", 'fa-globe'],
        ['Pending Jobs', 'job', "t.status='pending'", 'fa-hourglass-half'],
        ['Closed / Expired', 'job', "(t.status='closed' OR t.closing_date<CURDATE())", 'fa-box-archive'],
        ['Total Applications', 'job_application', '1=1', 'fa-inbox'],
        ['Active Packages', fn() => scalar("SELECT COUNT(*) FROM user_packages WHERE module_key='jobs' AND status='active' AND expires_at>NOW()"), null, 'fa-gift'],
    ]],
];
$m = (string)($_GET['m'] ?? '');
if (!isset($DASH[$m])) { header('Location: overview.php'); exit; }
[$title, $mainKey, $cards] = $DASH[$m];
if ($m === 'jobs') pl_jobs_daily();
$E = pl_entity($mainKey);

$a = []; $base = pl_admin_base($E, $cid, $a, []);
$months = []; for ($i = 5; $i >= 0; $i--) $months[date('Y-m', strtotime("first day of -$i month"))] = 0;
foreach (rows("SELECT DATE_FORMAT(t.created_at,'%Y-%m') ym, COUNT(*) n FROM {$E['table']} t WHERE $base AND t.created_at >= ? GROUP BY ym", array_merge($a, [array_key_first($months) . '-01'])) as $r)
    if (isset($months[$r['ym']])) $months[$r['ym']] = (int)$r['n'];
$max = max(1, max($months));
$breakdown = [];
$catCol = array_key_first(array_filter($E['fields'], fn($f) => $f['type'] === 'category'));
if ($catCol) foreach (rows("SELECT t.$catCol k, COUNT(*) n FROM {$E['table']} t WHERE $base GROUP BY t.$catCol ORDER BY n DESC LIMIT 8", $a) as $r) $breakdown[pl_cat_names()[$r['k']] ?? 'Uncategorised'] = (int)$r['n'];
elseif ($E['statuses']) foreach (rows("SELECT t.{$E['status_col']} k, COUNT(*) n FROM {$E['table']} t WHERE $base GROUP BY k ORDER BY n DESC", $a) as $r) $breakdown[pl_status_label((string)$r['k'])] = (int)$r['n'];
$bmax = max(1, $breakdown ? max($breakdown) : 1);
$pending = $E['statuses'] ? rows("SELECT t.* FROM {$E['table']} t WHERE $base AND t.{$E['status_col']}='pending' ORDER BY t.id DESC LIMIT 6", $a) : [];
$recent = rows("SELECT t.* FROM {$E['table']} t WHERE $base ORDER BY t.id DESC LIMIT 6", $a);

render_header($title, 'auto', $user, $comm);
echo pl_stat_cards(array_map(fn($c) => [$c[0], $c[1] instanceof Closure ? ($c[1])() : pl_count($c[1], $cid, $c[2]), $c[3]], $cards)); ?>
<div class="grid2 anim">
  <div class="card"><div class="card-h"><h3>New <?= e(strtolower($E['plural'])) ?> — last 6 months</h3><a class="btn btn-line btn-sm" href="manage.php?e=<?= e($mainKey) ?>">Manage <?= icon('fa-arrow-right') ?></a></div>
    <div class="bars"><?php foreach ($months as $k => $n): ?><div class="bar"><b><?= $n ?></b><i style="height:<?= max(3, $n / $max * 100) ?>%"></i><?= date('M', strtotime($k . '-01')) ?></div><?php endforeach; ?></div></div>
  <div class="card"><div class="card-h"><h3><?= $catCol ? 'By category' : 'By status' ?></h3></div>
    <?php if (!$breakdown): ?><div class="empty"><?= icon('fa-chart-simple', 'big') ?>No data yet.</div><?php else: foreach ($breakdown as $l => $n): ?>
      <div class="hrow"><span><?= e($l) ?></span><div class="hb"><i style="width:<?= max(4, $n / $bmax * 100) ?>%"></i></div><b><?= $n ?></b></div><?php endforeach; endif; ?></div>
</div>
<?php if ($E['statuses']): ?><div class="card anim"><div class="card-h"><h3>Waiting for approval</h3><a class="btn btn-line btn-sm" href="manage.php?e=<?= e($mainKey) ?>&status=pending">View all <?= icon('fa-arrow-right') ?></a></div><?= pl_admin_table($E, $pending, $E['scope'] === 'mixed') ?></div><?php endif; ?>
<div class="card anim"><div class="card-h"><h3>Recently added</h3></div><?= pl_admin_table($E, $recent, $E['scope'] === 'mixed') ?></div>
<?php if ($m === 'events'): $AE = pl_entity('ad'); $aa = []; $ab = pl_admin_base($AE, $cid, $aa, []); ?>
<div class="card anim"><div class="card-h"><h3>Recent advertisements</h3><a class="btn btn-line btn-sm" href="manage.php?e=ad">Manage ads <?= icon('fa-arrow-right') ?></a></div><?= pl_admin_table($AE, rows("SELECT t.* FROM advertisements t WHERE $ab ORDER BY t.id DESC LIMIT 6", $aa), true) ?></div>
<?php endif;
if ($m === 'jobs'): $AE = pl_entity('job_application'); $aa = []; $ab = pl_admin_base($AE, $cid, $aa, []); ?>
<div class="card anim"><div class="card-h"><h3>Recent applications</h3><a class="btn btn-line btn-sm" href="manage.php?e=job_application">All applications <?= icon('fa-arrow-right') ?></a></div><?= pl_admin_table($AE, rows("SELECT t.* FROM jobs_applications t WHERE $ab ORDER BY t.id DESC LIMIT 6", $aa), false) ?></div>
<?php endif;
render_footer();
