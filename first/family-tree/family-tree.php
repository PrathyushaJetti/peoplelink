<?php
// My Family Tree: built from the registered family (Member & Family). ?family=ID shows another approved tree.
require_once __DIR__ . '/_tree.php';
$fam = ft_family($mfUid, $mfCid, isset($_GET['family']) ? (int)$_GET['family'] : null);
if (!$fam && isset($_GET['family'])) { header('Location: family-tree.php'); exit; }
if (!$fam) mf_no_family($mfUser, $mfComm);
$B = mf_bundle($fam, $mfUid);
$isOwner = $B['own'];
$gens = ft_generations($B['all'], $fam);
$people = array_merge(...array_values(array_map(fn($g) => $g['people'], $gens ?: [['people' => []]])));
$completion = ft_completion($people);
$missingCount = count(array_filter($people, fn($p) => $p['missing']));
$q = $isOwner ? '' : '?family=' . (int)$fam['id'];
$family = [
    'surname' => $fam['family_name'] . (stripos($fam['family_name'], 'family') === false ? ' Family' : ''),
    'primary_member' => $fam['head_name'],
    'community' => $mfComm['name'],
    'native_place' => $fam['native_place'] ?: ($fam['city'] ?: 'Not added'),
    'total_members' => count($people),
    'status' => ft_status($fam),
];
$familyMembers = array_map(fn($p) => $p + ['age' => $p['age']], $people);
$ftAvatar = ['Self' => 'avatar-featured', 'Father' => 'avatar-green', 'Mother' => 'avatar-rose', 'Grandfather' => 'avatar-blue', 'Grandmother' => 'avatar-rose',
    'Spouse' => 'avatar-rose', 'Sister' => 'avatar-purple', 'Daughter' => 'avatar-purple', 'Granddaughter' => 'avatar-purple', 'Aunt' => 'avatar-rose'];
