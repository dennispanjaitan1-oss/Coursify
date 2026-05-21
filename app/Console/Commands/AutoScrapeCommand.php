<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use DOMDocument;
use DOMXPath;

class AutoScrapeCommand extends Command
{
    protected $signature = 'coursify:auto-scrape {course_id?} {--limit=5}';
    protected $description = 'Otomatis mencari URL edX dan men-scrape deskripsi serta kurikulum untuk kursus';

    public function handle()
    {
        $courseId = $this->argument('course_id');
        $limit = $this->option('limit');

        if ($courseId) {
            $courses = Course::where('id', $courseId)->get();
        } else {
            $courseIdsWithSyllabus = DB::table('course_syllabus')->select('course_id')->distinct()->pluck('course_id');
            $courses = Course::whereNull('description')
                ->orWhereNotIn('id', $courseIdsWithSyllabus)
                ->limit($limit)
                ->get();
                
            // Safe fallback if scope doesn't exist
            if ($courses->isEmpty()) {
                // Get courses that have 0 syllabus items
                $courseIdsWithSyllabus = DB::table('course_syllabus')->select('course_id')->distinct()->pluck('course_id');
                $courses = Course::whereNotIn('id', $courseIdsWithSyllabus)->limit($limit)->get();
            }
        }

        if ($courses->isEmpty()) {
            $this->info("Tidak ada kursus yang perlu di-scrape.");
            return;
        }

        $this->info("Memulai proses scraping untuk " . $courses->count() . " kursus...");

        foreach ($courses as $course) {
            $this->info("\n=============================================");
            $this->info("Mencari: {$course->title} (ID: {$course->id})");

            $edxUrl = $this->findEdxUrl($course->title);
            if (!$edxUrl) {
                $this->error("URL edX tidak ditemukan untuk kursus ini.");
                continue;
            }

            $this->info("Ditemukan URL: $edxUrl");
            $this->scrapeEdxCourse($course, $edxUrl);
            
            // Random delay to avoid getting blocked too quickly
            $sleep = rand(2, 5);
            $this->info("Menunggu $sleep detik agar tidak diblokir...");
            sleep($sleep);
        }
        
        $this->info("\nProses scraping selesai!");
    }

    private function findEdxUrl($title)
    {
        $query = urlencode('site:edx.org ' . $title);
        $url = 'https://html.duckduckgo.com/html/?q=' . $query;

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.5',
            ])->get($url);

            if ($response->successful()) {
                $html = $response->body();
                // Extract first edX URL from duckduckgo result
                if (preg_match('/class="result__url" href="([^"]+)"/', $html, $matches)) {
                    $foundUrl = htmlspecialchars_decode($matches[1]);
                    // DuckDuckGo sometimes prepends their own redirect, clean it:
                    if (strpos($foundUrl, 'uddg=') !== false) {
                        preg_match('/uddg=([^&]+)/', $foundUrl, $uddgMatch);
                        if (isset($uddgMatch[1])) {
                            return urldecode($uddgMatch[1]);
                        }
                    }
                    return $foundUrl;
                }
                
                // Alternative pattern
                if (preg_match('/href="(\/\/duckduckgo\.com\/l\/\?uddg=[^"]+)"/', $html, $matches)) {
                    $foundUrl = htmlspecialchars_decode($matches[1]);
                    preg_match('/uddg=([^&]+)/', $foundUrl, $uddgMatch);
                    if (isset($uddgMatch[1])) {
                        return urldecode($uddgMatch[1]);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error("Error mencari di DuckDuckGo: " . $e->getMessage());
        }

        return null;
    }

    private function scrapeEdxCourse($course, $url)
    {
        $this->info("Sedang men-scrape halaman edX...");
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.5',
            ])->get($url);

            if ($response->status() === 403 || $response->status() === 404) {
                $this->error("Gagal! Diblokir oleh edX (403) atau Halaman tidak ada (404). Status: " . $response->status());
                return;
            }

            $html = $response->body();
            
            // Bypass PHP warning for malformed HTML
            libxml_use_internal_errors(true);
            $dom = new DOMDocument();
            $dom->loadHTML($html);
            $xpath = new DOMXPath($dom);

            // 1. Ekstrak Deskripsi (About this course)
            // edX structure changes frequently. We'll try some common selectors.
            $descNode = $xpath->query('//div[contains(@class, "about-this-course")]/div')->item(0);
            if (!$descNode) {
                // Try another common one
                $descNode = $xpath->query('//div[@id="about-this-course"]')->item(0);
            }
            if (!$descNode) {
                // Fallback looking for paragraph after h2 'About this course'
                $descNode = $xpath->query('//h2[contains(text(), "About this course")]/following-sibling::div')->item(0);
            }

            if ($descNode) {
                $descText = trim($descNode->textContent);
                // Remove excess whitespace
                $descText = preg_replace('/\s+/', ' ', $descText);
                $course->description = $descText;
                $course->save();
                $this->info("✅ Deskripsi berhasil diupdate.");
            } else {
                $this->warn("⚠️ Deskripsi tidak ditemukan di struktur HTML ini.");
            }

            // 2. Ekstrak Silabus / What you'll learn
            $syllabusItems = [];
            $learningNodes = $xpath->query('//div[contains(@class, "what-you-will-learn")]//li');
            
            if ($learningNodes->length == 0) {
                // Try alternate selector
                $learningNodes = $xpath->query('//h2[contains(text(), "What you\'ll learn") or contains(text(), "What you will learn")]/following-sibling::ul//li');
            }

            if ($learningNodes->length > 0) {
                foreach ($learningNodes as $node) {
                    $text = trim($node->textContent);
                    $text = preg_replace('/\s+/', ' ', $text);
                    if (!empty($text)) {
                        $syllabusItems[] = $text;
                    }
                }
            }

            if (!empty($syllabusItems)) {
                // Hapus data lama
                DB::table('course_syllabus')->where('course_id', $course->id)->delete();
                
                // Insert data baru
                $insertData = [];
                foreach ($syllabusItems as $index => $item) {
                    $insertData[] = [
                        'course_id' => $course->id,
                        'item' => $item,
                        'order_index' => $index + 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('course_syllabus')->insert($insertData);
                $this->info("✅ Berhasil menyimpan " . count($syllabusItems) . " baris silabus.");
            } else {
                $this->warn("⚠️ Silabus (What you'll learn) tidak ditemukan di HTML.");
            }

        } catch (\Exception $e) {
            $this->error("Error saat men-scrape: " . $e->getMessage());
        }
    }
}
