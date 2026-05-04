@extends('layouts.app')

@section('title', 'Checkout – Elektronik Modern')

@section('head')
    <link rel="stylesheet" href="{{ asset('shared.css') }}" />
    <style>
        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px;
            padding: 32px 0 64px;
            align-items: start;
        }

        .checkout-card {
            background: #fff;
            border-radius: var(--rlg);
            box-shadow: var(--sh);
            padding: 26px;
            margin-bottom: 16px;
        }

        .step-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .step-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--blue);
            color: #fff;
            font-size: 13px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
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

        .pay-opt {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px;
            border: 2px solid var(--g200);
            border-radius: var(--rlg);
            cursor: pointer;
            transition: 0.2s;
            margin-bottom: 10px;
        }

        .pay-opt:hover,
        .pay-opt.selected {
            border-color: var(--blue);
            background: var(--blue-l);
        }

        .pay-opt input[type="radio"] {
            accent-color: var(--blue);
            width: 18px;
            height: 18px;
        }

        .pay-icon {
            font-size: 28px;
        }

        .pay-label {
            font-weight: 700;
            font-size: 14px;
            color: var(--g800);
        }

        .pay-sub {
            font-size: 12px;
            color: var(--g500);
        }

        .bank-detail {
            background: var(--blue-l);
            border-radius: var(--radius);
            padding: 16px;
            margin-top: 12px;
            border-left: 4px solid var(--blue);
        }

        .upload-zone {
            border: 2px dashed var(--g300);
            border-radius: var(--rlg);
            padding: 32px;
            text-align: center;
            color: var(--g400);
            cursor: pointer;
            transition: 0.2s;
        }

        .upload-zone:hover {
            border-color: var(--blue);
            background: var(--blue-l);
        }

        .upload-icon {
            font-size: 44px;
            margin-bottom: 10px;
        }

        .order-sum {
            background: #fff;
            border-radius: var(--rlg);
            box-shadow: var(--sh);
            overflow: hidden;
            position: sticky;
            top: 84px;
        }

        .os-head {
            padding: 18px 22px;
            background: var(--g50);
            border-bottom: 1px solid var(--g100);
            font-weight: 800;
            font-size: 15px;
        }

        .os-item {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 14px 22px;
            border-bottom: 1px solid var(--g100);
        }

        .os-item-img {
            width: 52px;
            height: 52px;
            border-radius: 10px;
            object-fit: cover;
            background: var(--g100);
            flex-shrink: 0;
        }

        .os-item-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--g800);
            line-height: 1.4;
        }

        .os-item-qty {
            font-size: 12px;
            color: var(--g400);
        }

        .os-item-price {
            margin-left: auto;
            font-weight: 800;
            font-size: 14px;
            color: var(--blue);
            font-family: "Syne", sans-serif;
            white-space: nowrap;
        }

        .os-footer {
            padding: 18px 22px;
        }

        .os-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 8px;
            color: var(--g600);
        }

        .os-total {
            display: flex;
            justify-content: space-between;
            padding-top: 12px;
            margin-top: 6px;
            border-top: 2px solid var(--g200);
        }

        .os-total span:first-child {
            font-weight: 700;
            font-size: 15px;
        }

        .os-total span:last-child {
            font-family: "Syne", sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: var(--blue);
        }
    </style>
@endsection

@section('header')
    <nav class="navbar">
        <a href="index.html" class="nav-logo">⚡ Elektronik<span>Modern</span></a>
        <div class="nav-right">
            <a href="profile.html" class="nav-icon-btn" title="Profil" style="text-decoration: none; font-size: 16px">👤</a>
            <a href="cart.html" class="btn btn-outline btn-sm">← Kembali ke Keranjang</a>
        </div>
    </nav>
@endsection

