@extends('investor.layout')

@section('title', 'Portfolio - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/investor/portfolio.css') }}">
<link rel="stylesheet" href="{{ asset('css/entrepreneur/home.css') }}">
@endsection

@section('content')
<div class="portfolio-container">
    <!-- Enhanced Portfolio Overview -->
    <div class="overview-header">
        <h1>Investment Portfolio</h1>
        <p class="subtitle">Track and manage your investments</p>
    </div>

    <div class="stats-grid">
        <!-- Total Investment Card -->
        <div class="stat-card primary">
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>  <!-- Using fas prefix -->
            </div>
            <div class="stat-content">
                <h3>Total Invested</h3>
                <div class="stat-value" data-value="{{ $totalInvested }}">
                    ₱{{ number_format($totalInvested, 2) }}
                </div>
                <p class="stat-label">Total capital invested</p>
            </div>
        </div>

        <!-- Active Investments Card -->
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-project-diagram"></i>  <!-- Changed from chart-network to project-diagram -->
            </div>
            <div class="stat-content">
                <h3>Active Investments</h3>
                <div class="stat-value" data-value="{{ $activeInvestments }}">
                    {{ $activeInvestments }}
                </div>
                <p class="stat-label">Current active projects</p>
            </div>
        </div>

        <!-- ROI Card -->
        <div class="stat-card info">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>  <!-- Using fas prefix -->
            </div>
            <div class="stat-content">
                <h3>Average ROI</h3>
                <div class="stat-value">
                    <span class="percentage" data-value="{{ $averageROI }}">
                        {{ number_format($averageROI, 1) }}%
                    </span>
                </div>
                <p class="stat-label">Return on investment</p>
            </div>
            <div class="trend-indicator positive">
                <i class="fas fa-arrow-up"></i>
                <span>2.5%</span>
            </div>
        </div>

        <!-- Returns Card -->
        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-coins"></i>  <!-- Using fas prefix -->
            </div>
            <div class="stat-content">
                <h3>Total Returns</h3>
                <div class="stat-value" data-value="{{ $totalReturns }}">
                    ₱{{ number_format($totalReturns, 2) }}
                </div>
                <p class="stat-label">Cumulative returns</p>
            </div>
            <div class="trend-indicator positive">
                <i class="fas fa-arrow-up"></i>
                <span>5.2%</span>
            </div>
        </div>
    </div>

    <!-- Investment List -->
    <div class="investments-card">
        <header class="card-header">
            <h2><i class="fas fa-list"></i> My Investments</h2>  <!-- Using fas prefix -->
            <div class="header-actions">
                <select id="statusFilter" class="filter-select">
                    <option value="">All Statuses</option>
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Refunded">Refunded</option>
                </select>
            </div>
        </header>

        <div class="investments-list">
            @forelse($investments as $investment)
            <div class="investment-item">
                <div class="investment-header">
                    <h3>{{ $investment->project->title }}</h3>
                    <span class="status-badge {{ strtolower($investment->investment_status) }}">
                        {{ $investment->investment_status }}
                    </span>
                </div>

                <div class="investment-details">
                    <div class="detail-group">
                        <label><i class="fas fa-money-bill"></i> Amount Invested:</label>
                        <span>₱{{ number_format($investment->investment_amount, 2) }}</span>
                    </div>
                    <div class="detail-group">
                        <label><i class="fas fa-calendar"></i> Investment Date:</label>
                        <span>{{ $investment->investment_date->format('M d, Y') }}</span>
                    </div>
                    <div class="detail-group">
                        <label><i class="fas fa-chart-bar"></i> Project Progress:</label>
                        <div class="progress-bar">
                            <div class="progress" style="width: {{ $investment->project->getProgressPercentage() }}%"></div>
                        </div>
                        <span>{{ $investment->project->getProgressPercentage() }}%</span>
                    </div>
                </div>

                <div class="investment-actions">
                    <a href="{{ route('investor.project.details', $investment->project_id) }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> View Project
                    </a>
                    <a href="{{ route('investor.messages.show', $investment->project->user_id) }}" class="btn btn-secondary">
                        <i class="fas fa-comment"></i> Contact Entrepreneur
                    </a>
                </div>
            </div>
            @empty
            <div class="no-investments">
                <i class="fas fa-folder-open"></i>
                <p>No investments found. Start investing in projects to build your portfolio!</p>
                <a href="{{ route('investor.projects') }}" class="btn btn-primary">Browse Projects</a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Add animated counter effect
function animateValue(element, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const current = Math.floor(progress * (end - start) + start);
        
        if (element.classList.contains('percentage')) {
            element.textContent = current.toFixed(1) + '%';
        } else {
            element.textContent = '₱' + current.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
        
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

// Animate all stat values on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.stat-value').forEach(stat => {
        const value = parseFloat(stat.dataset.value);
        if (!isNaN(value)) {
            animateValue(stat, 0, value, 2000);
        }
    });
    
    // Existing status filter code
    document.getElementById('statusFilter').addEventListener('change', function() {
        const status = this.value;
        const items = document.querySelectorAll('.investment-item');
        
        items.forEach(item => {
            if (!status || item.querySelector('.status-badge').textContent.trim() === status) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>
@endsection