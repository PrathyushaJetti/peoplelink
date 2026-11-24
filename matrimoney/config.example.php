<?php
// Copy this file to config.php and put the live DB user/password below. config.php is not stored in Git.
date_default_timezone_set('Asia/Kolkata'); // the app is for India: PHP times must match the database (IST)
const DB_HOST   = 'localhost';
const DB_NAME   = 'eliteinterior_peoplelink';
// Local XAMPP (localhost) uses root with no password; the live server uses its own user.
$__plIsLocal = PHP_SAPI !== 'cli' && preg_match('/^(localhost|127\.0\.0\.1)(:\d+)?$/', (string)($_SERVER['HTTP_HOST'] ?? ''));
define('DB_USER', $__plIsLocal ? 'root' : 'LIVE_DB_USER'); // exact MySQL user name from cPanel
define('DB_PASS', $__plIsLocal ? '' : 'LIVE_DB_PASSWORD');
unset($__plIsLocal);

const USE_SUBDOMAINS = false;
const BASE_DOMAIN    = 'eliteinteriorstudios.com';

// On a local server (php -S / XAMPP on localhost) the links stay local; on the live site they use the domain.
$__plLocal = preg_match('/^(localhost|127\.0\.0\.1)(:\d+)?$/', (string)($_SERVER['HTTP_HOST'] ?? ''));
define('FRONTEND_URL', $__plLocal ? 'http://' . $_SERVER['HTTP_HOST'] . '/peoplelink/first/' : 'https://eliteinteriorstudios.com/peoplelink/first/');

define('DASHBOARD_URL', $__plLocal ? 'http://' . $_SERVER['HTTP_HOST'] . '/peoplelink/matrimoney/' : 'https://eliteinteriorstudios.com/peoplelink/matrimoney/');
unset($__plLocal);

const LOGO_URL = DASHBOARD_URL . 'assets/logo.jpeg';

const SIGNUP_ROLE = 'member';

// Razorpay (Dashboard > Account & Settings > API Keys / Webhooks). Webhook URL: DASHBOARD_URL . 'razorpay-webhook.php'
const RAZORPAY_KEY_ID         = '';
const RAZORPAY_KEY_SECRET     = '';
const RAZORPAY_WEBHOOK_SECRET = '';

// FCM push: full path to the Firebase service-account JSON file (keep it outside public_html)
const FCM_SERVICE_ACCOUNT_FILE = '';

// SMS for major changes only. Your provider's GET URL with {phone} and {message}, e.g. https://sms.example.com/send?key=XXX&to={phone}&text={message}
const SMS_API_URL = '';

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

function db(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    try { $pdo->exec("SET time_zone='+05:30'"); } catch (Throwable $e) {}
    return $pdo;
}

if (!function_exists('e')) { function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); } } // some pages declare their own e()

function safe_next(?string $n): ?string {
    $n = trim((string)$n);
    if ($n === '') return null;
    if (preg_match('#^/(?![/\\\\])#', $n) || str_starts_with($n, FRONTEND_URL) || str_starts_with($n, DASHBOARD_URL)) return $n;
    return null;
}

function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}

function csrf_check(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(403); exit('Session expired. Please go back and try again.');
    }
}

function flash(?string $msg = null, string $type = 'success') {
    if ($msg !== null) { $_SESSION['flash'] = [$msg, $type]; return; }
    $f = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $f;
}

function current_community(): ?array {
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (USE_SUBDOMAINS && str_ends_with($host, BASE_DOMAIN) && $host !== BASE_DOMAIN && $host !== 'www.' . BASE_DOMAIN) {
        $slug = explode('.', $host)[0];
    } elseif (!empty($_GET['c'])) {
        $slug = $_GET['c'];
        $_SESSION['community_slug'] = $slug;
    } else {
        $slug = $_SESSION['community_slug'] ?? null;
    }
    if (!$slug) return null;
    $st = db()->prepare('SELECT * FROM communities WHERE slug = ?');
    $st->execute([$slug]);
    return $st->fetch() ?: null;
}

function community_url(array $c): string {
    if (USE_SUBDOMAINS) return 'https://' . $c['slug'] . '.' . BASE_DOMAIN . '/dashboard.php';
    return 'admin/overview.php?c=' . urlencode($c['slug']);
}