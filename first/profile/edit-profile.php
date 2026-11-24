<?php
// Edit Profile: loads the logged-in user's real data and saves it (account + community member profile).
require_once __DIR__ . '/_account.php';

$epErrors = [];
$epFlash = $_SESSION['ep_flash'] ?? null; unset($_SESSION['ep_flash']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) $epErrors[] = 'Your session expired. Please try again.';
    $in = fn(string $k, int $len = 255) => mb_substr(trim((string)($_POST[$k] ?? '')), 0, $len);
    $name = $in('full_name', 120); $email = strtolower($in('email', 160));
    $mobile = preg_replace('/[^\d+]/', '', $in('mobile', 30)); $alt = preg_replace('/[^\d+]/', '', $in('alternate_mobile', 30));
    $gender = $in('gender', 30); $marital = $in('marital_status', 30); $pin = $in('pincode', 10);
    $dobRaw = $in('dob', 20); $dob = $dobRaw !== '' && ($t = strtotime($dobRaw)) ? date('Y-m-d', $t) : null;
    if ($name === '') $epErrors[] = 'Please enter your full name.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $epErrors[] = 'Please enter a valid email address.';
    elseif ($email !== strtolower($acUser['email']) && scalar('SELECT COUNT(*) FROM users WHERE email=? AND id<>?', [$email, $acUid])) $epErrors[] = 'This email is already used by another account.';
    if (!preg_match('/^\+?\d{10,15}$/', $mobile)) $epErrors[] = 'Please enter a valid mobile number (10 digits).';
    if ($alt !== '' && !preg_match('/^\+?\d{10,15}$/', $alt)) $epErrors[] = 'Please check your alternate mobile number.';
    if ($pin !== '' && !preg_match('/^\d{6}$/', $pin)) $epErrors[] = 'Pincode must be 6 digits.';
    if ($dob && (strtotime($dob) > time() || (int)date('Y', strtotime($dob)) < 1900)) $epErrors[] = 'Please enter a valid date of birth.';
    if ($gender !== '' && !in_array($gender, ['Male', 'Female', 'Other', 'Prefer not to say'], true)) $gender = '';
    if ($marital !== '' && !in_array($marital, ['Single', 'Married', 'Divorced', 'Widowed', 'Other'], true)) $marital = '';

    // photo: upload a new one or remove the current one
    $photo = ac_val('photo'); $photoChanged = false;
    if (!$epErrors && !empty($_FILES['profile_photo']) && ($_FILES['profile_photo']['error'] ?? 4) !== UPLOAD_ERR_NO_FILE) {
        $up = pl_store_upload($_FILES['profile_photo'], 'users');
        if (!empty($up['error'])) $epErrors[] = $up['error']; else { $photo = $up['url']; $photoChanged = true; }
    } elseif (($_POST['remove_photo'] ?? '0') === '1') { $photo = null; $photoChanged = true; }

    if (!$epErrors) {
        $city = $in('city', 80) ?: $in('address_city', 80); $state = $in('state', 80);
        db()->prepare('UPDATE users SET name=?, email=?, phone=?, gender=?, dob=?, city=?, state=?, photo=?, phone_verified=IF(phone=?, phone_verified, 0), email_verified=IF(email=?, email_verified, 0) WHERE id=?')
            ->execute([$name, $email, $mobile, in_array($gender, PL_GENDERS, true) ? $gender : null, $dob, $city, $state, $photo, $mobile, $email, $acUid]);
        $p = $acPrefs;
        foreach (['show_mobile', 'show_email', 'show_city', 'show_professional'] as $k) $p[$k] = !empty($_POST[$k]);
        $p['mobile_visibility'] = $p['show_mobile'] ? 'members' : 'private'; $p['email_visibility'] = $p['show_email'] ? 'members' : 'private';
        db()->prepare('UPDATE users SET prefs=? WHERE id=?')->execute([json_encode($p), $acUid]);

        if ($acCid) {
            $details = json_decode($acMember['details'] ?? '', true) ?: [];
            foreach (['native_place', 'company', 'designation', 'sub_community', 'gotram', 'surname', 'alternate_mobile'] as $k) $details[$k] = $k === 'alternate_mobile' ? $alt : $in($k, 120);
            $cols = ['full_name' => $name, 'gender' => $gender ?: null, 'dob' => $dob, 'marital_status' => $marital ?: null, 'phone' => $mobile, 'email' => $email,
                'education' => $in('education'), 'occupation' => $in('profession'), 'address' => $in('address', 500), 'area' => $in('locality'), 'city' => $city, 'state' => $state,
                'pincode' => $pin, 'photo' => $photo, 'contact_visibility' => ($p['show_mobile'] || $p['show_email']) ? 'members' : 'private', 'details' => json_encode($details, JSON_UNESCAPED_UNICODE)];
            if ($acMember) {
                // a new name or photo needs a fresh admin approval, other edits stay live (same rule as the app API)
                if ($acMember['status'] === 'rejected' || $name !== $acMember['full_name'] || $photoChanged) $cols['status'] = 'pending';
                pl_entity_update(pl_entity('member'), (int)$acMember['id'], $cols);
            } else {
                pl_entity_insert(pl_entity('member'), $cols, ['community_id' => $acCid, 'user_id' => $acUid, 'created_by' => $acUid, 'status' => 'pending']);
                $cols['status'] = 'pending';
            }
        }
        $_SESSION['ep_flash'] = ($cols['status'] ?? '') === 'pending' ? 'Profile saved. Your name/photo change is waiting for admin approval.' : 'Profile saved successfully.';
        header('Location: edit-profile.php'); exit;
    }
}

