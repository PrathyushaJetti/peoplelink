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
        href="support-assistance.css"
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

<section class="pl-support-page">

    <div class="pl-support-container">

        <!-- HERO -->
        <div class="pl-support-hero">

            <div class="pl-support-hero-content">

                <span class="pl-support-eyebrow">
                    <i class="bi bi-people-fill"></i>
                    COMMUNITY SUPPORT
                </span>

                <h1>Community Support & Assistance</h1>

                <p>
                    Ask for Help. Offer Support. Stay Connected.
                </p>

                <div class="pl-support-hero-text">
                    PeopleLink provides a structured way for registered
                    users to request assistance from their community
                    for approved needs.
                </div>

                <div class="pl-support-hero-actions">

                    <a href="#request-assistance"
                       class="pl-support-primary-btn">
                        <i class="bi bi-hand-thumbs-up"></i>
                        Request Assistance
                    </a>

                    <a href="#support-requests"
                       class="pl-support-secondary-btn">
                        <i class="bi bi-list-check"></i>
                        View Support Requests
                    </a>

                </div>

            </div>

            <div class="pl-support-hero-visual">

                <div class="pl-support-hero-circle">
                    <i class="bi bi-people"></i>
                </div>

                <div class="pl-support-floating-card card-one">
                    <i class="bi bi-heart-fill"></i>
                    <span>Support</span>
                </div>

                <div class="pl-support-floating-card card-two">
                    <i class="bi bi-shield-check"></i>
                    <span>Verified</span>
                </div>

            </div>

        </div>


        <!-- INTRO -->
        <div class="pl-support-intro">

            <div class="pl-support-intro-icon">
                <i class="bi bi-info-circle"></i>
            </div>

            <div>
                <h2>Structured Community Assistance</h2>

                <p>
                    This section handles general support requests that are
                    not specifically categorized under Education Funding
                    or Emergency Help.
                </p>
            </div>

        </div>


        <!-- SUPPORT CATEGORIES -->
        <section class="pl-support-section">

            <div class="pl-support-section-heading">

                <div>
                    <span>01</span>
                    <h2>Support Categories</h2>
                    <p>
                        Choose the category that best describes the
                        assistance you require.
                    </p>
                </div>

            </div>


            <div class="pl-support-category-grid">

                <button class="pl-support-category" data-category="Employment Support">
                    <i class="bi bi-briefcase"></i>
                    <span>Employment Support</span>
                </button>

                <button class="pl-support-category" data-category="Business Guidance">
                    <i class="bi bi-building"></i>
                    <span>Business Guidance</span>
                </button>

                <button class="pl-support-category" data-category="Legal Guidance">
                    <i class="bi bi-scale"></i>
                    <span>Legal Guidance</span>
                </button>

                <button class="pl-support-category" data-category="Professional Assistance">
                    <i class="bi bi-person-workspace"></i>
                    <span>Professional Assistance</span>
                </button>

                <button class="pl-support-category" data-category="Community Support">
                    <i class="bi bi-people"></i>
                    <span>Community Support</span>
                </button>

                <button class="pl-support-category" data-category="Senior Citizen Support">
                    <i class="bi bi-person-wheelchair"></i>
                    <span>Senior Citizen Support</span>
                </button>

                <button class="pl-support-category" data-category="Women Support">
                    <i class="bi bi-gender-female"></i>
                    <span>Women Support</span>
                </button>

                <button class="pl-support-category" data-category="Student Guidance">
                    <i class="bi bi-mortarboard"></i>
                    <span>Student Guidance</span>
                </button>

                <button class="pl-support-category" data-category="Social Support">
                    <i class="bi bi-hand-thumbs-up"></i>
                    <span>Social Support</span>
                </button>

                <button class="pl-support-category" data-category="Other Approved Requests">
                    <i class="bi bi-three-dots"></i>
                    <span>Other Approved Requests</span>
                </button>

            </div>

        </section>


        <!-- SUBMIT REQUEST -->
        <section
            class="pl-support-section"
            id="request-assistance">

            <div class="pl-support-section-heading">

                <div>
                    <span>02</span>
                    <h2>Submit a Support Request</h2>
                    <p>
                        Provide clear information so the community and
                        authorised administrators can understand your request.
                    </p>
                </div>

            </div>


            <form
                id="supportRequestForm"
                class="pl-support-form"
                enctype="multipart/form-data">


                <!-- BASIC INFORMATION -->
                <div class="pl-support-form-block">

                    <div class="pl-support-form-title">

                        <div class="pl-support-form-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>

                        <div>
                            <h3>Request Information</h3>
                            <p>Tell us what kind of assistance you need.</p>
                        </div>

                    </div>


                    <div class="pl-support-form-grid">

                        <div class="pl-support-field full">

                            <label for="requestTitle">
                                Request Title
                                <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="requestTitle"
                                name="request_title"
                                placeholder="Enter a clear title for your request"
                                required>

                        </div>


                        <div class="pl-support-field">

                            <label for="supportCategory">
                                Support Category
                                <span>*</span>
                            </label>

                            <select
                                id="supportCategory"
                                name="support_category"
                                required>

                                <option value="">
                                    Select Category
                                </option>

                                <option>Employment Support</option>
                                <option>Business Guidance</option>
                                <option>Legal Guidance</option>
                                <option>Professional Assistance</option>
                                <option>Community Support</option>
                                <option>Senior Citizen Support</option>
                                <option>Women Support</option>
                                <option>Student Guidance</option>
                                <option>Social Support</option>
                                <option>Other Approved Requests</option>

                            </select>

                        </div>


                        <div class="pl-support-field">

                            <label for="community">
                                Community
                                <span>*</span>
                            </label>

                            <select
                                id="community"
                                name="community"
                                required>

                                <option value="">
                                    Select Community
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


                        <div class="pl-support-field">

                            <label for="supportLocation">
                                Location
                            </label>

                            <input
                                type="text"
                                id="supportLocation"
                                name="location"
                                placeholder="City / District / State">

                        </div>


                        <div class="pl-support-field">

                            <label for="requiredDate">
                                Required By Date
                            </label>

                            <input
                                type="date"
                                id="requiredDate"
                                name="required_by">

                        </div>

                    </div>

                </div>


                <!-- DESCRIPTION -->
                <div class="pl-support-form-block">

                    <div class="pl-support-form-title">

                        <div class="pl-support-form-icon green">
                            <i class="bi bi-chat-left-text"></i>
                        </div>

                        <div>
                            <h3>Request Description</h3>
                            <p>
                                Explain the situation clearly and accurately.
                            </p>
                        </div>

                    </div>


                    <div class="pl-support-field">

                        <label for="requestDescription">
                            Detailed Requirement
                            <span>*</span>
                        </label>

                        <textarea
                            id="requestDescription"
                            name="description"
                            rows="6"
                            placeholder="Explain what assistance is required, why support is needed, the expected type of help and relevant background information..."
                            required></textarea>

                        <div class="pl-support-character-count">
                            <span id="descriptionCount">0</span>
                            / 1000 characters
                        </div>

                    </div>


                    <div class="pl-support-field">

                        <label for="assistanceType">
                            Preferred Type of Assistance
                            <span>*</span>
                        </label>

                        <select
                            id="assistanceType"
                            name="assistance_type"
                            required>

                            <option value="">
                                Select Assistance Type
                            </option>

                            <option>Information / Guidance</option>
                            <option>Professional Help</option>
                            <option>Employment Support</option>
                            <option>Business Support</option>
                            <option>Legal Guidance</option>
                            <option>Community Support</option>
                            <option>Financial Guidance</option>
                            <option>Other Approved Assistance</option>

                        </select>

                    </div>

                </div>


                <!-- CONTACT -->
                <div class="pl-support-form-block">

                    <div class="pl-support-form-title">

                        <div class="pl-support-form-icon orange">
                            <i class="bi bi-person-lines-fill"></i>
                        </div>

                        <div>
                            <h3>Contact Information</h3>
                            <p>
                                Provide contact details according to your
                                privacy preferences.
                            </p>
                        </div>

                    </div>


                    <div class="pl-support-form-grid">

                        <div class="pl-support-field">

                            <label for="contactName">
                                Contact Name
                                <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="contactName"
                                name="contact_name"
                                placeholder="Enter your name"
                                required>

                        </div>


                        <div class="pl-support-field">

                            <label for="contactPhone">
                                Phone Number
                                <span>*</span>
                            </label>

                            <input
                                type="tel"
                                id="contactPhone"
                                name="phone"
                                placeholder="Enter phone number"
                                required>

                        </div>


                        <div class="pl-support-field">

                            <label for="contactEmail">
                                Email Address
                            </label>

                            <input
                                type="email"
                                id="contactEmail"
                                name="email"
                                placeholder="Enter email address">

                        </div>


                        <div class="pl-support-field">

                            <label for="contactMethod">
                                Preferred Contact Method
                            </label>

                            <select
                                id="contactMethod"
                                name="contact_method">

                                <option value="">
                                    Select Method
                                </option>

                                <option>Phone</option>
                                <option>Email</option>
                                <option>WhatsApp</option>
                                <option>Enquiry Form</option>

                            </select>

                        </div>

                    </div>

                </div>


                <!-- SUPPORTING DOCUMENT -->
                <div class="pl-support-form-block">

                    <div class="pl-support-form-title">

                        <div class="pl-support-form-icon purple">
                            <i class="bi bi-paperclip"></i>
                        </div>

                        <div>
                            <h3>Supporting Documents</h3>
                            <p>
                                Upload an approved document where required.
                            </p>
                        </div>

                    </div>


                    <div class="pl-support-upload">

                        <input
                            type="file"
                            id="supportDocument"
                            name="supporting_document"
                            accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">

                        <div class="pl-support-upload-icon">
                            <i class="bi bi-cloud-arrow-up"></i>
                        </div>

                        <strong>
                            Upload Supporting Document
                        </strong>

                        <span>
                            Application Letter · Reference Document ·
                            Supporting Proof · Other Relevant Document
                        </span>

                        <small>
                            PDF, JPG, PNG, DOC or DOCX
                        </small>

                        <div
                            class="pl-support-file-name"
                            id="supportFileName">
                        </div>

                    </div>


                    <div class="pl-support-sensitive-note">

                        <i class="bi bi-shield-lock"></i>

                        <span>
                            Sensitive documents should remain accessible
                            only to authorised users.
                        </span>

                    </div>

                </div>


                <!-- PRIVACY -->
                <div class="pl-support-form-block">

                    <div class="pl-support-form-title">

                        <div class="pl-support-form-icon blue">
                            <i class="bi bi-eye"></i>
                        </div>

                        <div>
                            <h3>Visibility & Privacy</h3>
                            <p>
                                Control how your request can be accessed.
                            </p>
                        </div>

                    </div>


                    <div class="pl-support-visibility-grid">

                        <label class="pl-support-visibility-option">

                            <input
                                type="radio"
                                name="visibility"
                                value="community"
                                checked>

                            <span class="pl-support-radio-box">

                                <i class="bi bi-people"></i>

                                <strong>Community</strong>

                                <small>
                                    Visible to authorised members
                                    of your community.
                                </small>

                            </span>

                        </label>


                        <label class="pl-support-visibility-option">

                            <input
                                type="radio"
                                name="visibility"
                                value="broader">

                            <span class="pl-support-radio-box">

                                <i class="bi bi-globe2"></i>

                                <strong>Broader Visibility</strong>

                                <small>
                                    May be visible beyond your
                                    selected community if approved.
                                </small>

                            </span>

                        </label>

                    </div>

                </div>


                <!-- DECLARATION -->
                <div class="pl-support-declaration">

                    <label>

                        <input
                            type="checkbox"
                            id="supportDeclaration"
                            required>

                        <span>
                            I confirm that the information provided is
                            genuine and accurate to the best of my knowledge.
                            I understand that the request may be reviewed
                            by an authorised Community Admin / Sub-Admin.
                        </span>

                    </label>

                </div>


                <!-- FORM ACTIONS -->
                <div class="pl-support-form-actions">

                    <button
                        type="button"
                        class="pl-support-draft-btn"
                        id="saveDraftBtn">

                        <i class="bi bi-save"></i>
                        Save Draft

                    </button>

                    <button
                        type="reset"
                        class="pl-support-reset-btn">

                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset

                    </button>

                    <button
                        type="submit"
                        class="pl-support-submit-btn">

                        <i class="bi bi-send"></i>
                        Submit Request

                    </button>

                </div>

            </form>

        </section>


        <!-- VERIFICATION -->
        <section class="pl-support-section">

            <div class="pl-support-verification">

                <div class="pl-support-verification-icon">
                    <i class="bi bi-shield-check"></i>
                </div>

                <div class="pl-support-verification-content">

                    <span>REQUEST VERIFICATION</span>

                    <h2>Support Request Verification</h2>

                    <p>
                        Submitted requests can be reviewed by the authorised
                        Community Admin / Sub-Admin before publication.
                    </p>

                    <div class="pl-support-statuses">

                        <span>Draft</span>
                        <span>Pending Review</span>
                        <span>Approved</span>
                        <span>Requires Clarification</span>
                        <span>Rejected</span>
                        <span>In Progress</span>
                        <span>Resolved / Closed</span>

                    </div>

                </div>

            </div>

        </section>


        <!-- APPROVED REQUESTS -->
        <section
            class="pl-support-section"
            id="support-requests">

            <div class="pl-support-section-heading split">

                <div>
                    <span>03</span>
                    <h2>Approved Support Requests</h2>
                    <p>
                        Browse approved requests where community members
                        can offer meaningful assistance.
                    </p>
                </div>

                <button
                    type="button"
                    class="pl-support-outline-btn"
                    id="viewAllRequests">

                    <i class="bi bi-grid"></i>
                    View All Requests

                </button>

            </div>


            <div class="pl-support-request-grid">


                <!-- REQUEST CARD -->
                <article class="pl-support-request-card">

                    <div class="pl-support-request-top">

                        <span class="pl-support-request-category">
                            Employment Support
                        </span>

                        <span class="pl-support-approved">
                            <i class="bi bi-check-circle-fill"></i>
                            Approved
                        </span>

                    </div>

                    <h3>
                        Looking for Guidance for a Career Opportunity
                    </h3>

                    <p>
                        Seeking professional guidance and relevant
                        information regarding available opportunities
                        in the technology sector.
                    </p>

                    <div class="pl-support-request-meta">

                        <span>
                            <i class="bi bi-geo-alt"></i>
                            Hyderabad
                        </span>

                        <span>
                            <i class="bi bi-people"></i>
                            Reddy
                        </span>

                        <span>
                            <i class="bi bi-calendar"></i>
                            Required by 30 Oct 2026
                        </span>

                    </div>

                    <div class="pl-support-request-bottom">

                        <span class="pl-support-progress">
                            <i class="bi bi-arrow-repeat"></i>
                            In Progress
                        </span>

                        <button
                            type="button"
                            class="pl-support-view-request"
                            data-request="Career Opportunity">

                            View Request
                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </article>


                <!-- REQUEST CARD -->
                <article class="pl-support-request-card">

                    <div class="pl-support-request-top">

                        <span class="pl-support-request-category">
                            Business Guidance
                        </span>

                        <span class="pl-support-approved">
                            <i class="bi bi-check-circle-fill"></i>
                            Approved
                        </span>

                    </div>

                    <h3>
                        Guidance Required for Small Business Setup
                    </h3>

                    <p>
                        Looking for guidance from experienced community
                        members regarding registration and initial business
                        setup requirements.
                    </p>

                    <div class="pl-support-request-meta">

                        <span>
                            <i class="bi bi-geo-alt"></i>
                            Bengaluru
                        </span>

                        <span>
                            <i class="bi bi-people"></i>
                            Arya Vysya
                        </span>

                        <span>
                            <i class="bi bi-calendar"></i>
                            Required by 15 Nov 2026
                        </span>

                    </div>

                    <div class="pl-support-request-bottom">

                        <span class="pl-support-progress">
                            <i class="bi bi-arrow-repeat"></i>
                            In Progress
                        </span>

                        <button
                            type="button"
                            class="pl-support-view-request"
                            data-request="Business Setup">

                            View Request
                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </article>


                <!-- REQUEST CARD -->
                <article class="pl-support-request-card">

                    <div class="pl-support-request-top">

                        <span class="pl-support-request-category">
                            Student Guidance
                        </span>

                        <span class="pl-support-approved">
                            <i class="bi bi-check-circle-fill"></i>
                            Approved
                        </span>

                    </div>

                    <h3>
                        Higher Education Application Guidance
                    </h3>

                    <p>
                        Student seeking guidance from experienced community
                        members regarding higher education applications
                        and available options.
                    </p>

                    <div class="pl-support-request-meta">

                        <span>
                            <i class="bi bi-geo-alt"></i>
                            Delhi
                        </span>

                        <span>
                            <i class="bi bi-people"></i>
                            Kamma
                        </span>

                        <span>
                            <i class="bi bi-calendar"></i>
                            Required by 20 Nov 2026
                        </span>

                    </div>

                    <div class="pl-support-request-bottom">

                        <span class="pl-support-progress">
                            <i class="bi bi-arrow-repeat"></i>
                            In Progress
                        </span>

                        <button
                            type="button"
                            class="pl-support-view-request"
                            data-request="Higher Education">

                            View Request
                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </article>

            </div>

        </section>


        <!-- OFFER ASSISTANCE -->
        <section class="pl-support-offer-section">

            <div class="pl-support-offer-content">

                <div class="pl-support-offer-icon">
                    <i class="bi bi-hand-thumbs-up-fill"></i>
                </div>

                <div>

                    <span>MAKE A DIFFERENCE</span>

                    <h2>Offer Assistance</h2>

                    <p>
                        Eligible users can respond to approved requests
                        and offer professional help, useful information
                        or other approved support.
                    </p>

                </div>

            </div>


            <div class="pl-support-offer-actions">

                <button
                    type="button"
                    class="pl-support-offer-btn"
                    id="offerAssistanceBtn">

                    <i class="bi bi-hand-thumbs-up"></i>
                    Offer Assistance

                </button>

                <div class="pl-support-offer-options">

                    <span>
                        <i class="bi bi-chat"></i>
                        Send Enquiry
                    </span>

                    <span>
                        <i class="bi bi-briefcase"></i>
                        Professional Help
                    </span>

                    <span>
                        <i class="bi bi-person-lines-fill"></i>
                        Contact Request
                    </span>

                    <span>
                        <i class="bi bi-share"></i>
                        Share Information
                    </span>

                </div>

            </div>

        </section>


        <!-- MY REQUESTS -->
        <section class="pl-support-section">

            <div class="pl-support-my-requests">

                <div class="pl-support-section-heading">

                    <div>
                        <span>04</span>
                        <h2>My Support Requests</h2>
                        <p>
                            Track the requests you have submitted and
                            monitor their progress.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="pl-support-outline-btn"
                        id="myRequestsBtn">

                        <i class="bi bi-folder2-open"></i>
                        My Requests

                    </button>

                </div>


                <div class="pl-support-my-request-grid">

                    <div class="pl-support-my-stat">
                        <i class="bi bi-send"></i>
                        <strong>3</strong>
                        <span>Submitted Requests</span>
                    </div>

                    <div class="pl-support-my-stat">
                        <i class="bi bi-hourglass-split"></i>
                        <strong>1</strong>
                        <span>Pending Review</span>
                    </div>

                    <div class="pl-support-my-stat">
                        <i class="bi bi-chat-dots"></i>
                        <strong>4</strong>
                        <span>Responses Received</span>
                    </div>

                    <div class="pl-support-my-stat">
                        <i class="bi bi-check-circle"></i>
                        <strong>1</strong>
                        <span>Closed Requests</span>
                    </div>

                </div>

            </div>

        </section>


        <!-- RESOLVE / COMMUNICATION / NOTIFICATIONS -->
        <section class="pl-support-info-grid">

            <div class="pl-support-info-card">

                <div class="pl-support-info-icon green">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <h3>Assistance Received</h3>

                <p>
                    Once sufficient help has been received, the requester
                    can update the request status.
                </p>

                <button
                    type="button"
                    class="pl-support-small-btn"
                    id="resolveRequestBtn">

                    <i class="bi bi-check-lg"></i>
                    Mark as Resolved

                </button>

            </div>


            <div class="pl-support-info-card">

                <div class="pl-support-info-icon blue">
                    <i class="bi bi-chat-square-text"></i>
                </div>

                <h3>Communication</h3>

                <p>
                    Communication can take place through approved contact
                    methods based on privacy settings and permissions.
                </p>

                <div class="pl-support-methods">

                    <span><i class="bi bi-telephone"></i> Phone</span>
                    <span><i class="bi bi-envelope"></i> Email</span>
                    <span><i class="bi bi-whatsapp"></i> WhatsApp</span>
                    <span><i class="bi bi-ui-checks"></i> Enquiry Form</span>

                </div>

            </div>


            <div class="pl-support-info-card">

                <div class="pl-support-info-icon orange">
                    <i class="bi bi-bell"></i>
                </div>

                <h3>Notifications</h3>

                <p>
                    Users can receive updates when requests are approved,
                    clarified, responded to or resolved.
                </p>

                <div class="pl-support-notification-list">

                    <span>
                        <i class="bi bi-check-circle"></i>
                        Request Approved
                    </span>

                    <span>
                        <i class="bi bi-question-circle"></i>
                        Clarification Required
                    </span>

                    <span>
                        <i class="bi bi-chat"></i>
                        Someone Responds
                    </span>

                    <span>
                        <i class="bi bi-arrow-repeat"></i>
                        Status Updated
                    </span>

                </div>

            </div>

        </section>


        <!-- COMMUNITY + REPORT -->
        <section class="pl-support-bottom-grid">

            <div class="pl-support-community-card">

                <div class="pl-support-community-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div>

                    <span>COMMUNITY-SPECIFIC SUPPORT</span>

                    <h2>Support Within Your Community</h2>

                    <p>
                        Support requests remain linked to the relevant
                        community unless specifically marked for broader
                        visibility. Community Admins should access only
                        their authorised community requests.
                    </p>

                </div>

            </div>


            <div class="pl-support-report-card">

                <div class="pl-support-report-icon">
                    <i class="bi bi-flag"></i>
                </div>

                <div>

                    <h3>Report Misuse</h3>

                    <p>
                        Report false, inappropriate or misleading
                        support requests to the authorised team.
                    </p>

                    <button
                        type="button"
                        id="reportRequestBtn">

                        <i class="bi bi-flag"></i>
                        Report Request

                    </button>

                </div>

            </div>

        </section>


        <!-- PRIVACY -->
        <section class="pl-support-privacy">

            <div class="pl-support-privacy-icon">
                <i class="bi bi-shield-lock"></i>
            </div>

            <div>

                <span>PRIVACY & SAFETY</span>

                <h2>Your Information Matters</h2>

                <p>
                    Personal information, uploaded documents and sensitive
                    details should only be visible according to the required
                    access permissions.
                </p>

            </div>

        </section>


        <!-- FINAL CTA -->
        <section class="pl-support-final-cta">

            <div>

                <span>
                    <i class="bi bi-heart-fill"></i>
                    PEOPLELINK COMMUNITY
                </span>

                <h2>Strong Communities Support Each Other</h2>

                <p>
                    Use PeopleLink to request genuine assistance,
                    offer support and connect with the right people
                    within your community.
                </p>

            </div>

            <div class="pl-support-final-actions">

                <a
                    href="#request-assistance"
                    class="pl-support-final-primary">

                    <i class="bi bi-hand-thumbs-up"></i>
                    Request Assistance

                </a>

                <a
                    href="#support-requests"
                    class="pl-support-final-secondary">

                    <i class="bi bi-list-check"></i>
                    View Requests

                </a>

                <button
                    type="button"
                    id="finalMyRequests">

                    <i class="bi bi-folder2-open"></i>
                    My Requests

                </button>

            </div>

        </section>

    </div>


    <!-- GENERIC MODAL -->
    <div
        class="pl-support-modal"
        id="supportModal"
        hidden>

        <div
            class="pl-support-modal-backdrop"
            data-close-support-modal>
        </div>

        <div class="pl-support-modal-box">

            <button
                type="button"
                class="pl-support-modal-close"
                data-close-support-modal>

                <i class="bi bi-x-lg"></i>

            </button>

            <div
                class="pl-support-modal-icon"
                id="supportModalIcon">

                <i class="bi bi-info-circle"></i>

            </div>

            <h3 id="supportModalTitle">
                Support Request
            </h3>

            <p id="supportModalMessage">
                This action is available to registered users.
            </p>

            <button
                type="button"
                class="pl-support-modal-btn"
                data-close-support-modal>

                Continue

            </button>

        </div>

    </div>


    <!-- SUCCESS TOAST -->
    <div
        class="pl-support-toast"
        id="supportToast">

        <div class="pl-support-toast-icon">
            <i class="bi bi-check-lg"></i>
        </div>

        <div>

            <strong id="supportToastTitle">
                Success
            </strong>

            <span id="supportToastMessage">
                Action completed successfully.
            </span>

        </div>

    </div>

</section>

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
<script src="support-assistance.js"></script>
</body>
</html>