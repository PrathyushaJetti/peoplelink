<?php
require __DIR__ . '/../components/init.php';
mat_need_profile();
$pageTitle = 'My photos'; $active = 'me'; $scripts = ['photos.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap">
  <div class="mat-head"><div><span class="mat-eyebrow"><?= isset($_GET['new']) ? 'Step 3 of 3' : 'Photos' ?></span><h1>Manage photos</h1><p>Up to <?= PL_MAX_PHOTOS ?> photos. New photos are checked by our team before others can see them.</p></div>
    <a class="mat-btn ghost" href="my-profile.php"><?= isset($_GET['new']) ? 'Finish' : 'Back to dashboard' ?></a></div>
  <div class="mat-panel">
    <label class="mat-drop" id="drop" for="photoInput">
      <i class="fa-solid fa-cloud-arrow-up"></i><p><b>Click or drop photos here</b><br><span class="mat-hint">JPG, PNG or WEBP · max 5 MB each</span></p>
      <input type="file" id="photoInput" accept="image/jpeg,image/png,image/webp" multiple hidden>
    </label>
    <p class="mat-hint" id="photoCount" style="margin-top:12px"></p>
    <div class="mat-photos" id="photoGrid" style="margin-top:12px"></div>
  </div>
  <div class="mat-panel"><h2><i class="fa-solid fa-user-shield"></i> Who can see my photos?</h2><p>Change this in <a href="privacy.php">Privacy settings</a>.</p></div>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
