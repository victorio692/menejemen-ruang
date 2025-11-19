<?php $__env->startSection('title', 'Manajemen Jadwal Reguler'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h3 class="mb-4">Manajemen Jadwal Reguler</h3>

    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary mb-3">Kembali</a>
    <a href="<?php echo e(route('admin.jadwal_reguler.create')); ?>" class="btn btn-success mb-3">Tambah Jadwal</a>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php
        // Kelompokkan jadwal berdasarkan nama room (kelas)
        $grouped = $jadwal->groupBy(fn($item) => $item->room->nama_room ?? 'Tidak Ada Kelas');
    ?>

    <?php $__empty_1 = true; $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong><?php echo e(strtoupper($kelas)); ?></strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Keterangan</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($item->hari); ?></td>
                                <td><?php echo e($item->start_time); ?> - <?php echo e($item->end_time); ?></td>
                                <td><?php echo e($item->keterangan ?? '-'); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.jadwal_reguler.edit', $item->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="<?php echo e(route('admin.jadwal_reguler.delete', $item->id)); ?>" method="POST" style="display:inline-block;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus jadwal ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="alert alert-warning text-center">
            Belum ada jadwal reguler.
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\menejemen-ruang\resources\views/admin/jadwal_reguler/index.blade.php ENDPATH**/ ?>