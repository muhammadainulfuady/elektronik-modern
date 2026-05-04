@extends('layouts.app')

@section('title', 'Admin Dashboard – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .chart-bars {
            display: flex;
            align-items: flex-end;
            gap: 6px;
            height: 160px;
            padding: 0 4px;
        }

        .bar-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            flex: 1;
        }

        .bar-fill {
            width: 100%;
            border-radius: 6px 6px 0 0;
            background: var(--blue);
            min-height: 4px;
            transition: 0.3s;
        }

        .bar-label {
            font-size: 10px;
            color: var(--g400);
            font-weight: 600;
        }
    </style>
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
            <a href="admin-dashboard.html" class="s-item active"><span class="si">📊</span> Dashboard</a>
            <a href="admin-products.html" class="s-item"><span class="si">📦</span> Kelola Produk</a>
            <a href="admin-orders.html" class="s-item"><span class="si">🧾</span> Kelola Pesanan</a>
            <a href="admin-users.html" class="s-item"><span class="si">👥</span> Kelola Pengguna</a>
            <div class="s-group">Akun</div>
            <a href="#" class="s-item"><span class="si">⚙️</span> Pengaturan</a>
            <a href="login.html" class="s-item"><span class="si">🚪</span> Keluar</a>
        </div>
        <div class="admin-main">
            <div class="admin-topbar">
                <div>
                    <div style="font-size: 13px; color: var(--g500); margin-bottom: 2px">
                        Selamat datang kembali,
                    </div>
                    <div class="page-title">Dashboard Admin</div>
                </div>
                <div style="display: flex; gap: 10px; align-items: center">
                    <button class="btn btn-outline btn-sm">📅 Desember 2024</button>
                    <div style="
                    width: 40px;
                    height: 40px;
                    background: var(--blue);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #fff;
                    font-weight: 800;
                    font-size: 14px;
                  ">
                        JK
                    </div>
                </div>
            </div>
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-ico blue">📦</div>
                    <div>
                        <div class="stat-label">Total Produk</div>
                        <div class="stat-val">247</div>
                        <div class="stat-chg">↑ 12 produk baru</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico teal">🧾</div>
                    <div>
                        <div class="stat-label">Pesanan Hari Ini</div>
                        <div class="stat-val">38</div>
                        <div class="stat-chg">↑ 8 dari kemarin</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico green">👥</div>
                    <div>
                        <div class="stat-label">Total Pengguna</div>
                        <div class="stat-val">1.842</div>
                        <div class="stat-chg">↑ 23 minggu ini</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico warn">⏳</div>
                    <div>
                        <div class="stat-label">Menunggu Konfirmasi</div>
                        <div class="stat-val">14</div>
                        <div class="stat-chg" style="color: var(--warn)">
                            Perlu ditangani
                        </div>
                    </div>
                </div>
            </div>
            <div style="
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 20px;
                margin-bottom: 24px;
              ">
                <div class="data-card">
                    <div class="data-card-head">
                        <h3>📈 Pesanan 7 Hari Terakhir</h3>
                    </div>
                    <div style="padding: 20px">
                        <div class="chart-bars">
                            <div class="bar-wrap">
                                <div class="bar-fill" style="height: 55%"></div>
                                <div class="bar-label">Sen</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar-fill" style="height: 72%"></div>
                                <div class="bar-label">Sel</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar-fill" style="height: 48%"></div>
                                <div class="bar-label">Rab</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar-fill" style="height: 83%"></div>
                                <div class="bar-label">Kam</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar-fill" style="height: 91%"></div>
                                <div class="bar-label">Jum</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar-fill" style="height: 65%; background: var(--g300)"></div>
                                <div class="bar-label">Sab</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar-fill" style="height: 38%; background: var(--g300)"></div>
                                <div class="bar-label">Min</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="data-card">
                    <div class="data-card-head">
                        <h3>📦 Status Pesanan</h3>
                    </div>
                    <div style="
                    padding: 20px;
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                  ">
                        <div>
                            <div style="
                        display: flex;
                        justify-content: space-between;
                        font-size: 13px;
                        margin-bottom: 5px;
                      ">
                                <span>Menunggu</span><strong>14</strong>
                            </div>
                            <div style="
                        height: 6px;
                        background: var(--g100);
                        border-radius: 3px;
                      ">
                                <div style="
                          width: 20%;
                          height: 100%;
                          background: var(--pend);
                          border-radius: 3px;
                        "></div>
                            </div>
                        </div>
                        <div>
                            <div style="
                        display: flex;
                        justify-content: space-between;
                        font-size: 13px;
                        margin-bottom: 5px;
                      ">
                                <span>Diproses</span><strong>22</strong>
                            </div>
                            <div style="
                        height: 6px;
                        background: var(--g100);
                        border-radius: 3px;
                      ">
                                <div style="
                          width: 32%;
                          height: 100%;
                          background: var(--blue);
                          border-radius: 3px;
                        "></div>
                            </div>
                        </div>
                        <div>
                            <div style="
                        display: flex;
                        justify-content: space-between;
                        font-size: 13px;
                        margin-bottom: 5px;
                      ">
                                <span>Dikirim</span><strong>31</strong>
                            </div>
                            <div style="
                        height: 6px;
                        background: var(--g100);
                        border-radius: 3px;
                      ">
                                <div style="
                          width: 45%;
                          height: 100%;
                          background: var(--teal);
                          border-radius: 3px;
                        "></div>
                            </div>
                        </div>
                        <div>
                            <div style="
                        display: flex;
                        justify-content: space-between;
                        font-size: 13px;
                        margin-bottom: 5px;
                      ">
                                <span>Selesai</span><strong>156</strong>
                            </div>
                            <div style="
                        height: 6px;
                        background: var(--g100);
                        border-radius: 3px;
                      ">
                                <div style="
                          width: 85%;
                          height: 100%;
                          background: var(--success);
                          border-radius: 3px;
                        "></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="data-card">
                <div class="data-card-head">
                    <h3>🧾 Pesanan Terbaru</h3>
                    <a href="admin-orders.html" class="btn btn-outline btn-sm">Lihat Semua →</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-weight: 700">#ORD-001</td>
                            <td>Budi Santoso</td>
                            <td>Samsung TV 43"</td>
                            <td style="
                        font-weight: 800;
                        color: var(--blue);
                        font-family: &quot;Syne&quot;, sans-serif;
                      ">
                                Rp 6.499.000
                            </td>
                            <td><span class="badge badge-pend">⏳ Menunggu</span></td>
                            <td>
                                <div style="display: flex; gap: 6px">
                                    <button class="btn-view">Detail</button><button class="btn-edit">Proses</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700">#ORD-002</td>
                            <td>Siti Rahayu</td>
                            <td>LG Kulkas 380L</td>
                            <td style="
                        font-weight: 800;
                        color: var(--blue);
                        font-family: &quot;Syne&quot;, sans-serif;
                      ">
                                Rp 5.199.000
                            </td>
                            <td><span class="badge badge-info">⚙️ Diproses</span></td>
                            <td>
                                <div style="display: flex; gap: 6px">
                                    <button class="btn-view">Detail</button><button class="btn-edit">Kirim</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700">#ORD-003</td>
                            <td>Ahmad Fauzi</td>
                            <td>Daikin AC 1PK ×2</td>
                            <td style="
                        font-weight: 800;
                        color: var(--blue);
                        font-family: &quot;Syne&quot;, sans-serif;
                      ">
                                Rp 7.700.000
                            </td>
                            <td><span class="badge badge-warn">🚚 Dikirim</span></td>
                            <td>
                                <div style="display: flex; gap: 6px">
                                    <button class="btn-view">Lacak</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700">#ORD-004</td>
                            <td>Dewi Lestari</td>
                            <td>Panasonic Washer</td>
                            <td style="
                        font-weight: 800;
                        color: var(--blue);
                        font-family: &quot;Syne&quot;, sans-serif;
                      ">
                                Rp 4.299.000
                            </td>
                            <td><span class="badge badge-success">✅ Selesai</span></td>
                            <td>
                                <div style="display: flex; gap: 6px">
                                    <button class="btn-view">Detail</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: 700">#ORD-005</td>
                            <td>Rina Marlina</td>
                            <td>Sony BRAVIA 55"</td>
                            <td style="
                        font-weight: 800;
                        color: var(--blue);
                        font-family: &quot;Syne&quot;, sans-serif;
                      ">
                                Rp 14.999.000
                            </td>
                            <td><span class="badge badge-pend">⏳ Menunggu</span></td>
                            <td>
                                <div style="display: flex; gap: 6px">
                                    <button class="btn-view">Detail</button><button class="btn-edit">Proses</button>
                                </div>
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