<?php
/* $pageTitle, $active (menu key) are set by the page. */
$__menu = [
    'home' => ['index.php', 'fa-house', 'Matrimony'],
    'search' => ['search.php', 'fa-magnifying-glass', 'Search'],
    'me' => ['my-profile.php', 'fa-id-card', 'My Profile'],
    'interests' => ['interests.php', 'fa-heart', 'Interests'],
    'contacts' => ['contacts.php', 'fa-address-book', 'Contacts'],
    'saved' => ['saved.php', 'fa-bookmark', 'Saved'],
    'notifications' => ['notifications.php', 'fa-bell', 'Alerts'],
    'packages' => ['packages.php', 'fa-crown', 'Packages'],
];
$__unread = $uid ? scalar('SELECT COUNT(*) FROM user_notifications WHERE user_id=? AND is_read=0 AND type=?', [$uid, MAT_NOTIFY_TYPE]) : 0;
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(($pageTitle ?? 'Matrimony') . ' | PeopleLink Matrimony') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="<?= $F ?>header.css?v=7">
<link rel="stylesheet" href="<?= $F ?>footer.css">
<link rel="stylesheet" href="../css/matrimony.css?v=10">
<script>
window.MAT = <?= json_encode([
    'api' => DASHBOARD_URL . 'api.php',
    'csrf' => csrf_token(),
    'loggedIn' => (bool)$user,
    'loginUrl' => mat_login_url(),
    'community' => $comm ? ['id' => (int)$comm['id'], 'name' => $comm['name'], 'slug' => $comm['slug']] : null,
    'me' => $me ? ['id' => (int)$me['id'], 'code' => $me['profile_code'], 'status' => $me['status'], 'gender' => $me['gender']] : null,
], JSON_UNESCAPED_SLASHES) ?>;
</script>
</head>
<body class="mat-body">
<?php include __DIR__ . '/site-nav.php'; ?>

<nav class="mat-subnav" aria-label="Matrimony menu">
  <div class="mat-wrap mat-subnav-in">
    <?php foreach ($__menu as $k => [$href, $ic, $label]): ?>
      <a href="<?= $href ?>" class="<?= ($active ?? '') === $k ? 'on' : '' ?>"><i class="fa-solid <?= $ic ?>"></i><span><?= $label ?></span><?php if ($k === 'notifications' && $__unread): ?><b class="mat-dot" id="matUnread"><?= $__unread ?></b><?php endif; ?></a>
    <?php endforeach; ?>
  </div>
</nav>

<?php if ($me && $me['status'] !== 'approved' && empty($hideStatusBar)): ?>
<div class="mat-statusbar mat-st-<?= e($me['status']) ?>">
  <div class="mat-wrap"><i class="fa-solid fa-circle-info"></i>
    <?= $me['status'] === 'pending' ? 'Your profile ' . e($me['profile_code']) . ' is waiting for admin approval. Until then it is hidden from search and you cannot send interests.' : 'Your profile was not approved. Please update it and save again for review.' ?>
    <a href="profile-form.php">Edit profile</a></div>
</div>
<?php endif; ?>

<main class="mat-main" id="matMain">
