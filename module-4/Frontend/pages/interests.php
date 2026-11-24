<?php
require __DIR__ . '/../components/init.php';
mat_need_profile();
$pageTitle = 'Interests'; $active = 'interests'; $scripts = ['lists.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap" id="listPage" data-kind="interests">
  <div class="mat-head"><div><span class="mat-eyebrow">Connections</span><h1>Interests</h1><p>Accept an interest to share contact details with each other.</p></div></div>
  <div class="mat-tabs" role="tablist"><button data-tab="received">Received <span class="n" id="nRecv">0</span></button><button data-tab="sent">Sent <span class="n" id="nSent">0</span></button><button data-tab="accepted">Accepted <span class="n" id="nAcc">0</span></button></div>
  <section data-pane="received"><div class="mat-rows"><div class="mat-row mat-skel"><i></i><i></i></div></div></section>
  <section data-pane="sent" hidden></section>
  <section data-pane="accepted" hidden></section>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
