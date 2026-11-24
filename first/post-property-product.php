<!DOCTYPE html>
<html lang="en">

<head>

    <!-- =====================================================
         BASIC META
    ====================================================== -->

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="PeopleLink — Connect, discover and belong to your community."
    >

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

 
    <title>
        PeopleLink | Connect • Discover • Belong
    </title>


    <!-- =====================================================
         GOOGLE FONTS
    ====================================================== -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap"
        rel="stylesheet"
    >


    <!-- =====================================================
         FONT AWESOME
    ====================================================== -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >
    <!-- =====================================================
         HEADER CSS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="header.css"
    >

     <link
        rel="stylesheet"
        href="post-property-product.css"
    >

    <link
        rel="stylesheet"
        href="footer.css"
    >

</head>


<body>


<!-- =========================================================
     PEOPLELINK HEADER
========================================================= -->

<header
    class="pl-header"
    id="peoplelinkHeader"
>


    <!-- =====================================================
         TOP BAR
    ====================================================== -->

    <div class="pl-topbar">

        <div class="pl-container">

            <div class="pl-top-left">

                <span>
                    <i class="fa-solid fa-heart"></i>
                    Connecting Communities
                </span>

                <span>
                    <i class="fa-solid fa-location-dot"></i>
                    Communities Across India
                </span>

            </div>


            <div class="pl-top-right">

                <a href="#help">
                    Help & Support
                </a>

                <a href="#contact">
                    Contact Us
                </a>

            </div>

        </div>

    </div>


    <!-- =====================================================
         MAIN NAVIGATION
    ====================================================== -->

    <div class="pl-navbar">

        <div class="pl-container">


            <!-- =================================================
                 ACTUAL PEOPLELINK LOGO
            ================================================== -->

            <a
                href="index.php"
                class="pl-logo"
                aria-label="PeopleLink Home"
            >

                <img
                    src="images/logo.jpeg"
                    alt="PeopleLink"
                    class="pl-logo-image"
                >

            </a>


            <!-- =================================================
                 MOBILE MENU BUTTON
            ================================================== -->

            <button
                type="button"
                class="pl-mobile-toggle"
                id="plMobileToggle"
                aria-label="Open navigation"
                aria-expanded="false"
            >

                <span></span>
                <span></span>
                <span></span>

            </button>


            <!-- =================================================
                 MAIN NAVIGATION
            ================================================== -->

            <nav
                class="pl-main-nav"
                id="plMainNav"
                aria-label="Main Navigation"
            >


                <a
                    href="index.php"
                    class="pl-nav-link active"
                >
                    Home
                </a>


                <!-- =============================================
                     COMMUNITIES
                ============================================== -->

                <div class="pl-nav-dropdown">

                    <button
                        type="button"
                        class="pl-nav-dropdown-btn"
                    >

                        Communities

                        <i class="fa-solid fa-chevron-down"></i>

                    </button>


                    <div class="pl-dropdown-menu">

                        <div class="pl-dropdown-title">

                            <strong>
                                OUR COMMUNITIES
                            </strong>

                            <span>
                                Choose your community
                            </span>

                        </div>


                        <a href="#communityList">

                            <i class="fa-solid fa-people-group"></i>

                            Arya Vysya

                        </a>


                        <a href="#communityList">

                            <i class="fa-solid fa-users"></i>

                            Reddy

                        </a>


                        <a href="#communityList">

                            <i class="fa-solid fa-people-roof"></i>

                            Kamma

                        </a>


                        <a href="#communityList">

                            <i class="fa-solid fa-user-group"></i>

                            Kapu

                        </a>


                        <a href="#communityList">

                            <i class="fa-solid fa-people-arrows"></i>

                            Banjara

                        </a>


                        <a
                            href="#communityList"
                            class="pl-dropdown-all"
                        >

                            View All Communities

                            <i class="fa-solid fa-arrow-right"></i>

                        </a>

                    </div>

                </div>


                <!-- =============================================
                     SERVICES
                ============================================== -->

                <a
                    href="service.php"
                    class="pl-nav-link"
                >
                    Services
                </a>


                <!-- =============================================
                     ABOUT
                ============================================== -->

                <a
                    href="about.php"
                    class="pl-nav-link"
                >
                    About Us
                </a>


                <!-- =============================================
                     EVENTS
                ============================================== -->

                <a
                    href="#events"
                    class="pl-nav-link"
                >
                    Events
                </a>


                <!-- =============================================
                     CONTACT
                ============================================== -->

                <a
                    href="#contact"
                    class="pl-nav-link"
                >
                    Contact
                </a>


                <!-- =============================================
                     MOBILE ACTIONS
                ============================================== -->

                <div class="pl-mobile-actions">

                    <a
                        href="#communityList"
                        class="pl-mobile-community"
                    >

                        <i class="fa-solid fa-users"></i>

                        Select Your Community

                    </a>


                    <a
                        href="#downloadApp"
                        class="pl-mobile-download"
                    >

                        <i class="fa-solid fa-mobile-screen-button"></i>

                        Download App

                    </a>

                </div>


            </nav>


            <!-- =================================================
                 DESKTOP ACTIONS
            ================================================== -->

            <div class="pl-header-actions">


                <!-- Login -->

                <a
                    href="#login"
                    class="pl-login"
                >

                    <i class="fa-regular fa-user"></i>

                    Login

                </a>


                <!-- Select Community -->

                <a
                    href="#communityList"
                    class="pl-community-button"
                >

                    <i class="fa-solid fa-users"></i>

                    Select Community

                </a>


                <!-- Download App -->

                <a
                    href="#downloadApp"
                    class="pl-download-button"
                >

                    <i class="fa-solid fa-mobile-screen-button"></i>

                    Download App

                </a>


            </div>

        </div>

    </div>

