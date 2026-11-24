document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("plMarketplaceForm");
    const categoryButtons = document.querySelectorAll(".pl-category-card");
    const categoryInput = document.getElementById("listingCategory");
    const selectedCategoryText = document.getElementById("selectedCategoryText");

    const dynamicBlocks = {
        property: document.getElementById("propertyFields"),
        car: document.getElementById("carFields"),
        bike: document.getElementById("bikeFields"),
        electronics: document.getElementById("electronicsFields"),
        furniture: document.getElementById("otherFields"),
        machinery: document.getElementById("otherFields"),
        equipment: document.getElementById("otherFields"),
        other: document.getElementById("otherFields")
    };

    const description = document.getElementById("listingDescription");
    const descriptionCount = document.getElementById("descriptionCount");

    const imageInput = document.getElementById("listingImages");
    const dropZone = document.getElementById("imageDropZone");
    const imagePreview = document.getElementById("imagePreview");

    const previewModal = document.getElementById("listingPreviewModal");

    let selectedFiles = [];
    let primaryImageIndex = 0;


    /* =====================================================
       CATEGORY
    ===================================================== */

    function setCategory(category) {

        categoryInput.value = category;

        const names = {
            property: "Property",
            car: "Car",
            bike: "Bike",
            electronics: "Electronics",
            furniture: "Furniture",
            machinery: "Machinery",
            equipment: "Equipment",
            other: "Other Marketplace Item"
        };

        selectedCategoryText.textContent = names[category] || "Marketplace Item";

        categoryButtons.forEach(button => {
            button.classList.toggle(
                "active",
                button.dataset.category === category
            );
        });

        Object.values(dynamicBlocks).forEach(block => {
            if (block) {
                block.classList.remove("active");
            }
        });

        if (dynamicBlocks[category]) {
            dynamicBlocks[category].classList.add("active");
        }

        toggleListingType(category);
        toggleRentalFields(category);

        window.scrollTo({
            top: document.getElementById("listingFormSection").offsetTop - 20,
            behavior: "smooth"
        });
    }


    categoryButtons.forEach(button => {

        button.addEventListener("click", function () {
            setCategory(this.dataset.category);
        });

    });


    /* =====================================================
       LISTING TYPE
    ===================================================== */

    function toggleListingType(category) {

        const propertyOnly =
            document.querySelectorAll(".property-only-option");

        const productOnly =
            document.querySelectorAll(".product-only-option");

        const isProperty = category === "property";

        propertyOnly.forEach(item => {
            item.style.display = isProperty ? "" : "none";
        });

        productOnly.forEach(item => {
            item.style.display = isProperty ? "none" : "";
        });

        const checkedType = document.querySelector(
            'input[name="listing_type"]:checked'
        );

        if (
            checkedType &&
            (
                (!isProperty && ["rent"].includes(checkedType.value)) ||
                (isProperty && ["new", "used"].includes(checkedType.value))
            )
        ) {
            const saleRadio =
                document.querySelector('input[name="listing_type"][value="sale"]');

            if (saleRadio) {
                saleRadio.checked = true;
            }
        }
    }


    document.querySelectorAll(
        'input[name="listing_type"]'
    ).forEach(radio => {

        radio.addEventListener("change", function () {

            if (this.value === "rent") {
                toggleRentalFields(categoryInput.value);
            } else {
                document.querySelectorAll(".rental-field").forEach(field => {
                    field.style.display = "none";
                });
            }

        });

    });


    function toggleRentalFields(category) {

        const rentalFields =
            document.querySelectorAll(".rental-field");

        const listingType =
            document.querySelector('input[name="listing_type"]:checked');

        const isRental =
            category === "property" &&
            listingType &&
            listingType.value === "rent";

        rentalFields.forEach(field => {
            field.style.display = isRental ? "" : "none";
        });
    }


    /* =====================================================
       DESCRIPTION COUNTER
    ===================================================== */

    if (description) {

        description.addEventListener("input", function () {

            if (this.value.length > 1000) {
                this.value = this.value.substring(0, 1000);
            }

            descriptionCount.textContent = this.value.length;

        });

    }


    /* =====================================================
       VISIBILITY
    ===================================================== */

    const visibilityCards =
        document.querySelectorAll(".pl-visibility-card");

    visibilityCards.forEach(card => {

        card.addEventListener("click", function () {

            visibilityCards.forEach(item =>
                item.classList.remove("active")
            );

            this.classList.add("active");

            const radio = this.querySelector("input");

            if (radio) {
                radio.checked = true;
            }

            const communitySelect =
                document.querySelector(".community-select");

            if (communitySelect) {
                communitySelect.style.display =
                    radio && radio.value === "community"
                        ? "block"
                        : "none";
            }

        });

    });


    /* =====================================================
       IMAGE UPLOAD
    ===================================================== */

    if (imageInput) {

        imageInput.addEventListener("change", function () {

            addFiles(Array.from(this.files));

        });

    }


    if (dropZone) {

        dropZone.addEventListener("dragover", function (event) {

            event.preventDefault();
            dropZone.classList.add("dragover");

        });

        dropZone.addEventListener("dragleave", function () {

            dropZone.classList.remove("dragover");

        });

        dropZone.addEventListener("drop", function (event) {

            event.preventDefault();

            dropZone.classList.remove("dragover");

            addFiles(Array.from(event.dataTransfer.files));

        });

    }


    function addFiles(files) {

        files.forEach(file => {

            if (!file.type.startsWith("image/")) {
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                showToast(
                    "Each image should be less than 5 MB."
                );
                return;
            }

            selectedFiles.push(file);

        });

        if (selectedFiles.length > 12) {
            selectedFiles = selectedFiles.slice(0, 12);

            showToast(
                "Maximum 12 images can be uploaded."
            );
        }

        primaryImageIndex =
            Math.min(primaryImageIndex, selectedFiles.length - 1);

        renderImages();
        syncInputFiles();

    }


    function renderImages() {

        imagePreview.innerHTML = "";

        selectedFiles.forEach((file, index) => {

            const reader = new FileReader();

            reader.onload = function (event) {

                const item =
                    document.createElement("div");

                item.className =
                    "pl-image-item" +
                    (index === primaryImageIndex ? " primary" : "");

                item.innerHTML = `
                    <img src="${event.target.result}" alt="Listing Image">

                    <button type="button"
                            class="pl-image-remove"
                            title="Remove image">
                        <i class="bi bi-x"></i>
                    </button>

                    <button type="button"
                            class="pl-primary-image">
                        ${
                            index === primaryImageIndex
                                ? "Primary Image"
                                : "Set Primary"
                        }
                    </button>
                `;

                item.querySelector(".pl-image-remove")
                    .addEventListener("click", function () {

                        selectedFiles.splice(index, 1);

                        if (
                            primaryImageIndex >= selectedFiles.length
                        ) {
                            primaryImageIndex =
                                Math.max(0, selectedFiles.length - 1);
                        }

                        renderImages();
                        syncInputFiles();

                    });


                item.querySelector(".pl-primary-image")
                    .addEventListener("click", function () {

                        primaryImageIndex = index;

                        renderImages();

                    });


                imagePreview.appendChild(item);

            };

            reader.readAsDataURL(file);

        });

    }


    function syncInputFiles() {

        if (!imageInput) {
            return;
        }

        const dataTransfer = new DataTransfer();

        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        imageInput.files = dataTransfer.files;

    }


    /* =====================================================
       PREVIEW
    ===================================================== */

    window.previewListing = function () {

        const title =
            document.querySelector(
                'input[name="listing_title"]'
            ).value.trim();

        const price =
            document.querySelector(
                'input[name="expected_price"]'
            ).value.trim();

        const city =
            document.querySelector(
                'input[name="city"]'
            ).value.trim();

        const state =
            document.querySelector(
                'input[name="state"]'
            ).value.trim();

        const desc =
            description.value.trim();

        const category =
            selectedCategoryText.textContent;

        document.getElementById("previewCategory")
            .textContent = category;

        document.getElementById("previewTitle")
            .textContent =
            title || "Your Listing Title";

        document.getElementById("previewPrice")
            .textContent =
            price
                ? "₹ " + Number(price).toLocaleString("en-IN")
                : "₹ Price";

        document.getElementById("previewLocation")
            .innerHTML =
            `<i class="bi bi-geo-alt-fill"></i>
             ${city || "Location"}${state ? ", " + state : ""}`;

        document.getElementById("previewDescription")
            .textContent =
            desc ||
            "Your listing description will appear here.";

        const previewImage =
            document.getElementById("previewImage");

        previewImage.innerHTML =
            '<i class="bi bi-image"></i>';

        if (selectedFiles.length > 0) {

            const reader = new FileReader();

            reader.onload = function (event) {

                previewImage.innerHTML = `
                    <img src="${event.target.result}"
                         alt="Listing Preview">
                `;

            };

            reader.readAsDataURL(
                selectedFiles[primaryImageIndex]
            );

        }

        previewModal.classList.add("show");
        document.body.style.overflow = "hidden";

    };


    window.closeListingPreview = function () {

        previewModal.classList.remove("show");
        document.body.style.overflow = "";

    };


    previewModal.addEventListener("click", function (event) {

        if (event.target === previewModal) {
            closeListingPreview();
        }

    });


    /* =====================================================
       SAVE DRAFT
    ===================================================== */

    window.saveListingDraft = function () {

        const formData = new FormData(form);
        const draft = {};

        formData.forEach((value, key) => {

            if (typeof value === "string") {
                draft[key] = value;
            }

        });

        draft.category = categoryInput.value;

        localStorage.setItem(
            "peoplelink_marketplace_listing_draft",
            JSON.stringify(draft)
        );

        showToast("Listing draft saved successfully.");

    };


    function loadDraft() {

        const saved =
            localStorage.getItem(
                "peoplelink_marketplace_listing_draft"
            );

        if (!saved) {
            return;
        }

        try {

            const draft = JSON.parse(saved);

            Object.keys(draft).forEach(key => {

                const field =
                    form.querySelector(`[name="${key}"]`);

                if (!field) {
                    return;
                }

                if (
                    field.type === "radio" ||
                    field.type === "checkbox"
                ) {
                    return;
                }

                field.value = draft[key];

            });

            if (draft.category) {
                setCategory(draft.category);
            }

            if (description) {
                description.dispatchEvent(
                    new Event("input")
                );
            }

        } catch (error) {

            console.warn(
                "Could not load marketplace draft.",
                error
            );

        }

    }


    /* =====================================================
       FORM SUBMIT
    ===================================================== */

    form.addEventListener("submit", function (event) {

        event.preventDefault();

        const title =
            document.querySelector(
                'input[name="listing_title"]'
            ).value.trim();

        const contact =
            document.querySelector(
                'input[name="contact_person"]'
            ).value.trim();

        const mobile =
            document.querySelector(
                'input[name="mobile"]'
            ).value.trim();

        const agreement =
            document.getElementById("listingAgreement");

        if (!title) {

            showToast(
                "Please enter the listing title."
            );

            document.querySelector(
                'input[name="listing_title"]'
            ).focus();

            return;

        }

        if (!contact || !mobile) {

            showToast(
                "Please enter seller contact details."
            );

            return;

        }

        if (!agreement.checked) {

            showToast(
                "Please accept the listing guidelines."
            );

            return;

        }

        /*
         * Connect this FormData to your PHP/AJAX endpoint.
         */

        const formData = new FormData(form);

        formData.append(
            "primary_image_index",
            primaryImageIndex
        );

        formData.append(
            "status",
            "pending_approval"
        );

        console.log(
            "Marketplace Listing Form Data:",
            Object.fromEntries(formData.entries())
        );

        showToast(
            "Listing prepared for approval."
        );

    });


    /* =====================================================
       LOCATION
    ===================================================== */

    window.selectLocation = function () {

        showToast(
            "Map location selection can be connected to your map service."
        );

    };


    /* =====================================================
       MY LISTINGS
    ===================================================== */

    window.openMyListings = function () {

        showToast(
            "My Listings page can be connected here."
        );

    };


    /* =====================================================
       SCROLL
    ===================================================== */

    window.scrollToListingForm = function () {

        const section =
            document.getElementById(
                "listingFormSection"
            );

        if (section) {

            section.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

        }

    };


    /* =====================================================
       TOAST
    ===================================================== */

    let toastTimer;

    window.showToast = function (message) {

        const toast =
            document.getElementById(
                "listingToast"
            );

        const toastText =
            document.getElementById(
                "listingToastText"
            );

        toastText.textContent = message;

        toast.classList.add("show");

        clearTimeout(toastTimer);

        toastTimer = setTimeout(() => {

            toast.classList.remove("show");

        }, 3000);

    };


    /* =====================================================
       INITIAL STATE
    ===================================================== */

    setCategory("property");

    const communitySelect =
        document.querySelector(".community-select");

    if (communitySelect) {
        communitySelect.style.display = "block";
    }

    loadDraft();

});