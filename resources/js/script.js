// Get elements
const editProfileBtn = document.getElementById("edit-profile-btn");
const modalOverlay = document.getElementById("modal-overlay");
const editProfileModal = document.getElementById("edit-profile-modal");
const closeModalBtn = document.getElementById("close-modal-btn");
const saveProfileBtn = document.getElementById("save-profile-btn");

// Get profile info to update
const profileName = document.getElementById("profile-name");
const profileLocation = document.getElementById("profile-location");
const profileBio = document.getElementById("profile-bio");
const profileSkills = document.getElementById("profile-skills");

// Get edit form elements
const editName = document.getElementById("edit-name");
const editLocation = document.getElementById("edit-location");
const editBio = document.getElementById("edit-bio");
const editSkills = document.getElementById("edit-skills");

// Open modal
editProfileBtn.addEventListener("click", () => {
    modalOverlay.classList.remove("hidden");
    editProfileModal.classList.remove("hidden");

    // Pre-fill form with current profile values
    editName.value = profileName.textContent;
    editLocation.value = profileLocation.textContent;
    editBio.value = profileBio.textContent;
    editSkills.value = Array.from(profileSkills.children)
        .map((skill) => skill.textContent)
        .join(", ");
});

// Close modal
closeModalBtn.addEventListener("click", () => {
    modalOverlay.classList.add("hidden");
    editProfileModal.classList.add("hidden");
});

// Close modal if clicked outside the modal
modalOverlay.addEventListener("click", () => {
    modalOverlay.classList.add("hidden");
    editProfileModal.classList.add("hidden");
});

// Save profile updates
saveProfileBtn.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent form from submitting and refreshing the page

    // Get the updated values from the form
    profileName.textContent = editName.value;
    profileLocation.textContent = editLocation.value;
    profileBio.textContent = editBio.value;

    // Update the skills list
    profileSkills.innerHTML = "";
    const skills = editSkills.value.split(",").map((skill) => skill.trim());
    skills.forEach((skill) => {
        const li = document.createElement("li");
        li.textContent = skill;
        profileSkills.appendChild(li);
    });

    // Close the modal after saving
    modalOverlay.classList.add("hidden");
    editProfileModal.classList.add("hidden");
});

// For login -- clearing the input
document.getElementById("openModal").onclick = function () {
    document.getElementById("registerModal").style.display = "block";
};
document.getElementById("closeModal").onclick = function () {
    document.getElementById("registerModal").style.display = "none";
    clearForms();
};
window.onclick = function (event) {
    if (event.target == document.getElementById("registerModal")) {
        document.getElementById("registerModal").style.display = "none";
        clearForms();
    }
};

function clearForms() {
    document.querySelectorAll(".form-control").forEach((input) => {
        input.value = "";
    });
}