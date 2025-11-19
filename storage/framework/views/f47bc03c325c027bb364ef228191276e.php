<?php $__env->startSection('title', 'Daftar Booking'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-4 py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-md-items-center mb-4 gap-3">
            <h3 class="fw-bold mb-0">Daftar Booking Anda</h3>
            <div class="d-grid gap-2 gap-md-3 w-100 w-md-auto d-md-flex" style="grid-template-columns: 1fr;">
                <a href="<?php echo e(route('user.rooms.index')); ?>" class="btn btn-info">
                    <i class="bi bi-building me-2"></i> Lihat Ruangan
                </a>
                <a href="<?php echo e(route('user.booking.create')); ?>" class="btn btn-success">
                    <i class="bi bi-plus-circle me-2"></i> Buat Booking Baru
                </a>
                <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-secondary">
                    <i class="bi bi-house me-2"></i> Dashboard
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-semibold mb-0 text-primary">
                    <i class="bi bi-clock-history me-2"></i>Riwayat Booking Anda
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">#</th>
                                <th>Ruangan</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Status</th>
                                <th>Tujuan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-4 fw-semibold"><?php echo e($index + 1); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-building text-muted me-2"></i>
                                            <span class="fw-medium"><?php echo e($booking->room->name ?? 'Ruangan Tidak Ditemukan'); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium"><?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('d M Y')); ?></span>
                                        <br>
                                        <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?></small>
                                    </td>
                                    <td>
                                        <span class="fw-medium"><?php echo e(\Carbon\Carbon::parse($booking->end_time)->format('d M Y')); ?></span>
                                        <br>
                                        <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($booking->end_time)->format('H:i')); ?></small>
                                    </td>
                                    <td>
                                        <?php if($booking->status == 'pending'): ?>
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-clock me-1"></i>Pending
                                            </span>
                                        <?php elseif($booking->status == 'disetujui'): ?>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Disetujui
                                            </span>
                                        <?php elseif($booking->status == 'ditolak'): ?>
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i>Ditolak
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-question-circle me-1"></i><?php echo e($booking->status); ?>

                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                              title="<?php echo e($booking->purpose); ?>">
                                            <?php echo e($booking->purpose ?? '-'); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo e(route('user.booking.show', $booking->id)); ?>" 
                                           class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                           title="Lihat Detail">
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-calendar-x display-4 d-block mb-3"></i>
                                            <h5>Belum ada booking</h5>
                                            <p class="mb-3">Mulai dengan membuat booking ruangan pertama Anda</p>
                                            <a href="<?php echo e(route('user.booking.create')); ?>" class="btn btn-primary">
                                                <i class="bi bi-plus-circle me-1"></i> Buat Booking
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: all 0.2s ease-in-out;
            border: 1px solid rgba(0,0,0,0.08);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        }

        .table > :not(caption) > * > * {
            padding: 1rem 0.75rem;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }

        .btn {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            border: 1px solid #0d6efd;
            color: #0d6efd;
        }

        .btn-outline-primary:hover {
            background: #0d6efd;
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.04);
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\menejemen-ruang\resources\views/user/booking/index.blade.php ENDPATH**/ ?>