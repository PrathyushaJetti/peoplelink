/* =========================================================
   PEOPLELINK HEADER JS
========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {


        /* =====================================================
           ELEMENTS
        ====================================================== */

        const mobileToggle =
            document.getElementById(
                "plMobileToggle"
            );


        const mainNav =
            document.getElementById(
                "plMainNav"
            );


        const menuOverlay =
            document.getElementById(
                "plMenuOverlay"
            );


        const dropdown =
            document.querySelector(
                ".pl-nav-dropdown"
            );


        const dropdownButton =
            document.querySelector(
                ".pl-nav-dropdown-btn"
            );



        /* =====================================================
           OPEN / CLOSE MOBILE MENU
        ====================================================== */

        function openMenu() {

            if (!mobileToggle || !mainNav) {
                return;
            }

            mobileToggle.classList.add(
                "active"
            );

            mainNav.classList.add(
                "active"
            );

            if (menuOverlay) {

                menuOverlay.classList.add(
                    "active"
                );

            }

            mobileToggle.setAttribute(
                "aria-expanded",
                "true"
            );

            document.body.style.overflow =
                "hidden";

        }


        function closeMenu() {

            if (!mobileToggle || !mainNav) {
                return;
            }

            mobileToggle.classList.remove(
                "active"
            );

            mainNav.classList.remove(
                "active"
            );

            if (menuOverlay) {

                menuOverlay.classList.remove(
                    "active"
                );

            }

            mobileToggle.setAttribute(
                "aria-expanded",
                "false"
            );

            document.body.style.overflow =
                "";

        }



        /* =====================================================
           MOBILE TOGGLE
        ====================================================== */

        if (mobileToggle) {

            mobileToggle.addEventListener(
                "click",
                function () {

                    const isOpen =
                        mainNav.classList.contains(
                            "active"
                        );


                    if (isOpen) {

                        closeMenu();

                    } else {

                        openMenu();

                    }

                }
            );

        }



        /* =====================================================
           OVERLAY CLOSE
        ====================================================== */

        if (menuOverlay) {

            menuOverlay.addEventListener(
                "click",
                function () {

                    closeMenu();

                }
            );

        }



        /* =====================================================
           MOBILE COMMUNITY DROPDOWN
        ====================================================== */

        if (
            dropdown &&
            dropdownButton
        ) {

            dropdownButton.addEventListener(
                "click",
                function (event) {

                    /*
                     * Desktop uses CSS hover.
                     * Mobile uses JavaScript.
                     */

                    if (
                        window.innerWidth <= 900
                    ) {

                        event.preventDefault();

                        dropdown.classList.toggle(
                            "mobile-open"
                        );

                    }

                }
            );

        }



        /* =====================================================
           CLOSE MENU WHEN LINK IS CLICKED
        ====================================================== */

        const navLinks =
            document.querySelectorAll(
                ".pl-main-nav a"
            );


        navLinks.forEach(
            function (link) {

                link.addEventListener(
                    "click",
                    function () {

                        if (
                            window.innerWidth <= 900
                        ) {

                            closeMenu();

                        }

                    }
                );

            }
        );



        /* =====================================================
           ESC KEY
        ====================================================== */

        document.addEventListener(
            "keydown",
            function (event) {

                if (
                    event.key === "Escape"
                ) {

                    closeMenu();

                }

            }
        );



        /* =====================================================
           RESIZE
        ====================================================== */

        window.addEventListener(
            "resize",
            function () {

                if (
                    window.innerWidth > 900
                ) {

                    closeMenu();

                    if (dropdown) {

                        dropdown.classList.remove(
                            "mobile-open"
                        );

                    }

                }

            }
        );



        /* =====================================================
           HEADER SCROLL EFFECT
        ====================================================== */

        const header =
            document.getElementById(
                "peoplelinkHeader"
            );


        let lastScroll = 0;


        window.addEventListener(
            "scroll",
            function () {

                const currentScroll =
                    window.pageYOffset ||
                    document.documentElement
                        .scrollTop;


                if (
                    header &&
                    currentScroll > 30
                ) {

                    header.classList.add(
                        "pl-header-scrolled"
                    );

                } else if (header) {

                    header.classList.remove(
                        "pl-header-scrolled"
                    );

                }


                lastScroll =
                    currentScroll <= 0
                        ? 0
                        : currentScroll;

            },
            {
                passive: true
            }
        );



        /* =====================================================
           SMOOTH INTERNAL LINKS
        ====================================================== */

        const internalLinks =
            document.querySelectorAll(
                'a[href^="#"]'
            );


        internalLinks.forEach(
            function (link) {

                link.addEventListener(
                    "click",
                    function (event) {

                        const targetId =
                            this.getAttribute(
                                "href"
                            );


                        if (
                            !targetId ||
                            targetId === "#"
                        ) {

                            return;

                        }


                        const target =
                            document.querySelector(
                                targetId
                            );


                        if (target) {

                            event.preventDefault();

                            closeMenu();

                            target.scrollIntoView(
                                {
                                    behavior: "smooth",
                                    block: "start"
                                }
                            );

                        }

                    }
                );

            }
        );

    }
);





