<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Get user's bookings (Mobile API)
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $bookings = Booking::with('room')
                ->where('user_id', $request->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'bookings' => $bookings
                ],
                'message' => 'Bookings retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve bookings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create new booking (Mobile API)
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'waktu_pinjam' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_pinjam',
            'purpose' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if room is available
            $room = Room::find($request->room_id);
            if ($room->status !== 'tersedia') {
                return response()->json([
                    'success' => false,
                    'message' => 'Room is not available'
                ], 400);
            }

            // Check for booking conflicts
            $conflictingBooking = Booking::where('room_id', $request->room_id)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('waktu_pinjam', [$request->waktu_pinjam, $request->waktu_selesai])
                          ->orWhereBetween('waktu_selesai', [$request->waktu_pinjam, $request->waktu_selesai])
                          ->orWhere(function ($q) use ($request) {
                              $q->where('waktu_pinjam', '<=', $request->waktu_pinjam)
                                ->where('waktu_selesai', '>=', $request->waktu_selesai);
                          });
                })
                ->where('status_booking', '!=', 'dibatalkan')
                ->first();

            if ($conflictingBooking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room already booked for the selected time'
                ], 400);
            }

            $booking = Booking::create([
                'user_id' => $request->user()->id,
                'room_id' => $request->room_id,
                'waktu_pinjam' => $request->waktu_pinjam,
                'waktu_selesai' => $request->waktu_selesai,
                'purpose' => $request->purpose,
                'status_booking' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'booking' => $booking->load('room')
                ],
                'message' => 'Booking created successfully'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific booking (Mobile API)
     */
    public function show(Request $request, $id): JsonResponse
    {
        try {
            $booking = Booking::with('room')
                ->where('id', $id)
                ->where('user_id', $request->user()->id)
                ->first();

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'booking' => $booking
                ],
                'message' => 'Booking retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve booking: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel booking (Mobile API)
     */
    public function cancel(Request $request, $id): JsonResponse
    {
        try {
            $booking = Booking::where('id', $id)
                ->where('user_id', $request->user()->id)
                ->first();

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found'
                ], 404);
            }

            if ($booking->status_booking === 'dibatalkan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking already cancelled'
                ], 400);
            }

            $booking->update([
                'status_booking' => 'dibatalkan'
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'booking' => $booking
                ],
                'message' => 'Booking cancelled successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel booking: ' . $e->getMessage()
            ], 500);
        }
    }
}