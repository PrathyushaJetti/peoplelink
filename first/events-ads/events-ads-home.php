<?php include 'header.php'; ?>

<main class="pl-events-page">
  <section class="pl-events-hero">
    <div class="pl-events-hero__content">
      <span class="pl-events-eyebrow"><i class="fa-solid fa-calendar-days"></i> PEOPLELINK COMMUNITY</span>
      <h1>Events &amp; Advertisements</h1>
      <p>Discover community gatherings, local activities, business promotions and opportunities around you.</p>
      <div class="pl-events-hero__actions">
        <a class="pl-btn pl-btn--light" href="events-ads-search.php"><i class="fa-solid fa-magnifying-glass"></i> Explore Listings</a>
        <a class="pl-btn pl-btn--outline" href="post-event-ad.php"><i class="fa-solid fa-plus"></i> Post an Event or Ad</a>
      </div>
      <div class="pl-events-hero__stats">
        <div><strong>Events</strong><span>Community meetups</span></div>
        <div><strong>Local Ads</strong><span>Promote your business</span></div>
        <div><strong>One Network</strong><span>More ways to connect</span></div>
      </div>
    </div>
    <div class="pl-events-hero__art" aria-hidden="true">
      <div class="pl-art-orbit pl-art-orbit--one"></div>
      <div class="pl-art-orbit pl-art-orbit--two"></div>
      <div class="pl-art-card pl-art-card--main"><i class="fa-solid fa-calendar-check"></i><span>Meet. Connect. Grow.</span></div>
      <div class="pl-art-card pl-art-card--small pl-art-card--top"><i class="fa-solid fa-bullhorn"></i></div>
      <div class="pl-art-card pl-art-card--small pl-art-card--bottom"><i class="fa-solid fa-people-group"></i></div>
    </div>
  </section>

  <section class="pl-events-search-panel" aria-label="Search events and advertisements">
    <div class="pl-section-heading pl-section-heading--compact">
      <div><span class="pl-section-kicker">FIND YOUR NEXT OPPORTUNITY</span><h2>What are you looking for?</h2></div>
    </div>
    <form class="pl-events-search" action="events-ads-search.php" method="get">
      <label class="pl-search-field"><span>Keyword</span><span class="pl-search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="search" name="q" placeholder="Event, workshop, business..." /></span></label>
      <label class="pl-search-field"><span>Listing type</span><span class="pl-search-input"><i class="fa-solid fa-layer-group"></i><select name="type"><option value="">All listings</option><option value="event">Events</option><option value="advertisement">Advertisements</option></select></span></label>
      <label class="pl-search-field"><span>Location</span><span class="pl-search-input"><i class="fa-solid fa-location-dot"></i><input type="text" name="location" placeholder="City or area" /></span></label>
      <button class="pl-btn pl-btn--primary" type="submit">Search <i class="fa-solid fa-arrow-right"></i></button>
    </form>
  </section>

  <section class="pl-events-section">
    <div class="pl-section-heading">
      <div><span class="pl-section-kicker">EXPLORE BY TYPE</span><h2>Browse the community board</h2><p>Choose a listing type to find what matters to you.</p></div>
      <a class="pl-text-link" href="events-ads-search.php">View all listings <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="pl-events-type-grid">
      <a class="pl-type-card pl-type-card--blue" href="events-ads-search.php?type=event"><span class="pl-type-card__icon"><i class="fa-solid fa-calendar-day"></i></span><span><strong>Community Events</strong><small>Gatherings, celebrations and meetups</small></span><i class="fa-solid fa-arrow-up-right-from-square pl-type-card__arrow"></i></a>
      <a class="pl-type-card pl-type-card--green" href="events-ads-search.php?type=workshop"><span class="pl-type-card__icon"><i class="fa-solid fa-chalkboard-user"></i></span><span><strong>Workshops &amp; Learning</strong><small>Build skills and share knowledge</small></span><i class="fa-solid fa-arrow-up-right-from-square pl-type-card__arrow"></i></a>
      <a class="pl-type-card pl-type-card--orange" href="events-ads-search.php?type=business"><span class="pl-type-card__icon"><i class="fa-solid fa-store"></i></span><span><strong>Business Promotions</strong><small>Discover local products and services</small></span><i class="fa-solid fa-arrow-up-right-from-square pl-type-card__arrow"></i></a>
      <a class="pl-type-card pl-type-card--purple" href="events-ads-search.php?type=announcement"><span class="pl-type-card__icon"><i class="fa-solid fa-bullhorn"></i></span><span><strong>Announcements</strong><small>Share useful community updates</small></span><i class="fa-solid fa-arrow-up-right-from-square pl-type-card__arrow"></i></a>
    </div>
  </section>

  <section class="pl-events-section pl-events-section--soft">
    <div class="pl-section-heading">
      <div><span class="pl-section-kicker">SAVE THE DATE</span><h2>Upcoming events</h2><p>Meet people, learn something new and take part in your community.</p></div>
      <a class="pl-text-link" href="events-ads-search.php?type=event">All events <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="pl-listing-grid">
      <article class="pl-listing-card">
        <a class="pl-listing-image" href="event-details.php?id=1"><img src="images/events/community-meetup.jpg" alt="People connecting at a community meetup" loading="lazy"><span class="pl-listing-label">Community</span></a>
        <div class="pl-listing-body"><div class="pl-event-date"><strong>24</strong><span>OCT</span></div><div class="pl-listing-main"><h3><a href="event-details.php?id=1">Community Networking Meetup</a></h3><p><i class="fa-solid fa-location-dot"></i> Add event location</p><p class="pl-listing-description">Connect with community members, exchange ideas and build meaningful relationships.</p><a class="pl-card-link" href="event-details.php?id=1">View event <i class="fa-solid fa-arrow-right"></i></a></div></div>
      </article>
      <article class="pl-listing-card">
        <a class="pl-listing-image" href="event-details.php?id=2"><img src="images/events/business-workshop.jpg" alt="Business workshop and learning session" loading="lazy"><span class="pl-listing-label pl-listing-label--green">Workshop</span></a>
        <div class="pl-listing-body"><div class="pl-event-date"><strong>02</strong><span>NOV</span></div><div class="pl-listing-main"><h3><a href="event-details.php?id=2">Business Growth Workshop</a></h3><p><i class="fa-solid fa-location-dot"></i> Add event location</p><p class="pl-listing-description">Share practical ideas, learn from professionals and explore new opportunities.</p><a class="pl-card-link" href="event-details.php?id=2">View event <i class="fa-solid fa-arrow-right"></i></a></div></div>
      </article>
      <article class="pl-listing-card">
        <a class="pl-listing-image" href="event-details.php?id=3"><img src="images/events/cultural-gathering.jpg" alt="Community cultural gathering" loading="lazy"><span class="pl-listing-label pl-listing-label--orange">Cultural</span></a>
        <div class="pl-listing-body"><div class="pl-event-date"><strong>09</strong><span>NOV</span></div><div class="pl-listing-main"><h3><a href="event-details.php?id=3">Culture &amp; Community Celebration</a></h3><p><i class="fa-solid fa-location-dot"></i> Add event location</p><p class="pl-listing-description">Celebrate traditions, share experiences and bring families together.</p><a class="pl-card-link" href="event-details.php?id=3">View event <i class="fa-solid fa-arrow-right"></i></a></div></div>
      </article>
    </div>
  </section>

  <section class="pl-events-section">
    <div class="pl-section-heading">
      <div><span class="pl-section-kicker">FROM THE COMMUNITY</span><h2>Latest advertisements</h2><p>Explore services, offers and business announcements shared by members.</p></div>
      <a class="pl-text-link" href="events-ads-search.php?type=advertisement">All advertisements <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="pl-listing-grid pl-listing-grid--ads">
      <article class="pl-ad-card"><a class="pl-ad-card__image" href="event-details.php?id=4"><img src="images/advertisements/home-services.jpg" alt="Home and professional services" loading="lazy"><span>Services</span></a><div class="pl-ad-card__body"><div class="pl-ad-meta"><span><i class="fa-solid fa-location-dot"></i> Your area</span><span class="pl-featured-tag">Community listing</span></div><h3><a href="event-details.php?id=4">Home &amp; Professional Services</a></h3><p>Discover reliable services shared by businesses and professionals in the network.</p><a class="pl-card-link" href="event-details.php?id=4">View advertisement <i class="fa-solid fa-arrow-right"></i></a></div></article>
      <article class="pl-ad-card"><a class="pl-ad-card__image" href="event-details.php?id=5"><img src="images/advertisements/local-business.jpg" alt="Local business products and offers" loading="lazy"><span>Business</span></a><div class="pl-ad-card__body"><div class="pl-ad-meta"><span><i class="fa-solid fa-location-dot"></i> Your area</span><span class="pl-featured-tag">Community listing</span></div><h3><a href="event-details.php?id=5">Local Business Spotlight</a></h3><p>Explore products, services and offers from businesses in your community.</p><a class="pl-card-link" href="event-details.php?id=5">View advertisement <i class="fa-solid fa-arrow-right"></i></a></div></article>
      <article class="pl-ad-card"><a class="pl-ad-card__image" href="event-details.php?id=6"><img src="images/advertisements/education-training.jpg" alt="Education and training opportunities" loading="lazy"><span>Education</span></a><div class="pl-ad-card__body"><div class="pl-ad-meta"><span><i class="fa-solid fa-location-dot"></i> Your area</span><span class="pl-featured-tag">Community listing</span></div><h3><a href="event-details.php?id=6">Education &amp; Training Opportunities</a></h3><p>Find learning programmes, training announcements and educational services.</p><a class="pl-card-link" href="event-details.php?id=6">View advertisement <i class="fa-solid fa-arrow-right"></i></a></div></article>
    </div>
  </section>

  <section class="pl-events-promo">
    <div class="pl-events-promo__icon"><i class="fa-solid fa-bullhorn"></i></div>
    <div><span class="pl-section-kicker">HAVE SOMETHING TO SHARE?</span><h2>Put your event or business in the spotlight.</h2><p>Reach people in your community by publishing an event, announcement or advertisement.</p></div>
    <a class="pl-btn pl-btn--primary" href="post-event-ad.php">Create a listing <i class="fa-solid fa-arrow-right"></i></a>
  </section>

  <section class="pl-events-section pl-events-section--categories">
    <div class="pl-section-heading"><div><span class="pl-section-kicker">QUICK DISCOVERY</span><h2>Explore popular categories</h2></div></div>
    <div class="pl-category-chips">
      <a href="events-ads-search.php?category=community"><i class="fa-solid fa-people-group"></i> Community</a>
      <a href="events-ads-search.php?category=business"><i class="fa-solid fa-briefcase"></i> Business</a>
      <a href="events-ads-search.php?category=education"><i class="fa-solid fa-graduation-cap"></i> Education</a>
      <a href="events-ads-search.php?category=cultural"><i class="fa-solid fa-masks-theater"></i> Cultural</a>
      <a href="events-ads-search.php?category=health"><i class="fa-solid fa-heart-pulse"></i> Health &amp; Wellness</a>
      <a href="events-ads-search.php?category=offers"><i class="fa-solid fa-tags"></i> Offers &amp; Deals</a>
      <a href="events-ads-search.php?category=services"><i class="fa-solid fa-screwdriver-wrench"></i> Services</a>
      <a href="events-ads-search.php?category=announcements"><i class="fa-solid fa-bell"></i> Announcements</a>
    </div>
  </section>

  <section class="pl-events-bottom-cta">
    <div><h2>Your community. Your opportunities.</h2><p>Discover what's happening and stay connected with PeopleLink.</p></div>
    <div class="pl-events-bottom-cta__actions"><a class="pl-btn pl-btn--light" href="events-ads-search.php">Browse listings</a><a class="pl-btn pl-btn--outline" href="my-events-ads.php">Manage my listings</a></div>
  </section>
</main>

 
<?php include 'footer.php'; ?>