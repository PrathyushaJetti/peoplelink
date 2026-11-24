<?php
// My Profile: real data of the logged-in user (account + community member profile).
require_once __DIR__ . '/_account.php';
include __DIR__ . '/header.php';

$acDetails = json_decode($acMember['details'] ?? '', true) ?: [];
$d = fn(string $k) => trim((string)($acDetails[$k] ?? ''));
$cityLine = implode(', ', array_filter([ac_val('city'), ac_val('state')]));
$memberStatus = $acMember['status'] ?? null;
$visLabels = ['public' => 'Public', 'members' => 'Members Only', 'private' => 'Only Me'];

$profile = [
    'id'              => $acMember ? 'PL-M-' . str_pad((string)$acMember['id'], 5, '0', STR_PAD_LEFT) : 'PL-U-' . str_pad((string)$acUid, 5, '0', STR_PAD_LEFT),
    'full_name'       => ac_val('full_name') ?: $acUser['name'],
    'photo'           => ac_val('photo') ?: 'assets/images/default-profile.png',
    'community'       => $acComm['name'] ?? 'No community selected',
    'sub_community'   => $d('sub_community'),
    'gotram'          => $d('gotram') ?: $d('gotra'),
    'surname'         => $d('surname'),
    'gender'          => ac_val('gender'),
    'dob'             => ac_date(ac_val('dob')),
    'marital_status'  => $acMember['marital_status'] ?? '',
    'mobile'          => ac_val('phone'),
    'email'           => ac_val('email'),
    'city'            => $cityLine,
    'native_place'    => $d('native_place'),
    'education'       => $acMember['education'] ?? '',
    'profession'      => $acMember['occupation'] ?? '',
    'company'         => $d('company'),
    'designation'     => $d('designation'),
    'account_status'  => ucfirst($acUser['status'] ?? 'active') . ($memberStatus && $memberStatus !== 'approved' ? ' · member profile ' . $memberStatus : ''),
    'visibility'      => $visLabels[$acMember['profile_visibility'] ?? ($acPrefs['profile_visibility'] ?? 'members')] ?? 'Members Only',
];
$__fill = ['full_name', 'photo', 'gender', 'dob', 'marital_status', 'mobile', 'email', 'city', 'native_place', 'education', 'profession', 'company', 'designation', 'gotram', 'surname'];
$profile['completion'] = (int)round(100 * count(array_filter($__fill, fn($k) => $profile[$k] !== '' && $profile[$k] !== null && $profile[$k] !== 'assets/images/default-profile.png')) / count($__fill));


$linkedSections = [
    [
        'title' => 'Matrimony Profile',
        'description' => 'Manage your matrimonial information',
        'icon' => 'heart',
        'url' => '/peoplelink/module-4/Frontend/pages/my-profile.php',
        'class' => 'matrimony'
    ],
    [
        'title' => 'Family Profile',
        'description' => 'View and update family details',
        'icon' => 'users',
        'url' => '../m-f-registration/family-profile.php',
        'class' => 'family'
    ],
    [
        'title' => 'My Jobs',
        'description' => 'Your job posts and applications',
        'icon' => 'briefcase-business',
        'url' => '../job/my-posted-jobs.php',
        'class' => 'jobs'
    ],
    [
        'title' => 'My Directory Listings',
        'description' => 'Manage professional listings',
        'icon' => 'building-2',
        'url' => '../professional-and-business-directory.php',
        'class' => 'directory'
    ],
    [
        'title' => 'My Marketplace Listings',
        'description' => 'Manage your marketplace posts',
        'icon' => 'store',
        'url' => '../marketplace/my-marketplace-listings.php',
        'class' => 'marketplace'
    ],
    [
        'title' => 'My Events / Ads',
        'description' => 'Manage events and advertisements',
        'icon' => 'calendar-days',
        'url' => '../events-ads/my-events-ads.php',
        'class' => 'events'
    ],
    [
        'title' => 'My Support Requests',
        'description' => 'View your support conversations',
        'icon' => 'headset',
        'url' => '../community/my-support-requests.php',
        'class' => 'support'
    ]
];

$accountSummary = [
    [
        'label' => 'Saved Items',
        'value' => (string)(ac_count('SELECT COUNT(*) FROM favourites WHERE user_id=?', [$acUid]) + ac_count('SELECT COUNT(*) FROM matrimony_saved WHERE user_id=?', [$acUid]) + ac_count('SELECT COUNT(*) FROM saved_jobs WHERE user_id=?', [$acUid])),
        'icon' => 'bookmark',
        'url' => '../saved-profiles.php'
    ],
    [
        'label' => 'Active Packages',
        'value' => (string)ac_count("SELECT COUNT(*) FROM user_packages WHERE user_id=? AND status='active' AND (expires_at IS NULL OR expires_at>NOW())", [$acUid]),
        'icon' => 'package',
        'url' => '/peoplelink/module-4/Frontend/pages/packages.php'
    ],
    [
        'label' => 'Recent Payments',
        'value' => (string)ac_count('SELECT COUNT(*) FROM transactions WHERE user_id=?', [$acUid]),
        'icon' => 'wallet',
        'url' => '../payment/my-payments.php'
    ]
];

