<?php
$wmagzFile = __DIR__ . '/assets/json/data-wmagz.json';
$latestMagazines = [];
if (file_exists($wmagzFile)) {
    $wmagzJson = json_decode(file_get_contents($wmagzFile), true);
    if ($wmagzJson && isset($wmagzJson['magazines'])) {
        foreach ($wmagzJson['magazines'] as $year => $months) {
            foreach ($months as $month => $item) {
                $item['_timestamp'] = strtotime("1 $month $year");
                $latestMagazines[] = $item;
            }
        }
    }
}
usort($latestMagazines, function($a, $b) {
    return $b['_timestamp'] <=> $a['_timestamp'];
});
foreach ($latestMagazines as $mag) {
    echo $mag['title'] . " - Timestamp: " . $mag['_timestamp'] . "\n";
}
?>
