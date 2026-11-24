document.addEventListener("DOMContentLoaded", function () {

    const page = document.querySelector(
        ".pl-interest-status-page"
    );

    if (!page) {
        return;
    }


    /* =====================================================
       ELEMENTS
    ===================================================== */

    const filterSelect =
        document.getElementById(
            "interestStatusFilter"
        );

    const interestList =
        document.getElementById(
            "interestStatusList"
        );

    const emptyState =
        document.getElementById(
            "interestStatusEmpty"
        );

    const resetFilter =
        document.getElementById(
            "resetInterestStatusFilter"
        );


    const acceptedCount =
        document.getElementById(
            "acceptedCount"
        );

    const declinedCount =
        document.getElementById(
            "declinedCount"
        );

    const contactCount =
        document.getElementById(
            "contactCount"
        );

    const totalCount =
        document.getElementById(
            "totalCount"
        );


    /* =====================================================
       CONTACT MODAL
    ===================================================== */

    const contactModal =
        document.getElementById(
            "interestStatusContactModal"
        );

    const closeContactModal =
        document.getElementById(
            "closeInterestStatusContactModal"
        );

    const closeContactButton =
        document.getElementById(
            "closeInterestStatusContactButton"
        );


    /* =====================================================
       TOAST
    ===================================================== */

    const toast =
        document.getElementById(
            "interestStatusToast"
        );

    const toastTitle =
        document.getElementById(
            "interestStatusToastTitle"
        );

    const toastMessage =
        document.getElementById(
            "interestStatusToastMessage"
        );

    let toastTimer = null;


    function showToast(
        title,
        message
    ) {

        toastTitle.textContent =
            title;

        toastMessage.textContent =
            message;

        toast.classList.add(
            "active"
        );

        clearTimeout(
            toastTimer
        );

        toastTimer =
            setTimeout(function () {

                toast.classList.remove(
                    "active"
                );

            }, 3500);
    }


    /* =====================================================
       CONTACT MODAL
    ===================================================== */

    function openContactModal() {

        contactModal.classList.add(
            "active"
        );

        contactModal.setAttribute(
            "aria-hidden",
            "false"
        );

        document.body.style.overflow =
            "hidden";
    }


    function closeContactModalBox() {

        contactModal.classList.remove(
            "active"
        );

        contactModal.setAttribute(
            "aria-hidden",
            "true"
        );

        document.body.style.overflow =
            "";
    }


    /* =====================================================
       FILTER
    ===================================================== */

    function applyFilter() {

        const selected =
            filterSelect.value;

        const cards =
            document.querySelectorAll(
                ".pl-is-card"
            );

        let visibleCount = 0;


        cards.forEach(function (card) {

            const status =
                card.dataset.status;

            const recent =
                card.dataset.recent ===
                "true";

            let show = true;


            if (
                selected ===
                "accepted"
            ) {

                show =
                    status === "accepted";

            } else if (
                selected ===
                "declined"
            ) {

                show =
                    status === "declined";

            } else if (
                selected ===
                "recent"
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
                ".pl-is-card"
            );

        let accepted = 0;
        let declined = 0;
        let contact = 0;


        cards.forEach(function (card) {

            const status =
                card.dataset.status;

            const hasContact =
                card.dataset.contact ===
                "true";


            if (
                status ===
                "accepted"
            ) {

                accepted++;

            }


            if (
                status ===
                "declined"
            ) {

                declined++;

            }


            if (hasContact) {

                contact++;

            }

        });


        acceptedCount.textContent =
            accepted;

        declinedCount.textContent =
            declined;

        contactCount.textContent =
            contact;

        totalCount.textContent =
            cards.length;
    }


    /* =====================================================
       CONTACT BUTTON
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


            /*
             * Production:
             * Verify accepted status,
             * package permissions and
             * privacy settings server-side
             * before returning contact data.
             */

            openContactModal();


            showToast(
                "Contact Access",
                "Contact access is available for this accepted interest."
            );
        }
    );


    /* =====================================================
       MODAL CLOSE
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
        ".pl-is-modal-overlay"
    ).forEach(function (overlay) {

        overlay.addEventListener(
            "click",
            function () {

                const modal =
                    overlay.closest(
                        ".pl-is-modal"
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
       ESCAPE KEY
    ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (
                event.key ===
                "Escape"
            ) {

                closeContactModalBox();

            }

        }
    );


    /* =====================================================
       INITIALIZE
    ===================================================== */

    updateCounts();

    applyFilter();

});