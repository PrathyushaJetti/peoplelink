<?php
$GLOBALS['ROOT'] = '../';
require_once __DIR__ . '/../includes/auth.php'; require_once __DIR__ . '/../includes/layout.php';
[$user, $comm] = require_login(); $cid = $comm['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); $t = trim($_POST['title'] ?? ''); $m = trim($_POST['message'] ?? '');
    $type = in_array($_POST['type'] ?? '', ['general', 'expiry', 'approval'], true) ? $_POST['type'] : 'general';
    $aud = in_array($_POST['audience'] ?? '', ['all', 'approved', 'pending'], true) ? $_POST['audience'] : 'all';
    if ($t === '' || $m === '') flash('Title and message are required.', 'error');
    else { notify($cid, $t, $m, $type, $aud); flash('Notification saved and queued'); }
    back();
}
$list = rows('SELECT * FROM matrimony_notifications WHERE community_id=? ORDER BY id DESC LIMIT 30', [$cid]);
$tpl = [[icon('fa-bullhorn') . ' General', ['title' => 'New feature on PeopleLink', 'message' => 'We have added new features to help you find your match. Open the app to explore.', 'type' => 'general']],
        [icon('fa-clock') . ' Package expiry reminder', ['title' => 'Your package expires soon', 'message' => 'Your matrimony package will expire in 3 days. Renew now to keep contacting matches.', 'type' => 'expiry']],
        [icon('fa-circle-check') . ' Profile approval update', ['title' => 'Profile review update', 'message' => 'Your matrimony profile has been reviewed. Open the app to see the result.', 'type' => 'approval']]];
$icon = ['general' => 'fa-bullhorn', 'expiry' => 'fa-clock', 'approval' => 'fa-circle-check', 'warning' => 'fa-triangle-exclamation'];
render_header('Notifications', 'Matrimony/Notifications', $user, $comm); ?>
<div class="grid2 anim">
  <div class="card"><div class="card-h"><h3>Send a notification</h3></div>
    <div class="tpl"><?php foreach ($tpl as [$l, $d]): ?><button type="button" class="btn btn-sm btn-line" data-tpl="<?= e(json_encode($d)) ?>"><?= $l ?></button><?php endforeach; ?></div>
    <form method="post"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
      <label>Title</label><input name="title" required maxlength="120">
      <label>Message</label><textarea name="message" required></textarea>
      <div class="row2"><div><label>Type</label><select name="type"><option value="general">General</option><option value="expiry">Package expiry</option><option value="approval">Profile approval</option></select></div>
      <div><label>Send to</label><select name="audience"><option value="all">All members</option><option value="approved">Approved profiles</option><option value="pending">Pending profiles</option></select></div></div>
      <button class="btn btn-primary btn-block">Send notification</button></form></div>
  <div class="card"><div class="card-h"><h3>Recent</h3></div>
    <?php if (!$list): ?><div class="empty"><?= icon('fa-bell-slash','big') ?>Nothing sent yet.</div><?php else: foreach ($list as $n): ?>
      <div class="note"><div class="note-i"><?= icon($icon[$n['type']] ?? 'fa-bell') ?></div>
        <div class="note-b"><b><?= e($n['title']) ?></b><div><?= e($n['message']) ?></div><small class="muted"><?= dshort($n['created_at']) ?> · <?= e(str_starts_with($n['audience'], 'profile:') ? 'single profile' : $n['audience']) ?></small></div></div>
    <?php endforeach; endif; ?></div>
</div>
<?php render_footer();
