<?php
// PeopleLink – Member & Family Registration. Saved by submit-member-family-registration.php.
require_once dirname(__DIR__, 2) . '/matrimoney/includes/bridge.php';
pl_ensure_schema();
$mfUser = current_user();
if (!$mfUser) { header('Location: ' . DASHBOARD_URL . 'login.php?next=' . urlencode('/peoplelink/first/m-f-registration/member-family-registration.php')); exit; }
$mfUid = (int)$mfUser['id'];
$mfComm = pl_resolve_community($mfUid);
if (!$mfComm) { header('Location: ../community-page.php?next=' . urlencode('/peoplelink/first/m-f-registration/member-family-registration.php')); exit; } // choose a community first
$mfCid = (int)$mfComm['id'];
$selectedCommunity = $mfComm['name'];
$mfPrefs = json_decode($mfUser['prefs'] ?? '', true) ?: [];
$mfMsg = $_SESSION['mf_msg'] ?? ''; unset($_SESSION['mf_msg']);
$mfStatus = (string)($_GET['status'] ?? '');

// values to put back into the form: a saved draft first, otherwise what is already registered
$mfMember = rows('SELECT * FROM members WHERE user_id=? AND community_id=? ORDER BY id DESC LIMIT 1', [$mfUid, $mfCid])[0] ?? null;
$mfFamily = rows('SELECT * FROM families WHERE user_id=? AND community_id=? ORDER BY id DESC LIMIT 1', [$mfUid, $mfCid])[0] ?? null;
$mfFill = [];
if (!empty($mfPrefs['mf_draft']) && is_array($mfPrefs['mf_draft'])) $mfFill = $mfPrefs['mf_draft'];
elseif ($mfMember || $mfFamily) {
    $md = json_decode($mfMember['details'] ?? '', true) ?: []; $fd = json_decode($mfFamily['details'] ?? '', true) ?: [];
    $mfFill = [
        'primary' => ['full_name' => $mfMember['full_name'] ?? '', 'gender' => $mfMember['gender'] ?? '', 'date_of_birth' => $mfMember['dob'] ?? '', 'marital_status' => $mfMember['marital_status'] ?? '',
            'mobile' => $mfMember['phone'] ?? '', 'email' => $mfMember['email'] ?? '', 'occupation' => $mfMember['occupation'] ?? '', 'education' => $mfMember['education'] ?? '', 'blood_group' => $md['blood_group'] ?? ''],
        'community' => ['gotram' => $md['gotram'] ?? ($fd['gotram'] ?? ''), 'native_place' => $mfFamily['native_place'] ?? ($md['native_place'] ?? ''), 'current_city' => $mfMember['city'] ?? '', 'family_name' => $mfFamily['family_name'] ?? ($md['surname'] ?? '')],
        'address' => ['area' => $mfFamily['area'] ?? '', 'city' => $mfFamily['city'] ?? '', 'state' => $mfFamily['state'] ?? '', 'pincode' => $mfFamily['pincode'] ?? ''],
        'family' => ['primary_contact' => $fd['primary_contact'] ?? '', 'alternate_contact' => $fd['alternate_contact'] ?? '', 'email' => $fd['email'] ?? '', 'member_count' => $fd['member_count'] ?? ''],
        'privacy' => $fd['privacy'] ?? null,
        'members' => $mfFamily ? array_map(fn($m) => ['full_name' => $m['full_name'], 'relationship' => $m['relationship'], 'gender' => $m['gender'], 'date_of_birth' => $m['dob'],
            'mobile' => $m['phone'], 'education' => $m['education'], 'occupation' => $m['occupation'], 'marital_status' => $m['marital_status']],
            rows('SELECT * FROM family_members WHERE family_id=? AND is_head=0 ORDER BY id', [$mfFamily['id']])) : [],
    ];
} else {
    $mfFill = ['primary' => ['full_name' => $mfUser['name'], 'mobile' => $mfUser['phone'] ?? '', 'email' => $mfUser['email'], 'gender' => $mfUser['gender'] ?? '', 'date_of_birth' => $mfUser['dob'] ?? ''],
        'address' => ['city' => $mfUser['city'] ?? '', 'state' => $mfUser['state'] ?? '']];
}
$selectedGotram = $mfFill['community']['gotram'] ?? '';
?>

