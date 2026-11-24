<?php
$page_title = "Listing Details | PeopleLink Marketplace";
$page_description = "View complete details of a Marketplace listing on PeopleLink Technologies.";
$page_css = "marketplace-listing.css";

include 'header.php';

/* ------------------------------------------------------------------
   DATA SOURCE
   Replace this sample array with your database query, e.g.
   $listing = getListingById((int)($_GET['id'] ?? 0));
   If not found, redirect to the Marketplace page.
------------------------------------------------------------------- */
$listing = [
    'id'            => 101,
    'title'         => 'Hyundai Creta SX 2019 - Single Owner',
    'images'        => [
        'images/marketplace/sample-1.jpg',
        'images/marketplace/sample-2.jpg',
        'images/marketplace/sample-3.jpg',
        'images/marketplace/sample-4.jpg',
    ],
    'category'      => 'Car',            // Property | Car | Bike | Electronics | Other
    'subcategory'   => 'SUV',
    'price'         => 1050000,
    'negotiable'    => true,
    'location'      => 'Indirapuram',
    'city'          => 'Ghaziabad',
    'posted_date'   => '2026-10-08',
    'status'        => 'Available',      // Available | Reserved | Sold
    'community'     => 'Indirapuram Residents',
    'condition'     => 'Used - Good',
    'brand'         => 'Hyundai',
    'model'         => 'Creta SX',
    'year'          => '2019',
    'description'   => "Well-maintained single-owner car with full service history. "
                     . "Regular servicing, no major accidents. Two keys available. "
                     . "Interested buyers can arrange a test drive.",
    // Category-specific fields (only relevant ones are displayed)
    'details'       => [
        'Brand'            => 'Hyundai',
        'Model'            => 'Creta SX',
        'Year'             => '2019',
        'Kilometres Driven'=> '48,000 km',
        'Fuel Type'        => 'Diesel',
    ],
    'seller'        => [
        'name'         => 'Rahul Sharma',
        'location'     => 'Indirapuram, Ghaziabad',
        'community'    => 'Indirapuram Residents',
        'member_since' => '2024',
        'phone'        => '919999999999',   // with country code, digits only
        'show_phone'   => true,             // privacy rule: show contact details?
    ],
];

$similar = [
    ['id' => 102, 'title' => 'Maruti Brezza VXI 2018', 'price' => 950000,  'location' => 'Vaishali',    'image' => 'images/marketplace/sample-5.jpg'],
    ['id' => 103, 'title' => 'Tata Nexon XZ 2020',     'price' => 1120000, 'location' => 'Indirapuram', 'image' => 'images/marketplace/sample-6.jpg'],
    ['id' => 104, 'title' => 'Kia Seltos HTX 2019',    'price' => 1180000, 'location' => 'Vasundhara',  'image' => 'images/marketplace/sample-7.jpg'],
    ['id' => 105, 'title' => 'Honda WR-V 2019',        'price' => 890000,  'location' => 'Kaushambi',   'image' => 'images/marketplace/sample-8.jpg'],
];

function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function money($n) { return '₹' . number_format((float)$n); }

$statusClass = 'pl-status-' . strtolower($listing['status']);
$seller      = $listing['seller'];
$waText      = rawurlencode("Hi, I'm interested in your listing \"" . $listing['title'] . "\" on PeopleLink Marketplace.");
?>

