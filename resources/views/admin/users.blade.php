@extends('layouts.app')

@section('title', 'Kelola Pengguna – Admin Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}">
@endsection

@section('header')
@endsection

@section('content')
    <div class="admin-layout">
        <div class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-name">⚡ Elektronik Modern</div>
                <div class="sidebar-brand-role">Panel Administrator</div>
            </div>
            <div class="s-group">Menu Utama</div>
            <a href="admin-dashboard.html" class="s-item"><span class="si">📊</span> Dashboard</a>
            <a href="admin-products.html" class="s-item"><span class="si">📦</span> Kelola Produk</a>
            <a href="admin-orders.html" class="s-item"><span class="si">🧾</span> Kelola Pesanan</a>
            <a href="admin-users.html" class="s-item active"><span class="si">👥</span> Kelola Pengguna</a>
            <div class="s-group">Akun</div>
            <a href="login.html" class="s-item"><span class="si">🚪</span> Keluar</a>
        </div>
        <div class="admin-main">
            <div class="admin-topbar">
                <div class="page-title">Kelola Pengguna</div>
                <input placeholder="Cari pengguna..." style="width:240px;padding:10px 16px;font-size:13px">
            </div>
            <div class="stat-grid" style="grid-template-columns:repeat(3,1fr)">
                <div class="stat-card">
                    <div class="stat-ico green">👤</div>
                    <div>
                        <div class="stat-label">Total Customer</div>
                        <div class="stat-val">1.842</div>
                        <div class="stat-chg">↑ 67 bulan ini</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico blue">🛡️</div>
                    <div>
                        <div class="stat-label">Total Admin</div>
                        <div class="stat-val">3</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico warn">👑</div>
                    <div>
                        <div class="stat-label">Total Owner</div>
                        <div class="stat-val">1</div>
                    </div>
                </div>
            </div>
            <div class="data-card">
                <div class="data-card-head">
                    <h3>Daftar Pengguna</h3>
                    <select style="width:auto;padding:8px 12px;font-size:13px">
                        <option>Semua Role</option>
                        <option>Customer</option>
                        <option>Admin</option>
                        <option>Owner</option>
                    </select>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Role</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="color:var(--g400);font-size:12px">#U001</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div
                                        style="width:34px;height:34px;border-radius:50%;background:var(--blue-l);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:var(--blue)">
                                        BS</div><span style="font-weight:700;font-size:13px">Budi Santoso</span>
                                </div>
                            </td>
                            <td style="font-size:13px">budi.s@email.com</td>
                            <td style="font-size:13px">0812-3456-7890</td>
                            <td><span class="badge badge-info">Customer</span></td>
                            <td style="font-size:12px;color:var(--g400)">01 Nov 2024</td>
                            <td>
                                <div style="display:flex;gap:6px"><button class="btn-edit">Edit</button><button
                                        class="btn-del">Hapus</button></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color:var(--g400);font-size:12px">#U002</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div
                                        style="width:34px;height:34px;border-radius:50%;background:var(--teal-l);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:var(--teal)">
                                        SR</div><span style="font-weight:700;font-size:13px">Siti Rahayu</span>
                                </div>
                            </td>
                            <td style="font-size:13px">siti.r@email.com</td>
                            <td style="font-size:13px">0821-9876-5432</td>
                            <td><span class="badge badge-info">Customer</span></td>
                            <td style="font-size:12px;color:var(--g400)">15 Oct 2024</td>
                            <td>
                                <div style="display:flex;gap:6px"><button class="btn-edit">Edit</button><button
                                        class="btn-del">Hapus</button></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color:var(--g400);font-size:12px">#A001</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div
                                        style="width:34px;height:34px;border-radius:50%;background:var(--blue);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#fff">
                                        JK</div><span style="font-weight:700;font-size:13px">Joni Kumar Meghwar</span>
                                </div>
                            </td>
                            <td style="font-size:13px">joni.k@Elektronik Modern.id</td>
                            <td style="font-size:13px">0813-1111-2222</td>
                            <td><span class="badge badge-pend">Admin</span></td>
                            <td style="font-size:12px;color:var(--g400)">01 Jan 2024</td>
                            <td>
                                <div style="display:flex;gap:6px"><button class="btn-edit">Edit</button></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color:var(--g400);font-size:12px">#A002</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div
                                        style="width:34px;height:34px;border-radius:50%;background:var(--blue);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#fff">
                                        MF</div><span style="font-weight:700;font-size:13px">Muhammad Farhan</span>
                                </div>
                            </td>
                            <td style="font-size:13px">m.farhan@Elektronik Modern.id</td>
                            <td style="font-size:13px">0856-3333-4444</td>
                            <td><span class="badge badge-pend">Admin</span></td>
                            <td style="font-size:12px;color:var(--g400)">01 Jan 2024</td>
                            <td>
                                <div style="display:flex;gap:6px"><button class="btn-edit">Edit</button></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color:var(--g400);font-size:12px">#O001</td>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <div
                                        style="width:34px;height:34px;border-radius:50%;background:var(--wl);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:var(--warn)">
                                        AF</div><span style="font-weight:700;font-size:13px">M. Ainul Fuady</span>
                                </div>
                            </td>
                            <td style="font-size:13px">fuady@Elektronik Modern.id</td>
                            <td style="font-size:13px">0878-5555-6666</td>
                            <td><span class="badge badge-warn">Owner</span></td>
                            <td style="font-size:12px;color:var(--g400)">01 Jan 2024</td>
                            <td>
                                <div style="display:flex;gap:6px"><button class="btn-edit">Edit</button></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection