<?php
// Near Me – listing details (live: nearme_details = a Directory profile, with distance from the visitor's location)
require_once dirname(__DIR__) . '/_web.php';
$ndId = (int)($_GET['id'] ?? 0);
$ndLat = is_numeric($_GET['lat'] ?? null) ? (float)$_GET['lat'] : null;
$ndLng = is_numeric($_GET['lng'] ?? null) ? (float)$_GET['lng'] : null;
$ndRes = $ndId ? web_call('nearme_details', array_filter(['id' => $ndId, 'lat' => $ndLat, 'lng' => $ndLng], fn($v) => $v !== null)) : ['error' => 'missing'];
if (!empty($ndRes['error'])) {
    flash($webUser ? 'This listing is not available.' : 'Please login to view this listing.', 'error');
    header('Location: ' . ($webUser ? 'near-me.php' : DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? ''))); exit;
}
$nd = web_dir_card($ndRes['item']);
$ndX = is_array($nd['details'] ?? null) ? $nd['details'] : [];
$listing = [
    'id' => (int)$nd['id'], 'name' => $nd['title'], 'logo' => $nd['image'] ?: 'assets/images/default-business.png',
    'category' => $nd['category_name'], 'service' => $nd['subcategory_name'] ?? ($nd['services_list'][0] ?? ''),
    'distance' => isset($nd['distance_km']) && $nd['distance_km'] !== null ? $nd['distance_km'] . ' km' : '',
    'area' => $nd['area'] ?? '', 'city' => $nd['city'] ?? '', 'state' => $nd['state'] ?? '',
    'description' => $nd['description'] ?? '', 'services' => $nd['services_list'],
    'experience' => !empty($nd['experience_years']) ? (int)$nd['experience_years'] . ' years' : '',
    'working_hours' => $ndX['working_hours'] ?? '', 'service_area' => $ndX['service_areas'] ?? (!empty($nd['service_radius_km']) ? 'Within ' . (int)$nd['service_radius_km'] . ' km' : ''),
    'mobile' => $nd['phone'] ?? '', 'whatsapp' => $nd['whatsapp'] ?? '', 'email' => $nd['email'] ?? '', 'website' => $nd['website'] ?? '',
    'address' => trim(implode(', ', array_filter([$nd['address'] ?? '', $nd['location_text']])), ', '),
    'latitude' => $nd['latitude'] ?? null, 'longitude' => $nd['longitude'] ?? null, 'is_verified' => true,
];
// similar: nearby profiles in the same category (closest first when the visitor's location is known)
$_REQUEST['per'] = 4; $_REQUEST['page'] = 1;
$simRes = $ndLat !== null ? web_call('nearme_list', ['lat' => $ndLat, 'lng' => $ndLng, 'category_id' => $nd['category_id'], 'per' => 4]) : ['items' => web_ent_list('directory', ['category_id' => $nd['category_id']], 4)['items'] ?? []];
$similarListings = [];
foreach ($simRes['items'] ?? [] as $s) {
    if ((int)$s['id'] === $ndId) continue;
    $c = web_dir_card($s);
    $similarListings[] = ['id' => (int)$c['id'], 'name' => $c['title'], 'category' => $c['category_name'], 'service' => $c['category_text'], 'area' => $c['area'] ?: $c['city'],
        'distance' => isset($s['distance_km']) && $s['distance_km'] !== null ? $s['distance_km'] . ' km' : '', 'logo' => $c['image'] ?: 'assets/images/default-business.png'];
}
$similarListings = array_slice($similarListings, 0, 3);

function hasValue($value) {
    return trim((string)($value ?? '')) !== '';
}

$listingUrl = 'near-me-details.php?id=' . (int)$listing['id'];
$nearMeUrl = 'near-me.php';
$mapQuery = $listing['latitude'] !== null && $listing['longitude'] !== null ? $listing['latitude'] . ',' . $listing['longitude'] : $listing['address'];
$mapUrl = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($mapQuery);
$directionsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode($mapQuery);
$websiteUrl = '';
if (hasValue($listing['website'])) {
    $candidateUrl = filter_var($listing['website'], FILTER_VALIDATE_URL);
    $scheme = $candidateUrl ? strtolower((string)parse_url($candidateUrl, PHP_URL_SCHEME)) : '';
    if ($candidateUrl && in_array($scheme, ['http', 'https'], true)) $websiteUrl = $candidateUrl;
}
$isSaved = !empty($nd['saved']);
?>


