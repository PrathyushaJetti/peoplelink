<?php
// Job Search (live: approved jobs from the jobs backend; the filters on this page work on these jobs)
require_once dirname(__DIR__) . '/_web.php';
$_REQUEST['per'] = 50; $_REQUEST['page'] = 1;
$searchJobs = array_map('web_job_card', pl_jobs_list(web_ctx(), ['sort' => 'latest'])['items']);
$jsCats = pl_categories('jobs');
$jsExp = fn($e) => ['fresher' => 'fresher', '0-1 years' => '0-1', '1-3 years' => '1-3', '3-5 years' => '3-5', '5-10 years' => '5-10', '10+ years' => '10-plus'][strtolower(trim((string)$e))] ?? '';
$jsMode = fn($m) => ['On-site' => 'office', 'Remote' => 'home', 'Hybrid' => 'hybrid'][$m] ?? strtolower((string)$m);
$jsYear = fn($j) => (int)round((float)($j['salary_max'] ?: $j['salary_min']) * ['month' => 12, 'year' => 1, 'day' => 300, 'hour' => 2400][$j['salary_period'] ?? 'month']);
$jsColors = ['blue', 'purple', 'green', 'orange', 'teal'];
?>
<?php $pageTitle = "Search Jobs | PeopleLink"; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- =====================================================
         BASIC META
    ====================================================== -->

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="PeopleLink — Connect, discover and belong to your community."
    >

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

 
    <title>
        PeopleLink | Connect • Discover • Belong
    </title>


    <!-- =====================================================
         GOOGLE FONTS
    ====================================================== -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <!-- =====================================================
         FONT AWESOME
    ====================================================== -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >
    <!-- =====================================================
         HEADER CSS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="header.css"
    >

     <link
        rel="stylesheet"
        href="job-search.css"
    >

        <link
        rel="stylesheet"
        href="footer.css"
    >

</head>


<body>


<!-- =========================================================
     PEOPLELINK HEADER
========================================================= -->

<header
    class="pl-header"
    id="peoplelinkHeader"
