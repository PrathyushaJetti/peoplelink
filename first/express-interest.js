document.addEventListener("DOMContentLoaded", function () {

    const form =
        document.getElementById("expressInterestForm");

    const message =
        document.getElementById("interestMessage");

    const messageCount =
        document.getElementById("interestMessageCount");

    const sendButton =
        document.getElementById("sendInterestBtn");

    const currentStatus =
        document.getElementById("currentStatus");

    const withdrawArea =
        document.getElementById("withdrawArea");

    const withdrawButton =
        document.getElementById("withdrawInterestBtn");

    const withdrawModal =
        document.getElementById("withdrawModal");

    const confirmWithdraw =
        document.getElementById("confirmWithdraw");

    const contactModal =
        document.getElementById("contactModal");

    const acceptedContactButton =
        document.getElementById("acceptedContactBtn");

    const confirmContactRequest =
        document.getElementById(
            "confirmContactRequest"
        );

    const toast =
        document.getElementById("interestToast");

    const toastTitle =
        document.getElementById(
            "interestToastTitle"
        );

    const toastMessage =
        document.getElementById(
            "interestToastMessage"
        );


    let interestStatus = "pending";


    /* =====================================================
       TOAST
    ===================================================== */

    function showToast(title, text) {

        toastTitle.textContent = title;
        toastMessage.textContent = text;

        toast.classList.add("show");

        clearTimeout(
            window.peopleLinkInterestToast
        );

        window.peopleLinkInterestToast =
            setTimeout(function () {

                toast.classList.remove("show");

            }, 3500);

    }


    /* =====================================================
       MESSAGE COUNTER
    ===================================================== */

    if (message) {

        message.addEventListener(
            "input",
            function () {

                messageCount.textContent =
                    message.value.length;

            }
        );

    }


    /* =====================================================
       STATUS UPDATE
    ===================================================== */

    function updateStatus(status) {

        interestStatus = status;


        currentStatus.classList.remove(
            "pending",
            "accepted",
            "declined"
        );


        currentStatus.classList.add(
            status
        );


        currentStatus.textContent =
            status.charAt(0).toUpperCase() +
            status.slice(1);


        const steps =
            document.querySelectorAll(
                ".pl-interest-status-step"
            );


        steps.forEach(function (step) {

            step.classList.remove(
                "active"
            );

        });


        const activeStep =
            document.querySelector(
                '[data-status="' +
                status +
                '"]'
            );


        if (activeStep) {

            activeStep.classList.add(
                "active"
            );

        }


        /* Pending */

        if (status === "pending") {

            withdrawArea.style.display =
                "flex";

            sendButton.disabled = true;

            sendButton.classList.add(
                "sent"
            );

            sendButton.innerHTML =
                '<i class="bi bi-check-circle-fill"></i> Interest Sent';

        }


        /* Accepted */

        if (status === "accepted") {

            withdrawArea.style.display =
                "none";

            sendButton.disabled = true;

            sendButton.classList.add(
                "sent"
            );

            sendButton.innerHTML =
                '<i class="bi bi-check-circle-fill"></i> Interest Accepted';

        }


        /* Declined */

        if (status === "declined") {

            withdrawArea.style.display =
                "none";

            sendButton.disabled = false;

            sendButton.classList.remove(
                "sent"
            );

            sendButton.innerHTML =
                '<i class="bi bi-heart-fill"></i> Express Interest';

        }

    }


    /* =====================================================
       EXPRESS INTEREST
    ===================================================== */

    if (form) {

        form.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();


                if (interestStatus === "pending") {

                    showToast(
                        "Already Sent",
                        "You have already expressed interest in this profile."
                    );

                    return;

                }


                const originalHTML =
                    sendButton.innerHTML;


                sendButton.disabled = true;

                sendButton.innerHTML =
                    '<i class="bi bi-arrow-repeat"></i> Sending...';


                const profileId = document.getElementById("targetProfileId") ? document.getElementById("targetProfileId").value : "";
                const csrf = document.getElementById("csrfToken") ? document.getElementById("csrfToken").value : "";
                const msgVal = message ? message.value.trim() : "";

                const formData = new FormData();
                formData.append("profile_id", profileId);
                formData.append("csrf", csrf);
                formData.append("interest_message", msgVal);

                fetch("api.php?action=send_interest", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    sendButton.disabled = false;
                    sendButton.innerHTML = originalHTML;

                    if (data.error) {
                        showToast("Notice", data.error);
                        return;
                    }

                    updateStatus("pending");
                    showToast("Interest Sent", data.message || "Your interest request has been sent successfully.");
                })
                .catch(err => {
                    sendButton.disabled = false;
                    sendButton.innerHTML = originalHTML;
                    showToast("Notice", "Interest request sent.");
                    updateStatus("pending");
                });
                return;

                setTimeout(function () {


                    /* Store demo state */

                    localStorage.setItem(
                        "peoplelink_interest_PLM10245",
                        JSON.stringify({
                            status: "pending",
                            message:
                                message.value.trim(),
                            sentAt:
                                new Date().toISOString()
                        })
                    );


                }, 800);

            }
        );

    }


    /* =====================================================
       WITHDRAW MODAL
    ===================================================== */

    if (withdrawButton) {

        withdrawButton.addEventListener(
            "click",
            function () {

                if (
                    interestStatus !==
                    "pending"
                ) {
                    return;
                }

                withdrawModal.hidden = false;

            }
        );

    }


    /* =====================================================
       CONFIRM WITHDRAW
    ===================================================== */

    if (confirmWithdraw) {

        confirmWithdraw.addEventListener(
            "click",
            function () {

                updateStatus(
                    "declined"
                );


                withdrawModal.hidden = true;


                localStorage.removeItem(
                    "peoplelink_interest_PLM10245"
                );


                showToast(
                    "Interest Withdrawn",
                    "Your pending interest request has been withdrawn."
                );

            }
        );

    }


    /* =====================================================
       CLOSE WITHDRAW MODAL
    ===================================================== */

    document.querySelectorAll(
        "[data-close-withdraw]"
    ).forEach(function (element) {

        element.addEventListener(
            "click",
            function () {

                withdrawModal.hidden = true;

            }
        );

    });


    /* =====================================================
       CONTACT REQUEST
    ===================================================== */

    if (acceptedContactButton) {

        acceptedContactButton.addEventListener(
            "click",
            function () {

                contactModal.hidden = false;

            }
        );

    }


    /* =====================================================
       CONFIRM CONTACT REQUEST
    ===================================================== */

    if (confirmContactRequest) {

        confirmContactRequest.addEventListener(
            "click",
            function () {

                contactModal.hidden = true;


                showToast(
                    "Contact Request Sent",
                    "Your request for contact access has been submitted."
                );


                confirmContactRequest.innerHTML =
                    '<i class="bi bi-check-circle"></i> Request Sent';

                confirmContactRequest.disabled =
                    true;

            }
        );

    }


    /* =====================================================
       CLOSE CONTACT MODAL
    ===================================================== */

    document.querySelectorAll(
        "[data-close-contact]"
    ).forEach(function (element) {

        element.addEventListener(
            "click",
            function () {

                contactModal.hidden = true;

            }
        );

    });


    /* =====================================================
       ESC KEY
    ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (
                event.key ===
                "Escape"
            ) {

                withdrawModal.hidden =
                    true;

                contactModal.hidden =
                    true;

            }

        }
    );


    /* =====================================================
       LOAD DEMO INTEREST STATE
    ===================================================== */

    function loadInterestState() {

        const saved =
            localStorage.getItem(
                "peoplelink_interest_PLM10245"
            );


        if (!saved) {

            updateStatus(
                "declined"
            );

            sendButton.disabled =
                false;

            sendButton.classList.remove(
                "sent"
            );

            sendButton.innerHTML =
                '<i class="bi bi-heart-fill"></i> Express Interest';

            return;

        }


        try {

            const data =
                JSON.parse(saved);


            if (data.message && message) {

                message.value =
                    data.message;

                messageCount.textContent =
                    message.value.length;

            }


            if (
                data.status ===
                "pending"
            ) {

                updateStatus(
                    "pending"
                );

            }

        } catch (error) {

            console.log(
                "Unable to load interest state."
            );

        }

    }


    loadInterestState();

});