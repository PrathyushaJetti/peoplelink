<?php
// Forgot / reset password: one-time links that expire after 30 minutes. Only a hash of the token is stored.
pl_need_table('password_resets', 'CREATE TABLE IF NOT EXISTS password_resets (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, token_hash CHAR(64) NOT NULL,
    expires_at DATETIME NOT NULL, used_at DATETIME NULL, ip VARCHAR(45) NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_token (token_hash), KEY idx_user (user_id, created_at), KEY idx_ip (ip, created_at)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

const PL_RESET_MINUTES = 30;

/* true only for a request made on this computer (XAMPP), never for visitors of the live site */
function pl_reset_is_local(): bool {
    return in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)
        && preg_match('/^(localhost|127\.0\.0\.1)(:\d+)?$/', (string)($_SERVER['HTTP_HOST'] ?? ''));
}

/* Creates a reset link for this email if the account exists. Returns the link (null when nothing was sent). */
function pl_reset_request(string $email): ?string {
    $email = strtolower(trim($email)); $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    // limits: 3 links per account and 10 per IP address per hour
    if ((int)scalar('SELECT COUNT(*) FROM password_resets WHERE ip=? AND created_at > NOW() - INTERVAL 1 HOUR', [$ip]) >= 10) return null;
    $u = rows('SELECT * FROM users WHERE LOWER(email)=? LIMIT 1', [$email])[0] ?? null;
    if (!$u || in_array($u['status'] ?? 'active', ['suspended', 'deleted'], true)) return null;
    if ((int)scalar('SELECT COUNT(*) FROM password_resets WHERE user_id=? AND created_at > NOW() - INTERVAL 1 HOUR', [$u['id']]) >= 3) return null;
    $token = bin2hex(random_bytes(32));
    db()->prepare('INSERT INTO password_resets (user_id, token_hash, expires_at, ip) VALUES (?,?, NOW() + INTERVAL ' . PL_RESET_MINUTES . ' MINUTE, ?)')
        ->execute([(int)$u['id'], hash('sha256', $token), $ip]);
    $link = DASHBOARD_URL . 'reset-password.php?token=' . $token;
    $body = "Hello {$u['name']},\n\nWe received a request to reset your PeopleLink password.\nOpen this link to choose a new password (valid for " . PL_RESET_MINUTES . " minutes):\n\n$link\n\nIf you did not ask for this, you can ignore this email. Your password will not change.\n\nPeopleLink";
    @mail($u['email'], 'Reset your PeopleLink password', $body, "From: PeopleLink <no-reply@" . BASE_DOMAIN . ">\r\nContent-Type: text/plain; charset=UTF-8");
    pl_audit('user:password_reset_requested', null, (int)$u['id'], 'reset link created');
    return $link;
}

/* the valid (unused, not expired) reset row for a token, or null */
function pl_reset_find(string $token): ?array {
    if (!preg_match('/^[a-f0-9]{64}$/', $token)) return null;
    return rows('SELECT r.*, u.name, u.email FROM password_resets r JOIN users u ON u.id=r.user_id WHERE r.token_hash=? AND r.used_at IS NULL AND r.expires_at > NOW()', [hash('sha256', $token)])[0] ?? null;
}

/* sets the new password, uses up the link (and every other open link of that account) and logs out all devices */
function pl_reset_complete(array $r, string $password): void {
    db()->prepare('UPDATE users SET password_hash=? WHERE id=?')->execute([password_hash($password, PASSWORD_DEFAULT), (int)$r['user_id']]);
    db()->prepare('UPDATE password_resets SET used_at=NOW() WHERE user_id=? AND used_at IS NULL')->execute([(int)$r['user_id']]);
    db()->prepare('DELETE FROM api_login_attempts WHERE email=?')->execute([strtolower($r['email'])]);
    pl_revoke_all_sessions((int)$r['user_id']);
    pl_audit('user:password_reset', null, (int)$r['user_id'], 'by reset link');
}

/* same rule as Change Password */
function pl_password_problem(string $p, string $confirm): ?string {
    if (strlen($p) < 8 || !preg_match('/[A-Za-z]/', $p) || !preg_match('/\d/', $p)) return 'Password must be at least 8 characters with letters and numbers.';
    if ($p !== $confirm) return 'Password and confirm password do not match.';
    return null;
}
