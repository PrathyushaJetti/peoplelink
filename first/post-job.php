<?php include 'header.php'; ?>

<div class="pl-post-job-page">

    <!-- PAGE INTRO -->
    <div class="pl-post-job-container">

        <div class="pl-post-job-intro">
            <div>
                <span class="pl-form-badge">
                    <i class="bi bi-briefcase-fill"></i>
                    PeopleLink Jobs
                </span>

                <h1>Post a Job</h1>

                <p>
                    Share an Opportunity With the Right Candidates
                </p>

                <div class="pl-intro-text">
                    Employers, authorised members and approved users can submit
                    job opportunities through PeopleLink.
                </div>
            </div>

            <div class="pl-intro-side">
                <div class="pl-intro-side-icon">
                    <i class="bi bi-person-workspace"></i>
                </div>

                <strong>Find the Right Talent</strong>

                <span>
                    Connect genuine opportunities with suitable candidates.
                </span>
            </div>
        </div>


        <!-- ONE PREMIUM FORM -->
        <form id="postJobForm"
              class="pl-job-main-form"
              method="POST"
              enctype="multipart/form-data">


            <!-- FORM HEADER -->

            <div class="pl-form-top">

                <div>
                    <span class="pl-form-top-label">
                        JOB POSTING FORM
                    </span>

                    <h2>
                        Create Your Job Opportunity
                    </h2>

                    <p>
                        Complete the details below to submit your job for
                        PeopleLink approval.
                    </p>
                </div>

                <div class="pl-form-security">
                    <i class="bi bi-shield-check"></i>
                    <span>Secure Submission</span>
                </div>

            </div>


            <!-- JOB VISIBILITY -->

            <div class="pl-form-block">

                <div class="pl-form-block-title">
                    <div class="pl-form-block-icon blue">
                        <i class="bi bi-globe2"></i>
                    </div>

                    <div>
                        <h3>Job Visibility</h3>
                        <p>
                            Select where this opportunity should be visible.
                        </p>
                    </div>
                </div>


                <div class="pl-visibility-options">

                    <label class="pl-visibility-card active">

                        <input type="radio"
                               name="job_visibility"
                               value="community"
                               checked>

                        <div class="pl-visibility-check">
                            <i class="bi bi-check"></i>
                        </div>

                        <div class="pl-visibility-icon community">
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <div>
                            <strong>Community Job</strong>

                            <span>
                                Visible within the selected community.
                            </span>
                        </div>

                    </label>


                    <label class="pl-visibility-card">

                        <input type="radio"
                               name="job_visibility"
                               value="global">

                        <div class="pl-visibility-check">
                            <i class="bi bi-check"></i>
                        </div>

                        <div class="pl-visibility-icon global">
                            <i class="bi bi-globe2"></i>
                        </div>

                        <div>
                            <strong>Global Job</strong>

                            <span>
                                Visible across the PeopleLink platform
                                according to the approved package.
                            </span>
                        </div>

                    </label>

                </div>

            </div>


            <!-- COMPANY DETAILS -->

            <div class="pl-form-block">

                <div class="pl-form-block-title">

                    <div class="pl-form-block-icon green">
                        <i class="bi bi-building"></i>
                    </div>

                    <div>
                        <h3>Company / Organisation</h3>

                        <p>
                            Enter the employer information.
                        </p>
                    </div>

                </div>


                <div class="pl-fields-grid">

                    <div class="pl-field">

                        <label>
                            Company / Organisation Name
                            <b>*</b>
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-building"></i>

                            <input type="text"
                                   name="company_name"
                                   placeholder="Enter company or organisation name"
                                   required>

                        </div>

                    </div>


                    <div class="pl-field">

                        <label>
                            Industry / Business Category
                            <b>*</b>
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-diagram-3"></i>

                            <input type="text"
                                   name="industry"
                                   placeholder="e.g. IT, Education, Healthcare"
                                   required>

                        </div>

                    </div>


                    <div class="pl-field">

                        <label>
                            Company Location
                            <b>*</b>
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-geo-alt"></i>

                            <input type="text"
                                   name="company_location"
                                   placeholder="City, State, Country"
                                   required>

                        </div>

                    </div>


                    <div class="pl-field">

                        <label>
                            Website
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-globe"></i>

                            <input type="url"
                                   name="company_website"
                                   placeholder="https://example.com">

                        </div>

                    </div>


                    <div class="pl-field full">

                        <label>
                            Company Description
                        </label>

                        <textarea name="company_description"
                                  placeholder="Tell candidates about your company or organisation"></textarea>

                    </div>


                    <div class="pl-field">

                        <label>
                            Recruiter / Contact Person Name
                            <b>*</b>
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-person"></i>

                            <input type="text"
                                   name="recruiter_name"
                                   placeholder="Enter contact person name"
                                   required>

                        </div>

                    </div>

                </div>

            </div>


            <!-- JOB INFORMATION -->

            <div class="pl-form-block">

                <div class="pl-form-block-title">

                    <div class="pl-form-block-icon orange">
                        <i class="bi bi-briefcase"></i>
                    </div>

                    <div>
                        <h3>Job Information</h3>

                        <p>
                            Provide complete details about the opportunity.
                        </p>
                    </div>

                </div>


                <div class="pl-fields-grid">

                    <div class="pl-field">

                        <label>
                            Job Title
                            <b>*</b>
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-briefcase"></i>

                            <input type="text"
                                   name="job_title"
                                   placeholder="e.g. Senior PHP Developer"
                                   required>

                        </div>

                    </div>


                    <div class="pl-field">

                        <label>
                            Job Category
                            <b>*</b>
                        </label>

                        <select name="job_category" required>

                            <option value="">
                                Select Job Category
                            </option>

                            <option>Information Technology</option>
                            <option>Sales & Marketing</option>
                            <option>Education</option>
                            <option>Healthcare</option>
                            <option>Finance & Accounting</option>
                            <option>Engineering</option>
                            <option>Administration</option>
                            <option>Other</option>

                        </select>

                    </div>


                    <div class="pl-field">

                        <label>
                            Employment Type
                            <b>*</b>
                        </label>

                        <select name="employment_type" required>

                            <option value="">
                                Select Employment Type
                            </option>

                            <option>Full Time</option>
                            <option>Part Time</option>
                            <option>Contract</option>
                            <option>Internship</option>
                            <option>Freelance</option>

                        </select>

                    </div>


                    <div class="pl-field">

                        <label>
                            Number of Openings
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-people"></i>

                            <input type="number"
                                   name="openings"
                                   min="1"
                                   placeholder="e.g. 5">

                        </div>

                    </div>


                    <div class="pl-field">

                        <label>
                            Job Location
                            <b>*</b>
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-geo-alt"></i>

                            <input type="text"
                                   name="job_location"
                                   placeholder="Enter job location"
                                   required>

                        </div>

                    </div>


                    <div class="pl-field">

                        <label>
                            Work Mode
                            <b>*</b>
                        </label>

                        <select name="work_mode" required>

                            <option value="">
                                Select Work Mode
                            </option>

                            <option>Office</option>
                            <option>Hybrid</option>
                            <option>Remote</option>

                        </select>

                    </div>


                    <div class="pl-field">

                        <label>
                            Experience Required
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-award"></i>

                            <input type="text"
                                   name="experience"
                                   placeholder="e.g. 2–5 Years">

                        </div>

                    </div>


                    <div class="pl-field">

                        <label>
                            Qualification
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-mortarboard"></i>

                            <input type="text"
                                   name="qualification"
                                   placeholder="e.g. B.Tech / MBA">

                        </div>

                    </div>


                    <div class="pl-field">

                        <label>
                            Required Skills
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-lightning"></i>

                            <input type="text"
                                   name="skills"
                                   placeholder="PHP, MySQL, JavaScript...">

                        </div>

                    </div>


                    <div class="pl-field">

                        <label>
                            Salary / Compensation
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-currency-rupee"></i>

                            <input type="text"
                                   name="salary"
                                   placeholder="e.g. ₹25,000 – ₹50,000">

                        </div>

                    </div>


                    <div class="pl-field full">

                        <label>
                            Job Description
                            <b>*</b>
                        </label>

                        <textarea name="job_description"
                                  placeholder="Describe the opportunity, department and position"
                                  required></textarea>

                    </div>


                    <div class="pl-field full">

                        <label>
                            Roles & Responsibilities
                        </label>

                        <textarea name="responsibilities"
                                  placeholder="List the key responsibilities for this position"></textarea>

                    </div>


                    <div class="pl-field">

                        <label>
                            Application Closing Date
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-calendar-event"></i>

                            <input type="date"
                                   name="closing_date">

                        </div>

                    </div>

                </div>

            </div>


            <!-- CANDIDATE REQUIREMENTS -->

            <div class="pl-form-block">

                <div class="pl-form-block-title">

                    <div class="pl-form-block-icon purple">
                        <i class="bi bi-person-check"></i>
                    </div>

                    <div>
                        <h3>Candidate Requirements</h3>

                        <p>
                            Select the job-relevant criteria required from
                            candidates.
                        </p>
                    </div>

                </div>


                <div class="pl-requirement-list">

                    <label>
                        <input type="checkbox"
                               name="criteria[]"
                               value="Education">

                        <span>
                            <i class="bi bi-mortarboard"></i>
                            Education
                        </span>
                    </label>


                    <label>
                        <input type="checkbox"
                               name="criteria[]"
                               value="Experience">

                        <span>
                            <i class="bi bi-award"></i>
                            Experience
                        </span>
                    </label>


                    <label>
                        <input type="checkbox"
                               name="criteria[]"
                               value="Skills">

                        <span>
                            <i class="bi bi-lightning"></i>
                            Skills
                        </span>
                    </label>


                    <label>
                        <input type="checkbox"
                               name="criteria[]"
                               value="Location">

                        <span>
                            <i class="bi bi-geo-alt"></i>
                            Location
                        </span>
                    </label>


                    <label>
                        <input type="checkbox"
                               name="criteria[]"
                               value="Languages">

                        <span>
                            <i class="bi bi-translate"></i>
                            Languages
                        </span>
                    </label>


                    <label>
                        <input type="checkbox"
                               name="criteria[]"
                               value="Certifications">

                        <span>
                            <i class="bi bi-patch-check"></i>
                            Certifications
                        </span>
                    </label>


                    <label>
                        <input type="checkbox"
                               name="criteria[]"
                               value="Other">

                        <span>
                            <i class="bi bi-plus-circle"></i>
                            Other Job-Specific Requirements
                        </span>
                    </label>

                </div>

            </div>


            <!-- APPLICATION METHOD -->

            <div class="pl-form-block">

                <div class="pl-form-block-title">

                    <div class="pl-form-block-icon whatsapp">
                        <i class="bi bi-send"></i>
                    </div>

                    <div>
                        <h3>Application Method</h3>

                        <p>
                            Configure how candidates can apply for this job.
                        </p>
                    </div>

                </div>


                <div class="pl-application-options">

                    <div class="pl-application-option">

                        <div class="pl-application-option-icon whatsapp">
                            <i class="bi bi-whatsapp"></i>
                        </div>

                        <div class="pl-application-option-content">

                            <strong>
                                Apply via WhatsApp
                            </strong>

                            <span>
                                Applicants can send a message through the
                                configured WhatsApp workflow.
                            </span>

                        </div>

                        <label class="pl-toggle">

                            <input type="checkbox"
                                   name="enable_whatsapp">

                            <span></span>

                        </label>

                    </div>


                    <div class="pl-application-option">

                        <div class="pl-application-option-icon email">
                            <i class="bi bi-envelope-fill"></i>
                        </div>

                        <div class="pl-application-option-content">

                            <strong>
                                Resume by Email
                            </strong>

                            <span>
                                Applicants can send their resume to the
                                configured email address.
                            </span>

                        </div>

                        <label class="pl-toggle">

                            <input type="checkbox"
                                   name="enable_email">

                            <span></span>

                        </label>

                    </div>

                </div>


                <div class="pl-fields-grid pl-application-fields">

                    <div class="pl-field">

                        <label>
                            Application WhatsApp Number
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-whatsapp"></i>

                            <input type="tel"
                                   name="whatsapp_number"
                                   placeholder="Enter WhatsApp number">

                        </div>

                    </div>


                    <div class="pl-field">

                        <label>
                            Resume Email
                        </label>

                        <div class="pl-input">

                            <i class="bi bi-envelope"></i>

                            <input type="email"
                                   name="resume_email"
                                   placeholder="recruitment@example.com">

                        </div>

                    </div>

                </div>

            </div>


            <!-- COMMUNITY -->

            <div class="pl-form-block">

                <div class="pl-form-block-title">

                    <div class="pl-form-block-icon blue">
                        <i class="bi bi-people"></i>
                    </div>

                    <div>

                        <h3>Community & Global Visibility</h3>

                        <p>
                            Choose the applicable community or global package.
                        </p>

                    </div>

                </div>


                <div class="pl-fields-grid">

                    <div class="pl-field">

                        <label>
                            Select Community
                        </label>

                        <select name="community">

                            <option value="">
                                Select Community
                            </option>

                            <option>Arya Vysya</option>
                            <option>Reddy</option>
                            <option>Kamma</option>
                            <option>Kapu</option>
                            <option>Banjara</option>
                            <option>Yadava</option>
                            <option>Padmashali</option>
                            <option>Goud</option>
                            <option>Chakali</option>
                            <option>Mudiraj</option>
                            <option>Viswakarma</option>
                            <option>Other Communities</option>

                        </select>

                    </div>

                </div>


                <div class="pl-global-info">

                    <i class="bi bi-globe2"></i>

                    <div>

                        <strong>
                            Global Job
                        </strong>

                        <p>
                            For Global Jobs, the listing will be visible
                            across eligible PeopleLink users based on the
                            selected Global Job Package.
                        </p>

                    </div>

                </div>


                <div class="pl-package-box">

                    <div>

                        <span>
                            GLOBAL JOB PACKAGE
                        </span>

                        <strong>
                            Packages may differ based on:
                        </strong>

                    </div>

                    <div class="pl-package-items">

                        <span>
                            <i class="bi bi-briefcase"></i>
                            Job Posts
                        </span>

                        <span>
                            <i class="bi bi-calendar-check"></i>
                            Validity
                        </span>

                        <span>
                            <i class="bi bi-star"></i>
                            Featured Placement
                        </span>

                        <span>
                            <i class="bi bi-eye"></i>
                            Visibility Period
                        </span>

                        <span>
                            <i class="bi bi-plus-circle"></i>
                            Other Benefits
                        </span>

                    </div>

                    <a href="#"
                       class="pl-view-packages">
                        View Global Job Packages
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>


            <!-- SUPPORTING DOCUMENTS -->

            <div class="pl-form-block">

                <div class="pl-form-block-title">

                    <div class="pl-form-block-icon red">
                        <i class="bi bi-paperclip"></i>
                    </div>

                    <div>

                        <h3>Supporting Information</h3>

                        <p>
                            Upload approved company or hiring documents
                            where required.
                        </p>

                    </div>

                </div>


                <div class="pl-upload-grid">

                    <label class="pl-upload">

                        <input type="file"
                               name="company_logo"
                               accept=".jpg,.jpeg,.png,.webp">

                        <i class="bi bi-image"></i>

                        <strong>
                            Company Logo
                        </strong>

                        <span>
                            JPG, PNG, WEBP
                        </span>

                    </label>


                    <label class="pl-upload">

                        <input type="file"
                               name="job_brochure"
                               accept=".pdf,.doc,.docx">

                        <i class="bi bi-file-earmark-text"></i>

                        <strong>
                            Job Brochure
                        </strong>

                        <span>
                            PDF, DOC, DOCX
                        </span>

                    </label>


                    <label class="pl-upload">

                        <input type="file"
                               name="hiring_poster"
                               accept=".jpg,.jpeg,.png,.webp,.pdf">

                        <i class="bi bi-file-earmark-image"></i>

                        <strong>
                            Hiring Poster
                        </strong>

                        <span>
                            Image / PDF
                        </span>

                    </label>


                    <label class="pl-upload">

                        <input type="file"
                               name="other_document"
                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">

                        <i class="bi bi-file-earmark-plus"></i>

                        <strong>
                            Other Documents
                        </strong>

                        <span>
                            Approved documents
                        </span>

                    </label>

                </div>

            </div>


            <!-- PREVIEW -->

            <div class="pl-form-block">

                <div class="pl-form-block-title">

                    <div class="pl-form-block-icon green">
                        <i class="bi bi-eye"></i>
                    </div>

                    <div>

                        <h3>Preview Job</h3>

                        <p>
                            Review how the job will appear before submission.
                        </p>

                    </div>

                </div>


                <div class="pl-job-preview">

                    <div class="pl-job-preview-top">

                        <div class="pl-preview-company-icon">
                            <i class="bi bi-building"></i>
                        </div>

                        <div>

                            <span>
                                JOB OPPORTUNITY
                            </span>

                            <h3 id="previewJobTitle">
                                Your Job Title
                            </h3>

                            <p id="previewCompany">
                                Company / Organisation
                            </p>

                        </div>

                    </div>


                    <div class="pl-preview-meta">

                        <span>
                            <i class="bi bi-geo-alt"></i>
                            <b id="previewLocation">
                                Job Location
                            </b>
                        </span>

                        <span>
                            <i class="bi bi-briefcase"></i>
                            <b id="previewEmployment">
                                Employment Type
                            </b>
                        </span>

                        <span>
                            <i class="bi bi-house"></i>
                            <b id="previewMode">
                                Work Mode
                            </b>
                        </span>

                    </div>


                    <div class="pl-preview-description">

                        <strong>
                            Job Description
                        </strong>

                        <p id="previewDescription">
                            Your job description will appear here.
                        </p>

                    </div>

                </div>


                <button type="button"
                        id="previewButton"
                        class="pl-preview-button">

                    <i class="bi bi-eye"></i>
                    Preview Job

                </button>

            </div>


            <!-- FINAL SUBMISSION -->

            <div class="pl-form-submit">

                <div class="pl-submit-info">

                    <div class="pl-submit-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>

                        <strong>
                            Submit for Approval
                        </strong>

                        <span>
                            Your job will be reviewed by the authorised
                            Admin or Community Admin before publication.
                        </span>

                    </div>

                </div>


                <div class="pl-submit-status">

                    <span>
                        <i class="bi bi-circle-fill"></i>
                        Draft
                    </span>

                    <span>
                        <i class="bi bi-circle-fill"></i>
                        Pending Approval
                    </span>

                    <span>
                        <i class="bi bi-circle-fill"></i>
                        Approved
                    </span>

                    <span>
                        <i class="bi bi-circle-fill"></i>
                        Requires Changes
                    </span>

                </div>


                <button type="submit"
                        class="pl-submit-button">

                    <i class="bi bi-send-fill"></i>

                    Submit Job

                </button>

            </div>

        </form>


        <!-- BOTTOM LINKS -->

        <div class="pl-job-bottom">

            <a href="#">
                <i class="bi bi-briefcase"></i>
                My Job Posts
            </a>

            <a href="#">
                <i class="bi bi-box-seam"></i>
                View Packages
            </a>

        </div>

    </div>

</div>

 


<?php include 'footer.php'; ?>