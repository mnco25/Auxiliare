document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-nav-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const body = document.body;

    if (mobileMenuToggle && navMenu) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
            body.classList.toggle('menu-open');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                navMenu.classList.remove('active');
                mobileMenuToggle.classList.remove('active');
                body.classList.remove('menu-open');
            }
        });

        // Close menu when clicking on a link
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                mobileMenuToggle.classList.remove('active');
                body.classList.remove('menu-open');
            });
        });
    }
});
