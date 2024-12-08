@extends('investor.layout')

@section('title', 'Project Details - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/investor/projects.css') }}">
@endsection

@section('content')
<div class="projects-wrapper">
    <div class="projects-container">
        <div class="project-details">
            <a href="{{ route('investor.projects') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Projects
            </a>

            <div class="project-detail-card">
                <div class="project-header">
                    <div class="title-section">
                        <h2>{{ $project->title }}</h2>
                        <span class="category-badge">{{ $project->category }}</span>
                    </div>
                    <div class="status-badge {{ strtotime($project->end_date) < time() ? 'closed' : 'active' }}">
                        {{ strtotime($project->end_date) < time() ? 'Closed' : 'Active' }}
                    </div>
                </div>

                <div class="project-content">
                    <div class="description-section">
                        <h3>Project Description</h3>
                        <p>{{ $project->description }}</p>
                    </div>

                    <div class="funding-details">
                        <h3>Investment Details</h3>
                        <div class="funding-progress">
                            @php
                            $percentage = ($project->current_funding / $project->funding_goal) * 100;
                            $percentage = min(100, round($percentage));
                            @endphp
                            <div class="progress-bar">
                                <div class="progress" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="funding-stats">
                                <div class="stat-item">
                                    <span class="label">Raised</span>
                                    <span class="value">₱{{ number_format($project->current_funding) }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="label">Goal</span>
                                    <span class="value">₱{{ number_format($project->funding_goal) }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="label">Minimum Investment</span>
                                    <span class="value">₱{{ number_format($project->minimum_investment) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="action-section">
                        <button class="invest-btn primary">Invest in Project</button>
                        <button class="contact-entrepreneur">Contact Entrepreneur</button>
                    </div>


                    <div class="modal fade" id="investmentModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Invest in {{ $project->title }}</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form id="investmentForm">
                                        @csrf
                                        <div class="form-group">
                                            <label>Investment Amount (₱)</label>
                                            <input type="number" name="amount" class="form-control"
                                                min="{{ $project->minimum_investment }}" step="100" required>
                                            <small class="text-muted">Minimum investment: ₱{{ number_format($project->minimum_investment) }}</small>
                                        </div>
                                        <div class="balance-info">
                                            Your current balance: ₱<span id="currentBalance">{{ number_format(auth()->user()->balance) }}</span>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="confirmInvestment">Confirm Investment</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @push('scripts')
                    <script>
                        document.getElementById('confirmInvestment').addEventListener('click', async function() {
                            const form = document.getElementById('investmentForm');
                            const amount = form.querySelector('[name="amount"]').value;

                            try {
                                const response = await fetch(`/projects/${@json($project->id)}/invest`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({
                                        amount
                                    })
                                });

                                const data = await response.json();

                                if (data.success) {
                                    // Update UI elements
                                    document.getElementById('currentBalance').textContent = number_format(data.new_balance);
                                    document.querySelector('.funding-stats .current-funding').textContent =
                                        '₱' + number_format(data.project_funding);

                                    // Close modal and show success message
                                    $('#investmentModal').modal('hide');
                                    toastr.success('Investment successful!');
                                } else {
                                    toastr.error(data.message);
                                }
                            } catch (error) {
                                toastr.error('An error occurred while processing your investment');
                            }
                        });
                    </script>
                    @endpush


                </div>
            </div>
        </div>
    </div>
</div>
@endsection