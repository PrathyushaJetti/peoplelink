<?php
// family-members.php - members of my family (or ?family=ID of an approved family in my community).
require_once __DIR__ . '/_family.php';
$fam = mf_family($mfUid, $mfCid, isset($_GET['family']) ? (int)$_GET['family'] : null);
if (!$fam) mf_no_family($mfUser, $mfComm);
$B = mf_bundle($fam, $mfUid);
$isOwner = $B['own'];
if (!$isOwner && empty($B['priv']['show_family_members'])) { header('Location: family-profile.php?family=' . (int)$fam['id']); exit; }
$family = ['family_id' => (int)$fam['id'], 'surname' => $fam['family_name'], 'primary_member' => $fam['head_name'], 'community' => $mfComm['name']];
$members = array_map(fn($m) => ['id' => (int)$m['id'], 'name' => $m['full_name'], 'relationship' => $m['relationship'], 'gender' => $m['gender'] ?: 'Not specified', 'dob' => $m['dob'],
    'marital_status' => $m['marital_status'] ?: 'Not specified', 'education' => $m['education'] ?: 'Not specified', 'profession' => $m['occupation'] ?: 'Not specified',
    'city' => $fam['city'] ?: '', 'status' => mf_status($m['status']), 'photo' => $m['photo'] ?? ''], $B['all']);

function memberAge($dob) {
    if (empty($dob)) {
        return 'Not specified';
    }

    try {
        $birthDate = new DateTime($dob);
        return $birthDate->diff(new DateTime())->y . ' years';
    } catch (Exception $ex) {
        return 'Not specified';
    }
}

function ageGroup($dob) {
    if (empty($dob)) {
        return 'Unknown';
    }

    try {
        $age = (new DateTime($dob))->diff(new DateTime())->y;

        if ($age < 18) return 'Under 18';
        if ($age <= 30) return '18–30';
        if ($age <= 45) return '31–45';
        if ($age <= 60) return '46–60';
        return '60+';
    } catch (Exception $ex) {
        return 'Unknown';
    }
}

function initials($name) {
    $parts = preg_split('/\s+/', trim($name));
    $result = '';

    foreach (array_slice($parts, 0, 2) as $part) {
        if ($part !== '') {
            $result .= mb_substr($part, 0, 1);
        }
    }

    return strtoupper($result ?: 'PL');
}

$totalMembers = count($members);
$activeMembers = 0;
$pendingMembers = 0;

foreach ($members as $member) {
    if ($member['status'] === 'Active') $activeMembers++;
    if ($member['status'] === 'Pending Approval') $pendingMembers++;
}

include 'header.php';
?>

 

