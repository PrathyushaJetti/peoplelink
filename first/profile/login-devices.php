<?php
// Devices where this account is logged in; log out one device or all others.
require_once __DIR__ . '/_account.php';
$pageTitle = 'Login Devices';
$ldFlash = $_SESSION['ld_flash'] ?? null; unset($_SESSION['ld_flash']); $ldError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) $ldError = 'Your session expired. Please try again.';
    elseif (($_POST['op'] ?? '') === 'others') {
        $n = pl_revoke_all_sessions($acUid, true);
        $_SESSION['ld_flash'] = $n ? "Logged out of $n other device(s)." : 'No other devices were logged in.';
        header('Location: login-devices.php'); exit;
    } else {
        $id = (int)($_POST['id'] ?? 0);
        $s = rows('SELECT session_hash FROM user_sessions WHERE id=? AND user_id=?', [$id, $acUid])[0] ?? null;
        if (!$s) $ldError = 'Device not found.';
        else {
            pl_revoke_session($id, $acUid);
            if ($s['session_hash'] === pl_session_hash()) { pl_session_logout(); header('Location: ' . DASHBOARD_URL . 'login.php'); exit; }
            $_SESSION['ld_flash'] = 'Device logged out.';
            header('Location: login-devices.php'); exit;
        }
    }
}
$ldMine = pl_session_hash();
$ldList = pl_active_sessions($acUid);
include __DIR__ . '/header.php';
?>
<main class="pl-settings-page">
  <div class="pl-settings-container" style="max-width:760px">
    <a href="account-settings.php" class="pl-cp-back"><i class="bi bi-arrow-left"></i> Back to Account Settings</a>
    <section class="pl-settings-card" style="margin-top:16px">
      <div class="pl-section-heading pl-cp-head">
        <div class="pl-section-icon blue"><i class="bi bi-laptop"></i></div>
        <div><h2>Login Devices</h2><p>You can be logged in on up to <?= (int)pl_device_limit() ?> devices at the same time.</p></div>
      </div>
      <?php if ($ldFlash): ?><div class="pl-as-alert ok" role="status"><i class="bi bi-check-circle"></i> <?= ac_e($ldFlash) ?></div><?php endif; ?>
      <?php if ($ldError): ?><div class="pl-as-alert err" role="alert"><i class="bi bi-exclamation-circle"></i> <?= ac_e($ldError) ?></div><?php endif; ?>
      <div class="pl-ld-list">
        <?php foreach ($ldList as $s): $cur = $s['session_hash'] === $ldMine; ?>
          <div class="pl-ld-row">
            <i class="bi <?= preg_match('/android|ios|mobile/i', (string)$s['platform']) ? 'bi-phone' : 'bi-laptop' ?>"></i>
            <div class="pl-ld-info">
              <strong><?= ac_e($s['device_name'] ?: 'Unknown device') ?><?= $cur ? ' <span class="pl-ld-cur">This device</span>' : '' ?></strong>
              <span><?= ac_e(trim(($s['platform'] ?: '') . ' · IP ' . ($s['ip'] ?: '-'), ' ·')) ?></span>
              <span>Logged in <?= ac_e(date('d M Y, h:i A', strtotime($s['created_at']))) ?> · last active <?= ac_e(date('d M Y, h:i A', strtotime($s['last_seen_at'] ?? $s['created_at']))) ?></span>
            </div>
            <form method="post" action="login-devices.php">
              <input type="hidden" name="csrf" value="<?= ac_e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
              <button type="submit" class="pl-danger-outline-button"><?= $cur ? 'Log out' : 'Remove' ?></button>
            </form>
          </div>
        <?php endforeach; ?>
        <?php if (!$ldList): ?><p>No active devices.</p><?php endif; ?>
      </div>
      <?php if (count($ldList) > 1): ?>
        <form method="post" action="login-devices.php" style="margin-top:18px">
          <input type="hidden" name="csrf" value="<?= ac_e(csrf_token()) ?>"><input type="hidden" name="op" value="others">
          <button type="submit" class="pl-danger-button">Log out all other devices</button>
        </form>
      <?php endif; ?>
    </section>
  </div>
</main>
<style>
.pl-cp-back{display:inline-flex;align-items:center;gap:8px;color:#1261a8;font-weight:600;text-decoration:none}.pl-cp-back:hover{text-decoration:underline}
.pl-cp-head{display:flex !important;align-items:center;gap:14px;text-align:left !important;justify-content:flex-start !important}.pl-cp-head>div:last-child{text-align:left}
.pl-ld-list{display:grid;gap:12px;margin-top:8px}
.pl-ld-row{display:flex;align-items:center;gap:14px;border:1px solid #e4e8ee;border-radius:14px;padding:14px 16px;flex-wrap:wrap}
.pl-ld-row>i{font-size:26px;color:#1261a8}
.pl-ld-info{flex:1;min-width:200px;display:grid;gap:2px}.pl-ld-info span{color:#667085;font-size:13.5px}
.pl-ld-cur{background:#e9f8ee;color:#17663a;border-radius:20px;padding:2px 10px;font-size:12px;margin-left:6px}
.pl-as-alert{border-radius:12px;padding:14px 18px;margin:0 0 6px;font-weight:600}.pl-as-alert.ok{background:#e9f8ee;color:#17663a;border:1px solid #b9e6c8}.pl-as-alert.err{background:#fdecee;color:#9b1c2c;border:1px solid #f5c2c9}
</style>
<?php include __DIR__ . '/footer.php'; ?>
