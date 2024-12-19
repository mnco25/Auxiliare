document.addEventListener("DOMContentLoaded", function () {
    // Initialize AOS
    AOS.init({
        once: true,
        offset: 200,
    });

    // Initialize all components
    initSmoothScroll();
    initStatsCounter();
    initFaqAccordion();
    initScrollToTop();
});

function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const targetId = this.getAttribute("href").slice(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                const headerOffset = 80; // Adjust this value based on your header height
                const elementPosition =
                    targetElement.getBoundingClientRect().top;
                const offsetPosition =
                    elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth",
                });
            }
        });
    });
}

function initStatsCounter() {
    const stats = document.querySelectorAll(".stat-number");
    stats.forEach((stat) => {
        const target = parseInt(stat.getAttribute("data-target"));
        const increment = target / 200;
        updateCount(stat, target, increment);
    });
}

function updateCount(element, target, increment) {
    const current = parseInt(element.innerText);
    if (current < target) {
        element.innerText = Math.ceil(current + increment);
        setTimeout(() => updateCount(element, target, increment), 10);
    }
}

function initFaqAccordion() {
    document.querySelectorAll(".faq-button").forEach((button) => {
        button.addEventListener("click", () => {
            const faqItem = button.parentElement;
            faqItem.classList.toggle("active");

            document.querySelectorAll(".faq-item").forEach((item) => {
                if (item !== faqItem) item.classList.remove("active");
            });
        });
    });
}

function initScrollToTop() {
    const scrollToTopBtn = document.getElementById("scroll-to-top");

    window.addEventListener("scroll", () => {
        scrollToTopBtn.classList.toggle("show", window.pageYOffset > 300);
    });

    scrollToTopBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    });
}
