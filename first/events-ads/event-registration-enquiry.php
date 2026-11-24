<?php
include 'header.php';

/* Demo context. In production, load event/ad data by validated ID and current user from the database. */
$type = strtolower(trim($_GET['type'] ?? 'event-registration'));
$allowedTypes = ['event-registration', 'event-enquiry', 'advertisement-enquiry'];
if (!in_array($type, $allowedTypes, true)) $type = 'event-registration';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 101;

$event = [
  'id' => 101, 'name' => 'PeopleLink Community Networking Meet', 'date' => '24 October 2026',
  'time' => '10:00 AM – 2:00 PM', 'venue' => 'Community Hall, Rishikesh, Uttarakhand',
  'organiser' => 'PeopleLink Community Team', 'fee' => 'Free',
];
$ad = [
  'id' => 104, 'title' => 'Premium Home Interior Consultation', 'business' => 'Elite Interior Studios',
  'category' => 'Home & Interior', 'location' => 'Ghaziabad, Uttar Pradesh',
  'phone' => '+919876543210', 'email' => 'hello@example.com', 'whatsapp' => '919876543210',
];
$pageTitle = $type === 'event-registration' ? 'Event Registration' : ($type === 'event-enquiry' ? 'Event Enquiry' : 'Advertisement Enquiry');
?>
<link rel="stylesheet" href="css/event-registration-enquiry.css">
<main class="pl-enquiry-page" data-mode="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>">
  <section class="pl-enquiry-hero">
    <div class="pl-hero-orb orb-one"></div><div class="pl-hero-orb orb-two"></div>
    <div class="pl-container pl-hero-inner">
      <div>
        <span class="pl-eyebrow"><i class="fa-solid fa-people-group"></i> PEOPLELINK COMMUNITY</span>
        <h1><?= htmlspecialchars($pageTitle) ?></h1>
        <p>Connect with your community, join meaningful events, and reach trusted businesses through one simple form.</p>
        <div class="pl-hero-trust"><span><i class="fa-solid fa-shield-halved"></i> Your details stay protected</span><span><i class="fa-solid fa-circle-check"></i> Simple and secure process</span></div>
      </div>
      <div class="pl-hero-art" aria-hidden="true"><div class="art-ring ring-a"></div><div class="art-ring ring-b"></div><div class="art-center"><i class="fa-solid fa-handshake-angle"></i></div><span class="art-chip chip-a"><i class="fa-solid fa-calendar-check"></i> Events</span><span class="art-chip chip-b"><i class="fa-solid fa-comments"></i> Enquiries</span><span class="art-chip chip-c"><i class="fa-solid fa-users"></i> Community</span></div>
    </div>
  </section>

  <section class="pl-container pl-main-content">
    <div class="pl-step-strip"><span class="step active"><b>1</b><span>Your details</span></span><span class="step-line"></span><span class="step"><b>2</b><span>Review</span></span><span class="step-line"></span><span class="step"><b>3</b><span>Confirmation</span></span></div>
    <div class="pl-workspace">
      <div class="pl-form-column">
        <div class="pl-form-card">
          <div class="pl-card-heading"><div class="heading-icon"><i class="fa-solid <?= $type === 'advertisement-enquiry' ? 'fa-store' : ($type === 'event-enquiry' ? 'fa-message' : 'fa-calendar-check') ?>"></i></div><div><span class="pl-kicker">LET'S GET STARTED</span><h2><?= htmlspecialchars($pageTitle) ?></h2><p>Fields marked with <em>*</em> are required.</p></div></div>

          <div class="pl-mode-switch" role="group" aria-label="Choose form type">
            <a class="<?= $type === 'event-registration' ? 'selected' : '' ?>" href="?type=event-registration&id=<?= (int)$event['id'] ?>"><i class="fa-solid fa-ticket"></i> Register for event</a>
            <a class="<?= $type === 'event-enquiry' ? 'selected' : '' ?>" href="?type=event-enquiry&id=<?= (int)$event['id'] ?>"><i class="fa-solid fa-comments"></i> Event enquiry</a>
            <a class="<?= $type === 'advertisement-enquiry' ? 'selected' : '' ?>" href="?type=advertisement-enquiry&id=<?= (int)$ad['id'] ?>"><i class="fa-solid fa-store"></i> Ad enquiry</a>
          </div>

          <?php if ($type !== 'advertisement-enquiry'): ?>
          <div class="pl-summary-box event-summary">
            <div class="summary-cover"><div class="cover-pattern"></div><span class="summary-label"><i class="fa-solid fa-calendar-days"></i> COMMUNITY EVENT</span><span class="summary-date"><strong>24</strong><small>OCT<br>2026</small></span></div>
            <div class="summary-body"><div class="summary-topline"><span class="status-pill free-pill"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($event['fee']) ?> Entry</span><span class="summary-id">Event #<?= (int)$event['id'] ?></span></div><h3><?= htmlspecialchars($event['name']) ?></h3><div class="summary-grid"><span><i class="fa-regular fa-calendar"></i><?= htmlspecialchars($event['date']) ?></span><span><i class="fa-regular fa-clock"></i><?= htmlspecialchars($event['time']) ?></span><span><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($event['venue']) ?></span><span><i class="fa-solid fa-user-group"></i><?= htmlspecialchars($event['organiser']) ?></span></div><a class="summary-link" href="event-ad-details.php?id=<?= (int)$event['id'] ?>&type=event"><i class="fa-solid fa-arrow-up-right-from-square"></i> View event details</a></div>
          </div>
          <?php else: ?>
          <div class="pl-summary-box ad-summary"><div class="ad-summary-icon"><i class="fa-solid fa-house-chimney-window"></i><span class="ad-mini-badge">FEATURED</span></div><div class="ad-summary-content"><div class="summary-topline"><span class="status-pill ad-pill"><i class="fa-solid fa-bullhorn"></i> Advertisement</span><span class="summary-id">Listing #<?= (int)$ad['id'] ?></span></div><h3><?= htmlspecialchars($ad['title']) ?></h3><p class="ad-business"><i class="fa-solid fa-building"></i> <?= htmlspecialchars($ad['business']) ?></p><div class="summary-grid"><span><i class="fa-solid fa-layer-group"></i><?= htmlspecialchars($ad['category']) ?></span><span><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($ad['location']) ?></span></div><a class="summary-link" href="event-ad-details.php?id=<?= (int)$ad['id'] ?>&type=advertisement"><i class="fa-solid fa-arrow-up-right-from-square"></i> View advertisement</a></div></div>
          <?php endif; ?>

          <form id="plEnquiryForm" novalidate data-mode="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="mode" value="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>"><input type="hidden" name="listing_id" value="<?= (int)($type === 'advertisement-enquiry' ? $ad['id'] : $event['id']) ?>">
            <div class="form-section-title"><span class="section-number">01</span><div><h3><?= $type === 'event-registration' ? 'Participant details' : 'Your contact details' ?></h3><p>Tell us how we can reach you.</p></div></div>
            <div class="pl-fields-grid">
              <div class="pl-field"><label for="fullName">Full name <em>*</em></label><div class="input-wrap"><i class="fa-regular fa-user"></i><input id="fullName" name="full_name" type="text" placeholder="Enter your full name" autocomplete="name" required></div><small class="field-error"></small></div>
              <div class="pl-field"><label for="mobile">Mobile number <em>*</em></label><div class="input-wrap"><i class="fa-solid fa-mobile-screen-button"></i><input id="mobile" name="mobile" type="tel" placeholder="10-digit mobile number" autocomplete="tel" inputmode="tel" required></div><small class="field-error"></small></div>
              <div class="pl-field"><label for="email">Email address <em>*</em></label><div class="input-wrap"><i class="fa-regular fa-envelope"></i><input id="email" name="email" type="email" placeholder="you@example.com" autocomplete="email" required></div><small class="field-error"></small></div>
              <?php if ($type === 'event-registration'): ?>
              <div class="pl-field"><label for="community">Community <span class="optional-label">Optional</span></label><div class="input-wrap"><i class="fa-solid fa-people-group"></i><select id="community" name="community"><option value="">Select community</option><option>Arya Vysya</option><option>Reddy</option><option>Kamma</option><option>Kapu</option><option>Banjara</option><option>Yadava</option><option>Padmashali</option><option>Goud</option><option>Other</option></select></div></div>
              <div class="pl-field"><label for="participants">Number of participants <em>*</em></label><div class="input-wrap"><i class="fa-solid fa-users"></i><select id="participants" name="participants" required><option value="1">1 participant</option><option value="2">2 participants</option><option value="3">3 participants</option><option value="4">4 participants</option><option value="5">5 participants</option><option value="6">6 participants</option></select></div><small class="field-error"></small></div>
              <?php endif; ?>
            </div>
            <?php if ($type !== 'event-registration'): ?>
            <div class="form-section-title section-spaced"><span class="section-number">02</span><div><h3>Enquiry details</h3><p>Share a little more about what you need.</p></div></div>
            <div class="pl-field"><label for="subject">Subject <em>*</em></label><div class="input-wrap"><i class="fa-regular fa-pen-to-square"></i><input id="subject" name="subject" type="text" placeholder="What is your enquiry about?" required></div><small class="field-error"></small></div>
            <div class="pl-field message-field"><label for="message"><?= $type === 'advertisement-enquiry' ? 'Requirement / message' : 'Message' ?> <em>*</em></label><textarea id="message" name="message" rows="4" placeholder="Write your message here..." required></textarea><div class="textarea-footer"><small class="field-error"></small><span id="messageCount">0 / 1000</span></div></div>
            <?php if ($type === 'advertisement-enquiry'): ?>
            <div class="pl-field contact-method-field"><label>Preferred contact method <em>*</em></label><div class="contact-methods"><label class="contact-choice"><input type="radio" name="contact_method" value="Call" checked><span><i class="fa-solid fa-phone"></i> Call</span></label><label class="contact-choice"><input type="radio" name="contact_method" value="WhatsApp"><span><i class="fa-brands fa-whatsapp"></i> WhatsApp</span></label><label class="contact-choice"><input type="radio" name="contact_method" value="Email"><span><i class="fa-regular fa-envelope"></i> Email</span></label></div></div>
            <?php endif; ?>
            <?php else: ?>
            <div class="form-section-title section-spaced"><span class="section-number">02</span><div><h3>Additional notes</h3><p>Anything the organiser should know? (Optional)</p></div></div><div class="pl-field message-field"><label for="message">Message / notes <span class="optional-label">Optional</span></label><textarea id="message" name="message" rows="3" maxlength="1000" placeholder="Any special requirements or notes..."></textarea><div class="textarea-footer"><small class="field-error"></small><span id="messageCount">0 / 1000</span></div></div>
            <?php endif; ?>
            <label class="pl-consent"><input type="checkbox" id="consent" name="consent" required><span>I confirm that the details provided are accurate and agree to be contacted about this <?= $type === 'advertisement-enquiry' ? 'advertisement enquiry' : 'event' ?>.</span></label><small class="consent-error"></small>
            <div class="pl-submit-row"><p><i class="fa-solid fa-lock"></i> Your information is handled responsibly.</p><button type="submit" class="pl-submit-btn"><span><?= $type === 'event-registration' ? 'Register Now' : 'Send Enquiry' ?></span><i class="fa-solid fa-arrow-right"></i></button></div>
          </form>
        </div>
      </div>
      <aside class="pl-side-column">
        <div class="side-help-card"><div class="help-icon"><i class="fa-regular fa-circle-question"></i></div><h3>Need a little help?</h3><p>Have a question about registration or need help with your enquiry? Our community team is here to help.</p><a href="contact.php"><i class="fa-solid fa-headset"></i> Contact support</a></div>
        <?php if ($type === 'advertisement-enquiry'): ?>
        <div class="side-direct-card"><span class="direct-kicker">DIRECT CONTACT</span><h3>Connect with the advertiser</h3><p>Choose a direct contact option if you prefer not to wait for a reply through PeopleLink.</p><a href="tel:<?= htmlspecialchars($ad['phone']) ?>" class="direct-action call-action"><i class="fa-solid fa-phone"></i><span>Call advertiser</span><i class="fa-solid fa-arrow-up-right-from-square"></i></a><a href="https://wa.me/<?= htmlspecialchars($ad['whatsapp']) ?>" target="_blank" rel="noopener" class="direct-action whatsapp-action"><i class="fa-brands fa-whatsapp"></i><span>WhatsApp</span><i class="fa-solid fa-arrow-up-right-from-square"></i></a><a href="mailto:<?= htmlspecialchars($ad['email']) ?>" class="direct-action email-action"><i class="fa-regular fa-envelope"></i><span>Send email</span><i class="fa-solid fa-arrow-up-right-from-square"></i></a><small>Direct contact details are demo data. Replace with verified advertiser details.</small></div>
        <?php else: ?>
        <div class="side-info-card"><div class="side-info-icon"><i class="fa-solid fa-clipboard-check"></i></div><h3>What happens next?</h3><ul><li><span><i class="fa-solid fa-check"></i></span><div><strong><?= $type === 'event-registration' ? 'Registration recorded' : 'Enquiry received' ?></strong><small>You'll see a confirmation when this demo form is submitted.</small></div></li><li><span><i class="fa-solid fa-envelope"></i></span><div><strong>Stay reachable</strong><small>Use an active mobile number and email address.</small></div></li><li><span><i class="fa-solid fa-calendar-check"></i></span><div><strong>Keep event details handy</strong><small>Check the event page for venue and timing updates.</small></div></li></ul></div>
        <?php endif; ?>
        <div class="side-safety-note"><i class="fa-solid fa-shield-heart"></i><p><strong>Community first</strong><br>Never share passwords, OTPs, or banking PINs in an enquiry message.</p></div>
      </aside>
    </div>
  </section>
