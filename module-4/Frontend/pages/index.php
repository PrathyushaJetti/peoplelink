<?php
require __DIR__ . '/../components/init.php';
$pageTitle = 'Matrimony'; $active = 'home'; $scripts = ['home.js'];
include __DIR__ . '/../components/header.php';

/* ---------- data for the home sections (real counts where available) ---------- */
$mhProfiles = $cid ? (int)scalar("SELECT COUNT(*) FROM matrimony_profiles WHERE community_id=? AND status='approved' AND is_active=1", [$cid]) : (int)scalar("SELECT COUNT(*) FROM matrimony_profiles WHERE status='approved' AND is_active=1");
$mhComms = rows('SELECT name, slug FROM communities WHERE is_active=1 ORDER BY sort_order, name');
$mhCities = $cid ? rows("SELECT city, COUNT(*) n FROM matrimony_profiles WHERE community_id=? AND status='approved' AND is_active=1 AND city<>'' GROUP BY city ORDER BY n DESC LIMIT 12", [$cid]) : [];
$mhStates = $cid ? rows("SELECT state, COUNT(*) n FROM matrimony_profiles WHERE community_id=? AND status='approved' AND is_active=1 AND state<>'' GROUP BY state ORDER BY n DESC LIMIT 12", [$cid]) : [];
$mhPlan = $cid ? (rows('SELECT name, price, validity_days FROM matrimony_packages WHERE community_id=? AND is_active=1 ORDER BY price LIMIT 1', [$cid])[0] ?? null) : null;
$mhCommName = $comm['name'] ?? 'your community';
// Founder photo (first/images/Srinivas-fonder.jpeg); the logo shows instead if the file is missing
$mhFounderImg = is_file(__DIR__ . '/../../../first/images/Srinivas-fonder.jpeg') ? $F . 'images/Srinivas-fonder.jpeg' : '';
$mhRegister = !$user ? DASHBOARD_URL . 'signup.php?next=' . urlencode(MAT_URL . 'profile-form.php') : (!$me ? 'profile-form.php' : 'my-profile.php');
?>
<!-- ================= HERO ================= -->
<section class="mx-hero">
  <div class="mx-hero-in">
    <span class="mx-hero-tag"><?= e($comm['name'] ?? 'PeopleLink') ?> Matrimony</span>
    <h1>Find Your Life Partner</h1>
    <p>Within your own community, with verified profiles and families you can trust</p>
    <form class="mx-search" action="search.php" method="get" aria-label="Quick search">
      <label class="mx-f"><span>I'm looking for a</span>
        <select name="gender"><option value="Female">Bride</option><option value="Male">Groom</option></select></label>
      <div class="mx-f mx-age"><span>Aged</span>
        <div><select name="min_age" aria-label="Minimum age"><?php for ($a = 18; $a <= 60; $a++): ?><option<?= $a === 21 ? ' selected' : '' ?>><?= $a ?></option><?php endfor; ?></select>
        <em>to</em>
        <select name="max_age" aria-label="Maximum age"><?php for ($a = 18; $a <= 70; $a++): ?><option<?= $a === 30 ? ' selected' : '' ?>><?= $a ?></option><?php endfor; ?></select></div></div>
      <label class="mx-f"><span>Marital status</span>
        <select name="marital_status"><option value="">Any</option><?php foreach (['Never Married', 'Divorced', 'Widowed', 'Awaiting Divorce'] as $m): ?><option><?= e($m) ?></option><?php endforeach; ?></select></label>
      <label class="mx-f"><span>Living in</span>
        <select name="city" id="quickCity"><option value="">Any city</option></select></label>
      <button class="mx-go" type="submit">Let's Begin</button>
    </form>
  </div>
  <div class="mx-band">
    <span><i class="fa-solid fa-people-group"></i> <?= $cid ? '#1 for ' . e($mhCommName) . ' families' : count($mhComms) . ' communities on PeopleLink' ?></span>
    <span><i class="fa-solid fa-user-check"></i> <?= number_format($mhProfiles) ?>+ approved profiles</span>
    <span><i class="fa-solid fa-shield-halved"></i> Every profile checked by our team</span>
  </div>
</section>

