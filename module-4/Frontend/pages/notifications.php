<?php
require __DIR__ . '/../components/init.php';
mat_need_login();
$pageTitle = 'Notifications'; $active = 'notifications'; $scripts = ['notifications.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap">
  <div class="mat-head"><div><span class="mat-eyebrow">Alerts</span><h1>Notifications</h1><p>Interests, contact requests, approvals and package updates.</p></div>
    <button class="mat-btn ghost" id="readAll"><i class="fa-solid fa-check-double"></i> Mark all as read</button></div>
  <div class="mat-rows" id="noteList"></div>
  <div class="mat-pager" id="pager"></div>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
