<?php
// Change password for the logged-in user. Other devices are logged out after a change.
require_once __DIR__ . '/_account.php';
$pageTitle = 'Change Password';
$cpError = null; $cpDone = $_SESSION['cp_flash'] ?? null; unset($_SESSION['cp_flash']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cur = (string)($_POST['current_password'] ?? ''); $new = (string)($_POST['new_password'] ?? ''); $conf = (string)($_POST['confirm_password'] ?? '');
    if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) $cpError = 'Your session expired. Please try again.';
    elseif (!password_verify($cur, (string)$acUser['password_hash'])) $cpError = 'Your current password is wrong.';
    elseif (strlen($new) < 8 || !preg_match('/[A-Za-z]/', $new) || !preg_match('/\d/', $new)) $cpError = 'New password must be at least 8 characters with letters and numbers.';
    elseif ($new !== $conf) $cpError = 'New password and confirm password do not match.';
    elseif (password_verify($new, (string)$acUser['password_hash'])) $cpError = 'New password must be different from the current one.';
    else {
        db()->prepare('UPDATE users SET password_hash=? WHERE id=?')->execute([password_hash($new, PASSWORD_DEFAULT), $acUid]);
        $n = pl_revoke_all_sessions($acUid, true);
        pl_audit('user:password_changed', null, $acUid, 'by user (website)');
        $_SESSION['cp_flash'] = 'Password changed successfully.' . ($n ? " You were logged out of $n other device(s)." : '');
        header('Location: change-password.php'); exit;
    }
}
include __DIR__ . '/header.php';
?>
<main class="pl-settings-page">
  <div class="pl-settings-container" style="max-width:640px">
    <a href="account-settings.php" class="pl-cp-back"><i class="bi bi-arrow-left"></i> Back to Account Settings</a>
    <section class="pl-settings-card" style="margin-top:16px">
      <div class="pl-section-heading pl-cp-head">
        <div class="pl-section-icon blue"><i class="bi bi-key"></i></div>
        <div><h2>Change Password</h2><p>Use at least 8 characters with letters and numbers.</p></div>
      </div>
      <?php if ($cpDone): ?><div class="pl-as-alert ok" role="status"><i class="bi bi-check-circle"></i> <?= ac_e($cpDone) ?></div><?php endif; ?>
      <?php if ($cpError): ?><div class="pl-as-alert err" role="alert"><i class="bi bi-exclamation-circle"></i> <?= ac_e($cpError) ?></div><?php endif; ?>
      <form method="post" action="change-password.php" class="pl-cp-form">
        <input type="hidden" name="csrf" value="<?= ac_e(csrf_token()) ?>">
        <input type="text" name="username" value="<?= ac_e($acUser['email'] ?? '') ?>" autocomplete="username" hidden aria-hidden="true">
        <label for="cpCur">Current password</label>
        <input type="password" id="cpCur" name="current_password" required autocomplete="current-password">
        <label for="cpNew">New password</label>
        <input type="password" id="cpNew" name="new_password" required minlength="8" autocomplete="new-password">
        <label for="cpConf">Confirm new password</label>
        <input type="password" id="cpConf" name="confirm_password" required minlength="8" autocomplete="new-password">
        <div class="pl-modal-actions" style="margin-top:18px">
          <a href="account-settings.php" class="pl-cancel-button">Cancel</a>
          <button type="submit" class="pl-save-button">Change Password</button>
        </div>
      </form>
    </section>
  </div>
</main>
<style>
.pl-cp-back{display:inline-flex;align-items:center;gap:8px;color:#1261a8;font-weight:600;text-decoration:none}.pl-cp-back:hover{text-decoration:underline}
.pl-cp-head{display:flex !important;align-items:center;gap:14px;text-align:left !important;justify-content:flex-start !important}.pl-cp-head>div:last-child{text-align:left}
.pl-cp-form label{display:block;font-weight:600;margin:14px 0 6px;color:#1d2939}
.pl-cp-form input{width:100%;padding:12px 14px;border:1px solid #d6dbe3;border-radius:10px;font-size:15px}
.pl-cp-form input:focus{outline:none;border-color:#1261a8;box-shadow:0 0 0 3px rgba(18,97,168,.15)}
.pl-as-alert{border-radius:12px;padding:14px 18px;margin:0 0 6px;font-weight:600}.pl-as-alert.ok{background:#e9f8ee;color:#17663a;border:1px solid #b9e6c8}.pl-as-alert.err{background:#fdecee;color:#9b1c2c;border:1px solid #f5c2c9}
</style>
<?php include __DIR__ . '/footer.php'; ?>
