@extends('investor.layout')

@section('title', 'Profile - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/entrepreneur/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/entrepreneur/home.css') }}">
<style>
    .main-header {
        position: relative;
        z-index: 3;
    }

    .content {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
</style>
@endsection

@section('content')
<div class="profile-wrapper">
    <div class="profile-banner">
        <div class="banner-content">
            <div class="banner-text">
                <h1>My Profile</h1>
                <p>Manage your personal information and settings</p>
            </div>
            <div class="banner-actions">
                <button id="edit-profile-btn" class="primary-btn">
                    <i class="fas fa-edit"></i> Edit Profile
                </button>
            </div>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-grid">
            <!-- Left Column -->
            <div class="profile-sidebar">
                <div class="profile-card main-info">
                    <div class="profile-pic-wrapper">
                        <div class="profile-pic-container">
                            @if($profile && $profile->profile_pic)
                                <img src="{{ asset('storage/profile_pictures/' . $profile->profile_pic) }}" 
                                     alt="Profile Picture" class="profile-pic" id="profile-pic">
                            @elseif($profile && $profile->profile_pic_url)
                                <img src="{{ $profile->profile_pic_url }}" 
                                     alt="Profile Picture" class="profile-pic" id="profile-pic">
                            @else
                                <div class="profile-pic profile-icon" id="profile-pic">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                            @endif
                        </div>
                        <div class="profile-status {{ $user->account_status === 'Active' ? 'active' : 'inactive' }}">
                            <i class="fas fa-circle"></i> {{ $user->account_status }}
                        </div>
                    </div>

                    <!-- Profile Info Card -->
                    <div class="profile-info-card">
                        <h2 id="profile-name">{{ $profile->name ?? auth()->user()->first_name . ' ' . auth()->user()->last_name }}</h2>
                        <div class="user-type-badge">{{ $user->user_type }}</div>
                        <p id="profile-location" class="location">
                            <i class="fas fa-map-marker-alt"></i> 
                            {{ $profile->location ?? 'Location not set' }}
                        </p>
                    </div>

                    <!-- Stats Section -->
                    <div class="stats-section">
                        <h3><i class="fas fa-chart-line"></i> Investment Overview</h3>
                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-project-diagram"></i></div>
                                <div class="stat-details">
                                    <span class="stat-value">{{ $investments_count ?? 0 }}</span>
                                    <span class="stat-label">Investments</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-coins"></i></div>
                                <div class="stat-details">
                                    <span class="stat-value">₱{{ number_format($total_invested ?? 0) }}</span>
                                    <span class="stat-label">Total Invested</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon"><i class="fas fa-chart-pie"></i></div>
                                <div class="stat-details">
                                    <span class="stat-value">{{ number_format($roi ?? 0, 1) }}%</span>
                                    <span class="stat-label">ROI</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                        <div class="action-buttons">
                            <a href="{{ route('investor.projects') }}" class="action-btn">
                                <i class="fas fa-search"></i> Browse Projects
                            </a>
                            <a href="{{ route('messages.conversations') }}" class="action-btn">
                                <i class="fas fa-envelope"></i> Messages
                                @if($unreadMessages ?? 0 > 0)
                                    <span class="badge">{{ $unreadMessages }}</span>
                                @endif
                            </a>
                            <a href="{{ route('investor.portfolio') }}" class="action-btn">
                                <i class="fas fa-chart-line"></i> View Portfolio
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column Content -->
            <div class="profile-content">
                <!-- About Section -->
                <div class="content-section">
                    <div class="section-header">
                        <h3><i class="fas fa-user"></i> About Me</h3>
                    </div>
                    <div class="section-body">
                        <p id="profile-bio" class="bio-text">{{ $profile->bio ?? 'No bio available' }}</p>
                    </div>
                </div>

                <!-- Skills Section -->
                <div class="content-section">
                    <div class="section-header">
                        <h3><i class="fas fa-tools"></i> Skills & Expertise</h3>
                    </div>
                    <div class="section-body">
                        <div id="profile-skills" class="skills-container">
                            @if(isset($profile->skills) && is_array($profile->skills))
                                @foreach($profile->skills as $skill)
                                    <span class="skill-tag">{{ $skill }}</span>
                                @endforeach
                            @else
                                <p class="no-data">No skills listed yet</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Account Details -->
                <div class="content-section">
                    <div class="section-header">
                        <h3><i class="fas fa-user-shield"></i> Account Information</h3>
                    </div>
                    <div class="section-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Username</span>
                                <span class="info-value">{{ $user->username }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email</span>
                                <span class="info-value">{{ $user->email }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Member Since</span>
                                <span class="info-value">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Account Status</span>
                                <span class="info-value status-badge {{ strtolower($user->account_status) }}">
                                    {{ $user->account_status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-overlay" class="hidden"></div>
<div id="edit-profile-modal" class="modal hidden">
    <div class="modal-content">
        <header class="modal-header">
            <h2><i class="fas fa-user-edit"></i> Edit Profile</h2>
            <button id="close-modal-btn" class="close-btn">&times;</button>
        </header>

        <form id="edit-profile-form" action="{{ route('investor.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-info-circle"></i> Basic Information</h3>
                <div class="form-group">
                    <label for="edit-name"><i class="fas fa-user"></i> Name</label>
                    <input type="text" id="edit-name" name="name" value="{{ $profile->name ?? '' }}" required>
                </div>
                <div class="form-group">
                    <label for="edit-location"><i class="fas fa-map-marker-alt"></i> Location</label>
                    <input type="text" id="edit-location" name="location" value="{{ $profile->location ?? '' }}" required>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-id-card"></i> Profile Details</h3>
                <div class="form-group">
                    <label for="edit-bio"><i class="fas fa-pen"></i> Bio</label>
                    <textarea id="edit-bio" name="bio" required>{{ $profile->bio ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="edit-interests"><i class="fas fa-lightbulb"></i> Investment Interests</label>
                    <input type="text" id="edit-interests" name="interests" value="{{ isset($profile->interests) && is_array($profile->interests) ? implode(', ', $profile->interests) : '' }}" required>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-camera"></i> Profile Picture</h3>
                <div class="profile-pic-options">
                    <div class="form-group">
                        <label for="edit-profile-pic"><i class="fas fa-upload"></i> Upload Image</label>
                        <input type="file" id="edit-profile-pic" name="profile_pic" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="profile-pic-url"><i class="fas fa-link"></i> Or Enter Image URL</label>
                        <input type="url" id="profile-pic-url" name="profile_pic_url" placeholder="https://example.com/image.jpg">
                    </div>
                </div>
            </div>

            <button type="submit" id="save-profile-btn" class="save-btn">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
@endsection