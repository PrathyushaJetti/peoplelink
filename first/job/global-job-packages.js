/* =====================================================
   PEOPLELINK PAGE 44: GLOBAL JOB PACKAGES
   File: global-job-packages.js
===================================================== */

document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    // -----------------------------------------------
    // ELEMENTS
    // -----------------------------------------------

    const currentPackage = document.getElementById("gjpCurrentPackage");

    const totalElement = document.getElementById("gjpTotalPosts");
    const usedElement = document.getElementById("gjpUsedPosts");
    const remainingElement = document.getElementById("gjpRemainingPosts");

    const percentageElement = document.getElementById("gjpUsagePercentage");
    const progressTrack = document.getElementById("gjpProgressTrack");
    const progressFill = document.getElementById("gjpProgressFill");

    const expiryElement = document.getElementById("gjpExpiryDate");

    // -----------------------------------------------
    // UPDATE PACKAGE USAGE
    // -----------------------------------------------

    function updatePackageUsage() {
        if (
            !totalElement ||
            !usedElement ||
            !remainingElement ||
            !percentageElement ||
            !progressTrack ||
            !progressFill
        ) {
            return;
        }

        const total = Math.max(
            0,
            Number(totalElement.textContent.trim()) || 0
        );

        const used = Math.min(
            total,
            Math.max(0, Number(usedElement.textContent.trim()) || 0)
        );

        const remaining = Math.max(0, total - used);

        const percentage = total > 0
            ? Math.round((used / total) * 100)
            : 0;

        remainingElement.textContent = remaining;
        percentageElement.textContent = percentage + "% used";

        progressFill.style.width = percentage + "%";

        progressTrack.setAttribute("aria-valuemin", "0");
        progressTrack.setAttribute("aria-valuemax", String(total));
        progressTrack.setAttribute("aria-valuenow", String(used));

        progressTrack.setAttribute(
            "aria-valuetext",
            used + " of " + total + " job posts used"
        );
    }

    updatePackageUsage();

    // -----------------------------------------------
    // CHECK PACKAGE EXPIRY
    // Uses the expiry date displayed in the HTML.
    // Date format expected: DD MMM YYYY.
    // -----------------------------------------------

    function checkPackageExpiry() {
        if (!currentPackage || !expiryElement) {
            return;
        }

        const expiryText = expiryElement.textContent.trim();

        const match = expiryText.match(
            /^(\d{1,2})\s+([A-Za-z]{3})\s+(\d{4})$/
        );

        if (!match) {
            return;
        }

        const day = Number(match[1]);
        const monthNames = [
            "Jan", "Feb", "Mar", "Apr",
            "May", "Jun", "Jul", "Aug",
            "Sep", "Oct", "Nov", "Dec"
        ];

        const month = monthNames.indexOf(
            match[2].charAt(0).toUpperCase() +
            match[2].slice(1).toLowerCase()
        );

        const year = Number(match[3]);

        if (month === -1) {
            return;
        }

        // Compare calendar dates rather than time of day.
        const expiryDate = new Date(Date.UTC(year, month, day));
        const now = new Date();

        const today = new Date(Date.UTC(
            now.getFullYear(),
            now.getMonth(),
            now.getDate()
        ));

        if (expiryDate < today) {
            const badge = document.querySelector(".gjp-active-badge");

            if (badge) {
                badge.innerHTML =
                    '<i class="fa-solid fa-circle-exclamation"></i> ' +
                    "Package Expired";

                badge.style.color = "#a52d2d";
                badge.style.background = "#fff0f0";
                badge.style.borderColor = "#f3caca";
            }
        }
    }

    checkPackageExpiry();

    // -----------------------------------------------
    // PACKAGE LINKS
    // Read package selection from the URL on Page 45.
    // -----------------------------------------------

    const packageLinks = document.querySelectorAll(
        '.gjp-package-card a[href*="package="]'
    );

    packageLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            const url = new URL(link.href, window.location.href);

            const packageName = url.searchParams.get("package");

            const allowedPackages = [
                "basic",
                "premium",
                "featured"
            ];

            if (!allowedPackages.includes(packageName)) {
                event.preventDefault();
                console.error("Invalid global job package selection.");
            }
        });
    });

    // -----------------------------------------------
    // BACK TO TOP
    // Kept here as a fallback if the HTML inline
    // script is removed in the future.
    // -----------------------------------------------

    const backToTop = document.getElementById("plBackToTop");

    if (backToTop && !backToTop.dataset.gjpInitialized) {
        backToTop.dataset.gjpInitialized = "true";

        backToTop.addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    }

});