<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  
  <br>
  
  <h1>🛒 Elektronik Modern</h1>
  <p>
    <strong>Platform E-Commerce Modern, Responsif, dan Cepat.</strong><br>
    <em>Dibangun dengan penuh cinta oleh RPL Team 2</em>
  </p>
</div>

---

## 📖 Tentang Aplikasi

**Elektronik Modern** adalah aplikasi web E-Commerce berbasis Laravel yang dirancang untuk memberikan pengalaman berbelanja barang elektronik terbaik bagi pelanggan, sekaligus memberikan kemudahan pengelolaan toko bagi Admin dan Pemilik (*Owner*). 

Sistem ini mendukung pengiriman ke seluruh wilayah di Indonesia berkat integrasi langsung dengan **API Wilayah Indonesia** (Provinsi, Kota, Kecamatan, hingga lebih dari 83.000 Desa) yang disimpan dengan cerdas (*JSON Caching*) agar website tetap melesat cepat.

## 🚀 Fitur Utama

Sistem ini memiliki pembagian peran (*role*) yang spesifik:

### 🛍️ Customer (Pelanggan)
- Registrasi dan Autentikasi yang aman.
- Pencarian dan Filter Katalog Produk.
- Manajemen Profil & Multi-Alamat Pengiriman (API Wilayah Real-time).
- *Shopping Cart* (Keranjang Belanja) & *Checkout* Pesanan.
- Unggah *Bukti Pembayaran* secara langsung.
- Cek Riwayat dan Status Pesanan.

### 💼 Admin (Pengelola)
- *Dashboard* Manajemen Operasional.
- Kelola Katalog (Produk & Kategori).
- Verifikasi dan Proses Pesanan (Menunggu ➔ Diproses ➔ Dikirim ➔ Selesai).
- Verifikasi Bukti Pembayaran.
- Kelola Data Pengguna (Customer).
- Kelola Data Promosi & Diskon.

### 👑 Owner (Pemilik)
- *Dashboard* Eksekutif.
- Cetak Laporan Penjualan (Harian, Bulanan, Tahunan).
- Unduh Laporan format PDF.

---

## 🛠️ Teknologi yang Digunakan

- **Framework:** Laravel (PHP)
- **Database:** MySQL
- **Styling/Frontend:** Blade Template, CSS Modern
- **API Eksternal:** TheCloudAlert Wilayah API
- **Tooling:** Artisan Console, Composer, Git

---

## ⚙️ Panduan Instalasi (Setup Guide)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di komputer lokal Anda (menggunakan XAMPP, Laragon, atau Valet):

### 1. Kloning Repository
```bash
git clone https://github.com/muhammadainulfuady/elektronik-modern.git
cd elektronik-modern
```

### 2. Install Dependensi
```bash
composer install
npm install
npm run build
```

### 3. Konfigurasi Lingkungan (.env)
Salin file konfigurasi bawaan dan hasilkan kunci aplikasi (App Key):
```bash
cp .env.example .env
php artisan key:generate
```
*(Pastikan Anda telah membuat database kosong di MySQL dengan nama `elektronik-modern` atau sesuai pengaturan di `.env` Anda).*

### 4. Unduh Data Wilayah (Wajib!) 🇮🇩
Sistem ini menggunakan data wilayah asli seluruh Indonesia. Jalankan *custom command* berikut untuk menarik data dari API dan menyimpannya sebagai *cache* lokal:
```bash
php artisan fetch:wilayah
```
*(Catatan: Proses ini mengunduh ~90.000 data, harap bersabar hingga proses selesai 100%).*

### 5. Migrasi dan Seeding Database
Setelah *fetch* selesai, masukkan struktur tabel dan data *dummy* (termasuk super admin):
```bash
php artisan migrate:fresh --seed
```

### 6. Jalankan Server Lokal
```bash
php artisan serve
```
Akses aplikasi melalui browser di `http://127.0.0.1:8000`.

---

## 🤝 Kontributor (RPL Team 2)

Proyek ini dibangun dan didesain oleh:
- **Muhammad Ainul Fuady**
- *(...dan anggota tim RPL 2 lainnya)*

*Terima kasih telah menggunakan Elektronik Modern! Selamat berbelanja.* ✨