$acDetails = json_decode($acMember['details'] ?? '', true) ?: [];
$d = fn(string $k) => (string)($acDetails[$k] ?? '');
$post = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : null; // keep what the user typed when there is an error
$v = fn(string $k, $real) => $post !== null && isset($post[$k]) ? (string)$post[$k] : (string)$real;

$profile = [
    'full_name' => $v('full_name', ac_val('full_name') ?: $acUser['name']),
    'gender' => $v('gender', ac_val('gender')),
    'dob' => $v('dob', ac_val('dob')),
    'marital_status' => $v('marital_status', $acMember['marital_status'] ?? ''),
    'mobile' => $v('mobile', ac_val('phone')),
    'alternate_mobile' => $v('alternate_mobile', $d('alternate_mobile')),
    'email' => $v('email', $acUser['email']),
    'native_place' => $v('native_place', $d('native_place')),
    'city' => $v('city', ac_val('city')),
    'education' => $v('education', $acMember['education'] ?? ''),
    'profession' => $v('profession', $acMember['occupation'] ?? ''),
    'company' => $v('company', $d('company')),
    'designation' => $v('designation', $d('designation')),
    'community' => $acComm['name'] ?? '',
    'sub_community' => $v('sub_community', $d('sub_community')),
    'gotram' => $v('gotram', $d('gotram')),
    'surname' => $v('surname', $d('surname')),
    'address' => $v('address', $acMember['address'] ?? ''),
    'locality' => $v('locality', $acMember['area'] ?? ''),
    'state' => $v('state', ac_val('state')),
    'pincode' => $v('pincode', $acMember['pincode'] ?? ''),
    'photo' => ac_val('photo') ?: 'assets/images/default-profile.png',
    'show_mobile' => $post !== null ? !empty($post['show_mobile']) : ($acPrefs['show_mobile'] ?? (($acPrefs['mobile_visibility'] ?? 'members') === 'members')),
    'show_email' => $post !== null ? !empty($post['show_email']) : ($acPrefs['show_email'] ?? (($acPrefs['email_visibility'] ?? 'members') === 'members')),
    'show_city' => $post !== null ? !empty($post['show_city']) : ($acPrefs['show_city'] ?? true),
    'show_professional' => $post !== null ? !empty($post['show_professional']) : ($acPrefs['show_professional'] ?? true),
];

$communities = array_column(rows('SELECT name FROM communities WHERE is_active=1 ORDER BY sort_order, name'), 'name');

// members are locked to one community (see pl_resolve_community); only an admin can move them
$communityLocked = ($acUser['role'] ?? '') !== 'admin' && !empty($acUser['community_id']);


