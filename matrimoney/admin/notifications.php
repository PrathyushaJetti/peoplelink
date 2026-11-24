<?php
// Common notifications: in-app list + FCM push to the app (SMS stays for major account / support changes only).
require __DIR__ . '/_boot.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $t = mb_substr(trim((string)($_POST['title'] ?? '')), 0, 160); $m = trim((string)($_POST['message'] ?? ''));
    $aud = (string)($_POST['audience'] ?? 'community');
    $type = in_array($_POST['type'] ?? '', ['general', 'event', 'support', 'payment', 'approval'], true) ? $_POST['type'] : 'general';
    if ($t === '' || $m === '') { flash('Title and message are required.', 'error'); header('Location: notifications.php'); exit; }
    if ($aud === 'user') {
        $u = rows('SELECT id, community_id FROM users WHERE email=? OR id=?', [trim((string)($_POST['user'] ?? '')), (int)($_POST['user'] ?? 0)])[0] ?? null;
        if (!$u) { flash('User not found (enter email or user ID).', 'error'); header('Location: notifications.php'); exit; }
        pl_notify_user((int)$u['id'], $u['community_id'] ? (int)$u['community_id'] : null, $t, $m, $type);
        flash('Notification sent to the user');
    } else {
        $cidN = $aud === 'all' ? null : $cid;
        db()->prepare('INSERT INTO user_notifications (user_id, community_id, title, message, type, created_by) VALUES (NULL,?,?,?,?,?)')->execute([$cidN, $t, $m, $type, (int)$user['id']]);
        $nid = (int)db()->lastInsertId();
        $uids = array_column(rows("SELECT id FROM users WHERE COALESCE(status,'active')='active'" . ($cidN ? ' AND community_id=?' : ''), $cidN ? [$cidN] : []), 'id');
        $sent = pl_push_users($uids, $t, $m, ['type' => $type]);
        db()->prepare('UPDATE user_notifications SET pushed=? WHERE id=?')->execute([$sent, $nid]);
        pl_audit('notification', null, $nid, $t, $cidN);
        flash('Notification sent to ' . ($cidN ? $comm['name'] . ' members' : 'all communities') . ' — it shows on their website bell and in the app' . (FCM_SERVICE_ACCOUNT_FILE !== '' ? " (phone push: $sent device(s))" : '') . '.');
    }
    header('Location: notifications.php'); exit;
}
require_once __DIR__ . '/../includes/notifications.php'; pl_notif_tables();
$list = rows('SELECT n.*, u.name uname, (SELECT COUNT(*) FROM notification_reads r WHERE r.notification_id=n.id) reads_n FROM user_notifications n LEFT JOIN users u ON u.id=n.user_id WHERE n.community_id=? OR n.community_id IS NULL ORDER BY n.id DESC LIMIT 40', [$cid]);
$memberCount = (int)scalar("SELECT COUNT(*) FROM users WHERE COALESCE(status,'active')='active' AND role='member' AND community_id=?", [$cid]);
render_header('Notifications', 'auto', $user, $comm); ?>
<div class="grid2 anim">
  <div class="card"><div class="card-h"><h3>Send a notification</h3></div>
    <?php if (FCM_SERVICE_ACCOUNT_FILE === ''): ?><div class="alert info" style="background:#eef5fc;color:#1d4e7e;border:1px solid #cfe0f2">Phone push alerts are not set up yet (FCM key in config.php). Notifications still appear on the website bell and in the app's notification list.</div><?php endif; ?>
    <form method="post"><?= pl_csrf_field() ?>
      <label>Title</label><input name="title" required maxlength="160">
      <label>Message</label><textarea name="message" required></textarea>
      <div class="row2"><div><label>Type</label><select name="type"><option value="general">General</option><option value="event">Event</option><option value="support">Support</option><option value="payment">Payment</option><option value="approval">Approval</option></select></div>
        <div><label>Send to</label><select name="audience" id="aud"><option value="community">This community (<?= e($comm['name']) ?>)</option><option value="all">All communities</option><option value="user">One user</option></select></div></div>
      <label>User email or ID (only for "One user")</label><input name="user" placeholder="name@example.com">
      <button class="btn btn-primary btn-block mt">Send notification</button></form></div>
  <div class="card"><div class="card-h"><h3>Recent</h3></div>
    <?php if (!$list): ?><div class="empty"><?= icon('fa-bell-slash', 'big') ?>Nothing sent yet.</div><?php else: foreach ($list as $n): ?>
      <div class="note"><div class="note-i"><?= icon('fa-bell') ?></div><div class="note-b"><b><?= e($n['title']) ?></b><div><?= e(mb_strimwidth((string)$n['message'], 0, 160, '…')) ?></div>
        <small class="muted"><?= dshort($n['created_at']) ?> · <?= $n['user_id'] ? e($n['uname'] ?? 'user') : ($n['community_id'] ? 'community' : 'all communities') ?> · <?= e($n['type']) ?><?= $n['pushed'] ? ' · push ' . (int)$n['pushed'] : '' ?><?= $n['user_id'] ? ($n['is_read'] ? ' · read' : ' · unread') : ' · read by ' . (int)$n['reads_n'] . ($n['community_id'] ? ' of ' . $memberCount : '') . ' members' ?></small></div></div>
    <?php endforeach; endif; ?></div>
</div>
<?php render_footer();
