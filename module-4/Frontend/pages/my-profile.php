<?php
require __DIR__ . '/../components/init.php';
mat_need_profile();
$pageTitle = 'My profile'; $active = 'me'; $scripts = ['my-profile.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap">
  <div class="mat-head"><div><span class="mat-eyebrow">My matrimony dashboard</span><h1>Hello, <?= e($me['full_name']) ?></h1><p>Profile <?= e($me['profile_code']) ?> · <span class="mat-tag <?= e($me['status']) ?>"><?= e($me['status']) ?></span></p></div>
    <div class="mat-actions"><a class="mat-btn" href="profile.php?id=<?= (int)$me['id'] ?>"><i class="fa-solid fa-eye"></i> View as others see it</a></div></div>

  <div class="mat-stats" id="stats">
    <?php foreach ([['interests.php#received', 'fa-heart', 'interests_received_pending', 'New interests'], ['interests.php#sent', 'fa-paper-plane', 'interests_sent', 'Interests sent'], ['contacts.php#received', 'fa-address-book', 'contact_requests_pending', 'Contact requests'], ['visitors.php', 'fa-eye', 'visitors_30d', 'Visitors (30 days)']] as [$h, $i, $k, $l]): ?>
      <a class="mat-stat" href="<?= $h ?>"><i class="fa-solid <?= $i ?>"></i><b data-k="<?= $k ?>">–</b><span><?= $l ?></span></a>
    <?php endforeach; ?>
  </div>

  <div class="mat-grid2 r" style="margin-top:20px">
    <div>
      <div class="mat-panel"><h2><i class="fa-solid fa-list-check"></i> Profile completion</h2>
        <div class="mat-progress"><i id="compBar" style="width:0"></i></div><p><b id="compPct">–</b> complete</p><div id="compMissing"></div></div>
      <div class="mat-panel"><h2><i class="fa-solid fa-gear"></i> Manage</h2>
        <div class="mat-links">
          <a href="profile-form.php"><i class="fa-solid fa-pen"></i> Edit profile</a>
          <a href="photos.php"><i class="fa-solid fa-images"></i> Photos</a>
          <a href="preferences.php"><i class="fa-solid fa-heart-circle-check"></i> Partner preferences</a>
          <a href="privacy.php"><i class="fa-solid fa-user-shield"></i> Privacy & blocked</a>
          <a href="saved.php"><i class="fa-solid fa-bookmark"></i> Saved profiles</a>
          <a href="packages.php"><i class="fa-solid fa-crown"></i> Packages & payments</a>
          <a href="notifications.php"><i class="fa-solid fa-bell"></i> Notifications</a>
          <a href="support.php"><i class="fa-solid fa-headset"></i> Help & support</a>
        </div></div>
    </div>
    <aside>
      <div class="mat-panel"><h2><i class="fa-solid fa-crown"></i> My package</h2><div id="pkgBox">Loading…</div></div>
      <div class="mat-panel"><h2><i class="fa-solid fa-eye-slash"></i> Profile visibility</h2>
        <p class="mat-hint">Hide your profile from search for a while without deleting it.</p>
        <button class="mat-btn ghost block" id="toggleActive" data-active="<?= (int)$me['is_active'] ?>"><?= $me['is_active'] ? 'Hide my profile' : 'Show my profile again' ?></button></div>
    </aside>
  </div>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
