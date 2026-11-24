<?php
// Older copy of payment-status.php, kept as a redirect so old links keep working.
$q = $_SERVER['QUERY_STRING'] ?? '';
header('Location: payment-status.php' . ($q !== '' ? '?' . $q : ''), true, 301);
exit;