<?php include 'header.php'; ?>

 

<main class="pl-registration-page">

    <!-- Page Banner -->
    <section class="pl-reg-hero">
        <div class="pl-reg-hero-content">
            <span class="pl-reg-eyebrow">
                <i class="bi bi-people-fill"></i>
                PEOPLELINK COMMUNITY NETWORK
            </span>

            <h1>Member &amp; Family Registration</h1>

            <p>
                Connect your family with your community. Create a family profile,
                share your details, and become part of the PeopleLink network.
            </p>

            <div class="pl-reg-hero-points">
                <span><i class="bi bi-shield-check"></i> Privacy Controls</span>
                <span><i class="bi bi-person-plus"></i> Multiple Family Members</span>
                <span><i class="bi bi-patch-check"></i> Community Approval</span>
            </div>
        </div>

        <div class="pl-reg-hero-art" aria-hidden="true">
            <div class="pl-reg-art-circle pl-reg-art-circle-one"></div>
            <div class="pl-reg-art-circle pl-reg-art-circle-two"></div>
            <div class="pl-reg-family-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <span class="pl-reg-art-badge pl-reg-art-badge-one">
                <i class="bi bi-heart-fill"></i>
            </span>
            <span class="pl-reg-art-badge pl-reg-art-badge-two">
                <i class="bi bi-house-heart-fill"></i>
            </span>
        </div>
    </section>

    <section class="pl-reg-layout">

        <!-- Main Form -->
        <div class="pl-reg-main">

            <div class="pl-reg-intro-card">
                <div class="pl-reg-intro-icon">
                    <i class="bi bi-person-vcard-fill"></i>
                </div>
                <div>
                    <h2>Create Your Family Profile</h2>
                    <p>
                        Fields marked with <span class="pl-required">*</span>
                        are required. You can save your information as a draft
                        before submitting it for approval.
                    </p>
                </div>
            </div>

            <?php if ($mfStatus === 'submitted'): ?>
            <div class="pl-mf-alert ok" role="status"><i class="bi bi-check-circle-fill"></i>
                <div><strong>Registration submitted.</strong> Your member and family details are waiting for admin approval.
                    <a href="family-profile.php">View your family profile</a><?php if ($mfMsg): ?><br><?= nl2br(htmlspecialchars($mfMsg, ENT_QUOTES, 'UTF-8')) ?><?php endif; ?></div></div>
            <?php elseif ($mfStatus === 'draft_saved'): ?>
            <div class="pl-mf-alert ok" role="status"><i class="bi bi-check-circle-fill"></i><div><strong>Draft saved.</strong> You can finish and submit it any time.</div></div>
            <?php elseif ($mfStatus === 'error'): ?>
            <div class="pl-mf-alert err" role="alert"><i class="bi bi-exclamation-circle-fill"></i>
                <div><strong>Please fix the following:</strong><br><?= nl2br(htmlspecialchars($mfMsg ?: 'Your registration could not be processed.', ENT_QUOTES, 'UTF-8')) ?></div></div>
            <?php elseif ($mfFamily): ?>
            <div class="pl-mf-alert info" role="status"><i class="bi bi-info-circle-fill"></i>
                <div>You have already registered the <strong><?= htmlspecialchars($mfFamily['family_name'], ENT_QUOTES, 'UTF-8') ?></strong> family (status: <?= htmlspecialchars($mfFamily['status'], ENT_QUOTES, 'UTF-8') ?>).
                    Changes you submit here update it and are sent for approval again. <a href="family-profile.php">View family profile</a></div></div>
            <?php elseif ($mfStatus === 'nofamily' && !$mfFamily): ?>
            <div class="pl-mf-alert info" role="status"><i class="bi bi-info-circle-fill"></i><div>You have not registered a family yet. Fill in this form to create your family profile.</div></div>
            <?php elseif (!empty($mfPrefs['mf_draft'])): ?>
            <div class="pl-mf-alert info" role="status"><i class="bi bi-info-circle-fill"></i><div>Your saved draft has been loaded.</div></div>
            <?php endif; ?>

            <form
                id="memberFamilyForm"
                action="submit-member-family-registration.php"
                method="POST"
                enctype="multipart/form-data"
                novalidate
            >
                <input type="hidden" name="submission_mode" id="submissionMode" value="submit">
                <input type="hidden" name="csrf_token"
                       value="<?= htmlspecialchars($_SESSION['member_family_csrf'] ??= bin2hex(random_bytes(32)), ENT_QUOTES, 'UTF-8') ?>">

                <!-- 01: Primary Member -->
                <section class="pl-reg-section">
                    <div class="pl-reg-section-heading">
                        <span class="pl-reg-step">01</span>
                        <div>
                            <h3>Primary Member Details</h3>
                            <p>Enter the details of the main family member.</p>
                        </div>
                    </div>

                    <div class="pl-reg-grid">
                        <div class="pl-reg-field pl-reg-field-full">
                            <label for="primary_name">Full Name <span class="pl-required">*</span></label>
                            <input type="text" id="primary_name" name="primary[full_name]"
                                   placeholder="Enter your full name" required maxlength="150">
                        </div>

                        <div class="pl-reg-field">
                            <label for="primary_gender">Gender <span class="pl-required">*</span></label>
                            <select id="primary_gender" name="primary[gender]" required>
                                <option value="">Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                                <option value="Prefer not to say">Prefer not to say</option>
                            </select>
                        </div>

                        <div class="pl-reg-field">
                            <label for="primary_dob">Date of Birth <span class="pl-required">*</span></label>
                            <input type="date" id="primary_dob" name="primary[date_of_birth]" required max="<?= date('Y-m-d', strtotime('-18 years')) ?>">
                        </div>

                        <div class="pl-reg-field">
                            <label for="primary_marital">Marital Status <span class="pl-required">*</span></label>
                            <select id="primary_marital" name="primary[marital_status]" required>
                                <option value="">Select status</option>
                                <option>Single</option>
                                <option>Married</option>
                                <option>Widowed</option>
                                <option>Divorced</option>
                                <option>Separated</option>
                            </select>
                        </div>

                        <div class="pl-reg-field">
                            <label for="primary_mobile">Mobile Number <span class="pl-required">*</span></label>
                            <input type="tel" id="primary_mobile" name="primary[mobile]"
                                   placeholder="Enter mobile number" required maxlength="20"
                                   inputmode="tel">
                        </div>

                        <div class="pl-reg-field">
                            <label for="primary_email">Email ID</label>
                            <input type="email" id="primary_email" name="primary[email]"
                                   placeholder="you@example.com" maxlength="190">
                        </div>

                        <div class="pl-reg-field">
                            <label for="primary_occupation">Occupation / Profession</label>
                            <input type="text" id="primary_occupation" name="primary[occupation]"
                                   placeholder="e.g. Business owner, Teacher">
                        </div>

                        <div class="pl-reg-field">
                            <label for="primary_education">Education</label>
                            <input type="text" id="primary_education" name="primary[education]"
                                   placeholder="e.g. Graduate, MBA">
                        </div>

                        <div class="pl-reg-field">
                            <label for="primary_blood">Blood Group</label>
                            <select id="primary_blood" name="primary[blood_group]">
                                <option value="">Select blood group</option>
                                <option>A+</option><option>A-</option>
                                <option>B+</option><option>B-</option>
                                <option>AB+</option><option>AB-</option>
                                <option>O+</option><option>O-</option>
                                <option>Unknown</option>
                            </select>
                        </div>

                        <div class="pl-reg-field">
                            <label for="primary_photo">Profile Photo</label>
                            <input type="file" id="primary_photo" name="primary[profile_photo]"
                                   accept="image/jpeg,image/png,image/webp">
                            <small>JPG, PNG or WebP. Use a clear profile photo.</small>
                            <div class="pl-reg-photo-preview" id="primaryPhotoPreview"></div>
                        </div>
                    </div>
                </section>

                <!-- 02: Community -->
                <section class="pl-reg-section">
                    <div class="pl-reg-section-heading">
                        <span class="pl-reg-step">02</span>
                        <div>
                            <h3>Community Details</h3>
                            <p>Help community members identify your family profile.</p>
                        </div>
                    </div>

                    <div class="pl-reg-grid">
                        <div class="pl-reg-field">
                            <label for="community_name">Community Name <span class="pl-required">*</span></label>
                            <input type="text" id="community_name" name="community[name]"
                                   value="<?= htmlspecialchars($selectedCommunity, ENT_QUOTES, 'UTF-8') ?>"
                                   required maxlength="150" readonly>
                            <small>Your community is set on your account.</small>
                        </div>

                        <div class="pl-reg-field">
                            <label for="community_gotram">Sub-Community / Gotram</label>
                            <input type="text" id="community_gotram" name="community[gotram]"
                                   value="<?= htmlspecialchars($selectedGotram, ENT_QUOTES, 'UTF-8') ?>"
                                   placeholder="Enter gotram or sub-community">
                        </div>

                        <div class="pl-reg-field">
                            <label for="native_place">Native Place</label>
                            <input type="text" id="native_place" name="community[native_place]"
                                   placeholder="Village, town or ancestral place">
                        </div>

                        <div class="pl-reg-field">
                            <label for="current_city">Current City <span class="pl-required">*</span></label>
                            <input type="text" id="current_city" name="community[current_city]"
                                   placeholder="Your current city" required>
                        </div>

                        <div class="pl-reg-field pl-reg-field-full">
                            <label for="family_surname">Family Surname / Family Name <span class="pl-required">*</span></label>
                            <input type="text" id="family_surname" name="community[family_name]"
                                   placeholder="Enter family surname or family name" required maxlength="150">
                        </div>
                    </div>
                </section>

                <!-- 03: Address -->
                <section class="pl-reg-section">
                    <div class="pl-reg-section-heading">
                        <span class="pl-reg-step">03</span>
                        <div>
                            <h3>Address Details</h3>
                            <p>Your address can remain hidden according to your privacy settings.</p>
                        </div>
                    </div>

                    <div class="pl-reg-grid">
                        <div class="pl-reg-field">
                            <label for="address_house">House / Flat Number</label>
                            <input type="text" id="address_house" name="address[house_number]"
                                   placeholder="House or flat number">
                        </div>

                        <div class="pl-reg-field">
                            <label for="address_area">Area / Locality</label>
                            <input type="text" id="address_area" name="address[area]"
                                   placeholder="Area or locality">
                        </div>

                        <div class="pl-reg-field">
                            <label for="address_city">City <span class="pl-required">*</span></label>
                            <input type="text" id="address_city" name="address[city]"
                                   placeholder="City" required>
                        </div>

                        <div class="pl-reg-field">
                            <label for="address_state">State <span class="pl-required">*</span></label>
                            <input type="text" id="address_state" name="address[state]"
                                   placeholder="State" required>
                        </div>

                        <div class="pl-reg-field">
                            <label for="address_pincode">Pincode <span class="pl-required">*</span></label>
                            <input type="text" id="address_pincode" name="address[pincode]"
                                   placeholder="6-digit pincode" inputmode="numeric"
                                   maxlength="10" required>
                        </div>
                    </div>
                </section>

                <!-- 04: Family Information -->
                <section class="pl-reg-section">
                    <div class="pl-reg-section-heading">
                        <span class="pl-reg-step">04</span>
                        <div>
                            <h3>Family Information</h3>
                            <p>Provide basic information about your immediate family.</p>
                        </div>
                    </div>

                    <div class="pl-reg-grid">
                        <div class="pl-reg-field">
                            <label for="spouse_name">Spouse Name</label>
                            <input type="text" id="spouse_name" name="family[spouse_name]"
                                   placeholder="Spouse full name">
                        </div>

                        <div class="pl-reg-field">
                            <label for="father_name">Father Name</label>
                            <input type="text" id="father_name" name="family[father_name]"
                                   placeholder="Father full name">
                        </div>

                        <div class="pl-reg-field">
                            <label for="mother_name">Mother Name</label>
                            <input type="text" id="mother_name" name="family[mother_name]"
                                   placeholder="Mother full name">
                        </div>

                        <div class="pl-reg-field">
                            <label for="family_count">Number of Family Members</label>
                            <input type="number" id="family_count" name="family[member_count]"
                                   min="1" max="100" value="1">
                            <small>Includes the primary member.</small>
                        </div>
                    </div>
                </section>

                <!-- 05: Additional Family Members -->
                <section class="pl-reg-section">
                    <div class="pl-reg-section-heading pl-reg-section-heading-between">
                        <div class="pl-reg-heading-left">
                            <span class="pl-reg-step">05</span>
                            <div>
                                <h3>Add Family Members</h3>
                                <p>Add the family members you want to include in your profile.</p>
                            </div>
                        </div>

                        <button type="button" class="pl-reg-btn pl-reg-btn-outline" id="addFamilyMember">
                            <i class="bi bi-person-plus-fill"></i>
                            Add Family Member
                        </button>
                    </div>

                    <div id="familyMembersContainer"></div>

                    <div class="pl-reg-empty-family" id="emptyFamilyMessage">
                        <i class="bi bi-people"></i>
                        <p>No additional family members added yet.</p>
                        <span>Use “Add Family Member” to include another person.</span>
                    </div>

                    <template id="familyMemberTemplate">
                        <div class="pl-reg-family-member">
                            <div class="pl-reg-family-member-header">
                                <div class="pl-reg-family-member-title">
                                    <span class="pl-reg-member-number">Family Member</span>
                                    <span class="pl-reg-member-subtitle">Member details</span>
                                </div>
                                <button type="button" class="pl-reg-remove-member" aria-label="Remove family member">
                                    <i class="bi bi-trash3"></i> Remove
                                </button>
                            </div>

                            <div class="pl-reg-grid">
                                <div class="pl-reg-field pl-reg-field-full">
                                    <label>Full Name <span class="pl-required">*</span></label>
                                    <input type="text" data-name="full_name"
                                           placeholder="Family member full name" required maxlength="150">
                                </div>

                                <div class="pl-reg-field">
                                    <label>Relationship <span class="pl-required">*</span></label>
                                    <select data-name="relationship" required>
                                        <option value="">Select relationship</option>
                                        <option>Spouse</option>
                                        <option>Son</option>
                                        <option>Daughter</option>
                                        <option>Father</option>
                                        <option>Mother</option>
                                        <option>Brother</option>
                                        <option>Sister</option>
                                        <option>Grandfather</option>
                                        <option>Grandmother</option>
                                        <option>Grandson</option>
                                        <option>Granddaughter</option>
                                        <option>Other</option>
                                    </select>
                                </div>

                                <div class="pl-reg-field">
                                    <label>Gender</label>
                                    <select data-name="gender">
                                        <option value="">Select gender</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                        <option>Other</option>
                                        <option>Prefer not to say</option>
                                    </select>
                                </div>

                                <div class="pl-reg-field">
                                    <label>Date of Birth</label>
                                    <input type="date" data-name="date_of_birth">
                                </div>

                                <div class="pl-reg-field">
                                    <label>Mobile Number</label>
                                    <input type="tel" data-name="mobile"
                                           placeholder="Optional mobile number" maxlength="20">
                                </div>

                                <div class="pl-reg-field">
                                    <label>Education</label>
                                    <input type="text" data-name="education" placeholder="Education">
                                </div>

                                <div class="pl-reg-field">
                                    <label>Profession / Occupation</label>
                                    <input type="text" data-name="occupation" placeholder="Profession or occupation">
                                </div>

                                <div class="pl-reg-field">
                                    <label>Marital Status</label>
                                    <select data-name="marital_status">
                                        <option value="">Select status</option>
                                        <option>Single</option>
                                        <option>Married</option>
                                        <option>Widowed</option>
                                        <option>Divorced</option>
                                        <option>Separated</option>
                                    </select>
                                </div>

                                <div class="pl-reg-field pl-reg-field-full">
                                    <label>Profile Photo (Optional)</label>
                                    <input type="file" data-name="profile_photo"
                                           accept="image/jpeg,image/png,image/webp">
                                    <small>Use JPG, PNG or WebP image files.</small>
                                </div>
                            </div>
                        </div>
                    </template>
                </section>

                <!-- 06: Family Contact -->
                <section class="pl-reg-section">
                    <div class="pl-reg-section-heading">
                        <span class="pl-reg-step">06</span>
                        <div>
                            <h3>Family Contact Details</h3>
                            <p>Choose the contact details that represent your family.</p>
                        </div>
                    </div>

                    <div class="pl-reg-grid">
                        <div class="pl-reg-field">
                            <label for="family_primary_contact">Primary Contact Number <span class="pl-required">*</span></label>
                            <input type="tel" id="family_primary_contact" name="family[primary_contact]"
                                   placeholder="Primary family contact" required maxlength="20">
                        </div>

                        <div class="pl-reg-field">
                            <label for="family_alternate_contact">Alternate Contact Number</label>
                            <input type="tel" id="family_alternate_contact" name="family[alternate_contact]"
                                   placeholder="Alternate contact" maxlength="20">
                        </div>

                        <div class="pl-reg-field pl-reg-field-full">
                            <label for="family_email">Family Email (Optional)</label>
                            <input type="email" id="family_email" name="family[email]"
                                   placeholder="family@example.com" maxlength="190">
                        </div>
                    </div>
                </section>

                <!-- 07: Privacy -->
                <section class="pl-reg-section">
                    <div class="pl-reg-section-heading">
                        <span class="pl-reg-step">07</span>
                        <div>
                            <h3>Privacy Settings</h3>
                            <p>You decide which details are visible to other community members.</p>
                        </div>
                    </div>

                    <div class="pl-reg-privacy-list">
                        <label class="pl-reg-privacy-item">
                            <span class="pl-reg-privacy-icon"><i class="bi bi-telephone"></i></span>
                            <span class="pl-reg-privacy-copy">
                                <strong>Show Mobile Number</strong>
                                <small>Allow community members to see your mobile number.</small>
                            </span>
                            <input type="checkbox" name="privacy[show_mobile]" value="1">
                            <span class="pl-reg-switch"></span>
                        </label>

                        <label class="pl-reg-privacy-item">
                            <span class="pl-reg-privacy-icon"><i class="bi bi-envelope"></i></span>
                            <span class="pl-reg-privacy-copy">
                                <strong>Show Email</strong>
                                <small>Display your email address on your community profile.</small>
                            </span>
                            <input type="checkbox" name="privacy[show_email]" value="1">
                            <span class="pl-reg-switch"></span>
                        </label>

                        <label class="pl-reg-privacy-item">
                            <span class="pl-reg-privacy-icon"><i class="bi bi-geo-alt"></i></span>
                            <span class="pl-reg-privacy-copy">
                                <strong>Show Address</strong>
                                <small>Allow others to view your address details.</small>
                            </span>
                            <input type="checkbox" name="privacy[show_address]" value="1">
                            <span class="pl-reg-switch"></span>
                        </label>

                        <label class="pl-reg-privacy-item">
                            <span class="pl-reg-privacy-icon"><i class="bi bi-people"></i></span>
                            <span class="pl-reg-privacy-copy">
                                <strong>Show Family Members</strong>
                                <small>Display family member profiles to the community.</small>
                            </span>
                            <input type="checkbox" name="privacy[show_family_members]" value="1" checked>
                            <span class="pl-reg-switch"></span>
                        </label>

                        <label class="pl-reg-privacy-item">
                            <span class="pl-reg-privacy-icon"><i class="bi bi-chat-dots"></i></span>
                            <span class="pl-reg-privacy-copy">
                                <strong>Allow Community Members to Contact</strong>
                                <small>Allow members to contact you through permitted channels.</small>
                            </span>
                            <input type="checkbox" name="privacy[allow_contact]" value="1" checked>
                            <span class="pl-reg-switch"></span>
                        </label>
                    </div>

                    <div class="pl-reg-privacy-note">
                        <i class="bi bi-shield-lock-fill"></i>
                        <p>
                            Privacy preferences should be enforced by the server when displaying
                            your profile. Unchecked fields must not be exposed publicly.
                        </p>
                    </div>
                </section>

                <!-- Consent -->
                <div class="pl-reg-consent">
                    <label>
                        <input type="checkbox" id="registrationConsent" name="consent" value="1" required>
                        <span>
                            I confirm that the information provided is accurate and that I am
                            authorized to submit the family details included in this registration.
                            <span class="pl-required">*</span>
                        </span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="pl-reg-actions">
                    <button type="button" class="pl-reg-btn pl-reg-btn-preview" id="previewFamilyProfile">
                        <i class="bi bi-eye"></i> Preview Family Profile
                    </button>

                    <div class="pl-reg-submit-actions">
                        <button type="submit" class="pl-reg-btn pl-reg-btn-draft" id="saveDraftButton">
                            <i class="bi bi-file-earmark"></i> Save Draft
                        </button>

                        <button type="submit" class="pl-reg-btn pl-reg-btn-primary" id="submitRegistrationButton">
                            Submit Registration <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <p class="pl-reg-form-note">
                    <i class="bi bi-info-circle"></i>
                    Submitting this form sends your registration for review. Your profile
                    should become active only after any required approval.
                </p>
            </form>
        </div>

        <!-- Sidebar -->
        <aside class="pl-reg-sidebar">
            <div class="pl-reg-side-card pl-reg-progress-card">
                <div class="pl-reg-side-icon"><i class="bi bi-clipboard2-check"></i></div>
                <h3>Registration Checklist</h3>
                <p>Complete your profile in a few simple steps.</p>

                <ul class="pl-reg-checklist">
                    <li><span>1</span> Primary member details</li>
                    <li><span>2</span> Community information</li>
                    <li><span>3</span> Address and family details</li>
                    <li><span>4</span> Add family members</li>
                    <li><span>5</span> Set privacy preferences</li>
                    <li><span>6</span> Preview and submit</li>
                </ul>
            </div>

            <div class="pl-reg-side-card pl-reg-benefits-card">
                <h3><i class="bi bi-stars"></i> Why Join PeopleLink?</h3>
                <div class="pl-reg-benefit">
                    <span><i class="bi bi-people-fill"></i></span>
                    <div><strong>Community Connections</strong><small>Build meaningful connections with community members.</small></div>
                </div>
                <div class="pl-reg-benefit">
                    <span><i class="bi bi-person-lines-fill"></i></span>
                    <div><strong>Family Profile</strong><small>Keep family information organized in one place.</small></div>
                </div>
                <div class="pl-reg-benefit">
                    <span><i class="bi bi-lock-fill"></i></span>
                    <div><strong>Privacy Choices</strong><small>Control the details visible on your profile.</small></div>
                </div>
            </div>

            <div class="pl-reg-side-help">
                <i class="bi bi-headset"></i>
                <div>
                    <h3>Need Help?</h3>
                    <p>If you need assistance with registration, contact the PeopleLink support team.</p>
                    <a href="contact.php">Contact Support <i class="bi bi-arrow-up-right"></i></a>
                </div>
            </div>
        </aside>
    </section>
