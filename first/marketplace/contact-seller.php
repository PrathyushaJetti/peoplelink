<?php
// Contact Seller (live: listing from marketplace_details, enquiry saved with marketplace_enquiry → seller notified)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();
$csId = (int)($_GET['id'] ?? $_POST['listing_id'] ?? 0);
$csRes = $csId ? web_call('marketplace_details', ['id' => $csId]) : ['error' => 'missing'];
if (!empty($csRes['error'])) { flash('That listing is not available.', 'error'); header('Location: marketplace-search-results.php'); exit; }
$cs = web_mp_card($csRes['item']);
if (!empty($cs['is_own'])) { flash('This is your own listing.', 'error'); header('Location: my-marketplace-listings.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = ['csrf' => $_POST['csrf'] ?? '', 'id' => $csId, 'name' => $_POST['buyer_name'] ?? '', 'phone' => $_POST['buyer_mobile'] ?? '', 'email' => $_POST['buyer_email'] ?? '',
        'message' => trim('Subject: ' . trim((string)($_POST['subject'] ?? '')) . "\n\n" . trim((string)($_POST['message'] ?? '')) . "\n\nPreferred contact: " . ($_POST['preferred_contact'] ?? 'Call'))];
    web_post('marketplace_enquiry', 'contact-seller.php?id=' . $csId, 'marketplace-listing-details.php?id=' . $csId);
}
$csRow = pl_entity_row(pl_entity('mp_listing'), $csId);
$csSeller = $cs['contact_name'] ?: (rows('SELECT name FROM users WHERE id=?', [(int)$csRow['user_id']])[0]['name'] ?? 'Seller');
$csTel = preg_replace('/[^\d+]/', '', (string)($cs['phone'] ?? ''));
$csWa = preg_replace('/\D+/', '', (string)($cs['whatsapp'] ?? '')); if (strlen($csWa) === 10) $csWa = '91' . $csWa;
$csMail = (string)($cs['email'] ?? '');
include 'header.php'; ?>

 

