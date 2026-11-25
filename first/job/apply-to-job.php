<?php
// Apply to Job (live: job from jobs_details, application sent with the backend action jobs_apply)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();
$ajId = (int)($_GET['job'] ?? $_GET['jobId'] ?? $_GET['id'] ?? 0);
$ajRes = $ajId ? web_call('jobs_details', ['id' => $ajId]) : ['error' => 'missing'];
if (!empty($ajRes['error'])) { flash('That job is not available.', 'error'); header('Location: job-search-results.php'); exit; }
$aj = web_job_card($ajRes['item']);
if (!empty($aj['applied'])) { flash('You have already applied for this job.', 'success'); header('Location: job-details.php?id=' . $ajId . '#apply'); exit; }
if (empty($aj['accepting_applications'])) { flash('This job is no longer accepting applications.', 'error'); header('Location: job-details.php?id=' . $ajId); exit; }
$ajSaved = pl_job_saved_resume($webUid);
$ajJob = ['id' => (int)$aj['id'], 'title' => $aj['title'], 'company' => $aj['company'], 'location' => $aj['location'], 'type' => $aj['job_type'],
    'visibility' => $aj['scope'] === 'global' ? 'Global Job' : 'Community Job', 'closingDate' => $aj['closing_date'] ? date('d M Y', strtotime($aj['closing_date'])) : 'Open',
    'whatsappNumber' => '', 'employerEmail' => '',
    // In-app applications always reach the employer; these cards show the extra ways the employer accepts.
    'methods' => ['whatsapp' => in_array('whatsapp', $aj['apply_methods'], true), 'email' => true]];
$ajProfile = ['fullName' => $webUser['name'] ?? '', 'mobile' => $webUser['phone'] ?? '', 'email' => $webUser['email'] ?? '', 'qualification' => '', 'experience' => '', 'currentLocation' => $webUser['city'] ?? ''];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PeopleLink — Apply to jobs and discover career opportunities.">

    <title>Apply to Job | PeopleLink</title>

    <!-- ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- EXISTING WEBSITE CSS -->
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">

    <!-- PAGE 42 CSS -->
    <link rel="stylesheet" href="apply-to-job.css">
</head>

<body>

<!-- =====================================================
     PEOPLELINK HEADER
====================================================== -->

<?php include __DIR__ . '/../_site_header.php'; ?>


<!-- =====================================================
     PAGE 42: APPLY TO JOB
====================================================== -->

