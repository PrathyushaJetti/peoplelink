/* PeopleLink – Near Me (live). Results come from the backend action nearme_list, which searches the
   Professional & Business Directory (Module 6) by GPS distance or by city / area / pincode.
   This script takes over the page controls (capture phase) so the old demo handlers in main.js do not run. */
(function () {
  "use strict";
  const API = ((window.PL_WEB || {}).api || "/peoplelink/matrimoney/api.php");
  const NM = window.NM || {};
  const $ = (id) => document.getElementById(id);
  const esc = (v) => String(v == null ? "" : v).replace(/[&<>"']/g, (c) => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c]));
  // design category words -> directory categories (others are searched as keywords)
  const ALIAS = { Doctors: "Healthcare", Hospitals: "Healthcare", Pharmacies: "Healthcare", Lawyers: "Legal", "Chartered Accountants": "Finance / CA",
    Shops: "Retail", "Home Services": "Home Services", "Real Estate": "Real Estate", Education: "Education", "Event Services": "Event Services",
    "Professional Services": "Consulting", "Other Businesses": "Other" };
  const state = { lat: null, lng: null, place: "", category: "", keyword: "", sort: "nearest", radius: NM.radius || 10, items: [] };

  function saveLoc() { try { sessionStorage.setItem("plNearMe", JSON.stringify({ lat: state.lat, lng: state.lng, place: state.place })); } catch (e) {} }
  function loadLoc() { try { const s = JSON.parse(sessionStorage.getItem("plNearMe") || "null"); if (s) Object.assign(state, s); } catch (e) {} }
  function status(msg) { const el = $("locationStatus"); if (el) el.innerHTML = '<i class="bi bi-geo-alt"></i> <span>' + esc(msg) + "</span>"; }

  async function search() {
    const grid = $("listingGrid"); if (!grid) return;
    if (state.lat === null && !state.place) { status("Choose a location to discover nearby listings."); render([]); return; }
    const q = new URLSearchParams({ action: "nearme_list", per: "50", radius: String(state.radius) });
    if (state.lat !== null) { q.set("lat", state.lat); q.set("lng", state.lng); }
    else if (/^\d{6}$/.test(state.place)) q.set("q", state.place);
    else { const parts = state.place.split(",").map((s) => s.trim()).filter(Boolean); q.set(parts.length > 1 ? "area" : "city", parts[0]); if (parts.length > 1) q.set("city", parts[1]); }
    const cat = ALIAS[state.category] || state.category;
    if (cat && NM.categories && NM.categories.indexOf(cat) !== -1) q.set("category", cat);
    const kw = [state.keyword, cat && NM.categories && NM.categories.indexOf(cat) === -1 ? state.category : ""].filter(Boolean).join(" ");
    if (kw) q.set("q", kw);
    grid.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:24px">Searching nearby…</p>';
    try {
      const res = await fetch(API + "?" + q.toString(), { credentials: "same-origin" });
      const r = await res.json();
      if (!r.ok) { grid.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:24px">' + esc(r.error || "Could not load nearby listings.") + "</p>"; return; }
      state.items = r.items || [];
      const sum = $("resultsSummary");
      if (sum) sum.textContent = state.items.length + " listing" + (state.items.length === 1 ? "" : "s") + (state.lat !== null ? " within " + (r.radius_km || state.radius) + " km" : " in " + state.place);
      render(state.items);
    } catch (e) { grid.innerHTML = '<p style="grid-column:1/-1;text-align:center;padding:24px">Could not reach the server.</p>'; }
  }

  function sorted(items) {
    const a = items.slice();
    if (state.sort === "name") a.sort((x, y) => String(x.business_name || x.name).localeCompare(String(y.business_name || y.name)));
    else if (state.sort === "recent") a.sort((x, y) => String(y.created_at).localeCompare(String(x.created_at)));
    else if (state.sort === "nearest") a.sort((x, y) => (x.distance_km == null ? 1e9 : x.distance_km) - (y.distance_km == null ? 1e9 : y.distance_km));
    return a;
  }

  function render(items) {
    const grid = $("listingGrid"), empty = $("noResults"), links = $("mapListingLinks");
    const list = sorted(items);
    if (empty) empty.hidden = list.length !== 0 || (state.lat === null && !state.place);
    grid.innerHTML = list.map(function (d) {
      const biz = d.profile_type === "Business";
      const title = biz ? (d.business_name || d.name) : d.name;
      const loc = [d.area, d.city].filter(Boolean).join(", ");
      const tel = String(d.phone || d.whatsapp || "").replace(/[^\d+]/g, "");
      const url = "near-me-details.php?id=" + d.id + (state.lat !== null ? "&lat=" + state.lat + "&lng=" + state.lng : "");
      const dest = d.latitude && d.longitude ? d.latitude + "," + d.longitude : encodeURIComponent(loc);
      return '<article class="near-listing-card"><div class="listing-card-top"><div class="listing-business-icon cat-blue">' +
        (d.logo || d.cover ? '<img src="' + esc(d.logo || d.cover) + '" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:inherit">' : '<i class="bi ' + (biz ? "bi-shop" : "bi-person-badge") + '"></i>') +
        '</div><span class="listing-type">' + esc(d.category_name || "") + "</span></div>" +
        "<h3>" + esc(title) + '</h3><p class="listing-service">' + esc(d.subcategory_name || String(d.services || "").split(",")[0] || "") + "</p>" +
        '<p class="listing-description">' + esc(String(d.description || "").slice(0, 140)) + "</p>" +
        '<div class="listing-meta"><span><i class="bi bi-geo-alt"></i> ' + esc(loc || "—") + "</span>" + (d.distance_km != null ? '<span><i class="bi bi-signpost-2"></i> ' + esc(d.distance_km) + " km</span>" : "") + "</div>" +
        '<div class="listing-actions"><a href="' + url + '" class="listing-view-details">View Details <i class="bi bi-arrow-up-right"></i></a>' +
        (tel ? '<a class="listing-contact" href="tel:' + esc(tel) + '"><i class="bi bi-telephone"></i> Contact</a>' : '<a class="listing-contact" href="../bussiness/enquiry-contact.php?id=' + d.id + '"><i class="bi bi-chat-dots"></i> Enquire</a>') +
        '<a class="listing-map" href="https://www.google.com/maps/dir/?api=1&destination=' + dest + '" target="_blank" rel="noopener" aria-label="Directions"><i class="bi bi-geo-alt"></i></a></div></article>';
    }).join("");
    if (links) links.innerHTML = list.map((d) => '<a href="https://www.google.com/maps/search/?api=1&query=' + (d.latitude && d.longitude ? d.latitude + "," + d.longitude : encodeURIComponent([d.area, d.city].join(" "))) + '" target="_blank" rel="noopener">' + esc(d.business_name || d.name) + (d.distance_km != null ? " · " + d.distance_km + " km" : "") + "</a>").join("");
  }

  function useGps() {
    if (!navigator.geolocation) { status("Location is not supported by this browser. Choose a location instead."); return; }
    status("Detecting your location…");
    navigator.geolocation.getCurrentPosition(function (p) {
      state.lat = +p.coords.latitude.toFixed(6); state.lng = +p.coords.longitude.toFixed(6); state.place = "";
      status("Showing listings near your current location."); saveLoc(); search();
    }, function () { status("Location permission was not given. Choose a city, area or PIN code instead."); openModal(); }, { timeout: 10000, maximumAge: 300000 });
  }
  function openModal() { const m = $("locationModal"); if (m) { m.hidden = false; const i = $("manualLocation"); if (i) setTimeout(() => i.focus(), 50); } }
  function closeModal() { const m = $("locationModal"); if (m) m.hidden = true; }

  document.addEventListener("click", function (e) {
    const t = e.target.closest("#useLocation, #chooseLocation, #changeLocationBtn, .near-category, #resetSearch, #listViewBtn, #mapViewBtn, [data-close-modal]");
    if (!t) return;
    e.preventDefault(); e.stopPropagation();
    if (t.id === "useLocation") useGps();
    else if (t.id === "chooseLocation" || t.id === "changeLocationBtn") openModal();
    else if (t.matches("[data-close-modal]")) closeModal();
    else if (t.classList.contains("near-category")) {
      document.querySelectorAll(".near-category").forEach((b) => b.classList.toggle("active", b === t));
      state.category = t.dataset.category || ""; const s = $("searchCategory"); if (s) s.value = state.category; search();
    } else if (t.id === "resetSearch") { state.category = ""; state.keyword = ""; const f = $("nearSearchForm"); if (f) f.reset(); search(); }
    else if (t.id === "listViewBtn" || t.id === "mapViewBtn") {
      const map = t.id === "mapViewBtn"; $("mapPanel").hidden = !map; $("listingGrid").hidden = map;
      $("listViewBtn").classList.toggle("active", !map); $("mapViewBtn").classList.toggle("active", map);
    }
  }, true);

  document.addEventListener("submit", function (e) {
    const f = e.target;
    if (f.id === "locationForm") {
      e.preventDefault(); e.stopPropagation();
      const v = ($("manualLocation").value || "").trim(); if (!v) return;
      state.place = v; state.lat = null; state.lng = null; closeModal(); status("Showing listings in " + v + "."); saveLoc(); search();
    } else if (f.id === "nearSearchForm") {
      e.preventDefault(); e.stopPropagation();
      state.keyword = ($("keyword").value || "").trim(); state.category = $("searchCategory").value || "";
      const area = ($("areaSearch").value || "").trim(); if (area) { state.place = area; state.lat = null; state.lng = null; saveLoc(); status("Showing listings in " + area + "."); }
      const rad = $("nmRadius"); if (rad) state.radius = +rad.value || state.radius;
      search();
    }
  }, true);

  document.addEventListener("change", function (e) {
    if (e.target.id === "sortListings") { e.stopPropagation(); state.sort = e.target.value; render(state.items); }
    if (e.target.id === "nmRadius") { state.radius = +e.target.value || 10; if (state.lat !== null) search(); }
  }, true);

  document.addEventListener("DOMContentLoaded", function () {
    loadLoc();
    if (state.lat === null && !state.place && NM.city) state.place = NM.city; // start with the member's city
    if (state.lat !== null) status("Showing listings near your current location.");
    else if (state.place) status("Showing listings in " + state.place + ". Use My Location for distance-based results.");
    const s = $("sortListings"); if (s) s.value = "nearest";
    search();
  });
})();
