<?php
require __DIR__ . '/../components/init.php';
$pageTitle = 'Matrimony'; $active = 'home'; $scripts = ['home.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap">
  <section class="mat-banner">
    <span class="mat-eyebrow" style="color:#ffd3e2"><?= e($comm['name'] ?? 'PeopleLink') ?> Matrimony</span>
    <h1>Find a life partner within your community</h1>
    <p>Verified profiles, photo privacy you control, and contact details shared only when both sides agree.</p>
    <form class="mat-quick" action="search.php" method="get" aria-label="Quick search">
      <select name="age" aria-label="Age"><option value="">Any age</option><option>21-25</option><option>26-30</option><option>31-35</option><option value="36+">36 and above</option></select>
      <select name="city" id="quickCity" aria-label="City"><option value="">Any city</option></select>
      <button class="mat-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
    </form>
    <div class="mat-actions">
      <?php if (!$user): ?>
        <a class="mat-btn" href="<?= e(DASHBOARD_URL) ?>signup.php?next=<?= urlencode(MAT_URL . 'profile-form.php') ?>">Register free</a>
        <a class="mat-btn ghost" href="<?= e(mat_login_url()) ?>">Login</a>
      <?php elseif (!$me): ?>
        <a class="mat-btn" href="profile-form.php"><i class="fa-solid fa-user-plus"></i> Create matrimony profile</a>
      <?php else: ?>
        <a class="mat-btn" href="my-profile.php"><i class="fa-solid fa-id-card"></i> My dashboard</a>
      <?php endif; ?>
    </div>
  </section>

  <?php if (!$cid): ?>
    <div class="mat-empty"><i class="fa-solid fa-people-group"></i><h3>Select your community</h3><p>Matrimony profiles are shown within your community.</p><a class="mat-btn" href="<?= $F ?>community-page.php?next=<?= urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/module-4/Frontend/pages/index.php') ?>">Choose community</a></div>
  <?php else: ?>
  <div class="mat-head"><div><span class="mat-eyebrow">Newest members</span><h2>Recently joined profiles</h2></div><a class="mat-btn ghost sm" href="search.php">See all profiles <i class="fa-solid fa-arrow-right"></i></a></div>
  <div class="mat-cards" id="homeCards"></div>
  <?php endif; ?>

  <div class="mat-steps">
    <div class="mat-step"><i class="fa-solid fa-user-pen"></i><h3>1. Create profile</h3><p>Add your details, family and partner preferences.</p></div>
    <div class="mat-step"><i class="fa-solid fa-shield-halved"></i><h3>2. Get approved</h3><p>Our team checks every profile and photo.</p></div>
    <div class="mat-step"><i class="fa-solid fa-heart"></i><h3>3. Send interest</h3><p>Show interest in profiles you like.</p></div>
    <div class="mat-step"><i class="fa-solid fa-phone"></i><h3>4. Connect</h3><p>Contacts are shared after an accepted interest or approved request.</p></div>
  </div>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
