@extends('layouts.app')

@section('title', 'Reset Password - Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}">
@endsection

@section('header')
@endsection

@section('content')
    <div class="auth-bg">
        <div class="auth-card">
            <div class="auth-logo-mark">*</div>
            <div class="auth-title">Password Baru</div>
            <div class="auth-sub">Buat password baru untuk akun {{ $email }}</div>

            @if ($errors->any())
                <div style="background:var(--dl);color:#991B1B;padding:10px 14px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru..." required>
                </div>
                <button class="btn btn-primary" type="submit"
                    style="width:100%;justify-content:center;padding:13px;font-size:15px">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
@endsection

@section('footer')
@endsection