/* =========================================================
   PEOPLELINK DIRECTORY SEARCH — PAGE INTERACTIONS
========================================================= */
(() => {
    "use strict";

    const form = document.getElementById("directorySearchForm");
    if (!form) return;

    const category = document.getElementById("directoryCategory");
    const experience = document.getElementById("directoryExperience");
    const sort = document.getElementById("directorySort");
    const locationButton = document.getElementById("useDirectoryLocation");
    const latitude = document.getElementById("directoryLatitude");
    const longitude = document.getElementById("directoryLongitude");
    const nearby = document.getElementById("directoryNearby");
    const status = document.getElementById("directoryLocationStatus");

    const setStatus = (message, type = "info") => {
        if (!status) return;
        status.textContent = message;
        status.dataset.state = type;
        status.style.color = type === "error" ? "#b42336" : type === "success" ? "#25813a" : "#527186";
    };

    const setListingType = (type) => {
        const radio = form.querySelector(`input[name="listing_type"][value="${type}"]`);
        if (radio) radio.checked = true;
    };

    const requestLocation = () => {
        if (!("geolocation" in navigator)) {
            setStatus("Location is not supported by this browser. You can enter your city and area manually.", "error");
            return;
        }

        locationButton.disabled = true;
        locationButton.innerHTML = '<i class="bi bi-hourglass-split"></i> Finding location…';
        setStatus("Please allow location access when your browser asks.");

        navigator.geolocation.getCurrentPosition(
            (position) => {
                latitude.value = position.coords.latitude.toFixed(6);
                longitude.value = position.coords.longitude.toFixed(6);
                nearby.value = "1";
                if (sort && sort.value === "relevant") sort.value = "nearest";
                setStatus("Location enabled. Nearby listings can now be prioritized.", "success");
                locationButton.disabled = false;
                locationButton.innerHTML = '<i class="bi bi-check-circle"></i> Location Enabled';
            },
            (error) => {
                nearby.value = "0";
                let message = "Unable to get your location. Enter your city and area instead.";
                if (error.code === error.PERMISSION_DENIED) message = "Location permission was denied. Allow it in your browser settings or enter your city and area.";
                else if (error.code === error.TIMEOUT) message = "Location request timed out. Please try again or enter your city and area.";
                setStatus(message, "error");
                locationButton.disabled = false;
                locationButton.innerHTML = '<i class="bi bi-geo-alt"></i> Use My Location';
            },
            { enableHighAccuracy: false, timeout: 10000, maximumAge: 300000 }
        );
    };

    if (locationButton) {
        locationButton.addEventListener("click", requestLocation);
    }

    form.querySelectorAll("[data-quick-filter]").forEach((button) => {
        button.addEventListener("click", () => {
            const action = button.dataset.quickFilter;
            if (action === "professionals-near-me") {
                setListingType("professional");
                requestLocation();
            } else if (action === "businesses-near-me") {
                setListingType("business");
                requestLocation();
            } else if (action === "recent") {
                if (sort) sort.value = "recent";
                form.requestSubmit();
            } else if (action === "categories") {
                document.getElementById("popularDirectoryCategories")?.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        });
    });

    document.querySelectorAll("[data-category]").forEach((button) => {
        button.addEventListener("click", () => {
            if (category) category.value = button.dataset.category || "";
            document.querySelectorAll("[data-category]").forEach((chip) => {
                chip.classList.toggle("is-active", chip === button);
            });
            document.getElementById("directorySearchForm")?.scrollIntoView({ behavior: "smooth", block: "center" });
            if (category) category.focus({ preventScroll: true });
        });
    });

    if (form) {
        form.addEventListener("reset", () => {
            window.setTimeout(() => {
                latitude.value = "";
                longitude.value = "";
                nearby.value = "0";
                if (locationButton) {
                    locationButton.disabled = false;
                    locationButton.innerHTML = '<i class="bi bi-geo-alt"></i> Use My Location';
                }
                setStatus("");
                document.querySelectorAll("[data-category]").forEach((chip) => chip.classList.remove("is-active"));
            }, 0);
        });
    }

    // Nearest sort is only meaningful after location permission succeeds.
    if (sort) {
        sort.addEventListener("change", () => {
            if (sort.value === "nearest" && nearby.value !== "1") {
                setStatus("Enable your location to sort listings by distance.");
            } else {
                setStatus("");
            }
        });
    }
})();







document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const list = document.getElementById('plResultsList');
    const cards = Array.from(document.querySelectorAll('.pl-directory-card'));
    const filterForm = document.getElementById('plResultsFilterForm');
    const sortSelect = document.getElementById('plResultsSort');
    const countElement = document.getElementById('plResultsCount');
    const emptyState = document.getElementById('plResultsEmpty');
    const loadMoreButton = document.getElementById('plResultsLoadMore');
    const loadMoreWrap = document.getElementById('plLoadMoreWrap');
    const loadNote = document.getElementById('plResultsLoadNote');
    const tabs = Array.from(document.querySelectorAll('.pl-results-type-tabs [data-type]'));
    const pageSize = 4;
    let activeType = 'all';
    let visibleCount = pageSize;
    let filteredCards = cards.slice();

    const fields = {
        category: document.getElementById('plFilterCategory'),
        location: document.getElementById('plFilterLocation'),
        community: document.getElementById('plFilterCommunity')
    };

    function getText(element) {
        return (element || '').toString().trim().toLowerCase();
    }

    function applyFilters() {
        const category = getText(fields.category.value);
        const location = getText(fields.location.value);
        const community = getText(fields.community.value);
        const keywordInput = document.querySelector('.pl-results-search input[name="keyword"]');
        const keyword = getText(keywordInput ? keywordInput.value : '');
        const checkedType = filterForm.querySelector('input[name="type"]:checked');
        activeType = checkedType ? checkedType.value : 'all';

        filteredCards = cards.filter(function (card) {
            const typeMatch = activeType === 'all' || card.dataset.type === activeType;
            const categoryMatch = !category || getText(card.dataset.category).includes(category);
            const locationMatch = !location || getText(card.dataset.location).includes(location);
            const communityMatch = !community || getText(card.dataset.community).includes(community);
            const keywordMatch = !keyword || getText([
                card.dataset.name,
                card.dataset.category,
                card.dataset.location,
                card.querySelector('.pl-directory-specialization')?.textContent,
                card.querySelector('.pl-directory-description')?.textContent
            ].join(' ')).includes(keyword);

            return typeMatch && categoryMatch && locationMatch && communityMatch && keywordMatch;
        });

        sortCards();
        visibleCount = pageSize;
        renderCards();
        updateTabs();
    }

    function sortCards() {
        const sortValue = sortSelect.value;
        filteredCards.sort(function (a, b) {
            if (sortValue === 'recent') {
                return (b.dataset.date || '').localeCompare(a.dataset.date || '');
            }
            if (sortValue === 'name') {
                return (a.dataset.name || '').localeCompare(b.dataset.name || '');
            }
            if (sortValue === 'nearest') {
                return Number(a.dataset.distance || 999999) - Number(b.dataset.distance || 999999);
            }
            return cards.indexOf(a) - cards.indexOf(b);
        });
    }

    function renderCards() {
        cards.forEach(function (card) {
            card.hidden = true;
            if (card.parentElement !== list) list.appendChild(card);
        });

        filteredCards.forEach(function (card, index) {
            list.appendChild(card);
            card.hidden = index >= visibleCount;
        });

        countElement.textContent = filteredCards.length;
        emptyState.hidden = filteredCards.length !== 0;
        list.hidden = filteredCards.length === 0;
        loadMoreWrap.hidden = filteredCards.length === 0;
        loadMoreButton.disabled = visibleCount >= filteredCards.length;

        const shown = Math.min(visibleCount, filteredCards.length);
        loadNote.textContent = 'Showing ' + shown + ' of ' + filteredCards.length + ' matching ' +
            (filteredCards.length === 1 ? 'listing.' : 'listings.');
    }

    function updateTabs() {
        tabs.forEach(function (tab) {
            const selected = tab.dataset.type === activeType;
            tab.classList.toggle('is-active', selected);
            tab.setAttribute('aria-pressed', selected ? 'true' : 'false');
        });
    }

    filterForm.addEventListener('submit', function (event) {
        event.preventDefault();
        applyFilters();
    });

    filterForm.addEventListener('reset', function () {
        window.setTimeout(function () {
            const keywordInput = document.querySelector('.pl-results-search input[name="keyword"]');
            if (keywordInput) keywordInput.value = '';
            applyFilters();
        }, 0);
    });

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            const type = tab.dataset.type;
            const radio = filterForm.querySelector('input[name="type"][value="' + type + '"]');
            if (radio) radio.checked = true;
            applyFilters();
        });
    });

    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            sortCards();
            renderCards();
        });
    }

    loadMoreButton.addEventListener('click', function () {
        visibleCount += pageSize;
        renderCards();
    });

    document.getElementById('plModifyFilters').addEventListener('click', function () {
        fields.category.focus();
        document.querySelector('.pl-results-filter-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    document.getElementById('plViewAll').addEventListener('click', function () {
        filterForm.reset();
        fields.category.value = '';
        fields.location.value = '';
        fields.community.value = '';
        const allRadio = filterForm.querySelector('input[name="type"][value="all"]');
        if (allRadio) allRadio.checked = true;
        applyFilters();
    });

    // Demo-only saved state. Replace with a logged-in user's server-side save endpoint.
    document.querySelectorAll('.pl-directory-save').forEach(function (button) {
        // live profiles: saved in the member's account (directory_save toggles)
        if (button.dataset.live === '1') {
            const paint = function (on) {
                button.classList.toggle('is-saved', on); button.setAttribute('aria-pressed', on ? 'true' : 'false');
                button.innerHTML = on ? '<i class="bi bi-bookmark-check-fill" aria-hidden="true"></i><span>Saved</span>' : '<i class="bi bi-bookmark" aria-hidden="true"></i><span>Save</span>';
            };
            paint(button.dataset.saved === '1');
            button.addEventListener('click', async function (e) {
                e.preventDefault(); e.stopImmediatePropagation();
                if (!window.PL || !PL.requireLogin()) return;
                button.disabled = true;
                try { const r = await PL.post('directory_save', { id: button.dataset.saveId }); if (r.ok) { paint(!!r.saved); PL.toast(r.saved ? 'Saved.' : 'Removed from saved.'); } else PL.toast(r.error || 'Could not save.', true); }
                catch (err) {} finally { button.disabled = false; }
            }, true);
            return;
        }
        const storageKey = 'peoplelink-saved-directory-listings';
        const id = button.dataset.saveId;
        let saved = [];

        try {
            saved = JSON.parse(localStorage.getItem(storageKey) || '[]');
            if (!Array.isArray(saved)) saved = [];
        } catch (error) {
            saved = [];
        }

        function renderSaved(isSaved) {
            button.classList.toggle('is-saved', isSaved);
            button.setAttribute('aria-pressed', isSaved ? 'true' : 'false');
            button.innerHTML = isSaved
                ? '<i class="bi bi-bookmark-check-fill" aria-hidden="true"></i><span>Saved</span>'
                : '<i class="bi bi-bookmark" aria-hidden="true"></i><span>Save</span>';
        }

        renderSaved(saved.includes(id));

        button.addEventListener('click', function () {
            try {
                saved = JSON.parse(localStorage.getItem(storageKey) || '[]');
                if (!Array.isArray(saved)) saved = [];
            } catch (error) {
                saved = [];
            }

            const isSaved = saved.includes(id);
            saved = isSaved ? saved.filter(function (item) { return item !== id; }) : saved.concat(id);

            try {
                localStorage.setItem(storageKey, JSON.stringify(saved));
            } catch (error) {
                // UI state still updates for the current page view.
            }
            renderSaved(!isSaved);
        });
    });

    // Initial render keeps only the first page of listings visible.
    applyFilters();
});





