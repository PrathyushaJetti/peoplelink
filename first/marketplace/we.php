<?php
// Old sample listing page: the real listing page is marketplace-listing-details.php
$id = (int)($_GET['id'] ?? 0);
header('Location: marketplace-listing-details.php' . ($id ? '?id=' . $id : ''), true, 301);
exit;
