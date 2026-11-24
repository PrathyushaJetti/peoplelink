document.addEventListener("DOMContentLoaded", function () {

    const form =
        document.getElementById("supportRequestForm");

    const categorySelect =
        document.getElementById("supportCategory");

    const categoryButtons =
        document.querySelectorAll(
            ".pl-support-category"
        );

    const description =
        document.getElementById("requestDescription");

    const descriptionCount =
        document.getElementById("descriptionCount");

    const documentInput =
        document.getElementById("supportDocument");

    const fileName =
        document.getElementById("supportFileName");

    const saveDraftBtn =
        document.getElementById("saveDraftBtn");

    const toast =
        document.getElementById("supportToast");

    const toastTitle =
        document.getElementById("supportToastTitle");

    const toastMessage =
        document.getElementById("supportToastMessage");

    const modal =
        document.getElementById("supportModal");

    const modalTitle =
        document.getElementById("supportModalTitle");

    const modalMessage =
        document.getElementById("supportModalMessage");

    const modalIcon =
        document.getElementById("supportModalIcon");


    /* =====================================================
       TOAST
    ===================================================== */

    function showToast(title, message) {

        toastTitle.textContent = title;
        toastMessage.textContent = message;

        toast.classList.add("show");

        clearTimeout(window.plSupportToastTimer);

        window.plSupportToastTimer =
            setTimeout(function () {

                toast.classList.remove("show");

            }, 3500);

    }


    /* =====================================================
       MODAL
    ===================================================== */

    function openModal(title, message, icon) {

        modalTitle.textContent = title;
        modalMessage.textContent = message;

        modalIcon.innerHTML =
            '<i class="bi ' + icon + '"></i>';

        modal.hidden = false;

    }


    function closeModal() {

        modal.hidden = true;

    }


    document.querySelectorAll(
        "[data-close-support-modal]"
    ).forEach(function (element) {

        element.addEventListener(
            "click",
            closeModal
        );

    });


    document.addEventListener(
        "keydown",
        function (event) {

            if (event.key === "Escape") {
                closeModal();
            }

        }
    );


    /* =====================================================
       CATEGORY SELECTION
    ===================================================== */

    categoryButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                const category =
                    button.dataset.category;

                if (categorySelect) {
                    categorySelect.value = category;
                }


                categoryButtons.forEach(
                    function (item) {
                        item.classList.remove("active");
                    }
                );


                button.classList.add("active");


                document
                    .getElementById("request-assistance")
                    .scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });

            }
        );

    });


    /* =====================================================
       DESCRIPTION COUNTER
    ===================================================== */

    if (description) {

        description.setAttribute(
            "maxlength",
            "1000"
        );


        description.addEventListener(
            "input",
            function () {

                descriptionCount.textContent =
                    description.value.length;

            }
        );

    }


    /* =====================================================
       FILE UPLOAD
    ===================================================== */

    const uploadBox =
        document.querySelector(
            ".pl-support-upload"
        );


    if (uploadBox && documentInput) {

        uploadBox.addEventListener(
            "click",
            function (event) {

                if (
                    event.target !== documentInput
                ) {

                    documentInput.click();

                }

            }
        );


        documentInput.addEventListener(
            "change",
            function () {

                if (!documentInput.files.length) {

                    fileName.textContent = "";

                    return;

                }


                const file =
                    documentInput.files[0];


                const allowedTypes = [
                    "application/pdf",
                    "image/jpeg",
                    "image/png",
                    "application/msword",
                    "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                ];


                if (
                    file.type &&
                    !allowedTypes.includes(file.type)
                ) {

                    documentInput.value = "";

                    fileName.textContent = "";

                    showToast(
                        "Invalid File",
                        "Please select an approved document format."
                    );

                    return;

                }


                const maxSize =
                    10 * 1024 * 1024;


                if (file.size > maxSize) {

                    documentInput.value = "";

                    fileName.textContent = "";

                    showToast(
                        "File Too Large",
                        "Please select a file smaller than 10 MB."
                    );

                    return;

                }


                fileName.textContent =
                    "Selected: " + file.name;

            }
        );


        uploadBox.addEventListener(
            "dragover",
            function (event) {

                event.preventDefault();

                uploadBox.classList.add(
                    "dragover"
                );

            }
        );


        uploadBox.addEventListener(
            "dragleave",
            function () {

                uploadBox.classList.remove(
                    "dragover"
                );

            }
        );


        uploadBox.addEventListener(
            "drop",
            function (event) {

                event.preventDefault();

                uploadBox.classList.remove(
                    "dragover"
                );


                if (
                    event.dataTransfer.files.length
                ) {

                    documentInput.files =
                        event.dataTransfer.files;


                    documentInput.dispatchEvent(
                        new Event("change")
                    );

                }

            }
        );

    }


    /* =====================================================
       SAVE DRAFT
    ===================================================== */

    if (saveDraftBtn) {

        saveDraftBtn.addEventListener(
            "click",
            function () {

                const title =
                    document.getElementById(
                        "requestTitle"
                    ).value.trim();


                if (!title) {

                    showToast(
                        "Draft Not Saved",
                        "Enter a request title before saving your draft."
                    );

                    document
                        .getElementById("requestTitle")
                        .focus();

                    return;

                }


                const draftData = {

                    title: title,

                    category:
                        categorySelect.value,

                    community:
                        document.getElementById(
                            "community"
                        ).value,

                    location:
                        document.getElementById(
                            "supportLocation"
                        ).value,

                    requiredBy:
                        document.getElementById(
                            "requiredDate"
                        ).value,

                    description:
                        description.value,

                    assistanceType:
                        document.getElementById(
                            "assistanceType"
                        ).value,

                    savedAt:
                        new Date().toISOString()

                };


                localStorage.setItem(
                    "peoplelink_support_draft",
                    JSON.stringify(draftData)
                );


                showToast(
                    "Draft Saved",
                    "Your support request draft has been saved."
                );

            }
        );

    }


    /* =====================================================
       LOAD SAVED DRAFT
    ===================================================== */

    function loadDraft() {

        const savedDraft =
            localStorage.getItem(
                "peoplelink_support_draft"
            );


        if (!savedDraft) {
            return;
        }


        try {

            const data =
                JSON.parse(savedDraft);


            document.getElementById(
                "requestTitle"
            ).value =
                data.title || "";


            categorySelect.value =
                data.category || "";


            document.getElementById(
                "community"
            ).value =
                data.community || "";


            document.getElementById(
                "supportLocation"
            ).value =
                data.location || "";


            document.getElementById(
                "requiredDate"
            ).value =
                data.requiredBy || "";


            description.value =
                data.description || "";


            document.getElementById(
                "assistanceType"
            ).value =
                data.assistanceType || "";


            descriptionCount.textContent =
                description.value.length;


        } catch (error) {

            console.log(
                "Unable to load saved draft."
            );

        }

    }


    loadDraft();


    /* =====================================================
       FORM SUBMISSION
    ===================================================== */

    if (form) {

        form.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();


                if (!form.checkValidity()) {

                    form.reportValidity();

                    return;

                }


                const submitButton =
                    form.querySelector(
                        ".pl-support-submit-btn"
                    );


                const originalHTML =
                    submitButton.innerHTML;


                submitButton.disabled = true;

                submitButton.innerHTML =
                    '<i class="bi bi-arrow-repeat"></i> Submitting...';


                setTimeout(function () {

                    localStorage.removeItem(
                        "peoplelink_support_draft"
                    );


                    submitButton.disabled = false;

                    submitButton.innerHTML =
                        originalHTML;


                    showToast(
                        "Request Submitted",
                        "Your support request has been submitted for review."
                    );


                    form.reset();

                    descriptionCount.textContent =
                        "0";

                    fileName.textContent =
                        "";


                    categoryButtons.forEach(
                        function (button) {
                            button.classList.remove(
                                "active"
                            );
                        }
                    );


                    window.scrollTo({
                        top: document.querySelector(
                            ".pl-support-page"
                        ).offsetTop,
                        behavior: "smooth"
                    });


                }, 1000);

            }
        );

    }


    /* =====================================================
       RESET
    ===================================================== */

    if (form) {

        form.addEventListener(
            "reset",
            function () {

                setTimeout(function () {

                    descriptionCount.textContent =
                        "0";

                    fileName.textContent =
                        "";

                    categoryButtons.forEach(
                        function (button) {
                            button.classList.remove(
                                "active"
                            );
                        }
                    );

                }, 10);

            }
        );

    }


    /* =====================================================
       VIEW REQUEST
    ===================================================== */

    document.querySelectorAll(
        ".pl-support-view-request"
    ).forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                const request =
                    button.dataset.request ||
                    "Support Request";


                openModal(
                    request,
                    "The detailed support request would open here. Access and contact information can be controlled by community permissions.",
                    "bi-file-earmark-text"
                );

            }
        );

    });


    /* =====================================================
       OFFER ASSISTANCE
    ===================================================== */

    const offerAssistanceBtn =
        document.getElementById(
            "offerAssistanceBtn"
        );


    if (offerAssistanceBtn) {

        offerAssistanceBtn.addEventListener(
            "click",
            function () {

                openModal(
                    "Offer Assistance",
                    "Eligible registered users can offer assistance to approved community support requests.",
                    "bi-hand-thumbs-up"
                );

            }
        );

    }


    /* =====================================================
       MY REQUESTS
    ===================================================== */

    function openMyRequests() {

        openModal(
            "My Support Requests",
            "Your submitted requests, approval status, responses and closed requests would be displayed here.",
            "bi-folder2-open"
        );

    }


    const myRequestsBtn =
        document.getElementById(
            "myRequestsBtn"
        );


    const finalMyRequests =
        document.getElementById(
            "finalMyRequests"
        );


    if (myRequestsBtn) {

        myRequestsBtn.addEventListener(
            "click",
            openMyRequests
        );

    }


    if (finalMyRequests) {

        finalMyRequests.addEventListener(
            "click",
            openMyRequests
        );

    }


    /* =====================================================
       RESOLVE REQUEST
    ===================================================== */

    const resolveRequestBtn =
        document.getElementById(
            "resolveRequestBtn"
        );


    if (resolveRequestBtn) {

        resolveRequestBtn.addEventListener(
            "click",
            function () {

                openModal(
                    "Mark as Resolved",
                    "You can mark a support request as resolved once sufficient assistance has been received.",
                    "bi-check2-circle"
                );

            }
        );

    }


    /* =====================================================
       REPORT REQUEST
    ===================================================== */

    const reportRequestBtn =
        document.getElementById(
            "reportRequestBtn"
        );


    if (reportRequestBtn) {

        reportRequestBtn.addEventListener(
            "click",
            function () {

                openModal(
                    "Report Support Request",
                    "Please provide accurate information when reporting a false, inappropriate or misleading request.",
                    "bi-flag"
                );

            }
        );

    }


    /* =====================================================
       VIEW ALL REQUESTS
    ===================================================== */

    const viewAllRequests =
        document.getElementById(
            "viewAllRequests"
        );


    if (viewAllRequests) {

        viewAllRequests.addEventListener(
            "click",
            function () {

                showToast(
                    "Support Requests",
                    "All approved support requests would be displayed here."
                );

            }
        );

    }

});