<?php
require_once __DIR__ . '/includes/auth.php';
$error = ''; $next = safe_next($_POST['next'] ?? $_GET['next'] ?? null); $limitHit = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $st = db()->prepare('SELECT * FROM users WHERE email = ?');
    $st->execute([trim($_POST['email'] ?? '')]);
    $u = $st->fetch();
    if ($u && password_verify($_POST['password'] ?? '', $u['password_hash'])) {
        $blocked = pl_login_status_error($u) ?? pl_login_device_check($u, !empty($_POST['logout_oldest']));
        if ($blocked) { $error = $blocked['error']; $limitHit = ($blocked['code'] ?? '') === 'DEVICE_LIMIT'; }
        else {
            pl_session_login($u);
            if ($next) { header('Location: ' . $next); exit; }
            if ($u['role'] === 'member') { // no community yet -> choose one; otherwise their community home
                $hasComm = !empty($u['community_id']);
                header('Location: ' . FRONTEND_URL . ($hasComm ? 'community-home.php' : 'community-page.php?welcome=1')); exit; }
            header('Location: ' . (current_community() ? 'admin/overview.php' : 'select-community.php')); exit;
        }
    } else $error = 'Invalid email or password.';
}
$pageTitle = 'Login'; include __DIR__ . '/includes/auth_top.php'; ?>
<h2>Welcome back</h2><div class="sub">Login to your PeopleLink account.</div>
<?php if (!empty($_GET['reset']) && !$error): ?><div class="alert success">Your password has been changed. Please login with your new password.</div><?php elseif ($next && !$error): ?><div class="auth-note"><i class="fa-solid fa-circle-info"></i> Please login to continue.</div><?php endif; ?>
<?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="next" value="<?= e($next) ?>">
  <label>Email</label><input type="email" name="email" required autocomplete="email" autofocus placeholder="you@example.com" value="<?= e($_POST['email'] ?? '') ?>">
  <label>Password</label><input type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
  <?php if ($limitHit): ?><label><input type="checkbox" name="logout_oldest" value="1" style="width:auto"> Log out my oldest device and continue</label><?php endif; ?>
  <button class="btn btn-primary btn-block">Login</button>
</form>
<div class="auth-help"><a href="forgot-password.php">Forgot your password?</a></div>
<div class="alt">New here? <a href="signup.php<?= $next ? '?next=' . urlencode($next) : '' ?>">Create an account</a></div>
<?php include __DIR__ . '/includes/auth_bottom.php';
