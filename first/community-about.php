<?php
// The About page is served by community-page.php with the community's own introduction and history (Module 5).
require_once dirname(__DIR__) . '/matrimoney/includes/bridge.php';
$c = pl_resolve_community(current_user() ? (int)current_user()['id'] : null);
header('Location: community-page.php' . ($c ? '?c=' . urlencode($c['slug']) : ''), true, 302);
exit;
