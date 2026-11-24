<?php
// JSON: current status of one of MY transactions. Pending payments are re-checked with Razorpay (when keys are set).
// Body: {"transaction_id": "<txn code or id>"} -> status Successful|Pending|Failed|Refunded
//       {"order_id": "<razorpay order id or txn id>"} -> status success|pending|failed
require_once dirname(__DIR__, 2) . '/matrimoney/includes/bridge.php';
require_once dirname(__DIR__, 2) . '/matrimoney/includes/payments.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
$out = function (int $code, array $data) { http_response_code($code); echo json_encode($data); exit; };
$u = current_user();
if (!$u) $out(401, ['error' => 'Please login to continue.']);
if ($_SERVER['REQUEST_METHOD'] !== 'POST') $out(405, ['error' => 'POST required.']);
$in = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
$tid = trim((string)($in['transaction_id'] ?? '')); $oid = trim((string)($in['order_id'] ?? ''));
$key = $tid !== '' ? $tid : $oid;
if ($key === '') $out(400, ['error' => 'Transaction not given.']);
$t = rows('SELECT * FROM transactions WHERE user_id=? AND (txn_code=? OR razorpay_order_id=? OR id=?) LIMIT 1', [(int)$u['id'], $key, $key, ctype_digit($key) ? (int)$key : 0])[0] ?? null;
if (!$t) $out(404, ['error' => 'Transaction not found.']);

// ask Razorpay again for unfinished payments, at most every 15 seconds per user
if (in_array($t['status'], ['created', 'pending'], true) && RAZORPAY_KEY_ID !== '' && (time() - (int)($_SESSION['pay_check_at'] ?? 0)) >= 15) {
    $_SESSION['pay_check_at'] = time();
    try { pl_txn_reconcile($t); } catch (Throwable $e) { error_log('PL pay check: ' . $e->getMessage()); }
    $t = pl_txn($t['id']);
}
$pretty = ($t['status'] === 'refunded' || (($t['refund_status'] ?? '') && $t['refund_status'] !== 'none')) ? 'Refunded'
    : (['paid' => 'Successful', 'failed' => 'Failed', 'cancelled' => 'Failed'][$t['status']] ?? 'Pending');
$simple = ['Successful' => 'success', 'Refunded' => 'success', 'Failed' => 'failed'][$pretty] ?? 'pending';
$out(200, ['status' => $tid !== '' ? $pretty : $simple, 'transaction_status' => $pretty]);