function profileEscape($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$completion = max(0, min(100, (int)$profile['completion']));

$personalFields = [
    ['Full Name', 'full_name'],
    ['Gender', 'gender'],
    ['Date of Birth', 'dob'],
    ['Marital Status', 'marital_status'],
    ['Mobile Number', 'mobile'],
    ['Email ID', 'email'],
    ['Current City', 'city'],
    ['Native Place', 'native_place']
];

$professionalFields = [
    ['Education', 'education'],
    ['Profession / Occupation', 'profession'],
    ['Company / Organisation', 'company'],
    ['Designation', 'designation']
];

$communityFields = [
    ['Community', 'community'],
    ['Sub-Community', 'sub_community'],
    ['Gotram', 'gotram'],
    ['Family Name / Surname', 'surname']
];
?>

 

<main class="profile-page">

    <div class="profile-container">

        <!-- Breadcrumb -->
        <nav class="profile-breadcrumb" aria-label="Breadcrumb">
            <a href="../index.php">Home</a>
            <span>/</span>
            <a href="../index.php">Dashboard</a>
            <span>/</span>
            <span>My Profile</span>
        </nav>

        <!-- Page Heading -->
        <div class="profile-page-heading">
            <div>
                <span class="profile-eyebrow">YOUR PEOPLELINK ACCOUNT</span>
                <h1>My Profile</h1>
                <p>Manage your identity, personal information and community connections.</p>
            </div>

            <a href="account-settings.php" class="profile-settings-btn">
                <span class="profile-settings-symbol">⚙</span>
                Account Settings
            </a>
        </div>

        <!-- Profile Header -->
        <section class="profile-hero">

            <div class="profile-hero-main">

                <div class="profile-photo-wrap">
                    <img
                        src="<?= profileEscape($profile['photo']) ?>"
                        alt="Profile photo of <?= profileEscape($profile['full_name']) ?>"
                        class="profile-photo"
                        onerror="this.onerror=null;this.src='assets/images/default-profile.png';">

                    <span class="profile-photo-status"
                          title="Account active"></span>
                </div>

                <div class="profile-hero-info">

                    <span class="profile-member-label">
                        PEOPLELINK MEMBER
                    </span>

                    <h2><?= profileEscape($profile['full_name']) ?></h2>

                    <p class="profile-community-line">
                        <?= profileEscape($profile['community']) ?>
                        <span class="profile-dot">•</span>
                        <?= profileEscape($profile['city']) ?>
                    </p>

                    <div class="profile-meta-row">
                        <span class="profile-member-id">
                            <span class="profile-meta-icon">#</span>
                            Member ID:
                            <strong><?= profileEscape($profile['id']) ?></strong>
                        </span>

                        <span class="profile-account-status">
                            <span></span>
                            <?= profileEscape($profile['account_status']) ?>
                        </span>
                    </div>

                </div>

            </div>

            <div class="profile-hero-actions">
                <a href="edit-profile.php" class="profile-btn profile-btn-primary">
                    <span>✎</span> Edit Profile
                </a>

                <a href="account-settings.php" class="profile-btn profile-btn-outline">
                    Account Settings
                </a>
            </div>

        </section>

        <!-- Profile Completion -->
        <section class="profile-completion-card">

            <div class="completion-main">
                <div class="completion-icon">✓</div>

                <div class="completion-text">
                    <h3>Complete Your Profile</h3>
                    <p>
                        A complete profile helps you build stronger community connections.
                    </p>
                </div>
            </div>

            <div class="completion-progress-area">

                <div class="completion-progress-heading">
                    <span>Profile Completion</span>
                    <strong><?= $completion ?>%</strong>
                </div>

                <div
                    class="completion-track"
                    role="progressbar"
                    aria-label="Profile completion"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    aria-valuenow="<?= $completion ?>">

                    <div class="completion-bar"
                         style="width: <?= $completion ?>%"></div>
                </div>

                <a href="edit-profile.php" class="completion-link">
                    Complete missing information <span>→</span>
                </a>

            </div>

        </section>

        <!-- Personal Information -->
        <section class="profile-section">

            <div class="profile-section-heading">
                <div class="profile-section-title">
                    <div class="profile-section-icon personal-icon">♙</div>

                    <div>
                        <h2>Personal Information</h2>
                        <p>Your basic account and contact details</p>
                    </div>
                </div>

                <a href="edit-profile.php#personal" class="profile-edit-link">
                    Edit Details <span>→</span>
                </a>
            </div>

            <div class="profile-info-grid">

                <?php foreach ($personalFields as $field): ?>
                    <div class="profile-info-item">
                        <span><?= profileEscape($field[0]) ?></span>
                        <strong>
                            <?= profileEscape(
                                $profile[$field[1]] ?: 'Not provided'
                            ) ?>
                        </strong>
                    </div>
                <?php endforeach; ?>

            </div>

        </section>

        <!-- Professional Information -->
        <section class="profile-section">

            <div class="profile-section-heading">
                <div class="profile-section-title">
                    <div class="profile-section-icon professional-icon">▣</div>

                    <div>
                        <h2>Professional Information</h2>
                        <p>Your education, career and work information</p>
                    </div>
                </div>

                <a href="edit-profile.php#professional" class="profile-edit-link">
                    Edit Details <span>→</span>
                </a>
            </div>

            <div class="profile-info-grid">

                <?php foreach ($professionalFields as $field): ?>
                    <div class="profile-info-item">
                        <span><?= profileEscape($field[0]) ?></span>
                        <strong>
                            <?= profileEscape(
                                $profile[$field[1]] ?: 'Not provided'
                            ) ?>
                        </strong>
                    </div>
                <?php endforeach; ?>

            </div>

        </section>

        <!-- Community Information -->
        <section class="profile-section">

            <div class="profile-section-heading">
                <div class="profile-section-title">
                    <div class="profile-section-icon community-icon">♧</div>

                    <div>
                        <h2>Community Information</h2>
                        <p>Your community and family identity</p>
                    </div>
                </div>

                <a href="edit-profile.php#community" class="profile-edit-link">
                    Edit Details <span>→</span>
                </a>
            </div>

            <div class="profile-info-grid">

                <?php foreach ($communityFields as $field): ?>
                    <div class="profile-info-item">
                        <span><?= profileEscape($field[0]) ?></span>
                        <strong>
                            <?= profileEscape(
                                $profile[$field[1]] ?: 'Not provided'
                            ) ?>
                        </strong>
                    </div>
                <?php endforeach; ?>

            </div>

        </section>

        <!-- Linked Sections -->
        <section class="profile-linked-section">

            <div class="profile-section-heading">
                <div class="profile-section-title">
                    <div class="profile-section-icon linked-icon">⌘</div>

                    <div>
                        <h2>My PeopleLink Activities</h2>
                        <p>Quick access to your profiles, listings and services</p>
                    </div>
                </div>
            </div>

            <div class="profile-linked-grid">

                <?php foreach ($linkedSections as $section): ?>

                    <a
                        href="<?= profileEscape($section['url']) ?>"
                        class="profile-linked-card <?= profileEscape($section['class']) ?>">

                        <div class="linked-card-icon">
                            <?php
                            $icons = [
                                'heart' => '♡',
                                'users' => '♧',
                                'briefcase-business' => '▣',
                                'building-2' => '⌂',
                                'store' => '▤',
                                'calendar-days' => '▦',
                                'headset' => '?'
                            ];
                            ?>
                            <?= profileEscape($icons[$section['icon']] ?? '•') ?>
                        </div>

                        <div class="linked-card-content">
                            <h3><?= profileEscape($section['title']) ?></h3>
                            <p><?= profileEscape($section['description']) ?></p>
                        </div>

                        <span class="linked-card-arrow">→</span>

                    </a>

                <?php endforeach; ?>

            </div>

        </section>

        <!-- Account Summary -->
        <section class="profile-summary-section">

            <div class="profile-section-heading">
                <div class="profile-section-title">
                    <div class="profile-section-icon summary-icon">▤</div>

                    <div>
                        <h2>Account Summary</h2>
                        <p>Your saved content, packages and recent payments</p>
                    </div>
                </div>
            </div>

            <div class="profile-summary-grid">

                <?php foreach ($accountSummary as $item): ?>

                    <a href="<?= profileEscape($item['url']) ?>"
                       class="profile-summary-card">

                        <div class="summary-card-top">
                            <span class="summary-card-label">
                                <?= profileEscape($item['label']) ?>
                            </span>

                            <span class="summary-card-icon">
                                <?php
                                $summaryIcons = [
                                    'bookmark' => '☆',
                                    'package' => '▣',
                                    'wallet' => '₹'
                                ];
                                ?>
                                <?= profileEscape(
                                    $summaryIcons[$item['icon']] ?? '•'
                                ) ?>
                            </span>
                        </div>

                        <strong><?= profileEscape($item['value']) ?></strong>

                        <span class="summary-card-link">
                            View Details <span>→</span>
                        </span>

                    </a>

                <?php endforeach; ?>

            </div>

        </section>

        <!-- Privacy -->
        <section class="profile-privacy-card">

            <div class="privacy-icon">♧</div>

            <div class="privacy-content">
                <h3>Your Privacy Matters</h3>
                <p>
                    Your personal information is displayed according to your
                    account privacy settings. Sensitive contact details should
                    only be visible to members you authorize.
                </p>

                <div class="privacy-current">
                    <span class="privacy-current-dot"></span>
                    Current profile visibility:
                    <strong><?= profileEscape($profile['visibility']) ?></strong>
                </div>
            </div>

            <a href="account-settings.php#privacy" class="privacy-settings-link">
                Privacy Settings <span>→</span>
            </a>

        </section>

    </div>

</main>

 

<?php include __DIR__ . '/footer.php'; ?>