<div class="mat-wrap">
  <!-- ================= THE PEOPLELINK EXPERIENCE ================= -->
  <section class="mx-sec">
    <h2 class="mx-title">The PeopleLink Experience</h2>
    <div class="mx-exp">
      <article class="mx-exp-card"><span class="mx-exp-ico"><i class="fa-solid fa-people-roof"></i></span><h3>Matches Within Your Community</h3><p>See profiles from <?= e($mhCommName) ?> only, with family details, native place and traditions that matter to you.</p></article>
      <article class="mx-exp-card"><span class="mx-exp-ico green"><i class="fa-solid fa-circle-check"></i></span><h3>Verified Profiles You Can Trust</h3><p>Our team reviews every profile and photo before it goes live, so you only meet genuine people.</p></article>
      <article class="mx-exp-card"><span class="mx-exp-ico blue"><i class="fa-solid fa-user-lock"></i></span><h3>Your Privacy, Your Choice</h3><p>Hide your photos until you accept an interest. Phone numbers are shared only when both sides agree.</p></article>
    </div>
    <div class="mx-premium">
      <div class="mx-premium-logo"><img src="<?= $F ?>images/peoplelink-logo.png" alt="PeopleLink"><small>Premium Matchmaking</small></div>
      <div class="mx-premium-copy">
        <p>Experience personalised matchmaking with a PeopleLink premium plan — contact access, unlimited interests and a highlighted profile.</p>
        <div class="mx-premium-btns">
          <a class="mx-btn" href="packages.php"><?= $mhPlan ? 'Plans from ₹' . number_format((float)$mhPlan['price']) : 'View Premium Plans' ?></a>
          <a class="mx-btn ghost" href="support.php">Talk to Our Team</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= RECENTLY JOINED (live) ================= -->
  <?php if (!$cid): ?>
    <div class="mat-empty"><i class="fa-solid fa-people-group"></i><h3>Select your community</h3><p>Matrimony profiles are shown within your community.</p><a class="mat-btn" href="<?= $F ?>community-page.php?next=<?= urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/module-4/Frontend/pages/index.php') ?>">Choose community</a></div>
  <?php else: ?>
  <section class="mx-sec">
    <div class="mx-head"><h2 class="mx-title">Recently Joined Profiles</h2><a class="mx-link" href="search.php">See all profiles <i class="fa-solid fa-arrow-right"></i></a></div>
    <div class="mat-cards" id="homeCards"></div>
  </section>
  <?php endif; ?>
</div>

