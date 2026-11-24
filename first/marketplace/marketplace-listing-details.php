<?php
// Marketplace Listing Details (live: marketplace_details; enquiry → marketplace_enquiry; report → marketplace_report)
require_once dirname(__DIR__) . '/_web.php';
$mdId = (int)($_GET['id'] ?? 0);
$mdRes = $mdId ? web_call('marketplace_details', ['id' => $mdId]) : ['error' => 'missing'];
if (!empty($mdRes['error'])) {
    flash($webUser ? 'This listing is not available. It may have been removed or belong to another community.' : 'Please login to view this listing.', 'error');
    header('Location: ' . ($webUser ? 'marketplace-search-results.php' : DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? ''))); exit;
}
$m = web_mp_card($mdRes['item']);
$mdImages = array_values(array_filter(array_map(fn($i) => is_array($i) ? ($i['url'] ?? null) : $i, (array)($m['images'] ?? []))));
if (!$mdImages && $m['image']) $mdImages = [$m['image']];
$mdDetails = is_array($m['details'] ?? null) ? array_filter($m['details'], fn($v) => is_scalar($v) && trim((string)$v) !== '') : [];
$mdRow = pl_entity_row(pl_entity('mp_listing'), $mdId);
$mdSeller = rows('SELECT name, created_at FROM users WHERE id=?', [(int)$mdRow['user_id']])[0] ?? ['name' => 'Community Member', 'created_at' => null];
$mdSellerName = $m['contact_name'] ?: $mdSeller['name'];
$mdIni = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice(preg_split('/\s+/', trim($mdSellerName)), 0, 2)))) ?: 'PL';
$mdOwn = !empty($m['is_own']);
$mdOpen = ($mdRow['status'] ?? '') === 'approved' && empty($m['expired']);
$mdWa = preg_replace('/\D+/', '', (string)($m['whatsapp'] ?: ''));
if ($mdWa && strlen($mdWa) === 10) $mdWa = '91' . $mdWa;
$mdTel = preg_replace('/[^\d+]/', '', (string)($m['phone'] ?? ''));
$mdSimilar = array_map('web_mp_card', array_values(array_filter(web_ent_list('mp_listing', ['category_id' => $m['category_id'], 'sort' => 'recent'], 4)['items'] ?? [], fn($s) => (int)$s['id'] !== $mdId)));
$mdSimilar = array_slice($mdSimilar, 0, 3);
$fmtKey = fn($k) => ucwords(str_replace(['_', '-'], ' ', (string)$k));
include 'header.php'; ?>


