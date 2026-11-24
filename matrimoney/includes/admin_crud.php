<?php
// Generic admin screens for every entity in PL_ENTITIES: list (tabs, search, community filter, pagination),
// view (details, images, child records, enquiries, reports, activity), add/edit form and all row actions.
require_once __DIR__ . '/bridge.php';
require_once __DIR__ . '/layout.php';

const PL_ADMIN_PER = 25;

function pl_here(): string { return basename($_SERVER['SCRIPT_NAME']) . (($_SERVER['QUERY_STRING'] ?? '') !== '' ? '?' . $_SERVER['QUERY_STRING'] : ''); }

function pl_ret(string $fallback): string {
    $r = (string)($_POST['ret'] ?? '');
    return preg_match('#^[a-z0-9\-]+\.php(\?[^\s<>"]*)?$#i', $r) ? $r : $fallback;
}

function pl_go(string $url): void { header('Location: ' . $url); exit; }

function pl_url(array $q, string $page = 'manage.php'): string { return $page . '?' . http_build_query(array_filter($q, fn($v) => $v !== '' && $v !== null)); }

function pl_csrf_field(): string { return '<input type="hidden" name="csrf" value="' . csrf_token() . '">'; }

/* small POST button */
function pl_btn(string $ent, int $id, string $act, string $label, string $cls = 'btn-line', string $confirm = '', array $extra = []): string {
    $h = '<form class="inline" method="post" action="manage.php"' . ($confirm ? ' data-confirm="' . e($confirm) . '"' : '') . '>' . pl_csrf_field()
        . '<input type="hidden" name="ent" value="' . e($ent) . '"><input type="hidden" name="id" value="' . $id . '"><input type="hidden" name="action" value="' . e($act) . '">'
        . '<input type="hidden" name="ret" value="' . e(pl_here()) . '">';
    foreach ($extra as $k => $v) $h .= '<input type="hidden" name="' . e($k) . '" value="' . e($v) . '">';
    return $h . '<button class="btn btn-sm ' . $cls . '">' . $label . '</button></form>';
}

function pl_status_badge(string $s): string {
    $map = ['in_progress' => 'open', 'resolved' => 'approved', 'offered' => 'open', 'connected' => 'accepted', 'none' => 'inactive', 'new' => 'open', 'replied' => 'accepted',
        'created' => 'pending', 'paid' => 'paid', 'refunded' => 'warned', 'reviewed' => 'approved', 'dismissed' => 'closed', 'deactivated' => 'inactive', 'suspended' => 'rejected', 'deleted' => 'rejected'];
    return badge($map[$s] ?? $s, pl_status_label($s));
}

function pl_fmt(array $E, string $col, $v, array $ctx = []): string {
    $f = $E['fields'][$col] ?? null;
    if ($v === null || $v === '') return '<span class="muted">—</span>';
    if (!$f) return e($v);
    switch ($f['type']) {
        case 'category': case 'subcategory': return e(pl_cat_names()[$v] ?? '#' . $v);
        case 'money': return money($v);
        case 'bool': return $v ? 'Yes' : 'No';
        case 'date': return dshort($v);
        case 'datetime': return e(date('d M Y, H:i', strtotime($v)));
        case 'time': return e(date('h:i A', strtotime($v)));
        case 'select': return e(pl_opts($f)[$v] ?? $v);
        case 'url': return '<a class="lnk" href="' . e($v) . '" target="_blank" rel="noopener">' . e(mb_strimwidth($v, 0, 40, '…')) . '</a>';
        case 'image': return '<img class="thumb" src="' . e(pl_thumb($v)) . '" alt="">';
        case 'email': return '<a class="lnk" href="mailto:' . e($v) . '">' . e($v) . '</a>';
        case 'textarea': return nl2br(e($v));
        case 'parent':
            $PE = pl_entity($E['parent'][0]);
            $t = $ctx['parents'][$v] ?? null;
            return '<a class="lnk" href="' . e(pl_url(['e' => $PE['key'], 'view' => $v])) . '">' . e($t ?? '#' . $v) . '</a>';
        case 'ref':
            if ($col === 'package_id') return e(rows('SELECT name FROM packages WHERE id=?', [$v])[0]['name'] ?? '#' . $v);
            return '#' . (int)$v;
    }
    return e($v);
}

function pl_parent_titles(array $E, array $list): array {
    if (!$E['parent']) return [];
    [$pk, $fk] = $E['parent'];
    $ids = array_values(array_unique(array_filter(array_map('intval', array_column($list, $fk)))));
    if (!$ids) return [];
    $PE = pl_entity($pk);
    return array_column(rows("SELECT id, {$PE['title']} t FROM {$PE['table']} WHERE id IN (" . implode(',', $ids) . ')'), 't', 'id');
}

/* ---------- filters ---------- */

function pl_admin_scope(array $E, int $cid, array &$a, array $g): string {
    if ($E['scope'] === 'global') return '';
    $cf = (string)($g['cf'] ?? ''); $vis = (string)($g['vis'] ?? '');
    if ($E['scope'] === 'mixed' && $vis === 'global') return " AND t.visibility_type='global'";
    if ($cf === 'all') return $E['scope'] === 'mixed' && $vis === 'community' ? " AND t.visibility_type='community'" : '';
    $a[] = ctype_digit($cf) ? (int)$cf : $cid;
    if ($E['scope'] === 'mixed') return $vis === 'community' ? " AND t.visibility_type='community' AND t.community_id=?" : " AND (t.community_id=? OR t.visibility_type='global')";
    return ' AND t.community_id=?';
}

function pl_admin_tabs(array $E): array {
    $sc = $E['status_col']; $ac = $E['active_col'];
    $t = ['' => ['All', '1=1']];
    foreach ($E['statuses'] as $s) if (!($s === 'closed' && $E['closable'])) $t[$s] = [pl_status_label($s), "t.$sc='$s'"];
    $t['active'] = ['Active', "t.$ac=1"];
    $t['inactive'] = ['Inactive', "t.$ac=0"];
    if ($E['expires'] || $E['closable']) {
        $x = [];
        if ($E['expires']) $x[] = "t.{$E['expires']} < " . ($E['fields'][$E['expires']]['type'] === 'date' ? 'CURDATE()' : 'NOW()');
        if ($E['closable']) $x[] = "t.$sc='closed'";
        $t['expired'] = [$E['closable'] ? ($E['expires'] ? 'Expired / Closed' : 'Closed') : 'Expired', '(' . implode(' OR ', $x) . ')'];
    }
    if ($E['featured']) $t['featured'] = ['Featured', 't.is_featured=1'];
    foreach ($E['tabs'] as $k => [$l, $sql]) $t[$k] = [$l, $sql];
    return $t;
}

