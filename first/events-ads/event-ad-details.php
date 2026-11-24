<?php
include 'header.php';

/* Front-end demonstration data. Replace this sample record with a database query
   using the ID and content type from the URL, after validating both server-side. */
$listingId = isset($_GET['id']) ? (int) $_GET['id'] : 101;
$listingType = isset($_GET['type']) ? strtolower(trim($_GET['type'])) : 'event';

$sampleEvent = [
    'id' => 101,
    'type' => 'event',
    'title' => 'Community Networking Meetup',
    'image' => 'images/events/community-meetup.jpg',
    'category' => 'Community',
    'date' => '24 October 2026',
    'time' => '10:30 AM – 1:00 PM',
    'venue' => 'Community Hall, Your City',
    'community' => 'PeopleLink Community',
    'price' => 'Free Entry',
    'organiser' => 'PeopleLink Community Team',
    'contact' => 'Contact details available on request',
    'description' => 'Join community members, professionals and local businesses for a welcoming networking meetup. Share ideas, meet new people and discover ways to contribute to your community.',
    'program' => 'Welcome and introductions, community updates, member networking, open discussion and closing announcements.',
    'schedule' => [
        ['time' => '10:30 AM', 'title' => 'Arrival & Registration'],
        ['time' => '11:00 AM', 'title' => 'Welcome and Introductions'],
        ['time' => '11:30 AM', 'title' => 'Community Networking'],
        ['time' => '12:30 PM', 'title' => 'Open Discussion & Closing']
    ],
    'venue_info' => 'The exact venue details and directions will be confirmed by the organiser. Please contact the organiser before travelling.',
    'attendees' => 'Community members, families, professionals and interested guests.',
    'registration' => 'Please register or contact the organiser to confirm your attendance.',
    'live_url' => ''
];

$sampleAd = [
    'id' => 104,
    'type' => 'advertisement',
    'title' => 'Home & Professional Services',
    'image' => 'images/advertisements/home-services.jpg',
    'business' => 'Your Business Name',
    'category' => 'Services',
    'location' => 'Your City, India',
    'posted' => '12 October 2026',
    'valid_until' => '',
    'description' => 'Discover home and professional services offered by a local business. Contact the advertiser to discuss your requirements and confirm service availability.',
    'service_details' => 'Service availability, coverage area and inclusions should be confirmed directly with the advertiser.',
    'offer' => 'Contact the advertiser for current offers and availability.',
    'price' => 'Contact for pricing',
    'contact' => 'Contact details available on request',
    'whatsapp' => '',
    'website' => ''
];

$isAd = $listingType === 'advertisement' || $listingType === 'ad';
$item = $isAd ? $sampleAd : $sampleEvent;
$isEvent = !$isAd;

