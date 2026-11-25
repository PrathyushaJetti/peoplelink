<?php
// Marketplace Home (live: newest approved listings for the viewer's community + global listings)
require_once dirname(__DIR__) . '/_web.php';
$mpLatest = array_map('web_mp_card', web_ent_list('mp_listing', ['sort' => 'recent'], 12)['items'] ?? []);
include 'header.php'; ?>

 

<main class="pl-marketplace-page">

    <!-- Hero -->
    <section class="pl-market-hero">
        <div class="pl-market-container pl-market-hero-grid">

            <div class="pl-market-hero-copy">
                <span class="pl-market-eyebrow">
                    <i class="bi bi-shop"></i>
                    PEOPLELINK COMMUNITY MARKETPLACE
                </span>

                <h1>Buy, Sell &amp; Discover
                    <span>Within Your Community</span>
                </h1>

                <p>
                    Explore property, vehicles, electronics, furniture,
                    products and services from people and businesses
                    in your community.
                </p>

                <div class="pl-market-hero-actions">
                    <a href="#marketplace-listings" class="pl-market-btn pl-market-btn-primary">
                        <i class="bi bi-search"></i> Browse Marketplace
                    </a>

                    <a href="post-listing.php" class="pl-market-btn pl-market-btn-outline">
                        <i class="bi bi-plus-circle"></i> Post a Listing
                    </a>
                </div>

                <div class="pl-market-trust">
                    <span><i class="bi bi-people-fill"></i> Community Connections</span>
                    <span><i class="bi bi-grid-fill"></i> Multiple Categories</span>
                    <span><i class="bi bi-geo-alt-fill"></i> Local Discoveries</span>
                </div>
            </div>

            <div class="pl-market-hero-art">
                <div class="pl-market-art-circle pl-market-art-circle-one"></div>
                <div class="pl-market-art-circle pl-market-art-circle-two"></div>

                <div class="pl-market-art-main">
                    <i class="bi bi-shop-window"></i>
                    <strong>Your Community.</strong>
                    <strong>Your Marketplace.</strong>
                    <span>Discover something valuable.</span>
                </div>

                <span class="pl-market-floating pl-market-floating-one">
                    <i class="bi bi-house-door-fill"></i> Property
                </span>

                <span class="pl-market-floating pl-market-floating-two">
                    <i class="bi bi-car-front-fill"></i> Vehicles
                </span>

                <span class="pl-market-floating pl-market-floating-three">
                    <i class="bi bi-bag-fill"></i> Products
                </span>
            </div>

        </div>
    </section>

    <!-- Marketplace Search -->
    <section class="pl-market-search-section">
        <div class="pl-market-container">

            <form class="pl-market-search" id="plMarketplaceSearch">

                <label class="pl-market-search-field">
                    <i class="bi bi-search"></i>
                    <span class="visually-hidden">Search listing</span>
                    <input type="search" id="plMarketKeyword"
                           placeholder="Product, property or keyword">
                </label>

                <label class="pl-market-search-field">
                    <i class="bi bi-grid"></i>
                    <span class="visually-hidden">Category</span>
                    <select id="plMarketCategory">
                        <option value="">All Categories</option>
                        <option value="Property">Property</option>
                        <option value="Cars">Cars</option>
                        <option value="Bikes">Bikes</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Products">Products</option>
                        <option value="Services">Services</option>
                        <option value="Other">Other</option>
                    </select>
                </label>

                <label class="pl-market-search-field">
                    <i class="bi bi-geo-alt"></i>
                    <span class="visually-hidden">Location</span>
                    <input type="text" id="plMarketLocation"
                           placeholder="City or locality">
                </label>

                <button type="submit" class="pl-market-search-button">
                    <i class="bi bi-search"></i> Search
                </button>

            </form>
        </div>
    </section>

    <!-- Categories -->
    <section class="pl-market-section">
        <div class="pl-market-container">

            <div class="pl-market-heading">
                <div>
                    <span class="pl-market-kicker">EXPLORE MARKETPLACE</span>
                    <h2>Browse by <span>Category</span></h2>
                    <p>Find what you need or discover something new.</p>
                </div>

                <a href="#marketplace-listings" class="pl-market-text-link">
                    View Listings <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="pl-market-category-grid">

                <button type="button" class="pl-market-category-card" data-market-category="Property">
                    <span class="pl-market-category-icon"><i class="bi bi-house-door"></i></span>
                    <strong>Property</strong>
                    <span class="pl-market-category-arrow"><i class="bi bi-arrow-up-right"></i></span>
                </button>

                <button type="button" class="pl-market-category-card" data-market-category="Cars">
                    <span class="pl-market-category-icon"><i class="bi bi-car-front"></i></span>
                    <strong>Cars</strong>
                    <span class="pl-market-category-arrow"><i class="bi bi-arrow-up-right"></i></span>
                </button>

                <button type="button" class="pl-market-category-card" data-market-category="Bikes">
                    <span class="pl-market-category-icon"><i class="bi bi-bicycle"></i></span>
                    <strong>Bikes</strong>
                    <span class="pl-market-category-arrow"><i class="bi bi-arrow-up-right"></i></span>
                </button>

                <button type="button" class="pl-market-category-card" data-market-category="Electronics">
                    <span class="pl-market-category-icon"><i class="bi bi-laptop"></i></span>
                    <strong>Electronics</strong>
                    <span class="pl-market-category-arrow"><i class="bi bi-arrow-up-right"></i></span>
                </button>

                <button type="button" class="pl-market-category-card" data-market-category="Furniture">
                    <span class="pl-market-category-icon"><i class="bi bi-lamp"></i></span>
                    <strong>Furniture</strong>
                    <span class="pl-market-category-arrow"><i class="bi bi-arrow-up-right"></i></span>
                </button>

                <button type="button" class="pl-market-category-card" data-market-category="Products">
                    <span class="pl-market-category-icon"><i class="bi bi-bag"></i></span>
                    <strong>Products</strong>
                    <span class="pl-market-category-arrow"><i class="bi bi-arrow-up-right"></i></span>
                </button>

                <button type="button" class="pl-market-category-card" data-market-category="Services">
                    <span class="pl-market-category-icon"><i class="bi bi-tools"></i></span>
                    <strong>Services</strong>
                    <span class="pl-market-category-arrow"><i class="bi bi-arrow-up-right"></i></span>
                </button>

                <button type="button" class="pl-market-category-card" data-market-category="Other">
                    <span class="pl-market-category-icon"><i class="bi bi-grid"></i></span>
                    <strong>Other</strong>
                    <span class="pl-market-category-arrow"><i class="bi bi-arrow-up-right"></i></span>
                </button>

            </div>
        </div>
    </section>

    <!-- Latest Listings -->
    <section class="pl-market-section pl-market-listings-section" id="marketplace-listings">
        <div class="pl-market-container">

            <div class="pl-market-heading">
                <div>
                    <span class="pl-market-kicker">FRESH FINDS</span>
                    <h2>Latest <span>Listings</span></h2>
                    <p>Discover products and services recently added to the marketplace.</p>
                </div>

                <a href="marketplace-search.php" class="pl-market-text-link">
                    Explore All <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="pl-market-toolbar">
                <span><i class="bi bi-grid-3x3-gap"></i>
                    <strong id="plMarketResultCount"><?= count($mpLatest) ?></strong> listings
                </span>

                <label class="pl-market-sort">
                    Sort:
                    <select id="plMarketSort">
                        <option value="recent">Recently Added</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="name">Name A–Z</option>
                    </select>
                </label>
            </div>

            <div class="pl-market-listing-grid" id="plMarketListingGrid">

                <?php if (!$mpLatest): ?><p class="pl-market-empty" style="grid-column:1/-1;text-align:center;padding:24px">No listings yet. <a href="post-marketplace-listing.php">Be the first to post one</a>.</p><?php endif; ?>
                <?php foreach ($mpLatest as $m): ?>
                <article class="pl-market-listing-card" data-name="<?= h($m['title']) ?>" data-category="<?= h($m['category_name']) ?>" data-location="<?= h($m['location_text']) ?>" data-date="<?= h($m['posted']) ?>" data-price="<?= (int)$m['price'] ?>">
                    <div class="pl-market-listing-image">
                        <?php if ($m['image']): ?><img src="<?= h($m['image']) ?>" alt="<?= h($m['title']) ?>" loading="lazy"><?php else: ?><img src="images/no-photo.svg" alt="" loading="lazy"><?php endif; ?>
                        <?php if (!empty($m['is_featured'])): ?><span class="pl-market-featured-badge"><i class="bi bi-star-fill"></i> Featured</span><?php endif; ?>
                        <button type="button" class="pl-market-save" data-live="1" data-save-id="<?= (int)$m['id'] ?>" data-saved="<?= !empty($m['saved']) ? '1' : '0' ?>" aria-pressed="<?= !empty($m['saved']) ? 'true' : 'false' ?>" aria-label="Save <?= h($m['title']) ?>"><i class="bi <?= !empty($m['saved']) ? 'bi-heart-fill' : 'bi-heart' ?>"></i></button>
                    </div>
                    <div class="pl-market-listing-body">
                        <span class="pl-market-listing-category"><?= h($m['category_text']) ?></span>
                        <h3><?= h($m['title']) ?></h3>
                        <div class="pl-market-price"><?= h($m['price_text']) ?><?= !empty($m['price_negotiable']) ? ' <small>(negotiable)</small>' : '' ?></div>
                        <div class="pl-market-listing-meta">
                            <span><i class="bi bi-geo-alt"></i> <?= h($m['location_text']) ?></span>
                            <span><i class="bi bi-calendar3"></i> <?= h(date('d M Y', strtotime($m['created_at']))) ?></span>
                        </div>
                        <p class="pl-market-listing-description"><?= h(mb_strimwidth((string)$m['description'], 0, 120, '…')) ?></p>
                        <div class="pl-market-community-label"><i class="bi <?= ($m['visibility_type'] ?? '') === 'global' ? 'bi-globe2' : 'bi-people-fill' ?>"></i> <?= ($m['visibility_type'] ?? '') === 'global' ? 'Global Listing' : 'Community Listing' ?></div>
                        <a href="marketplace-listing-details.php?id=<?= (int)$m['id'] ?>" class="pl-market-view-listing">View Details <i class="bi bi-arrow-up-right"></i></a>
                    </div>
                </article>
                <?php endforeach; ?>

            </div>

            <div class="pl-market-no-results" id="plMarketNoResults" hidden>
                <i class="bi bi-search"></i>
                <h3>No matching listings found</h3>
                <p>Try another keyword, category or location.</p>
                <button type="button" id="plMarketResetSearch"
                        class="pl-market-btn pl-market-btn-primary">
                    View All Listings
                </button>
            </div>

        </div>
    </section>

    <!-- Browse by Location -->
    <section class="pl-market-location-section">
        <div class="pl-market-container pl-market-location-content">
            <span class="pl-market-location-icon">
                <i class="bi bi-geo-alt-fill"></i>
            </span>

            <div>
                <span class="pl-market-kicker">DISCOVER NEAR YOU</span>
                <h2>Find Listings <span>by Location</span></h2>
                <p>
                    Explore listings in your city, area or nearby locality.
                    Discover opportunities closer to home.
                </p>
            </div>

            <div class="pl-market-location-actions">
                <a href="marketplace-search.php" class="pl-market-btn pl-market-btn-primary">
                    Browse Locations <i class="bi bi-arrow-right"></i>
                </a>

                <button type="button" id="plMarketNearMe"
                        class="pl-market-btn pl-market-btn-location">
                    <i class="bi bi-crosshair"></i> View Near Me
                </button>
            </div>
        </div>
    </section>

    <!-- Post a Listing -->
    <section class="pl-market-section">
        <div class="pl-market-container">
            <div class="pl-market-post-card">
                <div class="pl-market-post-icon">
                    <i class="bi bi-megaphone-fill"></i>
                </div>

                <div class="pl-market-post-copy">
                    <span class="pl-market-kicker">YOUR LISTING STARTS HERE</span>
                    <h2>Have Something to <span>Sell or Share?</span></h2>
                    <p>
                        Post a property, vehicle, product or service and help
                        people in your community discover what you offer.
                    </p>
                </div>

                <a href="post-listing.php" class="pl-market-btn pl-market-btn-primary">
                    <i class="bi bi-plus-circle"></i> Post Your Listing
                </a>
            </div>
        </div>
    </section>

    <!-- Quick Access -->
    <section class="pl-market-section pl-market-quick-section">
        <div class="pl-market-container">

            <div class="pl-market-heading">
                <div>
                    <span class="pl-market-kicker">YOUR MARKETPLACE</span>
                    <h2>Quick <span>Access</span></h2>
                    <p>Manage your marketplace activity in one place.</p>
                </div>
            </div>

            <div class="pl-market-quick-grid">
                <a href="my-listings.php" class="pl-market-quick-card">
                    <span class="pl-market-quick-icon"><i class="bi bi-card-list"></i></span>
                    <span><strong>My Listings</strong><small>Manage your posted items</small></span>
                    <i class="bi bi-arrow-up-right"></i>
                </a>

                <a href="saved-listings.php" class="pl-market-quick-card">
                    <span class="pl-market-quick-icon"><i class="bi bi-heart"></i></span>
                    <span><strong>Saved Listings</strong><small>Return to your saved items</small></span>
                    <i class="bi bi-arrow-up-right"></i>
                </a>

                <a href="post-listing.php" class="pl-market-quick-card">
                    <span class="pl-market-quick-icon"><i class="bi bi-plus-circle"></i></span>
                    <span><strong>Create a Listing</strong><small>Share an item or service</small></span>
                    <i class="bi bi-arrow-up-right"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- Community Visibility -->
    <section class="pl-market-community-notice">
        <div class="pl-market-container">
            <i class="bi bi-shield-check"></i>
            <p>
                <strong>Community visibility matters.</strong>
                Listings may be displayed according to the selected community
                and the visibility rules configured for your account.
            </p>
        </div>
    </section>

</main>

 

<?php include 'footer.php'; ?>
 