document.addEventListener("DOMContentLoaded", function () {

    const page = document.querySelector(
        ".pl-mp-packages-page"
    );

    if (!page) {
        return;
    }


    /* =====================================================
       ELEMENTS
    ===================================================== */

    const packageModal =
        document.getElementById(
            "packageSelectionModal"
        );

    const closePackageModal =
        document.getElementById(
            "closePackageModal"
        );

    const cancelPackageSelection =
        document.getElementById(
            "cancelPackageSelection"
        );

    const confirmPackageSelection =
        document.getElementById(
            "confirmPackageSelection"
        );


    const selectedPackageName =
        document.getElementById(
            "selectedPackageName"
        );

    const selectedPackagePrice =
        document.getElementById(
            "selectedPackagePrice"
        );

    const selectedPackageValidity =
        document.getElementById(
            "selectedPackageValidity"
        );

    const selectedPackageContacts =
        document.getElementById(
            "selectedPackageContacts"
        );


    const compareToggleBtn =
        document.getElementById(
            "compareToggleBtn"
        );

    const compareTableWrap =
        document.getElementById(
            "compareTableWrap"
        );


    const renewPackageBtn =
        document.getElementById(
            "renewPackageBtn"
        );

    const upgradePackageBtn =
        document.getElementById(
            "upgradePackageBtn"
        );


    /* =====================================================
       TOAST
    ===================================================== */

    const toast =
        document.getElementById(
            "packageToast"
        );

    const toastTitle =
        document.getElementById(
            "packageToastTitle"
        );

    const toastMessage =
        document.getElementById(
            "packageToastMessage"
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
       PACKAGE STATE
    ===================================================== */

    let selectedPackage = null;


    /* =====================================================
       OPEN PACKAGE MODAL
    ===================================================== */

    function openPackageModal(packageCard) {

        if (!packageCard) {
            return;
        }


        const packageName =
            packageCard.dataset.package;

        const packagePrice =
            packageCard.dataset.price;

        const packageValidity =
            packageCard.dataset.validity;

        const packageContacts =
            packageCard.dataset.contact;


        selectedPackage = {
            name: packageName,
            price: packagePrice,
            validity: packageValidity,
            contacts: packageContacts
        };


        selectedPackageName.textContent =
            packageName + " Package";

        selectedPackagePrice.textContent =
            Number(packagePrice).toLocaleString(
                "en-IN"
            );

        selectedPackageValidity.textContent =
            packageValidity;

        selectedPackageContacts.textContent =
            packageContacts;


        packageModal.classList.add(
            "active"
        );

        packageModal.setAttribute(
            "aria-hidden",
            "false"
        );

        document.body.style.overflow =
            "hidden";
    }


    /* =====================================================
       CLOSE PACKAGE MODAL
    ===================================================== */

    function closePackageSelectionModal() {

        packageModal.classList.remove(
            "active"
        );

        packageModal.setAttribute(
            "aria-hidden",
            "true"
        );

        selectedPackage = null;

        document.body.style.overflow =
            "";
    }


    /* =====================================================
       PACKAGE SELECTION
    ===================================================== */

    document.addEventListener(
        "click",
        function (event) {

            const button =
                event.target.closest(
                    "[data-package-select]"
                );

            if (!button) {
                return;
            }


            const packageCard =
                button.closest(
                    ".pl-mpp-package"
                );

            openPackageModal(
                packageCard
            );
        }
    );


    /* =====================================================
       CONFIRM PACKAGE
    ===================================================== */

    confirmPackageSelection.addEventListener(
        "click",
        function () {

            if (!selectedPackage) {
                return;
            }


            /*
             * Frontend/demo only.
             *
             * Production:
             * Redirect to the actual payment/
             * checkout page after server-side
             * package and pricing validation.
             */

            const packageName =
                selectedPackage.name;

            closePackageSelectionModal();


            showToast(
                "Package Selected",
                packageName +
                " Package selected. Continue to checkout when payment integration is connected."
            );
        }
    );


    /* =====================================================
       COMPARE TOGGLE
    ===================================================== */

    compareToggleBtn.addEventListener(
        "click",
        function () {

            const isHidden =
                compareTableWrap.style.display ===
                "none";


            if (isHidden) {

                compareTableWrap.style.display =
                    "block";

                compareToggleBtn.innerHTML =
                    `
                    <i class="bi bi-chevron-up"></i>
                    Hide Comparison
                    `;

            } else {

                compareTableWrap.style.display =
                    "none";

                compareToggleBtn.innerHTML =
                    `
                    <i class="bi bi-layout-three-columns"></i>
                    Compare Packages
                    `;
            }

        }
    );


    /* =====================================================
       RENEW
    ===================================================== */

    renewPackageBtn.addEventListener(
        "click",
        function () {

            showToast(
                "Renew Package",
                "Your current Premium Package is ready for renewal."
            );

        }
    );


    /* =====================================================
       UPGRADE
    ===================================================== */

    upgradePackageBtn.addEventListener(
        "click",
        function () {

            const featuredPackage =
                document.querySelector(
                    '.pl-mpp-package[data-package="Featured"]'
                );


            if (featuredPackage) {

                openPackageModal(
                    featuredPackage
                );

            }

        }
    );


    /* =====================================================
       CLOSE MODAL BUTTONS
    ===================================================== */

    closePackageModal.addEventListener(
        "click",
        closePackageSelectionModal
    );


    cancelPackageSelection.addEventListener(
        "click",
        closePackageSelectionModal
    );


    /* =====================================================
       MODAL OVERLAY
    ===================================================== */

    const modalOverlay =
        packageModal.querySelector(
            ".pl-mpp-modal-overlay"
        );


    if (modalOverlay) {

        modalOverlay.addEventListener(
            "click",
            closePackageSelectionModal
        );
    }


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

                closePackageSelectionModal();

            }

        }
    );


    /* =====================================================
       INITIALIZE
    ===================================================== */

    /*
     * Keep comparison visible by default.
     * On small screens users can still scroll
     * horizontally through the comparison table.
     */

    compareTableWrap.style.display =
        "block";

});