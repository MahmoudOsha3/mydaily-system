<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskTemplateController;
use Illuminate\Support\Facades\Route;

// ---------- Auth ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showRequestForm'])->name('password.request.form');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])
        ->middleware('throttle:3,1')
        ->name('password.request');

    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
        ->middleware('throttle:5,1')
        ->name('password.reset');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/today', [TaskController::class, 'today'])->name('tasks.today');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::get('/templates', [TaskTemplateController::class, 'index'])->name('templates.index');
    Route::post('/templates', [TaskTemplateController::class, 'store'])->name('templates.store');
    Route::patch('/templates/{template}', [TaskTemplateController::class, 'update'])->name('templates.update');
    Route::delete('/templates/{template}', [TaskTemplateController::class, 'destroy'])->name('templates.destroy');

    Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');

    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::post('/finance', [FinanceController::class, 'store'])->name('finance.store');
    Route::delete('/finance/{transaction}', [FinanceController::class, 'destroy'])->name('finance.destroy');
});
