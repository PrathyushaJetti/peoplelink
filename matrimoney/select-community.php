<?php
require_once __DIR__ . '/config.php';
$GLOBALS['ROOT'] = '';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/helpers.php';
if (!current_user()) { header('Location: login.php'); exit; }
$communities = db()->query('SELECT * FROM communities WHERE is_active = 1 ORDER BY id')->fetchAll(); ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Select Community | PeopleLink</title><link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"><link rel="stylesheet" href="assets/style.css"></head><body>
<div class="pick">
  <div class="brand"><img class="logo" src="<?= LOGO_URL ?>" alt="PeopleLink"></div>
  <h1>Choose your community</h1><div class="sub">You will be taken to your community's own space with Matrimony, Jobs, Ads and more.</div>
  <div class="grid-c">
    <?php foreach ($communities as $c): ?>
      <a class="ccard" href="<?= e(community_url($c)) ?>"><?= icon('fa-people-group') ?><?= e($c['name']) ?></a>
    <?php endforeach; ?>
  </div>
  <div class="alt left"><a href="logout.php"><?= icon('fa-right-from-bracket') ?> Logout</a></div>
</div><script src="assets/app.js"></script></body></html>
