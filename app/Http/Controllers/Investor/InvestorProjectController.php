<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class InvestorProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();
        
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $projects = $query->get();
        $categories = Project::distinct()->pluck('category');
        $totalProjects = $projects->count();
        $totalFundingNeeded = $projects->sum('funding_goal');

        return view('investor.projects', compact('projects', 'categories', 'totalProjects', 'totalFundingNeeded'));
    }

    public function show(Project $project)
    {
        return view('investor.project-details', compact('project'));
    }
}