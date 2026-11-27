(function () {
  const { get, card, empty, loading, failed, pager, $, $$, esc } = Mat;
  const form = $("#filterForm"), box = $("#results"), count = $("#resultCount"), sort = $("#sortBy");
  const url = new URLSearchParams(location.search);
  let page = parseInt(url.get("page") || "1", 10);

  $("#filterToggle").addEventListener("click", () => $("#filterPanel").classList.toggle("closed"));

  // fill dropdowns with values that really exist in the community
  let F = null;
  const filtersReady = get("matrimony_filters").then((r) => {
    if (!r.ok) return;
    F = r.filters;
    $$("[data-opts]", form).forEach((s) => {
      if (s.name === "state" || s.name === "city") return; // filled below
      s.insertAdjacentHTML("beforeend", (F[s.dataset.opts] || []).map((v) => "<option>" + esc(v) + "</option>").join(""));
    });
    // State: every state of India; states that have profiles show how many
    const counts = F.state_counts || {};
    const all = (window.PL_INDIA ? PL_INDIA.states : []).slice();
    (F.state || []).forEach((st) => { if (!all.some((x) => x.toLowerCase() === st.toLowerCase())) all.push(st); });
    const withP = all.filter((x) => counts[x.toLowerCase()]), rest = all.filter((x) => !counts[x.toLowerCase()]);
    form.state.innerHTML = "<option value=''>Any state</option>" +
      (withP.length ? "<optgroup label='States with profiles'>" + withP.map((x) => "<option value='" + esc(x) + "'>" + esc(x) + " (" + counts[x.toLowerCase()] + ")</option>").join("") + "</optgroup>" : "") +
      "<optgroup label='All states'>" + rest.map((x) => "<option>" + esc(x) + "</option>").join("") + "</optgroup>";
    fillCities();
  });
  // City follows the chosen State
  function fillCities() {
    if (!F) return;
    const st = form.state.value.toLowerCase(), cur = form.city.value;
    const list = st ? (F.city_by_state || {})[st] || [] : (F.city || []);
    form.city.innerHTML = "<option value=''>" + (st && !list.length ? "No profiles in this state yet" : "Any city") + "</option>" + list.map((c) => "<option>" + esc(c) + "</option>").join("");
    if (list.some((c) => c === cur)) form.city.value = cur;
    mark();
  }
  // highlight the filters that are in use
  function mark() { $$("input, select", form).forEach((el) => el.classList.toggle("is-set", String(el.value).trim() !== "")); sort.classList.toggle("is-set", sort.value !== "recent"); }
  form.addEventListener("input", mark); form.addEventListener("change", (e) => { if (e.target.name === "state") fillCities(); mark(); });

  function params() {
    const p = {};
    new FormData(form).forEach((v, k) => { if (String(v).trim() !== "") p[k] = String(v).trim(); });
    p.sort = sort.value; p.page = page; p.per = 12;
    return p;
  }

  async function load() {
    box.innerHTML = loading(6); count.textContent = "Loading…";
    const p = params();
    const qs = new URLSearchParams(p); qs.delete("per");
    history.replaceState(null, "", "?" + qs.toString());
    const r = await get("search", p);
    if (!r.ok) { box.innerHTML = failed(r, "location.reload()"); count.textContent = ""; return; }
    count.textContent = r.total + " profile" + (r.total === 1 ? "" : "s") + " found";
    box.innerHTML = r.profiles.length ? r.profiles.map((x) => card(x)).join("")
      : empty("fa-magnifying-glass", "No profiles match", "Try removing a filter or widening the age range.");
    pager($("#pager"), r.page, r.total_pages, (n) => { page = n; load(); });
  }

  // restore filters from the URL (shared links / back button)
  filtersReady.then(() => {
    url.forEach((v, k) => {
      if (k === "age") { const m = v.match(/^(\d+)\s*-\s*(\d+)$/) || v.match(/^(\d+)\+$/); if (m) { form.min_age.value = m[1]; if (m[2]) form.max_age.value = m[2]; } return; }
      if (k === "sort") { sort.value = v; return; }
      if (k === "page") { page = parseInt(v, 10) || 1; return; }
      const f = form.elements[k]; if (f) { f.value = v; if (k === "state") fillCities(); }
    });
    mark(); load();
  });

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const a = parseInt(form.min_age.value, 10), b = parseInt(form.max_age.value, 10);
    if (a && b && a > b) { Mat.toast("Minimum age cannot be more than maximum age.", "err"); return; }
    page = 1; load();
    if (window.innerWidth < 1024) $("#filterPanel").classList.add("closed");
  });
  form.addEventListener("reset", () => setTimeout(() => { fillCities(); mark(); page = 1; load(); }, 0));
  sort.addEventListener("change", () => { mark(); page = 1; load(); });
})();
