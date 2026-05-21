<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddSyllabusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coursify:add-syllabus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactively add syllabus to a course';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("--- Coursify Syllabus Input ---");
        
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

        $existingCount = DB::table('course_syllabus')->where('course_id', $course->id)->count();
        if ($existingCount > 0) {
            $this->warn("Kursus ini sudah memiliki $existingCount item silabus.");
            if ($this->confirm('Hapus silabus lama dan ganti dengan yang baru?', true)) {
                DB::table('course_syllabus')->where('course_id', $course->id)->delete();
                $this->info('Silabus lama dihapus.');
            }
        }
        
        $this->info("\n--- INFORMASI KURSUS ---");
        if ($this->confirm("Apakah Anda ingin memperbarui 'About this course' (Short Description)?", false)) {
            $shortDesc = $this->ask('Masukkan teks pendek (About this course)');
            if (!empty($shortDesc)) {
                $course->short_description = $shortDesc;
            }
        }

        if ($this->confirm("Apakah Anda ingin memperbarui 'Course Description' (Full Description)?", false)) {
            $this->info("Masukkan teks deskripsi panjang. Karena input terminal hanya mendukung 1 baris, paste teks Anda menjadi 1 baris, atau ketik manual.");
            $desc = $this->ask('Masukkan deskripsi lengkap');
            if (!empty($desc)) {
                $course->description = $desc;
            }
        }
        
        if ($course->isDirty()) {
            $course->save();
            $this->info("Informasi kursus berhasil diperbarui!");
        }

        $this->info("\n--- SILABUS (WHAT YOU'LL LEARN) ---");
        $this->info("Copy-paste isi 'What you'll learn' dari edX satu per satu.");
        $this->info("Ketik 'selesai' (atau tekan Enter 2x) jika sudah selesai.\n");

        $items = [];
        $order = 1;
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
            $this->warn("\nTidak ada silabus yang dimasukkan.");
        }
    }
}
