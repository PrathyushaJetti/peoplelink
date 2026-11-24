<?php
require_once __DIR__ . '/../../matrimoney/config.php';
if (session_status() === PHP_SESSION_NONE) { @session_start(); }
$plLoggedIn = !empty($_SESSION['uid']);
$plUserName = 'My Account';
if ($plLoggedIn) {
    try { $plN = db()->prepare('SELECT name FROM users WHERE id = ?'); $plN->execute([(int)$_SESSION['uid']]); $plUserName = $plN->fetchColumn() ?: 'My Account'; } catch (Throwable $e) {}
}
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
    <!-- =====================================================
         HEADER CSS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="style.css?v=<?= @filemtime(__DIR__ . '/style.css') ?>"
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

                <a href="#contact">
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
                href="/peoplelink/first/index.php"
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
                    href="/peoplelink/first/index.php"
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


                        <a href="/peoplelink/first/community-page.php?c=aryavysya">

                            <i class="fa-solid fa-people-group"></i>

                            Arya Vysya

                        </a>


                        <a href="/peoplelink/first/community-page.php?c=reddy">

                            <i class="fa-solid fa-users"></i>

                            Reddy

                        </a>


                        <a href="/peoplelink/first/community-page.php?c=kamma">

                            <i class="fa-solid fa-people-roof"></i>

                            Kamma

                        </a>


                        <a href="/peoplelink/first/community-page.php?c=kapu">

                            <i class="fa-solid fa-user-group"></i>

                            Kapu

                        </a>


                        <a href="/peoplelink/first/community-page.php?c=banjara">

                            <i class="fa-solid fa-people-arrows"></i>

                            Banjara

                        </a>


                        <a
                            href="/peoplelink/first/community-page.php"
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
                    href="/peoplelink/first/service.php"
                    class="pl-nav-link"
                >
                    Services
                </a>


                <!-- =============================================
                     ABOUT
                ============================================== -->

                <a
                    href="/peoplelink/first/about.php"
                    class="pl-nav-link"
                >
                    About Us
                </a>


                <!-- =============================================
                     EVENTS
                ============================================== -->

                <a
                    href="/peoplelink/first/events-ads.php"
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
                        href="/peoplelink/first/community-page.php"
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
                <?php if ($plLoggedIn): ?>
                <?php $plBellN = 0; if (!empty($_SESSION['uid'])) { try { require_once __DIR__ . '/../../matrimoney/includes/notifications.php'; $plBellN = pl_notif_unread((int)$_SESSION['uid']); } catch (Throwable $plBe) {} } ?>
                <a href="/peoplelink/first/profile/notifications.php" class="pl-login pl-bell" title="Notifications" aria-label="Notifications<?= $plBellN ? ' (' . (int)$plBellN . ' unread)' : '' ?>"><i class="fa-regular fa-bell"></i><?php if ($plBellN): ?><span class="pl-bell-count"><?= $plBellN > 99 ? '99+' : (int)$plBellN ?></span><?php endif; ?></a>
                <style>.pl-bell{position:relative;display:inline-flex;align-items:center;justify-content:center;min-width:38px}.pl-bell i{font-size:19px}.pl-bell-count{position:absolute;top:-4px;right:-2px;min-width:18px;height:18px;padding:0 5px;border-radius:9px;background:#e0245e;color:#fff;font:700 11px/18px Inter,Arial,sans-serif;text-align:center;box-shadow:0 0 0 2px #fff}</style>
                <a href="/peoplelink/first/profile/my-profile.php" class="pl-login pl-login-user" title="My account">
                    <i class="fa-regular fa-user"></i> <span class="pl-login-text"><?= htmlspecialchars($plUserName) ?></span>
                </a>
                <a href="/peoplelink/first/logout.php" class="pl-login pl-login-out" title="Logout" aria-label="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i> <span class="pl-login-text">Logout</span>
                </a>
                <?php else: ?>
                <a href="/peoplelink/matrimoney/login.php" class="pl-login">
                    <i class="fa-regular fa-user"></i> Login
                </a>
                <?php endif; ?>


                <!-- Select Community -->

                <?php $plMyComm = null; if (!empty($_SESSION['uid'])) { try { $plq = db()->prepare('SELECT c.name, c.slug FROM users u JOIN communities c ON c.id=u.community_id WHERE u.id=?'); $plq->execute([(int)$_SESSION['uid']]); $plMyComm = $plq->fetch(PDO::FETCH_ASSOC) ?: null; } catch (Throwable $plE) {} } ?>
                <?php if ($plMyComm): ?>
                <a href="/peoplelink/first/community-home.php?c=<?= urlencode($plMyComm['slug']) ?>" class="pl-community-button" title="My community">
                    <i class="fa-solid fa-users"></i> <?= htmlspecialchars($plMyComm['name'], ENT_QUOTES, 'UTF-8') ?>
                </a>
                <?php else: ?>
                <a href="/peoplelink/first/community-page.php" class="pl-community-button">
                    <i class="fa-solid fa-users"></i> Select Community
                </a>
                <?php endif; ?>


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


 