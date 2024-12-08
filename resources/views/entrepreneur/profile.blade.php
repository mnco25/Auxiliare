@extends('entrepreneur.layout')

@section('title', 'Profile - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/entrepreneur/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-pic-container">
                @if($profile && $profile->profile_pic)
                <img src="{{ asset('storage/profile_pictures/' . $profile->profile_pic) }}" alt="Profile Picture" class="profile-pic" id="profile-pic">
                @elseif($profile && $profile->profile_pic_url)
                <img src="{{ $profile->profile_pic_url }}" alt="Profile Picture" class="profile-pic" id="profile-pic">
                @else
                <div class="profile-pic profile-icon" id="profile-pic">
                    <i class="fas fa-user-circle"></i>
                </div>
                @endif
            </div>
            <h2 id="profile-name">{{ $profile->name ?? '' }}</h2>
            <p id="profile-location">{{ $profile->location ?? '' }}</p>
        </div>

        <div class="profile-body">
            <div class="user-info-section">
                <h3>Account Information</h3>
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
                        <span class="info-label">First Name</span>
                        <span class="info-value">{{ $user->first_name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Last Name</span>
                        <span class="info-value">{{ $user->last_name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Role</span>
                        <span class="info-value role-badge">{{ $user->user_type }}</span>
                    </div>
                </div>
            </div>

            <h3>Bio</h3>
            <p id="profile-bio">{{ $profile->bio ?? '' }}</p>

            <h3>Skills</h3>
            <ul id="profile-skills">
                @if(is_array($profile->skills))
                @foreach($profile->skills as $skill)
                <li>{{ $skill }}</li>
                @endforeach
                @endif
            </ul>
        </div>
        <button id="edit-profile-btn" class="edit-btn">Edit Profile</button>
    </div>
</div>

<div id="modal-overlay" class="hidden"></div>
<div id="edit-profile-modal" class="modal hidden">
    <div class="modal-content">
        <header class="modal-header">
            <h2><i class="fas fa-user-edit"></i> Edit Profile</h2>
            <button id="close-modal-btn" class="close-btn">&times;</button>
        </header>
        <form id="edit-profile-form" action="{{ route('entrepreneur.profile.update') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="edit-skills"><i class="fas fa-tools"></i> Skills</label>
                    <input type="text" id="edit-skills" name="skills" value="{{ is_array($profile->skills) ? implode(', ', $profile->skills) : '' }}" required>
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