$ftFlash = $_SESSION['ft_flash'] ?? null; unset($_SESSION['ft_flash']);
if (!function_exists('e')) { function e($value) { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); } }
$statusClass = strtolower(str_replace(' ', '-', $family['status']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Family Tree | PeopleLink</title>
    <meta name="description"
          content="View and manage your family connections on PeopleLink.">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
 
 <?php  include 'header.php'; ?>  

<main class="family-page">

    <!-- Page Heading -->
    <?php if ($ftFlash): ?><div style="max-width:1200px;margin:16px auto 0;padding:0 16px"><div style="background:#e9f8ee;color:#17663a;border:1px solid #b9e6c8;border-radius:12px;padding:12px 16px;font-weight:600"><i class="bi bi-check-circle"></i> <?= e($ftFlash) ?></div></div><?php endif; ?>
    <section class="family-hero">
        <div class="family-container">
            <div class="family-hero-content">
                <div class="family-hero-copy">
                    <span class="family-eyebrow">
                        <i class="bi bi-diagram-3"></i>
                        FAMILY CONNECTIONS
                    </span>

                    <h1>Family Tree</h1>

                    <p class="family-hero-subtitle">
                        View and Build Your Family Connections
                    </p>

                    <p class="family-hero-description">
                        Discover your family relationships in one place.
                        View generations, explore family members, and add
                        missing details to keep your family history connected.
                    </p>

                    <div class="family-hero-actions">
                        <a href="view-family-tree.php<?= $q ?>"
                           class="family-btn family-btn-primary">
                            <i class="bi bi-diagram-3"></i>
                            View Family Tree
                        </a>

                        <a href="../m-f-registration/family-profile.php<?= $q ?>"
                           class="family-btn family-btn-outline">
                            <i class="bi bi-person-plus"></i>
                            Add / Update Family Details
                        </a>
                    </div>
                </div>

                <div class="family-hero-art" aria-hidden="true">
                    <div class="family-art-circle circle-one"></div>
                    <div class="family-art-circle circle-two"></div>

                    <div class="family-art-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <div class="family-art-node node-top">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="family-art-node node-left">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="family-art-node node-right">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="family-art-node node-bottom">
                        <i class="bi bi-person-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="family-container family-main">

        <!-- Family Summary -->
        <section class="family-section">
            <div class="family-section-heading">
                <div>
                    <span class="family-section-label">YOUR FAMILY</span>
                    <h2>Family Summary</h2>
                    <p>Essential details about your family profile.</p>
                </div>

                <a href="../m-f-registration/family-profile.php<?= $q ?>" class="family-text-link">
                    Edit Details
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="family-summary-grid">

                <article class="family-summary-card">
                    <div class="summary-icon summary-blue">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <span>Family Name / Surname</span>
                        <h3><?= e($family['surname']) ?></h3>
                    </div>
                </article>

                <article class="family-summary-card">
                    <div class="summary-icon summary-green">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <span>Primary Member</span>
                        <h3><?= e($family['primary_member']) ?></h3>
                    </div>
                </article>

                <article class="family-summary-card">
                    <div class="summary-icon summary-purple">
                        <i class="bi bi-diagram-3"></i>
                    </div>
                    <div>
                        <span>Community</span>
                        <h3><?= e($family['community']) ?></h3>
                    </div>
                </article>

                <article class="family-summary-card">
                    <div class="summary-icon summary-orange">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div>
                        <span>Native Place</span>
                        <h3><?= e($family['native_place']) ?></h3>
                    </div>
                </article>

            </div>
        </section>

        <!-- Family Tree Preview -->
        <section class="family-section">
            <div class="family-section-heading">
                <div>
                    <span class="family-section-label">GENERATIONS</span>
                    <h2>Family Tree Preview</h2>
                    <p>Select a member to view their basic details.</p>
                </div>

                <a href="view-family-tree.php<?= $q ?>"
                   class="family-text-link">
                    View Full Tree
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="family-tree-card">

                <div class="family-tree-topbar">
                    <div class="family-tree-title">
                        <div class="tree-title-icon">
                            <i class="bi bi-diagram-3"></i>
                        </div>
                        <div>
                            <h3><?= e($family['surname']) ?></h3>
                            <p><?= (int) $family['total_members'] ?> family members</p>
                        </div>
                    </div>

                    <span class="family-status status-<?= e($statusClass) ?>">
                        <i class="bi bi-circle-fill"></i>
                        <?= e($family['status']) ?>
                    </span>
                </div>

                <div class="family-tree-preview">
                    <?php $gi = 0; foreach ($gens as $g): ?>
                    <?php if ($gi++): ?><div class="tree-connector"><span></span></div><?php endif; ?>
                    <div class="tree-generation">
                        <span class="generation-label"><?= e(strtoupper($g['label'])) ?></span>
                        <div class="<?= count($g['people']) === 2 ? 'tree-couple' : 'tree-children' ?>">
                            <?php foreach ($g['people'] as $pm): ?>
                            <button type="button"
                                    class="tree-member<?= $pm['head'] ? ' tree-member-featured' : '' ?>"
                                    data-name="<?= e($pm['name']) ?>"
                                    data-relationship="<?= e($pm['relationship']) ?>"
                                    data-age="<?= $pm['age'] === null ? '' : (int)$pm['age'] ?>"
                                    data-profession="<?= e($pm['profession'] ?: 'Not added') ?>"
                                    data-city="<?= e($pm['city'] ?: 'Not added') ?>">
                                <span class="tree-avatar <?= $pm['head'] ? 'avatar-featured' : e($ftAvatar[$pm['relationship']] ?? 'avatar-blue') ?>"><?= e($pm['initials']) ?></span>
                                <strong><?= e($pm['name']) ?></strong>
                                <small><?= e($pm['relationship']) ?></small>
                                <?php if ($pm['head'] && $isOwner): ?><span class="tree-you-label">YOU</span><?php endif; ?>
                            </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div class="tree-note">
                        <i class="bi bi-info-circle"></i>
                        <?= $gens ? 'Open the full tree to see every member and their details.' : 'No family members yet. Add your family members to build the tree.' ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="family-section">
            <div class="family-section-heading">
                <div>
                    <span class="family-section-label">MANAGE CONNECTIONS</span>
                    <h2>Quick Actions</h2>
                    <p>Keep your family information complete and up to date.</p>
                </div>
            </div>

            <div class="family-actions-grid">

                <a href="view-family-tree.php<?= $q ?>" class="family-action-card">
                    <div class="action-icon action-blue">
                        <i class="bi bi-diagram-3"></i>
                    </div>
                    <div class="action-card-content">
                        <h3>View Full Tree</h3>
                        <p>Explore family members across generations.</p>
                    </div>
                    <i class="bi bi-arrow-up-right action-arrow"></i>
                </a>

                <a href="../m-f-registration/member-family-registration.php#familyMembersContainer" class="family-action-card">
                    <div class="action-icon action-green">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <div class="action-card-content">
                        <h3>Add Family Member</h3>
                        <p>Connect another member to your family.</p>
                    </div>
                    <i class="bi bi-arrow-up-right action-arrow"></i>
                </a>

                <a href="family-tree-enquiry.php" class="family-action-card">
                    <div class="action-icon action-orange">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                    <div class="action-card-content">
                        <h3>Submit Missing Details</h3>
                        <p>Complete missing information for review.</p>
                    </div>
                    <i class="bi bi-arrow-up-right action-arrow"></i>
                </a>

            </div>
        </section>

        <!-- Family Members -->
        <section class="family-section">
            <div class="family-section-heading">
                <div>
                    <span class="family-section-label">YOUR CONNECTIONS</span>
                    <h2>Family Members</h2>
                    <p>View the members currently connected to your family.</p>
                </div>

                <a href="../m-f-registration/member-family-registration.php#familyMembersContainer"
                   class="family-btn family-btn-small">
                    <i class="bi bi-plus-lg"></i>
                    Add Member
                </a>
            </div>

            <div class="family-members-grid">
                <?php foreach ($familyMembers as $member): ?>
                    <article class="family-member-card">

                        <div class="member-card-top">
                            <span class="member-avatar">
                                <?= e($member['initials']) ?>
                            </span>

                            <span class="relationship-badge">
                                <?= e($member['relationship']) ?>
                            </span>
                        </div>

                        <h3><?= e($member['name']) ?></h3>

                        <div class="member-detail">
                            <i class="bi bi-calendar3"></i>
                            <span><?= $member['age'] === null ? 'Age not added' : (int) $member['age'] . ' years old' ?></span>
                        </div>

                        <div class="member-detail">
                            <i class="bi bi-briefcase"></i>
                            <span><?= e($member['profession'] ?: 'Profession not added') ?></span>
                        </div>

                        <div class="member-detail">
                            <i class="bi bi-geo-alt"></i>
                            <span><?= e($member['city'] ?: 'City not added') ?></span>
                        </div>

                        <button type="button"
                                class="member-view-btn"
                                data-name="<?= e($member['name']) ?>"
                                data-relationship="<?= e($member['relationship']) ?>"
                                data-age="<?= $member['age'] === null ? '' : (int) $member['age'] ?>"
                                data-profession="<?= e($member['profession']) ?>"
                                data-city="<?= e($member['city']) ?>">
                            View Details
                            <i class="bi bi-arrow-right"></i>
                        </button>

                    </article>
                <?php endforeach; ?>
            </div>

            <div class="family-members-footer">
                <span>
                    Showing <?= count($familyMembers) ?> of
                    <?= (int) $family['total_members'] ?> family members
                </span>

                <a href="view-family-tree.php<?= $q ?>" class="family-text-link">
                    View All Members
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </section>

        <!-- Family Status and Privacy -->
        <section class="family-bottom-grid">

            <div class="family-status-card">
                <div class="bottom-card-heading">
                    <div class="bottom-card-icon status-icon">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                    <div>
                        <h2>Family Tree Status</h2>
                        <p>Track the completeness of your family profile.</p>
                    </div>
                </div>

                <div class="status-progress-heading">
                    <span>Profile completion</span>
                    <strong><?= $completion ?>%</strong>
                </div>

                <div class="status-progress">
                    <span style="width:<?= $completion ?>%"></span>
                </div>

                <div class="status-message">
                    <i class="bi bi-<?= $missingCount ? 'exclamation-circle' : 'check-circle' ?>"></i> <span><?= $missingCount ? $missingCount . ' member(s) have missing details (date of birth, gender or profession).' : 'All member details are complete.' ?> Tree status: <strong><?= e($family['status']) ?></strong></span>
                </div>

                <div class="status-legend">
                    <span><i class="status-dot complete-dot"></i> Complete</span>
                    <span><i class="status-dot incomplete-dot"></i> Incomplete</span>
                    <span><i class="status-dot pending-dot"></i> Pending Verification</span>
                </div>

                <a href="family-tree-enquiry.php"
                   class="family-btn family-btn-primary family-btn-status">
                    Complete Missing Details
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="family-privacy-card">
                <div class="bottom-card-heading">
                    <div class="bottom-card-icon privacy-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <h2>Family Privacy</h2>
                        <p>Your family information should remain under your control.</p>
                    </div>
                </div>

                <div class="privacy-feature">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <strong>Privacy-based visibility</strong>
                        <p>Visibility should follow your profile and community settings.</p>
                    </div>
                </div>

                <div class="privacy-feature">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <strong>Respect member preferences</strong>
                        <p>Only show details that the viewer is permitted to access.</p>
                    </div>
                </div>

                <a href="../m-f-registration/family-profile.php#familyPrivacyForm" class="family-text-link">
                    Review Privacy Settings
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

        </section>

    </div>
</main>

<!-- Member Details Modal -->
<div class="family-modal" id="memberDetailsModal" aria-hidden="true">
    <div class="family-modal-backdrop" data-close-modal></div>

    <div class="family-modal-dialog"
         role="dialog"
         aria-modal="true"
         aria-labelledby="modalMemberName">

        <button type="button"
                class="family-modal-close"
                data-close-modal
                aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="modal-member-avatar" id="modalInitials">FM</div>

        <span class="family-section-label">FAMILY MEMBER</span>
        <h2 id="modalMemberName">Member Name</h2>
        <p class="modal-relationship" id="modalRelationship">Relationship</p>

        <div class="modal-member-details">
            <div>
                <i class="bi bi-calendar3"></i>
                <span>Age</span>
                <strong id="modalAge">—</strong>
            </div>
            <div>
                <i class="bi bi-briefcase"></i>
                <span>Profession</span>
                <strong id="modalProfession">—</strong>
            </div>
            <div>
                <i class="bi bi-geo-alt"></i>
                <span>Current City</span>
                <strong id="modalCity">—</strong>
            </div>
        </div>

        <a href="view-family-tree.php<?= $q ?>" class="family-btn family-btn-primary modal-full-tree">
            Explore Family Tree
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>


 <?php include 'footer.php'; ?> 

 