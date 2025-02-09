<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuration
$url = 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm1=65';

// Function to fetch JSON data
function ambilDataCuaca($url)
{
    $json_data = @file_get_contents($url);
    if ($json_data === false) {
        return null;
    }
    $data = @json_decode($json_data, true);
    if ($data === null) {
        return null;
    }
    return $data;
}

// Fetch weather data
$dataCuaca = ambilDataCuaca($url);
if ($dataCuaca === null || !isset($dataCuaca['data'])) {
    echo '<p class="error">Failed to fetch weather data.</p>';
    exit;
}

// Prepare associative array of city data
$citiesData = [];
foreach ($dataCuaca['data'] as $location_data) {
    $adm2 = isset($location_data['lokasi']['adm2']) ? $location_data['lokasi']['adm2'] : 'N/A';
    $provinsi = isset($location_data['lokasi']['provinsi']) ? $location_data['lokasi']['provinsi'] : 'N/A';
    $kotkab = isset($location_data['lokasi']['kotkab']) ? $location_data['lokasi']['kotkab'] : 'N/A';
    $timezone = isset($location_data['lokasi']['timezone']) && !empty($location_data['lokasi']['timezone'])
        ? $location_data['lokasi']['timezone']
        : 'Asia/Jakarta';
    $citiesData[$kotkab] = [
        'adm2'     => $adm2,
        'provinsi' => $provinsi,
        'cuaca'    => $location_data['cuaca'],
        'timezone' => $timezone
    ];
}

