<?php
// Module reports (summary) + the common Report/Block queue for listings, profiles, events, ads.
require __DIR__ . '/_boot.php';
$tab = ($_GET['tab'] ?? '') === 'reported' ? 'reported' : 'summary';
$byTable = [];
foreach (pl_entity_keys() as $k) { $E = pl_entity($k); if ($E['report']) $byTable[$E['table']] = $k; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $r = rows('SELECT * FROM content_reports WHERE id=?', [(int)($_POST['id'] ?? 0)])[0] ?? null;
    $act = $_POST['action'] ?? '';
    if ($r && in_array($act, ['reviewed', 'dismissed', 'hide', 'open'], true)) {
        if ($act === 'hide' && isset($byTable[$r['entity']])) {
            $E = pl_entity($byTable[$r['entity']]);
            pl_entity_update($E, (int)$r['entity_id'], [$E['active_col'] => 0]);
            pl_audit('deactivate', $E['key'], (int)$r['entity_id'], 'Hidden after report #' . $r['id'], $r['community_id'] ? (int)$r['community_id'] : null);
        }
        db()->prepare('UPDATE content_reports SET status=?, reviewed_by=?, admin_notes=? WHERE id=?')->execute([$act === 'hide' ? 'reviewed' : $act, (int)$user['id'], mb_substr(trim((string)($_POST['admin_notes'] ?? $r['admin_notes'] ?? '')), 0, 2000), $r['id']]);
        flash($act === 'hide' ? 'Content hidden and report closed' : 'Report updated');
    }
    header('Location: ' . pl_ret('reports.php?tab=reported')); exit;
}

render_header($tab === 'reported' ? 'Reported Content' : 'Module Reports', 'auto', $user, $comm); ?>
<div class="tabs anim"><a class="<?= $tab === 'summary' ? 'on' : '' ?>" href="reports.php">Module summary</a><a class="<?= $tab === 'reported' ? 'on' : '' ?>" href="reports.php?tab=reported">Reported content</a></div>
<?php if ($tab === 'reported'):
    $ek = isset($_GET['e']) && pl_entity((string)$_GET['e']) ? (string)$_GET['e'] : '';
    $st = (string)($_GET['status'] ?? 'open'); $st = $st === 'all' ? '' : (in_array($st, ['open', 'reviewed', 'dismissed'], true) ? $st : 'open');
    $w = '(r.community_id=? OR r.community_id IS NULL)'; $a = [$cid];
    if ($ek) { $w .= ' AND r.entity=?'; $a[] = pl_entity($ek)['table']; }
    $counts = array_column(rows("SELECT r.status, COUNT(*) c FROM content_reports r WHERE $w GROUP BY r.status", $a), 'c', 'status');
    if ($st !== '') { $w .= ' AND r.status=?'; $a[] = $st; }
    $list = rows("SELECT r.*, u.name uname FROM content_reports r LEFT JOIN users u ON u.id=r.user_id WHERE $w ORDER BY r.id DESC LIMIT 100", $a); ?>
