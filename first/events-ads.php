<?php include 'header.php'; ?>

 

<main class="pl-events-page">

    <!-- HERO -->
    <section class="pl-events-hero">
        <div class="pl-events-container">
            <div class="pl-events-hero-content">
                <span class="pl-events-eyebrow">
                    <i class="bi bi-calendar2-event"></i>
                    PeopleLink Events & Advertisements
                </span>

                <h1>Stay Connected With<br><span>What’s Happening</span></h1>

                <p>
                    Discover community events, celebrations, business promotions,
                    announcements and advertisements through one connected PeopleLink platform.
                </p>

                <div class="pl-events-hero-buttons">
                    <a href="#eventsListing" class="pl-btn pl-btn-primary">
                        <i class="bi bi-compass"></i>
                        Explore Events & Ads
                    </a>

                    <button class="pl-btn pl-btn-light" onclick="openPostModal()">
                        <i class="bi bi-plus-circle"></i>
                        Post Event / Advertisement
                    </button>
                </div>

                <div class="pl-events-hero-stats">
                    <div>
                        <strong>120+</strong>
                        <span>Active Posts</span>
                    </div>
                    <div>
                        <strong>35+</strong>
                        <span>Communities</span>
                    </div>
                    <div>
                        <strong>18</strong>
                        <span>Event Categories</span>
                    </div>
                </div>
            </div>

            <div class="pl-events-hero-visual">
                <div class="pl-events-main-image">
                    <img src="https://images.unsplash.com/photo-1507504031003-b417219a0fde?auto=format&fit=crop&w=1000&q=85"
                         alt="Community event">
                </div>

                <div class="pl-floating-event-card">
                    <span class="pl-floating-icon">
                        <i class="bi bi-calendar-check"></i>
                    </span>
                    <div>
                        <strong>Community Events</strong>
                        <small>Discover • Participate • Connect</small>
                    </div>
                </div>

                <div class="pl-floating-ad-card">
                    <i class="bi bi-megaphone"></i>
                    <span>Promote Your Business</span>
                </div>
            </div>
        </div>
    </section>


    <!-- BROWSE BY TYPE -->
    <section class="pl-section pl-browse-section">
        <div class="pl-events-container">

            <div class="pl-section-heading">
                <div>
                    <span class="pl-section-label">EXPLORE</span>
                    <h2>Browse by Type</h2>
                    <p>Find events, celebrations, promotions and community announcements.</p>
                </div>
            </div>

            <div class="pl-category-grid">

                <button class="pl-category-item" data-category="Community Events">
                    <span><i class="bi bi-people"></i></span>
                    <strong>Community Events</strong>
                </button>

                <button class="pl-category-item" data-category="Cultural Programs">
                    <span><i class="bi bi-music-note-beamed"></i></span>
                    <strong>Cultural Programs</strong>
                </button>

                <button class="pl-category-item" data-category="Festivals">
                    <span><i class="bi bi-stars"></i></span>
                    <strong>Festivals</strong>
                </button>

                <button class="pl-category-item" data-category="Meetings">
                    <span><i class="bi bi-person-video2"></i></span>
                    <strong>Meetings</strong>
                </button>

                <button class="pl-category-item" data-category="Weddings & Celebrations">
                    <span><i class="bi bi-balloon-heart"></i></span>
                    <strong>Weddings & Celebrations</strong>
                </button>

                <button class="pl-category-item" data-category="Business Promotions">
                    <span><i class="bi bi-shop"></i></span>
                    <strong>Business Promotions</strong>
                </button>

                <button class="pl-category-item" data-category="Product Launches">
                    <span><i class="bi bi-box-seam"></i></span>
                    <strong>Product Launches</strong>
                </button>

                <button class="pl-category-item" data-category="Public Announcements">
                    <span><i class="bi bi-megaphone"></i></span>
                    <strong>Public Announcements</strong>
                </button>

                <button class="pl-category-item" data-category="Social Initiatives">
                    <span><i class="bi bi-heart"></i></span>
                    <strong>Social Initiatives</strong>
                </button>

                <button class="pl-category-item" data-category="Other Approved Posts">
                    <span><i class="bi bi-grid"></i></span>
                    <strong>Other Approved Posts</strong>
                </button>

            </div>
        </div>
    </section>


    <!-- SEARCH FILTER -->
    <section class="pl-filter-section">
        <div class="pl-events-container">

            <div class="pl-filter-box">

                <div class="pl-filter-title">
                    <span class="pl-filter-icon">
                        <i class="bi bi-funnel"></i>
                    </span>
                    <div>
                        <h3>Search & Filters</h3>
                        <p>Refine events and advertisements to find what you need.</p>
                    </div>
                </div>

                <div class="pl-filter-grid">

                    <div class="pl-form-group">
                        <label>Search</label>
                        <div class="pl-input-icon">
                            <i class="bi bi-search"></i>
                            <input type="text"
                                   id="eventSearch"
                                   placeholder="Search events, businesses...">
                        </div>
                    </div>

                    <div class="pl-form-group">
                        <label>Category</label>
                        <select id="categoryFilter">
                            <option value="">All Categories</option>
                            <option>Community Events</option>
                            <option>Cultural Programs</option>
                            <option>Festivals</option>
                            <option>Meetings</option>
                            <option>Weddings & Celebrations</option>
                            <option>Business Promotions</option>
                            <option>Product Launches</option>
                            <option>Public Announcements</option>
                            <option>Social Initiatives</option>
                        </select>
                    </div>

                    <div class="pl-form-group">
                        <label>Community</label>
                        <select id="communityFilter">
                            <option value="">All Communities</option>
                            <option>Arya Vysya</option>
                            <option>Reddy</option>
                            <option>Kamma</option>
                            <option>Kapu</option>
                            <option>Banjara</option>
                            <option>Yadava</option>
                            <option>Padmashali</option>
                            <option>Goud</option>
                            <option>Chakali</option>
                            <option>Mudiraj</option>
                            <option>Viswakarma</option>
                            <option>Other Communities</option>
                        </select>
                    </div>

                    <div class="pl-form-group">
                        <label>Location</label>
                        <input type="text" id="locationFilter" placeholder="City / Area">
                    </div>

                    <div class="pl-form-group">
                        <label>Date</label>
                        <input type="date" id="dateFilter">
                    </div>

                    <div class="pl-form-group">
                        <label>Event Type</label>
                        <select id="eventTypeFilter">
                            <option value="">All Event Types</option>
                            <option>Community Event</option>
                            <option>Cultural Program</option>
                            <option>Festival</option>
                            <option>Meeting</option>
                            <option>Celebration</option>
                            <option>Social Initiative</option>
                        </select>
                    </div>

                    <div class="pl-form-group">
                        <label>Advertisement Type</label>
                        <select id="adTypeFilter">
                            <option value="">All Advertisement Types</option>
                            <option>Business Promotion</option>
                            <option>Product Launch</option>
                            <option>Service Advertisement</option>
                            <option>Public Announcement</option>
                        </select>
                    </div>

                    <div class="pl-form-group">
                        <label>Visibility</label>
                        <select id="visibilityFilter">
                            <option value="">Global & Community</option>
                            <option value="Global">Global</option>
                            <option value="Community">Community-Specific</option>
                        </select>
                    </div>

                </div>

                <div class="pl-filter-actions">
                    <button class="pl-btn pl-btn-primary" onclick="applyFilters()">
                        <i class="bi bi-funnel"></i>
                        Apply Filters
                    </button>

                    <button class="pl-btn pl-btn-outline" onclick="resetFilters()">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Filters
                    </button>
                </div>

            </div>

        </div>
    </section>


    <!-- FEATURED -->
    <section class="pl-section pl-featured-section" id="eventsListing">
        <div class="pl-events-container">

            <div class="pl-section-heading pl-heading-flex">
                <div>
                    <span class="pl-section-label">DISCOVER</span>
                    <h2>Featured Events & Advertisements</h2>
                    <p>Explore approved community activities and business promotions.</p>
                </div>

                <div class="pl-results-count">
                    <span id="resultCount">6</span> Posts
                </div>
            </div>


            <div class="pl-events-grid" id="eventsGrid">

                <!-- CARD 1 -->
                <article class="pl-event-card"
                         data-category="Community Events"
                         data-community="Arya Vysya"
                         data-location="Delhi"
                         data-visibility="Community"
                         data-type="Community Event">

                    <div class="pl-card-image">
                        <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=900&q=85"
                             alt="Community event">

                        <span class="pl-card-type event">
                            <i class="bi bi-calendar-event"></i>
                            Community Event
                        </span>

                        <button class="pl-save-btn" onclick="savePost(this)" aria-label="Save event">
                            <i class="bi bi-bookmark"></i>
                        </button>
                    </div>

                    <div class="pl-card-content">

                        <div class="pl-visibility-row">
                            <span class="pl-community-badge">
                                <i class="bi bi-people"></i> Arya Vysya
                            </span>
                            <span class="pl-approved">
                                <i class="bi bi-check-circle-fill"></i> Approved
                            </span>
                        </div>

                        <h3>Annual Community Gathering 2026</h3>

                        <div class="pl-card-meta">
                            <span><i class="bi bi-calendar3"></i> 18 October 2026</span>
                            <span><i class="bi bi-clock"></i> 5:00 PM</span>
                            <span><i class="bi bi-geo-alt"></i> New Delhi</span>
                        </div>

                        <p>
                            Join community members for an evening of networking,
                            cultural activities and meaningful connections.
                        </p>

                        <div class="pl-card-footer">
                            <div class="pl-posted-by">
                                <div class="pl-mini-avatar">AV</div>
                                <div>
                                    <small>Posted By</small>
                                    <strong>Arya Vysya Community</strong>
                                </div>
                            </div>

                            <button class="pl-view-btn"
                                    onclick="viewDetails('Annual Community Gathering 2026')">
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>

                    </div>
                </article>


                <!-- CARD 2 -->
                <article class="pl-event-card"
                         data-category="Cultural Programs"
                         data-community="Reddy"
                         data-location="Hyderabad"
                         data-visibility="Community"
                         data-type="Cultural Program">

                    <div class="pl-card-image">
                        <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=900&q=85"
                             alt="Cultural program">

                        <span class="pl-card-type event">
                            <i class="bi bi-music-note-beamed"></i>
                            Cultural Program
                        </span>

                        <button class="pl-save-btn" onclick="savePost(this)">
                            <i class="bi bi-bookmark"></i>
                        </button>
                    </div>

                    <div class="pl-card-content">

                        <div class="pl-visibility-row">
                            <span class="pl-community-badge">
                                <i class="bi bi-people"></i> Reddy
                            </span>
                            <span class="pl-approved">
                                <i class="bi bi-check-circle-fill"></i> Approved
                            </span>
                        </div>

                        <h3>Heritage & Cultural Evening</h3>

                        <div class="pl-card-meta">
                            <span><i class="bi bi-calendar3"></i> 24 October 2026</span>
                            <span><i class="bi bi-clock"></i> 6:30 PM</span>
                            <span><i class="bi bi-geo-alt"></i> Hyderabad</span>
                        </div>

                        <p>
                            Experience cultural performances, traditional programs
                            and community interaction.
                        </p>

                        <div class="pl-card-footer">
                            <div class="pl-posted-by">
                                <div class="pl-mini-avatar">RC</div>
                                <div>
                                    <small>Posted By</small>
                                    <strong>Reddy Community</strong>
                                </div>
                            </div>

                            <button class="pl-view-btn"
                                    onclick="viewDetails('Heritage & Cultural Evening')">
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>

                    </div>
                </article>


                <!-- CARD 3 -->
                <article class="pl-event-card"
                         data-category="Business Promotions"
                         data-community=""
                         data-location="Mumbai"
                         data-visibility="Global"
                         data-type="Business Promotion">

                    <div class="pl-card-image">
                        <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=900&q=85"
                             alt="Business promotion">

                        <span class="pl-card-type advertisement">
                            <i class="bi bi-megaphone"></i>
                            Business Promotion
                        </span>

                        <button class="pl-save-btn" onclick="savePost(this)">
                            <i class="bi bi-bookmark"></i>
                        </button>
                    </div>

                    <div class="pl-card-content">

                        <div class="pl-visibility-row">
                            <span class="pl-global-badge">
                                <i class="bi bi-globe2"></i> Global
                            </span>
                            <span class="pl-approved">
                                <i class="bi bi-check-circle-fill"></i> Approved
                            </span>
                        </div>

                        <h3>Special Business Launch Offer</h3>

                        <div class="pl-card-meta">
                            <span><i class="bi bi-calendar3"></i> Until 31 Oct 2026</span>
                            <span><i class="bi bi-geo-alt"></i> Mumbai</span>
                        </div>

                        <p>
                            Explore a special introductory offer from a PeopleLink
                            business member.
                        </p>

                        <div class="pl-card-footer">
                            <div class="pl-posted-by">
                                <div class="pl-mini-avatar">PB</div>
                                <div>
                                    <small>Posted By</small>
                                    <strong>PeopleLink Business</strong>
                                </div>
                            </div>

                            <button class="pl-view-btn"
                                    onclick="viewDetails('Special Business Launch Offer')">
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>

                    </div>
                </article>


                <!-- CARD 4 -->
                <article class="pl-event-card"
                         data-category="Social Initiatives"
                         data-community="Kamma"
                         data-location="Vijayawada"
                         data-visibility="Community"
                         data-type="Social Initiative">

                    <div class="pl-card-image">
                        <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?auto=format&fit=crop&w=900&q=85"
                             alt="Social initiative">

                        <span class="pl-card-type event">
                            <i class="bi bi-heart"></i>
                            Social Initiative
                        </span>

                        <button class="pl-save-btn" onclick="savePost(this)">
                            <i class="bi bi-bookmark"></i>
                        </button>
                    </div>

                    <div class="pl-card-content">

                        <div class="pl-visibility-row">
                            <span class="pl-community-badge">
                                <i class="bi bi-people"></i> Kamma
                            </span>
                            <span class="pl-approved">
                                <i class="bi bi-check-circle-fill"></i> Approved
                            </span>
                        </div>

                        <h3>Community Service Initiative</h3>

                        <div class="pl-card-meta">
                            <span><i class="bi bi-calendar3"></i> 26 October 2026</span>
                            <span><i class="bi bi-clock"></i> 9:00 AM</span>
                            <span><i class="bi bi-geo-alt"></i> Vijayawada</span>
                        </div>

                        <p>
                            Community members come together for a social service
                            and neighbourhood support initiative.
                        </p>

                        <div class="pl-card-footer">
                            <div class="pl-posted-by">
                                <div class="pl-mini-avatar">KC</div>
                                <div>
                                    <small>Posted By</small>
                                    <strong>Kamma Community</strong>
                                </div>
                            </div>

                            <button class="pl-view-btn"
                                    onclick="viewDetails('Community Service Initiative')">
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>

                    </div>
                </article>


                <!-- CARD 5 -->
                <article class="pl-event-card"
                         data-category="Product Launches"
                         data-community=""
                         data-location="Bengaluru"
                         data-visibility="Global"
                         data-type="Product Launch">

                    <div class="pl-card-image">
                        <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?auto=format&fit=crop&w=900&q=85"
                             alt="Product launch">

                        <span class="pl-card-type advertisement">
                            <i class="bi bi-box-seam"></i>
                            Product Launch
                        </span>

                        <button class="pl-save-btn" onclick="savePost(this)">
                            <i class="bi bi-bookmark"></i>
                        </button>
                    </div>

                    <div class="pl-card-content">

                        <div class="pl-visibility-row">
                            <span class="pl-global-badge">
                                <i class="bi bi-globe2"></i> Global
                            </span>
                            <span class="pl-approved">
                                <i class="bi bi-check-circle-fill"></i> Approved
                            </span>
                        </div>

                        <h3>New Product Launch</h3>

                        <div class="pl-card-meta">
                            <span><i class="bi bi-calendar3"></i> 30 October 2026</span>
                            <span><i class="bi bi-geo-alt"></i> Bengaluru</span>
                        </div>

                        <p>
                            Discover a new product launch promoted by a verified
                            PeopleLink business member.
                        </p>

                        <div class="pl-card-footer">
                            <div class="pl-posted-by">
                                <div class="pl-mini-avatar">BL</div>
                                <div>
                                    <small>Posted By</small>
                                    <strong>Business Member</strong>
                                </div>
                            </div>

                            <button class="pl-view-btn"
                                    onclick="viewDetails('New Product Launch')">
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>

                    </div>
                </article>


                <!-- CARD 6 -->
                <article class="pl-event-card"
                         data-category="Public Announcements"
                         data-community=""
                         data-location="Delhi"
                         data-visibility="Global"
                         data-type="Public Announcement">

                    <div class="pl-card-image">
                        <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=900&q=85"
                             alt="Public announcement">

                        <span class="pl-card-type advertisement">
                            <i class="bi bi-megaphone"></i>
                            Public Announcement
                        </span>

                        <button class="pl-save-btn" onclick="savePost(this)">
                            <i class="bi bi-bookmark"></i>
                        </button>
                    </div>

                    <div class="pl-card-content">

                        <div class="pl-visibility-row">
                            <span class="pl-global-badge">
                                <i class="bi bi-globe2"></i> Global
                            </span>
                            <span class="pl-approved">
                                <i class="bi bi-check-circle-fill"></i> Approved
                            </span>
                        </div>

                        <h3>PeopleLink Platform Announcement</h3>

                        <div class="pl-card-meta">
                            <span><i class="bi bi-calendar3"></i> October 2026</span>
                            <span><i class="bi bi-geo-alt"></i> PeopleLink</span>
                        </div>

                        <p>
                            Important platform information and approved announcements
                            for eligible PeopleLink users.
                        </p>

                        <div class="pl-card-footer">
                            <div class="pl-posted-by">
                                <div class="pl-mini-avatar">PL</div>
                                <div>
                                    <small>Posted By</small>
                                    <strong>PeopleLink Admin</strong>
                                </div>
                            </div>

                            <button class="pl-view-btn"
                                    onclick="viewDetails('PeopleLink Platform Announcement')">
                                View Details
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>

                    </div>
                </article>

            </div>

            <div class="pl-no-results" id="noResults">
                <div class="pl-no-results-icon">
                    <i class="bi bi-search"></i>
                </div>
                <h3>No Matching Posts Found</h3>
                <p>Try changing your filters or search criteria.</p>
                <button class="pl-btn pl-btn-primary" onclick="resetFilters()">
                    Reset Filters
                </button>
            </div>

        </div>
    </section>


    <!-- COMMUNITY / GLOBAL -->
    <section class="pl-section pl-visibility-section">
        <div class="pl-events-container">

            <div class="pl-section-heading">
                <span class="pl-section-label">VISIBILITY</span>
                <h2>Community-Specific & Global</h2>
                <p>Content visibility can be controlled by authorised administrators.</p>
            </div>

            <div class="pl-visibility-grid">

                <div class="pl-visibility-box community">
                    <div class="pl-visibility-icon">
                        <i class="bi bi-people"></i>
                    </div>

                    <span class="pl-box-label">COMMUNITY-SPECIFIC</span>

                    <h3>For Your Community</h3>

                    <p>
                        Content marked as Community-Specific will appear only
                        within the relevant community.
                    </p>

                    <div class="pl-example-list">
                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                            Arya Vysya Event → Arya Vysya users
                        </div>
                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                            Reddy Advertisement → Reddy users
                        </div>
                    </div>
                </div>

                <div class="pl-visibility-box global">
                    <div class="pl-visibility-icon">
                        <i class="bi bi-globe2"></i>
                    </div>

                    <span class="pl-box-label">GLOBAL VISIBILITY</span>

                    <h3>Across PeopleLink</h3>

                    <p>
                        Global content can be shown across the platform to
                        eligible users from multiple communities.
                    </p>

                    <div class="pl-example-list">
                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                            Business Promotions
                        </div>
                        <div>
                            <i class="bi bi-check-circle-fill"></i>
                            Public Announcements
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- REGISTRATION / ENQUIRY -->
    <section class="pl-section pl-action-section">
        <div class="pl-events-container">

            <div class="pl-action-grid">

                <div class="pl-action-content">
                    <span class="pl-section-label">PARTICIPATE</span>
                    <h2>Event Registration</h2>

                    <p>
                        Where applicable, users can register for an event
                        directly through PeopleLink.
                    </p>

                    <div class="pl-registration-fields">
                        <span><i class="bi bi-person"></i> Name</span>
                        <span><i class="bi bi-phone"></i> Mobile Number</span>
                        <span><i class="bi bi-envelope"></i> Email</span>
                        <span><i class="bi bi-people"></i> Participants</span>
                        <span><i class="bi bi-chat-text"></i> Additional Information</span>
                    </div>

                    <button class="pl-btn pl-btn-primary"
                            onclick="openRegistrationModal()">
                        <i class="bi bi-ticket-perforated"></i>
                        Register for Event
                    </button>
                </div>

                <div class="pl-action-content ad-action">
                    <span class="pl-section-label">PROMOTE</span>
                    <h2>Advertisement Enquiry</h2>

                    <p>
                        Contact businesses and advertisers directly about
                        their promotional listings.
                    </p>

                    <div class="pl-ad-actions">
                        <button class="pl-btn pl-btn-primary"
                                onclick="openEnquiryModal()">
                            <i class="bi bi-send"></i>
                            Send Enquiry
                        </button>

                        <button class="pl-btn pl-btn-outline"
                                onclick="showToast('Contact details will be available for eligible listings.')">
                            <i class="bi bi-telephone"></i>
                            Contact Advertiser
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- POST -->
    <section class="pl-post-section">
        <div class="pl-events-container">

            <div class="pl-post-wrapper">

                <div class="pl-post-content">
                    <span class="pl-section-label">CREATE</span>

                    <h2>Post an Event / Advertisement</h2>

                    <p>
                        Authorised users can submit community events,
                        business promotions and approved announcements.
                    </p>

                    <div class="pl-post-fields">
                        <span>Title</span>
                        <span>Category</span>
                        <span>Description</span>
                        <span>Date & Time</span>
                        <span>Location</span>
                        <span>Images</span>
                        <span>Contact Details</span>
                        <span>Visibility</span>
                        <span>Community Selection</span>
                    </div>

                    <div class="pl-post-note">
                        <i class="bi bi-shield-check"></i>
                        Submitted content can go through admin approval
                        before publication.
                    </div>

                    <button class="pl-btn pl-btn-white"
                            onclick="openPostModal()">
                        <i class="bi bi-plus-circle"></i>
                        Create Post
                    </button>
                </div>

                <div class="pl-post-image">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=900&q=85"
                         alt="Create event">
                </div>

            </div>

        </div>
    </section>


    <!-- PACKAGES -->
    <section class="pl-section pl-packages-section">
        <div class="pl-events-container">

            <div class="pl-section-heading text-center">
                <span class="pl-section-label">ADVERTISE</span>
                <h2>Advertisement Packages</h2>
                <p>
                    Where paid advertising is enabled, PeopleLink can offer
                    community and global advertising packages.
                </p>
            </div>

            <div class="pl-package-grid">

                <div class="pl-package-card">
                    <div class="pl-package-icon">
                        <i class="bi bi-people"></i>
                    </div>

                    <span class="pl-package-tag">COMMUNITY</span>

                    <h3>Community Advertisement</h3>

                    <p>
                        Promote your business or approved initiative
                        within a relevant community.
                    </p>

                    <ul>
                        <li><i class="bi bi-check2"></i> Community Visibility</li>
                        <li><i class="bi bi-check2"></i> Duration Options</li>
                        <li><i class="bi bi-check2"></i> Featured Placement</li>
                        <li><i class="bi bi-check2"></i> Post Options</li>
                    </ul>

                    <button class="pl-btn pl-btn-outline"
                            onclick="openPackageModal('Community Advertisement')">
                        View Packages
                    </button>
                </div>


                <div class="pl-package-card featured">
                    <span class="pl-popular">GLOBAL REACH</span>

                    <div class="pl-package-icon">
                        <i class="bi bi-globe2"></i>
                    </div>

                    <span class="pl-package-tag">GLOBAL</span>

                    <h3>Global Advertisement</h3>

                    <p>
                        Reach eligible users across multiple PeopleLink
                        communities and approved sections.
                    </p>

                    <ul>
                        <li><i class="bi bi-check2"></i> Global Visibility</li>
                        <li><i class="bi bi-check2"></i> Featured Position</li>
                        <li><i class="bi bi-check2"></i> Flexible Duration</li>
                        <li><i class="bi bi-check2"></i> Multiple Posts</li>
                    </ul>

                    <button class="pl-btn pl-btn-primary"
                            onclick="openPackageModal('Global Advertisement')">
                        View Packages
                    </button>
                </div>

            </div>

        </div>
    </section>


    <!-- LIVE LINK -->
    <section class="pl-live-section">
        <div class="pl-events-container">

            <div class="pl-live-box">

                <div class="pl-live-icon">
                    <i class="bi bi-broadcast"></i>
                </div>

                <div class="pl-live-content">
                    <span class="pl-section-label">EXTERNAL STREAM</span>
                    <h2>Live Program Link</h2>

                    <p>
                        If an event has an external live-stream link,
                        authorised admins can add the supported third-party
                        link to the event details.
                    </p>

                    <small>
                        PeopleLink does not develop or host its own
                        live-streaming system.
                    </small>
                </div>

                <button class="pl-btn pl-btn-primary"
                        onclick="openLiveLink()">
                    <i class="bi bi-play-circle"></i>
                    View Live Link
                </button>

            </div>

        </div>
    </section>


    <!-- SAVE SHARE -->
    <section class="pl-section pl-save-share-section">
        <div class="pl-events-container">

            <div class="pl-save-share-grid">

                <div>
                    <span class="pl-section-label">YOUR LIST</span>
                    <h2>Save & Share</h2>
                    <p>
                        Logged-in users can save useful events and
                        advertisements for later.
                    </p>
                </div>

                <div class="pl-feature-pills">
                    <span>
                        <i class="bi bi-bookmark-heart"></i>
                        Save Event / Advertisement
                    </span>

                    <span>
                        <i class="bi bi-share"></i>
                        Share Listing
                    </span>

                    <span>
                        <i class="bi bi-bell"></i>
                        Set Reminder
                    </span>
                </div>

            </div>

        </div>
    </section>


    <!-- MODERATION -->
    <section class="pl-section pl-moderation-section">
        <div class="pl-events-container">

            <div class="pl-section-heading text-center">
                <span class="pl-section-label">CONTROL & TRUST</span>
                <h2>Approval & Moderation</h2>
                <p>
                    Only approved content will be visible to users.
                </p>
            </div>

            <div class="pl-status-flow">

                <div class="pl-status-item">
                    <span><i class="bi bi-pencil"></i></span>
                    <strong>Draft</strong>
                </div>

                <i class="bi bi-arrow-right"></i>

                <div class="pl-status-item">
                    <span><i class="bi bi-hourglass-split"></i></span>
                    <strong>Pending Approval</strong>
                </div>

                <i class="bi bi-arrow-right"></i>

                <div class="pl-status-item approved">
                    <span><i class="bi bi-check-lg"></i></span>
                    <strong>Approved</strong>
                </div>

                <i class="bi bi-arrow-right"></i>

                <div class="pl-status-item rejected">
                    <span><i class="bi bi-x-lg"></i></span>
                    <strong>Rejected / Changes</strong>
                </div>

                <i class="bi bi-arrow-right"></i>

                <div class="pl-status-item expired">
                    <span><i class="bi bi-clock-history"></i></span>
                    <strong>Expired</strong>
                </div>

            </div>

        </div>
    </section>


    <!-- FINAL CTA -->
    <section class="pl-events-final-cta">
        <div class="pl-events-container">

            <div class="pl-final-cta-content">

                <div>
                    <span class="pl-section-label">PEOPLELINK</span>
                    <h2>Discover. Participate. Promote.</h2>
                    <p>
                        Stay informed about community activities and promote
                        approved events, businesses and initiatives through PeopleLink.
                    </p>
                </div>

                <div class="pl-final-buttons">
                    <a href="#eventsListing" class="pl-btn pl-btn-white">
                        <i class="bi bi-compass"></i>
                        Explore Events & Ads
                    </a>

                    <button class="pl-btn pl-btn-ghost"
                            onclick="openPostModal()">
                        <i class="bi bi-plus-circle"></i>
                        Post Event / Advertisement
                    </button>

                    <button class="pl-btn pl-btn-ghost"
                            onclick="document.querySelector('.pl-packages-section').scrollIntoView({behavior:'smooth'})">
                        <i class="bi bi-megaphone"></i>
                        View Packages
                    </button>
                </div>

            </div>

        </div>
    </section>

