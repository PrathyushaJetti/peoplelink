<?php
if (!function_exists('str_ends_with')) { function str_ends_with($h, $n) { return $n === '' || substr($h, -strlen($n)) === $n; } }
if (!function_exists('str_starts_with')) { function str_starts_with($h, $n) { return strncmp($h, $n, strlen($n)) === 0; } }
if (!function_exists('str_contains')) { function str_contains($h, $n) { return $n === '' || strpos($h, $n) !== false; } }
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/helpers.php'; // sessions.php uses rows() / scalar()
require_once __DIR__ . '/sessions.php';

function current_user(): ?array {
    if (empty($_SESSION['uid'])) return null;
    $st = db()->prepare('SELECT * FROM users WHERE id = ?');
    $st->execute([$_SESSION['uid']]);
    $u = $st->fetch() ?: null;
    if (!$u) return null;
    // suspended / inactive accounts and devices that were logged out are treated as logged out
    if (in_array($u['status'] ?? 'active', ['inactive', 'suspended', 'deleted'], true) || !pl_session_touch($u)) { unset($_SESSION['uid']); return null; }
    return $u;
}

function require_login(): array {
    $u = current_user();
    if (!$u) { header('Location: ' . $GLOBALS['ROOT'] . 'login.php'); exit; }
    if (($u['role'] ?? '') === 'member') { header('Location: ' . FRONTEND_URL . 'community-matrimony.php'); exit; }
    $c = current_community();
    if (!$c) { header('Location: ' . $GLOBALS['ROOT'] . 'select-community.php'); exit; }
    return [$u, $c];
}
