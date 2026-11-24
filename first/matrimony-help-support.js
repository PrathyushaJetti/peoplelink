document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       ELEMENTS
    ====================================================== */

    const supportForm =
        document.getElementById(
            "supportRequestForm"
        );

    const description =
        document.getElementById(
            "supportDescription"
        );

    const descriptionCount =
        document.getElementById(
            "descriptionCount"
        );

    const supportFile =
        document.getElementById(
            "supportFile"
        );

    const chooseFileBtn =
        document.getElementById(
            "chooseFileBtn"
        );

    const selectedFileName =
        document.getElementById(
            "selectedFileName"
        );

    const submitSupportBtn =
        document.getElementById(
            "submitSupportBtn"
        );

    const supportSuccess =
        document.getElementById(
            "supportSuccess"
        );

    const generatedTicketId =
        document.getElementById(
            "generatedTicketId"
        );

    const focusSupportForm =
        document.getElementById(
            "focusSupportForm"
        );


    /* =====================================================
       FAQ
    ====================================================== */

    const faqItems =
        document.querySelectorAll(
            ".pl-faq-item"
        );


    /* =====================================================
       TICKET MODAL
    ====================================================== */

    const ticketModal =
        document.getElementById(
            "ticketModal"
        );

    const ticketModalClose =
        document.getElementById(
            "ticketModalClose"
        );

    const ticketModalCloseBtn =
        document.getElementById(
            "ticketModalCloseBtn"
        );

    const ticketModalTitle =
        document.getElementById(
            "ticketModalTitle"
        );

    const modalTicketId =
        document.getElementById(
            "modalTicketId"
        );

    const modalTicketStatus =
        document.getElementById(
            "modalTicketStatus"
        );

    const modalTicketDate =
        document.getElementById(
            "modalTicketDate"
        );

    const modalTicketCategory =
        document.getElementById(
            "modalTicketCategory"
        );

    const modalTicketDescription =
        document.getElementById(
            "modalTicketDescription"
        );


    /* =====================================================
       TOAST
    ====================================================== */

    const helpToast =
        document.getElementById(
            "helpToast"
        );

    const helpToastMessage =
        document.getElementById(
            "helpToastMessage"
        );

    let toastTimer;


    /* =====================================================
       DEMO TICKET DATA
    ====================================================== */

    const tickets = {

        "PLM-SUP-10245": {

            title:
                "Package payment confirmation issue",

            status:
                "Open",

            date:
                "08 Oct 2026",

            category:
                "Package / Payment Issue",

            description:
                "Your support request has been received and is currently awaiting review by the support team."

        },


        "PLM-SUP-10198": {

            title:
                "Profile approval clarification",

            status:
                "In Progress",

            date:
                "05 Oct 2026",

            category:
                "Profile Approval",

            description:
                "The support team is reviewing your profile approval query and may request additional information if required."

        },


        "PLM-SUP-10074": {

            title:
                "Photo approval assistance",

            status:
                "Resolved",

            date:
                "27 Sep 2026",

            category:
                "Photo Approval",

            description:
                "Your photo approval issue has been reviewed and the required action has been completed."

        },


        "PLM-SUP-09981": {

            title:
                "Search and match issue",

            status:
                "Closed",

            date:
                "19 Sep 2026",

            category:
                "Search / Match Issue",

            description:
                "The reported search issue was reviewed and the support request has now been closed."

        }

    };


    /* =====================================================
       TOAST
    ====================================================== */

    function showToast(message) {

        if (!helpToast) {
            return;
        }

        helpToastMessage.textContent =
            message;

        helpToast.classList.add(
            "show"
        );

        clearTimeout(toastTimer);

        toastTimer = setTimeout(
            function () {

                helpToast.classList.remove(
                    "show"
                );

            },
            2800
        );

    }


    /* =====================================================
       DESCRIPTION COUNTER
    ====================================================== */

    if (description) {

        description.addEventListener(
            "input",
            function () {

                if (descriptionCount) {

                    descriptionCount.textContent =
                        description.value.length;

                }

            }
        );

    }


    /* =====================================================
       FILE PICKER
    ====================================================== */

    if (chooseFileBtn && supportFile) {

        chooseFileBtn.addEventListener(
            "click",
            function () {

                supportFile.click();

            }
        );

    }


    /* =====================================================
       FILE CHANGE
    ====================================================== */

    if (supportFile) {

        supportFile.addEventListener(
            "change",
            function () {

                const file =
                    supportFile.files[0];


                if (!file) {

                    selectedFileName.hidden =
                        true;

                    selectedFileName.textContent =
                        "";

                    return;

                }


                const maxSize =
                    5 * 1024 * 1024;


                if (file.size > maxSize) {

                    supportFile.value =
                        "";

                    selectedFileName.hidden =
                        true;

                    showToast(
                        "File size must not exceed 5 MB."
                    );

                    return;

                }


                selectedFileName.textContent =
                    "Selected: " +
                    file.name;


                selectedFileName.hidden =
                    false;

            }
        );

    }


    /* =====================================================
       SUPPORT FORM
    ====================================================== */

    if (supportForm) {

        supportForm.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();


                if (!supportForm.checkValidity()) {

                    supportForm.reportValidity();

                    return;

                }


                if (
                    submitSupportBtn &&
                    submitSupportBtn.classList.contains(
                        "loading"
                    )
                ) {

                    return;

                }


                if (submitSupportBtn) {

                    submitSupportBtn.classList.add(
                        "loading"
                    );

                    submitSupportBtn.innerHTML = `
                        <i class="bi bi-arrow-repeat"></i>
                        Submitting...
                    `;

                }


                /*
                 * Demo submission delay.
                 * Replace this section with AJAX/fetch
                 * to your PHP support-submit endpoint.
                 */

                setTimeout(
                    function () {

                        const ticketNumber =
                            Math.floor(
                                10000 +
                                Math.random() * 89999
                            );


                        const ticketId =
                            "PLM-SUP-" +
                            ticketNumber;


                        if (generatedTicketId) {

                            generatedTicketId.textContent =
                                ticketId;

                        }


                        if (supportSuccess) {

                            supportSuccess.hidden =
                                false;

                        }


                        if (submitSupportBtn) {

                            submitSupportBtn.classList.remove(
                                "loading"
                            );

                            submitSupportBtn.innerHTML = `
                                <i class="bi bi-send"></i>
                                Submit Request
                            `;

                        }


                        showToast(
                            "Support request submitted successfully."
                        );


                        /*
                         * In the real application:
                         * 1. Insert support ticket into MySQL.
                         * 2. Generate permanent ticket ID.
                         * 3. Save attachment.
                         * 4. Send notification/email.
                         */


                    },
                    700
                );

            }
        );

    }


    /* =====================================================
       FAQ ACCORDION
    ====================================================== */

    faqItems.forEach(
        function (item) {

            const question =
                item.querySelector(
                    ".pl-faq-question"
                );


            if (!question) {
                return;
            }


            question.addEventListener(
                "click",
                function () {

                    const wasActive =
                        item.classList.contains(
                            "active"
                        );


                    faqItems.forEach(
                        function (faq) {

                            faq.classList.remove(
                                "active"
                            );

                        }
                    );


                    if (!wasActive) {

                        item.classList.add(
                            "active"
                        );

                    }

                }
            );

        }
    );


    /* =====================================================
       MODAL
    ====================================================== */

    function openTicketModal(ticketId) {

        if (!ticketModal) {
            return;
        }


        const ticket =
            tickets[ticketId];


        if (!ticket) {
            return;
        }


        ticketModalTitle.textContent =
            ticket.title;

        modalTicketId.textContent =
            ticketId;

        modalTicketStatus.textContent =
            ticket.status;

        modalTicketDate.textContent =
            ticket.date;

        modalTicketCategory.textContent =
            ticket.category;

        modalTicketDescription.textContent =
            ticket.description;


        ticketModal.classList.add(
            "active"
        );

        ticketModal.setAttribute(
            "aria-hidden",
            "false"
        );

        document.body.style.overflow =
            "hidden";

    }


    function closeTicketModal() {

        if (!ticketModal) {
            return;
        }


        ticketModal.classList.remove(
            "active"
        );

        ticketModal.setAttribute(
            "aria-hidden",
            "true"
        );

        document.body.style.overflow =
            "";

    }


    /* =====================================================
       VIEW REQUEST BUTTONS
    ====================================================== */

    document.querySelectorAll(
        ".pl-view-ticket-btn"
    ).forEach(
        function (button) {

            button.addEventListener(
                "click",
                function () {

                    openTicketModal(
                        button.dataset.ticket
                    );

                }
            );

        }
    );


    /* =====================================================
       MODAL CLOSE
    ====================================================== */

    if (ticketModalClose) {

        ticketModalClose.addEventListener(
            "click",
            closeTicketModal
        );

    }


    if (ticketModalCloseBtn) {

        ticketModalCloseBtn.addEventListener(
            "click",
            closeTicketModal
        );

    }


    if (ticketModal) {

        const overlay =
            ticketModal.querySelector(
                ".pl-help-modal-overlay"
            );


        if (overlay) {

            overlay.addEventListener(
                "click",
                closeTicketModal
            );

        }

    }


    /* =====================================================
       SUPPORT FORM QUICK LINK
    ====================================================== */

    if (focusSupportForm) {

        focusSupportForm.addEventListener(
            "click",
            function () {

                const formCard =
                    document.getElementById(
                        "supportRequestForm"
                    );


                if (formCard) {

                    formCard.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });


                    setTimeout(
                        function () {

                            const category =
                                document.getElementById(
                                    "issueCategory"
                                );

                            if (category) {
                                category.focus();
                            }

                        },
                        500
                    );

                }

            }
        );

    }


    /* =====================================================
       ESCAPE
    ====================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (event.key === "Escape") {

                closeTicketModal();

            }

        }
    );


    /* =====================================================
       INITIALIZE
    ====================================================== */

    if (description && descriptionCount) {

        descriptionCount.textContent =
            description.value.length;

    }

});