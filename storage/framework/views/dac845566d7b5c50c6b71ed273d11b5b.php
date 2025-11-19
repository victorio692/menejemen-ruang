<?php $__env->startSection('title', 'Manajemen User'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-md-items-center mb-4 gap-3">
        <h3 class="fw-bold mb-0">Manajemen User</h3>
        <div class="d-grid gap-2 gap-md-3 w-100 w-md-auto d-md-flex">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
            <a href="<?php echo e(route('admin.petugas.create')); ?>" class="btn btn-success">
                <i class="bi bi-plus-circle me-2"></i> Tambah User
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($user->name); ?></td>
                <td><?php echo e($user->email); ?></td>
                <td>
                    <span class="badge <?php echo e($user->role === 'petugas' ? 'bg-primary' : 'bg-info'); ?>">
                        <?php echo e(ucfirst($user->role)); ?>

                    </span>
                </td>
                <td>
                    <a href="<?php echo e(route('admin.petugas.edit', $user->id)); ?>" class="btn btn-primary btn-sm">Edit</a>
                    <form action="<?php echo e(route('admin.petugas.delete', $user->id)); ?>" method="POST" style="display:inline-block;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\menejemen-ruang\resources\views/admin/petugas/index.blade.php ENDPATH**/ ?>