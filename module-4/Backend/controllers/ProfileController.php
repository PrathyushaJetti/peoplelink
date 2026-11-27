<?php
/* Profile, search and dashboard actions. Existing actions from matrimoney/includes/actions.php are wrapped (their logic is reused), not copied. */

$__orig = fn(string $a) => $GLOBALS['PL_ACTIONS'][$a]['fn'];

/* create_profile: date of birth required and 18+, then the existing create logic */
$__create = $__orig('create_profile');
pl_action('create_profile', function ($x) use ($__create) {
    if ($e = mat_check_dob($_POST, true)) return $e;
    if ($e = mat_check_profile($_POST, true)) return $e;
    unset($_POST["profile_form"]); // form marker only, not profile data
    $r = $__create($x); // the existing code already records the "Profile submitted" notice
    if (empty($r["error"])) unset($_SESSION["mat_signup"]); // sign-up popup answers are used once
    return $r;
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
    if ($me && !empty($r['profiles'])) {
        $ids = array_map(fn($c) => (int)$c['id'], $r['profiles']); $ph = implode(',', array_fill(0, count($ids), '?'));
        $st = [];
        foreach (rows("SELECT id, sender_id, receiver_id, status FROM matrimony_interests WHERE (sender_id=? AND receiver_id IN ($ph)) OR (receiver_id=? AND sender_id IN ($ph)) ORDER BY id", array_merge([$me['id']], $ids, [$me['id']], $ids)) as $i) {
            $other = (int)$i['sender_id'] === (int)$me['id'] ? (int)$i['receiver_id'] : (int)$i['sender_id'];
            $st[$other] = ['id' => (int)$i['id'], 'status' => $i['status'], 'direction' => (int)$i['sender_id'] === (int)$me['id'] ? 'sent' : 'received'];
        }
        foreach ($r['profiles'] as $k => $c) $r['profiles'][$k]['interest'] = $st[(int)$c['id']] ?? null;
    }
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

/* mat_register: the step-by-step sign-up popup on the matrimony pages.
   Same rules as matrimoney/signup.php, then the existing "register" action creates the account.
   The new account joins the community being viewed, and the answers prefill the Create Profile form. */
pl_action('mat_register', function ($x) {
    $__register = $GLOBALS['PL_ACTIONS']['register']['fn']; // the existing account-creation action
    require_once dirname(__DIR__, 3) . '/matrimoney/includes/password_reset.php';
    $in = fn($k) => trim((string)($_POST[$k] ?? ''));
    $for = $in('profile_for'); $gender = $in('gender'); $name = $in('name'); $dob = $in('dob');
    $phone = substr(preg_replace('/\D/', '', $in('phone')), -10); $email = strtolower($in('email'));
    $forMap = ['Myself' => 'Self', 'My Son' => 'Parent', 'My Daughter' => 'Parent', 'My Brother' => 'Sibling', 'My Sister' => 'Sibling', 'My Relative' => 'Relative', 'My Friend' => 'Friend'];
    if (!isset($forMap[$for])) return mat_err('Please choose who this profile is for.');
    if (in_array($for, ['My Son', 'My Brother'], true)) $gender = 'Male';
    if (in_array($for, ['My Daughter', 'My Sister'], true)) $gender = 'Female';
    if (!in_array($gender, ['Male', 'Female'], true)) return mat_err('Please choose the gender.');
    if (mb_strlen($name) < 2 || mb_strlen($name) > 100) return mat_err('Please enter the full name.');
    if ($e = mat_check_dob(['date_of_birth' => $dob], true)) return $e;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return mat_err('Please enter a valid email address.');
    if (!preg_match('/^[6-9]\d{9}$/', $phone)) return mat_err('Please enter a valid 10-digit mobile number.');
    if ($p = pl_password_problem((string)($_POST['password'] ?? ''), (string)($_POST['confirm'] ?? ''))) return mat_err($p);
    $_POST['phone'] = $phone; $_POST['email'] = $email; $_POST['name'] = $name;
    $r = $__register($x);
    if (!empty($r['error'])) return $r;
    // join the community being viewed (a member account belongs to one community)
    if ($x['cid'] && ($uid = (int)($_SESSION['uid'] ?? $_SESSION['user_id'] ?? 0) ?: (int)scalar('SELECT id FROM users WHERE email=?', [$email]))) {
        db()->prepare('UPDATE users SET community_id=? WHERE id=? AND community_id IS NULL')->execute([$x['cid'], $uid]);
    }
    $_SESSION['mat_signup'] = ['profile_created_by' => $forMap[$for], 'gender' => $gender, 'full_name' => $name, 'date_of_birth' => $dob,
        'religion' => $in('religion'), 'mother_tongue' => $in('mother_tongue')];
    return ['message' => 'Account created.', 'next' => MAT_URL . 'profile-form.php?first=1'];
}, true, true);
