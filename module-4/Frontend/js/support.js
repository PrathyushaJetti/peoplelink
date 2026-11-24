(function () {
  const { get, post, busy, report, validate, esc, $, dt, modal } = Mat;
  const form = $("#supForm");
  async function tickets() {
    const r = await get("my_support_requests"), box = $("#tickets");
    if (!r.ok) { box.textContent = r.error; return; }
    box.innerHTML = r.requests.length ? r.requests.map((t) => "<div class='mat-check' style='display:block'><b>" + esc(t.ticket) + " · " + esc(t.title) + "</b><small>" + esc(t.category) + " · " + dt(t.created_at) + "</small> <span class='mat-tag " + esc(t.status) + "'>" + esc(t.status) + "</span></div>").join("")
      : "<p class='mat-hint'>No requests yet.</p>";
  }
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    if (!validate(form)) return;
    const r = await busy(e.submitter, () => post("support_request", new FormData(form)));
    if (report(r)) { form.reset(); modal("Request submitted", "<p>Your ticket number is <b>" + esc(r.ticket) + "</b>. Our team will contact you.</p><div class='mat-actions'><button class='mat-btn' data-close>OK</button></div>"); tickets(); }
  });
  tickets();
})();
