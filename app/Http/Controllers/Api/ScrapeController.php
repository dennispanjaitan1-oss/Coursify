<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScrapeController extends Controller
{
    private function sanitizeUtf8(mixed $value): mixed
    {
        if (is_string($value)) {
            return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        }
        if (is_array($value)) {
            return array_map(fn($v) => $this->sanitizeUtf8($v), $value);
        }
        return $value;
    }

    public function next()
    {
        $course = Course::whereNull('scraped_at')->first();

        if (!$course) {
            return response()->json(['status' => 'done']);
        }

        return response()->json([
            'status' => 'ok',
            'course' => [
                'id'    => $course->id,
                'title' => $course->title,
            ]
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'course_id'          => 'required|exists:courses,id',
            'description'        => 'nullable|string',
            'short_description'  => 'nullable|string',
            'syllabus'           => 'nullable|array',
            'language'           => 'nullable|string|max:100',
            'effort'             => 'nullable|string|max:100',
            'price'              => 'nullable|string|max:50',
            'instructors'        => 'nullable|array',
            'transcripts'        => 'nullable|array',
            'content_translation'=> 'nullable|array',
            'prerequisites'      => 'nullable|string',
            'difficulty'         => 'nullable|string|max:50',
            'is_self_paced'      => 'nullable|boolean',
            'start_date'         => 'nullable|string',
            'end_date'           => 'nullable|string',
            'edx_url'            => 'nullable|string|max:500',
        ]);

        $request->replace($this->sanitizeUtf8($request->all()));

        $course = Course::find($request->course_id);

        // ── edX URL ───────────────────────────────────────────────────
        if ($request->filled('edx_url')) {
            $course->edx_url = $request->edx_url;
        }

        // ── Description ───────────────────────────────────────────────
        if ($request->filled('description')) {
            $course->description = $request->description;
        }

        // ── Short Description ─────────────────────────────────────────
        if ($request->filled('short_description')) {
            $short = trim($request->short_description);
            if (strtolower($short) !== strtolower($course->title)) {
                $course->short_description = $short;
            }
        }

        // ── Language ──────────────────────────────────────────────────
        if ($request->filled('language')) {
            $langMap = [
                'english'    => 'en', 'spanish'    => 'es', 'french'     => 'fr',
                'german'     => 'de', 'chinese'    => 'zh', 'arabic'     => 'ar',
                'portuguese' => 'pt', 'hindi'      => 'hi', 'japanese'   => 'ja',
                'korean'     => 'ko', 'italian'    => 'it', 'russian'    => 'ru',
                'turkish'    => 'tr', 'indonesian' => 'id',
                'espanol'    => 'es', 'frances'    => 'fr', 'aleman'     => 'de',
                'portugues'  => 'pt', 'deutsch'    => 'de', 'italiano'   => 'it',
                'francais'   => 'fr', 'japonais'   => 'ja', 'chinois'    => 'zh',
            ];
            $langRaw   = trim($request->language);
            $langAscii = strtolower(preg_replace('/[^a-zA-Z ]/', '', iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $langRaw)));
            $langAscii = trim($langAscii);
            if (isset($langMap[$langAscii])) {
                $course->language = $langMap[$langAscii];
            }
        }

        // ── Effort → duration_weeks & hours_per_week ──────────────────
        if ($request->filled('effort')) {
            $effortRaw = trim($request->effort);
            if (preg_match('/(\d+)\s*[-–]\s*(\d+)\s*weeks?/i', $effortRaw, $m)) {
                $course->duration_weeks = (int) round(((int)$m[1] + (int)$m[2]) / 2);
            } elseif (preg_match('/(\d+)\s*weeks?/i', $effortRaw, $m)) {
                $course->duration_weeks = (int) $m[1];
            } elseif (preg_match('/(\d+)\s*months?/i', $effortRaw, $m)) {
                $course->duration_weeks = (int) $m[1] * 4;
            }
            if (preg_match('/([\d]+[-–][\d]+|\d+)\s*hours?\s*per\s*week/i', $effortRaw, $m)) {
                $course->hours_per_week = $m[1];
            }
        }

        // ── Price ─────────────────────────────────────────────────────
        if ($request->filled('price')) {
            $priceRaw = trim($request->price);
            if (strtolower($priceRaw) === 'free' || $priceRaw === '0') {
                $course->price = 0.00;
                $course->has_audit_track = true;
                $course->currency = 'USD';
            } else {
                $priceClean = preg_replace('/[^0-9.]/', '', $priceRaw);
                if (is_numeric($priceClean) && (float)$priceClean > 0) {
                    $course->price = (float) $priceClean;
                    $course->certificate_price = (float) $priceClean;
                    $course->has_audit_track = true;
                    $course->currency = 'USD';
                }
            }
        }

        // ── Transcripts ───────────────────────────────────────────────
        if ($request->has('transcripts') && is_array($request->transcripts)) {
            $course->transcripts = implode(', ', $request->transcripts);
        }

        // ── Content Translation ───────────────────────────────────────
        if ($request->has('content_translation') && is_array($request->content_translation)) {
            $course->translations = implode(', ', $request->content_translation);
        }

        // ── Prerequisites ─────────────────────────────────────────────
        if ($request->filled('prerequisites') &&
            strtolower(trim($request->prerequisites)) !== 'none' &&
            strtolower(trim($request->prerequisites)) !== 'none.') {
            $course->prerequisites = $request->prerequisites;
        }

        // ── Difficulty ────────────────────────────────────────────────
        if ($request->filled('difficulty')) {
            $course->difficulty = $request->difficulty;
        }

        // ── Is Self Paced ─────────────────────────────────────────────
        if ($request->has('is_self_paced')) {
            $course->is_self_paced = $request->boolean('is_self_paced');
        }

        // ── Start Date & End Date ─────────────────────────────────────
        if ($request->filled('start_date')) {
            try { $course->start_date = \Carbon\Carbon::parse($request->start_date); } catch (\Exception $e) {}
        }
        if ($request->filled('end_date')) {
            try { $course->enroll_deadline = \Carbon\Carbon::parse($request->end_date); } catch (\Exception $e) {}
        }

        // ── Tandai sudah di-scrape ────────────────────────────────────
        $course->scraped_at = now();
        $course->save();

        // ── Syllabus ──────────────────────────────────────────────────
        if ($request->has('syllabus') && is_array($request->syllabus) && count($request->syllabus) > 0) {
            DB::table('course_syllabus')->where('course_id', $course->id)->delete();
            $insertData = [];
            foreach ($request->syllabus as $index => $item) {
                $insertData[] = [
                    'course_id'   => $course->id,
                    'item'        => $item,
                    'order_index' => $index + 1,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }
            DB::table('course_syllabus')->insert($insertData);
        }

        // ── Curriculum ────────────────────────────────────────────────
        if ($request->has('curriculum') && is_array($request->curriculum) && count($request->curriculum) > 0) {
            DB::table('sections')->where('course_id', $course->id)->delete();
            foreach ($request->curriculum as $secData) {
                $sectionId = DB::table('sections')->insertGetId([
                    'course_id'   => $course->id,
                    'title'       => $secData['title'],
                    'order_index' => $secData['order_index'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
                if (!empty($secData['lessons'])) {
                    $lessons = [];
                    foreach ($secData['lessons'] as $lesData) {
                        if (strlen($lesData['title']) > 150) continue;
                        $lessons[] = [
                            'section_id'  => $sectionId,
                            'title'       => $lesData['title'],
                            'type'        => 'video',
                            'order_index' => $lesData['order_index'],
                            'created_at'  => now(),
                            'updated_at'  => now(),
                        ];
                    }
                    if (count($lessons) > 0) {
                        DB::table('lessons')->insert($lessons);
                    }
                }
            }
        } else {
            $alreadyMarked = DB::table('course_syllabus')->where('course_id', $course->id)->exists();
            if (!$alreadyMarked) {
                DB::table('course_syllabus')->insert([
                    'course_id'   => $course->id,
                    'item'        => 'Syllabus not available on edX.',
                    'order_index' => 1,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        // ── Instructors (dengan photo_url & institution_logo_url) ─────
        if ($request->has('instructors') && is_array($request->instructors) && count($request->instructors) > 0) {
            DB::table('instructors')->where('course_id', $course->id)->delete();
            $instructorsData = [];
            foreach ($request->instructors as $instructor) {
                if (empty($instructor['name'])) continue;

                $photoUrl = null;
                if (!empty($instructor['photo_url'])) {
                    $url = trim($instructor['photo_url']);
                    if (filter_var($url, FILTER_VALIDATE_URL) && strlen($url) > 10) {
                        $photoUrl = $url;
                    }
                }

                $logoUrl = null;
                if (!empty($instructor['institution_logo_url'])) {
                    $url = trim($instructor['institution_logo_url']);
                    if (filter_var($url, FILTER_VALIDATE_URL) && strlen($url) > 10) {
                        $logoUrl = $url;
                    }
                }

                $instructorsData[] = [
                    'course_id'            => $course->id,
                    'name'                 => $instructor['name'],
                    'title'                => $instructor['title'] ?? null,
                    'photo_url'            => $photoUrl,
                    'institution_logo_url' => $logoUrl,
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ];
            }
            if (count($instructorsData) > 0) {
                DB::table('instructors')->insert($instructorsData);
            }
        }

        return response()->json(['status' => 'success']);
    }
}