document.addEventListener("DOMContentLoaded", function () {

    /*
     * PEOPLELINK MATRIMONY PACKAGE DETAILS
     * Frontend/demo implementation.
     *
     * Page 16 can replace the payment button
     * behaviour with the actual checkout/payment flow.
     */


    const packageData = {

        name: "Premium",

        price: 999,

        validity: "60 Days",

        contacts: 25,

        visibility: "Enhanced",

        featured: true,

        featuredDuration: "30 Days",

        startDate: "01 October 2026",

        expiryDate: "30 November 2026"

    };


    /* =====================================================
       ELEMENTS
       ===================================================== */

    const packageName = document.getElementById("packageName");
    const packagePrice = document.getElementById("packagePrice");
    const packageValidity = document.getElementById("packageValidity");

    const validityPeriod = document.getElementById("validityPeriod");
    const contactAccess = document.getElementById("contactAccess");
    const profileVisibility = document.getElementById("profileVisibility");
    const featuredBenefit = document.getElementById("featuredBenefit");

    const startDate = document.getElementById("startDate");
    const expiryDate = document.getElementById("expiryDate");

    const contactCount = document.getElementById("contactCount");
    const featuredDuration = document.getElementById("featuredDuration");

    const summaryPackage = document.getElementById("summaryPackage");
    const summaryPrice = document.getElementById("summaryPrice");
    const summaryValidity = document.getElementById("summaryValidity");
    const summaryContacts = document.getElementById("summaryContacts");

    const proceedPaymentBtn =
        document.getElementById("proceedPaymentBtn");

    const packageModal =
        document.getElementById("packageModal");

    const modalOverlay =
        document.getElementById("modalOverlay");

    const closePackageModal =
        document.getElementById("closePackageModal");

    const modalProceedBtn =
        document.getElementById("modalProceedBtn");

    const upgradeBtn =
        document.getElementById("upgradeBtn");

    const renewBtn =
        document.getElementById("renewBtn");


    /* =====================================================
       FORMAT PRICE
       ===================================================== */

    function formatPrice(amount) {

        return "₹" + Number(amount).toLocaleString("en-IN");

    }


    /* =====================================================
       LOAD PACKAGE DATA
       ===================================================== */

    function loadPackageData() {

        if (packageName) {
            packageName.textContent = packageData.name;
        }

        if (packagePrice) {
            packagePrice.textContent =
                formatPrice(packageData.price);
        }

        if (packageValidity) {
            packageValidity.textContent =
                packageData.validity + " Validity";
        }

        if (validityPeriod) {
            validityPeriod.textContent =
                packageData.validity;
        }

        if (contactAccess) {
            contactAccess.textContent =
                packageData.contacts + " Contacts";
        }

        if (profileVisibility) {
            profileVisibility.textContent =
                packageData.visibility;
        }

        if (featuredBenefit) {
            featuredBenefit.textContent =
                packageData.featured
                    ? "Included"
                    : "Not Included";
        }

        if (startDate) {
            startDate.textContent =
                packageData.startDate;
        }

        if (expiryDate) {
            expiryDate.textContent =
                packageData.expiryDate;
        }

        if (contactCount) {
            contactCount.textContent =
                packageData.contacts;
        }

        if (featuredDuration) {
            featuredDuration.textContent =
                packageData.featured
                    ? packageData.featuredDuration
                    : "Not Included";
        }

        if (summaryPackage) {
            summaryPackage.textContent =
                packageData.name;
        }

        if (summaryPrice) {
            summaryPrice.textContent =
                formatPrice(packageData.price);
        }

        if (summaryValidity) {
            summaryValidity.textContent =
                packageData.validity;
        }

        if (summaryContacts) {
            summaryContacts.textContent =
                packageData.contacts;
        }

    }


    /* =====================================================
       MODAL
       ===================================================== */

    function openModal() {

        if (!packageModal) return;

        packageModal.classList.add("active");

        document.body.style.overflow = "hidden";

    }


    function closeModal() {

        if (!packageModal) return;

        packageModal.classList.remove("active");

        document.body.style.overflow = "";

    }


    if (proceedPaymentBtn) {

        proceedPaymentBtn.addEventListener(
            "click",
            function () {

                openModal();

            }
        );

    }


    if (closePackageModal) {

        closePackageModal.addEventListener(
            "click",
            function () {

                closeModal();

            }
        );

    }


    if (modalOverlay) {

        modalOverlay.addEventListener(
            "click",
            function () {

                closeModal();

            }
        );

    }


    /* =====================================================
       PAGE 16 PAYMENT REDIRECT
       ===================================================== */

    if (modalProceedBtn) {

        modalProceedBtn.addEventListener(
            "click",
            function () {

                /*
                 * Page 16 will contain:
                 *
                 * matrimony-package-purchase.php
                 *
                 * Replace this location when Page 16
                 * payment integration is implemented.
                 */

                window.location.href =
                    "matrimony-package-purchase.php";

            }
        );

    }


    /* =====================================================
       UPGRADE
       ===================================================== */

    if (upgradeBtn) {

        upgradeBtn.addEventListener(
            "click",
            function () {

                showMessage(
                    "Package upgrade options will be available here."
                );

            }
        );

    }


    /* =====================================================
       RENEW
       ===================================================== */

    if (renewBtn) {

        renewBtn.addEventListener(
            "click",
            function () {

                showMessage(
                    "Your package renewal process will start here."
                );

            }
        );

    }


    /* =====================================================
       TOAST MESSAGE
       ===================================================== */

    function showMessage(message) {

        const oldToast =
            document.querySelector(".pl-pd-toast");

        if (oldToast) {
            oldToast.remove();
        }


        const toast =
            document.createElement("div");

        toast.className = "pl-pd-toast";

        toast.innerHTML = `
            <i class="bi bi-check-circle-fill"></i>
            <span>${message}</span>
        `;


        document.body.appendChild(toast);


        requestAnimationFrame(function () {

            toast.classList.add("show");

        });


        setTimeout(function () {

            toast.classList.remove("show");

            setTimeout(function () {

                toast.remove();

            }, 250);

        }, 3000);

    }


    /* =====================================================
       TOAST CSS
       ===================================================== */

    const toastStyle =
        document.createElement("style");

    toastStyle.textContent = `

        .pl-pd-toast {
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 10001;
            display: flex;
            align-items: center;
            gap: 9px;
            max-width: 360px;
            padding: 13px 17px;
            border-radius: 12px;
            background: #073b70;
            color: #fff;
            box-shadow: 0 12px 30px rgba(0,0,0,.18);
            font-size: 13px;
            font-weight: 600;
            opacity: 0;
            transform: translateY(15px);
            transition: .25s ease;
        }

        .pl-pd-toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .pl-pd-toast i {
            color: #42b72a;
            font-size: 17px;
        }

        @media (max-width: 600px) {

            .pl-pd-toast {
                left: 15px;
                right: 15px;
                bottom: 15px;
                max-width: none;
            }

        }

    `;

    document.head.appendChild(toastStyle);


    /* =====================================================
       ESC KEY
       ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (event.key === "Escape") {

                closeModal();

            }

        }
    );


    /* =====================================================
       INITIALIZE
       ===================================================== */

    loadPackageData();

});