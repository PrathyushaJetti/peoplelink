<?php
// Basic audit log: who changed what, when.
require __DIR__ . '/_boot.php';
$ek = isset($_GET['e']) && pl_entity((string)$_GET['e']) ? (string)$_GET['e'] : '';
$q = trim((string)($_GET['q'] ?? '')); $all = ($_GET['cf'] ?? '') === 'all';
$w = $all ? '1=1' : '(a.community_id=? OR a.community_id IS NULL)'; $p = $all ? [] : [$cid];
if ($ek) { $w .= ' AND a.entity=?'; $p[] = $ek; }
if ($q !== '') { $w .= ' AND (a.action LIKE ? OR a.details LIKE ? OR u.name LIKE ?)'; array_push($p, "%$q%", "%$q%", "%$q%"); }
$page = max(1, (int)($_GET['page'] ?? 1));
$total = scalar("SELECT COUNT(*) FROM audit_log a LEFT JOIN users u ON u.id=a.user_id WHERE $w", $p);
$list = rows("SELECT a.*, u.name uname FROM audit_log a LEFT JOIN users u ON u.id=a.user_id WHERE $w ORDER BY a.id DESC LIMIT 50 OFFSET " . (($page - 1) * 50), $p);
render_header('Audit Log', 'auto', $user, $comm); ?>
<div class="card anim">
  <form class="toolbar" method="get"><input class="grow" name="q" value="<?= e($q) ?>" placeholder="Search action, details or admin name">
    <select name="e"><option value="">All modules</option><?php foreach (pl_entity_keys() as $k): ?><option value="<?= e($k) ?>" <?= $ek === $k ? 'selected' : '' ?>><?= e(pl_entity($k)['plural']) ?></option><?php endforeach; ?></select>
    <select name="cf"><option value="">This community</option><option value="all" <?= $all ? 'selected' : '' ?>>All communities</option></select>
    <button class="btn btn-primary"><?= icon('fa-magnifying-glass') ?> Search</button></form>
  <?php if (!$list): ?><div class="empty"><?= icon('fa-clock-rotate-left', 'big') ?>No activity recorded.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>When</th><th>Who</th><th>Action</th><th>Record</th><th>Details</th><th>IP</th></tr></thead><tbody>
  <?php foreach ($list as $l): $E = $l['entity'] ? pl_entity($l['entity']) : null; ?><tr>
    <td data-label="When"><?= e(date('d M Y, H:i', strtotime($l['created_at']))) ?></td><td data-label="Who"><?= e($l['uname'] ?? 'System / app user') ?></td>
    <td data-label="Action"><b><?= e(pl_status_label(str_replace(':', ' → ', $l['action']))) ?></b></td>
    <td data-label="Record"><?= $E ? '<a class="lnk" href="manage.php?e=' . e($E['key']) . '&view=' . (int)$l['entity_id'] . '">' . e($E['label']) . ' #' . (int)$l['entity_id'] . '</a>' : ($l['entity_id'] ? '#' . (int)$l['entity_id'] : '—') ?></td>
    <td data-label="Details"><small><?= e(mb_strimwidth((string)$l['details'], 0, 160, '…')) ?></small></td><td data-label="IP"><small><?= e($l['ip']) ?></small></td></tr>
  <?php endforeach; ?></tbody></table></div><?= pl_pager($page, (int)ceil($total / 50)) ?><?php endif; ?>
</div>
<?php render_footer();
