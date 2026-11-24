
<?php
session_start();

$pageTitle = 'Offer Help | PeopleLink';

/*
|--------------------------------------------------------------------------
| DEMO REQUEST DATA
|--------------------------------------------------------------------------
| Replace with a database query using the request ID.
*/

$requestId = filter_input(INPUT_GET, 'request_id', FILTER_VALIDATE_INT);
$requestId = $requestId ?: 101;

$request = [
    'id' => $requestId,
    'title' => 'Help a Student Continue Their Education',
    'category' => 'Education Support',
    'community' => 'PeopleLink Community',
    'location' => 'Rishikesh, Uttarakhand',
    'urgency' => 'High',
    'status' => 'Active'
];

/*
|--------------------------------------------------------------------------
| HELPER DETAILS
|--------------------------------------------------------------------------
| Populate these fields from the authenticated user's profile.
*/

$helper = [
    'name' => $_SESSION['full_name'] ?? '',
    'mobile' => $_SESSION['mobile'] ?? '',
    'email' => $_SESSION['email'] ?? '',
    'community' => $_SESSION['community'] ?? ''
];

$helpTypes = [
    'Financial Support',
    'Medical Assistance',
    'Blood Donation',
    'Education Support',
    'Employment Guidance',
    'Material / Product Support',
    'Volunteer Support',
    'General Assistance',
    'Other'
];

$contactPreferences = ['Call', 'WhatsApp', 'Email'];

/*
|--------------------------------------------------------------------------
| SUCCESS SCREEN
|--------------------------------------------------------------------------
| Show this only after submit-support-offer.php has saved the offer
| successfully and redirected here.
*/

$isSuccess = isset($_GET['success']) &&
    $_GET['success'] === '1' &&
    isset($_SESSION['support_offer_confirmation']) &&
    (int) $_SESSION['support_offer_confirmation']['request_id'] === $requestId;

$confirmation = $isSuccess
    ? $_SESSION['support_offer_confirmation']
    : null;

if (empty($_SESSION['offer_csrf_token'])) {
    $_SESSION['offer_csrf_token'] = bin2hex(random_bytes(32));
}

