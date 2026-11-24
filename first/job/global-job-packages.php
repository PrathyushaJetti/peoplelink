<?php
// Global Job Packages (live: jobs_packages / jobs_active_package backend actions)
require_once dirname(__DIR__) . '/_web.php';
$gjpPackages = web_call('jobs_packages')['packages'] ?? [];
$gjpActive = $webUser ? web_call('jobs_active_package') : ['active' => false, 'packages' => []];
$gjpCur = ($gjpActive['packages'] ?? [])[0] ?? null;
$gjpIcons = [['basic', 'fa-briefcase', 'START HIRING'], ['premium', 'fa-crown', 'GROW YOUR TEAM'], ['featured', 'fa-rocket', 'MAXIMUM REACH']];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PeopleLink Global Job Packages — Choose a global job posting package to reach candidates across all PeopleLink communities.">

    <title>Global Job Packages | PeopleLink</title>

    <!-- ICONS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- PEOPLELINK CSS -->
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">

    <!-- PAGE 44 CSS -->
    <link rel="stylesheet" href="global-job-packages.css">
</head>

<body>

<!-- =====================================================
     PEOPLELINK HEADER
====================================================== -->

<header class="pl-header" id="peoplelinkHeader">

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
                <a href="#help">Help &amp; Support</a>
                <a href="#contact">Contact Us</a>
            </div>

        </div>
    </div>

    <div class="pl-navbar">
        <div class="pl-container">

            <a href="index.php" class="pl-logo"
               aria-label="PeopleLink Home">
                <img src="images/logo.jpeg"
                     alt="PeopleLink"
                     class="pl-logo-image">
            </a>

            <button type="button"
                    class="pl-mobile-toggle"
                    id="plMobileToggle"
                    aria-label="Open navigation"
                    aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav class="pl-main-nav"
                 id="plMainNav"
                 aria-label="Main Navigation">

                <a href="index.php" class="pl-nav-link">Home</a>

                <div class="pl-nav-dropdown">

                    <button type="button"
                            class="pl-nav-dropdown-btn">
                        Communities
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>

                    <div class="pl-dropdown-menu">

                        <div class="pl-dropdown-title">
                            <strong>OUR COMMUNITIES</strong>
                            <span>Choose your community</span>
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

                        <a href="#communityList" class="pl-dropdown-all">
                            View All Communities
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                    </div>
                </div>

                <a href="service.php" class="pl-nav-link">Services</a>
                <a href="about.php" class="pl-nav-link">About Us</a>
                <a href="#events" class="pl-nav-link">Events</a>
                <a href="#contact" class="pl-nav-link">Contact</a>

                <div class="pl-mobile-actions">

                    <a href="#communityList"
                       class="pl-mobile-community">
                        <i class="fa-solid fa-users"></i>
                        Select Your Community
                    </a>

                    <a href="#downloadApp"
                       class="pl-mobile-download">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                        Download App
                    </a>

                </div>

            </nav>

            <div class="pl-header-actions">

                <a href="#login" class="pl-login">
                    <i class="fa-regular fa-user"></i>
                    Login
                </a>

                <a href="#communityList"
                   class="pl-community-button">
                    <i class="fa-solid fa-users"></i>
                    Select Community
                </a>

                <a href="#downloadApp"
                   class="pl-download-button">
                    <i class="fa-solid fa-mobile-screen-button"></i>
                    Download App
                </a>

            </div>

        </div>
    </div>
</header>


<!-- =====================================================
     PAGE 44: GLOBAL JOB PACKAGES
====================================================== -->

