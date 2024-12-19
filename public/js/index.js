AOS.init({
    once: true,
    offset: 200,
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute("href")).scrollIntoView({
            behavior: "smooth",
        });
    });
});

// Add number counter animation for stats
const stats = document.querySelectorAll(".stat-number");

stats.forEach((stat) => {
    const target = parseInt(stat.getAttribute("data-target"));
    const increment = target / 200;

    function updateCount() {
        const current = parseInt(stat.innerText);
        if (current < target) {
            stat.innerText = Math.ceil(current + increment);
            setTimeout(updateCount, 10);
        } else {
            stat.innerText = target;
        }
    }

    updateCount();
});

// Add FAQ interaction
document.querySelectorAll(".faq-button").forEach((button) => {
    button.addEventListener("click", () => {
        const faqItem = button.parentElement;
        faqItem.classList.toggle("active");

        // Close other items
        document.querySelectorAll(".faq-item").forEach((item) => {
            if (item !== faqItem) {
                item.classList.remove("active");
            }
        });
    });
});

// Add scroll to top functionality
const scrollToTopBtn = document.getElementById("scroll-to-top");

window.addEventListener("scroll", () => {
    if (window.pageYOffset > 300) {
        scrollToTopBtn.classList.add("show");
    } else {
        scrollToTopBtn.classList.remove("show");
    }
});

scrollToTopBtn.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
});
