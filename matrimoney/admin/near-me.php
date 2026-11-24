<?php
// Near Me = a location layer over the Professional & Business Directory (no separate database).
require __DIR__ . '/_boot.php';
$E = pl_entity('directory');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); $act = $_POST['action'] ?? '';
    if ($act === 'config') {
        pl_setting_set('near_me_enabled', empty($_POST['near_me_enabled']) ? 0 : 1);
        pl_setting_set('near_me_default_radius', max(1, (int)($_POST['near_me_default_radius'] ?? 10)));
        pl_setting_set('near_me_max_radius', max(1, (int)($_POST['near_me_max_radius'] ?? 50)));
        pl_setting_set('near_me_categories', implode(',', array_map('intval', (array)($_POST['near_me_categories'] ?? []))));
        pl_audit('settings', null, null, 'Near Me configuration'); flash('Near Me configuration saved');
    } elseif ($act === 'location' && ($r = pl_entity_row($E, (int)($_POST['id'] ?? 0)))) {
        [$cols, $err] = pl_entity_input($E, array_intersect_key($_POST, array_flip(['area', 'city', 'state', 'latitude', 'longitude', 'service_radius_km'])), [], true, $r, false);
        if ($err) flash($err, 'error');
        else { $cols['near_me_visible'] = empty($_POST['near_me_visible']) ? 0 : 1; pl_entity_update($E, (int)$r['id'], $cols); pl_audit('update', 'directory', (int)$r['id'], 'Near Me location', (int)$r['community_id']); flash('Location saved'); }
    } elseif ($act === 'geocode') {
        // look up coordinates from the address for up to 20 profiles that have none (about 1 second each)
        $ids = array_column(rows("SELECT id FROM directory_profiles WHERE community_id=? AND (latitude IS NULL OR longitude IS NULL) ORDER BY id DESC LIMIT 20", [$cid]), 'id');
        $done = 0; foreach ($ids as $id) $done += pl_geo_fill($E, (int)$id) ? 1 : 0;
        pl_audit('update', 'directory', null, "Near Me: located $done of " . count($ids) . ' profiles from their address', $cid);
        flash($ids ? "Found the location of $done of " . count($ids) . ' profiles from their address.' . ($done < count($ids) ? ' Enter the rest by hand below.' : '') : 'Every profile already has a location.', $done || !$ids ? 'success' : 'error');
    }
    header('Location: ' . pl_ret('near-me.php')); exit;
}

$missing = !empty($_GET['missing']); $q = trim((string)($_GET['q'] ?? ''));
$w = "t.community_id=? AND t.status='approved'"; $a = [$cid];
if ($missing) $w .= ' AND (t.latitude IS NULL OR t.longitude IS NULL)';
if ($q !== '') { $w .= ' AND (t.name LIKE ? OR t.business_name LIKE ? OR t.city LIKE ? OR t.area LIKE ?)'; array_push($a, "%$q%", "%$q%", "%$q%", "%$q%"); }
$page = max(1, (int)($_GET['page'] ?? 1));
$total = scalar("SELECT COUNT(*) FROM directory_profiles t WHERE $w", $a);
$list = rows("SELECT t.* FROM directory_profiles t WHERE $w ORDER BY t.id DESC LIMIT 25 OFFSET " . (($page - 1) * 25), $a);
$on = array_filter(explode(',', (string)pl_setting('near_me_categories')));
$stats = [['Approved profiles', pl_count('directory', $cid, "t.status='approved'"), 'fa-address-book'],
    ['Visible in Near Me', pl_count('directory', $cid, "t.status='approved' AND t.is_active=1 AND t.near_me_visible=1"), 'fa-location-crosshairs'],
    ['With coordinates', pl_count('directory', $cid, "t.status='approved' AND t.latitude IS NOT NULL AND t.longitude IS NOT NULL"), 'fa-map-location-dot'],
    ['Missing coordinates', pl_count('directory', $cid, "t.status='approved' AND (t.latitude IS NULL OR t.longitude IS NULL)"), 'fa-map-pin']];
