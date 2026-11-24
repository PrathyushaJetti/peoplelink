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

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    if (!validate(form)) return;
    if (/\d{10}/.test(about.value.replace(/\s/g, ""))) { toast("Please remove phone numbers from 'About me'.", "err"); about.focus(); return; }
    const mode = form.dataset.mode;
    const fd = new FormData(form);
    fd.set("education", fd.get("qualification") || "");
    const r = await busy(e.submitter, () => post(mode === "create" ? "create_profile" : "update_profile", fd));
    if (!report(r)) return;
    if (r.photo_error) toast("Profile saved, but a photo was not uploaded: " + r.photo_error, "err");
    setTimeout(() => (location.href = mode === "create" ? "preferences.php?new=1" : "my-profile.php"), 900);
  });
})();
