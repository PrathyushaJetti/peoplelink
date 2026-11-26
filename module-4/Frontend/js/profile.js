(function () {
  const { M, get, post, report, busy, modal, closeModal, esc, $, $$, avatar, line, dt, failed } = Mat;
  const id = $("#profileRoot").dataset.id;
  const box = $("#profileBox");
  const REASONS = ["Fake profile", "Fake or misleading photo", "Wrong information", "Asking for money", "Harassment or abusive messages", "Already married", "Inappropriate content", "Other"];

  const fact = (label, v) => (v !== undefined && v !== null && String(v).trim() !== "" ? "<div class='mat-fact'><small>" + esc(label) + "</small><b>" + esc(v) + "</b></div>" : "");

  async function load() {
    const r = await get("profile", { id });
    if (!r.ok) {
      box.innerHTML = r.code === "PROFILE_NOT_FOUND" || r.code === "NOT_FOUND"
        ? Mat.empty("fa-user-slash", "Profile not available", "This profile is not approved, is hidden, or belongs to another community.", "<a class='mat-btn' href='search.php'>Back to search</a>")
        : failed(r, "location.reload()");
      return;
    }
    render(r.profile);
  }

  function actions(p) {
    if (p.is_own) return "<div class='mat-actions'><a class='mat-btn' href='profile-form.php'><i class='fa-solid fa-pen'></i> Edit my profile</a><a class='mat-btn ghost' href='photos.php'><i class='fa-solid fa-images'></i> Manage photos</a></div>";
    if (!M.loggedIn) return "<div class='mat-actions'><a class='mat-btn' href='" + esc(M.loginUrl) + "'><i class='fa-solid fa-right-to-bracket'></i> Login to send interest</a></div>";
    if (!M.me) return "<div class='mat-actions'><a class='mat-btn' href='profile-form.php'><i class='fa-solid fa-user-plus'></i> Create your profile to connect</a></div>";
    const i = p.interest, h = [];
    const saveBtn = "<button class='mat-btn ghost' data-save='" + p.id + "' aria-pressed='" + (p.saved ? "true" : "false") + "'><i class='fa-" + (p.saved ? "solid" : "regular") + " fa-bookmark'></i> " + (p.saved ? "Saved" : "Save") + "</button>";
    if (M.me.status !== "approved") return "<p class='mat-locked'><i class='fa-solid fa-hourglass-half'></i> You can send interests and contact requests once your profile is approved.</p><div class='mat-actions'>" + saveBtn + "</div>";
    if (!i) h.push("<button class='mat-btn' data-act='interest'><i class='fa-solid fa-heart'></i> Send interest</button>");
    else if (i.direction === "sent" && i.status === "sent") h.push("<button class='mat-btn ghost' data-act='withdraw' data-iid='" + i.id + "'><i class='fa-solid fa-rotate-left'></i> Withdraw interest</button>");
    else if (i.direction === "received" && i.status === "sent") h.push("<button class='mat-btn green' data-act='accept' data-iid='" + i.id + "'><i class='fa-solid fa-check'></i> Accept interest</button><button class='mat-btn ghost' data-act='decline' data-iid='" + i.id + "'>Decline</button>");
    else {
      // clear wording for every interest state
      const words = { "sent:sent": ["fa-clock", "Interest sent · waiting for reply"], "sent:accepted": ["fa-circle-check", "They accepted your interest"],
        "received:accepted": ["fa-circle-check", "You accepted their interest"], "sent:rejected": ["fa-circle-xmark", "Your interest was declined"],
        "received:rejected": ["fa-circle-xmark", "You declined their interest"], "sent:withdrawn": ["fa-rotate-left", "You withdrew your interest"] };
      const w = words[i.direction + ":" + i.status] || ["fa-heart", "Interest " + i.status];
      h.push("<span class='mat-tag mat-state " + esc(i.status) + "'><i class='fa-solid " + w[0] + "'></i> " + esc(w[1]) + "</span>");
    }
    h.push(saveBtn);
    return "<div class='mat-actions'>" + h.join("") + "</div>";
  }

  function contact(p) {
    if (p.is_own) return "";
    if (p.contact_visible) {
      return "<div class='mat-contact'><b><i class='fa-solid fa-unlock'></i> Contact details</b><div class='mat-facts'>" +
        fact("Mobile", p.phone || (p.details && (p.details.mobile || p.details.phone)) || "Not added") + fact("Email", p.email || (p.details && p.details.email) || "Not added") + "</div></div>";
    }
    const cr = p.contact_request;
    let btn = "";
    if (!M.loggedIn || !M.me || M.me.status !== "approved") btn = "";
    else if (cr && cr.direction === "sent" && cr.status === "pending") btn = "<p>Your contact request is waiting for a reply.</p><button class='mat-btn ghost sm' data-act='cancel-contact' data-rid='" + cr.id + "'>Cancel request</button>";
    else if (cr && cr.direction === "received" && cr.status === "pending") btn = "<p>This member asked for your contact details.</p><a class='mat-btn sm' href='contacts.php#received'>Answer request</a>";
    else btn = "<button class='mat-btn blue sm' data-act='contact'><i class='fa-solid fa-address-card'></i> Request contact details</button>" + (cr && cr.status === "declined" ? " <small>Your last request was declined.</small>" : "");
    return "<div class='mat-locked'><b><i class='fa-solid fa-lock'></i> Contact details are private</b><p class='mat-hint'>They are shown after your interest is accepted, or when the member approves your contact request (uses one package credit).</p>" + btn + "</div>";
  }

  /* ---------- detail sections (label : value rows, like the printed biodata) ---------- */
  const kv = (label, v, tick) => {
    if (Array.isArray(v)) v = v.filter((x) => String(x).trim() !== "").join(", ");
    if (v === undefined || v === null || String(v).trim() === "") return "";
    const t = tick === true ? "<i class='fa-solid fa-circle-check mat-tick yes' title='Matches you'></i>" : tick === false ? "<i class='fa-regular fa-circle-xmark mat-tick no' title='Does not match you'></i>" : "";
    return "<div class='mat-kv'><span>" + esc(label) + "</span><b>" + esc(v) + "</b>" + t + "</div>";
  };
  const sec = (icon, title, body, extra) => body ? "<section class='mat-psec'><h2><span><i class='fa-solid " + icon + "'></i></span> " + esc(title) + "</h2>" + (extra || "") + body + "</section>" : "";
  const sib = (n, m, one, many) => {
    if (n === undefined || n === null || String(n) === "") return "";
    n = parseInt(n, 10) || 0; m = parseInt(m, 10) || 0;
    if (!n) return "None";
    if (n === 1) return "1 " + one + (m ? " who is married" : " (unmarried)");
    return n + " " + many + (m ? ", " + (m === n ? "all" : m) + " married" : ", unmarried");
  };
  const lines = (a) => a.filter((x) => x && String(x).trim() !== "").join(", ");

  function details(p, d, pr) {
    const his = p.gender === "Female" ? "her" : "his", He = p.gender === "Female" ? "Her" : "His";
    const married = p.marital && p.marital !== "Never Married";
    const about = "<section class='mat-psec'><h2><span><i class='fa-solid fa-user'></i></span> About " + (p.is_own ? "me" : esc(p.name.split(" ")[0])) + "</h2>" +
      "<p class='mat-ptext'>" + (esc(p.intro || d.about_me) || "<span class='mat-hint'>Not added yet.</span>") + "</p>" +
      (d.about_family ? "<h3 class='mat-psub'>About " + (p.is_own ? "my" : his) + " family</h3><p class='mat-ptext'>" + esc(d.about_family) + "</p>" : "") + "</section>";
    const personal = kv("Age", p.age ? p.age + " Years" : "") + kv("Height", p.height) + kv("Weight", d.weight ? d.weight + " Kg" : "") + kv("Body type", d.body_type) +
      kv("Mother tongue", p.mother_tongue) + kv("Spoken languages", d.spoken_languages) + kv("Profile created by", d.profile_created_by) +
      kv("Marital status", lines([p.marital, married ? d.children : ""])) + kv("Lives in", lines([p.city, p.state])) + kv("Eating habits", d.eating_habits) +
      kv("Religion", d.religion) + kv("Caste", p.community) + kv("Sub-caste", p.sub_community) + kv("Gothram", d.gothram);
    const horoscope = kv("Date of birth", p.dob ? dt(p.dob) : "") + kv("Time of birth", d.birth_time) + kv("Place of birth", d.birth_place) +
      kv("Star / Nakshatram", d.star) + kv("Raasi", d.raasi) + kv("Kuja dosham", d.kuja_dosham);
    const career = kv("Education", lines([d.education_detail, p.education])) + kv("Employment", d.employed_in ? d.employed_in + (p.profession ? " – " + p.profession : "") : p.profession) +
      kv("Designation", d.designation) + kv("Company", d.company) + kv("Work location", d.work_location) + kv("Annual income", d.annual_income);
    const family = kv("Father", lines([d.father_name, d.father_occupation])) + kv("Mother", lines([d.mother_name, d.mother_occupation])) +
      kv("Family type", d.family_type) + kv("Family status", d.family_status) + kv("Family values", d.family_values) +
      kv("Brothers", sib(d.brothers, d.brothers_married, "brother", "brothers")) + kv("Sisters", sib(d.sisters, d.sisters_married, "sister", "sisters")) +
      kv("Ancestral origin", d.family_location);
    const life = kv("Cuisine", d.cuisine) + kv("Movies", d.movies) + kv("Music", d.music) + kv("Hobbies", d.hobbies) + kv("Interests", d.interests) +
      kv("Smoking habits", d.smoking) + kv("Drinking habits", d.drinking);
    // partner preferences: a tick shows whether the viewer meets each one
    const pd = (pr && pr.data) || {}, fit = p.pref_match || {};
    const tk = (k) => (p.is_own || !(k in fit) ? undefined : fit[k]);
    const prefs = pr ? kv("Age", pr.age_min || pr.age_max ? (pr.age_min || "18") + " to " + (pr.age_max || "any") + " years" : "", tk("age")) +
      kv("Marital status", pr.marital_status, tk("marital_status")) + kv("Education", pr.education, tk("education")) + kv("Profession", pr.profession, tk("profession")) +
      kv("Mother tongue", pd.partner_mother_tongue, tk("mother_tongue")) + kv("Preferred residing state", pd.partner_states, tk("states")) +
      kv("Preferred residing city", pd.partner_city, tk("city")) + kv("Preferred citizenship", pd.partner_citizenship, tk("citizenship")) +
      kv("Eating habits", pd.partner_eating_habits, tk("eating_habits")) + (pr.other ? "<p class='mat-ptext'>" + esc(pr.other) + "</p>" : "") : "";
    const nFit = Object.keys(fit).length, nYes = Object.values(fit).filter(Boolean).length;
    const fitNote = !p.is_own && nFit ? "<p class='mat-fitnote'><i class='fa-solid fa-heart'></i> You match <b>" + nYes + " of " + nFit + "</b> of " + his + " preferences</p>" : "";
    const common = p.common && Object.keys(p.common).length ? Object.keys(p.common).map((k) => kv(k, p.common[k])).join("") : "";
    // own profile saved before the new fields existed: list what is still missing
    const need = { "Profile created by": d.profile_created_by, "Weight": d.weight, "Body type": d.body_type, "Eating habits": d.eating_habits, "Spoken languages": (d.spoken_languages || []).length ? 1 : "",
      "Religion": d.religion, "Sub-caste": p.sub_community, "Gothram": d.gothram, "Star": d.star, "Raasi": d.raasi, "Kuja dosham": d.kuja_dosham,
      "Father's details": d.father_name && d.father_occupation, "Mother's details": d.mother_name && d.mother_occupation, "Married brothers / sisters": d.brothers_married !== undefined && d.sisters_married !== undefined ? 1 : "",
      "Family status": d.family_status, "Family values": d.family_values, "Native place": d.family_location, "About my family": d.about_family };
    const missing = p.is_own ? Object.keys(need).filter((k) => !need[k] || String(need[k]).trim() === "") : [];
    const todo = missing.length ? "<div class='mat-todo'><i class='fa-solid fa-circle-exclamation'></i><div><b>Complete your profile</b><p>Please add: " + esc(missing.join(", ")) + ".</p></div><a class='mat-btn sm' href='profile-form.php'><i class='fa-solid fa-pen'></i> Add details</a></div>" : "";
    return todo + about +
      sec("fa-id-card", "Personal information", personal) +
      sec("fa-om", "Religion & horoscope", horoscope) +
      sec("fa-graduation-cap", "Education & career", career) +
      sec("fa-house", "Family information", family) +
      sec("fa-mug-hot", "Lifestyle", life) +
      (common ? "<section class='mat-psec mat-both'><h2><span><i class='fa-solid fa-heart'></i></span> Both of you like</h2>" + common + "</section>" : "") +
      sec("fa-heart-circle-check", p.is_own ? "What I am looking for" : He + " partner preferences", prefs || "<p class='mat-hint'>Not added yet.</p>", fitNote);
  }

  function render(p) {
    document.title = p.name + " (" + p.code + ") | PeopleLink Matrimony";
    const d = p.details || {}, pr = p.preferences || {};
    const photos = p.photos || [];
    const main = photos.length ? "<img class='mat-ph' id='mainPhoto' src='" + esc(Mat.imgUrl(photos[0].full_url)) + "' alt='" + esc(p.name) + "'>" : avatar(p);
    const thumbs = photos.length > 1 ? "<div class='mat-thumbs'>" + photos.map((ph, i) => "<img src='" + esc(Mat.imgUrl(ph.thumbnail_url)) + "' data-full='" + esc(Mat.imgUrl(ph.full_url)) + "' class='" + (i ? "" : "on") + "' alt='Photo " + (i + 1) + "'>").join("") + "</div>" : "";
    const siblings = [d.brothers ? d.brothers + " brother(s)" : "", d.sisters ? d.sisters + " sister(s)" : ""].filter(Boolean).join(", ");
    box.innerHTML =
      "<div class='mat-hero'><div><div class='mat-gallery-main'>" + main + "</div>" + thumbs +
      (!photos.length && !p.is_own ? "<p class='mat-hint'><i class='fa-solid fa-lock'></i> Photos are shown as per this member's privacy settings.</p>" : "") + "</div>" +
      "<div class='mat-panel'><span class='mat-eyebrow'>" + esc(p.code) + (p.community ? " · " + esc(p.community) : "") + "</span>" +
      "<h1>" + esc(p.name) + "</h1>" +
      (p.match_percent != null ? "<p><span class='mat-tag accepted'><i class='fa-solid fa-star'></i> " + p.match_percent + "% match with your preferences</span></p>" : "") +
      "<p class='mat-meta'>" + line([p.age ? p.age + " years" : "", p.height, p.marital, p.mother_tongue]) + "</p>" +
      "<p class='mat-meta mat-cap'><i class='fa-solid fa-briefcase'></i> " + line([p.profession, d.designation, d.company]) + "</p>" +
      "<p class='mat-meta mat-cap'><i class='fa-solid fa-location-dot'></i> " + line([p.city, p.district, p.state, p.country]) + "</p>" +
      actions(p) + "<div style='margin-top:16px'>" + contact(p) + "</div>" +
      (!p.is_own && M.loggedIn ? "<div class='mat-actions'><button class='mat-btn danger sm' data-act='report'><i class='fa-solid fa-flag'></i> Report</button><button class='mat-btn ghost sm' data-act='block'><i class='fa-solid fa-ban'></i> " + (p.blocked ? "Unblock" : "Block") + "</button></div>" : "") +
      "</div></div>" +
      details(p, d, pr);

    $$(".mat-thumbs img", box).forEach((t) => t.addEventListener("click", () => {
      $("#mainPhoto").src = t.dataset.full; $$(".mat-thumbs img", box).forEach((x) => x.classList.toggle("on", x === t));
    }));
    bind(p);
  }

  function bind(p) {
    $$("[data-act]", box).forEach((b) => b.addEventListener("click", async () => {
      const a = b.dataset.act;
      if (a === "interest") {
        modal("Send interest to " + p.name, "<form id='iForm' class='mat-form' style='grid-template-columns:1fr'><div class='mat-f'><label for='im'>Message (optional)</label><textarea id='im' maxlength='500' placeholder='Hello, I liked your profile…'></textarea><span class='mat-hint'>Max 500 characters.</span></div><div class='mat-actions'><button class='mat-btn' type='submit'><i class='fa-solid fa-heart'></i> Send interest</button><button class='mat-btn ghost' type='button' data-close>Cancel</button></div></form>");
        $("#iForm").addEventListener("submit", async (e) => {
          e.preventDefault();
          const r = await busy(e.submitter, () => post("send_interest", { profile_id: p.id, message: $("#im").value.trim() }));
          if (report(r)) { closeModal(); load(); }
        });
      } else if (a === "withdraw") {
        if (!(await Mat.ask("Withdraw your interest in " + p.name + "?", "Yes, withdraw", true))) return;
        if (report(await busy(b, () => post("withdraw_interest", { interest_id: b.dataset.iid })))) load();
      } else if (a === "accept" || a === "decline") {
        if (report(await busy(b, () => post("respond_interest", { interest_id: b.dataset.iid, decision: a === "accept" ? "accepted" : "rejected" })))) load();
      } else if (a === "contact") {
        modal("Request contact details", "<p>" + esc(p.name) + " will be asked to share their mobile and email with you. This uses <b>one contact credit</b> from your package; it is returned if the request is declined.</p><form id='cForm'><div class='mat-f'><label for='cm'>Message (optional)</label><textarea id='cm' maxlength='500'></textarea></div><div class='mat-actions'><button class='mat-btn blue' type='submit'>Send request</button><button class='mat-btn ghost' type='button' data-close>Cancel</button></div></form>");
        $("#cForm").addEventListener("submit", async (e) => {
          e.preventDefault();
          const r = await busy(e.submitter, () => post("contact_request", { profile_id: p.id, message: $("#cm").value.trim() }));
          if (r.ok || r.code !== "PACKAGE_REQUIRED") closeModal();
          if (report(r)) load();
        });
      } else if (a === "cancel-contact") {
        if (report(await busy(b, () => post("contact_cancel", { request_id: b.dataset.rid })))) load();
      } else if (a === "report") {
        modal("Report " + p.code, "<form id='rForm' class='mat-form' style='grid-template-columns:1fr' novalidate><div class='mat-f'><label for='rr'>Reason <span class='req'>*</span></label><select id='rr' required data-msg='Please choose a reason.'><option value=''>Choose…</option>" + REASONS.map((x) => "<option>" + x + "</option>").join("") + "</select></div><div class='mat-f'><label for='rd'>Details</label><textarea id='rd' maxlength='200'></textarea></div><label class='mat-check'><input type='checkbox' id='rb'><span><b>Also block this profile</b><small>You will not see each other.</small></span></label><div class='mat-actions'><button class='mat-btn' type='submit'>Submit report</button><button class='mat-btn ghost' type='button' data-close>Cancel</button></div></form>");
        $("#rForm").addEventListener("submit", async (e) => {
          e.preventDefault();
          if (!Mat.validate(e.target)) return;
          const r = await busy(e.submitter, () => post("report_profile", { profile_id: p.id, reason: $("#rr").value, details: $("#rd").value.trim(), also_block: $("#rb").checked ? 1 : "" }));
          if (report(r)) { closeModal(); if ($("#rb").checked) location.href = "search.php"; }
        });
      } else if (a === "block") {
        const block = !p.blocked;
        if (block && !(await Mat.ask("Block " + p.name + "? You will not see each other in search, and pending interests from them are declined.", "Yes, block", true))) return;
        const r = await busy(b, () => post("block_profile", { profile_id: p.id, block: block ? 1 : 0 }));
        if (report(r)) { if (block) location.href = "search.php"; else load(); }
      }
    }));
  }

  load();
})();
