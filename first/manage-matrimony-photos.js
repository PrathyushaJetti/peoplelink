document.addEventListener("DOMContentLoaded", function () {

    const uploadInput = document.getElementById("photoUpload");
    const uploadButton = document.getElementById("uploadPhotosBtn");
    const dropZone = document.getElementById("photoDropZone");

    const selectedPreview = document.getElementById("selectedPreview");
    const selectedGrid = document.getElementById("selectedPhotoGrid");
    const selectedCount = document.getElementById("selectedPhotoCount");
    const clearSelected = document.getElementById("clearSelectedPhotos");

    const saveButton = document.getElementById("savePhotoChanges");

    const toast = document.getElementById("photoToast");
    const toastTitle = document.getElementById("photoToastTitle");
    const toastMessage = document.getElementById("photoToastMessage");

    const deleteModal = document.getElementById("deletePhotoModal");
    const confirmDelete = document.getElementById("confirmDeletePhoto");

    const photoCount = document.getElementById("photoCount");
    const primaryPhotoStatus = document.getElementById("primaryPhotoStatus");
    const approvedPhotoCount = document.getElementById("approvedPhotoCount");
    const pendingPhotoCount = document.getElementById("pendingPhotoCount");


    let selectedFiles = [];
    let photoToDelete = null;


    /* =====================================================
       TOAST
    ===================================================== */

    function showToast(title, message) {

        if (toastTitle) {
            toastTitle.textContent = title;
        }

        if (toastMessage) {
            toastMessage.textContent = message;
        }

        toast.classList.add("show");

        clearTimeout(window.photoToastTimer);

        window.photoToastTimer = setTimeout(function () {
            toast.classList.remove("show");
        }, 3500);
    }


    /* =====================================================
       OPEN FILE SELECTOR
    ===================================================== */

    if (uploadButton && uploadInput) {

        uploadButton.addEventListener("click", function () {
            uploadInput.click();
        });

    }


    /* =====================================================
       HANDLE FILES
    ===================================================== */

    function handleFiles(files) {

        const incomingFiles = Array.from(files);

        const allowedTypes = [
            "image/jpeg",
            "image/png",
            "image/webp"
        ];

        const maxSize = 5 * 1024 * 1024;

        incomingFiles.forEach(function (file) {

            if (!allowedTypes.includes(file.type)) {

                showToast(
                    "Unsupported File",
                    file.name + " is not a supported image format."
                );

                return;
            }


            if (file.size > maxSize) {

                showToast(
                    "File Too Large",
                    file.name + " is larger than 5 MB."
                );

                return;
            }


            const duplicate = selectedFiles.some(function (existing) {

                return (
                    existing.name === file.name &&
                    existing.size === file.size
                );

            });


            if (!duplicate) {
                selectedFiles.push(file);
            }

        });


        renderSelectedFiles();

    }


    /* =====================================================
       FILE INPUT
    ===================================================== */

    if (uploadInput) {

        uploadInput.addEventListener("change", function () {

            handleFiles(this.files);

            this.value = "";

        });

    }


    /* =====================================================
       DRAG & DROP
    ===================================================== */

    if (dropZone) {

        ["dragenter", "dragover"].forEach(function (eventName) {

            dropZone.addEventListener(eventName, function (event) {

                event.preventDefault();

                dropZone.classList.add("dragover");

            });

        });


        ["dragleave", "drop"].forEach(function (eventName) {

            dropZone.addEventListener(eventName, function (event) {

                event.preventDefault();

                dropZone.classList.remove("dragover");

            });

        });


        dropZone.addEventListener("drop", function (event) {

            const files = event.dataTransfer.files;

            handleFiles(files);

        });

    }


    /* =====================================================
       RENDER SELECTED FILES
    ===================================================== */

    function renderSelectedFiles() {

        if (!selectedPreview || !selectedGrid) {
            return;
        }


        selectedGrid.innerHTML = "";


        if (selectedFiles.length === 0) {

            selectedPreview.hidden = true;

            selectedCount.textContent = "0 photos";

            return;
        }


        selectedPreview.hidden = false;


        selectedCount.textContent =
            selectedFiles.length +
            (selectedFiles.length === 1 ? " photo" : " photos");


        selectedFiles.forEach(function (file, index) {

            const wrapper = document.createElement("div");

            wrapper.className = "pl-selected-photo";


            const image = document.createElement("img");

            image.alt = "Selected photo";


            const removeButton = document.createElement("button");

            removeButton.type = "button";

            removeButton.className = "pl-selected-photo-remove";

            removeButton.innerHTML =
                '<i class="bi bi-x-lg"></i>';

            removeButton.setAttribute(
                "aria-label",
                "Remove selected photo"
            );


            removeButton.addEventListener(
                "click",
                function () {

                    selectedFiles.splice(index, 1);

                    renderSelectedFiles();

                }
            );


            const reader = new FileReader();

            reader.onload = function (event) {

                image.src = event.target.result;

            };

            reader.readAsDataURL(file);


            wrapper.appendChild(image);

            wrapper.appendChild(removeButton);

            selectedGrid.appendChild(wrapper);

        });

    }


    /* =====================================================
       CLEAR SELECTED FILES
    ===================================================== */

    if (clearSelected) {

        clearSelected.addEventListener("click", function () {

            selectedFiles = [];

            renderSelectedFiles();

        });

    }


    /* =====================================================
       SET PRIMARY PHOTO
    ===================================================== */

    document.addEventListener("click", function (event) {

        const button = event.target.closest(
            "[data-primary-photo]"
        );

        if (!button) {
            return;
        }


        const photoId =
            button.getAttribute("data-primary-photo");


        const allPhotos =
            document.querySelectorAll(".pl-existing-photo");


        allPhotos.forEach(function (photo) {

            photo.classList.remove("is-primary");


            const badge =
                photo.querySelector(".pl-primary-badge");


            if (badge) {
                badge.remove();
            }


            const action =
                photo.querySelector(".primary-action");


            if (action) {

                action.disabled = false;

                action.className =
                    "pl-photo-action set-primary-action";

                action.setAttribute(
                    "data-primary-photo",
                    photo.getAttribute("data-photo-id")
                );

                action.innerHTML =
                    '<i class="bi bi-star"></i> Set as Primary';

            }

        });


        const selectedPhoto =
            document.querySelector(
                '[data-photo-id="' + photoId + '"]'
            );


        if (!selectedPhoto) {
            return;
        }


        selectedPhoto.classList.add("is-primary");


        const imageBox =
            selectedPhoto.querySelector(
                ".pl-existing-photo-image"
            );


        if (imageBox) {

            const badge =
                document.createElement("span");

            badge.className = "pl-primary-badge";

            badge.innerHTML =
                '<i class="bi bi-star-fill"></i> Primary';

            imageBox.appendChild(badge);

        }


        const action =
            selectedPhoto.querySelector(
                ".set-primary-action"
            );


        if (action) {

            action.disabled = true;

            action.className =
                "pl-photo-action primary-action";

            action.removeAttribute(
                "data-primary-photo"
            );

            action.innerHTML =
                '<i class="bi bi-star-fill"></i> Primary Photo';

        }


        showToast(
            "Primary Photo Updated",
            "This photograph is now your primary profile photo."
        );


        updatePhotoSummary();

    });


    /* =====================================================
       DELETE PHOTO
    ===================================================== */

    document.addEventListener("click", function (event) {

        const button = event.target.closest(
            "[data-delete-photo]"
        );

        if (!button) {
            return;
        }


        photoToDelete =
            button.getAttribute("data-delete-photo");


        if (deleteModal) {
            deleteModal.hidden = false;
        }

    });


    /* =====================================================
       CLOSE DELETE MODAL
    ===================================================== */

    document.querySelectorAll(
        "[data-close-delete]"
    ).forEach(function (element) {

        element.addEventListener("click", function () {

            if (deleteModal) {
                deleteModal.hidden = true;
            }

            photoToDelete = null;

        });

    });


    /* =====================================================
       CONFIRM DELETE
    ===================================================== */

    if (confirmDelete) {

        confirmDelete.addEventListener("click", function () {

            if (!photoToDelete) {
                return;
            }


            const photo =
                document.querySelector(
                    '[data-photo-id="' +
                    photoToDelete +
                    '"]'
                );


            if (photo) {

                const isPrimary =
                    photo.classList.contains("is-primary");


                if (isPrimary) {

                    showToast(
                        "Primary Photo",
                        "Set another photo as primary before deleting this photo."
                    );

                    deleteModal.hidden = true;

                    photoToDelete = null;

                    return;

                }


                photo.remove();

            }


            deleteModal.hidden = true;

            photoToDelete = null;


            updatePhotoSummary();


            showToast(
                "Photo Removed",
                "The selected photograph has been removed."
            );

        });

    }


    /* =====================================================
       PHOTO SUMMARY
    ===================================================== */

    function updatePhotoSummary() {

        const photos =
            document.querySelectorAll(
                ".pl-existing-photo"
            );


        const primary =
            document.querySelectorAll(
                ".pl-existing-photo.is-primary"
            );


        const approved =
            document.querySelectorAll(
                ".pl-photo-status.approved"
            );


        const pending =
            document.querySelectorAll(
                ".pl-photo-status.pending"
            );


        if (photoCount) {
            photoCount.textContent =
                photos.length;
        }


        if (primaryPhotoStatus) {
            primaryPhotoStatus.textContent =
                primary.length;
        }


        if (approvedPhotoCount) {
            approvedPhotoCount.textContent =
                approved.length;
        }


        if (pendingPhotoCount) {
            pendingPhotoCount.textContent =
                pending.length;
        }

    }


    /* =====================================================
       SAVE CHANGES
    ===================================================== */

    if (saveButton) {

        saveButton.addEventListener("click", function () {

            const privacy =
                document.querySelector(
                    'input[name="photo_privacy"]:checked'
                );


            const privacyValue =
                privacy ? privacy.value : "eligible";


            const settings = {
                privacy: privacyValue,
                selectedPhotos: selectedFiles.length,
                savedAt: new Date().toISOString()
            };


            /*
             * Demo/local storage only.
             * Replace this section with AJAX/PHP when
             * connecting to the database.
             */

            localStorage.setItem(
                "peoplelink_photo_settings",
                JSON.stringify(settings)
            );


            showToast(
                "Changes Saved",
                "Your photo settings have been updated."
            );

        });

    }


    /* =====================================================
       LOAD SAVED PRIVACY
    ===================================================== */

    function loadPrivacySettings() {

        const saved =
            localStorage.getItem(
                "peoplelink_photo_settings"
            );


        if (!saved) {
            return;
        }


        try {

            const data =
                JSON.parse(saved);


            if (data.privacy) {

                const radio =
                    document.querySelector(
                        'input[name="photo_privacy"][value="' +
                        data.privacy +
                        '"]'
                    );


                if (radio) {
                    radio.checked = true;
                }

            }

        } catch (error) {

            console.warn(
                "Unable to load photo settings."
            );

        }

    }


    /* =====================================================
       ESC KEY
    ===================================================== */

    document.addEventListener("keydown", function (event) {

        if (
            event.key === "Escape" &&
            deleteModal &&
            !deleteModal.hidden
        ) {

            deleteModal.hidden = true;

            photoToDelete = null;

        }

    });


    /* =====================================================
       INITIALIZE
    ===================================================== */

    loadPrivacySettings();

    updatePhotoSummary();

    renderSelectedFiles();

});