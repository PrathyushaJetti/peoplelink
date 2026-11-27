<?php
require __DIR__ . '/../components/init.php';
mat_need_login();
if (!$cid) { header('Location: ' . $F . 'community-page.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/module-4/Frontend/pages/index.php')); exit; }
$edit = (bool)$me;
$d = $me ? pl_details($me) : (array)($_SESSION['mat_signup'] ?? []); // new profile: answers from the sign-up popup
$v = function (string $k, ?string $col = null) use ($me, $d) {
    $val = $col && $me ? ($me[$col] ?? '') : '';
    if ($val === '' || $val === null) $val = $d[$k] ?? '';
    return e(is_array($val) ? implode(', ', $val) : $val);
};
$dv = fn(string $k) => is_array($d[$k] ?? null) ? '' : (string)($d[$k] ?? '');
$sel = function (string $name, array $opts, string $cur, string $placeholder = 'Select', bool $req = false) {
    $h = '<select id="f_' . $name . '" name="' . $name . '"' . ($req ? ' required data-msg="Please select an option."' : '') . '><option value="">' . e($placeholder) . '</option>';
    $found = false;
    foreach ($opts as $o) { $s = strcasecmp($o, $cur) === 0; $found = $found || $s; $h .= '<option' . ($s ? ' selected' : '') . '>' . e($o) . '</option>'; }
    if ($cur !== '' && !$found) $h .= '<option selected>' . e($cur) . '</option>';
    return $h . '</select>';
};
// tick-box group; the hidden empty value lets a member clear every tick
$multi = function (string $name, array $opts, bool $req = false) use ($d) {
    $cur = array_map('strtolower', (array)($d[$name] ?? []));
    $h = '<input type="hidden" name="' . $name . '" value=""><div class="mat-checks"' . ($req ? ' data-req-group="Please choose at least one."' : '') . '>';
    foreach ($opts as $o) $h .= '<label><input type="checkbox" name="' . $name . '[]" value="' . e($o) . '"' . (in_array(strtolower($o), $cur, true) ? ' checked' : '') . '> ' . e($o) . '</label>';
    return $h . '</div>';
};
$R = '<span class="req">*</span>';
$heights = []; for ($i = 54; $i <= 84; $i++) $heights[] = intdiv($i, 12) . "' " . ($i % 12) . '"';
$dobMax = date('Y-m-d', strtotime('-' . MAT_MIN_AGE . ' years'));
$dobMin = date('Y-m-d', strtotime('-' . MAT_MAX_AGE . ' years'));
$stars = ['Ashwini', 'Bharani', 'Krittika', 'Rohini', 'Mrigashira', 'Ardra', 'Punarvasu', 'Pushya', 'Ashlesha', 'Magha', 'Purva Phalguni (Pubba)', 'Uttara Phalguni (Uttara)', 'Hasta', 'Chitra', 'Swati',
    'Vishakha', 'Anuradha', 'Jyeshtha', 'Mula', 'Purva Ashadha', 'Uttara Ashadha', 'Shravana', 'Dhanishta', 'Shatabhisha', 'Purva Bhadrapada', 'Uttara Bhadrapada', 'Revati'];
