<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AuthAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('home'); // Added name 'home'

Route::get('/about', function () {
    return view('about');
});

Route::get('/pricing', function () {
    return view('pricing');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Handle login form submission
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Handle registration form submission
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // ...existing admin routes...
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// Include admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(base_path('routes/admin.php'));

require __DIR__ . '/admin.php'; // Ensure this line is present and correct
