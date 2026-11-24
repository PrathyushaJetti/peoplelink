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
    if (!filterForm) return; // this block belongs to another page
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
    if (!form) return; // this block belongs to another page
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
        showFeedback(
            'Listing Submitted Successfully',
            'Demo mode: your listing has not been sent to the server. Connect this form to your PeopleLink backend to submit it for review.'
        );
    });

    document.getElementById('plPreviewSubmit').addEventListener('click', function () {
        closePreview();
        form.requestSubmit();
    });

    // Restore a locally saved draft, excluding file inputs for security/browser reasons.
    try {
        const savedDraft = JSON.parse(localStorage.getItem('peoplelink-listing-draft') || 'null');
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
  if (!document.getElementById("listingSearch")) return; // this block belongs to another page
  const STORAGE_KEY = "peoplelinkSavedProfessionalBusinessListings";
  const initialListings = [
    {id:101,type:"professional",name:"Dr. Ananya Sharma",category:"Healthcare & Wellness",service:"Dentist · Cosmetic Dentistry",location:"Rishikesh, Uttarakhand",description:"Patient-focused dental care with a special interest in preventive and cosmetic treatments.",image:"https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=240&q=80",savedAt:"2026-10-12T10:35:00",status:"active",profile:"professional-and-business-profile-details.html"},
    {id:102,type:"business",name:"Himalayan Digital Studio",category:"IT & Digital Services",service:"Web Design · SEO · Branding",location:"Dehradun, Uttarakhand",description:"Digital solutions for growing businesses, including websites, search visibility and brand identity.",image:"https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=240&q=80",savedAt:"2026-10-11T15:20:00",status:"active",profile:"professional-and-business-profile-details.html"},
    {id:103,type:"professional",name:"Rahul Verma",category:"Legal & Consulting",service:"Business Consulting",location:"Haridwar, Uttarakhand",description:"Supports small businesses with planning, documentation and practical operational guidance.",image:"/peoplelink/first/images/in/man-1.jpg?auto=format&fit=crop&w=240&q=80",savedAt:"2026-10-10T11:10:00",status:"active",profile:"professional-and-business-profile-details.html"},
    {id:104,type:"business",name:"Green Leaf Interiors",category:"Home & Lifestyle",service:"Residential · Office Interiors",location:"Rishikesh, Uttarakhand",description:"Thoughtful interior planning, space styling and furnishing solutions for homes and offices.",image:"https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=240&q=80",savedAt:"2026-10-09T09:15:00",status:"unavailable",profile:"professional-and-business-profile-details.html"},
    {id:105,type:"professional",name:"Meera Joshi",category:"Education & Training",service:"Career Coaching · Interview Prep",location:"Online · India",description:"Career guidance and interview preparation for students and professionals planning their next step.",image:"/peoplelink/first/images/in/woman-2.jpg?auto=format&fit=crop&w=240&q=80",savedAt:"2026-10-08T17:45:00",status:"active",profile:"professional-and-business-profile-details.html"},
    {id:106,type:"business",name:"North Valley Event Co.",category:"Events & Hospitality",service:"Community Events · Corporate Events",location:"Dehradun, Uttarakhand",description:"Event planning and coordination for community gatherings, celebrations and professional meetups.",image:"https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=240&q=80",savedAt:"2026-10-07T13:05:00",status:"active",profile:"professional-and-business-profile-details.html"}
  ];
  const $ = (selector, root=document) => root.querySelector(selector);
  const $$ = (selector, root=document) => [...root.querySelectorAll(selector)];
  let saved = loadSaved();
  let activeType = "all";
  let visibleLimit = 6;
  let activeContactListing = null;
  let toastTimer = null;

  function loadSaved(){
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      if(raw !== null) return JSON.parse(raw);
    } catch(e) {}
    return initialListings.map(item => ({...item}));
  }
  function persist(){ try { localStorage.setItem(STORAGE_KEY, JSON.stringify(saved)); } catch(e) {} }
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
    saved=saved.filter(x=>String(x.id)!==String(id)); persist(); fillFilters(); render(); toast(`${item.name} removed from saved listings.`);
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
  if (!document.getElementById("listingName")) return; // this block belongs to another page
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
  const listing = {
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
    profile: params.get("profile") || "professional-and-business-profile-details.html"
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
    const account = JSON.parse(localStorage.getItem("peoplelinkDemoAccount") || "null");
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
    /* Demo only: keep the latest submission locally. Production should POST this data
       to a protected backend with authentication, CSRF protection, validation and rate limits. */
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






document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('plMarketplaceSearch');
    const keywordInput = document.getElementById('plMarketKeyword');
    const categoryInput = document.getElementById('plMarketCategory');
    const locationInput = document.getElementById('plMarketLocation');
    const sortSelect = document.getElementById('plMarketSort');
    const listingGrid = document.getElementById('plMarketListingGrid');
    const resultCount = document.getElementById('plMarketResultCount');
    const noResults = document.getElementById('plMarketNoResults');
    const resetButton = document.getElementById('plMarketResetSearch');

    if (!searchForm || !listingGrid) return;

    const listingCards = Array.from(
        listingGrid.querySelectorAll('.pl-market-listing-card')
    );

    function filterListings() {
        const keyword = keywordInput.value.trim().toLowerCase();
        const category = categoryInput.value.trim().toLowerCase();
        const location = locationInput.value.trim().toLowerCase();
        let visibleCount = 0;

        listingCards.forEach(function (card) {
            const name = (card.dataset.name || '').toLowerCase();
            const cardCategory = (card.dataset.category || '').toLowerCase();
            const cardLocation = (card.dataset.location || '').toLowerCase();
            const description = (
                card.querySelector('.pl-market-listing-description')?.textContent || ''
            ).toLowerCase();

            const matchesKeyword = !keyword ||
                name.includes(keyword) ||
                cardCategory.includes(keyword) ||
                cardLocation.includes(keyword) ||
                description.includes(keyword);

            const matchesCategory = !category || cardCategory === category;
            const matchesLocation = !location || cardLocation.includes(location);
            const visible = matchesKeyword && matchesCategory && matchesLocation;

            card.hidden = !visible;
            if (visible) visibleCount++;
        });

        resultCount.textContent = visibleCount;
        noResults.hidden = visibleCount > 0;
        listingGrid.hidden = visibleCount === 0;

        document.querySelectorAll('[data-market-category]').forEach(function (button) {
            button.classList.toggle(
                'is-active',
                button.dataset.marketCategory.toLowerCase() === category
            );
        });
    }

    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();
        filterListings();

        document.getElementById('marketplace-listings').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });

    [keywordInput, categoryInput, locationInput].forEach(function (field) {
        field.addEventListener('input', filterListings);
        field.addEventListener('change', filterListings);
    });

    document.querySelectorAll('[data-market-category]').forEach(function (button) {
        button.addEventListener('click', function () {
            categoryInput.value = button.dataset.marketCategory;
            filterListings();

            document.getElementById('marketplace-listings').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });
    });

    sortSelect.addEventListener('change', function () {
        const sortValue = sortSelect.value;
        const sortedCards = listingCards.slice();

        sortedCards.sort(function (a, b) {
            if (sortValue === 'name') {
                return a.dataset.name.localeCompare(b.dataset.name);
            }

            if (sortValue === 'price-low') {
                return Number(a.dataset.price) - Number(b.dataset.price);
            }

            if (sortValue === 'price-high') {
                return Number(b.dataset.price) - Number(a.dataset.price);
            }

            return new Date(b.dataset.date) - new Date(a.dataset.date);
        });

        sortedCards.forEach(function (card) {
            listingGrid.appendChild(card);
        });

        filterListings();
    });

    if (resetButton) {
        resetButton.addEventListener('click', function () {
            searchForm.reset();
            sortSelect.value = 'recent';

            listingCards.forEach(function (card) {
                listingGrid.appendChild(card);
                card.hidden = false;
            });

            filterListings();
        });
    }

    // Demo-only save functionality. Connect to user accounts later.
    let savedIds = [];

    try {
        savedIds = JSON.parse(sessionStorage.getItem('plMarketplaceSaved') || '[]');
    } catch (error) {
        savedIds = [];
    }

    function updateSaveButton(button, saved) {
        button.classList.toggle('is-saved', saved);
        button.setAttribute('aria-pressed', saved ? 'true' : 'false');

        const icon = button.querySelector('i');
        if (icon) {
            icon.className = saved ? 'bi bi-heart-fill' : 'bi bi-heart';
        }
    }

    document.querySelectorAll('[data-save-id]').forEach(function (button) {
        const id = String(button.dataset.saveId);
        updateSaveButton(button, savedIds.includes(id));

        button.addEventListener('click', function () {
            const currentId = String(button.dataset.saveId);

            if (savedIds.includes(currentId)) {
                savedIds = savedIds.filter(function (savedId) {
                    return savedId !== currentId;
                });
            } else {
                savedIds.push(currentId);
            }

            try {
                sessionStorage.setItem(
                    'plMarketplaceSaved',
                    JSON.stringify(savedIds)
                );
            } catch (error) {
                // Save state still updates for the current page view.
            }

            updateSaveButton(button, savedIds.includes(currentId));
        });
    });

    const nearMeButton = document.getElementById('plMarketNearMe');

    if (nearMeButton) {
        nearMeButton.addEventListener('click', function () {
            if (!navigator.geolocation) {
                alert('Location is not supported by your browser. Please enter your city.');
                locationInput.focus();
                return;
            }

            nearMeButton.disabled = true;

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const params = new URLSearchParams({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    });

                    nearMeButton.disabled = false;
                    window.location.href = 'marketplace-search.php?' + params.toString();
                },
                function () {
                    nearMeButton.disabled = false;
                    alert('Unable to access your location. Please enter your city or locality.');
                    locationInput.focus();
                },
                {
                    enableHighAccuracy: false,
                    timeout: 10000,
                    maximumAge: 300000
                }
            );
        });
    }

    // Optional filters supplied in the URL.
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('keyword')) keywordInput.value = urlParams.get('keyword');
    if (urlParams.has('category')) categoryInput.value = urlParams.get('category');
    if (urlParams.has('location')) locationInput.value = urlParams.get('location');

    filterListings();
});






