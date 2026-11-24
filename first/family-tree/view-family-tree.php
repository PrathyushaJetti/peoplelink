<?php
// View Family Tree: every generation of the family with member details. ?family=ID shows another approved tree.
require_once __DIR__ . '/_tree.php';
$fam = ft_family($mfUid, $mfCid, isset($_GET['family']) ? (int)$_GET['family'] : null);
if (!$fam && isset($_GET['family'])) { header('Location: view-family-tree.php'); exit; }
if (!$fam) mf_no_family($mfUser, $mfComm);
$B = mf_bundle($fam, $mfUid);
$isOwner = $B['own'];
$gens = ft_generations($B['all'], $fam);
$people = array_merge(...array_values(array_map(fn($g) => $g['people'], $gens ?: [['people' => []]])));
$missingCount = count(array_filter($people, fn($p) => $p['missing']));
$q = $isOwner ? '' : '?family=' . (int)$fam['id'];
$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
include 'header.php';
?>

 

<main class="vft-page">

    <!-- Page Header -->
    <section class="vft-hero">
        <div class="vft-container">
            <nav class="vft-breadcrumb">
                <a href="family-tree.php<?= $q ?>">Family Tree</a>
                <i class="bi bi-chevron-right"></i>
                <span>View Family Tree</span>
            </nav>

            <div class="vft-hero-content">
                <div>
                    <span class="vft-eyebrow">
                        <i class="bi bi-diagram-3"></i>
                        FAMILY CONNECTIONS
                    </span>

                    <h1>View Family Tree</h1>

                    <p>
                        Explore your family relationships across generations
                        and keep your family history connected.
                    </p>
                </div>

                <a href="family-tree.php<?= $q ?>" class="vft-btn vft-btn-light">
                    <i class="bi bi-arrow-left"></i>
                    Family Tree Home
                </a>
            </div>
        </div>
    </section>

    <div class="vft-container vft-main">

        <!-- Family Header -->
        <section class="vft-family-header">
            <div class="vft-family-symbol">
                <i class="bi bi-people-fill"></i>
            </div>

            <div class="vft-family-identity">
                <span class="vft-section-label">FAMILY PROFILE</span>
                <h2><?= $h($fam['family_name'] . (stripos($fam['family_name'], 'family') === false ? ' Family' : '')) ?></h2>

                <div class="vft-family-meta">
                    <span>
                        <i class="bi bi-person-badge"></i> <?= $h($fam['head_name']) ?>
                    </span>

                    <span>
                        <i class="bi bi-diagram-3"></i> <?= $h($mfComm['name']) ?>
                    </span>

                    <span>
                        <i class="bi bi-geo-alt"></i> <?= $h($fam['native_place'] ?: $fam['city']) ?>
                    </span>
                </div>
            </div>

            <div class="vft-member-count">
                <strong><?= count($people) ?></strong>
                <span>Family Members</span>
            </div>
        </section>

        <!-- Tree Controls -->
        <section class="vft-toolbar">
            <div class="vft-toolbar-heading">
                <h2>
                    <i class="bi bi-diagram-3"></i>
                    Family Structure
                </h2>
                <p>Select a family member to view their details.</p>
            </div>

            <div class="vft-toolbar-actions">
                <div class="vft-zoom-controls">
                    <button type="button" id="zoomOut"
                            class="vft-icon-btn" aria-label="Zoom out">
                        <i class="bi bi-zoom-out"></i>
                    </button>

                    <span id="zoomValue">100%</span>

                    <button type="button" id="zoomIn"
                            class="vft-icon-btn" aria-label="Zoom in">
                        <i class="bi bi-zoom-in"></i>
                    </button>

                    <button type="button" id="resetZoom"
                            class="vft-icon-btn" aria-label="Reset zoom">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                </div>

                <button type="button" id="expandTree"
                        class="vft-btn vft-btn-outline">
                    <i class="bi bi-arrows-expand"></i>
                    Expand Branch
                </button>

                <button type="button" id="collapseTree"
                        class="vft-btn vft-btn-outline">
                    <i class="bi bi-arrows-collapse"></i>
                    Collapse Branch
                </button>
            </div>
        </section>

        <!-- Family Tree -->
        <section class="vft-tree-panel">

            <div class="vft-tree-legend">
                <span>
                    <i class="legend-dot legend-complete"></i>
                    Details Available
                </span>

                <span>
                    <i class="legend-dot legend-incomplete"></i>
                    Missing Information
                </span>

                <span class="vft-tree-hint">
                    <i class="bi bi-hand-index-thumb"></i>
                    Select a member to view details
                </span>
            </div>

            <div class="vft-tree-viewport" id="treeViewport">
                <div class="vft-tree-canvas" id="treeCanvas">
                    <?php $gi = 0; foreach ($gens as $n => $g): ?>
                    <?php if ($gi++): ?><div class="vft-tree-connector"><span></span></div><?php endif; ?>
                    <div class="vft-tree-level"<?= $n === 4 ? ' id="childrenBranch"' : '' ?>>
                        <div class="vft-generation-label">
                            <span>GENERATION <?= $gi ?></span>
                            <strong><?= $h($g['label']) ?></strong>
                        </div>
                        <div class="vft-person-row">
                            <?php foreach ($g['people'] as $pm): $rel = $pm['head'] ? 'Primary Member' : $pm['relationship']; ?>
                            <article class="vft-person-card<?= $pm['missing'] ? ' is-incomplete' : '' ?>"
                                data-member-card
                                data-member-id="<?= (int)$pm['id'] ?>"
                                data-member-name="<?= $h($pm['name']) ?>"
                                data-relationship="<?= $h($rel) ?>"
                                data-age="<?= $pm['age'] === null ? '' : (int)$pm['age'] ?>"
                                data-profession="<?= $h($pm['profession'] ?: 'Not added') ?>"
                                data-city="<?= $h($pm['city'] ?: 'Not added') ?>"
                                data-missing="<?= $pm['missing'] ? '1' : '0' ?>"
                                tabindex="0" role="button">
                                <div class="vft-person-photo">
                                    <?php if ($pm['photo']): ?><img src="<?= $h($pm['photo']) ?>" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:inherit"><?php else: ?><span><?= $h($pm['initials']) ?></span><?php endif; ?>
                                </div>
                                <div class="vft-person-info">
                                    <h3><?= $h($pm['name']) ?></h3>
                                    <p class="vft-person-relation"><?= $h($rel) ?><?= $pm['status'] === 'pending' && $isOwner ? ' · pending approval' : '' ?></p>
                                    <p><i class="bi bi-calendar3"></i> <?= $pm['age'] === null ? 'Age not added' : (int)$pm['age'] . ' years' ?></p>
                                    <p><i class="bi bi-briefcase"></i> <?= $h($pm['profession'] ?: 'Profession not added') ?></p>
                                    <p><i class="bi bi-geo-alt"></i> <?= $h($pm['city'] ?: 'City not added') ?></p>
                                    <?php if ($pm['missing'] && $isOwner): ?><p style="color:#b45309"><i class="bi bi-exclamation-circle"></i> Missing: <?= $h(implode(', ', $pm['missing'])) ?></p><?php endif; ?>
                                </div>
                                <span class="vft-card-open">View Details <i class="bi bi-arrow-up-right"></i></span>
                            </article>
                            <?php endforeach; ?>
                            <?php if ($isOwner && $n === array_key_last($gens)): ?>
                            <a href="../m-f-registration/member-family-registration.php#familyMembersContainer" class="vft-add-placeholder">
                                <span><i class="bi bi-plus-lg"></i></span>
                                <strong>Add Family Member</strong>
                                <small>Connect another generation</small>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php if (!$gens): ?><p style="text-align:center;padding:40px 10px">No family members yet. <a href="../m-f-registration/member-family-registration.php">Add your family members</a> to build the tree.</p><?php endif; ?>
                </div>
            </div>

