(function () {
  const { post, busy, report, validate, toast, $ } = Mat;
  const form = $("#profileForm"), about = $("#f_about"), cnt = $("#aboutCount");
  const upd = () => (cnt.textContent = about.value.length);
  about.addEventListener("input", upd); upd();
  if (window.plLocationFields) plLocationFields($("#f_state"), $("#f_district"), $("#f_city"));

  const photos = $("#f_photos");
  if (photos) photos.addEventListener("change", () => {
    const bad = Array.from(photos.files).find((f) => f.size > 5 * 1024 * 1024 || !/^image\/(jpeg|png|webp)$/.test(f.type));
    if (photos.files.length > 6) { toast("You can add up to 6 photos.", "err"); photos.value = ""; }
    else if (bad) { toast(bad.name + ": use JPG, PNG or WEBP up to 5 MB.", "err"); photos.value = ""; }
  });

  // Children: only asked when the member has been married before
  const marital = $("#f_marital_status"), kidsWrap = $("#childrenWrap"), kids = $("#f_children");
  const syncKids = () => { const show = !!marital.value && marital.value !== "Never Married"; kidsWrap.hidden = !show; kids.disabled = !show; };
  marital.addEventListener("change", syncKids); syncKids();

  // tick-box groups marked data-req-group need at least one tick
  function groupsOk() {
    let ok = true;
    form.querySelectorAll("[data-req-group]").forEach((g) => {
      const f = g.closest(".mat-f"); f.querySelectorAll(".mat-ferr").forEach((x) => x.remove());
      if (!g.querySelector("input:checked")) {
        ok = false; const m = document.createElement("small"); m.className = "mat-ferr"; m.textContent = g.dataset.reqGroup; f.appendChild(m);
      }
    });
    return ok;
  }
  function siblingsOk() {
    for (const k of ["brothers", "sisters"]) {
      const t = parseInt(form[k].value || "0", 10), m = parseInt(form[k + "_married"].value || "0", 10);
      if (m > t) { toast("Married " + k + " cannot be more than the number of " + k + ".", "err"); form[k + "_married"].focus(); return false; }
    }
    return true;
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const fieldsOk = validate(form), gOk = groupsOk();
    if (!fieldsOk || !gOk) { if (fieldsOk) { toast("Please fix the highlighted fields.", "err"); form.querySelector("[data-req-group] input").focus(); } return; }
    if (!siblingsOk()) return;
    if (/\d{10}/.test(about.value.replace(/\s/g, ""))) { toast("Please remove phone numbers from 'About me'.", "err"); about.focus(); return; }
    const af = $("#f_about_family");
    if (af && /\d{10}/.test(af.value.replace(/\s/g, ""))) { toast("Please remove phone numbers from 'About my family'.", "err"); af.focus(); return; }
    const mode = form.dataset.mode;
    const fd = new FormData(form);
    fd.set("education", fd.get("qualification") || "");
    const r = await busy(e.submitter, () => post(mode === "create" ? "create_profile" : "update_profile", fd));
    if (!report(r)) return;
    if (r.photo_error) toast("Profile saved, but a photo was not uploaded: " + r.photo_error, "err");
    setTimeout(() => (location.href = mode === "create" ? "preferences.php?new=1" : "my-profile.php"), 900);
  });
})();

/* Section menu (side on laptops, step bar on phones) + how much of the required details are filled */
(function () {
  const form = document.getElementById("profileForm"), nav = document.getElementById("pfNav");
  if (!form || !nav) return;
  const cards = Array.from(form.querySelectorAll(".pf-card"));
  nav.innerHTML = "<div class='pf-nav-top'><b>Profile completeness</b><div class='pf-bar'><span id='pfBar'></span></div><small id='pfBarTxt'></small></div>" +
    cards.map((c) => "<a href='#" + c.id + "' data-for='" + c.id + "'><span class='pf-n'>" + c.querySelector(".pf-num").textContent + "</span><span class='pf-t'>" +
      c.querySelector("h2").textContent.trim() + "</span><i class='fa-solid fa-circle-check pf-ok'></i></a>").join("");
  const reqs = (c) => Array.from(c.querySelectorAll("input[required],select[required],textarea[required]")).filter((x) => !x.disabled);
  const groups = (c) => Array.from(c.querySelectorAll("[data-req-group]"));
  function update() {
    let all = 0, done = 0;
    cards.forEach((c) => {
      const r = reqs(c), g = groups(c);
      const ok = r.filter((x) => String(x.value).trim() !== "" && x.checkValidity()).length + g.filter((x) => x.querySelector("input:checked")).length;
      const tot = r.length + g.length; all += tot; done += ok;
      const full = tot > 0 && ok === tot;
      c.classList.toggle("is-done", full);
      const a = nav.querySelector("[data-for='" + c.id + "']"); a.classList.toggle("is-done", full); a.classList.toggle("is-optional", tot === 0);
    });
    const pct = all ? Math.round(done * 100 / all) : 100;
    document.getElementById("pfBar").style.width = pct + "%";
    document.getElementById("pfBarTxt").textContent = pct + "% of required details added";
    const p = document.getElementById("pfPct"); if (p) p.textContent = pct + "%";
  }
  form.addEventListener("input", update); form.addEventListener("change", update); update();
  // highlight the section on screen
  const io = new IntersectionObserver((es) => es.forEach((e) => {
    if (e.isIntersecting) nav.querySelectorAll("a").forEach((a) => a.classList.toggle("on", a.dataset.for === e.target.id));
  }), { rootMargin: "-30% 0px -60% 0px" });
  cards.forEach((c) => io.observe(c));
  nav.addEventListener("click", (e) => {
    const a = e.target.closest("a[data-for]"); if (!a) return;
    e.preventDefault(); const c = document.getElementById(a.dataset.for);
    window.scrollTo({ top: c.getBoundingClientRect().top + window.scrollY - 70, behavior: "smooth" });
  });
})();
