# Sistem Booking Kendaraan

[![Deployment Status](https://img.shields.io/badge/Deployment-Live%20on%20Vercel-success?style=for-the-badge&logo=vercel)](https://sistem-booking-kendaraan.vercel.app/bookings)
[![Laravel](https://img.shields.io/badge/Laravel-11%2F12-red?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue?style=for-the-badge&logo=php)](https://php.net)

Tautan Aplikasi Live:  
[https://sistem-booking-kendaraan.vercel.app/bookings](https://sistem-booking-kendaraan.vercel.app/bookings)

---

## Pratinjau Antarmuka

![Pratinjau Antarmuka Sistem Booking Kendaraan](preview.jpg)

---

## Deskripsi Proyek

Sistem Booking Kendaraan merupakan aplikasi berbasis web yang dirancang menggunakan framework Laravel untuk menyederhanakan proses manajemen operasional persewaan kendaraan roda dua (motor) dan roda empat (mobil). Sistem ini memfasilitasi pencatatan pemesanan, pemantauan status transaksi sewa secara langsung, serta visualisasi data performa usaha secara ringkas dan terstruktur.

Proyek ini disusun oleh Kelompok 5 sebagai bagian dari penyelesaian penugasan akhir program pelatihan dan kolaborasi pengembangan web.

---

## Fitur Utama

Sistem ini mencakup serangkaian fungsionalitas utama yang terintegrasi:

* **Dashboard Analitik dan Statistik**: Visualisasi metrik kinerja utama (Key Performance Indicators) dan grafik dinamis berbasis Chart.js yang memuat data tren pemesanan bulanan, peringkat kendaraan terfavorit, rasio kategori kendaraan, serta ringkasan status operasional.
* **Manajemen Data Pemesanan (CRUD)**:
  * **Pencatatan Booking Baru**: Formulir entri pemesanan yang dilengkapi validasi data terpadu dan tata letak grid dua kolom yang teroptimasi tanpa memerlukan pengguliran berlebih.
  * **Daftar Transaksi Terstruktur**: Penyajian data pemesanan secara rapi dengan indikator status berbasis visual vektor.
  * **Pembaruan Data & Status**: Fasilitas pengubahan rincian sewa dan pembaruan alur status pemesanan (Menunggu, Disetujui, Selesai, atau Batal).
  * **Penghapusan Data**: Mekanisme pembatalan dan penghapusan data transaksi yang tidak lagi relevan.
* **Filter Status Real-Time**: Fasilitas penyaringan instan untuk memilah transaksi berdasarkan tahapan status operasional tertentu.
* **Antarmuka Responsif**: Desain tata letak yang beradaptasi secara optimal pada seluruh resolusi layar (desktop, tablet, dan smartphone), didukung navigasi tetap (sticky header) dan menu seluler.

---

## Spesifikasi Teknis

| Komponen | Spesifikasi / Alat |
| :--- | :--- |
| **Backend Framework** | Laravel (PHP 8.2+) |
| **Frontend Framework & Styling** | HTML5, CSS3, Bootstrap 5, Bootstrap Icons |
| **Data Visualization** | Chart.js |
| **Database** | SQLite (Serverless Production) / MySQL (Pengembangan Lokal) |
| **Cloud Hosting & Deployment** | Vercel Serverless Architecture |
| **Version Control** | Git & GitHub |

---

## Struktur Skema Basis Data

Tabel data utama: **bookings**

| Nama Kolom | Tipe Data | Atribut | Deskripsi |
| :--- | :--- | :--- | :--- |
| `id` | BigInt | Primary Key, Auto Increment | Identifikasi unik setiap rekaman transaksi |
| `nama_pemesan` | Varchar(255) | Not Null | Nama lengkap penyewa kendaraan |
| `no_hp` | Varchar(50) | Not Null | Nomor telepon atau kontak seluler penyewa |
| `jenis_kendaraan` | Enum | 'mobil', 'motor' | Kategori jenis armada yang disewa |
| `nama_kendaraan` | Varchar(255) | Not Null | Nama atau tipe model spesifik kendaraan |
| `tanggal_sewa` | Date | Not Null | Tanggal dimulainya masa sewa |
| `lama_sewa` | Integer | Not Null | Durasi waktu sewa dalam satuan hari |
| `catatan` | Text | Nullable | Keterangan atau permintaan khusus dari penyewa |
| `status` | Enum | Default 'menunggu' | Status transaksi: 'menunggu', 'disetujui', 'selesai', 'batal' |

---

## Panduan Instalasi dan Menjalankan Proyek Lokal

Ikuti langkah-langkah berikut untuk mengoperasikan proyek di lingkungan lokal:

1. **Kloning Repositori:**
   ```bash
   git clone https://github.com/meganelfredaarkananta/Kelompok-5.git
   cd Kelompok-5
   ```

2. **Pengaturan Variabel Lingkungan:**
   ```bash
   cp .env.example .env
   ```

3. **Pemasangan Dependensi:**
   ```bash
   composer install
   npm install
   npm run build
   ```

4. **Inisialisasi Kunci Aplikasi dan Basis Data:**
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

5. **Menjalankan Server Pengembangan:**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui peramban web pada alamat `http://127.0.0.1:8000`.

---

## Tim Pengembang (Kelompok 5)

* Megan Elfreda Arkananta
* Ferdian
* Seluruh Anggota Tim Pengembang Kelompok 5
