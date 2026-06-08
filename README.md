<p align="center">
  <img src="public/images/logo.png" width="180" alt="Coursify Logo" onerror="this.style.display='none'"/>
</p>

<h1 align="center">Coursify</h1>

<p align="center">
  Platform E-Learning Indonesia berbasis Laravel 12
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white" alt="Laravel 12"/>
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white" alt="PHP 8.2+"/>
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38BDF8?style=flat&logo=tailwindcss&logoColor=white" alt="TailwindCSS"/>
  <img src="https://img.shields.io/badge/MySQL-8.x-4479A1?style=flat&logo=mysql&logoColor=white" alt="MySQL"/>
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat&logo=alpinedotjs&logoColor=white" alt="Alpine.js"/>
</p>

---

##  Tentang Coursify

**Coursify** adalah platform e-learning berbahasa Indonesia yang menyediakan akses ke ribuan kursus berkualitas dari berbagai institusi ternama dunia. Platform ini mendukung tiga peran pengguna: **Student**, **Instructor**, dan **Admin** — masing-masing dengan fitur dan dashboard tersendiri.

Coursify mendukung Tujuan Pembangunan Berkelanjutan (SDGs) PBB:
-  **SDG 4** — Pendidikan Berkualitas: akses kursus gratis (audit track) untuk semua
-  **SDG 8** — Pekerjaan Layak: kursus skill profesional untuk meningkatkan employability
-  **SDG 10** — Berkurangnya Kesenjangan: konten dalam bahasa Indonesia, akses tanpa biaya

---

##  Fitur Utama

-  **Landing Page** — beranda, daftar kursus, program, dan institusi
-  **Student Dashboard** — kursus saya, progress belajar, sertifikat, wishlist
-  **Instructor Panel** — kelola kursus, materi, siswa, pendapatan, dan analitik
-  **Admin Panel** — manajemen penuh: user, kursus, kategori, institusi, transaksi, laporan
-  **Sertifikasi Digital** — generate & verifikasi sertifikat dengan nomor unik
-  **Payment Gateway** — integrasi Midtrans (kartu kredit, transfer bank, e-wallet)
-  **Google OAuth** — login dengan akun Google via Laravel Socialite
-  **Real-time Notifikasi** — powered by Pusher + Laravel Echo
-  **Audit Log** — activity logging via Spatie Activity Log
-  **Upload Gambar** — avatar & thumbnail via Intervention Image
-  **Export PDF** — sertifikat via DomPDF

---

##  Requirement Sistem

| Komponen | Versi Minimum |
|---|---|
| **PHP** | 8.2 |
| **Composer** | 2.x |
| **MySQL** / MariaDB | 8.0 / 10.4 |
| **Node.js** | 18.x |
| **NPM** | 9.x |
| **Laravel** | 12.x |

> **Ekstensi PHP yang dibutuhkan:** `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd` atau `imagick`

---

##  Cara Menjalankan Projek

### 1. Clone Repository

```bash
git clone https://github.com/username/coursify.git
cd coursify
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Install Dependensi Node.js

```bash
npm install
```

### 4. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan sesuaikan konfigurasi berikut:

```env
APP_NAME=Coursify
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coursify_db
DB_USERNAME=root
DB_PASSWORD=

# (Opsional) Google OAuth
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# (Opsional) Pusher untuk real-time
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_APP_CLUSTER=ap1

# (Opsional) Midtrans Payment Gateway
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

### 5. Buat Database

Buat database baru di MySQL dengan nama `coursify_db`:

```sql
CREATE DATABASE coursify_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Jalankan Migrasi & Seeder

```bash
php artisan migrate
php artisan db:seed
```

Perintah ini akan membuat semua tabel dan mengisi data dummy secara otomatis, termasuk:
- Kategori, institusi, dan program
- ~989 kursus dari berbagai bidang
- 200+ akun student dummy
- Enrollment, review, dan progress dummy

### 7. Build Asset Frontend

```bash
# Development (dengan hot reload)
npm run dev

# Atau build untuk production
npm run build
```

### 8. Jalankan Server

```bash
php artisan serve
```

Buka browser dan akses: **http://localhost:8000**

---

##  Akun Demo

Setelah menjalankan seeder, akun berikut sudah tersedia:

| Role | Email | Password |
|---|---|---|
| **Admin** | admin@coursify.com | password |
| **Instructor** | instructor@coursify.com | password |
| **Student** | student@coursify.com | password |

---

##  Struktur Direktori

```
coursify/
├── app/
│   ├── Http/Controllers/     # 19+ controllers (Admin, Instructor, Student)
│   ├── Models/               # 22 Eloquent models
│   └── ...
├── database/
│   ├── migrations/           # 54 migration files
│   ├── seeders/              # 10 seeders
│   └── factories/            # 2 factories (User, Course)
├── resources/
│   └── views/                # 100+ Blade templates
│       ├── admin/            # 18 admin views
│       ├── instructor/       # 12+ instructor views
│       ├── student/          # 6 student views
│       └── ...
├── routes/
│   └── web.php               # Semua route aplikasi
├── public/                   # Asset publik
├── tailwind.config.js
├── vite.config.js
└── .env.example
```

---

##  Teknologi yang Digunakan

### Backend
| Package | Fungsi |
|---|---|
| `laravel/framework ^12.0` | Framework utama |
| `laravel/breeze ^2.4` | Auth scaffolding |
| `laravel/socialite` | Google OAuth |
| `barryvdh/laravel-dompdf` | Generate sertifikat PDF |
| `intervention/image ^3.0` | Pengolahan gambar |
| `spatie/laravel-activitylog` | Audit log aktivitas |
| `spatie/laravel-sluggable` | Auto-generate URL slug |
| `pusher/pusher-php-server` | Real-time server |
| Midtrans SDK | Payment gateway |

### Frontend
| Package | Fungsi |
|---|---|
| `tailwindcss ^3.1` | Utility-first CSS framework |
| `alpinejs ^3.15` | Reaktivitas frontend ringan |
| `laravel-echo ^2.3` | Real-time event client |
| `pusher-js ^8.5` | WebSocket client |
| `axios ^1.11` | HTTP client |
| `vite ^7.0` | Build tool modern |
| `sass ^1.99` | CSS preprocessor |

---

##  Menjalankan Test

```bash
php artisan test
```

---

##  Lisensi

Projek ini dibuat untuk keperluan **Tugas Besar Praktikum Pemrograman Web Lanjutan Kelompok 8 Kom B 2026**.
