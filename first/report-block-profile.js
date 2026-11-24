document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       ELEMENTS
    ===================================================== */

    const reportForm = document.getElementById("plReportForm");
    const reportReason = document.getElementById("reportReason");
    const reportRemarks = document.getElementById("reportRemarks");
    const remarksCount = document.getElementById("remarksCount");

    const reportSuccess = document.getElementById("reportSuccess");
    const reportStatus = document.getElementById("reportStatus");

    const blockProfileBtn = document.getElementById("blockProfileBtn");
    const unblockProfileBtn = document.getElementById("unblockProfileBtn");

    const blockedState = document.getElementById("blockedState");
    const blockStatus = document.getElementById("blockStatus");

    const blockModal = document.getElementById("blockModal");
    const closeBlockModal = document.getElementById("closeBlockModal");
    const cancelBlock = document.getElementById("cancelBlock");
    const confirmBlock = document.getElementById("confirmBlock");

    const toast = document.getElementById("rbToast");
    const toastMessage = document.getElementById("rbToastMessage");


    /* =====================================================
       DEMO STORAGE
    ===================================================== */

    const STORAGE_KEY = "peoplelink_report_block_PLM10245";

    let savedState = localStorage.getItem(STORAGE_KEY);

    let state = {
        reported: false,
        blocked: false
    };

    if (savedState) {
        try {
            state = JSON.parse(savedState);
        } catch (error) {
            console.warn("Unable to read saved report/block state.");
        }
    }


    /* =====================================================
       TOAST
    ===================================================== */

    function showToast(message) {

        if (!toast || !toastMessage) {
            return;
        }

        toastMessage.textContent = message;

        toast.classList.add("show");

        clearTimeout(window.peopleLinkToastTimer);

        window.peopleLinkToastTimer = setTimeout(function () {
            toast.classList.remove("show");
        }, 3000);
    }


    /* =====================================================
       SAVE STATE
    ===================================================== */

    function saveState() {
        localStorage.setItem(
            STORAGE_KEY,
            JSON.stringify(state)
        );
    }


    /* =====================================================
       REPORT STATUS
    ===================================================== */

    function updateReportUI() {

        if (!reportStatus) {
            return;
        }

        if (state.reported) {

            reportStatus.classList.add("reported");

            reportStatus.innerHTML = `
                <span class="pl-rb-status-dot"></span>
                Submitted for Review
            `;

            if (reportSuccess) {
                reportSuccess.hidden = false;
            }

        } else {

            reportStatus.classList.remove("reported");

            reportStatus.innerHTML = `
                <span class="pl-rb-status-dot"></span>
                No Report Submitted
            `;

            if (reportSuccess) {
                reportSuccess.hidden = true;
            }

        }
    }


    /* =====================================================
       BLOCK STATUS
    ===================================================== */

    function updateBlockUI() {

        if (!blockStatus) {
            return;
        }

        if (state.blocked) {

            blockStatus.classList.add("blocked");

            blockStatus.innerHTML = `
                <span class="pl-rb-status-dot"></span>
                Profile Blocked
            `;

            if (blockedState) {
                blockedState.hidden = false;
            }

            if (blockProfileBtn) {
                blockProfileBtn.closest(".pl-rb-block-content").style.display = "none";
            }

        } else {

            blockStatus.classList.remove("blocked");

            blockStatus.innerHTML = `
                <span class="pl-rb-status-dot"></span>
                Profile Not Blocked
            `;

            if (blockedState) {
                blockedState.hidden = true;
            }

            if (blockProfileBtn) {
                blockProfileBtn.closest(".pl-rb-block-content").style.display = "";
            }

        }
    }


    /* =====================================================
       REMARKS COUNTER
    ===================================================== */

    if (reportRemarks && remarksCount) {

        reportRemarks.addEventListener("input", function () {

            remarksCount.textContent =
                reportRemarks.value.length;

        });

    }


    /* =====================================================
       REPORT SUBMIT
    ===================================================== */

    if (reportForm) {

        reportForm.addEventListener("submit", function (event) {

            event.preventDefault();

            if (!reportReason.value) {

                reportReason.focus();

                showToast("Please select a report reason.");

                return;
            }


            state.reported = true;

            saveState();

            updateReportUI();

            reportForm.reset();

            if (remarksCount) {
                remarksCount.textContent = "0";
            }

            showToast(
                "Your report has been submitted for review."
            );

        });

    }


    /* =====================================================
       OPEN BLOCK MODAL
    ===================================================== */

    function openBlockModal() {

        if (!blockModal) {
            return;
        }

        blockModal.classList.add("active");

        blockModal.setAttribute(
            "aria-hidden",
            "false"
        );

        document.body.style.overflow = "hidden";
    }


    /* =====================================================
       CLOSE BLOCK MODAL
    ===================================================== */

    function closeModal() {

        if (!blockModal) {
            return;
        }

        blockModal.classList.remove("active");

        blockModal.setAttribute(
            "aria-hidden",
            "true"
        );

        document.body.style.overflow = "";
    }


    if (blockProfileBtn) {

        blockProfileBtn.addEventListener(
            "click",
            openBlockModal
        );

    }


    if (closeBlockModal) {

        closeBlockModal.addEventListener(
            "click",
            closeModal
        );

    }


    if (cancelBlock) {

        cancelBlock.addEventListener(
            "click",
            closeModal
        );

    }


    /* =====================================================
       MODAL OVERLAY
    ===================================================== */

    if (blockModal) {

        const overlay =
            blockModal.querySelector(
                ".pl-rb-modal-overlay"
            );

        if (overlay) {

            overlay.addEventListener(
                "click",
                closeModal
            );

        }

    }


    /* =====================================================
       CONFIRM BLOCK
    ===================================================== */

    if (confirmBlock) {

        confirmBlock.addEventListener(
            "click",
            function () {

                state.blocked = true;

                saveState();

                updateBlockUI();

                closeModal();

                showToast(
                    "Profile has been blocked."
                );

            }
        );

    }


    /* =====================================================
       UNBLOCK
    ===================================================== */

    if (unblockProfileBtn) {

        unblockProfileBtn.addEventListener(
            "click",
            function () {

                state.blocked = false;

                saveState();

                updateBlockUI();

                showToast(
                    "Profile has been unblocked."
                );

            }
        );

    }


    /* =====================================================
       ESCAPE KEY
    ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (
                event.key === "Escape" &&
                blockModal &&
                blockModal.classList.contains("active")
            ) {
                closeModal();
            }

        }
    );


    /* =====================================================
       INITIAL UI
    ===================================================== */

    updateReportUI();
    updateBlockUI();

});