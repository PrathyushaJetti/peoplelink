<?php include 'header.php'; ?>

 

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
                        <strong id="plMrKeyword">All listings</strong>
                    </div>
                </div>

                <div class="pl-mr-summary-item">
                    <i class="fas fa-th-large"></i>
                    <div>
                        <span>Category</span>
                        <strong id="plMrCategory">All Categories</strong>
                    </div>
                </div>

                <div class="pl-mr-summary-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <span>Location</span>
                        <strong id="plMrLocation">All Locations</strong>
                    </div>
                </div>

                <div class="pl-mr-summary-count">
                    <strong id="plMrCount">8</strong>
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
                <article class="pl-mr-card"
                         data-category="Electronics"
                         data-price="18500"
                         data-date="2026-10-12"
                         data-title="Samsung Galaxy Smartphone"
                         data-location="Rishikesh"
                         data-condition="Used"
                         data-status="available">

                    <div class="pl-mr-card-image">
                        <img src="assets/images/marketplace/phone.jpg"
                             alt="Samsung Galaxy smartphone"
                             loading="lazy">

                        <span class="pl-mr-status available">Available</span>

                        <button type="button" class="pl-mr-save"
                                aria-label="Save Samsung Galaxy Smartphone"
                                aria-pressed="false">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>

                    <div class="pl-mr-card-body">
                        <div class="pl-mr-card-meta">
                            <span class="pl-mr-card-category">Electronics</span>
                            <span class="pl-mr-condition">Used</span>
                        </div>

                        <h3>
                            <a href="marketplace-listing-details.php?id=1">
                                Samsung Galaxy Smartphone
                            </a>
                        </h3>

                        <div class="pl-mr-price">₹18,500</div>

                        <div class="pl-mr-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Rishikesh, Uttarakhand
                        </div>

                        <div class="pl-mr-card-footer">
                            <div class="pl-mr-seller">
                                <span class="pl-mr-avatar">RK</span>
                                <div>
                                    <strong>Rahul Kumar</strong>
                                    <span>Community Member</span>
                                </div>
                            </div>
                            <span class="pl-mr-date">12 Oct 2026</span>
                        </div>

                        <div class="pl-mr-card-actions">
                            <a href="marketplace-listing-details.php?id=1"
                               class="pl-mr-view-btn">View Details</a>
                            <button type="button" class="pl-mr-contact-btn"
                                    data-contact="Rahul Kumar">
                                <i class="fas fa-comment-alt"></i> Contact
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Listing 2 -->
                <article class="pl-mr-card"
                         data-category="Furniture"
                         data-price="6500"
                         data-date="2026-10-10"
                         data-title="Wooden Study Table"
                         data-location="Haridwar"
                         data-condition="Used"
                         data-status="available">

                    <div class="pl-mr-card-image">
                        <img src="assets/images/marketplace/study-table.jpg"
                             alt="Wooden study table"
                             loading="lazy">

                        <span class="pl-mr-status available">Available</span>

                        <button type="button" class="pl-mr-save"
                                aria-label="Save Wooden Study Table"
                                aria-pressed="false">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>

                    <div class="pl-mr-card-body">
                        <div class="pl-mr-card-meta">
                            <span class="pl-mr-card-category">Furniture</span>
                            <span class="pl-mr-condition">Used</span>
                        </div>

                        <h3>
                            <a href="marketplace-listing-details.php?id=2">
                                Wooden Study Table
                            </a>
                        </h3>

                        <div class="pl-mr-price">₹6,500</div>

                        <div class="pl-mr-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Haridwar, Uttarakhand
                        </div>

                        <div class="pl-mr-card-footer">
                            <div class="pl-mr-seller">
                                <span class="pl-mr-avatar">AS</span>
                                <div>
                                    <strong>Amit Sharma</strong>
                                    <span>Community Member</span>
                                </div>
                            </div>
                            <span class="pl-mr-date">10 Oct 2026</span>
                        </div>

                        <div class="pl-mr-card-actions">
                            <a href="marketplace-listing-details.php?id=2"
                               class="pl-mr-view-btn">View Details</a>
                            <button type="button" class="pl-mr-contact-btn"
                                    data-contact="Amit Sharma">
                                <i class="fas fa-comment-alt"></i> Contact
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Listing 3 -->
                <article class="pl-mr-card"
                         data-category="Bikes"
                         data-price="42000"
                         data-date="2026-10-08"
                         data-title="Honda Activa Scooter"
                         data-location="Dehradun"
                         data-condition="Used"
                         data-status="available">

                    <div class="pl-mr-card-image">
                        <img src="assets/images/marketplace/scooter.jpg"
                             alt="Honda Activa scooter"
                             loading="lazy">

                        <span class="pl-mr-status available">Available</span>

                        <button type="button" class="pl-mr-save"
                                aria-label="Save Honda Activa Scooter"
                                aria-pressed="false">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>

                    <div class="pl-mr-card-body">
                        <div class="pl-mr-card-meta">
                            <span class="pl-mr-card-category">Bikes</span>
                            <span class="pl-mr-condition">Used</span>
                        </div>

                        <h3>
                            <a href="marketplace-listing-details.php?id=3">
                                Honda Activa Scooter
                            </a>
                        </h3>

                        <div class="pl-mr-price">₹42,000</div>

                        <div class="pl-mr-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Dehradun, Uttarakhand
                        </div>

                        <div class="pl-mr-card-footer">
                            <div class="pl-mr-seller">
                                <span class="pl-mr-avatar">VP</span>
                                <div>
                                    <strong>Vikas Pandey</strong>
                                    <span>Community Member</span>
                                </div>
                            </div>
                            <span class="pl-mr-date">08 Oct 2026</span>
                        </div>

                        <div class="pl-mr-card-actions">
                            <a href="marketplace-listing-details.php?id=3"
                               class="pl-mr-view-btn">View Details</a>
                            <button type="button" class="pl-mr-contact-btn"
                                    data-contact="Vikas Pandey">
                                <i class="fas fa-comment-alt"></i> Contact
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Listing 4 -->
                <article class="pl-mr-card"
                         data-category="Property"
                         data-price="850000"
                         data-date="2026-10-06"
                         data-title="Residential Plot for Sale"
                         data-location="Rishikesh"
                         data-condition="New"
                         data-status="available">

                    <div class="pl-mr-card-image">
                        <img src="assets/images/marketplace/plot.jpg"
                             alt="Residential plot for sale"
                             loading="lazy">

                        <span class="pl-mr-status available">Available</span>

                        <button type="button" class="pl-mr-save"
                                aria-label="Save Residential Plot"
                                aria-pressed="false">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>

                    <div class="pl-mr-card-body">
                        <div class="pl-mr-card-meta">
                            <span class="pl-mr-card-category">Property</span>
                            <span class="pl-mr-condition">New</span>
                        </div>

                        <h3>
                            <a href="marketplace-listing-details.php?id=4">
                                Residential Plot for Sale
                            </a>
                        </h3>

                        <div class="pl-mr-price">₹8,50,000</div>

                        <div class="pl-mr-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Rishikesh, Uttarakhand
                        </div>

                        <div class="pl-mr-card-footer">
                            <div class="pl-mr-seller">
                                <span class="pl-mr-avatar">MS</span>
                                <div>
                                    <strong>Manoj Singh</strong>
                                    <span>Community Member</span>
                                </div>
                            </div>
                            <span class="pl-mr-date">06 Oct 2026</span>
                        </div>

                        <div class="pl-mr-card-actions">
                            <a href="marketplace-listing-details.php?id=4"
                               class="pl-mr-view-btn">View Details</a>
                            <button type="button" class="pl-mr-contact-btn"
                                    data-contact="Manoj Singh">
                                <i class="fas fa-comment-alt"></i> Contact
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Listing 5 -->
                <article class="pl-mr-card"
                         data-category="Cars"
                         data-price="325000"
                         data-date="2026-10-04"
                         data-title="Maruti Suzuki Swift"
                         data-location="Dehradun"
                         data-condition="Used"
                         data-status="sold">

                    <div class="pl-mr-card-image">
                        <img src="assets/images/marketplace/car.jpg"
                             alt="Maruti Suzuki Swift car"
                             loading="lazy">

                        <span class="pl-mr-status closed">Sold</span>

                        <button type="button" class="pl-mr-save"
                                aria-label="Save Maruti Suzuki Swift"
                                aria-pressed="false">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>

                    <div class="pl-mr-card-body">
                        <div class="pl-mr-card-meta">
                            <span class="pl-mr-card-category">Cars</span>
                            <span class="pl-mr-condition">Used</span>
                        </div>

                        <h3>
                            <a href="marketplace-listing-details.php?id=5">
                                Maruti Suzuki Swift
                            </a>
                        </h3>

                        <div class="pl-mr-price">₹3,25,000</div>

                        <div class="pl-mr-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Dehradun, Uttarakhand
                        </div>

                        <div class="pl-mr-card-footer">
                            <div class="pl-mr-seller">
                                <span class="pl-mr-avatar">NS</span>
                                <div>
                                    <strong>Neeraj Singh</strong>
                                    <span>Community Member</span>
                                </div>
                            </div>
                            <span class="pl-mr-date">04 Oct 2026</span>
                        </div>

                        <div class="pl-mr-card-actions">
                            <a href="marketplace-listing-details.php?id=5"
                               class="pl-mr-view-btn">View Details</a>
                            <button type="button" class="pl-mr-contact-btn"
                                    data-contact="Neeraj Singh">
                                <i class="fas fa-comment-alt"></i> Contact
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Listing 6 -->
                <article class="pl-mr-card"
                         data-category="Services"
                         data-price="1200"
                         data-date="2026-10-02"
                         data-title="Home Painting Service"
                         data-location="Haridwar"
                         data-condition="New"
                         data-status="available">

                    <div class="pl-mr-card-image">
                        <img src="assets/images/marketplace/painting-service.jpg"
                             alt="Home painting service"
                             loading="lazy">

                        <span class="pl-mr-status available">Available</span>

                        <button type="button" class="pl-mr-save"
                                aria-label="Save Home Painting Service"
                                aria-pressed="false">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>

                    <div class="pl-mr-card-body">
                        <div class="pl-mr-card-meta">
                            <span class="pl-mr-card-category">Services</span>
                            <span class="pl-mr-condition">Service</span>
                        </div>

                        <h3>
                            <a href="marketplace-listing-details.php?id=6">
                                Home Painting Service
                            </a>
                        </h3>

                        <div class="pl-mr-price">Starting ₹1,200</div>

                        <div class="pl-mr-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Haridwar, Uttarakhand
                        </div>

                        <div class="pl-mr-card-footer">
                            <div class="pl-mr-seller">
                                <span class="pl-mr-avatar">AK</span>
                                <div>
                                    <strong>Ajay Kumar</strong>
                                    <span>Local Service Provider</span>
                                </div>
                            </div>
                            <span class="pl-mr-date">02 Oct 2026</span>
                        </div>

                        <div class="pl-mr-card-actions">
                            <a href="marketplace-listing-details.php?id=6"
                               class="pl-mr-view-btn">View Details</a>
                            <button type="button" class="pl-mr-contact-btn"
                                    data-contact="Ajay Kumar">
                                <i class="fas fa-comment-alt"></i> Contact
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Listing 7 -->
                <article class="pl-mr-card"
                         data-category="Products"
                         data-price="950"
                         data-date="2026-09-30"
                         data-title="Handmade Gift Hamper"
                         data-location="Rishikesh"
                         data-condition="New"
                         data-status="available">

                    <div class="pl-mr-card-image">
                        <img src="assets/images/marketplace/gift-hamper.jpg"
                             alt="Handmade gift hamper"
                             loading="lazy">

                        <span class="pl-mr-status available">Available</span>

                        <button type="button" class="pl-mr-save"
                                aria-label="Save Handmade Gift Hamper"
                                aria-pressed="false">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>

                    <div class="pl-mr-card-body">
                        <div class="pl-mr-card-meta">
                            <span class="pl-mr-card-category">Products</span>
                            <span class="pl-mr-condition">New</span>
                        </div>

                        <h3>
                            <a href="marketplace-listing-details.php?id=7">
                                Handmade Gift Hamper
                            </a>
                        </h3>

                        <div class="pl-mr-price">₹950</div>

                        <div class="pl-mr-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Rishikesh, Uttarakhand
                        </div>

                        <div class="pl-mr-card-footer">
                            <div class="pl-mr-seller">
                                <span class="pl-mr-avatar">PD</span>
                                <div>
                                    <strong>Priya Devi</strong>
                                    <span>Community Member</span>
                                </div>
                            </div>
                            <span class="pl-mr-date">30 Sep 2026</span>
                        </div>

                        <div class="pl-mr-card-actions">
                            <a href="marketplace-listing-details.php?id=7"
                               class="pl-mr-view-btn">View Details</a>
                            <button type="button" class="pl-mr-contact-btn"
                                    data-contact="Priya Devi">
                                <i class="fas fa-comment-alt"></i> Contact
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Listing 8 -->
                <article class="pl-mr-card"
                         data-category="Other"
                         data-price="1500"
                         data-date="2026-09-28"
                         data-title="Musical Keyboard"
                         data-location="Haridwar"
                         data-condition="Used"
                         data-status="available">

                    <div class="pl-mr-card-image">
                        <img src="assets/images/marketplace/keyboard.jpg"
                             alt="Musical keyboard"
                             loading="lazy">

                        <span class="pl-mr-status available">Available</span>

                        <button type="button" class="pl-mr-save"
                                aria-label="Save Musical Keyboard"
                                aria-pressed="false">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>

                    <div class="pl-mr-card-body">
                        <div class="pl-mr-card-meta">
                            <span class="pl-mr-card-category">Other</span>
                            <span class="pl-mr-condition">Used</span>
                        </div>

                        <h3>
                            <a href="marketplace-listing-details.php?id=8">
                                Musical Keyboard
                            </a>
                        </h3>

                        <div class="pl-mr-price">₹1,500</div>

                        <div class="pl-mr-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Haridwar, Uttarakhand
                        </div>

                        <div class="pl-mr-card-footer">
                            <div class="pl-mr-seller">
                                <span class="pl-mr-avatar">SK</span>
                                <div>
                                    <strong>Sandeep Kumar</strong>
                                    <span>Community Member</span>
                                </div>
                            </div>
                            <span class="pl-mr-date">28 Sep 2026</span>
                        </div>

                        <div class="pl-mr-card-actions">
                            <a href="marketplace-listing-details.php?id=8"
                               class="pl-mr-view-btn">View Details</a>
                            <button type="button" class="pl-mr-contact-btn"
                                    data-contact="Sandeep Kumar">
                                <i class="fas fa-comment-alt"></i> Contact
                            </button>
                        </div>
                    </div>
                </article>

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
 