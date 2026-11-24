document.addEventListener("DOMContentLoaded", function () {
  const list = document.getElementById("savedJobList");
  const empty = document.getElementById("savedEmpty");
  const tabs = Array.from(document.querySelectorAll(".sj-filter-tab"));
  const sortSelect = document.getElementById("sortJobs");
  const toast = document.getElementById("sjToast");
  const modal = document.getElementById("jobModal");
  const modalTitle = document.getElementById("modalJobTitle");
  const modalCompany = document.getElementById("modalCompany");
  const modalContent = document.getElementById("modalContent");
  const modalApply = document.getElementById("modalApply");
  let currentFilter = "all";
  let toastTimer;

  function cards() { return Array.from(list.querySelectorAll(".sj-job-card")); }
  function showToast(message) {
    toast.textContent = message;
    toast.classList.add("show");
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove("show"), 2600);
  }
  function updateSummary() {
    const all = cards();
    const active = all.filter(card => card.dataset.status === "active").length;
    const today = new Date(); today.setHours(0,0,0,0);
    const closingSoon = all.filter(card => {
      if (card.dataset.status !== "active") return false;
      const close = new Date(card.dataset.closing + "T00:00:00");
      const days = Math.ceil((close - today) / 86400000);
      return days >= 0 && days <= 7;
    }).length;
    document.getElementById("savedCount").textContent = all.length;
    document.getElementById("activeCount").textContent = active;
    document.getElementById("closingCount").textContent = closingSoon;
    document.getElementById("allTabCount").textContent = all.length;
  }
  function render() {
    const all = cards();
    all.sort((a, b) => {
      const av = sortSelect.value === "closing" ? a.dataset.closing : a.dataset.saved;
      const bv = sortSelect.value === "closing" ? b.dataset.closing : b.dataset.saved;
      return sortSelect.value === "closing" ? av.localeCompare(bv) : bv.localeCompare(av);
    });
    all.forEach(card => {
      const matchesType = currentFilter === "all" || card.dataset.type === currentFilter;
      card.hidden = !matchesType;
      list.appendChild(card);
    });
    const visible = all.filter(card => !card.hidden).length;
    document.getElementById("resultsCount").textContent = visible + (visible === 1 ? " saved job" : " saved jobs");
    empty.hidden = all.length !== 0;
    list.hidden = all.length === 0;
    updateSummary();
  }
  tabs.forEach(tab => tab.addEventListener("click", () => {
    tabs.forEach(item => item.classList.toggle("active", item === tab));
    currentFilter = tab.dataset.filter;
    render();
  }));
  sortSelect.addEventListener("change", render);

  list.addEventListener("click", function (event) {
    const removeButton = event.target.closest("[data-remove]");
    const viewButton = event.target.closest("[data-view]");
    if (removeButton) {
      const card = removeButton.closest(".sj-job-card");
      const title = card.querySelector("h3").textContent;
      card.remove();
      render();
      showToast(title + " removed from saved jobs.");
      return;
    }
    if (viewButton) {
      const card = viewButton.closest(".sj-job-card");
      const title = card.querySelector("h3").textContent;
      const company = card.querySelector(".sj-company").textContent;
      const info = card.querySelectorAll(".sj-meta-grid span");
      const salary = card.querySelector(".sj-salary")?.textContent.trim() || "Salary not disclosed";
      const status = card.dataset.status === "active" ? "Active" : (card.dataset.status === "expired" ? "Expired" : "Job Closed");
      const description = card.dataset.type === "global"
        ? "This opportunity is listed across the PeopleLink network. Review the requirements and apply before the closing date."
        : "This opportunity is shared with a PeopleLink community. Review the requirements and apply if the role matches your experience.";
      modalTitle.textContent = title;
      modalCompany.textContent = company;
      modalApply.href = "apply-to-job.html?job=" + encodeURIComponent(card.dataset.id);
      modalApply.style.display = card.dataset.status === "active" ? "inline-flex" : "none";
      modalContent.innerHTML = "";
      const details = [
        ["Availability", status],
        ["Job Type", info[1]?.textContent.trim() || "Not specified"],
        ["Work Mode", info[3]?.textContent.trim() || "Not specified"],
        ["Experience", info[2]?.textContent.trim() || "Not specified"],
        ["Location", info[0]?.textContent.trim() || "Not specified"],
        ["Salary Range", salary]
      ];
      details.forEach(([label, value]) => {
        const div = document.createElement("div");
        div.className = "sj-modal-detail";
        const small = document.createElement("small"); small.textContent = label;
        const strong = document.createElement("strong"); strong.textContent = value;
        div.append(small, strong); modalContent.appendChild(div);
      });
      const desc = document.createElement("p");
      desc.className = "sj-modal-description";
      desc.textContent = description;
      modalContent.appendChild(desc);
      modal.classList.add("open");
      modal.setAttribute("aria-hidden", "false");
      document.body.style.overflow = "hidden";
    }
  });

  function closeModal() {
    modal.classList.remove("open");
    modal.setAttribute("aria-hidden", "true");
    document.body.style.overflow = "";
  }
  modal.querySelectorAll("[data-close-modal]").forEach(button => button.addEventListener("click", closeModal));
  document.addEventListener("keydown", event => {
    if (event.key === "Escape") closeModal();
  });
  document.getElementById("plBackToTop")?.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
  const year = document.getElementById("plCopyrightYear");
  if (year) year.textContent = new Date().getFullYear();

  // A local-only demo: removed jobs stay removed only until this page is refreshed.
  render();
});
