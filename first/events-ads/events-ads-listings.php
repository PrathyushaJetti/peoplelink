<?php
include 'header.php';

/* Front-end sample data.
   Replace this array with database results using the filters received in $_GET. */
$selectedType = isset($_GET['type']) ? trim($_GET['type']) : 'all';
$selectedCategory = isset($_GET['category']) ? trim($_GET['category']) : '';
$selectedLocation = isset($_GET['city']) ? trim($_GET['city']) : (isset($_GET['location']) ? trim($_GET['location']) : '');
$selectedDate = isset($_GET['event_date']) ? trim($_GET['event_date']) : '';
$selectedKeyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : (isset($_GET['q']) ? trim($_GET['q']) : '');
$selectedSort = isset($_GET['sort']) ? trim($_GET['sort']) : 'relevant';

$sampleListings = [
    [
        'id' => 101, 'type' => 'event', 'title' => 'Community Networking Meetup',
        'image' => 'images/events/community-meetup.jpg', 'category' => 'Community',
        'date' => '2026-10-24', 'time' => '10:30 AM – 1:00 PM',
        'location' => 'Community Hall, Your City', 'community' => 'PeopleLink Community',
        'price' => 'Free', 'status' => 'Upcoming',
        'description' => 'Meet community members, exchange ideas and build meaningful professional and personal connections.'
    ],
    [
        'id' => 102, 'type' => 'event', 'title' => 'Business Growth Workshop',
        'image' => 'images/events/business-workshop.jpg', 'category' => 'Workshop',
        'date' => '2026-11-02', 'time' => '2:00 PM – 5:00 PM',
        'location' => 'Business Centre, Your City', 'community' => 'Open to all communities',
        'price' => 'Paid', 'status' => 'Upcoming',
        'description' => 'Explore practical strategies, share business experiences and discover new opportunities.'
    ],
    [
        'id' => 103, 'type' => 'event', 'title' => 'Culture & Community Celebration',
        'image' => 'images/events/cultural-gathering.jpg', 'category' => 'Cultural',
        'date' => '2026-11-09', 'time' => '5:00 PM onwards',
        'location' => 'Central Grounds, Your City', 'community' => 'Community gathering',
        'price' => 'Free', 'status' => 'Upcoming',
        'description' => 'Celebrate culture and traditions with families, friends and community members.'
    ],
    [
        'id' => 104, 'type' => 'advertisement', 'title' => 'Home & Professional Services',
        'image' => 'images/advertisements/home-services.jpg', 'category' => 'Services',
        'business' => 'Your Business Name', 'location' => 'Your City',
        'posted' => '12 Oct 2026', 'featured' => true,
        'description' => 'Explore dependable home and professional services shared by a local business in the network.'
    ],
    [
        'id' => 105, 'type' => 'advertisement', 'title' => 'Local Business Spotlight',
        'image' => 'images/advertisements/local-business.jpg', 'category' => 'Business',
        'business' => 'Community Business', 'location' => 'Your Area',
        'posted' => '11 Oct 2026', 'featured' => false,
        'description' => 'Discover products, services and special offers from businesses in your community.'
    ],
    [
        'id' => 106, 'type' => 'advertisement', 'title' => 'Education & Training Opportunities',
        'image' => 'images/advertisements/education-training.jpg', 'category' => 'Education',
        'business' => 'Learning Centre', 'location' => 'Your City',
        'posted' => '10 Oct 2026', 'featured' => true,
        'description' => 'Find learning programmes, professional training and educational services.'
    ],
];

