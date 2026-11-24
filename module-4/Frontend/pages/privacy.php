<?php
require __DIR__ . '/../components/init.php';
mat_need_profile();
$pv = pl_mat_privacy($me);
$chk = fn($k) => !empty($pv[$k]) ? ' checked' : '';
$pageTitle = 'Privacy settings'; $active = 'me'; $scripts = ['privacy.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap">
  <div class="mat-head"><div><span class="mat-eyebrow">Privacy</span><h1>Privacy settings</h1><p>Control who sees your profile, photos and contact details.</p></div></div>
  <div class="mat-grid2 r">
    <form class="mat-panel" id="privForm" novalidate>
      <h2><i class="fa-solid fa-eye"></i> Visibility</h2>
      <div class="mat-form">
        <div class="mat-f"><label for="pv">Profile visibility</label><select id="pv" name="profile_visibility">
          <option value="visible"<?= $pv['profileVisibility'] === 'visible' ? ' selected' : '' ?>>Visible to my community</option>
          <option value="hidden"<?= $pv['profileVisibility'] !== 'visible' ? ' selected' : '' ?>>Hidden from search</option></select></div>
        <div class="mat-f"><label for="pp">Who can see my photos</label><select id="pp" name="photo_privacy">
          <?php foreach (['eligible' => 'All members who can see my profile', 'interest' => 'Only members with an interest between us', 'contact' => 'Only after interest is accepted', 'private' => 'Nobody (photos hidden)'] as $k => $l): ?>
          <option value="<?= $k ?>"<?= $pv['photoPrivacy'] === $k ? ' selected' : '' ?>><?= $l ?></option><?php endforeach; ?></select></div>
      </div>
      <h2 style="margin-top:18px"><i class="fa-solid fa-handshake"></i> Connections</h2>
      <label class="mat-check"><input type="checkbox" name="receive_interests" value="1"<?= $chk('receiveInterests') ?>><span><b>Receive new interests</b><small>Turn off to stop new interests for now.</small></span></label>
      <label class="mat-check"><input type="checkbox" name="allow_contact_requests" value="1"<?= $chk('allowContactRequests') ?>><span><b>Allow contact requests</b><small>Members with a package can ask for your contact details.</small></span></label>
      <label class="mat-check"><input type="checkbox" name="profile_recommendations" value="1"<?= $chk('profileRecommendations') ?>><span><b>Show me in recommendations</b></span></label>
      <h2 style="margin-top:18px"><i class="fa-solid fa-bell"></i> Push notifications</h2>
      <label class="mat-check"><input type="checkbox" name="notify_interests" value="1"<?= $chk('notifyInterests') ?>><span><b>Interests</b></span></label>
      <label class="mat-check"><input type="checkbox" name="notify_contacts" value="1"<?= $chk('notifyContacts') ?>><span><b>Contact requests</b></span></label>
      <label class="mat-check"><input type="checkbox" name="notify_packages" value="1"<?= $chk('notifyPackages') ?>><span><b>Package & payment</b></span></label>
      <label class="mat-check"><input type="checkbox" name="notify_profile" value="1"<?= $chk('notifyProfile') ?>><span><b>Profile approval</b></span></label>
      <div class="mat-actions"><button class="mat-btn" type="submit" data-busy="Saving"><i class="fa-solid fa-floppy-disk"></i> Save settings</button></div>
    </form>
    <aside class="mat-panel"><h2><i class="fa-solid fa-ban"></i> Blocked profiles</h2><div id="blocked">Loading…</div></aside>
  </div>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
