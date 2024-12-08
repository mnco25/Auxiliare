@extends('entrepreneur.layout')

@section('title', 'Create Project - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/entrepreneur/create_project.css') }}">
@endsection

@section('content')
<div class="project-container">
    <div class="project-card">
        <header class="card-header">
            <h2><i class="fas fa-rocket"></i> Create New Project</h2>
            <hr>
        </header>
        <form action="{{ route('entrepreneur.store_project') }}" method="POST" class="project-form">
            @csrf
            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-info-circle"></i> Project Information</h3>
                <div class="form-group">
                    <label for="title"><i class="fas fa-heading"></i> Project Title</label>
                    <input type="text" id="title" name="title" required placeholder="Enter a clear, descriptive title">
                </div>
                <div class="form-group">
                    <label for="description"><i class="fas fa-align-left"></i> Project Description</label>
                    <textarea id="description" name="description" required
                        placeholder="Describe your project in detail. Include its purpose, goals, and potential impact."></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title"><i class="fas fa-calendar-alt"></i> Project Timeline & Funding</h3>
                <div class="form-row">
                    <div class="form-group half">
                        <label for="funding_goal"><i class="fas fa-coins"></i> Funding Goal</label>
                        <input type="number" id="funding_goal" name="funding_goal" required min="0" step="1000"
                            placeholder="Enter target amount in PHP">
                    </div>
                    <div class="form-group half">
                        <label for="category"><i class="fas fa-tag"></i> Category</label>
                        <select id="category" name="category" required>
                            <option value="" disabled selected>Select a category</option>
                            <option value="Technology">Technology</option>
                            <option value="Healthcare">Healthcare</option>
                            <option value="Education">Education</option>
                            <option value="Finance">Finance</option>
                            <option value="Environment">Environment</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group half">
                        <label for="start_date"><i class="fas fa-play"></i> Start Date</label>
                        <input type="date" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group half">
                        <label for="end_date"><i class="fas fa-flag-checkered"></i> End Date</label>
                        <input type="date" id="end_date" name="end_date" required>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-button">
                    <i class="fas fa-paper-plane"></i> Create Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Set minimum date as today for start_date and end_date
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('start_date').min = today;
    document.getElementById('end_date').min = today;

    // Update end_date minimum when start_date changes
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').min = this.value;
    });
</script>
@endsection