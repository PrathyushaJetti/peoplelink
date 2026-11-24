(function () {
  const { M, get, post, busy, report, toast, esc, $, dt, empty, failed, modal, closeModal } = Mat;
  const money = (n) => "₹" + Number(n).toLocaleString("en-IN");

  async function plans() {
    const box = $("#plans");
    box.innerHTML = Mat.loading(3);
    const r = await get("packages");
    if (!r.ok) { box.innerHTML = failed(r, "location.reload()"); return; }
    if (!r.packages.length) { box.innerHTML = empty("fa-crown", "No packages available", "Packages for your community are not set up yet. Please check back later."); return; }
    const mid = Math.floor(r.packages.length / 2);
    box.innerHTML = r.packages.map((p, i) =>
      "<div class='mat-plan" + (p.is_featured || (r.packages.length > 2 && i === mid) ? " hot" : "") + "'><h3>" + esc(p.name) + "</h3><div class='price'>" + money(p.price) + "</div>" +
      "<ul><li><i class='fa-solid fa-check'></i> Valid for " + p.validity_days + " days</li><li><i class='fa-solid fa-check'></i> " + (p.contact_views == null ? "Unlimited" : p.contact_views) + " contact requests</li>" +
      p.features.map((f) => "<li><i class='fa-solid fa-check'></i> " + esc(f) + "</li>").join("") + "</ul>" +
      (p.description ? "<p class='mat-hint'>" + esc(p.description) + "</p>" : "") +
      "<button class='mat-btn' data-buy='" + p.id + "' data-name='" + esc(p.name) + "' data-price='" + p.price + "'>Buy " + esc(p.name) + "</button></div>").join("");
  }

  async function mine() {
    if (!M.loggedIn) return;
    const r = await get("my_packages");
    if (!r.ok) { $("#myPkgBody").textContent = r.error; $("#history").textContent = ""; return; }
    const e = r.entitlement;
    $("#myPkgBody").innerHTML = e.active
      ? e.packages.map((p) => "<p><b>" + esc(p.name) + "</b> · valid till " + dt(p.expires_at) + " (" + p.days_left + " days left) · contact requests used " + p.used + (p.contact_views == null ? " (unlimited)" : " of " + p.contact_views) + "</p>").join("")
      : "<p class='mat-hint'>You do not have an active package.</p>";
    $("#history").innerHTML = r.orders.length
      ? "<table class='mat-table'><thead><tr><th>Receipt</th><th>Package</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead><tbody>" +
        r.orders.map((o) => "<tr><td data-l='Receipt'>" + esc(o.txn_code) + "</td><td data-l='Package'>" + esc(o.package) + "</td><td data-l='Amount'>" + money(o.amount) + "</td><td data-l='Status'><span class='mat-tag " + esc(o.status) + "'>" + esc(o.status) + "</span></td><td data-l='Date'>" + dt(o.paid_at || o.created_at) + "</td></tr>").join("") + "</tbody></table>"
      : "<p class='mat-hint'>No payments yet.</p>";
  }

  async function verify(resp) {
    toast("Confirming your payment…", "ok");
    const r = await post("payment_verify", resp);
    if (r.ok) { modal("Payment successful", "<p>Your package is active. Receipt: <b>" + esc(r.txn_code || "") + "</b></p><div class='mat-actions'><button class='mat-btn' data-close>OK</button></div>"); mine(); }
    else { report(r); mine(); }
  }

  async function buy(btn) {
    if (!M.loggedIn) { location.href = M.loginUrl; return; }
    if (!M.me) { report({ ok: false, code: "PROFILE_REQUIRED", error: "Create your matrimony profile before buying a package." }); return; }
    if (!(await Mat.ask("Buy " + btn.dataset.name + " for " + money(btn.dataset.price) + "?", "Yes, continue to payment"))) return;
    const r = await busy(btn, () => post("order_package", { package_id: btn.dataset.buy }));
    if (!report(r)) return;
    if (typeof window.Razorpay !== "function") { toast("Payment window could not load. Check your connection and try again.", "err"); return; }
    const rz = new window.Razorpay({
      key: r.key_id, order_id: r.order_id, amount: r.amount, currency: r.currency, name: r.name || "PeopleLink", description: r.description, prefill: r.prefill,
      theme: { color: "#d6336c" },
      handler: (resp) => verify(resp),
      modal: { ondismiss: () => { toast("Payment cancelled.", "err"); mine(); } },
    });
    rz.on("payment.failed", (e) => { toast((e.error && e.error.description) || "Payment failed.", "err"); mine(); });
    rz.open();
  }

  $("#plans").addEventListener("click", (e) => { const b = e.target.closest("[data-buy]"); if (b) buy(b); });
  plans(); mine();
})();
