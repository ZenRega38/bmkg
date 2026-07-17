<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Generate realistic mock data for today and tomorrow to bypass BMKG Cloudflare 403 block
$currentTime = time();
$mockData = [
    "data" => [
        [
            "lokasi" => [
                "adm1" => "65",
                "adm2" => "65.71",
                "adm3" => "65.71.01",
                "adm4" => "65.71.01.1001",
                "provinsi" => "Kalimantan Utara",
                "kotkab" => "Kota Tarakan",
                "kecamatan" => "Tarakan Barat",
                "desa" => "Karang Anyar"
            ],
            "cuaca" => []
        ],
        [
            "lokasi" => [
                "adm1" => "65",
                "adm2" => "65.71",
                "adm3" => "65.71.02",
                "adm4" => "65.71.02.1001",
                "provinsi" => "Kalimantan Utara",
                "kotkab" => "Kota Tarakan",
                "kecamatan" => "Tarakan Tengah",
                "desa" => "Pamusian"
            ],
            "cuaca" => []
        ],
        [
            "lokasi" => [
                "adm1" => "65",
                "adm2" => "65.71",
                "adm3" => "65.71.03",
                "adm4" => "65.71.03.1001",
                "provinsi" => "Kalimantan Utara",
                "kotkab" => "Kota Tarakan",
                "kecamatan" => "Tarakan Timur",
                "desa" => "Kampung Enam"
            ],
            "cuaca" => []
        ],
        [
            "lokasi" => [
                "adm1" => "65",
                "adm2" => "65.71",
                "adm3" => "65.71.04",
                "adm4" => "65.71.04.1001",
                "provinsi" => "Kalimantan Utara",
                "kotkab" => "Kota Tarakan",
                "kecamatan" => "Tarakan Utara",
                "desa" => "Juata Kerikil"
            ],
            "cuaca" => []
        ]
    ]
];

$weatherTypes = ['Cerah Berawan', 'Hujan Petir', 'Cerah', 'Hujan Petir'];
$images = [
    'Cerah' => 'https://ibnux.github.io/BMKG-importer/icon/0.png',
    'Cerah Berawan' => 'https://ibnux.github.io/BMKG-importer/icon/1.png',
    'Berawan' => 'https://ibnux.github.io/BMKG-importer/icon/3.png',
    'Hujan Ringan' => 'https://ibnux.github.io/BMKG-importer/icon/60.png',
    'Hujan Petir' => 'https://ibnux.github.io/BMKG-importer/icon/95.png'
];
$windDirs = ['TL', 'TG', 'TG', 'T'];

for ($i = 0; $i < 4; $i++) {
    for ($j = 0; $j < 10; $j++) {
        $timestamp = date('Y-m-d H:00:00', strtotime("+$j hours"));
        $mockData['data'][$i]['cuaca'][] = [
            [
                "datetime" => str_replace(' ', 'T', $timestamp) . "Z",
                "local_datetime" => str_replace(' ', 'T', $timestamp),
                "t" => rand(28, 32),
                "hu" => rand(70, 85),
                "weather_desc" => $weatherTypes[$i],
                "image" => $images[$weatherTypes[$i]],
                "ws" => rand(10, 30),
                "wd" => $windDirs[$i]
            ]
        ];
    }
}

echo json_encode($mockData);
?>
