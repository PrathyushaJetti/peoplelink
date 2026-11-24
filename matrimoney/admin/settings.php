<?php
// Settings stored in the settings table (keys / secrets stay in config.php).
require __DIR__ . '/_boot.php';
$S = $GLOBALS['PL_SETTINGS'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    foreach ($S as $k => [$l, $def, $type]) {
        if ($type === 'bool') $v = empty($_POST[$k]) ? 0 : 1;
        elseif ($type === 'int') $v = max(0, (int)($_POST[$k] ?? $def));
        elseif (str_starts_with($type, 'cats:')) $v = implode(',', array_map('intval', (array)($_POST[$k] ?? [])));
        else $v = mb_substr(trim((string)($_POST[$k] ?? '')), 0, 500);
        pl_setting_set($k, $v);
    }
    pl_audit('settings', null, null, 'Settings updated');
    flash('Settings saved');
    header('Location: ' . pl_ret('settings.php')); exit;
}

function pl_setting_control(string $k, array $def): string {
    [$l, $d, $type] = $def; $v = pl_setting($k);
    if ($type === 'bool') return '<label class="chk"><input type="checkbox" name="' . e($k) . '" value="1"' . ($v ? ' checked' : '') . '> ' . e($l) . '</label>';
    if (str_starts_with($type, 'cats:')) {
        $on = array_filter(explode(',', (string)$v));
        $h = '<label>' . e($l) . '</label><div class="chips">';
        foreach (pl_categories(substr($type, 5), false) as $c) $h .= '<label class="chk"><input type="checkbox" name="' . e($k) . '[]" value="' . (int)$c['id'] . '"' . (in_array((string)$c['id'], $on, true) ? ' checked' : '') . '> ' . e($c['name']) . '</label>';
        return $h . '</div>';
    }
    return '<label>' . e($l) . '</label><input name="' . e($k) . '" value="' . e($v) . '"' . ($type === 'int' ? ' type="number" min="0"' : '') . '>';
}

render_header('Settings', 'auto', $user, $comm); ?>
<div class="grid2 anim">
  <div class="card"><div class="card-h"><h3>General settings</h3></div>
    <form method="post"><?= pl_csrf_field() ?><input type="hidden" name="ret" value="settings.php">
      <?php foreach ($S as $k => $def): ?><div class="mt"><?= pl_setting_control($k, $def) ?></div><?php endforeach; ?>
      <button class="btn btn-primary mt"><?= icon('fa-floppy-disk') ?> Save settings</button></form></div>
  <div class="card"><div class="card-h"><h3>Connections (config.php)</h3></div><div class="kv one">
    <div><span>Razorpay keys</span><b><?= RAZORPAY_KEY_ID !== '' && RAZORPAY_KEY_SECRET !== '' ? badge('approved', 'set') : badge('pending', 'not set') ?></b></div>
    <div><span>Razorpay webhook</span><b><?= RAZORPAY_WEBHOOK_SECRET !== '' ? badge('approved', 'set') : badge('pending', 'not set') ?><br><small><?= e(DASHBOARD_URL . 'razorpay-webhook.php') ?></small></b></div>
    <div><span>FCM push</span><b><?= FCM_SERVICE_ACCOUNT_FILE !== '' && is_file(FCM_SERVICE_ACCOUNT_FILE) ? badge('approved', 'ready') : badge('pending', 'not set') ?></b></div>
    <div><span>SMS provider</span><b><?= SMS_API_URL !== '' ? badge('approved', 'set') : badge('pending', 'not set') ?></b></div>
    <div><span>Upload folder</span><b><?= is_writable(dirname(PL_FILES_DIR)) ? badge('approved', 'writable') : badge('rejected', 'not writable') ?></b></div>
  </div></div>
</div>
<?php render_footer();
