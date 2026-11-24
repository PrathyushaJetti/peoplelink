<?php
// Old address kept so existing links work.
$qs = $_SERVER['QUERY_STRING'] ?? '';
header('Location: contact-seller.php' . ($qs !== '' ? '?' . $qs : ''), true, 301);
exit;