function pl_admin_base(array $E, int $cid, array &$a, array $g): string {
    $w = '1=1';
    foreach ($E['fixed'] as $k => $v) { $w .= " AND t.$k=?"; $a[] = $v; }
    if (!empty($E['base_where'])) $w .= ' AND ' . $E['base_where'];
    $w .= pl_admin_scope($E, $cid, $a, $g);
    if ($E['parent'] && !empty($g['parent'])) { $w .= " AND t.{$E['parent'][1]}=?"; $a[] = (int)$g['parent']; }
    if (!empty($g['cat']) && $E['cat']) {
        $cols = array_keys(array_filter($E['fields'], fn($f) => in_array($f['type'], ['category', 'subcategory'], true)));
        $w .= ' AND (' . implode(' OR ', array_map(fn($c) => "t.$c=?", $cols)) . ')'; foreach ($cols as $_) $a[] = (int)$g['cat'];
    }
    foreach ($E['fields'] as $col => $f) if ($f['type'] === 'select' && !empty($f['filter']) && ($g['f_' . $col] ?? '') !== '') { $w .= " AND t.$col=?"; $a[] = (string)$g['f_' . $col]; }
    $q = trim((string)($g['q'] ?? ''));
    if ($q !== '') {
        $cols = array_merge($E['search'] ?: [$E['title']], $E['code'] ? [$E['code'][0]] : []);
        $w .= ' AND (' . implode(' OR ', array_map(fn($c) => "t.$c LIKE ?", $cols)) . (ctype_digit($q) ? ' OR t.id=?' : '') . ')';
        foreach ($cols as $_) $a[] = "%$q%";
        if (ctype_digit($q)) $a[] = (int)$q;
    }
    return $w;
}

/* count of an entity in the admin's community (global rows included for mixed scope) */
function pl_count(string $key, int $cid, string $sql = '1=1'): int {
    $E = pl_entity($key); $a = [];
    $w = pl_admin_base($E, $cid, $a, []);
    return scalar("SELECT COUNT(*) FROM {$E['table']} t WHERE $w AND $sql", $a);
}

function pl_stat_cards(array $cards): string {
    $colors = ['c-blue', 'c-orange', 'c-purple', 'c-red'];
    $h = '<div class="stats anim' . (count($cards) > 4 ? ' many' : '') . '">';
    foreach (array_values($cards) as $i => [$label, $n, $ic]) {
        $pre = is_array($n) ? $n[1] : ''; $n = is_array($n) ? $n[0] : $n;
        $h .= '<div class="stat ' . $colors[$i % 4] . '"><div class="ic">' . icon($ic) . '</div><div class="n" data-count="' . (float)$n . '"' . ($pre ? ' data-prefix="' . e($pre) . '"' : '') . '>0</div><div class="l">' . e($label) . '</div></div>';
    }
    return $h . '</div>';
}

/* ---------- actions ---------- */

function pl_admin_set_status(array $E, array $row, string $new, array $admin): ?string {
    if (!in_array($new, $E['statuses'], true)) return 'Invalid status.';
    if ($E['key'] === 'ad' && $new === 'approved' && pl_setting('ads_require_payment') && ($row['payment_status'] ?? '') !== 'paid') return 'This advertisement is not paid yet (Settings: ads need a paid package).';
    $set = [$E['status_col'] => $new];
    if (in_array($new, ['approved', 'in_progress', 'connected'], true) && empty($row['approved_by'])) { $set['approved_by'] = (int)$admin['id']; $set['approved_at'] = date('Y-m-d H:i:s'); }
    if ($new === 'approved' && !empty($E['expiry_setting']) && $E['expires'] && empty($row[$E['expires']])) $set[$E['expires']] = date('Y-m-d H:i:s', strtotime('+' . max(1, pl_setting($E['expiry_setting'])) . ' days'));
    if (in_array($new, ['closed', 'resolved'], true)) $set['closed_at'] = date('Y-m-d H:i:s');
    if ($E['key'] === 'tree_relation' && $new === 'approved') db()->prepare("UPDATE families SET tree_status='approved' WHERE id=? AND tree_status IN ('none','pending')")->execute([(int)$row['family_id']]);
    // approving a family registration also approves what was submitted with it: its pending members and the head's member profile
    if ($E['key'] === 'family' && $new === 'approved') {
        db()->prepare("UPDATE family_members SET status='approved', approved_by=?, approved_at=NOW() WHERE family_id=? AND status='pending'")->execute([(int)$admin['id'], (int)$row['id']]);
        if (!empty($row['user_id'])) db()->prepare("UPDATE members SET status='approved', approved_by=?, approved_at=NOW() WHERE user_id=? AND community_id=? AND status='pending'")->execute([(int)$admin['id'], (int)$row['user_id'], (int)$row['community_id']]);
    }
    pl_entity_update($E, (int)$row['id'], $set);
    pl_audit('status:' . $new, $E['key'], (int)$row['id'], pl_entity_title($E, $row), $row['community_id'] ? (int)$row['community_id'] : null);
    if ($E['key'] === 'job_application') { if ($new !== $row['status']) pl_job_app_status_changed($row, $new, false); return null; }
    $owner = (int)($row['user_id'] ?? 0);
    if ($owner && $new !== ($row[$E['status_col']] ?? '')) {
        $t = pl_entity_title($E, $row);
        $msg = ['approved' => "Your {$E['label']} \"$t\" has been approved.", 'rejected' => "Your {$E['label']} \"$t\" was not approved. Please review and resubmit.",
            'in_progress' => "Your request \"$t\" is now being processed.", 'resolved' => "Your request \"$t\" has been resolved.", 'closed' => "Your {$E['label']} \"$t\" has been closed."][$new]
            ?? "Your {$E['label']} \"$t\" status is now " . pl_status_label($new) . '.';
        pl_notify_user($owner, $row['community_id'] ? (int)$row['community_id'] : null, $E['label'] . ' ' . pl_status_label($new), $msg, 'approval', $E['table'], (int)$row['id']);
        if ($E['key'] === 'support') pl_sms($row['phone'] ?? rows('SELECT phone FROM users WHERE id=?', [$owner])[0]['phone'] ?? null, 'PeopleLink: ' . $msg);
    }
    return null;
}

