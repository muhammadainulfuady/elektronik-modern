# 📋 Review Kesesuaian: SKPL vs Implementasi Project

Review ini membandingkan dokumen **SKPL (Spesifikasi Kebutuhan Perangkat Lunak)** dengan implementasi aktual pada project Laravel **Elektronik Modern**.

---

## 1. Kebutuhan Fungsional Customer

### 1.1 Registrasi Akun
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Menampilkan form pendaftaran akun baru (nama, email, password) | [AuthController::showRegister()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/AuthController.php#L103-L106) → view `auth.register` | ✅ Sesuai |
| Menyimpan data pelanggan pada database | [AuthController::register()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/AuthController.php#L111-L127) → `User::create()` dengan role `customer` | ✅ Sesuai |

---

### 1.2 Login Akun
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Menampilkan form login (email + password) | [AuthController::showLogin()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/AuthController.php#L15-L18) → view `auth.login` | ✅ Sesuai |
| Mengecek kredensial pada database | [AuthController::login()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/AuthController.php#L23-L46) → `Auth::attempt($credentials)` | ✅ Sesuai |
| Redirect berdasarkan role (customer/admin/owner) | `match ($user->role)` → redirect ke halaman masing-masing | ✅ Sesuai |

---

### 1.3 Melihat Daftar Produk & Pencarian
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Menampilkan form pencarian produk | [ProdukController::catalog()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/ProdukController.php#L55-L83) → filter `q` (search by name) | ✅ Sesuai |
| Mencari produk berdasarkan nama | `$query->where('nama_produk', 'like', '%' . $request->q . '%')` | ✅ Sesuai |
| Filter berdasarkan kategori | `$query->where('id_kategori', $request->kategori)` | ✅ Sesuai |
| Sorting (terbaru, termurah, termahal, nama) | `match ($sort)` → 4 opsi sorting | ✅ Sesuai |
| Pagination | `$query->paginate(12)` | ✅ Sesuai |

---

### 1.4 Memasukkan Produk ke Keranjang
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Memasukkan produk ke keranjang + notifikasi sukses | [CartController::add()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/CartController.php#L59-L89) → session-based cart + flash message | ✅ Sesuai |
| Menampilkan daftar keranjang (jumlah, subtotal per item) | [CartController::index()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/CartController.php#L15-L42) → items, subtotal, discount, total | ✅ Sesuai |
| Update qty & hapus item | [CartController::update()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/CartController.php#L94-L122) & [remove()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/CartController.php#L127-L142) | ✅ Sesuai |
| Apply/remove voucher di keranjang | [CartController::applyVoucher()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/CartController.php#L144-L163) & [removeVoucher()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/CartController.php#L165-L170) | ✅ Sesuai |

---

### 1.5 Checkout
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Menampilkan halaman checkout (total harga, form alamat, metode pembayaran) | [PesananController::checkout()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/PesananController.php#L94-L125) → items, subtotal, discount, alamats, ekspedisis | ✅ Sesuai |
| Customer memilih alamat pengiriman | Pilih dari `AlamatUser` yang sudah tersimpan | ✅ Sesuai |
| Customer memilih metode pembayaran (transfer/e-wallet) | Input `metode_pembayaran` (manual, tanpa payment gateway) | ✅ Sesuai |
| Upload bukti bayar | Input `bukti_bayar` (file upload: jpg, png, pdf) | ✅ Sesuai |
| Pembayaran manual (BUKAN payment gateway) | Sesuai SKPL — tidak ada integrasi API payment gateway | ✅ Sesuai |
| Memproses pesanan ke admin | `Pesanan::create()` + `Pembayaran::create()` + notifikasi ke customer | ✅ Sesuai |
| Pengurangan stok otomatis | `Produk::decrement('stok', $item['qty'])` | ✅ Sesuai |
| Pengurangan kuota promo | `$appliedPromo->decrement('kuota')` | ✅ Sesuai |

---

### 1.6 Melihat Riwayat Pesanan
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Menampilkan seluruh transaksi customer | [PesananController::customerOrders()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/PesananController.php#L81-L89) → view `customer.orders` | ✅ Sesuai |
| Status pesanan terlihat (menunggu, diproses, dikirim, selesai) | Data `status_pesanan` ditampilkan | ✅ Sesuai |

---

### 1.7 Edit Profil
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Menampilkan form edit profil | [UserController::profile()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/UserController.php#L193-L205) → view `customer.profile` | ✅ Sesuai |
| Menyimpan perubahan data (nama, email, password) | [UserController::updateProfile()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/UserController.php#L273-L294) | ✅ Sesuai |
| Kelola alamat (tambah, edit, hapus) | [storeAlamat()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/UserController.php#L210-L229), [updateAlamat()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/UserController.php#L231-L253), [destroyAlamat()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/UserController.php#L255-L268) | ✅ Sesuai |

---

## 2. Kebutuhan Fungsional Admin

### 2.1 Kelola Produk
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Menampilkan daftar produk + opsi CRUD | [ProdukController::adminIndex()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/ProdukController.php#L103-L109) → view `admin.products` | ✅ Sesuai |
| Tambah produk baru (nama, harga, stok, gambar, deskripsi, kategori) | [ProdukController::store()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/ProdukController.php#L114-L135) | ✅ Sesuai |
| Edit produk | [ProdukController::edit()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/ProdukController.php#L140-L145) & [update()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/ProdukController.php#L150-L179) | ✅ Sesuai |
| Hapus produk | [ProdukController::destroy()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/ProdukController.php#L184-L196) | ✅ Sesuai |
| Update stok | Melalui form edit produk → field `stok` | ✅ Sesuai |

---

### 2.2 Kelola Kategori
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Menampilkan daftar kategori + opsi CRUD | [KategoriController::index()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/KategoriController.php#L23-L30) → view `admin.categories` | ✅ Sesuai |
| Tambah kategori (nama + ikon) | [KategoriController::store()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/KategoriController.php#L32-L49) | ✅ Sesuai |
| Edit kategori | [KategoriController::update()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/KategoriController.php#L51-L76) | ✅ Sesuai |
| Hapus kategori | [KategoriController::destroy()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/KategoriController.php#L78-L96) + proteksi jika ada produk | ✅ Sesuai |

---

### 2.3 Kelola Pesanan & Pembayaran
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Menampilkan daftar pesanan (termasuk bukti bayar) | [PesananController::index()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/PesananController.php#L27-L38) → eager load `pembayaran` | ✅ Sesuai |
| Verifikasi pembayaran manual oleh admin | [PesananController::updatePayment()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/PesananController.php#L246-L284) → status_konfirmasi (0/1/2) | ✅ Sesuai |
| Mengubah status pesanan secara berurutan | [PesananController::updateStatus()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/PesananController.php#L44-L76) → menunggu→diproses→dikirim→selesai | ✅ Sesuai |
| Status: Menunggu → Diproses → Dikirim → Selesai | `STATUS_FLOW = ['menunggu', 'diproses', 'dikirim', 'selesai']` | ✅ Sesuai |
| Pembayaran harus diverifikasi sebelum diproses | Cek `status_konfirmasi === 1` sebelum ubah status | ✅ Sesuai |
| Notifikasi ke customer saat status berubah | `notifyCustomer()` dipanggil setiap perubahan status | ✅ Sesuai |

---

### 2.4 Kelola Data Pengguna
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Menampilkan daftar customer terdaftar | [UserController::userList()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/UserController.php#L49-L57) → filter `role = customer` | ✅ Sesuai |
| Tambah customer baru | [UserController::storeUser()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/UserController.php#L59-L73) | ✅ Sesuai |
| Edit data customer | [UserController::editUser()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/UserController.php#L75-L78) & [updateUser()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/UserController.php#L80-L98) | ✅ Sesuai |
| Hapus customer | [UserController::destroyUser()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/UserController.php#L100-L104) | ✅ Sesuai |

---

### 2.5 Kelola Promo
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Menampilkan daftar promo + opsi CRUD | [PromoController::index()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/PromoController.php#L13-L18) → view `admin.promos` | ✅ Sesuai |
| Tambah promo (kode, tipe diskon, nilai, kuota, tanggal) | [PromoController::store()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/PromoController.php#L20-L34) | ✅ Sesuai |
| Edit promo | [PromoController::update()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/PromoController.php#L36-L46) | ✅ Sesuai |
| Hapus promo | [PromoController::destroy()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/PromoController.php#L48-L61) + proteksi jika sudah dipakai | ✅ Sesuai |
| Notifikasi promo baru ke semua customer | [PromoController::notifyCustomers()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/PromoController.php#L80-L95) → broadcast ke semua `role = customer` | ✅ Sesuai |

---

## 3. Kebutuhan Fungsional Owner

### 3.1 Melihat Laporan Penjualan
| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Menampilkan laporan penjualan toko | [UserController::ownerDashboard()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/UserController.php#L109-L188) → view `owner.index` | ✅ Sesuai |
| Total pendapatan | `Pesanan::where('status_pesanan', 'selesai')->sum('total_bayar')` | ✅ Sesuai |
| Pendapatan bulan ini vs bulan lalu (persentase) | `$persenPendapatan` dihitung dari perbandingan kedua bulan | ✅ Sesuai |
| Jumlah pesanan per status | `groupBy('status_pesanan')->count()` | ✅ Sesuai |
| Grafik pendapatan bulanan | `$pendapatanBulanan` per bulan dalam tahun berjalan | ✅ Sesuai |
| Penjualan per kategori | `$penjualanKategori` — join detail_pesanan → produk → kategori | ✅ Sesuai |
| Produk terlaris (top 5) | `$produkTerlaris` — top 5 berdasarkan qty terjual | ✅ Sesuai |
| Rata-rata transaksi | `Pesanan::avg('total_bayar')` | ✅ Sesuai |
| Pesanan terbaru (10 terakhir) | `Pesanan::latest()->take(10)` | ✅ Sesuai |

> [!NOTE]
> Dashboard owner bahkan **melampaui** kebutuhan SKPL yang hanya menyebut "menampilkan laporan penjualan" — implementasinya sangat detail dan komprehensif.

---

## 4. Hak Akses & Autentikasi (Karakteristik Pengguna)

| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| **3 Role**: Customer, Admin, Owner | ENUM `['customer', 'admin', 'owner']` pada tabel `users` | ✅ Sesuai |
| **Customer**: Registrasi, login, katalog, keranjang, checkout, riwayat, profil | Middleware `role:customer` + semua route tersedia | ✅ Sesuai |
| **Admin**: Login, dashboard, kelola produk/stok/pesanan/pengguna | Middleware `role:admin` + prefix `/admin` | ✅ Sesuai |
| **Owner**: Login, pemantauan penjualan | Middleware `role:owner` + prefix `/owner` | ✅ Sesuai |
| Pemisahan akses berdasarkan role | [RoleMiddleware](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Middleware/RoleMiddleware.php) → redirect ke halaman role masing-masing | ✅ Sesuai |
| Admin/Owner tidak bisa beli barang | [CartController::isAdminOrOwner()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/CartController.php#L47-L54) → return 403 | ✅ Sesuai |

---

## 5. Batasan Sistem (Constraints)

| Batasan di SKPL | Implementasi | Status |
|---|---|---|
| Arsitektur berbasis website | Laravel MVC (web application) | ✅ Sesuai |
| Tidak ada integrasi payment gateway API | Pembayaran manual via upload bukti bayar + verifikasi admin | ✅ Sesuai |
| Password terenkripsi | `Hash::make()` + Eloquent cast `'password' => 'hashed'` | ✅ Sesuai |
| Responsif (desktop & mobile) | HTML + CSS responsive design | ✅ Sesuai |

---

## 6. Kebutuhan Data (19 Tabel)

| # | Tabel SKPL | Migration | Model | Status |
|---|-----------|-----------|-------|--------|
| 1 | users | ✅ | ✅ [User.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/User.php) | ✅ Sesuai |
| 2 | produk | ✅ | ✅ [Produk.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Produk.php) | ✅ Sesuai |
| 3 | keranjang | ✅ | ✅ [Keranjang.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Keranjang.php) | ✅ Sesuai |
| 4 | pesanan | ✅ | ✅ [Pesanan.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Pesanan.php) | ✅ Sesuai |
| 5 | detail_pesanan | ✅ | ✅ [DetailPesanan.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/DetailPesanan.php) | ✅ Sesuai |
| 6 | pembayaran | ✅ | ✅ [Pembayaran.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Pembayaran.php) | ✅ Sesuai |
| 7 | alamat_users | ✅ | ✅ [AlamatUser.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/AlamatUser.php) | ✅ Sesuai |
| 8 | provinsi | ✅ | ✅ [Provinsi.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Provinsi.php) | ✅ Sesuai |
| 9 | kota | ✅ | ✅ [Kota.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Kota.php) | ✅ Sesuai |
| 10 | kecamatan | ✅ | ✅ [Kecamatan.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Kecamatan.php) | ✅ Sesuai |
| 11 | desa | ✅ | ✅ [Desa.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Desa.php) | ✅ Sesuai |
| 12 | detail_keranjang | ✅ | ✅ [DetailKeranjang.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/DetailKeranjang.php) | ✅ Sesuai |
| 13 | dusun | ✅ | ✅ [Dusun.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Dusun.php) | ✅ Sesuai |
| 14 | kategori | ✅ | ✅ [Kategori.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Kategori.php) | ✅ Sesuai |
| 15 | ekspedisi | ✅ | ✅ [Ekspedisi.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Ekspedisi.php) | ✅ Sesuai |
| 16 | promo | ✅ | ✅ [Promo.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Promo.php) | ✅ Sesuai |
| 17 | ulasan | ✅ | ✅ [Ulasan.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Ulasan.php) | ✅ Sesuai |
| 18 | wishlist | ✅ | ✅ [Wishlist.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Wishlist.php) | ✅ Sesuai |
| 19 | notifikasi | ✅ | ✅ [Notifikasi.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Notifikasi.php) | ✅ Sesuai |

---

## 7. Lingkungan Operasi

| Kebutuhan SKPL | Implementasi | Status |
|---|---|---|
| Backend: PHP + Laravel | ✅ Laravel Framework | ✅ Sesuai |
| Database: MySQL | ✅ MySQL (via Laragon) | ✅ Sesuai |
| Frontend: HTML + CSS | ✅ Blade templates + CSS | ✅ Sesuai |
| Build tool | Vite (bonus, tidak di SKPL) | ✅ Sesuai |

---

## 8. Fitur Tambahan (Melebihi SKPL)

Beberapa fitur yang diimplementasikan **melebihi** kebutuhan minimum SKPL:

| Fitur Bonus | Keterangan |
|---|---|
| 🔐 **Lupa Password / Reset Password** | [AuthController::showForgotPassword()](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Http/Controllers/AuthController.php#L48-L51) — tidak disebutkan di SKPL |
| 🔔 **Sistem Notifikasi lengkap** | Notifikasi otomatis saat: promo baru, status pesanan berubah, pembayaran diverifikasi/ditolak |
| 📊 **Dashboard Admin sangat detail** | Jumlah user, pesanan per status, 7 hari terakhir, pesanan terbaru |
| 📈 **Dashboard Owner sangat komprehensif** | Pendapatan bulanan, perbandingan bulan, produk terlaris, penjualan per kategori, rata-rata transaksi |
| 🎟️ **Voucher/Promo di keranjang** | Apply/remove voucher langsung saat di keranjang belanja |
| 🚫 **Proteksi admin/owner beli barang** | Admin dan Owner tidak bisa menambahkan ke keranjang |
| 🛡️ **Proteksi hapus data berelasi** | Kategori dengan produk & promo dengan pesanan tidak bisa dihapus |
| 🔄 **Status pesanan berurutan** | Wajib maju satu langkah, tidak bisa loncat |

---

## ✅ Kesimpulan Keseluruhan

### SKPL vs Implementasi: **100% SESUAI + Bonus** ✅✅

| Aspek | Hasil |
|-------|-------|
| Kebutuhan Fungsional Customer (7 fitur) | ✅ 7/7 Terpenuhi |
| Kebutuhan Fungsional Admin (5 fitur) | ✅ 5/5 Terpenuhi |
| Kebutuhan Fungsional Owner (1 fitur) | ✅ 1/1 Terpenuhi (bahkan melampaui) |
| Kebutuhan Data (19 tabel) | ✅ 19/19 Terpenuhi |
| Hak Akses (3 role) | ✅ 3/3 Terpenuhi |
| Batasan Sistem | ✅ Semua terpenuhi |
| Lingkungan Operasi | ✅ Sesuai spesifikasi |

> [!TIP]
> **Semua kebutuhan fungsional dan non-fungsional yang tertulis di dokumen SKPL telah diimplementasikan dengan benar.** Bahkan, implementasi project ini memiliki beberapa fitur bonus yang melebihi kebutuhan minimum SKPL (seperti lupa password, notifikasi otomatis, dan dashboard analitik yang sangat detail).

> [!NOTE]
> Satu catatan kecil: Di SKPL tabel Pembayaran disebutkan ada field `status_konfirmasi`, namun di rancangan tabel SKPL bagian Pembayaran (Tabel 3.6) hanya ada 4 field (tanpa `status_konfirmasi`). Di migration Anda, field `status_konfirmasi` sudah ditambahkan — ini merupakan **perbaikan yang tepat** karena tanpa field ini, admin tidak bisa menandai pembayaran sudah diverifikasi atau belum.
