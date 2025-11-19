@extends('layouts.app')

@section('title', 'Jadwal Mingguan')

@section('content')
<div class="container-fluid mt-4">
    <h3 class="mb-4">📅 Jadwal Mingguan</h3>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">Kembali</a>

    <style>
        .jadwal-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .jadwal-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
        }

        .jadwal-table th,
        .jadwal-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 13px;
        }

        .jadwal-table th {
            text-transform: uppercase;
        }

        .time-col {
            background-color: #f5f5f5;
            font-weight: 600;
            text-align: left;
            width: 130px;
        }

        .session-cell {
            min-height: 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 3px;
        }

        .session-cell.ada-kelas {
            background: #e8f4f8;
        }

        .kelas-name {
            font-weight: 600;
            color: #333;
            font-size: 12px;
        }

        .room-name {
            color: #666;
            font-size: 11px;
        }

        .scroll-x {
            overflow-x: auto;
            margin-bottom: 30px;
        }

        .room-title {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 15px;
        }
    </style>

    @php
        // Data untuk menampilkan jadwal
        $sessions = [
            ['sesi' => '0', 'jam' => '07:00-07:45'],
            ['sesi' => '1', 'jam' => '07:45-08:30'],
            ['sesi' => '2', 'jam' => '08:30-09:15'],
            ['sesi' => '3', 'jam' => '09:15-10:00'],
            ['sesi' => '4', 'jam' => '10:00-10:45'],
            ['sesi' => '5', 'jam' => '10:45-11:30'],
            ['sesi' => '6', 'jam' => '12:00-12:45'],
            ['sesi' => '7', 'jam' => '12:45-13:30'],
            ['sesi' => '8', 'jam' => '13:30-14:15'],
            ['sesi' => '9', 'jam' => '14:15-15:00'],
        ];
        
        $haris = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        
        // Kelompokkan jadwal per ruangan dan hari
        $jadwalPerRuangan = [];
        foreach ($jadwal as $item) {
            $jadwalPerRuangan[$item->room_id][$item->hari][$item->kelas] = $item;
        }
    @endphp

    <!-- Tampilkan jadwal untuk setiap ruangan -->
    @foreach($rooms as $room)
        <div class="room-title">🏢 {{ $room->name }}</div>

        <div class="scroll-x">
            <table class="jadwal-table">
                <thead>
                    <tr>
                        <th>JAM</th>
                        @foreach($haris as $hari)
                            <th>{{ $hari }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                        <tr>
                            <td class="time-col">{{ $session['jam'] }}</td>
                            @foreach($haris as $hari)
                                <td>
                                    @php
                                        $scheduleItem = $jadwalPerRuangan[$room->id][$hari][$session['sesi']] ?? null;
                                    @endphp
                                    @if($scheduleItem && $scheduleItem->class)
                                        <div class="session-cell ada-kelas">
                                            <div class="kelas-name">{{ $scheduleItem->class->name }}</div>
                                            <div class="room-name">{{ $scheduleItem->room->name }}</div>
                                        </div>
                                    @else
                                        <div class="session-cell">-</div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>
@endsection
