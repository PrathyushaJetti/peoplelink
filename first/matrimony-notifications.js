document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       ELEMENTS
    ====================================================== */

    const notificationList =
        document.getElementById("notificationList");

    const notifications =
        Array.from(
            document.querySelectorAll(".pl-notification-item")
        );

    const filterButtons =
        document.querySelectorAll(
            ".pl-notification-filter"
        );

    const totalNotifications =
        document.getElementById(
            "totalNotifications"
        );

    const unreadNotifications =
        document.getElementById(
            "unreadNotifications"
        );

    const heroUnreadCount =
        document.getElementById(
            "heroUnreadCount"
        );

    const sidebarUnreadCount =
        document.getElementById(
            "sidebarUnreadCount"
        );

    const sidebarTotalCount =
        document.getElementById(
            "sidebarTotalCount"
        );

    const markAllReadBtn =
        document.getElementById(
            "markAllReadBtn"
        );

    const notificationEmpty =
        document.getElementById(
            "notificationEmpty"
        );

    const showAllNotifications =
        document.getElementById(
            "showAllNotifications"
        );

    const viewAllNotifications =
        document.getElementById(
            "viewAllNotifications"
        );


    /* =====================================================
       MODAL
    ====================================================== */

    const notificationModal =
        document.getElementById(
            "notificationModal"
        );

    const notificationModalClose =
        document.getElementById(
            "notificationModalClose"
        );

    const modalCloseBtn =
        document.getElementById(
            "modalCloseBtn"
        );

    const modalNotificationTitle =
        document.getElementById(
            "modalNotificationTitle"
        );

    const modalNotificationMessage =
        document.getElementById(
            "modalNotificationMessage"
        );

    const modalNotificationTime =
        document.getElementById(
            "modalNotificationTime"
        );

    const modalNotificationIcon =
        document.getElementById(
            "modalNotificationIcon"
        );

    const modalViewLink =
        document.getElementById(
            "modalViewLink"
        );


    /* =====================================================
       PREFERENCES
    ====================================================== */

    const managePreferencesBtn =
        document.getElementById(
            "managePreferencesBtn"
        );

    const preferencesModal =
        document.getElementById(
            "preferencesModal"
        );

    const preferencesModalClose =
        document.getElementById(
            "preferencesModalClose"
        );

    const preferencesCancelBtn =
        document.getElementById(
            "preferencesCancelBtn"
        );

    const savePreferencesBtn =
        document.getElementById(
            "savePreferencesBtn"
        );

    const preferenceToggles =
        document.querySelectorAll(
            ".pl-preference-toggle"
        );


    /* =====================================================
       TOAST
    ====================================================== */

    const notificationToast =
        document.getElementById(
            "notificationToast"
        );

    const notificationToastMessage =
        document.getElementById(
            "notificationToastMessage"
        );


    /* =====================================================
       STORAGE
    ====================================================== */

    const READ_STORAGE =
        "peoplelink_matrimony_notifications_read";

    const PREFERENCE_STORAGE =
        "peoplelink_matrimony_notification_preferences";


    let readNotifications = {};

    let savedReadState =
        localStorage.getItem(
            READ_STORAGE
        );

    if (savedReadState) {

        try {

            readNotifications =
                JSON.parse(savedReadState);

        } catch (error) {

            readNotifications = {};

        }

    }


    /* =====================================================
       TOAST
    ====================================================== */

    let toastTimer;

    function showToast(message) {

        if (!notificationToast) {
            return;
        }

        notificationToastMessage.textContent =
            message;

        notificationToast.classList.add(
            "show"
        );

        clearTimeout(toastTimer);

        toastTimer = setTimeout(function () {

            notificationToast.classList.remove(
                "show"
            );

        }, 2800);

    }


    /* =====================================================
       UPDATE COUNTS
    ====================================================== */

    function updateCounts() {

        const total =
            notifications.length;

        let unread = 0;

        notifications.forEach(function (item) {

            const isRead =
                item.dataset.read === "true";

            if (!isRead) {
                unread++;
            }

        });


        if (totalNotifications) {

            totalNotifications.textContent =
                total;

        }


        if (unreadNotifications) {

            unreadNotifications.textContent =
                unread;

        }


        if (heroUnreadCount) {

            heroUnreadCount.textContent =
                unread;

        }


        if (sidebarUnreadCount) {

            sidebarUnreadCount.textContent =
                unread;

        }


        if (sidebarTotalCount) {

            sidebarTotalCount.textContent =
                total;

        }


        if (unread === 0) {

            markAllReadBtn.disabled = true;

            markAllReadBtn.style.opacity = ".5";

            markAllReadBtn.style.cursor =
                "default";

        } else {

            markAllReadBtn.disabled = false;

            markAllReadBtn.style.opacity = "1";

            markAllReadBtn.style.cursor =
                "pointer";

        }

    }


    /* =====================================================
       SAVE READ STATE
    ====================================================== */

    function saveReadState() {

        localStorage.setItem(
            READ_STORAGE,
            JSON.stringify(readNotifications)
        );

    }


    /* =====================================================
       MARK NOTIFICATION READ
    ====================================================== */

    function markNotificationRead(item) {

        if (!item) {
            return;
        }

        const id =
            item.dataset.id;

        item.dataset.read = "true";

        item.classList.remove(
            "unread"
        );


        const unreadDot =
            item.querySelector(
                ".pl-unread-dot"
            );

        if (unreadDot) {

            unreadDot.remove();

        }


        const readButton =
            item.querySelector(
                ".pl-read-btn"
            );

        if (readButton) {

            readButton.remove();

        }


        readNotifications[id] = true;

        saveReadState();

        updateCounts();

    }


    /* =====================================================
       RESTORE READ STATE
    ====================================================== */

    function restoreReadState() {

        notifications.forEach(function (item) {

            const id =
                item.dataset.id;

            if (
                readNotifications[id] === true
            ) {

                item.dataset.read =
                    "true";

                item.classList.remove(
                    "unread"
                );


                const dot =
                    item.querySelector(
                        ".pl-unread-dot"
                    );

                if (dot) {
                    dot.remove();
                }


                const button =
                    item.querySelector(
                        ".pl-read-btn"
                    );

                if (button) {
                    button.remove();
                }

            }

        });

    }


    /* =====================================================
       FILTER
    ====================================================== */

    function applyFilter(category) {

        let visibleCount = 0;


        notifications.forEach(function (item) {

            const itemCategory =
                item.dataset.category;


            if (
                category === "all" ||
                itemCategory === category
            ) {

                item.style.display =
                    "flex";

                visibleCount++;

            } else {

                item.style.display =
                    "none";

            }

        });


        if (notificationEmpty) {

            notificationEmpty.hidden =
                visibleCount !== 0;

        }

    }


    filterButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                filterButtons.forEach(
                    function (btn) {

                        btn.classList.remove(
                            "active"
                        );

                    }
                );


                button.classList.add(
                    "active"
                );


                const filter =
                    button.dataset.filter;

                applyFilter(filter);

            }
        );

    });


    /* =====================================================
       INDIVIDUAL READ BUTTONS
    ====================================================== */

    document.querySelectorAll(
        ".pl-read-btn"
    ).forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                const item =
                    button.closest(
                        ".pl-notification-item"
                    );

                markNotificationRead(item);

                showToast(
                    "Notification marked as read."
                );

            }
        );

    });


    /* =====================================================
       MARK ALL READ
    ====================================================== */

    if (markAllReadBtn) {

        markAllReadBtn.addEventListener(
            "click",
            function () {

                notifications.forEach(
                    function (item) {

                        markNotificationRead(
                            item
                        );

                    }
                );


                showToast(
                    "All notifications marked as read."
                );

            }
        );

    }


    /* =====================================================
       VIEW DETAILS MODAL
    ====================================================== */

    function openNotificationModal(button) {

        if (!notificationModal) {
            return;
        }


        const title =
            button.dataset.title ||
            "Matrimony Notification";


        const message =
            button.dataset.message ||
            "";


        const link =
            button.dataset.link ||
            "";


        const item =
            button.closest(
                ".pl-notification-item"
            );


        let timeText = "Matrimony Update";


        if (item) {

            const time =
                item.querySelector(
                    ".pl-notification-meta span"
                );

            if (time) {

                timeText =
                    time.textContent.trim();

            }

        }


        modalNotificationTitle.textContent =
            title;

        modalNotificationMessage.textContent =
            message;

        modalNotificationTime.textContent =
            timeText;


        if (link) {

            modalViewLink.href =
                link;

            modalViewLink.hidden =
                false;

        } else {

            modalViewLink.hidden =
                true;

        }


        notificationModal.classList.add(
            "active"
        );

        notificationModal.setAttribute(
            "aria-hidden",
            "false"
        );

        document.body.style.overflow =
            "hidden";


        /* Mark as read */

        if (item) {

            markNotificationRead(item);

        }

    }


    document.querySelectorAll(
        ".pl-view-notification"
    ).forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                openNotificationModal(
                    button
                );

            }
        );

    });


    /* =====================================================
       CLOSE NOTIFICATION MODAL
    ====================================================== */

    function closeNotificationModal() {

        if (!notificationModal) {
            return;
        }

        notificationModal.classList.remove(
            "active"
        );

        notificationModal.setAttribute(
            "aria-hidden",
            "true"
        );

        document.body.style.overflow =
            "";

    }


    if (notificationModalClose) {

        notificationModalClose.addEventListener(
            "click",
            closeNotificationModal
        );

    }


    if (modalCloseBtn) {

        modalCloseBtn.addEventListener(
            "click",
            closeNotificationModal
        );

    }


    if (notificationModal) {

        const overlay =
            notificationModal.querySelector(
                ".pl-notification-modal-overlay"
            );

        if (overlay) {

            overlay.addEventListener(
                "click",
                closeNotificationModal
            );

        }

    }


    /* =====================================================
       PREFERENCES MODAL
    ====================================================== */

    function openPreferencesModal() {

        if (!preferencesModal) {
            return;
        }

        preferencesModal.classList.add(
            "active"
        );

        preferencesModal.setAttribute(
            "aria-hidden",
            "false"
        );

        document.body.style.overflow =
            "hidden";

    }


    function closePreferencesModal() {

        if (!preferencesModal) {
            return;
        }

        preferencesModal.classList.remove(
            "active"
        );

        preferencesModal.setAttribute(
            "aria-hidden",
            "true"
        );

        document.body.style.overflow =
            "";

    }


    if (managePreferencesBtn) {

        managePreferencesBtn.addEventListener(
            "click",
            openPreferencesModal
        );

    }


    if (preferencesModalClose) {

        preferencesModalClose.addEventListener(
            "click",
            closePreferencesModal
        );

    }


    if (preferencesCancelBtn) {

        preferencesCancelBtn.addEventListener(
            "click",
            closePreferencesModal
        );

    }


    if (preferencesModal) {

        const overlay =
            preferencesModal.querySelector(
                ".pl-notification-modal-overlay"
            );

        if (overlay) {

            overlay.addEventListener(
                "click",
                closePreferencesModal
            );

        }

    }


    /* =====================================================
       PREFERENCE STORAGE
    ====================================================== */

    function savePreferenceState() {

        const preferences = {};

        preferenceToggles.forEach(
            function (toggle) {

                preferences[
                    toggle.dataset.preference
                ] = toggle.checked;

            }
        );


        localStorage.setItem(
            PREFERENCE_STORAGE,
            JSON.stringify(preferences)
        );

    }


    function restorePreferenceState() {

        const saved =
            localStorage.getItem(
                PREFERENCE_STORAGE
            );

        if (!saved) {
            return;
        }


        try {

            const preferences =
                JSON.parse(saved);


            preferenceToggles.forEach(
                function (toggle) {

                    const key =
                        toggle.dataset.preference;

                    if (
                        typeof preferences[key]
                        !== "undefined"
                    ) {

                        toggle.checked =
                            preferences[key];

                    }

                }
            );

        } catch (error) {

            console.warn(
                "Unable to restore notification preferences."
            );

        }

    }


    if (savePreferencesBtn) {

        savePreferencesBtn.addEventListener(
            "click",
            function () {

                savePreferenceState();

                closePreferencesModal();

                showToast(
                    "Notification preferences saved."
                );

            }
        );

    }


    /* =====================================================
       VIEW ALL
    ====================================================== */

    function showAll() {

        filterButtons.forEach(
            function (button) {

                button.classList.remove(
                    "active"
                );

            }
        );


        const allButton =
            document.querySelector(
                '.pl-notification-filter[data-filter="all"]'
            );

        if (allButton) {

            allButton.classList.add(
                "active"
            );

        }


        applyFilter("all");

    }


    if (viewAllNotifications) {

        viewAllNotifications.addEventListener(
            "click",
            showAll
        );

    }


    if (showAllNotifications) {

        showAllNotifications.addEventListener(
            "click",
            showAll
        );

    }


    /* =====================================================
       ESCAPE KEY
    ====================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (event.key !== "Escape") {
                return;
            }

            closeNotificationModal();

            closePreferencesModal();

        }
    );


    /* =====================================================
       INITIALIZE
    ====================================================== */

    restoreReadState();

    restorePreferenceState();

    updateCounts();

    applyFilter("all");

});