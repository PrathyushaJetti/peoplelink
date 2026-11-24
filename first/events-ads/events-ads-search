<?php include 'header.php'; ?>

<main class="pl-search-page">
  <section class="pl-search-hero">
    <div class="pl-search-hero__content">
      <span class="pl-search-eyebrow"><i class="fa-solid fa-compass"></i> PEOPLELINK COMMUNITY BOARD</span>
      <h1>Search Events &amp; Advertisements</h1>
      <p>Find community events, local promotions, workshops and announcements that match your interests.</p>
      <div class="pl-search-hero__highlights">
        <span><i class="fa-solid fa-calendar-check"></i> Discover events</span>
        <span><i class="fa-solid fa-bullhorn"></i> Explore advertisements</span>
        <span><i class="fa-solid fa-location-dot"></i> Search locally</span>
      </div>
    </div>
    <div class="pl-search-hero__visual" aria-hidden="true">
      <div class="pl-search-visual-circle pl-search-visual-circle--one"></div>
      <div class="pl-search-visual-circle pl-search-visual-circle--two"></div>
      <div class="pl-search-visual-icon"><i class="fa-solid fa-sliders"></i></div>
      <div class="pl-search-floating pl-search-floating--calendar"><i class="fa-solid fa-calendar-days"></i></div>
      <div class="pl-search-floating pl-search-floating--pin"><i class="fa-solid fa-location-dot"></i></div>
      <div class="pl-search-floating pl-search-floating--bullhorn"><i class="fa-solid fa-bullhorn"></i></div>
    </div>
  </section>

  <section class="pl-search-shell">
    <div class="pl-search-intro">
      <div><span class="pl-search-kicker">REFINE YOUR DISCOVERY</span><h2>Find the right listing</h2><p>Choose a listing type, enter your search details and apply filters.</p></div>
      <a class="pl-search-back-link" href="events-ads-home.php"><i class="fa-solid fa-arrow-left"></i> Back to Events &amp; Ads</a>
    </div>

    <form id="plEventsAdsFilterForm" class="pl-filter-form" action="events-ads-listings.php" method="get">
      <div class="pl-filter-type" role="group" aria-label="Listing type">
        <span class="pl-filter-type__label">I want to explore</span>
        <div class="pl-filter-type__options">
          <label class="pl-type-option"><input type="radio" name="type" value="all" checked><span><i class="fa-solid fa-layer-group"></i> All listings</span></label>
          <label class="pl-type-option"><input type="radio" name="type" value="event"><span><i class="fa-solid fa-calendar-days"></i> Events</span></label>
          <label class="pl-type-option"><input type="radio" name="type" value="advertisement"><span><i class="fa-solid fa-bullhorn"></i> Advertisements</span></label>
        </div>
      </div>

      <div class="pl-filter-section">
        <div class="pl-filter-section__heading"><span class="pl-filter-section__number">01</span><div><h3>Search details</h3><p>Start with a name, keyword or community.</p></div></div>
        <div class="pl-filter-grid pl-filter-grid--three">
          <label class="pl-filter-field pl-filter-field--wide"><span>Event / Advertisement Name</span><span class="pl-filter-input"><i class="fa-solid fa-magnifying-glass"></i><input type="search" name="name" placeholder="Search by listing name"></span></label>
          <label class="pl-filter-field"><span>Keyword</span><span class="pl-filter-input"><i class="fa-solid fa-key"></i><input type="text" name="keyword" placeholder="Enter keywords"></span></label>
          <label class="pl-filter-field"><span>Category</span><span class="pl-filter-input"><i class="fa-solid fa-shapes"></i><select name="category"><option value="">All categories</option><option value="community">Community</option><option value="business">Business</option><option value="education">Education</option><option value="cultural">Cultural</option><option value="health">Health &amp; Wellness</option><option value="services">Services</option><option value="offers">Offers &amp; Deals</option><option value="announcements">Announcements</option><option value="workshop">Workshops</option></select></span></label>
          <label class="pl-filter-field"><span>Community</span><span class="pl-filter-input"><i class="fa-solid fa-people-group"></i><select name="community"><option value="">All communities</option><option value="arya-vysya">Arya Vysya</option><option value="reddy">Reddy</option><option value="kamma">Kamma</option><option value="kapu">Kapu</option><option value="banjara">Banjara</option><option value="yadava">Yadava</option><option value="padmashali">Padmashali</option><option value="goud">Goud</option><option value="chakali">Chakali</option><option value="mudiraj">Mudiraj</option><option value="viswakarma">Viswakarma</option><option value="other">Other Communities</option></select></span></label>
          <label class="pl-filter-field"><span>City</span><span class="pl-filter-input"><i class="fa-solid fa-city"></i><input type="text" name="city" placeholder="Enter city"></span></label>
          <label class="pl-filter-field"><span>Area / Locality</span><span class="pl-filter-input"><i class="fa-solid fa-location-dot"></i><input type="text" name="area" placeholder="Neighbourhood or area"></span></label>
        </div>
        <button type="button" id="plUseLocation" class="pl-location-button"><i class="fa-solid fa-location-crosshairs"></i> Use My Location <small>Optional</small></button>
        <p class="pl-location-message" id="plLocationMessage" aria-live="polite"></p>
        <input type="hidden" name="latitude" id="plLatitude">
        <input type="hidden" name="longitude" id="plLongitude">
      </div>

      <div class="pl-filter-section pl-event-filters">
        <div class="pl-filter-section__heading"><span class="pl-filter-section__number pl-number--green">02</span><div><h3>Event filters</h3><p>Choose event dates, time, cost and status.</p></div></div>
        <div class="pl-filter-grid pl-filter-grid--three">
          <label class="pl-filter-field"><span>Event Category</span><span class="pl-filter-input"><i class="fa-solid fa-list"></i><select name="event_category"><option value="">All event categories</option><option value="community">Community</option><option value="workshop">Workshop</option><option value="cultural">Cultural</option><option value="education">Education</option><option value="health">Health &amp; Wellness</option><option value="business">Business</option></select></span></label>
          <label class="pl-filter-field"><span>Date</span><span class="pl-filter-input"><i class="fa-regular fa-calendar"></i><input type="date" name="event_date"></span></label>
          <label class="pl-filter-field"><span>Time</span><span class="pl-filter-input"><i class="fa-regular fa-clock"></i><select name="event_time"><option value="">Any time</option><option value="morning">Morning</option><option value="afternoon">Afternoon</option><option value="evening">Evening</option><option value="night">Night</option></select></span></label>
          <label class="pl-filter-field"><span>Event Location</span><span class="pl-filter-input"><i class="fa-solid fa-map-pin"></i><input type="text" name="event_location" placeholder="Venue or location"></span></label>
          <label class="pl-filter-field"><span>Entry Fee</span><span class="pl-filter-input"><i class="fa-solid fa-ticket"></i><select name="event_price"><option value="">Free or paid</option><option value="free">Free events</option><option value="paid">Paid events</option></select></span></label>
          <label class="pl-filter-field"><span>Event Status</span><span class="pl-filter-input"><i class="fa-solid fa-circle-check"></i><select name="event_status"><option value="">All statuses</option><option value="upcoming">Upcoming</option><option value="ongoing">Ongoing</option><option value="completed">Completed</option></select></span></label>
        </div>
      </div>

      <div class="pl-filter-section pl-ad-filters">
        <div class="pl-filter-section__heading"><span class="pl-filter-section__number pl-number--orange">03</span><div><h3>Advertisement filters</h3><p>Find recent promotions and featured business listings.</p></div></div>
        <div class="pl-filter-grid pl-filter-grid--three">
          <label class="pl-filter-field"><span>Advertisement Category</span><span class="pl-filter-input"><i class="fa-solid fa-rectangle-ad"></i><select name="ad_category"><option value="">All ad categories</option><option value="business">Business</option><option value="services">Services</option><option value="education">Education</option><option value="real-estate">Real Estate</option><option value="products">Products</option><option value="offers">Offers &amp; Deals</option><option value="jobs">Jobs &amp; Opportunities</option><option value="other">Other</option></select></span></label>
          <label class="pl-filter-field"><span>Advertisement Location</span><span class="pl-filter-input"><i class="fa-solid fa-location-dot"></i><input type="text" name="ad_location" placeholder="City, area or locality"></span></label>
          <div class="pl-filter-field"><span>Ad highlights</span><div class="pl-check-options"><label><input type="checkbox" name="latest_ads" value="1"><span><i class="fa-solid fa-clock"></i> Latest Ads</span></label><label><input type="checkbox" name="featured_ads" value="1"><span><i class="fa-solid fa-star"></i> Featured Ads</span></label></div></div>
        </div>
      </div>

      <div class="pl-filter-section pl-filter-section--last">
        <div class="pl-filter-section__heading"><span class="pl-filter-section__number pl-number--purple">04</span><div><h3>Sort results</h3><p>Choose how matching listings should be ordered.</p></div></div>
        <div class="pl-sort-options">
          <label><input type="radio" name="sort" value="relevant" checked><span><i class="fa-solid fa-bullseye"></i><strong>Most Relevant</strong></span></label>
          <label><input type="radio" name="sort" value="latest"><span><i class="fa-solid fa-clock"></i><strong>Latest</strong></span></label>
          <label><input type="radio" name="sort" value="upcoming"><span><i class="fa-solid fa-calendar-arrow-up"></i><strong>Upcoming First</strong></span></label>
          <label><input type="radio" name="sort" value="recently-added"><span><i class="fa-solid fa-sparkles"></i><strong>Recently Added</strong></span></label>
        </div>
      </div>

      <div class="pl-filter-actions">
        <p><i class="fa-solid fa-circle-info"></i> You can change or reset your filters at any time.</p>
        <div><button class="pl-filter-reset" type="reset"><i class="fa-solid fa-rotate-left"></i> Reset Filters</button><button class="pl-filter-submit" type="submit">Apply Filters <i class="fa-solid fa-arrow-right"></i></button></div>
      </div>
    </form>
  </section>

  <section class="pl-quick-filter-section">
    <div class="pl-quick-filter-heading"><div><span class="pl-search-kicker">ONE-CLICK DISCOVERY</span><h2>Quick filters</h2><p>Jump straight to popular searches.</p></div></div>
    <div class="pl-quick-filter-list">
      <a href="events-ads-listings.php?type=event&event_status=upcoming"><span class="pl-quick-filter-icon pl-qf-blue"><i class="fa-solid fa-calendar-check"></i></span><span><strong>Upcoming Events</strong><small>What's coming next</small></span><i class="fa-solid fa-arrow-up-right-from-square pl-qf-arrow"></i></a>
      <a href="events-ads-listings.php?type=event&date_range=this-week"><span class="pl-quick-filter-icon pl-qf-green"><i class="fa-solid fa-calendar-week"></i></span><span><strong>This Week</strong><small>Plans for the week</small></span><i class="fa-solid fa-arrow-up-right-from-square pl-qf-arrow"></i></a>
      <a href="events-ads-listings.php?type=event&date_range=this-month"><span class="pl-quick-filter-icon pl-qf-purple"><i class="fa-solid fa-calendar"></i></span><span><strong>This Month</strong><small>Explore the month</small></span><i class="fa-solid fa-arrow-up-right-from-square pl-qf-arrow"></i></a>
      <a href="events-ads-listings.php?type=advertisement&featured_ads=1"><span class="pl-quick-filter-icon pl-qf-orange"><i class="fa-solid fa-star"></i></span><span><strong>Featured Ads</strong><small>Highlighted promotions</small></span><i class="fa-solid fa-arrow-up-right-from-square pl-qf-arrow"></i></a>
      <a href="events-ads-listings.php?type=advertisement&latest_ads=1"><span class="pl-quick-filter-icon pl-qf-pink"><i class="fa-solid fa-bolt"></i></span><span><strong>Latest Ads</strong><small>Recently published</small></span><i class="fa-solid fa-arrow-up-right-from-square pl-qf-arrow"></i></a>
    </div>
  </section>

  <section class="pl-search-footer-cta">
    <div class="pl-search-footer-cta__icon"><i class="fa-solid fa-bullhorn"></i></div>
    <div><h2>Have something to share?</h2><p>Publish an event or advertisement and let your community know.</p></div>
    <a href="post-event-ad.php" class="pl-search-cta-button">Post Event / Advertisement <i class="fa-solid fa-arrow-right"></i></a>
  </section>
</main>

 
<?php include 'footer.php'; ?>