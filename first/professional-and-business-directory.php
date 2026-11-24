<?php include 'header.php'; ?>

<div class="pl-directory-page">

    <!-- =====================================================
         HERO
    ====================================================== -->

    <section class="pl-directory-hero">

        <div class="pl-directory-container">

            <div class="pl-directory-hero-content">

                <span class="pl-directory-badge">
                    <i class="bi bi-people-fill"></i>
                    PeopleLink Professional Network
                </span>

                <h1>
                    Discover Trusted
                    <span>Professionals & Businesses</span>
                </h1>

                <p>
                    Find professionals, entrepreneurs, businesses and service
                    providers registered within the PeopleLink ecosystem.
                </p>

                <div class="pl-directory-hero-note">
                    <i class="bi bi-check-circle-fill"></i>

                    <span>
                        Explore listings based on your selected community,
                        profession, business category and location.
                    </span>
                </div>

                <div class="pl-directory-hero-buttons">

                    <a href="#directory-search"
                       class="pl-directory-btn primary">
                        <i class="bi bi-search"></i>
                        Find Professionals
                    </a>

                    <a href="#businesses"
                       class="pl-directory-btn secondary">
                        <i class="bi bi-building"></i>
                        Explore Businesses
                    </a>

                </div>

            </div>


            <!-- HERO VISUAL -->

            <div class="pl-directory-hero-visual">

                <div class="pl-directory-main-circle">

                    <div class="pl-directory-center-icon">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>

                    <strong>
                        PeopleLink
                    </strong>

                    <span>
                        Professional Directory
                    </span>

                </div>


                <div class="pl-directory-floating-card card-doctor">

                    <div class="pl-floating-icon blue">
                        <i class="bi bi-heart-pulse"></i>
                    </div>

                    <div>
                        <strong>Doctors</strong>
                        <span>Professionals</span>
                    </div>

                </div>


                <div class="pl-directory-floating-card card-business">

                    <div class="pl-floating-icon green">
                        <i class="bi bi-shop"></i>
                    </div>

                    <div>
                        <strong>Businesses</strong>
                        <span>Local Services</span>
                    </div>

                </div>


                <div class="pl-directory-floating-card card-lawyer">

                    <div class="pl-floating-icon purple">
                        <i class="bi bi-bank"></i>
                    </div>

                    <div>
                        <strong>Lawyers</strong>
                        <span>Professionals</span>
                    </div>

                </div>


                <div class="pl-directory-floating-card card-engineer">

                    <div class="pl-floating-icon orange">
                        <i class="bi bi-cpu"></i>
                    </div>

                    <div>
                        <strong>Engineers</strong>
                        <span>Experts</span>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         QUICK STATS
    ====================================================== -->

    <section class="pl-directory-stats">

        <div class="pl-directory-container">

            <div class="pl-stat-item">

                <div class="pl-stat-icon blue">
                    <i class="bi bi-person-badge"></i>
                </div>

                <div>
                    <strong>Professionals</strong>
                    <span>Across multiple fields</span>
                </div>

            </div>


            <div class="pl-stat-item">

                <div class="pl-stat-icon green">
                    <i class="bi bi-building"></i>
                </div>

                <div>
                    <strong>Businesses</strong>
                    <span>Community businesses</span>
                </div>

            </div>


            <div class="pl-stat-item">

                <div class="pl-stat-icon orange">
                    <i class="bi bi-geo-alt"></i>
                </div>

                <div>
                    <strong>Locations</strong>
                    <span>City to district discovery</span>
                </div>

            </div>


            <div class="pl-stat-item">

                <div class="pl-stat-icon purple">
                    <i class="bi bi-people"></i>
                </div>

                <div>
                    <strong>Communities</strong>
                    <span>Community-based discovery</span>
                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         SEARCH DIRECTORY
    ====================================================== -->

    <section class="pl-directory-search-section"
             id="directory-search">

        <div class="pl-directory-container">

            <div class="pl-directory-section-heading">

                <span class="section-label">
                    DIRECTORY SEARCH
                </span>

                <h2>
                    Search the Directory
                </h2>

                <p>
                    Find the right professional or business using
                    multiple directory filters.
                </p>

            </div>


            <div class="pl-directory-search-box">

                <div class="pl-search-top">

                    <div class="pl-search-main">

                        <i class="bi bi-search"></i>

                        <input type="text"
                               id="directoryKeyword"
                               placeholder="Search by name, profession or business...">

                    </div>

                    <button type="button"
                            class="pl-directory-search-button"
                            id="directorySearchBtn">

                        <i class="bi bi-search"></i>
                        Search

                    </button>

                </div>


                <div class="pl-directory-filters">

                    <div class="pl-filter">

                        <label>
                            Profession
                        </label>

                        <select id="professionFilter">

                            <option value="">
                                All Professions
                            </option>

                            <option>Doctors</option>
                            <option>Lawyers</option>
                            <option>Chartered Accountants</option>
                            <option>Engineers</option>
                            <option>Teachers</option>
                            <option>Consultants</option>
                            <option>IT Professionals</option>
                            <option>Architects</option>
                            <option>Real Estate Professionals</option>
                            <option>Financial Advisors</option>
                            <option>Other Professionals</option>

                        </select>

                    </div>


                    <div class="pl-filter">

                        <label>
                            Business Category
                        </label>

                        <select id="businessFilter">

                            <option value="">
                                All Business Categories
                            </option>

                            <option>Retail</option>
                            <option>Manufacturing</option>
                            <option>Healthcare</option>
                            <option>Education</option>
                            <option>Construction</option>
                            <option>Real Estate</option>
                            <option>IT Services</option>
                            <option>Finance</option>
                            <option>Food & Hospitality</option>
                            <option>Travel</option>
                            <option>Professional Services</option>
                            <option>Other Businesses</option>

                        </select>

                    </div>


                    <div class="pl-filter">

                        <label>
                            Community
                        </label>

                        <select id="communityFilter">

                            <option value="">
                                All Communities
                            </option>

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


                    <div class="pl-filter">

                        <label>
                            State
                        </label>

                        <select id="stateFilter">

                            <option value="">
                                Select State
                            </option>

                            <option>Uttarakhand</option>
                            <option>Uttar Pradesh</option>
                            <option>Delhi</option>
                            <option>Maharashtra</option>
                            <option>Telangana</option>
                            <option>Andhra Pradesh</option>
                            <option>Karnataka</option>
                            <option>Tamil Nadu</option>
                            <option>Other State</option>

                        </select>

                    </div>


                    <div class="pl-filter">

                        <label>
                            District
                        </label>

                        <select id="districtFilter">

                            <option value="">
                                Select District
                            </option>

                            <option>Dehradun</option>
                            <option>Haridwar</option>
                            <option>Rishikesh</option>
                            <option>Ghaziabad</option>
                            <option>Delhi</option>
                            <option>Other District</option>

                        </select>

                    </div>


                    <div class="pl-filter">

                        <label>
                            City
                        </label>

                        <select id="cityFilter">

                            <option value="">
                                Select City
                            </option>

                            <option>Rishikesh</option>
                            <option>Haridwar</option>
                            <option>Dehradun</option>
                            <option>Delhi</option>
                            <option>Ghaziabad</option>
                            <option>Other City</option>

                        </select>

                    </div>


                    <div class="pl-filter">

                        <label>
                            Service Type
                        </label>

                        <select id="serviceFilter">

                            <option value="">
                                All Service Types
                            </option>

                            <option>Professional Services</option>
                            <option>Business Services</option>
                            <option>Consulting</option>
                            <option>Healthcare Services</option>
                            <option>Education Services</option>
                            <option>Technology Services</option>
                            <option>Other Services</option>

                        </select>

                    </div>

                </div>


                <div class="pl-search-actions">

                    <button type="button"
                            class="pl-reset-button"
                            id="resetDirectory">

                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Filters

                    </button>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         PROFESSIONAL CATEGORIES
    ====================================================== -->

    <section class="pl-directory-category-section">

        <div class="pl-directory-container">

            <div class="pl-directory-section-heading centered">

                <span class="section-label">
                    PROFESSIONAL CATEGORIES
                </span>

                <h2>
                    Explore Professionals by Expertise
                </h2>

                <p>
                    Browse professionals across different fields and
                    areas of expertise.
                </p>

            </div>


            <div class="pl-category-grid">

                <a href="#" class="pl-category-card">

                    <div class="pl-category-icon blue">
                        <i class="bi bi-heart-pulse"></i>
                    </div>

                    <strong>Doctors</strong>

                    <span>Healthcare professionals</span>

                    <i class="bi bi-arrow-right"></i>

                </a>


                <a href="#" class="pl-category-card">

                    <div class="pl-category-icon purple">
                        <i class="bi bi-bank"></i>
                    </div>

                    <strong>Lawyers</strong>

                    <span>Legal professionals</span>

                    <i class="bi bi-arrow-right"></i>

                </a>


                <a href="#" class="pl-category-card">

                    <div class="pl-category-icon green">
                        <i class="bi bi-calculator"></i>
                    </div>

                    <strong>Chartered Accountants</strong>

                    <span>Finance professionals</span>

                    <i class="bi bi-arrow-right"></i>

                </a>


                <a href="#" class="pl-category-card">

                    <div class="pl-category-icon orange">
                        <i class="bi bi-cpu"></i>
                    </div>

                    <strong>Engineers</strong>

                    <span>Technical professionals</span>

                    <i class="bi bi-arrow-right"></i>

                </a>


                <a href="#" class="pl-category-card">

                    <div class="pl-category-icon red">
                        <i class="bi bi-mortarboard"></i>
                    </div>

                    <strong>Teachers</strong>

                    <span>Education professionals</span>

                    <i class="bi bi-arrow-right"></i>

                </a>


                <a href="#" class="pl-category-card">

                    <div class="pl-category-icon blue">
                        <i class="bi bi-lightbulb"></i>
                    </div>

                    <strong>Consultants</strong>

                    <span>Business consultants</span>

                    <i class="bi bi-arrow-right"></i>

                </a>


                <a href="#" class="pl-category-card">

                    <div class="pl-category-icon green">
                        <i class="bi bi-laptop"></i>
                    </div>

                    <strong>IT Professionals</strong>

                    <span>Technology experts</span>

                    <i class="bi bi-arrow-right"></i>

                </a>


                <a href="#" class="pl-category-card">

                    <div class="pl-category-icon purple">
                        <i class="bi bi-rulers"></i>
                    </div>

                    <strong>Architects</strong>

                    <span>Design professionals</span>

                    <i class="bi bi-arrow-right"></i>

                </a>


                <a href="#" class="pl-category-card">

                    <div class="pl-category-icon orange">
                        <i class="bi bi-buildings"></i>
                    </div>

                    <strong>Real Estate</strong>

                    <span>Property professionals</span>

                    <i class="bi bi-arrow-right"></i>

                </a>


                <a href="#" class="pl-category-card">

                    <div class="pl-category-icon green">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>

                    <strong>Financial Advisors</strong>

                    <span>Financial professionals</span>

                    <i class="bi bi-arrow-right"></i>

                </a>


                <a href="#" class="pl-category-card">

                    <div class="pl-category-icon blue">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <strong>Other Professionals</strong>

                    <span>Explore more expertise</span>

                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>

        </div>

    </section>


    <!-- =====================================================
         BUSINESS CATEGORIES
    ====================================================== -->

    <section class="pl-business-section"
             id="businesses">

        <div class="pl-directory-container">

            <div class="pl-directory-section-heading">

                <span class="section-label">
                    BUSINESS CATEGORIES
                </span>

                <h2>
                    Discover Community Businesses
                </h2>

                <p>
                    Explore businesses and service providers across
                    different industries.
                </p>

            </div>


            <div class="pl-business-grid">

                <div class="pl-business-card">
                    <i class="bi bi-shop"></i>
                    <strong>Retail</strong>
                    <span>Shops & retail services</span>
                </div>

                <div class="pl-business-card">
                    <i class="bi bi-gear"></i>
                    <strong>Manufacturing</strong>
                    <span>Manufacturing businesses</span>
                </div>

                <div class="pl-business-card">
                    <i class="bi bi-heart-pulse"></i>
                    <strong>Healthcare</strong>
                    <span>Healthcare businesses</span>
                </div>

                <div class="pl-business-card">
                    <i class="bi bi-mortarboard"></i>
                    <strong>Education</strong>
                    <span>Education services</span>
                </div>

                <div class="pl-business-card">
                    <i class="bi bi-buildings"></i>
                    <strong>Construction</strong>
                    <span>Construction services</span>
                </div>

                <div class="pl-business-card">
                    <i class="bi bi-house-door"></i>
                    <strong>Real Estate</strong>
                    <span>Property businesses</span>
                </div>

                <div class="pl-business-card">
                    <i class="bi bi-laptop"></i>
                    <strong>IT Services</strong>
                    <span>Technology businesses</span>
                </div>

                <div class="pl-business-card">
                    <i class="bi bi-cash-stack"></i>
                    <strong>Finance</strong>
                    <span>Financial services</span>
                </div>

                <div class="pl-business-card">
                    <i class="bi bi-cup-hot"></i>
                    <strong>Food & Hospitality</strong>
                    <span>Restaurants & hospitality</span>
                </div>

                <div class="pl-business-card">
                    <i class="bi bi-airplane"></i>
                    <strong>Travel</strong>
                    <span>Travel businesses</span>
                </div>

                <div class="pl-business-card">
                    <i class="bi bi-briefcase"></i>
                    <strong>Professional Services</strong>
                    <span>Business services</span>
                </div>

                <div class="pl-business-card">
                    <i class="bi bi-grid"></i>
                    <strong>Other Businesses</strong>
                    <span>Explore more categories</span>
                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         PROFESSIONAL LISTING
    ====================================================== -->

    <section class="pl-listing-section">

        <div class="pl-directory-container">

            <div class="pl-directory-section-heading centered">

                <span class="section-label">
                    PROFESSIONAL DIRECTORY
                </span>

                <h2>
                    Featured Professionals
                </h2>

                <p>
                    Discover registered professionals and explore
                    their expertise.
                </p>

            </div>


            <div class="pl-professional-grid">


                <div class="pl-professional-card">

                    <div class="pl-profile-top">

                        <div class="pl-profile-image">
                            <i class="bi bi-person"></i>
                        </div>

                        <span class="pl-verified">
                            <i class="bi bi-patch-check-fill"></i>
                            Verified
                        </span>

                    </div>

                    <h3>Professional Name</h3>

                    <strong>
                        Doctor
                    </strong>

                    <span class="pl-specialisation">
                        Medical Specialist
                    </span>

                    <div class="pl-profile-info">

                        <span>
                            <i class="bi bi-award"></i>
                            10+ Years Experience
                        </span>

                        <span>
                            <i class="bi bi-building"></i>
                            Organisation / Business
                        </span>

                        <span>
                            <i class="bi bi-geo-alt"></i>
                            City, State
                        </span>

                    </div>

                    <p>
                        Short professional introduction can appear here
                        to help users understand the professional's expertise.
                    </p>

                    <a href="#"
                       class="pl-card-button">
                        View Profile
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>


                <div class="pl-professional-card">

                    <div class="pl-profile-top">

                        <div class="pl-profile-image purple">
                            <i class="bi bi-person"></i>
                        </div>

                        <span class="pl-verified">
                            <i class="bi bi-patch-check-fill"></i>
                            Verified
                        </span>

                    </div>

                    <h3>Professional Name</h3>

                    <strong>
                        Lawyer
                    </strong>

                    <span class="pl-specialisation">
                        Corporate & Legal Services
                    </span>

                    <div class="pl-profile-info">

                        <span>
                            <i class="bi bi-award"></i>
                            8+ Years Experience
                        </span>

                        <span>
                            <i class="bi bi-building"></i>
                            Organisation / Business
                        </span>

                        <span>
                            <i class="bi bi-geo-alt"></i>
                            City, State
                        </span>

                    </div>

                    <p>
                        Short professional introduction can appear here
                        to help users understand the professional's expertise.
                    </p>

                    <a href="#"
                       class="pl-card-button">
                        View Profile
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>


                <div class="pl-professional-card">

                    <div class="pl-profile-top">

                        <div class="pl-profile-image green">
                            <i class="bi bi-person"></i>
                        </div>

                        <span class="pl-verified">
                            <i class="bi bi-patch-check-fill"></i>
                            Verified
                        </span>

                    </div>

                    <h3>Professional Name</h3>

                    <strong>
                        IT Professional
                    </strong>

                    <span class="pl-specialisation">
                        Technology & Digital Services
                    </span>

                    <div class="pl-profile-info">

                        <span>
                            <i class="bi bi-award"></i>
                            7+ Years Experience
                        </span>

                        <span>
                            <i class="bi bi-building"></i>
                            Organisation / Business
                        </span>

                        <span>
                            <i class="bi bi-geo-alt"></i>
                            City, State
                        </span>

                    </div>

                    <p>
                        Short professional introduction can appear here
                        to help users understand the professional's expertise.
                    </p>

                    <a href="#"
                       class="pl-card-button">
                        View Profile
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         BUSINESS LISTINGS
    ====================================================== -->

    <section class="pl-business-listing-section">

        <div class="pl-directory-container">

            <div class="pl-directory-section-heading centered">

                <span class="section-label">
                    BUSINESS DIRECTORY
                </span>

                <h2>
                    Discover Community Businesses
                </h2>

                <p>
                    Find businesses, products and services registered
                    within the PeopleLink ecosystem.
                </p>

            </div>


            <div class="pl-business-listing-grid">


                <div class="pl-business-listing-card">

                    <div class="pl-business-logo">
                        <i class="bi bi-shop"></i>
                    </div>

                    <div class="pl-business-listing-content">

                        <div class="pl-business-title-row">

                            <div>

                                <h3>
                                    Business Name
                                </h3>

                                <span>
                                    Retail & Services
                                </span>

                            </div>

                            <i class="bi bi-patch-check-fill"></i>

                        </div>


                        <div class="pl-business-meta">

                            <span>
                                <i class="bi bi-person"></i>
                                Owner / Contact Person
                            </span>

                            <span>
                                <i class="bi bi-geo-alt"></i>
                                City, State
                            </span>

                        </div>


                        <p>
                            Short business description can appear here,
                            explaining the products and services offered.
                        </p>


                        <div class="pl-business-services">

                            <span>Products</span>
                            <span>Services</span>
                            <span>Local Business</span>

                        </div>


                        <div class="pl-business-actions">

                            <a href="#">
                                View Business
                                <i class="bi bi-arrow-right"></i>
                            </a>

                            <a href="#">
                                <i class="bi bi-globe"></i>
                                Website
                            </a>

                        </div>

                    </div>

                </div>


                <div class="pl-business-listing-card">

                    <div class="pl-business-logo green">
                        <i class="bi bi-laptop"></i>
                    </div>

                    <div class="pl-business-listing-content">

                        <div class="pl-business-title-row">

                            <div>

                                <h3>
                                    Business Name
                                </h3>

                                <span>
                                    IT Services
                                </span>

                            </div>

                            <i class="bi bi-patch-check-fill"></i>

                        </div>


                        <div class="pl-business-meta">

                            <span>
                                <i class="bi bi-person"></i>
                                Owner / Contact Person
                            </span>

                            <span>
                                <i class="bi bi-geo-alt"></i>
                                City, State
                            </span>

                        </div>


                        <p>
                            Short business description can appear here,
                            explaining the products and services offered.
                        </p>


                        <div class="pl-business-services">

                            <span>Technology</span>
                            <span>Web Services</span>
                            <span>Consulting</span>

                        </div>


                        <div class="pl-business-actions">

                            <a href="#">
                                View Business
                                <i class="bi bi-arrow-right"></i>
                            </a>

                            <a href="#">
                                <i class="bi bi-globe"></i>
                                Website
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         COMMUNITY DIRECTORY
    ====================================================== -->

    <section class="pl-community-directory">

        <div class="pl-directory-container">

            <div class="pl-community-directory-inner">

                <div class="pl-community-content">

                    <span class="section-label">
                        COMMUNITY-SPECIFIC DIRECTORY
                    </span>

                    <h2>
                        Discover Professionals
                        Within Your Community
                    </h2>

                    <p>
                        Professional and business listings can remain
                        associated with their respective communities.
                    </p>

                    <div class="pl-community-examples">

                        <div>
                            <i class="bi bi-people-fill"></i>

                            <span>
                                Arya Vysya Directory
                            </span>

                            <small>
                                Professionals & Businesses
                            </small>
                        </div>

                        <div>
                            <i class="bi bi-people-fill"></i>

                            <span>
                                Reddy Directory
                            </span>

                            <small>
                                Professionals & Businesses
                            </small>
                        </div>

                    </div>

                </div>


                <div class="pl-community-visual">

                    <div class="pl-community-circle large">

                        <i class="bi bi-people-fill"></i>

                    </div>

                    <div class="pl-community-circle small one">
                        <i class="bi bi-person-badge"></i>
                    </div>

                    <div class="pl-community-circle small two">
                        <i class="bi bi-building"></i>
                    </div>

                    <div class="pl-community-circle small three">
                        <i class="bi bi-briefcase"></i>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         NEAR ME
    ====================================================== -->

    <section class="pl-near-me-section">

        <div class="pl-directory-container">

            <div class="pl-near-me-box">

                <div class="pl-near-me-icon">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>

                <div class="pl-near-me-content">

                    <span>
                        LOCATION DISCOVERY
                    </span>

                    <h2>
                        Find Professionals & Businesses Near You
                    </h2>

                    <p>
                        Users can discover registered businesses and
                        professionals near their current location where
                        location access is permitted.
                    </p>

                </div>

                <button type="button"
                        id="nearMeButton"
                        class="pl-near-me-button">

                    <i class="bi bi-crosshair"></i>
                    Explore Near Me

                </button>

            </div>

        </div>

    </section>


    <!-- =====================================================
         ADD PROFILE / BUSINESS
    ====================================================== -->

    <section class="pl-add-directory-section">

        <div class="pl-directory-container">

            <div class="pl-add-directory-grid">


                <!-- PROFESSIONAL -->

                <div class="pl-add-card professional">

                    <div class="pl-add-card-icon">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>

                    <span>
                        FOR PROFESSIONALS
                    </span>

                    <h2>
                        Add Your Professional Profile
                    </h2>

                    <p>
                        Registered users can submit their professional
                        information and connect with people looking for
                        relevant expertise.
                    </p>

                    <div class="pl-add-items">

                        <span>Profession</span>
                        <span>Specialisation</span>
                        <span>Experience</span>
                        <span>Organisation</span>
                        <span>Services</span>
                        <span>Location</span>

                    </div>

                    <a href="#"
                       class="pl-add-button">
                        Register as Professional
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>


                <!-- BUSINESS -->

                <div class="pl-add-card business">

                    <div class="pl-add-card-icon">
                        <i class="bi bi-shop-window"></i>
                    </div>

                    <span>
                        FOR BUSINESS OWNERS
                    </span>

                    <h2>
                        List Your Business
                    </h2>

                    <p>
                        Business owners can submit their business details,
                        products, services and location for directory
                        consideration.
                    </p>

                    <div class="pl-add-items">

                        <span>Business Name</span>
                        <span>Category</span>
                        <span>Products</span>
                        <span>Services</span>
                        <span>Address</span>
                        <span>Website</span>

                    </div>

                    <a href="#"
                       class="pl-add-button">
                        Add Business Listing
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         APPROVAL & PRIVACY
    ====================================================== -->

    <section class="pl-directory-trust">

        <div class="pl-directory-container">

            <div class="pl-trust-grid">


                <div class="pl-trust-card">

                    <div class="pl-trust-icon green">
                        <i class="bi bi-patch-check-fill"></i>
                    </div>

                    <div>

                        <h3>
                            Approval & Verification
                        </h3>

                        <p>
                            New professional and business listings can be
                            reviewed by the authorised admin before
                            publication.
                        </p>

                        <div class="pl-status-list">

                            <span>Pending</span>
                            <span>Approved</span>
                            <span>Requires Changes</span>
                            <span>Rejected</span>

                        </div>

                    </div>

                </div>


                <div class="pl-trust-card">

                    <div class="pl-trust-icon blue">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>

                    <div>

                        <h3>
                            Privacy & Contact Controls
                        </h3>

                        <p>
                            Personal contact details should only be displayed
                            according to user consent, directory settings,
                            community rules and admin approval.
                        </p>

                        <div class="pl-privacy-list">

                            <span>
                                <i class="bi bi-check"></i>
                                User Consent
                            </span>

                            <span>
                                <i class="bi bi-check"></i>
                                Directory Settings
                            </span>

                            <span>
                                <i class="bi bi-check"></i>
                                Community Rules
                            </span>

                            <span>
                                <i class="bi bi-check"></i>
                                Admin Approval
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         FINAL CTA
    ====================================================== -->

    <section class="pl-directory-final">

        <div class="pl-directory-container">

            <span class="pl-directory-final-icon">
                <i class="bi bi-diagram-3-fill"></i>
            </span>

            <h2>
                Build Stronger Community Connections
            </h2>

            <p>
                Discover professionals, support community businesses and
                connect with trusted service providers through PeopleLink.
            </p>

            <div class="pl-directory-final-buttons">

                <a href="#directory-search"
                   class="pl-directory-btn primary">
                    <i class="bi bi-search"></i>
                    Search Directory
                </a>

                <a href="#"
                   class="pl-directory-btn light">
                    <i class="bi bi-person-plus"></i>
                    Add Professional Profile
                </a>

                <a href="#"
                   class="pl-directory-btn light">
                    <i class="bi bi-shop"></i>
                    List Your Business
                </a>

            </div>

        </div>

    </section>

</div>



<?php include 'footer.php'; ?>