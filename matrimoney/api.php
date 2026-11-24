<?php
$GLOBALS['ROOT'] = '';
require_once __DIR__ . '/includes/bridge.php';
require_once __DIR__ . '/includes/actions.php';

function api_code(array $r, int $http): string {
    if (!empty($r['code'])) return strtoupper((string)$r['code']);
    if (!empty($r['login']) || $http === 401) return 'AUTH_REQUIRED';
    $m = strtolower((string)($r['error'] ?? ''));
    if ($http === 403 && strpos($m, 'community') !== false) return 'COMMUNITY_MISMATCH';
    if (strpos($m, 'create your profile') !== false || strpos($m, 'profile first') !== false) return 'PROFILE_REQUIRED';
    if (strpos($m, 'profile') !== false && strpos($m, 'not found') !== false) return 'PROFILE_NOT_FOUND';
    if (strpos($m, 'package') !== false && (strpos($m, 'required') !== false || strpos($m, 'active') !== false || strpos($m, 'upgrade') !== false)) return 'PACKAGE_REQUIRED';
    if (strpos($m, 'payment') !== false) return 'PAYMENT_FAILED';
    if ($http >= 500) return 'SERVER_ERROR';
    if ($http === 404) return 'NOT_FOUND';
    return 'VALIDATION_ERROR';
}

function api_out(array $r, ?string $redirect, int $code = 200): void {
    $code = $r['_code'] ?? $code; unset($r['_code']);
    $ok = empty($r['error']);
    if ($redirect !== null) {
        flash($ok ? ($r['message'] ?? 'Done') : $r['error'], $ok ? 'success' : 'error');
        header('Location: ' . $redirect); exit;
    }
    http_response_code($ok ? $code : ($code === 200 ? 400 : $code));
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    $http = http_response_code() ?: 200;
    if (!$ok) $r = ['code' => api_code($r, $http)] + $r;
    echo json_encode(['ok' => $ok] + $r, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE); exit;
}

// JSON request bodies (Postman / mobile app) are treated like form fields
if (stripos((string)($_SERVER['CONTENT_TYPE'] ?? ''), 'application/json') !== false) {
    $__j = json_decode((string)file_get_contents('php://input'), true);
    if (is_array($__j)) { $_POST = array_merge($_POST, $__j); $_REQUEST = array_merge($_REQUEST, $__j); }
}

$redirect = safe_next($_POST['redirect'] ?? $_GET['redirect'] ?? null);
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$action = (string)($_REQUEST['action'] ?? '');
$def = $GLOBALS['PL_ACTIONS'][$action] ?? null;
if (!$def) api_out(['error' => 'Unknown action.'], $redirect, 404);
if ($def['write'] && !$isPost) api_out(['error' => 'POST required.'], $redirect, 405);
$__noCsrf = ['login', 'register', 'forgot_password', 'reset_password', 'verify_otp', 'resend_otp', 'login_otp', 'logout'];
if ($isPost && !in_array($action, $__noCsrf, true) && !hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) api_out(['error' => 'Session expired. Please refresh the page and try again.', 'code' => 'CSRF_INVALID', '_code' => 403], $redirect, 403); // 403, not 419: Apache turns unknown status codes into 500

$user = current_user();
$uid = $user ? (int)$user['id'] : null;
if (!$def['public'] && !$user) {
    if ($redirect !== null) { flash('Please login to continue.', 'error'); header('Location: ' . DASHBOARD_URL . 'login.php?next=' . urlencode($redirect)); exit; }
    api_out(['error' => 'Please login to continue.', 'login' => true], null, 401);
}
pl_ensure_schema();
$comm = pl_resolve_community($uid);
$cid = $comm ? (int)$comm['id'] : 0;
if (!empty($GLOBALS['PL_COMMUNITY_MISMATCH']) && !in_array($action, ['session', 'communities', 'community_select', 'community_selected', 'community_details'], true)) api_out(['error' => 'This information is not available for your selected community.', 'code' => 'COMMUNITY_MISMATCH', '_code' => 403], $redirect, 403);
if (!$cid && empty($def['nocomm']) && !in_array($action, ['communities', 'profile', 'support_request', 'session', 'search', 'login', 'register', 'logout', 'forgot_password', 'reset_password', 'verify_otp', 'resend_otp', 'login_otp', 'save_device_token', 'remove_device_token'], true)) api_out(['error' => 'Select a community first.'], $redirect, 400);

try {
    api_out(($def['fn'])(['user' => $user, 'uid' => $uid, 'cid' => $cid, 'comm' => $comm]), $redirect);
} catch (Throwable $e) {
    error_log('PL API ' . $action . ': ' . $e->getMessage());
    api_out(['error' => 'Something went wrong. Please try again.'], $redirect, 500);
}
