<?php
// App API for the registry modules (Marketplace, Directory, Near Me, Events, Ads, Support, Leadership, Community Home/About).
// Every module with an 'api' prefix gets: {p}_list {p}_search {p}_filters {p}_details {p}_categories {p}_create {p}_update {p}_delete {p}_my
// {p}_upload {p}_photo_delete {p}_save {p}_saved {p}_enquiry {p}_enquiries {p}_report {p}_close  (only those the module supports).

function pl_api_page(): array { return [max(1, (int)($_REQUEST['page'] ?? 1)), max(1, min(50, (int)($_REQUEST['per'] ?? 20)))]; }

function pl_api_visible(array $E, int $id, int $cid, ?int $uid): ?array {
    $a = []; $w = pl_ent_where($E, $cid, $a);
    $r = rows("SELECT t.* FROM {$E['table']} t WHERE t.id=? AND $w", array_merge([$id], $a))[0] ?? null;
    if ($r) return $r;
    $own = $uid ? pl_entity_row($E, $id) : null;
    return $own && (int)$own['user_id'] === $uid ? $own : null;
}

function pl_api_own(array $E, int $id, int $uid): ?array {
    $r = $id ? pl_entity_row($E, $id) : null;
    return $r && (int)$r['user_id'] === $uid ? $r : null;
}

function pl_api_files(array $E): array {
    $out = [];
    foreach ($_FILES as $k => $f) if (!isset($E['fields'][$k])) $out[$k] = $f;
    return $out;
}

function pl_api_details(array $E, array $r, ?int $uid): array {
    $own = $uid && (int)$r['user_id'] === $uid;
    if (!$own) db()->prepare("UPDATE {$E['table']} SET views=views+1, updated_at=updated_at WHERE id=?")->execute([$r['id']]);
    $o = pl_ent_out($E, $r, $uid, true);
    if ($E['save']) $o['saved'] = $uid ? (bool)scalar('SELECT COUNT(*) FROM favourites WHERE user_id=? AND entity=? AND entity_id=?', [$uid, $E['table'], $r['id']]) : false;
    if ($own && $E['enquiry']) $o['enquiry_count'] = scalar('SELECT COUNT(*) FROM enquiries WHERE entity=? AND entity_id=?', [$E['table'], $r['id']]);
    if ($own) $o['views'] = (int)$r['views'];
    return $o;
}

function pl_api_create(array $E, array $x): array {
    [$cols, $err] = pl_entity_input($E, $_POST, $_FILES, false, null, true);
    if ($err) return ['error' => $err, 'code' => 'VALIDATION_ERROR'];
    $meta = ['community_id' => $E['scope'] === 'global' ? null : $x['cid'], 'user_id' => $x['uid'], 'created_by' => $x['uid'],
        'visibility_type' => $E['scope'] === 'mixed' && ($_POST['visibility_type'] ?? '') === 'global' ? 'global' : ($E['scope'] === 'global' ? 'global' : 'community'), $E['active_col'] => 1];
    if ($E['statuses']) $meta[$E['status_col']] = $E['statuses'][0];
    if ($E['key'] === 'ad' && pl_setting('ads_require_payment')) $cols['payment_status'] = 'pending';
    if ($E['key'] === 'support' && empty($cols['contact_name'])) $cols['contact_name'] = $x['user']['name'];
    $id = pl_entity_insert($E, $cols, $meta);
    $warn = null;
    if (($E['gallery'] || $E['files']) && pl_files_list(pl_api_files($E))) { $r = pl_media_add($E, $id, pl_api_files($E), $x['uid']); $warn = $r['error'] ?? null; }
    pl_geo_fill($E, $id);
    pl_audit('app_create', $E['key'], $id, pl_entity_title($E, $cols), $x['cid'] ?: null);
    $row = pl_entity_row($E, $id);
    return ['message' => $E['label'] . ($E['statuses'] ? ' submitted for approval.' : ' saved.'), 'id' => $id, 'item' => pl_ent_out($E, $row, $x['uid'], true)] + ($warn ? ['upload_error' => $warn] : []);
}

