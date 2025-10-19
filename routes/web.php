<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;



Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'registerUser']);


Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    
    Route::get('/user/booking', [BookingController::class, 'index'])->name('user.booking.index');
    Route::get('/user/booking/create', [BookingController::class, 'create'])->name('user.booking.create');
    Route::post('/user/booking', [BookingController::class, 'store'])->name('user.booking.store');
    Route::get('/user/booking/{booking}', [BookingController::class, 'show'])->name('user.booking.show');

   
    Route::get('/user/room', [RoomController::class, 'index'])->name('user.room.index');
});



Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/petugas', [AdminController::class, 'petugas'])->name('admin.petugas');
    Route::get('/admin/petugas/create', [AdminController::class, 'createPetugas'])->name('admin.petugas.create');
    Route::post('/admin/petugas', [AdminController::class, 'storePetugas'])->name('admin.petugas.store');
    Route::get('/admin/petugas/{user}/edit', [AdminController::class, 'editPetugas'])->name('admin.petugas.edit');
    Route::put('/admin/petugas/{user}', [AdminController::class, 'updatePetugas'])->name('admin.petugas.update');
    Route::delete('/admin/petugas/{user}', [AdminController::class, 'deletePetugas'])->name('admin.petugas.delete');

    
    Route::get('/admin/rooms', [AdminController::class, 'rooms'])->name('admin.rooms');
    Route::get('/admin/rooms/create', [AdminController::class, 'createRoom'])->name('admin.rooms.create');
    Route::post('/admin/rooms', [AdminController::class, 'storeRoom'])->name('admin.rooms.store');
    Route::get('/admin/rooms/{room}/edit', [AdminController::class, 'editRoom'])->name('admin.rooms.edit');
    Route::put('/admin/rooms/{room}', [AdminController::class, 'updateRoom'])->name('admin.rooms.update');
    Route::delete('/admin/rooms/{room}', [AdminController::class, 'deleteRoom'])->name('admin.rooms.delete');

  
    Route::get('/admin/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    Route::get('/admin/bookings/create', [AdminController::class, 'createBooking'])->name('admin.bookings.create');
    Route::post('/admin/bookings', [AdminController::class, 'storeBooking'])->name('admin.bookings.store');
    Route::get('/admin/bookings/{booking}', [AdminController::class, 'showBooking'])->name('admin.bookings.show');
    Route::get('/admin/bookings/{booking}/edit', [AdminController::class, 'editBooking'])->name('admin.bookings.edit');
    Route::put('/admin/bookings/{booking}', [AdminController::class, 'updateBooking'])->name('admin.bookings.update');
    Route::delete('/admin/bookings/{booking}', [AdminController::class, 'deleteBooking'])->name('admin.bookings.delete');

   
    Route::get('/admin/jadwal_reguler', [AdminController::class, 'jadwalReguler'])->name('admin.jadwal_reguler');
    Route::get('/admin/jadwal_reguler/create', [AdminController::class, 'createJadwalReguler'])->name('admin.jadwal_reguler.create');
    Route::post('/admin/jadwal_reguler', [AdminController::class, 'storeJadwalReguler'])->name('admin.jadwal_reguler.store');
    Route::get('/admin/jadwal_reguler/{jadwal}/edit', [AdminController::class, 'editJadwalReguler'])->name('admin.jadwal_reguler.edit');
    Route::put('/admin/jadwal_reguler/{jadwal}', [AdminController::class, 'updateJadwalReguler'])->name('admin.jadwal_reguler.update');
    Route::delete('/admin/jadwal_reguler/{jadwal}', [AdminController::class, 'deleteJadwalReguler'])->name('admin.jadwal_reguler.delete');
});



Route::middleware(['auth', 'role:petugas'])->group(function () {
   
    Route::get('/petugas/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');

    Route::get('/petugas/rooms', [PetugasController::class, 'rooms'])->name('petugas.rooms');
    Route::get('/petugas/rooms/create', [PetugasController::class, 'createRoom'])->name('petugas.rooms.create');
    Route::post('/petugas/rooms', [PetugasController::class, 'storeRoom'])->name('petugas.rooms.store');
    Route::delete('/petugas/rooms/{room}', [PetugasController::class, 'deleteRoom'])->name('petugas.rooms.delete');

  
    Route::get('/petugas/bookings', [PetugasController::class, 'bookings'])->name('petugas.bookings');
    Route::get('/petugas/bookings/create', [PetugasController::class, 'createBooking'])->name('petugas.bookings.create');
    Route::post('/petugas/bookings', [PetugasController::class, 'storeBooking'])->name('petugas.bookings.store');
    Route::delete('/petugas/bookings/{booking}', [PetugasController::class, 'deleteBooking'])->name('petugas.bookings.delete');

    
    Route::post('/petugas/bookings/{id}/konfirmasi', [PetugasController::class, 'konfirmasi'])->name('petugas.bookings.konfirmasi');
    Route::post('/petugas/bookings/{id}/tolak', [PetugasController::class, 'tolak'])->name('petugas.bookings.tolak');

    
Route::get('/petugas/jadwal_reguler', [PetugasController::class, 'jadwalReguler'])->name('petugas.jadwal_reguler');
Route::get('/petugas/jadwal_reguler/create', [PetugasController::class, 'createJadwalReguler'])->name('petugas.jadwal_reguler.create');
Route::post('/petugas/jadwal_reguler', [PetugasController::class, 'storeJadwalReguler'])->name('petugas.jadwal_reguler.store');
Route::get('/petugas/jadwal_reguler/{jadwal}/edit', [PetugasController::class, 'editJadwalReguler'])->name('petugas.jadwal_reguler.edit');
Route::put('/petugas/jadwal_reguler/{jadwal}', [PetugasController::class, 'updateJadwalReguler'])->name('petugas.jadwal_reguler.update');
Route::delete('/petugas/jadwal_reguler/{jadwal}', [PetugasController::class, 'deleteJadwalReguler'])->name('petugas.jadwal_reguler.delete');

});
