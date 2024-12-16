document.addEventListener("DOMContentLoaded", function() {
    // Doughnut Chart Initialization
    const doughnutCtx = document
        .getElementById("doughnutChart")
        .getContext("2d");
    new Chart(doughnutCtx, {
        type: "doughnut",
        data: {
            labels: ["Users", "Entrepreneurs", "Investors", "Projects"],
            datasets: [{
                data: [20, 11, 9, 11],
                backgroundColor: [
                    "rgba(54, 162, 235, 0.8)",
                    "rgba(255, 99, 132, 0.8)",
                    "rgba(255, 206, 86, 0.8)",
                    "rgba(75, 192, 192, 0.8)",
                ],
                borderWidth: 1,
            }],
        },
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
    new Chart(barCtx, {
        type: "bar",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            datasets: [{
                label: "Active Users",
                data: [1200, 1500, 1000, 2000, 2500, 2300],
                backgroundColor: "rgba(54, 162, 235, 0.8)",
                borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 1,
            }],
        },
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
