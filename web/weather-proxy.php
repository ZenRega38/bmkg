<?php
/**
 * BMKG Tarakan - Secure Weather Radar Tile Proxy
 * Prevents exposing the OpenWeatherMap API Key in client-side JavaScript.
 */

// Basic input validation
$z = isset($_GET['z']) ? intval($_GET['z']) : 0;
$x = isset($_GET['x']) ? intval($_GET['x']) : 0;
$y = isset($_GET['y']) ? intval($_GET['y']) : 0;

$apiKey = 'f1749350b540a2ca3c0b6a869d96894e';
$targetUrl = "https://tile.openweathermap.org/map/precipitation_new/{$z}/{$x}/{$y}.png?appid={$apiKey}";

// Set caching headers to optimize performance and reduce API hits
$cacheTime = 600; // 10 minutes cache
header("Content-Type: image/png");
header("Cache-Control: public, max-age={$cacheTime}");
header("Pragma: cache");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + $cacheTime) . " GMT");

// Fetch image via cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $targetUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$imageData = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Output the image or fallback to transparent tile
if ($httpCode === 200 && $imageData) {
    echo $imageData;
} else {
    // Return a 1x1 transparent PNG fallback if the API fails
    echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=');
}
?>
