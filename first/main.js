/* PeopleLink matrimony API helper (talks to the real matrimoney api.php with CSRF) */
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






 
/* =========================================================
   PEOPLELINK COMMUNITY SELECTOR
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const cards = document.querySelectorAll(
        "#communityList .pl-community-card"
    );

    const selected = document.getElementById(
        "selectedCommunity"
    );

    if (!cards.length) {
        console.log("PeopleLink: Community cards not found.");
        return;
    }

    if (!selected) {
        console.log(
            "PeopleLink: #selectedCommunity not found."
        );
        return;
    }


    /* =====================================================
       COMMUNITY CLICK
    ===================================================== */

    cards.forEach(function (card) {

        card.addEventListener("click", function (event) {

            event.preventDefault();
            event.stopPropagation();

            const community =
                card.getAttribute("data-community");

            if (!community) {
                console.log(
                    "PeopleLink: data-community missing."
                );
                return;
            }


            /* Remove active from all cards */

            cards.forEach(function (item) {
                item.classList.remove("active");
            });


            /* Add active to clicked card */

            card.classList.add("active");


            /* Change selected community */

            selected.textContent = community;


            /* Small visual animation */

            selected.style.opacity = "0";

            selected.style.transform =
                "translateY(5px)";

            setTimeout(function () {

                selected.style.opacity = "1";

                selected.style.transform =
                    "translateY(0)";

            }, 80);


            console.log(
                "Selected community:",
                community
            );

        });

    });

});







 




 
document.addEventListener("DOMContentLoaded", function () {

    const serviceExplorer = document.getElementById("platformServices");

    if (!serviceExplorer) {
        console.log("PeopleLink Service Explorer not found.");
        return;
    }

    const image = document.getElementById("serviceImage");
    const number = document.getElementById("serviceNumber");
    const category = document.getElementById("serviceCategory");
    const smallTitle = document.getElementById("serviceSmallTitle");
    const title = document.getElementById("serviceTitle");
    const description = document.getElementById("serviceDescription");
    const features = document.getElementById("serviceFeatures");
    const button = document.getElementById("serviceButton");

    /* ==========================================
       SERVICE DATA
    ========================================== */

    const services = {

        matrimony: {
            number: "01",
            category: "RELATIONSHIPS",
            smallTitle: "RELATIONSHIPS & MATRIMONY",
            title: "Find Meaningful Relationships Within Your Community",
            description: "PeopleLink provides a dedicated space for members looking for meaningful relationships and matrimonial connections within their community. Discover profiles, understand family backgrounds and connect with people who share your community values and interests.",
            image: "https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=85",
            alt: "Matrimony and relationships",
            button: "Explore Matrimony",
            features: [
                "Community-focused profiles",
                "Search suitable matches",
                "Family-oriented connections",
                "Meaningful introductions"
            ]
        },

        family: {
            number: "02",
            category: "FAMILY & COMMUNITY",
            smallTitle: "FAMILY & COMMUNITY NETWORK",
            title: "Keep Your Family Connected Across Generations",
            description: "Register family members, build your digital Family Tree and create a stronger connection between generations. PeopleLink helps families stay connected while making important family relationships easier to discover and maintain.",
            image: "https://images.unsplash.com/photo-1511895426328-dc8714191300?auto=format&fit=crop&w=1200&q=85",
            alt: "Family and community",
            button: "Register Your Family",
            features: [
                "Create your digital Family Tree",
                "Add and manage family members",
                "Connect different generations",
                "Strengthen family relationships"
            ]
        },

        jobs: {
            number: "03",
            category: "CAREERS & OPPORTUNITIES",
            smallTitle: "JOBS & CAREER",
            title: "Discover Jobs, Talent & Career Opportunities",
            description: "Explore employment opportunities within your community and discover new career possibilities. Businesses and organizations can also share job openings and connect with suitable candidates.",
            image: "https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=85",
            alt: "Jobs and career",
            button: "Explore Jobs",
            features: [
                "Discover community job opportunities",
                "Post employment openings",
                "Connect employers and candidates",
                "Explore career possibilities"
            ]
        },

        business: {
            number: "04",
            category: "PROFESSIONAL NETWORK",
            smallTitle: "PROFESSIONALS & BUSINESSES",
            title: "Discover Professionals & Businesses Around Your Community",
            description: "Find doctors, lawyers, CAs, engineers, consultants, entrepreneurs, shops and service providers. PeopleLink creates a professional directory that helps community members discover useful expertise and businesses.",
            image: "https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1200&q=85",
            alt: "Professionals and businesses",
            button: "Explore Directory",
            features: [
                "Find community professionals",
                "Discover local businesses",
                "Explore service providers",
                "Build professional connections"
            ]
        },

        marketplace: {
            number: "05",
            category: "MARKETPLACE",
            smallTitle: "PROPERTY & MARKETPLACE",
            title: "Buy, Sell & Discover What Your Community Offers",
            description: "Explore property and marketplace listings shared by community members. Discover homes, land, vehicles, electronics and other products while connecting with people and businesses.",
            image: "https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1200&q=85",
            alt: "Property and marketplace",
            button: "Explore Marketplace",
            features: [
                "Property listings",
                "Cars and bikes",
                "Products and electronics",
                "Community marketplace"
            ]
        },

        events: {
            number: "06",
            category: "COMMUNITY LIFE",
            smallTitle: "EVENTS & COMMUNITY LIFE",
            title: "Celebrate, Participate & Stay Connected",
            description: "Discover community celebrations, cultural programs, meetings, festivals and special gatherings. Stay informed about upcoming events and participate directly through PeopleLink.",
            image: "https://images.unsplash.com/photo-1507504031003-b417219a0fde?auto=format&fit=crop&w=1200&q=85",
            alt: "Community events",
            button: "View Events",
            features: [
                "Community celebrations",
                "Cultural programs",
                "Meetings and gatherings",
                "Event registration"
            ]
        },

        advertisements: {
            number: "07",
            category: "COMMUNITY ADVERTISING",
            smallTitle: "ADVERTISEMENTS",
            title: "Give Your Business a Voice Within the Community",
            description: "Promote businesses, products, services, launches, offers and personal events through community-specific advertising designed to help you reach relevant members.",
            image: "https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1200&q=85",
            alt: "Business advertising",
            button: "Advertise With Us",
            features: [
                "Promote your business",
                "Advertise products and services",
                "Promote events and launches",
                "Reach your community"
            ]
        },

        near: {
            number: "08",
            category: "AROUND YOU",
            smallTitle: "NEAR ME",
            title: "Discover Useful People, Businesses & Services Near You",
            description: "Find useful professionals, businesses and services around your location. Near Me helps community members discover relevant places and service providers based on where they are.",
            image: "https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?auto=format&fit=crop&w=1200&q=85",
            alt: "Location based services",
            button: "Explore Near Me",
            features: [
                "Discover nearby businesses",
                "Find useful professionals",
                "Location-based discovery",
                "Find services around you"
            ]
        }

    };


    /* ==========================================
       CHANGE SERVICE
    ========================================== */

    function changeService(serviceName) {

        console.log("Selected service:", serviceName);

        const data = services[serviceName];

        if (!data) {
            console.log("Service data not found:", serviceName);
            return;
        }


        /* ACTIVE TAB */

        const tabs = serviceExplorer.querySelectorAll(".pl-se-tab");

        tabs.forEach(function (tab) {

            tab.classList.remove("active");

            if (tab.getAttribute("data-service") === serviceName) {
                tab.classList.add("active");
            }

        });


        /* FADE OUT */

        if (image) image.style.opacity = "0";
        if (title) title.style.opacity = "0";
        if (description) description.style.opacity = "0";


        setTimeout(function () {

            /* IMAGE */

            if (image) {
                image.src = data.image;
                image.alt = data.alt;
            }


            /* BASIC INFORMATION */

            if (number) {
                number.textContent = data.number;
            }

            if (category) {
                category.textContent = data.category;
            }

            if (smallTitle) {
                smallTitle.textContent = data.smallTitle;
            }

            if (title) {
                title.textContent = data.title;
            }

            if (description) {
                description.textContent = data.description;
            }


            /* FEATURES */

            if (features) {

                features.innerHTML = "";

                data.features.forEach(function (feature) {

                    const item = document.createElement("div");

                    item.className = "pl-feature-item";

                    item.innerHTML =
                        '<i class="fa-solid fa-circle-check"></i>' +
                        '<span>' + feature + '</span>';

                    features.appendChild(item);

                });

            }


            /* BUTTON */

            if (button) {

                button.innerHTML =
                    data.button +
                    ' <i class="fa-solid fa-arrow-right"></i>';

                // each service opens its own page
                var serviceLinks = { matrimony: "/peoplelink/module-4/Frontend/pages/index.php", family: "/peoplelink/first/m-f-registration/member-family-registration.php", jobs: "/peoplelink/first/job/jobs-home.php", business: "/peoplelink/first/professional-and-business-directory.php", marketplace: "/peoplelink/first/marketplace/marketplace-home.php", events: "/peoplelink/first/events-ads.php", advertisements: "/peoplelink/first/events-ads.php", near: "/peoplelink/first/near-me.php" };
                var serviceKey = Object.keys(services).find(function (k) { return services[k] === data; });
                if (serviceKey && serviceLinks[serviceKey] && button.tagName === "A") button.setAttribute("href", serviceLinks[serviceKey]);

            }


            /* FADE IN */

            if (image) {
                image.style.opacity = "1";
            }

            if (title) {
                title.style.opacity = "1";
            }

            if (description) {
                description.style.opacity = "1";
            }

        }, 180);

    }


    /* ==========================================
       CLICK HANDLER
       EVENT DELEGATION
    ========================================== */

    serviceExplorer.addEventListener("click", function (event) {

        const tab = event.target.closest(".pl-se-tab");

        if (!tab) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        const serviceName = tab.getAttribute("data-service");

        console.log("Clicked:", serviceName);

        if (!serviceName) {
            console.log("No data-service attribute found.");
            return;
        }

        changeService(serviceName);

    });


    /* ==========================================
       INITIAL SERVICE
    ========================================== */

    changeService("matrimony");

});






/* ==========================================================
   PEOPLELINK COMMUNITY HOME
   JAVASCRIPT
========================================================== */

document.addEventListener("DOMContentLoaded", function () {


    /* ======================================================
       SMOOTH SCROLL
    ======================================================= */

    const quickLinks =
        document.querySelectorAll(
            '.pl-quick-item[href^="#"]'
        );

    quickLinks.forEach(function (link) {

        link.addEventListener("click", function (e) {

            const targetId =
                this.getAttribute("href");

            const target =
                document.querySelector(targetId);

            if (!target) {
                return;
            }

            e.preventDefault();

            target.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

        });

    });


    /* ======================================================
       REVEAL ANIMATION
    ======================================================= */

    const revealElements =
        document.querySelectorAll(
            `
            .pl-community-card,
            .pl-news-card,
            .pl-job-item,
            .pl-professional-item,
            .pl-event-big,
            .pl-event-small,
            .pl-support-box,
            .pl-leader-card,
            .pl-live-card
            `
        );


    const revealObserver =
        new IntersectionObserver(
            function (entries) {

                entries.forEach(function (entry) {

                    if (
                        entry.isIntersecting
                    ) {

                        entry.target.classList.add(
                            "pl-visible"
                        );

                        revealObserver.unobserve(
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

        element.classList.add(
            "pl-reveal-element"
        );

        revealObserver.observe(element);

    });


    /* ======================================================
       QUICK NAV ACTIVE STATE
    ======================================================= */

    const sections = [
        "matrimony",
        "family",
        "jobs",
        "professionals",
        "marketplace",
        "events",
        "support"
    ];


    const quickNavigation =
        document.querySelectorAll(
            ".pl-quick-item"
        );


    window.addEventListener(
        "scroll",
        function () {

            let currentSection = "";

            sections.forEach(function (id) {

                const section =
                    document.getElementById(id);

                if (!section) {
                    return;
                }

                const sectionTop =
                    section.offsetTop - 180;

                if (
                    window.scrollY >=
                    sectionTop
                ) {

                    currentSection = id;

                }

            });


            quickNavigation.forEach(
                function (item) {

                    item.classList.remove(
                        "pl-active"
                    );

                    const href =
                        item.getAttribute("href");

                    if (
                        href ===
                        "#" + currentSection
                    ) {

                        item.classList.add(
                            "pl-active"
                        );

                    }

                }
            );

        }
    );


    /* ======================================================
       HERO CARD FLOATING EFFECT
    ======================================================= */

    const heroVisual =
        document.querySelector(
            ".pl-hero-visual"
        );


    const heroCard =
        document.querySelector(
            ".pl-hero-main-card"
        );


    if (
        heroVisual &&
        heroCard &&
        window.innerWidth > 768
    ) {

        heroVisual.addEventListener(
            "mousemove",
            function (event) {

                const rect =
                    heroVisual.getBoundingClientRect();

                const x =
                    event.clientX -
                    rect.left;

                const y =
                    event.clientY -
                    rect.top;

                const rotateY =
                    ((x / rect.width) - .5) * 5;

                const rotateX =
                    ((y / rect.height) - .5) * -5;

                heroCard.style.transform =
                    `
                    perspective(1000px)
                    rotateX(${rotateX}deg)
                    rotateY(${rotateY}deg)
                    translateY(-4px)
                    `;

            }
        );


        heroVisual.addEventListener(
            "mouseleave",
            function () {

                heroCard.style.transform =
                    "";

            }
        );

    }

});






 
document.addEventListener("DOMContentLoaded", function () {

    /* =====================================
       STATISTICS COUNTER
    ===================================== */

    const counters = document.querySelectorAll(
        ".pl-stat-card strong[data-count]"
    );

    const counterObserver = new IntersectionObserver(
        function (entries, observer) {

            entries.forEach(function (entry) {

                if (!entry.isIntersecting) return;

                const counter = entry.target;
                const target = parseInt(counter.dataset.count, 10);

                let current = 0;
                const duration = 1300;
                const startTime = performance.now();

                function updateCounter(time) {

                    const progress = Math.min(
                        (time - startTime) / duration,
                        1
                    );

                    const ease = 1 - Math.pow(1 - progress, 3);

                    current = Math.floor(target * ease);

                    counter.textContent =
                        current.toLocaleString();

                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent =
                            target.toLocaleString() + "+";
                    }
                }

                requestAnimationFrame(updateCounter);

                observer.unobserve(counter);
            });

        },
        {
            threshold: 0.4
        }
    );

    counters.forEach(function (counter) {
        counterObserver.observe(counter);
    });


    /* =====================================
       IMAGE REVEAL
    ===================================== */

    const revealElements = document.querySelectorAll(
        ".pl-intro-grid, .pl-history-grid, .pl-value-card, .pl-info-card, .pl-stat-card, .pl-directory-card, .pl-activities-grid"
    );

    const revealObserver = new IntersectionObserver(
        function (entries) {

            entries.forEach(function (entry) {

                if (entry.isIntersecting) {

                    entry.target.classList.add("pl-visible");

                    revealObserver.unobserve(entry.target);

                }

            });

        },
        {
            threshold: 0.12
        }
    );

    revealElements.forEach(function (element) {

        element.classList.add("pl-reveal");

        revealObserver.observe(element);

    });


    /* =====================================
       SMOOTH SCROLL
    ===================================== */

    document.querySelectorAll(
        '.pl-about-page a[href^="#"]'
    ).forEach(function (link) {

        link.addEventListener("click", function (e) {

            const targetId =
                this.getAttribute("href");

            if (!targetId || targetId === "#") return;

            const target =
                document.querySelector(targetId);

            if (target) {

                e.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });

            }

        });

    });

});
 





 
document.addEventListener("DOMContentLoaded", function () {

    /* ==========================================
       SMOOTH SCROLL
    ========================================== */

    document.querySelectorAll(
        '.pl-leadership-page a[href^="#"]'
    ).forEach(function (link) {

        link.addEventListener("click", function (e) {

            const targetId = this.getAttribute("href");

            if (!targetId || targetId === "#") {
                return;
            }

            const target =
                document.querySelector(targetId);

            if (target) {

                e.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });

            }

        });

    });


    /* ==========================================
       SEARCH FORM DEMO
    ========================================== */

    const searchForm =
        document.querySelector(".pl-leader-search-form");

    if (searchForm) {

        searchForm.addEventListener("submit", function (e) {

            e.preventDefault();

            const button =
                this.querySelector(".pl-leader-search-btn");

            const originalText = button.innerHTML;

            button.innerHTML =
                '<i class="bi bi-check-circle-fill"></i> Searching...';

            setTimeout(function () {

                button.innerHTML =
                    '<i class="bi bi-check-circle-fill"></i> Search Complete';

                setTimeout(function () {
                    button.innerHTML = originalText;
                }, 1800);

            }, 700);

        });

    }


    /* ==========================================
       CARD REVEAL
    ========================================== */

    const revealElements =
        document.querySelectorAll(
            ".pl-leader-profile-card, .pl-level-card, .pl-submit-box, .pl-global-leader-grid"
        );

    const revealObserver =
        new IntersectionObserver(function (entries, observer) {

            entries.forEach(function (entry) {

                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";

                observer.unobserve(entry.target);

            });

        }, {
            threshold: 0.12
        });


    revealElements.forEach(function (element) {

        element.style.opacity = "0";
        element.style.transform = "translateY(18px)";
        element.style.transition =
            "opacity .55s ease, transform .55s ease";

        revealObserver.observe(element);

    });

});
 




 
document.addEventListener("DOMContentLoaded", function () {

    /* ==========================================
       COMMUNITY SELECTION
    ========================================== */

    const communitySelect =
        document.getElementById("communitySelect");

    if (communitySelect) {

        communitySelect.addEventListener("change", function () {

            if (this.value !== "") {

                this.style.borderColor = "#42b72a";

                this.style.boxShadow =
                    "0 0 0 3px rgba(66,183,42,.08)";

            } else {

                this.style.borderColor = "";
                this.style.boxShadow = "";

            }

        });

    }


    /* ==========================================
       INPUT FOCUS
    ========================================== */

    document.querySelectorAll(
        ".pl-input-wrap input, .pl-input-wrap select"
    ).forEach(function (input) {

        input.addEventListener("focus", function () {

            this.closest(".pl-input-wrap")
                .classList.add("pl-input-focused");

        });

        input.addEventListener("blur", function () {

            this.closest(".pl-input-wrap")
                .classList.remove("pl-input-focused");

        });

    });


    /* ==========================================
       SMOOTH SCROLL
    ========================================== */

    document.querySelectorAll(
        '.pl-register-page a[href^="#"]'
    ).forEach(function (link) {

        link.addEventListener("click", function (e) {

            const targetId =
                this.getAttribute("href");

            if (!targetId || targetId === "#") {
                return;
            }

            const target =
                document.querySelector(targetId);

            if (target) {

                e.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });

            }

        });

    });


    /* ==========================================
       FAMILY MEMBER BUTTON
    ========================================== */

    const familyButton =
        document.querySelector(
            ".pl-family-content .pl-register-primary"
        );

    if (familyButton) {

        familyButton.addEventListener("click", function () {

            const original =
                this.innerHTML;

            this.innerHTML =
                '<i class="bi bi-check-circle-fill"></i> Family Member Added';

            this.style.background = "#42b72a";

            setTimeout(function () {

                familyButton.innerHTML = original;
                familyButton.style.background = "";

            }, 1800);

        });

    }


    /* ==========================================
       REVEAL ANIMATION
    ========================================== */

    const revealElements =
        document.querySelectorAll(
            ".pl-community-select-box, .pl-register-form-card, .pl-id-card, .pl-profession-item, .pl-status-item"
        );

    const observer =
        new IntersectionObserver(
            function (entries, observer) {

                entries.forEach(function (entry) {

                    if (!entry.isIntersecting) {
                        return;
                    }

                    entry.target.style.opacity = "1";
                    entry.target.style.transform =
                        "translateY(0)";

                    observer.unobserve(entry.target);

                });

            },
            {
                threshold: 0.12
            }
        );


    revealElements.forEach(function (element) {

        element.style.opacity = "0";
        element.style.transform =
            "translateY(15px)";

        element.style.transition =
            "opacity .5s ease, transform .5s ease";

        observer.observe(element);

    });

});
 







/* =========================================================
   PEOPLELINK FAMILY TREE PAGE JS
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       SCROLL REVEAL
    ===================================================== */

    const revealElements =
        document.querySelectorAll(".pl-family-reveal");

    if ("IntersectionObserver" in window) {

        const revealObserver = new IntersectionObserver(
            function (entries, observer) {

                entries.forEach(function (entry) {

                    if (entry.isIntersecting) {

                        entry.target.classList.add("active");

                        observer.unobserve(entry.target);

                    }

                });

            },
            {
                threshold: 0.12,
                rootMargin: "0px 0px -30px 0px"
            }
        );

        revealElements.forEach(function (element) {
            revealObserver.observe(element);
        });

    } else {

        revealElements.forEach(function (element) {
            element.classList.add("active");
        });

    }


    /* =====================================================
       SMOOTH SCROLL
    ===================================================== */

    document
        .querySelectorAll('.pl-family-page a[href^="#"]')
        .forEach(function (link) {

            link.addEventListener("click", function (event) {

                const targetId =
                    this.getAttribute("href");

                if (!targetId || targetId === "#") {
                    return;
                }

                const target =
                    document.querySelector(targetId);

                if (!target) {
                    return;
                }

                event.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });

            });

        });


    /* =====================================================
       FAMILY MEMBER CARD INTERACTION
    ===================================================== */

    const memberCards =
        document.querySelectorAll(".pl-family-member");

    memberCards.forEach(function (card) {

        card.addEventListener("click", function () {

            memberCards.forEach(function (item) {
                item.classList.remove("selected");
            });

            this.classList.add("selected");

        });

    });


    /* =====================================================
       BUTTON DEMO
       Remove this section when backend is connected
    ===================================================== */

    const demoButtons = document.querySelectorAll(
        '.pl-family-btn[href="#"]'
    );

    demoButtons.forEach(function (button) {

        button.addEventListener("click", function (event) {

            event.preventDefault();

            const originalHTML = this.innerHTML;

            this.innerHTML =
                '<i class="bi bi-check-circle-fill"></i> Request Received';

            this.classList.add("success");

            setTimeout(() => {

                this.innerHTML = originalHTML;
                this.classList.remove("success");

            }, 2200);

        });

    });


    /* =====================================================
       TREE MEMBER HOVER EFFECT
    ===================================================== */

    const treeMembers =
        document.querySelectorAll(".pl-tree-member");

    treeMembers.forEach(function (member) {

        member.addEventListener("mouseenter", function () {

            this.style.transform = "translateY(-4px)";

        });

        member.addEventListener("mouseleave", function () {

            this.style.transform = "translateY(0)";

        });

    });


    /* =====================================================
       IMAGE LOAD FALLBACK
    ===================================================== */

    const familyImages =
        document.querySelectorAll(
            ".pl-family-page img"
        );

    familyImages.forEach(function (image) {

        image.addEventListener("error", function () {

            this.style.background =
                "linear-gradient(135deg,#1261a8,#073b70)";

            this.style.objectFit = "cover";

        });

    });


    /* =====================================================
       SMALL SCROLL EFFECT FOR HERO IMAGE
    ===================================================== */

    const heroImage =
        document.querySelector(
            ".pl-family-hero-image img"
        );

    if (heroImage && window.innerWidth > 800) {

        window.addEventListener("scroll", function () {

            const scrollValue =
                window.scrollY;

            if (scrollValue < 500) {

                heroImage.style.transform =
                    "translateY(" +
                    Math.min(scrollValue * 0.025, 10) +
                    "px)";

            }

        });

    }


});







document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       SEARCH BOX
    ===================================================== */

    const searchInput =
        document.getElementById("directorySearch");

    const searchButton =
        document.getElementById("searchDirectoryBtn");

    const quickButtons =
        document.querySelectorAll(
            ".pl-dir-quick-filters button"
        );

    function performSearch(value) {

        if (!value) {
            value = "all";
        }

        const memberSection =
            document.getElementById("members");

        if (memberSection) {

            memberSection.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

        }

        if (searchInput && value !== "all") {

            searchInput.value = value;

        }

    }


    if (searchButton) {

        searchButton.addEventListener(
            "click",
            function () {

                const value =
                    searchInput ?
                    searchInput.value.trim() :
                    "";

                performSearch(value);

            }
        );

    }


    if (searchInput) {

        searchInput.addEventListener(
            "keydown",
            function (event) {

                if (event.key === "Enter") {

                    event.preventDefault();

                    performSearch(
                        this.value.trim()
                    );

                }

            }
        );

    }


    quickButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                const value =
                    this.getAttribute("data-search");

                if (searchInput) {
                    searchInput.value = value;
                }

                performSearch(value);

            }
        );

    });


    /* =====================================================
       COUNTER ANIMATION
    ===================================================== */

    const counters =
        document.querySelectorAll(
            "[data-count]"
        );

    let countersStarted = false;

    function animateCounters() {

        if (countersStarted) {
            return;
        }

        countersStarted = true;

        counters.forEach(function (counter) {

            const target =
                parseInt(
                    counter.getAttribute("data-count"),
                    10
                );

            let current = 0;

            const duration = 1300;

            const increment =
                target / (duration / 20);

            const timer =
                setInterval(function () {

                    current += increment;

                    if (current >= target) {

                        current = target;

                        clearInterval(timer);

                    }

                    counter.textContent =
                        Math.floor(current).toLocaleString() + "+";

                }, 20);

        });

    }


    const statsSection =
        document.querySelector(
            ".pl-dir-stats-section"
        );

    if (
        statsSection &&
        "IntersectionObserver" in window
    ) {

        const statsObserver =
            new IntersectionObserver(
                function (entries) {

                    entries.forEach(function (entry) {

                        if (entry.isIntersecting) {

                            animateCounters();

                            statsObserver.disconnect();

                        }

                    });

                },
                {
                    threshold:.25
                }
            );

        statsObserver.observe(statsSection);

    } else {

        animateCounters();

    }


    /* =====================================================
       PROFESSIONAL CATEGORY
    ===================================================== */

    const categories =
        document.querySelectorAll(
            ".pl-dir-category"
        );

    categories.forEach(function (category) {

        category.addEventListener(
            "click",
            function () {

                categories.forEach(function (item) {

                    item.classList.remove("active");

                });

                this.classList.add("active");

                const professionalSection =
                    document.getElementById(
                        "professional-list"
                    );

                if (professionalSection) {

                    professionalSection.scrollIntoView({
                        behavior:"smooth",
                        block:"start"
                    });

                }

            }
        );

    });


    /* =====================================================
       RESET FILTERS
    ===================================================== */

    const resetButton =
        document.querySelector(
            ".pl-dir-reset-btn"
        );

    if (resetButton) {

        resetButton.addEventListener(
            "click",
            function () {

                const inputs =
                    document.querySelectorAll(
                        ".pl-dir-input-group input"
                    );

                const selects =
                    document.querySelectorAll(
                        ".pl-dir-input-group select"
                    );

                inputs.forEach(function (input) {
                    input.value = "";
                });

                selects.forEach(function (select) {
                    select.selectedIndex = 0;
                });

            }
        );

    }


    /* =====================================================
       FILTER BUTTON
    ===================================================== */

    const filterButton =
        document.querySelector(
            ".pl-dir-filter-btn"
        );

    if (filterButton) {

        filterButton.addEventListener(
            "click",
            function () {

                const original =
                    this.innerHTML;

                this.innerHTML =
                    '<i class="bi bi-check-circle-fill"></i> Filters Applied';

                this.style.background =
                    "#42b72a";

                setTimeout(function () {

                    filterButton.innerHTML =
                        original;

                    filterButton.style.background =
                        "";

                }, 1800);

            }
        );

    }


    /* =====================================================
       PROFILE LINKS DEMO
    ===================================================== */

    const profileLinks =
        document.querySelectorAll(
            ".pl-dir-profile-link"
        );

    profileLinks.forEach(function (link) {

        link.addEventListener(
            "click",
            function (event) {

                if (
                    this.getAttribute("href") === "#"
                ) {

                    event.preventDefault();

                }

            }
        );

    });


    /* =====================================================
       BUSINESS BUTTON DEMO
    ===================================================== */

    const businessButton =
        document.querySelector(
            ".pl-dir-business-content .pl-dir-btn"
        );

    if (businessButton) {

        businessButton.addEventListener(
            "click",
            function (event) {

                if (
                    this.getAttribute("href") === "#"
                ) {

                    event.preventDefault();

                    const original =
                        this.innerHTML;

                    this.innerHTML =
                        '<i class="bi bi-check-circle-fill"></i> Profile Request Started';

                    setTimeout(function () {

                        businessButton.innerHTML =
                            original;

                    }, 2000);

                }

            }
        );

    }


    /* =====================================================
       SMOOTH SCROLL
    ===================================================== */

    document.querySelectorAll(
        '.pl-directory-page a[href^="#"]'
    ).forEach(function (link) {

        link.addEventListener(
            "click",
            function (event) {

                const id =
                    this.getAttribute("href");

                if (
                    !id ||
                    id === "#"
                ) {
                    return;
                }

                const target =
                    document.querySelector(id);

                if (!target) {
                    return;
                }

                event.preventDefault();

                target.scrollIntoView({
                    behavior:"smooth",
                    block:"start"
                });

            }
        );

    });


    /* =====================================================
       IMAGE FALLBACK
    ===================================================== */

    document.querySelectorAll(
        ".pl-directory-page img"
    ).forEach(function (image) {

        image.addEventListener(
            "error",
            function () {

                this.style.background =
                    "linear-gradient(135deg,#073b70,#1261a8)";

                this.style.objectFit =
                    "cover";

            }
        );

    });


    /* =====================================================
       HERO PARALLAX
    ===================================================== */

    const heroPhoto =
        document.querySelector(
            ".pl-dir-hero-photo"
        );

    if (
        heroPhoto &&
        window.innerWidth > 850
    ) {

        window.addEventListener(
            "scroll",
            function () {

                const scroll =
                    window.scrollY;

                if (scroll < 500) {

                    heroPhoto.style.transform =
                        "translateY(" +
                        Math.min(scroll * .025,10) +
                        "px)";

                }

            }
        );

    }

});







