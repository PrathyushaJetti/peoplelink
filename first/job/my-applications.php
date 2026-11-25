<?php
// Page – My Applications (live: jobs_my_applications backend action)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();
$_REQUEST['per'] = 50; $_REQUEST['page'] = 1;
$apps = web_call('jobs_my_applications', ['per' => 50]);
$appItems = $apps['items'] ?? [];
// job details for each application (location, type, salary, community, contact rules)
$appJobs = [];
if ($appItems) {
    $ids = implode(',', array_map('intval', array_unique(array_column($appItems, 'job_id'))));
    foreach (rows("SELECT * FROM jobs WHERE id IN ($ids)") as $r) $appJobs[(int)$r['id']] = web_job_card(pl_job_out($r, $webUid, true, ['application' => true]));
}
$methodLabel = ['in_app' => 'PeopleLink', 'email' => 'Email', 'whatsapp' => 'WhatsApp'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PeopleLink — Manage your job applications and track application status.">

    <title>My Applications | PeopleLink</title>

    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- EXISTING PEOPLELINK CSS -->
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">

    <!-- PAGE 43 CSS -->
    <link rel="stylesheet" href="my-applications.css">
</head>

<body>

<!-- =====================================================
     PEOPLELINK HEADER
====================================================== -->

<?php include __DIR__ . '/../_site_header.php'; ?>


<!-- =====================================================
     PAGE 43: MY APPLICATIONS
====================================================== -->

<main class="ma-page">

    <!-- HERO -->
    <section class="ma-hero">
        <div class="ma-container ma-hero-inner">

            <div>
                <span class="ma-eyebrow">
                    <i class="fa-solid fa-briefcase"></i>
                    PEOPLELINK CAREER NETWORK
                </span>

                <h1>My Applications</h1>

                <p>
                    Keep track of your job applications, review
                    their status and follow up on opportunities.
                </p>
            </div>

            <div class="ma-hero-art">
                <span class="ma-hero-icon">
                    <i class="fa-solid fa-file-circle-check"></i>
                </span>

                <span class="ma-hero-mini">
                    <i class="fa-solid fa-paper-plane"></i>
                </span>
            </div>

        </div>
    </section>


    <!-- MAIN CONTENT -->
    <div class="ma-container ma-content">

        <!-- HEADING -->
        <div class="ma-heading-row">

            <div>
                <span class="ma-kicker">YOUR CAREER DASHBOARD</span>
                <h2>Track your applications</h2>
                <p>
                    View the jobs you've applied for and check your latest status.
                </p>
            </div>

            <a href="jobs-home.php" class="ma-btn primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Find More Jobs
            </a>

        </div>


        <!-- SUMMARY CARDS -->
        <section class="ma-stats" aria-label="Application summary">

            <div class="ma-stat">
                <span class="ma-stat-icon blue">
                    <i class="fa-solid fa-paper-plane"></i>
                </span>

                <div>
                    <small>Total Applications</small>
                    <strong id="maTotalCount">4</strong>
                </div>
            </div>

            <div class="ma-stat">
                <span class="ma-stat-icon green">
                    <i class="fa-solid fa-circle-check"></i>
                </span>

                <div>
                    <small>Active Applications</small>
                    <strong id="maActiveCount">3</strong>
                </div>
            </div>

            <div class="ma-stat">
                <span class="ma-stat-icon purple">
                    <i class="fa-solid fa-eye"></i>
                </span>

                <div>
                    <small>Viewed by Employer</small>
                    <strong id="maViewedCount">1</strong>
                </div>
            </div>

            <div class="ma-stat">
                <span class="ma-stat-icon amber">
                    <i class="fa-solid fa-folder-closed"></i>
                </span>

                <div>
                    <small>Closed Applications</small>
                    <strong id="maClosedCount">1</strong>
                </div>
            </div>

        </section>


        <!-- STATUS TABS -->
        <nav class="ma-tabs" aria-label="Application status filters">

            <button type="button" class="selected"
                    data-status-tab="all" aria-pressed="true">
                All <span id="maAllTabCount">4</span>
            </button>

            <button type="button"
                    data-status-tab="active" aria-pressed="false">
                Active <span id="maActiveTabCount">3</span>
            </button>

            <button type="button"
                    data-status-tab="closed" aria-pressed="false">
                Closed <span id="maClosedTabCount">1</span>
            </button>

        </nav>


        <!-- FILTERS -->
        <section class="ma-filter-panel" aria-label="Filter applications">

            <div class="ma-search">
                <i class="fa-solid fa-magnifying-glass"></i>

                <input type="search"
                       id="maSearch"
                       placeholder="Search job title or company"
                       aria-label="Search applications">
            </div>

            <select id="maJobVisibility" aria-label="Filter by job type">
                <option value="all">All Job Types</option>
                <option value="community">Community Jobs</option>
                <option value="global">Global Jobs</option>
            </select>

            <select id="maJobStatus" aria-label="Filter by job status">
                <option value="all">All Job Statuses</option>
                <option value="active">Active Jobs</option>
                <option value="closed">Closed Jobs</option>
            </select>

            <select id="maSort" aria-label="Sort applications">
                <option value="latest">Latest Applications</option>
                <option value="oldest">Oldest Applications</option>
            </select>

            <button type="button" class="ma-reset" id="maReset">
                Reset
            </button>

        </section>


        <!-- RESULTS -->
        <div class="ma-results-line">
            <strong id="maResultsCount">4 applications found</strong>
            <span>Manage your submitted applications</span>
        </div>


        <!-- APPLICATION CARDS -->
        <section class="ma-list" id="maApplicationList"
                 aria-label="Your applications">

            <?php foreach ($appItems as $a):
                $jb = $appJobs[(int)$a['job_id']] ?? [];
                $g = !empty($a['is_global']);
                $jobActive = ($a['job_status'] ?? '') === 'approved' && (empty($a['closing_date']) || $a['closing_date'] >= date('Y-m-d'));
                $st = in_array($a['status'], ['applied', 'viewed', 'shortlisted', 'rejected'], true) ? $a['status'] : 'closed';
                $stLabel = ucwords(str_replace('_', ' ', (string)$a['status']));
                $contact = $jb ? pl_job_contact(pl_entity_row(pl_entity('job'), (int)$a['job_id']) ?: [], $webUser) : [];
                $methods = $jb['apply_methods'] ?? []; ?>
            <article class="ma-card" data-application
                     data-id="<?= h($a['application_code']) ?>" data-title="<?= h($a['job_title']) ?>" data-company="<?= h($a['company_name']) ?>"
                     data-location="<?= h($jb['location'] ?? '') ?>" data-visibility="<?= $g ? 'global' : 'community' ?>" data-community="<?= h($jb['community'] ?? '') ?>"
                     data-application-date="<?= h(substr($a['applied_at'], 0, 10)) ?>" data-method="<?= h($methodLabel[$a['apply_method']] ?? $a['apply_method']) ?>"
                     data-job-status="<?= $jobActive ? 'active' : 'closed' ?>" data-application-status="<?= h($stLabel) ?>" data-applicant="<?= h($a['applicant_name']) ?>"
                     data-resume="<?= h($a['resume_name'] ?? '') ?>" data-message="<?= h($a['cover_letter'] ?? '') ?>" data-description="<?= h($jb['description'] ?? '') ?>"
                     data-job-type="<?= h($jb['job_type'] ?? '') ?>" data-salary="<?= h($jb['salary_text'] ?? '') ?>"
                     data-contact-methods="<?= h(implode(',', array_diff($methods, ['in_app']))) ?>" data-contact-number="<?= h($contact['whatsapp'] ?? '') ?>" data-contact-email="<?= h($contact['email'] ?? '') ?>">
                <div class="ma-card-top">
                    <div class="ma-company-mark"><i class="fa-solid <?= $g ? 'fa-earth-asia' : 'fa-building' ?>"></i></div>
                    <div class="ma-card-title">
                        <div class="ma-badges"><span class="ma-type-badge"><?= $g ? 'Global Job' : 'Community Job' ?></span><?php if (!$g && !empty($jb['community'])): ?><span class="ma-community-badge"><i class="fa-solid fa-users"></i> <?= h($jb['community']) ?></span><?php endif; ?></div>
                        <h3><?= h($a['job_title']) ?></h3>
                        <p><?= h($a['company_name']) ?></p>
                    </div>
                    <span class="ma-status <?= h($st) ?>"><span></span> <?= h($stLabel) ?></span>
                </div>
                <div class="ma-meta">
                    <span><i class="fa-solid fa-location-dot"></i> <?= h($jb['location'] ?? '') ?></span>
                    <span><i class="fa-regular fa-calendar-check"></i> Applied <?= h(date('d M Y', strtotime($a['applied_at']))) ?></span>
                    <span><i class="fa-solid fa-paper-plane"></i> <?= h($methodLabel[$a['apply_method']] ?? $a['apply_method']) ?></span>
                    <span><i class="fa-solid fa-hashtag"></i> <?= h($a['application_code']) ?></span>
                </div>
                <div class="ma-card-bottom">
                    <div class="ma-status-summary">
                        <span>Job Status: <strong class="ma-job-state <?= $jobActive ? 'active-text' : 'closed-text' ?>"><?= $jobActive ? 'Active' : 'Closed' ?></strong></span>
                        <span>Application Status: <strong><?= h($stLabel) ?></strong></span>
                    </div>
                    <div class="ma-card-actions">
                        <a href="job-details.php?id=<?= (int)$a['job_id'] ?>" class="ma-btn small outline"><i class="fa-regular fa-eye"></i> View Job</a>
                        <button type="button" class="ma-btn small outline" data-view-application><i class="fa-regular fa-file-lines"></i> View Application</button>
                        <?php if (!empty($contact['email']) || !empty($contact['whatsapp'])): ?><button type="button" class="ma-btn small soft" data-contact-application><i class="fa-solid fa-comments"></i> Contact</button><?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>

        </section>


        <!-- EMPTY STATE -->
        <section class="ma-empty-state" id="maEmptyState" hidden>

            <div class="ma-empty-icon">
                <i class="fa-regular fa-folder-open"></i>
            </div>

            <h3>You have not applied for any jobs yet.</h3>

            <p>
                Explore opportunities and submit your first job application.
            </p>

            <a href="jobs-home.php" class="ma-btn primary">
                <i class="fa-solid fa-magnifying-glass"></i>
                Explore Jobs
            </a>

        </section>


        <!-- DEMO NOTE -->
        <div class="ma-demo-note">
            <i class="fa-solid fa-circle-info"></i>
            <p>
                <strong>Sample data:</strong>
                These applications demonstrate the page layout.
                Connect the page to your database to show the logged-in
                user's actual applications and employer updates.
            </p>
        </div>

    </div>


    <!-- =================================================
         APPLICATION DETAILS MODAL
    ================================================== -->

    <div class="ma-modal-overlay" id="maDetailsModal" hidden>

        <section class="ma-modal" role="dialog"
                 aria-modal="true"
                 aria-labelledby="maModalTitle">

            <div class="ma-modal-header">

                <div>
                    <span class="ma-kicker">APPLICATION DETAILS</span>
                    <h2 id="maModalTitle">Your Application</h2>
                </div>

                <button type="button"
                        class="ma-modal-close"
                        data-close-modal
                        aria-label="Close application details">
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>

            <div class="ma-modal-body">

                <div class="ma-modal-job">
                    <div class="ma-company-mark">
                        <i class="fa-solid fa-building"></i>
                    </div>

                    <div>
                        <h3 id="maDetailJobTitle"></h3>
                        <p id="maDetailCompany"></p>
                    </div>
                </div>

                <div class="ma-detail-grid">

                    <div class="ma-detail-item">
                        <span>Location</span>
                        <strong id="maDetailLocation"></strong>
                    </div>

                    <div class="ma-detail-item">
                        <span>Job Type</span>
                        <strong id="maDetailJobType"></strong>
                    </div>

                    <div class="ma-detail-item">
                        <span>Job Visibility</span>
                        <strong id="maDetailVisibility"></strong>
                    </div>

                    <div class="ma-detail-item">
                        <span>Application Date</span>
                        <strong id="maDetailDate"></strong>
                    </div>

                    <div class="ma-detail-item">
                        <span>Applicant Name</span>
                        <strong id="maDetailApplicant"></strong>
                    </div>

                    <div class="ma-detail-item">
                        <span>Resume Used</span>
                        <strong id="maDetailResume"></strong>
                    </div>

                    <div class="ma-detail-item">
                        <span>Application Method</span>
                        <strong id="maDetailMethod"></strong>
                    </div>

                    <div class="ma-detail-item">
                        <span>Job Status</span>
                        <strong id="maDetailJobStatus"></strong>
                    </div>

                    <div class="ma-detail-item">
                        <span>Application Status</span>
                        <strong id="maDetailStatus"></strong>
                    </div>

                    <div class="ma-detail-item">
                        <span>Salary</span>
                        <strong id="maDetailSalary"></strong>
                    </div>

                </div>

                <div class="ma-detail-description">
                    <h4>Job Details</h4>
                    <p id="maDetailDescription"></p>
                </div>

                <div class="ma-detail-description">
                    <h4>Message Sent</h4>
                    <p id="maDetailMessage"></p>
                </div>

            </div>

            <div class="ma-modal-footer">

                <button type="button"
                        class="ma-btn outline"
                        data-close-modal>
                    Close
                </button>

                <a href="jobs-home.php"
                   class="ma-btn primary"
                   id="maDetailViewJob">
                    <i class="fa-regular fa-eye"></i>
                    View Job
                </a>

            </div>

        </section>
    </div>


    <!-- CONTACT OPTIONS MODAL -->
    <div class="ma-modal-overlay" id="maContactModal" hidden>

        <section class="ma-modal ma-contact-modal"
                 role="dialog"
                 aria-modal="true"
                 aria-labelledby="maContactTitle">

            <div class="ma-modal-header">

                <div>
                    <span class="ma-kicker">EMPLOYER CONTACT</span>
                    <h2 id="maContactTitle">Contact Employer</h2>
                </div>

                <button type="button"
                        class="ma-modal-close"
                        data-close-modal
                        aria-label="Close contact options">
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>

            <div class="ma-modal-body">

                <p id="maContactJobName"></p>

                <p class="ma-contact-hint">
                    Choose an available contact method configured by the employer.
                </p>

                <div class="ma-contact-options" id="maContactOptions"></div>

                <p id="maContactUnavailable" class="ma-contact-unavailable" hidden>
                    No contact method is currently available for this job.
                </p>

            </div>

            <div class="ma-modal-footer">
                <button type="button"
                        class="ma-btn outline"
                        data-close-modal>
                    Cancel
                </button>
            </div>

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
                    <li><a href="#communityList">Matrimony &amp; Relationships</a></li>
                    <li><a href="#platformServices">Family &amp; Community</a></li>
                    <li><a href="jobs-home.php">Jobs &amp; Career</a></li>
                    <li><a href="#platformServices">Professionals &amp; Businesses</a></li>
                    <li><a href="#platformServices">Marketplace</a></li>
                    <li><a href="#events">Community Events</a></li>
                </ul>

            </div>


            <!-- SUPPORT -->
            <div class="pl-footer-column">

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
<script src="my-applications.js?v=2"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const year = document.getElementById("plCopyrightYear");

    if (year) {
        year.textContent = new Date().getFullYear();
    }

    const backToTop = document.getElementById("plBackToTop");

    if (backToTop) {
        backToTop.addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    }

});
</script>

<script src="js/jobs-global.js"></script>
</body>
</html>
