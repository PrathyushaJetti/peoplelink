<?php
// Older directory design page: the live profile page is /first/bussiness/professional-business-profile-details.php
$id = (int)($_GET['id'] ?? 0);
header('Location: ' . ($id ? 'bussiness/professional-business-profile-details.php?id=' . $id : 'professional-and-business-directory.php'), true, 301);
exit;