document.addEventListener("DOMContentLoaded", function () {

    /* =========================================
       SCROLL REVEAL
    ========================================== */

    const revealItems = document.querySelectorAll(
        ".plft-feature-card, " +
        ".plft-member-card, " +
        ".plft-info-grid div, " +
        ".plft-tree-card, " +
        ".plft-tree-features > div, " +
        ".plft-id-card, " +
        ".plft-community-card, " +
        ".plft-enquiry, " +
        ".plft-security-list div"
    );

    revealItems.forEach(function (item) {
        item.classList.add("plft-reveal");
    });

    const revealObserver = new IntersectionObserver(
        function (entries) {

            entries.forEach(function (entry) {

                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                    revealObserver.unobserve(entry.target);
                }

            });

        },
        {
            threshold: 0.12
        }
    );

    revealItems.forEach(function (item) {
        revealObserver.observe(item);
    });


    /* =========================================
       FAMILY FLOW INTERACTION
    ========================================== */

    const flowItems = document.querySelectorAll(".plft-flow-item");

    flowItems.forEach(function (item) {

        item.addEventListener("mouseenter", function () {

            flowItems.forEach(function (other) {
                other.classList.remove("active");
            });

            item.classList.add("active");

        });

    });


    /* =========================================
       SMOOTH SCROLL
    ========================================== */

    document.querySelectorAll('a[href^="#"]').forEach(function (link) {

        link.addEventListener("click", function (e) {

            const targetId = this.getAttribute("href");

            if (!targetId || targetId === "#") {
                e.preventDefault();
                return;
            }

            const target = document.querySelector(targetId);

            if (target) {

                e.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });

            }

        });

    });


    /* =========================================
       HERO PARALLAX
    ========================================== */

    const visual = document.querySelector(".plft-family-visual");

    if (visual && window.innerWidth > 900) {

        window.addEventListener("mousemove", function (e) {

            const x = (window.innerWidth / 2 - e.clientX) / 70;
            const y = (window.innerHeight / 2 - e.clientY) / 70;

            visual.style.transform =
                "translate3d(" + x + "px," + y + "px,0)";

        });

    }


    /* =========================================
       BUTTON DEMO FEEDBACK
    ========================================== */

    document.querySelectorAll(
        '.plft-page a[href="#"]'
    ).forEach(function (button) {

        button.addEventListener("click", function (e) {

            e.preventDefault();

            const original = this.innerHTML;

            this.innerHTML =
                '<i class="bi bi-check-circle-fill"></i> Request Received';

            setTimeout(function () {

                button.innerHTML = original;

            }, 1800);

        });

    });


    /* =========================================
       IMAGE FALLBACK
    ========================================== */

    document.querySelectorAll(".plft-page img").forEach(function (img) {

        img.addEventListener("error", function () {

            this.style.background =
                "linear-gradient(135deg,#073b70,#1261a8)";

            this.style.objectFit = "cover";

        });

    });

});







document.addEventListener("DOMContentLoaded", function () {

    /* =========================================
       SAVE PROFILE
    ========================================== */

    document.querySelectorAll(".pl-mat-save").forEach(function(button){

        button.addEventListener("click", function(){

            const icon = this.querySelector("i");

            this.classList.toggle("saved");

            if(this.classList.contains("saved")){

                icon.classList.remove("bi-bookmark");
                icon.classList.add("bi-bookmark-fill");

                this.style.color = "#e72d55";

            }else{

                icon.classList.remove("bi-bookmark-fill");
                icon.classList.add("bi-bookmark");

                this.style.color = "";

            }

        });

    });


    /* =========================================
       SEARCH BUTTON
    ========================================== */

    const searchButton =
        document.querySelector(".pl-mat-search-btn");

    if(searchButton){

        searchButton.addEventListener("click", function(){

            const original = this.innerHTML;

            this.innerHTML =
                '<i class="bi bi-check-circle-fill"></i> Search Ready';

            setTimeout(() => {
                this.innerHTML = original;
            }, 1600);

        });

    }


    /* =========================================
       SMOOTH SCROLL
    ========================================== */

    document.querySelectorAll(
        '.pl-matrimony-page a[href^="#"]'
    ).forEach(function(link){

        link.addEventListener("click", function(e){

            const id = this.getAttribute("href");

            if(!id || id === "#"){
                e.preventDefault();
                return;
            }

            const target = document.querySelector(id);

            if(target){

                e.preventDefault();

                target.scrollIntoView({
                    behavior:"smooth",
                    block:"start"
                });

            }

        });

    });


    /* =========================================
       IMAGE FALLBACK
    ========================================== */

    document.querySelectorAll(
        ".pl-matrimony-page img"
    ).forEach(function(img){

        img.addEventListener("error", function(){

            this.style.background =
                "linear-gradient(135deg,#073b70,#1261a8)";

        });

    });


    /* =========================================
       REVEAL ANIMATION
    ========================================== */

    const elements = document.querySelectorAll(
        ".pl-mat-feature, " +
        ".pl-mat-profile-card, " +
        ".pl-mat-package, " +
        ".pl-mat-community-card, " +
        ".pl-mat-profile-fields div, " +
        ".pl-mat-privacy-items div"
    );

    elements.forEach(function(el){

        el.style.opacity = "0";
        el.style.transform = "translateY(18px)";
        el.style.transition =
            "opacity .6s ease, transform .6s ease";

    });


    const observer = new IntersectionObserver(
        function(entries){

            entries.forEach(function(entry){

                if(entry.isIntersecting){

                    entry.target.style.opacity = "1";
                    entry.target.style.transform =
                        "translateY(0)";

                    observer.unobserve(entry.target);

                }

            });

        },
        {
            threshold:.12
        }
    );


    elements.forEach(function(el){
        observer.observe(el);
    });


    /* =========================================
       HERO IMAGE PARALLAX
    ========================================== */

    const heroVisual =
        document.querySelector(".pl-mat-hero-visual");

    if(heroVisual && window.innerWidth > 1000){

        window.addEventListener("mousemove", function(e){

            const x =
                (window.innerWidth / 2 - e.clientX) / 90;

            const y =
                (window.innerHeight / 2 - e.clientY) / 90;

            heroVisual.style.transform =
                `translate(${x}px,${y}px)`;

        });

    }

});





 
document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       SEARCH TYPE SWITCHER
    ====================================================== */

    const searchTabs =
        document.querySelectorAll(".pl-search-tab");

    const searchInput =
        document.getElementById("portalSearchInput");

    const searchButton =
        document.getElementById("portalSearchButton");


    const searchData = {

        jobs: {
            placeholder: "Search jobs, skills, companies..."
        },

        matrimony: {
            placeholder: "Search profiles, community, profession..."
        },

        business: {
            placeholder: "Search businesses, services..."
        },

        near: {
            placeholder: "What are you looking for nearby?"
        }

    };


    searchTabs.forEach(function (tab) {

        tab.addEventListener("click", function () {

            searchTabs.forEach(function (item) {
                item.classList.remove("active");
            });

            tab.classList.add("active");

            const type =
                tab.getAttribute("data-search");

            if (
                searchInput &&
                searchData[type]
            ) {

                searchInput.placeholder =
                    searchData[type].placeholder;

            }

        });

    });


    /* =====================================================
       SEARCH BUTTON
    ====================================================== */

    if (searchButton) {

        searchButton.addEventListener("click", function () {

            const activeTab =
                document.querySelector(
                    ".pl-search-tab.active"
                );

            const searchType =
                activeTab
                    ? activeTab.dataset.search
                    : "jobs";

            const searchValue =
                searchInput
                    ? searchInput.value.trim()
                    : "";

            /*
             * Replace these URLs with your actual
             * portal routes.
             */

            const routes = {

                jobs: "jobs.php",
                matrimony: "matrimony.php",
                business: "business.php",
                near: "near-me.php"

            };

            const destination =
                routes[searchType] || "search.php";


            if (searchValue) {

                window.location.href =
                    destination +
                    "?q=" +
                    encodeURIComponent(searchValue);

            } else {

                window.location.href =
                    destination;

            }

        });

    }


    /* =====================================================
       POPULAR SEARCH BUTTONS
    ====================================================== */

    const popularButtons =
        document.querySelectorAll(
            ".pl-popular-searches button"
        );

    popularButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            if (!searchInput) return;

            searchInput.value =
                button.textContent.trim();

            searchInput.focus();

        });

    });


    /* =====================================================
       COMMUNITY SELECTOR
    ====================================================== */

    const communityButtons =
        document.querySelectorAll(
            ".pl-community-pill"
        );


    communityButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            communityButtons.forEach(function (item) {

                item.classList.remove("active");

            });

            button.classList.add("active");

            const community =
                button.dataset.community;

            /*
             * Later you can redirect to:
             *
             * community.php?name=...
             *
             * For now we only change active state.
             */

            console.log(
                "Selected community:",
                community
            );

        });

    });


    /* =====================================================
       SMOOTH SCROLL
    ====================================================== */

    document.querySelectorAll(
        'a[href^="#"]'
    ).forEach(function (anchor) {

        anchor.addEventListener(
            "click",
            function (event) {

                const targetId =
                    anchor.getAttribute("href");

                if (
                    targetId === "#" ||
                    targetId.length < 2
                ) {
                    return;
                }

                const target =
                    document.querySelector(targetId);

                if (!target) return;

                event.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });

            }
        );

    });


    /* =====================================================
       INTERSECTION ANIMATION
    ====================================================== */

    const animatedElements =
        document.querySelectorAll(
            ".pl-service-card, .pl-quick-card, .pl-connection-node"
        );


    const observer =
        new IntersectionObserver(
            function (entries) {

                entries.forEach(function (entry) {

                    if (entry.isIntersecting) {

                        entry.target.style.opacity = "1";
                        entry.target.style.transform =
                            "translateY(0)";

                        observer.unobserve(
                            entry.target
                        );

                    }

                });

            },
            {
                threshold: 0.1
            }
        );


    animatedElements.forEach(function (element) {

        element.style.opacity = "0";

        element.style.transform =
            "translateY(15px)";

        element.style.transition =
            "opacity .6s ease, transform .6s ease";

        observer.observe(element);

    });

});







document.addEventListener("DOMContentLoaded", function () {
    const page = document.querySelector(".pl-matrimony-detail-page");

    if (!page) return;

    const toast = page.querySelector("#plMdToast");
    const saveBtn = page.querySelector("#plMdSaveBtn");
    const interestBtn = page.querySelector("#plMdInterestBtn");
    const requestContactBtn = page.querySelector("#plMdRequestContact");
    const viewContactBtn = page.querySelector("#plMdViewContact");
    const contactMessage = page.querySelector("#plMdContactMessage");
    const lightbox = page.querySelector("#plMdLightbox");
    const lightboxImage = page.querySelector("#plMdLightboxImage");
    const lightboxClose = page.querySelector("#plMdLightboxClose");
    const similarTrack = page.querySelector("#plMdSimilarTrack");

    let toastTimeout;
    let saved = false;
    let interested = false;
    let lastFocusedElement = null;

    /* Toast notification */
    function showToast(message) {
        if (!toast) return;

        toast.textContent = message;
        toast.classList.add("is-visible");

        clearTimeout(toastTimeout);

        toastTimeout = setTimeout(function () {
            toast.classList.remove("is-visible");
        }, 3200);
    }

    /* Save profile (real API) */
    function profileRef() {
        return new URLSearchParams(window.location.search).get("id") || "";
    }

    function goLogin() {
        setTimeout(function () { window.location.href = "/peoplelink/matrimoney/login.php"; }, 1200);
    }

    function toggleSaveProfile() {
        window.plToggleSave(profileRef()).then(function (res) {
            if (!res.ok) {
                showToast(res.error || "Could not save this profile.");
                if (res.login) goLogin();
                return;
            }
            saved = !!res.saved;

            if (saveBtn) {
                saveBtn.classList.toggle("is-active", saved);
                saveBtn.setAttribute("aria-pressed", String(saved));
                saveBtn.innerHTML = saved
                    ? '<i class="bi bi-bookmark-check-fill"></i><span>Profile Saved</span>'
                    : '<i class="bi bi-bookmark"></i><span>Save Profile</span>';
            }
            showToast(res.message || (saved ? "Profile saved." : "Removed from saved profiles."));
        });
    }

    if (saveBtn) {
        saveBtn.addEventListener("click", toggleSaveProfile);
    }

    /* Express interest (real API) */
    function toggleInterest() {
        if (interested) {
            showToast("Interest already sent to this profile.");
            return;
        }
        window.plSendInterest(profileRef(), "").then(function (res) {
            if (!res.ok) {
                showToast(res.error || "Could not send interest.");
                if (res.login) goLogin();
                return;
            }
            interested = true;
            if (interestBtn) {
                interestBtn.classList.add("is-active");
                interestBtn.innerHTML = '<i class="bi bi-heart-fill"></i> Interest Sent';
            }
            showToast(res.message || "Interest sent.");
        });
    }

    if (interestBtn) {
        interestBtn.addEventListener("click", toggleInterest);
    }

    /* Sidebar action buttons */
    page.querySelectorAll('[data-action="save"]').forEach(function (button) {
        button.addEventListener("click", function () {
            toggleSaveProfile();
        });
    });

    page.querySelectorAll('[data-action="interest"]').forEach(function (button) {
        button.addEventListener("click", function () {
            toggleInterest();
        });
    });

    /* Contact request feedback */
    if (requestContactBtn) {
        requestContactBtn.addEventListener("click", function () {
            if (contactMessage) {
                contactMessage.hidden = false;
                contactMessage.innerHTML =
                    '<i class="bi bi-check-circle-fill"></i> ' +
                    'Your request has been selected in this demo. ' +
                    'A live website must submit this request to the server ' +
                    'and follow the profile owner’s privacy settings.';
            }

            showToast("Contact request demo activated.");
        });
    }

    /* View contact access */
    if (viewContactBtn) {
        viewContactBtn.addEventListener("click", function () {
            showToast(
                "Contact details require login and permission checks on the live website."
            );
        });
    }

    /* Profile gallery and lightbox */
    function openLightbox(imageUrl, altText) {
        if (!lightbox || !lightboxImage) return;

        lastFocusedElement = document.activeElement;
        lightboxImage.src = imageUrl;
        lightboxImage.alt = altText || "Profile photo";
        lightbox.hidden = false;
        document.body.style.overflow = "hidden";

        if (lightboxClose) {
            lightboxClose.focus();
        }
    }

    function closeLightbox() {
        if (!lightbox || lightbox.hidden) return;

        lightbox.hidden = true;
        lightboxImage.src = "";
        document.body.style.overflow = "";

        if (lastFocusedElement) {
            lastFocusedElement.focus();
        }
    }

    page.querySelectorAll(".pl-md-gallery-item").forEach(function (item) {
        item.addEventListener("click", function () {
            if (item.dataset.locked === "true") {
                showToast(
                    "This photo is private. A live website should check permissions before granting access."
                );
                return;
            }

            const image = item.querySelector("img");
            const imageUrl = item.dataset.photo;

            if (imageUrl) {
                openLightbox(
                    imageUrl,
                    image ? image.alt : "Profile photo"
                );
            }
        });
    });

    if (lightboxClose) {
        lightboxClose.addEventListener("click", closeLightbox);
    }

    if (lightbox) {
        lightbox.addEventListener("click", function (event) {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });
    }

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeLightbox();
        }
    });

    /* Similar profiles carousel */
    const previousButton = page.querySelector("#plMdPrev");
    const nextButton = page.querySelector("#plMdNext");

    function scrollSimilarProfiles(direction) {
        if (!similarTrack) return;

        const firstCard = similarTrack.querySelector(".pl-md-similar-card");
        if (!firstCard) return;

        const styles = window.getComputedStyle(similarTrack);
        const gap = parseFloat(styles.columnGap) || 13;
        const distance = firstCard.getBoundingClientRect().width + gap;

        similarTrack.scrollBy({
            left: distance * direction,
            behavior: "smooth"
        });
    }

    if (previousButton) {
        previousButton.addEventListener("click", function () {
            scrollSimilarProfiles(-1);
        });
    }

    if (nextButton) {
        nextButton.addEventListener("click", function () {
            scrollSimilarProfiles(1);
        });
    }

    /* Demo profile buttons */
    page.querySelectorAll(".pl-md-view-profile").forEach(function (button) {
        button.addEventListener("click", function () {
            const profileName = button.dataset.profile || "This profile";

            showToast(
                profileName +
                " is a sample profile. Connect this button to your profile details URL."
            );
        });
    });
});





document.addEventListener("DOMContentLoaded", function () {
    const page = document.querySelector(".pl-matrimony-search");
    if (!page) return;

    const $ = (selector) => page.querySelector(selector);

    const form = $("#plMsFilterForm");
    const quickForm = $("#plMsQuickForm");
    const profileList = $("#plMsProfileList");
    const emptyState = $("#plMsEmpty");
    const summary = $("#plMsResultSummary");
    const bottomCount = $("#plMsBottomCount");
    const activeFilters = $("#plMsActiveFilters");
    const sortSelect = $("#plMsSort");
    const loadMoreBtn = $("#plMsLoadMore");
    const savedCount = $("#plMsSavedCount");
    const toast = $("#plMsToast");
    const modal = $("#plMsSearchModal");
    const savedSearchList = $("#plMsSavedSearchList");

    let toastTimer;
    let visibleLimit = 4;
    let savedOnly = false;
    let savedProfiles = new Set();
    let savedSearches = [];
    let currentResults = [];
    let currentFilters = {};

    /*
     * Demonstration profiles only.
     * Replace this array with profiles fetched from PHP/MySQL.
     * Profile photos and names below are illustrative.
     */
    const profiles = [
                {
            id: "PLM1001",
            name: "Suresh Kumar",
            age: 28,
            gender: "Male",
            height: 5.9,
            marital: "Never Married",
            education: "B.Tech / MBA",
            profession: "Software Engineer",
            city: "Hyderabad",
            district: "Hyderabad",
            state: "Telangana",
            country: "India",
            community: "Arya Vysya",
            recent: 12,
            photo: "/peoplelink/first/images/in/man-2.jpg?auto=format&fit=crop&w=500&q=80",
            intro: "A tech professional who appreciates family values, honest conversations, and personal growth."
        },
        {
            id: "PLM1002",
            name: "Anitha R",
            age: 26,
            gender: "Female",
            height: 5.4,
            marital: "Never Married",
            education: "Postgraduate",
            profession: "Finance Professional",
            city: "Bengaluru",
            district: "Bengaluru Urban",
            state: "Karnataka",
            country: "India",
            community: "Arya Vysya",
            recent: 11,
            photo: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=500&q=80",
            intro: "Enjoys travelling, reading, music, and spending quality time with loved ones."
        }
    ];

    const filterFields = [
        "plMsKeyword",
        "plMsProfileId",
        "plMsGender",
        "plMsMarital",
        "plMsMinAge",
        "plMsMaxAge",
        "plMsMinHeight",
        "plMsMaxHeight",
        "plMsEducation",
        "plMsProfession",
        "plMsCountry",
        "plMsState",
        "plMsDistrict",
        "plMsCity",
        "plMsPartnerMinAge",
        "plMsPartnerMaxAge",
        "plMsPartnerEducation",
        "plMsPartnerProfession",
        "plMsPartnerLocation"
    ];

    const labelMap = {
        plMsKeyword: "Keyword",
        plMsProfileId: "Profile ID",
        plMsGender: "Gender",
        plMsMarital: "Marital status",
        plMsMinAge: "Minimum age",
        plMsMaxAge: "Maximum age",
        plMsMinHeight: "Minimum height",
        plMsMaxHeight: "Maximum height",
        plMsEducation: "Education",
        plMsProfession: "Profession",
        plMsCountry: "Country",
        plMsState: "State",
        plMsDistrict: "District",
        plMsCity: "City",
        plMsPartnerMinAge: "Preferred minimum age",
        plMsPartnerMaxAge: "Preferred maximum age",
        plMsPartnerEducation: "Preferred education",
        plMsPartnerProfession: "Preferred profession",
        plMsPartnerLocation: "Preferred location"
    };

    function showToast(message) {
        if (!toast) return;

        toast.textContent = message;
        toast.classList.add("is-visible");

        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () {
            toast.classList.remove("is-visible");
        }, 3200);
    }

    function normalize(value) {
        return String(value ?? "").trim().toLowerCase();
    }

    function includesText(value, query) {
        return normalize(value).includes(normalize(query));
    }

    function getValue(id) {
        const element = $("#" + id);
        return element ? element.value.trim() : "";
    }

    function getFilters() {
        const filters = {};

        filterFields.forEach(function (id) {
            filters[id] = getValue(id);
        });

        filters.community = getValue("plMsCommunity");
        return filters;
    }

    function readNumber(value) {
        return value === "" ? null : Number(value);
    }

    function heightLabel(height) {
        const totalInches = Math.round(height * 12);
        const feet = Math.floor(totalInches / 12);
        const inches = totalInches % 12;

        return feet + "'" + inches + '"';
    }

    function educationMatches(profileEducation, selected) {
        if (!selected) return true;

        const education = normalize(profileEducation);

        if (selected === "Graduate") {
            return ["graduate", "postgraduate", "mba", "engineering", "medical"]
                .some(function (value) {
                    return education.includes(value);
                });
        }

        if (selected === "Postgraduate") {
            return ["postgraduate", "mba", "m.tech", "m.com", "m.a.", "m.sc."]
                .some(function (value) {
                    return education.includes(value);
                });
        }

        if (selected === "Other") {
            return ![
                "graduate", "postgraduate", "mba",
                "engineering", "medical"
            ].some(function (value) {
                return education.includes(value);
            });
        }

        return education.includes(normalize(selected));
    }

    function professionMatches(profileProfession, selected) {
        if (!selected) return true;

        const profession = normalize(profileProfession);

        if (selected === "Other") {
            return ![
                "it professional", "doctor", "engineer",
                "teacher", "business", "government employee",
                "finance professional"
            ].some(function (value) {
                return profession.includes(value);
            });
        }

        return profession.includes(normalize(selected));
    }

    function matchesProfile(profile, filters) {
        /*
         * Strict community restriction:
         * profiles from other communities are never returned.
         */
        if (profile.community !== filters.community) return false;

        const keyword = normalize(filters.plMsKeyword);

        if (
            keyword &&
            !includesText(profile.name, keyword) &&
            !includesText(profile.id, keyword)
        ) {
            return false;
        }

        if (
            filters.plMsProfileId &&
            !includesText(profile.id, filters.plMsProfileId)
        ) {
            return false;
        }

        if (
            filters.plMsGender &&
            profile.gender !== filters.plMsGender
        ) {
            return false;
        }

        if (
            filters.plMsMarital &&
            profile.marital !== filters.plMsMarital
        ) {
            return false;
        }

        const minAge = readNumber(filters.plMsMinAge);
        const maxAge = readNumber(filters.plMsMaxAge);

        if (minAge !== null && profile.age < minAge) return false;
        if (maxAge !== null && profile.age > maxAge) return false;

        const minHeight = readNumber(filters.plMsMinHeight);
        const maxHeight = readNumber(filters.plMsMaxHeight);

        if (minHeight !== null && profile.height < minHeight) return false;
        if (maxHeight !== null && profile.height > maxHeight) return false;

        if (!educationMatches(profile.education, filters.plMsEducation)) {
            return false;
        }

        if (!professionMatches(profile.profession, filters.plMsProfession)) {
            return false;
        }

        if (
            filters.plMsCountry &&
            !includesText(profile.country, filters.plMsCountry)
        ) {
            return false;
        }

        if (
            filters.plMsState &&
            !includesText(profile.state, filters.plMsState)
        ) {
            return false;
        }

        if (
            filters.plMsDistrict &&
            !includesText(profile.district, filters.plMsDistrict)
        ) {
            return false;
        }

        if (
            filters.plMsCity &&
            !includesText(profile.city, filters.plMsCity)
        ) {
            return false;
        }

        const partnerMin = readNumber(filters.plMsPartnerMinAge);
        const partnerMax = readNumber(filters.plMsPartnerMaxAge);

        if (partnerMin !== null && profile.age < partnerMin) return false;
        if (partnerMax !== null && profile.age > partnerMax) return false;

        if (
            filters.plMsPartnerEducation &&
            !educationMatches(profile.education, filters.plMsPartnerEducation)
        ) {
            return false;
        }

        if (
            filters.plMsPartnerProfession &&
            !professionMatches(profile.profession, filters.plMsPartnerProfession)
        ) {
            return false;
        }

        if (
            filters.plMsPartnerLocation &&
            ![
                profile.city,
                profile.district,
                profile.state,
                profile.country
            ].some(function (location) {
                return includesText(location, filters.plMsPartnerLocation);
            })
        ) {
            return false;
        }

        if (savedOnly && !savedProfiles.has(profile.id)) {
            return false;
        }

        return true;
    }

    function getSortedProfiles(results) {
        const sorted = results.slice();
        const sort = sortSelect ? sortSelect.value : "recent";

        switch (sort) {
            case "age-asc":
                sorted.sort((a, b) => a.age - b.age);
                break;

            case "age-desc":
                sorted.sort((a, b) => b.age - a.age);
                break;

            case "location":
                sorted.sort((a, b) => a.city.localeCompare(b.city));
                break;

            case "education":
                sorted.sort((a, b) => a.education.localeCompare(b.education));
                break;

            case "profession":
                sorted.sort((a, b) => a.profession.localeCompare(b.profession));
                break;

            case "recent":
            default:
                sorted.sort((a, b) => b.recent - a.recent);
                break;
        }

        return sorted;
    }

    function escapeHTML(value) {
        return String(value ?? "").replace(/[&<>"']/g, function (character) {
            const entities = {
                "&": "&amp;",
                "<": "&lt;",
                ">": "&gt;",
                '"': "&quot;",
                "'": "&#39;"
            };

            return entities[character];
        });
    }

  function profileCard(profile) {
    const isSaved = savedProfiles.has(profile.id);

    return `
        <article class="pl-ms-profile-card" data-profile-id="${escapeHTML(profile.id)}">

            <div class="pl-ms-profile-photo">
                <img
                    src="${escapeHTML(profile.photo)}"
                    alt="Illustrative portrait for ${escapeHTML(profile.name)}"
                    loading="lazy">

                <span class="pl-ms-photo-badge">
                    <i class="bi bi-patch-check-fill"></i> Sample profile
                </span>
            </div>

            <div class="pl-ms-profile-info">

                <div class="pl-ms-profile-top">
                    <div>
                        <span class="pl-ms-profile-id">
                            PROFILE ID: ${escapeHTML(profile.id)}
                        </span>

                        <h3 class="pl-ms-profile-name">
                            ${escapeHTML(profile.name)}
                            <i class="bi bi-patch-check-fill"
                               aria-label="Example verification badge"></i>
                        </h3>
                    </div>

                    <button type="button"
                            class="pl-ms-save-profile ${isSaved ? "is-saved" : ""}"
                            data-save-profile="${escapeHTML(profile.id)}"
                            aria-pressed="${isSaved}"
                            aria-label="${isSaved ? "Remove saved profile" : "Save profile"}">
                        <i class="bi ${isSaved ? "bi-bookmark-heart-fill" : "bi-bookmark"}"></i>
                    </button>
                </div>

                <p class="pl-ms-profile-summary">
                    ${escapeHTML(profile.intro)}
                </p>

                <div class="pl-ms-profile-facts">
                    <span>
                        <i class="bi bi-calendar-heart"></i>
                        ${profile.age} years
                    </span>

                    <span>
                        <i class="bi bi-person"></i>
                        ${escapeHTML(profile.gender)}
                    </span>

                    <span>
                        <i class="bi bi-rulers"></i>
                        ${heightLabel(profile.height)}
                    </span>

                    <span>
                        <i class="bi bi-geo-alt"></i>
                        ${escapeHTML(profile.city)}
                    </span>
                </div>

                <div class="pl-ms-profile-divider"></div>

                <div class="pl-ms-profile-details">

                    <div class="pl-ms-profile-detail">
                        <small>Education</small>
                        <strong>
                            ${escapeHTML(profile.education)}
                        </strong>
                    </div>

                    <div class="pl-ms-profile-detail">
                        <small>Profession</small>
                        <strong>
                            ${escapeHTML(profile.profession)}
                        </strong>
                    </div>

                    <div class="pl-ms-profile-detail">
                        <small>Marital Status</small>
                        <strong>
                            ${escapeHTML(profile.marital)}
                        </strong>
                    </div>

                </div>

                <div class="pl-ms-profile-bottom">

                    <span class="pl-ms-community-tag">
                        <i class="bi bi-people"></i>
                        ${escapeHTML(profile.community)}
                    </span>

                    <a href="matrimony-profile-details.php?id=${encodeURIComponent(profile.id)}"
                       class="pl-ms-view-profile">
                        View Profile
                        <i class="bi bi-arrow-up-right"></i>
                    </a>

                </div>

            </div>
        </article>
    `;
}
    function renderActiveFilters(filters) {
        if (!activeFilters) return;

        const chips = [];

        filterFields.forEach(function (id) {
            const value = filters[id];

            if (value) {
                chips.push(`
                    <span class="pl-ms-filter-chip">
                        ${escapeHTML(labelMap[id])}: ${escapeHTML(value)}
                        <button type="button"
                                data-clear-filter="${id}"
                                aria-label="Clear ${escapeHTML(labelMap[id])}">
                            <i class="bi bi-x"></i>
                        </button>
                    </span>
                `);
            }
        });

        activeFilters.innerHTML = chips.join("");
    }

    function render() {
        currentFilters = getFilters();

        const matches = profiles.filter(function (profile) {
            return matchesProfile(profile, currentFilters);
        });

        currentResults = getSortedProfiles(matches);

        renderActiveFilters(currentFilters);

        if (summary) {
            const count = currentResults.length;
            summary.textContent =
                count + (count === 1 ? " matching profile" : " matching profiles") +
                " in " + currentFilters.community + ".";
        }

        const shown = currentResults.slice(0, visibleLimit);

        if (profileList) {
            profileList.innerHTML = shown.map(profileCard).join("");
        }

        if (emptyState) {
            emptyState.hidden = currentResults.length !== 0;
        }

        if (profileList) {
            profileList.hidden = currentResults.length === 0;
        }

        if (bottomCount) {
            bottomCount.textContent = currentResults.length
                ? "Showing " + shown.length + " of " + currentResults.length + " profiles"
                : "No profiles to display";
        }

        if (loadMoreBtn) {
            loadMoreBtn.hidden = shown.length >= currentResults.length;
        }

        if (savedCount) {
            savedCount.textContent = String(savedProfiles.size);
        }
    }

    function applyFilters() {
        savedOnly = false;
        visibleLimit = 4;
        render();
    }

    if (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            applyFilters();
            showToast("Search filters applied.");
        });
    }

    if (quickForm) {
        quickForm.addEventListener("submit", function (event) {
            event.preventDefault();
            applyFilters();

            const resultsTop = $("#plMsResultSummary");

            if (resultsTop) {
                resultsTop.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener("change", function () {
            visibleLimit = 4;
            render();
        });
    }

    /* Remove individual filter chips */
    if (activeFilters) {
        activeFilters.addEventListener("click", function (event) {
            const button = event.target.closest("[data-clear-filter]");
            if (!button) return;

            const input = $("#" + button.dataset.clearFilter);
            if (input) input.value = "";

            applyFilters();
        });
    }

    /* Reset filters while keeping the chosen community */
    function resetFilters() {
        filterFields.forEach(function (id) {
            const input = $("#" + id);
            if (input) input.value = "";
        });

        savedOnly = false;
        visibleLimit = 4;

        if (sortSelect) sortSelect.value = "recent";

        render();
        showToast("Filters have been reset. Your selected community is unchanged.");
    }

    ["plMsReset", "plMsResetTop", "plMsEmptyReset"].forEach(function (id) {
        const button = $("#" + id);

        if (button) {
            button.addEventListener("click", resetFilters);
        }
    });

    /* Change community: results remain strictly community-specific */
    const communitySelect = $("#plMsCommunity");

    if (communitySelect) {
        communitySelect.addEventListener("change", function () {
            savedOnly = false;
            visibleLimit = 4;
            render();
        });
    }

    /* Save/unsave profiles */
    if (profileList) {
        profileList.addEventListener("click", function (event) {
            const saveButton = event.target.closest("[data-save-profile]");

            if (saveButton) {
                const profileId = saveButton.dataset.saveProfile;

                if (savedProfiles.has(profileId)) {
                    savedProfiles.delete(profileId);
                    const fdUnsave = new FormData();
                    fdUnsave.append("action", "toggle_save");
                    fdUnsave.append("profile_id", profileId);
                    fetch("/peoplelink/matrimoney/api.php", { method: "POST", body: fdUnsave })
                    .then(r => r.json()).then(res => { if(!res.ok) console.warn(res.error); });
                    showToast("Profile removed from your saved list.");
                } else {
                    savedProfiles.add(profileId);
                    showToast("Profile saved to your list.");
                    const fdSave = new FormData();
                    fdSave.append("action", "toggle_save");
                    fdSave.append("profile_id", profileId);
                    fetch("/peoplelink/matrimoney/api.php", { method: "POST", body: fdSave })
                    .then(r => r.json()).then(res => { if(!res.ok) console.warn(res.error); });
                }

                render();
                return;
            }

            const viewButton = event.target.closest("[data-view-profile]");

            if (viewButton) {
                const profileId = viewButton.dataset.viewProfile;

                window.location.href = "matrimony-profile-details.php?id=" + encodeURIComponent(profileId);

                /*
                 * For your live website, replace the message above with
                 * navigation to your real profile URL.
                 *
                 * Example:
                 * window.location.href =
                 *   "matrimony-profile-details.php?id=" +
                 *   encodeURIComponent(profileId);
                 */
            }
        });
    }

    /* Saved profiles filter */
    const savedProfilesButton = $("#plMsSavedProfiles");

    if (savedProfilesButton) {
        savedProfilesButton.addEventListener("click", function () {
            savedOnly = !savedOnly;
            visibleLimit = 4;
            render();

            showToast(
                savedOnly
                    ? "Showing your saved profiles in this demo."
                    : "Showing all matching profiles."
            );
        });
    }

    /* Show more results */
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener("click", function () {
            visibleLimit += 4;
            render();
        });
    }

    /* Build a snapshot of the current search */
    function captureSearch() {
        return {
            id: "search-" + Date.now() + "-" + Math.random().toString(36).slice(2, 7),
            name: "My " + getValue("plMsCommunity") + " Search",
            filters: getFilters(),
            created: new Date().toLocaleDateString()
        };
    }

    /* Save current search */
    const saveSearchButton = $("#plMsSaveSearch");

    if (saveSearchButton) {
        saveSearchButton.addEventListener("click", function () {
            savedSearches.push(captureSearch());
            renderSavedSearches();
            showToast("Search saved in this demo.");
        });
    }

    /* Saved searches modal */
    function openSavedSearches() {
        renderSavedSearches();

        if (modal) {
            modal.hidden = false;
            document.body.style.overflow = "hidden";

            const closeButton = modal.querySelector(".pl-ms-modal-close");
            if (closeButton) closeButton.focus();
        }
    }

    function closeSavedSearches() {
        if (!modal || modal.hidden) return;

        modal.hidden = true;
        document.body.style.overflow = "";
    }

    const savedSearchesButton = $("#plMsSavedSearches");

    if (savedSearchesButton) {
        savedSearchesButton.addEventListener("click", openSavedSearches);
    }

    if (modal) {
        modal.addEventListener("click", function (event) {
            if (event.target.closest("[data-close-modal]")) {
                closeSavedSearches();
            }
        });
    }

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeSavedSearches();
        }
    });

    function describeSearch(filters) {
        const parts = [filters.community];

        if (filters.plMsMinAge || filters.plMsMaxAge) {
            parts.push(
                "Age " +
                (filters.plMsMinAge || "any") +
                "–" +
                (filters.plMsMaxAge || "any")
            );
        }

        if (filters.plMsCity) parts.push(filters.plMsCity);
        if (filters.plMsEducation) parts.push(filters.plMsEducation);
        if (filters.plMsProfession) parts.push(filters.plMsProfession);
        if (filters.plMsGender) parts.push(filters.plMsGender);

        return parts.join(" · ");
    }

    function renderSavedSearches() {
        if (!savedSearchList) return;

        if (savedSearches.length === 0) {
            savedSearchList.innerHTML =
                '<div class="pl-ms-modal-empty">' +
                '<i class="bi bi-bookmark"></i><br><br>' +
                'You have not saved any searches yet.' +
                '</div>';
            return;
        }

        savedSearchList.innerHTML = savedSearches.map(function (search) {
            return `
                <div class="pl-ms-saved-search-item"
                     data-search-item="${escapeHTML(search.id)}">
                    <div>
                        <strong>${escapeHTML(search.name)}</strong>
                        <small>${escapeHTML(describeSearch(search.filters))}</small>
                        <small>Saved ${escapeHTML(search.created)}</small>
                    </div>

                    <div class="pl-ms-saved-search-actions">
                        <button type="button"
                                data-load-search="${escapeHTML(search.id)}">
                            Apply
                        </button>
                        <button type="button"
                                data-delete-search="${escapeHTML(search.id)}"
                                aria-label="Delete saved search">
                            Delete
                        </button>
                    </div>
                </div>
            `;
        }).join("");
    }

    function applySavedSearch(search) {
        if (!search) return;

        if (communitySelect) {
            communitySelect.value = search.filters.community;
        }

        filterFields.forEach(function (id) {
            const input = $("#" + id);
            if (input) {
                input.value = search.filters[id] || "";
            }
        });

        savedOnly = false;
        visibleLimit = 4;

        closeSavedSearches();
        render();
        showToast("Saved search applied.");
    }

    if (savedSearchList) {
        savedSearchList.addEventListener("click", function (event) {
            const loadButton = event.target.closest("[data-load-search]");
            const deleteButton = event.target.closest("[data-delete-search]");

            if (loadButton) {
                const search = savedSearches.find(function (item) {
                    return item.id === loadButton.dataset.loadSearch;
                });

                applySavedSearch(search);
            }

            if (deleteButton) {
                savedSearches = savedSearches.filter(function (item) {
                    return item.id !== deleteButton.dataset.deleteSearch;
                });

                renderSavedSearches();
                showToast("Saved search deleted.");
            }
        });
    }

    /* Initial render */
    render();
});