<main class="pl-listing-page">

    <div class="pl-container">

        <!-- Breadcrumb -->
        <nav class="pl-breadcrumb" aria-label="Breadcrumb">
            <a href="index.php">Home</a>
            <span>/</span>
            <a href="marketplace.php">Marketplace</a>
            <span>/</span>
            <a href="marketplace.php?category=<?php echo urlencode($listing['category']); ?>"><?php echo e($listing['category']); ?></a>
            <span>/</span>
            <strong><?php echo e($listing['title']); ?></strong>
        </nav>

        <!-- ==================== LISTING HEADER ==================== -->
        <section class="pl-listing-header">

            <div class="pl-gallery">
                <div class="pl-gallery-main">
                    <img id="plMainImage"
                         src="<?php echo e($listing['images'][0]); ?>"
                         alt="<?php echo e($listing['title']); ?>">
                    <span class="pl-status <?php echo e($statusClass); ?>"><?php echo e($listing['status']); ?></span>
                </div>

                <?php if (count($listing['images']) > 1): ?>
                <div class="pl-gallery-thumbs">
                    <?php foreach ($listing['images'] as $i => $img): ?>
                        <button type="button"
                                class="pl-thumb<?php echo $i === 0 ? ' active' : ''; ?>"
                                data-src="<?php echo e($img); ?>"
                                aria-label="View image <?php echo $i + 1; ?>">
                            <img src="<?php echo e($img); ?>" alt="" loading="lazy">
                        </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="pl-summary">
                <span class="pl-chip"><?php echo e($listing['category']); ?></span>
                <h1><?php echo e($listing['title']); ?></h1>

                <div class="pl-price">
                    <?php echo money($listing['price']); ?>
                    <small><?php echo $listing['negotiable'] ? 'Negotiable' : 'Fixed Price'; ?></small>
                </div>

                <ul class="pl-meta">
                    <li><i class="bi bi-geo-alt"></i> <?php echo e($listing['location'] . ', ' . $listing['city']); ?></li>
                    <li><i class="bi bi-calendar3"></i> Posted <?php echo e(date('d M Y', strtotime($listing['posted_date']))); ?></li>
                    <li><i class="bi bi-tag"></i> <?php echo e($listing['category']); ?><?php echo $listing['subcategory'] ? ' &middot; ' . e($listing['subcategory']) : ''; ?></li>
                    <?php if (!empty($listing['community'])): ?>
                    <li><i class="bi bi-people"></i> <?php echo e($listing['community']); ?></li>
                    <?php endif; ?>
                </ul>

                <div class="pl-actions">
                    <button type="button" class="pl-btn pl-btn-outline" id="plSaveBtn"
                            data-id="<?php echo (int)$listing['id']; ?>">
                        <i class="bi bi-bookmark"></i> <span>Save</span>
                    </button>
                    <a href="#contact-seller" class="pl-btn pl-btn-primary">
                        <i class="bi bi-chat-dots"></i> Contact Seller
                    </a>
                    <button type="button" class="pl-btn pl-btn-outline" id="plShareBtn">
                        <i class="bi bi-share"></i> Share
                    </button>
                </div>
            </div>

        </section>

        <div class="pl-layout">

            <div class="pl-main-col">

                <!-- ==================== ABOUT THE LISTING ==================== -->
                <section class="pl-card">
                    <h2>About the Listing</h2>
                    <p class="pl-description"><?php echo nl2br(e($listing['description'])); ?></p>

                    <dl class="pl-details-grid">
                        <div><dt>Category</dt><dd><?php echo e($listing['category']); ?></dd></div>
                        <?php if (!empty($listing['subcategory'])): ?>
                        <div><dt>Subcategory</dt><dd><?php echo e($listing['subcategory']); ?></dd></div>
                        <?php endif; ?>
                        <?php if (!empty($listing['condition'])): ?>
                        <div><dt>Condition</dt><dd><?php echo e($listing['condition']); ?></dd></div>
                        <?php endif; ?>
                        <?php if (!empty($listing['brand'])): ?>
                        <div><dt>Brand / Model</dt><dd><?php echo e(trim($listing['brand'] . ' ' . ($listing['model'] ?? ''))); ?></dd></div>
                        <?php endif; ?>
                        <?php if (!empty($listing['year'])): ?>
                        <div><dt>Age / Year</dt><dd><?php echo e($listing['year']); ?></dd></div>
                        <?php endif; ?>
                        <div><dt>Price</dt><dd><?php echo money($listing['price']); ?></dd></div>
                        <div><dt>Price Type</dt><dd><?php echo $listing['negotiable'] ? 'Negotiable' : 'Fixed Price'; ?></dd></div>
                        <div><dt>Availability</dt><dd><?php echo e($listing['status']); ?></dd></div>
                    </dl>
                </section>

                <!-- ==================== CATEGORY-SPECIFIC DETAILS ==================== -->
                <?php if (!empty($listing['details'])): ?>
                <section class="pl-card">
                    <h2><?php echo e($listing['category']); ?> Details</h2>
                    <dl class="pl-details-grid">
                        <?php foreach ($listing['details'] as $label => $value): ?>
                            <?php if ($value !== '' && $value !== null): ?>
                            <div><dt><?php echo e($label); ?></dt><dd><?php echo e($value); ?></dd></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </dl>
                </section>
                <?php endif; ?>

                <!-- ==================== LOCATION ==================== -->
                <section class="pl-card">
                    <h2>Location</h2>
                    <dl class="pl-details-grid">
                        <div><dt>Area / Locality</dt><dd><?php echo e($listing['location']); ?></dd></div>
                        <div><dt>City</dt><dd><?php echo e($listing['city']); ?></dd></div>
                    </dl>
                    <a class="pl-btn pl-btn-outline"
                       target="_blank" rel="noopener"
                       href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($listing['location'] . ' ' . $listing['city']); ?>">
                        <i class="bi bi-map"></i> View on Map
                    </a>
                </section>

            </div>

            <!-- ==================== SIDEBAR ==================== -->
            <aside class="pl-side-col">

                <!-- Seller information -->
                <section class="pl-card">
                    <h2>Seller Information</h2>
                    <div class="pl-seller">
                        <div class="pl-avatar"><?php echo e(strtoupper(substr($seller['name'], 0, 1))); ?></div>
                        <div>
                            <strong><?php echo e($seller['name']); ?></strong>
                            <span><i class="bi bi-geo-alt"></i> <?php echo e($seller['location']); ?></span>
                            <?php if (!empty($seller['community'])): ?>
                            <span><i class="bi bi-people"></i> <?php echo e($seller['community']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($seller['member_since'])): ?>
                            <span><i class="bi bi-patch-check"></i> Member since <?php echo e($seller['member_since']); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

                <!-- Contact seller -->
                <section class="pl-card" id="contact-seller">
                    <h2>Contact Seller</h2>

                    <?php if ($seller['show_phone'] && !empty($seller['phone'])): ?>
                        <div class="pl-contact-buttons">
                            <a class="pl-btn pl-btn-primary" href="tel:+<?php echo e($seller['phone']); ?>">
                                <i class="bi bi-telephone"></i> Call
                            </a>
                            <a class="pl-btn pl-btn-green" target="_blank" rel="noopener"
                               href="https://wa.me/<?php echo e($seller['phone']); ?>?text=<?php echo $waText; ?>">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    <?php else: ?>
                        <p class="pl-note">The seller keeps phone details private. Send an enquiry and they can reply to you.</p>
                    <?php endif; ?>

                    <form class="pl-enquiry" action="send-enquiry.php" method="POST">
                        <input type="hidden" name="listing_id" value="<?php echo (int)$listing['id']; ?>">

                        <label for="plEnqName">Your Name *</label>
                        <input type="text" id="plEnqName" name="name" required autocomplete="name">

                        <label for="plEnqPhone">Phone Number *</label>
                        <input type="tel" id="plEnqPhone" name="phone" required autocomplete="tel">

                        <label for="plEnqMsg">Message *</label>
                        <textarea id="plEnqMsg" name="message" rows="4" required>Hi, is this still available?</textarea>

                        <button type="submit" class="pl-btn pl-btn-primary pl-btn-block">
                            <i class="bi bi-send"></i> Send Enquiry
                        </button>
                    </form>
                </section>

            </aside>
        </div>

        <!-- ==================== SIMILAR LISTINGS ==================== -->
        <section class="pl-similar">
            <div class="pl-similar-head">
                <h2>Similar Listings</h2>
                <a class="pl-text-link"
                   href="marketplace.php?category=<?php echo urlencode($listing['category']); ?>&amp;location=<?php echo urlencode($listing['location']); ?>">
                    View Similar Listings <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="pl-similar-grid">
                <?php foreach ($similar as $s): ?>
                <a class="pl-similar-card" href="marketplace-listing-details.php?id=<?php echo (int)$s['id']; ?>">
                    <img src="<?php echo e($s['image']); ?>" alt="<?php echo e($s['title']); ?>" loading="lazy">
                    <div class="pl-similar-body">
                        <h3><?php echo e($s['title']); ?></h3>
                        <strong><?php echo money($s['price']); ?></strong>
                        <span><i class="bi bi-geo-alt"></i> <?php echo e($s['location']); ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>

    </div>
