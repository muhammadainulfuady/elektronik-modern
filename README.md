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

- **Framework:** Laravel 13 (PHP 8.4)
- **Database:** MySQL
- **Styling/Frontend:** Blade Template, Tailwind CSS 4, Vite
- **PDF Report:** DomPDF (barryvdh/laravel-dompdf)
- **API Eksternal:** TheCloudAlert Wilayah API
- **Tooling:** Artisan Console, Composer, NPM, Git

---

## 📋 Prasyarat — Apa Saja yang Perlu Di-install Sebelumnya?

> [!IMPORTANT]
> Sebelum mulai, pastikan komputer Anda sudah memiliki software berikut. Jika belum punya, ikuti panduan instalasi di bawah.

| No | Software | Versi Minimum | Fungsi | Link Download |
|----|----------|--------------|--------|---------------|
| 1 | **Laragon** (Direkomendasikan) | Terbaru | Menyediakan PHP, MySQL, dan Apache sekaligus dalam satu paket | [laragon.org](https://laragon.org/download/) |
| 2 | **PHP** | 8.4+ | Bahasa pemrograman utama Laravel | *Sudah termasuk di Laragon* |
| 3 | **MySQL** | 5.7+ | Database untuk menyimpan data | *Sudah termasuk di Laragon* |
| 4 | **Composer** | 2.x | Manajer paket/dependensi PHP | *Sudah termasuk di Laragon* |
| 5 | **Node.js** | 18+ | Untuk menjalankan NPM (build CSS/JS) | [nodejs.org](https://nodejs.org/) |
| 6 | **Git** | Terbaru | Untuk mengunduh kode dari GitHub | [git-scm.com](https://git-scm.com/) |

### 🪟 Khusus Pengguna Windows — Mengapa Laragon?

Kami **sangat merekomendasikan Laragon** karena:
- ✅ Sudah **termasuk PHP, MySQL, Composer, dan Apache** — tidak perlu install satu per satu.
- ✅ Sangat **ringan** dan **mudah digunakan** (tinggal klik "Start All").
- ✅ Sudah otomatis menambahkan `php` dan `composer` ke PATH Windows (bisa langsung dipakai di terminal).

> [!TIP]
> **Alternatif lain:** Anda juga bisa menggunakan **XAMPP** (dari [apachefriends.org](https://www.apachefriends.org/)), namun Anda perlu install Composer secara terpisah dan mengatur PATH secara manual.

### ✅ Cara Cek Apakah Semua Sudah Terinstall

Buka **Command Prompt** (tekan `Win + R`, ketik `cmd`, tekan Enter) atau **Terminal** di Laragon, lalu ketik perintah berikut satu per satu:

```bash
php -v
```
> Harus muncul versi PHP (minimal 8.4). Contoh: `PHP 8.4.x`

```bash
composer -V
```
> Harus muncul versi Composer. Contoh: `Composer version 2.x.x`

```bash
node -v
```
> Harus muncul versi Node.js (minimal 18). Contoh: `v18.x.x` atau lebih tinggi

```bash
npm -v
```
> Harus muncul versi NPM. Contoh: `9.x.x` atau lebih tinggi

```bash
git --version
```
> Harus muncul versi Git. Contoh: `git version 2.x.x`

> [!WARNING]
> Jika salah satu perintah di atas menghasilkan **error** seperti `'php' is not recognized...`, artinya software tersebut belum terinstall atau belum ditambahkan ke PATH. Silakan install terlebih dahulu sebelum lanjut.

---

## ⚙️ Panduan Instalasi — Langkah demi Langkah

> [!NOTE]
> Panduan ini ditulis **sespesifik mungkin** agar orang yang baru pertama kali menggunakan Laravel pun bisa mengikutinya. Setiap perintah disertai **penjelasan** apa yang dilakukan.

---

### 📥 Langkah 1 — Unduh Kode dari GitHub

Buka **Terminal** (di Laragon: klik kanan icon tray → `Terminal`), lalu ketik:

```bash
cd C:\laragon\www
```
> 📌 *Ini memindahkan lokasi kerja Anda ke folder `www` milik Laragon, tempat semua proyek web disimpan.*

```bash
git clone https://github.com/muhammadainulfuady/elektronik-modern.git
```
> 📌 *Ini mengunduh seluruh kode proyek dari GitHub ke folder `C:\laragon\www\elektronik-modern`.*

```bash
cd elektronik-modern
```
> 📌 *Ini masuk ke dalam folder proyek yang baru saja diunduh.*

---

### 📦 Langkah 2 — Install Semua Dependensi (Library)

Jalankan perintah berikut **satu per satu** dan tunggu masing-masing selesai:

```bash
composer install
```
> 📌 *Mengunduh semua library PHP yang dibutuhkan Laravel (akan membuat folder `vendor`).*
> ⏱️ Proses ini membutuhkan waktu **1-5 menit** tergantung kecepatan internet.

```bash
npm install
```
> 📌 *Mengunduh semua library JavaScript/CSS yang dibutuhkan (Tailwind CSS, Vite, dll — akan membuat folder `node_modules`).*

```bash
npm run build
```
> 📌 *Mengompilasi file CSS dan JavaScript agar bisa digunakan oleh website.*

---

### 🔧 Langkah 3 — Konfigurasi File `.env` (Pengaturan Aplikasi)

File `.env` adalah file konfigurasi utama yang berisi pengaturan database, URL, dan lain-lain.

**3a.** Salin template konfigurasi:
```bash
cp .env.example .env
```
> 📌 *Menyalin file contoh menjadi file konfigurasi aktif.*

> [!NOTE]
> **Jika perintah `cp` tidak dikenali** (terjadi di Command Prompt Windows biasa), gunakan alternatif ini:
> ```bash
> copy .env.example .env
> ```

**3b.** Buat kunci keamanan aplikasi:
```bash
php artisan key:generate
```
> 📌 *Menghasilkan kunci enkripsi unik untuk keamanan aplikasi Anda. Kunci ini otomatis ditulis ke file `.env`.*

**3c.** Buka dan edit file `.env` menggunakan **Notepad** atau editor teks lainnya:

```
notepad .env
```

Cari bagian berikut dan **sesuaikan dengan pengaturan MySQL Anda**:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elektronikmodern
DB_USERNAME=root
DB_PASSWORD=
```

| Pengaturan | Penjelasan | Nilai Default |
|-----------|-----------|---------------|
| `DB_DATABASE` | Nama database yang akan digunakan | `elektronikmodern` |
| `DB_USERNAME` | Username MySQL | `root` (bawaan Laragon/XAMPP) |
| `DB_PASSWORD` | Password MySQL | *(kosong — bawaan Laragon/XAMPP)* |

> [!TIP]
> Jika Anda menggunakan **Laragon** atau **XAMPP** dengan pengaturan default, biasanya **tidak perlu mengubah apa-apa**. Cukup pastikan nama database-nya sudah benar.

---

### 🗄️ Langkah 4 — Buat Database di MySQL

Anda perlu membuat database kosong bernama `elektronikmodern` terlebih dahulu.

#### Cara A — Lewat Terminal (Cepat):
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS elektronikmodern;"
```
> 📌 *Membuat database baru bernama `elektronikmodern` jika belum ada.*

#### Cara B — Lewat phpMyAdmin (Lebih Mudah untuk Pemula):
1. Buka browser, akses **http://localhost/phpmyadmin**
2. Klik tab **"Databases"** (atau "Basis Data") di bagian atas
3. Di kolom **"Create database"**, ketik: `elektronikmodern`
4. Klik tombol **"Create"**

> [!IMPORTANT]
> Pastikan **MySQL sudah berjalan** sebelum langkah ini! Di Laragon, klik **"Start All"**. Di XAMPP, nyalakan modul **Apache** dan **MySQL**.

---

### 🇮🇩 Langkah 5 — Unduh Data Wilayah Indonesia (Wajib!)

Sistem ini menggunakan data wilayah asli seluruh Indonesia (Provinsi, Kota, Kecamatan, Desa). Data ini perlu diunduh terlebih dahulu:

```bash
php artisan fetch:wilayah
```
> 📌 *Mengunduh ~90.000 data wilayah dari API dan menyimpannya sebagai cache lokal (file JSON).*

> [!WARNING]
> - Proses ini bisa memakan waktu **5-15 menit** tergantung kecepatan internet.
> - **Jangan tutup terminal** sampai muncul pesan bahwa proses selesai 100%.
> - Pastikan koneksi internet Anda **stabil**.

---

### 🏗️ Langkah 6 — Buat Tabel & Isi Data Awal ke Database

```bash
php artisan migrate:fresh --seed
```
> 📌 *Perintah ini melakukan 2 hal sekaligus:*
> 1. **`migrate:fresh`** — Membuat semua tabel yang dibutuhkan di database.
> 2. **`--seed`** — Mengisi tabel dengan data awal (contoh produk, kategori, dan akun pengguna).

---

### 🚀 Langkah 7 — Jalankan Website!

```bash
php artisan serve
```

Jika berhasil, akan muncul pesan seperti:
```
INFO  Server running on [http://127.0.0.1:8000].
```

**🎉 Buka browser Anda dan akses: [http://127.0.0.1:8000](http://127.0.0.1:8000)**

> [!TIP]
> Untuk menghentikan server, tekan `Ctrl + C` di terminal.

---

## 🔐 Akun Login Bawaan (Setelah Seeding)

Setelah menjalankan `migrate:fresh --seed`, Anda bisa login menggunakan akun-akun berikut:

| Role | Nama | Email | Password |
|------|------|-------|----------|
| 🛍️ **Customer** | ainulfuady | `fuady@gmail.com` | `password` |
| 🛍️ **Customer** | fajar | `fajar@gmail.com` | `password` |
| 💼 **Admin** | angga | `angga@gmail.com` | `password` |
| 👑 **Owner** | joni | `joni@gmail.com` | `password` |
| 👑 **Owner** | labib | `labib@gmail.com` | `password` |

> [!CAUTION]
> Akun-akun di atas **hanya untuk pengembangan/testing**. Jangan gunakan password ini di lingkungan produksi!

---

## 🔄 Perintah Ringkas (Untuk yang Sudah Berpengalaman)

Jika Anda sudah familiar dengan Laravel, berikut ringkasan semua perintah:

```bash
git clone https://github.com/muhammadainulfuady/elektronik-modern.git
cd elektronik-modern
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
# Buat database 'elektronikmodern' di MySQL terlebih dahulu
php artisan fetch:wilayah
php artisan migrate:fresh --seed
php artisan serve
```

---

## ❓ Troubleshooting — Solusi Masalah Umum

<details>
<summary><strong>❌ Error: <code>'php' is not recognized as an internal or external command</code></strong></summary>

**Penyebab:** PHP belum di-install atau belum ditambahkan ke PATH Windows.

**Solusi:**
- Jika menggunakan **Laragon**: Buka terminal **lewat Laragon** (klik kanan icon → Terminal), bukan lewat CMD biasa.
- Jika menggunakan **XAMPP**: Tambahkan path PHP ke System Environment Variables:
  1. Buka **Settings** → cari **"Environment Variables"**
  2. Di bagian **System Variables**, cari **"Path"** → klik **Edit**
  3. Tambahkan: `C:\xampp\php`
  4. Klik OK, lalu **buka CMD baru**
</details>

<details>
<summary><strong>❌ Error: <code>SQLSTATE[HY000] [1049] Unknown database 'elektronikmodern'</code></strong></summary>

**Penyebab:** Database belum dibuat.

**Solusi:** Buat database terlebih dahulu (lihat **Langkah 4** di atas).
</details>

<details>
<summary><strong>❌ Error: <code>SQLSTATE[HY000] [2002] Connection refused</code></strong></summary>

**Penyebab:** MySQL belum berjalan.

**Solusi:**
- **Laragon**: Klik **"Start All"**
- **XAMPP**: Buka XAMPP Control Panel → klik **Start** di baris MySQL
</details>

<details>
<summary><strong>❌ Error saat <code>npm install</code>: <code>'npm' is not recognized</code></strong></summary>

**Penyebab:** Node.js belum di-install.

**Solusi:** Download dan install Node.js dari [nodejs.org](https://nodejs.org/) (pilih versi **LTS**). Setelah install, **buka terminal baru** dan coba lagi.
</details>

<details>
<summary><strong>❌ Error saat <code>composer install</code>: Versi PHP tidak kompatibel</strong></summary>

**Penyebab:** Versi PHP Anda di bawah 8.4.

**Solusi:** Update Laragon/XAMPP ke versi terbaru, atau download PHP 8.4+ secara manual.
</details>

<details>
<summary><strong>❌ Halaman web muncul tapi tampilannya berantakan (tidak ada CSS)</strong></summary>

**Penyebab:** Anda belum menjalankan `npm run build`.

**Solusi:**
```bash
npm install
npm run build
```
</details>

<details>
<summary><strong>❌ <code>php artisan fetch:wilayah</code> gagal atau timeout</strong></summary>

**Penyebab:** Koneksi internet tidak stabil atau API sedang down.

**Solusi:**
- Pastikan internet Anda **stabil**
- Coba jalankan ulang perintah yang sama
- Jika masih gagal, coba lagi di waktu yang berbeda
</details>

---

## 📁 Struktur Folder Penting

```
elektronik-modern/
├── app/                    # Logika aplikasi (Model, Controller, dll)
├── config/                 # File konfigurasi aplikasi
├── database/
│   ├── migrations/         # File pembuatan tabel database
│   └── seeders/            # File data awal (contoh produk, user, dll)
├── public/                 # File yang bisa diakses publik (gambar, CSS, JS)
├── resources/
│   └── views/              # File tampilan halaman (Blade template)
├── routes/                 # Definisi URL/halaman aplikasi
├── storage/                # File upload, cache, dan log
├── .env                    # ⚠️ File konfigurasi (JANGAN di-share!)
├── composer.json           # Daftar library PHP
└── package.json            # Daftar library JavaScript/CSS
```

---

## 🤝 Kontributor (RPL Team 2)

Proyek ini dibangun dan didesain oleh:
- **Muhammad Ainul Fuady**
- *(...dan anggota tim RPL 2 lainnya)*

---

*Terima kasih telah menggunakan Elektronik Modern! Selamat berbelanja.* ✨
