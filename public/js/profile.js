/******/ (() => { // webpackBootstrap
/*!*********************************!*\
  !*** ./resources/js/profile.js ***!
  \*********************************/
// Get elements
var editProfileBtn = document.getElementById("edit-profile-btn");
var modalOverlay = document.getElementById("modal-overlay");
var editProfileModal = document.getElementById("edit-profile-modal");
var closeModalBtn = document.getElementById("close-modal-btn");
var saveProfileBtn = document.getElementById("save-profile-btn");

// Get profile info to update
var profileName = document.getElementById("profile-name");
var profileLocation = document.getElementById("profile-location");
var profileBio = document.getElementById("profile-bio");
var profileSkills = document.getElementById("profile-skills");
var profilePic = document.getElementById("profile-pic");

// Get edit form elements
var editName = document.getElementById("edit-name");
var editLocation = document.getElementById("edit-location");
var editBio = document.getElementById("edit-bio");
var editSkills = document.getElementById("edit-skills");
var editProfilePic = document.getElementById("edit-profile-pic");

// Add URL input handler
var profilePicUrl = document.getElementById('profile-pic-url');
profilePicUrl.addEventListener('input', function (e) {
  if (this.value) {
    // Clear file input if URL is entered
    editProfilePic.value = '';
  }
});
editProfilePic.addEventListener('change', function (e) {
  if (this.files.length > 0) {
    // Clear URL input if file is selected
    profilePicUrl.value = '';
  }
});

// Open modal
editProfileBtn.addEventListener("click", function () {
  modalOverlay.classList.remove("hidden");
  editProfileModal.classList.remove("hidden");

  // Pre-fill form with current profile values
  editName.value = profileName.textContent;
  editLocation.value = profileLocation.textContent;
  editBio.value = profileBio.textContent;
  editSkills.value = Array.from(profileSkills.children).map(function (skill) {
    return skill.textContent;
  }).join(", ");
});

// Close modal
closeModalBtn.addEventListener("click", function () {
  modalOverlay.classList.add("hidden");
  editProfileModal.classList.add("hidden");
});

// Close modal if clicked outside the modal
modalOverlay.addEventListener("click", function () {
  modalOverlay.classList.add("hidden");
  editProfileModal.classList.add("hidden");
});

// Update form submission to use PUT method
document.getElementById('edit-profile-form').addEventListener('submit', function (e) {
  e.preventDefault();
  var form = this;
  var formData = new FormData(form);
  var submitBtn = form.querySelector('button[type="submit"]');

  // Show loading state
  submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
  submitBtn.disabled = true;
  fetch(form.action, {
    method: 'POST',
    // Laravel uses POST with method override for PUT
    body: formData,
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'X-HTTP-Method-Override': 'PUT' // Method override to simulate PUT request
    },
    credentials: 'same-origin'
  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    if (data.success) {
      // Update UI
      updateProfileUI(formData);
      modalOverlay.classList.add('hidden');
      editProfileModal.classList.add('hidden');
      showNotification('Profile updated successfully!', 'success');
    } else {
      throw new Error(data.message || 'Failed to update profile');
    }
  })["catch"](function (error) {
    console.error('Error:', error);
    showNotification(error.message || 'Failed to update profile', 'error');
  })["finally"](function () {
    submitBtn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
    submitBtn.disabled = false;
  });
});

// Update profile picture if a new one is selected
editProfilePic.addEventListener('change', function (e) {
  if (this.files && this.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      // Remove existing profile icon if it exists
      if (profilePic.classList.contains('profile-icon')) {
        profilePic.classList.remove('profile-icon');
        profilePic.innerHTML = ''; // Remove the icon
        var img = document.createElement('img');
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
function showNotification(message) {
  var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'success';
  var notification = document.createElement('div');
  notification.className = "notification ".concat(type);
  notification.textContent = message;
  document.body.appendChild(notification);
  setTimeout(function () {
    notification.remove();
  }, 3000);
}
function updateProfileUI(formData) {
  profileName.textContent = formData.get('name');
  profileLocation.textContent = formData.get('location');
  profileBio.textContent = formData.get('bio');

  // Update skills
  var skills = formData.get('skills').split(',').map(function (skill) {
    return skill.trim();
  });
  profileSkills.innerHTML = '';
  skills.forEach(function (skill) {
    var li = document.createElement('li');
    li.textContent = skill;
    profileSkills.appendChild(li);
  });
}

// Remove the old saveProfileBtn click handler since we're using form submission
/******/ })()
;