@extends('investor.layout')

@section('title', "{$project->title} - Project Details")

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/investor/projects.css') }}">
<link rel="stylesheet" href="{{ asset('css/investor/project-details.css') }}">
<link rel="stylesheet" href="{{ asset('css/entrepreneur/home.css') }}">
@endsection

@section('content')
<div class="project-details-wrapper">
    <div class="project-details-container">
        <!-- Navigation Breadcrumb -->
        <div class="breadcrumb-nav">
            <a href="{{ route('investor.projects') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
            <div class="project-actions">
                <button class="btn-share" title="Share Project">
                    <i class="fas fa-share-alt"></i>
                </button>
                <button class="btn-bookmark" title="Bookmark Project">
                    <i class="far fa-bookmark"></i>
                </button>
            </div>
        </div>

        <!-- Project Header Section -->
        <div class="project-header-section">
            <div class="header-main">
                <div class="title-wrapper">
                    <h1>{{ $project->title }}</h1>
                    <div class="tags">
                        <span class="category-tag">{{ $project->category }}</span>
                        <span class="status-tag {{ strtotime($project->end_date) < time() ? 'closed' : 'active' }}">
                            {{ strtotime($project->end_date) < time() ? 'Closed' : 'Active' }}
                        </span>
                    </div>
                </div>
                <div class="project-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        Started: {{ $project->created_at->format('M d, Y') }}
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        Deadline: {{ date('M d, Y', strtotime($project->end_date)) }}
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-users"></i>
                        {{ $project->investors_count }} Investors
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Left Column -->
            <div class="main-content">
                <!-- Project Overview -->
                <section class="content-section">
                    <h2>Project Overview</h2>
                    <div class="rich-text-content">
                        {{ $project->description }}
                    </div>
                </section>

                <!-- Business Model -->
                <section class="content-section">
                    <h2>Business Model</h2>
                    <div class="rich-text-content">
                        {{ $project->business_model }}
                    </div>
                </section>

                <!-- Market Analysis -->
                <section class="content-section">
                    <h2>Market Analysis</h2>
                    <div class="rich-text-content">
                        {{ $project->market_analysis }}
                    </div>
                </section>

                <!-- Project Timeline -->
                <section class="content-section">
                    <h2>Project Timeline</h2>
                    <div class="timeline">
                        @if(isset($project->milestones) && is_iterable($project->milestones))
                            @foreach($project->milestones as $milestone)
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h3>{{ $milestone->title }}</h3>
                                        <p>{{ $milestone->description }}</p>
                                        <span class="timeline-date">{{ $milestone->due_date->format('M Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-timeline">
                                <p>No milestones have been added to this project yet.</p>
                            </div>
                        @endif
                    </div>
                </section>
            </div>

            <!-- Right Column -->
            <div class="side-content">
                <!-- Investment Card -->
                <div class="investment-card">
                    <div class="funding-progress">
                        @php
                            $percentage = ($project->current_funding / $project->funding_goal) * 100;
                            $percentage = min(100, round($percentage));
                        @endphp
                        <div class="progress-stats">
                            <span class="progress-percentage">{{ $percentage }}%</span>
                            <span class="funding-goal">of ₱{{ number_format($project->funding_goal) }}</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="funding-details">
                            <div class="funding-item">
                                <span class="label">Raised</span>
                                <span class="value">₱{{ number_format($project->current_funding) }}</span>
                            </div>
                            <div class="funding-item">
                                <span class="label">Minimum Investment</span>
                                <span class="value">₱{{ number_format($project->minimum_investment) }}</span>
                            </div>
                            <div class="funding-item">
                                <span class="label">Investors</span>
                                <span class="value">{{ $project->investors_count }}</span>
                            </div>
                        </div>
                    </div>

                    <button class="invest-btn primary" 
                            data-toggle="modal" 
                            data-target="#investmentModal"
                            data-project-id="{{ $project->id }}"
                            data-project-title="{{ $project->title }}"
                            data-min-investment="{{ $project->minimum_investment }}"
                            data-max-investment="{{ $project->funding_goal - $project->current_funding }}"
                            {{ strtotime($project->end_date) < time() ? 'disabled' : '' }}>
                        <i class="fas fa-hand-holding-usd"></i>
                        {{ strtotime($project->end_date) < time() ? 'Investment Closed' : 'Invest Now' }}
                    </button>
                </div>

                <!-- Entrepreneur Profile -->
                <div class="entrepreneur-card">
                    <h3>Project Lead</h3>
                    <div class="entrepreneur-profile">
                        <div class="profile-header">
                            <div class="avatar">
                                @if($project->user->avatar)
                                    <img src="{{ asset($project->user->avatar) }}" alt="Profile">
                                @else
                                    <i class="fas fa-user-circle"></i>
                                @endif
                            </div>
                            <div class="profile-info">
                                <h4>{{ $project->user->first_name }} {{ $project->user->last_name }}</h4>
                                <p>{{ $project->user->profession }}</p>
                            </div>
                        </div>
                        <div class="profile-stats">
                            <div class="stat-item">
                                <span class="label">Projects</span>
                                <span class="value">{{ $project->user->projects_count }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="label">Success Rate</span>
                                <span class="value">{{ $project->user->success_rate }}%</span>
                            </div>
                        </div>
                        <div class="profile-actions">
                            <a href="{{ route('messages.show', $project->user->user_id) }}" class="contact-btn">
                                <i class="fas fa-envelope"></i> Contact
                            </a>
                            <button class="view-profile-btn">View Full Profile</button>
                        </div>
                    </div>
                </div>

                <!-- Investment Documents -->
                <div class="documents-card">
                    <h3>Documents</h3>
                    <div class="document-list">
                        @if(isset($project->documents) && is_iterable($project->documents))
                            @foreach($project->documents as $document)
                                <a href="{{ asset($document->file_path) }}" class="document-item" target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                                    <span>{{ $document->title }}</span>
                                </a>
                            @endforeach
                        @else
                            <p class="no-documents">No documents available for this project.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Replace the existing investment modal with this optimized version -->
<div class="modal fade" id="investmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Invest in {{ $project->title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="investmentForm">
                    @csrf
                    <div class="form-group">
                        <label for="investmentAmount">Investment Amount (₱)</label>
                        <input 
                            type="number" 
                            class="form-control" 
                            id="investmentAmount" 
                            name="amount" 
                            required
                            step="1000"
                        >
                        <small class="text-muted">
                            Minimum investment: ₱{{ number_format($project->minimum_investment) }}<br>
                            Maximum investment: ₱{{ number_format($project->funding_goal - $project->current_funding) }}
                        </small>
                    </div>
                    <div class="balance-info">
                        Your current balance: ₱<span id="currentBalance">{{ number_format(auth()->user()->balance, 2) }}</span>
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

@endsection

@section('scripts')
<script src="{{ asset('js/investor/projects.js') }}"></script>
@endsection