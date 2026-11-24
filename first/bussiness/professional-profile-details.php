<?php
// Old address kept so existing links work.
$qs = $_SERVER['QUERY_STRING'] ?? '';
header('Location: professional-business-profile-details.php' . ($qs !== '' ? '?' . $qs : ''), true, 301);
exit;
