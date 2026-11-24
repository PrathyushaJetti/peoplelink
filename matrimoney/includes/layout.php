<?php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/bridge.php';

/* Sidebar. Item: [name, href (from dashboard root), icon, optional badge [entity, extra SQL]]. */
function menu_items(array $community = []): array {
    $m = fn(string $e, array $q = []) => 'admin/manage.php?' . http_build_query(['e' => $e] + $q);
    $cid = (int)($community['id'] ?? 0);
    return [
        'Dashboard' => ['fa-gauge-high', [
            ['Overview', 'admin/overview.php', 'fa-chart-pie'],
        ]],
        'Users' => ['fa-users', [
            ['All Users', 'admin/users.php', 'fa-users'],
            ['Suspended Users', 'admin/users.php?status=suspended', 'fa-user-slash'],
            ['Delete Requests', 'admin/users.php?status=delete_requests', 'fa-user-xmark'],
        ]],
        'Communities' => ['fa-people-group', [
            ['All Communities', 'matrimony/communities.php', 'fa-list'],
            ['Home & About (this community)', 'matrimony/communities.php?edit=' . $cid, 'fa-house-flag'],
        ]],
        'Matrimony' => ['fa-heart', [
            ['Matrimony Dashboard', 'dashboard.php', 'fa-chart-pie'],
            ['Profiles', 'matrimony/profiles.php', 'fa-users'],
            ['Photo Approval', 'matrimony/photo-approval.php', 'fa-image'],
            ['Interests', 'matrimony/interests.php', 'fa-envelope-open-text'],
            ['Packages', 'matrimony/packages.php', 'fa-gift'],
            ['Payments', 'matrimony/payments.php', 'fa-credit-card'],
            ['Reported Profiles', 'matrimony/reports-profiles.php', 'fa-flag'],
            ['Notifications', 'matrimony/notifications.php', 'fa-bell'],
            ['Support Requests', 'matrimony/support.php', 'fa-headset'],
            ['Reports', 'matrimony/reports.php', 'fa-chart-line'],
        ]],
        'Jobs' => ['fa-briefcase', [
            ['Jobs Dashboard', 'admin/module.php?m=jobs', 'fa-chart-pie'],
            ['All Jobs', $m('job'), 'fa-list'],
            ['Community Jobs', $m('job', ['vis' => 'community']), 'fa-people-group'],
            ['Global Jobs', $m('job', ['vis' => 'global']), 'fa-globe'],
            ['Pending Approval', $m('job', ['status' => 'pending']), 'fa-hourglass-half', ['job', "status='pending'"]],
            ['Applications', $m('job_application'), 'fa-inbox', ['job_application', "status='applied'"]],
            ['Job Categories', 'admin/categories.php?m=jobs', 'fa-tags'],
            ['Global Job Packages', $m('package', ['f_module_key' => 'jobs']), 'fa-gift'],
            ['Payments', 'admin/transactions.php?module=jobs', 'fa-credit-card'],
            ['Reports', 'admin/jobs-reports.php', 'fa-chart-line'],
        ]],
        'Marketplace' => ['fa-store', [
            ['Marketplace Dashboard', 'admin/module.php?m=marketplace', 'fa-chart-pie'],
            ['All Listings', $m('mp_listing'), 'fa-list'],
            ['Pending Listings', $m('mp_listing', ['status' => 'pending']), 'fa-hourglass-half', ['mp_listing', "status='pending'"]],
            ['Expired / Closed', $m('mp_listing', ['status' => 'expired']), 'fa-box-archive'],
            ['Featured Listings', $m('mp_listing', ['status' => 'featured']), 'fa-star'],
            ['Categories', 'admin/categories.php?m=marketplace', 'fa-tags'],
            ['Buyer Enquiries', 'admin/enquiries.php?e=mp_listing', 'fa-comments'],
            ['Reported Listings', 'admin/reports.php?tab=reported&e=mp_listing', 'fa-flag'],
        ]],
        'Members & Family' => ['fa-id-card', [
            ['Members Dashboard', 'admin/module.php?m=members', 'fa-chart-pie'],
            ['Members', $m('member'), 'fa-users'],
            ['Pending Members', $m('member', ['status' => 'pending']), 'fa-hourglass-half', ['member', "status='pending'"]],
            ['Families', $m('family'), 'fa-people-roof'],
            ['Family Members', $m('family_member'), 'fa-user-group'],
            ['Pending Family Approvals', $m('family_member', ['status' => 'pending']), 'fa-user-clock', ['family_member', "status='pending'"]],
            ['Important Dates', 'admin/important-dates.php', 'fa-cake-candles'],
        ]],
        'Family Tree' => ['fa-sitemap', [
            ['Family Tree Dashboard', 'admin/module.php?m=family_tree', 'fa-chart-pie'],
            ['All Family Trees', $m('family_tree'), 'fa-sitemap'],
            ['Pending Tree Requests', $m('family_tree', ['status' => 'pending']), 'fa-hourglass-half', ['family_tree', "tree_status='pending'"]],
            ['Relationships', $m('tree_relation'), 'fa-diagram-project'],
            ['Pending Relation Updates', $m('tree_relation', ['status' => 'pending']), 'fa-code-pull-request', ['tree_relation', "status='pending'"]],
            ['Tree Change Requests', 'admin/enquiries.php?e=family_tree', 'fa-clipboard-list'],
        ]],
        'Professional & Business Directory' => ['fa-address-book', [
            ['Directory Dashboard', 'admin/module.php?m=directory', 'fa-chart-pie'],
            ['All Profiles', $m('directory'), 'fa-list'],
            ['Professionals', $m('directory', ['f_profile_type' => 'Professional']), 'fa-user-doctor'],
            ['Businesses', $m('directory', ['f_profile_type' => 'Business']), 'fa-building'],
            ['Pending Approval', $m('directory', ['status' => 'pending']), 'fa-hourglass-half', ['directory', "status='pending'"]],
            ['Categories', 'admin/categories.php?m=directory', 'fa-tags'],
            ['Enquiries', 'admin/enquiries.php?e=directory', 'fa-comments'],
            ['Reported Profiles', 'admin/reports.php?tab=reported&e=directory', 'fa-flag'],
        ]],
        'Near Me' => ['fa-location-crosshairs', [
            ['Near Me Configuration', 'admin/near-me.php', 'fa-sliders'],
            ['Missing Location Data', 'admin/near-me.php?missing=1', 'fa-map-pin'],
        ]],
        'Events & Advertisements' => ['fa-calendar-days', [
            ['Events & Ads Dashboard', 'admin/module.php?m=events', 'fa-chart-pie'],
            ['All Events', $m('event'), 'fa-calendar-days'],
            ['Upcoming Events', $m('event', ['status' => 'upcoming']), 'fa-calendar-check'],
            ['Pending Events', $m('event', ['status' => 'pending']), 'fa-hourglass-half', ['event', "status='pending'"]],
            ['Registrations / Enquiries', 'admin/enquiries.php?e=event', 'fa-clipboard-list'],
            ['Event Categories', 'admin/categories.php?m=events', 'fa-tags'],
            ['All Advertisements', $m('ad'), 'fa-rectangle-ad'],
            ['Pending Ads', $m('ad', ['status' => 'pending']), 'fa-hourglass-half', ['ad', "status='pending'"]],
            ['Global Advertisements', $m('ad', ['vis' => 'global']), 'fa-globe'],
        ]],
        'Community Support' => ['fa-hand-holding-heart', [
            ['Support Dashboard', 'admin/module.php?m=support', 'fa-chart-pie'],
            ['All Requests', $m('support'), 'fa-list'],
            ['Pending Requests', $m('support', ['status' => 'pending']), 'fa-hourglass-half', ['support', "status='pending'"]],
            ['In Progress', $m('support', ['status' => 'in_progress']), 'fa-spinner'],
            ['Help Offers', $m('support_offer'), 'fa-handshake-angle', ['support_offer', "status='offered'"]],
            ['Assistance Types', 'admin/categories.php?m=support', 'fa-tags'],
        ]],
        'Community Leadership' => ['fa-user-tie', [
            ['Community Leaders', $m('community_leader'), 'fa-user-tie'],
            ['Add Leader', $m('community_leader', ['edit' => 0]), 'fa-user-plus'],
        ]],
        'Global Leadership' => ['fa-globe', [
            ['Global Leaders', $m('global_leader'), 'fa-globe'],
            ['Add Global Leader', $m('global_leader', ['edit' => 0]), 'fa-user-plus'],
        ]],
        'Payments & Transactions' => ['fa-indian-rupee-sign', [
            ['Payments Dashboard', 'admin/transactions.php', 'fa-chart-pie'],
            ['Pending / Failed', 'admin/transactions.php?status=created', 'fa-triangle-exclamation'],
            ['Active Packages', 'admin/transactions.php?tab=packages', 'fa-box-open'],
            ['Packages & Pricing', $m('package'), 'fa-gift'],
        ]],
        'Notifications' => ['fa-bell', [
            ['Send Notification', 'admin/notifications.php', 'fa-paper-plane'],
        ]],
        'Reports' => ['fa-chart-line', [
            ['Module Reports', 'admin/reports.php', 'fa-chart-line'],
            ['Reported Content', 'admin/reports.php?tab=reported', 'fa-flag', ['_reports', '']],
            ['Audit Log', 'admin/audit-log.php', 'fa-clock-rotate-left'],
        ]],
        'Settings' => ['fa-gear', [
            ['General Settings', 'admin/settings.php', 'fa-sliders'],
        ]],
    ];
}

