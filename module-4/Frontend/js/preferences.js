(function () {
  const { post, busy, report, validate, toast, $ } = Mat;
  const form = $("#prefForm");
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    if (!validate(form)) return;
    const a = parseInt(form.age_min.value, 10), b = parseInt(form.age_max.value, 10);
    if (a && b && a > b) { toast("'Age from' cannot be more than 'Age to'.", "err"); return; }
    // the location used for match % = chosen states + city
    const states = Array.from(form.querySelectorAll("[name='partner_states[]']:checked")).map((x) => x.value);
    form.partner_location.value = [form.partner_city.value.trim()].concat(states).filter(Boolean).join(", ");
    const fd = new FormData(form);
    fd.set("partner_age_min", form.age_min.value); fd.set("partner_age_max", form.age_max.value);
    const r = await busy(e.submitter, () => post("save_preferences", fd));
    if (report(r)) setTimeout(() => (location.href = new URLSearchParams(location.search).has("new") ? "photos.php?new=1" : "my-profile.php"), 800);
  });
})();
