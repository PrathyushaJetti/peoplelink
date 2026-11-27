/* Matrimony sign-up popup, step by step (who the profile is for -> name & birth date -> religion & language -> account).
   Any "Sign up" link on the matrimony pages opens it. After the account is made, the member lands on Create Profile
   with these answers already filled in (server action: mat_register). */
(function () {
  const M = window.MAT || {};
  if (M.loggedIn || !M.api) return;
  const esc = (s) => String(s == null ? "" : s).replace(/[&<>"']/g, (c) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c]));
  const FOR = ["Myself", "My Son", "My Daughter", "My Brother", "My Sister", "My Relative", "My Friend"];
  const fixedGender = { "My Son": "Male", "My Brother": "Male", "My Daughter": "Female", "My Sister": "Female" };
  const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  const yNow = new Date().getFullYear();
  const opts = (arr, ph) => "<option value=''>" + ph + "</option>" + arr.map((v) => "<option value='" + esc(v[0]) + "'>" + esc(v[1]) + "</option>").join("");
  const range = (a, b) => Array.from({ length: b - a + 1 }, (_, i) => a + i);
  let box = null, step = 1;
  const data = {};

  function build() {
    box = document.createElement("div");
    box.className = "ml-back ms-back"; box.hidden = true;
    box.innerHTML =
      "<div class='ml-dlg ms-dlg' role='dialog' aria-modal='true' aria-labelledby='msTitle'>" +
      "<button type='button' class='ml-x' aria-label='Close'><i class='fa-solid fa-xmark'></i></button>" +
      "<img class='ml-logo' src='" + esc(M.logo || "") + "' alt='PeopleLink'>" +
      "<h2 id='msTitle'>Let's set up your account</h2><p class='ml-sub'><span id='msStepTxt'>Step 1 of 4</span></p>" +
      "<div class='ms-progress'><span id='msBar'></span></div>" +
      "<form class='ml-form ms-form' novalidate>" +
      // step 1
      "<div class='ms-step' data-step='1'><b class='ms-q'>This profile is for</b><div class='ms-chips' data-pick='profile_for'>" +
        FOR.map((f) => "<button type='button' data-v='" + f + "'>" + f + "</button>").join("") + "</div>" +
        "<div class='ms-gender' hidden><b class='ms-q'>Gender</b><div class='ms-chips' data-pick='gender'><button type='button' data-v='Male'><i class='fa-solid fa-mars'></i> Male</button><button type='button' data-v='Female'><i class='fa-solid fa-venus'></i> Female</button></div></div></div>" +
      // step 2
      "<div class='ms-step' data-step='2' hidden><b class='ms-q' id='msNameQ'>Full name</b><div class='ml-row'><input name='name' maxlength='100' autocomplete='name' placeholder='First name and last name'></div>" +
        "<b class='ms-q'>Date of birth</b><div class='ms-dob'><select name='dd' aria-label='Day'>" + opts(range(1, 31).map((d) => [String(d).padStart(2, "0"), d]), "Day") + "</select>" +
        "<select name='mm' aria-label='Month'>" + opts(months.map((m, i) => [String(i + 1).padStart(2, "0"), m]), "Month") + "</select>" +
        "<select name='yy' aria-label='Year'>" + opts(range(yNow - 70, yNow - 18).reverse().map((y) => [String(y), y]), "Year") + "</select></div></div>" +
      // step 3
      "<div class='ms-step' data-step='3' hidden><b class='ms-q'>Religion</b><div class='ml-row'><select name='religion'>" + opts(["Hindu", "Muslim", "Christian", "Sikh", "Jain", "Buddhist", "Other"].map((r) => [r, r]), "Select religion").replace("value='Hindu'", "value='Hindu' selected") + "</select></div>" +
        "<b class='ms-q'>Community</b><div class='ml-row'><input value='" + esc(M.community ? M.community.name : "You can choose after signing up") + "' disabled></div>" +
        "<b class='ms-q'>Mother tongue</b><div class='ml-row'><select name='mother_tongue'>" + opts(["Telugu", "Hindi", "Tamil", "Kannada", "Malayalam", "Marathi", "Urdu", "English", "Other"].map((r) => [r, r]), "Select mother tongue") + "</select></div></div>" +
      // step 4
      "<div class='ms-step' data-step='4' hidden><b class='ms-q'>Mobile number</b><div class='ml-row'><span class='ml-cc'>+91</span><input name='phone' type='tel' inputmode='numeric' maxlength='10' autocomplete='tel-national' placeholder='Mobile no.'></div>" +
        "<b class='ms-q'>Email</b><div class='ml-row'><input name='email' type='email' autocomplete='email' placeholder='Email address'></div>" +
        "<b class='ms-q'>Create password</b><div class='ml-row ml-pw'><input name='password' type='password' autocomplete='new-password' placeholder='At least 8 characters, letters and numbers'><button type='button' class='ml-eye' aria-label='Show password'><i class='fa-regular fa-eye'></i></button></div>" +
        "<div class='ml-row'><input name='confirm' type='password' autocomplete='new-password' placeholder='Confirm password'></div>" +
        "<small class='ms-note'><i class='fa-solid fa-lock'></i> Your mobile number is shown only to members you choose to connect with.</small></div>" +
      "<p class='ml-err' role='alert' hidden></p>" +
      "<div class='ms-btns'><button type='button' class='ml-alt ms-back-btn' hidden><i class='fa-solid fa-arrow-left'></i> Back</button><button class='ml-go ms-next' type='submit'>Continue</button></div>" +
      "</form>" +
      "<p class='ml-foot'>Already a member? <a href='#' class='ms-login'>Login <i class='fa-solid fa-angle-right'></i></a></p>" +
      "</div>";
    document.body.appendChild(box);
    const f = box.querySelector("form"), err = box.querySelector(".ml-err");
    const fail = (m) => { err.textContent = m; err.hidden = false; };

    box.querySelectorAll("[data-pick]").forEach((g) => g.addEventListener("click", (e) => {
      const b = e.target.closest("button"); if (!b) return;
      g.querySelectorAll("button").forEach((x) => x.classList.toggle("on", x === b));
      data[g.dataset.pick] = b.dataset.v; err.hidden = true;
      if (g.dataset.pick === "profile_for") {
        const fixed = fixedGender[b.dataset.v];
        box.querySelector(".ms-gender").hidden = !!fixed;
        if (fixed) data.gender = fixed; else { delete data.gender; box.querySelectorAll("[data-pick=gender] button").forEach((x) => x.classList.remove("on")); }
        box.querySelector("#msNameQ").textContent = b.dataset.v === "Myself" ? "Your full name" : "Full name of " + b.dataset.v.replace("My ", "your ").toLowerCase();
        if (fixed) setTimeout(() => go(2), 150);
      } else if (g.dataset.pick === "gender") setTimeout(() => go(2), 150);
    }));
    box.querySelector(".ml-x").addEventListener("click", close);
    box.addEventListener("click", (e) => { if (e.target === box) close(); });
    document.addEventListener("keydown", (e) => { if (e.key === "Escape" && !box.hidden) close(); });
    box.querySelector(".ms-back-btn").addEventListener("click", () => go(step - 1));
    box.querySelector(".ms-login").addEventListener("click", (e) => { e.preventDefault(); close(); if (window.MatLogin) MatLogin.open(location.href); });
    box.querySelector(".ml-eye").addEventListener("click", function () {
      const on = f.password.type === "password"; f.password.type = on ? "text" : "password"; f.confirm.type = f.password.type;
      this.innerHTML = "<i class='fa-regular fa-eye" + (on ? "-slash" : "") + "'></i>";
    });
    f.phone.addEventListener("input", () => (f.phone.value = f.phone.value.replace(/\D/g, "").slice(0, 10)));

    function check(n) {
      if (n === 1) { if (!data.profile_for) return "Please choose who this profile is for."; if (!data.gender) return "Please choose the gender."; }
      if (n === 2) {
        if (f.name.value.trim().length < 2) return "Please enter the full name.";
        if (!f.dd.value || !f.mm.value || !f.yy.value) return "Please choose the date of birth.";
        const d = new Date(+f.yy.value, +f.mm.value - 1, +f.dd.value);
        if (d.getDate() !== +f.dd.value) return "Please choose a valid date of birth.";
        const age = (Date.now() - d.getTime()) / (365.25 * 864e5);
        if (age < 18) return "The person must be at least 18 years old.";
      }
      if (n === 3) { if (!f.religion.value) return "Please choose the religion."; if (!f.mother_tongue.value) return "Please choose the mother tongue."; }
      if (n === 4) {
        if (!/^[6-9]\d{9}$/.test(f.phone.value)) return "Enter a valid 10-digit mobile number.";
        if (!/^\S+@\S+\.\S+$/.test(f.email.value.trim())) return "Enter a valid email address.";
        if (f.password.value.length < 8 || !/[A-Za-z]/.test(f.password.value) || !/\d/.test(f.password.value)) return "Password must be at least 8 characters with letters and numbers.";
        if (f.password.value !== f.confirm.value) return "Password and confirm password do not match.";
      }
      return "";
    }
    function go(n) {
      if (n > step) { const m = check(step); if (m) return fail(m); }
      step = Math.max(1, Math.min(4, n)); err.hidden = true;
      box.querySelectorAll(".ms-step").forEach((s) => (s.hidden = +s.dataset.step !== step));
      box.querySelector("#msStepTxt").textContent = "Step " + step + " of 4";
      box.querySelector("#msBar").style.width = (step * 25) + "%";
      box.querySelector(".ms-back-btn").hidden = step === 1;
      box.querySelector(".ms-next").textContent = step === 4 ? "Create my account" : "Continue";
      const first = box.querySelector(".ms-step[data-step='" + step + "'] input:not([disabled]), .ms-step[data-step='" + step + "'] select");
      if (first && step > 1) first.focus();
    }
    f.addEventListener("submit", async (e) => {
      e.preventDefault();
      if (step < 4) return go(step + 1);
      const m = check(4); if (m) return fail(m);
      const fd = new FormData();
      fd.set("action", "mat_register"); fd.set("csrf", M.csrf || "");
      fd.set("profile_for", data.profile_for); fd.set("gender", data.gender); fd.set("name", f.name.value.trim());
      fd.set("dob", f.yy.value + "-" + f.mm.value + "-" + f.dd.value); fd.set("religion", f.religion.value); fd.set("mother_tongue", f.mother_tongue.value);
      fd.set("phone", f.phone.value); fd.set("email", f.email.value.trim()); fd.set("password", f.password.value); fd.set("confirm", f.confirm.value);
      const btn = box.querySelector(".ms-next"); btn.disabled = true; btn.textContent = "Creating account…";
      let r;
      try { r = await (await fetch(M.api, { method: "POST", body: fd, credentials: "same-origin", headers: { Accept: "application/json" } })).json(); }
      catch (x) { r = { ok: false, error: "Network error. Check your connection and try again." }; }
      btn.disabled = false; btn.textContent = "Create my account";
      if (r && r.ok !== false && !r.error) { location.href = r.next || "profile-form.php?first=1"; return; }
      fail((r && r.error) || "Sign up failed. Please try again.");
    });
    box._go = go;
  }

  function open() {
    if (window.MatLogin && MatLogin.close) MatLogin.close();
    if (!box) build();
    box.hidden = false; document.body.classList.add("mat-noscroll");
    box._go(step);
  }
  function close() { box.hidden = true; document.body.classList.remove("mat-noscroll"); }

  // every sign-up link on the matrimony pages opens the popup
  document.addEventListener("click", (e) => {
    const a = e.target.closest("a[href*='signup.php']");
    if (!a || e.ctrlKey || e.metaKey || e.shiftKey) return;
    let u; try { u = new URL(a.href, location.href); } catch (x) { return; }
    if (!/\/matrimoney\/signup\.php$/.test(u.pathname)) return;
    e.preventDefault(); open();
  }, true);
  window.MatSignup = { open };
})();
