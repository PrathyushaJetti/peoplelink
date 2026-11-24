<?php
// My Payments: every payment of the logged-in user (all modules).
require_once __DIR__ . '/_pay.php';
include __DIR__ . '/header.php';
$transactions = array_map(fn($t) => pay_row($t, $payUser['name']), rows('SELECT * FROM transactions WHERE user_id=? ORDER BY id DESC LIMIT 200', [$payUid]));
function mpEscape($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function mpAmount($amount) {
    return '₹' . number_format((float)$amount, 2);
}

function mpDate($date) {
    return date('d M Y, h:i A', strtotime($date));
}

$summary = [
    'total' => count($transactions),
    'successful' => 0,
    'pending' => 0,
    'failed' => 0
];

foreach ($transactions as $transaction) {
    if ($transaction['status'] === 'Successful') {
        $summary['successful']++;
    } elseif ($transaction['status'] === 'Pending') {
        $summary['pending']++;
    } elseif ($transaction['status'] === 'Failed') {
        $summary['failed']++;
    }
}

$modules = array_unique(array_column($transactions, 'module'));
$methods = array_unique(array_column($transactions, 'method'));
?>

 

<main class="mp-page">

    <div class="mp-container">

        <!-- Breadcrumb -->
        <nav class="mp-breadcrumb" aria-label="Breadcrumb">
            <a href="../index.php">Home</a>
            <span>/</span>
            <a href="../profile/my-profile.php">My Account</a>
            <span>/</span>
            <span>My Payments</span>
        </nav>

        <!-- Page Heading -->
        <section class="mp-heading">
            <div>
                <span class="mp-eyebrow">PEOPLELINK ACCOUNT</span>
                <h1>My Payments</h1>
                <p>Track your purchases and payment history across PeopleLink.</p>
            </div>

            <div class="mp-heading-icon" aria-hidden="true">↗</div>
        </section>

        <!-- Summary Cards -->
        <section class="mp-summary-grid" aria-label="Payment summary">

            <article class="mp-summary-card mp-summary-total">
                <div class="mp-summary-top">
                    <span>Total Transactions</span>
                    <span class="mp-summary-icon">▤</span>
                </div>
                <strong><?= $summary['total'] ?></strong>
                <small>All recorded transactions</small>
            </article>

            <article class="mp-summary-card">
                <div class="mp-summary-top">
                    <span>Successful Payments</span>
                    <span class="mp-summary-icon mp-icon-success">✓</span>
                </div>
                <strong><?= $summary['successful'] ?></strong>
                <small>Confirmed payments</small>
            </article>

            <article class="mp-summary-card">
                <div class="mp-summary-top">
                    <span>Pending Payments</span>
                    <span class="mp-summary-icon mp-icon-pending">◷</span>
                </div>
                <strong><?= $summary['pending'] ?></strong>
                <small>Awaiting confirmation</small>
            </article>

            <article class="mp-summary-card">
                <div class="mp-summary-top">
                    <span>Failed Payments</span>
                    <span class="mp-summary-icon mp-icon-failed">×</span>
                </div>
                <strong><?= $summary['failed'] ?></strong>
                <small>Unsuccessful transactions</small>
            </article>

        </section>

        <!-- Transactions -->
        <section class="mp-table-card">

            <div class="mp-table-heading">
                <div>
                    <span class="mp-section-label">PAYMENT RECORDS</span>
                    <h2>Transaction History</h2>
                    <p>View and manage payments for all your PeopleLink services.</p>
                </div>

                <span class="mp-record-count">
                    <span id="mpVisibleCount"><?= count($transactions) ?></span>
                    transactions
                </span>
            </div>

            <!-- Filters -->
            <form id="mpFilterForm" class="mp-filters">

                <div class="mp-filter-field mp-search-field">
                    <label for="mpSearch">Search transactions</label>
                    <input
                        type="search"
                        id="mpSearch"
                        placeholder="Search transaction ID or package..."
                        autocomplete="off">
                </div>

                <div class="mp-filter-field">
                    <label for="mpFromDate">From date</label>
                    <input type="date" id="mpFromDate">
                </div>

                <div class="mp-filter-field">
                    <label for="mpToDate">To date</label>
                    <input type="date" id="mpToDate">
                </div>

                <div class="mp-filter-field">
                    <label for="mpModule">Module / Service</label>
                    <select id="mpModule">
                        <option value="">All Modules</option>
                        <?php foreach ($modules as $module): ?>
                            <option value="<?= mpEscape($module) ?>">
                                <?= mpEscape($module) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mp-filter-field">
                    <label for="mpStatus">Payment Status</label>
                    <select id="mpStatus">
                        <option value="">All Statuses</option>
                        <option value="Successful">Successful</option>
                        <option value="Pending">Pending</option>
                        <option value="Failed">Failed</option>
                        <option value="Refunded">Refunded</option>
                    </select>
                </div>

                <div class="mp-filter-field">
                    <label for="mpMethod">Payment Method</label>
                    <select id="mpMethod">
                        <option value="">All Methods</option>
                        <?php foreach ($methods as $method): ?>
                            <option value="<?= mpEscape($method) ?>">
                                <?= mpEscape($method) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mp-filter-actions">
                    <button type="button" id="mpReset" class="mp-reset-btn">
                        Reset Filters
                    </button>
                </div>

            </form>

            <!-- Table -->
            <div class="mp-table-wrap">
                <table class="mp-table">
                    <thead>
                        <tr>
                            <th>Transaction</th>
                            <th>Module / Package</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody id="mpTableBody">

                    <?php foreach ($transactions as $index => $transaction): ?>
                        <?php
                        $statusClass = strtolower($transaction['status']);
                        $searchText = implode(' ', [
                            $transaction['id'],
                            $transaction['module'],
                            $transaction['package'],
                            $transaction['method'],
                            $transaction['status']
                        ]);
                        ?>

                        <tr class="mp-transaction-row"
                            data-search="<?= mpEscape($searchText) ?>"
                            data-date="<?= mpEscape(date('Y-m-d', strtotime($transaction['date']))) ?>"
                            data-module="<?= mpEscape($transaction['module']) ?>"
                            data-status="<?= mpEscape($transaction['status']) ?>"
                            data-method="<?= mpEscape($transaction['method']) ?>">

                            <td>
                                <strong class="mp-transaction-id">
                                    <?= mpEscape($transaction['id']) ?>
                                </strong>
                                <span class="mp-mobile-date">
                                    <?= mpEscape(mpDate($transaction['date'])) ?>
                                </span>
                            </td>

                            <td>
                                <strong class="mp-module-name">
                                    <?= mpEscape($transaction['module']) ?>
                                </strong>
                                <span class="mp-package-name">
                                    <?= mpEscape($transaction['package']) ?>
                                </span>
                            </td>

                            <td>
                                <strong class="mp-amount">
                                    <?= mpAmount($transaction['amount']) ?>
                                </strong>
                            </td>

                            <td class="mp-date-cell">
                                <?= mpEscape(mpDate($transaction['date'])) ?>
                            </td>

                            <td>
                                <?= mpEscape($transaction['method']) ?>
                            </td>

                            <td>
                                <span class="mp-status <?= mpEscape($statusClass) ?>">
                                    <span class="mp-status-dot"></span>
                                    <?= mpEscape($transaction['status']) ?>
                                </span>
                            </td>

                            <td>
                                <div class="mp-row-actions">

                                    <button
                                        type="button"
                                        class="mp-action-btn mp-view-btn"
                                        data-index="<?= $index ?>">
                                        View Details
                                    </button>

                                    <?php if ($transaction['status'] === 'Successful'): ?>
                                        <a
                                            class="mp-action-btn mp-receipt-btn"
                                            href="<?= mpEscape($transaction['receipt_url']) ?>">
                                            Receipt
                                        </a>

                                    <?php elseif ($transaction['status'] === 'Failed'): ?>
                                        <a
                                            class="mp-action-btn mp-retry-btn"
                                            href="<?= mpEscape($transaction['retry_url']) ?>">
                                            Retry
                                        </a>

                                    <?php elseif ($transaction['status'] === 'Pending'): ?>
                                        <a class="mp-action-btn mp-check-btn" href="payment-status.php?id=<?= (int)$transaction['db_id'] ?>">Check Status</a>

                                    <?php elseif ($transaction['status'] === 'Refunded'): ?>
                                        <a
                                            class="mp-action-btn mp-receipt-btn"
                                            href="<?= mpEscape($transaction['receipt_url']) ?>">
                                            Receipt
                                        </a>
                                    <?php endif; ?>

                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div class="mp-empty-state" id="mpEmptyState"
                 <?= count($transactions) ? 'hidden' : '' ?>>

                <div class="mp-empty-icon">⌕</div>
                <h3>No payment transactions found.</h3>
                <p>Try changing your filters or search for another transaction.</p>

                <button type="button" id="mpEmptyReset" class="mp-reset-btn">
                    Clear Filters
                </button>
            </div>

            <div class="mp-table-footer">
                <span>Showing <strong id="mpShowingCount"><?= count($transactions) ?></strong>
                    of <?= count($transactions) ?> transactions</span>
                <span>PeopleLink Payment History</span>
            </div>

        </section>

        <!-- Help -->
        <section class="mp-help-card">
            <div class="mp-help-icon">?</div>
            <div class="mp-help-content">
                <h3>Need help with a transaction?</h3>
                <p>Contact our support team if you have questions about a payment or receipt.</p>
            </div>
            <a href="../community/community-support.php" class="mp-help-link">
                Contact Support <span>→</span>
            </a>
        </section>

    </div>

    <!-- Transaction Details Modal -->
    <div class="mp-modal" id="mpDetailsModal"
         role="dialog" aria-modal="true"
         aria-labelledby="mpModalTitle" hidden>

        <div class="mp-modal-backdrop" data-close-modal></div>

        <div class="mp-modal-dialog">

            <div class="mp-modal-heading">
                <div>
                    <span class="mp-section-label">TRANSACTION INFORMATION</span>
                    <h2 id="mpModalTitle">Transaction Details</h2>
                </div>

                <button type="button" class="mp-modal-close"
                        id="mpModalClose" aria-label="Close dialog">
                    ×
                </button>
            </div>

            <div id="mpModalContent" class="mp-modal-content"></div>

            <div class="mp-modal-actions" id="mpModalActions"></div>

        </div>
    </div>

    <div class="mp-toast" id="mpToast" role="status" aria-live="polite"></div>

</main>

<script id="mpTransactionsData" type="application/json"><?=
    json_encode(
        $transactions,
        JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
    )
?></script>

 

<?php include __DIR__ . '/footer.php'; ?>
