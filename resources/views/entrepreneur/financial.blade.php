@extends('entrepreneur.layout')

@section('title', 'Financial - Auxiliare')

@section('additional_css')
<link rel="stylesheet" href="{{ asset('css/entrepreneur/financial.css') }}">
@endsection

@section('content')
<div class="financial-container">
    <!-- Financial Overview Stats -->
    <div class="stats-row">
        <div class="stats-category">
            <h4 class="category-title">
                <i class="fas fa-money-bill-wave"></i> Revenue Overview
            </h4>
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-hand-holding-usd"></i></span>
                <div class="info-box-content">
                    <span>Total Revenue</span>
                    <span>₱{{ number_format($totalRevenue) }}</span>
                </div>
            </div>
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span>Monthly Growth</span>
                    <span>{{ number_format($monthlyGrowth ?? 0) }}%</span>
                </div>
            </div>
        </div>

        <div class="stats-category">
            <h4 class="category-title">
                <i class="fas fa-file-invoice-dollar"></i> Expense Overview
            </h4>
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-receipt"></i></span>
                <div class="info-box-content">
                    <span>Total Expenses</span>
                    <span>₱{{ number_format($totalExpenses) }}</span>
                </div>
            </div>
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-percent"></i></span>
                <div class="info-box-content">
                    <span>Profit Margin</span>
                    <span>{{ number_format($profitMargin ?? 0) }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Simplified Financial Charts -->
    <div class="chart-section">
        <div class="chart-card">
            <h3>Cash Flow Analysis</h3>
            <div class="chart-wrapper">
                <canvas id="cashFlowChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Detailed Transactions with Enhanced Layout -->
    <div class="financial-card">
        <header class="card-header">
            <div class="header-content">
                <h2><i class="fas fa-list"></i> Recent Transactions</h2>
                <div class="transaction-summary">
                    <span class="total-income">Total Income: ₱{{ number_format($totalRevenue) }}</span>
                    <span class="total-expense">Total Expense: ₱{{ number_format($totalExpenses) }}</span>
                </div>
            </div>
            <hr>
        </header>
        <div class="transaction-list">
            @forelse($transactions ?? [] as $transaction)
            <div class="transaction-item">
                <div class="transaction-info">
                    <div class="transaction-main">
                        <span class="transaction-date">{{ $transaction->date }}</span>
                        <span class="transaction-description">{{ $transaction->description }}</span>
                    </div>
                    <span class="transaction-category">{{ $transaction->category ?? 'Uncategorized' }}</span>
                </div>
                <span class="transaction-amount {{ $transaction->type === 'income' ? 'income' : 'expense' }}">
                    {{ $transaction->type === 'income' ? '+' : '-' }}₱{{ number_format($transaction->amount) }}
                </span>
            </div>
            @empty
            <p class="no-transactions">No recent transactions found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Enhanced Cash Flow Chart
        new Chart(document.getElementById("cashFlowChart").getContext("2d"), {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                datasets: [{
                    label: "Cash Flow",
                    data: {!! json_encode($cashFlow ?? []) !!},
                    borderColor: "#3d5af1",
                    backgroundColor: "rgba(61, 90, 241, 0.1)",
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: "#ffffff",
                    pointBorderColor: "#3d5af1",
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { 
                        beginAtZero: true,
                        grid: {
                            color: "rgba(0, 0, 0, 0.05)"
                        }
                    },
                    x: {
                        grid: {
                            color: "rgba(0, 0, 0, 0.05)"
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endsection