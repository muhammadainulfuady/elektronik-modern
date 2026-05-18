@extends('layouts.app')

@section('title', 'Kelola Customer – Admin Elektronik Modern')

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
                <div class="page-title">Kelola Customer</div>
            </div>

            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-ico green">👥</div>
                    <div>
                        <div class="stat-label">Total Customer</div>
                        <div class="stat-val">{{ $users->count() }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico blue">🛒</div>
                    <div>
                        <div class="stat-label">Punya Pesanan</div>
                        <div class="stat-val">{{ $users->where('pesanans_count', '>', 0)->count() }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico teal">📦</div>
                    <div>
                        <div class="stat-label">Total Pesanan</div>
                        <div class="stat-val">{{ $users->sum('pesanans_count') }}</div>
                    </div>
                </div>
            </div>

            @if (session('status'))
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px">
                    <strong>{{ session('status') }}</strong>
                </div>
            @endif

            @if ($errors->any())
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px;color:#ef4444">
                    <strong>Gagal menyimpan data customer:</strong>
                    <ul style="margin:8px 0 0 16px;font-size:12px">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="data-card" style="margin-bottom:16px">
                <div class="data-card-head">
                    <h3>Tambah Customer</h3>
                </div>
                <form method="POST" action="{{ route('admin.users.store') }}" style="padding:16px;display:grid;gap:12px;grid-template-columns:1fr 1fr 1fr auto;align-items:end">
                    @csrf
                    <div>
                        <label style="font-size:12px;color:var(--g500)">Nama</label>
                        <input name="nama" required style="width:100%;padding:10px;border:1px solid var(--g200);border-radius:8px">
                    </div>
                    <div>
                        <label style="font-size:12px;color:var(--g500)">Email</label>
                        <input type="email" name="email" required style="width:100%;padding:10px;border:1px solid var(--g200);border-radius:8px">
                    </div>
                    <div>
                        <label style="font-size:12px;color:var(--g500)">Password</label>
                        <input type="password" name="password" required style="width:100%;padding:10px;border:1px solid var(--g200);border-radius:8px">
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit">Tambah</button>
                    </div>
                </form>
            </div>

            <div class="data-card">
                <div class="data-card-head">
                    <h3>Daftar Customer</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Jumlah Pesanan</th>
                            <th>Aksi</th>
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
                                    <span class="badge badge-success">👤 {{ ucfirst($user->role) }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $user->pesanans_count }} pesanan</span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px">
                                        <a class="btn-edit" href="{{ route('admin.users.edit', $user) }}">Edit</a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin ingin menghapus customer ini? Semua data pesanan miliknya juga akan terhapus.')">
                                            @csrf @method('DELETE')
                                            <button class="btn-del" type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;color:var(--g400);padding:18px">Belum ada customer.</td>
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