>


    <!-- =====================================================
         TOP BAR
    ====================================================== -->

    <div class="pl-topbar">

        <div class="pl-container">

            <div class="pl-top-left">

                <span>
                    <i class="fa-solid fa-heart"></i>
                    Connecting Communities
                </span>

                <span>
                    <i class="fa-solid fa-location-dot"></i>
                    Communities Across India
                </span>

            </div>


            <div class="pl-top-right">

                <a href="#help">
                    Help & Support
                </a>

                <a href="#contact">
                    Contact Us
                </a>

            </div>

        </div>

    </div>


    <!-- =====================================================
         MAIN NAVIGATION
    ====================================================== -->

    <div class="pl-navbar">

        <div class="pl-container">


            <!-- =================================================
                 ACTUAL PEOPLELINK LOGO
            ================================================== -->

            <a
                href="index.php"
                class="pl-logo"
                aria-label="PeopleLink Home"
            >

                <img
                    src="images/logo.jpeg"
                    alt="PeopleLink"
                    class="pl-logo-image"
                >

            </a>


            <!-- =================================================
                 MOBILE MENU BUTTON
            ================================================== -->

            <button
                type="button"
                class="pl-mobile-toggle"
                id="plMobileToggle"
                aria-label="Open navigation"
                aria-expanded="false"
            >

                <span></span>
                <span></span>
                <span></span>

            </button>


            <!-- =================================================
                 MAIN NAVIGATION
            ================================================== -->

            <nav
                class="pl-main-nav"
                id="plMainNav"
                aria-label="Main Navigation"
            >


                <a
                    href="index.php"
                    class="pl-nav-link active"
                >
                    Home
                </a>


                <!-- =============================================
                     COMMUNITIES
                ============================================== -->

                <div class="pl-nav-dropdown">

                    <button
                        type="button"
                        class="pl-nav-dropdown-btn"
                    >

                        Communities

                        <i class="fa-solid fa-chevron-down"></i>

                    </button>


                    <div class="pl-dropdown-menu">

                        <div class="pl-dropdown-title">

                            <strong>
                                OUR COMMUNITIES
                            </strong>

                            <span>
                                Choose your community
                            </span>

                        </div>


                        <a href="#communityList">

                            <i class="fa-solid fa-people-group"></i>

                            Arya Vysya

                        </a>


                        <a href="#communityList">

                            <i class="fa-solid fa-users"></i>

                            Reddy

                        </a>


                        <a href="#communityList">

                            <i class="fa-solid fa-people-roof"></i>

                            Kamma

                        </a>


                        <a href="#communityList">

                            <i class="fa-solid fa-user-group"></i>

                            Kapu

                        </a>


                        <a href="#communityList">

                            <i class="fa-solid fa-people-arrows"></i>

                            Banjara

                        </a>


                        <a
                            href="#communityList"
                            class="pl-dropdown-all"
                        >

                            View All Communities

                            <i class="fa-solid fa-arrow-right"></i>

                        </a>

                    </div>

                </div>


                <!-- =============================================
                     SERVICES
                ============================================== -->

                <a
                    href="service.php"
                    class="pl-nav-link"
                >
                    Services
                </a>


                <!-- =============================================
                     ABOUT
                ============================================== -->

                <a
                    href="about.php"
                    class="pl-nav-link"
                >
                    About Us
                </a>


                <!-- =============================================
                     EVENTS
                ============================================== -->

                <a
                    href="#events"
                    class="pl-nav-link"
                >
                    Events
                </a>


                <!-- =============================================
                     CONTACT
                ============================================== -->

                <a
                    href="#contact"
                    class="pl-nav-link"
                >
                    Contact
                </a>


                <!-- =============================================
                     MOBILE ACTIONS
                ============================================== -->

                <div class="pl-mobile-actions">

                    <a
                        href="#communityList"
                        class="pl-mobile-community"
                    >

                        <i class="fa-solid fa-users"></i>

                        Select Your Community

                    </a>


                    <a
                        href="#downloadApp"
                        class="pl-mobile-download"
                    >

                        <i class="fa-solid fa-mobile-screen-button"></i>

                        Download App

                    </a>

                </div>


            </nav>


            <!-- =================================================
                 DESKTOP ACTIONS
            ================================================== -->

            <div class="pl-header-actions">


                <!-- Login -->

                <a
                    href="#login"
                    class="pl-login"
                >

                    <i class="fa-regular fa-user"></i>

                    Login

                </a>


                <!-- Select Community -->

                <a
                    href="#communityList"
                    class="pl-community-button"
                >

                    <i class="fa-solid fa-users"></i>

                    Select Community

                </a>


                <!-- Download App -->

                <a
                    href="#downloadApp"
                    class="pl-download-button"
                >

                    <i class="fa-solid fa-mobile-screen-button"></i>

                    Download App

                </a>


            </div>

        </div>

    </div>

