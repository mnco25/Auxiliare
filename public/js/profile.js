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

// Save profile updates
saveProfileBtn.addEventListener("click", function (event) {
  event.preventDefault(); // Prevent form from submitting and refreshing the page

  // Get the updated values from the form
  profileName.textContent = editName.value;
  profileLocation.textContent = editLocation.value;
  profileBio.textContent = editBio.value;

  // Update the skills list
  profileSkills.innerHTML = "";
  var skills = editSkills.value.split(",").map(function (skill) {
    return skill.trim();
  });
  skills.forEach(function (skill) {
    var li = document.createElement("li");
    li.textContent = skill;
    profileSkills.appendChild(li);
  });

  // Update profile picture if a new one is selected
  if (editProfilePic.files.length > 0) {
    var reader = new FileReader();
    reader.onload = function (e) {
      profilePic.src = e.target.result;
    };
    reader.readAsDataURL(editProfilePic.files[0]);
  }

  // Close the modal
  modalOverlay.classList.add("hidden");
  editProfileModal.classList.add("hidden");
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

// Update form submission
document.getElementById('edit-profile-form').addEventListener('submit', function (e) {
  saveProfileBtn.textContent = 'Saving...';
  saveProfileBtn.disabled = true;

  // Let the form submit normally
  return true;
});

// Remove the old saveProfileBtn click handler since we're using form submission
/******/ })()
;