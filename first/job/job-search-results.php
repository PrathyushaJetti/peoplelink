<?php
// Page 37 – Job Search Results
// Demo-ready page. Replace the sample $jobs array with your database query when connecting to your jobs table.
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$keyword = trim($_GET['keyword'] ?? '');
$location = trim($_GET['location'] ?? '');
$jobType = trim($_GET['job_type'] ?? '');
$jobScope = trim($_GET['scope'] ?? 'all'); // all, community, global
$sort = trim($_GET['sort'] ?? 'latest');

$jobs = [
    [
        'id'=>101, 'title'=>'PHP Web Developer', 'company'=>'Deep Web Solution',
        'location'=>'Dehradun, Uttarakhand', 'experience'=>'1–3 Years',
        'qualification'=>'BCA / B.Tech / Relevant Experience', 'job_type'=>'Full Time',
        'work_mode'=>'Hybrid', 'salary_min'=>18000, 'salary_max'=>35000,
        'posted'=>'2026-10-08', 'scope'=>'community', 'community'=>'Arya Vysya',
        'relevance'=>95, 'description'=>'Develop and maintain responsive PHP and MySQL websites.'
    ],
    [
        'id'=>102, 'title'=>'Digital Marketing Executive', 'company'=>'GrowthPath Media',
        'location'=>'Delhi, India', 'experience'=>'0–2 Years',
        'qualification'=>'Any Graduate', 'job_type'=>'Full Time',
        'work_mode'=>'On-site', 'salary_min'=>15000, 'salary_max'=>28000,
        'posted'=>'2026-10-07', 'scope'=>'global', 'community'=>'',
        'relevance'=>82, 'description'=>'Support SEO, campaign reporting and digital marketing activities.'
    ],
    [
        'id'=>103, 'title'=>'UI/UX Designer', 'company'=>'PixelCraft Studio',
        'location'=>'Remote, India', 'experience'=>'2–4 Years',
        'qualification'=>'Design Degree or Portfolio', 'job_type'=>'Contract',
        'work_mode'=>'Remote', 'salary_min'=>30000, 'salary_max'=>55000,
        'posted'=>'2026-10-06', 'scope'=>'community', 'community'=>'Reddy',
        'relevance'=>90, 'description'=>'Design clear, accessible web and mobile experiences.'
    ],
    [
        'id'=>104, 'title'=>'Customer Support Associate', 'company'=>'ConnectOne Services',
        'location'=>'Noida, Uttar Pradesh', 'experience'=>'Fresher',
        'qualification'=>'12th Pass / Graduate', 'job_type'=>'Full Time',
        'work_mode'=>'On-site', 'salary_min'=>14000, 'salary_max'=>22000,
        'posted'=>'2026-10-05', 'scope'=>'global', 'community'=>'',
        'relevance'=>75, 'description'=>'Assist customers and maintain accurate support records.'
    ],
    [
        'id'=>105, 'title'=>'WordPress Developer', 'company'=>'WebNest Technologies',
        'location'=>'Remote, India', 'experience'=>'1–3 Years',
        'qualification'=>'Any Graduate / Relevant Experience', 'job_type'=>'Part Time',
        'work_mode'=>'Remote', 'salary_min'=>20000, 'salary_max'=>40000,
        'posted'=>'2026-10-04', 'scope'=>'community', 'community'=>'Kamma',
        'relevance'=>88, 'description'=>'Build, customise and maintain WordPress websites.'
    ],
    [
        'id'=>106, 'title'=>'Accounts Assistant', 'company'=>'Shree Enterprises',
        'location'=>'Jaipur, Rajasthan', 'experience'=>'1–2 Years',
        'qualification'=>'B.Com / Relevant Experience', 'job_type'=>'Full Time',
        'work_mode'=>'On-site', 'salary_min'=>16000, 'salary_max'=>25000,
        'posted'=>'2026-10-02', 'scope'=>'global', 'community'=>'',
        'relevance'=>70, 'description'=>'Maintain invoices, records and basic accounting reports.'
    ],
];

