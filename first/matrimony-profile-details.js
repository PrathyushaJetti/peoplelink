window.PL_API_URL = window.PL_API_URL || "/peoplelink/matrimoney/api.php";

window.plCsrf = window.plCsrf || (function () {
    let cached = null;
    return function () {
        if (cached) return Promise.resolve(cached);
        return fetch(window.PL_API_URL + "?action=session", { credentials: "same-origin" })
            .then(function (r) { return r.json(); })
            .then(function (s) { cached = s; return s; });
    };
})();

window.plProfileId = function (codeOrId) {
    codeOrId = String(codeOrId || "").trim();
    if (/^\d+$/.test(codeOrId)) return Promise.resolve(parseInt(codeOrId, 10));
    return fetch(window.PL_API_URL + "?action=profile&code=" + encodeURIComponent(codeOrId), { credentials: "same-origin" })
        .then(function (r) { return r.json(); })
        .then(function (res) {
            if (res && res.ok && res.profile) return parseInt(res.profile.id, 10);
            throw new Error((res && res.error) || "Profile not found.");
        });
};

window.plPost = function (action, fields) {
    return window.plCsrf().then(function (s) {
        if (!s.logged_in) {
            return { ok: false, error: "Please login to continue.", login: true };
        }
        const fd = new FormData();
        fd.append("action", action);
        fd.append("csrf", s.csrf);
        Object.keys(fields || {}).forEach(function (k) { fd.append(k, fields[k]); });
        return fetch(window.PL_API_URL, { method: "POST", body: fd, credentials: "same-origin" })
            .then(function (r) { return r.json(); });
    });
};

window.plSendInterest = function (codeOrId, message) {
    return window.plProfileId(codeOrId).then(function (id) {
        return window.plPost("send_interest", { profile_id: id, message: message || "" });
    }).catch(function (e) { return { ok: false, error: e.message || "Could not send interest." }; });
};

window.plToggleSave = function (codeOrId) {
    return window.plProfileId(codeOrId).then(function (id) {
        return window.plPost("toggle_save", { profile_id: id });
    }).catch(function (e) { return { ok: false, error: e.message || "Could not save profile." }; });
};

