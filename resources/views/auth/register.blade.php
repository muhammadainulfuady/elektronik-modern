@extends('layouts.app')

@section('title', 'Daftar – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}">
@endsection

@section('header')
@endsection

@section('content')
    <div class="auth-bg">
        <div class="auth-card">
            <div class="auth-logo-mark">📝</div>
            <div class="auth-title">Buat Akun Baru</div>
            <div class="auth-sub">Bergabung dengan Elektronik Modern — gratis!</div>

            @if ($errors->any())
                <div style="background:var(--dl);color:#991B1B;padding:10px 14px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap..." required autofocus>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password..." required>
                </div>
                <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:18px;font-size:13px;color:var(--g600)">
                    <input type="checkbox" required
                        style="width:16px;height:16px;margin-top:2px;accent-color:var(--blue);flex-shrink:0">
                    <span>Saya menyetujui <a href="#"
                            style="color:var(--blue);font-weight:700;text-decoration:none">Syarat
                            & Ketentuan</a> dan <a href="#"
                            style="color:var(--blue);font-weight:700;text-decoration:none">Kebijakan Privasi</a> Elektronik
                        Modern</span>
                </div>
                <button class="btn btn-primary" type="submit"
                    style="width:100%;justify-content:center;padding:13px;font-size:15px">🚀 Daftar Sekarang</button>
            </form>

            <div class="divider">atau</div>
            <div class="auth-footer-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></div>
        </div>
    </div>
@endsection

@section('footer')
@endsection