</main>

<div class="pl-success-overlay" id="successOverlay" aria-hidden="true"><div class="pl-success-modal" role="dialog" aria-modal="true" aria-labelledby="successTitle"><button type="button" class="modal-close" id="closeSuccess" aria-label="Close confirmation"><i class="fa-solid fa-xmark"></i></button><div class="success-check"><i class="fa-solid fa-check"></i></div><span class="success-kicker">PEOPLELINK CONFIRMATION</span><h2 id="successTitle">Registration Successful</h2><p id="successDescription">Your submission has been received.</p><div class="success-reference" id="successReference"><span>Registration ID</span><strong id="registrationId">PL-R-000001</strong></div><div class="success-details" id="successDetails"></div><div class="success-actions" id="successActions"><a href="event-ad-details.php?id=101&type=event" class="success-secondary">Back to Event</a><a href="my-registrations.php" class="success-primary">View My Registrations <i class="fa-solid fa-arrow-right"></i></a></div><p class="demo-disclaimer"><i class="fa-solid fa-circle-info"></i> Demo confirmation only. Connect this form to your PHP backend to save submissions.</p></div></div>
<div class="pl-toast" id="plToast" role="status" aria-live="polite"><i class="fa-solid fa-circle-check"></i><span>Done</span></div>
 
<?php include 'footer.php'; ?>
