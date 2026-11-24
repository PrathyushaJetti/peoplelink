<?php
// Main admin dashboard for the selected community: totals + everything waiting for approval.
require __DIR__ . '/_boot.php';

$users = scalar('SELECT COUNT(*) FROM users WHERE community_id=?', [$cid]);
$revenue = scalar("SELECT COALESCE(SUM(amount),0) FROM transactions WHERE status='paid' AND community_id=?", [$cid])
    + scalar("SELECT COALESCE(SUM(amount),0) FROM matrimony_payments WHERE status='paid' AND community_id=?", [$cid]);
$queue = [['Matrimony profiles', scalar("SELECT COUNT(*) FROM matrimony_profiles WHERE community_id=? AND status='pending'", [$cid]), '../matrimony/profiles.php?status=pending', 'fa-heart']];
foreach (['member' => 'members', 'family_member' => 'family members', 'family_tree' => 'family trees', 'tree_relation' => 'family tree relations', 'mp_listing' => 'marketplace listings',
    'directory' => 'directory profiles', 'job' => 'jobs', 'event' => 'events', 'ad' => 'advertisements', 'support' => 'support requests'] as $k => $l) {
    $E = pl_entity($k);
    $queue[] = [ucfirst($l), pl_count($k, $cid, "t.{$E['status_col']}='pending'"), "manage.php?e=$k&status=pending", $E['icon']];
}
$queue[] = ['Reported content', scalar("SELECT COUNT(*) FROM content_reports WHERE status='open' AND (community_id=? OR community_id IS NULL)", [$cid]), 'reports.php?tab=reported', 'fa-flag'];
$queue[] = ['Account delete requests', scalar("SELECT COUNT(*) FROM users WHERE delete_requested_at IS NOT NULL AND status<>'deleted' AND community_id=?", [$cid]), 'users.php?status=delete_requests', 'fa-user-xmark'];
$waiting = array_sum(array_column($queue, 1));
$log = rows('SELECT a.*, u.name uname FROM audit_log a LEFT JOIN users u ON u.id=a.user_id WHERE a.community_id=? OR a.community_id IS NULL ORDER BY a.id DESC LIMIT 8', [$cid]);

render_header('Dashboard', 'auto', $user, $comm);
echo pl_stat_cards([
    ['Users in community', $users, 'fa-users'],
    ['Waiting for approval', $waiting, 'fa-hourglass-half'],
    ['Upcoming events', pl_count('event', $cid, "t.status='approved' AND t.event_date>=CURDATE()"), 'fa-calendar-check'],
    ['Revenue (paid)', [$revenue, '₹'], 'fa-indian-rupee-sign'],
]);
echo pl_stat_cards([
    ['Members', pl_count('member', $cid), 'fa-id-card'],
    ['Active listings', pl_count('mp_listing', $cid, "t.status='approved' AND t.is_active=1"), 'fa-store'],
    ['Directory profiles', pl_count('directory', $cid, "t.status='approved'"), 'fa-address-book'],
    ['Open support requests', pl_count('support', $cid, "t.status IN ('pending','approved','in_progress')"), 'fa-hand-holding-heart'],
]); ?>
<div class="grid2 anim">
  <div class="card"><div class="card-h"><h3>Approval queue</h3></div>
    <div class="tw"><table class="rt"><thead><tr><th>Module</th><th>Pending</th><th></th></tr></thead><tbody>
    <?php foreach ($queue as [$l, $n, $href, $ic]): ?><tr><td data-label="Module"><?= icon($ic) ?> <?= e($l) ?></td><td data-label="Pending"><?= $n ? '<span class="badge b-pending">' . (int)$n . '</span>' : '<span class="muted">0</span>' ?></td>
      <td><a class="btn btn-sm btn-line" href="<?= e($href) ?>">Open <?= icon('fa-arrow-right') ?></a></td></tr><?php endforeach; ?></tbody></table></div></div>
  <div class="card"><div class="card-h"><h3>Recent admin activity</h3><a class="btn btn-line btn-sm" href="audit-log.php">Audit log</a></div>
    <?php if (!$log): ?><div class="empty"><?= icon('fa-clock-rotate-left', 'big') ?>No activity yet.</div><?php else: foreach ($log as $l): $LE = $l['entity'] ? pl_entity($l['entity']) : null; ?>
      <div class="note"><div class="note-i"><?= icon($LE['icon'] ?? 'fa-clock-rotate-left') ?></div><div class="note-b"><b><?= e(pl_status_label(str_replace(':', ' → ', $l['action']))) ?> <?= $LE ? '· ' . e($LE['label']) . ' #' . (int)$l['entity_id'] : '' ?></b>
        <div><?= e($l['uname'] ?? 'System') ?><?= $l['details'] && $l['details'][0] !== '[' ? ' — ' . e(mb_strimwidth($l['details'], 0, 80, '…')) : '' ?></div><small class="muted"><?= e(date('d M Y, H:i', strtotime($l['created_at']))) ?></small></div></div>
    <?php endforeach; endif; ?></div>
</div>
<?php render_footer();