<?php
include 'header.php';
?>

<main class="near-details-page">
    <div class="container">

        <!-- Breadcrumb -->
        <nav class="near-details-breadcrumb" aria-label="Breadcrumb">
            <a href="../community/community-home.php">
                <i class="bi bi-house-door"></i> Community
            </a>
            <i class="bi bi-chevron-right"></i>
            <a href="<?= e($nearMeUrl) ?>">Near Me</a>
            <i class="bi bi-chevron-right"></i>
            <span>Listing Details</span>
        </nav>

        <!-- Listing Header -->
        <section class="listing-detail-hero">

            <div class="listing-detail-main">

                <div class="listing-detail-logo">
                    <img
                        src="<?= e($listing['logo']) ?>"
                        alt="<?= e($listing['name']) ?> logo"
                        onerror="this.onerror=null;this.src='assets/images/default-business.png';"
                    >
                </div>

                <div class="listing-detail-heading">

                    <div class="listing-detail-badges">
                        <span class="listing-category-badge">
                            <?= e($listing['category']) ?>
                        </span>

                        <?php if ($listing['is_verified']): ?>
                            <span class="listing-verified-badge">
                                <i class="bi bi-patch-check-fill"></i> Verified
                            </span>
                        <?php endif; ?>
                    </div>

                    <h1><?= e($listing['name']) ?></h1>

                    <p class="listing-detail-service">
                        <i class="bi bi-briefcase"></i>
                        <?= e($listing['service']) ?>
                    </p>

                    <div class="listing-detail-meta">
                        <span>
                            <i class="bi bi-geo-alt"></i>
                            <?= e($listing['area']) ?>, <?= e($listing['city']) ?>
                        </span>

                        <span>
                            <i class="bi bi-signpost-2"></i>
                            <?= e($listing['distance']) ?> away
                        </span>
                    </div>

                </div>

            </div>

            <div class="listing-detail-actions">

                <?php if (hasValue($listing['mobile'])): ?>
                    <a class="detail-action-btn detail-call"
                       href="tel:<?= e(preg_replace('/[^0-9+]/', '', $listing['mobile'])) ?>">
                        <i class="bi bi-telephone-fill"></i>
                        Call
                    </a>
                <?php endif; ?>

                <?php if (hasValue($listing['whatsapp'])): ?>
                    <?php
                    $whatsappNumber = preg_replace('/\D/', '', $listing['whatsapp']);
                    ?>
                    <a class="detail-action-btn detail-whatsapp"
                       href="https://wa.me/<?= e($whatsappNumber) ?>"
                       target="_blank"
                       rel="noopener noreferrer">
                        <i class="bi bi-whatsapp"></i>
                        WhatsApp
                    </a>
                <?php endif; ?>

                <a class="detail-action-btn detail-location"
                   href="<?= e($mapUrl) ?>"
                   target="_blank"
                   rel="noopener noreferrer">
                    <i class="bi bi-geo-alt-fill"></i>
                    View Location
                </a>

                <button type="button"
                        class="detail-action-btn detail-save <?= $isSaved ? 'is-saved' : '' ?>"
                        id="saveListing"
                        data-listing-id="<?= (int)$listing['id'] ?>"
                        aria-pressed="<?= $isSaved ? 'true' : 'false' ?>">
                    <i class="bi <?= $isSaved ? 'bi-bookmark-fill' : 'bi-bookmark' ?>"></i>
                    <span><?= $isSaved ? 'Saved' : 'Save' ?></span>
                </button>

            </div>

        </section>

        <!-- Main Content -->
        <div class="row g-4 near-details-layout">

            <div class="col-lg-8">

                <!-- About -->
                <section class="near-detail-card">

                    <div class="near-detail-card-heading">
                        <div class="near-detail-icon icon-blue">
                            <i class="bi bi-info-circle"></i>
                        </div>
                        <div>
                            <h2>About</h2>
                            <p>Learn more about this listing</p>
                        </div>
                    </div>

                    <p class="listing-about-text">
                        <?= e($listing['description']) ?>
                    </p>

                    <div class="listing-facts">

                        <?php if (hasValue($listing['experience'])): ?>
                            <div class="listing-fact">
                                <span class="listing-fact-icon">
                                    <i class="bi bi-award"></i>
                                </span>
                                <div>
                                    <span>Experience</span>
                                    <strong><?= e($listing['experience']) ?></strong>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (hasValue($listing['working_hours'])): ?>
                            <div class="listing-fact">
                                <span class="listing-fact-icon">
                                    <i class="bi bi-clock"></i>
                                </span>
                                <div>
                                    <span>Working Hours</span>
                                    <strong><?= e($listing['working_hours']) ?></strong>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (hasValue($listing['service_area'])): ?>
                            <div class="listing-fact">
                                <span class="listing-fact-icon">
                                    <i class="bi bi-map"></i>
                                </span>
                                <div>
                                    <span>Service Area</span>
                                    <strong><?= e($listing['service_area']) ?></strong>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                </section>

                <!-- Services -->
                <section class="near-detail-card">

                    <div class="near-detail-card-heading">
                        <div class="near-detail-icon icon-green">
                            <i class="bi bi-list-check"></i>
                        </div>
                        <div>
                            <h2>Services Offered</h2>
                            <p>Services available at this business</p>
                        </div>
                    </div>

                    <?php if (!empty($listing['services'])): ?>
                        <div class="listing-services-grid">
                            <?php foreach ($listing['services'] as $service): ?>
                                <div class="listing-service-item">
                                    <span><i class="bi bi-check2-circle"></i></span>
                                    <?= e($service) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="listing-empty-text">
                            Services have not been added yet.
                        </p>
                    <?php endif; ?>

                </section>

                <!-- Contact -->
                <section class="near-detail-card">

                    <div class="near-detail-card-heading">
                        <div class="near-detail-icon icon-purple">
                            <i class="bi bi-person-lines-fill"></i>
                        </div>
                        <div>
                            <h2>Contact Details</h2>
                            <p>Available contact and business information</p>
                        </div>
                    </div>

                    <div class="listing-contact-grid">

                        <?php if (hasValue($listing['mobile'])): ?>
                            <div class="listing-contact-item">
                                <span class="contact-detail-icon">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <div>
                                    <span>Mobile Number</span>
                                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $listing['mobile'])) ?>">
                                        <?= e($listing['mobile']) ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (hasValue($listing['whatsapp'])): ?>
                            <div class="listing-contact-item">
                                <span class="contact-detail-icon contact-green">
                                    <i class="bi bi-whatsapp"></i>
                                </span>
                                <div>
                                    <span>WhatsApp Number</span>
                                    <a href="https://wa.me/<?= e(preg_replace('/\D/', '', $listing['whatsapp'])) ?>"
                                       target="_blank"
                                       rel="noopener noreferrer">
                                        <?= e($listing['whatsapp']) ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (hasValue($listing['email'])): ?>
                            <div class="listing-contact-item">
                                <span class="contact-detail-icon">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <div>
                                    <span>Email Address</span>
                                    <a href="mailto:<?= e($listing['email']) ?>">
                                        <?= e($listing['email']) ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($websiteUrl !== ''): ?>
                            <div class="listing-contact-item">
                                <span class="contact-detail-icon">
                                    <i class="bi bi-globe"></i>
                                </span>
                                <div>
                                    <span>Website</span>
                                    <a href="<?= e($websiteUrl) ?>"
                                       target="_blank"
                                       rel="noopener noreferrer">
                                        Visit Website
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (hasValue($listing['address'])): ?>
                            <div class="listing-contact-item contact-full">
                                <span class="contact-detail-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </span>
                                <div>
                                    <span>Full Address</span>
                                    <strong><?= e($listing['address']) ?></strong>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (
                            !hasValue($listing['mobile']) &&
                            !hasValue($listing['whatsapp']) &&
                            !hasValue($listing['email']) &&
                            $websiteUrl === ''
                        ): ?>
                            <p class="listing-empty-text contact-full">
                                Contact information has not been provided.
                            </p>
                        <?php endif; ?>

                    </div>

                </section>

                <!-- Location -->
                <section class="near-detail-card">

                    <div class="near-detail-card-heading">
                        <div class="near-detail-icon icon-orange">
                            <i class="bi bi-pin-map"></i>
                        </div>
                        <div>
                            <h2>Location</h2>
                            <p>Find this business or professional</p>
                        </div>
                    </div>

                    <div class="listing-location-box">

                        <div class="listing-location-symbol">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>

                        <div class="listing-location-info">
                            <h3><?= e($listing['area']) ?></h3>
                            <p><?= e($listing['address']) ?></p>

                            <div class="location-mini-meta">
                                <span>
                                    <i class="bi bi-buildings"></i>
                                    <?= e($listing['city']) ?>, <?= e($listing['state']) ?>
                                </span>
                                <span>
                                    <i class="bi bi-signpost-2"></i>
                                    <?= e($listing['distance']) ?>
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="listing-location-actions">
                        <a href="<?= e($mapUrl) ?>"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="location-map-btn">
                            <i class="bi bi-map"></i>
                            Open Map
                        </a>

                        <a href="<?= e($directionsUrl) ?>"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="location-directions-btn">
                            <i class="bi bi-sign-turn-right"></i>
                            Get Directions
                        </a>
                    </div>

                </section>

            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">

                <!-- Listing Summary -->
                <aside class="near-details-sidebar">

                    <div class="sidebar-heading">
                        <i class="bi bi-card-checklist"></i>
                        <h2>Listing Summary</h2>
                    </div>

                    <div class="sidebar-business-summary">
                        <div class="sidebar-business-logo">
                            <img
                                src="<?= e($listing['logo']) ?>"
                                alt=""
                                onerror="this.onerror=null;this.src='assets/images/default-business.png';"
                            >
                        </div>

                        <h3><?= e($listing['name']) ?></h3>
                        <p><?= e($listing['category']) ?></p>
                    </div>

                    <div class="sidebar-detail-row">
                        <span>Specialization</span>
                        <strong><?= e($listing['service']) ?></strong>
                    </div>

                    <div class="sidebar-detail-row">
                        <span>Area</span>
                        <strong><?= e($listing['area']) ?></strong>
                    </div>

                    <div class="sidebar-detail-row">
                        <span>Distance</span>
                        <strong><?= e($listing['distance']) ?></strong>
                    </div>

                    <div class="sidebar-detail-row">
                        <span>City</span>
                        <strong><?= e($listing['city']) ?></strong>
                    </div>

                    <a href="<?= e($nearMeUrl) ?>" class="sidebar-back-link">
                        <i class="bi bi-arrow-left"></i>
                        Back to Nearby Listings
                    </a>

                </aside>

                <!-- Similar Listings -->
                <aside class="near-details-sidebar similar-sidebar">

                    <div class="sidebar-heading">
                        <i class="bi bi-geo"></i>
                        <h2>Similar Nearby Listings</h2>
                    </div>

                    <?php foreach ($similarListings as $similar): ?>
                        <div class="similar-listing-item">

                            <div class="similar-listing-logo">
                                <img
                                    src="<?= e($similar['logo']) ?>"
                                    alt=""
                                    onerror="this.onerror=null;this.src='assets/images/default-business.png';"
                                >
                            </div>

                            <div class="similar-listing-info">
                                <h3><?= e($similar['name']) ?></h3>
                                <span><?= e($similar['category']) ?></span>
                                <p>
                                    <i class="bi bi-geo-alt"></i>
                                    <?= e($similar['area']) ?>
                                    &middot;
                                    <?= e($similar['distance']) ?>
                                </p>

                                <a href="near-me-details.php?id=<?= (int)$similar['id'] ?>">
                                    View Details
                                    <i class="bi bi-arrow-up-right"></i>
                                </a>
                            </div>

                        </div>
                    <?php endforeach; ?>

                    <a href="<?= e($nearMeUrl) ?>" class="sidebar-more-link">
                        View More Nearby Listings
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </aside>

            </div>

        </div>

        <!-- Bottom Navigation -->
        <div class="near-details-bottom">
            <a href="<?= e($nearMeUrl) ?>" class="detail-back-btn">
                <i class="bi bi-arrow-left"></i>
                Back to Near Me
            </a>

            <button type="button" class="detail-save-bottom" id="saveListingBottom">
                <i class="bi bi-bookmark"></i>
                Save Listing
            </button>
        </div>

        <div class="near-save-message" id="saveMessage" role="status" aria-live="polite"></div>

    </div>
</main>

<?php
include 'footer.php';
?>

 

</body>
</html>
