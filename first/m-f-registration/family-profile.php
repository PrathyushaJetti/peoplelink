<?php
// PeopleLink - Family Profile: my family, or ?family=ID for another approved family of my community.
require_once __DIR__ . '/_family.php';

$fam = mf_family($mfUid, $mfCid, isset($_GET['family']) ? (int)$_GET['family'] : null);
if (!$fam && isset($_GET['family'])) { header('Location: family-profile.php'); exit; } // that family is not available
if (!$fam) mf_no_family($mfUser, $mfComm);
$B = mf_bundle($fam, $mfUid);
$isOwner = $B['own'];

// owner saves the privacy switches
$fpFlash = $_SESSION['fp_flash'] ?? null; unset($_SESSION['fp_flash']);
if ($isOwner && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (hash_equals((string)($_SESSION['family_privacy_csrf'] ?? ''), (string)($_POST['csrf_token'] ?? ''))) {
        $p = (array)($_POST['privacy'] ?? []);
        $B['fd']['privacy'] = array_combine(['show_mobile', 'show_email', 'show_address', 'show_family_members', 'allow_contact'], array_map(fn($k) => !empty($p[$k]), ['show_mobile', 'show_email', 'show_address', 'show_family_members', 'allow_contact']));
        db()->prepare('UPDATE families SET details=? WHERE id=?')->execute([json_encode($B['fd'], JSON_UNESCAPED_UNICODE), $fam['id']]);
        if ($B['head']) db()->prepare('UPDATE members SET family_visibility=?, contact_visibility=? WHERE id=?')->execute([$B['fd']['privacy']['show_family_members'] ? 'members' : 'private', ($B['fd']['privacy']['show_mobile'] || $B['fd']['privacy']['show_email']) ? 'members' : 'private', $B['head']['id']]);
        $_SESSION['fp_flash'] = 'Privacy settings saved.';
    } else $_SESSION['fp_flash'] = 'Your session expired. Please try again.';
    header('Location: family-profile.php'); exit;
}

$h = $B['head'] ?? []; $md = $B['md']; $fd = $B['fd']; $self = $B['self'] ?? [];
$family = [
    'id' => (int)$fam['id'],
    'family_name' => $fam['family_name'] . (stripos($fam['family_name'], 'family') === false ? ' Family' : ''),
    'primary_name' => $fam['head_name'],
    'photo' => $h['photo'] ?? ($self['photo'] ?? ''),
    'community' => $mfComm['name'],
    'sub_community' => $md['sub_community'] ?? '',
    'gotram' => $fd['gotram'] ?? ($md['gotram'] ?? ''),
    'native_place' => $fam['native_place'],
    'current_city' => $h['city'] ?? $fam['city'],
    'gender' => $h['gender'] ?? ($self['gender'] ?? ''),
    'dob' => $h['dob'] ?? ($self['dob'] ?? ''),
    'marital_status' => $h['marital_status'] ?? '',
    'education' => $h['education'] ?? '',
    'occupation' => $h['occupation'] ?? '',
    'mobile' => $h['phone'] ?? '',
    'email' => $h['email'] ?? '',
    'blood_group' => $md['blood_group'] ?? '',
    'father_name' => mf_rel($B['all'], 'Father'),
    'mother_name' => mf_rel($B['all'], 'Mother'),
    'spouse_name' => mf_rel($B['all'], 'Spouse'),
    'primary_contact' => $fd['primary_contact'] ?? '',
    'alternate_contact' => $fd['alternate_contact'] ?? '',
    'family_email' => $fd['email'] ?? '',
    'house_number' => '',
    'area' => $fam['area'],
    'city' => $fam['city'],
    'state' => $fam['state'],
    'pincode' => $fam['pincode'],
    'status' => mf_status($fam['status']),
] + $B['priv'];
$members = array_map(fn($m) => ['id' => (int)$m['id'], 'name' => $m['full_name'], 'relationship' => $m['relationship'], 'photo' => $m['photo'] ?? '', 'dob' => $m['dob'],
    'education' => $m['education'], 'occupation' => $m['occupation'], 'marital_status' => $m['marital_status'], 'status' => mf_status($m['status'])], $B['others']);
