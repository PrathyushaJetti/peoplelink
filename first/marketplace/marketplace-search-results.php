<?php
// Marketplace Search Results (live: filters from marketplace-search.php applied by the marketplace backend)
require_once dirname(__DIR__) . '/_web.php';
$g = fn($k) => trim((string)($_GET[$k] ?? ''));
$mrQ = trim($g('keyword') . ' ' . $g('listing_name'));
$mrPosted = ['today' => 1, '3days' => 3, '7days' => 7, '30days' => 30][$g('posted_within')] ?? 0;
$mrFilters = [
    'q' => $mrQ, 'category' => $g('category'), 'item_condition' => $g('condition'),
    'city' => $g('city'), 'location' => $g('area'), 'price_min' => $g('min_price'), 'price_max' => $g('max_price'),
    'sort' => ['recent' => 'recent', 'price_low' => 'price_asc', 'price_high' => 'price_desc'][$g('sort')] ?? '',
];
$E = pl_entity('mp_listing');
$mrRes = pl_ent_list($E, $webCid, array_filter($mrFilters, fn($v) => $v !== ''), $webUid, 1, 50,
    $mrPosted ? 't.created_at >= NOW() - INTERVAL ? DAY' : null, $mrPosted ? [$mrPosted] : []);
$mrItems = array_map('web_mp_card', $mrRes['items']);
// seller names for the card footers
$mrSellers = [];
if ($mrItems) foreach (rows('SELECT id, name FROM users WHERE id IN (' . implode(',', array_map('intval', array_unique(array_column(rows('SELECT user_id FROM mp_listings WHERE id IN (' . implode(',', array_map('intval', array_column($mrItems, 'id'))) . ')'), 'user_id')))) . ')') as $u) $mrSellers[(int)$u['id']] = $u['name'];
$mrOwner = $mrItems ? array_column(rows('SELECT id, user_id FROM mp_listings WHERE id IN (' . implode(',', array_map('intval', array_column($mrItems, 'id'))) . ')'), 'user_id', 'id') : [];
$ini = fn($n) => strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice(preg_split('/\s+/', trim((string)$n)), 0, 2)))) ?: 'PL';
include 'header.php'; ?>

 

