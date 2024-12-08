<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntrepreneurController;
use App\Http\Controllers\AuthController;

Route::middleware(['auth', 'entrepreneur'])->group(function () {
    Route::get('/dashboard', [EntrepreneurController::class, 'dashboard'])->name('entrepreneur.dashboard');
    Route::get('/create-project', [EntrepreneurController::class, 'createProject'])->name('entrepreneur.create_project');
    Route::post('/store-project', [EntrepreneurController::class, 'storeProject'])->name('entrepreneur.store_project');
    Route::get('/edit-project/{id}', [EntrepreneurController::class, 'editProject'])->name('entrepreneur.edit_project');
    Route::post('/update-project/{id}', [EntrepreneurController::class, 'updateProject'])->name('entrepreneur.update_project');
    Route::post('/logout', [AuthController::class, 'logout'])->name('entrepreneur.logout');
});
