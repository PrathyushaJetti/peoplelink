
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('plJobSearchForm');
  const list = document.getElementById('plJobResults');
  if (!form || !list) return;
  const cards = Array.from(list.querySelectorAll('.pl-js-job-card'));
  const count = document.getElementById('plJobResultCount');
  const empty = document.getElementById('plJobEmpty');
  const activeFilters = document.getElementById('plJobActiveFilters');
  const visibilityInput = document.getElementById('plJobVisibility');
  const scopeNote = document.getElementById('plJobScopeNote');
  const sort = document.getElementById('plJobSort');
  const norm = v => (v || '').toString().toLowerCase().trim();
  const get = id => document.getElementById(id);
  let currentVisibility = 'community';

  document.querySelectorAll('.pl-js-network[data-visibility]').forEach(btn => {
    btn.addEventListener('click', () => {
      currentVisibility = btn.dataset.visibility;
      visibilityInput.value = currentVisibility;
      document.querySelectorAll('.pl-js-network[data-visibility]').forEach(b => {
        const active = b === btn;
        b.classList.toggle('is-active', active);
        b.setAttribute('aria-pressed', active ? 'true' : 'false');
      });
      scopeNote.innerHTML = currentVisibility === 'community'
        ? '<i class="bi bi-info-circle"></i> Showing community opportunities.'
        : '<i class="bi bi-info-circle"></i> Showing opportunities across all communities.';
      applyFilters();
    });
  });

  function applyFilters() {
    const filters = {
      title: norm(get('plJobTitle').value),
      keyword: norm(get('plJobKeyword').value),
      location: norm(get('plJobLocation').value),
      category: norm(get('plJobCategory').value),
      qualification: norm(get('plJobQualification').value),
      experience: norm(get('plJobExperience').value),
      type: norm(get('plJobType').value),
      mode: norm(get('plJobWorkMode').value),
      min: Number(get('plJobSalaryMin').value || 0),
      max: Number(get('plJobSalaryMax').value || 0)
    };
    let shown = [];
    cards.forEach(card => {
      const d = card.dataset;
      const matches = (!filters.title || norm(d.title).includes(filters.title)) &&
        (!filters.keyword || (norm(d.keyword + ' ' + d.title).includes(filters.keyword))) &&
        (!filters.location || norm(d.location).includes(filters.location)) &&
        (!filters.category || norm(d.category).includes(filters.category)) &&
        (!filters.qualification || norm(d.qualification).includes(filters.qualification)) &&
        (!filters.experience || norm(d.experience) === filters.experience) &&
        (!filters.type || norm(d.type) === filters.type) &&
        (!filters.mode || norm(d.mode) === filters.mode) &&
        (!filters.min || Number(d.salary) >= filters.min) &&
        (!filters.max || Number(d.salary) <= filters.max) &&
        (currentVisibility === 'global' || d.visibility === 'community');
      card.hidden = !matches;
      if (matches) shown.push(card);
    });
    if (sort.value === 'salary_desc') shown.sort((a,b) => Number(b.dataset.salary)-Number(a.dataset.salary));
    else if (sort.value === 'salary_asc') shown.sort((a,b) => Number(a.dataset.salary)-Number(b.dataset.salary));
    else if (sort.value === 'latest') shown.sort((a,b) => Number(b.dataset.date)-Number(a.dataset.date));
    else shown.sort((a,b) => (norm(a.dataset.title)).localeCompare(norm(b.dataset.title)));
    shown.forEach(card => list.appendChild(card));
    count.textContent = `Showing ${shown.length} ${shown.length === 1 ? 'opportunity' : 'opportunities'}`;
    empty.hidden = shown.length !== 0;
    list.hidden = shown.length === 0;
    activeFilters.innerHTML = '';
    const tags = [];
    if (currentVisibility === 'community') tags.push('Community Jobs'); else tags.push('Global Jobs');
    Object.entries({Title:filters.title,Keyword:filters.keyword,Location:filters.location,Category:filters.category,Qualification:filters.qualification,Experience:filters.experience,Type:filters.type,'Work mode':filters.mode}).forEach(([label,value])=>{if(value)tags.push(label+': '+value)});
    if(filters.min)tags.push('Min ₹'+filters.min.toLocaleString('en-IN'));
    if(filters.max)tags.push('Max ₹'+filters.max.toLocaleString('en-IN'));
    tags.forEach(tag=>{const el=document.createElement('span');el.textContent=tag;activeFilters.appendChild(el)});
  }

  form.addEventListener('submit', e => { e.preventDefault(); applyFilters(); });
  sort.addEventListener('change', applyFilters);
  ['plJobTitle','plJobKeyword','plJobLocation'].forEach(id => get(id).addEventListener('input', applyFilters));
  ['plJobCategory','plJobQualification','plJobExperience','plJobType','plJobWorkMode','plJobSalaryMin','plJobSalaryMax'].forEach(id => get(id).addEventListener('change', applyFilters));
  function resetFilters() {
    form.reset();
    currentVisibility = 'community';
    visibilityInput.value = 'community';
    document.querySelectorAll('.pl-js-network[data-visibility]').forEach(b => {
      const active = b.dataset.visibility === 'community';
      b.classList.toggle('is-active', active);
      b.setAttribute('aria-pressed', active ? 'true' : 'false');
    });
    sort.value = 'latest';
    applyFilters();
  }
  get('plJobReset').addEventListener('click', resetFilters);
  get('plJobEmptyReset').addEventListener('click', resetFilters);
  applyFilters();
});
