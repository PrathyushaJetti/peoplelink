
<?php
// support-request-details.php
// Sample frontend content. Connect your database to load real requests.
$requestId = isset($_GET['id']) ? (int) $_GET['id'] : 1;

$request = [
    'title' => 'Help a Student Continue Their Education',
    'category' => 'Education Support',
    'community' => 'PeopleLink Community',
    'location' => 'Rishikesh, Uttarakhand',
    'date' => '15 October 2026',
    'urgency' => 'High Priority',
    'status' => 'Active',
    'short_description' => 'A family needs financial assistance to help a student continue their education.',
    'description' => 'The family is facing financial difficulties and requires assistance with tuition fees, books, school supplies and other essential educational expenses. Community members can help the student continue studying and work toward a brighter future.',
    'amount' => 25000,
    'people' => 1,
    'reason' => 'Temporary financial hardship has made it difficult for the family to manage educational expenses.',
    'requester' => 'Community Member',
    'phone' => '',
    'email' => '',
    'allow_phone' => false,
    'allow_email' => false
];

$currency = '₹' . number_format($request['amount']);

$relatedRequests = [
    [
        'title' => 'School Supplies for Students',
        'category' => 'Education Support',
        'location' => 'Rishikesh, Uttarakhand',
        'status' => 'Active',
        'icon' => 'fa-book-open',
        'color' => 'blue'
    ],
    [
        'title' => 'Educational Assistance Fund',
        'category' => 'Community Welfare',
        'location' => 'Dehradun, Uttarakhand',
        'status' => 'Active',
        'icon' => 'fa-graduation-cap',
        'color' => 'green'
    ],
    [
        'title' => 'Support for a Needy Family',
        'category' => 'Family Support',
        'location' => 'Haridwar, Uttarakhand',
        'status' => 'Active',
        'icon' => 'fa-house-heart',
        'color' => 'orange'
    ]
];
?>
 

<?php include 'header.php'; ?>

