<?php include 'header.php'; ?>

 

<main class="pl-detail-page">

    <!-- HERO / BREADCRUMB -->
    <section class="pl-detail-hero">
        <div class="pl-detail-container">

            <div class="pl-detail-breadcrumb">
                <a href="events-ads.php">
                    <i class="bi bi-arrow-left"></i>
                    Events & Advertisements
                </a>
                <span>/</span>
                <span>Details</span>
            </div>

            <div class="pl-detail-hero-grid">

                <div class="pl-detail-hero-content">

                    <div class="pl-detail-badges">
                        <span class="pl-detail-type">
                            <i class="bi bi-calendar-event"></i>
                            Community Event
                        </span>

                        <span class="pl-detail-community">
                            <i class="bi bi-people"></i>
                            Arya Vysya
                        </span>

                        <span class="pl-detail-approved">
                            <i class="bi bi-check-circle-fill"></i>
                            Approved
                        </span>
                    </div>

                    <h1>Annual Community Gathering 2026</h1>

                    <p class="pl-detail-intro">
                        Join community members for an evening of networking,
                        cultural activities, meaningful connections and
                        community participation.
                    </p>

                    <div class="pl-detail-quick-info">

                        <div>
                            <i class="bi bi-calendar3"></i>
                            <span>
                                <small>Event Date</small>
                                <strong>18 October 2026</strong>
                            </span>
                        </div>

                        <div>
                            <i class="bi bi-clock"></i>
                            <span>
                                <small>Time</small>
                                <strong>5:00 PM – 9:00 PM</strong>
                            </span>
                        </div>

                        <div>
                            <i class="bi bi-geo-alt"></i>
                            <span>
                                <small>Location</small>
                                <strong>New Delhi</strong>
                            </span>
                        </div>

                    </div>

                    <div class="pl-detail-hero-actions">

                        <button class="pl-detail-btn pl-detail-btn-primary"
                                onclick="openRegistrationModal()">
                            <i class="bi bi-ticket-perforated"></i>
                            Register Now
                        </button>

                        <button class="pl-detail-btn pl-detail-btn-outline"
                                onclick="saveDetailsPost(this)">
                            <i class="bi bi-bookmark"></i>
                            <span>Save</span>
                        </button>

                        <button class="pl-detail-btn pl-detail-btn-outline"
                                onclick="shareDetailsPost()">
                            <i class="bi bi-share"></i>
                            Share
                        </button>

                    </div>

                </div>


                <div class="pl-detail-featured-image">

                    <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1200&q=90"
                         alt="Annual Community Gathering">

                    <div class="pl-detail-image-overlay">
                        <div>
                            <i class="bi bi-calendar-check"></i>
                            <span>18 OCT</span>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>


    <!-- MAIN CONTENT -->
    <section class="pl-detail-main">
        <div class="pl-detail-container">

            <div class="pl-detail-layout">

                <!-- LEFT -->
                <div class="pl-detail-content">


                    <!-- OVERVIEW -->
                    <section class="pl-detail-section">

                        <div class="pl-detail-section-title">
                            <span>
                                <i class="bi bi-info-circle"></i>
                            </span>

                            <div>
                                <small>OVERVIEW</small>
                                <h2>Event / Advertisement Overview</h2>
                            </div>
                        </div>

                        <div class="pl-overview-grid">

                            <div>
                                <span>Title</span>
                                <strong>Annual Community Gathering 2026</strong>
                            </div>

                            <div>
                                <span>Type</span>
                                <strong>Community Event</strong>
                            </div>

                            <div>
                                <span>Visibility</span>
                                <strong>
                                    <em class="pl-inline-community">
                                        <i class="bi bi-people"></i>
                                        Community-Specific
                                    </em>
                                </strong>
                            </div>

                            <div>
                                <span>Posted By</span>
                                <strong>Arya Vysya Community</strong>
                            </div>

                            <div>
                                <span>Published Date</span>
                                <strong>02 October 2026</strong>
                            </div>

                            <div>
                                <span>Validity</span>
                                <strong>Until 18 October 2026</strong>
                            </div>

                        </div>

                    </section>


                    <!-- ABOUT -->
                    <section class="pl-detail-section">

                        <div class="pl-detail-section-title">
                            <span>
                                <i class="bi bi-file-text"></i>
                            </span>

                            <div>
                                <small>DESCRIPTION</small>
                                <h2>About the Event / Advertisement</h2>
                            </div>
                        </div>

                        <div class="pl-description">

                            <p>
                                The Annual Community Gathering brings together
                                members and families for an evening focused on
                                community interaction, cultural activities,
                                networking and meaningful connections.
                            </p>

                            <p>
                                The program provides an opportunity for
                                participating members to meet one another,
                                exchange ideas and take part in approved
                                community activities.
                            </p>

                            <h3>Purpose</h3>

                            <p>
                                To create an engaging environment where
                                community members can connect, participate
                                and strengthen their community network.
                            </p>

                            <h3>Activities</h3>

                            <ul>
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Community networking
                                </li>

                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Cultural activities
                                </li>

                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Member interaction
                                </li>

                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    Community announcements
                                </li>
                            </ul>

                        </div>

                    </section>


                    <!-- EVENT INFORMATION -->
                    <section class="pl-detail-section">

                        <div class="pl-detail-section-title">
                            <span>
                                <i class="bi bi-calendar2-event"></i>
                            </span>

                            <div>
                                <small>EVENT</small>
                                <h2>Event Information</h2>
                            </div>
                        </div>

                        <div class="pl-event-info-grid">

                            <div class="pl-event-info-item">
                                <i class="bi bi-calendar3"></i>
                                <span>
                                    <small>Event Name</small>
                                    <strong>Annual Community Gathering 2026</strong>
                                </span>
                            </div>

                            <div class="pl-event-info-item">
                                <i class="bi bi-calendar-date"></i>
                                <span>
                                    <small>Date</small>
                                    <strong>18 October 2026</strong>
                                </span>
                            </div>

                            <div class="pl-event-info-item">
                                <i class="bi bi-clock"></i>
                                <span>
                                    <small>Start Time</small>
                                    <strong>5:00 PM</strong>
                                </span>
                            </div>

                            <div class="pl-event-info-item">
                                <i class="bi bi-clock-history"></i>
                                <span>
                                    <small>End Time</small>
                                    <strong>9:00 PM</strong>
                                </span>
                            </div>

                            <div class="pl-event-info-item">
                                <i class="bi bi-building"></i>
                                <span>
                                    <small>Venue</small>
                                    <strong>Community Hall</strong>
                                </span>
                            </div>

                            <div class="pl-event-info-item">
                                <i class="bi bi-geo-alt"></i>
                                <span>
                                    <small>City / Location</small>
                                    <strong>New Delhi</strong>
                                </span>
                            </div>

                            <div class="pl-event-info-item">
                                <i class="bi bi-person-badge"></i>
                                <span>
                                    <small>Organiser</small>
                                    <strong>Arya Vysya Community</strong>
                                </span>
                            </div>

                            <div class="pl-event-info-item">
                                <i class="bi bi-cash-stack"></i>
                                <span>
                                    <small>Entry Fee</small>
                                    <strong>Free</strong>
                                </span>
                            </div>

                            <div class="pl-event-info-item">
                                <i class="bi bi-ticket-perforated"></i>
                                <span>
                                    <small>Registration</small>
                                    <strong>Required</strong>
                                </span>
                            </div>

                            <div class="pl-event-info-item">
                                <i class="bi bi-calendar-x"></i>
                                <span>
                                    <small>Registration Closes</small>
                                    <strong>16 October 2026</strong>
                                </span>
                            </div>

                        </div>

                    </section>


                    <!-- REGISTRATION -->
                    <section class="pl-registration-section">

                        <div class="pl-registration-heading">

                            <div>
                                <span class="pl-detail-label">PARTICIPATE</span>
                                <h2>Event Registration</h2>

                                <p>
                                    Reserve your participation by completing
                                    the registration form.
                                </p>
                            </div>

                            <div class="pl-registration-icon">
                                <i class="bi bi-ticket-perforated"></i>
                            </div>

                        </div>

                        <button class="pl-detail-btn pl-detail-btn-white"
                                onclick="openRegistrationModal()">
                            <i class="bi bi-check-circle"></i>
                            Register Now
                        </button>

                    </section>


                    <!-- ADVERTISEMENT INFORMATION -->
                    <section class="pl-detail-section pl-ad-info-section">

                        <div class="pl-detail-section-title">
                            <span>
                                <i class="bi bi-megaphone"></i>
                            </span>

                            <div>
                                <small>ADVERTISEMENT</small>
                                <h2>Advertisement Information</h2>
                            </div>
                        </div>

                        <div class="pl-ad-info-box">

                            <div>
                                <span>Business / Organisation</span>
                                <strong>PeopleLink Community Partner</strong>
                            </div>

                            <div>
                                <span>Advertisement Category</span>
                                <strong>Community Promotion</strong>
                            </div>

                            <div>
                                <span>Product / Service</span>
                                <strong>Community Services</strong>
                            </div>

                            <div>
                                <span>Offer / Promotion</span>
                                <strong>Special Community Promotion</strong>
                            </div>

                            <div>
                                <span>Validity</span>
                                <strong>October 2026</strong>
                            </div>

                            <div>
                                <span>Location</span>
                                <strong>New Delhi</strong>
                            </div>

                        </div>

                        <div class="pl-ad-enquiry-action">

                            <p>
                                For promotional listings, users can send an
                                enquiry to the advertiser.
                            </p>

                            <button class="pl-detail-btn pl-detail-btn-primary"
                                    onclick="openEnquiryModal()">
                                <i class="bi bi-send"></i>
                                Send Enquiry
                            </button>

                        </div>

                    </section>


                    <!-- VISIBILITY -->
                    <section class="pl-detail-section">

                        <div class="pl-detail-section-title">
                            <span>
                                <i class="bi bi-eye"></i>
                            </span>

                            <div>
                                <small>VISIBILITY</small>
                                <h2>Community / Global Visibility</h2>
                            </div>
                        </div>

                        <div class="pl-visibility-detail">

                            <div class="pl-current-visibility">

                                <div class="pl-visibility-big-icon">
                                    <i class="bi bi-people"></i>
                                </div>

                                <div>
                                    <span>THIS CONTENT IS</span>
                                    <h3>Community-Specific</h3>

                                    <p>
                                        This event is associated with the
                                        selected Arya Vysya community and is
                                        intended for eligible community users.
                                    </p>
                                </div>

                            </div>

                            <div class="pl-visibility-note">
                                <i class="bi bi-shield-check"></i>
                                Visibility is controlled according to
                                PeopleLink permissions and approved settings.
                            </div>

                        </div>

                    </section>


                    <!-- CONTACT -->
                    <section class="pl-detail-section">

                        <div class="pl-detail-section-title">
                            <span>
                                <i class="bi bi-person-lines-fill"></i>
                            </span>

                            <div>
                                <small>CONNECT</small>
                                <h2>Contact the Organiser / Advertiser</h2>
                            </div>
                        </div>

                        <p class="pl-section-description">
                            Contact options are displayed according to the
                            configured permissions for this listing.
                        </p>

                        <div class="pl-contact-grid">

                            <button onclick="contactAction('call')">
                                <span class="pl-contact-icon call">
                                    <i class="bi bi-telephone"></i>
                                </span>
                                <strong>Call</strong>
                                <small>Contact by phone</small>
                            </button>

                            <button onclick="contactAction('whatsapp')">
                                <span class="pl-contact-icon whatsapp">
                                    <i class="bi bi-whatsapp"></i>
                                </span>
                                <strong>WhatsApp</strong>
                                <small>Send a message</small>
                            </button>

                            <button onclick="contactAction('email')">
                                <span class="pl-contact-icon email">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <strong>Email</strong>
                                <small>Send an email</small>
                            </button>

                            <button onclick="openEnquiryModal()">
                                <span class="pl-contact-icon enquiry">
                                    <i class="bi bi-send"></i>
                                </span>
                                <strong>Enquiry</strong>
                                <small>Send enquiry</small>
                            </button>

                        </div>

                    </section>


                    <!-- LIVE -->
                    <section class="pl-detail-live">

                        <div class="pl-live-detail-icon">
                            <i class="bi bi-broadcast"></i>
                        </div>

                        <div>
                            <span>EXTERNAL LIVE PROGRAM</span>
                            <h2>Live Program Link</h2>

                            <p>
                                An authorised organiser can provide an
                                external live-streaming URL for this event.
                            </p>

                            <small>
                                PeopleLink provides access to supported
                                external links and does not host its own
                                live-streaming system.
                            </small>
                        </div>

                        <button class="pl-detail-btn pl-detail-btn-primary"
                                onclick="openLiveLink()">
                            <i class="bi bi-play-circle"></i>
                            Watch Live
                        </button>

                    </section>


                    <!-- GALLERY -->
                    <section class="pl-detail-section">

                        <div class="pl-detail-section-title">
                            <span>
                                <i class="bi bi-images"></i>
                            </span>

                            <div>
                                <small>MEDIA</small>
                                <h2>Event / Advertisement Gallery</h2>
                            </div>
                        </div>

                        <div class="pl-detail-gallery">

                            <div class="pl-gallery-main"
                                 onclick="openImageLightbox(this)">
                                <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1000&q=85"
                                     alt="Event gallery">
                                <span>
                                    <i class="bi bi-arrows-fullscreen"></i>
                                </span>
                            </div>

                            <div class="pl-gallery-small"
                                 onclick="openImageLightbox(this)">
                                <img src="https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=700&q=85"
                                     alt="Community event">
                            </div>

                            <div class="pl-gallery-small"
                                 onclick="openImageLightbox(this)">
                                <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=700&q=85"
                                     alt="People gathering">
                            </div>

                            <div class="pl-gallery-small"
                                 onclick="openImageLightbox(this)">
                                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=700&q=85"
                                     alt="Event venue">
                            </div>

                            <div class="pl-gallery-small"
                                 onclick="openImageLightbox(this)">
                                <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?auto=format&fit=crop&w=700&q=85"
                                     alt="Event program">
                            </div>

                        </div>

                    </section>


                    <!-- LOCATION -->
                    <section class="pl-detail-section">

                        <div class="pl-detail-section-title">
                            <span>
                                <i class="bi bi-geo-alt"></i>
                            </span>

                            <div>
                                <small>LOCATION</small>
                                <h2>Location & Directions</h2>
                            </div>
                        </div>

                        <div class="pl-location-box">

                            <div class="pl-location-map">

                                <div class="pl-map-grid"></div>

                                <div class="pl-map-pin">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>

                                <div class="pl-map-label">
                                    <strong>Community Hall</strong>
                                    <span>New Delhi</span>
                                </div>

                            </div>

                            <div class="pl-location-info">

                                <span>VENUE</span>

                                <h3>Community Hall</h3>

                                <p>
                                    New Delhi, India
                                </p>

                                <div class="pl-location-buttons">

                                    <button class="pl-detail-btn pl-detail-btn-primary"
                                            onclick="viewLocation()">
                                        <i class="bi bi-map"></i>
                                        View Location
                                    </button>

                                    <button class="pl-detail-btn pl-detail-btn-outline"
                                            onclick="getDirections()">
                                        <i class="bi bi-sign-turn-right"></i>
                                        Get Directions
                                    </button>

                                </div>

                            </div>

                        </div>

                    </section>


                    <!-- REPORT -->
                    <section class="pl-report-section">

                        <div>
                            <span class="pl-report-icon">
                                <i class="bi bi-flag"></i>
                            </span>

                            <div>
                                <h3>Report Content</h3>
                                <p>
                                    Found incorrect, expired or inappropriate
                                    content? Report it for admin review.
                                </p>
                            </div>
                        </div>

                        <button class="pl-detail-btn pl-detail-btn-outline"
                                onclick="openReportModal()">
                            <i class="bi bi-flag"></i>
                            Report
                        </button>

                    </section>

                </div>


                <!-- SIDEBAR -->
                <aside class="pl-detail-sidebar">


                    <!-- POSTED BY -->
                    <div class="pl-sidebar-card pl-organiser-card">

                        <span class="pl-sidebar-label">
                            POSTED BY
                        </span>

                        <div class="pl-organiser-avatar">
                            AV
                        </div>

                        <h3>Arya Vysya Community</h3>

                        <p>
                            Community organiser
                        </p>

                        <div class="pl-organiser-status">
                            <i class="bi bi-check-circle-fill"></i>
                            Approved Publisher
                        </div>

                        <button class="pl-detail-btn pl-detail-btn-primary"
                                onclick="openEnquiryModal()">
                            <i class="bi bi-send"></i>
                            Contact
                        </button>

                    </div>


                    <!-- QUICK ACTIONS -->
                    <div class="pl-sidebar-card">

                        <span class="pl-sidebar-label">
                            QUICK ACTIONS
                        </span>

                        <div class="pl-sidebar-actions">

                            <button onclick="openRegistrationModal()">
                                <i class="bi bi-ticket-perforated"></i>
                                Register Now
                                <i class="bi bi-chevron-right"></i>
                            </button>

                            <button onclick="shareDetailsPost()">
                                <i class="bi bi-share"></i>
                                Share Listing
                                <i class="bi bi-chevron-right"></i>
                            </button>

                            <button onclick="saveDetailsPost(this)">
                                <i class="bi bi-bookmark"></i>
                                Save Listing
                                <i class="bi bi-chevron-right"></i>
                            </button>

                            <button onclick="openReportModal()">
                                <i class="bi bi-flag"></i>
                                Report
                                <i class="bi bi-chevron-right"></i>
                            </button>

                        </div>

                    </div>


                    <!-- EVENT SNAPSHOT -->
                    <div class="pl-sidebar-card">

                        <span class="pl-sidebar-label">
                            EVENT SNAPSHOT
                        </span>

                        <div class="pl-snapshot-item">
                            <i class="bi bi-calendar3"></i>
                            <span>
                                <small>Date</small>
                                <strong>18 Oct 2026</strong>
                            </span>
                        </div>

                        <div class="pl-snapshot-item">
                            <i class="bi bi-clock"></i>
                            <span>
                                <small>Time</small>
                                <strong>5:00 PM</strong>
                            </span>
                        </div>

                        <div class="pl-snapshot-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>
                                <small>Location</small>
                                <strong>New Delhi</strong>
                            </span>
                        </div>

                        <div class="pl-snapshot-item">
                            <i class="bi bi-people"></i>
                            <span>
                                <small>Visibility</small>
                                <strong>Arya Vysya</strong>
                            </span>
                        </div>

                    </div>


                    <!-- PRIVACY -->
                    <div class="pl-sidebar-card pl-privacy-card">

                        <i class="bi bi-shield-check"></i>

                        <h3>PeopleLink Privacy</h3>

                        <p>
                            Contact details and visibility are displayed
                            according to configured permissions.
                        </p>

                    </div>

                </aside>

            </div>

        </div>
    </section>


    <!-- SIMILAR -->
    <section class="pl-similar-section">

        <div class="pl-detail-container">

            <div class="pl-detail-section-heading">

                <div>
                    <span class="pl-detail-label">DISCOVER MORE</span>
                    <h2>Similar Events & Advertisements</h2>
                    <p>
                        Explore related content based on community,
                        category and location.
                    </p>
                </div>

                <a href="events-ads.php" class="pl-detail-view-more">
                    View More
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>


            <div class="pl-similar-grid">


                <article class="pl-similar-card">

                    <div class="pl-similar-image">
                        <img src="https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&w=700&q=85"
                             alt="Cultural program">

                        <span>
                            <i class="bi bi-music-note-beamed"></i>
                            Cultural Program
                        </span>
                    </div>

                    <div class="pl-similar-content">

                        <div class="pl-similar-community">
                            <i class="bi bi-people"></i>
                            Reddy
                        </div>

                        <h3>Heritage & Cultural Evening</h3>

                        <div>
                            <i class="bi bi-calendar3"></i>
                            24 October 2026
                        </div>

                        <div>
                            <i class="bi bi-geo-alt"></i>
                            Hyderabad
                        </div>

                        <a href="#">
                            View Details
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                </article>


                <article class="pl-similar-card">

                    <div class="pl-similar-image">
                        <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?auto=format&fit=crop&w=700&q=85"
                             alt="Social initiative">

                        <span class="green">
                            <i class="bi bi-heart"></i>
                            Social Initiative
                        </span>
                    </div>

                    <div class="pl-similar-content">

                        <div class="pl-similar-community">
                            <i class="bi bi-people"></i>
                            Kamma
                        </div>

                        <h3>Community Service Initiative</h3>

                        <div>
                            <i class="bi bi-calendar3"></i>
                            26 October 2026
                        </div>

                        <div>
                            <i class="bi bi-geo-alt"></i>
                            Vijayawada
                        </div>

                        <a href="#">
                            View Details
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                </article>


                <article class="pl-similar-card">

                    <div class="pl-similar-image">
                        <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=700&q=85"
                             alt="Business promotion">

                        <span class="orange">
                            <i class="bi bi-megaphone"></i>
                            Business Promotion
                        </span>
                    </div>

                    <div class="pl-similar-content">

                        <div class="pl-similar-global">
                            <i class="bi bi-globe2"></i>
                            Global
                        </div>

                        <h3>Special Business Launch Offer</h3>

                        <div>
                            <i class="bi bi-calendar3"></i>
                            Until 31 October 2026
                        </div>

                        <div>
                            <i class="bi bi-geo-alt"></i>
                            Mumbai
                        </div>

                        <a href="#">
                            View Details
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                </article>

            </div>

        </div>

    </section>


    <!-- FINAL CTA -->
    <section class="pl-detail-final-cta">

        <div class="pl-detail-container">

            <div class="pl-detail-final-content">

                <div>
                    <span>PEOPLELINK</span>

                    <h2>Stay Informed. Stay Connected.</h2>

                    <p>
                        View complete details, register for events and
                        connect with advertisers through PeopleLink.
                    </p>
                </div>

                <div class="pl-detail-final-buttons">

                    <a href="events-ads.php"
                       class="pl-detail-btn pl-detail-btn-white">
                        <i class="bi bi-arrow-left"></i>
                        Back to Events & Ads
                    </a>

                    <button class="pl-detail-btn pl-detail-btn-ghost"
                            onclick="openRegistrationModal()">
                        <i class="bi bi-ticket-perforated"></i>
                        Register / Enquire
                    </button>

                    <button class="pl-detail-btn pl-detail-btn-ghost"
                            onclick="shareDetailsPost()">
                        <i class="bi bi-share"></i>
                        Share
                    </button>

                </div>

            </div>

        </div>

    </section>

