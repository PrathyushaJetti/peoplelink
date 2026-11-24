/* PeopleLink website -> backend API helper (same API as the mobile app).
   Pages set window.PL_WEB = {api, csrf, loggedIn, loginUrl} via web_js_boot() in first/_web.php. */
(function () {
  const cfg = window.PL_WEB || {};
  async function post(action, data) {
    const fd = new FormData();
    fd.append('csrf', cfg.csrf || '');
    Object.entries(data || {}).forEach(([k, v]) => fd.append(k, v));
    const res = await fetch((cfg.api || '/peoplelink/matrimoney/api.php') + '?action=' + encodeURIComponent(action), { method: 'POST', body: fd, credentials: 'same-origin' });
    let j = {};
    try { j = await res.json(); } catch (e) { j = { ok: false, error: 'Unexpected server response.' }; }
    if (j.login || j.code === 'AUTH_REQUIRED') { location.href = cfg.loginUrl || '/peoplelink/matrimoney/login.php'; throw new Error('login'); }
    return j;
  }
  function requireLogin() {
    if (cfg.loggedIn) return true;
    location.href = cfg.loginUrl || '/peoplelink/matrimoney/login.php';
    return false;
  }
  function toast(msg, isError) {
    let t = document.getElementById('plToast');
    if (!t) {
      t = document.createElement('div'); t.id = 'plToast'; t.setAttribute('role', 'status');
      t.style.cssText = 'position:fixed;left:50%;bottom:24px;transform:translateX(-50%);z-index:9999;padding:12px 18px;border-radius:10px;font:600 14px/1.4 Inter,system-ui,sans-serif;box-shadow:0 10px 30px rgba(0,0,0,.18);transition:opacity .3s';
      document.body.appendChild(t);
    }
    t.textContent = msg; t.style.background = isError ? '#b42318' : '#0b4f8c'; t.style.color = '#fff'; t.style.opacity = '1';
    clearTimeout(t._h); t._h = setTimeout(() => { t.style.opacity = '0'; }, 2600);
  }
  window.PL = { post, requireLogin, toast, cfg };
})();
