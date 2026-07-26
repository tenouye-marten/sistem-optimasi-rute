# 🚛 SIMPAS DLH - Sistem Optimasi Rute Pengangkutan Sampah

Sistem Informasi Optimasi Rute Pengangkutan Sampah berbasis web untuk **Dinas Lingkungan Hidup (DLH) Kabupaten Jayapura**. Aplikasi ini dirancang untuk mengoptimalkan rute perjalanan armada pengangkut sampah dari titik-titik TPS (Tempat Penampungan Sementara) menuju TPA (Tempat Pemrosesan Akhir) menggunakan metode **Nearest Neighbor**.

---

## 🚀 Fitur Utama

- **Optimasi Rute (Nearest Neighbor)**: Menghitung dan memberikan rekomendasi rute terpendek dan paling efisien untuk armada pengangkut sampah.
- **Manajemen Data TPS & TPA**: Pengelolaan koordinat lokasi, kapasitas, dan status TPS di wilayah Kabupaten Jayapura.
- **Multi-Role Access**:
  - **Admin**: Mengelola data master TPS, TPA, armada driver, serta penjadwalan rute.
  - **Kepala DLH**: Memantau grafik pengangkutan sampah dan laporan statistik operasional.
  - **Driver**: Melihat instruksi rute pengangkutan harian dan memperbarui status tugas.
- **Laporan & Cetak PDF**: Export laporan rute dan pengangkutan dalam format PDF & Print.

---

## 🛠️ Teknologi yang Digunakan

- **Framework Backend**: Laravel 12 (PHP >= 8.2)
- **Frontend & Styling**: Blade, Tailwind CSS, Alpine.js, Vite
- **Peta & Visualisasi Rute**: Leaflet.js / OpenStreetMap
- **Database**: MySQL / MariaDB
- **Icons & Typography**: FontAwesome 6, Plus Jakarta Sans

---

## 📋 Persyaratan Sistem

Pastikan perangkat Anda telah terpasang software berikut:

- **PHP**: versi 8.2.x atau lebih baru
- **Composer**: versi 2.x
- **Node.js**: versi 18.x atau lebih baru (termasuk NPM)
- **Database Server**: MySQL (XAMPP / Laragon / Native MySQL)
- **Git**

---

## ⚙️ Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project di lingkungan lokal:

### 1. Clone Repository
```bash
git clone https://github.com/tenouye-marten/sistem-optimasi-rute.git
cd sistem-optimasi-rute
```

### 2. Install Dependency
Install paket dependency PHP (Composer) dan JavaScript (NPM):
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file contoh `.env.example` menjadi `.env`:

*Windows (Command Prompt / PowerShell):*
```bash
copy .env.example .env
```

*Linux / macOS / Git Bash:*
```bash
cp .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Konfigurasi Database
Buka aplikasi pengelola database (seperti **phpMyAdmin** atau **DBeaver**), lalu buat sebuah database kosong baru, contohnya: `sistem_optimasi_rute`.

Buka file `.env` di text editor Anda dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_optimasi_rute
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan Migration dan Seeder Data
Jalankan migrasi tabel beserta seeder untuk mengisi data awal (pengguna, TPS, TPA, dll):
```bash
php artisan migrate:fresh --seed
```

### 7. Buat Storage Link
```bash
php artisan storage:link
```

### 8. Jalankan Aplikasi
Buka dua jendela terminal terpisah:

**Terminal 1 (Vite Asset Bundler):**
```bash
npm run dev
```

**Terminal 2 (Laravel Development Server):**
```bash
php artisan serve
```

Aplikasi siap diakses melalui browser pada alamat:
`http://127.0.0.1:8000`

---

## 🔑 Akun Default (Login Seeder)

Setelah menjalankan `php artisan migrate:fresh --seed`, Anda dapat menguji login menggunakan akun bawaan berikut:

| Peran (Role) | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@dlh.com` | `password` |
| **Kepala DLH** | `kepala@dlh.com` | `password` |
| **Driver** | `driver1@dlh.com` | `password` |

---

## ⚡ Ringkasan Perintah Cepat (Quick Setup)

```bash
git clone https://github.com/tenouye-marten/sistem-optimasi-rute.git
cd sistem-optimasi-rute
composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
npm run dev
# Pada terminal lain:
php artisan serve
```

---

## 📜 Lisensi & Hak Cipta

© 2026 **Sistem Optimasi Rute Pengangkutan Sampah (SIMPAS)**  
Dinas Lingkungan Hidup Kabupaten Jayapura.
