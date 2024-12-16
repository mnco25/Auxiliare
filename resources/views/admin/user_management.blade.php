@extends('admin.layout')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <h1 class="dashboard-title">
      <i class="mdi mdi-account-group"></i>
      User Management
    </h1>
    <div class="dashboard-breadcrumb">
      <span>Home</span>
      <i class="mdi mdi-chevron-right"></i>
      <span>User Management</span>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <!-- User Statistics -->
    <div class="stats-row">
      <!-- General Stats -->
      <div class="stats-category">
        <h4 class="category-title">
          <i class="mdi mdi-account-multiple"></i>All Users
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
          <div class="info-box-content">
            <span>Total Users</span>
            <span>{{ $totalUsers }}</span>
          </div>
        </div>
      </div>

      <!-- Entrepreneur Stats -->
      <div class="stats-category">
        <h4 class="category-title">
          <i class="mdi mdi-briefcase-account"></i>Entrepreneurs
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-entrepreneur"><i class="fas fa-user-tie"></i></span>
          <div class="info-box-content">
            <span>Total Entrepreneurs</span>
            <span>{{ $totalEntrepreneurs }}</span>
          </div>
        </div>
      </div>

      <!-- Investor Stats -->
      <div class="stats-category">
        <h4 class="category-title">
          <i class="mdi mdi-cash-multiple"></i>Investors
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-investor"><i class="fas fa-hand-holding-usd"></i></span>
          <div class="info-box-content">
            <span>Total Investors</span>
            <span>{{ $totalInvestors }}</span>
          </div>
        </div>
      </div>

      <!-- Admin Stats -->
      <div class="stats-category">
        <h4 class="category-title">
          <i class="mdi mdi-shield-account"></i>Admins
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-admin"><i class="fas fa-user-shield"></i></span>
          <div class="info-box-content">
            <span>Total Admins</span>
            <span>{{ $totalAdmins }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- User List Table -->
    <div class="stats-category">
      <div class="category-header">
        <h4 class="category-title">
          <i class="mdi mdi-account-multiple"></i>
          User List
        </h4>
        <div class="header-actions">
          <div class="search-box">
            <i class="mdi mdi-magnify"></i>
            <input type="text" placeholder="Search users..." />
          </div>
          <button type="button" class="add-user-btn">
            <i class="mdi mdi-account-plus"></i>
            Add User
          </button>
        </div>
      </div>
      <div class="table-container">
        <table id="usersTable">
          <thead>
            <tr>
              <th width="10%">Profile</th>
              <th width="30%">User Information</th>
              <th width="30%">Account Details</th>
              <th width="20%">Status</th>
              <th width="10%">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $user)
            <tr data-user-id="{{ $user->user_id }}">
              <td>
                <div class="user-avatar">
                  @if($user->profile && ($user->profile->profile_pic || $user->profile->profile_pic_url))
                    <img src="{{ $user->profile->profile_pic ? asset('storage/profile_pictures/' . $user->profile->profile_pic) : $user->profile->profile_pic_url }}" 
                         alt="Profile" class="profile-pic">
                  @else
                    <div class="default-profile-icon">
                      <i class="mdi mdi-account"></i>
                    </div>
                  @endif
                </div>
              </td>
              <td>
                <div class="user-info">
                  <h4>{{ $user->first_name }} {{ $user->last_name }}</h4>
                  <p><i class="mdi mdi-email"></i> {{ $user->email }}</p>
                </div>
              </td>
              <td>
                <div class="account-info">
                  <p><span>Username:</span> {{ $user->username }}</p>
                  <p><span>Role:</span> {{ $user->user_type }}</p>
                  <p><span>Join Date:</span> {{ $user->created_at->format('M d, Y') }}</p>
                </div>
              </td>
              <td>
                <span class="status-badge status-{{ strtolower($user->account_status) }}">{{ $user->account_status }}</span>
              </td>
              <td>
                <div class="action-buttons">
                  <button class="edit-btn" title="Edit User" onclick="editUser({{ $user->user_id }})">
                    <i class="mdi mdi-pencil"></i>
                  </button>
                  <button class="delete-btn" title="Delete User" onclick="deleteUser({{ $user->user_id }})">
                    <i class="mdi mdi-delete"></i>
                  </button>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center">No users found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- User Registration Modal -->
