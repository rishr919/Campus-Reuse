@extends('layouts.app')

@section('title', 'Barang Saya - CampusReuse')

@section('content')
    <section class="catalog-panel">
        <div class="page-heading">
            <div>
                <h1>Barang Saya</h1>
                <p class="muted">Kelola barang yang kamu jual atau donasikan.</p>
            </div>
            <a class="button" href="{{ route('products.create') }}">Tawarkan Barang</a>
        </div>

        @if (session('success'))
            <div class="notice">{{ session('success') }}</div>
        @endif

        <section style="display:grid;gap:14px" aria-label="Daftar barang milik saya">
            @forelse ($products as $product)
                <article class="my-listing">
                    <div class="product-image">
                        @if ($product->photos)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($product->photos[0]) }}" alt="Foto {{ $product->name }}">
                        @else
                            <span>Foto belum tersedia</span>
                        @endif
                    </div>
                    <div>
                        <div class="my-listing-head">
                            <div>
                                <h2 class="card-title">{{ $product->name }}</h2>
                                <span class="badge">{{ ucfirst($product->offer_type ?: 'dijual') }}</span>
                                <span class="badge">{{ ucfirst($product->status) }}</span>
                            </div>
                            <strong class="price">
                                @if ($product->offer_type === 'donasi')
                                    Donasi
                                @elseif ($product->price === null || (float) $product->price === 0.0)
                                    Gratis
                                @else
                                    Rp{{ number_format((float) $product->price, 0, ',', '.') }}
                                @endif
                            </strong>
                        </div>
                        <p class="description">{{ $product->description }}</p>
                        <p class="muted">{{ $product->category }} · {{ $product->condition }} · {{ $product->campus_location ?: 'Lokasi belum dicantumkan' }}</p>
                        <div class="listing-actions">
                            <a class="button secondary" href="{{ route('products.edit', $product) }}">Edit</a>
                            <form method="POST" action="{{ route('products.status', $product) }}">
                                @csrf
                                @method('PATCH')
                                <label class="muted" for="status-{{ $product->id }}">Status</label>
                                <select id="status-{{ $product->id }}" name="status" onchange="this.form.submit()">
                                    @foreach (['tersedia' => 'Tersedia', 'dipesan' => 'Dipesan', 'selesai' => 'Selesai'] as $value => $label)
                                        <option value="{{ $value }}" @selected($product->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                            <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Hapus penawaran barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="button secondary" type="submit">Hapus</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty">
                    <h2>Kamu belum menawarkan barang</h2>
                    <p class="muted">Tambahkan barang yang ingin dijual atau didonasikan.</p>
                    <a class="button" href="{{ route('products.create') }}">Tawarkan Barang</a>
                </div>
            @endforelse
        </section>
        <div class="pagination">{{ $products->links() }}</div>
    </section>
@endsection
