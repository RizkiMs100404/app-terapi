<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Orangtua\JadwalController;
use App\Http\Controllers\Orangtua\PerkembanganController;
use App\Http\Controllers\Orangtua\SiswaProfileController;
use App\Http\Controllers\Orangtua\ProfileController as OrangtuaProfile;
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
Route::post('/forgot-password', [AuthController::class, 'sendResetCode'])->name('password.email');
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// 4. Admin Panel
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Tahun Akademik
    Route::resource('tahun-ajaran', TahunAjaranController::class);
    Route::post('/tahun-ajaran/toggle/{id}', [TahunAjaranController::class, 'toggleStatus'])->name('tahun-ajaran.toggle');

    // Data Orang Tua
    Route::resource('orangtua', \App\Http\Controllers\Admin\OrangtuaController::class);

    // Data Guru Terapis
    Route::resource('guru-terapis', \App\Http\Controllers\Admin\GuruTerapisController::class);

    // Data Siswa
    Route::resource('siswa', SiswaController::class);

    // Jadwal Terapi
    Route::resource('jadwal-terapi', App\Http\Controllers\Admin\JadwalTerapiController::class);

    // Rekam Terapi (Hasil Terapi)
    Route::resource('rekam-terapi', App\Http\Controllers\Admin\RekamTerapiController::class)->names([
    'index'   => 'admin.rekam-terapi.index',
    'show'    => 'admin.rekam-terapi.show',
    'destroy' => 'admin.rekam-terapi.destroy',
]);

    // Laporan Perkembangan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('admin.laporan.pdf');
    Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('admin.laporan.excel');

    // Manajemen Users
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    // Profile
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('admin.profile.password');
});

// 5. Guru Panel
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {

    // Dashboard Utama Guru
    Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('dashboard');

    // Menu Jadwal
    Route::get('/jadwal', [App\Http\Controllers\Guru\JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/{id}', [App\Http\Controllers\Guru\JadwalController::class, 'show'])->name('jadwal.show');

    // Menu Riwayat & Rekam Terapi
    Route::get('/rekam-terapi/history', [App\Http\Controllers\Guru\RekamTerapiController::class, 'history'])->name('rekam-terapi.history');
    Route::get('/rekam-terapi/create/{id_jadwal}', [App\Http\Controllers\Guru\RekamTerapiController::class, 'create'])->name('rekam-terapi.create');
    Route::post('/rekam-terapi/store', [App\Http\Controllers\Guru\RekamTerapiController::class, 'store'])->name('rekam-terapi.store');
    Route::get('/rekam-terapi/edit/{id}', [App\Http\Controllers\Guru\RekamTerapiController::class, 'edit'])->name('rekam-terapi.edit');
    Route::put('/rekam-terapi/update/{id}', [App\Http\Controllers\Guru\RekamTerapiController::class, 'update'])->name('rekam-terapi.update');

    // --- Siswa Terapi ---
    Route::get('/siswa-terapi', [App\Http\Controllers\Guru\SiswaTerapiController::class, 'index'])->name('siswa-terapi.index');
    Route::get('/siswa-terapi/{id}', [App\Http\Controllers\Guru\SiswaTerapiController::class, 'show'])->name('siswa-terapi.show');

    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\Guru\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Guru\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Guru\ProfileController::class, 'updatePassword'])->name('profile.password');

});

// 6. Orang Tua Panel
// Tambahkan ->name('orangtua.') di bawah ini
Route::middleware(['auth', 'role:orangtua'])->prefix('orangtua')->name('orangtua.')->group(function () {
    
    // Dashboard Utama
    Route::get('/dashboard', [OrangtuaDashboard::class, 'index'])->name('dashboard'); // Jadi orangtua.dashboard
    
    Route::get('/switch-anak/{id}', [OrangtuaDashboard::class, 'switchAnak'])->name('switch');

    // Menu Jadwal
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::get('/jadwal/{id}', [JadwalController::class, 'show'])->name('jadwal.show');
    Route::get('/hasil', [JadwalController::class, 'history'])->name('jadwal.history');

    // Menu Monitoring & Laporan
    Route::get('/perkembangan', [PerkembanganController::class, 'index'])->name('perkembangan');

    // Profile 
    Route::get('/profile', [OrangtuaProfile::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [OrangtuaProfile::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [OrangtuaProfile::class, 'updatePassword'])->name('profile.password');

    // Profile Anak
    Route::get('/profil-anak', [SiswaProfileController::class, 'edit'])->name('siswa.edit');
    Route::put('/profil-anak', [SiswaProfileController::class, 'update'])->name('siswa.update');

});