<?php $__env->startSection('title', 'Daftar Room Petugas'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h3>Daftar Room</h3>
      <a href="<?php echo e(route('petugas.dashboard')); ?>" class="btn btn-secondary mb-3">Kembali</a>
    <a href="<?php echo e(route('petugas.rooms.create')); ?>" class="btn btn-success mb-3">Tambah Room</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Room</th>
                <th>Kapasitas</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($room->name); ?></td>
                <td><?php echo e($room->capacity); ?></td>
                <td><?php echo e($room->description); ?></td>
                <td>
                    <form action="<?php echo e(route('petugas.rooms.delete', $room->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus room?')">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\menejemen-ruang\resources\views/petugas/rooms/index.blade.php ENDPATH**/ ?>