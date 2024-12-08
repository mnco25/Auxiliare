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

    public function createProject()
    {
        $user = Auth::user();
        if ($user->user_type !== 'Entrepreneur') {
            return redirect()->route('login')->with('error_message', 'Unauthorized access.');
        }
        return view('entrepreneur.create_project');
    }

    public function storeProject(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'funding_goal' => 'required|numeric|min:0',
            'category' => 'required|string|in:Technology,Healthcare,Education,Finance,Environment',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // TODO: Add project storage logic here
        
        return redirect()->route('entrepreneur.dashboard')
            ->with('success_message', 'Project created successfully!');
    }
}
