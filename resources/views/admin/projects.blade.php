@extends('admin.layout')

@section('styles')
<!-- Base Admin CSS -->
<link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
<!-- Projects specific CSS -->
<link rel="stylesheet" href="{{ asset('css/admin/projects.css') }}">
<!-- Material Design Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <h1 class="dashboard-title">
      <i class="fas fa-briefcase"></i> 
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
          <i class="fas fa-briefcase"></i>
          All Projects
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-primary"><i class="fas fa-project-diagram"></i></span>
          <div class="info-box-content">
            <span>Total Projects</span>
            <span>{{ $stats['total'] }}</span>
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
            <span>{{ $stats['active'] }}</span>
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
            <span>{{ $stats['pending'] }}</span>
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
            <span>{{ $stats['completed'] }}</span>
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
      </div>
      <div class="table-container">
        <div class="table-responsive" style="overflow-y: auto; height: 100%;">
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
              @forelse($projects as $project)
              <tr>
                <td>
                  <div class="project-info">
                    <i class="fas fa-briefcase project-icon"></i>
                    <span>{{ $project->title }}</span>
                  </div>
                </td>
                <td>
                  <p class="project-description">
                    {{ Str::limit($project->description, 100) }}
                  </p>
                </td>
                <td>
                  <div class="author-info">
                    <i class="fas fa-user-circle author-avatar"></i>
                    <span>{{ $project->user->first_name }} {{ $project->user->last_name }}</span>
                  </div>
                </td>
                <td>
                  <span class="status-badge status-{{ strtolower($project->status) }}">{{ $project->status }}</span>
                </td>
                <td>
                  <div class="progress-bar">
                    @php
                      $progress = ($project->current_funding / $project->funding_goal) * 100;
                      $progress = min(100, $progress);
                    @endphp
                    <div class="progress" style="width: {{ $progress }}%">{{ number_format($progress) }}%</div>
                  </div>
                </td>
                <td>
                  <div class="action-buttons">
                    <button class="edit-btn" title="Edit Project" onclick="editProject({{ $project->id }})">
                      <i class="mdi mdi-pencil"></i>
                    </button>
                    <button class="delete-btn" title="Delete Project" onclick="deleteProject({{ $project->id }})">
                        <i class="mdi mdi-delete"></i>
                    </button>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center">No projects found</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/projects.js') }}"></script>
@endsection