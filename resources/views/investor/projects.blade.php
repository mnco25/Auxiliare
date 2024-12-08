@extends('investor.layout')

@section('title', 'Projects - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/investor/projects.css') }}">
@endsection

@section('content')
<div class="projects-wrapper">
    <div class="projects-container">
        <!-- Statistics Section -->
        <div class="stats-row">
            <div class="stats-category">
                <h4 class="category-title">
                    <i class="fas fa-chart-pie"></i> Investment Overview
                </h4>
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="fas fa-briefcase"></i></span>
                    <div class="info-box-content">
                        <span>Available Projects</span>
                        <span>{{ $totalProjects }}</span>
                    </div>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
                    <div class="info-box-content">
                        <span>Total Investment Opportunities</span>
                        <span>₱{{ number_format($totalFundingNeeded) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects List -->
        <div class="projects-grid">
            @forelse($projects as $project)
            <div class="project-card">
                <div class="project-header">
                    <h3>{{ $project->title }}</h3>
                    <span class="category-badge">{{ $project->category }}</span>
                </div>

                <p class="description">{{ $project->description }}</p>

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
                    <img src="{{ asset('assets/default-avatar.png') }}" alt="Entrepreneur" class="avatar">
                    <div class="info">
                        <span class="name">{{ $project->user->firstname }} {{ $project->user->lastname }}</span>
                        <span class="email">{{ $project->user->email }}</span>
                    </div>
                </div>

                <div class="project-meta">
                    <span><i class="fas fa-calendar"></i> Ends: {{ date('M d, Y', strtotime($project->end_date)) }}</span>
                    <a href="#" class="invest-btn">Invest Now</a>
                </div>
            </div>
            @empty
            <div class="no-projects">
                <i class="fas fa-folder-open"></i>
                <p>No projects available for investment at this time.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection