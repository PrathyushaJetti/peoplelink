<?php
// Shared start for every admin/ page: admin login + community, schema and the generic admin helpers.
$GLOBALS['ROOT'] = '../';
require_once __DIR__ . '/../includes/admin_crud.php';
[$user, $comm] = require_login();
pl_ensure_schema();
$cid = (int)$comm['id'];
