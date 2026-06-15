# 🛒 Elektronik Modern

**Platform E-Commerce Elektronik** yang dibangun menggunakan Laravel 13, Tailwind CSS 4, dan integrasi API Wilayah Indonesia.

---

## 🚀 Langkah Instalasi (Cepat)

Pastikan Anda sudah menginstall **Laragon/XAMPP**, **Node.js**, dan **Composer**.

1. **Clone & Masuk ke Folder:**
   ```bash
   git clone https://github.com/muhammadainulfuady/elektronik-modern.git
   cd elektronik-modern
   ```

2. **Install Library (PHP & JS):**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database:**
   - Buat database baru bernama `elektronik_modern` di phpMyAdmin/MySQL.
   - Buka file `.env`, sesuaikan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`.

5. **Migrasi & Data Awal:**
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

6. **Ambil Data Wilayah (PENTING):**
   *Data ini dibutuhkan untuk fitur alamat pengiriman.*
   ```bash
   php artisan fetch:wilayah
   ```

7. **Jalankan Aplikasi:**
   ```bash
   npm run build
   php artisan serve
   ```
   Akses di: `http://127.0.0.1:8000`

---

## 🔐 Akun Login Testing

Setelah menjalankan `--seed`, gunakan akun berikut untuk mencoba fitur:

| Role | Email | Password |
|------|-------|----------|
| 🛍️ **Customer** | `fuady@gmail.com` | `password` |
| 💼 **Admin** | `angga@gmail.com` | `password` |
| 👑 **Owner** | `joni@gmail.com` | `password` |

---

## 🛠️ Fitur Utama
- **Multi-Role:** Customer, Admin, dan Owner.
- **Checkout & Payment:** Sistem keranjang, checkout, dan upload bukti bayar.
- **API Wilayah:** Pilihan Provinsi, Kota, hingga Desa secara real-time.
- **Laporan:** Owner dapat mencetak laporan penjualan dalam format PDF.

---

## ❓ Masalah Umum (Troubleshooting)

- **Tampilan Berantakan?** Pastikan sudah menjalankan `npm install` dan `npm run build`.
- **Gambar Tidak Muncul?** Pastikan sudah menjalankan `php artisan storage:link`.
- **Error Database?** Pastikan nama database di `.env` sama dengan yang dibuat di MySQL.
- **Fetch Wilayah Gagal?** Pastikan koneksi internet aktif karena mengambil data dari API eksternal.

---

## 📁 Struktur Folder
- `app/Http/Controllers`: Logika utama aplikasi.
- `resources/views`: Tampilan (Blade templates).
- `routes/web.php`: Daftar URL aplikasi.
- `database/seeders`: Pengaturan data awal/testing.

---

**RPL Team 2** - 2026
