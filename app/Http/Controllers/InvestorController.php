<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Transaction; // Ensure this line is present
use App\Models\User;
use App\Models\Profile; // Ensure this line is present

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
        $user_id = auth()->id();
        
        // Fetch basic stats
        $stats = [
            'current_balance' => $this->calculateBalance($user_id),
            'total_deposits' => Transaction::where('user_id', $user_id)
                ->where('transaction_type', 'Deposit')
                ->where('transaction_status', 'Success')
                ->sum('amount'),
            'total_investments' => Transaction::where('user_id', $user_id)
                ->where('transaction_type', 'Investment')
                ->where('transaction_status', 'Success')
                ->sum('amount'),
            'pending_transactions' => Transaction::where('user_id', $user_id)
                ->where('transaction_status', 'Pending')
                ->count()
        ];

        // Prepare chart data
        $chartData = [
            'months' => $this->getLast6Months(),
            'investments' => $this->getMonthlyData($user_id, 'Investment'),
            'deposits' => $this->getMonthlyData($user_id, 'Deposit'),
            'monthlyInvestments' => $this->getMonthlyData($user_id, 'Investment'),
            'transactionTypes' => ['Deposit', 'Investment', 'Milestone Payment', 'Refund'],
            'transactionAmounts' => $this->getTransactionTypeDistribution($user_id)
        ];

        $transactions = Transaction::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('investor.financial', compact('stats', 'chartData', 'transactions'));
    }

    private function getLast6Months()
    {
        return collect(range(5, 0))->map(function($i) {
            return now()->subMonths($i)->format('M Y');
        })->toArray();
    }

    private function getMonthlyData($user_id, $type)
    {
        return collect(range(5, 0))->map(function($i) use ($user_id, $type) {
            $month = now()->subMonths($i);
            return Transaction::where('user_id', $user_id)
                ->where('transaction_type', $type)
                ->where('transaction_status', 'Success')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
        })->toArray();
    }

    private function getTransactionTypeDistribution($user_id)
    {
        return collect(['Deposit', 'Investment', 'Milestone Payment', 'Refund'])
            ->map(function($type) use ($user_id) {
                return Transaction::where('user_id', $user_id)
                    ->where('transaction_type', $type)
                    ->where('transaction_status', 'Success')
                    ->sum('amount');
            })->toArray();
    }

    private function calculateBalance($user_id)
    {
        $deposits = Transaction::where('user_id', $user_id)
            ->where('transaction_type', 'Deposit')
            ->where('transaction_status', 'Success')
            ->sum('amount');
            
        $investments = Transaction::where('user_id', $user_id)
            ->whereIn('transaction_type', ['Investment', 'Milestone Payment'])
            ->where('transaction_status', 'Success')
            ->sum('amount');
            
        $refunds = Transaction::where('user_id', $user_id)
            ->where('transaction_type', 'Refund')
            ->where('transaction_status', 'Success')
            ->sum('amount');
            
        return $deposits - $investments + $refunds;
    }

    public function profile()
    {
        $user = Auth::user();
        $profile = $user->profile; // Assuming a 'profile' relationship exists on the User model

        return view('investor.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'bio' => 'required|string',
                'interests' => 'required|string',
                'profile_pic' => 'nullable|image|max:5120', // 5MB max
                'profile_pic_url' => 'nullable|url'
            ]);

            $user = Auth::user();
            $profile = Profile::where('user_id', $user->user_id)->first();

            if (!$profile) {
                $profile = new Profile(['user_id' => $user->user_id]);
            }

            $profile->name = $request->name;
            $profile->location = $request->location;
            $profile->bio = $request->bio;
            $profile->interests = array_map('trim', explode(',', $request->interests));

            // Handle profile picture upload
            if ($request->hasFile('profile_pic')) {
                if ($profile->profile_pic) {
                    Storage::disk('public')->delete('profile_pictures/' . $profile->profile_pic);
                }
                $fileName = time() . '_' . $request->file('profile_pic')->getClientOriginalName();
                $request->file('profile_pic')->storeAs('profile_pictures', $fileName, 'public');
                $profile->profile_pic = $fileName;
                $profile->profile_pic_url = null;
            } elseif ($request->profile_pic_url) {
                $profile->profile_pic_url = $request->profile_pic_url;
                $profile->profile_pic = null;
            }

            $profile->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
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
