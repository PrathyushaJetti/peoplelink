<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($pageTitle) ?> | PeopleLink</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="assets/style.css">
<style>
/* login / signup polish */
.auth-art .brand a{display:inline-block;background:#fff;border-radius:16px;padding:10px 16px;box-shadow:0 10px 30px rgba(0,0,0,.18)}
.auth-art .brand .logo{height:84px;width:auto;display:block;background:none;box-shadow:none;padding:0;border-radius:0}
.auth-points{list-style:none;padding:0;margin:22px 0 0;display:grid;gap:10px}.auth-points li{display:flex;gap:10px;align-items:center;opacity:.95}
.auth-points i{width:30px;height:30px;border-radius:50%;background:rgba(255,255,255,.16);display:grid;place-items:center;font-size:.85rem}
.auth-form{position:relative;flex-direction:column}
.auth-back{position:absolute;top:26px;left:32px;color:var(--muted);font-weight:600;font-size:.92rem;text-decoration:none;display:inline-flex;gap:8px;align-items:center}.auth-back:hover{color:var(--blue)}
.auth-mobile-logo{display:none;margin:0 0 22px}.auth-mobile-logo img{height:56px}
.pw-wrap{position:relative}.pw-wrap input{padding-right:46px}
.pw-toggle{position:absolute;right:8px;top:50%;transform:translateY(-50%);border:0;background:transparent;color:var(--muted);cursor:pointer;padding:8px;font-size:1rem}.pw-toggle:hover{color:var(--blue)}
.auth-note{background:#eaf3fc;color:#0b4f8c;border:1px solid #c3dcf5;border-radius:10px;padding:10px 14px;font-size:.9rem;margin-bottom:16px}
.auth-help{text-align:center;margin-top:10px;font-size:.85rem;color:var(--muted)}.auth-help a{color:var(--blue);font-weight:600}
@media (max-width:900px){.auth-mobile-logo{display:block}.auth-back{position:static;margin:0 0 18px;align-self:flex-start}.auth-form{justify-content:flex-start;padding-top:28px}}
</style></head><body>
<div class="auth">
  <div class="auth-art">
    <div class="brand"><a href="<?= e(FRONTEND_URL) ?>index.php" aria-label="PeopleLink home"><img class="logo" src="<?= LOGO_URL ?>" alt="PeopleLink"></a></div>
    <div><h1>Your community.<br>Your connections.</h1><p>Matrimony, family, jobs, marketplace and more — all for your community, in one place.</p>
      <ul class="auth-points"><li><i class="fa-solid fa-shield-halved"></i> Your details stay private until you choose to share</li><li><i class="fa-solid fa-users"></i> Connect only within your own community</li><li><i class="fa-solid fa-circle-check"></i> Every profile is checked by our team</li></ul></div>
    <small class="tag">Connect • Discover • Belong</small>
  </div>
  <div class="auth-form">
  <a class="auth-back" href="<?= e(FRONTEND_URL) ?>index.php"><i class="fa-solid fa-arrow-left"></i> Back to website</a>
  <div class="auth-card">
  <div class="auth-mobile-logo"><a href="<?= e(FRONTEND_URL) ?>index.php"><img src="<?= LOGO_URL ?>" alt="PeopleLink"></a></div>
