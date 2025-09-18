<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AuthController;


// Login & Logout
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================
// Dashboard Admin
// ============================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Manajemen Petugas
    Route::get('/admin/petugas', [AdminController::class, 'petugas'])->name('admin.petugas');
    Route::get('/admin/petugas/create', [AdminController::class, 'createPetugas'])->name('admin.petugas.create');
    Route::post('/admin/petugas', [AdminController::class, 'storePetugas'])->name('admin.petugas.store');
    Route::get('/admin/petugas/{user}/edit', [AdminController::class, 'editPetugas'])->name('admin.petugas.edit');
    Route::put('/admin/petugas/{user}', [AdminController::class, 'updatePetugas'])->name('admin.petugas.update');
    Route::delete('/admin/petugas/{user}', [AdminController::class, 'deletePetugas'])->name('admin.petugas.delete');

    // Manajemen Room
    Route::get('/admin/rooms', [AdminController::class, 'rooms'])->name('admin.rooms');
    Route::get('/admin/rooms/create', [AdminController::class, 'createRoom'])->name('admin.rooms.create');
    Route::post('/admin/rooms', [AdminController::class, 'storeRoom'])->name('admin.rooms.store');
    Route::get('/admin/rooms/{room}/edit', [AdminController::class, 'editRoom'])->name('admin.rooms.edit');
    Route::put('/admin/rooms/{room}', [AdminController::class, 'updateRoom'])->name('admin.rooms.update');
    Route::delete('/admin/rooms/{room}', [AdminController::class, 'deleteRoom'])->name('admin.rooms.delete');

    // Manajemen Booking
    Route::get('/admin/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    Route::get('/admin/bookings/create', [AdminController::class, 'createBooking'])->name('admin.bookings.create');
    Route::post('/admin/bookings', [AdminController::class, 'storeBooking'])->name('admin.bookings.store');
    Route::get('/admin/bookings/{booking}', [AdminController::class, 'showBooking'])->name('admin.bookings.show');
    Route::get('/admin/bookings/{booking}/edit', [AdminController::class, 'editBooking'])->name('admin.bookings.edit');
    Route::put('/admin/bookings/{booking}', [AdminController::class, 'updateBooking'])->name('admin.bookings.update');
    Route::delete('/admin/bookings/{booking}', [AdminController::class, 'deleteBooking'])->name('admin.bookings.delete');
});
  
   // Manajemen Jadwal Ruang (Admin Only)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/schedules', [AdminController::class, 'schedules'])->name('admin.schedules');
    Route::get('/admin/schedules/create', [AdminController::class, 'createSchedule'])->name('admin.schedules.create');
    Route::post('/admin/schedules', [AdminController::class, 'storeSchedule'])->name('admin.schedules.store');
    Route::get('/admin/schedules/{schedule}/edit', [AdminController::class, 'editSchedule'])->name('admin.schedules.edit');
    Route::put('/admin/schedules/{schedule}', [AdminController::class, 'updateSchedule'])->name('admin.schedules.update');
    Route::delete('/admin/schedules/{schedule}', [AdminController::class, 'deleteSchedule'])->name('admin.schedules.delete');
});


// ============================
// Dashboard Petugas
// ============================
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');
    Route::post('/petugas/konfirmasi/{id}', [PetugasController::class, 'konfirmasi'])->name('petugas.konfirmasi');
    Route::post('/petugas/tolak/{id}', [PetugasController::class, 'tolak'])->name('petugas.tolak');
});
