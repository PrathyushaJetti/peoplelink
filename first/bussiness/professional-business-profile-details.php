<?php
// Directory Profile Details (live: directory_details; save → directory_save; report → directory_report; enquiry → enquiry-contact.php)
require_once dirname(__DIR__) . '/_web.php';
$ddId = (int)($_GET['id'] ?? 0);
$ddRes = $ddId ? web_call('directory_details', ['id' => $ddId]) : ['error' => 'missing'];
if (!empty($ddRes['error'])) {
    flash($webUser ? 'This profile is not available. It may have been removed or belong to another community.' : 'Please login to view directory profiles.', 'error');
    header('Location: ' . ($webUser ? 'professional-and-business-directory-search-results.php' : DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? ''))); exit;
}
$d = web_dir_card($ddRes['item']);
$dx = is_array($d['details'] ?? null) ? array_filter($d['details'], fn($v) => is_scalar($v) && trim((string)$v) !== '') : [];
$ddImages = array_values(array_filter(array_map(fn($i) => is_array($i) ? ($i['url'] ?? null) : $i, (array)($d['images'] ?? []))));
$ddOwn = !empty($d['is_own']);
$ddWa = preg_replace('/\D+/', '', (string)($d['whatsapp'] ?? '')); if (strlen($ddWa) === 10) $ddWa = '91' . $ddWa;
$ddTel = preg_replace('/[^\d+]/', '', (string)($d['phone'] ?? ''));
$ddSimilar = array_slice(array_values(array_filter(array_map('web_dir_card', web_ent_list('directory', ['category_id' => $d['category_id'], 'sort' => 'recent'], 4)['items'] ?? []), fn($s) => (int)$s['id'] !== $ddId)), 0, 3);
$label = fn($k) => ucwords(str_replace(['_', '-'], ' ', (string)$k));
$ddSkip = ['contact_privacy', 'map_link', 'service_mode', 'listing_type', 'listing_name'];
include 'header.php'; ?>
<main class="pl-profile-page">
    <section class="pl-profile-hero">
        <div class="pl-profile-container">
            <nav class="pl-profile-breadcrumb" aria-label="Breadcrumb"><a href="../professional-and-business-directory.php">Directory</a> <i class="bi bi-chevron-right" aria-hidden="true"></i> <a href="professional-and-business-directory-search-results.php">Listings</a> <i class="bi bi-chevron-right" aria-hidden="true"></i> <span><?= h($d['title']) ?></span></nav>
            <?= web_flash_html() ?>
            <div class="pl-profile-header-card">
                <div class="pl-profile-avatar-wrap">
                    <div class="pl-profile-avatar"><?php if ($d['image']): ?><img src="<?= h($d['image']) ?>" alt="<?= h($d['title']) ?>" style="width:100%;height:100%;object-fit:cover;border-radius:inherit"><?php else: ?><span><?= h($d['initials']) ?></span><?php endif; ?></div>
                    <span class="pl-profile-verified"><i class="bi bi-patch-check-fill" aria-hidden="true"></i> Approved Profile</span>
                </div>
                <div class="pl-profile-header-info">
                    <div class="pl-profile-label-row"><span class="pl-profile-type"><i class="bi <?= $d['is_business'] ? 'bi-building' : 'bi-person-badge' ?>" aria-hidden="true"></i> <?= $d['is_business'] ? 'BUSINESS' : 'PROFESSIONAL' ?></span><span class="pl-profile-category"><?= h($d['category_text']) ?></span></div>
                    <h1><?= h($d['title']) ?></h1>
                    <?php if ($d['subtitle']): ?><p class="pl-profile-specialization"><?= $d['is_business'] ? 'Owner / contact: ' : '' ?><?= h($d['subtitle']) ?></p><?php endif; ?>
                    <div class="pl-profile-header-meta">
                        <span><i class="bi bi-geo-alt" aria-hidden="true"></i> <?= h($d['location_text']) ?></span>
                        <?php if (!empty($d['experience_years'])): ?><span><i class="bi bi-award" aria-hidden="true"></i> <?= (int)$d['experience_years'] ?> years <?= $d['is_business'] ? 'in business' : 'of experience' ?></span><?php endif; ?>
                        <?php if (!empty($d['community_name'])): ?><span><i class="bi bi-people" aria-hidden="true"></i> <?= h($d['community_name']) ?> Community</span><?php endif; ?>
                    </div>
                    <?php if ($d['description']): ?><p class="pl-profile-intro"><?= h(mb_strimwidth((string)$d['description'], 0, 220, '…')) ?></p><?php endif; ?>
                    <div class="pl-profile-header-actions">
                        <?php if ($ddOwn): ?>
                        <a class="pl-button pl-button-primary" href="submit-professional-business-listing.php?edit=<?= $ddId ?>"><i class="bi bi-pencil" aria-hidden="true"></i> Edit Profile</a>
                        <a class="pl-button pl-button-outline" href="my-directory-listings.php"><i class="bi bi-list" aria-hidden="true"></i> My Directory Profiles</a>
                        <?php else: ?>
                        <button class="pl-button pl-button-primary pl-directory-save" type="button" data-live="1" data-save-id="<?= $ddId ?>" data-saved="<?= !empty($d['saved']) ? '1' : '0' ?>"><i class="bi bi-bookmark" aria-hidden="true"></i><span>Save Profile</span></button>
                        <a class="pl-button pl-button-orange" href="enquiry-contact.php?id=<?= $ddId ?>"><i class="bi bi-chat-dots" aria-hidden="true"></i> Contact / Enquire</a>
                        <?php endif; ?>
                        <button class="pl-button pl-button-outline" type="button" onclick="(navigator.share ? navigator.share({title: document.title, url: location.href}) : navigator.clipboard.writeText(location.href).then(function(){ window.PL && PL.toast('Link copied.'); })).catch(function(){})"><i class="bi bi-share" aria-hidden="true"></i> Share Profile</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pl-profile-content">
        <div class="pl-profile-container pl-profile-layout">
            <div class="pl-profile-main-column">
                <section class="pl-profile-section" id="plAbout">
                    <div class="pl-section-heading"><span class="pl-section-icon"><i class="bi bi-person-lines-fill" aria-hidden="true"></i></span><div><h2>About</h2><p>Get to know this <?= $d['is_business'] ? 'business' : 'professional' ?></p></div></div>
                    <p class="pl-profile-body-copy"><?= nl2br(h($d['description'] ?: 'No description provided yet.')) ?></p>
                </section>

                <?php if ($d['services_list']): ?>
                <section class="pl-profile-section" id="plServices">
                    <div class="pl-section-heading"><span class="pl-section-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span><div><h2>Services Offered</h2><p>Ways <?= $d['is_business'] ? 'this business' : 'this professional' ?> can help</p></div></div>
                    <div class="pl-profile-services-grid"><?php foreach ($d['services_list'] as $sv): ?><article class="pl-service-item"><span><i class="bi bi-check2-square" aria-hidden="true"></i></span><div><h3><?= h($sv) ?></h3></div><i class="bi bi-check-circle-fill pl-service-check" aria-hidden="true"></i></article><?php endforeach; ?></div>
                </section>
                <?php endif; ?>

                <?php if ($ddImages): ?>
                <section class="pl-profile-section">
                    <div class="pl-section-heading"><span class="pl-section-icon"><i class="bi bi-images" aria-hidden="true"></i></span><div><h2>Photos</h2><p>Work, premises and services</p></div></div>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:12px"><?php foreach ($ddImages as $img): ?><a href="<?= h($img) ?>" target="_blank" rel="noopener"><img src="<?= h($img) ?>" alt="" loading="lazy" style="width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:12px"></a><?php endforeach; ?></div>
                </section>
                <?php endif; ?>

                <section class="pl-profile-section" id="plDetails">
                    <div class="pl-section-heading"><span class="pl-section-icon"><i class="bi bi-card-checklist" aria-hidden="true"></i></span><div><h2><?= $d['is_business'] ? 'Business' : 'Professional' ?> Details</h2><p>Profile information</p></div></div>
                    <div class="pl-profile-details-table">
                        <div><span><?= $d['is_business'] ? 'Business Name' : 'Full Name' ?></span><strong><?= h($d['title']) ?></strong></div>
                        <?php if ($d['subtitle']): ?><div><span><?= $d['is_business'] ? 'Contact Person' : 'Organisation / Business' ?></span><strong><?= h($d['subtitle']) ?></strong></div><?php endif; ?>
                        <div><span>Category</span><strong><?= h($d['category_name']) ?></strong></div>
                        <?php if (!empty($d['subcategory_name'])): ?><div><span>Subcategory</span><strong><?= h($d['subcategory_name']) ?></strong></div><?php endif; ?>
                        <?php if (!empty($d['qualification'])): ?><div><span>Qualification</span><strong><?= h($d['qualification']) ?></strong></div><?php endif; ?>
                        <?php if (!empty($d['experience_years'])): ?><div><span>Experience</span><strong><?= (int)$d['experience_years'] ?> years</strong></div><?php endif; ?>
                        <?php foreach ($dx as $k => $v): if (in_array($k, $ddSkip, true)) continue; ?><div><span><?= h($label($k)) ?></span><strong><?= h($v) ?></strong></div><?php endforeach; ?>
                        <?php if (!empty($d['website'])): ?><div><span>Website</span><strong><a href="<?= h($d['website']) ?>" target="_blank" rel="noopener">Visit Website <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a></strong></div><?php endif; ?>
                    </div>
                </section>

                <section class="pl-profile-section" id="plLocation">
                    <div class="pl-section-heading"><span class="pl-section-icon"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i></span><div><h2>Location &amp; Service Area</h2><p>Where <?= $d['is_business'] ? 'this business operates' : 'this professional works' ?></p></div></div>
                    <div class="pl-profile-location-card">
                        <div class="pl-location-map-placeholder"><i class="bi bi-map" aria-hidden="true"></i><span><?= !empty($d['service_radius_km']) ? 'Serves within ' . (int)$d['service_radius_km'] . ' km' : 'Location' ?></span></div>
                        <div class="pl-location-details"><span class="pl-location-eyebrow">PRIMARY LOCATION</span><h3><?= h($d['location_text']) ?></h3><?php if (!empty($d['address'])): ?><p><?= h($d['address']) ?></p><?php endif; ?>
                            <a class="pl-button pl-button-outline" href="https://www.google.com/maps/<?= ($d['latitude'] && $d['longitude']) ? 'dir/?api=1&destination=' . $d['latitude'] . ',' . $d['longitude'] : 'search/?api=1&query=' . rawurlencode($d['location_text']) ?>" target="_blank" rel="noopener"><i class="bi bi-map" aria-hidden="true"></i> <?= ($d['latitude'] && $d['longitude']) ? 'Get Directions' : 'View Location' ?></a></div>
                    </div>
                </section>

                <?php if ($ddSimilar): ?>
                <section class="pl-profile-section" id="plSimilar">
                    <div class="pl-section-heading pl-section-heading-between"><div class="pl-section-heading"><span class="pl-section-icon"><i class="bi bi-people-fill" aria-hidden="true"></i></span><div><h2>Similar Listings</h2><p>More in <?= h($d['category_name']) ?></p></div></div><a class="pl-text-link" href="professional-and-business-directory-search-results.php?category=<?= rawurlencode($d['category_name']) ?>">View All Listings <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a></div>
                    <div class="pl-similar-grid"><?php foreach ($ddSimilar as $s): ?><article class="pl-similar-card"><div class="pl-similar-avatar<?= $s['is_business'] ? ' pl-similar-avatar-business' : '' ?>"><?php if ($s['is_business']): ?><i class="bi bi-building" aria-hidden="true"></i><?php else: ?><span><?= h($s['initials']) ?></span><?php endif; ?></div><div class="pl-similar-info"><span><?= h($s['category_text']) ?></span><h3><?= h($s['title']) ?></h3><p><i class="bi bi-geo-alt" aria-hidden="true"></i> <?= h($s['location_text']) ?></p><a href="professional-business-profile-details.php?id=<?= (int)$s['id'] ?>">View Profile <i class="bi bi-arrow-right" aria-hidden="true"></i></a></div></article><?php endforeach; ?></div>
                </section>
                <?php endif; ?>
            </div>

            <aside class="pl-profile-sidebar">
                <div class="pl-profile-contact-card">
                    <div class="pl-contact-card-heading"><span><i class="bi bi-chat-square-text" aria-hidden="true"></i></span><div><h2>Contact Details</h2><p>Connect with <?= $d['is_business'] ? 'this business' : 'this professional' ?></p></div></div>
                    <div class="pl-contact-private-note"><i class="bi bi-shield-lock" aria-hidden="true"></i><span>Contact details are shown to logged-in members of the community.</span></div>
                    <div class="pl-contact-detail"><span class="pl-contact-detail-icon"><i class="bi bi-telephone" aria-hidden="true"></i></span><div><small>Mobile Number</small><strong><?= $ddTel ? '<a href="tel:' . h($ddTel) . '">' . h($d['phone']) . '</a>' : 'Available on enquiry' ?></strong></div></div>
                    <div class="pl-contact-detail"><span class="pl-contact-detail-icon"><i class="bi bi-envelope" aria-hidden="true"></i></span><div><small>Email Address</small><strong><?= !empty($d['email']) ? '<a href="mailto:' . h($d['email']) . '">' . h($d['email']) . '</a>' : 'Available on enquiry' ?></strong></div></div>
                    <?php if (!empty($d['website'])): ?><div class="pl-contact-detail"><span class="pl-contact-detail-icon"><i class="bi bi-globe" aria-hidden="true"></i></span><div><small>Website</small><strong><a href="<?= h($d['website']) ?>" target="_blank" rel="noopener"><?= h(parse_url($d['website'], PHP_URL_HOST) ?: $d['website']) ?></a></strong></div></div><?php endif; ?>
                    <?php if (!$ddOwn): ?><a class="pl-button pl-button-orange pl-contact-full-button" href="enquiry-contact.php?id=<?= $ddId ?>"><i class="bi bi-send" aria-hidden="true"></i> Send an Enquiry</a><?php endif; ?>
                    <?php if ($ddWa && !$ddOwn): ?><a class="pl-button pl-button-whatsapp" href="https://wa.me/<?= h($ddWa) ?>?text=<?= rawurlencode('Hello, I found your profile "' . $d['title'] . '" on PeopleLink.') ?>" target="_blank" rel="noopener"><i class="bi bi-whatsapp" aria-hidden="true"></i> WhatsApp Contact</a><?php endif; ?>
                    <p class="pl-contact-privacy"><i class="bi bi-lock-fill" aria-hidden="true"></i> Your information is shared according to PeopleLink privacy settings.</p>
                </div>
                <div class="pl-profile-facts-card">
                    <h3><i class="bi bi-info-circle" aria-hidden="true"></i> Quick Information</h3>
                    <div><span>Profile Type</span><strong><?= h($d['profile_type']) ?></strong></div>
                    <?php if (!empty($d['experience_years'])): ?><div><span>Experience</span><strong><?= (int)$d['experience_years'] ?> Years</strong></div><?php endif; ?>
                    <div><span>Availability</span><strong><i class="pl-status-dot" aria-hidden="true"></i> Open to enquiries</strong></div>
                    <?php if (!empty($dx['service_mode'])): ?><div><span>Service Mode</span><strong><?= h($dx['service_mode']) ?></strong></div><?php endif; ?>
                    <div><span>Listed Since</span><strong><?= h(date('M Y', strtotime($d['created_at']))) ?></strong></div>
                </div>
                <?php if (!$ddOwn): ?>
                <div class="pl-profile-report-card">
                    <i class="bi bi-flag" aria-hidden="true"></i>
                    <div><strong>Notice something wrong?</strong><p>Help keep the directory useful and trustworthy.</p>
                        <form id="ddReport" style="display:grid;gap:8px;margin-top:8px"><select name="reason" required style="padding:8px;border-radius:8px;border:1px solid #cbd5e1"><option value="">Choose a reason</option><option>Incorrect information</option><option>Fake or misleading profile</option><option>Inappropriate content</option><option>Spam</option><option>Other</option></select><textarea name="details" rows="2" placeholder="Details (optional)" style="padding:8px;border-radius:8px;border:1px solid #cbd5e1"></textarea><button type="submit">Report this profile</button></form>
                    </div>
                </div>
                <?php endif; ?>
            </aside>
        </div>
    </section>
</main>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var f = document.getElementById('ddReport'); if (!f) return;
  f.addEventListener('submit', async function (e) {
    e.preventDefault(); if (!window.PL || !PL.requireLogin()) return;
    var data = { id: <?= $ddId ?> }; new FormData(f).forEach(function (v, k) { data[k] = v; });
    var r = await PL.post('directory_report', data); PL.toast(r.message || r.error || 'Done.', !r.ok); if (r.ok) f.reset();
  });
});
</script>
<?php include 'footer.php'; ?>
