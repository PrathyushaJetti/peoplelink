<?php
require __DIR__ . '/../components/init.php';
mat_need_profile();
$pageTitle = 'Profile visitors'; $active = 'me'; $scripts = ['lists.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap" id="listPage" data-kind="visitors">
  <div class="mat-head"><div><span class="mat-eyebrow">Who viewed me</span><h1>Profile visitors</h1><p>Approved members who opened your profile.</p></div></div>
  <div class="mat-cards" id="listBox"></div><div class="mat-pager" id="pager"></div>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
