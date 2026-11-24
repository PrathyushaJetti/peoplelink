<?php
// Generic list / view / add / edit page for every module record: manage.php?e=mp_listing (see PL_ENTITIES in includes/modules.php)
require __DIR__ . '/_boot.php';
pl_admin_manage((string)($_POST['ent'] ?? $_GET['e'] ?? ''), $user, $comm);
