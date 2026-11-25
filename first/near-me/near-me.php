<?php
// Near Me (live: results from nearme_list = the Professional & Business Directory, by GPS distance or city / area)
require_once dirname(__DIR__) . '/_web.php';
include 'header.php';
?>

<main class="near-page">
    <div class="container">

        <!-- Breadcrumb -->
        <nav class="near-breadcrumb">
            <a href="../community/community-home.php">
                <i class="bi bi-house-door"></i> Community
            </a>
            <i class="bi bi-chevron-right"></i>
            <span>Near Me</span>
        </nav>

        <!-- Hero Section -->
        <section class="near-hero">
            <div class="near-hero-content">
                <span class="near-eyebrow">
                    <i class="bi bi-geo-alt-fill"></i>
                    PEOPLELINK LOCAL DISCOVERY
                </span>

                <h1>Discover What's <span>Near You</span></h1>

                <p>
                    Find trusted professionals, local businesses and useful
                    community services around you.
                </p>

                <div class="near-location-actions">
                    <button type="button" class="near-btn near-btn-primary" id="useLocation">
                        <i class="bi bi-crosshair"></i>
                        Use My Location
                    </button>

                    <button type="button" class="near-btn near-btn-light" id="chooseLocation">
                        <i class="bi bi-geo"></i>
                        Choose Location
                    </button>
                </div>

                <div class="near-current-location" id="locationStatus" aria-live="polite">
                    <i class="bi bi-geo-alt"></i>
                    <span>Choose a location to discover nearby listings.</span>
                </div>
            </div>

            <div class="near-hero-visual">
                <div class="near-visual-circle">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>

                <div class="near-floating-card near-float-one">
                    <span class="near-float-icon"><i class="bi bi-shop"></i></span>
                    <span>
                        <strong>Local Businesses</strong>
                        <small>Discover nearby</small>
                    </span>
                </div>

                <div class="near-floating-card near-float-two">
                    <span class="near-float-icon green"><i class="bi bi-people"></i></span>
                    <span>
                        <strong>Community Network</strong>
                        <small>Connect locally</small>
                    </span>
                </div>
            </div>
        </section>

        <!-- Search Section -->
        <section class="near-search-section" id="nearSearch">
            <div class="near-section-heading">
                <span class="near-eyebrow">FIND WHAT YOU NEED</span>
                <h2>Search Nearby</h2>
                <p>Search for a business, professional, service or area.</p>
            </div>

            <form id="nearSearchForm" class="near-search-form">
                <div class="near-search-field">
                    <i class="bi bi-search"></i>
                    <input type="search" id="keyword" placeholder="Business, doctor, lawyer, service..." aria-label="Search business, professional or service">
                </div>

                <div class="near-search-field">
                    <i class="bi bi-grid"></i>
                    <select id="searchCategory" aria-label="Select category">
                        <option value="">All Categories</option>
                        <option>Doctors</option>
                        <option>Hospitals</option>
                        <option>Pharmacies</option>
                        <option>Lawyers</option>
                        <option>Chartered Accountants</option>
                        <option>Restaurants</option>
                        <option>Shops</option>
                        <option>Home Services</option>
                        <option>Real Estate</option>
                        <option>Education</option>
                        <option>Travel</option>
                        <option>Event Services</option>
                        <option>Professional Services</option>
                        <option>Other Businesses</option>
                    </select>
                </div>

                <div class="near-search-field">
                    <i class="bi bi-pin-map"></i>
                    <input type="text" id="areaSearch" placeholder="Area or locality" aria-label="Search by area or locality">
                </div>

                <div class="near-search-field"><i class="bi bi-bullseye"></i><select id="nmRadius" aria-label="Distance"><?php foreach ([2, 5, 10, 25, 50] as $km): ?><option value="<?= $km ?>"<?= $km === 10 ? ' selected' : '' ?>>Within <?= $km ?> km</option><?php endforeach; ?></select></div>
