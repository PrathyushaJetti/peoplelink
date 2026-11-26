(async function () {
  const { get, card, empty, loading, failed, $, esc } = Mat;
  const box = $("#homeCards");
  // index2.php (old layout) fills its city list here; the new home page renders cities on the server
  if ($("#quickCity") && window.MAT && window.MAT.community) get("matrimony_filters").then((r) => {
    if (r.ok) $("#quickCity").insertAdjacentHTML("beforeend", r.filters.city.map((c) => "<option>" + esc(c) + "</option>").join(""));
  });
  if (!box) return;
  box.innerHTML = loading(4);
  const r = await get("search", { per: 8, sort: "recent" });
  if (!r.ok) { box.innerHTML = failed(r); return; }
  box.innerHTML = r.profiles.length ? r.profiles.map((p) => card(p)).join("") : empty("fa-users", "No profiles yet", "Be one of the first members to create a matrimony profile in your community.");
})();
