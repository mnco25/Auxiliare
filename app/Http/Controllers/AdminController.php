<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Project;
use App\Models\Transaction;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admin');
    }

    public function projects()
    {
        // Calculate project statistics
        $stats = [
            'total' => Project::count(),
            'active' => Project::where('status', 'Active')->count(),
            'pending' => Project::where('status', 'Pending')->count(),
            'completed' => Project::where('status', 'Completed')->count(),
        ];

        // Fetch projects
        $projects = Project::with('user')->latest()->get();

        // Pass 'stats' and 'projects' to the view
        return view('admin.projects', compact('stats', 'projects'));
    }

    public function transactions()
    {
        $stats = [
            'total' => Transaction::count(),
            'completed' => Transaction::where('transaction_status', 'completed')->count(),
            'pending' => Transaction::where('transaction_status', 'pending')->count(),
            'failed' => Transaction::where('transaction_status', 'failed')->count()
        ];

        $transactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.transactions', compact('stats', 'transactions'));
    }

    public function userManagement()
    {
        $totalUsers = User::count();
        $totalEntrepreneurs = User::where('user_type', 'Entrepreneur')->count();
        $totalInvestors = User::where('user_type', 'Investor')->count();
        $totalAdmins = User::where('user_type', 'Admin')->count();
        
        $users = User::with('profile')->orderBy('created_at', 'desc')->get();

        return view('admin.user_management', compact(
            'totalUsers', 
            'totalEntrepreneurs', 
            'totalInvestors', 
            'totalAdmins',
            'users'
        ));
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

    public function updateUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,user_id',
                'username' => 'required|unique:users,username,' . $request->user_id,
                'email' => 'required|email|unique:users,email,' . $request->user_id,
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'user_type' => 'required|in:Entrepreneur,Investor',
            ]);

            $user = User::findOrFail($validated['user_id']);
            $user->update([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'user_type' => $validated['user_type'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function deleteUser($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $userType = $user->user_type;
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully',
                'user_type' => $userType
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function getUser($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Validate the request
            $validated = $request->validate([
                'username' => 'sometimes|unique:users,username,' . $id . ',user_id',
                'email' => 'sometimes|email|unique:users,email,' . $id . ',user_id',
                'first_name' => 'sometimes|string|max:255',
                'last_name' => 'sometimes|string|max:255',
                'user_type' => 'sometimes|in:Entrepreneur,Investor',
                'account_status' => 'sometimes|in:Active,Inactive,Suspended',
            ]);

            // Update the user record
            $user->update($validated);

            // If status is updated, log the change
            if ($request->has('account_status') && $user->account_status !== $request->account_status) {
                DB::table('account_status_logs')->insert([
                    'user_id' => $user->user_id,
                    'previous_status' => $user->account_status,
                    'new_status' => $request->account_status,
                    'changed_by' => auth()->id(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'user' => $user
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