// PEOPLELINK GLOBAL JOBS - PAGE 14
(() => {
  "use strict";

  const root = document.querySelector(".pl-global-jobs");
  if (!root) return;

  const $ = (selector, scope = root) => scope.querySelector(selector);
  const $$ = (selector, scope = root) => [...scope.querySelectorAll(selector)];

  const STORAGE = {
    saved: "peoplelink_global_jobs_saved_v1",
    alerts: "peoplelink_global_jobs_alerts_v1"
  };

  // Illustrative demo data. Replace with approved jobs from your PHP/MySQL API.
  const jobs = [
    {
      id: 101,
      title: "PHP Web Developer",
      company: "Digital Solutions Group",
      location: "Remote / India",
      category: "IT & Software",
      experience: "1–2 years",
      experienceLevel: "1-2",
      qualification: "Graduate",
      type: "Full-time",
      salary: "₹3–5 LPA",
      salaryValue: 400000,
      posted: "2026-10-01",
      skills: ["PHP", "MySQL", "JavaScript", "HTML/CSS"],
      description: "Develop and maintain responsive websites and web applications. Work with PHP, MySQL, APIs and frontend technologies. Candidates should be comfortable debugging code and collaborating with a development team.",
      email: "careers@example.com",
      whatsapp: "",
      applicationUrl: "",
      featured: true
    },
    {
      id: 102,
      title: "Digital Marketing Executive",
      company: "GrowthPath Media",
      location: "Delhi, India",
      category: "Sales & Marketing",
      experience: "1–2 years",
      experienceLevel: "1-2",
      qualification: "Graduate",
      type: "Full-time",
      salary: "₹2.4–4 LPA",
      salaryValue: 320000,
      posted: "2026-09-30",
      skills: ["SEO", "Social Media", "Analytics"],
      description: "Support digital marketing campaigns, keyword research, on-page SEO, content planning and performance reporting. Familiarity with analytics and social media platforms is useful.",
      email: "careers@example.com",
      whatsapp: "",
      applicationUrl: "",
      featured: false
    },
    {
      id: 103,
      title: "Customer Support Associate",
      company: "ConnectServe Services",
      location: "Work From Home",
      category: "Work From Home",
      experience: "Fresher",
      experienceLevel: "fresher",
      qualification: "10th / 12th",
      type: "Remote",
      salary: "₹18,000–25,000/month",
      salaryValue: 258000,
      posted: "2026-09-29",
      skills: ["Communication", "Customer Service", "Email"],
      description: "Assist customers with queries through approved support channels, document requests and follow established service processes. Good written communication and a customer-focused approach are required.",
      email: "careers@example.com",
      whatsapp: "",
      applicationUrl: "",
      featured: false
    },
    {
      id: 104,
      title: "Accounts Executive",
      company: "Northstar Business Services",
      location: "Dehradun, Uttarakhand",
      category: "Banking",
      experience: "1–2 years",
      experienceLevel: "1-2",
      qualification: "Graduate",
      type: "Full-time",
      salary: "₹2.5–4 LPA",
      salaryValue: 325000,
      posted: "2026-09-28",
      skills: ["Accounting", "Excel", "Tally"],
      description: "Maintain accounting records, reconcile transactions, prepare reports and support routine financial operations. Familiarity with accounting software and spreadsheets is preferred.",
      email: "careers@example.com",
      whatsapp: "",
      applicationUrl: "",
      featured: false
    },
    {
      id: 105,
      title: "School Teacher",
      company: "Bright Future Learning Centre",
      location: "Jaipur, Rajasthan",
      category: "Education",
      experience: "3–5 years",
      experienceLevel: "3-5",
      qualification: "Graduate",
      type: "Full-time",
      salary: "₹3–4.5 LPA",
      salaryValue: 375000,
      posted: "2026-09-27",
      skills: ["Teaching", "Lesson Planning", "Communication"],
      description: "Prepare lessons, deliver classroom instruction, assess student progress and coordinate with parents and colleagues. Relevant teaching qualifications may be required by the employer.",
      email: "careers@example.com",
      whatsapp: "",
      applicationUrl: "",
      featured: false
    },
    {
      id: 106,
      title: "Healthcare Administration Assistant",
      company: "CareBridge Health Services",
      location: "Lucknow, Uttar Pradesh",
      category: "Healthcare",
      experience: "Fresher",
      experienceLevel: "fresher",
      qualification: "Diploma",
      type: "Full-time",
      salary: "₹2–3 LPA",
      salaryValue: 250000,
      posted: "2026-09-26",
      skills: ["Administration", "Documentation", "Communication"],
      description: "Support appointment coordination, documentation, record maintenance and day-to-day administrative activities. Role-specific training and qualification requirements are set by the employer.",
      email: "careers@example.com",
      whatsapp: "",
      applicationUrl: "",
      featured: false
    },
    {
      id: 107,
      title: "Software Development Intern",
      company: "NextStep Technologies",
      location: "Bengaluru, Karnataka",
      category: "Internship",
      experience: "Fresher",
      experienceLevel: "fresher",
      qualification: "Graduate",
      type: "Internship",
      salary: "₹12,000–18,000/month",
      salaryValue: 180000,
      posted: "2026-09-25",
      skills: ["JavaScript", "Git", "Problem Solving"],
      description: "Work alongside developers on supervised software tasks, testing, documentation and small feature improvements. Suitable for candidates looking to gain practical development experience.",
      email: "careers@example.com",
      whatsapp: "",
      applicationUrl: "",
      featured: false
    },
    {
      id: 108,
      title: "Telecom Field Technician",
      company: "NetworkLink Infrastructure",
      location: "Chandigarh, India",
      category: "Telecom",
      experience: "3–5 years",
      experienceLevel: "3-5",
      qualification: "Diploma",
      type: "Contract",
      salary: "₹3–4 LPA",
      salaryValue: 350000,
      posted: "2026-09-24",
      skills: ["Networking", "Troubleshooting", "Field Support"],
      description: "Assist with network installation, field maintenance, troubleshooting and service documentation. Technical training and the ability to travel to assigned sites may be required.",
      email: "careers@example.com",
      whatsapp: "",
      applicationUrl: "",
      featured: false
    },
    {
      id: 109,
      title: "Junior Sales Associate",
      company: "MarketReach Enterprises",
      location: "Mumbai, Maharashtra",
      category: "Sales & Marketing",
      experience: "Fresher",
      experienceLevel: "fresher",
      qualification: "10th / 12th",
      type: "Full-time",
      salary: "₹18,000–28,000/month",
      salaryValue: 276000,
      posted: "2026-09-23",
      skills: ["Sales", "Communication", "Customer Relations"],
      description: "Support customer outreach, product information, lead follow-up and sales reporting. Training and performance expectations should be confirmed with the employer.",
      email: "careers@example.com",
      whatsapp: "",
      applicationUrl: "",
      featured: false
    },
    {
      id: 110,
      title: "Government Recruitment Updates",
      company: "Public Recruitment Information Desk",
      location: "Multiple locations, India",
      category: "Government",
      experience: "Any experience",
      experienceLevel: "",
      qualification: "Graduate",
      type: "Full-time",
      salary: "As per official notification",
      salaryValue: 0,
      posted: "2026-09-22",
      skills: ["Eligibility Review", "Documentation"],
      description: "Illustrative listing for a recruitment information category. Replace with a verified, active vacancy containing the recruiting authority, official notification, eligibility requirements, application deadline and official application link before publishing.",
      email: "",
      whatsapp: "",
      applicationUrl: "",
      featured: false
    }
  ];

  let savedJobs = readStorage(STORAGE.saved, []);
  let currentResults = [...jobs];
  let activeJobId = null;
  let toastTimeout;

  const filterForm = $("#plGjFilterForm");
  const jobList = $("#plGjJobList");
  const emptyState = $("#plGjEmpty");
  const summary = $("#plGjResultSummary");
  const savedCount = $("[data-gj-saved-count]");
  const toast = $("#plGjToast");

  function readStorage(key, fallback) {
    try {
      const value = JSON.parse(localStorage.getItem(key));
      return value ?? fallback;
    } catch {
      return fallback;
    }
  }

  function writeStorage(key, value) {
    try {
      localStorage.setItem(key, JSON.stringify(value));
      return true;
    } catch {
      showToast("Browser storage is unavailable. Your changes may not persist.");
      return false;
    }
  }

  function escapeHTML(value = "") {
    return String(value).replace(/[&<>"']/g, char => ({
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#39;"
    })[char]);
  }

  function normalise(value) {
    return String(value || "").trim().toLowerCase();
  }

  function getJob(id) {
    return jobs.find(job => job.id === Number(id));
  }

  function getFormValues() {
    return {
      keyword: normalise($("#plGjKeyword").value),
      location: normalise($("#plGjLocation").value),
      category: $("#plGjCategory").value,
      experience: $("#plGjExperience").value,
      qualification: $("#plGjQualification").value,
      type: $("#plGjType").value,
      skills: normalise($("#plGjSkills").value)
    };
  }

  function experienceMatches(job, selected) {
    if (!selected) return true;
    if (selected === "fresher") return job.experienceLevel === "fresher";
    if (selected === "1-2") return job.experienceLevel === "1-2";
    if (selected === "3-5") return job.experienceLevel === "3-5";
    if (selected === "5+") return job.experienceLevel === "5+";
    return true;
  }

  function qualificationMatches(job, selected) {
    if (!selected) return true;

    // Illustrative qualification matching; use structured qualification data in production.
    const value = normalise(job.qualification);
    const wanted = normalise(selected);

    if (wanted === "10th / 12th") {
      return value.includes("10th") || value.includes("12th");
    }
    if (wanted === "professional certification") {
      return value.includes("certification");
    }
    return value === wanted;
  }

  function filterJobs() {
    const filters = getFormValues();

    currentResults = jobs.filter(job => {
      const searchableText = normalise([
        job.title,
        job.company,
        job.description,
        job.category,
        job.location,
        job.qualification,
        job.type,
        job.experience,
        ...(job.skills || [])
      ].join(" "));

      if (filters.keyword && !searchableText.includes(filters.keyword)) {
        return false;
      }

      if (filters.location && !normalise(job.location).includes(filters.location)) {
        return false;
      }

      if (filters.category && job.category !== filters.category) {
        return false;
      }

      if (!experienceMatches(job, filters.experience)) {
        return false;
      }

      if (!qualificationMatches(job, filters.qualification)) {
        return false;
      }

      if (filters.type && job.type !== filters.type) {
        return false;
      }

      if (filters.skills) {
        const skillTerms = filters.skills.split(",").map(normalise).filter(Boolean);
        const jobSkills = normalise((job.skills || []).join(" "));
        const titleAndDescription = normalise(`${job.title} ${job.description}`);

        const allSkillsFound = skillTerms.every(skill =>
          jobSkills.includes(skill) || titleAndDescription.includes(skill)
        );

        if (!allSkillsFound) return false;
      }

      return true;
    });

    sortResults();
    renderJobs();
  }

  function sortResults() {
    const sort = $("#plGjSort").value;

    currentResults.sort((a, b) => {
      if (sort === "salary") return (b.salaryValue || 0) - (a.salaryValue || 0);
      if (sort === "title") return a.title.localeCompare(b.title);
      if (sort === "location") return a.location.localeCompare(b.location);

      return new Date(b.posted) - new Date(a.posted);
    });
  }

  function formatDate(dateString) {
    if (!dateString) return "Date not provided";

    const date = new Date(`${dateString}T12:00:00`);
    if (Number.isNaN(date.getTime())) return "Date not provided";

    return new Intl.DateTimeFormat("en-IN", {
      day: "numeric",
      month: "short",
      year: "numeric"
    }).format(date);
  }

  function companyInitials(company) {
    const words = String(company || "Company").trim().split(/\s+/);
    return escapeHTML(words.slice(0, 2).map(word => word[0] || "").join("").toUpperCase());
  }

  function renderJobCard(job) {
    const isSaved = savedJobs.includes(job.id);
    const skillTags = (job.skills || []).slice(0, 4)
      .map(skill => `<span class="pl-gj-skill-tag">${escapeHTML(skill)}</span>`)
      .join("");

    return `
      <article class="pl-gj-job-card" data-gj-job-card="${job.id}">
        <div class="pl-gj-company-logo" aria-hidden="true">
          ${companyInitials(job.company)}
        </div>

        <div class="pl-gj-job-main">
          <div class="pl-gj-job-topline">
            <span class="pl-gj-job-category">${escapeHTML(job.category)}</span>
            ${job.featured ? '<span class="pl-gj-featured"><i class="bi bi-stars"></i> Featured</span>' : ""}
          </div>

          <h3 class="pl-gj-job-title">${escapeHTML(job.title)}</h3>
          <p class="pl-gj-company-name">${escapeHTML(job.company)}</p>

          <div class="pl-gj-job-meta">
            <span><i class="bi bi-geo-alt"></i>${escapeHTML(job.location)}</span>
            <span><i class="bi bi-briefcase"></i>${escapeHTML(job.experience)}</span>
            <span><i class="bi bi-mortarboard"></i>${escapeHTML(job.qualification)}</span>
            <span><i class="bi bi-clock"></i>${escapeHTML(job.type)}</span>
          </div>

          <p class="pl-gj-job-description">${escapeHTML(job.description)}</p>
          <div class="pl-gj-skill-list">${skillTags}</div>
        </div>

        <div class="pl-gj-job-side">
          <div class="pl-gj-salary">${escapeHTML(job.salary || "Salary not disclosed")}</div>
          <div class="pl-gj-posted">Posted ${escapeHTML(formatDate(job.posted))}</div>
          <div class="pl-gj-job-actions">
            <button type="button" class="pl-gj-btn pl-gj-btn-primary"
              data-gj-view-job="${job.id}">
              View Job Details <i class="bi bi-arrow-right"></i>
            </button>
            <button type="button" class="pl-gj-save-btn ${isSaved ? "is-saved" : ""}"
              data-gj-save-job="${job.id}" aria-pressed="${isSaved}">
              <i class="bi ${isSaved ? "bi-bookmark-check-fill" : "bi-bookmark"}"></i>
              ${isSaved ? "Saved" : "Save Job"}
            </button>
          </div>
        </div>
      </article>
    `;
  }

  function renderJobs() {
    jobList.innerHTML = currentResults.map(renderJobCard).join("");
    emptyState.hidden = currentResults.length !== 0;

    const count = currentResults.length;
    summary.textContent = `Showing ${count} ${count === 1 ? "opportunity" : "opportunities"}`;

    updateSavedCount();
  }

  function updateSavedCount() {
    savedCount.textContent = savedJobs.length;
  }

  function showToast(message) {
    toast.textContent = message;
    toast.classList.add("is-visible");

    clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => {
      toast.classList.remove("is-visible");
    }, 3200);
  }

  function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;

    $$(".pl-gj-modal", root).forEach(item => {
      item.hidden = true;
    });

    modal.hidden = false;
    document.body.style.overflow = "hidden";

    const focusTarget = $("input, select, textarea, button", modal);
    if (focusTarget) {
      setTimeout(() => focusTarget.focus(), 30);
    }
  }

  function closeModal(modal) {
    if (!modal) return;

    modal.hidden = true;

    const anotherOpen = $$(".pl-gj-modal", root).some(item => !item.hidden);
    if (!anotherOpen) document.body.style.overflow = "";
  }

  function closeAllModals() {
    $$(".pl-gj-modal", root).forEach(modal => {
      modal.hidden = true;
    });
    document.body.style.overflow = "";
  }

  function renderJobDetails(job) {
    activeJobId = job.id;

    const isSaved = savedJobs.includes(job.id);
    const skills = (job.skills || [])
      .map(skill => `<span class="pl-gj-skill-tag">${escapeHTML(skill)}</span>`)
      .join(" ");

    $("#plGjDetailsContent").innerHTML = `
      <div class="pl-gj-modal-heading">
        <span class="pl-gj-section-kicker">${escapeHTML(job.category)}</span>
        <h2 class="pl-gj-detail-title" id="plGjModalTitle">${escapeHTML(job.title)}</h2>
        <p class="pl-gj-detail-company">${escapeHTML(job.company)}</p>
      </div>

      <div class="pl-gj-detail-meta">
        <span><i class="bi bi-geo-alt"></i> ${escapeHTML(job.location)}</span>
        <span><i class="bi bi-briefcase"></i> ${escapeHTML(job.experience)}</span>
        <span><i class="bi bi-mortarboard"></i> ${escapeHTML(job.qualification)}</span>
        <span><i class="bi bi-clock"></i> ${escapeHTML(job.type)}</span>
        <span><i class="bi bi-calendar3"></i> ${escapeHTML(formatDate(job.posted))}</span>
      </div>

      <div class="pl-gj-detail-block">
        <h3>Salary / Compensation</h3>
        <p>${escapeHTML(job.salary || "Not disclosed by the employer")}</p>
      </div>

      <div class="pl-gj-detail-block">
        <h3>Job Description</h3>
        <p>${escapeHTML(job.description)}</p>
      </div>

      <div class="pl-gj-detail-block">
        <h3>Skills</h3>
        <div class="pl-gj-skill-list">${skills || "Not specified"}</div>
      </div>

      <div class="pl-gj-detail-block">
        <h3>How to Apply</h3>
        <p>Use one of the application methods configured and verified for this job. Demo contact details are not connected to a live employer.</p>
      </div>

      <div class="pl-gj-detail-actions">
        <button type="button" class="pl-gj-btn pl-gj-btn-primary"
          data-gj-apply-job="${job.id}">
          <i class="bi bi-send"></i> Apply for Job
        </button>
        <button type="button" class="pl-gj-btn pl-gj-btn-light"
          data-gj-save-job="${job.id}" aria-pressed="${isSaved}">
          <i class="bi ${isSaved ? "bi-bookmark-check-fill" : "bi-bookmark"}"></i>
          ${isSaved ? "Saved" : "Save Job"}
        </button>
      </div>
    `;
  }

  function viewJob(id) {
    const job = getJob(id);
    if (!job) return;

    renderJobDetails(job);
    openModal("plGjDetailsModal");
  }

  function toggleSavedJob(id) {
    const numericId = Number(id);
    const job = getJob(numericId);

    if (!job) return;

    if (savedJobs.includes(numericId)) {
      savedJobs = savedJobs.filter(savedId => savedId !== numericId);
      showToast("Job removed from your saved list.");
    } else {
      savedJobs.push(numericId);
      showToast("Job saved for future reference.");
    }

    writeStorage(STORAGE.saved, savedJobs);
    renderJobs();
    updateSavedCount();

    // Keep an open details modal in sync.
    if (!$("#plGjDetailsModal").hidden && activeJobId === numericId) {
      renderJobDetails(job);
    }

    if (!$("#plGjSavedModal").hidden) {
      renderSavedJobs();
    }
  }

  function renderSavedJobs() {
    const container = $("#plGjSavedList");
    const saved = savedJobs.map(getJob).filter(Boolean);

    if (!saved.length) {
      container.innerHTML = `
        <div class="pl-gj-saved-empty">
          <i class="bi bi-bookmark-heart"></i>
          <strong>No saved jobs yet.</strong>
          <p>Browse opportunities and select Save Job to build your shortlist.</p>
        </div>
      `;
      return;
    }

    container.innerHTML = saved.map(job => `
      <div class="pl-gj-saved-item">
        <div>
          <h3>${escapeHTML(job.title)}</h3>
          <p>${escapeHTML(job.company)} · ${escapeHTML(job.location)}</p>
          <p>${escapeHTML(job.salary || "Salary not disclosed")}</p>
        </div>
        <div class="pl-gj-job-actions">
          <button type="button" class="pl-gj-btn pl-gj-btn-primary" data-gj-view-job="${job.id}">
            View Details
          </button>
          <button type="button" class="pl-gj-btn pl-gj-btn-light" data-gj-save-job="${job.id}">
            Remove
          </button>
        </div>
      </div>
    `).join("");
  }

  function resetFilters() {
    filterForm.reset();
    $$(".pl-gj-category-card", root).forEach(card => card.classList.remove("is-active"));
    filterJobs();
  }

  function applyCategory(category, clickedCard) {
    $("#plGjCategory").value = category;

    $$(".pl-gj-category-card", root).forEach(card => {
      card.classList.toggle("is-active", card === clickedCard);
    });

    filterJobs();

    document.getElementById("plGjResults").scrollIntoView({
      behavior: window.matchMedia("(prefers-reduced-motion: reduce)").matches ? "auto" : "smooth",
      block: "start"
    });
  }

  function buildApplicationMessage(job) {
    return `Hello, I am interested in the position "${job.title}" at ${job.company}. Please share the official application instructions.`;
  }

  function applyForJob(id) {
    const job = getJob(id);
    if (!job) return;

    // In production, load these destinations from a verified job record
    // and enforce eligibility and access rules on the server.
    const choices = [];

    if (job.applicationUrl) {
      choices.push({
        label: "Official application page",
        action: () => GenOpen(job.applicationUrl)
      });
    }

    if (job.email) {
      choices.push({
        label: "Send resume by email",
        action: () => {
          const subject = encodeURIComponent(`Application: ${job.title}`);
          const body = encodeURIComponent(
            `${buildApplicationMessage(job)}\n\nI will attach my resume to this email.`
          );
          window.location.href = `mailto:${job.email}?subject=${subject}&body=${body}`;
        }
      });
    }

    if (job.whatsapp) {
      choices.push({
        label: "Apply via WhatsApp",
        action: () => {
          const message = encodeURIComponent(buildApplicationMessage(job));
          const number = String(job.whatsapp).replace(/\D/g, "");
          if (!number) {
            showToast("The employer has not configured a valid WhatsApp destination.");
            return;
          }
          GenOpen(`https://wa.me/${number}?text=${message}`);
        }
      });
    }

    if (!choices.length) {
      showToast("Application details are not configured for this demo job. Connect a verified employer application method.");
      return;
    }

    if (choices.length === 1) {
      choices[0].action();
      return;
    }

    // Use a simple selection prompt until the live application workflow is integrated.
    const choice = window.prompt(
      `Choose an application method by number:\n${choices.map((item, index) => `${index + 1}. ${item.label}`).join("\n")}`
    );

    const selected = Number(choice) - 1;
    if (choice !== null && choices[selected]) choices[selected].action();
  }

  function GenOpen(url) {
    try {
      const parsed = new URL(url, window.location.href);
      if (!["https:", "http:"].includes(parsed.protocol)) {
        showToast("This application link is not valid.");
        return;
      }
      window.open(parsed.href, "_blank", "noopener,noreferrer");
    } catch {
      showToast("This application link is not valid.");
    }
  }

  // Filter submissions.
  filterForm.addEventListener("submit", event => {
    event.preventDefault();
    filterJobs();
    document.getElementById("plGjResults").scrollIntoView({
      behavior: window.matchMedia("(prefers-reduced-motion: reduce)").matches ? "auto" : "smooth",
      block: "start"
    });
  });

  filterForm.addEventListener("reset", () => {
    // Reset the actual control values before running the filter.
    setTimeout(() => {
      $$(".pl-gj-category-card", root).forEach(card => card.classList.remove("is-active"));
      filterJobs();
    }, 0);
  });

  $("#plGjSort").addEventListener("change", () => {
    sortResults();
    renderJobs();
  });

  // Click delegation for cards, modals and actions.
  root.addEventListener("click", event => {
    const target = event.target.closest("button, a");
    if (!target || !root.contains(target)) return;

    if (target.matches("[data-gj-category]")) {
      applyCategory(target.dataset.gjCategory, target);
      return;
    }

    if (target.hasAttribute("data-gj-view-job")) {
      viewJob(target.dataset.gjViewJob);
      return;
    }

    if (target.hasAttribute("data-gj-save-job")) {
      toggleSavedJob(target.dataset.gjSaveJob);
      return;
    }

    if (target.hasAttribute("data-gj-apply-job")) {
      applyForJob(target.dataset.gjApplyJob);
      return;
    }

    if (target.hasAttribute("data-gj-open-post")) {
      closeAllModals();
      openModal("plGjPostModal");
      return;
    }

    if (target.hasAttribute("data-gj-open-alert")) {
      openModal("plGjAlertModal");
      return;
    }

    if (target.hasAttribute("data-gj-show-saved")) {
      renderSavedJobs();
      openModal("plGjSavedModal");
      return;
    }

    if (target.hasAttribute("data-gj-view-packages")) {
      openModal("plGjPackagesModal");
      return;
    }

    if (target.hasAttribute("data-gj-close-modal")) {
      closeModal(target.closest(".pl-gj-modal"));
      return;
    }

    if (target.hasAttribute("data-gj-clear-search") ||
        target.hasAttribute("data-gj-reset-all")) {
      resetFilters();
      return;
    }

    if (target.id === "plGjReset") {
      // The native reset event handles the form.
      return;
    }
  });

  // Close a modal using Escape.
  document.addEventListener("keydown", event => {
    if (event.key === "Escape") {
      closeAllModals();
    }
  });

  // Demo post form: validates locally but never publishes a job.
  $("#plGjPostForm").addEventListener("submit", event => {
    event.preventDefault();

    const form = event.currentTarget;
    if (!form.reportValidity()) return;

    const formData = new FormData(form);
    const draft = Object.fromEntries(formData.entries());

    // Store no employer contact data in public job listings.
    // Production: POST this draft to a secure server endpoint for admin approval.
    console.info("Global job draft ready for backend submission.", {
      title: draft.title,
      company: draft.company,
      category: draft.category,
      location: draft.location
    });

    form.reset();
    closeAllModals();
    showToast("Demo submission validated. Connect your backend to submit this job for admin approval.");
  });

  // Demo job alert preferences.
  $("#plGjAlertForm").addEventListener("submit", event => {
    event.preventDefault();

    const form = event.currentTarget;
    if (!form.reportValidity()) return;

    const data = Object.fromEntries(new FormData(form).entries());
    const saved = writeStorage(STORAGE.alerts, data);

    closeAllModals();
    if (saved) {
      showToast("Preferences saved in this browser. Live alerts need backend integration.");
    }
  });

  // Initial render.
  filterJobs();
  updateSavedCount();
})();







