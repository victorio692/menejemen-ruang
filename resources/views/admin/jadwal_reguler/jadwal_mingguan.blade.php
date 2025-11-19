@extends('layouts.app')

@section('title', 'Jadwal Mingguan')

@section('content')
<div class="container-fluid mt-4">
    <h3 class="mb-4">📅 Jadwal Mingguan Ruangan & Kelas</h3>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>

    <style>
        .jadwal-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .jadwal-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
        }

        .jadwal-table th,
        .jadwal-table td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        .jadwal-table th {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .jadwal-table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .jadwal-table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .jam-col {
            background-color: #f0f0f0;
            font-weight: 600;
            color: #333;
            width: 120px;
        }

        .session-cell {
            background-color: #fff;
            border-left: 3px solid #667eea;
            font-size: 12px;
            padding: 8px;
            min-height: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .session-cell.ada-kelas {
            background: linear-gradient(135deg, #e8f4f8, #f0e8ff);
            border-left-color: #667eea;
        }

        .kelas-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
            font-size: 11px;
        }

        .room-name {
            color: #666;
            font-size: 10px;
            margin-bottom: 2px;
        }

        .time-badge {
            background: #667eea;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
        }

        .room-select {
            margin-bottom: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .room-select select {
            max-width: 300px;
        }

        .scroll-x {
            overflow-x: auto;
        }
    </style>

    <!-- Filter Ruangan -->
    <div class="room-select">
        <label for="roomFilter" class="form-label">📍 Pilih Ruangan:</label>
        <select id="roomFilter" class="form-select" onchange="filterRoom()">
            <option value="">-- Semua Ruangan --</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}">{{ $room->name }} (Kapasitas: {{ $room->capacity }})</option>
            @endforeach
        </select>
    </div>

    @php
        // Data untuk menampilkan jadwal
        $sessions = [
            ['sesi' => '0', 'jam' => '07:00 - 07:45'],
            ['sesi' => '1', 'jam' => '07:45 - 08:30'],
            ['sesi' => '2', 'jam' => '08:30 - 09:15'],
            ['sesi' => '3', 'jam' => '09:15 - 10:00'],
            ['sesi' => '4', 'jam' => '10:00 - 10:45'],
            ['sesi' => '5', 'jam' => '10:45 - 11:30'],
            ['sesi' => '6', 'jam' => '12:00 - 12:45'],
            ['sesi' => '7', 'jam' => '12:45 - 13:30'],
            ['sesi' => '8', 'jam' => '13:30 - 14:15'],
            ['sesi' => '9', 'jam' => '14:15 - 15:00'],
        ];
        
        $haris = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        
        // Kelompokkan jadwal per ruangan dan hari
        $jadwalPerRuangan = [];
        foreach ($jadwal as $item) {
            $jadwalPerRuangan[$item->room_id][$item->hari][$item->kelas] = $item;
        }
    @endphp

    <!-- Tampilkan jadwal untuk semua ruangan -->
    @foreach($rooms as $room)
        <div class="jadwal-room-container mb-5" data-room-id="{{ $room->id }}">
            <h5 class="mb-3" style="color: #667eea; font-weight: 600;">
                🏢 {{ $room->name }}
                <small style="color: #999;">({{ $room->capacity }} tempat)</small>
            </h5>

            <div class="scroll-x">
                <table class="jadwal-table">
                    <thead>
                        <tr>
                            <th>JAM KE</th>
                            <th>WAKTU</th>
                            @foreach($haris as $hari)
                                <th>{{ strtoupper($hari) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $session)
                            <tr>
                                <td class="jam-col">{{ $session['sesi'] }}</td>
                                <td class="jam-col">{{ $session['jam'] }}</td>
                                @foreach($haris as $hari)
                                    <td>
                                        @php
                                            $scheduleItem = $jadwalPerRuangan[$room->id][$hari][$session['sesi']] ?? null;
                                        @endphp
                                        @if($scheduleItem && $scheduleItem->class)
                                            <div class="session-cell ada-kelas">
                                                <div class="kelas-name">{{ $scheduleItem->class->name }}</div>
                                                <div class="room-name">{{ $scheduleItem->room->name }}</div>
                                                <div class="time-badge">{{ substr($scheduleItem->start_time, 0, 5) }} - {{ substr($scheduleItem->end_time, 0, 5) }}</div>
                                            </div>
                                        @else
                                            <div class="session-cell">
                                                -
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach

    <script>
        function filterRoom() {
            const roomId = document.getElementById('roomFilter').value;
            const containers = document.querySelectorAll('.jadwal-room-container');

            containers.forEach(container => {
                if (roomId === '' || container.getAttribute('data-room-id') === roomId) {
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            });
        }
    </script>
</div>
@endsection
