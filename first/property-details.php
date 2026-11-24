<?php
// Older marketplace design page: the live listing page is /first/marketplace/marketplace-listing-details.php
$id = (int)($_GET['id'] ?? 0);
header('Location: marketplace/' . ($id ? 'marketplace-listing-details.php?id=' . $id : 'marketplace-home.php'), true, 301);
exit;
