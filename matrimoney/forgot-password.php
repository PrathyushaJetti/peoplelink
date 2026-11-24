<?php
// Forgot password: asks for the email and sends a one-time reset link.
require_once __DIR__ . '/includes/bridge.php';
require_once __DIR__ . '/includes/password_reset.php';
pl_ensure_schema();

$sent = false; $error = ''; $devLink = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $email = trim((string)($_POST['email'] ?? ''));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Please enter a valid email address.';
    else {
        $link = pl_reset_request($email);
        $sent = true; // same message whether or not the account exists, so nobody can check which emails are registered
        if ($link && pl_reset_is_local()) $devLink = $link; // no mail server on XAMPP: show the link for local testing only
    }
}
$pageTitle = 'Forgot Password'; include __DIR__ . '/includes/auth_top.php'; ?>
<h2>Forgot password?</h2><div class="sub">Enter the email of your account. We will send you a link to set a new password.</div>
<?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<?php if ($sent): ?>
  <div class="alert success">If an account exists for that email, a password reset link has been sent. The link works for <?= PL_RESET_MINUTES ?> minutes.</div>
  <?php if ($devLink): ?>
  <div class="auth-note" style="background:#fff8e6;border-color:#f5d48a;color:#7a5200">
    <strong>Local testing only:</strong> this computer has no mail server, so here is the link that would be emailed.
    <a href="<?= e($devLink) ?>" style="display:block;margin-top:8px;font-weight:700;word-break:break-all">Open reset link</a>
  </div>
  <?php endif; ?>
  <div class="alt"><a href="login.php">Back to login</a></div>
<?php else: ?>
<form method="post"><input type="hidden" name="csrf" value="<?= csrf_token() ?>">
  <label>Email</label><input type="email" name="email" required autofocus autocomplete="email" placeholder="you@example.com" value="<?= e($_POST['email'] ?? '') ?>">
  <button class="btn btn-primary btn-block">Send reset link</button>
</form>
<div class="alt">Remembered it? <a href="login.php">Back to login</a></div>
<?php endif; ?>
<?php include __DIR__ . '/includes/auth_bottom.php';
