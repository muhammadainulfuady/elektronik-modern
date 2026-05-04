@extends('layouts.app')

@section('title', 'Profil Saya – Elektronik Modern')

@section('head')
  <link rel="stylesheet" href="{{ asset('shared.css') }}" />
  <style>
    /* ===== LAYOUT ===== */
    .profile-layout {
      display: grid;
      grid-template-columns: 260px 1fr;
      gap: 24px;
      padding: 32px 0 64px;
      align-items: start;
    }

    .profile-sidebar {
      background: #fff;
      border-radius: var(--rlg);
      box-shadow: var(--sh);
      overflow: hidden;
      position: sticky;
      top: 84px;
    }

    .profile-avatar-section {
      padding: 28px 20px;
      text-align: center;
      background: linear-gradient(135deg, #0f2060, #1a5cff);
      position: relative;
    }

    .avatar-circle {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      border: 3px solid rgba(255, 255, 255, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: "Syne", sans-serif;
      font-size: 28px;
      font-weight: 800;
      color: #fff;
      margin: 0 auto 14px;
    }

    .profile-user-name {
      font-family: "Syne", sans-serif;
      font-size: 17px;
      font-weight: 800;
      color: #fff;
      margin-bottom: 3px;
    }

    .profile-user-email {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.6);
    }

    .profile-joined {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: rgba(255, 255, 255, 0.15);
      color: rgba(255, 255, 255, 0.8);
      font-size: 11px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 50px;
      margin-top: 8px;
    }

    .profile-nav {
      padding: 8px 0;
    }

    .pnav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 20px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      color: var(--g600);
      transition: 0.15s;
      text-decoration: none;
      border-left: 3px solid transparent;
    }

    .pnav-item:hover {
      background: var(--g50);
      color: var(--g900);
    }

    .pnav-item.active {
      background: var(--blue-l);
      color: var(--blue);
      border-left-color: var(--blue);
    }

    .pnav-icon {
      font-size: 18px;
      width: 22px;
      text-align: center;
    }

    .pnav-badge {
      margin-left: auto;
      background: var(--blue);
      color: #fff;
      border-radius: 50px;
      font-size: 10px;
      font-weight: 700;
      padding: 2px 7px;
    }

    /* ===== CONTENT PANELS ===== */
    .profile-panel {
      display: none;
    }

    .profile-panel.active {
      display: block;
    }

    .panel-card {
      background: #fff;
      border-radius: var(--rlg);
      box-shadow: var(--sh);
      overflow: hidden;
      margin-bottom: 20px;
    }

    .panel-head {
      padding: 20px 24px;
      border-bottom: 1px solid var(--g100);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .panel-head h2 {
      font-family: "Syne", sans-serif;
      font-size: 18px;
      font-weight: 800;
      color: var(--g900);
    }

    .panel-head p {
      font-size: 13px;
      color: var(--g400);
      margin-top: 2px;
    }

    .panel-body {
      padding: 24px;
    }

    /* ===== ADDRESS CARDS ===== */
    .address-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .addr-card {
      background: #fff;
      border: 2px solid var(--g200);
      border-radius: var(--rlg);
      padding: 20px;
      position: relative;
      transition: 0.2s;
    }

    .addr-card.default {
      border-color: var(--blue);
      background: var(--blue-l);
    }

    .addr-card:hover {
      border-color: var(--g300);
      box-shadow: var(--sh);
    }

    .addr-card.default:hover {
      border-color: var(--blue-d);
    }

    .addr-label-row {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 12px;
    }

    .addr-label {
      font-size: 12px;
      font-weight: 800;
      background: var(--g100);
      color: var(--g600);
      padding: 3px 10px;
      border-radius: 50px;
      letter-spacing: 0.03em;
    }

    .addr-card.default .addr-label {
      background: var(--blue);
      color: #fff;
    }

    .addr-default-badge {
      font-size: 11px;
      font-weight: 700;
      background: rgba(26, 92, 255, 0.12);
      color: var(--blue);
      padding: 3px 10px;
      border-radius: 50px;
      margin-left: auto;
    }

    .addr-name {
      font-weight: 800;
      font-size: 14px;
      color: var(--g900);
      margin-bottom: 3px;
    }

    .addr-phone {
      font-size: 13px;
      color: var(--g500);
      margin-bottom: 10px;
    }

    .addr-street {
      font-size: 13px;
      color: var(--g700);
      line-height: 1.6;
      margin-bottom: 10px;
    }

    .addr-region {
      font-size: 12px;
      color: var(--g400);
      font-weight: 600;
    }

    .addr-actions {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 14px;
      padding-top: 14px;
      border-top: 1px solid var(--g200);
    }

    .addr-card.default .addr-actions {
      border-top-color: rgba(26, 92, 255, 0.15);
    }

    .btn-addr-edit {
      background: var(--blue-l);
      color: var(--blue);
      border: none;
      padding: 6px 14px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      font-family: "Plus Jakarta Sans", sans-serif;
      transition: 0.15s;
    }

    .btn-addr-edit:hover {
      background: var(--blue);
      color: #fff;
    }

    .btn-addr-del {
      background: var(--dl);
      color: var(--danger);
      border: none;
      padding: 6px 14px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      font-family: "Plus Jakarta Sans", sans-serif;
      transition: 0.15s;
    }

    .btn-addr-del:hover {
      background: var(--danger);
      color: #fff;
    }

    .btn-addr-default {
      background: var(--g100);
      color: var(--g500);
      border: none;
      padding: 6px 14px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      font-family: "Plus Jakarta Sans", sans-serif;
      transition: 0.15s;
      margin-left: auto;
    }

    .btn-addr-default:hover {
      background: var(--sl);
      color: var(--success);
    }

    .add-addr-card {
      border: 2px dashed var(--g300);
      border-radius: var(--rlg);
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 200px;
      cursor: pointer;
      transition: 0.2s;
      color: var(--g400);
      text-align: center;
    }

    .add-addr-card:hover {
      border-color: var(--blue);
      color: var(--blue);
      background: var(--blue-l);
    }

    .add-addr-icon {
      font-size: 36px;
      margin-bottom: 10px;
    }

    .add-addr-text {
      font-size: 14px;
      font-weight: 700;
      margin-bottom: 4px;
    }

    .add-addr-sub {
      font-size: 12px;
    }

    /* ===== MODAL ===== */
    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(10, 15, 30, 0.55);
      z-index: 1000;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 20px;
      backdrop-filter: blur(4px);
    }

    .modal-overlay.open {
      display: flex;
    }

    .modal {
      background: #fff;
      border-radius: var(--rxl);
      box-shadow: var(--sh-lg);
      width: 100%;
      max-width: 560px;
      max-height: 90vh;
      overflow-y: auto;
      animation: modalIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes modalIn {
      from {
        transform: scale(0.92) translateY(20px);
        opacity: 0;
      }

      to {
        transform: scale(1) translateY(0);
        opacity: 1;
      }
    }

    .modal-head {
      padding: 24px 28px 0;
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
    }

    .modal-title {
      font-family: "Syne", sans-serif;
      font-size: 20px;
      font-weight: 800;
      color: var(--g900);
      margin-bottom: 3px;
    }

    .modal-sub {
      font-size: 13px;
      color: var(--g400);
    }

    .modal-close {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--g100);
      border: none;
      cursor: pointer;
      font-size: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--g500);
      transition: 0.2s;
      flex-shrink: 0;
    }

    .modal-close:hover {
      background: var(--g200);
      color: var(--g900);
    }

    .modal-body {
      padding: 24px 28px;
    }

    .form-grid-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .form-grid-3 {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 14px;
    }

    .modal-footer {
      padding: 0 28px 24px;
      display: flex;
      gap: 10px;
      justify-content: flex-end;
    }

    .default-toggle {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 14px;
      background: var(--g50);
      border-radius: var(--radius);
      cursor: pointer;
      margin-bottom: 4px;
    }

    .toggle-switch {
      width: 44px;
      height: 24px;
      background: var(--g300);
      border-radius: 50px;
      position: relative;
      transition: 0.2s;
      flex-shrink: 0;
    }

    .toggle-switch.on {
      background: var(--blue);
    }

    .toggle-knob {
      position: absolute;
      top: 3px;
      left: 3px;
      width: 18px;
      height: 18px;
      background: #fff;
      border-radius: 50%;
      transition: 0.2s;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .toggle-switch.on .toggle-knob {
      left: 23px;
    }

    .toggle-label {
      font-size: 13px;
      font-weight: 700;
      color: var(--g700);
    }

    .toggle-sub {
      font-size: 12px;
      color: var(--g400);
    }

    /* ===== DELETE CONFIRM MODAL ===== */
    .confirm-modal {
      background: #fff;
      border-radius: var(--rxl);
      box-shadow: var(--sh-lg);
      width: 100%;
      max-width: 400px;
      padding: 32px;
      text-align: center;
      animation: modalIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .confirm-icon {
      font-size: 52px;
      margin-bottom: 16px;
    }

    .confirm-title {
      font-family: "Syne", sans-serif;
      font-size: 20px;
      font-weight: 800;
      color: var(--g900);
      margin-bottom: 8px;
    }

    .confirm-text {
      font-size: 14px;
      color: var(--g500);
      line-height: 1.7;
      margin-bottom: 24px;
    }

    .confirm-btns {
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    /* ===== TOAST ===== */
    .profile-toast {
      position: fixed;
      bottom: 32px;
      left: 50%;
      transform: translateX(-50%) translateY(80px);
      background: var(--dark);
      color: #fff;
      padding: 14px 24px;
      border-radius: 50px;
      font-size: 14px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
      z-index: 2000;
      box-shadow: var(--sh-lg);
      opacity: 0;
      transition: 0.3s;
      white-space: nowrap;
      pointer-events: none;
    }

    .profile-toast.show {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }

    /* ===== INFO PANEL ===== */
    .info-row {
      display: flex;
      align-items: center;
      padding: 16px 0;
      border-bottom: 1px solid var(--g100);
    }

    .info-row:last-child {
      border-bottom: none;
    }

    .info-key {
      font-size: 13px;
      font-weight: 700;
      color: var(--g500);
      width: 140px;
      flex-shrink: 0;
    }

    .info-val {
      font-size: 14px;
      color: var(--g800);
      font-weight: 600;
    }

    .info-locked {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 12px;
      color: var(--g400);
      margin-left: auto;
      background: var(--g100);
      padding: 4px 10px;
      border-radius: 50px;
    }

    /* ===== QUICK STATS ===== */
    .quick-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
      margin-bottom: 20px;
    }

    .qs-card {
      background: #fff;
      border-radius: var(--rlg);
      box-shadow: var(--sh);
      padding: 20px;
      text-align: center;
    }

    .qs-num {
      font-family: "Syne", sans-serif;
      font-size: 28px;
      font-weight: 800;
      margin-bottom: 4px;
    }

    .qs-label {
      font-size: 12px;
      color: var(--g400);
      font-weight: 600;
    }

    @media (max-width: 900px) {
      .profile-layout {
        grid-template-columns: 1fr;
      }

      .profile-sidebar {
        position: static;
      }

      .address-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
@endsection

@section('header')
  <!-- NAVBAR -->
  <nav class="navbar">
    <a href="index.html" class="nav-logo">⚡ Elektronik<span>Modern</span></a>
    <div class="nav-search">
      <span class="search-icon">🔍</span><input type="text" placeholder="Cari produk..." />
    </div>
    <div class="nav-right">
      <button class="nav-icon-btn" onclick="toggleNotif()">
        🔔<span class="notif-badge">2</span>
      </button>
      <button class="nav-icon-btn" onclick="openCart()">
        🛒<span class="cart-badge">0</span>
      </button>
      <a href="profile.html" class="nav-icon-btn active" title="Profil" style="
              text-decoration: none;
              font-size: 16px;
              background: var(--blue-l);
              color: var(--blue);
            ">👤</a>
    </div>
  </nav>

  <!-- NOTIFICATION PANEL -->
  <div class="notif-overlay" id="notifOverlay" onclick="closeNotif()"></div>
  <div class="notif-panel" id="notifPanel">
    <div class="notif-pheader">
      <h3>🔔 Notifikasi</h3>
      <button class="notif-mark" onclick="markAllRead()">
        Tandai dibaca
      </button>
    </div>
    <div class="notif-list" id="notifList"></div>
  </div>

  <!-- CART SIDEBAR -->
  <div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>
  <div class="cart-sidebar" id="cartSidebar">
    <div class="cart-header">
      <h2>🛒 Keranjang</h2>
      <button class="cart-close" onclick="closeCart()">✕</button>
    </div>
    <div class="cart-items" id="cartItems"></div>
    <div class="cart-footer" id="cartFooter"></div>
  </div>

  <!-- ADD/EDIT ADDRESS MODAL -->
  <div class="modal-overlay" id="addrModal">
    <div class="modal">
      <div class="modal-head">
      </div>
@endsection

    @section('content')
          <!-- MAIN CONTENT -->
          <div class="container">
          </div>
        </div>
        <button class="modal-close" onclick="closeModal()">✕</button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="editAddrId" />
        <div class="form-group">
          <label>Label Alamat
            <span style="color: var(--g400); font-weight: 400">(cth: Rumah, Kantor, Kos)</span></label>
          <input id="fLabel" placeholder="Rumah" />
        </div>
        <div class="form-grid-2">
          <div class="form-group">
            <label>Nama Penerima</label><input id="fName" placeholder="Nama lengkap..." />
          </div>
          <div class="form-group">
            <label>No. Telepon</label><input id="fPhone" placeholder="08xx-xxxx-xxxx" type="tel" />
          </div>
        </div>
        <div class="form-group">
          <label>Alamat Lengkap <span style="color: var(--danger)">*</span></label><textarea id="fStreet" rows="2"
            placeholder="Nama jalan, nomor rumah, RT/RW..."></textarea>
        </div>
        <div class="form-grid-2">
          <div class="form-group">
            <label>Provinsi</label>
            <select id="fProvince" onchange="onProvinceChange()">
              <option value="">-- Pilih Provinsi --</option>
              <option>Jawa Timur</option>
              <option>Jawa Barat</option>
              <option>Jawa Tengah</option>
              <option>DKI Jakarta</option>
              <option>Bali</option>
              <option>Sumatera Utara</option>
              <option>Sulawesi Selatan</option>
              <option>Kalimantan Timur</option>
            </select>
          </div>
          <div class="form-group">
            <label>Kota / Kabupaten</label>
            <select id="fCity" onchange="onCityChange()">
              <option value="">-- Pilih Kota --</option>
            </select>
          </div>
        </div>
        <div class="form-grid-2">
          <div class="form-group">
            <label>Kecamatan</label>
            <select id="fDistrict" onchange="onDistrictChange()">
              <option value="">-- Pilih Kecamatan --</option>
            </select>
          </div>
          <div class="form-group">
            <label>Desa / Kelurahan</label>
            <select id="fVillage">
              <option value="">-- Pilih Desa --</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>Kode Pos</label><input id="fPostal" placeholder="Kode pos..." type="number" style="max-width: 140px" />
        </div>
        <div class="default-toggle" id="defaultToggleWrap" onclick="toggleDefault()">
          <div>
            <div class="toggle-label">Jadikan Alamat Utama</div>
            <div class="toggle-sub">
              Alamat ini otomatis dipilih saat checkout
            </div>
          </div>
          <div class="toggle-switch" id="defaultToggle">
            <div class="toggle-knob"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal()">Batal</button>
        <button class="btn btn-primary" onclick="saveAddress()">
          💾 Simpan Alamat
        </button>
      </div>
      </div>
      </div>

      <!-- DELETE CONFIRM MODAL -->
      <div class="modal-overlay" id="deleteModal">
        <div class="confirm-modal">
          <div class="confirm-icon">🗑️</div>
          <div class="confirm-title">Hapus Alamat?</div>
          <p class="confirm-text" id="deleteModalText">
            Alamat ini akan dihapus permanen dan tidak dapat dikembalikan.
          </p>
          <div class="confirm-btns">
            <button class="btn btn-outline" onclick="closeDeleteModal()">
              Batal
            </button>
            <button class="btn btn-danger" id="confirmDeleteBtn">
              Ya, Hapus
            </button>
          </div>
        </div>
      </div>

      <!-- PROFILE TOAST -->
      <div class="profile-toast" id="profileToast"></div>

      <!-- MAIN CONTENT -->
      <div class="container">
        <div class="breadcrumb"><a href="index.html">Home</a> › Profil Saya</div>
        <div class="profile-layout">
          <!-- SIDEBAR -->
          <div class="profile-sidebar">
            <div class="profile-avatar-section">
              <div class="avatar-circle" id="sidebarAvatar">BS</div>
              <div class="profile-user-name" id="sidebarName">Budi Santoso</div>
              <div class="profile-user-email" id="sidebarEmail">
                budi.s@email.com
              </div>
              <div class="profile-joined">📅 Bergabung November 2024</div>
            </div>
            <nav class="profile-nav">
              <a href="#" class="pnav-item active" onclick="switchPanel('overview', this)">
                <span class="pnav-icon">🏠</span> Ikhtisar Akun
              </a>
              <a href="#" class="pnav-item" onclick="switchPanel('addresses', this)">
                <span class="pnav-icon">📍</span> Alamat Pengiriman
                <span class="pnav-badge" id="addrCountBadge">0</span>
              </a>
              <a href="orders.html" class="pnav-item">
                <span class="pnav-icon">📋</span> Riwayat Pesanan
              </a>
              <a href="#" class="pnav-item" onclick="switchPanel('settings', this)">
                <span class="pnav-icon">⚙️</span> Pengaturan Akun
              </a>
              <a href="login.html" class="pnav-item" style="color: var(--danger)">
                <span class="pnav-icon">🚪</span> Keluar
              </a>
            </nav>
          </div>

          <!-- CONTENT -->
          <div>
            <!-- PANEL: OVERVIEW -->
            <div class="profile-panel active" id="panel-overview">
              <div class="quick-stats">
                <div class="qs-card">
                  <div class="qs-num" style="color: var(--blue)">4</div>
                  <div class="qs-label">Total Pesanan</div>
                </div>
                <div class="qs-card">
                  <div class="qs-num" style="color: var(--success)">1</div>
                  <div class="qs-label">Selesai</div>
                </div>
                <div class="qs-card">
                  <div class="qs-num" id="overviewAddrCount" style="color: var(--teal)">
                    0
                  </div>
                  <div class="qs-label">Alamat Tersimpan</div>
                </div>
              </div>
              <div class="panel-card">
                <div class="panel-head">
                  <div>
                    <h2>Informasi Akun</h2>
                    <p>Ubah data profil akun Anda di sini</p>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="form-group" style="margin-bottom: 14px">
                    <label class="info-key">Nama Lengkap</label>
                    <input type="text" id="editName" placeholder="Nama lengkap Anda..." />
                  </div>
                  <div class="form-group" style="margin-bottom: 14px">
                    <label class="info-key">Email</label>
                    <input type="email" id="editEmail" placeholder="nama@email.com..." />
                  </div>
                  <div class="form-group" style="margin-bottom: 18px">
                    <label class="info-key">No. Telepon</label>
                    <input type="tel" id="editPhone" placeholder="08xx-xxxx-xxxx..." />
                  </div>
                  <div class="info-row" style="padding-top: 10px; border-top: 1px solid var(--g100)">
                    <span class="info-key">Bergabung Sejak</span>
                    <span class="info-val" id="infoJoined">–</span>
                  </div>
                  <div style="margin-top: 20px; text-align: right">
                    <button class="btn btn-primary" onclick="saveProfile()">
                      💾 Simpan Profil
                    </button>
                  </div>
                </div>
              </div>
              <div class="panel-card">
                <div class="panel-head">
                  <div>
                    <h2>Alamat Utama</h2>
                    <p>Digunakan sebagai default di checkout</p>
                  </div>
                  <button class="btn btn-outline btn-sm" onclick="
                          switchPanel(
                            'addresses',
                            document.querySelector('.pnav-item:nth-child(2)'),
                          )
                        ">
                    Kelola Semua →
                  </button>
                </div>
                <div class="panel-body" id="defaultAddrPreview">
                  <div style="text-align: center; padding: 20px; color: var(--g400)">
                    <div style="font-size: 36px; margin-bottom: 8px">📍</div>
                    Belum ada alamat utama
                  </div>
                </div>
              </div>
            </div>

            <!-- PANEL: ADDRESSES -->
            <div class="profile-panel" id="panel-addresses">
              <div class="panel-card">
                <div class="panel-head">
                  <div>
                    <h2>Alamat Pengiriman</h2>
                    <p>Kelola alamat pengiriman Anda</p>
                  </div>
                  <button class="btn btn-primary btn-sm" onclick="openAddModal()">
                    + Tambah Alamat
                  </button>
                </div>
                <div class="panel-body">
                  <div class="address-grid" id="addressGrid">
                    <!-- rendered by JS -->
                  </div>
                </div>
              </div>
            </div>

            <!-- PANEL: SETTINGS -->
            <div class="profile-panel" id="panel-settings">
              <div class="panel-card">
                <div class="panel-head">
                  <div>
                    <h2>Pengaturan Akun</h2>
                    <p>Preferensi dan privasi akun</p>
                  </div>
                </div>
                <div class="panel-body">
                  <div style="
                          background: var(--wl);
                          border-radius: var(--radius);
                          padding: 14px 18px;
                          font-size: 13px;
                          color: var(--warn);
                          font-weight: 600;
                          margin-bottom: 20px;
                          display: flex;
                          gap: 10px;
                        ">
                    <span>ℹ️</span>
                    <span>Perubahan nama, email, dan password saat ini tidak tersedia
                      melalui fitur ini. Silakan hubungi admin jika perlu
                      perubahan data.</span>
                  </div>
                  <div class="info-row">
                    <span class="info-key">Notifikasi Email</span>
                    <div style="
                            margin-left: auto;
                            display: flex;
                            align-items: center;
                            gap: 10px;
                            font-size: 13px;
                            color: var(--g600);
                          ">
                      Aktif
                      <div class="toggle-switch on" style="width: 38px; height: 22px">
                        <div class="toggle-knob" style="width: 16px; height: 16px; top: 3px; left: 19px"></div>
                      </div>
                    </div>
                  </div>
                  <div class="info-row">
                    <span class="info-key">Notifikasi Promo</span>
                    <div style="
                            margin-left: auto;
                            display: flex;
                            align-items: center;
                            gap: 10px;
                            font-size: 13px;
                            color: var(--g600);
                          ">
                      Aktif
                      <div class="toggle-switch on" style="width: 38px; height: 22px">
                        <div class="toggle-knob" style="width: 16px; height: 16px; top: 3px; left: 19px"></div>
                      </div>
                    </div>
                  </div>
                  <div class="info-row">
                    <span class="info-key">Bahasa</span>
                    <select style="
                            width: auto;
                            padding: 8px 14px;
                            font-size: 13px;
                            margin-left: auto;
                          ">
                      <option>Bahasa Indonesia</option>
                      <option>English</option>
                    </select>
                  </div>
                  <div style="
                          margin-top: 24px;
                          padding-top: 20px;
                          border-top: 1px solid var(--g100);
                        ">
                    <div style="
                            font-size: 14px;
                            font-weight: 700;
                            color: var(--danger);
                            margin-bottom: 8px;
                          ">
                      Zona Bahaya
                    </div>
                    <button class="btn btn-sm" style="
                            background: var(--dl);
                            color: var(--danger);
                            border: none;
                            font-weight: 700;
                          ">
                      🗑 Hapus Akun Saya
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /content -->
        </div>
        <!-- /layout -->
      </div>
      <!-- /container -->
    @endsection

@section('footer')
  <footer class="footer">
    <div class="footer-grid">
      <div>
        <div class="footer-brand">⚡ Elektronik Modern</div>
        <p class="footer-desc">
          Platform belanja elektronik rumah tangga terpercaya.
        </p>
      </div>
      <div>
        <h4>Belanja</h4>
        <a href="products.html">Semua Produk</a>
      </div>
      <div>
        <h4>Akun</h4>
        <a href="profile.html">Profil Saya</a><a href="orders.html">Riwayat Pesanan</a>
      </div>
      <div>
        <h4>Bantuan</h4>
        <a href="#">Hubungi Kami</a><a href="#">FAQ</a>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2024 Elektronik Modern – Kelompok 2 IF4E UTM</span>
    </div>
  </footer>

  <div class="cart-toast" id="cart-toast"></div>
@endsection

@push('scripts')
  <script src="{{ asset('shared.js') }}"></script>
  <script>
    // ===== WILAYAH DATA =====
    const WILAYAH = {
      "Jawa Timur": {
        Bangkalan: {
          Bangkalan: ["Pejagan", "Demangan", "Kemayoran", "Mlajah"],
          Burneh: ["Burneh", "Pemecutan", "Tonjung"],
          Socah: ["Socah", "Jaddih", "Bilaporah"],
        },
        Surabaya: {
          Tegalsari: ["Kedungdoro", "Kapasari", "Keputran"],
          Gubeng: ["Gubeng", "Mojo", "Airlangga"],
        },
        Malang: {
          Klojen: ["Klojen", "Oro-Oro Dowo", "Bareng"],
          Lowokwaru: ["Lowokwaru", "Tulusrejo", "Merjosari"],
        },
      },
      "DKI Jakarta": {
        "Jakarta Pusat": {
          Gambir: ["Gambir", "Cideng", "Petojo Utara"],
          "Tanah Abang": ["Tanah Abang", "Bendungan Hilir"],
        },
        "Jakarta Selatan": {
          "Kebayoran Baru": ["Senayan", "Selong", "Rawa Barat"],
          Mampang: ["Mampang Prapatan", "Tegal Parang"],
        },
      },
      "Jawa Barat": {
        Bandung: {
          Coblong: ["Dago", "Lebak Gede", "Sadang Serang"],
          Cicendo: ["Husein Sastranegara", "Pasirkaliki"],
        },
        Bekasi: {
          "Bekasi Utara": ["Marga Mulya", "Harapan Jaya"],
          "Bekasi Selatan": ["Pekayon Jaya", "Margajaya"],
        },
      },
      Bali: {
        Denpasar: {
          "Denpasar Selatan": ["Sesetan", "Pedungan", "Sanur"],
          "Denpasar Utara": ["Tonja", "Peguyangan"],
        },
        Badung: {
          Kuta: ["Kuta", "Kedonganan", "Tuban"],
          Mengwi: ["Mengwi", "Gulingan"],
        },
      },
    };

    function onProvinceChange() {
      const prov = document.getElementById("fProvince").value;
      const cityEl = document.getElementById("fCity");
      const distEl = document.getElementById("fDistrict");
      const villEl = document.getElementById("fVillage");
      cityEl.innerHTML = '<option value="">-- Pilih Kota --</option>';
      distEl.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
      villEl.innerHTML = '<option value="">-- Pilih Desa --</option>';
      if (prov && WILAYAH[prov]) {
        Object.keys(WILAYAH[prov]).forEach(
          (c) => (cityEl.innerHTML += `<option>${c}</option>`),
        );
      }
    }
    function onCityChange() {
      const prov = document.getElementById("fProvince").value;
      const city = document.getElementById("fCity").value;
      const distEl = document.getElementById("fDistrict");
      const villEl = document.getElementById("fVillage");
      distEl.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
      villEl.innerHTML = '<option value="">-- Pilih Desa --</option>';
      if (prov && city && WILAYAH[prov]?.[city]) {
        Object.keys(WILAYAH[prov][city]).forEach(
          (d) => (distEl.innerHTML += `<option>${d}</option>`),
        );
      }
    }
    function onDistrictChange() {
      const prov = document.getElementById("fProvince").value;
      const city = document.getElementById("fCity").value;
      const dist = document.getElementById("fDistrict").value;
      const villEl = document.getElementById("fVillage");
      villEl.innerHTML = '<option value="">-- Pilih Desa --</option>';
      if (prov && city && dist && WILAYAH[prov]?.[city]?.[dist]) {
        WILAYAH[prov][city][dist].forEach(
          (v) => (villEl.innerHTML += `<option>${v}</option>`),
        );
      }
    }

    // ===== PANEL SWITCHER =====
    function switchPanel(id, el) {
      document
        .querySelectorAll(".profile-panel")
        .forEach((p) => p.classList.remove("active"));
      document
        .querySelectorAll(".pnav-item")
        .forEach((i) => i.classList.remove("active"));
      document.getElementById("panel-" + id).classList.add("active");
      if (el) el.classList.add("active");
      if (id === "addresses") renderAddresses();
      if (id === "overview") renderOverview();
    }

    // ===== RENDER FUNCTIONS =====
    function renderOverview() {
      const u = getUser();
      document.getElementById("editName").value = u.name;
      document.getElementById("editEmail").value = u.email;
      document.getElementById("editPhone").value = u.phone;
      document.getElementById("infoJoined").textContent = u.joined;

      document.getElementById("sidebarName").textContent = u.name;
      document.getElementById("sidebarEmail").textContent = u.email;

      const initials = u.name
        .split(" ")
        .map((n) => n[0])
        .join("")
        .substring(0, 2)
        .toUpperCase();
      document.getElementById("sidebarAvatar").textContent = initials;
      const addresses = getAddresses();
      const cnt = addresses.length;
      document.getElementById("overviewAddrCount").textContent = cnt;
      document.getElementById("addrCountBadge").textContent = cnt;

      const def = getDefaultAddress();
      const prev = document.getElementById("defaultAddrPreview");
      if (def) {
        prev.innerHTML = `
        <div style="display:flex;align-items:flex-start;gap:14px">
          <div style="width:44px;height:44px;border-radius:12px;background:var(--blue-l);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0">📍</div>
          <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
              <span style="font-weight:800;font-size:14px">${def.name}</span>
              <span style="font-size:11px;font-weight:700;background:var(--blue);color:#fff;padding:2px 8px;border-radius:50px">${def.label}</span>
            </div>
            <div style="font-size:13px;color:var(--g500);margin-bottom:4px">${def.phone}</div>
            <div style="font-size:13px;color:var(--g700);line-height:1.6">${def.street}, ${def.village}, ${def.district}, ${def.city}, ${def.province} ${def.postal}</div>
          </div>
        </div>`;
      } else {
        prev.innerHTML = `<div style="text-align:center;padding:20px;color:var(--g400)"><div style="font-size:36px;margin-bottom:8px">📍</div>Belum ada alamat utama.<br><a href="#" onclick="switchPanel('addresses',document.querySelector('.pnav-item:nth-child(2)'));openAddModal();return false;" style="color:var(--blue);font-weight:700;text-decoration:none">+ Tambah sekarang</a></div>`;
      }
    }

    function renderAddresses() {
      const addresses = getAddresses();
      const grid = document.getElementById("addressGrid");
      const cnt = addresses.length;
      document.getElementById("addrCountBadge").textContent = cnt;
      document.getElementById("overviewAddrCount").textContent = cnt;

      let html = "";
      addresses.forEach((addr) => {
        html += `
      <div class="addr-card ${addr.isDefault ? "default" : ""}" id="addr-${addr.id}">
        <div class="addr-label-row">
          <span class="addr-label">${addr.label}</span>
          ${addr.isDefault ? '<span class="addr-default-badge">✓ Utama</span>' : ""}
        </div>
        <div class="addr-name">${addr.name}</div>
        <div class="addr-phone">📞 ${addr.phone}</div>
        <div class="addr-street">${addr.street}</div>
        <div class="addr-region">${addr.village}, ${addr.district}, ${addr.city}, ${addr.province} ${addr.postal}</div>
        <div class="addr-actions">
          <button class="btn-addr-edit" onclick="openEditModal(${addr.id})">✏️ Edit</button>
          <button class="btn-addr-del" onclick="confirmDelete(${addr.id},'${addr.label}')">🗑 Hapus</button>
          ${!addr.isDefault ? `<button class="btn-addr-default" onclick="setAsDefault(${addr.id})">⭐ Jadikan Utama</button>` : ""}
        </div>
      </div>`;
      });

      // Add new address card
      html += `
      <div class="add-addr-card" onclick="openAddModal()">
        <div class="add-addr-icon">＋</div>
        <div class="add-addr-text">Tambah Alamat Baru</div>
        <div class="add-addr-sub">Simpan lebih banyak lokasi pengiriman</div>
      </div>`;

      grid.innerHTML = html;
    }

    // ===== MODAL HELPERS =====
    let isDefaultOn = false;

    function toggleDefault() {
      isDefaultOn = !isDefaultOn;
      const sw = document.getElementById("defaultToggle");
      sw.classList.toggle("on", isDefaultOn);
    }

    function setDefaultToggle(val) {
      isDefaultOn = val;
      document.getElementById("defaultToggle").classList.toggle("on", val);
    }

    // ===== FUNGSI SIMPAN PROFIL =====
    function saveProfile() {
      const newName = document.getElementById("editName").value.trim();
      const newEmail = document.getElementById("editEmail").value.trim();
      const newPhone = document.getElementById("editPhone").value.trim();

      // Validasi jika ada yang kosong
      if (!newName || !newEmail || !newPhone) {
        showProfileToast("⚠️ Mohon lengkapi semua data profil", true);
        return;
      }

      // Ambil data user saat ini dari fungsi di shared.js
      const u = getUser();

      // Update dengan data baru
      u.name = newName;
      u.email = newEmail;
      u.phone = newPhone;

      // Simpan kembali ke localStorage
      localStorage.setItem("eh_user", JSON.stringify(u));

      // Render ulang tampilan agar sidebar langsung berubah
      renderOverview();

      // Tampilkan notifikasi sukses hijau
      showProfileToast("✅ Profil berhasil diperbarui!");
    }

    function openAddModal() {
      document.getElementById("editAddrId").value = "";
      document.getElementById("modalTitle").textContent =
        "Tambah Alamat Baru";
      document.getElementById("modalSub").textContent =
        "Isi data alamat pengiriman dengan lengkap";
      ["fLabel", "fName", "fPhone", "fStreet", "fPostal"].forEach(
        (id) => (document.getElementById(id).value = ""),
      );
      document.getElementById("fProvince").value = "";
      onProvinceChange();
      setDefaultToggle(getAddresses().length === 0);
      document.getElementById("addrModal").classList.add("open");
    }

    function openEditModal(id) {
      const addr = getAddresses().find((a) => a.id === id);
      if (!addr) return;
      document.getElementById("editAddrId").value = id;
      document.getElementById("modalTitle").textContent = "Edit Alamat";
      document.getElementById("modalSub").textContent =
        `Mengubah alamat: ${addr.label}`;
      document.getElementById("fLabel").value = addr.label;
      document.getElementById("fName").value = addr.name;
      document.getElementById("fPhone").value = addr.phone;
      document.getElementById("fStreet").value = addr.street;
      document.getElementById("fPostal").value = addr.postal;
      // Set province then chain
      document.getElementById("fProvince").value = addr.province;
      onProvinceChange();
      setTimeout(() => {
        document.getElementById("fCity").value = addr.city;
        onCityChange();
        setTimeout(() => {
          document.getElementById("fDistrict").value = addr.district;
          onDistrictChange();
          setTimeout(() => {
            document.getElementById("fVillage").value = addr.village;
          }, 50);
        }, 50);
      }, 50);
      setDefaultToggle(addr.isDefault);
      document.getElementById("addrModal").classList.add("open");
    }

    function closeModal() {
      document.getElementById("addrModal").classList.remove("open");
    }

    function saveAddress() {
      const label = document.getElementById("fLabel").value.trim();
      const name = document.getElementById("fName").value.trim();
      const phone = document.getElementById("fPhone").value.trim();
      const street = document.getElementById("fStreet").value.trim();
      const province = document.getElementById("fProvince").value;
      const city = document.getElementById("fCity").value;
      const district = document.getElementById("fDistrict").value;
      const village = document.getElementById("fVillage").value;
      const postal = document.getElementById("fPostal").value.trim();

      if (!label || !name || !phone || !street || !province || !city) {
        showProfileToast("⚠️ Mohon lengkapi semua field wajib", true);
        return;
      }

      const data = {
        label,
        name,
        phone,
        street,
        province,
        city,
        district,
        village,
        postal,
        isDefault: isDefaultOn,
      };
      const editId = document.getElementById("editAddrId").value;

      if (editId) {
        updateAddress(parseInt(editId), data);
        showProfileToast("✅ Alamat berhasil diperbarui!");
      } else {
        addAddress(data);
        showProfileToast("✅ Alamat baru berhasil ditambahkan!");
      }

      closeModal();
      renderAddresses();
      renderOverview();
    }

    // ===== DELETE =====
    let pendingDeleteId = null;

    function confirmDelete(id, label) {
      pendingDeleteId = id;
      document.getElementById("deleteModalText").textContent =
        `Alamat "${label}" akan dihapus permanen.`;
      document.getElementById("deleteModal").classList.add("open");
      document.getElementById("confirmDeleteBtn").onclick = () => {
        deleteAddress(pendingDeleteId);
        closeDeleteModal();
        renderAddresses();
        renderOverview();
        showProfileToast("🗑 Alamat berhasil dihapus");
      };
    }

    function closeDeleteModal() {
      document.getElementById("deleteModal").classList.remove("open");
      pendingDeleteId = null;
    }

    // ===== SET DEFAULT =====
    function setAsDefault(id) {
      setDefaultAddress(id);
      renderAddresses();
      renderOverview();
      showProfileToast("⭐ Alamat utama berhasil diperbarui!");
    }

    // ===== TOAST =====
    function showProfileToast(msg, isWarn = false) {
      const t = document.getElementById("profileToast");
      t.textContent = msg;
      t.style.background = isWarn ? "var(--warn)" : "var(--dark)";
      t.classList.add("show");
      clearTimeout(t._t);
      t._t = setTimeout(() => t.classList.remove("show"), 3000);
    }

    // ===== CART SIDEBAR =====
    function renderCart() {
      updateCartBadge();
      const el = document.getElementById("cartItems"),
        foot = document.getElementById("cartFooter");
      if (!CART.length) {
        el.innerHTML = `<div class="cart-empty"><div class="empty-icon">🛒</div><div style="font-weight:700">Keranjang Kosong</div><a href="products.html" class="btn btn-primary" style="margin-top:16px;display:inline-flex">Belanja</a></div>`;
        foot.innerHTML = "";
        return;
      }
      el.innerHTML = CART.map(
        (i) =>
          `<div class="cart-item"><img src="${i.img}" class="cart-item-img"><div class="cart-item-info"><div class="cart-item-name">${i.name}</div><div class="cart-item-price">${fmt(i.price)}</div></div><button class="cart-remove" onclick="removeFromCart(${i.id});renderCart()">🗑</button></div>`,
      ).join("");
      const t = cartTotal();
      foot.innerHTML = `<div class="cart-total"><span>Total</span><span>${fmt(t)}</span></div><a href="checkout.html" class="btn btn-primary" style="width:100%;justify-content:center;padding:13px;margin-top:12px">💳 Checkout</a>`;
    }
    function openCart() {
      document.getElementById("cartSidebar").classList.add("open");
      document.getElementById("cartOverlay").classList.add("open");
      document.body.style.overflow = "hidden";
      renderCart();
    }
    function closeCart() {
      document.getElementById("cartSidebar").classList.remove("open");
      document.getElementById("cartOverlay").classList.remove("open");
      document.body.style.overflow = "";
    }

    // ===== NOTIFICATIONS =====
    function renderNotifs() {
      document.getElementById("notifList").innerHTML = NOTIFICATIONS.map(
        (n) =>
          `<div class="notif-item ${n.read ? "" : "unread"}"><div class="notif-icon">${n.icon}</div><div><div class="notif-title">${n.title}</div><div class="notif-msg">${n.msg}</div><div class="notif-time">${n.time}</div></div></div>`,
      ).join("");
      updateNotifBadge();
    }
    function toggleNotif() {
      const p = document.getElementById("notifPanel"),
        o = document.getElementById("notifOverlay");
      const open = p.classList.toggle("open");
      o.style.display = open ? "block" : "none";
      if (open) renderNotifs();
    }
    function closeNotif() {
      document.getElementById("notifPanel").classList.remove("open");
      document.getElementById("notifOverlay").style.display = "none";
    }
    function markAllRead() {
      NOTIFICATIONS.forEach((n) => (n.read = true));
      renderNotifs();
    }

    // Close modals on overlay click
    document.getElementById("addrModal").addEventListener("click", (e) => {
      if (e.target === e.currentTarget) closeModal();
    });
    document.getElementById("deleteModal").addEventListener("click", (e) => {
      if (e.target === e.currentTarget) closeDeleteModal();
    });

    // ===== INIT =====
    updateCartBadge();
    updateNotifBadge();
    renderOverview();
  </script>
@endpush