@extends('admin.layout')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <h1 class="dashboard-title">
      <i class="fas fa-briefcase"></i> <!-- Changed from mdi to fas -->
      Project Management
    </h1>
    <div class="dashboard-breadcrumb">
      <span>Home</span>
      <i class="mdi mdi-chevron-right"></i>
      <span>Projects</span>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <!-- Project Statistics -->
    <div class="stats-row">
      <div class="stats-category">
        <h4 class="category-title">
          <i class="fas fa-briefcase"></i> <!-- Changed from mdi to fas -->
          All Projects
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-primary"><i class="fas fa-project-diagram"></i></span>
          <div class="info-box-content">
            <span>Total Projects</span>
            <span>15</span>
          </div>
        </div>
      </div>

      <div class="stats-category">
        <h4 class="category-title">
          <i class="mdi mdi-check-circle"></i>Active Projects
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fas fa-tasks"></i></span>
          <div class="info-box-content">
            <span>Active</span>
            <span>8</span>
          </div>
        </div>
      </div>

      <div class="stats-category">
        <h4 class="category-title">
          <i class="mdi mdi-clock-outline"></i>Pending Projects
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-hourglass-half"></i></span>
          <div class="info-box-content">
            <span>Pending</span>
            <span>5</span>
          </div>
        </div>
      </div>

      <div class="stats-category">
        <h4 class="category-title">
          <i class="mdi mdi-check-all"></i>Completed Projects
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-flag-checkered"></i></span>
          <div class="info-box-content">
            <span>Completed</span>
            <span>2</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Projects List Table -->
    <div class="stats-category">
      <div class="category-header">
        <h4 class="category-title">
          <i class="mdi mdi-briefcase"></i>
          Projects List
        </h4>
        <div class="header-actions">
          <div class="search-box">
            <i class="mdi mdi-magnify"></i>
            <input type="text" placeholder="Search projects..." />
          </div>
          <button class="add-user-btn">
            <i class="mdi mdi-briefcase-plus"></i>
            Add Project
          </button>
        </div>
      </div>
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th width="20%">Project</th>
              <th width="25%">Description</th>
              <th width="15%">Author</th>
              <th width="15%">Status</th>
              <th width="15%">Progress</th>
              <th width="10%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="project-info">
                  <img
                    src="../../assets/project-icon.png"
                    alt="Project"
                    class="project-icon" />
                  <span>E-Commerce Platform</span>
                </div>
              </td>
              <td>
                <p class="project-description">
                  Online marketplace for local artisans
                </p>
              </td>
              <td>
                <div class="author-info">
                  <img
                    src="../../assets/default-avatar.png"
                    alt="Author"
                    class="author-avatar" />
                  <span>John Doe</span>
                </div>
              </td>
              <td>
                <span class="status-badge status-active">In Progress</span>
              </td>
              <td>
                <div class="progress-bar">
                  <div class="progress" style="width: 75%">75%</div>
                </div>
              </td>
              <td>
                <div class="action-buttons">
                  <button class="edit-btn" title="Edit Project">
                    <i class="mdi mdi-pencil"></i>
                  </button>
                  <button class="delete-btn" title="Delete Project">
                    <i class="mdi mdi-delete"></i>
                  </button>
                </div>
              </td>
            </tr>
            <!-- Add more project rows with the same structure -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const toggleBtn = document.querySelector("#toggle-menu");
    if (toggleBtn) {
      toggleBtn.addEventListener("click", function() {
        document.body.classList.toggle("sidebar-collapsed");
      });
    }

    if (localStorage.getItem("sidebarCollapsed") === "true") {
      document.body.classList.add("sidebar-collapsed");
    }
  });

  // Modal functionality
  const addUserBtn = document.querySelector(".add-user-btn");
  const modal = document.getElementById("addUserModal");
  const closeModal = document.getElementById("closeModal");

  addUserBtn.onclick = () => (modal.style.display = "block");

  closeModal.onclick = () => (modal.style.display = "none");

  window.onclick = (event) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  };
</script>
@endsection