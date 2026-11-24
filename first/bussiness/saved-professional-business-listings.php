<?php
// Saved Professionals & Businesses (live: the member's saved directory profiles — directory_saved / directory_save)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();
$_REQUEST['per'] = 50; $_REQUEST['page'] = 1;
$svItems = array_map('web_dir_card', web_call('directory_saved', ['per' => 50])['items'] ?? []);
$svAt = array_column(rows("SELECT entity_id, created_at FROM favourites WHERE user_id=? AND entity='directory_profiles'", [$webUid]), 'created_at', 'entity_id');
$svJs = array_map(fn($d) => ['id' => (int)$d['id'], 'type' => $d['is_business'] ? 'business' : 'professional', 'name' => $d['title'], 'category' => $d['category_name'],
    'service' => implode(' · ', array_slice($d['services_list'], 0, 3)) ?: $d['category_text'], 'location' => $d['location_text'],
    'description' => mb_strimwidth((string)$d['description'], 0, 160, '…'),
    'image' => $d['image'] ?: 'https://ui-avatars.com/api/?background=0b4f8c&color=fff&name=' . rawurlencode($d['initials']),
    'savedAt' => str_replace(' ', 'T', (string)($svAt[$d['id']] ?? $d['created_at'])), 'status' => 'active',
    'profile' => 'professional-business-profile-details.php?id=' . (int)$d['id']], $svItems);
