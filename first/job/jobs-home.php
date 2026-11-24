<?php
// Jobs Home (live: latest approved jobs from the jobs backend; filters on this page work on these jobs)
require_once dirname(__DIR__) . '/_web.php';
$_REQUEST['per'] = 24; $_REQUEST['page'] = 1;
$latest = pl_jobs_list(web_ctx(), ['sort' => 'latest']);
$homeJobs = array_map('web_job_card', $latest['items']);
$catSlug = ['it-software' => 'it', 'sales-marketing' => 'sales', 'banking-finance' => 'finance', 'healthcare' => 'healthcare', 'education' => 'education',
    'engineering' => 'engineering', 'administration' => 'administration', 'hr' => 'hr', 'hospitality' => 'hospitality', 'government' => 'government',
    'work-from-home' => 'remote', 'internship' => 'internship'];
$catById = [];
foreach (pl_categories('jobs') as $c) $catById[(int)$c['id']] = $catSlug[$c['slug'] ?? ''] ?? 'other';
$expBucket = fn($e) => ['fresher' => 'fresher', '0-1 years' => '0-2', '1-3 years' => '0-2', '3-5 years' => '2-5', '5-10 years' => '5+', '10+ years' => '5+'][strtolower(trim((string)$e))] ?? '';
$logoColors = ['plj-logo-blue', 'plj-logo-green', 'plj-logo-orange', 'plj-logo-purple'];
?>
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
        href="jobs-home.css"
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

