

<?php $__env->startSection('title', 'Hasil Laporan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold"><?php echo e($title); ?></h3>
        <div>
            <a href="
            <?php if(auth()->user()->role === 'admin'): ?>
                <?php echo e(route('admin.reports.index')); ?>

            <?php elseif(auth()->user()->role === 'petugas'): ?>
                <?php echo e(route('petugas.reports.index')); ?>

            <?php else: ?>
                <?php echo e(route('reports.index')); ?>

            <?php endif; ?>
            " class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="<?php echo e(request()->fullUrlWithQuery(['export' => 'pdf'])); ?>" class="btn btn-success">
                <i class="bi bi-file-pdf me-1"></i> Export PDF
            </a>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4><?php echo e($stats['total_bookings']); ?></h4>
                    <p>Total Booking</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4><?php echo e($stats['approved_bookings']); ?></h4>
                    <p>Disetujui</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h4><?php echo e($stats['pending_bookings']); ?></h4>
                    <p>Pending</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h4><?php echo e($stats['rejected_bookings']); ?></h4>
                    <p>Ditolak</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-light">
            <h5 class="mb-0">Detail Booking</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Ruangan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th>Tujuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($booking->user->name); ?></td>
                            <td><?php echo e($booking->room->name); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('d/m/Y')); ?></td>
                            <td>
                                <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?> - 
                                <?php echo e(\Carbon\Carbon::parse($booking->end_time)->format('H:i')); ?>

                            </td>
                            <td>
                                <?php echo e(\Carbon\Carbon::parse($booking->start_time)->diffInMinutes($booking->end_time)); ?> menit
                            </td>
                            <td>
                                <?php if($booking->status == 'disetujui'): ?>
                                    <span class="badge bg-success">Disetujui</span>
                                <?php elseif($booking->status == 'pending'): ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($booking->purpose); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($bookings->isEmpty()): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">Tidak ada data booking pada periode ini</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart (Optional) -->
    <div class="card shadow-sm border-0 rounded-3 mt-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Grafik Booking</h5>
        </div>
        <div class="card-body">
            <canvas id="bookingChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('bookingChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($chartData['labels'], 15, 512) ?>,
            datasets: [{
                label: 'Jumlah Booking',
                data: <?php echo json_encode($chartData['data'], 15, 512) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\menejemen-ruang\resources\views/reports/result.blade.php ENDPATH**/ ?>