include 'header.php'; ?>
<script>window.SAVED_DIR=<?= json_encode($svJs, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES) ?>;</script>

  <main class="pl-page">
    <section class="pl-hero">
      <div class="pl-hero-orb orb-one"></div><div class="pl-hero-orb orb-two"></div>
      <div class="pl-hero-inner">
        <div class="pl-breadcrumb"><a href="#"><i class="bi bi-house-door"></i> Home</a><i class="bi bi-chevron-right"></i><a href="#">Directory</a><i class="bi bi-chevron-right"></i><span>Saved listings</span></div>
        <div class="pl-hero-content">
          <div>
            <span class="pl-eyebrow"><i class="bi bi-bookmark-heart"></i> YOUR PERSONAL DIRECTORY</span>
            <h1>Saved Professionals <span>&amp; Businesses</span></h1>
            <p>Keep trusted professionals and useful businesses close at hand. Your shortlist, all in one place.</p>
            <div class="pl-hero-actions"><a class="pl-btn pl-btn-light" href="#savedListings"><i class="bi bi-bookmarks"></i> View saved listings</a><a class="pl-btn pl-btn-outline" href="professional-and-business-directory-search-results.php"><i class="bi bi-search"></i> Browse directory</a></div>
          </div>
          <div class="pl-hero-stat"><span class="stat-icon"><i class="bi bi-bookmark-star"></i></span><span class="stat-label">Saved listings</span><strong id="heroSavedCount">6</strong><span class="stat-foot"><i class="bi bi-shield-check"></i> Your shortlist at a glance</span></div>
        </div>
      </div>
    </section>

    <section class="pl-main" id="savedListings">
      <div class="pl-page-heading">
        <div><span class="pl-section-kicker">YOUR SHORTLIST</span><h2>Listings you’ve saved</h2><p>Review details, get in touch, or remove listings you no longer need.</p></div>
        <div class="pl-heading-count"><span id="resultCount">6</span> <span>saved listings</span></div>
      </div>

      <div class="pl-toolbar">
        <label class="pl-search"><i class="bi bi-search"></i><input id="listingSearch" type="search" placeholder="Search name, service or keyword..." aria-label="Search saved listings"><kbd>⌕</kbd></label>
        <label class="pl-sort"><span>Sort by</span><select id="sortBy" aria-label="Sort listings"><option value="recent">Recently saved</option><option value="name">Name A–Z</option></select></label>
      </div>

      <div class="pl-filter-row">
        <div class="pl-type-tabs" role="group" aria-label="Filter by listing type">
          <button class="type-tab active" data-type="all"><i class="bi bi-grid"></i> All listings <span id="allTabCount">6</span></button>
          <button class="type-tab" data-type="professional"><i class="bi bi-person-workspace"></i> Professionals <span id="professionalTabCount">3</span></button>
          <button class="type-tab" data-type="business"><i class="bi bi-buildings"></i> Businesses <span id="businessTabCount">3</span></button>
        </div>
        <div class="pl-filter-controls">
          <label><i class="bi bi-tags"></i><select id="categoryFilter" aria-label="Filter by category"><option value="">All categories</option></select></label>
          <label><i class="bi bi-geo-alt"></i><select id="locationFilter" aria-label="Filter by location"><option value="">All locations</option></select></label>
          <button class="pl-reset" id="resetFilters"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
        </div>
      </div>

      <div class="pl-content-grid">
        <div class="pl-results-column">
          <div class="pl-results-meta"><span id="resultsMessage">Showing all saved listings</span><span class="sort-note"><i class="bi bi-clock-history"></i> Recently saved first</span></div>
          <div class="pl-listings" id="listingGrid" aria-live="polite"></div>
          <div class="pl-no-results" id="noResults" hidden>
            <div class="empty-icon"><i class="bi bi-bookmark-heart"></i></div>
            <h3>You have not saved any professional or business listings yet.</h3>
            <p>Explore the directory and save listings you may want to contact later.</p>
            <a class="pl-btn pl-btn-primary" href="professional-and-business-directory-search-results.php"><i class="bi bi-search"></i> Browse Directory</a>
          </div>
          <div class="pl-load-more-wrap" id="loadMoreWrap"><button class="pl-load-more" id="loadMore">Load more listings <i class="bi bi-arrow-down-circle"></i></button></div>
        </div>

        <aside class="pl-sidebar">
          <div class="sidebar-card summary-card">
            <div class="sidebar-card-head"><span class="side-icon blue"><i class="bi bi-bookmark-check"></i></span><span class="side-title">Your saved list</span></div>
            <div class="summary-total"><strong id="sideTotal">6</strong><span>listings saved</span></div>
            <div class="summary-breakdown"><div><span class="dot professional-dot"></span> Professionals <strong id="sideProfessionals">3</strong></div><div><span class="dot business-dot"></span> Businesses <strong id="sideBusinesses">3</strong></div></div>
            <div class="summary-tip"><i class="bi bi-lightbulb"></i><p>Save useful listings so you can compare options and reach out when you’re ready.</p></div>
          </div>
          <div class="sidebar-card quick-card">
            <span class="side-icon green"><i class="bi bi-compass"></i></span><h3>Discover someone new</h3><p>Find trusted professionals and businesses from your community.</p><a href="professional-and-business-directory-search-results.php">Explore directory <i class="bi bi-arrow-up-right"></i></a>
          </div>
          <div class="sidebar-card privacy-card"><i class="bi bi-lock"></i><div><strong>Your shortlist is personal</strong><p>Your saved listings are intended for your account and future reference.</p></div></div>
        </aside>
      </div>
      <footer class="pl-page-footer"><span><i class="bi bi-heart-fill"></i> Built for stronger community connections</span><a href="#">PeopleLink Community Directory <i class="bi bi-arrow-up-right"></i></a></footer>
    </section>
  </main>

  <div class="pl-toast" id="toast" role="status" aria-live="polite"><i class="bi bi-check-circle-fill"></i><span id="toastMessage">Listing removed from saved items.</span></div>
  <div class="pl-modal-backdrop" id="contactModal" hidden>
    <section class="pl-modal" role="dialog" aria-modal="true" aria-labelledby="contactModalTitle">
      <button class="modal-close" data-close-modal aria-label="Close"><i class="bi bi-x-lg"></i></button>
      <div class="modal-icon"><i class="bi bi-chat-dots"></i></div><span class="pl-section-kicker">CONNECT ON PEOPLELINK</span>
      <h2 id="contactModalTitle">Contact listing</h2><p class="modal-subtitle" id="contactListingName">Send an enquiry to this listing.</p>
      <form id="contactForm">
        <div class="form-field"><label for="contactName">Your name</label><input id="contactName" name="name" required placeholder="Enter your name"></div>
        <div class="form-field"><label for="contactEmail">Email address</label><input id="contactEmail" name="email" type="email" required placeholder="you@example.com"></div>
        <div class="form-field"><label for="contactMessage">Message</label><textarea id="contactMessage" name="message" rows="4" required placeholder="Tell them what you need..."></textarea></div>
        <button class="pl-btn pl-btn-primary submit-enquiry" type="submit">Prepare enquiry <i class="bi bi-send"></i></button>
        <p class="demo-note"><i class="bi bi-info-circle"></i> Demo interaction: connect this form to your enquiry backend to send messages.</p>
      </form>
    </section>
  </div>

<?php include 'footer.php'; ?>