<main class="gjp-page">

    <!-- HERO -->
    <section class="gjp-hero">
        <div class="gjp-container gjp-hero-inner">

            <div class="gjp-hero-content">

                <span class="gjp-eyebrow">
                    <i class="fa-solid fa-earth-asia"></i>
                    PEOPLELINK GLOBAL CAREERS
                </span>

                <h1>Global Job Packages</h1>

                <p>
                    Expand your hiring reach across all PeopleLink
                    communities. Choose the right package, publish
                    global job opportunities and connect with talent
                    across our network.
                </p>

                <a href="#availablePackages" class="gjp-btn primary">
                    <i class="fa-solid fa-layer-group"></i>
                    Explore Packages
                </a>

            </div>

            <div class="gjp-hero-art" aria-hidden="true">
                <div class="gjp-hero-circle">
                    <i class="fa-solid fa-earth-asia"></i>
                </div>

                <span class="gjp-hero-floating one">
                    <i class="fa-solid fa-briefcase"></i>
                </span>

                <span class="gjp-hero-floating two">
                    <i class="fa-solid fa-users"></i>
                </span>

                <span class="gjp-hero-floating three">
                    <i class="fa-solid fa-bullhorn"></i>
                </span>
            </div>

        </div>
    </section>


    <!-- MAIN CONTENT -->
    <div class="gjp-container gjp-content">

        <!-- PAGE INTRODUCTION -->
        <section class="gjp-heading-row">

            <div>
                <span class="gjp-kicker">GLOBAL HIRING DASHBOARD</span>

                <h2>Find the Right Package for Your Business</h2>

                <p>
                    Publish jobs across PeopleLink communities with
                    flexible job posting limits, validity periods
                    and visibility options.
                </p>
            </div>

        </section>


        <!-- BENEFITS -->
        <section class="gjp-benefits"
                 aria-label="Global package benefits">

            <article class="gjp-benefit">

                <span class="gjp-benefit-icon blue">
                    <i class="fa-solid fa-users"></i>
                </span>

                <div>
                    <h3>All Communities</h3>
                    <p>
                        Reach candidates across the PeopleLink network.
                    </p>
                </div>

            </article>

            <article class="gjp-benefit">

                <span class="gjp-benefit-icon purple">
                    <i class="fa-solid fa-bullhorn"></i>
                </span>

                <div>
                    <h3>Enhanced Visibility</h3>
                    <p>
                        Access featured placement with eligible packages.
                    </p>
                </div>

            </article>

            <article class="gjp-benefit">

                <span class="gjp-benefit-icon green">
                    <i class="fa-solid fa-chart-line"></i>
                </span>

                <div>
                    <h3>Track Job Posts</h3>
                    <p>
                        Monitor your posting usage and package validity.
                    </p>
                </div>

            </article>

        </section>


        <!-- CURRENT PACKAGE -->
        <section class="gjp-current-section">

            <div class="gjp-section-heading">

                <div>
                    <span class="gjp-kicker">YOUR SUBSCRIPTION</span>
                    <h2>Current Package</h2>
                    <p>
                        Review your existing global posting package.
                    </p>
                </div>

                <span class="gjp-active-badge"<?= $gjpCur ? '' : ' hidden' ?>>
                    <i class="fa-solid fa-circle-check"></i>
                    Active Package
                </span>

            </div>


            <?php if ($gjpCur): $tot = (int)($gjpCur['job_posts'] ?? 0); $used = (int)($gjpCur['posts_used'] ?? 0); $pct = $tot ? (int)round($used * 100 / $tot) : 0; ?>
            <article class="gjp-current-card" id="gjpCurrentPackage">
                <div class="gjp-current-top"><div class="gjp-current-icon"><i class="fa-solid fa-crown"></i></div><div class="gjp-current-title"><span class="gjp-kicker">CURRENTLY SUBSCRIBED</span><h3 id="gjpCurrentName"><?= h($gjpCur['name'] ?? $gjpCur['package_name'] ?? 'Global Job Package') ?></h3><p>Global job posting subscription</p></div></div>
                <div class="gjp-current-details">
                    <div class="gjp-detail-item"><span>Purchase Date</span><strong id="gjpPurchaseDate"><?= h(!empty($gjpCur['starts_at']) ? date('d M Y', strtotime($gjpCur['starts_at'])) : '—') ?></strong></div>
                    <div class="gjp-detail-item"><span>Expiry Date</span><strong id="gjpExpiryDate"><?= h(!empty($gjpCur['expires_at']) ? date('d M Y', strtotime($gjpCur['expires_at'])) : '—') ?></strong></div>
                    <div class="gjp-detail-item"><span>Total Job Posts</span><strong id="gjpTotalPosts"><?= $tot ?></strong></div>
                    <div class="gjp-detail-item"><span>Job Posts Used</span><strong id="gjpUsedPosts"><?= $used ?></strong></div>
                    <div class="gjp-detail-item"><span>Job Posts Remaining</span><strong id="gjpRemainingPosts"><?= (int)($gjpActive['remaining_global_posts'] ?? max(0, $tot - $used)) ?></strong></div>
                </div>
                <div class="gjp-usage"><div class="gjp-usage-heading"><span>Package Usage</span><strong id="gjpUsagePercentage"><?= $pct ?>% used</strong></div><div class="gjp-progress-track" id="gjpProgressTrack" role="progressbar" aria-label="Global job posts used" aria-valuemin="0" aria-valuemax="<?= $tot ?>" aria-valuenow="<?= $used ?>"><span class="gjp-progress-fill" id="gjpProgressFill" style="width: <?= $pct ?>%;"></span></div></div>
                <div class="gjp-current-actions"><a href="post-a-job.php" class="gjp-btn primary"><i class="fa-solid fa-plus"></i> Post a Global Job</a><a href="#availablePackages" class="gjp-btn soft"><i class="fa-solid fa-arrow-up"></i> Buy More Posts</a></div>
            </article>
            <?php else: ?>
            <article class="gjp-current-card" id="gjpCurrentPackage">
                <div class="gjp-current-top"><div class="gjp-current-icon"><i class="fa-regular fa-circle"></i></div><div class="gjp-current-title"><span class="gjp-kicker">NO ACTIVE PACKAGE</span><h3 id="gjpCurrentName"><?= $webUser ? 'You do not have an active Global Job Package' : 'Login to see your Global Job Package' ?></h3><p>Community jobs are free. A package is needed only to post jobs visible across all PeopleLink communities.</p></div></div>
                <div class="gjp-current-actions"><?php if (!$webUser): ?><a href="<?= h(DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '')) ?>" class="gjp-btn primary">Login</a><?php endif; ?><a href="#availablePackages" class="gjp-btn soft"><i class="fa-solid fa-arrow-down"></i> See Packages</a></div>
            </article>
            <?php endif; ?>

        </section>


        <!-- AVAILABLE PACKAGES -->
        <section class="gjp-packages-section"
                 id="availablePackages">

            <div class="gjp-section-heading">

                <div>
                    <span class="gjp-kicker">FLEXIBLE HIRING PLANS</span>

                    <h2>Available Global Packages</h2>

                    <p>
                        Compare posting limits, validity and visibility
                        before selecting your package.
                    </p>
                </div>

            </div>


            <div class="gjp-package-grid">

                <?php foreach ($gjpPackages as $i => $p): [$cls, $icon, $label] = $gjpIcons[min($i, 2)]; $rec = !empty($p['featured_listing']) && $i === 1; ?>
                <article class="gjp-package-card<?= $rec ? ' recommended' : '' ?>">
                    <?php if ($rec): ?><span class="gjp-popular-badge"><i class="fa-solid fa-star"></i> MOST POPULAR</span><?php endif; ?>
                    <div class="gjp-package-icon <?= $cls ?>"><i class="fa-solid <?= $icon ?>"></i></div>
                    <span class="gjp-package-label"><?= $label ?></span>
                    <h3><?= h($p['name']) ?></h3>
                    <p class="gjp-package-description"><?= h($p['description']) ?></p>
                    <div class="gjp-price"><strong>₹<?= number_format((float)$p['price']) ?></strong><span>/ package</span></div>
                    <p class="gjp-price-note">Includes GST where applicable.</p>
                    <div class="gjp-package-divider"></div>
                    <ul class="gjp-feature-list">
                        <li><i class="fa-solid fa-check"></i><span><strong><?= (int)$p['job_posts'] ?></strong> global job posts</span></li>
                        <li><i class="fa-solid fa-check"></i><span><?= (int)$p['validity_days'] ?>-day validity</span></li>
                        <?php if (!empty($p['featured_listing'])): ?><li><i class="fa-solid fa-check"></i><span>Featured listing</span></li><?php endif; ?>
                        <?php if (!empty($p['priority_visibility'])): ?><li><i class="fa-solid fa-check"></i><span>Priority visibility in search</span></li><?php endif; ?>
                        <li><i class="fa-solid fa-check"></i><span>Application tracking</span></li>
                        <?php foreach ((array)($p['features'] ?? []) as $ft): ?><li><i class="fa-solid fa-check"></i><span><?= h($ft) ?></span></li><?php endforeach; ?>
                    </ul>
                    <a href="global-job-package-details.php?package=<?= (int)$p['id'] ?>" class="gjp-btn <?= $rec ? 'primary' : 'outline' ?> gjp-btn-full">Choose <?= h(trim(str_replace(['Global Package', 'Package'], '', $p['name'])) ?: 'Package') ?> <i class="fa-solid fa-arrow-right"></i></a>
                </article>
                <?php endforeach; ?>
                <?php if (!$gjpPackages): ?><p>No Global Job Packages are available right now.</p><?php endif; ?>

            </div>

        </section>


        <!-- HOW IT WORKS -->
        <section class="gjp-how-section">

            <div class="gjp-section-heading">
                <div>
                    <span class="gjp-kicker">THREE SIMPLE STEPS</span>
                    <h2>How Global Packages Work</h2>
                </div>
            </div>

            <div class="gjp-how-grid">

                <article class="gjp-how-card">
                    <span class="gjp-step-number">01</span>

                    <div class="gjp-how-icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>

                    <h3>Choose a Package</h3>

                    <p>
                        Select a package that matches your
                        hiring volume and visibility needs.
                    </p>
                </article>

                <article class="gjp-how-card">
                    <span class="gjp-step-number">02</span>

                    <div class="gjp-how-icon">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>

                    <h3>Complete Purchase</h3>

                    <p>
                        Review your selected package and
                        continue to the purchase page.
                    </p>
                </article>

                <article class="gjp-how-card">
                    <span class="gjp-step-number">03</span>

                    <div class="gjp-how-icon">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>

                    <h3>Post Global Jobs</h3>

                    <p>
                        Use your available job posts to reach
                        candidates across PeopleLink communities.
                    </p>
                </article>

            </div>

        </section>


        <!-- COMMUNITY JOB NOTICE -->
        <section class="gjp-info-note">

            <span class="gjp-info-icon">
                <i class="fa-solid fa-circle-info"></i>
            </span>

            <p>
                <strong>Important information</strong>

                Global Job Packages are intended for employers
                who want to post jobs across all PeopleLink communities.
                Community-specific job postings can follow a separate
                process and do not require a global package unless
                otherwise configured.
            </p>

        </section>


        <!-- SUPPORT CTA -->
        <section class="gjp-support-section" id="help">

            <div class="gjp-support-icon">
                <i class="fa-solid fa-headset"></i>
            </div>

            <div class="gjp-support-content">
                <h2>Need Help Choosing a Package?</h2>

                <p>
                    Contact our support team for assistance with
                    global hiring packages, renewals and upgrades.
                </p>
            </div>

            <a href="#contact" class="gjp-btn outline">
                <i class="fa-solid fa-envelope"></i>
                Contact Support
            </a>

        </section>

    </div>

