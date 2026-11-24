<?php include 'header.php'; ?>

 

<main class="pl-near-page">

    <!-- =====================================================
         HERO
    ====================================================== -->
    <section class="pl-near-hero">

        <div class="pl-near-hero-pattern"></div>

        <div class="pl-container">

            <div class="pl-near-hero-content">

                <div class="pl-near-badge">
                    <i class="bi bi-geo-alt-fill"></i>
                    PeopleLink Near Me
                </div>

                <h1>
                    Discover Professionals
                    <span>& Services Around You</span>
                </h1>

                <p>
                    Find nearby registered professionals, businesses and
                    service providers available through PeopleLink.
                </p>

                <div class="pl-near-hero-actions">

                    <button
                        type="button"
                        class="pl-near-btn pl-near-btn-primary"
                        id="useLocationBtn"
                    >
                        <i class="bi bi-crosshair"></i>
                        Use My Location
                    </button>

                    <button
                        type="button"
                        class="pl-near-btn pl-near-btn-light"
                        id="areaSearchBtn"
                    >
                        <i class="bi bi-search"></i>
                        Search by Area
                    </button>

                </div>

                <div class="pl-location-status" id="locationStatus">

                    <i class="bi bi-shield-check"></i>

                    <span>
                        Your exact location is not publicly displayed.
                    </span>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         SEARCH PANEL
    ====================================================== -->
    <section class="pl-near-search-section">

        <div class="pl-container">

            <div class="pl-near-search-card">

                <div class="pl-search-card-header">

                    <div>

                        <span class="pl-section-label">
                            Location-Based Search
                        </span>

                        <h2>
                            Find Nearby Services
                        </h2>

                        <p>
                            Search using your location or manually select
                            an area to discover relevant PeopleLink listings.
                        </p>

                    </div>

                    <div class="pl-search-location-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                </div>


                <div class="pl-location-methods">

                    <button
                        type="button"
                        class="pl-location-method active"
                        id="currentLocationMethod"
                    >

                        <span>
                            <i class="bi bi-crosshair"></i>
                        </span>

                        <div>
                            <strong>Use My Location</strong>
                            <small>
                                Find services around your location
                            </small>
                        </div>

                    </button>


                    <button
                        type="button"
                        class="pl-location-method"
                        id="manualLocationMethod"
                    >

                        <span>
                            <i class="bi bi-pin-map-fill"></i>
                        </span>

                        <div>
                            <strong>Search by Area</strong>
                            <small>
                                Select your location manually
                            </small>
                        </div>

                    </button>

                </div>


                <!-- CURRENT LOCATION -->
                <div
                    class="pl-current-location-box"
                    id="currentLocationBox"
                >

                    <div class="pl-current-location-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <div>

                        <strong id="currentLocationText">
                            Location not selected
                        </strong>

                        <span>
                            Allow location access to discover nearby
                            professionals and businesses.
                        </span>

                    </div>

                    <button
                        type="button"
                        class="pl-small-action"
                        id="detectLocationBtn"
                    >
                        Detect
                    </button>

                </div>


                <!-- MANUAL LOCATION -->
                <div
                    class="pl-manual-location"
                    id="manualLocationBox"
                >

                    <div class="pl-form-grid">

                        <div class="pl-form-group">

                            <label>
                                State
                            </label>

                            <select id="stateSelect">

                                <option value="">
                                    Select State
                                </option>

                                <option>
                                    Uttar Pradesh
                                </option>

                                <option>
                                    Uttarakhand
                                </option>

                                <option>
                                    Delhi
                                </option>

                                <option>
                                    Maharashtra
                                </option>

                                <option>
                                    Rajasthan
                                </option>

                                <option>
                                    Gujarat
                                </option>

                            </select>

                        </div>


                        <div class="pl-form-group">

                            <label>
                                District
                            </label>

                            <select id="districtSelect">

                                <option value="">
                                    Select District
                                </option>

                                <option>
                                    Agra
                                </option>

                                <option>
                                    Haridwar
                                </option>

                                <option>
                                    Dehradun
                                </option>

                                <option>
                                    Gautam Buddha Nagar
                                </option>

                            </select>

                        </div>


                        <div class="pl-form-group">

                            <label>
                                City / Area
                            </label>

                            <input
                                type="text"
                                id="cityArea"
                                placeholder="Enter city or area"
                            >

                        </div>


                        <div class="pl-form-group">

                            <label>
                                Pincode
                            </label>

                            <input
                                type="text"
                                id="pincode"
                                placeholder="Enter pincode"
                                maxlength="6"
                            >

                        </div>

                    </div>

                </div>


                <!-- CATEGORY SEARCH -->
                <div class="pl-main-search-row">

                    <div class="pl-main-search">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="serviceSearch"
                            placeholder="Search professionals, businesses or services..."
                        >

                    </div>


                    <button
                        type="button"
                        class="pl-search-btn"
                        id="searchNearbyBtn"
                    >
                        <i class="bi bi-search"></i>
                        Search Nearby
                    </button>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         SERVICE CATEGORIES
    ====================================================== -->
    <section class="pl-near-categories">

        <div class="pl-container">

            <div class="pl-section-heading">

                <div>

                    <span class="pl-section-label">
                        Explore Services
                    </span>

                    <h2>
                        Find Nearby Services
                    </h2>

                    <p>
                        Select a service category to discover relevant
                        professionals and businesses around you.
                    </p>

                </div>

                <a
                    href="professional-directory.php"
                    class="pl-section-link"
                >
                    View Directory
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>


            <div class="pl-category-grid">

                <button class="pl-category-item">

                    <span class="pl-category-icon blue">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </span>

                    <strong>Doctors</strong>

                    <small>
                        Medical professionals
                    </small>

                </button>


                <button class="pl-category-item">

                    <span class="pl-category-icon red">
                        <i class="bi bi-bank"></i>
                    </span>

                    <strong>Lawyers</strong>

                    <small>
                        Legal professionals
                    </small>

                </button>


                <button class="pl-category-item">

                    <span class="pl-category-icon green">
                        <i class="bi bi-calculator-fill"></i>
                    </span>

                    <strong>Chartered Accountants</strong>

                    <small>
                        Accounting services
                    </small>

                </button>


                <button class="pl-category-item">

                    <span class="pl-category-icon purple">
                        <i class="bi bi-cpu-fill"></i>
                    </span>

                    <strong>Engineers</strong>

                    <small>
                        Engineering services
                    </small>

                </button>


                <button class="pl-category-item">

                    <span class="pl-category-icon orange">
                        <i class="bi bi-book-half"></i>
                    </span>

                    <strong>Tutors</strong>

                    <small>
                        Education & tutoring
                    </small>

                </button>


                <button class="pl-category-item">

                    <span class="pl-category-icon teal">
                        <i class="bi bi-person-workspace"></i>
                    </span>

                    <strong>Consultants</strong>

                    <small>
                        Professional consulting
                    </small>

                </button>


                <button class="pl-category-item">

                    <span class="pl-category-icon pink">
                        <i class="bi bi-house-fill"></i>
                    </span>

                    <strong>Real Estate</strong>

                    <small>
                        Property services
                    </small>

                </button>


                <button class="pl-category-item">

                    <span class="pl-category-icon dark">
                        <i class="bi bi-laptop-fill"></i>
                    </span>

                    <strong>IT Services</strong>

                    <small>
                        Technology services
                    </small>

                </button>


                <button class="pl-category-item">

                    <span class="pl-category-icon yellow">
                        <i class="bi bi-shop"></i>
                    </span>

                    <strong>Shops</strong>

                    <small>
                        Nearby businesses
                    </small>

                </button>


                <button class="pl-category-item">

                    <span class="pl-category-icon blue">
                        <i class="bi bi-building-fill"></i>
                    </span>

                    <strong>Businesses</strong>

                    <small>
                        Local businesses
                    </small>

                </button>


                <button class="pl-category-item">

                    <span class="pl-category-icon green">
                        <i class="bi bi-tools"></i>
                    </span>

                    <strong>Service Providers</strong>

                    <small>
                        Local services
                    </small>

                </button>


                <button class="pl-category-item">

                    <span class="pl-category-icon purple">
                        <i class="bi bi-grid-fill"></i>
                    </span>

                    <strong>Other Services</strong>

                    <small>
                        Explore more
                    </small>

                </button>

            </div>

        </div>

    </section>


    <!-- =====================================================
         FILTER BAR
    ====================================================== -->
    <section class="pl-near-filter-section">

        <div class="pl-container">

            <div class="pl-filter-card">

                <div class="pl-filter-header">

                    <div>

                        <span class="pl-section-label">
                            Refine Results
                        </span>

                        <h2>
                            Category Filters
                        </h2>

                    </div>

                    <button
                        type="button"
                        class="pl-reset-btn"
                        id="resetFiltersBtn"
                    >
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Filters
                    </button>

                </div>


                <div class="pl-filter-grid">

                    <div class="pl-filter-item">

                        <label>
                            Profession
                        </label>

                        <select id="professionFilter">

                            <option value="">
                                All Professions
                            </option>

                            <option>
                                Doctor
                            </option>

                            <option>
                                Lawyer
                            </option>

                            <option>
                                Chartered Accountant
                            </option>

                            <option>
                                Engineer
                            </option>

                            <option>
                                Teacher
                            </option>

                            <option>
                                Consultant
                            </option>

                        </select>

                    </div>


                    <div class="pl-filter-item">

                        <label>
                            Business Category
                        </label>

                        <select id="businessFilter">

                            <option value="">
                                All Businesses
                            </option>

                            <option>
                                Healthcare
                            </option>

                            <option>
                                IT Services
                            </option>

                            <option>
                                Retail
                            </option>

                            <option>
                                Real Estate
                            </option>

                            <option>
                                Education
                            </option>

                        </select>

                    </div>


                    <div class="pl-filter-item">

                        <label>
                            Service Type
                        </label>

                        <select id="serviceFilter">

                            <option value="">
                                All Services
                            </option>

                            <option>
                                Consultation
                            </option>

                            <option>
                                Professional Services
                            </option>

                            <option>
                                Home Services
                            </option>

                            <option>
                                Business Services
                            </option>

                        </select>

                    </div>


                    <div class="pl-filter-item">

                        <label>
                            Community
                        </label>

                        <select id="communityFilter">

                            <option value="">
                                All Communities
                            </option>

                            <option>
                                Arya Vysya
                            </option>

                            <option>
                                Reddy
                            </option>

                            <option>
                                Kamma
                            </option>

                            <option>
                                Kapu
                            </option>

                            <option>
                                Banjara
                            </option>

                            <option>
                                Yadava
                            </option>

                        </select>

                    </div>


                    <div class="pl-filter-item">

                        <label>
                            Distance
                        </label>

                        <select id="distanceFilter">

                            <option value="5">
                                Within 5 km
                            </option>

                            <option value="10">
                                Within 10 km
                            </option>

                            <option value="25">
                                Within 25 km
                            </option>

                            <option value="50">
                                Within 50 km
                            </option>

                            <option value="100">
                                Within 100 km
                            </option>

                        </select>

                    </div>


                    <div class="pl-filter-item">

                        <label>
                            Location
                        </label>

                        <input
                            type="text"
                            id="locationFilter"
                            placeholder="City / Area / Pincode"
                        >

                    </div>

                </div>


                <div class="pl-filter-actions">

                    <button
                        type="button"
                        class="pl-near-btn pl-near-btn-primary"
                        id="applyFiltersBtn"
                    >
                        <i class="bi bi-funnel-fill"></i>
                        Apply Filters
                    </button>

                    <button
                        type="button"
                        class="pl-near-btn pl-near-btn-secondary"
                        id="resetFiltersBtnBottom"
                    >
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Filters
                    </button>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         RESULTS
    ====================================================== -->
    <section class="pl-results-section">

        <div class="pl-container">

            <div class="pl-results-top">

                <div>

                    <span class="pl-section-label">
                        Nearby Results
                    </span>

                    <h2>
                        Professionals Around You
                    </h2>

                    <p id="resultText">
                        Showing nearby professionals and service providers
                    </p>

                </div>


                <div class="pl-results-sort">

                    <label>
                        Sort by
                    </label>

                    <select id="sortResults">

                        <option>
                            Nearest
                        </option>

                        <option>
                            Recommended
                        </option>

                        <option>
                            Recently Added
                        </option>

                    </select>

                </div>

            </div>


            <!-- PROFESSIONAL LISTING -->
            <div class="pl-near-results-grid" id="nearResults">


                <!-- RESULT 1 -->
                <article class="pl-near-result-card">

                    <div class="pl-result-image">

                        <img
                            src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=700&q=85"
                            alt="Dr. Rajesh Sharma"
                        >

                        <span class="pl-result-verified">
                            <i class="bi bi-patch-check-fill"></i>
                        </span>

                        <span class="pl-distance-badge">
                            1.8 km
                        </span>

                    </div>


                    <div class="pl-result-body">

                        <div class="pl-result-type">
                            Medical Professional
                        </div>

                        <h3>
                            Dr. Rajesh Sharma
                        </h3>

                        <div class="pl-result-speciality">
                            Cardiology
                        </div>

                        <p class="pl-result-location">
                            <i class="bi bi-geo-alt-fill"></i>
                            Agra, Uttar Pradesh
                        </p>

                        <p class="pl-result-description">
                            Experienced medical professional providing
                            consultation and specialist healthcare services.
                        </p>


                        <div class="pl-result-community">
                            <i class="bi bi-people-fill"></i>
                            Arya Vysya Community
                        </div>


                        <div class="pl-result-actions">

                            <a
                                href="professional-profile.php"
                                class="pl-view-profile-btn"
                            >
                                View Profile
                                <i class="bi bi-arrow-right"></i>
                            </a>

                            <button
                                class="pl-save-listing"
                                title="Save Listing"
                            >
                                <i class="bi bi-bookmark"></i>
                            </button>

                        </div>

                    </div>

                </article>


                <!-- RESULT 2 -->
                <article class="pl-near-result-card">

                    <div class="pl-result-image">

                        <img
                            src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=700&q=85"
                            alt="Business Consultant"
                        >

                        <span class="pl-result-verified">
                            <i class="bi bi-patch-check-fill"></i>
                        </span>

                        <span class="pl-distance-badge">
                            3.4 km
                        </span>

                    </div>


                    <div class="pl-result-body">

                        <div class="pl-result-type">
                            Business Consultant
                        </div>

                        <h3>
                            Verma Business Solutions
                        </h3>

                        <div class="pl-result-speciality">
                            Business Consulting
                        </div>

                        <p class="pl-result-location">
                            <i class="bi bi-geo-alt-fill"></i>
                            Sanjay Place, Agra
                        </p>

                        <p class="pl-result-description">
                            Business consulting and professional advisory
                            services for growing organisations.
                        </p>


                        <div class="pl-result-community">
                            <i class="bi bi-people-fill"></i>
                            Reddy Community
                        </div>


                        <div class="pl-result-actions">

                            <a
                                href="professional-profile.php"
                                class="pl-view-profile-btn"
                            >
                                View Profile
                                <i class="bi bi-arrow-right"></i>
                            </a>

                            <button
                                class="pl-save-listing"
                                title="Save Listing"
                            >
                                <i class="bi bi-bookmark"></i>
                            </button>

                        </div>

                    </div>

                </article>


                <!-- RESULT 3 -->
                <article class="pl-near-result-card">

                    <div class="pl-result-image">

                        <img
                            src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=700&q=85"
                            alt="Chartered Accountant"
                        >

                        <span class="pl-result-verified">
                            <i class="bi bi-patch-check-fill"></i>
                        </span>

                        <span class="pl-distance-badge">
                            4.7 km
                        </span>

                    </div>


                    <div class="pl-result-body">

                        <div class="pl-result-type">
                            Chartered Accountant
                        </div>

                        <h3>
                            Amit & Associates
                        </h3>

                        <div class="pl-result-speciality">
                            Accounting & Tax Services
                        </div>

                        <p class="pl-result-location">
                            <i class="bi bi-geo-alt-fill"></i>
                            Civil Lines, Agra
                        </p>

                        <p class="pl-result-description">
                            Professional accounting, taxation and business
                            advisory services.
                        </p>


                        <div class="pl-result-community">
                            <i class="bi bi-people-fill"></i>
                            Arya Vysya Community
                        </div>


                        <div class="pl-result-actions">

                            <a
                                href="professional-profile.php"
                                class="pl-view-profile-btn"
                            >
                                View Profile
                                <i class="bi bi-arrow-right"></i>
                            </a>

                            <button
                                class="pl-save-listing"
                                title="Save Listing"
                            >
                                <i class="bi bi-bookmark"></i>
                            </button>

                        </div>

                    </div>

                </article>


                <!-- RESULT 4 -->
                <article class="pl-near-result-card">

                    <div class="pl-result-image">

                        <img
                            src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=700&q=85"
                            alt="IT Services Business"
                        >

                        <span class="pl-result-verified">
                            <i class="bi bi-patch-check-fill"></i>
                        </span>

                        <span class="pl-distance-badge">
                            6.2 km
                        </span>

                    </div>


                    <div class="pl-result-body">

                        <div class="pl-result-type">
                            IT Services
                        </div>

                        <h3>
                            Digital Tech Solutions
                        </h3>

                        <div class="pl-result-speciality">
                            Website & Technology Services
                        </div>

                        <p class="pl-result-location">
                            <i class="bi bi-geo-alt-fill"></i>
                            Kamla Nagar, Agra
                        </p>

                        <p class="pl-result-description">
                            Website development, digital solutions and
                            technology consulting for businesses.
                        </p>


                        <div class="pl-result-community">
                            <i class="bi bi-people-fill"></i>
                            Kamma Community
                        </div>


                        <div class="pl-result-actions">

                            <a
                                href="professional-profile.php"
                                class="pl-view-profile-btn"
                            >
                                View Profile
                                <i class="bi bi-arrow-right"></i>
                            </a>

                            <button
                                class="pl-save-listing"
                                title="Save Listing"
                            >
                                <i class="bi bi-bookmark"></i>
                            </button>

                        </div>

                    </div>

                </article>

            </div>

        </div>

    </section>


    <!-- =====================================================
         COMMUNITY NEAR ME
    ====================================================== -->
    <section class="pl-community-near-section">

        <div class="pl-container">

            <div class="pl-community-near-box">

                <div class="pl-community-near-icon">
                    <i class="bi bi-people-fill"></i>
                </div>


                <div class="pl-community-near-content">

                    <span class="pl-section-label">
                        Community-Based Near Me
                    </span>

                    <h2>
                        Discover Professionals From Your Community
                    </h2>

                    <p>
                        Optionally explore nearby professionals and
                        businesses specifically from your selected
                        community.
                    </p>


                    <div class="pl-community-options">

                        <button>
                            <i class="bi bi-people-fill"></i>
                            Nearby Arya Vysya Professionals
                            <i class="bi bi-arrow-right"></i>
                        </button>

                        <button>
                            <i class="bi bi-building-fill"></i>
                            Nearby Reddy Businesses
                            <i class="bi bi-arrow-right"></i>
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         MAP
    ====================================================== -->
    <section class="pl-map-section">

        <div class="pl-container">

            <div class="pl-map-card">

                <div class="pl-map-content">

                    <div class="pl-map-icon">
                        <i class="bi bi-map-fill"></i>
                    </div>

                    <span class="pl-section-label">
                        Location Discovery
                    </span>

                    <h2>
                        View Professionals & Businesses on Map
                    </h2>

                    <p>
                        Where map integration is enabled, view approved
                        professional and business locations around your
                        selected area.
                    </p>

                    <button
                        type="button"
                        class="pl-near-btn pl-near-btn-primary"
                        id="viewMapBtn"
                    >
                        <i class="bi bi-map"></i>
                        View Map
                    </button>

                </div>


                <div class="pl-map-visual">

                    <div class="pl-map-grid"></div>

                    <div class="pl-map-road road-one"></div>
                    <div class="pl-map-road road-two"></div>
                    <div class="pl-map-road road-three"></div>

                    <div class="pl-map-pin pin-one">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <div class="pl-map-pin pin-two">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <div class="pl-map-pin pin-three">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <div class="pl-map-pin pin-four">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <div class="pl-map-current">
                        <span></span>
                        Your Area
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         CONTACT / PRIVACY
    ====================================================== -->
    <section class="pl-contact-privacy-section">

        <div class="pl-container">

            <div class="pl-contact-privacy-grid">


                <!-- CONTACT -->
                <div class="pl-info-box">

                    <div class="pl-info-box-icon blue">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>

                    <div>

                        <span class="pl-section-label">
                            Connect
                        </span>

                        <h2>
                            Contact & Enquiry
                        </h2>

                        <p>
                            Contact or send an enquiry to the selected
                            professional or business according to available
                            permissions.
                        </p>


                        <div class="pl-contact-buttons">

                            <button>
                                <i class="bi bi-telephone-fill"></i>
                                Call
                            </button>

                            <button>
                                <i class="bi bi-whatsapp"></i>
                                WhatsApp
                            </button>

                            <button>
                                <i class="bi bi-chat-text-fill"></i>
                                Send Enquiry
                            </button>

                        </div>

                    </div>

                </div>


                <!-- SAVE -->
                <div class="pl-info-box">

                    <div class="pl-info-box-icon green">
                        <i class="bi bi-bookmark-fill"></i>
                    </div>

                    <div>

                        <span class="pl-section-label">
                            Save For Later
                        </span>

                        <h2>
                            Save a Nearby Listing
                        </h2>

                        <p>
                            Logged-in users can save useful nearby
                            professionals and businesses for future
                            reference.
                        </p>


                        <button
                            class="pl-near-btn pl-near-btn-secondary"
                            id="savedListingsBtn"
                        >
                            <i class="bi bi-bookmark"></i>
                            View Saved Listings
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         PRIVACY
    ====================================================== -->
    <section class="pl-privacy-section">

        <div class="pl-container">

            <div class="pl-privacy-inner">

                <div class="pl-privacy-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>


                <div>

                    <span class="pl-section-label">
                        Privacy & Location Protection
                    </span>

                    <h2>
                        Your Location Stays Private
                    </h2>

                    <p>
                        Your exact personal location should not be
                        publicly displayed. Location access is only used
                        to help find nearby listings when permission is
                        provided.
                    </p>

                    <p>
                        Professional and business locations are displayed
                        according to the visibility settings approved by
                        the listing owner and administrator.
                    </p>

                </div>


                <div class="pl-privacy-points">

                    <span>
                        <i class="bi bi-check-circle-fill"></i>
                        Location permission required
                    </span>

                    <span>
                        <i class="bi bi-check-circle-fill"></i>
                        Exact personal location protected
                    </span>

                    <span>
                        <i class="bi bi-check-circle-fill"></i>
                        Approved listings only
                    </span>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         NO RESULTS
    ====================================================== -->
    <section class="pl-no-results-section">

        <div class="pl-container">

            <div class="pl-no-results">

                <div class="pl-no-results-icon">
                    <i class="bi bi-search"></i>
                </div>

                <div>

                    <span class="pl-section-label">
                        Can't Find What You Need?
                    </span>

                    <h2>
                        No Nearby Results?
                    </h2>

                    <p>
                        Increase the search radius, change the service
                        category or manually select another area.
                    </p>

                </div>


                <div class="pl-no-results-actions">

                    <button
                        type="button"
                        id="increaseDistanceBtn"
                    >
                        <i class="bi bi-arrows-expand"></i>
                        Increase Distance
                    </button>

                    <button
                        type="button"
                        id="changeLocationBtn"
                    >
                        <i class="bi bi-geo-alt"></i>
                        Change Location
                    </button>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         FINAL CTA
    ====================================================== -->
    <section class="pl-near-final-cta">

        <div class="pl-container">

            <div class="pl-final-cta-content">

                <div class="pl-final-cta-icon">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>

                <span>
                    PeopleLink Near Me
                </span>

                <h2>
                    Find the Right Service,
                    <strong>Close to You</strong>
                </h2>

                <p>
                    Discover trusted professionals and businesses around
                    your location through PeopleLink.
                </p>


                <div class="pl-final-cta-actions">

                    <button
                        type="button"
                        class="pl-near-btn pl-near-btn-white"
                        id="finalLocationBtn"
                    >
                        <i class="bi bi-crosshair"></i>
                        Use My Location
                    </button>

                    <button
                        type="button"
                        class="pl-near-btn pl-near-btn-outline-white"
                        id="finalSearchBtn"
                    >
                        <i class="bi bi-search"></i>
                        Search Services
                    </button>

                    <button
                        type="button"
                        class="pl-near-btn pl-near-btn-outline-white"
                        id="finalMapBtn"
                    >
                        <i class="bi bi-map"></i>
                        View Map
                    </button>

                </div>

            </div>

        </div>

    </section>