<div class="tabs anim"><?php foreach (['open' => 'Open', 'reviewed' => 'Reviewed', 'dismissed' => 'Dismissed', '' => 'All'] as $s => $l): ?><a class="<?= $st === $s ? 'on' : '' ?>" href="<?= e(pl_url(['tab' => 'reported', 'e' => $ek, 'status' => $s === '' ? 'all' : $s], 'reports.php')) ?>"><?= $l ?> (<?= $s === '' ? array_sum($counts) : (int)($counts[$s] ?? 0) ?>)</a><?php endforeach; ?></div>
<div class="card anim">
  <form class="toolbar" method="get"><input type="hidden" name="tab" value="reported"><input type="hidden" name="status" value="<?= e($st) ?>"><select name="e"><option value="">All modules</option><?php foreach ($byTable as $k): ?><option value="<?= e($k) ?>" <?= $ek === $k ? 'selected' : '' ?>><?= e(pl_entity($k)['plural']) ?></option><?php endforeach; ?></select><button class="btn btn-primary">Filter</button></form>
  <?php if (!$list): ?><div class="empty"><?= icon('fa-flag', 'big') ?>No reports here.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Content</th><th>Reason</th><th>Reported by</th><th>Type</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead><tbody>
  <?php foreach ($list as $r): $E = isset($byTable[$r['entity']]) ? pl_entity($byTable[$r['entity']]) : null; $item = $E ? pl_entity_row($E, (int)$r['entity_id']) : null; ?><tr>
    <td data-label="Content"><?php if ($E && $item): ?><a class="lnk" href="manage.php?e=<?= e($E['key']) ?>&view=<?= (int)$item['id'] ?>"><?= e(pl_entity_title($E, $item)) ?></a><br><small><?= e($E['label']) ?> · <?= $item[$E['active_col']] ? 'visible' : 'hidden' ?></small><?php else: ?><span class="muted">Removed (<?= e($r['entity']) ?> #<?= (int)$r['entity_id'] ?>)</span><?php endif; ?></td>
    <td data-label="Reason"><b><?= e($r['reason']) ?></b><br><small><?= e(mb_strimwidth((string)$r['details'], 0, 140, '…')) ?></small></td>
    <td data-label="By"><?= e($r['uname'] ?? '—') ?></td><td data-label="Type"><?= e(ucfirst($r['action_type'])) ?></td><td data-label="Date"><?= dshort($r['created_at']) ?></td><td data-label="Status"><?= pl_status_badge($r['status']) ?></td>
    <td data-label="Actions"><div class="actions"><?php foreach ($r['status'] === 'open' ? [['hide', 'Hide content', 'btn-red'], ['reviewed', 'Mark reviewed', 'btn-blue'], ['dismissed', 'Dismiss', 'btn-line']] : [['open', 'Reopen', 'btn-orange']] as [$a2, $l, $c]): ?>
      <form class="inline" method="post"<?= $a2 === 'hide' ? ' data-confirm="Hide this content from the app?"' : '' ?>><?= pl_csrf_field() ?><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><input type="hidden" name="action" value="<?= $a2 ?>"><input type="hidden" name="ret" value="<?= e(pl_here()) ?>"><button class="btn btn-sm <?= $c ?>"><?= $l ?></button></form>
    <?php endforeach; ?></div></td></tr>
  <?php endforeach; ?></tbody></table></div><?php endif; ?>
</div>
<?php else:
    $cf = (string)($_GET['cf'] ?? '');
    $g = ['cf' => $cf];
    $rowsOut = [];
    foreach (pl_entity_keys() as $k) {
        $E = pl_entity($k); if ($k === 'package') continue;
        $a = []; $base = pl_admin_base($E, $cid, $a, $g);
        $c = fn($sql) => scalar("SELECT COUNT(*) FROM {$E['table']} t WHERE $base AND $sql", $a);
        $rowsOut[] = [$E, $c('1=1'), $E['statuses'] ? $c("t.{$E['status_col']}='pending'") : null, $E['statuses'] ? $c("t.{$E['status_col']}='" . ($E['public_statuses'][0] ?? 'approved') . "'") : null,
            $c("t.{$E['active_col']}=1"), $c("t.created_at >= '" . date('Y-m-01') . "'"),
            $E['save'] ? scalar('SELECT COUNT(*) FROM favourites WHERE entity=?', [$E['table']]) : null, $E['enquiry'] ? scalar("SELECT COUNT(*) FROM enquiries q JOIN {$E['table']} t ON t.id=q.entity_id WHERE q.entity=? AND $base", array_merge([$E['table']], $a)) : null];
    }
    $rev = rows("SELECT module_key, COUNT(*) n, SUM(amount) s FROM transactions WHERE status='paid'" . ($cf === 'all' ? '' : ' AND community_id=?') . ' GROUP BY module_key ORDER BY s DESC', $cf === 'all' ? [] : [ctype_digit($cf) ? (int)$cf : $cid]); ?>
<div class="card anim">
  <form class="toolbar" method="get"><?= pl_community_select('cf', $cf === '' ? (string)$cid : $cf, true) ?><button class="btn btn-primary">Show</button></form>
  <div class="tw"><table class="rt"><thead><tr><th>Module</th><th>Total</th><th>Pending</th><th>Approved</th><th>Active</th><th>New this month</th><th>Saved</th><th>Enquiries</th></tr></thead><tbody>
  <?php foreach ($rowsOut as [$E, $t, $p, $ap, $ac, $nm, $sv, $eq]): ?><tr>
    <td data-label="Module"><a class="lnk" href="manage.php?e=<?= e($E['key']) ?><?= $cf ? '&cf=' . e($cf) : '' ?>"><?= icon($E['icon']) ?> <?= e($E['plural']) ?></a></td>
    <td data-label="Total"><b><?= $t ?></b></td><td data-label="Pending"><?= $p ?? '—' ?></td><td data-label="Approved"><?= $ap ?? '—' ?></td><td data-label="Active"><?= $ac ?></td><td data-label="New this month"><?= $nm ?></td><td data-label="Saved"><?= $sv ?? '—' ?></td><td data-label="Enquiries"><?= $eq ?? '—' ?></td></tr>
  <?php endforeach; ?></tbody></table></div></div>
<div class="card anim"><div class="card-h"><h3>Revenue by module (paid transactions)</h3><a class="btn btn-line btn-sm" href="transactions.php">Transactions</a></div>
  <?php if (!$rev): ?><div class="empty"><?= icon('fa-indian-rupee-sign', 'big') ?>No paid transactions yet.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Module</th><th>Payments</th><th>Revenue</th></tr></thead><tbody><?php foreach ($rev as $r): ?><tr><td data-label="Module"><?= e(PL_PACKAGE_MODULES[$r['module_key']] ?? $r['module_key']) ?></td><td data-label="Payments"><?= (int)$r['n'] ?></td><td data-label="Revenue"><b><?= money($r['s']) ?></b></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?></div>
<?php endif;
render_footer();
