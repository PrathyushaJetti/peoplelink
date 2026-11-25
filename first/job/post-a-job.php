<?php
// Page 40 – Post a Job / Edit Job (live: jobs_create, or jobs_update with ?edit=ID → admin approval queue)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();
web_require_community();

$errors = [];
$success = false;
$submittedJob = null;
// Edit mode: only the poster's own job, and not a closed one (closed jobs are renewed from My Posted Jobs)
$editId = (int)($_GET['edit'] ?? 0);
$editJob = $editId ? pl_api_own(pl_entity('job'), $editId, $webUid) : null;
if ($editId && (!$editJob || $editJob['status'] === 'closed')) { flash($editJob ? 'This job is closed. Renew it to make changes.' : 'Job not found.', 'error'); header('Location: my-posted-jobs.php'); exit; }
$jobCats = pl_categories('jobs');
$jobOpts = pl_entity('job')['fields'];
$optList = fn($col) => pl_opts($jobOpts[$col]); // value => label, the same choices the backend accepts
function pj_options(array $opts, string $placeholder): string {
    $h = '<option value="">' . h($placeholder) . '</option>';
    foreach ($opts as $v => $l) $h .= '<option value="' . h($v) . '">' . h($l) . '</option>';
    return $h;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) {
        $errors[] = 'Your session expired. Please submit the form again.';
    } else {
        $in = $_POST;
        $m = (array)($in['application_method'] ?? []);
        $via = in_array('whatsapp', $m, true) && in_array('email', $m, true) ? 'both' : (in_array('whatsapp', $m, true) ? 'whatsapp' : (in_array('email', $m, true) ? 'email' : 'in_app'));
        $place = array_map('trim', explode(',', (string)($in['job_location'] ?? '')));
        $map = [
            'visibility_type' => ($in['visibility'] ?? '') === 'global' ? 'global' : 'community',
            'job_title' => $in['job_title'] ?? '', 'company_name' => $in['company_name'] ?? '',
            'category_id' => (int)($in['job_category'] ?? 0), 'openings' => $in['openings'] ?? 1,
            'employment_type' => $in['employment_type'] ?? '', 'work_mode' => $in['work_mode'] ?? '',
            'location' => $in['job_location'] ?? '', 'city' => $place[0] ?? '', 'state' => $place[1] ?? '',
            'salary_min' => $in['salary_min'] ?? '', 'salary_max' => $in['salary_max'] ?? '', 'salary_period' => 'month',
            'experience' => $in['experience'] ?? '', 'qualification' => $in['qualification'] ?? '',
            'required_skills' => $in['skills_required'] ?? '', 'description' => $in['job_summary'] ?? '',
            'responsibilities' => $in['responsibilities'] ?? '', 'joining' => $in['joining_availability'] ?? '',
            'application_email' => $in['application_email'] ?? '', 'whatsapp' => $in['application_whatsapp'] ?? '', 'apply_via' => $via,
            'contact_person' => $in['contact_name'] ?? '',
            'application_start_date' => $in['application_start'] ?? '', 'closing_date' => $in['application_end'] ?? '',
            // kept with the job as extra details (shown on the job page)
            'core_skills' => $in['required_skills'] ?? '', 'preferred_skills' => $in['preferred_skills'] ?? '',
            'additional_requirements' => $in['additional_requirements'] ?? '', 'industry' => $in['industry'] ?? '',
            'company_website' => $in['company_website'] ?? '', 'company_location' => $in['company_location'] ?? '',
            'company_description' => $in['company_description'] ?? '', 'contact_mobile' => $in['contact_mobile'] ?? '', 'contact_email' => $in['contact_email'] ?? '',
        ];
        $saveFiles = $_FILES;
        $r = web_call($editJob ? 'jobs_update' : 'jobs_create', array_map(fn($v) => is_string($v) ? trim($v) : $v, $map) + ['csrf' => $_POST['csrf']] + ($editJob ? ['id' => $editId] : []), true);
        if (!empty($r['error'])) {
            $errors[] = $r['error'];
            if (($r['code'] ?? '') === 'PACKAGE_REQUIRED') $errors[] = 'Buy a Global Job Package, or post it as a Community Job.';
        } else {
            $success = true;
            $it = $r['item'] ?? [];
            $submittedJob = ['title' => $it['job_title'] ?? $map['job_title'], 'company' => $it['company_name'] ?? $map['company_name'],
                'visibility' => $it['visibility_type'] ?? $map['visibility_type'], 'id' => $it['id'] ?? 0, 'warning' => $r['warning'] ?? '', 'message' => $r['message'] ?? ''];
        }
    }
}
$jsOld = (!$success && $_SERVER['REQUEST_METHOD'] === 'POST') ? array_diff_key($_POST, ['csrf' => 1]) : [];
// Edit mode, first visit: fill the form from the saved job (form field names of this design)
if ($editJob && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $d = json_decode((string)($editJob['details'] ?? ''), true) ?: [];
    $via = $editJob['apply_via'] ?? 'in_app';
    $jsOld = [
        'visibility' => $editJob['visibility_type'], 'job_title' => $editJob['job_title'], 'company_name' => $editJob['company_name'],
        'job_category' => (string)$editJob['category_id'], 'openings' => (string)$editJob['openings'], 'employment_type' => $editJob['employment_type'],
        'work_mode' => $editJob['work_mode'], 'job_location' => $editJob['location'] ?: trim($editJob['city'] . ', ' . $editJob['state'], ', '),
        'salary_min' => $editJob['salary_min'] !== null ? (string)(int)$editJob['salary_min'] : '', 'salary_max' => $editJob['salary_max'] !== null ? (string)(int)$editJob['salary_max'] : '',
        'experience' => $editJob['experience'], 'qualification' => $editJob['qualification'], 'skills_required' => $editJob['required_skills'],
        'job_summary' => $editJob['description'], 'responsibilities' => $editJob['responsibilities'], 'joining_availability' => $editJob['joining'],
        'application_email' => $editJob['application_email'], 'application_whatsapp' => $editJob['whatsapp'], 'contact_name' => $editJob['contact_person'],
        'application_start' => $editJob['application_start_date'], 'application_end' => $editJob['closing_date'],
        'application_method' => array_values(array_filter([in_array($via, ['whatsapp', 'both'], true) ? 'whatsapp' : null, in_array($via, ['email', 'both'], true) ? 'email' : null])),
        'required_skills' => $d['core_skills'] ?? '', 'preferred_skills' => $d['preferred_skills'] ?? '', 'additional_requirements' => $d['additional_requirements'] ?? '',
        'industry' => $d['industry'] ?? '', 'company_website' => $d['company_website'] ?? '', 'company_location' => $d['company_location'] ?? '',
        'company_description' => $d['company_description'] ?? '', 'contact_mobile' => $d['contact_mobile'] ?? '', 'contact_email' => $d['contact_email'] ?? '',
    ];
}
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

