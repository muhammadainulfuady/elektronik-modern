@extends('layouts.app')

@section('title', 'Edit Customer – Admin')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}">
@endsection

@section('header')
@endsection

@section('content')
    <div class="admin-layout">
        @include('partials.admin-sidebar')

        <div class="admin-main">
            <div class="admin-topbar">
                <div class="page-title">
                    <a href="{{ route('admin.users.index') }}" style="color:var(--g500);text-decoration:none">Kelola Customer</a> 
                    <span style="color:var(--g300);margin:0 8px">›</span> Edit
                </div>
            </div>

            @if ($errors->any())
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px;color:#ef4444">
                    <strong>Gagal menyimpan data:</strong>
                    <ul style="margin:8px 0 0 16px;font-size:12px">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="data-card">
                <div class="data-card-head">
                    <h3>Edit Customer: {{ $user->nama }}</h3>
                </div>
                <form method="POST" action="{{ route('admin.users.update', $user) }}" style="padding:20px;display:grid;gap:16px;max-width:500px">
                    @csrf @method('PUT')
                    <div>
                        <label style="display:block;margin-bottom:6px;font-size:13px;font-weight:700">Nama</label>
                        <input name="nama" value="{{ old('nama', $user->nama) }}" required style="width:100%;padding:10px;border:1px solid var(--g200);border-radius:8px">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-size:13px;font-weight:700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width:100%;padding:10px;border:1px solid var(--g200);border-radius:8px">
                    </div>
                    <div>
                        <label style="display:block;margin-bottom:6px;font-size:13px;font-weight:700">Password Baru (Opsional)</label>
                        <input type="password" name="password" style="width:100%;padding:10px;border:1px solid var(--g200);border-radius:8px">
                        <div style="font-size:11px;color:var(--g400);margin-top:4px">Kosongkan jika tidak ingin mengubah password.</div>
                    </div>
                    <div style="margin-top:10px">
                        <button class="btn btn-primary" type="submit" style="display:inline-flex;align-items:center;gap:8px"><i class="fi fi-rr-disk"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
