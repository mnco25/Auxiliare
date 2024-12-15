@extends('investor.layout')

@section('title', 'Projects - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/investor/projects.css') }}">
<link rel="stylesheet" href="{{ asset('css/entrepreneur/home.css') }}">

@endsection

@section('content')
<div class="projects-wrapper">
    <div class="projects-container">
        <!-- Investment Overview Section -->
        <div class="stats-row">
            <div class="stats-category">
                <h4 class="category-title">
                    <i class="fas fa-chart-pie"></i> Investment Dashboard
                </h4>
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-rocket"></i></span>
                    <div class="info-box-content">
                        <span>Active Opportunities</span>
                        <span>{{ $totalProjects }}</span>
                    </div>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-hand-holding-usd"></i></span>
                    <div class="info-box-content">
                        <span>Total Investment Pool</span>
                        <span>₱{{ number_format($totalFundingNeeded) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Filters -->
        <div class="filter-section">
            <h4><i class="fas fa-filter"></i> Filter Projects</h4>
            <div class="category-filters">
                <button class="category-filter active" data-category="all">All Projects</button>
                @foreach($categories as $category)
                    <button class="category-filter" data-category="{{ $category }}">
                        {{ $category }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="projects-grid">
            @forelse($projects as $project)
            <div class="project-card">
                <div class="project-header">
                    <div class="title-section">
                        <h3>{{ $project->title }}</h3>
                        <span class="category-badge">{{ $project->category }}</span>
                    </div>
                    <div class="status-badge {{ strtotime($project->end_date) < time() ? 'closed' : 'active' }}">
                        {{ strtotime($project->end_date) < time() ? 'Closed' : 'Active' }}
                    </div>
                </div>

                <p class="description">{{ $project->description }}</p>

                <div class="investment-details">
                    <div class="detail-item">
                        <i class="fas fa-users"></i>
                        <span>Min. Investment: ₱{{ number_format($project->minimum_investment) }}</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ \Carbon\Carbon::parse($project->end_date)->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="funding-progress">
                    @php
                    $percentage = ($project->current_funding / $project->funding_goal) * 100;
                    $percentage = min(100, round($percentage));
                    @endphp
                    <div class="progress-info">
                        <span class="progress-label">Funding Progress</span>
                        <span class="progress-percentage">{{ $percentage }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress" style="width: {{ $percentage }}%"></div>
                    </div>
                    <div class="funding-stats">
                        <span>₱{{ number_format($project->current_funding) }} raised</span>
                        <span>of ₱{{ number_format($project->funding_goal) }} goal</span>
                    </div>
                </div>

                <div class="entrepreneur-info">
                    <img src="{{ $project->user->avatar ?? asset('assets/default-avatar.png') }}" alt="Entrepreneur" class="avatar">
                    <div class="info">
                        <span class="name">{{ $project->user->firstname }} {{ $project->user->lastname }}</span>
                        <span class="role">Project Lead</span>
                    </div>
                    <button class="contact-btn" title="Contact Entrepreneur">
                        <i class="fas fa-envelope"></i>
                    </button>
                </div>

                <div class="project-meta">
                    <div class="meta-info">
                        <span class="deadline">
                            <i class="fas fa-calendar-alt"></i>
                            Deadline: {{ date('M d, Y', strtotime($project->end_date)) }}
                        </span>
                    </div>
                    <button class="invest-btn" data-project-id="{{ $project->id }}" data-min-investment="{{ $project->minimum_investment }}">
                        <i class="fas fa-chart-line"></i> Invest Now
                    </button>
                </div>
            </div>
            @empty
            <div class="no-projects">
                <i class="fas fa-folder-open"></i>
                <p>No projects available for investment at this time.</p>
            </div>
            @endforelse
        </div>

        <!-- Investment Modal -->
        <div class="modal fade" id="investmentModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Make an Investment</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="investmentForm">
                            @csrf
                            <div class="form-group">
                                <label>Investment Amount (₱)</label>
                                <input type="number" name="amount" class="form-control" required>
                                <small class="text-muted">Minimum investment: ₱<span id="minInvestment"></span></small>
                            </div>
                            <div class="balance-info">
                                Your current balance: ₱<span id="currentBalance">{{ number_format(auth()->user()->balance) }}</span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmInvestment">Confirm Investment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.category-filter');
    const projectsGrid = document.querySelector('.projects-grid');
    const statsContent = document.querySelector('.stats-category');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', async function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const category = this.dataset.category;
            
            try {
                // Show loading state
                projectsGrid.style.opacity = '0.5';
                projectsGrid.style.pointerEvents = 'none';
                
                // Fetch filtered projects
                const response = await fetch(`/investor/filter-projects?category=${category}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data = await response.json();
                
                // Animate out old content
                projectsGrid.style.opacity = '0';
                
                // Update content
                setTimeout(() => {
                    projectsGrid.innerHTML = data.html;
                    
                    // Update stats
                    document.querySelector('.info-box-content span:last-child').textContent = data.totalProjects;
                    document.querySelector('.info-box:last-child .info-box-content span:last-child').textContent = 
                        '₱' + Number(data.totalFundingNeeded).toLocaleString();
                    
                    // Animate in new content
                    projectsGrid.style.opacity = '1';
                    projectsGrid.style.pointerEvents = 'auto';
                }, 300);
                
            } catch (error) {
                console.error('Error:', error);
                projectsGrid.style.opacity = '1';
                projectsGrid.style.pointerEvents = 'auto';
            }
        });
    });

    // Investment handling
    let currentProjectId = null;
    const investButtons = document.querySelectorAll('.invest-btn');
    const modal = document.getElementById('investmentModal');

    investButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            currentProjectId = this.dataset.projectId;
            const minInvestment = this.dataset.minInvestment;
            document.getElementById('minInvestment').textContent = minInvestment;
            document.querySelector('[name="amount"]').min = minInvestment;
            $('#investmentModal').modal('show');
        });
    });

    document.getElementById('confirmInvestment').addEventListener('click', async function() {
        const form = document.getElementById('investmentForm');
        const amount = form.querySelector('[name="amount"]').value;

        if (!amount || parseFloat(amount) <= 0) {
            alert('Please enter a valid investment amount');
            return;
        }

        try {
            const response = await fetch(`/investor/projects/${currentProjectId}/invest`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    amount: parseFloat(amount)
                })
            });

            const data = await response.json();

            if (data.success) {
                $('#investmentModal').modal('hide');
                alert('Investment successful!');
                window.location.reload();
            } else {
                alert(data.message || 'Investment failed');
            }
        } catch (error) {
            console.error('Investment error:', error);
            alert('An error occurred while processing your investment. Please try again.');
        }
    });

    // Amount input validation
    const amountInput = document.querySelector('[name="amount"]');
    amountInput.addEventListener('input', function() {
        const currentBalance = parseFloat(document.getElementById('currentBalance').textContent.replace(/[^0-9.-]+/g,""));
        const minInvestment = parseFloat(document.getElementById('minInvestment').textContent);

        if (parseFloat(this.value) > currentBalance) {
            this.setCustomValidity('Amount exceeds your current balance');
        } else if (parseFloat(this.value) < minInvestment) {
            this.setCustomValidity(`Minimum investment amount is ₱${minInvestment}`);
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>
@endsection