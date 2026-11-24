(function () {
  const { get, post, busy, report, esc, $, ago, empty, failed, pager } = Mat;
  const list = $("#noteList");
  let page = 1;
  const icon = (ev) => ev && ev.includes("interest") ? "fa-heart" : ev && ev.includes("contact") ? "fa-address-book" : ev && (ev.includes("approval") || ev.includes("submitted")) ? "fa-shield-halved" : ev && (ev.includes("expiry") || ev.includes("package")) ? "fa-crown" : "fa-bell";
  const link = (n) => n.event && n.event.includes("interest") ? "interests.php" : n.event && n.event.includes("contact") ? (n.event === "matrimony_contact_request" ? "contacts.php#received" : "contacts.php#sent") : n.event && n.event.includes("expiry") ? "packages.php" : n.event && (n.event.includes("approval") || n.event.includes("submitted")) ? "my-profile.php" : "";

  function setBadge(n) { const b = $("#matUnread"); if (b) { if (n > 0) b.textContent = n; else b.remove(); } }

  async function load() {
    list.innerHTML = "<div class='mat-note mat-skel'><i></i></div>";
    const r = await get("matrimony_notifications", { page, per: 15 });
    if (!r.ok) { list.innerHTML = failed(r, "location.reload()"); return; }
    setBadge(r.unread);
    list.innerHTML = r.notifications.length ? r.notifications.map((n) =>
      "<div class='mat-note" + (n.is_read ? "" : " unread") + "' data-id='" + esc(n.id) + "' data-href='" + link(n) + "' role='button' tabindex='0'><span class='ic'><i class='fa-solid " + icon(n.event) + "'></i></span><div><h4>" + esc(n.title) + "</h4><p>" + esc(n.message) + "</p><time>" + ago(n.created_at) + "</time></div></div>").join("")
      : empty("fa-bell", "No notifications yet", "We will let you know when someone shows interest in you.");
    pager($("#pager"), r.page, r.total_pages, (x) => { page = x; load(); });
  }

  async function open(el) {
    if (el.classList.contains("unread")) {
      const r = await post("matrimony_notification_read", { id: el.dataset.id });
      if (r.ok) { el.classList.remove("unread"); setBadge(r.unread); }
    }
    if (el.dataset.href) location.href = el.dataset.href;
  }
  list.addEventListener("click", (e) => { const n = e.target.closest(".mat-note[data-id]"); if (n) open(n); });
  list.addEventListener("keydown", (e) => { const n = e.target.closest(".mat-note[data-id]"); if (n && (e.key === "Enter" || e.key === " ")) { e.preventDefault(); open(n); } });
  $("#readAll").addEventListener("click", async (e) => { if (report(await busy(e.currentTarget, () => post("matrimony_notification_read", { all: 1 })))) load(); });
  load();
})();
