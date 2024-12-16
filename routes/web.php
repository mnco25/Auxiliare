<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntrepreneurController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Investor\InvestorProjectController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatController;

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
    require base_path('routes/entrepreneur.php');
    Route::get('/chat', [EntrepreneurController::class, 'chat'])->name('entrepreneur.chat');
    Route::get('/messages/{userId}', [MessageController::class, 'show'])->name('entrepreneur.messages.show');
    Route::post('/messages/send', [MessageController::class, 'sendMessage'])->name('entrepreneur.messages.send');
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

require __DIR__ . '/admin.php';
require __DIR__ . '/entrepreneur.php';

Route::middleware(['auth'])->group(function () {
    Route::post('/entrepreneur/profile/update', [ProfileController::class, 'update'])->name('entrepreneur.profile.update');
    Route::get('/chat/messages/new/{lastMessageId}', [ChatController::class, 'getNewMessages'])
         ->name('chat.messages.new');
    Route::post('/chat/typing', [MessageController::class, 'typingStatus'])->name('chat.typing');
});

// Messaging routes - ensure these are outside other middleware groups
Route::middleware(['auth'])->group(function () {
    Route::get('/messages/{userId}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/send', [MessageController::class, 'sendMessage'])->name('messages.send');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/conversations', [MessageController::class, 'getConversations'])->name('messages.conversations');
    Route::get('/chat/messages/new/{lastMessageId}/{currentChatId}', [MessageController::class, 'getNewMessages'])->name('chat.messages.new');
});

// Investor routes
Route::middleware(['auth', 'investor'])->prefix('investor')->group(function () {
    Route::get('/home', [InvestorController::class, 'home'])->name('investor.home');
    Route::get('/projects', [InvestorProjectController::class, 'index'])->name('investor.projects');
    Route::get('/projects/{project}', [InvestorProjectController::class, 'show'])->name('investor.project.details');
    Route::get('/portfolio', [InvestorController::class, 'portfolio'])->name('investor.portfolio');
    Route::get('/financial', [InvestorController::class, 'financial'])->name('investor.financial');
    Route::get('/profile', [InvestorController::class, 'profile'])->name('investor.profile');
    Route::post('/profile/update', [InvestorController::class, 'updateProfile'])->name('investor.profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('investor.logout');
    Route::get('/filter-projects', [InvestorProjectController::class, 'filterProjects'])->name('investor.filter.projects');
    Route::get('/chat', [InvestorController::class, 'chat'])->name('investor.chat');
    Route::post('/deposit', [InvestorController::class, 'deposit'])->name('investor.deposit');
    Route::get('/messages/{userId}', [MessageController::class, 'show'])->name('investor.messages.show');
    Route::post('/messages/send', [MessageController::class, 'sendMessage'])->name('investor.messages.send');
});

Route::post('/investor/projects/{project}/invest', [InvestmentController::class, 'invest'])
    ->name('investor.invest')
    ->middleware('auth');

Route::post('/entrepreneur/messages/send', [MessageController::class, 'sendMessage'])
    ->name('entrepreneur.messages.send')
    ->middleware(['auth', 'entrepreneur']);

// Add these routes to your existing chat routes
Route::post('/chat/typing', 'ChatController@updateTypingStatus')->name('chat.typing');
Route::post('/messages/mark-as-read', 'ChatController@markAsRead')->name('messages.mark-as-read');

Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');

Route::get('/admin/user-management', [AdminController::class, 'userManagement'])->name('admin.user_management');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/users/{id}', [AdminController::class, 'getUser']);
    Route::post('/users/{id}', [AdminController::class, 'update']);
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});
