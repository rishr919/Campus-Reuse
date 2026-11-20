@extends('layouts.app')

@section('title', 'Daftar - CampusReuse')

@section('content')
    <div class="auth-page">
        <section class="auth-card">
            <h1>Buat akun baru</h1>
            <p class="muted">Daftar dan temukan barang preloved pilihanmu.</p>
            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="field">
                    <label for="name">Nama lengkap</label>
                    <input id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autocomplete="name" autofocus>
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Masukkan alamat email" required autocomplete="email">
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="password">Kata sandi</label>
                    <input id="password" name="password" type="password" placeholder="Buat kata sandi" required autocomplete="new-password">
                    @error('password') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="password_confirmation">Ulangi kata sandi</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Masukkan kembali kata sandi" required autocomplete="new-password">
                </div>
                <button class="button" type="submit">Daftar</button>
            </form>
            <p class="muted auth-foot">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </section>
    </div>
@endsection