document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('plMarketplaceFilterForm');

    if (!form) return;

    const category = document.getElementById('plMsCategory');
    const postedWithin = document.getElementById('plMsPostedWithin');
    const sort = document.getElementById('plMsSort');
    const city = document.getElementById('plMsCity');
    const area = document.getElementById('plMsArea');
    const minPrice = document.getElementById('plMsMinPrice');
    const maxPrice = document.getElementById('plMsMaxPrice');
    const latitude = document.getElementById('plMsLatitude');
    const longitude = document.getElementById('plMsLongitude');
    const locationStatus = document.getElementById('plMsLocationStatus');
    const useLocationButton = document.getElementById('plMsUseLocation');
    const resetButton = document.getElementById('plMsResetFilters');

    // Quick category and date filters
    document.querySelectorAll('.pl-ms-quick-chip[data-category]').forEach(function (button) {
        button.addEventListener('click', function () {
            category.value = button.dataset.category;

            document.querySelectorAll('.pl-ms-quick-chip').forEach(function (chip) {
                chip.classList.remove('is-active');
            });

            button.classList.add('is-active');
        });
    });

    document.querySelectorAll('.pl-ms-quick-chip[data-posted]').forEach(function (button) {
        button.addEventListener('click', function () {
            postedWithin.value = button.dataset.posted;

            document.querySelectorAll('.pl-ms-quick-chip').forEach(function (chip) {
                chip.classList.remove('is-active');
            });

            button.classList.add('is-active');
        });
    });

    // Use browser location with user permission
    function requestLocation() {
        if (!navigator.geolocation) {
            locationStatus.textContent =
                'Location is not supported by your browser. Please enter a city or locality.';
            return;
        }

        useLocationButton.disabled = true;
        locationStatus.textContent = 'Requesting your location permission...';

        navigator.geolocation.getCurrentPosition(
            function (position) {
                latitude.value = position.coords.latitude;
                longitude.value = position.coords.longitude;

                locationStatus.textContent =
                    'Location captured. Apply filters to search nearby listings.';

                useLocationButton.disabled = false;
            },
            function () {
                locationStatus.textContent =
                    'Unable to access your location. Please allow permission or enter your location manually.';

                useLocationButton.disabled = false;
            },
            {
                enableHighAccuracy: false,
                timeout: 10000,
                maximumAge: 300000
            }
        );
    }

    useLocationButton.addEventListener('click', requestLocation);

    // Near Me quick filter
    document.getElementById('plMsNearMe').addEventListener('click', function () {
        document.querySelectorAll('.pl-ms-quick-chip').forEach(function (chip) {
            chip.classList.remove('is-active');
        });

        this.classList.add('is-active');
        requestLocation();
    });

    // Price validation
    form.addEventListener('submit', function (event) {
        const minimum = minPrice.value.trim();
        const maximum = maxPrice.value.trim();

        if (minimum !== '' && Number(minimum) < 0) {
            event.preventDefault();
            alert('Minimum price cannot be negative.');
            minPrice.focus();
            return;
        }

        if (maximum !== '' && Number(maximum) < 0) {
            event.preventDefault();
            alert('Maximum price cannot be negative.');
            maxPrice.focus();
            return;
        }

        if (
            minimum !== '' &&
            maximum !== '' &&
            Number(minimum) > Number(maximum)
        ) {
            event.preventDefault();
            alert('Minimum price cannot be greater than maximum price.');
            minPrice.focus();
            return;
        }

        // The form submits to marketplace-search-results.php.
        // That page must implement the actual database filtering.
    });

    // Reset filters and quick-filter highlights
    resetButton.addEventListener('click', function () {
        window.setTimeout(function () {
            document.querySelectorAll('.pl-ms-quick-chip').forEach(function (chip) {
                chip.classList.remove('is-active');
            });

            latitude.value = '';
            longitude.value = '';
            locationStatus.textContent = '';
        }, 0);
    });

    // Restore filters when returning through a query-string URL
    const params = new URLSearchParams(window.location.search);

    const fieldMap = {
        listing_name: 'plMsListingName',
        keyword: 'plMsKeyword',
        category: 'plMsCategory',
        city: 'plMsCity',
        area: 'plMsArea',
        min_price: 'plMsMinPrice',
        max_price: 'plMsMaxPrice',
        condition: 'plMsCondition',
        posted_within: 'plMsPostedWithin',
        sort: 'plMsSort',
        latitude: 'plMsLatitude',
        longitude: 'plMsLongitude'
    };

    Object.keys(fieldMap).forEach(function (parameter) {
        const field = document.getElementById(fieldMap[parameter]);

        if (field && params.has(parameter)) {
            field.value = params.get(parameter);
        }
    });
});






 
document.addEventListener("DOMContentLoaded", function () {
    const page = document.querySelector(".pl-md-page");
    if (!page) return;

    const mainImage = document.getElementById("plMdMainImage");
    const imageCount = document.getElementById("plMdImageCount");
    const thumbnails = Array.from(
        document.querySelectorAll(".pl-md-thumbnail")
    );

    const saveButton = document.getElementById("plMdSave");
    const shareButton = document.getElementById("plMdShare");
    const enquiryModal = document.getElementById("plMdEnquiryModal");
    const reportModal = document.getElementById("plMdReportModal");
    const openEnquiryButton = document.getElementById("plMdOpenEnquiry");
    const reportButton = document.getElementById("plMdReport");
    const enquiryForm = document.getElementById("plMdEnquiryForm");
    const reportForm = document.getElementById("plMdReportForm");
    const toast = document.getElementById("plMdToast");

    let previousFocus = null;

    /* Toast message */
    function showToast(message) {
        toast.textContent = message;
        toast.classList.add("show");

        clearTimeout(showToast.timer);

        showToast.timer = setTimeout(function () {
            toast.classList.remove("show");
        }, 2800);
    }

    /* Image gallery */
    thumbnails.forEach(function (thumbnail, index) {
        thumbnail.addEventListener("click", function () {
            const imageUrl = thumbnail.dataset.image;

            if (!imageUrl) return;

            mainImage.src = imageUrl;
            mainImage.alt =
                thumbnail.querySelector("img")?.alt || "Listing image";

            thumbnails.forEach(function (item) {
                item.classList.remove("active");
            });

            thumbnail.classList.add("active");
            imageCount.textContent =
                (index + 1) + " / " + thumbnails.length;
        });
    });

    /* Save listing - demo interaction */
    saveButton.addEventListener("click", function () {
        const currentlySaved =
            saveButton.getAttribute("aria-pressed") === "true";

        const newSavedState = !currentlySaved;

        saveButton.setAttribute("aria-pressed", String(newSavedState));
        saveButton.classList.toggle("saved", newSavedState);

        const icon = saveButton.querySelector("i");
        const text = saveButton.querySelector("span");

        if (newSavedState) {
            icon.classList.remove("far");
            icon.classList.add("fas");
            text.textContent = "Saved";
            showToast(
                "Listing saved for this session. Sign in to save it to your account."
            );
        } else {
            icon.classList.remove("fas");
            icon.classList.add("far");
            text.textContent = "Save Listing";
            showToast("Listing removed from saved items.");
        }
    });

    /* Share listing */
    shareButton.addEventListener("click", async function () {
        const shareData = {
            title: document.title || "PeopleLink Marketplace Listing",
            text: "Check out this marketplace listing on PeopleLink.",
            url: window.location.href
        };

        try {
            if (navigator.share) {
                await navigator.share(shareData);
            } else if (navigator.clipboard?.writeText) {
                await navigator.clipboard.writeText(shareData.url);
                showToast("Listing link copied.");
            } else {
                showToast("Copy the page link from your browser address bar.");
            }
        } catch (error) {
            if (error.name !== "AbortError") {
                showToast("Unable to share right now. Copy the page link instead.");
            }
        }
    });

    /* Modal helpers */
    function openModal(modal) {
        if (!modal) return;

        previousFocus = document.activeElement;
        modal.classList.add("open");
        modal.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";

        const firstInput = modal.querySelector(
            "input, select, textarea, button"
        );

        if (firstInput) {
            setTimeout(function () {
                firstInput.focus();
            }, 50);
        }
    }

    function closeModal(modal) {
        if (!modal) return;

        modal.classList.remove("open");
        modal.setAttribute("aria-hidden", "true");

        if (!document.querySelector(".pl-md-modal.open")) {
            document.body.style.overflow = "";
        }

        if (previousFocus && typeof previousFocus.focus === "function") {
            previousFocus.focus();
        }
    }

    openEnquiryButton.addEventListener("click", function () {
        openModal(enquiryModal);
    });

    reportButton.addEventListener("click", function () {
        openModal(reportModal);
    });

    document.querySelectorAll("[data-close-modal]").forEach(function (element) {
        element.addEventListener("click", function () {
            const modal = element.closest(".pl-md-modal");
            closeModal(modal);
        });
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            document.querySelectorAll(".pl-md-modal.open").forEach(function (modal) {
                closeModal(modal);
            });
        }
    });

    /* Demo enquiry form */
    enquiryForm.addEventListener("submit", function (event) {
        event.preventDefault();

        if (!enquiryForm.reportValidity()) return;

        showToast(
            "Demo only: connect this form to your enquiry submission handler."
        );

        closeModal(enquiryModal);
        enquiryForm.reset();
    });

    /* Demo report form */
    reportForm.addEventListener("submit", function (event) {
        event.preventDefault();

        if (!reportForm.reportValidity()) return;

        showToast(
            "Demo only: connect this report form to your moderation system."
        );

        closeModal(reportModal);
        reportForm.reset();
    });
});






 
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("plPostForm");
    if (!form) return;

    const categoryDetails = document.getElementById("plPostCategoryDetails");
    const dynamicTitle = document.getElementById("plPostDynamicTitle");
    const dynamicGroups = Array.from(
        document.querySelectorAll(".pl-post-dynamic-group")
    );

    const mainImageInput = document.getElementById("plPostMainImage");
    const additionalImagesInput = document.getElementById("plPostAdditionalImages");
    const imagePreview = document.getElementById("plPostImagePreview");

    const previewModal = document.getElementById("plPostPreviewModal");
    const feedbackModal = document.getElementById("plPostFeedbackModal");
    const previewContent = document.getElementById("plPostPreviewContent");

    const toast = document.getElementById("plPostToast");
    const draftButton = document.getElementById("plPostSaveDraft");
    const previewButton = document.getElementById("plPostPreview");
    const previewSubmitButton = document.getElementById("plPostPreviewSubmit");
    const feedbackCloseButton = document.getElementById("plPostFeedbackClose");

    const shortDescription = document.getElementById("plPostShortDescription");
    const description = document.getElementById("plPostDescription");

    const subcategories = {
        Property: [
            "Apartment / Flat",
            "Independent House",
            "Villa",
            "Residential Plot",
            "Commercial Property",
            "Shop / Office",
            "Land",
            "Other"
        ],
        Cars: [
            "Hatchback",
            "Sedan",
            "SUV",
            "Luxury Car",
            "Electric Car",
            "Other"
        ],
        Bikes: [
            "Motorcycle",
            "Scooter",
            "Electric Scooter",
            "Electric Bike",
            "Other"
        ],
        Electronics: [
            "Mobile Phones",
            "Laptops",
            "Computers",
            "Tablets",
            "Televisions",
            "Cameras",
            "Home Appliances",
            "Accessories",
            "Other"
        ],
        Furniture: [
            "Sofa",
            "Bed",
            "Table",
            "Chair",
            "Wardrobe",
            "Office Furniture",
            "Other"
        ],
        Products: [
            "Clothing",
            "Footwear",
            "Books",
            "Home Products",
            "Handmade Products",
            "Accessories",
            "Other"
        ],
        Services: [
            "Home Services",
            "Repair & Maintenance",
            "Professional Services",
            "Education & Training",
            "Events",
            "Business Services",
            "Other"
        ],
        Other: [
            "Collectibles",
            "Sports Equipment",
            "Musical Instruments",
            "Hobby Items",
            "Other"
        ]
    };

    let currentObjectUrls = [];
    let previousFocus = null;

    /* Toast notification */
    function showToast(message) {
        toast.textContent = message;
        toast.classList.add("show");

        clearTimeout(showToast.timer);

        showToast.timer = setTimeout(function () {
            toast.classList.remove("show");
        }, 3000);
    }

    /* Selected category */
    function getSelectedCategory() {
        const selected = form.querySelector('input[name="category"]:checked');
        return selected ? selected.value : "";
    }

    /* Rebuild subcategories */
    function updateSubcategories(category, selectedValue) {
        const select = document.getElementById("plPostSubcategory");

        select.replaceChildren();

        const placeholder = document.createElement("option");
        placeholder.value = "";
        placeholder.textContent = "Select subcategory";
        select.appendChild(placeholder);

        (subcategories[category] || []).forEach(function (name) {
            const option = document.createElement("option");
            option.value = name;
            option.textContent = name;

            if (selectedValue === name) {
                option.selected = true;
            }

            select.appendChild(option);
        });
    }

    /* Show fields for selected category */
    function updateCategoryFields() {
        const category = getSelectedCategory();

        categoryDetails.hidden = !category;

        dynamicGroups.forEach(function (group) {
            const categories = (group.dataset.category || "")
                .split(",")
                .map(function (item) {
                    return item.trim();
                });

            const isVisible = categories.includes(category);
            group.hidden = !isVisible;

            // Hidden category fields must not block form submission.
            group.querySelectorAll("input, select, textarea").forEach(function (field) {
                field.disabled = !isVisible;
            });
        });

        if (!category) {
            document.getElementById("plPostSubcategory").replaceChildren();
            return;
        }

        dynamicTitle.textContent = category + " Details";

        const currentSubcategory =
            document.getElementById("plPostSubcategory").value;

        updateSubcategories(category, currentSubcategory);
    }

    form.querySelectorAll('input[name="category"]').forEach(function (radio) {
        radio.addEventListener("change", function () {
            updateCategoryFields();
        });
    });

    /* Character counters */
    function updateCharacterCount(input, output) {
        output.textContent = input.value.length;
    }

    shortDescription.addEventListener("input", function () {
        updateCharacterCount(
            shortDescription,
            document.getElementById("plPostShortCount")
        );
    });

    description.addEventListener("input", function () {
        updateCharacterCount(
            description,
            document.getElementById("plPostDescriptionCount")
        );
    });

    /* Manage temporary image preview URLs */
    function clearObjectUrls() {
        currentObjectUrls.forEach(function (url) {
            URL.revokeObjectURL(url);
        });

        currentObjectUrls = [];
    }

    function validateImageFiles(files) {
        const allowedTypes = [
            "image/jpeg",
            "image/png",
            "image/webp"
        ];

        for (const file of files) {
            if (!allowedTypes.includes(file.type)) {
                showToast("Please choose JPG, PNG or WebP images.");
                return false;
            }

            if (file.size > 5 * 1024 * 1024) {
                showToast("Each image must be 5 MB or smaller.");
                return false;
            }
        }

        return true;
    }

    function renderImagePreviews() {
        clearObjectUrls();
        imagePreview.replaceChildren();

        const mainFile = mainImageInput.files[0];
        const additionalFiles = Array.from(additionalImagesInput.files || []);

        const allFiles = [];

        if (mainFile) {
            allFiles.push({
                file: mainFile,
                label: "Main Image"
            });
        }

        additionalFiles.forEach(function (file, index) {
            allFiles.push({
                file: file,
                label: "Additional " + (index + 1)
            });
        });

        allFiles.forEach(function (item) {
            const url = URL.createObjectURL(item.file);
            currentObjectUrls.push(url);

            const wrapper = document.createElement("div");
            wrapper.className = "pl-post-preview-image";

            const image = document.createElement("img");
            image.src = url;
            image.alt = item.label;

            const label = document.createElement("span");
            label.textContent = item.label;

            wrapper.append(image, label);
            imagePreview.appendChild(wrapper);
        });
    }

    mainImageInput.addEventListener("change", function () {
        const file = mainImageInput.files[0];

        if (file && !validateImageFiles([file])) {
            mainImageInput.value = "";
        }

        renderImagePreviews();
    });

    additionalImagesInput.addEventListener("change", function () {
        const files = Array.from(additionalImagesInput.files || []);

        if (!validateImageFiles(files)) {
            additionalImagesInput.value = "";
        }

        renderImagePreviews();
    });

    /* Form values for preview */
    function getFieldValue(id) {
        const element = document.getElementById(id);
        if (!element) return "";

        if (element.type === "radio") {
            const selected = form.querySelector(
                'input[name="' + element.name + '"]:checked'
            );
            return selected ? selected.value : "";
        }

        return (element.value || "").trim();
    }

    function getRadioValue(name) {
        const selected = form.querySelector(
            'input[name="' + name + '"]:checked'
        );

        return selected ? selected.value : "";
    }

    function getContactMethods() {
        return Array.from(
            form.querySelectorAll('input[name="contact_methods[]"]:checked')
        ).map(function (item) {
            return item.value;
        });
    }

    function getFormDataForPreview() {
        return {
            title: getFieldValue("plPostTitle"),
            category: getSelectedCategory(),
            subcategory: getFieldValue("plPostSubcategory"),
            condition: getFieldValue("plPostCondition"),
            price: getFieldValue("plPostPrice"),
            priceType: getRadioValue("price_type"),
            shortDescription: getFieldValue("plPostShortDescription"),
            description: getFieldValue("plPostDescription"),
            city: getFieldValue("plPostCity"),
            locality: getFieldValue("plPostLocality"),
            seller: getFieldValue("plPostSellerName"),
            contactMethods: getContactMethods(),
            visibility: getRadioValue("visibility")
        };
    }

    function appendPreviewItem(label, value, fullWidth) {
        const item = document.createElement("div");
        item.className = "pl-post-preview-item" +
            (fullWidth ? " full" : "");

        const labelElement = document.createElement("span");
        labelElement.textContent = label;

        const valueElement = document.createElement("strong");
        valueElement.textContent = value || "Not provided";

        item.append(labelElement, valueElement);
        previewContent.appendChild(item);
    }

    function buildPreview() {
        previewContent.replaceChildren();

        const data = getFormDataForPreview();

        if (mainImageInput.files[0]) {
            const url = URL.createObjectURL(mainImageInput.files[0]);
            currentObjectUrls.push(url);

            const image = document.createElement("img");
            image.className = "pl-post-preview-photo";
            image.src = url;
            image.alt = "Listing main image";
            image.style.gridColumn = "1 / -1";

            previewContent.appendChild(image);
        }

        appendPreviewItem("Listing Title", data.title);
        appendPreviewItem("Category", data.category);
        appendPreviewItem("Subcategory", data.subcategory);
        appendPreviewItem("Condition", data.condition);
        appendPreviewItem(
            "Price",
            data.price ? "₹" + data.price + " · " + data.priceType : ""
        );
        appendPreviewItem("City", data.city);
        appendPreviewItem("Area / Locality", data.locality);
        appendPreviewItem("Seller", data.seller);
        appendPreviewItem(
            "Contact Methods",
            data.contactMethods.join(", ") || "None selected",
            true
        );
        appendPreviewItem("Visibility", data.visibility);

        appendPreviewItem(
            "Short Description",
            data.shortDescription,
            true
        );

        appendPreviewItem(
            "Detailed Description",
            data.description,
            true
        );
    }

    /* Modal controls */
    function openModal(modal) {
        previousFocus = document.activeElement;

        modal.classList.add("open");
        modal.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";

        const firstControl = modal.querySelector(
            "button, input, select, textarea"
        );

        if (firstControl) {
            setTimeout(function () {
                firstControl.focus();
            }, 40);
        }
    }

    function closeModal(modal) {
        if (!modal) return;

        modal.classList.remove("open");
        modal.setAttribute("aria-hidden", "true");

        if (!document.querySelector(".pl-post-modal.open")) {
            document.body.style.overflow = "";
        }

        if (previousFocus && typeof previousFocus.focus === "function") {
            previousFocus.focus();
        }
    }

    document.querySelectorAll("[data-post-close]").forEach(function (element) {
        element.addEventListener("click", function () {
            closeModal(element.closest(".pl-post-modal"));
        });
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            document.querySelectorAll(".pl-post-modal.open").forEach(function (modal) {
                closeModal(modal);
            });
        }
    });

    /* Preview */
    previewButton.addEventListener("click", function () {
        if (!getSelectedCategory()) {
            showToast("Please select a listing category first.");
            document.querySelector('input[name="category"]').focus();
            return;
        }

        buildPreview();
        openModal(previewModal);
    });

    /* Draft storage: text fields only, for this browser */
    const draftStorageKey = "peoplelink_marketplace_listing_draft";

    function collectDraft() {
        const data = {};

        new FormData(form).forEach(function (value, key) {
            if (value instanceof File) return;

            if (Object.prototype.hasOwnProperty.call(data, key)) {
                if (!Array.isArray(data[key])) {
                    data[key] = [data[key]];
                }

                data[key].push(value);
            } else {
                data[key] = value;
            }
        });

        return data;
    }

    function saveDraft() {
        try {
            const draft = collectDraft();

            localStorage.setItem(
                draftStorageKey,
                JSON.stringify(draft)
            );

            showToast(
                "Draft saved in this browser. Images are not saved in the draft."
            );
        } catch (error) {
            showToast("Unable to save the draft in this browser.");
        }
    }

    function restoreDraft() {
        try {
            const rawDraft = localStorage.getItem(draftStorageKey);
            if (!rawDraft) return;

            const draft = JSON.parse(rawDraft);

            Object.entries(draft).forEach(function (entry) {
                const name = entry[0];
                const value = entry[1];

                if (name === "category") {
                    const categoryRadio = form.querySelector(
                        'input[name="category"][value="' + value + '"]'
                    );

                    if (categoryRadio) categoryRadio.checked = true;
                    return;
                }

                if (name === "price_type" || name === "visibility") {
                    const radio = form.querySelector(
                        'input[name="' + name + '"][value="' + value + '"]'
                    );

                    if (radio) radio.checked = true;
                    return;
                }

                const fields = form.querySelectorAll(
                    '[name="' + name.replace(/"/g, '\\"') + '"]'
                );

                fields.forEach(function (field) {
                    if (field.type === "file") return;

                    if (field.type === "checkbox") {
                        const values = Array.isArray(value) ? value : [value];
                        field.checked = values.includes(field.value);
                    } else if (field.type === "radio") {
                        field.checked = field.value === value;
                    } else if (!Array.isArray(value)) {
                        field.value = value;
                    }
                });
            });

            updateCategoryFields();

            // Restore subcategory after its options have been rebuilt.
            const subcategory = form.querySelector('[name="subcategory"]');
            if (subcategory && draft.subcategory) {
                subcategory.value = draft.subcategory;
            }

            updateCharacterCount(
                shortDescription,
                document.getElementById("plPostShortCount")
            );

            updateCharacterCount(
                description,
                document.getElementById("plPostDescriptionCount")
            );
        } catch (error) {
            showToast("A saved draft could not be restored.");
        }
    }

    draftButton.addEventListener("click", saveDraft);

    /* Submission demo */
    function submitListingDemo() {
        if (!form.reportValidity()) {
            return;
        }

        if (!mainImageInput.files.length) {
            showToast("Please select a main listing image.");
            mainImageInput.focus();
            return;
        }

        const selectedMethods = getContactMethods();

        if (!selectedMethods.length) {
            showToast("Please select at least one contact method.");
            return;
        }

        /*
         * This page is a front-end template.
         * Replace this demo handler with a fetch() request to your PHP
         * backend that validates the data, uploads images, stores the
         * listing, and returns the real approval status.
         */
        closeModal(previewModal);

        document.getElementById("plPostFeedbackTitle").textContent =
            "Demo Preview Complete";

        document.getElementById("plPostFeedbackMessage").textContent =
            "The form passed browser validation, but no listing has been uploaded or submitted. Connect your PHP backend to save the listing and show its actual approval status.";

        openModal(feedbackModal);
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        submitListingDemo();
    });

    previewSubmitButton.addEventListener("click", function () {
        submitListingDemo();
    });

    feedbackCloseButton.addEventListener("click", function () {
        closeModal(feedbackModal);
    });

    /* Initialize */
    updateCategoryFields();
    restoreDraft();
});






