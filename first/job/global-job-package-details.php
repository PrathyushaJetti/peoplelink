<?php
// Global Job Package Details + checkout (live: package from jobs_package_details, Razorpay order from jobs_package_purchase)
require_once dirname(__DIR__) . '/_web.php';
$p45Id = (int)($_GET['package'] ?? 0);
$p45All = web_call('jobs_packages')['packages'] ?? [];
$p45Pkg = null;
foreach ($p45All as $p) if ((int)$p['id'] === $p45Id) $p45Pkg = $p;
if (!$p45Pkg && $p45All) $p45Pkg = $p45All[min(1, count($p45All) - 1)];
if (!$p45Pkg) { flash('No Global Job Packages are available right now.', 'error'); header('Location: global-job-packages.php'); exit; }
$p45Icons = ['fa-briefcase', 'fa-crown', 'fa-bullhorn'];
$p45Index = array_search($p45Pkg, $p45All, true);
$p45Benefits = array_values(array_filter(array_merge(['Post jobs across all PeopleLink communities', 'Wider candidate reach', 'Application tracking'],
    !empty($p45Pkg['featured_listing']) ? ['Featured job tag'] : [], !empty($p45Pkg['priority_visibility']) ? ['Priority placement in search'] : [], (array)($p45Pkg['features'] ?? []))));
$p45Js = ['id' => (int)$p45Pkg['id'], 'name' => $p45Pkg['name'], 'label' => ['GET STARTED', 'GROW YOUR TEAM', 'MAXIMUM EXPOSURE'][min((int)$p45Index, 2)],
    'description' => $p45Pkg['description'], 'price' => (float)$p45Pkg['price'], 'posts' => (int)$p45Pkg['job_posts'], 'validity' => (int)$p45Pkg['validity_days'],
    'icon' => $p45Icons[min((int)$p45Index, 2)], 'benefits' => $p45Benefits];
$p45Cur = null;
if ($webUser) {
    $act = web_call('jobs_active_package');
    if (!empty($act['packages'][0])) { $c = $act['packages'][0];
        $p45Cur = ['name' => $c['name'], 'used' => (int)($c['posts_used'] ?? 0), 'total' => (int)($c['job_posts'] ?? 0), 'expiry' => date('d M Y', strtotime($c['expires_at']))]; }
}
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
    <link rel="stylesheet" href="global-job-package-details.css">
</head>

<body>

<!-- =====================================================
     PEOPLELINK HEADER
====================================================== -->

<?php include __DIR__ . '/../_site_header.php'; ?>


<body>


