(function () {
  const { get, post, busy, report, toast, esc, $, $$ } = Mat;
  const MAX = 6, grid = $("#photoGrid"), input = $("#photoInput"), drop = $("#drop");
  let photos = [];

  function render() {
    $("#photoCount").textContent = photos.length + " of " + MAX + " photos";
    drop.style.display = photos.length >= MAX ? "none" : "";
    grid.innerHTML = photos.length ? photos.map((p) =>
      "<div class='mat-photo'>" + (p.is_primary ? "<span class='pri'>Main photo</span>" : "") +
      "<img src='" + esc(Mat.imgUrl(p.thumbnail_url)) + "' alt='My photo'><div class='bar'><span class='mat-tag " + esc(p.approval_status) + "'>" + esc(p.approval_status) + "</span>" +
      "<span>" + (p.is_primary ? "" : "<button class='mat-btn ghost sm' data-primary='" + p.photo_id + "' title='Make main photo'><i class='fa-solid fa-star'></i></button> ") +
      "<button class='mat-btn danger sm' data-del='" + p.photo_id + "' title='Delete photo' aria-label='Delete photo'><i class='fa-solid fa-trash'></i></button></span></div></div>").join("")
      : Mat.empty("fa-image", "No photos yet", "Profiles with photos get many more responses.");
  }

  async function load() {
    const r = await get("me");
    if (!r.ok || !r.profile) { grid.innerHTML = Mat.failed(r); return; }
    // own profile -> all photos including pending
    const all = await get("profile", { id: r.profile.id });
    photos = all.ok ? all.profile.photos : [];
    render();
  }

  async function upload(files) {
    files = Array.from(files);
    if (!files.length) return;
    if (photos.length + files.length > MAX) { toast("You can upload " + (MAX - photos.length) + " more photo(s).", "err"); return; }
    const bad = files.find((f) => f.size > 5 * 1024 * 1024 || !/^image\/(jpeg|png|webp)$/.test(f.type));
    if (bad) { toast(bad.name + ": use JPG, PNG or WEBP up to 5 MB.", "err"); return; }
    const fd = new FormData(); files.forEach((f) => fd.append("photos[]", f));
    drop.classList.add("over"); drop.querySelector("b").textContent = "Uploading…";
    const r = await post("upload_photos", fd);
    drop.classList.remove("over"); drop.querySelector("b").textContent = "Click or drop photos here";
    report(r);
    if (r.photos) { photos = r.photos; render(); } else load();
    input.value = "";
  }

  input.addEventListener("change", () => upload(input.files));
  ["dragenter", "dragover"].forEach((ev) => drop.addEventListener(ev, (e) => { e.preventDefault(); drop.classList.add("over"); }));
  ["dragleave", "drop"].forEach((ev) => drop.addEventListener(ev, (e) => { e.preventDefault(); drop.classList.remove("over"); }));
  drop.addEventListener("drop", (e) => upload(e.dataTransfer.files));

  grid.addEventListener("click", async (e) => {
    const d = e.target.closest("[data-del]"), p = e.target.closest("[data-primary]");
    if (d) {
      if (!(await Mat.ask("Delete this photo?", "Yes, delete", true))) return;
      const r = await busy(d, () => post("delete_photo", { photo_id: d.dataset.del }));
      if (report(r)) { photos = r.photos; render(); }
    } else if (p) {
      const r = await busy(p, () => post("set_primary_photo", { photo_id: p.dataset.primary }));
      if (report(r)) { photos = r.photos; render(); }
    }
  });
  load();
})();
