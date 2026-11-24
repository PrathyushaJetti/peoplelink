(async function () {
  const { get, post, busy, report, esc, $, $$, dt } = Mat;
  const r = await get("me");
  if (!r.ok || !r.profile) { $("#pkgBox").textContent = r.error || "Could not load."; return; }
  $$("[data-k]").forEach((b) => (b.textContent = r.stats[b.dataset.k] ?? 0));
  const c = r.profile.completion;
  $("#compBar").style.width = c.percent + "%";
  $("#compPct").textContent = c.percent + "%";
  $("#compMissing").innerHTML = c.missing.length ? "<p class='mat-hint'>Add these to get more responses:</p><div class='mat-actions'>" +
    c.missing.map((m) => "<a class='mat-tag' href='" + (m === "Photo" ? "photos.php" : m === "Partner preferences" ? "preferences.php" : "profile-form.php") + "'>+ " + esc(m) + "</a>").join("") + "</div>" : "<p>Your profile is complete. 🎉</p>";
  const e = r.entitlement;
  $("#pkgBox").innerHTML = e.active
    ? "<p><b>" + esc(e.packages.map((p) => p.name).join(", ")) + "</b></p><p class='mat-meta'>Valid till " + dt(e.expires_at) + "</p><p class='mat-meta'>Contact requests left: <b>" + (e.remaining === null ? "Unlimited" : e.remaining) + "</b></p><a class='mat-btn ghost sm' href='packages.php'>Details</a>"
    : "<p class='mat-hint'>No active package. A package lets you request contact details.</p><a class='mat-btn sm' href='packages.php'>View packages</a>";

  const t = $("#toggleActive");
  t.addEventListener("click", async () => {
    const show = t.dataset.active !== "1";
    if (!show && !(await Mat.ask("Hide your profile? Others will not find you in search until you show it again.", "Yes, hide it", true))) return;
    const res = await busy(t, () => post("profile_set_active", { active: show ? 1 : 0 }));
    if (report(res)) { t.dataset.active = show ? "1" : "0"; t.textContent = show ? "Hide my profile" : "Show my profile again"; }
  });
})();