</header>
<main class="pl-job-search-page">
  <section class="pl-js-hero">
    <div class="pl-js-container pl-js-hero-grid">
      <div>
        <span class="pl-js-eyebrow"><i class="bi bi-briefcase-fill"></i> PEOPLELINK CAREERS</span>
        <h1>Search <span>Jobs</span></h1>
        <p>Find opportunities that match your skills, experience and career goals — within your community or across the PeopleLink network.</p>
        <div class="pl-js-points"><span><i class="bi bi-check-circle-fill"></i> Relevant opportunities</span><span><i class="bi bi-check-circle-fill"></i> Flexible work options</span><span><i class="bi bi-check-circle-fill"></i> Easy job discovery</span></div>
      </div>
      <div class="pl-js-hero-art" aria-hidden="true"><div class="pl-js-art-orbit"></div><div class="pl-js-art-card"><span class="pl-js-art-icon"><i class="bi bi-search"></i></span><strong>Find your next opportunity</strong><small>Search smarter. Grow further.</small><i class="pl-js-art-line"></i><i class="pl-js-art-line short"></i></div><span class="pl-js-bubble bubble-one"><i class="bi bi-briefcase-fill"></i></span><span class="pl-js-bubble bubble-two"><i class="bi bi-people-fill"></i></span></div>
    </div>
  </section>
  <section class="pl-js-main pl-js-results-layout">
    <div class="pl-js-container">
      <div class="pl-js-heading">
        <span>YOUR CAREER, YOUR CHOICE</span>
        <h2>Find the right job for you</h2>
        <p>Filter opportunities on the left and explore matching jobs in the centre.</p>
      </div>

      <div class="pl-js-workspace">
        <aside class="pl-js-sidebar" aria-label="Job filters">
          <div class="pl-js-sidebar-head">
            <div><span class="pl-js-sidebar-kicker"><i class="bi bi-sliders"></i> REFINE SEARCH</span><h3>Job Filters</h3></div>
            <button type="button" id="plJobReset" class="pl-js-reset-link">Reset</button>
          </div>
          <form id="plJobSearchForm" class="pl-js-filter-form" action="#" method="get">
            <input type="hidden" name="visibility" id="plJobVisibility" value="community">
            <div class="pl-js-filter-group">
              <label class="pl-js-filter-label">Job Network</label>
              <div class="pl-js-network-options sidebar-networks">
                <button type="button" class="pl-js-network is-active" data-visibility="community" aria-pressed="true"><span class="pl-js-network-icon"><i class="bi bi-people-fill"></i></span><span><strong>Community Jobs</strong><small>Selected community</small></span><i class="bi bi-check-circle-fill pl-js-check"></i></button>
                <button type="button" class="pl-js-network" data-visibility="global" aria-pressed="false"><span class="pl-js-network-icon global"><i class="bi bi-globe"></i></span><span><strong>Global Jobs</strong><small>All communities</small></span><i class="bi bi-check-circle-fill pl-js-check"></i></button>
              </div>
              <p class="pl-js-scope-note" id="plJobScopeNote"><i class="bi bi-info-circle"></i> Showing community opportunities.</p>
            </div>
            <div class="pl-js-filter-group">
              <label class="pl-js-filter-label" for="plJobTitle">Job title</label>
              <div class="pl-js-input"><i class="bi bi-briefcase"></i><input id="plJobTitle" name="job_title" placeholder="e.g. Web Developer"></div>
            </div>
            <div class="pl-js-filter-group">
              <label class="pl-js-filter-label" for="plJobKeyword">Skill or keyword</label>
              <div class="pl-js-input"><i class="bi bi-lightning-charge"></i><input id="plJobKeyword" name="keyword" placeholder="e.g. PHP, sales"></div>
            </div>
            <div class="pl-js-filter-group">
              <label class="pl-js-filter-label" for="plJobLocation">Location</label>
              <div class="pl-js-input"><i class="bi bi-geo-alt"></i><input id="plJobLocation" name="location" placeholder="City, state or country"></div>
            </div>
            <div class="pl-js-filter-group">
              <label class="pl-js-filter-label" for="plJobCategory">Job category</label>
              <div class="pl-js-input"><i class="bi bi-grid"></i><select id="plJobCategory" name="category"><option value="">All categories</option><?php foreach ($jsCats as $c): ?><option><?= h($c['name']) ?></option><?php endforeach; ?></select></div>
            </div>
            <div class="pl-js-filter-group">
              <label class="pl-js-filter-label" for="plJobQualification">Qualification</label>
              <div class="pl-js-input"><i class="bi bi-mortarboard"></i><select id="plJobQualification" name="qualification"><option value="">Any qualification</option><option>10th Pass</option><option>12th Pass</option><option>ITI / Diploma</option><option>Graduate</option><option>Postgraduate</option><option>Professional Degree</option></select></div>
            </div>
            <div class="pl-js-filter-group">
              <label class="pl-js-filter-label" for="plJobExperience">Experience</label>
              <div class="pl-js-input"><i class="bi bi-person-workspace"></i><select id="plJobExperience" name="experience"><option value="">Any experience</option><option value="fresher">Fresher</option><option value="0-1">0–1 Year</option><option value="1-3">1–3 Years</option><option value="3-5">3–5 Years</option><option value="5-10">5–10 Years</option><option value="10-plus">10+ Years</option></select></div>
            </div>
            <div class="pl-js-filter-group">
              <label class="pl-js-filter-label" for="plJobType">Job type</label>
              <div class="pl-js-input"><i class="bi bi-clock"></i><select id="plJobType" name="job_type"><option value="">All job types</option><option>Full Time</option><option>Part Time</option><option>Contract</option><option>Internship</option><option>Freelance</option></select></div>
            </div>
            <div class="pl-js-filter-group">
              <label class="pl-js-filter-label" for="plJobWorkMode">Work mode</label>
              <div class="pl-js-input"><i class="bi bi-laptop"></i><select id="plJobWorkMode" name="work_mode"><option value="">All work modes</option><option value="office">Work From Office</option><option value="home">Work From Home</option><option value="hybrid">Hybrid</option></select></div>
            </div>
            <div class="pl-js-filter-group">
              <label class="pl-js-filter-label">Annual salary (₹)</label>
              <div class="pl-js-salary-row"><input id="plJobSalaryMin" name="salary_min" type="number" min="0" step="1000" placeholder="Min"><input id="plJobSalaryMax" name="salary_max" type="number" min="0" step="1000" placeholder="Max"></div>
            </div>
            <button class="pl-js-btn primary pl-js-apply-btn" type="submit"><i class="bi bi-search"></i> Apply Filters</button>
            <p class="pl-js-hint"><i class="bi bi-shield-check"></i> Update filters to narrow the jobs shown here.</p>
          </form>
        </aside>

        <section class="pl-js-results-column" aria-label="Job search results">
          <div class="pl-js-results-toolbar">
            <div><span class="pl-js-results-eyebrow">OPPORTUNITIES FOR YOU</span><h3>Job Search Results</h3><p id="plJobResultCount">Showing 6 sample opportunities</p></div>
            <label class="pl-js-sort-label">Sort by
              <select id="plJobSort" name="sort"><option value="latest">Latest Jobs</option><option value="relevant">Most Relevant</option><option value="salary_desc">Salary: High to Low</option><option value="salary_asc">Salary: Low to High</option></select>
            </label>
          </div>
          <div class="pl-js-active-filters" id="plJobActiveFilters"><span>Suggested opportunities</span></div>
          <div class="pl-js-job-list" id="plJobResults">
            <?php foreach ($searchJobs as $i => $j): $g = $j['scope'] === 'global'; ?>
            <article class="pl-js-job-card" data-id="<?= (int)$j['id'] ?>" data-title="<?= h($j['title']) ?>" data-keyword="<?= h(strtolower($j['required_skills'] . ' ' . $j['company'] . ' ' . $j['category_name'])) ?>" data-location="<?= h(strtolower($j['location'])) ?>" data-category="<?= h($j['category_name']) ?>" data-qualification="<?= h($j['qualification']) ?>" data-experience="<?= h($jsExp($j['experience'])) ?>" data-type="<?= h($j['job_type']) ?>" data-mode="<?= h($jsMode($j['work_mode'])) ?>" data-salary="<?= $jsYear($j) ?>" data-visibility="<?= $g ? 'global' : 'community' ?>" data-date="<?= strtotime($j['created_at']) ?>">
              <div class="pl-js-company-logo <?= $jsColors[$i % 5] ?>"><i class="bi bi-briefcase"></i></div><div class="pl-js-job-content"><div class="pl-js-job-top"><span class="pl-js-job-tag <?= $g ? 'global-tag' : 'community-tag' ?>"><?= $g ? 'Global Job' : 'Community Job' ?></span><span class="pl-js-posted"><i class="bi bi-clock"></i> <?= h(web_ago($j['created_at'])) ?></span></div><h4><?= h($j['title']) ?></h4><p class="pl-js-company"><?= h($j['company']) ?></p><div class="pl-js-job-meta"><span><i class="bi bi-geo-alt"></i> <?= h($j['location']) ?></span><span><i class="bi bi-briefcase"></i> <?= h($j['experience'] ?: 'Any experience') ?></span><span><i class="bi bi-laptop"></i> <?= h($j['work_mode']) ?></span></div><div class="pl-js-job-bottom"><strong class="pl-js-salary"><?= h($j['salary_text'] ?: 'Not disclosed') ?></strong><span class="pl-js-category"><?= h($j['category_name']) ?></span><a href="job-details.php?id=<?= (int)$j['id'] ?>" class="pl-js-view-job">View Details <i class="bi bi-arrow-up-right"></i></a></div></div>
            </article>
            <?php endforeach; ?>
          </div>
          <div class="pl-js-empty" id="plJobEmpty" hidden><span><i class="bi bi-search"></i></span><h3>No matching jobs found</h3><p>Try changing your filters or reset the search to see more opportunities.</p><button type="button" id="plJobEmptyReset" class="pl-js-btn secondary">Clear all filters</button></div>
          <div class="pl-js-results-foot"><i class="bi bi-info-circle"></i> These are sample job cards for layout preview. Connect this list to your jobs database for live results.</div>
        </section>
      </div>
    </div>
  </section>
