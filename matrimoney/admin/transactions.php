<?php
// Common Payments / Transactions (Razorpay) + active packages.
require __DIR__ . '/_boot.php';
require_once __DIR__ . '/../includes/payments.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); $t = pl_txn((int)($_POST['id'] ?? 0));
    if ($t && ($_POST['action'] ?? '') === 'reconcile') { $msg = pl_txn_reconcile($t); pl_audit('payment:reconcile', null, (int)$t['id'], $msg, $t['community_id'] ? (int)$t['community_id'] : null); flash($msg); }
    header('Location: transactions.php?view=' . (int)($_POST['id'] ?? 0)); exit;
}

if (isset($_GET['receipt']) && ($t = pl_txn((int)$_GET['receipt']))):
    $u = rows('SELECT name, email, phone FROM users WHERE id=?', [$t['user_id']])[0] ?? []; ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><title>Receipt <?= e($t['txn_code']) ?></title><link rel="stylesheet" href="../assets/style.css"></head>
<body class="receipt"><div class="rc"><img class="logo" src="<?= LOGO_URL ?>" alt="PeopleLink" style="height:48px"><h2>Payment receipt</h2>
<div class="kv one">
  <?php foreach (['Receipt no.' => $t['txn_code'], 'Date' => date('d M Y, H:i', strtotime($t['paid_at'] ?: $t['created_at'])), 'Paid by' => ($u['name'] ?? '') . ' · ' . ($u['email'] ?? ''),
      'Community' => pl_community_names()[$t['community_id']] ?? '—', 'Module' => PL_PACKAGE_MODULES[$t['module_key']] ?? $t['module_key'], 'Package' => $t['package_name'],
      'Amount' => '₹' . number_format((float)$t['amount'], 2), 'Payment method' => $t['method'] ?: '—', 'Status' => pl_status_label($t['status']),
      'Razorpay order' => $t['razorpay_order_id'], 'Razorpay payment' => $t['razorpay_payment_id'] ?: '—'] as $l => $v): ?><div><span><?= e($l) ?></span><b><?= e($v) ?></b></div><?php endforeach; ?>
</div><button class="btn btn-primary mt" onclick="print()">Print</button></div></body></html>
<?php exit; endif;

if (isset($_GET['view']) && ($t = pl_txn((int)$_GET['view']))):
    $u = rows('SELECT id, name, email, phone FROM users WHERE id=?', [$t['user_id']])[0] ?? null;
    $up = rows('SELECT * FROM user_packages WHERE transaction_id=?', [$t['id']])[0] ?? null;
    render_header('Transaction ' . $t['txn_code'], 'Payments & Transactions/Payments Dashboard', $user, $comm); ?>
<div class="card anim"><div class="card-h"><div><h3><?= e($t['txn_code']) ?></h3><small class="muted"><?= e($t['package_name']) ?> · <?= money($t['amount']) ?></small></div><div class="actions"><?= pl_status_badge($t['status']) ?></div></div>
  <div class="actions"><form class="inline" method="post"><?= pl_csrf_field() ?><input type="hidden" name="id" value="<?= (int)$t['id'] ?>"><input type="hidden" name="action" value="reconcile"><button class="btn btn-sm btn-blue"><?= icon('fa-rotate') ?> Check status with Razorpay / reconcile</button></form>
    <a class="btn btn-sm btn-line" target="_blank" href="transactions.php?receipt=<?= (int)$t['id'] ?>"><?= icon('fa-receipt') ?> View receipt</a><a class="btn btn-sm btn-line" href="transactions.php"><?= icon('fa-arrow-left') ?> All transactions</a></div></div>
<div class="grid2 anim"><div class="card"><div class="card-h"><h3>Transaction</h3></div><div class="kv">
  <?php foreach (['Transaction ID' => $t['txn_code'], 'Module' => PL_PACKAGE_MODULES[$t['module_key']] ?? $t['module_key'], 'Package' => $t['package_name'], 'Amount' => money($t['amount']),
      'Razorpay Order ID' => $t['razorpay_order_id'] ?: '—', 'Razorpay Payment ID' => $t['razorpay_payment_id'] ?: '—', 'Payment method' => $t['method'] ?: '—',
      'Created' => date('d M Y, H:i', strtotime($t['created_at'])), 'Paid' => $t['paid_at'] ? date('d M Y, H:i', strtotime($t['paid_at'])) : '—',
      'Refund' => $t['refund_status'] ? $t['refund_status'] . ' (' . money($t['refund_amount']) . ')' : '—', 'Error' => $t['error_text'] ?: '—', 'Paid for' => $t['ref_entity'] ? $t['ref_entity'] . ' #' . $t['ref_id'] : '—'] as $l => $v): ?>
    <div><span><?= e($l) ?></span><b><?= e($v) ?></b></div><?php endforeach; ?></div></div>
  <div class="card"><div class="card-h"><h3>User & package</h3></div><div class="kv one">
    <div><span>User</span><b><?= $u ? '<a class="lnk" href="users.php?view=' . (int)$u['id'] . '">' . e($u['name']) . '</a><br><small>' . e($u['email']) . ' ' . e($u['phone']) . '</small>' : '—' ?></b></div>
    <div><span>Community</span><b><?= e(pl_community_names()[$t['community_id']] ?? '—') ?></b></div>
    <div><span>Package activation</span><b><?= $up ? dshort($up['starts_at']) . ' → ' . dshort($up['expires_at']) : 'Not activated' ?></b></div></div></div></div>
