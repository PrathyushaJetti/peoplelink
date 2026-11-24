<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Manage your saved job opportunities on PeopleLink.">
  <title>PeopleLink | Saved Jobs</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="header.css">
  <link rel="stylesheet" href="saved-jobs.css">
  <link rel="stylesheet" href="footer.css">
</head>
<body>
  <!-- PEOPLELINK HEADER -->
  <header class="pl-header" id="peoplelinkHeader">
    <div class="pl-topbar">
      <div class="pl-container">
        <div class="pl-top-left">
          <span><i class="fa-solid fa-heart"></i> Connecting Communities</span>
          <span><i class="fa-solid fa-location-dot"></i> Communities Across India</span>
        </div>
        <div class="pl-top-right">
          <a href="#help">Help &amp; Support</a>
          <a href="#contact">Contact Us</a>
        </div>
      </div>
    </div>
    <div class="pl-navbar">
      <div class="pl-container">
        <a href="index.html" class="pl-logo" aria-label="PeopleLink Home">
          <img src="images/logo.jpeg" alt="PeopleLink" class="pl-logo-image">
        </a>
        <button type="button" class="pl-mobile-toggle" id="plMobileToggle" aria-label="Open navigation" aria-expanded="false">
          <span></span><span></span><span></span>
        </button>
        <nav class="pl-main-nav" id="plMainNav" aria-label="Main Navigation">
          <a href="index.html" class="pl-nav-link">Home</a>
          <div class="pl-nav-dropdown">
            <button type="button" class="pl-nav-dropdown-btn">Communities <i class="fa-solid fa-chevron-down"></i></button>
            <div class="pl-dropdown-menu">
              <div class="pl-dropdown-title"><strong>OUR COMMUNITIES</strong><span>Choose your community</span></div>
              <a href="#communityList"><i class="fa-solid fa-people-group"></i> Arya Vysya</a>
              <a href="#communityList"><i class="fa-solid fa-users"></i> Reddy</a>
              <a href="#communityList"><i class="fa-solid fa-people-roof"></i> Kamma</a>
              <a href="#communityList"><i class="fa-solid fa-user-group"></i> Kapu</a>
              <a href="#communityList"><i class="fa-solid fa-people-arrows"></i> Banjara</a>
              <a href="#communityList" class="pl-dropdown-all">View All Communities <i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
          <a href="service.html" class="pl-nav-link">Services</a>
          <a href="about.html" class="pl-nav-link">About Us</a>
          <a href="#events" class="pl-nav-link">Events</a>
          <a href="#contact" class="pl-nav-link">Contact</a>
          <div class="pl-mobile-actions">
            <a href="#communityList" class="pl-mobile-community"><i class="fa-solid fa-users"></i> Select Your Community</a>
            <a href="#downloadApp" class="pl-mobile-download"><i class="fa-solid fa-mobile-screen-button"></i> Download App</a>
          </div>
        </nav>
        <div class="pl-header-actions">
          <a href="#login" class="pl-login"><i class="fa-regular fa-user"></i> Login</a>
          <a href="#communityList" class="pl-community-button"><i class="fa-solid fa-users"></i> Select Community</a>
          <a href="#downloadApp" class="pl-download-button"><i class="fa-solid fa-mobile-screen-button"></i> Download App</a>
        </div>
      </div>
    </div>
  </header>

  <main class="sj-page">
    <section class="sj-hero">
      <div class="sj-container sj-hero-inner">
        <div class="sj-hero-copy">
          <span class="sj-eyebrow"><i class="fa-solid fa-bookmark"></i> PEOPLELINK CAREER NETWORK</span>
          <h1>Saved Jobs</h1>
          <p>Keep promising opportunities close. Revisit, compare and apply when you’re ready.</p>
          <div class="sj-hero-points">
            <span><i class="fa-solid fa-check-circle"></i> Your shortlist in one place</span>
            <span><i class="fa-solid fa-bell"></i> Keep an eye on closing dates</span>
          </div>
        </div>
        <div class="sj-hero-art" aria-hidden="true">
          <div class="sj-art-card"><i class="fa-solid fa-bookmark"></i><span class="sj-art-line long"></span><span class="sj-art-line"></span><span class="sj-art-line short"></span></div>
          <span class="sj-art-bubble bubble-one"><i class="fa-solid fa-briefcase"></i></span>
          <span class="sj-art-bubble bubble-two"><i class="fa-solid fa-star"></i></span>
        </div>
      </div>
    </section>

    <section class="sj-container sj-content">
      <div class="sj-heading-row">
        <div>
          <span class="sj-kicker">YOUR CAREER SHORTLIST</span>
          <h2>Jobs you’ve saved</h2>
          <p>Check availability and take the next step before an opportunity closes.</p>
        </div>
        <a href="job-search-results.html" class="sj-btn sj-btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Browse Jobs</a>
      </div>

      <div class="sj-summary-row">
        <div class="sj-summary-card"><span class="sj-summary-icon blue"><i class="fa-solid fa-bookmark"></i></span><div><small>Saved Jobs</small><strong id="savedCount">4</strong></div></div>
        <div class="sj-summary-card"><span class="sj-summary-icon green"><i class="fa-solid fa-circle-check"></i></span><div><small>Still Active</small><strong id="activeCount">3</strong></div></div>
        <div class="sj-summary-card"><span class="sj-summary-icon orange"><i class="fa-regular fa-clock"></i></span><div><small>Closing Soon</small><strong id="closingCount">1</strong></div></div>
      </div>

      <div class="sj-toolbar">
        <div class="sj-filter-tabs" role="group" aria-label="Filter saved jobs">
          <button class="sj-filter-tab active" type="button" data-filter="all">All Saved <span id="allTabCount">4</span></button>
          <button class="sj-filter-tab" type="button" data-filter="community">Community Jobs</button>
          <button class="sj-filter-tab" type="button" data-filter="global">Global Jobs</button>
        </div>
        <label class="sj-sort-wrap"><i class="fa-solid fa-arrow-down-wide-short"></i><span class="sr-only">Sort saved jobs</span>
          <select id="sortJobs">
            <option value="latest">Latest Saved</option>
            <option value="closing">Closing Soon</option>
          </select>
        </label>
      </div>

      <div class="sj-results-line"><strong id="resultsCount">4 saved jobs</strong><span>Availability may change as employers update listings.</span></div>

      <div class="sj-job-list" id="savedJobList">
        <article class="sj-job-card" data-id="101" data-type="global" data-saved="2026-10-09" data-closing="2026-10-15" data-status="active">
          <div class="sj-job-main">
            <div class="sj-company-mark global"><i class="fa-solid fa-earth-asia"></i></div>
            <div class="sj-job-info">
              <div class="sj-badge-row"><span class="sj-type-badge global">Global Job</span><span class="sj-status active"><i class="fa-solid fa-circle"></i> Active</span></div>
              <h3>PHP Web Developer</h3>
              <p class="sj-company">BrightPath Digital Solutions</p>
              <div class="sj-meta-grid">
                <span><i class="fa-solid fa-location-dot"></i> Dehradun, Uttarakhand</span>
                <span><i class="fa-solid fa-briefcase"></i> 1–3 Years</span>
                <span><i class="fa-regular fa-clock"></i> Full Time</span>
                <span><i class="fa-solid fa-laptop"></i> Hybrid</span>
              </div>
              <div class="sj-job-bottom"><span class="sj-salary"><i class="fa-solid fa-indian-rupee-sign"></i> ₹20,000 – ₹35,000 / month</span><span><i class="fa-regular fa-calendar"></i> Posted 08 Oct 2026</span><span><i class="fa-solid fa-hourglass-half"></i> Closes 15 Oct 2026</span></div>
            </div>
          </div>
          <div class="sj-card-actions"><button class="sj-btn sj-btn-outline" type="button" data-view><i class="fa-regular fa-eye"></i> View Details</button><a class="sj-btn sj-btn-primary" href="apply-to-job.html?job=101"><i class="fa-solid fa-paper-plane"></i> Apply Now</a><button class="sj-remove" type="button" data-remove aria-label="Remove PHP Web Developer from saved jobs"><i class="fa-solid fa-bookmark"></i> Remove from Saved</button></div>
        </article>

        <article class="sj-job-card" data-id="102" data-type="community" data-saved="2026-10-08" data-closing="2026-10-28" data-status="active">
          <div class="sj-job-main">
            <div class="sj-company-mark"><i class="fa-solid fa-building"></i></div>
            <div class="sj-job-info">
              <div class="sj-badge-row"><span class="sj-type-badge">Community Job</span><span class="sj-community-tag"><i class="fa-solid fa-users"></i> Arya Vysya</span><span class="sj-status active"><i class="fa-solid fa-circle"></i> Active</span></div>
              <h3>Digital Marketing Executive</h3>
              <p class="sj-company">NorthStar Business Hub</p>
              <div class="sj-meta-grid">
                <span><i class="fa-solid fa-location-dot"></i> Rishikesh, Uttarakhand</span>
                <span><i class="fa-solid fa-briefcase"></i> 1–2 Years</span>
                <span><i class="fa-regular fa-clock"></i> Full Time</span>
                <span><i class="fa-solid fa-laptop"></i> On-site</span>
              </div>
              <div class="sj-job-bottom"><span class="sj-salary"><i class="fa-solid fa-indian-rupee-sign"></i> ₹18,000 – ₹28,000 / month</span><span><i class="fa-regular fa-calendar"></i> Posted 06 Oct 2026</span><span><i class="fa-solid fa-hourglass-half"></i> Closes 28 Oct 2026</span></div>
            </div>
          </div>
          <div class="sj-card-actions"><button class="sj-btn sj-btn-outline" type="button" data-view><i class="fa-regular fa-eye"></i> View Details</button><a class="sj-btn sj-btn-primary" href="apply-to-job.html?job=102"><i class="fa-solid fa-paper-plane"></i> Apply Now</a><button class="sj-remove" type="button" data-remove aria-label="Remove Digital Marketing Executive from saved jobs"><i class="fa-solid fa-bookmark"></i> Remove from Saved</button></div>
        </article>

        <article class="sj-job-card" data-id="103" data-type="global" data-saved="2026-10-07" data-closing="2026-10-10" data-status="active">
          <div class="sj-job-main">
            <div class="sj-company-mark global"><i class="fa-solid fa-earth-asia"></i></div>
            <div class="sj-job-info">
              <div class="sj-badge-row"><span class="sj-type-badge global">Global Job</span><span class="sj-status active"><i class="fa-solid fa-circle"></i> Active</span><span class="sj-closing-soon"><i class="fa-solid fa-bolt"></i> Closing soon</span></div>
              <h3>UI/UX Designer</h3>
              <p class="sj-company">PixelCraft Studio</p>
              <div class="sj-meta-grid">
                <span><i class="fa-solid fa-location-dot"></i> Remote, India</span>
                <span><i class="fa-solid fa-briefcase"></i> 2–4 Years</span>
                <span><i class="fa-regular fa-clock"></i> Full Time</span>
                <span><i class="fa-solid fa-laptop"></i> Remote</span>
              </div>
              <div class="sj-job-bottom"><span class="sj-salary"><i class="fa-solid fa-indian-rupee-sign"></i> ₹35,000 – ₹55,000 / month</span><span><i class="fa-regular fa-calendar"></i> Posted 05 Oct 2026</span><span><i class="fa-solid fa-hourglass-half"></i> Closes 10 Oct 2026</span></div>
            </div>
          </div>
          <div class="sj-card-actions"><button class="sj-btn sj-btn-outline" type="button" data-view><i class="fa-regular fa-eye"></i> View Details</button><a class="sj-btn sj-btn-primary" href="apply-to-job.html?job=103"><i class="fa-solid fa-paper-plane"></i> Apply Now</a><button class="sj-remove" type="button" data-remove aria-label="Remove UI UX Designer from saved jobs"><i class="fa-solid fa-bookmark"></i> Remove from Saved</button></div>
        </article>

        <article class="sj-job-card" data-id="104" data-type="community" data-saved="2026-10-04" data-closing="2026-10-01" data-status="closed">
          <div class="sj-job-main">
            <div class="sj-company-mark closed-mark"><i class="fa-solid fa-building"></i></div>
            <div class="sj-job-info">
              <div class="sj-badge-row"><span class="sj-type-badge">Community Job</span><span class="sj-community-tag"><i class="fa-solid fa-users"></i> Reddy</span><span class="sj-status closed"><i class="fa-solid fa-circle"></i> Job Closed</span></div>
              <h3>Accounts Assistant</h3>
              <p class="sj-company">Evergreen Traders</p>
              <div class="sj-meta-grid">
                <span><i class="fa-solid fa-location-dot"></i> Haridwar, Uttarakhand</span>
                <span><i class="fa-solid fa-briefcase"></i> Fresher</span>
                <span><i class="fa-regular fa-clock"></i> Full Time</span>
                <span><i class="fa-solid fa-laptop"></i> On-site</span>
              </div>
              <div class="sj-job-bottom"><span class="sj-salary"><i class="fa-solid fa-indian-rupee-sign"></i> ₹12,000 – ₹16,000 / month</span><span><i class="fa-regular fa-calendar"></i> Posted 20 Sep 2026</span><span><i class="fa-solid fa-hourglass-half"></i> Closed 01 Oct 2026</span></div>
            </div>
          </div>
          <div class="sj-card-actions"><button class="sj-btn sj-btn-outline" type="button" data-view><i class="fa-regular fa-eye"></i> View Details</button><button class="sj-btn sj-btn-disabled" type="button" disabled><i class="fa-solid fa-lock"></i> Applications Closed</button><button class="sj-remove" type="button" data-remove aria-label="Remove Accounts Assistant from saved jobs"><i class="fa-solid fa-bookmark"></i> Remove from Saved</button></div>
        </article>
      </div>

      <section class="sj-empty" id="savedEmpty" hidden>
        <div class="sj-empty-icon"><i class="fa-regular fa-bookmark"></i></div>
        <h3>You have not saved any jobs yet.</h3>
        <p>Save interesting opportunities while browsing and they’ll appear here for easy access.</p>
        <a href="job-search-results.html" class="sj-btn sj-btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Browse Jobs</a>
      </section>
    </section>
  </main>

  <!-- FOOTER -->
  <footer class="pl-footer">
    <div class="pl-footer-main">
      <div class="pl-footer-container">
        <div class="pl-footer-grid">
          <div class="pl-footer-brand">
            <a href="index.html" class="pl-footer-logo"><img src="images/logo.jpeg" alt="PeopleLink"></a>
            <p>PeopleLink brings communities together, helping people connect with family, discover opportunities, build relationships and access trusted services.</p>
            <div class="pl-footer-social">
              <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a><a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a><a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a><a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a><a href="#" aria-label="X"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
          </div>
          <div class="pl-footer-column"><h3>PeopleLink</h3><ul><li><a href="index.html">Home</a></li><li><a href="about.html">About Us</a></li><li><a href="#communityList">Our Communities</a></li><li><a href="#platformServices">Our Services</a></li><li><a href="#events">Events</a></li><li><a href="#contact">Contact Us</a></li></ul></div>
          <div class="pl-footer-column"><h3>Community</h3><ul><li><a href="#">Matrimony &amp; Relationships</a></li><li><a href="#">Family &amp; Community</a></li><li><a href="job-search-results.html">Jobs &amp; Career</a></li><li><a href="#">Professionals &amp; Businesses</a></li><li><a href="#">Marketplace</a></li><li><a href="#events">Community Events</a></li></ul></div>
          <div class="pl-footer-column"><h3>Support</h3><ul><li><a href="#help">Help Center</a></li><li><a href="#contact">Contact Support</a></li><li><a href="#faq">FAQs</a></li><li><a href="#privacy">Privacy Policy</a></li><li><a href="#terms">Terms &amp; Conditions</a></li><li><a href="#safety">Community Guidelines</a></li></ul></div>
          <div class="pl-footer-contact" id="contact"><h3>Get In Touch</h3><a href="#" class="pl-contact-item"><span class="pl-contact-icon"><i class="fa-solid fa-location-dot"></i></span><span><small>Location</small><strong>India</strong></span></a><a href="mailto:info@peoplelink.com" class="pl-contact-item"><span class="pl-contact-icon"><i class="fa-solid fa-envelope"></i></span><span><small>Email</small><strong>info@peoplelink.com</strong></span></a><a href="tel:+910000000000" class="pl-contact-item"><span class="pl-contact-icon"><i class="fa-solid fa-phone"></i></span><span><small>Phone</small><strong>+91 00000 00000</strong></span></a></div>
        </div>
      </div>
    </div>
    <div class="pl-footer-community-strip"><div class="pl-footer-container"><div class="pl-community-strip-content"><span class="pl-strip-icon"><i class="fa-solid fa-people-group"></i></span><div><strong>One Platform. Many Communities.</strong><span>Bringing people, families and opportunities closer together.</span></div></div><div class="pl-strip-items"><span><i class="fa-solid fa-heart"></i> Relationships</span><span><i class="fa-solid fa-briefcase"></i> Opportunities</span><span><i class="fa-solid fa-store"></i> Businesses</span><span><i class="fa-solid fa-calendar-days"></i> Events</span></div></div></div>
    <div class="pl-footer-bottom"><div class="pl-footer-container"><div class="pl-copyright">© <span id="plCopyrightYear"></span> PeopleLink Technologies Private Limited. All Rights Reserved.</div><div class="pl-footer-bottom-links"><a href="#privacy">Privacy</a><a href="#terms">Terms</a><a href="#cookies">Cookies</a></div><button class="pl-back-top" type="button" id="plBackToTop" aria-label="Back to top"><i class="fa-solid fa-arrow-up"></i></button></div></div>
  </footer>

  <div class="sj-toast" id="sjToast" role="status" aria-live="polite"></div>
  <div class="sj-modal" id="jobModal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modalJobTitle">
    <div class="sj-modal-backdrop" data-close-modal></div>
    <div class="sj-modal-panel">
      <div class="sj-modal-head"><div><span class="sj-kicker">SAVED JOB DETAILS</span><h2 id="modalJobTitle">Job title</h2><p id="modalCompany">Company</p></div><button type="button" class="sj-modal-close" data-close-modal aria-label="Close details"><i class="fa-solid fa-xmark"></i></button></div>
      <div class="sj-modal-content" id="modalContent"></div>
      <div class="sj-modal-actions"><button type="button" class="sj-btn sj-btn-outline" data-close-modal>Close</button><a href="apply-to-job.html" id="modalApply" class="sj-btn sj-btn-primary"><i class="fa-solid fa-paper-plane"></i> Apply Now</a></div>
    </div>
  </div>

  <script src="header.js"></script>
  <script src="saved-jobs.js"></script>
<script src="js/jobs-global.js"></script>
</body>
</html>