function pl_admin_handle_post(array $user, array $comm): void {
    csrf_check();
    $E = pl_entity((string)($_POST['ent'] ?? ''));
    if (!$E) { flash('Unknown module.', 'error'); pl_go('overview.php'); }
    $id = (int)($_POST['id'] ?? 0); $act = (string)($_POST['action'] ?? '');
    $ret = pl_ret(pl_url(['e' => $E['key']]));
    if ($act === 'save') pl_admin_save($E, $id, $user, $comm);
    $row = $id ? pl_entity_row($E, $id) : null;
    if (!$row) { flash(($E['label']) . ' not found.', 'error'); pl_go($ret); }
    $t = pl_entity_title($E, $row); $rc = $row['community_id'] ? (int)$row['community_id'] : null;
    switch ($act) {
        case 'approve': case 'reject': case 'status':
            $new = $act === 'status' ? (string)($_POST['value'] ?? '') : ($act === 'approve' ? ($E['statuses'][1] ?? 'approved') : 'rejected');
            if ($act === 'approve' && in_array('approved', $E['statuses'], true)) $new = 'approved';
            $err = pl_admin_set_status($E, $row, $new, $user);
            flash($err ?? "$t: " . pl_status_label($new), $err ? 'error' : 'success'); break;
        case 'activate': case 'deactivate':
            pl_entity_update($E, $id, [$E['active_col'] => $act === 'activate' ? 1 : 0]);
            pl_audit($act, $E['key'], $id, $t, $rc); flash("$t " . ($act === 'activate' ? 'activated' : 'deactivated')); break;
        case 'feature': case 'unfeature':
            pl_entity_update($E, $id, ['is_featured' => $act === 'feature' ? 1 : 0]);
            pl_audit($act, $E['key'], $id, $t, $rc); flash("$t " . ($act === 'feature' ? 'marked as featured' : 'removed from featured')); break;
        case 'close':
            pl_admin_set_status($E, $row, 'closed', $user); flash("$t closed"); break;
        case 'delete':
            pl_entity_delete($E, $id); pl_audit('delete', $E['key'], $id, $t, $rc); flash("$t deleted");
            if (str_contains($ret, 'view=' . $id)) $ret = pl_url(['e' => $E['key']]);
            break;
        case 'notes':
            pl_entity_update($E, $id, ['admin_notes' => mb_substr(trim((string)($_POST['admin_notes'] ?? '')), 0, 5000)] + (isset($_POST['assigned_to']) && isset($E['fields']['assigned_to']) ? ['assigned_to' => mb_substr(trim((string)$_POST['assigned_to']), 0, 255)] : []));
            pl_audit('notes', $E['key'], $id, null, $rc); flash('Notes saved'); break;
        case 'order':
            pl_entity_update($E, $id, ['sort_order' => (int)($_POST['sort_order'] ?? 0)]); flash('Display order saved'); break;
        case 'media_add':
            $r = pl_media_add($E, $id, $_FILES, (int)$user['id']); flash($r['error'] ?? $r['message'], empty($r['error']) ? 'success' : 'error');
            if (empty($r['error'])) pl_audit('media_add', $E['key'], $id, null, $rc); break;
        case 'media_delete':
            flash(pl_media_delete($E, $id, (int)($_POST['media_id'] ?? 0)) ? 'File removed' : 'File not found.'); pl_audit('media_delete', $E['key'], $id, null, $rc); break;
        case 'media_primary':
            flash(pl_media_primary($E, $id, (int)($_POST['media_id'] ?? 0)) ? 'Main image updated' : 'File not found.'); break;
        default: flash('Unknown action.', 'error');
    }
    pl_go($ret);
}

function pl_admin_save(array $E, int $id, array $user, array $comm): void {
    $old = $id ? pl_entity_row($E, $id) : null;
    $back = pl_url(['e' => $E['key'], 'edit' => $id ?: '0', 'parent' => $_POST['parent_ref'] ?? '']);
    if ($id && !$old) { flash('Record not found.', 'error'); pl_go(pl_url(['e' => $E['key']])); }
    [$cols, $err] = pl_entity_input($E, $_POST, $_FILES, true, $old, true);
    if (!$err && $E['parent']) {
        [$pk, $fk] = $E['parent']; $PE = pl_entity($pk);
        $pid = $cols[$fk] ?? ($old[$fk] ?? null);
        $prow = $pid ? pl_entity_row($PE, (int)$pid) : null;
        if (!$prow) $err = 'Choose a valid ' . $E['fields'][$fk]['label'] . '.';
        else $_POST['community_id'] = $prow['community_id'];
    }
    if ($err) { flash($err, 'error'); $_SESSION['pl_form'] = $_POST; pl_go($back); }
    $meta = [];
    if ($E['scope'] !== 'global') {
        $c = (int)($_POST['community_id'] ?? $comm['id']);
        $meta['community_id'] = scalar('SELECT COUNT(*) FROM communities WHERE id=?', [$c]) ? $c : (int)$comm['id'];
    } else $meta['community_id'] = null;
    $meta['visibility_type'] = $E['scope'] === 'global' ? 'global' : ($E['scope'] === 'mixed' && ($_POST['visibility_type'] ?? '') === 'global' ? 'global' : 'community');
    if ($E['statuses'] && in_array($_POST['status_value'] ?? '', $E['statuses'], true)) $meta[$E['status_col']] = $_POST['status_value'];
    $meta[$E['active_col']] = empty($_POST['active_value']) ? 0 : 1;
    if ($E['featured']) $meta['is_featured'] = empty($_POST['is_featured']) ? 0 : 1;
    if ($E['ordered']) $meta['sort_order'] = (int)($_POST['sort_order'] ?? 0);
    if ($id) {
        foreach ($E['fields'] as $col => $f) if ($f['type'] === 'image' && array_key_exists($col, $cols) && ($old[$col] ?? null) !== $cols[$col]) pl_delete_file($old[$col] ?? null);
        $newStatus = $meta[$E['status_col']] ?? null; unset($meta[$E['status_col']]);
        pl_entity_update($E, $id, $cols + $meta);
        if ($newStatus && $newStatus !== $old[$E['status_col']]) pl_admin_set_status($E, pl_entity_row($E, $id), $newStatus, $user);
        pl_audit('update', $E['key'], $id, array_keys($cols), $meta['community_id']);
    } else {
        if ($E['statuses'] && !isset($meta[$E['status_col']])) $meta[$E['status_col']] = in_array('approved', $E['statuses'], true) ? 'approved' : $E['statuses'][0];
        if ($E['statuses']) { $meta['approved_by'] = (int)$user['id']; $meta['approved_at'] = date('Y-m-d H:i:s'); }
        if (!empty($E['expiry_setting']) && $E['expires'] && empty($cols[$E['expires']])) $cols[$E['expires']] = date('Y-m-d H:i:s', strtotime('+' . max(1, pl_setting($E['expiry_setting'])) . ' days'));
        $meta['created_by'] = (int)$user['id'];
        $id = pl_entity_insert($E, $cols, $meta);
        pl_audit('create', $E['key'], $id, pl_entity_title($E, $cols), $meta['community_id']);
    }
    if ($E['key'] === 'directory') pl_geo_fill($E, $id); // no coordinates entered: look them up from the address
    if (($E['gallery'] || $E['files']) && !empty($_FILES['gallery']) && pl_files_list(['gallery' => $_FILES['gallery']])) {
        $r = pl_media_add($E, $id, ['gallery' => $_FILES['gallery']], (int)$user['id']);
        if (!empty($r['error'])) { flash('Saved, but: ' . $r['error'], 'error'); pl_go(pl_url(['e' => $E['key'], 'view' => $id])); }
    }
    flash($E['label'] . ' saved');
    pl_go(pl_url(['e' => $E['key'], 'view' => $id]));
}

/* ---------- form controls ---------- */

