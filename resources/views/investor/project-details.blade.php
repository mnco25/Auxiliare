
@extends('investor.layout')

@section('title', 'Project Details - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/investor/projects.css') }}">
@endsection

@section('content')
<div class="projects-wrapper">
    <div class="projects-container">
        <div class="project-details">
            <a href="{{ route('investor.projects') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>
            
            <div class="project-detail-card">
                <div class="project-header">
                    <div class="title-section">
                        <h2>{{ $project->title }}</h2>
                        <span class="category-badge">{{ $project->category }}</span>
                    </div>
                    <div class="status-badge {{ strtotime($project->end_date) < time() ? 'closed' : 'active' }}">
                        {{ strtotime($project->end_date) < time() ? 'Closed' : 'Active' }}
                    </div>
                </div>

                <div class="project-content">
                    <div class="description-section">
                        <h3>Project Description</h3>
                        <p>{{ $project->description }}</p>
                    </div>

                    <div class="funding-details">
                        <h3>Investment Details</h3>
                        <div class="funding-progress">
                            @php
                            $percentage = ($project->current_funding / $project->funding_goal) * 100;
                            $percentage = min(100, round($percentage));
                            @endphp
                            <div class="progress-bar">
                                <div class="progress" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="funding-stats">
                                <div class="stat-item">
                                    <span class="label">Raised</span>
                                    <span class="value">₱{{ number_format($project->current_funding) }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="label">Goal</span>
                                    <span class="value">₱{{ number_format($project->funding_goal) }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="label">Minimum Investment</span>
                                    <span class="value">₱{{ number_format($project->minimum_investment) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="action-section">
                        <button class="invest-btn primary">Invest in Project</button>
                        <button class="contact-entrepreneur">Contact Entrepreneur</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection