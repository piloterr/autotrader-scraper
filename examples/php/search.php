<?php
// Autotrader Search API – PHP example (ext-curl)
// Usage: PILOTERR_API_KEY=your-key php search.php

$params = http_build_query([
    'query' => 'https://www.autotrader.co.uk/car-search?channel=cars&postcode=W1F%208EB&price_search_type=total&sort=relevance&page=1',
]);

$ch = curl_init('https://api.piloterr.com/v2/autotrader/search?' . $params);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_HTTPHEADER => ['x-api-key: ' . getenv('PILOTERR_API_KEY')],
]);

$body = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($status !== 200) {
    fwrite(STDERR, "Piloterr error $status: $body\n");
    exit(1);
}

$data = json_decode($body, true);
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), PHP_EOL;
