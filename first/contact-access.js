document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       PEOPLELINK - CONTACT ACCESS
       Frontend / demo implementation
       ===================================================== */


    /* =====================================================
       ELEMENTS
       ===================================================== */

    const requestContactBtn =
        document.getElementById(
            "requestContactBtn"
        );

    const requestModal =
        document.getElementById(
            "requestModal"
        );

    const requestOverlay =
        document.getElementById(
            "requestOverlay"
        );

    const closeRequestModal =
        document.getElementById(
            "closeRequestModal"
        );

    const cancelRequest =
        document.getElementById(
            "cancelRequest"
        );

    const confirmRequest =
        document.getElementById(
            "confirmRequest"
        );


    const requestStatus =
        document.getElementById(
            "requestStatus"
        );

    const requestStatusMessage =
        document.getElementById(
            "requestStatusMessage"
        );

    const requestStatusIcon =
        document.getElementById(
            "requestStatusIcon"
        );

    const requestStatusDate =
        document.getElementById(
            "requestStatusDate"
        );


    const accessStatusTitle =
        document.getElementById(
            "accessStatusTitle"
        );

    const accessStatusText =
        document.getElementById(
            "accessStatusText"
        );

    const accessStatusPill =
        document.getElementById(
            "accessStatusPill"
        );


    const viewContactBtn =
        document.getElementById(
            "viewContactBtn"
        );

    const contactDetails =
        document.getElementById(
            "contactDetails"
        );


    const packageRequired =
        document.getElementById(
            "packageRequired"
        );


    const reportMisuseBtn =
        document.getElementById(
            "reportMisuseBtn"
        );

    const reportModal =
        document.getElementById(
            "reportModal"
        );

    const reportOverlay =
        document.getElementById(
            "reportOverlay"
        );

    const closeReportModal =
        document.getElementById(
            "closeReportModal"
        );

    const submitReport =
        document.getElementById(
            "submitReport"
        );


    /* =====================================================
       INITIAL STATE
       ===================================================== */

    let contactRequestStatus =
        "not_sent";

    let contactApproved =
        false;


    /* =====================================================
       MODAL HELPERS
       ===================================================== */

    function openModal(modal) {

        if (!modal) return;

        modal.classList.add(
            "active"
        );

        document.body.style.overflow =
            "hidden";

    }


    function closeModal(modal) {

        if (!modal) return;

        modal.classList.remove(
            "active"
        );

        document.body.style.overflow =
            "";

    }


    /* =====================================================
       REQUEST CONTACT
       ===================================================== */

    if (requestContactBtn) {

        requestContactBtn.addEventListener(
            "click",
            function () {

                if (
                    contactRequestStatus ===
                    "pending"
                ) {

                    showToast(
                        "Your contact request is already pending."
                    );

                    return;

                }


                if (
                    contactRequestStatus ===
                    "approved"
                ) {

                    showToast(
                        "Contact access has already been approved."
                    );

                    return;

                }


                openModal(
                    requestModal
                );

            }
        );

    }


    /* =====================================================
       CLOSE REQUEST MODAL
       ===================================================== */

    if (closeRequestModal) {

        closeRequestModal.addEventListener(
            "click",
            function () {

                closeModal(
                    requestModal
                );

            }
        );

    }


    if (cancelRequest) {

        cancelRequest.addEventListener(
            "click",
            function () {

                closeModal(
                    requestModal
                );

            }
        );

    }


    if (requestOverlay) {

        requestOverlay.addEventListener(
            "click",
            function () {

                closeModal(
                    requestModal
                );

            }
        );

    }


    /* =====================================================
       CONFIRM REQUEST
       ===================================================== */

    if (confirmRequest) {

        confirmRequest.addEventListener(
            "click",
            function () {

                contactRequestStatus =
                    "pending";


                closeModal(
                    requestModal
                );


                updateRequestStatus(
                    "pending"
                );


                showToast(
                    "Contact request sent successfully."
                );

            }
        );

    }


    /* =====================================================
       UPDATE REQUEST STATUS
       ===================================================== */

    function updateRequestStatus(status) {

        if (!requestStatus) return;


        requestStatus.className = "";


        if (status === "pending") {

            requestStatus.textContent =
                "Pending";

            requestStatus.classList.add(
                "pending"
            );


            if (requestStatusIcon) {

                requestStatusIcon.innerHTML =
                    `<i class="bi bi-hourglass-split"></i>`;

            }


            if (requestStatusDate) {

                requestStatusDate.textContent =
                    "Request sent today";

            }


            if (requestStatusMessage) {

                requestStatusMessage.textContent =
                    "Your request is waiting for approval from the profile owner.";

            }


            if (accessStatusTitle) {

                accessStatusTitle.textContent =
                    "Contact Request Pending";

            }


            if (accessStatusText) {

                accessStatusText.textContent =
                    "Your request has been sent. Contact details will remain protected until access is approved.";

            }


            if (accessStatusPill) {

                accessStatusPill.textContent =
                    "Pending";

                accessStatusPill.className =
                    "pl-ca-status-pill pending";

            }

        }


        if (status === "approved") {

            requestStatus.textContent =
                "Approved";

            requestStatus.classList.add(
                "approved"
            );


            if (requestStatusIcon) {

                requestStatusIcon.innerHTML =
                    `<i class="bi bi-check-circle-fill"></i>`;

            }


            if (requestStatusDate) {

                requestStatusDate.textContent =
                    "Request approved";

            }


            if (requestStatusMessage) {

                requestStatusMessage.textContent =
                    "Contact access has been approved. Permitted contact information can now be viewed.";

            }


            if (accessStatusTitle) {

                accessStatusTitle.textContent =
                    "Contact Access Approved";

            }


            if (accessStatusText) {

                accessStatusText.textContent =
                    "The profile owner has approved your contact request.";

            }


            if (accessStatusPill) {

                accessStatusPill.textContent =
                    "Approved";

                accessStatusPill.className =
                    "pl-ca-status-pill approved";

            }

        }


        if (status === "declined") {

            requestStatus.textContent =
                "Declined";

            requestStatus.classList.add(
                "declined"
            );


            if (requestStatusIcon) {

                requestStatusIcon.innerHTML =
                    `<i class="bi bi-x-circle-fill"></i>`;

            }


            if (requestStatusDate) {

                requestStatusDate.textContent =
                    "Request declined";

            }


            if (requestStatusMessage) {

                requestStatusMessage.textContent =
                    "The profile owner has declined this contact request.";

            }


            if (accessStatusTitle) {

                accessStatusTitle.textContent =
                    "Contact Request Declined";

            }


            if (accessStatusText) {

                accessStatusText.textContent =
                    "Contact details remain protected because access was not approved.";

            }


            if (accessStatusPill) {

                accessStatusPill.textContent =
                    "Declined";

                accessStatusPill.className =
                    "pl-ca-status-pill declined";

            }

        }

    }


    /* =====================================================
       DEMO APPROVAL
       ===================================================== */

    /*
     * Demo only.
     *
     * In production the receiving profile owner would approve
     * or decline from their Received Interests / Contact Requests
     * section and the status would come from the database.
     *
     * This demo automatically approves after a delay so the
     * complete UI flow can be tested.
     */

    function demoApproval() {

        if (
            contactRequestStatus !==
            "pending"
        ) {

            return;

        }


        contactRequestStatus =
            "approved";

        contactApproved =
            true;


        updateRequestStatus(
            "approved"
        );


        showToast(
            "Contact request approved. Contact access is now available."
        );

    }


    /* =====================================================
       VIEW CONTACT
       ===================================================== */

    if (viewContactBtn) {

        viewContactBtn.addEventListener(
            "click",
            function () {

                if (!contactApproved) {

                    showToast(
                        "Contact access has not been approved yet."
                    );

                    return;

                }


                if (packageRequired) {

                    packageRequired.style.display =
                        "none";

                }


                if (contactDetails) {

                    contactDetails.style.display =
                        "grid";

                }


                showToast(
                    "Permitted contact details are now visible."
                );

            }
        );

    }


    /* =====================================================
       REPORT MODAL
       ===================================================== */

    if (reportMisuseBtn) {

        reportMisuseBtn.addEventListener(
            "click",
            function () {

                openModal(
                    reportModal
                );

            }
        );

    }


    if (closeReportModal) {

        closeReportModal.addEventListener(
            "click",
            function () {

                closeModal(
                    reportModal
                );

            }
        );

    }


    if (reportOverlay) {

        reportOverlay.addEventListener(
            "click",
            function () {

                closeModal(
                    reportModal
                );

            }
        );

    }


    /* =====================================================
       SUBMIT REPORT
       ===================================================== */

    if (submitReport) {

        submitReport.addEventListener(
            "click",
            function () {

                const selectedReason =
                    document.querySelector(
                        'input[name="report_reason"]:checked'
                    );


                if (!selectedReason) {

                    showToast(
                        "Please select a reason for the report."
                    );

                    return;

                }


                closeModal(
                    reportModal
                );


                showToast(
                    "Your report has been submitted for review."
                );


                const reportDescription =
                    document.getElementById(
                        "reportDescription"
                    );

                if (reportDescription) {

                    reportDescription.value =
                        "";

                }


                const radios =
                    document.querySelectorAll(
                        'input[name="report_reason"]'
                    );

                radios.forEach(
                    function (radio) {

                        radio.checked =
                            false;

                    }
                );

            }
        );

    }


    /* =====================================================
       TOAST
       ===================================================== */

    function showToast(message) {

        const existing =
            document.querySelector(
                ".pl-ca-toast"
            );

        if (existing) {

            existing.remove();

        }


        const toast =
            document.createElement(
                "div"
            );

        toast.className =
            "pl-ca-toast";


        toast.innerHTML = `

            <i class="bi bi-check-circle-fill"></i>

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
            3200
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

        .pl-ca-toast {

            position: fixed;

            right: 22px;
            bottom: 22px;

            z-index: 10001;

            display: flex;

            align-items: center;

            gap: 8px;

            max-width: 390px;

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

        .pl-ca-toast.show {

            opacity: 1;

            transform:
                translateY(0);

        }

        .pl-ca-toast i {

            color: #42b72a;

            font-size: 16px;

        }

        @media(max-width:600px) {

            .pl-ca-toast {

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
       ESCAPE
       ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (
                event.key === "Escape"
            ) {

                closeModal(
                    requestModal
                );

                closeModal(
                    reportModal
                );

            }

        }
    );


    /* =====================================================
       INITIAL CONTACT DETAILS
       ===================================================== */

    if (contactDetails) {

        contactDetails.style.display =
            "none";

    }


    /* =====================================================
       INITIALIZE
       ===================================================== */

});