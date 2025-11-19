<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    /**
     * Get all rooms (Mobile API) - COMPATIBLE VERSION
     */
    public function index(): JsonResponse
    {
        try {
            $rooms = Room::all();

            // Format response untuk mobile app
            $formattedRooms = $rooms->map(function($room) {
                return [
                    'id' => $room->id,
                    'nama_ruang' => $room->nama_ruang, // menggunakan accessor
                    'kode_ruang' => $room->kode_ruang, // menggunakan accessor
                    'kapasitas' => $room->kapasitas,   // menggunakan accessor
                    'lokasi' => $room->lokasi,         // menggunakan accessor
                    'fasilitas' => $room->fasilitas,   // menggunakan accessor
                    'status' => $room->status,         // menggunakan accessor
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'rooms' => $formattedRooms
                ],
                'message' => 'Rooms retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve rooms: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available rooms (Mobile API) - COMPATIBLE VERSION
     */
    public function available(): JsonResponse
    {
        try {
            // Untuk sekarang, return semua rooms
            $rooms = Room::all();

            $formattedRooms = $rooms->map(function($room) {
                return [
                    'id' => $room->id,
                    'nama_ruang' => $room->nama_ruang,
                    'kode_ruang' => $room->kode_ruang,
                    'kapasitas' => $room->kapasitas,
                    'lokasi' => $room->lokasi,
                    'fasilitas' => $room->fasilitas,
                    'status' => $room->status,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'rooms' => $formattedRooms,
                    'total' => $rooms->count()
                ],
                'message' => 'Available rooms retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve available rooms: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific room (Mobile API) - COMPATIBLE VERSION
     */
    public function show($id): JsonResponse
    {
        try {
            $room = Room::find($id);

            if (!$room) {
                return response()->json([
                    'success' => false,
                    'message' => 'Room not found'
                ], 404);
            }

            $formattedRoom = [
                'id' => $room->id,
                'nama_ruang' => $room->nama_ruang,
                'kode_ruang' => $room->kode_ruang,
                'kapasitas' => $room->kapasitas,
                'lokasi' => $room->lokasi,
                'fasilitas' => $room->fasilitas,
                'status' => $room->status,
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'room' => $formattedRoom
                ],
                'message' => 'Room retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve room: ' . $e->getMessage()
            ], 500);
        }
    }
}