/* =========================================================
   PeopleLink Marketplace - My Listings
   File: my-marketplace-listings.js

   Demo interactions only. Connect actions to PHP/MySQL
   before using this page with real user listings.
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
    const root = document.getElementById("plMyMarket");
    if (!root) return;

    const listingContainer = document.getElementById("plMmListings");
    const listings = Array.from(listingContainer.querySelectorAll(".pl-mm-listing"));

    const tabs = Array.from(root.querySelectorAll(".pl-mm-tab"));
    const searchInput = document.getElementById("plMmSearch");
    const categorySelect = document.getElementById("plMmCategory");
    const statusSelect = document.getElementById("plMmStatus");
    const resetButton = document.getElementById("plMmReset");
    const resultCount = document.getElementById("plMmResultCount");

    const emptyState = document.getElementById("plMmEmpty");
    const emptyTitle = document.getElementById("plMmEmptyTitle");
    const emptyText = document.getElementById("plMmEmptyText");

    const viewModal = document.getElementById("plMmViewModal");
    const reasonModal = document.getElementById("plMmReasonModal");
    const confirmModal = document.getElementById("plMmConfirmModal");

    const toast = document.getElementById("plMmToast");

    let currentTab = "all";
    let selectedListing = null;
    let pendingAction = null;
    let toastTimer = null;
    let previousFocus = null;

    const statusLabels = {
        active: "Active",
        pending: "Pending Approval",
        draft: "Draft",
        sold: "Sold",
        closed: "Closed",
        rejected: "Rejected"
    };

    function getStatus(listing) {
        return listing.dataset.status || "draft";
    }

    function getTitle(listing) {
        return listing.dataset.title || "Untitled listing";
    }

    function formatPrice(value) {
        const number = Number(value || 0);

        return new Intl.NumberFormat("en-IN", {
            style: "currency",
            currency: "INR",
            maximumFractionDigits: 0
        }).format(number);
    }

    function showToast(message) {
        window.clearTimeout(toastTimer);

        toast.textContent = message;
        toast.classList.add("is-visible");

        toastTimer = window.setTimeout(function () {
            toast.classList.remove("is-visible");
        }, 3200);
    }

    function getListingData(listing) {
        return {
            id: listing.dataset.id,
            title: getTitle(listing),
            category: listing.dataset.category || "Other",
            status: getStatus(listing),
            price: listing.dataset.price || "0",
            location: listing.dataset.location || "Location not provided",
            date: listing.dataset.date || "",
            image: listing.dataset.image || "",
            views: listing.dataset.views || "0",
            enquiries: listing.dataset.enquiries || "0",
            saved: listing.dataset.saved || "0",
            reason: listing.dataset.reason || ""
        };
    }

    function updateCounts() {
        const counts = {
            all: listings.length,
            active: 0,
            pending: 0,
            draft: 0,
            closed: 0,
            rejected: 0
        };

        listings.forEach(function (listing) {
            const status = getStatus(listing);

            if (status === "sold" || status === "closed") {
                counts.closed++;
            } else if (Object.prototype.hasOwnProperty.call(counts, status)) {
                counts[status]++;
            }
        });

        tabs.forEach(function (tab) {
            const status = tab.dataset.status;
            const countElement = tab.querySelector("[data-tab-count]");

            if (countElement) {
                countElement.textContent = counts[status] ?? 0;
            }
        });

        document.getElementById("plMmTotal").textContent = listings.length;

        const totalViews = listings.reduce(function (total, listing) {
            return total + Number(listing.dataset.views || 0);
        }, 0);

        const totalEnquiries = listings.reduce(function (total, listing) {
            return total + Number(listing.dataset.enquiries || 0);
        }, 0);

        const totalSaved = listings.reduce(function (total, listing) {
            return total + Number(listing.dataset.saved || 0);
        }, 0);

        document.getElementById("plMmViews").textContent =
            totalViews.toLocaleString("en-IN");

        document.getElementById("plMmEnquiries").textContent =
            totalEnquiries.toLocaleString("en-IN");

        document.getElementById("plMmSaved").textContent =
            totalSaved.toLocaleString("en-IN");
    }

    function matchesTab(listing) {
        const status = getStatus(listing);

        if (currentTab === "all") return true;
        if (currentTab === "closed") {
            return status === "sold" || status === "closed";
        }

        return status === currentTab;
    }

    function applyFilters() {
        const searchTerm = searchInput.value.trim().toLowerCase();
        const category = categorySelect.value;
        const status = statusSelect.value;

        let visibleCount = 0;

        listings.forEach(function (listing) {
            const title = getTitle(listing).toLowerCase();
            const listingCategory = listing.dataset.category || "";
            const listingLocation = (listing.dataset.location || "").toLowerCase();
            const listingStatus = getStatus(listing);

            const matchesSearch =
                !searchTerm ||
                title.includes(searchTerm) ||
                listingCategory.toLowerCase().includes(searchTerm) ||
                listingLocation.includes(searchTerm);

            const matchesCategory =
                category === "all" || listingCategory === category;

            const matchesStatus =
                status === "all" || listingStatus === status;

            const matches =
                matchesTab(listing) &&
                matchesSearch &&
                matchesCategory &&
                matchesStatus;

            listing.hidden = !matches;

            if (matches) visibleCount++;
        });

        resultCount.textContent =
            visibleCount + (visibleCount === 1 ? " listing" : " listings");

        emptyState.hidden = visibleCount !== 0;
        listingContainer.hidden = visibleCount === 0;

        if (visibleCount === 0) {
            const hasFilters =
                currentTab !== "all" ||
                searchTerm !== "" ||
                category !== "all" ||
                status !== "all";

            emptyTitle.textContent = hasFilters
                ? "No listings found"
                : "You have not posted any Marketplace listings yet.";

            emptyText.textContent = hasFilters
                ? "Try another search or reset your filters to see more listings."
                : "Start selling, sharing or offering services to your community.";
        }
    }

    function setTab(status) {
        currentTab = status;

        tabs.forEach(function (tab) {
            const isActive = tab.dataset.status === status;

            tab.classList.toggle("is-active", isActive);
            tab.setAttribute("aria-selected", String(isActive));
        });

        // The tab takes priority; clear the separate status filter.
        statusSelect.value = "all";
        applyFilters();
    }

    function openModal(modal) {
        previousFocus = document.activeElement;
        modal.hidden = false;
        document.body.style.overflow = "hidden";

        const closeButton = modal.querySelector("[data-close-modal]");
        if (closeButton) closeButton.focus();
    }

    function closeModal(modal) {
        modal.hidden = true;

        const anyOpen = [viewModal, reasonModal, confirmModal].some(function (item) {
            return !item.hidden;
        });

        if (!anyOpen) {
            document.body.style.overflow = "";
            if (previousFocus && typeof previousFocus.focus === "function") {
                previousFocus.focus();
            }
        }
    }

    function closeAllModals() {
        [viewModal, reasonModal, confirmModal].forEach(function (modal) {
            modal.hidden = true;
        });

        document.body.style.overflow = "";

        if (previousFocus && typeof previousFocus.focus === "function") {
            previousFocus.focus();
        }
    }

    function openView(listing) {
        selectedListing = listing;

        const data = getListingData(listing);

        document.getElementById("plMmViewImage").src = data.image;
        document.getElementById("plMmViewImage").alt = data.title;
        document.getElementById("plMmViewCategory").textContent = data.category;
        document.getElementById("plMmViewTitle").textContent = data.title;
        document.getElementById("plMmViewPrice").textContent = formatPrice(data.price);
        document.getElementById("plMmViewLocation").textContent = "📍 " + data.location;
        document.getElementById("plMmViewDate").textContent = "Posted: " + data.date;

        const stats = document.getElementById("plMmViewStats");
        stats.replaceChildren();

        [
            ["Views", data.views],
            ["Enquiries", data.enquiries],
            ["Saved", data.saved],
            ["Status", statusLabels[data.status] || data.status]
        ].forEach(function (item) {
            const span = document.createElement("span");
            span.textContent = item[0] + ": " + item[1];
            stats.appendChild(span);
        });

        openModal(viewModal);
    }

    function openReason(listing) {
        selectedListing = listing;

        document.getElementById("plMmReasonText").textContent =
            listing.dataset.reason || "No rejection reason has been provided.";

        openModal(reasonModal);
    }

    function requestConfirmation(listing, action) {
        selectedListing = listing;
        pendingAction = action;

        const data = getListingData(listing);
        const title = document.getElementById("plMmConfirmTitle");
        const message = document.getElementById("plMmConfirmText");
        const confirmButton = document.getElementById("plMmConfirmAction");

        const config = {
            sold: {
                title: "Mark Listing as Sold?",
                message: 'Mark "' + data.title + '" as sold?',
                button: "Mark as Sold"
            },
            close: {
                title: "Close This Listing?",
                message: 'Close "' + data.title + '"? It will no longer be active.',
                button: "Close Listing"
            },
            delete: {
                title: "Delete This Listing?",
                message: 'Delete "' + data.title + '" from this demo? This action cannot be undone.',
                button: "Delete Listing"
            }
        };

        const details = config[action];
        if (!details) return;

        title.textContent = details.title;
        message.textContent = details.message;
        confirmButton.textContent = details.button;

        confirmButton.classList.toggle("pl-mm-delete-confirm", action === "delete");
        openModal(confirmModal);
    }

    function navigateToEdit(listing, resubmit) {
        const data = getListingData(listing);

        /*
         * Replace this URL with your actual edit page.
         * The destination should check that the logged-in user owns this listing.
         */
        const editUrl = new URL("edit-marketplace-listing.php", window.location.href);
        editUrl.searchParams.set("id", data.id);

        if (resubmit) {
            editUrl.searchParams.set("resubmit", "1");
        }

        window.location.href = editUrl.href;
    }

    function performDemoAction() {
        if (!selectedListing || !pendingAction) return;

        const listing = selectedListing;
        const action = pendingAction;
        const title = getTitle(listing);

        if (action === "sold" || action === "close") {
            const newStatus = action === "sold" ? "sold" : "closed";
            listing.dataset.status = newStatus;

            const badge = listing.querySelector(".pl-mm-status");

            if (badge) {
                badge.className = "pl-mm-status status-" + newStatus;
                badge.textContent = statusLabels[newStatus];
            }

            // Remove actions that no longer apply.
            listing.querySelectorAll('[data-action="sold"], [data-action="close"]')
                .forEach(function (button) {
                    button.remove();
                });

            updateCounts();
            applyFilters();

            showToast(
                '"' + title + '" marked as ' +
                (newStatus === "sold" ? "sold" : "closed") +
                " in this demo."
            );
        }

        if (action === "delete") {
            listing.remove();

            const index = listings.indexOf(listing);
            if (index !== -1) listings.splice(index, 1);

            updateCounts();
            applyFilters();

            showToast('"' + title + '" removed from the demo.');
        }

        closeAllModals();
        selectedListing = null;
        pendingAction = null;
    }

    /* Status tabs */

    tabs.forEach(function (tab) {
        tab.addEventListener("click", function () {
            setTab(tab.dataset.status);
        });
    });

    /* Search and filters */

    searchInput.addEventListener("input", applyFilters);
    categorySelect.addEventListener("change", applyFilters);
    statusSelect.addEventListener("change", applyFilters);

    resetButton.addEventListener("click", function () {
        searchInput.value = "";
        categorySelect.value = "all";
        statusSelect.value = "all";
        setTab("all");
        showToast("Filters have been reset.");
    });

    /* Listing actions */

    listingContainer.addEventListener("click", function (event) {
        const button = event.target.closest("[data-action]");
        if (!button) return;

        const listing = button.closest(".pl-mm-listing");
        if (!listing) return;

        const action = button.dataset.action;

        switch (action) {
            case "view":
                openView(listing);
                break;

            case "edit":
                navigateToEdit(listing, false);
                break;

            case "resubmit":
                navigateToEdit(listing, true);
                break;

            case "reason":
                openReason(listing);
                break;

            case "sold":
            case "close":
            case "delete":
                requestConfirmation(listing, action);
                break;
        }
    });

    /* Modal close buttons and backdrops */

    document.querySelectorAll("[data-close-modal]").forEach(function (element) {
        element.addEventListener("click", function () {
            const modal = element.closest(".pl-mm-modal");
            if (modal) closeModal(modal);
        });
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeAllModals();
        }
    });

    document.getElementById("plMmViewEdit").addEventListener("click", function () {
        if (selectedListing) navigateToEdit(selectedListing, false);
    });

    document.getElementById("plMmReasonEdit").addEventListener("click", function () {
        if (selectedListing) navigateToEdit(selectedListing, true);
    });

    document.getElementById("plMmConfirmAction").addEventListener("click", performDemoAction);

    /* Initial render */

    updateCounts();
    applyFilters();
});