</main>


<!-- =====================================================
     PEOPLELINK FOOTER
====================================================== -->

<div class="pl-footer-main">

    <div class="pl-footer-container">

        <div class="pl-footer-grid">

            <!-- BRAND -->
            <div class="pl-footer-brand">

                <a href="index.php" class="pl-footer-logo">
                    <img src="images/logo.jpeg" alt="PeopleLink">
                </a>

                <p>
                    PeopleLink brings communities together,
                    helping people connect with family,
                    discover opportunities, build relationships
                    and access trusted services.
                </p>

                <div class="pl-footer-social">

                    <a href="#" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>

                    <a href="#" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>

                    <a href="#" aria-label="LinkedIn">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>

                    <a href="#" aria-label="YouTube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>

                    <a href="#" aria-label="X">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>

                </div>

            </div>


            <!-- PEOPLELINK -->
            <div class="pl-footer-column">

                <h3>PeopleLink</h3>

                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="#communityList">Our Communities</a></li>
                    <li><a href="service.php">Our Services</a></li>
                    <li><a href="#events">Events</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                </ul>

            </div>


            <!-- COMMUNITY -->
            <div class="pl-footer-column">

                <h3>Community</h3>

                <ul>
                    <li>
                        <a href="#communityList">
                            Matrimony &amp; Relationships
                        </a>
                    </li>

                    <li>
                        <a href="#platformServices">
                            Family &amp; Community
                        </a>
                    </li>

                    <li>
                        <a href="jobs-home.php">Jobs &amp; Career</a>
                    </li>

                    <li>
                        <a href="#platformServices">
                            Professionals &amp; Businesses
                        </a>
                    </li>

                    <li>
                        <a href="#platformServices">Marketplace</a>
                    </li>

                    <li>
                        <a href="#events">Community Events</a>
                    </li>
                </ul>

            </div>


            <!-- SUPPORT -->
            <div class="pl-footer-column" id="contact">

                <h3>Support</h3>

                <ul>
                    <li><a href="#help">Help Center</a></li>
                    <li><a href="#contact">Contact Support</a></li>
                    <li><a href="#faq">FAQs</a></li>
                    <li><a href="#privacy">Privacy Policy</a></li>
                    <li><a href="#terms">Terms &amp; Conditions</a></li>
                    <li><a href="#safety">Community Guidelines</a></li>
                </ul>

            </div>


            <!-- CONTACT -->
            <div class="pl-footer-contact">

                <h3>Get In Touch</h3>

                <a href="#contact" class="pl-contact-item">

                    <div class="pl-contact-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <div>
                        <span>Location</span>
                        <strong>India</strong>
                    </div>

                </a>

                <a href="mailto:info@peoplelink.com"
                   class="pl-contact-item">

                    <div class="pl-contact-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div>
                        <span>Email</span>
                        <strong>info@peoplelink.com</strong>
                    </div>

                </a>

                <a href="tel:+910000000000"
                   class="pl-contact-item">

                    <div class="pl-contact-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>

                    <div>
                        <span>Phone</span>
                        <strong>+91 00000 00000</strong>
                    </div>

                </a>

            </div>

        </div>

    </div>