document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const saveButton = document.getElementById('plProfileSave');
    const shareButton = document.getElementById('plShareProfile');
    const toast = document.getElementById('plProfileToast');
    const modal = document.getElementById('plEnquiryModal');
    const enquiryForm = document.getElementById('plEnquiry');
    const reportButton = document.getElementById('plReportProfile');
    let toastTimer;

    function showToast(message) {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('is-visible');
        window.clearTimeout(toastTimer);
        toastTimer = window.setTimeout(function () {
            toast.classList.remove('is-visible');
        }, 3200);
    }

    function openModal() {
        if (!modal) return;
        modal.hidden = false;
        document.body.style.overflow = 'hidden';
        const firstInput = modal.querySelector('input');
        if (firstInput) window.setTimeout(function () { firstInput.focus(); }, 50);
    }

    function closeModal() {
        if (!modal) return;
        modal.hidden = true;
        document.body.style.overflow = '';
    }

    document.querySelectorAll('a[href="#plEnquiry"]').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            openModal();
        });
    });

    document.querySelectorAll('[data-close-modal]').forEach(function (button) {
        button.addEventListener('click', closeModal);
    });

    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) closeModal();
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal && !modal.hidden) closeModal();
    });

    if (saveButton) {
        const storageKey = 'peoplelink-saved-profiles';
        const profileId = 'professional-ananya-sharma';
        let savedProfiles = [];

        try {
            savedProfiles = JSON.parse(localStorage.getItem(storageKey) || '[]');
            if (!Array.isArray(savedProfiles)) savedProfiles = [];
        } catch (error) {
            savedProfiles = [];
        }

        function renderSaveState(saved) {
            saveButton.setAttribute('aria-pressed', saved ? 'true' : 'false');
            saveButton.innerHTML = saved
                ? '<i class="bi bi-bookmark-check-fill" aria-hidden="true"></i><span>Saved Profile</span>'
                : '<i class="bi bi-bookmark" aria-hidden="true"></i><span>Save Profile</span>';
        }

        renderSaveState(savedProfiles.includes(profileId));

        saveButton.addEventListener('click', function () {
            try {
                savedProfiles = JSON.parse(localStorage.getItem(storageKey) || '[]');
                if (!Array.isArray(savedProfiles)) savedProfiles = [];
            } catch (error) {
                savedProfiles = [];
            }

            const isSaved = savedProfiles.includes(profileId);
            savedProfiles = isSaved
                ? savedProfiles.filter(function (id) { return id !== profileId; })
                : savedProfiles.concat(profileId);

            try {
                localStorage.setItem(storageKey, JSON.stringify(savedProfiles));
            } catch (error) {
                // Keep the button responsive if browser storage is disabled.
            }

            renderSaveState(!isSaved);
            showToast(!isSaved ? 'Profile saved to your list.' : 'Profile removed from your saved list.');
        });
    }

    if (shareButton) {
        shareButton.addEventListener('click', async function () {
            const shareData = {
                title: document.title,
                text: 'View this professional profile on PeopleLink.',
                url: window.location.href
            };

            try {
                if (navigator.share) {
                    await navigator.share(shareData);
                } else if (navigator.clipboard && navigator.clipboard.writeText) {
                    await navigator.clipboard.writeText(window.location.href);
                    showToast('Profile link copied.');
                } else {
                    showToast('Copy this page URL from your browser address bar to share the profile.');
                }
            } catch (error) {
                if (error && error.name !== 'AbortError') {
                    showToast('Unable to share automatically. You can copy the page URL.');
                }
            }
        });
    }

    if (enquiryForm) {
        enquiryForm.addEventListener('submit', function (event) {
            event.preventDefault();
            if (!enquiryForm.reportValidity()) return;
            showToast('Demo only: connect this form to your enquiry backend to send the message.');
            enquiryForm.reset();
            closeModal();
        });
    }

    if (reportButton) {
        reportButton.addEventListener('click', function () {
            showToast('Report flow placeholder: connect this action to your report form or moderation endpoint.');
        });
    }
});





