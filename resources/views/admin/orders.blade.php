@extends('layouts.app')

@section('title', 'Kelola Pesanan – Admin Elektronik Modern')

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
            <a href="admin-orders.html" class="s-item active"><span class="si">🧾</span> Kelola Pesanan</a>
            <a href="admin-users.html" class="s-item"><span class="si">👥</span> Kelola Pengguna</a>
            <div class="s-group">Akun</div>
            <a href="login.html" class="s-item"><span class="si">🚪</span> Keluar</a>
        </div>
        <div class="admin-main">
            <div class="admin-topbar">
                <div class="page-title">Kelola Pesanan</div>
                <div style="display:flex;gap:8px">
                    <button class="btn btn-outline btn-sm">📤 Export CSV</button>
                    <input placeholder="Cari pesanan..." style="width:200px;padding:8px 14px;font-size:13px">
                </div>
            </div>
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-ico warn">⏳</div>
                    <div>
                        <div class="stat-label">Menunggu</div>
                        <div class="stat-val">14</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico blue">⚙️</div>
                    <div>
                        <div class="stat-label">Diproses</div>
                        <div class="stat-val">22</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico teal">🚚</div>
                    <div>
                        <div class="stat-label">Dikirim</div>
                        <div class="stat-val">31</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico green">✅</div>
                    <div>
                        <div class="stat-label">Selesai</div>
                        <div class="stat-val">156</div>
                    </div>
                </div>
            </div>
            <div class="data-card">
                <div class="data-card-head">
                    <h3>Daftar Pesanan</h3>
                    <select style="width:auto;padding:8px 12px;font-size:13px">
                        <option>Semua Status</option>
                        <option>Menunggu</option>
                        <option>Diproses</option>
                        <option>Dikirim</option>
                        <option>Selesai</option>
                    </select>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Bukti Bayar</th>
                            <th>Status</th>
                            <th>Update Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight:700">#ORD-001</td>
                            <td>
                                <div style="font-weight:700;font-size:13px">Budi Santoso</div>
                                <div style="font-size:11px;color:var(--g400)">06 Des 2024</div>
                            </td>
                            <td style="font-weight:800;color:var(--blue);font-family:'Syne',sans-serif">Rp 6.499.000
                            </td>
                            <td>
                                <div
                                    style="width:44px;height:44px;border-radius:8px;background:var(--g100);border:1.5px solid var(--g200);display:flex;align-items:center;justify-content:center;font-size:20px;cursor:pointer">
                                    🧾</div>
                            </td>
                            <td><span class="badge badge-pend">⏳ Menunggu</span></td>
                            <td><select style="width:auto;padding:6px 10px;font-size:12px">
                                    <option>Menunggu</option>
                                    <option>Diproses</option>
                                    <option>Dikirim</option>
                                    <option>Selesai</option>
                                </select></td>
                            <td>
                                <div style="display:flex;gap:6px"><button class="btn-view">Detail</button><button
                                        class="btn-edit">Proses</button></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:700">#ORD-002</td>
                            <td>
                                <div style="font-weight:700;font-size:13px">Siti Rahayu</div>
                                <div style="font-size:11px;color:var(--g400)">05 Des 2024</div>
                            </td>
                            <td style="font-weight:800;color:var(--blue);font-family:'Syne',sans-serif">Rp 12.899.000
                            </td>
                            <td>
                                <div
                                    style="width:44px;height:44px;border-radius:8px;background:var(--sl);border:1.5px solid #bbf7d0;display:flex;align-items:center;justify-content:center;font-size:20px;cursor:pointer">
                                    ✅</div>
                            </td>
                            <td><span class="badge badge-info">⚙️ Diproses</span></td>
                            <td><select style="width:auto;padding:6px 10px;font-size:12px">
                                    <option>Menunggu</option>
                                    <option selected>Diproses</option>
                                    <option>Dikirim</option>
                                    <option>Selesai</option>
                                </select></td>
                            <td>
                                <div style="display:flex;gap:6px"><button class="btn-view">Detail</button><button
                                        class="btn-edit">Kirim</button></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:700">#ORD-003</td>
                            <td>
                                <div style="font-weight:700;font-size:13px">Ahmad Fauzi</div>
                                <div style="font-size:11px;color:var(--g400)">04 Des 2024</div>
                            </td>
                            <td style="font-weight:800;color:var(--blue);font-family:'Syne',sans-serif">Rp 7.700.000
                            </td>
                            <td>
                                <div
                                    style="width:44px;height:44px;border-radius:8px;background:var(--sl);border:1.5px solid #bbf7d0;display:flex;align-items:center;justify-content:center;font-size:20px;cursor:pointer">
                                    ✅</div>
                            </td>
                            <td><span class="badge badge-warn">🚚 Dikirim</span></td>
                            <td><select style="width:auto;padding:6px 10px;font-size:12px">
                                    <option>Menunggu</option>
                                    <option>Diproses</option>
                                    <option selected>Dikirim</option>
                                    <option>Selesai</option>
                                </select></td>
                            <td>
                                <div style="display:flex;gap:6px"><button class="btn-view">Lacak</button></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:700">#ORD-005</td>
                            <td>
                                <div style="font-weight:700;font-size:13px">Rina Marlina</div>
                                <div style="font-size:11px;color:var(--g400)">06 Des 2024</div>
                            </td>
                            <td style="font-weight:800;color:var(--blue);font-family:'Syne',sans-serif">Rp 14.999.000
                            </td>
                            <td>
                                <div
                                    style="width:44px;height:44px;border-radius:8px;background:var(--wl);border:1.5px solid #fde68a;display:flex;align-items:center;justify-content:center;font-size:20px;cursor:pointer">
                                    ⚠️</div>
                            </td>
                            <td><span class="badge badge-pend">⏳ Menunggu</span></td>
                            <td><select style="width:auto;padding:6px 10px;font-size:12px">
                                    <option selected>Menunggu</option>
                                    <option>Diproses</option>
                                    <option>Dikirim</option>
                                    <option>Selesai</option>
                                </select></td>
                            <td>
                                <div style="display:flex;gap:6px"><button class="btn-view">Detail</button></div>
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