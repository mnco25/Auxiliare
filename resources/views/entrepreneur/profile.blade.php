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
                @if($profile->profile_pic)
                <img src="{{ Storage::url('public/profile_pictures/' . $profile->profile_pic) }}" alt="Profile Picture" class="profile-pic" id="profile-pic">
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
            <h2>Edit Profile</h2>
            <button id="close-modal-btn" class="close-btn">&times;</button>
        </header>
        <form id="edit-profile-form" action="{{ route('entrepreneur.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="form-group">
                <label for="edit-name">Name</label>
                <input type="text" id="edit-name" name="name" value="{{ $profile->name ?? '' }}" required>
            </div>
            <div class="form-group">
                <label for="edit-location">Location</label>
                <input type="text" id="edit-location" name="location" value="{{ $profile->location ?? '' }}" required>
            </div>
            <div class="form-group">
                <label for="edit-bio">Bio</label>
                <textarea id="edit-bio" name="bio" required>{{ $profile->bio ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label for="edit-skills">Skills</label>
                <input type="text" id="edit-skills" name="skills" value="{{ is_array($profile->skills) ? implode(', ', $profile->skills) : '' }}" required>
            </div>
            <div class="form-group">
                <label for="edit-profile-pic">Profile Picture</label>
                <input type="file" id="edit-profile-pic" name="profile_pic" accept="image/*">
            </div>
            <button type="submit" id="save-profile-btn" class="save-btn">Save</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
@endsection