</main>


<!-- REGISTRATION MODAL -->
<div class="pl-detail-modal" id="registrationModal">

    <div class="pl-detail-modal-overlay"
         onclick="closeDetailModal('registrationModal')"></div>

    <div class="pl-detail-modal-box">

        <button class="pl-detail-modal-close"
                onclick="closeDetailModal('registrationModal')">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="pl-detail-modal-header">

            <span>
                <i class="bi bi-ticket-perforated"></i>
            </span>

            <div>
                <small>EVENT REGISTRATION</small>
                <h3>Register Now</h3>
            </div>

        </div>

        <form id="detailRegistrationForm">

            <div class="pl-detail-form-grid">

                <div class="pl-detail-form-group">
                    <label>Name</label>
                    <input type="text"
                           required
                           placeholder="Your full name">
                </div>

                <div class="pl-detail-form-group">
                    <label>Mobile Number</label>
                    <input type="tel"
                           required
                           placeholder="Mobile number">
                </div>

                <div class="pl-detail-form-group">
                    <label>Email</label>
                    <input type="email"
                           placeholder="Email address">
                </div>

                <div class="pl-detail-form-group">
                    <label>Number of Participants</label>
                    <input type="number"
                           min="1"
                           value="1"
                           required>
                </div>

                <div class="pl-detail-form-group full">
                    <label>Additional Information</label>
                    <textarea rows="4"
                              placeholder="Additional information"></textarea>
                </div>

            </div>

            <button type="submit"
                    class="pl-detail-btn pl-detail-btn-primary pl-detail-submit">
                <i class="bi bi-check-circle"></i>
                Submit Registration
            </button>

        </form>

    </div>