function pl_admin_control(array $E, string $col, array $f, $val, array $ctx): string {
    $n = e($col); $v = e($val ?? ''); $req = !empty($f['req']) && $f['type'] !== 'image' ? ' required' : '';
    switch ($f['type']) {
        case 'textarea': return "<textarea name=\"$n\" rows=\"4\"$req>$v</textarea>";
        case 'select':
            $h = "<select name=\"$n\"$req><option value=\"\">— Select —</option>";
            foreach (pl_opts($f) as $k => $l) $h .= '<option value="' . e($k) . '"' . ((string)$val === (string)$k ? ' selected' : '') . '>' . e($l) . '</option>';
            return $h . '</select>';
        case 'bool': return "<label class=\"chk\"><input type=\"checkbox\" name=\"$n\" value=\"1\"" . ($val ? ' checked' : '') . '> ' . e($f['label']) . '</label>';
        case 'category': case 'subcategory':
            $sub = $f['type'] === 'subcategory';
            $h = '<select name="' . $n . '" data-cat="' . ($sub ? 'sub' : 'main') . '"' . $req . '><option value="">— Select —</option>';
            foreach ($ctx['cats'] as $c) {
                if (!$sub) $h .= '<option value="' . (int)$c['id'] . '"' . ((int)$val === (int)$c['id'] ? ' selected' : '') . '>' . e($c['name']) . '</option>';
                else foreach ($c['subcategories'] as $s) $h .= '<option data-parent="' . (int)$c['id'] . '" value="' . (int)$s['id'] . '"' . ((int)$val === (int)$s['id'] ? ' selected' : '') . '>' . e($s['name']) . '</option>';
            }
            return $h . '</select>';
        case 'parent':
            $h = "<select name=\"$n\"$req><option value=\"\">— Select —</option>";
            foreach ($ctx['parent_opts'] as $pid => $pt) $h .= '<option value="' . (int)$pid . '"' . ((int)$val === (int)$pid ? ' selected' : '') . '>' . e($pt) . ' (#' . (int)$pid . ')</option>';
            return $h . '</select>';
        case 'image':
            return ($val ? '<div class="imgrow"><img class="thumb lg" src="' . e(pl_thumb($val)) . '" alt=""><label class="chk"><input type="checkbox" name="remove_' . $n . '" value="1"> Remove</label></div>' : '')
                . '<input type="file" name="' . $n . '" accept="image/jpeg,image/png,image/webp">';
        case 'date': return "<input type=\"date\" name=\"$n\" value=\"$v\"$req>";
        case 'time': return '<input type="time" name="' . $n . '" value="' . e($val ? substr((string)$val, 0, 5) : '') . "\"$req>";
        case 'datetime': return '<input type="datetime-local" name="' . $n . '" value="' . e($val ? date('Y-m-d\TH:i', strtotime((string)$val)) : '') . "\"$req>";
        case 'money': return "<input type=\"number\" step=\"0.01\" min=\"0\" name=\"$n\" value=\"$v\"$req>";
        case 'int': case 'ref': return "<input type=\"number\" step=\"1\" min=\"0\" name=\"$n\" value=\"$v\"$req>";
        case 'lat': case 'lng': return "<input type=\"number\" step=\"0.0000001\" name=\"$n\" value=\"$v\"$req>";
        case 'email': return "<input type=\"email\" name=\"$n\" value=\"$v\"$req>";
        case 'url': return "<input type=\"url\" name=\"$n\" value=\"$v\" placeholder=\"https://\"$req>";
        case 'phone': return "<input type=\"tel\" name=\"$n\" value=\"$v\"$req>";
    }
    return "<input name=\"$n\" value=\"$v\"$req>";
}

function pl_community_select(string $name, $selected, bool $withAll = false, string $allLabel = 'All communities'): string {
    $h = '<select name="' . e($name) . '">' . ($withAll ? '<option value="all"' . ($selected === 'all' ? ' selected' : '') . '>' . e($allLabel) . '</option>' : '');
    foreach (rows('SELECT id, name FROM communities ORDER BY sort_order, name') as $c) $h .= '<option value="' . (int)$c['id'] . '"' . ((string)$selected === (string)$c['id'] ? ' selected' : '') . '>' . e($c['name']) . '</option>';
    return $h . '</select>';
}

function pl_pager(int $page, int $pages): string {
    if ($pages <= 1) return '';
    $q = $_GET; $h = '<div class="pager">';
    foreach ([['‹ Prev', $page - 1, $page > 1], ['Next ›', $page + 1, $page < $pages]] as [$l, $p, $on]) {
        $q['page'] = $p;
        $h .= $on ? '<a class="btn btn-sm btn-line" href="?' . e(http_build_query($q)) . '">' . $l . '</a>' : '';
        if ($l === '‹ Prev') $h .= '<span class="muted">Page ' . $page . ' of ' . $pages . '</span>';
    }
    return $h . '</div>';
}

/* ---------- screens ---------- */

function pl_admin_manage(string $key, array $user, array $comm): void {
    $E = pl_entity($key);
    if (!$E) { http_response_code(404); exit('Unknown module.'); }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') pl_admin_handle_post($user, $comm);
    if (isset($_GET['edit'])) { pl_admin_edit($E, (int)$_GET['edit'], $user, $comm); return; }
    if (isset($_GET['view'])) { pl_admin_view($E, (int)$_GET['view'], $user, $comm); return; }
    pl_admin_list($E, $user, $comm);
}

function pl_admin_row_actions(array $E, array $r, bool $compact = true): string {
    $id = (int)$r['id']; $k = $E['key']; $st = $r[$E['status_col']] ?? '';
    $h = '<div class="actions">';
    if ($compact) $h .= '<a class="btn btn-sm btn-line" href="' . e(pl_url(['e' => $k, 'view' => $id])) . '">' . icon('fa-eye') . ' View</a>';
    if ($E['statuses'] === ['pending', 'approved', 'rejected'] || $E['statuses'] === ['pending', 'approved', 'rejected', 'closed']) {
        if ($st !== 'approved' && $st !== 'closed') $h .= pl_btn($k, $id, 'approve', icon('fa-check') . ' Approve', 'btn-blue');
        if ($st !== 'rejected' && $st !== 'closed') $h .= pl_btn($k, $id, 'reject', icon('fa-xmark') . ' Reject', 'btn-red', 'Reject this ' . strtolower($E['label']) . '?');
        if ($E['closable'] && $st === 'approved' && !$compact) $h .= pl_btn($k, $id, 'close', 'Close', 'btn-line', 'Close this listing?');
    } elseif ($E['statuses']) {
        $h .= '<form class="inline" method="post" action="manage.php">' . pl_csrf_field() . '<input type="hidden" name="ent" value="' . e($k) . '"><input type="hidden" name="id" value="' . $id . '">'
            . '<input type="hidden" name="action" value="status"><input type="hidden" name="ret" value="' . e(pl_here()) . '"><select name="value" class="sel-sm" onchange="this.form.submit()">';
        foreach ($E['statuses'] as $s) $h .= '<option value="' . e($s) . '"' . ($s === $st ? ' selected' : '') . '>' . e(pl_status_label($s)) . '</option>';
        $h .= '</select></form>';
    }
    $h .= $r[$E['active_col']] ? pl_btn($k, $id, 'deactivate', 'Deactivate', 'btn-orange', 'Deactivate this ' . strtolower($E['label']) . '?') : pl_btn($k, $id, 'activate', 'Activate', 'btn-line');
    if ($E['featured'] && !$compact) $h .= $r['is_featured'] ? pl_btn($k, $id, 'unfeature', icon('fa-star') . ' Unfeature', 'btn-line') : pl_btn($k, $id, 'feature', icon('fa-star') . ' Feature', 'btn-line');
    $h .= '<a class="btn btn-sm btn-line" href="' . e(pl_url(['e' => $k, 'edit' => $id])) . '">' . icon('fa-pen') . ($compact ? '' : ' Edit') . '</a>';
    if (!$compact) $h .= pl_btn($k, $id, 'delete', icon('fa-trash') . ' Delete', 'btn-red', 'Delete this ' . strtolower($E['label']) . ' permanently? This cannot be undone.');
    return $h . '</div>';
}

