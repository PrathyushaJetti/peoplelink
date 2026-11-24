<?php
// Payment Status: result of one of MY payments. ?id=<transaction id> or ?order_id=<Razorpay order id>; latest payment otherwise.
require_once __DIR__ . '/_pay.php';
$key = (string)($_GET['order_id'] ?? $_GET['id'] ?? '');
$t = $key !== ''
    ? (rows('SELECT * FROM transactions WHERE user_id=? AND (razorpay_order_id=? OR txn_code=? OR id=?) LIMIT 1', [$payUid, $key, $key, ctype_digit($key) ? (int)$key : 0])[0] ?? null)
    : (rows('SELECT * FROM transactions WHERE user_id=? ORDER BY id DESC LIMIT 1', [$payUid])[0] ?? null);
if (!$t) { header('Location: my-payments.php'); exit; } // nothing to show (or not my payment)
include __DIR__ . '/header.php';
$row = pay_row($t, $payUser['name']);
$paymentStatus = ['Successful' => 'success', 'Refunded' => 'success', 'Failed' => 'failed'][$row['status']] ?? 'pending';
$order = [
    'order_id'       => $t['razorpay_order_id'] ?: $row['id'],
    'transaction_id' => $t['razorpay_payment_id'] ?: $row['id'],
    'module'         => $row['module'],
    'package'        => $row['package'],
    'amount'         => $row['amount'],
    'currency'       => $row['currency'],
    'payment_date'   => date('d M Y, h:i A', strtotime($row['date'])),
    'message'        => $row['error'],
];
$doneUrl = pay_retry_url($t['module_key']);
$paymentStatus = strtolower($paymentStatus);

if (!in_array($paymentStatus, ['success', 'failed', 'pending'], true)) {
    $paymentStatus = 'pending';
}

$statusContent = [
    'success' => [
        'icon'      => '✓',
        'title'     => 'Payment Successful!',
        'subtitle'  => 'Thank you! Your payment has been confirmed.',
        'heading'   => 'Your transaction is complete',
        'message'   => 'Your payment has been verified. Your purchased service will be available according to the selected package.',
        'class'     => 'success',
        'button'    => 'Continue'
    ],
    'failed' => [
        'icon'      => '×',
        'title'     => 'Payment Failed',
        'subtitle'  => 'We could not confirm a successful payment.',
        'heading'   => 'Your payment was not completed',
        'message'   => 'Please check your transaction status before trying again. If money was deducted, contact support before making another payment.',
        'class'     => 'failed',
        'button'    => 'Try Again'
    ],
    'pending' => [
        'icon'      => '…',
        'title'     => 'Payment Processing',
        'subtitle'  => 'We are waiting for payment confirmation.',
        'heading'   => 'Your transaction is being verified',
        'message'   => 'Please do not make another payment while this transaction is being checked. The status will update when confirmation is received.',
        'class'     => 'pending',
        'button'    => 'Check Payment Status'
    ]
];

$current = $statusContent[$paymentStatus];

$formatAmount = number_format((float) $order['amount'], 2);
?>

 

