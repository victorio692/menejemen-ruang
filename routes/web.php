<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use Dompdf\Dompdf;

// ==================== TEST ROUTE ====================
Route::get('/test-pdf', function () {
    try {
        $html = '<h1>Test PDF</h1><p>This is a test PDF generated using DomPDF.</p>';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="test.pdf"');
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// ==================== ROUTE ROOT ====================
Route::get('/', function () {
    return redirect('/login');
});

// ==================== AUTH ROUTES ====================
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ==================== API ROUTES (UNTUK AJAX) ====================
Route::get('/api/check-schedule', [BookingController::class, 'checkSchedule'])->name('api.check-schedule');
Route::post('/api/refresh-csrf', function() {
    return response()->json(['token' => csrf_token()]);
})->middleware('auth')->name('api.refresh-csrf');

// ==================== USER ROUTES ====================
Route::middleware(['auth'])->group(function () {
    // Dashboard User
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    
    // Booking Routes
    Route::get('/user/bookings', [BookingController::class, 'index'])->name('user.booking.index');
    Route::get('/user/bookings/create', [BookingController::class, 'create'])->name('user.booking.create');
    Route::post('/user/bookings', [BookingController::class, 'store'])->name('user.booking.store');
    Route::get('/user/bookings/{booking}', [BookingController::class, 'show'])->name('user.booking.show');

    // Room Routes
    Route::get('/user/rooms', [RoomController::class, 'index'])->name('user.rooms.index');
});

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Laporan Routes untuk Admin
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');

    // Petugas Management
    Route::get('/admin/petugas', [AdminController::class, 'petugas'])->name('admin.petugas');
    Route::get('/admin/petugas/create', [AdminController::class, 'createPetugas'])->name('admin.petugas.create');
    Route::post('/admin/petugas', [AdminController::class, 'storePetugas'])->name('admin.petugas.store');
    Route::get('/admin/petugas/{user}/edit', [AdminController::class, 'editPetugas'])->name('admin.petugas.edit');
    Route::put('/admin/petugas/{user}', [AdminController::class, 'updatePetugas'])->name('admin.petugas.update');
    Route::delete('/admin/petugas/{user}', [AdminController::class, 'deletePetugas'])->name('admin.petugas.delete');

    // Room Management
    Route::get('/admin/rooms', [AdminController::class, 'rooms'])->name('admin.rooms');
    Route::get('/admin/rooms/create', [AdminController::class, 'createRoom'])->name('admin.rooms.create');
    Route::post('/admin/rooms', [AdminController::class, 'storeRoom'])->name('admin.rooms.store');
    Route::get('/admin/rooms/{room}/edit', [AdminController::class, 'editRoom'])->name('admin.rooms.edit');
    Route::put('/admin/rooms/{room}', [AdminController::class, 'updateRoom'])->name('admin.rooms.update');
    Route::delete('/admin/rooms/{room}', [AdminController::class, 'deleteRoom'])->name('admin.rooms.delete');

    // Booking Management
    Route::get('/admin/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    Route::get('/admin/bookings/create', [AdminController::class, 'createBooking'])->name('admin.bookings.create');
    Route::post('/admin/bookings', [AdminController::class, 'storeBooking'])->name('admin.bookings.store');
    Route::get('/admin/bookings/{booking}', [AdminController::class, 'showBooking'])->name('admin.bookings.show');
    Route::get('/admin/bookings/{booking}/edit', [AdminController::class, 'editBooking'])->name('admin.bookings.edit');
    Route::put('/admin/bookings/{booking}', [AdminController::class, 'updateBooking'])->name('admin.bookings.update');
    Route::delete('/admin/bookings/{booking}', [AdminController::class, 'deleteBooking'])->name('admin.bookings.delete');
    Route::post('/admin/bookings/{booking}/approve', [AdminController::class, 'konfirmasiBooking'])->name('admin.booking.approve');
    Route::post('/admin/bookings/{booking}/reject', [AdminController::class, 'tolakBooking'])->name('admin.booking.reject');

    // Jadwal Reguler Management
    Route::get('/admin/jadwal_reguler', [AdminController::class, 'jadwalReguler'])->name('admin.jadwal_reguler');
    Route::get('/admin/jadwal_reguler/mingguan', [AdminController::class, 'jadwalMingguan'])->name('admin.jadwal_reguler.mingguan');
    Route::get('/admin/jadwal_reguler/create', [AdminController::class, 'createJadwalReguler'])->name('admin.jadwal_reguler.create');
    Route::post('/admin/jadwal_reguler', [AdminController::class, 'storeJadwalReguler'])->name('admin.jadwal_reguler.store');
    Route::get('/admin/jadwal_reguler/{jadwal}/edit', [AdminController::class, 'editJadwalReguler'])->name('admin.jadwal_reguler.edit');
    Route::put('/admin/jadwal_reguler/{jadwal}', [AdminController::class, 'updateJadwalReguler'])->name('admin.jadwal_reguler.update');
    Route::delete('/admin/jadwal_reguler/{jadwal}', [AdminController::class, 'deleteJadwalReguler'])->name('admin.jadwal_reguler.delete');
});

// ==================== PETUGAS ROUTES ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/petugas/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');

    // Laporan Routes untuk Petugas
    Route::get('/petugas/reports', [PetugasController::class, 'reports'])->name('petugas.reports');

    Route::get('/petugas/konfirmasi', [PetugasController::class, 'konfirmasiPage'])->name('petugas.konfirmasi');
      
    // Room Management
    Route::get('/petugas/rooms', [PetugasController::class, 'rooms'])->name('petugas.rooms');
    Route::get('/petugas/rooms/create', [PetugasController::class, 'createRoom'])->name('petugas.rooms.create');
    Route::post('/petugas/rooms', [PetugasController::class, 'storeRoom'])->name('petugas.rooms.store');
    Route::delete('/petugas/rooms/{room}', [PetugasController::class, 'deleteRoom'])->name('petugas.rooms.delete');

    // Booking Management
    Route::get('/petugas/bookings', [PetugasController::class, 'bookings'])->name('petugas.bookings');
    Route::get('/petugas/bookings/create', [PetugasController::class, 'createBooking'])->name('petugas.bookings.create');
    Route::post('/petugas/bookings', [PetugasController::class, 'storeBooking'])->name('petugas.bookings.store');
    Route::get('/petugas/bookings/{booking}', [PetugasController::class, 'showBooking'])->name('petugas.bookings.show');
    Route::delete('/petugas/bookings/{booking}', [PetugasController::class, 'deleteBooking'])->name('petugas.bookings.delete');

    // Booking Actions
    Route::post('/petugas/bookings/{id}/konfirmasi', [PetugasController::class, 'konfirmasi'])->name('petugas.bookings.konfirmasi');
    Route::post('/petugas/bookings/{id}/tolak', [PetugasController::class, 'tolak'])->name('petugas.bookings.tolak');

    // Jadwal Reguler Management
    Route::get('/petugas/jadwal_reguler', [PetugasController::class, 'jadwalReguler'])->name('petugas.jadwal_reguler');
    Route::get('/petugas/jadwal_reguler/mingguan', [AdminController::class, 'jadwalMingguan'])->name('petugas.jadwal_reguler.mingguan');
    Route::get('/petugas/jadwal_reguler/create', [PetugasController::class, 'createJadwalReguler'])->name('petugas.jadwal_reguler.create');
    Route::post('/petugas/jadwal_reguler', [PetugasController::class, 'storeJadwalReguler'])->name('petugas.jadwal_reguler.store');
    Route::get('/petugas/jadwal_reguler/{jadwal}/edit', [PetugasController::class, 'editJadwalReguler'])->name('petugas.jadwal_reguler.edit');
    Route::put('/petugas/jadwal_reguler/{jadwal}', [PetugasController::class, 'updateJadwalReguler'])->name('petugas.jadwal_reguler.update');
    Route::delete('/petugas/jadwal_reguler/{jadwal}', [PetugasController::class, 'deleteJadwalReguler'])->name('petugas.jadwal_reguler.delete');
});

// ==================== REPORT ROUTES (ADMIN) ====================
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin/reports')->name('admin.reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/generate', [ReportController::class, 'generate'])->name('generate');
        Route::get('/room', [ReportController::class, 'roomReport'])->name('room');
    });
});

// ==================== REPORT ROUTES (PETUGAS) ====================
Route::middleware(['auth'])->group(function () {
    Route::prefix('petugas/reports')->name('petugas.reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/generate', [ReportController::class, 'generate'])->name('generate');
        Route::get('/room', [ReportController::class, 'roomReport'])->name('room');
    });
});

// ==================== REPORT ROUTES (USER) ====================
Route::middleware(['auth'])->group(function () {
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/generate', [ReportController::class, 'generate'])->name('generate');
        Route::get('/room', [ReportController::class, 'roomReport'])->name('room');
    });
});