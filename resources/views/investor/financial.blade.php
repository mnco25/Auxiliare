@extends('investor.layout')

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Financial Overview Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Current Balance</h5>
                        <h3 class="mb-0">₱{{ number_format($stats['current_balance'], 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Deposits</h5>
                        <h3 class="mb-0">₱{{ number_format($stats['total_deposits'], 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Investments</h5>
                        <h3 class="mb-0">₱{{ number_format($stats['total_investments'], 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Pending Transactions</h5>
                        <h3 class="mb-0">{{ $stats['pending_transactions'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deposit Form -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Make a Deposit</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <form action="{{ route('investor.deposit') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₱</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="0.01" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Deposit</button>
                        </form>
                    </div>
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
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        margin-bottom: 1rem;
    }
    .table td, .table th {
        padding: .75rem;
        vertical-align: middle;
    }
    .badge {
        padding: .5em .75em;
    }
</style>
@endsection