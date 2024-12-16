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
                    <i class="mdi mdi-chart-box"></i>General Statistics
                </h4>
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span>Total Users</span>
                        <span>{{ $stats['total_users'] }}</span>
                    </div>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-project-diagram"></i></span>
                    <div class="info-box-content">
                        <span>Total Projects</span>
                        <span>{{ $stats['total_projects'] }}</span>
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
                        <span>{{ $stats['entrepreneurs']['total'] }}</span>
                    </div>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-entrepreneur-secondary"><i class="fas fa-rocket"></i></span>
                    <div class="info-box-content">
                        <span>Active Projects</span>
                        <span>{{ $stats['entrepreneurs']['active_projects'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Investor Stats -->
            <div class="stats-category">
                <h4 class="category-title">
                    <i class="mdi mdi-cash"></i>Investor Statistics
                </h4>
                <div class="info-box">
                    <span class="info-box-icon bg-investor"><i class="fas fa-hand-holding-usd"></i></span>
                    <div class="info-box-content">
                        <span>Total Investors</span>
                        <span>{{ $stats['investors']['total'] }}</span>
                    </div>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-investor-secondary"><i class="fas fa-money-bill-wave"></i></span>
                    <div class="info-box-content">
                        <span>Total Investments</span>
                        <span>₱{{ number_format($stats['investors']['total_investments']) }}</span>
                    </div>
                </div>
            </div>

            <!-- Admin Stats -->
            <div class="stats-category">
                <h4 class="category-title">
                    <i class="mdi mdi-shield-account"></i>Admin Statistics
                </h4>
                <div class="info-box">
                    <span class="info-box-icon bg-admin"><i class="fas fa-user-shield"></i></span>
                    <div class="info-box-content">
                        <span>Total Admins</span>
                        <span>{{ $stats['admins']['total'] }}</span>
                    </div>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-admin-secondary"><i class="fas fa-tasks"></i></span>
                    <div class="info-box-content">
                        <span>Active Tasks</span>
                        <span>{{ $stats['admins']['active_tasks'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var statisticsData = {
        totalUsers: {{ $stats['total_users'] }},
        totalEntrepreneurs: {{ $stats['entrepreneurs']['total'] }},
        totalInvestors: {{ $stats['investors']['total'] }},
        totalProjects: {{ $stats['total_projects'] }},
        monthlyUserGrowth: @json($chartData['user_growth']),
    };
</script>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/admin-dashboard.js') }}"></script>