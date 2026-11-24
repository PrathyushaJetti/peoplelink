<?php
require_once dirname(__DIR__, 1) . '/matrimoney/includes/bridge.php';
pl_ensure_schema();
$slug = pl_slug_from_request();
$plNext = safe_next($_GET['next'] ?? null); // page to return to after choosing a community
$plNextLabel = $plNext && str_contains($plNext, 'm-f-registration') ? 'Member & Family Registration' : ($plNext && str_contains($plNext, 'community-home') ? 'Community Home' : ($plNext && str_contains($plNext, 'module-4') ? 'Matrimony' : 'where you were'));
$plLoggedUser = current_user();
$cm = $slug !== '' ? pl_community_page($slug) : null;
// the member's own community (members are locked to one; admins and visitors are not)
$plOwnComm = ($plLoggedUser && ($plLoggedUser['role'] ?? '') !== 'admin' && !empty($plLoggedUser['community_id'])) ? (rows('SELECT * FROM communities WHERE id=?', [(int)$plLoggedUser['community_id']])[0] ?? null) : null;
if ($cm && $plLoggedUser && $_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['choose'] ?? '') === '1') {
    if (hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? '')) && !$plOwnComm && ($plLoggedUser['role'] ?? '') !== 'admin') {
        db()->prepare('UPDATE users SET community_id=? WHERE id=? AND community_id IS NULL')->execute([(int)$cm['id'], (int)$plLoggedUser['id']]);
        $_SESSION['community_slug'] = $cm['slug'];
        pl_audit('user:community_chosen', null, (int)$plLoggedUser['id'], $cm['name'], (int)$cm['id']);
    }
    header('Location: ' . ($plNext ?: 'community-home.php?c=' . urlencode($cm['slug']))); exit;
}
$pageTitle = $cm ? $cm['name'] . ' Community | PeopleLink' : 'Communities | PeopleLink';
if (!$cm && $slug !== '') http_response_code(404);
include('header.php');
if (!$cm):
    $all = rows('SELECT name, slug, about FROM communities WHERE is_active=1 ORDER BY sort_order, name');
    $accents = ['#1261a8', '#42b72a', '#f7941d', '#e72d55', '#7434c4', '#10a8a1'];
    ?>