/* PeopleLink Marketplace - Saved Listings */

document.addEventListener("DOMContentLoaded", function () {
    const root = document.getElementById("plSavedMarket");
    if (!root) return;

    const grid = document.getElementById("plSmGrid");
    const search = document.getElementById("plSmSearch");
    const category = document.getElementById("plSmCategory");
    const sort = document.getElementById("plSmSort");
    const reset = document.getElementById("plSmReset");
    const empty = document.getElementById("plSmEmpty");
    const emptyTitle = document.getElementById("plSmEmptyTitle");
    const emptyText = document.getElementById("plSmEmptyText");
    const resultCount = document.getElementById("plSmResultCount");
    const savedCount = document.getElementById("plSmSavedCount");

    function getCards() {
        return Array.from(grid.querySelectorAll(".pl-sm-card"));
    }

    function updateCount() {
        const count = getCards().length;
        savedCount.textContent = count + (count === 1 ? " Listing" : " Listings");
    }

    function applyFilters() {
        const term = search.value.trim().toLowerCase();
        const selectedCategory = category.value;
        const cards = getCards();
        let visible = 0;

        cards.forEach(function (card) {
            const title = (card.dataset.title || "").toLowerCase();
            const location = (card.dataset.location || "").toLowerCase();
            const cardCategory = card.dataset.category || "";

            const matchesSearch =
                !term ||
                title.includes(term) ||
                location.includes(term) ||
                cardCategory.toLowerCase().includes(term);

            const matchesCategory =
                selectedCategory === "all" ||
                cardCategory === selectedCategory;

            const show = matchesSearch && matchesCategory;
            card.hidden = !show;

            if (show) visible++;
        });

        resultCount.textContent =
            "Showing " + visible +
            (visible === 1 ? " saved listing" : " saved listings");

        grid.hidden = visible === 0;
        empty.hidden = visible !== 0;

        if (visible === 0) {
            if (cards.length === 0) {
                emptyTitle.textContent =
                    "You have not saved any Marketplace listings yet.";
                emptyText.textContent =
                    "Browse the marketplace and save listings you want to revisit later.";
            } else {
                emptyTitle.textContent = "No saved listings found";
                emptyText.textContent =
                    "Try another search or choose a different category.";
            }
        }
    }

    function applySorting() {
        const cards = getCards();
        const sortBy = sort.value;

        cards.sort(function (a, b) {
            switch (sortBy) {
                case "posted-desc":
                    return (b.dataset.posted || "").localeCompare(a.dataset.posted || "");

                case "price-asc":
                    return Number(a.dataset.price || 0) - Number(b.dataset.price || 0);

                case "price-desc":
                    return Number(b.dataset.price || 0) - Number(a.dataset.price || 0);

                case "saved-desc":
                default:
                    return (b.dataset.saved || "").localeCompare(a.dataset.saved || "");
            }
        });

        cards.forEach(function (card) {
            grid.appendChild(card);
        });

        applyFilters();
    }

    search.addEventListener("input", applyFilters);
    category.addEventListener("change", applyFilters);
    sort.addEventListener("change", applySorting);

    reset.addEventListener("click", function () {
        search.value = "";
        category.value = "all";
        sort.value = "saved-desc";
        applySorting();
    });

    /*
     * Demo-only remove action.
     * For permanent removal, send an authenticated request to PHP/MySQL.
     */
    grid.addEventListener("click", function (event) {
        const button = event.target.closest('[data-action="remove"]');
        if (!button) return;

        const card = button.closest(".pl-sm-card");
        if (!card) return;

        const title = card.dataset.title || "Listing";
        const shouldRemove = window.confirm(
            'Remove "' + title + '" from your saved listings?'
        );

        if (!shouldRemove) return;

        card.remove();
        updateCount();
        applyFilters();
    });

    updateCount();
    applySorting();
});





