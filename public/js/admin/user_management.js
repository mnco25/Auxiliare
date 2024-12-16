document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("userRegistrationModal");
    const addUserBtn = document.querySelector(".add-user-btn");
    const closeBtn = document.getElementById("closeModal");
    const form = document.getElementById("userRegistrationForm");

    const editModal = document.getElementById("userEditModal");
    const closeEditBtn = document.getElementById("closeEditModal");
    const editForm = document.getElementById("userEditForm");

    const addUserSaveBtn = document.getElementById("addUserSaveBtn");

    // Show modal
    addUserBtn.onclick = () => {
        modal.classList.add("show");
        document.body.style.overflow = "hidden";
    };

    // Close modal
    closeBtn.onclick = () => {
        modal.classList.remove("show");
        document.body.style.overflow = "";
        form.reset();
    };

    closeEditBtn.onclick = () => {
        editModal.classList.remove("show");
        document.body.style.overflow = "";
        editForm.reset();
    };

    window.onclick = (e) => {
        if (e.target == modal) {
            modal.classList.remove("show");
            document.body.style.overflow = "";
            form.reset();
        }
        if (e.target == editModal) {
            editModal.classList.remove("show");
            document.body.style.overflow = "";
            editForm.reset();
        }
    };

    // Handle form submission
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
            });

            const data = await response.json();

            if (data.success) {
                // Create new row with the user data
                const newRow = createUserRow({
                    user_id: data.user.user_id,
                    first_name: formData.get("first_name"),
                    last_name: formData.get("last_name"),
                    email: formData.get("email"),
                    username: formData.get("username"),
                    user_type: formData.get("user_type"),
                    account_status: "Active",
                    created_at: new Date().toISOString(),
                });

                // Add new row to table
                const tbody = document.querySelector("#usersTable tbody");
                const noDataRow = tbody.querySelector('tr td[colspan="5"]');
                if (noDataRow) {
                    tbody.innerHTML = "";
                }
                tbody.insertBefore(newRow, tbody.firstChild);

                // Update stats
                updateUserStats(formData.get("user_type"));

                // Close modal and reset form
                modal.classList.remove("show");
                document.body.style.overflow = "";
                form.reset();

                showNotification("User added successfully!", "success");
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            showNotification(error.message, "error");
        }
    });

    // Ensure the modal is closed when the "Add User" button is clicked
    addUserSaveBtn.addEventListener("click", () => {
        modal.classList.remove("show");
        document.body.style.overflow = "";
    });

    // Handle edit form submission
    editForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(editForm);
        const userId = document.getElementById("editUserId").value;

        try {
            const response = await fetch(`/admin/users/${userId}`, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
            });

            const data = await response.json();

            if (data.success) {
                // Update the user row in the table
                const userRow = document.querySelector(
                    `tr[data-user-id="${userId}"]`
                );

                // Update user info
                userRow.querySelector(
                    ".user-info h4"
                ).textContent = `${formData.get("first_name")} ${formData.get(
                    "last_name"
                )}`;
                userRow.querySelector(
                    ".user-info p"
                ).innerHTML = `<i class="mdi mdi-email"></i> ${formData.get(
                    "email"
                )}`;

                // Update account info
                const accountInfo = userRow.querySelector(".account-info");
                accountInfo.innerHTML = `
                    <p><span>Username:</span> ${formData.get("username")}</p>
                    <p><span>Role:</span> ${formData.get("user_type")}</p>
                    <p><span>Join Date:</span> ${
                        accountInfo.querySelector("p:last-child span")
                            .nextSibling.textContent
                    }</p>
                `;

                // Update status badge
                userRow.querySelector('.status-badge').className = 
                    `status-badge status-${formData.get('account_status').toLowerCase()}`;
                userRow.querySelector('.status-badge').textContent = 
                    formData.get('account_status');

                // Close modal and reset form
                editModal.style.display = "none";
                editForm.reset();

                showNotification("User updated successfully!", "success");
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            showNotification(error.message, "error");
        }
    });
});

