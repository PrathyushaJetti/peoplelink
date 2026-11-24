(function () {
  const { get, post, busy, report, esc, $, dt } = Mat;
  const form = $("#privForm");
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    if (form.profile_visibility.value !== "visible" && !(await Mat.ask("Hide your profile from search?", "Yes, hide it", true))) return;
    report(await busy(e.submitter, () => post("matrimony_privacy_save", new FormData(form))));
  });
  async function blocked() {
    const r = await get("blocked_profiles"), box = $("#blocked");
    if (!r.ok) { box.textContent = r.error; return; }
    box.innerHTML = r.profiles.length ? r.profiles.map((p) => "<div class='mat-check' style='justify-content:space-between'><span><b>" + esc(p.name) + "</b><small>" + esc(p.code) + " · blocked " + dt(p.blocked_at) + "</small></span><button class='mat-btn ghost sm' data-unblock='" + p.id + "'>Unblock</button></div>").join("")
      : "<p class='mat-hint'>You have not blocked anyone.</p>";
  }
  $("#blocked").addEventListener("click", async (e) => {
    const b = e.target.closest("[data-unblock]"); if (!b) return;
    if (report(await busy(b, () => post("block_profile", { profile_id: b.dataset.unblock, block: 0 })))) blocked();
  });
  blocked();
})();
