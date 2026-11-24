<?php include('header.php'); ?>

<main class="pl-global-jobs">

  <!-- HERO -->
  <section class="pl-gj-hero">
    <div class="pl-gj-container pl-gj-hero-grid">
      <div class="pl-gj-hero-content">
        <span class="pl-gj-eyebrow"><i class="bi bi-globe2"></i> PEOPLELINK CAREER NETWORK</span>
        <h1>Global Jobs.<br><span>Greater Possibilities.</span></h1>
        <p class="pl-gj-hero-text">
          Explore job opportunities across the PeopleLink platform.
          Discover new careers, connect with employers, and take your next
          professional step beyond your community.
        </p>

        <div class="pl-gj-hero-actions">
          <a href="#plGjSearch" class="pl-gj-btn pl-gj-btn-orange">
            <i class="bi bi-search"></i> Search Global Jobs
          </a>
          <button type="button" class="pl-gj-btn pl-gj-btn-outline" data-gj-open-post>
            <i class="bi bi-plus-circle"></i> Post Global Job
          </button>
        </div>

        <div class="pl-gj-hero-note">
          <i class="bi bi-shield-check"></i>
          Opportunities shown according to administrator-approved visibility and access.
        </div>
      </div>

      <div class="pl-gj-hero-visual">
        <div class="pl-gj-visual-orbit pl-gj-orbit-one"></div>
        <div class="pl-gj-visual-orbit pl-gj-orbit-two"></div>
        <div class="pl-gj-globe">
          <i class="bi bi-globe-asia-australia"></i>
        </div>
        <div class="pl-gj-float-card pl-gj-float-card-one">
          <span class="pl-gj-float-icon"><i class="bi bi-briefcase-fill"></i></span>
          <span><strong>Career opportunities</strong><small>Across communities</small></span>
        </div>
        <div class="pl-gj-float-card pl-gj-float-card-two">
          <span class="pl-gj-float-icon pl-gj-green"><i class="bi bi-people-fill"></i></span>
          <span><strong>Talent meets opportunity</strong><small>One connected platform</small></span>
        </div>
        <span class="pl-gj-hero-dot pl-gj-dot-one"></span>
        <span class="pl-gj-hero-dot pl-gj-dot-two"></span>
      </div>
    </div>
  </section>

  <!-- QUICK BENEFITS -->
  <section class="pl-gj-benefits">
    <div class="pl-gj-container pl-gj-benefit-grid">
      <div class="pl-gj-benefit">
        <span><i class="bi bi-globe2"></i></span>
        <div><strong>Platform-wide reach</strong><small>Explore opportunities across communities</small></div>
      </div>
      <div class="pl-gj-benefit">
        <span><i class="bi bi-funnel"></i></span>
        <div><strong>Focused job search</strong><small>Filter by skills, location and experience</small></div>
      </div>
      <div class="pl-gj-benefit">
        <span><i class="bi bi-bookmark-check"></i></span>
        <div><strong>Save opportunities</strong><small>Keep interesting jobs for later</small></div>
      </div>
    </div>
  </section>

  <!-- SEARCH -->
  <section class="pl-gj-section pl-gj-search-section" id="plGjSearch">
    <div class="pl-gj-container">
      <div class="pl-gj-section-heading">
        <div>
          <span class="pl-gj-section-kicker">FIND YOUR NEXT ROLE</span>
          <h2>Search Global Jobs</h2>
          <p>Use the filters to find opportunities that match your goals.</p>
        </div>
        <button type="button" class="pl-gj-text-button" data-gj-show-saved>
          <i class="bi bi-bookmark-heart"></i> Saved Jobs
          <span class="pl-gj-count" data-gj-saved-count>0</span>
        </button>
      </div>

      <form class="pl-gj-search-panel" id="plGjFilterForm">
        <div class="pl-gj-search-grid">
          <label class="pl-gj-field pl-gj-field-keyword">
            <span>Job title or keywords</span>
            <div class="pl-gj-input-wrap">
              <i class="bi bi-search"></i>
              <input type="text" id="plGjKeyword" placeholder="e.g. Web Developer, Accountant">
            </div>
          </label>

          <label class="pl-gj-field">
            <span>Location</span>
            <div class="pl-gj-input-wrap">
              <i class="bi bi-geo-alt"></i>
              <input type="text" id="plGjLocation" placeholder="City, state or remote">
            </div>
          </label>

          <label class="pl-gj-field">
            <span>Category</span>
            <select id="plGjCategory">
              <option value="">All categories</option>
              <option>IT &amp; Software</option>
              <option>Government</option>
              <option>Banking</option>
              <option>Healthcare</option>
              <option>Education</option>
              <option>Sales &amp; Marketing</option>
              <option>Telecom</option>
              <option>Work From Home</option>
              <option>Internship</option>
              <option>Walk-in</option>
              <option>Other Jobs</option>
            </select>
          </label>

          <label class="pl-gj-field">
            <span>Experience</span>
            <select id="plGjExperience">
              <option value="">Any experience</option>
              <option value="fresher">Fresher</option>
              <option value="1-2">1–2 years</option>
              <option value="3-5">3–5 years</option>
              <option value="5+">5+ years</option>
            </select>
          </label>

          <label class="pl-gj-field">
            <span>Qualification</span>
            <select id="plGjQualification">
              <option value="">Any qualification</option>
              <option>10th / 12th</option>
              <option>Diploma</option>
              <option>Graduate</option>
              <option>Postgraduate</option>
              <option>Professional Certification</option>
            </select>
          </label>

          <label class="pl-gj-field">
            <span>Employment type</span>
            <select id="plGjType">
              <option value="">All job types</option>
              <option>Full-time</option>
              <option>Part-time</option>
              <option>Contract</option>
              <option>Internship</option>
              <option>Remote</option>
              <option>Walk-in</option>
            </select>
          </label>

          <label class="pl-gj-field pl-gj-field-skills">
            <span>Skills</span>
            <div class="pl-gj-input-wrap">
              <i class="bi bi-lightning-charge"></i>
              <input type="text" id="plGjSkills" placeholder="e.g. PHP, Excel, communication">
            </div>
          </label>
        </div>

        <div class="pl-gj-search-footer">
          <span><i class="bi bi-info-circle"></i> Results depend on your access permissions.</span>
          <div>
            <button type="reset" class="pl-gj-btn pl-gj-btn-light" id="plGjReset">
              <i class="bi bi-arrow-counterclockwise"></i> Reset Filters
            </button>
            <button type="submit" class="pl-gj-btn pl-gj-btn-primary">
              <i class="bi bi-search"></i> Apply Filters
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>

  <!-- CATEGORIES -->
  <section class="pl-gj-section pl-gj-category-section">
    <div class="pl-gj-container">
      <div class="pl-gj-section-heading">
        <div>
          <span class="pl-gj-section-kicker">EXPLORE BY INDUSTRY</span>
          <h2>Global Job Categories</h2>
          <p>Choose a category to narrow down your search.</p>
        </div>
      </div>

      <div class="pl-gj-category-grid">
        <button class="pl-gj-category-card" type="button" data-gj-category="IT &amp; Software">
          <span class="pl-gj-category-icon pl-gj-icon-blue"><i class="bi bi-laptop"></i></span>
          <strong>IT &amp; Software</strong><small>Technology careers</small>
        </button>
        <button class="pl-gj-category-card" type="button" data-gj-category="Government">
          <span class="pl-gj-category-icon pl-gj-icon-purple"><i class="bi bi-bank"></i></span>
          <strong>Government</strong><small>Public sector roles</small>
        </button>
        <button class="pl-gj-category-card" type="button" data-gj-category="Banking">
          <span class="pl-gj-category-icon pl-gj-icon-green"><i class="bi bi-cash-stack"></i></span>
          <strong>Banking</strong><small>Finance and banking</small>
        </button>
        <button class="pl-gj-category-card" type="button" data-gj-category="Healthcare">
          <span class="pl-gj-category-icon pl-gj-icon-red"><i class="bi bi-heart-pulse"></i></span>
          <strong>Healthcare</strong><small>Care and medical roles</small>
        </button>
        <button class="pl-gj-category-card" type="button" data-gj-category="Education">
          <span class="pl-gj-category-icon pl-gj-icon-orange"><i class="bi bi-mortarboard"></i></span>
          <strong>Education</strong><small>Teaching and training</small>
        </button>
        <button class="pl-gj-category-card" type="button" data-gj-category="Sales &amp; Marketing">
          <span class="pl-gj-category-icon pl-gj-icon-pink"><i class="bi bi-megaphone"></i></span>
          <strong>Sales &amp; Marketing</strong><small>Growth and outreach</small>
        </button>
        <button class="pl-gj-category-card" type="button" data-gj-category="Work From Home">
          <span class="pl-gj-category-icon pl-gj-icon-teal"><i class="bi bi-house-laptop"></i></span>
          <strong>Work From Home</strong><small>Flexible opportunities</small>
        </button>
        <button class="pl-gj-category-card" type="button" data-gj-category="Internship">
          <span class="pl-gj-category-icon pl-gj-icon-gold"><i class="bi bi-person-workspace"></i></span>
          <strong>Internships</strong><small>Start your career</small>
        </button>
      </div>
    </div>
  </section>

  <!-- JOB RESULTS -->
  <section class="pl-gj-section pl-gj-results-section" id="plGjResults">
    <div class="pl-gj-container">
      <div class="pl-gj-section-heading pl-gj-results-heading">
        <div>
          <span class="pl-gj-section-kicker">CAREER OPPORTUNITIES</span>
          <h2>Latest Global Opportunities</h2>
          <p>Explore jobs made available across the PeopleLink platform.</p>
        </div>
        <label class="pl-gj-sort">
          <span>Sort by</span>
          <select id="plGjSort">
            <option value="recent">Recently added</option>
            <option value="salary">Salary: high to low</option>
            <option value="title">Job title</option>
            <option value="location">Location</option>
          </select>
        </label>
      </div>

      <div class="pl-gj-results-toolbar">
        <p id="plGjResultSummary" aria-live="polite">Showing available opportunities</p>
        <button type="button" class="pl-gj-text-button" data-gj-clear-search>
          <i class="bi bi-x-circle"></i> Clear search
        </button>
      </div>

      <div class="pl-gj-job-list" id="plGjJobList" aria-live="polite"></div>

      <div class="pl-gj-empty" id="plGjEmpty" hidden>
        <span><i class="bi bi-search"></i></span>
        <h3>No matching jobs found</h3>
        <p>Try different keywords or reset your filters to explore more opportunities.</p>
        <button type="button" class="pl-gj-btn pl-gj-btn-primary" data-gj-reset-all>
          Reset Search
        </button>
      </div>

      <div class="pl-gj-results-bottom">
        <p><i class="bi bi-shield-check"></i> Job visibility and application access may depend on your account package.</p>
        <button type="button" class="pl-gj-btn pl-gj-btn-light" data-gj-show-saved>
          <i class="bi bi-bookmark-heart"></i> View Saved Jobs
        </button>
      </div>
    </div>
  </section>

  <!-- JOB ALERTS -->
  <section class="pl-gj-alert-section">
    <div class="pl-gj-container pl-gj-alert-box">
      <div class="pl-gj-alert-icon"><i class="bi bi-bell"></i></div>
      <div class="pl-gj-alert-copy">
        <span class="pl-gj-section-kicker">STAY INFORMED</span>
        <h2>Get Global Job Alerts</h2>
        <p>Set your preferences to receive relevant opportunities based on your skills and career interests.</p>
      </div>
      <button type="button" class="pl-gj-btn pl-gj-btn-primary" data-gj-open-alert>
        <i class="bi bi-bell-fill"></i> Set Job Preferences
      </button>
    </div>
  </section>

  <!-- PACKAGES -->
  <section class="pl-gj-section pl-gj-package-section" id="plGjPackages">
    <div class="pl-gj-container pl-gj-package-grid">
      <div class="pl-gj-package-copy">
        <span class="pl-gj-section-kicker">FOR EMPLOYERS &amp; AUTHORISED USERS</span>
        <h2>Reach Talent Across Communities</h2>
        <p>
          Publish global opportunities using the Global Job Packages available
          for your account. Package features, pricing, visibility, and duration
          are determined by the administrator.
        </p>
        <ul class="pl-gj-check-list">
          <li><i class="bi bi-check-circle-fill"></i> Number of permitted job posts</li>
          <li><i class="bi bi-check-circle-fill"></i> Package validity period</li>
          <li><i class="bi bi-check-circle-fill"></i> Featured placement, where included</li>
          <li><i class="bi bi-check-circle-fill"></i> Configured visibility duration</li>
        </ul>
        <button type="button" class="pl-gj-btn pl-gj-btn-primary" data-gj-view-packages>
          View Global Job Packages <i class="bi bi-arrow-right"></i>
        </button>
      </div>

      <div class="pl-gj-package-visual">
        <div class="pl-gj-package-decoration"></div>
        <div class="pl-gj-package-card">
          <span class="pl-gj-package-card-icon"><i class="bi bi-briefcase-fill"></i></span>
          <span class="pl-gj-package-label">PEOPLELINK EMPLOYER TOOLS</span>
          <h3>Put your next opportunity in front of more talent.</h3>
          <div class="pl-gj-package-line"></div>
          <div class="pl-gj-package-mini">
            <span><i class="bi bi-check2-circle"></i> Job publishing</span>
            <span><i class="bi bi-check2-circle"></i> Visibility options</span>
            <span><i class="bi bi-check2-circle"></i> Package-based benefits</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- COMMUNITY JOBS SWITCH -->
  <section class="pl-gj-community-section">
    <div class="pl-gj-container pl-gj-community-box">
      <div class="pl-gj-community-icon"><i class="bi bi-people"></i></div>
      <div>
        <h2>Looking for community-specific opportunities?</h2>
        <p>Switch to Community Jobs to explore listings intended for your own community.</p>
      </div>
      <a href="community-jobs.php" class="pl-gj-btn pl-gj-btn-light">
        View Community Jobs <i class="bi bi-arrow-up-right"></i>
      </a>
    </div>
  </section>

  <!-- FINAL CTA -->
  <section class="pl-gj-final-cta">
    <div class="pl-gj-container pl-gj-final-inner">
      <span class="pl-gj-final-icon"><i class="bi bi-globe2"></i></span>
      <span class="pl-gj-section-kicker">CONNECT TALENT WITH OPPORTUNITY</span>
      <h2>Your Next Opportunity Could Be Anywhere.</h2>
      <p>Explore opportunities, discover new possibilities, and connect with the wider PeopleLink network.</p>
      <div class="pl-gj-final-actions">
        <a href="#plGjSearch" class="pl-gj-btn pl-gj-btn-orange"><i class="bi bi-search"></i> Search Jobs</a>
        <button type="button" class="pl-gj-btn pl-gj-btn-white" data-gj-open-post><i class="bi bi-plus-circle"></i> Post Global Job</button>
        <button type="button" class="pl-gj-btn pl-gj-btn-ghost" data-gj-view-packages>View Packages</button>
      </div>
    </div>
  </section>

  <!-- JOB DETAILS MODAL -->
  <div class="pl-gj-modal" id="plGjDetailsModal" hidden>
    <div class="pl-gj-modal-backdrop" data-gj-close-modal></div>
    <div class="pl-gj-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="plGjModalTitle">
      <button type="button" class="pl-gj-modal-close" aria-label="Close" data-gj-close-modal><i class="bi bi-x-lg"></i></button>
      <div id="plGjDetailsContent"></div>
    </div>
  </div>

  <!-- POST JOB MODAL -->
  <div class="pl-gj-modal" id="plGjPostModal" hidden>
    <div class="pl-gj-modal-backdrop" data-gj-close-modal></div>
    <div class="pl-gj-modal-dialog pl-gj-modal-wide" role="dialog" aria-modal="true" aria-labelledby="plGjPostTitle">
      <button type="button" class="pl-gj-modal-close" aria-label="Close" data-gj-close-modal><i class="bi bi-x-lg"></i></button>
      <div class="pl-gj-modal-heading">
        <span class="pl-gj-section-kicker">EMPLOYER CENTRE</span>
        <h2 id="plGjPostTitle">Post a Global Job</h2>
        <p>Submit your job details for administrator review.</p>
      </div>

      <form id="plGjPostForm" class="pl-gj-modal-form">
        <div class="pl-gj-modal-form-grid">
          <label class="pl-gj-field"><span>Company / Organisation *</span><input name="company" required maxlength="120" placeholder="Organisation name"></label>
          <label class="pl-gj-field"><span>Job Title *</span><input name="title" required maxlength="120" placeholder="e.g. PHP Developer"></label>
          <label class="pl-gj-field"><span>Category *</span>
            <select name="category" required>
              <option value="">Select category</option>
              <option>IT &amp; Software</option><option>Government</option><option>Banking</option>
              <option>Healthcare</option><option>Education</option><option>Sales &amp; Marketing</option>
              <option>Telecom</option><option>Work From Home</option><option>Internship</option>
              <option>Walk-in</option><option>Other Jobs</option>
            </select>
          </label>
          <label class="pl-gj-field"><span>Location *</span><input name="location" required placeholder="City, state or remote"></label>
          <label class="pl-gj-field"><span>Qualification</span><input name="qualification" placeholder="Required qualification"></label>
          <label class="pl-gj-field"><span>Experience</span>
            <select name="experience">
              <option value="Any experience">Any experience</option><option>Fresher</option>
              <option>1–2 years</option><option>3–5 years</option><option>5+ years</option>
            </select>
          </label>
          <label class="pl-gj-field"><span>Skills</span><input name="skills" placeholder="Separate skills with commas"></label>
          <label class="pl-gj-field"><span>Job Type *</span>
            <select name="type" required>
              <option value="">Select type</option><option>Full-time</option><option>Part-time</option>
              <option>Contract</option><option>Internship</option><option>Remote</option><option>Walk-in</option>
            </select>
          </label>
          <label class="pl-gj-field"><span>Salary / Compensation</span><input name="salary" placeholder="e.g. ₹4–6 LPA or Not disclosed"></label>
          <label class="pl-gj-field"><span>Application Email</span><input type="email" name="email" placeholder="careers@example.com"></label>
          <label class="pl-gj-field"><span>Application WhatsApp / Phone</span><input name="phone" placeholder="Include country code"></label>
          <label class="pl-gj-field"><span>Application URL</span><input type="url" name="applicationUrl" placeholder="https://example.com/apply"></label>
        </div>
        <label class="pl-gj-field pl-gj-full-field"><span>Job Description *</span><textarea name="description" required rows="5" maxlength="5000" placeholder="Describe responsibilities, requirements and how to apply..."></textarea></label>
        <p class="pl-gj-form-notice"><i class="bi bi-shield-check"></i> Submissions are pending review in this demo. Live publishing requires a secure server-side approval workflow.</p>
        <div class="pl-gj-modal-actions">
          <button type="button" class="pl-gj-btn pl-gj-btn-light" data-gj-close-modal>Cancel</button>
          <button type="submit" class="pl-gj-btn pl-gj-btn-primary"><i class="bi bi-send"></i> Submit for Approval</button>
        </div>
      </form>
    </div>
  </div>

  <!-- JOB ALERT MODAL -->
  <div class="pl-gj-modal" id="plGjAlertModal" hidden>
    <div class="pl-gj-modal-backdrop" data-gj-close-modal></div>
    <div class="pl-gj-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="plGjAlertTitle">
      <button type="button" class="pl-gj-modal-close" aria-label="Close" data-gj-close-modal><i class="bi bi-x-lg"></i></button>
      <div class="pl-gj-modal-heading">
        <span class="pl-gj-section-kicker">PERSONALISED OPPORTUNITIES</span>
        <h2 id="plGjAlertTitle">Set Job Preferences</h2>
        <p>Choose the kinds of opportunities you want to hear about.</p>
      </div>
      <form id="plGjAlertForm" class="pl-gj-modal-form">
        <label class="pl-gj-field"><span>Skills / Profession</span><input name="skills" placeholder="e.g. design, PHP, accounting"></label>
        <label class="pl-gj-field"><span>Category</span>
          <select name="category">
            <option value="">Any category</option><option>IT &amp; Software</option><option>Government</option>
            <option>Banking</option><option>Healthcare</option><option>Education</option>
            <option>Sales &amp; Marketing</option><option>Telecom</option><option>Work From Home</option>
            <option>Internship</option><option>Walk-in</option><option>Other Jobs</option>
          </select>
        </label>
        <label class="pl-gj-field"><span>Preferred Location</span><input name="location" placeholder="City, state or remote"></label>
        <label class="pl-gj-field"><span>Experience</span>
          <select name="experience">
            <option value="">Any experience</option><option>Fresher</option><option>1–2 years</option>
            <option>3–5 years</option><option>5+ years</option>
          </select>
        </label>
        <p class="pl-gj-form-notice"><i class="bi bi-info-circle"></i> This demo saves preferences in this browser. Notifications require account and backend integration.</p>
        <div class="pl-gj-modal-actions">
          <button type="button" class="pl-gj-btn pl-gj-btn-light" data-gj-close-modal>Cancel</button>
          <button type="submit" class="pl-gj-btn pl-gj-btn-primary"><i class="bi bi-bell"></i> Save Preferences</button>
        </div>
      </form>
    </div>
  </div>

  <!-- SAVED JOBS MODAL -->
  <div class="pl-gj-modal" id="plGjSavedModal" hidden>
    <div class="pl-gj-modal-backdrop" data-gj-close-modal></div>
    <div class="pl-gj-modal-dialog pl-gj-modal-wide" role="dialog" aria-modal="true" aria-labelledby="plGjSavedTitle">
      <button type="button" class="pl-gj-modal-close" aria-label="Close" data-gj-close-modal><i class="bi bi-x-lg"></i></button>
      <div class="pl-gj-modal-heading">
        <span class="pl-gj-section-kicker">YOUR SHORTLIST</span>
        <h2 id="plGjSavedTitle">Saved Jobs</h2>
        <p>Opportunities you have bookmarked for future reference.</p>
      </div>
      <div id="plGjSavedList" class="pl-gj-saved-list"></div>
    </div>
  </div>

  <!-- PACKAGES MODAL -->
  <div class="pl-gj-modal" id="plGjPackagesModal" hidden>
    <div class="pl-gj-modal-backdrop" data-gj-close-modal></div>
    <div class="pl-gj-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="plGjPackagesTitle">
      <button type="button" class="pl-gj-modal-close" aria-label="Close" data-gj-close-modal><i class="bi bi-x-lg"></i></button>
      <div class="pl-gj-modal-heading">
        <span class="pl-gj-section-kicker">GLOBAL JOB PACKAGES</span>
        <h2 id="plGjPackagesTitle">Choose Your Publishing Access</h2>
        <p>Available plans, pricing and benefits should be loaded from your administrator-managed package records.</p>
      </div>
      <div class="pl-gj-package-info">
        <div><i class="bi bi-file-earmark-check"></i><strong>Job post allowance</strong><p>Number of listings allowed by your package.</p></div>
        <div><i class="bi bi-calendar-check"></i><strong>Validity period</strong><p>How long the package remains active.</p></div>
        <div><i class="bi bi-stars"></i><strong>Featured visibility</strong><p>Placement benefits where included.</p></div>
      </div>
      <p class="pl-gj-form-notice"><i class="bi bi-info-circle"></i> Connect this section to your live package table and payment workflow to display actual plans.</p>
      <div class="pl-gj-modal-actions">
        <button type="button" class="pl-gj-btn pl-gj-btn-light" data-gj-close-modal>Close</button>
        <button type="button" class="pl-gj-btn pl-gj-btn-primary" data-gj-open-post>Post a Global Job</button>
      </div>
    </div>
  </div>

  <div class="pl-gj-toast" id="plGjToast" role="status" aria-live="polite"></div>
</main>

<?php include('footer.php'); ?>