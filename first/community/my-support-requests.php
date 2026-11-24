
<?php
$pageTitle = 'My Support Requests | PeopleLink';

/*
|--------------------------------------------------------------------------
| DEMO DATA
|--------------------------------------------------------------------------
| Replace this array with requests belonging to the logged-in user.
| Always verify ownership on the server before editing or closing a request.
*/

$requests = [
    [
        'id' => 101,
        'title' => 'Help a Student Continue Their Education',
        'category' => 'Education Support',
        'community' => 'PeopleLink Community',
        'location' => 'Rishikesh, Uttarakhand',
        'date' => '15 Oct 2026',
        'urgency' => 'High',
        'status' => 'Active',
        'offers' => 5,
        'responses' => 3,
        'updated' => '15 Oct 2026',
        'reason' => ''
    ],
    [
        'id' => 102,
        'title' => 'Medical Assistance for a Family Member',
        'category' => 'Medical Support',
        'community' => 'PeopleLink Community',
        'location' => 'Dehradun, Uttarakhand',
        'date' => '12 Oct 2026',
        'urgency' => 'Urgent',
        'status' => 'Pending Approval',
        'offers' => 0,
        'responses' => 1,
        'updated' => '14 Oct 2026',
        'reason' => ''
    ],
    [
        'id' => 103,
        'title' => 'Emergency Grocery Assistance',
        'category' => 'Family Support',
        'community' => 'PeopleLink Community',
        'location' => 'Haridwar, Uttarakhand',
        'date' => '08 Oct 2026',
        'urgency' => 'Medium',
        'status' => 'Support Received',
        'offers' => 4,
        'responses' => 4,
        'updated' => '13 Oct 2026',
        'reason' => ''
    ],
    [
        'id' => 104,
        'title' => 'Books and Learning Materials',
        'category' => 'Education Support',
        'community' => 'PeopleLink Community',
        'location' => 'Rishikesh, Uttarakhand',
        'date' => '01 Oct 2026',
        'urgency' => 'Low',
        'status' => 'Completed',
        'offers' => 3,
        'responses' => 3,
        'updated' => '10 Oct 2026',
        'reason' => ''
    ],
    [
        'id' => 105,
        'title' => 'Community Assistance Request',
        'category' => 'Family Support',
        'community' => 'PeopleLink Community',
        'location' => 'Dehradun, Uttarakhand',
        'date' => '28 Sep 2026',
        'urgency' => 'Medium',
        'status' => 'Rejected',
        'offers' => 0,
        'responses' => 1,
        'updated' => '29 Sep 2026',
        'reason' => 'Please provide the required supporting documents and clarify the assistance requested before resubmitting.'
    ],
    [
        'id' => 106,
        'title' => 'Support for School Uniforms',
        'category' => 'Education Support',
        'community' => 'PeopleLink Community',
        'location' => 'Rishikesh, Uttarakhand',
        'date' => '27 Sep 2026',
        'urgency' => 'Low',
        'status' => 'Closed',
        'offers' => 2,
        'responses' => 2,
        'updated' => '30 Sep 2026',
        'reason' => ''
    ],
    [
        'id' => 107,
        'title' => 'Draft: Household Essentials',
        'category' => 'Family Support',
        'community' => 'PeopleLink Community',
        'location' => 'Rishikesh, Uttarakhand',
        'date' => '15 Oct 2026',
        'urgency' => 'Medium',
        'status' => 'Draft',
        'offers' => 0,
        'responses' => 0,
        'updated' => '15 Oct 2026',
        'reason' => ''
    ]
];

$tabs = [
    'All' => count($requests),
    'Active' => 0,
    'Pending Approval' => 0,
    'Completed' => 0,
    'Closed' => 0,
    'Drafts' => 0
];

foreach ($requests as $request) {
    if ($request['status'] === 'Active' ||
        $request['status'] === 'Support Received') {
        $tabs['Active']++;
    } elseif ($request['status'] === 'Pending Approval') {
        $tabs['Pending Approval']++;
    } elseif ($request['status'] === 'Completed') {
        $tabs['Completed']++;
    } elseif ($request['status'] === 'Closed' ||
              $request['status'] === 'Rejected') {
        $tabs['Closed']++;
    } elseif ($request['status'] === 'Draft') {
        $tabs['Drafts']++;
    }
}

$categories = array_unique(array_column($requests, 'category'));
sort($categories);
?>

 
<?php include 'header.php'; ?>