<main class="pl-jobs-page">

    <!-- Hero Section -->
    <section class="plj-hero">
        <div class="plj-container plj-hero-grid">
            <div class="plj-hero-content">
                <span class="plj-eyebrow">
                    <i class="bi bi-briefcase-fill"></i>
                    PEOPLELINK CAREER NETWORK
                </span>

                <h1>Find the Right <span>Opportunity</span></h1>

                <p>
                    Explore job opportunities within your community or
                    discover career possibilities across all PeopleLink communities.
                </p>

                <div class="plj-hero-actions">
                    <a href="#plj-search" class="plj-btn plj-btn-primary">
                        <i class="bi bi-search"></i> Explore Jobs
                    </a>
                    <a href="post-a-job.php" class="plj-btn plj-btn-outline">
                        <i class="bi bi-plus-circle"></i> Post a Job
                    </a>
                </div>

                <div class="plj-hero-points">
                    <span><i class="bi bi-check-circle-fill"></i> Community Opportunities</span>
                    <span><i class="bi bi-check-circle-fill"></i> Global Career Network</span>
                </div>
            </div>

            <div class="plj-hero-visual">
                <div class="plj-hero-visual-icon">
                    <i class="bi bi-person-workspace"></i>
                </div>
                <span class="plj-visual-label">YOUR NEXT CHAPTER STARTS HERE</span>
                <h2>Discover. Connect. Grow.</h2>
                <p>Find opportunities that match your skills and ambitions.</p>

                <div class="plj-float-card plj-float-one">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span><strong>Career Growth</strong><small>Explore new possibilities</small></span>
                </div>

                <div class="plj-float-card plj-float-two">
                    <i class="bi bi-globe2"></i>
                    <span><strong>Global Network</strong><small>Connect across communities</small></span>
                </div>
            </div>
        </div>
    </section>

    <!-- Community / Global Jobs -->
    <section class="plj-section">
        <div class="plj-container">
            <div class="plj-heading">
                <span class="plj-kicker">CHOOSE YOUR NETWORK</span>
                <h2>Explore Job Opportunities</h2>
                <p>Choose the job network that works for you.</p>
            </div>

            <div class="plj-type-grid">
                <button type="button" class="plj-type-card active"
                        data-job-scope="community" aria-pressed="true">
                    <span class="plj-type-icon plj-blue-icon">
                        <i class="bi bi-people-fill"></i>
                    </span>
                    <span class="plj-type-content">
                        <strong>Community Jobs</strong>
                        <small>Jobs posted specifically for members of your selected community.</small>
                        <span class="plj-type-link">Explore Community Jobs <i class="bi bi-arrow-right"></i></span>
                    </span>
                    <i class="bi bi-check-circle-fill plj-type-check"></i>
                </button>

                <button type="button" class="plj-type-card"
                        data-job-scope="global" aria-pressed="false">
                    <span class="plj-type-icon plj-green-icon">
                        <i class="bi bi-globe-asia-australia"></i>
                    </span>
                    <span class="plj-type-content">
                        <strong>Global Jobs</strong>
                        <small>Jobs available to users across all PeopleLink communities.</small>
                        <span class="plj-type-link">Explore Global Jobs <i class="bi bi-arrow-right"></i></span>
                    </span>
                    <i class="bi bi-check-circle-fill plj-type-check"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Search Jobs -->
    <section class="plj-search-section" id="plj-search">
        <div class="plj-container">
            <div class="plj-search-panel">
                <div class="plj-heading">
                    <span class="plj-kicker">YOUR NEXT OPPORTUNITY</span>
                    <h2>Search Jobs</h2>
                    <p>Find roles based on your skills, experience and location.</p>
                </div>

                <form id="pljSearchForm" class="plj-search-form">
                    <div class="plj-field">
                        <label for="pljKeyword">Job Title or Skills</label>
                        <div class="plj-input-wrap">
                            <i class="bi bi-search"></i>
                            <input type="text" id="pljKeyword"
                                   placeholder="e.g. PHP Developer">
                        </div>
                    </div>

                    <div class="plj-field">
                        <label for="pljCompany">Company</label>
                        <div class="plj-input-wrap">
                            <i class="bi bi-building"></i>
                            <input type="text" id="pljCompany"
                                   placeholder="Company name">
                        </div>
                    </div>

                    <div class="plj-field">
                        <label for="pljLocation">Location</label>
                        <div class="plj-input-wrap">
                            <i class="bi bi-geo-alt"></i>
                            <input type="text" id="pljLocation"
                                   placeholder="City or remote">
                        </div>
                    </div>

                    <div class="plj-field">
                        <label for="pljExperience">Experience</label>
                        <select id="pljExperience">
                            <option value="">Any Experience</option>
                            <option value="fresher">Fresher</option>
                            <option value="0-2">0–2 Years</option>
                            <option value="2-5">2–5 Years</option>
                            <option value="5+">5+ Years</option>
                        </select>
                    </div>

                    <div class="plj-field">
                        <label for="pljCategory">Job Category</label>
                        <select id="pljCategory">
                            <option value="">All Categories</option>
                            <option value="it">IT & Software</option>
                            <option value="sales">Sales & Marketing</option>
                            <option value="finance">Banking & Finance</option>
                            <option value="healthcare">Healthcare</option>
                            <option value="education">Education</option>
                            <option value="engineering">Engineering</option>
                            <option value="administration">Administration</option>
                            <option value="hr">HR</option>
                            <option value="hospitality">Hospitality</option>
                            <option value="government">Government Jobs</option>
                            <option value="remote">Work From Home</option>
                            <option value="internship">Internships</option>
                            <option value="other">Other Jobs</option>
                        </select>
                    </div>

                    <div class="plj-search-actions">
                        <button type="submit" class="plj-btn plj-btn-primary">
                            <i class="bi bi-search"></i> Search Jobs
                        </button>
                        <button type="reset" class="plj-reset-btn">Clear Filters</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Latest Jobs -->
    <section class="plj-section" id="plj-latest">
        <div class="plj-container">
            <div class="plj-heading plj-heading-row">
                <div>
                    <span class="plj-kicker">NEW OPPORTUNITIES</span>
                    <h2>Latest Jobs</h2>
                    <p>Explore recently listed career opportunities.</p>
                </div>
                <span class="plj-count" id="pljResultCount">6 opportunities</span>
            </div>

            <div class="plj-listing-label">
                <span id="pljScopeLabel"><i class="bi bi-people-fill"></i> Community Jobs</span>
                <small>Newest approved jobs</small>
            </div>

            <div class="plj-job-grid" id="pljJobGrid">

            <?php foreach ($homeJobs as $i => $j): $g = $j['scope'] === 'global';
                $ini = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice(preg_split('/\s+/', trim($j['company'])), 0, 2)))); ?>
            <article class="plj-job-card" data-scope="<?= $g ? 'global' : 'community' ?>" data-id="<?= (int)$j['id'] ?>" data-title="<?= h($j['title']) ?>" data-company="<?= h($j['company']) ?>"
                     data-location="<?= h($j['location']) ?>" data-experience="<?= h($expBucket($j['experience'])) ?>" data-category="<?= h($catById[(int)$j['category_id']] ?? 'other') ?>"
                     data-skills="<?= h(strtolower((string)$j['required_skills'])) ?>" data-qualification="<?= h($j['qualification']) ?>" data-salary="<?= h($j['salary_text'] ?: 'Not disclosed') ?>" data-date="<?= h(web_ago($j['created_at'])) ?>">
                <div class="plj-job-top">
                    <span class="plj-company-logo <?= $logoColors[$i % 4] ?>"><?= h($ini ?: 'J') ?></span>
                    <button type="button" class="plj-save-btn<?= !empty($j['saved']) ? ' is-saved' : '' ?>" data-job-id="<?= (int)$j['id'] ?>" aria-label="Save <?= h($j['title']) ?> job" aria-pressed="<?= !empty($j['saved']) ? 'true' : 'false' ?>"><i class="bi <?= !empty($j['saved']) ? 'bi-bookmark-fill' : 'bi-bookmark' ?>"></i></button>
                </div>
                <span class="plj-job-tag <?= $g ? 'plj-global-tag' : 'plj-community-tag' ?>"><?= $g ? 'Global Job' : 'Community Job' ?></span>
                <h3><?= h($j['title']) ?></h3>
                <p class="plj-company"><i class="bi bi-building"></i> <?= h($j['company']) ?></p>
                <div class="plj-job-meta">
                    <span><i class="bi bi-geo-alt"></i> <?= h($j['location']) ?></span>
                    <span><i class="bi bi-briefcase"></i> <?= h($j['experience'] ?: 'Any experience') ?></span>
                    <?php if ($j['qualification']): ?><span><i class="bi bi-mortarboard"></i> <?= h($j['qualification']) ?></span><?php endif; ?>
                </div>
                <div class="plj-salary"><strong><?= h($j['salary_text'] ?: 'Not disclosed') ?></strong><small><?= h($j['job_type']) ?></small></div>
                <div class="plj-job-footer">
                    <small><i class="bi bi-clock"></i> <?= h(web_ago($j['created_at'])) ?></small>
                    <a class="plj-view-btn" href="job-details.php?id=<?= (int)$j['id'] ?>">View Details <i class="bi bi-arrow-up-right"></i></a>
                </div>
            </article>
            <?php endforeach; ?>

                <div class="plj-empty" id="pljEmpty" hidden>
                    <i class="bi bi-search"></i>
                    <h3>No matching jobs found</h3>
                    <p>Try changing your search terms or filters.</p>
                    <button type="button" class="plj-btn plj-btn-primary" id="pljEmptyReset">
                        Clear Filters
                    </button>
                </div>
            </div>

            <div class="plj-center-action">
                <button type="button" id="pljViewAll" class="plj-btn plj-btn-light">
                    View All Jobs <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Browse by Category -->
    <section class="plj-category-section">
        <div class="plj-container">
            <div class="plj-heading">
                <span class="plj-kicker">EXPLORE CAREER PATHS</span>
                <h2>Browse by Category</h2>
                <p>Explore opportunities across popular professional fields.</p>
            </div>

            <div class="plj-category-grid">
                <button type="button" class="plj-category-card" data-category="it">
                    <span class="plj-category-icon cat-blue"><i class="bi bi-code-slash"></i></span>
                    <strong>IT & Software</strong><small>Technology careers</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
                <button type="button" class="plj-category-card" data-category="sales">
                    <span class="plj-category-icon cat-orange"><i class="bi bi-megaphone"></i></span>
                    <strong>Sales & Marketing</strong><small>Grow brands and revenue</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
                <button type="button" class="plj-category-card" data-category="finance">
                    <span class="plj-category-icon cat-green"><i class="bi bi-cash-stack"></i></span>
                    <strong>Banking & Finance</strong><small>Finance opportunities</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
                <button type="button" class="plj-category-card" data-category="healthcare">
                    <span class="plj-category-icon cat-red"><i class="bi bi-heart-pulse"></i></span>
                    <strong>Healthcare</strong><small>Care and medical roles</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
                <button type="button" class="plj-category-card" data-category="education">
                    <span class="plj-category-icon cat-purple"><i class="bi bi-mortarboard"></i></span>
                    <strong>Education</strong><small>Teaching and training</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
                <button type="button" class="plj-category-card" data-category="engineering">
                    <span class="plj-category-icon cat-teal"><i class="bi bi-gear"></i></span>
                    <strong>Engineering</strong><small>Technical careers</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
                <button type="button" class="plj-category-card" data-category="administration">
                    <span class="plj-category-icon cat-blue"><i class="bi bi-clipboard-check"></i></span>
                    <strong>Administration</strong><small>Office and operations</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
                <button type="button" class="plj-category-card" data-category="hr">
                    <span class="plj-category-icon cat-orange"><i class="bi bi-people"></i></span>
                    <strong>HR</strong><small>People and recruitment</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
                <button type="button" class="plj-category-card" data-category="hospitality">
                    <span class="plj-category-icon cat-green"><i class="bi bi-cup-hot"></i></span>
                    <strong>Hospitality</strong><small>Service and tourism</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
                <button type="button" class="plj-category-card" data-category="government">
                    <span class="plj-category-icon cat-red"><i class="bi bi-bank"></i></span>
                    <strong>Government Jobs</strong><small>Public sector roles</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
                <button type="button" class="plj-category-card" data-category="remote">
                    <span class="plj-category-icon cat-purple"><i class="bi bi-house-laptop"></i></span>
                    <strong>Work From Home</strong><small>Remote opportunities</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
                <button type="button" class="plj-category-card" data-category="internship">
                    <span class="plj-category-icon cat-teal"><i class="bi bi-lightning-charge"></i></span>
                    <strong>Internships</strong><small>Start your career</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
                <button type="button" class="plj-category-card" data-category="other">
                    <span class="plj-category-icon cat-blue"><i class="bi bi-grid"></i></span>
                    <strong>Other Jobs</strong><small>Explore more roles</small>
                    <i class="bi bi-arrow-up-right plj-category-arrow"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Recommended Jobs -->
    <section class="plj-recommended-section">
        <div class="plj-container">
            <div class="plj-recommended">
                <div class="plj-recommended-content">
                    <span class="plj-kicker">YOUR NEXT CAREER MOVE</span>
                    <h2>Find Opportunities That Match Your Potential</h2>
                    <p>
                        Discover relevant jobs based on your skills, experience,
                        profession, location and selected community.
                    </p>
                    <button type="button" class="plj-btn plj-btn-primary" id="pljRecommended">
                        <i class="bi bi-stars"></i> View Recommended Jobs
                    </button>
                </div>
                <div class="plj-recommended-visual">
                    <div class="plj-recommend-circle"></div>
                    <div class="plj-recommend-center"><i class="bi bi-person-check-fill"></i></div>
                    <span class="plj-chip plj-chip-one"><i class="bi bi-check-circle-fill"></i> Skills</span>
                    <span class="plj-chip plj-chip-two"><i class="bi bi-check-circle-fill"></i> Experience</span>
                    <span class="plj-chip plj-chip-three"><i class="bi bi-check-circle-fill"></i> Location</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Access -->
    <section class="plj-section plj-quick-section">
        <div class="plj-container">
            <div class="plj-heading">
                <span class="plj-kicker">YOUR JOB ACTIVITY</span>
                <h2>Quick Access</h2>
                <p>Manage your job search from one convenient place.</p>
            </div>

            <div class="plj-quick-grid">
                <a href="saved-jobs.php" class="plj-quick-card">
                    <span class="plj-quick-icon plj-blue-icon"><i class="bi bi-bookmark-heart"></i></span>
                    <span><strong>Saved Jobs</strong><small>Revisit bookmarked opportunities.</small></span>
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="my-applications.php" class="plj-quick-card">
                    <span class="plj-quick-icon plj-green-icon"><i class="bi bi-file-earmark-person"></i></span>
                    <span><strong>My Applications</strong><small>Track your submitted applications.</small></span>
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="my-posted-jobs.php" class="plj-quick-card">
                    <span class="plj-quick-icon plj-orange-icon"><i class="bi bi-briefcase"></i></span>
                    <span><strong>My Posted Jobs</strong><small>Manage your job listings.</small></span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Post a Job -->
    <section class="plj-post-section" id="plj-post-job">
        <div class="plj-container">
            <div class="plj-post-panel">
                <div class="plj-post-icon"><i class="bi bi-person-workspace"></i></div>
                <div class="plj-post-content">
                    <span class="plj-kicker">FOR EMPLOYERS & ORGANISATIONS</span>
                    <h2>Find the Right Talent for Your Team</h2>
                    <p>Publish opportunities and connect with suitable candidates.</p>
                    <div class="plj-post-options">
                        <span><i class="bi bi-people-fill"></i> Community Job</span>
                        <span><i class="bi bi-globe2"></i> Global Job</span>
                    </div>
                </div>
                <a href="post-a-job.php" class="plj-btn plj-btn-primary">
                    <i class="bi bi-plus-lg"></i> Post a Job
                </a>
            </div>
        </div>
    </section>

    <!-- Global Job Packages -->
    <section class="plj-packages-section">
        <div class="plj-container">
            <div class="plj-packages-panel">
                <div class="plj-package-icon"><i class="bi bi-globe2"></i></div>
                <div class="plj-package-content">
                    <span class="plj-kicker">REACH MORE CANDIDATES</span>
                    <h2>Promote Your Job Across Communities</h2>
                    <p>
                        Explore Global Job packages for broader visibility across
                        PeopleLink communities, subject to applicable posting rules.
                    </p>
                </div>
                <a href="global-job-packages.php" class="plj-btn plj-btn-light">
                    View Global Job Packages <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Job Details Modal -->
    <div class="plj-modal" id="pljJobModal" aria-hidden="true">
        <div class="plj-modal-backdrop" data-close-modal></div>
        <div class="plj-modal-dialog" role="dialog" aria-modal="true"
             aria-labelledby="pljModalTitle">
            <button type="button" class="plj-modal-close"
                    data-close-modal aria-label="Close job details">
                <i class="bi bi-x-lg"></i>
            </button>

            <span class="plj-job-tag plj-global-tag" id="pljModalTag">Job Listing</span>
            <h2 id="pljModalTitle">Job Title</h2>
            <p id="pljModalCompany" class="plj-company"></p>
            <div class="plj-modal-meta" id="pljModalMeta"></div>
            <div class="plj-modal-divider"></div>
            <h3>Job Overview</h3>
            <p id="pljModalOverview"></p>
            <h3>Qualification</h3>
            <p id="pljModalQualification"></p>
            <div class="plj-modal-salary" id="pljModalSalary"></div>
            <p class="plj-modal-note">
                These are sample listings for the frontend preview.
            </p>
            <a href="job-details.php" class="plj-btn plj-btn-primary" id="pljModalContinue">
                Continue to Job Details <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="plj-toast" id="pljToast" role="status" aria-live="polite"></div>

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
<?= web_js_boot() ?><script src="jobs-home.js?v=2"></script>
<script src="js/jobs-global.js"></script>
</body>
</html>