<main class="pl-contact-page">
    <!-- Premium marketplace banner -->
    <section class="pl-contact-hero">
        <div class="pl-hero-orb pl-hero-orb-one"></div>
        <div class="pl-hero-orb pl-hero-orb-two"></div>
        <div class="pl-contact-container pl-hero-inner">
            <div class="pl-hero-copy">
                <span class="pl-hero-kicker"><span class="pl-kicker-dot"></span> PEOPLELINK MARKETPLACE</span>
                <h1>Good connections<br><span>start with a conversation.</span></h1>
                <p>Interested in a listing? Send the seller your question or requirement. Simple, direct, and connected through PeopleLink.</p>
                <div class="pl-hero-points">
                    <span><i aria-hidden="true">✓</i> Connect with sellers</span>
                    <span><i aria-hidden="true">✓</i> Share your requirements</span>
                    <span><i aria-hidden="true">✓</i> Choose how to be contacted</span>
                </div>
            </div>
            <div class="pl-hero-art" aria-hidden="true">
                <div class="pl-art-ring pl-ring-one"></div>
                <div class="pl-art-ring pl-ring-two"></div>
                <div class="pl-art-globe">◎</div>
                <div class="pl-art-person pl-person-blue"><span></span></div>
                <div class="pl-art-person pl-person-orange"><span></span></div>
                <div class="pl-art-person pl-person-green"><span></span></div>
                <div class="pl-art-person pl-person-purple"><span></span></div>
                <div class="pl-art-message"><span>•••</span><small>Let’s connect</small></div>
            </div>
        </div>
        <div class="pl-hero-bottom-line"></div>
    </section>

    <div class="pl-contact-container pl-main-content">
        <nav class="pl-breadcrumb" aria-label="Breadcrumb">
            <a href="index.php">Home</a><span>/</span><a href="marketplace-home.php">Marketplace</a><span>/</span><strong>Contact Seller</strong>
        </nav>

        <div class="pl-section-intro">
            <div>
                <span class="pl-section-eyebrow">SELLER ENQUIRY</span>
                <h2>Let’s talk about this listing</h2>
                <p>Review the listing details and send a message to the seller.</p>
            </div>
            <div class="pl-secure-note"><span aria-hidden="true">✓</span><div><strong>PeopleLink connection</strong><small>Your enquiry stays focused on this listing.</small></div></div>
        </div>

        <div class="pl-contact-layout">
            <!-- Listing summary -->
            <aside class="pl-listing-column">
                <section class="pl-card pl-listing-card">
                    <div class="pl-card-topline"><span class="pl-card-label">LISTING SUMMARY</span><span class="pl-listing-status"><i></i> Marketplace</span></div>
                    <div class="pl-listing-photo-wrap">
                        <!-- Replace the placeholder image and details with listing data from your existing backend. -->
                        <img class="pl-listing-image" src="<?= h($cs['image'] ?: 'images/no-photo.svg') ?>" alt="<?= h($cs['title']) ?>">
                        <span class="pl-photo-badge">PeopleLink Listing</span>
                    </div>
                    <div class="pl-listing-details">
                        <span class="pl-category-chip"><?= h($cs['category_text']) ?></span>
                        <h3 class="pl-listing-title"><a href="marketplace-listing-details.php?id=<?= $csId ?>"><?= h($cs['title']) ?></a></h3>
                        <p class="pl-listing-price"><?= h($cs['price_text']) ?></p>
                        <div class="pl-listing-info">
                            <div class="pl-info-item"><span class="pl-info-icon" aria-hidden="true">⌖</span><div><small>Location</small><strong><?= h($cs['location_text']) ?></strong></div></div>
                            <div class="pl-info-item"><span class="pl-info-icon" aria-hidden="true">♙</span><div><small>Seller</small><strong><?= h($csSeller) ?></strong></div></div>
                        </div>
                    </div>
                    <div class="pl-seller-profile">
                        <div class="pl-seller-avatar"><?= h(mb_strtoupper(mb_substr($csSeller, 0, 1))) ?></div>
                        <div class="pl-seller-profile-copy"><small>YOU’RE CONTACTING</small><strong><?= h($csSeller) ?></strong><span>Marketplace seller</span></div>
                        <span class="pl-seller-arrow" aria-hidden="true">↗</span>
                    </div>
                </section>

                <div class="pl-help-card">
                    <div class="pl-help-icon" aria-hidden="true">✦</div>
                    <div><h3>Make your enquiry useful</h3><p>Ask a clear question, mention what you need, and include a convenient way for the seller to reach you.</p></div>
                </div>
            </aside>

            <!-- Enquiry form -->
            <section class="pl-card pl-enquiry-card">
                <div class="pl-form-card-heading">
                    <div class="pl-form-heading-icon" aria-hidden="true">✉</div>
                    <div><span class="pl-card-label">CONTACT THE SELLER</span><h2>Send an enquiry</h2><p>Fields marked with <b>*</b> are required.</p></div>
                </div>

                <?= web_flash_html() ?>