<main class="pl-my-support">

    <!-- Page Banner -->
    <section class="ms-banner">
        <div class="ms-container">
            <div class="ms-breadcrumb">
                <a href="index.php">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="support-requests.php">Community Support</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>My Support Requests</span>
            </div>

            <div class="ms-banner-content">
                <div>
                    <span class="ms-eyebrow">
                        <i class="fa-solid fa-hand-holding-heart"></i>
                        YOUR COMMUNITY SUPPORT DASHBOARD
                    </span>
                    <h1>My Support Requests</h1>
                    <p>
                        Track your requests, review responses and keep your
                        community support journey organized in one place.
                    </p>
                </div>

                <a href="create-support-request.php" class="ms-btn ms-btn-white">
                    <i class="fa-solid fa-plus"></i>
                    Request Support
                </a>
            </div>
        </div>
    </section>

    <section class="ms-main-section">
        <div class="ms-container">

            <!-- Summary -->
            <div class="ms-summary-grid">

                <div class="ms-summary-card">
                    <div class="ms-summary-icon ms-icon-blue">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <span>Total Requests</span>
                        <strong><?php echo count($requests); ?></strong>
                        <small>All submitted and saved requests</small>
                    </div>
                </div>

                <div class="ms-summary-card">
                    <div class="ms-summary-icon ms-icon-green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <span>Active Requests</span>
                        <strong><?php echo $tabs['Active']; ?></strong>
                        <small>Active and receiving support</small>
                    </div>
                </div>

                <div class="ms-summary-card">
                    <div class="ms-summary-icon ms-icon-orange">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div>
                        <span>Pending Approval</span>
                        <strong><?php echo $tabs['Pending Approval']; ?></strong>
                        <small>Awaiting review</small>
                    </div>
                </div>

                <div class="ms-summary-card">
                    <div class="ms-summary-icon ms-icon-purple">
                        <i class="fa-solid fa-handshake-angle"></i>
                    </div>
                    <div>
                        <span>Completed</span>
                        <strong><?php echo $tabs['Completed']; ?></strong>
                        <small>Requests marked completed</small>
                    </div>
                </div>

            </div>

            <!-- Request Management -->
            <section class="ms-management-card">

                <div class="ms-management-header">
                    <div>
                        <h2>Manage Your Requests</h2>
                        <p>Review request status, responses and available actions.</p>
                    </div>

                    <a href="create-support-request.php" class="ms-btn ms-btn-primary">
                        <i class="fa-solid fa-plus"></i>
                        New Request
                    </a>
                </div>

                <!-- Tabs -->
                <div class="ms-tabs" role="tablist" aria-label="Request status">
                    <button type="button" class="ms-tab is-active"
                            data-status="All" role="tab" aria-selected="true">
                        All <span><?php echo $tabs['All']; ?></span>
                    </button>

                    <button type="button" class="ms-tab"
                            data-status="Active" role="tab" aria-selected="false">
                        Active <span><?php echo $tabs['Active']; ?></span>
                    </button>

                    <button type="button" class="ms-tab"
                            data-status="Pending Approval" role="tab" aria-selected="false">
                        Pending Approval <span><?php echo $tabs['Pending Approval']; ?></span>
                    </button>

                    <button type="button" class="ms-tab"
                            data-status="Completed" role="tab" aria-selected="false">
                        Completed <span><?php echo $tabs['Completed']; ?></span>
                    </button>

                    <button type="button" class="ms-tab"
                            data-status="Closed" role="tab" aria-selected="false">
                        Closed <span><?php echo $tabs['Closed']; ?></span>
                    </button>

                    <button type="button" class="ms-tab"
                            data-status="Drafts" role="tab" aria-selected="false">
                        Drafts <span><?php echo $tabs['Drafts']; ?></span>
                    </button>
                </div>

                <!-- Filters -->
                <div class="ms-filter-bar">
                    <div class="ms-search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="search" id="requestSearch"
                               placeholder="Search your requests..."
                               aria-label="Search support requests">
                    </div>

                    <div class="ms-filter-control">
                        <label for="categoryFilter">Category</label>
                        <select id="categoryFilter">
                            <option value="All">All Categories</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category, ENT_QUOTES); ?>">
                                    <?php echo htmlspecialchars($category); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="ms-filter-control">
                        <label for="statusFilter">Status</label>
                        <select id="statusFilter">
                            <option value="All">All Statuses</option>
                            <option value="Active">Active</option>
                            <option value="Pending Approval">Pending Approval</option>
                            <option value="Support Received">Support Received</option>
                            <option value="Completed">Completed</option>
                            <option value="Closed">Closed</option>
                            <option value="Draft">Draft</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>

                    <button type="button" class="ms-reset-btn" id="resetFilters">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </button>
                </div>

                <!-- Request Cards -->
                <div class="ms-request-list" id="requestList">

                    <?php foreach ($requests as $request): ?>
                    <?php
                        $status = $request['status'];

                        $statusClass = match ($status) {
                            'Active' => 'active',
                            'Pending Approval' => 'pending',
                            'Support Received' => 'received',
                            'Completed' => 'completed',
                            'Closed' => 'closed',
                            'Rejected' => 'rejected',
                            'Draft' => 'draft',
                            default => 'closed'
                        };

                        $tabGroup = match ($status) {
                            'Active', 'Support Received' => 'Active',
                            'Pending Approval' => 'Pending Approval',
                            'Completed' => 'Completed',
                            'Closed', 'Rejected' => 'Closed',
                            'Draft' => 'Drafts',
                            default => 'All'
                        };
                    ?>

                    <article class="ms-request-card"
                        data-id="<?php echo (int) $request['id']; ?>"
                        data-title="<?php echo htmlspecialchars($request['title'], ENT_QUOTES); ?>"
                        data-category="<?php echo htmlspecialchars($request['category'], ENT_QUOTES); ?>"
                        data-status="<?php echo htmlspecialchars($status, ENT_QUOTES); ?>"
                        data-tab="<?php echo htmlspecialchars($tabGroup, ENT_QUOTES); ?>">

                        <div class="ms-request-card-main">

                            <div class="ms-request-icon">
                                <i class="fa-solid fa-hand-holding-heart"></i>
                            </div>

                            <div class="ms-request-details">
                                <div class="ms-card-title-row">
                                    <h3>
                                        <?php echo htmlspecialchars($request['title']); ?>
                                    </h3>

                                    <span class="ms-status ms-status-<?php echo $statusClass; ?>">
                                        <span class="ms-status-dot"></span>
                                        <?php echo htmlspecialchars($status); ?>
                                    </span>
                                </div>

                                <div class="ms-request-category">
                                    <span>
                                        <i class="fa-solid fa-layer-group"></i>
                                        <?php echo htmlspecialchars($request['category']); ?>
                                    </span>

                                    <span>
                                        <i class="fa-solid fa-users"></i>
                                        <?php echo htmlspecialchars($request['community']); ?>
                                    </span>
                                </div>

                                <div class="ms-request-meta">
                                    <span>
                                        <i class="fa-solid fa-location-dot"></i>
                                        <?php echo htmlspecialchars($request['location']); ?>
                                    </span>

                                    <span>
                                        <i class="fa-regular fa-calendar"></i>
                                        Submitted: <?php echo htmlspecialchars($request['date']); ?>
                                    </span>

                                    <span class="ms-urgency ms-urgency-<?php echo strtolower($request['urgency']); ?>">
                                        <i class="fa-solid fa-bolt"></i>
                                        <?php echo htmlspecialchars($request['urgency']); ?> Priority
                                    </span>
                                </div>
                            </div>

                        </div>

                        <!-- Support Summary -->
                        <div class="ms-request-stats">
                            <div class="ms-mini-stat">
                                <i class="fa-solid fa-handshake-angle"></i>
                                <div>
                                    <strong><?php echo (int) $request['offers']; ?></strong>
                                    <span>Offers of Help</span>
                                </div>
                            </div>

                            <div class="ms-mini-stat">
                                <i class="fa-regular fa-message"></i>
                                <div>
                                    <strong><?php echo (int) $request['responses']; ?></strong>
                                    <span>Responses</span>
                                </div>
                            </div>

                            <div class="ms-mini-stat ms-updated-stat">
                                <i class="fa-regular fa-clock"></i>
                                <div>
                                    <strong>Last Updated</strong>
                                    <span><?php echo htmlspecialchars($request['updated']); ?></span>
                                </div>
                            </div>
                        </div>

                        <?php if ($status === 'Rejected'): ?>
                            <div class="ms-rejection-notice">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <div>
                                    <strong>Changes required</strong>
                                    <p><?php echo htmlspecialchars($request['reason']); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Actions -->
                        <div class="ms-request-actions">
                            <a href="support-request-details.php?id=<?php echo (int) $request['id']; ?>"
                               class="ms-action-btn ms-action-view">
                                <i class="fa-regular fa-eye"></i>
                                View Details
                            </a>

                            <?php if (in_array($status, ['Draft', 'Rejected'], true)): ?>
                                <a href="create-support-request.php?id=<?php echo (int) $request['id']; ?>"
                                   class="ms-action-btn ms-action-edit">
                                    <i class="fa-solid fa-pen"></i>
                                    <?php echo $status === 'Rejected' ? 'Edit & Resubmit' : 'Continue Draft'; ?>
                                </a>
                            <?php elseif (in_array($status, ['Active', 'Pending Approval'], true)): ?>
                                <a href="edit-support-request.php?id=<?php echo (int) $request['id']; ?>"
                                   class="ms-action-btn ms-action-edit">
                                    <i class="fa-solid fa-pen"></i>
                                    Edit
                                </a>
                            <?php endif; ?>

                            <?php if ($status === 'Rejected'): ?>
                                <button type="button"
                                        class="ms-action-btn ms-action-reason"
                                        data-reason="<?php echo htmlspecialchars($request['reason'], ENT_QUOTES); ?>"
                                        data-title="<?php echo htmlspecialchars($request['title'], ENT_QUOTES); ?>">
                                    <i class="fa-solid fa-circle-info"></i>
                                    View Reason
                                </button>
                            <?php endif; ?>

                            <?php if (in_array($status, ['Active', 'Pending Approval'], true)): ?>
                                <button type="button"
                                        class="ms-action-btn ms-action-close"
                                        data-close-request="<?php echo (int) $request['id']; ?>"
                                        data-title="<?php echo htmlspecialchars($request['title'], ENT_QUOTES); ?>">
                                    <i class="fa-solid fa-ban"></i>
                                    Close Request
                                </button>
                            <?php endif; ?>
                        </div>

                    </article>
                    <?php endforeach; ?>

                    <!-- Empty state -->
                    <div class="ms-empty-state" id="emptyState" hidden>
                        <div class="ms-empty-icon">
                            <i class="fa-solid fa-folder-open"></i>
                        </div>
                        <h3 id="emptyTitle">No support requests found</h3>
                        <p id="emptyDescription">
                            You have not submitted any support requests yet.
                        </p>
                        <a href="create-support-request.php" class="ms-btn ms-btn-primary">
                            <i class="fa-solid fa-plus"></i>
                            Create Support Request
                        </a>
                    </div>

                </div>

            </section>

            <!-- Bottom CTA -->
            <section class="ms-bottom-cta">
                <div class="ms-cta-icon">
                    <i class="fa-solid fa-heart-circle-plus"></i>
                </div>
                <div class="ms-cta-content">
                    <h3>Need Additional Community Support?</h3>
                    <p>
                        Submit a new request and connect with community
                        members who may be able to help.
                    </p>
                </div>
                <a href="create-support-request.php" class="ms-btn ms-btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Request Support
                </a>
            </section>

        </div>
    </section>