<!-- ================= FOUNDER / MISSION ================= -->
<section class="mx-founder">
  <div class="mat-wrap mx-founder-in">
    <div class="mx-founder-copy">
      <span class="mx-quote" aria-hidden="true">&ldquo;</span>
      <blockquote>At PeopleLink, our mission is to use technology to keep communities connected and help families find meaningful, lasting relationships.</blockquote>
      <p class="mx-founder-by">— <strong>Srinivas</strong>, Founder, PeopleLink Technologies</p>
      <a class="mx-btn" href="<?= e($mhRegister) ?>"><?= !$user ? 'Register Free' : (!$me ? 'Create Matrimony Profile' : 'Go to My Dashboard') ?></a>
    </div>
    <div class="mx-founder-art">
      <?php if ($mhFounderImg): ?>
        <img src="<?= e($mhFounderImg) ?>" alt="Srinivas, Founder of PeopleLink" loading="lazy">
      <?php else: ?>
        <div class="mx-founder-ph" aria-hidden="true"><img src="<?= $F ?>images/peoplelink-logo.png" alt=""><span><i class="fa-solid fa-heart"></i></span></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<div class="mat-wrap">
  <!-- ================= REAL STORIES ================= -->
  <section class="mx-sec mx-stories">
    <div class="mx-stories-intro">
      <h2 class="mx-title">Real Stories, True Connections</h2>
      <p>Discover how PeopleLink has brought families together within their community. Your success story could be next!</p>
      <a class="mx-btn" href="support.php">Share Your Story <i class="fa-solid fa-arrow-right"></i></a>
    </div>
    <div class="mx-stories-rail">
      <div class="mx-track" id="mxTrack">
        <?php foreach ([
          ['Sravani & Rakesh', 'Hyderabad · Married 2026', 'Our parents liked that both families were from the same community. We spoke for a few weeks on PeopleLink before meeting — and the rest is history.', 'rose'],
          ['Divya & Kiran', 'Vijayawada · Engaged 2026', 'I liked that my photos were private until I accepted an interest. It felt safe, and the profile details helped our families connect quickly.', 'blue'],
          ['Anusha & Varun', 'Visakhapatnam · Married 2026', 'My brother created my profile. Within a month we found a family with the same values — thank you PeopleLink Matrimony!', 'orange'],
          ['Harika & Sai', 'Guntur · Married 2026', 'Both families could see the native place and family details upfront, which made the first conversation so much easier.', 'green'],
        ] as [$n, $m, $t, $c]): $ini = implode(' & ', array_map(fn($x) => mb_substr(trim($x), 0, 1), explode('&', $n))); ?>
        <article class="mx-story">
          <div class="mx-story-img <?= $c ?>"><span><?= e($ini) ?></span><i class="fa-solid fa-heart"></i></div>
          <div class="mx-story-body"><h3><?= e($n) ?></h3><small><?= e($m) ?></small><p><?= e($t) ?></p></div>
        </article>
        <?php endforeach; ?>
      </div>
      <div class="mx-rail-foot">
        <div class="mx-progress"><span id="mxBar"></span></div>
        <div class="mx-arrows"><button type="button" id="mxPrev" aria-label="Previous stories"><i class="fa-solid fa-arrow-left"></i></button><button type="button" id="mxNext" aria-label="Next stories"><i class="fa-solid fa-arrow-right"></i></button></div>
      </div>
      <p class="mx-note"><i class="fa-solid fa-circle-info"></i> Sample stories shown until members share their own. Names are illustrative.</p>
    </div>
  </section>

  <!-- ================= FAQ ================= -->
  <section class="mx-sec">
    <h2 class="mx-title">Frequently Asked Questions</h2>
    <div class="mx-faq">
      <?php foreach ([
        ['Why is PeopleLink Matrimony different from other matrimony websites?', 'PeopleLink is community-first. You see profiles only from your own community, every profile is checked by our team, photos can stay private until you accept an interest, and contact details are shared only when both sides agree.'],
        ['How do I create a matrimony profile on PeopleLink?', 'Register or log in, select your community, then choose <strong>Create matrimony profile</strong>. Add personal, family and partner details and upload photos. Our team reviews it and you are notified once it is approved.'],
        ['What is the difference between free and premium membership?', 'Free members can create a profile, search and send interests. Premium plans add contact access, more interests and a highlighted profile. See <a href="packages.php">Packages</a> for current plans.'],
        ['Who can see my profile and contact details?', 'Only members of your community can find your profile. In <strong>Privacy</strong> settings you can hide your photos, and phone numbers are shared only after an accepted interest or an approved contact request.'],
        ['Can parents or relatives create a profile for me?', 'Yes. While creating the profile, choose who is creating it (self, parent, sibling or relative). The profile stays linked to your PeopleLink account.'],
        ['How do I report a fake or misleading profile?', 'Open the profile and choose <strong>Report</strong>. Our team reviews every report and can suspend profiles that break the community guidelines.'],
      ] as $i => [$q, $a]): ?>
      <details<?= $i === 0 ? ' open' : '' ?>><summary><b><?= sprintf('%02d', $i + 1) ?></b><span><?= e($q) ?></span></summary><p><?= $a ?></p></details>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ================= EXPLORE ================= -->
  <section class="mx-box">
    <h2>Explore Matrimonial Profiles By</h2>
    <div class="mx-tabs" role="tablist">
      <button type="button" class="on" data-mh-tab="comm" role="tab">Community</button>
      <?php if ($mhCities): ?><button type="button" data-mh-tab="city" role="tab">City</button><?php endif; ?>
      <?php if ($mhStates): ?><button type="button" data-mh-tab="state" role="tab">State</button><?php endif; ?>
      <button type="button" data-mh-tab="marital" role="tab">Marital Status</button>
      <button type="button" data-mh-tab="age" role="tab">Age</button>
    </div>
    <div class="mx-links" data-mh-panel="comm"><?php foreach ($mhComms as $c): ?><a href="index.php?c=<?= urlencode($c['slug']) ?>"><?= e($c['name']) ?> Matrimony</a><?php endforeach; ?></div>
    <?php if ($mhCities): ?><div class="mx-links" data-mh-panel="city" hidden><?php foreach ($mhCities as $c): ?><a href="search.php?city=<?= urlencode($c['city']) ?>"><?= e(ucwords(strtolower($c['city']))) ?> Matrimony</a><?php endforeach; ?></div><?php endif; ?>
    <?php if ($mhStates): ?><div class="mx-links" data-mh-panel="state" hidden><?php foreach ($mhStates as $s): ?><a href="search.php?state=<?= urlencode($s['state']) ?>"><?= e(ucwords(strtolower($s['state']))) ?> Matrimony</a><?php endforeach; ?></div><?php endif; ?>
    <div class="mx-links" data-mh-panel="marital" hidden><?php foreach (['Never Married', 'Divorced', 'Widowed', 'Awaiting Divorce'] as $m): ?><a href="search.php?marital_status=<?= urlencode($m) ?>"><?= e($m) ?> Matrimony</a><?php endforeach; ?></div>
    <div class="mx-links" data-mh-panel="age" hidden><?php foreach ([[21, 25], [26, 30], [31, 35], [36, 45]] as [$a, $b]): ?><a href="search.php?min_age=<?= $a ?>&amp;max_age=<?= $b ?>">Brides &amp; Grooms aged <?= $a ?>–<?= $b ?></a><?php endforeach; ?></div>
  </section>

  <section class="mx-box">
    <h2>Brides &amp; Grooms</h2>
    <div class="mx-links">
      <a href="search.php?gender=Female"><?= e($comm['name'] ?? 'Community') ?> Brides</a><a href="search.php?gender=Male"><?= e($comm['name'] ?? 'Community') ?> Grooms</a>
      <a href="search.php?gender=Female&amp;marital_status=Never+Married">Never Married Brides</a><a href="search.php?gender=Male&amp;marital_status=Never+Married">Never Married Grooms</a>
      <a href="search.php?gender=Female&amp;marital_status=Divorced">Divorced Brides</a><a href="search.php?gender=Male&amp;marital_status=Divorced">Divorced Grooms</a>
    </div>
  </section>

  <section class="mx-box">
    <h2>PeopleLink Matrimony Services</h2>
    <div class="mx-links">
      <a href="<?= e($mhRegister) ?>">Create Matrimony Profile</a><a href="search.php">Search Profiles</a><a href="interests.php">Interests</a><a href="contacts.php">Contacts</a>
      <a href="saved.php">Saved Profiles</a><a href="packages.php">Premium Plans</a><a href="support.php">Help &amp; Support</a><a href="<?= $F ?>community-page.php">All Communities</a>
    </div>
  </section>

  <!-- ================= ABOUT ================= -->
  <section class="mx-about">
    <p>PeopleLink Matrimony is a community-first matchmaking service from PeopleLink Technologies. Instead of searching across millions of unrelated profiles, members meet people from their own community, where family values, traditions and native places are understood and respected.</p>
    <p>Every profile is reviewed by our team, photos stay private until you choose to share them, and contact details are exchanged only when both sides agree. Families can stay involved at every step — from creating the profile to linking it with the PeopleLink family profile and family tree.</p>
    <p>Create your profile free today, explore matches in <?= e($mhCommName) ?>, and take the first step towards a meaningful relationship.</p>
  </section>
