<?php
require __DIR__ . '/../components/init.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0 && !empty($_GET['code'])) $id = scalar('SELECT id FROM matrimony_profiles WHERE profile_code=?', [(string)$_GET['code']]);
if ($id <= 0) { header('Location: search.php'); exit; }
$pageTitle = 'Profile'; $active = 'search'; $scripts = ['profile.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap" id="profileRoot" data-id="<?= $id ?>">
  <p><a class="mat-back" href="javascript:history.length>1?history.back():location.href='search.php'"><i class="fa-solid fa-arrow-left"></i> Back</a></p>
  <div id="profileBox"><div class="mat-panel"><div class="mat-skel"><i></i><i></i><i></i></div></div></div>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
