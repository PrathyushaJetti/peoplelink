<?php
require __DIR__ . '/../components/init.php';
$pageTitle = 'Matrimony'; $active = 'home'; $scripts = ['home.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap">
  <section class="mat-banner">
    <span class="mat-eyebrow" style="color:#ffd3e2"><?= e($comm['name'] ?? 'PeopleLink') ?> Matrimony</span>
    <h1>Find a life partner within your community</h1>
    <p>Verified profiles, photo privacy you control, and contact details shared only when both sides agree.</p>
    <form class="mat-quick" action="search.php" method="get" aria-label="Quick search">
      <select name="age" aria-label="Age"><option value="">Any age</option><option>21-25</option><option>26-30</option><option>31-35</option><option value="36+">36 and above</option></select>
      <select name="city" id="quickCity" aria-label="City"><option value="">Any city</option></select>
      <button class="mat-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
    </form>
    <div class="mat-actions">
      <?php if (!$user): ?>
        <a class="mat-btn" href="<?= e(DASHBOARD_URL) ?>signup.php?next=<?= urlencode(MAT_URL . 'profile-form.php') ?>">Register free</a>
        <a class="mat-btn ghost" href="<?= e(mat_login_url()) ?>">Login</a>
      <?php elseif (!$me): ?>
        <a class="mat-btn" href="profile-form.php"><i class="fa-solid fa-user-plus"></i> Create matrimony profile</a>
      <?php else: ?>
        <a class="mat-btn" href="my-profile.php"><i class="fa-solid fa-id-card"></i> My dashboard</a>
      <?php endif; ?>
    </div>
  </section>

  <?php if (!$cid): ?>
    <div class="mat-empty"><i class="fa-solid fa-people-group"></i><h3>Select your community</h3><p>Matrimony profiles are shown within your community.</p><a class="mat-btn" href="<?= $F ?>community-page.php?next=<?= urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/module-4/Frontend/pages/index.php') ?>">Choose community</a></div>
  <?php else: ?>
  <div class="mat-head"><div><span class="mat-eyebrow">Newest members</span><h2>Recently joined profiles</h2></div><a class="mat-btn ghost sm" href="search.php">See all profiles <i class="fa-solid fa-arrow-right"></i></a></div>
  <div class="mat-cards" id="homeCards"></div>
  <?php endif; ?>

  <div class="mat-steps">
    <div class="mat-step"><i class="fa-solid fa-user-pen"></i><h3>1. Create profile</h3><p>Add your details, family and partner preferences.</p></div>
    <div class="mat-step"><i class="fa-solid fa-shield-halved"></i><h3>2. Get approved</h3><p>Our team checks every profile and photo.</p></div>
    <div class="mat-step"><i class="fa-solid fa-heart"></i><h3>3. Send interest</h3><p>Show interest in profiles you like.</p></div>
    <div class="mat-step"><i class="fa-solid fa-phone"></i><h3>4. Connect</h3><p>Contacts are shared after an accepted interest or approved request.</p></div>
  </div>

  <?php
  /* ---------- extra home sections (real counts where available) ---------- */
  $mhProfiles = $cid ? (int)scalar("SELECT COUNT(*) FROM matrimony_profiles WHERE community_id=? AND status='approved' AND is_active=1", [$cid]) : (int)scalar("SELECT COUNT(*) FROM matrimony_profiles WHERE status='approved' AND is_active=1");
  $mhComms = rows('SELECT name, slug FROM communities WHERE is_active=1 ORDER BY sort_order, name');
  $mhCities = $cid ? rows("SELECT city, COUNT(*) n FROM matrimony_profiles WHERE community_id=? AND status='approved' AND is_active=1 AND city<>'' GROUP BY city ORDER BY n DESC LIMIT 12", [$cid]) : [];
  $mhPlan = $cid ? (rows('SELECT name, price, validity_days FROM matrimony_packages WHERE community_id=? AND is_active=1 ORDER BY price LIMIT 1', [$cid])[0] ?? null) : null;
  $mhCommName = $comm['name'] ?? 'your community';
  ?>

  <!-- Trust strip -->
  <section class="mh-trust" aria-label="Why members trust PeopleLink Matrimony">
    <div class="mh-trust-item"><i class="fa-solid fa-user-check"></i><div><strong><?= number_format($mhProfiles) ?>+</strong><span>Approved profiles<?= $cid ? ' in ' . e($mhCommName) : '' ?></span></div></div>
    <div class="mh-trust-item"><i class="fa-solid fa-people-group"></i><div><strong><?= count($mhComms) ?></strong><span>Communities on PeopleLink</span></div></div>
    <div class="mh-trust-item"><i class="fa-solid fa-shield-halved"></i><div><strong>100%</strong><span>Profiles checked by our team</span></div></div>
    <div class="mh-trust-item"><i class="fa-solid fa-lock"></i><div><strong>Private</strong><span>Contacts shared only with consent</span></div></div>
  </section>

  <!-- Why PeopleLink Matrimony -->
  <section class="mh-section">
    <div class="mat-head"><div><span class="mat-eyebrow">The PeopleLink experience</span><h2>Why families choose PeopleLink Matrimony</h2></div></div>
    <div class="mh-features">
      <article class="mh-feature"><span class="mh-ico"><i class="fa-solid fa-people-roof"></i></span><h3>Matches within your community</h3><p>See profiles from <?= e($mhCommName) ?> only, with family details, native place and traditions that matter to you.</p></article>
      <article class="mh-feature"><span class="mh-ico green"><i class="fa-solid fa-circle-check"></i></span><h3>Every profile verified</h3><p>Our team reviews each profile and photo before it goes live, so you meet genuine people.</p></article>
      <article class="mh-feature"><span class="mh-ico blue"><i class="fa-solid fa-eye-slash"></i></span><h3>Photo &amp; contact privacy</h3><p>You decide who sees your photos. Phone numbers are shared only after an accepted interest.</p></article>
      <article class="mh-feature"><span class="mh-ico orange"><i class="fa-solid fa-hands-holding-child"></i></span><h3>Families stay involved</h3><p>Profiles can be created by parents or siblings, and linked to your PeopleLink family profile.</p></article>
    </div>
  </section>

  <!-- Premium membership promo -->
  <section class="mh-promo">
    <div class="mh-promo-copy">
      <span class="mat-eyebrow" style="color:#ffd3e2">Premium membership</span>
      <h2>Find your match faster with a premium plan</h2>
      <ul>
        <li><i class="fa-solid fa-check"></i> View contact details of accepted matches</li>
        <li><i class="fa-solid fa-check"></i> Send unlimited interests with a personal message</li>
        <li><i class="fa-solid fa-check"></i> Stand out with a highlighted profile</li>
      </ul>
      <div class="mat-actions">
        <a class="mat-btn" href="packages.php"><i class="fa-solid fa-crown"></i> <?= $mhPlan ? 'Plans from ₹' . number_format((float)$mhPlan['price']) : 'View plans' ?></a>
        <a class="mat-btn ghost" href="support.php"><i class="fa-solid fa-headset"></i> Talk to our team</a>
      </div>
    </div>
    <div class="mh-promo-art" aria-hidden="true"><i class="fa-solid fa-crown"></i><span class="b1"><i class="fa-solid fa-heart"></i></span><span class="b2"><i class="fa-solid fa-star"></i></span></div>
  </section>

  <!-- Success stories (sample stories until real couples share theirs) -->
  <section class="mh-section">
    <div class="mat-head"><div><span class="mat-eyebrow">Real stories, true connections</span><h2>Happily matched on PeopleLink</h2></div><a class="mat-btn ghost sm" href="support.php">Share your story <i class="fa-solid fa-arrow-right"></i></a></div>
    <div class="mh-stories">
      <article class="mh-story"><div class="mh-story-top"><span class="mh-av">S&amp;R</span><div><h3>Sravani &amp; Rakesh</h3><small>Hyderabad · Married 2026</small></div></div><p>“Our parents liked that both families were from the same community. We spoke for a few weeks on PeopleLink before meeting — and the rest is history.”</p></article>
      <article class="mh-story"><div class="mh-story-top"><span class="mh-av">D&amp;K</span><div><h3>Divya &amp; Kiran</h3><small>Vijayawada · Engaged 2026</small></div></div><p>“I liked that my photos were private until I accepted an interest. It felt safe, and the profile details helped our families connect quickly.”</p></article>
      <article class="mh-story"><div class="mh-story-top"><span class="mh-av">A&amp;V</span><div><h3>Anusha &amp; Varun</h3><small>Visakhapatnam · Married 2026</small></div></div><p>“My brother created my profile. Within a month we found a family with the same values — thank you PeopleLink Matrimony!”</p></article>
    </div>
    <p class="mh-note"><i class="fa-solid fa-circle-info"></i> Sample stories shown until members share their own. Names are illustrative.</p>
  </section>

  <!-- App promo -->
  <section class="mh-app">
    <div>
      <span class="mat-eyebrow">PeopleLink app</span>
      <h2>Search, chat and get match alerts on your phone</h2>
      <p>Get instant notifications when someone sends you an interest, and manage your profile anywhere.</p>
      <div class="mh-stores"><span class="mh-store"><i class="fa-brands fa-google-play"></i><span><small>Coming soon on</small>Google Play</span></span><span class="mh-store"><i class="fa-brands fa-apple"></i><span><small>Coming soon on the</small>App Store</span></span></div>
    </div>
    <div class="mh-phone" aria-hidden="true"><div class="mh-phone-screen"><i class="fa-solid fa-heart"></i><span>New interest received</span><small>Tap to view profile</small></div></div>
  </section>

  <!-- FAQ -->
  <section class="mh-section">
    <div class="mat-head"><div><span class="mat-eyebrow">Help</span><h2>Frequently asked questions</h2></div></div>
    <div class="mh-faq">
      <details open><summary>How do I create a matrimony profile on PeopleLink?</summary><p>Register or log in, select your community, then choose <strong>Create matrimony profile</strong>. Add personal, family and partner details and upload photos. Our team reviews it and you are notified once it is approved.</p></details>
      <details><summary>Who can see my profile and photos?</summary><p>Only members of your community can find your profile. In <strong>Privacy</strong> settings you can hide your photos until you accept an interest, and block or report any profile.</p></details>
      <details><summary>When are phone numbers and contact details shared?</summary><p>Contact details are shared only after both sides agree — when an interest is accepted or a contact request is approved.</p></details>
      <details><summary>What is the difference between free and premium membership?</summary><p>Free members can create a profile, search and send interests. Premium plans add contact access, more interests and a highlighted profile. See <a href="packages.php">Packages</a> for current plans.</p></details>
      <details><summary>Can parents or relatives create a profile for me?</summary><p>Yes. While creating the profile, choose who is creating it (self, parent, sibling or relative). The profile stays linked to your PeopleLink account.</p></details>
      <details><summary>How do I report a fake or misleading profile?</summary><p>Open the profile and choose <strong>Report</strong>. Our team reviews every report and can suspend profiles that break the community guidelines.</p></details>
    </div>
  </section>

  <!-- Explore profiles by -->
  <section class="mh-explore">
    <h2>Explore matrimony profiles by</h2>
    <div class="mh-tabs" role="tablist">
      <button type="button" class="on" data-mh-tab="comm" role="tab">Community</button>
      <?php if ($mhCities): ?><button type="button" data-mh-tab="city" role="tab">City</button><?php endif; ?>
      <button type="button" data-mh-tab="marital" role="tab">Marital status</button>
      <button type="button" data-mh-tab="age" role="tab">Age</button>
    </div>
    <div class="mh-links" data-mh-panel="comm"><?php foreach ($mhComms as $c): ?><a href="index.php?c=<?= urlencode($c['slug']) ?>"><?= e($c['name']) ?> Matrimony</a><?php endforeach; ?></div>
    <?php if ($mhCities): ?><div class="mh-links" data-mh-panel="city" hidden><?php foreach ($mhCities as $c): ?><a href="search.php?city=<?= urlencode($c['city']) ?>"><?= e(ucwords(strtolower($c['city']))) ?> Matrimony</a><?php endforeach; ?></div><?php endif; ?>
    <div class="mh-links" data-mh-panel="marital" hidden><?php foreach (['Never Married', 'Divorced', 'Widowed', 'Awaiting Divorce'] as $m): ?><a href="search.php?marital_status=<?= urlencode($m) ?>"><?= e($m) ?> Matrimony</a><?php endforeach; ?></div>
    <div class="mh-links" data-mh-panel="age" hidden><?php foreach ([[21, 25], [26, 30], [31, 35], [36, 45]] as [$a, $b]): ?><a href="search.php?min_age=<?= $a ?>&amp;max_age=<?= $b ?>">Brides &amp; grooms aged <?= $a ?>–<?= $b ?></a><?php endforeach; ?></div>
  </section>

  <!-- About -->
  <section class="mh-about">
    <h2>About PeopleLink Matrimony</h2>
    <p>PeopleLink Matrimony is a community-first matchmaking service from PeopleLink Technologies. Instead of searching across millions of unrelated profiles, members meet people from their own community, where family values, traditions and native places are understood and respected.</p>
    <p>Every profile is reviewed by our team, photos stay private until you choose to share them, and contact details are exchanged only when both sides agree. Families can stay involved at every step — from creating the profile to linking it with the PeopleLink family profile and family tree.</p>
    <p>Create your profile free today, explore matches in <?= e($mhCommName) ?>, and take the first step towards a meaningful relationship.</p>
  </section>
  <script>
  document.querySelectorAll("[data-mh-tab]").forEach(function (b) {
    b.addEventListener("click", function () {
      document.querySelectorAll("[data-mh-tab]").forEach(function (x) { x.classList.toggle("on", x === b); });
      document.querySelectorAll("[data-mh-panel]").forEach(function (p) { p.hidden = p.dataset.mhPanel !== b.dataset.mhTab; });
    });
  });
  </script>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