<style>
.plc-hero { background: linear-gradient(135deg, #0b3d73 0%, #1261a8 55%, #1685c8 100%); color: #fff; padding: 72px 20px 96px; text-align: center; position: relative; overflow: hidden; }
.plc-hero::before, .plc-hero::after { content: ""; position: absolute; border-radius: 50%; background: rgba(255,255,255,.07); }
.plc-hero::before { width: 380px; height: 380px; top: -160px; left: -120px; }
.plc-hero::after { width: 300px; height: 300px; bottom: -150px; right: -80px; }
.plc-hero, .plc-body, .plc-hero *, .plc-body * { font-family: "Inter", "Segoe UI", Arial, sans-serif; }
.plc-hero h1, .plc-card h3, .plc-avatar { font-family: "Manrope", "Inter", "Segoe UI", Arial, sans-serif; }
.plc-hero i, .plc-body i { font-family: "bootstrap-icons" !important; }
.plc-wrap { max-width: 1240px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 1; }
.plc-eyebrow { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; letter-spacing: .14em; color: #bfe3ff; margin-bottom: 14px; }
.plc-hero h1 { font-family: "Manrope", "Inter", sans-serif; font-size: clamp(32px, 5vw, 54px); font-weight: 800; line-height: 1.1; margin: 0 0 14px; }
.plc-hero h1 span { color: #8be36f; }
.plc-hero p { max-width: 640px; margin: 0 auto 30px; font-size: 17px; line-height: 1.6; color: #d6e8f8; }
.plc-search { max-width: 560px; margin: 0 auto; position: relative; }
.plc-search i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #1261a8; font-size: 18px; }
.plc-search input { width: 100%; height: 58px; border: 0; border-radius: 40px; padding: 0 24px 0 52px; font-size: 16px; font-family: inherit; color: #10233f; box-shadow: 0 14px 40px rgba(6,30,60,.28); outline: none; }
.plc-search input:focus { box-shadow: 0 14px 40px rgba(6,30,60,.28), 0 0 0 4px rgba(139,227,111,.55); }
.plc-notice { max-width: 560px; margin: 0 auto 18px; background: rgba(247,148,29,.18); border: 1px solid rgba(247,148,29,.6); color: #fff; padding: 12px 18px; border-radius: 12px; font-size: 15px; }
.plc-body { background: #f5f8fc; padding: 0 0 80px; }
.plc-bar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; padding: 28px 0 22px; margin-top: -34px; }
.plc-count { background: #fff; border: 1px solid #e5ebf2; border-radius: 40px; padding: 10px 20px; font-weight: 700; color: #10233f; box-shadow: 0 8px 24px rgba(16,35,63,.08); }
.plc-count b { color: #1261a8; }
.plc-hint { color: #64748b; font-size: 14px; }
.plc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 22px; }
a.plc-card, a.plc-card:hover, a.plc-card:visited { text-decoration: none; color: inherit; }
.plc-card { --ac: #1261a8; background: #fff; border: 1px solid #e5ebf2; border-radius: 20px; padding: 26px 24px 22px; display: flex; flex-direction: column; position: relative; overflow: hidden; transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease; }
.plc-card::before { content: ""; position: absolute; left: 0; top: 0; right: 0; height: 5px; background: var(--ac); }
.plc-card:hover { transform: translateY(-6px); box-shadow: 0 22px 44px rgba(16,35,63,.14); border-color: var(--ac); }
.plc-avatar { width: 56px; height: 56px; border-radius: 16px; background: var(--ac); color: #fff; display: flex; align-items: center; justify-content: center; font-family: "Manrope", "Inter", sans-serif; font-size: 24px; font-weight: 800; margin-bottom: 16px; box-shadow: 0 10px 22px rgba(16,35,63,.18); }
.plc-card h3 { font-family: "Manrope", "Inter", sans-serif; font-size: 19px; font-weight: 800; color: #10233f; margin: 0 0 8px; line-height: 1.25; }
.plc-card p { font-size: 14px; line-height: 1.6; color: #64748b; margin: 0 0 18px; flex: 1; }
.plc-go { display: inline-flex; align-items: center; gap: 8px; font-weight: 700; font-size: 14px; color: var(--ac); }
.plc-go i { transition: transform .25s ease; }
.plc-card:hover .plc-go i { transform: translateX(5px); }
.plc-empty { display: none; text-align: center; padding: 60px 20px; color: #64748b; }
.plc-empty i { font-size: 40px; color: #1261a8; display: block; margin-bottom: 12px; }
@media (max-width: 640px) { .plc-hero { padding: 52px 16px 84px; } .plc-grid { grid-template-columns: 1fr 1fr; gap: 14px; } .plc-card { padding: 20px 16px 18px; } .plc-card h3 { font-size: 16px; } .plc-card p { display: none; } }
@media (max-width: 400px) { .plc-grid { grid-template-columns: 1fr; } }
</style>

<section class="plc-hero">
    <div class="plc-wrap">
        <span class="plc-eyebrow"><i class="bi bi-people-fill"></i> OUR COMMUNITIES</span>
        <h1>Find <span>Your Community</span></h1>
        <p>Choose your community to read its introduction and history, and explore matrimony, jobs, business directory and more.</p>
        <?php if ($plNext && $slug === ''): ?>
        <div class="plc-notice"><i class="bi bi-info-circle-fill"></i> Please choose your community first to continue to <?= e($plNextLabel) ?>.<?php if ($plLoggedUser && ($plLoggedUser['role'] ?? '') !== 'admin'): ?> Your account will be linked to the community you choose.<?php endif; ?></div>
        <?php elseif ($slug === '' && $plLoggedUser && !$plOwnComm && ($plLoggedUser['role'] ?? '') !== 'admin'): ?>
        <div class="plc-notice"><i class="bi bi-info-circle-fill"></i> Welcome<?= !empty($plLoggedUser['name']) ? ', ' . e($plLoggedUser['name']) : '' ?>! Please choose your community below. Your account will be linked to the community you choose.</div>
        <?php endif; ?>
        <?php if ($slug !== ''): ?>
        <div class="plc-notice"><i class="bi bi-info-circle-fill"></i> We could not find that community. Please pick one from the list below.</div>
        <?php endif; ?>
        <div class="plc-search">
            <i class="bi bi-search"></i>
            <input type="search" id="plcSearch" placeholder="Search your community..." autocomplete="off" aria-label="Search communities">
        </div>
    </div>
</section>

<section class="plc-body">
    <div class="plc-wrap">

        <div class="plc-bar">
            <div class="plc-count"><b id="plcCount"><?= count($all) ?></b> communities</div>
            <div class="plc-hint">Tap a community to open its page</div>
        </div>

        <div class="plc-grid" id="plcGrid">
            <?php foreach ($all as $i => $c):
                $name = trim((string)$c['name']);
                $initial = mb_strtoupper(mb_substr($name, 0, 1));
                $snippet = trim(preg_replace('/\s+/', ' ', (string)($c['about'] ?? '')));
                if ($snippet !== '' && mb_strlen($snippet) > 105) $snippet = rtrim(mb_substr($snippet, 0, 105)) . '...';
                if ($snippet === '') $snippet = 'Read the introduction and history of the ' . $name . ' community.';
                ?>
            <a class="plc-card" href="community-page.php?c=<?= urlencode($c['slug']) ?><?= $plNext ? '&amp;next=' . urlencode($plNext) : '' ?>"
               data-name="<?= e(mb_strtolower($name)) ?>" style="--ac: <?= $accents[$i % count($accents)] ?>">
                <div class="plc-avatar"><?= e($initial) ?></div>
                <h3><?= e($name) ?></h3>
                <p><?= e($snippet) ?></p>
                <span class="plc-go">Explore community <i class="bi bi-arrow-right"></i></span>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="plc-empty" id="plcEmpty">
            <i class="bi bi-search"></i>
            No community matches your search.
        </div>

    </div>
</section>

<script>
(function () {
    var input = document.getElementById('plcSearch');
    var cards = document.querySelectorAll('#plcGrid .plc-card');
    var count = document.getElementById('plcCount');
    var empty = document.getElementById('plcEmpty');
    if (!input) return;
    input.addEventListener('input', function () {
        var q = input.value.trim().toLowerCase(), shown = 0;
        cards.forEach(function (c) {
            var ok = q === '' || c.getAttribute('data-name').indexOf(q) !== -1;
            c.style.display = ok ? '' : 'none';
            if (ok) shown++;
        });
        count.textContent = shown;
        empty.style.display = shown === 0 ? 'block' : 'none';
    });
})();
</script>
<?php include('footer.php'); return; endif; ?>

<style>
/* Responsive tuning for a single community page (all devices) */
.pl-about-page { overflow-x: hidden; }
.pl-about-page .pl-hero-buttons { display: flex; flex-wrap: wrap; gap: 12px; }
.pl-about-page .pl-intro-grid { align-items: center; }
.pl-about-page .pl-intro-text { align-self: start; }
/* hero: one clean left-aligned block (older centred rules from style.css also match these classes) */
.pl-about-page .pl-about-hero-content { text-align: left; margin: 0; padding: 40px 0; max-width: none; }
.pl-about-page .pl-about-hero-content > p { margin: 0 0 22px; max-width: 590px; }
.pl-about-page .pl-about-hero-content .pl-eyebrow { justify-content: flex-start; }
.pl-about-page .pl-about-hero h1 { margin: 18px 0 18px; }
.pl-about-page .pl-history-image img { object-fit: cover; object-position: center; }
#values .pl-values-grid { grid-template-columns: repeat(4, 1fr); }
#values .pl-intro-text { max-width: 860px; }
@media (max-width: 1024px) {
    #values .pl-values-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .pl-about-page .pl-about-hero-content h1 { font-size: clamp(32px, 9vw, 46px); line-height: 1.12; }
    .pl-about-page .pl-hero-buttons { justify-content: flex-start; }
    .pl-about-page .pl-hero-buttons .pl-about-btn { flex: 1 1 auto; justify-content: center; text-align: center; }
    .pl-about-page .pl-section-title h2, .pl-about-page .pl-history-content h2 { font-size: clamp(26px, 7vw, 34px); }
}
@media (max-width: 560px) {
    #values .pl-values-grid { grid-template-columns: 1fr; }
    .pl-about-page .pl-hero-buttons .pl-about-btn { width: 100%; }
}
</style>

<?php if ($plNext || ($plLoggedUser && !$plOwnComm && ($plLoggedUser['role'] ?? '') !== 'admin')): /* members without a community can always choose this one */ ?>
<div style="background:#e9f8ee;border-bottom:1px solid #b9e6c8">
  <div style="max-width:1240px;margin:0 auto;padding:14px 20px;display:flex;flex-wrap:wrap;gap:12px;align-items:center;justify-content:space-between;font-family:Inter,Arial,sans-serif;color:#17663a">
    <?php if ($plOwnComm && (int)$plOwnComm['id'] !== (int)$cm['id']): ?>
    <span><i class="bi bi-info-circle-fill"></i> Your account belongs to <strong><?= e($plOwnComm['name']) ?></strong>. To change it, please contact support.</span>
    <a href="community-page.php?c=<?= urlencode($plOwnComm['slug']) ?>&amp;next=<?= urlencode($plNext) ?>" style="background:#17663a;color:#fff;border-radius:10px;padding:10px 18px;font-weight:700;text-decoration:none">Go to <?= e($plOwnComm['name']) ?></a>
    <?php elseif ($plOwnComm || !$plLoggedUser || ($plLoggedUser['role'] ?? '') === 'admin'): ?>
    <span><i class="bi bi-check-circle-fill"></i> Your community is <strong><?= e($cm['name']) ?></strong>.</span>
    <a href="<?= e($plNext) ?>" style="background:#17663a;color:#fff;border-radius:10px;padding:10px 18px;font-weight:700;text-decoration:none">Continue to <?= e($plNextLabel) ?> <i class="bi bi-arrow-right"></i></a>
    <?php else: ?>
    <span><i class="bi bi-people-fill"></i> Is <strong><?= e($cm['name']) ?></strong> your community? Your account will be linked to it.</span>
    <form method="post" action="community-page.php?c=<?= urlencode($cm['slug']) ?>&amp;next=<?= urlencode($plNext) ?>" style="margin:0">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="choose" value="1">
      <button type="submit" style="background:#17663a;color:#fff;border:0;border-radius:10px;padding:10px 18px;font-weight:700;cursor:pointer;font-size:15px">Yes, choose <?= e($cm['name']) ?> and continue <i class="bi bi-arrow-right"></i></button>
    </form>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>
<div class="pl-about-page">

    <section class="pl-about-hero">

        <div class="pl-about-container">

            <div class="pl-about-hero-grid">

                <div class="pl-about-hero-content">

                    <span class="pl-eyebrow">
                        <i class="bi bi-buildings-fill"></i>
                        <?= e(strtoupper($cm['name'])) ?>
                    </span>

                    <h1>
                        Our Community.<br>
                        <span>Our Identity.</span>
                        Our Legacy.
                    </h1>

                    <?php foreach ($cm['about_paras'] ?: ['Discover the introduction and history of the ' . $cm['name'] . ' community.'] as $para): ?>
                    <p><?= nl2br(e($para)) ?></p>
                    <?php endforeach; ?>

                    <div class="pl-hero-buttons">

                        <a href="#introduction"
                           class="pl-about-btn pl-primary-btn">
                            Community Introduction
                            <i class="bi bi-arrow-down"></i>
                        </a>

                        <a href="#history"
                           class="pl-about-btn pl-light-btn">
                            Community History
                        </a>

                        <a href="community-home.php?c=<?= urlencode($cm['slug']) ?>"
                           class="pl-about-btn pl-primary-btn">
                            <i class="bi bi-house-door-fill"></i> Community Home
                        </a>
                        <a href="#values"
                           class="pl-about-btn pl-light-btn">
                            Community Values
                        </a>

                    </div>

                </div>


                <div class="pl-about-hero-image">

                    <div class="pl-image-main">

                        <img
                            src="/peoplelink/first/images/in/family-1.jpg?auto=format&fit=crop&w=1200&q=85"
                            alt="<?= e($cm['name']) ?> community">

                    </div>


                    <div class="pl-image-small pl-image-one">

                        <img
                            src="/peoplelink/first/images/in/community-1.jpg?auto=format&fit=crop&w=500&q=85"
                            alt="Community People">

                    </div>


                    <div class="pl-image-small pl-image-two">

                        <img
                            src="/peoplelink/first/images/in/community-2.jpg?auto=format&fit=crop&w=500&q=85"
                            alt="Community Gathering">

                    </div>


                    <div class="pl-hero-badge">

                        <i class="bi bi-heart-fill"></i>

                        <div>
                            <strong>One Community</strong>
                            <span>Many Stories</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <section class="pl-about-intro" id="introduction">

        <div class="pl-about-container">

            <div class="pl-section-title center">

                <span class="pl-eyebrow">
                    <i class="bi bi-people-fill"></i>
                    COMMUNITY INTRODUCTION
                </span>

                <h2>
                    About
                    <span><?= e($cm['name']) ?></span>
                </h2>

            </div>


            <div class="pl-intro-grid">

                <div class="pl-intro-text">

                    <?php foreach ($cm['intro_paras'] ?: ['Introduction for the ' . $cm['name'] . ' community will be added soon.'] as $para): ?>
                    <p><?= nl2br(e($para)) ?></p>
                    <?php endforeach; ?>

                </div>


                <div class="pl-intro-visual">

                    <img
                        src="/peoplelink/first/images/in/community-1.jpg?auto=format&fit=crop&w=1000&q=85"
                        alt="Community Culture">

                    <div class="pl-visual-caption">

                        <i class="bi bi-camera-fill"></i>

                        <span>
                            Preserving memories for generations
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <section class="pl-history-section" id="history">

        <div class="pl-about-container">

            <div class="pl-history-grid">

                <div class="pl-history-image">

                    <img
                        src="/peoplelink/first/images/in/community-3.jpg"
                        alt="Community History">

                    <div class="pl-year-card">

                        <span>OUR</span>

                        <strong>LEGACY</strong>

                        <i class="bi bi-clock-history"></i>

                    </div>

                </div>


                <div class="pl-history-content">

                    <span class="pl-eyebrow">
                        <i class="bi bi-clock-history"></i>
                        COMMUNITY HISTORY
                    </span>

                    <h2>
                        A Journey Built
                        <span>Across Generations</span>
                    </h2>

                    <?php foreach ($cm['history_paras'] ?: ['History of the ' . $cm['name'] . ' community will be added soon.'] as $para): ?>
                    <p><?= nl2br(e($para)) ?></p>
                    <?php endforeach; ?>

                </div>

            </div>

        </div>

    </section>

    <section class="pl-values-section" id="values">

        <div class="pl-about-container">

            <div class="pl-section-title">

                <span class="pl-eyebrow">
                    <i class="bi bi-gem"></i>
                    COMMUNITY VALUES
                </span>

                <h2>
                    What Keeps
                    <span><?= e($cm['name']) ?> Strong</span>
                </h2>

            </div>

            <?php if (!empty($cm['values_paras'])): ?>

            <div class="pl-intro-text">
                <?php foreach ($cm['values_paras'] as $para): ?>
                <p><?= nl2br(e($para)) ?></p>
                <?php endforeach; ?>
            </div>

            <?php else: ?>

            <div class="pl-values-grid">

                <div class="pl-value-card">
                    <div class="pl-value-icon heritage"><i class="bi bi-bank2"></i></div>
                    <span>01</span>
                    <h3>Traditions</h3>
                    <p>Preserving cultural heritage, customs and identity for future generations.</p>
                </div>

                <div class="pl-value-card">
                    <div class="pl-value-icon unity"><i class="bi bi-people-fill"></i></div>
                    <span>02</span>
                    <h3>Social Contribution</h3>
                    <p>Supporting society through service, cooperation and community initiatives.</p>
                </div>

                <div class="pl-value-card">
                    <div class="pl-value-icon growth"><i class="bi bi-graph-up-arrow"></i></div>
                    <span>03</span>
                    <h3>Education &amp; Professional Growth</h3>
                    <p>Encouraging learning, entrepreneurship and career opportunities for members.</p>
                </div>

                <div class="pl-value-card">
                    <div class="pl-value-icon support"><i class="bi bi-hand-thumbs-up-fill"></i></div>
                    <span>04</span>
                    <h3>Community Welfare</h3>
                    <p>Helping families and members through mutual support and shared responsibility.</p>
                </div>

            </div>

            <?php endif; ?>

        </div>

    </section>

    <?php include('community-services.php'); ?>

</div>

<?php include('footer.php'); ?>