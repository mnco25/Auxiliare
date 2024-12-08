<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validate Input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->account_status === 'Active') {
                switch ($user->user_type) {
                    case 'Admin':
                        return redirect()->route('admin.dashboard');
                    case 'Entrepreneur':
                        return redirect()->route('entrepreneur.dashboard');
                    case 'Investor':
                        return redirect()->route('investor.dashboard');
                    default:
                        return redirect()->route('home');
                }
            }
            
            Auth::logout();
            return back()->with('error_message', 'Your account is not active.');
        }
        
        return back()->with('error_message', 'Invalid credentials.');
    }

    public function register(Request $request)
    {
        try {
            Log::info('Registration attempt with data:', $request->all());

            // Validate Input
            $validated = $request->validate([
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'user_type' => 'required|in:Entrepreneur,Investor,Admin',
            ], [
                'username.unique' => 'This username is already taken.',
                'email.unique' => 'This email is already registered.',
                'password.confirmed' => 'The passwords do not match.',
                'password.min' => 'Password must be at least 6 characters.',
                'user_type.in' => 'Please select a valid user type.'
            ]);

            // Create User
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'user_type' => $validated['user_type'],
                'account_status' => 'Active',
            ]);

            Log::info('User created:', ['user_id' => $user->user_id]);

            if (!$user) {
                throw new \Exception('Failed to create user');
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registration successful! Please login.'
                ]);
            }

            return redirect()->route('login')->with('success_message', 'Registration successful! Please login.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->validator->errors()->all()
                ], 422);
            }

            $errorMessage = implode("\n", $e->validator->errors()->all());
            return back()->with('error_message', $errorMessage)->withInput();
        } catch (\Exception $e) {
            Log::error('Registration failed:', ['error' => $e->getMessage()]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration failed: ' . $e->getMessage()
                ], 500);
            }

            return back()
                ->with('error_message', 'Registration failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login')->with('success_message', 'Successfully logged out.');
    }
}