document.addEventListener('DOMContentLoaded', function () {
    // Hide the listing photo gracefully when the configured image is unavailable.
    document.querySelectorAll('.pl-listing-image').forEach(function (image) {
        image.addEventListener('error', function () {
            image.classList.add('pl-image-unavailable');
        });
        if (!image.getAttribute('src') || !image.getAttribute('src').trim()) {
            image.classList.add('pl-image-unavailable');
        }
    });

    // Prevent repeat clicks while the enquiry form is being submitted.
    document.querySelectorAll('.pl-form-body').forEach(function (form) {
        form.addEventListener('submit', function () {
            if (!form.checkValidity()) return;
            var button = form.querySelector('.pl-btn-submit');
            if (!button || form.dataset.submitting === 'true') return;
            form.dataset.submitting = 'true';
            button.disabled = true;
            button.setAttribute('aria-busy', 'true');
            button.querySelector('span:first-child').textContent = 'Sending enquiry…';
        });
    });
});





/* PeopleLink Events & Advertisements Home interactions */
document.addEventListener('DOMContentLoaded', function () {
  const searchForm = document.querySelector('.pl-events-search');
  if (searchForm) {
    searchForm.addEventListener('submit', function (event) {
      const keyword = searchForm.querySelector('[name="q"]');
      const location = searchForm.querySelector('[name="location"]');
      const type = searchForm.querySelector('[name="type"]');
      if (keyword && location && type &&
          !keyword.value.trim() && !location.value.trim() && !type.value) {
        event.preventDefault();
        keyword.focus();
        keyword.setCustomValidity('Enter a keyword, choose a listing type, or add a location to search.');
        keyword.reportValidity();
        keyword.addEventListener('input', () => keyword.setCustomValidity(''), { once: true });
      }
    });
  }
});





/* PeopleLink Events & Advertisements Search interactions */
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('plEventsAdsFilterForm');
  if (!form) return;

  const typeInputs = form.querySelectorAll('input[name="type"]');
  const eventSection = form.querySelector('.pl-event-filters');
  const adSection = form.querySelector('.pl-ad-filters');
  const locationButton = document.getElementById('plUseLocation');
  const locationMessage = document.getElementById('plLocationMessage');
  const cityInput = form.querySelector('[name="city"]');
  const areaInput = form.querySelector('[name="area"]');
  const latitudeInput = document.getElementById('plLatitude');
  const longitudeInput = document.getElementById('plLongitude');

  function updateTypeSections() {
    const selected = form.querySelector('input[name="type"]:checked')?.value || 'all';
    if (eventSection) eventSection.hidden = selected === 'advertisement';
    if (adSection) adSection.hidden = selected === 'event';
  }
  typeInputs.forEach(input => input.addEventListener('change', updateTypeSections));
  updateTypeSections();

  form.addEventListener('reset', function () {
    window.setTimeout(function () {
      updateTypeSections();
      if (locationMessage) locationMessage.textContent = '';
      if (latitudeInput) latitudeInput.value = '';
      if (longitudeInput) longitudeInput.value = '';
    }, 0);
  });

  if (locationButton) {
    locationButton.addEventListener('click', function () {
      if (!navigator.geolocation) {
        if (locationMessage) locationMessage.textContent = 'Location is not supported by this browser. Please enter your city or area.';
        return;
      }
      locationButton.disabled = true;
      locationButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Finding location...';
      if (locationMessage) locationMessage.textContent = 'Please allow location access when your browser asks.';
      navigator.geolocation.getCurrentPosition(
        function (position) {
          if (latitudeInput) latitudeInput.value = position.coords.latitude;
          if (longitudeInput) longitudeInput.value = position.coords.longitude;
          if (locationMessage) locationMessage.textContent = 'Location added. The listings page can use these coordinates to filter nearby results.';
          locationButton.disabled = false;
          locationButton.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Update My Location <small>Optional</small>';
        },
        function () {
          if (locationMessage) locationMessage.textContent = 'Could not access your location. Check browser permission or enter your city and area manually.';
          locationButton.disabled = false;
          locationButton.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Use My Location <small>Optional</small>';
        },
        { enableHighAccuracy: false, timeout: 10000, maximumAge: 300000 }
      );
    });
  }

  form.addEventListener('submit', function () {
    // The selected filters are submitted to events-ads-listings.php using GET.
    // Apply database filtering and validation on the destination page.
  });
});






/* PeopleLink Page 3 — client-side listing presentation controls */
document.addEventListener('DOMContentLoaded', function () {
  const grid = document.getElementById('plResultsGrid');
  const sortSelect = document.getElementById('plResultsSort');
  const loadButton = document.getElementById('plLoadMore');
  const loadMessage = document.getElementById('plLoadMessage');
  const count = document.getElementById('plVisibleCount');
  const viewButtons = document.querySelectorAll('.pl-results-view-switch [data-view]');

  if (grid) {
    const cards = Array.from(grid.querySelectorAll('.pl-result-card'));

    // Front-end sample cards are all shown initially. Replace this with server-side pagination for database data.
    if (loadButton) {
      loadButton.addEventListener('click', function () {
        if (loadMessage) loadMessage.textContent = 'You are viewing all sample listings on this page.';
        loadButton.disabled = true;
        loadButton.innerHTML = 'All Sample Listings Shown <i class="fa-solid fa-check"></i>';
      });
    }

    if (sortSelect) {
      sortSelect.addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sortSelect.value);
        window.location.href = url.toString();
      });
    }

    viewButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        viewButtons.forEach(b => b.classList.remove('is-active'));
        button.classList.add('is-active');
        grid.classList.toggle('is-list', button.dataset.view === 'list');
      });
    });

    if (count) count.textContent = String(cards.length);
  }
});





/* PeopleLink Page 4 — share interactions */
document.addEventListener('DOMContentLoaded', function () {
  const toast = document.getElementById('plDetailToast');
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

  async function shareListing() {
    const shareData = {
      title: document.title || 'PeopleLink listing',
      text: document.querySelector('.pl-detail-hero h1')?.textContent?.trim() || 'View this PeopleLink listing',
      url: window.location.href
    };

    if (navigator.share) {
      try {
        await navigator.share(shareData);
      } catch (error) {
        if (error && error.name !== 'AbortError') showToast('Sharing was not available. You can copy the page URL from your browser.');
      }
      return;
    }

    try {
      await navigator.clipboard.writeText(window.location.href);
      showToast('Listing link copied. Share it with your community.');
    } catch (error) {
      showToast('Copy the page URL from your browser address bar to share this listing.');
    }
  }

  document.getElementById('plShareButton')?.addEventListener('click', shareListing);
  document.getElementById('plShareButtonSide')?.addEventListener('click', shareListing);
});





