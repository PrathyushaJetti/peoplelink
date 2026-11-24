<?php
// Page 38 – Job Details (live data: matrimoney/includes/jobs_api.php — same backend as the mobile app)
require_once dirname(__DIR__) . '/_web.php';

$id = (int)filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$back = 'job-details.php?id=' . $id;

// Apply in PeopleLink (resume upload) — handled by the backend action jobs_apply
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_now'])) {
    web_require_login();
    $_POST['job_id'] = $id; $_POST['method'] = 'in_app';
    web_post('jobs_apply', $back . '#apply', $back . '#apply');
}

$res = $id ? web_call('jobs_details', ['id' => $id]) : ['error' => 'Job not found.'];
if (!empty($res['error'])) {
    http_response_code(404);
    $needLogin = !empty($res['login']) || !$webUser;
    $msg = $needLogin ? 'Please login to view this job. Community jobs are visible to members of that community.' : 'This job is not available. It may have been removed or belong to another community.';
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Job not found | PeopleLink</title></head>'
        . '<body style="font-family:Inter,system-ui,sans-serif;display:grid;place-items:center;min-height:90vh;margin:0;background:#f5f8fc"><div style="text-align:center;max-width:460px;padding:24px">'
        . '<h1 style="color:#0b2545">Job not found</h1><p style="color:#5b6b7f">' . h($msg) . '</p>'
        . '<p><a href="job-search-results.php" style="color:#0b6fb8;font-weight:600">Browse all jobs</a>'
        . ($needLogin ? ' · <a href="' . h(DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '')) . '" style="color:#0b6fb8;font-weight:600">Login</a>' : '') . '</p></div></body></html>';
    exit;
}
$j = web_job_card($res['item']);
$d = is_array($j['details'] ?? null) ? $j['details'] : [];
$lines = fn($s) => array_values(array_filter(array_map('trim', preg_split('/\r?\n/', (string)$s))));
$job = array_merge($j, [
    'logo' => $j['company_logo'] ?? '',
    'category' => $j['category_name'] ?? '',
    'company_description' => $d['company_description'] ?? '',
    'website' => $d['company_website'] ?? '',
    'role' => $j['description'] ?? '',
    'responsibilities' => $lines($j['responsibilities'] ?? ''),
    'skills' => array_values(array_filter(array_map('trim', explode(',', (string)($j['required_skills'] ?? ''))))),
    'preferred' => $lines($d['preferred_skills'] ?? $d['additional_requirements'] ?? ''),
    'work_location' => trim(($j['work_mode'] ?? '') . ' — ' . $j['location'], ' —'),
    'email' => $j['application_email'] ?? '',
    'whatsapp' => $j['whatsapp'] ?? '',
    'status' => !empty($j['accepting_applications']) ? 'open' : 'closed',
]);

function salaryText($job) {
    if (!empty($job['salary_text'])) return $job['salary_text'];
    if (empty($job['salary_min']) && empty($job['salary_max'])) return 'Not disclosed';
    return '₹'.number_format((int)$job['salary_min']).' – ₹'.number_format((int)$job['salary_max']).' / month';
}
function dateText($date) { return $date ? date('d M Y', strtotime($date)) : ''; }
function bulletList($items) {
    if (!$items) return '<p class="muted">Not specified by the employer.</p>';
    $html = '<ul class="detail-bullets">';
    foreach ($items as $item) $html .= '<li>'.h($item).'</li>';
    return $html.'</ul>';
}

$alreadyApplied = !empty($job['applied']);
$isOwn = !empty($job['is_own']);
$isClosed = $job['status'] !== 'open';
$methods = (array)($job['apply_methods'] ?? []);
$waNumber = in_array('whatsapp', $methods, true) ? preg_replace('/\D+/', '', $job['whatsapp'] ?? '') : '';
$waMessage = rawurlencode('Hello, I am interested in the '.$job['title'].' position at '.$job['company'].'. Please share the next steps.');
$whatsappUrl = $waNumber ? 'https://wa.me/'.$waNumber.'?text='.$waMessage : '';
$emailSubject = rawurlencode('Application for '.$job['title']);
$emailBody = rawurlencode("Hello ".$job['company'].",\n\nI would like to apply for the ".$job['title']." position.\n\nPlease find my resume attached.\n\nRegards,");
$emailUrl = (in_array('email', $methods, true) && !empty($job['email'])) ? 'mailto:'.$job['email'].'?subject='.$emailSubject.'&body='.$emailBody : '';

