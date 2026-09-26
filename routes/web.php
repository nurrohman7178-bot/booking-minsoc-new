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

    //ADMIN//
//Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    //Customer
    Route::resource('customer', CustomerController::class);
    //Booking
    Route::resource('booking', BookingController::class)
        ->only(['index', 'update']);
    //Schedule
    Route::resource('schedule', ScheduleController::class);
    //Setting
    Route::get('/profil', [ProfilController::class, 'index'])
        ->name('profil');

    //PELANGGAN//
    Route::get(
        '/pelanggan/jadwal',
        [PelangganScheduleController::class, 'index']
    )->name('pelanggan.schedule');
});
