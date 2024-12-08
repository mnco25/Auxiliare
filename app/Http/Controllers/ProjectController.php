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
}
