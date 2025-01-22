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
    echo '<p class="error">Gagal mengambil data cuaca.</p>';
    exit;
}

// Prepare an associative array of cities data
$citiesData = [];
foreach ($dataCuaca['data'] as $location_data) {
    $adm2 = isset($location_data['lokasi']['adm2']) ? $location_data['lokasi']['adm2'] : 'N/A';
    $provinsi = isset($location_data['lokasi']['provinsi']) ? $location_data['lokasi']['provinsi'] : 'N/A';
    $kotkab = isset($location_data['lokasi']['kotkab']) ? $location_data['lokasi']['kotkab'] : 'N/A';
    $citiesData[$kotkab] = [
        'adm2' => $adm2,
        'provinsi' => $provinsi,
        'cuaca' => $location_data['cuaca']
    ];
}

// Get selected city
$selectedCity = $_GET['kota'] ?? array_key_first($citiesData);

// Check if the city exists
if (!isset($citiesData[$selectedCity])) {
    echo '<p class="error">Kota tidak ditemukan.</p>';
    exit;
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
    <link rel="stylesheet" href="css/outer.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <meta charset="UTF-8">
    <style>
        section {
            position: relative;
            padding: 100px;
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: linear-gradient(
                    rgba(255, 255, 255, 0.1),
                    rgba(255, 255, 255, 0.1)
            ),
            url('assets/image/bg_clouds.png');
            background-repeat: no-repeat;
            background-size: cover;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .title {
            flex-grow: 1;
        }

        .title h1 {
            margin: 0;
            font-size: 24px;
        }

        .subtitle {
            font-size: 18px;
            margin-top: 10px;
        }

        .address {
            background-color: #4682b4;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .forecast-title {
            color: white;
            padding: 10px;
            text-align: center;
            margin-top: 20px;
        }

        .weather-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .weather-table th {
            background-color: #5f9ea0;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .weather-table td {
            background-color: rgba(95, 158, 160, 0.8);
            color: white;
            padding: 10px;
            text-align: left;
            border: 1px solid #4682b4;
        }

        .weather-icons {
            background-color: rgba(70, 130, 180, 0.9);
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .social-icons {
            float: right;
        }

        .social-icons img {
            width: 30px;
            height: 30px;
            margin-left: 10px;
        }

        .weather-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            vertical-align: middle;
            margin-right: 5px;
        }
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
         .swiper-button-next,
         .swiper-button-prev {
           all : unset;
         }
         /*remove styling swiper, swiper-wrapper, swiper-slide */
         .swiper,
         .swiper-wrapper,
         .swiper-slide{
           all: unset;
         }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<section>
    <h2 class="forecast-title">
        Prakiraan Cuaca <?= $selectedCity . ', ' . $selectedCityData['provinsi'] ?>
    </h2>
    <div class="swiper-container">
        <div class="swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
              <a href="cuaca.php?kota=<?= $prevCity ?>" class="swiper-button-prev"></a>
            </div>
            <div class="swiper-wrapper">
             <?php foreach ($citiesData as $city => $data): ?>
                <div class="swiper-slide">
                    <a style = 'text-decoration : none; color:#000' href="cuaca.php?kota=<?= $city ?>">
                        <?= $city ?>
                    </a>
                </div>
             <?php endforeach; ?>
        </div>
            <div class="swiper-slide">
              <a href="cuaca.php?kota=<?= $nextCity ?>" class="swiper-button-next"></a>
            </div>
        </div>
    </div>
    </div>

    <?php
    // Icon mapping
    $icon_mapping = [
        'Cerah' => '<span class="weather-icon">☀️</span>',
        'Berawan' => '<span class="weather-icon">☁️</span>',
        'Hujan Ringan' => '<span class="weather-icon">🌦️</span>',
        'Hujan Sedang' => '<span class="weather-icon">🌧️</span>',
        'Hujan Lebat' => '<span class="weather-icon">🌧️</span>',
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
        'Heavy Rain' => '<span class="weather-icon">🌧️</span>',
        'Thunderstorm' => '<span class="weather-icon">⛈️</span>',
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
        'Freezing Rain' => '<span class="weather-icon">🌧️</span>',
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
        'Tornado' => '<span class="weather-icon">🌪️</span>',
        'Volcanic Ash' => '<span class="weather-icon">🌋</span>',
        'Sandstorm' => '<span class="weather-icon">🏜️</span>',
        'Duststorm' => '<span class="weather-icon">🌫️</span>',
        'Funnel Cloud' => '<span class="weather-icon">🌪️</span>',
        'Hail' => '<span class="weather-icon">🌧️</span>',
        'Small Hail' => '<span class="weather-icon">🌧️</span>',
        'Unknown' => ''
    ];

    echo '<table class="weather-table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Suhu</th>';
    echo '<th>Tutupan Awan</th>';
    echo '<th>Deskripsi Cuaca</th>';
    echo '<th>Kecepatan Angin</th>';
    echo '<th>Kelembapan Udara</th>';
    echo '<th>Jarak Pandang</th>';
    echo '<th>Waktu Setempat</th>';
    echo '<th>Tanggal</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($selectedCityData['cuaca'] as $forecast_set) {
        foreach ($forecast_set as $forecast) {
            $weather_desc = isset($forecast['weather_desc']) ? $forecast['weather_desc'] : 'Unknown';
            $icon_html = isset($icon_mapping[$weather_desc]) ? $icon_mapping[$weather_desc] : '';

            $local_datetime = isset($forecast['local_datetime']) ? $forecast['local_datetime'] : null;
            $formatted_time = 'N/A';
            $formatted_date = 'N/A';

            if ($local_datetime) {
                try {
                    $date = new DateTime($local_datetime);
                    $formatted_time = $date->format('H:i');
                    $formatted_date = $date->format('Y-m-d');
                } catch (Exception $e) {
                    // Handle invalid date format
                }
            }

            echo '<tr>';
            echo '<td>' . (isset($forecast['t']) ? $forecast['t'] : 'N/A') . ' °C</td>';
            echo '<td>' . (isset($forecast['tcc']) ? $forecast['tcc'] : 'N/A') . ' %</td>';
            echo '<td>' . $icon_html . ' ' . $weather_desc . '</td>';
            echo '<td>' . (isset($forecast['ws']) ? $forecast['ws'] : 'N/A') . ' km/jam</td>';
            echo '<td>' . (isset($forecast['hu']) ? $forecast['hu'] : 'N/A') . ' %</td>';
            echo '<td>' . (isset($forecast['vs_text']) ? $forecast['vs_text'] : 'N/A') . '</td>';
            echo '<td>' . $formatted_time . '</td>';
            echo '<td>' . $formatted_date . '</td>';
            echo '</tr>';
        }
    }
    echo '</tbody>';
    echo '</table>';
    ?>
     
</section>
<?php include 'footer.php'; ?>
</body>
</html>