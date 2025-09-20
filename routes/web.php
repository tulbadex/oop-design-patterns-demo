<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('tasks', TaskController::class);
Route::patch('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