function fp_h($value) {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function fp_date($date) {
    if (!$date) return 'Not provided';

    try {
        return (new DateTime($date))->format('d M Y');
    } catch (Exception $e) {
        return 'Not provided';
    }
}

function fp_age($date) {
    if (!$date) return '';

    try {
        return (new DateTime($date))->diff(new DateTime())->y;
    } catch (Exception $e) {
        return '';
    }
}

function fp_status_class($status) {
    $status = strtolower(trim((string)$status));

    $map = [
        'active' => 'active',
        'pending approval' => 'pending',
        'incomplete' => 'incomplete',
        'inactive' => 'inactive'
    ];

    return $map[$status] ?? 'inactive';
}

function fp_photo($path) {
    /*
     * In production, use only validated image paths from your database.
     * Consider serving images through a controlled media endpoint.
     */
    return !empty($path) ? $path : '';
}

$memberCount = count($members) + 1;
$familyAddress = trim(
    implode(', ', array_filter([
        $family['house_number'],
        $family['area'],
        $family['city'],
        $family['state'],
        $family['pincode']
    ]))
);

$profileStatus = $family['status'] ?: 'Incomplete';
$canShowFamilyMembers = $isOwner || !empty($family['show_family_members']);
$canShowMobile = $isOwner || !empty($family['show_mobile']);
$canShowEmail = $isOwner || !empty($family['show_email']);
$canShowAddress = $isOwner || !empty($family['show_address']);
$canShowContactOption = $isOwner || !empty($family['allow_contact']);

?>

<?php include 'header.php'; ?>



<main class="pl-family-profile">
<?php if ($fpFlash): ?><div style="max-width:1200px;margin:18px auto 0;padding:0 16px"><div style="background:#e9f8ee;color:#17663a;border:1px solid #b9e6c8;border-radius:12px;padding:12px 16px;font-weight:600"><i class="bi bi-check-circle"></i> <?= fp_h($fpFlash) ?></div></div><?php endif; ?>

    <!-- Family Profile Banner -->
    <section class="fp-hero">
        <div class="fp-hero-inner">
            <div class="fp-breadcrumb">
                <a href="../community-home.php">Community</a>
                <i class="bi bi-chevron-right"></i>
                <span>Family Profile</span>
            </div>

            <span class="fp-eyebrow">
                <i class="bi bi-people-fill"></i>
                PEOPLELINK FAMILY NETWORK
            </span>

            <h1>Family Profile</h1>
            <p>
                Discover your family’s community connections and keep important
                family information organized in one place.
            </p>

            <div class="fp-hero-tags">
                <span><i class="bi bi-shield-check"></i> Privacy-aware profile</span>
                <span><i class="bi bi-person-check"></i> Community membership</span>
            </div>
        </div>

        <div class="fp-hero-decoration" aria-hidden="true">
            <i class="bi bi-people-fill"></i>
        </div>
    </section>

    <div class="fp-container">

        <!-- Family Header Card -->
        <section class="fp-family-header">
            <div class="fp-family-identity">
                <div class="fp-family-photo">
                    <?php if (fp_photo($family['photo'])): ?>
                        <img src="<?= fp_h(fp_photo($family['photo'])) ?>"
                             alt="<?= fp_h($family['family_name']) ?>"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                        <span class="fp-avatar-fallback" style="display:none">
                            <i class="bi bi-people-fill"></i>
                        </span>
                    <?php else: ?>
                        <span class="fp-avatar-fallback">
                            <i class="bi bi-people-fill"></i>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="fp-family-heading">
                    <div class="fp-status-line">
                        <span class="fp-status <?= fp_status_class($profileStatus) ?>">
                            <span></span><?= fp_h($profileStatus) ?>
                        </span>
                        <span class="fp-profile-label">Family Profile</span>
                    </div>

                    <h2><?= fp_h($family['family_name']) ?></h2>

                    <p class="fp-primary-name">
                        <i class="bi bi-person-fill"></i>
                        Primary Member: <strong><?= fp_h($family['primary_name']) ?></strong>
                    </p>

                    <div class="fp-family-meta">
                        <span><i class="bi bi-people"></i><?= fp_h($family['community']) ?></span>
                        <span><i class="bi bi-geo-alt"></i><?= fp_h($family['native_place']) ?></span>
                        <span><i class="bi bi-building"></i><?= fp_h($family['current_city']) ?></span>
                    </div>
                </div>
            </div>

            <div class="fp-family-count">
                <div class="fp-count-icon"><i class="bi bi-people-fill"></i></div>
                <strong><?= (int)$memberCount ?></strong>
                <span>Family Members</span>
            </div>

            <?php if ($isOwner): ?>
                <div class="fp-header-actions">
                    <a class="fp-btn fp-btn-light" href="member-family-registration.php">
                        <i class="bi bi-pencil-square"></i> Edit Family Profile
                    </a>
                    <a class="fp-btn fp-btn-primary" href="member-family-registration.php">
                        <i class="bi bi-person-plus-fill"></i> Add Family Member
                    </a>
                </div>
            <?php endif; ?>
        </section>

        <div class="fp-content-layout">

            <!-- Main Content -->
            <div class="fp-main-column">

                <!-- Primary Member Information -->
                <section class="fp-card">
                    <div class="fp-card-heading">
                        <div class="fp-heading-icon blue"><i class="bi bi-person-vcard-fill"></i></div>
                        <div>
                            <h3>Primary Member Information</h3>
                            <p>Personal and professional details of the primary member.</p>
                        </div>
                    </div>

                    <div class="fp-info-grid">
                        <div class="fp-info-item">
                            <span>Full Name</span>
                            <strong><?= fp_h($family['primary_name']) ?></strong>
                        </div>
                        <div class="fp-info-item">
                            <span>Gender</span>
                            <strong><?= fp_h($family['gender']) ?></strong>
                        </div>
                        <div class="fp-info-item">
                            <span>Date of Birth</span>
                            <strong><?= fp_h(fp_date($family['dob'])) ?></strong>
                        </div>
                        <div class="fp-info-item">
                            <span>Marital Status</span>
                            <strong><?= fp_h($family['marital_status']) ?></strong>
                        </div>
                        <div class="fp-info-item">
                            <span>Education</span>
                            <strong><?= fp_h($family['education'] ?: 'Not provided') ?></strong>
                        </div>
                        <div class="fp-info-item">
                            <span>Profession / Occupation</span>
                            <strong><?= fp_h($family['occupation'] ?: 'Not provided') ?></strong>
                        </div>

                        <?php if ($canShowMobile): ?>
                            <div class="fp-info-item">
                                <span>Mobile Number</span>
                                <strong><?= fp_h($family['mobile'] ?: 'Not provided') ?></strong>
                            </div>
                        <?php endif; ?>

                        <?php if ($canShowEmail): ?>
                            <div class="fp-info-item">
                                <span>Email ID</span>
                                <strong class="fp-break-word"><?= fp_h($family['email'] ?: 'Not provided') ?></strong>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($family['blood_group'])): ?>
                            <div class="fp-info-item">
                                <span>Blood Group</span>
                                <strong class="fp-blood-group"><?= fp_h($family['blood_group']) ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Family Details -->
                <section class="fp-card">
                    <div class="fp-card-heading">
                        <div class="fp-heading-icon green"><i class="bi bi-house-heart-fill"></i></div>
                        <div>
                            <h3>Family Details</h3>
                            <p>Family relationships and community background.</p>
                        </div>
                    </div>

                    <div class="fp-info-grid">
                        <div class="fp-info-item">
                            <span>Father Name</span>
                            <strong><?= fp_h($family['father_name'] ?: 'Not provided') ?></strong>
                        </div>
                        <div class="fp-info-item">
                            <span>Mother Name</span>
                            <strong><?= fp_h($family['mother_name'] ?: 'Not provided') ?></strong>
                        </div>

                        <?php if (!empty($family['spouse_name'])): ?>
                            <div class="fp-info-item">
                                <span>Spouse Name</span>
                                <strong><?= fp_h($family['spouse_name']) ?></strong>
                            </div>
                        <?php endif; ?>

                        <div class="fp-info-item">
                            <span>Family Surname</span>
                            <strong><?= fp_h($family['family_name']) ?></strong>
                        </div>
                        <div class="fp-info-item">
                            <span>Native Place</span>
                            <strong><?= fp_h($family['native_place']) ?></strong>
                        </div>
                        <div class="fp-info-item">
                            <span>Community</span>
                            <strong><?= fp_h($family['community']) ?></strong>
                        </div>
                        <?php if (!empty($family['sub_community'])): ?>
                            <div class="fp-info-item">
                                <span>Sub-Community</span>
                                <strong><?= fp_h($family['sub_community']) ?></strong>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($family['gotram'])): ?>
                            <div class="fp-info-item">
                                <span>Gotram</span>
                                <strong><?= fp_h($family['gotram']) ?></strong>
                            </div>
                        <?php endif; ?>
                        <?php if ($canShowAddress): ?>
                            <div class="fp-info-item fp-info-full">
                                <span>Current Address</span>
                                <strong><?= fp_h($familyAddress ?: 'Not provided') ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Family Members -->
                <section class="fp-card">
                    <div class="fp-card-heading fp-card-heading-between">
                        <div class="fp-card-title-group">
                            <div class="fp-heading-icon purple"><i class="bi bi-people-fill"></i></div>
                            <div>
                                <h3>Family Members</h3>
                                <p>Meet the members connected to this family profile.</p>
                            </div>
                        </div>

                        <span class="fp-member-count"><?= (int)count($members) ?> additional</span>
                    </div>

                    <?php if ($canShowFamilyMembers): ?>

                        <?php if (!empty($members)): ?>
                            <div class="fp-members-grid">
                                <?php foreach ($members as $member): ?>
                                    <article class="fp-member-card">
                                        <div class="fp-member-top">
                                            <div class="fp-member-photo">
                                                <?php if (fp_photo($member['photo'] ?? '')): ?>
                                                    <img src="<?= fp_h(fp_photo($member['photo'])) ?>"
                                                         alt="<?= fp_h($member['name']) ?>"
                                                         loading="lazy"
                                                         onerror="this.style.display='none';this.nextElementSibling.style.display='grid';">
                                                    <span class="fp-member-avatar-fallback" style="display:none">
                                                        <i class="bi bi-person-fill"></i>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="fp-member-avatar-fallback">
                                                        <i class="bi bi-person-fill"></i>
                                                    </span>
                                                <?php endif; ?>
                                            </div>

                                            <span class="fp-relationship">
                                                <?= fp_h($member['relationship']) ?>
                                            </span>
                                        </div>

                                        <h4><?= fp_h($member['name']) ?></h4>

                                        <div class="fp-member-detail">
                                            <span><i class="bi bi-calendar3"></i> Date of Birth</span>
                                            <strong>
                                                <?= fp_h(fp_date($member['dob'] ?? '')) ?>
                                                <?php if (!empty($member['dob'])): ?>
                                                    <small>(<?= (int)fp_age($member['dob']) ?> yrs)</small>
                                                <?php endif; ?>
                                            </strong>
                                        </div>

                                        <div class="fp-member-detail">
                                            <span><i class="bi bi-mortarboard"></i> Education</span>
                                            <strong><?= fp_h($member['education'] ?: 'Not provided') ?></strong>
                                        </div>

                                        <div class="fp-member-detail">
                                            <span><i class="bi bi-briefcase"></i> Profession</span>
                                            <strong><?= fp_h($member['occupation'] ?: 'Not provided') ?></strong>
                                        </div>

                                        <div class="fp-member-detail">
                                            <span><i class="bi bi-person-check"></i> Marital Status</span>
                                            <strong><?= fp_h($member['marital_status'] ?: 'Not provided') ?></strong>
                                        </div>

                                        <a class="fp-view-member"
                                           href="member-details.php?id=<?= (int)$member['id'] ?>">
                                            View Member <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="fp-empty-state">
                                <i class="bi bi-people"></i>
                                <h4>No additional family members</h4>
                                <p>Additional family members will appear here when they are added to the profile.</p>
                                <?php if ($isOwner): ?>
                                    <a href="member-family-registration.php" class="fp-btn fp-btn-primary">
                                        <i class="bi bi-person-plus"></i> Add Family Member
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="fp-private-state">
                            <i class="bi bi-lock-fill"></i>
                            <div>
                                <h4>Family members are private</h4>
                                <p>The family profile owner has chosen not to display family members publicly.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </section>

                <!-- Contact Information -->
                <section class="fp-card">
                    <div class="fp-card-heading">
                        <div class="fp-heading-icon orange"><i class="bi bi-person-lines-fill"></i></div>
                        <div>
                            <h3>Contact Information</h3>
                            <p>Contact information shown according to the family’s privacy settings.</p>
                        </div>
                    </div>

                    <div class="fp-contact-grid">
                        <?php if ($canShowMobile): ?>
                            <div class="fp-contact-item">
                                <span class="fp-contact-icon"><i class="bi bi-telephone-fill"></i></span>
                                <div>
                                    <small>Primary Contact</small>
                                    <strong><?= fp_h($family['primary_contact'] ?: 'Not provided') ?></strong>
                                </div>
                            </div>

                            <?php if (!empty($family['alternate_contact'])): ?>
                                <div class="fp-contact-item">
                                    <span class="fp-contact-icon"><i class="bi bi-phone"></i></span>
                                    <div>
                                        <small>Alternate Contact</small>
                                        <strong><?= fp_h($family['alternate_contact']) ?></strong>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($canShowEmail): ?>
                            <div class="fp-contact-item">
                                <span class="fp-contact-icon"><i class="bi bi-envelope-fill"></i></span>
                                <div>
                                    <small>Family Email</small>
                                    <strong class="fp-break-word"><?= fp_h($family['family_email'] ?: $family['email'] ?: 'Not provided') ?></strong>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($canShowAddress): ?>
                            <div class="fp-contact-item fp-contact-item-full">
                                <span class="fp-contact-icon"><i class="bi bi-geo-alt-fill"></i></span>
                                <div>
                                    <small>Family Address</small>
                                    <strong><?= fp_h($familyAddress ?: 'Not provided') ?></strong>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!$canShowMobile && !$canShowEmail && !$canShowAddress): ?>
                            <div class="fp-private-state fp-private-state-full">
                                <i class="bi bi-shield-lock-fill"></i>
                                <div>
                                    <h4>Contact details are private</h4>
                                    <p>This family has chosen not to display contact information publicly.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!$isOwner && $canShowContactOption && !empty($family['allow_contact'])): ?>
                        <div class="fp-contact-cta">
                            <div>
                                <strong>Would you like to connect with this family?</strong>
                                <p>Send a message through PeopleLink.</p>
                            </div>
                            <a href="#familyContact"
                               class="fp-btn fp-btn-primary">
                                <i class="bi bi-chat-dots-fill"></i> Contact Family
                            </a>
                        </div>
                    <?php endif; ?>
                </section>

            </div>

            <!-- Sidebar -->
            <aside class="fp-sidebar">

                <section class="fp-side-card fp-status-card">
                    <div class="fp-side-card-heading">
                        <span class="fp-side-icon"><i class="bi bi-patch-check-fill"></i></span>
                        <h3>Family Profile Status</h3>
                    </div>

                    <div class="fp-large-status <?= fp_status_class($profileStatus) ?>">
                        <span></span>
                        <?= fp_h($profileStatus) ?>
                    </div>

                    <p>
                        <?php if ($profileStatus === 'Active'): ?>
                            This family profile is active in the PeopleLink community.
                        <?php elseif ($profileStatus === 'Pending Approval'): ?>
                            Your profile is awaiting review by the community administrator.
                        <?php elseif ($profileStatus === 'Incomplete'): ?>
                            Some required profile information may still need to be completed.
                        <?php else: ?>
                            This family profile is currently inactive.
                        <?php endif; ?>
                    </p>

                    <?php if ($isOwner && $profileStatus === 'Incomplete'): ?>
                        <a href="member-family-registration.php" class="fp-side-link">
                            Complete Profile <i class="bi bi-arrow-right"></i>
                        </a>
                    <?php endif; ?>
                </section>

                <!-- Privacy Controls: Owner only -->
                <?php if ($isOwner): ?>
                    <section class="fp-side-card fp-privacy-card">
                        <div class="fp-side-card-heading">
                            <span class="fp-side-icon green"><i class="bi bi-shield-lock-fill"></i></span>
                            <h3>Privacy Controls</h3>
                        </div>

                        <p class="fp-side-description">
                            Choose which information community members can see.
                        </p>

                        <form action="family-profile.php" method="POST" id="familyPrivacyForm">
                            <input type="hidden" name="csrf_token"
                                   value="<?= fp_h($_SESSION['family_privacy_csrf'] ??= bin2hex(random_bytes(32))) ?>">
                            <input type="hidden" name="family_id" value="<?= (int)$family['id'] ?>">

                            <?php
                            $privacyControls = [
                                'show_mobile' => ['Mobile Number', 'bi-telephone'],
                                'show_email' => ['Email Address', 'bi-envelope'],
                                'show_address' => ['Family Address', 'bi-geo-alt'],
                                'show_family_members' => ['Family Members', 'bi-people'],
                                'allow_contact' => ['Allow Contact Option', 'bi-chat-dots']
                            ];
                            ?>

                            <div class="fp-privacy-controls">
                                <?php foreach ($privacyControls as $key => $control): ?>
                                    <label class="fp-privacy-toggle">
                                        <span class="fp-privacy-label">
                                            <i class="bi <?= fp_h($control[1]) ?>"></i>
                                            <?= fp_h($control[0]) ?>
                                        </span>

                                        <input type="checkbox"
                                               name="privacy[<?= fp_h($key) ?>]"
                                               value="1"
                                               <?= !empty($family[$key]) ? 'checked' : '' ?>>

                                        <span class="fp-toggle-track"></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <button type="submit" class="fp-btn fp-btn-primary fp-save-privacy">
                                <i class="bi bi-shield-check"></i> Save Privacy Settings
                            </button>
                        </form>

                        <p class="fp-privacy-note">
                            <i class="bi bi-info-circle"></i>
                            Settings should be enforced on the server, not just hidden in the interface.
                        </p>
                    </section>
                <?php endif; ?>

                <section class="fp-side-card fp-quick-actions">
                    <div class="fp-side-card-heading">
                        <span class="fp-side-icon purple"><i class="bi bi-lightning-charge-fill"></i></span>
                        <h3>Quick Actions</h3>
                    </div>

                    <?php if ($isOwner): ?>
                        <a href="member-family-registration.php">
                            <span><i class="bi bi-pencil-square"></i></span>
                            <span><strong>Edit Profile</strong><small>Update family information</small></span>
                            <i class="bi bi-chevron-right"></i>
                        </a>

                        <a href="family-members.php<?= $isOwner ? '' : '?family=' . (int)$family['id'] ?>">
                            <span><i class="bi bi-people-fill"></i></span>
                            <span><strong>Manage Family Members</strong><small>Add or update members</small></span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    <?php endif; ?>

                    <button type="button" id="previewFamilyProfile" class="fp-quick-action-button">
                        <span><i class="bi bi-eye-fill"></i></span>
                        <span><strong>Preview Profile</strong><small>See the profile summary</small></span>
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </section>

                <section class="fp-help-card">
                    <div class="fp-help-graphic"><i class="bi bi-heart-fill"></i></div>
                    <h3>Stay Connected</h3>
                    <p>PeopleLink helps families stay connected with their community and discover meaningful relationships.</p>
                    <a href="../community-home.php">Explore Community <i class="bi bi-arrow-right"></i></a>
                </section>

            </aside>
        </div>

    </div>
