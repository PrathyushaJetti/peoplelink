<?php
// App API: Jobs (Community + Global jobs on ONE backend). Loaded from actions.php after includes/ext/*.php.
// Kept from the registry (modules_api.php): jobs_categories, jobs_delete, jobs_close, jobs_report.
// Replaced here: jobs_list/search, jobs_filters, jobs_details, jobs_create/post, jobs_update/edit, jobs_my, jobs_save, jobs_saved.
// Added: renew, unsave, apply, applications, resume, Global Job Packages, notifications. Reference: API-MODULES.txt (JOBS).
require_once __DIR__ . '/payments.php';

function pl_jobs_err(string $msg, string $code = 'VALIDATION_ERROR', int $http = 400): array { return ['error' => $msg, 'code' => $code, '_code' => $http]; }
function pl_jobs_404(string $what = 'Job'): array { return pl_jobs_err("$what not found.", 'NOT_FOUND', 404); }
function pl_jobs_is_admin(?array $u): bool { return $u && ($u['role'] ?? '') !== 'member'; }

/* free text from the app -> option key of a select field ("full-time" -> "Full Time") */
function pl_jobs_opt(array $f, string $v): ?string {
    $n = fn($s) => preg_replace('/[^a-z0-9+]/', '', strtolower((string)$s));
    if ($n($v) === '') return null;
    foreach (pl_opts($f) as $k => $l) if ($n($k) === $n($v) || $n($l) === $n($v)) return (string)$k;
    return null;
}

/* ---------- list / search / details ---------- */

function pl_jobs_items(array $list, ?int $uid): array {
    $saved = $apps = [];
    if ($uid && $list) {
        $in = implode(',', array_map('intval', array_column($list, 'id')));
        $saved = array_flip(array_column(rows("SELECT entity_id FROM favourites WHERE user_id=? AND entity='jobs' AND entity_id IN ($in)", [$uid]), 'entity_id'));
        foreach (rows("SELECT * FROM jobs_applications WHERE user_id=? AND job_id IN ($in)", [$uid]) as $ap) $apps[$ap['job_id']] = $ap;
    }
    return array_map(fn($r) => pl_job_out($r, $uid, false, ['saved' => isset($saved[$r['id']]), 'application' => $apps[$r['id']] ?? null]), $list);
}

function pl_jobs_list(array $x, array $f, ?string $extraWhere = null, array $extraArgs = []): array {
    pl_jobs_daily();
    $E = pl_entity('job');
    foreach (['title' => 'job_title', 'company' => 'company_name', 'type' => 'employment_type'] as $alias => $col) if (!isset($f[$col]) && isset($f[$alias])) $f[$col] = $f[$alias];
    $jt = strtolower(trim((string)($f['job_type'] ?? '')));
    if (in_array($jt, ['community', 'global'], true)) $f['visibility'] = $jt;
    elseif ($jt !== '' && !isset($f['employment_type'])) $f['employment_type'] = $f['job_type'];
    foreach (['employment_type', 'work_mode', 'experience'] as $col)
        if (is_string($f[$col] ?? null) && trim($f[$col]) !== '' && !in_array(strtolower(trim($f[$col])), ['any', 'all'], true)) $f[$col] = pl_jobs_opt($E['fields'][$col], $f[$col]) ?? '-';
    $a = []; $w = pl_ent_where($E, $x['cid'], $a) . pl_ent_filters($E, $f, $a);
    $vis = strtolower(trim((string)($f['visibility'] ?? $f['visibility_type'] ?? '')));
    if (in_array($vis, ['community', 'global'], true)) { $w .= ' AND t.visibility_type=?'; $a[] = $vis; }
    $loc = trim((string)($f['location'] ?? ''));
    if ($loc !== '') { $w .= ' AND (t.location LIKE ? OR t.city LIKE ? OR t.state LIKE ?)'; array_push($a, "%$loc%", "%$loc%", "%$loc%"); }
    // salary range: jobs whose range overlaps the one asked for
    if (is_numeric($f['salary_min'] ?? null)) { $w .= ' AND COALESCE(t.salary_max, t.salary_min) >= ?'; $a[] = (float)$f['salary_min']; }
    if (is_numeric($f['salary_max'] ?? null)) { $w .= ' AND COALESCE(t.salary_min, t.salary_max) <= ?'; $a[] = (float)$f['salary_max']; }
    if ((int)($f['posted_within'] ?? 0) > 0) { $w .= ' AND t.created_at >= NOW() - INTERVAL ? DAY'; $a[] = (int)$f['posted_within']; }
    if ($extraWhere) { $w .= " AND $extraWhere"; array_push($a, ...$extraArgs); }
    $orders = ['latest' => 't.id DESC', 'recent' => 't.id DESC', 'oldest' => 't.id ASC', 'closing_soon' => 't.closing_date IS NULL, t.closing_date ASC, t.id DESC',
        'salary_desc' => 'COALESCE(t.salary_max, t.salary_min) IS NULL, COALESCE(t.salary_max, t.salary_min) DESC, t.id DESC',
        'salary_asc' => 'COALESCE(t.salary_min, t.salary_max) IS NULL, COALESCE(t.salary_min, t.salary_max) ASC, t.id DESC'];
    $sort = (string)($f['sort'] ?? ''); $oa = [];
    if (isset($orders[$sort])) $order = $orders[$sort];
    else {
        // relevant: best text match first when searching, then featured / priority (package) jobs, then newest
        $sort = 'relevant'; $order = 't.is_featured DESC, t.priority DESC, t.id DESC';
        $q = trim((string)($f['q'] ?? $f['keyword'] ?? $f['search'] ?? ''));
        if ($q !== '') { $order = '((t.job_title LIKE ?) * 4 + (t.required_skills LIKE ?) * 2 + (t.company_name LIKE ?)) DESC, ' . $order; array_push($oa, "%$q%", "%$q%", "%$q%"); }
    }
    [$page, $per] = pl_api_page();
    $total = scalar("SELECT COUNT(*) FROM jobs t WHERE $w", $a);
    $list = rows("SELECT t.* FROM jobs t WHERE $w ORDER BY $order LIMIT $per OFFSET " . (($page - 1) * $per), array_merge($a, $oa));
    return ['total' => $total, 'page' => $page, 'per' => $per, 'total_pages' => (int)ceil($total / $per), 'sort' => $sort, 'items' => pl_jobs_items($list, $x['uid'])];
}

