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
            <span>20</span>
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
            <span>8</span>
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
            <span>10</span>
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
            <span>2</span>
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
          <button class="add-user-btn">
            <i class="mdi mdi-account-plus"></i>
            Add User
          </button>
        </div>
      </div>
      <div class="table-container">
        <table>
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
            <tr>
              <td>
                <div class="user-avatar">
                  <img
                    src="../../assets/default-avatar.png"
                    alt="Profile"
                    class="profile-pic" />
                </div>
              </td>
              <td>
                <div class="user-info">
                  <h4>Dawn Smith</h4>
                  <p><i class="mdi mdi-phone"></i> 098733526171</p>
                  <p><i class="mdi mdi-email"></i> Dawn@gmail.com</p>
                </div>
              </td>
              <td>
                <div class="account-info">
                  <p><span>Username:</span> Dawn</p>
                  <p><span>Role:</span> Entrepreneur</p>
                  <p><span>Join Date:</span> Jan 15, 2024</p>
                </div>
              </td>
              <td>
                <span class="status-badge status-active">Active</span>
              </td>
              <td>
                <div class="action-buttons">
                  <button class="edit-btn" title="Edit User">
                    <i class="mdi mdi-pencil"></i>
                  </button>
                  <button class="delete-btn" title="Delete User">
                    <i class="mdi mdi-delete"></i>
                  </button>
                </div>
              </td>
            </tr>
            <!-- Add more user rows with the same structure -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection