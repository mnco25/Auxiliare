<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('admin.user_management');
    }
}
