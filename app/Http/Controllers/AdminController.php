<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function storeUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'user_type' => 'required|in:Entrepreneur,Investor',
            ]);

            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'user_type' => $validated['user_type'],
                'account_status' => 'Active',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success_message', 'Successfully logged out.');
    }
}
