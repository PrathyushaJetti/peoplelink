<?php
// Reset password: opened from the emailed link (?token=...). Sets a new password and logs out every device.
require_once __DIR__ . '/includes/bridge.php';
require_once __DIR__ . '/includes/password_reset.php';
pl_ensure_schema();

$token = (string)($_POST['token'] ?? $_GET['token'] ?? '');
$r = pl_reset_find($token);
$error = '';
if ($r && $_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $error = pl_password_problem((string)($_POST['password'] ?? ''), (string)($_POST['confirm'] ?? '')) ?? '';
    if ($error === '') {
        pl_reset_complete($r, (string)$_POST['password']);
        header('Location: login.php?reset=1'); exit;
    }
}
$pageTitle = 'Reset Password'; include __DIR__ . '/includes/auth_top.php'; ?>
<?php if (!$r): ?>
  <h2>Link expired</h2><div class="sub">This password reset link is not valid any more. Links work once and only for <?= PL_RESET_MINUTES ?> minutes.</div>
  <a class="btn btn-primary btn-block" href="forgot-password.php">Get a new link</a>
  <div class="alt"><a href="login.php">Back to login</a></div>
<?php else: ?>
  <h2>Set a new password</h2><div class="sub">For <?= e($r['name']) ?>. Use at least 8 characters with letters and numbers.</div>
  <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
  <form method="post"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="token" value="<?= e($token) ?>">
    <label>New password</label><input type="password" name="password" required minlength="8" autofocus autocomplete="new-password" placeholder="New password">
    <label>Confirm new password</label><input type="password" name="confirm" required minlength="8" autocomplete="new-password" placeholder="Type it again">
    <button class="btn btn-primary btn-block">Save new password</button>
  </form>
  <div class="alt"><a href="login.php">Back to login</a></div>
<?php endif; ?>
<?php include __DIR__ . '/includes/auth_bottom.php';
