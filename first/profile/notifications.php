<?php
// Member notifications on the website: own alerts + community announcements, filter tabs, mark read.
require_once __DIR__ . '/_account.php';
require_once dirname(__DIR__, 2) . '/matrimoney/includes/notifications.php';
$pageTitle = 'Notifications';
$nfFlash = $_SESSION['nf_flash'] ?? null; unset($_SESSION['nf_flash']);

/* open = mark read, then go to the related page */
if (isset($_GET['open'])) {
    $id = (int)$_GET['open'];
    pl_notif_mark_read($acUid, $id);
    $n = rows('SELECT * FROM user_notifications WHERE id=?', [$id])[0] ?? null;
    $to = $n ? pl_notif_link($n) : null;
    header('Location: ' . ($to ?: 'notifications.php')); exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) {
    if (($_POST['op'] ?? '') === 'all') { pl_notif_mark_read($acUid); $_SESSION['nf_flash'] = 'All notifications marked as read.'; }
    elseif (($id = (int)($_POST['id'] ?? 0))) pl_notif_mark_read($acUid, $id);
    header('Location: notifications.php?' . http_build_query(array_filter(['cat' => $_POST['cat'] ?? '', 'unread' => $_POST['unread'] ?? '', 'page' => $_POST['page'] ?? '']))); exit;
}

$nfCats = pl_notif_categories();
$nfCat = isset($nfCats[$_GET['cat'] ?? '']) ? (string)($_GET['cat'] ?? '') : '';
$nfUnreadOnly = !empty($_GET['unread']);
$nfPage = max(1, (int)($_GET['page'] ?? 1)); $nfPer = 15;
$nfData = pl_notif_list($acUid, $nfCat, $nfPage, $nfPer, $nfUnreadOnly);
$nfUnread = pl_notif_unread($acUid);
$nfPages = max(1, (int)ceil($nfData['total'] / $nfPer));
$nfUrl = fn(array $q) => 'notifications.php?' . http_build_query(array_filter($q + ['cat' => $nfCat, 'unread' => $nfUnreadOnly ? 1 : ''], fn($v) => $v !== '' && $v !== null && $v !== 0));
include __DIR__ . '/header.php';
?>
<main class="pl-settings-page">
  <div class="pl-settings-container" style="max-width:860px">
    <a href="my-profile.php" class="pl-cp-back"><i class="bi bi-arrow-left"></i> Back to My Profile</a>
    <section class="pl-settings-card" style="margin-top:16px">
      <div class="pl-nf-top">
        <div class="pl-section-heading pl-cp-head">
          <div class="pl-section-icon blue"><i class="bi bi-bell-fill"></i></div>
          <div><h2>Notifications</h2><p><?= $nfUnread ? '<b>' . $nfUnread . '</b> unread · ' : 'All caught up · ' ?>approvals, family tree, matrimony, jobs, payments and community announcements.</p></div>
        </div>
        <?php if ($nfUnread): ?>
          <form method="post" action="notifications.php"><input type="hidden" name="csrf" value="<?= ac_e(csrf_token()) ?>"><input type="hidden" name="op" value="all">
            <button type="submit" class="pl-nf-btn"><i class="bi bi-check2-all"></i> Mark all as read</button></form>
        <?php endif; ?>
      </div>
      <?php if ($nfFlash): ?><div class="pl-as-alert ok" role="status"><i class="bi bi-check-circle"></i> <?= ac_e($nfFlash) ?></div><?php endif; ?>

      <nav class="pl-nf-tabs" aria-label="Filter notifications">
        <?php foreach ($nfCats as $k => $c): ?>
          <a href="<?= ac_e('notifications.php?' . http_build_query(array_filter(['cat' => $k, 'unread' => $nfUnreadOnly ? 1 : '']))) ?>" class="<?= $nfCat === $k ? 'on' : '' ?>"><?= ac_e($c['label']) ?></a>
        <?php endforeach; ?>
        <a href="<?= ac_e('notifications.php?' . http_build_query(array_filter(['cat' => $nfCat, 'unread' => $nfUnreadOnly ? '' : 1]))) ?>" class="pl-nf-only <?= $nfUnreadOnly ? 'on' : '' ?>"><i class="bi bi-<?= $nfUnreadOnly ? 'check-square-fill' : 'square' ?>"></i> Unread only</a>
      </nav>

      <div class="pl-nf-list">
        <?php foreach ($nfData['items'] as $n): $read = $n['is_read_now']; ?>
          <div class="pl-nf-row <?= $read ? '' : 'unread' ?>">
            <div class="pl-nf-ic <?= $n['user_id'] === null ? 'ann' : '' ?>"><i class="bi <?= ac_e($n['icon']) ?>"></i></div>
            <a class="pl-nf-body" href="notifications.php?open=<?= (int)$n['id'] ?>">
              <strong><?= ac_e($n['title']) ?><?= $n['user_id'] === null ? ' <span class="pl-nf-tag">Announcement</span>' : '' ?></strong>
              <?php if (trim((string)$n['message']) !== ''): ?><span class="pl-nf-msg"><?= nl2br(ac_e($n['message'])) ?></span><?php endif; ?>
              <small><?= ac_e(pl_notif_ago($n['created_at'])) ?><?= $n['link'] ? ' · <span class="pl-nf-go">Open <i class="bi bi-arrow-right"></i></span>' : '' ?></small>
            </a>
            <?php if (!$read): ?>
              <form method="post" action="notifications.php"><input type="hidden" name="csrf" value="<?= ac_e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int)$n['id'] ?>">
                <input type="hidden" name="cat" value="<?= ac_e($nfCat) ?>"><input type="hidden" name="unread" value="<?= $nfUnreadOnly ? 1 : '' ?>"><input type="hidden" name="page" value="<?= $nfPage > 1 ? $nfPage : '' ?>">
                <button type="submit" class="pl-nf-mark" title="Mark as read" aria-label="Mark as read"><span class="pl-nf-dot"></span></button></form>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
        <?php if (!$nfData['items']): ?>
          <div class="pl-nf-empty"><i class="bi bi-bell-slash"></i><strong><?= $nfUnreadOnly ? 'No unread notifications' : 'No notifications yet' ?></strong><span>Approvals, replies and community announcements will appear here.</span></div>
        <?php endif; ?>
      </div>

      <?php if ($nfPages > 1): ?>
        <div class="pl-nf-pager">
          <?php if ($nfPage > 1): ?><a href="<?= ac_e($nfUrl(['page' => $nfPage - 1])) ?>"><i class="bi bi-chevron-left"></i> Newer</a><?php endif; ?>
          <span>Page <?= $nfPage ?> of <?= $nfPages ?></span>
          <?php if ($nfPage < $nfPages): ?><a href="<?= ac_e($nfUrl(['page' => $nfPage + 1])) ?>">Older <i class="bi bi-chevron-right"></i></a><?php endif; ?>
        </div>
      <?php endif; ?>
    </section>
  </div>
