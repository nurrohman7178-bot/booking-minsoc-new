<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Pelanggan\ScheduleController as PelangganScheduleController;

// Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Register
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware('auth')->group(function () {

    // ADMIN

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('customer', CustomerController::class);

    Route::resource('booking', BookingController::class);

    // Schedule
    Route::post('/schedule/generate', [ScheduleController::class, 'generate'])
        ->name('schedule.generate');

    Route::post('/schedule/libur', [ScheduleController::class, 'libur'])
        ->name('schedule.libur');

    Route::post('/schedule/buka', [ScheduleController::class, 'buka'])
        ->name('schedule.buka');

    Route::resource('schedule', ScheduleController::class)
        ->only(['index', 'edit', 'update', 'destroy']);

    // Setting
    Route::get('/profil', [ProfilController::class, 'index'])
        ->name('profil');


    // PELANGGAN

    Route::get('/pelanggan/schedule', [PelangganScheduleController::class, 'index'])
        ->name('pelanggan.schedule');

    Route::post('/pelanggan/schedule', [PelangganScheduleController::class, 'store'])
        ->name('pelanggan.schedule.store');
});