// ============================================================
// PEOPLELINK PAGE 15 - JOB DETAILS
// Demo implementation. Connect API endpoints before production.
// ============================================================

(() => {
  "use strict";

  const root = document.getElementById("plJobDetails");
  if (!root) return;

  const $ = (selector) => root.querySelector(selector);

  const CONFIG = {
    // Replace these with your actual PHP endpoints.
    applicationEndpoint: "job-application.php",
    reportEndpoint: "job-report-submit.php",
    jobDetailsEndpoint: "job-details-data.php",
    savedJobsEndpoint: "save-job.php",
    requireLoginForSave: true,

    // Enable only after the endpoint is implemented and verified.
    enableServerApplication: false,
    enableServerReports: false,
    enableServerSave: false
  };

  // Sample records for demonstration. Replace with database/API data.
  const sampleJobs = [
    {
      id: 101,
      jobType: "global",
      title: "PHP Web Developer",
      company: "Digital Solutions Group",
      initials: "DS",
      category: "IT & Software",
      type: "Full-time",
      location: "Remote / India",
      experience: "1–2 years",
      qualification: "Graduate",
      salary: "₹3–5 LPA",
      openings: "2 Positions",
      posted: "2026-10-01",
      closing: "2026-10-31",
      summary: "We are looking for a motivated PHP Web Developer to help build, maintain and improve responsive websites and web applications.",
      responsibilities: [
        "Develop and maintain responsive websites and web applications.",
        "Work with PHP, MySQL, JavaScript, HTML and CSS.",
        "Debug issues, improve performance and maintain code quality.",
        "Collaborate with team members on features and project delivery."
      ],
      workingConditions: "Full-time role. Remote working arrangements and other conditions should be confirmed with the employer.",
      otherRequirements: "Candidates should be comfortable solving technical problems, communicating progress and working with project requirements.",
      skills: ["PHP", "MySQL", "JavaScript", "HTML & CSS", "API Integration"],
      eligibility: [
        { title: "Education", text: "Graduate or relevant qualification" },
        { title: "Experience", text: "1–2 years of relevant experience" },
        { title: "Location", text: "India / Remote, subject to employer policy" },
        { title: "Certifications", text: "Not specified by the employer" },
        { title: "Additional conditions", text: "Confirm role-specific requirements with the employer" }
      ],
      industry: "Technology & Digital Services",
      companyLocation: "India",
      companyDescription: "Employer information and company details should be verified before applying.",
      companyWebsite: "",
      application: {
        // Configure server-side application methods for each approved job.
        whatsappAvailable: false,
        emailAvailable: false,
        externalUrl: ""
      },
      visibilityText: "Visible across eligible communities according to PeopleLink access settings.",
      status: "active",
      featured: true
    },
    {
      id: 102,
      jobType: "global",
      title: "Digital Marketing Executive",
      company: "GrowthPath Media",
      initials: "GM",
      category: "Sales & Marketing",
      type: "Full-time",
      location: "Delhi, India",
      experience: "1–2 years",
      qualification: "Graduate",
      salary: "₹2.4–4 LPA",
      openings: "3 Positions",
      posted: "2026-09-30",
      closing: "",
      summary: "Support digital marketing campaigns, keyword research, on-page SEO, content planning and performance reporting.",
      responsibilities: [
        "Assist with keyword research and on-page SEO.",
        "Coordinate content calendars and social media activity.",
        "Review campaign performance and prepare reports.",
        "Support digital marketing projects and improvements."
      ],
      workingConditions: "Employment arrangements and working hours should be confirmed with the employer.",
      otherRequirements: "Familiarity with analytics tools and digital marketing platforms is useful.",
      skills: ["SEO", "Digital Marketing", "Social Media", "Analytics"],
      eligibility: [
        { title: "Education", text: "Graduate or relevant qualification" },
        { title: "Experience", text: "1–2 years preferred" },
        { title: "Location", text: "Delhi, India" },
        { title: "Certifications", text: "Not specified" }
      ],
      industry: "Digital Marketing",
      companyLocation: "Delhi, India",
      companyDescription: "Company information should be provided and verified by the employer.",
      companyWebsite: "",
      application: {
        whatsappAvailable: false,
        emailAvailable: false,
        externalUrl: ""
      },
      visibilityText: "Global listing for users eligible under PeopleLink visibility settings.",
      status: "active",
      featured: false
    },
    {
      id: 103,
      jobType: "community",
      title: "Accounts Executive",
      company: "Northstar Business Services",
      initials: "NB",
      category: "Banking",
      type: "Full-time",
      location: "Dehradun, Uttarakhand",
      experience: "1–2 years",
      qualification: "Graduate",
      salary: "₹2.5–4 LPA",
      openings: "1 Position",
      posted: "2026-09-28",
      closing: "",
      summary: "Support accounting operations, reconcile transactions, maintain records and prepare routine financial reports.",
      responsibilities: [
        "Maintain accounting records and supporting documents.",
        "Reconcile transactions and assist with routine reporting.",
        "Use spreadsheets and accounting software.",
        "Support the finance team with daily accounting tasks."
      ],
      workingConditions: "Work location and schedule are determined by the employer.",
      otherRequirements: "Experience with spreadsheets and accounting software is preferred.",
      skills: ["Accounting", "Excel", "Tally", "Documentation"],
      eligibility: [
        { title: "Education", text: "Graduate in a relevant field preferred" },
        { title: "Experience", text: "1–2 years preferred" },
        { title: "Location", text: "Dehradun, Uttarakhand" },
        { title: "Certifications", text: "As specified by the employer" }
      ],
      industry: "Business Services",
      companyLocation: "Dehradun, Uttarakhand",
      companyDescription: "Company details and community eligibility must be confirmed through the live listing.",
      companyWebsite: "",
      application: {
        whatsappAvailable: false,
        emailAvailable: false,
        externalUrl: ""
      },
      visibilityText: "Community Job. Visible only to eligible users in the configured community.",
      communityId: "demo-community",
      status: "active",
      featured: false
    }
  ];

  let currentJob = null;
  let toastTimer = null;
  let lastFocusedElement = null;

  const toast = $("#plJdToast");
  const reportModal = $("#plJdReportModal");
  const applyModal = $("#plJdApplyModal");

  function escapeHTML(value = "") {
    return String(value).replace(/[&<>"']/g, char => ({
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#39;"
    })[char]);
  }

  function showToast(message) {
    toast.textContent = message;
    toast.classList.add("is-visible");

    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => {
      toast.classList.remove("is-visible");
    }, 3500);
  }

  function formatDate(value) {
    if (!value) return "Not specified";

    const date = new Date(`${value}T12:00:00`);
    if (Number.isNaN(date.getTime())) return "Not specified";

    return new Intl.DateTimeFormat("en-IN", {
      day: "numeric",
      month: "short",
      year: "numeric"
    }).format(date);
  }

  function getJobIdFromUrl() {
    const params = new URLSearchParams(window.location.search);
    return params.get("job_id") || params.get("id") || "101";
  }

  function getJobTypeFromUrl() {
    const params = new URLSearchParams(window.location.search);
    return params.get("job_type") || "";
  }

  function getJobUrl(job) {
    const url = new URL(window.location.href);
    url.searchParams.set("job_id", job.id);
    url.searchParams.set("job_type", job.jobType);
    return url.href;
  }

  function getInitials(name) {
    return String(name || "")
      .trim()
      .split(/\s+/)
      .slice(0, 2)
      .map(part => part[0] || "")
      .join("")
      .toUpperCase();
  }

  function getSavedJobs() {
    try {
      const value = JSON.parse(localStorage.getItem("pl_job_details_saved") || "[]");
      return Array.isArray(value) ? value : [];
    } catch {
      return [];
    }
  }

  function isSaved(job) {
    return getSavedJobs().some(item =>
      String(item.id) === String(job.id) &&
      item.jobType === job.jobType
    );
  }

  function setSaveButton(button, saved) {
    if (!button) return;

    const icon = button.querySelector("i");
    const text = button.querySelector("span");

    if (icon) {
      icon.className = saved ? "bi bi-bookmark-check-fill" : "bi bi-bookmark";
    }

    if (text) {
      text.textContent = saved ? "Saved Job" : "Save Job";
    } else {
      button.innerHTML = `
        <i class="bi ${saved ? "bi-bookmark-check-fill" : "bi-bookmark"}"></i>
        ${saved ? "Saved Job" : "Save Job"}
      `;
    }

    button.setAttribute("aria-pressed", String(saved));
  }

  function updateSaveButtons() {
    const saved = currentJob && isSaved(currentJob);

    setSaveButton($("#plJdSaveTop"), saved);
    setSaveButton($("#plJdSaveSidebar"), saved);
  }

  async function saveJob() {
    if (!currentJob) return;

    // Replace this demo login check with your actual PHP session/auth system.
    if (CONFIG.requireLoginForSave) {
      const loggedIn = root.dataset.loggedIn === "true";

      if (!loggedIn) {
        showToast("Please log in to save jobs.");
        return;
      }
    }

    if (CONFIG.enableServerSave) {
      try {
        const response = await fetch(CONFIG.savedJobsEndpoint, {
          method: "POST",
          credentials: "same-origin",
          headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
          },
          body: JSON.stringify({
            job_id: currentJob.id,
            job_type: currentJob.jobType
          })
        });

        if (!response.ok) throw new Error("Save request failed");

        const data = await response.json();
        if (!data.success) throw new Error(data.message || "Unable to save job");

        showToast(data.saved ? "Job saved successfully." : "Job removed from saved jobs.");
        updateSaveButtons();
        return;
      } catch {
        showToast("Unable to update saved jobs. Please try again.");
        return;
      }
    }

    // Browser-only fallback for front-end preview.
    try {
      let savedJobs = getSavedJobs();

      const alreadySaved = savedJobs.some(item =>
        String(item.id) === String(currentJob.id) &&
        item.jobType === currentJob.jobType
      );

      if (alreadySaved) {
        savedJobs = savedJobs.filter(item =>
          !(String(item.id) === String(currentJob.id) &&
            item.jobType === currentJob.jobType)
        );
        showToast("Job removed from this browser's saved list.");
      } else {
        savedJobs.push({
          id: currentJob.id,
          jobType: currentJob.jobType,
          title: currentJob.title,
          company: currentJob.company,
          url: getJobUrl(currentJob)
        });
        showToast("Job saved in this browser.");
      }

      localStorage.setItem("pl_job_details_saved", JSON.stringify(savedJobs));
      updateSaveButtons();
    } catch {
      showToast("Unable to save this job in your browser.");
    }
  }

  function setText(selector, value, fallback = "Not specified") {
    const element = $(selector);
    if (!element) return;

    element.textContent = value === null || value === undefined || value === ""
      ? fallback
      : value;
  }

  function renderVisibility(job) {
    const isCommunity = job.jobType === "community";

    $("#plJdVisibility").innerHTML = isCommunity
      ? '<i class="bi bi-people"></i> Community Job'
      : '<i class="bi bi-globe2"></i> Global Job';

    setText(
      "#plJdVisibilityTitle",
      isCommunity ? "Community Opportunity" : "Global Opportunity"
    );

    setText(
      "#plJdVisibilityText",
      job.visibilityText || (
        isCommunity
          ? "Visible to eligible users within the configured community."
          : "Visible across eligible communities according to administrator settings."
      )
    );
  }

  function renderSkills(job) {
    $("#plJdSkills").innerHTML = (job.skills || []).length
      ? job.skills.map(skill => `<span>${escapeHTML(skill)}</span>`).join("")
      : "<span>Not specified</span>";
  }

  function renderResponsibilities(job) {
    const items = job.responsibilities || [];

    $("#plJdResponsibilities").innerHTML = items.length
      ? items.map(item => `<li>${escapeHTML(item)}</li>`).join("")
      : "<li>Responsibilities have not been specified.</li>";
  }

  function renderEligibility(job) {
    const items = job.eligibility || [];

    $("#plJdEligibility").innerHTML = items.length
      ? items.map(item => `
          <div>
            <i class="bi bi-check2-circle"></i>
            <span>
              <strong>${escapeHTML(item.title)}</strong>
              <small>${escapeHTML(item.text)}</small>
            </span>
          </div>
        `).join("")
      : `
          <div>
            <i class="bi bi-info-circle"></i>
            <span>
              <strong>Eligibility</strong>
              <small>Check with the employer for role-specific requirements.</small>
            </span>
          </div>
        `;
  }

  function renderCompany(job) {
    const initials = job.initials || getInitials(job.company);

    setText("#plJdCompanyMark", initials);
    setText("#plJdAboutMark", initials);
    setText("#plJdAboutCompany", job.company);
    setText("#plJdIndustry", job.industry);
    setText("#plJdCompanyLocation", job.companyLocation || job.location);
    setText("#plJdCompanyDescription", job.companyDescription);

    const website = $("#plJdCompanyWebsite");
    website.hidden = true;
    website.removeAttribute("href");

    if (job.companyWebsite) {
      try {
        const parsed = new URL(job.companyWebsite);
        if (parsed.protocol === "https:" || parsed.protocol === "http:") {
          website.href = parsed.href;
          website.hidden = false;
        }
      } catch {
        // Invalid employer websites are not displayed.
      }
    }
  }

  function renderOverview(job) {
    setText("#plJdTitle", job.title);
    setText("#plJdCompany", job.company);
    setText("#plJdCategory", job.category);
    setText("#plJdLocation", job.location);
    setText("#plJdExperience", job.experience);
    setText("#plJdType", job.type);

    setText("#plJdOverviewCategory", job.category);
    setText("#plJdOverviewLocation", job.location);
    setText("#plJdOverviewExperience", job.experience);
    setText("#plJdQualification", job.qualification);
    setText("#plJdSalary", job.salary, "Not disclosed");
    setText("#plJdOpenings", job.openings, "Not specified");
    setText("#plJdPosted", formatDate(job.posted));
    setText("#plJdClosing", formatDate(job.closing));
    setText("#plJdJobId", `JOB-PL-${job.id}`);

    setText("#plJdSummary", job.summary);
    setText("#plJdWorkingConditions", job.workingConditions);
    setText("#plJdOtherRequirements", job.otherRequirements);

    renderVisibility(job);
    renderResponsibilities(job);
    renderSkills(job);
    renderEligibility(job);
    renderCompany(job);
    updateSaveButtons();

    document.title = `${job.title} | PeopleLink Jobs`;
  }

  function isJobOpen(job) {
    if (job.status && job.status !== "active") return false;

    if (job.closing) {
      const closeDate = new Date(`${job.closing}T23:59:59`);
      if (!Number.isNaN(closeDate.getTime()) && closeDate < new Date()) {
        return false;
      }
    }

    return true;
  }

  function renderSimilarJobs(job) {
    const container = $("#plJdSimilarJobs");

    const similar = sampleJobs
      .filter(item => {
        if (String(item.id) === String(job.id)) return false;
        if (!isJobOpen(item)) return false;

        // Keep community jobs inside their configured community.
        if (job.jobType === "community") {
          return item.jobType === "community" &&
            item.communityId === job.communityId;
        }

        // Global job details may show other eligible global jobs.
        return item.jobType === "global" &&
          (
            item.category === job.category ||
            (item.skills || []).some(skill =>
              (job.skills || []).includes(skill)
            ) ||
            item.location === job.location
          );
      })
      .slice(0, 4);

    if (!similar.length) {
      container.innerHTML = `
        <article class="pl-jd-similar-card">
          <p class="pl-jd-body-text">No similar opportunities are available in this demo. Connect this section to your approved jobs database.</p>
        </article>
      `;
      return;
    }

    container.innerHTML = similar.map(item => `
      <article class="pl-jd-similar-card">
        <div class="pl-jd-similar-top">
          <div class="pl-jd-similar-mark">${escapeHTML(item.initials || getInitials(item.company))}</div>
          <div>
            <h3>${escapeHTML(item.title)}</h3>
            <p class="pl-jd-similar-company">${escapeHTML(item.company)}</p>
          </div>
        </div>

        <div class="pl-jd-similar-meta">
          <span><i class="bi bi-geo-alt"></i>${escapeHTML(item.location)}</span>
          <span><i class="bi bi-briefcase"></i>${escapeHTML(item.experience)}</span>
        </div>

        <div class="pl-jd-similar-bottom">
          <span class="pl-jd-similar-salary">${escapeHTML(item.salary || "Salary not disclosed")}</span>
          <button type="button" data-jd-open-similar="${item.id}">
            View Job <i class="bi bi-arrow-up-right"></i>
          </button>
        </div>
      </article>
    `).join("");
  }

  function openModal(modal) {
    lastFocusedElement = document.activeElement;
    modal.hidden = false;
    document.body.style.overflow = "hidden";

    const focusTarget = modal.querySelector("button, input, select, textarea");
    if (focusTarget) focusTarget.focus();
  }

  function closeModal(modal) {
    if (!modal) return;

    modal.hidden = true;

    if (reportModal.hidden && applyModal.hidden) {
      document.body.style.overflow = "";

      if (lastFocusedElement && typeof lastFocusedElement.focus === "function") {
        lastFocusedElement.focus();
      }
    }
  }

  function closeAllModals() {
    closeModal(reportModal);
    closeModal(applyModal);
  }

  function openApplyOptions() {
    if (!currentJob) return;

    if (!isJobOpen(currentJob)) {
      showToast("This vacancy may have closed. Please check the latest job status.");
      return;
    }

    const options = $("#plJdApplicationOptions");
    const application = currentJob.application || {};
    const availableOptions = [];

    if (application.whatsappAvailable) {
      availableOptions.push({
        icon: "bi-whatsapp",
        title: "Apply via WhatsApp",
        description: "Continue through the approved application workflow.",
        action: "whatsapp"
      });
    }

    if (application.emailAvailable) {
      availableOptions.push({
        icon: "bi-envelope",
        title: "Send Resume by Email",
        description: "Use the email workflow configured for this job.",
        action: "email"
      });
    }

    if (application.externalUrl) {
      availableOptions.push({
        icon: "bi-box-arrow-up-right",
        title: "Open Application Page",
        description: "Continue to the employer's configured application page.",
        action: "external"
      });
    }

    if (!availableOptions.length) {
      options.innerHTML = `
        <div class="pl-jd-notice">
          <i class="bi bi-info-circle"></i>
          <p>Application methods have not been configured for this demo listing. The live site should load approved contact methods from the job record.</p>
        </div>
      `;
    } else {
      options.innerHTML = availableOptions.map(option => `
        <button type="button" class="pl-jd-application-option"
          data-jd-application="${option.action}">
          <span>
            <i class="bi ${option.icon}"></i>
            ${escapeHTML(option.title)}
            <small>${escapeHTML(option.description)}</small>
          </span>
          <i class="bi bi-arrow-right"></i>
        </button>
      `).join("");
    }

    openModal(applyModal);
  }

  async function startApplication(method) {
    if (!currentJob) return;

    if (!isJobOpen(currentJob)) {
      showToast("This vacancy may have closed. Please check the latest job status.");
      closeModal(applyModal);
      return;
    }

    // The server must verify job status, access permissions and application method.
    if (CONFIG.enableServerApplication) {
      try {
        const response = await fetch(CONFIG.applicationEndpoint, {
          method: "POST",
          credentials: "same-origin",
          headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest"
          },
          body: JSON.stringify({
            job_id: currentJob.id,
            job_type: currentJob.jobType,
            method
          })
        });

        if (!response.ok) throw new Error("Application request failed");

        const result = await response.json();

        if (!result.success) {
          throw new Error(result.message || "Unable to start application");
        }

        // Only navigate to destinations returned by your trusted backend.
        if (method === "external" && result.redirect_url) {
          navigateToApprovedURL(result.redirect_url);
        } else if (method === "whatsapp" && result.redirect_url) {
          navigateToApprovedURL(result.redirect_url);
        } else if (method === "email" && result.redirect_url) {
          navigateToApprovedURL(result.redirect_url);
        } else {
          showToast(result.message || "Application workflow started.");
        }

        closeModal(applyModal);
      } catch {
        showToast("Unable to start the application. Please try again later.");
      }
      return;
    }

    showToast("Connect the approved server-side application workflow before enabling this option.");
  }

  function navigateToApprovedURL(url) {
    try {
      const parsed = new URL(url, window.location.origin);

      if (!["https:", "http:", "mailto:"].includes(parsed.protocol)) {
        showToast("The application destination is invalid.");
        return;
      }

      if (parsed.protocol === "mailto:") {
        window.location.href = parsed.href;
      } else {
        window.open(parsed.href, "_blank", "noopener,noreferrer");
      }
    } catch {
      showToast("The application destination is invalid.");
    }
  }

  async function shareJob() {
    if (!currentJob) return;

    const shareData = {
      title: `${currentJob.title} | PeopleLink Jobs`,
      text: `${currentJob.title} at ${currentJob.company} — ${currentJob.location}`,
      url: getJobUrl(currentJob)
    };

    if (navigator.share) {
      try {
        await navigator.share(shareData);
      } catch (error) {
        if (error.name !== "AbortError") {
          showToast("Unable to open the sharing menu.");
        }
      }
      return;
    }

    copyJobLink();
  }

  function shareViaWhatsApp() {
    if (!currentJob) return;

    const message = `${currentJob.title} at ${currentJob.company}\n` +
      `${currentJob.location}\n` +
      `${getJobUrl(currentJob)}`;

    const url = `https://wa.me/?text=${encodeURIComponent(message)}`;
    window.open(url, "_blank", "noopener,noreferrer");
  }

  async function copyJobLink() {
    if (!currentJob) return;

    try {
      await navigator.clipboard.writeText(getJobUrl(currentJob));
      showToast("Job link copied.");
    } catch {
      // Fallback for browsers without clipboard permission.
      const input = document.createElement("textarea");
      input.value = getJobUrl(currentJob);
      input.setAttribute("readonly", "");
      input.style.position = "fixed";
      input.style.opacity = "0";
      root.appendChild(input);
      input.select();

      let copied = false;

      try {
        copied = document.execCommand("copy");
      } catch {
        copied = false;
      }

      input.remove();
      showToast(copied ? "Job link copied." : "Unable to copy link. Please copy the page URL manually.");
    }
  }

  async function submitReport(event) {
    event.preventDefault();

    const form = event.currentTarget;
    if (!form.reportValidity() || !currentJob) return;

    const formData = new FormData(form);
    const payload = {
      job_id: currentJob.id,
      job_type: currentJob.jobType,
      reason: formData.get("reason"),
      message: formData.get("message"),
      email: formData.get("email")
    };

    if (!CONFIG.enableServerReports) {
      showToast("Demo only: connect job-report-submit.php to submit reports for admin review.");
      return;
    }

    try {
      const response = await fetch(CONFIG.reportEndpoint, {
        method: "POST",
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest"
        },
        body: JSON.stringify(payload)
      });

      if (!response.ok) throw new Error("Report request failed");

      const result = await response.json();
      if (!result.success) throw new Error(result.message || "Report submission failed");

      form.reset();
      closeModal(reportModal);
      showToast("Thank you. Your report has been sent for review.");
    } catch {
      showToast("Unable to submit your report. Please try again.");
    }
  }

  async function loadJob() {
    const id = getJobIdFromUrl();
    const type = getJobTypeFromUrl();

    // Demo lookup only. Use a server endpoint in production.
    currentJob = sampleJobs.find(job =>
      String(job.id) === String(id) &&
      (!type || job.jobType === type)
    );

    if (!currentJob) {
      setText("#plJdTitle", "Job Not Found");
      setText("#plJdCompany", "PeopleLink Jobs");
      setText("#plJdSummary", "This job could not be found in the demonstration data. Connect the live job details endpoint to load approved listings.");
      $("#plJdResponsibilities").innerHTML = "";
      $("#plJdSkills").innerHTML = "";
      $("#plJdEligibility").innerHTML = "";
      $("#plJdSimilarJobs").innerHTML = "";
      $("#plJdApplyTop").disabled = true;
      $("#plJdApplyWhatsApp").disabled = true;
      $("#plJdApplyEmail").disabled = true;
      $("#plJdSaveTop").disabled = true;
      $("#plJdSaveSidebar").disabled = true;
      document.title = "Job Not Found | PeopleLink";
      return;
    }

    renderOverview(currentJob);
    renderSimilarJobs(currentJob);

    const active = isJobOpen(currentJob);

    if (!active) {
      showToast("This listing may have expired. Please verify its current status.");
      $("#plJdApplyTop").disabled = true;
      $("#plJdApplyWhatsApp").disabled = true;
      $("#plJdApplyEmail").disabled = true;
    }

    // Job type and visibility must ultimately be validated on the server.
    root.dataset.jobId = currentJob.id;
    root.dataset.jobType = currentJob.jobType;
  }

  root.addEventListener("click", event => {
    const button = event.target.closest("button");
    if (!button || !root.contains(button)) return;

    if (button.id === "plJdApplyTop" ||
        button.id === "plJdApplyWhatsApp" ||
        button.id === "plJdApplyEmail") {
      openApplyOptions();
      return;
    }

    if (button.id === "plJdSaveTop" ||
        button.id === "plJdSaveSidebar") {
      saveJob();
      return;
    }

    if (button.id === "plJdShareNative") {
      shareJob();
      return;
    }

    if (button.id === "plJdShareWhatsApp") {
      shareViaWhatsApp();
      return;
    }

    if (button.id === "plJdCopyLink") {
      copyJobLink();
      return;
    }

    if (button.id === "plJdOpenReport") {
      openModal(reportModal);
      return;
    }

    if (button.hasAttribute("data-jd-close")) {
      closeModal(button.closest(".pl-jd-modal"));
      return;
    }

    if (button.hasAttribute("data-jd-application")) {
      startApplication(button.dataset.jdApplication);
      return;
    }

    if (button.hasAttribute("data-jd-open-similar")) {
      const id = button.dataset.jdOpenSimilar;
      const target = sampleJobs.find(job => String(job.id) === String(id));
      if (!target) return;

      const url = new URL(window.location.href);
      url.searchParams.set("job_id", target.id);
      url.searchParams.set("job_type", target.jobType);
      window.location.href = url.href;
    }
  });

  $("#plJdReportForm").addEventListener("submit", submitReport);

  document.addEventListener("keydown", event => {
    if (event.key === "Escape") {
      closeAllModals();
    }
  });

  // Initialize the demo job from ?job_id=101&job_type=global
  loadJob();
})();