<?php render_footer(); exit; endif;

$tab = ($_GET['tab'] ?? '') === 'packages' ? 'packages' : 'txn';
$cf = (string)($_GET['cf'] ?? ''); $q = trim((string)($_GET['q'] ?? '')); $mod = (string)($_GET['module'] ?? '');
$w = '1=1'; $a = [];
if ($cf !== 'all') { $w .= ' AND t.community_id=?'; $a[] = ctype_digit($cf) ? (int)$cf : $cid; }
if ($mod !== '' && isset(PL_PACKAGE_MODULES[$mod])) { $w .= ' AND t.module_key=?'; $a[] = $mod; }
render_header('Payments & Transactions', 'auto', $user, $comm);
if ($tab === 'txn'):
    if ($q !== '') { $w .= ' AND (t.txn_code LIKE ? OR t.razorpay_order_id LIKE ? OR t.razorpay_payment_id LIKE ? OR u.email LIKE ? OR u.name LIKE ?)'; array_push($a, "%$q%", "%$q%", "%$q%", "%$q%", "%$q%"); }
    $sum = array_column(rows("SELECT t.status, COUNT(*) c, SUM(t.amount) s FROM transactions t LEFT JOIN users u ON u.id=t.user_id WHERE $w GROUP BY t.status", $a), null, 'status');
    $n = fn($s) => (int)($sum[$s]['c'] ?? 0);
    $status = in_array($_GET['status'] ?? '', ['paid', 'created', 'failed', 'refunded'], true) ? $_GET['status'] : '';
    $sw = $status === 'created' ? " AND t.status IN ('created','pending')" : ($status ? ' AND t.status=?' : '');
    $sa = $status && $status !== 'created' ? array_merge($a, [$status]) : $a;
    $page = max(1, (int)($_GET['page'] ?? 1));
    $total = scalar("SELECT COUNT(*) FROM transactions t LEFT JOIN users u ON u.id=t.user_id WHERE $w$sw", $sa);
    $list = rows("SELECT t.*, u.name uname, u.email FROM transactions t LEFT JOIN users u ON u.id=t.user_id WHERE $w$sw ORDER BY t.id DESC LIMIT 25 OFFSET " . (($page - 1) * 25), $sa);
    echo pl_stat_cards([['Total Revenue', [(float)($sum['paid']['s'] ?? 0), '₹'], 'fa-indian-rupee-sign'], ['Successful', $n('paid'), 'fa-circle-check'],
        ['Pending', $n('created') + $n('pending'), 'fa-hourglass-half'], ['Failed', $n('failed'), 'fa-triangle-exclamation'], ['Refunded', $n('refunded'), 'fa-rotate-left'],
        ['Total Transactions', array_sum(array_map('intval', array_column($sum, 'c'))), 'fa-receipt']]);
    $keep = ['q' => $q, 'cf' => $cf, 'module' => $mod]; ?>