</main>


<!-- =====================================================
     LOCATION MODAL
====================================================== -->
<div class="pl-near-modal" id="locationModal">

    <div class="pl-near-modal-overlay"></div>

    <div class="pl-near-modal-box">

        <button
            type="button"
            class="pl-near-modal-close"
            data-close-location-modal
        >
            <i class="bi bi-x-lg"></i>
        </button>


        <div class="pl-modal-location-icon">
            <i class="bi bi-crosshair"></i>
        </div>

        <h2>
            Use Your Location
        </h2>

        <p>
            PeopleLink can use your current location to find nearby
            professionals and businesses. Your exact location will not
            be publicly displayed.
        </p>


        <div class="pl-modal-location-note">

            <i class="bi bi-shield-check"></i>

            <span>
                Location access is only used for nearby search.
            </span>

        </div>


        <div class="pl-modal-buttons">

            <button
                type="button"
                class="pl-near-btn pl-near-btn-primary"
                id="allowLocationBtn"
            >
                <i class="bi bi-crosshair"></i>
                Allow Location
            </button>

            <button
                type="button"
                class="pl-near-btn pl-near-btn-secondary"
                data-close-location-modal
            >
                Search by Area
            </button>

        </div>

    </div>

</div>


<!-- =====================================================
     TOAST
====================================================== -->
<div class="pl-near-toast" id="nearToast">

    <i class="bi bi-check-circle-fill"></i>

    <span>
        Location updated successfully.
    </span>

</div>


 

<?php include 'footer.php'; ?>