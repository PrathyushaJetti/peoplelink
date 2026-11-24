<?php
// App API: common Razorpay payments. Flow: payment_create_order -> open Razorpay Checkout with the returned key_id/order_id -> payment_verify.
// The webhook (razorpay-webhook.php) confirms the payment too, so a closed app still gets its package.
require_once __DIR__ . '/../payments.php';

pl_action('payment_packages', fn($x) => ['packages' => pl_packages_for($x['cid'], isset(PL_PACKAGE_MODULES[$_GET['module'] ?? '']) ? $_GET['module'] : null)], true, false);
pl_action('payment_create_order', fn($x) => pl_txn_create($x['user'], $x['cid'], (int)($_POST['package_id'] ?? 0),
    ($_POST['ref_entity'] ?? '') !== '' ? (string)$_POST['ref_entity'] : null, ($_POST['ref_id'] ?? '') !== '' ? (int)$_POST['ref_id'] : null));
pl_action('payment_verify', fn($x) => pl_txn_verify($x['uid'], (string)($_POST['razorpay_order_id'] ?? ''), (string)($_POST['razorpay_payment_id'] ?? ''), (string)($_POST['razorpay_signature'] ?? '')));
pl_action('payment_history', fn($x) => ['transactions' => array_map('pl_txn_out', rows('SELECT * FROM transactions WHERE user_id=? ORDER BY id DESC LIMIT 100', [$x['uid']]))], false, false);
pl_action('payment_status', function ($x) {
    $t = rows('SELECT * FROM transactions WHERE (id=? OR razorpay_order_id=?) AND user_id=?', [(int)($_GET['id'] ?? 0), (string)($_GET['order_id'] ?? ''), $x['uid']])[0] ?? null;
    return $t ? ['transaction' => pl_txn_out($t)] : ['error' => 'Transaction not found.', 'code' => 'NOT_FOUND', '_code' => 404];
}, false, false);
pl_action('payment_receipt', function ($x) {
    $t = rows("SELECT * FROM transactions WHERE id=? AND user_id=? AND status IN ('paid','refunded')", [(int)($_GET['id'] ?? 0), $x['uid']])[0] ?? null;
    if (!$t) return ['error' => 'Receipt not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    return ['receipt' => pl_txn_out($t) + ['receipt_no' => $t['txn_code'], 'paid_by' => $x['user']['name'], 'email' => $x['user']['email'], 'community' => pl_community_names()[$t['community_id']] ?? null]];
}, false, false);
pl_action('payment_active_packages', fn($x) => ['packages' => pl_user_packages($x['uid'], isset(PL_PACKAGE_MODULES[$_GET['module'] ?? '']) ? $_GET['module'] : null)], false, false);
foreach (['payment_history', 'payment_status', 'payment_receipt', 'payment_active_packages', 'payment_verify'] as $__a) pl_action_nocomm($__a);
