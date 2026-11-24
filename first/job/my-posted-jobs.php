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
        href="my-posted-jobs.css"
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

<body>

<main class="mpj-page">
    <section class="mpj-hero"><div class="mpj-container mpj-hero-inner"><div><span class="mpj-eyebrow"><i class="fa-solid fa-briefcase"></i> PEOPLELINK CAREER NETWORK</span><h1>My Posted Jobs</h1><p>Manage your opportunities, track application activity and keep your listings up to date.</p></div><div class="mpj-hero-art"><span class="mpj-art-icon"><i class="fa-solid fa-clipboard-check"></i></span><span class="mpj-art-mini"><i class="fa-solid fa-users"></i></span></div></div></section>
    <div class="mpj-container mpj-content">
        <div class="mpj-heading-row"><div><span class="mpj-kicker">EMPLOYER WORKSPACE</span><h2>Your job listings</h2><p>Review status, monitor responses and manage each opportunity.</p></div><a class="mpj-btn primary" href="post-a-job.php"><i class="fa-solid fa-plus"></i> Post a Job</a></div>
        <section class="mpj-stats" aria-label="Job summary">
            <div class="mpj-stat"><span class="mpj-stat-icon blue"><i class="fa-solid fa-briefcase"></i></span><div><small>Total Jobs</small><strong>4</strong></div></div>
            <div class="mpj-stat"><span class="mpj-stat-icon green"><i class="fa-solid fa-circle-check"></i></span><div><small>Active Jobs</small><strong>2</strong></div></div>
            <div class="mpj-stat"><span class="mpj-stat-icon amber"><i class="fa-regular fa-clock"></i></span><div><small>Pending Approval</small><strong>1</strong></div></div>
            <div class="mpj-stat"><span class="mpj-stat-icon purple"><i class="fa-solid fa-user-group"></i></span><div><small>Applications Received</small><strong>18</strong></div></div>
        </section>
        <nav class="mpj-tabs" aria-label="Job status tabs">
            <a class="selected" href="#all-jobs">All Jobs <span>4</span></a>
            <a href="#active-jobs">Active Jobs <span>2</span></a>
            <a href="#pending-jobs">Pending Approval <span>1</span></a>
            <a href="#draft-jobs">Drafts <span>1</span></a>
            <a href="#closed-jobs">Closed Jobs <span>0</span></a>
        </nav>
        <form class="mpj-filters" method="get" action="my-posted-jobs.html">
            <label class="mpj-search"><i class="fa-solid fa-magnifying-glass"></i><input type="search" name="q" placeholder="Search job title, company or location" aria-label="Search jobs"></label>
            <select name="type" aria-label="Filter by job visibility"><option value="all">All job types</option><option value="community">Community Jobs</option><option value="global">Global Jobs</option></select>
            <select name="status" aria-label="Filter by status"><option value="all">All statuses</option><option>Active</option><option>Pending Approval</option><option>Draft</option><option>Rejected</option><option>Closed</option><option>Expired</option></select>
            <button class="mpj-btn filter-btn" type="submit"><i class="fa-solid fa-sliders"></i> Filter</button>
            <button class="mpj-reset" type="reset">Reset</button>
        </form>
        <div class="mpj-results-line"><strong>4 jobs found</strong><span>Manage listings and application activity</span></div>
        <div class="mpj-job-list">
            <article class="mpj-job-card" data-job-card data-title="PHP Web Developer" data-company="Deep Web Solution" data-visibility="Community Job" data-community="Arya Vysya" data-location="Rishikesh, Uttarakhand" data-posted="09 Oct 2026" data-closing="31 Oct 2026" data-openings="2" data-status="Active" data-applications="12" data-whatsapp="4" data-email="8" data-description="Develop and maintain responsive websites using PHP, MySQL, HTML, CSS and JavaScript." data-category="Information Technology" data-type="Full Time" data-salary="₹18,000–₹35,000/month">
                <div class="mpj-job-top"><div class="mpj-company-mark"><i class="fa-solid fa-building"></i></div><div class="mpj-job-title-wrap"><div class="mpj-badges"><span class="mpj-type-badge">Community Job</span><span class="mpj-community-badge"><i class="fa-solid fa-users"></i> Arya Vysya</span></div><h3>PHP Web Developer</h3><p class="mpj-company-name">Deep Web Solution</p></div><span class="mpj-status active"><span></span>Active</span></div>
                <div class="mpj-job-meta"><span><i class="fa-solid fa-location-dot"></i>Rishikesh, Uttarakhand</span><span><i class="fa-regular fa-calendar"></i>Posted 09 Oct 2026</span><span><i class="fa-regular fa-calendar-xmark"></i>Closes 31 Oct 2026</span><span><i class="fa-solid fa-user-plus"></i>2 openings</span></div>
                <div class="mpj-application-stats"><div><span class="mpj-mini-icon blue"><i class="fa-solid fa-users"></i></span><span><small>Applications Received</small><strong>12</strong></span></div><div><span class="mpj-mini-icon green"><i class="fa-brands fa-whatsapp"></i></span><span><small>WhatsApp Enquiries</small><strong>4</strong></span></div><div><span class="mpj-mini-icon orange"><i class="fa-regular fa-envelope"></i></span><span><small>Email Applications</small><strong>8</strong></span></div></div>
                <div class="mpj-card-actions"><button type="button" class="mpj-btn small outline" data-view-job><i class="fa-regular fa-eye"></i> View</button><a class="mpj-btn small outline" href="post-a-job.html"><i class="fa-regular fa-pen-to-square"></i> Edit</a><button class="mpj-btn small soft" type="button" data-demo-action="Close Job"><i class="fa-solid fa-lock"></i> Close Job</button><button class="mpj-icon-btn" type="button" data-demo-action="Delete job" aria-label="Delete job" title="Delete job"><i class="fa-regular fa-trash-can"></i></button></div>
            </article>
            <article class="mpj-job-card" data-job-card data-title="Sales Executive" data-company="PeopleLink Network" data-visibility="Global Job" data-community="" data-location="Dehradun, Uttarakhand" data-posted="07 Oct 2026" data-closing="25 Oct 2026" data-openings="3" data-status="Pending Approval" data-applications="6" data-whatsapp="2" data-email="4" data-description="Build client relationships and support business growth across the PeopleLink network." data-category="Sales & Marketing" data-type="Full Time" data-salary="₹20,000–₹30,000/month">
                <div class="mpj-job-top"><div class="mpj-company-mark global"><i class="fa-solid fa-earth-asia"></i></div><div class="mpj-job-title-wrap"><div class="mpj-badges"><span class="mpj-type-badge global">Global Job</span></div><h3>Sales Executive</h3><p class="mpj-company-name">PeopleLink Network</p></div><span class="mpj-status pending"><span></span>Pending Approval</span></div>
                <div class="mpj-job-meta"><span><i class="fa-solid fa-location-dot"></i>Dehradun, Uttarakhand</span><span><i class="fa-regular fa-calendar"></i>Posted 07 Oct 2026</span><span><i class="fa-regular fa-calendar-xmark"></i>Closes 25 Oct 2026</span><span><i class="fa-solid fa-user-plus"></i>3 openings</span></div>
                <div class="mpj-application-stats"><div><span class="mpj-mini-icon blue"><i class="fa-solid fa-users"></i></span><span><small>Applications Received</small><strong>6</strong></span></div><div><span class="mpj-mini-icon green"><i class="fa-brands fa-whatsapp"></i></span><span><small>WhatsApp Enquiries</small><strong>2</strong></span></div><div><span class="mpj-mini-icon orange"><i class="fa-regular fa-envelope"></i></span><span><small>Email Applications</small><strong>4</strong></span></div></div>
                <div class="mpj-card-actions"><button type="button" class="mpj-btn small outline" data-view-job><i class="fa-regular fa-eye"></i> View</button><a class="mpj-btn small outline" href="post-a-job.html"><i class="fa-regular fa-pen-to-square"></i> Edit</a><button class="mpj-btn small package" type="button" data-demo-action="Renew / Extend Package"><i class="fa-solid fa-credit-card"></i> Renew / Extend Package</button><button class="mpj-icon-btn" type="button" data-demo-action="Delete job" aria-label="Delete job" title="Delete job"><i class="fa-regular fa-trash-can"></i></button></div>
            </article>
            <article class="mpj-job-card" data-job-card data-title="Graphic Designer" data-company="PeopleLink Creative" data-visibility="Community Job" data-community="Reddy" data-location="Remote" data-posted="06 Oct 2026" data-closing="30 Oct 2026" data-openings="1" data-status="Draft" data-applications="0" data-whatsapp="0" data-email="0" data-description="Create digital creatives, social media graphics and marketing materials." data-category="Design & Creative" data-type="Freelance" data-salary="Negotiable">
                <div class="mpj-job-top"><div class="mpj-company-mark"><i class="fa-solid fa-building"></i></div><div class="mpj-job-title-wrap"><div class="mpj-badges"><span class="mpj-type-badge">Community Job</span><span class="mpj-community-badge"><i class="fa-solid fa-users"></i> Reddy</span></div><h3>Graphic Designer</h3><p class="mpj-company-name">PeopleLink Creative</p></div><span class="mpj-status draft"><span></span>Draft</span></div>
                <div class="mpj-job-meta"><span><i class="fa-solid fa-location-dot"></i>Remote</span><span><i class="fa-regular fa-calendar"></i>Posted 06 Oct 2026</span><span><i class="fa-regular fa-calendar-xmark"></i>Closes 30 Oct 2026</span><span><i class="fa-solid fa-user-plus"></i>1 opening</span></div>
                <div class="mpj-application-stats"><div><span class="mpj-mini-icon blue"><i class="fa-solid fa-users"></i></span><span><small>Applications Received</small><strong>0</strong></span></div><div><span class="mpj-mini-icon green"><i class="fa-brands fa-whatsapp"></i></span><span><small>WhatsApp Enquiries</small><strong>0</strong></span></div><div><span class="mpj-mini-icon orange"><i class="fa-regular fa-envelope"></i></span><span><small>Email Applications</small><strong>0</strong></span></div></div>
                <div class="mpj-card-actions"><button type="button" class="mpj-btn small outline" data-view-job><i class="fa-regular fa-eye"></i> View</button><a class="mpj-btn small outline" href="post-a-job.html"><i class="fa-regular fa-pen-to-square"></i> Edit</a><button class="mpj-icon-btn" type="button" data-demo-action="Delete job" aria-label="Delete job" title="Delete job"><i class="fa-regular fa-trash-can"></i></button></div>
            </article>
            <article class="mpj-job-card" data-job-card data-title="Customer Support Associate" data-company="Community Connect" data-visibility="Global Job" data-community="" data-location="Remote" data-posted="01 Oct 2026" data-closing="20 Oct 2026" data-openings="2" data-status="Closed" data-applications="0" data-whatsapp="0" data-email="0" data-description="Support users and respond to service-related questions through digital channels." data-category="Customer Support" data-type="Full Time" data-salary="₹16,000–₹24,000/month">
                <div class="mpj-job-top"><div class="mpj-company-mark global"><i class="fa-solid fa-earth-asia"></i></div><div class="mpj-job-title-wrap"><div class="mpj-badges"><span class="mpj-type-badge global">Global Job</span></div><h3>Customer Support Associate</h3><p class="mpj-company-name">Community Connect</p></div><span class="mpj-status closed"><span></span>Closed</span></div>
                <div class="mpj-job-meta"><span><i class="fa-solid fa-location-dot"></i>Remote</span><span><i class="fa-regular fa-calendar"></i>Posted 01 Oct 2026</span><span><i class="fa-regular fa-calendar-xmark"></i>Closes 20 Oct 2026</span><span><i class="fa-solid fa-user-plus"></i>2 openings</span></div>
                <div class="mpj-application-stats"><div><span class="mpj-mini-icon blue"><i class="fa-solid fa-users"></i></span><span><small>Applications Received</small><strong>0</strong></span></div><div><span class="mpj-mini-icon green"><i class="fa-brands fa-whatsapp"></i></span><span><small>WhatsApp Enquiries</small><strong>0</strong></span></div><div><span class="mpj-mini-icon orange"><i class="fa-regular fa-envelope"></i></span><span><small>Email Applications</small><strong>0</strong></span></div></div>
                <div class="mpj-card-actions"><button type="button" class="mpj-btn small outline" data-view-job><i class="fa-regular fa-eye"></i> View</button><a class="mpj-btn small outline" href="post-a-job.html"><i class="fa-regular fa-pen-to-square"></i> Edit</a><button class="mpj-btn small soft" type="button" data-demo-action="Reopen job"><i class="fa-solid fa-rotate-right"></i> Reopen</button><button class="mpj-btn small package" type="button" data-demo-action="Renew / Extend Package"><i class="fa-solid fa-credit-card"></i> Renew / Extend Package</button><button class="mpj-icon-btn" type="button" data-demo-action="Delete job" aria-label="Delete job" title="Delete job"><i class="fa-regular fa-trash-can"></i></button></div>
            </article>
        </div>
        <div class="mpj-demo-note"><i class="fa-solid fa-circle-info"></i><p><strong>Static HTML demo:</strong> These are sample job listings. Search, filtering and job actions require JavaScript or backend integration.</p></div>
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
<script src="my-posted-jobs.js"></script>
<script src="js/jobs-global.js"></script>
</body>
</html>