</header>


 

<main class="pl-post-listing-page">

    <!-- HERO -->
    <section class="pl-listing-hero">
        <div class="pl-listing-hero-overlay"></div>

        <div class="pl-listing-hero-content">
            <span class="pl-listing-eyebrow">
                <i class="bi bi-shop-window"></i> PeopleLink Marketplace
            </span>

            <h1>Post a Property or Product</h1>

            <p>
                Create your marketplace listing and connect with the right audience
                across the PeopleLink network.
            </p>

            <div class="pl-hero-actions">
                <button type="button" class="pl-btn pl-btn-primary" onclick="scrollToListingForm()">
                    <i class="bi bi-plus-circle"></i>
                    Create Listing
                </button>

                <button type="button" class="pl-btn pl-btn-light" onclick="openMyListings()">
                    <i class="bi bi-list-ul"></i>
                    My Listings
                </button>
            </div>
        </div>
    </section>


    <!-- LISTING FORM -->
    <section class="pl-listing-section" id="listingFormSection">

        <div class="pl-listing-container">

            <div class="pl-section-heading">
                <span>
                    <i class="bi bi-pencil-square"></i>
                    Create Your Marketplace Listing
                </span>

                <h2>Post Once. Reach the Right Audience.</h2>

                <p>
                    Select your listing category and complete only the information
                    relevant to your property, vehicle, electronics or product.
                </p>
            </div>


            <form id="plMarketplaceForm" class="pl-marketplace-form" enctype="multipart/form-data">

                <!-- CATEGORY -->
                <div class="pl-form-block">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-grid-1x2-fill"></i>
                        </div>

                        <div>
                            <h3>Select Listing Category</h3>
                            <p>Choose what you want to post.</p>
                        </div>
                    </div>

                    <div class="pl-category-grid">

                        <button type="button" class="pl-category-card active" data-category="property">
                            <i class="bi bi-house-door-fill"></i>
                            <span>Property</span>
                        </button>

                        <button type="button" class="pl-category-card" data-category="car">
                            <i class="bi bi-car-front-fill"></i>
                            <span>Car</span>
                        </button>

                        <button type="button" class="pl-category-card" data-category="bike">
                            <i class="bi bi-bicycle"></i>
                            <span>Bike</span>
                        </button>

                        <button type="button" class="pl-category-card" data-category="electronics">
                            <i class="bi bi-phone-fill"></i>
                            <span>Electronics</span>
                        </button>

                        <button type="button" class="pl-category-card" data-category="furniture">
                            <i class="bi bi-lamp-fill"></i>
                            <span>Furniture</span>
                        </button>

                        <button type="button" class="pl-category-card" data-category="machinery">
                            <i class="bi bi-gear-wide-connected"></i>
                            <span>Machinery</span>
                        </button>

                        <button type="button" class="pl-category-card" data-category="equipment">
                            <i class="bi bi-tools"></i>
                            <span>Equipment</span>
                        </button>

                        <button type="button" class="pl-category-card" data-category="other">
                            <i class="bi bi-box-seam-fill"></i>
                            <span>Other</span>
                        </button>

                    </div>

                    <input type="hidden" name="category" id="listingCategory" value="property">

                    <div class="pl-selected-category">
                        <i class="bi bi-check-circle-fill"></i>
                        Selected Category:
                        <strong id="selectedCategoryText">Property</strong>
                    </div>

                </div>


                <!-- LISTING TYPE -->
                <div class="pl-form-block">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-tags-fill"></i>
                        </div>

                        <div>
                            <h3>Listing Type</h3>
                            <p>Select how you want to list your item.</p>
                        </div>
                    </div>

                    <div class="pl-option-row">

                        <label class="pl-option">
                            <input type="radio" name="listing_type" value="sale" checked>
                            <span>
                                <i class="bi bi-currency-rupee"></i>
                                For Sale
                            </span>
                        </label>

                        <label class="pl-option property-only-option">
                            <input type="radio" name="listing_type" value="rent">
                            <span>
                                <i class="bi bi-key-fill"></i>
                                For Rent
                            </span>
                        </label>

                        <label class="pl-option">
                            <input type="radio" name="listing_type" value="exchange">
                            <span>
                                <i class="bi bi-arrow-left-right"></i>
                                Exchange
                            </span>
                        </label>

                        <label class="pl-option product-only-option">
                            <input type="radio" name="listing_type" value="new">
                            <span>
                                <i class="bi bi-stars"></i>
                                New
                            </span>
                        </label>

                        <label class="pl-option product-only-option">
                            <input type="radio" name="listing_type" value="used">
                            <span>
                                <i class="bi bi-recycle"></i>
                                Used
                            </span>
                        </label>

                    </div>

                </div>


                <!-- BASIC INFORMATION -->
                <div class="pl-form-block">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>

                        <div>
                            <h3>Basic Information</h3>
                            <p>Enter the main information about your listing.</p>
                        </div>
                    </div>

                    <div class="pl-form-grid">

                        <div class="pl-field pl-span-2">
                            <label>Listing Title <span>*</span></label>
                            <input type="text" name="listing_title"
                                   placeholder="e.g. 3 BHK Family Home for Sale">
                        </div>

                        <div class="pl-field">
                            <label>Subcategory</label>
                            <input type="text" name="subcategory"
                                   placeholder="Enter subcategory">
                        </div>

                        <div class="pl-field">
                            <label>Price</label>
                            <input type="number" name="price"
                                   placeholder="₹ Expected price">
                        </div>

                        <div class="pl-field">
                            <label>Price Type</label>
                            <select name="price_type">
                                <option value="fixed">Fixed</option>
                                <option value="negotiable">Negotiable</option>
                            </select>
                        </div>

                        <div class="pl-field pl-span-2">
                            <label>Short Description</label>
                            <input type="text" name="short_description"
                                   maxlength="180"
                                   placeholder="Write a short description">
                        </div>

                        <div class="pl-field pl-span-2">
                            <label>Detailed Description</label>
                            <textarea name="description"
                                      id="listingDescription"
                                      rows="4"
                                      placeholder="Provide complete and accurate information about your listing..."></textarea>

                            <small>
                                <span id="descriptionCount">0</span>/1000 characters
                            </small>
                        </div>

                    </div>

                </div>


                <!-- PROPERTY -->
                <div class="pl-form-block dynamic-block" id="propertyFields">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-house-heart-fill"></i>
                        </div>

                        <div>
                            <h3>Property Details</h3>
                            <p>Enter property-specific information.</p>
                        </div>
                    </div>

                    <div class="pl-form-grid">

                        <div class="pl-field">
                            <label>Property Type</label>
                            <select name="property_type">
                                <option value="">Select Type</option>
                                <option>Apartment</option>
                                <option>Independent House</option>
                                <option>Villa</option>
                                <option>Builder Floor</option>
                                <option>Office</option>
                                <option>Shop</option>
                                <option>Commercial Property</option>
                                <option>Plot / Land</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Sale / Rent</label>
                            <select name="property_sale_rent">
                                <option value="">Select</option>
                                <option>For Sale</option>
                                <option>For Rent</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Property Area / Size</label>
                            <input type="text" name="property_area"
                                   placeholder="e.g. 1500 sq.ft">
                        </div>

                        <div class="pl-field">
                            <label>Bedrooms</label>
                            <select name="bedrooms">
                                <option value="">Select</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5+</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Bathrooms</label>
                            <select name="bathrooms">
                                <option value="">Select</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4+</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Floor</label>
                            <input type="text" name="floor"
                                   placeholder="e.g. 2nd Floor">
                        </div>

                        <div class="pl-field">
                            <label>Furnished Status</label>
                            <select name="furnished">
                                <option value="">Select</option>
                                <option>Fully Furnished</option>
                                <option>Semi Furnished</option>
                                <option>Unfurnished</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Facing</label>
                            <select name="facing">
                                <option value="">Select</option>
                                <option>North</option>
                                <option>South</option>
                                <option>East</option>
                                <option>West</option>
                                <option>North-East</option>
                                <option>North-West</option>
                                <option>South-East</option>
                                <option>South-West</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Parking</label>
                            <select name="parking">
                                <option value="">Select</option>
                                <option>Available</option>
                                <option>Not Available</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Property Age</label>
                            <input type="text" name="property_age"
                                   placeholder="e.g. 5 Years">
                        </div>

                        <div class="pl-field">
                            <label>Ownership Type</label>
                            <select name="ownership">
                                <option value="">Select</option>
                                <option>Freehold</option>
                                <option>Leasehold</option>
                                <option>Co-operative</option>
                                <option>Other</option>
                            </select>
                        </div>

                    </div>

                    <div class="pl-subheading">
                        <i class="bi bi-map-fill"></i>
                        Plot / Land Details
                    </div>

                    <div class="pl-form-grid">

                        <div class="pl-field">
                            <label>Plot Area</label>
                            <input type="text" name="plot_area"
                                   placeholder="e.g. 2000 sq.ft">
                        </div>

                        <div class="pl-field">
                            <label>Dimensions</label>
                            <input type="text" name="dimensions"
                                   placeholder="e.g. 40 × 50 ft">
                        </div>

                        <div class="pl-field">
                            <label>Road Width</label>
                            <input type="text" name="road_width"
                                   placeholder="e.g. 30 ft">
                        </div>

                        <div class="pl-field">
                            <label>Land Type</label>
                            <input type="text" name="land_type"
                                   placeholder="Residential / Commercial">
                        </div>

                        <div class="pl-field pl-span-2">
                            <label>Approval Information</label>
                            <input type="text" name="approval_information"
                                   placeholder="Enter applicable approval details">
                        </div>

                    </div>

                </div>


                <!-- CAR -->
                <div class="pl-form-block dynamic-block" id="carFields">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-car-front-fill"></i>
                        </div>

                        <div>
                            <h3>Car Details</h3>
                            <p>Provide vehicle information.</p>
                        </div>
                    </div>

                    <div class="pl-form-grid">

                        <div class="pl-field">
                            <label>Brand</label>
                            <input type="text" name="car_brand" placeholder="e.g. Hyundai">
                        </div>

                        <div class="pl-field">
                            <label>Model</label>
                            <input type="text" name="car_model" placeholder="e.g. Creta">
                        </div>

                        <div class="pl-field">
                            <label>Variant</label>
                            <input type="text" name="car_variant">
                        </div>

                        <div class="pl-field">
                            <label>Manufacturing Year</label>
                            <input type="number" name="car_manufacturing_year"
                                   placeholder="2024">
                        </div>

                        <div class="pl-field">
                            <label>Registration Year</label>
                            <input type="number" name="car_registration_year">
                        </div>

                        <div class="pl-field">
                            <label>Fuel Type</label>
                            <select name="car_fuel">
                                <option value="">Select</option>
                                <option>Petrol</option>
                                <option>Diesel</option>
                                <option>CNG</option>
                                <option>Electric</option>
                                <option>Hybrid</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Transmission</label>
                            <select name="car_transmission">
                                <option value="">Select</option>
                                <option>Manual</option>
                                <option>Automatic</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Kilometres Driven</label>
                            <input type="number" name="car_km">
                        </div>

                        <div class="pl-field">
                            <label>Number of Owners</label>
                            <select name="car_owners">
                                <option value="">Select</option>
                                <option>1st Owner</option>
                                <option>2nd Owner</option>
                                <option>3rd Owner</option>
                                <option>4+ Owners</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Colour</label>
                            <input type="text" name="car_colour">
                        </div>

                        <div class="pl-field">
                            <label>Registration State</label>
                            <input type="text" name="car_registration_state">
                        </div>

                        <div class="pl-field">
                            <label>Insurance Status</label>
                            <select name="car_insurance">
                                <option value="">Select</option>
                                <option>Valid</option>
                                <option>Expired</option>
                                <option>Not Available</option>
                            </select>
                        </div>

                    </div>

                </div>


                <!-- BIKE -->
                <div class="pl-form-block dynamic-block" id="bikeFields">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-bicycle"></i>
                        </div>

                        <div>
                            <h3>Bike Details</h3>
                            <p>Provide two-wheeler information.</p>
                        </div>
                    </div>

                    <div class="pl-form-grid">

                        <div class="pl-field">
                            <label>Brand</label>
                            <input type="text" name="bike_brand">
                        </div>

                        <div class="pl-field">
                            <label>Model</label>
                            <input type="text" name="bike_model">
                        </div>

                        <div class="pl-field">
                            <label>Variant</label>
                            <input type="text" name="bike_variant">
                        </div>

                        <div class="pl-field">
                            <label>Year</label>
                            <input type="number" name="bike_year">
                        </div>

                        <div class="pl-field">
                            <label>Kilometres Driven</label>
                            <input type="number" name="bike_km">
                        </div>

                        <div class="pl-field">
                            <label>Fuel Type</label>
                            <select name="bike_fuel">
                                <option value="">Select</option>
                                <option>Petrol</option>
                                <option>Electric</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Number of Owners</label>
                            <select name="bike_owners">
                                <option value="">Select</option>
                                <option>1st Owner</option>
                                <option>2nd Owner</option>
                                <option>3rd Owner</option>
                                <option>4+ Owners</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Colour</label>
                            <input type="text" name="bike_colour">
                        </div>

                        <div class="pl-field">
                            <label>Registration State</label>
                            <input type="text" name="bike_registration_state">
                        </div>

                        <div class="pl-field">
                            <label>Insurance Status</label>
                            <select name="bike_insurance">
                                <option value="">Select</option>
                                <option>Valid</option>
                                <option>Expired</option>
                                <option>Not Available</option>
                            </select>
                        </div>

                    </div>

                </div>


                <!-- ELECTRONICS -->
                <div class="pl-form-block dynamic-block" id="electronicsFields">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-phone-fill"></i>
                        </div>

                        <div>
                            <h3>Electronics Details</h3>
                            <p>Provide product information.</p>
                        </div>
                    </div>

                    <div class="pl-form-grid">

                        <div class="pl-field">
                            <label>Product Name</label>
                            <input type="text" name="electronic_product">
                        </div>

                        <div class="pl-field">
                            <label>Brand</label>
                            <input type="text" name="electronic_brand">
                        </div>

                        <div class="pl-field">
                            <label>Model</label>
                            <input type="text" name="electronic_model">
                        </div>

                        <div class="pl-field">
                            <label>Purchase Year</label>
                            <input type="number" name="purchase_year">
                        </div>

                        <div class="pl-field">
                            <label>Condition</label>
                            <select name="electronic_condition">
                                <option value="">Select</option>
                                <option>New</option>
                                <option>Like New</option>
                                <option>Excellent</option>
                                <option>Good</option>
                                <option>Used</option>
                                <option>Refurbished</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Warranty Status</label>
                            <select name="warranty">
                                <option value="">Select</option>
                                <option>Under Warranty</option>
                                <option>Warranty Expired</option>
                                <option>No Warranty</option>
                            </select>
                        </div>

                        <div class="pl-field pl-span-2">
                            <label>Accessories Included</label>
                            <input type="text" name="accessories"
                                   placeholder="Charger, box, remote, cables etc.">
                        </div>

                        <div class="pl-field pl-span-2">
                            <label>Usage Details</label>
                            <textarea name="electronic_usage" rows="3"
                                      placeholder="Describe usage and condition..."></textarea>
                        </div>

                    </div>

                </div>


                <!-- OTHER -->
                <div class="pl-form-block dynamic-block" id="otherFields">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>

                        <div>
                            <h3>Other Product Details</h3>
                            <p>For furniture, machinery, equipment and other marketplace items.</p>
                        </div>
                    </div>

                    <div class="pl-form-grid">

                        <div class="pl-field">
                            <label>Product Name</label>
                            <input type="text" name="other_product">
                        </div>

                        <div class="pl-field">
                            <label>Brand / Model</label>
                            <input type="text" name="other_brand_model">
                        </div>

                        <div class="pl-field">
                            <label>Condition</label>
                            <select name="other_condition">
                                <option value="">Select</option>
                                <option>New</option>
                                <option>Like New</option>
                                <option>Excellent</option>
                                <option>Good</option>
                                <option>Used</option>
                                <option>Refurbished</option>
                            </select>
                        </div>

                        <div class="pl-field">
                            <label>Quantity</label>
                            <input type="number" name="quantity" min="1">
                        </div>

                        <div class="pl-field">
                            <label>Age of Product</label>
                            <input type="text" name="product_age"
                                   placeholder="e.g. 2 Years">
                        </div>

                        <div class="pl-field">
                            <label>Product Status</label>
                            <select name="product_status">
                                <option value="">Select</option>
                                <option>Available</option>
                                <option>Used</option>
                                <option>Refurbished</option>
                                <option>Pre-Order</option>
                            </select>
                        </div>

                        <div class="pl-field pl-span-2">
                            <label>Usage Details</label>
                            <textarea name="other_usage" rows="3"></textarea>
                        </div>

                        <div class="pl-field pl-span-2">
                            <label>Other Specifications</label>
                            <textarea name="other_specs" rows="3"
                                      placeholder="Add dimensions, capacity, specifications etc."></textarea>
                        </div>

                    </div>

                </div>


                <!-- PRICE -->
                <div class="pl-form-block">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>

                        <div>
                            <h3>Price Details</h3>
                            <p>Set the expected price for your listing.</p>
                        </div>
                    </div>

                    <div class="pl-form-grid">

                        <div class="pl-field">
                            <label>Expected Price</label>
                            <div class="pl-input-prefix">
                                <span>₹</span>
                                <input type="number" name="expected_price"
                                       placeholder="0">
                            </div>
                        </div>

                        <div class="pl-field">
                            <label>Price Option</label>
                            <select name="price_option">
                                <option>Fixed</option>
                                <option>Negotiable</option>
                            </select>
                        </div>

                        <div class="pl-field rental-field">
                            <label>Monthly Rent</label>
                            <div class="pl-input-prefix">
                                <span>₹</span>
                                <input type="number" name="monthly_rent">
                            </div>
                        </div>

                        <div class="pl-field rental-field">
                            <label>Security Deposit</label>
                            <div class="pl-input-prefix">
                                <span>₹</span>
                                <input type="number" name="security_deposit">
                            </div>
                        </div>

                    </div>

                </div>


                <!-- LOCATION -->
                <div class="pl-form-block">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>

                        <div>
                            <h3>Location</h3>
                            <p>Enter the approved location for your listing.</p>
                        </div>
                    </div>

                    <div class="pl-form-grid">

                        <div class="pl-field">
                            <label>Country</label>
                            <input type="text" name="country" value="India">
                        </div>

                        <div class="pl-field">
                            <label>State</label>
                            <input type="text" name="state"
                                   placeholder="State">
                        </div>

                        <div class="pl-field">
                            <label>District</label>
                            <input type="text" name="district">
                        </div>

                        <div class="pl-field">
                            <label>City</label>
                            <input type="text" name="city">
                        </div>

                        <div class="pl-field">
                            <label>Area / Locality</label>
                            <input type="text" name="area">
                        </div>

                        <div class="pl-field">
                            <label>Pincode</label>
                            <input type="text" name="pincode"
                                   maxlength="6">
                        </div>

                        <div class="pl-field pl-span-2">
                            <label>Landmark</label>
                            <input type="text" name="landmark"
                                   placeholder="Nearby landmark">
                        </div>

                    </div>

                    <button type="button" class="pl-location-btn" onclick="selectLocation()">
                        <i class="bi bi-crosshair2"></i>
                        Select Location on Map
                    </button>

                </div>


                <!-- IMAGE UPLOAD -->
                <div class="pl-form-block">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-images"></i>
                        </div>

                        <div>
                            <h3>Upload Images</h3>
                            <p>Upload clear and approved images of your listing.</p>
                        </div>
                    </div>

                    <div class="pl-upload-box" id="imageDropZone">

                        <input type="file"
                               id="listingImages"
                               name="listing_images[]"
                               accept="image/*"
                               multiple
                               hidden>

                        <div class="pl-upload-icon">
                            <i class="bi bi-cloud-arrow-up-fill"></i>
                        </div>

                        <h4>Upload Listing Images</h4>

                        <p>
                            Drag & drop images here or click to browse
                        </p>

                        <button type="button"
                                class="pl-upload-btn"
                                onclick="document.getElementById('listingImages').click()">
                            <i class="bi bi-folder2-open"></i>
                            Upload Images
                        </button>

                        <small>
                            One image can be selected as the primary image.
                        </small>

                    </div>

                    <div class="pl-image-preview" id="imagePreview"></div>

                </div>


                <!-- VISIBILITY -->
                <div class="pl-form-block">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-eye-fill"></i>
                        </div>

                        <div>
                            <h3>Choose Visibility</h3>
                            <p>Control who can discover your listing.</p>
                        </div>
                    </div>

                    <div class="pl-visibility-grid">

                        <label class="pl-visibility-card active">
                            <input type="radio"
                                   name="visibility"
                                   value="community"
                                   checked>

                            <span class="pl-visibility-icon">
                                <i class="bi bi-people-fill"></i>
                            </span>

                            <strong>Community-Specific</strong>

                            <small>
                                Visible only within the selected community.
                            </small>
                        </label>

                        <label class="pl-visibility-card">
                            <input type="radio"
                                   name="visibility"
                                   value="global">

                            <span class="pl-visibility-icon">
                                <i class="bi bi-globe2"></i>
                            </span>

                            <strong>Global</strong>

                            <small>
                                Visible across eligible PeopleLink users.
                            </small>
                        </label>

                    </div>

                    <div class="pl-field community-select">
                        <label>Select Community</label>

                        <select name="community">
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

                </div>


                <!-- SELLER -->
                <div class="pl-form-block">

                    <div class="pl-block-heading">
                        <div class="pl-block-icon">
                            <i class="bi bi-person-vcard-fill"></i>
                        </div>

                        <div>
                            <h3>Seller Contact Details</h3>
                            <p>Your contact information will follow configured privacy rules.</p>
                        </div>
                    </div>

                    <div class="pl-form-grid">

                        <div class="pl-field">
                            <label>Contact Person <span>*</span></label>
                            <input type="text" name="contact_person">
                        </div>

                        <div class="pl-field">
                            <label>Mobile Number <span>*</span></label>
                            <input type="tel" name="mobile"
                                   placeholder="+91">
                        </div>

                        <div class="pl-field">
                            <label>Email</label>
                            <input type="email" name="email">
                        </div>

                        <div class="pl-field">
                            <label>WhatsApp</label>
                            <input type="tel" name="whatsapp"
                                   placeholder="+91">
                        </div>

                        <div class="pl-field pl-span-2">
                            <label>Preferred Contact Method</label>

                            <select name="preferred_contact">
                                <option>Enquiry Form</option>
                                <option>Phone</option>
                                <option>WhatsApp</option>
                                <option>Email</option>
                            </select>
                        </div>

                    </div>

                    <label class="pl-checkbox-row">

                        <input type="checkbox"
                               name="enable_enquiry"
                               checked>

                        <span>
                            <i class="bi bi-chat-square-text-fill"></i>
                            Enable enquiry form so buyers can contact me without
                            directly exposing personal contact information.
                        </span>

                    </label>

                </div>


                <!-- AGREEMENT -->
                <div class="pl-form-block pl-guidelines-block">

                    <div class="pl-guideline-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <div>
                        <h3>Listing Guidelines</h3>

                        <p>
                            Please submit genuine and accurate information.
                            Prohibited, misleading or inappropriate products
                            should not be published on PeopleLink.
                        </p>

                        <label class="pl-checkbox-row">
                            <input type="checkbox"
                                   id="listingAgreement">

                            <span>
                                I confirm that the information provided is accurate
                                and I agree to the marketplace guidelines.
                            </span>
                        </label>
                    </div>

                </div>


                <!-- ACTIONS -->
                <div class="pl-form-actions">

                    <button type="button"
                            class="pl-action-btn pl-action-secondary"
                            onclick="saveListingDraft()">
                        <i class="bi bi-save2-fill"></i>
                        Save Draft
                    </button>

                    <button type="button"
                            class="pl-action-btn pl-action-preview"
                            onclick="previewListing()">
                        <i class="bi bi-eye-fill"></i>
                        Preview Listing
                    </button>

                    <button type="submit"
                            class="pl-action-btn pl-action-primary">
                        <i class="bi bi-send-fill"></i>
                        Submit for Approval
                    </button>

                </div>

            </form>


            <!-- STATUS -->
            <div class="pl-status-box">

                <div class="pl-status-title">
                    <i class="bi bi-diagram-3-fill"></i>
                    Listing Approval Flow
                </div>

                <div class="pl-status-flow">

                    <span>
                        <i class="bi bi-file-earmark"></i>
                        Draft
                    </span>

                    <b>→</b>

                    <span>
                        <i class="bi bi-hourglass-split"></i>
                        Pending Approval
                    </span>

                    <b>→</b>

                    <span>
                        <i class="bi bi-check-circle"></i>
                        Approved
                    </span>

                    <b>→</b>

                    <span>
                        <i class="bi bi-pencil-square"></i>
                        Requires Changes
                    </span>

                    <b>→</b>

                    <span>
                        <i class="bi bi-x-circle"></i>
                        Rejected
                    </span>

                </div>

            </div>


            <!-- MANAGE LISTINGS -->
            <div class="pl-manage-box">

                <div>
                    <span class="pl-manage-icon">
                        <i class="bi bi-collection-fill"></i>
                    </span>

                    <div>
                        <h3>Manage My Listings</h3>
                        <p>
                            Edit permitted details, update prices, manage images,
                            view approval status and close your listings.
                        </p>
                    </div>
                </div>

                <button type="button"
                        class="pl-btn pl-btn-outline"
                        onclick="openMyListings()">
                    <i class="bi bi-arrow-right"></i>
                    My Listings
                </button>

            </div>


        </div>

    </section>


    <!-- CTA -->
    <section class="pl-listing-cta">

        <div class="pl-cta-content">

            <span>
                <i class="bi bi-megaphone-fill"></i>
                PeopleLink Marketplace
            </span>

            <h2>Post Once. Reach the Right Audience.</h2>

            <p>
                List your property, vehicle or product and connect with
                interested buyers through PeopleLink.
            </p>

            <div class="pl-cta-actions">

                <button type="button"
                        class="pl-btn pl-btn-primary"
                        onclick="scrollToListingForm()">
                    <i class="bi bi-plus-circle-fill"></i>
                    Create Listing
                </button>

                <button type="button"
                        class="pl-btn pl-btn-light"
                        onclick="openMyListings()">
                    <i class="bi bi-list-check"></i>
                    My Listings
                </button>

                <button type="button"
                        class="pl-btn pl-btn-light"
                        onclick="previewListing()">
                    <i class="bi bi-eye-fill"></i>
                    Preview
                </button>

            </div>

        </div>

    </section>


    <!-- PREVIEW MODAL -->
    <div class="pl-modal" id="listingPreviewModal">

        <div class="pl-modal-dialog">

            <button type="button"
                    class="pl-modal-close"
                    onclick="closeListingPreview()">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="pl-modal-icon">
                <i class="bi bi-eye-fill"></i>
            </div>

            <h3>Listing Preview</h3>

            <p>
                This is how your marketplace listing information can be presented.
            </p>

            <div class="pl-preview-card">

                <div class="pl-preview-image" id="previewImage">
                    <i class="bi bi-image"></i>
                </div>

                <div class="pl-preview-content">

                    <span class="pl-preview-category"
                          id="previewCategory">
                        Property
                    </span>

                    <h4 id="previewTitle">
                        Your Listing Title
                    </h4>

                    <strong id="previewPrice">
                        ₹ Price
                    </strong>

                    <p id="previewLocation">
                        <i class="bi bi-geo-alt-fill"></i>
                        Location
                    </p>

                    <p id="previewDescription">
                        Listing description will appear here.
                    </p>

                </div>

            </div>

            <button type="button"
                    class="pl-btn pl-btn-primary pl-modal-btn"
                    onclick="closeListingPreview()">
                <i class="bi bi-check2"></i>
                Continue Editing
            </button>

        </div>

    </div>


    <!-- TOAST -->
    <div class="pl-listing-toast" id="listingToast">
        <i class="bi bi-check-circle-fill"></i>
        <span id="listingToastText">Saved successfully.</span>
    </div>

