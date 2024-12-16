<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'description' => 'required',
            'funding_goal' => 'required|numeric|min:0',
            'category' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['project_status'] = 'Draft';
        $validated['current_funding'] = 0.00;

        Project::create($validated);

        return redirect()->route('entrepreneur.home')->with('success', 'Project created successfully.');
    }

    public function dashboard()
    {
        $projects = auth()->user()->projects;
        return view('entrepreneur.dashboard', compact('projects'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'funding_goal' => 'required|numeric|min:0',
            'category' => 'required|in:Technology,Healthcare,Education,Finance,Environment'
        ]);

        $project->update($validated);
        return back()->with('success', 'Project updated successfully');
    }

    public function destroy(Project $project)
    {
        try {
            // Check if user is admin or owns the project
            if (auth()->user()->user_type === 'Admin' || 
                (auth()->user()->user_type === 'Entrepreneur' && $project->user_id === auth()->id())) {
                $project->delete();
                return response()->json(['success' => true]);
            }

            return response()->json(['error' => 'Unauthorized'], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete project'], 500);
        }
    }
}
