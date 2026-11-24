/* India locations for the State -> District -> City fields.
   States / union territories: all. Districts: complete lists for Andhra Pradesh and Telangana (most PeopleLink communities);
   other states type their district. Cities: suggestions only (the member can type any city). */
window.PL_INDIA = {
  states: ["Andhra Pradesh", "Telangana", "Karnataka", "Tamil Nadu", "Kerala", "Maharashtra", "Odisha", "Chhattisgarh", "Goa", "Gujarat",
    "Madhya Pradesh", "Rajasthan", "Uttar Pradesh", "Uttarakhand", "Bihar", "Jharkhand", "West Bengal", "Assam", "Arunachal Pradesh", "Manipur",
    "Meghalaya", "Mizoram", "Nagaland", "Sikkim", "Tripura", "Haryana", "Himachal Pradesh", "Punjab",
    "Andaman and Nicobar Islands", "Chandigarh", "Dadra and Nagar Haveli and Daman and Diu", "Delhi", "Jammu and Kashmir", "Ladakh", "Lakshadweep", "Puducherry"],
  districts: {
    "Andhra Pradesh": ["Alluri Sitharama Raju", "Anakapalli", "Anantapur", "Annamayya", "Bapatla", "Chittoor", "Dr. B.R. Ambedkar Konaseema", "East Godavari",
      "Eluru", "Guntur", "Kakinada", "Krishna", "Kurnool", "Nandyal", "NTR", "Palnadu", "Parvathipuram Manyam", "Prakasam", "Sri Potti Sriramulu Nellore",
      "Sri Sathya Sai", "Srikakulam", "Tirupati", "Visakhapatnam", "Vizianagaram", "West Godavari", "YSR Kadapa"],
    "Telangana": ["Adilabad", "Bhadradri Kothagudem", "Hanumakonda", "Hyderabad", "Jagtial", "Jangaon", "Jayashankar Bhupalpally", "Jogulamba Gadwal",
      "Kamareddy", "Karimnagar", "Khammam", "Kumuram Bheem Asifabad", "Mahabubabad", "Mahabubnagar", "Mancherial", "Medak", "Medchal-Malkajgiri", "Mulugu",
      "Nagarkurnool", "Nalgonda", "Narayanpet", "Nirmal", "Nizamabad", "Peddapalli", "Rajanna Sircilla", "Ranga Reddy", "Sangareddy", "Siddipet",
      "Suryapet", "Vikarabad", "Wanaparthy", "Warangal", "Yadadri Bhuvanagiri"]
  },
  // main towns per district (suggestions; any city can be typed)
  cities: {
    "Hyderabad": ["Hyderabad", "Secunderabad"], "Ranga Reddy": ["Shamshabad", "Ibrahimpatnam", "Chevella", "Shadnagar", "Gachibowli"],
    "Medchal-Malkajgiri": ["Medchal", "Malkajgiri", "Kukatpally", "Uppal", "Kompally"], "Bhadradri Kothagudem": ["Kothagudem", "Bhadrachalam", "Palvancha", "Manuguru", "Yellandu"],
    "Khammam": ["Khammam", "Sathupally", "Madhira", "Wyra"], "Warangal": ["Warangal", "Narsampet"], "Hanumakonda": ["Hanumakonda", "Kazipet"],
    "Karimnagar": ["Karimnagar", "Huzurabad", "Jammikunta"], "Nizamabad": ["Nizamabad", "Bodhan", "Armoor"], "Nalgonda": ["Nalgonda", "Miryalaguda", "Devarakonda"],
    "Suryapet": ["Suryapet", "Kodad", "Huzurnagar"], "Sangareddy": ["Sangareddy", "Patancheru", "Zaheerabad"], "Siddipet": ["Siddipet", "Gajwel"],
    "Mahabubnagar": ["Mahabubnagar", "Jadcherla"], "Adilabad": ["Adilabad"], "Mancherial": ["Mancherial", "Bellampalli"], "Medak": ["Medak", "Narsapur"],
    "Visakhapatnam": ["Visakhapatnam", "Bheemunipatnam"], "Guntur": ["Guntur", "Tenali", "Mangalagiri"], "Krishna": ["Machilipatnam", "Gudivada"],
    "NTR": ["Vijayawada", "Nandigama", "Jaggayyapeta"], "Tirupati": ["Tirupati", "Srikalahasti", "Gudur"], "Chittoor": ["Chittoor", "Kuppam", "Palamaner"],
    "East Godavari": ["Rajamahendravaram", "Kovvur"], "West Godavari": ["Bhimavaram", "Tadepalligudem", "Narsapuram"], "Eluru": ["Eluru", "Jangareddygudem"],
    "Kakinada": ["Kakinada", "Peddapuram", "Pithapuram"], "Sri Potti Sriramulu Nellore": ["Nellore", "Kavali"], "Prakasam": ["Ongole", "Markapur", "Chirala"],
    "Kurnool": ["Kurnool", "Adoni", "Yemmiganur"], "Anantapur": ["Anantapur", "Guntakal", "Tadipatri"], "YSR Kadapa": ["Kadapa", "Proddatur", "Pulivendula"],
    "Srikakulam": ["Srikakulam", "Palasa", "Tekkali"], "Vizianagaram": ["Vizianagaram", "Bobbili"], "Nandyal": ["Nandyal", "Allagadda"], "Palnadu": ["Narasaraopet", "Sattenapalli"],
    "Bapatla": ["Bapatla", "Repalle"], "Annamayya": ["Rayachoti", "Madanapalle"], "Sri Sathya Sai": ["Puttaparthi", "Hindupur", "Dharmavaram"]
  }
};