</main>


<!-- REGISTRATION MODAL -->
<div class="pl-modal" id="registrationModal">
    <div class="pl-modal-overlay" onclick="closeModal('registrationModal')"></div>

    <div class="pl-modal-box">

        <button class="pl-modal-close" onclick="closeModal('registrationModal')">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="pl-modal-header">
            <span class="pl-modal-icon">
                <i class="bi bi-ticket-perforated"></i>
            </span>
            <div>
                <span>EVENT REGISTRATION</span>
                <h3>Register for Event</h3>
            </div>
        </div>

        <form id="registrationForm">

            <div class="pl-modal-form-grid">

                <div class="pl-form-group">
                    <label>Name</label>
                    <input type="text" required placeholder="Your name">
                </div>

                <div class="pl-form-group">
                    <label>Mobile Number</label>
                    <input type="tel" required placeholder="Mobile number">
                </div>

                <div class="pl-form-group">
                    <label>Email</label>
                    <input type="email" placeholder="Email address">
                </div>

                <div class="pl-form-group">
                    <label>Participants</label>
                    <input type="number" min="1" value="1">
                </div>

                <div class="pl-form-group full">
                    <label>Additional Information</label>
                    <textarea rows="4"
                              placeholder="Any additional information..."></textarea>
                </div>

            </div>

            <button class="pl-btn pl-btn-primary pl-modal-submit" type="submit">
                <i class="bi bi-check-circle"></i>
                Submit Registration
            </button>

        </form>

    </div>
