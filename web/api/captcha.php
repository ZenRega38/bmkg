<?php
session_start();

// Buat kode acak 5 karakter
$characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$captcha_code = '';
for ($i = 0; $i < 5; $i++) {
    $captcha_code .= $characters[rand(0, strlen($characters) - 1)];
}
$_SESSION['captcha_code'] = $captcha_code;

// Set header sebagai file SVG
header('Content-Type: image/svg+xml');
header('Cache-Control: no-cache, must-revalidate');

$width = 150;
$height = 50;

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<svg xmlns="http://www.w3.org/2000/svg" width="'.$width.'" height="'.$height.'" viewBox="0 0 '.$width.' '.$height.'">';

// Background
echo '<rect width="'.$width.'" height="'.$height.'" fill="#f4f7f6" />';

// Garis-garis noise
for ($i = 0; $i < 10; $i++) {
    $x1 = rand(0, $width); $y1 = rand(0, $height);
    $x2 = rand(0, $width); $y2 = rand(0, $height);
    echo '<line x1="'.$x1.'" y1="'.$y1.'" x2="'.$x2.'" y2="'.$y2.'" stroke="#96aac8" stroke-width="2" opacity="0.6"/>';
}

// Titik-titik noise
for ($i = 0; $i < 30; $i++) {
    $cx = rand(0, $width); $cy = rand(0, $height);
    $r = rand(1, 3);
    echo '<circle cx="'.$cx.'" cy="'.$cy.'" r="'.$r.'" fill="#96aac8" opacity="0.8"/>';
}

// Tulisan Teks Kode
$x = 20;
for ($i = 0; $i < 5; $i++) {
    $y = 35 + rand(-4, 4);
    $rot = rand(-15, 15); // Kemiringan teks
    echo '<text x="'.$x.'" y="'.$y.'" font-family="monospace, Arial" font-size="28" font-weight="bold" fill="#1e3c72" transform="rotate('.$rot.' '.$x.' '.$y.')">'.$captcha_code[$i].'</text>';
    $x += 24;
}

echo '</svg>';
?>
