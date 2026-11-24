<?php
// Family Tree request (add member / relationship / correction ...). Saved for admin review; the family tree goes to "Under Review".
require_once __DIR__ . '/_tree.php';
$fam = mf_family($mfUid, $mfCid, null);
if (!$fam) mf_no_family($mfUser, $mfComm);
$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
const FTE_TYPES = ['add_member' => 'Add Family Member', 'add_relationship' => 'Add Missing Relationship', 'correct_details' => 'Correct Existing Details',
    'update_member' => 'Update Member Information', 'remove_information' => 'Remove Incorrect Information', 'other' => 'Other Family Tree Request'];
$fteErrors = []; $fteSent = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $in = fn(string $k, int $len = 255) => mb_substr(trim((string)($_POST[$k] ?? '')), 0, $len);
    if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) $fteErrors[] = 'Your session expired. Please try again.';
    $type = (string)($_POST['request_type'] ?? '');
    if (!isset(FTE_TYPES[$type])) $fteErrors[] = 'Please choose a request type.';
    if (in_array($type, ['add_member', 'update_member', 'add_relationship'], true) && $in('member_name') === '') $fteErrors[] = 'Please enter the member name.';
    $mobile = preg_replace('/[^\d+]/', '', $in('mobile_number', 30));
    if ($in('contact_name') === '') $fteErrors[] = 'Please enter your name.';
    if (!preg_match('/^\+?\d{10,15}$/', $mobile)) $fteErrors[] = 'Please enter a valid mobile number.';
    $email = $in('email', 160); if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $fteErrors[] = 'Please enter a valid email address.';
    if (empty($_POST['information_confirmation']) || empty($_POST['review_consent'])) $fteErrors[] = 'Please tick both confirmation boxes.';
    $files = [];
    if (!$fteErrors) foreach (['member_photo' => false, 'supporting_document' => true] as $fk => $docs)
        if (!empty($_FILES[$fk]) && ($_FILES[$fk]['error'] ?? 4) !== UPLOAD_ERR_NO_FILE) { $up = pl_store_upload($_FILES[$fk], 'family_tree', $docs); if (!empty($up['error'])) $fteErrors[] = ucfirst(str_replace('_', ' ', $fk)) . ': ' . $up['error']; else $files[$fk] = $up['url']; }
    if (!$fteErrors) {
        $lines = ['Request: ' . FTE_TYPES[$type]];
        foreach (['member_name' => 'Member', 'relationship' => 'Relationship to head', 'gender' => 'Gender', 'date_of_birth' => 'Date of birth', 'marital_status' => 'Marital status',
            'education' => 'Education', 'profession' => 'Profession', 'current_city' => 'City', 'native_place' => 'Native place', 'related_to' => 'Related to',
            'relationship_type' => 'Relationship type', 'father_details' => 'Father', 'mother_details' => 'Mother', 'spouse_details' => 'Spouse', 'notes' => 'Notes'] as $k => $label)
            if ($in($k, 1000) !== '') $lines[] = "$label: " . $in($k, 1000);
        foreach ($files as $k => $u) $lines[] = ($k === 'member_photo' ? 'Photo' : 'Document') . ': ' . $u;
        db()->prepare("INSERT INTO enquiries (entity, entity_id, community_id, user_id, owner_user_id, kind, name, phone, email, message, status) VALUES ('families',?,?,?,?, 'tree_request', ?,?,?,?, 'new')")
            ->execute([(int)$fam['id'], $mfCid, $mfUid, (int)$fam['user_id'], $in('contact_name', 120), $mobile, $email, implode("\n", $lines)]);
        $rid = (int)db()->lastInsertId();
        // the tree goes to review: keep the request in the family's tree information too
        $d = json_decode($fam['details'] ?? '', true) ?: [];
        $d['tree_info']['last_request'] = ['id' => $rid, 'type' => $type, 'at' => date('c')]; $d['tree_submitted_at'] = date('c');
        db()->prepare("UPDATE families SET details=?, tree_status=IF(tree_status='approved', tree_status, 'pending') WHERE id=?")->execute([json_encode($d, JSON_UNESCAPED_UNICODE), $fam['id']]);
        pl_audit('app_tree_request', 'family_tree', (int)$fam['id'], FTE_TYPES[$type] . ' #' . $rid, $mfCid);
        header('Location: family-tree-enquiry.php?sent=' . $rid); exit;
    }
}
if (isset($_GET['sent'])) $fteSent = rows("SELECT * FROM enquiries WHERE id=? AND user_id=? AND kind='tree_request'", [(int)$_GET['sent'], $mfUid])[0] ?? null;
$fteList = rows("SELECT * FROM enquiries WHERE user_id=? AND kind='tree_request' ORDER BY id DESC LIMIT 20", [$mfUid]);
$fteStatus = ['new' => ['Submitted', 'status-submitted'], 'replied' => ['Under Review', 'status-review'], 'closed' => ['Completed', 'status-approved']];
$fteCode = fn($id) => 'PL-FT-' . str_pad((string)$id, 5, '0', STR_PAD_LEFT);
$fteType = fn($msg) => trim(substr(strtok((string)$msg, "\n"), strlen('Request: ')));
include 'header.php';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<main class="fte-page">

    <!-- Hero -->
    <section class="fte-hero">
        <div class="fte-container">
            <nav class="fte-breadcrumb" aria-label="Breadcrumb">
                <a href="family-tree.php">Family Tree</a>
                <i class="bi bi-chevron-right"></i>
                <a href="view-family-tree.php">View Family Tree</a>
                <i class="bi bi-chevron-right"></i>
                <span>Submit Details</span>
            </nav>

            <div class="fte-hero-content">
                <div>
                    <span class="fte-eyebrow">
                        <i class="bi bi-people"></i>
                        FAMILY INFORMATION
                    </span>

                    <h1>Submit Family Tree Details</h1>

                    <p>
                        Help complete your family history or request a correction
                        to existing family-tree information. Submitted changes
                        can be reviewed before they appear in the family tree.
                    </p>
                </div>

                <div class="fte-hero-icon" aria-hidden="true">
                    <i class="bi bi-diagram-3"></i>
                </div>
            </div>
        </div>
    </section>

    <div class="fte-container fte-main">

        <!-- Steps -->
        <section class="fte-step-strip" aria-label="Submission steps">
            <div class="fte-step active">
                <span>1</span>
                <div>
                    <strong>Enter Details</strong>
                    <small>Complete the form</small>
                </div>
            </div>

            <div class="fte-step-line"></div>

            <div class="fte-step">
                <span>2</span>
                <div>
                    <strong>Submit Request</strong>
                    <small>Send for review</small>
                </div>
            </div>

            <div class="fte-step-line"></div>

            <div class="fte-step">
                <span>3</span>
                <div>
                    <strong>Track Status</strong>
                    <small>Follow progress</small>
                </div>
            </div>
        </section>

        <!-- Notice -->
        <div class="fte-info-banner">
            <i class="bi bi-info-circle-fill"></i>
            <div>
                <strong>Please provide accurate information.</strong>
                <p>
                    Family details may be reviewed before approval. Only provide
                    information you are authorised to share, and ensure you have
                    permission to upload another person's photo or documents.
                </p>
            </div>
        </div>

        <!-- Main Form -->
        <form id="familyTreeEnquiryForm"
              class="fte-form"
              action="family-tree-enquiry.php"
              method="post"
              enctype="multipart/form-data">
            <input type="hidden" name="csrf" value="<?= $h(csrf_token()) ?>">
            <?php if ($fteErrors): ?><div style="background:#fdecee;color:#9b1c2c;border:1px solid #f5c2c9;border-radius:12px;padding:14px 18px;margin-bottom:18px"><strong>Please fix the following:</strong><ul style="margin:6px 0 0 18px"><?php foreach ($fteErrors as $er): ?><li><?= $h($er) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

            <!-- Family Reference -->
            <section class="fte-form-section">
                <div class="fte-section-heading">
                    <div class="fte-heading-icon blue">
                        <i class="bi bi-people"></i>
                    </div>

                    <div>
                        <span class="fte-section-kicker">SECTION 01</span>
                        <h2>Family Reference</h2>
                        <p>Identify the family tree this request belongs to.</p>
                    </div>
                </div>

                <div class="fte-fields-grid">
                    <div class="fte-field">
                        <label for="familyName">Family Name / Surname <span>*</span></label>
                        <input type="text"
                               id="familyName"
                               name="family_name"
                               value="<?= $h($fam['family_name']) ?>" readonly
                               placeholder="Enter family name"
                               required>
                    </div>

                    <div class="fte-field">
                        <label for="primaryMember">Primary Member Name <span>*</span></label>
                        <input type="text"
                               id="primaryMember"
                               name="primary_member"
                               value="<?= $h($fam['head_name']) ?>" readonly
                               placeholder="Enter primary member name"
                               required>
                    </div>

                    <div class="fte-field">
                        <label for="communityName">Community Name <span>*</span></label>
                        <input type="text"
                               id="communityName"
                               name="community_name" value="<?= $h($mfComm['name']) ?>" readonly
                               placeholder="Enter community name"
                               required>
                    </div>

                    <div class="fte-field">
                        <label for="familyReference">Family Tree Reference</label>
                        <input type="text"
                               id="familyReference"
                               name="family_reference" value="<?= $h(sprintf('PL-FAM-%06d', (int)$fam['id'])) ?>" readonly
                               placeholder="Enter reference ID, if available">
                        <small>Leave blank if you do not have a reference ID.</small>
                    </div>
                </div>
            </section>

            <!-- Request Type -->
            <section class="fte-form-section">
                <div class="fte-section-heading">
                    <div class="fte-heading-icon green">
                        <i class="bi bi-clipboard-check"></i>
                    </div>

                    <div>
                        <span class="fte-section-kicker">SECTION 02</span>
                        <h2>Request Type</h2>
                        <p>Choose the type of family-tree change you want to submit.</p>
                    </div>
                </div>

                <div class="fte-request-grid">
                    <label class="fte-request-option">
                        <input type="radio" name="request_type" value="add_member" required>
                        <span class="fte-request-icon"><i class="bi bi-person-plus"></i></span>
                        <span class="fte-request-copy">
                            <strong>Add Family Member</strong>
                            <small>Add a new person to the family tree.</small>
                        </span>
                        <span class="fte-radio-mark"></span>
                    </label>

                    <label class="fte-request-option">
                        <input type="radio" name="request_type" value="add_relationship">
                        <span class="fte-request-icon"><i class="bi bi-diagram-2"></i></span>
                        <span class="fte-request-copy">
                            <strong>Add Missing Relationship</strong>
                            <small>Connect family members correctly.</small>
                        </span>
                        <span class="fte-radio-mark"></span>
                    </label>

                    <label class="fte-request-option">
                        <input type="radio" name="request_type" value="correct_details">
                        <span class="fte-request-icon"><i class="bi bi-pencil-square"></i></span>
                        <span class="fte-request-copy">
                            <strong>Correct Existing Details</strong>
                            <small>Report incorrect family information.</small>
                        </span>
                        <span class="fte-radio-mark"></span>
                    </label>

                    <label class="fte-request-option">
                        <input type="radio" name="request_type" value="update_member">
                        <span class="fte-request-icon"><i class="bi bi-person-lines-fill"></i></span>
                        <span class="fte-request-copy">
                            <strong>Update Member Information</strong>
                            <small>Update a member's existing details.</small>
                        </span>
                        <span class="fte-radio-mark"></span>
                    </label>

                    <label class="fte-request-option">
                        <input type="radio" name="request_type" value="remove_information">
                        <span class="fte-request-icon"><i class="bi bi-person-dash"></i></span>
                        <span class="fte-request-copy">
                            <strong>Remove Incorrect Information</strong>
                            <small>Request removal of incorrect data.</small>
                        </span>
                        <span class="fte-radio-mark"></span>
                    </label>

                    <label class="fte-request-option">
                        <input type="radio" name="request_type" value="other">
                        <span class="fte-request-icon"><i class="bi bi-chat-square-text"></i></span>
                        <span class="fte-request-copy">
                            <strong>Other Family Tree Request</strong>
                            <small>Submit another family-tree request.</small>
                        </span>
                        <span class="fte-radio-mark"></span>
                    </label>
                </div>
            </section>

            <!-- Member Details -->
            <section class="fte-form-section">
                <div class="fte-section-heading">
                    <div class="fte-heading-icon purple">
                        <i class="bi bi-person-vcard"></i>
                    </div>

                    <div>
                        <span class="fte-section-kicker">SECTION 03</span>
                        <h2>Member Details</h2>
                        <p>Enter the details to add, correct or update.</p>
                    </div>
                </div>

                <div class="fte-fields-grid">
                    <div class="fte-field fte-field-full">
                        <label for="memberName">Full Name <span>*</span></label>
                        <input type="text"
                               id="memberName"
                               name="member_name"
                               placeholder="Enter full name"
                               required>
                    </div>

                    <div class="fte-field">
                        <label for="relationship">Relationship</label>
                        <select id="relationship" name="relationship">
                            <option value="">Select relationship</option>
                            <option>Grandfather</option>
                            <option>Grandmother</option>
                            <option>Father</option>
                            <option>Mother</option>
                            <option>Son</option>
                            <option>Daughter</option>
                            <option>Brother</option>
                            <option>Sister</option>
                            <option>Spouse</option>
                            <option>Uncle</option>
                            <option>Aunt</option>
                            <option>Cousin</option>
                            <option>Nephew</option>
                            <option>Niece</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="fte-field">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                            <option value="prefer_not_to_say">Prefer not to say</option>
                        </select>
                    </div>

                    <div class="fte-field">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="date_of_birth">
                    </div>

                    <div class="fte-field">
                        <label for="maritalStatus">Marital Status</label>
                        <select id="maritalStatus" name="marital_status">
                            <option value="">Select status</option>
                            <option>Single</option>
                            <option>Married</option>
                            <option>Widowed</option>
                            <option>Divorced</option>
                            <option>Prefer not to say</option>
                        </select>
                    </div>

                    <div class="fte-field">
                        <label for="education">Education</label>
                        <input type="text"
                               id="education"
                               name="education"
                               placeholder="e.g. Graduate, MBA">
                    </div>

                    <div class="fte-field">
                        <label for="profession">Profession / Occupation</label>
                        <input type="text"
                               id="profession"
                               name="profession"
                               placeholder="Enter profession">
                    </div>

                    <div class="fte-field">
                        <label for="currentCity">Current City</label>
                        <input type="text"
                               id="currentCity"
                               name="current_city"
                               placeholder="Enter current city">
                    </div>

                    <div class="fte-field">
                        <label for="nativePlace">Native Place</label>
                        <input type="text"
                               id="nativePlace"
                               name="native_place"
                               placeholder="Enter native place">
                    </div>
                </div>
            </section>

            <!-- Relationship Details -->
            <section class="fte-form-section">
                <div class="fte-section-heading">
                    <div class="fte-heading-icon orange">
                        <i class="bi bi-diagram-3"></i>
                    </div>

                    <div>
                        <span class="fte-section-kicker">SECTION 04</span>
                        <h2>Relationship Details</h2>
                        <p>Explain how this person connects to the existing family tree.</p>
                    </div>
                </div>

                <div class="fte-fields-grid">
                    <div class="fte-field">
                        <label for="relatedTo">Related To <span>*</span></label>
                        <input type="text"
                               id="relatedTo"
                               name="related_to"
                               placeholder="Enter existing family member's name"
                               required>
                    </div>

                    <div class="fte-field">
                        <label for="relationshipType">Relationship Type <span>*</span></label>
                        <select id="relationshipType" name="relationship_type" required>
                            <option value="">Select relationship type</option>
                            <option>Parent</option>
                            <option>Child</option>
                            <option>Spouse</option>
                            <option>Sibling</option>
                            <option>Grandparent</option>
                            <option>Grandchild</option>
                            <option>Uncle / Aunt</option>
                            <option>Nephew / Niece</option>
                            <option>Cousin</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="fte-field">
                        <label for="fatherDetails">Father's Name</label>
                        <input type="text"
                               id="fatherDetails"
                               name="father_details"
                               placeholder="Enter father's name, if applicable">
                    </div>

                    <div class="fte-field">
                        <label for="motherDetails">Mother's Name</label>
                        <input type="text"
                               id="motherDetails"
                               name="mother_details"
                               placeholder="Enter mother's name, if applicable">
                    </div>

                    <div class="fte-field fte-field-full">
                        <label for="spouseDetails">Spouse Details</label>
                        <input type="text"
                               id="spouseDetails"
                               name="spouse_details"
                               placeholder="Enter spouse's name, if applicable">
                    </div>
                </div>
            </section>

            <!-- Supporting Information -->
            <section class="fte-form-section">
                <div class="fte-section-heading">
                    <div class="fte-heading-icon blue">
                        <i class="bi bi-paperclip"></i>
                    </div>

                    <div>
                        <span class="fte-section-kicker">SECTION 05</span>
                        <h2>Supporting Information</h2>
                        <p>Attach relevant files or explain the requested change.</p>
                    </div>
                </div>

                <div class="fte-upload-grid">
                    <div class="fte-upload-box">
                        <label for="memberPhoto" class="fte-upload-label">
                            <span class="fte-upload-icon">
                                <i class="bi bi-image"></i>
                            </span>
                            <strong>Upload Photo</strong>
                            <small>JPG, PNG or WebP</small>
                            <span class="fte-upload-action">Choose Photo</span>
                        </label>

                        <input type="file"
                               id="memberPhoto"
                               name="member_photo"
                               accept="image/jpeg,image/png,image/webp">

                        <p class="fte-file-name" id="photoFileName">No file selected</p>
                    </div>

                    <div class="fte-upload-box">
                        <label for="supportDocument" class="fte-upload-label">
                            <span class="fte-upload-icon">
                                <i class="bi bi-file-earmark-text"></i>
                            </span>
                            <strong>Supporting Document</strong>
                            <small>PDF, JPG or PNG</small>
                            <span class="fte-upload-action">Choose Document</span>
                        </label>

                        <input type="file"
                               id="supportDocument"
                               name="supporting_document"
                               accept=".pdf,.jpg,.jpeg,.png">

                        <p class="fte-file-name" id="documentFileName">No file selected</p>
                    </div>
                </div>

                <div class="fte-field fte-notes-field">
                    <label for="notes">Notes / Explanation</label>
                    <textarea id="notes"
                              name="notes"
                              rows="5"
                              placeholder="Explain the missing information, correction or requested relationship..."></textarea>
                    <small>Do not include unnecessary sensitive personal information.</small>
                </div>
            </section>

            <!-- Contact Details -->
            <section class="fte-form-section">
                <div class="fte-section-heading">
                    <div class="fte-heading-icon green">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <div>
                        <span class="fte-section-kicker">SECTION 06</span>
                        <h2>Contact Details</h2>
                        <p>Provide contact information in case clarification is needed.</p>
                    </div>
                </div>

                <div class="fte-fields-grid">
                    <div class="fte-field">
                        <label for="contactName">Your Name <span>*</span></label>
                        <input type="text"
                               id="contactName"
                               name="contact_name" value="<?= $h($_POST['contact_name'] ?? $mfUser['name']) ?>"
                               placeholder="Enter your full name"
                               required>
                    </div>

                    <div class="fte-field">
                        <label for="mobileNumber">Mobile Number <span>*</span></label>
                        <input type="tel"
                               id="mobileNumber"
                               name="mobile_number" value="<?= $h($_POST['mobile_number'] ?? ($mfUser['phone'] ?? '')) ?>"
                               inputmode="tel"
                               placeholder="Enter mobile number"
                               required>
                    </div>

                    <div class="fte-field fte-field-full">
                        <label for="emailAddress">Email ID <span>*</span></label>
                        <input type="email"
                               id="emailAddress"
                               name="email" value="<?= $h($_POST['email'] ?? $mfUser['email']) ?>"
                               placeholder="you@example.com"
                               required>
                    </div>
                </div>

                <div class="fte-contact-note">
                    <i class="bi bi-shield-check"></i>
                    <span>Your contact details should only be accessible to authorised people handling this request.</span>
                </div>
            </section>

            <!-- Consent -->
            <section class="fte-consent-section">
                <label class="fte-checkbox-label">
                    <input type="checkbox" name="information_confirmation" required>
                    <span>
                        I confirm that the information provided is accurate to the
                        best of my knowledge and that I am authorised to submit it.
                    </span>
                </label>

                <label class="fte-checkbox-label">
                    <input type="checkbox" name="review_consent" required>
                    <span>
                        I understand that the information may be reviewed and verified
                        before being reflected in the family tree.
                    </span>
                </label>
            </section>

            <!-- Submit -->
            <div class="fte-submit-bar">
                <div>
                    <strong>Ready to submit?</strong>
                    <p>Review your information before sending the request.</p>
                </div>

                <div class="fte-submit-actions">
                    <button type="reset" class="fte-btn fte-btn-reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Form
                    </button>

                    <button type="submit" class="fte-btn fte-btn-primary">
                        <i class="bi bi-send"></i>
                        Submit Details
                    </button>
                </div>
            </div>
        </form>

        <!-- Success Message: demo only -->
        <section class="fte-success-panel" id="submissionSuccess"<?= $fteSent ? '' : ' hidden' ?>>
            <div class="fte-success-icon">
                <i class="bi bi-check-lg"></i>
            </div>

            <span class="fte-section-label">SUBMISSION RECEIVED</span>
            <h2>Family Tree Information Submitted Successfully</h2>

            <p>
                Your request has been saved and sent to the PeopleLink team for review.
            </p>

            <div class="fte-success-review">
                <i class="bi bi-shield-check"></i>
                <span>
                    The submitted information will be reviewed before being
                    reflected in the Family Tree, where verification is required.
                </span>
            </div>

            <div class="fte-request-reference">
                <span>Request ID</span>
                <strong id="successRequestId"><?= $fteSent ? $h($fteCode($fteSent['id'])) : '' ?></strong>
                <span>Submitted Date</span>
                <strong id="successSubmittedDate"><?= $fteSent ? $h(date('d M Y', strtotime($fteSent['created_at']))) : '—' ?></strong>
            </div>

            <button type="button" id="submitAnotherRequest" class="fte-btn fte-btn-primary">
                Submit Another Request
                <i class="bi bi-arrow-right"></i>
            </button>
        </section>

        <!-- Track Request -->
        <section class="fte-tracking-section" id="track">
            <div class="fte-tracking-heading">
                <div>
                    <span class="fte-section-label">REQUEST TRACKING</span>
                    <h2>Track Your Request</h2>
                    <p>Your family tree requests and their status.</p>
                </div>

                <div class="fte-tracking-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>

            <div class="fte-tracking-table-wrap">
                <table class="fte-tracking-table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Request Type</th>
                            <th>Submitted Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody id="trackingTableBody">
                        <?php foreach ($fteList as $r): [$sl, $sc] = $fteStatus[$r['status']] ?? ['Submitted', 'status-submitted']; ?>
                        <tr>
                            <td data-label="Request ID"><?= $h($fteCode($r['id'])) ?></td>
                            <td data-label="Request Type"><?= $h($fteType($r['message'])) ?></td>
                            <td data-label="Submitted Date"><?= $h(date('d M Y', strtotime($r['created_at']))) ?></td>
                            <td data-label="Status"><span class="fte-status <?= $sc ?>"><?= $h($sl) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (!$fteList): ?><tr><td colspan="4" style="text-align:center;padding:18px">You have not sent any family tree requests yet.</td></tr><?php endif; ?>
</tbody>
                </table>
            </div>

            <div class="fte-status-legend">
                <span><i class="legend-submitted"></i> Submitted</span>
                <span><i class="legend-review"></i> Under Review</span>
                <span><i class="legend-approved"></i> Approved</span>
                <span><i class="legend-rejected"></i> Rejected</span>
                <span><i class="legend-updated"></i> Updated</span>
            </div>

            <p class="fte-demo-note">
                <i class="bi bi-info-circle"></i>
                You can follow the status of each request here. You also get an alert when the admin replies.
            </p>
        </section>

    </div>
</main>

<div class="fte-toast" id="fteToast" role="status" aria-live="polite"></div>


<?php include 'footer.php'; ?>