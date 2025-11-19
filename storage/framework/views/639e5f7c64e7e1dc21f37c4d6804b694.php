<?php $__env->startSection('title', 'Login - Menejemen Ruang'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">🏢</div>
        <h2 class="auth-title">Selamat Datang</h2>
        <p class="auth-subtitle">Silakan login untuk melanjutkan</p>
    </div>

    <!-- Error Alert -->
    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form action="<?php echo e(route('login')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   value="<?php echo e(old('email')); ?>" placeholder="Masukkan email Anda" required>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   placeholder="Masukkan password Anda" required>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </button>
    </form>

    <div class="auth-footer">
        <p>Belum punya akun? <a href="<?php echo e(route('register')); ?>">Daftar di sini</a></p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\menejemen-ruang\resources\views/auth/login.blade.php ENDPATH**/ ?>