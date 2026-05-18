@extends('layouts.app')

@section('title', 'Profil Saya – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .profile-section { padding: 32px 0 72px }
        .profile-section h1 { font-family: "Syne", sans-serif; font-size: 28px; font-weight: 800; margin-bottom: 8px }

        .profile-layout { display: grid; grid-template-columns: 300px 1fr; gap: 28px; align-items: start }

        .profile-sidebar {
            background: #fff; border-radius: var(--rlg); box-shadow: var(--sh);
            padding: 32px; text-align: center
        }
        .profile-avatar {
            width: 80px; height: 80px; border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--blue-mid));
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; font-weight: 800; color: #fff;
            margin: 0 auto 16px; box-shadow: 0 8px 24px rgba(26,92,255,.3)
        }
        .profile-name { font-family: var(--font-h); font-size: 20px; font-weight: 800; margin-bottom: 4px }
        .profile-email { font-size: 13px; color: var(--g500); margin-bottom: 16px }

        .profile-nav { display: flex; flex-direction: column; gap: 4px; margin-top: 20px; border-top: 1px solid var(--g200); padding-top: 16px }
        .profile-nav a {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px; border-radius: 10px; font-size: 14px;
            font-weight: 600; color: var(--g600); text-decoration: none; transition: .15s
        }
        .profile-nav a:hover, .profile-nav a.active { background: var(--blue-l); color: var(--blue) }

        .profile-card {
            background: #fff; border-radius: var(--rlg); box-shadow: var(--sh);
            padding: 32px
        }
        .profile-card h2 {
            font-family: var(--font-h); font-size: 22px; font-weight: 800;
            margin-bottom: 6px; color: var(--g900)
        }
        .profile-card .subtitle {
            font-size: 14px; color: var(--g500); margin-bottom: 28px
        }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px }

        .save-btn {
            margin-top: 8px;
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 28px; border-radius: 50px; font-weight: 700;
            font-size: 15px; cursor: pointer; border: none;
            font-family: var(--font); transition: .2s;
            background: var(--blue); color: #fff;
            box-shadow: 0 4px 12px rgba(26,92,255,.3)
        }
        .save-btn:hover {
            background: var(--blue-d); transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(26,92,255,.4)
        }

        @media(max-width:768px) {
            .profile-layout { grid-template-columns: 1fr }
            .form-row { grid-template-columns: 1fr }
        }
    </style>
