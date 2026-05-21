<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$q = urlencode('site:edx.org "Rhetoric: The Art of Persuasive Writing and Public Speaking"');
$url = 'https://html.duckduckgo.com/html/?q=' . $q;
$resp = Http::withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'])->get($url);
preg_match_all('/<a class="result__url" href="(.*?)"/', $resp->body(), $matches);
print_r($matches[1]);
