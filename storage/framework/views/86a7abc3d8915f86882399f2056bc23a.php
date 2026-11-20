

<?php $__env->startSection('title', 'Daftar - CampusReuse'); ?>

<?php $__env->startSection('content'); ?>
    <div class="auth-page">
        <section class="auth-card">
            <h1>Buat akun baru</h1>
            <p class="muted">Daftar dan temukan barang preloved pilihanmu.</p>
            <form method="POST" action="<?php echo e(route('register.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="field">
                    <label for="name">Nama lengkap</label>
                    <input id="name" name="name" value="<?php echo e(old('name')); ?>" placeholder="Masukkan nama lengkap" required autocomplete="name" autofocus>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" placeholder="Masukkan alamat email" required autocomplete="email">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="field">
                    <label for="password">Kata sandi</label>
                    <input id="password" name="password" type="password" placeholder="Buat kata sandi" required autocomplete="new-password">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="field">
                    <label for="password_confirmation">Ulangi kata sandi</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Masukkan kembali kata sandi" required autocomplete="new-password">
                </div>
                <button class="button" type="submit">Daftar</button>
            </form>
            <p class="muted auth-foot">Sudah punya akun? <a href="<?php echo e(route('login')); ?>">Masuk</a></p>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel-app\resources\views/auth/register.blade.php ENDPATH**/ ?>