@endsection

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('index') }}">Beranda</a> <span>›</span> <span>Profil Saya</span>
            </div>
            <h1>👤 Profil Saya</h1>
            <p style="color:var(--g500);margin-bottom:28px">Kelola informasi akun Anda</p>

            @if (session('status'))
                <div style="background:var(--sl);color:#15803D;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:20px">
                    ✓ {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div style="background:var(--dl);color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:20px">
                    ✗ {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background:var(--dl);color:#991B1B;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:20px">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="profile-layout">
                <!-- Sidebar -->
                <div class="profile-sidebar">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($user->nama, 0, 2)) }}
                    </div>
                    <div class="profile-name">{{ $user->nama }}</div>
                    <div class="profile-email">{{ $user->email }}</div>
                    <span class="badge badge-success">👤 Customer</span>

                    <div class="profile-nav">
                        <a href="#" class="active" onclick="switchTab('edit-profile', this)">
                            <span>📝</span> Edit Profil
                        </a>
                        <a href="#" onclick="switchTab('alamat', this)">
                            <span>📍</span> Alamat Pengiriman
                        </a>
                        <a href="{{ route('customer.orders') }}">
                            <span>📦</span> Pesanan Saya
                        </a>
                    </div>
                </div>

                <!-- Container Panel -->
                <div class="profile-panels">
                    <!-- Edit Form -->
                    <div id="edit-profile" class="profile-card tab-panel" style="display:block">
                    <h2>Edit Profil</h2>
                    <div class="subtitle">Perbarui informasi akun Anda di bawah ini</div>

                    <form method="POST" action="{{ route('customer.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div style="border-top:1px solid var(--g200);padding-top:20px;margin-top:8px;margin-bottom:18px">
                            <div style="font-size:13px;font-weight:700;color:var(--g700);margin-bottom:4px">🔒 Ubah Password</div>
                            <div style="font-size:12px;color:var(--g400);margin-bottom:16px">Kosongkan jika tidak ingin mengubah password</div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input type="password" id="password" name="password" placeholder="Min. 8 karakter">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password">
                            </div>
                        </div>

                        <button type="submit" class="save-btn">💾 Simpan Profil</button>
                    </form>
                </div>
                
                <!-- Alamat Pengiriman -->
                <div id="alamat" class="profile-card tab-panel" style="display:none">
                    <h2>Alamat Pengiriman</h2>
                    <div class="subtitle">Kelola alamat untuk keperluan checkout pesanan Anda</div>
                    
                    <div style="margin-bottom: 24px; display: grid; gap: 12px">
                        @forelse($user->alamatUsers as $alamat)
                            <div style="border: 1px solid var(--g200); border-radius: 10px; padding: 16px; background: {{ $alamat->is_utama ? 'var(--blue-l)' : '#fff' }}">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px">
                                    <div style="font-weight: 700; font-size: 15px">{{ $alamat->label_alamat }} 
                                        @if($alamat->is_utama)
                                            <span style="font-size: 11px; background: var(--blue); color: #fff; padding: 2px 8px; border-radius: 50px; margin-left: 8px">Utama</span>
                                        @endif
                                    </div>
                                    <div style="font-size: 13px; font-weight: 700; color: var(--g800)">{{ $alamat->nomor_telepon }}</div>
                                </div>
                                <div style="font-size: 13px; color: var(--g600); line-height: 1.5">
                                    {{ $alamat->detail_alamat }}<br>
                                    <span style="color: var(--g500)">{{ $alamat->dusun->nama_dusun }}, {{ $alamat->dusun->desa->nama_desa }}, {{ $alamat->dusun->desa->kecamatan->nama_kecamatan }}, {{ $alamat->dusun->desa->kecamatan->kota->nama_kota }}, {{ $alamat->dusun->desa->kecamatan->kota->provinsi->nama_provinsi }}</span>
                                </div>
                                <details style="margin-top:14px">
                                    <summary style="cursor:pointer;font-size:13px;font-weight:700;color:var(--blue)">Edit alamat</summary>
                                    <form method="POST" action="{{ route('customer.alamat.update', $alamat) }}" style="margin-top:12px;display:grid;gap:10px">
                                        @csrf @method('PUT')
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Label Alamat</label>
                                                <input type="text" name="label_alamat" value="{{ old('label_alamat', $alamat->label_alamat) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Nomor Telepon</label>
                                                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $alamat->nomor_telepon) }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Dusun</label>
                                            <select name="id_dusun" required style="width: 100%; padding: 12px; border: 1px solid var(--g200); border-radius: 10px">
                                                @foreach($dusuns as $dusun)
                                                    <option value="{{ $dusun->id_dusun }}" @selected(old('id_dusun', $alamat->id_dusun) == $dusun->id_dusun)>
                                                        {{ $dusun->nama_dusun }} - {{ $dusun->desa->nama_desa ?? '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Detail Alamat</label>
                                            <textarea name="detail_alamat" rows="3" required>{{ old('detail_alamat', $alamat->detail_alamat) }}</textarea>
                                        </div>
                                        <label style="display:flex;align-items:center;gap:8px;font-size:14px;font-weight:600">
                                            <input type="checkbox" name="is_utama" value="1" @checked($alamat->is_utama) style="width:18px;height:18px;accent-color:var(--blue)">
                                            Jadikan sebagai alamat utama
                                        </label>
                                        <div style="display:flex;gap:8px;flex-wrap:wrap">
                                            <button type="submit" class="btn btn-primary">Simpan Alamat</button>
                                        </div>
                                    </form>
                                    <form method="POST" action="{{ route('customer.alamat.destroy', $alamat) }}" onsubmit="return confirm('Hapus alamat ini?')" style="margin-top:8px">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-del">Hapus Alamat</button>
                                    </form>
                                </details>
                            </div>
                        @empty
                            <div style="font-size: 13px; color: var(--g500); text-align: center; padding: 20px; border: 1px dashed var(--g300); border-radius: 10px">
                                Belum ada alamat tersimpan.
                            </div>
                        @endforelse
                    </div>

                    <div style="border-top: 1px solid var(--g200); padding-top: 24px;">
                        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px">Tambah Alamat Baru</h3>
                        <form method="POST" action="{{ route('customer.alamat.store') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Label Alamat (Contoh: Rumah, Kantor)</label>
                                    <input type="text" name="label_alamat" required placeholder="Rumah">
                                </div>
                                <div class="form-group">
                                    <label>Nomor Telepon</label>
                                    <input type="text" name="nomor_telepon" required placeholder="08...">
                                </div>
                            </div>
                            <div class="form-row" style="margin-bottom:16px">
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <select name="id_provinsi" id="provinsi" required style="width: 100%; padding: 12px; border: 1px solid var(--g200); border-radius: 10px">
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach($provinsis as $p)
                                            <option value="{{ $p->id_provinsi }}">{{ $p->nama_provinsi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Kota/Kabupaten</label>
                                    <select name="id_kota" id="kota" required style="width: 100%; padding: 12px; border: 1px solid var(--g200); border-radius: 10px">
                                        <option value="">-- Pilih Kota --</option>
                                        @foreach($kotas as $k)
                                            <option value="{{ $k->id_kota }}">{{ $k->nama_kota }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row" style="margin-bottom:16px">
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <select name="id_kecamatan" id="kecamatan" required style="width: 100%; padding: 12px; border: 1px solid var(--g200); border-radius: 10px">
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach($kecamatans as $kec)
                                            <option value="{{ $kec->id_kecamatan }}">{{ $kec->nama_kecamatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Desa/Kelurahan</label>
                                    <select name="id_desa" id="desa" required style="width: 100%; padding: 12px; border: 1px solid var(--g200); border-radius: 10px">
                                        <option value="">-- Pilih Desa --</option>
                                        @foreach($desas as $d)
                                            <option value="{{ $d->id_desa }}">{{ $d->nama_desa }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Dusun</label>
                                <select name="id_dusun" id="dusun" required style="width: 100%; padding: 12px; border: 1px solid var(--g200); border-radius: 10px">
                                    <option value="">-- Pilih Dusun --</option>
                                    @foreach($dusuns as $dusun)
                                        <option value="{{ $dusun->id_dusun }}">{{ $dusun->nama_dusun }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Detail Alamat (Jalan, RT/RW, Patokan)</label>
                                <textarea name="detail_alamat" rows="3" required placeholder="Jl. Mawar No 1..."></textarea>
                            </div>
                            <div class="form-group">
                                <label style="display:flex; align-items:center; gap:8px; cursor:pointer; margin-bottom:16px; margin-top:8px">
                                    <input type="checkbox" name="is_utama" value="1" style="width:18px;height:18px;accent-color:var(--blue)">
                                    <span style="font-size:14px;font-weight:600;color:var(--g800)">Jadikan sebagai alamat utama</span>
                                </label>
                            </div>
                            <button type="submit" class="save-btn" style="background: var(--g800)">➕ Tambah Alamat</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function switchTab(tabId, el) {
            event.preventDefault();
            document.querySelectorAll('.profile-nav a').forEach(a => a.classList.remove('active'));
            el.classList.add('active');
            
            document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';
        }

        // Keep tab open if coming from form submit
        @if((session('status') && str_contains(session('status'), 'Alamat')) || session('error') || request('tab') === 'alamat')
            document.querySelector('a[onclick="switchTab(\'alamat\', this)"]').click();
        @endif
    </script>
@endsection
