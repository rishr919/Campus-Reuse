

<?php $__env->startSection('title', 'Barang Saya - CampusReuse'); ?>

<?php $__env->startSection('content'); ?>
    <section class="catalog-panel">
        <div class="page-heading">
            <div>
                <h1>Barang Saya</h1>
                <p class="muted">Kelola barang yang kamu jual atau donasikan.</p>
            </div>
            <a class="button" href="<?php echo e(route('products.create')); ?>">Tawarkan Barang</a>
        </div>

        <?php if(session('success')): ?>
            <div class="notice"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <section style="display:grid;gap:14px" aria-label="Daftar barang milik saya">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="my-listing">
                    <div class="product-image">
                        <?php if($product->photos): ?>
                            <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($product->photos[0])); ?>" alt="Foto <?php echo e($product->name); ?>">
                        <?php else: ?>
                            <span>Foto belum tersedia</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <div class="my-listing-head">
                            <div>
                                <h2 class="card-title"><?php echo e($product->name); ?></h2>
                                <span class="badge"><?php echo e(ucfirst($product->offer_type ?: 'dijual')); ?></span>
                                <span class="badge"><?php echo e(ucfirst($product->status)); ?></span>
                            </div>
                            <strong class="price">
                                <?php if($product->offer_type === 'donasi'): ?>
                                    Donasi
                                <?php elseif($product->price === null || (float) $product->price === 0.0): ?>
                                    Gratis
                                <?php else: ?>
                                    Rp<?php echo e(number_format((float) $product->price, 0, ',', '.')); ?>

                                <?php endif; ?>
                            </strong>
                        </div>
                        <p class="description"><?php echo e($product->description); ?></p>
                        <p class="muted"><?php echo e($product->category); ?> · <?php echo e($product->condition); ?> · <?php echo e($product->campus_location ?: 'Lokasi belum dicantumkan'); ?></p>
                        <div class="listing-actions">
                            <a class="button secondary" href="<?php echo e(route('products.edit', $product)); ?>">Edit</a>
                            <form method="POST" action="<?php echo e(route('products.status', $product)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <label class="muted" for="status-<?php echo e($product->id); ?>">Status</label>
                                <select id="status-<?php echo e($product->id); ?>" name="status" onchange="this.form.submit()">
                                    <?php $__currentLoopData = ['tersedia' => 'Tersedia', 'dipesan' => 'Dipesan', 'selesai' => 'Selesai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($value); ?>" <?php if($product->status === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </form>
                            <form method="POST" action="<?php echo e(route('products.destroy', $product)); ?>" onsubmit="return confirm('Hapus penawaran barang ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="button secondary" type="submit">Hapus</button>
                            </form>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty">
                    <h2>Kamu belum menawarkan barang</h2>
                    <p class="muted">Tambahkan barang yang ingin dijual atau didonasikan.</p>
                    <a class="button" href="<?php echo e(route('products.create')); ?>">Tawarkan Barang</a>
                </div>
            <?php endif; ?>
        </section>
        <div class="pagination"><?php echo e($products->links()); ?></div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel-app\resources\views/products/mine.blade.php ENDPATH**/ ?>