<div class="vft-tree-footer">
                <span>
                    <i class="bi bi-info-circle"></i>
                    Family information should be visible only to eligible viewers.
                </span>

                <button type="button" id="fitTree" class="vft-text-button">
                    Fit Tree to Screen
                    <i class="bi bi-arrows-angle-contract"></i>
                </button>
            </div>

        </section>

        <!-- Missing Family Information -->
        <?php if ($isOwner && $missingCount): ?><section class="vft-missing-panel">
            <div class="vft-missing-icon">
                <i class="bi bi-clipboard2-pulse"></i>
            </div>

            <div class="vft-missing-copy">
                <span class="vft-section-label">ACTION REQUIRED</span>
                <h2>Missing Family Information</h2>
                <p>
                    Some family entries have incomplete details.
                    Submit the missing information to help maintain an accurate family tree.
                </p>
            </div>

            <div class="vft-missing-count">
                <strong><?= $missingCount ?></strong>
                <span>Incomplete Entries</span>
            </div>

            <a href="family-tree-enquiry.php" class="vft-btn vft-btn-primary">
                <i class="bi bi-send"></i>
                Submit Details
            </a>
        </section><?php endif; ?>

        <!-- Family Management -->
        <?php if ($isOwner): ?><section class="vft-management-section">
            <div class="vft-section-heading">
                <span class="vft-section-label">FAMILY MANAGEMENT</span>
                <h2>Add or Update Information</h2>
                <p>Manage family relationships and member details.</p>
            </div>

            <div class="vft-management-grid">

                <a href="../m-f-registration/member-family-registration.php#familyMembersContainer" class="vft-management-card">
                    <span class="management-icon management-blue">
                        <i class="bi bi-person-plus"></i>
                    </span>

                    <span class="management-copy">
                        <strong>Add Family Member</strong>
                        <small>Add a member to your family tree.</small>
                    </span>

                    <i class="bi bi-arrow-up-right management-arrow"></i>
                </a>

                <a href="../m-f-registration/member-family-registration.php#familyMembersContainer" class="vft-management-card">
                    <span class="management-icon management-green">
                        <i class="bi bi-diagram-2"></i>
                    </span>

                    <span class="management-copy">
                        <strong>Edit Relationship</strong>
                        <small>Update family relationships.</small>
                    </span>

                    <i class="bi bi-arrow-up-right management-arrow"></i>
                </a>

                <a href="../m-f-registration/family-profile.php<?= $q ?>" class="vft-management-card">
                    <span class="management-icon management-purple">
                        <i class="bi bi-person-lines-fill"></i>
                    </span>

                    <span class="management-copy">
                        <strong>Update Details</strong>
                        <small>Review family and member information.</small>
                    </span>

                    <i class="bi bi-arrow-up-right management-arrow"></i>
                </a>

            </div>
        </section><?php endif; ?>

        <!-- Privacy -->
        <section class="vft-privacy-note">
            <div class="vft-privacy-icon">
                <i class="bi bi-shield-lock"></i>
            </div>

            <div>
                <h3>Family Privacy Matters</h3>
                <p>
                    Family-tree access, member details and profile photos should
                    follow configured community rules and privacy permissions.
                </p>
            </div>

            <a href="../m-f-registration/family-profile.php#familyPrivacyForm">
                Privacy Settings
                <i class="bi bi-arrow-right"></i>
            </a>
        </section>

    </div>
