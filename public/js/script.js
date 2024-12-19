document.addEventListener('DOMContentLoaded', function() {
    // Prevent double-tap zoom on iOS
    document.addEventListener('touchend', function(event) {
        event.preventDefault();
    }, { passive: false });

    // Handle iOS keyboard
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            setTimeout(() => {
                window.scrollTo(0, 0);
                document.body.scrollTop = 0;
            }, 300);
        });

        input.addEventListener('blur', () => {
            window.scrollTo(0, 0);
        });
    });

    // Fix modal scrolling on iOS
    const modal = document.getElementById('registerModal');
    if (modal) {
        modal.addEventListener('touchmove', function(e) {
            e.stopPropagation();
        }, { passive: true });
    }

    // Improve form submission on mobile
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                setTimeout(() => {
                    submitButton.disabled = false;
                }, 2000);
            }
        });
    });
});
