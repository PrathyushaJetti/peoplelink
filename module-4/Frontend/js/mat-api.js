/* PeopleLink Matrimony - shared API client and UI helpers. Talks to matrimoney/api.php (same session + CSRF). */
(function () {
  "use strict";
  const M = window.MAT || {};

  const esc = (v) => String(v == null ? "" : v).replace(/[&<>"']/g, (c) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c]));
  const $ = (s, el) => (el || document).querySelector(s);
  const $$ = (s, el) => Array.from((el || document).querySelectorAll(s));

  async function parse(res) {
    let data;
    try { data = await res.json(); } catch (e) { data = { ok: false, error: "Server returned an invalid response. Please try again.", code: "SERVER_ERROR" }; }
    if (!data.ok) handleCommon(data);
    return data;
  }

  function handleCommon(r) {
    if (r.code === "AUTH_REQUIRED" || r.login) { location.href = M.loginUrl; }
    if (r.code === "CSRF_INVALID") { toast("Your session expired. Reloading…", "err"); setTimeout(() => location.reload(), 1200); }
  }

  async function get(action, params) {
    const q = new URLSearchParams(Object.assign({ action: action }, params || {}));
    try { return await parse(await fetch(M.api + "?" + q.toString(), { credentials: "same-origin", headers: { Accept: "application/json" } })); }
    catch (e) { return { ok: false, error: "Network error. Check your connection and try again.", code: "NETWORK" }; }
  }

  async function post(action, fields) {
    const fd = fields instanceof FormData ? fields : new FormData();
    if (!(fields instanceof FormData)) Object.keys(fields || {}).forEach((k) => { if (fields[k] !== undefined && fields[k] !== null) fd.append(k, fields[k]); });
    fd.set("action", action);
    fd.set("csrf", M.csrf);
    try { return await parse(await fetch(M.api, { method: "POST", body: fd, credentials: "same-origin", headers: { Accept: "application/json" } })); }
    catch (e) { return { ok: false, error: "Network error. Check your connection and try again.", code: "NETWORK" }; }
  }

  let toastTimer;
  function toast(msg, type) {
    const t = $("#matToast"); if (!t) return alert(msg);
    t.className = "mat-toast show " + (type || "ok");
    t.textContent = msg;
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => { t.className = "mat-toast"; }, 4200);
  }

  /* Shows the API result as a toast; adds a link for package errors. Returns r.ok */
  function report(r, okMsg) {
    if (r.ok) { toast(r.message || okMsg || "Done.", "ok"); return true; }
    if (r.code === "PACKAGE_REQUIRED" || r.code === "PACKAGE_LIMIT_REACHED") {
      modal("Package needed", "<p>" + esc(r.error) + "</p><div class='mat-actions'><a class='mat-btn' href='packages.php'><i class='fa-solid fa-crown'></i> View packages</a></div>");
      return false;
    }
    if (r.code === "PROFILE_REQUIRED") {
      modal("Create your profile", "<p>" + esc(r.error) + "</p><div class='mat-actions'><a class='mat-btn' href='profile-form.php'>Create profile</a></div>");
      return false;
    }
    toast(r.error || "Something went wrong.", "err");
    return false;
  }

  /* Disables a button while a request runs */
  async function busy(btn, fn) {
    if (!btn) return fn();
    const old = btn.innerHTML; btn.disabled = true; btn.classList.add("busy");
    btn.innerHTML = "<i class='fa-solid fa-spinner fa-spin'></i> " + (btn.dataset.busy || "Please wait");
    try { return await fn(); } finally { btn.disabled = false; btn.classList.remove("busy"); btn.innerHTML = old; }
  }

  function modal(title, html) {
    const m = $("#matModal");
    $("#matModalTitle").textContent = title;
    $("#matModalBody").innerHTML = html;
    m.hidden = false; document.body.classList.add("mat-noscroll");
    const f = $("input,textarea,select,button:not([data-close])", m); if (f) f.focus();
    return m;
  }
  /* Themed yes/no question instead of the browser confirm(). Resolves true / false. */
  function ask(message, okLabel, danger) {
    return new Promise((resolve) => {
      let answered = false;
      const done = (v) => { if (answered) return; answered = true; obs.disconnect(); closeModal(); resolve(v); };
      modal("Please confirm", "<p style='margin:0 0 18px;font-size:15.5px;line-height:1.6;color:var(--m-dark)'>" + esc(message) + "</p><div class='mat-actions'><button type='button' class='mat-btn" + (danger ? " danger" : "") + "' id='matAskYes'>" + esc(okLabel || "Yes, continue") + "</button><button type='button' class='mat-btn ghost' id='matAskNo'>Cancel</button></div>");
      $("#matAskYes").addEventListener("click", () => done(true));
      $("#matAskNo").addEventListener("click", () => done(false));
      $("#matAskYes").focus();
      // closed with X, Esc or a click outside = No
      const obs = new MutationObserver(() => { if ($("#matModal").hidden) done(false); });
      obs.observe($("#matModal"), { attributes: true, attributeFilter: ["hidden"] });
    });
  }
  function closeModal() { $("#matModal").hidden = true; document.body.classList.remove("mat-noscroll"); }
  document.addEventListener("click", (e) => { if (e.target.matches("[data-close]") || e.target.id === "matModal") closeModal(); });
  document.addEventListener("keydown", (e) => { if (e.key === "Escape" && !$("#matModal").hidden) closeModal(); });

  /* old seed photos are stored relative to first/ (e.g. profile/images/x.png) */
  const imgUrl = (u) => (!u || /^(https?:)?\/\//.test(u) || u.charAt(0) === "/" ? u : "../../../first/" + u);
  const initials = (n) => esc(String(n || "?").trim().split(/\s+/).map((w) => w[0]).slice(0, 2).join("").toUpperCase());
  function avatar(p, cls) {
    return p.photo ? "<img class='" + (cls || "mat-ph") + "' src='" + esc(imgUrl(p.photo)) + "' alt='' loading='lazy' data-ini='" + initials(p.name) + "' onerror='Mat.brokenImg(this)'>"
      : "<div class='" + (cls || "mat-ph") + " mat-ph-none' aria-hidden='true'><span>" + initials(p.name) + "</span><i class='fa-solid fa-lock'></i></div>";
  }
  /* replaces a photo that fails to load with the initials placeholder */
  function brokenImg(img) {
    const d = document.createElement("div");
    d.className = img.className + " mat-ph-none"; d.setAttribute("aria-hidden", "true");
    d.innerHTML = "<span>" + img.dataset.ini + "</span>";
    img.replaceWith(d);
  }
  // joins non-empty parts with " • "; the same word twice (e.g. city and district both "Hyderabad") is shown once
  const line = (arr) => arr.filter((x, i, all) => x && String(x).trim() !== "" && x !== 0 && all.findIndex((y) => y && String(y).trim().toLowerCase() === String(x).trim().toLowerCase()) === i).map(esc).join(" • ");
  const dt = (s) => { if (!s) return ""; const d = new Date(String(s).replace(" ", "T")); return isNaN(d) ? esc(s) : d.toLocaleDateString("en-IN", { day: "numeric", month: "short", year: "numeric" }); };
  const ago = (s) => {
    const d = new Date(String(s).replace(" ", "T")); if (isNaN(d)) return "";
    const m = Math.round((Date.now() - d) / 60000);
    if (m < 1) return "just now"; if (m < 60) return m + " min ago"; const h = Math.round(m / 60); if (h < 24) return h + " h ago"; const dd = Math.round(h / 24); return dd < 30 ? dd + " d ago" : dt(s);
  };

  /* Standard profile card. extra = html for the action area */
  function card(p, extra) {
    const match = p.match_percent != null ? "<span class='mat-match' title='Matches your partner preferences'>" + p.match_percent + "% match</span>" : "";
    return "<article class='mat-card' data-id='" + p.id + "'>" +
      "<a class='mat-card-ph' href='profile.php?id=" + p.id + "'>" + avatar(p) + match + "</a>" +
      "<div class='mat-card-b'>" +
      "<div class='mat-card-top'><h3><a href='profile.php?id=" + p.id + "'>" + esc(p.name) + "</a></h3><span class='mat-code'>" + esc(p.code) + "</span></div>" +
      "<div class='mat-chips'>" + [p.age ? p.age + " yrs" : "", p.height, p.marital].filter(Boolean).map((t) => "<span>" + esc(t) + "</span>").join("") + "</div>" +
      "<p class='mat-meta mat-meta-work'><i class='fa-solid fa-graduation-cap'></i> " + line([p.education, p.profession]) + "</p>" +
      "<p class='mat-meta'><i class='fa-solid fa-location-dot'></i> " + line([p.city, p.state]) + "</p>" +
      (extra || "<div class='mat-card-a'><a class='mat-btn sm' href='profile.php?id=" + p.id + "'>View profile</a>" +
        "<button class='mat-btn sm ghost' data-save='" + p.id + "' aria-pressed='" + (p.saved ? "true" : "false") + "'><i class='fa-" + (p.saved ? "solid" : "regular") + " fa-bookmark'></i> " + (p.saved ? "Saved" : "Save") + "</button></div>") +
      "</div></article>";
  }

  /* Save / unsave buttons anywhere on the page */
  document.addEventListener("click", async (e) => {
    const b = e.target.closest("[data-save]"); if (!b) return;
    e.preventDefault();
    if (!M.loggedIn) { location.href = M.loginUrl; return; }
    const r = await busy(b, () => post("toggle_save", { profile_id: b.dataset.save }));
    if (report(r)) {
      b.setAttribute("aria-pressed", r.saved ? "true" : "false");
      b.innerHTML = "<i class='fa-" + (r.saved ? "solid" : "regular") + " fa-bookmark'></i> " + (r.saved ? "Saved" : "Save");
      document.dispatchEvent(new CustomEvent("mat:saved", { detail: { id: b.dataset.save, saved: r.saved } }));
    }
  });

  function empty(icon, title, text, cta) {
    return "<div class='mat-empty'><i class='fa-solid " + icon + "'></i><h3>" + esc(title) + "</h3><p>" + esc(text) + "</p>" + (cta || "") + "</div>";
  }
  const loading = (n) => Array.from({ length: n || 3 }, () => "<div class='mat-card mat-skel'><div class='mat-card-ph'></div><div class='mat-card-b'><i></i><i></i><i></i></div></div>").join("");
  const failed = (r, retry) => "<div class='mat-empty err'><i class='fa-solid fa-triangle-exclamation'></i><h3>Could not load</h3><p>" + esc(r.error || "Please try again.") + "</p>" + (retry ? "<button class='mat-btn' onclick='" + retry + "'>Retry</button>" : "") + "</div>";

  function pager(el, page, totalPages, go) {
    if (!el) return;
    if (totalPages <= 1) { el.innerHTML = ""; return; }
    let h = "<button class='mat-btn sm ghost' " + (page <= 1 ? "disabled" : "") + " data-p='" + (page - 1) + "'><i class='fa-solid fa-chevron-left'></i> Prev</button>";
    h += "<span>Page " + page + " of " + totalPages + "</span>";
    h += "<button class='mat-btn sm ghost' " + (page >= totalPages ? "disabled" : "") + " data-p='" + (page + 1) + "'>Next <i class='fa-solid fa-chevron-right'></i></button>";
    el.innerHTML = h;
    $$("[data-p]", el).forEach((b) => b.addEventListener("click", () => { go(parseInt(b.dataset.p, 10)); window.scrollTo({ top: 0, behavior: "smooth" }); }));
  }

  /* Tabs: <div class="mat-tabs"><button data-tab="x">..</button></div> + <section data-pane="x"> */
  function tabs(root, onChange) {
    const bs = $$("[data-tab]", root);
    const show = (k) => {
      bs.forEach((b) => b.classList.toggle("on", b.dataset.tab === k));
      $$("[data-pane]").forEach((p) => (p.hidden = p.dataset.pane !== k));
      if (onChange) onChange(k);
      history.replaceState(null, "", "#" + k);
    };
    bs.forEach((b) => b.addEventListener("click", () => show(b.dataset.tab)));
    const start = location.hash.slice(1);
    show(bs.some((b) => b.dataset.tab === start) ? start : bs[0].dataset.tab);
  }

  /* Client-side form validation using HTML5 rules + friendly messages */
  function validate(form) {
    let ok = true;
    $$(".mat-ferr", form).forEach((x) => x.remove());
    $$("[aria-invalid]", form).forEach((x) => x.removeAttribute("aria-invalid"));
    $$("input,select,textarea", form).forEach((f) => {
      if (f.disabled || f.type === "hidden") return;
      if (!f.checkValidity()) {
        ok = false;
        f.setAttribute("aria-invalid", "true");
        const m = document.createElement("small"); m.className = "mat-ferr"; m.textContent = f.dataset.msg || f.validationMessage;
        (f.closest(".mat-f") || f.parentNode).appendChild(m);
      }
    });
    if (!ok) { const first = $("[aria-invalid]", form); if (first) first.focus(); toast("Please fix the highlighted fields.", "err"); }
    return ok;
  }

  window.Mat = { M, ask, brokenImg, imgUrl, esc, $, $$, get, post, toast, report, busy, modal, closeModal, card, avatar, line, dt, ago, empty, loading, failed, pager, tabs, validate, initials };
})();
