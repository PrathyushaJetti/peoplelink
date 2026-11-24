<?php
// Community Home: the selected community's landing page (real data, links into every module).
require_once dirname(__DIR__) . '/matrimoney/includes/bridge.php';
pl_ensure_schema();
$chUser = current_user();
$chComm = pl_resolve_community($chUser ? (int)$chUser['id'] : null);
if (!$chComm) { header('Location: community-page.php?next=' . urlencode('/peoplelink/first/community-home.php')); exit; } // no community chosen yet: pick one first
$chCid = (int)$chComm['id']; $chSlug = $chComm['slug']; $chName = $chComm['name'];
$chQ = '?c=' . urlencode($chSlug);
$chIntro = pl_paras($chComm['intro'] ?? '') ?: pl_paras($chComm['about'] ?? '');
$chE = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
$U = [
    'about' => 'community-page.php' . $chQ, 'matrimony' => '/peoplelink/module-4/Frontend/pages/index.php' . $chQ,
    'family' => 'family-tree.php' . $chQ, 'jobs' => 'job/jobs-home.php' . $chQ, 'directory' => 'professional-and-business-directory.php' . $chQ,
    'marketplace' => 'marketplace/marketplace-home.php' . $chQ, 'events' => 'events-ads.php' . $chQ, 'support' => 'community/community-support.php' . $chQ,
    'leaders' => 'community-leadership.php' . $chQ, 'register' => '/peoplelink/matrimoney/signup.php?next=' . urlencode('/peoplelink/first/community-home.php' . $chQ),
    'profile' => $chUser ? 'profile/edit-profile.php' : '/peoplelink/matrimoney/login.php?next=' . urlencode('/peoplelink/first/profile/edit-profile.php'),
    'family_reg' => 'm-f-registration/member-family-registration.php' . $chQ,
];
$U['join'] = $chUser ? $U['family_reg'] : $U['register'];
$chSafe = function (string $sql, array $a) { try { return rows($sql, $a); } catch (Throwable $e) { return []; } };
// latest approved jobs of this community (and jobs shared with every community)
$chJobs = $chSafe("SELECT id, job_title, company_name, location, city, experience, employment_type FROM jobs WHERE status='approved' AND is_active=1 AND (community_id=? OR community_id IS NULL) AND (closing_date IS NULL OR closing_date >= CURDATE()) ORDER BY is_featured DESC, id DESC LIMIT 4", [$chCid]);
// updates: community announcements, upcoming events, newest jobs - newest first
$chUpdates = [];
foreach ($chSafe("SELECT title, message, created_at FROM user_notifications WHERE user_id IS NULL AND community_id=? ORDER BY id DESC LIMIT 3", [$chCid]) as $n)
    $chUpdates[] = ['tag' => 'ANNOUNCEMENT', 'date' => $n['created_at'], 'title' => $n['title'], 'text' => $n['message'], 'url' => $U['events'], 'img' => '/peoplelink/first/images/in/community-1.jpg'];
foreach ($chSafe("SELECT id, title, description, event_date FROM events WHERE status='approved' AND is_active=1 AND community_id=? AND event_date >= CURDATE() ORDER BY event_date LIMIT 3", [$chCid]) as $ev)
    $chUpdates[] = ['tag' => 'EVENT', 'date' => $ev['event_date'], 'title' => $ev['title'], 'text' => $ev['description'], 'url' => 'event-details.php?id=' . (int)$ev['id'], 'img' => '/peoplelink/first/images/in/community-2.jpg'];
foreach (array_slice($chJobs, 0, 3) as $j)
    $chUpdates[] = ['tag' => 'NEW JOB', 'date' => null, 'title' => $j['job_title'] . ' at ' . $j['company_name'], 'text' => 'A new job was shared in the ' . $chName . ' community.', 'url' => 'job/job-details.php?id=' . (int)$j['id'], 'img' => '/peoplelink/first/images/in/community-3.jpg'];
$chUpdates = array_slice($chUpdates, 0, 3);
$chMembers = (int)($chSafe("SELECT COUNT(*) n FROM users WHERE community_id=?", [$chCid])[0]['n'] ?? 0);
$pageTitle = $chName . ' Community Home | PeopleLink';
include('header.php');
?>

 <!-- ==========================================================
     PEOPLELINK COMMUNITY HOME
     PREMIUM VISUAL DESIGN
     HTML
========================================================== -->

