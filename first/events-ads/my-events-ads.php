<?php
include 'header.php';

/*
 * PeopleLink — Page 6: My Events & Advertisements
 * Demo records are used here. Replace them with records belonging to the
 * authenticated user, loaded securely from your database.
 */
$items = [
    [
        'id' => 201, 'title' => 'Annual Community Meet 2026', 'type' => 'event',
        'category' => 'Community Gathering', 'date_label' => '24 Oct 2026 · 10:00 AM',
        'location' => 'Rishikesh, Uttarakhand', 'submitted' => '10 Oct 2026',
        'status' => 'Active', 'image' => 'images/events/community-meet.jpg',
        'registrations' => 86, 'enquiries' => 12, 'views' => null, 'reason' => ''
    ],
    [
        'id' => 202, 'title' => 'Diwali Special Catering Offer', 'type' => 'advertisement',
        'category' => 'Food & Catering', 'date_label' => 'Valid 12–31 Oct 2026',
        'location' => 'Dehradun, Uttarakhand', 'submitted' => '09 Oct 2026',
        'status' => 'Pending Approval', 'image' => 'images/advertisements/catering-offer.jpg',
        'registrations' => null, 'enquiries' => 7, 'views' => 328, 'reason' => ''
    ],
    [
        'id' => 203, 'title' => 'Youth Career Guidance Workshop', 'type' => 'event',
        'category' => 'Education / Workshop', 'date_label' => '05 Oct 2026 · 11:00 AM',
        'location' => 'Haridwar, Uttarakhand', 'submitted' => '25 Sep 2026',
        'status' => 'Completed', 'image' => 'images/events/career-workshop.jpg',
        'registrations' => 54, 'enquiries' => 9, 'views' => null, 'reason' => ''
    ],
    [
        'id' => 204, 'title' => 'Professional Website Design Service', 'type' => 'advertisement',
        'category' => 'Professional Services', 'date_label' => 'Valid 01–30 Sep 2026',
        'location' => 'India · Online', 'submitted' => '01 Sep 2026',
        'status' => 'Rejected', 'image' => 'images/advertisements/web-design.jpg',
        'registrations' => null, 'enquiries' => 3, 'views' => 145, 'reason' => 'Please update the advertisement image and clarify the offer terms before resubmitting.'
    ],
    [
        'id' => 205, 'title' => 'Local Business Networking Evening', 'type' => 'event',
        'category' => 'Business & Networking', 'date_label' => 'Draft · No date set',
        'location' => 'Not set', 'submitted' => '14 Oct 2026',
        'status' => 'Draft', 'image' => 'images/events/networking.jpg',
        'registrations' => null, 'enquiries' => null, 'views' => null, 'reason' => ''
    ],
    [
        'id' => 206, 'title' => 'Community Book & Stationery Sale', 'type' => 'advertisement',
        'category' => 'Retail & Shopping', 'date_label' => 'Closed by you · 08 Oct 2026',
        'location' => 'Rishikesh, Uttarakhand', 'submitted' => '28 Sep 2026',
        'status' => 'Closed', 'image' => 'images/advertisements/stationery-sale.jpg',
        'registrations' => null, 'enquiries' => 14, 'views' => 512, 'reason' => ''
    ],
];
function plma_e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
?>
<link rel="stylesheet" href="css/my-events-ads.css">

