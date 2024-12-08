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
            <span>45</span>
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
            <span>32</span>
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
            <span>10</span>
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
            <span>3</span>
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
              <tr>
                <td>2024-12-01</td>
                <td>
                  <p>Name: <strong>Jix</strong></p>
                  <p>Contact: 098733456171</p>
                </td>
                <td>Payment to Jix</td>
                <td>$50,000.00</td>
                <td class="completed">Completed</td>
              </tr>
              <tr>
                <td>2024-12-05</td>
                <td>
                  <p>Name: <strong>Jix</strong></p>
                  <p>Contact: 098733456171</p>
                </td>
                <td>Payment from Jix</td>
                <td>$10,000.00</td>
                <td class="pending">Pending</td>
              </tr>
              <tr>
                <td>2024-12-07</td>
                <td>
                  <p>Name: <strong>Marc</strong></p>
                  <p>Contact: 098733526171</p>
                </td>
                <td>Payment from Marc</td>
                <td>$200,000.00</td>
                <td class="completed">Completed</td>
              </tr>
              <tr>
                <td>2024-12-10</td>
                <td>
                  <p>Name: <strong>Dawn</strong></p>
                  <p>Contact: 09873892319</p>
                </td>
                <td>Payment to Dawn</td>
                <td>$150,000,000.00</td>
                <td class="failed">Failed</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection