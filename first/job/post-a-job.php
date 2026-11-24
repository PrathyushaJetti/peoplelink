<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$errors = [];
$success = false;
$submittedJob = null;

// Keep your existing PHP form-submission logic below.
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
        href="post-a-job.css"
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

<main class="pl-post-job">
    <section class="pj-hero">
        <div class="pj-container pj-hero-inner">
            <div>
                <span class="pj-eyebrow"><i class="fa-solid fa-people-group"></i> PEOPLELINK CAREER NETWORK</span>
                <h1>Post a job. Find the right people.</h1>
                <p>Reach skilled professionals through your community or across the PeopleLink network.</p>
            </div>
            <div class="pj-hero-art" aria-hidden="true"><div class="pj-art-main"><i class="fa-solid fa-briefcase"></i></div><span class="pj-art-bubble one"><i class="fa-solid fa-user-check"></i></span><span class="pj-art-bubble two"><i class="fa-solid fa-bullhorn"></i></span></div>
        </div>
    </section>

    <div class="pj-container pj-page-content">
        <?php if ($success): ?>
            <section class="pj-success-card">
                <div class="pj-success-icon"><i class="fa-solid fa-check"></i></div>
                <span class="pj-section-kicker">JOB RECEIVED</span>
                <h2><?= !empty($_POST['save_draft']) ? 'Draft Saved Successfully' : 'Job Submitted Successfully' ?></h2>
                <p><strong><?= h($submittedJob['title']) ?></strong> at <?= h($submittedJob['company']) ?> has been <?= !empty($_POST['save_draft']) ? 'saved as a draft in this demo.' : 'submitted in this demo.' ?></p>
                <?php if (empty($_POST['save_draft'])): ?><div class="pj-review-note"><i class="fa-solid fa-shield-halved"></i><span>Your job is under review and will be published after approval.</span></div><?php endif; ?>
                <?php if ($submittedJob['visibility'] === 'global'): ?><div class="pj-review-note payment-note"><i class="fa-solid fa-credit-card"></i><span>A Global Job Package may be required. Connect your package/payment workflow to continue.</span></div><a href="global-job-packages.php" class="pj-btn pj-btn-primary">Proceed to Global Job Package / Payment <i class="fa-solid fa-arrow-right"></i></a><?php endif; ?>
                <div class="pj-success-actions"><a class="pj-btn pj-btn-outline" href="post-a-job.php">Post Another Job</a><a class="pj-btn pj-btn-primary" href="my-posted-jobs.php">View My Posted Jobs</a></div>
            </section>
        <?php else: ?>
            <?php if ($errors): ?><div class="pj-errors"><strong>Please review the following:</strong><ul><?php foreach ($errors as $error): ?><li><?= h($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

            <div class="pj-form-heading">
                <div><span class="pj-section-kicker">EMPLOYER WORKSPACE</span><h2>Post a Job</h2><p>Complete the details below. You can preview your listing before submitting it.</p></div>
                <div class="pj-step-note"><i class="fa-solid fa-lock"></i> Your contact details stay in the application workflow</div>
            </div>

            <form id="postJobForm" method="post" enctype="multipart/form-data" action="">
                <section class="pj-form-card">
                    <div class="pj-card-heading"><span class="pj-card-icon"><i class="fa-solid fa-eye"></i></span><div><h3>Job Visibility</h3><p>Choose who can discover this opportunity.</p></div></div>
                    <div class="pj-visibility-options">
                        <label class="pj-visibility-option active" data-visibility-card="community"><input type="radio" name="visibility" value="community" checked><span class="pj-radio-mark"></span><span class="pj-visibility-symbol"><i class="fa-solid fa-people-group"></i></span><span class="pj-visibility-copy"><strong>Community Job</strong><small>Visible to your selected community.</small></span><span class="pj-visibility-check"><i class="fa-solid fa-circle-check"></i></span></label>
                        <label class="pj-visibility-option" data-visibility-card="global"><input type="radio" name="visibility" value="global"><span class="pj-radio-mark"></span><span class="pj-visibility-symbol global"><i class="fa-solid fa-earth-asia"></i></span><span class="pj-visibility-copy"><strong>Global Job</strong><small>Visible across the PeopleLink network.</small></span><span class="pj-visibility-check"><i class="fa-solid fa-circle-check"></i></span></label>
                    </div>
                    <div class="pj-conditional-grid" id="communityFields">
                        <div class="pj-field"><label for="community_id">Selected Community <span>*</span></label><select id="community_id" name="community_id"><option value="">Select community</option><option>Arya Vysya</option><option>Reddy</option><option>Kamma</option><option>Kapu</option><option>Banjara</option><option>Yadava</option><option>Padmashali</option><option>Goud</option><option>Chakali</option><option>Mudiraj</option><option>Viswakarma</option><option>Other Communities</option></select><small>Community name is displayed on the job listing where applicable.</small></div>
                        <div class="pj-community-preview"><i class="fa-solid fa-users"></i><span>Community label preview<strong id="communityNamePreview">Select a community</strong></span></div>
                    </div>
                    <div class="pj-global-notice" id="globalNotice" hidden><i class="fa-solid fa-earth-asia"></i><div><strong>Global visibility selected</strong><p>This job can appear across PeopleLink. A Global Job Package may be required before publication.</p></div></div>
                </section>

                <section class="pj-form-card">
                    <div class="pj-card-heading"><span class="pj-card-icon"><i class="fa-solid fa-briefcase"></i></span><div><h3>Basic Job Information</h3><p>Share the essential details candidates need.</p></div></div>
                    <div class="pj-form-grid">
                        <div class="pj-field span-2"><label for="job_title">Job Title <span>*</span></label><input id="job_title" name="job_title" required placeholder="e.g. PHP Web Developer"></div>
                        <div class="pj-field"><label for="company_name">Company / Organisation Name <span>*</span></label><input id="company_name" name="company_name" required placeholder="Enter organisation name"></div>
                        <div class="pj-field"><label for="job_category">Job Category <span>*</span></label><select id="job_category" name="job_category" required><option value="">Select category</option><option>Information Technology</option><option>Sales & Marketing</option><option>Accounting & Finance</option><option>Education</option><option>Healthcare</option><option>Engineering</option><option>Customer Support</option><option>Operations</option><option>Design & Creative</option><option>Other</option></select></div>
                        <div class="pj-field"><label for="openings">Number of Openings <span>*</span></label><input id="openings" name="openings" type="number" min="1" value="1" required></div>
                        <div class="pj-field"><label for="employment_type">Employment Type <span>*</span></label><select id="employment_type" name="employment_type" required><option value="">Select type</option><option>Full Time</option><option>Part Time</option><option>Contract</option><option>Temporary</option><option>Internship</option><option>Freelance</option></select></div>
                        <div class="pj-field"><label for="work_mode">Work Mode <span>*</span></label><select id="work_mode" name="work_mode" required><option value="">Select mode</option><option>On-site</option><option>Hybrid</option><option>Remote</option></select></div>
                        <div class="pj-field"><label for="job_location">Job Location <span>*</span></label><input id="job_location" name="job_location" required placeholder="City, State or Remote"></div>
                        <div class="pj-field"><label for="salary_min">Minimum Salary (₹ / month)</label><input id="salary_min" name="salary_min" type="number" min="0" placeholder="e.g. 18000"></div>
                        <div class="pj-field"><label for="salary_max">Maximum Salary (₹ / month)</label><input id="salary_max" name="salary_max" type="number" min="0" placeholder="e.g. 35000"></div>
                        <div class="pj-field"><label for="experience">Experience Required <span>*</span></label><select id="experience" name="experience" required><option value="">Select experience</option><option>Fresher</option><option>0–1 Years</option><option>1–3 Years</option><option>3–5 Years</option><option>5–8 Years</option><option>8+ Years</option></select></div>
                        <div class="pj-field"><label for="qualification">Qualification Required <span>*</span></label><input id="qualification" name="qualification" required placeholder="e.g. BCA / Any Graduate"></div>
                        <div class="pj-field span-2"><label for="skills_required">Skills Required <span>*</span></label><input id="skills_required" name="skills_required" required placeholder="Enter skills separated by commas"><small>Example: PHP, MySQL, HTML, CSS, JavaScript</small></div>
                    </div>
                </section>

                <section class="pj-form-card">
                    <div class="pj-card-heading"><span class="pj-card-icon purple"><i class="fa-solid fa-align-left"></i></span><div><h3>Job Description</h3><p>Explain the role, responsibilities and expectations.</p></div></div>
                    <div class="pj-form-grid">
                        <div class="pj-field span-2"><label for="job_summary">Job Role / Summary <span>*</span></label><textarea id="job_summary" name="job_summary" rows="3" required placeholder="Briefly explain the purpose of this role"></textarea></div>
                        <div class="pj-field span-2"><label for="responsibilities">Key Responsibilities <span>*</span></label><textarea id="responsibilities" name="responsibilities" rows="4" required placeholder="Add each responsibility on a new line"></textarea></div>
                        <div class="pj-field"><label for="required_skills">Required Skills</label><textarea id="required_skills" name="required_skills" rows="3" placeholder="Core skills candidates must have"></textarea></div>
                        <div class="pj-field"><label for="preferred_skills">Preferred Skills</label><textarea id="preferred_skills" name="preferred_skills" rows="3" placeholder="Additional useful skills"></textarea></div>
                        <div class="pj-field span-2"><label for="additional_requirements">Additional Requirements</label><textarea id="additional_requirements" name="additional_requirements" rows="3" placeholder="Certifications, travel, language or other requirements"></textarea></div>
                        <div class="pj-field"><label for="joining_availability">Joining Availability</label><select id="joining_availability" name="joining_availability"><option value="">Select availability</option><option>Immediately</option><option>Within 15 days</option><option>Within 30 days</option><option>Within 60 days</option><option>Negotiable</option></select></div>
                    </div>
                </section>

                <section class="pj-form-card">
                    <div class="pj-card-heading"><span class="pj-card-icon green"><i class="fa-solid fa-building"></i></span><div><h3>Company Details</h3><p>Give candidates a little context about your organisation.</p></div></div>
                    <div class="pj-form-grid">
                        <div class="pj-field span-2"><label for="company_logo">Company Logo</label><div class="pj-upload-box"><i class="fa-regular fa-image"></i><div><strong>Upload company logo</strong><small>PNG, JPG or WEBP · Recommended square image</small><input id="company_logo" name="company_logo" type="file" accept=".png,.jpg,.jpeg,.webp,image/png,image/jpeg,image/webp"><span id="logoFileName">No logo selected</span></div><img id="logoPreview" alt="Company logo preview" hidden></div></div>
                        <div class="pj-field"><label for="industry">Industry</label><input id="industry" name="industry" placeholder="e.g. Information Technology"></div>
                        <div class="pj-field"><label for="company_website">Company Website</label><input id="company_website" name="company_website" type="url" placeholder="https://example.com"></div>
                        <div class="pj-field"><label for="company_location">Company Location</label><input id="company_location" name="company_location" placeholder="City, State"></div>
                        <div class="pj-field span-2"><label for="company_description">Short Company Description</label><textarea id="company_description" name="company_description" rows="3" placeholder="Tell candidates about your company"></textarea></div>
                    </div>
                </section>

                <section class="pj-form-card">
                    <div class="pj-card-heading"><span class="pj-card-icon orange"><i class="fa-solid fa-paper-plane"></i></span><div><h3>Application Method</h3><p>Select at least one way candidates can contact you.</p></div></div>
                    <div class="pj-method-options">
                        <label class="pj-method-option"><input type="checkbox" name="application_method[]" value="whatsapp" id="methodWhatsapp"><span class="pj-method-icon whatsapp"><i class="fa-brands fa-whatsapp"></i></span><span><strong>WhatsApp Application</strong><small>Use the configured WhatsApp contact workflow.</small></span></label>
                        <label class="pj-method-option"><input type="checkbox" name="application_method[]" value="email" id="methodEmail" checked><span class="pj-method-icon email"><i class="fa-regular fa-envelope"></i></span><span><strong>Email Application</strong><small>Receive resumes at your configured email address.</small></span></label>
                    </div>
                    <div class="pj-form-grid pj-method-fields">
                        <div class="pj-field" id="whatsappNumberField" hidden><label for="application_whatsapp">WhatsApp Number</label><input id="application_whatsapp" name="application_whatsapp" type="tel" placeholder="Country code + mobile number"></div>
                        <div class="pj-field" id="applicationEmailField"><label for="application_email">Application Email</label><input id="application_email" name="application_email" type="email" placeholder="careers@example.com"></div>
                    </div>
                </section>

                <section class="pj-form-card">
                    <div class="pj-card-heading"><span class="pj-card-icon"><i class="fa-solid fa-address-card"></i></span><div><h3>Contact Details</h3><p>Used for verification and your chosen application workflow.</p></div></div>
                    <div class="pj-form-grid">
                        <div class="pj-field"><label for="contact_name">Contact Person Name <span>*</span></label><input id="contact_name" name="contact_name" required placeholder="Full name"></div>
                        <div class="pj-field"><label for="contact_mobile">Mobile Number <span>*</span></label><input id="contact_mobile" name="contact_mobile" type="tel" required placeholder="Contact mobile number"></div>
                        <div class="pj-field span-2"><label for="contact_email">Contact Email Address <span>*</span></label><input id="contact_email" name="contact_email" type="email" required placeholder="you@company.com"><small>Contact details do not have to be displayed publicly.</small></div>
                    </div>
                </section>

                <section class="pj-form-card">
                    <div class="pj-card-heading"><span class="pj-card-icon purple"><i class="fa-regular fa-calendar-days"></i></span><div><h3>Job Validity</h3><p>Set the period during which candidates can apply.</p></div></div>
                    <div class="pj-form-grid">
                        <div class="pj-field"><label for="application_start">Application Start Date</label><input type="date" id="application_start" name="application_start"></div>
                        <div class="pj-field"><label for="application_end">Application Closing Date</label><input type="date" id="application_end" name="application_end"></div>
                    </div>
                </section>

                <div class="pj-submit-bar">
                    <div class="pj-submit-note"><i class="fa-solid fa-circle-info"></i><span>Preview your listing before submitting. Jobs may require approval before publication.</span></div>
                    <div class="pj-submit-actions">
                        <button type="button" class="pj-btn pj-btn-outline" id="previewJob"><i class="fa-regular fa-eye"></i> Preview Job</button>
                        <button type="submit" class="pj-btn pj-btn-soft" name="save_draft" value="1"><i class="fa-regular fa-floppy-disk"></i> Save Draft</button>
                        <button type="submit" class="pj-btn pj-btn-primary" name="submit_job" value="1"><i class="fa-solid fa-paper-plane"></i> Submit Job</button>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>
</main>

<div class="pj-modal" id="previewModal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="previewTitle">
    <div class="pj-modal-backdrop" data-close-preview></div>
    <div class="pj-modal-dialog">
        <div class="pj-modal-header"><div><span class="pj-section-kicker">LISTING PREVIEW</span><h2 id="previewTitle">Preview Job</h2></div><button type="button" class="pj-modal-close" data-close-preview aria-label="Close preview"><i class="fa-solid fa-xmark"></i></button></div>
        <div class="pj-preview-body">
            <div class="pj-preview-company"><div class="pj-preview-logo" id="previewLogoMark">C</div><div><span id="previewVisibility" class="pj-preview-badge">Community Job</span><h3 id="previewJobTitle">Job Title</h3><p id="previewCompany">Company Name</p></div></div>
            <div class="pj-preview-meta"><span><i class="fa-solid fa-location-dot"></i><b id="previewLocation">Location</b></span><span><i class="fa-solid fa-clock"></i><b id="previewType">Employment Type</b></span><span><i class="fa-solid fa-laptop"></i><b id="previewMode">Work Mode</b></span><span><i class="fa-solid fa-briefcase"></i><b id="previewExperience">Experience</b></span></div>
            <div class="pj-preview-salary" id="previewSalary">Salary not disclosed</div>
            <div class="pj-preview-block"><h4>Job Summary</h4><p id="previewSummary">Your job summary will appear here.</p></div>
            <div class="pj-preview-block"><h4>Responsibilities</h4><p id="previewResponsibilities">Your responsibilities will appear here.</p></div>
            <div class="pj-preview-block"><h4>Skills Required</h4><p id="previewSkills">Your required skills will appear here.</p></div>
            <div class="pj-preview-block"><h4>Community</h4><p id="previewCommunity">Not applicable</p></div>
        </div>
        <div class="pj-modal-footer"><button type="button" class="pj-btn pj-btn-outline" data-close-preview>Continue Editing</button><button type="button" class="pj-btn pj-btn-primary" id="previewSubmit">Looks Good — Submit</button></div>
    </div>
</div>

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
<script src="post-a-job.js"></script>
<script src="js/jobs-global.js"></script>
</body>
</html>