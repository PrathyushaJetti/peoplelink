/* =========================================================
   PEOPLELINK TECHNOLOGIES
   HEADER JAVASCRIPT
========================================================= */


document.addEventListener("DOMContentLoaded", function () {


    const mobileToggle =
        document.getElementById("mobileToggle");

    const mainNav =
        document.getElementById("mainNav");

    const siteHeader =
        document.getElementById("siteHeader");

    const dropdown =
        document.querySelector(".nav-dropdown");

    const dropdownToggle =
        document.querySelector(".dropdown-toggle");


    /* =====================================================
       MOBILE MENU
    ===================================================== */

    mobileToggle.addEventListener("click", function () {

        const isOpen =
            mainNav.classList.toggle("open");

        mobileToggle.classList.toggle("active");

        mobileToggle.setAttribute(
            "aria-expanded",
            isOpen ? "true" : "false"
        );

    });


    /* =====================================================
       MOBILE DROPDOWN
    ===================================================== */

    dropdownToggle.addEventListener("click", function (event) {

        if (window.innerWidth <= 1000) {

            event.preventDefault();

            dropdown.classList.toggle("open");

        }

    });


    /* =====================================================
       CLOSE MOBILE MENU WHEN LINK CLICKED
    ===================================================== */

    const navLinks =
        document.querySelectorAll(
            ".main-nav a"
        );

    navLinks.forEach(function (link) {

        link.addEventListener("click", function () {

            if (window.innerWidth <= 1000) {

                mainNav.classList.remove("open");

                mobileToggle.classList.remove("active");

                mobileToggle.setAttribute(
                    "aria-expanded",
                    "false"
                );

            }

        });

    });


    /* =====================================================
       CLOSE WHEN CLICKING OUTSIDE
    ===================================================== */

    document.addEventListener("click", function (event) {

        if (
            !mainNav.contains(event.target) &&
            !mobileToggle.contains(event.target)
        ) {

            mainNav.classList.remove("open");

            mobileToggle.classList.remove("active");

            mobileToggle.setAttribute(
                "aria-expanded",
                "false"
            );

        }

    });


    /* =====================================================
       HEADER SCROLL EFFECT
    ===================================================== */

    function headerScroll() {

        if (window.scrollY > 20) {

            siteHeader.classList.add("scrolled");

        } else {

            siteHeader.classList.remove("scrolled");

        }

    }

    window.addEventListener(
        "scroll",
        headerScroll
    );

    headerScroll();


    /* =====================================================
       ESC KEY
    ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (event.key === "Escape") {

                mainNav.classList.remove("open");

                mobileToggle.classList.remove("active");

                dropdown.classList.remove("open");

                mobileToggle.setAttribute(
                    "aria-expanded",
                    "false"
                );

            }

        }
    );


});






/* =========================================================
   PEOPLELINK HERO
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const heroContent =
        document.querySelector(".peoplelink-hero-content");

    const heroVisual =
        document.querySelector(".peoplelink-hero-visual");


    if (heroContent) {

        heroContent.style.opacity = "0";
        heroContent.style.transform = "translateY(25px)";

        setTimeout(function () {

            heroContent.style.transition =
                "opacity .8s ease, transform .8s ease";

            heroContent.style.opacity = "1";
            heroContent.style.transform =
                "translateY(0)";

        }, 100);

    }


    if (heroVisual) {

        heroVisual.style.opacity = "0";
        heroVisual.style.transform =
            "translateY(25px)";

        setTimeout(function () {

            heroVisual.style.transition =
                "opacity .9s ease, transform .9s ease";

            heroVisual.style.opacity = "1";
            heroVisual.style.transform =
                "translateY(0)";

        }, 250);

    }

});







/* =========================================================
   PEOPLELINK COMMUNITY SELECTOR
========================================================= */

document.addEventListener("DOMContentLoaded", function () {


    const communityList =
        document.querySelector(".pl-community-list");

    const viewButton =
        document.getElementById("plViewCommunities");


    /* =====================================================
       VIEW ALL COMMUNITIES
    ===================================================== */

    if (viewButton && communityList) {

        viewButton.addEventListener(
            "click",
            function () {

                communityList.classList.toggle("show-all");

                const isOpen =
                    communityList.classList.contains("show-all");


                const buttonText =
                    viewButton.querySelector("span");

                const buttonIcon =
                    viewButton.querySelector("i");


                if (isOpen) {

                    buttonText.textContent =
                        "Show Fewer Communities";

                    buttonIcon.className =
                        "fa-solid fa-arrow-up";

                } else {

                    buttonText.textContent =
                        "View All Communities";

                    buttonIcon.className =
                        "fa-solid fa-arrow-right";

                }

            }
        );

    }


    /* =====================================================
       COMMUNITY SELECTION
    ===================================================== */

    const communities =
        document.querySelectorAll(
            ".pl-community-item"
        );


    communities.forEach(function (community) {

        community.addEventListener(
            "click",
            function (event) {

                event.preventDefault();


                communities.forEach(function (item) {

                    item.classList.remove("active");

                });


                this.classList.add("active");

            }
        );

    });


});






 
document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       FOOTER YEAR
    ====================================================== */

    const footerYear =
        document.getElementById("plFooterYear");

    if (footerYear) {

        footerYear.textContent =
            new Date().getFullYear();

    }


    /* =====================================================
       SMOOTH SCROLL
    ====================================================== */

    const scrollLinks = document.querySelectorAll(
        'a[href^="#"]'
    );

    scrollLinks.forEach(function (link) {

        link.addEventListener("click", function (event) {

            const targetId =
                this.getAttribute("href");

            if (!targetId || targetId === "#") {

                event.preventDefault();

                return;

            }

            const target =
                document.querySelector(targetId);

            if (target) {

                event.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });

            }

        });

    });


    /* =====================================================
       SCROLL REVEAL
    ====================================================== */

    const revealElements =
        document.querySelectorAll(
            ".pl-why-header, .pl-why-card, " +
            ".pl-join-content, .pl-join-visual"
        );


    if ("IntersectionObserver" in window) {

        const revealObserver =
            new IntersectionObserver(
                function (entries, observer) {

                    entries.forEach(function (entry) {

                        if (entry.isIntersecting) {

                            entry.target.classList.add(
                                "pl-visible"
                            );

                            observer.unobserve(
                                entry.target
                            );

                        }

                    });

                },
                {
                    threshold: 0.12
                }
            );


        revealElements.forEach(function (element) {

            revealObserver.observe(element);

        });

    } else {

        revealElements.forEach(function (element) {

            element.classList.add("pl-visible");

        });

    }


    /* =====================================================
       WHY CARD STAGGER
    ====================================================== */

    const whyCards =
        document.querySelectorAll(
            ".pl-why-card"
        );

    whyCards.forEach(function (card, index) {

        card.style.transitionDelay =
            (index * 0.08) + "s";

    });


    /* =====================================================
       NETWORK NODE INTERACTION
    ====================================================== */

    const networkNodes =
        document.querySelectorAll(
            ".pl-network-node"
        );

    networkNodes.forEach(function (node) {

        node.addEventListener(
            "mouseenter",
            function () {

                this.classList.add(
                    "network-active"
                );

            }
        );

        node.addEventListener(
            "mouseleave",
            function () {

                this.classList.remove(
                    "network-active"
                );

            }
        );

    });


    /* =====================================================
       JOIN BUTTON FEEDBACK
    ====================================================== */

    const selectCommunity =
        document.querySelector(
            '.primary-join-btn[href="#communityList"]'
        );

    if (selectCommunity) {

        selectCommunity.addEventListener(
            "click",
            function () {

                setTimeout(function () {

                    const communityList =
                        document.getElementById(
                            "communityList"
                        );

                    if (communityList) {

                        communityList.classList.add(
                            "show-all"
                        );

                    }

                }, 500);

            }
        );

    }

});
