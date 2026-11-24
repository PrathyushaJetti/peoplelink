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
        href="emergency-help.css"
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

<main class="pl-emergency-page">

    <!-- =========================================================
         HERO
    ========================================================== -->
    <section class="pl-emergency-hero">

        <div class="pl-emergency-hero-overlay"></div>

        <div class="pl-emergency-container pl-emergency-hero-inner">

            <div class="pl-emergency-hero-content">

                <span class="pl-emergency-eyebrow">
                    <i class="bi bi-shield-fill-check"></i>
                    PeopleLink Emergency Help
                </span>

                <h1>Emergency Help</h1>

                <p>
                    Get help when it matters most. Connect genuine urgent
                    requirements with the right community support through
                    PeopleLink.
                </p>

                <div class="pl-emergency-hero-actions">

                    <button type="button"
                            class="pl-emergency-btn pl-emergency-btn-primary"
                            onclick="scrollToEmergencyForm()">
                        <i class="bi bi-plus-circle-fill"></i>
                        Request Emergency Help
                    </button>

                    <button type="button"
                            class="pl-emergency-btn pl-emergency-btn-light"
                            onclick="scrollToActiveEmergency()">
                        <i class="bi bi-broadcast-pin"></i>
                        View Active Requests
                    </button>

                </div>

            </div>

            <div class="pl-emergency-hero-card">

                <div class="pl-emergency-alert-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>

                <strong>Urgent Support Network</strong>

                <span>
                    Verified emergency requests can be shared with
                    eligible PeopleLink members.
                </span>

                <div class="pl-emergency-mini-stats">

                    <div>
                        <strong>24/7</strong>
                        <span>Urgent Need</span>
                    </div>

                    <div>
                        <strong>Fast</strong>
                        <span>Community Reach</span>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         INTRO
    ========================================================== -->
    <section class="pl-emergency-intro">

        <div class="pl-emergency-container">

            <div class="pl-emergency-section-heading">

                <span>
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Emergency Support
                </span>

                <h2>Get Help When It Matters Most</h2>

                <p>
                    PeopleLink Emergency Help is designed to connect genuine
                    urgent requirements with the right community support.
                    Approved requests can be shared with eligible members
                    according to community and visibility settings.
                </p>

            </div>

            <div class="pl-emergency-benefits">

                <div class="pl-emergency-benefit">
                    <i class="bi bi-lightning-charge-fill"></i>
                    <div>
                        <strong>Urgent Requests</strong>
                        <small>Submit genuine emergency requirements.</small>
                    </div>
                </div>

                <div class="pl-emergency-benefit">
                    <i class="bi bi-shield-check"></i>
                    <div>
                        <strong>Admin Review</strong>
                        <small>Requests can be reviewed before publication.</small>
                    </div>
                </div>

                <div class="pl-emergency-benefit">
                    <i class="bi bi-people-fill"></i>
                    <div>
                        <strong>Community Support</strong>
                        <small>Reach eligible people who can help.</small>
                    </div>
                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         EMERGENCY CATEGORIES
    ========================================================== -->
    <section class="pl-emergency-categories">

        <div class="pl-emergency-container">

            <div class="pl-emergency-section-heading pl-emergency-heading-left">

                <span>
                    <i class="bi bi-grid-fill"></i>
                    Emergency Categories
                </span>

                <h2>What Kind of Help Is Needed?</h2>

                <p>
                    Emergency requests can cover different urgent situations
                    that are eligible for PeopleLink community support.
                </p>

            </div>

            <div class="pl-emergency-category-grid">

                <div class="pl-emergency-category">
                    <i class="bi bi-heart-pulse-fill"></i>
                    <span>Medical Emergency</span>
                </div>

                <div class="pl-emergency-category">
                    <i class="bi bi-droplet-fill"></i>
                    <span>Blood Requirement</span>
                </div>

                <div class="pl-emergency-category">
                    <i class="bi bi-hospital-fill"></i>
                    <span>Hospital Support</span>
                </div>

                <div class="pl-emergency-category">
                    <i class="bi bi-car-front-fill"></i>
                    <span>Accident Support</span>
                </div>

                <div class="pl-emergency-category">
                    <i class="bi bi-cash-stack"></i>
                    <span>Financial Emergency</span>
                </div>

                <div class="pl-emergency-category">
                    <i class="bi bi-cloud-lightning-rain-fill"></i>
                    <span>Natural Disaster</span>
                </div>

                <div class="pl-emergency-category">
                    <i class="bi bi-house-heart-fill"></i>
                    <span>Urgent Family Assistance</span>
                </div>

                <div class="pl-emergency-category">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Other Approved Needs</span>
                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         REQUEST FORM
    ========================================================== -->
    <section class="pl-emergency-form-section"
             id="emergencyRequestForm">

        <div class="pl-emergency-container">

            <div class="pl-emergency-section-heading">

                <span>
                    <i class="bi bi-pencil-square"></i>
                    Submit an Emergency Request
                </span>

                <h2>Tell Us What Help Is Needed</h2>

                <p>
                    Provide accurate information so the authorised team can
                    review and process the emergency request.
                </p>

            </div>


            <form class="pl-emergency-form"
                  id="emergencyHelpForm"
                  enctype="multipart/form-data">


                <!-- =================================================
                     REQUESTER INFORMATION
                ================================================== -->
                <div class="pl-emergency-form-block">

                    <div class="pl-emergency-form-title">

                        <div>
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <span>
                            <strong>Requester Information</strong>
                            <small>Basic information about the person requesting help.</small>
                        </span>

                    </div>


                    <div class="pl-emergency-form-grid">

                        <div class="pl-emergency-field">

                            <label>
                                Requester Name <b>*</b>
                            </label>

                            <input type="text"
                                   name="requester_name"
                                   placeholder="Enter requester name"
                                   required>

                        </div>


                        <div class="pl-emergency-field">

                            <label>
                                Patient / Beneficiary Name
                            </label>

                            <input type="text"
                                   name="beneficiary_name"
                                   placeholder="Enter patient or beneficiary name">

                        </div>


                        <div class="pl-emergency-field">

                            <label>Community</label>

                            <select name="community">

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


                        <div class="pl-emergency-field">

                            <label>
                                Emergency Type <b>*</b>
                            </label>

                            <select name="emergency_type"
                                    id="emergencyType"
                                    required>

                                <option value="">
                                    Select Emergency Type
                                </option>

                                <option value="medical">
                                    Medical Emergency
                                </option>

                                <option value="blood">
                                    Blood Requirement
                                </option>

                                <option value="hospital">
                                    Hospital Support
                                </option>

                                <option value="accident">
                                    Accident Support
                                </option>

                                <option value="financial">
                                    Financial Emergency
                                </option>

                                <option value="disaster">
                                    Natural Disaster Support
                                </option>

                                <option value="family">
                                    Urgent Family Assistance
                                </option>

                                <option value="other">
                                    Other Approved Emergency Need
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     LOCATION & HOSPITAL
                ================================================== -->
                <div class="pl-emergency-form-block">

                    <div class="pl-emergency-form-title">

                        <div>
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>

                        <span>
                            <strong>Location & Institution</strong>
                            <small>Help supporters understand where assistance is required.</small>
                        </span>

                    </div>


                    <div class="pl-emergency-form-grid">

                        <div class="pl-emergency-field">

                            <label>
                                Location <b>*</b>
                            </label>

                            <input type="text"
                                   name="location"
                                   placeholder="City / Area"
                                   required>

                        </div>


                        <div class="pl-emergency-field">

                            <label>
                                Hospital / Institution
                            </label>

                            <input type="text"
                                   name="hospital"
                                   placeholder="Hospital or institution name">

                        </div>


                        <div class="pl-emergency-field">

                            <label>State</label>

                            <input type="text"
                                   name="state"
                                   placeholder="State">

                        </div>


                        <div class="pl-emergency-field">

                            <label>District</label>

                            <input type="text"
                                   name="district"
                                   placeholder="District">

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     EMERGENCY REQUIREMENT
                ================================================== -->
                <div class="pl-emergency-form-block">

                    <div class="pl-emergency-form-title">

                        <div>
                            <i class="bi bi-exclamation-octagon-fill"></i>
                        </div>

                        <span>
                            <strong>Emergency Requirement</strong>
                            <small>Explain the urgent requirement clearly.</small>
                        </span>

                    </div>


                    <div class="pl-emergency-form-grid">

                        <div class="pl-emergency-field">

                            <label>Amount Required</label>

                            <div class="pl-emergency-money">

                                <span>₹</span>

                                <input type="number"
                                       name="amount_required"
                                       min="0"
                                       placeholder="Enter amount">

                            </div>

                        </div>


                        <div class="pl-emergency-field">

                            <label>
                                Required By
                            </label>

                            <input type="datetime-local"
                                   name="required_by">

                        </div>


                        <div class="pl-emergency-field">

                            <label>Urgency</label>

                            <select name="urgency">

                                <option value="normal">
                                    Normal
                                </option>

                                <option value="urgent">
                                    Urgent
                                </option>

                                <option value="critical">
                                    Critical
                                </option>

                            </select>

                        </div>


                        <div class="pl-emergency-field">

                            <label>Blood Group</label>

                            <select name="blood_group">

                                <option value="">
                                    Not Applicable
                                </option>

                                <option>A+</option>
                                <option>A-</option>
                                <option>B+</option>
                                <option>B-</option>
                                <option>AB+</option>
                                <option>AB-</option>
                                <option>O+</option>
                                <option>O-</option>

                            </select>

                        </div>


                        <div class="pl-emergency-field pl-emergency-span-2">

                            <label>
                                Requirement Description <b>*</b>
                            </label>

                            <textarea name="requirement"
                                      id="emergencyRequirement"
                                      rows="4"
                                      maxlength="1800"
                                      placeholder="Explain the emergency, assistance required and other important information..."
                                      required></textarea>

                            <small class="pl-emergency-counter">
                                <span id="emergencyRequirementCount">0</span>/1800
                            </small>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     MEDICAL / BLOOD DETAILS
                ================================================== -->
                <div class="pl-emergency-medical-block"
                     id="medicalEmergencyFields">

                    <div class="pl-emergency-form-title">

                        <div>
                            <i class="bi bi-heart-pulse-fill"></i>
                        </div>

                        <span>
                            <strong>Medical / Blood Requirement</strong>
                            <small>Additional details for medical emergencies.</small>
                        </span>

                    </div>


                    <div class="pl-emergency-form-grid">

                        <div class="pl-emergency-field">

                            <label>Patient Name</label>

                            <input type="text"
                                   name="patient_name"
                                   placeholder="Patient name">

                        </div>


                        <div class="pl-emergency-field">

                            <label>Hospital Name</label>

                            <input type="text"
                                   name="medical_hospital"
                                   placeholder="Hospital name">

                        </div>


                        <div class="pl-emergency-field">

                            <label>Blood Group</label>

                            <select name="medical_blood_group">

                                <option value="">Select Blood Group</option>
                                <option>A+</option>
                                <option>A-</option>
                                <option>B+</option>
                                <option>B-</option>
                                <option>AB+</option>
                                <option>AB-</option>
                                <option>O+</option>
                                <option>O-</option>

                            </select>

                        </div>


                        <div class="pl-emergency-field">

                            <label>Units Required</label>

                            <input type="number"
                                   name="blood_units"
                                   min="1"
                                   placeholder="Units">

                        </div>


                        <div class="pl-emergency-field">

                            <label>Doctor / Department</label>

                            <input type="text"
                                   name="doctor_department"
                                   placeholder="Doctor or department">

                        </div>


                        <div class="pl-emergency-field">

                            <label>Contact Person</label>

                            <input type="text"
                                   name="medical_contact_person"
                                   placeholder="Contact person">

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     CONTACT
                ================================================== -->
                <div class="pl-emergency-form-block">

                    <div class="pl-emergency-form-title">

                        <div>
                            <i class="bi bi-person-lines-fill"></i>
                        </div>

                        <span>
                            <strong>Contact Information</strong>
                            <small>Used for verification and emergency updates.</small>
                        </span>

                    </div>


                    <div class="pl-emergency-form-grid">

                        <div class="pl-emergency-field">

                            <label>
                                Contact Person <b>*</b>
                            </label>

                            <input type="text"
                                   name="contact_person"
                                   required>

                        </div>


                        <div class="pl-emergency-field">

                            <label>
                                Mobile Number <b>*</b>
                            </label>

                            <input type="tel"
                                   name="mobile"
                                   placeholder="+91"
                                   required>

                        </div>


                        <div class="pl-emergency-field">

                            <label>Email</label>

                            <input type="email"
                                   name="email"
                                   placeholder="Email address">

                        </div>


                        <div class="pl-emergency-field">

                            <label>WhatsApp</label>

                            <input type="tel"
                                   name="whatsapp"
                                   placeholder="+91">

                        </div>


                        <div class="pl-emergency-field pl-emergency-span-2">

                            <label>
                                Preferred Contact Method
                            </label>

                            <select name="preferred_contact">

                                <option>
                                    Enquiry / Secure Message
                                </option>

                                <option>Phone</option>
                                <option>WhatsApp</option>
                                <option>Email</option>

                            </select>

                        </div>

                    </div>

                </div>


                <!-- =================================================
                     DOCUMENTS
                ================================================== -->
                <div class="pl-emergency-form-block">

                    <div class="pl-emergency-form-title">

                        <div>
                            <i class="bi bi-file-earmark-medical-fill"></i>
                        </div>

                        <span>
                            <strong>Supporting Documents</strong>
                            <small>Upload only required supporting proof.</small>
                        </span>

                    </div>


                    <div class="pl-emergency-document-note">

                        <div>
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>

                        <p>
                            Supporting documents may include medical records,
                            hospital documents, blood requirement proof,
                            institution letters or other approved evidence.
                            Sensitive information should remain available only
                            to authorised users/admins.
                        </p>

                    </div>


                    <div class="pl-emergency-upload"
                         id="emergencyDropZone">

                        <input type="file"
                               id="emergencyDocuments"
                               name="supporting_documents[]"
                               multiple
                               accept=".jpg,.jpeg,.png,.pdf"
                               hidden>

                        <i class="bi bi-cloud-arrow-up-fill"></i>

                        <strong>
                            Upload Supporting Documents
                        </strong>

                        <span>
                            Drag & drop files here or select from your device
                        </span>

                        <button type="button"
                                class="pl-emergency-upload-btn"
                                onclick="document.getElementById('emergencyDocuments').click()">

                            <i class="bi bi-folder2-open"></i>
                            Select Documents

                        </button>

                        <small>
                            PDF, JPG and PNG files are recommended.
                        </small>

                    </div>


                    <div class="pl-emergency-file-list"
                         id="emergencyFileList"></div>

                </div>


                <!-- =================================================
                     VISIBILITY
                ================================================== -->
                <div class="pl-emergency-form-block">

                    <div class="pl-emergency-form-title">

                        <div>
                            <i class="bi bi-broadcast-pin"></i>
                        </div>

                        <span>
                            <strong>Emergency Visibility</strong>
                            <small>Choose who can see the approved request.</small>
                        </span>

                    </div>


                    <div class="pl-emergency-visibility">

                        <label class="pl-emergency-visibility-card active">

                            <input type="radio"
                                   name="emergency_visibility"
                                   value="community"
                                   checked>

                            <i class="bi bi-people-fill"></i>

                            <span>
                                <strong>Community-Specific</strong>
                                <small>
                                    Request can remain linked to the selected
                                    community.
                                </small>
                            </span>

                        </label>


                        <label class="pl-emergency-visibility-card">

                            <input type="radio"
                                   name="emergency_visibility"
                                   value="global">

                            <i class="bi bi-globe2"></i>

                            <span>
                                <strong>Eligible Global Support</strong>
                                <small>
                                    Request can be shared with eligible
                                    PeopleLink users.
                                </small>
                            </span>

                        </label>

                    </div>

                </div>


                <!-- =================================================
                     CONFIRMATION
                ================================================== -->
                <div class="pl-emergency-confirmation">

                    <label>

                        <input type="checkbox"
                               id="emergencyAgreement">

                        <span>
                            I confirm that this is a genuine emergency request
                            and the information provided is accurate to the best
                            of my knowledge.
                        </span>

                    </label>

                </div>


                <!-- =================================================
                     ACTIONS
                ================================================== -->
                <div class="pl-emergency-form-actions">

                    <button type="button"
                            class="pl-emergency-action secondary"
                            onclick="saveEmergencyDraft()">

                        <i class="bi bi-save2-fill"></i>
                        Save Draft

                    </button>


                    <button type="button"
                            class="pl-emergency-action preview"
                            onclick="previewEmergencyRequest()">

                        <i class="bi bi-eye-fill"></i>
                        Preview Request

                    </button>


                    <button type="submit"
                            class="pl-emergency-action primary">

                        <i class="bi bi-send-fill"></i>
                        Submit Emergency Request

                    </button>

                </div>

            </form>

        </div>

    </section>


    <!-- =========================================================
         ACTIVE REQUESTS
    ========================================================== -->
    <section class="pl-active-emergency"
             id="activeEmergencyRequests">

        <div class="pl-emergency-container">

            <div class="pl-emergency-section-heading">

                <span>
                    <i class="bi bi-broadcast-pin"></i>
                    Active Emergency Requests
                </span>

                <h2>People Who Need Urgent Support</h2>

                <p>
                    Approved emergency requests can be displayed to eligible
                    PeopleLink members according to privacy and visibility rules.
                </p>

            </div>


            <div class="pl-active-emergency-grid">

                <!-- CARD 1 -->
                <article class="pl-emergency-request-card">

                    <div class="pl-emergency-request-image">

                        <img src="https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=800&q=85"
                             alt="Medical emergency support">

                        <span class="urgent">
                            <i class="bi bi-lightning-fill"></i>
                            Urgent
                        </span>

                    </div>


                    <div class="pl-emergency-request-content">

                        <div class="pl-emergency-request-top">

                            <span>
                                <i class="bi bi-heart-pulse-fill"></i>
                                Medical Emergency
                            </span>

                            <small>Approved</small>

                        </div>

                        <h3>Medical Assistance Required</h3>

                        <p class="pl-emergency-request-location">
                            <i class="bi bi-geo-alt-fill"></i>
                            Location available to eligible users
                        </p>

                        <p>
                            Urgent support required for approved medical
                            treatment and related expenses.
                        </p>


                        <div class="pl-emergency-request-meta">

                            <div>
                                <small>Required</small>
                                <strong>₹80,000</strong>
                            </div>

                            <div>
                                <small>Received</small>
                                <strong>₹32,000</strong>
                            </div>

                        </div>


                        <div class="pl-emergency-progress">
                            <span style="width:40%;"></span>
                        </div>


                        <button type="button"
                                class="pl-emergency-request-btn"
                                onclick="showEmergencyToast('Emergency request details can be connected here.')">

                            View Details
                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </article>


                <!-- CARD 2 -->
                <article class="pl-emergency-request-card">

                    <div class="pl-emergency-request-image">

                        <img src="https://images.unsplash.com/photo-1538108149393-fbbd81895907?auto=format&fit=crop&w=800&q=85"
                             alt="Blood requirement">

                        <span class="blood">
                            <i class="bi bi-droplet-fill"></i>
                            Blood Needed
                        </span>

                    </div>


                    <div class="pl-emergency-request-content">

                        <div class="pl-emergency-request-top">

                            <span>
                                <i class="bi bi-droplet-fill"></i>
                                Blood Requirement
                            </span>

                            <small>Urgent</small>

                        </div>

                        <h3>Urgent Blood Requirement</h3>

                        <p class="pl-emergency-request-location">
                            <i class="bi bi-hospital-fill"></i>
                            Hospital details available to eligible users
                        </p>

                        <p>
                            Approved blood requirement requiring urgent
                            community response.
                        </p>


                        <div class="pl-emergency-request-meta">

                            <div>
                                <small>Blood Group</small>
                                <strong>O+</strong>
                            </div>

                            <div>
                                <small>Units</small>
                                <strong>3</strong>
                            </div>

                        </div>


                        <button type="button"
                                class="pl-emergency-request-btn"
                                onclick="showEmergencyToast('Blood requirement details can be connected here.')">

                            View Details
                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </article>


                <!-- CARD 3 -->
                <article class="pl-emergency-request-card">

                    <div class="pl-emergency-request-image">

                        <img src="https://images.unsplash.com/photo-1504150558240-0b4fd8946624?auto=format&fit=crop&w=800&q=85"
                             alt="Emergency family support">

                        <span>
                            <i class="bi bi-check-circle-fill"></i>
                            Approved
                        </span>

                    </div>


                    <div class="pl-emergency-request-content">

                        <div class="pl-emergency-request-top">

                            <span>
                                <i class="bi bi-house-heart-fill"></i>
                                Family Assistance
                            </span>

                            <small>Community</small>

                        </div>

                        <h3>Urgent Family Assistance</h3>

                        <p class="pl-emergency-request-location">
                            <i class="bi bi-geo-alt-fill"></i>
                            Community location protected
                        </p>

                        <p>
                            Genuine emergency assistance requested for an
                            approved family requirement.
                        </p>


                        <div class="pl-emergency-request-meta">

                            <div>
                                <small>Required</small>
                                <strong>₹35,000</strong>
                            </div>

                            <div>
                                <small>Received</small>
                                <strong>₹15,000</strong>
                            </div>

                        </div>


                        <div class="pl-emergency-progress">
                            <span style="width:43%;"></span>
                        </div>


                        <button type="button"
                                class="pl-emergency-request-btn"
                                onclick="showEmergencyToast('Emergency request details can be connected here.')">

                            View Details
                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </article>

            </div>

        </div>

    </section>


    <!-- =========================================================
         OFFER HELP
    ========================================================== -->
    <section class="pl-emergency-help-options">

        <div class="pl-emergency-container">

            <div class="pl-emergency-section-heading">

                <span>
                    <i class="bi bi-hand-thumbs-up-fill"></i>
                    Offer Help
                </span>

                <h2>How You Can Support</h2>

                <p>
                    Eligible users can choose from configured assistance
                    options for approved emergency requests.
                </p>

            </div>


            <div class="pl-emergency-help-grid">

                <div class="pl-emergency-help-card">

                    <div class="pl-help-icon">
                        <i class="bi bi-telephone-fill"></i>
                    </div>

                    <h3>Contact Requester</h3>

                    <p>
                        Contact the requester through approved privacy-safe
                        communication options.
                    </p>

                    <button type="button"
                            onclick="showEmergencyToast('Contact workflow can be connected here.')">

                        Contact
                        <i class="bi bi-arrow-right"></i>

                    </button>

                </div>


                <div class="pl-emergency-help-card">

                    <div class="pl-help-icon">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>

                    <h3>Send Enquiry</h3>

                    <p>
                        Send a secure enquiry without directly exposing
                        personal contact information where required.
                    </p>

                    <button type="button"
                            onclick="showEmergencyToast('Secure enquiry workflow can be connected here.')">

                        Send Enquiry
                        <i class="bi bi-arrow-right"></i>

                    </button>

                </div>


                <div class="pl-emergency-help-card">

                    <div class="pl-help-icon">
                        <i class="bi bi-hand-heart-fill"></i>
                    </div>

                    <h3>Offer Assistance</h3>

                    <p>
                        Let the requester or authorised admin know that
                        you are available to help.
                    </p>

                    <button type="button"
                            onclick="showEmergencyToast('Assistance workflow can be connected here.')">

                        Offer Help
                        <i class="bi bi-arrow-right"></i>

                    </button>

                </div>


                <div class="pl-emergency-help-card">

                    <div class="pl-help-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>

                    <h3>Contribute</h3>

                    <p>
                        Financial contribution can be enabled where the
                        configured payment workflow supports it.
                    </p>

                    <button type="button"
                            onclick="showEmergencyToast('Contribution workflow can be connected here.')">

                        Support Now
                        <i class="bi bi-arrow-right"></i>

                    </button>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         TRACKING
    ========================================================== -->
    <section class="pl-emergency-tools">

        <div class="pl-emergency-container">

            <div class="pl-emergency-tool-grid">

                <div class="pl-emergency-tool-card">

                    <div class="pl-emergency-tool-icon">
                        <i class="bi bi-person-check-fill"></i>
                    </div>

                    <div>

                        <h3>My Emergency Requests</h3>

                        <p>
                            Track submitted requests, approval status,
                            support received and updates.
                        </p>

                        <button type="button"
                                onclick="showEmergencyToast('My Emergency Requests can be connected to your dashboard.')">

                            My Requests
                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </div>


                <div class="pl-emergency-tool-card">

                    <div class="pl-emergency-tool-icon">
                        <i class="bi bi-check2-circle"></i>
                    </div>

                    <div>

                        <h3>Mark as Resolved</h3>

                        <p>
                            Requesters or authorised admins can close an
                            emergency after the situation is resolved.
                        </p>

                        <button type="button"
                                onclick="showEmergencyToast('Resolve workflow can be connected here.')">

                            Mark Resolved
                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </div>


                <div class="pl-emergency-tool-card">

                    <div class="pl-emergency-tool-icon">
                        <i class="bi bi-bell-fill"></i>
                    </div>

                    <div>

                        <h3>Emergency Notifications</h3>

                        <p>
                            Relevant users can receive alerts according to
                            community, location and emergency type.
                        </p>

                        <button type="button"
                                onclick="showEmergencyToast('Notification settings can be connected here.')">

                            Notifications
                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         PRIVACY
    ========================================================== -->
    <section class="pl-emergency-privacy">

        <div class="pl-emergency-container">

            <div class="pl-emergency-privacy-box">

                <div class="pl-emergency-privacy-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>

                <div>

                    <span>
                        Privacy & Safety
                    </span>

                    <h2>Protecting Emergency Information</h2>

                    <p>
                        Personal medical information, financial details,
                        exact addresses and uploaded documents should remain
                        visible only to authorised users where necessary.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         COMMUNITY SUPPORT
    ========================================================== -->
    <section class="pl-emergency-community">

        <div class="pl-emergency-container">

            <div class="pl-emergency-community-box">

                <div class="pl-emergency-community-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div>

                    <span>
                        Community-Specific Emergency Support
                    </span>

                    <h2>Support Can Stay Within the Right Community</h2>

                    <p>
                        Emergency requests can remain linked to the relevant
                        community. Community Admins should access only their
                        authorised community data, while Super Admin can view
                        permitted requests across communities.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         REPORT
    ========================================================== -->
    <section class="pl-emergency-report">

        <div class="pl-emergency-container">

            <div class="pl-emergency-report-inner">

                <div class="pl-emergency-report-content">

                    <i class="bi bi-flag-fill"></i>

                    <div>

                        <h3>Report Misuse</h3>

                        <p>
                            Report suspicious, false or misleading emergency
                            requests for administrative review.
                        </p>

                    </div>

                </div>


                <button type="button"
                        class="pl-emergency-report-btn"
                        onclick="showEmergencyToast('Report workflow can be connected to the admin review system.')">

                    <i class="bi bi-flag-fill"></i>
                    Report Request

                </button>

            </div>

        </div>

    </section>


    <!-- =========================================================
         FINAL CTA
    ========================================================== -->
    <section class="pl-emergency-final-cta">

        <div class="pl-emergency-container">

            <div class="pl-emergency-final-content">

                <span>
                    <i class="bi bi-heart-pulse-fill"></i>
                    PeopleLink Emergency Help
                </span>

                <h2>Help Faster. Support Better.</h2>

                <p>
                    PeopleLink Emergency Help can connect genuine urgent needs
                    with the right people at the right time.
                </p>


                <div class="pl-emergency-final-actions">

                    <button type="button"
                            class="pl-emergency-btn pl-emergency-btn-primary"
                            onclick="scrollToEmergencyForm()">

                        <i class="bi bi-plus-circle-fill"></i>
                        Request Help

                    </button>


                    <button type="button"
                            class="pl-emergency-btn pl-emergency-btn-light"
                            onclick="scrollToActiveEmergency()">

                        <i class="bi bi-broadcast-pin"></i>
                        Active Requests

                    </button>


                    <button type="button"
                            class="pl-emergency-btn pl-emergency-btn-light"
                            onclick="scrollToHelpOptions()">

                        <i class="bi bi-hand-thumbs-up-fill"></i>
                        Offer Help

                    </button>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================================
         PREVIEW MODAL
    ========================================================== -->
    <div class="pl-emergency-modal"
         id="emergencyPreviewModal">

        <div class="pl-emergency-modal-box">

            <button type="button"
                    class="pl-emergency-modal-close"
                    onclick="closeEmergencyPreview()">

                <i class="bi bi-x-lg"></i>

            </button>


            <div class="pl-emergency-modal-icon">
                <i class="bi bi-eye-fill"></i>
            </div>

            <h3>Emergency Request Preview</h3>

            <p>
                Review the basic emergency information before submitting.
            </p>


            <div class="pl-emergency-preview">

                <div>
                    <small>Requester</small>
                    <strong id="previewEmergencyRequester">—</strong>
                </div>

                <div>
                    <small>Emergency Type</small>
                    <strong id="previewEmergencyType">—</strong>
                </div>

                <div>
                    <small>Location</small>
                    <strong id="previewEmergencyLocation">—</strong>
                </div>

                <div>
                    <small>Urgency</small>
                    <strong id="previewEmergencyUrgency">—</strong>
                </div>

                <div class="full">

                    <small>Requirement</small>

                    <p id="previewEmergencyRequirement">
                        —
                    </p>

                </div>

            </div>


            <button type="button"
                    class="pl-emergency-btn pl-emergency-btn-primary pl-emergency-modal-btn"
                    onclick="closeEmergencyPreview()">

                <i class="bi bi-check2"></i>
                Continue Editing

            </button>

        </div>

    </div>


    <!-- =========================================================
         TOAST
    ========================================================== -->
    <div class="pl-emergency-toast"
         id="emergencyToast">

        <i class="bi bi-check-circle-fill"></i>

        <span id="emergencyToastText">
            Done successfully.
        </span>

    </div>

</main>

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
<script src="emergency-help.js"></script>
</body>
</html>