foreach (['jobs_list', 'jobs_search'] as $__a) pl_action($__a, fn($x) => pl_jobs_list($x, $_GET + $_POST), true, false);
pl_action('jobs_global', fn($x) => pl_jobs_list($x, ['visibility' => 'global'] + $_GET + $_POST), true, false);
pl_action('jobs_community', fn($x) => pl_jobs_list($x, ['visibility' => 'community'] + $_GET + $_POST), true, false);

pl_action('jobs_filters', function ($x) {
    $o = pl_api_filters(pl_entity('job'));
    $o['filters'][] = ['field' => 'location', 'label' => 'Location (area, city or state)', 'type' => 'text'];
    $o['filters'][] = ['field' => 'visibility', 'label' => 'Community / Global', 'type' => 'select', 'options' => [['value' => 'community', 'label' => 'Community jobs'], ['value' => 'global', 'label' => 'Global jobs']]];
    $o['filters'][] = ['field' => 'salary', 'label' => 'Salary range (₹)', 'type' => 'money', 'params' => ['salary_min', 'salary_max']];
    $o['filters'][] = ['field' => 'posted_within', 'label' => 'Posted within (days)', 'type' => 'int'];
    $o['sort'] = ['relevant', 'latest', 'oldest', 'closing_soon', 'salary_desc', 'salary_asc'];
    return $o;
}, true, false);

pl_action('jobs_details', function ($x) {
    $uid = $x['uid'];
    $r = pl_api_visible(pl_entity('job'), (int)($_REQUEST['id'] ?? 0), $x['cid'], $uid);
    if (!$r) return pl_jobs_404();
    if (!$uid || (int)$r['user_id'] !== $uid) db()->prepare('UPDATE jobs SET views=views+1, updated_at=updated_at WHERE id=?')->execute([$r['id']]);
    $app = $uid ? (rows('SELECT * FROM jobs_applications WHERE job_id=? AND user_id=?', [$r['id'], $uid])[0] ?? null) : null;
    $saved = $uid && scalar("SELECT COUNT(*) FROM favourites WHERE user_id=? AND entity='jobs' AND entity_id=?", [$uid, $r['id']]);
    $o = pl_job_out($r, $uid, true, ['saved' => $saved, 'application' => $app]);
    if ($app) $o['my_application'] = pl_job_app_out($app, $r);
    return ['item' => $o];
}, true, false);

/* ---------- post / edit / my posted jobs / renew ---------- */

function pl_jobs_check(array $in, ?array $old): ?string {
    $E = pl_entity('job');
    $val = fn($k) => array_key_exists($k, $in) ? trim(is_array($in[$k]) ? '' : (string)$in[$k]) : (string)($old[$k] ?? '');
    $date = fn($k) => $val($k) === '' ? null : strtotime($val($k));
    $close = $date('closing_date'); $start = $date('application_start_date');
    if ($close === false || $start === false) return null; // pl_entity_input reports the bad date
    $today = strtotime('today'); $max = pl_setting('jobs_max_validity_days');
    if (array_key_exists('closing_date', $in) && $close !== null) {
        if ($close < $today) return 'Closing date cannot be in the past.';
        if ($max > 0 && $close > strtotime("+$max days", $today)) return "Closing date can be at most $max days from today.";
    }
    if ($close !== null && $start !== null && $start > $close) return 'Applications start date must be on or before the closing date.';
    $mn = str_replace([',', '₹', ' '], '', $val('salary_min')); $mx = str_replace([',', '₹', ' '], '', $val('salary_max'));
    if (is_numeric($mn) && is_numeric($mx) && (float)$mn > (float)$mx) return 'Salary from cannot be more than salary up to.';
    $via = pl_jobs_opt($E['fields']['apply_via'], $val('apply_via')) ?? 'in_app';
    if (in_array($via, ['email', 'both'], true) && $val('application_email') === '') return 'Add the application email, or choose another way to receive applications.';
    if (in_array($via, ['whatsapp', 'both'], true) && $val('whatsapp') === '') return 'Add the WhatsApp number, or choose another way to receive applications.';
    return null;
}

