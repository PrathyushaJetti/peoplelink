document.addEventListener("DOMContentLoaded", function () {

    /*
     * PEOPLELINK MATRIMONY PACKAGE PURCHASE
     *
     * Frontend/demo payment flow.
     *
     * For production:
     * 1. Create payment order on the server.
     * 2. Open Razorpay / other configured gateway.
     * 3. Verify payment signature server-side.
     * 4. Activate package only after verified success.
     * 5. Store transaction and package information in database.
     */


    /* =====================================================
       PACKAGE DATA
       ===================================================== */

    const packageData = {

        name: "Premium",

        price: 999,

        tax: 0,

        validity: 60,

        contacts: 25,

        featured: true,

        featuredDuration: 30

    };


    /* =====================================================
       ELEMENTS
       ===================================================== */

    const paymentTerms =
        document.getElementById("paymentTerms");

    const proceedPayBtn =
        document.getElementById("proceedPayBtn");

    const paymentModal =
        document.getElementById("paymentModal");

    const paymentModalOverlay =
        document.getElementById("paymentModalOverlay");

    const paymentStatusCard =
        document.getElementById("paymentStatusCard");

    const paymentStatusTitle =
        document.getElementById("paymentStatusTitle");

    const paymentStatusText =
        document.getElementById("paymentStatusText");

    const paymentSuccessCard =
        document.getElementById("paymentSuccessCard");

    const retryCard =
        document.getElementById("retryCard");

    const retryPaymentBtn =
        document.getElementById("retryPaymentBtn");

    const activePackageBtn =
        document.getElementById("activePackageBtn");

    const receiptBtn =
        document.getElementById("receiptBtn");

    const supportBtn =
        document.getElementById("supportBtn");

    const receiptModal =
        document.getElementById("receiptModal");

    const receiptModalOverlay =
        document.getElementById("receiptModalOverlay");

    const closeReceipt =
        document.getElementById("closeReceipt");

    const downloadReceiptBtn =
        document.getElementById("downloadReceiptBtn");

    const supportModal =
        document.getElementById("supportModal");

    const supportModalOverlay =
        document.getElementById("supportModalOverlay");

    const closeSupport =
        document.getElementById("closeSupport");


    /* =====================================================
       PACKAGE DISPLAY
       ===================================================== */

    function formatPrice(amount) {

        return "₹" +
            Number(amount).toLocaleString("en-IN");

    }


    function updatePackageDisplay() {

        const packageName =
            document.getElementById(
                "purchasePackageName"
            );

        const packagePrice =
            document.getElementById(
                "purchasePackagePrice"
            );

        const purchaseValidity =
            document.getElementById(
                "purchaseValidity"
            );

        const purchaseContacts =
            document.getElementById(
                "purchaseContacts"
            );

        const summaryPackage =
            document.getElementById(
                "summaryPackage"
            );

        const summaryAmount =
            document.getElementById(
                "summaryAmount"
            );

        const summaryTax =
            document.getElementById(
                "summaryTax"
            );

        const finalAmount =
            document.getElementById(
                "finalAmount"
            );


        if (packageName) {

            packageName.textContent =
                packageData.name;

        }


        if (packagePrice) {

            packagePrice.textContent =
                formatPrice(
                    packageData.price
                );

        }


        if (purchaseValidity) {

            purchaseValidity.textContent =
                packageData.validity +
                " Days Validity";

        }


        if (purchaseContacts) {

            purchaseContacts.textContent =
                packageData.contacts +
                " Contacts";

        }


        if (summaryPackage) {

            summaryPackage.textContent =
                packageData.name;

        }


        if (summaryAmount) {

            summaryAmount.textContent =
                formatPrice(
                    packageData.price
                );

        }


        if (summaryTax) {

            summaryTax.textContent =
                formatPrice(
                    packageData.tax
                );

        }


        if (finalAmount) {

            finalAmount.textContent =
                formatPrice(
                    packageData.price +
                    packageData.tax
                );

        }

    }


    /* =====================================================
       PAYMENT METHOD
       ===================================================== */

    const paymentOptions =
        document.querySelectorAll(
            ".pl-pp-payment-option"
        );


    paymentOptions.forEach(function (option) {

        option.addEventListener(
            "click",
            function () {

                paymentOptions.forEach(
                    function (item) {

                        item.classList.remove(
                            "active"
                        );

                    }
                );

                option.classList.add(
                    "active"
                );

                const radio =
                    option.querySelector(
                        "input[type='radio']"
                    );

                if (radio) {

                    radio.checked = true;

                }

            }
        );

    });


    /* =====================================================
       MODAL HELPERS
       ===================================================== */

    function openPaymentModal() {

        if (!paymentModal) return;

        paymentModal.classList.add(
            "active"
        );

        document.body.style.overflow =
            "hidden";

    }


    function closePaymentModal() {

        if (!paymentModal) return;

        paymentModal.classList.remove(
            "active"
        );

        document.body.style.overflow =
            "";

    }


    function openReceiptModal() {

        if (!receiptModal) return;

        receiptModal.classList.add(
            "active"
        );

        document.body.style.overflow =
            "hidden";

    }


    function closeReceiptModal() {

        if (!receiptModal) return;

        receiptModal.classList.remove(
            "active"
        );

        document.body.style.overflow =
            "";

    }


    function openSupportModal() {

        if (!supportModal) return;

        supportModal.classList.add(
            "active"
        );

        document.body.style.overflow =
            "hidden";

    }


    function closeSupportModal() {

        if (!supportModal) return;

        supportModal.classList.remove(
            "active"
        );

        document.body.style.overflow =
            "";

    }


    /* =====================================================
       VALIDATE PAYMENT
       ===================================================== */

    function validatePayment() {

        if (!paymentTerms.checked) {

            showToast(
                "Please accept the package and payment terms."
            );

            paymentTerms.focus();

            return false;

        }

        return true;

    }


    /* =====================================================
       PROCEED TO PAY
       ===================================================== */

    if (proceedPayBtn) {

        proceedPayBtn.addEventListener(
            "click",
            function () {

                if (!validatePayment()) {

                    return;

                }

                startPayment();

            }
        );

    }


    /* =====================================================
       PAYMENT PROCESS
       ===================================================== */

    function startPayment() {

        openPaymentModal();


        /*
         * Demo processing time.
         *
         * Replace this section with the
         * real payment gateway integration.
         */

        setTimeout(function () {

            closePaymentModal();

            showPaymentSuccess();

        }, 2200);

    }


    /* =====================================================
       SUCCESS
       ===================================================== */

    function showPaymentSuccess() {

        const transactionId =
            generateTransactionId();

        const paymentDate =
            formatDate(
                new Date()
            );

        const startDate =
            formatDate(
                new Date()
            );

        const expiryDate =
            calculateExpiryDate(
                packageData.validity
            );


        const transactionElement =
            document.getElementById(
                "transactionId"
            );

        const receiptTransaction =
            document.getElementById(
                "receiptTransaction"
            );

        const paymentDateElement =
            document.getElementById(
                "paymentDate"
            );

        const successStartDate =
            document.getElementById(
                "successStartDate"
            );

        const successExpiryDate =
            document.getElementById(
                "successExpiryDate"
            );

        const successAmount =
            document.getElementById(
                "successAmount"
            );


        if (transactionElement) {

            transactionElement.textContent =
                transactionId;

        }


        if (receiptTransaction) {

            receiptTransaction.textContent =
                transactionId;

        }


        if (paymentDateElement) {

            paymentDateElement.textContent =
                paymentDate;

        }


        if (successStartDate) {

            successStartDate.textContent =
                startDate;

        }


        if (successExpiryDate) {

            successExpiryDate.textContent =
                expiryDate;

        }


        if (successAmount) {

            successAmount.textContent =
                formatPrice(
                    packageData.price +
                    packageData.tax
                );

        }


        if (paymentStatusCard) {

            paymentStatusCard.style.display =
                "none";

        }


        if (retryCard) {

            retryCard.classList.remove(
                "active"
            );

        }


        if (paymentSuccessCard) {

            paymentSuccessCard.classList.add(
                "active"
            );

        }


        showToast(
            "Payment successful. Your package has been activated."
        );

    }


    /* =====================================================
       TRANSACTION ID
       ===================================================== */

    function generateTransactionId() {

        const now =
            new Date();

        const timestamp =
            now.getTime()
                .toString()
                .slice(-8);

        return "PLTXN" + timestamp;

    }


    /* =====================================================
       DATE
       ===================================================== */

    function formatDate(date) {

        return date.toLocaleDateString(
            "en-IN",
            {
                day: "2-digit",
                month: "long",
                year: "numeric"
            }
        );

    }


    function calculateExpiryDate(days) {

        const date =
            new Date();

        date.setDate(
            date.getDate() + days
        );

        return formatDate(date);

    }


    /* =====================================================
       RETRY
       ===================================================== */

    if (retryPaymentBtn) {

        retryPaymentBtn.addEventListener(
            "click",
            function () {

                startPayment();

            }
        );

    }


    /* =====================================================
       ACTIVE PACKAGE
       ===================================================== */

    if (activePackageBtn) {

        activePackageBtn.addEventListener(
            "click",
            function () {

                window.location.href =
                    "matrimony-packages.php";

            }
        );

    }


    /* =====================================================
       RECEIPT
       ===================================================== */

    if (receiptBtn) {

        receiptBtn.addEventListener(
            "click",
            function () {

                openReceiptModal();

            }
        );

    }


    if (closeReceipt) {

        closeReceipt.addEventListener(
            "click",
            function () {

                closeReceiptModal();

            }
        );

    }


    if (receiptModalOverlay) {

        receiptModalOverlay.addEventListener(
            "click",
            function () {

                closeReceiptModal();

            }
        );

    }


    /* =====================================================
       RECEIPT DOWNLOAD
       ===================================================== */

    if (downloadReceiptBtn) {

        downloadReceiptBtn.addEventListener(
            "click",
            function () {

                showToast(
                    "Receipt download will be connected to the final payment system."
                );

            }
        );

    }


    /* =====================================================
       SUPPORT
       ===================================================== */

    if (supportBtn) {

        supportBtn.addEventListener(
            "click",
            function () {

                openSupportModal();

            }
        );

    }


    if (closeSupport) {

        closeSupport.addEventListener(
            "click",
            function () {

                closeSupportModal();

            }
        );

    }


    if (supportModalOverlay) {

        supportModalOverlay.addEventListener(
            "click",
            function () {

                closeSupportModal();

            }
        );

    }


    /* =====================================================
       TOAST
       ===================================================== */

    function showToast(message) {

        const existing =
            document.querySelector(
                ".pl-pp-toast"
            );

        if (existing) {

            existing.remove();

        }


        const toast =
            document.createElement(
                "div"
            );

        toast.className =
            "pl-pp-toast";


        toast.innerHTML = `

            <i class="bi bi-info-circle-fill"></i>

            <span>
                ${message}
            </span>

        `;


        document.body.appendChild(
            toast
        );


        requestAnimationFrame(
            function () {

                toast.classList.add(
                    "show"
                );

            }
        );


        setTimeout(
            function () {

                toast.classList.remove(
                    "show"
                );

                setTimeout(
                    function () {

                        toast.remove();

                    },
                    250
                );

            },
            3500
        );

    }


    /* =====================================================
       TOAST CSS
       ===================================================== */

    const toastStyle =
        document.createElement(
            "style"
        );

    toastStyle.textContent = `

        .pl-pp-toast {

            position: fixed;

            right: 22px;
            bottom: 22px;

            z-index: 10001;

            display: flex;

            align-items: center;

            gap: 8px;

            max-width: 380px;

            padding: 13px 17px;

            border-radius: 12px;

            background: #073b70;

            color: #fff;

            box-shadow:
                0 12px 30px rgba(0,0,0,.18);

            font-size: 12px;

            font-weight: 600;

            opacity: 0;

            transform:
                translateY(15px);

            transition: .25s ease;

        }

        .pl-pp-toast.show {

            opacity: 1;

            transform:
                translateY(0);

        }

        .pl-pp-toast i {

            color: #42b72a;

            font-size: 16px;

        }

        @media(max-width:600px) {

            .pl-pp-toast {

                left: 15px;
                right: 15px;

                bottom: 15px;

                max-width: none;

            }

        }

    `;

    document.head.appendChild(
        toastStyle
    );


    /* =====================================================
       ESC KEY
       ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (
                event.key === "Escape"
            ) {

                closePaymentModal();

                closeReceiptModal();

                closeSupportModal();

            }

        }
    );


    /* =====================================================
       INITIALIZE
       ===================================================== */

    updatePackageDisplay();

});