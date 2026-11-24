document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("emergencyHelpForm");
    const emergencyType = document.getElementById("emergencyType");
    const medicalFields = document.getElementById("medicalEmergencyFields");

    const requirement = document.getElementById("emergencyRequirement");
    const requirementCount =
        document.getElementById("emergencyRequirementCount");

    const fileInput = document.getElementById("emergencyDocuments");
    const dropZone = document.getElementById("emergencyDropZone");
    const fileList = document.getElementById("emergencyFileList");

    const agreement = document.getElementById("emergencyAgreement");

    let selectedFiles = [];


    /* =========================================================
       SCROLL HELPERS
    ========================================================== */

    window.scrollToEmergencyForm = function () {

        const section = document.getElementById("emergencyRequestForm");

        if (section) {
            section.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        }
    };


    window.scrollToActiveEmergency = function () {

        const section =
            document.getElementById("activeEmergencyRequests");

        if (section) {
            section.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        }
    };


    window.scrollToHelpOptions = function () {

        const section =
            document.querySelector(".pl-emergency-help-options");

        if (section) {
            section.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
        }
    };


    /* =========================================================
       MEDICAL / BLOOD CONDITIONAL FIELDS
    ========================================================== */

    function toggleMedicalFields() {

        if (!medicalFields || !emergencyType) return;

        const value = emergencyType.value;

        if (
            value === "medical" ||
            value === "blood" ||
            value === "hospital" ||
            value === "accident"
        ) {
            medicalFields.classList.add("show");
        } else {
            medicalFields.classList.remove("show");
        }
    }

    if (emergencyType) {
        emergencyType.addEventListener("change", toggleMedicalFields);
        toggleMedicalFields();
    }


    /* =========================================================
       DESCRIPTION COUNTER
    ========================================================== */

    if (requirement && requirementCount) {

        function updateRequirementCount() {

            requirementCount.textContent =
                requirement.value.length;

        }

        requirement.addEventListener(
            "input",
            updateRequirementCount
        );

        updateRequirementCount();
    }


    /* =========================================================
       FILE HANDLING
    ========================================================== */

    function syncFiles() {

        if (!fileInput) return;

        const dataTransfer = new DataTransfer();

        selectedFiles.forEach(function (file) {
            dataTransfer.items.add(file);
        });

        fileInput.files = dataTransfer.files;
    }


    function renderFiles() {

        if (!fileList) return;

        fileList.innerHTML = "";

        selectedFiles.forEach(function (file, index) {

            const item =
                document.createElement("div");

            item.className =
                "pl-emergency-file-item";

            item.innerHTML = `
                <span>
                    <i class="bi bi-file-earmark-text"></i>
                    ${escapeHtml(file.name)}
                </span>

                <button type="button"
                        aria-label="Remove file"
                        data-index="${index}">
                    <i class="bi bi-x-lg"></i>
                </button>
            `;

            fileList.appendChild(item);
        });

        fileList.querySelectorAll("button").forEach(function (button) {

            button.addEventListener("click", function () {

                const index =
                    Number(this.dataset.index);

                selectedFiles.splice(index, 1);

                syncFiles();
                renderFiles();

            });

        });
    }


    function addFiles(files) {

        Array.from(files).forEach(function (file) {

            const validTypes = [
                "image/jpeg",
                "image/png",
                "application/pdf"
            ];

            if (!validTypes.includes(file.type)) {
                showEmergencyToast(
                    "Only JPG, PNG and PDF files are allowed."
                );
                return;
            }

            const exists =
                selectedFiles.some(function (existingFile) {
                    return (
                        existingFile.name === file.name &&
                        existingFile.size === file.size
                    );
                });

            if (!exists) {
                selectedFiles.push(file);
            }

        });

        syncFiles();
        renderFiles();
    }


    if (fileInput) {

        fileInput.addEventListener(
            "change",
            function () {
                addFiles(this.files);
            }
        );

    }


    if (dropZone) {

        ["dragenter", "dragover"].forEach(function (eventName) {

            dropZone.addEventListener(
                eventName,
                function (event) {

                    event.preventDefault();
                    event.stopPropagation();

                    dropZone.classList.add("dragover");

                }
            );

        });


        ["dragleave", "drop"].forEach(function (eventName) {

            dropZone.addEventListener(
                eventName,
                function (event) {

                    event.preventDefault();
                    event.stopPropagation();

                    dropZone.classList.remove("dragover");

                }
            );

        });


        dropZone.addEventListener(
            "drop",
            function (event) {

                addFiles(event.dataTransfer.files);

            }
        );

    }


    /* =========================================================
       VISIBILITY
    ========================================================== */

    document
        .querySelectorAll(".pl-emergency-visibility-card")
        .forEach(function (card) {

            const radio =
                card.querySelector("input[type='radio']");

            radio.addEventListener("change", function () {

                document
                    .querySelectorAll(
                        ".pl-emergency-visibility-card"
                    )
                    .forEach(function (item) {

                        item.classList.remove("active");

                    });

                card.classList.add("active");

            });

        });


    /* =========================================================
       PREVIEW
    ========================================================== */

    window.previewEmergencyRequest = function () {

        const requester =
            form?.querySelector(
                "[name='requester_name']"
            )?.value.trim() || "—";

        const type =
            emergencyType?.options[
                emergencyType.selectedIndex
            ]?.text || "—";

        const location =
            form?.querySelector(
                "[name='location']"
            )?.value.trim() || "—";

        const urgency =
            form?.querySelector(
                "[name='urgency']"
            )?.value || "—";

        const requirementText =
            requirement?.value.trim() || "—";


        document.getElementById(
            "previewEmergencyRequester"
        ).textContent = requester;


        document.getElementById(
            "previewEmergencyType"
        ).textContent = type;


        document.getElementById(
            "previewEmergencyLocation"
        ).textContent = location;


        document.getElementById(
            "previewEmergencyUrgency"
        ).textContent =
            urgency.charAt(0).toUpperCase() +
            urgency.slice(1);


        document.getElementById(
            "previewEmergencyRequirement"
        ).textContent = requirementText;


        document
            .getElementById("emergencyPreviewModal")
            .classList.add("show");

    };


    window.closeEmergencyPreview = function () {

        const modal =
            document.getElementById(
                "emergencyPreviewModal"
            );

        if (modal) {
            modal.classList.remove("show");
        }

    };


    /* =========================================================
       SAVE DRAFT
    ========================================================== */

    window.saveEmergencyDraft = function () {

        if (!form) return;

        const data = {};

        form.querySelectorAll(
            "input:not([type='file']), select, textarea"
        ).forEach(function (field) {

            if (!field.name) return;

            if (field.type === "radio") {

                if (field.checked) {
                    data[field.name] = field.value;
                }

            } else if (field.type === "checkbox") {

                data[field.name] = field.checked;

            } else {

                data[field.name] = field.value;

            }

        });

        localStorage.setItem(
            "peoplelinkEmergencyDraft",
            JSON.stringify(data)
        );

        showEmergencyToast(
            "Emergency request draft saved."
        );

    };


    /* =========================================================
       LOAD DRAFT
    ========================================================== */

    function loadDraft() {

        const saved =
            localStorage.getItem(
                "peoplelinkEmergencyDraft"
            );

        if (!saved || !form) return;

        try {

            const data =
                JSON.parse(saved);

            Object.keys(data).forEach(function (name) {

                const field =
                    form.querySelector(
                        `[name="${name}"]`
                    );

                if (!field) return;

                if (field.type === "radio") {

                    form.querySelectorAll(
                        `[name="${name}"]`
                    ).forEach(function (radio) {

                        radio.checked =
                            radio.value === data[name];

                    });

                } else if (field.type === "checkbox") {

                    field.checked =
                        Boolean(data[name]);

                } else {

                    field.value =
                        data[name];

                }

            });

            toggleMedicalFields();

            document
                .querySelectorAll(
                    ".pl-emergency-visibility-card"
                )
                .forEach(function (card) {

                    const radio =
                        card.querySelector("input");

                    if (radio?.checked) {
                        card.classList.add("active");
                    } else {
                        card.classList.remove("active");
                    }

                });

            if (requirement && requirementCount) {
                requirementCount.textContent =
                    requirement.value.length;
            }

        } catch (error) {
            console.warn(
                "Emergency draft could not be loaded."
            );
        }

    }

    loadDraft();


    /* =========================================================
       FORM SUBMISSION
    ========================================================== */

    if (form) {

        form.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();

                if (!agreement || !agreement.checked) {

                    showEmergencyToast(
                        "Please confirm that the emergency information is genuine."
                    );

                    agreement?.focus();

                    return;
                }


                if (!form.checkValidity()) {

                    form.reportValidity();

                    return;
                }


                /*
                 * Demo workflow.
                 *
                 * Replace this section with AJAX/PHP submission,
                 * for example:
                 *
                 * fetch("emergency-submit.php", {
                 *     method: "POST",
                 *     body: new FormData(form)
                 * });
                 */

                showEmergencyToast(
                    "Emergency request submitted for review."
                );

                localStorage.removeItem(
                    "peoplelinkEmergencyDraft"
                );

            }
        );

    }


    /* =========================================================
       TOAST
    ========================================================== */

    window.showEmergencyToast = function (message) {

        const toast =
            document.getElementById(
                "emergencyToast"
            );

        const text =
            document.getElementById(
                "emergencyToastText"
            );

        if (!toast || !text) return;

        text.textContent = message;

        toast.classList.add("show");

        clearTimeout(
            window.peoplelinkEmergencyToastTimer
        );

        window.peoplelinkEmergencyToastTimer =
            setTimeout(function () {

                toast.classList.remove("show");

            }, 3200);

    };


    /* =========================================================
       CLOSE MODAL ON BACKDROP
    ========================================================== */

    const modal =
        document.getElementById(
            "emergencyPreviewModal"
        );

    if (modal) {

        modal.addEventListener(
            "click",
            function (event) {

                if (event.target === modal) {
                    closeEmergencyPreview();
                }

            }
        );

    }


    /* =========================================================
       ESCAPE KEY
    ========================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (event.key === "Escape") {
                closeEmergencyPreview();
            }

        }
    );


    /* =========================================================
       HTML ESCAPE
    ========================================================== */

    function escapeHtml(value) {

        return String(value)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");

    }

});