<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/user_management', [AdminController::class, 'userManagement'])->name('admin.user_management');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/users', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/projects', [AdminController::class, 'projects'])->name('admin.projects');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});