<main class="pl-support-page">

    <!-- Page Banner -->
    <section class="pl-page-banner">
        <div class="pl-container">
            <div class="pl-breadcrumb">
                <a href="index.php">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <a href="support-requests.php">Community Support</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Request Details</span>
            </div>

            <div class="pl-banner-content">
                <span class="pl-eyebrow">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                    COMMUNITY CARE &amp; SUPPORT
                </span>

                <h1>Support Request Details</h1>

                <p>
                    Every helping hand matters. Discover community needs,
                    connect with people and make a meaningful difference.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="pl-main-section">
        <div class="pl-container">

            <div class="pl-back-row">
                <a href="support-requests.php" class="pl-back-link">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Support Requests
                </a>

                <button type="button" class="pl-share-btn" id="shareRequest">
                    <i class="fa-solid fa-share-nodes"></i>
                    Share Request
                </button>
            </div>

            <div class="pl-details-layout">

                <!-- LEFT CONTENT -->
                <div class="pl-primary-content">

                    <!-- Request Header -->
                    <article class="pl-card pl-request-header">

                        <div class="pl-request-top">
                            <div class="pl-category-icon">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>

                            <div class="pl-request-heading">
                                <span class="pl-category-label">
                                    <?php echo htmlspecialchars($request['category']); ?>
                                </span>

                                <h2>
                                    <?php echo htmlspecialchars($request['title']); ?>
                                </h2>

                                <div class="pl-request-meta">
                                    <span>
                                        <i class="fa-solid fa-location-dot"></i>
                                        <?php echo htmlspecialchars($request['location']); ?>
                                    </span>

                                    <span>
                                        <i class="fa-regular fa-calendar"></i>
                                        <?php echo htmlspecialchars($request['date']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="pl-badge-row">
                            <span class="pl-badge pl-badge-active">
                                <span class="pl-status-dot"></span>
                                <?php echo htmlspecialchars($request['status']); ?>
                            </span>

                            <span class="pl-badge pl-badge-urgent">
                                <i class="fa-solid fa-bolt"></i>
                                <?php echo htmlspecialchars($request['urgency']); ?>
                            </span>

                            <span class="pl-badge pl-badge-neutral">
                                <i class="fa-solid fa-users"></i>
                                <?php echo htmlspecialchars($request['community']); ?>
                            </span>
                        </div>

                        <div class="pl-request-intro">
                            <p>
                                <?php echo htmlspecialchars($request['short_description']); ?>
                            </p>
                        </div>

                        <div class="pl-quick-stats">

                            <div class="pl-stat-box">
                                <div class="pl-stat-icon pl-stat-blue">
                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                </div>
                                <div>
                                    <span>Amount Required</span>
                                    <strong><?php echo $currency; ?></strong>
                                </div>
                            </div>

                            <div class="pl-stat-box">
                                <div class="pl-stat-icon pl-stat-green">
                                    <i class="fa-solid fa-user-group"></i>
                                </div>
                                <div>
                                    <span>People Affected</span>
                                    <strong><?php echo (int) $request['people']; ?> Student</strong>
                                </div>
                            </div>

                        </div>

                        <button type="button"
                                class="pl-btn pl-btn-primary pl-btn-full"
                                id="openHelpModal">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                            Offer Help
                            <i class="fa-solid fa-arrow-right pl-btn-arrow"></i>
                        </button>

                        <p class="pl-secure-note">
                            <i class="fa-solid fa-shield-halved"></i>
                            Please verify the request and supporting information
                            before making a contribution.
                        </p>
                    </article>

                    <!-- Request Summary -->
                    <section class="pl-card pl-content-card">
                        <div class="pl-section-heading">
                            <div class="pl-heading-icon">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </div>
                            <div>
                                <h3>Request Summary</h3>
                                <p>Important information about this request</p>
                            </div>
                        </div>

                        <div class="pl-summary-grid">
                            <div class="pl-summary-item">
                                <span>Request Title</span>
                                <strong><?php echo htmlspecialchars($request['title']); ?></strong>
                            </div>

                            <div class="pl-summary-item">
                                <span>Support Category</span>
                                <strong><?php echo htmlspecialchars($request['category']); ?></strong>
                            </div>

                            <div class="pl-summary-item">
                                <span>Community Name</span>
                                <strong><?php echo htmlspecialchars($request['community']); ?></strong>
                            </div>

                            <div class="pl-summary-item">
                                <span>Location</span>
                                <strong><?php echo htmlspecialchars($request['location']); ?></strong>
                            </div>

                            <div class="pl-summary-item">
                                <span>Date Posted</span>
                                <strong><?php echo htmlspecialchars($request['date']); ?></strong>
                            </div>

                            <div class="pl-summary-item">
                                <span>Urgency Level</span>
                                <strong class="pl-text-urgent">
                                    <?php echo htmlspecialchars($request['urgency']); ?>
                                </strong>
                            </div>
                        </div>
                    </section>

                    <!-- Description -->
                    <section class="pl-card pl-content-card">
                        <div class="pl-section-heading">
                            <div class="pl-heading-icon pl-heading-green">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div>
                                <h3>Request Description</h3>
                                <p>Understand the requirement and reason for support</p>
                            </div>
                        </div>

                        <div class="pl-description-block">
                            <h4>Short Description</h4>
                            <p><?php echo htmlspecialchars($request['short_description']); ?></p>
                        </div>

                        <div class="pl-description-block">
                            <h4>Detailed Requirement</h4>
                            <p><?php echo htmlspecialchars($request['description']); ?></p>
                        </div>

                        <div class="pl-description-block">
                            <h4>Reason for Support</h4>
                            <p><?php echo htmlspecialchars($request['reason']); ?></p>
                        </div>

                        <div class="pl-amount-highlight">
                            <div class="pl-amount-icon">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                            <div>
                                <span>Requested Support Amount</span>
                                <strong><?php echo $currency; ?></strong>
                            </div>
                            <span class="pl-optional-note">As applicable</span>
                        </div>
                    </section>

                    <!-- Supporting Documents -->
                    <section class="pl-card pl-content-card">
                        <div class="pl-section-heading">
                            <div class="pl-heading-icon pl-heading-orange">
                                <i class="fa-solid fa-folder-open"></i>
                            </div>
                            <div>
                                <h3>Supporting Documents</h3>
                                <p>Documents provided to support this request</p>
                            </div>
                        </div>

                        <!-- Demo attachments. Load real, authorized attachments here. -->
                        <div class="pl-document-list">

                            <div class="pl-document-item">
                                <div class="pl-document-icon pl-pdf-icon">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>
                                <div class="pl-document-info">
                                    <strong>Education Fee Receipt.pdf</strong>
                                    <span>PDF document · Sample attachment</span>
                                </div>
                                <button type="button"
                                        class="pl-icon-btn"
                                        aria-label="View education receipt"
                                        data-demo-document="Education Fee Receipt.pdf">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>

                            <div class="pl-document-item">
                                <div class="pl-document-icon pl-image-icon">
                                    <i class="fa-solid fa-file-image"></i>
                                </div>
                                <div class="pl-document-info">
                                    <strong>Supporting Image.jpg</strong>
                                    <span>Image document · Sample attachment</span>
                                </div>
                                <button type="button"
                                        class="pl-icon-btn"
                                        aria-label="View supporting image"
                                        data-demo-document="Supporting Image.jpg">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                            </div>

                        </div>

                        <div class="pl-privacy-notice">
                            <i class="fa-solid fa-lock"></i>
                            <p>
                                Medical records, identity documents and other
                                sensitive files must be accessible only to
                                authorized users.
                            </p>
                        </div>
                    </section>

                    <!-- Support Status -->
                    <section class="pl-card pl-content-card">
                        <div class="pl-section-heading">
                            <div class="pl-heading-icon pl-heading-purple">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <div>
                                <h3>Support Status</h3>
                                <p>Current stage of the request</p>
                            </div>
                        </div>

                        <div class="pl-current-status">
                            <span class="pl-status-dot"></span>
                            <div>
                                <strong><?php echo htmlspecialchars($request['status']); ?></strong>
                                <p>This request is currently accepting offers of help.</p>
                            </div>
                        </div>

                        <div class="pl-status-legend">
                            <span class="pl-status-pending">Pending Approval</span>
                            <span class="pl-status-active">Active</span>
                            <span class="pl-status-received">Support Received</span>
                            <span class="pl-status-completed">Completed</span>
                            <span class="pl-status-closed">Closed</span>
                        </div>
                    </section>

                    <!-- Related Requests -->
                    <section class="pl-related-section">
                        <div class="pl-related-heading">
                            <div>
                                <span class="pl-eyebrow pl-eyebrow-dark">
                                    MORE WAYS TO HELP
                                </span>
                                <h3>Similar Support Requests</h3>
                                <p>Explore other community needs</p>
                            </div>

                            <a href="support-requests.php" class="pl-view-all">
                                View All <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>

                        <div class="pl-related-grid">
                            <?php foreach ($relatedRequests as $related): ?>
                                <article class="pl-related-card">

                                    <div class="pl-related-card-top">
                                        <div class="pl-related-icon pl-related-<?php echo htmlspecialchars($related['color']); ?>">
                                            <i class="fa-solid <?php echo htmlspecialchars($related['icon']); ?>"></i>
                                        </div>
                                        <span class="pl-related-status">
                                            <span class="pl-status-dot"></span>
                                            <?php echo htmlspecialchars($related['status']); ?>
                                        </span>
                                    </div>

                                    <span class="pl-related-category">
                                        <?php echo htmlspecialchars($related['category']); ?>
                                    </span>

                                    <h4><?php echo htmlspecialchars($related['title']); ?></h4>

                                    <p>
                                        <i class="fa-solid fa-location-dot"></i>
                                        <?php echo htmlspecialchars($related['location']); ?>
                                    </p>

                                    <a href="support-requests.php"
                                       class="pl-related-link">
                                        View Request
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </section>

                </div>

                <!-- RIGHT SIDEBAR -->
                <aside class="pl-sidebar">

                    <!-- Requester Information -->
                    <section class="pl-card pl-sidebar-card">
                        <div class="pl-sidebar-title">
                            <i class="fa-solid fa-user-shield"></i>
                            <h3>Requester Information</h3>
                        </div>

                        <div class="pl-requester-profile">
                            <div class="pl-avatar">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                                <strong><?php echo htmlspecialchars($request['requester']); ?></strong>
                                <span>Community Member</span>
                            </div>
                        </div>

                        <div class="pl-contact-detail">
                            <i class="fa-solid fa-users"></i>
                            <div>
                                <span>Community</span>
                                <strong><?php echo htmlspecialchars($request['community']); ?></strong>
                            </div>
                        </div>

                        <div class="pl-contact-detail">
                            <i class="fa-solid fa-location-dot"></i>
                            <div>
                                <span>Location</span>
                                <strong><?php echo htmlspecialchars($request['location']); ?></strong>
                            </div>
                        </div>

                        <?php if ($request['allow_phone'] && !empty($request['phone'])): ?>
                            <div class="pl-contact-detail">
                                <i class="fa-solid fa-phone"></i>
                                <div>
                                    <span>Mobile Number</span>
                                    <strong><?php echo htmlspecialchars($request['phone']); ?></strong>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($request['allow_email'] && !empty($request['email'])): ?>
                            <div class="pl-contact-detail">
                                <i class="fa-solid fa-envelope"></i>
                                <div>
                                    <span>Email Address</span>
                                    <strong><?php echo htmlspecialchars($request['email']); ?></strong>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="pl-sidebar-privacy">
                            <i class="fa-solid fa-shield-halved"></i>
                            Contact information is shown only when permitted
                            by the requester's privacy settings.
                        </div>

                        <button type="button"
                                class="pl-btn pl-btn-outline pl-btn-full"
                                id="openMessageModal">
                            <i class="fa-regular fa-message"></i>
                            Send Message
                        </button>

                        <?php if ($request['allow_phone'] && !empty($request['phone'])): ?>
                            <a href="tel:<?php echo htmlspecialchars($request['phone'], ENT_QUOTES); ?>"
                               class="pl-btn pl-btn-call pl-btn-full">
                                <i class="fa-solid fa-phone"></i> Call Requester
                            </a>

                            <a href="https://wa.me/<?php echo preg_replace('/\D+/', '', $request['phone']); ?>"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="pl-btn pl-btn-whatsapp pl-btn-full">
                                <i class="fa-brands fa-whatsapp"></i> WhatsApp
                            </a>
                        <?php endif; ?>

                        <?php if ($request['allow_email'] && !empty($request['email'])): ?>
                            <a href="mailto:<?php echo htmlspecialchars($request['email'], ENT_QUOTES); ?>"
                               class="pl-btn pl-btn-outline pl-btn-full">
                                <i class="fa-solid fa-envelope"></i> Email Requester
                            </a>
                        <?php endif; ?>
                    </section>

                    <!-- Offer Help Card -->
                    <section class="pl-help-sidebar">
                        <div class="pl-help-decoration">
                            <i class="fa-solid fa-heart"></i>
                        </div>

                        <span class="pl-help-kicker">BE THE REASON SOMEONE SMILES</span>
                        <h3>Your Support Can Change a Life</h3>
                        <p>
                            Your time, resources or contribution can make a
                            real difference to a family in need.
                        </p>

                        <button type="button"
                                class="pl-btn pl-btn-white pl-btn-full"
                                id="sidebarOfferHelp">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                            Offer Help Now
                        </button>

                        <div class="pl-help-footer">
                            <i class="fa-solid fa-shield-heart"></i>
                            Help responsibly. Verify before contributing.
                        </div>
                    </section>

                    <!-- Share Card -->
                    <section class="pl-card pl-share-card">
                        <div class="pl-sidebar-title">
                            <i class="fa-solid fa-share-nodes"></i>
                            <h3>Spread the Word</h3>
                        </div>

                        <p>
                            Share this request with friends and community
                            members who may be able to help.
                        </p>

                        <button type="button"
                                class="pl-btn pl-btn-outline pl-btn-full"
                                id="sidebarShare">
                            <i class="fa-solid fa-share"></i>
                            Share Request
                        </button>
                    </section>

                </aside>

            </div>
        </div>
    </section>

</main>

<!-- Offer Help Modal -->
<div class="pl-modal" id="helpModal" aria-hidden="true">
    <div class="pl-modal-overlay" data-close-modal></div>

    <div class="pl-modal-dialog" role="dialog"
         aria-modal="true" aria-labelledby="helpModalTitle">

        <div class="pl-modal-header">
            <div>
                <span class="pl-eyebrow pl-eyebrow-dark">COMMUNITY SUPPORT</span>
                <h2 id="helpModalTitle">Offer Help</h2>
                <p>Let the requester know how you can help.</p>
            </div>
            <button type="button" class="pl-modal-close" data-close-modal
                    aria-label="Close modal">&times;</button>
        </div>

        <form id="helpForm" action="submit-support-offer.php" method="POST">
            <input type="hidden" name="request_id"
                   value="<?php echo (int) $requestId; ?>">

            <div class="pl-form-group">
                <label for="helpType">How would you like to help?</label>
                <select name="help_type" id="helpType" required>
                    <option value="">Select support type</option>
                    <option value="financial">Financial Contribution</option>
                    <option value="materials">Books / Educational Materials</option>
                    <option value="services">Services or Assistance</option>
                    <option value="volunteer">Volunteer Support</option>
                    <option value="other">Other Support</option>
                </select>
            </div>

            <div class="pl-form-group" id="amountGroup" hidden>
                <label for="contributionAmount">Contribution Amount (₹)</label>
                <input type="number" id="contributionAmount"
                       name="contribution_amount" min="1" step="1"
                       placeholder="Enter amount">
            </div>

            <div class="pl-form-group">
                <label for="supportName">Your Name</label>
                <input type="text" id="supportName" name="support_name"
                       maxlength="100" required
                       placeholder="Enter your full name">
            </div>

            <div class="pl-form-group">
                <label for="supportEmail">Email Address</label>
                <input type="email" id="supportEmail" name="support_email"
                       maxlength="254" required
                       placeholder="Enter your email address">
            </div>

            <div class="pl-form-group">
                <label for="supportMessage">Message</label>
                <textarea id="supportMessage" name="message"
                          rows="4" maxlength="2000"
                          placeholder="Tell the requester how you can help..."
                          required></textarea>
            </div>

            <label class="pl-checkbox-row">
                <input type="checkbox" name="contact_consent"
                       value="1" required>
                <span>I agree to be contacted about this support offer.</span>
            </label>

            <button type="submit" class="pl-btn pl-btn-primary pl-btn-full">
                Submit Offer
                <i class="fa-solid fa-arrow-right"></i>
            </button>

            <p class="pl-form-note">
                Your offer should be processed securely. Do not include
                bank passwords, OTPs or other sensitive credentials.
            </p>
        </form>
    </div>
</div>

<!-- Send Message Modal -->
<div class="pl-modal" id="messageModal" aria-hidden="true">
    <div class="pl-modal-overlay" data-close-modal></div>

    <div class="pl-modal-dialog" role="dialog"
         aria-modal="true" aria-labelledby="messageModalTitle">

        <div class="pl-modal-header">
            <div>
                <span class="pl-eyebrow pl-eyebrow-dark">CONNECT &amp; HELP</span>
                <h2 id="messageModalTitle">Send a Message</h2>
                <p>Send a message about this support request.</p>
            </div>
            <button type="button" class="pl-modal-close" data-close-modal
                    aria-label="Close modal">&times;</button>
        </div>

        <form id="messageForm" action="submit-support-message.php" method="POST">
            <input type="hidden" name="request_id"
                   value="<?php echo (int) $requestId; ?>">

            <div class="pl-form-group">
                <label for="messageName">Your Name</label>
                <input type="text" id="messageName" name="sender_name"
                       maxlength="100" required placeholder="Your name">
            </div>

            <div class="pl-form-group">
                <label for="messageEmail">Email Address</label>
                <input type="email" id="messageEmail" name="sender_email"
                       maxlength="254" required placeholder="Your email">
            </div>

            <div class="pl-form-group">
                <label for="messageContent">Your Message</label>
                <textarea id="messageContent" name="message"
                          rows="5" maxlength="2000" required
                          placeholder="Write your message here..."></textarea>
            </div>

            <button type="submit" class="pl-btn pl-btn-primary pl-btn-full">
                <i class="fa-regular fa-paper-plane"></i>
                Send Message
            </button>

            <p class="pl-form-note">
                This form requires a secure backend to deliver messages.
            </p>
        </form>
    </div>
</div>

<!-- Toast -->
<div class="pl-toast" id="plToast" role="status" aria-live="polite">
    <i class="fa-solid fa-circle-check"></i>
    <span id="plToastMessage">Link copied successfully.</span>
</div>

<?php include 'footer.php'; ?>

 