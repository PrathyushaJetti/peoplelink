<?php
// Submit / Edit Directory Profile (live: directory_create / directory_update, photos to the profile gallery, admin approval)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();
web_require_community();
$E = pl_entity('directory');
$dsEditId = (int)($_GET['edit'] ?? $_POST['edit_id'] ?? 0);
$dsEdit = $dsEditId ? pl_api_own($E, $dsEditId, $webUid) : null;
if ($dsEditId && !$dsEdit) { flash('Profile not found.', 'error'); header('Location: my-directory-listings.php'); exit; }
$dsCats = array_values(array_filter(pl_categories('directory'), fn($c) => !$c['parent_id']));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) { echo json_encode(['ok' => false, 'error' => 'Your session expired. Please refresh the page and try again.']); exit; }
    $in = $_POST; $biz = ($in['listing_type'] ?? '') === 'business';
    $catId = 0; foreach ($dsCats as $c) if (strcasecmp($c['name'], (string)($in['category'] ?? '')) === 0) $catId = (int)$c['id'];
    if (!$catId) { echo json_encode(['ok' => false, 'error' => 'Please choose a category.']); exit; }
    $sub = trim((string)($in['subcategory'] ?? ''));
    $subId = $sub !== '' ? (int)(rows("SELECT id FROM categories WHERE module='directory' AND parent_id=? AND LOWER(name)=LOWER(?) LIMIT 1", [$catId, $sub])[0]['id'] ?? 0) : 0;
    $t = fn($k) => trim((string)($in[$k] ?? ''));
    $map = [
        'profile_type' => $biz ? 'Business' : 'Professional',
        'name' => $biz ? ($t('contact_person') ?: $t('listing_name')) : ($t('full_name') ?: $t('listing_name')),
        'business_name' => $biz ? ($t('business_name') ?: $t('listing_name')) : $t('listing_name'),
        'category_id' => $catId, 'subcategory_id' => $subId ?: '',
        'description' => $t('short_description'),
        'experience_years' => $t('experience_years') !== '' ? (int)$t('experience_years') : '',
        'qualification' => $t('qualification'),
        'services' => $biz ? $t('business_services') : trim($t('specialization') . ($t('skills') !== '' ? ', ' . $t('skills') : ''), ', '),
        'address' => $t('address'), 'area' => $t('locality'), 'city' => $t('city'), 'state' => $t('state'), 'pincode' => $t('pincode'),
        'phone' => $t('mobile'), 'whatsapp' => $t('whatsapp'), 'email' => $t('email'), 'website' => $t('website') ?: $t('business_website'),
    ];
    // extra details shown on the profile page
    foreach (['specialization', 'designation', 'professional_experience', 'skills', 'languages', 'established_year', 'business_type', 'map_link', 'service_areas'] as $k) if ($t($k) !== '') $map[$k] = $t($k);
    if ($sub !== '' && !$subId) $map['speciality'] = $sub;
    if (!empty($in['service_mode'])) $map['service_mode'] = ucwords(implode(', ', (array)$in['service_mode']));
    $map['contact_privacy'] = isset($in['contact_privacy']) ? 'Show' : 'On request';
    // photo / logo -> the profile's main image; service images -> gallery
    $logo = $_FILES['business_logo'] ?? null; if (!$logo || ($logo['error'] ?? 4) === UPLOAD_ERR_NO_FILE) $logo = $_FILES['profile_photo'] ?? null;
    $files = [];
    if ($logo && ($logo['error'] ?? 4) !== UPLOAD_ERR_NO_FILE) $files['logo'] = $logo;
    if (!empty($_FILES['service_images'])) $files['service_images'] = $_FILES['service_images'];
    $_FILES = $files;
    if ($dsEdit) $map['id'] = $dsEditId;
    $_POST = ['csrf' => $in['csrf']];
    $r = web_call($dsEdit ? 'directory_update' : 'directory_create', $map + ['csrf' => $in['csrf']], true);
    if (!empty($r['error'])) { echo json_encode(['ok' => false, 'error' => $r['error']]); exit; }
    $id = (int)($r['id'] ?? $r['item']['id'] ?? $dsEditId);
    if ($dsEdit && pl_files_list(pl_api_files($E))) pl_media_add($E, $id, pl_api_files($E), $webUid);
    echo json_encode(['ok' => true, 'id' => $id, 'message' => $r['message'] ?? 'Saved.', 'upload_error' => $r['upload_error'] ?? null]); exit;
}