</main>

<!-- Close Request Confirmation -->
<div class="ms-modal" id="closeModal" aria-hidden="true">
    <div class="ms-modal-overlay" data-ms-close></div>

    <div class="ms-modal-dialog" role="dialog"
         aria-modal="true" aria-labelledby="closeModalTitle">

        <div class="ms-modal-icon ms-modal-warning">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>

        <h2 id="closeModalTitle">Close This Request?</h2>
        <p id="closeModalText">
            Are you sure you want to close this support request?
        </p>

        <form action="close-support-request.php" method="POST" id="closeForm">
            <input type="hidden" name="request_id" id="closeRequestId">

            <div class="ms-modal-actions">
                <button type="button" class="ms-btn ms-btn-outline" data-ms-close>
                    Cancel
                </button>
                <button type="submit" class="ms-btn ms-btn-danger">
                    Yes, Close Request
                </button>
            </div>
        </form>

        <p class="ms-modal-note">
            The server must verify request ownership and eligibility before closing it.
        </p>
    </div>
</div>

<!-- Rejection Reason Modal -->
<div class="ms-modal" id="reasonModal" aria-hidden="true">
    <div class="ms-modal-overlay" data-ms-close></div>

    <div class="ms-modal-dialog" role="dialog"
         aria-modal="true" aria-labelledby="reasonModalTitle">

        <div class="ms-modal-icon ms-modal-warning">
            <i class="fa-solid fa-file-circle-exclamation"></i>
        </div>

        <h2 id="reasonModalTitle">Review Rejection Reason</h2>
        <p id="reasonRequestTitle" class="ms-reason-request-title"></p>

        <div class="ms-reason-box" id="reasonText"></div>

        <div class="ms-modal-actions">
            <button type="button" class="ms-btn ms-btn-outline" data-ms-close>
                Close
            </button>
            <a href="#" id="resubmitLink" class="ms-btn ms-btn-primary">
                <i class="fa-solid fa-pen"></i>
                Edit &amp; Resubmit
            </a>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="ms-toast" id="msToast" role="status" aria-live="polite">
    <i class="fa-solid fa-circle-check"></i>
    <span id="msToastText"></span>
</div>

<?php include 'footer.php'; ?>

 

 
