@extends('layouts.app')

@section('title', ($product->exists ? 'Edit' : 'Tambah') . ' Penawaran - CampusReuse')

@section('content')
    <section class="form-card">
        <h1>{{ $product->exists ? 'Edit penawaran barang' : 'Tawarkan barang' }}</h1>
        <p class="muted">Lengkapi informasi barang yang ingin dijual atau didonasikan.</p>

        <form method="POST" enctype="multipart/form-data" action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}">
            @csrf
            @if ($product->exists)
                @method('PUT')
            @endif

            <div class="form-grid offer-grid">
                <div class="field wide">
                    <label for="name">Nama barang</label>
                    <input id="name" name="name" value="{{ old('name', $product->name) }}" maxlength="255" required>
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="field wide">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="4" maxlength="5000" required>{{ old('description', $product->description) }}</textarea>
                    @error('description') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="offer_type">Jenis penawaran</label>
                    <select id="offer_type" name="offer_type" required>
                        @foreach (['dijual' => 'Dijual', 'donasi' => 'Donasi'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('offer_type', $product->offer_type ?: 'dijual') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('offer_type') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="field" id="price-field">
                    <label for="price">Harga (Rp; isi 0 untuk gratis)</label>
                    <input id="price" name="price" type="number" min="0" step="1000" value="{{ old('price', $product->price) }}">
                    @error('price') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="condition">Kondisi barang</label>
                    <select id="condition" name="condition" required>
                        @foreach (['Baru', 'Sangat baik', 'Baik', 'Layak pakai'] as $condition)
                            <option value="{{ $condition }}" @selected(old('condition', $product->condition) === $condition)>{{ $condition }}</option>
                        @endforeach
                    </select>
                    @error('condition') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="category">Kategori</label>
                    <input id="category" name="category" value="{{ old('category', $product->category) }}" maxlength="100" placeholder="Contoh: Buku kuliah" required>
                    @error('category') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="field wide">
                    <label for="campus_location">Lokasi kampus</label>
                    <input id="campus_location" name="campus_location" value="{{ old('campus_location', $product->campus_location) }}" maxlength="150" placeholder="Contoh: Kampus Utama">
                    @error('campus_location') <span class="error">{{ $message }}</span> @enderror
                </div>
                @if ($product->exists && $product->photos)
                    <div class="field wide">
                        <label>Foto saat ini (centang foto yang ingin dihapus)</label>
                        <div class="image-choices">
                            @foreach ($product->photos as $photo)
                                <label class="image-choice">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($photo) }}" alt="Foto {{ $product->name }}">
                                    <span><input type="checkbox" name="remove_images[]" value="{{ $photo }}" style="width:auto" @checked(in_array($photo, old('remove_images', []), true))> Hapus foto</span>
                                </label>
                            @endforeach
                        </div>
                        @error('remove_images.*') <span class="error">{{ $message }}</span> @enderror
                    </div>
                @endif
                <div class="field wide">
                    <label for="images">Foto barang (maksimal 5 foto, JPG/PNG/WEBP, 5 MB per foto)</label>
                    <input id="images" name="images[]" type="file" accept=".jpg,.jpeg,.png,.webp" multiple>
                    <span class="muted">Saat mengedit, foto baru ditambahkan ke foto lama yang tidak dihapus.</span>
                    @error('images') <span class="error">{{ $message }}</span> @enderror
                    @error('images.*') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button class="button" type="submit">{{ $product->exists ? 'Simpan perubahan' : 'Terbitkan penawaran' }}</button>
                <a class="button secondary" href="{{ route('products.mine') }}">Batal</a>
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
@endsection
