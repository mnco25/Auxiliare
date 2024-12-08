
@forelse($projects as $project)
<div class="project-card" style="opacity: 0; animation: fadeIn 0.3s forwards">
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
        <a href="{{ route('investor.project.details', $project->id) }}" class="invest-btn">
            <i class="fas fa-chart-line"></i> Invest Now
        </a>
    </div>
</div>
@empty
<div class="no-projects">
    <i class="fas fa-folder-open"></i>
    <p>No projects available for this category.</p>
</div>
@endforelse