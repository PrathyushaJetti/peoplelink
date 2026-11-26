<?php
// API login / register / logout - same PHP session as the website. Accepts JSON or form bodies.
pl_need_table('api_login_attempts', 'CREATE TABLE IF NOT EXISTS api_login_attempts (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(160) NULL, ip VARCHAR(45) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP, KEY idx_email (email, created_at), KEY idx_ip (ip, created_at)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

function pl_auth_payload(array $u, string $message): array {
    $comm = pl_resolve_community((int)$u['id']);
    $sx = ['user' => $u, 'uid' => (int)$u['id'], 'cid' => $comm ? (int)$comm['id'] : 0, 'comm' => $comm];
    return ['message' => $message] + ($GLOBALS['PL_ACTIONS']['session']['fn'])($sx);
}

function pl_auth_start(array $u): void {
    pl_session_login($u);
}

pl_action('login', function ($x) {
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $pw = (string)($_POST['password'] ?? '');
    // optional: login with the 10-digit mobile number instead of email (matrimony login popup)
    $mobile = substr(preg_replace('/\D/', '', (string)($_POST['phone'] ?? '')), -10);
    $byPhone = $email === '' && $mobile !== '';
    if ($byPhone && !preg_match('/^[6-9]\d{9}$/', $mobile)) return ['error' => 'Enter a valid 10-digit mobile number.', 'code' => 'VALIDATION_ERROR'];
    if (($byPhone ? $mobile : $email) === '' || $pw === '') return ['error' => ($byPhone ? 'Mobile number' : 'Email') . ' and password are required.', 'code' => 'VALIDATION_ERROR'];
    $who = $byPhone ? $mobile : $email;
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    if ((int)scalar('SELECT COUNT(*) FROM api_login_attempts WHERE (email=? OR ip=?) AND created_at > (NOW() - INTERVAL 10 MINUTE)', [$who, $ip]) >= 8) {
        return ['error' => 'Too many attempts. Please try again after a few minutes.', 'code' => 'RATE_LIMITED', '_code' => 429];
    }
    $u = null;
    if ($byPhone) { // a number can be on more than one account: use the one whose password matches
        $hits = array_values(array_filter(rows("SELECT * FROM users WHERE phone<>'' AND RIGHT(REGEXP_REPLACE(phone, '[^0-9]', ''), 10)=?", [$mobile]),
            fn($cand) => password_verify($pw, (string)$cand['password_hash'])));
        if (count($hits) > 1) return ['error' => 'This mobile number is linked to more than one account. Please continue with your email.', 'code' => 'PHONE_AMBIGUOUS', '_code' => 409];
        $u = $hits[0] ?? null;
    } else {
        $u = rows('SELECT * FROM users WHERE email=?', [$email])[0] ?? null;
        if ($u && !password_verify($pw, (string)$u['password_hash'])) $u = null;
    }
    if (!$u) {
        db()->prepare('INSERT INTO api_login_attempts (email, ip) VALUES (?,?)')->execute([$who, $ip]);
        return ['error' => 'Invalid ' . ($byPhone ? 'mobile number' : 'email') . ' or password.', 'code' => 'INVALID_CREDENTIALS', '_code' => 401];
    }
    $email = $who;
    db()->prepare('DELETE FROM api_login_attempts WHERE email=?')->execute([$email]);
    $blocked = pl_login_status_error($u) ?? pl_login_device_check($u, !empty($_POST['logout_oldest']) && $_POST['logout_oldest'] !== 'false');
    if ($blocked) return $blocked;
    pl_auth_start($u);
    return pl_auth_payload($u, 'Logged in.');
}, true, true);

pl_action('register', function ($x) {
    $name = trim((string)($_POST['name'] ?? ''));
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $phone = trim((string)($_POST['phone'] ?? ''));
    $pw = (string)($_POST['password'] ?? '');
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) return ['error' => 'Please enter your name and a valid email.', 'code' => 'VALIDATION_ERROR'];
    if (strlen($pw) < 6) return ['error' => 'Password must be at least 6 characters.', 'code' => 'VALIDATION_ERROR'];
    if (isset($_POST['confirm']) && $pw !== (string)$_POST['confirm']) return ['error' => 'Passwords do not match.', 'code' => 'VALIDATION_ERROR'];
    if (scalar('SELECT COUNT(*) FROM users WHERE email=?', [$email])) return ['error' => 'This email is already registered.', 'code' => 'EMAIL_EXISTS', '_code' => 409];
    db()->prepare('INSERT INTO users (name,email,phone,password_hash,role) VALUES (?,?,?,?,?)')->execute([mb_substr($name, 0, 120), $email, mb_substr($phone, 0, 30), password_hash($pw, PASSWORD_DEFAULT), SIGNUP_ROLE]);
    $u = rows('SELECT * FROM users WHERE id=?', [(int)db()->lastInsertId()])[0];
    pl_auth_start($u);
    return pl_auth_payload($u, 'Account created.');
}, true, true);

pl_action('logout', function ($x) {
    pl_session_logout();
    return ['message' => 'Logged out.'];
}, true, true);