/* Finds the menu item for the current URL: same script and every query value of the item present in the request. */
function pl_menu_match(array $menu): string {
    $script = basename($_SERVER['SCRIPT_NAME']);
    $path = ($GLOBALS['ROOT'] === '../' ? basename(dirname($_SERVER['SCRIPT_NAME'])) . '/' : '') . $script;
    $best = ''; $score = -1;
    foreach ($menu as $label => [, $children]) foreach ($children as $it) {
        $u = parse_url($it[1]); parse_str($u['query'] ?? '', $q);
        if ($u['path'] !== $path) continue;
        $ok = true; foreach ($q as $k => $v) if ((string)($_GET[$k] ?? '') !== (string)$v) { $ok = false; break; }
        if ($ok && count($q) > $score) { $best = "$label/{$it[0]}"; $score = count($q); }
    }
    return $best;
}

function render_header(string $title, string $active, array $user, array $community): void {
    pl_ensure_schema();
    $root = $GLOBALS['ROOT']; $flash = flash(); $cid = (int)$community['id'];
    $menu = menu_items($community);
    if ($active === 'auto') $active = pl_menu_match($menu);
    $badges = [];
    try {
        $badges['Profiles'] = scalar("SELECT COUNT(*) FROM matrimony_profiles WHERE community_id=? AND status='pending'", [$cid]);
        $badges['Reported Profiles'] = scalar("SELECT COUNT(*) FROM matrimony_reports WHERE community_id=? AND status='open'", [$cid]);
        $badges['Support Requests'] = scalar("SELECT COUNT(*) FROM matrimony_support WHERE status='open' AND (community_id=? OR community_id IS NULL)", [$cid]);
        foreach ($menu as [, $children]) foreach ($children as $it) {
            if (empty($it[3])) continue;
            [$ek, $sql] = $it[3];
            if ($ek === '_reports') { $badges[$it[0]] = scalar("SELECT COUNT(*) FROM content_reports WHERE status='open' AND (community_id=? OR community_id IS NULL)", [$cid]); continue; }
            $E = pl_entity($ek); $a = [];
            $w = $E['scope'] === 'global' ? '1=1' : 'community_id=?'; if ($E['scope'] !== 'global') $a[] = $cid;
            foreach ($E['fixed'] as $k => $v) { $w .= " AND $k=?"; $a[] = $v; }
            $badges[$it[0]] = scalar("SELECT COUNT(*) FROM {$E['table']} WHERE $w AND $sql", $a);
        }
    } catch (Throwable $e) { error_log('PL badges: ' . $e->getMessage()); } ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title) ?> | PeopleLink</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="<?= $root ?>assets/style.css"></head><body>
