@extends('layouts.app')

@section('title', 'Generate Laporan Booking')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-md-items-center mb-4 gap-3">
        <h3 class="fw-bold mb-0">Generate Laporan Booking</h3>
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- Laporan Booking Umum -->
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Laporan Booking Umum</h5>
                </div>
                <div class="card-body">
                    <form action="
                    @if(auth()->user()->role === 'admin')
                        {{ route('admin.reports.generate') }}
                    @elseif(auth()->user()->role === 'petugas')
                        {{ route('petugas.reports.generate') }}
                    @else
                        {{ route('reports.generate') }}
                    @endif
                    " method="GET">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <label class="form-label fw-semibold">Jenis Laporan</label>
                                <select name="type" class="form-select" required id="typeSelect">
                                    <option value="">-- Pilih Jenis Laporan --</option>
                                    <option value="weekly">Mingguan</option>
                                    <option value="monthly">Bulanan</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <label class="form-label fw-semibold">Periode</label>
                                <input type="date" name="period" class="form-control" required 
                                       id="periodInput">
                                <small class="text-muted d-block mt-1" id="periodHelp">
                                    Pilih tanggal referensi
                                </small>
                            </div>

                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <label class="form-label fw-semibold">Status Booking</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="disetujui">Disetujui</option>
                                    <option value="pending">Pending</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid gap-2 gap-md-3 d-md-flex">
                            <button type="submit" name="view" value="true" class="btn btn-primary btn-lg flex-md-grow-1">
                                <i class="bi bi-eye me-2"></i> Lihat Laporan
                            </button>
                            <button type="submit" name="export" value="pdf" class="btn btn-success btn-lg flex-md-grow-1">
                                <i class="bi bi-file-pdf me-2"></i> Export PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Laporan -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Laporan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Laporan Booking Umum:</h6>
                            <ul class="text-muted">
                                <li>Menampilkan semua booking dalam periode tertentu</li>
                            
                                <li>Statistik  : total, disetujui, pending, ditolak</li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.querySelector('#typeSelect');
    const periodInput = document.getElementById('periodInput');
    const periodHelp = document.getElementById('periodHelp');

    // Set default date to today
    const today = new Date();
    periodInput.value = today.toISOString().split('T')[0];

    // Update help text based on report type
    typeSelect.addEventListener('change', function() {
        if (this.value === 'weekly') {
            periodHelp.textContent = 'Pilih tanggal dalam minggu yang diinginkan (laporan akan menampilkan data Senin-Minggu)';
        } else if (this.value === 'monthly') {
            periodHelp.textContent = 'Pilih tanggal dalam bulan yang diinginkan (laporan akan menampilkan data 1-akhir bulan)';
        } else {
            periodHelp.textContent = 'Pilih tanggal referensi untuk laporan';
        }
    });

    // Set default room if only one exists
    const roomSelect = document.querySelector('select[name="room_id"]');
    if (roomSelect && roomSelect.options.length === 2) { // 1 option + 1 default
        roomSelect.selectedIndex = 1;
    }
});
</script>

<style>
.card {
    transition: transform 0.2s ease-in-out;
}
.card:hover {
    transform: translateY(-2px);
}
.form-select:focus, .form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}
.btn {
    transition: all 0.2s ease-in-out;
}
</style>
@endsection