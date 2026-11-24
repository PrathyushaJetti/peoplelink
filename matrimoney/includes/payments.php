<?php
// Common Razorpay payment engine for all PeopleLink modules.
// The price always comes from the packages table on the server - never from the app.
require_once __DIR__ . '/bridge.php';

function pl_rzp(string $method, string $path, ?array $body = null): array {
    if (RAZORPAY_KEY_ID === '' || RAZORPAY_KEY_SECRET === '') return [0, ['error' => ['description' => 'Razorpay keys are not set in config.php.']]];
    $ch = curl_init('https://api.razorpay.com/v1/' . ltrim($path, '/'));
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 20, CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_USERPWD => RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET, CURLOPT_HTTPHEADER => ['Content-Type: application/json']]);
    if ($body !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    $res = curl_exec($ch); $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE); $err = curl_error($ch); curl_close($ch);
    return [$code, json_decode((string)$res, true) ?: ['error' => ['description' => $err ?: 'No response from Razorpay.']]];
}

function pl_txn(int $id): ?array { return rows('SELECT * FROM transactions WHERE id=?', [$id])[0] ?? null; }

function pl_packages_for(int $cid, ?string $module = null): array {
    $a = [$cid]; $w = "is_active=1 AND (community_id=? OR visibility_type='global')";
    if ($module) { $w .= ' AND module_key=?'; $a[] = $module; }
    return array_map(fn($p) => ['id' => (int)$p['id'], 'module' => $p['module_key'], 'name' => $p['name'], 'price' => (float)$p['price'], 'validity_days' => (int)$p['validity_days'],
        'description' => $p['description'], 'features' => array_values(array_filter(array_map('trim', preg_split('/\R/', (string)$p['features']))))],
        rows("SELECT * FROM packages WHERE $w ORDER BY sort_order, price", $a));
}

