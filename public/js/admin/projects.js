document.addEventListener("DOMContentLoaded", function () {
    window.deleteProject = function (projectId) {
        if (confirm("Are you sure you want to delete this project?")) {
            fetch(`/admin/projects/${projectId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                credentials: "same-origin"
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Find and remove the project row
                    const row = document.querySelector(`tr:has(button[onclick*="${projectId}"])`);
                    if (row) {
                        row.remove();
                        // Show success message
                        alert("Project successfully deleted!");
                        // Optionally reload the page to refresh statistics
                        window.location.reload();
                    }
                } else {
                    throw new Error(data.error || 'Failed to delete project');
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert(error.message || "Failed to delete project. Please try again.");
            });
        }
    };
});