document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       VISIBILITY CARDS
    ===================================================== */

    const visibilityCards =
        document.querySelectorAll(".pl-visibility-card");

    const visibilityInputs =
        document.querySelectorAll(
            'input[name="job_visibility"]'
        );


    function updateVisibility() {

        visibilityCards.forEach(function (card) {

            const input =
                card.querySelector(
                    'input[name="job_visibility"]'
                );

            if (input && input.checked) {

                card.classList.add("active");

            } else {

                card.classList.remove("active");

            }

        });

    }


    visibilityInputs.forEach(function (input) {

        input.addEventListener(
            "change",
            updateVisibility
        );

    });


    updateVisibility();


    /* =====================================================
       APPLICATION TOGGLES
    ===================================================== */

    const whatsappToggle =
        document.querySelector(
            'input[name="enable_whatsapp"]'
        );

    const emailToggle =
        document.querySelector(
            'input[name="enable_email"]'
        );

    const whatsappNumber =
        document.querySelector(
            'input[name="whatsapp_number"]'
        );

    const resumeEmail =
        document.querySelector(
            'input[name="resume_email"]'
        );


    function updateApplicationFields() {

        if (whatsappToggle && whatsappNumber) {

            whatsappNumber.disabled =
                !whatsappToggle.checked;

            if (!whatsappToggle.checked) {

                whatsappNumber.value = "";

            }

        }


        if (emailToggle && resumeEmail) {

            resumeEmail.disabled =
                !emailToggle.checked;

            if (!emailToggle.checked) {

                resumeEmail.value = "";

            }

        }

    }


    if (whatsappToggle) {

        whatsappToggle.addEventListener(
            "change",
            updateApplicationFields
        );

    }


    if (emailToggle) {

        emailToggle.addEventListener(
            "change",
            updateApplicationFields
        );

    }


    updateApplicationFields();


    /* =====================================================
       LIVE JOB PREVIEW
    ===================================================== */

    const jobTitle =
        document.querySelector(
            'input[name="job_title"]'
        );

    const companyName =
        document.querySelector(
            'input[name="company_name"]'
        );

    const jobLocation =
        document.querySelector(
            'input[name="job_location"]'
        );

    const employmentType =
        document.querySelector(
            'select[name="employment_type"]'
        );

    const workMode =
        document.querySelector(
            'select[name="work_mode"]'
        );

    const jobDescription =
        document.querySelector(
            'textarea[name="job_description"]'
        );


    const previewTitle =
        document.getElementById(
            "previewJobTitle"
        );

    const previewCompany =
        document.getElementById(
            "previewCompany"
        );

    const previewLocation =
        document.getElementById(
            "previewLocation"
        );

    const previewEmployment =
        document.getElementById(
            "previewEmployment"
        );

    const previewMode =
        document.getElementById(
            "previewMode"
        );

    const previewDescription =
        document.getElementById(
            "previewDescription"
        );


    function updatePreview() {

        if (previewTitle && jobTitle) {

            previewTitle.textContent =
                jobTitle.value.trim() ||
                "Your Job Title";

        }


        if (previewCompany && companyName) {

            previewCompany.textContent =
                companyName.value.trim() ||
                "Company / Organisation";

        }


        if (previewLocation && jobLocation) {

            previewLocation.textContent =
                jobLocation.value.trim() ||
                "Job Location";

        }


        if (previewEmployment && employmentType) {

            previewEmployment.textContent =
                employmentType.value ||
                "Employment Type";

        }


        if (previewMode && workMode) {

            previewMode.textContent =
                workMode.value ||
                "Work Mode";

        }


        if (previewDescription && jobDescription) {

            previewDescription.textContent =
                jobDescription.value.trim() ||
                "Your job description will appear here.";

        }

    }


    const previewFields = [
        jobTitle,
        companyName,
        jobLocation,
        employmentType,
        workMode,
        jobDescription
    ];


    previewFields.forEach(function (field) {

        if (!field) {
            return;
        }

        field.addEventListener(
            "input",
            updatePreview
        );

        field.addEventListener(
            "change",
            updatePreview
        );

    });


    updatePreview();


    /* =====================================================
       PREVIEW BUTTON
    ===================================================== */

    const previewButton =
        document.getElementById(
            "previewButton"
        );


    if (previewButton) {

        previewButton.addEventListener(
            "click",
            function () {

                updatePreview();

                const preview =
                    document.querySelector(
                        ".pl-job-preview"
                    );

                if (preview) {

                    preview.scrollIntoView({
                        behavior:"smooth",
                        block:"center"
                    });

                }

            }
        );

    }


    /* =====================================================
       FILE NAME DISPLAY
    ===================================================== */

    const uploadInputs =
        document.querySelectorAll(
            ".pl-upload input[type='file']"
        );


    uploadInputs.forEach(function (input) {

        input.addEventListener(
            "change",
            function () {

                const upload =
                    this.closest(".pl-upload");

                if (!upload) {
                    return;
                }


                const strong =
                    upload.querySelector("strong");


                if (
                    strong &&
                    this.files &&
                    this.files.length
                ) {

                    strong.textContent =
                        this.files[0].name;

                }

            }
        );

    });


    /* =====================================================
       REMOVE ERROR WHEN FIELD CHANGES
    ===================================================== */

    const allFields =
        document.querySelectorAll(
            "#postJobForm input, #postJobForm select, #postJobForm textarea"
        );


    allFields.forEach(function (field) {

        field.addEventListener(
            "input",
            function () {

                if (this.value.trim()) {

                    this.classList.remove(
                        "pl-input-error"
                    );

                }

            }
        );


        field.addEventListener(
            "change",
            function () {

                if (this.value.trim()) {

                    this.classList.remove(
                        "pl-input-error"
                    );

                }

            }
        );

    });


    /* =====================================================
       FORM VALIDATION
    ===================================================== */

    const form =
        document.getElementById(
            "postJobForm"
        );


    if (form) {

        form.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();


                const requiredFields =
                    form.querySelectorAll(
                        "[required]"
                    );


                let firstInvalid = null;


                requiredFields.forEach(
                    function (field) {

                        if (!field.value.trim()) {

                            field.classList.add(
                                "pl-input-error"
                            );

                            if (!firstInvalid) {

                                firstInvalid =
                                    field;

                            }

                        } else {

                            field.classList.remove(
                                "pl-input-error"
                            );

                        }

                    }
                );


                if (firstInvalid) {

                    firstInvalid.focus();

                    firstInvalid.scrollIntoView({
                        behavior:"smooth",
                        block:"center"
                    });

                    return;

                }


                /*
                 * Connect your PHP/AJAX submission
                 * endpoint here.
                 *
                 * Example:
                 *
                 * const formData = new FormData(form);
                 *
                 * fetch("submit-job.php", {
                 *     method:"POST",
                 *     body:formData
                 * });
                 */


                alert(
                    "Your job has been submitted for approval."
                );

            }
        );

    }

});





document.addEventListener("DOMContentLoaded", function () {


    /* =====================================================
       DIRECTORY SEARCH
    ====================================================== */

    const searchButton =
        document.getElementById(
            "directorySearchBtn"
        );

    const keyword =
        document.getElementById(
            "directoryKeyword"
        );

    const profession =
        document.getElementById(
            "professionFilter"
        );

    const business =
        document.getElementById(
            "businessFilter"
        );

    const community =
        document.getElementById(
            "communityFilter"
        );

    const state =
        document.getElementById(
            "stateFilter"
        );

    const district =
        document.getElementById(
            "districtFilter"
        );

    const city =
        document.getElementById(
            "cityFilter"
        );

    const service =
        document.getElementById(
            "serviceFilter"
        );


    if (searchButton) {

        searchButton.addEventListener(
            "click",
            function () {

                const searchData = {

                    keyword:
                        keyword
                            ? keyword.value.trim()
                            : "",

                    profession:
                        profession
                            ? profession.value
                            : "",

                    business:
                        business
                            ? business.value
                            : "",

                    community:
                        community
                            ? community.value
                            : "",

                    state:
                        state
                            ? state.value
                            : "",

                    district:
                        district
                            ? district.value
                            : "",

                    city:
                        city
                            ? city.value
                            : "",

                    service:
                        service
                            ? service.value
                            : ""

                };


                /*
                 * Connect your PHP/AJAX search endpoint here.
                 *
                 * Example:
                 *
                 * fetch("directory-search.php", {
                 *     method:"POST",
                 *     headers:{
                 *         "Content-Type":
                 *             "application/json"
                 *     },
                 *     body:
                 *         JSON.stringify(searchData)
                 * });
                 */


                console.log(
                    "Directory Search:",
                    searchData
                );


                const listingSection =
                    document.querySelector(
                        ".pl-listing-section"
                    );


                if (listingSection) {

                    listingSection.scrollIntoView({
                        behavior:"smooth",
                        block:"start"
                    });

                }

            }
        );

    }


    /* =====================================================
       RESET FILTERS
    ====================================================== */

    const resetButton =
        document.getElementById(
            "resetDirectory"
        );


    if (resetButton) {

        resetButton.addEventListener(
            "click",
            function () {

                if (keyword) {
                    keyword.value = "";
                }

                if (profession) {
                    profession.value = "";
                }

                if (business) {
                    business.value = "";
                }

                if (community) {
                    community.value = "";
                }

                if (state) {
                    state.value = "";
                }

                if (district) {
                    district.value = "";
                }

                if (city) {
                    city.value = "";
                }

                if (service) {
                    service.value = "";
                }

            }
        );

    }


    /* =====================================================
       ENTER KEY SEARCH
    ====================================================== */

    if (keyword) {

        keyword.addEventListener(
            "keydown",
            function (event) {

                if (event.key === "Enter") {

                    event.preventDefault();

                    if (searchButton) {

                        searchButton.click();

                    }

                }

            }
        );

    }


    /* =====================================================
       NEAR ME
    ====================================================== */

    const nearMeButton =
        document.getElementById(
            "nearMeButton"
        );


    if (nearMeButton) {

        nearMeButton.addEventListener(
            "click",
            function () {

                if (!navigator.geolocation) {

                    alert(
                        "Location access is not supported by this browser."
                    );

                    return;

                }


                nearMeButton.disabled = true;

                nearMeButton.innerHTML =
                    '<i class="bi bi-hourglass-split"></i> Finding Location...';


                navigator.geolocation.getCurrentPosition(

                    function (position) {

                        const latitude =
                            position.coords.latitude;

                        const longitude =
                            position.coords.longitude;


                        /*
                         * Send latitude and longitude
                         * to your PHP/AJAX nearby directory
                         * endpoint here.
                         */

                        console.log(
                            "User location:",
                            latitude,
                            longitude
                        );


                        nearMeButton.disabled = false;

                        nearMeButton.innerHTML =
                            '<i class="bi bi-check-circle"></i> Location Found';


                        setTimeout(
                            function () {

                                nearMeButton.innerHTML =
                                    '<i class="bi bi-crosshair"></i> Explore Near Me';

                            },
                            2500
                        );

                    },

                    function () {

                        nearMeButton.disabled = false;

                        nearMeButton.innerHTML =
                            '<i class="bi bi-crosshair"></i> Explore Near Me';


                        alert(
                            "Location access was not permitted. You can still search the directory using the filters."
                        );

                    },

                    {
                        enableHighAccuracy:true,

                        timeout:10000,

                        maximumAge:300000

                    }

                );

            }
        );

    }


    /* =====================================================
       CATEGORY CARD ANIMATION
    ====================================================== */

    const categoryCards =
        document.querySelectorAll(
            ".pl-category-card"
        );


    categoryCards.forEach(
        function (card) {

            card.addEventListener(
                "mouseenter",
                function () {

                    this.style.transform =
                        "translateY(-4px)";

                }
            );


            card.addEventListener(
                "mouseleave",
                function () {

                    this.style.transform =
                        "translateY(0)";

                }
            );

        }
    );


});






/* =========================================================
   PEOPLELINK - PROFESSIONAL / BUSINESS PROFILE
   Page 18
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const contactModal = document.getElementById("contactModal");
    const reportModal = document.getElementById("reportModal");
    const toast = document.getElementById("profileToast");


    /* =====================================================
       TOAST
    ===================================================== */

    function showToast(message) {

        if (!toast) return;

        const text = toast.querySelector("span");

        if (text) {
            text.textContent = message;
        }

        toast.classList.add("show");

        setTimeout(function () {
            toast.classList.remove("show");
        }, 3000);
    }


    /* =====================================================
       MODAL
    ===================================================== */

    function openModal(modal) {

        if (!modal) return;

        modal.classList.add("active");
        document.body.style.overflow = "hidden";
    }


    function closeModal(modal) {

        if (!modal) return;

        modal.classList.remove("active");
        document.body.style.overflow = "";
    }


    document.querySelectorAll("[data-close-modal]").forEach(function (button) {

        button.addEventListener("click", function () {

            const modal = button.closest(".pl-modal");

            closeModal(modal);

        });

    });


    document.querySelectorAll(".pl-modal-overlay").forEach(function (overlay) {

        overlay.addEventListener("click", function () {

            const modal = overlay.closest(".pl-modal");

            closeModal(modal);

        });

    });


    document.addEventListener("keydown", function (event) {

        if (event.key === "Escape") {

            closeModal(contactModal);
            closeModal(reportModal);

        }

    });


    /* =====================================================
       CONTACT BUTTONS
    ===================================================== */

    const contactButtons = [
        "contactBtn",
        "sideContactBtn",
        "ctaContactBtn"
    ];

    contactButtons.forEach(function (id) {

        const button = document.getElementById(id);

        if (button) {

            button.addEventListener("click", function () {
                openModal(contactModal);
            });

        }

    });


    /* =====================================================
       SAVE PROFILE
    ===================================================== */

    const saveButtons = [
        "saveProfileBtn",
        "sideSaveBtn",
        "ctaSaveBtn"
    ];

    saveButtons.forEach(function (id) {

        const button = document.getElementById(id);

        if (button) {

            button.addEventListener("click", function () {

                button.classList.toggle("saved");

                const isSaved = button.classList.contains("saved");

                if (isSaved) {

                    if (button.querySelector("i")) {
                        button.querySelector("i").className =
                            "bi bi-bookmark-fill";
                    }

                    showToast("Profile saved successfully.");

                } else {

                    if (button.querySelector("i")) {
                        button.querySelector("i").className =
                            "bi bi-bookmark";
                    }

                    showToast("Profile removed from saved profiles.");

                }

            });

        }

    });


    /* =====================================================
       SHARE PROFILE
    ===================================================== */

    const shareButtons = [
        "shareProfileBtn",
        "sideShareBtn"
    ];

    shareButtons.forEach(function (id) {

        const button = document.getElementById(id);

        if (!button) return;

        button.addEventListener("click", function () {

            const shareData = {
                title: "PeopleLink Professional Profile",
                text: "View this professional/business profile on PeopleLink.",
                url: window.location.href
            };


            if (navigator.share) {

                navigator.share(shareData)
                    .then(function () {
                        showToast("Profile shared successfully.");
                    })
                    .catch(function () {
                        // User cancelled share.
                    });

            } else {

                navigator.clipboard.writeText(window.location.href)
                    .then(function () {
                        showToast("Profile link copied.");
                    })
                    .catch(function () {
                        showToast("Unable to copy profile link.");
                    });

            }

        });

    });


    /* =====================================================
       ENQUIRY SCROLL
    ===================================================== */

    const enquiryButtons = [
        "sideEnquiryBtn",
        "ctaEnquiryBtn"
    ];

    enquiryButtons.forEach(function (id) {

        const button = document.getElementById(id);

        if (!button) return;

        button.addEventListener("click", function () {

            const enquiry = document.getElementById("enquiry");

            if (enquiry) {

                enquiry.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });

            }

        });

    });


    /* =====================================================
       ENQUIRY FORM
    ===================================================== */

    const enquiryForm = document.getElementById("profileEnquiryForm");

    if (enquiryForm) {

        enquiryForm.addEventListener("submit", function (event) {

            event.preventDefault();

            const submitButton =
                enquiryForm.querySelector("button[type='submit']");

            if (submitButton) {

                const originalText = submitButton.innerHTML;

                submitButton.disabled = true;

                submitButton.innerHTML =
                    '<i class="bi bi-hourglass-split"></i> Sending...';


                setTimeout(function () {

                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;

                    enquiryForm.reset();

                    showToast("Your enquiry has been submitted successfully.");

                }, 900);

            }

        });

    }


    /* =====================================================
       REPORT PROFILE
    ===================================================== */

    const reportButton = document.getElementById("reportProfileBtn");

    if (reportButton) {

        reportButton.addEventListener("click", function () {

            openModal(reportModal);

        });

    }


    /* =====================================================
       REPORT FORM
    ===================================================== */

    const reportForm = document.getElementById("reportForm");

    if (reportForm) {

        reportForm.addEventListener("submit", function (event) {

            event.preventDefault();

            const submitButton =
                reportForm.querySelector("button[type='submit']");

            if (submitButton) {

                submitButton.disabled = true;

                submitButton.innerHTML =
                    '<i class="bi bi-hourglass-split"></i> Submitting...';

                setTimeout(function () {

                    submitButton.disabled = false;

                    submitButton.innerHTML =
                        '<i class="bi bi-send-fill"></i> Submit Report';

                    reportForm.reset();

                    closeModal(reportModal);

                    showToast(
                        "Thank you. Your report has been submitted for review."
                    );

                }, 900);

            }

        });

    }


    /* =====================================================
       LOCATION
    ===================================================== */

    const locationButton = document.getElementById("locationBtn");

    if (locationButton) {

        locationButton.addEventListener("click", function () {

            const locationQuery =
                encodeURIComponent(
                    "Agra, Uttar Pradesh, India"
                );

            window.open(
                "https://www.google.com/maps/search/?api=1&query=" +
                locationQuery,
                "_blank"
            );

        });

    }


    /* =====================================================
       CONTACT OPTION DEMO
    ===================================================== */

    document.querySelectorAll(".pl-contact-option").forEach(function (button) {

        button.addEventListener("click", function () {

            const title = button.querySelector("strong");

            if (title) {

                showToast(
                    title.textContent + " option selected."
                );

            }

        });

    });


    /* =====================================================
       GALLERY IMAGE VIEW
    ===================================================== */

    document.querySelectorAll(".pl-gallery-item img").forEach(function (image) {

        image.addEventListener("click", function () {

            window.open(image.src, "_blank");

        });

        image.style.cursor = "pointer";

    });


    /* =====================================================
       PROFILE PAGE BACKEND READY HOOK
    ===================================================== */

    /*
       When connecting this page with PHP/MySQL/AJAX,
       replace the demo form handlers above with:

       fetch("profile-enquiry-submit.php", {
           method: "POST",
           body: new FormData(enquiryForm)
       })

       Profile data can also be loaded using:

       professional-profile.php?id=123

       Then fetch the profile from the database based on
       profile ID and profile type.

       Example profile types:

       professional
       business

       Recommended fields:

       profile_id
       profile_type
       name
       profession
       category
       specialisation
       qualification
       experience
       designation
       organisation
       community
       country
       state
       district
       city
       service_area
       description
       visibility
       approval_status
       profile_image
    */

});






/* =========================================================
   PEOPLELINK - PAGE 19
   NEAR ME
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       ELEMENTS
    ===================================================== */

    const useLocationBtn =
        document.getElementById("useLocationBtn");

    const detectLocationBtn =
        document.getElementById("detectLocationBtn");

    const finalLocationBtn =
        document.getElementById("finalLocationBtn");

    const allowLocationBtn =
        document.getElementById("allowLocationBtn");

    const locationModal =
        document.getElementById("locationModal");

    const currentLocationMethod =
        document.getElementById("currentLocationMethod");

    const manualLocationMethod =
        document.getElementById("manualLocationMethod");

    const currentLocationBox =
        document.getElementById("currentLocationBox");

    const manualLocationBox =
        document.getElementById("manualLocationBox");

    const currentLocationText =
        document.getElementById("currentLocationText");

    const locationStatus =
        document.getElementById("locationStatus");

    const searchNearbyBtn =
        document.getElementById("searchNearbyBtn");

    const serviceSearch =
        document.getElementById("serviceSearch");

    const applyFiltersBtn =
        document.getElementById("applyFiltersBtn");

    const resetFiltersBtn =
        document.getElementById("resetFiltersBtn");

    const resetFiltersBtnBottom =
        document.getElementById("resetFiltersBtnBottom");

    const resultText =
        document.getElementById("resultText");

    const nearResults =
        document.getElementById("nearResults");

    const increaseDistanceBtn =
        document.getElementById("increaseDistanceBtn");

    const changeLocationBtn =
        document.getElementById("changeLocationBtn");

    const areaSearchBtn =
        document.getElementById("areaSearchBtn");

    const viewMapBtn =
        document.getElementById("viewMapBtn");

    const finalMapBtn =
        document.getElementById("finalMapBtn");

    const finalSearchBtn =
        document.getElementById("finalSearchBtn");

    const savedListingsBtn =
        document.getElementById("savedListingsBtn");

    const toast =
        document.getElementById("nearToast");


    /* =====================================================
       TOAST
    ===================================================== */

    function showToast(message) {

        if (!toast) {
            return;
        }

        const text = toast.querySelector("span");

        if (text) {
            text.textContent = message;
        }

        toast.classList.add("show");

        setTimeout(function () {

            toast.classList.remove("show");

        }, 3000);
    }


    /* =====================================================
       MODAL
    ===================================================== */

    function openLocationModal() {

        if (!locationModal) {
            return;
        }

        locationModal.classList.add("active");

        document.body.style.overflow = "hidden";
    }


    function closeLocationModal() {

        if (!locationModal) {
            return;
        }

        locationModal.classList.remove("active");

        document.body.style.overflow = "";
    }


    document.querySelectorAll(
        "[data-close-location-modal]"
    ).forEach(function (button) {

        button.addEventListener("click", function () {

            closeLocationModal();

        });

    });


    const modalOverlay =
        document.querySelector(
            ".pl-near-modal-overlay"
        );

    if (modalOverlay) {

        modalOverlay.addEventListener(
            "click",
            function () {

                closeLocationModal();

            }
        );

    }


    document.addEventListener("keydown", function (event) {

        if (event.key === "Escape") {

            closeLocationModal();

        }

    });


    /* =====================================================
       LOCATION METHOD
    ===================================================== */

    if (currentLocationMethod) {

        currentLocationMethod.addEventListener(
            "click",
            function () {

                currentLocationMethod.classList.add("active");

                if (manualLocationMethod) {
                    manualLocationMethod.classList.remove("active");
                }

                if (currentLocationBox) {
                    currentLocationBox.style.display = "flex";
                }

                if (manualLocationBox) {
                    manualLocationBox.classList.remove("active");
                }

            }
        );

    }


    if (manualLocationMethod) {

        manualLocationMethod.addEventListener(
            "click",
            function () {

                manualLocationMethod.classList.add("active");

                if (currentLocationMethod) {
                    currentLocationMethod.classList.remove("active");
                }

                if (currentLocationBox) {
                    currentLocationBox.style.display = "none";
                }

                if (manualLocationBox) {
                    manualLocationBox.classList.add("active");
                }

            }
        );

    }


    /* =====================================================
       OPEN LOCATION MODAL
    ===================================================== */

    [
        useLocationBtn,
        detectLocationBtn,
        finalLocationBtn
    ].forEach(function (button) {

        if (!button) {
            return;
        }

        button.addEventListener("click", function () {

            openLocationModal();

        });

    });


    if (allowLocationBtn) {

        allowLocationBtn.addEventListener(
            "click",
            function () {

                closeLocationModal();

                requestUserLocation();

            }
        );

    }


    /* =====================================================
       GEOLOCATION
    ===================================================== */

    function requestUserLocation() {

        if (!navigator.geolocation) {

            showToast(
                "Location services are not supported by this browser."
            );

            return;
        }


        if (locationStatus) {

            locationStatus.innerHTML =
                '<i class="bi bi-hourglass-split"></i>' +
                '<span>Detecting your location...</span>';

        }


        if (currentLocationText) {

            currentLocationText.textContent =
                "Detecting your location...";

        }


        navigator.geolocation.getCurrentPosition(

            function (position) {

                const latitude =
                    position.coords.latitude;

                const longitude =
                    position.coords.longitude;


                /*
                 * For production:
                 *
                 * Send latitude/longitude to your PHP/AJAX
                 * endpoint and reverse-geocode them.
                 *
                 * Example:
                 *
                 * fetch("nearby-search.php", {
                 *     method: "POST",
                 *     body: JSON.stringify({
                 *         latitude: latitude,
                 *         longitude: longitude
                 *     })
                 * });
                 */


                if (currentLocationText) {

                    currentLocationText.textContent =
                        "Current location detected";

                }


                if (locationStatus) {

                    locationStatus.innerHTML =
                        '<i class="bi bi-check-circle-fill"></i>' +
                        '<span>Location detected. Nearby results can now be shown.</span>';

                }


                showToast(
                    "Location detected successfully."
                );


                updateDistanceResults();

            },


            function (error) {

                let message =
                    "Unable to access your location.";

                if (error.code === 1) {

                    message =
                        "Location permission was denied.";

                } else if (error.code === 2) {

                    message =
                        "Your location could not be determined.";

                } else if (error.code === 3) {

                    message =
                        "Location request timed out.";

                }


                if (locationStatus) {

                    locationStatus.innerHTML =
                        '<i class="bi bi-exclamation-circle"></i>' +
                        '<span>' + message + '</span>';

                }


                if (currentLocationText) {

                    currentLocationText.textContent =
                        "Location not selected";

                }


                showToast(message);

            },

            {
                enableHighAccuracy: false,
                timeout: 10000,
                maximumAge: 300000
            }

        );

    }


    /* =====================================================
       AREA SEARCH
    ===================================================== */

    if (areaSearchBtn) {

        areaSearchBtn.addEventListener(
            "click",
            function () {

                if (manualLocationMethod) {
                    manualLocationMethod.click();
                }

                const searchSection =
                    document.querySelector(
                        ".pl-near-search-section"
                    );

                if (searchSection) {

                    searchSection.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });

                }

            }
        );

    }


    /* =====================================================
       SEARCH NEARBY
    ===================================================== */

    if (searchNearbyBtn) {

        searchNearbyBtn.addEventListener(
            "click",
            function () {

                performSearch();

            }
        );

    }


    if (serviceSearch) {

        serviceSearch.addEventListener(
            "keydown",
            function (event) {

                if (event.key === "Enter") {

                    event.preventDefault();

                    performSearch();

                }

            }
        );

    }


    function performSearch() {

        const query =
            serviceSearch
                ? serviceSearch.value.trim()
                : "";

        const city =
            document.getElementById(
                "cityArea"
            );

        const location =
            city
                ? city.value.trim()
                : "";

        const state =
            document.getElementById(
                "stateSelect"
            );

        const selectedState =
            state
                ? state.value
                : "";


        /*
         * Production AJAX hook:
         *
         * fetch("nearby-search.php", {
         *     method: "POST",
         *     headers: {
         *         "Content-Type": "application/json"
         *     },
         *     body: JSON.stringify({
         *         query: query,
         *         state: selectedState,
         *         city: location
         *     })
         * });
         */


        filterResults(query);

        showToast(
            "Nearby search updated."
        );

    }


    /* =====================================================
       FILTER RESULTS
    ===================================================== */

    function filterResults(query) {

        if (!nearResults) {
            return;
        }

        const cards =
            nearResults.querySelectorAll(
                ".pl-near-result-card"
            );

        let visibleCount = 0;

        query = query.toLowerCase();


        cards.forEach(function (card) {

            const text =
                card.textContent.toLowerCase();

            if (!query || text.includes(query)) {

                card.classList.remove("hidden");

                visibleCount++;

            } else {

                card.classList.add("hidden");

            }

        });


        updateResultText(visibleCount);

    }


    function updateResultText(count) {

        if (!resultText) {
            return;
        }

        if (count === 0) {

            resultText.textContent =
                "No matching nearby listings found.";

        } else {

            resultText.textContent =
                "Showing " +
                count +
                " nearby professionals and service providers.";

        }

    }


    /* =====================================================
       APPLY FILTERS
    ===================================================== */

    if (applyFiltersBtn) {

        applyFiltersBtn.addEventListener(
            "click",
            function () {

                const query =
                    serviceSearch
                        ? serviceSearch.value.trim()
                        : "";

                filterResults(query);

                showToast(
                    "Filters applied successfully."
                );

            }
        );

    }


    /* =====================================================
       RESET FILTERS
    ===================================================== */

    function resetFilters() {

        const ids = [
            "serviceSearch",
            "cityArea",
            "pincode",
            "locationFilter"
        ];

        ids.forEach(function (id) {

            const element =
                document.getElementById(id);

            if (element) {
                element.value = "";
            }

        });


        const selects = [
            "stateSelect",
            "districtSelect",
            "professionFilter",
            "businessFilter",
            "serviceFilter",
            "communityFilter"
        ];


        selects.forEach(function (id) {

            const element =
                document.getElementById(id);

            if (element) {
                element.selectedIndex = 0;
            }

        });


        const distance =
            document.getElementById(
                "distanceFilter"
            );

        if (distance) {
            distance.value = "5";
        }


        if (nearResults) {

            const cards =
                nearResults.querySelectorAll(
                    ".pl-near-result-card"
                );

            cards.forEach(function (card) {

                card.classList.remove("hidden");

            });

            updateResultText(cards.length);

        }


        showToast(
            "Filters have been reset."
        );

    }


    if (resetFiltersBtn) {

        resetFiltersBtn.addEventListener(
            "click",
            resetFilters
        );

    }


    if (resetFiltersBtnBottom) {

        resetFiltersBtnBottom.addEventListener(
            "click",
            resetFilters
        );

    }


    /* =====================================================
       CATEGORY SELECTION
    ===================================================== */

    document.querySelectorAll(
        ".pl-category-item"
    ).forEach(function (category) {

        category.addEventListener(
            "click",
            function () {

                document.querySelectorAll(
                    ".pl-category-item"
                ).forEach(function (item) {

                    item.classList.remove("active");

                });


                category.classList.add("active");


                const categoryName =
                    category.querySelector(
                        "strong"
                    );


                if (serviceSearch && categoryName) {

                    serviceSearch.value =
                        categoryName.textContent.trim();

                }


                const searchSection =
                    document.querySelector(
                        ".pl-near-search-section"
                    );

                if (searchSection) {

                    searchSection.scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });

                }


                showToast(
                    "Service category selected."
                );

            }
        );

    });


    /* =====================================================
       SAVE LISTINGS
    ===================================================== */

    document.querySelectorAll(
        ".pl-save-listing"
    ).forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                const icon =
                    button.querySelector("i");

                const saved =
                    button.classList.toggle(
                        "saved"
                    );


                if (saved) {

                    if (icon) {
                        icon.className =
                            "bi bi-bookmark-fill";
                    }

                    showToast(
                        "Listing saved successfully."
                    );

                } else {

                    if (icon) {
                        icon.className =
                            "bi bi-bookmark";
                    }

                    showToast(
                        "Listing removed from saved items."
                    );

                }

            }
        );

    });


    /* =====================================================
       DISTANCE
    ===================================================== */

    if (increaseDistanceBtn) {

        increaseDistanceBtn.addEventListener(
            "click",
            function () {

                const distance =
                    document.getElementById(
                        "distanceFilter"
                    );

                if (distance) {

                    distance.value = "25";

                }

                showToast(
                    "Search distance increased to 25 km."
                );

                if (applyFiltersBtn) {
                    applyFiltersBtn.click();
                }

            }
        );

    }


    /* =====================================================
       CHANGE LOCATION
    ===================================================== */

    if (changeLocationBtn) {

        changeLocationBtn.addEventListener(
            "click",
            function () {

                if (manualLocationMethod) {
                    manualLocationMethod.click();
                }


                const searchSection =
                    document.querySelector(
                        ".pl-near-search-section"
                    );

                if (searchSection) {

                    searchSection.scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });

                }

            }
        );

    }


    /* =====================================================
       MAP
    ===================================================== */

    function openMap() {

        /*
         * Replace this with your actual Google Maps,
         * Mapbox, OpenStreetMap or other map integration.
         */

        const location =
            document.getElementById(
                "locationFilter"
            );

        const city =
            document.getElementById(
                "cityArea"
            );

        let query = "Agra, Uttar Pradesh, India";

        if (location && location.value.trim()) {

            query = location.value.trim();

        } else if (city && city.value.trim()) {

            query = city.value.trim();

        }


        const url =
            "https://www.google.com/maps/search/?api=1&query=" +
            encodeURIComponent(query);


        window.open(
            url,
            "_blank"
        );

    }


    if (viewMapBtn) {

        viewMapBtn.addEventListener(
            "click",
            openMap
        );

    }


    if (finalMapBtn) {

        finalMapBtn.addEventListener(
            "click",
            openMap
        );

    }


    /* =====================================================
       FINAL SEARCH
    ===================================================== */

    if (finalSearchBtn) {

        finalSearchBtn.addEventListener(
            "click",
            function () {

                const searchSection =
                    document.querySelector(
                        ".pl-near-search-section"
                    );

                if (searchSection) {

                    searchSection.scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });

                }

                if (serviceSearch) {

                    setTimeout(function () {

                        serviceSearch.focus();

                    }, 500);

                }

            }
        );

    }


    /* =====================================================
       SAVED LISTINGS
    ===================================================== */

    if (savedListingsBtn) {

        savedListingsBtn.addEventListener(
            "click",
            function () {

                /*
                 * Production:
                 * Redirect to logged-in user's saved
                 * professional/business listings.
                 */

                window.location.href =
                    "saved-listings.php";

            }
        );

    }


    /* =====================================================
       LOCATION FILTER
    ===================================================== */

    const locationFilter =
        document.getElementById(
            "locationFilter"
        );

    if (locationFilter) {

        locationFilter.addEventListener(
            "keydown",
            function (event) {

                if (event.key === "Enter") {

                    event.preventDefault();

                    performSearch();

                }

            }
        );

    }


    /* =====================================================
       INITIAL RESULT COUNT
    ===================================================== */

    if (nearResults) {

        const cards =
            nearResults.querySelectorAll(
                ".pl-near-result-card"
            );

        updateResultText(cards.length);

    }

});





