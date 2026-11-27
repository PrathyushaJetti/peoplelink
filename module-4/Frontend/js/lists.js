/* Interests, contact requests, saved profiles and visitors pages. The page sets <div id="listPage" data-kind="..."> */
(function () {
  const { get, post, busy, report, esc, $, $$, avatar, line, ago, empty, failed, tabs, card, pager } = Mat;
  const root = $("#listPage"), kind = root.dataset.kind;

  const row = (p, meta, acts, msg) =>
    "<div class='mat-row'><a href='profile.php?id=" + p.id + "'>" + avatar(p) + "</a><div><h3><a href='profile.php?id=" + p.id + "'>" + esc(p.name) + "</a> <small class='mat-code'>" + esc(p.code) + "</small></h3>" +
    "<p class='mat-meta mat-cap'>" + line([p.age ? p.age + " yrs" : "", p.education, p.profession, p.city]) + "</p>" + (meta || "") + (msg ? "<div class='msg'>“" + esc(msg) + "”</div>" : "") + "</div>" +
    "<div class='acts'>" + (acts || "") + "</div></div>";

  async function interests() {
    const r = await get("interests");
    if (!r.ok) { $$("[data-pane]").forEach((p) => (p.innerHTML = failed(r, "location.reload()"))); return; }
    $("#nRecv").textContent = r.received.filter((x) => x.interest_status === "sent").length;
    $("#nSent").textContent = r.sent.length;
    const acc = r.received.concat(r.sent).filter((x) => x.interest_status === "accepted");
    $("#nAcc").textContent = acc.length;
    $("[data-pane=received]").innerHTML = r.received.length ? "<div class='mat-rows'>" + r.received.map((p) => row(p,
      "<span class='mat-tag " + esc(p.interest_status) + "'>" + (p.interest_status === "sent" ? "waiting for you" : esc(p.interest_status)) + "</span> <small>" + ago(p.interest_at) + "</small>",
      p.interest_status === "sent" ? "<button class='mat-btn green sm' data-resp='accepted' data-iid='" + p.interest_id + "'><i class='fa-solid fa-check'></i> Accept</button><button class='mat-btn ghost sm' data-resp='rejected' data-iid='" + p.interest_id + "'>Decline</button>" : "<a class='mat-btn ghost sm' href='profile.php?id=" + p.id + "'>View</a>",
      p.message)).join("") + "</div>" : empty("fa-heart", "No interests received yet", "Complete your profile and add photos to get noticed.", "<a class='mat-btn' href='my-profile.php'>Improve my profile</a>");
    $("[data-pane=sent]").innerHTML = r.sent.length ? "<div class='mat-rows'>" + r.sent.map((p) => row(p,
      "<span class='mat-tag " + esc(p.interest_status) + "'>" + (p.interest_status === "sent" ? "awaiting reply" : esc(p.interest_status)) + "</span> <small>" + ago(p.interest_at) + "</small>",
      (p.interest_status === "sent" ? "<button class='mat-btn ghost sm' data-withdraw='" + p.interest_id + "'>Withdraw</button>" : "") + "<a class='mat-btn ghost sm' href='profile.php?id=" + p.id + "'>View</a>", p.message)).join("") + "</div>"
      : empty("fa-paper-plane", "You have not sent any interest", "Search profiles and send interest to the ones you like.", "<a class='mat-btn' href='search.php'>Search profiles</a>");
    // declined and withdrawn interests, both directions
    const dec = r.received.filter((x) => x.interest_status === "rejected").map((x) => Object.assign({ _who: "you declined" }, x))
      .concat(r.sent.filter((x) => x.interest_status === "rejected").map((x) => Object.assign({ _who: "they declined" }, x)))
      .concat(r.sent.filter((x) => x.interest_status === "withdrawn").map((x) => Object.assign({ _who: "you withdrew" }, x)));
    $("#nDec").textContent = dec.length;
    $("[data-pane=declined]").innerHTML = dec.length ? "<div class='mat-rows'>" + dec.map((p) => row(p, "<span class='mat-tag rejected'>" + esc(p._who) + "</span> <small>" + ago(p.interest_at) + "</small>", "<a class='mat-btn ghost sm' href='profile.php?id=" + p.id + "'>View</a>")).join("") + "</div>"
      : empty("fa-ban", "Nothing here", "Declined and withdrawn interests appear here.");
    $("[data-pane=accepted]").innerHTML = acc.length ? "<div class='mat-rows'>" + acc.map((p) => row(p, "<span class='mat-tag accepted'>connected</span> <small>contact details visible on profile</small>", "<button type='button' class='mat-btn sm' data-contact='" + p.id + "'><i class='fa-solid fa-address-card'></i> View contact</button>")).join("") + "</div>"
      : empty("fa-handshake", "No accepted interests yet", "When an interest is accepted, both of you can see contact details.");
  }

  async function contacts() {
    const r = await get("contact_requests");
    if (!r.ok) { $$("[data-pane]").forEach((p) => (p.innerHTML = failed(r, "location.reload()"))); return; }
    $("#nRecv").textContent = r.received.filter((x) => x.request_status === "pending").length;
    $("#nSent").textContent = r.sent.length;
    $("[data-pane=received]").innerHTML = r.received.length ? "<div class='mat-rows'>" + r.received.map((p) => row(p,
      "<span class='mat-tag " + esc(p.request_status) + "'>" + esc(p.request_status) + "</span> <small>" + ago(p.requested_at) + "</small>",
      p.request_status === "pending" ? "<button class='mat-btn green sm' data-cresp='approved' data-rid='" + p.request_id + "'><i class='fa-solid fa-share'></i> Share contact</button><button class='mat-btn ghost sm' data-cresp='declined' data-rid='" + p.request_id + "'>Decline</button>" : "",
      p.message)).join("") + "</div>" : empty("fa-address-book", "No contact requests", "Members who want your phone number will appear here.");
    $("[data-pane=sent]").innerHTML = r.sent.length ? "<div class='mat-rows'>" + r.sent.map((p) => row(p,
      "<span class='mat-tag " + esc(p.request_status) + "'>" + esc(p.request_status) + "</span> <small>" + ago(p.requested_at) + "</small>" +
      (p.request_status === "approved" ? "<div class='mat-contact' style='margin-top:6px'><i class='fa-solid fa-phone'></i> " + esc(p.phone || "–") + " &nbsp; <i class='fa-solid fa-envelope'></i> " + esc(p.email || "–") + "</div>" : ""),
      p.request_status === "pending" ? "<button class='mat-btn ghost sm' data-ccancel='" + p.request_id + "'>Cancel</button>" : "")).join("") + "</div>"
      : empty("fa-paper-plane", "No requests sent", "Open a profile and tap “Request contact details”.", "<a class='mat-btn' href='search.php'>Search profiles</a>");
  }

  let page = 1;
  async function saved() {
    const box = $("#listBox"); box.innerHTML = Mat.loading(4);
    const r = await get("saved");
    if (!r.ok) { box.innerHTML = failed(r, "location.reload()"); return; }
    box.innerHTML = r.profiles.length ? r.profiles.map((p) => card(p)).join("") : empty("fa-bookmark", "No saved profiles", "Tap Save on any profile to keep it here.", "<a class='mat-btn' href='search.php'>Search profiles</a>");
  }
  document.addEventListener("mat:saved", (e) => { if (kind === "saved" && !e.detail.saved) { const c = $(".mat-card[data-id='" + e.detail.id + "']"); if (c) c.remove(); if (!$(".mat-card")) saved(); } });

  async function visitors() {
    const box = $("#listBox"); box.innerHTML = Mat.loading(3);
    const r = await get("matrimony_visitors", { page, per: 12 });
    if (!r.ok) { box.innerHTML = failed(r, "location.reload()"); return; }
    box.innerHTML = r.profiles.length ? "<div class='mat-rows' style='grid-column:1/-1'>" + r.profiles.map((p) => row(p, "<small>Viewed " + ago(p.last_viewed_at) + (p.views > 1 ? " · " + p.views + " times" : "") + "</small>", "<a class='mat-btn sm' href='profile.php?id=" + p.id + "'>View profile</a>")).join("") + "</div>"
      : empty("fa-eye", "No visitors yet", "Members who open your profile appear here.");
    pager($("#pager"), r.page, r.total_pages, (n) => { page = n; visitors(); });
  }

  root.addEventListener("click", async (e) => {
    const b = e.target.closest("button"); if (!b) return;
    if (b.dataset.contact) { // show the unlocked mobile / email in a popup
      const pr = await busy(b, () => get("profile", { id: b.dataset.contact }));
      if (!pr.ok) { report(pr); return; }
      const p = pr.profile, dd = p.details || {};
      const ph = p.phone || dd.mobile || dd.phone || "", em = p.email || dd.email || "";
      Mat.modal("Contact details · " + p.name, (p.contact_visible
        ? "<div class='mat-facts'>" + (ph ? "<div class='mat-fact'><small>Mobile</small><b><a href='tel:" + esc(ph) + "'>" + esc(ph) + "</a></b></div>" : "") + (em ? "<div class='mat-fact'><small>Email</small><b><a href='mailto:" + esc(em) + "'>" + esc(em) + "</a></b></div>" : "") + "</div>"
        : "<p>Contact details are not shared yet.</p>") +
        "<div class='mat-actions' style='margin-top:16px'><a class='mat-btn' href='profile.php?id=" + p.id + "'><i class='fa-solid fa-user'></i> Open full profile</a><button type='button' class='mat-btn ghost' data-close>Close</button></div>");
      return;
    }
    let r;
    if (b.dataset.resp) r = await busy(b, () => post("respond_interest", { interest_id: b.dataset.iid, decision: b.dataset.resp }));
    else if (b.dataset.withdraw) { if (!(await Mat.ask("Withdraw this interest?", "Yes, withdraw", true))) return; r = await busy(b, () => post("withdraw_interest", { interest_id: b.dataset.withdraw })); }
    else if (b.dataset.cresp) { if (b.dataset.cresp === "approved" && !(await Mat.ask("Share your mobile and email with this member?", "Yes, share"))) return; r = await busy(b, () => post("contact_respond", { request_id: b.dataset.rid, decision: b.dataset.cresp })); }
    else if (b.dataset.ccancel) r = await busy(b, () => post("contact_cancel", { request_id: b.dataset.ccancel }));
    else return;
    if (report(r)) (kind === "interests" ? interests : contacts)();
  });

  if (kind === "interests") { tabs($(".mat-tabs")); interests(); }
  if (kind === "contacts") { tabs($(".mat-tabs")); contacts(); }
  if (kind === "saved") saved();
  if (kind === "visitors") visitors();
})();
