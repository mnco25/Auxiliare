<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntrepreneurController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\Investor\InvestorProjectController;

// Public routes
Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
});

Route::get('/pricing', function () {
    return view('pricing');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(base_path('routes/admin.php'));

// Entrepreneur routes
Route::middleware(['auth', 'entrepreneur'])->prefix('entrepreneur')->group(function () {
    Route::get('/home', [EntrepreneurController::class, 'home'])->name('entrepreneur.home');
    // ...other entrepreneur routes...
    require base_path('routes/entrepreneur.php');
});

Route::resource('projects', ProjectController::class)->except(['index']);

Route::middleware(['auth', 'entrepreneur'])->group(function () {
    Route::get('/dashboard', [EntrepreneurController::class, 'dashboard'])->name('entrepreneur.dashboard');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::get('/financial', [EntrepreneurController::class, 'financial'])->name('entrepreneur.financial');
    Route::get('/entrepreneur/profile', [ProfileController::class, 'show'])->name('entrepreneur.profile');
    Route::post('/entrepreneur/profile/update', [ProfileController::class, 'update'])->name('entrepreneur.profile.update');
});

// Include route files
require __DIR__ . '/admin.php';
require __DIR__ . '/entrepreneur.php';

Route::middleware(['auth'])->group(function () {
    // ...existing routes...
    Route::post('/entrepreneur/profile/update', [ProfileController::class, 'update'])->name('entrepreneur.profile.update');
});

// Investor routes
Route::middleware(['auth', 'investor'])->prefix('investor')->group(function () {
    Route::get('/home', [InvestorController::class, 'home'])->name('investor.home');
    Route::get('/projects', [InvestorProjectController::class, 'index'])->name('investor.projects');
    Route::get('/projects/{project}', [InvestorProjectController::class, 'show'])->name('investor.project.details');
    Route::get('/portfolio', [InvestorController::class, 'portfolio'])->name('investor.portfolio');
    Route::get('/financial', [InvestorController::class, 'financial'])->name('investor.financial');
    Route::get('/profile', [InvestorController::class, 'profile'])->name('investor.profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('investor.logout');
    Route::get('/filter-projects', [InvestorProjectController::class, 'filterProjects'])->name('investor.filter.projects');
    Route::get('/investor/portfolio', function () {
        return view('investor.portfolio');
    });
});