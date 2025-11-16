document.addEventListener("DOMContentLoaded", function() {
    // Doughnut Chart Initialization
    const doughnutCtx = document
        .getElementById("doughnutChart")
        .getContext("2d");
    // Use statisticsData variable from the updated structure
    const doughnutData = {
        labels: ["Users", "Entrepreneurs", "Investors", "Projects"],
        datasets: [{
            data: [
                statisticsData.totalUsers,
                statisticsData.totalEntrepreneurs,
                statisticsData.totalInvestors,
                statisticsData.totalProjects
            ],
            backgroundColor: [
                "rgba(54, 162, 235, 0.8)",
                "rgba(255, 99, 132, 0.8)",
                "rgba(255, 206, 86, 0.8)",
                "rgba(75, 192, 192, 0.8)",
            ],
            borderWidth: 1,
        }],
    };
    new Chart(doughnutCtx, {
        type: "doughnut",
        data: doughnutData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "bottom",
                },
            },
        },
    });

    // Bar Chart Initialization
    const barCtx = document.getElementById("barChart").getContext("2d");
    // Prepare data for Bar Chart using the updated monthlyUserGrowth
    const barLabels = Object.keys(statisticsData.monthlyUserGrowth);
    const barDataValues = Object.values(statisticsData.monthlyUserGrowth);
    const barData = {
        labels: barLabels,
        datasets: [{
            label: "Active Users",
            data: barDataValues,
            backgroundColor: "rgba(54, 162, 235, 0.8)",
            borderColor: "rgba(54, 162, 235, 1)",
            borderWidth: 1,
        }],
    };
    new Chart(barCtx, {
        type: "bar",
        data: barData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });

    // Funding Progress Chart
    const fundingCtx = document
        .getElementById("fundingChart")
        .getContext("2d");
    new Chart(fundingCtx, {
        type: "line",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            datasets: [{
                label: "Monthly Funding (₱ Millions)",
                data: [2.5, 3.2, 4.1, 3.8, 5.2, 6.0],
                borderColor: "rgba(46, 204, 113, 1)",
                tension: 0.4,
                fill: true,
                backgroundColor: "rgba(46, 204, 113, 0.1)",
            }],
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                },
            },
        },
    });

    // Project Categories Chart
    const categoryCtx = document
        .getElementById("categoryChart")
        .getContext("2d");
    new Chart(categoryCtx, {
        type: "polarArea",
        data: {
            labels: [
                "Technology",
                "Healthcare",
                "Education",
                "Finance",
                "Environment",
            ],
            datasets: [{
                data: [30, 25, 20, 15, 10],
                backgroundColor: [
                    "rgba(52, 152, 219, 0.7)",
                    "rgba(155, 89, 182, 0.7)",
                    "rgba(46, 204, 113, 0.7)",
                    "rgba(230, 126, 34, 0.7)",
                    "rgba(241, 196, 15, 0.7)",
                ],
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "right"
                },
            },
        },
    });

    // Investment Trends Chart
    const investmentTrendCtx = document
        .getElementById("investmentTrendChart")
        .getContext("2d");
    new Chart(investmentTrendCtx, {
        type: "bar",
        data: {
            labels: ["Q1", "Q2", "Q3", "Q4"],
            datasets: [{
                    label: "Investment Volume",
                    data: [150, 230, 180, 320],
                    backgroundColor: "rgba(52, 152, 219, 0.7)",
                },
                {
                    label: "Number of Investors",
                    data: [45, 65, 55, 85],
                    backgroundColor: "rgba(46, 204, 113, 0.7)",
                },
            ],
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                },
            },
        },
    });

    // Success Rate Chart
    const successRateCtx = document
        .getElementById("successRateChart")
        .getContext("2d");
    new Chart(successRateCtx, {
        type: "radar",
        data: {
            labels: ["Tech", "Health", "Edu", "Finance", "Env"],
            datasets: [{
                label: "Success Rate %",
                data: [85, 75, 90, 65, 70],
                backgroundColor: "rgba(52, 152, 219, 0.2)",
                borderColor: "rgba(52, 152, 219, 1)",
                pointBackgroundColor: "rgba(52, 152, 219, 1)",
            }],
        },
        options: {
            responsive: true,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                },
            },
        },
    });

    document
        .querySelector(".sidebar-toggle")
        .addEventListener("click", () => {
            document.body.classList.toggle("sidebar-collapsed");
        });

    // Enhanced sidebar toggle functionality
    document
        .querySelector(".sidebar-toggle")
        .addEventListener("click", function() {
            document.body.classList.toggle("sidebar-collapsed");
            // Store preference
            localStorage.setItem(
                "sidebarCollapsed",
                document.body.classList.contains("sidebar-collapsed")
            );
        });

    // Restore sidebar state on page load
    if (localStorage.getItem("sidebarCollapsed") === "true") {
        document.body.classList.add("sidebar-collapsed");
    }
});

// View Pitch Function
window.viewPitch = function(pitchId) {
    fetch(`/admin/projects/${pitchId}/view`, {
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

            const modalBody = document.getElementById('pitchModalBody');
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

            document.getElementById('pitchViewModal').style.display = 'block';
        } else {
            alert('Failed to load pitch details');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to load pitch details');
    });
};

// Close Pitch Modal
window.closePitchModal = function() {
    document.getElementById('pitchViewModal').style.display = 'none';
};

// Delete Pitch Function
window.deletePitch = function(pitchId) {
    if (confirm('Are you sure you want to delete this pitch? This action cannot be undone.')) {
        fetch(`/admin/projects/${pitchId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pitch deleted successfully!');
                // Reload the page to refresh the list
                window.location.reload();
            } else {
                alert(data.error || 'Failed to delete pitch');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete pitch. Please try again.');
        });
    }
};

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('pitchViewModal');
    if (event.target === modal) {
        closePitchModal();
    }
};