</main>

<!-- Profile Preview Modal -->
<div class="fp-preview-modal" id="familyProfilePreviewModal" aria-hidden="true">
    <div class="fp-preview-backdrop" data-close-family-preview></div>

    <div class="fp-preview-dialog" role="dialog" aria-modal="true"
         aria-labelledby="fpPreviewTitle">
        <div class="fp-preview-header">
            <div>
                <span>PEOPLELINK FAMILY NETWORK</span>
                <h2 id="fpPreviewTitle">Family Profile Preview</h2>
            </div>
            <button type="button" class="fp-preview-close" data-close-family-preview
                    aria-label="Close preview">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="fp-preview-body">
            <div class="fp-preview-family-banner">
                <div class="fp-preview-family-avatar"><i class="bi bi-people-fill"></i></div>
                <div>
                    <h3><?= fp_h($family['family_name']) ?></h3>
                    <p><?= fp_h($family['community']) ?></p>
                    <span><?= fp_h($family['current_city']) ?></span>
                </div>
            </div>

            <div class="fp-preview-summary">
                <div><small>Primary Member</small><strong><?= fp_h($family['primary_name']) ?></strong></div>
                <div><small>Native Place</small><strong><?= fp_h($family['native_place']) ?></strong></div>
                <div><small>Family Members</small><strong><?= (int)$memberCount ?></strong></div>
                <div><small>Profile Status</small><strong><?= fp_h($profileStatus) ?></strong></div>
            </div>

            <p class="fp-preview-disclaimer">
                This is a summary preview. The information displayed to other community members
                must follow the saved privacy settings.
            </p>
        </div>

        <div class="fp-preview-footer">
            <button type="button" class="fp-btn fp-btn-light" data-close-family-preview>
                Close Preview
            </button>
            <?php if ($isOwner): ?>
                <a href="member-family-registration.php"
                   class="fp-btn fp-btn-primary">
                    <i class="bi bi-pencil-square"></i> Edit Profile
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="fp-toast" id="familyProfileToast" role="status" aria-live="polite"></div>


<?php include 'footer.php'; ?>