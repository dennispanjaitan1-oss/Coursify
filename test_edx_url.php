<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

// Test URL format baru edX
$institutionSlug = preg_replace('/-\d+$/', '', 'harvard-university-51'); // 'harvard-university'
$courseSlug = 'rhetoric-the-art-of-persuasive-writing-and-public-speaking';

// Format 1: /learn/{institution}/{institution}-{course}
$urls = [
    "https://www.edx.org/learn/{$institutionSlug}/{$institutionSlug}-{$courseSlug}",
    "https://www.edx.org/learn/writing/{$institutionSlug}-{$courseSlug}",
    "https://www.edx.org/learn/communication/{$institutionSlug}-{$courseSlug}",
];

foreach ($urls as $url) {
    echo "Mencoba: {$url}\n";
    try {
        $resp = Http::withoutVerifying()
            ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1)'])
            ->timeout(8)
            ->get($url);
        echo "Status: " . $resp->status() . "\n";
        if ($resp->successful()) {
            preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $resp->body(), $m);
            foreach ($m[1] as $j) {
                $d = json_decode($j, true);
                if (isset($d['@graph'])) {
                    foreach ($d['@graph'] as $item) {
                        if (isset($item['teaches'])) {
                            echo "TEACHES: " . json_encode($item['teaches']) . "\n";
                            break 3;
                        }
                    }
                }
            }
        }
    } catch (\Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

// Also test edX discovery API
echo "Test Discovery API:\n";
$title = urlencode('Rhetoric: The Art of Persuasive Writing and Public Speaking');
$apiUrl = "https://discovery.edx.org/api/v1/search/all/?q={$title}&content_type[]=course&page_size=2";
echo "URL: {$apiUrl}\n";
try {
    $resp = Http::withoutVerifying()
        ->withHeaders(['Accept' => 'application/json', 'User-Agent' => 'Mozilla/5.0'])
        ->timeout(8)
        ->get($apiUrl);
    echo "Status: " . $resp->status() . "\n";
    if ($resp->successful()) {
        $data = $resp->json();
        echo "Count: " . ($data['count'] ?? 0) . "\n";
        if (!empty($data['results'])) {
            $first = $data['results'][0];
            echo "First result: " . ($first['title'] ?? 'N/A') . "\n";
            echo "URL: " . ($first['marketing_url'] ?? 'N/A') . "\n";
            echo "Skills: " . json_encode($first['skill_names'] ?? []) . "\n";
            echo "Expected: " . json_encode($first['expected_learning_items'] ?? []) . "\n";
        }
    } else {
        echo "Body: " . substr($resp->body(), 0, 300) . "\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