</div>


<!-- ENQUIRY MODAL -->
<div class="pl-modal" id="enquiryModal">
    <div class="pl-modal-overlay" onclick="closeModal('enquiryModal')"></div>

    <div class="pl-modal-box">

        <button class="pl-modal-close" onclick="closeModal('enquiryModal')">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="pl-modal-header">
            <span class="pl-modal-icon">
                <i class="bi bi-send"></i>
            </span>
            <div>
                <span>ADVERTISEMENT</span>
                <h3>Send Enquiry</h3>
            </div>
        </div>

        <form id="enquiryForm">

            <div class="pl-modal-form-grid">

                <div class="pl-form-group">
                    <label>Your Name</label>
                    <input type="text" required placeholder="Your name">
                </div>

                <div class="pl-form-group">
                    <label>Mobile Number</label>
                    <input type="tel" required placeholder="Mobile number">
                </div>

                <div class="pl-form-group full">
                    <label>Email</label>
                    <input type="email" placeholder="Email address">
                </div>

                <div class="pl-form-group full">
                    <label>Message</label>
                    <textarea rows="5"
                              required
                              placeholder="Write your enquiry..."></textarea>
                </div>

            </div>

            <button class="pl-btn pl-btn-primary pl-modal-submit" type="submit">
                <i class="bi bi-send"></i>
                Send Enquiry
            </button>

        </form>

    </div>