</div>

<script>
document.querySelectorAll("[data-mh-tab]").forEach(function (b) {
  b.addEventListener("click", function () {
    document.querySelectorAll("[data-mh-tab]").forEach(function (x) { x.classList.toggle("on", x === b); });
    document.querySelectorAll("[data-mh-panel]").forEach(function (p) { p.hidden = p.dataset.mhPanel !== b.dataset.mhTab; });
  });
});
(function () {
  var t = document.getElementById("mxTrack"), bar = document.getElementById("mxBar");
  if (!t) return;
  function step() { var c = t.querySelector(".mx-story"); return c ? c.offsetWidth + 18 : 300; }
  function upd() { var max = t.scrollWidth - t.clientWidth; var vis = t.clientWidth / t.scrollWidth; bar.style.width = (vis * 100) + "%"; bar.style.marginLeft = (max > 0 ? (t.scrollLeft / max) * (100 - vis * 100) : 0) + "%"; }
  document.getElementById("mxPrev").onclick = function () { t.scrollBy({ left: -step(), behavior: "smooth" }); };
  document.getElementById("mxNext").onclick = function () { t.scrollBy({ left: step(), behavior: "smooth" }); };
  t.addEventListener("scroll", upd, { passive: true }); window.addEventListener("resize", upd); upd();
})();
</script>
<?php include __DIR__ . '/../components/footer.php'; ?>