<main class="plma-page">
  <section class="plma-hero">
    <div class="plma-wrap plma-hero-inner">
      <div class="plma-hero-copy">
        <span class="plma-eyebrow"><i class="fa-solid fa-folder-open"></i> YOUR PEOPLELINK ACTIVITY</span>
        <h1>My Events & <span>Advertisements</span></h1>
        <p>Keep track of your submissions, update your posts, and manage what your community sees — all in one place.</p>
        <div class="plma-hero-points"><span><i class="fa-solid fa-check-circle"></i> One simple dashboard</span><span><i class="fa-solid fa-shield-halved"></i> Approval status at a glance</span></div>
      </div>
      <a class="plma-add-btn" href="post-event-ad.php"><i class="fa-solid fa-plus"></i><span>Post Event / Advertisement</span><i class="fa-solid fa-arrow-up-right-from-square plma-add-arrow"></i></a>
    </div>
  </section>

  <section class="plma-wrap plma-main">
    <div class="plma-page-heading">
      <div><span class="plma-kicker">MANAGE YOUR POSTS</span><h2>Your submissions</h2><p>View status, check performance, and take action on each post.</p></div>
      <div class="plma-total"><span class="plma-total-icon"><i class="fa-solid fa-layer-group"></i></span><span><strong id="plmaTotalCount">6</strong><small>Total posts</small></span></div>
    </div>

    <div class="plma-stats" aria-label="Submission summary">
      <button type="button" class="plma-stat is-active" data-stat-filter="all"><span class="plma-stat-icon plma-stat-blue"><i class="fa-solid fa-border-all"></i></span><span><small>All posts</small><strong data-stat-count="all">6</strong></span></button>
      <button type="button" class="plma-stat" data-stat-filter="active"><span class="plma-stat-icon plma-stat-green"><i class="fa-solid fa-circle-check"></i></span><span><small>Active</small><strong data-stat-count="active">1</strong></span></button>
      <button type="button" class="plma-stat" data-stat-filter="pending"><span class="plma-stat-icon plma-stat-orange"><i class="fa-regular fa-hourglass-half"></i></span><span><small>Pending approval</small><strong data-stat-count="pending">1</strong></span></button>
      <button type="button" class="plma-stat" data-stat-filter="drafts"><span class="plma-stat-icon plma-stat-purple"><i class="fa-regular fa-file-lines"></i></span><span><small>Drafts</small><strong data-stat-count="drafts">1</strong></span></button>
    </div>

    <div class="plma-toolbar">
      <div class="plma-tabs" role="tablist" aria-label="Filter submissions by status">
        <button type="button" role="tab" aria-selected="true" class="is-active" data-tab="all">All Posts <span data-tab-count="all">6</span></button>
        <button type="button" role="tab" aria-selected="false" data-tab="active">Active</button>
        <button type="button" role="tab" aria-selected="false" data-tab="pending">Pending Approval</button>
        <button type="button" role="tab" aria-selected="false" data-tab="drafts">Drafts</button>
        <button type="button" role="tab" aria-selected="false" data-tab="completed">Completed / Expired</button>
        <button type="button" role="tab" aria-selected="false" data-tab="rejected">Rejected</button>
      </div>
      <div class="plma-filters">
        <label class="plma-search"><i class="fa-solid fa-magnifying-glass"></i><input id="plmaSearch" type="search" placeholder="Search your posts..." aria-label="Search your posts"></label>
        <select id="plmaTypeFilter" aria-label="Filter by type"><option value="all">All types</option><option value="event">Events</option><option value="advertisement">Advertisements</option></select>
        <select id="plmaStatusFilter" aria-label="Filter by status"><option value="all">All statuses</option><option value="draft">Draft</option><option value="pending">Pending Approval</option><option value="active">Active</option><option value="rejected">Rejected</option><option value="completed">Completed</option><option value="expired">Expired</option><option value="closed">Closed</option></select>
      </div>
    </div>

    <div class="plma-results-head"><p id="plmaResultSummary">Showing 6 posts</p><span><i class="fa-solid fa-sliders"></i> Filter your submissions</span></div>
    <div class="plma-list" id="plmaList">
      <?php foreach ($items as $item): ?>
      <?php
        $statusKey = strtolower(str_replace(' ', '-', $item['status']));
        if ($item['status'] === 'Pending Approval') $statusKey = 'pending';
        if ($item['status'] === 'Completed') $statusKey = 'completed';
        $isEvent = $item['type'] === 'event';
      ?>
      <article class="plma-item" data-id="<?= (int)$item['id'] ?>" data-type="<?= plma_e($item['type']) ?>" data-status="<?= plma_e($statusKey) ?>" data-title="<?= plma_e(strtolower($item['title'])) ?>" data-category="<?= plma_e(strtolower($item['category'])) ?>" data-location="<?= plma_e(strtolower($item['location'])) ?>" data-reason="<?= plma_e($item['reason']) ?>">
        <div class="plma-item-image">
          <img src="<?= plma_e($item['image']) ?>" alt="<?= plma_e($item['title']) ?>" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='grid'">
          <span class="plma-image-fallback" style="display:none"><i class="fa-solid <?= $isEvent ? 'fa-calendar-days' : 'fa-bullhorn' ?>"></i></span>
          <span class="plma-type-tag <?= $isEvent ? 'is-event' : 'is-ad' ?>"><i class="fa-solid <?= $isEvent ? 'fa-calendar-days' : 'fa-bullhorn' ?>"></i><?= $isEvent ? 'Event' : 'Advertisement' ?></span>
        </div>
        <div class="plma-item-content">
          <div class="plma-item-topline"><span class="plma-category"><?= plma_e($item['category']) ?></span><span class="plma-status plma-status-<?= plma_e($statusKey) ?>"><b></b><?= plma_e($item['status']) ?></span></div>
          <h3><?= plma_e($item['title']) ?></h3>
          <div class="plma-meta-row">
            <span><i class="fa-regular fa-calendar"></i><?= plma_e($item['date_label']) ?></span>
            <span><i class="fa-solid fa-location-dot"></i><?= plma_e($item['location']) ?></span>
            <span><i class="fa-regular fa-paper-plane"></i>Submitted <?= plma_e($item['submitted']) ?></span>
          </div>
          <?php if ($item['status'] === 'Rejected'): ?>
            <div class="plma-rejection-note"><i class="fa-solid fa-circle-exclamation"></i><span><strong>Changes requested</strong><small><?= plma_e($item['reason']) ?></small></span><button type="button" class="plma-text-action" data-action="reason">View reason</button></div>
          <?php endif; ?>
          <div class="plma-item-bottom">
            <div class="plma-mini-stats">
              <?php if ($isEvent): ?>
                <?php if ($item['registrations'] !== null): ?><span><i class="fa-solid fa-user-check"></i><strong><?= (int)$item['registrations'] ?></strong> Registrations</span><?php endif; ?>
                <?php if ($item['enquiries'] !== null): ?><span><i class="fa-regular fa-message"></i><strong><?= (int)$item['enquiries'] ?></strong> Enquiries</span><?php endif; ?>
              <?php else: ?>
                <?php if ($item['enquiries'] !== null): ?><span><i class="fa-regular fa-message"></i><strong><?= (int)$item['enquiries'] ?></strong> Enquiries</span><?php endif; ?>
                <?php if ($item['views'] !== null): ?><span><i class="fa-regular fa-eye"></i><strong><?= (int)$item['views'] ?></strong> Views</span><?php endif; ?>
              <?php endif; ?>
            </div>
            <div class="plma-item-actions">
              <a class="plma-action plma-action-view" href="event-ad-details.php?id=<?= (int)$item['id'] ?>&type=<?= plma_e($item['type']) ?>"><i class="fa-regular fa-eye"></i> View</a>
              <?php if ($item['status'] !== 'Completed' && $item['status'] !== 'Expired'): ?>
                <a class="plma-action" href="edit-event-ad.php?id=<?= (int)$item['id'] ?>"><i class="fa-regular fa-pen-to-square"></i> <?= $item['status'] === 'Rejected' ? 'Edit & Resubmit' : 'Edit' ?></a>
              <?php endif; ?>
              <?php if (in_array($item['status'], ['Active', 'Pending Approval'], true)): ?>
                <button class="plma-action plma-action-warn" type="button" data-action="close"><i class="fa-solid fa-ban"></i> Close</button>
              <?php endif; ?>
              <button class="plma-action plma-action-delete" type="button" data-action="delete"><i class="fa-regular fa-trash-can"></i> Delete</button>
            </div>
          </div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>

    <div class="plma-empty" id="plmaEmpty" hidden><span><i class="fa-regular fa-calendar-xmark"></i></span><h3>You have not posted any events or advertisements yet.</h3><p>Start by sharing an event or promoting something useful with your community.</p><a class="plma-primary-btn" href="post-event-ad.php"><i class="fa-solid fa-plus"></i> Post Now</a></div>
    <div class="plma-no-results" id="plmaNoResults" hidden><i class="fa-solid fa-magnifying-glass"></i><strong>No matching posts found</strong><p>Try changing your search or filters.</p><button type="button" id="plmaResetFilters">Clear filters</button></div>
  </section>
</main>

<div class="plma-modal" id="plmaModal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="plmaModalTitle">
  <div class="plma-modal-shade" data-modal-close></div><div class="plma-modal-box"><header><span class="plma-modal-icon"><i class="fa-solid fa-circle-info"></i></span><button type="button" aria-label="Close dialog" data-modal-close><i class="fa-solid fa-xmark"></i></button></header><h2 id="plmaModalTitle">Confirm action</h2><p id="plmaModalMessage"></p><div class="plma-modal-reason" id="plmaModalReason" hidden></div><footer><button type="button" class="plma-btn plma-btn-light" data-modal-close>Cancel</button><button type="button" class="plma-btn plma-btn-primary" id="plmaModalConfirm">Confirm</button></footer></div>
</div>
<div class="plma-toast" id="plmaToast" role="status" aria-live="polite"><i class="fa-solid fa-circle-check"></i><span><strong id="plmaToastTitle">Done</strong><small id="plmaToastMessage"></small></span><button type="button" id="plmaToastClose" aria-label="Dismiss"><i class="fa-solid fa-xmark"></i></button></div>
 
<?php include 'footer.php'; ?>
