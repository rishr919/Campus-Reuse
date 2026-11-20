@extends('layouts.app')

@section('title', 'Cari Barang - CampusReuse')

@section('content')
    <section class="search-page">
        <h1>Cari barang yang kamu butuhkan</h1>
        <p class="muted">Temukan barang preloved yang pas untuk kebutuhan kuliah dan sehari-harimu.</p>

        <form class="search-form" method="GET" action="{{ route('products.search') }}" role="search">
            <div class="search-input-wrap">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"></circle><path d="m16 16 4.5 4.5"></path></svg>
                <input type="search" name="q" value="{{ $term }}" placeholder="Cari nama barang, merek, atau kategori" aria-label="Cari barang" autofocus>
            </div>
            <button class="button" type="submit">Cari</button>
        </form>

        @if ($term !== '')
            <div class="suggestions">
                <p class="suggestions-title">Saran pencarian</p>
                @forelse ($suggestions as $suggestion)
                    <a class="suggestion-link" href="{{ route('products.index', ['q' => $suggestion]) }}">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"></circle><path d="m16 16 4.5 4.5"></path></svg>
                        {{ $suggestion }}
                    </a>
                @empty
                    <p class="muted" style="margin:8px 0;font-size:13px">Belum ada saran barang yang cocok.</p>
                @endforelse
                <a class="suggestion-link" href="{{ route('products.index', ['q' => $term]) }}">Lihat semua hasil untuk “{{ $term }}”</a>
            </div>
        @endif

        <p class="muted" style="margin:11px 0 0;font-size:11px">Ketik nama, merek, atau kategori barang yang ingin kamu cari.</p>

        @if ($categories->isNotEmpty())
            <section class="popular">
                <h2>Pencarian populer</h2>
                <div class="chip-list">
                    @foreach ($categories as $category)
                        <a class="chip" href="{{ route('products.index', ['category' => $category]) }}">{{ $category }}</a>
                    @endforeach
                </div>
            </section>
        @endif
    </section>
@endsection
