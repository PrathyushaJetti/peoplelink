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
        <div class="mat-f"><label>Height</label>
          <div style="display:flex;gap:8px"><select name="min_height_in" aria-label="Minimum height"><option value="">From</option><option value="54">4' 6&quot;</option><option value="55">4' 7&quot;</option><option value="56">4' 8&quot;</option><option value="57">4' 9&quot;</option><option value="58">4' 10&quot;</option><option value="59">4' 11&quot;</option><option value="60">5' 0&quot;</option><option value="61">5' 1&quot;</option><option value="62">5' 2&quot;</option><option value="63">5' 3&quot;</option><option value="64">5' 4&quot;</option><option value="65">5' 5&quot;</option><option value="66">5' 6&quot;</option><option value="67">5' 7&quot;</option><option value="68">5' 8&quot;</option><option value="69">5' 9&quot;</option><option value="70">5' 10&quot;</option><option value="71">5' 11&quot;</option><option value="72">6' 0&quot;</option><option value="73">6' 1&quot;</option><option value="74">6' 2&quot;</option><option value="75">6' 3&quot;</option><option value="76">6' 4&quot;</option><option value="77">6' 5&quot;</option><option value="78">6' 6&quot;</option><option value="79">6' 7&quot;</option><option value="80">6' 8&quot;</option><option value="81">6' 9&quot;</option><option value="82">6' 10&quot;</option><option value="83">6' 11&quot;</option><option value="84">7' 0&quot;</option></select><select name="max_height_in" aria-label="Maximum height"><option value="">To</option><option value="54">4' 6&quot;</option><option value="55">4' 7&quot;</option><option value="56">4' 8&quot;</option><option value="57">4' 9&quot;</option><option value="58">4' 10&quot;</option><option value="59">4' 11&quot;</option><option value="60">5' 0&quot;</option><option value="61">5' 1&quot;</option><option value="62">5' 2&quot;</option><option value="63">5' 3&quot;</option><option value="64">5' 4&quot;</option><option value="65">5' 5&quot;</option><option value="66">5' 6&quot;</option><option value="67">5' 7&quot;</option><option value="68">5' 8&quot;</option><option value="69">5' 9&quot;</option><option value="70">5' 10&quot;</option><option value="71">5' 11&quot;</option><option value="72">6' 0&quot;</option><option value="73">6' 1&quot;</option><option value="74">6' 2&quot;</option><option value="75">6' 3&quot;</option><option value="76">6' 4&quot;</option><option value="77">6' 5&quot;</option><option value="78">6' 6&quot;</option><option value="79">6' 7&quot;</option><option value="80">6' 8&quot;</option><option value="81">6' 9&quot;</option><option value="82">6' 10&quot;</option><option value="83">6' 11&quot;</option><option value="84">7' 0&quot;</option></select></div></div>
        <div class="mat-f"><label for="fm">Marital status</label><select id="fm" name="marital_status" data-opts="marital_status"><option value="">Any</option></select></div>
        <div class="mat-f"><label for="fe">Education</label><select id="fe" name="education" data-opts="education"><option value="">Any</option></select></div>
        <div class="mat-f"><label for="fp">Profession</label><select id="fp" name="profession" data-opts="profession"><option value="">Any</option></select></div>
        <div class="mat-f"><label for="fs">State</label><select id="fs" name="state" data-opts="state"><option value="">Any</option></select></div>
        <div class="mat-f"><label for="fc">City</label><select id="fc" name="city" data-opts="city"><option value="">Any</option></select></div>
        <div class="mat-f"><label for="fmt">Mother tongue</label><select id="fmt" name="mother_tongue" data-opts="mother_tongue"><option value="">Any</option></select></div>
        <div class="mat-f"><label for="fstar">Star / Nakshatram</label><select id="fstar" name="star"><option value="">Any</option><option value="Ashwini">Ashwini</option><option value="Bharani">Bharani</option><option value="Krittika">Krittika</option><option value="Rohini">Rohini</option><option value="Mrigashira">Mrigashira</option><option value="Ardra">Ardra</option><option value="Punarvasu">Punarvasu</option><option value="Pushya">Pushya</option><option value="Ashlesha">Ashlesha</option><option value="Magha">Magha</option><option value="Purva Phalguni (Pubba)">Purva Phalguni (Pubba)</option><option value="Uttara Phalguni (Uttara)">Uttara Phalguni (Uttara)</option><option value="Hasta">Hasta</option><option value="Chitra">Chitra</option><option value="Swati">Swati</option><option value="Vishakha">Vishakha</option><option value="Anuradha">Anuradha</option><option value="Jyeshtha">Jyeshtha</option><option value="Mula">Mula</option><option value="Purva Ashadha">Purva Ashadha</option><option value="Uttara Ashadha">Uttara Ashadha</option><option value="Shravana">Shravana</option><option value="Dhanishta">Dhanishta</option><option value="Shatabhisha">Shatabhisha</option><option value="Purva Bhadrapada">Purva Bhadrapada</option><option value="Uttara Bhadrapada">Uttara Bhadrapada</option><option value="Revati">Revati</option></select></div>
        <div class="mat-f"><label for="fkuja">Kuja dosham</label><select id="fkuja" name="kuja_dosham"><option value="">Any</option><option value="No">No</option><option value="Yes">Yes</option><option value="Don&#039;t know">Don&#039;t know</option></select></div>
        <div class="mat-f"><label for="feat">Eating habits</label><select id="feat" name="eating_habits"><option value="">Any</option><option value="Vegetarian">Vegetarian</option><option value="Non-vegetarian">Non-vegetarian</option><option value="Eggetarian">Eggetarian</option><option value="Vegan">Vegan</option></select></div>
        <div class="mat-f"><label for="finc">Annual income</label><select id="finc" name="annual_income"><option value="">Any</option><option value="Below ₹3 Lakh">Below ₹3 Lakh</option><option value="₹3 – 5 Lakh">₹3 – 5 Lakh</option><option value="₹5 – 10 Lakh">₹5 – 10 Lakh</option><option value="₹10 – 20 Lakh">₹10 – 20 Lakh</option><option value="₹20 – 50 Lakh">₹20 – 50 Lakh</option><option value="Above ₹50 Lakh">Above ₹50 Lakh</option></select></div>
        <div class="mat-f"><label for="fsmk">Smoking</label><select id="fsmk" name="smoking"><option value="">Any</option><option value="Never smokes">Never smokes</option><option value="Occasionally">Occasionally</option></select></div>
        <div class="mat-f"><label for="fdrk">Drinking</label><select id="fdrk" name="drinking"><option value="">Any</option><option value="Never drinks">Never drinks</option><option value="Occasionally">Occasionally</option></select></div>
        <div class="mat-f"><label for="fph">Photo</label><select id="fph" name="with_photo"><option value="">Any</option><option value="With photo only">With photo only</option></select></div>
        <div class="mat-f"><label for="fjn">Joined</label><select id="fjn" name="joined"><option value="">Any</option><option value="Today">Today</option><option value="In the last week">In the last week</option><option value="In the last month">In the last month</option></select></div>
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
