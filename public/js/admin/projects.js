document.addEventListener("DOMContentLoaded", function () {
    // View Project Function
    window.viewProject = function(projectId) {
        fetch(`/admin/projects/${projectId}/view`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const project = data.project;
                const progress = project.funding_goal > 0
                    ? Math.min(100, (project.current_funding / project.funding_goal) * 100)
                    : 0;

                const modalBody = document.getElementById('projectModalBody');
                modalBody.innerHTML = `
                    <div class="pitch-details">
                        <div class="pitch-header">
                            <h2>${project.title}</h2>
                            <span class="status-badge status-${project.status.toLowerCase()}">${project.status}</span>
                        </div>

                        <div class="pitch-info-grid">
                            <div class="pitch-info-item">
                                <label><i class="fas fa-user"></i> Author:</label>
                                <span>${project.user.first_name} ${project.user.last_name}</span>
                            </div>
                            <div class="pitch-info-item">
                                <label><i class="fas fa-tag"></i> Category:</label>
                                <span>${project.category || 'N/A'}</span>
                            </div>
                            <div class="pitch-info-item">
                                <label><i class="fas fa-bullseye"></i> Funding Goal:</label>
                                <span>₱${parseFloat(project.funding_goal).toLocaleString()}</span>
                            </div>
                            <div class="pitch-info-item">
                                <label><i class="fas fa-money-bill-wave"></i> Current Funding:</label>
                                <span>₱${parseFloat(project.current_funding).toLocaleString()}</span>
                            </div>
                            <div class="pitch-info-item">
                                <label><i class="fas fa-calendar-alt"></i> Start Date:</label>
                                <span>${new Date(project.start_date).toLocaleDateString()}</span>
                            </div>
                            <div class="pitch-info-item">
                                <label><i class="fas fa-calendar-check"></i> End Date:</label>
                                <span>${new Date(project.end_date).toLocaleDateString()}</span>
                            </div>
                        </div>

                        <div class="pitch-progress">
                            <label>Funding Progress:</label>
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" style="width: ${progress}%">
                                    ${progress.toFixed(0)}%
                                </div>
                            </div>
                        </div>

                        <div class="pitch-description">
                            <label><i class="fas fa-file-alt"></i> Description:</label>
                            <p>${project.description}</p>
                        </div>

                        <div class="pitch-meta">
                            <small><i class="fas fa-clock"></i> Created: ${new Date(project.created_at).toLocaleString()}</small>
                            <small><i class="fas fa-sync"></i> Updated: ${new Date(project.updated_at).toLocaleString()}</small>
                        </div>
                    </div>
                `;

                document.getElementById('projectViewModal').style.display = 'block';
            } else {
                alert('Failed to load project details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load project details');
        });
    };

    // Close Project Modal
    window.closeProjectModal = function() {
        document.getElementById('projectViewModal').style.display = 'none';
    };

    // Delete Project Function
    window.deleteProject = function (projectId) {
        if (confirm("Are you sure you want to delete this project? This action cannot be undone.")) {
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
                    alert("Project successfully deleted!");
                    // Reload the page to refresh statistics and list
                    window.location.reload();
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

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('projectViewModal');
        if (event.target === modal) {
            closeProjectModal();
        }
    };
});