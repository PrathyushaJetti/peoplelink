<?php
/* Small shared helpers for the matrimony module. */

function mat_err(string $msg, string $code = 'VALIDATION_ERROR', int $http = 400): array {
    return ['error' => $msg, 'code' => $code, '_code' => $http];
}

/* Validates date of birth: required on create, real date, not in the future, age MAT_MIN_AGE..MAT_MAX_AGE. Returns an error array or null. */
function mat_check_dob(array $in, bool $required): ?array {
    $dob = trim((string)($in['date_of_birth'] ?? $in['dob'] ?? ''));
    if ($dob === '') return $required ? mat_err('Date of birth is required.') : null;
    $d = DateTime::createFromFormat('Y-m-d', $dob);
    if (!$d || $d->format('Y-m-d') !== $dob) return mat_err('Enter date of birth as YYYY-MM-DD.');
    if ($d > new DateTime('today')) return mat_err('Date of birth cannot be in the future.');
    $age = $d->diff(new DateTime('today'))->y;
    if ($age < MAT_MIN_AGE) return mat_err('You must be at least ' . MAT_MIN_AGE . ' years old to create a matrimony profile.', 'UNDERAGE');
    if ($age > MAT_MAX_AGE) return mat_err('Please check the date of birth.');
    return null;
}

/* Server-side profile validation (the browser checks the same rules). $create = all required fields must be present. */
function mat_check_profile(array $in, bool $create): ?array {
    $val = fn(array $keys) => trim((string)(array_values(array_filter(array_map(fn($k) => $in[$k] ?? null, $keys), fn($x) => $x !== null && $x !== ''))[0] ?? ''));
    $required = ['full name' => ['full_name'], 'gender' => ['gender'], 'marital status' => ['marital_status'], 'state' => ['state'], 'city' => ['city'],
        'education' => ['qualification', 'education'], 'profession' => ['profession'], 'mobile number' => ['mobile', 'phone'], 'about me' => ['about_me', 'about']];
    foreach ($required as $label => $keys) {
        $present = (bool)array_filter($keys, fn($k) => array_key_exists($k, $in));
        if (($create || $present) && $val($keys) === '') return mat_err('Please enter ' . $label . '.');
    }
    $mob = preg_replace('/\D/', '', $val(['mobile', 'phone']));
    if ($mob !== '' && !preg_match('/^[6-9]\d{9}$/', substr($mob, -10))) return mat_err('Enter a valid 10-digit mobile number.');
    $email = $val(['email']);
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) return mat_err('Enter a valid email address.');
    $about = $val(['about_me', 'about']);
    if ($about !== '' && mb_strlen($about) < 20) return mat_err('Write at least 20 characters in About me.');
    if (($g = $val(['gender'])) !== '' && !in_array(strtolower($g), ['male', 'female'], true)) return mat_err('Choose Male or Female.');
    foreach (['brothers', 'sisters'] as $k) if (isset($in[$k]) && $in[$k] !== '' && (!ctype_digit((string)$in[$k]) || (int)$in[$k] > 15)) return mat_err('Enter a valid number of ' . $k . '.');
    return null;
}

function mat_profile_user(int $profileId): ?int {
    $u = scalar('SELECT COALESCE(user_id,0) FROM matrimony_profiles WHERE id=?', [$profileId]);
    return $u ?: null;
}

function mat_page(): array {
    return [max(1, (int)($_REQUEST['page'] ?? 1)), max(1, min(50, (int)($_REQUEST['per'] ?? 12)))];
}

function mat_paged(array $all, int $page, int $per, string $key = 'items'): array {
    $total = count($all);
    return [$key => array_slice($all, ($page - 1) * $per, $per), 'total' => $total, 'page' => $page, 'per' => $per, 'total_pages' => (int)ceil($total / $per)];
}

/* Opposite-gender, not-blocked, same community check used by interests and contact requests. */
function mat_can_reach(array $me, array $to, int $uid): ?array {
    if ((int)$to['id'] === (int)$me['id']) return mat_err('This is your own profile.');
    if (!empty($me['gender']) && !empty($to['gender']) && strcasecmp($me['gender'], $to['gender']) === 0) return mat_err('You can connect only with profiles of the opposite gender.');
    if (pl_is_blocked($uid, (int)$to['id'])) return mat_err('You have blocked this profile. Unblock it first.', 'BLOCKED');
    $toUser = (int)($to['user_id'] ?? 0);
    if ($toUser && pl_is_blocked($toUser, (int)$me['id'])) return mat_err('Profile not available.', 'PROFILE_NOT_FOUND', 404);
    return null;
}
