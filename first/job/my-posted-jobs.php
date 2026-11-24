<?php
// Page – My Posted Jobs (live: jobs_my / jobs_close / jobs_delete / jobs_renew backend actions)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $act = (string)($_POST['do'] ?? '');
    $allowed = ['close' => 'jobs_close', 'delete' => 'jobs_delete', 'renew' => 'jobs_renew'];
    if (isset($allowed[$act])) web_post($allowed[$act], 'my-posted-jobs.php' . (isset($_GET['tab']) ? '?tab=' . urlencode($_GET['tab']) : ''));
}

// all my jobs (newest first), with application counts per method
$_REQUEST['per'] = 50; $_REQUEST['page'] = 1;
$mine = web_call('jobs_my', ['per' => 50]);
$items = $mine['items'] ?? [];
$counts = [];
if ($items) {
    $ids = implode(',', array_map('intval', array_column($items, 'id')));
    foreach (rows("SELECT job_id, apply_method, COUNT(*) n FROM jobs_applications WHERE job_id IN ($ids) GROUP BY job_id, apply_method") as $r)
        $counts[(int)$r['job_id']][$r['apply_method']] = (int)$r['n'];
}
function mpj_state(array $j): array {
    $st = $j['status'] ?? 'pending';
    if ($st === 'approved' && !empty($j['expired'])) return ['expired', 'Expired'];
    return [['approved' => 'active', 'pending' => 'pending', 'rejected' => 'rejected', 'closed' => 'closed'][$st] ?? 'draft',
            ['approved' => 'Active', 'pending' => 'Pending Approval', 'rejected' => 'Rejected', 'closed' => 'Closed'][$st] ?? ucfirst($st)];
}
$tab = (string)($_GET['tab'] ?? 'all');
$q = trim((string)($_GET['q'] ?? ''));
$type = (string)($_GET['type'] ?? 'all');
$stats = ['all' => 0, 'active' => 0, 'pending' => 0, 'closed' => 0, 'expired' => 0, 'rejected' => 0];
foreach ($items as $j) { $stats['all']++; $stats[mpj_state($j)[0]] = ($stats[mpj_state($j)[0]] ?? 0) + 1; }
$appsTotal = array_sum(array_map('array_sum', $counts));
$shown = array_values(array_filter($items, function ($j) use ($tab, $q, $type) {
    if ($tab !== 'all' && mpj_state($j)[0] !== $tab) return false;
    if ($type !== 'all' && (!empty($j['is_global']) ? 'global' : 'community') !== $type) return false;
    if ($q !== '' && stripos($j['job_title'] . ' ' . $j['company_name'] . ' ' . $j['city'] . ' ' . $j['location'], $q) === false) return false;
    return true;
}));
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
        href="my-posted-jobs.css"
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

<body>