</main>

<!-- Preview Modal -->
<div class="pl-reg-modal" id="familyPreviewModal" aria-hidden="true">
    <div class="pl-reg-modal-backdrop" data-close-preview></div>

    <div class="pl-reg-modal-dialog" role="dialog" aria-modal="true"
         aria-labelledby="previewModalTitle">
        <div class="pl-reg-modal-header">
            <div>
                <span class="pl-reg-modal-kicker">PEOPLELINK PROFILE</span>
                <h2 id="previewModalTitle">Preview Family Profile</h2>
            </div>
            <button type="button" class="pl-reg-modal-close" data-close-preview aria-label="Close preview">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="pl-reg-preview-content" id="familyPreviewContent"></div>

        <div class="pl-reg-modal-footer">
            <button type="button" class="pl-reg-btn pl-reg-btn-draft" data-close-preview>
                Continue Editing
            </button>
            <button type="button" class="pl-reg-btn pl-reg-btn-primary" id="previewSubmitButton">
                Submit Registration <i class="bi bi-arrow-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="pl-reg-toast" id="registrationToast" role="status" aria-live="polite"></div>
<style>
.pl-mf-alert{display:flex;gap:12px;align-items:flex-start;border-radius:14px;padding:14px 18px;margin:0 0 18px;font-size:15px;line-height:1.55}
.pl-mf-alert>i{font-size:20px;margin-top:1px}.pl-mf-alert a{font-weight:700;color:inherit;text-decoration:underline}
.pl-mf-alert.ok{background:#e9f8ee;color:#17663a;border:1px solid #b9e6c8}.pl-mf-alert.err{background:#fdecee;color:#9b1c2c;border:1px solid #f5c2c9}.pl-mf-alert.info{background:#eaf3fc;color:#0b4f8c;border:1px solid #c3dcf5}
</style>
<script>
/* Fills the form with the saved draft or the registered details. */
window.addEventListener('load', function () {
    var data = <?= json_encode($mfFill, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?>;
    var form = document.getElementById('memberFamilyForm'); if (!form || !data) return;
    function put(name, value) {
        var els = form.querySelectorAll('[name="' + name.replace(/"/g, '') + '"]');
        els.forEach(function (el) {
            if (el.type === 'file' || el.readOnly) return;
            if (el.type === 'checkbox') el.checked = value === true || value === '1' || value === 1;
            else if (value !== null && value !== undefined && value !== '') el.value = value;
        });
    }
    ['primary', 'community', 'address', 'family'].forEach(function (g) { var o = data[g] || {}; Object.keys(o).forEach(function (k) { put(g + '[' + k + ']', o[k]); }); });
    if (data.privacy) ['show_mobile', 'show_email', 'show_address', 'show_family_members', 'allow_contact'].forEach(function (k) { put('privacy[' + k + ']', !!data.privacy[k]); });
    var list = Array.isArray(data.members) ? data.members : Object.values(data.members || {});
    var add = document.getElementById('addFamilyMember');
    list.forEach(function (m, i) {
        if (!add) return; add.click();
        Object.keys(m || {}).forEach(function (k) { put('members[' + i + '][' + k + ']', m[k]); });
    });
    if (list.length) setTimeout(function () { window.scrollTo(0, 0); if (document.activeElement) document.activeElement.blur(); }, 50);
});
</script>

 

<?php include 'footer.php'; ?>