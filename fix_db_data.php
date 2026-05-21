<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

echo "Mulai memproses data...\n";

// 1. Ambil semua program_id yang tersedia
$programIds = DB::table('programs')->pluck('id')->toArray();

// Video dummy edukasi (beberapa variasi)
$dummyVideos = [
    'https://www.youtube.com/embed/jNQXAC9IVRw', // Me at the zoo (first yt video)
    'https://www.youtube.com/embed/tgbNymZ7vqY', 
    'https://www.youtube.com/embed/kJQP7kiw5Fk',
    'https://www.youtube.com/embed/V-_O7nl0Ii0',
];

// Proses semua kursus
$courses = Course::all();
$count = 0;
foreach ($courses as $course) {
    // Acak jam per minggu (misal: 2-4, 4-6, 8-12)
    $minHours = rand(2, 6);
    $maxHours = $minHours + rand(2, 6);
    $hoursStr = "{$minHours}-{$maxHours}";

    // Acak tanggal mulai (dari hari ini sampai 30 hari ke depan)
    $startDate = Carbon::now()->addDays(rand(1, 30));
    
    // Acak batas enroll (beberapa hari setelah start date)
    $enrollDeadline = (clone $startDate)->addDays(rand(3, 14));

    // Acak tipe kursus (80% self paced, 20% instructor)
    $isSelfPaced = rand(1, 100) <= 80 ? 1 : 0;
    
    // Acak sertifikat (90% ada sertifikat)
    $hasCertificate = rand(1, 100) <= 90 ? 1 : 0;

    // Point 3 & 4: Acak program_id dan preview_video_url
    $randomProgramId = !empty($programIds) && rand(1,100) <= 50 ? $programIds[array_rand($programIds)] : null;
    $randomPreviewVideo = $dummyVideos[array_rand($dummyVideos)];

    $course->update([
        'hours_per_week' => $hoursStr,
        'start_date' => $startDate,
        'enroll_deadline' => $enrollDeadline,
        'is_self_paced' => $isSelfPaced,
        'has_certificate' => $hasCertificate,
        'program_id' => $randomProgramId,
        'preview_video_url' => $randomPreviewVideo
    ]);
    $count++;
}
echo "Berhasil memperbarui $count Kursus (Point 3, 4, dan Random Meta).\n";

// Point 2: Update Lessons
$lessonsCount = Lesson::count();
$chunkSize = 500;
$processedLessons = 0;

Lesson::chunkById($chunkSize, function ($lessons) use ($dummyVideos, &$processedLessons) {
    foreach ($lessons as $lesson) {
        $lesson->update([
            'video_url' => $dummyVideos[array_rand($dummyVideos)],
            'content' => '<p>Ini adalah konten deskripsi materi secara detail. Pada bagian ini, instruktur akan menjelaskan mengenai konsep dasar dari judul bab ini.</p><ul><li>Poin Penting 1</li><li>Poin Penting 2</li></ul>',
        ]);
        $processedLessons++;
    }
    echo "Memproses pelajaran... $processedLessons selesai.\n";
});

echo "Semua tugas selesai!\n";
