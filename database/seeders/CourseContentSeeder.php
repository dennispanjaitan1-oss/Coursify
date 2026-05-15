<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseContentSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        
        // Ambil kursus yang belum punya section
        $courses = Course::doesntHave('sections')->get();

        foreach ($courses as $course) {
            // 1. Buat beberapa Section (misal 3 section per kursus)
            $topics = ['Introduction', 'Core Concepts', 'Advanced Modules', 'Final Project'];
            
            foreach ($topics as $index => $topic) {
    $section = $course->sections()->create([
        'title' => $topic . " to " . $course->title,
        'order_index' => $index + 1
    ]);

    for ($i = 1; $i <= 3; $i++) {
        $lessonTitle = $this->generateLessonTitle($course->title, $topic, $i);
        
        \App\Models\Lesson::create([
            'section_id'       => $section->id,
            'title'            => $lessonTitle,
            'type'             => 'video', // Sesuai enum di modelmu
            'video_url'        => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Link dummy
            'content'          => $this->generateDummyContent($course->title, $lessonTitle),
            'duration_seconds' => rand(300, 1200), // Kita ganti ke detik (5-20 menit)
            'order_index'      => $i,
            'is_free_preview'  => ($index == 0 && $i == 1), // Sesuai nama kolom di modelmu
        ]);
    }
}
        }
    }

    // Fungsi pembantu untuk membuat judul materi yang nyambung
    private function generateLessonTitle($courseTitle, $topic, $num)
    {
        $prefixes = ['Understanding', 'Mastering', 'Deep Dive into', 'Practical Guide to'];
        return $prefixes[array_rand($prefixes)] . " " . $courseTitle . " (Part $num)";
    }

    // Fungsi pembantu untuk membuat isi konten yang terlihat niat
    private function generateDummyContent($courseTitle, $lessonTitle)
    {
        return "<h3>Welcome to $lessonTitle</h3>" .
               "<p>In this lesson, we will explore the fundamentals of <strong>$courseTitle</strong>.</p>" .
               "<p>Topics covered include best practices, common mistakes, and industry standards related to this field.</p>" .
               "<ul><li>Key Concept 1</li><li>Key Concept 2</li><li>Implementation Strategy</li></ul>";
    }
}