<div class="overlay" id="overlay"></div>
<div class="shell">
<aside class="side" id="side">
  <div class="brand"><img class="logo" src="<?= LOGO_URL ?>" alt="PeopleLink"></div>
  <div class="comm">Community<b><?= icon('fa-people-group') ?> <?= e($community['name']) ?></b><a href="<?= $root ?>select-community.php">Change community</a></div>
  <nav class="nav">
    <?php foreach ($menu as $label => [$icon, $children]): $isOpen = str_starts_with($active, $label . '/'); ?>
      <details <?= $isOpen ? 'open' : '' ?>>
        <summary><?= icon($icon) ?> <?= e($label) ?></summary>
        <div class="sub-nav"><?php foreach ($children as $it): [$name, $href, $ic] = $it; ?>
          <a href="<?= e($root . $href) ?>" class="<?= $active === "$label/$name" ? 'active' : '' ?>"><?= icon($ic) ?> <?= e($name) ?>
            <?php if (!empty($badges[$name])): ?><span class="badge-n"><?= (int)$badges[$name] ?></span><?php endif; ?></a>
        <?php endforeach; ?></div>
      </details>
    <?php endforeach; ?>
    <small>Account</small>
    <a href="<?= $root ?>logout.php"><?= icon('fa-right-from-bracket') ?> Logout</a>
  </nav>
</aside>
<div class="main">
  <header class="top">
    <div class="top-l"><button class="menu-btn" id="menuBtn" aria-label="Menu"><?= icon('fa-bars') ?></button>
      <div><h2><?= e($title) ?></h2><div class="crumb"><?= e($community['name']) ?> › <?= e(str_replace('/', ' › ', $active ?: $title)) ?></div></div></div>
    <div class="who"><span><?= e($user['name']) ?></span><div class="avatar"><?= e(strtoupper($user['name'][0])) ?></div></div>
  </header>
  <main class="content">
  <?php if ($flash): ?><div class="alert <?= e($flash[1]) ?>"><?= e($flash[0]) ?></div><?php endif;
}

function render_footer(): void { $root = $GLOBALS['ROOT']; ?>
  </main></div></div><script src="<?= $root ?>assets/app.js"></script></body></html>
<?php }
