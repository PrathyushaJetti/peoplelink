document.addEventListener("DOMContentLoaded", function () {

    const page = document.querySelector(
        ".pl-sent-interest-page"
    );

    if (!page) {
        return;
    }


    /* =====================================================
       ELEMENTS
    ===================================================== */

    const filterSelect =
        document.getElementById(
            "sentInterestFilter"
        );

    const interestList =
        document.getElementById(
            "sentInterestList"
        );

    const emptyState =
        document.getElementById(
            "sentInterestEmpty"
        );

    const resetFilter =
        document.getElementById(
            "resetSentFilter"
        );


    const pendingCount =
        document.getElementById(
            "pendingSentCount"
        );

    const acceptedCount =
        document.getElementById(
            "acceptedSentCount"
        );

    const declinedCount =
        document.getElementById(
            "declinedSentCount"
        );

    const withdrawnCount =
        document.getElementById(
            "withdrawnSentCount"
        );


    /* =====================================================
       MODALS
    ===================================================== */

    const actionModal =
        document.getElementById(
            "sentInterestActionModal"
        );

    const closeActionModal =
        document.getElementById(
            "closeSentModal"
        );

    const cancelAction =
        document.getElementById(
            "cancelSentAction"
        );

    const confirmAction =
        document.getElementById(
            "confirmSentAction"
        );


    const contactModal =
        document.getElementById(
            "sentContactModal"
        );

    const closeContactModal =
        document.getElementById(
            "closeSentContactModal"
        );

    const closeContactButton =
        document.getElementById(
            "closeSentContactButton"
        );


    /* =====================================================
       TOAST
    ===================================================== */

    const toast =
        document.getElementById(
            "sentInterestToast"
        );

    const toastTitle =
        document.getElementById(
            "sentToastTitle"
        );

    const toastMessage =
        document.getElementById(
            "sentToastMessage"
        );

    let toastTimer = null;


    function showToast(title, message) {

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
    let selectedProfileId = null;


    function openWithdrawModal(card, profileId) {

        selectedCard = card;
        selectedProfileId = profileId;

        actionModal.classList.add("active");

        actionModal.setAttribute(
            "aria-hidden",
            "false"
        );

        document.body.style.overflow = "hidden";
    }


    function closeWithdrawModal() {

        actionModal.classList.remove("active");

        actionModal.setAttribute(
            "aria-hidden",
            "true"
        );

        selectedCard = null;
        selectedProfileId = null;

        document.body.style.overflow = "";
    }


    /* =====================================================
       CONTACT MODAL
    ===================================================== */

    function openContactModal() {

        contactModal.classList.add("active");

        contactModal.setAttribute(
            "aria-hidden",
            "false"
        );

        document.body.style.overflow = "hidden";
    }


    function closeContactModalBox() {

        contactModal.classList.remove("active");

        contactModal.setAttribute(
            "aria-hidden",
            "true"
        );

        document.body.style.overflow = "";
    }


    /* =====================================================
       WITHDRAW INTEREST
    ===================================================== */

    confirmAction.addEventListener(
        "click",
        function () {

            if (!selectedCard) {
                return;
            }

            const card =
                selectedCard;

            const profileId =
                selectedProfileId;


            /*
             * Only pending interests can be withdrawn.
             */
            if (
                card.dataset.status !==
                "pending"
            ) {

                closeWithdrawModal();

                return;
            }


            card.dataset.status =
                "withdrawn";


            const statusElement =
                card.querySelector(
                    ".pl-si-status"
                );

            if (statusElement) {

                statusElement.className =
                    "pl-si-status withdrawn";

                statusElement.textContent =
                    "Withdrawn";
            }


            /*
             * Replace pending actions.
             */
            const actions =
                card.querySelector(
                    ".pl-si-actions"
                );

            if (actions) {

                actions.innerHTML = `
                    <a
                        href="matrimony-profile-detail.php?id=${encodeURIComponent(profileId)}"
                        class="pl-si-btn view"
                    >
                        <i class="bi bi-person-vcard"></i>
                        View Profile
                    </a>
                `;
            }


            /*
             * Add withdrawn information box.
             */
            removeStatusBoxes(card);

            const content =
                card.querySelector(
                    ".pl-si-profile-content"
                );

            const message =
                card.querySelector(
                    ".pl-si-message"
                );

            const withdrawnBox =
                document.createElement("div");

            withdrawnBox.className =
                "pl-si-withdrawn-box";

            withdrawnBox.innerHTML = `
                <i class="bi bi-arrow-counterclockwise"></i>

                <div>
                    <strong>
                        Interest Withdrawn
                    </strong>

                    <span>
                        This interest was withdrawn by you.
                    </span>
                </div>
            `;


            if (message) {

                message.insertAdjacentElement(
                    "afterend",
                    withdrawnBox
                );

            } else {

                content.appendChild(
                    withdrawnBox
                );
            }


            saveState(
                profileId,
                "withdrawn"
            );


            updateCounts();

            closeWithdrawModal();

            showToast(
                "Interest Withdrawn",
                "Your pending interest has been withdrawn."
            );

            applyFilter();
        }
    );


    /* =====================================================
       REMOVE OLD STATUS BOXES
    ===================================================== */

    function removeStatusBoxes(card) {

        const selectors = [
            ".pl-si-accepted-box",
            ".pl-si-declined-box",
            ".pl-si-withdrawn-box",
            ".pl-si-contact"
        ];

        selectors.forEach(function (selector) {

            const element =
                card.querySelector(selector);

            if (element) {
                element.remove();
            }
        });
    }


    /* =====================================================
       LOCAL STORAGE
    ===================================================== */

    function saveState(profileId, status) {

        if (!profileId) {
            return;
        }

        localStorage.setItem(
            "peoplelink_sent_interest_" + profileId,
            status
        );
    }


    function getState(profileId) {

        return localStorage.getItem(
            "peoplelink_sent_interest_" + profileId
        );
    }


    /* =====================================================
       LOAD SAVED STATES
    ===================================================== */

    function loadSavedStates() {

        const cards =
            document.querySelectorAll(
                ".pl-si-card"
            );

        cards.forEach(function (card) {

            const profileId =
                card.dataset.id;

            if (!profileId) {
                return;
            }

            const savedStatus =
                getState(profileId);

            if (
                savedStatus &&
                savedStatus !==
                card.dataset.status
            ) {

                if (
                    card.dataset.status ===
                    "pending"
                ) {

                    if (
                        savedStatus ===
                        "withdrawn"
                    ) {

                        applyWithdrawnState(
                            card,
                            profileId
                        );
                    }
                }
            }

        });
    }


    function applyWithdrawnState(
        card,
        profileId
    ) {

        card.dataset.status =
            "withdrawn";

        const status =
            card.querySelector(
                ".pl-si-status"
            );

        if (status) {

            status.className =
                "pl-si-status withdrawn";

            status.textContent =
                "Withdrawn";
        }


        removeStatusBoxes(card);

        const actions =
            card.querySelector(
                ".pl-si-actions"
            );

        if (actions) {

            actions.innerHTML = `
                <a
                    href="matrimony-profile-detail.php?id=${encodeURIComponent(profileId)}"
                    class="pl-si-btn view"
                >
                    <i class="bi bi-person-vcard"></i>
                    View Profile
                </a>
            `;
        }


        const content =
            card.querySelector(
                ".pl-si-profile-content"
            );

        const message =
            card.querySelector(
                ".pl-si-message"
            );

        const withdrawnBox =
            document.createElement("div");

        withdrawnBox.className =
            "pl-si-withdrawn-box";

        withdrawnBox.innerHTML = `
            <i class="bi bi-arrow-counterclockwise"></i>

            <div>
                <strong>
                    Interest Withdrawn
                </strong>

                <span>
                    This interest was withdrawn by you.
                </span>
            </div>
        `;


        if (message) {

            message.insertAdjacentElement(
                "afterend",
                withdrawnBox
            );

        } else {

            content.appendChild(
                withdrawnBox
            );
        }
    }


    /* =====================================================
       FILTER
    ===================================================== */

    function applyFilter() {

        const selected =
            filterSelect.value;

        const cards =
            document.querySelectorAll(
                ".pl-si-card"
            );

        let visibleCount = 0;


        cards.forEach(function (card) {

            const status =
                card.dataset.status;

            const recent =
                card.dataset.recent ===
                "true";

            let show = true;


            if (selected === "pending") {

                show =
                    status === "pending";

            } else if (
                selected === "accepted"
            ) {

                show =
                    status === "accepted";

            } else if (
                selected === "declined"
            ) {

                show =
                    status === "declined";

            } else if (
                selected === "withdrawn"
            ) {

                show =
                    status === "withdrawn";

            } else if (
                selected === "recent"
            ) {

                show = recent;
            }


            if (show) {

                card.style.display =
                    "grid";

                visibleCount++;

            } else {

                card.style.display =
                    "none";
            }

        });


        if (visibleCount === 0) {

            interestList.style.display =
                "none";

            emptyState.style.display =
                "block";

        } else {

            interestList.style.display =
                "grid";

            emptyState.style.display =
                "none";
        }
    }


    filterSelect.addEventListener(
        "change",
        applyFilter
    );


    resetFilter.addEventListener(
        "click",
        function () {

            filterSelect.value =
                "all";

            applyFilter();
        }
    );


    /* =====================================================
       COUNTS
    ===================================================== */

    function updateCounts() {

        const cards =
            document.querySelectorAll(
                ".pl-si-card"
            );

        let pending = 0;
        let accepted = 0;
        let declined = 0;
        let withdrawn = 0;


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

            if (status === "withdrawn") {
                withdrawn++;
            }
        });


        pendingCount.textContent =
            pending;

        acceptedCount.textContent =
            accepted;

        declinedCount.textContent =
            declined;

        withdrawnCount.textContent =
            withdrawn;
    }


    /* =====================================================
       WITHDRAW BUTTONS
    ===================================================== */

    document.addEventListener(
        "click",
        function (event) {

            const button =
                event.target.closest(
                    "[data-action='withdraw']"
                );

            if (!button) {
                return;
            }

            const card =
                button.closest(
                    ".pl-si-card"
                );

            if (!card) {
                return;
            }

            const profileId =
                button.dataset.id;

            openWithdrawModal(
                card,
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
       CLOSE ACTION MODAL
    ===================================================== */

    closeActionModal.addEventListener(
        "click",
        closeWithdrawModal
    );

    cancelAction.addEventListener(
        "click",
        closeWithdrawModal
    );


    /* =====================================================
       CLOSE CONTACT MODAL
    ===================================================== */

    closeContactModal.addEventListener(
        "click",
        closeContactModalBox
    );

    closeContactButton.addEventListener(
        "click",
        closeContactModalBox
    );


    /* =====================================================
       OVERLAY CLOSE
    ===================================================== */

    document.querySelectorAll(
        ".pl-si-modal-overlay"
    ).forEach(function (overlay) {

        overlay.addEventListener(
            "click",
            function () {

                const modal =
                    overlay.closest(
                        ".pl-si-modal"
                    );

                if (!modal) {
                    return;
                }

                modal.classList.remove(
                    "active"
                );

                modal.setAttribute(
                    "aria-hidden",
                    "true"
                );

                document.body.style.overflow =
                    "";
            }
        );
    });


    /* =====================================================
       ESC KEY
    ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (event.key !== "Escape") {
                return;
            }

            closeWithdrawModal();

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