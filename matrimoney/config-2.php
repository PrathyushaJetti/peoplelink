<?php
const DB_HOST   = 'localhost';
const DB_NAME   = 'eliteinterior_peoplelink';
const DB_USER   = 'eliteinterior_pluser';
const DB_PASS   = 'PUT_YOUR_DB_PASSWORD_HERE';

const USE_SUBDOMAINS = false;
const BASE_DOMAIN    = 'eliteinteriorstudios.com';

const FRONTEND_URL = 'https://eliteinteriorstudios.com/peoplelink/first/';

const DASHBOARD_URL = 'https://eliteinteriorstudios.com/matrimony/';

const LOGO_URL = FRONTEND_URL . 'images/logo.jpeg';

const SIGNUP_ROLE = 'member';

session_start();

function db(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
}

function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}

function csrf_check(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419); exit('Session expired. Please go back and try again.');
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
    return 'dashboard.php?c=' . urlencode($c['slug']);
}
