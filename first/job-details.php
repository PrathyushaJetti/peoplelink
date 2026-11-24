<?php include('header.php'); ?>



<main class="pl-job-details" id="plJobDetails">

  <!-- Breadcrumb -->
  <div class="pl-jd-breadcrumb">
    <a href="index.php">Home</a>
    <i class="bi bi-chevron-right"></i>
    <a href="jobs.php">Jobs</a>
    <i class="bi bi-chevron-right"></i>
    <span>Job Details</span>
  </div>

  <!-- Job Hero -->
  <section class="pl-jd-hero">
    <div class="pl-jd-hero-glow"></div>

    <div class="pl-jd-hero-inner">
      <div class="pl-jd-company-mark" id="plJdCompanyMark">PL</div>

      <div class="pl-jd-hero-content">
        <div class="pl-jd-badges">
          <span class="pl-jd-visibility-badge" id="plJdVisibility">
            <i class="bi bi-globe2"></i> Global Job
          </span>
          <span class="pl-jd-status-badge">
            <i class="bi bi-check-circle-fill"></i> Active Opportunity
          </span>
        </div>

        <p class="pl-jd-eyebrow" id="plJdCategory">IT &amp; Software</p>
        <h1 id="plJdTitle">PHP Web Developer</h1>
        <p class="pl-jd-company-line">
          <i class="bi bi-building"></i>
          <span id="plJdCompany">Digital Solutions Group</span>
        </p>

        <div class="pl-jd-hero-meta">
          <span><i class="bi bi-geo-alt"></i><span id="plJdLocation">Remote / India</span></span>
          <span><i class="bi bi-briefcase"></i><span id="plJdExperience">1–2 years</span></span>
          <span><i class="bi bi-clock"></i><span id="plJdType">Full-time</span></span>
        </div>
      </div>

      <div class="pl-jd-hero-actions">
        <button class="pl-jd-btn pl-jd-btn-primary" type="button" id="plJdApplyTop">
          Apply for Job <i class="bi bi-arrow-up-right"></i>
        </button>
        <button class="pl-jd-btn pl-jd-btn-outline" type="button" id="plJdSaveTop">
          <i class="bi bi-bookmark"></i> <span>Save Job</span>
        </button>
      </div>
    </div>
  </section>

  <!-- Main layout -->
  <div class="pl-jd-layout">

    <!-- Main content -->
    <div class="pl-jd-main-column">

      <!-- Job overview -->
      <section class="pl-jd-card pl-jd-overview">
        <div class="pl-jd-section-heading">
          <div>
            <span class="pl-jd-section-kicker">THE OPPORTUNITY</span>
            <h2>Job Overview</h2>
          </div>
          <span class="pl-jd-job-id" id="plJdJobId">JOB-PL-101</span>
        </div>

        <div class="pl-jd-overview-grid">
          <div class="pl-jd-overview-item">
            <span class="pl-jd-overview-icon"><i class="bi bi-grid"></i></span>
            <div><small>Job Category</small><strong id="plJdOverviewCategory">IT &amp; Software</strong></div>
          </div>
          <div class="pl-jd-overview-item">
            <span class="pl-jd-overview-icon"><i class="bi bi-geo-alt"></i></span>
            <div><small>Location</small><strong id="plJdOverviewLocation">Remote / India</strong></div>
          </div>
          <div class="pl-jd-overview-item">
            <span class="pl-jd-overview-icon"><i class="bi bi-briefcase"></i></span>
            <div><small>Experience</small><strong id="plJdOverviewExperience">1–2 years</strong></div>
          </div>
          <div class="pl-jd-overview-item">
            <span class="pl-jd-overview-icon"><i class="bi bi-mortarboard"></i></span>
            <div><small>Qualification</small><strong id="plJdQualification">Graduate</strong></div>
          </div>
          <div class="pl-jd-overview-item">
            <span class="pl-jd-overview-icon"><i class="bi bi-cash-stack"></i></span>
            <div><small>Salary / Compensation</small><strong id="plJdSalary">₹3–5 LPA</strong></div>
          </div>
          <div class="pl-jd-overview-item">
            <span class="pl-jd-overview-icon"><i class="bi bi-people"></i></span>
            <div><small>Openings</small><strong id="plJdOpenings">2 Positions</strong></div>
          </div>
          <div class="pl-jd-overview-item">
            <span class="pl-jd-overview-icon"><i class="bi bi-calendar3"></i></span>
            <div><small>Posted Date</small><strong id="plJdPosted">1 Oct 2026</strong></div>
          </div>
          <div class="pl-jd-overview-item">
            <span class="pl-jd-overview-icon"><i class="bi bi-calendar-check"></i></span>
            <div><small>Apply Before</small><strong id="plJdClosing">31 Oct 2026</strong></div>
          </div>
        </div>
      </section>

      <!-- Description -->
      <section class="pl-jd-card">
        <div class="pl-jd-section-heading">
          <div>
            <span class="pl-jd-section-kicker">UNDERSTAND THE ROLE</span>
            <h2>Job Description</h2>
          </div>
          <i class="bi bi-file-earmark-text pl-jd-heading-icon"></i>
        </div>

        <p class="pl-jd-body-text" id="plJdSummary">
          We are looking for a motivated PHP Web Developer to help build, maintain and improve responsive websites and web applications.
        </p>

        <div class="pl-jd-content-block">
          <h3><i class="bi bi-list-check"></i> Key Responsibilities</h3>
          <ul class="pl-jd-check-list" id="plJdResponsibilities">
            <li>Develop and maintain responsive websites and web applications.</li>
            <li>Work with PHP, MySQL, JavaScript, HTML and CSS.</li>
            <li>Debug issues, improve performance and maintain code quality.</li>
            <li>Collaborate with team members on features and project delivery.</li>
          </ul>
        </div>

        <div class="pl-jd-content-block">
          <h3><i class="bi bi-laptop"></i> Working Conditions</h3>
          <p class="pl-jd-body-text" id="plJdWorkingConditions">
            Full-time role. Remote working arrangements and other conditions should be confirmed with the employer.
          </p>
        </div>

        <div class="pl-jd-content-block">
          <h3><i class="bi bi-info-circle"></i> Other Requirements</h3>
          <p class="pl-jd-body-text" id="plJdOtherRequirements">
            Candidates should be comfortable solving technical problems, communicating progress and working with project requirements.
          </p>
        </div>
      </section>

      <!-- Skills -->
      <section class="pl-jd-card">
        <div class="pl-jd-section-heading">
          <div>
            <span class="pl-jd-section-kicker">WHAT YOU WILL NEED</span>
            <h2>Key Skills</h2>
          </div>
          <i class="bi bi-lightning-charge pl-jd-heading-icon"></i>
        </div>
        <p class="pl-jd-body-text">Review the skills listed by the employer before submitting your application.</p>
        <div class="pl-jd-skills" id="plJdSkills">
          <span>PHP</span><span>MySQL</span><span>JavaScript</span><span>HTML &amp; CSS</span>
        </div>
      </section>

      <!-- Eligibility -->
      <section class="pl-jd-card">
        <div class="pl-jd-section-heading">
          <div>
            <span class="pl-jd-section-kicker">CHECK BEFORE APPLYING</span>
            <h2>Eligibility Requirements</h2>
          </div>
          <i class="bi bi-person-check pl-jd-heading-icon"></i>
        </div>

        <div class="pl-jd-eligibility-list" id="plJdEligibility">
          <div><i class="bi bi-check2-circle"></i><span><strong>Education</strong><small>Graduate or relevant qualification</small></span></div>
          <div><i class="bi bi-check2-circle"></i><span><strong>Experience</strong><small>1–2 years of relevant experience</small></span></div>
          <div><i class="bi bi-check2-circle"></i><span><strong>Location</strong><small>India / Remote, subject to employer policy</small></span></div>
          <div><i class="bi bi-check2-circle"></i><span><strong>Certifications</strong><small>Not specified by the employer</small></span></div>
          <div><i class="bi bi-check2-circle"></i><span><strong>Additional conditions</strong><small>Confirm role-specific requirements with the employer</small></span></div>
        </div>

        <div class="pl-jd-notice">
          <i class="bi bi-info-circle"></i>
          <p>Eligibility information is supplied by the employer. Please confirm any requirements that are important to your application.</p>
        </div>
      </section>

      <!-- Company -->
      <section class="pl-jd-card">
        <div class="pl-jd-section-heading">
          <div>
            <span class="pl-jd-section-kicker">YOUR POTENTIAL EMPLOYER</span>
            <h2>About the Company</h2>
          </div>
          <i class="bi bi-buildings pl-jd-heading-icon"></i>
        </div>

        <div class="pl-jd-company-profile">
          <div class="pl-jd-company-profile-mark" id="plJdAboutMark">PL</div>
          <div>
            <h3 id="plJdAboutCompany">Digital Solutions Group</h3>
            <p class="pl-jd-company-industry" id="plJdIndustry">Technology &amp; Digital Services</p>
            <p class="pl-jd-body-text" id="plJdCompanyDescription">
              Employer information and company details should be verified before applying.
            </p>
            <div class="pl-jd-company-links">
              <span><i class="bi bi-geo-alt"></i> <span id="plJdCompanyLocation">India</span></span>
              <a id="plJdCompanyWebsite" href="#" target="_blank" rel="noopener noreferrer" hidden>
                <i class="bi bi-globe"></i> Visit Website
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Similar jobs -->
      <section class="pl-jd-similar-section">
        <div class="pl-jd-section-heading">
          <div>
            <span class="pl-jd-section-kicker">MORE TO EXPLORE</span>
            <h2>Similar Jobs</h2>
            <p class="pl-jd-body-text">Explore other opportunities based on category, skills and location.</p>
          </div>
          <a href="jobs.php" class="pl-jd-text-link">All Jobs <i class="bi bi-arrow-up-right"></i></a>
        </div>
        <div class="pl-jd-similar-grid" id="plJdSimilarJobs"></div>
      </section>

    </div>

    <!-- Sidebar -->
    <aside class="pl-jd-sidebar">

      <section class="pl-jd-apply-card">
        <span class="pl-jd-sidebar-kicker"><i class="bi bi-send-check"></i> READY TO APPLY?</span>
        <h2>Take the next step in your career.</h2>
        <p>Review the job requirements and choose an application method configured for this opportunity.</p>

        <button class="pl-jd-btn pl-jd-btn-primary pl-jd-btn-wide" type="button" id="plJdApplyWhatsApp">
          <i class="bi bi-whatsapp"></i> Apply via WhatsApp
        </button>
        <button class="pl-jd-btn pl-jd-btn-email pl-jd-btn-wide" type="button" id="plJdApplyEmail">
          <i class="bi bi-envelope"></i> Send Resume by Email
        </button>
        <button class="pl-jd-btn pl-jd-btn-light pl-jd-btn-wide" type="button" id="plJdSaveSidebar">
          <i class="bi bi-bookmark"></i> <span>Save This Job</span>
        </button>

        <p class="pl-jd-apply-note"><i class="bi bi-shield-check"></i> Apply only through verified details provided for this job.</p>
      </section>

      <section class="pl-jd-card pl-jd-share-card">
        <h3><i class="bi bi-share"></i> Share This Job</h3>
        <p>Help someone discover this opportunity.</p>
        <div class="pl-jd-share-buttons">
          <button type="button" id="plJdShareNative" aria-label="Share job">
            <i class="bi bi-share-fill"></i>
          </button>
          <button type="button" id="plJdShareWhatsApp" aria-label="Share on WhatsApp">
            <i class="bi bi-whatsapp"></i>
          </button>
          <button type="button" id="plJdCopyLink" aria-label="Copy job link">
            <i class="bi bi-link-45deg"></i>
          </button>
        </div>
      </section>

      <section class="pl-jd-card pl-jd-safety-card">
        <span class="pl-jd-safety-icon"><i class="bi bi-shield-check"></i></span>
        <h3>Stay Job-Safe</h3>
        <p>Never pay a recruiter to secure a job. Verify the employer and offer before sharing sensitive information.</p>
        <button type="button" class="pl-jd-report-link" id="plJdOpenReport">
          <i class="bi bi-flag"></i> Report This Job
        </button>
      </section>

      <section class="pl-jd-visibility-card">
        <i class="bi bi-globe2"></i>
        <div>
          <strong id="plJdVisibilityTitle">Global Opportunity</strong>
          <p id="plJdVisibilityText">Visible across eligible communities according to PeopleLink access settings.</p>
        </div>
      </section>

    </aside>
  </div>

  <!-- Similar jobs link fallback -->
  <section class="pl-jd-bottom-cta">
    <div>
      <span>YOUR NEXT OPPORTUNITY STARTS HERE</span>
      <h2>Find more jobs that fit your goals.</h2>
      <p>Explore community-specific opportunities or discover jobs across the eligible PeopleLink network.</p>
    </div>
    <div class="pl-jd-bottom-actions">
      <a href="jobs.php" class="pl-jd-btn pl-jd-btn-primary">Explore Jobs <i class="bi bi-arrow-right"></i></a>
      <a href="community-jobs.php" class="pl-jd-btn pl-jd-btn-white">Community Jobs</a>
    </div>
  </section>

  <!-- Report Job Modal -->
  <div class="pl-jd-modal" id="plJdReportModal" hidden>
    <div class="pl-jd-modal-backdrop" data-jd-close></div>
    <div class="pl-jd-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="plJdReportTitle">
      <button type="button" class="pl-jd-modal-close" data-jd-close aria-label="Close report form">
        <i class="bi bi-x-lg"></i>
      </button>
      <span class="pl-jd-modal-icon"><i class="bi bi-flag"></i></span>
      <h2 id="plJdReportTitle">Report This Job</h2>
      <p>Tell the PeopleLink team why this listing needs to be reviewed.</p>

      <form id="plJdReportForm">
        <label for="plJdReportReason">Reason for report</label>
        <select id="plJdReportReason" name="reason" required>
          <option value="">Select a reason</option>
          <option value="incorrect">Incorrect job information</option>
          <option value="expired">Expired or closed vacancy</option>
          <option value="suspicious">Suspicious or potentially fraudulent listing</option>
          <option value="inappropriate">Inappropriate content</option>
          <option value="duplicate">Duplicate job listing</option>
          <option value="other">Other</option>
        </select>

        <label for="plJdReportMessage">Additional details</label>
        <textarea id="plJdReportMessage" name="message" rows="4" maxlength="1500"
          placeholder="Share details that may help the admin team review this listing."></textarea>

        <label for="plJdReporterEmail">Email (optional)</label>
        <input id="plJdReporterEmail" name="email" type="email" maxlength="190"
          placeholder="you@example.com">

        <button type="submit" class="pl-jd-btn pl-jd-btn-primary pl-jd-btn-wide">
          Submit Report <i class="bi bi-arrow-right"></i>
        </button>
        <p class="pl-jd-form-note">Demo form only. Connect this form to your server-side report endpoint before going live.</p>
      </form>
    </div>
  </div>

  <!-- Application information Modal -->
  <div class="pl-jd-modal" id="plJdApplyModal" hidden>
    <div class="pl-jd-modal-backdrop" data-jd-close></div>
    <div class="pl-jd-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="plJdApplyModalTitle">
      <button type="button" class="pl-jd-modal-close" data-jd-close aria-label="Close application options">
        <i class="bi bi-x-lg"></i>
      </button>
      <span class="pl-jd-modal-icon"><i class="bi bi-send-check"></i></span>
      <h2 id="plJdApplyModalTitle">Application Options</h2>
      <p id="plJdApplyModalDescription">Choose an application method configured for this job.</p>
      <div class="pl-jd-modal-application-options" id="plJdApplicationOptions"></div>
    </div>
  </div>

  <!-- Toast -->
  <div class="pl-jd-toast" id="plJdToast" role="status" aria-live="polite"></div>

</main>





<?php include('footer.php'); ?>