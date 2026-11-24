<?php
// Old separate login page. It accepted a shared master password, so it now sends people to the one real login.
require_once __DIR__ . '/../matrimoney/config.php';
$next = safe_next($_GET['next'] ?? null);
header('Location: ../matrimoney/login.php' . ($next ? '?next=' . urlencode($next) : ''), true, 302);
exit;