function pl_admin_table(array $E, array $list, bool $showComm, bool $actions = true): string {
    if (!$list) return '<div class="empty">' . icon($E['icon'], 'big') . 'No ' . e(strtolower($E['plural'])) . ' found.' . (!empty($E['empty_hint']) ? '<br><small style="display:block;margin-top:6px;opacity:.75">' . e($E['empty_hint']) . '</small>' : '') . '</div>';
    $ctx = ['parents' => pl_parent_titles($E, $list)];
    $covers = pl_ent_covers($E, array_column($list, 'id'));
    $h = '<div class="tw"><table class="rt"><thead><tr><th>' . e($E['label']) . '</th>';
    foreach ($E['list'] as $c) $h .= '<th>' . e($E['fields'][$c]['label'] ?? pl_status_label($c)) . '</th>';
    if ($showComm) $h .= '<th>Community</th>';
    $h .= ($E['statuses'] ? '<th>Status</th>' : '') . '<th>Visibility</th><th>Created</th>' . ($actions ? '<th>Actions</th>' : '') . '</tr></thead><tbody>';
    $names = pl_community_names();
    foreach ($list as $r) {
        $title = pl_entity_title($E, $r);
        $img = $E['thumb'] && !empty($r[$E['thumb']]) ? pl_thumb($r[$E['thumb']]) : ($covers[$r['id']] ?? null);
        $sub = '';
        if ($E['sub']) $sub = ($E['fields'][$E['sub']]['type'] ?? '') === 'select' ? (pl_opts($E['fields'][$E['sub']])[$r[$E['sub']]] ?? $r[$E['sub']]) : ($r[$E['sub']] ?? '');
        $h .= '<tr><td data-label="' . e($E['label']) . '"><a class="person" href="' . e(pl_url(['e' => $E['key'], 'view' => $r['id']])) . '">'
            . ($img ? '<img class="pi" src="' . e($img) . '" alt="">' : '<div class="pi">' . e(mb_strtoupper(mb_substr($title, 0, 1))) . '</div>')
            . '<div><b>' . e($title) . '</b>' . ($E['featured'] && $r['is_featured'] ? ' ' . icon('fa-star', 'star') : '') . '<br><small>' . e($sub ?: '#' . $r['id']) . '</small></div></a></td>';
        foreach ($E['list'] as $c) $h .= '<td data-label="' . e($E['fields'][$c]['label'] ?? $c) . '">' . (isset($E['fields'][$c]) ? pl_fmt($E, $c, $r[$c] ?? null, $ctx) : pl_status_badge((string)($r[$c] ?? ''))) . '</td>';
        if ($showComm) $h .= '<td data-label="Community">' . ($r['visibility_type'] === 'global' ? badge('active', 'Global') : e($names[$r['community_id']] ?? '—')) . '</td>';
        if ($E['statuses']) $h .= '<td data-label="Status">' . pl_status_badge((string)$r[$E['status_col']]) . '</td>';
        $h .= '<td data-label="Visibility">' . badge($r[$E['active_col']] ? 'active' : 'inactive') . '</td><td data-label="Created">' . dshort($r['created_at']) . '</td>';
        if ($actions) $h .= '<td data-label="Actions">' . pl_admin_row_actions($E, $r) . '</td>';
        $h .= '</tr>';
    }
    return $h . '</tbody></table></div>';
}

function pl_admin_list(array $E, array $user, array $comm): void {
    $cid = (int)$comm['id']; $g = $_GET;
    $tabs = pl_admin_tabs($E); $tab = isset($tabs[$g['status'] ?? '']) ? (string)($g['status'] ?? '') : '';
    $a = []; $base = pl_admin_base($E, $cid, $a, $g);
    $counts = [];
    foreach ($tabs as $k => [, $sql]) $counts[$k] = scalar("SELECT COUNT(*) FROM {$E['table']} t WHERE $base AND $sql", $a);
    $page = max(1, (int)($g['page'] ?? 1)); $total = $counts[$tab]; $pages = (int)ceil($total / PL_ADMIN_PER);
    $order = $E['ordered'] ? 't.sort_order ASC, t.id DESC' : 't.id DESC';
    $list = rows("SELECT t.* FROM {$E['table']} t WHERE $base AND {$tabs[$tab][1]} ORDER BY $order LIMIT " . PL_ADMIN_PER . ' OFFSET ' . (($page - 1) * PL_ADMIN_PER), $a);
    $showComm = $E['scope'] === 'mixed' || ($E['scope'] === 'community' && ($g['cf'] ?? '') === 'all');
    $title = ($E['scope'] === 'mixed' && ($g['vis'] ?? '') === 'global' ? 'Global ' : '') . $E['plural'];
    $parentRow = $E['parent'] && !empty($g['parent']) ? pl_entity_row(pl_entity($E['parent'][0]), (int)$g['parent']) : null;
    if ($parentRow) $title .= ' — ' . pl_entity_title(pl_entity($E['parent'][0]), $parentRow);
    render_header($title, 'auto', $user, $comm);
    $keep = array_intersect_key($g, array_flip(['e', 'q', 'cf', 'vis', 'cat', 'parent']));
    foreach ($E['fields'] as $col => $f) if (isset($g['f_' . $col])) $keep['f_' . $col] = $g['f_' . $col]; ?>
<div class="tabs anim"><?php foreach ($tabs as $k => [$l]): ?><a class="<?= $tab === (string)$k ? 'on' : '' ?>" href="<?= e(pl_url($keep + ['status' => $k])) ?>"><?= e($l) ?> (<?= (int)$counts[$k] ?>)</a><?php endforeach; ?></div>
<div class="card anim">
  <form class="toolbar" method="get"><input type="hidden" name="e" value="<?= e($E['key']) ?>"><input type="hidden" name="status" value="<?= e($tab) ?>">
    <?php if (!empty($g['parent'])): ?><input type="hidden" name="parent" value="<?= (int)$g['parent'] ?>"><?php endif; ?>
    <input class="grow" name="q" value="<?= e($g['q'] ?? '') ?>" placeholder="Search <?= e(strtolower($E['plural'])) ?>">
    <?php if ($E['scope'] !== 'global'): ?><?= str_replace('<select', '<select title="Community"', pl_community_select('cf', ($g['cf'] ?? '') === '' ? (string)$cid : $g['cf'], true)) ?><?php endif; ?>
    <?php if ($E['scope'] === 'mixed'): ?><select name="vis" title="Visibility"><option value="">Community + Global</option><option value="community" <?= ($g['vis'] ?? '') === 'community' ? 'selected' : '' ?>>Community only</option><option value="global" <?= ($g['vis'] ?? '') === 'global' ? 'selected' : '' ?>>Global only</option></select><?php endif; ?>
    <?php if ($E['cat']): ?><select name="cat" title="Category"><option value="">All categories</option><?php foreach (pl_categories($E['cat'], false) as $c): ?><option value="<?= (int)$c['id'] ?>" <?= (int)($g['cat'] ?? 0) === (int)$c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php foreach ($c['subcategories'] as $s): ?><option value="<?= (int)$s['id'] ?>" <?= (int)($g['cat'] ?? 0) === (int)$s['id'] ? 'selected' : '' ?>>&nbsp;&nbsp;– <?= e($s['name']) ?></option><?php endforeach; endforeach; ?></select><?php endif; ?>
    <?php foreach ($E['fields'] as $col => $f) if ($f['type'] === 'select' && !empty($f['filter'])): ?><select name="f_<?= e($col) ?>" title="<?= e($f['label']) ?>"><option value=""><?= e($f['label']) ?>: all</option><?php foreach (pl_opts($f) as $k => $l): ?><option value="<?= e($k) ?>" <?= ($g['f_' . $col] ?? '') === (string)$k ? 'selected' : '' ?>><?= e($l) ?></option><?php endforeach; ?></select><?php endif; ?>
    <button class="btn btn-primary"><?= icon('fa-magnifying-glass') ?> Search</button>
    <?php if (!$E['no_create']): ?><a class="btn btn-line" href="<?= e(pl_url(['e' => $E['key'], 'edit' => '0', 'parent' => $g['parent'] ?? ''])) ?>"><?= icon('fa-plus') ?> Add <?= e(strtolower($E['label'])) ?></a><?php endif; ?></form>
  <?= pl_admin_table($E, $list, $showComm) ?>
  <?= pl_pager($page, $pages) ?>
</div>
<?php render_footer();
}

