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
const profilePic = document.getElementById("profile-pic");

// Get edit form elements
const editName = document.getElementById("edit-name");
const editLocation = document.getElementById("edit-location");
const editBio = document.getElementById("edit-bio");
const editSkills = document.getElementById("edit-skills");
const editProfilePic = document.getElementById("edit-profile-pic");

// Add URL input handler
const profilePicUrl = document.getElementById('profile-pic-url');

profilePicUrl.addEventListener('input', function(e) {
    if (this.value) {
        // Clear file input if URL is entered
        editProfilePic.value = '';
    }
});

editProfilePic.addEventListener('change', function(e) {
    if (this.files.length > 0) {
        // Clear URL input if file is selected
        profilePicUrl.value = '';
    }
});

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

// Update form submission to use PUT method
document.getElementById('edit-profile-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    submitBtn.disabled = true;

    fetch(form.action, {
        method: 'POST', // Laravel uses POST with method override for PUT
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-HTTP-Method-Override': 'PUT' // Method override to simulate PUT request
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI
            updateProfileUI(formData);
            modalOverlay.classList.add('hidden');
            editProfileModal.classList.add('hidden');
            showNotification('Profile updated successfully!', 'success');
        } else {
            throw new Error(data.message || 'Failed to update profile');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Failed to update profile', 'error');
    })
    .finally(() => {
        submitBtn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
        submitBtn.disabled = false;
    });
});

// Update profile picture if a new one is selected
editProfilePic.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Remove existing profile icon if it exists
            if (profilePic.classList.contains('profile-icon')) {
                profilePic.classList.remove('profile-icon');
                profilePic.innerHTML = ''; // Remove the icon
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('profile-pic');
                profilePic.parentNode.replaceChild(img, profilePic);
            } else {
                profilePic.src = e.target.result;
            }
        };
        reader.readAsDataURL(this.files[0]);
    }
});

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function updateProfileUI(formData) {
    profileName.textContent = formData.get('name');
    profileLocation.textContent = formData.get('location');
    profileBio.textContent = formData.get('bio');
    
    // Update skills
    const skills = formData.get('skills').split(',').map(skill => skill.trim());
    profileSkills.innerHTML = '';
    skills.forEach(skill => {
        const li = document.createElement('li');
        li.textContent = skill;
        profileSkills.appendChild(li);
    });
}

// Remove the old saveProfileBtn click handler since we're using form submission