</div>


<!-- ENQUIRY MODAL -->
<div class="pl-detail-modal" id="enquiryModal">

    <div class="pl-detail-modal-overlay"
         onclick="closeDetailModal('enquiryModal')"></div>

    <div class="pl-detail-modal-box">

        <button class="pl-detail-modal-close"
                onclick="closeDetailModal('enquiryModal')">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="pl-detail-modal-header">

            <span>
                <i class="bi bi-send"></i>
            </span>

            <div>
                <small>PEOPLELINK ENQUIRY</small>
                <h3>Send Enquiry</h3>
            </div>

        </div>

        <form id="detailEnquiryForm">

            <div class="pl-detail-form-grid">

                <div class="pl-detail-form-group">
                    <label>Your Name</label>
                    <input type="text"
                           required
                           placeholder="Your name">
                </div>

                <div class="pl-detail-form-group">
                    <label>Mobile Number</label>
                    <input type="tel"
                           required
                           placeholder="Mobile number">
                </div>

                <div class="pl-detail-form-group full">
                    <label>Email</label>
                    <input type="email"
                           placeholder="Email address">
                </div>

                <div class="pl-detail-form-group full">
                    <label>Message</label>
                    <textarea rows="5"
                              required
                              placeholder="Write your enquiry"></textarea>
                </div>

            </div>

            <button type="submit"
                    class="pl-detail-btn pl-detail-btn-primary pl-detail-submit">
                <i class="bi bi-send"></i>
                Send Enquiry
            </button>

        </form>

    </div>

