@extends('layouts.app')

@section('title', 'Kelola Pengguna – Admin Elektronik Modern')

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
                <div class="page-title">Kelola Pengguna</div>
            </div>

            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-ico blue">👥</div>
                    <div>
                        <div class="stat-label">Total Pengguna</div>
                        <div class="stat-val">{{ $users->count() }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico green">🛒</div>
                    <div>
                        <div class="stat-label">Customer</div>
                        <div class="stat-val">{{ $users->where('role', 'customer')->count() }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico teal">🛡️</div>
                    <div>
                        <div class="stat-label">Admin</div>
                        <div class="stat-val">{{ $users->where('role', 'admin')->count() }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico warn">👑</div>
                    <div>
                        <div class="stat-label">Owner</div>
                        <div class="stat-val">{{ $users->where('role', 'owner')->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="data-card">
                <div class="data-card-head">
                    <h3>Daftar Pengguna</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Jumlah Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td style="color:var(--g400);font-size:12px">#{{ $user->id_users }}</td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px">
                                        <div style="width:36px;height:36px;border-radius:50%;background:var(--blue-l);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:var(--blue)">
                                            {{ strtoupper(substr($user->nama, 0, 2)) }}
                                        </div>
                                        <span style="font-weight:700;font-size:13px">{{ $user->nama }}</span>
                                    </div>
                                </td>
                                <td style="font-size:13px;color:var(--g500)">{{ $user->email }}</td>
                                <td>
                                    @php
                                        $roleClass = match ($user->role) {
                                            'admin' => 'badge-info',
                                            'owner' => 'badge-warn',
                                            default => 'badge-success',
                                        };
                                        $roleIcon = match ($user->role) {
                                            'admin' => '🛡️',
                                            'owner' => '👑',
                                            default => '👤',
                                        };
                                    @endphp
                                    <span class="badge {{ $roleClass }}">{{ $roleIcon }} {{ ucfirst($user->role) }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $user->pesanans_count }} pesanan</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;color:var(--g400);padding:18px">Belum ada pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection