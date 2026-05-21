<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$junkItems = [
    "Learn Software Engineering",
    "Learn Blockchain",
    "Learn Computer Programming",
    "Learn Architecture",
    "Learn Project Management",
    "Learn Business Administration",
    "Become a Cybersecurity Analyst",
    "Become a Data Scientist",
    "Become a Social Media Manager",
    "Become a Software Developer",
    "Become a Software Engineer",
    "Bachelor's in Business",
    "Bachelor's in Computer Science / Data Science",
    "Bachelor's in Health and Nursing",
    "Bachelor's in Accounting",
    "Bachelor's in Computer Science \/ Data Science"
];

$deletedCount = DB::table('course_syllabus')->whereIn('item', $junkItems)->delete();
$deletedCount += DB::table('course_syllabus')->where('item', 'like', 'Bachelor\'s in%')->delete();
$deletedCount += DB::table('course_syllabus')->where('item', 'like', 'Become a %')->delete();

echo "Pembersihan selesai! Menghapus $deletedCount baris data silabus yang nyasar (junk).\n";