<main class="pl-payment-page"
      data-payment-status="<?= htmlspecialchars($paymentStatus, ENT_QUOTES, 'UTF-8') ?>"
      data-status-url="payment-status-check.php" data-order-id="<?= htmlspecialchars((string)$t['id'], ENT_QUOTES, 'UTF-8') ?>">

    <div class="pl-payment-container">

        <!-- Breadcrumb -->
        <div class="pl-breadcrumb">
            <a href="../index.php">Home</a>
            <span>/</span>
            <a href="my-payments.php">My Payments</a>
            <span>/</span>
            <span>Payment Status</span>
        </div>

        <!-- Page Heading -->
        <section class="pl-payment-heading">
            <span class="pl-eyebrow">PEOPLELINK PAYMENTS</span>
            <h1>Payment Status</h1>
            <p>
                Your secure payment update, all in one place.
            </p>
        </section>

        <!-- Status Card -->
        <section class="pl-status-card <?= $current['class'] ?>">

            <div class="pl-status-icon">
                <span><?= htmlspecialchars($current['icon'], ENT_QUOTES, 'UTF-8') ?></span>
            </div>

            <span class="pl-status-label">
                <?= htmlspecialchars(ucfirst($paymentStatus), ENT_QUOTES, 'UTF-8') ?>
            </span>

            <h2>
                <?= htmlspecialchars($current['title'], ENT_QUOTES, 'UTF-8') ?>
            </h2>

            <p class="pl-status-subtitle">
                <?= htmlspecialchars($current['subtitle'], ENT_QUOTES, 'UTF-8') ?>
            </p>

            <div class="pl-status-divider"></div>

            <h3>
                <?= htmlspecialchars($current['heading'], ENT_QUOTES, 'UTF-8') ?>
            </h3>

            <p class="pl-status-message">
                <?= htmlspecialchars($current['message'], ENT_QUOTES, 'UTF-8') ?>
            </p>

            <?php if ($paymentStatus === 'success'): ?>
                <div class="pl-success-note">
                    <span class="pl-note-icon">✓</span>
                    <span>
                        Payment confirmation received. Check your dashboard
                        for your service activation status.
                    </span>
                </div>
            <?php elseif ($paymentStatus === 'failed'): ?>
                <div class="pl-warning-note">
                    <span class="pl-note-icon">!</span>
                    <span>
                        If your bank account was debited, verify the transaction
                        before paying again.
                    </span>
                </div>
            <?php else: ?>
                <div class="pl-pending-note">
                    <span class="pl-note-icon">i</span>
                    <span>
                        Your order will remain pending until the gateway
                        confirms the final payment result.
                    </span>
                </div>
            <?php endif; ?>

        </section>

        <!-- Transaction Details -->
        <section class="pl-transaction-card">

            <div class="pl-section-title">
                <div>
                    <span class="pl-section-kicker">TRANSACTION INFORMATION</span>
                    <h2>Payment Details</h2>
                </div>

                <span class="pl-secure-badge">
                    <span>✓</span> Secure Transaction
                </span>
            </div>

            <div class="pl-transaction-grid">

                <div class="pl-detail-item">
                    <span class="pl-detail-label">Order ID</span>
                    <strong><?= htmlspecialchars($order['order_id'], ENT_QUOTES, 'UTF-8') ?></strong>
                    <button type="button"
                            class="pl-copy-btn"
                            data-copy="<?= htmlspecialchars($order['order_id'], ENT_QUOTES, 'UTF-8') ?>">
                        Copy ID
                    </button>
                </div>

                <div class="pl-detail-item">
                    <span class="pl-detail-label">Transaction Reference</span>
                    <strong class="pl-break-word">
                        <?= htmlspecialchars($order['transaction_id'], ENT_QUOTES, 'UTF-8') ?>
                    </strong>
                </div>

                <div class="pl-detail-item">
                    <span class="pl-detail-label">Module / Service</span>
                    <strong><?= htmlspecialchars($order['module'], ENT_QUOTES, 'UTF-8') ?></strong>
                </div>

                <div class="pl-detail-item">
                    <span class="pl-detail-label">Package / Plan</span>
                    <strong><?= htmlspecialchars($order['package'], ENT_QUOTES, 'UTF-8') ?></strong>
                </div>

                <div class="pl-detail-item">
                    <span class="pl-detail-label">Payment Date</span>
                    <strong><?= htmlspecialchars($order['payment_date'], ENT_QUOTES, 'UTF-8') ?></strong>
                </div>

                <div class="pl-detail-item">
                    <span class="pl-detail-label">Payment Status</span>
                    <strong class="pl-inline-status <?= $current['class'] ?>">
                        <?= htmlspecialchars(ucfirst($paymentStatus), ENT_QUOTES, 'UTF-8') ?>
                    </strong>
                </div>

            </div>

            <div class="pl-amount-box">
                <div>
                    <span>Total Amount</span>
                    <small>Order payment summary</small>
                </div>

                <strong>
                    ₹<?= $formatAmount ?>
                </strong>
            </div>

        </section>

        <!-- Help Section -->
        <section class="pl-payment-help">
            <div class="pl-help-icon">?</div>

            <div class="pl-help-content">
                <h3>Need help with your payment?</h3>
                <p>
                    If you have questions about this transaction, our support
                    team can help you check your order and payment status.
                </p>
            </div>

            <a href="../community/community-support.php" class="pl-help-btn">
                Contact Support <span>→</span>
            </a>
        </section>

        <!-- Action Buttons -->
        <div class="pl-payment-actions">

            <?php if ($paymentStatus === 'success'): ?>

                <a href="<?= htmlspecialchars($doneUrl, ENT_QUOTES, 'UTF-8') ?>" class="pl-btn pl-btn-primary">
                    <?= htmlspecialchars($current['button'], ENT_QUOTES, 'UTF-8') ?>
                    <span>→</span>
                </a>

                <a href="my-payments.php" class="pl-btn pl-btn-secondary">
                    View My Payments
                </a><?php if ($paymentStatus === 'success'): ?> <a href="receipt.php?id=<?= (int)$t['id'] ?>" class="pl-btn pl-btn-secondary">Download Receipt</a><?php endif; ?>

            <?php elseif ($paymentStatus === 'failed'): ?>

                <a href="<?= htmlspecialchars($doneUrl, ENT_QUOTES, 'UTF-8') ?>"
                   class="pl-btn pl-btn-primary">
                    <?= htmlspecialchars($current['button'], ENT_QUOTES, 'UTF-8') ?>
                    <span>→</span>
                </a>

                <a href="my-payments.php" class="pl-btn pl-btn-secondary">
                    View My Payments
                </a>

            <?php else: ?>

                <button type="button"
                        id="plCheckStatus"
                        class="pl-btn pl-btn-primary">
                    <?= htmlspecialchars($current['button'], ENT_QUOTES, 'UTF-8') ?>
                    <span>↻</span>
                </button>

                <a href="my-payments.php" class="pl-btn pl-btn-secondary">
                    View My Payments
                </a>

            <?php endif; ?>

        </div>

        <p class="pl-security-footer">
            <span>🔒</span>
            Your payment information is handled securely through the
            integrated payment gateway.
        </p>

    </div>

    <!-- Toast Notification -->
    <div class="pl-toast" id="plToast" role="status" aria-live="polite"></div>

</main>

 

<?php include __DIR__ . '/footer.php'; ?>
