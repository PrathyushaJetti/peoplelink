<?php include 'header.php'; ?>

<main class="pl-directory-results-page">
    <!-- Hero / Search -->
    <section class="pl-results-hero">
        <div class="pl-results-container">
            <div class="pl-results-hero-copy">
                <span class="pl-results-eyebrow">
                    <i class="bi bi-people-fill" aria-hidden="true"></i>
                    PEOPLELINK DIRECTORY
                </span>
                <h1>Find the right people. <span>Build meaningful connections.</span></h1>
                <p>Discover trusted professionals and businesses across your community and beyond.</p>
            </div>

            <form class="pl-results-search" action="professional-and-business-directory-search-results.php" method="get">
                <label class="pl-results-search-field">
                    <i class="bi bi-search" aria-hidden="true"></i>
                    <span class="visually-hidden">Search keyword</span>
                    <input type="search" name="keyword" placeholder="Name, service or keyword">
                </label>

                <label class="pl-results-search-field">
                    <i class="bi bi-grid" aria-hidden="true"></i>
                    <span class="visually-hidden">Category</span>
                    <input type="text" name="category" placeholder="Category">
                </label>

                <label class="pl-results-search-field">
                    <i class="bi bi-geo-alt" aria-hidden="true"></i>
                    <span class="visually-hidden">Location</span>
                    <input type="text" name="location" placeholder="City or location">
                </label>

                <button class="pl-results-search-button" type="submit">
                    <i class="bi bi-search" aria-hidden="true"></i> Search
                </button>
            </form>
        </div>
    </section>

    <!-- Results -->
    <section class="pl-results-content">
        <div class="pl-results-container">
            <div class="pl-results-heading-row">
                <div>
                    <div class="pl-results-breadcrumb">
                        <a href="community-dashboard.php">Home</a>
                        <i class="bi bi-chevron-right" aria-hidden="true"></i>
                        <span>Directory Listings</span>
                    </div>
                    <h2>Directory Listings</h2>
                    <p class="pl-results-subtitle">Explore professionals and businesses in the PeopleLink network.</p>
                </div>

                <a class="pl-results-edit-button" href="professional-and-business-directory-search.php">
                    <i class="bi bi-sliders" aria-hidden="true"></i> Edit Filters
                </a>
            </div>

            <div class="pl-results-summary">
                <div class="pl-results-count">
                    <span class="pl-results-count-icon"><i class="bi bi-card-list" aria-hidden="true"></i></span>
                    <div>
                        <strong><span id="plResultsCount">6</span> Listings Found</strong>
                        <span>Browse listings matching your interests and location.</span>
                    </div>
                </div>

                <label class="pl-results-sort">
                    <span>Sort by</span>
                    <select id="plResultsSort" aria-label="Sort listings">
                        <option value="relevant">Most Relevant</option>
                        <option value="recent">Recently Added</option>
                        <option value="name">Name A–Z</option>
                        <option value="nearest">Nearest</option>
                    </select>
                </label>
            </div>

            <div class="pl-results-layout">
                <!-- Sidebar Filters -->
                <aside class="pl-results-sidebar" aria-label="Directory filters">
                    <div class="pl-results-filter-card">
                        <div class="pl-results-filter-title">
                            <span class="pl-results-filter-icon"><i class="bi bi-funnel" aria-hidden="true"></i></span>
                            <div>
                                <h3>Refine Results</h3>
                                <p>Find a better match</p>
                            </div>
                        </div>

                        <form id="plResultsFilterForm">
                            <div class="pl-results-filter-group">
                                <span class="pl-results-filter-label">Listing Type</span>
                                <label class="pl-results-radio"><input type="radio" name="type" value="all" checked><span>All listings</span></label>
                                <label class="pl-results-radio"><input type="radio" name="type" value="professional"><span>Professionals</span></label>
                                <label class="pl-results-radio"><input type="radio" name="type" value="business"><span>Businesses</span></label>
                            </div>

                            <div class="pl-results-filter-group">
                                <label class="pl-results-filter-label" for="plFilterCategory">Category</label>
                                <input class="pl-results-input" id="plFilterCategory" type="text" placeholder="e.g. Web Development">
                            </div>

                            <div class="pl-results-filter-group">
                                <label class="pl-results-filter-label" for="plFilterLocation">Location</label>
                                <input class="pl-results-input" id="plFilterLocation" type="text" placeholder="Enter city or state">
                            </div>

                            <div class="pl-results-filter-group">
                                <label class="pl-results-filter-label" for="plFilterCommunity">Community <span>(optional)</span></label>
                                <input class="pl-results-input" id="plFilterCommunity" type="text" placeholder="Community name">
                            </div>

                            <button class="pl-results-apply-filter" type="submit">Apply Filters <i class="bi bi-arrow-right" aria-hidden="true"></i></button>
                            <button class="pl-results-reset-filter" id="plResultsReset" type="reset">Reset all filters</button>
                        </form>
                    </div>

                    <div class="pl-results-help-card">
                        <span class="pl-results-help-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
                        <h3>Grow your network</h3>
                        <p>Help your community discover your professional skills or business.</p>
                        <a href="professional-business-profile.php">Create a Listing <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
                    </div>
                </aside>

                <!-- Listing Results -->
                <div class="pl-results-main">
                    <div class="pl-results-type-tabs" role="group" aria-label="Filter listing type">
                        <button class="is-active" type="button" data-type="all">All Listings <span>6</span></button>
                        <button type="button" data-type="professional">Professionals</button>
                        <button type="button" data-type="business">Businesses</button>
                    </div>

                    <div class="pl-results-list" id="plResultsList">
                        <article class="pl-directory-card" data-type="professional" data-category="Web Development" data-location="Rishikesh, Uttarakhand" data-community="Arya Vysya" data-name="Ananya Sharma" data-date="2026-10-10" data-distance="2.4">
                            <div class="pl-directory-card-avatar"><span>AS</span><span class="pl-directory-type-mark"><i class="bi bi-person-badge" aria-hidden="true"></i></span></div>
                            <div class="pl-directory-card-body">
                                <div class="pl-directory-card-topline"><span class="pl-directory-category">Web Development</span><button class="pl-directory-save" type="button" data-save-id="1" aria-pressed="false"><i class="bi bi-bookmark" aria-hidden="true"></i><span>Save</span></button></div>
                                <h3>Ananya Sharma</h3>
                                <p class="pl-directory-specialization">PHP, WordPress &amp; E-commerce Websites</p>
                                <div class="pl-directory-meta"><span><i class="bi bi-geo-alt" aria-hidden="true"></i>Rishikesh, Uttarakhand</span><span><i class="bi bi-award" aria-hidden="true"></i>6 years of experience</span></div>
                                <p class="pl-directory-description">Helping businesses build responsive websites and practical digital experiences.</p>
                                <div class="pl-directory-community"><i class="bi bi-people" aria-hidden="true"></i> Arya Vysya Community</div>
                                <div class="pl-directory-card-actions"><a class="pl-directory-view" href="professional-profile-details.php">View Profile <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a><a class="pl-directory-contact" href="directory-enquiry.php"><i class="bi bi-chat-dots" aria-hidden="true"></i> Contact / Enquire</a></div>
                            </div>
                        </article>

                        <article class="pl-directory-card" data-type="business" data-category="Design & Marketing" data-location="Dehradun, Uttarakhand" data-community="" data-name="Himalayan Creative Studio" data-date="2026-10-08" data-distance="24">
                            <div class="pl-directory-card-avatar is-business"><span><i class="bi bi-building" aria-hidden="true"></i></span><span class="pl-directory-type-mark"><i class="bi bi-building" aria-hidden="true"></i></span></div>
                            <div class="pl-directory-card-body">
                                <div class="pl-directory-card-topline"><span class="pl-directory-category">Design &amp; Marketing</span><button class="pl-directory-save" type="button" data-save-id="2" aria-pressed="false"><i class="bi bi-bookmark" aria-hidden="true"></i><span>Save</span></button></div>
                                <h3>Himalayan Creative Studio</h3>
                                <p class="pl-directory-specialization">Branding, Social Media &amp; Digital Marketing</p>
                                <div class="pl-directory-meta"><span><i class="bi bi-geo-alt" aria-hidden="true"></i>Dehradun, Uttarakhand</span><span><i class="bi bi-award" aria-hidden="true"></i>8 years in business</span></div>
                                <p class="pl-directory-description">A creative studio supporting local and growing brands with digital marketing.</p>
                                <div class="pl-directory-card-actions"><a class="pl-directory-view" href="business-profile-details.php">View Profile <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a><a class="pl-directory-contact" href="directory-enquiry.php"><i class="bi bi-chat-dots" aria-hidden="true"></i> Contact / Enquire</a></div>
                            </div>
                        </article>

                        <article class="pl-directory-card" data-type="professional" data-category="Accounting & Finance" data-location="Hyderabad, Telangana" data-community="Reddy" data-name="Rahul Reddy" data-date="2026-10-05" data-distance="1450">
                            <div class="pl-directory-card-avatar"><span>RR</span><span class="pl-directory-type-mark"><i class="bi bi-person-badge" aria-hidden="true"></i></span></div>
                            <div class="pl-directory-card-body">
                                <div class="pl-directory-card-topline"><span class="pl-directory-category">Accounting &amp; Finance</span><button class="pl-directory-save" type="button" data-save-id="3" aria-pressed="false"><i class="bi bi-bookmark" aria-hidden="true"></i><span>Save</span></button></div>
                                <h3>Rahul Reddy</h3>
                                <p class="pl-directory-specialization">Tax Planning, GST &amp; Business Accounting</p>
                                <div class="pl-directory-meta"><span><i class="bi bi-geo-alt" aria-hidden="true"></i>Hyderabad, Telangana</span><span><i class="bi bi-award" aria-hidden="true"></i>9 years of experience</span></div>
                                <p class="pl-directory-description">Providing accounting support and clear financial guidance for small businesses.</p>
                                <div class="pl-directory-community"><i class="bi bi-people" aria-hidden="true"></i> Reddy Community</div>
                                <div class="pl-directory-card-actions"><a class="pl-directory-view" href="professional-profile-details.php">View Profile <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a><a class="pl-directory-contact" href="directory-enquiry.php"><i class="bi bi-chat-dots" aria-hidden="true"></i> Contact / Enquire</a></div>
                            </div>
                        </article>

                        <article class="pl-directory-card" data-type="business" data-category="Food & Retail" data-location="Haridwar, Uttarakhand" data-community="Kamma" data-name="Green Basket Foods" data-date="2026-09-29" data-distance="32.5">
                            <div class="pl-directory-card-avatar is-business"><span><i class="bi bi-shop" aria-hidden="true"></i></span><span class="pl-directory-type-mark"><i class="bi bi-building" aria-hidden="true"></i></span></div>
                            <div class="pl-directory-card-body">
                                <div class="pl-directory-card-topline"><span class="pl-directory-category">Food &amp; Retail</span><button class="pl-directory-save" type="button" data-save-id="4" aria-pressed="false"><i class="bi bi-bookmark" aria-hidden="true"></i><span>Save</span></button></div>
                                <h3>Green Basket Foods</h3>
                                <p class="pl-directory-specialization">Fresh Produce, Grocery &amp; Local Delivery</p>
                                <div class="pl-directory-meta"><span><i class="bi bi-geo-alt" aria-hidden="true"></i>Haridwar, Uttarakhand</span><span><i class="bi bi-award" aria-hidden="true"></i>5 years in business</span></div>
                                <p class="pl-directory-description">A local retail business focused on fresh produce and convenient neighbourhood delivery.</p>
                                <div class="pl-directory-community"><i class="bi bi-people" aria-hidden="true"></i> Kamma Community</div>
                                <div class="pl-directory-card-actions"><a class="pl-directory-view" href="business-profile-details.php">View Profile <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a><a class="pl-directory-contact" href="directory-enquiry.php"><i class="bi bi-chat-dots" aria-hidden="true"></i> Contact / Enquire</a></div>
                            </div>
                        </article>

                        <article class="pl-directory-card" data-type="professional" data-category="Human Resources" data-location="Bengaluru, Karnataka" data-community="Kapu" data-name="Priya Naidu" data-date="2026-09-24" data-distance="2200">
                            <div class="pl-directory-card-avatar"><span>PN</span><span class="pl-directory-type-mark"><i class="bi bi-person-badge" aria-hidden="true"></i></span></div>
                            <div class="pl-directory-card-body">
                                <div class="pl-directory-card-topline"><span class="pl-directory-category">Human Resources</span><button class="pl-directory-save" type="button" data-save-id="5" aria-pressed="false"><i class="bi bi-bookmark" aria-hidden="true"></i><span>Save</span></button></div>
                                <h3>Priya Naidu</h3>
                                <p class="pl-directory-specialization">Recruitment, HR Operations &amp; Career Guidance</p>
                                <div class="pl-directory-meta"><span><i class="bi bi-geo-alt" aria-hidden="true"></i>Bengaluru, Karnataka</span><span><i class="bi bi-award" aria-hidden="true"></i>7 years of experience</span></div>
                                <p class="pl-directory-description">Supporting candidates and businesses with recruitment and people operations.</p>
                                <div class="pl-directory-community"><i class="bi bi-people" aria-hidden="true"></i> Kapu Community</div>
                                <div class="pl-directory-card-actions"><a class="pl-directory-view" href="professional-profile-details.php">View Profile <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a><a class="pl-directory-contact" href="directory-enquiry.php"><i class="bi bi-chat-dots" aria-hidden="true"></i> Contact / Enquire</a></div>
                            </div>
                        </article>

                        <article class="pl-directory-card" data-type="business" data-category="Home & Repair Services" data-location="Rishikesh, Uttarakhand" data-community="" data-name="Reliable Home Services" data-date="2026-09-18" data-distance="4.1">
                            <div class="pl-directory-card-avatar is-business"><span><i class="bi bi-tools" aria-hidden="true"></i></span><span class="pl-directory-type-mark"><i class="bi bi-building" aria-hidden="true"></i></span></div>
                            <div class="pl-directory-card-body">
                                <div class="pl-directory-card-topline"><span class="pl-directory-category">Home &amp; Repair Services</span><button class="pl-directory-save" type="button" data-save-id="6" aria-pressed="false"><i class="bi bi-bookmark" aria-hidden="true"></i><span>Save</span></button></div>
                                <h3>Reliable Home Services</h3>
                                <p class="pl-directory-specialization">Electrical, Plumbing &amp; Maintenance</p>
                                <div class="pl-directory-meta"><span><i class="bi bi-geo-alt" aria-hidden="true"></i>Rishikesh, Uttarakhand</span><span><i class="bi bi-award" aria-hidden="true"></i>4 years in business</span></div>
                                <p class="pl-directory-description">A local service team for everyday home repairs and maintenance requirements.</p>
                                <div class="pl-directory-card-actions"><a class="pl-directory-view" href="business-profile-details.php">View Profile <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a><a class="pl-directory-contact" href="directory-enquiry.php"><i class="bi bi-chat-dots" aria-hidden="true"></i> Contact / Enquire</a></div>
                            </div>
                        </article>
                    </div>

                    <div class="pl-results-empty" id="plResultsEmpty" hidden>
                        <span class="pl-results-empty-icon"><i class="bi bi-search" aria-hidden="true"></i></span>
                        <h3>No matching professionals or businesses found.</h3>
                        <p>Try changing your keyword, category or location, or clear your filters to explore all listings.</p>
                        <div class="pl-results-empty-actions">
                            <button class="pl-directory-view" id="plModifyFilters" type="button"><i class="bi bi-sliders" aria-hidden="true"></i> Modify Filters</button>
                            <button class="pl-directory-contact" id="plViewAll" type="button">View All Listings</button>
                        </div>
                    </div>

                    <div class="pl-results-load-more-wrap" id="plLoadMoreWrap">
                        <button class="pl-results-load-more" id="plResultsLoadMore" type="button">Load More Listings <i class="bi bi-arrow-down-circle" aria-hidden="true"></i></button>
                        <p class="pl-results-load-note" id="plResultsLoadNote">Showing 6 matching listings.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
