@extends('admin.layout')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="dashboard-title">
            <i class="mdi mdi-view-dashboard"></i>
            Dashboard
        </h1>
        <div class="dashboard-breadcrumb">
            <span>Home</span>
            <i class="mdi mdi-chevron-right"></i>
            <span>Dashboard</span>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <!-- Dashboard-specific content -->
        <div class="charts-container">
            <div class="chart-card main-chart">
                <h3>Overall Statistics</h3>
                <div class="chart-wrapper">
                    <canvas id="doughnutChart"></canvas>
                </div>
            </div>

            <div class="chart-card main-chart">
                <h3>User Growth Trends</h3>
                <div class="chart-wrapper">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Funding Progress</h3>
                <div class="chart-wrapper">
                    <canvas id="fundingChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Project Categories</h3>
                <div class="chart-wrapper">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <div class="charts-container">
            <div class="chart-card">
                <h3>Investment Trends</h3>
                <div class="chart-wrapper">
                    <canvas id="investmentTrendChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3>Success Rate by Category</h3>
                <div class="chart-wrapper">
                    <canvas id="successRateChart"></canvas>
                </div>
            </div>
        </div>

        <div class="stats-row">
            <!-- General Stats -->
            <div class="stats-category">
                <h4 class="category-title">
                    <i class="mdi mdi-chart-box"></i>General
                    Statistics
                </h4>
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span>Total Users</span>
                        <span>20</span>
                    </div>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-project-diagram"></i></span>
                    <div class="info-box-content">
                        <span>Total Projects</span>
                        <span>10</span>
                    </div>
                </div>
            </div>

            <!-- Entrepreneur Stats -->
            <div class="stats-category">
                <h4 class="category-title">
                    <i class="mdi mdi-account-tie"></i>Entrepreneur Statistics
                </h4>
                <div class="info-box">
                    <span class="info-box-icon bg-entrepreneur"><i class="fas fa-user-tie"></i></span>
                    <div class="info-box-content">
                        <span>Total Entrepreneurs</span>
                        <span>10</span>
                    </div>
                </div>
                <div class="info-box">
                    <span
                        class="info-box-icon bg-entrepreneur-secondary"><i class="fas fa-rocket"></i></span>
                    <div class="info-box-content">
                        <span>Active Projects</span>
                        <span>8</span>
                    </div>
                </div>
            </div>

            <!-- Investor Stats -->
            <div class="stats-category">
                <h4 class="category-title">
                    <i class="mdi mdi-cash"></i>Investor
                    Statistics
                </h4>
                <div class="info-box">
                    <span class="info-box-icon bg-investor"><i class="fas fa-hand-holding-usd"></i></span>
                    <div class="info-box-content">
                        <span>Total Investors</span>
                        <span>10</span>
                    </div>
                </div>
                <div class="info-box">
                    <span
                        class="info-box-icon bg-investor-secondary"><i class="fas fa-money-bill-wave"></i></span>
                    <div class="info-box-content">
                        <span>Total Investments</span>
                        <span>₱10M</span>
                    </div>
                </div>
            </div>

            <!-- Admin Stats -->
            <div class="stats-category">
                <h4 class="category-title">
                    <i class="mdi mdi-shield-account"></i>Admin
                    Statistics
                </h4>
                <div class="info-box">
                    <span class="info-box-icon bg-admin"><i class="fas fa-user-shield"></i></span>
                    <div class="info-box-content">
                        <span>Total Admins</span>
                        <span>5</span>
                    </div>
                </div>
                <div class="info-box">
                    <span
                        class="info-box-icon bg-admin-secondary"><i class="fas fa-tasks"></i></span>
                    <div class="info-box-content">
                        <span>Active Tasks</span>
                        <span>15</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<!-- Ensure Chart.js is included -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
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
</script>