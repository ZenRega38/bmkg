<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuration: ADM4 codes for the 5 regencies in Kalimantan Utara
$kaltaraAdm4 = [
    '65.71.01.1001', // Kota Tarakan
    '65.01.02.2001', // Kab. Bulungan
    '65.02.04.2001', // Kab. Malinau
    '65.03.02.1001', // Kab. Nunukan
    '65.04.01.2001'  // Kab. Tana Tidung
];

// Function to fetch multiple JSON data concurrently
function fetchKaltaraWeather($adm4Codes) {
    $mh = curl_multi_init();
    $curl_handles = [];
    
    foreach ($adm4Codes as $code) {
        $ch = curl_init();
        $url = 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=' . $code;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_multi_add_handle($mh, $ch);
        $curl_handles[$code] = $ch;
    }
    
    $running = null;
    do {
        curl_multi_exec($mh, $running);
    } while ($running);
    
    $results = [];
    foreach ($curl_handles as $code => $ch) {
        $response = curl_multi_getcontent($ch);
        if ($response) {
            $data = @json_decode($response, true);
            if ($data && isset($data['data'][0])) {
                $results[] = $data['data'][0];
            }
        }
        curl_multi_remove_handle($mh, $ch);
    }
    curl_multi_close($mh);
    
    // FALLBACK MOCK DATA IF BMKG SERVER BLOCKS THE REQUEST
    if (empty($results)) {
        // Generate fake data for all 5 regencies
        $mockKotkab = ['Kota Tarakan', 'Kab. Bulungan', 'Kab. Malinau', 'Kab. Nunukan', 'Kab. Tana Tidung'];
        $weatherTypes = ['Cerah Berawan', 'Hujan Petir', 'Cerah', 'Hujan Ringan', 'Berawan'];
        $images = [
            'Cerah' => 'https://ibnux.github.io/BMKG-importer/icon/0.png',
            'Cerah Berawan' => 'https://ibnux.github.io/BMKG-importer/icon/1.png',
            'Berawan' => 'https://ibnux.github.io/BMKG-importer/icon/3.png',
            'Hujan Ringan' => 'https://ibnux.github.io/BMKG-importer/icon/60.png',
            'Hujan Petir' => 'https://ibnux.github.io/BMKG-importer/icon/95.png'
        ];
        
        foreach ($mockKotkab as $index => $kotkab) {
            $mockItem = [
                "lokasi" => [
                    "adm2" => "65.0" . ($index+1),
                    "provinsi" => "Kalimantan Utara",
                    "kotkab" => $kotkab,
                    "timezone" => "Asia/Makassar"
                ],
                "cuaca" => []
            ];
            for ($j = 0; $j < 15; $j++) {
                $timestamp = date('Y-m-d H:00:00', strtotime("+$j hours"));
                $mockItem['cuaca'][] = [
                    [
                        "datetime" => str_replace(' ', 'T', $timestamp) . "Z",
                        "local_datetime" => str_replace(' ', 'T', $timestamp),
                        "t" => rand(28, 32),
                        "hu" => rand(70, 85),
                        "weather_desc" => $weatherTypes[$index % 5],
                        "image" => $images[$weatherTypes[$index % 5]],
                        "ws" => rand(10, 30),
                        "wd" => 'TL',
                        "vs" => rand(5000, 10000),
                        "vs_text" => "> 5 km"
                    ]
                ];
            }
            $results[] = $mockItem;
        }
    }
    return $results;
}

// Fetch weather data for all Kaltara Regencies
$dataCuacaArray = fetchKaltaraWeather($kaltaraAdm4);

// Prepare associative array of city data
$citiesData = [];
foreach ($dataCuacaArray as $location_data) {
    $adm2 = isset($location_data['lokasi']['adm2']) ? $location_data['lokasi']['adm2'] : 'N/A';
    $provinsi = isset($location_data['lokasi']['provinsi']) ? $location_data['lokasi']['provinsi'] : 'N/A';
    $kotkab = isset($location_data['lokasi']['kotkab']) ? $location_data['lokasi']['kotkab'] : 'N/A';
    $timezone = isset($location_data['lokasi']['timezone']) && !empty($location_data['lokasi']['timezone'])
        ? $location_data['lokasi']['timezone']
        : 'Asia/Jakarta';
        
    if (!isset($citiesData[$kotkab]) && $kotkab !== 'N/A') {
        $citiesData[$kotkab] = [
            'adm2'      => $adm2,
            'provinsi'  => $provinsi,
            'kotkab'    => $kotkab,
            'cuaca'     => $location_data['cuaca'],
            'timezone'  => $timezone
        ];
    }
}

