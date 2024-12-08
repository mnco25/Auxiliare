<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Transaction; // Ensure this line is present
use App\Models\User;

class InvestorController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $firstname = $user->first_name ?? 'Investor';
        return view('investor.home', compact('firstname'));
    }

    public function portfolio()
    {
        return view('investor.portfolio');
    }

    public function financial()
    {
        return view('investor.financial');
    }

    public function profile()
    {
        return view('investor.profile');
    }

    public function projects()
    {
        $projects = Project::with('user')->get();
        $totalProjects = $projects->count();
        $totalFundingNeeded = $projects->sum('funding_goal');

        return view('investor.projects', compact('projects', 'totalProjects', 'totalFundingNeeded'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $user = auth()->user();
        $amount = $request->input('amount');

        // Create a new transaction
        Transaction::create([
            'investment_id' => null, // or appropriate investment_id
            'user_id' => $user->user_id, // Ensure this is set correctly
            'amount' => $amount,
            'transaction_type' => 'Deposit',
            'transaction_status' => 'Success',
            'payment_gateway' => 'YourPaymentGateway', // or appropriate value
        ]);

        // Update user's balance
        $user->balance += $amount;
        $user->save();

        return redirect()->route('investor.financial')->with('success', 'Deposit successful.');
    }
}