/* Wires a State select + District + City inputs. ids: state select, district input, city input. */
window.plLocationFields = function (stateSel, districtInp, cityInp) {
  const L = window.PL_INDIA;
  if (!stateSel || !districtInp || !cityInp) return;
  // district: a select for states with a list, the original text box otherwise
  const dSel = document.createElement("select");
  dSel.id = districtInp.id + "_sel"; dSel.className = districtInp.className;
  districtInp.insertAdjacentElement("beforebegin", dSel);
  const cityList = document.createElement("datalist"); cityList.id = cityInp.id + "_list";
  cityInp.setAttribute("list", cityList.id); cityInp.insertAdjacentElement("afterend", cityList);
  const norm = (s) => String(s || "").trim().toLowerCase().replace(/[^a-z]/g, "");

  function fillDistricts(keep) {
    const list = L.districts[stateSel.value];
    if (!list) { dSel.hidden = true; dSel.disabled = true; districtInp.hidden = false; districtInp.placeholder = "Type your district"; return; }
    const cur = keep ? districtInp.value : "";
    const match = list.find((d) => norm(d) === norm(cur));
    dSel.innerHTML = "<option value=''>Select district</option>" + list.map((d) => "<option>" + d + "</option>").join("") + "<option value='__other'>Other (type it)</option>";
    dSel.hidden = false; dSel.disabled = false;
    if (match) { dSel.value = match; districtInp.value = match; districtInp.hidden = true; }
    else if (cur) { dSel.value = "__other"; districtInp.hidden = false; }
    else { dSel.value = ""; districtInp.value = ""; districtInp.hidden = true; }
  }
  function fillCities() {
    const c = L.cities[districtInp.value] || (districtInp.value ? [districtInp.value] : []);
    cityList.innerHTML = c.map((x) => "<option value='" + x + "'>").join("");
    cityInp.placeholder = c.length ? "e.g. " + c[0] + " (or type your city)" : "Type your city";
  }
  dSel.addEventListener("change", () => {
    if (dSel.value === "__other") { districtInp.value = ""; districtInp.hidden = false; districtInp.focus(); }
    else { districtInp.value = dSel.value; districtInp.hidden = true; }
    if (!cityInp.value || cityInp.dataset.auto === "1") { const c = L.cities[districtInp.value]; if (c) { cityInp.value = c[0]; cityInp.dataset.auto = "1"; } }
    fillCities();
  });
  districtInp.addEventListener("input", fillCities);
  cityInp.addEventListener("input", () => (cityInp.dataset.auto = "0"));
  stateSel.addEventListener("change", () => { fillDistricts(false); cityInp.value = ""; fillCities(); });
  fillDistricts(true); fillCities();
};