<main class="pl-mr-page">

    <!-- Page Heading -->
    <section class="pl-mr-hero">
        <div class="pl-mr-container">
            <div class="pl-mr-breadcrumb">
                <a href="marketplace-home.php">Marketplace</a>
                <span>/</span>
                <span>Search Results</span>
            </div>

            <div class="pl-mr-hero-content">
                <div>
                    <span class="pl-mr-eyebrow">PEOPLELINK MARKETPLACE</span>
                    <h1>Marketplace Listings</h1>
                    <p>Discover products, services and great finds from your community.</p>
                </div>

                <a href="marketplace-search.php" class="pl-mr-edit-btn">
                    <i class="fas fa-sliders-h"></i>
                    Edit Filters
                </a>
            </div>

            <!-- Search Summary -->
            <div class="pl-mr-search-summary">
                <div class="pl-mr-summary-item">
                    <i class="fas fa-search"></i>
                    <div>
                        <span>Search Keyword</span>
                        <strong id="plMrKeyword"><?= $mrQ !== '' ? h($mrQ) : 'All listings' ?></strong>
                    </div>
                </div>

                <div class="pl-mr-summary-item">
                    <i class="fas fa-th-large"></i>
                    <div>
                        <span>Category</span>
                        <strong id="plMrCategory"><?= h($g('category') ?: 'All Categories') ?></strong>
                    </div>
                </div>

                <div class="pl-mr-summary-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <span>Location</span>
                        <strong id="plMrLocation"><?= h(trim($g('area') . ' ' . $g('city')) ?: 'All Locations') ?></strong>
                    </div>
                </div>

                <div class="pl-mr-summary-count">
                    <strong id="plMrCount"><?= count($mrItems) ?></strong>
                    <span>Listings Found</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Results Section -->
    <section class="pl-mr-results-section">
        <div class="pl-mr-container">

            <!-- Category Quick Filter -->
            <div class="pl-mr-category-panel">
                <div class="pl-mr-category-heading">
                    <div>
                        <h2>Explore Categories</h2>
                        <p>Quickly switch to another category.</p>
                    </div>
                </div>

                <div class="pl-mr-category-list" id="plMrCategories">
                    <button type="button" class="pl-mr-category active" data-category="">
                        <i class="fas fa-th-large"></i>
                        <span>All</span>
                    </button>

                    <button type="button" class="pl-mr-category" data-category="Property">
                        <i class="fas fa-home"></i>
                        <span>Property</span>
                    </button>

                    <button type="button" class="pl-mr-category" data-category="Cars">
                        <i class="fas fa-car"></i>
                        <span>Cars</span>
                    </button>

                    <button type="button" class="pl-mr-category" data-category="Bikes">
                        <i class="fas fa-motorcycle"></i>
                        <span>Bikes</span>
                    </button>

                    <button type="button" class="pl-mr-category" data-category="Electronics">
                        <i class="fas fa-laptop"></i>
                        <span>Electronics</span>
                    </button>

                    <button type="button" class="pl-mr-category" data-category="Furniture">
                        <i class="fas fa-couch"></i>
                        <span>Furniture</span>
                    </button>

                    <button type="button" class="pl-mr-category" data-category="Products">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Products</span>
                    </button>

                    <button type="button" class="pl-mr-category" data-category="Services">
                        <i class="fas fa-tools"></i>
                        <span>Services</span>
                    </button>

                    <button type="button" class="pl-mr-category" data-category="Other">
                        <i class="fas fa-ellipsis-h"></i>
                        <span>Other</span>
                    </button>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="pl-mr-toolbar">
                <div class="pl-mr-results-label">
                    <h2>Available Listings</h2>
                    <p>Browse items shared by community members.</p>
                </div>

                <div class="pl-mr-toolbar-actions">
                    <label class="pl-mr-sort-label" for="plMrSort">
                        <i class="fas fa-sort-amount-down"></i>
                        Sort by
                    </label>

                    <select id="plMrSort" class="pl-mr-sort-select">
                        <option value="relevant">Most Relevant</option>
                        <option value="recent">Recently Added</option>
                        <option value="low">Price: Low to High</option>
                        <option value="high">Price: High to Low</option>
                        <option value="nearest">Nearest</option>
                    </select>

                    <button type="button" class="pl-mr-view-toggle active"
                            data-view="grid" aria-label="Grid view">
                        <i class="fas fa-th-large"></i>
                    </button>

                    <button type="button" class="pl-mr-view-toggle"
                            data-view="list" aria-label="List view">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>

            <!-- Listings Grid -->
            <div class="pl-mr-listings-grid" id="plMrListings">

                <!-- Listing 1 -->
                <?php foreach ($mrItems as $m): $seller = $m['contact_name'] ?: ($mrSellers[(int)($mrOwner[$m['id']] ?? 0)] ?? 'Community Member'); ?>
                <article class="pl-mr-card" data-category="<?= h($m['category_name']) ?>" data-price="<?= (int)$m['price'] ?>" data-date="<?= h($m['posted']) ?>" data-title="<?= h($m['title']) ?>" data-location="<?= h($m['city'] ?: $m['location_text']) ?>" data-condition="<?= h($m['item_condition']) ?>" data-status="available">
                    <div class="pl-mr-card-image">
                        <img src="<?= h($m['image'] ?: 'images/marketplace-placeholder.jpg') ?>" alt="<?= h($m['title']) ?>" loading="lazy">
                        <span class="pl-mr-status available"><?= h($m['listing_type'] ?: 'Available') ?></span>
                        <button type="button" class="pl-mr-save" data-live="1" data-save-id="<?= (int)$m['id'] ?>" data-saved="<?= !empty($m['saved']) ? '1' : '0' ?>" aria-label="Save <?= h($m['title']) ?>" aria-pressed="<?= !empty($m['saved']) ? 'true' : 'false' ?>"><i class="<?= !empty($m['saved']) ? 'fas' : 'far' ?> fa-heart"></i></button>
                    </div>
                    <div class="pl-mr-card-body">
                        <div class="pl-mr-card-meta"><span class="pl-mr-card-category"><?= h($m['category_text']) ?></span><?php if ($m['item_condition']): ?><span class="pl-mr-condition"><?= h($m['item_condition']) ?></span><?php endif; ?></div>
                        <h3><a href="marketplace-listing-details.php?id=<?= (int)$m['id'] ?>"><?= h($m['title']) ?></a></h3>
                        <div class="pl-mr-price"><?= h($m['price_text']) ?></div>
                        <div class="pl-mr-location"><i class="fas fa-map-marker-alt"></i> <?= h($m['location_text']) ?></div>
                        <div class="pl-mr-card-footer">
                            <div class="pl-mr-seller"><span class="pl-mr-avatar"><?= h($ini($seller)) ?></span><div><strong><?= h($seller) ?></strong><span><?= ($m['visibility_type'] ?? '') === 'global' ? 'PeopleLink Member' : h(($m['community_name'] ?? 'Community') . ' Member') ?></span></div></div>
                            <span class="pl-mr-date"><?= h(date('d M Y', strtotime($m['created_at']))) ?></span>
                        </div>
                        <div class="pl-mr-card-actions">
                            <a href="marketplace-listing-details.php?id=<?= (int)$m['id'] ?>" class="pl-mr-view-btn">View Details</a>
                            <a href="contact-seller.php?id=<?= (int)$m['id'] ?>" class="pl-mr-contact-btn"><i class="fas fa-comment-alt"></i> Contact</a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>

            </div>

            <!-- No Results -->
            <div class="pl-mr-no-results" id="plMrNoResults" hidden>
                <div class="pl-mr-no-results-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h2>No marketplace listings found</h2>
                <p>No marketplace listings found matching your search.</p>

                <div class="pl-mr-no-results-actions">
                    <a href="marketplace-search.php" class="pl-mr-primary-btn">
                        Modify Filters
                    </a>
                    <button type="button" id="plMrViewAll" class="pl-mr-secondary-btn">
                        View All Listings
                    </button>
                </div>
            </div>

            <!-- Load More -->
            <div class="pl-mr-load-more-wrap" id="plMrLoadMoreWrap">
                <p>Showing <strong id="plMrShowing">8</strong> listings</p>
                <button type="button" id="plMrLoadMore" class="pl-mr-load-more">
                    Load More Listings
                    <i class="fas fa-arrow-down"></i>
                </button>
            </div>

        </div>
    </section>

    <!-- Contact Notice -->
    <div class="pl-mr-toast" id="plMrToast" role="status" aria-live="polite"></div>

</main>

 

<?php include 'footer.php'; ?>
 