<form class="pl-form-body" action="contact-seller.php?id=<?= $csId ?>" method="POST"><?= web_csrf_field() ?>
                    <input type="hidden" name="listing_id" value="<?= $csId ?>">

                    <div class="pl-form-section-heading"><span>01</span><div><h3>Your contact details</h3><p>How the seller can get back to you.</p></div></div>
                    <div class="pl-form-grid">
                        <div class="pl-form-group">
                            <label for="pl-buyer-name">Full name <b>*</b></label>
                            <input id="pl-buyer-name" type="text" name="buyer_name" value="<?= h($webUser['name'] ?? '') ?>" placeholder="Enter your full name" autocomplete="name" required>
                        </div>
                        <div class="pl-form-group">
                            <label for="pl-buyer-mobile">Mobile number <b>*</b></label>
                            <input id="pl-buyer-mobile" type="tel" name="buyer_mobile" value="<?= h($webUser['phone'] ?? '') ?>" placeholder="Enter mobile number" autocomplete="tel" required>
                        </div>
                        <div class="pl-form-group pl-full-width">
                            <label for="pl-buyer-email">Email address <b>*</b></label>
                            <input id="pl-buyer-email" type="email" name="buyer_email" value="<?= h($webUser['email'] ?? '') ?>" placeholder="you@example.com" autocomplete="email" required>
                        </div>
                    </div>

                    <div class="pl-form-divider"></div>

                    <div class="pl-form-section-heading"><span>02</span><div><h3>Your enquiry</h3><p>Give the seller a little context.</p></div></div>
                    <div class="pl-form-group">
                        <label for="pl-subject">Subject <b>*</b></label>
                        <input id="pl-subject" type="text" name="subject" value="Interested in: <?= h($cs['title']) ?>" placeholder="e.g. Interested in this listing" required>
                    </div>
                    <div class="pl-form-group">
                        <label for="pl-message">Message or requirement <b>*</b></label>
                        <textarea id="pl-message" name="message" rows="5" placeholder="Hi, I’m interested in this listing. Could you please share more details?" required></textarea>
                        <small class="pl-field-hint">A clear message helps the seller understand what you need.</small>
                    </div>

                    <div class="pl-form-group">
                        <label>Preferred contact method</label>
                        <div class="pl-contact-methods">
                            <label class="pl-method-option"><input type="radio" name="preferred_contact" value="Call" checked><span class="pl-method-symbol" aria-hidden="true">☎</span><span>Call</span></label>
                            <label class="pl-method-option"><input type="radio" name="preferred_contact" value="WhatsApp"><span class="pl-method-symbol" aria-hidden="true">◉</span><span>WhatsApp</span></label>
                            <label class="pl-method-option"><input type="radio" name="preferred_contact" value="Email"><span class="pl-method-symbol" aria-hidden="true">✉</span><span>Email</span></label>
                        </div>
                    </div>

                    <div class="pl-privacy-note"><span aria-hidden="true">⌑</span><p>Your details are provided so the seller can respond to this enquiry. Do not include passwords or sensitive financial information.</p></div>
                    <button type="submit" class="pl-btn pl-btn-submit"><span>Send enquiry</span><span class="pl-submit-arrow" aria-hidden="true">→</span></button>
                    <p class="pl-submit-caption">By submitting, you’re asking the seller to contact you about this listing.</p>
                </form>

                <!-- Replace these sample contact details and show this block only if seller settings allow direct contact. -->
                <?php if ($csTel || $csWa || $csMail): ?><div class="pl-direct-contact">
                    <div class="pl-direct-heading"><strong>Prefer to contact directly?</strong><span>When available</span></div>
                    <div class="pl-direct-actions">
                        <?php if ($csTel): ?><a class="pl-direct-btn pl-direct-call" href="tel:<?= h($csTel) ?>"><span aria-hidden="true">☎</span> Call seller</a><?php endif; ?>
                        <?php if ($csWa): ?><a class="pl-direct-btn pl-direct-whatsapp" target="_blank" rel="noopener" href="https://wa.me/<?= h($csWa) ?>"><span aria-hidden="true">◉</span> WhatsApp</a><?php endif; ?>
                        <?php if ($csMail): ?><a class="pl-direct-btn pl-direct-email" href="mailto:<?= h($csMail) ?>"><span aria-hidden="true">✉</span> Email</a><?php endif; ?>
                    </div>
                    <p class="pl-direct-disclaimer">Shown because the seller shared these contact details.</p>
                </div><?php endif; ?>
            </section>
        </div>
    </div>
</main>

 

<?php include 'footer.php'; ?>