<main class="pl-md-page">
    <section class="pl-md-top"><div class="pl-md-container"><nav class="pl-md-breadcrumb"><a href="marketplace-home.php">Marketplace</a> <i class="fas fa-chevron-right"></i> <a href="marketplace-search-results.php">Listings</a> <i class="fas fa-chevron-right"></i> <span><?= h($m['title']) ?></span></nav></div></section>
    <?= web_flash_html() ?>
    <section class="pl-md-main-section">
        <div class="pl-md-container">
            <div class="pl-md-layout">
                <div class="pl-md-primary">
                    <div class="pl-md-gallery">
                        <div class="pl-md-main-image">
                            <img src="<?= h($mdImages[0] ?? 'images/marketplace-placeholder.jpg') ?>" id="plMdMainImage" alt="<?= h($m['title']) ?>">
                            <span class="pl-md-image-status"><i class="fas fa-check-circle"></i> <?= $mdOpen ? 'Available' : 'Not available' ?></span>
                            <?php if (count($mdImages) > 1): ?><span class="pl-md-image-count" id="plMdImageCount">1 / <?= count($mdImages) ?></span><?php endif; ?>
                        </div>
                        <?php if (count($mdImages) > 1): ?>
                        <div class="pl-md-thumbnails">
                            <?php foreach ($mdImages as $i => $img): ?><button type="button" class="pl-md-thumbnail<?= $i ? '' : ' active' ?>" data-image="<?= h($img) ?>"><img src="<?= h($img) ?>" alt="Photo <?= $i + 1 ?>"></button><?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <section class="pl-md-card pl-md-overview">
                        <div class="pl-md-category-line"><span class="pl-md-category-badge"><i class="fas fa-tag"></i> <?= h($m['category_name']) ?></span><span class="pl-md-listing-id">Listing #PL<?= str_pad((string)$mdId, 3, '0', STR_PAD_LEFT) ?></span></div>
                        <div class="pl-md-listing-heading"><h1><?= h($m['title']) ?></h1><div class="pl-md-meta-line"><span><i class="fas fa-map-marker-alt"></i> <?= h($m['location_text']) ?></span><span><i class="far fa-calendar-alt"></i> Posted <?= h(date('d F Y', strtotime($m['created_at']))) ?></span></div></div>
                        <div class="pl-md-price-row">
                            <div><span class="pl-md-price-label"><?= ($m['listing_type'] ?? '') === 'Rent' ? 'Rent' : 'Asking Price' ?></span><div class="pl-md-price"><?= h($m['price_text']) ?></div><?php if (!empty($m['price_negotiable'])): ?><span class="pl-md-price-type"><i class="fas fa-handshake"></i> Price negotiable</span><?php endif; ?></div>
                            <span class="pl-md-availability"><span></span> <?= $mdOpen ? 'Available' : 'Not available' ?></span>
                        </div>
                        <div class="pl-md-actions">
                            <?php if (!$mdOwn): ?><button type="button" class="pl-md-btn pl-md-save" data-live="1" data-save-id="<?= $mdId ?>" data-saved="<?= !empty($m['saved']) ? '1' : '0' ?>" aria-pressed="<?= !empty($m['saved']) ? 'true' : 'false' ?>"><i class="<?= !empty($m['saved']) ? 'fas' : 'far' ?> fa-heart"></i> <span>Save Listing</span></button>
                            <a href="#plMdContact" class="pl-md-btn pl-md-contact-primary"><i class="fas fa-comment-alt"></i> Contact Seller</a>
                            <?php else: ?><a href="post-marketplace-listing.php?edit=<?= $mdId ?>" class="pl-md-btn pl-md-contact-primary"><i class="fas fa-pen"></i> Edit Listing</a><a href="my-marketplace-listings.php" class="pl-md-btn pl-md-save"><i class="fas fa-list"></i> My Listings</a><?php endif; ?>
                            <button type="button" class="pl-md-btn pl-md-share" id="plMdShare"><i class="fas fa-share-alt"></i> Share</button>
                        </div>
                    </section>

                    <section class="pl-md-card pl-md-section-card">
                        <div class="pl-md-section-heading"><span class="pl-md-heading-icon"><i class="fas fa-align-left"></i></span><div><h2>About This Listing</h2><p>Complete information provided by the seller.</p></div></div>
                        <div class="pl-md-description"><?php foreach (preg_split('/\n\s*\n/', trim((string)$m['description'])) as $para): if (trim($para) === '') continue; ?><p><?= nl2br(h(trim($para))) ?></p><?php endforeach; ?><?php if (trim((string)$m['description']) === ''): ?><p>No description provided.</p><?php endif; ?></div>
                        <div class="pl-md-detail-grid">
                            <div class="pl-md-detail-item"><span>Category</span><strong><?= h($m['category_name']) ?></strong></div>
                            <?php if (!empty($m['subcategory_name'])): ?><div class="pl-md-detail-item"><span>Subcategory</span><strong><?= h($m['subcategory_name']) ?></strong></div><?php endif; ?>
                            <?php if (!empty($m['listing_type'])): ?><div class="pl-md-detail-item"><span>Listing Type</span><strong><?= h($m['listing_type']) ?></strong></div><?php endif; ?>
                            <?php if (!empty($m['item_condition'])): ?><div class="pl-md-detail-item"><span>Condition</span><strong><?= h($m['item_condition']) ?></strong></div><?php endif; ?>
                            <div class="pl-md-detail-item"><span>Price Type</span><strong><?= !empty($m['price_negotiable']) ? 'Negotiable' : 'Fixed' ?></strong></div>
                            <div class="pl-md-detail-item"><span>Availability</span><strong class="pl-md-green-text"><?= $mdOpen ? 'Available' : 'Not available' ?></strong></div>
                        </div>
                    </section>

                    <?php if ($mdDetails): ?>
                    <section class="pl-md-card pl-md-section-card">
                        <div class="pl-md-section-heading"><span class="pl-md-heading-icon"><i class="fas fa-list-ul"></i></span><div><h2>Specifications</h2><p>Additional details from the seller.</p></div></div>
                        <div class="pl-md-spec-list"><?php foreach ($mdDetails as $k => $v): ?><div><span><?= h($fmtKey($k)) ?></span><strong><?= h($v) ?></strong></div><?php endforeach; ?></div>
                    </section>
                    <?php endif; ?>

                    <section class="pl-md-card pl-md-section-card">
                        <div class="pl-md-section-heading"><span class="pl-md-heading-icon"><i class="fas fa-map-marked-alt"></i></span><div><h2>Listing Location</h2><p>Find the item's general location.</p></div></div>
                        <div class="pl-md-location-box"><div class="pl-md-location-icon"><i class="fas fa-map-marker-alt"></i></div><div class="pl-md-location-info"><strong><?= h($m['location_text']) ?></strong><?php if (!empty($m['location'])): ?><span>Area: <?= h($m['location']) ?></span><?php endif; ?><?php if (!empty($m['city'])): ?><span>City: <?= h($m['city']) ?></span><?php endif; ?></div>
                            <a href="https://www.google.com/maps/search/?api=1&query=<?= rawurlencode($m['location_text']) ?>" target="_blank" rel="noopener noreferrer" class="pl-md-map-btn"><i class="fas fa-external-link-alt"></i> View on Map</a></div>
                        <p class="pl-md-privacy-note"><i class="fas fa-shield-alt"></i> The seller's exact address is not displayed publicly.</p>
                    </section>

                    <?php if ($mdSimilar): ?>
                    <section class="pl-md-similar-section">
                        <div class="pl-md-similar-heading"><div><span class="pl-md-eyebrow">YOU MAY ALSO LIKE</span><h2>Similar Listings</h2><p>More items in <?= h($m['category_name']) ?>.</p></div><a href="marketplace-search-results.php?category=<?= rawurlencode($m['category_name']) ?>" class="pl-md-view-all">View Similar Listings <i class="fas fa-arrow-right"></i></a></div>
                        <div class="pl-md-similar-grid">
                            <?php foreach ($mdSimilar as $s): ?>
                            <article class="pl-md-similar-card"><a href="marketplace-listing-details.php?id=<?= (int)$s['id'] ?>" class="pl-md-similar-image"><img src="<?= h($s['image'] ?: 'images/marketplace-placeholder.jpg') ?>" alt="<?= h($s['title']) ?>" loading="lazy"></a><div class="pl-md-similar-body"><span><?= h($s['category_text']) ?></span><h3><a href="marketplace-listing-details.php?id=<?= (int)$s['id'] ?>"><?= h($s['title']) ?></a></h3><strong><?= h($s['price_text']) ?></strong><small><i class="fas fa-map-marker-alt"></i> <?= h($s['location_text']) ?></small></div></article>
                            <?php endforeach; ?>
                        </div>
                    </section>
                    <?php endif; ?>
                </div>

                <aside class="pl-md-sidebar">
                    <section class="pl-md-card pl-md-seller-card">
                        <div class="pl-md-sidebar-heading"><h2>Seller Information</h2><i class="fas fa-user-check"></i></div>
                        <div class="pl-md-seller-profile"><div class="pl-md-seller-avatar"><?= h($mdIni) ?></div><div><h3><?= h($mdSellerName) ?></h3><span class="pl-md-member-badge"><i class="fas fa-check-circle"></i> <?= ($m['visibility_type'] ?? '') === 'global' ? 'PeopleLink Member' : 'Community Member' ?></span></div></div>
                        <div class="pl-md-seller-details">
                            <div><i class="fas fa-map-marker-alt"></i> <span><?= h($m['city'] ?: $m['location_text']) ?></span></div>
                            <div><i class="fas fa-users"></i> <span>Community: <?= h($m['community_name'] ?? 'All communities') ?></span></div>
                            <?php if ($mdSeller['created_at']): ?><div><i class="far fa-calendar-alt"></i> <span>Member since: <?= h(date('M Y', strtotime($mdSeller['created_at']))) ?></span></div><?php endif; ?>
                        </div>
                        <?php if (!$mdOwn): ?><a href="#plMdContact" class="pl-md-sidebar-contact">Contact Seller <i class="fas fa-arrow-right"></i></a><?php endif; ?>
                        <p class="pl-md-privacy-note"><i class="fas fa-lock"></i> Contact information is shared according to member privacy settings.</p>
                    </section>

                    <?php if (!$mdOwn): ?>
                    <section class="pl-md-card pl-md-contact-card" id="plMdContact">
                        <div class="pl-md-sidebar-heading"><h2>Contact Seller</h2><i class="fas fa-comments"></i></div>
                        <p>Interested in this listing? Contact the seller for more information.</p>
                        <?php if ($mdTel): ?><a href="tel:<?= h($mdTel) ?>" class="pl-md-contact-option pl-md-call"><span><i class="fas fa-phone-alt"></i></span><div><strong>Call Seller</strong><small><?= h($mdTel) ?></small></div><i class="fas fa-chevron-right"></i></a><?php endif; ?>
                        <?php if ($mdWa): ?><a href="https://wa.me/<?= h($mdWa) ?>?text=<?= rawurlencode('Hello, I am interested in your listing "' . $m['title'] . '" on PeopleLink.') ?>" target="_blank" rel="noopener noreferrer" class="pl-md-contact-option pl-md-whatsapp"><span><i class="fab fa-whatsapp"></i></span><div><strong>WhatsApp</strong><small>Chat with the seller</small></div><i class="fas fa-chevron-right"></i></a><?php endif; ?>
                        <button type="button" class="pl-md-contact-option pl-md-enquiry" id="plMdOpenEnquiry"><span><i class="fas fa-envelope"></i></span><div><strong>Send Enquiry</strong><small>The seller is notified in PeopleLink</small></div><i class="fas fa-chevron-right"></i></button>
                        <?php if (!$webUser): ?><p class="pl-md-privacy-note"><i class="fas fa-lock"></i> <a href="<?= h(DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '')) ?>">Login</a> to see the seller's phone number.</p><?php endif; ?>
                        <div class="pl-md-safety-tip"><i class="fas fa-shield-alt"></i><div><strong>Stay safe</strong><p>Verify the item before payment and avoid sharing sensitive information.</p></div></div>
                    </section>
                    <?php endif; ?>

                    <section class="pl-md-card pl-md-sidebar-info">
                        <h2>Listing Information</h2>
                        <div><span>Listing ID</span><strong>PL<?= str_pad((string)$mdId, 3, '0', STR_PAD_LEFT) ?></strong></div>
                        <div><span>Posted Date</span><strong><?= h(date('d F Y', strtotime($m['created_at']))) ?></strong></div>
                        <div><span>Last Updated</span><strong><?= h(date('d F Y', strtotime($m['updated_at']))) ?></strong></div>
                        <div><span>Status</span><strong class="pl-md-green-text"><?= $mdOpen ? 'Available' : h(ucfirst((string)$mdRow['status'])) ?></strong></div>
                        <?php if (!$mdOwn): ?><button type="button" id="plMdReport" class="pl-md-report-btn"><i class="fas fa-flag"></i> Report this listing</button><?php endif; ?>
                    </section>
                </aside>
            </div>
        </div>
    </section>

    <div class="pl-md-modal" id="plMdEnquiryModal" aria-hidden="true">
        <div class="pl-md-modal-backdrop" data-close-modal></div>
        <div class="pl-md-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="plMdModalTitle">
            <button type="button" class="pl-md-modal-close" data-close-modal aria-label="Close enquiry form"><i class="fas fa-times"></i></button>
            <div class="pl-md-modal-icon"><i class="fas fa-envelope-open-text"></i></div>
            <h2 id="plMdModalTitle">Send an Enquiry</h2>
            <p class="pl-md-modal-subtitle">Ask <?= h(explode(' ', $mdSellerName)[0]) ?> about “<?= h($m['title']) ?>”.</p>
            <form id="plMdEnquiryLive" data-id="<?= $mdId ?>">
                <div class="pl-md-form-group"><label for="plMdName">Your Name</label><input type="text" id="plMdName" name="name" value="<?= h($webUser['name'] ?? '') ?>" required></div>
                <div class="pl-md-form-group"><label for="plMdEmail">Email Address</label><input type="email" id="plMdEmail" name="email" value="<?= h($webUser['email'] ?? '') ?>" required></div>
                <div class="pl-md-form-group"><label for="plMdPhone">Phone Number (Optional)</label><input type="tel" id="plMdPhone" name="phone" value="<?= h($webUser['phone'] ?? '') ?>"></div>
                <div class="pl-md-form-group"><label for="plMdMessage">Your Message</label><textarea id="plMdMessage" name="message" rows="4" required>I am interested in this listing. Please share more details.</textarea></div>
                <button type="submit" class="pl-md-submit-enquiry">Send Enquiry <i class="fas fa-paper-plane"></i></button>
                <p class="pl-md-form-note">The seller receives your enquiry in PeopleLink and can reply to you.</p>
            </form>
        </div>
    </div>

    <div class="pl-md-modal" id="plMdReportModal" aria-hidden="true">
        <div class="pl-md-modal-backdrop" data-close-modal></div>
        <div class="pl-md-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="plMdReportTitle">
            <button type="button" class="pl-md-modal-close" data-close-modal aria-label="Close report form"><i class="fas fa-times"></i></button>
            <div class="pl-md-modal-icon pl-md-report-icon"><i class="fas fa-flag"></i></div>
            <h2 id="plMdReportTitle">Report this Listing</h2>
            <p class="pl-md-modal-subtitle">Tell us why this listing needs review.</p>
            <form id="plMdReportLive" data-id="<?= $mdId ?>">
                <div class="pl-md-form-group"><label for="plMdReportReason">Reason for Report</label><select id="plMdReportReason" name="reason" required><option value="">Select a reason</option><option>Misleading information</option><option>Spam or duplicate listing</option><option>Suspected fraud</option><option>Prohibited item</option><option>Other</option></select></div>
                <div class="pl-md-form-group"><label for="plMdReportMessage">Additional Details</label><textarea id="plMdReportMessage" name="details" rows="3" placeholder="Additional details (optional)"></textarea></div>
                <button type="submit" class="pl-md-submit-enquiry">Submit Report <i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
    <div class="pl-md-toast" id="plMdToast" role="status" aria-live="polite"></div>
