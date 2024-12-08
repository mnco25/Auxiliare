<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EntrepreneurController;
use App\Http\Controllers\ProjectController;

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
});

// Include route files
require __DIR__ . '/admin.php';
require __DIR__ . '/entrepreneur.php';
