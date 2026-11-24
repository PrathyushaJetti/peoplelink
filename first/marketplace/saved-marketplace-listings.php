<?php include 'header.php'; ?>

 

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
                <strong id="plSmSavedCount">6 Listings</strong>
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
                    <p id="plSmResultCount">Showing 6 saved listings</p>
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
            <article class="pl-sm-card"
                     data-id="201"
                     data-category="Property"
                     data-title="Premium 2 BHK Apartment"
                     data-price="4500000"
                     data-location="Rishikesh, Uttarakhand"
                     data-condition="Ready to Move"
                     data-availability="active"
                     data-posted="2026-10-10"
                     data-saved="2026-10-13">

                <div class="pl-sm-image-wrap">
                    <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=85"
                         alt="Premium apartment interior" loading="lazy">

                    <span class="pl-sm-category-tag">Property</span>
                    <span class="pl-sm-availability available">
                        <i class="fa-solid fa-circle-check"></i> Available
                    </span>

                    <button type="button" class="pl-sm-remove" data-action="remove"
                            aria-label="Remove Premium 2 BHK Apartment from saved listings"
                            title="Remove from saved">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </div>

                <div class="pl-sm-card-body">
                    <div class="pl-sm-card-heading">
                        <h3>Premium 2 BHK Apartment</h3>
                        <strong class="pl-sm-price">₹45,00,000</strong>
                    </div>

                    <p class="pl-sm-location">
                        <i class="fa-solid fa-location-dot"></i> Rishikesh, Uttarakhand
                    </p>

                    <div class="pl-sm-details">
                        <span><i class="fa-solid fa-house"></i> Ready to Move</span>
                        <span><i class="fa-regular fa-calendar"></i> Posted 10 Oct 2026</span>
                    </div>

                    <div class="pl-sm-card-footer">
                        <a href="marketplace-listing-details.php?id=201"
                           class="pl-sm-btn pl-sm-btn-outline">
                            View Details
                        </a>
                        <a href="marketplace-enquiry.php?id=201"
                           class="pl-sm-btn pl-sm-btn-contact">
                            <i class="fa-regular fa-comment-dots"></i> Contact Seller
                        </a>
                    </div>
                </div>
            </article>

            <!-- Car -->
            <article class="pl-sm-card"
                     data-id="202"
                     data-category="Cars"
                     data-title="Hyundai Creta SX Diesel"
                     data-price="1250000"
                     data-location="Dehradun, Uttarakhand"
                     data-condition="Used"
                     data-availability="active"
                     data-posted="2026-10-11"
                     data-saved="2026-10-12">

                <div class="pl-sm-image-wrap">
                    <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=85"
                         alt="Car for sale" loading="lazy">

                    <span class="pl-sm-category-tag">Cars</span>
                    <span class="pl-sm-availability available">
                        <i class="fa-solid fa-circle-check"></i> Available
                    </span>

                    <button type="button" class="pl-sm-remove" data-action="remove"
                            aria-label="Remove Hyundai Creta SX Diesel from saved listings"
                            title="Remove from saved">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </div>

                <div class="pl-sm-card-body">
                    <div class="pl-sm-card-heading">
                        <h3>Hyundai Creta SX Diesel</h3>
                        <strong class="pl-sm-price">₹12,50,000</strong>
                    </div>

                    <p class="pl-sm-location">
                        <i class="fa-solid fa-location-dot"></i> Dehradun, Uttarakhand
                    </p>

                    <div class="pl-sm-details">
                        <span><i class="fa-solid fa-car"></i> Used</span>
                        <span><i class="fa-regular fa-calendar"></i> Posted 11 Oct 2026</span>
                    </div>

                    <div class="pl-sm-card-footer">
                        <a href="marketplace-listing-details.php?id=202"
                           class="pl-sm-btn pl-sm-btn-outline">View Details</a>
                        <a href="marketplace-enquiry.php?id=202"
                           class="pl-sm-btn pl-sm-btn-contact">
                            <i class="fa-regular fa-comment-dots"></i> Contact Seller
                        </a>
                    </div>
                </div>
            </article>

            <!-- Electronics -->
            <article class="pl-sm-card"
                     data-id="203"
                     data-category="Electronics"
                     data-title="Apple MacBook Air M2"
                     data-price="65000"
                     data-location="Haridwar, Uttarakhand"
                     data-condition="Like New"
                     data-availability="active"
                     data-posted="2026-10-09"
                     data-saved="2026-10-11">

                <div class="pl-sm-image-wrap">
                    <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=85"
                         alt="Apple MacBook laptop" loading="lazy">

                    <span class="pl-sm-category-tag">Electronics</span>
                    <span class="pl-sm-availability available">
                        <i class="fa-solid fa-circle-check"></i> Available
                    </span>

                    <button type="button" class="pl-sm-remove" data-action="remove"
                            aria-label="Remove Apple MacBook Air M2 from saved listings"
                            title="Remove from saved">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </div>

                <div class="pl-sm-card-body">
                    <div class="pl-sm-card-heading">
                        <h3>Apple MacBook Air M2</h3>
                        <strong class="pl-sm-price">₹65,000</strong>
                    </div>

                    <p class="pl-sm-location">
                        <i class="fa-solid fa-location-dot"></i> Haridwar, Uttarakhand
                    </p>

                    <div class="pl-sm-details">
                        <span><i class="fa-solid fa-laptop"></i> Like New</span>
                        <span><i class="fa-regular fa-calendar"></i> Posted 9 Oct 2026</span>
                    </div>

                    <div class="pl-sm-card-footer">
                        <a href="marketplace-listing-details.php?id=203"
                           class="pl-sm-btn pl-sm-btn-outline">View Details</a>
                        <a href="marketplace-enquiry.php?id=203"
                           class="pl-sm-btn pl-sm-btn-contact">
                            <i class="fa-regular fa-comment-dots"></i> Contact Seller
                        </a>
                    </div>
                </div>
            </article>

            <!-- Furniture: Sold -->
            <article class="pl-sm-card"
                     data-id="204"
                     data-category="Furniture"
                     data-title="Solid Wood Dining Table"
                     data-price="18000"
                     data-location="Dehradun, Uttarakhand"
                     data-condition="Good Condition"
                     data-availability="sold"
                     data-posted="2026-10-06"
                     data-saved="2026-10-10">

                <div class="pl-sm-image-wrap">
                    <img src="https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=800&q=85"
                         alt="Wooden dining table" loading="lazy">

                    <span class="pl-sm-category-tag">Furniture</span>
                    <span class="pl-sm-availability unavailable">
                        <i class="fa-solid fa-circle-xmark"></i> Sold / Closed
                    </span>

                    <button type="button" class="pl-sm-remove" data-action="remove"
                            aria-label="Remove Solid Wood Dining Table from saved listings"
                            title="Remove from saved">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </div>

                <div class="pl-sm-card-body">
                    <div class="pl-sm-card-heading">
                        <h3>Solid Wood Dining Table</h3>
                        <strong class="pl-sm-price">₹18,000</strong>
                    </div>

                    <p class="pl-sm-location">
                        <i class="fa-solid fa-location-dot"></i> Dehradun, Uttarakhand
                    </p>

                    <div class="pl-sm-details">
                        <span><i class="fa-solid fa-chair"></i> Good Condition</span>
                        <span><i class="fa-regular fa-calendar"></i> Posted 6 Oct 2026</span>
                    </div>

                    <div class="pl-sm-card-footer">
                        <a href="marketplace-listing-details.php?id=204"
                           class="pl-sm-btn pl-sm-btn-outline">View Details</a>
                        <a href="marketplace-enquiry.php?id=204"
                           class="pl-sm-btn pl-sm-btn-contact">
                            <i class="fa-regular fa-comment-dots"></i> Contact Seller
                        </a>
                    </div>
                </div>
            </article>

            <!-- Bike -->
            <article class="pl-sm-card"
                     data-id="205"
                     data-category="Bikes"
                     data-title="Royal Enfield Classic 350"
                     data-price="145000"
                     data-location="Rishikesh, Uttarakhand"
                     data-condition="Used"
                     data-availability="active"
                     data-posted="2026-10-08"
                     data-saved="2026-10-09">

                <div class="pl-sm-image-wrap">
                    <img src="https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&w=800&q=85"
                         alt="Motorcycle for sale" loading="lazy">

                    <span class="pl-sm-category-tag">Bikes</span>
                    <span class="pl-sm-availability available">
                        <i class="fa-solid fa-circle-check"></i> Available
                    </span>

                    <button type="button" class="pl-sm-remove" data-action="remove"
                            aria-label="Remove Royal Enfield Classic 350 from saved listings"
                            title="Remove from saved">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </div>

                <div class="pl-sm-card-body">
                    <div class="pl-sm-card-heading">
                        <h3>Royal Enfield Classic 350</h3>
                        <strong class="pl-sm-price">₹1,45,000</strong>
                    </div>

                    <p class="pl-sm-location">
                        <i class="fa-solid fa-location-dot"></i> Rishikesh, Uttarakhand
                    </p>

                    <div class="pl-sm-details">
                        <span><i class="fa-solid fa-motorcycle"></i> Used</span>
                        <span><i class="fa-regular fa-calendar"></i> Posted 8 Oct 2026</span>
                    </div>

                    <div class="pl-sm-card-footer">
                        <a href="marketplace-listing-details.php?id=205"
                           class="pl-sm-btn pl-sm-btn-outline">View Details</a>
                        <a href="marketplace-enquiry.php?id=205"
                           class="pl-sm-btn pl-sm-btn-contact">
                            <i class="fa-regular fa-comment-dots"></i> Contact Seller
                        </a>
                    </div>
                </div>
            </article>

            <!-- Services -->
            <article class="pl-sm-card"
                     data-id="206"
                     data-category="Services"
                     data-title="Professional Home Cleaning"
                     data-price="1500"
                     data-location="Haridwar, Uttarakhand"
                     data-condition="Professional Service"
                     data-availability="active"
                     data-posted="2026-10-12"
                     data-saved="2026-10-13">

                <div class="pl-sm-image-wrap">
                    <img src="https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?auto=format&fit=crop&w=800&q=85"
                         alt="Professional home cleaning service" loading="lazy">

                    <span class="pl-sm-category-tag">Services</span>
                    <span class="pl-sm-availability available">
                        <i class="fa-solid fa-circle-check"></i> Available
                    </span>

                    <button type="button" class="pl-sm-remove" data-action="remove"
                            aria-label="Remove Professional Home Cleaning from saved listings"
                            title="Remove from saved">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </div>

                <div class="pl-sm-card-body">
                    <div class="pl-sm-card-heading">
                        <h3>Professional Home Cleaning</h3>
                        <strong class="pl-sm-price">₹1,500</strong>
                    </div>

                    <p class="pl-sm-location">
                        <i class="fa-solid fa-location-dot"></i> Haridwar, Uttarakhand
                    </p>

                    <div class="pl-sm-details">
                        <span><i class="fa-solid fa-broom"></i> Professional Service</span>
                        <span><i class="fa-regular fa-calendar"></i> Posted 12 Oct 2026</span>
                    </div>

                    <div class="pl-sm-card-footer">
                        <a href="marketplace-listing-details.php?id=206"
                           class="pl-sm-btn pl-sm-btn-outline">View Details</a>
                        <a href="marketplace-enquiry.php?id=206"
                           class="pl-sm-btn pl-sm-btn-contact">
                            <i class="fa-regular fa-comment-dots"></i> Contact Seller
                        </a>
                    </div>
                </div>
            </article>

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
