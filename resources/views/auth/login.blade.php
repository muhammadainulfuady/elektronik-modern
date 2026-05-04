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

            @if (session('status'))
                <div style="background:var(--sl);color:#15803D;padding:10px 14px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px;text-align:center">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background:var(--dl);color:#991B1B;padding:10px 14px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password..." required>
                </div>
                <button class="btn btn-primary" type="submit"
                    style="width:100%;justify-content:center;padding:13px;font-size:15px">
                    Masuk ke Akun
                </button>
            </form>

            <div class="divider">atau</div>

            <div class="auth-footer-link">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></div>

            <div style="margin-top:20px;padding-top:20px;border-top:1px solid var(--g100);text-align:center">
                <div style="font-size:12px;color:var(--g400);margin-bottom:10px">Login cepat (demo):</div>
                <div style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap">
                    <button type="button" class="btn btn-sm"
                        style="background:var(--sl);color:var(--success);border:none;font-size:12px"
                        onclick="document.getElementById('email').value='budi@example.com';document.getElementById('password').value='password'">
                        👤 Customer
                    </button>
                    <button type="button" class="btn btn-sm"
                        style="background:var(--blue-l);color:var(--blue);border:none;font-size:12px"
                        onclick="document.getElementById('email').value='admin@example.com';document.getElementById('password').value='password'">
                        🛡️ Admin
                    </button>
                    <button type="button" class="btn btn-sm"
                        style="background:var(--wl);color:var(--warn);border:none;font-size:12px"
                        onclick="document.getElementById('email').value='owner@example.com';document.getElementById('password').value='password'">
                        👑 Owner
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection