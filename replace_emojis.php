<?php

$file = 'c:\laragon\www\coursify\resources\views\student\profile.blade.php';
$content = file_get_contents($file);

$replacements = [
    '👤' => '<i class="fa-regular fa-user"></i>',
    '🔒' => '<i class="fa-solid fa-lock"></i>',
    '🔔' => '<i class="fa-regular fa-bell"></i>',
    '🎨' => '<i class="fa-solid fa-palette"></i>',
    '💳' => '<i class="fa-regular fa-credit-card"></i>',
    '📷' => '<i class="fa-solid fa-camera"></i>',
    '⚙️' => '<i class="fa-solid fa-gear"></i>',
    '👨‍🏫' => '<i class="fa-solid fa-chalkboard-user"></i>',
    '🎓' => '<i class="fa-solid fa-graduation-cap"></i>',
    '🌐' => '<i class="fa-solid fa-globe"></i>',
    '💾' => '<i class="fa-solid fa-floppy-disk"></i>',
    '🔑' => '<i class="fa-solid fa-key"></i>',
    '👁' => '<i class="fa-regular fa-eye"></i>',
    '🔐' => '<i class="fa-regular fa-eye-slash"></i>',
    '🛡️' => '<i class="fa-solid fa-shield-halved"></i>',
    '🗑️' => '<i class="fa-solid fa-trash-can"></i>',
    '📧' => '<i class="fa-regular fa-envelope"></i>',
    '⚠' => '<i class="fa-solid fa-triangle-exclamation"></i>'
];

foreach ($replacements as $emoji => $fa) {
    $content = str_replace($emoji, $fa, $content);
}

// Fix alignment issues with icons
// E.g., make sure buttons with FA icons have gap if they didn't before.
// We can just rely on existing CSS gap or add a space. The FA icons usually render fine.

file_put_contents($file, $content);
echo "Berhasil mengganti emoji menjadi Font Awesome.";
