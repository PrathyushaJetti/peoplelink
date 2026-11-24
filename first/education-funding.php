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
        href="education-funding.css"
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


<main class="pl-education-page">

    <!-- HERO -->
    <section class="pl-education-hero">
        <div class="pl-education-hero-content">

            <span class="pl-education-eyebrow">
                <i class="bi bi-mortarboard-fill"></i>
                PeopleLink Education Support
            </span>

            <h1>Education Support</h1>

            <p>
                Support education. Build better futures. Raise genuine education
                assistance requests within your community and connect eligible
                needs with people willing to help.
            </p>

            <div class="pl-education-hero-actions">

                <button type="button"
                        class="pl-edu-btn pl-edu-btn-primary"
                        onclick="scrollToEducationForm()">
                    <i class="bi bi-pencil-square"></i>
                    Request Education Support
                </button>

                <button type="button"
                        class="pl-edu-btn pl-edu-btn-light"
                        onclick="scrollToApprovedRequests()">
                    <i class="bi bi-search"></i>
                    View Approved Requests
                </button>

            </div>

        </div>
    </section>


    <!-- INTRO -->
    <section class="pl-education-intro">

        <div class="pl-education-container">

            <div class="pl-education-heading">

                <span>
                    <i class="bi bi-heart-fill"></i>
                    Education Assistance
                </span>

                <h2>Support Education. Build Better Futures.</h2>

                <p>
                    PeopleLink can help eligible students and families raise or
                    request support for genuine education-related needs within
                    their community.
                </p>

            </div>

            <div class="pl-education-benefits">

                <div class="pl-edu-benefit">
                    <i class="bi bi-person-check-fill"></i>
                    <div>
                        <strong>Genuine Requests</strong>
                        <small>Education needs can be submitted for review.</small>
                    </div>
                </div>

                <div class="pl-edu-benefit">
                    <i class="bi bi-shield-check"></i>
                    <div>
                        <strong>Admin Verification</strong>
                        <small>Requests can be reviewed before publication.</small>
                    </div>
                </div>

                <div class="pl-edu-benefit">
                    <i class="bi bi-people-fill"></i>
                    <div>
                        <strong>Community Support</strong>
                        <small>Connect eligible needs with supportive members.</small>
                    </div>
                </div>

            </div>

        </div>

    </section>


    <!-- WHO CAN REQUEST -->
    <section class="pl-education-needs">

        <div class="pl-education-container">

            <div class="pl-education-heading left">

                <span>
                    <i class="bi bi-bookmark-star-fill"></i>
                    Eligible Education Needs
                </span>

                <h2>Who Can Request Support?</h2>

                <p>
                    Education assistance may be requested for approved
                    education-related needs such as:
                </p>

            </div>

            <div class="pl-education-need-grid">

                <div class="pl-education-need">
                    <i class="bi bi-building"></i>
                    <span>School Fees</span>
                </div>

                <div class="pl-education-need">
                    <i class="bi bi-bank"></i>
                    <span>College Fees</span>
                </div>

                <div class="pl-education-need">
                    <i class="bi bi-mortarboard"></i>
                    <span>Higher Education</span>
                </div>

                <div class="pl-education-need">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Books & Study Material</span>
                </div>

                <div class="pl-education-need">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span>Examination Fees</span>
                </div>

                <div class="pl-education-need">
                    <i class="bi bi-award-fill"></i>
                    <span>Professional Courses</span>
                </div>

                <div class="pl-education-need">
                    <i class="bi bi-lightbulb-fill"></i>
                    <span>Skill Training</span>
                </div>

                <div class="pl-education-need">
                    <i class="bi bi-three-dots"></i>
                    <span>Other Approved Needs</span>
                </div>

            </div>

        </div>

    </section>


    <!-- REQUEST FORM -->
    <section class="pl-education-form-section"
             id="educationRequestForm">

        <div class="pl-education-container">

            <div class="pl-education-heading">

                <span>
                    <i class="bi bi-pencil-square"></i>
                    Submit an Education Request
                </span>

                <h2>Tell Us About the Education Need</h2>

                <p>
                    Provide genuine information and upload only the supporting
                    documents required for verification.
                </p>

            </div>


            <form class="pl-education-form"
                  id="educationSupportForm"
                  enctype="multipart/form-data">


                <!-- STUDENT -->
                <div class="pl-edu-form-block">

                    <div class="pl-edu-form-title">

                        <div>
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <span>
                            <strong>Student Information</strong>
                            <small>Basic details about the student.</small>
                        </span>

                    </div>

                    <div class="pl-edu-form-grid">

                        <div class="pl-edu-field">
                            <label>
                                Student Name <b>*</b>
                            </label>

                            <input type="text"
                                   name="student_name"
                                   placeholder="Enter student name"
                                   required>
                        </div>

                        <div class="pl-edu-field">
                            <label>
                                Parent / Guardian Name <b>*</b>
                            </label>

                            <input type="text"
                                   name="guardian_name"
                                   placeholder="Enter parent or guardian name"
                                   required>
                        </div>

                        <div class="pl-edu-field">
                            <label>Community</label>

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

                        <div class="pl-edu-field">
                            <label>
                                Education Level <b>*</b>
                            </label>

                            <select name="education_level" required>

                                <option value="">
                                    Select Education Level
                                </option>

                                <option>School</option>
                                <option>Higher Secondary</option>
                                <option>College</option>
                                <option>Undergraduate</option>
                                <option>Postgraduate</option>
                                <option>Professional Course</option>
                                <option>Skill Training</option>
                                <option>Other</option>

                            </select>
                        </div>

                    </div>

                </div>


                <!-- EDUCATION -->
                <div class="pl-edu-form-block">

                    <div class="pl-edu-form-title">

                        <div>
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>

                        <span>
                            <strong>Education Details</strong>
                            <small>Tell us about the institution and course.</small>
                        </span>

                    </div>

                    <div class="pl-edu-form-grid">

                        <div class="pl-edu-field pl-edu-span-2">

                            <label>
                                School / College / Institution <b>*</b>
                            </label>

                            <input type="text"
                                   name="institution"
                                   placeholder="Enter institution name"
                                   required>

                        </div>

                        <div class="pl-edu-field">

                            <label>
                                Course / Class <b>*</b>
                            </label>

                            <input type="text"
                                   name="course_class"
                                   placeholder="e.g. Class 12 / B.Tech / MBA"
                                   required>

                        </div>

                        <div class="pl-edu-field">

                            <label>
                                Location <b>*</b>
                            </label>

                            <input type="text"
                                   name="education_location"
                                   placeholder="City / Area"
                                   required>

                        </div>

                    </div>

                </div>


                <!-- SUPPORT -->
                <div class="pl-edu-form-block">

                    <div class="pl-edu-form-title">

                        <div>
                            <i class="bi bi-cash-coin"></i>
                        </div>

                        <span>
                            <strong>Support Requirement</strong>
                            <small>Explain the financial requirement.</small>
                        </span>

                    </div>

                    <div class="pl-edu-form-grid">

                        <div class="pl-edu-field">

                            <label>
                                Amount Required <b>*</b>
                            </label>

                            <div class="pl-edu-money">

                                <span>₹</span>

                                <input type="number"
                                       name="amount_required"
                                       min="1"
                                       placeholder="Enter amount"
                                       required>

                            </div>

                        </div>

                        <div class="pl-edu-field">

                            <label>
                                Required By Date <b>*</b>
                            </label>

                            <input type="date"
                                   name="required_by"
                                   required>

                        </div>

                        <div class="pl-edu-field pl-edu-span-2">

                            <label>
                                Reason for Support <b>*</b>
                            </label>

                            <textarea name="support_reason"
                                      rows="4"
                                      maxlength="1500"
                                      id="supportReason"
                                      placeholder="Explain the education requirement and why support is needed..."
                                      required></textarea>

                            <small class="pl-edu-counter">
                                <span id="supportReasonCount">0</span>/1500
                            </small>

                        </div>

                    </div>

                </div>


                <!-- CONTACT -->
                <div class="pl-edu-form-block">

                    <div class="pl-edu-form-title">

                        <div>
                            <i class="bi bi-person-lines-fill"></i>
                        </div>

                        <span>
                            <strong>Contact Information</strong>
                            <small>Used for verification and important updates.</small>
                        </span>

                    </div>

                    <div class="pl-edu-form-grid">

                        <div class="pl-edu-field">

                            <label>
                                Contact Person <b>*</b>
                            </label>

                            <input type="text"
                                   name="contact_person"
                                   required>

                        </div>

                        <div class="pl-edu-field">

                            <label>
                                Mobile Number <b>*</b>
                            </label>

                            <input type="tel"
                                   name="mobile"
                                   placeholder="+91"
                                   required>

                        </div>

                        <div class="pl-edu-field">

                            <label>Email</label>

                            <input type="email"
                                   name="email"
                                   placeholder="Email address">

                        </div>

                        <div class="pl-edu-field">

                            <label>WhatsApp</label>

                            <input type="tel"
                                   name="whatsapp"
                                   placeholder="+91">

                        </div>

                        <div class="pl-edu-field pl-edu-span-2">

                            <label>
                                Preferred Contact Method
                            </label>

                            <select name="preferred_contact">

                                <option>Enquiry / Secure Message</option>
                                <option>Phone</option>
                                <option>WhatsApp</option>
                                <option>Email</option>

                            </select>

                        </div>

                    </div>

                </div>


                <!-- DOCUMENTS -->
                <div class="pl-edu-form-block">

                    <div class="pl-edu-form-title">

                        <div>
                            <i class="bi bi-file-earmark-check-fill"></i>
                        </div>

                        <span>
                            <strong>Supporting Documents</strong>
                            <small>Upload only required supporting proof.</small>
                        </span>

                    </div>

                    <div class="pl-edu-document-info">

                        <div class="pl-edu-document-icon">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>

                        <p>
                            Supporting documents may include fee structure,
                            admission letter, student ID, marks memo,
                            institution letter or other approved proof.
                            Sensitive documents should only be accessible
                            to authorised users/admins.
                        </p>

                    </div>

                    <div class="pl-edu-upload"
                         id="educationDropZone">

                        <input type="file"
                               id="educationDocuments"
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
                                class="pl-edu-upload-btn"
                                onclick="document.getElementById('educationDocuments').click()">

                            <i class="bi bi-folder2-open"></i>
                            Select Documents

                        </button>

                        <small>
                            PDF, JPG and PNG files are recommended.
                        </small>

                    </div>

                    <div class="pl-edu-file-list"
                         id="educationFileList"></div>

                </div>


                <!-- VISIBILITY -->
                <div class="pl-edu-form-block">

                    <div class="pl-edu-form-title">

                        <div>
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <span>
                            <strong>Community Support</strong>
                            <small>Choose how your request should be handled.</small>
                        </span>

                    </div>

                    <div class="pl-edu-visibility">

                        <label class="pl-edu-visibility-card active">

                            <input type="radio"
                                   name="request_visibility"
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

                        <label class="pl-edu-visibility-card">

                            <input type="radio"
                                   name="request_visibility"
                                   value="global">

                            <i class="bi bi-globe2"></i>

                            <span>
                                <strong>Eligible Global Support</strong>
                                <small>
                                    Request can be displayed to eligible
                                    PeopleLink members.
                                </small>
                            </span>

                        </label>

                    </div>

                </div>


                <!-- CONFIRMATION -->
                <div class="pl-edu-confirmation">

                    <label>

                        <input type="checkbox"
                               id="educationAgreement">

                        <span>
                            I confirm that the information provided is genuine
                            and accurate and that the supporting documents
                            submitted are relevant to this education request.
                        </span>

                    </label>

                </div>


                <!-- ACTIONS -->
                <div class="pl-edu-form-actions">

                    <button type="button"
                            class="pl-edu-action secondary"
                            onclick="saveEducationDraft()">

                        <i class="bi bi-save2-fill"></i>
                        Save Draft

                    </button>

                    <button type="button"
                            class="pl-edu-action preview"
                            onclick="previewEducationRequest()">

                        <i class="bi bi-eye-fill"></i>
                        Preview Request

                    </button>

                    <button type="submit"
                            class="pl-edu-action primary">

                        <i class="bi bi-send-fill"></i>
                        Submit Request

                    </button>

                </div>

            </form>

        </div>

    </section>


    <!-- APPROVED REQUESTS -->
    <section class="pl-approved-education"
             id="approvedEducationRequests">

        <div class="pl-education-container">

            <div class="pl-education-heading">

                <span>
                    <i class="bi bi-heart-fill"></i>
                    Approved Education Requests
                </span>

                <h2>Help Create an Opportunity</h2>

                <p>
                    Approved requests can be displayed to eligible members
                    according to PeopleLink privacy and approval settings.
                </p>

            </div>


            <div class="pl-approved-grid">

                <!-- CARD 1 -->
                <article class="pl-education-request-card">

                    <div class="pl-request-image">

                        <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=800&q=85"
                             alt="Education support">

                        <span>
                            <i class="bi bi-check-circle-fill"></i>
                            Approved
                        </span>

                    </div>

                    <div class="pl-request-content">

                        <div class="pl-request-top">

                            <span>
                                <i class="bi bi-mortarboard-fill"></i>
                                Higher Education
                            </span>

                            <small>
                                Community Support
                            </small>

                        </div>

                        <h3>Education Support Request</h3>

                        <p class="pl-request-institution">
                            <i class="bi bi-building"></i>
                            Institution details visible to eligible users
                        </p>

                        <p>
                            Support required for approved education expenses
                            and academic needs.
                        </p>

                        <div class="pl-request-amount">

                            <div>
                                <small>Amount Required</small>
                                <strong>₹75,000</strong>
                            </div>

                            <div>
                                <small>Support Received</small>
                                <strong>₹35,000</strong>
                            </div>

                        </div>

                        <div class="pl-request-progress">

                            <span style="width:46%;"></span>

                        </div>

                        <button type="button"
                                class="pl-request-btn"
                                onclick="showEducationToast('Request details can be connected here.')">

                            View Request
                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </article>


                <!-- CARD 2 -->
                <article class="pl-education-request-card">

                    <div class="pl-request-image">

                        <img src="https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?auto=format&fit=crop&w=800&q=85"
                             alt="Student education support">

                        <span>
                            <i class="bi bi-check-circle-fill"></i>
                            Approved
                        </span>

                    </div>

                    <div class="pl-request-content">

                        <div class="pl-request-top">

                            <span>
                                <i class="bi bi-book-fill"></i>
                                College Education
                            </span>

                            <small>
                                Community Support
                            </small>

                        </div>

                        <h3>College Education Assistance</h3>

                        <p class="pl-request-institution">
                            <i class="bi bi-geo-alt-fill"></i>
                            Location available to eligible users
                        </p>

                        <p>
                            Assistance requested for approved academic
                            and study-related expenses.
                        </p>

                        <div class="pl-request-amount">

                            <div>
                                <small>Amount Required</small>
                                <strong>₹50,000</strong>
                            </div>

                            <div>
                                <small>Support Received</small>
                                <strong>₹20,000</strong>
                            </div>

                        </div>

                        <div class="pl-request-progress">

                            <span style="width:40%;"></span>

                        </div>

                        <button type="button"
                                class="pl-request-btn"
                                onclick="showEducationToast('Request details can be connected here.')">

                            View Request
                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </article>


                <!-- CARD 3 -->
                <article class="pl-education-request-card">

                    <div class="pl-request-image">

                        <img src="https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?auto=format&fit=crop&w=800&q=85"
                             alt="Education student support">

                        <span>
                            <i class="bi bi-check-circle-fill"></i>
                            Approved
                        </span>

                    </div>

                    <div class="pl-request-content">

                        <div class="pl-request-top">

                            <span>
                                <i class="bi bi-lightbulb-fill"></i>
                                Skill Training
                            </span>

                            <small>
                                Global Eligible
                            </small>

                        </div>

                        <h3>Professional Skill Training</h3>

                        <p class="pl-request-institution">
                            <i class="bi bi-award-fill"></i>
                            Training details available
                        </p>

                        <p>
                            Support requested for an approved professional
                            skill-development programme.
                        </p>

                        <div class="pl-request-amount">

                            <div>
                                <small>Amount Required</small>
                                <strong>₹30,000</strong>
                            </div>

                            <div>
                                <small>Support Received</small>
                                <strong>₹12,000</strong>
                            </div>

                        </div>

                        <div class="pl-request-progress">

                            <span style="width:40%;"></span>

                        </div>

                        <button type="button"
                                class="pl-request-btn"
                                onclick="showEducationToast('Request details can be connected here.')">

                            View Request
                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </article>

            </div>

        </div>

    </section>


    <!-- SUPPORT PROCESS -->
    <section class="pl-education-process">

        <div class="pl-education-container">

            <div class="pl-education-heading">

                <span>
                    <i class="bi bi-diagram-3-fill"></i>
                    Education Support Process
                </span>

                <h2>From Request to Support</h2>

            </div>

            <div class="pl-education-process-grid">

                <div class="pl-process-step">

                    <span>01</span>

                    <i class="bi bi-pencil-square"></i>

                    <h3>Submit</h3>

                    <p>
                        Applicant submits a genuine education assistance request.
                    </p>

                </div>

                <div class="pl-process-line"></div>

                <div class="pl-process-step">

                    <span>02</span>

                    <i class="bi bi-shield-check"></i>

                    <h3>Verify</h3>

                    <p>
                        Authorised Community Admin or Sub-Admin reviews the request.
                    </p>

                </div>

                <div class="pl-process-line"></div>

                <div class="pl-process-step">

                    <span>03</span>

                    <i class="bi bi-check-circle-fill"></i>

                    <h3>Approve</h3>

                    <p>
                        Approved requests can become visible to eligible members.
                    </p>

                </div>

                <div class="pl-process-line"></div>

                <div class="pl-process-step">

                    <span>04</span>

                    <i class="bi bi-heart-fill"></i>

                    <h3>Support</h3>

                    <p>
                        Eligible users can support or contact the applicant.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- TRACKING / MY REQUESTS -->
    <section class="pl-education-tools">

        <div class="pl-education-container">

            <div class="pl-education-tool-grid">

                <div class="pl-education-tool-card">

                    <div class="pl-tool-icon">
                        <i class="bi bi-person-check-fill"></i>
                    </div>

                    <div>
                        <h3>My Education Requests</h3>

                        <p>
                            Track submission date, verification status,
                            approved amount, support received and current status.
                        </p>

                        <button type="button"
                                onclick="showEducationToast('My Requests can be connected to the applicant dashboard.')">

                            <i class="bi bi-arrow-right"></i>
                            My Requests

                        </button>
                    </div>

                </div>


                <div class="pl-education-tool-card">

                    <div class="pl-tool-icon">
                        <i class="bi bi-bar-chart-fill"></i>
                    </div>

                    <div>
                        <h3>Contribution Tracking</h3>

                        <p>
                            Where contributions are processed through PeopleLink,
                            required, received and balance amounts can be tracked.
                        </p>

                        <button type="button"
                                onclick="showEducationToast('Contribution tracking can be connected here.')">

                            <i class="bi bi-arrow-right"></i>
                            View Contributions

                        </button>
                    </div>

                </div>


                <div class="pl-education-tool-card">

                    <div class="pl-tool-icon">
                        <i class="bi bi-bell-fill"></i>
                    </div>

                    <div>
                        <h3>Notifications</h3>

                        <p>
                            Applicants can receive updates for submission,
                            approval, clarification and contribution events.
                        </p>

                        <button type="button"
                                onclick="showEducationToast('Notification preferences can be connected here.')">

                            <i class="bi bi-arrow-right"></i>
                            Notification Settings

                        </button>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- PRIVACY -->
    <section class="pl-education-privacy">

        <div class="pl-education-container">

            <div class="pl-privacy-box">

                <div class="pl-privacy-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>

                <div>

                    <span>Privacy & Security</span>

                    <h2>Protecting Student & Family Information</h2>

                    <p>
                        Student and family data should be protected. Sensitive
                        documents, personal addresses, financial information
                        and private contact details should only be available
                        to authorised users and administrators according to
                        configured privacy rules.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- REPORT -->
    <section class="pl-education-report">

        <div class="pl-education-container">

            <div>

                <i class="bi bi-flag-fill"></i>

                <div>
                    <h3>Report / Flag a Request</h3>

                    <p>
                        Report suspicious, incorrect or misleading education
                        requests for administrative review.
                    </p>
                </div>

            </div>

            <button type="button"
                    class="pl-report-btn"
                    onclick="showEducationToast('Report workflow can be connected to the admin review system.')">

                <i class="bi bi-flag-fill"></i>
                Report Request

            </button>

        </div>

    </section>


    <!-- FINAL CTA -->
    <section class="pl-education-final-cta">

        <div>

            <span>
                <i class="bi bi-heart-fill"></i>
                PeopleLink Education Support
            </span>

            <h2>Every Student Deserves an Opportunity</h2>

            <p>
                PeopleLink Education Support can connect genuine educational
                needs with people willing to help.
            </p>

            <div class="pl-final-edu-actions">

                <button type="button"
                        class="pl-edu-btn pl-edu-btn-primary"
                        onclick="scrollToEducationForm()">

                    <i class="bi bi-pencil-square"></i>
                    Request Support

                </button>

                <button type="button"
                        class="pl-edu-btn pl-edu-btn-light"
                        onclick="scrollToApprovedRequests()">

                    <i class="bi bi-search"></i>
                    View Requests

                </button>

                <button type="button"
                        class="pl-edu-btn pl-edu-btn-light"
                        onclick="showEducationToast('My Requests can be connected to your PeopleLink dashboard.')">

                    <i class="bi bi-person-lines-fill"></i>
                    My Requests

                </button>

            </div>

        </div>

    </section>


    <!-- PREVIEW MODAL -->
    <div class="pl-education-modal"
         id="educationPreviewModal">

        <div class="pl-education-modal-box">

            <button type="button"
                    class="pl-education-modal-close"
                    onclick="closeEducationPreview()">

                <i class="bi bi-x-lg"></i>

            </button>

            <div class="pl-education-modal-icon">
                <i class="bi bi-eye-fill"></i>
            </div>

            <h3>Education Request Preview</h3>

            <p>
                Review the basic information before submitting your request.
            </p>

            <div class="pl-education-preview">

                <div>
                    <small>Student</small>
                    <strong id="previewStudent">—</strong>
                </div>

                <div>
                    <small>Education Level</small>
                    <strong id="previewLevel">—</strong>
                </div>

                <div>
                    <small>Institution</small>
                    <strong id="previewInstitution">—</strong>
                </div>

                <div>
                    <small>Amount Required</small>
                    <strong id="previewAmount">—</strong>
                </div>

                <div class="full">
                    <small>Reason for Support</small>
                    <p id="previewReason">—</p>
                </div>

            </div>

            <button type="button"
                    class="pl-edu-btn pl-edu-btn-primary pl-edu-modal-btn"
                    onclick="closeEducationPreview()">

                <i class="bi bi-check2"></i>
                Continue Editing

            </button>

        </div>

    </div>


    <!-- TOAST -->
    <div class="pl-education-toast"
         id="educationToast">

        <i class="bi bi-check-circle-fill"></i>

        <span id="educationToastText">
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
<script src="education-funding.js"></script>
</body>
</html>