$raasis = ['Mesha (Aries)', 'Vrishabha (Taurus)', 'Mithuna (Gemini)', 'Karkataka (Cancer)', 'Simha (Leo)', 'Kanya (Virgo)', 'Tula (Libra)', 'Vrischika (Scorpio)', 'Dhanus (Sagittarius)', 'Makara (Capricorn)', 'Kumbha (Aquarius)', 'Meena (Pisces)'];
$pageTitle = $edit ? 'Edit profile' : 'Create profile'; $active = 'me'; $scripts = ['india-locations.js', 'profile-form.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap">
  <div class="mat-head"><div><span class="mat-eyebrow"><?= e($comm['name']) ?> matrimony</span><h1><?= $edit ? 'Edit your profile' : 'Create your matrimony profile' ?></h1>
    <p><?= $edit ? ($me['status'] === 'approved' ? 'Saving changes sends your profile for re-approval; it stays hidden until approved.' : 'Profile ' . e($me['profile_code']) . ' · status: ' . e($me['status'])) : 'Fields marked * are required. Your profile is checked by our team before it is shown.' ?>
    <?= $edit ? ' · Fields marked * are required.' : '' ?></p></div></div>

  <div class="pf-layout">
  <aside class="pf-nav" id="pfNav" aria-label="Profile sections"></aside>
  <form id="profileForm" class="pf-form" novalidate data-mode="<?= $edit ? 'edit' : 'create' ?>">
    <input type="hidden" name="profile_form" value="2">
    <section class="pf-card" id="pf-sec-1">
      <header class="pf-head"><span class="pf-num">1</span><div><h2><i class="fa-solid fa-user"></i> Personal information</h2><p>Basic details shown at the top of your profile.</p></div><span class="pf-done" title="All required details added"><i class="fa-solid fa-circle-check"></i></span></header>
      <div class="mat-form">
      <div class="mat-f"><label for="f_profile_created_by">Profile created by <?= $R ?></label><?= $sel('profile_created_by', ['Self', 'Parent', 'Sibling', 'Relative', 'Friend'], $dv('profile_created_by'), 'Select', true) ?></div>
      <div class="mat-f"><label for="f_full_name">Full name <?= $R ?></label><input id="f_full_name" name="full_name" required maxlength="120" value="<?= $v('full_name', 'full_name') ?>" data-msg="Please enter the full name."></div>
      <div class="mat-f"><label for="f_gender">Gender <?= $R ?></label>
        <?php if ($edit): ?><input id="f_gender" value="<?= e($me['gender']) ?>" disabled><span class="mat-hint">Contact support to change gender.</span>
        <?php else: ?><?= $sel('gender', ['Female', 'Male'], (string)($d['gender'] ?? ''), 'Select', true) ?><?php endif; ?></div>
      <div class="mat-f"><label for="f_dob">Date of birth <?= $R ?></label><input id="f_dob" type="date" name="date_of_birth" required min="<?= $dobMin ?>" max="<?= $dobMax ?>" value="<?= e($me['dob'] ?? $d['date_of_birth'] ?? '') ?>" data-msg="Enter a valid date of birth (you must be <?= MAT_MIN_AGE ?>+)."><span class="mat-hint">Age is calculated from this. Minimum age <?= MAT_MIN_AGE ?>.</span></div>
      <div class="mat-f"><label for="f_height">Height <?= $R ?></label><?= $sel('height', $heights, html_entity_decode($v('height', 'height'), ENT_QUOTES), 'Select', true) ?></div>
      <div class="mat-f"><label for="f_weight">Weight (kg) <?= $R ?></label><input id="f_weight" name="weight" type="number" min="30" max="200" required inputmode="numeric" value="<?= e($dv('weight')) ?>" data-msg="Enter weight in kg (30–200)."></div>
      <div class="mat-f"><label for="f_body_type">Body type <?= $R ?></label><?= $sel('body_type', ['Slim', 'Average', 'Athletic', 'Heavy'], $dv('body_type'), 'Select', true) ?></div>
      <div class="mat-f"><label for="f_marital_status">Marital status <?= $R ?></label><?= $sel('marital_status', ['Never Married', 'Divorced', 'Widowed', 'Awaiting Divorce'], $me['marital_status'] ?? '', 'Select', true) ?></div>
      <div class="mat-f" id="childrenWrap"><label for="f_children">Children <?= $R ?></label><?= $sel('children', ['No children', '1 child – living with me', '1 child – not living with me', '2 children', '3 or more children'], $dv('children'), 'Select', true) ?></div>
      <div class="mat-f"><label for="f_mother_tongue">Mother tongue <?= $R ?></label><?= $sel('mother_tongue', ['Telugu', 'Hindi', 'Tamil', 'Kannada', 'Malayalam', 'Marathi', 'Urdu', 'English', 'Other'], $me['mother_tongue'] ?? (string)($d['mother_tongue'] ?? ''), 'Select', true) ?></div>
      <div class="mat-f"><label for="f_eating_habits">Eating habits <?= $R ?></label><?= $sel('eating_habits', ['Vegetarian', 'Non-vegetarian', 'Eggetarian', 'Vegan'], $dv('eating_habits'), 'Select', true) ?></div>
      <div class="mat-f full"><label>Spoken languages <?= $R ?></label><?= $multi('spoken_languages', ['Telugu', 'English', 'Hindi', 'Tamil', 'Kannada', 'Malayalam', 'Marathi', 'Urdu', 'Other'], true) ?></div>
      </div>
    </section>
    <section class="pf-card" id="pf-sec-2">
      <header class="pf-head"><span class="pf-num">2</span><div><h2><i class="fa-solid fa-om"></i> Religion &amp; horoscope</h2><p>Families use these details for horoscope matching.</p></div><span class="pf-done" title="All required details added"><i class="fa-solid fa-circle-check"></i></span></header>
      <div class="mat-form">
      <div class="mat-f"><label for="f_religion">Religion <?= $R ?></label><?= $sel('religion', ['Hindu', 'Muslim', 'Christian', 'Sikh', 'Jain', 'Buddhist', 'Other'], $dv('religion') ?: 'Hindu', 'Select', true) ?></div>
      <div class="mat-f"><label for="f_caste">Caste / community</label><input id="f_caste" value="<?= e($comm['name']) ?>" disabled><span class="mat-hint">From the community you selected.</span></div>
      <div class="mat-f"><label for="f_sub">Sub-caste <?= $R ?></label><input id="f_sub" name="sub_community" required maxlength="120" value="<?= $v('sub_community') ?>" placeholder="e.g. Gudati" data-msg="Please enter the sub-caste."></div>
      <div class="mat-f"><label for="f_gothram">Gothram <?= $R ?></label><input id="f_gothram" name="gothram" required maxlength="80" value="<?= e($dv('gothram')) ?>" placeholder="Write &quot;Don't know&quot; if not sure" data-msg="Please enter the gothram."></div>
      <div class="mat-f"><label for="f_star">Star / Nakshatram <?= $R ?></label><?= $sel('star', array_merge($stars, ["Don't know"]), $dv('star'), 'Select', true) ?></div>
      <div class="mat-f"><label for="f_raasi">Raasi / Moon sign <?= $R ?></label><?= $sel('raasi', array_merge($raasis, ["Don't know"]), $dv('raasi'), 'Select', true) ?></div>
      <div class="mat-f"><label for="f_kuja_dosham">Kuja dosham / Manglik <?= $R ?></label><?= $sel('kuja_dosham', ['No', 'Yes', "Don't know"], $dv('kuja_dosham'), 'Select', true) ?></div>
      <div class="mat-f"><label for="f_birth_time">Time of birth</label><input id="f_birth_time" name="birth_time" type="time" value="<?= e($dv('birth_time')) ?>"></div>
      <div class="mat-f"><label for="f_birth_place">Place of birth</label><input id="f_birth_place" name="birth_place" maxlength="120" value="<?= e($dv('birth_place')) ?>"></div>
      </div>
    </section>
    <section class="pf-card" id="pf-sec-3">
      <header class="pf-head"><span class="pf-num">3</span><div><h2><i class="fa-solid fa-location-dot"></i> Location &amp; contact</h2><p>Your mobile number is shown only to members you connect with.</p></div><span class="pf-done" title="All required details added"><i class="fa-solid fa-circle-check"></i></span></header>
      <div class="mat-form">
      <div class="mat-f"><label for="f_country">Country</label><input id="f_country" name="country" maxlength="80" value="<?= $v('country', 'country') ?: 'India' ?>"></div>
      <div class="mat-f"><label for="f_state">State <?= $R ?></label><?php
        $states = ['Andhra Pradesh', 'Telangana', 'Karnataka', 'Tamil Nadu', 'Kerala', 'Maharashtra', 'Odisha', 'Chhattisgarh', 'Goa', 'Gujarat', 'Madhya Pradesh', 'Rajasthan',
            'Uttar Pradesh', 'Uttarakhand', 'Bihar', 'Jharkhand', 'West Bengal', 'Assam', 'Arunachal Pradesh', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Sikkim', 'Tripura',
            'Haryana', 'Himachal Pradesh', 'Punjab', 'Andaman and Nicobar Islands', 'Chandigarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Delhi', 'Jammu and Kashmir',
            'Ladakh', 'Lakshadweep', 'Puducherry'];
        // match what was typed before (e.g. "telanagan") to the right state
        $curState = trim((string)$v('state', 'state')); $pick = '';
        if ($curState !== '') { $best = 99; foreach ($states as $st) { $dist = levenshtein(strtolower(preg_replace('/[^a-z]/i', '', $curState)), strtolower(preg_replace('/[^a-z]/i', '', $st))); if ($dist < $best) { $best = $dist; $pick = $st; } } if ($best > 3) $pick = ''; }
        ?><select id="f_state" name="state" required data-msg="Please select the state."><option value="">Select state</option><?php foreach ($states as $st): ?><option<?= $st === $pick ? ' selected' : '' ?>><?= e($st) ?></option><?php endforeach; ?></select></div>
      <div class="mat-f"><label for="f_district">District</label><input id="f_district" name="district" maxlength="80" value="<?= $v('district', 'district') ?>"></div>
      <div class="mat-f"><label for="f_city">City <?= $R ?></label><input id="f_city" name="city" required maxlength="80" value="<?= $v('city', 'city') ?>" data-msg="Please enter the city."></div>
      <div class="mat-f"><label for="f_mobile">Mobile <?= $R ?></label><input id="f_mobile" name="mobile" type="tel" required pattern="[6-9][0-9]{9}" maxlength="10" inputmode="numeric" value="<?= e(preg_replace('/\D/', '', (string)($me['phone'] ?? $user['phone'] ?? ''))) ?>" data-msg="Enter a 10-digit Indian mobile number."><span class="mat-hint">Shown only to members you connect with.</span></div>
      <div class="mat-f"><label for="f_email">Email</label><input id="f_email" name="email" type="email" maxlength="160" value="<?= e($me['email'] ?? $user['email'] ?? '') ?>" data-msg="Enter a valid email."></div>
      </div>
    </section>
    <section class="pf-card" id="pf-sec-4">
      <header class="pf-head"><span class="pf-num">4</span><div><h2><i class="fa-solid fa-graduation-cap"></i> Education &amp; career</h2><p>Your studies and work.</p></div><span class="pf-done" title="All required details added"><i class="fa-solid fa-circle-check"></i></span></header>
      <div class="mat-form">
      <div class="mat-f"><label for="f_qualification">Education <?= $R ?></label><?= $sel('qualification', ['10th / SSC', 'Intermediate / 12th', 'Diploma', 'Graduate', 'Post Graduate', 'Doctorate', 'Professional (CA / Medical / Law)', 'Other'], $me['education'] ?? '', 'Select', true) ?></div>
      <div class="mat-f"><label for="f_education_detail">Degree / course</label><input id="f_education_detail" name="education_detail" maxlength="120" value="<?= e($dv('education_detail')) ?>" placeholder="e.g. MBA, B.Tech (CSE)"></div>
      <div class="mat-f"><label for="f_employed_in">Employed in</label><?= $sel('employed_in', ['Private sector', 'Government / PSU', 'Business / Self-employed', 'Defence', 'Not working', 'Other'], $dv('employed_in')) ?></div>
      <div class="mat-f"><label for="f_profession">Profession <?= $R ?></label><input id="f_profession" name="profession" required maxlength="80" value="<?= $v('profession', 'profession') ?>" placeholder="e.g. Software Engineer" data-msg="Please enter the profession."></div>
      <div class="mat-f"><label for="f_designation">Designation</label><input id="f_designation" name="designation" maxlength="120" value="<?= $v('designation') ?>"></div>
      <div class="mat-f"><label for="f_company">Company / Business</label><input id="f_company" name="company" maxlength="120" value="<?= $v('company') ?>"></div>
      <div class="mat-f"><label for="f_work_location">Work location</label><input id="f_work_location" name="work_location" maxlength="120" value="<?= $v('work_location') ?>"></div>
      <div class="mat-f"><label for="f_annual_income">Annual income</label><?= $sel('annual_income', ['Below ₹3 Lakh', '₹3 – 5 Lakh', '₹5 – 10 Lakh', '₹10 – 20 Lakh', '₹20 – 50 Lakh', 'Above ₹50 Lakh', 'Prefer not to say'], $d['annual_income'] ?? '') ?></div>
      </div>
    </section>
    <section class="pf-card" id="pf-sec-5">
      <header class="pf-head"><span class="pf-num">5</span><div><h2><i class="fa-solid fa-people-roof"></i> Family information</h2><p>Tell families about your parents, brothers, sisters and roots.</p></div><span class="pf-done" title="All required details added"><i class="fa-solid fa-circle-check"></i></span></header>
      <div class="mat-form">
      <div class="mat-f"><label for="f_father_name">Father's name <?= $R ?></label><input id="f_father_name" name="father_name" required maxlength="120" value="<?= $v('father_name') ?>" data-msg="Please enter the father's name."></div>
      <div class="mat-f"><label for="f_father_occupation">Father's occupation <?= $R ?></label><input id="f_father_occupation" name="father_occupation" required maxlength="120" value="<?= $v('father_occupation') ?>" placeholder="e.g. Business, Retired, Late" data-msg="Please enter the father's occupation."></div>
      <div class="mat-f"><label for="f_mother_name">Mother's name <?= $R ?></label><input id="f_mother_name" name="mother_name" required maxlength="120" value="<?= $v('mother_name') ?>" data-msg="Please enter the mother's name."></div>
      <div class="mat-f"><label for="f_mother_occupation">Mother's occupation <?= $R ?></label><input id="f_mother_occupation" name="mother_occupation" required maxlength="120" value="<?= $v('mother_occupation') ?>" placeholder="e.g. Homemaker, Teacher, Late" data-msg="Please enter the mother's occupation."></div>
      <div class="mat-f"><label for="f_brothers">Brothers <?= $R ?></label><input id="f_brothers" name="brothers" type="number" min="0" max="15" required value="<?= $v('brothers') ?>" data-msg="Enter the number of brothers (0 if none)."></div>
      <div class="mat-f"><label for="f_brothers_married">Brothers married <?= $R ?></label><input id="f_brothers_married" name="brothers_married" type="number" min="0" max="15" required value="<?= e($dv('brothers_married')) ?>" data-msg="Enter how many brothers are married (0 if none)."></div>
      <div class="mat-f"><label for="f_sisters">Sisters <?= $R ?></label><input id="f_sisters" name="sisters" type="number" min="0" max="15" required value="<?= $v('sisters') ?>" data-msg="Enter the number of sisters (0 if none)."></div>
      <div class="mat-f"><label for="f_sisters_married">Sisters married <?= $R ?></label><input id="f_sisters_married" name="sisters_married" type="number" min="0" max="15" required value="<?= e($dv('sisters_married')) ?>" data-msg="Enter how many sisters are married (0 if none)."></div>
      <div class="mat-f"><label for="f_family_type">Family type <?= $R ?></label><?= $sel('family_type', ['Joint family', 'Nuclear family'], $d['family_type'] ?? '', 'Select', true) ?></div>
      <div class="mat-f"><label for="f_family_status">Family status <?= $R ?></label><?= $sel('family_status', ['Middle class', 'Upper middle class', 'Rich / Affluent', 'Lower middle class'], $dv('family_status'), 'Select', true) ?></div>
      <div class="mat-f"><label for="f_family_values">Family values <?= $R ?></label><?= $sel('family_values', ['Traditional', 'Moderate', 'Liberal'], $dv('family_values'), 'Select', true) ?></div>
      <div class="mat-f"><label for="f_family_location">Ancestral origin / native place <?= $R ?></label><input id="f_family_location" name="family_location" required maxlength="120" value="<?= $v('family_location') ?>" placeholder="e.g. Rangareddy Dist" data-msg="Please enter the native place."></div>
      <div class="mat-f full"><label for="f_about_family">About my family <?= $R ?></label><textarea id="f_about_family" name="about_family" required minlength="20" maxlength="1500" data-msg="Write at least 20 characters about your family." placeholder="e.g. We are a family of 5 – my parents, a brother, a sister and me."><?= e($dv('about_family')) ?></textarea></div>
      </div>
    </section>
    <section class="pf-card" id="pf-sec-6">
      <header class="pf-head"><span class="pf-num">6</span><div><h2><i class="fa-solid fa-mug-hot"></i> Lifestyle &amp; interests</h2><p>Optional – helps us show what you both like.</p></div><span class="pf-done" title="All required details added"><i class="fa-solid fa-circle-check"></i></span></header>
      <div class="mat-form">
      <div class="mat-f"><label for="f_smoking">Smoking</label><?= $sel('smoking', ['Never smokes', 'Occasionally', 'Regularly'], $dv('smoking')) ?></div>
      <div class="mat-f"><label for="f_drinking">Drinking</label><?= $sel('drinking', ['Never drinks', 'Occasionally', 'Regularly'], $dv('drinking')) ?></div>
      <div class="mat-f full"><label>Cuisine</label><?= $multi('cuisine', ['South Indian', 'Andhra', 'North Indian', 'Gujarati', 'Chinese', 'Continental', 'Street food']) ?></div>
      <div class="mat-f full"><label>Hobbies</label><?= $multi('hobbies', ['Cooking', 'Gardening / Landscaping', 'Reading', 'Travel', 'Photography', 'Painting / Art', 'Playing musical instruments', 'Sports', 'Dancing', 'Nature']) ?></div>
      <div class="mat-f full"><label>Interests</label><?= $multi('interests', ['Book clubs', 'Music', 'Movies', 'Politics', 'Social service', 'Yoga', 'Fitness', 'Technology', 'Spirituality', 'Travel']) ?></div>
      <div class="mat-f full"><label>Music</label><?= $multi('music', ['Film songs', 'Carnatic', 'Indian classical', 'Devotional', 'Folk', 'Pop', 'Western']) ?></div>
      <div class="mat-f full"><label>Movies</label><?= $multi('movies', ['Romantic', 'Family', 'Comedy', 'Action', 'Drama', 'Thriller', 'Devotional']) ?></div>
      </div>
    </section>
    <section class="pf-card" id="pf-sec-7">
      <header class="pf-head"><span class="pf-num">7</span><div><h2><i class="fa-solid fa-pen"></i> About me</h2><p>A few lines about yourself, in your own words.</p></div><span class="pf-done" title="All required details added"><i class="fa-solid fa-circle-check"></i></span></header>
      <div class="mat-form">
      <div class="mat-f full"><label for="f_about">About me <?= $R ?></label><textarea id="f_about" name="about_me" required minlength="20" maxlength="2000" data-msg="Write at least 20 characters about yourself."><?= $v('about_me', 'about') ?></textarea><span class="mat-hint"><span id="aboutCount">0</span>/2000. Do not include phone numbers here.</span></div>

      <?php if (!$edit): ?>
      <div class="mat-f full"><label for="f_photos">Add up to 6 photos</label><input id="f_photos" type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple><span class="mat-hint">JPG, PNG or WEBP, max 5 MB each. Photos are checked before they are shown.</span></div>
      <?php endif; ?>
      </div>
    </section>
    <div class="pf-savebar">
      <div class="pf-savebar-info"><b id="pfPct">0%</b> of required details added</div>
      <div class="mat-actions">
      <button class="mat-btn" type="submit" data-busy="Saving"><i class="fa-solid fa-floppy-disk"></i> <?= $edit ? 'Save changes' : 'Submit profile' ?></button>
      <a class="mat-btn ghost" href="<?= $edit ? 'my-profile.php' : 'index.php' ?>">Cancel</a>
      </div>
    </div>
  </form>
  </div>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
