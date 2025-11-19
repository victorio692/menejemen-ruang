<?php $__env->startSection('title', 'Dashboard User'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Dashboard User</h3>
                <div class="text-end">
                    <p class="text-muted mb-1">Selamat datang, <strong><?php echo e(Auth::user()->name); ?></strong>!</p>
                    <small class="text-muted"><?php echo e(\Carbon\Carbon::now()->translatedFormat('l, d F Y')); ?></small>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Booking</h6>
                            <h2 class="mb-0"><?php echo e(\App\Models\Booking::where('user_id', auth()->id())->count()); ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-list-check display-6 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Approved</h6>
                            <h2 class="mb-0"><?php echo e(\App\Models\Booking::where('user_id', auth()->id())->where('status', 'disetujui')->count()); ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-check-circle display-6 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-dark shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Pending</h6>
                            <h2 class="mb-0"><?php echo e(\App\Models\Booking::where('user_id', auth()->id())->where('status', 'pending')->count()); ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-clock display-6 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Ruangan Tersedia</h6>
                            <h2 class="mb-0"><?php echo e(\App\Models\Room::count()); ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="bi bi-building display-6 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-semibold mb-0">Menu Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="<?php echo e(route('user.booking.create')); ?>" class="btn btn-success w-100 py-3 h-100">
                                <div class="text-center">
                                    <i class="bi bi-plus-circle display-6 d-block mb-2"></i>
                                    <h6>Buat Booking Baru</h6>
                                    <small class="d-block">Pesan ruangan untuk meeting</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="<?php echo e(route('user.booking.index')); ?>" class="btn btn-primary w-100 py-3 h-100">
                                <div class="text-center">
                                    <i class="bi bi-clock-history display-6 d-block mb-2"></i>
                                    <h6>Lihat Booking Saya</h6>
                                    <small class="d-block">Riwayat pemesanan</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="<?php echo e(route('user.rooms.index')); ?>" class="btn btn-info w-100 py-3 h-100">
                                <div class="text-center">
                                    <i class="bi bi-building display-6 d-block mb-2"></i>
                                    <h6>Lihat Ruangan</h6>
                                    <small class="d-block">Daftar ruangan tersedia</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-semibold mb-0">Booking Terbaru</h5>
                    <a href="<?php echo e(route('user.booking.index')); ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <?php
                        $recentBookings = \App\Models\Booking::where('user_id', auth()->id())
                            ->with('room')
                            ->latest()
                            ->take(5)
                            ->get();
                    ?>
                    
                    <?php if($recentBookings->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Ruangan</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><strong><?php echo e($booking->room->name ?? '-'); ?></strong></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('d M Y')); ?></td>
                                            <td>
                                                <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?> - 
                                                <?php echo e(\Carbon\Carbon::parse($booking->end_time)->format('H:i')); ?>

                                            </td>
                                            <td>
                                                <?php if($booking->status == 'pending'): ?>
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="bi bi-clock me-1"></i>Pending
                                                    </span>
                                                <?php elseif($booking->status == 'disetujui'): ?>
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Approved
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle me-1"></i>Rejected
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('user.booking.show', $booking->id)); ?>" class="btn btn-sm btn-primary" title="Lihat Detail">
                                                    <i class="bi bi-eye me-1"></i>Detail
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x display-4 text-muted d-block mb-3"></i>
                            <p class="text-muted">Belum ada booking</p>
                            <a href="<?php echo e(route('user.booking.create')); ?>" class="btn btn-primary">Buat Booking Pertama</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1) !important;
    }
    
    .btn {
        transition: all 0.2s ease;
        border: none;
    }
    
    .btn:hover {
        transform: translateY(-2px);
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\menejemen-ruang\resources\views/user/dashboard.blade.php ENDPATH**/ ?>