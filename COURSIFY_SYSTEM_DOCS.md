# 📚 Coursify — Dokumentasi Sistem & Roadmap Ekspansi

> Dokumen lengkap yang mencakup status sistem saat ini, arsitektur yang sudah dibangun, gap yang perlu diisi, dan rencana ekspansi konten.

---

## 🗺️ Daftar Isi

1. [Status Sistem Saat Ini](#1-status-sistem-saat-ini)
2. [Arsitektur Database](#2-arsitektur-database)
3. [Sistem Filter & Navigasi](#3-sistem-filter--navigasi)
4. [Sistem Enrollment](#4-sistem-enrollment)
5. [Status Konten](#5-status-konten)
6. [Gap & Yang Perlu Ditambah](#6-gap--yang-perlu-ditambah)
7. [Roadmap Ekspansi](#7-roadmap-ekspansi)
8. [Checklist Pengerjaan](#8-checklist-pengerjaan)
9. [Referensi Perintah](#9-referensi-perintah)

---

## 1. Status Sistem Saat Ini

### ✅ Yang Sudah Berfungsi

| Fitur | Status | Catatan |
|-------|--------|---------|
| Scraper edX (courses) | ✅ Jalan | ~989 courses, terus bertambah |
| Simpan curriculum (sections + lessons) | ✅ Jalan | Filter title > 150 char |
| Simpan instructors | ✅ Jalan | Per course |
| Simpan syllabus | ✅ Jalan | Fallback jika kosong |
| Handle UTF-8 / karakter non-ASCII | ✅ Fixed | iconv + mb_convert_encoding |
| Filter pencarian courses | ✅ Ada | Lihat detail di Bagian 3 |
| Sistem enrollment dual-track | ✅ Ada | Audit + Verified |
| Upgrade audit → verified | ✅ Ada | Dengan upgrade_deadline |
| Review system (post-completion) | ✅ Ada | Hanya setelah 100% lesson |
| Relasi program → courses | ✅ Strukturnya ada | Belum di-populate |

### ❌ Yang Belum Ada

| Fitur | Prioritas | Bagian |
|-------|-----------|--------|
| Filter by institution/educator | Tinggi | Bagian 6 |
| Filter by language | Tinggi | Bagian 6 |
| Filter by learning type/format | Tinggi | Bagian 6 |
| Data programs (Certificate, Exec Ed, dll) | Tinggi | Bagian 7 |
| Halaman /programs di frontend | Tinggi | Bagian 7 |
| Scraper untuk programs | Sedang | Bagian 7 |
| Deskripsi per lesson | Rendah | Bagian 6 |

---

## 2. Arsitektur Database

### Hierarki Lengkap

```
institutions
    └── programs  (professional_certificate / micromasters / degree / dll)
            └── courses  (individual courses, bisa standalone atau dalam program)
                    └── sections  (Week 1, Module A, dll)
                            └── lessons  (Video, Reading, dll)
                                    └── quizzes
```

### Tabel Utama & Kolom Penting

#### `institutions`
```
id, name, slug, logo_url, website, description
```

#### `programs`
```
id
type → enum: professional_certificate | micromasters | microbachelors 
             | degree | executive_education
title, slug, description
institution_id → FK ke institutions
duration, effort, language, difficulty
price, currency
image_url, edx_url
scraped_at
```

#### `courses`
```
id
program_id     → FK ke programs (nullable — bisa standalone)
course_type    → enum: course | professional_certificate | micromasters | dll
title, slug, description, short_description
difficulty     → beginner | intermediate | advanced
duration_weeks
hours_per_week
language       → 2-char ISO (en, id, fr, es, dll)
translations   → bahasa subtitle yang tersedia
has_audit_track → boolean
price, certificate_price, currency
rating, enrolled_count
prerequisites
is_self_paced
start_date, enroll_deadline
scraped_at
```

#### `sections`
```
id, course_id, title, order_index
```

#### `lessons`
```
id, section_id, title, type (video/reading/quiz), order_index
description → nullable (belum di-scrape semua)
```

#### `enrollments`
```
id
user_id, course_id
track          → audit | verified
status         → active | completed | dropped
progress       → 0-100 (%)
upgrade_deadline
enrolled_at, completed_at
```

---

## 3. Sistem Filter & Navigasi

### Status Filter di `CourseController`

| Filter | Status | Parameter URL |
|--------|--------|--------------|
| Search by title/description | ✅ Ada | `?q=python` |
| Filter by category | ✅ Ada | `?category=data-science` |
| Filter by difficulty | ✅ Ada | `?difficulty=beginner` |
| Filter by price free/paid | ✅ Ada | `?price=free` |
| Filter by max price | ✅ Ada | `?max_price=100` |
| Filter by rating | ✅ Ada | `?rating=4` |
| Filter by institution | ❌ Belum | `?institution=mit` |
| Filter by language | ❌ Belum | `?language=en` |
| Filter by learning type | ❌ Belum | `?type=professional_certificate` |
| Sort (newest, popular, price) | ❓ Cek | `?sort=popular` |

### Yang Perlu Ditambah di `CourseController`

```php
// Filter by institution
if ($request->filled('institution')) {
    $query->whereHas('institution', function ($q) use ($request) {
        $q->where('slug', $request->institution);
    });
}

// Filter by language
if ($request->filled('language')) {
    $query->where('language', $request->language);
}

// Filter by learning type (course vs program)
if ($request->filled('type')) {
    $query->where('course_type', $request->type);
}

// Sort options
$sort = $request->get('sort', 'newest');
match($sort) {
    'popular'    => $query->orderByDesc('enrolled_count'),
    'rating'     => $query->orderByDesc('rating'),
    'price_low'  => $query->orderBy('price'),
    'price_high' => $query->orderByDesc('price'),
    default      => $query->orderByDesc('created_at'),
};
```

---

## 4. Sistem Enrollment

### Alur Lengkap (Sudah Diimplementasi)

```
User klik "Enroll"
        │
        ▼
Cek sudah enroll? ──── Ya ──→ Redirect ke dashboard course
        │ Tidak
        ▼
Pilih track: Audit atau Verified?
        │
        ├── AUDIT ──────────────────────────────────────────────────┐
        │   Cek: course punya audit track?                          │
        │   ├── Ya  → Langsung enroll, payment amount=0             │
        │   └── Tidak → Paksa ke Verified                           │
        │                                                           │
        └── VERIFIED ────────────────────────────────────────────── ┤
            → Redirect ke halaman payment                           │
            → Setelah bayar → enrollment aktif                      │
                                                                    ▼
                                                    Enrollment tersimpan di DB
                                                    track: audit / verified
                                                    status: active
```

### Business Rules yang Sudah Ada

```
✅ Unique enrollment: satu user tidak bisa enroll course yang sama dua kali
   → unique(['user_id', 'course_id']) di tabel enrollments

✅ Upgrade path: audit → verified diizinkan
   → Cek upgrade_deadline sebelum izinkan upgrade

✅ Review gate: review hanya bisa diberikan setelah progress = 100%
   → Validasi di ReviewController

✅ Payment flow: verified track → wajib bayar dulu
   → amount=0 untuk audit/free courses
```

### Yang Perlu Dicek / Ditambah

```
❓ Apakah ada notifikasi email setelah enroll berhasil?
❓ Apakah ada reminder ketika upgrade_deadline hampir habis?
❓ Certificate generation setelah completed?
❓ Refund policy untuk verified track?
```

---

## 5. Status Konten

### Individual Courses

```
Total di DB sekarang : ~989+
Sudah di-scrape      : cek dengan → Course::whereNotNull('scraped_at')->count()
Belum di-scrape      : cek dengan → Course::whereNull('scraped_at')->count()
```

### Programs (Belum Ada Data)

| Tipe | Jumlah di edX | Di DB Coursify |
|------|--------------|----------------|
| Professional Certificate | 300+ | 0 |
| Executive Education | 200+ | 0 |
| MicroMasters | 60+ | 0 |
| Master's Degree | 20+ | 0 |
| Bachelor's Degree | 10+ | 0 |

### Kategori edX yang Perlu Dicek Kelengkapannya

| Kategori | URL |
|----------|-----|
| Computer Science | edx.org/learn/computer-science |
| Data Science | edx.org/learn/data-science |
| Business & Management | edx.org/learn/business-management |
| Artificial Intelligence | edx.org/learn/artificial-intelligence |
| Healthcare | edx.org/learn/healthcare |
| Language Learning | edx.org/learn/language |
| Engineering | edx.org/learn/engineering |
| Finance | edx.org/learn/finance |
| Law | edx.org/learn/law |
| Design | edx.org/learn/design |
| Marketing | edx.org/learn/marketing |
| Education & Teaching | edx.org/learn/education-teacher-training |

---

## 6. Gap & Yang Perlu Ditambah

### 6.1 Filter yang Belum Ada (Prioritas Tinggi)

Tambahkan di `CourseController@index` dan update view filter sidebar:

**a. Filter by Institution**
```php
// Controller
if ($request->filled('institution')) {
    $query->where('institution_id', $request->institution);
}

// Di view, tampilkan dropdown institusi populer:
// MIT, Harvard, Google, IBM, Microsoft, dll.
```

**b. Filter by Language**
```php
if ($request->filled('language')) {
    $query->where('language', $request->language);
}
// Tampilkan flag + nama bahasa di filter sidebar
```

**c. Filter by Learning Type**
```php
if ($request->filled('learning_type')) {
    if ($request->learning_type === 'program') {
        $query->whereNotNull('program_id');
    } elseif ($request->learning_type === 'course') {
        $query->whereNull('program_id');
    }
}
```

### 6.2 Deskripsi Per Lesson (Prioritas Rendah)

Tambah kolom `description` di tabel `lessons`:

```bash
php artisan make:migration add_description_to_lessons_table
```

```php
public function up(): void
{
    Schema::table('lessons', function (Blueprint $table) {
        $table->text('description')->nullable()->after('title');
    });
}
```

Update `ScrapeController` bagian lessons:
```php
$lessons[] = [
    'section_id'  => $sectionId,
    'title'       => $lesData['title'],
    'description' => $lesData['description'] ?? null, // tambah ini
    'type'        => 'video',
    'order_index' => $lesData['order_index'],
    'created_at'  => now(),
    'updated_at'  => now(),
];
```

> **Catatan:** Deskripsi lesson di edX ada di halaman publik (tanpa enroll) untuk sebagian course. Perlu update content script extension untuk scrape bullet point deskripsi dari accordion curriculum.

---

## 7. Roadmap Ekspansi

### TAHAP 1 — Selesaikan Scraping Courses (Sedang Berjalan)

**Aksi:**
1. Biarkan scraper jalan sampai semua `scraped_at` terisi
2. Tambah course dari kategori yang belum ada (lihat tabel di Bagian 5)
3. Monitor dengan:
```php
php artisan tinker
$d = Course::whereNotNull('scraped_at')->count();
$s = Course::whereNull('scraped_at')->count();
echo "Selesai: $d | Sisa: $s";
```

---

### TAHAP 2 — Setup Database Programs

**2a. Migration `programs` table** (jika belum ada):
```bash
php artisan make:migration create_programs_table
```

```php
Schema::create('programs', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->enum('type', [
        'professional_certificate',
        'micromasters',
        'microbachelors',
        'executive_education',
        'masters_degree',
        'bachelors_degree',
        'boot_camp',
    ]);
    $table->text('description')->nullable();
    $table->text('short_description')->nullable();
    $table->string('institution')->nullable();
    $table->string('institution_logo')->nullable();
    $table->string('duration')->nullable();
    $table->string('effort')->nullable();
    $table->string('language', 10)->default('en');
    $table->string('difficulty')->nullable();
    $table->boolean('is_self_paced')->default(false);
    $table->decimal('price', 10, 2)->nullable();
    $table->string('currency', 10)->default('USD');
    $table->string('image_url')->nullable();
    $table->string('edx_url')->nullable();
    $table->string('edx_program_id')->nullable();
    $table->decimal('rating', 3, 1)->nullable();
    $table->integer('enrolled_count')->default(0);
    $table->timestamp('scraped_at')->nullable();
    $table->timestamps();
    $table->index(['type', 'scraped_at']);
});
```

**2b. Migration relasi courses → programs:**
```bash
php artisan make:migration add_program_id_to_courses_table
```

```php
Schema::table('courses', function (Blueprint $table) {
    $table->foreignId('program_id')
          ->nullable()->after('id')
          ->constrained('programs')->nullOnDelete();
    $table->enum('course_type', [
        'course', 'professional_certificate', 'micromasters',
        'executive_education', 'masters_degree', 'bachelors_degree',
    ])->default('course')->after('program_id');
});
```

**2c. Migration tabel `program_courses`** (urutan courses dalam program):
```php
Schema::create('program_courses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
    $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
    $table->integer('order_index')->default(0);
    $table->timestamps();
    $table->unique(['program_id', 'course_id']);
});
```

```bash
php artisan migrate
```

---

### TAHAP 3 — Scraper untuk Programs

**3a. Buat `ScrapeProgramController`:**
```bash
php artisan make:controller Api/ScrapeProgramController
```

Endpoint yang dibutuhkan:
```php
// routes/api.php
Route::get('/scrape/programs/next', [ScrapeProgramController::class, 'next']);
Route::post('/scrape/programs/save', [ScrapeProgramController::class, 'save']);
```

Logic `next()`:
```php
public function next()
{
    $program = Program::whereNull('scraped_at')->first();
    if (!$program) return response()->json(['status' => 'done']);

    return response()->json([
        'status'  => 'ok',
        'program' => [
            'id'    => $program->id,
            'title' => $program->title,
            'type'  => $program->type,
            'url'   => $program->edx_url,
        ]
    ]);
}
```

**3b. URL edX per tipe program:**

| Tipe | URL List di edX |
|------|----------------|
| Professional Certificate | edx.org/certificates |
| Executive Education | edx.org/executive-education |
| MicroMasters | edx.org/micromasters |
| Master's Degree | edx.org/masters |
| Bachelor's Degree | edx.org/bachelors |

**3c. Cara deteksi tipe dari URL:**
```javascript
// Di content script extension
function detectProgramType(url) {
    if (url.includes('/certificates/'))        return 'professional_certificate';
    if (url.includes('/executive-education/')) return 'executive_education';
    if (url.includes('/micromasters/'))        return 'micromasters';
    if (url.includes('/masters/'))             return 'masters_degree';
    if (url.includes('/bachelors/'))           return 'bachelors_degree';
    return null;
}
```

**3d. Seed list program dulu sebelum scrape:**
```php
// Contoh insert manual via tinker
DB::table('programs')->insertOrIgnore([
    'title'      => 'IBM Data Science Professional Certificate',
    'slug'       => 'ibm-data-science-professional-certificate',
    'type'       => 'professional_certificate',
    'edx_url'    => 'https://www.edx.org/certificates/professional-certificate/ibm-data-science',
    'created_at' => now(),
    'updated_at' => now(),
]);
```

---

### TAHAP 4 — Frontend Halaman Programs

**Struktur halaman:**
```
/programs                          → Semua programs dengan filter tipe
/programs?type=professional_certificate
/programs?type=executive_education
/programs?type=masters_degree
/programs/{slug}                   → Detail program + list courses di dalamnya
```

**Controller:**
```php
// app/Http/Controllers/ProgramController.php
public function index(Request $request)
{
    $query = Program::whereNotNull('scraped_at');

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }
    if ($request->filled('q')) {
        $query->where('title', 'like', "%{$request->q}%");
    }

    $programs = $query->orderBy('title')->paginate(24);
    return view('programs.index', compact('programs'));
}

public function show(string $slug)
{
    $program = Program::where('slug', $slug)
                      ->with(['courses' => fn($q) => $q->orderBy('program_courses.order_index')])
                      ->firstOrFail();
    return view('programs.show', compact('program'));
}
```

**Routes:**
```php
// routes/web.php
Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{slug}', [ProgramController::class, 'show'])->name('programs.show');
```

**Tambah link di navbar:**
```html
<a href="/programs">Programs</a>
```

---

## 8. Checklist Pengerjaan

### Segera (Minggu Ini)
- [ ] Monitor scraper courses sampai selesai
- [ ] Tambah filter **institution**, **language**, **learning_type** di `CourseController`
- [ ] Update view filter sidebar dengan ketiga filter baru

### Jangka Pendek (2 Minggu)
- [ ] Buat migration `programs` table
- [ ] Buat migration `add_program_id_to_courses`
- [ ] Buat migration `program_courses`
- [ ] Jalankan `php artisan migrate`
- [ ] Buat model `Program` dengan relasi ke `Course`
- [ ] Update model `Course` tambah `belongsTo(Program::class)`
- [ ] Buat `ScrapeProgramController`
- [ ] Tambah routes API `/scrape/programs/next` dan `/scrape/programs/save`

### Jangka Menengah (1 Bulan)
- [ ] Seed list URL programs dari edX ke DB
- [ ] Update extension untuk scrape halaman program
- [ ] Test scraper 1 program dulu, cek hasilnya
- [ ] Jalankan scraper untuk semua programs
- [ ] Buat `ProgramController` frontend
- [ ] Buat view `programs/index.blade.php`
- [ ] Buat view `programs/show.blade.php`
- [ ] Tambah link Programs di navbar

### Nice to Have (Nanti)
- [ ] Tambah kolom `description` di tabel `lessons`
- [ ] Scrape deskripsi lesson dari halaman publik edX
- [ ] Notifikasi email setelah enroll
- [ ] Reminder upgrade_deadline
- [ ] Certificate generation setelah course completed
- [ ] Halaman institusi (`/institutions/{slug}`)

---

## 9. Referensi Perintah

### Monitoring Scraper

```php
php artisan tinker

// Progress courses
$d = Course::whereNotNull('scraped_at')->count();
$s = Course::whereNull('scraped_at')->count();
echo "Courses — Selesai: $d | Sisa: $s";

// Progress programs (setelah tahap 2)
$d = \App\Models\Program::whereNotNull('scraped_at')->count();
$s = \App\Models\Program::whereNull('scraped_at')->count();
echo "Programs — Selesai: $d | Sisa: $s";

// 5 course terbaru yang masuk
Course::whereNotNull('scraped_at')
      ->orderBy('scraped_at','desc')
      ->limit(5)
      ->get(['id','title','scraped_at']);
```

### Troubleshooting Scraper

```php
// Skip course/program yang stuck (ganti ID)
DB::table('courses')->where('id', 999)->update(['scraped_at' => now()]);
DB::table('programs')->where('id', 999)->update(['scraped_at' => now()]);

// Cek log error terbaru
// (jalankan di Git Bash, bukan tinker)
// grep "SQLSTATE\|local.ERROR" storage/logs/laravel.log | tail -10

// Fix charset jika ada error \xC3 di tabel baru
DB::statement('ALTER TABLE programs CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

// Bersihkan lesson dengan title yang terlalu panjang (deskripsi, bukan judul)
DB::table('lessons')->whereRaw('LENGTH(title) > 150')->delete();
```

### Database Health Check

```php
// Cek kolom tabel
Schema::getColumnListing('courses');
Schema::getColumnListing('programs');

// Cek charset kolom
DB::select("SHOW FULL COLUMNS FROM courses WHERE Field = 'language'");

// Cek charset koneksi MySQL
DB::select("SHOW VARIABLES LIKE 'character_set%'");

// Export DB (jalankan di Git Bash)
// mysqldump -u root coursify_db > coursify_db_backup.sql
```

---

## 💡 Catatan Penting

### Kenapa Pakai Chrome Extension untuk Scraping?

edX menggunakan JavaScript untuk render konten (React/SPA). `curl` atau `Guzzle` dari Laravel tidak bisa mengeksekusi JavaScript, sehingga data curriculum, instructor, dll. tidak akan muncul. Extension browser berjalan sebagai "user sungguhan" sehingga semua konten ter-render sempurna.

### Kenapa Data Program Belum Ada?

Scraper yang sekarang hanya buka halaman `/course/[slug]` — halaman individual course. Halaman program (`/certificates/`, `/masters/`, dll.) punya struktur HTML yang berbeda dan perlu content script terpisah.

### UTF-8 & Karakter Non-ASCII

Selalu pastikan setiap controller baru punya method `sanitizeUtf8()` dan dipanggil di awal `save()`. Ini wajib untuk course berbahasa Spanyol, Perancis, Arab, Jepang, dll.

```php
// Wajib ada di setiap scrape controller
$request->replace($this->sanitizeUtf8($request->all()));
```

---

*Dokumen ini diperbarui berdasarkan analisis kode Coursify per Mei 2026.*
*Update dokumen ini setiap kali ada perubahan signifikan pada sistem.*
