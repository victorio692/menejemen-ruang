

<?php $__env->startSection('title', 'Jadwal Mingguan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid mt-4">
    <h3 class="mb-4">📅 Jadwal Mingguan</h3>

    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary mb-3">Kembali</a>

    <style>
        .jadwal-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .jadwal-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .jadwal-table th {
            padding: 16px 12px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .jadwal-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        .time-col {
            background-color: #f5f5f5;
            font-weight: 600;
            text-align: left;
            width: 110px;
            color: #333;
        }

        .session-cell {
            min-height: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 4px;
            background-color: #fff;
            border-left: 4px solid #667eea;
        }

        .session-cell.ada-kelas {
            background: linear-gradient(135deg, #e8f4f8 0%, #f0e8ff 100%);
        }

        .kelas-name {
            font-weight: 700;
            color: #333;
            font-size: 13px;
        }

        .room-name {
            color: #666;
            font-size: 11px;
        }

        .scroll-x {
            overflow-x: auto;
            margin-top: 20px;
        }

        .jadwal-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
        }
    </style>

    <?php
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
        
        // Kelompokkan jadwal per hari dan ruangan
        $jadwalPerHariPerRuang = [];
        foreach ($jadwal as $item) {
            $jadwalPerHariPerRuang[$item->hari][$item->room_id][$item->kelas] = $item;
        }
        
        // Ambil semua ruangan yang memiliki jadwal
        $roomsWithSchedule = [];
        foreach ($jadwal as $item) {
            if (!isset($roomsWithSchedule[$item->room_id])) {
                $roomsWithSchedule[$item->room_id] = $item->room;
            }
        }
    ?>

    <div class="jadwal-container">
        <div class="scroll-x">
            <table class="jadwal-table">
                <thead>
                    <tr>
                        <th>JAM</th>
                        <?php $__currentLoopData = $haris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th><?php echo e($hari); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="time-col"><?php echo e($session['jam']); ?></td>
                            <?php $__currentLoopData = $haris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <?php
                                        // Cek apakah ada jadwal untuk hari dan session ini
                                        $hasSchedule = false;
                                        $scheduleItems = [];
                                        
                                        if (isset($jadwalPerHariPerRuang[$hari])) {
                                            foreach ($jadwalPerHariPerRuang[$hari] as $roomId => $sessions_data) {
                                                if (isset($sessions_data[$session['sesi']])) {
                                                    $scheduleItems[] = $sessions_data[$session['sesi']];
                                                    $hasSchedule = true;
                                                }
                                            }
                                        }
                                    ?>
                                    <?php if($hasSchedule): ?>
                                        <?php $__currentLoopData = $scheduleItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="session-cell ada-kelas">
                                                <div class="kelas-name"><?php echo e($item->class->name); ?></div>
                                                <div class="room-name"><?php echo e($item->room->name); ?></div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="session-cell">-</div>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\menejemen-ruang\resources\views/admin/jadwal_reguler/jadwal_mingguan_per_hari.blade.php ENDPATH**/ ?>