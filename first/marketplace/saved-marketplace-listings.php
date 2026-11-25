<?php
// Saved Marketplace Listings (live: the member's saved listings — marketplace_saved / marketplace_save)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();
$_REQUEST['per'] = 50; $_REQUEST['page'] = 1;
$smItems = array_map('web_mp_card', web_call('marketplace_saved', ['per' => 50])['items'] ?? []);
$smSavedAt = $smItems ? array_column(rows("SELECT entity_id, created_at FROM favourites WHERE user_id=? AND entity='mp_listings'", [$webUid]), 'created_at', 'entity_id') : [];
include 'header.php'; ?>

 

<main class="pl-saved-market" id="plSavedMarket">

    <!-- Hero -->
    <section class="pl-sm-hero">
        <div class="pl-sm-container pl-sm-hero-inner">
            <div>
                <span class="pl-sm-eyebrow">PEOPLELINK MARKETPLACE</span>
                <h1>Saved Marketplace Listings</h1>
                <p>All your favourite finds in one place. Revisit listings whenever you need them.</p>
            </div>

            <a href="marketplace-listings.php" class="pl-sm-btn pl-sm-btn-primary">
                <i class="fa-solid fa-store"></i> Browse Marketplace
            </a>
        </div>
    </section>

    <div class="pl-sm-container pl-sm-content">

        <!-- Summary -->
        <section class="pl-sm-summary">
            <div class="pl-sm-summary-icon">
                <i class="fa-solid fa-heart"></i>
            </div>
            <div>
                <span>My Saved Listings</span>
                <strong id="plSmSavedCount"><?= count($smItems) ?> Listings</strong>
                <p>Keep track of the items and services you are interested in.</p>
            </div>
            <div class="pl-sm-summary-decoration">
                <i class="fa-regular fa-bookmark"></i>
            </div>
        </section>

        <!-- Filters and Sorting -->
        <section class="pl-sm-toolbar">

            <div class="pl-sm-toolbar-heading">
                <div>
                    <h2>Your Favourites</h2>
                    <p id="plSmResultCount">Showing <?= count($smItems) ?> saved listings</p>
                </div>
            </div>

            <div class="pl-sm-filters">

                <div class="pl-sm-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="plSmSearch"
                           placeholder="Search saved listings..."
                           aria-label="Search saved listings">
                </div>

                <select id="plSmCategory" aria-label="Filter by category">
                    <option value="all">All Categories</option>
                    <option value="Property">Property</option>
                    <option value="Cars">Cars</option>
                    <option value="Bikes">Bikes</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Products">Products</option>
                    <option value="Services">Services</option>
                    <option value="Other">Other</option>
                </select>

                <select id="plSmSort" aria-label="Sort saved listings">
                    <option value="saved-desc">Recently Saved</option>
                    <option value="posted-desc">Recently Posted</option>
                    <option value="price-asc">Price – Low to High</option>
                    <option value="price-desc">Price – High to Low</option>
                </select>

                <button type="button" class="pl-sm-btn pl-sm-btn-outline" id="plSmReset">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </button>

            </div>
        </section>

        <!-- Saved Listings Grid -->
        <section class="pl-sm-grid" id="plSmGrid" aria-label="Saved marketplace listings">

            <!-- Property -->
            <?php foreach ($smItems as $m): $open = empty($m['expired']); ?>
            <article class="pl-sm-card" data-id="<?= (int)$m['id'] ?>" data-category="<?= h($m['category_name']) ?>" data-title="<?= h($m['title']) ?>" data-price="<?= (int)$m['price'] ?>" data-location="<?= h($m['location_text']) ?>" data-condition="<?= h($m['item_condition']) ?>" data-availability="<?= $open ? 'active' : 'closed' ?>" data-posted="<?= h($m['posted']) ?>" data-saved="<?= h(substr((string)($smSavedAt[$m['id']] ?? $m['created_at']), 0, 10)) ?>">
                <div class="pl-sm-image-wrap">
                    <img src="<?= h($m['image'] ?: 'images/no-photo.svg') ?>" alt="<?= h($m['title']) ?>" loading="lazy">
                    <span class="pl-sm-category-tag"><?= h($m['category_name']) ?></span>
                    <span class="pl-sm-availability <?= $open ? 'available' : 'sold' ?>"><i class="fa-solid <?= $open ? 'fa-circle-check' : 'fa-circle-xmark' ?>"></i> <?= $open ? 'Available' : 'No longer available' ?></span>
                    <button type="button" class="pl-sm-remove" data-action="remove" data-live-id="<?= (int)$m['id'] ?>" aria-label="Remove <?= h($m['title']) ?> from saved listings" title="Remove from saved"><i class="fa-solid fa-heart"></i></button>
                </div>
                <div class="pl-sm-card-body">
                    <div class="pl-sm-card-heading"><h3><?= h($m['title']) ?></h3><strong class="pl-sm-price"><?= h($m['price_text']) ?></strong></div>
                    <p class="pl-sm-location"><i class="fa-solid fa-location-dot"></i> <?= h($m['location_text']) ?></p>
                    <div class="pl-sm-details"><?php if ($m['item_condition']): ?><span><i class="fa-solid fa-tag"></i> <?= h($m['item_condition']) ?></span><?php endif; ?><span><i class="fa-regular fa-calendar"></i> Posted <?= h(date('d M Y', strtotime($m['created_at']))) ?></span></div>
                    <div class="pl-sm-card-footer"><a href="marketplace-listing-details.php?id=<?= (int)$m['id'] ?>" class="pl-sm-btn pl-sm-btn-outline">View Details</a><a href="contact-seller.php?id=<?= (int)$m['id'] ?>" class="pl-sm-btn pl-sm-btn-contact"><i class="fa-regular fa-comment-dots"></i> Contact Seller</a></div>
                </div>
            </article>
            <?php endforeach; ?>

        </section>

        <!-- Empty State -->
        <section class="pl-sm-empty" id="plSmEmpty" hidden>
            <div class="pl-sm-empty-icon">
                <i class="fa-regular fa-heart"></i>
            </div>
            <h3 id="plSmEmptyTitle">You have not saved any Marketplace listings yet.</h3>
            <p id="plSmEmptyText">
                Browse the marketplace and save listings you want to revisit later.
            </p>
            <a href="marketplace-listings.php" class="pl-sm-btn pl-sm-btn-primary">
                <i class="fa-solid fa-store"></i> Browse Marketplace
            </a>
        </section>

        <!-- Help -->
        <section class="pl-sm-help">
            <div class="pl-sm-help-icon">
                <i class="fa-solid fa-lightbulb"></i>
            </div>
            <div>
                <h3>Found something you like?</h3>
                <p>Save interesting listings so you can easily find them again.</p>
            </div>
            <a href="marketplace-listings.php">
                Explore Marketplace <i class="fa-solid fa-arrow-right"></i>
            </a>
        </section>

    </div>
</main>

 

<?php include 'footer.php'; ?>
