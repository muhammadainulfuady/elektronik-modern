# 📋 Review Lengkap Project: Elektronik Modern (E-Commerce Laravel)

## 🏗️ Arsitektur Sistem

Project ini menggunakan **Laravel** dengan arsitektur MVC standar dan menggunakan **Vite** sebagai build tool.

### Struktur Utama

| Layer | Keterangan |
|-------|-----------|
| **Framework** | Laravel (PHP) |
| **Build Tool** | Vite |
| **Database** | MySQL (via Laragon) |
| **Auth** | Custom (bukan Breeze/Jetstream) dengan `AuthController` |
| **Role System** | ENUM (`customer`, `admin`, `owner`) dengan `RoleMiddleware` |
| **Timestamps** | Disabled (`$timestamps = false`) di semua model |

---

## 🗄️ Perbandingan Database: Diagram Relasi vs Migration

Berikut perbandingan field-per-field antara diagram [RELASI.drawio.png](file:///c:/laragon/www/elektronik-modern%20-%20Copy/RELASI.drawio.png) dengan file migration yang diimplementasikan.

### 1. Tabel `users`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_users INT (PK) | `$table->id('id_users')` | ✅ Sesuai |
| nama VARCHAR(50) | `$table->string('nama', 50)` | ✅ Sesuai |
| email VARCHAR(50) | `$table->string('email', 50)->unique()` | ✅ Sesuai |
| password VARCHAR(255) | `$table->string('password', 255)` | ✅ Sesuai |
| role ENUM(customer, admin, owner) | `$table->enum('role', ['customer', 'admin', 'owner'])->default('customer')` | ✅ Sesuai |

> [!NOTE]
> Migration menambahkan `rememberToken()` yang tidak ada di diagram — ini wajar karena merupakan kebutuhan internal Laravel untuk fitur "Remember Me".

---

### 2. Tabel `provinsi`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_provinsi INT (PK) | `$table->id('id_provinsi')` | ✅ Sesuai |
| nama_provinsi VARCHAR(50) | `$table->string('nama_provinsi', 50)` | ✅ Sesuai |

---

### 3. Tabel `kota`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_kota INT (PK) | `$table->id('id_kota')` | ✅ Sesuai |
| id_provinsi (FK) | `$table->unsignedBigInteger('id_provinsi')` + foreign key | ✅ Sesuai |
| nama_kota VARCHAR(50) | `$table->string('nama_kota', 50)` | ✅ Sesuai |

---

### 4. Tabel `kecamatan`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_kecamatan INT (PK) | `$table->id('id_kecamatan')` | ✅ Sesuai |
| id_kota INT (FK) | `$table->unsignedBigInteger('id_kota')` + foreign key | ✅ Sesuai |
| nama_kecamatan VARCHAR(50) | `$table->string('nama_kecamatan', 50)` | ✅ Sesuai |

---

### 5. Tabel `desa`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_desa INT (PK) | `$table->id('id_desa')` | ✅ Sesuai |
| id_kecamatan INT (FK) | `$table->unsignedBigInteger('id_kecamatan')` + foreign key | ✅ Sesuai |
| nama_desa VARCHAR(50) | `$table->string('nama_desa', 50)` | ✅ Sesuai |

---

### 6. Tabel `dusun`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_dusun INT (PK) | `$table->id('id_dusun')` | ✅ Sesuai |
| id_desa INT (FK) | `$table->unsignedBigInteger('id_desa')` + foreign key | ✅ Sesuai |
| nama_dusun VARCHAR(50) | `$table->string('nama_dusun', 50)` | ✅ Sesuai |

---

### 7. Tabel `alamat_user`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_alamat INT (PK) | `$table->id('id_alamat')` | ✅ Sesuai |
| id_users INT (FK) | `$table->unsignedBigInteger('id_users')` + FK | ✅ Sesuai |
| id_dusun INT (FK) | `$table->unsignedBigInteger('id_dusun')` + FK | ✅ Sesuai |
| label_alamat VARCHAR(50) | `$table->string('label_alamat', 50)` | ✅ Sesuai |
| nomor_telepon VARCHAR(20) | `$table->string('nomor_telepon', 20)` | ✅ Sesuai |
| detail_alamat VARCHAR(255) | `$table->string('detail_alamat', 255)` | ✅ Sesuai |
| is_utama INT | `$table->tinyInteger('is_utama')->default(0)` | ✅ Sesuai |

---

### 8. Tabel `kategori`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_kategori INT (PK) | `$table->id('id_kategori')` | ✅ Sesuai |
| nama_kategori VARCHAR(50) | `$table->string('nama_kategori', 50)` | ✅ Sesuai |
| ikon_kategori VARCHAR(150) | `$table->string('ikon_kategori', 150)` | ✅ Sesuai |

---

### 9. Tabel `produk`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_produk INT (PK) | `$table->id('id_produk')` | ✅ Sesuai |
| id_kategori INT (FK) | `$table->unsignedBigInteger('id_kategori')` + FK | ✅ Sesuai |
| gambar VARCHAR(50) | `$table->string('gambar', 50)` | ✅ Sesuai |
| nama_produk VARCHAR(50) | `$table->string('nama_produk', 50)` | ✅ Sesuai |
| deskripsi TEXT | `$table->text('deskripsi')` | ✅ Sesuai |
| harga INT | `$table->integer('harga')` | ✅ Sesuai |
| stok INT | `$table->integer('stok')` | ✅ Sesuai |

---

### 10. Tabel `keranjang`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_keranjang INT (PK) | `$table->id('id_keranjang')` | ✅ Sesuai |
| id_users INT (FK) | `$table->unsignedBigInteger('id_users')` + FK | ✅ Sesuai |

---

### 11. Tabel `detail_keranjang`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_detail_keranjang INT (PK) | `$table->id('id_detail_keranjang')` | ✅ Sesuai |
| id_produk INT (FK) | `$table->unsignedBigInteger('id_produk')` + FK | ✅ Sesuai |
| id_keranjang INT (FK) | `$table->unsignedBigInteger('id_keranjang')` + FK | ✅ Sesuai |
| qty INT | `$table->integer('qty')` | ✅ Sesuai |

---

### 12. Tabel `wishlist`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_wishlist INT (PK) | `$table->id('id_wishlist')` | ✅ Sesuai |
| id_users INT (FK) | `$table->unsignedBigInteger('id_users')` + FK | ✅ Sesuai |
| id_produk INT (FK) | `$table->unsignedBigInteger('id_produk')` + FK | ✅ Sesuai |

---

### 13. Tabel `ulasan`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_ulasan INT (PK) | `$table->id('id_ulasan')` | ✅ Sesuai |
| id_users INT (FK) | `$table->unsignedBigInteger('id_users')` + FK | ✅ Sesuai |
| id_produk INT (FK) | `$table->unsignedBigInteger('id_produk')` + FK | ✅ Sesuai |
| rating INT | `$table->integer('rating')` | ✅ Sesuai |
| komentar TEXT | `$table->text('komentar')` | ✅ Sesuai |

---

### 14. Tabel `notifikasi`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_notifikasi INT (PK) | `$table->id('id_notifikasi')` | ✅ Sesuai |
| id_users INT (FK) | `$table->unsignedBigInteger('id_users')` + FK | ✅ Sesuai |
| judul VARCHAR(150) | `$table->string('judul', 150)` | ✅ Sesuai |
| pesan TEXT | `$table->text('pesan')` | ✅ Sesuai |
| is_read INT | `$table->tinyInteger('is_read')->default(0)` | ✅ Sesuai |

---

### 15. Tabel `promo`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_promo INT (PK) | `$table->id('id_promo')` | ✅ Sesuai |
| kode_voucher VARCHAR(50) | `$table->string('kode_voucher', 50)` | ✅ Sesuai |
| tipe_diskon ENUM('persen','nominal') | `$table->enum('tipe_diskon', ['persen', 'nominal'])` | ✅ Sesuai |
| nilai_diskon INT | `$table->integer('nilai_diskon')` | ✅ Sesuai |
| kuota INT | `$table->integer('kuota')` | ✅ Sesuai |
| tanggal_mulai DATETIME | `$table->dateTime('tanggal_mulai')` | ✅ Sesuai |
| tanggal_berakhir DATETIME | `$table->dateTime('tanggal_berakhir')` | ✅ Sesuai |

---

### 16. Tabel `ekspedisi`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_ekspedisi INT (PK) | `$table->id('id_ekspedisi')` | ✅ Sesuai |
| nama_ekspedisi VARCHAR(100) | `$table->string('nama_ekspedisi', 100)` | ✅ Sesuai |
| biaya_pengiriman INT | `$table->integer('biaya_pengiriman')` | ✅ Sesuai |

---

### 17. Tabel `pesanan`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_pesanan INT (PK) | `$table->id('id_pesanan')` | ✅ Sesuai |
| id_users INT (FK) | `$table->unsignedBigInteger('id_users')` + FK | ✅ Sesuai |
| id_alamat INT (FK) | `$table->unsignedBigInteger('id_alamat')` + FK | ✅ Sesuai |
| id_promo INT (FK) | `$table->unsignedBigInteger('id_promo')` + FK | ✅ Sesuai |
| id_ekspedisi INT (FK) | `$table->unsignedBigInteger('id_ekspedisi')` + FK | ✅ Sesuai |
| tanggal_pesan DATETIME | `$table->dateTime('tanggal_pesan')` | ✅ Sesuai |
| total_bayar INT | `$table->integer('total_bayar')` | ✅ Sesuai |
| status_pesanan ENUM('Menunggu',...) | `$table->enum('status_pesanan', ['menunggu', 'diproses', 'dikirim', 'selesai'])` | ✅ Sesuai |
| subtotal INT | `$table->integer('subtotal')` | ✅ Sesuai |
| diskon INT | `$table->integer('diskon')` | ✅ Sesuai |
| no_resi VARCHAR(50) | `$table->string('no_resi', 50)` | ✅ Sesuai |
| ongkos_kirim INT | `$table->integer('ongkos_kirim')` | ✅ Sesuai |

---

### 18. Tabel `detail_pesanan`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_detail INT (PK) | `$table->id('id_detail')` | ✅ Sesuai |
| id_pesanan INT (FK) | `$table->unsignedBigInteger('id_pesanan')` + FK | ✅ Sesuai |
| id_produk INT (FK) | `$table->unsignedBigInteger('id_produk')` + FK | ✅ Sesuai |
| qty INT | `$table->integer('qty')` | ✅ Sesuai |
| harga_beli INT | `$table->integer('harga_beli')` | ✅ Sesuai |

---

### 19. Tabel `pembayaran`

| Field (Diagram) | Field (Migration) | Status |
|---|---|---|
| id_pembayaran INT (PK) | `$table->id('id_pembayaran')` | ✅ Sesuai |
| id_pesanan INT (FK) | `$table->unsignedBigInteger('id_pesanan')` + FK | ✅ Sesuai |
| metode_pembayaran VARCHAR(150) | `$table->string('metode_pembayaran', 150)` | ✅ Sesuai |
| bukti_bayar VARCHAR(150) | `$table->string('bukti_bayar', 150)` | ✅ Sesuai |
| status_konfirmasi INT | `$table->tinyInteger('status_konfirmasi')->default(0)` | ✅ Sesuai |

---

## 🔗 Relasi (Foreign Key) — Semua Sesuai Diagram

| Relasi | Diagram | Migration | Status |
|--------|---------|-----------|--------|
| kota → provinsi | ✅ | ✅ `id_provinsi` FK | ✅ |
| kecamatan → kota | ✅ | ✅ `id_kota` FK | ✅ |
| desa → kecamatan | ✅ | ✅ `id_kecamatan` FK | ✅ |
| dusun → desa | ✅ | ✅ `id_desa` FK | ✅ |
| alamat_user → users | ✅ | ✅ `id_users` FK | ✅ |
| alamat_user → dusun | ✅ | ✅ `id_dusun` FK | ✅ |
| produk → kategori | ✅ | ✅ `id_kategori` FK | ✅ |
| keranjang → users | ✅ | ✅ `id_users` FK | ✅ |
| detail_keranjang → produk | ✅ | ✅ `id_produk` FK | ✅ |
| detail_keranjang → keranjang | ✅ | ✅ `id_keranjang` FK | ✅ |
| wishlist → users | ✅ | ✅ `id_users` FK | ✅ |
| wishlist → produk | ✅ | ✅ `id_produk` FK | ✅ |
| ulasan → users | ✅ | ✅ `id_users` FK | ✅ |
| ulasan → produk | ✅ | ✅ `id_produk` FK | ✅ |
| notifikasi → users | ✅ | ✅ `id_users` FK | ✅ |
| pesanan → users | ✅ | ✅ `id_users` FK | ✅ |
| pesanan → alamat_user | ✅ | ✅ `id_alamat` FK | ✅ |
| pesanan → promo | ✅ | ✅ `id_promo` FK | ✅ |
| pesanan → ekspedisi | ✅ | ✅ `id_ekspedisi` FK | ✅ |
| detail_pesanan → pesanan | ✅ | ✅ `id_pesanan` FK | ✅ |
| detail_pesanan → produk | ✅ | ✅ `id_produk` FK | ✅ |
| pembayaran → pesanan | ✅ | ✅ `id_pesanan` FK | ✅ |

---

## 📊 Review Model Eloquent

Semua **19 model** sudah ada dan sesuai dengan 19 tabel pada diagram:

| Model | Primary Key | Relasi Didefinisikan | Status |
|-------|------------|---------------------|--------|
| [User.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/User.php) | `id_users` | alamatUsers, keranjang, pesanans, wishlists, ulasans, notifikasis | ✅ Lengkap |
| [Produk.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Produk.php) | `id_produk` | kategori, detailKeranjangs, detailPesanans, wishlists, ulasans | ✅ Lengkap |
| [Pesanan.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Pesanan.php) | `id_pesanan` | user, alamat, promo, ekspedisi, detailPesanans, pembayaran | ✅ Lengkap |
| [AlamatUser.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/AlamatUser.php) | `id_alamat` | — | ✅ |
| [Kategori.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Kategori.php) | `id_kategori` | — | ✅ |
| [Keranjang.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Keranjang.php) | `id_keranjang` | — | ✅ |
| [DetailKeranjang.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/DetailKeranjang.php) | `id_detail_keranjang` | — | ✅ |
| [DetailPesanan.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/DetailPesanan.php) | `id_detail` | — | ✅ |
| [Pembayaran.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Pembayaran.php) | `id_pembayaran` | — | ✅ |
| [Promo.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Promo.php) | `id_promo` | — | ✅ |
| [Ekspedisi.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Ekspedisi.php) | `id_ekspedisi` | — | ✅ |
| [Wishlist.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Wishlist.php) | `id_wishlist` | — | ✅ |
| [Ulasan.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Ulasan.php) | `id_ulasan` | — | ✅ |
| [Notifikasi.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Notifikasi.php) | `id_notifikasi` | — | ✅ |
| [Provinsi.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Provinsi.php) | `id_provinsi` | — | ✅ |
| [Kota.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Kota.php) | `id_kota` | — | ✅ |
| [Kecamatan.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Kecamatan.php) | `id_kecamatan` | — | ✅ |
| [Desa.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Desa.php) | `id_desa` | — | ✅ |
| [Dusun.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/app/Models/Dusun.php) | `id_dusun` | — | ✅ |

---

## 🛣️ Review Routes ([web.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/routes/web.php))

### Struktur Route berdasarkan Role

| Grup | Middleware | Prefix | Fitur |
|------|-----------|--------|-------|
| **Public** | — | `/` | Homepage, katalog produk, detail produk, cart count |
| **Guest** | `guest` | `/login`, `/register`, `/forgot-password`, `/reset-password` | Auth (login, register, lupa password) |
| **Customer** | `auth`, `role:customer` | `/cart`, `/profile`, `/my-orders`, `/checkout`, `/notifications` | Cart CRUD, profile, alamat, pesanan, notifikasi |
| **Admin** | `auth`, `role:admin` | `/admin/*` | Dashboard, kelola produk/kategori/promo/pesanan/user |
| **Owner** | `auth`, `role:owner` | `/owner/` | Dashboard owner |

---

## 🖥️ Review Views (Blade Templates)

| Folder | File | Keterangan |
|--------|------|-----------|
| `views/` | [index.blade.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/resources/views/index.blade.php) | Homepage publik |
| `views/auth/` | Login, Register, Forgot/Reset Password | Halaman auth |
| `views/admin/` | index, products, products-edit, categories, promos, orders, users, users-edit | Panel admin lengkap |
| `views/customer/` | profile, checkout, orders | Halaman customer |
| `views/owner/` | [index.blade.php](file:///c:/laragon/www/elektronik-modern%20-%20Copy/resources/views/owner/index.blade.php) | Dashboard owner |
| `views/cart/` | Halaman keranjang | Cart view |
| `views/products/` | Halaman detail produk | Product detail |
| `views/layouts/` | Layout utama | Template layout |
| `views/partials/` | Komponen partial | Navbar, footer, dll |

---

## 🌱 Review Seeders

Semua **20 seeder** sudah tersedia, sesuai dengan setiap tabel:

| Seeder | Tabel Target |
|--------|-------------|
| UserSeeder | users |
| ProvinsiSeeder | provinsis |
| KotaSeeder | kotas |
| KecamatanSeeder | kecamatans |
| DesaSeeder | desas |
| DusunSeeder | dusuns |
| AlamatUserSeeder | alamat_users |
| KategoriSeeder | kategoris |
| ProdukSeeder | produks |
| KeranjangSeeder | keranjangs |
| DetailKeranjangSeeder | detail_keranjangs |
| WishlistSeeder | wishlists |
| UlasanSeeder | ulasans |
| NotifikasiSeeder | notifikasis |
| EkspedisiSeeder | ekspedisis |
| PromoSeeder | promos |
| PesananSeeder | pesanans |
| DetailPesananSeeder | detail_pesanans |
| PembayaranSeeder | pembayarans |
| DatabaseSeeder | Orchestrator (memanggil semua seeder) |

---

## ✅ Kesimpulan Keseluruhan

### Database ↔ Diagram Relasi: **100% SESUAI** ✅

Semua **19 tabel** pada diagram relasi telah diimplementasikan dengan benar di migration Laravel:
- ✅ Semua **primary key** sesuai
- ✅ Semua **field nama, tipe data, dan panjang** sesuai
- ✅ Semua **22 foreign key** telah didefinisikan dengan benar beserta `onDelete('cascade')`
- ✅ Semua **ENUM** values sesuai
- ✅ Hirarki wilayah (Provinsi → Kota → Kecamatan → Desa → Dusun) terhubung dengan baik

### Sistem Keseluruhan: **Terstruktur Baik** ✅

- ✅ **19 Model** — lengkap sesuai tabel, relasi Eloquent sudah didefinisikan di model-model utama
- ✅ **22 Controller** — mencakup semua entitas + auth + cart
- ✅ **1 Middleware** — `RoleMiddleware` untuk akses kontrol berbasis role
- ✅ **20 Seeder** — data dummy tersedia untuk semua tabel
- ✅ **Routes** — terorganisir rapi berdasarkan role (public, guest, customer, admin, owner)
- ✅ **Views** — tersedia untuk semua halaman (admin panel, customer, owner, auth, public)

> [!TIP]
> Project ini sudah sangat baik secara struktural. Diagram relasi database dan implementasi migration-nya **sepenuhnya sinkron**.
