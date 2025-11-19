<?php $__env->startSection('title', 'Manajemen Room'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-header h3 {
            font-weight: 700;
        }

        .btn-add {
            background: linear-gradient(135deg, #42e695, #3bb2b8);
            color: white;
            border: none;
            transition: 0.2s;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .table-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table thead {
            background: #f9fafb;
            font-weight: 600;
        }

        .btn-sm {
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 13px;
        }

        .btn-edit {
            background-color: #6c63ff;
            color: #fff;
            border: none;
        }

        .btn-edit:hover {
            background-color: #5848e5;
        }

        .btn-delete {
            background-color: #ff5e5e;
            color: #fff;
            border: none;
        }

        .btn-delete:hover {
            background-color: #e14b4b;
        }

        .alert {
            border-radius: 10px;
        }
    </style>

    <div class="container-fluid px-4 py-4">

        <div class="page-header">
            <h3>Manajemen Room</h3>
            <div>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary me-2">Kembali</a>
                <a href="<?php echo e(route('admin.rooms.create')); ?>" class="btn btn-add">+ Tambah Room</a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="card table-card">
            <div class="card-body p-0">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Nama Room</th>
                            <th>Kapasitas</th>
                            <th>Deskripsi</th>
                            <th class="text-center" style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center"><?php echo e($index + 1); ?></td>
                                <td><?php echo e($room->name); ?></td>
                                <td><?php echo e($room->capacity); ?></td>
                                <td><?php echo e($room->description); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('admin.rooms.edit', $room->id)); ?>"
                                        class="btn btn-sm btn-edit me-1">Edit</a>
                                    <form action="<?php echo e(route('admin.rooms.delete', $room->id)); ?>" method="POST"
                                        style="display:inline-block;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-delete"
                                            onclick="return confirm('Hapus Room ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada data room</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\menejemen-ruang\resources\views/admin/rooms/index.blade.php ENDPATH**/ ?>