</div>


<!-- POST MODAL -->
<div class="pl-modal" id="postModal">
    <div class="pl-modal-overlay" onclick="closeModal('postModal')"></div>

    <div class="pl-modal-box pl-large-modal">

        <button class="pl-modal-close" onclick="closeModal('postModal')">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="pl-modal-header">
            <span class="pl-modal-icon">
                <i class="bi bi-plus-circle"></i>
            </span>
            <div>
                <span>AUTHORISED USERS</span>
                <h3>Post Event / Advertisement</h3>
            </div>
        </div>

        <form id="postForm">

            <div class="pl-modal-form-grid">

                <div class="pl-form-group full">
                    <label>Title</label>
                    <input type="text" required placeholder="Enter title">
                </div>

                <div class="pl-form-group">
                    <label>Category</label>
                    <select required>
                        <option value="">Select Category</option>
                        <option>Community Events</option>
                        <option>Cultural Programs</option>
                        <option>Festivals</option>
                        <option>Meetings</option>
                        <option>Weddings & Celebrations</option>
                        <option>Business Promotions</option>
                        <option>Product Launches</option>
                        <option>Public Announcements</option>
                        <option>Social Initiatives</option>
                    </select>
                </div>

                <div class="pl-form-group">
                    <label>Post Type</label>
                    <select required>
                        <option value="">Select Type</option>
                        <option>Event</option>
                        <option>Advertisement</option>
                    </select>
                </div>

                <div class="pl-form-group">
                    <label>Date</label>
                    <input type="date">
                </div>

                <div class="pl-form-group">
                    <label>Time</label>
                    <input type="time">
                </div>

                <div class="pl-form-group">
                    <label>Location</label>
                    <input type="text" placeholder="Location / City">
                </div>

                <div class="pl-form-group">
                    <label>Contact Details</label>
                    <input type="text" placeholder="Phone / Email">
                </div>

                <div class="pl-form-group full">
                    <label>Description</label>
                    <textarea rows="5"
                              required
                              placeholder="Describe your event or advertisement..."></textarea>
                </div>

                <div class="pl-form-group">
                    <label>Visibility</label>
                    <select id="postVisibility" onchange="toggleCommunityField()">
                        <option value="Global">Global</option>
                        <option value="Community">Community-Specific</option>
                    </select>
                </div>

                <div class="pl-form-group" id="communityField">
                    <label>Community</label>
                    <select>
                        <option value="">Select Community</option>
                        <option>Arya Vysya</option>
                        <option>Reddy</option>
                        <option>Kamma</option>
                        <option>Kapu</option>
                        <option>Banjara</option>
                        <option>Yadava</option>
                        <option>Padmashali</option>
                        <option>Goud</option>
                        <option>Chakali</option>
                        <option>Mudiraj</option>
                        <option>Viswakarma</option>
                        <option>Other Communities</option>
                    </select>
                </div>

                <div class="pl-form-group full">
                    <label>Featured Image / Banner</label>
                    <input type="file" accept="image/*">
                    <small class="pl-upload-note">
                        Upload an approved event or advertisement image.
                    </small>
                </div>

                <div class="pl-form-group full">
                    <label>External Live Link <small>(Optional)</small></label>
                    <input type="url"
                           placeholder="https://example.com/live-event">
                </div>

            </div>

            <div class="pl-modal-notice">
                <i class="bi bi-shield-check"></i>
                Your submission may be reviewed and approved by PeopleLink
                administration before publication.
            </div>

            <button class="pl-btn pl-btn-primary pl-modal-submit" type="submit">
                <i class="bi bi-send"></i>
                Submit for Approval
            </button>

        </form>

    </div>
