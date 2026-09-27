<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Pelanggan\ScheduleController as PelangganScheduleController;
// ==================================================
// LOGIN
// ==================================================
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');
Route::post('/login', [AuthController::class, 'login']);
// ==================================================
// REGISTER
// ==================================================
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');
Route::post('/register', [AuthController::class, 'register']);
// ==================================================
// LOGOUT
// ==================================================
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
// ==================================================
// AUTH
// ==================================================
Route::middleware('auth')->group(function () {
    // ==================================================
    // ADMIN
    // ==================================================
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    // Customer
    Route::resource('customer', CustomerController::class);
    // Booking Admin
    Route::resource('booking', BookingController::class);
    // Schedule Admin
    Route::post('/schedule/generate', [ScheduleController::class, 'generate'])
        ->name('schedule.generate');
    Route::post('/schedule/libur', [ScheduleController::class, 'libur'])
        ->name('schedule.libur');
    Route::post('/schedule/buka', [ScheduleController::class, 'buka'])
        ->name('schedule.buka');
    Route::resource('schedule', ScheduleController::class)
        ->only([
            'index',
            'edit',
            'update',
            'destroy'
        ]);
    // Setting / Profil
    Route::get('/profil', [ProfilController::class, 'index'])
        ->name('profil');
    // ==================================================
    // PELANGGAN
    // ==================================================
    // Schedule Pelanggan
    Route::get(
        '/pelanggan/schedule',
        [PelangganScheduleController::class, 'index']
    )->name('pelanggan.schedule');
    // Simpan Booking Pelanggan
    Route::post(
        '/pelanggan/schedule',
        [PelangganScheduleController::class, 'store']
    )->name('pelanggan.schedule.store');
    // My Booking
    Route::get(
        '/pelanggan/booking',
        [PelangganScheduleController::class, 'booking']
    )->name('pelanggan.booking');
    // History
    Route::get(
        '/pelanggan/history',
        [PelangganScheduleController::class, 'history']
    )->name('pelanggan.history');
});