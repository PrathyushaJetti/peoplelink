
document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    const page = document.querySelector(".pl-jobs-page");
    if (!page) return;

    const scopeButtons = page.querySelectorAll("[data-job-scope]");
    const cards = Array.from(page.querySelectorAll(".plj-job-card"));
    const form = page.querySelector("#pljSearchForm");

    const keyword = page.querySelector("#pljKeyword");
    const company = page.querySelector("#pljCompany");
    const location = page.querySelector("#pljLocation");
    const experience = page.querySelector("#pljExperience");
    const category = page.querySelector("#pljCategory");

    const resultCount = page.querySelector("#pljResultCount");
    const scopeLabel = page.querySelector("#pljScopeLabel");
    const empty = page.querySelector("#pljEmpty");
    const emptyReset = page.querySelector("#pljEmptyReset");
    const viewAll = page.querySelector("#pljViewAll");
    const recommended = page.querySelector("#pljRecommended");
    const toast = page.querySelector("#pljToast");

    const modal = page.querySelector("#pljJobModal");
    const modalTitle = page.querySelector("#pljModalTitle");
    const modalCompany = page.querySelector("#pljModalCompany");
    const modalTag = page.querySelector("#pljModalTag");
    const modalMeta = page.querySelector("#pljModalMeta");
    const modalOverview = page.querySelector("#pljModalOverview");
    const modalQualification = page.querySelector("#pljModalQualification");
    const modalSalary = page.querySelector("#pljModalSalary");
    const modalContinue = page.querySelector("#pljModalContinue");

    let activeScope = "community";
    let toastTimer;
    let lastFocusedElement = null;

    const savedJobs = new Set();

    function clean(value) {
        return String(value || "").trim().toLowerCase();
    }

    function jobData(card) {
        return {
            title: card.dataset.title || "",
            company: card.dataset.company || "",
            location: card.dataset.location || "",
            experience: card.dataset.experience || "",
            category: card.dataset.category || "",
            skills: card.dataset.skills || "",
            qualification: card.dataset.qualification || "",
            salary: card.dataset.salary || "",
            date: card.dataset.date || "",
            scope: card.dataset.scope || "community"
        };
    }

    function notify(message) {
        if (!toast) return;

        toast.textContent = message;
        toast.classList.add("show");

        window.clearTimeout(toastTimer);

        toastTimer = window.setTimeout(function () {
            toast.classList.remove("show");
        }, 2600);
    }

    function getFilters() {
        return {
            keyword: clean(keyword.value),
            company: clean(company.value),
            location: clean(location.value),
            experience: clean(experience.value),
            category: clean(category.value)
        };
    }

    function experienceMatches(jobValue, selectedValue) {
        if (!selectedValue) return true;

        if (selectedValue === "fresher") {
            return jobValue === "fresher";
        }

        if (selectedValue === "0-2") {
            return jobValue === "0-2" || jobValue === "fresher";
        }

        if (selectedValue === "2-5") {
            return jobValue === "2-5";
        }

        return jobValue === selectedValue;
    }

    function categoryMatches(job, selectedCategory) {
        if (!selectedCategory) return true;

        if (selectedCategory === "remote") {
            return clean(job.location).includes("remote");
        }

        return clean(job.category) === selectedCategory;
    }

    function matches(card, filters) {
        const job = jobData(card);

        if (job.scope !== activeScope) return false;

        const searchable = clean([
            job.title,
            job.company,
            job.skills,
            job.qualification,
            job.category
        ].join(" "));

        if (filters.keyword && !searchable.includes(filters.keyword)) {
            return false;
        }

        if (
            filters.company &&
            !clean(job.company).includes(filters.company)
        ) {
            return false;
        }

        if (
            filters.location &&
            !clean(job.location).includes(filters.location)
        ) {
            return false;
        }

        if (!experienceMatches(job.experience, filters.experience)) {
            return false;
        }

        if (!categoryMatches(job, filters.category)) {
            return false;
        }

        return true;
    }

    function renderJobs() {
        const filters = getFilters();
        let count = 0;

        cards.forEach(function (card) {
            const visible = matches(card, filters);

            card.hidden = !visible;

            if (visible) count++;
        });

        if (resultCount) {
            resultCount.textContent =
                count + (count === 1 ? " opportunity" : " opportunities");
        }

        if (scopeLabel) {
            scopeLabel.innerHTML = activeScope === "community"
                ? '<i class="bi bi-people-fill"></i> Community Jobs'
                : '<i class="bi bi-globe2"></i> Global Jobs';
        }

        if (empty) {
            empty.hidden = count > 0;
        }

        if (viewAll) {
            viewAll.hidden = count === 0;
        }
    }

    function selectScope(scope, scrollToJobs) {
        if (!["community", "global"].includes(scope)) return;

        activeScope = scope;

        scopeButtons.forEach(function (button) {
            const selected = button.dataset.jobScope === scope;

            button.classList.toggle("active", selected);
            button.setAttribute("aria-pressed", String(selected));
        });

        renderJobs();

        if (scrollToJobs) {
            page.querySelector("#plj-latest").scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        }
    }

    function resetFilters() {
        if (form) form.reset();
        renderJobs();
    }

    function formatExperience(value) {
        const labels = {
            fresher: "Fresher",
            "0-2": "0–2 Years",
            "2-5": "2–5 Years",
            "5+": "5+ Years"
        };

        return labels[value] || "Not specified";
    }

    function addModalMeta(iconName, text) {
        const span = document.createElement("span");
        const icon = document.createElement("i");

        icon.className = "bi " + iconName;
        span.appendChild(icon);
        span.appendChild(document.createTextNode(" " + text));

        modalMeta.appendChild(span);
    }

    function openModal(card) {
        const job = jobData(card);

        if (!modal) return;

        lastFocusedElement = document.activeElement;

        modalTitle.textContent = job.title;
        modalCompany.textContent = job.company;
        modalTag.textContent = job.scope === "community"
            ? "Community Job"
            : "Global Job";

        modalTag.classList.toggle(
            "plj-community-tag",
            job.scope === "community"
        );

        modalTag.classList.toggle(
            "plj-global-tag",
            job.scope === "global"
        );

        modalMeta.replaceChildren();

        addModalMeta("bi-geo-alt", job.location);
        addModalMeta("bi-briefcase", formatExperience(job.experience));
        addModalMeta("bi-clock", job.date);

        modalOverview.textContent =
            "Explore the " + job.title + " opportunity at " + job.company +
            ". Review the role requirements and confirm your suitability.";

        modalQualification.textContent =
            job.qualification || "Please check the full job listing.";

        modalSalary.textContent = job.salary
            ? "Salary Range: " + job.salary
            : "Salary not disclosed";

        modalContinue.href =
            "job-details.php?title=" + encodeURIComponent(job.title);

        modal.classList.add("is-open");
        modal.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";

        const closeButton = modal.querySelector(".plj-modal-close");
        if (closeButton) closeButton.focus();
    }

    function closeModal() {
        if (!modal) return;

        modal.classList.remove("is-open");
        modal.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";

        if (lastFocusedElement) lastFocusedElement.focus();
    }

    // Switch between Community Jobs and Global Jobs.
    scopeButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            selectScope(button.dataset.jobScope, true);
        });
    });

    // Search and filter.
    if (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            renderJobs();

            const count = cards.filter(function (card) {
                return !card.hidden;
            }).length;

            notify(count
                ? count + " matching job(s) found."
                : "No matching jobs found. Try other filters.");

            page.querySelector("#plj-latest").scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        });

        form.addEventListener("reset", function () {
            window.setTimeout(renderJobs, 0);
        });
    }

    if (emptyReset) {
        emptyReset.addEventListener("click", function () {
            resetFilters();
            notify("Filters cleared.");
        });
    }

    // Browse by category.
    page.querySelectorAll("[data-category]").forEach(function (button) {
        button.addEventListener("click", function () {
            category.value = button.dataset.category;
            renderJobs();

            page.querySelector("#plj-search").scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

            const count = cards.filter(function (card) {
                return !card.hidden;
            }).length;

            notify(count
                ? count + " job(s) found in this category."
                : "No sample jobs in this category yet.");
        });
    });

    // Save and unsave demo jobs.
    cards.forEach(function (card) {
        const saveButton = card.querySelector(".plj-save-btn");

        if (!saveButton) return;

        saveButton.addEventListener("click", function () {
            const job = jobData(card);
            const key = job.scope + "|" + job.title + "|" + job.company;

            if (savedJobs.has(key)) {
                savedJobs.delete(key);
                saveButton.classList.remove("is-saved");
                saveButton.setAttribute("aria-pressed", "false");
                saveButton.innerHTML = '<i class="bi bi-bookmark"></i>';

                notify("Job removed from saved jobs.");
            } else {
                savedJobs.add(key);
                saveButton.classList.add("is-saved");
                saveButton.setAttribute("aria-pressed", "true");
                saveButton.innerHTML = '<i class="bi bi-bookmark-fill"></i>';

                notify("Job saved successfully.");
            }
        });

        const viewButton = card.querySelector("[data-view-job]");

        if (viewButton) {
            viewButton.addEventListener("click", function () {
                openModal(card);
            });
        }
    });

    // Modal close actions.
    if (modal) {
        modal.querySelectorAll("[data-close-modal]").forEach(function (button) {
            button.addEventListener("click", closeModal);
        });

        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape" && modal.classList.contains("is-open")) {
                closeModal();
            }
        });
    }

    if (viewAll) {
        viewAll.addEventListener("click", function () {
            notify("All matching sample listings are displayed.");
        });
    }

    if (recommended) {
        recommended.addEventListener("click", function () {
            resetFilters();

            page.querySelector("#plj-latest").scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

            notify("Explore jobs in your selected network.");
        });
    }

    // Default selection.
    selectScope("community", false);
});