<main class="p45-page">

    <!-- HERO -->
    <section class="p45-hero">
        <div class="p45-container">
            <span class="p45-eyebrow">
                <i class="fa-solid fa-earth-asia"></i>
                PEOPLELINK GLOBAL CAREERS
            </span>

            <h1>Global Job Package Details</h1>

            <p>
                Review your package, confirm your employer details
                and securely continue to checkout.
            </p>

            <div class="p45-steps">
                <span class="active">
                    <i class="fa-solid fa-circle-check"></i>
                    Package Details
                </span>
                <span class="step-line"></span>
                <span>
                    <i class="fa-regular fa-credit-card"></i>
                    Payment
                </span>
                <span class="step-line"></span>
                <span>
                    <i class="fa-solid fa-check"></i>
                    Confirmation
                </span>
            </div>
        </div>
    </section>

    <div class="p45-container p45-main-grid">

        <!-- LEFT COLUMN -->
        <div class="p45-left-column">

            <!-- PACKAGE INFORMATION -->
            <section class="p45-card">
                <div class="p45-card-heading">
                    <div class="p45-heading-icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <span class="p45-kicker">YOUR SELECTION</span>
                        <h2>Package Information</h2>
                    </div>
                </div>

                <div class="p45-selected-package">
                    <div class="p45-package-top">
                        <div>
                            <span class="p45-package-label" id="p45PackageLabel">
                                GROW YOUR TEAM
                            </span>
                            <h3 id="p45PackageName">
                                Premium Global Package
                            </h3>
                            <p id="p45PackageDescription">
                                A flexible plan for businesses hiring
                                across multiple communities.
                            </p>
                        </div>

                        <div class="p45-package-icon" id="p45PackageIcon">
                            <i class="fa-solid fa-crown"></i>
                        </div>
                    </div>

                    <div class="p45-price-display">
                        <strong id="p45PackagePrice">₹2,999</strong>
                        <span>/ package</span>
                    </div>

                    <p class="p45-price-note">
                        Final charges are displayed before payment.
                    </p>
                </div>

                <div class="p45-package-stats">
                    <div class="p45-stat">
                        <i class="fa-solid fa-briefcase"></i>
                        <span>Global Job Posts</span>
                        <strong id="p45PackagePosts">25</strong>
                    </div>

                    <div class="p45-stat">
                        <i class="fa-regular fa-calendar"></i>
                        <span>Package Validity</span>
                        <strong id="p45PackageValidity">90 days</strong>
                    </div>

                    <div class="p45-stat">
                        <i class="fa-solid fa-earth-asia"></i>
                        <span>Job Reach</span>
                        <strong>All Communities</strong>
                    </div>
                </div>

                <div class="p45-featured-benefits">
                    <h3>Package Benefits</h3>

                    <ul id="p45Benefits">
                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            Post jobs across all PeopleLink communities
                        </li>
                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            Wider candidate reach
                        </li>
                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            Global job visibility
                        </li>
                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            Enhanced visibility
                        </li>
                        <li>
                            <i class="fa-solid fa-circle-check"></i>
                            Application tracking
                        </li>
                    </ul>
                </div>
            </section>

            <!-- CURRENT USAGE -->
            <section class="p45-card" id="p45CurrentUsage">
                <div class="p45-card-heading">
                    <div class="p45-heading-icon green">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div>
                        <span class="p45-kicker">EXISTING SUBSCRIPTION</span>
                        <h2>Current Package Usage</h2>
                    </div>
                </div>

                <div class="p45-usage-banner">
                    <div>
                        <span>Current Package</span>
                        <strong id="p45CurrentName">
                            Premium Global Package
                        </strong>
                    </div>
                    <span class="p45-status">
                        <i class="fa-solid fa-circle"></i>
                        Active
                    </span>
                </div>

                <div class="p45-usage-grid">
                    <div>
                        <span>Posts Used</span>
                        <strong id="p45Used">8</strong>
                    </div>
                    <div>
                        <span>Posts Remaining</span>
                        <strong id="p45Remaining">17</strong>
                    </div>
                    <div>
                        <span>Expiry Date</span>
                        <strong id="p45Expiry">31 Dec 2026</strong>
                    </div>
                </div>

                <p class="p45-usage-note">
                    Your existing package information is shown for reference.
                    A new purchase or upgrade is subject to your account's
                    package and billing rules.
                </p>
            </section>

            <!-- EMPLOYER INFORMATION -->
            <section class="p45-card">
                <div class="p45-card-heading">
                    <div class="p45-heading-icon purple">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div>
                        <span class="p45-kicker">BILLING INFORMATION</span>
                        <h2>User / Employer Details</h2>
                    </div>
                </div>

                <form id="p45CheckoutForm">

                    <div class="p45-form-grid">
                        <div class="p45-form-group">
                            <label for="p45Name">Full Name *</label>
                            <input type="text"
                                   id="p45Name"
                                   name="name"
                                   placeholder="Enter your full name"
                                   autocomplete="name"
                                   required>
                        </div>

                        <div class="p45-form-group">
                            <label for="p45Company">
                                Company / Organisation *
                            </label>
                            <input type="text"
                                   id="p45Company"
                                   name="company"
                                   placeholder="Enter company name"
                                   autocomplete="organization"
                                   required>
                        </div>

                        <div class="p45-form-group">
                            <label for="p45Mobile">Mobile Number *</label>
                            <input type="tel"
                                   id="p45Mobile"
                                   name="mobile"
                                   placeholder="10-digit mobile number"
                                   inputmode="numeric"
                                   pattern="[6-9][0-9]{9}"
                                   maxlength="10"
                                   autocomplete="tel-national"
                                   required>
                        </div>

                        <div class="p45-form-group">
                            <label for="p45Email">Email Address *</label>
                            <input type="email"
                                   id="p45Email"
                                   name="email"
                                   placeholder="you@company.com"
                                   autocomplete="email"
                                   required>
                        </div>
                    </div>

                    <p class="p45-form-note">
                        <i class="fa-solid fa-lock"></i>
                        Your billing information should be handled securely.
                    </p>

                    <!-- PAYMENT METHOD -->
                    <div class="p45-payment-heading">
                        <div class="p45-card-heading">
                            <div class="p45-heading-icon orange">
                                <i class="fa-solid fa-credit-card"></i>
                            </div>
                            <div>
                                <span class="p45-kicker">SECURE CHECKOUT</span>
                                <h2>Payment Method</h2>
                            </div>
                        </div>
                    </div>

                    <div class="p45-payment-options">

                        <label class="p45-payment-option">
                            <input type="radio"
                                   name="paymentMethod"
                                   value="upi"
                                   checked
                                   required>
                            <span class="p45-payment-symbol">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                            </span>
                            <span>UPI</span>
                        </label>

                        <label class="p45-payment-option">
                            <input type="radio"
                                   name="paymentMethod"
                                   value="debit_card">
                            <span class="p45-payment-symbol">
                                <i class="fa-regular fa-credit-card"></i>
                            </span>
                            <span>Debit Card</span>
                        </label>

                        <label class="p45-payment-option">
                            <input type="radio"
                                   name="paymentMethod"
                                   value="credit_card">
                            <span class="p45-payment-symbol">
                                <i class="fa-solid fa-credit-card"></i>
                            </span>
                            <span>Credit Card</span>
                        </label>

                        <label class="p45-payment-option">
                            <input type="radio"
                                   name="paymentMethod"
                                   value="net_banking">
                            <span class="p45-payment-symbol">
                                <i class="fa-solid fa-building-columns"></i>
                            </span>
                            <span>Net Banking</span>
                        </label>

                    </div>

                    <div class="p45-gateway-note">
                        <i class="fa-solid fa-shield-halved"></i>
                        <p>
                            Payments must be processed through your
                            configured payment gateway. Never collect
                            card PINs, CVVs or banking passwords directly
                            on this page.
                        </p>
                    </div>

                    <label class="p45-terms">
                        <input type="checkbox" id="p45Terms" required>
                        <span>
                            I have reviewed the package details and agree
                            to the applicable
                            <a href="#p45TermsInfo">Terms &amp; Conditions</a>.
                        </span>
                    </label>

                    <div class="p45-mobile-submit">
                        <button type="submit"
                                class="p45-button primary"
                                id="p45PayButton">
                            <i class="fa-solid fa-lock"></i>
                            Continue to Secure Payment
                        </button>
                    </div>

                </form>
            </section>
        </div>

        <!-- RIGHT COLUMN: PAYMENT SUMMARY -->
        <aside class="p45-right-column">

            <section class="p45-card p45-summary-card">
                <div class="p45-summary-heading">
                    <span class="p45-kicker">ORDER SUMMARY</span>
                    <h2>Payment Summary</h2>
                    <p>Review your order before continuing.</p>
                </div>

                <div class="p45-summary-package">
                    <div class="p45-summary-icon">
                        <i class="fa-solid fa-crown" id="p45SummaryIcon"></i>
                    </div>
                    <div>
                        <strong id="p45SummaryName">
                            Premium Global Package
                        </strong>
                        <span id="p45SummaryPosts">25 global job posts</span>
                    </div>
                </div>

                <div class="p45-summary-line">
                    <span>Package Amount</span>
                    <strong id="p45SummaryAmount">₹2,999.00</strong>
                </div>

                <div class="p45-summary-line">
                    <span>Applicable Charges</span>
                    <strong id="p45SummaryCharges">₹0.00</strong>
                </div>

                <div class="p45-summary-line">
                    <span>Tax</span>
                    <strong id="p45SummaryTax">₹0.00</strong>
                </div>

                <div class="p45-summary-divider"></div>

                <div class="p45-summary-total">
                    <span>Total Payable</span>
                    <strong id="p45SummaryTotal">₹2,999.00</strong>
                </div>

                <p class="p45-tax-note">
                    Taxes and other applicable charges must be calculated
                    using your actual billing configuration.
                </p>

                <button type="submit"
                        form="p45CheckoutForm"
                        class="p45-button primary p45-desktop-submit"
                        id="p45DesktopPayButton">
                    Proceed to Payment
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

                <div class="p45-secure-note">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Secure payment through the configured gateway</span>
                </div>

                <div class="p45-summary-divider"></div>

                <div class="p45-help">
                    <div class="p45-help-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <strong>Need assistance?</strong>
                        <p>Our support team can help with your purchase.</p>
                        <a href="#p45Support">Contact Support</a>
                    </div>
                </div>
            </section>

            <div class="p45-trust-card">
                <i class="fa-solid fa-circle-check"></i>
                <div>
                    <strong>Transparent Pricing</strong>
                    <span>Review all charges before paying.</span>
                </div>
            </div>

            <div class="p45-trust-card">
                <i class="fa-solid fa-earth-asia"></i>
                <div>
                    <strong>Global Job Reach</strong>
                    <span>Post across PeopleLink communities.</span>
                </div>
            </div>

        </aside>
    </div>

    <!-- PAYMENT SUCCESS: HIDDEN UNTIL VERIFIED SUCCESS -->
    <section class="p45-success-section"
             id="p45Success"
             hidden
             aria-live="polite">

        <div class="p45-success-card">
            <div class="p45-success-icon">
                <i class="fa-solid fa-check"></i>
            </div>

            <span class="p45-kicker">PAYMENT CONFIRMED</span>
            <h2>Package Activated Successfully!</h2>
            <p>
                Your payment has been confirmed and your package
                is ready to use.
            </p>

            <div class="p45-success-details">
                <div>
                    <span>Transaction ID</span>
                    <strong id="p45TransactionId">—</strong>
                </div>
                <div>
                    <span>Package Name</span>
                    <strong id="p45SuccessName">—</strong>
                </div>
                <div>
                    <span>Amount Paid</span>
                    <strong id="p45SuccessAmount">—</strong>
                </div>
                <div>
                    <span>Activation Date</span>
                    <strong id="p45ActivationDate">—</strong>
                </div>
                <div>
                    <span>Expiry Date</span>
                    <strong id="p45SuccessExpiry">—</strong>
                </div>
                <div>
                    <span>Job Posts Available</span>
                    <strong id="p45SuccessPosts">—</strong>
                </div>
            </div>

            <div class="p45-success-actions">
                <a href="post-global-job.php" class="p45-button primary">
                    <i class="fa-solid fa-paper-plane"></i>
                    Post Global Job
                </a>

                <a href="my-posted-jobs.php" class="p45-button outline">
                    <i class="fa-solid fa-briefcase"></i>
                    View My Posted Jobs
                </a>
            </div>

            <p class="p45-demo-notice" id="p45SuccessNotice" hidden>
                This is a demonstration confirmation, not a verified payment.
            </p>
        </div>
    </section>

    <!-- SUPPORT -->
    <section class="p45-support" id="p45Support">
        <div class="p45-support-icon">
            <i class="fa-solid fa-headset"></i>
        </div>
        <div>
            <h2>Need Help with Your Purchase?</h2>
            <p>
                Contact
                <a href="mailto:info@peoplelink.com">info@peoplelink.com</a>
                for assistance with packages, billing or renewals.
            </p>
        </div>
    </section>

    <p class="p45-terms-info" id="p45TermsInfo">
        Package prices, taxes, validity, renewals and payment processing
        must follow the terms configured by PeopleLink.
    </p>

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
<?= web_js_boot() ?><script>window.P45_PACKAGE=<?= json_encode($p45Js, JSON_HEX_TAG | JSON_HEX_AMP) ?>;window.P45_CURRENT=<?= json_encode($p45Cur, JSON_HEX_TAG | JSON_HEX_AMP) ?>;</script><script src="global-job-package-details.js?v=2"></script>

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