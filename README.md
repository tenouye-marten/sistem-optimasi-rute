# 🚛 Sistem Optimasi Rute Pengangkutan Sampah
## Menggunakan Metode Nearest Neighbor

Aplikasi berbasis web untuk mengoptimalkan rute pengangkutan sampah pada Dinas Lingkungan Hidup Kabupaten Jayapura menggunakan Laravel 12.

---

# Persyaratan Sistem

Pastikan perangkat telah terpasang:

- PHP 8.2.x
- Composer
- Node.js (LTS)
- Git Bash
- XAMPP (Apache & MySQL)
- Laravel 12

---

# Cara Instalasi

## 1. Clone Repository

Buka Git Bash kemudian jalankan:

```bash
git clone https://github.com/tenouye-marten/sistem-optimasi-rute.git
```

Contoh

```bash
git clone https://github.com/tenouye-marten/sistem-optimasi-rute.git
```

Masuk ke folder project

```bash
cd sirps
```

---

## 2. Install Dependency

Install package Laravel

```bash
composer install
```

Install package Node

```bash
npm install
```

---

## 3. Copy File Environment

Windows

```bash
copy .env.example .env
```

atau

```bash
cp .env.example .env
```

---

## 4. Generate Application Key

```bash
php artisan key:generate
```

---

# Konfigurasi Database

Buka **XAMPP** kemudian jalankan:

- Apache
- MySQL

Selanjutnya buka **phpMyAdmin**

Buat database baru, misalnya

```
sirps
```

> Cukup buat database kosong, tidak perlu membuat tabel.

---

## 5. Atur File .env

Buka file

```
.env
```

Kemudian ubah konfigurasi database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sirps
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan jika username atau password MySQL berbeda.

---

## 6. Jalankan Migration dan Seeder

Karena database masih kosong, jalankan:

```bash
php artisan migrate:fresh --seed
```

Perintah tersebut akan:

- Membuat seluruh tabel database
- Mengisi data awal (Seeder)

---

## 7. Membuat Storage Link

```bash
php artisan storage:link
```

---

## 8. Menjalankan Vite

Buka terminal baru kemudian jalankan

```bash
npm run dev
```

Biarkan terminal ini tetap berjalan.

---

## 9. Menjalankan Laravel

Buka terminal baru

```bash
php artisan serve
```

Aplikasi dapat diakses melalui

```
http://127.0.0.1:8000
```

---

# Urutan Instalasi Singkat

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

php artisan serve
```

---

# Jika Terjadi Error

Bersihkan cache Laravel

```bash
php artisan optimize:clear
```

Kemudian jalankan kembali

```bash
php artisan serve
```

---

# Teknologi yang Digunakan

- Laravel 12
- PHP 8.2.x
- MySQL
- Tailwind CSS
- Alpine.js
- Leaflet.js
- Vite
- JavaScript

---

# Catatan

Pastikan:

- Apache aktif
- MySQL aktif
- PHP menggunakan versi **8.2.x**
- Composer sudah terpasang
- Node.js sudah terpasang
- Git Bash sudah terpasang

---

© 2026  
**Sistem Optimasi Rute Pengangkutan Sampah Menggunakan Metode Nearest Neighbor**  
Dinas Lingkungan Hidup Kabupaten Jayapura.