<div class="tabs anim"><a class="on" href="transactions.php">Transactions</a><a href="transactions.php?tab=packages">Active packages</a><a href="manage.php?e=package">Packages & pricing</a></div>
<div class="tabs anim"><?php foreach (['' => 'All', 'paid' => 'Successful', 'created' => 'Pending', 'failed' => 'Failed', 'refunded' => 'Refunded'] as $s => $l): ?><a class="<?= $status === $s ? 'on' : '' ?>" href="<?= e(pl_url($keep + ['status' => $s], 'transactions.php')) ?>"><?= $l ?></a><?php endforeach; ?></div>
<div class="card anim">
  <?php if (RAZORPAY_KEY_ID === ''): ?><div class="alert error">Razorpay keys are not set yet — add RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET and RAZORPAY_WEBHOOK_SECRET in config.php.</div><?php endif; ?>
  <form class="toolbar" method="get"><input type="hidden" name="status" value="<?= e($status) ?>"><input class="grow" name="q" value="<?= e($q) ?>" placeholder="Transaction ID, Razorpay order / payment ID, user">
    <select name="module"><option value="">All modules</option><?php foreach (PL_PACKAGE_MODULES as $k => $l): ?><option value="<?= $k ?>" <?= $mod === $k ? 'selected' : '' ?>><?= e($l) ?></option><?php endforeach; ?></select>
    <?= pl_community_select('cf', $cf === '' ? (string)$cid : $cf, true) ?><button class="btn btn-primary"><?= icon('fa-magnifying-glass') ?> Search</button></form>
  <?php if (!$list): ?><div class="empty"><?= icon('fa-receipt', 'big') ?>No transactions found.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Transaction</th><th>User</th><th>Community</th><th>Module / Package</th><th>Amount</th><th>Razorpay</th><th>Method</th><th>Date</th><th>Status</th><th></th></tr></thead><tbody>
  <?php foreach ($list as $r): ?><tr>
    <td data-label="Transaction"><b><?= e($r['txn_code']) ?></b></td><td data-label="User"><?= e($r['uname'] ?? '#' . $r['user_id']) ?><br><small><?= e($r['email'] ?? '') ?></small></td>
    <td data-label="Community"><?= e(pl_community_names()[$r['community_id']] ?? '—') ?></td>
    <td data-label="Module / Package"><?= e(PL_PACKAGE_MODULES[$r['module_key']] ?? $r['module_key']) ?><br><small><?= e($r['package_name']) ?></small></td><td data-label="Amount"><b><?= money($r['amount']) ?></b></td>
    <td data-label="Razorpay"><small><?= e($r['razorpay_order_id'] ?: '—') ?><br><?= e($r['razorpay_payment_id'] ?: '') ?></small></td><td data-label="Method"><?= e($r['method'] ?: '—') ?></td>
    <td data-label="Date"><?= dshort($r['created_at']) ?></td><td data-label="Status"><?= pl_status_badge($r['status']) ?></td>
    <td><a class="btn btn-sm btn-line" href="transactions.php?view=<?= (int)$r['id'] ?>"><?= icon('fa-eye') ?></a></td></tr>
  <?php endforeach; ?></tbody></table></div><?= pl_pager($page, (int)ceil($total / 25)) ?><?php endif; ?>
</div>
<?php else:
    db()->exec("UPDATE user_packages SET status='expired' WHERE status='active' AND expires_at < NOW()");
    $show = ($_GET['state'] ?? 'active') === 'expired' ? 'expired' : 'active';
    $list = rows("SELECT t.*, p.name pname, u.name uname, u.email FROM user_packages t LEFT JOIN packages p ON p.id=t.package_id LEFT JOIN users u ON u.id=t.user_id WHERE $w AND t.status=? ORDER BY t.expires_at LIMIT 200", array_merge($a, [$show])); ?>
<div class="tabs anim"><a href="transactions.php">Transactions</a><a class="on" href="transactions.php?tab=packages">Active packages</a><a href="manage.php?e=package">Packages & pricing</a></div>
<div class="tabs anim"><a class="<?= $show === 'active' ? 'on' : '' ?>" href="?tab=packages&state=active">Active</a><a class="<?= $show === 'expired' ? 'on' : '' ?>" href="?tab=packages&state=expired">Expired</a></div>
<div class="card anim"><?php if (!$list): ?><div class="empty"><?= icon('fa-box-open', 'big') ?>No <?= $show ?> packages.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>User</th><th>Package</th><th>Module</th><th>Starts</th><th>Expires</th><th>Transaction</th></tr></thead><tbody>
  <?php foreach ($list as $r): ?><tr><td data-label="User"><a class="lnk" href="users.php?view=<?= (int)$r['user_id'] ?>"><?= e($r['uname'] ?? '#' . $r['user_id']) ?></a><br><small><?= e($r['email'] ?? '') ?></small></td><td data-label="Package"><?= e($r['pname'] ?? '#' . $r['package_id']) ?></td>
    <td data-label="Module"><?= e(PL_PACKAGE_MODULES[$r['module_key']] ?? $r['module_key']) ?></td><td data-label="Starts"><?= dshort($r['starts_at']) ?></td><td data-label="Expires"><?= dshort($r['expires_at']) ?></td>
    <td data-label="Transaction"><?= $r['transaction_id'] ? '<a class="lnk" href="transactions.php?view=' . (int)$r['transaction_id'] . '">#' . (int)$r['transaction_id'] . '</a>' : '—' ?></td></tr><?php endforeach; ?>
  </tbody></table></div><?php endif; ?></div>
<?php endif;
render_footer();