document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const form = document.getElementById('plListingForm');
    const typeInputs = Array.from(document.querySelectorAll('input[name="listing_type"]'));
    const typeOptions = Array.from(document.querySelectorAll('[data-type-option]'));
    const professionalFields = document.getElementById('plProfessionalFields');
    const businessFields = document.getElementById('plBusinessFields');
    const progressBar = document.getElementById('plProgressBar');
    const progressLabel = document.getElementById('plProgressLabel');
    const description = document.getElementById('plShortDescription');
    const descriptionCount = document.getElementById('plDescriptionCount');
    const previewModal = document.getElementById('plPreviewModal');
    const previewContent = document.getElementById('plPreviewContent');
    const feedback = document.getElementById('plSubmitFeedback');
    const feedbackTitle = document.getElementById('plFeedbackTitle');
    const feedbackMessage = document.getElementById('plFeedbackMessage');
    const toast = document.getElementById('plSubmitToast');
    let toastTimer;

    function showToast(message) {
        toast.textContent = message;
        toast.classList.add('is-visible');
        window.clearTimeout(toastTimer);
        toastTimer = window.setTimeout(function () {
            toast.classList.remove('is-visible');
        }, 3200);
    }

    function selectedType() {
        const selected = typeInputs.find(function (input) { return input.checked; });
        return selected ? selected.value : 'professional';
    }

    function updateListingType() {
        const type = selectedType();
        typeOptions.forEach(function (option) {
            option.classList.toggle('is-selected', option.dataset.typeOption === type);
        });

        professionalFields.hidden = type !== 'professional';
        businessFields.hidden = type !== 'business';

        professionalFields.querySelectorAll('input,select,textarea').forEach(function (field) {
            field.disabled = type !== 'professional';
        });
        businessFields.querySelectorAll('input,select,textarea').forEach(function (field) {
            field.disabled = type !== 'business';
        });

        document.getElementById('plListingName').placeholder = type === 'business'
            ? 'Enter your business name'
            : 'Enter your professional name';
        updateProgress();
    }

    function updateProgress() {
        const requiredFields = Array.from(form.querySelectorAll('[required]')).filter(function (field) {
            return !field.disabled && field.type !== 'radio' && field.offsetParent !== null;
        });
        const completed = requiredFields.filter(function (field) {
            return field.value.trim() !== '';
        }).length;
        const percent = requiredFields.length ? Math.round((completed / requiredFields.length) * 100) : 0;
        progressBar.style.width = Math.max(8, percent) + '%';

        if (percent < 35) progressLabel.textContent = 'Step 1 of 4';
        else if (percent < 65) progressLabel.textContent = 'Step 2 of 4';
        else if (percent < 100) progressLabel.textContent = 'Step 3 of 4';
        else progressLabel.textContent = 'Ready to review';
    }

    typeInputs.forEach(function (input) {
        input.addEventListener('change', updateListingType);
    });

    form.querySelectorAll('input,select,textarea').forEach(function (field) {
        field.addEventListener('input', updateProgress);
        field.addEventListener('change', updateProgress);
    });

    description.addEventListener('input', function () {
        descriptionCount.textContent = description.value.length;
    });

    // Display selected filenames and perform lightweight client-side image checks.
    document.querySelectorAll('.pl-upload-box input[type="file"]').forEach(function (input) {
        input.addEventListener('change', function () {
            const output = document.querySelector('[data-file-name="' + input.id + '"]');
            const files = Array.from(input.files || []);
            const maxSize = 5 * 1024 * 1024;
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if (input.id !== 'plServiceImages' && files.length > 1) {
                input.value = '';
                output.textContent = 'Please choose one file.';
                showToast('Choose one file for this upload field.');
                return;
            }

            if (input.id === 'plServiceImages' && files.length > 5) {
                input.value = '';
                output.textContent = 'Maximum 5 images allowed.';
                showToast('You can select up to 5 service images.');
                return;
            }

            const invalidFile = files.find(function (file) {
                return !allowedTypes.includes(file.type) || file.size > maxSize;
            });

            if (invalidFile) {
                input.value = '';
                output.textContent = 'Invalid file type or size.';
                showToast('Use JPG, PNG or WebP images up to 5 MB each.');
                return;
            }

            output.textContent = files.length
                ? files.map(function (file) { return file.name; }).join(', ')
                : (input.id === 'plServiceImages' ? 'No files selected' : 'No file selected');
        });
    });

    function collectPreviewRows() {
        const type = selectedType();
        const rows = [
            ['Listing Type', type === 'business' ? 'Business' : 'Professional'],
            ['Listing Name', document.getElementById('plListingName').value],
            ['Category', document.getElementById('plCategory').value],
            ['Subcategory', document.getElementById('plSubcategory').value],
            ['Main Service / Specialization', document.getElementById('plSpecialization').value],
            ['Short Description', description.value],
            ['Experience / Years in Business', document.getElementById('plExperience').value]
        ];

        if (type === 'professional') {
            rows.push(
                ['Full Name', document.getElementById('plFullName').value],
                ['Profession / Designation', document.getElementById('plDesignation').value],
                ['Qualification', document.getElementById('plQualification').value],
                ['Experience', document.getElementById('plProfessionalExperience').value],
                ['Skills / Specializations', document.getElementById('plSkills').value],
                ['Languages Known', document.getElementById('plLanguages').value]
            );
        } else {
            rows.push(
                ['Business Name', document.getElementById('plBusinessName').value],
                ['Contact Person', document.getElementById('plContactPerson').value],
                ['Established Year', document.getElementById('plEstablishedYear').value],
                ['Business Type', document.getElementById('plBusinessType').value],
                ['Services Offered', document.getElementById('plBusinessServices').value],
                ['Business Website', document.getElementById('plBusinessWebsite').value]
            );
        }

        rows.push(
            ['Mobile Number', document.getElementById('plMobile').value],
            ['WhatsApp Number', document.getElementById('plWhatsapp').value],
            ['Email ID', document.getElementById('plEmail').value],
            ['Website', document.getElementById('plWebsite').value],
            ['Address', document.getElementById('plAddress').value],
            ['Area / Locality', document.getElementById('plLocality').value],
            ['City', document.getElementById('plCity').value],
            ['State', document.getElementById('plState').value],
            ['Pincode', document.getElementById('plPincode').value],
            ['Map Link', document.getElementById('plMapLink').value],
            ['Service Areas', document.getElementById('plServiceAreas').value]
        );

        return rows.filter(function (row) { return row[1] && row[1].trim(); });
    }

    function renderPreview() {
        previewContent.replaceChildren();
        collectPreviewRows().forEach(function (row) {
            const item = document.createElement('div');
            item.className = 'pl-preview-row';
            const label = document.createElement('span');
            label.textContent = row[0];
            const value = document.createElement('strong');
            value.textContent = row[1];
            item.append(label, value);
            previewContent.appendChild(item);
        });
    }

    function openPreview() {
        renderPreview();
        previewModal.hidden = false;
        document.body.style.overflow = 'hidden';
    }

    function closePreview() {
        previewModal.hidden = true;
        document.body.style.overflow = '';
    }

    document.getElementById('plPreviewButton').addEventListener('click', openPreview);
    document.querySelectorAll('[data-close-submit-modal]').forEach(function (button) {
        button.addEventListener('click', closePreview);
    });
    previewModal.addEventListener('click', function (event) {
        if (event.target === previewModal) closePreview();
    });

    function validateForm() {
        let firstInvalid = null;
        form.querySelectorAll('.pl-field-error').forEach(function (error) { error.textContent = ''; });
        form.querySelectorAll('[aria-invalid="true"]').forEach(function (field) { field.removeAttribute('aria-invalid'); });

        const fields = Array.from(form.querySelectorAll('[required]')).filter(function (field) {
            return !field.disabled && !field.closest('[hidden]');
        });

        fields.forEach(function (field) {
            let message = '';
            if (!field.value.trim()) {
                message = 'This field is required.';
            } else if (field.type === 'email' && !field.validity.valid) {
                message = 'Enter a valid email address.';
            } else if (field.type === 'url' && !field.validity.valid) {
                message = 'Enter a valid URL including https://.';
            } else if (field.id === 'plMobile' && field.value.replace(/\D/g, '').length < 10) {
                message = 'Enter a valid mobile number.';
            }

            if (message) {
                field.setAttribute('aria-invalid', 'true');
                const error = field.parentElement.querySelector('.pl-field-error');
                if (error) error.textContent = message;
                if (!firstInvalid) firstInvalid = field;
            }
        });

        if (firstInvalid) {
            firstInvalid.focus();
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        return true;
    }

    function showFeedback(title, message) {
        feedbackTitle.textContent = title;
        feedbackMessage.textContent = message;
        feedback.hidden = false;
        document.body.style.overflow = 'hidden';
    }

    function closeFeedback() {
        feedback.hidden = true;
        document.body.style.overflow = '';
    }

    document.getElementById('plFeedbackClose').addEventListener('click', closeFeedback);

    document.getElementById('plSaveDraft').addEventListener('click', function () {
        const formData = {};
        new FormData(form).forEach(function (value, key) {
            if (value instanceof File) return;
            if (Object.prototype.hasOwnProperty.call(formData, key)) {
                if (!Array.isArray(formData[key])) formData[key] = [formData[key]];
                formData[key].push(value);
            } else {
                formData[key] = value;
            }
        });

        try {
            localStorage.setItem('peoplelink-listing-draft', JSON.stringify(formData));
            showToast('Draft saved in this browser. It is not yet saved to your PeopleLink account.');
        } catch (error) {
            showToast('Browser storage is unavailable. Please copy your details before leaving this page.');
        }
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        if (!validateForm()) return;
        closePreview();
        // Real submission through the directory backend (same as the app); goes to admin approval
        const fd = new FormData(form);
        fd.append('csrf', (window.PL_WEB || {}).csrf || '');
        if (window.DS_EDIT_ID) fd.append('edit_id', window.DS_EDIT_ID);
        fetch(window.location.pathname + (window.DS_EDIT_ID ? '?edit=' + window.DS_EDIT_ID : ''), { method: 'POST', body: fd, credentials: 'same-origin' })
            .then(function (res) { return res.json(); })
            .then(function (r) {
                if (!r.ok) { showFeedback('Could not submit', r.error || 'Please check the form and try again.'); return; }
                try { localStorage.removeItem('peoplelink-listing-draft'); } catch (e) {}
                showFeedback(window.DS_EDIT_ID ? 'Profile Updated' : 'Profile Submitted Successfully',
                    (r.message || 'Saved.') + (r.upload_error ? ' Some images were not uploaded: ' + r.upload_error : '') + ' You can manage it from My Directory Profiles.');
                setTimeout(function () { window.location.href = 'my-directory-listings.php'; }, 2500);
            })
            .catch(function () { showFeedback('Could not submit', 'Could not reach the server. Please try again.'); });
    });

    document.getElementById('plPreviewSubmit').addEventListener('click', function () {
        closePreview();
        form.requestSubmit();
    });

    // Restore: server values (edit mode / account) first, otherwise a locally saved draft (file inputs excluded).
    try {
        const savedDraft = (window.DS_FILL && Object.keys(window.DS_FILL).length) ? window.DS_FILL : JSON.parse(localStorage.getItem('peoplelink-listing-draft') || 'null');
        if (savedDraft && typeof savedDraft === 'object') {
            Object.keys(savedDraft).forEach(function (key) {
                const elements = form.querySelectorAll('[name="' + CSS.escape(key) + '"]');
                if (!elements.length) return;
                const value = savedDraft[key];
                if (elements[0].type === 'file') return;
                if (elements[0].type === 'radio' || elements[0].type === 'checkbox') {
                    elements.forEach(function (element) {
                        element.checked = Array.isArray(value) ? value.includes(element.value) : element.value === value;
                    });
                } else {
                    elements[0].value = Array.isArray(value) ? value[0] : value;
                }
            });
        }
    } catch (error) {
        // Ignore malformed browser draft data.
    }

    updateListingType();
    descriptionCount.textContent = description.value.length;
    updateProgress();
});