</main>

<!-- Member Details Modal -->
<div class="vft-modal" id="memberModal" aria-hidden="true">
    <div class="vft-modal-backdrop" data-close-modal></div>

    <div class="vft-modal-dialog"
         role="dialog"
         aria-modal="true"
         aria-labelledby="modalName">

        <button type="button"
                class="vft-modal-close"
                data-close-modal
                aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="vft-modal-avatar" id="modalAvatar">FM</div>

        <span class="vft-section-label">FAMILY MEMBER</span>
        <h2 id="modalName">Member Name</h2>
        <p class="vft-modal-relationship" id="modalRelationship">Relationship</p>

        <div class="vft-modal-details">
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

        <div class="vft-modal-warning" id="modalMissingNotice" hidden>
            <i class="bi bi-exclamation-circle"></i>
            Some family details are incomplete.
        </div>

        <div class="vft-modal-actions">
            <a href="family-tree-enquiry.php"
               class="vft-btn vft-btn-outline"
               id="modalSubmitDetails">
                <i class="bi bi-send"></i>
                Submit Details
            </a>

            <a href="../m-f-registration/family-profile.php<?= $q ?>"
               class="vft-btn vft-btn-primary"
               id="modalUpdateDetails">
                <i class="bi bi-pencil-square"></i>
                Update Details
            </a>
        </div>
    </div>
</div>

 

<?php include 'footer.php'; ?>