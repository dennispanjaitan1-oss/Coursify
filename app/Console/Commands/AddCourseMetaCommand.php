<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddCourseMetaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coursify:add-course-meta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactively add comprehensive course metadata to the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("=== Coursify Comprehensive Course Meta Input ===");
        
        $searchTerm = $this->ask('Masukkan ID Kursus, Slug, atau kata kunci Judul Kursus (contoh: cs50)');
        
        $courses = Course::where('id', $searchTerm)
            ->orWhere('slug', 'like', "%{$searchTerm}%")
            ->orWhere('title', 'like', "%{$searchTerm}%")
            ->limit(5)
            ->get();
            
        if ($courses->isEmpty()) {
            $this->error('Kursus tidak ditemukan!');
            return;
        }

        if ($courses->count() > 1) {
            $choices = $courses->map(function ($c) {
                return "[{$c->id}] {$c->title} ({$c->slug})";
            })->toArray();
            
            $selected = $this->choice('Ditemukan beberapa kursus, pilih yang mana?', $choices);
            preg_match('/\[(\d+)\]/', $selected, $matches);
            $courseId = $matches[1];
            
            $course = $courses->firstWhere('id', $courseId);
        } else {
            $course = $courses->first();
            $this->info("Memilih kursus: [{$course->id}] {$course->title}");
        }

        while (true) {
            $this->info("\n--- MENU UPDATE DATA KURSUS ---");
            $this->info("Kursus saat ini: {$course->title}");
            
            $menu = [
                '1' => 'Short Description (About this course)',
                '2' => 'Full Description',
                '3' => 'Weeks (duration_weeks)',
                '4' => 'Hours per week',
                '5' => 'Language',
                '6' => 'Translations',
                '7' => 'Transcripts',
                '8' => 'Prerequisites',
                '9' => 'Instructor (Created by / Meet your instructor)',
                '10' => 'Syllabus (What you\'ll learn)',
                '11' => 'Curriculum (Sections & Lessons)',
                '0' => 'Keluar / Selesai'
            ];

            $choice = $this->choice('Pilih menu yang ingin diupdate (0-11)', $menu);

            // Parsing choice if they type the full string or number
            $choiceKey = array_search($choice, $menu) ?: $choice;

            switch ((string)$choiceKey) {
                case '1':
                    $this->updateField($course, 'short_description', 'Masukkan teks pendek (About this course)');
                    break;
                case '2':
                    $this->updateField($course, 'description', "Masukkan deskripsi lengkap (1 baris panjang)");
                    break;
                case '3':
                    $this->updateField($course, 'duration_weeks', 'Masukkan durasi dalam minggu (angka, misal: 12)');
                    break;
                case '4':
                    $this->updateField($course, 'hours_per_week', 'Masukkan jam per minggu (teks, misal: "8-12")');
                    break;
                case '5':
                    $this->updateField($course, 'language', 'Masukkan bahasa pengantar (contoh: English)');
                    break;
                case '6':
                    $this->updateField($course, 'translations', 'Masukkan translations (contoh: English, Spanish)');
                    break;
                case '7':
                    $this->updateField($course, 'transcripts', 'Masukkan transcripts (contoh: English)');
                    break;
                case '8':
                    $this->updateField($course, 'prerequisites', 'Masukkan prerequisites (contoh: None atau Basic Python)');
                    break;
                case '9':
                    $this->updateInstructor($course);
                    break;
                case '10':
                    $this->updateSyllabus($course);
                    break;
                case '11':
                    $this->updateCurriculum($course);
                    break;
                case '0':
                case 'Keluar / Selesai':
                    $this->info("Selesai! Perubahan telah disimpan.");
                    return;
            }
        }
    }

    private function updateField(Course $course, string $field, string $prompt)
    {
        $this->info("Nilai saat ini: " . ($course->{$field} ?: '(kosong)'));
        $input = $this->ask($prompt);
        if ($input !== null && $input !== '') {
            $course->{$field} = $input;
            $course->save();
            $this->info("Berhasil memperbarui {$field}!");
        } else {
            $this->warn("Dibatalkan, nilai tidak berubah.");
        }
    }

    private function updateInstructor(Course $course)
    {
        $instructors = $course->instructors;
        if ($instructors->isNotEmpty()) {
            $this->info("Instruktur saat ini: " . $instructors->pluck('name')->join(', '));
            $action = $this->choice('Apa yang ingin Anda lakukan?', [
                '1' => 'Hapus semua instruktur yang ada lalu buat baru',
                '2' => 'Tambahkan instruktur baru (tanpa menghapus yang lama)',
                '0' => 'Batal'
            ], '2');

            if ($action === '0' || $action === 'Batal') {
                $this->warn("Dibatalkan.");
                return;
            }

            if ($action === '1' || $action === 'Hapus semua instruktur yang ada lalu buat baru') {
                if ($this->confirm('Yakin ingin menghapus semua instruktur dari kursus ini?')) {
                    $course->instructors()->detach();
                    $this->info("Semua instruktur berhasil dilepas dari kursus ini.");
                } else {
                    $this->warn("Penghapusan dibatalkan.");
                    return;
                }
            }
        }

        $this->info("\n--- TAMBAH INSTRUKTUR BARU ---");
        $instructorName = $this->ask("1. Masukkan nama Instruktur (kosongkan untuk batal)");
        if (empty($instructorName)) {
            $this->warn("Dibatalkan.");
            return;
        }

        $headline = $this->ask("2. Masukkan headline / keterangan / gelar profesi instruktur (opsional)");

        // Find or create instructor user
        $user = User::where('name', $instructorName)->where('role', 'instructor')->first();
        
        if (!$user) {
            $this->info("Instruktur belum ada di database, membuat instruktur baru...");
            $email = strtolower(str_replace(' ', '', $instructorName)) . '_' . Str::random(4) . '@instructor.coursify.local';
            $user = User::create([
                'name' => $instructorName,
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => 'instructor',
                'headline' => $headline
            ]);
            $this->info("Instruktur {$instructorName} berhasil dibuat!");
        } else {
            // Update headline if provided
            if (!empty($headline) && $user->headline !== $headline) {
                $user->headline = $headline;
                $user->save();
                $this->info("Headline untuk {$instructorName} berhasil diperbarui!");
            }
        }

        // Attach if not already attached
        if (!$course->instructors->contains($user->id)) {
            $course->instructors()->attach($user->id, ['role' => 'lead']);
            $this->info("Instruktur {$instructorName} berhasil ditautkan ke kursus ini!");
        } else {
            $this->warn("Instruktur {$instructorName} sudah tertaut dengan kursus ini.");
        }
    }

    private function updateSyllabus(Course $course)
    {
        $existingCount = DB::table('course_syllabus')->where('course_id', $course->id)->count();
        if ($existingCount > 0) {
            $this->warn("Kursus ini sudah memiliki $existingCount item silabus.");
            if ($this->confirm('Hapus silabus lama dan ganti dengan yang baru? (Pilih "no" untuk menambah di akhir)', true)) {
                DB::table('course_syllabus')->where('course_id', $course->id)->delete();
                $this->info('Silabus lama dihapus.');
            }
        }

        $this->info("\n--- SILABUS (WHAT YOU'LL LEARN) ---");
        $this->info("Masukkan item silabus satu per satu.");
        $this->info("Ketik 'selesai' (atau tekan Enter tanpa mengetik) jika sudah selesai.\n");

        $items = [];
        // Get max order if we are appending
        $maxOrder = DB::table('course_syllabus')->where('course_id', $course->id)->max('order_index') ?? 0;
        $order = $maxOrder + 1;

        while (true) {
            $item = $this->ask("Item #{$order} (atau 'selesai')");
            
            if (empty($item)) {
                $confirm = $this->confirm('Selesai memasukkan silabus?');
                if ($confirm) break;
                continue;
            }

            if (strtolower($item) === 'selesai' || strtolower($item) === 'exit' || strtolower($item) === 'quit') {
                break;
            }

            $items[] = [
                'course_id' => $course->id,
                'item' => $item,
                'order_index' => $order,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $order++;
        }

        if (!empty($items)) {
            DB::table('course_syllabus')->insert($items);
            $this->info("\nBerhasil! Menyimpan " . count($items) . " item silabus ke kursus '{$course->title}'.");
        } else {
            $this->warn("\nTidak ada silabus yang dimasukkan/ditambahkan.");
        }
    }

    private function updateCurriculum(Course $course)
    {
        $existingSections = DB::table('sections')->where('course_id', $course->id)->count();
        if ($existingSections > 0) {
            $this->warn("Kursus ini sudah memiliki $existingSections Sections (Bagian).");
            if ($this->confirm('Hapus kurikulum lama (Semua Section & Lesson) dan ganti dengan yang baru? (Pilih "no" untuk menambah di akhir)', true)) {
                DB::table('sections')->where('course_id', $course->id)->delete();
                $this->info('Kurikulum lama dihapus.');
            } else {
                $this->info("Kurikulum baru akan ditambahkan di bagian bawah.");
            }
        }

        $this->info("\n--- KURIKULUM (BAGIAN & MATERI) ---");
        $this->info("Sekarang kita akan memasukkan Section (Bagian) dan Lesson (Materi).");
        $this->info("Ketik 'selesai' kapan saja jika ingin mengakhiri.\n");

        $sectionOrder = DB::table('sections')->where('course_id', $course->id)->max('order_index') ?? 0;
        $sectionOrder++;
        
        while (true) {
            $sectionTitle = $this->ask("\nJudul SECTION ke-{$sectionOrder} (contoh: 'Minggu 1: Pengenalan') [Atau ketik 'selesai']");
            
            if (empty($sectionTitle)) {
                continue;
            }

            if (strtolower($sectionTitle) === 'selesai' || strtolower($sectionTitle) === 'exit' || strtolower($sectionTitle) === 'quit') {
                break;
            }

            // Simpan Section
            $sectionId = DB::table('sections')->insertGetId([
                'course_id' => $course->id,
                'title' => $sectionTitle,
                'order_index' => $sectionOrder,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $this->info("✔ Section '{$sectionTitle}' berhasil ditambahkan. Sekarang masukkan materi-materi di dalamnya.");

            $lessonOrder = 1;
            while (true) {
                $lessonTitle = $this->ask("  -> Judul MATERI ke-{$lessonOrder} di Section ini (Atau tekan Enter jika Section ini sudah selesai)");
                
                if (empty($lessonTitle) || strtolower($lessonTitle) === 'selesai' || strtolower($lessonTitle) === 'exit' || strtolower($lessonTitle) === 'quit') {
                    $this->info("  [Selesai memasukkan materi untuk Section ini]");
                    break;
                }

                // Simpan Lesson
                DB::table('lessons')->insert([
                    'section_id' => $sectionId,
                    'title' => $lessonTitle,
                    'type' => 'video',
                    'order_index' => $lessonOrder,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $lessonOrder++;
            }
            
            $sectionOrder++;
        }

        $finalSections = DB::table('sections')->where('course_id', $course->id)->count();
        $this->info("\nSelesai! Kursus ini sekarang memiliki $finalSections Sections (Bagian).");
    }
}
