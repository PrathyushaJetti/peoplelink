document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       STORAGE
    ====================================================== */

    const SETTINGS_KEY =
        "peoplelink_matrimony_privacy_settings";

    const BLOCKED_KEY =
        "peoplelink_matrimony_blocked_profiles";


    /* =====================================================
       DEFAULT SETTINGS
    ====================================================== */

    const defaultSettings = {

        profileVisibility: "visible",

        photoPrivacy: "eligible",

        receiveInterests: true,

        allowContactRequests: true,

        profileRecommendations: true,

        notifyInterests: true,

        notifyContacts: true,

        notifyPackages: true,

        notifyProfile: true,

        deactivated: false

    };


    let settings = {
        ...defaultSettings
    };


    /* =====================================================
       LOAD SETTINGS
    ====================================================== */

    const savedSettings =
        localStorage.getItem(
            SETTINGS_KEY
        );


    if (savedSettings) {

        try {

            settings = {
                ...defaultSettings,
                ...JSON.parse(savedSettings)
            };

        } catch (error) {

            settings = {
                ...defaultSettings
            };

        }

    }


    /* =====================================================
       ELEMENTS
    ====================================================== */

    const saveSettingsBtn =
        document.getElementById(
            "saveSettingsBtn"
        );

    const manageVisibilityBtn =
        document.getElementById(
            "manageVisibilityBtn"
        );

    const viewBlockedProfilesBtn =
        document.getElementById(
            "viewBlockedProfilesBtn"
        );

    const deactivateProfileBtn =
        document.getElementById(
            "deactivateProfileBtn"
        );


    /* =====================================================
       PROFILE VISIBILITY
    ====================================================== */

    const profileVisibilityInputs =
        document.querySelectorAll(
            'input[name="profile_visibility"]'
        );


    /* =====================================================
       PHOTO PRIVACY
    ====================================================== */

    const photoPrivacyInputs =
        document.querySelectorAll(
            'input[name="photo_privacy"]'
        );


    /* =====================================================
       TOGGLES
    ====================================================== */

    const receiveInterests =
        document.getElementById(
            "receiveInterests"
        );

    const allowContactRequests =
        document.getElementById(
            "allowContactRequests"
        );

    const profileRecommendations =
        document.getElementById(
            "profileRecommendations"
        );

    const notifyInterests =
        document.getElementById(
            "notifyInterests"
        );

    const notifyContacts =
        document.getElementById(
            "notifyContacts"
        );

    const notifyPackages =
        document.getElementById(
            "notifyPackages"
        );

    const notifyProfile =
        document.getElementById(
            "notifyProfile"
        );


    /* =====================================================
       SIDEBAR
    ====================================================== */

    const sidebarProfileVisibility =
        document.getElementById(
            "sidebarProfileVisibility"
        );

    const sidebarPhotoPrivacy =
        document.getElementById(
            "sidebarPhotoPrivacy"
        );


    /* =====================================================
       MODALS
    ====================================================== */

    const visibilityModal =
        document.getElementById(
            "visibilityModal"
        );

    const visibilityModalClose =
        document.getElementById(
            "visibilityModalClose"
        );

    const blockedProfilesModal =
        document.getElementById(
            "blockedProfilesModal"
        );

    const blockedProfilesModalClose =
        document.getElementById(
            "blockedProfilesModalClose"
        );

    const deactivateModal =
        document.getElementById(
            "deactivateModal"
        );

    const deactivateModalClose =
        document.getElementById(
            "deactivateModalClose"
        );

    const cancelDeactivate =
        document.getElementById(
            "cancelDeactivate"
        );

    const confirmDeactivate =
        document.getElementById(
            "confirmDeactivate"
        );


    /* =====================================================
       TOAST
    ====================================================== */

    const privacyToast =
        document.getElementById(
            "privacyToast"
        );

    const privacyToastMessage =
        document.getElementById(
            "privacyToastMessage"
        );


    let toastTimer;


    function showToast(message) {

        if (!privacyToast) {
            return;
        }

        privacyToastMessage.textContent =
            message;

        privacyToast.classList.add(
            "show"
        );

        clearTimeout(toastTimer);

        toastTimer = setTimeout(
            function () {

                privacyToast.classList.remove(
                    "show"
                );

            },
            2800
        );

    }


    /* =====================================================
       SAVE SETTINGS
    ====================================================== */

    function saveSettings() {

        localStorage.setItem(
            SETTINGS_KEY,
            JSON.stringify(settings)
        );

    }


    /* =====================================================
       PROFILE VISIBILITY LABEL
    ====================================================== */

    function getVisibilityLabel(value) {

        switch (value) {

            case "hidden":
                return "Temporarily Hidden";

            case "deactivated":
                return "Deactivated";

            default:
                return "Visible";

        }

    }


    /* =====================================================
       PHOTO PRIVACY LABEL
    ====================================================== */

    function getPhotoPrivacyLabel(value) {

        switch (value) {

            case "interest":
                return "After Interest";

            case "contact":
                return "After Contact";

            case "private":
                return "Private";

            default:
                return "Eligible Users";

        }

    }


    /* =====================================================
       UPDATE SIDEBAR
    ====================================================== */

    function updateSidebar() {

        if (sidebarProfileVisibility) {

            sidebarProfileVisibility.textContent =
                getVisibilityLabel(
                    settings.profileVisibility
                );

        }


        if (sidebarPhotoPrivacy) {

            sidebarPhotoPrivacy.textContent =
                getPhotoPrivacyLabel(
                    settings.photoPrivacy
                );

        }

    }


    /* =====================================================
       RESTORE RADIO BUTTONS
    ====================================================== */

    function restoreRadioButtons() {

        profileVisibilityInputs.forEach(
            function (input) {

                input.checked =
                    input.value ===
                    settings.profileVisibility;

            }
        );


        photoPrivacyInputs.forEach(
            function (input) {

                input.checked =
                    input.value ===
                    settings.photoPrivacy;

            }
        );

    }


    /* =====================================================
       RESTORE TOGGLES
    ====================================================== */

    function restoreToggles() {

        if (receiveInterests) {

            receiveInterests.checked =
                settings.receiveInterests;

        }

        if (allowContactRequests) {

            allowContactRequests.checked =
                settings.allowContactRequests;

        }

        if (profileRecommendations) {

            profileRecommendations.checked =
                settings.profileRecommendations;

        }

        if (notifyInterests) {

            notifyInterests.checked =
                settings.notifyInterests;

        }

        if (notifyContacts) {

            notifyContacts.checked =
                settings.notifyContacts;

        }

        if (notifyPackages) {

            notifyPackages.checked =
                settings.notifyPackages;

        }

        if (notifyProfile) {

            notifyProfile.checked =
                settings.notifyProfile;

        }

    }


    /* =====================================================
       COLLECT SETTINGS
    ====================================================== */

    function collectSettings() {

        const selectedProfileVisibility =
            document.querySelector(
                'input[name="profile_visibility"]:checked'
            );


        const selectedPhotoPrivacy =
            document.querySelector(
                'input[name="photo_privacy"]:checked'
            );


        if (selectedProfileVisibility) {

            settings.profileVisibility =
                selectedProfileVisibility.value;

        }


        if (selectedPhotoPrivacy) {

            settings.photoPrivacy =
                selectedPhotoPrivacy.value;

        }


        settings.receiveInterests =
            receiveInterests
                ? receiveInterests.checked
                : true;


        settings.allowContactRequests =
            allowContactRequests
                ? allowContactRequests.checked
                : true;


        settings.profileRecommendations =
            profileRecommendations
                ? profileRecommendations.checked
                : true;


        settings.notifyInterests =
            notifyInterests
                ? notifyInterests.checked
                : true;


        settings.notifyContacts =
            notifyContacts
                ? notifyContacts.checked
                : true;


        settings.notifyPackages =
            notifyPackages
                ? notifyPackages.checked
                : true;


        settings.notifyProfile =
            notifyProfile
                ? notifyProfile.checked
                : true;

    }


    /* =====================================================
       RADIO CHANGE
    ====================================================== */

    profileVisibilityInputs.forEach(
        function (input) {

            input.addEventListener(
                "change",
                function () {

                    settings.profileVisibility =
                        input.value;

                    updateSidebar();

                }
            );

        }
    );


    photoPrivacyInputs.forEach(
        function (input) {

            input.addEventListener(
                "change",
                function () {

                    settings.photoPrivacy =
                        input.value;

                    updateSidebar();

                }
            );

        }
    );


    /* =====================================================
       MANAGE VISIBILITY MODAL
    ====================================================== */

    function openModal(modal) {

        if (!modal) {
            return;
        }

        modal.classList.add(
            "active"
        );

        modal.setAttribute(
            "aria-hidden",
            "false"
        );

        document.body.style.overflow =
            "hidden";

    }


    function closeModal(modal) {

        if (!modal) {
            return;
        }

        modal.classList.remove(
            "active"
        );

        modal.setAttribute(
            "aria-hidden",
            "true"
        );

        document.body.style.overflow =
            "";

    }


    if (manageVisibilityBtn) {

        manageVisibilityBtn.addEventListener(
            "click",
            function () {

                openModal(
                    visibilityModal
                );

            }
        );

    }


    if (visibilityModalClose) {

        visibilityModalClose.addEventListener(
            "click",
            function () {

                closeModal(
                    visibilityModal
                );

            }
        );

    }


    /* =====================================================
       VISIBILITY MODAL OPTIONS
    ====================================================== */

    document.querySelectorAll(
        ".pl-modal-option[data-visibility]"
    ).forEach(
        function (button) {

            button.addEventListener(
                "click",
                function () {

                    settings.profileVisibility =
                        button.dataset.visibility;


                    profileVisibilityInputs.forEach(
                        function (input) {

                            input.checked =
                                input.value ===
                                settings.profileVisibility;

                        }
                    );


                    updateSidebar();

                    closeModal(
                        visibilityModal
                    );

                    showToast(
                        "Profile visibility updated."
                    );

                }
            );

        }
    );


    /* =====================================================
       BLOCKED PROFILES
    ====================================================== */

    if (viewBlockedProfilesBtn) {

        viewBlockedProfilesBtn.addEventListener(
            "click",
            function () {

                openModal(
                    blockedProfilesModal
                );

            }
        );

    }


    if (blockedProfilesModalClose) {

        blockedProfilesModalClose.addEventListener(
            "click",
            function () {

                closeModal(
                    blockedProfilesModal
                );

            }
        );

    }


    /* =====================================================
       UNBLOCK
    ====================================================== */

    document.querySelectorAll(
        ".pl-unblock-small"
    ).forEach(
        function (button) {

            button.addEventListener(
                "click",
                function () {

                    const name =
                        button.dataset.name;

                    button.textContent =
                        "Unblocked";

                    button.disabled =
                        true;

                    button.style.opacity =
                        ".6";

                    showToast(
                        name +
                        " has been unblocked."
                    );

                }
            );

        }
    );


    /* =====================================================
       DEACTIVATE MODAL
    ====================================================== */

    if (deactivateProfileBtn) {

        deactivateProfileBtn.addEventListener(
            "click",
            function () {

                openModal(
                    deactivateModal
                );

            }
        );

    }


    if (deactivateModalClose) {

        deactivateModalClose.addEventListener(
            "click",
            function () {

                closeModal(
                    deactivateModal
                );

            }
        );

    }


    if (cancelDeactivate) {

        cancelDeactivate.addEventListener(
            "click",
            function () {

                closeModal(
                    deactivateModal
                );

            }
        );

    }


    /* =====================================================
       CONFIRM DEACTIVATION
    ====================================================== */

    if (confirmDeactivate) {

        confirmDeactivate.addEventListener(
            "click",
            function () {

                settings.profileVisibility =
                    "deactivated";

                settings.deactivated =
                    true;


                profileVisibilityInputs.forEach(
                    function (input) {

                        input.checked =
                            input.value ===
                            "deactivated";

                    }
                );


                saveSettings();

                updateSidebar();

                closeModal(
                    deactivateModal
                );

                showToast(
                    "Matrimony profile deactivated."
                );

            }
        );

    }


    /* =====================================================
       SAVE CHANGES
    ====================================================== */

    if (saveSettingsBtn) {

        saveSettingsBtn.addEventListener(
            "click",
            function () {

                collectSettings();

                saveSettings();

                updateSidebar();

                showToast(
                    "Privacy settings saved successfully."
                );

            }
        );

    }


    /* =====================================================
       MODAL OVERLAYS
    ====================================================== */

    document.querySelectorAll(
        ".pl-privacy-modal-overlay"
    ).forEach(
        function (overlay) {

            overlay.addEventListener(
                "click",
                function () {

                    const modal =
                        overlay.closest(
                            ".pl-privacy-modal"
                        );

                    closeModal(modal);

                }
            );

        }
    );


    /* =====================================================
       ESCAPE KEY
    ====================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (event.key !== "Escape") {
                return;
            }

            closeModal(
                visibilityModal
            );

            closeModal(
                blockedProfilesModal
            );

            closeModal(
                deactivateModal
            );

        }
    );


    /* =====================================================
       INITIALIZE
    ====================================================== */

    restoreRadioButtons();

    restoreToggles();

    updateSidebar();

});