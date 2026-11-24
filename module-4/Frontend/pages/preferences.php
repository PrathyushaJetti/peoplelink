<?php
require __DIR__ . '/../components/init.php';
mat_need_profile();
$pr = pl_prefs((int)$me['id']); $pd = $pr['data'] ?? [];
$val = fn($k, $dk = null) => e($pr[$k] ?? ($dk ? ($pd[$dk] ?? '') : ''));
$multi = function (string $name, array $opts, string $cur) {
    $cur = array_map('trim', explode(',', $cur));
    $h = '';
    foreach ($opts as $o) $h .= '<label class="mat-tag" style="cursor:pointer"><input type="checkbox" name="' . $name . '[]" value="' . e($o) . '"' . (in_array($o, $cur, true) ? ' checked' : '') . '> ' . e($o) . '</label> ';
    return '<div class="mat-actions" style="margin:0">' . $h . '</div>';
};
$pageTitle = 'Partner preferences'; $active = 'me'; $scripts = ['preferences.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap">
  <div class="mat-head"><div><span class="mat-eyebrow">Step <?= isset($_GET['new']) ? '2 of 3' : '' ?></span><h1>Partner preferences</h1><p>Used to calculate the match % shown on profiles. Leave a field empty for “any”.</p></div></div>
  <form id="prefForm" class="mat-panel" novalidate>
    <div class="mat-form">
      <div class="mat-f"><label for="pmin">Age from</label><input id="pmin" name="age_min" type="number" min="18" max="80" value="<?= $val('age_min') ?>"></div>
      <div class="mat-f"><label for="pmax">Age to</label><input id="pmax" name="age_max" type="number" min="18" max="80" value="<?= $val('age_max') ?>"></div>
      <div class="mat-f full"><label>Marital status</label><?= $multi('partner_marital_status', ['Never Married', 'Divorced', 'Widowed', 'Awaiting Divorce'], $pr['marital_status'] ?? '') ?></div>
      <div class="mat-f full"><label>Education</label><?= $multi('partner_education', ['Graduate', 'Post Graduate', 'Doctorate', 'Professional (CA / Medical / Law)', 'Diploma'], $pr['education'] ?? '') ?></div>
      <div class="mat-f"><label for="pprof">Profession</label><input id="pprof" name="partner_profession" maxlength="80" value="<?= $val('profession') ?>" placeholder="e.g. Engineer, Doctor"></div>
      <div class="mat-f"><label for="ploc">Preferred location</label><input id="ploc" name="partner_location" maxlength="120" value="<?= $val('location') ?>" placeholder="e.g. Hyderabad, Telangana"></div>
      <div class="mat-f"><label for="pmt">Mother tongue</label><input id="pmt" name="partner_mother_tongue" maxlength="60" value="<?= e($pd['partner_mother_tongue'] ?? '') ?>" placeholder="e.g. Telugu"></div>
      <div class="mat-f full"><label for="pother">Anything else</label><textarea id="pother" name="other_preferences" maxlength="2000"><?= $val('other') ?></textarea></div>
    </div>
    <div class="mat-actions"><button class="mat-btn" type="submit" data-busy="Saving"><i class="fa-solid fa-floppy-disk"></i> Save preferences</button>
      <a class="mat-btn ghost" href="<?= isset($_GET['new']) ? 'photos.php?new=1' : 'my-profile.php' ?>"><?= isset($_GET['new']) ? 'Skip' : 'Cancel' ?></a></div>
  </form>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
