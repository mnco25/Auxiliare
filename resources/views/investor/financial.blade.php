@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Financial Overview</h1>
    <p>Current Balance: ${{ auth()->user()->balance }}</p>

    <form action="{{ route('investor.deposit') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="amount">Deposit Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Deposit</button>
    </form>
</div>
@endsection