<div id="userRegistrationModal" class="modal">
    <div class="modal-content card">
        <header class="card-header">
            <h2><i class="mdi mdi-account-plus"></i> Add New User</h2>
            <button type="button" id="closeModal" class="close">&times;</button>
        </header>
        <form class="card-body" action="{{ route('admin.users.store') }}" method="POST" id="userRegistrationForm">
            @csrf
            <div id="error-messages" class="alert alert-danger" style="display: none;"></div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="add-username">Username</label>
                    <i class="mdi mdi-account"></i>
                    <input type="text" id="add-username" name="username" placeholder="Enter username" class="form-control" required />
                </div>
                <div class="form-group">
                    <label for="add-email">Email</label>
                    <i class="mdi mdi-email"></i>
                    <input type="email" id="add-email" name="email" placeholder="Enter email" class="form-control" required />
                </div>
                <div class="form-group">
                    <label for="add-password">Password</label>
                    <i class="mdi mdi-lock"></i>
                    <input type="password" id="add-password" name="password" placeholder="Password" class="form-control" required />
                </div>
                <div class="form-group">
                    <label for="add-password-confirm">Confirm Password</label>
                    <i class="mdi mdi-lock-check"></i>
                    <input type="password" id="add-password-confirm" name="password_confirmation" placeholder="Confirm Password" class="form-control" required />
                </div>
                <div class="form-group">
                    <label for="add-firstname">First Name</label>
                    <i class="mdi mdi-account-details"></i>
                    <input type="text" id="add-firstname" name="first_name" placeholder="First Name" class="form-control" required />
                </div>
                <div class="form-group">
                    <label for="add-lastname">Last Name</label>
                    <i class="mdi mdi-account-details"></i>
                    <input type="text" id="add-lastname" name="last_name" placeholder="Last Name" class="form-control" required />
                </div>
                <div class="form-group">
                    <label for="add-role">Role</label>
                    <i class="mdi mdi-account-group"></i>
                    <select id="add-role" name="user_type" class="form-control" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="Entrepreneur">Entrepreneur</option>
                        <option value="Investor">Investor</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="document.getElementById('closeModal').click()">
                    Cancel
                </button>
                <button type="submit" class="save-btn" id="addUserSaveBtn">
                    <i class="mdi mdi-account-plus"></i> Add User
                </button>
            </div>
        </form>
    </div>
</div>

<!-- User Edit Modal -->
<div id="userEditModal" class="modal">
    <div class="modal-content card">
        <header class="card-header">
            <h2><i class="mdi mdi-account-edit"></i> Edit User</h2>
            <button type="button" id="closeEditModal" class="close">&times;</button>
        </header>
        <form class="card-body" id="userEditForm">
            @csrf
            <input type="hidden" name="user_id" id="editUserId">
            <div id="edit-error-messages" class="alert alert-danger" style="display: none;"></div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="edit-username">Username</label>
                    <i class="mdi mdi-account"></i>
                    <input type="text" id="edit-username" name="username" placeholder="Enter username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit-email">Email</label>
                    <i class="mdi mdi-email"></i>
                    <input type="email" id="edit-email" name="email" placeholder="Enter email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit-firstname">First Name</label>
                    <i class="mdi mdi-account-details"></i>
                    <input type="text" id="edit-firstname" name="first_name" placeholder="First Name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit-lastname">Last Name</label>
                    <i class="mdi mdi-account-details"></i>
                    <input type="text" id="edit-lastname" name="last_name" placeholder="Last Name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit-role">Role</label>
                    <i class="mdi mdi-account-group"></i>
                    <select id="edit-role" name="user_type" class="form-control">
                        <option value="" disabled selected>Select Role</option>
                        <option value="Entrepreneur">Entrepreneur</option>
                        <option value="Investor">Investor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit-status">Account Status</label>
                    <i class="mdi mdi-shield-account"></i>
                    <select id="edit-status" name="account_status" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Suspended">Suspended</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="document.getElementById('closeEditModal').click()">
                    Cancel
                </button>
                <button type="submit" class="save-btn">
                    <i class="mdi mdi-content-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/user_management.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" />
@endsection

@section('scripts')
<script src="{{ asset('js/admin/user_management.js') }}"></script>
@endsection