function pl_jobs_save(array $x, ?array $old): array {
    $E = pl_entity('job'); $uid = $x['uid'];
    if ($old && $old['status'] === 'closed') return pl_jobs_err('This job is closed. Renew it to make changes.');
    // accept "full-time", "full_time", "hybrid" ... for the dropdown fields
    foreach ($E['fields'] as $col => $f) if ($f['type'] === 'select' && is_string($_POST[$col] ?? null) && ($k = pl_jobs_opt($f, $_POST[$col])) !== null) $_POST[$col] = $k;
    if ($err = pl_jobs_check($_POST, $old)) return pl_jobs_err($err);
    $global = strtolower(trim((string)($_POST['visibility_type'] ?? $_POST['visibility'] ?? ($old['visibility_type'] ?? 'community')))) === 'global';
    $_POST['visibility_type'] = $global ? 'global' : 'community';
    // members pay for global reach with a Global Job Package post; a job that already used one keeps it
    $needCredit = $global && !pl_jobs_is_admin($x['user']) && pl_setting('jobs_global_requires_package') && (!$old || ($old['visibility_type'] !== 'global' && !$old['user_package_id']));
    if ($needCredit && pl_job_remaining($uid) < 1)
        return ['error' => 'Posting a global job needs an active Global Job Package with job posts left.', 'code' => 'PACKAGE_REQUIRED', '_code' => 402, 'packages_action' => 'jobs_packages'];
    if (!$old && trim((string)($_POST['closing_date'] ?? '')) === '') $_POST['closing_date'] = date('Y-m-d', strtotime('+' . max(1, pl_setting('jobs_default_validity_days')) . ' days'));
    $res = $old ? pl_api_update($E, $x, $old) : pl_api_create($E, $x);
    if (!empty($res['error'])) return $res;
    $id = $old ? (int)$old['id'] : (int)$res['id'];
    if ($needCredit) {
        $c = pl_job_use_credit($uid);
        if ($c) pl_entity_update($E, $id, ['user_package_id' => $c['id'], 'is_featured' => (int)$c['featured_listing'], 'priority' => (int)$c['priority_visibility']]);
        else { pl_entity_update($E, $id, ['visibility_type' => 'community']); $res['warning'] = 'No global job posts were left, so the job was saved as a community job.'; }
    }
    $res['item'] = pl_job_out(pl_entity_row($E, $id), $uid, true);
    if ($global) $res['remaining_global_posts'] = pl_job_remaining($uid);
    return $res;
}

foreach (['jobs_create', 'jobs_post'] as $__a) pl_action($__a, fn($x) => pl_jobs_save($x, null));
foreach (['jobs_update', 'jobs_edit'] as $__a) pl_action($__a, function ($x) {
    $r = pl_api_own(pl_entity('job'), (int)($_POST['id'] ?? 0), $x['uid']);
    return $r ? pl_jobs_save($x, $r) : pl_jobs_404();
});

foreach (['jobs_my', 'jobs_my_posted'] as $__a) pl_action($__a, function ($x) {
    pl_jobs_daily();
    [$page, $per] = pl_api_page();
    $w = 't.user_id=?'; $a = [$x['uid']];
    $st = (string)($_GET['status'] ?? '');
    if ($st === 'active') $w .= " AND t.status='approved' AND t.is_active=1 AND (t.closing_date IS NULL OR t.closing_date >= CURDATE())";
    elseif ($st === 'expired') $w .= " AND t.status='approved' AND t.closing_date < CURDATE()";
    elseif (in_array($st, pl_entity('job')['statuses'], true)) { $w .= ' AND t.status=?'; $a[] = $st; }
    if (in_array($_GET['visibility'] ?? '', ['community', 'global'], true)) { $w .= ' AND t.visibility_type=?'; $a[] = $_GET['visibility']; }
    $total = scalar("SELECT COUNT(*) FROM jobs t WHERE $w", $a);
    $list = rows("SELECT t.* FROM jobs t WHERE $w ORDER BY t.id DESC LIMIT $per OFFSET " . (($page - 1) * $per), $a);
    return ['total' => $total, 'page' => $page, 'per' => $per, 'total_pages' => (int)ceil($total / $per), 'items' => array_map(fn($r) => pl_job_out($r, $x['uid']), $list)];
}, false, false);

