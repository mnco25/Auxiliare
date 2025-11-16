@extends('admin.layout')

@section('styles')
@parent
<link rel="stylesheet" href="{{ asset('css/admin/project-modal.css') }}">
@endsection

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

        <!-- Recent Activity Section -->
        <div class="stats-row" style="margin-top: 30px;">
            <!-- Recent Users -->
            <div class="stats-category" style="width: 48%;">
                <div class="category-header">
                    <h4 class="category-title">
                        <i class="mdi mdi-account-multiple"></i>
                        Recent Users
                    </h4>
                </div>
                <div class="table-container">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentUsers as $user)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <i class="fas fa-user-circle"></i>
                                            <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($user->user_type) }}">
                                            {{ $user->user_type }}
                                        </span>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No recent users</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Pitches -->
            <div class="stats-category" style="width: 48%;">
                <div class="category-header">
                    <h4 class="category-title">
                        <i class="mdi mdi-briefcase"></i>
                        Recent Pitches
                    </h4>
                </div>
                <div class="table-container">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPitches as $pitch)
                                <tr>
                                    <td>
                                        <div class="project-info">
                                            <i class="fas fa-briefcase project-icon"></i>
                                            <span>{{ Str::limit($pitch->title, 30) }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $pitch->user->first_name }} {{ $pitch->user->last_name }}</td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($pitch->status) }}">
                                            {{ $pitch->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="view-btn" title="View Pitch" onclick="viewPitch({{ $pitch->id }})">
                                                <i class="mdi mdi-eye"></i>
                                            </button>
                                            <button class="delete-btn" title="Delete Pitch" onclick="deletePitch({{ $pitch->id }})">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No recent pitches</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pitch View Modal -->
<div id="pitchViewModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header">
            <h3><i class="mdi mdi-briefcase"></i> Pitch Details</h3>
            <span class="close" onclick="closePitchModal()">&times;</span>
        </div>
        <div class="modal-body" id="pitchModalBody">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

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