<?php
// Old address: editing now happens on the post form (?edit=ID).
$id = (int)($_GET['id'] ?? 0);
header('Location: post-marketplace-listing.php' . ($id ? '?edit=' . $id : ''), true, 301);
exit;
