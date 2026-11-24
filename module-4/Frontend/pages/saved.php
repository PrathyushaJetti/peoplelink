<?php
require __DIR__ . '/../components/init.php';
mat_need_profile();
$pageTitle = 'Saved profiles'; $active = 'saved'; $scripts = ['lists.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap" id="listPage" data-kind="saved">
  <div class="mat-head"><div><span class="mat-eyebrow">Shortlist</span><h1>Saved profiles</h1><p>Profiles you saved to look at later.</p></div></div>
  <div class="mat-cards" id="listBox"></div>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
