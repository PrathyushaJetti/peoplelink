/* =====================================================
   PAGE 43 - MY APPLICATIONS
===================================================== */

document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const $ = (selector, root = document) =>
        root.querySelector(selector);

    const $$ = (selector, root = document) =>
        [...root.querySelectorAll(selector)];

    const list = $("#maApplicationList");
    const cards = $$("[data-application]", list);

    const search = $("#maSearch");
    const visibilityFilter = $("#maJobVisibility");
    const jobStatusFilter = $("#maJobStatus");
    const sort = $("#maSort");

    const emptyState = $("#maEmptyState");
    const resultsCount = $("#maResultsCount");

    const detailsModal = $("#maDetailsModal");
    const contactModal = $("#maContactModal");

    let currentTab = "all";
    let lastFocusedElement = null;

    const normalize = value =>
        String(value || "").trim().toLowerCase();

    function getData(card, key) {
        return card.dataset[key] || "";
    }

    function getJobStatus(card) {
        return normalize(getData(card, "jobStatus"));
    }

    function getApplicationStatus(card) {
        return getData(card, "applicationStatus");
    }

    function formatDate(value) {
        if (!value) return "Not available";

        const date = new Date(value + "T12:00:00");

        if (Number.isNaN(date.getTime())) {
            return value;
        }

        return new Intl.DateTimeFormat("en-IN", {
            day: "2-digit",
            month: "short",
            year: "numeric"
        }).format(date);
    }

    // -----------------------------------------------
    // 1. Summary counters
    // -----------------------------------------------

    function updateSummary() {
        const total = cards.length;

        const active = cards.filter(card =>
            getJobStatus(card) === "active"
        ).length;

        const closed = cards.filter(card =>
            getJobStatus(card) === "closed"
        ).length;

        const viewed = cards.filter(card =>
            normalize(getApplicationStatus(card)) === "viewed"
        ).length;

        $("#maTotalCount").textContent = total;
        $("#maActiveCount").textContent = active;
        $("#maViewedCount").textContent = viewed;
        $("#maClosedCount").textContent = closed;

        $("#maAllTabCount").textContent = total;
        $("#maActiveTabCount").textContent = active;
        $("#maClosedTabCount").textContent = closed;
    }

    // -----------------------------------------------
    // 2. Status tabs and filters
    // -----------------------------------------------

    function matchesTab(card) {
        const jobStatus = getJobStatus(card);

        if (currentTab === "active") {
            return jobStatus === "active";
        }

        if (currentTab === "closed") {
            return jobStatus === "closed";
        }

        return true;
    }

    function matchesSearch(card) {
        const query = normalize(search.value);

        if (!query) return true;

        const searchable = [
            getData(card, "title"),
            getData(card, "company"),
            getData(card, "location"),
            getData(card, "community"),
            getData(card, "applicationStatus")
        ].join(" ");

        return normalize(searchable).includes(query);
    }

    function matchesVisibility(card) {
        const selected = visibilityFilter.value;

        if (selected === "all") return true;

        return getData(card, "visibility") === selected;
    }

    function matchesJobStatus(card) {
        const selected = jobStatusFilter.value;

        if (selected === "all") return true;

        return getJobStatus(card) === selected;
    }

    function render() {
        const filtered = cards.filter(card =>
            matchesTab(card) &&
            matchesSearch(card) &&
            matchesVisibility(card) &&
            matchesJobStatus(card)
        );

        const direction = sort.value === "oldest" ? 1 : -1;

        filtered.sort((a, b) => {
            const dateA = getData(a, "applicationDate");
            const dateB = getData(b, "applicationDate");

            return dateA.localeCompare(dateB) * direction;
        });

        // Append moves existing cards into the selected order.
        filtered.forEach(card => list.appendChild(card));

        cards.forEach(card => {
            card.hidden = !filtered.includes(card);
        });

        const count = filtered.length;

        resultsCount.textContent =
            count + (count === 1
                ? " application found"
                : " applications found");

        emptyState.hidden = count !== 0;
        list.hidden = count === 0;
    }

    $$("[data-status-tab]").forEach(button => {
        button.addEventListener("click", () => {
            currentTab = button.dataset.statusTab;

            $$("[data-status-tab]").forEach(tab => {
                const selected = tab === button;

                tab.classList.toggle("selected", selected);
                tab.setAttribute("aria-pressed", String(selected));
            });

            render();
        });
    });

    [search, visibilityFilter, jobStatusFilter, sort]
        .forEach(control => {
            control.addEventListener("input", render);
            control.addEventListener("change", render);
        });

    $("#maReset").addEventListener("click", () => {
        search.value = "";
        visibilityFilter.value = "all";
        jobStatusFilter.value = "all";
        sort.value = "latest";
        currentTab = "all";

        $$("[data-status-tab]").forEach(button => {
            const selected = button.dataset.statusTab === "all";

            button.classList.toggle("selected", selected);
            button.setAttribute("aria-pressed", String(selected));
        });

        render();
    });

    // -----------------------------------------------
    // 3. Modal helpers
    // -----------------------------------------------

    function openModal(modal, trigger) {
        lastFocusedElement = trigger || document.activeElement;

        modal.hidden = false;
        document.body.style.overflow = "hidden";

        const closeButton = $("[data-close-modal]", modal);

        if (closeButton) closeButton.focus();
    }

    function closeModal(modal) {
        modal.hidden = true;

        if (detailsModal.hidden && contactModal.hidden) {
            document.body.style.overflow = "";
        }

        if (lastFocusedElement &&
            typeof lastFocusedElement.focus === "function") {
            lastFocusedElement.focus();
        }
    }

    $$("[data-close-modal]").forEach(button => {
        button.addEventListener("click", () => {
            closeModal(button.closest(".ma-modal-overlay"));
        });
    });

    [detailsModal, contactModal].forEach(modal => {
        modal.addEventListener("click", event => {
            if (event.target === modal) {
                closeModal(modal);
            }
        });
    });

    document.addEventListener("keydown", event => {
        if (event.key === "Escape") {
            if (!detailsModal.hidden) closeModal(detailsModal);
            else if (!contactModal.hidden) closeModal(contactModal);
        }
    });

    // -----------------------------------------------
    // 4. View application details
    // -----------------------------------------------

    function setText(id, value) {
        $(id).textContent = value || "Not available";
    }

    function showApplicationDetails(card, trigger) {
        setText("#maDetailJobTitle", getData(card, "title"));
        setText("#maDetailCompany", getData(card, "company"));
        setText("#maDetailLocation", getData(card, "location"));
        setText("#maDetailJobType", getData(card, "jobType"));

        setText(
            "#maDetailVisibility",
            getData(card, "visibility") === "community"
                ? "Community Job" +
                  (getData(card, "community")
                    ? " — " + getData(card, "community")
                    : "")
                : "Global Job"
        );

        setText(
            "#maDetailDate",
            formatDate(getData(card, "applicationDate"))
        );

        setText("#maDetailApplicant", getData(card, "applicant"));
        setText("#maDetailResume", getData(card, "resume"));
        setText("#maDetailMethod", getData(card, "method"));

        setText(
            "#maDetailJobStatus",
            getJobStatus(card) === "closed" ? "Closed" : "Active"
        );

        setText(
            "#maDetailStatus",
            getApplicationStatus(card)
        );

        setText("#maDetailSalary", getData(card, "salary"));
        setText("#maDetailDescription", getData(card, "description"));
        setText("#maDetailMessage", getData(card, "message"));

        const viewJobLink = $("#maDetailViewJob");

        viewJobLink.href =
            "job-details.html?id=" +
            encodeURIComponent(getData(card, "id").replace("APP-", "JOB-"));

        openModal(detailsModal, trigger);
    }

    $$("[data-view-application]").forEach(button => {
        button.addEventListener("click", () => {
            showApplicationDetails(
                button.closest("[data-application]"),
                button
            );
        });
    });

    // -----------------------------------------------
    // 5. Contact through configured methods
    // -----------------------------------------------

    function showContactOptions(card, trigger) {
        const options = $("#maContactOptions");
        const unavailable = $("#maContactUnavailable");

        options.replaceChildren();

        const isClosed = getJobStatus(card) === "closed";

        $("#maContactJobName").textContent =
            getData(card, "title") + " — " + getData(card, "company");

        const configuredMethods = getData(card, "contactMethods")
            .split(",")
            .map(method => method.trim().toLowerCase())
            .filter(Boolean);

        const contacts = [];

        if (!isClosed && configuredMethods.includes("whatsapp")) {
            const number = getData(card, "contactNumber")
                .replace(/\D/g, "");

            if (number) {
                contacts.push({
                    title: "Contact via WhatsApp",
                    description: "Continue to the configured employer contact.",
                    icon: "fa-brands fa-whatsapp",
                    url: "https://wa.me/" + number
                });
            }
        }

        if (!isClosed && configuredMethods.includes("email")) {
            const email = getData(card, "contactEmail").trim();

            // Require a plausible email before generating a mail link.
            if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                contacts.push({
                    title: "Contact via Email",
                    description: "Send a message to the employer.",
                    icon: "fa-regular fa-envelope",
                    url: "mailto:" + email +
                        "?subject=" +
                        encodeURIComponent(
                            "Application enquiry: " + getData(card, "title")
                        )
                });
            }
        }

        contacts.forEach(contact => {
            const link = document.createElement("a");

            link.className = "ma-contact-link";
            link.href = contact.url;
            link.target = contact.url.startsWith("https://") ? "_blank" : "";
            link.rel = "noopener noreferrer";

            const icon = document.createElement("i");
            icon.className = contact.icon;

            const textWrapper = document.createElement("span");

            const title = document.createElement("strong");
            title.textContent = contact.title;

            const description = document.createElement("small");
            description.textContent = contact.description;

            textWrapper.append(title, description);
            link.append(icon, textWrapper);
            options.appendChild(link);
        });

        unavailable.hidden = contacts.length !== 0;

        openModal(contactModal, trigger);
    }

    $$("[data-contact-application]").forEach(button => {
        button.addEventListener("click", () => {
            showContactOptions(
                button.closest("[data-application]"),
                button
            );
        });
    });

    // -----------------------------------------------
    // 6. Initialize
    // -----------------------------------------------

    updateSummary();
    render();
});