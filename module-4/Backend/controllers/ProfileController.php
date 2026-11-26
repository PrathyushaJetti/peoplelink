<?php
/* Profile, search and dashboard actions. Existing actions from matrimoney/includes/actions.php are wrapped (their logic is reused), not copied. */

$__orig = fn(string $a) => $GLOBALS['PL_ACTIONS'][$a]['fn'];

/* create_profile: date of birth required and 18+, then the existing create logic */
$__create = $__orig('create_profile');
pl_action('create_profile', function ($x) use ($__create) {
    if ($e = mat_check_dob($_POST, true)) return $e;
    if ($e = mat_check_profile($_POST, true)) return $e;
    unset($_POST["profile_form"]); // form marker only, not profile data
    return $__create($x); // the existing code already records the "Profile submitted" notice
});

$__update = $__orig('update_profile');
pl_action('update_profile', function ($x) use ($__update) {
    if ($e = mat_check_dob($_POST, false)) return $e;
    if ($e = mat_check_profile($_POST, false)) return $e;
    unset($_POST["profile_form"]);
    unset($_POST['gender']); // gender is fixed after creation
    return $__update($x);
});

/* me: own profile + completion %, dashboard counts and package status */
pl_action('me', function ($x) {
    $p = pl_me($x['uid'], $x['cid'] ?: null);
    if (!$p) return ['profile' => null, 'entitlement' => mat_entitlement($x['uid'])];
    $row = pl_my_profile($x['uid'], $x['cid'] ?: null);
    $p['is_active'] = (bool)$row['is_active'];
    $p['completion'] = mat_completion($row);
    return ['profile' => $p, 'stats' => mat_dashboard($x['uid'], $x['cid'], $row), 'entitlement' => mat_entitlement($x['uid'])];
}, false, false);

/* profile: existing visibility rules + match %, contact-request state, visitor log */
$__profile = $__orig('profile');
pl_action('profile', function ($x) use ($__profile) {
    $r = $__profile($x);
    if (empty($r['profile']) || !$x['uid']) return $r;
    $p = &$r['profile'];
    $me = pl_my_profile($x['uid'], (int)$x['cid'] ?: null);
    if (!$me || $p['is_own']) { $p['match_percent'] = null; return $r; }
    $p['match_percent'] = mat_match(pl_prefs((int)$me['id']), $p);
    [$p['pref_match'], $p['common']] = mat_viewer_fit($me, $p['preferences'] ?? [], $p['details'] ?? []);
    $cr = mat_contact_between((int)$me['id'], (int)$p['id']);
    $p['contact_request'] = $cr ? ['id' => (int)$cr['id'], 'status' => $cr['status'], 'direction' => (int)$cr['requester_profile_id'] === (int)$me['id'] ? 'sent' : 'received'] : null;
    if (!$p['contact_visible'] && mat_contact_unlocked((int)$me['id'], (int)$p['id'])) {
        $row = rows('SELECT phone, email FROM matrimony_profiles WHERE id=?', [$p['id']])[0] ?? [];
        $p['phone'] = $row['phone'] ?? ''; $p['email'] = $row['email'] ?? ''; $p['contact_visible'] = true;
    }
    if ($me['status'] === 'approved') mat_log_visit((int)$me['id'], (int)$p['id']);
    return $r;
}, true, false);

/* search: existing filters + match % per card */
$__search = $__orig('search');
pl_action('search', function ($x) use ($__search) {
    $r = $__search($x);
    $me = $x['uid'] ? pl_my_profile($x['uid'], $x['cid'] ?: null) : null;
    $prefs = $me ? pl_prefs((int)$me['id']) : null;
    foreach ($r['profiles'] ?? [] as $k => $c) $r['profiles'][$k]['match_percent'] = mat_match($prefs, $c);
    return $r;
}, true, false);

pl_action('matrimony_filters', function ($x) {
    // a member with a profile only searches the opposite gender, so counts are for that gender
    $me = $x['uid'] ? pl_my_profile($x['uid'], (int)$x['cid'] ?: null) : null;
    $g = $me && !empty($me['gender']) ? (strtolower($me['gender'][0]) === 'f' ? 'Male' : 'Female') : null;
    return ['filters' => mat_filters((int)$x['cid'], $g)];
}, true, false);

pl_action('matrimony_dashboard', function ($x) {
    $me = pl_my_profile($x['uid'], $x['cid']);
    if (!$me) return mat_err('Create your matrimony profile first.', 'PROFILE_REQUIRED');
    return ['stats' => mat_dashboard($x['uid'], $x['cid'], $me), 'completion' => mat_completion($me), 'status' => $me['status'], 'entitlement' => mat_entitlement($x['uid'])];
}, false, false);

pl_action('matrimony_visitors', function ($x) {
    $me = pl_my_profile($x['uid'], $x['cid']);
    if (!$me) return mat_err('Create your matrimony profile first.', 'PROFILE_REQUIRED');
    [$page, $per] = mat_page();
    return mat_paged(mat_visitors((int)$me['id']), $page, $per, 'profiles');
}, false, false);

/* report_profile: stops self-reports and repeat open reports, keeps the reporter's user id */
pl_action('report_profile', function ($x) {
    $pid = (int)($_POST['profile_id'] ?? 0);
    $reason = trim((string)($_POST['reason'] ?? ''));
    $details = trim((string)($_POST['details'] ?? ''));
    if ($reason === '') return mat_err('Please choose a reason.');
    $p = rows('SELECT id, user_id FROM matrimony_profiles WHERE id=? AND community_id=?', [$pid, $x['cid']])[0] ?? null;
    if (!$p) return mat_err('Profile not found.', 'PROFILE_NOT_FOUND', 404);
    if ((int)$p['user_id'] === $x['uid']) return mat_err('You cannot report your own profile.', 'CANNOT_REPORT_OWN_CONTENT');
    if (scalar("SELECT COUNT(*) FROM matrimony_reports WHERE reported_profile_id=? AND reporter_user_id=? AND status='open'", [$pid, $x['uid']])) return mat_err('You have already reported this profile. Our team is reviewing it.', 'ALREADY_REPORTED', 409);
    $text = mb_substr($reason . ($details !== '' ? ' — ' . $details : ''), 0, 255);
    db()->prepare('INSERT INTO matrimony_reports (community_id, reported_profile_id, reporter_name, reporter_user_id, reason) VALUES (?,?,?,?,?)')->execute([$x['cid'], $pid, $x['user']['name'], $x['uid'], $text]);
    if (!empty($_POST['also_block'])) pl_block_profile($x['uid'], $x['cid'], $pid, true);
    return ['message' => 'Report submitted. Our team will review it.' . (!empty($_POST['also_block']) ? ' The profile is also blocked.' : '')];
});

unset($__orig, $__create, $__update, $__profile, $__search);
