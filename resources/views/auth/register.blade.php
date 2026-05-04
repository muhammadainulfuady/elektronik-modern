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
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                <div class="form-group"><label>Nama Depan</label><input placeholder="Nama depan..."></div>
                <div class="form-group"><label>Nama Belakang</label><input placeholder="Nama belakang..."></div>
            </div>
            <div class="form-group"><label>Email</label><input type="email" placeholder="nama@email.com"></div>
            <div class="form-group"><label>No. Telepon</label><input type="tel" placeholder="08xx-xxxx-xxxx"></div>
            <div class="form-group"><label>Password</label><input type="password" placeholder="Min. 8 karakter"></div>
            <div class="form-group"><label>Konfirmasi Password</label><input type="password"
                    placeholder="Ulangi password..."></div>
            <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:18px;font-size:13px;color:var(--g600)">
                <input type="checkbox" style="width:16px;height:16px;margin-top:2px;accent-color:var(--blue);flex-shrink:0">
                <span>Saya menyetujui <a href="#" style="color:var(--blue);font-weight:700;text-decoration:none">Syarat
                        & Ketentuan</a> dan <a href="#"
                        style="color:var(--blue);font-weight:700;text-decoration:none">Kebijakan Privasi</a> Elektronik
                    Modern</span>
            </div>
            <button class="btn btn-primary" style="width:100%;justify-content:center;padding:13px;font-size:15px"
                onclick="window.location.href='index.html'">🚀 Daftar Sekarang</button>
            <div class="divider">atau daftar dengan</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <a href="#" class="social-btn">🌐 Google</a>
                <a href="#" class="social-btn">📘 Facebook</a>
            </div>
            <div class="auth-footer-link">Sudah punya akun? <a href="login.html">Masuk di sini</a></div>
        </div>
    </div>
@endsection

@section('footer')
@endsection