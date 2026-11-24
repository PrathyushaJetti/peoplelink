<?php
require_once __DIR__ . '/includes/bridge.php';
require_once __DIR__ . '/includes/password_reset.php';
$error = ''; $next = safe_next($_POST['next'] ?? $_GET['next'] ?? null);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $name = trim($_POST['name'] ?? ''); $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = preg_replace('/\D/', '', (string)($_POST['phone'] ?? '')); $pw = $_POST['password'] ?? '';
    if (strlen($phone) === 12 && str_starts_with($phone, '91')) $phone = substr($phone, 2);
    if (mb_strlen($name) < 2 || mb_strlen($name) > 100) $error = 'Please enter your full name.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Please enter a valid email address.';
    elseif (!preg_match('/^[6-9]\d{9}$/', $phone)) $error = 'Please enter a valid 10-digit mobile number.';
    elseif ($p = pl_password_problem($pw, (string)($_POST['confirm'] ?? ''))) $error = $p;
    else {
        $chk = db()->prepare('SELECT id FROM users WHERE email = ?'); $chk->execute([$email]);
        if ($chk->fetch()) $error = 'This email is already registered. Please login, or use Forgot password.';
        else {
            db()->prepare('INSERT INTO users (name,email,phone,password_hash,role) VALUES (?,?,?,?,?)')
                ->execute([$name, $email, $phone, password_hash($pw, PASSWORD_DEFAULT), SIGNUP_ROLE]);
            pl_session_login(['id' => (int)db()->lastInsertId(), 'role' => SIGNUP_ROLE]);
            // a new member first chooses their community
            header('Location: ' . ($next ?: (SIGNUP_ROLE === 'member' ? FRONTEND_URL . 'community-page.php?welcome=1' : 'select-community.php'))); exit;
        }
    }
}
$pageTitle = 'Sign up'; include __DIR__ . '/includes/auth_top.php'; ?>
<h2>Create your account</h2><div class="sub">Join PeopleLink in a minute.</div>
<?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post" id="signupForm"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="next" value="<?= e($next) ?>">
  <label>Full name</label><input name="name" required maxlength="100" autocomplete="name" value="<?= e($_POST['name'] ?? '') ?>">
  <label>Email</label><input type="email" name="email" required autocomplete="email" value="<?= e($_POST['email'] ?? '') ?>">
  <label>Mobile number</label><input type="tel" name="phone" required inputmode="numeric" maxlength="10" pattern="[6-9][0-9]{9}" placeholder="10-digit mobile number" title="10-digit mobile number" autocomplete="tel" value="<?= e($_POST['phone'] ?? '') ?>">
  <label>Password</label><input type="password" name="password" required minlength="8" autocomplete="new-password">
  <small class="auth-hint">At least 8 characters, with letters and numbers.</small>
  <label>Confirm password</label><input type="password" name="confirm" required autocomplete="new-password">
  <small class="auth-hint" id="pwMatch" hidden></small>
  <button class="btn btn-primary btn-block">Sign up</button>
</form>
<div class="alt">Already have an account? <a href="login.php<?= $next ? '?next=' . urlencode($next) : '' ?>">Login</a></div>
<style>.auth-hint{display:block;margin:-6px 0 12px;color:#64748b;font-size:.82rem}.auth-hint.bad{color:#c0264f}.auth-hint.ok{color:#15803d}</style>
<script>
(function () {
  var f = document.getElementById('signupForm'); if (!f) return;
  var pw = f.password, cf = f.confirm, msg = document.getElementById('pwMatch');
  function check() {
    if (!cf.value) { msg.hidden = true; cf.setCustomValidity(''); return; }
    var same = pw.value === cf.value;
    msg.hidden = false; msg.className = 'auth-hint ' + (same ? 'ok' : 'bad');
    msg.textContent = same ? 'Passwords match.' : 'Passwords do not match.';
    cf.setCustomValidity(same ? '' : 'Passwords do not match.');
  }
  pw.addEventListener('input', check); cf.addEventListener('input', check);
  f.phone.addEventListener('input', function () { this.value = this.value.replace(/\D/g, '').slice(0, 10); });
})();
</script>
<?php include __DIR__ . '/includes/auth_bottom.php';
