document.addEventListener('DOMContentLoaded', function() {
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");
    const registerModal = document.getElementById("registerModal");
    const body = document.body;

    function showModal() {
        registerModal.style.display = "block";
        body.classList.add('modal-open');
        // Force redraw for iOS
        registerModal.offsetHeight;
    }

    function hideModal() {
        registerModal.style.display = "none";
        body.classList.remove('modal-open');
    }

    // Improve touch events
    if (openModal) {
        ['click', 'touchend'].forEach(evt => 
            openModal.addEventListener(evt, function(e) {
                e.preventDefault();
                showModal();
            }, { passive: false })
        );
    }

    if (closeModal) {
        ['click', 'touchend'].forEach(evt => 
            closeModal.addEventListener(evt, function(e) {
                e.preventDefault();
                hideModal();
            }, { passive: false })
        );
    }

    // Prevent modal content click from closing
    registerModal?.querySelector('.modal-content')?.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Close modal on outside click
    registerModal?.addEventListener('click', function(e) {
        if (e.target === registerModal) {
            hideModal();
        }
    });

    // Handle form inputs
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            // Small delay to ensure keyboard is shown
            setTimeout(() => {
                input.scrollIntoView({ behavior: 'smooth' });
            }, 300);
        });
    });
});
