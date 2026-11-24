<?php
// Shared loader for the website module pages (Jobs, Marketplace, Directory, Events/Ads, Support, Leadership, Near Me).
// Pages call the SAME backend actions as the mobile app API (matrimoney/api.php), in-process, so rules live in one place.
$GLOBALS['ROOT'] = $GLOBALS['ROOT'] ?? '';
require_once dirname(__DIR__) . '/matrimoney/includes/bridge.php';
require_once dirname(__DIR__) . '/matrimoney/includes/actions.php';
pl_ensure_schema();

$webUser = current_user();
$webUid  = $webUser ? (int)$webUser['id'] : null;
$webComm = pl_resolve_community($webUid);
$webCid  = $webComm ? (int)$webComm['id'] : 0;

if (!function_exists('h')) { function h($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); } }

/* Run a backend action with the given parameters and return its result array (never exits). */
function web_call(string $action, array $params = [], bool $post = false): array {
    $def = $GLOBALS['PL_ACTIONS'][$action] ?? null;
    if (!$def) return ['error' => 'Unknown action.'];
    global $webUser, $webUid, $webCid, $webComm;
    if (!$def['public'] && !$webUser) return ['error' => 'Please login to continue.', 'login' => true];
    $save = [$_GET, $_POST, $_REQUEST];
    if ($post) { $_POST = $params + $_POST; } else { $_GET = $params; }
    $_REQUEST = $params + ($post ? $_POST : $_GET);
    try {
        $r = ($def['fn'])(['user' => $webUser, 'uid' => $webUid, 'cid' => $webCid, 'comm' => $webComm]);
    } catch (Throwable $e) {
        error_log('PL WEB ' . $action . ': ' . $e->getMessage());
        $r = ['error' => 'Something went wrong. Please try again.'];
    }
    [$_GET, $_POST, $_REQUEST] = $save;
    unset($r['_code']);
    return $r;
}

/* Send visitors to login (and back here afterwards). */
function web_require_login(): void {
    global $webUser;
    if ($webUser) return;
    header('Location: ' . DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/first/'));
    exit;
}

/* Members must have picked a community for community-scoped pages. */
function web_require_community(): void {
    global $webCid;
    if ($webCid) return;
    header('Location: /peoplelink/first/community-page.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? ''));
    exit;
}

/* Handle a POSTed form: check CSRF, run the action, flash the result, redirect (Post/Redirect/Get). */
function web_post(string $action, string $back, ?string $okTo = null): void {
    if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) { flash('Your session expired. Please try again.', 'error'); header('Location: ' . $back); exit; }
    $r = web_call($action, [], true);
    if (!empty($r['login'])) web_require_login();
    flash(empty($r['error']) ? ($r['message'] ?? 'Saved.') : $r['error'], empty($r['error']) ? 'success' : 'error');
    header('Location: ' . (empty($r['error']) && $okTo ? str_replace('{id}', (string)($r['id'] ?? $r['item']['id'] ?? ''), $okTo) : $back));
    exit;
}

/* Flash message box (success / error) for the top of a page. */
function web_flash_html(): string {
    $f = flash();
    if (!$f) return '';
    [$msg, $type] = $f;
    $c = $type === 'error' ? '#b42318;background:#fef3f2;border-color:#fecdca' : '#067647;background:#ecfdf3;border-color:#abefc6';
    return '<div role="status" style="max-width:1180px;margin:16px auto;padding:12px 16px;border:1px solid;border-radius:10px;font-weight:600;color:' . $c . '">' . h($msg) . '</div>';
}

/* <script> tags that give page JavaScript the API address, CSRF token and login state (used by first/js/pl-api.js). */
function web_js_boot(): string {
    global $webUser;
    $cfg = ['api' => DASHBOARD_URL . 'api.php', 'csrf' => csrf_token(), 'loggedIn' => (bool)$webUser,
        'loginUrl' => DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/first/')];
    return '<script>window.PL_WEB=' . json_encode($cfg, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES) . ';</script>'
        . '<script src="/peoplelink/first/js/pl-api.js?v=1"></script>';
}

/* Context array the backend actions expect. */
function web_ctx(): array { global $webUser, $webUid, $webCid, $webComm; return ['user' => $webUser, 'uid' => $webUid, 'cid' => $webCid, 'comm' => $webComm]; }

/* A job from the backend (pl_job_out) in the field names the job page designs use. */
function web_job_card(array $j): array {
    $loc = trim(implode(', ', array_filter([$j['location'] ?? '', $j['city'] ?? '', $j['state'] ?? ''])), ', ');
    return array_merge($j, [
        'title' => $j['job_title'] ?? '', 'company' => $j['company_name'] ?? '',
        'location' => $loc !== '' ? $loc : ($j['work_mode'] === 'Remote' ? 'Remote' : 'Location not specified'),
        'job_type' => $j['employment_type'] ?? '', 'posted' => substr((string)($j['created_at'] ?? ''), 0, 10),
        'scope' => !empty($j['is_global']) ? 'global' : 'community', 'community' => $j['community_name'] ?? '',
    ]);
}

function web_csrf_field(): string { return '<input type="hidden" name="csrf" value="' . h(csrf_token()) . '">'; }

/* Page links that keep the current filters. */
function web_qs(array $change): string { $q = array_merge($_GET, $change); return '?' . http_build_query(array_filter($q, fn($v) => $v !== '' && $v !== null)); }

function web_ago(?string $dt): string {
    if (!$dt) return '';
    $d = time() - strtotime($dt);
    if ($d < 3600) return max(1, (int)($d / 60)) . ' min ago';
    if ($d < 86400) return (int)($d / 3600) . ' hours ago';
    if ($d < 86400 * 30) return (int)($d / 86400) . ' days ago';
    return date('d M Y', strtotime($dt));
}