function epEscape($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

include __DIR__ . '/header.php';
?>

 

<main class="ep-page">
    <div class="ep-container">

        <nav class="ep-breadcrumb" aria-label="Breadcrumb">
            <a href="../index.php">Home</a>
            <span>/</span>
            <a href="my-profile.php">My Profile</a>
            <span>/</span>
            <span>Edit Profile</span>
        </nav>

        <header class="ep-heading">
            <span class="ep-eyebrow">PEOPLELINK ACCOUNT</span>
            <h1>Edit Profile</h1>
            <p>Keep your information accurate and up to date.</p>
        </header>

        <form id="epProfileForm"
              action="edit-profile.php"
              method="POST"
              enctype="multipart/form-data">

            <input type="hidden" name="csrf" value="<?= epEscape(csrf_token()) ?>">

            <?php if ($epFlash): ?><div class="ep-alert ep-alert-success" role="status">✓ <?= epEscape($epFlash) ?></div><?php endif; ?>
            <?php if ($epErrors): ?><div class="ep-alert ep-alert-error" role="alert"><strong>Please fix the following:</strong><ul><?php foreach ($epErrors as $er): ?><li><?= epEscape($er) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

            <!-- Profile Photo -->
            <section class="ep-card ep-photo-card">
                <div class="ep-section-heading">
                    <div>
                        <h2>Profile Photo</h2>
                        <p>Choose a clear photo for your PeopleLink account.</p>
                    </div>
                </div>

                <div class="ep-photo-layout">
                    <div class="ep-photo-preview-wrap">
                        <img
                            src="<?= epEscape($profile['photo']) ?>"
                            id="epPhotoPreview"
                            class="ep-photo-preview"
                            alt="Profile photo"
                            onerror="this.onerror=null;this.src='assets/images/default-profile.png';">

                        <span class="ep-photo-camera">✎</span>
                    </div>

                    <div class="ep-photo-controls">
                        <strong>Upload your profile photo</strong>
                        <p>JPG, PNG or WebP. Maximum size: 2 MB.</p>

                        <div class="ep-photo-buttons">
                            <label for="epPhotoInput" class="ep-btn ep-btn-primary">
                                Upload / Change Photo
                            </label>

                            <button type="button" id="epRemovePhoto"
                                    class="ep-btn ep-btn-light">
                                Remove Photo
                            </button>
                        </div>

                        <input type="file"
                               id="epPhotoInput"
                               name="profile_photo"
                               accept="image/jpeg,image/png,image/webp"
                               hidden>

                        <input type="hidden"
                               name="remove_photo"
                               id="epRemovePhotoFlag"
                               value="0">

                        <span id="epPhotoMessage" class="ep-field-message"
                              aria-live="polite"></span>
                    </div>
                </div>
            </section>

            <!-- Personal Information -->
            <section class="ep-card" id="personal">
                <div class="ep-section-heading">
                    <div class="ep-section-icon ep-blue">♙</div>
                    <div>
                        <h2>Personal Information</h2>
                        <p>Your basic identity and personal details.</p>
                    </div>
                </div>

                <div class="ep-form-grid">
                    <div class="ep-field">
                        <label for="full_name">Full Name <span>*</span></label>
                        <input type="text" id="full_name" name="full_name"
                               value="<?= epEscape($profile['full_name']) ?>"
                               maxlength="100" autocomplete="name" required>
                    </div>

                    <div class="ep-field">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <?php foreach (['Male','Female','Other','Prefer not to say'] as $option): ?>
                                <option value="<?= epEscape($option) ?>"
                                    <?= $profile['gender'] === $option ? 'selected' : '' ?>>
                                    <?= epEscape($option) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="ep-field">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob"
                               value="<?= epEscape($profile['dob']) ?>">
                    </div>

                    <div class="ep-field">
                        <label for="marital_status">Marital Status</label>
                        <select id="marital_status" name="marital_status">
                            <option value="">Select Status</option>
                            <?php foreach (['Single','Married','Divorced','Widowed','Other'] as $option): ?>
                                <option value="<?= epEscape($option) ?>"
                                    <?= $profile['marital_status'] === $option ? 'selected' : '' ?>>
                                    <?= epEscape($option) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="ep-field">
                        <label for="native_place">Native Place</label>
                        <input type="text" id="native_place" name="native_place"
                               value="<?= epEscape($profile['native_place']) ?>"
                               maxlength="150">
                    </div>

                    <div class="ep-field">
                        <label for="city">Current City</label>
                        <input type="text" id="city" name="city"
                               value="<?= epEscape($profile['city']) ?>"
                               maxlength="100">
                    </div>
                </div>
            </section>

            <!-- Professional Information -->
            <section class="ep-card" id="professional">
                <div class="ep-section-heading">
                    <div class="ep-section-icon ep-green">▣</div>
                    <div>
                        <h2>Professional Information</h2>
                        <p>Share your education and career information.</p>
                    </div>
                </div>

                <div class="ep-form-grid">
                    <div class="ep-field">
                        <label for="education">Education</label>
                        <input type="text" id="education" name="education"
                               value="<?= epEscape($profile['education']) ?>"
                               maxlength="150">
                    </div>

                    <div class="ep-field">
                        <label for="profession">Profession / Occupation</label>
                        <input type="text" id="profession" name="profession"
                               value="<?= epEscape($profile['profession']) ?>"
                               maxlength="150">
                    </div>

                    <div class="ep-field">
                        <label for="company">Company / Organisation</label>
                        <input type="text" id="company" name="company"
                               value="<?= epEscape($profile['company']) ?>"
                               maxlength="150">
                    </div>

                    <div class="ep-field">
                        <label for="designation">Designation</label>
                        <input type="text" id="designation" name="designation"
                               value="<?= epEscape($profile['designation']) ?>"
                               maxlength="150">
                    </div>
                </div>
            </section>

            <!-- Community Information -->
            <section class="ep-card" id="community">
                <div class="ep-section-heading">
                    <div class="ep-section-icon ep-purple">♧</div>
                    <div>
                        <h2>Community Information</h2>
                        <p>Manage your community and family identity.</p>
                    </div>
                </div>

                <?php if ($communityLocked): ?>
                    <div class="ep-info-note">
                        <span>i</span>
                        Community information is currently locked.
                        Contact an administrator to request a change.
                    </div>
                <?php endif; ?>

                <fieldset class="ep-fieldset">

                    <div class="ep-form-grid">
                        <div class="ep-field">
                            <label for="community">Community</label>
                            <select id="community" name="community" <?= $communityLocked ? 'disabled' : '' ?>>
                                <option value="">Select Community</option>
                                <?php foreach ($communities as $community): ?>
                                    <option value="<?= epEscape($community) ?>"
                                        <?= $profile['community'] === $community ? 'selected' : '' ?>>
                                        <?= epEscape($community) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="ep-field">
                            <label for="sub_community">Sub-Community</label>
                            <input type="text" id="sub_community"
                                   name="sub_community"
                                   value="<?= epEscape($profile['sub_community']) ?>"
                                   maxlength="100">
                        </div>

                        <div class="ep-field">
                            <label for="gotram">Gotram</label>
                            <input type="text" id="gotram" name="gotram"
                                   value="<?= epEscape($profile['gotram']) ?>"
                                   maxlength="100">
                        </div>

                        <div class="ep-field">
                            <label for="surname">Family Name / Surname</label>
                            <input type="text" id="surname" name="surname"
                                   value="<?= epEscape($profile['surname']) ?>"
                                   maxlength="100">
                        </div>
                    </div>
                </fieldset>

                <?php if ($communityLocked): ?>
                    <a href="/peoplelink/module-4/Frontend/pages/support.php?topic=community"
                       class="ep-request-link">
                        Request Community Information Change →
                    </a>
                <?php endif; ?>
            </section>

            <!-- Contact Information -->
            <section class="ep-card" id="contact">
                <div class="ep-section-heading">
                    <div class="ep-section-icon ep-orange">✉</div>
                    <div>
                        <h2>Contact Information</h2>
                        <p>Keep your contact details up to date.</p>
                    </div>
                </div>

                <div class="ep-form-grid">
                    <div class="ep-field">
                        <label for="mobile">Mobile Number <span>*</span></label>
                        <input type="tel" id="mobile" name="mobile"
                               value="<?= epEscape($profile['mobile']) ?>"
                               inputmode="tel" maxlength="15" required>
                        <small>Changes may require OTP verification.</small>
                    </div>

                    <div class="ep-field">
                        <label for="alternate_mobile">Alternate Mobile Number</label>
                        <input type="tel" id="alternate_mobile"
                               name="alternate_mobile"
                               value="<?= epEscape($profile['alternate_mobile']) ?>"
                               inputmode="tel" maxlength="15">
                    </div>

                    <div class="ep-field ep-full-width">
                        <label for="email">Email ID <span>*</span></label>
                        <input type="email" id="email" name="email"
                               value="<?= epEscape($profile['email']) ?>"
                               maxlength="190" autocomplete="email" required>
                        <small>Email changes may require verification.</small>
                    </div>
                </div>
            </section>

            <!-- Address -->
            <section class="ep-card" id="address">
                <div class="ep-section-heading">
                    <div class="ep-section-icon ep-blue">⌂</div>
                    <div>
                        <h2>Address</h2>
                        <p>Your residential address and location details.</p>
                    </div>
                </div>

                <div class="ep-form-grid">
                    <div class="ep-field ep-full-width">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3"
                                  maxlength="500"><?= epEscape($profile['address']) ?></textarea>
                    </div>

                    <div class="ep-field">
                        <label for="locality">Area / Locality</label>
                        <input type="text" id="locality" name="locality"
                               value="<?= epEscape($profile['locality']) ?>"
                               maxlength="150">
                    </div>

                    <div class="ep-field">
                        <label for="address_city">City</label>
                        <input type="text" id="address_city" name="address_city"
                               value="<?= epEscape($profile['city']) ?>"
                               maxlength="100">
                    </div>

                    <div class="ep-field">
                        <label for="state">State</label>
                        <input type="text" id="state" name="state"
                               value="<?= epEscape($profile['state']) ?>"
                               maxlength="100">
                    </div>

                    <div class="ep-field">
                        <label for="pincode">Pincode</label>
                        <input type="text" id="pincode" name="pincode"
                               value="<?= epEscape($profile['pincode']) ?>"
                               inputmode="numeric" maxlength="10">
                    </div>
                </div>
            </section>

            <!-- Privacy -->
            <section class="ep-card" id="visibility">
                <div class="ep-section-heading">
                    <div class="ep-section-icon ep-purple">♙</div>
                    <div>
                        <h2>Profile Visibility</h2>
                        <p>Choose which information other members can see.</p>
                    </div>
                </div>

                <?php
                $visibilityOptions = [
                    'show_mobile' => [
                        'Mobile Number',
                        'Allow authorized members to see your mobile number.'
                    ],
                    'show_email' => [
                        'Email Address',
                        'Allow authorized members to see your email.'
                    ],
                    'show_city' => [
                        'Current City',
                        'Display your city on your public profile.'
                    ],
                    'show_professional' => [
                        'Professional Details',
                        'Display your education and career information.'
                    ]
                ];
                ?>

                <div class="ep-visibility-list">
                    <?php foreach ($visibilityOptions as $name => $option): ?>
                        <label class="ep-visibility-row">
                            <span class="ep-visibility-text">
                                <strong><?= epEscape($option[0]) ?></strong>
                                <small><?= epEscape($option[1]) ?></small>
                            </span>

                            <span class="ep-switch">
                                <input type="checkbox"
                                       name="<?= epEscape($name) ?>"
                                       value="1"
                                       <?= !empty($profile[$name]) ? 'checked' : '' ?>>
                                <span class="ep-switch-slider"></span>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Form Actions -->
            <div class="ep-form-actions">
                <a href="my-profile.php" class="ep-btn ep-btn-light">
                    Cancel
                </a>

                <button type="submit" class="ep-btn ep-btn-primary"
                        id="epSaveButton">
                    <span>✓</span> Save Changes
                </button>
            </div>

        </form>

        <div class="ep-toast" id="epToast"
             role="status" aria-live="polite"></div>

    </div>
</main>
<style>.ep-alert{border-radius:12px;padding:14px 18px;margin:0 0 18px;font-size:15px}.ep-alert ul{margin:6px 0 0 18px;padding:0}.ep-alert-success{background:#e9f8ee;color:#17663a;border:1px solid #b9e6c8}.ep-alert-error{background:#fdecee;color:#9b1c2c;border:1px solid #f5c2c9}</style>

 

<?php include __DIR__ . '/footer.php'; ?>