</main>
<script>
// Enquiry and report go to the marketplace backend (same as the mobile app)
document.addEventListener('DOMContentLoaded', function () {
  function wire(formId, action, modalId, okMsg) {
    var f = document.getElementById(formId); if (!f) return;
    f.addEventListener('submit', async function (e) {
      e.preventDefault();
      if (!window.PL || !PL.requireLogin()) return;
      var btn = f.querySelector('button[type="submit"]'); btn.disabled = true;
      var data = { id: f.dataset.id }; new FormData(f).forEach(function (v, k) { data[k] = v; });
      try {
        var r = await PL.post(action, data);
        if (!r.ok) { PL.toast(r.error || 'Something went wrong.', true); return; }
        var m = document.getElementById(modalId); if (m) { m.classList.remove('is-open', 'open', 'active'); m.setAttribute('aria-hidden', 'true'); }
        document.body.style.overflow = '';
        PL.toast(r.message || okMsg); f.reset();
      } catch (err) {} finally { btn.disabled = false; }
    });
  }
  wire('plMdEnquiryLive', 'marketplace_enquiry', 'plMdEnquiryModal', 'Your enquiry has been sent.');
  wire('plMdReportLive', 'marketplace_report', 'plMdReportModal', 'Report submitted.');
});
</script>

 

<?php include 'footer.php'; ?>
 
