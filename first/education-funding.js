document.addEventListener("DOMContentLoaded", function () {

    const form =
        document.getElementById("educationSupportForm");

    const reason =
        document.getElementById("supportReason");

    const reasonCount =
        document.getElementById("supportReasonCount");

    const documentInput =
        document.getElementById("educationDocuments");

    const dropZone =
        document.getElementById("educationDropZone");

    const fileList =
        document.getElementById("educationFileList");

    const previewModal =
        document.getElementById("educationPreviewModal");

    const agreement =
        document.getElementById("educationAgreement");

    let selectedDocuments = [];

    let toastTimer;


    /* =====================================================
       SCROLL TO FORM
    ===================================================== */

    window.scrollToEducationForm = function () {

        const section =
            document.getElementById("educationRequestForm");

        if (!section) return;

        section.scrollIntoView({
            behavior: "smooth",
            block: "start"
        });

    };


    /* =====================================================
       SCROLL TO APPROVED REQUESTS
    ===================================================== */

    window.scrollToApprovedRequests = function () {

        const section =
            document.getElementById(
                "approvedEducationRequests"
            );

        if (!section) return;

        section.scrollIntoView({
            behavior: "smooth",
            block: "start"
        });

    };


    /* =====================================================
       DESCRIPTION COUNTER
    ===================================================== */

    if (reason) {

        reason.addEventListener("input", function () {

            if (this.value.length > 1500) {
                this.value =
                    this.value.substring(0, 1500);
            }

            reasonCount.textContent =
                this.value.length;

        });

    }


    /* =====================================================
       VISIBILITY
    ===================================================== */

    document.querySelectorAll(
        ".pl-edu-visibility-card"
    ).forEach(card => {

        card.addEventListener("click", function () {

            document.querySelectorAll(
                ".pl-edu-visibility-card"
            ).forEach(item => {
                item.classList.remove("active");
            });

            this.classList.add("active");

            const radio =
                this.querySelector("input");

            if (radio) {
                radio.checked = true;
            }

        });

    });


    /* =====================================================
       DOCUMENT UPLOAD
    ===================================================== */

    if (documentInput) {

        documentInput.addEventListener(
            "change",
            function () {

                addDocuments(
                    Array.from(this.files)
                );

            }
        );

    }


    if (dropZone) {

        dropZone.addEventListener(
            "dragover",
            function (event) {

                event.preventDefault();

                dropZone.classList.add(
                    "dragover"
                );

            }
        );


        dropZone.addEventListener(
            "dragleave",
            function () {

                dropZone.classList.remove(
                    "dragover"
                );

            }
        );


        dropZone.addEventListener(
            "drop",
            function (event) {

                event.preventDefault();

                dropZone.classList.remove(
                    "dragover"
                );

                addDocuments(
                    Array.from(
                        event.dataTransfer.files
                    )
                );

            }
        );

    }


    function addDocuments(files) {

        files.forEach(file => {

            const allowedTypes = [
                "application/pdf",
                "image/jpeg",
                "image/png"
            ];

            if (
                !allowedTypes.includes(
                    file.type
                )
            ) {

                showEducationToast(
                    "Only PDF, JPG and PNG files are allowed."
                );

                return;

            }


            if (
                file.size >
                8 * 1024 * 1024
            ) {

                showEducationToast(
                    "Each document should be below 8 MB."
                );

                return;

            }


            const alreadyExists =
                selectedDocuments.some(
                    item =>
                        item.name === file.name &&
                        item.size === file.size
                );

            if (!alreadyExists) {
                selectedDocuments.push(file);
            }

        });


        if (selectedDocuments.length > 8) {

            selectedDocuments =
                selectedDocuments.slice(0, 8);

            showEducationToast(
                "Maximum 8 supporting documents can be selected."
            );

        }


        renderDocuments();

        syncDocumentInput();

    }


    function renderDocuments() {

        if (!fileList) return;

        fileList.innerHTML = "";

        selectedDocuments.forEach(
            (file, index) => {

                const row =
                    document.createElement("div");

                row.className =
                    "pl-edu-file";

                const icon =
                    file.type ===
                    "application/pdf"
                        ? "bi-file-earmark-pdf-fill"
                        : "bi-file-earmark-image-fill";

                row.innerHTML = `
                    <div>
                        <i class="bi ${icon}"></i>
                        <span>${escapeHtml(file.name)}</span>
                    </div>

                    <button type="button"
                            title="Remove document">
                        <i class="bi bi-x-lg"></i>
                    </button>
                `;


                row.querySelector("button")
                    .addEventListener(
                        "click",
                        function () {

                            selectedDocuments
                                .splice(index, 1);

                            renderDocuments();

                            syncDocumentInput();

                        }
                    );


                fileList.appendChild(row);

            }
        );

    }


    function syncDocumentInput() {

        if (!documentInput) return;

        const transfer =
            new DataTransfer();

        selectedDocuments.forEach(file => {

            transfer.items.add(file);

        });

        documentInput.files =
            transfer.files;

    }


    function escapeHtml(value) {

        return value
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");

    }


    /* =====================================================
       PREVIEW
    ===================================================== */

    window.previewEducationRequest =
        function () {

            const student =
                document.querySelector(
                    '[name="student_name"]'
                ).value.trim();

            const level =
                document.querySelector(
                    '[name="education_level"]'
                ).value.trim();

            const institution =
                document.querySelector(
                    '[name="institution"]'
                ).value.trim();

            const amount =
                document.querySelector(
                    '[name="amount_required"]'
                ).value.trim();

            const supportReason =
                document.querySelector(
                    '[name="support_reason"]'
                ).value.trim();


            document.getElementById(
                "previewStudent"
            ).textContent =
                student || "Not provided";


            document.getElementById(
                "previewLevel"
            ).textContent =
                level || "Not selected";


            document.getElementById(
                "previewInstitution"
            ).textContent =
                institution || "Not provided";


            document.getElementById(
                "previewAmount"
            ).textContent =
                amount
                    ? "₹ " +
                      Number(amount)
                        .toLocaleString("en-IN")
                    : "Not provided";


            document.getElementById(
                "previewReason"
            ).textContent =
                supportReason ||
                "No reason provided.";


            previewModal.classList.add("show");

            document.body.style.overflow =
                "hidden";

        };


    window.closeEducationPreview =
        function () {

            previewModal.classList.remove(
                "show"
            );

            document.body.style.overflow =
                "";

        };


    if (previewModal) {

        previewModal.addEventListener(
            "click",
            function (event) {

                if (
                    event.target ===
                    previewModal
                ) {

                    closeEducationPreview();

                }

            }
        );

    }


    /* =====================================================
       SAVE DRAFT
    ===================================================== */

    window.saveEducationDraft =
        function () {

            const data = {};

            const fields =
                form.querySelectorAll(
                    "input, select, textarea"
                );

            fields.forEach(field => {

                if (
                    !field.name ||
                    field.type === "file"
                ) {
                    return;
                }

                if (
                    field.type === "checkbox"
                ) {

                    data[field.name] =
                        field.checked;

                    return;

                }


                if (
                    field.type === "radio"
                ) {

                    if (field.checked) {
                        data[field.name] =
                            field.value;
                    }

                    return;

                }


                data[field.name] =
                    field.value;

            });


            localStorage.setItem(
                "peoplelink_education_support_draft",
                JSON.stringify(data)
            );


            showEducationToast(
                "Education request draft saved."
            );

        };


    /* =====================================================
       LOAD DRAFT
    ===================================================== */

    function loadDraft() {

        const saved =
            localStorage.getItem(
                "peoplelink_education_support_draft"
            );

        if (!saved) return;

        try {

            const data =
                JSON.parse(saved);

            Object.keys(data).forEach(
                name => {

                    const fields =
                        form.querySelectorAll(
                            `[name="${name}"]`
                        );

                    if (!fields.length) {
                        return;
                    }


                    fields.forEach(field => {

                        if (
                            field.type ===
                            "checkbox"
                        ) {

                            field.checked =
                                Boolean(
                                    data[name]
                                );

                            return;

                        }


                        if (
                            field.type ===
                            "radio"
                        ) {

                            field.checked =
                                field.value ===
                                data[name];

                            return;

                        }


                        field.value =
                            data[name];

                    });

                }
            );


            if (reason) {

                reason.dispatchEvent(
                    new Event("input")
                );

            }


            document.querySelectorAll(
                ".pl-edu-visibility-card"
            ).forEach(card => {

                const radio =
                    card.querySelector(
                        "input"
                    );

                if (
                    radio &&
                    radio.checked
                ) {

                    document.querySelectorAll(
                        ".pl-edu-visibility-card"
                    ).forEach(item => {
                        item.classList.remove(
                            "active"
                        );
                    });

                    card.classList.add(
                        "active"
                    );

                }

            });

        } catch (error) {

            console.warn(
                "Unable to load education draft.",
                error
            );

        }

    }


    /* =====================================================
       SUBMIT
    ===================================================== */

    if (form) {

        form.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();


                const student =
                    document.querySelector(
                        '[name="student_name"]'
                    ).value.trim();

                const guardian =
                    document.querySelector(
                        '[name="guardian_name"]'
                    ).value.trim();

                const institution =
                    document.querySelector(
                        '[name="institution"]'
                    ).value.trim();

                const amount =
                    document.querySelector(
                        '[name="amount_required"]'
                    ).value.trim();

                const contact =
                    document.querySelector(
                        '[name="contact_person"]'
                    ).value.trim();

                const mobile =
                    document.querySelector(
                        '[name="mobile"]'
                    ).value.trim();


                if (
                    !student ||
                    !guardian ||
                    !institution ||
                    !amount ||
                    !contact ||
                    !mobile
                ) {

                    showEducationToast(
                        "Please complete all required fields."
                    );

                    return;

                }


                if (
                    Number(amount) <= 0
                ) {

                    showEducationToast(
                        "Please enter a valid support amount."
                    );

                    return;

                }


                if (
                    !agreement.checked
                ) {

                    showEducationToast(
                        "Please confirm that the information is genuine."
                    );

                    return;

                }


                /*
                 * Connect this FormData to your
                 * PHP/AJAX education request endpoint.
                 */

                const formData =
                    new FormData(form);

                formData.append(
                    "status",
                    "pending_verification"
                );


                console.log(
                    "Education Support Request:",
                    Object.fromEntries(
                        formData.entries()
                    )
                );


                showEducationToast(
                    "Education request prepared for verification."
                );

            }
        );

    }


    /* =====================================================
       GENERAL TOAST
    ===================================================== */

    window.showEducationToast =
        function (message) {

            const toast =
                document.getElementById(
                    "educationToast"
                );

            const text =
                document.getElementById(
                    "educationToastText"
                );

            if (!toast || !text) {
                return;
            }

            text.textContent =
                message;

            toast.classList.add("show");

            clearTimeout(toastTimer);

            toastTimer =
                setTimeout(
                    function () {

                        toast.classList.remove(
                            "show"
                        );

                    },
                    3200
                );

        };


    /* =====================================================
       ESC KEY FOR MODAL
    ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (
                event.key === "Escape" &&
                previewModal.classList.contains("show")
            ) {

                closeEducationPreview();

            }

        }
    );


    /* =====================================================
       INITIALIZE
    ===================================================== */

    loadDraft();

});