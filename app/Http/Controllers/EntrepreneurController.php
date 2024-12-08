<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntrepreneurController extends Controller
{
    public function home()
    {
        return view('entrepreneur.home');
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

        return redirect()->route('entrepreneur.home')
            ->with('success_message', 'Project created successfully!');
    }

    public function dashboard()
    {
        $projects = auth()->user()->projects;

        // Calculate statistics
        $totalProjects = $projects->count();
        $activeProjects = $projects->where('status', 'active')->count();
        $totalFunding = $projects->sum('current_funding');
        $avgFundingProgress = $projects->avg(function ($project) {
            return ($project->current_funding / $project->funding_goal) * 100;
        }) ?? 0;

        // Prepare funding chart data
        $fundingLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        $fundingData = $projects->pluck('current_funding')->toArray();

        // Prepare category chart data
        $categories = $projects->groupBy('category')
            ->map->count();
        $categoryLabels = $categories->keys();
        $categoryData = $categories->values();

        return view('entrepreneur.dashboard', compact(
            'projects',
            'totalProjects',
            'activeProjects',
            'totalFunding',
            'avgFundingProgress',
            'fundingLabels',
            'fundingData',
            'categoryLabels',
            'categoryData'
        ));
    }

    public function financial()
    {
        $projects = auth()->user()->projects;
        
        // Calculate basic financial metrics
        $totalRevenue = $projects->sum('revenue');
        $totalExpenses = $projects->sum('expenses');
        
        // Calculate monthly growth (example calculation)
        $lastMonth = $projects->sum('last_month_revenue');
        $currentMonth = $projects->sum('current_month_revenue');
        $monthlyGrowth = $lastMonth > 0 ? (($currentMonth - $lastMonth) / $lastMonth) * 100 : 0;
        
        // Calculate profit margin
        $profitMargin = $totalRevenue > 0 ? (($totalRevenue - $totalExpenses) / $totalRevenue) * 100 : 0;
        
        // Prepare monthly data for charts
        $monthlyRevenue = $projects->pluck('monthly_revenue')->flatten()->take(6);
        $monthlyExpenses = $projects->pluck('monthly_expenses')->flatten()->take(6);
        $cashFlow = collect($monthlyRevenue)->map(function($revenue, $key) use ($monthlyExpenses) {
            return $revenue - ($monthlyExpenses[$key] ?? 0);
        });
        
        // Get recent transactions
        $transactions = $projects->flatMap(function($project) {
            return $project->transactions;
        })->sortByDesc('created_at')->take(10);
    
        return view('entrepreneur.financial', compact(
            'totalRevenue',
            'totalExpenses',
            'monthlyGrowth',
            'profitMargin',
            'monthlyRevenue',
            'monthlyExpenses',
            'cashFlow',
            'transactions'
        ));
    }
}
