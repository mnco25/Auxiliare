@extends('entrepreneur.layout')

@section('title', 'Dashboard - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/entrepreneur/dashboard.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    <div class="dashboard-card">
        <header class="card-header">
            <h2><i class="fas fa-tasks"></i> My Projects</h2>
            <hr>
        </header>

        <div class="projects-grid">
            @forelse($projects as $project)
            <div class="project-item" data-project-id="{{ $project->id }}">
                <div class="project-header">
                    <h3>{{ $project->title }}</h3>
                    <div class="project-actions">
                        <button class="edit-btn" onclick="enableEditing('{{ $project->id }}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="delete-btn" onclick="deleteProject('{{ $project->id }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <form class="project-form" id="form-{{ $project->id }}" style="display:none;"
                    action="{{ route('projects.update', $project->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label><i class="fas fa-heading"></i> Title</label>
                        <input type="text" name="title" value="{{ $project->title }}" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-align-left"></i> Description</label>
                        <textarea name="description" required>{{ $project->description }}</textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group half">
                            <label><i class="fas fa-coins"></i> Funding Goal</label>
                            <input type="number" name="funding_goal" value="{{ $project->funding_goal }}" required>
                        </div>
                        <div class="form-group half">
                            <label><i class="fas fa-tag"></i> Category</label>
                            <select name="category" required>
                                <option value="Technology" {{ $project->category == 'Technology' ? 'selected' : '' }}>Technology</option>
                                <option value="Healthcare" {{ $project->category == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                <option value="Education" {{ $project->category == 'Education' ? 'selected' : '' }}>Education</option>
                                <option value="Finance" {{ $project->category == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Environment" {{ $project->category == 'Environment' ? 'selected' : '' }}>Environment</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="save-btn">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <button type="button" class="cancel-btn" onclick="cancelEditing('{{ $project->id }}')">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>
                </form>

                <div class="project-content" id="content-{{ $project->id }}">
                    <p class="description">{{ $project->description }}</p>
                    <div class="project-meta">
                        <span><i class="fas fa-coins"></i> ₱{{ number_format($project->funding_goal) }}</span>
                        <span><i class="fas fa-tag"></i> {{ $project->category }}</span>
                        <span><i class="fas fa-calendar"></i> {{ date('M d, Y', strtotime($project->end_date)) }}</span>
                    </div>
                </div>
            </div>
            @empty
            <p>No projects found. <a href="{{ route('entrepreneur.create_project') }}">Create a new project</a>.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function enableEditing(projectId) {
        document.querySelector(`#content-${projectId}`).style.display = 'none';
        document.querySelector(`#form-${projectId}`).style.display = 'block';
    }

    function cancelEditing(projectId) {
        document.querySelector(`#form-${projectId}`).style.display = 'none';
        document.querySelector(`#content-${projectId}`).style.display = 'block';
    }

    function deleteProject(projectId) {
        if (confirm('Are you sure you want to delete this project?')) {
            fetch(`/projects/${projectId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(response => {
                if (response.ok) {
                    document.querySelector(`[data-project-id="${projectId}"]`).remove();
                }
            });
        }
    }
</script>
@endsection