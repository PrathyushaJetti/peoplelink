document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("partnerPreferencesForm");
    const resetButton = document.getElementById("resetPreferences");

    const toast = document.getElementById("partnerToast");

    const progress = document.getElementById("preferenceProgress");
    const percent = document.getElementById("preferencePercent");

    if (!form) {
        return;
    }


    /* =====================================================
       STORAGE KEY
    ===================================================== */

    const STORAGE_KEY = "peoplelink_partner_preferences";


    /* =====================================================
       ELEMENTS TO TRACK
    ===================================================== */

    const trackedFields = [
        "minAge",
        "maxAge",
        "minHeight",
        "maxHeight",
        "country",
        "state",
        "district",
        "city",
        "subCommunity",
        "minIncome",
        "maxIncome",
        "motherTongue",
        "familyBackground",
        "lifestyle",
        "otherPreferences"
    ];


    /* =====================================================
       SHOW TOAST
    ===================================================== */

    function showToast(message = "Your partner preferences have been updated.") {

        const toastText = toast.querySelector("span");

        if (toastText) {
            toastText.textContent = message;
        }

        toast.classList.add("show");

        clearTimeout(window.partnerToastTimer);

        window.partnerToastTimer = setTimeout(function () {
            toast.classList.remove("show");
        }, 3500);
    }


    /* =====================================================
       GET CHECKBOX VALUES
    ===================================================== */

    function getCheckboxValues(name) {

        return Array.from(
            form.querySelectorAll(
                'input[name="' + name + '"]:checked'
            )
        ).map(function (input) {
            return input.value;
        });

    }


    /* =====================================================
       GET FORM DATA
    ===================================================== */

    function getPreferences() {

        const data = {};

        trackedFields.forEach(function (id) {

            const element = document.getElementById(id);

            if (element) {
                data[id] = element.value;
            }

        });


        data.marital_status = getCheckboxValues("marital_status[]");

        data.education = getCheckboxValues("education[]");

        data.profession = getCheckboxValues("profession[]");


        const preferenceMode = form.querySelector(
            'input[name="preference_mode"]:checked'
        );

        data.preference_mode = preferenceMode
            ? preferenceMode.value
            : "flexible";


        return data;
    }


    /* =====================================================
       SAVE TO LOCAL STORAGE
    ===================================================== */

    function savePreferences() {

        const data = getPreferences();

        localStorage.setItem(
            STORAGE_KEY,
            JSON.stringify(data)
        );

    }


    /* =====================================================
       LOAD SAVED PREFERENCES
    ===================================================== */

    function loadPreferences() {

        const saved = localStorage.getItem(STORAGE_KEY);

        if (!saved) {
            updateProgress();
            return;
        }

        let data;

        try {
            data = JSON.parse(saved);
        } catch (error) {
            updateProgress();
            return;
        }


        trackedFields.forEach(function (id) {

            const element = document.getElementById(id);

            if (element && data[id] !== undefined) {
                element.value = data[id];
            }

        });


        if (Array.isArray(data.marital_status)) {

            data.marital_status.forEach(function (value) {

                const checkbox = form.querySelector(
                    'input[name="marital_status[]"][value="' +
                    CSS.escape(value) +
                    '"]'
                );

                if (checkbox) {
                    checkbox.checked = true;
                }

            });

        }


        if (Array.isArray(data.education)) {

            data.education.forEach(function (value) {

                const checkbox = form.querySelector(
                    'input[name="education[]"][value="' +
                    CSS.escape(value) +
                    '"]'
                );

                if (checkbox) {
                    checkbox.checked = true;
                }

            });

        }


        if (Array.isArray(data.profession)) {

            data.profession.forEach(function (value) {

                const checkbox = form.querySelector(
                    'input[name="profession[]"][value="' +
                    CSS.escape(value) +
                    '"]'
                );

                if (checkbox) {
                    checkbox.checked = true;
                }

            });

        }


        if (data.preference_mode) {

            const radio = form.querySelector(
                'input[name="preference_mode"][value="' +
                CSS.escape(data.preference_mode) +
                '"]'
            );

            if (radio) {
                radio.checked = true;
            }

        }


        updateProgress();

    }


    /* =====================================================
       UPDATE COMPLETION
    ===================================================== */

    function updateProgress() {

        let completed = 0;
        let total = 0;


        /* Basic select / text fields */

        trackedFields.forEach(function (id) {

            const element = document.getElementById(id);

            if (!element) {
                return;
            }

            total++;

            if (String(element.value).trim() !== "") {
                completed++;
            }

        });


        /* Checkbox groups */

        const checkboxGroups = [
            "marital_status[]",
            "education[]",
            "profession[]"
        ];


        checkboxGroups.forEach(function (name) {

            total++;

            const selected = form.querySelectorAll(
                'input[name="' + name + '"]:checked'
            );

            if (selected.length > 0) {
                completed++;
            }

        });


        /* Preference mode */

        total++;

        const selectedMode = form.querySelector(
            'input[name="preference_mode"]:checked'
        );

        if (selectedMode) {
            completed++;
        }


        const percentage = total > 0
            ? Math.round((completed / total) * 100)
            : 0;


        if (progress) {
            progress.style.width = percentage + "%";
        }

        if (percent) {
            percent.textContent = percentage + "%";
        }

    }


    /* =====================================================
       AGE VALIDATION
    ===================================================== */

    const minAge = document.getElementById("minAge");
    const maxAge = document.getElementById("maxAge");


    function validateAge() {

        if (
            minAge &&
            maxAge &&
            minAge.value &&
            maxAge.value
        ) {

            if (
                Number(minAge.value) >
                Number(maxAge.value)
            ) {

                maxAge.setCustomValidity(
                    "Maximum age must be greater than or equal to minimum age."
                );

                return false;

            }

        }

        if (maxAge) {
            maxAge.setCustomValidity("");
        }

        return true;
    }


    if (minAge) {
        minAge.addEventListener("change", function () {
            validateAge();
            updateProgress();
        });
    }


    if (maxAge) {
        maxAge.addEventListener("change", function () {
            validateAge();
            updateProgress();
        });
    }


    /* =====================================================
       HEIGHT VALIDATION
    ===================================================== */

    const minHeight = document.getElementById("minHeight");
    const maxHeight = document.getElementById("maxHeight");


    function validateHeight() {

        if (
            minHeight &&
            maxHeight &&
            minHeight.value &&
            maxHeight.value
        ) {

            if (
                Number(minHeight.value) >
                Number(maxHeight.value)
            ) {

                maxHeight.setCustomValidity(
                    "Maximum height must be greater than or equal to minimum height."
                );

                return false;

            }

        }

        if (maxHeight) {
            maxHeight.setCustomValidity("");
        }

        return true;
    }


    if (minHeight) {
        minHeight.addEventListener("change", function () {
            validateHeight();
            updateProgress();
        });
    }


    if (maxHeight) {
        maxHeight.addEventListener("change", function () {
            validateHeight();
            updateProgress();
        });
    }


    /* =====================================================
       INCOME VALIDATION
    ===================================================== */

    const minIncome = document.getElementById("minIncome");
    const maxIncome = document.getElementById("maxIncome");


    function validateIncome() {

        if (
            minIncome &&
            maxIncome &&
            minIncome.value &&
            maxIncome.value
        ) {

            if (
                Number(minIncome.value) >
                Number(maxIncome.value)
            ) {

                maxIncome.setCustomValidity(
                    "Maximum income must be greater than or equal to minimum income."
                );

                return false;

            }

        }

        if (maxIncome) {
            maxIncome.setCustomValidity("");
        }

        return true;
    }


    if (minIncome) {
        minIncome.addEventListener("change", function () {
            validateIncome();
            updateProgress();
        });
    }


    if (maxIncome) {
        maxIncome.addEventListener("change", function () {
            validateIncome();
            updateProgress();
        });
    }


    /* =====================================================
       FORM INPUT TRACKING
    ===================================================== */

    form.addEventListener("input", function () {
        updateProgress();
    });


    form.addEventListener("change", function () {
        updateProgress();
    });


    /* =====================================================
       SAVE FORM
    ===================================================== */

    form.addEventListener("submit", function (event) {

        event.preventDefault();


        if (!validateAge()) {

            maxAge.focus();

            return;
        }


        if (!validateHeight()) {

            maxHeight.focus();

            return;
        }


        if (!validateIncome()) {

            maxIncome.focus();

            return;
        }


        savePreferences();

        updateProgress();

        showToast(
            "Your partner preferences have been updated."
        );

    });


    /* =====================================================
       RESET
    ===================================================== */

    resetButton.addEventListener("click", function () {

        const confirmed = confirm(
            "Are you sure you want to reset all partner preferences?"
        );

        if (!confirmed) {
            return;
        }


        form.reset();

        localStorage.removeItem(STORAGE_KEY);


        /* Restore flexible preference */

        const flexible = form.querySelector(
            'input[name="preference_mode"][value="flexible"]'
        );

        if (flexible) {
            flexible.checked = true;
        }


        /* Clear validation */

        if (maxAge) {
            maxAge.setCustomValidity("");
        }

        if (maxHeight) {
            maxHeight.setCustomValidity("");
        }

        if (maxIncome) {
            maxIncome.setCustomValidity("");
        }


        updateProgress();

        showToast(
            "Partner preferences have been reset."
        );

    });


    /* =====================================================
       INITIAL LOAD
    ===================================================== */

    loadPreferences();

});