render_header('Near Me', 'auto', $user, $comm);
echo pl_stat_cards($stats); ?>
<div class="card anim"><div class="card-h"><h3>Near Me configuration</h3><span class="muted">Near Me shows approved directory professionals near the user — not shops or restaurants.</span></div>
  <form method="post"><?= pl_csrf_field() ?><input type="hidden" name="action" value="config">
    <div class="fgrid"><div><label class="chk"><input type="checkbox" name="near_me_enabled" value="1" <?= pl_setting('near_me_enabled') ? 'checked' : '' ?>> Near Me enabled in the app</label></div>
      <div><label>Default radius (km)</label><input type="number" min="1" name="near_me_default_radius" value="<?= (int)pl_setting('near_me_default_radius') ?>"></div>
      <div><label>Maximum radius (km)</label><input type="number" min="1" name="near_me_max_radius" value="<?= (int)pl_setting('near_me_max_radius') ?>"></div>
      <div class="wide"><label>Categories shown in Near Me (none ticked = all)</label><div class="chips"><?php foreach (pl_categories('directory', false) as $c): ?><label class="chk"><input type="checkbox" name="near_me_categories[]" value="<?= (int)$c['id'] ?>" <?= in_array((string)$c['id'], $on, true) ? 'checked' : '' ?>> <?= e($c['name']) ?></label><?php endforeach; ?></div></div></div>
    <button class="btn btn-primary mt">Save configuration</button></form></div>
<div class="tabs anim"><a class="<?= $missing ? '' : 'on' ?>" href="near-me.php">All approved profiles</a><a class="<?= $missing ? 'on' : '' ?>" href="near-me.php?missing=1">Missing location data</a></div>
<div class="card anim"><form method="post" class="toolbar"><?= pl_csrf_field() ?><input type="hidden" name="action" value="geocode"><input type="hidden" name="ret" value="<?= e(pl_here()) ?>">
  <span class="grow muted">New listings get their location from the address automatically. Profiles saved before that can be located here (up to 20 at a time, using OpenStreetMap).</span>
  <button class="btn btn-primary"><?= icon('fa-location-crosshairs') ?> Find missing locations from address</button></form></div>
<div class="card anim">
  <form class="toolbar" method="get"><?php if ($missing): ?><input type="hidden" name="missing" value="1"><?php endif; ?><input class="grow" name="q" value="<?= e($q) ?>" placeholder="Search name, city or area"><button class="btn btn-primary"><?= icon('fa-magnifying-glass') ?> Search</button></form>
  <?php if (!$list): ?><div class="empty"><?= icon('fa-location-dot', 'big') ?>No profiles here.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Professional / Business</th><th>Category</th><th>Area</th><th>City</th><th>State</th><th>Latitude</th><th>Longitude</th><th>Radius km</th><th>Near Me</th><th></th></tr></thead><tbody>
  <?php foreach ($list as $r): $f = 'loc' . (int)$r['id']; ?><tr>
    <td data-label="Profile"><a class="lnk" href="manage.php?e=directory&view=<?= (int)$r['id'] ?>"><b><?= e($r['name']) ?></b></a><br><small><?= e($r['business_name']) ?></small></td>
    <td data-label="Category"><?= e(pl_cat_names()[$r['category_id']] ?? '—') ?></td>
    <?php foreach (['area' => 'text', 'city' => 'text', 'state' => 'text', 'latitude' => 'number', 'longitude' => 'number', 'service_radius_km' => 'number'] as $c => $t): ?>
      <td data-label="<?= e($E['fields'][$c]['label']) ?>"><input form="<?= $f ?>" class="sel-sm" style="width:<?= $t === 'number' ? '110' : '120' ?>px" type="<?= $t ?>"<?= $t === 'number' ? ' step="any"' : '' ?> name="<?= $c ?>" value="<?= e($r[$c]) ?>"></td><?php endforeach; ?>
    <td data-label="Near Me"><input form="<?= $f ?>" type="checkbox" name="near_me_visible" value="1" <?= $r['near_me_visible'] ? 'checked' : '' ?>></td>
    <td><form id="<?= $f ?>" class="inline" method="post"><?= pl_csrf_field() ?><input type="hidden" name="action" value="location"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><input type="hidden" name="ret" value="<?= e(pl_here()) ?>"><button class="btn btn-sm btn-blue">Save</button></form></td></tr>
  <?php endforeach; ?></tbody></table></div><?= pl_pager($page, (int)ceil($total / 25)) ?><?php endif; ?>
</div>
<?php render_footer();
