@extends('layouts.app')

@section('title', 'Laporan Penjualan – Owner Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .chart-area {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            height: 180px;
            padding: 0 8px;
            background: var(--g50);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .bar-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            flex: 1;
        }

        .bar-fill {
            width: 100%;
            border-radius: 6px 6px 0 0;
            min-height: 4px;
            transition: 0.4s;
        }

        .bar-label {
            font-size: 10px;
            color: var(--g400);
            font-weight: 600;
            margin-bottom: 4px;
        }

        .donut-svg {
            width: 140px;
            height: 140px;
        }

        .mini-line {
            display: flex;
            align-items: flex-end;
            gap: 3px;
            height: 48px;
        }

        .ml-bar {
            flex: 1;
            border-radius: 3px 3px 0 0;
            background: var(--blue);
            opacity: 0.7;
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
                <div class="sidebar-brand-role">Panel Owner</div>
            </div>
            <div class="s-group">Laporan</div>
            <a href="owner-dashboard.html" class="s-item active"><span class="si">📈</span> Laporan Penjualan</a>
            <a href="#" class="s-item"><span class="si">📊</span> Analitik</a>
            <a href="admin-products.html" class="s-item"><span class="si">📦</span> Overview Produk</a>
            <div class="s-group">Akun</div>
            <a href="login.html" class="s-item"><span class="si">🚪</span> Keluar</a>
        </div>
        <div class="admin-main">
            <div class="admin-topbar">
                <div>
                    <div style="font-size: 13px; color: var(--g500); margin-bottom: 2px">
                        Dashboard Owner
                    </div>
                    <div class="page-title">Laporan Penjualan</div>
                </div>
                <div style="display: flex; gap: 8px">
                    <select style="padding: 10px 14px; font-size: 13px; width: auto">
                        <option>Desember 2024</option>
                        <option>November 2024</option>
                        <option>Oktober 2024</option>
                    </select>
                    <button class="btn btn-primary btn-sm">📤 Export PDF</button>
                </div>
            </div>
            <!-- Summary Stats -->
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-ico green">💰</div>
                    <div>
                        <div class="stat-label">Total Pendapatan</div>
                        <div class="stat-val" style="font-size: 22px">Rp 284,5 Jt</div>
                        <div class="stat-chg">↑ 18% dari Nov</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico blue">🧾</div>
                    <div>
                        <div class="stat-label">Total Pesanan</div>
                        <div class="stat-val">223</div>
                        <div class="stat-chg">↑ 32 pesanan</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico teal">💳</div>
                    <div>
                        <div class="stat-label">Rata-rata Transaksi</div>
                        <div class="stat-val" style="font-size: 22px">Rp 1,27 Jt</div>
                        <div class="stat-chg">↑ 5%</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ico warn">👤</div>
                    <div>
                        <div class="stat-label">Pelanggan Aktif</div>
                        <div class="stat-val">412</div>
                        <div class="stat-chg">↑ 67 baru</div>
                    </div>
                </div>
            </div>
            <div style="
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 20px;
                margin-bottom: 24px;
              ">
                <!-- Bar Chart -->
                <div class="data-card">
                    <div class="data-card-head">
                        <h3>📊 Pendapatan Bulanan 2024</h3>
                        <span style="font-size: 12px; color: var(--g400)">dalam jutaan rupiah</span>
                    </div>
                    <div style="padding: 20px 20px 0">
                        <div class="chart-area">
                            <div class="bar-col">
                                <div class="bar-fill" style="height: 45%; background: var(--blue)"></div>
                                <div class="bar-label">Jan</div>
                            </div>
                            <div class="bar-col">
                                <div class="bar-fill" style="height: 38%; background: var(--blue)"></div>
                                <div class="bar-label">Feb</div>
                            </div>
                            <div class="bar-col">
                                <div class="bar-fill" style="height: 55%; background: var(--blue)"></div>
                                <div class="bar-label">Mar</div>
                            </div>
                            <div class="bar-col">
                                <div class="bar-fill" style="height: 42%; background: var(--blue)"></div>
                                <div class="bar-label">Apr</div>
                            </div>
                            <div class="bar-col">
                                <div class="bar-fill" style="height: 67%; background: var(--blue)"></div>
                                <div class="bar-label">Mei</div>
                            </div>
                            <div class="bar-col">
                                <div class="bar-fill" style="height: 52%; background: var(--blue)"></div>
                                <div class="bar-label">Jun</div>
                            </div>
                            <div class="bar-col">
                                <div class="bar-fill" style="height: 61%; background: var(--blue)"></div>
                                <div class="bar-label">Jul</div>
                            </div>
                            <div class="bar-col">
                                <div class="bar-fill" style="height: 74%; background: var(--blue)"></div>
                                <div class="bar-label">Agu</div>
                            </div>
                            <div class="bar-col">
                                <div class="bar-fill" style="height: 79%; background: var(--blue)"></div>
                                <div class="bar-label">Sep</div>
                            </div>
                            <div class="bar-col">
                                <div class="bar-fill" style="height: 68%; background: var(--blue)"></div>
                                <div class="bar-label">Okt</div>
                            </div>
                            <div class="bar-col">
                                <div class="bar-fill" style="height: 88%; background: var(--blue)"></div>
                                <div class="bar-label">Nov</div>
                            </div>
                            <div class="bar-col">
                                <div class="bar-fill" style="height: 100%; background: var(--teal)"></div>
                                <div class="bar-label" style="color: var(--teal)">Des</div>
                            </div>
                        </div>
                    </div>
                    <div style="
                    display: flex;
                    justify-content: space-around;
                    padding: 12px 20px;
                    border-top: 1px solid var(--g100);
                    margin-top: 16px;
                  ">
                        <div style="text-align: center">
                            <div style="font-size: 11px; color: var(--g400)">Tertinggi</div>
                            <div style="
                        font-weight: 800;
                        color: var(--teal);
                        font-family: &quot;Syne&quot;, sans-serif;
                      ">
                                Rp 284,5 Jt
                            </div>
                        </div>
                        <div style="text-align: center">
                            <div style="font-size: 11px; color: var(--g400)">Rata-rata</div>
                            <div style="
                        font-weight: 800;
                        font-family: &quot;Syne&quot;, sans-serif;
                      ">
                                Rp 198,2 Jt
                            </div>
                        </div>
                        <div style="text-align: center">
                            <div style="font-size: 11px; color: var(--g400)">
                                Total 2024
                            </div>
                            <div style="
                        font-weight: 800;
                        font-family: &quot;Syne&quot;, sans-serif;
                      ">
                                Rp 2,1 M
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Donut -->
                <div class="data-card">
                    <div class="data-card-head">
                        <h3>📦 Per Kategori</h3>
                    </div>
                    <div style="padding: 20px; text-align: center">
                        <svg viewBox="0 0 140 140" class="donut-svg">
                            <circle cx="70" cy="70" r="55" fill="none" stroke="#E4E9F5" stroke-width="22" />
                            <circle cx="70" cy="70" r="55" fill="none" stroke="#1A5CFF" stroke-width="22"
                                stroke-dasharray="155 200" stroke-dashoffset="0" transform="rotate(-90 70 70)" />
                            <circle cx="70" cy="70" r="55" fill="none" stroke="#0EA5A0" stroke-width="22"
                                stroke-dasharray="79 200" stroke-dashoffset="-155" transform="rotate(-90 70 70)" />
                            <circle cx="70" cy="70" r="55" fill="none" stroke="#D97706" stroke-width="22"
                                stroke-dasharray="48 200" stroke-dashoffset="-234" transform="rotate(-90 70 70)" />
                            <circle cx="70" cy="70" r="55" fill="none" stroke="#E4E9F5" stroke-width="22"
                                stroke-dasharray="62 200" stroke-dashoffset="-282" transform="rotate(-90 70 70)" />
                            <text x="70" y="65" text-anchor="middle" font-size="16" font-weight="800" fill="#0D1728"
                                font-family="Syne">
                                45%
                            </text>
                            <text x="70" y="82" text-anchor="middle" font-size="10" fill="#8896B5">
                                Smart TV
                            </text>
                        </svg>
                        <div style="
                      display: flex;
                      flex-direction: column;
                      gap: 8px;
                      margin-top: 8px;
                    ">
                            <div style="
                        display: flex;
                        align-items: center;
                        gap: 8px;
                        font-size: 13px;
                      ">
                                <div style="
                          width: 12px;
                          height: 12px;
                          border-radius: 3px;
                          background: var(--blue);
                          flex-shrink: 0;
                        "></div>
                                <span style="flex: 1">Smart TV</span><strong>45%</strong>
                            </div>
                            <div style="
                        display: flex;
                        align-items: center;
                        gap: 8px;
                        font-size: 13px;
                      ">
                                <div style="
                          width: 12px;
                          height: 12px;
                          border-radius: 3px;
                          background: var(--teal);
                          flex-shrink: 0;
                        "></div>
                                <span style="flex: 1">AC / Pendingin</span><strong>23%</strong>
                            </div>
                            <div style="
                        display: flex;
                        align-items: center;
                        gap: 8px;
                        font-size: 13px;
                      ">
                                <div style="
                          width: 12px;
                          height: 12px;
                          border-radius: 3px;
                          background: var(--warn);
                          flex-shrink: 0;
                        "></div>
                                <span style="flex: 1">Kulkas</span><strong>14%</strong>
                            </div>
                            <div style="
                        display: flex;
                        align-items: center;
                        gap: 8px;
                        font-size: 13px;
                      ">
                                <div style="
                          width: 12px;
                          height: 12px;
                          border-radius: 3px;
                          background: var(--g200);
                          flex-shrink: 0;
                        "></div>
                                <span style="flex: 1">Lainnya</span><strong>18%</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Top Products -->
            <div class="data-card">
                <div class="data-card-head">
                    <h3>🏆 Produk Terlaris – Desember 2024</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Terjual</th>
                            <th>Pendapatan</th>
                            <th>Tren</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong style="font-size: 18px">🥇</strong></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px">
                                    <img src="https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=60&q=70" style="
                            width: 44px;
                            height: 44px;
                            border-radius: 8px;
                            object-fit: cover;
                          " /><span style="font-weight: 700; font-size: 13px">Daikin AC Split 1PK Inverter</span>
                                </div>
                            </td>
                            <td>AC / Pendingin</td>
                            <td style="font-weight: 800">89 unit</td>
                            <td style="
                        font-weight: 800;
                        color: var(--success);
                        font-family: &quot;Syne&quot;, sans-serif;
                      ">
                                Rp 342,6 Jt
                            </td>
                            <td>
                                <div class="mini-line">
                                    <div class="ml-bar" style="height: 40%"></div>
                                    <div class="ml-bar" style="height: 55%"></div>
                                    <div class="ml-bar" style="height: 70%"></div>
                                    <div class="ml-bar" style="height: 85%"></div>
                                    <div class="ml-bar" style="height: 100%; background: var(--success)"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong style="font-size: 18px">🥈</strong></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px">
                                    <img src="https://images.unsplash.com/photo-1593784991095-a205069470b6?w=60&q=70" style="
                            width: 44px;
                            height: 44px;
                            border-radius: 8px;
                            object-fit: cover;
                          " /><span style="font-weight: 700; font-size: 13px">Samsung Smart TV 43" 4K UHD</span>
                                </div>
                            </td>
                            <td>Smart TV</td>
                            <td style="font-weight: 800">54 unit</td>
                            <td style="
                        font-weight: 800;
                        color: var(--success);
                        font-family: &quot;Syne&quot;, sans-serif;
                      ">
                                Rp 350,9 Jt
                            </td>
                            <td>
                                <div class="mini-line">
                                    <div class="ml-bar" style="height: 60%"></div>
                                    <div class="ml-bar" style="height: 65%"></div>
                                    <div class="ml-bar" style="height: 75%"></div>
                                    <div class="ml-bar" style="height: 88%"></div>
                                    <div class="ml-bar" style="height: 100%; background: var(--success)"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong style="font-size: 18px">🥉</strong></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px">
                                    <img src="https://images.unsplash.com/photo-1571175443880-49e1d25b2bc5?w=60&q=70" style="
                            width: 44px;
                            height: 44px;
                            border-radius: 8px;
                            object-fit: cover;
                          " /><span style="font-weight: 700; font-size: 13px">LG Kulkas 2 Pintu 380L Inverter</span>
                                </div>
                            </td>
                            <td>Kulkas</td>
                            <td style="font-weight: 800">41 unit</td>
                            <td style="
                        font-weight: 800;
                        color: var(--success);
                        font-family: &quot;Syne&quot;, sans-serif;
                      ">
                                Rp 213,2 Jt
                            </td>
                            <td>
                                <div class="mini-line">
                                    <div class="ml-bar" style="height: 50%"></div>
                                    <div class="ml-bar" style="height: 60%"></div>
                                    <div class="ml-bar" style="height: 68%"></div>
                                    <div class="ml-bar" style="height: 82%"></div>
                                    <div class="ml-bar" style="height: 100%; background: var(--success)"></div>
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