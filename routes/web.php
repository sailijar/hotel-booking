<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\RoomTypeController as AdminRoomTypeController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;

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


        // Manajemen tipe kamar untuk admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get(
            '/room-types',
            [AdminRoomTypeController::class, 'index']
        )->name('room-types.index');

        Route::get(
            '/room-types/create',
            [AdminRoomTypeController::class, 'create']
        )->name('room-types.create');

        Route::post(
            '/room-types',
            [AdminRoomTypeController::class, 'store']
        )->name('room-types.store');

        Route::get(
            '/room-types/{roomType}/edit',
            [AdminRoomTypeController::class, 'edit']
        )->name('room-types.edit');

        Route::put(
            '/room-types/{roomType}',
            [AdminRoomTypeController::class, 'update']
        )->name('room-types.update');

        Route::delete(
            '/room-types/{roomType}',
            [AdminRoomTypeController::class, 'destroy']
        )->name('room-types.destroy');
    });

    // Manajemen nomor kamar
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/rooms', [
            AdminRoomController::class,
            'index'
        ])->name('rooms.index');

        Route::get('/rooms/create', [
            AdminRoomController::class,
            'create'
        ])->name('rooms.create');

        Route::post('/rooms', [
            AdminRoomController::class,
            'store'
        ])->name('rooms.store');

        Route::get('/rooms/{room}/edit', [
            AdminRoomController::class,
            'edit'
        ])->name('rooms.edit');

        Route::put('/rooms/{room}', [
            AdminRoomController::class,
            'update'
        ])->name('rooms.update');
    });
// Route login dan registrasi dari Laravel Breeze
require __DIR__.'/auth.php';
