<?php
// App API: Member & Family + Family Tree (connected: the tree is built on the family and its members).

function pl_my_member(int $uid, int $cid): ?array { return rows('SELECT * FROM members WHERE user_id=? AND community_id=? ORDER BY id DESC LIMIT 1', [$uid, $cid])[0] ?? null; }
function pl_my_family(int $uid, int $cid): ?array { return rows('SELECT * FROM families WHERE user_id=? AND community_id=? ORDER BY id DESC LIMIT 1', [$uid, $cid])[0] ?? null; }

/* privacy: 'public' = everyone, 'members' = logged-in members of the same community, 'private' = only the owner */
function pl_vis_ok(?string $vis, array $x, ?array $row): bool {
    if ($row && $x['uid'] && (int)$row['user_id'] === $x['uid']) return true;
    $vis = $vis ?: 'members';
    return $vis === 'public' || ($vis === 'members' && $x['uid'] && $row && (int)$row['community_id'] === $x['cid']);
}

function pl_member_out(array $r, array $x, bool $full = false): array {
    $E = pl_entity('member');
    $o = pl_ent_out($E, $r, $x['uid'], $full);
    if (!pl_vis_ok($r['contact_visibility'], $x, $r)) { foreach (['phone', 'email', 'address'] as $c) $o[$c] = null; $o['contact_hidden'] = true; }
    elseif ($x['uid']) { $o['phone'] = $r['phone']; $o['email'] = $r['email']; $o['address'] = $r['address']; unset($o['contact_hidden']); }
    if ((int)$r['user_id'] !== (int)$x['uid']) unset($o['dob']);
    $o['birthday'] = $r['dob'] ? date('d M', strtotime($r['dob'])) : null;
    return $o;
}

function pl_family_payload(array $fam, array $x, bool $own): array {
    $FE = pl_entity('family'); $ME = pl_entity('family_member'); $RE = pl_entity('tree_relation');
    $mw = $own ? '' : " AND status='approved' AND is_active=1";
    $members = rows("SELECT * FROM family_members WHERE family_id=?$mw ORDER BY is_head DESC, id", [$fam['id']]);
    $rels = rows("SELECT * FROM family_tree_relations WHERE family_id=?$mw ORDER BY id", [$fam['id']]);
    $out = pl_ent_out($FE, $fam, $x['uid'], true);
    if (!$own) unset($out['address'], $out['latitude'], $out['longitude']);
    if ($own) { $out['status'] = $fam['status']; $out['tree_status'] = $fam['tree_status']; }
    $out['members'] = array_map(fn($m) => pl_ent_out($ME, $m, $own ? $x['uid'] : null) + ($own ? ['status' => $m['status']] : []), $members);
    $out['relations'] = array_map(fn($r) => pl_ent_out($RE, $r, $own ? $x['uid'] : null) + ($own ? ['status' => $r['status']] : []), $rels);
    return $out;
}

/* ---------- member profile ---------- */

