<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-primary bg-primary p-3">
    <span class="navbar-brand text-white">Dashboard Petugas</span>
    <form action="{{ route('logout') }}" method="POST">@csrf
        <button class="btn btn-light">Logout</button>
    </form>
</nav>

<div class="container mt-4">
    <h2>Halo, Petugas {{ Auth::user()->username }}</h2>

    <h4 class="mt-4">Peminjaman Menunggu Verifikasi</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Peminjam</th>
                <th>Ruangan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pendingBookings as $booking)
            <tr>
                <td>{{ $booking->user->username }}</td>
                <td>{{ $booking->room->nama_room }}</td>
                <td>{{ $booking->tanggal_mulai }} s/d {{ $booking->tanggal_selesai }}</td>
                <td>
                    <button class="btn btn-success btn-sm">Setujui</button>
                    <button class="btn btn-danger btn-sm">Tolak</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h4 class="mt-4">Semua Jadwal Peminjaman</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Peminjam</th>
                <th>Ruangan</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($allBookings as $booking)
            <tr>
                <td>{{ $booking->user->username }}</td>
                <td>{{ $booking->room->nama_room }}</td>
                <td>{{ $booking->tanggal_mulai }} s/d {{ $booking->tanggal_selesai }}</td>
                <td>{{ $booking->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