// form values: edit mode from the saved profile, otherwise the member's account details
if ($dsEdit) {
    $x = json_decode((string)($dsEdit['details'] ?? ''), true) ?: [];
    $biz = $dsEdit['profile_type'] === 'Business';
    $cat = $dsEdit['category_id'] ? (rows('SELECT name FROM categories WHERE id=?', [(int)$dsEdit['category_id']])[0]['name'] ?? '') : '';
    $sub = $dsEdit['subcategory_id'] ? (rows('SELECT name FROM categories WHERE id=?', [(int)$dsEdit['subcategory_id']])[0]['name'] ?? '') : ($x['speciality'] ?? '');
    $dsFill = array_intersect_key($x, array_flip(['specialization', 'designation', 'professional_experience', 'skills', 'languages', 'established_year', 'business_type', 'map_link', 'service_areas'])) + [
        'listing_type' => $biz ? 'business' : 'professional', 'listing_name' => $biz ? $dsEdit['business_name'] : ($dsEdit['business_name'] ?: $dsEdit['name']),
        'category' => $cat, 'subcategory' => $sub, 'short_description' => $dsEdit['description'], 'experience_years' => (string)($dsEdit['experience_years'] ?? ''),
        'qualification' => $dsEdit['qualification'], 'full_name' => $dsEdit['name'], 'contact_person' => $dsEdit['name'], 'business_name' => $dsEdit['business_name'],
        'business_services' => $dsEdit['services'], 'mobile' => preg_replace('/\D/', '', (string)$dsEdit['phone']), 'whatsapp' => preg_replace('/\D/', '', (string)$dsEdit['whatsapp']),
        'email' => $dsEdit['email'], 'website' => $dsEdit['website'], 'business_website' => $dsEdit['website'], 'address' => $dsEdit['address'],
        'locality' => $dsEdit['area'], 'city' => $dsEdit['city'], 'state' => $dsEdit['state'], 'pincode' => $dsEdit['pincode'],
        'service_mode' => array_map('strtolower', array_map('trim', explode(',', (string)($x['service_mode'] ?? '')))),
    ];
} else {
    $t0 = strtolower((string)($_GET['type'] ?? ''));
    $dsFill = ['full_name' => $webUser['name'] ?? '', 'contact_person' => $webUser['name'] ?? '', 'mobile' => preg_replace('/\D/', '', (string)($webUser['phone'] ?? '')), 'email' => $webUser['email'] ?? '']
        + (in_array($t0, ['professional', 'business'], true) ? ['listing_type' => $t0] : []);
}
include 'header.php'; ?>