</div>


<!-- PACKAGE MODAL -->
<div class="pl-modal" id="packageModal">
    <div class="pl-modal-overlay" onclick="closeModal('packageModal')"></div>

    <div class="pl-modal-box">

        <button class="pl-modal-close" onclick="closeModal('packageModal')">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="pl-modal-header">
            <span class="pl-modal-icon">
                <i class="bi bi-megaphone"></i>
            </span>
            <div>
                <span>ADVERTISEMENT</span>
                <h3 id="packageModalTitle">Advertisement Packages</h3>
            </div>
        </div>

        <div class="pl-package-modal-content">

            <p>
                Package options can vary based on the approved advertising
                configuration.
            </p>

            <div class="pl-package-options">
                <div>
                    <i class="bi bi-eye"></i>
                    <strong>Visibility</strong>
                </div>

                <div>
                    <i class="bi bi-clock"></i>
                    <strong>Duration</strong>
                </div>

                <div>
                    <i class="bi bi-pin-angle"></i>
                    <strong>Placement</strong>
                </div>

                <div>
                    <i class="bi bi-star"></i>
                    <strong>Featured Position</strong>
                </div>

                <div>
                    <i class="bi bi-files"></i>
                    <strong>Number of Posts</strong>
                </div>
            </div>

            <button class="pl-btn pl-btn-primary"
                    onclick="closeModal('packageModal'); openEnquiryModal();">
                <i class="bi bi-send"></i>
                Enquire About Packages
            </button>

        </div>

    </div>
