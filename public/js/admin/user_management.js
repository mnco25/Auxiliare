document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const modal = document.getElementById('userRegistrationModal');
    const addUserBtn = document.querySelector('.add-user-btn');
    const closeBtn = document.getElementById('closeModal');
    const form = document.getElementById('userRegistrationForm');

    // Show modal
    if (addUserBtn) {
        addUserBtn.addEventListener('click', function() {
            console.log('Add User button clicked'); // Debugging statement
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        });
    }

    // Close modal on X click
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            closeModal();
        });
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Close modal function
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Restore scrolling
        if (form) form.reset();
    }

    // Form submission
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert('User added successfully!');
                    closeModal();
                    window.location.reload();
                } else {
                    const errorDiv = document.getElementById('error-messages');
                    errorDiv.style.display = 'block';
                    errorDiv.textContent = data.message;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while adding the user.');
            }
        });
    }
});
