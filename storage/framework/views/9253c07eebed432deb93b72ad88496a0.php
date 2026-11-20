

<?php $__env->startSection('title', ($product->exists ? 'Edit' : 'Tambah') . ' Penawaran - CampusReuse'); ?>

<?php $__env->startSection('content'); ?>
    <section class="form-card">
        <h1><?php echo e($product->exists ? 'Edit penawaran barang' : 'Tawarkan barang'); ?></h1>
        <p class="muted">Lengkapi informasi barang yang ingin dijual atau didonasikan.</p>

        <form method="POST" enctype="multipart/form-data" action="<?php echo e($product->exists ? route('products.update', $product) : route('products.store')); ?>">
            <?php echo csrf_field(); ?>
            <?php if($product->exists): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="form-grid offer-grid">
                <div class="field wide">
                    <label for="name">Nama barang</label>
                    <input id="name" name="name" value="<?php echo e(old('name', $product->name)); ?>" maxlength="255" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="field wide">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" maxlength="5000" required><?php echo e(old('description', $product->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="field">
                    <label for="offer_type">Jenis penawaran</label>
                    <select id="offer_type" name="offer_type" required>
                        <?php $__currentLoopData = ['dijual' => 'Dijual', 'donasi' => 'Donasi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php if(old('offer_type', $product->offer_type ?: 'dijual') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['offer_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="field" id="price-field">
                    <label for="price">Harga (Rp; isi 0 untuk gratis)</label>
                    <input id="price" name="price" type="number" min="0" step="1000" value="<?php echo e(old('price', $product->price)); ?>">
                    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="field">
                    <label for="condition">Kondisi barang</label>
                    <select id="condition" name="condition" required>
                        <?php $__currentLoopData = ['Baru', 'Sangat baik', 'Baik', 'Layak pakai']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($condition); ?>" <?php if(old('condition', $product->condition) === $condition): echo 'selected'; endif; ?>><?php echo e($condition); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['condition'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="field">
                    <label for="category">Kategori</label>
                    <input id="category" name="category" value="<?php echo e(old('category', $product->category)); ?>" maxlength="100" placeholder="Contoh: Buku kuliah" required>
                    <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="field wide">
                    <label for="campus_location">Lokasi kampus</label>
                    <input id="campus_location" name="campus_location" value="<?php echo e(old('campus_location', $product->campus_location)); ?>" maxlength="150" placeholder="Contoh: Kampus Utama">
                    <?php $__errorArgs = ['campus_location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <?php if($product->exists && $product->photos): ?>
                    <div class="field wide">
                        <label>Foto saat ini (centang foto yang ingin dihapus)</label>
                        <div class="image-choices">
                            <?php $__currentLoopData = $product->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="image-choice">
                                    <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($photo)); ?>" alt="Foto <?php echo e($product->name); ?>">
                                    <span><input type="checkbox" name="remove_images[]" value="<?php echo e($photo); ?>" style="width:auto" <?php if(in_array($photo, old('remove_images', []), true)): echo 'checked'; endif; ?>> Hapus foto</span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php $__errorArgs = ['remove_images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                <?php endif; ?>
                <div class="field wide">
                    <label for="images">Foto barang (maksimal 5 foto, JPG/PNG/WEBP, 5 MB per foto)</label>
                    <input id="images" name="images[]" type="file" accept=".jpg,.jpeg,.png,.webp" multiple>
                    <span class="muted">Saat mengedit, foto baru ditambahkan ke foto lama yang tidak dihapus.</span>
                    <?php $__errorArgs = ['images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="form-actions">
                <button class="button" type="submit"><?php echo e($product->exists ? 'Simpan perubahan' : 'Terbitkan penawaran'); ?></button>
                <a class="button secondary" href="<?php echo e(route('products.mine')); ?>">Batal</a>
            </div>
        </form>
    </section>
    <script>
        const offerType = document.getElementById('offer_type');
        const price = document.getElementById('price');
        const priceField = document.getElementById('price-field');
        const updatePriceField = () => {
            const isSale = offerType.value === 'dijual';
            price.required = isSale;
            priceField.hidden = !isSale;
        };
        offerType.addEventListener('change', updatePriceField);
        updatePriceField();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel-app\resources\views/products/form.blade.php ENDPATH**/ ?>