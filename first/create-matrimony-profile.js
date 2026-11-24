document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("createMatrimonyForm");

    const aboutMe = document.getElementById("aboutMe");
    const aboutCounter = document.getElementById("aboutCounter");

    const previewBtn = document.getElementById("previewChangesBtn");
    const previewModal = document.getElementById("previewModal");

    const closePreview = document.getElementById("closePreview");
    const cancelPreview = document.getElementById("cancelPreview");

    const confirmPreviewSave =
        document.getElementById("confirmPreviewSave");

    const saveDraftBtn =
        document.getElementById("saveDraftBtn");

    const toast =
        document.getElementById("editMatToast");

    const photoUpload =
        document.getElementById("photoUpload");


    /* =====================================================
       ABOUT ME COUNTER
    ===================================================== */

    function updateAboutCounter() {

        if (!aboutMe || !aboutCounter) {
            return;
        }

        aboutCounter.textContent = aboutMe.value.length;
    }

    if (aboutMe) {

        aboutMe.addEventListener(
            "input",
            updateAboutCounter
        );

        updateAboutCounter();
    }


    /* =====================================================
       TOAST
    ===================================================== */

    let toastTimer;

    function showToast(message) {

        if (!toast) {
            return;
        }

        const text =
            toast.querySelector("span");

        if (text) {
            text.textContent = message;
        }

        toast.classList.add("show");

        clearTimeout(toastTimer);

        toastTimer = setTimeout(function () {

            toast.classList.remove("show");

        }, 3000);
    }


    /* =====================================================
       COLLECT FORM DATA
    ===================================================== */

    function getFormValues() {

        const fullName =
            document.getElementById("fullName")?.value || "";

        const profession =
            document.getElementById("profession")?.value || "";

        const city =
            document.getElementById("city")?.value || "";

        const state =
            document.getElementById("state")?.value || "";

        const ageMin =
            document.getElementById("ageMin")?.value || "";

        const ageMax =
            document.getElementById("ageMax")?.value || "";

        const partnerProfession =
            document.getElementById("partnerProfession")?.value || "";

        return {
            fullName,
            profession,
            city,
            state,
            ageMin,
            ageMax,
            partnerProfession
        };
    }


    /* =====================================================
       PREVIEW
    ===================================================== */

    function openPreview() {

        const values = getFormValues();

        const previewName =
            document.getElementById("previewName");

        const previewProfession =
            document.getElementById("previewProfession");

        const previewLocation =
            document.getElementById("previewLocation");

        const previewPartner =
            document.getElementById("previewPartner");


        if (previewName) {
            previewName.textContent =
                values.fullName || "Not provided";
        }

        if (previewProfession) {
            previewProfession.textContent =
                values.profession || "Not provided";
        }

        if (previewLocation) {

            const location =
                [values.city, values.state]
                    .filter(Boolean)
                    .join(", ");

            previewLocation.textContent =
                location || "Not provided";
        }

        if (previewPartner) {

            let partnerText = "";

            if (values.ageMin && values.ageMax) {

                partnerText =
                    values.ageMin +
                    " - " +
                    values.ageMax +
                    " years";

            }

            if (values.partnerProfession) {

                partnerText +=
                    partnerText
                        ? " • " + values.partnerProfession
                        : values.partnerProfession;
            }

            previewPartner.textContent =
                partnerText || "Not provided";
        }


        if (previewModal) {

            previewModal.classList.add("show");

            previewModal.setAttribute(
                "aria-hidden",
                "false"
            );

            document.body.style.overflow = "hidden";
        }
    }


    function closePreviewModal() {

        if (!previewModal) {
            return;
        }

        previewModal.classList.remove("show");

        previewModal.setAttribute(
            "aria-hidden",
            "true"
        );

        document.body.style.overflow = "";
    }


    if (previewBtn) {

        previewBtn.addEventListener(
            "click",
            openPreview
        );
    }


    if (closePreview) {

        closePreview.addEventListener(
            "click",
            closePreviewModal
        );
    }


    if (cancelPreview) {

        cancelPreview.addEventListener(
            "click",
            closePreviewModal
        );
    }


    /* Close when clicking overlay */

    if (previewModal) {

        previewModal.addEventListener(
            "click",
            function (event) {

                if (
                    event.target.classList.contains(
                        "pl-edit-mat-modal-overlay"
                    )
                ) {
                    closePreviewModal();
                }

            }
        );
    }


    /* Escape key */

    document.addEventListener(
        "keydown",
        function (event) {

            if (
                event.key === "Escape" &&
                previewModal &&
                previewModal.classList.contains("show")
            ) {
                closePreviewModal();
            }

        }
    );


    /* =====================================================
       SAVE CHANGES
    ===================================================== */

    function saveProfile() {

        const values = getFormValues();

        const profileData = {
            ...values,
            savedAt: new Date().toISOString()
        };

        localStorage.setItem(
            "peoplelink_matrimony_edit_draft",
            JSON.stringify(profileData)
        );

        closePreviewModal();

        showToast(
            "Profile changes saved successfully."
        );
    }


    if (confirmPreviewSave) {

        confirmPreviewSave.addEventListener(
            "click",
            saveProfile
        );
    }


    if (form) {

        form.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();

                saveProfile();

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

                const values = getFormValues();

                localStorage.setItem(
                    "peoplelink_matrimony_edit_draft",
                    JSON.stringify({
                        ...values,
                        draft: true,
                        savedAt: new Date().toISOString()
                    })
                );

                showToast(
                    "Your profile draft has been saved."
                );

            }
        );
    }


    /* =====================================================
       PHOTO PRIMARY
    ===================================================== */

    const primaryButtons =
        document.querySelectorAll(
            "[data-photo-primary]"
        );

    primaryButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                const photoItem =
                    button.closest(
                        ".pl-edit-mat-photo-item"
                    );

                if (!photoItem) {
                    return;
                }

                document
                    .querySelectorAll(
                        ".pl-edit-mat-photo-item"
                    )
                    .forEach(function (item) {

                        item.classList.remove(
                            "primary"
                        );

                        const badge =
                            item.querySelector(
                                ".pl-edit-mat-primary-badge"
                            );

                        if (badge) {
                            badge.remove();
                        }

                    });


                photoItem.classList.add("primary");


                const badge =
                    document.createElement("span");

                badge.className =
                    "pl-edit-mat-primary-badge";

                badge.innerHTML =
                    '<i class="bi bi-star-fill"></i> Primary';

                photoItem.appendChild(badge);


                button.remove();


                showToast(
                    "Primary profile photo updated."
                );

            }
        );

    });


    /* =====================================================
       REMOVE PHOTO
    ===================================================== */

    const removeButtons =
        document.querySelectorAll(
            ".pl-edit-mat-photo-remove"
        );

    removeButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                const photoItem =
                    button.closest(
                        ".pl-edit-mat-photo-item"
                    );

                if (!photoItem) {
                    return;
                }

                const confirmed =
                    window.confirm(
                        "Are you sure you want to remove this photo?"
                    );

                if (!confirmed) {
                    return;
                }

                photoItem.remove();

                showToast(
                    "Photo removed from your profile."
                );

            }
        );

    });


    /* =====================================================
       PHOTO UPLOAD
    ===================================================== */

    if (photoUpload) {

        photoUpload.addEventListener(
            "change",
            function () {

                const files =
                    Array.from(
                        photoUpload.files || []
                    );

                if (!files.length) {
                    return;
                }

                let validCount = 0;

                files.forEach(function (file) {

                    if (
                        !file.type.startsWith("image/")
                    ) {
                        return;
                    }

                    validCount++;

                });


                if (validCount > 0) {

                    showToast(
                        validCount +
                        " photo" +
                        (validCount > 1 ? "s" : "") +
                        " selected for upload."
                    );

                }

            }
        );

    }


    /* =====================================================
       BASIC FIELD VALIDATION
    ===================================================== */

    if (form) {

        const requiredFields =
            form.querySelectorAll(
                "[required]"
            );

        requiredFields.forEach(function (field) {

            field.addEventListener(
                "blur",
                function () {

                    if (!field.value.trim()) {

                        field.style.borderColor =
                            "#e72d55";

                    } else {

                        field.style.borderColor =
                            "";
                    }

                }
            );


            field.addEventListener(
                "input",
                function () {

                    if (field.value.trim()) {

                        field.style.borderColor =
                            "";
                    }

                }
            );

        });

    }


    /* =====================================================
       AGE RANGE VALIDATION
    ===================================================== */

    const ageMin =
        document.getElementById("ageMin");

    const ageMax =
        document.getElementById("ageMax");


    function validateAgeRange() {

        if (
            !ageMin ||
            !ageMax ||
            !ageMin.value ||
            !ageMax.value
        ) {
            return true;
        }

        const min =
            parseInt(ageMin.value, 10);

        const max =
            parseInt(ageMax.value, 10);


        if (min > max) {

            ageMax.style.borderColor =
                "#e72d55";

            return false;
        }


        ageMax.style.borderColor = "";

        return true;
    }


    if (ageMin) {

        ageMin.addEventListener(
            "input",
            validateAgeRange
        );
    }

    if (ageMax) {

        ageMax.addEventListener(
            "input",
            validateAgeRange
        );
    }


    if (form) {

        form.addEventListener(
            "submit",
            function (event) {

                if (!validateAgeRange()) {

                    event.preventDefault();

                    showToast(
                        "Please check the partner age range."
                    );

                }

            }
        );

    }


});