@extends('layouts.app')

@section('title', 'Kelola Promo - Admin Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}">
@endsection

@section('content')
    <div class="admin-layout">
        @include('partials.admin-sidebar')

        <div class="admin-main">
            <div class="admin-topbar">
                <div class="page-title">Kelola Promo</div>
            </div>

            @if (session('status'))
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px;background:var(--sl);color:#15803D">
                    <strong>{{ session('status') }}</strong>
                </div>
            @endif
            @if (session('error'))
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px;background:var(--dl);color:#991B1B">
                    <strong>{{ session('error') }}</strong>
                </div>
            @endif
            @if ($errors->any())
                <div class="data-card" style="padding:12px 16px;margin-bottom:16px;background:var(--dl);color:#991B1B">
                    <strong>Gagal menyimpan promo.</strong>
                    <ul style="margin:8px 0 0 16px;font-size:12px">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="data-card" style="margin-bottom:16px">
                <div class="data-card-head"><h3>Tambah Promo</h3></div>
                <form method="POST" action="{{ route('admin.promos.store') }}" style="padding:16px;display:grid;gap:12px">
                    @csrf
                    <div style="display:grid;grid-template-columns:1.2fr 1fr 1fr 1fr;gap:12px">
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Kode Voucher</label>
                            <input name="kode_voucher" value="{{ old('kode_voucher') }}" required placeholder="HEMAT50"
                                style="width:100%;padding:10px 12px;border:1px solid var(--g200);border-radius:10px;text-transform:uppercase">
                        </div>
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Tipe Diskon</label>
                            <select name="tipe_diskon" required style="width:100%;padding:10px 12px;border:1px solid var(--g200);border-radius:10px">
                                <option value="persen" @selected(old('tipe_diskon') === 'persen')>Persen</option>
                                <option value="nominal" @selected(old('tipe_diskon') === 'nominal')>Nominal</option>
                            </select>
                        </div>
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Nilai Diskon</label>
                            <input type="number" name="nilai_diskon" min="1" value="{{ old('nilai_diskon') }}" required
                                style="width:100%;padding:10px 12px;border:1px solid var(--g200);border-radius:10px">
                        </div>
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Kuota</label>
                            <input type="number" name="kuota" min="0" value="{{ old('kuota', 10) }}" required
                                style="width:100%;padding:10px 12px;border:1px solid var(--g200);border-radius:10px">
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr auto;gap:12px;align-items:end">
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Tanggal Mulai</label>
                            <input type="datetime-local" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                                style="width:100%;padding:10px 12px;border:1px solid var(--g200);border-radius:10px">
                        </div>
                        <div>
                            <label style="font-size:12px;color:var(--g500)">Tanggal Berakhir</label>
                            <input type="datetime-local" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}" required
                                style="width:100%;padding:10px 12px;border:1px solid var(--g200);border-radius:10px">
                        </div>
                        <button class="btn btn-primary" type="submit">Simpan Promo</button>
                    </div>
                </form>
            </div>

            <div class="data-card">
                <div class="data-card-head">
                    <h3>Daftar Promo</h3>
                    <span class="badge badge-info">{{ $promos->count() }} promo</span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Diskon</th>
                            <th>Periode</th>
                            <th>Kuota</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($promos as $promo)
                            @php
                                $mulai = \Illuminate\Support\Carbon::parse($promo->tanggal_mulai);
                                $akhir = \Illuminate\Support\Carbon::parse($promo->tanggal_berakhir);
                                $aktif = $promo->kuota > 0 && now()->between($mulai, $akhir);
                            @endphp
                            <tr>
                                <td>
                                    <form id="promo-{{ $promo->id_promo }}" method="POST" action="{{ route('admin.promos.update', $promo) }}" style="display:grid;grid-template-columns:1fr 110px 110px 90px;gap:8px">
                                        @csrf @method('PUT')
                                        <input name="kode_voucher" value="{{ old('kode_voucher', $promo->kode_voucher) }}" required
                                            style="width:100%;padding:8px 10px;border:1px solid var(--g200);border-radius:8px;text-transform:uppercase">
                                        <select name="tipe_diskon" required style="width:100%;padding:8px 10px;border:1px solid var(--g200);border-radius:8px">
                                            <option value="persen" @selected(old('tipe_diskon', $promo->tipe_diskon) === 'persen')>Persen</option>
                                            <option value="nominal" @selected(old('tipe_diskon', $promo->tipe_diskon) === 'nominal')>Nominal</option>
                                        </select>
                                        <input type="number" name="nilai_diskon" min="1" value="{{ old('nilai_diskon', $promo->nilai_diskon) }}" required
                                            style="width:100%;padding:8px 10px;border:1px solid var(--g200);border-radius:8px">
                                        <input type="number" name="kuota" min="0" value="{{ old('kuota', $promo->kuota) }}" required
                                            style="width:100%;padding:8px 10px;border:1px solid var(--g200);border-radius:8px">
                                    </form>
                                </td>
                                <td style="font-weight:800">
                                    {{ $promo->tipe_diskon === 'persen' ? $promo->nilai_diskon . '%' : 'Rp ' . number_format($promo->nilai_diskon, 0, ',', '.') }}
                                </td>
                                <td style="font-size:12px;color:var(--g500)">
                                    <div style="display:grid;gap:6px">
                                        <input type="datetime-local" name="tanggal_mulai" form="promo-{{ $promo->id_promo }}" value="{{ old('tanggal_mulai', $mulai->format('Y-m-d\TH:i')) }}" required
                                            style="width:100%;padding:8px 10px;border:1px solid var(--g200);border-radius:8px">
                                        <input type="datetime-local" name="tanggal_berakhir" form="promo-{{ $promo->id_promo }}" value="{{ old('tanggal_berakhir', $akhir->format('Y-m-d\TH:i')) }}" required
                                            style="width:100%;padding:8px 10px;border:1px solid var(--g200);border-radius:8px">
                                    </div>
                                </td>
                                <td><span class="badge badge-info">{{ $promo->kuota }}</span></td>
                                <td><span class="badge {{ $aktif ? 'badge-success' : 'badge-warn' }}">{{ $aktif ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                                <td>
                                    <div style="display:flex;gap:6px">
                                        <button class="btn-edit" type="submit" form="promo-{{ $promo->id_promo }}">Simpan</button>
                                        <form method="POST" action="{{ route('admin.promos.destroy', $promo) }}" onsubmit="return confirm('Hapus promo ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn-del" type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align:center;color:var(--g400);padding:18px">Belum ada promo.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