</div>


<!-- REPORT MODAL -->
<div class="pl-detail-modal" id="reportModal">

    <div class="pl-detail-modal-overlay"
         onclick="closeDetailModal('reportModal')"></div>

    <div class="pl-detail-modal-box">

        <button class="pl-detail-modal-close"
                onclick="closeDetailModal('reportModal')">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="pl-detail-modal-header">

            <span class="report">
                <i class="bi bi-flag"></i>
            </span>

            <div>
                <small>CONTENT REVIEW</small>
                <h3>Report Content</h3>
            </div>

        </div>

        <form id="reportForm">

            <div class="pl-detail-form-group">
                <label>Reason</label>

                <select required>
                    <option value="">Select reason</option>
                    <option>Incorrect Information</option>
                    <option>Expired Content</option>
                    <option>Inappropriate Content</option>
                    <option>Misleading Information</option>
                    <option>Other</option>
                </select>
            </div>

            <div class="pl-detail-form-group">
                <label>Additional Details</label>

                <textarea rows="5"
                          placeholder="Tell us more about the issue"></textarea>
            </div>

            <button type="submit"
                    class="pl-detail-btn pl-detail-btn-primary pl-detail-submit">
                <i class="bi bi-flag"></i>
                Submit Report
            </button>

        </form>

    </div>

</div>


<!-- IMAGE LIGHTBOX -->
<div class="pl-detail-lightbox" id="detailLightbox">

    <button onclick="closeLightbox()">
        <i class="bi bi-x-lg"></i>
    </button>

    <img id="lightboxImage"
         data-src=""
         alt="Gallery preview">

</div>


<!-- TOAST -->
<div class="pl-detail-toast" id="detailToast">
    <i class="bi bi-check-circle-fill"></i>
    <span id="detailToastText">Done</span>
</div>


 

<?php include 'footer.php'; ?>