function editUser(userId) {
    const editModal = document.getElementById("userEditModal");
    const editForm = document.getElementById("userEditForm");

    // Fetch user data
    fetch(`/admin/users/${userId}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                const user = data.user;
                document.getElementById("editUserId").value = user.user_id;
                editForm.querySelector('input[name="username"]').value =
                    user.username;
                editForm.querySelector('input[name="email"]').value =
                    user.email;
                editForm.querySelector('input[name="first_name"]').value =
                    user.first_name;
                editForm.querySelector('input[name="last_name"]').value =
                    user.last_name;
                editForm.querySelector('select[name="user_type"]').value =
                    user.user_type;
                editForm.querySelector('select[name="account_status"]').value = user.account_status;

                // Show the modal with class
                editModal.classList.add("show");
                document.body.style.overflow = "hidden";
            } else {
                showNotification(data.message, "error");
            }
        })
        .catch((error) => {
            showNotification("Error fetching user data", "error");
        });
}

function deleteUser(userId) {
    if (confirm("Are you sure you want to delete this user?")) {
        fetch(`/admin/users/${userId}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Remove the user row from the table
                    const userRow = document.querySelector(
                        `tr[data-user-id="${userId}"]`
                    );
                    userRow.remove();

                    // Update stats
                    updateUserStats(data.user_type, -1);

                    showNotification("User deleted successfully!", "success");
                } else {
                    throw new Error(data.message);
                }
            })
            .catch((error) => {
                showNotification(error.message, "error");
            });
    }
}

function createUserRow(user) {
    const tr = document.createElement("tr");
    tr.dataset.userId = user.user_id;

    tr.innerHTML = `
        <td>
            <div class="user-avatar">
                <div class="default-profile-icon">
                    <i class="mdi mdi-account"></i>
                </div>
            </div>
        </td>
        <td>
            <div class="user-info">
                <h4>${user.first_name} ${user.last_name}</h4>
                <p><i class="mdi mdi-email"></i> ${user.email}</p>
            </div>
        </td>
        <td>
            <div class="account-info">
                <p><span>Username:</span> ${user.username}</p>
                <p><span>Role:</span> ${user.user_type}</p>
                <p><span>Join Date:</span> ${new Date(
                    user.created_at
                ).toLocaleDateString("en-US", {
                    month: "short",
                    day: "numeric",
                    year: "numeric",
                })}</p>
            </div>
        </td>
        <td>
            <span class="status-badge status-active">Active</span>
        </td>
        <td>
            <div class="action-buttons">
                <button class="edit-btn" title="Edit User" onclick="editUser(${
                    user.user_id
                })">
                    <i class="mdi mdi-pencil"></i>
                </button>
                <button class="delete-btn" title="Delete User" onclick="deleteUser(${
                    user.user_id
                })">
                    <i class="mdi mdi-delete"></i>
                </button>
            </div>
        </td>
    `;

    return tr;
}

function updateUserStats(userType, increment = 1) {
    const totalUsers = document.querySelector(
        ".stats-category:nth-child(1) .info-box-content span:last-child"
    );
    totalUsers.textContent = parseInt(totalUsers.textContent) + increment;

    if (userType === "Entrepreneur") {
        const totalEntrepreneurs = document.querySelector(
            ".stats-category:nth-child(2) .info-box-content span:last-child"
        );
        totalEntrepreneurs.textContent =
            parseInt(totalEntrepreneurs.textContent) + increment;
    } else if (userType === "Investor") {
        const totalInvestors = document.querySelector(
            ".stats-category:nth-child(3) .info-box-content span:last-child"
        );
        totalInvestors.textContent =
            parseInt(totalInvestors.textContent) + increment;
    }
}

function showNotification(message, type = "success") {
    const notification = document.createElement("div");
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}
