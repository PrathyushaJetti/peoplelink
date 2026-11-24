document.addEventListener("DOMContentLoaded", function () {

    const page = document.querySelector(".pl-received-interest-page");

    if (!page) {
        return;
    }


    /* =====================================================
       ELEMENTS
    ===================================================== */

    const filterSelect = document.getElementById("interestFilter");
    const interestList = document.getElementById("receivedInterestList");
    const emptyState = document.getElementById("receivedInterestEmpty");
    const resetFilter = document.getElementById("resetInterestFilter");

    const pendingCount = document.getElementById("pendingCount");
    const acceptedCount = document.getElementById("acceptedCount");
    const declinedCount = document.getElementById("declinedCount");
    const totalCount = document.getElementById("totalCount");


    /* =====================================================
       MODAL ELEMENTS
    ===================================================== */

    const actionModal = document.getElementById("interestActionModal");
    const actionModalTitle = document.getElementById("interestModalTitle");
    const actionModalText = document.getElementById("interestModalText");

    const confirmActionButton =
        document.getElementById("confirmInterestAction");

    const cancelActionButton =
        document.getElementById("cancelInterestAction");

    const closeActionModal =
        document.getElementById("closeInterestModal");


    const contactModal =
        document.getElementById("contactModal");

    const closeContactModal =
        document.getElementById("closeContactModal");

    const closeContactButton =
        document.getElementById("closeContactButton");


    /* =====================================================
       TOAST
    ===================================================== */

    const toast = document.getElementById("receivedInterestToast");
    const toastTitle = document.getElementById("toastTitle");
    const toastMessage = document.getElementById("toastMessage");

    let toastTimer = null;


    function showToast(title, message) {

        if (!toast) {
            return;
        }

        toastTitle.textContent = title;
        toastMessage.textContent = message;

        toast.classList.add("active");

        clearTimeout(toastTimer);

        toastTimer = setTimeout(function () {
            toast.classList.remove("active");
        }, 3500);
    }


    /* =====================================================
       MODAL STATE
    ===================================================== */

    let selectedCard = null;
    let selectedAction = null;
    let selectedProfileId = null;


    function openActionModal(card, action, profileId) {

        selectedCard = card;
        selectedAction = action;
        selectedProfileId = profileId;

        if (action === "accept") {

            actionModalTitle.textContent = "Accept Interest";

            actionModalText.textContent =
                "Are you interested in this profile? Accepting will allow the connection to proceed according to the applicable privacy and package rules.";

            confirmActionButton.textContent = "Accept Interest";

            confirmActionButton.style.background =
                "var(--pl-green)";

        } else {

            actionModalTitle.textContent = "Decline Interest";

            actionModalText.textContent =
                "Are you sure you want to decline this interest request?";

            confirmActionButton.textContent = "Decline";

            confirmActionButton.style.background =
                "var(--pl-red)";
        }

        actionModal.classList.add("active");
        actionModal.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";
    }


    function closeActionModalBox() {

        actionModal.classList.remove("active");
        actionModal.setAttribute("aria-hidden", "true");

        selectedCard = null;
        selectedAction = null;
        selectedProfileId = null;

        document.body.style.overflow = "";
    }


    /* =====================================================
       CONTACT MODAL
    ===================================================== */

    function openContactModal() {

        contactModal.classList.add("active");
        contactModal.setAttribute("aria-hidden", "false");

        document.body.style.overflow = "hidden";
    }


    function closeContactModalBox() {

        contactModal.classList.remove("active");
        contactModal.setAttribute("aria-hidden", "true");

        document.body.style.overflow = "";
    }


    /* =====================================================
       STATUS UPDATE
    ===================================================== */

    function updateCardStatus(card, status) {

        if (!card) {
            return;
        }

        card.dataset.status = status;

        const statusElement =
            card.querySelector(".pl-ri-status");

        if (statusElement) {

            statusElement.className =
                "pl-ri-status " + status;

            statusElement.textContent =
                status.charAt(0).toUpperCase() +
                status.slice(1);
        }


        const actions =
            card.querySelector(".pl-ri-actions");

        if (!actions) {
            return;
        }


        if (status === "accepted") {

            actions.innerHTML = `
                <a
                    href="${getProfileLink(card)}"
                    class="pl-ri-btn view"
                >
                    <i class="bi bi-person-vcard"></i>
                    View Profile
                </a>
            `;

            addContactAccess(card);

        } else if (status === "declined") {

            actions.innerHTML = `
                <a
                    href="${getProfileLink(card)}"
                    class="pl-ri-btn view"
                >
                    <i class="bi bi-person-vcard"></i>
                    View Profile
                </a>
            `;

            const contactBox =
                card.querySelector(".pl-ri-contact");

            if (contactBox) {
                contactBox.remove();
            }

        }

        updateCounts();
    }


    /* =====================================================
       PROFILE LINK
    ===================================================== */

    function getProfileLink(card) {

        const idElement =
            card.querySelector(".pl-ri-profile-id");

        if (!idElement) {
            return "matrimony-profile-detail.php";
        }

        const idText =
            idElement.textContent
                .replace("PLM", "PLM")
                .trim();

        const match =
            idText.match(/PLM\d+/);

        if (!match) {
            return "matrimony-profile-detail.php";
        }

        return "matrimony-profile-detail.php?id=" +
            encodeURIComponent(match[0]);
    }


    /* =====================================================
       CONTACT ACCESS
    ===================================================== */

    function addContactAccess(card) {

        if (card.querySelector(".pl-ri-contact")) {
            return;
        }

        const content =
            card.querySelector(".pl-ri-profile-content");

        const actions =
            card.querySelector(".pl-ri-actions");

        if (!content || !actions) {
            return;
        }

        const contactBox =
            document.createElement("div");

        contactBox.className = "pl-ri-contact";

        contactBox.innerHTML = `
            <div>
                <i class="bi bi-shield-check"></i>

                <div>
                    <strong>Contact Access Available</strong>
                    <span>
                        Interest accepted. Contact access is available
                        according to your privacy settings and package.
                    </span>
                </div>
            </div>

            <button
                type="button"
                class="pl-ri-contact-btn"
                data-contact="available"
            >
                <i class="bi bi-person-lines-fill"></i>
                View Contact
            </button>
        `;

        content.insertBefore(contactBox, actions);

        const button =
            contactBox.querySelector(".pl-ri-contact-btn");

        button.addEventListener("click", function () {
            openContactModal();
        });
    }


    /* =====================================================
       CONFIRM ACTION
    ===================================================== */

    confirmActionButton.addEventListener(
        "click",
        function () {

            if (!selectedCard || !selectedAction) {
                return;
            }

            const action =
                selectedAction;

            const profileId =
                selectedProfileId;

            if (action === "accept") {

                updateCardStatus(
                    selectedCard,
                    "accepted"
                );

                showToast(
                    "Interest Accepted",
                    "The interest has been accepted successfully."
                );

                saveInterestState(
                    profileId,
                    "accepted"
                );

            } else {

                updateCardStatus(
                    selectedCard,
                    "declined"
                );

                showToast(
                    "Interest Declined",
                    "The interest request has been declined."
                );

                saveInterestState(
                    profileId,
                    "declined"
                );
            }

            closeActionModalBox();

            applyFilter();
        }
    );


    /* =====================================================
       SAVE STATE
    ===================================================== */

    function saveInterestState(profileId, status) {

        if (!profileId) {
            return;
        }

        const key =
            "peoplelink_received_interest_" +
            profileId;

        localStorage.setItem(
            key,
            status
        );
    }


    function getSavedInterestState(profileId) {

        if (!profileId) {
            return null;
        }

        return localStorage.getItem(
            "peoplelink_received_interest_" +
            profileId
        );
    }


    /* =====================================================
       APPLY SAVED STATES
    ===================================================== */

    function loadSavedStates() {

        const cards =
            document.querySelectorAll(".pl-ri-card");

        cards.forEach(function (card) {

            const idElement =
                card.querySelector(".pl-ri-profile-id");

            if (!idElement) {
                return;
            }

            const match =
                idElement.textContent.match(/PLM\d+/);

            if (!match) {
                return;
            }

            const savedStatus =
                getSavedInterestState(match[0]);

            if (savedStatus) {

                updateCardStatus(
                    card,
                    savedStatus
                );
            }
        });
    }


    /* =====================================================
       FILTER
    ===================================================== */

    function applyFilter() {

        const selected =
            filterSelect.value;

        const cards =
            document.querySelectorAll(".pl-ri-card");

        let visibleCount = 0;

        cards.forEach(function (card) {

            const status =
                card.dataset.status;

            const isRecent =
                card.dataset.recent === "true";

            let shouldShow = true;


            if (selected === "pending") {

                shouldShow =
                    status === "pending";

            } else if (selected === "accepted") {

                shouldShow =
                    status === "accepted";

            } else if (selected === "declined") {

                shouldShow =
                    status === "declined";

            } else if (selected === "recent") {

                shouldShow =
                    isRecent;
            }


            if (shouldShow) {

                card.style.display = "grid";

                visibleCount++;

            } else {

                card.style.display = "none";
            }

        });


        if (visibleCount === 0) {

            emptyState.style.display = "block";
            interestList.style.display = "none";

        } else {

            emptyState.style.display = "none";
            interestList.style.display = "grid";
        }
    }


    filterSelect.addEventListener(
        "change",
        applyFilter
    );


    resetFilter.addEventListener(
        "click",
        function () {

            filterSelect.value = "all";

            applyFilter();
        }
    );


    /* =====================================================
       COUNTS
    ===================================================== */

    function updateCounts() {

        const cards =
            document.querySelectorAll(".pl-ri-card");

        let pending = 0;
        let accepted = 0;
        let declined = 0;

        cards.forEach(function (card) {

            const status =
                card.dataset.status;

            if (status === "pending") {
                pending++;
            }

            if (status === "accepted") {
                accepted++;
            }

            if (status === "declined") {
                declined++;
            }
        });

        pendingCount.textContent = pending;
        acceptedCount.textContent = accepted;
        declinedCount.textContent = declined;
        totalCount.textContent = cards.length;
    }


    /* =====================================================
       ACTION BUTTONS
    ===================================================== */

    document.addEventListener(
        "click",
        function (event) {

            const button =
                event.target.closest(
                    "[data-action]"
                );

            if (!button) {
                return;
            }

            const card =
                button.closest(".pl-ri-card");

            if (!card) {
                return;
            }

            const action =
                button.dataset.action;

            const profileId =
                button.dataset.id;

            openActionModal(
                card,
                action,
                profileId
            );
        }
    );


    /* =====================================================
       CONTACT BUTTONS
    ===================================================== */

    document.addEventListener(
        "click",
        function (event) {

            const button =
                event.target.closest(
                    "[data-contact]"
                );

            if (!button) {
                return;
            }

            openContactModal();
        }
    );


    /* =====================================================
       CLOSE MODALS
    ===================================================== */

    closeActionModal.addEventListener(
        "click",
        closeActionModalBox
    );

    cancelActionButton.addEventListener(
        "click",
        closeActionModalBox
    );


    closeContactModal.addEventListener(
        "click",
        closeContactModalBox
    );

    closeContactButton.addEventListener(
        "click",
        closeContactModalBox
    );


    document.querySelectorAll(
        ".pl-ri-modal-overlay"
    ).forEach(function (overlay) {

        overlay.addEventListener(
            "click",
            function () {

                const modal =
                    overlay.closest(".pl-ri-modal");

                if (!modal) {
                    return;
                }

                modal.classList.remove("active");
                modal.setAttribute(
                    "aria-hidden",
                    "true"
                );

                document.body.style.overflow = "";
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

            closeActionModalBox();
            closeContactModalBox();
        }
    );


    /* =====================================================
       INITIALIZE
    ===================================================== */

    loadSavedStates();

    updateCounts();

    applyFilter();

});