@section('content')
    <div class="container">
        <div class="breadcrumb">
            <a href="index.html">Home</a> › <a href="cart.html">Keranjang</a> ›
            Checkout
        </div>
        <div style="margin-bottom: 20px">
            <div class="section-title" style="font-size: 26px">
                💳 Proses Checkout
            </div>
        </div>
        <div class="checkout-layout">
            <div>
                <!-- Saved address banner -->
                <div id="savedAddrBanner" style="
                  background: var(--blue-l);
                  border-radius: var(--rlg);
                  padding: 16px 20px;
                  margin-bottom: 16px;
                  border: 1.5px solid rgba(26, 92, 255, 0.3);
                  display: flex;
                  align-items: center;
                  gap: 14px;
                ">
                    <div style="font-size: 24px">📍</div>
                    <div style="flex: 1">
                        <div style="
                      font-size: 11px;
                      font-weight: 700;
                      color: var(--blue);
                      margin-bottom: 2px;
                      letter-spacing: 0.04em;
                    ">
                            ALAMAT TERSIMPAN
                        </div>
                        <div style="font-size: 13px; font-weight: 700; color: var(--g800)" id="bannerAddrName">
                            Memuat…
                        </div>
                        <div style="font-size: 12px; color: var(--g500)" id="bannerAddrDetail"></div>
                    </div>
                    <button class="btn btn-primary btn-sm" onclick="fillFromDefault()">
                        Gunakan
                    </button>
                    <a href="profile.html" class="btn btn-outline btn-sm">Ganti</a>
                </div>

                <!-- Step 1: Address -->
                <div class="checkout-card">
                    <div class="step-title">
                        <span class="step-num">1</span>Alamat Pengiriman
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label>Nama Penerima</label><input id="co-name" placeholder="Nama lengkap..." />
                        </div>
                        <div class="form-group">
                            <label>No. Telepon</label><input id="co-phone" placeholder="08xx-xxxx-xxxx" type="tel" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat Lengkap</label><textarea id="co-street" rows="2"
                            placeholder="Jl. ... No. ... RT/RW ..."></textarea>
                    </div>
                    <div class="form-grid-3">
                        <div class="form-group">
                            <label>Provinsi</label><select id="co-province">
                                <option>Jawa Timur</option>
                                <option>Jawa Barat</option>
                                <option>DKI Jakarta</option>
                                <option>Bali</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kota</label><select id="co-city">
                                <option>Bangkalan</option>
                                <option>Surabaya</option>
                                <option>Malang</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label><select id="co-district">
                                <option>Bangkalan</option>
                                <option>Burneh</option>
                                <option>Socah</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label>Desa / Kelurahan</label><input placeholder="Nama desa..." />
                        </div>
                        <div class="form-group">
                            <label>Kode Pos</label><input id="co-postal" placeholder="69101" type="number" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Catatan (opsional)</label><input placeholder="Catatan untuk kurir..." />
                    </div>
                </div>
                <!-- Step 2: Payment -->
                <div class="checkout-card">
                    <div class="step-title">
                        <span class="step-num">2</span>Metode Pembayaran
                    </div>
                    <div class="pay-opt selected" onclick="selectPay(this, 'bank')">
                        <input type="radio" name="pay" checked />
                        <div class="pay-icon">🏦</div>
                        <div>
                            <div class="pay-label">Transfer Bank</div>
                            <div class="pay-sub">BCA · BRI · BNI · Mandiri</div>
                        </div>
                    </div>
                    <div class="pay-opt" onclick="selectPay(this, 'ewallet')">
                        <input type="radio" name="pay" />
                        <div class="pay-icon">💚</div>
                        <div>
                            <div class="pay-label">E-Wallet</div>
                            <div class="pay-sub">GoPay · OVO · DANA · ShopeePay</div>
                        </div>
                    </div>
                    <div class="bank-detail" id="bankDetail">
                        <div style="font-weight: 700; color: var(--blue); margin-bottom: 6px">
                            📋 Detail Transfer Bank:
                        </div>
                        <div style="font-size: 14px; color: var(--g700)">
                            <strong>Bank BCA</strong> – No. Rek:
                            <strong>1234-5678-90</strong>
                        </div>
                        <div style="font-size: 13px; color: var(--g500)">
                            a.n. Elektronik Modern Store
                        </div>
                        <div style="font-size: 12px; color: var(--g400); margin-top: 6px">
                            ⚠️ Pastikan nominal transfer sesuai total pesanan
                        </div>
                    </div>
                </div>
                <!-- Step 3: Upload -->
                <div class="checkout-card">
                    <div class="step-title">
                        <span class="step-num">3</span>Upload Bukti Pembayaran
                    </div>
                    <div class="upload-zone" onclick="this.querySelector('input').click()">
                        <div class="upload-icon">📸</div>
                        <div style="font-weight: 700; font-size: 15px; margin-bottom: 4px">
                            Klik atau seret file ke sini
                        </div>
                        <div style="font-size: 13px">
                            Format: JPG, PNG, PDF · Maks. 5MB
                        </div>
                        <input type="file" accept="image/*,.pdf" style="display: none" onchange="handleUpload(this)" />
                    </div>
                    <div id="uploadPreview" style="
                    display: none;
                    margin-top: 12px;
                    background: var(--sl);
                    border-radius: var(--radius);
                    padding: 12px;
                    font-size: 13px;
                    color: var(--success);
                    font-weight: 600;
                  ">
                        ✅ File berhasil dipilih!
                    </div>
                </div>
            </div>
            <!-- Order Summary -->
            <div>
                <div class="order-sum">
                    <div class="os-head">📦 Ringkasan Pesanan</div>
                    <div id="osSummaryItems"></div>
                    <div class="os-footer">
                        <div class="os-row">
                            <span>Subtotal</span><span id="osBase">–</span>
                        </div>
                        <div class="os-row">
                            <span>Diskon</span><span style="color: var(--danger)" id="osDisc">–</span>
                        </div>
                        <div class="os-row">
                            <span>Ongkos Kirim</span><span style="color: var(--success)">GRATIS</span>
                        </div>
                        <div class="os-total">
                            <span>Total Bayar</span><span id="osTotal">–</span>
                        </div>
                        <button class="btn btn-primary" style="
                      width: 100%;
                      justify-content: center;
                      padding: 14px;
                      margin-top: 20px;
                      font-size: 15px;
                    " onclick="confirmOrder()">
                            ✅ Konfirmasi Pesanan
                        </button>
                        <div style="
                      font-size: 11px;
                      color: var(--g400);
                      text-align: center;
                      margin-top: 10px;
                    ">
                            🔒 Pesanan diproses setelah konfirmasi admin
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <footer class="footer">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">⚡ Elektronik Modern</div>
                <p class="footer-desc">Platform belanja elektronik terpercaya.</p>
            </div>
            <div>
                <h4>Belanja</h4>
                <a href="products.html">Produk</a>
            </div>
            <div>
                <h4>Bantuan</h4>
                <a href="#">Kontak</a>
            </div>
            <div>
                <h4>Perusahaan</h4>
                <a href="#">Tentang Kami</a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2024 Elektronik Modern – Kelompok 2 IF4E UTM</span>
        </div>
    </footer>
