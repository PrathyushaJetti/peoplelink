<?php require_once __DIR__ . '/config.php'; header('Location: ' . (empty($_SESSION['uid']) ? 'login.php' : 'admin/overview.php')); exit;
