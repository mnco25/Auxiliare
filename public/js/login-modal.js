document.addEventListener('DOMContentLoaded', function() {
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");
    const registerModal = document.getElementById("registerModal");
    const body = document.body;

    function showModal() {
        registerModal.style.display = "block";
        body.style.overflow = "hidden";
    }

    function hideModal() {
        registerModal.style.display = "none";
        body.style.overflow = "";
    }

    // Open modal
    if (openModal) {
        openModal.addEventListener('click', function(e) {
            e.preventDefault();
            showModal();
        });
    }

    // Close modal with X button
    if (closeModal) {
        closeModal.addEventListener('click', hideModal);
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === registerModal) {
            hideModal();
        }
    });

    // Prevent modal close when clicking modal content
    registerModal?.querySelector('.modal-content')?.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Handle form submission
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const errorMessages = document.getElementById('error-messages');
            errorMessages.style.display = 'none';
            errorMessages.innerHTML = '';
        });
    }
});
