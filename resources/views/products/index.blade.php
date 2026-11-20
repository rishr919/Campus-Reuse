@extends('layouts.app')

@section('title', 'Katalog Barang - CampusReuse')

@section('content')
    <section class="catalog-panel">
        <div class="catalog-head">
            <h1>Temukan barang untuk kebutuhan kampusmu</h1>
            <p class="muted">Pilih barang bekas berkualitas atau temukan barang gratis dari sesama mahasiswa.</p>
        </div>

        <form class="filters" method="GET" action="{{ route('products.index') }}">
            @if (filled($filters['q'] ?? null))
                <input type="hidden" name="q" value="{{ $filters['q'] }}">
            @endif
            <div class="field">
                <label for="category">Kategori</label>
                <select id="category" name="category">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected(($filters['category'] ?? '') === $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="location">Lokasi kampus</label>
                <select id="location" name="location">
                    <option value="">Semua lokasi</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location }}" @selected(($filters['location'] ?? '') === $location)>{{ $location }}</option>
                    @endforeach
                </select>
            </div>
            <button class="button" type="submit">Terapkan Filter</button>
            @if (filled($filters['category'] ?? null) || filled($filters['location'] ?? null) || filled($filters['q'] ?? null))
                <a class="button secondary" href="{{ route('products.index') }}">Reset Filter</a>
            @endif
        </form>

        @if (filled($filters['q'] ?? null))
            <p class="muted">Hasil pencarian untuk <strong>{{ $filters['q'] }}</strong></p>
        @endif

        <section class="grid" aria-label="Daftar barang">
            @forelse ($products as $product)
                <article class="card">
                    <div class="product-image">
                        @if ($product->photos)
                            <div class="product-gallery">
                                @foreach ($product->photos as $photo)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($photo) }}" alt="Foto {{ $product->name }}">
                                @endforeach
                            </div>
                        @else
                            <span>Foto belum tersedia</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">{{ $product->name }}</h2>
                        <div class="price">
                            @if ($product->offer_type === 'donasi' || $product->price === null || (float) $product->price === 0.0)
                                Gratis
                            @else
                                Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                            @endif
                        </div>
                        <div class="badges">
                            <span class="badge">{{ ucfirst($product->offer_type ?: 'dijual') }}</span>
                            <span class="badge">{{ $product->condition }}</span>
                            <span class="badge">{{ $product->category }}</span>
                            <span class="badge status">{{ ucfirst($product->status) }}</span>
                        </div>
                        <p class="description">{{ $product->description }}</p>
                        <div class="muted" style="font-size:12px">{{ $product->campus_location ?: 'Lokasi belum dicantumkan' }}</div>
                        <div class="owner">
                            <strong>{{ $product->owner->name }}</strong>
                            <div class="muted">{{ $product->owner->email }}</div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty">
                    <h2>Belum ada barang yang cocok</h2>
                    <p class="muted">Coba ubah filter atau kunjungi lagi nanti.</p>
                </div>
            @endforelse
        </section>

        <div class="pagination">{{ $products->links() }}</div>
    </section>
@endsection