function offer_h($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
 

<?php include 'header.php'; ?>

<main class="oh-page">

    <!-- Banner -->
    <section class="oh-banner">
        <div class="oh-container">

            <div class="oh-breadcrumb">
                <a href="index.php">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="support-requests.php">Community Support</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Offer Help</span>
            </div>

            <div class="oh-banner-content">
                <span class="oh-eyebrow">
                    <i class="fa-solid fa-heart-handshake"></i>
                    COMMUNITY CARE &amp; SUPPORT
                </span>

                <h1>Offer Help</h1>

                <p>
                    Every act of kindness matters. Share your skills,
                    resources or time to make a positive difference
                    in someone's life.
                </p>
            </div>
        </div>
    </section>

    <section class="oh-main-section">
        <div class="oh-container">

            <a href="support-request-details.php?id=<?php echo (int) $request['id']; ?>"
               class="oh-back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Support Request
            </a>

            <?php if ($isSuccess): ?>

                <!-- SUCCESS CONFIRMATION -->
                <section class="oh-success-card">

                    <div class="oh-success-icon">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <span class="oh-success-label">SUBMISSION CONFIRMED</span>

                    <h2>Your Offer of Help Has Been Submitted Successfully</h2>

                    <p class="oh-success-description">
                        Thank you for stepping forward to support your community.
                        Your offer has been recorded and can be reviewed by the
                        requester.
                    </p>

                    <div class="oh-confirmation-details">

                        <div class="oh-confirmation-row">
                            <span>Support Request</span>
                            <strong><?php echo offer_h($confirmation['request_title']); ?></strong>
                        </div>

                        <div class="oh-confirmation-row">
                            <span>Help Type</span>
                            <strong><?php echo offer_h($confirmation['help_type']); ?></strong>
                        </div>

                        <div class="oh-confirmation-row">
                            <span>Date Submitted</span>
                            <strong><?php echo offer_h($confirmation['date_submitted']); ?></strong>
                        </div>

                        <div class="oh-confirmation-row">
                            <span>Response Status</span>
                            <span class="oh-status oh-status-submitted">
                                <span class="oh-status-dot"></span>
                                <?php echo offer_h($confirmation['status']); ?>
                            </span>
                        </div>

                    </div>

                    <div class="oh-success-actions">
                        <a href="support-request-details.php?id=<?php echo (int) $request['id']; ?>"
                           class="oh-btn oh-btn-outline">
                            <i class="fa-solid fa-arrow-left"></i>
                            Back to Support Request
                        </a>

                        <a href="my-support-responses.php"
                           class="oh-btn oh-btn-primary">
                            <i class="fa-solid fa-list-check"></i>
                            View Requests I Responded To
                        </a>
                    </div>

                    <div class="oh-thank-you-note">
                        <i class="fa-solid fa-heart"></i>
                        Together, we can build a stronger and more caring community.
                    </div>

                </section>

            <?php else: ?>

                <div class="oh-layout">

                    <!-- MAIN FORM -->
                    <div class="oh-main-content">

                        <form id="offerHelpForm"
                              action="submit-support-offer.php"
                              method="POST"
                              novalidate>

                            <input type="hidden"
                                   name="csrf_token"
                                   value="<?php echo offer_h($_SESSION['offer_csrf_token']); ?>">

                            <input type="hidden"
                                   name="request_id"
                                   value="<?php echo (int) $request['id']; ?>">

                            <!-- Request Summary -->
                            <section class="oh-card oh-request-card">

                                <div class="oh-section-heading">
                                    <div class="oh-heading-icon oh-blue">
                                        <i class="fa-solid fa-hand-holding-heart"></i>
                                    </div>

                                    <div>
                                        <h2>Support Request Summary</h2>
                                        <p>Review the request before offering help.</p>
                                    </div>
                                </div>

                                <div class="oh-request-title-row">
                                    <div class="oh-request-symbol">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </div>

                                    <div class="oh-request-title-content">
                                        <span class="oh-category-label">
                                            <?php echo offer_h($request['category']); ?>
                                        </span>

                                        <h3><?php echo offer_h($request['title']); ?></h3>
                                    </div>
                                </div>

                                <div class="oh-request-badges">
                                    <span class="oh-status oh-status-active">
                                        <span class="oh-status-dot"></span>
                                        <?php echo offer_h($request['status']); ?>
                                    </span>

                                    <span class="oh-urgency">
                                        <i class="fa-solid fa-bolt"></i>
                                        <?php echo offer_h($request['urgency']); ?> Priority
                                    </span>
                                </div>

                                <div class="oh-request-info-grid">

                                    <div class="oh-info-item">
                                        <i class="fa-solid fa-layer-group"></i>
                                        <div>
                                            <span>Support Category</span>
                                            <strong><?php echo offer_h($request['category']); ?></strong>
                                        </div>
                                    </div>

                                    <div class="oh-info-item">
                                        <i class="fa-solid fa-users"></i>
                                        <div>
                                            <span>Community</span>
                                            <strong><?php echo offer_h($request['community']); ?></strong>
                                        </div>
                                    </div>

                                    <div class="oh-info-item">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <div>
                                            <span>Location</span>
                                            <strong><?php echo offer_h($request['location']); ?></strong>
                                        </div>
                                    </div>

                                    <div class="oh-info-item">
                                        <i class="fa-solid fa-shield-heart"></i>
                                        <div>
                                            <span>Request Status</span>
                                            <strong><?php echo offer_h($request['status']); ?></strong>
                                        </div>
                                    </div>

                                </div>

                            </section>

                            <!-- Helper Details -->
                            <section class="oh-card">

                                <div class="oh-section-heading">
                                    <div class="oh-heading-icon oh-green">
                                        <i class="fa-solid fa-user"></i>
                                    </div>

                                    <div>
                                        <h2>Your Details</h2>
                                        <p>Confirm your information so the requester can respond.</p>
                                    </div>
                                </div>

                                <div class="oh-form-grid">

                                    <div class="oh-field">
                                        <label for="helperName">
                                            Full Name <span>*</span>
                                        </label>
                                        <input type="text"
                                               id="helperName"
                                               name="full_name"
                                               value="<?php echo offer_h($helper['name']); ?>"
                                               maxlength="100"
                                               autocomplete="name"
                                               required
                                               placeholder="Enter your full name">
                                    </div>

                                    <div class="oh-field">
                                        <label for="helperMobile">
                                            Mobile Number <span>*</span>
                                        </label>
                                        <input type="tel"
                                               id="helperMobile"
                                               name="mobile"
                                               value="<?php echo offer_h($helper['mobile']); ?>"
                                               maxlength="20"
                                               autocomplete="tel"
                                               required
                                               placeholder="Enter your mobile number">
                                    </div>

                                    <div class="oh-field">
                                        <label for="helperEmail">
                                            Email Address <span>*</span>
                                        </label>
                                        <input type="email"
                                               id="helperEmail"
                                               name="email"
                                               value="<?php echo offer_h($helper['email']); ?>"
                                               maxlength="254"
                                               autocomplete="email"
                                               required
                                               placeholder="Enter your email address">
                                    </div>

                                    <div class="oh-field">
                                        <label for="helperCommunity">Community</label>
                                        <input type="text"
                                               id="helperCommunity"
                                               name="community"
                                               value="<?php echo offer_h($helper['community']); ?>"
                                               maxlength="120"
                                               placeholder="Enter your community">
                                    </div>

                                </div>

                                <p class="oh-field-note">
                                    <i class="fa-solid fa-circle-info"></i>
                                    Your profile information may be pre-filled when you are logged in.
                                </p>

                            </section>

                            <!-- Type of Help -->
                            <section class="oh-card">

                                <div class="oh-section-heading">
                                    <div class="oh-heading-icon oh-purple">
                                        <i class="fa-solid fa-handshake-angle"></i>
                                    </div>

                                    <div>
                                        <h2>Type of Help</h2>
                                        <p>Select the kind of assistance you can provide.</p>
                                    </div>
                                </div>

                                <div class="oh-help-type-grid">

                                    <?php foreach ($helpTypes as $index => $type): ?>
                                        <?php
                                        $icons = [
                                            'fa-coins',
                                            'fa-kit-medical',
                                            'fa-droplet',
                                            'fa-graduation-cap',
                                            'fa-briefcase',
                                            'fa-box-open',
                                            'fa-people-group',
                                            'fa-hand-holding-heart',
                                            'fa-ellipsis'
                                        ];
                                        ?>
                                        <label class="oh-help-option">
                                            <input type="radio"
                                                   name="help_type"
                                                   value="<?php echo offer_h($type); ?>"
                                                   required>

                                            <span class="oh-option-content">
                                                <span class="oh-option-icon">
                                                    <i class="fa-solid <?php echo $icons[$index]; ?>"></i>
                                                </span>
                                                <span class="oh-option-title">
                                                    <?php echo offer_h($type); ?>
                                                </span>
                                                <i class="fa-solid fa-circle-check oh-option-check"></i>
                                            </span>
                                        </label>
                                    <?php endforeach; ?>

                                </div>

                            </section>

                            <!-- Help Details -->
                            <section class="oh-card">

                                <div class="oh-section-heading">
                                    <div class="oh-heading-icon oh-orange">
                                        <i class="fa-solid fa-file-pen"></i>
                                    </div>

                                    <div>
                                        <h2>Help Details</h2>
                                        <p>Explain how you plan to support this request.</p>
                                    </div>
                                </div>

                                <div class="oh-field">
                                    <label for="helpDescription">
                                        How Would You Like to Help? <span>*</span>
                                    </label>
                                    <textarea id="helpDescription"
                                              name="help_description"
                                              rows="4"
                                              maxlength="3000"
                                              required
                                              placeholder="Describe the assistance you can provide..."></textarea>
                                    <small>Be specific about the help you can offer.</small>
                                </div>

                                <div class="oh-form-grid oh-details-grid">

                                    <div class="oh-field">
                                        <label for="helpQuantity">
                                            Amount / Quantity
                                        </label>
                                        <input type="number"
                                               id="helpQuantity"
                                               name="quantity"
                                               min="0.01"
                                               max="999999999"
                                               step="any"
                                               placeholder="Enter amount or quantity">

                                        <small id="quantityHint">
                                            Optional. Enter an amount or quantity if applicable.
                                        </small>
                                    </div>

                                    <div class="oh-field">
                                        <label for="quantityUnit">Unit</label>
                                        <select id="quantityUnit" name="quantity_unit">
                                            <option value="">Select unit</option>
                                            <option value="INR">Indian Rupees (₹)</option>
                                            <option value="Units">Units</option>
                                            <option value="Items">Items</option>
                                            <option value="Hours">Hours</option>
                                            <option value="Days">Days</option>
                                            <option value="Bags">Bags</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="oh-field oh-message-field">
                                    <label for="requesterMessage">
                                        Message to Requester <span>*</span>
                                    </label>
                                    <textarea id="requesterMessage"
                                              name="message"
                                              rows="4"
                                              maxlength="2000"
                                              required
                                              placeholder="Write a helpful message to the requester..."></textarea>
                                </div>

                            </section>

                            <!-- Contact Preference -->
                            <section class="oh-card">

                                <div class="oh-section-heading">
                                    <div class="oh-heading-icon oh-teal">
                                        <i class="fa-solid fa-comments"></i>
                                    </div>

                                    <div>
                                        <h2>Contact Preference</h2>
                                        <p>Choose how you prefer to be contacted.</p>
                                    </div>
                                </div>

                                <div class="oh-contact-options">

                                    <?php foreach ($contactPreferences as $index => $preference): ?>
                                        <?php
                                        $contactIcons = [
                                            'fa-phone',
                                            'fa-brands fa-whatsapp',
                                            'fa-envelope'
                                        ];
                                        ?>
                                        <label class="oh-contact-option">
                                            <input type="radio"
                                                   name="contact_preference"
                                                   value="<?php echo offer_h($preference); ?>"
                                                   <?php echo $index === 0 ? 'checked' : ''; ?>
                                                   required>

                                            <span>
                                                <i class="fa-solid <?php echo $contactIcons[$index]; ?>"></i>
                                                <?php echo offer_h($preference); ?>
                                            </span>
                                        </label>
                                    <?php endforeach; ?>

                                </div>

                                <div class="oh-privacy-box">
                                    <div class="oh-privacy-icon">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>

                                    <div class="oh-privacy-copy">
                                        <strong>Contact Privacy</strong>
                                        <p>
                                            Choose whether the requester may see your
                                            contact information for this offer.
                                        </p>
                                    </div>

                                    <label class="oh-switch">
                                        <input type="checkbox"
                                               name="allow_contact_details"
                                               value="1"
                                               id="allowContactDetails">
                                        <span class="oh-switch-slider"></span>
                                    </label>
                                </div>

                                <p class="oh-privacy-note">
                                    <i class="fa-solid fa-lock"></i>
                                    Your contact details will only be shared according
                                    to your selection and the platform's privacy rules.
                                </p>

                            </section>

                            <!-- Consent -->
                            <section class="oh-consent-card">
                                <label class="oh-checkbox">
                                    <input type="checkbox"
                                           name="confirm_information"
                                           value="1"
                                           required>
                                    <span>
                                        I confirm that the information provided is accurate
                                        and that I am genuinely willing to offer the
                                        assistance described above.
                                    </span>
                                </label>
                            </section>

                            <!-- Submit -->
                            <div class="oh-submit-area">
                                <button type="submit"
                                        class="oh-btn oh-btn-primary oh-submit-btn">
                                    <i class="fa-solid fa-hand-holding-heart"></i>
                                    Offer Help
                                    <i class="fa-solid fa-arrow-right oh-submit-arrow"></i>
                                </button>

                                <p>
                                    <i class="fa-solid fa-shield-halved"></i>
                                    Your offer will be submitted for the requester's review.
                                </p>
                            </div>

                        </form>

                    </div>

                    <!-- SIDEBAR -->
                    <aside class="oh-sidebar">

                        <section class="oh-sidebar-card oh-sidebar-help">

                            <div class="oh-sidebar-heart">
                                <i class="fa-solid fa-heart"></i>
                            </div>

                            <span class="oh-sidebar-eyebrow">YOUR KINDNESS MATTERS</span>

                            <h3>A Small Act Can Make a Big Difference</h3>

                            <p>
                                Your skills, resources and willingness to help
                                can bring hope to another community member.
                            </p>

                            <div class="oh-sidebar-points">
                                <div>
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Support people in need</span>
                                </div>
                                <div>
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Choose the help you can provide</span>
                                </div>
                                <div>
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Respect privacy and dignity</span>
                                </div>
                            </div>

                        </section>

                        <section class="oh-sidebar-card">
                            <div class="oh-sidebar-title">
                                <i class="fa-solid fa-list-check"></i>
                                <h3>What Happens Next?</h3>
                            </div>

                            <div class="oh-steps">

                                <div class="oh-step">
                                    <span class="oh-step-number">1</span>
                                    <div>
                                        <strong>Submit Your Offer</strong>
                                        <p>Share your proposed assistance.</p>
                                    </div>
                                </div>

                                <div class="oh-step">
                                    <span class="oh-step-number">2</span>
                                    <div>
                                        <strong>Requester Reviews</strong>
                                        <p>The requester can review your offer.</p>
                                    </div>
                                </div>

                                <div class="oh-step">
                                    <span class="oh-step-number">3</span>
                                    <div>
                                        <strong>Connect and Coordinate</strong>
                                        <p>Arrange the assistance if accepted.</p>
                                    </div>
                                </div>

                            </div>
                        </section>

                        <section class="oh-sidebar-card oh-safety-card">
                            <div class="oh-sidebar-title">
                                <i class="fa-solid fa-shield-heart"></i>
                                <h3>Safety Reminder</h3>
                            </div>

                            <p>
                                Protect your personal information. Never share
                                OTPs, passwords or banking credentials. Verify
                                the request before making financial contributions.
                            </p>
                        </section>

                    </aside>

                </div>

            <?php endif; ?>

        </div>
    </section>

</main>

<div class="oh-toast" id="ohToast" role="status" aria-live="polite">
    <i class="fa-solid fa-circle-exclamation"></i>
    <span id="ohToastMessage"></span>
</div>

<?php include 'footer.php'; ?>

 
 
