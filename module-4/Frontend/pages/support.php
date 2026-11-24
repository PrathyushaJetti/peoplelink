<?php
require __DIR__ . '/../components/init.php';
mat_need_login();
$pageTitle = 'Help & support'; $active = 'support';
$supTopic = ($_GET['topic'] ?? '') === 'community' ? 'Community change' : ''; $scripts = ['support.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap">
  <div class="mat-head"><div><span class="mat-eyebrow">Help desk</span><h1>Help & support</h1><p>Tell us about a problem with your account, community, profile, photos, payments or another member.</p></div></div>
  <div class="mat-grid2 r">
    <form class="mat-panel" id="supForm" novalidate>
      <h2><i class="fa-solid fa-headset"></i> New request</h2>
      <div class="mat-form">
        <div class="mat-f"><label for="sc">Category <span class="req">*</span></label><select id="sc" name="support_category" required data-msg="Choose a category.">
          <option value="">Choose…</option><?php foreach (['Profile approval', 'Photo approval', 'Edit profile details', 'Package / payment', 'Contact request', 'Report a member', 'Account / login', 'Community change', 'Technical issue', 'Other'] as $o): ?><option<?= $o === $supTopic ? ' selected' : '' ?>><?= $o ?></option><?php endforeach; ?></select></div>
        <div class="mat-f"><label for="st">Subject <span class="req">*</span></label><input id="st" name="request_title" required maxlength="200" data-msg="Enter a subject." value="<?= $supTopic ? 'Request to change my community details' : '' ?>"></div>
        <div class="mat-f"><label for="sn">Your name</label><input id="sn" name="contact_name" maxlength="120" value="<?= e($user['name']) ?>"></div>
        <div class="mat-f"><label for="sp">Mobile</label><input id="sp" name="phone" type="tel" pattern="[6-9][0-9]{9}" maxlength="10" value="<?= e(preg_replace('/\D/', '', (string)$user['phone'])) ?>" data-msg="Enter a 10-digit mobile number."></div>
        <div class="mat-f full"><label for="sd">Describe the issue <span class="req">*</span></label><textarea id="sd" name="description" required minlength="15" maxlength="3000" data-msg="Please describe the issue (at least 15 characters)."></textarea></div>
      </div>
      <input type="hidden" name="email" value="<?= e($user['email']) ?>"><input type="hidden" name="assistance_type" value="matrimony">
      <div class="mat-actions"><button class="mat-btn" type="submit" data-busy="Submitting"><i class="fa-solid fa-paper-plane"></i> Submit request</button></div>
    </form>
    <aside class="mat-panel"><h2><i class="fa-solid fa-ticket"></i> My requests</h2><div id="tickets">Loading…</div></aside>
  </div>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
