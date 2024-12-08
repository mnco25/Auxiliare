@extends('investor.layout')

@section('title', 'Financial Overview - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/entrepreneur/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/investor/financial.css') }}">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Stats Overview -->
        <div class="stats-row">
            <div class="stats-category">
                <h4 class="category-title">
                    <i class="fas fa-wallet"></i> Balance Overview
                </h4>
                <div class="info-box">
                    <span class="info-box-icon bg-primary">
                        <i class="fas fa-coins"></i>
                    </span>
                    <div class="info-box-content">
                        <span>Current Balance</span>
                        <span>₱{{ number_format($stats['current_balance'], 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="stats-category">
                <h4 class="category-title">
                    <i class="fas fa-chart-line"></i> Transaction Summary
                </h4>
                <div class="info-box">
                    <span class="info-box-icon bg-success">
                        <i class="fas fa-hand-holding-usd"></i>
                    </span>
                    <div class="info-box-content">
                        <span>Total Deposits</span>
                        <span>₱{{ number_format($stats['total_deposits'], 2) }}</span>
                    </div>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-info">
                        <i class="fas fa-chart-pie"></i>
                    </span>
                    <div class="info-box-content">
                        <span>Total Investments</span>
                        <span>₱{{ number_format($stats['total_investments'], 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="stats-category">
                <h4 class="category-title">
                    <i class="fas fa-clock"></i> Pending Activity
                </h4>
                <div class="info-box">
                    <span class="info-box-icon bg-warning">
                        <i class="fas fa-hourglass-half"></i>
                    </span>
                    <div class="info-box-content">
                        <span>Pending Transactions</span>
                        <span>{{ $stats['pending_transactions'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Charts -->
        <div class="charts-container">
            <div class="chart-card">
                <h3><i class="fas fa-chart-line"></i> Investment Growth</h3>
                <div class="chart-wrapper">
                    <canvas id="investmentGrowthChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h3><i class="fas fa-chart-pie"></i> Transaction Distribution</h3>
                <div class="chart-wrapper">
                    <canvas id="transactionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Monthly Summary Chart -->
        <div class="charts-container">
            <div class="chart-card">
                <h3><i class="fas fa-chart-bar"></i> Monthly Activity</h3>
                <div class="chart-wrapper">
                    <canvas id="monthlyActivityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Deposit Section -->
        <div class="action-row">
            <div class="deposit-card">
                <div class="card-header">
                    <h3><i class="fas fa-plus-circle"></i> Make a Deposit</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('investor.deposit') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="amount">Deposit Amount</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₱</span>
                                </div>
                                <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="0.01" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Submit Deposit
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Transaction History -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Transaction History</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment Method</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                    <td>{{ $transaction->transaction_type }}</td>
                                    <td class="{{ $transaction->transaction_type == 'Deposit' ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->transaction_type == 'Deposit' ? '+' : '-' }}₱{{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $transaction->transaction_status == 'Success' ? 'success' : ($transaction->transaction_status == 'Pending' ? 'warning' : 'danger') }}">
                                            {{ $transaction->transaction_status }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->payment_gateway }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No transactions found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .card {
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        margin-bottom: 1rem;
    }

    .table td,
    .table th {
        padding: .75rem;
        vertical-align: middle;
    }

    .badge {
        padding: .5em .75em;
    }

    .charts-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .chart-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 1.25rem;
        transition: transform 0.3s ease;
    }

    .chart-card:hover {
        transform: translateY(-5px);
    }

    .chart-card h3 {
        color: #1f2b77;
        font-size: 1.1rem;
        margin-bottom: 0.75rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chart-card h3 i {
        color: #3d5af1;
    }

    .chart-wrapper {
        position: relative;
        height: 280px;
        padding: 0.5rem;
    }

    @media (min-width: 1200px) {
        .charts-container {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .charts-container:nth-child(2) .chart-card {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 768px) {
        .charts-container {
            grid-template-columns: 1fr;
        }
        
        .chart-wrapper {
            height: 250px;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Common options for better tooltips
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            intersect: false,
            mode: 'index'
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    boxWidth: 12,
                    padding: 15,
                    font: {
                        size: 11
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) label += ': ';
                        if (context.parsed.y !== null) {
                            label += new Intl.NumberFormat('en-PH', {
                                style: 'currency',
                                currency: 'PHP'
                            }).format(context.parsed.y);
                        }
                        return label;
                    }
                }
            }
        }
    };

    // Investment Growth Chart
    new Chart(document.getElementById('investmentGrowthChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['months'] ?? []) !!},
            datasets: [{
                label: 'Investment Value',
                data: {!! json_encode($chartData['investments'] ?? []) !!},
                borderColor: "#3d5af1",
                tension: 0.3,
                fill: true,
                backgroundColor: "rgba(61, 90, 241, 0.1)",
                pointBackgroundColor: "#3d5af1",
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            ...commonOptions,
            aspectRatio: 2,
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 10
                        },
                        callback: value => '₱' + value.toLocaleString()
                    }
                }
            }
        }
    });

    // Transaction Distribution Chart with improved visuals
    new Chart(document.getElementById('transactionChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($chartData['transactionTypes'] ?? []) !!},
            datasets: [{
                data: {!! json_encode($chartData['transactionAmounts'] ?? []) !!},
                backgroundColor: [
                    "rgba(46, 204, 113, 0.8)",  // Deposits
                    "rgba(52, 152, 219, 0.8)",  // Investments
                    "rgba(155, 89, 182, 0.8)",  // Milestone
                    "rgba(241, 196, 15, 0.8)"   // Refunds
                ],
                borderColor: "#ffffff",
                borderWidth: 2
            }]
        },
        options: {
            ...commonOptions,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 15,
                        font: {
                            size: 11
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${context.label}: ₱${value.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Monthly Activity Chart with stacked bars
    new Chart(document.getElementById('monthlyActivityChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['months'] ?? []) !!},
            datasets: [{
                label: 'Deposits',
                data: {!! json_encode($chartData['deposits'] ?? []) !!},
                backgroundColor: "rgba(46, 204, 113, 0.7)",
                borderColor: "rgba(46, 204, 113, 1)",
                borderWidth: 1
            }, {
                label: 'Investments',
                data: {!! json_encode($chartData['monthlyInvestments'] ?? []) !!},
                backgroundColor: "rgba(52, 152, 219, 0.7)",
                borderColor: "rgba(52, 152, 219, 1)",
                borderWidth: 1
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                },
                y: {
                    stacked: false,
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 10
                        },
                        callback: value => '₱' + value.toLocaleString()
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection