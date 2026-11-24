<?php
$GLOBALS['ROOT'] = '../';
require_once __DIR__ . '/../includes/auth.php'; require_once __DIR__ . '/../includes/layout.php';
[$user, $comm] = require_login(); $page = trim($_GET['p'] ?? 'This page');
render_header($page, 'Soon/' . $page, $user, $comm); ?>
<div class="card soon anim"><?= icon('fa-rocket','big') ?><h3><?= e($page) ?> is coming soon</h3><p>This module is part of the next phase.</p>
<a class="btn btn-primary" href="../dashboard.php"><?= icon('fa-arrow-left') ?> Back to Matrimony Dashboard</a></div>
<?php render_footer();