</main>
    <!-- =====================================================
         MAIN FOOTER
    ====================================================== -->

    <div class="pl-footer-main">

        <div class="pl-footer-container">

            <div class="pl-footer-grid">


                <!-- =================================================
                     BRAND
                ================================================== -->

                <div class="pl-footer-brand">

                    <a
                        href="index.php"
                        class="pl-footer-logo"
                    >

                        <img
                            src="images/logo.jpeg"
                            alt="PeopleLink"
                        >

                    </a>


                    <p>
                        PeopleLink brings communities together,
                        helping people connect with family,
                        discover opportunities, build relationships
                        and access trusted services.
                    </p>


                    <!-- Social Media -->

                    <div class="pl-footer-social">

                        <a
                            href="#"
                            aria-label="Facebook"
                        >
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>

                        <a
                            href="#"
                            aria-label="Instagram"
                        >
                            <i class="fa-brands fa-instagram"></i>
                        </a>

                        <a
                            href="#"
                            aria-label="LinkedIn"
                        >
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>

                        <a
                            href="#"
                            aria-label="YouTube"
                        >
                            <i class="fa-brands fa-youtube"></i>
                        </a>

                        <a
                            href="#"
                            aria-label="X"
                        >
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>

                    </div>

                </div>



                <!-- =================================================
                     PEOPLELINK
                ================================================== -->

                <div class="pl-footer-column">

                    <h3>
                        PeopleLink
                    </h3>

                    <ul>

                        <li>
                            <a href="index.php">
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="#about">
                                About Us
                            </a>
                        </li>

                        <li>
                            <a href="#communityList">
                                Our Communities
                            </a>
                        </li>

                        <li>
                            <a href="#platformServices">
                                Our Services
                            </a>
                        </li>

                        <li>
                            <a href="#events">
                                Events
                            </a>
                        </li>

                        <li>
                            <a href="#contact">
                                Contact Us
                            </a>
                        </li>

                    </ul>

                </div>



                <!-- =================================================
                     COMMUNITY
                ================================================== -->

                <div class="pl-footer-column">

                    <h3>
                        Community
                    </h3>

                    <ul>

                        <li>
                            <a href="#communityList">
                                Matrimony & Relationships
                            </a>
                        </li>

                        <li>
                            <a href="#platformServices">
                                Family & Community
                            </a>
                        </li>

                        <li>
                            <a href="#platformServices">
                                Jobs & Career
                            </a>
                        </li>

                        <li>
                            <a href="#platformServices">
                                Professionals & Businesses
                            </a>
                        </li>

                        <li>
                            <a href="#platformServices">
                                Marketplace
                            </a>
                        </li>

                        <li>
                            <a href="#events">
                                Community Events
                            </a>
                        </li>

                    </ul>

                </div>



                <!-- =================================================
                     SUPPORT
                ================================================== -->

                <div class="pl-footer-column">

                    <h3>
                        Support
                    </h3>

                    <ul>

                        <li>
                            <a href="#help">
                                Help Center
                            </a>
                        </li>

                        <li>
                            <a href="#contact">
                                Contact Support
                            </a>
                        </li>

                        <li>
                            <a href="#faq">
                                FAQs
                            </a>
                        </li>

                        <li>
                            <a href="#privacy">
                                Privacy Policy
                            </a>
                        </li>

                        <li>
                            <a href="#terms">
                                Terms & Conditions
                            </a>
                        </li>

                        <li>
                            <a href="#safety">
                                Community Guidelines
                            </a>
                        </li>

                    </ul>

                </div>



                <!-- =================================================
                     CONTACT
                ================================================== -->

                <div class="pl-footer-contact">

                    <h3>
                        Get In Touch
                    </h3>


                    <!-- Location -->

                    <a
                        href="#"
                        class="pl-contact-item"
                    >

                        <div class="pl-contact-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>

                        <div>

                            <span>
                                Location
                            </span>

                            <strong>
                                India
                            </strong>

                        </div>

                    </a>


                    <!-- Email -->

                    <a
                        href="mailto:info@peoplelink.com"
                        class="pl-contact-item"
                    >

                        <div class="pl-contact-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>

                        <div>

                            <span>
                                Email
                            </span>

                            <strong>
                                info@peoplelink.com
                            </strong>

                        </div>

                    </a>


                    <!-- Phone -->

                    <a
                        href="tel:+910000000000"
                        class="pl-contact-item"
                    >

                        <div class="pl-contact-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>

                        <div>

                            <span>
                                Phone
                            </span>

                            <strong>
                                +91 00000 00000
                            </strong>

                        </div>

                    </a>


                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         COMMUNITY STRIP
    ====================================================== -->

    <div class="pl-footer-community-strip">

        <div class="pl-footer-container">

            <div class="pl-community-strip-content">

                <div class="pl-strip-icon">

                    <i class="fa-solid fa-people-group"></i>

                </div>

                <div>

                    <strong>
                        One Platform. Many Communities.
                    </strong>

                    <span>
                        Bringing people, families and opportunities
                        closer together.
                    </span>

                </div>

            </div>


            <div class="pl-strip-items">

                <span>
                    <i class="fa-solid fa-heart"></i>
                    Relationships
                </span>

                <span>
                    <i class="fa-solid fa-briefcase"></i>
                    Opportunities
                </span>

                <span>
                    <i class="fa-solid fa-store"></i>
                    Businesses
                </span>

                <span>
                    <i class="fa-solid fa-calendar-days"></i>
                    Events
                </span>

            </div>

        </div>

    </div>



    <!-- =====================================================
         FOOTER BOTTOM
    ====================================================== -->

    <div class="pl-footer-bottom">

        <div class="pl-footer-container">

            <div class="pl-copyright">

                ©
                <span id="plCopyrightYear"></span>
                PeopleLink Technologies Private Limited.
                All Rights Reserved.

            </div>


            <div class="pl-footer-bottom-links">

                <a href="#privacy">
                    Privacy
                </a>

                <a href="#terms">
                    Terms
                </a>

                <a href="#cookies">
                    Cookies
                </a>

            </div>


            <div class="pl-back-top">

                <button
                    type="button"
                    id="plBackToTop"
                    aria-label="Back to top"
                >

                    <i class="fa-solid fa-arrow-up"></i>

                </button>

            </div>

        </div>

    </div>

</footer>

<script src="header.js"></script>
<script src="job-search.js"></script>
<script src="js/jobs-global.js"></script>
</body>
</html>
