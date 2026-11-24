<?php
$GLOBALS['ROOT'] = '../';
require_once __DIR__ . '/../includes/auth.php'; require_once __DIR__ . '/../includes/layout.php';
[$user, $comm] = require_login(); $cid = $comm['id'];
$status = $_GET['status'] ?? ''; $q = trim($_GET['q'] ?? '');
$where = 'i.community_id=?'; $p = [$cid];
if (in_array($status, ['sent', 'accepted', 'rejected'], true)) { $where .= ' AND i.status=?'; $p[] = $status; }
if ($q !== '') { $where .= ' AND (s.full_name LIKE ? OR r.full_name LIKE ?)'; array_push($p, "%$q%", "%$q%"); }
$list = rows("SELECT i.*, s.full_name sname, s.profile_code scode, r.full_name rname, r.profile_code rcode FROM matrimony_interests i
              JOIN matrimony_profiles s ON s.id=i.sender_id JOIN matrimony_profiles r ON r.id=i.receiver_id WHERE $where ORDER BY i.id DESC", $p);
$counts = array_column(rows('SELECT status, COUNT(*) c FROM matrimony_interests WHERE community_id=? GROUP BY status', [$cid]), 'c', 'status');
$tabs = ['' => ['All', array_sum($counts)], 'sent' => ['Sent (awaiting reply)', $counts['sent'] ?? 0], 'accepted' => ['Accepted', $counts['accepted'] ?? 0], 'rejected' => ['Rejected', $counts['rejected'] ?? 0]];
render_header('Interests', 'Matrimony/Interests', $user, $comm); ?>
<div class="stats anim">
  <div class="stat c-blue"><div class="ic"><?= icon('fa-envelope-open-text') ?></div><div class="n" data-count="<?= array_sum($counts) ?>">0</div><div class="l">Total Interests</div></div>
  <div class="stat c-orange"><div class="ic"><?= icon('fa-paper-plane') ?></div><div class="n" data-count="<?= $counts['sent'] ?? 0 ?>">0</div><div class="l">Sent / Waiting</div></div>
  <div class="stat c-purple"><div class="ic"><?= icon('fa-heart') ?></div><div class="n" data-count="<?= $counts['accepted'] ?? 0 ?>">0</div><div class="l">Accepted</div></div>
  <div class="stat c-red"><div class="ic"><?= icon('fa-ban') ?></div><div class="n" data-count="<?= $counts['rejected'] ?? 0 ?>">0</div><div class="l">Rejected</div></div>
</div>
<div class="tabs anim"><?php foreach ($tabs as $k => [$l, $n]): ?><a class="<?= $status === (string)$k ? 'on' : '' ?>" href="?status=<?= $k ?>&q=<?= urlencode($q) ?>"><?= $l ?> (<?= $n ?>)</a><?php endforeach; ?></div>
<div class="card anim">
  <form class="toolbar" method="get"><input type="hidden" name="status" value="<?= e($status) ?>"><input class="grow" name="q" value="<?= e($q) ?>" placeholder="Search sender or receiver name"><button class="btn btn-primary"><?= icon('fa-magnifying-glass') ?> Search</button></form>
  <?php if (!$list): ?><div class="empty"><?= icon('fa-envelope-open','big') ?>No interests found.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Sent by</th><th>Received by</th><th>Status</th><th>Date</th></tr></thead><tbody>
  <?php foreach ($list as $r): ?><tr>
    <td data-label="Sent by"><div class="person"><div class="pi"><?= e($r['sname'][0]) ?></div><div><b><?= e($r['sname']) ?></b><br><small><?= e($r['scode']) ?></small></div></div></td>
    <td data-label="Received by"><div class="person"><div class="pi alt-pi"><?= e($r['rname'][0]) ?></div><div><b><?= e($r['rname']) ?></b><br><small><?= e($r['rcode']) ?></small></div></div></td>
    <td data-label="Status"><?= badge($r['status'], $r['status'] === 'sent' ? 'awaiting reply' : $r['status']) ?></td><td data-label="Date"><?= dshort($r['created_at']) ?></td></tr>
  <?php endforeach; ?></tbody></table></div><?php endif; ?></div>
<?php render_footer();
