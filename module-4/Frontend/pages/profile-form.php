<?php
require __DIR__ . '/../components/init.php';
mat_need_login();
if (!$cid) { header('Location: ' . $F . 'community-page.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/module-4/Frontend/pages/index.php')); exit; }
$edit = (bool)$me;
$d = $me ? pl_details($me) : [];
$v = function (string $k, ?string $col = null) use ($me, $d) {
    $val = $col && $me ? ($me[$col] ?? '') : '';
    if ($val === '' || $val === null) $val = $d[$k] ?? '';
    return e(is_array($val) ? implode(', ', $val) : $val);
};
$sel = function (string $name, array $opts, string $cur, string $placeholder = 'Select', bool $req = false) {
    $h = '<select id="f_' . $name . '" name="' . $name . '"' . ($req ? ' required data-msg="Please select an option."' : '') . '><option value="">' . e($placeholder) . '</option>';
    $found = false;
    foreach ($opts as $o) { $s = strcasecmp($o, $cur) === 0; $found = $found || $s; $h .= '<option' . ($s ? ' selected' : '') . '>' . e($o) . '</option>'; }
    if ($cur !== '' && !$found) $h .= '<option selected>' . e($cur) . '</option>';
    return $h . '</select>';
};
$heights = []; for ($i = 54; $i <= 84; $i++) $heights[] = intdiv($i, 12) . "' " . ($i % 12) . '"';
$dobMax = date('Y-m-d', strtotime('-' . MAT_MIN_AGE . ' years'));
$dobMin = date('Y-m-d', strtotime('-' . MAT_MAX_AGE . ' years'));
$pageTitle = $edit ? 'Edit profile' : 'Create profile'; $active = 'me'; $scripts = ['india-locations.js', 'profile-form.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap">
  <div class="mat-head"><div><span class="mat-eyebrow"><?= e($comm['name']) ?> matrimony</span><h1><?= $edit ? 'Edit your profile' : 'Create your matrimony profile' ?></h1>
    <p><?= $edit ? ($me['status'] === 'approved' ? 'Saving changes sends your profile for re-approval; it stays hidden until approved.' : 'Profile ' . e($me['profile_code']) . ' · status: ' . e($me['status'])) : 'Fields marked * are required. Your profile is checked by our team before it is shown.' ?></p></div></div>

  <form id="profileForm" class="mat-panel" novalidate data-mode="<?= $edit ? 'edit' : 'create' ?>">
    <div class="mat-form">
      <h3 class="mat-fs"><i class="fa-solid fa-user"></i> Basic details</h3>
      <div class="mat-f"><label for="f_full_name">Full name <span class="req">*</span></label><input id="f_full_name" name="full_name" required maxlength="120" value="<?= $v('full_name', 'full_name') ?>" data-msg="Please enter the full name."></div>
      <div class="mat-f"><label for="f_gender">Gender <span class="req">*</span></label>
        <?php if ($edit): ?><input id="f_gender" value="<?= e($me['gender']) ?>" disabled><span class="mat-hint">Contact support to change gender.</span>
        <?php else: ?><?= $sel('gender', ['Female', 'Male'], '', 'Select', true) ?><?php endif; ?></div>
      <div class="mat-f"><label for="f_dob">Date of birth <span class="req">*</span></label><input id="f_dob" type="date" name="date_of_birth" <?= $edit ? '' : 'required' ?> min="<?= $dobMin ?>" max="<?= $dobMax ?>" value="<?= e($me['dob'] ?? '') ?>" data-msg="Enter a valid date of birth (you must be <?= MAT_MIN_AGE ?>+)."><span class="mat-hint">Age is calculated from this. Minimum age <?= MAT_MIN_AGE ?>.</span></div>
      <div class="mat-f"><label for="f_height">Height</label><?= $sel('height', $heights, html_entity_decode($v('height', 'height'), ENT_QUOTES)) ?></div>
      <div class="mat-f"><label for="f_marital_status">Marital status <span class="req">*</span></label><?= $sel('marital_status', ['Never Married', 'Divorced', 'Widowed', 'Awaiting Divorce'], $me['marital_status'] ?? '', 'Select', true) ?></div>
      <div class="mat-f"><label for="f_mother_tongue">Mother tongue</label><?= $sel('mother_tongue', ['Telugu', 'Hindi', 'Tamil', 'Kannada', 'Malayalam', 'Marathi', 'Urdu', 'English', 'Other'], $me['mother_tongue'] ?? '') ?></div>
      <div class="mat-f"><label for="f_sub">Sub-community / Gotra</label><input id="f_sub" name="sub_community" maxlength="120" value="<?= $v('sub_community') ?>"></div>

      <h3 class="mat-fs"><i class="fa-solid fa-location-dot"></i> Location & contact</h3>
      <div class="mat-f"><label for="f_country">Country</label><input id="f_country" name="country" maxlength="80" value="<?= $v('country', 'country') ?: 'India' ?>"></div>
      <div class="mat-f"><label for="f_state">State <span class="req">*</span></label><?php
        $states = ['Andhra Pradesh', 'Telangana', 'Karnataka', 'Tamil Nadu', 'Kerala', 'Maharashtra', 'Odisha', 'Chhattisgarh', 'Goa', 'Gujarat', 'Madhya Pradesh', 'Rajasthan',
            'Uttar Pradesh', 'Uttarakhand', 'Bihar', 'Jharkhand', 'West Bengal', 'Assam', 'Arunachal Pradesh', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Sikkim', 'Tripura',
            'Haryana', 'Himachal Pradesh', 'Punjab', 'Andaman and Nicobar Islands', 'Chandigarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Delhi', 'Jammu and Kashmir',
            'Ladakh', 'Lakshadweep', 'Puducherry'];
        // match what was typed before (e.g. "telanagan") to the right state
        $curState = trim((string)$v('state', 'state')); $pick = '';
        if ($curState !== '') { $best = 99; foreach ($states as $st) { $d = levenshtein(strtolower(preg_replace('/[^a-z]/i', '', $curState)), strtolower(preg_replace('/[^a-z]/i', '', $st))); if ($d < $best) { $best = $d; $pick = $st; } } if ($best > 3) $pick = ''; }
        ?><select id="f_state" name="state" required data-msg="Please select the state."><option value="">Select state</option><?php foreach ($states as $st): ?><option<?= $st === $pick ? ' selected' : '' ?>><?= e($st) ?></option><?php endforeach; ?></select></div>
      <div class="mat-f"><label for="f_district">District</label><input id="f_district" name="district" maxlength="80" value="<?= $v('district', 'district') ?>"></div>
      <div class="mat-f"><label for="f_city">City <span class="req">*</span></label><input id="f_city" name="city" required maxlength="80" value="<?= $v('city', 'city') ?>" data-msg="Please enter the city."></div>
      <div class="mat-f"><label for="f_mobile">Mobile <span class="req">*</span></label><input id="f_mobile" name="mobile" type="tel" required pattern="[6-9][0-9]{9}" maxlength="10" inputmode="numeric" value="<?= e(preg_replace('/\D/', '', (string)($me['phone'] ?? $user['phone'] ?? ''))) ?>" data-msg="Enter a 10-digit Indian mobile number."><span class="mat-hint">Shown only to members you connect with.</span></div>
      <div class="mat-f"><label for="f_email">Email</label><input id="f_email" name="email" type="email" maxlength="160" value="<?= e($me['email'] ?? $user['email'] ?? '') ?>" data-msg="Enter a valid email."></div>

      <h3 class="mat-fs"><i class="fa-solid fa-graduation-cap"></i> Education & career</h3>
      <div class="mat-f"><label for="f_qualification">Education <span class="req">*</span></label><?= $sel('qualification', ['10th / SSC', 'Intermediate / 12th', 'Diploma', 'Graduate', 'Post Graduate', 'Doctorate', 'Professional (CA / Medical / Law)', 'Other'], $me['education'] ?? '', 'Select', true) ?></div>
      <div class="mat-f"><label for="f_profession">Profession <span class="req">*</span></label><input id="f_profession" name="profession" required maxlength="80" value="<?= $v('profession', 'profession') ?>" placeholder="e.g. Software Engineer" data-msg="Please enter the profession."></div>
      <div class="mat-f"><label for="f_designation">Designation</label><input id="f_designation" name="designation" maxlength="120" value="<?= $v('designation') ?>"></div>
      <div class="mat-f"><label for="f_company">Company / Business</label><input id="f_company" name="company" maxlength="120" value="<?= $v('company') ?>"></div>
      <div class="mat-f"><label for="f_work_location">Work location</label><input id="f_work_location" name="work_location" maxlength="120" value="<?= $v('work_location') ?>"></div>
      <div class="mat-f"><label for="f_annual_income">Annual income</label><?= $sel('annual_income', ['Below ₹3 Lakh', '₹3 – 5 Lakh', '₹5 – 10 Lakh', '₹10 – 20 Lakh', '₹20 – 50 Lakh', 'Above ₹50 Lakh', 'Prefer not to say'], $d['annual_income'] ?? '') ?></div>

      <h3 class="mat-fs"><i class="fa-solid fa-people-roof"></i> Family</h3>
      <div class="mat-f"><label for="f_father_name">Father's name</label><input id="f_father_name" name="father_name" maxlength="120" value="<?= $v('father_name') ?>"></div>
      <div class="mat-f"><label for="f_father_occupation">Father's occupation</label><input id="f_father_occupation" name="father_occupation" maxlength="120" value="<?= $v('father_occupation') ?>"></div>
      <div class="mat-f"><label for="f_mother_name">Mother's name</label><input id="f_mother_name" name="mother_name" maxlength="120" value="<?= $v('mother_name') ?>"></div>
      <div class="mat-f"><label for="f_mother_occupation">Mother's occupation</label><input id="f_mother_occupation" name="mother_occupation" maxlength="120" value="<?= $v('mother_occupation') ?>"></div>
      <div class="mat-f"><label for="f_brothers">Brothers</label><input id="f_brothers" name="brothers" type="number" min="0" max="15" value="<?= $v('brothers') ?>"></div>
      <div class="mat-f"><label for="f_sisters">Sisters</label><input id="f_sisters" name="sisters" type="number" min="0" max="15" value="<?= $v('sisters') ?>"></div>
      <div class="mat-f"><label for="f_family_type">Family type</label><?= $sel('family_type', ['Joint family', 'Nuclear family'], $d['family_type'] ?? '') ?></div>
      <div class="mat-f"><label for="f_family_location">Family location / native place</label><input id="f_family_location" name="family_location" maxlength="120" value="<?= $v('family_location') ?>"></div>

      <h3 class="mat-fs"><i class="fa-solid fa-pen"></i> About</h3>
      <div class="mat-f full"><label for="f_about">About me <span class="req">*</span></label><textarea id="f_about" name="about_me" required minlength="20" maxlength="2000" data-msg="Write at least 20 characters about yourself."><?= $v('about_me', 'about') ?></textarea><span class="mat-hint"><span id="aboutCount">0</span>/2000. Do not include phone numbers here.</span></div>

      <?php if (!$edit): ?>
      <h3 class="mat-fs"><i class="fa-solid fa-camera"></i> Photos (optional)</h3>
      <div class="mat-f full"><label for="f_photos">Add up to 6 photos</label><input id="f_photos" type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple><span class="mat-hint">JPG, PNG or WEBP, max 5 MB each. Photos are checked before they are shown.</span></div>
      <?php endif; ?>
    </div>
    <div class="mat-actions">
      <button class="mat-btn" type="submit" data-busy="Saving"><i class="fa-solid fa-floppy-disk"></i> <?= $edit ? 'Save changes' : 'Submit profile' ?></button>
      <a class="mat-btn ghost" href="<?= $edit ? 'my-profile.php' : 'index.php' ?>">Cancel</a>
    </div>
  </form>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