$filteredJobs = array_values(array_filter($jobs, function ($job) use ($keyword, $location, $jobType, $jobScope) {
    $haystack = strtolower($job['title'].' '.$job['company'].' '.$job['description'].' '.$job['qualification']);
    if ($keyword !== '' && strpos($haystack, strtolower($keyword)) === false) return false;
    if ($location !== '' && strpos(strtolower($job['location']), strtolower($location)) === false) return false;
    if ($jobType !== '' && strtolower($job['job_type']) !== strtolower($jobType)) return false;
    if ($jobScope !== 'all' && $job['scope'] !== $jobScope) return false;
    return true;
}));

usort($filteredJobs, function ($a, $b) use ($sort) {
    if ($sort === 'relevant') return $b['relevance'] <=> $a['relevance'];
    if ($sort === 'salary_high') return $b['salary_max'] <=> $a['salary_max'];
    if ($sort === 'salary_low') return $a['salary_min'] <=> $b['salary_min'];
    return strcmp($b['posted'], $a['posted']);
});

function h($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function moneyRange($min, $max) {
    if (!$min && !$max) return 'Salary not disclosed';
    return '₹'.number_format((int)$min).' – ₹'.number_format((int)$max).' / month';
}
function dateLabel($date) { return date('d M Y', strtotime($date)); }
$totalJobs = count($filteredJobs);
$displayJobs = array_slice($filteredJobs, 0, 4);
?>
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
        href="job-search-results.css"
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

<main class="pl-jobs-page">
    <section class="jobs-hero">
        <div class="jobs-container">
            <div class="hero-copy">
                <span class="eyebrow"><i class="fa-solid fa-people-group"></i> PEOPLELINK CAREER NETWORK</span>
                <h1>Find your next <span>opportunity.</span></h1>
                <p>Explore career opportunities shared by your community and employers across India.</p>
            </div>
            <div class="hero-graphic" aria-hidden="true">
                <div class="hero-icon"><i class="fa-solid fa-briefcase"></i></div>
                <span class="float-icon float-one"><i class="fa-solid fa-user-tie"></i></span>
                <span class="float-icon float-two"><i class="fa-solid fa-location-dot"></i></span>
                <span class="float-icon float-three"><i class="fa-solid fa-arrow-trend-up"></i></span>
            </div>
        </div>
    </section>

    <section class="jobs-container results-area">
        <form class="filter-summary" id="filterForm" method="get" action="">
            <div class="summary-heading">
                <div>
                    <span class="section-kicker">YOUR SEARCH</span>
                    <h2>Job Search Results</h2>
                    <p>Review roles that match your selected filters.</p>
                </div>
                <a class="btn btn-outline" href="job-search.php"><i class="fa-solid fa-sliders"></i> Edit Filters</a>
            </div>
            <div class="summary-fields">
                <label class="summary-field"><span>Search Keyword</span><strong><i class="fa-solid fa-magnifying-glass"></i> <?= $keyword !== '' ? h($keyword) : 'All opportunities' ?></strong></label>
                <label class="summary-field"><span>Selected Location</span><strong><i class="fa-solid fa-location-dot"></i> <?= $location !== '' ? h($location) : 'Any location' ?></strong></label>
                <label class="summary-field"><span>Job Type</span><strong><i class="fa-solid fa-clock"></i> <?= $jobType !== '' ? h($jobType) : 'Any job type' ?></strong></label>
                <label class="summary-field"><span>Job Category</span><strong><i class="fa-solid fa-earth-asia"></i> <?= $jobScope === 'all' ? 'Community + Global' : h(ucfirst($jobScope).' Jobs') ?></strong></label>
            </div>
            <input type="hidden" name="keyword" value="<?= h($keyword) ?>">
            <input type="hidden" name="location" value="<?= h($location) ?>">
            <input type="hidden" name="job_type" value="<?= h($jobType) ?>">
            <input type="hidden" name="scope" value="<?= h($jobScope) ?>">
        </form>

        <div class="results-toolbar">
            <div class="results-count"><strong><?= number_format($totalJobs) ?> Jobs Found</strong><span>Opportunities picked for your search</span></div>
            <label class="sort-control">Sort By
                <select name="sort" id="sortJobs" aria-label="Sort jobs">
                    <option value="latest" <?= $sort==='latest'?'selected':'' ?>>Latest</option>
                    <option value="relevant" <?= $sort==='relevant'?'selected':'' ?>>Most Relevant</option>
                    <option value="salary_high" <?= $sort==='salary_high'?'selected':'' ?>>Salary: High to Low</option>
                    <option value="salary_low" <?= $sort==='salary_low'?'selected':'' ?>>Salary: Low to High</option>
                </select>
            </label>
        </div>

        <?php if ($totalJobs > 0): ?>
        <div class="job-list" id="jobList">
            <?php foreach ($displayJobs as $job): ?>
            <article class="job-card" data-salary="<?= (int)$job['salary_max'] ?>" data-date="<?= h($job['posted']) ?>">
                <div class="job-card-top">
                    <div class="company-mark"><?= h(strtoupper(substr($job['company'], 0, 1))) ?></div>
                    <div class="job-main">
                        <div class="job-tags">
                            <span class="job-type-tag"><?= h($job['scope']==='community'?'Community Job':'Global Job') ?></span>
                            <?php if ($job['scope']==='community' && $job['community']!==''): ?><span class="community-tag"><?= h($job['community']) ?> Community</span><?php endif; ?>
                        </div>
                        <h3><?= h($job['title']) ?></h3>
                        <p class="company-name"><?= h($job['company']) ?></p>
                    </div>
                    <button type="button" class="save-job" aria-label="Save <?= h($job['title']) ?>" data-job-id="<?= (int)$job['id'] ?>"><i class="fa-regular fa-bookmark"></i><span>Save Job</span></button>
                </div>
                <div class="job-meta">
                    <span><i class="fa-solid fa-location-dot"></i><?= h($job['location']) ?></span>
                    <span><i class="fa-solid fa-briefcase"></i><?= h($job['experience']) ?></span>
                    <span><i class="fa-solid fa-graduation-cap"></i><?= h($job['qualification']) ?></span>
                    <span><i class="fa-solid fa-clock"></i><?= h($job['job_type']) ?></span>
                    <span><i class="fa-solid fa-laptop"></i><?= h($job['work_mode']) ?></span>
                </div>
                <div class="job-card-bottom">
                    <div class="salary"><i class="fa-solid fa-indian-rupee-sign"></i><strong><?= h(moneyRange($job['salary_min'], $job['salary_max'])) ?></strong><small>Posted <?= h(dateLabel($job['posted'])) ?></small></div>
                    <div class="job-actions">
                        <a class="btn btn-outline" href="job-details.php?id=<?= (int)$job['id'] ?>">View Details <i class="fa-solid fa-arrow-right"></i></a>
                        <a class="btn btn-primary" href="job-details.php?id=<?= (int)$job['id'] ?>#apply">Apply Now</a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php if ($totalJobs > count($displayJobs)): ?>
            <div class="load-more-wrap"><button class="btn btn-load" id="loadMoreJobs" type="button">Load More Jobs <i class="fa-solid fa-chevron-down"></i></button></div>
            <script>window.peopleLinkJobResults = <?= json_encode(array_slice($filteredJobs, 4), JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP) ?>;</script>
        <?php endif; ?>
        <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
            <h3>No jobs found matching your search.</h3>
            <p>Try changing your keyword, location or job type to discover more opportunities.</p>
            <div class="empty-actions"><a class="btn btn-primary" href="job-search.php"><i class="fa-solid fa-sliders"></i> Modify Filters</a><a class="btn btn-outline" href="job-search-results.php">View All Jobs</a></div>
        </div>
        <?php endif; ?>
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
<script src="job-search-results.js"></script>
<script src="js/jobs-global.js"></script>
</body>
</html>