function pl_jobs_renew(array $x): array {
    $E = pl_entity('job');
    $r = pl_api_own($E, (int)($_POST['id'] ?? 0), $x['uid']);
    if (!$r) return pl_jobs_404();
    if (!in_array($r['status'], ['approved', 'closed'], true)) return pl_jobs_err('Only approved, expired or closed jobs can be renewed.');
    $today = strtotime('today'); $max = pl_setting('jobs_max_validity_days');
    $raw = trim((string)($_POST['closing_date'] ?? ''));
    $new = $raw !== '' ? strtotime($raw) : strtotime('+' . max(1, (int)($_POST['days'] ?? pl_setting('jobs_default_validity_days'))) . ' days', $today);
    if (!$new || $new < $today) return pl_jobs_err('Choose a closing date from today onwards.');
    if ($max > 0 && $new > strtotime("+$max days", $today)) return pl_jobs_err("Closing date can be at most $max days from today.");
    $set = ['closing_date' => date('Y-m-d', $new)];
    $reapprove = $r['status'] === 'closed';
    if ($reapprove) $set += ['status' => 'pending', 'closed_at' => null];
    pl_entity_update($E, (int)$r['id'], $set);
    pl_audit('app_renew', 'job', (int)$r['id'], $set['closing_date'], $r['community_id'] ? (int)$r['community_id'] : null);
    return ['message' => $reapprove ? 'Job renewed and sent for approval.' : 'Closing date extended to ' . date('d M Y', $new) . '.',
        'item' => pl_job_out(pl_entity_row($E, (int)$r['id']), $x['uid'], true)];
}
pl_action('jobs_renew', 'pl_jobs_renew');
pl_action('jobs_extend', 'pl_jobs_renew');

/* ---------- saved jobs ---------- */

function pl_jobs_set_saved(array $x, int $id, bool $want): array {
    $has = (bool)scalar("SELECT COUNT(*) FROM favourites WHERE user_id=? AND entity='jobs' AND entity_id=?", [$x['uid'], $id]);
    if ($want && !$has) {
        if (!pl_api_visible(pl_entity('job'), $id, $x['cid'], $x['uid'])) return pl_jobs_404();
        db()->prepare("INSERT IGNORE INTO favourites (user_id, entity, entity_id) VALUES (?, 'jobs', ?)")->execute([$x['uid'], $id]);
    } elseif (!$want && $has) db()->prepare("DELETE FROM favourites WHERE user_id=? AND entity='jobs' AND entity_id=?")->execute([$x['uid'], $id]);
    return ['saved' => $want, 'message' => $want ? 'Job saved.' : 'Removed from saved jobs.'];
}
pl_action('jobs_save', fn($x) => pl_jobs_set_saved($x, (int)($_POST['id'] ?? $_POST['job_id'] ?? 0), true));
pl_action('jobs_unsave', fn($x) => pl_jobs_set_saved($x, (int)($_POST['id'] ?? $_POST['job_id'] ?? 0), false));
pl_action('jobs_save_toggle', function ($x) {
    $id = (int)($_POST['id'] ?? $_POST['job_id'] ?? 0);
    return pl_jobs_set_saved($x, $id, !scalar("SELECT COUNT(*) FROM favourites WHERE user_id=? AND entity='jobs' AND entity_id=?", [$x['uid'], $id]));
});
/* saved jobs, newest saved first; closed / expired ones stay in the list (accepting_applications=false) so the member sees what happened */
pl_action('jobs_saved', function ($x) {
    [$page, $per] = pl_api_page();
    $w = "f.user_id=? AND f.entity='jobs' AND t.status IN ('approved','closed') AND t.is_active=1 AND (t.visibility_type='global' OR t.community_id=?)"; $a = [$x['uid'], $x['cid']];
    if (in_array($_GET['visibility'] ?? '', ['community', 'global'], true)) { $w .= ' AND t.visibility_type=?'; $a[] = $_GET['visibility']; }
    $total = scalar("SELECT COUNT(*) FROM favourites f JOIN jobs t ON t.id=f.entity_id WHERE $w", $a);
    $list = rows("SELECT t.*, f.created_at saved_at FROM favourites f JOIN jobs t ON t.id=f.entity_id WHERE $w ORDER BY " . (($_GET['sort'] ?? '') === 'closing' ? 't.closing_date IS NULL, t.closing_date' : 'f.id DESC')
        . " LIMIT $per OFFSET " . (($page - 1) * $per), $a);
    $items = pl_jobs_items($list, $x['uid']);
    foreach ($items as $i => &$it) $it['saved_at'] = $list[$i]['saved_at'];
    return ['total' => $total, 'page' => $page, 'per' => $per, 'total_pages' => (int)ceil($total / $per), 'items' => $items];
}, false, false);