/* =========================================================
   PEOPLELINK - EVENTS & ADVERTISEMENTS JS
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    /* -----------------------------------------------------
       CATEGORY BUTTONS
    ----------------------------------------------------- */

    const categoryButtons = document.querySelectorAll(".pl-category-item");

    categoryButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            categoryButtons.forEach(function (item) {
                item.classList.remove("active");
            });

            this.classList.add("active");

            const category = this.getAttribute("data-category");

            const categoryFilter = document.getElementById("categoryFilter");

            if (categoryFilter) {
                categoryFilter.value = category;
            }

            applyFilters();

            const listing = document.getElementById("eventsListing");

            if (listing) {
                setTimeout(function () {
                    listing.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                }, 100);
            }

        });

    });


    /* -----------------------------------------------------
       REGISTRATION FORM
    ----------------------------------------------------- */

    const registrationForm = document.getElementById("registrationForm");

    if (registrationForm) {

        registrationForm.addEventListener("submit", function (e) {

            e.preventDefault();

            closeModal("registrationModal");

            showToast(
                "Registration submitted successfully."
            );

            this.reset();

        });

    }


    /* -----------------------------------------------------
       ENQUIRY FORM
    ----------------------------------------------------- */

    const enquiryForm = document.getElementById("enquiryForm");

    if (enquiryForm) {

        enquiryForm.addEventListener("submit", function (e) {

            e.preventDefault();

            closeModal("enquiryModal");

            showToast(
                "Your enquiry has been submitted."
            );

            this.reset();

        });

    }


    /* -----------------------------------------------------
       POST FORM
    ----------------------------------------------------- */

    const postForm = document.getElementById("postForm");

    if (postForm) {

        postForm.addEventListener("submit", function (e) {

            e.preventDefault();

            closeModal("postModal");

            showToast(
                "Post submitted for admin approval."
            );

            this.reset();

            toggleCommunityField();

        });

    }


    /* -----------------------------------------------------
       ESCAPE KEY
    ----------------------------------------------------- */

    document.addEventListener("keydown", function (e) {

        if (e.key === "Escape") {

            document.querySelectorAll(".pl-modal.show").forEach(function (modal) {
                modal.classList.remove("show");
            });

            document.body.style.overflow = "";

        }

    });

});


/* =========================================================
   APPLY FILTERS
   ========================================================= */

function applyFilters() {

    const cards = document.querySelectorAll(".pl-event-card");

    const searchValue =
        document.getElementById("eventSearch").value
            .trim()
            .toLowerCase();

    const categoryValue =
        document.getElementById("categoryFilter").value
            .trim()
            .toLowerCase();

    const communityValue =
        document.getElementById("communityFilter").value
            .trim()
            .toLowerCase();

    const locationValue =
        document.getElementById("locationFilter").value
            .trim()
            .toLowerCase();

    const visibilityValue =
        document.getElementById("visibilityFilter").value
            .trim()
            .toLowerCase();

    const eventTypeValue =
        document.getElementById("eventTypeFilter").value
            .trim()
            .toLowerCase();

    const adTypeValue =
        document.getElementById("adTypeFilter").value
            .trim()
            .toLowerCase();

    let visibleCount = 0;

    cards.forEach(function (card) {

        const cardText =
            card.innerText.toLowerCase();

        const cardCategory =
            (card.dataset.category || "").toLowerCase();

        const cardCommunity =
            (card.dataset.community || "").toLowerCase();

        const cardLocation =
            (card.dataset.location || "").toLowerCase();

        const cardVisibility =
            (card.dataset.visibility || "").toLowerCase();

        const cardType =
            (card.dataset.type || "").toLowerCase();


        const searchMatch =
            !searchValue ||
            cardText.includes(searchValue);

        const categoryMatch =
            !categoryValue ||
            cardCategory === categoryValue;

        const communityMatch =
            !communityValue ||
            cardCommunity === communityValue;

        const locationMatch =
            !locationValue ||
            cardLocation.includes(locationValue);

        const visibilityMatch =
            !visibilityValue ||
            cardVisibility === visibilityValue;

        const eventTypeMatch =
            !eventTypeValue ||
            cardType === eventTypeValue;

        const adTypeMatch =
            !adTypeValue ||
            cardType === adTypeValue;


        const shouldShow =
            searchMatch &&
            categoryMatch &&
            communityMatch &&
            locationMatch &&
            visibilityMatch &&
            eventTypeMatch &&
            adTypeMatch;


        if (shouldShow) {

            card.style.display = "";

            visibleCount++;

        } else {

            card.style.display = "none";

        }

    });


    updateResultCount(visibleCount);

}


/* =========================================================
   RESET FILTERS
   ========================================================= */

function resetFilters() {

    const ids = [
        "eventSearch",
        "categoryFilter",
        "communityFilter",
        "locationFilter",
        "dateFilter",
        "eventTypeFilter",
        "adTypeFilter",
        "visibilityFilter"
    ];

    ids.forEach(function (id) {

        const element = document.getElementById(id);

        if (!element) return;

        if (element.tagName === "SELECT") {
            element.value = "";
        } else {
            element.value = "";
        }

    });


    document.querySelectorAll(".pl-event-card").forEach(function (card) {
        card.style.display = "";
    });


    document.querySelectorAll(".pl-category-item").forEach(function (item) {
        item.classList.remove("active");
    });


    updateResultCount(
        document.querySelectorAll(".pl-event-card").length
    );

}


/* =========================================================
   RESULT COUNT
   ========================================================= */

function updateResultCount(count) {

    const countElement =
        document.getElementById("resultCount");

    const noResults =
        document.getElementById("noResults");

    if (countElement) {
        countElement.textContent = count;
    }

    if (noResults) {

        if (count === 0) {
            noResults.classList.add("show");
        } else {
            noResults.classList.remove("show");
        }

    }

}


/* =========================================================
   SAVE POST
   ========================================================= */

function savePost(button) {

    if (!button) return;

    button.classList.toggle("saved");

    const icon = button.querySelector("i");

    if (!icon) return;


    if (button.classList.contains("saved")) {

        icon.classList.remove("bi-bookmark");
        icon.classList.add("bi-bookmark-fill");

        showToast("Listing saved to your account.");

    } else {

        icon.classList.remove("bi-bookmark-fill");
        icon.classList.add("bi-bookmark");

        showToast("Listing removed from saved items.");

    }

}


/* =========================================================
   VIEW DETAILS
   ========================================================= */

let currentPostTitle = "";

function viewDetails(title) {

    currentPostTitle = title || "Event Details";

    const titleElement =
        document.getElementById("detailsTitle");

    if (titleElement) {
        titleElement.textContent = currentPostTitle;
    }

    openModal("detailsModal");

}


/* =========================================================
   SHARE
   ========================================================= */

function shareCurrentPost() {

    const title =
        currentPostTitle || "PeopleLink Event";

    const shareData = {
        title: title,
        text: "Check this event or advertisement on PeopleLink.",
        url: window.location.href
    };


    if (navigator.share) {

        navigator.share(shareData)
            .then(function () {
                showToast("Listing shared.");
            })
            .catch(function () {});

    } else {

        if (navigator.clipboard) {

            navigator.clipboard.writeText(window.location.href)
                .then(function () {
                    showToast("Listing link copied.");
                })
                .catch(function () {
                    showToast("Copy the page URL to share this listing.");
                });

        } else {

            showToast("Copy the page URL to share this listing.");

        }

    }

}


/* =========================================================
   MODALS
   ========================================================= */

function openModal(id) {

    const modal = document.getElementById(id);

    if (!modal) return;

    modal.classList.add("show");

    document.body.style.overflow = "hidden";

}


function closeModal(id) {

    const modal = document.getElementById(id);

    if (!modal) return;

    modal.classList.remove("show");

    document.body.style.overflow = "";

}


function openRegistrationModal() {
    openModal("registrationModal");
}


function openEnquiryModal() {
    openModal("enquiryModal");
}


function openPostModal() {

    openModal("postModal");

    toggleCommunityField();

}


function openPackageModal(packageName) {

    const title =
        document.getElementById("packageModalTitle");

    if (title) {
        title.textContent = packageName || "Advertisement Packages";
    }

    openModal("packageModal");

}


function openLiveLink() {

    showToast(
        "The approved external live-stream link will open here."
    );

    /*
       Production example:

       window.open(
           eventLiveUrl,
           "_blank",
           "noopener,noreferrer"
       );
    */

}


/* =========================================================
   COMMUNITY FIELD
   ========================================================= */

function toggleCommunityField() {

    const visibility =
        document.getElementById("postVisibility");

    const communityField =
        document.getElementById("communityField");

    if (!visibility || !communityField) return;


    if (visibility.value === "Community") {

        communityField.style.display = "";

    } else {

        communityField.style.display = "none";

    }

}


/* =========================================================
   TOAST
   ========================================================= */

let toastTimer = null;

function showToast(message) {

    const toast =
        document.getElementById("plToast");

    const toastMessage =
        document.getElementById("toastMessage");

    if (!toast || !toastMessage) return;

    toastMessage.textContent = message;

    toast.classList.add("show");

    clearTimeout(toastTimer);

    toastTimer = setTimeout(function () {

        toast.classList.remove("show");

    }, 3000);

}


/* =========================================================
   DATE FILTER
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const dateFilter =
        document.getElementById("dateFilter");

    if (!dateFilter) return;


    dateFilter.addEventListener("change", function () {

        /*
         * Demo implementation.
         *
         * For production:
         * compare this date with the event's
         * database date field.
         */

        showToast(
            "Date filter selected. Connect this to your event database."
        );

    });

});






/* =========================================================
   PEOPLELINK - EVENT / ADVERTISEMENT DETAILS JS
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    /* -----------------------------------------------------
       REGISTRATION FORM
    ----------------------------------------------------- */

    const registrationForm =
        document.getElementById("detailRegistrationForm");

    if (registrationForm) {

        registrationForm.addEventListener("submit", function (e) {

            e.preventDefault();

            closeDetailModal("registrationModal");

            showDetailToast(
                "Registration submitted successfully."
            );

            this.reset();

        });

    }


    /* -----------------------------------------------------
       ENQUIRY FORM
    ----------------------------------------------------- */

    const enquiryForm =
        document.getElementById("detailEnquiryForm");

    if (enquiryForm) {

        enquiryForm.addEventListener("submit", function (e) {

            e.preventDefault();

            closeDetailModal("enquiryModal");

            showDetailToast(
                "Your enquiry has been submitted."
            );

            this.reset();

        });

    }


    /* -----------------------------------------------------
       REPORT FORM
    ----------------------------------------------------- */

    const reportForm =
        document.getElementById("reportForm");

    if (reportForm) {

        reportForm.addEventListener("submit", function (e) {

            e.preventDefault();

            closeDetailModal("reportModal");

            showDetailToast(
                "Report submitted for admin review."
            );

            this.reset();

        });

    }


    /* -----------------------------------------------------
       ESCAPE KEY
    ----------------------------------------------------- */

    document.addEventListener("keydown", function (e) {

        if (e.key === "Escape") {

            document.querySelectorAll(".pl-detail-modal.show")
                .forEach(function (modal) {
                    modal.classList.remove("show");
                });

            closeLightbox();

            document.body.style.overflow = "";

        }

    });

});


/* =========================================================
   MODALS
   ========================================================= */

function openDetailModal(id) {

    const modal =
        document.getElementById(id);

    if (!modal) return;

    modal.classList.add("show");

    document.body.style.overflow = "hidden";

}


function closeDetailModal(id) {

    const modal =
        document.getElementById(id);

    if (!modal) return;

    modal.classList.remove("show");

    document.body.style.overflow = "";

}


function openRegistrationModal() {

    openDetailModal("registrationModal");

}


function openEnquiryModal() {

    openDetailModal("enquiryModal");

}


function openReportModal() {

    openDetailModal("reportModal");

}


/* =========================================================
   SAVE
   ========================================================= */

function saveDetailsPost(button) {

    if (!button) {

        showDetailToast(
            "Event saved to your PeopleLink account."
        );

        return;

    }


    const icon =
        button.querySelector("i");

    const text =
        button.querySelector("span");


    button.classList.toggle("saved");


    if (button.classList.contains("saved")) {

        if (icon) {

            icon.classList.remove("bi-bookmark");
            icon.classList.add("bi-bookmark-fill");

        }

        if (text) {
            text.textContent = "Saved";
        }

        showDetailToast(
            "Event saved to your account."
        );

    } else {

        if (icon) {

            icon.classList.remove("bi-bookmark-fill");
            icon.classList.add("bi-bookmark");

        }

        if (text) {
            text.textContent = "Save";
        }

        showDetailToast(
            "Event removed from saved items."
        );

    }

}


/* =========================================================
   SHARE
   ========================================================= */

function shareDetailsPost() {

    const shareData = {
        title: "Annual Community Gathering 2026",
        text: "Check this event on PeopleLink.",
        url: window.location.href
    };


    if (navigator.share) {

        navigator.share(shareData)
            .then(function () {
                showDetailToast("Listing shared.");
            })
            .catch(function () {});

        return;
    }


    if (navigator.clipboard) {

        navigator.clipboard
            .writeText(window.location.href)
            .then(function () {

                showDetailToast(
                    "Listing link copied."
                );

            })
            .catch(function () {

                showDetailToast(
                    "Copy the page URL to share this listing."
                );

            });

    } else {

        showDetailToast(
            "Copy the page URL to share this listing."
        );

    }

}


/* =========================================================
   CONTACT ACTIONS
   ========================================================= */

function contactAction(type) {

    switch (type) {

        case "call":

            /*
             * Production:
             *
             * window.location.href = "tel:+919XXXXXXXXX";
             */

            showDetailToast(
                "Calling will use the contact number permitted for this listing."
            );

            break;


        case "whatsapp":

            /*
             * Production:
             *
             * window.open(
             *   "https://wa.me/919XXXXXXXXX",
             *   "_blank"
             * );
             */

            showDetailToast(
                "WhatsApp contact will open when enabled."
            );

            break;


        case "email":

            /*
             * Production:
             *
             * window.location.href =
             * "mailto:example@example.com";
             */

            showDetailToast(
                "Email contact will open when enabled."
            );

            break;


        case "enquiry":

            openEnquiryModal();

            break;

    }

}


/* =========================================================
   LIVE LINK
   ========================================================= */

function openLiveLink() {

    /*
     * In production the URL should come from
     * the approved event database record.
     *
     * Example:
     *
     * const liveUrl = event.live_url;
     * window.open(liveUrl, "_blank", "noopener,noreferrer");
     */

    showDetailToast(
        "The approved external live-stream link will open here."
    );

}


/* =========================================================
   LOCATION
   ========================================================= */

function viewLocation() {

    /*
     * Production:
     * Replace this with the approved map URL.
     */

    showDetailToast(
        "Opening the approved event location."
    );

}


function getDirections() {

    const destination =
        encodeURIComponent(
            "Community Hall, New Delhi, India"
        );

    const mapsUrl =
        "https://www.google.com/maps/dir/?api=1&destination=" +
        destination;


    window.open(
        mapsUrl,
        "_blank",
        "noopener,noreferrer"
    );

}


/* =========================================================
   IMAGE LIGHTBOX
   ========================================================= */

function openImageLightbox(element) {

    if (!element) return;


    const image =
        element.querySelector("img");

    const lightbox =
        document.getElementById("detailLightbox");

    const lightboxImage =
        document.getElementById("lightboxImage");


    if (!image || !lightbox || !lightboxImage) {
        return;
    }


    lightboxImage.src =
        image.src;

    lightboxImage.alt =
        image.alt || "Gallery image";

    lightbox.classList.add("show");

    document.body.style.overflow = "hidden";

}


function closeLightbox() {

    const lightbox =
        document.getElementById("detailLightbox");

    if (!lightbox) return;

    lightbox.classList.remove("show");

    document.body.style.overflow = "";

}


/* =========================================================
   TOAST
   ========================================================= */

let detailToastTimer = null;

function showDetailToast(message) {

    const toast =
        document.getElementById("detailToast");

    const text =
        document.getElementById("detailToastText");


    if (!toast || !text) return;


    text.textContent =
        message;


    toast.classList.add("show");


    clearTimeout(detailToastTimer);


    detailToastTimer =
        setTimeout(function () {

            toast.classList.remove("show");

        }, 3000);

}






/* =========================================================
   PEOPLELINK - POST EVENT / ADVERTISEMENT JS
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    /* -----------------------------------------------------
       POST TYPE RADIO
    ----------------------------------------------------- */

    const typeOptions =
        document.querySelectorAll(".pl-post-type-option");

    const typeInputs =
        document.querySelectorAll(
            'input[name="post_type"]'
        );


    typeInputs.forEach(function (input) {

        input.addEventListener("change", function () {

            selectPostType(this.value, false);

        });

    });


    /* -----------------------------------------------------
       INITIAL VISIBILITY
    ----------------------------------------------------- */

    toggleVisibility();

    togglePostSections();


    /* -----------------------------------------------------
       IMAGE UPLOAD
    ----------------------------------------------------- */

    const mediaUpload =
        document.getElementById("mediaUpload");

    if (mediaUpload) {

        mediaUpload.addEventListener("change", function () {

            showImagePreviews(this.files);

            updatePreviewImage(this.files);

        });

    }


    /* -----------------------------------------------------
       LIVE PREVIEW FIELDS
    ----------------------------------------------------- */

    const titleInput =
        document.querySelector('[name="title"]');

    const shortDescriptionInput =
        document.querySelector('[name="short_description"]');

    const dateInput =
        document.querySelector('[name="event_date"]');

    const locationInput =
        document.querySelector('[name="event_location"]');


    if (titleInput) {

        titleInput.addEventListener(
            "input",
            updatePreview
        );

    }


    if (shortDescriptionInput) {

        shortDescriptionInput.addEventListener(
            "input",
            updatePreview
        );

    }


    if (dateInput) {

        dateInput.addEventListener(
            "change",
            updatePreview
        );

    }


    if (locationInput) {

        locationInput.addEventListener(
            "input",
            updatePreview
        );

    }


    /* -----------------------------------------------------
       FORM SUBMISSION
    ----------------------------------------------------- */

    const form =
        document.getElementById("postContentForm");

    if (form) {

        form.addEventListener("submit", function (e) {

            e.preventDefault();

            if (!validatePostForm()) {
                return;
            }

            /*
             * Production:
             *
             * const formData = new FormData(form);
             *
             * fetch("ajax-submit-event-ad.php", {
             *     method: "POST",
             *     body: formData
             * })
             * .then(response => response.json())
             * .then(data => {
             *     ...
             * });
             */

            showPostToast(
                "Your post has been submitted for approval."
            );

        });

    }


    /* -----------------------------------------------------
       ESCAPE KEY
    ----------------------------------------------------- */

    document.addEventListener("keydown", function (e) {

        if (e.key === "Escape") {

            document.querySelectorAll(
                ".pl-post-modal.show"
            ).forEach(function (modal) {

                modal.classList.remove("show");

            });

            document.body.style.overflow = "";

        }

    });

});


/* =========================================================
   SELECT POST TYPE
   ========================================================= */

function selectPostType(type, fromButton = true) {

    const input =
        document.querySelector(
            'input[name="post_type"][value="' +
            type +
            '"]'
        );

    if (input) {
        input.checked = true;
    }


    document.querySelectorAll(
        ".pl-post-type-option"
    ).forEach(function (option) {

        option.classList.remove("active");

        if (option.dataset.type === type) {
            option.classList.add("active");
        }

    });


    togglePostSections();

    updatePreview();


    if (fromButton) {

        scrollToForm();

    }

}


/* =========================================================
   TOGGLE EVENT / ADVERTISEMENT
   ========================================================= */

function togglePostSections() {

    const selected =
        document.querySelector(
            'input[name="post_type"]:checked'
        );

    const eventSection =
        document.getElementById(
            "eventDetailsSection"
        );

    const adSection =
        document.getElementById(
            "advertisementDetailsSection"
        );

    const packageSection =
        document.getElementById(
            "packageSection"
        );

    const liveSection =
        document.getElementById(
            "liveLinkSection"
        );


    if (!selected) return;


    if (selected.value === "Event") {

        if (eventSection) {
            eventSection.style.display = "";
        }

        if (adSection) {
            adSection.style.display = "none";
        }

        if (packageSection) {
            packageSection.style.display = "none";
        }

        if (liveSection) {
            liveSection.style.display = "";
        }

    } else {

        if (eventSection) {
            eventSection.style.display = "none";
        }

        if (adSection) {
            adSection.style.display = "";
        }

        if (packageSection) {
            packageSection.style.display = "";
        }

        if (liveSection) {
            liveSection.style.display = "none";
        }

    }

}


/* =========================================================
   VISIBILITY
   ========================================================= */

function toggleVisibility() {

    const visibility =
        document.getElementById(
            "visibility"
        );

    const communityGroup =
        document.getElementById(
            "communityGroup"
        );


    if (!visibility || !communityGroup) {
        return;
    }


    if (visibility.value === "Global") {

        communityGroup.style.display = "none";

        const community =
            document.getElementById("community");

        if (community) {
            community.value = "";
        }

    } else {

        communityGroup.style.display = "";

    }

}


/* =========================================================
   SECOND VISIBILITY OPTIONS
   ========================================================= */

function setVisibilityOption(type) {

    document.querySelectorAll(
        ".pl-visibility-option"
    ).forEach(function (option) {

        option.classList.remove("active");

    });


    const selected =
        document.querySelector(
            '.pl-visibility-option input[value="' +
            type +
            '"]'
        );


    if (selected) {

        selected.closest(
            ".pl-visibility-option"
        ).classList.add("active");

    }


    const mainVisibility =
        document.getElementById(
            "visibility"
        );


    if (mainVisibility) {

        mainVisibility.value =
            type;

        toggleVisibility();

    }


    const packageSection =
        document.getElementById(
            "packageSection"
        );


    if (packageSection) {

        const selectedType =
            document.querySelector(
                'input[name="post_type"]:checked'
            );

        if (
            selectedType &&
            selectedType.value === "Advertisement"
        ) {

            packageSection.style.display = "";

        }

    }

}


/* =========================================================
   REGISTRATION CLOSING DATE
   ========================================================= */

function toggleRegistrationClosing() {

    const select =
        document.getElementById(
            "registrationRequired"
        );

    const group =
        document.getElementById(
            "registrationClosingGroup"
        );


    if (!select || !group) return;


    if (select.value === "Yes") {

        group.style.display = "";

    } else {

        group.style.display = "none";

    }

}


/* =========================================================
   IMAGE PREVIEWS
   ========================================================= */

function showImagePreviews(files) {

    const preview =
        document.getElementById(
            "uploadPreview"
        );


    if (!preview) return;


    preview.innerHTML = "";


    if (!files || files.length === 0) {
        return;
    }


    Array.from(files).forEach(function (file, index) {

        if (!file.type.startsWith("image/")) {
            return;
        }


        const reader =
            new FileReader();


        reader.onload =
            function (event) {

                const item =
                    document.createElement("div");

                item.className =
                    "pl-upload-preview-item";


                item.innerHTML = `
                    <img src="${event.target.result}"
                         alt="Uploaded image">

                    <button type="button"
                            onclick="removePreviewImage(this)">
                        <i class="bi bi-x"></i>
                    </button>
                `;


                preview.appendChild(item);

            };


        reader.readAsDataURL(file);

    });

}


/* =========================================================
   REMOVE PREVIEW
   ========================================================= */

function removePreviewImage(button) {

    const item =
        button.closest(
            ".pl-upload-preview-item"
        );

    if (item) {
        item.remove();
    }

}


/* =========================================================
   PREVIEW IMAGE
   ========================================================= */

function updatePreviewImage(files) {

    if (!files || !files.length) {
        return;
    }


    const file = files[0];

    if (!file.type.startsWith("image/")) {
        return;
    }


    const reader =
        new FileReader();


    reader.onload =
        function (event) {

            const preview =
                document.getElementById(
                    "previewImage"
                );

            const modalPreview =
                document.getElementById(
                    "modalPreviewImage"
                );


            if (preview) {

                preview.innerHTML =
                    `<img src="${event.target.result}"
                          alt="Preview image">`;

            }


            if (modalPreview) {

                modalPreview.innerHTML =
                    `<img src="${event.target.result}"
                          alt="Preview image">`;

            }

        };


    reader.readAsDataURL(file);

}


/* =========================================================
   LIVE PREVIEW
   ========================================================= */

function updatePreview() {

    const title =
        document.querySelector(
            '[name="title"]'
        );

    const shortDescription =
        document.querySelector(
            '[name="short_description"]'
        );

    const date =
        document.querySelector(
            '[name="event_date"]'
        );

    const location =
        document.querySelector(
            '[name="event_location"]'
        );

    const type =
        document.querySelector(
            'input[name="post_type"]:checked'
        );

    const visibility =
        document.querySelector(
            'input[name="visibility_option"]:checked'
        );


    const titleValue =
        title && title.value.trim()
            ? title.value.trim()
            : "Your post title will appear here";


    const descriptionValue =
        shortDescription &&
        shortDescription.value.trim()
            ? shortDescription.value.trim()
            : "Your short description will appear here";


    const dateValue =
        date && date.value
            ? formatDate(date.value)
            : "Date";


    const locationValue =
        location && location.value.trim()
            ? location.value.trim()
            : "Location";


    const typeValue =
        type
            ? type.value
            : "Event";


    const visibilityValue =
        visibility
            ? visibility.value
            : "Community";


    setText(
        "previewTitle",
        titleValue
    );

    setText(
        "previewDescription",
        descriptionValue
    );

    setText(
        "previewDate",
        dateValue
    );

    setText(
        "previewLocation",
        locationValue
    );

    setText(
        "previewType",
        typeValue
    );

    setText(
        "previewVisibility",
        visibilityValue
    );


    setText(
        "modalPreviewTitle",
        titleValue
    );

    setText(
        "modalPreviewDescription",
        descriptionValue
    );

    setText(
        "modalPreviewDate",
        dateValue
    );

    setText(
        "modalPreviewLocation",
        locationValue
    );

    setText(
        "modalPreviewType",
        typeValue
    );

    setText(
        "modalPreviewVisibility",
        visibilityValue
    );

}


