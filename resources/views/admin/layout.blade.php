<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Admin - Auxiliare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    @section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/transactions.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/user_management.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" />
    <!-- Material Design Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @show
</head>

<body class="layout-fixed">
    <div class="wrapper">
        <!-- Enhanced Sidebar -->
        <aside class="main-sidebar">
            <div class="brand-wrapper">
                <img src="{{ asset('assets/logo.png') }}" alt="Auxiliare Logo" class="brand-logo" />
                <span class="brand-text">Admin Panel</span>
            </div>
            <div class="sidebar-wrapper">
                <div class="user-panel">
                    <i class="fas fa-user-circle user-avatar"></i>
                    <div class="user-info">
                        <span class="user-name">Admin User</span>
                        <span class="user-role">Administrator</span>
                    </div>
                </div>
                <nav class="sidebar-nav">
                    <ul>
                        <li class="nav-header">MAIN NAVIGATION</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.user_management') }}" class="nav-link">
                                <i class="mdi mdi-account-group"></i>
                                <span>User Management</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.projects') }}" class="nav-link">
                                <i class="mdi mdi-briefcase"></i>
                                <span>Projects</span>
                            </a>
                        </li>
                        <li class="nav-header">ANALYTICS</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.transactions') }}" class="nav-link">
                                <i class="mdi mdi-cash-multiple"></i>
                                <span>Transactions</span>
                            </a>
                        </li>
                        <li class="nav-header">ACCOUNT</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        <footer class="main-footer">
            <strong>Copyright © 2024
                <a href="#">AUXILIARE | All Rights Reserved </a>. </strong>All rights reserved.
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Doughnut Chart
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
                }, ],
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

        // Bar Chart
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
                }, ],
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
                }, ],
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
                }, ],
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
                }, ],
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
    </script>
    @section('scripts')
    @show

    @yield('scripts') <!-- Ensure this line is present before </body> -->
    <script src="{{ asset('js/admin/mobile-sidebar.js') }}"></script>
</body>

    @yield('scripts') <!-- Ensure this line is present before </body> -->
</html>
</body>

</html>