/* ---------- resume ---------- */

function pl_jobs_resume_set(int $uid, array $res): ?array {
    $old = pl_job_saved_resume($uid);
    db()->prepare('INSERT INTO job_resumes (user_id, path, name, mime, size) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE path=VALUES(path), name=VALUES(name), mime=VALUES(mime), size=VALUES(size), updated_at=NOW()')
        ->execute([$uid, $res['path'], $res['name'], $res['mime'], $res['size']]);
    if ($old && $old['path'] !== $res['path']) pl_job_resume_unlink($old['path']);
    return pl_job_saved_resume($uid);
}

foreach (['jobs_resume_upload', 'jobs_resume_replace'] as $__a) pl_action($__a, function ($x) {
    $f = $_FILES['resume'] ?? null;
    if (!$f || is_array($f['name']) || ($f['error'] ?? 4) === UPLOAD_ERR_NO_FILE) return pl_jobs_err('Choose your resume file (PDF, DOC or DOCX) in the field "resume".');
    $r = pl_job_resume_store($f);
    if (!empty($r['error'])) return pl_jobs_err($r['error']);
    return ['message' => 'Resume saved.', 'resume' => pl_job_saved_resume_out(pl_jobs_resume_set($x['uid'], $r))];
});
foreach (['jobs_resume', 'jobs_resume_get'] as $__a) pl_action($__a, fn($x) => ['resume' => pl_job_saved_resume_out(pl_job_saved_resume($x['uid']))], false, false);
pl_action('jobs_resume_delete', function ($x) {
    $r = pl_job_saved_resume($x['uid']);
    if (!$r) return pl_jobs_404('Resume');
    db()->prepare('DELETE FROM job_resumes WHERE user_id=?')->execute([$x['uid']]);
    pl_job_resume_unlink($r['path']);
    return ['message' => 'Saved resume removed. Resumes already sent with applications are kept.'];
});

/* streams the file: without application_id my saved resume; with it the applicant, the job poster or an admin */
pl_action('jobs_resume_download', function ($x) {
    $aid = (int)($_GET['application_id'] ?? 0);
    if (!$aid) {
        $r = pl_job_saved_resume($x['uid']);
        if (!$r) return pl_jobs_404('Resume');
        pl_job_resume_send($r['path'], $r['name']);
    }
    $ctx = pl_jobs_app_for($aid, $x);
    if (!$ctx || !$ctx[0]['resume_path']) return pl_jobs_404('Resume');
    if ($ctx[2] === 'poster' && $ctx[0]['status'] === 'applied') pl_jobs_app_set_status($ctx[0], 'viewed');
    pl_job_resume_send($ctx[0]['resume_path'], $ctx[0]['resume_name']);
}, false, false);

/* ---------- apply + applications ---------- */

