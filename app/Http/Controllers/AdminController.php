<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('admin.user_management');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success_message', 'Successfully logged out.');
    }
}