pl_action('member_profile', fn($x) => ['profile' => ($m = pl_my_member($x['uid'], $x['cid'])) ? pl_member_out($m, $x, true) + ['status' => $m['status']] : null], false, false);
pl_action('member_profile_save', function ($x) {
    $E = pl_entity('member'); $old = pl_my_member($x['uid'], $x['cid']);
    $in = $_POST; if (!$old) $in += ['full_name' => $x['user']['name'], 'email' => $x['user']['email'], 'phone' => $x['user']['phone'] ?? ''];
    [$cols, $err] = pl_entity_input($E, $in, $_FILES, false, $old, !$old);
    if ($err) return ['error' => $err, 'code' => 'VALIDATION_ERROR'];
    if (!$old) {
        $id = pl_entity_insert($E, $cols, ['community_id' => $x['cid'], 'user_id' => $x['uid'], 'created_by' => $x['uid'], 'status' => 'pending']);
        pl_audit('app_create', 'member', $id, $cols['full_name'] ?? '', $x['cid']);
        return ['message' => 'Member profile submitted for approval.', 'profile' => pl_member_out(pl_entity_row($E, $id), $x, true) + ['status' => 'pending']];
    }
    // name / photo changes need a fresh approval; other edits stay live
    if ($old['status'] === 'rejected' || (isset($cols['full_name']) && $cols['full_name'] !== $old['full_name']) || array_key_exists('photo', $cols)) $cols['status'] = 'pending';
    if (array_key_exists('photo', $cols)) pl_delete_file($old['photo']);
    pl_entity_update($E, (int)$old['id'], $cols);
    $m = pl_entity_row($E, (int)$old['id']);
    return ['message' => ($cols['status'] ?? '') === 'pending' ? 'Profile updated and sent for approval.' : 'Profile updated.', 'profile' => pl_member_out($m, $x, true) + ['status' => $m['status']]];
});
foreach (['member_search', 'member_list'] as $__a) pl_action($__a, function ($x) {
    $vis = $x['uid'] ? "t.profile_visibility IN ('public','members')" : "t.profile_visibility='public'";
    $r = pl_ent_list(pl_entity('member'), $x['cid'], $_GET + $_POST, $x['uid'], ...array_merge(pl_api_page(), [$vis . ($x['uid'] ? ' AND t.user_id<>?' : ''), $x['uid'] ? [$x['uid']] : []]));
    $ids = array_column($r['items'], 'id');
    $rows = $ids ? array_column(rows('SELECT * FROM members WHERE id IN (' . implode(',', array_map('intval', $ids)) . ')'), null, 'id') : [];
    $r['items'] = array_map(fn($i) => pl_member_out($rows[$i['id']], $x), $r['items']);
    return $r;
}, true, false);
pl_action('member_details', function ($x) {
    $E = pl_entity('member');
    $r = pl_api_visible($E, (int)($_REQUEST['id'] ?? 0), $x['cid'], $x['uid']);
    if (!$r || ($r['profile_visibility'] === 'private' && (int)$r['user_id'] !== $x['uid']) || !pl_vis_ok($r['profile_visibility'], $x, $r)) return ['error' => 'Member not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    $o = pl_member_out($r, $x, true);
    $fam = $r['user_id'] ? rows("SELECT * FROM families WHERE user_id=? AND community_id=? AND status='approved' AND is_active=1 ORDER BY id DESC LIMIT 1", [$r['user_id'], $r['community_id']])[0] ?? null : null;
    $o['family'] = $fam && pl_vis_ok($r['family_visibility'], $x, $r) ? pl_family_payload($fam, $x, false) : null;
    return ['member' => $o];
}, true, false);

/* ---------- family ---------- */

pl_action('family_details', function ($x) {
    if (empty($_GET['id'])) { $f = pl_my_family($x['uid'], $x['cid']); return ['family' => $f ? pl_family_payload($f, $x, true) : null]; }
    $f = rows("SELECT * FROM families WHERE id=? AND community_id=? AND status='approved' AND is_active=1", [(int)$_GET['id'], $x['cid']])[0] ?? null;
    $owner = $f ? pl_my_member((int)$f['user_id'], $x['cid']) : null;
    if (!$f || ($owner && !pl_vis_ok($owner['family_visibility'], $x, $owner))) return ['error' => 'Family not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    return ['family' => pl_family_payload($f, $x, (int)$f['user_id'] === $x['uid'])];
}, false, false);
pl_action('family_save', function ($x) {
    $E = pl_entity('family'); $old = pl_my_family($x['uid'], $x['cid']);
    [$cols, $err] = pl_entity_input($E, $_POST, $_FILES, false, $old, !$old);
    if ($err) return ['error' => $err, 'code' => 'VALIDATION_ERROR'];
    if (!$old) {
        $id = pl_entity_insert($E, $cols, ['community_id' => $x['cid'], 'user_id' => $x['uid'], 'created_by' => $x['uid'], 'status' => 'pending', 'tree_status' => 'none']);
        pl_audit('app_create', 'family', $id, $cols['family_name'] ?? '', $x['cid']);
        return ['message' => 'Family registered and sent for approval.', 'family' => pl_family_payload(pl_entity_row($E, $id), $x, true)];
    }
    if ($old['status'] === 'rejected') $cols['status'] = 'pending';
    pl_entity_update($E, (int)$old['id'], $cols);
    return ['message' => 'Family details updated.', 'family' => pl_family_payload(pl_entity_row($E, (int)$old['id']), $x, true)];
});
function pl_family_child_save(array $x, string $key, bool $create): array {
    $E = pl_entity($key);
    $fam = pl_my_family($x['uid'], $x['cid']);
    if (!$fam) return ['error' => 'Register your family first.', 'code' => 'PROFILE_REQUIRED'];
    $old = null;
    if (!$create) {
        $old = rows("SELECT * FROM {$E['table']} WHERE id=? AND family_id=?", [(int)($_POST['id'] ?? 0), $fam['id']])[0] ?? null;
        if (!$old) return ['error' => $E['label'] . ' not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    }
    $in = ['family_id' => $fam['id']] + $_POST; $in['family_id'] = $fam['id'];
    [$cols, $err] = pl_entity_input($E, $in, $_FILES, false, $old, $create);
    if ($err) return ['error' => $err, 'code' => 'VALIDATION_ERROR'];
    foreach (['person_member_id', 'related_member_id'] as $rc) if (!empty($cols[$rc]) && !scalar('SELECT COUNT(*) FROM family_members WHERE id=? AND family_id=?', [$cols[$rc], $fam['id']])) return ['error' => 'Choose a member of your family.', 'code' => 'VALIDATION_ERROR'];
    $cols['status'] = 'pending';
    if ($create) $id = pl_entity_insert($E, $cols, ['community_id' => $x['cid'], 'user_id' => $x['uid'], 'created_by' => $x['uid']]);
    else { if (array_key_exists('photo', $cols)) pl_delete_file($old['photo'] ?? null); $id = (int)$old['id']; pl_entity_update($E, $id, $cols); }
    if ($key === 'tree_relation' && in_array($fam['tree_status'], ['none', 'rejected', 'approved'], true)) db()->prepare("UPDATE families SET tree_status='pending' WHERE id=?")->execute([$fam['id']]);
    // supporting documents (JPG/PNG/PDF) of a family-tree request, e.g. documents[]
    $warn = null;
    if ($E['files'] && pl_files_list(pl_api_files($E))) $warn = pl_media_add($E, $id, pl_api_files($E), $x['uid'])['error'] ?? null;
    pl_audit($create ? 'app_create' : 'app_update', $key, $id, null, $x['cid']);
    return ['message' => $E['label'] . ($create ? ' added' : ' updated') . ' — waiting for approval.', 'item' => pl_ent_out($E, pl_entity_row($E, $id), $x['uid'], true) + ['status' => 'pending']]
        + ($warn ? ['upload_error' => $warn] : []);
}
function pl_family_child_delete(array $x, string $key): array {
    $E = pl_entity($key); $fam = pl_my_family($x['uid'], $x['cid']);
    $r = $fam ? rows("SELECT * FROM {$E['table']} WHERE id=? AND family_id=?", [(int)($_POST['id'] ?? 0), $fam['id']])[0] ?? null : null;
    if (!$r) return ['error' => $E['label'] . ' not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    pl_entity_delete($E, (int)$r['id']);
    if ($key === 'family_member') db()->prepare('DELETE FROM family_tree_relations WHERE family_id=? AND (person_member_id=? OR related_member_id=?)')->execute([$fam['id'], $r['id'], $r['id']]);
    pl_audit('app_delete', $key, (int)$r['id'], null, $x['cid']);
    return ['message' => $E['label'] . ' removed.'];
}
pl_action('family_member_add', fn($x) => pl_family_child_save($x, 'family_member', true));
pl_action('family_member_edit', fn($x) => pl_family_child_save($x, 'family_member', false));
pl_action('family_member_remove', fn($x) => pl_family_child_delete($x, 'family_member'));

/* ---------- privacy ---------- */

pl_action('privacy_settings', function ($x) {
    $m = pl_my_member($x['uid'], $x['cid']); $p = json_decode($x['user']['prefs'] ?? '', true) ?: [];
    return ['privacy' => ['profile_visibility' => $m['profile_visibility'] ?? ($p['profile_visibility'] ?? 'members'), 'contact_visibility' => $m['contact_visibility'] ?? 'members',
        'family_visibility' => $m['family_visibility'] ?? 'members', 'mobile_visibility' => $p['mobile_visibility'] ?? 'members', 'email_visibility' => $p['email_visibility'] ?? 'members'],
        'options' => ['profile_visibility' => PL_VISIBILITY, 'contact_visibility' => PL_CONTACT_VIS, 'family_visibility' => PL_CONTACT_VIS, 'mobile_visibility' => PL_CONTACT_VIS, 'email_visibility' => PL_CONTACT_VIS]];
}, false, false);
pl_action('privacy_settings_save', function ($x) {
    $set = [];
    foreach (['profile_visibility' => PL_VISIBILITY, 'contact_visibility' => PL_CONTACT_VIS, 'family_visibility' => PL_CONTACT_VIS, 'mobile_visibility' => PL_CONTACT_VIS, 'email_visibility' => PL_CONTACT_VIS] as $k => $opts)
        if (isset($_POST[$k])) { if (!isset($opts[$_POST[$k]])) return ['error' => 'Invalid value for ' . str_replace('_', ' ', $k) . '.', 'code' => 'VALIDATION_ERROR']; $set[$k] = $_POST[$k]; }
    if (!$set) return ['error' => 'Nothing to update.', 'code' => 'VALIDATION_ERROR'];
    $m = pl_my_member($x['uid'], $x['cid']);
    $mc = array_intersect_key($set, array_flip(['profile_visibility', 'contact_visibility', 'family_visibility']));
    if ($m && $mc) pl_entity_update(pl_entity('member'), (int)$m['id'], $mc);
    $p = array_merge(json_decode($x['user']['prefs'] ?? '', true) ?: [], $set);
    db()->prepare('UPDATE users SET prefs=? WHERE id=?')->execute([json_encode($p), $x['uid']]);
    return ['message' => 'Privacy settings saved.'];
});

$GLOBALS['PL_ACTIONS']['account_privacy'] = $GLOBALS['PL_ACTIONS']['privacy_settings'];
$GLOBALS['PL_ACTIONS']['account_privacy_save'] = $GLOBALS['PL_ACTIONS']['privacy_settings_save'];

pl_action('member_important_dates', function ($x) {
    $days = min(90, max(1, (int)($_GET['days'] ?? 30))); $out = [];
    foreach ([['members', "AND profile_visibility IN ('public','members')"], ['family_members', "AND COALESCE(life_status,'Living')='Living'"]] as [$t, $w])
        foreach (['dob' => 'birthday', 'anniversary' => 'anniversary'] as $col => $kind)
            foreach (rows("SELECT id, full_name, $col d FROM $t WHERE community_id=? AND status='approved' AND is_active=1 AND $col IS NOT NULL $w", [$x['cid']]) as $r) {
                $next = strtotime(date('Y') . substr($r['d'], 4)); if ($next < strtotime('today')) $next = strtotime((date('Y') + 1) . substr($r['d'], 4));
                $in = (int)round(($next - strtotime('today')) / 86400);
                if ($in <= $days) $out[] = ['type' => $kind, 'name' => $r['full_name'], 'source' => $t === 'members' ? 'member' : 'family_member', 'id' => (int)$r['id'], 'date' => date('m-d', $next), 'in_days' => $in];
            }
    usort($out, fn($a, $b) => $a['in_days'] <=> $b['in_days']);
    return ['dates' => $out];
}, false, false);

/* ---------- family tree ---------- */

pl_action('family_tree', function ($x) {
    if (empty($_GET['family_id']) && empty($_GET['id'])) {
        $f = pl_my_family($x['uid'], $x['cid']);
        return ['tree' => $f ? pl_family_payload($f, $x, true) + ['tree_info' => (json_decode($f['details'] ?? '', true) ?: [])['tree_info'] ?? new stdClass()] : null];
    }
    $f = rows("SELECT * FROM families WHERE id=? AND community_id=? AND status='approved' AND is_active=1 AND tree_status='approved' AND tree_active=1", [(int)($_GET['family_id'] ?? $_GET['id']), $x['cid']])[0] ?? null;
    $owner = $f ? pl_my_member((int)$f['user_id'], $x['cid']) : null;
    if (!$f || ($owner && !pl_vis_ok($owner['family_visibility'], $x, $owner))) return ['error' => 'Family tree not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    return ['tree' => pl_family_payload($f, $x, (int)$f['user_id'] === $x['uid'])];
}, false, false);
pl_action('tree_relation_add', fn($x) => pl_family_child_save($x, 'tree_relation', true));
pl_action('tree_relation_update', fn($x) => pl_family_child_save($x, 'tree_relation', false));
pl_action('tree_relation_delete', fn($x) => pl_family_child_delete($x, 'tree_relation'));
pl_action('tree_submit', function ($x) {
    $f = pl_my_family($x['uid'], $x['cid']);
    if (!$f) return ['error' => 'Register your family first.', 'code' => 'PROFILE_REQUIRED'];
    $info = pl_collect(array_diff_key($_POST, array_flip(['csrf', 'action', 'c', 'redirect'])));
    $d = json_decode($f['details'] ?? '', true) ?: [];
    $d['tree_info'] = array_merge($d['tree_info'] ?? [], $info); $d['tree_submitted_at'] = date('c');
    db()->prepare("UPDATE families SET details=?, tree_status='pending' WHERE id=?")->execute([json_encode($d, JSON_UNESCAPED_UNICODE), $f['id']]);
    pl_audit('app_tree_submit', 'family_tree', (int)$f['id'], null, $x['cid']);
    return ['message' => 'Family tree information submitted for approval.', 'tree_status' => 'pending'];
});
pl_action('tree_member_details', function ($x) {
    $m = rows('SELECT fm.*, f.user_id fam_user, f.status fam_status, f.tree_status, f.tree_active FROM family_members fm JOIN families f ON f.id=fm.family_id WHERE fm.id=? AND fm.community_id=?', [(int)($_GET['id'] ?? 0), $x['cid']])[0] ?? null;
    $own = $m && (int)$m['fam_user'] === $x['uid'];
    if (!$m || (!$own && ($m['status'] !== 'approved' || !$m['is_active'] || $m['fam_status'] !== 'approved'))) return ['error' => 'Family member not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    $o = pl_ent_out(pl_entity('family_member'), $m, $own ? $x['uid'] : null, true);
    $o['relations'] = array_map(fn($r) => ['id' => (int)$r['id'], 'relation' => $r['relation'], 'person_name' => $r['person_name'], 'related_name' => $r['related_name']],
        rows('SELECT * FROM family_tree_relations WHERE (person_member_id=? OR related_member_id=?)' . ($own ? '' : " AND status='approved'"), [$m['id'], $m['id']]));
    return ['member' => $o];
}, false, false);
pl_action('tree_relationship_types', fn($x) => ['tree_relations' => PL_TREE_RELATIONS, 'family_relationships' => PL_RELATIONS], true, false);
pl_action_nocomm('tree_relationship_types');
pl_action('tree_status', function ($x) {
    $f = pl_my_family($x['uid'], $x['cid']);
    if (!$f) return ['family' => null, 'tree_status' => 'none'];
    return ['family_id' => (int)$f['id'], 'family_status' => $f['status'], 'tree_status' => $f['tree_status'], 'tree_active' => (bool)$f['tree_active'],
        'pending_members' => scalar("SELECT COUNT(*) FROM family_members WHERE family_id=? AND status='pending'", [$f['id']]),
        'pending_relations' => scalar("SELECT COUNT(*) FROM family_tree_relations WHERE family_id=? AND status='pending'", [$f['id']]),
        'rejected_relations' => scalar("SELECT COUNT(*) FROM family_tree_relations WHERE family_id=? AND status='rejected'", [$f['id']])];
}, false, false);
