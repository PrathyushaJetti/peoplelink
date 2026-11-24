<?php
// Older copy of my-payments.php, kept as a redirect so old links keep working.
$q = $_SERVER['QUERY_STRING'] ?? '';
header('Location: my-payments.php' . ($q !== '' ? '?' . $q : ''), true, 301);
exit;