function pl_api_update(array $E, array $x, ?array $r): array {
    if (!$r) return ['error' => $E['label'] . ' not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    if ($E['closable'] && $r[$E['status_col']] === 'closed') return ['error' => 'This ' . strtolower($E['label']) . ' is closed.', 'code' => 'VALIDATION_ERROR'];
    [$cols, $err] = pl_entity_input($E, $_POST, $_FILES, false, $r, false);
    if ($err) return ['error' => $err, 'code' => 'VALIDATION_ERROR'];
    if ($E['scope'] === 'mixed' && in_array($_POST['visibility_type'] ?? '', ['community', 'global'], true)) $cols['visibility_type'] = $_POST['visibility_type'];
    $re = $E['statuses'] && in_array($r[$E['status_col']], ['approved', 'rejected'], true) && in_array('pending', $E['statuses'], true);
    if ($re) $cols[$E['status_col']] = 'pending';
    foreach ($E['fields'] as $c => $f) if ($f['type'] === 'image' && array_key_exists($c, $cols) && $cols[$c] !== $r[$c]) pl_delete_file($r[$c]);
    // a changed address without new coordinates: look the location up again
    $addr = array_intersect_key($cols, array_flip(['address', 'area', 'city', 'state', 'pincode']));
    if (isset($E['fields']['latitude']) && !isset($cols['latitude']) && $addr && $addr != array_intersect_key($r, $addr)) { $cols['latitude'] = null; $cols['longitude'] = null; }
    pl_entity_update($E, (int)$r['id'], $cols);
    pl_geo_fill($E, (int)$r['id']);
    if (($E['gallery'] || $E['files']) && pl_files_list(pl_api_files($E))) pl_media_add($E, (int)$r['id'], pl_api_files($E), $x['uid']);
    pl_audit('app_update', $E['key'], (int)$r['id'], array_keys($cols), $r['community_id'] ? (int)$r['community_id'] : null);
    return ['message' => $re ? 'Updated and sent for re-approval.' : 'Updated.', 'item' => pl_ent_out($E, pl_entity_row($E, (int)$r['id']), $x['uid'], true)];
}

function pl_api_enquiry(array $E, array $x, array $r, string $kind = 'enquiry'): array {
    if ((int)$r['user_id'] === $x['uid']) return ['error' => 'You cannot send an enquiry to yourself.', 'code' => 'VALIDATION_ERROR'];
    $msg = mb_substr(trim((string)($_POST['message'] ?? '')), 0, 3000);
    if ($kind === 'register') {
        if (scalar("SELECT COUNT(*) FROM enquiries WHERE entity=? AND entity_id=? AND user_id=? AND kind='register'", [$E['table'], $r['id'], $x['uid']])) return ['error' => 'You are already registered for this event.', 'code' => 'VALIDATION_ERROR'];
        $max = (int)($r['max_registrations'] ?? 0);
        if ($max && scalar("SELECT COUNT(*) FROM enquiries WHERE entity=? AND entity_id=? AND kind='register'", [$E['table'], $r['id']]) >= $max) return ['error' => 'Registrations are full for this event.', 'code' => 'VALIDATION_ERROR'];
    } elseif ($msg === '') return ['error' => 'Please write a message.', 'code' => 'VALIDATION_ERROR'];
    $phone = preg_replace('/[^\d+]/', '', (string)($_POST['phone'] ?? $x['user']['phone'] ?? ''));
    $email = trim((string)($_POST['email'] ?? $x['user']['email']));
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) return ['error' => 'Enter a valid email.', 'code' => 'VALIDATION_ERROR'];
    db()->prepare('INSERT INTO enquiries (entity, entity_id, community_id, user_id, owner_user_id, kind, name, phone, email, message) VALUES (?,?,?,?,?,?,?,?,?,?)')
        ->execute([$E['table'], $r['id'], $r['community_id'], $x['uid'], $r['user_id'], $kind, mb_substr(trim((string)($_POST['name'] ?? $x['user']['name'])), 0, 120), mb_substr($phone, 0, 30), mb_substr($email, 0, 160), $msg]);
    $t = pl_entity_title($E, $r);
    if ($r['user_id']) pl_notify_user((int)$r['user_id'], $r['community_id'] ? (int)$r['community_id'] : null, $kind === 'register' ? 'New event registration' : 'New enquiry',
        $x['user']['name'] . ($kind === 'register' ? ' registered for ' : ' sent an enquiry about ') . "\"$t\".", 'enquiry', $E['table'], (int)$r['id']);
    return ['message' => $kind === 'register' ? 'You are registered.' : 'Your enquiry has been sent.', 'enquiry_id' => (int)db()->lastInsertId()];
}