<main class="mpj-page">
    <section class="mpj-hero"><div class="mpj-container mpj-hero-inner"><div><span class="mpj-eyebrow"><i class="fa-solid fa-briefcase"></i> PEOPLELINK CAREER NETWORK</span><h1>My Posted Jobs</h1><p>Manage your opportunities, track application activity and keep your listings up to date.</p></div><div class="mpj-hero-art"><span class="mpj-art-icon"><i class="fa-solid fa-clipboard-check"></i></span><span class="mpj-art-mini"><i class="fa-solid fa-users"></i></span></div></div></section>
    <?= web_flash_html() ?>
    <div class="mpj-container mpj-content">
        <div class="mpj-heading-row"><div><span class="mpj-kicker">EMPLOYER WORKSPACE</span><h2>Your job listings</h2><p>Review status, monitor responses and manage each opportunity.</p></div><a class="mpj-btn primary" href="post-a-job.php"><i class="fa-solid fa-plus"></i> Post a Job</a></div>
        <section class="mpj-stats" aria-label="Job summary">
            <div class="mpj-stat"><span class="mpj-stat-icon blue"><i class="fa-solid fa-briefcase"></i></span><div><small>Total Jobs</small><strong><?= $stats['all'] ?></strong></div></div>
            <div class="mpj-stat"><span class="mpj-stat-icon green"><i class="fa-solid fa-circle-check"></i></span><div><small>Active Jobs</small><strong><?= $stats['active'] ?></strong></div></div>
            <div class="mpj-stat"><span class="mpj-stat-icon amber"><i class="fa-regular fa-clock"></i></span><div><small>Pending Approval</small><strong><?= $stats['pending'] ?></strong></div></div>
            <div class="mpj-stat"><span class="mpj-stat-icon purple"><i class="fa-solid fa-user-group"></i></span><div><small>Applications Received</small><strong><?= $appsTotal ?></strong></div></div>
        </section>
        <nav class="mpj-tabs" aria-label="Job status tabs">
            <?php foreach (['all' => 'All Jobs', 'active' => 'Active Jobs', 'pending' => 'Pending Approval', 'expired' => 'Expired', 'closed' => 'Closed Jobs', 'rejected' => 'Rejected'] as $k => $label): ?>
            <a class="<?= $tab === $k ? 'selected' : '' ?>" href="<?= h(web_qs(['tab' => $k])) ?>"><?= h($label) ?> <span><?= (int)$stats[$k] ?></span></a>
            <?php endforeach; ?>
        </nav>
        <form class="mpj-filters" method="get" action="my-posted-jobs.php">
            <input type="hidden" name="tab" value="<?= h($tab) ?>">
            <label class="mpj-search"><i class="fa-solid fa-magnifying-glass"></i><input type="search" name="q" value="<?= h($q) ?>" placeholder="Search job title, company or location" aria-label="Search jobs"></label>
            <select name="type" aria-label="Filter by job visibility"><option value="all">All job types</option><option value="community" <?= $type === 'community' ? 'selected' : '' ?>>Community Jobs</option><option value="global" <?= $type === 'global' ? 'selected' : '' ?>>Global Jobs</option></select>
            <button class="mpj-btn filter-btn" type="submit"><i class="fa-solid fa-sliders"></i> Filter</button>
            <a class="mpj-reset" href="my-posted-jobs.php">Reset</a>
        </form>
        <div class="mpj-results-line"><strong><?= count($shown) ?> job<?= count($shown) === 1 ? '' : 's' ?> found</strong><span>Manage listings and application activity</span></div>
        <div class="mpj-job-list">
        <?php if (!$shown): ?>
            <div class="mpj-demo-note"><i class="fa-solid fa-circle-info"></i><p><?= $items ? 'No jobs match these filters.' : 'You have not posted any jobs yet. <a href="post-a-job.php">Post your first job</a>.' ?></p></div>
        <?php endif; ?>
        <?php foreach ($shown as $j): [$sk, $sl] = mpj_state($j); $c = $counts[(int)$j['id']] ?? []; $g = !empty($j['is_global']); $loc = trim(implode(', ', array_filter([$j['location'], $j['city'], $j['state']])), ', ') ?: ($j['work_mode'] ?? ''); ?>
            <article class="mpj-job-card" data-job-card>
                <div class="mpj-job-top"><div class="mpj-company-mark<?= $g ? ' global' : '' ?>"><i class="fa-solid <?= $g ? 'fa-earth-asia' : 'fa-building' ?>"></i></div><div class="mpj-job-title-wrap"><div class="mpj-badges"><span class="mpj-type-badge<?= $g ? ' global' : '' ?>"><?= $g ? 'Global Job' : 'Community Job' ?></span><?php if (!$g && !empty($j['community_name'])): ?><span class="mpj-community-badge"><i class="fa-solid fa-users"></i> <?= h($j['community_name']) ?></span><?php endif; ?></div><h3><?= h($j['job_title']) ?></h3><p class="mpj-company-name"><?= h($j['company_name']) ?></p></div><span class="mpj-status <?= h($sk) ?>"><span></span><?= h($sl) ?></span></div>
                <div class="mpj-job-meta"><span><i class="fa-solid fa-location-dot"></i><?= h($loc) ?></span><span><i class="fa-regular fa-calendar"></i>Posted <?= h(date('d M Y', strtotime($j['created_at']))) ?></span><?php if (!empty($j['closing_date'])): ?><span><i class="fa-regular fa-calendar-xmark"></i>Closes <?= h(date('d M Y', strtotime($j['closing_date']))) ?></span><?php endif; ?><span><i class="fa-solid fa-user-plus"></i><?= (int)$j['openings'] ?> opening<?= (int)$j['openings'] === 1 ? '' : 's' ?></span></div>
                <div class="mpj-application-stats"><div><span class="mpj-mini-icon blue"><i class="fa-solid fa-users"></i></span><span><small>In-app Applications</small><strong><?= (int)($c['in_app'] ?? 0) ?></strong></span></div><div><span class="mpj-mini-icon green"><i class="fa-brands fa-whatsapp"></i></span><span><small>WhatsApp Enquiries</small><strong><?= (int)($c['whatsapp'] ?? 0) ?></strong></span></div><div><span class="mpj-mini-icon orange"><i class="fa-regular fa-envelope"></i></span><span><small>Email Applications</small><strong><?= (int)($c['email'] ?? 0) ?></strong></span></div></div>
                <div class="mpj-card-actions">
                    <a class="mpj-btn small outline" href="job-details.php?id=<?= (int)$j['id'] ?>"><i class="fa-regular fa-eye"></i> View</a>
                    <a class="mpj-btn small primary" href="job-applicants.php?job=<?= (int)$j['id'] ?>"><i class="fa-solid fa-users"></i> Applicants (<?= array_sum($c) ?>)</a>
                    <?php if ($sk !== 'closed'): ?><a class="mpj-btn small outline" href="post-a-job.php?edit=<?= (int)$j['id'] ?>"><i class="fa-regular fa-pen-to-square"></i> Edit</a><?php endif; ?>
                    <?php if (in_array($sk, ['active', 'expired', 'closed'], true)): ?>
                    <form method="post" data-confirm="<?= $sk === 'active' ? 'Extend the closing date of this job?' : 'Renew this job?' ?>"><?= web_csrf_field() ?><input type="hidden" name="do" value="renew"><input type="hidden" name="id" value="<?= (int)$j['id'] ?>"><button class="mpj-btn small package" type="submit"><i class="fa-solid fa-rotate"></i> <?= $sk === 'active' ? 'Extend' : 'Renew' ?></button></form>
                    <?php endif; ?>
                    <?php if ($sk === 'active' || $sk === 'pending'): ?>
                    <form method="post" data-confirm="Close this job? It will stop accepting applications."><?= web_csrf_field() ?><input type="hidden" name="do" value="close"><input type="hidden" name="id" value="<?= (int)$j['id'] ?>"><button class="mpj-btn small soft" type="submit"><i class="fa-solid fa-lock"></i> Close Job</button></form>
                    <?php endif; ?>
                    <form method="post" data-confirm="Delete this job permanently?"><?= web_csrf_field() ?><input type="hidden" name="do" value="delete"><input type="hidden" name="id" value="<?= (int)$j['id'] ?>"><button class="mpj-icon-btn" type="submit" aria-label="Delete job" title="Delete job"><i class="fa-regular fa-trash-can"></i></button></form>
                </div>
            </article>
        <?php endforeach; ?>
        </div>
    </div>
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
<?= web_js_boot() ?><script src="my-posted-jobs.js?v=2"></script>
<script src="js/jobs-global.js"></script>
</body>
</html>