$defaultCity = array_key_last($citiesData);
$selectedCity = $_GET['kota'] ?? $defaultCity;
if (!isset($citiesData[$selectedCity])) {
    $selectedCity = $defaultCity;
}
$selectedCityData = $citiesData[$selectedCity];
$allCities = array_keys($citiesData);
$currentCityIndex = array_search($selectedCity, $allCities);
$prevCity = $allCities[($currentCityIndex - 1 + count($allCities)) % count($allCities)];
$nextCity = $allCities[($currentCityIndex + 1) % count($allCities)];
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/all.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        /* ===PASTE THE ENTIRE MOBILE CARD SWIPER CSS FROM tes_scroll_cuaca.php HERE=== */

        /* Global Styles & Background */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden; /* Prevent horizontal scroll */
            touch-action: pan-y; /* Allow only vertical touch scrolling */
        }

        * {
            touch-action: pan-y;  /* Ensure the above rule is applied broadly */
        }

        section {
            position: relative;
            padding: 100px;
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: linear-gradient(rgba(255,255,255,0.1), rgba(255,255,255,0.1)),
                              url('assets/image/bg_clouds.png');
            background-repeat: no-repeat;
            background-size: cover;
        }
        .forecast-title {
            color: white;
            padding: 10px;
            text-align: center;
            margin-top: 20px;
        }
        .current-weather {
            margin: 20px auto;
            padding: 20px;
            max-width: 400px;
            text-align: center;
            background-color: rgba(255,255,255,0.8);
            border-radius: 10px;
        }
        .current-weather-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }
        .weather-table-container {
            overflow-x: auto;
        }
        .weather-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(255,255,255,0.9);
        }
        .weather-table th {
            background-color: #5f9ea0;
            color: white;
            padding: 10px;
            text-align: center;
        }
        .weather-table td {
            background-color: rgba(95,158,160,0.8);
            color: white;
            padding: 10px;
            text-align: left;
            border: 1px solid #4682b4;
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
                font-weight: bold;
                font-size: 1.2em;
                margin-bottom: 5px;
                padding: 5px;
                color: white;
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
                border: none;
                border-radius: 15px;
                text-align: left;
                background-color: rgba(55, 123, 201, 0.69);
                color: white;
                box-sizing: border-box;
            }

            .weather-card-title {
                font-weight: bold;
                font-size: 1.1em;
                color: #f0ad4e;
                margin-bottom: 10px;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
                text-align: center;
            }

            .weather-icon {
                display: block;
                margin: 0 auto 10px;
                font-size: 5em;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
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
            .current-weather { width: 100% !important; max-width: 100%; }
            .current-weather-temp { font-size: 20px !important; }
            .current-weather-icon { font-size: 16px !important; }
            .current-weather-humidity { font-size: 12px !important; }
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
<?php include 'header.php'; ?>
<script src="assets/script/nav.js"></script>
<section>
    <h2 class="forecast-title">
        Prakiraan Cuaca <?= $selectedCity . ', ' . $selectedCityData['provinsi'] ?>
    </h2>
    <!-- Top Navigation Swiper -->
    <div class="swiper-container">
        <div class="swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <a href="cuaca.php?kota=<?= $prevCity ?>" onclick="reloadPage(event)" style="text-decoration: none; color: #000; font-size: 20px; display: flex; align-items: center;">
                            <img style="width:16px;height:22px;margin-right: 16px;" src="assets/image/prev_btn.png" class="swiper-button-prev"/>
                        </a>
                        <a style="text-decoration: none; color: #000; font-size: 20px;" href="cuaca.php?kota=<?= $selectedCity ?>">
                            <?= $selectedCity ?>
                        </a>
                        <a href="cuaca.php?kota=<?= $nextCity ?>" onclick="reloadPage(event)" style="text-decoration: none; color: #000; font-size: 20px; display: flex; align-items: center;">
                            <img style="width:16px;height:22px;margin-left: 16px;" src="assets/image/next_btn.png" class="swiper-button-next"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Current Weather Info -->
    <div class="current-weather-container">
        <?php
        // Icon mapping
        $icon_mapping = [
            'Cerah' => '<span class="weather-icon">☀️</span>',
            'Berawan' => '<span class="weather-icon">☁️</span>',
            'Hujan Ringan' => '<span class="weather-icon">🌦️</span>',
            'Hujan Sedang' => '<span class="weather-icon">🌧️</span>',
            'Hujan Lebat' => '<span class="weather-icon">⛈️</span>',
            'Hujan Petir' => '<span class="weather-icon">⛈️</span>',
            'Cerah Berawan' => '<span class="weather-icon">🌤️</span>',
            'Awan Tebal' => '<span class="weather-icon">🌥️</span>',
            'Udara Kabur' => '<span class="weather-icon">🌫️</span>',
            'Angin Kencang' => '<span class="weather-icon">🌪️</span>',
            'Kabut' => '<span class="weather-icon">🌫️</span>',
            'Asap' => '<span class="weather-icon">🌫️</span>',
            'Berawan Tebal' => '<span class="weather-icon">🌥️</span>',
            'Kabut Asap' => '<span class="weather-icon">🌫️</span>',
            'Cloudy' => '<span class="weather-icon">☁️</span>',
            'Light Rain' => '<span class="weather-icon">🌦️</span>',
            'Moderate Rain' => '<span class="weather-icon">🌧️</span>',
            'Heavy Rain' => '<span class="weather-icon">⛈️</span>',
            'Clear' => '<span class="weather-icon">☀️</span>',
            'Partly Cloudy' => '<span class="weather-icon">🌤️</span>',
            'Fog' => '<span class="weather-icon">🌫️</span>',
            'Smoke' => '<span class="weather-icon">🌫️</span>',
            'Overcast' => '<span class="weather-icon">🌥️</span>',
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
            'Few Clouds' => '<span class="weather-icon">🌤️</span>',
            'Scattered Clouds' => '<span class="weather-icon">☁️</span>',
            'Broken Clouds' => '<span class="weather-icon">🌥️</span>',
            'Shower Rain' => '<span class="weather-icon">🌦️</span>',
            'Rain Shower' => '<span class="weather-icon">🌦️</span>',
            'Snow Shower' => '<span class="weather-icon">🌨️</span>',
            'Ice Pellets' => '<span class="weather-icon">🌧️</span>',
            'Mist' => '<span class="weather-icon">🌫️</span>',
            'Sand' => '<span class="weather-icon">🏜️</span>',
            'Dust' => '<span class="weather-icon">🌫️</span>',
            'Squall' => '<span class="weather-icon">🌪️</span>',
            'Tornado' => '<span class="weather-icon">🌋</span>',
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
            echo '<div class="current-weather-time" style="font-size: 20px; text-align: center;" id="realtime-clock">' . $formatted_time . ' WIB</div>';
            echo '<div class="current-weather-temp" style="display: flex; justify-content: center; align-items: center; font-size: 30px;">' . (isset($currentForecast['t']) ? $currentForecast['t'] : 'N/A') . '°C</div>';
            echo '<div class="current-weather-icon" style="display: flex; justify-content: center; align-items: center; font-size: 30px; flex-direction: row;">';
            echo '<span style="margin-right: 18px; margin-top: -24px">' . $icon_html . '</span>';
            echo '<span>' . $weather_desc . '</span>';
            echo '</div>';
            echo '<div class="current-weather-humidity" style="display: flex; justify-content: center; align-items: center; font-size: 16px;">💧' . (isset($currentForecast['hu']) ? $currentForecast['hu'] : 'N/A') . ' %</div>';
            echo '</div>';
        }
        ?>
    </div>
    <!-- Filter Dropdown -->
    <div class="filter-container">
       <select onchange="filterTable(this.value)">
            <option value="all">Tiga Hari Kedepan</option>
            <option value="today">Hari Ini</option>
            <option value="tomorrow">Besok</option>
            <option value="today-tomorrow">Hari Ini & Besok</option>
        </select>
    </div>
    <!-- Desktop Table Forecast -->
    <div class="weather-table-container" id="weatherTable">
        <table class="weather-table">
            <thead>
                <tr>
                    <th>Suhu</th>
                    <th>Tutupan Awan</th>
                    <th>Deskripsi Cuaca</th>
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
                                       $dayName = 'Today';
                                   } elseif ($date->format('Y-m-d') == $tomorrow->format('Y-m-d')) {
                                       $dayName = 'Tomorrow';
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
        $timezone = $selectedCityData['timezone'] ?? 'Asia/Jakarta';

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

        // Initialize empty arrays for each day
        $dailyForecasts['Today'] = [];
        $dailyForecasts['Tomorrow'] = [];
        $dailyForecasts[$dayAfterTomorrowName] = [];  // Use the actual day name

        foreach ($selectedCityData['cuaca'] as $forecast_set) {
            foreach ($forecast_set as $forecast) {
                $local_datetime = isset($forecast['local_datetime']) ? $forecast['local_datetime'] : null;
                if ($local_datetime) {
                    try {
                        $date = new DateTime($local_datetime, new DateTimeZone($timezone));
                        $date_string = $date->format('Y-m-d');
                        if ($date_string == $today_date) {
                            $dailyForecasts['Today'][] = $forecast;
                        } elseif ($date_string == $tomorrow_date) {
                            $dailyForecasts['Tomorrow'][] = $forecast;
                        } elseif ($date_string == $after_tomorrow_date) {
                            $dailyForecasts[$dayAfterTomorrowName][] = $forecast; // Use the actual day name
                        }
                    } catch (Exception $e) {
                        echo "Error processing datetime: " . $e->getMessage() . "<br>"; // Debugging
                    }
                }
            }
        }
    }
    ?>

    <!-- Mobile Forecast Cards with Swiper -->
    <?php
    // Explicitly define the order of days
    $dayOrder = ['Today', 'Tomorrow', $dayAfterTomorrowName]; // Use the actual day name
    ?>

    <?php foreach ($dayOrder as $dayName): ?>
        <div class="day-container">
            <div class="day-heading"><?= $dayName ?></div>
            <div class="mobile-swiper-container swiper-mobile">
                <div class="swiper-wrapper">
                    <?php if (isset($dailyForecasts[$dayName]) && !empty($dailyForecasts[$dayName])): ?>
                        <?php foreach ($dailyForecasts[$dayName] as $forecast):
                            $weather_desc = isset($forecast['weather_desc']) ? $forecast['weather_desc'] : 'Unknown';
                            $icon_html = isset($icon_mapping[$weather_desc]) ? $icon_html : '';
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
</section>
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
        // Initialize top navigation Swiper only
        const swiperNav = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: true,
        });

        function updateClock() {
            const clockElement = document.getElementById('realtime-clock');
            const timezone = '<?php echo $selectedCityData['timezone']; ?>';
            const date = new Date();
            const options = { timeZone: timezone, hour: '2-digit', minute: '2-digit' };
            const formattedTime = date.toLocaleTimeString(undefined, options);
            clockElement.textContent = formattedTime + ' WITA';
        }
        setInterval(updateClock, 1000);
        updateClock();

        function filterTable(filter) {
            const table = document.getElementById('weatherTable'); // corrected id
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
        function reloadPage(event) {
            event.preventDefault();
            window.location.href = event.currentTarget.getAttribute('href');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const swiperContainers = document.querySelectorAll('.swiper-mobile'); // Target mobile swipers specifically

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
            });
        });
    </script>
</body>
</html>