function plDetailEscape($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>

<main class="pl-detail-page">
  <section class="pl-detail-hero">
    <div class="pl-detail-hero__content">
      <a href="events-ads-listings.php" class="pl-detail-back"><i class="fa-solid fa-arrow-left"></i> Back to listings</a>
      <span class="pl-detail-eyebrow"><i class="fa-solid <?php echo $isEvent ? 'fa-calendar-days' : 'fa-bullhorn'; ?>"></i> PEOPLELINK <?php echo $isEvent ? 'COMMUNITY EVENT' : 'COMMUNITY ADVERTISEMENT'; ?></span>
      <h1><?php echo plDetailEscape($item['title']); ?></h1>
      <p><?php echo plDetailEscape($isEvent ? $item['description'] : $item['description']); ?></p>
      <div class="pl-detail-hero__tags">
        <span><i class="fa-solid fa-shapes"></i> <?php echo plDetailEscape($item['category']); ?></span>
        <span><i class="fa-solid fa-location-dot"></i> <?php echo plDetailEscape($isEvent ? $item['venue'] : $item['location']); ?></span>
        <?php if ($isEvent): ?><span class="pl-detail-status"><i class="fa-solid fa-circle-check"></i> <?php echo plDetailEscape($item['price']); ?></span><?php endif; ?>
      </div>
    </div>
    <div class="pl-detail-hero__art" aria-hidden="true">
      <div class="pl-detail-orbit pl-detail-orbit--one"></div>
      <div class="pl-detail-orbit pl-detail-orbit--two"></div>
      <div class="pl-detail-hero-icon"><i class="fa-solid <?php echo $isEvent ? 'fa-calendar-check' : 'fa-store'; ?>"></i></div>
      <span class="pl-detail-float pl-detail-float--one"><i class="fa-solid fa-star"></i></span>
      <span class="pl-detail-float pl-detail-float--two"><i class="fa-solid fa-people-group"></i></span>
    </div>
  </section>

  <section class="pl-detail-layout">
    <div class="pl-detail-main">
      <article class="pl-detail-media-card">
        <div class="pl-detail-main-image">
          <img src="<?php echo plDetailEscape($item['image']); ?>" alt="<?php echo plDetailEscape($item['title']); ?>">
          <span class="pl-detail-image-label"><i class="fa-solid <?php echo $isEvent ? 'fa-calendar-days' : 'fa-bullhorn'; ?>"></i> <?php echo $isEvent ? 'Event details' : 'Advertisement details'; ?></span>
        </div>
        <div class="pl-detail-main-content">
          <?php if ($isEvent): ?>
            <div class="pl-detail-date-tile"><strong><?php echo date('d', strtotime('24 October 2026')); ?></strong><span>OCT</span><small>2026</small></div>
          <?php else: ?>
            <div class="pl-detail-business-avatar"><i class="fa-solid fa-store"></i></div>
          <?php endif; ?>
          <div class="pl-detail-main-title">
            <span class="pl-detail-kicker"><?php echo $isEvent ? 'SAVE THE DATE' : 'COMMUNITY BUSINESS LISTING'; ?></span>
            <h2><?php echo plDetailEscape($item['title']); ?></h2>
            <p><?php echo $isEvent ? '<i class="fa-solid fa-location-dot"></i> ' . plDetailEscape($item['venue']) : '<i class="fa-solid fa-building"></i> ' . plDetailEscape($item['business']); ?></p>
          </div>
          <button type="button" class="pl-detail-icon-button" id="plShareButton" aria-label="Share listing"><i class="fa-solid fa-share-nodes"></i></button>
        </div>
      </article>

      <?php if ($isEvent): ?>
        <section class="pl-detail-panel">
          <div class="pl-detail-panel-heading"><span class="pl-detail-panel-icon pl-icon-blue"><i class="fa-regular fa-file-lines"></i></span><div><span class="pl-detail-kicker">EVENT OVERVIEW</span><h2>About the Event</h2></div></div>
          <p class="pl-detail-body-copy"><?php echo plDetailEscape($item['description']); ?></p>
          <h3 class="pl-detail-subheading">Program Details</h3>
          <p class="pl-detail-body-copy"><?php echo plDetailEscape($item['program']); ?></p>
          <h3 class="pl-detail-subheading">Who Can Attend</h3>
          <p class="pl-detail-body-copy"><?php echo plDetailEscape($item['attendees']); ?></p>
          <h3 class="pl-detail-subheading">Registration Information</h3>
          <p class="pl-detail-body-copy"><?php echo plDetailEscape($item['registration']); ?></p>
        </section>

        <section class="pl-detail-panel">
          <div class="pl-detail-panel-heading"><span class="pl-detail-panel-icon pl-icon-green"><i class="fa-solid fa-list-check"></i></span><div><span class="pl-detail-kicker">PLAN YOUR VISIT</span><h2>Program Schedule</h2></div></div>
          <div class="pl-detail-timeline">
            <?php foreach ($item['schedule'] as $scheduleItem): ?>
              <div class="pl-detail-timeline-item"><span class="pl-detail-timeline-dot"></span><time><?php echo plDetailEscape($scheduleItem['time']); ?></time><strong><?php echo plDetailEscape($scheduleItem['title']); ?></strong></div>
            <?php endforeach; ?>
          </div>
        </section>

        <section class="pl-detail-panel">
          <div class="pl-detail-panel-heading"><span class="pl-detail-panel-icon pl-icon-orange"><i class="fa-solid fa-map-location-dot"></i></span><div><span class="pl-detail-kicker">GETTING THERE</span><h2>Venue Information</h2></div></div>
          <div class="pl-detail-location-box"><span class="pl-detail-location-icon"><i class="fa-solid fa-location-dot"></i></span><div><h3><?php echo plDetailEscape($item['venue']); ?></h3><p><?php echo plDetailEscape($item['venue_info']); ?></p></div></div>
        </section>
      <?php else: ?>
        <section class="pl-detail-panel">
          <div class="pl-detail-panel-heading"><span class="pl-detail-panel-icon pl-icon-blue"><i class="fa-regular fa-file-lines"></i></span><div><span class="pl-detail-kicker">ADVERTISEMENT OVERVIEW</span><h2>About This Listing</h2></div></div>
          <p class="pl-detail-body-copy"><?php echo plDetailEscape($item['description']); ?></p>
          <h3 class="pl-detail-subheading">Product / Service Details</h3>
          <p class="pl-detail-body-copy"><?php echo plDetailEscape($item['service_details']); ?></p>
          <h3 class="pl-detail-subheading">Offer Information</h3>
          <p class="pl-detail-body-copy"><?php echo plDetailEscape($item['offer']); ?></p>
        </section>
        <section class="pl-detail-panel">
          <div class="pl-detail-panel-heading"><span class="pl-detail-panel-icon pl-icon-green"><i class="fa-solid fa-tags"></i></span><div><span class="pl-detail-kicker">PRICE &amp; VALIDITY</span><h2>Offer Details</h2></div></div>
          <div class="pl-detail-offer-grid"><div><span>Price</span><strong><?php echo plDetailEscape($item['price']); ?></strong></div><div><span>Posted on</span><strong><?php echo plDetailEscape($item['posted']); ?></strong></div><div><span>Offer valid until</span><strong><?php echo $item['valid_until'] ? plDetailEscape($item['valid_until']) : 'Please confirm with advertiser'; ?></strong></div></div>
        </section>
      <?php endif; ?>

      <?php if ($isEvent && !empty($item['live_url'])): ?>
        <section class="pl-detail-live-card"><span class="pl-detail-live-icon"><i class="fa-solid fa-play"></i></span><div><h2>Join the live program</h2><p>The organiser has provided an external live program link.</p></div><a href="<?php echo plDetailEscape($item['live_url']); ?>" target="_blank" rel="noopener noreferrer" class="pl-detail-primary-button">Watch Live / Join Live <i class="fa-solid fa-arrow-up-right-from-square"></i></a></section>
      <?php endif; ?>
    </div>

    <aside class="pl-detail-sidebar">
      <section class="pl-detail-side-card">
        <span class="pl-detail-kicker"><?php echo $isEvent ? 'EVENT INFORMATION' : 'ADVERTISEMENT INFORMATION'; ?></span>
        <h2><?php echo $isEvent ? 'At a glance' : 'Listing at a glance'; ?></h2>
        <?php if ($isEvent): ?>
          <div class="pl-detail-info-row"><span class="pl-detail-info-icon pl-icon-blue"><i class="fa-regular fa-calendar"></i></span><div><small>Date</small><strong><?php echo plDetailEscape($item['date']); ?></strong></div></div>
          <div class="pl-detail-info-row"><span class="pl-detail-info-icon pl-icon-green"><i class="fa-regular fa-clock"></i></span><div><small>Time</small><strong><?php echo plDetailEscape($item['time']); ?></strong></div></div>
          <div class="pl-detail-info-row"><span class="pl-detail-info-icon pl-icon-orange"><i class="fa-solid fa-ticket"></i></span><div><small>Entry</small><strong><?php echo plDetailEscape($item['price']); ?></strong></div></div>
          <div class="pl-detail-info-row"><span class="pl-detail-info-icon pl-icon-purple"><i class="fa-solid fa-people-group"></i></span><div><small>Community</small><strong><?php echo plDetailEscape($item['community']); ?></strong></div></div>
          <div class="pl-detail-info-row"><span class="pl-detail-info-icon pl-icon-pink"><i class="fa-solid fa-user-tie"></i></span><div><small>Organiser</small><strong><?php echo plDetailEscape($item['organiser']); ?></strong></div></div>
        <?php else: ?>
          <div class="pl-detail-info-row"><span class="pl-detail-info-icon pl-icon-blue"><i class="fa-solid fa-store"></i></span><div><small>Advertiser</small><strong><?php echo plDetailEscape($item['business']); ?></strong></div></div>
          <div class="pl-detail-info-row"><span class="pl-detail-info-icon pl-icon-green"><i class="fa-solid fa-shapes"></i></span><div><small>Category</small><strong><?php echo plDetailEscape($item['category']); ?></strong></div></div>
          <div class="pl-detail-info-row"><span class="pl-detail-info-icon pl-icon-orange"><i class="fa-solid fa-location-dot"></i></span><div><small>Location</small><strong><?php echo plDetailEscape($item['location']); ?></strong></div></div>
          <div class="pl-detail-info-row"><span class="pl-detail-info-icon pl-icon-purple"><i class="fa-regular fa-calendar"></i></span><div><small>Posted</small><strong><?php echo plDetailEscape($item['posted']); ?></strong></div></div>
          <?php if (!empty($item['valid_until'])): ?><div class="pl-detail-info-row"><span class="pl-detail-info-icon pl-icon-pink"><i class="fa-solid fa-hourglass-end"></i></span><div><small>Offer ends</small><strong><?php echo plDetailEscape($item['valid_until']); ?></strong></div></div><?php endif; ?>
        <?php endif; ?>
        <div class="pl-detail-side-actions">
          <?php if ($isEvent): ?>
            <a href="#register" class="pl-detail-primary-button"><i class="fa-solid fa-ticket"></i> Register</a>
            <a href="#contact" class="pl-detail-secondary-button"><i class="fa-regular fa-message"></i> Enquire</a>
            <?php if (empty($item['registration'])): ?><a href="#contact" class="pl-detail-secondary-button"><i class="fa-solid fa-phone"></i> Contact Organiser</a><?php endif; ?>
          <?php else: ?>
            <a href="#contact" class="pl-detail-primary-button"><i class="fa-regular fa-message"></i> Contact / Enquire</a>
            <?php if (!empty($item['whatsapp'])): ?><a href="<?php echo plDetailEscape($item['whatsapp']); ?>" target="_blank" rel="noopener noreferrer" class="pl-detail-whatsapp-button"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a><?php endif; ?>
            <?php if (!empty($item['website'])): ?><a href="<?php echo plDetailEscape($item['website']); ?>" target="_blank" rel="noopener noreferrer" class="pl-detail-secondary-button"><i class="fa-solid fa-arrow-up-right-from-square"></i> Visit Website</a><?php endif; ?>
          <?php endif; ?>
          <button type="button" class="pl-detail-secondary-button" id="plShareButtonSide"><i class="fa-solid fa-share-nodes"></i> Share Listing</button>
        </div>
      </section>

      <section class="pl-detail-side-card pl-detail-contact-card" id="contact">
        <span class="pl-detail-kicker">NEED MORE INFORMATION?</span>
        <h2><?php echo $isEvent ? 'Contact the organiser' : 'Contact the advertiser'; ?></h2>
        <p><?php echo plDetailEscape($item['contact']); ?></p>
        <a href="contact-seller.php?id=<?php echo (int)$item['id']; ?>&type=<?php echo $isEvent ? 'event' : 'advertisement'; ?>" class="pl-detail-primary-button"><i class="fa-regular fa-paper-plane"></i> Send an Enquiry</a>
        <small>Contact information should only be displayed according to the member's privacy settings.</small>
      </section>
    </aside>
  </section>

  <section class="pl-detail-related">
    <div class="pl-detail-related-heading"><div><span class="pl-detail-kicker">KEEP EXPLORING</span><h2>Similar <?php echo $isEvent ? 'Events' : 'Advertisements'; ?></h2><p>Discover more listings from related categories and locations.</p></div><a href="events-ads-listings.php?type=<?php echo $isEvent ? 'event' : 'advertisement'; ?>" class="pl-detail-view-more">View More <i class="fa-solid fa-arrow-right"></i></a></div>
    <div class="pl-detail-related-grid">
      <article class="pl-detail-related-card"><a href="event-ad-details.php?id=<?php echo $isEvent ? '102&type=event' : '105&type=advertisement'; ?>" class="pl-detail-related-image"><img src="<?php echo $isEvent ? 'images/events/business-workshop.jpg' : 'images/advertisements/local-business.jpg'; ?>" alt="Related <?php echo $isEvent ? 'event' : 'advertisement'; ?>" loading="lazy"><span><?php echo $isEvent ? 'Workshop' : 'Business'; ?></span></a><div><h3><?php echo $isEvent ? 'Business Growth Workshop' : 'Local Business Spotlight'; ?></h3><p><i class="fa-solid fa-location-dot"></i> Your City</p><a href="event-ad-details.php?id=<?php echo $isEvent ? '102&type=event' : '105&type=advertisement'; ?>">View Details <i class="fa-solid fa-arrow-right"></i></a></div></article>
      <article class="pl-detail-related-card"><a href="event-ad-details.php?id=<?php echo $isEvent ? '103&type=event' : '106&type=advertisement'; ?>" class="pl-detail-related-image"><img src="<?php echo $isEvent ? 'images/events/cultural-gathering.jpg' : 'images/advertisements/education-training.jpg'; ?>" alt="Another related listing" loading="lazy"><span><?php echo $isEvent ? 'Cultural' : 'Education'; ?></span></a><div><h3><?php echo $isEvent ? 'Culture & Community Celebration' : 'Education & Training Opportunities'; ?></h3><p><i class="fa-solid fa-location-dot"></i> Your City</p><a href="event-ad-details.php?id=<?php echo $isEvent ? '103&type=event' : '106&type=advertisement'; ?>">View Details <i class="fa-solid fa-arrow-right"></i></a></div></article>
      <article class="pl-detail-related-card"><a href="events-ads-listings.php?type=<?php echo $isEvent ? 'event' : 'advertisement'; ?>" class="pl-detail-related-image pl-detail-related-placeholder"><i class="fa-solid <?php echo $isEvent ? 'fa-calendar-days' : 'fa-bullhorn'; ?>"></i><span>Explore more</span></a><div><h3>Explore more community listings</h3><p><i class="fa-solid fa-people-group"></i> PeopleLink Community</p><a href="events-ads-listings.php?type=<?php echo $isEvent ? 'event' : 'advertisement'; ?>">Browse Listings <i class="fa-solid fa-arrow-right"></i></a></div></article>
    </div>
  </section>

  <div class="pl-detail-toast" id="plDetailToast" role="status" aria-live="polite"></div>
</main>

 
<?php include 'footer.php'; ?>