/* PeopleLink — Saved Professionals & Businesses: frontend demo data/actions.
   Replace the demo data and localStorage persistence with your account/database API when integrating. */
(() => {
  "use strict";
  const STORAGE_KEY = "peoplelinkSavedProfessionalBusinessListings";
  const initialListings = [
    {id:101,type:"professional",name:"Dr. Ananya Sharma",category:"Healthcare & Wellness",service:"Dentist · Cosmetic Dentistry",location:"Rishikesh, Uttarakhand",description:"Patient-focused dental care with a special interest in preventive and cosmetic treatments.",image:"https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=240&q=80",savedAt:"2026-10-12T10:35:00",status:"active",profile:"professional-business-profile-details.php"},
    {id:102,type:"business",name:"Himalayan Digital Studio",category:"IT & Digital Services",service:"Web Design · SEO · Branding",location:"Dehradun, Uttarakhand",description:"Digital solutions for growing businesses, including websites, search visibility and brand identity.",image:"https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=240&q=80",savedAt:"2026-10-11T15:20:00",status:"active",profile:"professional-business-profile-details.php"},
    {id:103,type:"professional",name:"Rahul Verma",category:"Legal & Consulting",service:"Business Consulting",location:"Haridwar, Uttarakhand",description:"Supports small businesses with planning, documentation and practical operational guidance.",image:"/peoplelink/first/images/in/man-1.jpg?auto=format&fit=crop&w=240&q=80",savedAt:"2026-10-10T11:10:00",status:"active",profile:"professional-business-profile-details.php"},
    {id:104,type:"business",name:"Green Leaf Interiors",category:"Home & Lifestyle",service:"Residential · Office Interiors",location:"Rishikesh, Uttarakhand",description:"Thoughtful interior planning, space styling and furnishing solutions for homes and offices.",image:"https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=240&q=80",savedAt:"2026-10-09T09:15:00",status:"unavailable",profile:"professional-business-profile-details.php"},
    {id:105,type:"professional",name:"Meera Joshi",category:"Education & Training",service:"Career Coaching · Interview Prep",location:"Online · India",description:"Career guidance and interview preparation for students and professionals planning their next step.",image:"/peoplelink/first/images/in/woman-2.jpg?auto=format&fit=crop&w=240&q=80",savedAt:"2026-10-08T17:45:00",status:"active",profile:"professional-business-profile-details.php"},
    {id:106,type:"business",name:"North Valley Event Co.",category:"Events & Hospitality",service:"Community Events · Corporate Events",location:"Dehradun, Uttarakhand",description:"Event planning and coordination for community gatherings, celebrations and professional meetups.",image:"https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=240&q=80",savedAt:"2026-10-07T13:05:00",status:"active",profile:"professional-business-profile-details.php"}
  ];
  const $ = (selector, root=document) => root.querySelector(selector);
  const $$ = (selector, root=document) => [...root.querySelectorAll(selector)];
  let saved = loadSaved();
  let activeType = "all";
  let visibleLimit = 6;
  let activeContactListing = null;
  let toastTimer = null;

  function loadSaved(){
    if (Array.isArray(window.SAVED_DIR)) return window.SAVED_DIR.map(item => ({...item})); // live: the member's saved profiles
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      if(raw !== null) return JSON.parse(raw);
    } catch(e) {}
    return initialListings.map(item => ({...item}));
  }
  function persist(){ if (Array.isArray(window.SAVED_DIR)) return; try { localStorage.setItem(STORAGE_KEY, JSON.stringify(saved)); } catch(e) {} }
  function escapeHTML(value=""){
    return String(value).replace(/[&<>"']/g, ch => ({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[ch]));
  }
  function prettyDate(date){
    const d = new Date(date);
    if(Number.isNaN(d.getTime())) return "Saved recently";
    const now = new Date(); const diff = Math.max(0, now-d);
    if(diff < 86400000 && d.getDate()===now.getDate()) return "Saved today";
    if(diff < 172800000) return "Saved yesterday";
    return "Saved " + d.toLocaleDateString("en-IN",{day:"numeric",month:"short"});
  }
  function iconFor(item){ return item.type==="business" ? "bi-buildings" : "bi-person-workspace"; }
  function imageMarkup(item){
    if(item.image) return `<img class="listing-avatar" src="${escapeHTML(item.image)}" alt="${escapeHTML(item.name)}" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.hidden=false"><div class="listing-avatar avatar-fallback" hidden><i class="bi ${iconFor(item)}"></i></div>`;
    return `<div class="listing-avatar avatar-fallback"><i class="bi ${iconFor(item)}"></i></div>`;
  }
  function getFiltered(){
    const query = $("#listingSearch").value.trim().toLowerCase();
    const category = $("#categoryFilter").value;
    const location = $("#locationFilter").value;
    const sort = $("#sortBy").value;
    let list = saved.filter(item => {
      const matchType = activeType==="all" || item.type===activeType;
      const haystack = [item.name,item.category,item.service,item.location,item.description].join(" ").toLowerCase();
      return matchType && (!query || haystack.includes(query)) && (!category || item.category===category) && (!location || item.location===location);
    });
    list.sort((a,b) => sort==="name" ? a.name.localeCompare(b.name) : new Date(b.savedAt)-new Date(a.savedAt));
    return list;
  }
  function renderCard(item){
    const unavailable = item.status !== "active";
    return `<article class="listing-card" data-id="${item.id}">
      ${imageMarkup(item)}
      <div class="listing-main">
        <div class="listing-topline"><span class="listing-type ${item.type}">${item.type==="professional"?"Professional":"Business"}</span><span class="listing-status ${unavailable?"unavailable":""}">${unavailable?"Currently Unavailable":"Active"}</span></div>
        <h3>${escapeHTML(item.name)}</h3>
        <div class="listing-category">${escapeHTML(item.category)}</div>
        <p class="listing-description">${escapeHTML(item.description)}</p>
        <div class="listing-meta"><span><i class="bi ${iconFor(item)}"></i>${escapeHTML(item.service)}</span><span><i class="bi bi-geo-alt"></i>${escapeHTML(item.location)}</span></div>
      </div>
      <div class="listing-side"><span class="saved-date"><i class="bi bi-bookmark-check"></i> ${prettyDate(item.savedAt)}</span>
        <div class="listing-actions"><a class="action-btn primary" href="${escapeHTML(item.profile)}"><i class="bi bi-eye"></i> View Profile</a><button class="action-btn" data-action="contact" data-id="${item.id}" ${unavailable?"disabled title='This listing is currently unavailable'":""}><i class="bi bi-chat-dots"></i> Contact</button><button class="action-btn remove" data-action="remove" data-id="${item.id}"><i class="bi bi-bookmark-x"></i> Remove</button></div>
      </div></article>`;
  }
  function updateCounts(){
    const professionals=saved.filter(x=>x.type==="professional").length;
    const businesses=saved.filter(x=>x.type==="business").length;
    $("#heroSavedCount").textContent=saved.length; $("#sideTotal").textContent=saved.length;
    $("#sideProfessionals").textContent=professionals; $("#sideBusinesses").textContent=businesses;
    $("#allTabCount").textContent=saved.length; $("#professionalTabCount").textContent=professionals; $("#businessTabCount").textContent=businesses;
    $("#resultCount").textContent=getFiltered().length;
  }
  function fillFilters(){
    const oldCat=$("#categoryFilter").value, oldLoc=$("#locationFilter").value;
    const categories=[...new Set(saved.map(x=>x.category).filter(Boolean))].sort();
    const locations=[...new Set(saved.map(x=>x.location).filter(Boolean))].sort();
    $("#categoryFilter").innerHTML='<option value="">All categories</option>'+categories.map(x=>`<option value="${escapeHTML(x)}">${escapeHTML(x)}</option>`).join("");
    $("#locationFilter").innerHTML='<option value="">All locations</option>'+locations.map(x=>`<option value="${escapeHTML(x)}">${escapeHTML(x)}</option>`).join("");
    if(categories.includes(oldCat)) $("#categoryFilter").value=oldCat;
    if(locations.includes(oldLoc)) $("#locationFilter").value=oldLoc;
  }
  function render(){
    const list=getFiltered(); const shown=list.slice(0,visibleLimit);
    $("#listingGrid").innerHTML=shown.map(renderCard).join("");
    $("#noResults").hidden=list.length>0;
    $("#listingGrid").hidden=list.length===0;
    $("#loadMoreWrap").hidden=list.length<=visibleLimit;
    $("#resultCount").textContent=list.length;
    $("#resultsMessage").textContent=list.length===saved.length && activeType==="all" && !$("#listingSearch").value && !$("#categoryFilter").value && !$("#locationFilter").value ? "Showing all saved listings" : `Showing ${list.length} matching listing${list.length===1?"":"s"}`;
    updateCounts();
  }
  function toast(message){
    $("#toastMessage").textContent=message; $("#toast").classList.add("show");
    clearTimeout(toastTimer); toastTimer=setTimeout(()=>$("#toast").classList.remove("show"),2600);
  }
  function removeListing(id){
    const item=saved.find(x=>String(x.id)===String(id)); if(!item) return;
    const done = () => { saved=saved.filter(x=>String(x.id)!==String(id)); persist(); fillFilters(); render(); toast(`${item.name} removed from saved listings.`); };
    if (!Array.isArray(window.SAVED_DIR) || !window.PL) { done(); return; }
    PL.post("directory_save", { id: id }).then(r => {
      if (r.ok && r.saved) return PL.post("directory_save", { id: id }).then(() => toast("Could not remove. Please try again."));
      if (!r.ok) { toast(r.error || "Could not remove."); return; }
      done();
    }).catch(() => {});
  }
  function openContact(id){
    const item=saved.find(x=>String(x.id)===String(id)); if(!item || item.status!=="active") return;
    activeContactListing=item;
    $("#contactModalTitle").textContent="Contact listing";
    $("#contactListingName").textContent=`Your enquiry will be about ${item.name}.`;
    $("#contactModal").hidden=false; document.body.classList.add("modal-open");
    setTimeout(()=>$("#contactName").focus(),50);
  }
  function closeModal(){ $("#contactModal").hidden=true; document.body.classList.remove("modal-open"); }
  $$(".type-tab").forEach(button=>button.addEventListener("click",()=>{
    $$(".type-tab").forEach(x=>x.classList.toggle("active",x===button));
    activeType=button.dataset.type; visibleLimit=6; render();
  }));
  ["listingSearch","categoryFilter","locationFilter","sortBy"].forEach(id=>{
    $("#"+id).addEventListener(id==="listingSearch"?"input":"change",()=>{visibleLimit=6;render();});
  });
  $("#resetFilters").addEventListener("click",()=>{
    $("#listingSearch").value="";$("#categoryFilter").value="";$("#locationFilter").value="";$("#sortBy").value="recent";
    activeType="all";$$(".type-tab").forEach(x=>x.classList.toggle("active",x.dataset.type==="all"));visibleLimit=6;render();
  });
  $("#loadMore").addEventListener("click",()=>{visibleLimit+=6;render();});
  $("#listingGrid").addEventListener("click",event=>{
    const button=event.target.closest("[data-action]"); if(!button)return;
    if(button.dataset.action==="remove") removeListing(button.dataset.id);
    if(button.dataset.action==="contact") openContact(button.dataset.id);
  });
  $$("[data-close-modal]").forEach(el=>el.addEventListener("click",closeModal));
  $("#contactModal").addEventListener("click",event=>{if(event.target===$("#contactModal"))closeModal();});
  document.addEventListener("keydown",event=>{if(event.key==="Escape"&&!$("#contactModal").hidden)closeModal();});
  $("#contactForm").addEventListener("submit",event=>{
    event.preventDefault();
    if(!activeContactListing)return;
    if (Array.isArray(window.SAVED_DIR) && window.PL) {
      const f=$("#contactForm"); const data={id:activeContactListing.id}; new FormData(f).forEach((v,k)=>{data[k]=v;});
      PL.post("directory_enquiry", data).then(r=>{ toast(r.ok ? `Enquiry sent to ${activeContactListing.name}.` : (r.error || "Could not send.")); if(r.ok){ f.reset(); closeModal(); } }).catch(()=>{});
      return;
    }
    toast(`Enquiry prepared for ${activeContactListing.name}. Connect a backend to send it.`);
    $("#contactForm").reset();closeModal();
  });
  fillFilters();render();
})();





/* PeopleLink Page 8 — Enquiry / Contact frontend demo.
   URL parameters supported: ?name=...&type=business&category=...&service=...&location=...&image=...&direct=0
   Replace demo account fields and submission simulation with authenticated server/API integration. */
(() => {
  "use strict";
  const $ = (selector, root=document) => root.querySelector(selector);
  const params = new URLSearchParams(window.location.search);
  const defaultListing = {
    name: "Dr. Ananya Sharma",
    type: "professional",
    category: "Healthcare & Wellness",
    service: "Dentist · Cosmetic Dentistry",
    location: "Rishikesh, Uttarakhand",
    image: "https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=240&q=80",
    direct: true,
    phone: "919876543210",
    email: "hello@example.com"
  };
  const listing = window.EQ_LISTING || {
    ...defaultListing,
    name: params.get("name") || defaultListing.name,
    type: params.get("type") === "business" ? "business" : defaultListing.type,
    category: params.get("category") || defaultListing.category,
    service: params.get("service") || defaultListing.service,
    location: params.get("location") || defaultListing.location,
    image: params.get("image") || defaultListing.image,
    direct: params.get("direct") !== "0",
    phone: params.get("phone") || defaultListing.phone,
    email: params.get("email") || defaultListing.email,
    profile: params.get("profile") || "professional-business-profile-details.php"
  };
  $("#listingName").textContent = listing.name;
  $("#listingKind").textContent = listing.type === "business" ? "BUSINESS" : "PROFESSIONAL";
  $("#listingCategory").textContent = listing.category;
  $("#listingService").textContent = listing.service;
  $("#listingLocation").textContent = listing.location;
  $("#listingPhoto").src = listing.image;
  $("#listingPhoto").alt = listing.name + " profile photo or logo";
  $("#backProfile").href = listing.profile;
  $("#successBackProfile").href = listing.profile;
  $("#subject").value = "Enquiry about " + listing.service;
  $("#directContact").hidden = !listing.direct;
  $("#restrictedNote").hidden = listing.direct;
  $("#callNow").href = "tel:+" + listing.phone.replace(/\D/g,"");
  $("#whatsApp").href = "https://wa.me/" + listing.phone.replace(/\D/g,"") + "?text=" + encodeURIComponent("Hello, I found your listing on PeopleLink and would like to enquire about " + listing.service + ".");
  $("#emailOwner").href = "mailto:" + listing.email + "?subject=" + encodeURIComponent("PeopleLink enquiry: " + listing.name);

  /* Optional logged-in demo autofill. In production, populate these fields server-side
     from the authenticated account, never trust a browser-provided identity for security. */
  try {
    const account = window.EQ_ACCOUNT || JSON.parse(localStorage.getItem("peoplelinkDemoAccount") || "null");
    if (account) {
      if (account.fullName) $("#fullName").value = account.fullName;
      if (account.mobile) $("#mobile").value = String(account.mobile).replace(/\D/g,"").slice(-10);
      if (account.email) $("#email").value = account.email;
    }
  } catch(e) {}

  $("#message").addEventListener("input", () => {
    $("#messageCount").textContent = $("#message").value.length;
  });
  $("#mobile").addEventListener("input", () => {
    $("#mobile").value = $("#mobile").value.replace(/\D/g,"").slice(0,10);
  });

  const requiredFields = ["fullName","mobile","email","subject","message"];
  function setError(id, message) {
    const field = $("#"+id);
    const error = $(`[data-error="${id}"]`);
    field.classList.toggle("invalid", Boolean(message));
    field.setAttribute("aria-invalid", message ? "true" : "false");
    if(error) error.textContent = message || "";
  }
  function validate() {
    let valid = true;
    const name = $("#fullName").value.trim();
    const mobile = $("#mobile").value.trim();
    const email = $("#email").value.trim();
    const subject = $("#subject").value.trim();
    const message = $("#message").value.trim();
    const checks = {
      fullName: name ? "" : "Please enter your full name.",
      mobile: /^\d{10}$/.test(mobile) ? "" : "Enter a valid 10-digit mobile number.",
      email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) ? "" : "Enter a valid email address.",
      subject: subject ? "" : "Please enter an enquiry subject.",
      message: message.length >= 10 ? "" : "Please enter at least 10 characters about your requirement."
    };
    requiredFields.forEach(id => { setError(id,checks[id]); if(checks[id]) valid=false; });
    $("#formErrorSummary").hidden = valid;
    if(!valid) {
      const first=requiredFields.find(id=>checks[id]);
      $("#"+first).focus({preventScroll:false});
    }
    return valid;
  }
  function showToast(message) {
    $("#toastText").textContent=message;
    $("#toast").classList.add("show");
    window.clearTimeout(showToast.timer);
    showToast.timer=window.setTimeout(()=>$("#toast").classList.remove("show"),2600);
  }
  function createEnquiryId() {
    return "PL-ENQ-" + Date.now().toString().slice(-8);
  }
  $("#enquiryForm").addEventListener("submit", event => {
    event.preventDefault();
    if(!validate()) return;
    const preferred = $('input[name="preferredMethod"]:checked')?.value || "Email";
    const enquiry = {
      id:createEnquiryId(),
      date:new Date().toISOString(),
      listingName:listing.name,
      listingType:listing.type,
      fullName:$("#fullName").value.trim(),
      mobile:$("#mobile").value.trim(),
      email:$("#email").value.trim(),
      subject:$("#subject").value.trim(),
      message:$("#message").value.trim(),
      preferredMethod:preferred
    };
    if (window.EQ_LISTING && window.PL) {
      // Real enquiry: saved by the directory backend and the owner is notified (same as the app)
      const btn = $("#submitEnquiry"); btn.disabled = true;
      PL.post("directory_enquiry", { id: listing.id, name: enquiry.fullName, phone: enquiry.mobile, email: enquiry.email,
        message: "Subject: " + enquiry.subject + "\n\n" + enquiry.message + "\n\nPreferred contact: " + preferred })
        .then(r => {
          btn.disabled = false;
          if (!r.ok) { showToast(r.error || "Could not send the enquiry."); return; }
          $("#confirmationId").textContent = "PL-ENQ-" + String(r.enquiry_id).padStart(6, "0");
          $("#confirmationDate").textContent = new Date().toLocaleDateString("en-IN",{day:"numeric",month:"long",year:"numeric"});
          $("#confirmationListing").textContent = listing.name;
          $("#enquiryPanel").hidden = true; $(".listing-summary").hidden = true; $("#successPanel").hidden = false;
          window.scrollTo({top:$("#successPanel").getBoundingClientRect().top+window.scrollY-20,behavior:"smooth"});
        }).catch(() => { btn.disabled = false; });
      return;
    }
    try { localStorage.setItem("peoplelinkLastDemoEnquiry",JSON.stringify(enquiry)); } catch(e) {}
    $("#confirmationId").textContent=enquiry.id;
    $("#confirmationDate").textContent=new Date(enquiry.date).toLocaleDateString("en-IN",{day:"numeric",month:"long",year:"numeric"});
    $("#confirmationListing").textContent=listing.name;
    $("#enquiryPanel").hidden=true;
    $(".listing-summary").hidden=true;
    $("#successPanel").hidden=false;
    window.scrollTo({top:$("#successPanel").getBoundingClientRect().top+window.scrollY-20,behavior:"smooth"});
  });
  $("#copyEnquiryId").addEventListener("click", async () => {
    const id=$("#confirmationId").textContent;
    try {
      await navigator.clipboard.writeText(id);
      showToast("Enquiry ID copied.");
    } catch(e) {
      const temp=document.createElement("textarea");
      temp.value=id;temp.style.position="fixed";temp.style.opacity="0";document.body.appendChild(temp);temp.select();
      try { document.execCommand("copy");showToast("Enquiry ID copied."); } catch(err) { showToast("Enquiry ID: "+id); }
      temp.remove();
    }
  });
})();



