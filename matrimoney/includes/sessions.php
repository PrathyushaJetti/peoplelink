<?php
// Login sessions / devices. PeopleLink rule: a member account may be logged in on at most N devices (setting device_limit, default 3).
// Each PHP session that belongs to a logged-in user gets one row; logging a device out revokes its row.

function pl_sessions_table(): void {
    if (!empty($_SESSION['pl_sess_tbl'])) return;
    db()->exec('CREATE TABLE IF NOT EXISTS user_sessions (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, session_hash CHAR(64) NOT NULL,
        device_id VARCHAR(120) NULL, device_name VARCHAR(120) NULL, platform VARCHAR(20) NULL, ip VARCHAR(45) NULL, user_agent VARCHAR(255) NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP, last_seen_at DATETIME DEFAULT CURRENT_TIMESTAMP, revoked_at DATETIME NULL,
        UNIQUE KEY uq_hash (session_hash), KEY idx_user (user_id, revoked_at)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
    $_SESSION['pl_sess_tbl'] = 1;
}

function pl_session_hash(): string { return hash('sha256', session_id()); }

/* Sessions older than PHP's session lifetime are already gone on the server, so they do not count as active devices. */
function pl_session_window(): int { return max(1440, (int)ini_get('session.gc_maxlifetime')); }

function pl_device_info(): array {
    $ua = (string)($_SERVER['HTTP_USER_AGENT'] ?? '');
    $platform = strtolower(trim((string)($_POST['platform'] ?? $_SERVER['HTTP_X_PLATFORM'] ?? '')));
    if (!in_array($platform, ['android', 'ios', 'web'], true)) $platform = preg_match('/android/i', $ua) ? 'android' : (preg_match('/iphone|ipad/i', $ua) ? 'ios' : 'web');
    $name = trim((string)($_POST['device_name'] ?? $_SERVER['HTTP_X_DEVICE_NAME'] ?? ''));
    if ($name === '') $name = preg_match('/(Edg|Chrome|Firefox|Safari|OPR)\//', $ua, $m) ? ['Edg' => 'Edge', 'OPR' => 'Opera'][$m[1]] ?? $m[1] : 'Browser';
    return ['device_id' => mb_substr(trim((string)($_POST['device_id'] ?? $_SERVER['HTTP_X_DEVICE_ID'] ?? '')), 0, 120) ?: null,
        'device_name' => mb_substr($name, 0, 120), 'platform' => $platform, 'ip' => $_SERVER['REMOTE_ADDR'] ?? null, 'user_agent' => mb_substr($ua, 0, 255)];
}

function pl_active_sessions(int $uid): array {
    pl_sessions_table();
    return rows('SELECT * FROM user_sessions WHERE user_id=? AND revoked_at IS NULL AND last_seen_at > (NOW() - INTERVAL ' . pl_session_window() . ' SECOND) ORDER BY last_seen_at DESC', [$uid]);
}

function pl_device_limit(): int {
    try { $v = rows("SELECT v FROM settings WHERE k='device_limit'")[0]['v'] ?? null; } catch (Throwable $e) { $v = null; }
    return max(1, (int)($v ?? 3));
}

/* Called right before a login. Returns an error array when the account already uses all its devices. */
function pl_login_device_check(array $u, bool $logoutOldest): ?array {
    if (($u['role'] ?? '') === 'admin') return null;
    pl_sessions_table();
    $mine = pl_session_hash();
    $active = array_values(array_filter(pl_active_sessions((int)$u['id']), fn($s) => $s['session_hash'] !== $mine));
    $limit = pl_device_limit();
    if (count($active) < $limit) return null;
    if ($logoutOldest) {
        usort($active, fn($a, $b) => strcmp($a['last_seen_at'], $b['last_seen_at']));
        foreach (array_slice($active, 0, count($active) - $limit + 1) as $s) pl_revoke_session((int)$s['id']);
        return null;
    }
    return ['error' => "This account is already logged in on $limit devices. Log out from one device, or log in again and choose to log out the oldest device.",
        'code' => 'DEVICE_LIMIT', '_code' => 403,
        'devices' => array_map(fn($s) => ['id' => (int)$s['id'], 'device_name' => $s['device_name'], 'platform' => $s['platform'], 'last_seen_at' => $s['last_seen_at']], $active)];
}

/* Logs the browser/app in: call after the password check and the device check. */
function pl_session_login(array $u): void {
    pl_sessions_table();
    db()->prepare('UPDATE user_sessions SET revoked_at=NOW() WHERE session_hash=? AND revoked_at IS NULL')->execute([pl_session_hash()]);
    session_regenerate_id(true);
    $_SESSION['uid'] = (int)$u['id'];
    $_SESSION['pl_sess_tbl'] = 1;
    $d = pl_device_info();
    db()->prepare('INSERT INTO user_sessions (user_id, session_hash, device_id, device_name, platform, ip, user_agent) VALUES (?,?,?,?,?,?,?)')
        ->execute([(int)$u['id'], pl_session_hash(), $d['device_id'], $d['device_name'], $d['platform'], $d['ip'], $d['user_agent']]);
    try { db()->prepare('UPDATE users SET last_login_at=NOW() WHERE id=?')->execute([(int)$u['id']]); } catch (Throwable $e) {}
}

function pl_session_logout(): void {
    try { pl_sessions_table(); db()->prepare('UPDATE user_sessions SET revoked_at=NOW() WHERE session_hash=? AND revoked_at IS NULL')->execute([pl_session_hash()]); } catch (Throwable $e) {}
    $_SESSION = [];
    if (session_status() === PHP_SESSION_ACTIVE) session_destroy();
}

function pl_revoke_session(int $id, ?int $uid = null): bool {
    pl_sessions_table();
    $s = rows('SELECT * FROM user_sessions WHERE id=?' . ($uid ? ' AND user_id=?' : ''), $uid ? [$id, $uid] : [$id])[0] ?? null;
    if (!$s) return false;
    db()->prepare('UPDATE user_sessions SET revoked_at=NOW() WHERE id=? AND revoked_at IS NULL')->execute([$id]);
    if ($s['device_id']) { try { db()->prepare('UPDATE device_tokens SET is_active=0 WHERE user_id=? AND device_id=?')->execute([$s['user_id'], $s['device_id']]); } catch (Throwable $e) {} }
    return true;
}

function pl_revoke_all_sessions(int $uid, bool $exceptCurrent = false): int {
    pl_sessions_table();
    $n = 0;
    foreach (pl_active_sessions($uid) as $s) if (!$exceptCurrent || $s['session_hash'] !== pl_session_hash()) { pl_revoke_session((int)$s['id']); $n++; }
    return $n;
}

/* Runs on every request of a logged-in user: false = this device was logged out (by the user or an admin). */
function pl_session_touch(array $u): bool {
    static $ok = null;
    if ($ok !== null) return $ok;
    try {
        pl_sessions_table();
        $s = rows('SELECT id, revoked_at, last_seen_at FROM user_sessions WHERE session_hash=?', [pl_session_hash()])[0] ?? null;
        if (!$s) {
            $d = pl_device_info();
            db()->prepare('INSERT INTO user_sessions (user_id, session_hash, device_id, device_name, platform, ip, user_agent) VALUES (?,?,?,?,?,?,?)')
                ->execute([(int)$u['id'], pl_session_hash(), $d['device_id'], $d['device_name'], $d['platform'], $d['ip'], $d['user_agent']]);
        } elseif ($s['revoked_at']) return $ok = false;
        elseif (strtotime($s['last_seen_at']) < time() - 60) db()->prepare('UPDATE user_sessions SET last_seen_at=NOW(), ip=? WHERE id=?')->execute([$_SERVER['REMOTE_ADDR'] ?? null, $s['id']]);
    } catch (Throwable $e) { error_log('PL session: ' . $e->getMessage()); }
    return $ok = true;
}

/* Account status check shared by every login form. */
function pl_login_status_error(array $u): ?array {
    $st = $u['status'] ?? 'active';
    if ($st === 'suspended') return ['error' => 'Your account is suspended. Please contact PeopleLink support.', 'code' => 'ACCOUNT_SUSPENDED', '_code' => 403];
    if ($st === 'inactive') return ['error' => 'Your account is inactive. Please contact PeopleLink support.', 'code' => 'ACCOUNT_INACTIVE', '_code' => 403];
    if ($st === 'deleted') return ['error' => 'This account has been deleted.', 'code' => 'ACCOUNT_DELETED', '_code' => 403];
    if ($st === 'deactivated') db()->prepare("UPDATE users SET status='active' WHERE id=?")->execute([(int)$u['id']]);
    return null;
}
