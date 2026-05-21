<?php
$file = fopen('database/data/csv/subject_courses.csv', 'r');
$header = fgetcsv($file);
$courseIds = [];
$sample = [];
while (($row = fgetcsv($file)) !== false) {
    $cid = $row[0];
    if (!isset($courseIds[$cid])) {
        $courseIds[$cid] = 0;
        if (count($sample) < 5) {
            $sample[$cid] = $row[1];
        }
    }
    $courseIds[$cid]++;
}
fclose($file);
echo "Total unique course_ids: " . count($courseIds) . "\n";
echo "Sample mappings:\n";
foreach ($sample as $cid => $item) {
    echo "Course ID $cid -> $item\n";
}
