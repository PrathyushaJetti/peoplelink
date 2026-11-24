<?php
/* Included at the top of every matrimony page (before any HTML). Uses the shared PeopleLink session, database and community rules. */
$GLOBALS['ROOT'] = '';
require_once __DIR__ . '/../../../matrimoney/includes/bridge.php';
require_once __DIR__ . '/../../../matrimoney/includes/actions.php'; // loads module-4/Backend through includes/ext/matrimony.php
pl_ensure_schema();

$user = current_user();
$uid  = $user ? (int)$user['id'] : null;
$comm = pl_resolve_community($uid);
$cid  = $comm ? (int)$comm['id'] : 0;
$me   = ($uid && $cid) ? pl_my_profile($uid, $cid) : null;

$F = '../../../first/';   // shared site assets (header.css, footer.css, logo, other modules)
$P = '';                  // matrimony pages are siblings

function mat_login_url(): string { return DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? ''); }

/* Page guards */
function mat_need_login(): void {
    global $user;
    if (!$user) { header('Location: ' . mat_login_url()); exit; }
}
function mat_need_profile(): void {
    global $me, $cid;
    mat_need_login();
    if (!$cid) { header('Location: ' . $GLOBALS['F'] . 'community-page.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/module-4/Frontend/pages/index.php')); exit; }
    if (!$me) { header('Location: profile-form.php?first=1'); exit; }
}