</main>
<style>
.pl-cp-back{display:inline-flex;align-items:center;gap:8px;color:#1261a8;font-weight:600;text-decoration:none}.pl-cp-back:hover{text-decoration:underline}
.pl-cp-head{display:flex !important;align-items:center;gap:14px;text-align:left !important;justify-content:flex-start !important}.pl-cp-head>div:last-child{text-align:left}
.pl-as-alert{border-radius:12px;padding:14px 18px;margin:0 0 10px;font-weight:600}.pl-as-alert.ok{background:#e9f8ee;color:#17663a;border:1px solid #b9e6c8}
.pl-nf-top{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap}
.pl-nf-btn{display:inline-flex;align-items:center;gap:7px;border:1px solid #cfd9e6;background:#fff;color:#0b2a4a;border-radius:10px;padding:9px 14px;font-weight:600;cursor:pointer}
.pl-nf-btn:hover{background:#f3f7fc}
.pl-nf-tabs{display:flex;gap:8px;flex-wrap:wrap;margin:16px 0 14px}
.pl-nf-tabs a{border:1px solid #dde4ee;border-radius:30px;padding:7px 14px;color:#42546a;text-decoration:none;font-size:14px;font-weight:600;background:#fff}
.pl-nf-tabs a.on{background:#1261a8;border-color:#1261a8;color:#fff}
.pl-nf-tabs .pl-nf-only{margin-left:auto}.pl-nf-tabs .pl-nf-only.on{background:#e8f1fb;color:#1261a8;border-color:#b8d2ee}
.pl-nf-list{display:grid;gap:10px}
.pl-nf-row{display:flex;align-items:flex-start;gap:14px;border:1px solid #e4e8ee;border-radius:14px;padding:14px 16px;background:#fff}
.pl-nf-row.unread{background:#f3f8ff;border-color:#c9dcf3}
.pl-nf-ic{flex:0 0 42px;height:42px;border-radius:12px;display:grid;place-items:center;background:#e8f1fb;color:#1261a8;font-size:18px}
.pl-nf-ic.ann{background:#fff3e0;color:#d9822b}
.pl-nf-body{flex:1;min-width:0;display:grid;gap:4px;color:inherit;text-decoration:none}
.pl-nf-body strong{color:#0b2a4a;font-size:15.5px}.pl-nf-row.unread .pl-nf-body strong{font-weight:800}
.pl-nf-msg{color:#475569;font-size:14px;line-height:1.5;overflow-wrap:anywhere}
.pl-nf-body small{color:#7b8797;font-size:12.5px}.pl-nf-go{color:#1261a8;font-weight:600}
.pl-nf-body:hover strong{color:#1261a8}
.pl-nf-tag{display:inline-block;background:#fff3e0;color:#b4630f;border-radius:20px;padding:1px 9px;font-size:11.5px;font-weight:700;margin-left:6px;vertical-align:2px}
.pl-nf-mark{border:0;background:transparent;padding:8px;cursor:pointer;border-radius:50%}.pl-nf-mark:hover{background:#e2ecf8}
.pl-nf-dot{display:block;width:11px;height:11px;border-radius:50%;background:#1261a8}
.pl-nf-empty{display:grid;justify-items:center;gap:6px;padding:40px 10px;text-align:center;color:#667085}.pl-nf-empty i{font-size:34px;color:#9fb3c8}.pl-nf-empty strong{color:#0b2a4a}
.pl-nf-pager{display:flex;align-items:center;justify-content:center;gap:16px;margin-top:16px;color:#667085}.pl-nf-pager a{color:#1261a8;font-weight:600;text-decoration:none}
@media (max-width:600px){.pl-nf-tabs .pl-nf-only{margin-left:0}.pl-nf-row{padding:12px}.pl-nf-ic{flex-basis:36px;height:36px;font-size:16px}}
</style>
<?php include __DIR__ . '/footer.php'; ?>