// Similar jobs: same category, newest first (not this one)
$_REQUEST['per'] = 4; $_REQUEST['page'] = 1;
$sim = $job['category_id'] ? pl_jobs_list(web_ctx(), ['category_id' => $job['category_id'], 'sort' => 'latest'], 't.id<>?', [$job['id']]) : ['items' => []];
$similarJobs = array_map(fn($s) => ['id' => $s['id'], 'title' => $s['title'], 'company' => $s['company'], 'location' => $s['location'],
    'type' => $s['scope'] === 'global' ? 'Global Job' : 'Community Job'], array_slice(array_map('web_job_card', $sim['items']), 0, 3));
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
        href="job-details.css"
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

<main class="pl-job-details">
<?= web_flash_html() ?>
    <section class="jd-hero">
        <div class="jd-container">
            <a class="back-link" href="job-search-results.php"><i class="fa-solid fa-arrow-left"></i> Back to Job Results</a>
            <div class="jd-hero-card">
                <div class="jd-company-logo">
                    <?php if (!empty($job['logo'])): ?>
                        <img src="<?= h($job['logo']) ?>" alt="<?= h($job['company']) ?> logo">
                    <?php else: ?>
                        <span><?= h(strtoupper(substr($job['company'], 0, 1))) ?></span>
                    <?php endif; ?>
                </div>
                <div class="jd-hero-main">
                    <div class="jd-tags">
                        <span class="jd-tag <?= $job['scope']==='community'?'community':'global' ?>"><?= $job['scope']==='community'?'Community Job':'Global Job' ?></span>
                        <?php if ($job['scope']==='community' && $job['community']): ?><span class="jd-tag community-name"><?= h($job['community']) ?> Community</span><?php endif; ?>
                        <?php if ($isClosed): ?><span class="jd-tag closed">Closed</span><?php endif; ?>
                    </div>
                    <h1><?= h($job['title']) ?></h1>
                    <p class="jd-company-name"><?= h($job['company']) ?></p>
                    <div class="jd-quick-meta">
                        <span><i class="fa-solid fa-location-dot"></i><?= h($job['location']) ?></span>
                        <span><i class="fa-solid fa-clock"></i><?= h($job['job_type']) ?></span>
                        <span><i class="fa-solid fa-laptop"></i><?= h($job['work_mode']) ?></span>
                        <span><i class="fa-solid fa-briefcase"></i><?= h($job['experience']) ?></span>
                    </div>
                </div>
                <div class="jd-hero-side">
                    <div class="jd-salary-label">SALARY RANGE</div>
                    <div class="jd-salary"><?= h(salaryText($job)) ?></div>
                    <div class="jd-posted"><i class="fa-regular fa-calendar"></i> Posted <?= h(dateText($job['posted'])) ?></div>
                </div>
            </div>
        </div>
    </section>

    <section class="jd-container jd-layout">
        <div class="jd-content">
            <?php if ($alreadyApplied): ?>
                <div class="status-banner applied"><i class="fa-solid fa-circle-check"></i><div><strong>Applied</strong><span>You have applied for this job<?= !empty($job['application_status']) ? ' — status: ' . h(ucwords(str_replace('_', ' ', $job['application_status']))) : '' ?>. <a href="my-applications.php">View my applications</a></span></div></div>
            <?php elseif ($isClosed): ?>
                <div class="status-banner closed"><i class="fa-solid fa-circle-info"></i><div><strong>This Job is No Longer Accepting Applications</strong><span>You can still review the role details below.</span></div></div>
            <?php endif; ?>

            <section class="jd-panel">
                <div class="panel-title"><span class="panel-icon"><i class="fa-solid fa-file-lines"></i></span><div><h2>Job Description</h2><p>Understand the role and what the employer expects.</p></div></div>
                <div class="jd-prose"><h3>Job Role</h3><p><?= h($job['role']) ?></p></div>
                <div class="jd-prose"><h3>Key Responsibilities</h3><?= bulletList($job['responsibilities']) ?></div>
                <div class="jd-prose"><h3>Required Skills</h3><div class="skill-list"><?php foreach ($job['skills'] as $skill): ?><span><?= h($skill) ?></span><?php endforeach; ?></div></div>
                <div class="detail-grid">
                    <div class="detail-item"><span>Qualification</span><strong><?= h($job['qualification']) ?></strong></div>
                    <div class="detail-item"><span>Experience Required</span><strong><?= h($job['experience']) ?></strong></div>
                    <div class="detail-item"><span>Number of Openings</span><strong><?= (int)$job['openings'] ?></strong></div>
                    <div class="detail-item"><span>Employment Type</span><strong><?= h($job['employment_type']) ?></strong></div>
                    <div class="detail-item"><span>Work Location</span><strong><?= h($job['work_location']) ?></strong></div>
                    <div class="detail-item"><span>Joining Availability</span><strong><?= h($job['joining'] ?: 'Not specified') ?></strong></div>
                </div>
                <?php if (!empty($job['preferred'])): ?><div class="jd-prose"><h3>Preferred Skills</h3><?= bulletList($job['preferred']) ?></div><?php endif; ?>
            </section>

            <section class="jd-panel">
                <div class="panel-title"><span class="panel-icon green"><i class="fa-solid fa-building"></i></span><div><h2>Company / Organisation</h2><p>Learn more about the organisation offering this role.</p></div></div>
                <div class="company-detail-head"><div class="company-mini-mark"><?= h(strtoupper(substr($job['company'], 0, 1))) ?></div><div><h3><?= h($job['company']) ?></h3><span><?= h($job['category']) ?></span></div></div>
                <p class="company-description"><?= h($job['company_description']) ?></p>
                <div class="company-info-row"><i class="fa-solid fa-location-dot"></i><span><?= h($job['location']) ?></span></div>
                <?php if (!empty($job['website'])): ?><div class="company-info-row"><i class="fa-solid fa-globe"></i><a href="<?= h($job['website']) ?>" target="_blank" rel="noopener noreferrer"><?= h(parse_url($job['website'], PHP_URL_HOST) ?: $job['website']) ?></a></div><?php endif; ?>
            </section>

            <section class="jd-panel" id="apply">
                <div class="panel-title"><span class="panel-icon orange"><i class="fa-solid fa-paper-plane"></i></span><div><h2>How to Apply</h2><p>Choose an available contact method and prepare your resume.</p></div></div>
                <?php if (!$isClosed && !$alreadyApplied): ?>
                <div class="apply-options">
                    <?php if ($whatsappUrl): ?><a class="apply-option whatsapp" href="<?= h($whatsappUrl) ?>" target="_blank" rel="noopener noreferrer"><span class="apply-option-icon"><i class="fa-brands fa-whatsapp"></i></span><span><strong>Apply via WhatsApp</strong><small>Contact the configured employer number</small></span><i class="fa-solid fa-arrow-up-right-from-square option-arrow"></i></a>
                    <?php else: ?><div class="apply-option unavailable"><span class="apply-option-icon"><i class="fa-brands fa-whatsapp"></i></span><span><strong>Apply via WhatsApp</strong><small>Employer WhatsApp number is not configured.</small></span></div><?php endif; ?>
                    <?php if ($emailUrl): ?><a class="apply-option email" href="<?= h($emailUrl) ?>"><span class="apply-option-icon"><i class="fa-regular fa-envelope"></i></span><span><strong>Apply via Email</strong><small>Open your email application draft</small></span><i class="fa-solid fa-arrow-up-right-from-square option-arrow"></i></a>
                    <?php else: ?><div class="apply-option unavailable"><span class="apply-option-icon"><i class="fa-regular fa-envelope"></i></span><span><strong>Apply via Email</strong><small>Employer email address is not configured.</small></span></div><?php endif; ?>
                </div>
                <?php if ($isOwn): ?><p class="muted">This is your job post. <a href="my-posted-jobs.php">Manage your posted jobs</a>.</p><?php elseif (!$webUser): ?><p class="muted"><a href="<?= h(DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '')) ?>">Login</a> to apply in PeopleLink with your resume.</p><?php else: ?><form class="resume-form" id="resumeForm" action="" method="post" enctype="multipart/form-data"><?= web_csrf_field() ?>
                    <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                    <div class="resume-heading"><div><h3>Attach Your Resume</h3><p>PDF, DOC or DOCX · Maximum 5 MB</p></div><i class="fa-solid fa-file-arrow-up"></i></div>
                    <label class="resume-drop" for="resumeFile"><i class="fa-regular fa-folder-open"></i><strong>Choose resume file</strong><span>Browse your device</span><input type="file" id="resumeFile" name="resume" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"><small id="resumeFileName">No file selected</small></label>
                    <div class="resume-buttons"><button class="btn btn-outline" type="button" id="replaceResume" hidden>Replace Resume</button><button class="btn btn-primary" type="submit" name="apply_now" value="1">Apply Now <i class="fa-solid fa-arrow-right"></i></button></div>
                    <p class="form-note">Your application and resume are sent securely to the employer through PeopleLink.</p>
                </form><?php endif; ?>
                <?php elseif ($alreadyApplied): ?><p class="muted">You have already applied to this job. <a href="my-applications.php">Track your application</a>.</p>
                <?php else: ?><p class="muted">This job is closed and is no longer accepting applications.</p><?php endif; ?>
            </section>
        </div>

        <aside class="jd-sidebar">
            <div class="side-card action-card">
                <span class="side-label">INTERESTED IN THIS ROLE?</span>
                <h3>Take the next step</h3>
                <p>Keep this opportunity handy or share it with someone who may be a good fit.</p>
                <button class="btn btn-primary side-action" id="applyNowButton" type="button" <?= ($isClosed || $alreadyApplied)?'disabled':'' ?>>Apply Now <i class="fa-solid fa-arrow-right"></i></button>
                <button class="btn btn-outline side-action<?= !empty($job['saved']) ? ' is-saved' : '' ?>" id="saveJobButton" type="button" data-job-id="<?= (int)$job['id'] ?>"><?= !empty($job['saved']) ? '<i class="fa-solid fa-bookmark"></i> Saved' : '<i class="fa-regular fa-bookmark"></i> Save Job' ?></button>
                <button class="btn btn-outline side-action" id="shareJobButton" type="button"><i class="fa-solid fa-share-nodes"></i> Share Job</button>
                <div class="share-feedback" id="shareFeedback" role="status" aria-live="polite"></div>
            </div>
            <div class="side-card highlights-card">
                <h3><i class="fa-solid fa-list-check"></i> Job Highlights</h3>
                <div class="highlight-row"><span>Experience</span><strong><?= h($job['experience']) ?></strong></div>
                <div class="highlight-row"><span>Job Type</span><strong><?= h($job['job_type']) ?></strong></div>
                <div class="highlight-row"><span>Work Mode</span><strong><?= h($job['work_mode']) ?></strong></div>
                <div class="highlight-row"><span>Openings</span><strong><?= (int)$job['openings'] ?></strong></div>
                <div class="highlight-row"><span>Posted On</span><strong><?= h(dateText($job['posted'])) ?></strong></div>
            </div>
        </aside>
    </section>

    <?php if ($similarJobs): ?>
    <section class="jd-container similar-section">
        <div class="similar-heading"><div><span class="section-kicker">KEEP EXPLORING</span><h2>Similar Jobs</h2><p>Other opportunities you may want to consider.</p></div><a class="btn btn-outline" href="job-search-results.php">View Similar Jobs <i class="fa-solid fa-arrow-right"></i></a></div>
        <div class="similar-grid">
            <?php foreach ($similarJobs as $similar): ?>
            <article class="similar-card"><span class="similar-type"><?= h($similar['type']) ?></span><h3><?= h($similar['title']) ?></h3><p><?= h($similar['company']) ?></p><div class="similar-location"><i class="fa-solid fa-location-dot"></i><?= h($similar['location']) ?></div><a href="job-details.php?id=<?= (int)$similar['id'] ?>" class="similar-link">View Details <i class="fa-solid fa-arrow-right"></i></a></article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
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
<?= web_js_boot() ?>
<script src="job-details.js?v=2"></script>
<script src="js/jobs-global.js"></script>
</body>
</html>
