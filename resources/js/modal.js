const openModal = document.getElementById("openModal");
const closeModal = document.getElementById("closeModal");
const registerModal = document.getElementById("registerModal");

openModal.onclick = () => registerModal.style.display = "block";

// Close modal when the user clicks on the "X"
closeModal.onclick = () => {
    registerModal.style.display = "none";
    clearForms();
};

// Close modal when clicked outside of the modal content
window.onclick = (event) => {
    if (event.target === registerModal) {
        registerModal.style.display = "none";
        clearForms();
    }
};

function clearForms() {
    document.querySelectorAll('.form-control').forEach(input => {
        input.value = '';
    });
}

// Ensure that the Register button is disabled by default
document.addEventListener('DOMContentLoaded', () => {
    const registerButton = document.getElementById('registerButton');
    registerButton.disabled = true;
});