function pl_admin_view(array $E, int $id, array $user, array $comm): void {
    $r = pl_entity_row($E, $id);
    if (!$r) { flash($E['label'] . ' not found.', 'error'); pl_go(pl_url(['e' => $E['key']])); }
    $title = pl_entity_title($E, $r);
    $ctx = ['parents' => pl_parent_titles($E, [$r])];
    $owner = $r['user_id'] ? (rows('SELECT id, name, email, phone FROM users WHERE id=?', [$r['user_id']])[0] ?? null) : null;
    $approver = $r['approved_by'] ? (rows('SELECT name FROM users WHERE id=?', [$r['approved_by']])[0]['name'] ?? null) : null;
    $creator = $r['created_by'] ? (rows('SELECT name FROM users WHERE id=?', [$r['created_by']])[0]['name'] ?? null) : null;
    $details = json_decode($r['details'] ?? '', true) ?: [];
    $media = ($E['gallery'] || $E['files']) ? pl_media($E, $id) : [];
    $saved = $E['save'] ? scalar('SELECT COUNT(*) FROM favourites WHERE entity=? AND entity_id=?', [$E['table'], $id]) : 0;
    $enq = $E['enquiry'] ? rows('SELECT * FROM enquiries WHERE entity=? AND entity_id=? ORDER BY id DESC LIMIT 50', [$E['table'], $id]) : [];
    $reports = $E['report'] ? rows('SELECT cr.*, u.name uname FROM content_reports cr LEFT JOIN users u ON u.id=cr.user_id WHERE cr.entity=? AND cr.entity_id=? ORDER BY cr.id DESC', [$E['table'], $id]) : [];
    $log = rows('SELECT a.*, u.name uname FROM audit_log a LEFT JOIN users u ON u.id=a.user_id WHERE a.entity=? AND a.entity_id=? ORDER BY a.id DESC LIMIT 20', [$E['key'], $id]);
    render_header($E['label'] . ': ' . $title, 'auto', $user, $comm); ?>
<div class="card anim">
  <div class="card-h"><div><h3><?= e($title) ?></h3><small class="muted"><?= $E['code'] ? e($r[$E['code'][0]]) . ' · ' : '' ?>#<?= $id ?> · <?= e($E['label']) ?></small></div>
    <div class="actions"><?= $E['statuses'] ? pl_status_badge((string)$r[$E['status_col']]) : '' ?> <?= badge($r[$E['active_col']] ? 'active' : 'inactive') ?>
      <?= $E['featured'] && $r['is_featured'] ? badge('approved', 'Featured') : '' ?> <?= $E['scope'] === 'mixed' ? badge($r['visibility_type'] === 'global' ? 'active' : 'sent', ucfirst($r['visibility_type'])) : '' ?></div></div>
  <?= pl_admin_row_actions($E, $r, false) ?>
  <a class="btn btn-sm btn-line mt" href="<?= e(pl_url(['e' => $E['key']])) ?>"><?= icon('fa-arrow-left') ?> Back to <?= e(strtolower($E['plural'])) ?></a>
</div>
<div class="grid2 anim">
  <div class="card"><div class="card-h"><h3>Details</h3></div>
    <div class="kv"><?php foreach ($E['fields'] as $col => $f): if ($f['type'] === 'hidden' && $col !== ($E['code'][0] ?? '')) continue; ?>
      <div><span><?= e($f['label']) ?></span><b><?= pl_fmt($E, $col, $r[$col] ?? null, $ctx) ?></b></div><?php endforeach; ?>
      <?php foreach ($details as $k => $v): ?><div><span><?= e(pl_status_label((string)$k)) ?></span><b><?= e(pl_detail_text($v)) ?></b></div><?php endforeach; ?>
    </div></div>
  <div class="card"><div class="card-h"><h3>Record</h3></div>
    <div class="kv one">
      <?php if ($E['scope'] !== 'global'): ?><div><span>Community</span><b><?= e(pl_community_names()[$r['community_id']] ?? '—') ?></b></div><?php endif; ?>
      <div><span>Posted by</span><b><?= $owner ? '<a class="lnk" href="users.php?view=' . (int)$owner['id'] . '">' . e($owner['name']) . '</a><br><small>' . e($owner['email']) . ' ' . e($owner['phone']) . '</small>' : e($creator ? $creator . ' (admin)' : '—') ?></b></div>
      <div><span>Created</span><b><?= e(date('d M Y, H:i', strtotime($r['created_at']))) ?></b></div>
      <div><span>Updated</span><b><?= e(date('d M Y, H:i', strtotime($r['updated_at']))) ?></b></div>
      <?php if ($E['statuses']): ?><div><span>Approved / processed by</span><b><?= e($approver ?? '—') ?><?= $r['approved_at'] ? ' · ' . dshort($r['approved_at']) : '' ?></b></div><?php endif; ?>
      <?php if ($E['save']): ?><div><span>Saved by</span><b><?= (int)$saved ?> users</b></div><?php endif; ?>
      <?php if ($E['ordered']): ?><div><span>Display order</span><b><form class="inline" method="post" action="manage.php"><?= pl_csrf_field() ?><input type="hidden" name="ent" value="<?= e($E['key']) ?>"><input type="hidden" name="id" value="<?= $id ?>"><input type="hidden" name="action" value="order"><input type="hidden" name="ret" value="<?= e(pl_here()) ?>"><input type="number" name="sort_order" value="<?= (int)$r['sort_order'] ?>" class="sel-sm" style="width:90px"> <button class="btn btn-sm btn-line">Save</button></form></b></div><?php endif; ?>
    </div>
    <form method="post" action="manage.php" class="mt"><?= pl_csrf_field() ?><input type="hidden" name="ent" value="<?= e($E['key']) ?>"><input type="hidden" name="id" value="<?= $id ?>"><input type="hidden" name="action" value="notes"><input type="hidden" name="ret" value="<?= e(pl_here()) ?>">
      <?php if (isset($E['fields']['assigned_to'])): ?><label>Assigned to</label><input name="assigned_to" value="<?= e($r['assigned_to'] ?? '') ?>" placeholder="Volunteer / staff name"><?php endif; ?>
      <label>Admin notes (internal)</label><textarea name="admin_notes" rows="3"><?= e($r['admin_notes'] ?? '') ?></textarea>
      <button class="btn btn-sm btn-primary mt">Save notes</button></form>
  </div>
</div>
<?php if ($E['gallery'] || $E['files']): ?>
<div class="card anim"><div class="card-h"><h3><?= $E['files'] ? 'Supporting documents' : 'Images' ?> (<?= count($media) ?>/<?= $E['files'] ?: $E['gallery'] ?>)</h3>
  <form method="post" action="manage.php" enctype="multipart/form-data" class="actions"><?= pl_csrf_field() ?><input type="hidden" name="ent" value="<?= e($E['key']) ?>"><input type="hidden" name="id" value="<?= $id ?>"><input type="hidden" name="action" value="media_add"><input type="hidden" name="ret" value="<?= e(pl_here()) ?>">
    <input type="file" name="files[]" multiple accept="<?= $E['files'] ? 'image/*,application/pdf' : 'image/jpeg,image/png,image/webp' ?>"><button class="btn btn-sm btn-primary"><?= icon('fa-upload') ?> Upload</button></form></div>
  <?php if (!$media): ?><div class="empty"><?= icon('fa-image', 'big') ?>Nothing uploaded.</div><?php else: ?><div class="gal">
  <?php foreach ($media as $m): ?><div class="gi"><?php if ($m['kind'] === 'image'): ?><a href="<?= e($m['url']) ?>" target="_blank" rel="noopener"><img src="<?= e($m['thumbnail_url']) ?>" alt=""></a><?php else: ?><a class="doc" href="<?= e($m['url']) ?>" target="_blank" rel="noopener"><?= icon('fa-file-pdf') ?><span><?= e($m['name'] ?: 'Document') ?></span></a><?php endif; ?>
    <div class="actions"><?= $m['is_primary'] ? badge('approved', 'Main') : ($m['kind'] === 'image' ? pl_btn($E['key'], $id, 'media_primary', 'Make main', 'btn-line', '', ['media_id' => $m['id']]) : '') ?><?= pl_btn($E['key'], $id, 'media_delete', icon('fa-trash'), 'btn-red', 'Delete this file?', ['media_id' => $m['id']]) ?></div></div>
  <?php endforeach; ?></div><?php endif; ?></div>
<?php endif; ?>
<?php foreach ($E['children'] as $ch): [$ck, $fk] = $ch; $pkCol = $ch[2] ?? 'id'; $CE = pl_entity($ck);
    $kids = rows("SELECT t.* FROM {$CE['table']} t WHERE t.$fk=? ORDER BY t.id DESC LIMIT 100", [$r[$pkCol]]); ?>
<div class="card anim"><div class="card-h"><h3><?= e($CE['plural']) ?> (<?= count($kids) ?>)</h3>
  <?php if ($CE['parent'] && $CE['parent'][0] === ($E['key'] === 'family_tree' ? 'family' : $E['key'])): ?><a class="btn btn-sm btn-line" href="<?= e(pl_url(['e' => $ck, 'edit' => '0', 'parent' => $id])) ?>"><?= icon('fa-plus') ?> Add <?= e(strtolower($CE['label'])) ?></a><?php endif; ?></div>
  <?= pl_admin_table($CE, $kids, false) ?></div>
<?php endforeach; ?>
<?php if ($E['enquiry']): ?>
<div class="card anim"><div class="card-h"><h3><?= $E['key'] === 'event' ? 'Registrations & enquiries' : 'Enquiries' ?> (<?= count($enq) ?>)</h3><a class="btn btn-sm btn-line" href="enquiries.php?e=<?= e($E['key']) ?>&item=<?= $id ?>">Open enquiries</a></div>
  <?php if (!$enq): ?><div class="empty"><?= icon('fa-inbox', 'big') ?>No enquiries yet.</div><?php else: ?><div class="tw"><table class="rt"><thead><tr><th>From</th><th>Type</th><th>Message</th><th>Date</th><th>Status</th></tr></thead><tbody>
  <?php foreach ($enq as $q): ?><tr><td data-label="From"><b><?= e($q['name']) ?></b><br><small><?= e($q['phone']) ?> <?= e($q['email']) ?></small></td><td data-label="Type"><?= e(ucfirst($q['kind'])) ?></td><td data-label="Message"><?= e(mb_strimwidth((string)$q['message'], 0, 140, '…')) ?></td><td data-label="Date"><?= dshort($q['created_at']) ?></td><td data-label="Status"><?= pl_status_badge($q['status']) ?></td></tr><?php endforeach; ?>
  </tbody></table></div><?php endif; ?></div>
<?php endif; ?>
<?php if ($E['report']): ?>
<div class="card anim"><div class="card-h"><h3>Reports (<?= count($reports) ?>)</h3></div>
  <?php if (!$reports): ?><div class="empty"><?= icon('fa-flag', 'big') ?>Not reported.</div><?php else: ?><div class="tw"><table class="rt"><thead><tr><th>Reported by</th><th>Reason</th><th>Date</th><th>Status</th></tr></thead><tbody>
  <?php foreach ($reports as $q): ?><tr><td data-label="By"><?= e($q['uname'] ?? 'User #' . $q['user_id']) ?></td><td data-label="Reason"><b><?= e($q['reason']) ?></b><br><small><?= e($q['details']) ?></small></td><td data-label="Date"><?= dshort($q['created_at']) ?></td><td data-label="Status"><?= pl_status_badge($q['status']) ?></td></tr><?php endforeach; ?>
  </tbody></table></div><?php endif; ?></div>
<?php endif; ?>
<div class="card anim"><div class="card-h"><h3>Activity</h3></div>
  <?php if (!$log): ?><div class="empty"><?= icon('fa-clock-rotate-left', 'big') ?>No admin activity yet.</div><?php else: foreach ($log as $l): ?>
  <div class="note"><div class="note-i"><?= icon('fa-clock-rotate-left') ?></div><div class="note-b"><b><?= e(pl_status_label(str_replace(':', ' → ', $l['action']))) ?></b><div><?= e($l['uname'] ?? 'System') ?></div><small class="muted"><?= e(date('d M Y, H:i', strtotime($l['created_at']))) ?></small></div></div>
  <?php endforeach; endif; ?></div>
<?php render_footer();
}

