<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;

// Halaman utama hotel
Route::get('/', [RoomController::class, 'index'])
    ->name('home');

// Arahkan dashboard ke halaman utama hotel
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware('auth')->name('dashboard');

// Fitur reservasi untuk pengguna yang sudah login
Route::middleware('auth')->group(function () {

    // Form pemesanan kamar
    Route::get(
        '/rooms/{roomType}/book',
        [BookingController::class, 'create']
    )->name('bookings.create');

    // Memproses pemesanan
    Route::post(
        '/rooms/{roomType}/book',
        [BookingController::class, 'store']
    )->name('bookings.store');

    // Riwayat pemesanan pelanggan
    Route::get(
        '/my-bookings',
        [BookingController::class, 'index']
    )->name('bookings.index');

});

// Dashboard admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get(
            '/bookings',
            [AdminBookingController::class, 'index']
        )->name('bookings.index');

        Route::patch(
            '/bookings/{booking}/status',
            [AdminBookingController::class, 'updateStatus']
        )->name('bookings.status');
    });

// Route login dan registrasi dari Laravel Breeze
require __DIR__.'/auth.php';
