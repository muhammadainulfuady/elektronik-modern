@extends('layouts.app')

@section('title', 'Lupa Password - Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}">
@endsection

@section('header')
@endsection

@section('content')
    <div class="auth-bg">
        <div class="auth-card">
            <div class="auth-logo-mark">?</div>
            <div class="auth-title">Lupa Password</div>
            <div class="auth-sub">Masukkan email akun Anda untuk melanjutkan reset password</div>

            @if ($errors->any())
                <div style="background:var(--dl);color:#991B1B;padding:10px 14px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email.verify') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
                </div>
                <button class="btn btn-primary" type="submit"
                    style="width:100%;justify-content:center;padding:13px;font-size:15px">
                    Lanjutkan
                </button>
            </form>

            <div class="divider">atau</div>
            <div class="auth-footer-link">Ingat password? <a href="{{ route('login') }}">Masuk di sini</a></div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