/* =========================================================
   SET TEXT
   ========================================================= */

function setText(id, value) {

    const element =
        document.getElementById(id);

    if (element) {
        element.textContent = value;
    }

}


/* =========================================================
   DATE FORMAT
   ========================================================= */

function formatDate(dateString) {

    if (!dateString) {
        return "Date";
    }


    const date =
        new Date(
            dateString + "T00:00:00"
        );


    if (isNaN(date.getTime())) {
        return dateString;
    }


    return date.toLocaleDateString(
        "en-IN",
        {
            day: "2-digit",
            month: "short",
            year: "numeric"
        }
    );

}


/* =========================================================
   PREVIEW MODAL
   ========================================================= */

function openPreview() {

    updatePreview();

    openPostModal(
        "previewModal"
    );

}


/* =========================================================
   MODAL
   ========================================================= */

function openPostModal(id) {

    const modal =
        document.getElementById(id);

    if (!modal) return;

    modal.classList.add("show");

    document.body.style.overflow =
        "hidden";

}


function closePostModal(id) {

    const modal =
        document.getElementById(id);

    if (!modal) return;

    modal.classList.remove("show");

    document.body.style.overflow =
        "";

}


/* =========================================================
   PACKAGES
   ========================================================= */

function openPackages() {

    openPostModal(
        "packageModal"
    );

}


function selectPackageFromModal() {

    const packageSelect =
        document.getElementById(
            "advertisementPackage"
        );


    if (packageSelect) {

        packageSelect.selectedIndex =
            1;

    }


    closePostModal(
        "packageModal"
    );


    showPostToast(
        "Advertisement package selected."
    );

}


/* =========================================================
   MY POSTS
   ========================================================= */

function openMyPosts() {

    /*
     * Production:
     *
     * window.location.href =
     * "my-events-ads.php";
     */

    showPostToast(
        "Opening My Events & Ads..."
    );

}


/* =========================================================
   FORM VALIDATION
   ========================================================= */

function validatePostForm() {

    const selectedType =
        document.querySelector(
            'input[name="post_type"]:checked'
        );


    if (!selectedType) {

        showPostToast(
            "Please select Event or Advertisement."
        );

        return false;

    }


    const visibility =
        document.getElementById(
            "visibility"
        );


    if (
        visibility &&
        visibility.value === "Community"
    ) {

        const community =
            document.getElementById(
                "community"
            );


        if (
            !community ||
            !community.value
        ) {

            showPostToast(
                "Please select a community."
            );

            community?.focus();

            return false;

        }

    }


    const title =
        document.querySelector(
            '[name="title"]'
        );


    if (
        !title ||
        !title.value.trim()
    ) {

        showPostToast(
            "Please enter a title."
        );

        title?.focus();

        return false;

    }


    return true;

}


/* =========================================================
   SCROLL TO FORM
   ========================================================= */

function scrollToForm() {

    const form =
        document.querySelector(
            ".pl-post-form-wrapper"
        );


    if (!form) return;


    form.scrollIntoView({
        behavior: "smooth",
        block: "start"
    });

}


/* =========================================================
   TOAST
   ========================================================= */

let postToastTimer = null;


function showPostToast(message) {

    const toast =
        document.getElementById(
            "postToast"
        );

    const text =
        document.getElementById(
            "postToastMessage"
        );


    if (!toast || !text) return;


    text.textContent =
        message;


    toast.classList.add(
        "show"
    );


    clearTimeout(
        postToastTimer
    );


    postToastTimer =
        setTimeout(function () {

            toast.classList.remove(
                "show"
            );

        }, 3000);

}





document.addEventListener("DOMContentLoaded", function () {

    /* Smooth scrolling */
    document.querySelectorAll(
        '.pl-coming-page a[href^="#"]'
    ).forEach(function (link) {

        link.addEventListener("click", function (e) {

            const targetId = this.getAttribute("href");

            if (!targetId || targetId === "#") {
                return;
            }

            const target = document.querySelector(targetId);

            if (target) {

                e.preventDefault();

                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });

            }

        });

    });


    /* Simple reveal animation */
    const revealItems = document.querySelectorAll(
        ".pl-feature-item, .pl-identity-box, .pl-app-box"
    );

    if ("IntersectionObserver" in window) {

        const observer = new IntersectionObserver(
            function (entries) {

                entries.forEach(function (entry) {

                    if (entry.isIntersecting) {

                        entry.target.classList.add("pl-visible");

                        observer.unobserve(entry.target);

                    }

                });

            },
            {
                threshold: 0.08
            }
        );

        revealItems.forEach(function (item) {
            observer.observe(item);
        });

    }

});

 





document.addEventListener("DOMContentLoaded", function () {

    const page = document.querySelector(".pl-marketplace-page");

    if (!page) {
        return;
    }

    const searchForm = page.querySelector("#plMarketplaceSearch");
    const keywordInput = page.querySelector("#plMarketplaceKeyword");
    const locationInput = page.querySelector("#plMarketplaceLocation");
    const typeSelect = page.querySelector("#plMarketplaceType");
    const visibilitySelect = page.querySelector("#plMarketplaceVisibility");

    const listings = Array.from(
        page.querySelectorAll(".pl-marketplace-listing")
    );

    const categoryButtons = Array.from(
        page.querySelectorAll(".pl-marketplace-category")
    );

    const countElement = page.querySelector("#plMarketplaceCount");
    const noResults = page.querySelector("#plMarketplaceNoResults");
    const resetButton = page.querySelector("#plMarketplaceReset");
    const clearResults = page.querySelector("#plMarketplaceClearResults");

    const toast = page.querySelector("#plMarketplaceToast");
    const toastText = page.querySelector("#plMarketplaceToastText");

    const modal = page.querySelector("#plMarketplaceModal");
    const modalTitle = page.querySelector("#plMarketplaceModalTitle");
    const modalClose = page.querySelector("#plMarketplaceModalClose");

    let selectedCategory = "all";
    let toastTimer = null;


    /* =====================================================
       TOAST
    ===================================================== */

    function showToast(message) {

        if (!toast || !toastText) {
            return;
        }

        toastText.textContent = message;

        toast.classList.add("show");

        clearTimeout(toastTimer);

        toastTimer = setTimeout(function () {
            toast.classList.remove("show");
        }, 2600);
    }


    /* =====================================================
       FILTER LISTINGS
    ===================================================== */

    function filterListings() {

        const keyword = keywordInput
            ? keywordInput.value.trim().toLowerCase()
            : "";

        const location = locationInput
            ? locationInput.value.trim().toLowerCase()
            : "";

        const selectedType = typeSelect
            ? typeSelect.value.toLowerCase()
            : "all";

        const visibility = visibilitySelect
            ? visibilitySelect.value.toLowerCase()
            : "all";

        let visibleCount = 0;

        listings.forEach(function (listing) {

            const category =
                (listing.dataset.category || "").toLowerCase();

            const listingLocation =
                (listing.dataset.location || "").toLowerCase();

            const title =
                (listing.dataset.title || "").toLowerCase();

            const listingVisibility =
                (listing.dataset.visibility || "").toLowerCase();

            const matchesCategory =
                selectedCategory === "all" ||
                category === selectedCategory;

            const matchesType =
                selectedType === "all" ||
                category === selectedType;

            const matchesVisibility =
                visibility === "all" ||
                listingVisibility === visibility;

            const matchesKeyword =
                keyword === "" ||
                title.includes(keyword) ||
                category.includes(keyword) ||
                listingLocation.includes(keyword);

            const matchesLocation =
                location === "" ||
                listingLocation.includes(location);

            const visible =
                matchesCategory &&
                matchesType &&
                matchesVisibility &&
                matchesKeyword &&
                matchesLocation;

            if (visible) {
                listing.style.display = "";
                visibleCount++;
            } else {
                listing.style.display = "none";
            }
        });

        if (countElement) {
            countElement.textContent = visibleCount;
        }

        if (noResults) {
            noResults.classList.toggle(
                "show",
                visibleCount === 0
            );
        }
    }


    /* =====================================================
       CATEGORY BUTTONS
    ===================================================== */

    categoryButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            categoryButtons.forEach(function (item) {
                item.classList.remove("active");
            });

            button.classList.add("active");

            selectedCategory =
                button.dataset.category || "all";

            if (typeSelect) {
                typeSelect.value =
                    ["property", "vehicle", "product"].includes(selectedCategory)
                        ? selectedCategory
                        : "all";
            }

            filterListings();

            const listingSection =
                page.querySelector("#pl-marketplace-listings");

            if (listingSection) {
                listingSection.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        });
    });


    /* =====================================================
       SEARCH
    ===================================================== */

    if (searchForm) {

        searchForm.addEventListener("submit", function (event) {

            event.preventDefault();

            filterListings();

            const listingSection =
                page.querySelector("#pl-marketplace-listings");

            if (listingSection) {
                listingSection.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }

            showToast("Marketplace search updated.");
        });
    }


    /* =====================================================
       LIVE SEARCH
    ===================================================== */

    if (keywordInput) {
        keywordInput.addEventListener("input", filterListings);
    }

    if (locationInput) {
        locationInput.addEventListener("input", filterListings);
    }

    if (typeSelect) {
        typeSelect.addEventListener("change", function () {

            const value = typeSelect.value;

            selectedCategory = value;

            categoryButtons.forEach(function (button) {
                button.classList.toggle(
                    "active",
                    button.dataset.category === value
                );
            });

            if (value === "all") {
                categoryButtons.forEach(function (button) {

                    button.classList.toggle(
                        "active",
                        button.dataset.category === "all"
                    );
                });
            }

            filterListings();
        });
    }

    if (visibilitySelect) {
        visibilitySelect.addEventListener(
            "change",
            filterListings
        );
    }


    /* =====================================================
       RESET
    ===================================================== */

    function resetFilters() {

        if (keywordInput) {
            keywordInput.value = "";
        }

        if (locationInput) {
            locationInput.value = "";
        }

        if (typeSelect) {
            typeSelect.value = "all";
        }

        if (visibilitySelect) {
            visibilitySelect.value = "all";
        }

        selectedCategory = "all";

        categoryButtons.forEach(function (button) {

            button.classList.toggle(
                "active",
                button.dataset.category === "all"
            );
        });

        filterListings();

        showToast("Marketplace filters cleared.");
    }

    if (resetButton) {
        resetButton.addEventListener("click", resetFilters);
    }

    if (clearResults) {
        clearResults.addEventListener("click", resetFilters);
    }


    /* =====================================================
       SAVE LISTINGS
    ===================================================== */

    page.querySelectorAll(".pl-marketplace-save").forEach(
        function (button) {

            button.addEventListener("click", function () {

                const saved =
                    button.classList.toggle("saved");

                const icon =
                    button.querySelector("i");

                if (icon) {

                    icon.className = saved
                        ? "bi bi-heart-fill"
                        : "bi bi-heart";
                }

                showToast(
                    saved
                        ? "Listing saved."
                        : "Listing removed from saved listings."
                );
            });
        }
    );


    /* =====================================================
       VIEW DETAILS
    ===================================================== */

    page.querySelectorAll(".pl-marketplace-view").forEach(
        function (button) {

            button.addEventListener("click", function () {

                const title =
                    button.dataset.title ||
                    "Marketplace Listing";

                if (modalTitle) {
                    modalTitle.textContent = title;
                }

                if (modal) {
                    modal.classList.add("show");
                    document.body.style.overflow = "hidden";
                }
            });
        }
    );


    /* =====================================================
       CLOSE MODAL
    ===================================================== */

    function closeModal() {

        if (modal) {
            modal.classList.remove("show");
            document.body.style.overflow = "";
        }
    }

    if (modalClose) {
        modalClose.addEventListener(
            "click",
            closeModal
        );
    }

    const modalOverlay =
        page.querySelector(".pl-marketplace-modal-overlay");

    if (modalOverlay) {
        modalOverlay.addEventListener(
            "click",
            closeModal
        );
    }

    document.addEventListener("keydown", function (event) {

        if (
            event.key === "Escape" &&
            modal &&
            modal.classList.contains("show")
        ) {
            closeModal();
        }
    });


    /* =====================================================
       FILTER LINKS
    ===================================================== */

    page.querySelectorAll("[data-filter-link]").forEach(
        function (link) {

            link.addEventListener("click", function (event) {

                event.preventDefault();

                const category =
                    link.dataset.filterLink || "all";

                selectedCategory = category;

                categoryButtons.forEach(function (button) {

                    button.classList.toggle(
                        "active",
                        button.dataset.category === category
                    );
                });

                if (typeSelect) {
                    typeSelect.value =
                        ["property", "vehicle", "product"].includes(category)
                            ? category
                            : "all";
                }

                filterListings();

                const listingSection =
                    page.querySelector("#pl-marketplace-listings");

                if (listingSection) {
                    listingSection.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                }
            });
        }
    );


    /* =====================================================
       VISIBILITY LINKS
    ===================================================== */

    page.querySelectorAll("[data-visibility-link]").forEach(
        function (button) {

            button.addEventListener("click", function () {

                const visibility =
                    button.dataset.visibilityLink;

                if (visibilitySelect) {
                    visibilitySelect.value = visibility;
                }

                filterListings();

                const listingSection =
                    page.querySelector("#pl-marketplace-listings");

                if (listingSection) {
                    listingSection.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                }

                showToast(
                    visibility === "community"
                        ? "Showing community listings."
                        : "Showing global listings."
                );
            });
        }
    );


    /* =====================================================
       ACTION BUTTONS
    ===================================================== */

    page.querySelectorAll("[data-action]").forEach(
        function (button) {

            button.addEventListener("click", function () {

                const action =
                    button.dataset.action;

                switch (action) {

                    case "enquiry":
                        showToast(
                            "Seller enquiry option selected."
                        );
                        break;

                    case "saved":
                        showToast(
                            "Your saved listings will appear here."
                        );
                        break;

                    case "post":
                        const postSection =
                            page.querySelector("#pl-post-listing");

                        if (postSection) {
                            postSection.scrollIntoView({
                                behavior: "smooth",
                                block: "center"
                            });
                        }

                        showToast(
                            "Ready to create a new listing."
                        );
                        break;

                    case "approval":
                        showToast(
                            "Listings are reviewed before approval."
                        );
                        break;

                    case "report":
                        showToast(
                            "Listing report option selected."
                        );
                        break;

                    case "similar":
                        showToast(
                            "Finding similar marketplace listings."
                        );
                        break;

                    default:
                        showToast(
                            "Action selected."
                        );
                }
            });
        }
    );


    /* =====================================================
       INITIAL STATE
    ===================================================== */

    filterListings();

});





document.addEventListener("DOMContentLoaded", function () {

    const page = document.querySelector(".pl-property-page");

    if (!page) return;


    /* =====================================================
       TOAST
    ===================================================== */

    const toast = page.querySelector("#plPropertyToast");
    const toastText = page.querySelector("#plPropertyToastText");

    let toastTimer;

    function showToast(message) {

        if (!toast || !toastText) return;

        toastText.textContent = message;

        toast.classList.add("show");

        clearTimeout(toastTimer);

        toastTimer = setTimeout(function () {
            toast.classList.remove("show");
        }, 2600);
    }


    /* =====================================================
       SAVE PROPERTY
    ===================================================== */

    const saveButtons =
        page.querySelectorAll('[data-action="save"]');

    saveButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            const isSaved =
                button.classList.toggle("saved");

            const icon =
                button.querySelector("i");

            if (icon) {
                icon.className =
                    isSaved
                        ? "bi bi-heart-fill"
                        : "bi bi-heart";
            }

            const text =
                button.querySelector("span");

            if (text) {
                text.textContent =
                    isSaved
                        ? "Saved Property"
                        : "Save Property";
            }

            showToast(
                isSaved
                    ? "Property saved successfully."
                    : "Property removed from saved listings."
            );

            saveButtons.forEach(function (otherButton) {

                if (otherButton !== button) {

                    otherButton.classList.toggle(
                        "saved",
                        isSaved
                    );

                    const otherIcon =
                        otherButton.querySelector("i");

                    if (otherIcon) {
                        otherIcon.className =
                            isSaved
                                ? "bi bi-heart-fill"
                                : "bi bi-heart";
                    }

                    const otherText =
                        otherButton.querySelector("span");

                    if (otherText) {
                        otherText.textContent =
                            isSaved
                                ? "Saved Property"
                                : "Save Property";
                    }
                }
            });
        });
    });


    /* =====================================================
       GENERAL ACTIONS
    ===================================================== */

    page.querySelectorAll("[data-action]").forEach(function (button) {

        button.addEventListener("click", function () {

            const action = button.dataset.action;

            if (
                action === "save" ||
                action === "gallery"
            ) {
                return;
            }

            switch (action) {

                case "contact":
                    showToast(
                        "Seller contact option selected."
                    );
                    break;

                case "enquiry":
                    const enquiry =
                        page.querySelector(
                            ".pl-property-enquiry-section"
                        );

                    if (enquiry) {
                        enquiry.scrollIntoView({
                            behavior: "smooth",
                            block: "center"
                        });
                    }

                    showToast(
                        "Property enquiry form opened."
                    );
                    break;

                case "map":
                    showToast(
                        "Map location option selected."
                    );
                    break;

                case "directions":
                    showToast(
                        "Directions option selected."
                    );
                    break;

                case "share":

                    if (navigator.share) {

                        navigator.share({
                            title:
                                "Premium 3 BHK Family Apartment",
                            text:
                                "Property listing on PeopleLink",
                            url:
                                window.location.href
                        }).catch(function () {});

                    } else {

                        navigator.clipboard.writeText(
                            window.location.href
                        ).then(function () {

                            showToast(
                                "Property link copied."
                            );

                        }).catch(function () {

                            showToast(
                                "Share option selected."
                            );

                        });
                    }

                    break;

                case "report":
                    showToast(
                        "Property report option selected."
                    );
                    break;

                case "similar":
                    showToast(
                        "Showing similar properties."
                    );
                    break;

                default:
                    break;
            }
        });
    });


    /* =====================================================
       CONTACT OPTIONS
    ===================================================== */

    page.querySelectorAll("[data-contact]").forEach(function (button) {

        button.addEventListener("click", function () {

            const contactType =
                button.dataset.contact;

            const messages = {
                call: "Call seller option selected.",
                whatsapp: "WhatsApp seller option selected.",
                email: "Email seller option selected.",
                enquiry: "Property enquiry option selected."
            };

            showToast(
                messages[contactType] ||
                "Contact option selected."
            );
        });
    });


    /* =====================================================
       ENQUIRY FORM
    ===================================================== */

    const enquiryForm =
        page.querySelector("#plPropertyEnquiryForm");

    if (enquiryForm) {

        enquiryForm.addEventListener("submit", function (event) {

            event.preventDefault();

            showToast(
                "Your property enquiry has been prepared successfully."
            );

            enquiryForm.reset();
        });
    }


    /* =====================================================
       PROPERTY GALLERY
    ===================================================== */

    const galleryImages = [
        "https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1200&q=85",
        "https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=1200&q=85",
        "https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=85",
        "https://images.unsplash.com/photo-1600607688969-a5bfcd646154?auto=format&fit=crop&w=1200&q=85"
    ];

    let currentImage = 0;

    const mainImage =
        page.querySelector("#plPropertyMainImage");

    const modal =
        page.querySelector("#plPropertyGalleryModal");

    const modalImage =
        page.querySelector("#plPropertyModalImage");

    const modalCount =
        page.querySelector("#plPropertyModalCount");

    const photoCount =
        page.querySelector("#plPropertyPhotoCount");


    function updateMainImage() {

        if (!mainImage) return;

        mainImage.src =
            galleryImages[currentImage];
    }


    function updateModalImage() {

        if (!modalImage) return;

        modalImage.src =
            galleryImages[currentImage];

        if (modalCount) {
            modalCount.textContent =
                (currentImage + 1) +
                " / " +
                galleryImages.length;
        }
    }


    function openGallery(index) {

        currentImage =
            typeof index === "number"
                ? index
                : 0;

        updateModalImage();

        if (modal) {
            modal.classList.add("show");
            document.body.style.overflow = "hidden";
        }
    }


    function closeGallery() {

        if (modal) {
            modal.classList.remove("show");
            document.body.style.overflow = "";
        }
    }


    page.querySelectorAll(
        ".pl-property-gallery-item"
    ).forEach(function (item, index) {

        item.addEventListener("click", function () {

            const image =
                item.dataset.image;

            const imageIndex =
                galleryImages.indexOf(image);

            openGallery(
                imageIndex >= 0
                    ? imageIndex
                    : index
            );
        });
    });


    page.querySelectorAll(
        '[data-action="gallery"]'
    ).forEach(function (button) {

        button.addEventListener("click", function () {
            openGallery(0);
        });
    });


    const nextButton =
        page.querySelector("[data-gallery-next]");

    const previousButton =
        page.querySelector("[data-gallery-prev]");


    if (nextButton) {

        nextButton.addEventListener("click", function () {

            currentImage =
                (currentImage + 1) %
                galleryImages.length;

            updateMainImage();
        });
    }


    if (previousButton) {

        previousButton.addEventListener("click", function () {

            currentImage =
                (currentImage - 1 +
                galleryImages.length) %
                galleryImages.length;

            updateMainImage();
        });
    }


    const modalNext =
        page.querySelector("[data-modal-next]");

    const modalPrevious =
        page.querySelector("[data-modal-prev]");


    if (modalNext) {

        modalNext.addEventListener("click", function () {

            currentImage =
                (currentImage + 1) %
                galleryImages.length;

            updateModalImage();
        });
    }


    if (modalPrevious) {

        modalPrevious.addEventListener("click", function () {

            currentImage =
                (currentImage - 1 +
                galleryImages.length) %
                galleryImages.length;

            updateModalImage();
        });
    }


    const galleryClose =
        page.querySelector("#plPropertyGalleryClose");

    if (galleryClose) {
        galleryClose.addEventListener(
            "click",
            closeGallery
        );
    }


    const galleryOverlay =
        page.querySelector(".pl-property-gallery-overlay");

    if (galleryOverlay) {
        galleryOverlay.addEventListener(
            "click",
            closeGallery
        );
    }


    document.addEventListener("keydown", function (event) {

        if (
            event.key === "Escape" &&
            modal &&
            modal.classList.contains("show")
        ) {
            closeGallery();
        }

        if (
            event.key === "ArrowRight" &&
            modal &&
            modal.classList.contains("show")
        ) {
            currentImage =
                (currentImage + 1) %
                galleryImages.length;

            updateModalImage();
        }

        if (
            event.key === "ArrowLeft" &&
            modal &&
            modal.classList.contains("show")
        ) {
            currentImage =
                (currentImage - 1 +
                galleryImages.length) %
                galleryImages.length;

            updateModalImage();
        }
    });


    if (photoCount) {
        photoCount.textContent =
            galleryImages.length + " Photos";
    }

});






document.addEventListener("DOMContentLoaded", function () {

    const page = document.querySelector(".pl-car-form-page");

    if (!page) return;


    /* =====================================================
       ELEMENTS
    ===================================================== */

    const form = page.querySelector("#carListingForm");
    const imageInput = page.querySelector("#carImages");
    const uploadArea = page.querySelector("#uploadArea");
    const browseImages = page.querySelector("#browseImages");
    const imagePreview = page.querySelector("#imagePreview");

    const description = page.querySelector("#carDescription");
    const descriptionCount = page.querySelector("#descriptionCount");

    const carPrice = page.querySelector("#carPrice");
    const pricePreview = page.querySelector("#pricePreview");

    const previewModal = page.querySelector("#previewModal");
    const previewListing = page.querySelector("#previewListing");
    const closePreview = page.querySelector("#closePreview");

    const saveDraft = page.querySelector("#saveDraft");

    const toast = page.querySelector("#carToast");
    const toastTitle = page.querySelector("#toastTitle");
    const toastMessage = page.querySelector("#toastMessage");
    const closeToast = page.querySelector("#closeToast");

    let selectedFiles = [];
    let toastTimer;


    /* =====================================================
       TOAST
    ===================================================== */

    function showToast(title, message) {

        toastTitle.textContent = title;
        toastMessage.textContent = message;

        toast.classList.add("show");

        clearTimeout(toastTimer);

        toastTimer = setTimeout(function () {
            toast.classList.remove("show");
        }, 3500);
    }

    closeToast.addEventListener("click", function () {
        toast.classList.remove("show");
    });


    /* =====================================================
       IMAGE UPLOAD
    ===================================================== */

    browseImages.addEventListener("click", function () {
        imageInput.click();
    });

    uploadArea.addEventListener("click", function (event) {

        if (
            event.target.closest(".pl-car-upload-btn") ||
            event.target === imageInput
        ) {
            return;
        }

        imageInput.click();
    });


    imageInput.addEventListener("change", function () {

        const files = Array.from(this.files);

        addFiles(files);

        this.value = "";
    });


    function addFiles(files) {

        files.forEach(function (file) {

            if (!file.type.startsWith("image/")) {
                showToast("Invalid File", "Please select image files only.");
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                showToast(
                    "Image Too Large",
                    file.name + " is larger than 5 MB."
                );
                return;
            }

            selectedFiles.push(file);
        });

        renderImages();
    }


    function renderImages() {

        imagePreview.innerHTML = "";

        selectedFiles.forEach(function (file, index) {

            const reader = new FileReader();

            reader.onload = function (event) {

                const item = document.createElement("div");

                item.className = "pl-car-image-item";

                item.innerHTML = `
                    <img src="${event.target.result}" alt="Car Image">
                    <button
                        type="button"
                        class="pl-car-image-remove"
                        data-index="${index}"
                        title="Remove image"
                    >
                        <i class="bi bi-x-lg"></i>
                    </button>
                `;

                imagePreview.appendChild(item);
            };

            reader.readAsDataURL(file);
        });
    }


    imagePreview.addEventListener("click", function (event) {

        const removeButton = event.target.closest(".pl-car-image-remove");

        if (!removeButton) return;

        const index = Number(removeButton.dataset.index);

        selectedFiles.splice(index, 1);

        renderImages();

        showToast(
            "Image Removed",
            "The selected image has been removed."
        );
    });


    /* =====================================================
       DRAG & DROP
    ===================================================== */

    ["dragenter", "dragover"].forEach(function (eventName) {

        uploadArea.addEventListener(eventName, function (event) {

            event.preventDefault();
            event.stopPropagation();

            uploadArea.classList.add("dragover");
        });

    });


    ["dragleave", "drop"].forEach(function (eventName) {

        uploadArea.addEventListener(eventName, function (event) {

            event.preventDefault();
            event.stopPropagation();

            uploadArea.classList.remove("dragover");
        });

    });


    uploadArea.addEventListener("drop", function (event) {

        const files = Array.from(event.dataTransfer.files);

        addFiles(files);
    });


    /* =====================================================
       DESCRIPTION COUNTER
    ===================================================== */

    description.addEventListener("input", function () {

        descriptionCount.textContent = this.value.length;
    });


    /* =====================================================
       PRICE FORMAT
    ===================================================== */

    carPrice.addEventListener("input", function () {

        const value = Number(this.value);

        if (!value) {
            pricePreview.textContent = "";
            return;
        }

        pricePreview.textContent =
            "Approx. ₹" + value.toLocaleString("en-IN");
    });


    /* =====================================================
       VISIBILITY
    ===================================================== */

    const visibilityOptions =
        page.querySelectorAll(".pl-car-visibility-option");

    visibilityOptions.forEach(function (option) {

        option.addEventListener("click", function () {

            visibilityOptions.forEach(function (item) {
                item.classList.remove("active");
            });

            option.classList.add("active");

            const radio = option.querySelector("input");

            if (radio) {
                radio.checked = true;
            }
        });

    });


    /* =====================================================
       FORM DATA HELPER
    ===================================================== */

    function getValue(name) {

        const field = form.querySelector(`[name="${name}"]`);

        return field ? field.value.trim() : "";
    }


    /* =====================================================
       PREVIEW
    ===================================================== */

    previewListing.addEventListener("click", function () {

        const brand = getValue("brand");
        const model = getValue("model");
        const variant = getValue("variant");
        const year = getValue("manufacturing_year");
        const price = getValue("price");
        const km = getValue("kilometres");
        const fuel = getValue("fuel_type");
        const transmission = getValue("transmission");
        const city = getValue("city");
        const state = getValue("state");
        const desc = getValue("description");

        const title =
            [brand, model, variant]
                .filter(Boolean)
                .join(" ");

        page.querySelector("#previewTitle").textContent =
            title || "Your Car";

        page.querySelector("#previewPrice").textContent =
            price
                ? "₹" + Number(price).toLocaleString("en-IN")
                : "₹0";

        page.querySelector("#previewYear").textContent =
            year || "-";

        page.querySelector("#previewKm").textContent =
            km ? Number(km).toLocaleString("en-IN") : "-";

        page.querySelector("#previewFuel").textContent =
            fuel || "-";

        page.querySelector("#previewTransmission").textContent =
            transmission || "-";

        page.querySelector("#previewLocation").textContent =
            [city, state]
                .filter(Boolean)
                .join(", ") || "Location not provided";

        page.querySelector("#previewDescription").textContent =
            desc ||
            "Your car description will appear here.";

        updatePreviewImage();

        previewModal.classList.add("show");

        document.body.style.overflow = "hidden";
    });


    function updatePreviewImage() {

        const previewImage =
            page.querySelector("#previewImage");

        if (!selectedFiles.length) {

            previewImage.innerHTML =
                '<i class="bi bi-car-front"></i>';

            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {

            previewImage.innerHTML =
                `<img src="${event.target.result}" alt="Car">`;
        };

        reader.readAsDataURL(selectedFiles[0]);
    }


    closePreview.addEventListener("click", closePreviewModal);


    previewModal.addEventListener("click", function (event) {

        if (event.target === previewModal) {
            closePreviewModal();
        }
    });


    function closePreviewModal() {

        previewModal.classList.remove("show");

        document.body.style.overflow = "";
    }


    /* =====================================================
       SAVE DRAFT
    ===================================================== */

    saveDraft.addEventListener("click", function () {

        const draftData = {};

        const fields = form.querySelectorAll(
            "input:not([type='file']):not([type='checkbox']), select, textarea"
        );

        fields.forEach(function (field) {

            if (field.name) {
                draftData[field.name] = field.value;
            }
        });

        localStorage.setItem(
            "peoplelink_car_listing_draft",
            JSON.stringify(draftData)
        );

        showToast(
            "Draft Saved",
            "Your car listing has been saved as a draft."
        );
    });


    /* =====================================================
       LOAD DRAFT
    ===================================================== */

    const savedDraft =
        localStorage.getItem("peoplelink_car_listing_draft");

    if (savedDraft) {

        try {

            const draftData = JSON.parse(savedDraft);

            Object.keys(draftData).forEach(function (name) {

                const field =
                    form.querySelector(`[name="${name}"]`);

                if (!field) return;

                if (field.type === "radio") {
                    return;
                }

                field.value = draftData[name];
            });

            descriptionCount.textContent =
                description.value.length;

            if (carPrice.value) {

                pricePreview.textContent =
                    "Approx. ₹" +
                    Number(carPrice.value).toLocaleString("en-IN");
            }

        } catch (error) {

            console.warn("Could not load saved draft.");
        }
    }


    /* =====================================================
       FORM SUBMIT
    ===================================================== */

    form.addEventListener("submit", function (event) {

        event.preventDefault();

        if (!form.checkValidity()) {

            form.reportValidity();

            return;
        }

        if (!selectedFiles.length) {

            showToast(
                "Add Car Images",
                "Please upload at least one car image."
            );

            uploadArea.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });

            return;
        }

        const agreement =
            page.querySelector("#listingAgreement");

        if (!agreement.checked) {

            showToast(
                "Confirmation Required",
                "Please confirm that the listing information is accurate."
            );

            return;
        }


        /*
         * Replace this section with your AJAX/PHP submission.
         *
         * Example:
         *
         * const formData = new FormData(form);
         *
         * selectedFiles.forEach(function(file) {
         *     formData.append("car_images[]", file);
         * });
         *
         * fetch("car-listing-submit.php", {
         *     method: "POST",
         *     body: formData
         * })
         * .then(response => response.json())
         * .then(data => {
         *     ...
         * });
         */

        showToast(
            "Listing Submitted",
            "Your car listing has been submitted for admin approval."
        );

        localStorage.removeItem(
            "peoplelink_car_listing_draft"
        );

        setTimeout(function () {

            form.reset();

            selectedFiles = [];

            imagePreview.innerHTML = "";

            descriptionCount.textContent = "0";

            pricePreview.textContent = "";

            visibilityOptions.forEach(function (option, index) {

                option.classList.toggle("active", index === 0);

                const radio =
                    option.querySelector("input");

                if (radio) {
                    radio.checked = index === 0;
                }
            });

        }, 1200);
    });


    /* =====================================================
       ESC CLOSE MODAL
    ===================================================== */

    document.addEventListener("keydown", function (event) {

        if (event.key === "Escape" &&
            previewModal.classList.contains("show")) {

            closePreviewModal();
        }

    });

});






