<?php if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) { http_response_code(404); exit; } // include only
// Shared header actions (bell, account, logout, community) — same as the Member & Family / Profile headers.
// Used by headers that were static (Jobs pages, Directory, old Matrimony folder).
require_once __DIR__ . '/../matrimoney/config.php';
if (session_status() === PHP_SESSION_NONE) { @session_start(); }
if (!isset($plLoggedIn)) $plLoggedIn = !empty($_SESSION['uid']);
if (!isset($plUserName)) {
    $plUserName = 'My Account';
    if ($plLoggedIn) { try { $plN = db()->prepare('SELECT name FROM users WHERE id = ?'); $plN->execute([(int)$_SESSION['uid']]); $plUserName = $plN->fetchColumn() ?: 'My Account'; } catch (Throwable $e) {} }
}
?>
                <!-- Login -->
                <?php if ($plLoggedIn): ?>
                <?php $plBellN = 0; if (!empty($_SESSION['uid'])) { try { require_once __DIR__ . '/../matrimoney/includes/notifications.php'; $plBellN = pl_notif_unread((int)$_SESSION['uid']); } catch (Throwable $plBe) {} } ?>
                <a href="/peoplelink/first/profile/notifications.php" class="pl-login pl-bell" title="Notifications" aria-label="Notifications<?= $plBellN ? ' (' . (int)$plBellN . ' unread)' : '' ?>"><i class="fa-regular fa-bell"></i><?php if ($plBellN): ?><span class="pl-bell-count"><?= $plBellN > 99 ? '99+' : (int)$plBellN ?></span><?php endif; ?></a>
                <style>.pl-bell{position:relative;display:inline-flex;align-items:center;justify-content:center;min-width:38px}.pl-bell i{font-size:19px}.pl-bell-count{position:absolute;top:-4px;right:-2px;min-width:18px;height:18px;padding:0 5px;border-radius:9px;background:#e0245e;color:#fff;font:700 11px/18px Inter,Arial,sans-serif;text-align:center;box-shadow:0 0 0 2px #fff}/* pl-compact-actions: logged-in header fits narrower desktops */@media (max-width:1500px){.pl-header-actions{gap:8px}.pl-header-actions .pl-login-text{display:none}.pl-header-actions .pl-login{padding-left:10px;padding-right:10px}}</style>
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


