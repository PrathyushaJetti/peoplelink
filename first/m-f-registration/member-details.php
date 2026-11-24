<?php
// PeopleLink - Member Details: one family member (?id=). Owner sees everything; others follow the family privacy settings.
require_once __DIR__ . '/_family.php';
$fmRow = rows('SELECT * FROM family_members WHERE id=? AND community_id=?', [(int)($_GET['id'] ?? 0), $mfCid])[0] ?? null;
$fam = $fmRow ? mf_family($mfUid, $mfCid, (int)$fmRow['family_id']) : null;
if (!$fmRow && !isset($_GET['id'])) { // no id: show my own record (head of my family)
    $fam = mf_family($mfUid, $mfCid, null);
    $fmRow = $fam ? (rows('SELECT * FROM family_members WHERE family_id=? ORDER BY is_head DESC, id LIMIT 1', [$fam['id']])[0] ?? null) : null;
}
$B = $fam ? mf_bundle($fam, $mfUid) : null;
if (!$fmRow || !$B || (!$B['own'] && ($fmRow['status'] !== 'approved' || !$fmRow['is_active'] || empty($B['priv']['show_family_members'])))) {
    http_response_code(404); include 'header.php';
    echo '<main style="max-width:720px;margin:60px auto;padding:0 16px;text-align:center"><h1 style="font-size:28px">Member not found</h1><p>This member is not available or is waiting for approval.</p><p><a href="family-profile.php">Go to your family profile</a></p></main>';
    include 'footer.php'; exit;
}
$isHead = (int)$fmRow['is_head'] === 1; $h = $B['head'] ?? []; $md = $B['md'];
$member = [
    'id' => (int)$fmRow['id'],
    'photo' => $fmRow['photo'] ?: 'assets/images/default-member.png',
    'name' => $fmRow['full_name'],
    'relationship' => $isHead ? 'Head of Family' : $fmRow['relationship'],
    'community' => $mfComm['name'],
    'sub_community' => $md['sub_community'] ?? '',
    'gotram' => $B['fd']['gotram'] ?? ($md['gotram'] ?? ''),
    'city' => implode(', ', array_filter([$fam['city'], $fam['state']])),
    'status' => mf_status($fmRow['status']),
    'gender' => $fmRow['gender'],
    'dob' => $fmRow['dob'],
    'marital_status' => $fmRow['marital_status'],
    'blood_group' => $isHead ? ($md['blood_group'] ?? '') : '',
    'native_place' => $fam['native_place'],
    'education' => $fmRow['education'],
    'profession' => $fmRow['occupation'],
    'company' => $isHead ? ($md['company'] ?? '') : '',
    'designation' => $isHead ? ($md['designation'] ?? '') : '',
    'work_location' => '',
    'family_name' => $fam['family_name'],
    'primary_member' => $fam['head_name'],
    'father_name' => mf_rel($B['all'], 'Father'),
    'mother_name' => mf_rel($B['all'], 'Mother'),
    'spouse_name' => $isHead ? mf_rel($B['all'], 'Spouse') : '',
    'mobile' => $fmRow['phone'],
    'email' => $fmRow['email'],
    'address' => implode(', ', array_filter([$fam['area'], $fam['city'], $fam['state'], $fam['pincode']])),
    'show_mobile' => !empty($B['priv']['show_mobile']),
    'show_email' => !empty($B['priv']['show_email']),
    'show_address' => !empty($B['priv']['show_address']),
];
$member['age'] = !empty($member['dob']) ? (new DateTime($member['dob']))->diff(new DateTime())->y : null;
$isProfileOwner = $B['own'];
$isAuthorizedFamilyMember = false;
$canEdit = $isProfileOwner;
$isEligibleCommunityUser = (int)($mfUser['community_id'] ?? 0) === $mfCid; // logged-in member of the same community
$canContact = $isEligibleCommunityUser || $isProfileOwner;
$showMobile = $isProfileOwner || ($canContact && $member['show_mobile']);
$showEmail = $isProfileOwner || ($canContact && $member['show_email']);
$showAddress = $isProfileOwner || ($canContact && $member['show_address']);
$familyProfileUrl = 'family-profile.php' . ($B['own'] ? '' : '?family=' . (int)$fam['id']);
$editMemberUrl = 'member-family-registration.php';

function displayValue($value)
{
    return trim((string)$value) !== '' ? e($value) : 'Not provided';
}

?>



<?php

 include 'header.php';

?>