function plListingEscape($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function plListingDate($date) {
    $timestamp = strtotime($date);
    return $timestamp ? date('d M Y', $timestamp) : $date;
}

/* Keep the sample cards relevant to the selected type and keyword. */
$visibleListings = array_values(array_filter($sampleListings, function ($item) use ($selectedType, $selectedKeyword) {
    if ($selectedType !== '' && $selectedType !== 'all' && $item['type'] !== $selectedType) {
        return false;
    }
    if ($selectedKeyword !== '') {
        $haystack = strtolower($item['title'] . ' ' . $item['category'] . ' ' . ($item['description'] ?? '') . ' ' . ($item['business'] ?? ''));
        if (strpos($haystack, strtolower($selectedKeyword)) === false) {
            return false;
        }
    }
    return true;
}));
?>

<main class="pl-results-page">
  <section class="pl-results-hero">
    <div class="pl-results-hero__content">
      <span class="pl-results-eyebrow"><i class="fa-solid fa-compass"></i> PEOPLELINK COMMUNITY BOARD</span>
      <h1>Events &amp; Advertisements</h1>
      <p>Explore community events, local business promotions and opportunities that bring people together.</p>
      <div class="pl-results-hero__actions">
        <a href="events-ads-search.php" class="pl-results-btn pl-results-btn--light"><i class="fa-solid fa-sliders"></i> Edit Filters</a>
        <a href="events-ads-home.php" class="pl-results-btn pl-results-btn--outline"><i class="fa-solid fa-house"></i> Explore Home</a>
      </div>
    </div>
    <div class="pl-results-hero__visual" aria-hidden="true">
      <div class="pl-results-orbit pl-results-orbit--one"></div>
      <div class="pl-results-orbit pl-results-orbit--two"></div>
      <div class="pl-results-hero-icon"><i class="fa-solid fa-calendar-check"></i></div>
      <span class="pl-results-float pl-results-float--one"><i class="fa-solid fa-bullhorn"></i></span>
      <span class="pl-results-float pl-results-float--two"><i class="fa-solid fa-people-group"></i></span>
    </div>
  </section>

  <section class="pl-results-toolbar">
    <div class="pl-results-summary">
      <div class="pl-results-count"><strong id="plVisibleCount"><?php echo count($visibleListings); ?></strong><span>Sample results found</span></div>
      <div class="pl-results-selected">
        <span><i class="fa-solid fa-layer-group"></i> <?php echo plListingEscape($selectedType === 'event' ? 'Events' : ($selectedType === 'advertisement' ? 'Advertisements' : 'All listings')); ?></span>
        <?php if ($selectedCategory !== ''): ?><span><i class="fa-solid fa-shapes"></i> <?php echo plListingEscape($selectedCategory); ?></span><?php endif; ?>
        <?php if ($selectedLocation !== ''): ?><span><i class="fa-solid fa-location-dot"></i> <?php echo plListingEscape($selectedLocation); ?></span><?php endif; ?>
        <?php if ($selectedDate !== ''): ?><span><i class="fa-regular fa-calendar"></i> <?php echo plListingEscape($selectedDate); ?></span><?php endif; ?>
        <?php if ($selectedKeyword !== ''): ?><span><i class="fa-solid fa-magnifying-glass"></i> <?php echo plListingEscape($selectedKeyword); ?></span><?php endif; ?>
      </div>
    </div>
    <div class="pl-results-controls">
      <a href="events-ads-search.php" class="pl-results-edit"><i class="fa-solid fa-pen-to-square"></i> Edit Filters</a>
      <label class="pl-results-sort"><span>Sort by</span><select id="plResultsSort" name="sort">
        <option value="relevant" <?php echo $selectedSort === 'relevant' ? 'selected' : ''; ?>>Most Relevant</option>
        <option value="latest" <?php echo $selectedSort === 'latest' ? 'selected' : ''; ?>>Latest</option>
        <option value="upcoming" <?php echo $selectedSort === 'upcoming' ? 'selected' : ''; ?>>Upcoming First</option>
        <option value="recently-added" <?php echo $selectedSort === 'recently-added' ? 'selected' : ''; ?>>Recently Added</option>
      </select></label>
    </div>
  </section>

  <section class="pl-results-main">
    <div class="pl-results-section-heading">
      <div><span class="pl-results-kicker">DISCOVER WHAT'S HAPPENING</span><h2>Matching listings</h2><p>Browse the latest events and advertisements from the community.</p></div>
      <div class="pl-results-view-switch" role="group" aria-label="Listing view">
        <button type="button" class="is-active" data-view="grid" aria-label="Grid view"><i class="fa-solid fa-grip"></i></button>
        <button type="button" data-view="list" aria-label="List view"><i class="fa-solid fa-list"></i></button>
      </div>
    </div>

    <?php if (count($visibleListings) > 0): ?>
    <div class="pl-results-grid" id="plResultsGrid">
      <?php foreach ($visibleListings as $index => $item): ?>
        <?php if ($item['type'] === 'event'): ?>
          <article class="pl-result-card pl-event-result" data-kind="event" data-index="<?php echo $index; ?>" data-title="<?php echo plListingEscape(strtolower($item['title'])); ?>">
            <a class="pl-result-image" href="event-ad-details.php?id=<?php echo (int)$item['id']; ?>">
              <img src="<?php echo plListingEscape($item['image']); ?>" alt="<?php echo plListingEscape($item['title']); ?>" loading="lazy">
              <span class="pl-result-category"><i class="fa-solid fa-calendar-days"></i> <?php echo plListingEscape($item['category']); ?></span>
              <span class="pl-result-status <?php echo strtolower($item['status']) === 'ongoing' ? 'is-ongoing' : ''; ?>"><?php echo plListingEscape($item['status']); ?></span>
            </a>
            <div class="pl-result-card__body">
              <div class="pl-event-date"><strong><?php echo date('d', strtotime($item['date'])); ?></strong><span><?php echo strtoupper(date('M', strtotime($item['date']))); ?></span></div>
              <div class="pl-result-content">
                <h3><a href="event-ad-details.php?id=<?php echo (int)$item['id']; ?>"><?php echo plListingEscape($item['title']); ?></a></h3>
                <div class="pl-result-meta"><span><i class="fa-regular fa-clock"></i> <?php echo plListingEscape($item['time']); ?></span><span><i class="fa-solid fa-location-dot"></i> <?php echo plListingEscape($item['location']); ?></span></div>
                <p class="pl-result-description"><?php echo plListingEscape($item['description']); ?></p>
                <div class="pl-event-extra"><span class="pl-price-tag <?php echo strtolower($item['price']) === 'free' ? 'is-free' : 'is-paid'; ?>"><?php echo plListingEscape($item['price']); ?></span><span><i class="fa-solid fa-people-group"></i> <?php echo plListingEscape($item['community']); ?></span></div>
                <div class="pl-result-actions"><a class="pl-result-primary" href="event-ad-details.php?id=<?php echo (int)$item['id']; ?>">View Details <i class="fa-solid fa-arrow-right"></i></a><a class="pl-result-secondary" href="event-ad-details.php?id=<?php echo (int)$item['id']; ?>#register">Register / Enquire</a></div>
              </div>
            </div>
          </article>
        <?php else: ?>
          <article class="pl-result-card pl-ad-result" data-kind="advertisement" data-index="<?php echo $index; ?>" data-title="<?php echo plListingEscape(strtolower($item['title'])); ?>">
            <a class="pl-result-image" href="event-ad-details.php?id=<?php echo (int)$item['id']; ?>">
              <img src="<?php echo plListingEscape($item['image']); ?>" alt="<?php echo plListingEscape($item['title']); ?>" loading="lazy">
              <span class="pl-result-category"><i class="fa-solid fa-bullhorn"></i> <?php echo plListingEscape($item['category']); ?></span>
              <?php if (!empty($item['featured'])): ?><span class="pl-result-featured"><i class="fa-solid fa-star"></i> Featured</span><?php endif; ?>
            </a>
            <div class="pl-result-card__body pl-ad-result__body">
              <div class="pl-ad-business"><span class="pl-ad-business__icon"><i class="fa-solid fa-store"></i></span><div><strong><?php echo plListingEscape($item['business']); ?></strong><small><i class="fa-solid fa-location-dot"></i> <?php echo plListingEscape($item['location']); ?></small></div></div>
              <h3><a href="event-ad-details.php?id=<?php echo (int)$item['id']; ?>"><?php echo plListingEscape($item['title']); ?></a></h3>
              <p class="pl-result-description"><?php echo plListingEscape($item['description']); ?></p>
              <div class="pl-ad-posted"><i class="fa-regular fa-clock"></i> Posted <?php echo plListingEscape($item['posted']); ?></div>
              <div class="pl-result-actions"><a class="pl-result-primary" href="event-ad-details.php?id=<?php echo (int)$item['id']; ?>">View Details <i class="fa-solid fa-arrow-right"></i></a><a class="pl-result-secondary" href="event-ad-details.php?id=<?php echo (int)$item['id']; ?>#contact">Contact / Enquire</a></div>
            </div>
          </article>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
    <div class="pl-results-load-wrap"><button type="button" class="pl-results-load" id="plLoadMore">Load More <i class="fa-solid fa-chevron-down"></i></button><p id="plLoadMessage" aria-live="polite"></p></div>
    <?php else: ?>
    <div class="pl-results-empty">
      <div class="pl-results-empty__art"><i class="fa-solid fa-magnifying-glass"></i><span><i class="fa-solid fa-calendar-days"></i></span></div>
      <h2>No events or advertisements found</h2>
      <p>We couldn't find sample listings matching your search. Try changing your keywords or filters.</p>
      <div class="pl-results-empty__actions"><a href="events-ads-search.php" class="pl-results-btn pl-results-btn--primary"><i class="fa-solid fa-sliders"></i> Modify Filters</a><a href="events-ads-home.php" class="pl-results-btn pl-results-btn--soft">View All Events &amp; Ads</a></div>
    </div>
    <?php endif; ?>
  </section>

  <section class="pl-results-bottom-cta">
    <div class="pl-results-bottom-cta__icon"><i class="fa-solid fa-bullhorn"></i></div>
    <div><h2>Have an event or business to promote?</h2><p>Share your listing with the PeopleLink community.</p></div>
    <a href="post-event-ad.php" class="pl-results-btn pl-results-btn--light">Create a Listing <i class="fa-solid fa-arrow-right"></i></a>
  </section>
</main>

 
<?php include 'footer.php'; ?>