</div>


<!-- DETAILS MODAL -->
<div class="pl-modal" id="detailsModal">
    <div class="pl-modal-overlay" onclick="closeModal('detailsModal')"></div>

    <div class="pl-modal-box">

        <button class="pl-modal-close" onclick="closeModal('detailsModal')">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="pl-modal-header">
            <span class="pl-modal-icon">
                <i class="bi bi-calendar2-event"></i>
            </span>
            <div>
                <span>PEOPLELINK LISTING</span>
                <h3 id="detailsTitle">Event Details</h3>
            </div>
        </div>

        <div class="pl-details-content">

            <div class="pl-detail-highlight">
                <i class="bi bi-check-circle-fill"></i>
                Approved PeopleLink Content
            </div>

            <p>
                This listing can contain the complete event or advertisement
                information, registration details, contact information,
                location and any supported external links.
            </p>

            <div class="pl-detail-actions">
                <button class="pl-btn pl-btn-primary"
                        onclick="openRegistrationModal(); closeModal('detailsModal');">
                    <i class="bi bi-ticket-perforated"></i>
                    Register
                </button>

                <button class="pl-btn pl-btn-outline"
                        onclick="openEnquiryModal(); closeModal('detailsModal');">
                    <i class="bi bi-send"></i>
                    Send Enquiry
                </button>

                <button class="pl-btn pl-btn-outline"
                        onclick="shareCurrentPost()">
                    <i class="bi bi-share"></i>
                    Share
                </button>
            </div>

        </div>

    </div>
</div>


<!-- TOAST -->
<div class="pl-toast" id="plToast">
    <i class="bi bi-check-circle-fill"></i>
    <span id="toastMessage">Done</span>
</div>


 

<?php include 'footer.php'; ?>