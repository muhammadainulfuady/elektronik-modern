@extends('layouts.app')

@section('title', 'Masuk - Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}">
@endsection

@section('header')
@endsection

@section('content')
    <div class="auth-bg">
        <div class="auth-card">
            <div class="auth-logo-mark"><i class="fi fi-rr-bolt" style="color:var(--blue)"></i></div>
            <div class="auth-title">Selamat Datang!</div>
            <div class="auth-sub">Masuk ke akun Elektronik Modern Anda</div>

            @if (session('status'))
                <div
                    style="background:var(--sl);color:#15803D;padding:10px 14px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px;text-align:center">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div
                    style="background:var(--dl);color:#991B1B;padding:10px 14px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                        required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password..." required>
                </div>
                <div style="text-align:right;margin:-8px 0 16px">
                    <a href="{{ route('password.request') }}"
                        style="font-size:13px;color:var(--blue);font-weight:700;text-decoration:none">
                        Lupa password?
                    </a>
                </div>
                <button class="btn btn-primary" type="submit"
                    style="width:100%;justify-content:center;padding:13px;font-size:15px">
                    Masuk ke Akun
                </button>
            </form>
            <div class="auth-footer-link">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></div>
        </div>
    </div>
@endsection

@section('footer')
@endsection