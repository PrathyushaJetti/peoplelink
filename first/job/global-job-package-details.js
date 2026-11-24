/* =====================================================
   PAGE 45 — GLOBAL JOB PACKAGE DETAILS
===================================================== */

document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    const $ = (id) => document.getElementById(id);

    // Update copyright year.
    if ($("p45Year")) {
        $("p45Year").textContent = new Date().getFullYear();
    }

    // Package information.
    const packages = {
        basic: {
            name: "Basic Global Package",
            label: "GET STARTED",
            description:
                "A practical choice for employers with occasional global hiring needs.",
            price: 999,
            posts: 5,
            validity: 30,
            icon: "fa-briefcase",
            benefits: [
                "Post jobs across all PeopleLink communities",
                "Wider candidate reach",
                "Global job visibility",
                "Standard job visibility",
                "Application tracking",
                "Renewal option available"
            ]
        },

        premium: {
            name: "Premium Global Package",
            label: "GROW YOUR TEAM",
            description:
                "Suitable for businesses hiring across multiple PeopleLink communities.",
            price: 2999,
            posts: 25,
            validity: 90,
            icon: "fa-crown",
            benefits: [
                "Post jobs across all PeopleLink communities",
                "Wider candidate reach",
                "Global job visibility",
                "Enhanced visibility",
                "Application tracking",
                "Priority support",
                "Renewal and upgrade options"
            ]
        },

        featured: {
            name: "Featured Global Package",
            label: "MAXIMUM EXPOSURE",
            description:
                "Designed for employers who want increased exposure and priority job placement.",
            price: 5999,
            posts: 50,
            validity: 180,
            icon: "fa-bullhorn",
            benefits: [
                "Post jobs across all PeopleLink communities",
                "Wider candidate reach",
                "Global job visibility",
                "Priority placement",
                "Featured job tag",
                "Enhanced network visibility",
                "Renewal and upgrade options"
            ]
        }
    };

    const params = new URLSearchParams(window.location.search);

    const requestedPackage = params.get("package") || "premium";
    const mode = params.get("mode") || "purchase";

    let selectedPackage =
        packages[requestedPackage] || packages.premium;

    // Formatting helpers.
    const formatINR = (amount) =>
        new Intl.NumberFormat("en-IN", {
            style: "currency",
            currency: "INR",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount);

    const formatDate = (date) =>
        date.toLocaleDateString("en-IN", {
            day: "2-digit",
            month: "short",
            year: "numeric"
        });

    // Update package information.
    function renderPackage(pkg) {
        $("p45PackageName").textContent = pkg.name;
        $("p45PackageLabel").textContent = pkg.label;
        $("p45PackageDescription").textContent = pkg.description;
        $("p45PackagePrice").textContent = formatINR(pkg.price);
        $("p45PackagePosts").textContent = pkg.posts;
        $("p45PackageValidity").textContent =
            pkg.validity + " days";

        $("p45PackageIcon").innerHTML =
            '<i class="fa-solid ' + pkg.icon + '"></i>';

        $("p45SummaryIcon").className =
            "fa-solid " + pkg.icon;

        $("p45SummaryName").textContent = pkg.name;
        $("p45SummaryPosts").textContent =
            pkg.posts + " global job posts";

        const benefits = $("p45Benefits");
        benefits.replaceChildren();

        pkg.benefits.forEach(function (benefit) {
            const li = document.createElement("li");
            const icon = document.createElement("i");
            const text = document.createElement("span");

            icon.className = "fa-solid fa-circle-check";
            text.textContent = benefit;

            li.append(icon, text);
            benefits.appendChild(li);
        });

        renderSummary();
    }

    // Payment summary.
    // Replace these sample charge values with your server-side
    // tax and billing calculations before accepting real payments.
    const charges = {
        additional: 0,
        tax: 0
    };

    function renderSummary() {
        const subtotal =
            selectedPackage.price + charges.additional;

        const total = subtotal + charges.tax;

        $("p45SummaryAmount").textContent =
            formatINR(selectedPackage.price);

        $("p45SummaryCharges").textContent =
            formatINR(charges.additional);

        $("p45SummaryTax").textContent =
            formatINR(charges.tax);

        $("p45SummaryTotal").textContent =
            formatINR(total);
    }

    // Example current subscription data.
    // Replace this with the authenticated user's database record.
    const currentPackage = {
        name: "Premium Global Package",
        used: 8,
        total: 25,
        expiry: "31 Dec 2026"
    };

    function renderCurrentUsage() {
        $("p45CurrentName").textContent =
            currentPackage.name;

        $("p45Used").textContent =
            currentPackage.used;

        $("p45Remaining").textContent =
            Math.max(
                0,
                currentPackage.total - currentPackage.used
            );

        $("p45Expiry").textContent =
            currentPackage.expiry;
    }

    // Handle details, renewal and upgrade URLs.
    if (mode === "details") {
        document.title = "Package Details | PeopleLink";
    } else if (mode === "renew") {
        $("p45PackageLabel").textContent =
            "PACKAGE RENEWAL";
    } else if (mode === "upgrade") {
        $("p45PackageLabel").textContent =
            "PACKAGE UPGRADE";
    }

    renderPackage(selectedPackage);
    renderCurrentUsage();

    // Checkout form.
    const checkoutForm = $("p45CheckoutForm");

    checkoutForm.addEventListener("submit", function (event) {
        event.preventDefault();

        if (!checkoutForm.reportValidity()) {
            return;
        }

        const employer = {
            name: $("p45Name").value.trim(),
            company: $("p45Company").value.trim(),
            mobile: $("p45Mobile").value.trim(),
            email: $("p45Email").value.trim()
        };

        const paymentMethod = checkoutForm.querySelector(
            'input[name="paymentMethod"]:checked'
        );

        if (!paymentMethod) {
            alert("Please select a payment method.");
            return;
        }

        if (!$("p45Terms").checked) {
            alert("Please accept the applicable terms.");
            return;
        }

        /*
         * PAYMENT GATEWAY INTEGRATION REQUIRED
         *
         * Send the selected package ID and employer details
         * to your backend over HTTPS.
         *
         * The backend must:
         * 1. Authenticate the employer.
         * 2. Verify package price and calculate taxes.
         * 3. Create a payment order with your gateway.
         * 4. Return the gateway checkout details.
         *
         * Never trust a price supplied by the browser.
         * Never activate a package based only on a client-side
         * success message or redirect.
         *
         * The success section must only be shown after your
         * backend verifies the payment with the gateway.
         */

        console.log("Checkout details validated:", {
            packageId: requestedPackage,
            mode: mode,
            paymentMethod: paymentMethod.value,
            employer: employer
        });

        alert(
            "Your details are valid. The payment gateway is not " +
            "connected yet. Configure your backend and payment " +
            "provider before accepting purchases."
        );
    });

    /*
     * Call this function from your verified payment-success
     * flow after the backend confirms payment and activates
     * the package. Do not call it directly from a button click.
     */
    window.showVerifiedPackageSuccess = function (receipt) {
        if (!receipt || receipt.verified !== true) {
            console.error("A verified payment receipt is required.");
            return;
        }

        const requiredFields = [
            "transactionId",
            "packageName",
            "amountPaid",
            "activationDate",
            "expiryDate",
            "postsAvailable"
        ];

        for (const field of requiredFields) {
            if (receipt[field] === undefined ||
                receipt[field] === null ||
                receipt[field] === "") {
                console.error("Missing receipt field:", field);
                return;
            }
        }

        $("p45TransactionId").textContent =
            receipt.transactionId;

        $("p45SuccessName").textContent =
            receipt.packageName;

        $("p45SuccessAmount").textContent =
            formatINR(Number(receipt.amountPaid));

        $("p45ActivationDate").textContent =
            receipt.activationDate;

        $("p45SuccessExpiry").textContent =
            receipt.expiryDate;

        $("p45SuccessPosts").textContent =
            receipt.postsAvailable;

        $("p45SuccessNotice").hidden = true;
        $("p45Success").hidden = false;

        $("p45Success").scrollIntoView({
            behavior: "smooth",
            block: "start"
        });
    };
});