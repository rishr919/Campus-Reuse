

<?php $__env->startSection('title', 'Cari Barang - CampusReuse'); ?>

<?php $__env->startSection('content'); ?>
    <section class="search-page">
        <h1>Cari barang yang kamu butuhkan</h1>
        <p class="muted">Temukan barang preloved yang pas untuk kebutuhan kuliah dan sehari-harimu.</p>

        <form class="search-form" method="GET" action="<?php echo e(route('products.search')); ?>" role="search">
            <div class="search-input-wrap">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"></circle><path d="m16 16 4.5 4.5"></path></svg>
                <input type="search" name="q" value="<?php echo e($term); ?>" placeholder="Cari nama barang, merek, atau kategori" aria-label="Cari barang" autofocus>
            </div>
            <button class="button" type="submit">Cari</button>
        </form>

        <?php if($term !== ''): ?>
            <div class="suggestions">
                <p class="suggestions-title">Saran pencarian</p>
                <?php $__empty_1 = true; $__currentLoopData = $suggestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a class="suggestion-link" href="<?php echo e(route('products.index', ['q' => $suggestion])); ?>">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"></circle><path d="m16 16 4.5 4.5"></path></svg>
                        <?php echo e($suggestion); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="muted" style="margin:8px 0;font-size:13px">Belum ada saran barang yang cocok.</p>
                <?php endif; ?>
                <a class="suggestion-link" href="<?php echo e(route('products.index', ['q' => $term])); ?>">Lihat semua hasil untuk “<?php echo e($term); ?>”</a>
            </div>
        <?php endif; ?>

        <p class="muted" style="margin:11px 0 0;font-size:11px">Ketik nama, merek, atau kategori barang yang ingin kamu cari.</p>

        <?php if($categories->isNotEmpty()): ?>
            <section class="popular">
                <h2>Pencarian populer</h2>
                <div class="chip-list">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="chip" href="<?php echo e(route('products.index', ['category' => $category])); ?>"><?php echo e($category); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel-app\resources\views/products/search.blade.php ENDPATH**/ ?>