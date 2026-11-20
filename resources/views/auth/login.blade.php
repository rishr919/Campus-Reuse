@extends('layouts.app')

@section('title', 'Masuk - CampusReuse')

@section('content')
    <div class="auth-page">
        <section class="auth-card">
            <h1>Selamat datang kembali</h1>
            <p class="muted">Masuk untuk melanjutkan belanja di CampusReuse.</p>
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Masukkan alamat email" required autocomplete="email" autofocus>
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="field">
                    <label for="password">Kata sandi</label>
                    <input id="password" name="password" type="password" placeholder="Masukkan kata sandi" required autocomplete="current-password">
                    @error('password') <span class="error">{{ $message }}</span> @enderror
                </div>
                <button class="button" type="submit">Masuk</button>
            </form>
            <p class="muted auth-foot">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
        </section>
    </div>
@endsection
