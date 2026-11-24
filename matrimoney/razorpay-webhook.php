<?php
// Razorpay webhook. In Razorpay Dashboard > Webhooks add this URL with events payment.captured, payment.failed, order.paid, refund.processed
// and put the same secret in config.php (RAZORPAY_WEBHOOK_SECRET).
require_once __DIR__ . '/includes/payments.php';
header('Content-Type: application/json');

$body = (string)file_get_contents('php://input');
$sig = (string)($_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '');
if (RAZORPAY_WEBHOOK_SECRET === '' || !hash_equals(hash_hmac('sha256', $body, RAZORPAY_WEBHOOK_SECRET), $sig)) { http_response_code(400); exit('{"ok":false}'); }

pl_ensure_schema();
$ev = json_decode($body, true) ?: [];
$payment = $ev['payload']['payment']['entity'] ?? null;
$orderId = $payment['order_id'] ?? ($ev['payload']['order']['entity']['id'] ?? null);
$t = $orderId ? (rows('SELECT * FROM transactions WHERE razorpay_order_id=?', [$orderId])[0] ?? null) : null;

try {
    if ($t) switch ($ev['event'] ?? '') {
        case 'payment.captured': case 'order.paid':
            if ($payment && (int)$payment['amount'] === (int)round($t['amount'] * 100)) pl_txn_paid($t, $payment);
            break;
        case 'payment.failed':
            if ($payment) pl_txn_failed($t, $payment);
            break;
        case 'refund.processed':
            pl_txn_reconcile($t);
            break;
    }
} catch (Throwable $e) { error_log('PL webhook: ' . $e->getMessage()); http_response_code(500); exit('{"ok":false}'); }
echo '{"ok":true}';