</div>


<!-- COMMUNITY STRIP -->
<div class="pl-footer-community-strip">

    <div class="pl-footer-container">

        <div class="pl-community-strip-content">

            <div class="pl-strip-icon">
                <i class="fa-solid fa-people-group"></i>
            </div>

            <div>
                <strong>One Platform. Many Communities.</strong>

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


<!-- FOOTER BOTTOM -->
<div class="pl-footer-bottom">

    <div class="pl-footer-container">

        <div class="pl-copyright">
            &copy;
            <span id="plCopyrightYear"></span>
            PeopleLink Technologies Private Limited.
            All Rights Reserved.
        </div>

        <div class="pl-footer-bottom-links">
            <a href="#privacy">Privacy</a>
            <a href="#terms">Terms</a>
            <a href="#cookies">Cookies</a>
        </div>

        <div class="pl-back-top">
            <button type="button"
                    id="plBackToTop"
                    aria-label="Back to top">
                <i class="fa-solid fa-arrow-up"></i>
            </button>
        </div>

    </div>

</div>


<!-- =====================================================
     JAVASCRIPT
====================================================== -->

<script src="header.js"></script>
<?= web_js_boot() ?><script src="global-job-packages.js?v=2"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // Copyright year
    const year = document.getElementById("plCopyrightYear");

    if (year) {
        year.textContent = new Date().getFullYear();
    }

    // Back to top
    const backToTop = document.getElementById("plBackToTop");

    if (backToTop) {
        backToTop.addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    }

    // Current package usage
    const totalElement = document.getElementById("gjpTotalPosts");
    const usedElement = document.getElementById("gjpUsedPosts");
    const remainingElement = document.getElementById("gjpRemainingPosts");
    const percentageElement = document.getElementById("gjpUsagePercentage");
    const progressFill = document.getElementById("gjpProgressFill");
    const progressTrack = document.getElementById("gjpProgressTrack");

    if (
        totalElement &&
        usedElement &&
        remainingElement &&
        percentageElement &&
        progressFill &&
        progressTrack
    ) {
        const total = Math.max(0, Number(totalElement.textContent) || 0);
        const used = Math.min(
            total,
            Math.max(0, Number(usedElement.textContent) || 0)
        );

        const remaining = Math.max(0, total - used);
        const percentage = total > 0
            ? Math.round((used / total) * 100)
            : 0;

        remainingElement.textContent = remaining;
        percentageElement.textContent = percentage + "% used";
        progressFill.style.width = percentage + "%";

        progressTrack.setAttribute("aria-valuemax", total);
        progressTrack.setAttribute("aria-valuenow", used);
        progressTrack.setAttribute(
            "aria-valuetext",
            used + " of " + total + " job posts used"
        );
    }

});
</script>

<script src="js/jobs-global.js"></script>
</body>
</html>