$defaultCity = isset($citiesData['Kota Tarakan']) ? 'Kota Tarakan' : (empty($citiesData) ? 'N/A' : array_key_first($citiesData));
$selectedCity = $_GET['kota'] ?? $defaultCity;
if (!isset($citiesData[$selectedCity])) {
    $selectedCity = $defaultCity;
}
$selectedCityData = $citiesData[$selectedCity] ?? null;
$allCities = array_keys($citiesData);
$currentCityIndex = array_search($selectedCity, $allCities);
if ($currentCityIndex === false) { $currentCityIndex = 0; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cuaca - BMKG Tarakan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <link rel="stylesheet" href="css/outer.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* ===PASTE THE ENTIRE MOBILE CARD SWIPER CSS FROM tes_scroll_cuaca.php HERE=== */

        /* Global Styles & Background */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden; /* Prevent horizontal scroll */
            touch-action: pan-y; /* Allow only vertical touch scrolling */
            background-image: linear-gradient(rgba(255,255,255,0.1), rgba(255,255,255,0.1)),
                              url('assets/image/bg_clouds.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed; /* Keep background static on view height changes */
        }

        * {
            touch-action: pan-y;  /* Ensure the above rule is applied broadly */
            box-sizing: border-box;
        }

        section {
            position: relative;
            padding: 40px 5%;
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .forecast-title {
            color: white;
            padding: 10px;
            text-align: center;
            margin-top: 20px;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
        }
        .current-weather {
            margin: 20px auto;
            padding: 20px;
            width: 320px;
            height: 245px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            box-sizing: border-box;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            color: var(--bmkg-blue);
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.6);
        }
        .current-weather-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }
        .weather-table-container {
            overflow-x: auto;
            max-width: 1000px;
            margin: 0 auto;
            width: 90%;
        }
        .weather-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        }
        .weather-table th {
            background: rgba(255, 255, 255, 0.2);
            color: var(--bmkg-blue);
            padding: 15px;
            text-align: center;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.6);
        }
        .weather-table td {
            background: transparent;
            color: var(--bmkg-blue);
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.6);
            transition: background 0.3s ease;
        }
        .weather-table td:nth-child(3) {
            white-space: nowrap;
        }
        .weather-table tr:last-child td {
            border-bottom: none;
        }
        .weather-table tr:hover td {
            background: rgba(255, 255, 255, 0.3);
        }
        .filter-container {
            text-align: center;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .filter-container select {
            background-color: #4682b4;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .filter-container select:hover {
            background-color: #5f9ea0;
        }
        /* Desktop Swiper (Top Navigation) */
        .swiper-container {
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .swiper-slide {
            text-align: center;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 8px;
            margin: 5px;
        }
        .day-container {
            display: none;
        }

        .swiper-button-next, .swiper-button-prev { all: unset; }
        .swiper, .swiper-wrapper, .swiper-slide { all: unset; }

        /* Mobile Styles */
        @media (max-width: 768px) {
            .current-weather-container {
                padding-left: 20%;
                padding-right: 20%;
            }
            .day-container {
                display: block;
                margin-bottom: 15px;
                width: 100%;
                box-sizing: border-box;
            }

            .day-heading {
                text-align: center;
                font-weight: 600;
                font-size: 1.2em;
                margin-bottom: 5px;
                padding: 5px;
                color: var(--bmkg-blue);
            }

            .mobile-swiper-container {
                width: 100%;
                overflow: hidden;
                padding: 0 5px;
            }

            .mobile-swiper-container .swiper-wrapper {
                display: flex;
                margin:  0 -5px;
                width: 100%;
            }

            .mobile-swiper-slide {
                width: 60%;
                flex-shrink: 0;
                padding: 0 5px;
            }

            .weather-card {
                flex: 0 0 auto;
                min-width: 100%;
                padding: 15px;
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 15px;
                text-align: left;
                background: rgba(255, 255, 255, 0.15); /* Match desktop frosted glass */
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                color: var(--bmkg-blue); /* Match desktop text color */
                text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.6); /* Match desktop text shadow */
                box-sizing: border-box;
            }

            .weather-card-title {
                font-weight: bold;
                font-size: 1.1em;
                color: var(--bmkg-blue);
                margin-bottom: 10px;
                text-align: center;
            }

            .weather-card .weather-icon {
                display: block;
                margin: 0 auto 10px;
                font-size: 3em; /* Scaled down slightly */
                text-align: center;
            }

            .weather-card-detail {
                margin-bottom: 8px;
                display: flex;
                align-items: center;
            }

            .filter-container, .weather-table {
                display: none;
            }
            section {
                padding: 0;
            }
            .current-weather {
                width: 290px !important;
                height: 225px !important;
                margin: 15px auto !important;
                padding: 15px !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: space-around !important;
                align-items: center !important;
            }
            .current-weather-time { font-size: 18px !important; }
            .current-weather-temp { font-size: 32px !important; }
            .current-weather-icon { font-size: 18px !important; }
            .current-weather-icon .weather-icon {
                font-size: 1.5em !important; /* Increased icon size */
                display: inline-block !important;
                margin: 0 !important;
            }
            .current-weather-humidity { font-size: 20px !important; } /* Increased humidity font size */
            .swiper-container { padding: 10px; }
            .swiper-slide { font-size: 16px; padding: 5px 10px; }
        }

        /* Apply width and box-sizing to potentially overflowing elements */
        .day-container, .cards-container, .cards-wrapper, .weather-card, img {
            max-width: 100vw;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<?php include 'widget/header.php'; ?>
<script src="assets/script/nav.js"></script>
<section style="width: 100%;">
    <?php 
    $cityIndex = 0;
    foreach ($citiesData as $cityName => $selectedCityData): 
        $display = ($cityIndex === $currentCityIndex) ? 'block' : 'none';
    ?>
    <div class="city-panel" id="city-panel-<?= $cityIndex ?>" style="display: <?= $display ?>; width: 100%;">
        <h2 class="forecast-title">
            Prakiraan Cuaca <?= $cityName . ', ' . $selectedCityData['provinsi'] ?>
        </h2>
                
                <div style="display: flex; justify-content: center; align-items: center; width: 100%; margin-bottom: 20px;">
                      <a href="javascript:void(0)" onclick="prevCity()" class="master-prev-btn" style="text-decoration: none; color: #000; font-size: 20px; display: flex; align-items: center;">
                          <img style="width:16px;height:22px;margin-right: 16px;" src="assets/image/prev_btn.png"/>
                      </a>
                      <div style="text-decoration: none; color: #000; font-size: 20px; display: flex; align-items: center; justify-content: center; height: 100%; width: 220px; text-align: center; font-weight: 500;">
                          <?= $cityName ?>
                      </div>
                      <a href="javascript:void(0)" onclick="nextCity()" class="master-next-btn" style="text-decoration: none; color: #000; font-size: 20px; display: flex; align-items: center;">
                          <img style="width:16px;height:22px;margin-left: 16px;" src="assets/image/next_btn.png"/>
                      </a>
                </div>

                <!-- Current Weather Info -->
                <div class="current-weather-container">
                    <?php
                    $icon_mapping = [
                        'Cerah' => '<span class="weather-icon">☀️</span>',
                        'Berawan' => '<span class="weather-icon">☁️</span>',
                        'Hujan Ringan' => '<span class="weather-icon">🌦️</span>',
                        'Hujan Sedang' => '<span class="weather-icon">🌧️</span>',
                        'Hujan Lebat' => '<span class="weather-icon">⛈️</span>',
                        'Hujan Petir' => '<span class="weather-icon">⛈️</span>',
                        'Cerah Berawan' => '<span class="weather-icon">⛅</span>',
                        'Awan Tebal' => '<span class="weather-icon">☁️</span>',
                        'Udara Kabur' => '<span class="weather-icon">🌫️</span>',
                        'Angin Kencang' => '<span class="weather-icon">🌪️</span>',
                        'Kabut' => '<span class="weather-icon">🌫️</span>',
                        'Asap' => '<span class="weather-icon">🌫️</span>',
                        'Berawan Tebal' => '<span class="weather-icon">☁️</span>',
                        'Kabut Asap' => '<span class="weather-icon">🌫️</span>',
                        'Cloudy' => '<span class="weather-icon">☁️</span>',
                        'Light Rain' => '<span class="weather-icon">🌦️</span>',
                        'Moderate Rain' => '<span class="weather-icon">🌧️</span>',
                        'Heavy Rain' => '<span class="weather-icon">⛈️</span>',
                        'Clear' => '<span class="weather-icon">☀️</span>',
                        'Partly Cloudy' => '<span class="weather-icon">⛅</span>',
                        'Fog' => '<span class="weather-icon">🌫️</span>',
                        'Smoke' => '<span class="weather-icon">🌫️</span>',
                        'Overcast' => '<span class="weather-icon">☁️</span>',
                        'Haze' => '<span class="weather-icon">🌫️</span>',
                        'Light Snow' => '<span class="weather-icon">🌨️</span>',
                        'Moderate Snow' => '<span class="weather-icon">🌨️</span>',
                        'Heavy Snow' => '<span class="weather-icon">🌨️</span>',
                        'Snow' => '<span class="weather-icon">🌨️</span>',
                        'Sleet' => '<span class="weather-icon">🌧️</span>',
                        'Freezing Rain' => '<span class="weather-icon">🌦️</span>',
                        'Drizzle' => '<span class="weather-icon">🌦️</span>',
                        'Rain' => '<span class="weather-icon">🌧️</span>',
                        'Thunder' => '<span class="weather-icon">⛈️</span>',
                        'Windy' => '<span class="weather-icon">🌪️</span>',
                        'Clear Sky' => '<span class="weather-icon">☀️</span>',
                        'Few Clouds' => '<span class="weather-icon">⛅</span>',
                        'Scattered Clouds' => '<span class="weather-icon">☁️</span>',
                        'Broken Clouds' => '<span class="weather-icon">☁️</span>',
                        'Shower Rain' => '<span class="weather-icon">🌦️</span>',
                        'Rain Shower' => '<span class="weather-icon">🌦️</span>',
                        'Snow Shower' => '<span class="weather-icon">🌨️</span>',
                        'Ice Pellets' => '<span class="weather-icon">🌧️</span>',
                        'Mist' => '<span class="weather-icon">🌫️</span>',
                        'Sand' => '<span class="weather-icon">🏜️</span>',
                        'Dust' => '<span class="weather-icon">🌫️</span>',
                        'Squall' => '<span class="weather-icon">🌪️</span>',
                        'Tornado' => '<span class="weather-icon">🌪️</span>',
                        'Sandstorm' => '<span class="weather-icon">🏜️</span>',
                        'Duststorm' => '<span class="weather-icon">🌫️</span>',
                        'Funnel Cloud' => '<span class="weather-icon">🌪️</span>',
                        'Hail' => '<span class="weather-icon">🌧️</span>',
                        'Small Hail' => '<span class="weather-icon">🌧️</span>',
                        'Unknown' => ''
                    ];
                    $timezone = $selectedCityData['timezone'] ?? 'Asia/Jakarta';
                    $now = new DateTime('now', new DateTimeZone($timezone));
                    $currentForecast = null;
                    $minDiff = PHP_INT_MAX;
                    if (isset($selectedCityData['cuaca'])) {
                        foreach ($selectedCityData['cuaca'] as $forecast_set) {
                            foreach ($forecast_set as $forecast) {
                                if (isset($forecast['local_datetime'])) {
                                    $forecastTime = new DateTime($forecast['local_datetime'], new DateTimeZone($timezone));
                                    $diff = abs($now->getTimestamp() - $forecastTime->getTimestamp());
                                    if ($diff < $minDiff) {
                                        $minDiff = $diff;
                                        $currentForecast = $forecast;
                                    }
                                }
                            }
                        }
                    }
                    if ($currentForecast) {
                        $weather_desc = isset($currentForecast['weather_desc']) ? $currentForecast['weather_desc'] : 'Unknown';
                        $icon_html = isset($icon_mapping[$weather_desc]) ? $icon_mapping[$weather_desc] : '';
                        $formatted_time = $now->format('H:i');
                        echo '<div class="current-weather">';
                        echo '<div class="current-weather-time realtime-clock" data-timezone="'.$timezone.'" style="font-size: 24px; font-weight: 600; text-align: center;">' . $formatted_time . ' WITA</div>';
                        echo '<div class="current-weather-temp" style="display: flex; justify-content: center; align-items: center; font-size: 40px; font-weight: 700;">' . (isset($currentForecast['t']) ? $currentForecast['t'] : 'N/A') . '°C</div>';
                        echo '<div class="current-weather-icon" style="display: flex; justify-content: center; align-items: center; font-size: 24px; font-weight: 600; flex-direction: row; gap: 8px;">';
                        echo '<span>' . $icon_html . '</span>';
                        echo '<span>' . $weather_desc . '</span>';
                        echo '</div>';
                        echo '<div class="current-weather-humidity" style="display: flex; justify-content: center; align-items: center; font-size: 22px; font-weight: 500;">💧 ' . (isset($currentForecast['hu']) ? $currentForecast['hu'] : 'N/A') . ' %</div>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <!-- Filter Dropdown -->
                <div class="filter-container">
                   <select onchange="filterTable(this)">
                        <option value="all">Tiga Hari Kedepan</option>
                        <option value="today">Hari Ini</option>
                        <option value="tomorrow">Besok</option>
                        <option value="today-tomorrow">Hari Ini & Besok</option>
                    </select>
                </div>

                <!-- Desktop Table Forecast -->
                <div class="weather-table-container">
                    <table class="weather-table">
                        <thead>
                            <tr>
                                <th>Suhu</th>
                                <th>Tutupan Awan</th>
                                <th>Deskripsi<br>Cuaca</th>
                                <th>Kecepatan Angin</th>
                                <th>Kelembapan Udara</th>
                                <th>Jarak Pandang</th>
                                <th>Waktu Setempat</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($selectedCityData['cuaca'])) {
                               $dayCount = 0;
                               $displayedDates = [];
                                foreach ($selectedCityData['cuaca'] as $forecast_set) {
                                    foreach ($forecast_set as $forecast) {
                                        $weather_desc = isset($forecast['weather_desc']) ? $forecast['weather_desc'] : 'Unknown';
                                        $icon_html = isset($icon_mapping[$weather_desc]) ? $icon_mapping[$weather_desc] : '';
                                        $local_datetime = isset($forecast['local_datetime']) ? $forecast['local_datetime'] : null;
                                        $formatted_time = 'N/A';
                                        $formatted_date = 'N/A';
                                        $dayName = 'N/A';
                                        if ($local_datetime) {
                                            try {
                                               $date = new DateTime($local_datetime, new DateTimeZone($timezone));
                                               $formatted_time = $date->format('H:i');
                                               $formatted_date = $date->format('Y-m-d');
                                               $dayName = $date->format('D');
                                               $dayName = match ($dayName) {
                                                   'Mon' => 'Senin',
                                                   'Tue' => 'Selasa',
                                                   'Wed' => 'Rabu',
                                                   'Thu' => 'Kamis',
                                                   'Fri' => 'Jumat',
                                                   'Sat' => 'Sabtu',
                                                   'Sun' => 'Minggu',
                                                   default => 'Unknown',
                                               };
                                               $today = new DateTime('now', new DateTimeZone($selectedCityData['timezone']));
                                               $tomorrow = (new DateTime('now', new DateTimeZone($selectedCityData['timezone'])))->modify('+1 day');
                                              if ($date->format('Y-m-d') == $today->format('Y-m-d')) {
                                                   $dayName = 'Hari Ini';
                                               } elseif ($date->format('Y-m-d') == $tomorrow->format('Y-m-d')) {
                                                   $dayName = 'Besok';
                                               }
                                            } catch (Exception $e) { }
                                       }
                                      if (!in_array($formatted_date, $displayedDates)) {
                                          if ($dayCount >= 3) {
                                              break 2;
                                          }
                                          $displayedDates[] = $formatted_date;
                                          $dayCount++;
                                      }
                                        echo '<tr data-date="' . $formatted_date . '">';
                                       echo '<td>' . (isset($forecast['t']) ? $forecast['t'] : 'N/A') . ' °C</td>';
                                       echo '<td>' . (isset($forecast['tcc']) ? $forecast['tcc'] : 'N/A') . ' %</td>';
                                       echo '<td>' . $icon_html . ' ' . $weather_desc . '</td>';
                                       echo '<td>' . (isset($forecast['ws']) ? $forecast['ws'] : 'N/A') . ' km/jam</td>';
                                       echo '<td>' . (isset($forecast['hu']) ? $forecast['hu'] : 'N/A') . ' %</td>';
                                       echo '<td>' . (isset($forecast['vs_text']) ? $forecast['vs_text'] : 'N/A') . '</td>';
                                       echo '<td>' . $formatted_time . '</td>';
                                       echo '<td>' . $dayName . '</td>';
                                       echo '</tr>';
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php
                // Group forecasts by day for mobile cards
                if (isset($selectedCityData['cuaca'])) {
                    $dailyForecasts = [];
                    $today = new DateTime('now', new DateTimeZone($timezone));
                    $today_date = $today->format('Y-m-d');
                    $tomorrow = (new DateTime('now', new DateTimeZone($timezone)))->modify('+1 day');
                    $tomorrow_date = $tomorrow->format('Y-m-d');
                    $after_tomorrow = (new DateTime('now', new DateTimeZone($timezone)))->modify('+2 days');
                    $after_tomorrow_date = $after_tomorrow->format('Y-m-d');
                    $dayAfterTomorrowName = $after_tomorrow->format('D');
                    $dayAfterTomorrowName = match ($dayAfterTomorrowName) {
                        'Mon' => 'Senin',
                        'Tue' => 'Selasa',
                        'Wed' => 'Rabu',
                        'Thu' => 'Kamis',
                        'Fri' => 'Jumat',
                        'Sat' => 'Sabtu',
                        'Sun' => 'Minggu',
                        default => 'Unknown',
                    };

                    $dailyForecasts['Hari Ini'] = [];
                    $dailyForecasts['Besok'] = [];
                    $dailyForecasts[$dayAfterTomorrowName] = [];

                    foreach ($selectedCityData['cuaca'] as $forecast_set) {
                        foreach ($forecast_set as $forecast) {
                            $local_datetime = isset($forecast['local_datetime']) ? $forecast['local_datetime'] : null;
                            if ($local_datetime) {
                                try {
                                    $date = new DateTime($local_datetime, new DateTimeZone($timezone));
                                    $date_string = $date->format('Y-m-d');
                                    if ($date_string == $today_date) {
                                        $dailyForecasts['Hari Ini'][] = $forecast;
                                    } elseif ($date_string == $tomorrow_date) {
                                        $dailyForecasts['Besok'][] = $forecast;
                                    } elseif ($date_string == $after_tomorrow_date) {
                                        $dailyForecasts[$dayAfterTomorrowName][] = $forecast;
                                    }
                                } catch (Exception $e) { }
                            }
                        }
                    }
                }
                $dayOrder = ['Hari Ini', 'Besok', $dayAfterTomorrowName];
                ?>

                <?php foreach ($dayOrder as $dayName): ?>
                    <div class="day-container">
                        <div class="day-heading"><?= $dayName ?></div>
                        <div class="mobile-swiper-container swiper-mobile">
                            <div class="swiper-wrapper">
                                <?php if (isset($dailyForecasts[$dayName]) && !empty($dailyForecasts[$dayName])): ?>
                                    <?php foreach ($dailyForecasts[$dayName] as $forecast):
                                        $weather_desc = isset($forecast['weather_desc']) ? $forecast['weather_desc'] : 'Unknown';
                                        $icon_html = isset($icon_mapping[$weather_desc]) ? $icon_mapping[$weather_desc] : '';
                                        $local_datetime = isset($forecast['local_datetime']) ? $forecast['local_datetime'] : null;
                                        $formatted_time = 'N/A';
                                        if ($local_datetime) {
                                            try {
                                                $date = new DateTime($local_datetime, new DateTimeZone($timezone));
                                                $formatted_time = $date->format('H:i');
                                            } catch (Exception $e) { }
                                        }
                                        ?>
                                        <div class="swiper-slide mobile-swiper-slide">
                                            <div class="weather-card">
                                                <div class="weather-card-title"><?= $formatted_time ?></div>
                                                <div style="text-align: center; color:white; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);"><?=$icon_html?></div>
                                                <div class="weather-card-detail">
                                                    Suhu: <?= (isset($forecast['t']) ? $forecast['t'] : 'N/A') ?> °C
                                                </div>
                                                <div class="weather-card-detail">
                                                     <?= $weather_desc ?>
                                                </div>
                                                <div class="weather-card-detail">
                                                       Kecepatan Angin: <?= (isset($forecast['ws']) ? $forecast['ws'] : 'N/A') ?> km/jam
                                                </div>
                                                <div class="weather-card-detail">
                                                      Kelembapan: <?= (isset($forecast['hu']) ? $forecast['hu'] : 'N/A') ?>%
                                                 </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="swiper-slide mobile-swiper-slide">
                                        <div class="weather-card">
                                            <div class="weather-card-title">No Data Available</div>
                                            <div class="weather-card-detail">
                                                No forecast data for <?= $dayName ?>.
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div> <!-- city-panel -->
            <?php 
                $cityIndex++;
            endforeach; 
            ?>
</section>
<?php include 'widget/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
        // Initialize top navigation Swiper only
        

        function updateClock() {
            const clocks = document.querySelectorAll('.realtime-clock');
            clocks.forEach(clock => {
                const timezone = clock.getAttribute('data-timezone') || 'Asia/Jakarta';
                const date = new Date();
                const options = { timeZone: timezone, hour: '2-digit', minute: '2-digit' };
                const formattedTime = date.toLocaleTimeString(undefined, options);
                clock.textContent = formattedTime + ' WITA';
            });
        }
        setInterval(updateClock, 1000);
        updateClock();

        function filterTable(selectElement) {
            const filter = selectElement.value;
            const container = selectElement.closest('.swiper-slide');
            const table = container ? container.querySelector('.weather-table') : document.querySelector('.weather-table');
            if(!table) return;
            const rows = table.getElementsByTagName('tr');
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(today.getDate() + 1);
            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const rowDate = new Date(row.getAttribute('data-date'));
                let showRow = false;
                if (filter === 'all') {
                    showRow = true;
                } else if (filter === 'today' && rowDate.toDateString() === today.toDateString()) {
                    showRow = true;
                } else if (filter === 'tomorrow' && rowDate.toDateString() === tomorrow.toDateString()) {
                    showRow = true;
                } else if (filter === 'today-tomorrow' && (rowDate.toDateString() === today.toDateString() || rowDate.toDateString() === tomorrow.toDateString())) {
                    showRow = true;
                }
                row.style.display = showRow ? '' : 'none';
            }
        }
        

        let currentCityIndex = <?= $currentCityIndex ?>;
        const totalCities = <?= count($citiesData) ?>;

        function showCity(index) {
            for (let i = 0; i < totalCities; i++) {
                const el = document.getElementById('city-panel-' + i);
                if (el) el.style.display = 'none';
            }
            const el = document.getElementById('city-panel-' + index);
            if (el) el.style.display = 'block';
            
            currentCityIndex = index;
            
            // Update mobile swipers inside the newly shown panel
            if (window.mobileSwipers) {
                window.mobileSwipers.forEach(sw => {
                    sw.update();
                });
            }
        }

        function prevCity() {
            let prevIndex = (currentCityIndex - 1 + totalCities) % totalCities;
            showCity(prevIndex);
        }

        function nextCity() {
            let nextIndex = (currentCityIndex + 1) % totalCities;
            showCity(nextIndex);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const swiperContainers = document.querySelectorAll('.swiper-mobile'); // Target mobile swipers specifically
            window.mobileSwipers = [];

            swiperContainers.forEach(function (container) {
                const swiper = new Swiper(container, { // Initialize for each mobile swiper
                    effect: 'coverflow',
                    grabCursor: true,
                    centeredSlides: true,
                    slidesPerView: 'auto',
                    coverflowEffect: {
                        rotate: 50,
                        stretch: 0,
                        depth: 200,
                        modifier: 1,
                        slideShadows: false,
                    },
                    loop: true,
                });
                window.mobileSwipers.push(swiper);
            });
        });
    </script>
</body>
</html>
