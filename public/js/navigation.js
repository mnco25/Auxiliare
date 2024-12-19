class Navigation {
    constructor() {
        this.header = document.querySelector(".main-header");
        this.mobileNavToggle = document.querySelector(".mobile-nav-toggle");
        this.navMenu = document.querySelector(".nav-menu");
        this.lastScrollPosition = window.pageYOffset;
        this.isScrolling = false;

        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // Mobile menu toggle
        this.mobileNavToggle?.addEventListener("click", () =>
            this.toggleMobileMenu()
        );

        // Close menu on link click
        document.querySelectorAll(".nav-menu a").forEach((link) => {
            link.addEventListener("click", () => this.closeMobileMenu());
        });

        // Header hide/show on scroll
        window.addEventListener("scroll", () => this.handleScroll());

        // Close menu on outside click
        document.addEventListener("click", (e) => this.handleOutsideClick(e));

        // Handle window resize
        window.addEventListener("resize", () => this.handleResize());
    }

    toggleMobileMenu() {
        this.mobileNavToggle.classList.toggle("active");
        this.navMenu.classList.toggle("active");
        document.body.classList.toggle("menu-open");
    }

    closeMobileMenu() {
        this.mobileNavToggle?.classList.remove("active");
        this.navMenu?.classList.remove("active");
        document.body.classList.remove("menu-open");
    }

    handleScroll() {
        if (!this.isScrolling) {
            window.requestAnimationFrame(() => {
                const currentScroll = window.pageYOffset;

                // Show/hide header based on scroll direction
                if (
                    currentScroll > this.lastScrollPosition &&
                    currentScroll > 100
                ) {
                    this.header.classList.add("hidden");
                } else {
                    this.header.classList.remove("hidden");
                }

                this.lastScrollPosition = currentScroll;
                this.isScrolling = false;
            });

            this.isScrolling = true;
        }
    }

    handleOutsideClick(event) {
        if (
            this.navMenu?.classList.contains("active") &&
            !this.navMenu.contains(event.target) &&
            !this.mobileNavToggle?.contains(event.target)
        ) {
            this.closeMobileMenu();
        }
    }

    handleResize() {
        if (window.innerWidth > 768) {
            this.closeMobileMenu();
        }
    }

    // Method to highlight active nav item
    setActiveNavItem() {
        const currentPath = window.location.pathname;
        const currentHash = window.location.hash;

        document.querySelectorAll(".nav-menu a").forEach((link) => {
            const href = link.getAttribute("href");

            // Remove active class by default
            link.classList.remove("active");

            // Check if it's a hash link on the home page
            if (href.startsWith("#") && currentPath === "/") {
                if (currentHash === href) {
                    link.classList.add("active");
                }
            }
            // Check for exact path matches
            else if (href === currentPath) {
                link.classList.add("active");
            }
            // Special case for home page
            else if (currentPath === "/" && href === "/") {
                link.classList.add("active");
            }
        });
    }
}

// Initialize navigation when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
    const navigation = new Navigation();
    navigation.setActiveNavItem();

    // Update active state when hash changes
    window.addEventListener("hashchange", () => {
        navigation.setActiveNavItem();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Mobile menu toggle functionality
    const mobileNav = document.querySelector(".nav-menu");
    const mobileNavToggle = document.querySelector(".mobile-nav-toggle");
    const body = document.body;

    mobileNavToggle.addEventListener("click", function () {
        this.classList.toggle("active");
        mobileNav.classList.toggle("active");
        body.classList.toggle("menu-open");
    });

    // Close mobile menu when clicking outside
    document.addEventListener("click", function (e) {
        if (
            !mobileNav.contains(e.target) &&
            !mobileNavToggle.contains(e.target)
        ) {
            mobileNav.classList.remove("active");
            mobileNavToggle.classList.remove("active");
            body.classList.remove("menu-open");
        }
    });

    // Header hide/show on scroll
    let lastScrollPosition = 0;
    const header = document.querySelector(".main-header");

    window.addEventListener("scroll", () => {
        const currentScrollPosition = window.pageYOffset;

        if (currentScrollPosition > lastScrollPosition) {
            header.classList.add("hidden");
        } else {
            header.classList.remove("hidden");
        }

        lastScrollPosition = currentScrollPosition;
    });
});
