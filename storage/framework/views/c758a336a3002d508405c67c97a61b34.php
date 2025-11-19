<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .dashboard-card {
            border: none;
            border-radius: 15px;
            color: white;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
            text-align: center;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .bg-purple {
            background: linear-gradient(135deg, #8a5cf5, #6c63ff);
        }

        .bg-blue {
            background: linear-gradient(135deg, #43a4ff, #0575e6);
        }

        .bg-orange {
            background: linear-gradient(135deg, #ff7b5e, #ff4b2b);
        }

        .bg-green {
            background: linear-gradient(135deg, #42e695, #3bb2b8);
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: white;
        }

        .status-approved {
            background: #28a745;
        }

        .status-pending {
            background: #ffc107;
            color: #000;
        }

        .status-reject {
            background: #dc3545;
        }
    </style>

    <div class="container-fluid px-4 py-4">

        <h3 class="mb-4 fw-bold">Dashboard Admin</h3>

        <div class="row g-3">
            <div class="col-md-3">
                <div class="dashboard-card bg-purple">
                    <h5>Total Users</h5>
                    <h2><?php echo e($usersCount); ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card bg-blue">
                    <h5>Total Rooms</h5>
                    <h2><?php echo e($roomsCount); ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card bg-green">
                    <h5>Total Bookings</h5>
                    <h2><?php echo e($bookingsCount); ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card bg-orange">
                    <h5>Pending Bookings</h5>
                    <h2><?php echo e($pendingBookings); ?></h2>
                </div>
            </div>
        </div>

        <!-- Peminjaman Menunggu Verifikasi -->
        <div class="card mt-4 shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-0">
                <h5 class="fw-bold mb-0">Peminjaman Menunggu Verifikasi</h5>
            </div>
            <div class="card-body p-0">
                <?php if($pendingBookingList->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Ruangan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Tujuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pendingBookingList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($booking->user->name); ?></td>
                                    <td><?php echo e($booking->room->name); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('d M Y H:i')); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($booking->end_time)->format('d M Y H:i')); ?></td>
                                    <td><?php echo e(Str::limit($booking->purpose, 50)); ?></td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <form action="<?php echo e(route('admin.booking.approve', $booking->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.booking.reject', $booking->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                            <a href="<?php echo e(route('admin.bookings.show', $booking->id)); ?>" class="btn btn-info btn-sm" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                        <p class="mt-2 text-muted">Tidak ada peminjaman menunggu verifikasi</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Statistik Booking per Status -->
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-0">
                        <h5 class="fw-bold mb-0">Statistik Booking</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="border-end">
                                    <h3 class="text-success"><?php echo e($approvedBookings ?? 0); ?></h3>
                                    <p class="text-muted mb-0">Disetujui</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border-end">
                                    <h3 class="text-warning"><?php echo e($pendingBookings); ?></h3>
                                    <p class="text-muted mb-0">Pending</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <h3 class="text-danger"><?php echo e($rejectedBookings ?? 0); ?></h3>
                                    <p class="text-muted mb-0">Ditolak</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

        <?php if(session('success')): ?>
            <div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\menejemen-ruang\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>