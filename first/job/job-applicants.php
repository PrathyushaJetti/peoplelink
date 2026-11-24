<?php
// Job Applicants – the employer's view of applications received for their jobs
// (live: jobs_applications, jobs_application_update_status, jobs_resume_download backend actions)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();

$jobId = (int)($_GET['job'] ?? 0);
$back = 'job-applicants.php' . ($jobId ? '?job=' . $jobId : '');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['do'] ?? '') === 'status') web_post('jobs_application_update_status', $back . (isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : ''));

$myJobs = rows('SELECT id, job_title, company_name FROM jobs WHERE user_id=? ORDER BY id DESC', [$webUid]);
$_REQUEST['per'] = 50; $_REQUEST['page'] = 1;
$params = ['per' => 50, 'q' => trim((string)($_GET['q'] ?? ''))] + ($jobId ? ['job_id' => $jobId] : []) + (!empty($_GET['status']) ? ['status' => $_GET['status']] : []);
$res = web_call('jobs_received_applications', $params);
if (!empty($res['error'])) { flash($res['error'], 'error'); header('Location: my-posted-jobs.php'); exit; }
$apps = $res['items'] ?? [];
$counts = $res['counts'] ?? [];
$curJob = null; foreach ($myJobs as $j) if ((int)$j['id'] === $jobId) $curJob = $j;
$stClass = ['applied' => 'pending', 'viewed' => 'draft', 'shortlisted' => 'active', 'rejected' => 'rejected', 'closed' => 'closed'];
$methodLabel = ['in_app' => 'PeopleLink', 'email' => 'Email', 'whatsapp' => 'WhatsApp'];
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

 
    <title>Job Applicants | PeopleLink</title>


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
    <section class="mpj-hero"><div class="mpj-container mpj-hero-inner"><div><span class="mpj-eyebrow"><i class="fa-solid fa-users"></i> EMPLOYER WORKSPACE</span><h1>Job Applicants</h1><p><?= $curJob ? 'Applications for ' . h($curJob['job_title']) . ' at ' . h($curJob['company_name']) . '.' : 'Every application received for your job posts.' ?></p></div><div class="mpj-hero-art"><span class="mpj-art-icon"><i class="fa-solid fa-user-check"></i></span><span class="mpj-art-mini"><i class="fa-solid fa-file-lines"></i></span></div></div></section>
    <?= web_flash_html() ?>
    <div class="mpj-container mpj-content">
        <div class="mpj-heading-row"><div><span class="mpj-kicker">APPLICATIONS RECEIVED</span><h2><?= $curJob ? h($curJob['job_title']) : 'All your jobs' ?></h2><p>Open resumes and move candidates forward. Applicants are notified when you change their status.</p></div><a class="mpj-btn primary" href="my-posted-jobs.php"><i class="fa-solid fa-arrow-left"></i> My Posted Jobs</a></div>
        <section class="mpj-stats" aria-label="Application summary">
            <div class="mpj-stat"><span class="mpj-stat-icon blue"><i class="fa-solid fa-inbox"></i></span><div><small>New</small><strong><?= (int)($counts['applied'] ?? 0) ?></strong></div></div>
            <div class="mpj-stat"><span class="mpj-stat-icon purple"><i class="fa-regular fa-eye"></i></span><div><small>Viewed</small><strong><?= (int)($counts['viewed'] ?? 0) ?></strong></div></div>
            <div class="mpj-stat"><span class="mpj-stat-icon green"><i class="fa-solid fa-star"></i></span><div><small>Shortlisted</small><strong><?= (int)($counts['shortlisted'] ?? 0) ?></strong></div></div>
            <div class="mpj-stat"><span class="mpj-stat-icon amber"><i class="fa-solid fa-xmark"></i></span><div><small>Rejected</small><strong><?= (int)($counts['rejected'] ?? 0) ?></strong></div></div>
        </section>
        <form class="mpj-filters" method="get" action="job-applicants.php">
            <select name="job" aria-label="Job"><option value="0">All my jobs</option><?php foreach ($myJobs as $j): ?><option value="<?= (int)$j['id'] ?>" <?= (int)$j['id'] === $jobId ? 'selected' : '' ?>><?= h($j['job_title']) ?> — <?= h($j['company_name']) ?></option><?php endforeach; ?></select>
            <label class="mpj-search"><i class="fa-solid fa-magnifying-glass"></i><input type="search" name="q" value="<?= h($_GET['q'] ?? '') ?>" placeholder="Search name, email or phone" aria-label="Search applicants"></label>
            <select name="status" aria-label="Status"><option value="">All statuses</option><?php foreach (PL_JOB_APP_STATUSES as $s): ?><option value="<?= h($s) ?>" <?= ($_GET['status'] ?? '') === $s ? 'selected' : '' ?>><?= h(ucfirst($s === 'applied' ? 'new' : $s)) ?></option><?php endforeach; ?></select>
            <button class="mpj-btn filter-btn" type="submit"><i class="fa-solid fa-sliders"></i> Filter</button>
            <a class="mpj-reset" href="job-applicants.php<?= $jobId ? '?job=' . $jobId : '' ?>">Reset</a>
        </form>
        <div class="mpj-results-line"><strong><?= count($apps) ?> applicant<?= count($apps) === 1 ? '' : 's' ?></strong><span>Newest first</span></div>
        <div class="mpj-job-list">
        <?php if (!$apps): ?><div class="mpj-demo-note"><i class="fa-solid fa-circle-info"></i><p>No applications <?= ($params['q'] || !empty($params['status'])) ? 'match these filters' : 'yet' ?>.</p></div><?php endif; ?>
        <?php foreach ($apps as $a): $st = (string)$a['status']; ?>
            <article class="mpj-job-card">
                <div class="mpj-job-top"><div class="mpj-company-mark"><i class="fa-solid fa-user"></i></div><div class="mpj-job-title-wrap"><div class="mpj-badges"><span class="mpj-type-badge"><?= h($a['application_code']) ?></span><span class="mpj-community-badge"><i class="fa-solid fa-briefcase"></i> <?= h($a['job_title']) ?></span></div><h3><?= h($a['applicant_name']) ?></h3><p class="mpj-company-name">Applied <?= h(date('d M Y, h:i A', strtotime($a['applied_at']))) ?> · via <?= h($methodLabel[$a['apply_method']] ?? $a['apply_method']) ?></p></div><span class="mpj-status <?= h($stClass[$st] ?? 'draft') ?>"><span></span><?= h($st === 'applied' ? 'New' : ucfirst($st)) ?></span></div>
                <div class="mpj-job-meta">
                    <?php if ($a['email']): ?><span><i class="fa-regular fa-envelope"></i><a href="mailto:<?= h($a['email']) ?>"><?= h($a['email']) ?></a></span><?php endif; ?>
                    <?php if ($a['phone']): ?><span><i class="fa-solid fa-phone"></i><a href="tel:<?= h($a['phone']) ?>"><?= h($a['phone']) ?></a></span><?php endif; ?>
                    <?php if ($a['total_experience']): ?><span><i class="fa-solid fa-briefcase"></i><?= h($a['total_experience']) ?></span><?php endif; ?>
                    <?php if ($a['current_location']): ?><span><i class="fa-solid fa-location-dot"></i><?= h($a['current_location']) ?></span><?php endif; ?>
                </div>
                <?php if (trim((string)$a['cover_letter']) !== ''): ?><p style="margin:12px 0 0;white-space:pre-line;color:#475569"><?= h($a['cover_letter']) ?></p><?php endif; ?>
                <div class="mpj-card-actions">
                    <?php if (!empty($a['has_resume'])): ?><a class="mpj-btn small outline" href="<?= h(DASHBOARD_URL . 'api.php?action=jobs_resume_download&application_id=' . (int)$a['id']) ?>"><i class="fa-solid fa-download"></i> Resume<?= $a['resume_name'] ? ' (' . h($a['resume_name']) . ')' : '' ?></a><?php else: ?><span class="mpj-btn small outline" aria-disabled="true">No resume attached</span><?php endif; ?>
                    <?php foreach (['shortlisted' => ['fa-star', 'Shortlist', 'package'], 'rejected' => ['fa-xmark', 'Reject', 'soft'], 'viewed' => ['fa-eye', 'Mark viewed', 'outline']] as $to => [$ic, $lbl, $cls]): if ($to === $st || ($to === 'viewed' && $st !== 'applied')) continue; ?>
                    <form method="post"<?= $to === 'rejected' ? ' data-confirm="Reject this applicant? They will be notified."' : '' ?>><?= web_csrf_field() ?><input type="hidden" name="do" value="status"><input type="hidden" name="id" value="<?= (int)$a['id'] ?>"><input type="hidden" name="status" value="<?= $to ?>"><button class="mpj-btn small <?= $cls ?>" type="submit"><i class="fa-solid <?= $ic ?>"></i> <?= $lbl ?></button></form>
                    <?php endforeach; ?>
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