(() => {
'use strict';
const form=document.getElementById('plPostForm'); if(!form)return;
const modal=document.getElementById('plPreviewModal'), preview=document.getElementById('plPreviewContent'), toast=document.getElementById('plToast');
let timer;
const type=()=>form.querySelector('[name="post_type"]:checked').value;
const val=name=>{const el=form.elements[name];return el&&String(el.value).trim()?String(el.value).trim():'Not provided'};
const esc=s=>String(s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
function notify(title,msg){document.getElementById('plToastTitle').textContent=title;document.getElementById('plToastMessage').textContent=msg;toast.classList.add('visible');clearTimeout(timer);timer=setTimeout(()=>toast.classList.remove('visible'),6000)}
function update(){
 const t=type();
 form.querySelectorAll('.pl-type-option').forEach(label=>label.classList.toggle('is-selected',label.querySelector('input').checked));
 form.querySelectorAll('[data-section]').forEach(s=>s.hidden=!s.dataset.section.split(' ').includes(t));
 form.querySelector('[data-event-live]').hidden=t!=='event';
 form.querySelector('[data-ad-website]').hidden=t!=='advertisement';
 form.querySelector('.pl-paid').hidden=t!=='event'||form.elements.entry_type.value!=='paid';
 form.querySelectorAll('[data-required]').forEach(el=>{const s=el.closest('[data-section]');el.required=!(s&&s.hidden);if(s&&s.hidden)clearError(el)});
 updateVisibility();
}
function updateVisibility(){const global=document.getElementById('plVisibility').value==='global',field=document.getElementById('plCommunityField'),input=document.getElementById('plCommunity');input.disabled=global;input.required=!global;field.style.opacity=global?'.55':'1';input.placeholder=global?'Not required for global posts':'Choose or enter the community name';if(global)clearError(input)}
function clearError(el){el.removeAttribute('aria-invalid');const e=el.closest('.pl-field')?.querySelector('.pl-error');if(e)e.textContent=''}
function validate(){
 let first=null;
 form.querySelectorAll('[data-required]').forEach(el=>{
  if(el.closest('[data-section]')?.hidden||el.disabled)return;
  let msg=!el.value.trim()?'This field is required.':'';
  if(!msg&&el.type==='email'&&!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(el.value.trim()))msg='Enter a valid email address.';
  if(!msg&&el.type==='url'&&el.value){try{new URL(el.value)}catch(e){msg='Enter a complete URL including https://.'}}
  if(msg){el.setAttribute('aria-invalid','true');const e=el.closest('.pl-field')?.querySelector('.pl-error');if(e)e.textContent=msg;if(!first)first=el}else clearError(el);
 });
 const t=type(),start=form.elements[t==='event'?'event_date':'ad_start_date'],end=form.elements[t==='event'?'registration_closing_date':'ad_end_date'];
 if(start.value&&end.value&&end.value<start.value){end.setAttribute('aria-invalid','true');const e=end.closest('.pl-field')?.querySelector('.pl-error');if(e)e.textContent='End/closing date cannot be before the start/event date.';if(!first)first=end}
 if(t==='event'&&form.elements.start_time.value&&form.elements.end_time.value&&form.elements.end_time.value<=form.elements.start_time.value){const el=form.elements.end_time;el.setAttribute('aria-invalid','true');const e=el.closest('.pl-field')?.querySelector('.pl-error');if(e)e.textContent='End time should be later than start time.';if(!first)first=el}
 if(first){first.focus({preventScroll:true});first.scrollIntoView({behavior:'smooth',block:'center'});return false}return true;
}
function openPreview(){
 if(!validate())return;
 const event=type()==='event',title=val(event?'event_name':'ad_title'),short=val(event?'event_short_description':'ad_short_description'),details=val(event?'event_description':'ad_description'),category=val(event?'event_category':'ad_category'),file=form.elements[event?'event_image':'ad_image'].files[0];
 const meta=event?[['Date',val('event_date')],['Time',val('start_time')+' – '+val('end_time')],['Venue',val('venue_name')],['City',val('event_city')],['Organiser',val('organiser_name')],['Registration',form.elements.registration_required.value==='yes'?'Required':'Not required'],['Entry',form.elements.entry_type.value==='paid'?'Paid — ₹'+val('entry_fee'):'Free']]:[['Business',val('advertiser_name')],['Product / service',val('product_service_name')],['Price',val('ad_price')==='Not provided'?'Contact for price':'₹'+val('ad_price')],['Valid from',val('ad_start_date')],['Valid until',val('ad_end_date')],['Location',val('ad_area')==='Not provided'?val('ad_city'):val('ad_area')+', '+val('ad_city')]];
 meta.push(['Visibility',document.getElementById('plVisibility').selectedOptions[0].text]);
 preview.innerHTML=(file?'<img class="preview-banner" id="plPreviewBanner" alt="Post banner preview">':'')+'<span class="preview-tag">'+(event?'Community event':'Advertisement')+' · '+esc(category)+'</span><h3>'+esc(title)+'</h3><p>'+esc(short)+'</p><div class="pl-preview-meta">'+meta.map(x=>'<div><small>'+esc(x[0])+'</small><strong>'+esc(x[1])+'</strong></div>').join('')+'</div><div class="pl-preview-details">'+esc(details)+(event?'':'\n\nOffer: '+esc(val('offer_details')))+'</div>';
 if(file){const r=new FileReader();r.onload=e=>document.getElementById('plPreviewBanner').src=e.target.result;r.readAsDataURL(file)}
 modal.classList.add('open');modal.setAttribute('aria-hidden','false');document.body.style.overflow='hidden';
}
function closePreview(){modal.classList.remove('open');modal.setAttribute('aria-hidden','true');document.body.style.overflow=''}
form.querySelectorAll('[name="post_type"],[name="entry_type"]').forEach(el=>el.addEventListener('change',update));
document.getElementById('plVisibility').addEventListener('change',updateVisibility);
form.querySelectorAll('input,select,textarea').forEach(el=>{el.addEventListener('input',()=>{if(el.hasAttribute('aria-invalid'))clearError(el)});el.addEventListener('change',()=>{if(el.hasAttribute('aria-invalid'))clearError(el)})});
form.querySelectorAll('[data-image]').forEach(input=>input.addEventListener('change',()=>{
 const key=input.dataset.image,box=form.querySelector('[data-preview-image="'+key+'"]'),label=form.querySelector('[data-filename="'+key+'"]'),file=input.files[0];box.innerHTML='';
 if(!file){label.textContent='Choose file';box.classList.remove('visible');return}
 if(!file.type.startsWith('image/')){input.value='';notify('Image file required','Please choose an image file.');return}
 label.textContent=file.name;const img=document.createElement('img'),r=new FileReader();r.onload=e=>img.src=e.target.result;r.readAsDataURL(file);const name=document.createElement('span');name.textContent=file.name;const remove=document.createElement('button');remove.type='button';remove.textContent='Remove';remove.onclick=()=>{input.value='';box.innerHTML='';box.classList.remove('visible');label.textContent='Choose file'};box.append(img,name,remove);box.classList.add('visible')
}));
document.getElementById('plPreviewBtn').onclick=openPreview;
document.getElementById('plPreviewSubmit').onclick=()=>{closePreview();form.requestSubmit()};
document.querySelectorAll('[data-close]').forEach(el=>el.addEventListener('click',closePreview));
document.getElementById('plDraftBtn').onclick=()=>{if(validate())notify('Draft ready','This demo does not store drafts permanently. Connect a save-draft endpoint to enable storage.')};
form.addEventListener('submit',e=>{e.preventDefault();if(!validate())return;notify(type()==='event'?'Event Submitted Successfully':'Advertisement Submitted Successfully','Your submission is under review and will be published after approval.');form.dispatchEvent(new CustomEvent('peoplelink:post-submit',{bubbles:true,detail:{postType:type(),formData:new FormData(form)}}))});
document.getElementById('plToastClose').onclick=()=>toast.classList.remove('visible');
document.addEventListener('keydown',e=>{if(e.key==='Escape')closePreview()});
update();
})();




(() => {
'use strict';
const list=document.getElementById('plmaList'); if(!list)return;
const cards=[...list.querySelectorAll('.plma-item')], search=document.getElementById('plmaSearch'), typeFilter=document.getElementById('plmaTypeFilter'), statusFilter=document.getElementById('plmaStatusFilter');
const tabs=[...document.querySelectorAll('[data-tab]')], stats=[...document.querySelectorAll('[data-stat-filter]')];
const empty=document.getElementById('plmaEmpty'), noResults=document.getElementById('plmaNoResults'), summary=document.getElementById('plmaResultSummary'), total=document.getElementById('plmaTotalCount');
const modal=document.getElementById('plmaModal'), modalTitle=document.getElementById('plmaModalTitle'), modalMessage=document.getElementById('plmaModalMessage'), modalReason=document.getElementById('plmaModalReason'), confirm=document.getElementById('plmaModalConfirm'), toast=document.getElementById('plmaToast');
let activeTab='all', pendingAction=null, toastTimer;
const statusToTab=s=>({active:'active',pending:'pending',draft:'drafts',completed:'completed',expired:'completed',rejected:'rejected'}[s]||'all');
function notify(title,message){document.getElementById('plmaToastTitle').textContent=title;document.getElementById('plmaToastMessage').textContent=message;toast.classList.add('visible');clearTimeout(toastTimer);toastTimer=setTimeout(()=>toast.classList.remove('visible'),5000)}
function updateCounts(){
 const count={all:cards.length,active:0,pending:0,drafts:0,completed:0,rejected:0};
 cards.forEach(c=>{const s=c.dataset.status;const tab=statusToTab(s);if(count[tab]!==undefined)count[tab]++});
 total.textContent=cards.length;
 document.querySelectorAll('[data-stat-count]').forEach(el=>el.textContent=count[el.dataset.statCount]||0);
 document.querySelectorAll('[data-tab-count]').forEach(el=>el.textContent=count[el.dataset.tabCount]||0);
 tabs.forEach(t=>{const tab=t.dataset.tab;t.hidden=(tab==='active'&&count.active===0)||(tab==='pending'&&count.pending===0)||(tab==='drafts'&&count.drafts===0)||(tab==='completed'&&count.completed===0)||(tab==='rejected'&&count.rejected===0)});
}
function applyFilters(){
 const q=search.value.trim().toLowerCase(), typ=typeFilter.value, status=statusFilter.value;let visible=0;
 cards.forEach(card=>{
  const matchesTab=activeTab==='all'||statusToTab(card.dataset.status)===activeTab;
  const matchesType=typ==='all'||card.dataset.type===typ;
  const matchesStatus=status==='all'||card.dataset.status===status;
  const hay=[card.dataset.title,card.dataset.category,card.dataset.location].join(' ');
  const matchesQuery=!q||hay.includes(q);
  const show=matchesTab&&matchesType&&matchesStatus&&matchesQuery;
  card.hidden=!show;if(show)visible++;
 });
 summary.textContent=`Showing ${visible} of ${cards.length} post${cards.length===1?'':'s'}`;
 empty.hidden=cards.length!==0;
 noResults.hidden=cards.length===0||visible!==0;
 updateCounts();
}
function setTab(tab){activeTab=tab;tabs.forEach(t=>{const on=t.dataset.tab===tab;t.classList.toggle('is-active',on);t.setAttribute('aria-selected',String(on))});stats.forEach(s=>s.classList.toggle('is-active',s.dataset.statFilter===tab));statusFilter.value='all';applyFilters()}
tabs.forEach(t=>t.addEventListener('click',()=>setTab(t.dataset.tab)));
stats.forEach(s=>s.addEventListener('click',()=>setTab(s.dataset.statFilter)));
[search,typeFilter,statusFilter].forEach(el=>el.addEventListener('input',applyFilters));
document.getElementById('plmaResetFilters').addEventListener('click',()=>{search.value='';typeFilter.value='all';statusFilter.value='all';setTab('all')});
function openModal({title,message,reason='',actionLabel='Confirm',action=null}){pendingAction=action;modalTitle.textContent=title;modalMessage.textContent=message;modalReason.hidden=!reason;modalReason.textContent=reason;confirm.textContent=actionLabel;modal.classList.add('open');modal.setAttribute('aria-hidden','false');document.body.style.overflow='hidden'}
function closeModal(){modal.classList.remove('open');modal.setAttribute('aria-hidden','true');document.body.style.overflow='';pendingAction=null}
document.querySelectorAll('[data-modal-close]').forEach(el=>el.addEventListener('click',closeModal));
document.addEventListener('keydown',e=>{if(e.key==='Escape'&&modal.classList.contains('open'))closeModal()});
list.addEventListener('click',e=>{
 const btn=e.target.closest('[data-action]');if(!btn)return;const card=btn.closest('.plma-item');if(!card)return;
 const action=btn.dataset.action,title=card.querySelector('h3').textContent;
 if(action==='reason'){openModal({title:'Reason for rejection',message:'The administrator requested the following changes:',reason:card.dataset.reason||'No reason has been provided.',actionLabel:'Got it'});pendingAction=null;return}
 if(action==='close')openModal({title:'Close this post?',message:`“${title}” will be marked closed in this demo. On the live site, confirm that registrations or enquiries should stop.`,actionLabel:'Close post',action:()=>{card.dataset.status='closed';const badge=card.querySelector('.plma-status');badge.className='plma-status plma-status-closed';badge.innerHTML='<b></b>Closed';btn.remove();applyFilters();notify('Post closed','This is a local demo change; connect the database action to persist it.')}});
 if(action==='delete')openModal({title:'Delete this post?',message:`“${title}” will be removed from this demo list. This cannot be undone here.`,actionLabel:'Delete post',action:()=>{card.remove();const i=cards.indexOf(card);if(i>-1)cards.splice(i,1);applyFilters();notify('Post deleted','This is a local demo change; connect the database action to persist it.')}});
});
confirm.addEventListener('click',()=>{const action=pendingAction;closeModal();if(action)action()});
document.getElementById('plmaToastClose').addEventListener('click',()=>toast.classList.remove('visible'));
updateCounts();applyFilters();
})();




(function(){
  'use strict';
  const form=document.getElementById('plEnquiryForm');
  if(!form)return;
  const mode=form.dataset.mode;
  const overlay=document.getElementById('successOverlay');
  const toast=document.getElementById('plToast');
  const message=document.getElementById('message');
  const count=document.getElementById('messageCount');
  let toastTimer;
  function showToast(text){toast.querySelector('span').textContent=text;toast.classList.add('show');clearTimeout(toastTimer);toastTimer=setTimeout(()=>toast.classList.remove('show'),3000)}
  function setError(input,text){const field=input.closest('.pl-field');if(field){field.classList.toggle('invalid',!!text);const err=field.querySelector('.field-error');if(err)err.textContent=text||''}return !text}
  function validate(){let ok=true;form.querySelectorAll('[required]').forEach(input=>{if(input.type==='checkbox'){const err=document.querySelector('.consent-error');if(!input.checked){ok=false;if(err)err.textContent='Please confirm before continuing.'}else if(err)err.textContent='';return}let error='';if(!String(input.value||'').trim())error='This field is required.';else if(input.type==='email'&&!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value.trim()))error='Enter a valid email address.';else if(input.name==='mobile'&&!/^[+\d][\d\s()-]{7,17}$/.test(input.value.trim()))error='Enter a valid mobile number.';if(!setError(input,error))ok=false});return ok}
  form.querySelectorAll('input,textarea,select').forEach(input=>{input.addEventListener('input',()=>{if(input.closest('.pl-field'))setError(input,'');if(input.id==='message'&&count)count.textContent=(input.value.length)+' / 1000'});input.addEventListener('change',()=>{if(input.closest('.pl-field'))setError(input,'')})});
  if(message&&count){message.maxLength=1000;count.textContent=message.value.length+' / 1000'}
  function openModal(){overlay.classList.add('open');overlay.setAttribute('aria-hidden','false');document.body.style.overflow='hidden';document.getElementById('closeSuccess').focus()}
  function closeModal(){overlay.classList.remove('open');overlay.setAttribute('aria-hidden','true');document.body.style.overflow='';}
  document.getElementById('closeSuccess').addEventListener('click',closeModal);overlay.addEventListener('click',e=>{if(e.target===overlay)closeModal()});document.addEventListener('keydown',e=>{if(e.key==='Escape'&&overlay.classList.contains('open'))closeModal()});
  form.addEventListener('submit',e=>{e.preventDefault();if(!validate()){const bad=form.querySelector('.invalid input,.invalid select,.invalid textarea');if(bad)bad.focus();else document.getElementById('consent').focus();showToast('Please check the highlighted fields.');return}
    const data=new FormData(form);const name=String(data.get('full_name')||'Participant').trim();const eventName='PeopleLink Community Networking Meet';const date='24 October 2026';const isRegistration=mode==='event-registration';const isAd=mode==='advertisement-enquiry';
    document.getElementById('successTitle').textContent=isRegistration?'Registration Successful':'Enquiry Sent Successfully';document.getElementById('successDescription').textContent=isRegistration?'Your event registration has been recorded in this demo.':'Thank you, '+name+'. Your enquiry has been recorded in this demo.';
    const reference=document.getElementById('successReference');const details=document.getElementById('successDetails');const actions=document.getElementById('successActions');
    if(isRegistration){const registrationId='PL-R-'+Date.now().toString().slice(-7);reference.style.display='flex';reference.querySelector('span').textContent='Registration ID';document.getElementById('registrationId').textContent=registrationId;details.innerHTML='<div><strong>Event:</strong> '+escapeHtml(eventName)+'</div><div><strong>Date:</strong> '+date+'</div><div><strong>Participant:</strong> '+escapeHtml(name)+'</div><div><strong>Participants:</strong> '+escapeHtml(String(data.get('participants')||'1'))+'</div>';actions.innerHTML='<a href="event-ad-details.php?id=101&type=event" class="success-secondary">Back to Event</a><a href="my-registrations.php" class="success-primary">View My Registrations <i class="fa-solid fa-arrow-right"></i></a>'}
    else{reference.style.display='none';details.innerHTML=isAd?'<div><strong>Advertisement:</strong> Premium Home Interior Consultation</div><div><strong>Contact preference:</strong> '+escapeHtml(String(data.get('contact_method')||'Call'))+'</div>':'<div><strong>Event:</strong> '+escapeHtml(eventName)+'</div><div><strong>Subject:</strong> '+escapeHtml(String(data.get('subject')||'Event enquiry'))+'</div>';actions.innerHTML='<button type="button" class="success-primary" id="doneSuccess">Done <i class="fa-solid fa-check"></i></button>';}
    openModal();const done=document.getElementById('doneSuccess');if(done)done.addEventListener('click',closeModal);
    // Production: POST FormData to a server endpoint, validate again on the server, and save to the database.
    form.reset();if(count)count.textContent='0 / 1000';
  });
  function escapeHtml(s){return s.replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]))}
})();




