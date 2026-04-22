<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// Pastikan controller dashboard ini sudah kamu buat ya bg, kalau belum buat dlu filenya
// use App\Http\Controllers\AdminController; 
// use App\Http\Controllers\GuruController;

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
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function() {
        return "Halo Admin! Ini Dashboard kamu.";
    });
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/guru/dashboard', function() {
        return "Halo Guru! Ini Dashboard kamu.";
    });
});

Route::middleware(['auth', 'role:orangtua'])->group(function () {
    Route::get('/orangtua/dashboard', function() {
        return "Halo Orangtua! Ini Dashboard kamu.";
    });
});