document.addEventListener("DOMContentLoaded", function () {

    const page = document.querySelector(
        ".pl-mp-details-page"
    );

    if (!page) {
        return;
    }


    /* =====================================================
       ELEMENTS
    ====================================================== */

    const mainPhoto =
        document.getElementById("plMpMainPhoto");

    const galleryItems =
        page.querySelectorAll(
            ".pl-mp-gallery-item"
        );

    const saveBtn =
        document.getElementById("plMpSaveBtn");

    const interestBtn =
        document.getElementById("plMpInterestBtn");

    const contactBtn =
        document.getElementById("plMpContactBtn");

    const sideInterest =
        document.getElementById("plMpSideInterest");

    const sideContact =
        document.getElementById("plMpSideContact");

    const sideSave =
        document.getElementById("plMpSideSave");

    const reportBtn =
        document.getElementById("plMpReportBtn");

    const blockBtn =
        document.getElementById("plMpBlockBtn");

    const similarBtn =
        document.getElementById("plMpSimilarBtn");

    const viewPhotosBtn =
        document.getElementById("plMpViewPhotos");


    /* =====================================================
       TOAST
    ====================================================== */

    let toastTimer;

    function showToast(message) {

        const toast =
            document.getElementById("plMpToast");

        const text =
            document.getElementById("plMpToastText");

        if (!toast || !text) {
            return;
        }

        text.textContent = message;

        toast.classList.add("show");

        clearTimeout(toastTimer);

        toastTimer = setTimeout(function () {

            toast.classList.remove("show");

        }, 3000);

    }


    /* =====================================================
       GALLERY
    ====================================================== */

    galleryItems.forEach(function (item) {

        item.addEventListener(
            "click",
            function () {

                const image =
                    this.dataset.image;

                if (image && mainPhoto) {

                    mainPhoto.src = image;

                }


                galleryItems.forEach(
                    function (galleryItem) {

                        galleryItem.classList.remove(
                            "active"
                        );

                    }
                );


                this.classList.add("active");

            }
        );

    });


    /* =====================================================
       VIEW PHOTOS
    ====================================================== */

    if (viewPhotosBtn) {

        viewPhotosBtn.addEventListener(
            "click",
            function () {

                if (galleryItems.length > 0) {

                    galleryItems[0].click();

                }

                document.querySelector(
                    ".pl-mp-photo-gallery"
                ).scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });

            }
        );

    }


    /* =====================================================
       SAVE PROFILE
    ====================================================== */

    function saveProfile() {
        const pid = new URLSearchParams(window.location.search).get("id");
        window.plToggleSave(pid).then(function (res) {
            if (res.ok) {
                showToast(res.message || "Done.");
                updateSaveButtons(!!res.saved);
            } else {
                showToast(res.error || "Could not save profile.");
                if (res.login) { setTimeout(function () { window.location.href = "login.php"; }, 1200); }
            }
        });
    }


    function updateSaveButtons(saved) {

        const buttons = [
            saveBtn,
            sideSave
        ];


        buttons.forEach(function (button) {

            if (!button) {
                return;
            }


            if (saved) {

                button.innerHTML =
                    '<i class="bi bi-bookmark-fill"></i> Saved';

            } else {

                button.innerHTML =
                    '<i class="bi bi-bookmark"></i> Save Profile';

            }

        });

    }


    if (saveBtn) {

        saveBtn.addEventListener(
            "click",
            saveProfile
        );

    }


    if (sideSave) {

        sideSave.addEventListener(
            "click",
            saveProfile
        );

    }


    const existingSaved =
        localStorage.getItem(
            "peoplelink_saved_matrimony_profile"
        );


    if (
        existingSaved ===
        "PL-MAT-10245"
    ) {

        updateSaveButtons(true);

    }


    /* =====================================================
       INTEREST MODAL
    ====================================================== */

    const modal =
        document.getElementById(
            "plMpActionModal"
        );

    const modalTitle =
        document.getElementById(
            "plMpModalTitle"
        );

    const modalText =
        document.getElementById(
            "plMpModalText"
        );

    const modalSubmit =
        document.getElementById(
            "plMpModalSubmit"
        );

    const modalMessage =
        document.getElementById(
            "plMpInterestMessage"
        );

    const modalClose =
        document.getElementById(
            "plMpModalClose"
        );


    function openInterestModal() {

        if (!modal) {
            return;
        }


        modalTitle.textContent =
            "Express Interest";

        modalText.textContent =
            "Send an interest request to this profile. You can include a short respectful message.";

        modalSubmit.innerHTML =
            '<i class="bi bi-send-fill"></i> Send Interest';

        modal.classList.add("show");

    }


    if (interestBtn) {

        interestBtn.addEventListener(
            "click",
            openInterestModal
        );

    }


    if (sideInterest) {

        sideInterest.addEventListener(
            "click",
            openInterestModal
        );

    }


    /* =====================================================
       CONTACT REQUEST
    ====================================================== */

    function openContactRequest() {

        if (!modal) {
            return;
        }


        modalTitle.textContent =
            "Request Contact";

        modalText.textContent =
            "Your request will be handled according to the member's privacy settings, matrimony package and PeopleLink rules.";

        modalSubmit.innerHTML =
            '<i class="bi bi-person-lines-fill"></i> Request Contact';

        modal.classList.add("show");

    }


    if (contactBtn) {

        contactBtn.addEventListener(
            "click",
            openContactRequest
        );

    }


    if (sideContact) {

        sideContact.addEventListener(
            "click",
            openContactRequest
        );

    }


    /* =====================================================
       MODAL SUBMIT
    ====================================================== */

    if (modalSubmit) {

        modalSubmit.addEventListener(
            "click",
            function () {

                const title =
                    modalTitle.textContent;


                if (
                    title ===
                    "Request Contact"
                ) {

                    showToast(
                        "Contact request submitted for review."
                    );

                } else {

                    const pid = new URLSearchParams(window.location.search).get("id");
                    window.plSendInterest(pid, "").then(function (res) {
                        showToast(res.ok ? (res.message || "Interest sent successfully.") : (res.error || "Could not send interest."));
                        if (res.login) { setTimeout(function () { window.location.href = "login.php"; }, 1200); }
                    });

                }


                closeModal();

            }
        );

    }


    /* =====================================================
       CLOSE MODAL
    ====================================================== */

    function closeModal() {

        if (modal) {

            modal.classList.remove(
                "show"
            );

        }

        if (modalMessage) {

            modalMessage.value = "";

        }

    }


    if (modalClose) {

        modalClose.addEventListener(
            "click",
            closeModal
        );

    }


    if (modal) {

        modal.addEventListener(
            "click",
            function (event) {

                if (
                    event.target === modal
                ) {

                    closeModal();

                }

            }
        );

    }


    document.addEventListener(
        "keydown",
        function (event) {

            if (
                event.key === "Escape"
            ) {

                closeModal();

            }

        }
    );


    /* =====================================================
       REPORT PROFILE
    ====================================================== */

    if (reportBtn) {

        reportBtn.addEventListener(
            "click",
            function () {

                const confirmed =
                    window.confirm(
                        "Do you want to report this profile for admin review?"
                    );


                if (confirmed) {

                    showToast(
                        "Profile reported for admin review."
                    );

                }

            }
        );

    }


    /* =====================================================
       BLOCK PROFILE
    ====================================================== */

    if (blockBtn) {

        blockBtn.addEventListener(
            "click",
            function () {

                const confirmed =
                    window.confirm(
                        "Do you want to block this profile?"
                    );


                if (confirmed) {

                    showToast(
                        "Profile blocked successfully."
                    );

                }

            }
        );

    }


    /* =====================================================
       SIMILAR PROFILES
    ====================================================== */

    if (similarBtn) {

        similarBtn.addEventListener(
            "click",
            function () {

                showToast(
                    "Loading similar profiles..."
                );


                setTimeout(function () {

                    /*
                     * Replace this with your actual
                     * similar profile page URL.
                     */

                    window.location.href =
                        "matrimony.php";

                }, 700);

            }
        );

    }


});