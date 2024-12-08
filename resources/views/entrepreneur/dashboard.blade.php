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
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/projects/${projectId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const projectElement = document.querySelector(`[data-project-id="${projectId}"]`);
                    projectElement.remove();
                } else {
                    alert(data.error || 'Failed to delete project');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete project. Please try again.');
            });
        }
    }
</script>
@endsection