<main class="pl-members-page">

    <!-- Page Banner -->
    <section class="fm-hero">
        <div class="fm-hero-overlay"></div>
        <div class="fm-hero-inner">
            <div>
                <span class="fm-eyebrow">
                    <i class="bi bi-people-fill"></i>
                    FAMILY DIRECTORY
                </span>
                <h1>Family Members</h1>
                <p>Manage your family connections and keep your community profile up to date.</p>
            </div>

            <a href="member-family-registration.php#familyMembersContainer" class="fm-btn fm-btn-light">
                <i class="bi bi-person-plus-fill"></i>
                Add Family Member
            </a>
        </div>
    </section>

    <div class="fm-container">

        <!-- Breadcrumb -->
        <nav class="fm-breadcrumb" aria-label="Breadcrumb">
            <a href="../community-home.php">Community Home</a>
            <i class="bi bi-chevron-right"></i>
            <a href="family-profile.php">Family Profile</a>
            <i class="bi bi-chevron-right"></i>
            <span>Family Members</span>
        </nav>

        <!-- Family Summary -->
        <section class="fm-summary">
            <div class="fm-family-identity">
                <div class="fm-family-icon">
                    <i class="bi bi-house-heart-fill"></i>
                </div>

                <div class="fm-family-info">
                    <span class="fm-section-kicker">YOUR FAMILY PROFILE</span>
                    <h2><?php echo e($family['surname']); ?> Family</h2>
                    <div class="fm-family-meta">
                        <span>
                            <i class="bi bi-person-fill"></i>
                            <?php echo e($family['primary_member']); ?>
                        </span>
                        <span>
                            <i class="bi bi-people-fill"></i>
                            <?php echo e($family['community']); ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="fm-summary-stats">
                <div class="fm-stat">
                    <span class="fm-stat-number"><?php echo $totalMembers; ?></span>
                    <span class="fm-stat-label">Total Members</span>
                </div>
                <div class="fm-stat">
                    <span class="fm-stat-number"><?php echo $activeMembers; ?></span>
                    <span class="fm-stat-label">Active</span>
                </div>
                <div class="fm-stat">
                    <span class="fm-stat-number"><?php echo $pendingMembers; ?></span>
                    <span class="fm-stat-label">Pending</span>
                </div>
            </div>

            <div class="fm-summary-actions">
                <a href="member-family-registration.php#familyMembersContainer" class="fm-btn fm-btn-primary">
                    <i class="bi bi-person-plus"></i> Add Family Member
                </a>
                <a href="member-family-registration.php"
                   class="fm-btn fm-btn-outline">
                    <i class="bi bi-pencil-square"></i> Edit Family Details
                </a>
            </div>
        </section>

        <!-- Heading -->
        <section class="fm-list-heading">
            <div>
                <span class="fm-section-kicker">FAMILY DIRECTORY</span>
                <h2>All Family Members</h2>
                <p>Search and filter members by relationship, age, marital status, or profession.</p>
            </div>
            <div class="fm-result-count">
                <strong id="fmVisibleCount"><?php echo $totalMembers; ?></strong>
                <span>members displayed</span>
            </div>
        </section>

        <!-- Search and Filters -->
        <section class="fm-filter-panel">
            <div class="fm-search-wrap">
                <i class="bi bi-search"></i>
                <input type="search" id="fmSearch"
                       placeholder="Search by name, education, profession or city..."
                       aria-label="Search family members">
                <button type="button" id="fmClearSearch" aria-label="Clear search">
                    <i class="bi bi-x-circle"></i>
                </button>
            </div>

            <div class="fm-filters">
                <div class="fm-filter-field">
                    <label for="fmRelationship">Relationship</label>
                    <select id="fmRelationship">
                        <option value="">All Relationships</option>
                        <?php
                        $relationships = [
                            'Self', 'Spouse', 'Father', 'Mother', 'Son',
                            'Daughter', 'Brother', 'Sister', 'Other'
                        ];
                        foreach ($relationships as $relationship):
                        ?>
                            <option value="<?php echo e($relationship); ?>">
                                <?php echo e($relationship); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="fm-filter-field">
                    <label for="fmAgeGroup">Age Group</label>
                    <select id="fmAgeGroup">
                        <option value="">All Ages</option>
                        <option value="Under 18">Under 18</option>
                        <option value="18–30">18–30</option>
                        <option value="31–45">31–45</option>
                        <option value="46–60">46–60</option>
                        <option value="60+">60+</option>
                        <option value="Unknown">Not specified</option>
                    </select>
                </div>

                <div class="fm-filter-field">
                    <label for="fmMaritalStatus">Marital Status</label>
                    <select id="fmMaritalStatus">
                        <option value="">All Statuses</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="fm-filter-field">
                    <label for="fmProfession">Profession</label>
                    <select id="fmProfession">
                        <option value="">All Professions</option>
                        <?php
                        $professions = [];
                        foreach ($members as $member) {
                            if (!empty($member['profession'])) {
                                $professions[] = $member['profession'];
                            }
                        }
                        $professions = array_unique($professions);
                        sort($professions);

                        foreach ($professions as $profession):
                        ?>
                            <option value="<?php echo e($profession); ?>">
                                <?php echo e($profession); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="button" id="fmResetFilters" class="fm-reset-btn">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </button>
            </div>
        </section>

        <!-- Member Cards -->
        <section class="fm-members-grid" id="fmMembersGrid">

            <?php foreach ($members as $member): ?>
                <?php
                $statusClass = strtolower(str_replace(' ', '-', $member['status']));
                $searchText = implode(' ', [
                    $member['name'],
                    $member['relationship'],
                    $member['gender'],
                    $member['marital_status'],
                    $member['education'],
                    $member['profession'],
                    $member['city']
                ]);
                ?>
                <article class="fm-member-card"
                    data-search="<?php echo e(strtolower($searchText)); ?>"
                    data-relationship="<?php echo e($member['relationship']); ?>"
                    data-age-group="<?php echo e(ageGroup($member['dob'])); ?>"
                    data-marital="<?php echo e($member['marital_status']); ?>"
                    data-profession="<?php echo e($member['profession']); ?>">

                    <div class="fm-card-top">
                        <div class="fm-member-avatar">
                            <?php if (!empty($member['photo'])): ?>
                                <img src="<?php echo e($member['photo']); ?>"
                                     alt="<?php echo e($member['name']); ?>">
                            <?php else: ?>
                                <span><?php echo e(initials($member['name'])); ?></span>
                            <?php endif; ?>
                        </div>

                        <span class="fm-status fm-status-<?php echo e($statusClass); ?>">
                            <span class="fm-status-dot"></span>
                            <?php echo e($member['status']); ?>
                        </span>
                    </div>

                    <div class="fm-member-heading">
                        <h3><?php echo e($member['name']); ?></h3>
                        <span class="fm-relationship">
                            <i class="bi bi-person-heart"></i>
                            <?php echo e($member['relationship']); ?>
                        </span>
                    </div>

                    <div class="fm-member-details">
                        <div class="fm-detail-row">
                            <span><i class="bi bi-gender-ambiguous"></i> Gender</span>
                            <strong><?php echo e($member['gender']); ?></strong>
                        </div>
                        <div class="fm-detail-row">
                            <span><i class="bi bi-calendar3"></i> Age / DOB</span>
                            <strong>
                                <?php echo e(memberAge($member['dob'])); ?>
                                <?php if (!empty($member['dob'])): ?>
                                    <small>(<?php echo e(date('d M Y', strtotime($member['dob']))); ?>)</small>
                                <?php endif; ?>
                            </strong>
                        </div>
                        <div class="fm-detail-row">
                            <span><i class="bi bi-heart"></i> Marital Status</span>
                            <strong><?php echo e($member['marital_status']); ?></strong>
                        </div>
                        <div class="fm-detail-row">
                            <span><i class="bi bi-mortarboard"></i> Education</span>
                            <strong><?php echo e($member['education'] ?: 'Not specified'); ?></strong>
                        </div>
                        <div class="fm-detail-row">
                            <span><i class="bi bi-briefcase"></i> Profession</span>
                            <strong><?php echo e($member['profession'] ?: 'Not specified'); ?></strong>
                        </div>
                        <div class="fm-detail-row">
                            <span><i class="bi bi-geo-alt"></i> Current City</span>
                            <strong><?php echo e($member['city'] ?: 'Not specified'); ?></strong>
                        </div>
                    </div>

                    <div class="fm-card-actions">
                        <a class="fm-btn fm-btn-outline"
                           href="member-details.php?id=<?php echo (int)$member['id']; ?>">
                            <i class="bi bi-eye"></i> View Details
                        </a>
                        <a class="fm-edit-link"
                           href="member-family-registration.php"
                           aria-label="Edit <?php echo e($member['name']); ?>">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>

        </section>

        <!-- Empty Search Result -->
        <div class="fm-empty-state" id="fmNoResults" hidden>
            <div class="fm-empty-icon">
                <i class="bi bi-people"></i>
            </div>
            <h3>No matching members found</h3>
            <p>Try changing your search or clearing the filters.</p>
            <button type="button" class="fm-btn fm-btn-primary" id="fmEmptyReset">
                Clear Filters
            </button>
        </div>

        <!-- No Members Empty State -->
        <?php if ($totalMembers === 0): ?>
            <div class="fm-empty-state">
                <div class="fm-empty-icon">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h3>No family members have been added yet.</h3>
                <p>Add your first family member to build your family directory.</p>
                <a href="member-family-registration.php#familyMembersContainer" class="fm-btn fm-btn-primary">
                    <i class="bi bi-person-plus-fill"></i> Add Family Member
                </a>
            </div>
        <?php endif; ?>

        <div class="fm-bottom-cta">
            <div class="fm-bottom-icon">
                <i class="bi bi-people-fill"></i>
            </div>
            <div>
                <h3>Keep your family profile updated</h3>
                <p>Add new members and keep family information accurate for your community.</p>
            </div>
            <a href="member-family-registration.php#familyMembersContainer" class="fm-btn fm-btn-primary">
                <i class="bi bi-plus-lg"></i> Add Member
            </a>
        </div>

    </div>
</main>

 

<?php include 'footer.php'; ?>