document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("bikeListingForm");
    if (!form) return; // this block belongs to another page

    const imageInput = document.getElementById("bikeImages");
    const dropZone = document.getElementById("bikeDropZone");
    const previewBox = document.getElementById("bikeImagePreview");

    const description = document.getElementById("bikeDescription");
    const descriptionCount = document.getElementById("bikeDescriptionCount");

    const previewModal = document.getElementById("bikePreviewModal");
    const closePreview = document.getElementById("closeBikePreview");
    const previewButton = document.getElementById("previewBike");

    const saveDraftButton = document.getElementById("saveBikeDraft");

    const toast = document.getElementById("bikeToast");

    let selectedFiles = [];


    /* =========================
       TOAST
       ========================= */

    function showToast(message) {

        const toastText = toast.querySelector("span");

        toastText.textContent = message;

        toast.classList.add("show");

        setTimeout(function () {
            toast.classList.remove("show");
        }, 2800);
    }


    /* =========================
       IMAGE UPLOAD
       ========================= */

    imageInput.addEventListener("change", function () {

        addImages(Array.from(this.files));

    });


    function addImages(files) {

        files.forEach(function (file) {

            if (!file.type.startsWith("image/")) {
                return;
            }

            const exists = selectedFiles.some(function (item) {
                return item.name === file.name &&
                       item.size === file.size;
            });

            if (!exists) {
                selectedFiles.push(file);
            }

        });

        renderImages();
        syncInputFiles();
    }


    function renderImages() {

        previewBox.innerHTML = "";

        selectedFiles.forEach(function (file, index) {

            const reader = new FileReader();

            reader.onload = function (event) {

                const item = document.createElement("div");

                item.className = "pl-bike-image-item";

                item.innerHTML = `
                    <img src="${event.target.result}" alt="Bike Image">

                    <button type="button"
                            class="pl-bike-image-remove"
                            data-index="${index}">
                        <i class="bi bi-x-lg"></i>
                    </button>
                `;

                previewBox.appendChild(item);

            };

            reader.readAsDataURL(file);

        });
    }


    previewBox.addEventListener("click", function (event) {

        const button = event.target.closest(".pl-bike-image-remove");

        if (!button) {
            return;
        }

        const index = Number(button.dataset.index);

        selectedFiles.splice(index, 1);

        renderImages();
        syncInputFiles();

    });


    function syncInputFiles() {

        try {

            const dataTransfer = new DataTransfer();

            selectedFiles.forEach(function (file) {
                dataTransfer.items.add(file);
            });

            imageInput.files = dataTransfer.files;

        } catch (error) {

            console.log("File sync not supported:", error);

        }
    }


    /* =========================
       DRAG & DROP
       ========================= */

    ["dragenter", "dragover"].forEach(function (eventName) {

        dropZone.addEventListener(eventName, function (event) {

            event.preventDefault();
            dropZone.classList.add("dragging");

        });

    });


    ["dragleave", "drop"].forEach(function (eventName) {

        dropZone.addEventListener(eventName, function (event) {

            event.preventDefault();
            dropZone.classList.remove("dragging");

        });

    });


    dropZone.addEventListener("drop", function (event) {

        const files = Array.from(event.dataTransfer.files);

        addImages(files);

    });


    /* =========================
       DESCRIPTION COUNTER
       ========================= */

    description.addEventListener("input", function () {

        descriptionCount.textContent = this.value.length;

    });


    /* =========================
       VISIBILITY
       ========================= */

    const visibilityOptions =
        document.querySelectorAll(".pl-bike-visibility-option");

    visibilityOptions.forEach(function (option) {

        option.addEventListener("click", function () {

            visibilityOptions.forEach(function (item) {
                item.classList.remove("active");
            });

            this.classList.add("active");

            const radio = this.querySelector("input");

            if (radio) {
                radio.checked = true;
            }

        });

    });


    /* =========================
       PREVIEW
       ========================= */

    previewButton.addEventListener("click", function () {

        if (!validateBasicFields()) {
            return;
        }

        updatePreview();

        previewModal.classList.add("show");

    });


    function updatePreview() {

        const brand =
            form.querySelector('[name="brand"]').value || "—";

        const model =
            form.querySelector('[name="model"]').value || "—";

        const price =
            form.querySelector('[name="price"]').value || "—";

        const year =
            form.querySelector('[name="manufacturing_year"]').value || "—";

        const km =
            form.querySelector('[name="kilometres"]').value || "—";

        const fuel =
            form.querySelector('[name="fuel_type"]').value || "—";

        const city =
            form.querySelector('[name="city"]').value || "";

        const state =
            form.querySelector('[name="state"]').value || "";

        const desc =
            form.querySelector('[name="description"]').value || "—";


        document.getElementById("previewBikeTitle").textContent =
            brand + " " + model;

        document.getElementById("previewBrandModel").textContent =
            brand + " " + model;

        document.getElementById("previewPrice").textContent =
            price !== "—"
                ? "₹ " + Number(price).toLocaleString("en-IN")
                : "—";

        document.getElementById("previewYear").textContent =
            year;

        document.getElementById("previewKm").textContent =
            km !== "—"
                ? Number(km).toLocaleString("en-IN") + " km"
                : "—";

        document.getElementById("previewFuel").textContent =
            fuel;

        document.getElementById("previewLocation").textContent =
            city && state
                ? city + ", " + state
                : city || state || "—";

        document.getElementById("previewDescription").textContent =
            desc;


        const previewImage =
            document.getElementById("previewBikeImage");

        previewImage.innerHTML = "";

        if (selectedFiles.length > 0) {

            const reader = new FileReader();

            reader.onload = function (event) {

                previewImage.innerHTML = `
                    <img src="${event.target.result}"
                         alt="Bike Preview">
                `;

            };

            reader.readAsDataURL(selectedFiles[0]);

        } else {

            previewImage.innerHTML = `
                <i class="bi bi-bicycle"></i>
            `;

        }

    }


    function validateBasicFields() {

        const requiredFields =
            form.querySelectorAll("[required]");

        let valid = true;

        requiredFields.forEach(function (field) {

            if (
                field.type === "checkbox" &&
                !field.checked
            ) {
                valid = false;
                return;
            }

            if (
                field.type !== "checkbox" &&
                !field.value.trim()
            ) {
                valid = false;
            }

        });


        if (!valid) {

            showToast(
                "Please complete the required fields first."
            );

            const firstInvalid =
                form.querySelector(
                    ":invalid"
                );

            if (firstInvalid) {
                firstInvalid.focus();
            }

            return false;
        }

        return true;

    }


    /* =========================
       CLOSE PREVIEW
       ========================= */

    closePreview.addEventListener("click", function () {

        previewModal.classList.remove("show");

    });


    previewModal.addEventListener("click", function (event) {

        if (event.target === previewModal) {

            previewModal.classList.remove("show");

        }

    });


    document.addEventListener("keydown", function (event) {

        if (event.key === "Escape") {

            previewModal.classList.remove("show");

        }

    });


    /* =========================
       SAVE DRAFT
       ========================= */

    saveDraftButton.addEventListener("click", function () {

        const formData = {};

        new FormData(form).forEach(function (value, key) {

            if (typeof value === "string") {
                formData[key] = value;
            }

        });

        localStorage.setItem(
            "peoplelink_bike_listing_draft",
            JSON.stringify(formData)
        );

        showToast("Bike listing draft saved.");

    });


    /* =========================
       LOAD DRAFT
       ========================= */

    function loadDraft() {

        const saved =
            localStorage.getItem(
                "peoplelink_bike_listing_draft"
            );

        if (!saved) {
            return;
        }

        try {

            const data = JSON.parse(saved);

            Object.keys(data).forEach(function (key) {

                const field =
                    form.querySelector(
                        `[name="${key}"]`
                    );

                if (!field) {
                    return;
                }

                if (field.type === "radio") {
                    return;
                }

                field.value = data[key];

            });

            descriptionCount.textContent =
                description.value.length;

        } catch (error) {

            console.log("Draft loading error:", error);

        }

    }


    loadDraft();


    /* =========================
       FORM SUBMIT
       ========================= */

    form.addEventListener("submit", function (event) {

        event.preventDefault();

        if (!validateBasicFields()) {
            return;
        }

        showToast(
            "Bike listing submitted for approval."
        );

        /*
         * Connect your PHP/AJAX submission here.
         *
         * Example:
         *
         * const formData = new FormData(form);
         *
         * fetch("bike-listing-submit.php", {
         *     method: "POST",
         *     body: formData
         * })
         * .then(response => response.json())
         * .then(data => {
         *     ...
         * });
         */

    });

});







document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("electronicsListingForm");
    if (!form) return; // this block belongs to another page

    const imageInput = document.getElementById("electronicsImages");
    const dropZone = document.getElementById("electronicsDropZone");
    const previewBox = document.getElementById("electronicsImagePreview");

    const description = document.getElementById("electronicsDescription");
    const descriptionCount = document.getElementById("electronicsDescriptionCount");

    const previewButton = document.getElementById("previewElectronics");
    const previewModal = document.getElementById("electronicsPreviewModal");
    const closePreview = document.getElementById("closeElectronicsPreview");

    const saveDraftButton = document.getElementById("saveElectronicsDraft");
    const toast = document.getElementById("electronicsToast");

    let selectedFiles = [];


    /* =========================
       TOAST
       ========================= */

    function showToast(message) {

        const text = toast.querySelector("span");

        text.textContent = message;

        toast.classList.add("show");

        setTimeout(function () {
            toast.classList.remove("show");
        }, 2800);
    }


    /* =========================
       IMAGE UPLOAD
       ========================= */

    imageInput.addEventListener("change", function () {

        addImages(Array.from(this.files));

    });


    function addImages(files) {

        files.forEach(function (file) {

            if (!file.type.startsWith("image/")) {
                return;
            }

            const exists = selectedFiles.some(function (item) {

                return item.name === file.name &&
                       item.size === file.size;

            });

            if (!exists) {
                selectedFiles.push(file);
            }

        });

        renderImages();
        syncInputFiles();

    }


    function renderImages() {

        previewBox.innerHTML = "";

        selectedFiles.forEach(function (file, index) {

            const reader = new FileReader();

            reader.onload = function (event) {

                const item = document.createElement("div");

                item.className = "pl-electronics-image-item";

                item.innerHTML = `
                    <img src="${event.target.result}"
                         alt="Product Image">

                    <button type="button"
                            class="pl-electronics-image-remove"
                            data-index="${index}">
                        <i class="bi bi-x-lg"></i>
                    </button>
                `;

                previewBox.appendChild(item);

            };

            reader.readAsDataURL(file);

        });

    }


    previewBox.addEventListener("click", function (event) {

        const button =
            event.target.closest(".pl-electronics-image-remove");

        if (!button) {
            return;
        }

        const index = Number(button.dataset.index);

        selectedFiles.splice(index, 1);

        renderImages();
        syncInputFiles();

    });


    function syncInputFiles() {

        try {

            const dataTransfer = new DataTransfer();

            selectedFiles.forEach(function (file) {

                dataTransfer.items.add(file);

            });

            imageInput.files = dataTransfer.files;

        } catch (error) {

            console.log(
                "File sync is not supported:",
                error
            );

        }

    }


    /* =========================
       DRAG & DROP
       ========================= */

    ["dragenter", "dragover"].forEach(function (eventName) {

        dropZone.addEventListener(eventName, function (event) {

            event.preventDefault();

            dropZone.classList.add("dragging");

        });

    });


    ["dragleave", "drop"].forEach(function (eventName) {

        dropZone.addEventListener(eventName, function (event) {

            event.preventDefault();

            dropZone.classList.remove("dragging");

        });

    });


    dropZone.addEventListener("drop", function (event) {

        const files =
            Array.from(event.dataTransfer.files);

        addImages(files);

    });


    /* =========================
       DESCRIPTION COUNTER
       ========================= */

    description.addEventListener("input", function () {

        descriptionCount.textContent =
            this.value.length;

    });


    /* =========================
       CONDITION SELECTOR
       ========================= */

    const conditionOptions =
        document.querySelectorAll(
            ".pl-electronics-condition-option"
        );

    conditionOptions.forEach(function (option) {

        option.addEventListener("click", function () {

            conditionOptions.forEach(function (item) {

                item.classList.remove("selected");

            });

            this.classList.add("selected");

            const radio =
                this.querySelector("input");

            if (radio) {
                radio.checked = true;
            }

        });

    });


    /* =========================
       VISIBILITY
       ========================= */

    const visibilityOptions =
        document.querySelectorAll(
            ".pl-electronics-visibility-option"
        );

    visibilityOptions.forEach(function (option) {

        option.addEventListener("click", function () {

            visibilityOptions.forEach(function (item) {

                item.classList.remove("active");

            });

            this.classList.add("active");

            const radio =
                this.querySelector("input");

            if (radio) {
                radio.checked = true;
            }

        });

    });


    /* =========================
       VALIDATION
       ========================= */

    function validateForm() {

        if (!form.checkValidity()) {

            form.reportValidity();

            showToast(
                "Please complete the required fields."
            );

            return false;
        }

        return true;
    }


    /* =========================
       PREVIEW
       ========================= */

    previewButton.addEventListener("click", function () {

        if (!validateForm()) {
            return;
        }

        updatePreview();

        previewModal.classList.add("show");

    });


    function updatePreview() {

        const productName =
            form.querySelector('[name="product_name"]').value || "—";

        const category =
            form.querySelector('[name="category"]').value || "—";

        const brand =
            form.querySelector('[name="brand"]').value || "—";

        const model =
            form.querySelector('[name="model"]').value || "—";

        const price =
            form.querySelector('[name="price"]').value || "—";

        const city =
            form.querySelector('[name="city"]').value || "";

        const state =
            form.querySelector('[name="state"]').value || "";

        const descriptionValue =
            form.querySelector('[name="description"]').value || "—";

        const condition =
            form.querySelector(
                '[name="condition"]:checked'
            );


        document.getElementById(
            "previewElectronicsTitle"
        ).textContent = productName;


        document.getElementById(
            "previewProductName"
        ).textContent = productName;


        document.getElementById(
            "previewBrandModel"
        ).textContent =
            brand + " / " + model;


        document.getElementById(
            "previewCondition"
        ).textContent =
            condition ? condition.value : "—";


        document.getElementById(
            "previewPrice"
        ).textContent =
            price !== "—"
                ? "₹ " + Number(price).toLocaleString("en-IN")
                : "—";


        document.getElementById(
            "previewCategory"
        ).textContent = category;


        document.getElementById(
            "previewLocation"
        ).textContent =
            city && state
                ? city + ", " + state
                : city || state || "—";


        document.getElementById(
            "previewDescription"
        ).textContent =
            descriptionValue;


        const previewImage =
            document.getElementById(
                "previewElectronicsImage"
            );

        previewImage.innerHTML = "";


        if (selectedFiles.length > 0) {

            const reader =
                new FileReader();

            reader.onload = function (event) {

                previewImage.innerHTML = `
                    <img src="${event.target.result}"
                         alt="Product Preview">
                `;

            };

            reader.readAsDataURL(
                selectedFiles[0]
            );

        } else {

            previewImage.innerHTML = `
                <i class="bi bi-cpu-fill"></i>
            `;

        }

    }


    /* =========================
       CLOSE PREVIEW
       ========================= */

    closePreview.addEventListener("click", function () {

        previewModal.classList.remove("show");

    });


    previewModal.addEventListener("click", function (event) {

        if (event.target === previewModal) {

            previewModal.classList.remove("show");

        }

    });


    document.addEventListener("keydown", function (event) {

        if (event.key === "Escape") {

            previewModal.classList.remove("show");

        }

    });


    /* =========================
       SAVE DRAFT
       ========================= */

    saveDraftButton.addEventListener("click", function () {

        const data = {};

        new FormData(form).forEach(function (value, key) {

            if (typeof value === "string") {

                data[key] = value;

            }

        });


        const condition =
            form.querySelector(
                '[name="condition"]:checked'
            );

        if (condition) {
            data.condition = condition.value;
        }


        localStorage.setItem(
            "peoplelink_electronics_listing_draft",
            JSON.stringify(data)
        );


        showToast(
            "Electronics listing draft saved."
        );

    });


    /* =========================
       LOAD DRAFT
       ========================= */

    function loadDraft() {

        const saved =
            localStorage.getItem(
                "peoplelink_electronics_listing_draft"
            );

        if (!saved) {
            return;
        }

        try {

            const data =
                JSON.parse(saved);


            Object.keys(data).forEach(function (key) {

                const field =
                    form.querySelector(
                        `[name="${key}"]`
                    );

                if (!field) {
                    return;
                }

                if (
                    field.type === "radio" ||
                    field.type === "checkbox"
                ) {
                    return;
                }

                field.value = data[key];

            });


            if (data.condition) {

                const condition =
                    form.querySelector(
                        `[name="condition"][value="${data.condition}"]`
                    );

                if (condition) {

                    condition.checked = true;

                }

            }


            descriptionCount.textContent =
                description.value.length;


        } catch (error) {

            console.log(
                "Draft loading error:",
                error
            );

        }

    }


    loadDraft();


    /* =========================
       SUBMIT
       ========================= */

    form.addEventListener("submit", function (event) {

        event.preventDefault();

        if (!validateForm()) {
            return;
        }


        /*
         * Connect your PHP/AJAX backend here.
         *
         * Example:
         *
         * const formData = new FormData(form);
         *
         * fetch("electronics-listing-submit.php", {
         *     method: "POST",
         *     body: formData
         * })
         * .then(response => response.json())
         * .then(data => {
         *     ...
         * });
         */


        showToast(
            "Electronics listing submitted for approval."
        );


        localStorage.removeItem(
            "peoplelink_electronics_listing_draft"
        );

    });

});







document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("otherMarketplaceForm");
    if (!form) return; // this block belongs to another page

    const imageInput = document.getElementById("otherImages");
    const dropZone = document.getElementById("otherDropZone");
    const previewBox = document.getElementById("otherImagePreview");

    const description = document.getElementById("otherDescription");
    const descriptionCount =
        document.getElementById("otherDescriptionCount");

    const previewButton =
        document.getElementById("previewOther");

    const previewModal =
        document.getElementById("otherPreviewModal");

    const closePreview =
        document.getElementById("closeOtherPreview");

    const saveDraftButton =
        document.getElementById("saveOtherDraft");

    const toast =
        document.getElementById("otherToast");

    let selectedFiles = [];


    /* =========================
       TOAST
       ========================= */

    function showToast(message) {

        const toastText =
            toast.querySelector("span");

        toastText.textContent = message;

        toast.classList.add("show");

        setTimeout(function () {

            toast.classList.remove("show");

        }, 2800);

    }


    /* =========================
       IMAGE UPLOAD
       ========================= */

    imageInput.addEventListener("change", function () {

        addImages(Array.from(this.files));

    });


    function addImages(files) {

        files.forEach(function (file) {

            if (!file.type.startsWith("image/")) {
                return;
            }

            const exists =
                selectedFiles.some(function (item) {

                    return item.name === file.name &&
                           item.size === file.size;

                });


            if (!exists) {

                selectedFiles.push(file);

            }

        });


        renderImages();

        syncInputFiles();

    }


    function renderImages() {

        previewBox.innerHTML = "";


        selectedFiles.forEach(function (file, index) {

            const reader = new FileReader();


            reader.onload = function (event) {

                const item =
                    document.createElement("div");

                item.className =
                    "pl-other-image-item";


                item.innerHTML = `
                    <img src="${event.target.result}"
                         alt="Marketplace Product">

                    <button type="button"
                            class="pl-other-image-remove"
                            data-index="${index}">
                        <i class="bi bi-x-lg"></i>
                    </button>
                `;


                previewBox.appendChild(item);

            };


            reader.readAsDataURL(file);

        });

    }


    previewBox.addEventListener("click", function (event) {

        const button =
            event.target.closest(
                ".pl-other-image-remove"
            );


        if (!button) {
            return;
        }


        const index =
            Number(button.dataset.index);


        selectedFiles.splice(index, 1);


        renderImages();

        syncInputFiles();

    });


    function syncInputFiles() {

        try {

            const dataTransfer =
                new DataTransfer();


            selectedFiles.forEach(function (file) {

                dataTransfer.items.add(file);

            });


            imageInput.files =
                dataTransfer.files;

        } catch (error) {

            console.log(
                "File sync is not supported:",
                error
            );

        }

    }


    /* =========================
       DRAG & DROP
       ========================= */

    ["dragenter", "dragover"].forEach(function (eventName) {

        dropZone.addEventListener(
            eventName,
            function (event) {

                event.preventDefault();

                dropZone.classList.add("dragging");

            }
        );

    });


    ["dragleave", "drop"].forEach(function (eventName) {

        dropZone.addEventListener(
            eventName,
            function (event) {

                event.preventDefault();

                dropZone.classList.remove("dragging");

            }
        );

    });


    dropZone.addEventListener("drop", function (event) {

        const files =
            Array.from(event.dataTransfer.files);

        addImages(files);

    });


    /* =========================
       DESCRIPTION COUNTER
       ========================= */

    description.addEventListener("input", function () {

        descriptionCount.textContent =
            this.value.length;

    });


    /* =========================
       CONDITION
       ========================= */

    const conditionOptions =
        document.querySelectorAll(
            ".pl-other-condition-option"
        );


    conditionOptions.forEach(function (option) {

        option.addEventListener("click", function () {

            conditionOptions.forEach(function (item) {

                item.classList.remove("selected");

            });


            this.classList.add("selected");


            const radio =
                this.querySelector("input");


            if (radio) {

                radio.checked = true;

            }

        });

    });


    /* =========================
       VISIBILITY
       ========================= */

    const visibilityOptions =
        document.querySelectorAll(
            ".pl-other-visibility-option"
        );


    visibilityOptions.forEach(function (option) {

        option.addEventListener("click", function () {

            visibilityOptions.forEach(function (item) {

                item.classList.remove("active");

            });


            this.classList.add("active");


            const radio =
                this.querySelector("input");


            if (radio) {

                radio.checked = true;

            }

        });

    });


    /* =========================
       VALIDATION
       ========================= */

    function validateForm() {

        if (!form.checkValidity()) {

            form.reportValidity();

            showToast(
                "Please complete the required fields."
            );

            return false;

        }

        return true;

    }


    /* =========================
       PREVIEW
       ========================= */

    previewButton.addEventListener("click", function () {

        if (!validateForm()) {
            return;
        }


        updatePreview();


        previewModal.classList.add("show");

    });


    function updatePreview() {

        const productName =
            form.querySelector(
                '[name="product_name"]'
            ).value || "—";


        const category =
            form.querySelector(
                '[name="category"]'
            ).value || "—";


        const price =
            form.querySelector(
                '[name="price"]'
            ).value || "—";


        const quantity =
            form.querySelector(
                '[name="quantity"]'
            ).value || "—";


        const city =
            form.querySelector(
                '[name="city"]'
            ).value || "";


        const state =
            form.querySelector(
                '[name="state"]'
            ).value || "";


        const descriptionValue =
            form.querySelector(
                '[name="description"]'
            ).value || "—";


        const condition =
            form.querySelector(
                '[name="condition"]:checked'
            );


        document.getElementById(
            "previewOtherTitle"
        ).textContent = productName;


        document.getElementById(
            "previewOtherProduct"
        ).textContent = productName;


        document.getElementById(
            "previewOtherCategory"
        ).textContent = category;


        document.getElementById(
            "previewOtherCondition"
        ).textContent =
            condition ? condition.value : "—";


        document.getElementById(
            "previewOtherPrice"
        ).textContent =
            price !== "—"
                ? "₹ " + Number(price).toLocaleString("en-IN")
                : "—";


        document.getElementById(
            "previewOtherQuantity"
        ).textContent = quantity;


        document.getElementById(
            "previewOtherLocation"
        ).textContent =
            city && state
                ? city + ", " + state
                : city || state || "—";


        document.getElementById(
            "previewOtherDescription"
        ).textContent =
            descriptionValue;


        const previewImage =
            document.getElementById(
                "previewOtherImage"
            );


        previewImage.innerHTML = "";


        if (selectedFiles.length > 0) {

            const reader =
                new FileReader();


            reader.onload = function (event) {

                previewImage.innerHTML = `
                    <img src="${event.target.result}"
                         alt="Marketplace Preview">
                `;

            };


            reader.readAsDataURL(
                selectedFiles[0]
            );

        } else {

            previewImage.innerHTML = `
                <i class="bi bi-grid-3x3-gap-fill"></i>
            `;

        }

    }


    /* =========================
       CLOSE PREVIEW
       ========================= */

    closePreview.addEventListener("click", function () {

        previewModal.classList.remove("show");

    });


    previewModal.addEventListener("click", function (event) {

        if (event.target === previewModal) {

            previewModal.classList.remove("show");

        }

    });


    document.addEventListener("keydown", function (event) {

        if (event.key === "Escape") {

            previewModal.classList.remove("show");

        }

    });


    /* =========================
       SAVE DRAFT
       ========================= */

    saveDraftButton.addEventListener("click", function () {

        const data = {};


        new FormData(form).forEach(function (value, key) {

            if (typeof value === "string") {

                data[key] = value;

            }

        });


        const condition =
            form.querySelector(
                '[name="condition"]:checked'
            );


        if (condition) {

            data.condition =
                condition.value;

        }


        localStorage.setItem(
            "peoplelink_other_marketplace_draft",
            JSON.stringify(data)
        );


        showToast(
            "Marketplace listing draft saved."
        );

    });


    /* =========================
       LOAD DRAFT
       ========================= */

    function loadDraft() {

        const saved =
            localStorage.getItem(
                "peoplelink_other_marketplace_draft"
            );


        if (!saved) {
            return;
        }


        try {

            const data =
                JSON.parse(saved);


            Object.keys(data).forEach(function (key) {

                const field =
                    form.querySelector(
                        `[name="${key}"]`
                    );


                if (!field) {
                    return;
                }


                if (
                    field.type === "radio" ||
                    field.type === "checkbox"
                ) {
                    return;
                }


                field.value =
                    data[key];

            });


            if (data.condition) {

                const condition =
                    form.querySelector(
                        `[name="condition"][value="${data.condition}"]`
                    );


                if (condition) {

                    condition.checked = true;

                }

            }


            descriptionCount.textContent =
                description.value.length;


        } catch (error) {

            console.log(
                "Draft loading error:",
                error
            );

        }

    }


    loadDraft();


    /* =========================
       SUBMIT
       ========================= */

    form.addEventListener("submit", function (event) {

        event.preventDefault();


        if (!validateForm()) {
            return;
        }


        /*
         * Connect your PHP/AJAX backend here.
         *
         * Example:
         *
         * const formData = new FormData(form);
         *
         * fetch("other-marketplace-submit.php", {
         *     method: "POST",
         *     body: formData
         * })
         * .then(response => response.json())
         * .then(data => {
         *     ...
         * });
         */


        showToast(
            "Marketplace item submitted for approval."
        );


        localStorage.removeItem(
            "peoplelink_other_marketplace_draft"
        );

    });

});






document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("plMarketplaceForm");
    if (!form) return; // this block belongs to another page
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


    /* ====================================================
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