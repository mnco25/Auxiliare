document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    const sidebar = document.querySelector('.main-sidebar');
    const toggleBtn = document.createElement('button');
    const backdrop = document.createElement('div');
    let touchStartX = null;
    let touchMoveX = null;
    let sidebarWidth = 280;
    let scrollPosition = 0;

    // Initialize sidebar elements
    function initializeSidebar() {
        toggleBtn.className = 'mobile-sidebar-toggle';
        toggleBtn.innerHTML = '<i class="mdi mdi-menu"></i>';
        document.body.appendChild(toggleBtn);

        backdrop.className = 'sidebar-backdrop';
        document.body.appendChild(backdrop);

        // Ensure sidebar links are properly handled
        sidebar.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', handleLinkClick);
        });
    }

    // Toggle sidebar function
    function toggleSidebar() {
        if (!body.classList.contains('sidebar-open')) {
            // Store scroll position and prevent body scroll
            scrollPosition = window.pageYOffset;
            body.style.position = 'fixed';
            body.style.top = `-${scrollPosition}px`;
            body.style.width = '100%';
            body.classList.add('sidebar-open');
            
            // Enable pointer events on sidebar elements
            sidebar.style.pointerEvents = 'auto';
            document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
                link.style.pointerEvents = 'auto';
            });
        } else {
            // Restore scroll position
            body.classList.remove('sidebar-open');
            body.style.position = '';
            body.style.top = '';
            body.style.width = '';
            window.scrollTo(0, scrollPosition);
        }
    }

    // Handle link clicks
    function handleLinkClick(e) {
        if (window.innerWidth <= 768) {
            const href = e.currentTarget.getAttribute('href');
            if (!href || href === '#') return;

            e.preventDefault();
            e.stopPropagation();

            // Close sidebar
            body.classList.remove('sidebar-open');
            body.style.position = '';
            body.style.top = '';
            window.scrollTo(0, scrollPosition);
            
            // Navigate after sidebar closes
            window.location.href = href;
        }
    }

    // Touch event handlers
    function handleTouchStart(e) {
        touchStartX = e.touches[0].clientX;
        sidebar.style.transition = 'none';
    }

    function handleTouchMove(e) {
        if (touchStartX === null) return;
        
        touchMoveX = e.touches[0].clientX;
        const diff = touchMoveX - touchStartX;
        const currentTransform = diff < 0 ? diff : 0;
        
        if (body.classList.contains('sidebar-open')) {
            if (diff < 0) {
                sidebar.style.transform = `translateX(${currentTransform}px)`;
            }
        } else if (touchStartX < 30 && diff > 0) {
            sidebar.style.transform = `translateX(${diff - sidebarWidth}px)`;
        }
    }

    function handleTouchEnd() {
        if (touchStartX === null) return;
        
        const diff = touchMoveX - touchStartX;
        sidebar.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        
        if (body.classList.contains('sidebar-open')) {
            if (diff < -50) {
                toggleSidebar();
            } else {
                sidebar.style.transform = '';
            }
        } else if (touchStartX < 30 && diff > 50) {
            toggleSidebar();
        } else {
            sidebar.style.transform = 'translateX(-100%)';
        }
        
        touchStartX = null;
        touchMoveX = null;
    }

    // Initialize sidebar
    initializeSidebar();

    // Event listeners
    function initializeEventListeners() {
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleSidebar();
        });
        
        sidebar.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', handleLinkClick);
        });
        
        // Prevent touch events from bleeding through
        ['touchstart', 'touchmove', 'touchend'].forEach(eventName => {
            sidebar.addEventListener(eventName, e => e.stopPropagation(), { passive: false });
        });
    }

    initializeEventListeners();

    backdrop.addEventListener('click', function(e) {
        if (body.classList.contains('sidebar-open')) {
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar();
        }
    });

    sidebar.addEventListener('click', function(e) {
        // Make sure clicks on sidebar content work
        e.stopPropagation();
    });
    
    // Touch events with passive flag for better performance
    document.addEventListener('touchstart', handleTouchStart, { passive: true });
    document.addEventListener('touchmove', handleTouchMove, { passive: true });
    document.addEventListener('touchend', handleTouchEnd);

    // Handle orientation change
    window.addEventListener('orientationchange', function() {
        if (body.classList.contains('sidebar-open')) {
            toggleSidebar();
        }
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth > 768 && body.classList.contains('sidebar-open')) {
                toggleSidebar();
            }
        }, 250);
    });
});