<button type="submit" class="near-btn near-btn-primary near-search-submit">
                    <i class="bi bi-search"></i> Search
                </button>
            </form>
        </section>

        <!-- Browse Categories -->
        <section class="near-category-section">
            <div class="near-section-heading">
                <span class="near-eyebrow">EXPLORE LOCAL SERVICES</span>
                <h2>Browse Categories</h2>
                <p>Choose a category to find relevant listings.</p>
            </div>

            <div class="near-category-grid" id="categoryGrid">

                <button class="near-category active" data-category="">
                    <span class="category-icon cat-blue"><i class="bi bi-grid"></i></span>
                    <span>All Listings</span>
                </button>

                <button class="near-category" data-category="Doctors">
                    <span class="category-icon cat-red"><i class="bi bi-heart-pulse"></i></span>
                    <span>Doctors</span>
                </button>

                <button class="near-category" data-category="Hospitals">
                    <span class="category-icon cat-pink"><i class="bi bi-hospital"></i></span>
                    <span>Hospitals</span>
                </button>

                <button class="near-category" data-category="Pharmacies">
                    <span class="category-icon cat-green"><i class="bi bi-capsule"></i></span>
                    <span>Pharmacies</span>
                </button>

                <button class="near-category" data-category="Lawyers">
                    <span class="category-icon cat-purple"><i class="bi bi-briefcase"></i></span>
                    <span>Lawyers</span>
                </button>

                <button class="near-category" data-category="Chartered Accountants">
                    <span class="category-icon cat-orange"><i class="bi bi-calculator"></i></span>
                    <span>Chartered Accountants</span>
                </button>

                <button class="near-category" data-category="Restaurants">
                    <span class="category-icon cat-yellow"><i class="bi bi-cup-hot"></i></span>
                    <span>Restaurants</span>
                </button>

                <button class="near-category" data-category="Shops">
                    <span class="category-icon cat-teal"><i class="bi bi-bag"></i></span>
                    <span>Shops</span>
                </button>

                <button class="near-category" data-category="Home Services">
                    <span class="category-icon cat-blue"><i class="bi bi-tools"></i></span>
                    <span>Home Services</span>
                </button>

                <button class="near-category" data-category="Real Estate">
                    <span class="category-icon cat-purple"><i class="bi bi-buildings"></i></span>
                    <span>Real Estate</span>
                </button>

                <button class="near-category" data-category="Education">
                    <span class="category-icon cat-green"><i class="bi bi-mortarboard"></i></span>
                    <span>Education</span>
                </button>

                <button class="near-category" data-category="Travel">
                    <span class="category-icon cat-orange"><i class="bi bi-airplane"></i></span>
                    <span>Travel</span>
                </button>

                <button class="near-category" data-category="Event Services">
                    <span class="category-icon cat-pink"><i class="bi bi-calendar-event"></i></span>
                    <span>Event Services</span>
                </button>

                <button class="near-category" data-category="Professional Services">
                    <span class="category-icon cat-teal"><i class="bi bi-person-workspace"></i></span>
                    <span>Professional Services</span>
                </button>

                <button class="near-category" data-category="Other Businesses">
                    <span class="category-icon cat-blue"><i class="bi bi-shop"></i></span>
                    <span>Other Businesses</span>
                </button>

            </div>
        </section>

        <!-- Listings -->
        <section class="near-listings-section" id="nearbyListings">

            <div class="near-listings-heading">
                <div>
                    <span class="near-eyebrow">LOCAL DIRECTORY</span>
                    <h2>Nearby Listings</h2>
                    <p id="resultsSummary">Choose a location to see nearby professionals and businesses.</p>
                </div>

                <div class="near-listing-controls">
                    <label class="near-sort">
                        <span>Sort by</span>
                        <select id="sortListings">
                            <option value="relevant">Most Relevant</option>
                            <option value="nearest">Nearest</option>
                            <option value="recent">Recently Added</option>
                            <option value="name">Name A–Z</option>
                        </select>
                    </label>

                    <div class="near-view-switch">
                        <button type="button" class="active" id="listViewBtn">
                            <i class="bi bi-list-ul"></i> List
                        </button>
                        <button type="button" id="mapViewBtn">
                            <i class="bi bi-map"></i> Map
                        </button>
                    </div>
                </div>
            </div>

            <!-- Live listings: filled by near-me-live.js from the nearme_list API -->
            <div class="near-listing-grid" id="listingGrid">


            </div>

            <!-- Map view -->
            <div class="near-map-panel" id="mapPanel" hidden>
                <div class="near-map-placeholder">
                    <i class="bi bi-map"></i>
                    <h3>Nearby Locations</h3>
                    <p>Choose a listing to open its location in your map application.</p>
                    <div id="mapListingLinks" class="map-listing-links"></div>
                </div>
            </div>

            <!-- No Results -->
            <div class="near-empty-state" id="noResults" hidden>
                <div class="empty-state-icon"><i class="bi bi-search"></i></div>
                <h3>No nearby listings found in this area.</h3>
                <p>Try another keyword, choose a different category or change your location.</p>
                <button type="button" class="near-btn near-btn-primary" id="resetSearch">
                    <i class="bi bi-arrow-counterclockwise"></i> Clear Filters
                </button>
            </div>

        </section>

        <!-- Change Location -->
        <section class="near-change-location" id="changeLocationSection">
            <div class="change-location-icon">
                <i class="bi bi-pin-map"></i>
            </div>

            <div class="change-location-copy">
                <h2>Looking in another area?</h2>
                <p>Choose a city, locality or PIN code to explore another location.</p>
            </div>

            <button type="button" class="near-btn near-btn-primary" id="changeLocationBtn">
                <i class="bi bi-geo-alt"></i> Change Location
            </button>
        </section>

        <!-- Location Modal -->
        <div class="near-modal" id="locationModal" hidden>
            <div class="near-modal-backdrop" data-close-modal></div>

            <div class="near-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="locationModalTitle">
                <button type="button" class="near-modal-close" data-close-modal aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>

                <div class="near-modal-icon"><i class="bi bi-geo-alt"></i></div>
                <h2 id="locationModalTitle">Choose Your Location</h2>
                <p>Enter a city, area, locality or PIN code.</p>

                <form id="locationForm">
                    <label for="manualLocation">Your preferred location</label>
                    <input type="text" id="manualLocation" placeholder="e.g. Rajpur Road, Dehradun" required>
                    <button type="submit" class="near-btn near-btn-primary">
                        <i class="bi bi-check2-circle"></i> Apply Location
                    </button>
                </form>
            </div>
        </div>

    </div>
</main>

<script>window.NM=<?= json_encode(['categories' => array_values(array_map(fn($c) => $c['name'], array_filter(pl_categories('directory'), fn($c) => !$c['parent_id']))), 'city' => (string)($webUser['city'] ?? ''), 'radius' => 10], JSON_HEX_TAG | JSON_HEX_AMP) ?>;</script>
<script src="near-me-live.js?v=2"></script>
<?php
 include 'footer.php';
?>

 
</body>
</html>