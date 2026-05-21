<?php
$url = 'https://windows.php.net/downloads/releases/php-8.2.20-Win32-vs16-x64.zip';
$zipPath = 'C:/laragon/bin/php/php-8.2.20.zip';
$destPath = 'C:/laragon/bin/php/php-8.2.20-Win32-vs16-x64';

echo "Downloading PHP 8.2.20 (30MB)... Please wait.\n";
$ch = curl_init($url);
$fp = fopen($zipPath, 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_exec($ch);
curl_close($ch);
fclose($fp);

echo "Extracting PHP 8.2.20...\n";
if (!is_dir($destPath)) {
    mkdir($destPath, 0777, true);
}
$zip = new ZipArchive;
if ($zip->open($zipPath) === TRUE) {
    $zip->extractTo($destPath);
    $zip->close();
    echo "Extracted successfully!\n";
} else {
    echo "Failed to extract zip!\n";
}

if (file_exists($zipPath)) {
    unlink($zipPath);
}
echo "PHP 8.2.20 successfully installed in Laragon!\n";
