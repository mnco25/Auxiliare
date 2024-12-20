document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-nav-toggle');
    const navMenu = document.querySelector('.nav-menu');
    const body = document.body;
    let touchStartY = 0;

    function toggleMenu(event) {
        if (event) event.preventDefault();
        
        const isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
        
        mobileMenuToggle.setAttribute('aria-expanded', !isExpanded);
        mobileMenuToggle.classList.toggle('active');
        navMenu.classList.toggle('active');
        body.classList.toggle('menu-open');

        // Handle iOS scroll lock
        if (!isExpanded) {
            body.style.top = `-${window.scrollY}px`;
            body.style.position = 'fixed';
            body.style.width = '100%';
        } else {
            const scrollY = body.style.top;
            body.style.position = '';
            body.style.top = '';
            body.style.width = '';
            window.scrollTo(0, parseInt(scrollY || '0') * -1);
        }
    }

    // Enhanced touch handling
    if (mobileMenuToggle && navMenu) {
        // Click handler
        mobileMenuToggle.addEventListener('click', toggleMenu);

        // Touch handlers with improved responsiveness
        mobileMenuToggle.addEventListener('touchstart', function(e) {
            touchStartY = e.touches[0].clientY;
        }, { passive: true });

        mobileMenuToggle.addEventListener('touchend', function(e) {
            const touchEndY = e.changedTouches[0].clientY;
            const touchDiff = Math.abs(touchEndY - touchStartY);
            
            // Only toggle if it's a tap (minimal vertical movement)
            if (touchDiff < 5) {
                e.preventDefault();
                toggleMenu();
            }
        }, { passive: false });

        // Close menu on menu item click
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                toggleMenu();
            });
        });

        // Close menu on outside click
        document.addEventListener('click', function(e) {
            if (navMenu.classList.contains('active') && 
                !navMenu.contains(e.target) && 
                !mobileMenuToggle.contains(e.target)) {
                toggleMenu();
            }
        });

        // Handle resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768 && navMenu.classList.contains('active')) {
                toggleMenu();
            }
        });
    }
});
