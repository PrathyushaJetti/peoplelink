/* =========================================================
   PEOPLELINK HEADER JS
========================================================= */

document.addEventListener(
    "DOMContentLoaded",
    function () {


        /* =====================================================
           ELEMENTS
        ====================================================== */

        const mobileToggle =
            document.getElementById(
                "plMobileToggle"
            );


        const mainNav =
            document.getElementById(
                "plMainNav"
            );


        const menuOverlay =
            document.getElementById(
                "plMenuOverlay"
            );


        const dropdown =
            document.querySelector(
                ".pl-nav-dropdown"
            );


        const dropdownButton =
            document.querySelector(
                ".pl-nav-dropdown-btn"
            );



        /* =====================================================
           OPEN / CLOSE MOBILE MENU
        ====================================================== */

        function openMenu() {

            if (!mobileToggle || !mainNav) {
                return;
            }

            mobileToggle.classList.add(
                "active"
            );

            mainNav.classList.add(
                "active"
            );

            if (menuOverlay) {

                menuOverlay.classList.add(
                    "active"
                );

            }

            mobileToggle.setAttribute(
                "aria-expanded",
                "true"
            );

            document.body.style.overflow =
                "hidden";

        }


        function closeMenu() {

            if (!mobileToggle || !mainNav) {
                return;
            }

            mobileToggle.classList.remove(
                "active"
            );

            mainNav.classList.remove(
                "active"
            );

            if (menuOverlay) {

                menuOverlay.classList.remove(
                    "active"
                );

            }

            mobileToggle.setAttribute(
                "aria-expanded",
                "false"
            );

            document.body.style.overflow =
                "";

        }



        /* =====================================================
           MOBILE TOGGLE
        ====================================================== */

        if (mobileToggle) {

            mobileToggle.addEventListener(
                "click",
                function () {

                    const isOpen =
                        mainNav.classList.contains(
                            "active"
                        );


                    if (isOpen) {

                        closeMenu();

                    } else {

                        openMenu();

                    }

                }
            );

        }



        /* =====================================================
           OVERLAY CLOSE
        ====================================================== */

        if (menuOverlay) {

            menuOverlay.addEventListener(
                "click",
                function () {

                    closeMenu();

                }
            );

        }



        /* =====================================================
           MOBILE COMMUNITY DROPDOWN
        ====================================================== */

        if (
            dropdown &&
            dropdownButton
        ) {

            dropdownButton.addEventListener(
                "click",
                function (event) {

                    /*
                     * Desktop uses CSS hover.
                     * Mobile uses JavaScript.
                     */

                    if (
                        window.innerWidth <= 900
                    ) {

                        event.preventDefault();

                        dropdown.classList.toggle(
                            "mobile-open"
                        );

                    }

                }
            );

        }



        /* =====================================================
           CLOSE MENU WHEN LINK IS CLICKED
        ====================================================== */

        const navLinks =
            document.querySelectorAll(
                ".pl-main-nav a"
            );


        navLinks.forEach(
            function (link) {

                link.addEventListener(
                    "click",
                    function () {

                        if (
                            window.innerWidth <= 900
                        ) {

                            closeMenu();

                        }

                    }
                );

            }
        );



        /* =====================================================
           ESC KEY
        ====================================================== */

        document.addEventListener(
            "keydown",
            function (event) {

                if (
                    event.key === "Escape"
                ) {

                    closeMenu();

                }

            }
        );



        /* =====================================================
           RESIZE
        ====================================================== */

        window.addEventListener(
            "resize",
            function () {

                if (
                    window.innerWidth > 900
                ) {

                    closeMenu();

                    if (dropdown) {

                        dropdown.classList.remove(
                            "mobile-open"
                        );

                    }

                }

            }
        );



        /* =====================================================
           HEADER SCROLL EFFECT
        ====================================================== */

        const header =
            document.getElementById(
                "peoplelinkHeader"
            );


        let lastScroll = 0;


        window.addEventListener(
            "scroll",
            function () {

                const currentScroll =
                    window.pageYOffset ||
                    document.documentElement
                        .scrollTop;


                if (
                    header &&
                    currentScroll > 30
                ) {

                    header.classList.add(
                        "pl-header-scrolled"
                    );

                } else if (header) {

                    header.classList.remove(
                        "pl-header-scrolled"
                    );

                }


                lastScroll =
                    currentScroll <= 0
                        ? 0
                        : currentScroll;

            },
            {
                passive: true
            }
        );



        /* =====================================================
           SMOOTH INTERNAL LINKS
        ====================================================== */

        const internalLinks =
            document.querySelectorAll(
                'a[href^="#"]'
            );


        internalLinks.forEach(
            function (link) {

                link.addEventListener(
                    "click",
                    function (event) {

                        const targetId =
                            this.getAttribute(
                                "href"
                            );


                        if (
                            !targetId ||
                            targetId === "#"
                        ) {

                            return;

                        }


                        const target =
                            document.querySelector(
                                targetId
                            );


                        if (target) {

                            event.preventDefault();

                            closeMenu();

                            target.scrollIntoView(
                                {
                                    behavior: "smooth",
                                    block: "start"
                                }
                            );

                        }

                    }
                );

            }
        );

    }
);


