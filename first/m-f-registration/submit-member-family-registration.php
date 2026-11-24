<?php
// Saves the Member & Family Registration form (member-family-registration.php).
// "submit" -> member profile + family + family members are saved and sent for admin approval.
// "draft"  -> the typed values are kept on the account so the form can be finished later.
require_once dirname(__DIR__, 2) . '/matrimoney/includes/bridge.php';
pl_ensure_schema();

$back = 'member-family-registration.php';
$go = function (string $status, string $msg = '') use ($back) {
    if ($msg !== '') $_SESSION['mf_msg'] = $msg;
    header('Location: ' . $back . '?status=' . $status); exit;
};
$user = current_user();
if (!$user) { header('Location: ' . DASHBOARD_URL . 'login.php?next=' . urlencode('/peoplelink/first/m-f-registration/' . $back)); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ' . $back); exit; }
if (!hash_equals((string)($_SESSION['member_family_csrf'] ?? ''), (string)($_POST['csrf_token'] ?? ''))) $go('error', 'Your session expired. Please try again.');

$uid = (int)$user['id'];
$comm = pl_resolve_community($uid);
if (!$comm) $go('error', 'Please select your community first.');
$cid = (int)$comm['id'];

$P = fn(string $group, string $key, int $len = 255) => mb_substr(trim((string)($_POST[$group][$key] ?? '')), 0, $len);
$prefs = json_decode($user['prefs'] ?? '', true) ?: [];

/* ---------- draft ---------- */
if (($_POST['submission_mode'] ?? 'submit') === 'draft') {
    $draft = $_POST; unset($draft['csrf_token'], $draft['submission_mode']);
    array_walk_recursive($draft, function (&$v) { $v = mb_substr((string)$v, 0, 500); });
    $prefs['mf_draft'] = $draft; $prefs['mf_draft_at'] = date('c');
    db()->prepare('UPDATE users SET prefs=? WHERE id=?')->execute([json_encode($prefs, JSON_UNESCAPED_UNICODE), $uid]);
    $go('draft_saved');
}

/* ---------- validation ---------- */
$errors = [];
$name = $P('primary', 'full_name', 120);
$gender = $P('primary', 'gender', 30);
$dobRaw = $P('primary', 'date_of_birth', 20);
$dob = $dobRaw !== '' && ($t = strtotime($dobRaw)) ? date('Y-m-d', $t) : null;
$marital = $P('primary', 'marital_status', 30);
$mobile = preg_replace('/[^\d+]/', '', $P('primary', 'mobile', 30));
$email = strtolower($P('primary', 'email', 160));
if ($name === '') $errors[] = 'Please enter your full name.';
if ($gender === '') $errors[] = 'Please select your gender.';
if (!$dob || strtotime($dob) > time() || (int)date('Y', strtotime($dob)) < 1900) $errors[] = 'Please enter a valid date of birth.';
elseif ($dob > date('Y-m-d', strtotime('-18 years'))) $errors[] = 'The primary member must be at least 18 years old. Add children as family members instead.';
if ($marital === '') $errors[] = 'Please select your marital status.';
if (!preg_match('/^\+?\d{10,15}$/', $mobile)) $errors[] = 'Please enter a valid mobile number.';
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
$familyName = $P('community', 'family_name', 120);
if ($familyName === '') $errors[] = 'Please enter your family name / surname.';
$pin = $P('address', 'pincode', 10);
if ($pin !== '' && !preg_match('/^\d{6}$/', $pin)) $errors[] = 'Pincode must be 6 digits.';
if (empty($_POST['consent'])) $errors[] = 'Please confirm that the information is correct.';

$members = [];
foreach ((array)($_POST['members'] ?? []) as $i => $m) {
    if (!is_array($m)) continue;
    $mn = mb_substr(trim((string)($m['full_name'] ?? '')), 0, 120); $rel = trim((string)($m['relationship'] ?? ''));
    if ($mn === '' && $rel === '') continue; // empty row
    if ($mn === '') { $errors[] = 'Please enter the name of family member ' . ($i + 1) . '.'; continue; }
    if (!in_array($rel, PL_RELATIONS, true)) { $errors[] = 'Please choose the relationship for ' . $mn . '.'; continue; }
    $mm = preg_replace('/[^\d+]/', '', (string)($m['mobile'] ?? ''));
    if ($mm !== '' && !preg_match('/^\+?\d{10,15}$/', $mm)) { $errors[] = 'Please check the mobile number of ' . $mn . '.'; continue; }
    $md = trim((string)($m['date_of_birth'] ?? ''));
    $members[] = ['idx' => $i, 'full_name' => $mn, 'relationship' => $rel, 'gender' => in_array($m['gender'] ?? '', PL_GENDERS, true) ? $m['gender'] : null,
        'dob' => $md !== '' && ($t = strtotime($md)) && $t <= time() ? date('Y-m-d', $t) : null, 'phone' => $mm,
        'education' => mb_substr(trim((string)($m['education'] ?? '')), 0, 255), 'occupation' => mb_substr(trim((string)($m['occupation'] ?? '')), 0, 255),
        'marital_status' => mb_substr(trim((string)($m['marital_status'] ?? '')), 0, 30) ?: null];
}
// spouse / father / mother typed in "Family details" become family members too (if not already in the list)
foreach (['spouse_name' => 'Spouse', 'father_name' => 'Father', 'mother_name' => 'Mother'] as $k => $rel) {
    $n = $P('family', $k, 120);
    if ($n === '') continue;
    foreach ($members as $m) if ($m['relationship'] === $rel || strcasecmp($m['full_name'], $n) === 0) continue 2;
    $members[] = ['idx' => null, 'full_name' => $n, 'relationship' => $rel, 'gender' => $rel === 'Father' ? 'Male' : ($rel === 'Mother' ? 'Female' : null),
        'dob' => null, 'phone' => '', 'education' => '', 'occupation' => '', 'marital_status' => $rel === 'Spouse' ? 'Married' : null];
}
if ($errors) $go('error', implode("\n", $errors));

/* nested upload field, e.g. primary[profile_photo] or members[2][profile_photo] */
function mf_file(string $group, ...$path): ?array {
    if (empty($_FILES[$group])) return null;
    $f = [];
    foreach (['name', 'type', 'tmp_name', 'error', 'size'] as $k) { $v = $_FILES[$group][$k]; foreach ($path as $p) $v = $v[$p] ?? null; $f[$k] = $v; }
    return ($f['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE || $f['tmp_name'] === null ? null : $f;
}

/* ---------- save ---------- */
$vis = fn($on) => $on ? 'members' : 'private';
$priv = (array)($_POST['privacy'] ?? []);
$house = $P('address', 'house_number', 120); $area = $P('address', 'area', 255);
$city = $P('address', 'city', 80) ?: $P('community', 'current_city', 80); $state = $P('address', 'state', 80);
$address = trim($house . ($house !== '' && $area !== '' ? ', ' : '') . $area);
$warn = [];

$db = db();
$db->beginTransaction();
try {
    $ME = pl_entity('member'); $FE = pl_entity('family'); $FME = pl_entity('family_member');
    $oldM = rows('SELECT * FROM members WHERE user_id=? AND community_id=? ORDER BY id DESC LIMIT 1', [$uid, $cid])[0] ?? null;
    $md = json_decode($oldM['details'] ?? '', true) ?: [];
    $md = array_merge($md, ['blood_group' => $P('primary', 'blood_group', 10), 'gotram' => $P('community', 'gotram', 120), 'native_place' => $P('community', 'native_place', 120), 'surname' => $familyName]);
    $mcols = ['full_name' => $name, 'gender' => in_array($gender, PL_GENDERS, true) ? $gender : null, 'dob' => $dob, 'marital_status' => $marital, 'phone' => $mobile,
        'email' => $email ?: $user['email'], 'education' => $P('primary', 'education'), 'occupation' => $P('primary', 'occupation'), 'address' => $address, 'area' => $area,
        'city' => $city, 'state' => $state, 'pincode' => $pin, 'status' => 'pending', 'details' => json_encode($md, JSON_UNESCAPED_UNICODE),
        'contact_visibility' => $vis(!empty($priv['show_mobile']) || !empty($priv['show_email'])), 'family_visibility' => $vis(!empty($priv['show_family_members']))];
    if ($pf = mf_file('primary', 'profile_photo')) { $up = pl_store_upload($pf, 'members'); if (!empty($up['error'])) $warn[] = 'Your photo was not saved: ' . $up['error']; else { $mcols['photo'] = $up['url']; if ($oldM) pl_delete_file($oldM['photo'] ?? null); } }
    if ($oldM) pl_entity_update($ME, (int)$oldM['id'], $mcols);
    else pl_entity_insert($ME, $mcols, ['community_id' => $cid, 'user_id' => $uid, 'created_by' => $uid]);

    $oldF = rows('SELECT * FROM families WHERE user_id=? AND community_id=? ORDER BY id DESC LIMIT 1', [$uid, $cid])[0] ?? null;
    $fd = json_decode($oldF['details'] ?? '', true) ?: [];
    $fd = array_merge($fd, ['gotram' => $P('community', 'gotram', 120), 'primary_contact' => preg_replace('/[^\d+]/', '', $P('family', 'primary_contact', 30)),
        'alternate_contact' => preg_replace('/[^\d+]/', '', $P('family', 'alternate_contact', 30)), 'email' => $P('family', 'email', 160), 'member_count' => max((int)$P('family', 'member_count', 4), 1 + count($members)),
        'privacy' => array_map(fn($v) => (bool)$v, array_intersect_key($priv, array_flip(['show_mobile', 'show_email', 'show_address', 'show_family_members', 'allow_contact'])))]);
    $fcols = ['family_name' => $familyName, 'head_name' => $name, 'address' => $address, 'area' => $area, 'city' => $city, 'state' => $state, 'pincode' => $pin,
        'native_place' => $P('community', 'native_place', 120), 'status' => 'pending', 'details' => json_encode($fd, JSON_UNESCAPED_UNICODE)];
    if ($oldF) { $fid = (int)$oldF['id']; pl_entity_update($FE, $fid, $fcols); }
    else $fid = pl_entity_insert($FE, $fcols, ['community_id' => $cid, 'user_id' => $uid, 'created_by' => $uid, 'tree_status' => 'none']);

    // the head of the family is the registering member ("Self")
    $self = rows("SELECT id FROM family_members WHERE family_id=? AND is_head=1 LIMIT 1", [$fid])[0] ?? null;
    $selfCols = ['full_name' => $name, 'relationship' => 'Self', 'gender' => $mcols['gender'], 'dob' => $dob, 'marital_status' => $marital, 'phone' => $mobile,
        'email' => $mcols['email'], 'education' => $mcols['education'], 'occupation' => $mcols['occupation'], 'is_head' => 1, 'status' => 'pending'] + (isset($mcols['photo']) ? ['photo' => $mcols['photo']] : []);
    if ($self) pl_entity_update($FME, (int)$self['id'], $selfCols);
    else pl_entity_insert($FME, $selfCols + ['family_id' => $fid], ['community_id' => $cid, 'user_id' => $uid, 'created_by' => $uid]);

    $added = 0;
    foreach ($members as $m) {
        $dup = rows('SELECT id FROM family_members WHERE family_id=? AND LOWER(full_name)=LOWER(?) AND relationship=? LIMIT 1', [$fid, $m['full_name'], $m['relationship']])[0] ?? null;
        $cols = array_diff_key($m, ['idx' => 1]) + ['status' => 'pending', 'is_head' => 0];
        if ($m['idx'] !== null && ($mf = mf_file('members', $m['idx'], 'profile_photo'))) { $up = pl_store_upload($mf, 'members'); if (!empty($up['error'])) $warn[] = 'Photo of ' . $m['full_name'] . ' was not saved: ' . $up['error']; else $cols['photo'] = $up['url']; }
        if ($dup) pl_entity_update($FME, (int)$dup['id'], $cols);
        else { pl_entity_insert($FME, $cols + ['family_id' => $fid], ['community_id' => $cid, 'user_id' => $uid, 'created_by' => $uid]); $added++; }
    }
    $db->commit();
} catch (Throwable $e) {
    $db->rollBack();
    error_log('PL member-family registration: ' . $e->getMessage());
    $go('error', 'Something went wrong while saving. Please try again.');
}
pl_audit($oldF ? 'app_update' : 'app_create', 'family', $fid, $familyName . ' (website registration)', $cid);
unset($prefs['mf_draft'], $prefs['mf_draft_at']);
db()->prepare('UPDATE users SET prefs=? WHERE id=?')->execute([json_encode($prefs, JSON_UNESCAPED_UNICODE), $uid]);
$_SESSION['member_family_csrf'] = bin2hex(random_bytes(32)); // one submit per form load
$go('submitted', $warn ? implode("\n", $warn) : '');