function pl_api_filters(array $E): array {
    $out = [];
    foreach ($E['fields'] as $c => $f) {
        if (empty($f['filter'])) continue;
        $o = ['field' => $c, 'label' => $f['label'], 'type' => $f['type']];
        if ($f['type'] === 'select') $o['options'] = array_map(fn($k, $v) => ['value' => $k, 'label' => $v], array_keys(pl_opts($f)), pl_opts($f));
        if ($f['type'] === 'money') { $o['params'] = [$c . '_min', $c . '_max']; $mm = rows("SELECT MIN($c) mn, MAX($c) mx FROM {$E['table']}")[0]; $o['min'] = (float)$mm['mn']; $o['max'] = (float)$mm['mx']; }
        if ($f['type'] === 'date') $o['params'] = [$c, $c . '_from', $c . '_to'];
        $out[] = $o;
    }
    $sorts = ['recent', 'oldest'];
    if (isset($E['fields']['price'])) array_push($sorts, 'price_asc', 'price_desc');
    if (isset($E['fields']['event_date'])) array_push($sorts, 'date', 'date_desc');
    return ['filters' => $out, 'sort' => $sorts, 'categories' => $E['cat'] ? pl_categories($E['cat']) : []];
}

function pl_api_register(string $key): void {
    $E = pl_entity($key); $p = $E['api'];
    $list = fn($x) => pl_ent_list($E, $x['cid'], $_GET + $_POST, $x['uid'], ...pl_api_page());
    pl_action("{$p}_list", $list, true, false);
    pl_action("{$p}_search", $list, true, false);
    pl_action("{$p}_filters", fn($x) => pl_api_filters($E), true, false);
    pl_action("{$p}_details", function ($x) use ($E) {
        $r = pl_api_visible($E, (int)($_REQUEST['id'] ?? 0), $x['cid'], $x['uid']);
        return $r ? ['item' => pl_api_details($E, $r, $x['uid'])] : ['error' => $E['label'] . ' not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    }, true, false);
    if ($E['cat']) pl_action("{$p}_categories", fn($x) => ['categories' => pl_categories($E['cat'])], true, false);
    if ($E['user_post']) {
        pl_action("{$p}_create", fn($x) => pl_api_create($E, $x));
        pl_action("{$p}_update", fn($x) => pl_api_update($E, $x, pl_api_own($E, (int)($_POST['id'] ?? 0), $x['uid'])));
        pl_action("{$p}_delete", function ($x) use ($E) {
            $r = pl_api_own($E, (int)($_POST['id'] ?? 0), $x['uid']);
            if (!$r) return ['error' => $E['label'] . ' not found.', 'code' => 'NOT_FOUND', '_code' => 404];
            pl_entity_delete($E, (int)$r['id']); pl_audit('app_delete', $E['key'], (int)$r['id'], pl_entity_title($E, $r), $r['community_id'] ? (int)$r['community_id'] : null);
            return ['message' => $E['label'] . ' deleted.'];
        });
        pl_action("{$p}_my", function ($x) use ($E) {
            [$page, $per] = pl_api_page();
            $a = [$x['uid']]; $w = 't.user_id=?';
            foreach ($E['fixed'] as $k => $v) { $w .= " AND t.$k=?"; $a[] = $v; }
            if (!empty($_GET['status']) && in_array($_GET['status'], $E['statuses'], true)) { $w .= " AND t.{$E['status_col']}=?"; $a[] = $_GET['status']; }
            $total = scalar("SELECT COUNT(*) FROM {$E['table']} t WHERE $w", $a);
            $list = rows("SELECT t.* FROM {$E['table']} t WHERE $w ORDER BY t.id DESC LIMIT $per OFFSET " . (($page - 1) * $per), $a);
            $cov = pl_ent_covers($E, array_column($list, 'id'));
            return ['total' => $total, 'page' => $page, 'per' => $per, 'total_pages' => (int)ceil($total / $per),
                'items' => array_map(function ($r) use ($E, $x, $cov) { $r['_cover'] = $cov[$r['id']] ?? null; return pl_ent_out($E, $r, $x['uid']); }, $list)];
        }, false, false);
        if ($E['gallery'] || $E['files']) {
            pl_action("{$p}_upload", function ($x) use ($E) {
                $r = pl_api_own($E, (int)($_POST['id'] ?? 0), $x['uid']);
                return $r ? pl_media_add($E, (int)$r['id'], pl_api_files($E), $x['uid']) : ['error' => $E['label'] . ' not found.', 'code' => 'NOT_FOUND', '_code' => 404];
            });
            pl_action("{$p}_photo_delete", function ($x) use ($E) {
                $r = pl_api_own($E, (int)($_POST['id'] ?? 0), $x['uid']);
                if (!$r || !pl_media_delete($E, (int)$r['id'], (int)($_POST['photo_id'] ?? $_POST['media_id'] ?? 0))) return ['error' => 'Photo not found.', 'code' => 'NOT_FOUND', '_code' => 404];
                return ['message' => 'Removed.', 'media' => pl_media($E, (int)$r['id'])];
            });
            pl_action("{$p}_photo_primary", function ($x) use ($E) {
                $r = pl_api_own($E, (int)($_POST['id'] ?? 0), $x['uid']);
                if (!$r || !pl_media_primary($E, (int)$r['id'], (int)($_POST['photo_id'] ?? $_POST['media_id'] ?? 0))) return ['error' => 'Photo not found.', 'code' => 'NOT_FOUND', '_code' => 404];
                return ['message' => 'Main photo updated.', 'media' => pl_media($E, (int)$r['id'])];
            });
        }
    }
    if ($E['closable']) pl_action("{$p}_close", function ($x) use ($E) {
        $r = pl_api_own($E, (int)($_POST['id'] ?? 0), $x['uid']);
        if (!$r) return ['error' => $E['label'] . ' not found.', 'code' => 'NOT_FOUND', '_code' => 404];
        pl_entity_update($E, (int)$r['id'], [$E['status_col'] => 'closed', 'closed_at' => date('Y-m-d H:i:s')]);
        pl_audit('app_close', $E['key'], (int)$r['id'], null, $r['community_id'] ? (int)$r['community_id'] : null);
        return ['message' => $E['label'] . ' closed.'];
    });
    if ($E['save']) {
        pl_action("{$p}_save", function ($x) use ($E) {
            $id = (int)($_POST['id'] ?? 0);
            if (!pl_api_visible($E, $id, $x['cid'], $x['uid'])) return ['error' => $E['label'] . ' not found.', 'code' => 'NOT_FOUND', '_code' => 404];
            if (scalar('SELECT COUNT(*) FROM favourites WHERE user_id=? AND entity=? AND entity_id=?', [$x['uid'], $E['table'], $id])) {
                db()->prepare('DELETE FROM favourites WHERE user_id=? AND entity=? AND entity_id=?')->execute([$x['uid'], $E['table'], $id]);
                return ['saved' => false, 'message' => 'Removed from saved.'];
            }
            db()->prepare('INSERT INTO favourites (user_id, entity, entity_id) VALUES (?,?,?)')->execute([$x['uid'], $E['table'], $id]);
            return ['saved' => true, 'message' => 'Saved.'];
        });
        pl_action("{$p}_saved", fn($x) => pl_ent_list($E, $x['cid'], [], $x['uid'], ...array_merge(pl_api_page(), ['t.id IN (SELECT entity_id FROM favourites WHERE user_id=? AND entity=?)', [$x['uid'], $E['table']]])), false, false);
    }
    if ($E['enquiry']) {
        pl_action("{$p}_enquiry", function ($x) use ($E) {
            $r = pl_api_visible($E, (int)($_POST['id'] ?? 0), $x['cid'], $x['uid']);
            return $r ? pl_api_enquiry($E, $x, $r, in_array($_POST['kind'] ?? '', ['register', 'contact'], true) ? $_POST['kind'] : 'enquiry') : ['error' => $E['label'] . ' not found.', 'code' => 'NOT_FOUND', '_code' => 404];
        });
        pl_action("{$p}_enquiries", function ($x) use ($E) {
            $w = 'q.entity=? AND q.owner_user_id=?'; $a = [$E['table'], $x['uid']];
            if (!empty($_GET['id'])) { $w .= ' AND q.entity_id=?'; $a[] = (int)$_GET['id']; }
            return ['enquiries' => array_map(fn($q) => ['id' => (int)$q['id'], 'item_id' => (int)$q['entity_id'], 'item_title' => $q['item_title'], 'kind' => $q['kind'], 'name' => $q['name'],
                'phone' => $q['phone'], 'email' => $q['email'], 'message' => $q['message'], 'status' => $q['status'], 'created_at' => $q['created_at']],
                rows("SELECT q.*, t.{$E['title']} item_title FROM enquiries q LEFT JOIN {$E['table']} t ON t.id=q.entity_id WHERE $w ORDER BY q.id DESC LIMIT 200", $a))];
        }, false, false);
    }
    if ($E['report']) pl_action("{$p}_report", function ($x) use ($E) {
        $r = pl_api_visible($E, (int)($_POST['id'] ?? 0), $x['cid'], $x['uid']);
        if (!$r) return ['error' => $E['label'] . ' not found.', 'code' => 'NOT_FOUND', '_code' => 404];
        $reason = mb_substr(trim((string)($_POST['reason'] ?? '')), 0, 255);
        if ($reason === '') return ['error' => 'Please choose a reason.', 'code' => 'VALIDATION_ERROR'];
        if (scalar("SELECT COUNT(*) FROM content_reports WHERE entity=? AND entity_id=? AND user_id=? AND status='open'", [$E['table'], $r['id'], $x['uid']])) return ['message' => 'You have already reported this. Our team is reviewing it.'];
        db()->prepare('INSERT INTO content_reports (entity, entity_id, community_id, user_id, reason, details, action_type) VALUES (?,?,?,?,?,?,?)')
            ->execute([$E['table'], $r['id'], $r['community_id'], $x['uid'], $reason, mb_substr(trim((string)($_POST['details'] ?? '')), 0, 2000), ($_POST['type'] ?? '') === 'block' ? 'block' : 'report']);
        return ['message' => 'Report submitted. Our team will review it.'];
    });
}

foreach (pl_entity_keys() as $__k) if (pl_entity($__k)['api']) pl_api_register($__k);
// names used in the scope document: marketplace_post / marketplace_edit, events_post, ads_edit ...
foreach (pl_entity_keys() as $__k) { $__E = pl_entity($__k); if ($__E['api'] && $__E['user_post']) {
    $GLOBALS['PL_ACTIONS'][$__E['api'] . '_post'] = $GLOBALS['PL_ACTIONS'][$__E['api'] . '_create'];
    $GLOBALS['PL_ACTIONS'][$__E['api'] . '_edit'] = $GLOBALS['PL_ACTIONS'][$__E['api'] . '_update'];
} }
$GLOBALS['PL_ACTIONS']['directory_professional_details'] = $GLOBALS['PL_ACTIONS']['directory_business_details'] = $GLOBALS['PL_ACTIONS']['directory_details'];
unset($__k, $__E);

/* ---------- Near Me: location layer over the Directory ---------- */

function pl_near_me(array $x, array $f): array {
    if (!pl_setting('near_me_enabled')) return ['error' => 'Near Me is not available right now.', 'code' => 'DISABLED', '_code' => 403];
    $E = pl_entity('directory');
    $lat = is_numeric($f['lat'] ?? $f['latitude'] ?? null) ? (float)($f['lat'] ?? $f['latitude']) : null;
    $lng = is_numeric($f['lng'] ?? $f['longitude'] ?? null) ? (float)($f['lng'] ?? $f['longitude']) : null;
    $radius = min(max(1, (float)($f['radius'] ?? $f['distance'] ?? pl_setting('near_me_default_radius'))), max(1, pl_setting('near_me_max_radius')));
    if ($lat === null && trim((string)($f['city'] ?? '')) === '' && trim((string)($f['area'] ?? '')) === '') return ['error' => 'Send your location (lat, lng) or a city / area.', 'code' => 'VALIDATION_ERROR'];
    $extra = 't.near_me_visible=1'; $ea = [];
    $cats = array_filter(array_map('intval', explode(',', (string)pl_setting('near_me_categories'))));
    if ($cats) $extra .= ' AND t.category_id IN (' . implode(',', $cats) . ')';
    $dist = null;
    if ($lat !== null && $lng !== null) {
        $dist = '(6371 * ACOS(LEAST(1, COS(RADIANS(?)) * COS(RADIANS(t.latitude)) * COS(RADIANS(t.longitude) - RADIANS(?)) + SIN(RADIANS(?)) * SIN(RADIANS(t.latitude)))))';
        $extra .= " AND t.latitude IS NOT NULL AND t.longitude IS NOT NULL AND $dist <= ?"; array_push($ea, $lat, $lng, $lat, $radius);
    }
    [$page, $per] = pl_api_page();
    $a = []; $w = pl_ent_where($E, $x['cid'], $a) . pl_ent_filters($E, $f, $a) . " AND $extra"; $a = array_merge($a, $ea);
    $total = scalar("SELECT COUNT(*) FROM directory_profiles t WHERE $w", $a);
    $sel = $dist ? ", $dist distance_km" : ', NULL distance_km';
    $sa = $dist ? array_merge([$lat, $lng, $lat], $a) : $a;
    $list = rows("SELECT t.* $sel FROM directory_profiles t WHERE $w ORDER BY " . ($dist ? 'distance_km ASC' : 't.is_featured DESC, t.id DESC') . " LIMIT $per OFFSET " . (($page - 1) * $per), $sa);
    $cov = pl_ent_covers($E, array_column($list, 'id'));
    $saved = $x['uid'] ? array_column(rows('SELECT entity_id FROM favourites WHERE user_id=? AND entity=?', [$x['uid'], 'directory_profiles']), 'entity_id') : [];
    return ['total' => $total, 'page' => $page, 'per' => $per, 'total_pages' => (int)ceil($total / $per), 'radius_km' => $radius,
        'items' => array_map(function ($r) use ($E, $x, $cov, $saved) {
            $r['_cover'] = $cov[$r['id']] ?? null; $o = pl_ent_out($E, $r, $x['uid']);
            $o['distance_km'] = $r['distance_km'] === null ? null : round((float)$r['distance_km'], 2); $o['saved'] = in_array($r['id'], $saved); return $o;
        }, $list)];
}
foreach (['nearme_list', 'nearme_search', 'nearme_filter'] as $__a) pl_action($__a, fn($x) => pl_near_me($x, $_GET + $_POST), true, false);
pl_action('nearme_details', function ($x) {
    $E = pl_entity('directory');
    $r = pl_api_visible($E, (int)($_REQUEST['id'] ?? 0), $x['cid'], $x['uid']);
    if (!$r) return ['error' => 'Professional not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    $o = pl_api_details($E, $r, $x['uid']);
    $lat = $_REQUEST['lat'] ?? null; $lng = $_REQUEST['lng'] ?? null;
    if (is_numeric($lat) && is_numeric($lng) && $r['latitude'] !== null) {
        $d = 6371 * acos(min(1, cos(deg2rad((float)$lat)) * cos(deg2rad((float)$r['latitude'])) * cos(deg2rad((float)$r['longitude']) - deg2rad((float)$lng)) + sin(deg2rad((float)$lat)) * sin(deg2rad((float)$r['latitude']))));
        $o['distance_km'] = round($d, 2);
    }
    return ['item' => $o];
}, true, false);
pl_action('nearme_config', fn($x) => ['enabled' => (bool)pl_setting('near_me_enabled'), 'default_radius_km' => pl_setting('near_me_default_radius'), 'max_radius_km' => pl_setting('near_me_max_radius'),
    'categories' => array_values(array_filter(pl_categories('directory'), fn($c) => !($ids = array_filter(explode(',', (string)pl_setting('near_me_categories')))) || in_array((string)$c['id'], $ids, true)))], true, false);

/* ---------- Events & Ads extras ---------- */

pl_action('events_upcoming', fn($x) => pl_ent_list(pl_entity('event'), $x['cid'], ($_GET + $_POST) + ['sort' => 'date'], $x['uid'], ...array_merge(pl_api_page(), ['t.event_date >= CURDATE()', []])), true, false);
pl_action('events_register', function ($x) {
    $E = pl_entity('event');
    $r = pl_api_visible($E, (int)($_POST['id'] ?? 0), $x['cid'], $x['uid']);
    if (!$r) return ['error' => 'Event not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    if ($r['event_date'] < date('Y-m-d')) return ['error' => 'This event is over.', 'code' => 'VALIDATION_ERROR'];
    return pl_api_enquiry($E, $x, $r, ($_POST['kind'] ?? 'register') === 'enquiry' ? 'enquiry' : 'register');
});
pl_action('ads_global', fn($x) => pl_ent_list(pl_entity('ad'), $x['cid'], $_GET + $_POST, $x['uid'], ...array_merge(pl_api_page(), ["t.visibility_type='global'", []])), true, false);
pl_action_nocomm('ads_global');

/* ---------- Community Support extras ---------- */

pl_action('support_offer_help', function ($x) {
    $E = pl_entity('support'); $OE = pl_entity('support_offer');
    $r = pl_api_visible($E, (int)($_POST['request_id'] ?? $_POST['id'] ?? 0), $x['cid'], $x['uid']);
    if (!$r || !in_array($r['status'], ['approved', 'in_progress'], true)) return ['error' => 'This request is not open for help.', 'code' => 'NOT_FOUND', '_code' => 404];
    if ((int)$r['user_id'] === $x['uid']) return ['error' => 'You cannot offer help on your own request.', 'code' => 'VALIDATION_ERROR'];
    if (scalar("SELECT COUNT(*) FROM support_offers WHERE request_id=? AND user_id=? AND status<>'closed'", [$r['id'], $x['uid']])) return ['error' => 'You have already offered help for this request.', 'code' => 'VALIDATION_ERROR'];
    $in = $_POST + ['name' => $x['user']['name'], 'phone' => $x['user']['phone'] ?? '', 'email' => $x['user']['email']];
    $in['request_id'] = $r['id'];
    [$cols, $err] = pl_entity_input($OE, $in, [], false, null, true);
    if ($err) return ['error' => $err, 'code' => 'VALIDATION_ERROR'];
    $id = pl_entity_insert($OE, $cols, ['community_id' => $r['community_id'], 'user_id' => $x['uid'], 'created_by' => $x['uid'], 'status' => 'offered']);
    pl_audit('app_offer_help', 'support', (int)$r['id'], 'Offer #' . $id, (int)$r['community_id']);
    pl_notify_user((int)$r['user_id'], (int)$r['community_id'], 'Someone offered help', 'A community member offered help for "' . $r['title'] . '". Our team will connect you.', 'support', 'support_requests', (int)$r['id']);
    return ['message' => 'Thank you! Your offer has been sent. The team will connect you with the requester.', 'offer_id' => $id];
});
pl_action('support_status', function ($x) {
    $r = pl_api_own(pl_entity('support'), (int)($_REQUEST['id'] ?? 0), $x['uid']);
    if (!$r) return ['error' => 'Request not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    return ['request_code' => $r['request_code'], 'status' => $r['status'], 'assigned' => (bool)$r['assigned_to'], 'updated_at' => $r['updated_at'],
        'offers' => scalar("SELECT COUNT(*) FROM support_offers WHERE request_id=? AND status<>'closed'", [$r['id']]),
        'history' => array_map(fn($l) => ['status' => str_replace('status:', '', $l['action']), 'at' => $l['created_at']],
            rows("SELECT action, created_at FROM audit_log WHERE entity='support' AND entity_id=? AND action LIKE 'status:%' ORDER BY id", [$r['id']]))];
}, false, false);
pl_action('support_close', function ($x) {
    $r = pl_api_own(pl_entity('support'), (int)($_POST['id'] ?? $_POST['request_id'] ?? 0), $x['uid']);
    if (!$r) return ['error' => 'Request not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    if (in_array($r['status'], ['closed', 'resolved'], true)) return ['message' => 'This request is already closed.'];
    pl_entity_update(pl_entity('support'), (int)$r['id'], ['status' => 'closed']);
    pl_audit('status:closed', 'support', (int)$r['id'], 'Closed by the requester', (int)$r['community_id']);
    return ['message' => 'Your request has been closed.'];
});
pl_action('support_my_offers',fn($x) => ['offers' => array_map(fn($o) => ['id' => (int)$o['id'], 'request_id' => (int)$o['request_id'], 'request_title' => $o['title'], 'offer_type' => $o['offer_type'],
    'message' => $o['message'], 'status' => $o['status'], 'created_at' => $o['created_at']],
    rows('SELECT o.*, r.title FROM support_offers o LEFT JOIN support_requests r ON r.id=o.request_id WHERE o.user_id=? ORDER BY o.id DESC', [$x['uid']]))], false, false);
pl_action_nocomm('global_leaders_list'); pl_action_nocomm('global_leaders_search'); pl_action_nocomm('global_leaders_details');

/* ---------- Communities: details, selection, Home, About ---------- */

function pl_comm_out(array $c): array {
    return ['id' => (int)$c['id'], 'name' => $c['name'], 'slug' => $c['slug'], 'banner' => $c['banner'] ?? null, 'is_active' => (bool)$c['is_active']];
}
pl_action('community_details', function ($x) {
    $v = $_GET['id'] ?? $_GET['slug'] ?? null;
    $c = $v !== null ? (rows('SELECT * FROM communities WHERE is_active=1 AND (id=? OR slug=?)', [(int)$v, (string)$v])[0] ?? null) : $x['comm'];
    return $c ? ['community' => pl_comm_out($c) + ['welcome_text' => $c['welcome_text'] ?? null]] : ['error' => 'Community not found.', 'code' => 'NOT_FOUND', '_code' => 404];
}, true, false);
pl_action_nocomm('community_details');
pl_action('community_selected', fn($x) => ['community' => $x['comm'] ? pl_comm_out($x['comm']) : null, 'can_change' => !$x['user'] || $x['user']['role'] === 'admin' || empty($x['user']['community_id'])], true, false);
pl_action_nocomm('community_selected');
pl_action('community_select', function ($x) {
    $c = pl_community_by((string)($_POST['community'] ?? $_POST['slug'] ?? $_POST['community_id'] ?? ''));
    if (!$c && ctype_digit((string)($_POST['community_id'] ?? ''))) $c = rows('SELECT * FROM communities WHERE id=? AND is_active=1', [(int)$_POST['community_id']])[0] ?? null;
    if (!$c) return ['error' => 'Community not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    $u = $x['user'];
    if ($u && $u['role'] !== 'admin' && !empty($u['community_id']) && (int)$u['community_id'] !== (int)$c['id'])
        return ['error' => 'Your account belongs to another community. Please contact support to change it.', 'code' => 'COMMUNITY_LOCKED', '_code' => 403];
    if ($u && empty($u['community_id']) && $u['role'] !== 'admin') db()->prepare('UPDATE users SET community_id=? WHERE id=?')->execute([(int)$c['id'], (int)$u['id']]);
    $_SESSION['community_slug'] = $c['slug'];
    return ['message' => 'Community selected.', 'community' => pl_comm_out($c)];
}, true, true);
pl_action_nocomm('community_select');

pl_action('community_home', function ($x) {
    $c = $x['comm']; $cid = $x['cid']; $uid = $x['uid'];
    $mods = array_values(array_filter(explode(',', (string)($c['home_modules'] ?? '')))) ?: array_keys(PL_HOME_MODULES);
    $take = fn(string $k, int $n, array $f = [], ?string $w = null) => pl_ent_list(pl_entity($k), $cid, $f, $uid, 1, $n, $w, [])['items'];
    $sections = [];
    foreach ($mods as $m) switch ($m) {
        case 'matrimony': $s = pl_search($cid, [], 1, 6, $uid); $sections[] = ['module' => 'matrimony', 'title' => 'Matrimony', 'total' => $s['total'], 'items' => $s['profiles']]; break;
        case 'jobs': $sections[] = ['module' => 'jobs', 'title' => 'Latest Jobs', 'items' => $take('job', 6)]; break;
        case 'directory': $sections[] = ['module' => 'directory', 'title' => 'Professionals & Businesses', 'items' => $take('directory', 6, ['sort' => ''])]; break;
        case 'marketplace': $sections[] = ['module' => 'marketplace', 'title' => 'Marketplace', 'items' => $take('mp_listing', 6)]; break;
        case 'events': $sections[] = ['module' => 'events', 'title' => 'Upcoming Events', 'items' => $take('event', 6, ['sort' => 'date'], 't.event_date >= CURDATE()')]; break;
        case 'ads': $sections[] = ['module' => 'ads', 'title' => 'Advertisements', 'items' => $take('ad', 8)]; break;
        case 'support': $sections[] = ['module' => 'support', 'title' => 'Community Support', 'items' => $take('support', 4)]; break;
        case 'leadership': $sections[] = ['module' => 'leadership', 'title' => 'Community Leadership', 'items' => $take('community_leader', 8)]; break;
    }
    return ['community' => pl_comm_out($c) + ['welcome_text' => $c['welcome_text'] ?? null], 'sections' => $sections];
}, true, false);

$__about = fn($x, array $keys) => ['community' => pl_comm_out($x['comm']) + ['about_banner' => $x['comm']['about_banner'] ?? null]]
    + array_intersect_key(['about' => pl_paras($x['comm']['about'] ?? ''), 'introduction' => pl_paras($x['comm']['intro'] ?? ''), 'history' => pl_paras($x['comm']['history'] ?? '')], array_flip($keys));
pl_action('community_about', fn($x) => $__about($x, ['about', 'introduction', 'history']), true, false);
pl_action('community_introduction', fn($x) => $__about($x, ['introduction']), true, false);
pl_action('community_history', fn($x) => $__about($x, ['history']), true, false);
