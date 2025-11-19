<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #667eea;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 12px;
        }

        .stats-section {
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-box {
            background: #f8f9ff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .stat-box .label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .stat-box .value {
            font-size: 24px;
            color: #667eea;
            font-weight: bold;
        }

        .table-section {
            margin-top: 30px;
        }

        .table-section h3 {
            font-size: 14px;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background: #667eea;
            color: white;
        }

        table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
        }

        table td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }

        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-disetujui {
            background: #d4edda;
            color: #155724;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #721c24;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: right;
            font-size: 11px;
            color: #666;
        }

        .filter-info {
            background: #f0f0f0;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 11px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1><?php echo e($title); ?></h1>
            <p>Laporan Booking Ruangan</p>
            <p>Periode: <?php echo e(\Carbon\Carbon::parse($startDate)->format('d M Y')); ?> - <?php echo e(\Carbon\Carbon::parse($endDate)->format('d M Y')); ?></p>
        </div>

        <!-- Filter Info -->
        <?php if($status): ?>
        <div class="filter-info">
            <strong>Filter Status:</strong> <?php echo e(ucfirst($status)); ?>

        </div>
        <?php endif; ?>

        <!-- Statistics Section -->
        <div class="stats-section">
            <h3 style="margin-bottom: 15px; font-size: 14px; color: #333;">Ringkasan Statistik</h3>
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="label">Total Booking</div>
                    <div class="value"><?php echo e($stats['total_bookings']); ?></div>
                </div>
                <div class="stat-box">
                    <div class="label">Disetujui</div>
                    <div class="value" style="color: #28a745;"><?php echo e($stats['approved_bookings']); ?></div>
                </div>
                <div class="stat-box">
                    <div class="label">Pending</div>
                    <div class="value" style="color: #ffc107;"><?php echo e($stats['pending_bookings']); ?></div>
                </div>
                <div class="stat-box">
                    <div class="label">Ditolak</div>
                    <div class="value" style="color: #dc3545;"><?php echo e($stats['rejected_bookings']); ?></div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-box">
                    <div class="label">Ruangan Digunakan</div>
                    <div class="value"><?php echo e($stats['total_rooms_used']); ?></div>
                </div>
                <div class="stat-box">
                    <div class="label">Total User</div>
                    <div class="value"><?php echo e($stats['total_users']); ?></div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <h3>Detail Booking</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Ruangan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($booking->user->name ?? '-'); ?></td>
                        <td><?php echo e($booking->room->name ?? '-'); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('d M Y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($booking->end_time)->format('H:i')); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo e($booking->status); ?>">
                                <?php echo e(ucfirst($booking->status)); ?>

                            </span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: #999;">
                            Tidak ada data booking untuk periode ini
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Laporan ini dibuat otomatis oleh Sistem Manajemen Ruang</p>
            <p><?php echo e(now()->format('d M Y H:i:s')); ?></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\menejemen-ruang\resources\views/reports/pdf.blade.php ENDPATH**/ ?>