<div class="peoplelink-community">

    <!-- ======================================================
         HERO
    ======================================================= -->

    <section class="pl-hero">

        <div class="pl-hero-bg-circle circle-1"></div>
        <div class="pl-hero-bg-circle circle-2"></div>
        <div class="pl-hero-bg-circle circle-3"></div>

        <div class="pl-container">

            <div class="pl-hero-layout">

                <div class="pl-hero-text">

                    <div class="pl-small-label">
                        <span></span>
                        <?= $chE(strtoupper($chName)) ?> COMMUNITY
                    </div>

                    <h1>
                        One Community.
                        <strong>Many Connections.</strong>
                    </h1>

                    <p>
                        Stay connected with your people, discover opportunities,
                        find trusted professionals, participate in events and
                        build meaningful relationships through PeopleLink.
                    </p>

                    <div class="pl-hero-actions">

                        <a href="<?= $chE($U['join']) ?>" class="pl-main-button">
                            <?= $chUser ? 'Register Your Family' : 'Join Your Community' ?>
                            <i class="bi bi-arrow-up-right"></i>
                        </a>

                        <a href="<?= $chE($U['about']) ?>" class="pl-second-button">
                            <i class="bi bi-play-circle"></i>
                            About Our Community
                        </a>

                    </div>

                    <div class="pl-hero-trust">

                        <div class="pl-avatar-group">

                            <img src="/peoplelink/first/images/in/man-1.jpg">
                            <img src="/peoplelink/first/images/in/woman-1.jpg">
                            <img src="/peoplelink/first/images/in/woman-2.jpg">
                            <img src="/peoplelink/first/images/in/man-2.jpg">

                            <span>+</span>

                        </div>

                        <div>

                            <strong><?= $chMembers ? number_format($chMembers) . ' Members' : 'Community Connections' ?></strong>

                            <small>
                                People bringing people together
                            </small>

                        </div>

                    </div>

                </div>


                <!-- HERO VISUAL -->

                <div class="pl-hero-visual">

                    <div class="pl-orbit orbit-one"></div>
                    <div class="pl-orbit orbit-two"></div>

                    <div class="pl-hero-main-card">

                        <div class="pl-hero-card-top">

                            <div>

                                <span>YOUR COMMUNITY</span>

                                <h3>Connected Together</h3>

                            </div>

                            <div class="pl-online-dot"></div>

                        </div>


                        <div class="pl-people-visual">

                            <div class="pl-person person-one">
                                <img src="/peoplelink/first/images/in/man-1.jpg">
                            </div>

                            <div class="pl-person person-two">
                                <img src="/peoplelink/first/images/in/woman-1.jpg">
                            </div>

                            <div class="pl-person person-three">
                                <img src="/peoplelink/first/images/in/woman-2.jpg">
                            </div>

                            <div class="pl-person person-four">
                                <img src="/peoplelink/first/images/in/man-2.jpg">
                            </div>

                            <div class="pl-person person-five">
                                <img src="/peoplelink/first/images/in/woman-3.jpg">
                            </div>

                        </div>


                        <div class="pl-connect-line">

                            <span></span>
                            <span></span>
                            <span></span>

                        </div>


                        <div class="pl-community-stat">

                            <div>

                                <strong>Connect</strong>

                                <small>
                                    Discover your community
                                </small>

                            </div>

                            <i class="bi bi-arrow-right"></i>

                        </div>

                    </div>


                    <div class="pl-floating-card floating-one">

                        <div class="floating-icon green">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>

                        <div>
                            <strong>Jobs</strong>
                            <small>New opportunities</small>
                        </div>

                    </div>


                    <div class="pl-floating-card floating-two">

                        <div class="floating-icon orange">
                            <i class="bi bi-calendar-event-fill"></i>
                        </div>

                        <div>
                            <strong>Events</strong>
                            <small>Coming soon</small>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ======================================================
         QUICK COMMUNITY NAVIGATION
    ======================================================= -->

    <section class="pl-quick-section">

        <div class="pl-container">

            <div class="pl-quick-wrapper">

                <a href="#matrimony" class="pl-quick-item">

                    <div class="quick-icon red">
                        <i class="bi bi-heart-fill"></i>
                    </div>

                    <span>Matrimony</span>

                </a>


                <a href="#family" class="pl-quick-item">

                    <div class="quick-icon green">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>

                    <span>Family Tree</span>

                </a>


                <a href="#jobs" class="pl-quick-item">

                    <div class="quick-icon blue">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>

                    <span>Jobs</span>

                </a>


                <a href="#professionals" class="pl-quick-item">

                    <div class="quick-icon purple">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>

                    <span>Professionals</span>

                </a>


                <a href="#marketplace" class="pl-quick-item">

                    <div class="quick-icon orange">
                        <i class="bi bi-shop-window"></i>
                    </div>

                    <span>Marketplace</span>

                </a>


                <a href="#events" class="pl-quick-item">

                    <div class="quick-icon pink">
                        <i class="bi bi-calendar-heart-fill"></i>
                    </div>

                    <span>Events</span>

                </a>


                <a href="#support" class="pl-quick-item">

                    <div class="quick-icon teal">
                        <i class="bi bi-life-preserver"></i>
                    </div>

                    <span>Support</span>

                </a>

            </div>

        </div>

    </section>


    <!-- ======================================================
         INTRO / COMMUNITY PURPOSE
    ======================================================= -->

    <section class="pl-intro-section">

        <div class="pl-container">

            <div class="pl-intro-grid">

                <div class="pl-intro-title">

                    <span class="pl-section-number">
                        01
                    </span>

                    <h2>
                        Everything your
                        <span>community</span>
                        needs.
                    </h2>

                </div>


                <div class="pl-intro-text">

                    <?php foreach (array_slice($chIntro ?: ['PeopleLink brings community members, families, professionals, businesses and opportunities together in one connected digital ecosystem.'], 0, 2) as $para): ?>
                        <p><?= $chE($para) ?></p>
                    <?php endforeach; ?>

                    <a href="<?= $chE($U['about']) ?>">
                        Read About <?= $chE($chName) ?>
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

        </div>

    </section>


    <!-- ======================================================
         COMMUNITY SERVICES VISUAL GRID
    ======================================================= -->

    <section class="pl-services-section">

        <div class="pl-container">

            <div class="pl-service-grid">


                <!-- MATRIMONY -->

                <div
                    class="pl-service-large service-matrimony"
                    id="matrimony"
                >

                    <div class="service-image">

                        <img
                            src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1000&q=85"
                            alt="Matrimony"
                        >

                    </div>

                    <div class="service-overlay"></div>

                    <div class="service-content">

                        <div class="service-icon">
                            <i class="bi bi-heart-fill"></i>
                        </div>

                        <span>CONNECTIONS</span>

                        <h3>
                            Matrimony
                        </h3>

                        <p>
                            Discover suitable profiles and
                            meaningful connections within your community.
                        </p>

                        <a href="<?= $chE($U['matrimony']) ?>">
                            Explore Matrimony
                            <i class="bi bi-arrow-up-right"></i>
                        </a>

                    </div>

                </div>


                <!-- FAMILY -->

                <div
                    class="pl-service-card service-family"
                    id="family"
                >

                    <div class="service-card-icon green">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>

                    <span>YOUR ROOTS</span>

                    <h3>
                        Build Your
                        Family Tree
                    </h3>

                    <p>
                        Connect generations and preserve
                        your family's digital story.
                    </p>

                    <a href="<?= $chE($U['family']) ?>">
                        Create Family Tree
                        <i class="bi bi-arrow-right"></i>
                    </a>

                    <div class="service-pattern">
                        <i class="bi bi-diagram-3"></i>
                    </div>

                </div>


                <!-- JOBS -->

                <div
                    class="pl-service-card service-jobs"
                    id="jobs"
                >

                    <div class="service-card-icon blue">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>

                    <span>CAREER</span>

                    <h3>
                        Community
                        Jobs
                    </h3>

                    <p>
                        Discover opportunities shared by
                        people and businesses in your network.
                    </p>

                    <a href="<?= $chE($U['jobs']) ?>">
                        Explore Jobs
                        <i class="bi bi-arrow-right"></i>
                    </a>

                    <div class="service-pattern">
                        <i class="bi bi-briefcase"></i>
                    </div>

                </div>


                <!-- PROFESSIONALS -->

                <div
                    class="pl-service-wide service-professionals"
                    id="professionals"
                >

                    <div class="professional-visual">

                        <div class="professional-circle circle-a">
                            <i class="bi bi-heart-pulse-fill"></i>
                        </div>

                        <div class="professional-circle circle-b">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>

                        <div class="professional-circle circle-c">
                            <i class="bi bi-calculator-fill"></i>
                        </div>

                        <div class="professional-circle circle-d">
                            <i class="bi bi-cpu-fill"></i>
                        </div>

                    </div>

                    <div class="professional-content">

                        <span>TRUSTED NETWORK</span>

                        <h3>
                            Professionals &
                            Businesses
                        </h3>

                        <p>
                            Find doctors, lawyers, CAs, engineers,
                            consultants, service providers and
                            community businesses.
                        </p>

                        <a href="<?= $chE($U['directory']) ?>">
                            Explore Directory
                            <i class="bi bi-arrow-up-right"></i>
                        </a>

                    </div>

                </div>


                <!-- MARKETPLACE -->

                <div
                    class="pl-service-wide service-marketplace"
                    id="marketplace"
                >

                    <div class="marketplace-content">

                        <span>COMMUNITY MARKETPLACE</span>

                        <h3>
                            Buy, Sell &
                            Discover
                        </h3>

                        <p>
                            Properties, vehicles, electronics,
                            furniture, machinery and more.
                        </p>

                        <a href="<?= $chE($U['marketplace']) ?>">
                            Explore Marketplace
                            <i class="bi bi-arrow-up-right"></i>
                        </a>

                    </div>

                    <div class="marketplace-icons">

                        <div>
                            <i class="bi bi-house-fill"></i>
                        </div>

                        <div>
                            <i class="bi bi-car-front-fill"></i>
                        </div>

                        <div>
                            <i class="bi bi-phone-fill"></i>
                        </div>

                        <div>
                            <i class="bi bi-gear-fill"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ======================================================
         COMMUNITY UPDATES
    ======================================================= -->

    <section class="pl-updates-section">

        <div class="pl-container">

            <div class="pl-section-header-row">

                <div>

                    <span class="pl-section-number">
                        02
                    </span>

                    <h2>
                        What's happening
                        <span>around you?</span>
                    </h2>

                </div>

                <a href="<?= $chE($U['events']) ?>" class="pl-view-all">
                    View All Updates
                    <i class="bi bi-arrow-up-right"></i>
                </a>

            </div>


            <div class="pl-news-slider" id="newsSlider">
                <?php foreach ($chUpdates as $up): ?>
                <article class="pl-news-card">
                    <div class="news-image">
                        <img src="<?= $chE($up['img']) ?>" alt="<?= $chE($up['title']) ?>">
                        <span><?= $chE($up['tag']) ?></span>
                    </div>
                    <div class="news-content">
                        <?php if ($up['date']): ?><small><i class="bi bi-calendar3"></i> <?= $chE(date('d F', strtotime($up['date']))) ?></small><?php endif; ?>
                        <h3><?= $chE($up['title']) ?></h3>
                        <p><?= $chE(mb_strimwidth(trim(preg_replace('/\s+/', ' ', (string)$up['text'])), 0, 110, '...')) ?></p>
                        <a href="<?= $chE($up['url']) ?>">Read Update <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>
                <?php endforeach; ?>
                <?php if (!$chUpdates): ?>
                <article class="pl-news-card">
                    <div class="news-image"><img src="/peoplelink/first/images/in/community-1.jpg" alt="<?= $chE($chName) ?> community"><span>COMMUNITY</span></div>
                    <div class="news-content">
                        <h3>No updates yet</h3>
                        <p>Announcements, events and new jobs of the <?= $chE($chName) ?> community will appear here.</p>
                        <a href="<?= $chE($U['events']) ?>">See Events <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>
                <?php endif; ?>

            </div>

        </div>

    </section>


    <!-- ======================================================
         JOBS SECTION
    ======================================================= -->

    <section class="pl-jobs-section" id="community-jobs">

        <div class="pl-container">

            <div class="pl-jobs-layout">

                <div class="pl-jobs-intro">

                    <span class="pl-section-number">
                        03
                    </span>

                    <span class="pl-section-tag">
                        CAREER NETWORK
                    </span>

                    <h2>
                        Opportunities
                        <strong>within your network.</strong>
                    </h2>

                    <p>
                        Find jobs shared by businesses,
                        professionals and members of your community.
                    </p>

                    <a href="<?= $chE($U['jobs']) ?>" class="pl-main-button">
                        View Community Jobs
                        <i class="bi bi-arrow-up-right"></i>
                    </a>

                </div>


                <div class="pl-job-list">
                    <?php $chIcons = [['bi-briefcase', ''], ['bi-graph-up-arrow', 'green'], ['bi-code-slash', ''], ['bi-people', 'green']]; ?>
                    <?php foreach ($chJobs as $i => $j): [$ic, $col] = $chIcons[$i % 4]; ?>
                    <div class="pl-job-item">
                        <div class="job-company-icon <?= $col ?>"><i class="bi <?= $ic ?>"></i></div>
                        <div class="job-details">
                            <h3><?= $chE($j['job_title']) ?></h3>
                            <p><?= $chE($j['company_name']) ?></p>
                            <div class="job-tags">
                                <?php foreach (array_filter([$j['city'] ?: $j['location'], $j['experience'], $j['employment_type']]) as $t): ?><span><?= $chE($t) ?></span><?php endforeach; ?>
                            </div>
                        </div>
                        <a href="job/job-details.php?id=<?= (int)$j['id'] ?>" class="job-arrow" aria-label="View <?= $chE($j['job_title']) ?>"><i class="bi bi-arrow-up-right"></i></a>
                    </div>
                    <?php endforeach; ?>
                    <?php if (!$chJobs): ?>
                    <div class="pl-job-item">
                        <div class="job-company-icon"><i class="bi bi-briefcase"></i></div>
                        <div class="job-details"><h3>No jobs posted yet</h3><p>Be the first to share a job with your community.</p></div>
                        <a href="job/post-a-job.php" class="job-arrow" aria-label="Post a job"><i class="bi bi-plus-lg"></i></a>
                    </div>
                    <?php endif; ?>

                </div>

            </div>

        </div>

    </section>


    <!-- ======================================================
         PROFESSIONALS
    ======================================================= -->

    <section class="pl-professionals-section">

        <div class="pl-container">

            <div class="pl-section-heading-left">

                <span class="pl-section-number">
                    04
                </span>

                <span class="pl-section-tag">
                    TRUSTED COMMUNITY
                </span>

                <h2>
                    People you can
                    <strong>connect with.</strong>
                </h2>

                <p>
                    Discover professionals and service providers
                    who are part of your community.
                </p>

            </div>


            <div class="pl-professional-icons">


                <a href="<?= $chE($U['directory'] . '&q=Doctors') ?>" class="pl-professional-item">

                    <div>
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>

                    <span>Doctors</span>

                </a>


                <a href="<?= $chE($U['directory'] . '&q=Lawyers') ?>" class="pl-professional-item">

                    <div>
                        <i class="bi bi-briefcase-fill"></i>
                    </div>

                    <span>Lawyers</span>

                </a>


                <a href="<?= $chE($U['directory'] . '&q=CAs') ?>" class="pl-professional-item">

                    <div>
                        <i class="bi bi-calculator-fill"></i>
                    </div>

                    <span>CAs</span>

                </a>


                <a href="<?= $chE($U['directory'] . '&q=Engineers') ?>" class="pl-professional-item">

                    <div>
                        <i class="bi bi-cpu-fill"></i>
                    </div>

                    <span>Engineers</span>

                </a>


                <a href="<?= $chE($U['directory'] . '&q=Consultants') ?>" class="pl-professional-item">

                    <div>
                        <i class="bi bi-person-lines-fill"></i>
                    </div>

                    <span>Consultants</span>

                </a>


                <a href="<?= $chE($U['directory'] . '&q=Real%20Estate') ?>" class="pl-professional-item">

                    <div>
                        <i class="bi bi-house-check-fill"></i>
                    </div>

                    <span>Real Estate</span>

                </a>

            </div>


            <div class="pl-professional-button">

                <a href="<?= $chE($U['directory']) ?>" class="pl-main-button">
                    Search Professionals
                    <i class="bi bi-arrow-up-right"></i>
                </a>

            </div>

        </div>

    </section>


    <!-- ======================================================
         EVENTS
    ======================================================= -->

    <section class="pl-events-section" id="events">

        <div class="pl-container">

            <div class="pl-events-heading">

                <div>

                    <span class="pl-section-number">
                        05
                    </span>

                    <h2>
                        Be part of
                        <strong>what's happening.</strong>
                    </h2>

                </div>

                <p>
                    Festivals, cultural programs, celebrations,
                    business promotions and community announcements.
                </p>

            </div>


            <div class="pl-events-grid">


                <div class="pl-event-big">

                    <img
                        src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?auto=format&fit=crop&w=1000&q=85"
                        alt="Community celebration"
                    >

                    <div class="pl-event-overlay"></div>

                    <div class="pl-event-text">

                        <span>
                            COMMUNITY EVENTS
                        </span>

                        <h3>
                            Festivals &
                            Celebrations
                        </h3>

                        <a href="<?= $chE($U['events']) ?>">
                            Explore Events
                            <i class="bi bi-arrow-up-right"></i>
                        </a>

                    </div>

                </div>


                <div class="pl-event-small green-event">

                    <div class="event-small-icon">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>

                    <span>
                        BUSINESS
                    </span>

                    <h3>
                        Promotions &
                        Advertisements
                    </h3>

                    <p>
                        Discover businesses,
                        products and services.
                    </p>

                    <a href="<?= $chE($U['events']) ?>">
                        Explore
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>


                <div class="pl-event-small purple-event">

                    <div class="event-small-icon">
                        <i class="bi bi-bell-fill"></i>
                    </div>

                    <span>
                        COMMUNITY
                    </span>

                    <h3>
                        Important
                        Announcements
                    </h3>

                    <p>
                        Stay informed with
                        important community news.
                    </p>

                    <a href="<?= $chE($U['events']) ?>">
                        View Updates
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

        </div>

    </section>


    <!-- ======================================================
         SUPPORT
    ======================================================= -->

    <section class="pl-support-section" id="support">

        <div class="pl-container">

            <div class="pl-support-box">

                <div class="support-icon">
                    <i class="bi bi-heart-pulse-fill"></i>
                </div>

                <div class="support-content">

                    <span>
                        COMMUNITY CARE
                    </span>

                    <h2>
                        Education & Emergency Support
                    </h2>

                    <p>
                        Request or provide assistance for education,
                        medical needs, blood requirements and emergencies.
                    </p>

                </div>

                <a href="<?= $chE($U['support']) ?>">
                    Get Support
                    <i class="bi bi-arrow-up-right"></i>
                </a>

            </div>

        </div>

    </section>


    <!-- ======================================================
         LEADERSHIP + LIVE
    ======================================================= -->

    <section class="pl-leadership-section">

        <div class="pl-container">

            <div class="pl-leadership-grid">


                <div class="pl-leader-card">

                    <div class="leader-image">

                        <img
                            src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=800&q=85"
                            alt="Community leadership"
                        >

                    </div>

                    <div class="leader-content">

                        <span>
                            COMMUNITY NETWORK
                        </span>

                        <h2>
                            Community
                            Leadership
                        </h2>

                        <p>
                            Know your community leaders,
                            representatives and key contributors.
                        </p>

                        <a href="<?= $chE($U['leaders']) ?>">
                            View Leadership Directory
                            <i class="bi bi-arrow-up-right"></i>
                        </a>

                    </div>

                </div>


                <div class="pl-live-card">

                    <div class="live-top">

                        <div class="live-icon">
                            <i class="bi bi-broadcast-pin"></i>
                        </div>

                        <span>
                            LIVE PROGRAMS
                        </span>

                    </div>

                    <h2>
                        Watch approved
                        community programs.
                    </h2>

                    <p>
                        Access approved third-party live-stream
                        links shared by community administration.
                    </p>

                    <a href="<?= $chE($U['events']) ?>">
                        View Live Links
                        <i class="bi bi-arrow-up-right"></i>
                    </a>

                </div>

            </div>

        </div>

    </section>


    <!-- ======================================================
         FINAL CTA
    ======================================================= -->

    <section class="pl-final-section">

        <div class="pl-final-shape shape-left"></div>
        <div class="pl-final-shape shape-right"></div>

        <div class="pl-container">

            <div class="pl-final-content">

                <div class="pl-final-icon">

                    <i class="bi bi-people-fill"></i>

                </div>

                <span>
                    PEOPLELINK COMMUNITY
                </span>

                <h2>
                    Your people.
                    Your opportunities.
                    <strong>Your community.</strong>
                </h2>

                <p>
                    Register your family, connect with professionals,
                    explore opportunities, participate in activities
                    and stay informed.
                </p>

                <div class="pl-final-buttons">

                    <a href="<?= $chE($U['register']) ?>" class="pl-main-button">
                        Create Account
                        <i class="bi bi-arrow-up-right"></i>
                    </a>

                    <a href="<?= $chE($U['profile']) ?>" class="pl-outline-button">
                        Complete Profile
                    </a>

                    <a href="/peoplelink/first/coming-soon.php" class="pl-outline-button">
                        Download App
                    </a>

                </div>

            </div>

        </div>

    </section>

</div>


<?php include('footer.php'); ?>