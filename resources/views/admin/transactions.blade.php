@extends('admin.layout')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <h1 class="dashboard-title">
      <i class="mdi mdi-cash-multiple"></i>
      Transactions History
    </h1>
    <div class="dashboard-breadcrumb">
      <span>Home</span>
      <i class="mdi mdi-chevron-right"></i>
      <span>Transactions</span>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <!-- transactions Statistics -->
    <div class="stats-row">
      <div class="stats-category">
        <h4 class="category-title">
          <i class="mdi mdi-cash-multiple"></i>All transactions
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-primary"><i class="fas fa-exchange-alt"></i></span>
          <div class="info-box-content">
            <span>Total transactions</span>
            <span>{{ $stats['total'] }}</span>
          </div>
        </div>
      </div>

      <div class="stats-category">
        <h4 class="category-title">
          <i class="mdi mdi-check-circle"></i>Completed
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
          <div class="info-box-content">
            <span>Completed</span>
            <span>{{ $stats['completed'] }}</span>
          </div>
        </div>
      </div>

      <div class="stats-category">
        <h4 class="category-title">
          <i class="mdi mdi-clock-outline"></i>Pending
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
          <div class="info-box-content">
            <span>Pending</span>
            <span>{{ $stats['pending'] }}</span>
          </div>
        </div>
      </div>

      <div class="stats-category">
        <h4 class="category-title">
          <i class="mdi mdi-alert-circle"></i>Failed
        </h4>
        <div class="info-box">
          <span class="info-box-icon bg-danger"><i class="fas fa-times-circle"></i></span>
          <div class="info-box-content">
            <span>Failed</span>
            <span>{{ $stats['failed'] }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- transactions Table -->
    <div class="stats-category">
      <div class="category-header">
        <h4 class="category-title">
          <i class="mdi mdi-cash-multiple"></i>
          Transaction List
        </h4>
      </div>
      <div class="table-container">
        <div class="container11">
          <table>
            <thead>
              <tr>
                <th>Date</th>
                <th>Investor Information</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($transactions as $transaction)
              <tr>
                <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                <td>
                  <p><strong>{{ $transaction->user->first_name . ' ' . $transaction->user->last_name }}</strong></p>
                  <p>{{ $transaction->user->email }}</p>
                </td>
                <td>{{ $transaction->transaction_type }}</td>
                <td>₱{{ number_format($transaction->amount, 2) }}</td>
                <td class="{{ strtolower($transaction->transaction_status) }}">
                  {{ ucfirst($transaction->transaction_status) }}
                </td>
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
</section>
@endsection