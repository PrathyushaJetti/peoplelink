<?php include 'header.php'; ?>


<main class="pl-md-page">

    <!-- Breadcrumb -->
    <section class="pl-md-top">
        <div class="pl-md-container">
            <nav class="pl-md-breadcrumb">
                <a href="marketplace-home.php">Marketplace</a>
                <i class="fas fa-chevron-right"></i>
                <a href="marketplace-search-results.php">Listings</a>
                <i class="fas fa-chevron-right"></i>
                <span>Listing Details</span>
            </nav>
        </div>
    </section>

    <section class="pl-md-main-section">
        <div class="pl-md-container">
            <div class="pl-md-layout">

                <!-- Main Content -->
                <div class="pl-md-primary">

                    <!-- Product Gallery -->
                    <div class="pl-md-gallery">
                        <div class="pl-md-main-image">
                            <img
                                src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1200&q=85"
                                id="plMdMainImage"
                                alt="Samsung Galaxy smartphone">

                            <span class="pl-md-image-status">
                                <i class="fas fa-check-circle"></i> Available
                            </span>

                            <span class="pl-md-image-count" id="plMdImageCount">
                                1 / 4
                            </span>
                        </div>

                        <div class="pl-md-thumbnails">
                            <button type="button"
                                class="pl-md-thumbnail active"
                                data-image="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1200&q=85">
                                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=200&q=80"
                                     alt="Smartphone front view">
                            </button>

                            <button type="button"
                                class="pl-md-thumbnail"
                                data-image="https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=1200&q=85">
                                <img src="https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=200&q=80"
                                     alt="Smartphone side view">
                            </button>

                            <button type="button"
                                class="pl-md-thumbnail"
                                data-image="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=1200&q=85">
                                <img src="https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?auto=format&fit=crop&w=200&q=80"
                                     alt="Smartphone back view">
                            </button>

                            <button type="button"
                                class="pl-md-thumbnail"
                                data-image="https://images.unsplash.com/photo-1605236453806-6ff36851218e?auto=format&fit=crop&w=1200&q=85">
                                <img src="https://images.unsplash.com/photo-1605236453806-6ff36851218e?auto=format&fit=crop&w=200&q=80"
                                     alt="Another smartphone view">
                            </button>
                        </div>
                    </div>

                    <!-- Listing Overview -->
                    <section class="pl-md-card pl-md-overview">
                        <div class="pl-md-category-line">
                            <span class="pl-md-category-badge">
                                <i class="fas fa-mobile-alt"></i>
                                Electronics
                            </span>
                            <span class="pl-md-listing-id">Listing #PL001</span>
                        </div>

                        <div class="pl-md-listing-heading">
                            <h1>Samsung Galaxy Smartphone</h1>

                            <div class="pl-md-meta-line">
                                <span>
                                    <i class="fas fa-map-marker-alt"></i>
                                    Rishikesh, Uttarakhand
                                </span>
                                <span>
                                    <i class="far fa-calendar-alt"></i>
                                    Posted 12 October 2026
                                </span>
                            </div>
                        </div>

                        <div class="pl-md-price-row">
                            <div>
                                <span class="pl-md-price-label">Asking Price</span>
                                <div class="pl-md-price">₹18,500</div>
                                <span class="pl-md-price-type">
                                    <i class="fas fa-handshake"></i>
                                    Price negotiable
                                </span>
                            </div>

                            <span class="pl-md-availability">
                                <span></span> Available
                            </span>
                        </div>

                        <div class="pl-md-actions">
                            <button type="button" class="pl-md-btn pl-md-save"
                                    id="plMdSave" aria-pressed="false">
                                <i class="far fa-heart"></i>
                                <span>Save Listing</span>
                            </button>

                            <a href="#plMdContact"
                               class="pl-md-btn pl-md-contact-primary">
                                <i class="fas fa-comment-alt"></i>
                                Contact Seller
                            </a>

                            <button type="button" class="pl-md-btn pl-md-share"
                                    id="plMdShare">
                                <i class="fas fa-share-alt"></i> Share
                            </button>
                        </div>
                    </section>

                    <!-- About Listing -->
                    <section class="pl-md-card pl-md-section-card">
                        <div class="pl-md-section-heading">
                            <span class="pl-md-heading-icon">
                                <i class="fas fa-align-left"></i>
                            </span>
                            <div>
                                <h2>About This Listing</h2>
                                <p>Complete information provided by the seller.</p>
                            </div>
                        </div>

                        <div class="pl-md-description">
                            <p>
                                Samsung Galaxy smartphone in good working
                                condition. Suitable for everyday use, calls,
                                photography, browsing and other regular activities.
                            </p>
                            <p>
                                The device has been used carefully. Contact the
                                seller for additional photographs, specifications
                                and an opportunity to inspect the item before purchase.
                            </p>
                        </div>

                        <div class="pl-md-detail-grid">
                            <div class="pl-md-detail-item">
                                <span>Category</span>
                                <strong>Electronics</strong>
                            </div>
                            <div class="pl-md-detail-item">
                                <span>Subcategory</span>
                                <strong>Mobile Phones</strong>
                            </div>
                            <div class="pl-md-detail-item">
                                <span>Brand</span>
                                <strong>Samsung</strong>
                            </div>
                            <div class="pl-md-detail-item">
                                <span>Model</span>
                                <strong>Galaxy Series</strong>
                            </div>
                            <div class="pl-md-detail-item">
                                <span>Condition</span>
                                <strong>Used</strong>
                            </div>
                            <div class="pl-md-detail-item">
                                <span>Purchase Year</span>
                                <strong>2025</strong>
                            </div>
                            <div class="pl-md-detail-item">
                                <span>Price Type</span>
                                <strong>Negotiable</strong>
                            </div>
                            <div class="pl-md-detail-item">
                                <span>Availability</span>
                                <strong class="pl-md-green-text">Available</strong>
                            </div>
                        </div>
                    </section>

                    <!-- Category Specific Details -->
                    <section class="pl-md-card pl-md-section-card">
                        <div class="pl-md-section-heading">
                            <span class="pl-md-heading-icon">
                                <i class="fas fa-list-ul"></i>
                            </span>
                            <div>
                                <h2>Product Specifications</h2>
                                <p>Additional details about this item.</p>
                            </div>
                        </div>

                        <div class="pl-md-spec-list">
                            <div>
                                <span>Product Type</span>
                                <strong>Smartphone</strong>
                            </div>
                            <div>
                                <span>Brand</span>
                                <strong>Samsung</strong>
                            </div>
                            <div>
                                <span>Model</span>
                                <strong>Galaxy Series</strong>
                            </div>
                            <div>
                                <span>Purchase Year</span>
                                <strong>2025</strong>
                            </div>
                            <div>
                                <span>Accessories</span>
                                <strong>Confirm with seller</strong>
                            </div>
                        </div>

                        <p class="pl-md-dynamic-note">
                            Specifications are sample data. Show relevant fields
                            dynamically for each listing category.
                        </p>
                    </section>

                    <!-- Location -->
                    <section class="pl-md-card pl-md-section-card">
                        <div class="pl-md-section-heading">
                            <span class="pl-md-heading-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </span>
                            <div>
                                <h2>Listing Location</h2>
                                <p>Find the item's general location.</p>
                            </div>
                        </div>

                        <div class="pl-md-location-box">
                            <div class="pl-md-location-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>

                            <div class="pl-md-location-info">
                                <strong>Rishikesh, Uttarakhand</strong>
                                <span>Area: Confirm with seller</span>
                                <span>City: Rishikesh</span>
                            </div>

                            <a href="https://www.google.com/maps/search/?api=1&query=Rishikesh%2C%20Uttarakhand"
                               target="_blank" rel="noopener noreferrer"
                               class="pl-md-map-btn">
                                <i class="fas fa-external-link-alt"></i>
                                View on Map
                            </a>
                        </div>

                        <p class="pl-md-privacy-note">
                            <i class="fas fa-shield-alt"></i>
                            The seller's exact address is not displayed publicly.
                        </p>
                    </section>

                    <!-- Similar Listings -->
                    <section class="pl-md-similar-section">
                        <div class="pl-md-similar-heading">
                            <div>
                                <span class="pl-md-eyebrow">YOU MAY ALSO LIKE</span>
                                <h2>Similar Listings</h2>
                                <p>Discover more items from the marketplace.</p>
                            </div>

                            <a href="marketplace-search-results.php?category=Electronics"
                               class="pl-md-view-all">
                                View Similar Listings
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>

                        <div class="pl-md-similar-grid">

                            <article class="pl-md-similar-card">
                                <a href="marketplace-listing-details.php?id=9"
                                   class="pl-md-similar-image">
                                    <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=700&q=80"
                                         alt="Laptop for sale" loading="lazy">
                                </a>
                                <div class="pl-md-similar-body">
                                    <span>Electronics</span>
                                    <h3>
                                        <a href="marketplace-listing-details.php?id=9">
                                            Laptop for Sale
                                        </a>
                                    </h3>
                                    <strong>₹25,000</strong>
                                    <small>
                                        <i class="fas fa-map-marker-alt"></i>
                                        Dehradun, Uttarakhand
                                    </small>
                                </div>
                            </article>

                            <article class="pl-md-similar-card">
                                <a href="marketplace-listing-details.php?id=10"
                                   class="pl-md-similar-image">
                                    <img src="https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=700&q=80"
                                         alt="Tablet for sale" loading="lazy">
                                </a>
                                <div class="pl-md-similar-body">
                                    <span>Electronics</span>
                                    <h3>
                                        <a href="marketplace-listing-details.php?id=10">
                                            Tablet for Sale
                                        </a>
                                    </h3>
                                    <strong>₹12,000</strong>
                                    <small>
                                        <i class="fas fa-map-marker-alt"></i>
                                        Haridwar, Uttarakhand
                                    </small>
                                </div>
                            </article>

                            <article class="pl-md-similar-card">
                                <a href="marketplace-listing-details.php?id=11"
                                   class="pl-md-similar-image">
                                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=700&q=80"
                                         alt="Headphones for sale" loading="lazy">
                                </a>
                                <div class="pl-md-similar-body">
                                    <span>Electronics</span>
                                    <h3>
                                        <a href="marketplace-listing-details.php?id=11">
                                            Wireless Headphones
                                        </a>
                                    </h3>
                                    <strong>₹2,500</strong>
                                    <small>
                                        <i class="fas fa-map-marker-alt"></i>
                                        Rishikesh, Uttarakhand
                                    </small>
                                </div>
                            </article>

                        </div>
                    </section>
                </div>

                <!-- Sidebar -->
                <aside class="pl-md-sidebar">

                    <!-- Seller Information -->
                    <section class="pl-md-card pl-md-seller-card">
                        <div class="pl-md-sidebar-heading">
                            <h2>Seller Information</h2>
                            <i class="fas fa-user-check"></i>
                        </div>

                        <div class="pl-md-seller-profile">
                            <div class="pl-md-seller-avatar">RK</div>
                            <div>
                                <h3>Rahul Kumar</h3>
                                <span class="pl-md-member-badge">
                                    <i class="fas fa-check-circle"></i>
                                    Community Member
                                </span>
                            </div>
                        </div>

                        <div class="pl-md-seller-details">
                            <div>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Rishikesh, Uttarakhand</span>
                            </div>
                            <div>
                                <i class="fas fa-users"></i>
                                <span>Community: Not specified</span>
                            </div>
                            <div>
                                <i class="far fa-calendar-alt"></i>
                                <span>Member since: Not specified</span>
                            </div>
                        </div>

                        <a href="#plMdContact" class="pl-md-sidebar-contact">
                            Contact Seller
                            <i class="fas fa-arrow-right"></i>
                        </a>

                        <p class="pl-md-privacy-note">
                            <i class="fas fa-lock"></i>
                            Contact information is shared according to member privacy settings.
                        </p>
                    </section>

                    <!-- Contact Seller -->
                    <section class="pl-md-card pl-md-contact-card" id="plMdContact">
                        <div class="pl-md-sidebar-heading">
                            <h2>Contact Seller</h2>
                            <i class="fas fa-comments"></i>
                        </div>

                        <p>Interested in this listing? Contact the seller for more information.</p>

                        <a href="tel:+910000000000"
                           class="pl-md-contact-option pl-md-call">
                            <span><i class="fas fa-phone-alt"></i></span>
                            <div>
                                <strong>Call Seller</strong>
                                <small>Ask about the listing</small>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>

                        <a href="https://wa.me/910000000000?text=Hello%2C%20I%20am%20interested%20in%20your%20Samsung%20Galaxy%20Smartphone%20listing."
                           target="_blank" rel="noopener noreferrer"
                           class="pl-md-contact-option pl-md-whatsapp">
                            <span><i class="fab fa-whatsapp"></i></span>
                            <div>
                                <strong>WhatsApp</strong>
                                <small>Chat with the seller</small>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>

                        <button type="button"
                                class="pl-md-contact-option pl-md-enquiry"
                                id="plMdOpenEnquiry">
                            <span><i class="fas fa-envelope"></i></span>
                            <div>
                                <strong>Send Enquiry</strong>
                                <small>Ask about this item</small>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </button>

                        <div class="pl-md-safety-tip">
                            <i class="fas fa-shield-alt"></i>
                            <div>
                                <strong>Stay safe</strong>
                                <p>Verify the item before payment and avoid sharing sensitive information.</p>
                            </div>
                        </div>
                    </section>

                    <!-- Listing Information -->
                    <section class="pl-md-card pl-md-sidebar-info">
                        <h2>Listing Information</h2>

                        <div>
                            <span>Listing ID</span>
                            <strong>PL001</strong>
                        </div>
                        <div>
                            <span>Posted Date</span>
                            <strong>12 October 2026</strong>
                        </div>
                        <div>
                            <span>Last Updated</span>
                            <strong>12 October 2026</strong>
                        </div>
                        <div>
                            <span>Status</span>
                            <strong class="pl-md-green-text">Available</strong>
                        </div>

                        <button type="button" id="plMdReport"
                                class="pl-md-report-btn">
                            <i class="fas fa-flag"></i>
                            Report this listing
                        </button>
                    </section>

                </aside>
            </div>
        </div>
    </section>

    <!-- Enquiry Modal -->
    <div class="pl-md-modal" id="plMdEnquiryModal" aria-hidden="true">
        <div class="pl-md-modal-backdrop" data-close-modal></div>

        <div class="pl-md-modal-dialog" role="dialog" aria-modal="true"
             aria-labelledby="plMdModalTitle">
            <button type="button" class="pl-md-modal-close"
                    data-close-modal aria-label="Close enquiry form">
                <i class="fas fa-times"></i>
            </button>

            <div class="pl-md-modal-icon">
                <i class="fas fa-envelope-open-text"></i>
            </div>

            <h2 id="plMdModalTitle">Send an Enquiry</h2>
            <p class="pl-md-modal-subtitle">
                Ask Rahul about the Samsung Galaxy Smartphone.
            </p>

            <form id="plMdEnquiryForm">
                <div class="pl-md-form-group">
                    <label for="plMdName">Your Name</label>
                    <input type="text" id="plMdName" name="name"
                           placeholder="Enter your full name" required>
                </div>

                <div class="pl-md-form-group">
                    <label for="plMdEmail">Email Address</label>
                    <input type="email" id="plMdEmail" name="email"
                           placeholder="Enter your email" required>
                </div>

                <div class="pl-md-form-group">
                    <label for="plMdPhone">Phone Number (Optional)</label>
                    <input type="tel" id="plMdPhone" name="phone"
                           placeholder="Enter your phone number">
                </div>

                <div class="pl-md-form-group">
                    <label for="plMdMessage">Your Message</label>
                    <textarea id="plMdMessage" name="message" rows="4"
                              placeholder="I am interested in this listing. Please share more details."
                              required></textarea>
                </div>

                <button type="submit" class="pl-md-submit-enquiry">
                    Send Enquiry
                    <i class="fas fa-paper-plane"></i>
                </button>
                <p class="pl-md-form-note">
                    Connect this form to your server-side enquiry handler.
                </p>
            </form>
        </div>
    </div>

    <!-- Report Modal -->
    <div class="pl-md-modal" id="plMdReportModal" aria-hidden="true">
        <div class="pl-md-modal-backdrop" data-close-modal></div>

        <div class="pl-md-modal-dialog" role="dialog" aria-modal="true"
             aria-labelledby="plMdReportTitle">
            <button type="button" class="pl-md-modal-close"
                    data-close-modal aria-label="Close report form">
                <i class="fas fa-times"></i>
            </button>

            <div class="pl-md-modal-icon pl-md-report-icon">
                <i class="fas fa-flag"></i>
            </div>

            <h2 id="plMdReportTitle">Report this Listing</h2>
            <p class="pl-md-modal-subtitle">
                Tell us why this listing needs review.
            </p>

            <form id="plMdReportForm">
                <div class="pl-md-form-group">
                    <label for="plMdReportReason">Reason for Report</label>
                    <select id="plMdReportReason" required>
                        <option value="">Select a reason</option>
                        <option value="misleading">Misleading information</option>
                        <option value="spam">Spam or duplicate listing</option>
                        <option value="fraud">Suspected fraud</option>
                        <option value="prohibited">Prohibited item</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="pl-md-form-group">
                    <label for="plMdReportMessage">Additional Details</label>
                    <textarea id="plMdReportMessage" rows="3"
                              placeholder="Additional details (optional)"></textarea>
                </div>

                <button type="submit" class="pl-md-submit-enquiry">
                    Submit Report
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="pl-md-toast" id="plMdToast"
         role="status" aria-live="polite"></div>

</main>

 

<?php include 'footer.php'; ?>
 