pl_action('jobs_apply', function ($x) {
    $AE = pl_entity('job_application'); $uid = $x['uid']; $u = $x['user'];
    $r = pl_api_visible(pl_entity('job'), (int)($_POST['job_id'] ?? $_POST['id'] ?? 0), $x['cid'], $uid);
    if (!$r) return pl_jobs_404();
    if ((int)$r['user_id'] === $uid) return pl_jobs_err('You cannot apply to your own job.');
    if ($why = pl_job_closed_reason($r)) return pl_jobs_err($why, 'APPLICATIONS_CLOSED');
    $prev = rows('SELECT id, status FROM jobs_applications WHERE job_id=? AND user_id=?', [$r['id'], $uid])[0] ?? null;
    if ($prev) return ['error' => 'You have already applied for this job.', 'code' => 'ALREADY_APPLIED', 'application_id' => (int)$prev['id'], 'status' => $prev['status']];
    $methods = pl_job_methods($r);
    $method = pl_jobs_opt($AE['fields']['apply_method'], (string)($_POST['method'] ?? $_POST['apply_method'] ?? 'in_app')) ?? '';
    if (!in_array($method, $methods, true)) return ['error' => 'This job does not take applications that way.', 'code' => 'VALIDATION_ERROR', 'apply_methods' => $methods];

    // resume: a new upload, otherwise a copy of the saved resume (use_saved_resume=0 to skip)
    $resume = null; $file = $_FILES['resume'] ?? null;
    $uploaded = $file && !is_array($file['name']) && ($file['error'] ?? 4) !== UPLOAD_ERR_NO_FILE;
    if ($uploaded) {
        $resume = pl_job_resume_store($file);
        if (!empty($resume['error'])) return pl_jobs_err($resume['error']);
    } elseif (!in_array(strtolower((string)($_POST['use_saved_resume'] ?? '1')), ['0', 'false', 'no'], true) && ($s = pl_job_saved_resume($uid)) && ($copy = pl_job_resume_copy($s['path']))) {
        $resume = ['path' => $copy, 'name' => $s['name']];
    }
    if (!$resume && $method === 'in_app' && pl_setting('jobs_resume_required')) return pl_jobs_err('Please attach your resume (PDF, DOC or DOCX).', 'RESUME_REQUIRED');

    $in = ['job_id' => $r['id'], 'applicant_name' => $_POST['name'] ?? $_POST['applicant_name'] ?? $u['name'], 'email' => $_POST['email'] ?? $u['email'],
        'phone' => $_POST['phone'] ?? ($u['phone'] ?? ''), 'total_experience' => $_POST['total_experience'] ?? $_POST['experience'] ?? '',
        'current_location' => $_POST['current_location'] ?? $_POST['location'] ?? '', 'cover_letter' => $_POST['cover_letter'] ?? $_POST['message'] ?? '', 'apply_method' => $method];
    [$cols, $err] = pl_entity_input($AE, $in, [], false, null, true);
    if ($err) { pl_job_resume_unlink($resume['path'] ?? null); return pl_jobs_err($err); }
    $cols['resume_path'] = $resume['path'] ?? null; $cols['resume_name'] = $resume['name'] ?? null;
    $id = pl_entity_insert($AE, $cols, ['community_id' => $r['community_id'], 'user_id' => $uid, 'created_by' => $uid, 'status' => 'applied']);
    if ($resume) pl_entity_update($AE, $id, ['resume_url' => pl_job_resume_url($id)]);
    if ($uploaded && $resume && in_array(strtolower((string)($_POST['save_resume'] ?? '')), ['1', 'true', 'yes'], true) && ($copy = pl_job_resume_copy($resume['path']))) {
        $ext = pathinfo($copy, PATHINFO_EXTENSION);
        pl_jobs_resume_set($uid, ['path' => $copy, 'name' => $resume['name'], 'mime' => PL_RESUME_TYPES[$ext], 'size' => (int)filesize(PL_RESUME_DIR . $copy)]);
    }
    pl_audit('app_apply', 'job', (int)$r['id'], 'Application #' . $id, $r['community_id'] ? (int)$r['community_id'] : null);
    if ($r['user_id']) pl_notify_user((int)$r['user_id'], $r['community_id'] ? (int)$r['community_id'] : null, 'New application',
        $cols['applicant_name'] . ' applied for "' . $r['job_title'] . '".', 'job_application', 'jobs_applications', $id);
    $out = ['message' => 'Application submitted.', 'application' => pl_job_app_out(pl_entity_row($AE, $id), $r)];
    if ($method !== 'in_app') {
        $out['contact'] = pl_job_contact($r, $u);
        $out['message'] = $method === 'email' ? 'Application recorded. Send your email to the employer to complete it.' : 'Application recorded. Continue on WhatsApp to message the employer.';
    }
    return $out;
});

/* [application, job, viewer role: applicant | poster | admin] or null when the viewer may not see it */
function pl_jobs_app_for(int $id, array $x): ?array {
    $a = $id ? (rows('SELECT * FROM jobs_applications WHERE id=?', [$id])[0] ?? null) : null;
    if (!$a) return null;
    $j = rows('SELECT * FROM jobs WHERE id=?', [$a['job_id']])[0] ?? null;
    if ((int)$a['user_id'] === $x['uid']) return [$a, $j, 'applicant'];
    if ($j && (int)$j['user_id'] === $x['uid']) return [$a, $j, 'poster'];
    return pl_jobs_is_admin($x['user']) ? [$a, $j, 'admin'] : null;
}

function pl_jobs_app_set_status(array $a, string $new): void {
    pl_entity_update(pl_entity('job_application'), (int)$a['id'], ['status' => $new]);
    pl_job_app_status_changed($a, $new);
}

function pl_jobs_app_history(array $a): array {
    return array_merge([['status' => 'applied', 'at' => $a['created_at']]], array_map(fn($l) => ['status' => substr($l['action'], 7), 'at' => $l['created_at']],
        rows("SELECT action, created_at FROM audit_log WHERE entity='job_application' AND entity_id=? AND action LIKE 'status:%' ORDER BY id", [$a['id']])));
}

function pl_jobs_status_counts(string $w, array $a): array {
    $c = array_column(rows("SELECT a.status, COUNT(*) n FROM jobs_applications a LEFT JOIN jobs j ON j.id=a.job_id WHERE $w GROUP BY a.status", $a), 'n', 'status');
    $out = [];
    foreach (PL_JOB_APP_STATUSES as $s) $out[$s] = (int)($c[$s] ?? 0);
    return $out;
}

