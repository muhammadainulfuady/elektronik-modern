@extends('layouts.app')

@section('title', 'Masuk – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}">
@endsection

@section('header')
@endsection

@section('content')
    <div class="auth-bg">
        <div class="auth-card">
            <div class="auth-logo-mark">⚡</div>
            <div class="auth-title">Selamat Datang!</div>
            <div class="auth-sub">Masuk ke akun Elektronik Modern Anda</div>
            <div class="form-group"><label>Email</label><input type="email" placeholder="nama@email.com"></div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" placeholder="Masukkan password...">
                <div style="text-align:right;margin-top:6px"><a href="#"
                        style="font-size:13px;color:var(--blue);font-weight:700;text-decoration:none">Lupa password?</a>
                </div>
            </div>
            <button class="btn btn-primary" style="width:100%;justify-content:center;padding:13px;font-size:15px"
                onclick="window.location.href='index.html'">Masuk ke Akun</button>
            <div class="divider">atau masuk dengan</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <a href="#" class="social-btn">🌐 Google</a>
                <a href="#" class="social-btn">📘 Facebook</a>
            </div>
            <div class="auth-footer-link">Belum punya akun? <a href="register.html">Daftar sekarang</a></div>
            <div style="margin-top:20px;padding-top:20px;border-top:1px solid var(--g100);text-align:center">
                <div style="font-size:12px;color:var(--g400);margin-bottom:10px">Login sebagai:</div>
                <div style="display:flex;gap:8px;justify-content:center">
                    <a href="admin-dashboard.html" class="btn btn-sm"
                        style="background:var(--blue-l);color:var(--blue);border:none;font-size:12px">🛡️ Admin</a>
                    <a href="owner-dashboard.html" class="btn btn-sm"
                        style="background:var(--wl);color:var(--warn);border:none;font-size:12px">👑 Owner</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection