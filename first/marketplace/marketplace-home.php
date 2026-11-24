<?php include 'header.php'; ?>

 

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
                    <strong id="plMarketResultCount">6</strong> listings
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

                <!-- Listing 1 -->
                <article class="pl-market-listing-card"
                         data-name="2 BHK Family Apartment"
                         data-category="Property"
                         data-location="Rishikesh Uttarakhand"
                         data-date="2026-10-12"
                         data-price="4500000">

                    <div class="pl-market-listing-image">
                        <img src="images/marketplace/property-1.jpg"
                             alt="Family apartment for sale" loading="lazy">

                        <span class="pl-market-featured-badge">
                            <i class="bi bi-star-fill"></i> Featured
                        </span>

                        <button type="button" class="pl-market-save"
                                data-save-id="1" aria-pressed="false"
                                aria-label="Save apartment listing">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="pl-market-listing-body">
                        <span class="pl-market-listing-category">Property</span>
                        <h3>2 BHK Family Apartment</h3>
                        <div class="pl-market-price">₹45,00,000</div>

                        <div class="pl-market-listing-meta">
                            <span><i class="bi bi-geo-alt"></i> Rishikesh, Uttarakhand</span>
                            <span><i class="bi bi-calendar3"></i> 12 Oct 2026</span>
                        </div>

                        <p class="pl-market-listing-description">
                            Spacious family apartment with convenient access to local amenities.
                        </p>

                        <div class="pl-market-community-label">
                            <i class="bi bi-people-fill"></i> Community Listing
                        </div>

                        <a href="marketplace-listing-details.php?id=1"
                           class="pl-market-view-listing">
                            View Details <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                </article>

                <!-- Listing 2 -->
                <article class="pl-market-listing-card"
                         data-name="Well-Maintained Family Car"
                         data-category="Cars"
                         data-location="Dehradun Uttarakhand"
                         data-date="2026-10-11"
                         data-price="425000">

                    <div class="pl-market-listing-image">
                        <img src="images/marketplace/car-1.jpg"
                             alt="Pre-owned family car" loading="lazy">

                        <span class="pl-market-featured-badge">
                            <i class="bi bi-star-fill"></i> Featured
                        </span>

                        <button type="button" class="pl-market-save"
                                data-save-id="2" aria-pressed="false"
                                aria-label="Save car listing">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="pl-market-listing-body">
                        <span class="pl-market-listing-category">Cars</span>
                        <h3>Well-Maintained Family Car</h3>
                        <div class="pl-market-price">₹4,25,000</div>

                        <div class="pl-market-listing-meta">
                            <span><i class="bi bi-geo-alt"></i> Dehradun, Uttarakhand</span>
                            <span><i class="bi bi-calendar3"></i> 11 Oct 2026</span>
                        </div>

                        <p class="pl-market-listing-description">
                            Pre-owned car available for a direct enquiry and inspection.
                        </p>

                        <a href="marketplace-listing-details.php?id=2"
                           class="pl-market-view-listing">
                            View Details <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                </article>

                <!-- Listing 3 -->
                <article class="pl-market-listing-card"
                         data-name="Office Laptop in Excellent Condition"
                         data-category="Electronics"
                         data-location="Haridwar Uttarakhand"
                         data-date="2026-10-10"
                         data-price="28000">

                    <div class="pl-market-listing-image">
                        <img src="images/marketplace/laptop-1.jpg"
                             alt="Laptop for work and study" loading="lazy">

                        <button type="button" class="pl-market-save"
                                data-save-id="3" aria-pressed="false"
                                aria-label="Save laptop listing">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="pl-market-listing-body">
                        <span class="pl-market-listing-category">Electronics</span>
                        <h3>Office Laptop in Excellent Condition</h3>
                        <div class="pl-market-price">₹28,000</div>

                        <div class="pl-market-listing-meta">
                            <span><i class="bi bi-geo-alt"></i> Haridwar, Uttarakhand</span>
                            <span><i class="bi bi-calendar3"></i> 10 Oct 2026</span>
                        </div>

                        <p class="pl-market-listing-description">
                            A laptop suitable for office work, study and everyday use.
                        </p>

                        <div class="pl-market-community-label">
                            <i class="bi bi-people-fill"></i> Community Listing
                        </div>

                        <a href="marketplace-listing-details.php?id=3"
                           class="pl-market-view-listing">
                            View Details <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                </article>

                <!-- Listing 4 -->
                <article class="pl-market-listing-card"
                         data-name="Solid Wood Dining Table"
                         data-category="Furniture"
                         data-location="Rishikesh Uttarakhand"
                         data-date="2026-10-09"
                         data-price="12500">

                    <div class="pl-market-listing-image">
                        <img src="images/marketplace/furniture-1.jpg"
                             alt="Wooden dining table" loading="lazy">

                        <button type="button" class="pl-market-save"
                                data-save-id="4" aria-pressed="false"
                                aria-label="Save furniture listing">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="pl-market-listing-body">
                        <span class="pl-market-listing-category">Furniture</span>
                        <h3>Solid Wood Dining Table</h3>
                        <div class="pl-market-price">₹12,500</div>

                        <div class="pl-market-listing-meta">
                            <span><i class="bi bi-geo-alt"></i> Rishikesh, Uttarakhand</span>
                            <span><i class="bi bi-calendar3"></i> 09 Oct 2026</span>
                        </div>

                        <p class="pl-market-listing-description">
                            A well-kept dining table for your home.
                        </p>

                        <a href="marketplace-listing-details.php?id=4"
                           class="pl-market-view-listing">
                            View Details <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                </article>

                <!-- Listing 5 -->
                <article class="pl-market-listing-card"
                         data-name="Premium City Commuter Bike"
                         data-category="Bikes"
                         data-location="Dehradun Uttarakhand"
                         data-date="2026-10-08"
                         data-price="62000">

                    <div class="pl-market-listing-image">
                        <img src="images/marketplace/bike-1.jpg"
                             alt="Commuter motorcycle" loading="lazy">

                        <span class="pl-market-featured-badge">
                            <i class="bi bi-star-fill"></i> Featured
                        </span>

                        <button type="button" class="pl-market-save"
                                data-save-id="5" aria-pressed="false"
                                aria-label="Save bike listing">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="pl-market-listing-body">
                        <span class="pl-market-listing-category">Bikes</span>
                        <h3>Premium City Commuter Bike</h3>
                        <div class="pl-market-price">₹62,000</div>

                        <div class="pl-market-listing-meta">
                            <span><i class="bi bi-geo-alt"></i> Dehradun, Uttarakhand</span>
                            <span><i class="bi bi-calendar3"></i> 08 Oct 2026</span>
                        </div>

                        <p class="pl-market-listing-description">
                            A practical two-wheeler for everyday commuting.
                        </p>

                        <a href="marketplace-listing-details.php?id=5"
                           class="pl-market-view-listing">
                            View Details <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                </article>

                <!-- Listing 6 -->
                <article class="pl-market-listing-card"
                         data-name="Professional Website Development"
                         data-category="Services"
                         data-location="Available Online"
                         data-date="2026-10-07"
                         data-price="0">

                    <div class="pl-market-listing-image">
                        <img src="images/marketplace/service-1.jpg"
                             alt="Website development service" loading="lazy">

                        <button type="button" class="pl-market-save"
                                data-save-id="6" aria-pressed="false"
                                aria-label="Save service listing">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="pl-market-listing-body">
                        <span class="pl-market-listing-category">Services</span>
                        <h3>Professional Website Development</h3>
                        <div class="pl-market-price">Contact for Price</div>

                        <div class="pl-market-listing-meta">
                            <span><i class="bi bi-geo-alt"></i> Available Online</span>
                            <span><i class="bi bi-calendar3"></i> 07 Oct 2026</span>
                        </div>

                        <p class="pl-market-listing-description">
                            Website design and development for businesses and professionals.
                        </p>

                        <div class="pl-market-community-label">
                            <i class="bi bi-people-fill"></i> Community Listing
                        </div>

                        <a href="marketplace-listing-details.php?id=6"
                           class="pl-market-view-listing">
                            View Details <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                </article>

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
 