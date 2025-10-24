<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    // Daftar semua room
    public function index()
    {
        $rooms = Room::all();
        return view('user.room.index', compact('rooms'));
    }
}
