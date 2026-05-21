<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddCurriculumCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coursify:add-curriculum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactively add sections and lessons to a course';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("--- Coursify Curriculum (Bagian & Materi) Input ---");
        
        $searchTerm = $this->ask('Masukkan ID Kursus, Slug, atau kata kunci Judul Kursus');
        
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

        $existingSections = DB::table('sections')->where('course_id', $course->id)->count();
        if ($existingSections > 0) {
            $this->warn("Kursus ini sudah memiliki $existingSections Sections (Bagian).");
            if ($this->confirm('Hapus kurikulum lama (Semua Section & Lesson) dan ganti dengan yang baru?', true)) {
                DB::table('sections')->where('course_id', $course->id)->delete();
                $this->info('Kurikulum lama dihapus.');
            } else {
                $this->info("Kurikulum baru akan ditambahkan di bagian bawah.");
            }
        }

        $this->info("\nSekarang kita akan memasukkan Section (Bagian) dan Lesson (Materi).");
        $this->info("Ketik 'selesai' kapan saja jika ingin mengakhiri.\n");

        $sectionOrder = DB::table('sections')->where('course_id', $course->id)->max('order_index') ?? 0;
        $sectionOrder++;
        
        while (true) {
            $sectionTitle = $this->ask("\nJudul SECTION ke-{$sectionOrder} (contoh: 'Minggu 1: Pengenalan') [Atau ketik 'selesai']");
            
            if (empty($sectionTitle)) {
                continue;
            }

            if (strtolower($sectionTitle) === 'selesai' || strtolower($sectionTitle) === 'exit') {
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
                
                if (empty($lessonTitle) || strtolower($lessonTitle) === 'selesai' || strtolower($lessonTitle) === 'exit') {
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
