<?php
require __DIR__ . '/../components/init.php';
if (!$cid) { header('Location: ' . $F . 'community-page.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/module-4/Frontend/pages/index.php')); exit; }
$pageTitle = 'Search profiles'; $active = 'search'; $scripts = ['india-locations.js', 'search.js'];
include __DIR__ . '/../components/header.php';
$lockedGender = $me && $me['gender'];
?>
<div class="mat-wrap">
  <div class="mat-head">
    <div><span class="mat-eyebrow"><?= e($comm['name']) ?> community</span><h1>Search profiles</h1>
      <p><?= $lockedGender ? 'Showing ' . ($me['gender'] === 'Female' ? 'grooms' : 'brides') . ' from your community.' : 'Only approved profiles are shown.' ?></p></div>
    <button type="button" class="mat-btn ghost mat-filter-toggle" id="filterToggle"><i class="fa-solid fa-sliders"></i> Filters</button>
  </div>
  <div class="mat-grid2">
    <aside class="mat-panel mat-filters closed" id="filterPanel">
      <h2><i class="fa-solid fa-sliders"></i> Filters</h2>
      <form id="filterForm" class="mat-form" novalidate>
        <div class="mat-f"><label for="fq">Name or profile ID</label><input id="fq" name="q" placeholder="e.g. PL-MAT-1007"></div>
        <?php if (!$lockedGender): ?>
        <div class="mat-f"><label for="fg">Looking for</label><select id="fg" name="gender"><option value="">Bride or groom</option><option value="Female">Bride</option><option value="Male">Groom</option></select></div>
        <?php endif; ?>
        <div class="mat-f"><label>Age</label>
          <div style="display:flex;gap:8px"><input name="min_age" type="number" min="18" max="80" placeholder="From" aria-label="Minimum age"><input name="max_age" type="number" min="18" max="80" placeholder="To" aria-label="Maximum age"></div></div>
        <div class="mat-f"><label for="fm">Marital status</label><select id="fm" name="marital_status" data-opts="marital_status"><option value="">Any</option></select></div>
        <div class="mat-f"><label for="fe">Education</label><select id="fe" name="education" data-opts="education"><option value="">Any</option></select></div>
        <div class="mat-f"><label for="fp">Profession</label><select id="fp" name="profession" data-opts="profession"><option value="">Any</option></select></div>
        <div class="mat-f"><label for="fs">State</label><select id="fs" name="state" data-opts="state"><option value="">Any</option></select></div>
        <div class="mat-f"><label for="fc">City</label><select id="fc" name="city" data-opts="city"><option value="">Any</option></select></div>
        <div class="mat-actions"><button class="mat-btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Apply</button><button class="mat-btn ghost" type="reset">Clear</button></div>
      </form>
    </aside>
    <section>
      <div class="mat-toolbar"><strong id="resultCount" aria-live="polite">Loading…</strong>
        <label>Sort <select id="sortBy" aria-label="Sort results"><option value="recent">Newest first</option><option value="age-asc">Age: low to high</option><option value="age-desc">Age: high to low</option><option value="location">Location</option><option value="education">Education</option><option value="profession">Profession</option></select></label></div>
      <div class="mat-cards" id="results"></div>
      <div class="mat-pager" id="pager"></div>
    </section>
  </div>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