document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("supportRequestForm");
    const previewButton = document.getElementById("previewSupportRequest");
    const modal = document.getElementById("supportPreviewModal");
    const previewContent = document.getElementById("supportRequestPreviewContent");
    const submitAfterPreview = document.getElementById("previewSubmitRequest");
    const closeButtons = document.querySelectorAll("[data-close-preview], #closeSupportPreview");
    const fileInput = document.getElementById("support_documents");
    const fileOutput = document.getElementById("selectedSupportFiles");
    const shortDescription = document.getElementById("short_description");
    const shortCount = document.getElementById("shortDescriptionCount");
    let lastFocused = null;

    // Character count for the short description.
    function updateCount() {
        if (shortDescription && shortCount) {
            shortCount.textContent = shortDescription.value.length;
        }
    }
    if (shortDescription) {
        shortDescription.addEventListener("input", updateCount);
        updateCount();
    }

    // Show selected filenames. Server-side upload validation is still required.
    if (fileInput && fileOutput) {
        fileInput.addEventListener("change", function () {
            const files = Array.from(fileInput.files || []);
            if (!files.length) {
                fileOutput.textContent = "No files selected";
                return;
            }
            fileOutput.textContent = files.map(function (file) {
                return file.name + " (" + formatBytes(file.size) + ")";
            }).join(" · ");
        });
    }

    function formatBytes(bytes) {
        if (bytes < 1024) return bytes + " B";
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + " KB";
        return (bytes / 1048576).toFixed(1) + " MB";
    }

    function fieldValue(name) {
        if (!form) return "";
        const field = form.elements.namedItem(name);
        if (!field) return "";
        if (field instanceof RadioNodeList) {
            return field.value || "";
        }
        if (field.type === "checkbox") return field.checked ? "Yes" : "No";
        return (field.value || "").trim();
    }

    function addPreviewItem(label, value) {
        const item = document.createElement("div");
        item.className = "pl-preview-item";
        const title = document.createElement("span");
        title.textContent = label;
        const content = document.createElement("strong");
        content.textContent = value || "Not provided";
        item.append(title, content);
        previewContent.appendChild(item);
    }

    function openPreview() {
        if (!form || !modal || !previewContent) return;

        // Native validation highlights missing required fields before preview.
        if (!form.reportValidity()) return;

        lastFocused = document.activeElement;
        previewContent.replaceChildren();

        const rows = [
            ["Support category", fieldValue("support_type")],
            ["Request title", fieldValue("request_title")],
            ["Short description", fieldValue("short_description")],
            ["Detailed requirement", fieldValue("detailed_requirement")],
            ["Amount required", fieldValue("amount_required") ? "₹" + fieldValue("amount_required") : "Not applicable"],
            ["People affected", fieldValue("people_affected")],
            ["Urgency", fieldValue("urgency_level")],
            ["City", fieldValue("city")],
            ["Area / locality", fieldValue("locality")],
            ["Full name", fieldValue("show_name") === "Yes" ? fieldValue("full_name") : "Hidden in public display"],
            ["Community", fieldValue("community_name")],
            ["Contact details", fieldValue("hide_contact_details") === "Yes" ? "Hidden from members" : "Visibility permitted by selected settings"],
            ["Member contact permission", fieldValue("allow_member_contact")],
            ["Admin contact permission", fieldValue("allow_admin_contact")],
            ["Supporting files", fileInput && fileInput.files.length ? Array.from(fileInput.files).map(f => f.name).join(", ") : "None selected"]
        ];

        rows.forEach(function (row) {
            addPreviewItem(row[0], row[1]);
        });

        modal.classList.add("is-open");
        modal.setAttribute("aria-hidden", "false");
        document.body.classList.add("pl-modal-open");
        const close = modal.querySelector(".pl-preview-close");
        if (close) close.focus();
    }

    function closePreview() {
        if (!modal) return;
        modal.classList.remove("is-open");
        modal.setAttribute("aria-hidden", "true");
        document.body.classList.remove("pl-modal-open");
        if (lastFocused && typeof lastFocused.focus === "function") lastFocused.focus();
    }

    if (previewButton) previewButton.addEventListener("click", openPreview);
    closeButtons.forEach(function (button) {
        button.addEventListener("click", closePreview);
    });

    if (submitAfterPreview && form) {
        submitAfterPreview.addEventListener("click", function () {
            closePreview();
            const submitButton = form.querySelector('button[name="action"][value="submit"]');
            if (submitButton) submitButton.focus();
        });
    }

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && modal && modal.classList.contains("is-open")) {
            closePreview();
        }
    });

    // Keep the two contact privacy controls from contradicting one another.
    const hideContact = document.getElementById("hide_contact_details");
    const contactVisibility = document.getElementById("contact_visibility");
    if (hideContact && contactVisibility) {
        hideContact.addEventListener("change", function () {
            contactVisibility.value = hideContact.checked ? "hidden" : "visible";
        });
        contactVisibility.addEventListener("change", function () {
            hideContact.checked = contactVisibility.value === "hidden";
        });
    }

    // If the member changes any form field after preview, they can preview again.
    if (form && modal) {
        form.addEventListener("input", function () {
            if (modal.classList.contains("is-open")) closePreview();
        });
    }
});






