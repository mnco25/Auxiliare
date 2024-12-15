<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admin');
    }

    public function projects()
    {
        return view('admin.projects');
    }

    public function transactions()
    {
        return view('admin.transactions');
    }

    public function userManagement()
    {
        $totalUsers = User::count();
        $totalEntrepreneurs = User::where('user_type', 'Entrepreneur')->count();
        $totalInvestors = User::where('user_type', 'Investor')->count();
        $totalAdmins = User::where('user_type', 'Admin')->count();

        return view('admin.user_management', compact('totalUsers', 'totalEntrepreneurs', 'totalInvestors', 'totalAdmins'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success_message', 'Successfully logged out.');
    }
}
