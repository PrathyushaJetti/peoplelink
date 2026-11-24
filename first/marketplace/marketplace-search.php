<?php include 'header.php'; ?>
 

<main class="pl-ms-page">

    <!-- Search Hero -->
    <section class="pl-ms-hero">
        <div class="pl-ms-container">
            <div class="pl-ms-hero-content">
                <span class="pl-ms-eyebrow">
                    <i class="bi bi-search"></i> PEOPLELINK MARKETPLACE
                </span>

                <h1>Search <span>Marketplace</span></h1>

                <p>
                    Find products, property, vehicles and services from
                    your community. Use filters to discover relevant listings.
                </p>

                <div class="pl-ms-breadcrumb">
                    <a href="community-dashboard.php">Home</a>
                    <i class="bi bi-chevron-right"></i>
                    <a href="marketplace-home.php">Marketplace</a>
                    <i class="bi bi-chevron-right"></i>
                    <span>Search &amp; Filters</span>
                </div>
            </div>

            <div class="pl-ms-hero-icon">
                <i class="bi bi-sliders"></i>
            </div>
        </div>
    </section>

    <!-- Main Search Area -->
    <section class="pl-ms-main-section">
        <div class="pl-ms-container">

            <div class="pl-ms-layout">

                <!-- Filters -->
                <aside class="pl-ms-sidebar">
                    <form id="plMarketplaceFilterForm"
                          action="marketplace-search-results.php"
                          method="get">

                        <div class="pl-ms-filter-heading">
                            <div class="pl-ms-filter-heading-icon">
                                <i class="bi bi-funnel"></i>
                            </div>

                            <div>
                                <h2>Search Filters</h2>
                                <p>Refine your marketplace search</p>
                            </div>
                        </div>

                        <!-- Listing Name -->
                        <div class="pl-ms-filter-group">
                            <label for="plMsListingName">Listing / Product Name</label>

                            <div class="pl-ms-input-wrap">
                                <i class="bi bi-box-seam"></i>
                                <input type="text" id="plMsListingName"
                                       name="listing_name"
                                       placeholder="e.g. apartment, laptop">
                            </div>
                        </div>

                        <!-- Keyword -->
                        <div class="pl-ms-filter-group">
                            <label for="plMsKeyword">Keyword</label>

                            <div class="pl-ms-input-wrap">
                                <i class="bi bi-search"></i>
                                <input type="search" id="plMsKeyword"
                                       name="keyword"
                                       placeholder="Enter keywords">
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="pl-ms-filter-group">
                            <label for="plMsCategory">Category</label>

                            <select id="plMsCategory" name="category">
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
                        </div>

                        <!-- Location -->
                        <div class="pl-ms-filter-group">
                            <label for="plMsCity">City</label>

                            <div class="pl-ms-input-wrap">
                                <i class="bi bi-geo-alt"></i>
                                <input type="text" id="plMsCity"
                                       name="city"
                                       placeholder="Enter city">
                            </div>
                        </div>

                        <div class="pl-ms-filter-group">
                            <label for="plMsArea">Area / Locality</label>

                            <div class="pl-ms-input-wrap">
                                <i class="bi bi-pin-map"></i>
                                <input type="text" id="plMsArea"
                                       name="area"
                                       placeholder="Enter area or locality">
                            </div>
                        </div>

                        <button type="button" class="pl-ms-location-button"
                                id="plMsUseLocation">
                            <i class="bi bi-crosshair"></i>
                            <span>Use My Location</span>
                        </button>

                        <p class="pl-ms-location-status" id="plMsLocationStatus"
                           aria-live="polite"></p>

                        <input type="hidden" name="latitude" id="plMsLatitude">
                        <input type="hidden" name="longitude" id="plMsLongitude">

                        <!-- Price -->
                        <div class="pl-ms-filter-group">
                            <label>Price Range</label>

                            <div class="pl-ms-price-fields">
                                <div>
                                    <label for="plMsMinPrice">Minimum</label>
                                    <input type="number" id="plMsMinPrice"
                                           name="min_price" min="0"
                                           placeholder="₹ Min">
                                </div>

                                <div>
                                    <label for="plMsMaxPrice">Maximum</label>
                                    <input type="number" id="plMsMaxPrice"
                                           name="max_price" min="0"
                                           placeholder="₹ Max">
                                </div>
                            </div>

                            <small class="pl-ms-hint">
                                Leave blank if you have no price preference.
                            </small>
                        </div>

                        <!-- Condition -->
                        <div class="pl-ms-filter-group">
                            <label for="plMsCondition">Listing Condition</label>

                            <select id="plMsCondition" name="condition">
                                <option value="">All Conditions</option>
                                <option value="New">New</option>
                                <option value="Used">Used</option>
                                <option value="Refurbished">Refurbished</option>
                                <option value="Not Applicable">Not Applicable</option>
                            </select>

                            <small class="pl-ms-hint">
                                Applies where condition is relevant to the listing.
                            </small>
                        </div>

                        <!-- Posted Within -->
                        <div class="pl-ms-filter-group">
                            <label for="plMsPostedWithin">Posted Within</label>

                            <select id="plMsPostedWithin" name="posted_within">
                                <option value="any">Any Time</option>
                                <option value="today">Today</option>
                                <option value="3days">Last 3 Days</option>
                                <option value="7days">Last 7 Days</option>
                                <option value="30days">Last 30 Days</option>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="pl-ms-filter-group">
                            <label for="plMsSort">Sort By</label>

                            <select id="plMsSort" name="sort">
                                <option value="relevant">Most Relevant</option>
                                <option value="recent">Recently Added</option>
                                <option value="price_low">Price – Low to High</option>
                                <option value="price_high">Price – High to Low</option>
                                <option value="nearest">Nearest</option>
                            </select>
                        </div>

                        <!-- Actions -->
                        <div class="pl-ms-filter-actions">
                            <button type="submit" class="pl-ms-apply-button">
                                <i class="bi bi-search"></i> Apply Filters
                            </button>

                            <button type="reset" class="pl-ms-reset-button"
                                    id="plMsResetFilters">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Reset Filters
                            </button>
                        </div>

                    </form>
                </aside>

                <!-- Search Information -->
                <div class="pl-ms-content">

                    <div class="pl-ms-intro-card">
                        <div class="pl-ms-intro-icon">
                            <i class="bi bi-search-heart"></i>
                        </div>

                        <div>
                            <span class="pl-ms-kicker">FIND WHAT YOU NEED</span>
                            <h2>Discover the Right Listing</h2>
                            <p>
                                Search across marketplace categories, narrow down
                                your location and budget, and sort listings to
                                find the options most relevant to you.
                            </p>
                        </div>
                    </div>

                    <!-- Quick Filters -->
                    <div class="pl-ms-quick-section">
                        <div class="pl-ms-section-heading">
                            <div>
                                <h2>Quick Filters</h2>
                                <p>Start your search with one click.</p>
                            </div>
                        </div>

                        <div class="pl-ms-quick-filters">
                            <button type="button" class="pl-ms-quick-chip"
                                    data-category="Property">
                                <i class="bi bi-house-door"></i> Property
                            </button>

                            <button type="button" class="pl-ms-quick-chip"
                                    data-category="Cars">
                                <i class="bi bi-car-front"></i> Cars
                            </button>

                            <button type="button" class="pl-ms-quick-chip"
                                    data-category="Bikes">
                                <i class="bi bi-bicycle"></i> Bikes
                            </button>

                            <button type="button" class="pl-ms-quick-chip"
                                    data-category="Electronics">
                                <i class="bi bi-laptop"></i> Electronics
                            </button>

                            <button type="button" class="pl-ms-quick-chip"
                                    data-posted="today">
                                <i class="bi bi-clock-history"></i> Recently Added
                            </button>

                            <button type="button" class="pl-ms-quick-chip"
                                    id="plMsNearMe">
                                <i class="bi bi-crosshair"></i> Near Me
                            </button>
                        </div>
                    </div>

                    <!-- Search Guide -->
                    <div class="pl-ms-guide-section">
                        <div class="pl-ms-section-heading">
                            <div>
                                <h2>How to Find Listings</h2>
                                <p>Three simple steps to refine your search.</p>
                            </div>
                        </div>

                        <div class="pl-ms-guide-grid">

                            <div class="pl-ms-guide-card">
                                <span class="pl-ms-guide-number">01</span>
                                <div class="pl-ms-guide-icon">
                                    <i class="bi bi-search"></i>
                                </div>
                                <h3>Enter Your Search</h3>
                                <p>
                                    Type a product name or keyword and select
                                    the marketplace category you need.
                                </p>
                            </div>

                            <div class="pl-ms-guide-card">
                                <span class="pl-ms-guide-number">02</span>
                                <div class="pl-ms-guide-icon">
                                    <i class="bi bi-sliders"></i>
                                </div>
                                <h3>Refine Your Results</h3>
                                <p>
                                    Narrow listings by location, price,
                                    condition and posting date.
                                </p>
                            </div>

                            <div class="pl-ms-guide-card">
                                <span class="pl-ms-guide-number">03</span>
                                <div class="pl-ms-guide-icon">
                                    <i class="bi bi-grid"></i>
                                </div>
                                <h3>Explore Listings</h3>
                                <p>
                                    Apply your filters to open matching
                                    listings on the results page.
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- Search Tip -->
                    <div class="pl-ms-tip-card">
                        <span class="pl-ms-tip-icon">
                            <i class="bi bi-lightbulb"></i>
                        </span>

                        <div>
                            <h3>Search Tip</h3>
                            <p>
                                Combine a category with a city and price range
                                to narrow down your search. You can leave
                                optional filters blank.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</main>

 

<?php include 'footer.php'; ?>
