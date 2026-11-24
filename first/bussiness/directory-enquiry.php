<?php
// Old address kept so existing links work.
$qs = $_SERVER['QUERY_STRING'] ?? '';
header('Location: enquiry-contact.php' . ($qs !== '' ? '?' . $qs : ''), true, 301);
exit;