</main>





<!-- =========================================================
     PEOPLELINK FOOTER
========================================================= -->

<footer class="pl-footer" id="contact">


    <!-- =====================================================
         FOOTER TOP CTA
    ====================================================== -->

    <div class="pl-footer-cta">

        <div class="pl-footer-container">

            <div class="pl-footer-cta-content">

                <span class="pl-footer-eyebrow">
                    CONNECT • DISCOVER • BELONG
                </span>

                <h2>
                    Your Community.
                    <span>Your Connections.</span>
                </h2>

                <p>
                    Join your community on PeopleLink and discover
                    meaningful relationships, opportunities, trusted
                    services, businesses and events — all in one place.
                </p>

            </div>


            <div class="pl-footer-cta-actions">

                <a
                    href="#communityList"
                    class="pl-footer-primary-btn"
                >

                    <i class="fa-solid fa-users"></i>

                    Choose Your Community

                    <i class="fa-solid fa-arrow-right"></i>

                </a>


                <a
                    href="#downloadApp"
                    class="pl-footer-secondary-btn"
                >

                    <i class="fa-solid fa-mobile-screen-button"></i>

                    Download App

                </a>

            </div>

        </div>

    </div>



    <!-- =====================================================
         MAIN FOOTER
    ====================================================== -->

    <div class="pl-footer-main">

        <div class="pl-footer-container">

            <div class="pl-footer-grid">


                <!-- =================================================
                     BRAND
                ================================================== -->

                <div class="pl-footer-brand">

                    <a
                        href="index.php"
                        class="pl-footer-logo"
                    >

                        <img
                            src="images/logo.jpeg"
                            alt="PeopleLink"
                        >

                    </a>


                    <p>
                        PeopleLink brings communities together,
                        helping people connect with family,
                        discover opportunities, build relationships
                        and access trusted services.
                    </p>


                    <!-- Social Media -->

                    <div class="pl-footer-social">

                        <a
                            href="#"
                            aria-label="Facebook"
                        >
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>

                        <a
                            href="#"
                            aria-label="Instagram"
                        >
                            <i class="fa-brands fa-instagram"></i>
                        </a>

                        <a
                            href="#"
                            aria-label="LinkedIn"
                        >
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>

                        <a
                            href="#"
                            aria-label="YouTube"
                        >
                            <i class="fa-brands fa-youtube"></i>
                        </a>

                        <a
                            href="#"
                            aria-label="X"
                        >
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>

                    </div>

                </div>



                <!-- =================================================
                     PEOPLELINK
                ================================================== -->

                <div class="pl-footer-column">

                    <h3>
                        PeopleLink
                    </h3>

                    <ul>

                        <li>
                            <a href="index.php">
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="#about">
                                About Us
                            </a>
                        </li>

                        <li>
                            <a href="#communityList">
                                Our Communities
                            </a>
                        </li>

                        <li>
                            <a href="#platformServices">
                                Our Services
                            </a>
                        </li>

                        <li>
                            <a href="#events">
                                Events
                            </a>
                        </li>

                        <li>
                            <a href="#contact">
                                Contact Us
                            </a>
                        </li>

                    </ul>

                </div>



                <!-- =================================================
                     COMMUNITY
                ================================================== -->

                <div class="pl-footer-column">

                    <h3>
                        Community
                    </h3>

                    <ul>

                        <li>
                            <a href="#communityList">
                                Matrimony & Relationships
                            </a>
                        </li>

                        <li>
                            <a href="#platformServices">
                                Family & Community
                            </a>
                        </li>

                        <li>
                            <a href="#platformServices">
                                Jobs & Career
                            </a>
                        </li>

                        <li>
                            <a href="#platformServices">
                                Professionals & Businesses
                            </a>
                        </li>

                        <li>
                            <a href="#platformServices">
                                Marketplace
                            </a>
                        </li>

                        <li>
                            <a href="#events">
                                Community Events
                            </a>
                        </li>

                    </ul>

                </div>



                <!-- =================================================
                     SUPPORT
                ================================================== -->

                <div class="pl-footer-column">

                    <h3>
                        Support
                    </h3>

                    <ul>

                        <li>
                            <a href="#help">
                                Help Center
                            </a>
                        </li>

                        <li>
                            <a href="#contact">
                                Contact Support
                            </a>
                        </li>

                        <li>
                            <a href="#faq">
                                FAQs
                            </a>
                        </li>

                        <li>
                            <a href="#privacy">
                                Privacy Policy
                            </a>
                        </li>

                        <li>
                            <a href="#terms">
                                Terms & Conditions
                            </a>
                        </li>

                        <li>
                            <a href="#safety">
                                Community Guidelines
                            </a>
                        </li>

                    </ul>

                </div>



                <!-- =================================================
                     CONTACT
                ================================================== -->

                <div class="pl-footer-contact">

                    <h3>
                        Get In Touch
                    </h3>


                    <!-- Location -->

                    <a
                        href="#"
                        class="pl-contact-item"
                    >

                        <div class="pl-contact-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>

                        <div>

                            <span>
                                Location
                            </span>

                            <strong>
                                India
                            </strong>

                        </div>

                    </a>


                    <!-- Email -->

                    <a
                        href="mailto:info@peoplelink.com"
                        class="pl-contact-item"
                    >

                        <div class="pl-contact-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>

                        <div>

                            <span>
                                Email
                            </span>

                            <strong>
                                info@peoplelink.com
                            </strong>

                        </div>

                    </a>


                    <!-- Phone -->

                    <a
                        href="tel:+910000000000"
                        class="pl-contact-item"
                    >

                        <div class="pl-contact-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>

                        <div>

                            <span>
                                Phone
                            </span>

                            <strong>
                                +91 00000 00000
                            </strong>

                        </div>

                    </a>


                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         COMMUNITY STRIP
    ====================================================== -->

    <div class="pl-footer-community-strip">

        <div class="pl-footer-container">

            <div class="pl-community-strip-content">

                <div class="pl-strip-icon">

                    <i class="fa-solid fa-people-group"></i>

                </div>

                <div>

                    <strong>
                        One Platform. Many Communities.
                    </strong>

                    <span>
                        Bringing people, families and opportunities
                        closer together.
                    </span>

                </div>

            </div>


            <div class="pl-strip-items">

                <span>
                    <i class="fa-solid fa-heart"></i>
                    Relationships
                </span>

                <span>
                    <i class="fa-solid fa-briefcase"></i>
                    Opportunities
                </span>

                <span>
                    <i class="fa-solid fa-store"></i>
                    Businesses
                </span>

                <span>
                    <i class="fa-solid fa-calendar-days"></i>
                    Events
                </span>

            </div>

        </div>

    </div>



    <!-- =====================================================
         FOOTER BOTTOM
    ====================================================== -->

    <div class="pl-footer-bottom">

        <div class="pl-footer-container">

            <div class="pl-copyright">

                ©
                <span id="plCopyrightYear"></span>
                PeopleLink Technologies Private Limited.
                All Rights Reserved.

            </div>


            <div class="pl-footer-bottom-links">

                <a href="#privacy">
                    Privacy
                </a>

                <a href="#terms">
                    Terms
                </a>

                <a href="#cookies">
                    Cookies
                </a>

            </div>


            <div class="pl-back-top">

                <button
                    type="button"
                    id="plBackToTop"
                    aria-label="Back to top"
                >

                    <i class="fa-solid fa-arrow-up"></i>

                </button>

            </div>

        </div>

    </div>

</footer>

<script src="header.js"></script>
<script src="post-property-product.js"></script>
</body>
</html>
