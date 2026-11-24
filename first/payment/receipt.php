<?php
// Payment receipt (paid or refunded payments of the logged-in user). Print / Save as PDF from the browser.
require_once __DIR__ . '/_pay.php';
$t = rows("SELECT * FROM transactions WHERE id=? AND user_id=? AND status IN ('paid','refunded')", [(int)($_GET['id'] ?? 0), $payUid])[0] ?? null;
if (!$t) { header('Location: my-payments.php'); exit; }
$row = pay_row($t, $payUser['name']);
$comm = pl_community_names()[$t['community_id']] ?? '—';
$x = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
$money = fn($v) => '₹' . number_format((float)$v, 2);
include __DIR__ . '/header.php';
?>
<main class="rc-page">
  <div class="rc-actions no-print">
    <a href="my-payments.php" class="rc-link">← Back to My Payments</a>
    <button type="button" class="rc-btn" onclick="window.print()">Print / Save as PDF</button>
  </div>
  <article class="rc-card" aria-label="Payment receipt">
    <header class="rc-head">
      <img src="<?= $x(LOGO_URL) ?>" alt="PeopleLink" class="rc-logo">
      <div class="rc-title"><h1>Payment Receipt</h1><span>Receipt no. <strong><?= $x($row['id']) ?></strong></span></div>
    </header>
    <div class="rc-status <?= $row['status'] === 'Refunded' ? 'refunded' : '' ?>"><?= $row['status'] === 'Refunded' ? 'Refunded' : 'Paid' ?></div>
    <section class="rc-grid">
      <div><span>Paid by</span><strong><?= $x($payUser['name']) ?></strong><small><?= $x($payUser['email']) ?></small></div>
      <div><span>Date</span><strong><?= $x(date('d M Y, h:i A', strtotime($row['date']))) ?></strong></div>
      <div><span>Community</span><strong><?= $x($comm) ?></strong></div>
      <div><span>Payment method</span><strong><?= $x($row['method']) ?></strong></div>
      <div><span>Payment ID</span><strong><?= $x($t['razorpay_payment_id'] ?: '—') ?></strong></div>
      <div><span>Order ID</span><strong><?= $x($t['razorpay_order_id'] ?: '—') ?></strong></div>
    </section>
    <table class="rc-table">
      <thead><tr><th>Description</th><th>Module</th><th class="r">Amount</th></tr></thead>
      <tbody><tr><td><?= $x($row['package']) ?></td><td><?= $x($row['module']) ?></td><td class="r"><?= $money($row['amount']) ?></td></tr></tbody>
      <tfoot>
        <tr><td colspan="2">Total paid</td><td class="r"><strong><?= $money($row['amount']) ?></strong></td></tr>
        <?php if ((float)($t['refund_amount'] ?? 0) > 0): ?><tr><td colspan="2">Refunded</td><td class="r">− <?= $money($t['refund_amount']) ?></td></tr><?php endif; ?>
      </tfoot>
    </table>
    <p class="rc-note">This is a computer-generated receipt from PeopleLink Technologies Private Limited and does not need a signature.
      For questions about this payment, contact support with the receipt number.</p>
  </article>
</main>
<style>
.rc-page{max-width:820px;margin:32px auto 56px;padding:0 16px;font-family:Inter,Arial,sans-serif;color:#10233f}
.rc-actions{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:16px;flex-wrap:wrap}
.rc-link{color:#1261a8;font-weight:600;text-decoration:none}.rc-btn{background:#1261a8;color:#fff;border:0;border-radius:10px;padding:11px 18px;font-weight:700;cursor:pointer}
.rc-card{background:#fff;border:1px solid #e4e8ee;border-radius:18px;padding:32px;box-shadow:0 12px 30px rgba(16,35,63,.06)}
.rc-head{display:flex;justify-content:space-between;align-items:center;gap:16px;border-bottom:1px solid #eef1f5;padding-bottom:18px;flex-wrap:wrap}
.rc-logo{height:60px;width:auto}.rc-title{text-align:right}.rc-title h1{margin:0 0 4px;font-size:24px}.rc-title span{color:#64748b;font-size:14px}
.rc-status{display:inline-block;margin:18px 0 8px;background:#e9f8ee;color:#17663a;border-radius:20px;padding:5px 14px;font-weight:700;font-size:13px}.rc-status.refunded{background:#fff4e5;color:#9a5b00}
.rc-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px 24px;margin:14px 0 22px}.rc-grid span{display:block;color:#64748b;font-size:13px;margin-bottom:3px}.rc-grid strong{word-break:break-all}.rc-grid small{display:block;color:#64748b}
.rc-table{width:100%;border-collapse:collapse}.rc-table th,.rc-table td{padding:12px 10px;border-bottom:1px solid #eef1f5;text-align:left}.rc-table th{background:#f5f8fc;font-size:13px;color:#475569}.rc-table .r{text-align:right}
.rc-table tfoot td{border-bottom:0;font-size:16px}.rc-note{color:#64748b;font-size:13px;margin-top:22px;line-height:1.6}
@media (max-width:600px){.rc-card{padding:20px}.rc-grid{grid-template-columns:1fr}.rc-title{text-align:left}}
@media print{.no-print,header,footer,.pl-topbar,.pl-header,nav{display:none!important}.rc-page{margin:0;max-width:none}.rc-card{border:0;box-shadow:none}}
</style>
<?php include __DIR__ . '/footer.php'; ?>
