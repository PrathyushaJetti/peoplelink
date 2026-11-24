<?php include 'header.php'; ?>
 

<div class="pl-marketplace-page">

    <!-- HERO -->
    <section class="pl-marketplace-hero">
        <div class="pl-marketplace-container">
            <div class="pl-marketplace-hero-grid">

                <div class="pl-marketplace-hero-content">
                    <span class="pl-marketplace-eyebrow">
                        <i class="bi bi-shop-window"></i>
                        PEOPLELINK MARKETPLACE
                    </span>

                    <h1>
                        Property &amp;
                        <span>Marketplace</span>
                    </h1>

                    <p class="pl-marketplace-hero-text">
                        Buy, Sell &amp; Discover Within the PeopleLink Network
                    </p>

                    <p class="pl-marketplace-hero-desc">
                        Explore approved property listings, vehicles, products and
                        other marketplace items shared by registered users and businesses.
                    </p>

                    <div class="pl-marketplace-hero-actions">
                        <a href="#pl-marketplace-listings" class="pl-marketplace-btn pl-marketplace-btn-primary">
                            <i class="bi bi-grid-3x3-gap"></i>
                            Explore Listings
                        </a>

                        <a href="#pl-post-listing" class="pl-marketplace-btn pl-marketplace-btn-outline">
                            <i class="bi bi-plus-circle"></i>
                            Post a Listing
                        </a>
                    </div>

                    <div class="pl-marketplace-hero-note">
                        <i class="bi bi-shield-check"></i>
                        Community-Specific or Global visibility, subject to admin approval.
                    </div>
                </div>

                <div class="pl-marketplace-hero-visual">
                    <img
                        src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1100&q=85"
                        alt="Property Marketplace">

                    <div class="pl-marketplace-floating-card pl-marketplace-floating-top">
                        <i class="bi bi-patch-check-fill"></i>
                        <div>
                            <strong>Approved Listings</strong>
                            <small>PeopleLink Network</small>
                        </div>
                    </div>

                    <div class="pl-marketplace-floating-card pl-marketplace-floating-bottom">
                        <div class="pl-marketplace-mini-icons">
                            <span><i class="bi bi-house-door"></i></span>
                            <span><i class="bi bi-car-front"></i></span>
                            <span><i class="bi bi-bag"></i></span>
                        </div>
                        <div>
                            <strong>3 Marketplace Areas</strong>
                            <small>Property • Vehicle • Products</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- CATEGORIES -->
    <section class="pl-marketplace-section pl-marketplace-categories">
        <div class="pl-marketplace-container">

            <div class="pl-marketplace-heading">
                <span>DISCOVER</span>
                <h2>Browse by Category</h2>
                <p>Find relevant listings from across the PeopleLink network.</p>
            </div>

            <div class="pl-marketplace-category-grid">

                <button class="pl-marketplace-category active" data-category="all">
                    <i class="bi bi-grid"></i>
                    <strong>All Listings</strong>
                    <small>Everything</small>
                </button>

                <button class="pl-marketplace-category" data-category="property">
                    <i class="bi bi-house-door"></i>
                    <strong>Property</strong>
                    <small>Buy &amp; Sell</small>
                </button>

                <button class="pl-marketplace-category" data-category="vehicle">
                    <i class="bi bi-car-front"></i>
                    <strong>Vehicles</strong>
                    <small>Cars &amp; More</small>
                </button>

                <button class="pl-marketplace-category" data-category="product">
                    <i class="bi bi-bag"></i>
                    <strong>Products</strong>
                    <small>Items &amp; Goods</small>
                </button>

                <button class="pl-marketplace-category" data-category="community">
                    <i class="bi bi-people"></i>
                    <strong>Community</strong>
                    <small>Network Only</small>
                </button>

                <button class="pl-marketplace-category" data-category="global">
                    <i class="bi bi-globe2"></i>
                    <strong>Global</strong>
                    <small>Open Listings</small>
                </button>

            </div>
        </div>
    </section>


    <!-- SEARCH -->
    <section class="pl-marketplace-section pl-marketplace-search-section">
        <div class="pl-marketplace-container">

            <div class="pl-marketplace-search-box">

                <div class="pl-marketplace-search-title">
                    <div class="pl-marketplace-section-icon">
                        <i class="bi bi-search"></i>
                    </div>

                    <div>
                        <h2>Search Marketplace</h2>
                        <p>Search property, vehicles, products and other listings.</p>
                    </div>
                </div>

                <form id="plMarketplaceSearch">

                    <div class="pl-marketplace-search-field pl-marketplace-search-main">
                        <i class="bi bi-search"></i>
                        <input
                            type="text"
                            id="plMarketplaceKeyword"
                            placeholder="Search listings..."
                        >
                    </div>

                    <div class="pl-marketplace-search-field">
                        <i class="bi bi-geo-alt"></i>
                        <input
                            type="text"
                            id="plMarketplaceLocation"
                            placeholder="Location"
                        >
                    </div>

                    <select id="plMarketplaceType" class="pl-marketplace-search-select">
                        <option value="all">All Categories</option>
                        <option value="property">Property</option>
                        <option value="vehicle">Vehicle</option>
                        <option value="product">Product</option>
                    </select>

                    <select id="plMarketplaceVisibility" class="pl-marketplace-search-select">
                        <option value="all">All Visibility</option>
                        <option value="community">Community</option>
                        <option value="global">Global</option>
                    </select>

                    <button type="submit" class="pl-marketplace-search-btn">
                        <i class="bi bi-search"></i>
                        Search
                    </button>

                    <button type="button" id="plMarketplaceReset" class="pl-marketplace-reset-btn">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset
                    </button>

                </form>
            </div>

        </div>
    </section>


    <!-- FEATURED LISTINGS -->
    <section class="pl-marketplace-section" id="pl-marketplace-listings">
        <div class="pl-marketplace-container">

            <div class="pl-marketplace-heading pl-marketplace-heading-row">
                <div>
                    <span>MARKETPLACE</span>
                    <h2>Featured Listings</h2>
                    <p>Discover selected listings shared within the network.</p>
                </div>

                <div class="pl-marketplace-result-count">
                    <i class="bi bi-grid-3x3-gap"></i>
                    <strong id="plMarketplaceCount">6</strong>
                    <span>Listings</span>
                </div>
            </div>

            <div class="pl-marketplace-listing-grid" id="plMarketplaceGrid">

                <!-- PROPERTY -->
                <article
                    class="pl-marketplace-listing"
                    data-category="property"
                    data-location="rishikesh"
                    data-visibility="community"
                    data-title="2 BHK Premium Apartment"
                >
                    <div class="pl-marketplace-listing-image">
                        <img
                            src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=900&q=85"
                            alt="2 BHK Apartment"
                        >

                        <span class="pl-marketplace-listing-badge">
                            <i class="bi bi-house-door"></i> Property
                        </span>

                        <button class="pl-marketplace-save" type="button" title="Save Listing">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="pl-marketplace-listing-body">
                        <div class="pl-marketplace-listing-top">
                            <span class="pl-marketplace-visibility community">
                                <i class="bi bi-people"></i> Community
                            </span>
                            <span class="pl-marketplace-approved">
                                <i class="bi bi-patch-check-fill"></i> Approved
                            </span>
                        </div>

                        <h3>2 BHK Premium Apartment</h3>

                        <div class="pl-marketplace-price">₹48.00 Lakh</div>

                        <div class="pl-marketplace-location">
                            <i class="bi bi-geo-alt"></i>
                            Rishikesh, Uttarakhand
                        </div>

                        <div class="pl-marketplace-listing-footer">
                            <span><i class="bi bi-person"></i> Registered Member</span>

                            <button
                                type="button"
                                class="pl-marketplace-view"
                                data-title="2 BHK Premium Apartment"
                            >
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </article>


                <!-- PROPERTY -->
                <article
                    class="pl-marketplace-listing"
                    data-category="property"
                    data-location="dehradun"
                    data-visibility="global"
                    data-title="Residential Plot"
                >
                    <div class="pl-marketplace-listing-image">
                        <img
                            src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=900&q=85"
                            alt="Residential Plot"
                        >

                        <span class="pl-marketplace-listing-badge">
                            <i class="bi bi-house"></i> Property
                        </span>

                        <button class="pl-marketplace-save" type="button">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="pl-marketplace-listing-body">
                        <div class="pl-marketplace-listing-top">
                            <span class="pl-marketplace-visibility global">
                                <i class="bi bi-globe2"></i> Global
                            </span>
                            <span class="pl-marketplace-approved">
                                <i class="bi bi-patch-check-fill"></i> Approved
                            </span>
                        </div>

                        <h3>Residential Plot</h3>

                        <div class="pl-marketplace-price">₹32.50 Lakh</div>

                        <div class="pl-marketplace-location">
                            <i class="bi bi-geo-alt"></i>
                            Dehradun, Uttarakhand
                        </div>

                        <div class="pl-marketplace-listing-footer">
                            <span><i class="bi bi-building"></i> Property Seller</span>

                            <button
                                type="button"
                                class="pl-marketplace-view"
                                data-title="Residential Plot"
                            >
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </article>


                <!-- VEHICLE -->
                <article
                    class="pl-marketplace-listing"
                    data-category="vehicle"
                    data-location="delhi"
                    data-visibility="global"
                    data-title="Premium SUV"
                >
                    <div class="pl-marketplace-listing-image">
                        <img
                            src="https://images.unsplash.com/photo-1553440569-bcc63803a83d?auto=format&fit=crop&w=900&q=85"
                            alt="Premium SUV"
                        >

                        <span class="pl-marketplace-listing-badge vehicle">
                            <i class="bi bi-car-front"></i> Vehicle
                        </span>

                        <button class="pl-marketplace-save" type="button">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="pl-marketplace-listing-body">
                        <div class="pl-marketplace-listing-top">
                            <span class="pl-marketplace-visibility global">
                                <i class="bi bi-globe2"></i> Global
                            </span>
                            <span class="pl-marketplace-approved">
                                <i class="bi bi-patch-check-fill"></i> Approved
                            </span>
                        </div>

                        <h3>Premium SUV</h3>

                        <div class="pl-marketplace-price">₹12.75 Lakh</div>

                        <div class="pl-marketplace-location">
                            <i class="bi bi-geo-alt"></i>
                            New Delhi
                        </div>

                        <div class="pl-marketplace-listing-footer">
                            <span><i class="bi bi-person"></i> Verified Seller</span>

                            <button
                                type="button"
                                class="pl-marketplace-view"
                                data-title="Premium SUV"
                            >
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </article>


                <!-- VEHICLE -->
                <article
                    class="pl-marketplace-listing"
                    data-category="vehicle"
                    data-location="haridwar"
                    data-visibility="community"
                    data-title="Used Family Car"
                >
                    <div class="pl-marketplace-listing-image">
                        <img
                            src="https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=900&q=85"
                            alt="Used Family Car"
                        >

                        <span class="pl-marketplace-listing-badge vehicle">
                            <i class="bi bi-car-front"></i> Vehicle
                        </span>

                        <button class="pl-marketplace-save" type="button">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="pl-marketplace-listing-body">
                        <div class="pl-marketplace-listing-top">
                            <span class="pl-marketplace-visibility community">
                                <i class="bi bi-people"></i> Community
                            </span>
                            <span class="pl-marketplace-approved">
                                <i class="bi bi-patch-check-fill"></i> Approved
                            </span>
                        </div>

                        <h3>Used Family Car</h3>

                        <div class="pl-marketplace-price">₹6.80 Lakh</div>

                        <div class="pl-marketplace-location">
                            <i class="bi bi-geo-alt"></i>
                            Haridwar, Uttarakhand
                        </div>

                        <div class="pl-marketplace-listing-footer">
                            <span><i class="bi bi-person"></i> Community Member</span>

                            <button
                                type="button"
                                class="pl-marketplace-view"
                                data-title="Used Family Car"
                            >
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </article>


                <!-- PRODUCT -->
                <article
                    class="pl-marketplace-listing"
                    data-category="product"
                    data-location="meerut"
                    data-visibility="community"
                    data-title="Office Furniture Set"
                >
                    <div class="pl-marketplace-listing-image">
                        <img
                            src="https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?auto=format&fit=crop&w=900&q=85"
                            alt="Office Furniture"
                        >

                        <span class="pl-marketplace-listing-badge product">
                            <i class="bi bi-bag"></i> Product
                        </span>

                        <button class="pl-marketplace-save" type="button">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="pl-marketplace-listing-body">
                        <div class="pl-marketplace-listing-top">
                            <span class="pl-marketplace-visibility community">
                                <i class="bi bi-people"></i> Community
                            </span>
                            <span class="pl-marketplace-approved">
                                <i class="bi bi-patch-check-fill"></i> Approved
                            </span>
                        </div>

                        <h3>Office Furniture Set</h3>

                        <div class="pl-marketplace-price">₹38,000</div>

                        <div class="pl-marketplace-location">
                            <i class="bi bi-geo-alt"></i>
                            Meerut, Uttar Pradesh
                        </div>

                        <div class="pl-marketplace-listing-footer">
                            <span><i class="bi bi-shop"></i> Business Member</span>

                            <button
                                type="button"
                                class="pl-marketplace-view"
                                data-title="Office Furniture Set"
                            >
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </article>


                <!-- PRODUCT -->
                <article
                    class="pl-marketplace-listing"
                    data-category="product"
                    data-location="rishikesh"
                    data-visibility="global"
                    data-title="Handcrafted Home Decor"
                >
                    <div class="pl-marketplace-listing-image">
                        <img
                            src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=900&q=85"
                            alt="Home Decor"
                        >

                        <span class="pl-marketplace-listing-badge product">
                            <i class="bi bi-bag"></i> Product
                        </span>

                        <button class="pl-marketplace-save" type="button">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                    <div class="pl-marketplace-listing-body">
                        <div class="pl-marketplace-listing-top">
                            <span class="pl-marketplace-visibility global">
                                <i class="bi bi-globe2"></i> Global
                            </span>
                            <span class="pl-marketplace-approved">
                                <i class="bi bi-patch-check-fill"></i> Approved
                            </span>
                        </div>

                        <h3>Handcrafted Home Decor</h3>

                        <div class="pl-marketplace-price">₹4,500</div>

                        <div class="pl-marketplace-location">
                            <i class="bi bi-geo-alt"></i>
                            Rishikesh, Uttarakhand
                        </div>

                        <div class="pl-marketplace-listing-footer">
                            <span><i class="bi bi-shop"></i> Business Member</span>

                            <button
                                type="button"
                                class="pl-marketplace-view"
                                data-title="Handcrafted Home Decor"
                            >
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </article>

            </div>

            <div id="plMarketplaceNoResults" class="pl-marketplace-no-results">
                <i class="bi bi-search"></i>
                <h3>No listings found</h3>
                <p>Try changing your search or filter options.</p>
                <button type="button" id="plMarketplaceClearResults">
                    Clear Filters
                </button>
            </div>

        </div>
    </section>


    <!-- MARKETPLACE TYPES -->
    <section class="pl-marketplace-section pl-marketplace-types">
        <div class="pl-marketplace-container">

            <div class="pl-marketplace-heading">
                <span>EXPLORE</span>
                <h2>Marketplace Areas</h2>
                <p>Explore different types of listings available through PeopleLink.</p>
            </div>

            <div class="pl-marketplace-type-grid">

                <div class="pl-marketplace-type-card">
                    <div class="pl-marketplace-type-icon">
                        <i class="bi bi-house-heart"></i>
                    </div>
                    <div>
                        <h3>Property Listings</h3>
                        <p>Discover property opportunities shared by registered users and businesses.</p>
                        <a href="#pl-marketplace-listings" data-filter-link="property">
                            Explore Property
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="pl-marketplace-type-card">
                    <div class="pl-marketplace-type-icon vehicle">
                        <i class="bi bi-car-front"></i>
                    </div>
                    <div>
                        <h3>Vehicle Marketplace</h3>
                        <p>Explore vehicles available for sale within the PeopleLink network.</p>
                        <a href="#pl-marketplace-listings" data-filter-link="vehicle">
                            Explore Vehicles
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="pl-marketplace-type-card">
                    <div class="pl-marketplace-type-icon product">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <div>
                        <h3>Product Marketplace</h3>
                        <p>Discover products and items offered by community members and businesses.</p>
                        <a href="#pl-marketplace-listings" data-filter-link="product">
                            Explore Products
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- COMMUNITY / GLOBAL -->
    <section class="pl-marketplace-section pl-marketplace-visibility-section">
        <div class="pl-marketplace-container">

            <div class="pl-marketplace-visibility-grid">

                <div class="pl-marketplace-visibility-card community-card">
                    <div class="pl-marketplace-visibility-icon">
                        <i class="bi bi-people"></i>
                    </div>

                    <div>
                        <span>COMMUNITY-SPECIFIC</span>
                        <h2>Community-Specific Marketplace</h2>
                        <p>
                            Listings can be shared specifically with selected
                            communities and their members.
                        </p>

                        <ul>
                            <li><i class="bi bi-check-circle-fill"></i> Community-focused visibility</li>
                            <li><i class="bi bi-check-circle-fill"></i> Registered members</li>
                            <li><i class="bi bi-check-circle-fill"></i> Admin approval</li>
                        </ul>

                        <button type="button" class="pl-marketplace-small-btn" data-visibility-link="community">
                            View Community Listings
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>


                <div class="pl-marketplace-visibility-card global-card">
                    <div class="pl-marketplace-visibility-icon">
                        <i class="bi bi-globe2"></i>
                    </div>

                    <div>
                        <span>GLOBAL VISIBILITY</span>
                        <h2>Global Marketplace</h2>
                        <p>
                            Listings can also be made available beyond a specific
                            community after admin approval.
                        </p>

                        <ul>
                            <li><i class="bi bi-check-circle-fill"></i> Wider audience</li>
                            <li><i class="bi bi-check-circle-fill"></i> Property, vehicles &amp; products</li>
                            <li><i class="bi bi-check-circle-fill"></i> Admin approval</li>
                        </ul>

                        <button type="button" class="pl-marketplace-small-btn" data-visibility-link="global">
                            View Global Listings
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- MARKETPLACE TOOLS -->
    <section class="pl-marketplace-section pl-marketplace-tools">
        <div class="pl-marketplace-container">

            <div class="pl-marketplace-heading">
                <span>PEOPLELINK FEATURES</span>
                <h2>Simple &amp; Secure Marketplace Tools</h2>
                <p>Useful tools to make marketplace interactions easier.</p>
            </div>

            <div class="pl-marketplace-tools-grid">

                <div class="pl-marketplace-tool">
                    <span><i class="bi bi-chat-dots"></i></span>
                    <div>
                        <h3>Contact Seller / Send Enquiry</h3>
                        <p>Contact sellers directly and send an enquiry about a listing.</p>
                        <button type="button" data-action="enquiry">
                            Send Enquiry <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="pl-marketplace-tool">
                    <span><i class="bi bi-heart"></i></span>
                    <div>
                        <h3>Save Listings</h3>
                        <p>Save interesting listings and access them again later.</p>
                        <button type="button" data-action="saved">
                            View Saved Listings <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="pl-marketplace-tool">
                    <span><i class="bi bi-plus-circle"></i></span>
                    <div>
                        <h3>Post a Property / Product</h3>
                        <p>Registered users and businesses can submit new marketplace listings.</p>
                        <button type="button" data-action="post">
                            Post a Listing <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="pl-marketplace-tool">
                    <span><i class="bi bi-shield-check"></i></span>
                    <div>
                        <h3>Listing Approval</h3>
                        <p>Listings are reviewed and approved before becoming available.</p>
                        <button type="button" data-action="approval">
                            Learn About Approval <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="pl-marketplace-tool">
                    <span><i class="bi bi-flag"></i></span>
                    <div>
                        <h3>Report a Listing</h3>
                        <p>Report a listing if you notice incorrect or inappropriate information.</p>
                        <button type="button" data-action="report">
                            Report Listing <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="pl-marketplace-tool">
                    <span><i class="bi bi-layers"></i></span>
                    <div>
                        <h3>Similar Listings</h3>
                        <p>Discover related listings based on category and location.</p>
                        <button type="button" data-action="similar">
                            Find Similar <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- POST LISTING -->
    <section class="pl-marketplace-section pl-marketplace-post" id="pl-post-listing">
        <div class="pl-marketplace-container">

            <div class="pl-marketplace-post-box">

                <div class="pl-marketplace-post-icon">
                    <i class="bi bi-megaphone"></i>
                </div>

                <div class="pl-marketplace-post-content">
                    <span>FOR MEMBERS &amp; BUSINESSES</span>
                    <h2>Post a Property / Product</h2>
                    <p>
                        Share your property, vehicle or product with the PeopleLink network.
                        Choose Community-Specific or Global visibility.
                    </p>
                </div>

                <button type="button" class="pl-marketplace-btn pl-marketplace-btn-primary" data-action="post">
                    <i class="bi bi-plus-circle"></i>
                    Post a Listing
                </button>

            </div>
        </div>
    </section>


    <!-- FINAL CTA -->
    <section class="pl-marketplace-final-cta">
        <div class="pl-marketplace-container">

            <div class="pl-marketplace-final-inner">
                <div>
                    <span><i class="bi bi-stars"></i> PEOPLELINK NETWORK</span>
                    <h2>Discover Opportunities Within Your Network</h2>
                    <p>
                        Explore listings, connect with sellers and share opportunities
                        across the PeopleLink community.
                    </p>
                </div>

                <div class="pl-marketplace-final-actions">
                    <a href="#pl-marketplace-listings" class="pl-marketplace-final-btn primary">
                        <i class="bi bi-grid"></i>
                        Explore Marketplace
                    </a>

                    <a href="#pl-post-listing" class="pl-marketplace-final-btn">
                        <i class="bi bi-plus-circle"></i>
                        Post Listing
                    </a>

                    <button type="button" class="pl-marketplace-final-btn" data-action="saved">
                        <i class="bi bi-heart"></i>
                        Saved Listings
                    </button>
                </div>
            </div>

        </div>
    </section>


    <!-- DETAILS MODAL -->
    <div class="pl-marketplace-modal" id="plMarketplaceModal">
        <div class="pl-marketplace-modal-overlay"></div>

        <div class="pl-marketplace-modal-box">
            <button type="button" class="pl-marketplace-modal-close" id="plMarketplaceModalClose">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="pl-marketplace-modal-icon">
                <i class="bi bi-shop"></i>
            </div>

            <span>MARKETPLACE LISTING</span>
            <h2 id="plMarketplaceModalTitle">Listing Details</h2>

            <p>
                This listing preview is currently available as a frontend demonstration.
                Connect this section with your PeopleLink listing details page to show
                complete property, vehicle or product information.
            </p>

            <div class="pl-marketplace-modal-info">
                <div>
                    <i class="bi bi-patch-check-fill"></i>
                    <strong>Approved Listing</strong>
                </div>

                <div>
                    <i class="bi bi-person-check"></i>
                    <strong>Registered Seller</strong>
                </div>

                <div>
                    <i class="bi bi-chat-dots"></i>
                    <strong>Enquiry Available</strong>
                </div>
            </div>

            <button type="button" class="pl-marketplace-btn pl-marketplace-btn-primary" data-action="enquiry">
                <i class="bi bi-chat-dots"></i>
                Contact Seller
            </button>
        </div>
    </div>


    <!-- TOAST -->
    <div class="pl-marketplace-toast" id="plMarketplaceToast">
        <i class="bi bi-check-circle-fill"></i>
        <span id="plMarketplaceToastText">Action completed.</span>
    </div>

</div>

 

<?php include 'footer.php'; ?>