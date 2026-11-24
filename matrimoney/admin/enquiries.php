<?php
// Buyer / seller enquiries, directory contact requests and event registrations: enquiries.php?e=mp_listing|directory|event[&item=ID]
require __DIR__ . '/_boot.php';
$keys = array_values(array_filter(pl_entity_keys(), fn($k) => pl_entity($k)['enquiry']));
$k = in_array($_GET['e'] ?? '', $keys, true) ? $_GET['e'] : $keys[0];
$E = pl_entity($k);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $new = in_array($_POST['value'] ?? '', ['new', 'replied', 'closed'], true) ? $_POST['value'] : 'new';
    $qOld = rows('SELECT * FROM enquiries WHERE id=? AND entity=?', [(int)($_POST['id'] ?? 0), $E['table']])[0] ?? null;
    db()->prepare('UPDATE enquiries SET status=? WHERE id=? AND entity=?')->execute([$new, (int)($_POST['id'] ?? 0), $E['table']]);
    // tell the member who sent it (the request pages promise an alert when the admin replies)
    if ($qOld && $qOld['status'] !== $new && !empty($qOld['user_id']) && function_exists('pl_notify_user')) {
        $isTree = $qOld['kind'] === 'tree_request'; $ref = $isTree ? sprintf('PL-FT-%05d', $qOld['id']) : '#' . $qOld['id'];
        $txt = ['new' => 'is open again', 'replied' => 'is now under review', 'closed' => 'has been completed'][$new];
        pl_notify_user((int)$qOld['user_id'], $qOld['community_id'] ? (int)$qOld['community_id'] : null,
            ($isTree ? 'Family tree request ' : 'Your enquiry ') . ($new === 'closed' ? 'completed' : ($new === 'replied' ? 'under review' : 'reopened')),
            'Your ' . ($isTree ? 'family tree request ' : 'enquiry ') . $ref . ' ' . $txt . '.', $isTree ? 'family_tree' : 'enquiry', 'enquiries', (int)$qOld['id']);
    }
    flash('Enquiry marked as ' . $new);
    header('Location: ' . pl_ret('enquiries.php?e=' . $k)); exit;
}

$status = in_array($_GET['status'] ?? '', ['new', 'replied', 'closed'], true) ? $_GET['status'] : '';
$item = (int)($_GET['item'] ?? 0); $q = trim((string)($_GET['q'] ?? ''));
$w = 'q.entity=? AND (q.community_id=? OR q.community_id IS NULL)'; $a = [$E['table'], $cid];
if ($item) { $w .= ' AND q.entity_id=?'; $a[] = $item; }
if ($q !== '') { $w .= ' AND (q.name LIKE ? OR q.phone LIKE ? OR q.email LIKE ? OR q.message LIKE ?)'; array_push($a, "%$q%", "%$q%", "%$q%", "%$q%"); }
$counts = array_column(rows("SELECT q.status, COUNT(*) c FROM enquiries q WHERE $w GROUP BY q.status", $a), 'c', 'status');
if ($status) { $w .= ' AND q.status=?'; $a[] = $status; }
$page = max(1, (int)($_GET['page'] ?? 1));
$total = scalar("SELECT COUNT(*) FROM enquiries q WHERE $w", $a);
$list = rows("SELECT q.*, t.{$E['title']} item_title, u.name owner FROM enquiries q LEFT JOIN {$E['table']} t ON t.id=q.entity_id LEFT JOIN users u ON u.id=q.owner_user_id WHERE $w ORDER BY q.id DESC LIMIT 25 OFFSET " . (($page - 1) * 25), $a);
render_header(($k === 'event' ? 'Event registrations & enquiries' : $E['label'] . ' enquiries'), 'auto', $user, $comm); ?>
<div class="tabs anim"><?php foreach ($keys as $kk): ?><a class="<?= $kk === $k ? 'on' : '' ?>" href="?e=<?= e($kk) ?>"><?= e(pl_entity($kk)['plural']) ?></a><?php endforeach; ?></div>
<div class="tabs anim"><?php foreach (['' => 'All', 'new' => 'New', 'replied' => 'Replied', 'closed' => 'Closed'] as $s => $l): ?><a class="<?= $status === $s ? 'on' : '' ?>" href="<?= e(pl_url(['e' => $k, 'item' => $item ?: '', 'q' => $q, 'status' => $s], 'enquiries.php')) ?>"><?= $l ?> (<?= $s === '' ? array_sum($counts) : (int)($counts[$s] ?? 0) ?>)</a><?php endforeach; ?></div>
<div class="card anim">
  <form class="toolbar" method="get"><input type="hidden" name="e" value="<?= e($k) ?>"><?php if ($item): ?><input type="hidden" name="item" value="<?= $item ?>"><?php endif; ?><input class="grow" name="q" value="<?= e($q) ?>" placeholder="Search name, phone, email or message"><button class="btn btn-primary"><?= icon('fa-magnifying-glass') ?> Search</button></form>
  <?php if (!$list): ?><div class="empty"><?= icon('fa-inbox', 'big') ?>No enquiries.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>From</th><th><?= e($E['label']) ?></th><th>Owner</th><th>Type</th><th>Message</th><th>Date</th><th>Status</th></tr></thead><tbody>
  <?php foreach ($list as $r): ?><tr>
    <td data-label="From"><b><?= e($r['name']) ?></b><br><small><?= e($r['phone']) ?> <?= e($r['email']) ?></small></td>
    <td data-label="<?= e($E['label']) ?>"><a class="lnk" href="manage.php?e=<?= e($k) ?>&view=<?= (int)$r['entity_id'] ?>"><?= e($r['item_title'] ?? '#' . $r['entity_id']) ?></a></td>
    <td data-label="Owner"><?= e($r['owner'] ?? '—') ?></td><td data-label="Type"><?= e(ucfirst($r['kind'])) ?></td>
    <td data-label="Message"><?= nl2br(e(mb_strimwidth((string)$r['message'], 0, 220, '…'))) ?></td><td data-label="Date"><?= dshort($r['created_at']) ?></td>
    <td data-label="Status"><form class="inline" method="post"><?= pl_csrf_field() ?><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><input type="hidden" name="ret" value="<?= e(pl_here()) ?>">
      <select name="value" class="sel-sm" onchange="this.form.submit()"><?php foreach (['new', 'replied', 'closed'] as $s): ?><option value="<?= $s ?>" <?= $r['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option><?php endforeach; ?></select></form></td></tr>
  <?php endforeach; ?></tbody></table></div><?= pl_pager($page, (int)ceil($total / 25)) ?><?php endif; ?>
</div>
<?php render_footer();
