<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Mobile\AuthController;
use App\Http\Controllers\Api\Mobile\RoomController;
use App\Http\Controllers\Api\Mobile\BookingController;
use App\Http\Controllers\Api\Mobile\UserController;

/*
|--------------------------------------------------------------------------
| API Routes for Mobile App
|--------------------------------------------------------------------------
*/

// Public routes - No auth required
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// TEST ROUTES - PUBLIC SEMENTARA (COMMENT AUTH MIDDLEWARE)
Route::get('/test', function() {
    return response()->json([
        'success' => true,
        'message' => 'API is working!',
        'data' => [
            'status' => 'OK',
            'timestamp' => now(),
            'version' => '1.0'
        ]
    ]);
});

Route::get('/rooms', [RoomController::class, 'index']);
Route::get('/rooms/available', [RoomController::class, 'available']);


 Route::middleware(['auth:sanctum'])->group(function () {
     
//     // Auth routes
    Route::get('/user', [AuthController::class, 'profile']);
//     Route::post('/logout', [AuthController::class, 'logout']);
    
//     // Room routes
//     Route::get('/rooms', [RoomController::class, 'index']);
//     Route::get('/rooms/{id}', [RoomController::class, 'show']);
     // Booking routes
     Route::get('/bookings', [BookingController::class, 'index']);
     Route::post('/bookings', [BookingController::class, 'store']);
     Route::get('/bookings/{id}', [BookingController::class, 'show']);
    Route::put('/bookings/{id}/cancel', [BookingController::class, 'cancel']); }); 