<main class="pl-submit-listing-page">
    <section class="pl-submit-hero">
        <div class="pl-submit-container">
            <nav class="pl-submit-breadcrumb" aria-label="Breadcrumb">
                <a href="../community-home.php">Home</a>
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
                <a href="professional-and-business-directory-search-results.php">Directory</a>
                <i class="bi bi-chevron-right" aria-hidden="true"></i>
                <span>Add Your Listing</span>
            </nav>

            <div class="pl-submit-hero-grid">
                <div class="pl-submit-hero-copy">
                    <span class="pl-submit-eyebrow"><i class="bi bi-stars" aria-hidden="true"></i> PEOPLELINK DIRECTORY</span>
                    <h1>Put your work in the <span>community spotlight.</span></h1>
                    <p>Create a professional profile or showcase your business so people can discover your services, skills and expertise.</p>
                    <div class="pl-submit-hero-points">
                        <span><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Reach more people</span>
                        <span><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Build trusted connections</span>
                        <span><i class="bi bi-check-circle-fill" aria-hidden="true"></i> Manage your listing</span>
                    </div>
                </div>
                <div class="pl-submit-hero-art" aria-hidden="true">
                    <div class="pl-submit-art-orbit pl-orbit-one"></div>
                    <div class="pl-submit-art-orbit pl-orbit-two"></div>
                    <div class="pl-submit-art-card pl-art-card-main"><span class="pl-art-avatar"><i class="bi bi-person-workspace"></i></span><span><b>Your Profile</b><small>Skills &amp; experience</small></span><i class="bi bi-patch-check-fill pl-art-check"></i></div>
                    <div class="pl-submit-art-card pl-art-card-small"><span class="pl-art-building"><i class="bi bi-building"></i></span><span><b>Your Business</b><small>Services &amp; contact</small></span></div>
                    <span class="pl-submit-art-spark pl-spark-one"><i class="bi bi-stars"></i></span>
                    <span class="pl-submit-art-spark pl-spark-two"><i class="bi bi-people-fill"></i></span>
                </div>
            </div>
        </div>
    </section>

    <section class="pl-submit-content">
        <div class="pl-submit-container pl-submit-layout">
            <div class="pl-submit-main">
                <div class="pl-submit-section-intro">
                    <div><span class="pl-submit-step-label">CREATE YOUR DIRECTORY LISTING</span><h2>Add Your Listing</h2><p>Complete the details below. Fields marked <b>*</b> are required.</p></div>
                    <span class="pl-submit-progress-label" id="plProgressLabel">Step 1 of 4</span>
                </div>

                <div class="pl-submit-progress"><span id="plProgressBar"></span></div>

                <form id="plListingForm" class="pl-listing-form" novalidate>
                    <section class="pl-form-section" id="plSectionType">
                        <div class="pl-form-section-heading"><span class="pl-form-section-icon"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i></span><div><h3>1. Listing Type</h3><p>Choose what you want to add to the directory.</p></div></div>
                        <div class="pl-listing-type-options">
                            <label class="pl-listing-type-option is-selected" data-type-option="professional">
                                <input type="radio" name="listing_type" value="professional" checked>
                                <span class="pl-listing-type-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
                                <span class="pl-listing-type-copy"><strong>Professional</strong><small>Showcase your skills, experience and expertise.</small></span>
                                <span class="pl-type-radio-mark"><i class="bi bi-check-lg" aria-hidden="true"></i></span>
                            </label>
                            <label class="pl-listing-type-option" data-type-option="business">
                                <input type="radio" name="listing_type" value="business">
                                <span class="pl-listing-type-icon pl-business-icon"><i class="bi bi-building" aria-hidden="true"></i></span>
                                <span class="pl-listing-type-copy"><strong>Business</strong><small>Promote your company, services and business details.</small></span>
                                <span class="pl-type-radio-mark"><i class="bi bi-check-lg" aria-hidden="true"></i></span>
                            </label>
                        </div>
                    </section>

                    <section class="pl-form-section">
                        <div class="pl-form-section-heading"><span class="pl-form-section-icon"><i class="bi bi-card-text" aria-hidden="true"></i></span><div><h3>2. Basic Information</h3><p>Tell people what you do and what makes your listing useful.</p></div></div>
                        <div class="pl-form-grid">
                            <div class="pl-form-field pl-field-full"><label for="plListingName">Professional / Business Name <span>*</span></label><input id="plListingName" name="listing_name" type="text" placeholder="Enter professional or business name" required maxlength="120"><small class="pl-field-error"></small></div>
                            <div class="pl-form-field"><label for="plCategory">Category <span>*</span></label><select id="plCategory" name="category" required><option value="">Select category</option><?php foreach ($dsCats as $c): ?><option value="<?= h($c['name']) ?>"><?= h($c['name']) ?></option><?php endforeach; ?></select><small class="pl-field-error"></small></div>
                            <div class="pl-form-field"><label for="plSubcategory">Subcategory</label><input id="plSubcategory" name="subcategory" type="text" placeholder="e.g. Web Development"></div>
                            <div class="pl-form-field pl-field-full"><label for="plSpecialization">Main Service / Specialization <span>*</span></label><input id="plSpecialization" name="specialization" type="text" placeholder="What is your main service or speciality?" required maxlength="160"><small class="pl-field-error"></small></div>
                            <div class="pl-form-field pl-field-full"><label for="plShortDescription">Short Description <span>*</span></label><textarea id="plShortDescription" name="short_description" rows="4" maxlength="500" placeholder="Briefly describe your services, experience or business..." required></textarea><div class="pl-field-foot"><small class="pl-field-error"></small><small><span id="plDescriptionCount">0</span>/500 characters</small></div></div>
                            <div class="pl-form-field"><label for="plExperience">Years of Experience / Years in Business</label><input id="plExperience" name="experience_years" type="number" min="0" max="100" placeholder="e.g. 5"></div>
                        </div>
                    </section>

                    <section class="pl-form-section pl-conditional-section" id="plProfessionalFields">
                        <div class="pl-form-section-heading"><span class="pl-form-section-icon"><i class="bi bi-person-vcard" aria-hidden="true"></i></span><div><h3>3. Professional Details</h3><p>Share your professional background and skills.</p></div></div>
                        <div class="pl-form-grid">
                            <div class="pl-form-field"><label for="plFullName">Full Name <span>*</span></label><input id="plFullName" name="full_name" type="text" placeholder="Your full name" required></div>
                            <div class="pl-form-field"><label for="plDesignation">Profession / Designation <span>*</span></label><input id="plDesignation" name="designation" type="text" placeholder="e.g. Web Developer" required></div>
                            <div class="pl-form-field"><label for="plQualification">Qualification</label><input id="plQualification" name="qualification" type="text" placeholder="Degree, certification or qualification"></div>
                            <div class="pl-form-field"><label for="plProfessionalExperience">Experience</label><input id="plProfessionalExperience" name="professional_experience" type="number" min="0" max="100" placeholder="Years of experience"></div>
                            <div class="pl-form-field pl-field-full"><label for="plSkills">Skills / Specializations</label><input id="plSkills" name="skills" type="text" placeholder="e.g. PHP, WordPress, SEO"></div>
                            <div class="pl-form-field pl-field-full"><label for="plLanguages">Languages Known</label><input id="plLanguages" name="languages" type="text" placeholder="e.g. Hindi, English"></div>
                        </div>
                    </section>

                    <section class="pl-form-section pl-conditional-section" id="plBusinessFields" hidden>
                        <div class="pl-form-section-heading"><span class="pl-form-section-icon pl-icon-green"><i class="bi bi-buildings" aria-hidden="true"></i></span><div><h3>3. Business Details</h3><p>Share details that help customers understand your business.</p></div></div>
                        <div class="pl-form-grid">
                            <div class="pl-form-field"><label for="plBusinessName">Business Name <span>*</span></label><input id="plBusinessName" name="business_name" type="text" placeholder="Registered or public business name"></div>
                            <div class="pl-form-field"><label for="plContactPerson">Contact Person Name <span>*</span></label><input id="plContactPerson" name="contact_person" type="text" placeholder="Primary contact person"></div>
                            <div class="pl-form-field"><label for="plEstablishedYear">Established Year</label><input id="plEstablishedYear" name="established_year" type="number" min="1800" max="2100" placeholder="e.g. 2018"></div>
                            <div class="pl-form-field"><label for="plBusinessType">Business Type</label><select id="plBusinessType" name="business_type"><option value="">Select business type</option><option>Sole Proprietorship</option><option>Partnership</option><option>Private Limited Company</option><option>LLP</option><option>NGO / Non-profit</option><option>Other</option></select></div>
                            <div class="pl-form-field pl-field-full"><label for="plBusinessServices">Services Offered <span>*</span></label><textarea id="plBusinessServices" name="business_services" rows="3" placeholder="List your main services, separated by commas"></textarea></div>
                            <div class="pl-form-field pl-field-full"><label for="plBusinessWebsite">Business Website</label><input id="plBusinessWebsite" name="business_website" type="url" placeholder="https://yourwebsite.com"></div>
                        </div>
                    </section>

                    <section class="pl-form-section">
                        <div class="pl-form-section-heading"><span class="pl-form-section-icon"><i class="bi bi-telephone" aria-hidden="true"></i></span><div><h3>4. Contact Details</h3><p>How should people contact you about your listing?</p></div></div>
                        <div class="pl-form-grid">
                            <div class="pl-form-field"><label for="plMobile">Mobile Number <span>*</span></label><input id="plMobile" name="mobile" type="tel" inputmode="tel" autocomplete="tel" placeholder="Enter mobile number" required><small class="pl-field-error"></small></div>
                            <div class="pl-form-field"><label for="plWhatsapp">WhatsApp Number</label><input id="plWhatsapp" name="whatsapp" type="tel" inputmode="tel" placeholder="WhatsApp number (if different)"></div>
                            <div class="pl-form-field"><label for="plEmail">Email ID <span>*</span></label><input id="plEmail" name="email" type="email" autocomplete="email" placeholder="you@example.com" required><small class="pl-field-error"></small></div>
                            <div class="pl-form-field"><label for="plWebsite">Website (if available)</label><input id="plWebsite" name="website" type="url" placeholder="https://yourwebsite.com"></div>
                        </div>
                        <label class="pl-privacy-check"><input type="checkbox" name="contact_privacy" checked><span>Let PeopleLink display my contact details according to my account privacy settings.</span></label>
                    </section>

                    <section class="pl-form-section">
                        <div class="pl-form-section-heading"><span class="pl-form-section-icon"><i class="bi bi-geo-alt" aria-hidden="true"></i></span><div><h3>5. Location</h3><p>Help people find you and understand where you provide services.</p></div></div>
                        <div class="pl-form-grid">
                            <div class="pl-form-field pl-field-full"><label for="plAddress">Address</label><input id="plAddress" name="address" type="text" autocomplete="street-address" placeholder="Building, street or full address"></div>
                            <div class="pl-form-field"><label for="plLocality">Area / Locality</label><input id="plLocality" name="locality" type="text" placeholder="Area or neighbourhood"></div>
                            <div class="pl-form-field"><label for="plCity">City <span>*</span></label><input id="plCity" name="city" type="text" autocomplete="address-level2" placeholder="Enter city" required><small class="pl-field-error"></small></div>
                            <div class="pl-form-field"><label for="plState">State <span>*</span></label><select id="plState" name="state" required><option value="">Select state / UT</option><option>Andhra Pradesh</option><option>Arunachal Pradesh</option><option>Assam</option><option>Bihar</option><option>Chhattisgarh</option><option>Goa</option><option>Gujarat</option><option>Haryana</option><option>Himachal Pradesh</option><option>Jharkhand</option><option>Karnataka</option><option>Kerala</option><option>Madhya Pradesh</option><option>Maharashtra</option><option>Manipur</option><option>Meghalaya</option><option>Mizoram</option><option>Nagaland</option><option>Odisha</option><option>Punjab</option><option>Rajasthan</option><option>Sikkim</option><option>Tamil Nadu</option><option>Telangana</option><option>Tripura</option><option>Uttar Pradesh</option><option>Uttarakhand</option><option>West Bengal</option><option>Andaman and Nicobar Islands</option><option>Chandigarh</option><option>Dadra and Nagar Haveli and Daman and Diu</option><option>Delhi</option><option>Jammu and Kashmir</option><option>Ladakh</option><option>Lakshadweep</option><option>Puducherry</option></select><small class="pl-field-error"></small></div>
                            <div class="pl-form-field"><label for="plPincode">Pincode</label><input id="plPincode" name="pincode" type="text" inputmode="numeric" autocomplete="postal-code" maxlength="6" placeholder="6-digit pincode"></div>
                            <div class="pl-form-field pl-field-full"><label for="plMapLink">Map Pin / Google Maps Link</label><input id="plMapLink" name="map_link" type="url" placeholder="Paste a Google Maps link (optional)"></div>
                        </div>
                    </section>

                    <section class="pl-form-section">
                        <div class="pl-form-section-heading"><span class="pl-form-section-icon"><i class="bi bi-images" aria-hidden="true"></i></span><div><h3>6. Images &amp; Logo</h3><p>Add clear images to make your listing recognizable.</p></div></div>
                        <div class="pl-upload-grid">
                            <label class="pl-upload-box" for="plProfilePhoto"><span class="pl-upload-icon"><i class="bi bi-person-circle" aria-hidden="true"></i></span><strong>Profile Photo</strong><small>JPG, PNG or WebP · Max 5 MB</small><span class="pl-upload-action">Choose Photo</span><input id="plProfilePhoto" name="profile_photo" type="file" accept="image/jpeg,image/png,image/webp"><span class="pl-upload-filename" data-file-name="plProfilePhoto">No file selected</span></label>
                            <label class="pl-upload-box" for="plBusinessLogo"><span class="pl-upload-icon pl-upload-icon-green"><i class="bi bi-building" aria-hidden="true"></i></span><strong>Business Logo</strong><small>JPG, PNG or WebP · Max 5 MB</small><span class="pl-upload-action">Choose Logo</span><input id="plBusinessLogo" name="business_logo" type="file" accept="image/jpeg,image/png,image/webp"><span class="pl-upload-filename" data-file-name="plBusinessLogo">No file selected</span></label>
                            <label class="pl-upload-box" for="plServiceImages"><span class="pl-upload-icon pl-upload-icon-orange"><i class="bi bi-card-image" aria-hidden="true"></i></span><strong>Service Images</strong><small>Up to 5 images · JPG, PNG or WebP</small><span class="pl-upload-action">Choose Images</span><input id="plServiceImages" name="service_images[]" type="file" accept="image/jpeg,image/png,image/webp" multiple><span class="pl-upload-filename" data-file-name="plServiceImages">No files selected</span></label>
                        </div>
                        <p class="pl-upload-security-note"><i class="bi bi-shield-check" aria-hidden="true"></i> For security, the server should validate file type and size before saving uploads.</p>
                    </section>

                    <section class="pl-form-section">
                        <div class="pl-form-section-heading"><span class="pl-form-section-icon"><i class="bi bi-pin-map" aria-hidden="true"></i></span><div><h3>7. Service Areas</h3><p>Select where you are available to serve customers.</p></div></div>
                        <div class="pl-form-grid">
                            <div class="pl-form-field pl-field-full"><label for="plServiceAreas">Local Areas / Cities</label><input id="plServiceAreas" name="service_areas" type="text" placeholder="e.g. Rishikesh, Dehradun, Haridwar"></div>
                            <div class="pl-form-field pl-field-full"><label for="plServiceMode">Service Mode</label><div class="pl-service-mode-options"><label><input type="checkbox" name="service_mode[]" value="local" checked> Local / In-person</label><label><input type="checkbox" name="service_mode[]" value="remote"> Remote / Online</label><label><input type="checkbox" name="service_mode[]" value="nationwide"> Across India</label></div></div>
                        </div>
                    </section>

                    <section class="pl-form-section">
                        <div class="pl-form-section-heading"><span class="pl-form-section-icon"><i class="bi bi-people" aria-hidden="true"></i></span><div><h3>8. Community</h3><p>Your community is associated with your PeopleLink account.</p></div></div>
                        <div class="pl-community-info"><span><i class="bi bi-shield-check" aria-hidden="true"></i></span><div><strong>Community linked to your account</strong><p>Your selected community will be used for this listing. If it needs to be changed, update your account profile or contact support.</p></div><span class="pl-community-demo-value">Account-linked</span></div>
                    </section>

                    <div class="pl-submit-form-actions">
                        <button class="pl-button pl-button-outline" type="button" id="plPreviewButton"><i class="bi bi-eye" aria-hidden="true"></i> Preview Listing</button>
                        <div class="pl-submit-primary-actions">
                            <button class="pl-button pl-button-draft" type="button" id="plSaveDraft"><i class="bi bi-file-earmark" aria-hidden="true"></i> Save Draft</button>
                            <button class="pl-button pl-button-primary" type="submit"><i class="bi bi-send-check" aria-hidden="true"></i> Submit Listing</button>
                        </div>
                    </div>
                    <p class="pl-submit-terms"><i class="bi bi-info-circle" aria-hidden="true"></i> By submitting, you confirm that the information is accurate and agree to PeopleLink's listing guidelines.</p>
                </form>
            </div>

            <aside class="pl-submit-sidebar">
                <div class="pl-submit-sidebar-card pl-submit-tips-card">
                    <span class="pl-sidebar-card-icon"><i class="bi bi-lightbulb" aria-hidden="true"></i></span>
                    <h3>Tips for a strong listing</h3>
                    <ul><li><i class="bi bi-check2" aria-hidden="true"></i> Use a clear professional photo or logo.</li><li><i class="bi bi-check2" aria-hidden="true"></i> Describe your services in simple language.</li><li><i class="bi bi-check2" aria-hidden="true"></i> Keep your contact details up to date.</li><li><i class="bi bi-check2" aria-hidden="true"></i> Add service areas to improve discovery.</li></ul>
                </div>
                <div class="pl-submit-sidebar-card pl-submit-review-card">
                    <span class="pl-sidebar-card-icon pl-sidebar-icon-green"><i class="bi bi-patch-check" aria-hidden="true"></i></span>
                    <h3>Review &amp; approval</h3>
                    <p>Your listing may be reviewed before it appears publicly. You can save a draft and complete it later.</p>
                    <div class="pl-review-step"><span>1</span><div><strong>Submit details</strong><small>Complete your listing form.</small></div></div>
                    <div class="pl-review-step"><span>2</span><div><strong>Community review</strong><small>Approval, if required.</small></div></div>
                    <div class="pl-review-step"><span>3</span><div><strong>Go live</strong><small>People can discover your listing.</small></div></div>
                </div>
                <div class="pl-submit-sidebar-help"><i class="bi bi-headset" aria-hidden="true"></i><div><strong>Need help?</strong><p>Contact PeopleLink support if you need assistance creating your listing.</p><a href="../about.php">Contact Support <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a></div></div>
            </aside>
        </div>
    </section>

    <!-- Preview Modal -->
    <div class="pl-submit-modal-backdrop" id="plPreviewModal" hidden>
        <section class="pl-submit-modal" role="dialog" aria-modal="true" aria-labelledby="plPreviewTitle">
            <button class="pl-submit-modal-close" type="button" data-close-submit-modal aria-label="Close preview"><i class="bi bi-x-lg" aria-hidden="true"></i></button>
            <span class="pl-preview-modal-eyebrow"><i class="bi bi-eye" aria-hidden="true"></i> LISTING PREVIEW</span>
            <h2 id="plPreviewTitle">Review your listing</h2>
            <p class="pl-preview-modal-description">This is a preview of the details you have entered.</p>
            <div id="plPreviewContent" class="pl-preview-content"></div>
            <div class="pl-preview-modal-actions"><button type="button" class="pl-button pl-button-outline" data-close-submit-modal>Continue Editing</button><button type="button" class="pl-button pl-button-primary" id="plPreviewSubmit">Submit Listing</button></div>
        </section>
    </div>

    <!-- Submission / draft feedback -->
    <div class="pl-submit-feedback" id="plSubmitFeedback" role="status" aria-live="polite" hidden>
        <div class="pl-feedback-icon"><i class="bi bi-check-lg" aria-hidden="true"></i></div>
        <h2 id="plFeedbackTitle">Listing Submitted Successfully</h2>
        <p id="plFeedbackMessage">Your listing is under review and will be published after approval.</p>
        <button class="pl-button pl-button-primary" type="button" id="plFeedbackClose">Continue</button>
    </div>
    <div class="pl-submit-toast" id="plSubmitToast" role="status" aria-live="polite"></div>
</main>

<script>window.DS_EDIT_ID=<?= (int)($dsEdit['id'] ?? 0) ?>;window.DS_FILL=<?= json_encode($dsFill, JSON_HEX_TAG | JSON_HEX_AMP) ?>;</script>
<?php include 'footer.php'; ?>

