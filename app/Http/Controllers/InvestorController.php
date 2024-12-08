<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('investor.projects');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
