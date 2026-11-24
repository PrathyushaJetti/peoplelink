<header class="pl-header" id="peoplelinkHeader">
    <div class="pl-topbar">
        <div class="pl-container">
            <div class="pl-top-left">
                <span><i class="fa-solid fa-heart"></i> Connecting Communities</span>
                <span><i class="fa-solid fa-location-dot"></i> Communities Across India</span>
            </div>
            <div class="pl-top-right">
                <a href="/peoplelink/module-4/Frontend/pages/support.php">Help & Support</a>
                <a href="/peoplelink/module-4/Frontend/pages/support.php">Contact Us</a>
            </div>
        </div>
    </div>

    <div class="pl-navbar">
        <div class="pl-container">
            <a href="<?= $F ?>index.php" class="pl-logo" aria-label="PeopleLink Home">
                <img src="<?= $F ?>images/logo.jpeg" alt="PeopleLink" class="pl-logo-image">
            </a>

            <button type="button" class="pl-mobile-toggle" id="plMobileToggle" aria-label="Open navigation" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>

            <nav class="pl-main-nav" id="plMainNav" aria-label="Main Navigation">
                <a href="<?= $F ?>index.php" class="pl-nav-link active">Home</a>
                <div class="pl-nav-dropdown">
                    <button type="button" class="pl-nav-dropdown-btn">
                        Communities <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="pl-dropdown-menu">
                        <div class="pl-dropdown-title">
                            <strong>OUR COMMUNITIES</strong>
                            <span>Choose your community</span>
                        </div>
                        <a href="<?= $F ?>community-page.php?c=arya-vysya"><i class="fa-solid fa-people-group"></i> Arya Vysya</a>
                        <a href="<?= $F ?>community-page.php?c=reddy"><i class="fa-solid fa-users"></i> Reddy</a>
                        <a href="<?= $F ?>community-page.php?c=kamma"><i class="fa-solid fa-people-roof"></i> Kamma</a>
                        <a href="<?= $F ?>community-page.php?c=kapu"><i class="fa-solid fa-user-group"></i> Kapu</a>
                        <a href="<?= $F ?>community-page.php?c=banjara"><i class="fa-solid fa-people-arrows"></i> Banjara</a>
                        <a href="<?= $F ?>community-page.php" class="pl-dropdown-all">View All Communities <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <a href="<?= $F ?>service.php" class="pl-nav-link">Services</a>
                <a href="<?= $F ?>about-us.php" class="pl-nav-link">About Us</a>
                <a href="<?= $F ?>events-ads.php" class="pl-nav-link">Events</a>
                <a href="/peoplelink/module-4/Frontend/pages/support.php" class="pl-nav-link">Contact</a>

                <div class="pl-mobile-actions">
                    <a href="<?= $F ?>community-page.php" class="pl-mobile-community"><i class="fa-solid fa-users"></i> Select Your Community</a>
                    <a href="<?= $F ?>coming-soon.php" class="pl-mobile-download"><i class="fa-solid fa-mobile-screen-button"></i> Download App</a>
                </div>
            </nav>

            <div class="pl-header-actions">
                <?php if ($user): ?>
                <?php $plBellN = 0; if (!empty($_SESSION['uid'])) { try { require_once __DIR__ . '/../../../matrimoney/includes/notifications.php'; $plBellN = pl_notif_unread((int)$_SESSION['uid']); } catch (Throwable $plBe) {} } ?>
                <a href="/peoplelink/first/profile/notifications.php" class="pl-login pl-bell" title="Notifications" aria-label="Notifications<?= $plBellN ? ' (' . (int)$plBellN . ' unread)' : '' ?>"><i class="fa-regular fa-bell"></i><?php if ($plBellN): ?><span class="pl-bell-count"><?= $plBellN > 99 ? '99+' : (int)$plBellN ?></span><?php endif; ?></a>
                <style>.pl-bell{position:relative;display:inline-flex;align-items:center;justify-content:center;min-width:38px}.pl-bell i{font-size:19px}.pl-bell-count{position:absolute;top:-4px;right:-2px;min-width:18px;height:18px;padding:0 5px;border-radius:9px;background:#e0245e;color:#fff;font:700 11px/18px Inter,Arial,sans-serif;text-align:center;box-shadow:0 0 0 2px #fff}</style>
                <a href="<?= $F ?>profile/my-profile.php" class="pl-login pl-login-user" title="My account">
                    <i class="fa-regular fa-user"></i> <span class="pl-login-text"><?= e($user['name'] ?? 'My Account') ?></span>
                </a>
                <a href="<?= e(DASHBOARD_URL) ?>logout.php" class="pl-login pl-login-out" title="Logout" aria-label="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i> <span class="pl-login-text">Logout</span>
                </a>
                <?php else: ?>
                <a href="<?= e(DASHBOARD_URL) ?>login.php?next=<?= urlencode($_SERVER['REQUEST_URI'] ?? '') ?>" class="pl-login">
                    <i class="fa-regular fa-user"></i> Login
                </a>
                <?php endif; ?>
<?php $plMyComm = null; if (($_SESSION['uid'] ?? 0)) { try { $plq = db()->prepare('SELECT c.name, c.slug FROM users u JOIN communities c ON c.id=u.community_id WHERE u.id=?'); $plq->execute([(int)($_SESSION['uid'] ?? 0)]); $plMyComm = $plq->fetch(PDO::FETCH_ASSOC) ?: null; } catch (Throwable $plE) {} } ?>
                <?php if ($plMyComm): ?>
                <a href="/peoplelink/first/community-home.php?c=<?= urlencode($plMyComm['slug']) ?>" class="pl-community-button" title="My community">
                    <i class="fa-solid fa-users"></i> <?= htmlspecialchars($plMyComm['name'], ENT_QUOTES, 'UTF-8') ?>
                </a>
                <?php else: ?>
                <a href="<?= $F ?>community-page.php" class="pl-community-button">
                    <i class="fa-solid fa-users"></i> Select Community
                </a>
                <?php endif; ?>
                <a href="<?= $F ?>coming-soon.php" class="pl-download-button">
                    <i class="fa-solid fa-mobile-screen-button"></i> Download App
                </a>
            </div>
        </div>
    </div>
</header>
