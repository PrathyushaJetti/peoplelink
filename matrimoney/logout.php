<?php require_once __DIR__ . '/includes/auth.php'; pl_session_logout(); header('Location: ' . (safe_next($_GET['next'] ?? null) ?: 'login.php')); exit;