/* lists for the applicant (mine) and for the poster (received) */
function pl_jobs_app_list(array $x, bool $received): array {
    [$page, $per] = pl_api_page();
    $w = $received ? 'j.user_id=?' : 'a.user_id=?'; $a = [$x['uid']];
    $jid = (int)($_GET['job_id'] ?? 0);
    if ($received && $jid) {
        if (!scalar('SELECT COUNT(*) FROM jobs WHERE id=? AND user_id=?', [$jid, $x['uid']])) return pl_jobs_404();
        $w .= ' AND a.job_id=?'; $a[] = $jid;
    }
    $q = trim((string)($_GET['q'] ?? ''));
    if ($received && $q !== '') { $w .= ' AND (a.applicant_name LIKE ? OR a.email LIKE ? OR a.phone LIKE ?)'; array_push($a, "%$q%", "%$q%", "%$q%"); }
    $counts = pl_jobs_status_counts($w, $a);
    if (in_array($_GET['status'] ?? '', PL_JOB_APP_STATUSES, true)) { $w .= ' AND a.status=?'; $a[] = $_GET['status']; }
    $total = scalar("SELECT COUNT(*) FROM jobs_applications a LEFT JOIN jobs j ON j.id=a.job_id WHERE $w", $a);
    $list = rows("SELECT a.*, j.job_title, j.company_name, j.company_logo, j.status job_status, j.closing_date, j.visibility_type FROM jobs_applications a
        LEFT JOIN jobs j ON j.id=a.job_id WHERE $w ORDER BY a.id DESC LIMIT $per OFFSET " . (($page - 1) * $per), $a);
    return ['total' => $total, 'page' => $page, 'per' => $per, 'total_pages' => (int)ceil($total / $per), 'counts' => $counts,
        'items' => array_map(fn($r) => pl_job_app_out($r, ['job_title' => $r['job_title'], 'company_name' => $r['company_name'], 'status' => $r['job_status']], $received)
            + ['company_logo' => $r['company_logo'], 'closing_date' => $r['closing_date'], 'is_global' => $r['visibility_type'] === 'global'], $list)];
}
pl_action('jobs_my_applications', function ($x) { pl_jobs_daily(); return pl_jobs_app_list($x, false); }, false, false);
foreach (['jobs_applications', 'jobs_received_applications'] as $__a) pl_action($__a, fn($x) => pl_jobs_app_list($x, true), false, false);

pl_action('jobs_application_details', function ($x) {
    $ctx = pl_jobs_app_for((int)($_GET['id'] ?? $_GET['application_id'] ?? 0), $x);
    if (!$ctx) return pl_jobs_404('Application');
    [$a, $j, $role] = $ctx;
    if ($role === 'poster' && $a['status'] === 'applied') { pl_jobs_app_set_status($a, 'viewed'); $a['status'] = 'viewed'; }
    $o = pl_job_app_out($a, $j, $role !== 'applicant') + ['viewer_role' => $role, 'history' => pl_jobs_app_history($a)];
    $o['job'] = $j ? pl_job_out($j, $x['uid'], false, $role === 'applicant' ? ['application' => $a] : []) : null;
    if ($role === 'applicant' && $j && $a['apply_method'] !== 'in_app') $o['contact'] = pl_job_contact($j, $x['user']);
    return ['application' => $o];
}, false, false);

pl_action('jobs_application_status', function ($x) {
    $ctx = pl_jobs_app_for((int)($_GET['id'] ?? $_GET['application_id'] ?? 0), $x);
    if (!$ctx || $ctx[2] !== 'applicant') return pl_jobs_404('Application');
    $a = $ctx[0];
    return ['application_id' => (int)$a['id'], 'application_code' => $a['application_code'], 'status' => $a['status'], 'status_label' => pl_status_label($a['status']),
        'updated_at' => $a['updated_at'], 'history' => pl_jobs_app_history($a)];
}, false, false);

pl_action('jobs_application_update_status', function ($x) {
    $ctx = pl_jobs_app_for((int)($_POST['id'] ?? $_POST['application_id'] ?? 0), $x);
    if (!$ctx || $ctx[2] === 'applicant') return pl_jobs_404('Application');
    [$a, $j] = $ctx;
    $new = strtolower(trim((string)($_POST['status'] ?? '')));
    if (!in_array($new, ['viewed', 'shortlisted', 'rejected', 'closed'], true)) return pl_jobs_err('Status must be viewed, shortlisted, rejected or closed.');
    if ($new !== $a['status']) pl_jobs_app_set_status($a, $new);
    return ['message' => 'Application marked as ' . strtolower(pl_status_label($new)) . '.', 'application' => pl_job_app_out(pl_entity_row(pl_entity('job_application'), (int)$a['id']), $j, true)];
});

/* ---------- Global Job Packages + Razorpay (common payment engine, module_key = jobs) ---------- */

function pl_jobs_package_rows(int $cid, int $id = 0): array {
    $a = [$cid]; $w = "module_key='jobs' AND is_active=1 AND (community_id=? OR visibility_type='global')";
    if ($id) { $w .= ' AND id=?'; $a[] = $id; }
    return rows("SELECT * FROM packages WHERE $w ORDER BY sort_order, price", $a);
}

pl_action('jobs_packages', fn($x) => ['packages' => array_map('pl_job_package_out', pl_jobs_package_rows($x['cid']))]
    + ($x['uid'] ? ['remaining_global_posts' => pl_job_remaining($x['uid'])] : []), true, false);
pl_action('jobs_package_details', function ($x) {
    $p = pl_jobs_package_rows($x['cid'], (int)($_GET['id'] ?? $_GET['package_id'] ?? 0))[0] ?? null;
    return $p ? ['package' => pl_job_package_out($p)] : pl_jobs_404('Package');
}, true, false);
pl_action('jobs_package_purchase', function ($x) {
    $id = (int)($_POST['package_id'] ?? $_POST['id'] ?? 0);
    if (!$id || !pl_jobs_package_rows($x['cid'], $id)) return pl_jobs_404('Package');
    return pl_txn_create($x['user'], $x['cid'], $id);
});
pl_action('jobs_payment_verify', function ($x) {
    $r = pl_txn_verify($x['uid'], (string)($_POST['razorpay_order_id'] ?? ''), (string)($_POST['razorpay_payment_id'] ?? ''), (string)($_POST['razorpay_signature'] ?? ''));
    if (empty($r['error'])) $r['remaining_global_posts'] = pl_job_remaining($x['uid']);
    return $r;
});
pl_action('jobs_active_package', function ($x) {
    pl_jobs_daily();
    $c = pl_job_credits($x['uid']);
    return ['active' => (bool)$c, 'remaining_global_posts' => array_sum(array_column($c, 'remaining')),
        'packages' => array_map(fn($r) => ['id' => (int)$r['id'], 'package_id' => (int)$r['package_id'], 'name' => $r['name'], 'starts_at' => $r['starts_at'], 'expires_at' => $r['expires_at'],
            'job_posts' => (int)$r['job_posts'], 'posts_used' => (int)$r['posts_used'], 'remaining' => $r['remaining'],
            'featured_listing' => (bool)$r['featured_listing'], 'priority_visibility' => (bool)$r['priority_visibility']], $c)];
}, false, false);
pl_action('jobs_remaining_posts', fn($x) => ['remaining_global_posts' => pl_job_remaining($x['uid']), 'package_required' => (bool)pl_setting('jobs_global_requires_package')], false, false);
pl_action('jobs_package_history', fn($x) => [
    'transactions' => array_map('pl_txn_out', rows("SELECT * FROM transactions WHERE user_id=? AND module_key='jobs' ORDER BY id DESC LIMIT 100", [$x['uid']])),
    'packages' => array_map(fn($r) => ['id' => (int)$r['id'], 'name' => $r['name'], 'starts_at' => $r['starts_at'], 'expires_at' => $r['expires_at'], 'status' => $r['status'],
        'job_posts' => (int)$r['job_posts'], 'posts_used' => (int)$r['posts_used']],
        rows("SELECT up.*, p.name, COALESCE(p.job_posts,0) job_posts FROM user_packages up LEFT JOIN packages p ON p.id=up.package_id WHERE up.user_id=? AND up.module_key='jobs' ORDER BY up.id DESC LIMIT 100", [$x['uid']]))],
    false, false);

/* ---------- notifications (jobs only; the general list is action=notifications) ---------- */

pl_action('jobs_notifications', function ($x) {
    [$page, $per] = pl_api_page();
    $w = "user_id=? AND (type IN ('job_application','job_closing','job_package','package_expiry') OR entity IN ('jobs','jobs_applications'))";
    return ['unread' => scalar("SELECT COUNT(*) FROM user_notifications WHERE $w AND is_read=0", [$x['uid']]), 'page' => $page,
        'notifications' => array_map(fn($n) => ['id' => (int)$n['id'], 'title' => $n['title'], 'message' => $n['message'], 'type' => $n['type'], 'entity' => $n['entity'],
            'entity_id' => $n['entity_id'] === null ? null : (int)$n['entity_id'], 'is_read' => (bool)$n['is_read'], 'created_at' => $n['created_at']],
            rows("SELECT * FROM user_notifications WHERE $w ORDER BY id DESC LIMIT $per OFFSET " . (($page - 1) * $per), [$x['uid']]))];
}, false, false);

foreach (['jobs_list', 'jobs_search', 'jobs_global', 'jobs_filters', 'jobs_details', 'jobs_categories', 'jobs_packages', 'jobs_package_details', 'jobs_payment_verify',
    'jobs_active_package', 'jobs_remaining_posts', 'jobs_package_history', 'jobs_resume', 'jobs_resume_get', 'jobs_resume_upload', 'jobs_resume_replace', 'jobs_resume_delete',
    'jobs_resume_download', 'jobs_my_applications', 'jobs_application_details', 'jobs_application_status', 'jobs_notifications', 'jobs_unsave'] as $__a) pl_action_nocomm($__a);
unset($__a);
