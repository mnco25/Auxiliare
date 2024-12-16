<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Project::count(),
            'active' => Project::where('status', 'Active')->count(),
            'pending' => Project::where('status', 'Pending')->count(),
            'completed' => Project::where('status', 'Completed')->count(),
        ];

        $projects = Project::with('user')->latest()->get();

        return view('admin.projects', compact('stats', 'projects'));
    }
}
