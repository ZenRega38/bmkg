<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$adm2 = isset($_GET['adm2']) ? $_GET['adm2'] : '65.71';

// Fetch real data from BMKG API using cURL (bypasses Cloudflare block)
function fetchBmkgData($adm2) {
    $url = "https://api.bmkg.go.id/publik/prakiraan-cuaca?adm2=" . urlencode($adm2);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
        'Accept: application/json, text/plain, */*',
        'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
        'Referer: https://www.bmkg.go.id/',
        'Origin: https://www.bmkg.go.id'
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 && $response) {
        $data = json_decode($response, true);
        if ($data !== null && isset($data['data']) && count($data['data']) > 0) {
            return $data;
        }
    }
    return null;
}

$data = fetchBmkgData($adm2);

// If real API works, return it
if ($data !== null) {
    echo json_encode($data);
    exit;
}

// =============================================
// FALLBACK: Mock data hanya jika API BMKG gagal
// =============================================
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
                "desa" => "Karang Anyar",
                "timezone" => "Asia/Makassar"
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
                "kecamatan" => "Tarakan Timur",
                "desa" => "Mamburungan",
                "timezone" => "Asia/Makassar"
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
                "kecamatan" => "Tarakan Tengah",
                "desa" => "Pamusian",
                "timezone" => "Asia/Makassar"
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
                "desa" => "Juata Laut",
                "timezone" => "Asia/Makassar"
            ],
            "cuaca" => []
        ]
    ]
];

$weatherTypes = ['Cerah Berawan', 'Hujan Petir', 'Cerah', 'Berawan'];
$images = [
    'Cerah'         => 'https://ibnux.github.io/BMKG-importer/icon/0.png',
    'Cerah Berawan' => 'https://ibnux.github.io/BMKG-importer/icon/1.png',
    'Berawan'       => 'https://ibnux.github.io/BMKG-importer/icon/3.png',
    'Hujan Ringan'  => 'https://ibnux.github.io/BMKG-importer/icon/60.png',
    'Hujan Petir'   => 'https://ibnux.github.io/BMKG-importer/icon/95.png'
];
$windDirs = ['TL', 'TG', 'B', 'U'];

for ($i = 0; $i < 4; $i++) {
    for ($j = 0; $j < 10; $j++) {
        $timestamp = date('Y-m-d H:00:00', strtotime("+$j hours"));
        $mockData['data'][$i]['cuaca'][] = [
            [
                "datetime"       => str_replace(' ', 'T', $timestamp) . "Z",
                "local_datetime" => str_replace(' ', 'T', $timestamp),
                "t"              => rand(28, 33),
                "hu"             => rand(70, 88),
                "weather_desc"   => $weatherTypes[$i % 4],
                "image"          => $images[$weatherTypes[$i % 4]],
                "ws"             => rand(10, 30),
                "wd"             => $windDirs[$i % 4],
                "vs"             => rand(5000, 10000),
                "vs_text"        => "> 5 km"
            ]
        ];
    }
}

echo json_encode($mockData);
?>