document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    const requestCards = Array.from(
        document.querySelectorAll(".ms-request-card")
    );

    const tabs = Array.from(document.querySelectorAll(".ms-tab"));
    const searchInput = document.getElementById("requestSearch");
    if (!searchInput) return; // this block belongs to another page
    const categoryFilter = document.getElementById("categoryFilter");
    const statusFilter = document.getElementById("statusFilter");
    const resetButton = document.getElementById("resetFilters");

    const emptyState = document.getElementById("emptyState");
    const emptyTitle = document.getElementById("emptyTitle");
    const emptyDescription = document.getElementById("emptyDescription");

    const closeModal = document.getElementById("closeModal");
    const reasonModal = document.getElementById("reasonModal");

    let activeTab = "All";
    let lastFocusedElement = null;
    let toastTimer;

    // -----------------------------------------
    // Search, status tabs and category filters
    // -----------------------------------------

    function filterRequests() {
        const search = searchInput.value.trim().toLowerCase();
        const category = categoryFilter.value;
        const selectedStatus = statusFilter.value;

        let visibleCount = 0;

        requestCards.forEach(function (card) {
            const title = card.dataset.title.toLowerCase();
            const cardCategory = card.dataset.category;
            const status = card.dataset.status;
            const tabGroup = card.dataset.tab;

            const searchableText = [
                title,
                cardCategory,
                card.textContent
            ].join(" ").toLowerCase();

            const matchesSearch = searchableText.includes(search);

            const matchesCategory =
                category === "All" || cardCategory === category;

            const matchesStatus =
                selectedStatus === "All" || status === selectedStatus;

            const matchesTab =
                activeTab === "All" || tabGroup === activeTab;

            const visible =
                matchesSearch &&
                matchesCategory &&
                matchesStatus &&
                matchesTab;

            card.hidden = !visible;

            if (visible) {
                visibleCount++;
            }
        });

        emptyState.hidden = visibleCount !== 0;

        if (visibleCount === 0) {
            const hasSearch = search !== "";
            const hasFilters =
                category !== "All" ||
                selectedStatus !== "All";

            if (activeTab === "All" && !hasSearch && !hasFilters) {
                emptyTitle.textContent = "You have not submitted any support requests yet.";
                emptyDescription.textContent =
                    "Create your first request to connect with people who may be able to help.";
            } else {
                emptyTitle.textContent = "No support requests found";
                emptyDescription.textContent =
                    "Try another status, category or search term.";
            }
        }
    }

    tabs.forEach(function (tab) {
        tab.addEventListener("click", function () {
            activeTab = tab.dataset.status;

            tabs.forEach(function (item) {
                const selected = item === tab;

                item.classList.toggle("is-active", selected);
                item.setAttribute(
                    "aria-selected",
                    selected ? "true" : "false"
                );
            });

            filterRequests();
        });
    });

    searchInput.addEventListener("input", filterRequests);
    categoryFilter.addEventListener("change", filterRequests);
    statusFilter.addEventListener("change", filterRequests);

    resetButton.addEventListener("click", function () {
        activeTab = "All";
        searchInput.value = "";
        categoryFilter.value = "All";
        statusFilter.value = "All";

        tabs.forEach(function (tab) {
            const selected = tab.dataset.status === "All";

            tab.classList.toggle("is-active", selected);
            tab.setAttribute(
                "aria-selected",
                selected ? "true" : "false"
            );
        });

        filterRequests();
    });

    // -----------------------------------------
    // Modal helpers
    // -----------------------------------------

    function openModal(modal, trigger) {
        if (!modal) return;

        closeAllModals();

        lastFocusedElement = trigger || document.activeElement;

        modal.classList.add("is-open");
        modal.setAttribute("aria-hidden", "false");
        document.body.classList.add("ms-modal-open");

        const firstButton = modal.querySelector(
            "button:not([disabled]), a[href], input:not([type='hidden'])"
        );

        if (firstButton) {
            firstButton.focus();
        }
    }

    function closeModalByElement(modal) {
        if (!modal) return;

        modal.classList.remove("is-open");
        modal.setAttribute("aria-hidden", "true");

        if (!document.querySelector(".ms-modal.is-open")) {
            document.body.classList.remove("ms-modal-open");
        }

        if (
            lastFocusedElement &&
            typeof lastFocusedElement.focus === "function"
        ) {
            lastFocusedElement.focus();
        }
    }

    function closeAllModals() {
        document.querySelectorAll(".ms-modal.is-open").forEach(function (modal) {
            modal.classList.remove("is-open");
            modal.setAttribute("aria-hidden", "true");
        });

        document.body.classList.remove("ms-modal-open");
    }

    document.querySelectorAll("[data-ms-close]").forEach(function (element) {
        element.addEventListener("click", function () {
            closeModalByElement(element.closest(".ms-modal"));
        });
    });

    document.addEventListener("keydown", function (event) {
        const modal = document.querySelector(".ms-modal.is-open");

        if (!modal) return;

        if (event.key === "Escape") {
            closeModalByElement(modal);
            return;
        }

        if (event.key === "Tab") {
            const focusable = Array.from(
                modal.querySelectorAll(
                    'button:not([disabled]), a[href], input:not([disabled])'
                )
            ).filter(function (element) {
                return element.offsetParent !== null;
            });

            if (!focusable.length) return;

            const first = focusable[0];
            const last = focusable[focusable.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (
                !event.shiftKey &&
                document.activeElement === last
            ) {
                event.preventDefault();
                first.focus();
            }
        }
    });

    // -----------------------------------------
    // Close request confirmation
    // -----------------------------------------

    document.querySelectorAll("[data-close-request]").forEach(function (button) {
        button.addEventListener("click", function () {
            const requestId = button.dataset.closeRequest;
            const requestTitle = button.dataset.title;

            document.getElementById("closeRequestId").value = requestId;

            document.getElementById("closeModalText").textContent =
                'Are you sure you want to close "' +
                requestTitle +
                '"?';

            openModal(closeModal, button);
        });
    });

    // -----------------------------------------
    // View rejection reason
    // -----------------------------------------

    document.querySelectorAll("[data-reason]").forEach(function (button) {
        button.addEventListener("click", function () {
            const reason = button.dataset.reason;
            const title = button.dataset.title;
            const card = button.closest(".ms-request-card");
            const requestId = card.dataset.id;

            // textContent prevents supplied text from becoming HTML.
            document.getElementById("reasonText").textContent = reason;
            document.getElementById("reasonRequestTitle").textContent = title;

            document.getElementById("resubmitLink").href =
                "create-support-request.php?id=" +
                encodeURIComponent(requestId);

            openModal(reasonModal, button);
        });
    });

    // -----------------------------------------
    // Toast notification
    // -----------------------------------------

    function showToast(message) {
        const toast = document.getElementById("msToast");
        const toastText = document.getElementById("msToastText");

        toastText.textContent = message;
        toast.classList.add("is-visible");

        clearTimeout(toastTimer);

        toastTimer = setTimeout(function () {
            toast.classList.remove("is-visible");
        }, 3500);
    }

    // -----------------------------------------
    // Initial render
    // -----------------------------------------

    filterRequests();

    /*
     * IMPORTANT:
     * Closing a request is handled by close-support-request.php.
     * That endpoint must authenticate the user, verify ownership,
     * validate CSRF tokens and update the database.
     *
     * This script does not change a request's status in the browser
     * and does not pretend that a server update has succeeded.
     */
});





document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    const form = document.getElementById("offerHelpForm");
    const toast = document.getElementById("ohToast");
    const toastMessage = document.getElementById("ohToastMessage");

    if (!form) return;

    let toastTimer;

    function showToast(message) {
        toastMessage.textContent = message;
        toast.classList.add("is-visible");

        clearTimeout(toastTimer);

        toastTimer = setTimeout(function () {
            toast.classList.remove("is-visible");
        }, 3500);
    }

    // Help-type-specific quantity hints.
    const helpTypeInputs = form.querySelectorAll(
        'input[name="help_type"]'
    );

    const quantityInput = document.getElementById("helpQuantity");
    const quantityUnit = document.getElementById("quantityUnit");
    const quantityHint = document.getElementById("quantityHint");

    const quantityOptions = {
        "Financial Support": {
            hint: "Enter the amount you are offering, if applicable.",
            unit: "INR"
        },
        "Medical Assistance": {
            hint: "Enter the quantity of supplies or assistance, if applicable.",
            unit: "Units"
        },
        "Blood Donation": {
            hint: "Add any relevant quantity or details if applicable.",
            unit: ""
        },
        "Education Support": {
            hint: "Enter the amount, books or learning materials you can provide.",
            unit: "Items"
        },
        "Employment Guidance": {
            hint: "Enter the hours or days you can offer, if applicable.",
            unit: "Hours"
        },
        "Material / Product Support": {
            hint: "Enter the quantity of items you can provide.",
            unit: "Items"
        },
        "Volunteer Support": {
            hint: "Enter the number of hours or days you can volunteer.",
            unit: "Hours"
        },
        "General Assistance": {
            hint: "Enter an amount or quantity if applicable.",
            unit: ""
        },
        "Other": {
            hint: "Enter an amount or quantity if applicable.",
            unit: ""
        }
    };

    function updateQuantityOptions() {
        const selected = form.querySelector(
            'input[name="help_type"]:checked'
        );

        if (!selected) return;

        const config = quantityOptions[selected.value];

        if (!config) return;

        quantityHint.textContent = config.hint;

        // Reset the unit to the suggested default when the help type changes.
        quantityUnit.value = config.unit;
    }

    helpTypeInputs.forEach(function (input) {
        input.addEventListener("change", updateQuantityOptions);
    });

    // Validate inputs and display useful messages.
    function validateForm() {
        let firstInvalid = null;

        form.querySelectorAll("[aria-invalid='true']").forEach(function (field) {
            field.removeAttribute("aria-invalid");
        });

        const requiredFields = form.querySelectorAll(
            "input[required], textarea[required], select[required]"
        );

        requiredFields.forEach(function (field) {
            if (!field.checkValidity()) {
                field.setAttribute("aria-invalid", "true");

                if (!firstInvalid) {
                    firstInvalid = field;
                }
            }
        });

        const mobile = document.getElementById("helperMobile");
        const mobileValue = mobile.value.trim();

        // Basic character-count check; verify the actual phone number server-side.
        const digits = mobileValue.replace(/\D/g, "");

        if (digits.length < 7 || digits.length > 15) {
            mobile.setAttribute("aria-invalid", "true");
            firstInvalid = firstInvalid || mobile;
            showToast("Please enter a valid mobile number.");
        }

        const quantity = quantityInput.value.trim();

        if (
            quantity !== "" &&
            (
                !Number.isFinite(Number(quantity)) ||
                Number(quantity) <= 0
            )
        ) {
            quantityInput.setAttribute("aria-invalid", "true");
            firstInvalid = firstInvalid || quantityInput;
            showToast("Enter a valid amount or quantity.");
        }

        if (firstInvalid) {
            firstInvalid.focus();
            return false;
        }

        return true;
    }

    form.querySelectorAll("input, select, textarea").forEach(function (field) {
        field.addEventListener("input", function () {
            if (field.checkValidity()) {
                field.removeAttribute("aria-invalid");
            }
        });

        field.addEventListener("change", function () {
            if (field.checkValidity()) {
                field.removeAttribute("aria-invalid");
            }
        });
    });

    form.addEventListener("submit", function (event) {
        if (!validateForm()) {
            event.preventDefault();
            return;
        }

        const submitButton = form.querySelector('button[type="submit"]');

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML =
                '<i class="fa-solid fa-spinner fa-spin"></i> Submitting Offer...';
        }

        // The form submits to submit-support-offer.php.
        // The PHP endpoint must validate, save and redirect after success.
        // If submission fails, the server should return a useful error page.
    });

    // Display an optional server-returned error without trusting HTML.
    const params = new URLSearchParams(window.location.search);

    if (params.get("error") === "1") {
        showToast("Your offer could not be submitted. Please try again.");
    }
});

