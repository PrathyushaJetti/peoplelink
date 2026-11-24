document.addEventListener("DOMContentLoaded", function () {

    const profileList =
        document.getElementById("savedProfileList");

    const searchInput =
        document.getElementById("savedProfileSearch");

    const sortSelect =
        document.getElementById("savedProfileSort");

    const emptyState =
        document.getElementById("savedEmpty");

    const profileCount =
        document.getElementById("savedProfileCount");

    const sidebarCount =
        document.getElementById("sidebarSavedCount");

    const interestReadyCount =
        document.getElementById("interestReadyCount");

    const contactRequestCount =
        document.getElementById("contactRequestCount");

    const resultsText =
        document.getElementById("savedResultsText");

    const interestModal =
        document.getElementById("interestModal");

    const contactModal =
        document.getElementById("contactModal");

    const confirmInterest =
        document.getElementById("confirmInterest");

    const confirmContact =
        document.getElementById("confirmContact");

    const toast =
        document.getElementById("savedToast");

    const toastTitle =
        document.getElementById("savedToastTitle");

    const toastMessage =
        document.getElementById("savedToastMessage");


    let selectedInterestProfile = null;
    let selectedContactProfile = null;


    /* =====================================================
       TOAST
    ===================================================== */

    function showToast(title, message) {

        if (toastTitle) {
            toastTitle.textContent = title;
        }

        if (toastMessage) {
            toastMessage.textContent = message;
        }

        toast.classList.add("show");

        clearTimeout(window.savedToastTimer);

        window.savedToastTimer = setTimeout(function () {
            toast.classList.remove("show");
        }, 3500);
    }


    /* =====================================================
       PROFILE CARDS
    ===================================================== */

    function getProfiles() {

        return Array.from(
            profileList.querySelectorAll(
                ".pl-saved-profile"
            )
        );

    }


    /* =====================================================
       SEARCH
    ===================================================== */

    function filterProfiles() {

        const query =
            searchInput.value
                .trim()
                .toLowerCase();


        const profiles = getProfiles();

        let visible = 0;


        profiles.forEach(function (profile) {

            const name =
                profile.dataset.name || "";

            const id =
                profile.dataset.profileId || "";

            const location =
                profile.dataset.location || "";

            const profession =
                profile.dataset.profession || "";


            const searchableText =
                (
                    name +
                    " " +
                    id +
                    " " +
                    location +
                    " " +
                    profession
                ).toLowerCase();


            const matches =
                query === "" ||
                searchableText.includes(query);


            profile.style.display =
                matches ? "" : "none";


            if (matches) {
                visible++;
            }

        });


        updateResultState(visible);

    }


    /* =====================================================
       SORT
    ===================================================== */

    function sortProfiles() {

        const sortValue =
            sortSelect.value;


        const profiles =
            getProfiles();


        profiles.sort(function (a, b) {

            if (sortValue === "age") {

                return Number(a.dataset.age || 0) -
                       Number(b.dataset.age || 0);

            }


            if (sortValue === "location") {

                return (a.dataset.location || "")
                    .localeCompare(
                        b.dataset.location || ""
                    );

            }


            if (sortValue === "profession") {

                return (a.dataset.profession || "")
                    .localeCompare(
                        b.dataset.profession || ""
                    );

            }


            return Number(
                a.dataset.savedOrder || 0
            ) - Number(
                b.dataset.savedOrder || 0
            );

        });


        profiles.forEach(function (profile) {

            profileList.appendChild(profile);

        });


        filterProfiles();

    }


    /* =====================================================
       RESULT STATE
    ===================================================== */

    function updateResultState(visibleCount) {

        const total =
            getProfiles().length;


        profileCount.textContent =
            visibleCount;


        sidebarCount.textContent =
            total;


        interestReadyCount.textContent =
            total;


        if (resultsText) {

            if (visibleCount === total) {

                resultsText.textContent =
                    "Showing your saved matrimony profiles.";

            } else {

                resultsText.textContent =
                    "Showing " +
                    visibleCount +
                    " matching saved profile" +
                    (visibleCount === 1 ? "." : "s.");

            }

        }


        if (visibleCount === 0) {

            emptyState.hidden = false;

        } else {

            emptyState.hidden = true;

        }

    }


    /* =====================================================
       SEARCH EVENTS
    ===================================================== */

    if (searchInput) {

        searchInput.addEventListener(
            "input",
            filterProfiles
        );

    }


    /* =====================================================
       SORT EVENTS
    ===================================================== */

    if (sortSelect) {

        sortSelect.addEventListener(
            "change",
            sortProfiles
        );

    }


    /* =====================================================
       REMOVE SAVED PROFILE
    ===================================================== */

    document.addEventListener("click", function (event) {

        const removeButton =
            event.target.closest(
                "[data-remove-profile]"
            );


        if (!removeButton) {
            return;
        }


        const profileId =
            removeButton.getAttribute(
                "data-remove-profile"
            );
        if (profileId) {
            const fd = new FormData();
            fd.append("action", "toggle_save");
            fd.append("profile_id", profileId);
            fetch("/peoplelink/matrimoney/api.php", { method: "POST", body: fd })
            .then(r => r.json()).then(res => { if(!res.ok) console.warn(res.error); });
        }


        const profile =
            document.querySelector(
                '[data-profile-id="' +
                profileId +
                '"]'
            );


        if (!profile) {
            return;
        }


        profile.style.opacity = "0";
        profile.style.transform = "translateX(15px)";


        setTimeout(function () {

            profile.remove();

            updateResultState(
                getProfiles().length
            );


            showToast(
                "Profile Removed",
                "The profile has been removed from your saved list."
            );


        }, 220);

    });


    /* =====================================================
       EXPRESS INTEREST
    ===================================================== */

    document.addEventListener("click", function (event) {

        const button =
            event.target.closest(
                "[data-interest-profile]"
            );


        if (!button) {
            return;
        }


        if (button.classList.contains("is-sent")) {
            return;
        }


        selectedInterestProfile =
            button.getAttribute(
                "data-interest-profile"
            );


        interestModal.hidden = false;

    });


    /* =====================================================
       CONFIRM INTEREST
    ===================================================== */

    if (confirmInterest) {

        confirmInterest.addEventListener(
            "click",
            function () {

                if (!selectedInterestProfile) { return; }
                const fd = new FormData();
                fd.append("action", "send_interest");
                fd.append("profile_id", selectedInterestProfile);
                fetch("/peoplelink/matrimoney/api.php", { method: "POST", body: fd })
                .then(r => r.json()).then(res => { if(!res.ok) console.warn(res.error); });
                }


                const button =
                    document.querySelector(
                        '[data-interest-profile="' +
                        selectedInterestProfile +
                        '"]'
                    );


                if (button) {

                    button.classList.add("is-sent");

                    button.innerHTML =
                        '<i class="bi bi-check-circle-fill"></i> Interest Sent';

                }


                interestModal.hidden = true;


                showToast(
                    "Interest Sent",
                    "Your interest has been recorded for this profile."
                );


                selectedInterestProfile = null;

            }
        );

    }


    /* =====================================================
       REQUEST CONTACT
    ===================================================== */

    document.addEventListener("click", function (event) {

        const button =
            event.target.closest(
                "[data-contact-profile]"
            );


        if (!button) {
            return;
        }


        selectedContactProfile =
            button.getAttribute(
                "data-contact-profile"
            );


        contactModal.hidden = false;

    });


    /* =====================================================
       CONFIRM CONTACT
    ===================================================== */

    if (confirmContact) {

        confirmContact.addEventListener(
            "click",
            function () {

                if (!selectedContactProfile) {
                    return;
                }


                const button =
                    document.querySelector(
                        '[data-contact-profile="' +
                        selectedContactProfile +
                        '"]'
                    );


                if (button) {

                    button.innerHTML =
                        '<i class="bi bi-clock"></i> Request Sent';

                    button.disabled = true;

                    button.style.opacity = "0.7";

                }


                const current =
                    Number(
                        contactRequestCount.textContent
                    ) || 0;


                contactRequestCount.textContent =
                    current + 1;


                contactModal.hidden = true;


                showToast(
                    "Contact Request Sent",
                    "Your contact request has been submitted."
                );


                selectedContactProfile = null;

            }
        );

    }


    /* =====================================================
       CLOSE MODALS
    ===================================================== */

    document.querySelectorAll(
        "[data-close-interest]"
    ).forEach(function (element) {

        element.addEventListener(
            "click",
            function () {

                interestModal.hidden = true;

                selectedInterestProfile = null;

            }
        );

    });


    document.querySelectorAll(
        "[data-close-contact]"
    ).forEach(function (element) {

        element.addEventListener(
            "click",
            function () {

                contactModal.hidden = true;

                selectedContactProfile = null;

            }
        );

    });


    /* =====================================================
       ESCAPE KEY
    ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (event.key !== "Escape") {
                return;
            }


            if (
                interestModal &&
                !interestModal.hidden
            ) {

                interestModal.hidden = true;

                selectedInterestProfile = null;

            }


            if (
                contactModal &&
                !contactModal.hidden
            ) {

                contactModal.hidden = true;

                selectedContactProfile = null;

            }

        }
    );


    /* =====================================================
       INITIALIZE
    ===================================================== */

    updateResultState(
        getProfiles().length
    );

});