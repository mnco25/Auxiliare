<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntrepreneurController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if ($user->user_type !== 'Entrepreneur') {
            return redirect()->route('login')->with('error_message', 'Unauthorized access.');
        }
        return view('entrepreneur.dashboard', ['user' => $user]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