@endsection

@push('scripts')
    <script src="{{ asset('shared.js') }}"></script>
    <script>
        if (!CART.length) {
            CART.push(
                { ...PRODUCTS[0], qty: 1 },
                { ...PRODUCTS[1], qty: 1 },
                { ...PRODUCTS[3], qty: 2 },
            );
            saveCart();
        }

        // Auto-fill from saved default address
        (function () {
            const def = getDefaultAddress();
            if (def) {
                document.getElementById("bannerAddrName").textContent =
                    def.name + " (" + def.label + ") • " + def.phone;
                document.getElementById("bannerAddrDetail").textContent =
                    def.street +
                    ", " +
                    def.village +
                    ", " +
                    def.district +
                    ", " +
                    def.city;
            } else {
                document.getElementById("savedAddrBanner").style.display = "none";
            }
        })();

        function fillFromDefault() {
            const def = getDefaultAddress();
            if (!def) return;
            // Find inputs by position in the form
            const inputs = document.querySelectorAll(
                ".checkout-card input, .checkout-card textarea, .checkout-card select",
            );
            // Map: name, phone, street, province, city, district, village, postal
            const fields = [
                { sel: "#co-name", val: def.name },
                { sel: "#co-phone", val: def.phone },
                { sel: "#co-street", val: def.street },
                { sel: "#co-postal", val: def.postal },
            ];
            document.getElementById("co-name").value = def.name;
            document.getElementById("co-phone").value = def.phone;
            document.getElementById("co-street").value = def.street;
            document.getElementById("co-postal").value = def.postal;
            document.getElementById("co-province").value = def.province;
            document.getElementById("co-city").value = def.city;
            document.getElementById("co-district").value = def.district;
            showFillToast('✅ Alamat "' + def.label + '" berhasil diisi!');
        }
        function showFillToast(msg) {
            let t = document.getElementById("fill-toast");
            if (!t) {
                t = document.createElement("div");
                t.id = "fill-toast";
                t.className = "cart-toast";
                document.body.appendChild(t);
            }
            t.textContent = msg;
            t.classList.add("show");
            clearTimeout(t._t);
            t._t = setTimeout(() => t.classList.remove("show"), 3000);
        }
        function renderSummary() {
            const t = cartTotal(),
                disc = t > 5000000 ? 500000 : 0;
            document.getElementById("osBase").textContent = fmt(t);
            document.getElementById("osDisc").textContent = "−" + fmt(disc);
            document.getElementById("osTotal").textContent = fmt(t - disc);
            document.getElementById("osSummaryItems").innerHTML = CART.map(
                (i) =>
                    `<div class="os-item"><img src="${i.img}" class="os-item-img"><div style="flex:1;min-width:0"><div class="os-item-name">${i.name}</div><div class="os-item-qty">×${i.qty}</div></div><div class="os-item-price">${fmt(i.price * i.qty)}</div></div>`,
            ).join("");
        }
        function selectPay(el, type) {
            document
                .querySelectorAll(".pay-opt")
                .forEach((o) => o.classList.remove("selected"));
            el.classList.add("selected");
            el.querySelector("input").checked = true;
            document.getElementById("bankDetail").style.display =
                type === "bank" ? "block" : "none";
        }
        function handleUpload(inp) {
            if (inp.files.length > 0)
                document.getElementById("uploadPreview").style.display = "block";
        }
        function confirmOrder() {
            alert(
                "✅ Pesanan berhasil dikonfirmasi!\n\nNo. Pesanan: #ORD-20241206-" +
                Math.floor(Math.random() * 999 + 100) +
                "\nAdmin akan memverifikasi pembayaran Anda dalam 1×24 jam.",
            );
            window.location.href = "orders.html";
        }
        renderSummary();
    </script>
@endpush