<?php include __DIR__ . '/../_site_header.php'; ?>

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
                <h2><?= $editJob ? 'Job Updated' : 'Job Submitted Successfully' ?></h2>
                <p><strong><?= h($submittedJob['title']) ?></strong> at <?= h($submittedJob['company']) ?> has been <?= $editJob ? 'updated' : 'submitted' ?>.<?= $editJob && $submittedJob['message'] ? ' ' . h($submittedJob['message']) : '' ?></p><?php if (!empty($submittedJob['warning'])): ?><div class="pj-review-note payment-note"><i class="fa-solid fa-circle-info"></i><span><?= h($submittedJob['warning']) ?></span></div><?php endif; ?>
                <div class="pj-review-note"><i class="fa-solid fa-shield-halved"></i><span>Your job is under review and will be published after approval by the community admin.</span></div>
                <?php if ($submittedJob['visibility'] === 'global'): ?><div class="pj-review-note payment-note"><i class="fa-solid fa-earth-asia"></i><span>This is a Global Job: it will be visible across PeopleLink once approved.</span></div><?php endif; ?>
                <div class="pj-success-actions"><a class="pj-btn pj-btn-outline" href="post-a-job.php">Post Another Job</a><a class="pj-btn pj-btn-primary" href="my-posted-jobs.php">View My Posted Jobs</a></div>
            </section>
        <?php else: ?>
            <?php if ($errors): ?><div class="pj-errors"><strong>Please review the following:</strong><ul><?php foreach ($errors as $error): ?><li><?= h($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

            <div class="pj-form-heading">
                <div><span class="pj-section-kicker">EMPLOYER WORKSPACE</span><h2>Post a Job</h2><p>Complete the details below. You can preview your listing before submitting it.</p></div>
                <div class="pj-step-note"><i class="fa-solid fa-lock"></i> Your contact details stay in the application workflow</div>
            </div>

            <form id="postJobForm" method="post" enctype="multipart/form-data" action="<?= $editJob ? 'post-a-job.php?edit=' . (int)$editId : '' ?>"><?= web_csrf_field() ?>
                <section class="pj-form-card">
                    <div class="pj-card-heading"><span class="pj-card-icon"><i class="fa-solid fa-eye"></i></span><div><h3>Job Visibility</h3><p>Choose who can discover this opportunity.</p></div></div>
                    <div class="pj-visibility-options">
                        <label class="pj-visibility-option active" data-visibility-card="community"><input type="radio" name="visibility" value="community" checked><span class="pj-radio-mark"></span><span class="pj-visibility-symbol"><i class="fa-solid fa-people-group"></i></span><span class="pj-visibility-copy"><strong>Community Job</strong><small>Visible to your selected community.</small></span><span class="pj-visibility-check"><i class="fa-solid fa-circle-check"></i></span></label>
                        <label class="pj-visibility-option" data-visibility-card="global"><input type="radio" name="visibility" value="global"><span class="pj-radio-mark"></span><span class="pj-visibility-symbol global"><i class="fa-solid fa-earth-asia"></i></span><span class="pj-visibility-copy"><strong>Global Job</strong><small>Visible across the PeopleLink network.</small></span><span class="pj-visibility-check"><i class="fa-solid fa-circle-check"></i></span></label>
                    </div>
                    <div class="pj-conditional-grid" id="communityFields">
                        <div class="pj-field"><label for="community_id">Selected Community <span>*</span></label><select id="community_id" name="community_id" disabled><option selected><?= h($webComm['name']) ?></option></select><small>Community jobs are posted to your selected community. <a href="/peoplelink/first/community-page.php">Change community</a></small></div>
                        <div class="pj-community-preview"><i class="fa-solid fa-users"></i><span>Community label preview<strong id="communityNamePreview"><?= h($webComm['name']) ?></strong></span></div>
                    </div>
                    <div class="pj-global-notice" id="globalNotice" hidden><i class="fa-solid fa-earth-asia"></i><div><strong>Global visibility selected</strong><p>This job can appear across PeopleLink. Posting a global job uses one post from your Global Job Package. <a href="global-job-packages.php">View packages</a></p></div></div>
                </section>

                <section class="pj-form-card">
                    <div class="pj-card-heading"><span class="pj-card-icon"><i class="fa-solid fa-briefcase"></i></span><div><h3>Basic Job Information</h3><p>Share the essential details candidates need.</p></div></div>
                    <div class="pj-form-grid">
                        <div class="pj-field span-2"><label for="job_title">Job Title <span>*</span></label><input id="job_title" name="job_title" required placeholder="e.g. PHP Web Developer"></div>
                        <div class="pj-field"><label for="company_name">Company / Organisation Name <span>*</span></label><input id="company_name" name="company_name" required placeholder="Enter organisation name"></div>
                        <div class="pj-field"><label for="job_category">Job Category <span>*</span></label><select id="job_category" name="job_category" required><option value="">Select category</option><?php foreach ($jobCats as $c): ?><option value="<?= (int)$c['id'] ?>"><?= h($c['name']) ?></option><?php endforeach; ?></select></div>
                        <div class="pj-field"><label for="openings">Number of Openings <span>*</span></label><input id="openings" name="openings" type="number" min="1" value="1" required></div>
                        <div class="pj-field"><label for="employment_type">Employment Type <span>*</span></label><select id="employment_type" name="employment_type" required><?= pj_options($optList('employment_type'), 'Select type') ?></select></div>
                        <div class="pj-field"><label for="work_mode">Work Mode <span>*</span></label><select id="work_mode" name="work_mode" required><?= pj_options($optList('work_mode'), 'Select mode') ?></select></div>
                        <div class="pj-field"><label for="job_location">Job Location <span>*</span></label><input id="job_location" name="job_location" required placeholder="City, State or Remote"></div>
                        <div class="pj-field"><label for="salary_min">Minimum Salary (₹ / month)</label><input id="salary_min" name="salary_min" type="number" min="0" placeholder="e.g. 18000"></div>
                        <div class="pj-field"><label for="salary_max">Maximum Salary (₹ / month)</label><input id="salary_max" name="salary_max" type="number" min="0" placeholder="e.g. 35000"></div>
                        <div class="pj-field"><label for="experience">Experience Required <span>*</span></label><select id="experience" name="experience" required><?= pj_options($optList('experience'), 'Select experience') ?></select></div>
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
                        <div class="pj-field"><label for="joining_availability">Joining Availability</label><select id="joining_availability" name="joining_availability"><?= pj_options($optList('joining'), 'Select availability') ?></select></div>
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
<?php if ($editJob && !$success): ?><script>
// edit mode: change the page wording
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.pj-form-heading h2').forEach(function (el) { el.textContent = 'Edit Job'; });
  var b = document.querySelector('button[name="submit_job"]'); if (b) b.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Save Changes';
});
</script><?php endif; ?>
<?php if ($jsOld): ?><script>
// refill the form after an error so nothing typed is lost
document.addEventListener('DOMContentLoaded', function () {
  const old = <?= json_encode($jsOld, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
  const f = document.getElementById('postJobForm'); if (!f) return;
  Object.keys(old).forEach(function (k) {
    const v = old[k];
    if (Array.isArray(v)) { f.querySelectorAll('[name="' + k + '[]"]').forEach(function (el) { el.checked = v.indexOf(el.value) !== -1; el.dispatchEvent(new Event('change', {bubbles: true})); }); return; }
    f.querySelectorAll('[name="' + k + '"]').forEach(function (el) {
      if (el.type === 'radio' || el.type === 'checkbox') { el.checked = el.value === v; if (el.checked) el.dispatchEvent(new Event('change', {bubbles: true})); }
      else if (el.type !== 'file') el.value = v;
    });
  });
});
</script><?php endif; ?>
<script src="post-a-job.js"></script>
<script src="js/jobs-global.js"></script>
</body>
</html>