function pl_txn_create(array $user, int $cid, int $packageId, ?string $refEntity = null, ?int $refId = null): array {
    $pk = rows("SELECT * FROM packages WHERE id=? AND is_active=1 AND (community_id=? OR visibility_type='global')", [$packageId, $cid])[0] ?? null;
    if (!$pk) return ['error' => 'This package is not available.', 'code' => 'NOT_FOUND', '_code' => 404];
    if ((float)$pk['price'] <= 0) return ['error' => 'This package has no price set.', 'code' => 'VALIDATION_ERROR'];
    // no gateway keys yet: say so clearly and do not leave a failed transaction behind
    if (RAZORPAY_KEY_ID === '' || RAZORPAY_KEY_SECRET === '')
        return ['error' => 'Online payment is not set up yet. Please contact support.', 'code' => 'PAYMENT_NOT_CONFIGURED', '_code' => 503];
    if ($refEntity !== null) {
        $RE = pl_entity($refEntity);
        if (!$RE || !$refId || !scalar("SELECT COUNT(*) FROM {$RE['table']} WHERE id=? AND user_id=?", [$refId, (int)$user['id']])) return ['error' => 'Item to pay for was not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    }
    db()->prepare("INSERT INTO transactions (user_id, community_id, module_key, package_id, package_name, ref_entity, ref_id, amount, status) VALUES (?,?,?,?,?,?,?,?, 'created')")
        ->execute([(int)$user['id'], $cid ?: null, $pk['module_key'], $pk['id'], $pk['name'], $refEntity, $refId, $pk['price']]);
    $id = (int)db()->lastInsertId(); $code = 'PL-TXN-' . (100000 + $id);
    db()->prepare('UPDATE transactions SET txn_code=? WHERE id=?')->execute([$code, $id]);
    [$http, $o] = pl_rzp('POST', 'orders', ['amount' => (int)round($pk['price'] * 100), 'currency' => 'INR', 'receipt' => $code,
        'notes' => ['txn_id' => (string)$id, 'user_id' => (string)$user['id'], 'module' => (string)$pk['module_key'], 'package' => (string)$pk['name']]]);
    if ($http !== 200 || empty($o['id'])) {
        $msg = mb_substr((string)($o['error']['description'] ?? 'Could not create the payment order.'), 0, 255);
        db()->prepare("UPDATE transactions SET status='failed', error_text=? WHERE id=?")->execute([$msg, $id]);
        return ['error' => 'Payment could not be started. Please try again.', 'code' => 'PAYMENT_FAILED', 'detail' => $msg, '_code' => 502];
    }
    db()->prepare("UPDATE transactions SET razorpay_order_id=?, status='pending' WHERE id=?")->execute([$o['id'], $id]);
    return ['message' => 'Order created.', 'transaction_id' => $id, 'txn_code' => $code, 'key_id' => RAZORPAY_KEY_ID, 'order_id' => $o['id'],
        'amount' => (int)$o['amount'], 'currency' => $o['currency'], 'name' => 'PeopleLink', 'description' => $pk['name'],
        'prefill' => ['name' => $user['name'], 'email' => $user['email'], 'contact' => $user['phone'] ?? '']];
}

function pl_activate_package(array $t): void {
    if (!$t['package_id'] || scalar('SELECT COUNT(*) FROM user_packages WHERE transaction_id=?', [$t['id']])) return;
    $pk = rows('SELECT * FROM packages WHERE id=?', [$t['package_id']])[0] ?? null;
    if (!$pk) return;
    $last = rows("SELECT MAX(expires_at) m FROM user_packages WHERE user_id=? AND module_key=? AND status='active' AND expires_at > NOW()", [$t['user_id'], $t['module_key']])[0]['m'] ?? null;
    $start = $last ?: date('Y-m-d H:i:s');
    $end = date('Y-m-d H:i:s', strtotime($start . ' +' . max(1, (int)$pk['validity_days']) . ' days'));
    db()->prepare("INSERT INTO user_packages (user_id, community_id, package_id, module_key, transaction_id, starts_at, expires_at, status) VALUES (?,?,?,?,?,?,?, 'active')")
        ->execute([$t['user_id'], $t['community_id'], $pk['id'], $t['module_key'], $t['id'], $start, $end]);
    if ($t['module_key'] === 'jobs') pl_job_package_activated($t, $pk, (int)db()->lastInsertId(), $end);
    if ($t['ref_entity'] === 'ad' && $t['ref_id']) db()->prepare("UPDATE advertisements SET payment_status='paid', package_id=? WHERE id=?")->execute([$pk['id'], $t['ref_id']]);
}

/* Idempotent: safe to call from the app callback, the webhook and admin reconcile. */
function pl_txn_paid(array $t, array $payment, ?string $signature = null): void {
    if ($t['status'] === 'paid') return;
    db()->prepare("UPDATE transactions SET status='paid', razorpay_payment_id=?, razorpay_signature=COALESCE(?, razorpay_signature), method=?, paid_at=NOW(), raw=?, error_text=NULL WHERE id=? AND status<>'paid'")
        ->execute([$payment['id'] ?? null, $signature, $payment['method'] ?? null, json_encode($payment), $t['id']]);
    $t = pl_txn((int)$t['id']);
    pl_activate_package($t);
    pl_audit('payment:paid', null, (int)$t['id'], $t['txn_code'] . ' ' . $t['amount'], $t['community_id'] ? (int)$t['community_id'] : null);
    pl_notify_user((int)$t['user_id'], $t['community_id'] ? (int)$t['community_id'] : null, 'Payment successful', 'Your payment of ₹' . number_format((float)$t['amount'], 2) . ' for ' . $t['package_name'] . ' is confirmed. Receipt: ' . $t['txn_code'], 'payment', 'transactions', (int)$t['id']);
}

function pl_txn_failed(array $t, array $payment): void {
    if (in_array($t['status'], ['paid', 'refunded'], true)) return;
    db()->prepare("UPDATE transactions SET status='failed', razorpay_payment_id=COALESCE(?, razorpay_payment_id), method=?, error_text=?, raw=? WHERE id=?")
        ->execute([$payment['id'] ?? null, $payment['method'] ?? null, mb_substr((string)($payment['error_description'] ?? 'Payment failed'), 0, 255), json_encode($payment), $t['id']]);
}

function pl_txn_verify(int $uid, string $orderId, string $paymentId, string $signature): array {
    $t = rows('SELECT * FROM transactions WHERE razorpay_order_id=? AND user_id=?', [$orderId, $uid])[0] ?? null;
    if (!$t) return ['error' => 'Transaction not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    if ($t['status'] === 'paid') return ['message' => 'Payment already confirmed.', 'status' => 'paid', 'transaction_id' => (int)$t['id'], 'txn_code' => $t['txn_code']];
    if (RAZORPAY_KEY_SECRET === '' || !hash_equals(hash_hmac('sha256', $orderId . '|' . $paymentId, RAZORPAY_KEY_SECRET), $signature))
        return ['error' => 'Payment could not be verified.', 'code' => 'PAYMENT_FAILED', '_code' => 400];
    [$http, $p] = pl_rzp('GET', 'payments/' . rawurlencode($paymentId));
    if ($http !== 200 || ($p['order_id'] ?? '') !== $orderId) return ['error' => 'Payment could not be confirmed with Razorpay. It will update automatically if it succeeded.', 'code' => 'PAYMENT_FAILED', '_code' => 502];
    if (($p['status'] ?? '') === 'authorized') { [$c2, $cap] = pl_rzp('POST', 'payments/' . rawurlencode($paymentId) . '/capture', ['amount' => (int)$p['amount'], 'currency' => $p['currency']]); if ($c2 === 200) $p = $cap; }
    if (($p['status'] ?? '') !== 'captured' || (int)$p['amount'] !== (int)round($t['amount'] * 100)) return ['error' => 'Payment is not completed yet.', 'code' => 'PAYMENT_FAILED', 'status' => $p['status'] ?? null, '_code' => 402];
    pl_txn_paid($t, $p, $signature);
    return ['message' => 'Payment successful.', 'status' => 'paid', 'transaction_id' => (int)$t['id'], 'txn_code' => $t['txn_code']];
}

/* Admin "Check status": asks Razorpay about the order and updates the transaction. */
function pl_txn_reconcile(array $t): string {
    if (!$t['razorpay_order_id']) return 'This transaction has no Razorpay order.';
    [$http, $r] = pl_rzp('GET', 'orders/' . rawurlencode($t['razorpay_order_id']) . '/payments');
    if ($http !== 200) return 'Razorpay: ' . ($r['error']['description'] ?? 'request failed');
    $items = $r['items'] ?? [];
    $cap = array_values(array_filter($items, fn($p) => in_array($p['status'], ['captured', 'refunded'], true)))[0] ?? null;
    if ($cap) {
        if ($t['status'] !== 'paid' && $t['status'] !== 'refunded') pl_txn_paid($t, $cap);
        $ref = (int)($cap['amount_refunded'] ?? 0);
        if ($ref > 0) {
            $full = $ref >= (int)$cap['amount'];
            db()->prepare('UPDATE transactions SET refund_status=?, refund_amount=?, status=? WHERE id=?')->execute([$full ? 'full' : 'partial', $ref / 100, $full ? 'refunded' : 'paid', $t['id']]);
            return 'Payment captured; ' . ($full ? 'fully' : 'partly') . ' refunded (₹' . number_format($ref / 100, 2) . ').';
        }
        return 'Payment captured — transaction marked as paid.';
    }
    $failed = array_values(array_filter($items, fn($p) => $p['status'] === 'failed'))[0] ?? null;
    if ($failed) { pl_txn_failed($t, $failed); return 'Payment failed: ' . ($failed['error_description'] ?? 'no reason given'); }
    return $items ? 'Payment status at Razorpay: ' . $items[0]['status'] : 'No payment attempt yet for this order.';
}

function pl_user_packages(int $uid, ?string $module = null): array {
    db()->exec("UPDATE user_packages SET status='expired' WHERE status='active' AND expires_at < NOW()");
    return rows('SELECT up.id, up.package_id, up.module_key module, p.name, up.starts_at, up.expires_at, up.status FROM user_packages up LEFT JOIN packages p ON p.id=up.package_id
        WHERE up.user_id=?' . ($module ? ' AND up.module_key=?' : '') . " AND up.status='active' ORDER BY up.expires_at", $module ? [$uid, $module] : [$uid]);
}

function pl_txn_out(array $t): array {
    return ['id' => (int)$t['id'], 'txn_code' => $t['txn_code'], 'module' => $t['module_key'], 'package' => $t['package_name'], 'amount' => (float)$t['amount'], 'currency' => $t['currency'],
        'status' => $t['status'], 'method' => $t['method'], 'razorpay_order_id' => $t['razorpay_order_id'], 'razorpay_payment_id' => $t['razorpay_payment_id'],
        'refund_status' => $t['refund_status'], 'created_at' => $t['created_at'], 'paid_at' => $t['paid_at']];
}
