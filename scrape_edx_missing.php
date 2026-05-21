<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

echo "============================================\n";
echo "STEP 1: Membersihkan semua data junk...\n";
echo "============================================\n";

// Pola junk yang pasti bukan "what you'll learn" yang valid
$junkPatterns = [
    // Navigasi edX (sudah dibersihkan sebelumnya, pastikan bersih)
    'Learn Software Engineering', 'Learn Blockchain', 'Learn Computer Programming',
    'Learn Architecture', 'Learn Project Management', 'Learn Business Administration',
    'Become a Cybersecurity Analyst', 'Become a Data Scientist', 'Become a Social Media Manager',
    'Become a Software Developer', 'Become a Software Engineer',
    // Footer & CTA edX
    "Unlimited Access", "World class institutions", "Graded assessments", 
    "Earn a certificate", "Access Expires", "Increase your career opportunities",
    "Show off your hard work", "Course", "Executive Education",
    // Teks marketing/promo
    '84% of learners', '% of learners', 'learners report', 
    'That\'s a big deal', 'Let others know',
    // Item sangat pendek (1-2 kata tanpa makna)
];

// Hapus berdasarkan exact match
$deleted = DB::table('course_syllabus')->whereIn('item', $junkPatterns)->delete();
echo "Hapus exact match junk: $deleted baris\n";

// Hapus item yang mengandung pola marketing
$patternsLike = [
    'Bachelor\'s in%', 'Become a %', 'Master\'s in%',
    '%report more opportunities%', '%big deal%', '%Let others know%',
    '%career opportunities%', '% of learners%', 'Access Expires%',
];
$deletedLike = 0;
foreach ($patternsLike as $pattern) {
    $deletedLike += DB::table('course_syllabus')->where('item', 'like', $pattern)->delete();
}
echo "Hapus pattern-match junk: $deletedLike baris\n";

// Hapus items yang terlalu panjang (>300 chars, biasanya bukan bullet poin)
$deletedLong = DB::table('course_syllabus')->whereRaw('CHAR_LENGTH(item) > 300')->delete();
echo "Hapus item terlalu panjang: $deletedLong baris\n";

// Hapus course_id yang sekarang jadi kosong (tapi hapus juga course 1000 yang penuh junk campuran)
// Identifikasi courses dengan silabus yang mencurigakan: semua item berakhiran 'X' atau 'Course'
$coursesWithMixedJunk = DB::table('course_syllabus')
    ->whereIn('item', ['Course', 'Executive Education', 'HarvardX', 'MITx', 'GTx'])
    ->pluck('course_id')
    ->unique();
if ($coursesWithMixedJunk->isNotEmpty()) {
    $del = DB::table('course_syllabus')->whereIn('course_id', $coursesWithMixedJunk)->delete();
    echo "Hapus silabus campuran junk untuk " . $coursesWithMixedJunk->count() . " kursus ($del baris)\n";
}

$totalRemaining = DB::table('course_syllabus')->count();
echo "Sisa data di course_syllabus setelah bersih: $totalRemaining baris\n\n";

echo "============================================\n";
echo "STEP 2: Scraping silabus dari edX...\n";
echo "============================================\n";

// Ambil semua courses yang TIDAK punya silabus (termasuk yang baru dikosongkan)
$courses = DB::table('courses')
    ->whereNotIn('id', function($query) {
        $query->select('course_id')->from('course_syllabus')->distinct();
    })
    ->select('id', 'slug', 'title')
    ->get();

$total = $courses->count();
echo "Ditemukan $total kursus yang perlu silabus.\n\n";

$successCount = 0;
$failCount = 0;

foreach ($courses as $index => $course) {
    echo "[" . ($index + 1) . "/$total] {$course->slug} ... ";

    $teaches = null;

    // Strategy 1: Coba URL format lama /course/slug
    try {
        $response = Http::withoutVerifying()
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'])
            ->timeout(8)
            ->get('https://www.edx.org/course/' . $course->slug);

        if ($response->successful()) {
            $teaches = extractTeachesFromHtml($response->body());
        }
    } catch (\Exception $e) {
        // Coba strategy berikutnya
    }

    // Strategy 2: Coba search edX API (jika strategy 1 gagal)
    if (empty($teaches)) {
        try {
            $encodedTitle = urlencode($course->title);
            $apiResponse = Http::withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1)',
                    'Accept' => 'application/json',
                ])
                ->timeout(8)
                ->get("https://www.edx.org/api/catalog/v2/search/courses?q={$encodedTitle}&page=1&pageSize=3");

            if ($apiResponse->successful()) {
                $apiData = $apiResponse->json();
                if (!empty($apiData['hits']['hits'])) {
                    foreach ($apiData['hits']['hits'] as $hit) {
                        $src = $hit['_source'] ?? [];
                        if (!empty($src['skill_names'])) {
                            $teaches = array_values(array_unique($src['skill_names']));
                            break;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Gagal juga
        }
    }

    // Strategy 3: Coba URL format baru /learn dengan slug
    if (empty($teaches)) {
        try {
            $searchResp = Http::withoutVerifying()
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1)'])
                ->timeout(8)
                ->get('https://www.edx.org/search?q=' . urlencode($course->slug) . '&tab=course');

            if ($searchResp->successful()) {
                $teaches = extractTeachesFromHtml($searchResp->body());
            }
        } catch (\Exception $e) {
            // Gagal
        }
    }

    if (!empty($teaches)) {
        $inserts = [];
        foreach (array_values($teaches) as $i => $item) {
            $clean = trim(strip_tags($item));
            // Validasi: item harus lebih dari 3 karakter dan bukan junk marketing
            if (strlen($clean) > 3 && strlen($clean) <= 500 && !isJunk($clean)) {
                $inserts[] = [
                    'course_id'   => $course->id,
                    'item'        => $clean,
                    'order_index' => $i + 1,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
        }
        if (!empty($inserts)) {
            DB::table('course_syllabus')->insert($inserts);
            $successCount++;
            echo "BERHASIL (" . count($inserts) . " items)\n";
        } else {
            $failCount++;
            echo "GAGAL (items tidak valid setelah filter)\n";
        }
    } else {
        $failCount++;
        echo "GAGAL (tidak ada data dari edX)\n";
    }

    usleep(400000); // 0.4 detik jeda
}

echo "\n============================================\n";
echo "SELESAI!\n";
echo "Berhasil  : $successCount kursus\n";
echo "Gagal/Skip: $failCount kursus\n";
echo "============================================\n";

// ─── Helper functions ─────────────────────────────────────────────────

function extractTeachesFromHtml(string $html): array
{
    preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches);
    foreach ($matches[1] as $jsonStr) {
        $data = json_decode($jsonStr, true);
        if (!$data) continue;

        // Single object
        if (isset($data['@type']) && $data['@type'] === 'Course' && !empty($data['teaches'])) {
            return (array) $data['teaches'];
        }
        // Graph
        if (isset($data['@graph'])) {
            foreach ($data['@graph'] as $item) {
                if (isset($item['@type']) && $item['@type'] === 'Course' && !empty($item['teaches'])) {
                    return (array) $item['teaches'];
                }
            }
        }
    }
    return [];
}

function isJunk(string $item): bool
{
    $lc = strtolower($item);
    $junkKeywords = [
        "bachelor's", "master's", "become a", "unlimited access", "earn a certificate",
        "world class", "access expires", "career opportunities", "hardwork", "big deal",
        "let others know", "graded assessments", "% of learners",
    ];
    foreach ($junkKeywords as $kw) {
        if (str_contains($lc, $kw)) return true;
    }
    return false;
}
