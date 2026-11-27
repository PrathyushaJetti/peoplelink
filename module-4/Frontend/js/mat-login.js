/* Matrimony login popup: any "Login" link on the matrimony pages opens this instead of leaving the page.
   Mobile number + password, or email + password (same accounts as the main login page). */
(function () {
  const M = window.MAT || {};
  if (M.loggedIn || !M.api) return;
  const esc = (s) => String(s == null ? "" : s).replace(/[&<>"']/g, (c) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c]));
  let next = "", box = null;

  function build() {
    box = document.createElement("div");
    box.className = "ml-back"; box.hidden = true;
    box.innerHTML =
      "<div class='ml-dlg' role='dialog' aria-modal='true' aria-labelledby='mlTitle'>" +
      "<button type='button' class='ml-x' aria-label='Close'><i class='fa-solid fa-xmark'></i></button>" +
      "<img class='ml-logo' src='" + esc(M.logo || "") + "' alt='PeopleLink'>" +
      "<h2 id='mlTitle'>Welcome back</h2><p class='ml-sub'>Enter your details to continue</p>" +
      "<form class='ml-form' novalidate>" +
      "<div class='ml-row' data-view='mobile'><span class='ml-cc'>+91</span><input name='phone' type='tel' inputmode='numeric' maxlength='10' autocomplete='tel-national' placeholder='Mobile no.' aria-label='Mobile number'></div>" +
      "<div class='ml-row' data-view='email' hidden><input name='email' type='email' autocomplete='email' placeholder='Email address' aria-label='Email address'></div>" +
      "<div class='ml-row ml-pw'><input name='password' type='password' autocomplete='current-password' placeholder='Password' aria-label='Password'><button type='button' class='ml-eye' aria-label='Show password'><i class='fa-regular fa-eye'></i></button></div>" +
      "<label class='ml-dev' hidden><input type='checkbox' name='logout_oldest' value='1'> Log out my oldest device and continue</label>" +
      "<p class='ml-err' role='alert' hidden></p>" +
      "<button class='ml-go' type='submit'>Login</button>" +
      "<a class='ml-forgot' href='" + esc(M.forgotUrl || "#") + "'>Forgot password?</a>" +
      "</form>" +
      "<div class='ml-or'><span>Or</span></div>" +
      "<button type='button' class='ml-alt' data-switch='email'><i class='fa-solid fa-envelope'></i> Continue with Email</button>" +
      "<button type='button' class='ml-alt' data-switch='mobile' hidden><i class='fa-solid fa-mobile-screen-button'></i> Continue with Mobile number</button>" +
      "<p class='ml-foot'>Don't have an account? <a class='ml-signup' href='#'>Sign Up Free <i class='fa-solid fa-angle-right'></i></a></p>" +
      "</div>";
    document.body.appendChild(box);
    const f = box.querySelector("form"), err = box.querySelector(".ml-err");
    const show = (v) => {
      box.dataset.view = v;
      box.querySelectorAll("[data-view]").forEach((x) => (x.hidden = x.dataset.view !== v));
      box.querySelectorAll("[data-switch]").forEach((x) => (x.hidden = x.dataset.switch === v));
      err.hidden = true; (v === "mobile" ? f.phone : f.email).focus();
    };
    box.querySelectorAll("[data-switch]").forEach((b) => b.addEventListener("click", () => show(b.dataset.switch)));
    box.querySelector(".ml-x").addEventListener("click", close);
    box.addEventListener("click", (e) => { if (e.target === box) close(); });
    document.addEventListener("keydown", (e) => { if (e.key === "Escape" && !box.hidden) close(); });
    box.querySelector(".ml-eye").addEventListener("click", function () {
      const on = f.password.type === "password"; f.password.type = on ? "text" : "password";
      this.innerHTML = "<i class='fa-regular fa-eye" + (on ? "-slash" : "") + "'></i>";
    });
    f.phone.addEventListener("input", () => (f.phone.value = f.phone.value.replace(/\D/g, "").slice(0, 10)));
    f.addEventListener("submit", async (e) => {
      e.preventDefault();
      const v = box.dataset.view, fail = (m) => { err.textContent = m; err.hidden = false; };
      if (v === "mobile" && !/^[6-9]\d{9}$/.test(f.phone.value)) return fail("Enter your 10-digit mobile number.");
      if (v === "email" && !/^\S+@\S+\.\S+$/.test(f.email.value.trim())) return fail("Enter a valid email address.");
      if (!f.password.value) return fail("Enter your password.");
      const fd = new FormData();
      fd.set("action", "login");
      if (v === "mobile") fd.set("phone", f.phone.value); else fd.set("email", f.email.value.trim());
      fd.set("password", f.password.value);
      if (f.logout_oldest.checked) fd.set("logout_oldest", "1");
      const btn = box.querySelector(".ml-go"); btn.disabled = true; btn.textContent = "Logging in…";
      let r;
      try { r = await (await fetch(M.api, { method: "POST", body: fd, credentials: "same-origin", headers: { Accept: "application/json" } })).json(); }
      catch (x) { r = { ok: false, error: "Network error. Check your connection and try again." }; }
      btn.disabled = false; btn.textContent = "Login";
      if (r && r.ok !== false && !r.error) { location.href = next || location.href; return; }
      if (r.code === "DEVICE_LIMIT") box.querySelector(".ml-dev").hidden = false;
      fail(r.error || "Login failed. Please try again.");
    });
  }

  function open(nextUrl) {
    if (!box) build();
    next = nextUrl || location.href;
    box.querySelector(".ml-signup").href = (M.signupUrl || "#").replace("__NEXT__", encodeURIComponent(next));
    box.hidden = false; document.body.classList.add("mat-noscroll");
    box.dataset.view || (box.dataset.view = "mobile");
    (box.dataset.view === "email" ? box.querySelector("[name=email]") : box.querySelector("[name=phone]")).focus();
  }
  function close() { box.hidden = true; document.body.classList.remove("mat-noscroll"); }

  // every link to the login page opens the popup (keeps its ?next=)
  document.addEventListener("click", (e) => {
    const a = e.target.closest("a[href*='login.php']");
    if (!a || e.ctrlKey || e.metaKey || e.shiftKey) return;
    let u; try { u = new URL(a.href, location.href); } catch (x) { return; }
    if (!/\/matrimoney\/login\.php$/.test(u.pathname)) return;
    e.preventDefault();
    open(u.searchParams.get("next") || "");
  });
  window.MatLogin = { open, close: () => { if (box && !box.hidden) close(); } };
})();
