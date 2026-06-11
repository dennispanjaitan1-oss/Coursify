<?php
// Hapus file ini setelah berhasil!
$publicPath  = __DIR__ . '/public';
$storagePath = __DIR__ . '/storage/app/public';
$linkPath    = $publicPath . '/storage';

if (!file_exists($linkPath)) {
    // Coba symlink
    $target = $storagePath;
    // Di Windows pakai junction, di Linux pakai symlink
    if (PHP_OS_FAMILY === 'Windows') {
        exec('mklink /J "' . $linkPath . '" "' . $target . '"');
        echo "✅ Junction (Windows symlink) dibuat!";
    } else {
        if (@symlink($target, $linkPath)) {
            echo "✅ Symlink berhasil: public/storage → storage/app/public";
        } else {
            echo "❌ Gagal. Jalankan manual via SSH/FTP:<br>";
            echo '<code>ln -s ' . $target . ' ' . $linkPath . '</code>';
        }
    }
} else {
    echo "ℹ️ Symlink sudah ada.";
}
