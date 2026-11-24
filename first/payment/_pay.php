<?php
// Shared loader for My Payments, Payment Status and Receipt: the logged-in user's own transactions only.
require_once dirname(__DIR__, 2) . '/matrimoney/includes/bridge.php';
require_once dirname(__DIR__, 2) . '/matrimoney/includes/payments.php';
pl_ensure_schema();
$payUser = current_user();
if (!$payUser) { header('Location: ' . DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/first/payment/my-payments.php')); exit; }
$payUid = (int)$payUser['id'];

/* database status -> the words the designs use */
function pay_status(array $t): string {
    if (($t['refund_status'] ?? '') && $t['refund_status'] !== 'none' || $t['status'] === 'refunded') return 'Refunded';
    return ['paid' => 'Successful', 'failed' => 'Failed', 'created' => 'Pending', 'pending' => 'Pending', 'cancelled' => 'Failed'][$t['status']] ?? 'Pending';
}
function pay_module(?string $k): string { return PL_PACKAGE_MODULES[$k ?? ''] ?? ucfirst((string)$k ?: 'General'); }
/* where to buy the package again */
function pay_retry_url(?string $k): string {
    return ['matrimony' => '/peoplelink/module-4/Frontend/pages/packages.php', 'jobs' => '/peoplelink/first/job/global-job-packages.php',
        'marketplace' => '/peoplelink/first/marketplace/marketplace-home.php', 'events' => '/peoplelink/first/events-ads.php', 'ads' => '/peoplelink/first/events-ads.php',
        'directory' => '/peoplelink/first/professional-and-business-directory.php'][$k ?? ''] ?? '/peoplelink/first/index.php';
}
function pay_method(?string $m): string { return ['upi' => 'UPI', 'card' => 'Card', 'netbanking' => 'Net Banking', 'wallet' => 'Wallet', 'emi' => 'EMI'][strtolower((string)$m)] ?? ($m ? ucfirst($m) : '—'); }
/* one transaction in the shape of the design arrays */
function pay_row(array $t, string $userName): array {
    return ['db_id' => (int)$t['id'], 'id' => $t['txn_code'] ?: 'TXN-' . $t['id'], 'user' => $userName, 'module' => pay_module($t['module_key']), 'package' => $t['package_name'] ?: '—',
        'amount' => (float)$t['amount'], 'date' => $t['paid_at'] ?: $t['created_at'], 'method' => pay_method($t['method']), 'status' => pay_status($t),
        'gateway_ref' => $t['razorpay_payment_id'] ?: ($t['razorpay_order_id'] ?: '—'), 'currency' => $t['currency'] ?: 'INR',
        'receipt_url' => 'receipt.php?id=' . (int)$t['id'], 'retry_url' => pay_retry_url($t['module_key']), 'error' => $t['error_text'] ?? ''];
}