<main class="member-page">

    <div class="container">

        <!-- Breadcrumb -->
        <nav class="member-breadcrumb" aria-label="Breadcrumb">
            <a href="../community-home.php">
                <i class="bi bi-house-door"></i> Community
            </a>
            <i class="bi bi-chevron-right"></i>
            <a href="<?= e($familyProfileUrl) ?>">Family Profile</a>
            <i class="bi bi-chevron-right"></i>
            <span>Member Details</span>
        </nav>

        <!-- Page Heading -->
        <div class="member-page-heading">
            <div>
                <span class="section-eyebrow">PEOPLELINK COMMUNITY</span>
                <h1>Member Details</h1>
                <p>
                    View personal information, family relationships and
                    professional details.
                </p>
            </div>

            <a href="<?= e($familyProfileUrl) ?>" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Back to Family Profile
            </a>
        </div>

        <!-- Member Profile Header -->
        <section class="member-hero">

            <div class="member-hero-main">

                <div class="member-avatar">
                    <img
                        src="<?= e($member['photo']) ?>"
                        alt="<?= e($member['name']) ?>"
                        onerror="this.onerror=null;this.src='assets/images/default-member.png';"
                    >

                    <span class="avatar-status"
                          title="<?= e($member['status']) ?>"></span>
                </div>

                <div class="member-hero-info">

                    <div class="member-status-row">
                        <span class="status-badge">
                            <span class="status-dot"></span>
                            <?= e($member['status']) ?> Member
                        </span>

                        <span class="member-id">
                            Member ID: PL-<?= (int)$member['id'] ?>
                        </span>
                    </div>

                    <h2><?= e($member['name']) ?></h2>

                    <div class="member-quick-info">
                        <span>
                            <i class="bi bi-people"></i>
                            <?= e($member['relationship']) ?> in family
                        </span>

                        <span>
                            <i class="bi bi-diagram-3"></i>
                            <?= e($member['community']) ?>
                        </span>

                        <span>
                            <i class="bi bi-geo-alt"></i>
                            <?= e($member['city']) ?>
                        </span>
                    </div>

                </div>

            </div>

            <div class="member-hero-actions">

                <?php if ($canEdit): ?>
                    <a href="<?= e($editMemberUrl) ?>" class="btn-primary-action">
                        <i class="bi bi-pencil-square"></i>
                        Edit Member
                    </a>
                <?php endif; ?>

                <?php if ($canContact && ($showMobile || $showEmail)): ?>
                    <button type="button"
                            class="btn-outline-action"
                            id="contactToggle">
                        <i class="bi bi-person-lines-fill"></i>
                        Contact
                    </button>
                <?php endif; ?>

            </div>

        </section>

        <!-- Privacy Notice -->
        <div class="privacy-notice">
            <div class="privacy-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            <div>
                <h3>Privacy Protected</h3>
                <p>
                    Personal contact information is displayed according to
                    the member's privacy settings and your access permissions.
                </p>
            </div>
        </div>

        <!-- Main Layout -->
        <div class="row g-4 member-content-row">

            <div class="col-lg-8">

                <!-- Personal Information -->
                <section class="detail-card">

                    <div class="detail-card-heading">
                        <div class="detail-icon icon-blue">
                            <i class="bi bi-person-vcard"></i>
                        </div>

                        <div>
                            <h3>Personal Information</h3>
                            <p>Basic details about this family member</p>
                        </div>
                    </div>

                    <div class="detail-grid">

                        <div class="detail-item">
                            <span>Full Name</span>
                            <strong><?= e($member['name']) ?></strong>
                        </div>

                        <div class="detail-item">
                            <span>Gender</span>
                            <strong><?= displayValue($member['gender']) ?></strong>
                        </div>

                        <div class="detail-item">
                            <span>Date of Birth</span>
                            <strong>
                                <?= $member['dob']
                                    ? e(date('d M Y', strtotime($member['dob'])))
                                    : 'Not provided' ?>
                            </strong>
                        </div>

                        <div class="detail-item">
                            <span>Age</span>
                            <strong>
                                <?= $member['age'] !== null
                                    ? (int)$member['age'] . ' years'
                                    : 'Not provided' ?>
                            </strong>
                        </div>

                        <div class="detail-item">
                            <span>Marital Status</span>
                            <strong><?= displayValue($member['marital_status']) ?></strong>
                        </div>

                        <div class="detail-item">
                            <span>Blood Group</span>
                            <strong><?= displayValue($member['blood_group']) ?></strong>
                        </div>

                        <div class="detail-item detail-item-full">
                            <span>Native Place</span>
                            <strong>
                                <i class="bi bi-geo-alt detail-inline-icon"></i>
                                <?= displayValue($member['native_place']) ?>
                            </strong>
                        </div>

                    </div>

                </section>

                <!-- Education and Profession -->
                <section class="detail-card">

                    <div class="detail-card-heading">
                        <div class="detail-icon icon-green">
                            <i class="bi bi-mortarboard"></i>
                        </div>

                        <div>
                            <h3>Education & Profession</h3>
                            <p>Academic qualifications and career information</p>
                        </div>
                    </div>

                    <div class="detail-grid">

                        <div class="detail-item">
                            <span>Education</span>
                            <strong><?= displayValue($member['education']) ?></strong>
                        </div>

                        <div class="detail-item">
                            <span>Profession / Occupation</span>
                            <strong><?= displayValue($member['profession']) ?></strong>
                        </div>

                        <div class="detail-item">
                            <span>Company / Organisation</span>
                            <strong><?= displayValue($member['company']) ?></strong>
                        </div>

                        <div class="detail-item">
                            <span>Designation</span>
                            <strong><?= displayValue($member['designation']) ?></strong>
                        </div>

                        <div class="detail-item detail-item-full">
                            <span>Work Location</span>
                            <strong>
                                <i class="bi bi-briefcase detail-inline-icon"></i>
                                <?= displayValue($member['work_location']) ?>
                            </strong>
                        </div>

                    </div>

                </section>

                <!-- Family Relationships -->
                <section class="detail-card">

                    <div class="detail-card-heading">
                        <div class="detail-icon icon-purple">
                            <i class="bi bi-diagram-3"></i>
                        </div>

                        <div>
                            <h3>Family Relationship</h3>
                            <p>Family connections and relationship details</p>
                        </div>
                    </div>

                    <div class="detail-grid">

                        <div class="detail-item">
                            <span>Family Name / Surname</span>
                            <strong><?= displayValue($member['family_name']) ?></strong>
                        </div>

                        <div class="detail-item">
                            <span>Primary Member</span>
                            <strong><?= displayValue($member['primary_member']) ?></strong>
                        </div>

                        <div class="detail-item">
                            <span>Relationship</span>
                            <strong><?= displayValue($member['relationship']) ?></strong>
                        </div>

                        <div class="detail-item">
                            <span>Father's Name</span>
                            <strong><?= displayValue($member['father_name']) ?></strong>
                        </div>

                        <div class="detail-item">
                            <span>Mother's Name</span>
                            <strong><?= displayValue($member['mother_name']) ?></strong>
                        </div>

                        <?php if (!empty($member['spouse_name'])): ?>
                            <div class="detail-item">
                                <span>Spouse Name</span>
                                <strong><?= e($member['spouse_name']) ?></strong>
                            </div>
                        <?php endif; ?>

                    </div>

                </section>

                <!-- Community Information -->
                <section class="detail-card">

                    <div class="detail-card-heading">
                        <div class="detail-icon icon-orange">
                            <i class="bi bi-people"></i>
                        </div>

                        <div>
                            <h3>Community Information</h3>
                            <p>Community identity and traditional details</p>
                        </div>
                    </div>

                    <div class="detail-grid">

                        <div class="detail-item">
                            <span>Community</span>
                            <strong><?= displayValue($member['community']) ?></strong>
                        </div>

                        <div class="detail-item">
                            <span>Sub-Community</span>
                            <strong><?= displayValue($member['sub_community']) ?></strong>
                        </div>

                        <div class="detail-item">
                            <span>Gotram</span>
                            <strong><?= displayValue($member['gotram']) ?></strong>
                        </div>

                    </div>

                </section>

                <!-- Contact Information -->
                <section class="detail-card" id="contactInformation">

                    <div class="detail-card-heading">
                        <div class="detail-icon icon-teal">
                            <i class="bi bi-envelope-paper"></i>
                        </div>

                        <div>
                            <h3>Contact Details</h3>
                            <p>Available contact information and privacy controls</p>
                        </div>
                    </div>

                    <?php if ($showMobile || $showEmail || $showAddress): ?>

                        <div class="detail-grid">

                            <?php if ($showMobile): ?>
                                <div class="detail-item">
                                    <span>Mobile Number</span>
                                    <strong><?= e($member['mobile']) ?></strong>
                                </div>
                            <?php endif; ?>

                            <?php if ($showEmail): ?>
                                <div class="detail-item">
                                    <span>Email Address</span>
                                    <strong><?= e($member['email']) ?></strong>
                                </div>
                            <?php endif; ?>

                            <?php if ($showAddress): ?>
                                <div class="detail-item detail-item-full">
                                    <span>Current Address</span>
                                    <strong><?= e($member['address']) ?></strong>
                                </div>
                            <?php endif; ?>

                        </div>

                    <?php else: ?>

                        <div class="contact-restricted">
                            <div class="restricted-icon">
                                <i class="bi bi-lock"></i>
                            </div>

                            <div>
                                <h4>Contact information is private</h4>
                                <p>
                                    The member has not enabled contact details
                                    for your account. You can return to the
                                    family profile to continue browsing.
                                </p>
                            </div>
                        </div>

                    <?php endif; ?>

                </section>

            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-4">

                <!-- Family Summary -->
                <aside class="sidebar-card">

                    <div class="sidebar-card-heading">
                        <i class="bi bi-house-heart"></i>
                        <h3>Family Summary</h3>
                    </div>

                    <div class="family-summary-profile">
                        <div class="family-summary-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <div>
                            <h4><?= e($member['family_name']) ?></h4>
                            <p>Family Profile</p>
                        </div>
                    </div>

                    <div class="sidebar-info-row">
                        <span>Primary Member</span>
                        <strong><?= e($member['primary_member']) ?></strong>
                    </div>

                    <div class="sidebar-info-row">
                        <span>Community</span>
                        <strong><?= e($member['community']) ?></strong>
                    </div>

                    <div class="sidebar-info-row">
                        <span>Member Status</span>
                        <strong class="active-text">
                            <i class="bi bi-check-circle-fill"></i>
                            <?= e($member['status']) ?>
                        </strong>
                    </div>

                    <a href="<?= e($familyProfileUrl) ?>" class="sidebar-link">
                        View Family Profile
                        <i class="bi bi-arrow-up-right"></i>
                    </a>

                </aside>

                <!-- Privacy Sidebar -->
                <aside class="sidebar-card privacy-sidebar">

                    <div class="sidebar-card-heading">
                        <i class="bi bi-shield-check"></i>
                        <h3>Privacy & Access</h3>
                    </div>

                    <div class="privacy-point">
                        <i class="bi bi-check-circle"></i>
                        <span>Personal information is displayed according to access permissions.</span>
                    </div>

                    <div class="privacy-point">
                        <i class="bi bi-check-circle"></i>
                        <span>Contact details remain hidden unless the relevant settings allow access.</span>
                    </div>

                    <div class="privacy-point">
                        <i class="bi bi-check-circle"></i>
                        <span>Only authorised users can edit member information.</span>
                    </div>

                </aside>

                <!-- Quick Actions -->
                <aside class="sidebar-card">

                    <div class="sidebar-card-heading">
                        <i class="bi bi-lightning-charge"></i>
                        <h3>Quick Actions</h3>
                    </div>

                    <a href="<?= e($familyProfileUrl) ?>" class="quick-action">
                        <span class="quick-action-icon">
                            <i class="bi bi-arrow-left-circle"></i>
                        </span>

                        <span>
                            <strong>Back to Family Profile</strong>
                            <small>View all family members</small>
                        </span>

                        <i class="bi bi-chevron-right"></i>
                    </a>

                    <?php if ($canEdit): ?>
                        <a href="<?= e($editMemberUrl) ?>" class="quick-action">
                            <span class="quick-action-icon">
                                <i class="bi bi-pencil-square"></i>
                            </span>

                            <span>
                                <strong>Edit Member</strong>
                                <small>Update member information</small>
                            </span>

                            <i class="bi bi-chevron-right"></i>
                        </a>
                    <?php endif; ?>

                </aside>

            </div>

        </div>

        <!-- Bottom Navigation -->
        <div class="member-bottom-navigation">

            <a href="<?= e($familyProfileUrl) ?>" class="btn-back">
                <i class="bi bi-arrow-left"></i>
                Back to Family Profile
            </a>

            <?php if ($canEdit): ?>
                <a href="<?= e($editMemberUrl) ?>" class="btn-primary-action">
                    <i class="bi bi-pencil-square"></i>
                    Edit Member
                </a>
            <?php endif; ?>

        </div>

    </div>

</main>

<?php
 
  include 'footer.php';
 
?>

 
 