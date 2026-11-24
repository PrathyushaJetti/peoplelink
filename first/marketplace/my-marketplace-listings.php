<?php include 'header.php'; ?>

 

<main class="pl-my-market" id="plMyMarket">

    <!-- Page Header -->
    <section class="pl-mm-hero">
        <div class="pl-mm-container pl-mm-hero-inner">
            <div>
                <span class="pl-mm-eyebrow">PEOPLELINK MARKETPLACE</span>
                <h1>My Marketplace Listings</h1>
                <p>Manage your listings, track enquiries and keep your marketplace updated.</p>
            </div>

            <a href="post-marketplace-listing.php" class="pl-mm-btn pl-mm-btn-primary">
                <i class="fa-solid fa-plus"></i> Post New Listing
            </a>
        </div>
    </section>

    <div class="pl-mm-container pl-mm-content">

        <!-- Listing Summary -->
        <section class="pl-mm-stats" aria-label="Listing summary">

            <article class="pl-mm-stat-card">
                <div class="pl-mm-stat-icon pl-mm-blue">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <div>
                    <span>Total Views</span>
                    <strong id="plMmViews">1,248</strong>
                    <small>Across your listings</small>
                </div>
            </article>

            <article class="pl-mm-stat-card">
                <div class="pl-mm-stat-icon pl-mm-orange">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                    <span>Enquiries Received</span>
                    <strong id="plMmEnquiries">36</strong>
                    <small>People interested in your listings</small>
                </div>
            </article>

            <article class="pl-mm-stat-card">
                <div class="pl-mm-stat-icon pl-mm-purple">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <div>
                    <span>Saved by Users</span>
                    <strong id="plMmSaved">84</strong>
                    <small>Total favourites</small>
                </div>
            </article>

            <article class="pl-mm-stat-card">
                <div class="pl-mm-stat-icon pl-mm-green">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <span>Total Listings</span>
                    <strong id="plMmTotal">6</strong>
                    <small>All listing statuses</small>
                </div>
            </article>

        </section>

        <!-- Listing Management -->
        <section class="pl-mm-panel">

            <div class="pl-mm-panel-heading">
                <div>
                    <h2>Manage Your Listings</h2>
                    <p>Review and update your marketplace posts.</p>
                </div>
                <span class="pl-mm-total-badge" id="plMmResultCount">6 listings</span>
            </div>

            <!-- Status Tabs -->
            <div class="pl-mm-tabs" role="tablist" aria-label="Filter listings by status">

                <button class="pl-mm-tab is-active" type="button"
                        data-status="all" role="tab" aria-selected="true">
                    All Listings <span data-tab-count="all">6</span>
                </button>

                <button class="pl-mm-tab" type="button"
                        data-status="active" role="tab" aria-selected="false">
                    Active <span data-tab-count="active">2</span>
                </button>

                <button class="pl-mm-tab" type="button"
                        data-status="pending" role="tab" aria-selected="false">
                    Pending Approval <span data-tab-count="pending">1</span>
                </button>

                <button class="pl-mm-tab" type="button"
                        data-status="draft" role="tab" aria-selected="false">
                    Drafts <span data-tab-count="draft">1</span>
                </button>

                <button class="pl-mm-tab" type="button"
                        data-status="closed" role="tab" aria-selected="false">
                    Sold / Closed <span data-tab-count="closed">2</span>
                </button>

                <button class="pl-mm-tab" type="button"
                        data-status="rejected" role="tab" aria-selected="false">
                    Rejected <span data-tab-count="rejected">1</span>
                </button>

            </div>

            <!-- Filters -->
            <div class="pl-mm-filters">

                <div class="pl-mm-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="plMmSearch"
                           placeholder="Search your listings..."
                           aria-label="Search listings">
                </div>

                <select id="plMmCategory" aria-label="Filter by category">
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

                <select id="plMmStatus" aria-label="Filter by status">
                    <option value="all">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending Approval</option>
                    <option value="draft">Draft</option>
                    <option value="sold">Sold</option>
                    <option value="closed">Closed</option>
                    <option value="rejected">Rejected</option>
                </select>

                <button class="pl-mm-btn pl-mm-btn-outline" id="plMmReset" type="button">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </button>

            </div>

            <!-- Listing Cards -->
            <div class="pl-mm-listings" id="plMmListings">

                <!-- Listing 1 -->
                <article class="pl-mm-listing"
                         data-id="101"
                         data-category="Cars"
                         data-status="active"
                         data-title="Hyundai Creta SX Diesel"
                         data-price="1250000"
                         data-views="542"
                         data-enquiries="18"
                         data-saved="32"
                         data-location="Dehradun, Uttarakhand"
                         data-date="10 October 2026"
                         data-image="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=85">

                    <div class="pl-mm-listing-image">
                        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=85"
                             alt="Car for sale" loading="lazy">
                        <span class="pl-mm-status status-active">Active</span>
                    </div>

                    <div class="pl-mm-listing-body">
                        <div class="pl-mm-listing-top">
                            <div>
                                <span class="pl-mm-category">Cars</span>
                                <h3>Hyundai Creta SX Diesel</h3>
                                <div class="pl-mm-location">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Dehradun, Uttarakhand
                                </div>
                            </div>
                            <strong class="pl-mm-price">₹12,50,000</strong>
                        </div>

                        <div class="pl-mm-listing-meta">
                            <span><i class="fa-regular fa-calendar"></i> 10 Oct 2026</span>
                            <span><i class="fa-solid fa-eye"></i> 542 views</span>
                            <span><i class="fa-regular fa-envelope"></i> 18 enquiries</span>
                        </div>

                        <div class="pl-mm-listing-actions">
                            <a href="marketplace-listing-details.php?id=101" class="pl-mm-action action-view">
                                <i class="fa-regular fa-eye"></i> View
                            </a>
                            <a href="edit-marketplace-listing.php?id=101" class="pl-mm-action">
                                <i class="fa-regular fa-pen-to-square"></i> Edit
                            </a>
                            <button type="button" class="pl-mm-action action-sold" data-action="sold">
                                <i class="fa-solid fa-check"></i> Mark as Sold
                            </button>
                            <button type="button" class="pl-mm-action action-close" data-action="close">
                                <i class="fa-solid fa-lock"></i> Close Listing
                            </button>
                            <button type="button" class="pl-mm-action action-delete" data-action="delete">
                                <i class="fa-regular fa-trash-can"></i> Delete
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Listing 2 -->
                <article class="pl-mm-listing"
                         data-id="102"
                         data-category="Property"
                         data-status="pending"
                         data-title="2 BHK Apartment Near City Centre"
                         data-price="4500000"
                         data-views="184"
                         data-enquiries="7"
                         data-saved="21"
                         data-location="Rishikesh, Uttarakhand"
                         data-date="9 October 2026"
                         data-image="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=85">

                    <div class="pl-mm-listing-image">
                        <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=800&q=85"
                             alt="Modern apartment" loading="lazy">
                        <span class="pl-mm-status status-pending">Pending Approval</span>
                    </div>

                    <div class="pl-mm-listing-body">
                        <div class="pl-mm-listing-top">
                            <div>
                                <span class="pl-mm-category">Property</span>
                                <h3>2 BHK Apartment Near City Centre</h3>
                                <div class="pl-mm-location">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Rishikesh, Uttarakhand
                                </div>
                            </div>
                            <strong class="pl-mm-price">₹45,00,000</strong>
                        </div>

                        <div class="pl-mm-listing-meta">
                            <span><i class="fa-regular fa-calendar"></i> 9 Oct 2026</span>
                            <span><i class="fa-solid fa-eye"></i> 184 views</span>
                            <span><i class="fa-regular fa-envelope"></i> 7 enquiries</span>
                        </div>

                        <div class="pl-mm-listing-actions">
                            <a href="marketplace-listing-details.php?id=102" class="pl-mm-action action-view">
                                <i class="fa-regular fa-eye"></i> View
                            </a>
                            <a href="edit-marketplace-listing.php?id=102" class="pl-mm-action">
                                <i class="fa-regular fa-pen-to-square"></i> Edit
                            </a>
                            <button type="button" class="pl-mm-action action-delete" data-action="delete">
                                <i class="fa-regular fa-trash-can"></i> Delete
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Listing 3 -->
                <article class="pl-mm-listing"
                         data-id="103"
                         data-category="Electronics"
                         data-status="draft"
                         data-title="Apple MacBook Air M2"
                         data-price="65000"
                         data-views="0"
                         data-enquiries="0"
                         data-saved="0"
                         data-location="Haridwar, Uttarakhand"
                         data-date="8 October 2026"
                         data-image="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=85">

                    <div class="pl-mm-listing-image">
                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=85"
                             alt="Laptop for sale" loading="lazy">
                        <span class="pl-mm-status status-draft">Draft</span>
                    </div>

                    <div class="pl-mm-listing-body">
                        <div class="pl-mm-listing-top">
                            <div>
                                <span class="pl-mm-category">Electronics</span>
                                <h3>Apple MacBook Air M2</h3>
                                <div class="pl-mm-location">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Haridwar, Uttarakhand
                                </div>
                            </div>
                            <strong class="pl-mm-price">₹65,000</strong>
                        </div>

                        <div class="pl-mm-listing-meta">
                            <span><i class="fa-regular fa-calendar"></i> 8 Oct 2026</span>
                            <span><i class="fa-solid fa-eye"></i> 0 views</span>
                            <span><i class="fa-regular fa-envelope"></i> 0 enquiries</span>
                        </div>

                        <div class="pl-mm-listing-actions">
                            <a href="marketplace-listing-details.php?id=103" class="pl-mm-action action-view">
                                <i class="fa-regular fa-eye"></i> Preview
                            </a>
                            <a href="edit-marketplace-listing.php?id=103" class="pl-mm-action">
                                <i class="fa-regular fa-pen-to-square"></i> Continue Editing
                            </a>
                            <button type="button" class="pl-mm-action action-delete" data-action="delete">
                                <i class="fa-regular fa-trash-can"></i> Delete
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Listing 4 -->
                <article class="pl-mm-listing"
                         data-id="104"
                         data-category="Furniture"
                         data-status="sold"
                         data-title="Solid Wood Dining Table"
                         data-price="18000"
                         data-views="275"
                         data-enquiries="9"
                         data-saved="16"
                         data-location="Dehradun, Uttarakhand"
                         data-date="5 October 2026"
                         data-image="https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=800&q=85">

                    <div class="pl-mm-listing-image">
                        <img src="https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=800&q=85"
                             alt="Wooden dining table" loading="lazy">
                        <span class="pl-mm-status status-sold">Sold</span>
                    </div>

                    <div class="pl-mm-listing-body">
                        <div class="pl-mm-listing-top">
                            <div>
                                <span class="pl-mm-category">Furniture</span>
                                <h3>Solid Wood Dining Table</h3>
                                <div class="pl-mm-location">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Dehradun, Uttarakhand
                                </div>
                            </div>
                            <strong class="pl-mm-price">₹18,000</strong>
                        </div>

                        <div class="pl-mm-listing-meta">
                            <span><i class="fa-regular fa-calendar"></i> 5 Oct 2026</span>
                            <span><i class="fa-solid fa-eye"></i> 275 views</span>
                            <span><i class="fa-regular fa-envelope"></i> 9 enquiries</span>
                        </div>

                        <div class="pl-mm-listing-actions">
                            <a href="marketplace-listing-details.php?id=104" class="pl-mm-action action-view">
                                <i class="fa-regular fa-eye"></i> View
                            </a>
                            <a href="edit-marketplace-listing.php?id=104" class="pl-mm-action">
                                <i class="fa-regular fa-pen-to-square"></i> Edit
                            </a>
                            <button type="button" class="pl-mm-action action-delete" data-action="delete">
                                <i class="fa-regular fa-trash-can"></i> Delete
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Listing 5 -->
                <article class="pl-mm-listing"
                         data-id="105"
                         data-category="Bikes"
                         data-status="closed"
                         data-title="Royal Enfield Classic 350"
                         data-price="145000"
                         data-views="166"
                         data-enquiries="2"
                         data-saved="9"
                         data-location="Rishikesh, Uttarakhand"
                         data-date="3 October 2026"
                         data-image="https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&w=800&q=85">

                    <div class="pl-mm-listing-image">
                        <img src="https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&w=800&q=85"
                             alt="Motorcycle listing" loading="lazy">
                        <span class="pl-mm-status status-closed">Closed</span>
                    </div>

                    <div class="pl-mm-listing-body">
                        <div class="pl-mm-listing-top">
                            <div>
                                <span class="pl-mm-category">Bikes</span>
                                <h3>Royal Enfield Classic 350</h3>
                                <div class="pl-mm-location">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Rishikesh, Uttarakhand
                                </div>
                            </div>
                            <strong class="pl-mm-price">₹1,45,000</strong>
                        </div>

                        <div class="pl-mm-listing-meta">
                            <span><i class="fa-regular fa-calendar"></i> 3 Oct 2026</span>
                            <span><i class="fa-solid fa-eye"></i> 166 views</span>
                            <span><i class="fa-regular fa-envelope"></i> 2 enquiries</span>
                        </div>

                        <div class="pl-mm-listing-actions">
                            <a href="marketplace-listing-details.php?id=105" class="pl-mm-action action-view">
                                <i class="fa-regular fa-eye"></i> View
                            </a>
                            <a href="edit-marketplace-listing.php?id=105" class="pl-mm-action">
                                <i class="fa-regular fa-pen-to-square"></i> Edit
                            </a>
                            <button type="button" class="pl-mm-action action-delete" data-action="delete">
                                <i class="fa-regular fa-trash-can"></i> Delete
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Listing 6 -->
                <article class="pl-mm-listing"
                         data-id="106"
                         data-category="Services"
                         data-status="rejected"
                         data-title="Home Cleaning Services"
                         data-price="1500"
                         data-views="81"
                         data-enquiries="0"
                         data-saved="6"
                         data-location="Haridwar, Uttarakhand"
                         data-date="2 October 2026"
                         data-image="https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?auto=format&fit=crop&w=800&q=85"
                         data-reason="Please add a clear service area and complete your pricing details before resubmitting.">

                    <div class="pl-mm-listing-image">
                        <img src="https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?auto=format&fit=crop&w=800&q=85"
                             alt="Home cleaning service" loading="lazy">
                        <span class="pl-mm-status status-rejected">Rejected</span>
                    </div>

                    <div class="pl-mm-listing-body">
                        <div class="pl-mm-listing-top">
                            <div>
                                <span class="pl-mm-category">Services</span>
                                <h3>Home Cleaning Services</h3>
                                <div class="pl-mm-location">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Haridwar, Uttarakhand
                                </div>
                            </div>
                            <strong class="pl-mm-price">₹1,500</strong>
                        </div>

                        <div class="pl-mm-rejection-note">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            Please update the listing details before resubmitting.
                        </div>

                        <div class="pl-mm-listing-meta">
                            <span><i class="fa-regular fa-calendar"></i> 2 Oct 2026</span>
                            <span><i class="fa-solid fa-eye"></i> 81 views</span>
                            <span><i class="fa-regular fa-envelope"></i> 0 enquiries</span>
                        </div>

                        <div class="pl-mm-listing-actions">
                            <a href="marketplace-listing-details.php?id=106" class="pl-mm-action action-view">
                                <i class="fa-regular fa-eye"></i> View
                            </a>
                            <a href="marketplace-rejection-reason.php?id=106" class="pl-mm-action action-reason">
                                <i class="fa-solid fa-circle-info"></i> View Reason
                            </a>
                            <a href="edit-marketplace-listing.php?id=106&resubmit=1" class="pl-mm-action">
                                <i class="fa-solid fa-rotate"></i> Edit &amp; Resubmit
                            </a>
                            <button type="button" class="pl-mm-action action-delete" data-action="delete">
                                <i class="fa-regular fa-trash-can"></i> Delete
                            </button>
                        </div>
                    </div>
                </article>

            </div>

            <!-- Empty State -->
            <div class="pl-mm-empty" id="plMmEmpty" hidden>
                <div class="pl-mm-empty-icon">
                    <i class="fa-solid fa-store"></i>
                </div>
                <h3 id="plMmEmptyTitle">No listings found</h3>
                <p id="plMmEmptyText">
                    Try changing your filters or post your first marketplace listing.
                </p>
                <a href="post-marketplace-listing.php" class="pl-mm-btn pl-mm-btn-primary">
                    <i class="fa-solid fa-plus"></i> Post a Listing
                </a>
            </div>

        </section>

        <!-- Help Section -->
        <section class="pl-mm-help">
            <div class="pl-mm-help-icon">
                <i class="fa-solid fa-lightbulb"></i>
            </div>

            <div>
                <h3>Get more attention for your listings</h3>
                <p>
                    Use clear photos, accurate prices and complete descriptions
                    to help people make informed decisions.
                </p>
            </div>

            <a href="marketplace-guidelines.php">
                Marketplace Guidelines <i class="fa-solid fa-arrow-right"></i>
            </a>
        </section>

    </div>
</main>

 

<?php include 'footer.php'; ?>
