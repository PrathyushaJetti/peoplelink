<?php
require_once __DIR__ . '/matrimoney/config.php';
if (session_status() === PHP_SESSION_NONE) { @session_start(); }
$plLoggedIn = !empty($_SESSION['uid']);
$plUserName = 'My Account';
if ($plLoggedIn) {
    try {
        $plN = db()->prepare('SELECT name FROM users WHERE id = ?');
        $plN->execute([(int)$_SESSION['uid']]);
        $plUserName = $plN->fetchColumn() ?: 'My Account';
    } catch (Throwable $e) {}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PeopleLink — Connect, discover and belong to your community.">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title><?= htmlspecialchars($pageTitle ?? 'PeopleLink | Connect • Discover • Belong', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="pl-header" id="peoplelinkHeader">
    <div class="pl-topbar">
        <div class="pl-container">
            <div class="pl-top-left">
                <span><i class="fa-solid fa-heart"></i> Connecting Communities</span>
                <span><i class="fa-solid fa-location-dot"></i> Communities Across India</span>
            </div>
            <div class="pl-top-right">
                <a href="#help">Help & Support</a>
                <a href="#contact">Contact Us</a>
            </div>
        </div>
    </div>

    <div class="pl-navbar">
        <div class="pl-container">
            <a href="index.php" class="pl-logo" aria-label="PeopleLink Home">
                <img src="images/logo.jpeg" alt="PeopleLink" class="pl-logo-image">
            </a>

            <button type="button" class="pl-mobile-toggle" id="plMobileToggle" aria-label="Open navigation" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>

            <nav class="pl-main-nav" id="plMainNav" aria-label="Main Navigation">
                <a href="index.php" class="pl-nav-link active">Home</a>
                <div class="pl-nav-dropdown">
                    <button type="button" class="pl-nav-dropdown-btn">
                        Communities <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="pl-dropdown-menu">
                        <div class="pl-dropdown-title">
                            <strong>OUR COMMUNITIES</strong>
                            <span>Choose your community</span>
                        </div>
                        <a href="community-page.php?c=arya-vysya"><i class="fa-solid fa-people-group"></i> Arya Vysya</a>
                        <a href="community-page.php?c=reddy"><i class="fa-solid fa-users"></i> Reddy</a>
                        <a href="community-page.php?c=kamma"><i class="fa-solid fa-people-roof"></i> Kamma</a>
                        <a href="community-page.php?c=kapu"><i class="fa-solid fa-user-group"></i> Kapu</a>
                        <a href="community-page.php?c=banjara"><i class="fa-solid fa-people-arrows"></i> Banjara</a>
                        <a href="community-page.php" class="pl-dropdown-all">View All Communities <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <a href="service.php" class="pl-nav-link">Services</a>
                <a href="about.php" class="pl-nav-link">About Us</a>
                <a href="#events" class="pl-nav-link">Events</a>
                <a href="#contact" class="pl-nav-link">Contact</a>

                <div class="pl-mobile-actions">
                    <a href="community-page.php" class="pl-mobile-community"><i class="fa-solid fa-users"></i> Select Your Community</a>
                    <a href="#downloadApp" class="pl-mobile-download"><i class="fa-solid fa-mobile-screen-button"></i> Download App</a>
                </div>
            </nav>

            <div class="pl-header-actions">
                <?php if ($plLoggedIn): ?>
                <a href="my-matrimony-profile.php" class="pl-login">
                    <i class="fa-regular fa-user"></i> <?= htmlspecialchars($plUserName) ?>
                </a>
                <a href="logout.php" class="pl-login">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
                <?php else: ?>
                <a href="/peoplelink/matrimoney/login.php" class="pl-login">
                    <i class="fa-regular fa-user"></i> Login
                </a>
                <?php endif; ?>
                <a href="community-page.php" class="pl-community-button">
                    <i class="fa-solid fa-users"></i> Select Community
                </a>
                <a href="#downloadApp" class="pl-download-button">
                    <i class="fa-solid fa-mobile-screen-button"></i> Download App
                </a>
            </div>
        </div>
    </div>
</header>