function pl_admin_edit(array $E, int $id, array $user, array $comm): void {
    $r = $id ? pl_entity_row($E, $id) : null;
    if ($id && !$r) { flash($E['label'] . ' not found.', 'error'); pl_go(pl_url(['e' => $E['key']])); }
    if (!$id && $E['no_create']) { flash('Create the family under Members & Family first.', 'error'); pl_go(pl_url(['e' => $E['key']])); }
    $prev = $_SESSION['pl_form'] ?? null; unset($_SESSION['pl_form']);
    $val = fn($c) => $prev[$c] ?? ($r[$c] ?? ($E['fields'][$c]['default'] ?? null));
    $ctx = ['cats' => $E['cat'] ? pl_categories($E['cat'], false) : [], 'parent_opts' => []];
    if ($E['parent']) {
        $PE = pl_entity($E['parent'][0]);
        $ctx['parent_opts'] = array_column(rows("SELECT id, {$PE['title']} t FROM {$PE['table']} WHERE community_id=? ORDER BY id DESC LIMIT 500", [(int)$comm['id']]), 't', 'id');
        $pref = (int)($_GET['parent'] ?? 0) ?: (int)($r[$E['parent'][1]] ?? 0);
        if ($pref && !isset($ctx['parent_opts'][$pref]) && ($pr = pl_entity_row($PE, $pref))) $ctx['parent_opts'][$pref] = pl_entity_title($PE, $pr);
        if (!$id && $pref && !$prev) $prev = [$E['parent'][1] => $pref];
    }
    render_header(($id ? 'Edit ' : 'Add ') . strtolower($E['label']), 'auto', $user, $comm); ?>
<div class="card anim">
  <div class="card-h"><h3><?= $id ? 'Edit: ' . e(pl_entity_title($E, $r)) : 'New ' . e(strtolower($E['label'])) ?></h3>
    <a class="btn btn-line btn-sm" href="<?= e($id ? pl_url(['e' => $E['key'], 'view' => $id]) : pl_url(['e' => $E['key']])) ?>"><?= icon('fa-arrow-left') ?> Back</a></div>
  <form method="post" action="manage.php" enctype="multipart/form-data"><?= pl_csrf_field() ?>
    <input type="hidden" name="ent" value="<?= e($E['key']) ?>"><input type="hidden" name="id" value="<?= $id ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="parent_ref" value="<?= (int)($_GET['parent'] ?? 0) ?: '' ?>">
    <div class="fgrid">
    <?php foreach ($E['fields'] as $col => $f): if ($f['type'] === 'hidden') continue; ?>
      <div class="<?= in_array($f['type'], ['textarea'], true) ? 'wide' : '' ?>"><?php if ($f['type'] !== 'bool'): ?><label><?= e($f['label']) ?><?= !empty($f['req']) ? ' *' : '' ?></label><?php endif; ?>
        <?= pl_admin_control($E, $col, $f, $val($col), $ctx) ?><?php if (!empty($f['help'])): ?><small class="muted"><?= e($f['help']) ?></small><?php endif; ?></div>
    <?php endforeach; ?>
    <?php if ($E['scope'] !== 'global' && !$E['parent']): ?><div><label>Community</label><?= pl_community_select('community_id', $prev['community_id'] ?? ($r['community_id'] ?? $comm['id'])) ?></div><?php endif; ?>
    <?php if ($E['scope'] === 'mixed'): ?><div><label>Visibility</label><select name="visibility_type"><option value="community">This community only</option><option value="global" <?= ($prev['visibility_type'] ?? $r['visibility_type'] ?? '') === 'global' ? 'selected' : '' ?>>Global (all communities)</option></select></div><?php endif; ?>
    <?php if ($E['statuses']): ?><div><label>Status</label><select name="status_value"><?php foreach ($E['statuses'] as $s): ?><option value="<?= e($s) ?>" <?= ($prev['status_value'] ?? $r[$E['status_col']] ?? (in_array('approved', $E['statuses'], true) ? 'approved' : $E['statuses'][0])) === $s ? 'selected' : '' ?>><?= e(pl_status_label($s)) ?></option><?php endforeach; ?></select></div><?php endif; ?>
    <?php if ($E['ordered']): ?><div><label>Display order</label><input type="number" name="sort_order" value="<?= (int)($prev['sort_order'] ?? $r['sort_order'] ?? 0) ?>"></div><?php endif; ?>
    <div><label class="chk"><input type="checkbox" name="active_value" value="1" <?= ($prev ? !empty($prev['active_value']) : ($r ? $r[$E['active_col']] : 1)) ? 'checked' : '' ?>> Active (visible in the app)</label>
      <?php if ($E['featured']): ?><label class="chk"><input type="checkbox" name="is_featured" value="1" <?= ($prev['is_featured'] ?? $r['is_featured'] ?? 0) ? 'checked' : '' ?>> Featured</label><?php endif; ?></div>
    <?php if ($E['gallery'] || $E['files']): ?><div class="wide"><label><?= $E['files'] ? 'Add supporting documents' : 'Add images' ?> (max <?= $E['files'] ?: $E['gallery'] ?>)</label><input type="file" name="gallery[]" multiple accept="<?= $E['files'] ? 'image/*,application/pdf' : 'image/jpeg,image/png,image/webp' ?>"></div><?php endif; ?>
    </div>
    <div class="dlg-actions"><a class="btn btn-line" href="<?= e(pl_url(['e' => $E['key']])) ?>">Cancel</a><button class="btn btn-primary"><?= icon('fa-floppy-disk') ?> Save</button></div>
  </form>
</div>
<?php render_footer();
}

/* readable text for a value in a record's extra details (nested lists, yes/no flags, ISO dates) */
function pl_detail_text($v): string {
    if (is_bool($v)) return $v ? 'Yes' : 'No';
    if ($v === null || $v === '') return '—';
    if (is_array($v)) {
        $out = [];
        foreach ($v as $k => $x) $out[] = (is_int($k) ? '' : pl_status_label((string)$k) . ': ') . pl_detail_text($x);
        return $out ? implode(' · ', $out) : '—';
    }
    if (is_string($v) && preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}/', $v) && ($t = strtotime($v))) return date('d M Y, H:i', $t);
    return (string)$v;
}
