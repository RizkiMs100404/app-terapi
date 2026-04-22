<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Orangtua\DashboardController as OrangtuaDashboard;


// 1. Redirect halaman utama ke login
Route::get('/', function () {
    return redirect('/login');
});

// 2. Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Forgot Password Flow
Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetCode'])->name('password.email'); // Ini yang tadi kurang

Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// 4. Grouping Berdasarkan Role
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('guru.dashboard');
});

Route::middleware(['auth', 'role:orangtua'])->prefix('orangtua')->group(function () {
    Route::get('/dashboard', [OrangtuaDashboard::class, 'index'])->name('orangtua.dashboard');
});