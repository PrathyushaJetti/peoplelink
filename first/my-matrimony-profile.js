document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       PEOPLELINK - MY MATRIMONY PROFILE
       Frontend / demo implementation
       ===================================================== */


    /* =====================================================
       ELEMENTS
       ===================================================== */

    const copyProfileId =
        document.getElementById("copyProfileId");

    const previewProfileBtn =
        document.getElementById("previewProfileBtn");

    const privacySettingsBtn =
        document.getElementById("privacySettingsBtn");

    const deactivateBtn =
        document.getElementById("deactivateBtn");


    /* MODALS */

    const previewModal =
        document.getElementById("previewModal");

    const previewOverlay =
        document.getElementById("previewOverlay");

    const closePreview =
        document.getElementById("closePreview");


    const privacyModal =
        document.getElementById("privacyModal");

    const privacyOverlay =
        document.getElementById("privacyOverlay");

    const closePrivacy =
        document.getElementById("closePrivacy");

    const savePrivacyBtn =
        document.getElementById("savePrivacyBtn");


    const deactivateModal =
        document.getElementById("deactivateModal");

    const deactivateOverlay =
        document.getElementById("deactivateOverlay");

    const cancelDeactivate =
        document.getElementById("cancelDeactivate");

    const confirmDeactivate =
        document.getElementById("confirmDeactivate");


    /* =====================================================
       PROFILE ID COPY
       ===================================================== */

    if (copyProfileId) {

        copyProfileId.addEventListener(
            "click",
            function () {

                const profileId =
                    "PLM10245";


                if (
                    navigator.clipboard &&
                    navigator.clipboard.writeText
                ) {

                    navigator.clipboard.writeText(
                        profileId
                    ).then(function () {

                        showToast(
                            "Profile ID copied successfully."
                        );

                    }).catch(function () {

                        showToast(
                            "Profile ID: " + profileId
                        );

                    });

                } else {

                    showToast(
                        "Profile ID: " + profileId
                    );

                }

            }
        );

    }


    /* =====================================================
       GENERIC MODAL FUNCTIONS
       ===================================================== */

    function openModal(modal) {

        if (!modal) return;

        modal.classList.add("active");

        document.body.style.overflow =
            "hidden";

    }


    function closeModal(modal) {

        if (!modal) return;

        modal.classList.remove("active");

        document.body.style.overflow =
            "";

    }


    /* =====================================================
       PREVIEW
       ===================================================== */

    if (previewProfileBtn) {

        previewProfileBtn.addEventListener(
            "click",
            function () {

                openModal(previewModal);

            }
        );

    }


    if (closePreview) {

        closePreview.addEventListener(
            "click",
            function () {

                closeModal(previewModal);

            }
        );

    }


    if (previewOverlay) {

        previewOverlay.addEventListener(
            "click",
            function () {

                closeModal(previewModal);

            }
        );

    }


    /* =====================================================
       PRIVACY SETTINGS
       ===================================================== */

    if (privacySettingsBtn) {

        privacySettingsBtn.addEventListener(
            "click",
            function () {

                openModal(privacyModal);

            }
        );

    }


    if (closePrivacy) {

        closePrivacy.addEventListener(
            "click",
            function () {

                closeModal(privacyModal);

            }
        );

    }


    if (privacyOverlay) {

        privacyOverlay.addEventListener(
            "click",
            function () {

                closeModal(privacyModal);

            }
        );

    }


    if (savePrivacyBtn) {

        savePrivacyBtn.addEventListener(
            "click",
            function () {

                /*
                 * Production:
                 * Send privacy settings to PHP/AJAX.
                 */

                closeModal(
                    privacyModal
                );

                showToast(
                    "Privacy settings saved successfully."
                );

            }
        );

    }


    /* =====================================================
       DEACTIVATE PROFILE
       ===================================================== */

    if (deactivateBtn) {

        deactivateBtn.addEventListener(
            "click",
            function () {

                openModal(
                    deactivateModal
                );

            }
        );

    }


    if (deactivateOverlay) {

        deactivateOverlay.addEventListener(
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


    if (confirmDeactivate) {

        confirmDeactivate.addEventListener(
            "click",
            function () {

                /*
                 * Production:
                 * Submit AJAX/PHP request to change
                 * profile status to inactive.
                 */

                closeModal(
                    deactivateModal
                );

                updateProfileStatus();

                showToast(
                    "Your profile has been deactivated."
                );

            }
        );

    }


    /* =====================================================
       PROFILE STATUS DEMO
       ===================================================== */

    function updateProfileStatus() {

        const heroStatus =
            document.getElementById(
                "heroProfileStatus"
            );

        if (heroStatus) {

            heroStatus.textContent =
                "Inactive Profile";

        }


        const statusDot =
            document.querySelector(
                ".pl-mmp-status-dot"
            );

        if (statusDot) {

            statusDot.style.background =
                "#f7941d";

        }

    }


    /* =====================================================
       TOAST
       ===================================================== */

    function showToast(message) {

        const existing =
            document.querySelector(
                ".pl-mmp-toast"
            );

        if (existing) {

            existing.remove();

        }


        const toast =
            document.createElement(
                "div"
            );

        toast.className =
            "pl-mmp-toast";


        toast.innerHTML = `

            <i class="bi bi-check-circle-fill"></i>

            <span>
                ${message}
            </span>

        `;


        document.body.appendChild(
            toast
        );


        requestAnimationFrame(
            function () {

                toast.classList.add(
                    "show"
                );

            }
        );


        setTimeout(
            function () {

                toast.classList.remove(
                    "show"
                );

                setTimeout(
                    function () {

                        toast.remove();

                    },
                    250
                );

            },
            3000
        );

    }


    /* =====================================================
       TOAST CSS
       ===================================================== */

    const toastStyle =
        document.createElement(
            "style"
        );

    toastStyle.textContent = `

        .pl-mmp-toast {

            position: fixed;

            right: 22px;
            bottom: 22px;

            z-index: 10001;

            display: flex;

            align-items: center;

            gap: 8px;

            max-width: 370px;

            padding: 13px 17px;

            border-radius: 12px;

            background: #073b70;

            color: #fff;

            box-shadow:
                0 12px 30px rgba(0,0,0,.18);

            font-size: 12px;

            font-weight: 600;

            opacity: 0;

            transform:
                translateY(15px);

            transition: .25s ease;

        }

        .pl-mmp-toast.show {

            opacity: 1;

            transform:
                translateY(0);

        }

        .pl-mmp-toast i {

            color: #42b72a;

            font-size: 16px;

        }

        @media(max-width:600px) {

            .pl-mmp-toast {

                left: 15px;
                right: 15px;

                bottom: 15px;

                max-width: none;

            }

        }

    `;

    document.head.appendChild(
        toastStyle
    );


    /* =====================================================
       ESC KEY
       ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (
                event.key === "Escape"
            ) {

                closeModal(
                    previewModal
                );

                closeModal(
                    privacyModal
                );

                closeModal(
                    deactivateModal
                );

            }

        }
    );

});