

<?php $__env->startSection('title', 'Katalog Barang - CampusReuse'); ?>

<?php $__env->startSection('content'); ?>
    <section class="catalog-panel">
        <div class="catalog-head">
            <h1>Temukan barang untuk kebutuhan kampusmu</h1>
            <p class="muted">Pilih barang bekas berkualitas atau temukan barang gratis dari sesama mahasiswa.</p>
        </div>

        <form class="filters" method="GET" action="<?php echo e(route('products.index')); ?>">
            <?php if(filled($filters['q'] ?? null)): ?>
                <input type="hidden" name="q" value="<?php echo e($filters['q']); ?>">
            <?php endif; ?>
            <div class="field">
                <label for="category">Kategori</label>
                <select id="category" name="category">
                    <option value="">Semua kategori</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category); ?>" <?php if(($filters['category'] ?? '') === $category): echo 'selected'; endif; ?>><?php echo e($category); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="field">
                <label for="location">Lokasi kampus</label>
                <select id="location" name="location">
                    <option value="">Semua lokasi</option>
                    <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($location); ?>" <?php if(($filters['location'] ?? '') === $location): echo 'selected'; endif; ?>><?php echo e($location); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <button class="button" type="submit">Terapkan Filter</button>
            <?php if(filled($filters['category'] ?? null) || filled($filters['location'] ?? null) || filled($filters['q'] ?? null)): ?>
                <a class="button secondary" href="<?php echo e(route('products.index')); ?>">Reset Filter</a>
            <?php endif; ?>
        </form>

        <?php if(filled($filters['q'] ?? null)): ?>
            <p class="muted">Hasil pencarian untuk <strong><?php echo e($filters['q']); ?></strong></p>
        <?php endif; ?>

        <section class="grid" aria-label="Daftar barang">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="card">
                    <div class="product-image">
                        <?php if($product->photos): ?>
                            <div class="product-gallery">
                                <?php $__currentLoopData = $product->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($photo)); ?>" alt="Foto <?php echo e($product->name); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <span>Foto belum tersedia</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h2 class="card-title"><?php echo e($product->name); ?></h2>
                        <div class="price">
                            <?php if($product->offer_type === 'donasi' || $product->price === null || (float) $product->price === 0.0): ?>
                                Gratis
                            <?php else: ?>
                                Rp<?php echo e(number_format((float) $product->price, 0, ',', '.')); ?>

                            <?php endif; ?>
                        </div>
                        <div class="badges">
                            <span class="badge"><?php echo e(ucfirst($product->offer_type ?: 'dijual')); ?></span>
                            <span class="badge"><?php echo e($product->condition); ?></span>
                            <span class="badge"><?php echo e($product->category); ?></span>
                            <span class="badge status"><?php echo e(ucfirst($product->status)); ?></span>
                        </div>
                        <p class="description"><?php echo e($product->description); ?></p>
                        <div class="muted" style="font-size:12px"><?php echo e($product->campus_location ?: 'Lokasi belum dicantumkan'); ?></div>
                        <div class="owner">
                            <strong><?php echo e($product->owner->name); ?></strong>
                            <div class="muted"><?php echo e($product->owner->email); ?></div>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty">
                    <h2>Belum ada barang yang cocok</h2>
                    <p class="muted">Coba ubah filter atau kunjungi lagi nanti.</p>
                </div>
            <?php endif; ?>
        </section>

        <div class="pagination"><?php echo e($products->links()); ?></div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel-app\resources\views/products/index.blade.php ENDPATH**/ ?>