<main class="aj-page">

    <!-- HERO -->
    <section class="aj-hero">
        <div class="aj-container aj-hero-inner">

            <div>
                <span class="aj-eyebrow">
                    <i class="fa-solid fa-briefcase"></i>
                    PEOPLELINK CAREER NETWORK
                </span>

                <h1>Apply to Job</h1>

                <p>
                    Complete your application and take the next
                    step towards your career opportunity.
                </p>
            </div>

            <div class="aj-hero-icon">
                <i class="fa-solid fa-file-circle-check"></i>
            </div>

        </div>
    </section>


    <!-- PAGE CONTENT -->
    <div class="aj-container aj-layout">

        <!-- APPLICATION FORM -->
        <section class="aj-main-card">

            <div class="aj-section-heading">
                <span class="aj-kicker">JOB APPLICATION</span>
                <h2>Complete your application</h2>
                <p>Please check your details before submitting.</p>
            </div>

            <form id="ajApplicationForm" novalidate>

                <!-- JOB SUMMARY -->
                <section class="aj-section">

                    <div class="aj-section-title">
                        <span class="aj-title-icon">
                            <i class="fa-solid fa-briefcase"></i>
                        </span>

                        <div>
                            <h3>Job Summary</h3>
                            <p>Review the job details below.</p>
                        </div>
                    </div>

                    <div class="aj-job-summary">

                        <div class="aj-company-icon">
                            <i class="fa-solid fa-building"></i>
                        </div>

                        <div class="aj-job-info">
                            <span class="aj-job-type" id="ajJobVisibility">
                                Community Job
                            </span>

                            <h2 id="ajJobTitle">PHP Web Developer</h2>

                            <p id="ajCompanyName">Deep Web Solution</p>
                        </div>

                    </div>

                    <div class="aj-job-details">

                        <div>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>
                                <small>Location</small>
                                <strong id="ajLocation">Rishikesh, Uttarakhand</strong>
                            </span>
                        </div>

                        <div>
                            <i class="fa-solid fa-clock"></i>
                            <span>
                                <small>Job Type</small>
                                <strong id="ajJobType">Full Time</strong>
                            </span>
                        </div>

                        <div>
                            <i class="fa-regular fa-calendar-xmark"></i>
                            <span>
                                <small>Closing Date</small>
                                <strong id="ajClosingDate">31 Oct 2026</strong>
                            </span>
                        </div>

                    </div>
                </section>

                <div class="aj-divider"></div>

                <!-- APPLICANT DETAILS -->
                <section class="aj-section">

                    <div class="aj-section-title">
                        <span class="aj-title-icon">
                            <i class="fa-solid fa-user"></i>
                        </span>

                        <div>
                            <h3>Applicant Details</h3>
                            <p>Your profile details, where available.</p>
                        </div>
                    </div>

                    <div class="aj-form-grid">

                        <div class="aj-field">
                            <label for="ajFullName">Full Name *</label>
                            <input type="text" id="ajFullName"
                                   name="fullName" autocomplete="name" required>
                        </div>

                        <div class="aj-field">
                            <label for="ajMobile">Mobile Number *</label>
                            <input type="tel" id="ajMobile"
                                   name="mobile" autocomplete="tel" required>
                        </div>

                        <div class="aj-field">
                            <label for="ajEmail">Email ID *</label>
                            <input type="email" id="ajEmail"
                                   name="email" autocomplete="email" required>
                        </div>

                        <div class="aj-field">
                            <label for="ajQualification">Qualification *</label>
                            <input type="text" id="ajQualification"
                                   name="qualification" required>
                        </div>

                        <div class="aj-field">
                            <label for="ajExperience">Experience *</label>
                            <select id="ajExperience" name="experience" required>
                                <option value="">Select experience</option>
                                <option value="Fresher">Fresher</option>
                                <option value="Less than 1 year">Less than 1 year</option>
                                <option value="1–2 years">1–2 years</option>
                                <option value="3–5 years">3–5 years</option>
                                <option value="6–10 years">6–10 years</option>
                                <option value="10+ years">10+ years</option>
                            </select>
                        </div>

                        <div class="aj-field">
                            <label for="ajCurrentLocation">Current Location *</label>
                            <input type="text" id="ajCurrentLocation"
                                   name="currentLocation" required>
                        </div>

                    </div>
                </section>

                <div class="aj-divider"></div>

                <!-- RESUME -->
                <section class="aj-section">

                    <div class="aj-section-title">
                        <span class="aj-title-icon">
                            <i class="fa-solid fa-file-pdf"></i>
                        </span>

                        <div>
                            <h3>Resume / CV</h3>
                            <p>Upload a resume or select one saved to your profile.</p>
                        </div>
                    </div>

                    <div class="aj-resume-options">

                        <label class="aj-resume-option">
                            <input type="radio" name="resumeMode"
                                   value="upload" checked>

                            <span>
                                <strong>Upload Resume</strong>
                                <small>PDF, DOC or DOCX</small>
                            </span>
                        </label>

                        <label class="aj-resume-option">
                            <input type="radio" name="resumeMode"
                                   value="saved">

                            <span>
                                <strong>Previously Uploaded Resume</strong>
                                <small>Choose an existing resume</small>
                            </span>
                        </label>

                    </div>

                    <div id="ajUploadPanel" class="aj-resume-panel">

                        <label for="ajResume" class="aj-upload-box">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <strong>Click to upload your resume</strong>
                            <span>Maximum file size: 5 MB</span>
                        </label>

                        <input type="file" id="ajResume"
                               accept=".pdf,.doc,.docx" hidden>

                        <div id="ajSelectedResume"
                             class="aj-selected-resume" hidden>

                            <span id="ajResumeFileName"></span>

                            <button type="button" id="ajReplaceResume">
                                Replace
                            </button>

                            <button type="button" id="ajRemoveResume">
                                Remove
                            </button>

                        </div>
                    </div>

                    <div id="ajSavedResumePanel" hidden>

                        <label for="ajSavedResume">
                            Select previously uploaded resume
                        </label>

                        <select id="ajSavedResume">
                            <option value="">Select a resume</option>
                            <?php if ($ajSaved): ?><option value="saved" selected><?= h($ajSaved['name'] ?? 'My resume') ?></option><?php endif; ?>
                        </select>

                    </div>

                </section>

                <div class="aj-divider"></div>

                <!-- APPLICATION METHOD -->
                <section class="aj-section">

                    <div class="aj-section-title">
                        <span class="aj-title-icon">
                            <i class="fa-solid fa-paper-plane"></i>
                        </span>

                        <div>
                            <h3>Application Method</h3>
                            <p>Select from the methods enabled by the employer.</p>
                        </div>
                    </div>

                    <div class="aj-method-grid">

                        <label class="aj-method-card" id="ajWhatsAppCard">

                            <input type="checkbox" id="ajWhatsApp"
                                   name="method" value="whatsapp" checked>

                            <span class="aj-method-icon whatsapp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </span>

                            <span class="aj-method-content">
                                <strong>Apply via WhatsApp</strong>
                                <small>Continue through the configured WhatsApp contact.</small>
                                <span class="aj-method-status">Enabled</span>
                            </span>

                        </label>

                        <label class="aj-method-card" id="ajEmailCard">

                            <input type="checkbox" id="ajEmailMethod"
                                   name="method" value="email" checked>

                            <span class="aj-method-icon email">
                                <i class="fa-regular fa-envelope"></i>
                            </span>

                            <span class="aj-method-content">
                                <strong>Apply via Email</strong>
                                <small>Apply using the employer's configured email.</small>
                                <span class="aj-method-status">Enabled</span>
                            </span>

                        </label>

                    </div>
                </section>

                <div class="aj-divider"></div>

                <!-- OPTIONAL MESSAGE -->
                <section class="aj-section">

                    <div class="aj-section-title">
                        <span class="aj-title-icon">
                            <i class="fa-regular fa-message"></i>
                        </span>

                        <div>
                            <h3>Message to Employer</h3>
                            <p>Optional</p>
                        </div>
                    </div>

                    <div class="aj-field">

                        <textarea id="ajMessage" name="message"
                                  rows="4" maxlength="1000"
                                  placeholder="Briefly introduce yourself or mention your relevant experience."></textarea>

                        <div class="aj-textarea-footer">
                            <span>Keep your message short and professional.</span>
                            <span><b id="ajMessageCount">0</b>/1000</span>
                        </div>

                    </div>
                </section>

                <div class="aj-divider"></div>

                <!-- CONFIRMATION -->
                <div class="aj-confirmation">
                    <input type="checkbox" id="ajConfirm"
                           name="confirmation" required>

                    <label for="ajConfirm">
                        I confirm that the information provided is correct.
                    </label>
                </div>

                <p id="ajFormError" class="aj-form-error"
                   role="alert" hidden></p>

                <!-- FORM ACTIONS -->
                <div class="aj-submit-row">

                    <a href="jobs-home.php" class="aj-back-link">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to Jobs
                    </a>

                    <button type="submit" id="ajSubmitButton"
                            class="aj-submit-btn">
                        Submit Application
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>

                </div>

                <p class="aj-privacy-note">
                    <i class="fa-solid fa-lock"></i>
                    Your information should only be shared through authorized application channels.
                </p>

            </form>
        </section>


        <!-- RIGHT SIDEBAR -->
        <aside class="aj-sidebar">

            <div class="aj-sidebar-card aj-tips-card">

                <span class="aj-sidebar-icon">
                    <i class="fa-solid fa-lightbulb"></i>
                </span>

                <h3>Before You Apply</h3>

                <ul>
                    <li>Verify your contact details.</li>
                    <li>Upload your latest resume.</li>
                    <li>Check the job closing date.</li>
                    <li>Highlight your relevant experience.</li>
                </ul>

            </div>

            <div class="aj-sidebar-card aj-help-card">

                <span class="aj-sidebar-icon">
                    <i class="fa-solid fa-headset"></i>
                </span>

                <h3>Need Assistance?</h3>

                <p>
                    Our support team can help with questions about the application process.
                </p>

                <a href="mailto:info@peoplelink.com">
                    Contact Support
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

            </div>

        </aside>

    </div>


    <!-- APPLICATION SUCCESS DIALOG -->
    <div class="aj-success-overlay" id="ajSuccessOverlay" hidden>

        <section class="aj-success-dialog"
                 role="dialog"
                 aria-modal="true"
                 aria-labelledby="ajSuccessTitle">

            <span class="aj-success-icon">
                <i class="fa-solid fa-check"></i>
            </span>

            <h2 id="ajSuccessTitle">
                Application Submitted Successfully
            </h2>

            <p id="ajSuccessMessage"></p>

            <div class="aj-reference-box">
                <span>Application Reference</span>
                <strong id="ajApplicationReference"></strong>
            </div>

            <div class="aj-success-actions">

                <a href="my-applications.php" class="aj-success-primary">
                    View My Applications
                </a>

                <a href="jobs-home.php" class="aj-success-secondary">
                    Back to Jobs
                </a>

            </div>

        </section>
    </div>

</main>


<!-- =====================================================
     PEOPLELINK FOOTER
====================================================== -->

<!-- FOOTER MAIN -->
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


            <!-- PEOPLELINK LINKS -->
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


            <!-- COMMUNITY LINKS -->
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


            <!-- SUPPORT LINKS -->
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

                <a href="mailto:info@peoplelink.com" class="pl-contact-item">

                    <div class="pl-contact-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div>
                        <span>Email</span>
                        <strong>info@peoplelink.com</strong>
                    </div>

                </a>

                <a href="tel:+910000000000" class="pl-contact-item">

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
<?= web_js_boot() ?><script>window.AJ_JOB=<?= json_encode($ajJob, JSON_HEX_TAG | JSON_HEX_AMP) ?>;window.AJ_PROFILE=<?= json_encode($ajProfile, JSON_HEX_TAG | JSON_HEX_AMP) ?>;</script><script src="apply-to-job.js?v=2"></script>

<!-- FOOTER YEAR AND BACK-TO-TOP FALLBACK -->
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