</main>

<script>
(function () {
    // Gallery thumbnails
    var main = document.getElementById('plMainImage');
    document.querySelectorAll('.pl-thumb').forEach(function (t) {
        t.addEventListener('click', function () {
            main.src = t.dataset.src;
            document.querySelectorAll('.pl-thumb').forEach(function (x) { x.classList.remove('active'); });
            t.classList.add('active');
        });
    });

    // Share
    document.getElementById('plShareBtn').addEventListener('click', function () {
        var data = { title: document.title, url: window.location.href };
        if (navigator.share) {
            navigator.share(data).catch(function () {});
        } else if (navigator.clipboard) {
            navigator.clipboard.writeText(data.url).then(function () { alert('Listing link copied.'); });
        }
    });

    // Save (UI toggle; connect to save-listing.php for logged-in users)
    var save = document.getElementById('plSaveBtn');
    save.addEventListener('click', function () {
        var on = save.classList.toggle('saved');
        save.querySelector('i').className = on ? 'bi bi-bookmark-fill' : 'bi bi-bookmark';
        save.querySelector('span').textContent = on ? 'Saved' : 'Save';
        // fetch('save-listing.php', {method:'POST', body:new URLSearchParams({listing_id: save.dataset.id})});
    });
})();
</script>

<?php include 'footer.php'; ?>