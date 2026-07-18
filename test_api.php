<?php
$json_data = file_get_contents('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm1=65');
$dataCuaca = json_decode($json_data, true);
$citiesData = [];
foreach ($dataCuaca['data'] as $location_data) {
    $kotkab = isset($location_data['lokasi']['kotkab']) ? $location_data['lokasi']['kotkab'] : 'N/A';
    if (!isset($citiesData[$kotkab]) && $kotkab !== 'N/A') {
        $citiesData[$kotkab] = $location_data['lokasi']['adm2'];
    }
}
print_r($citiesData);
?>
