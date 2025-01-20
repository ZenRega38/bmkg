<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="css/outer.css">
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
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<section>
    <h2 class="forecast-title">
        Prakiraan Cuaca Kalimantan Utara
    </h2>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Configuration
    $url = 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm1=65'; // JSON API URL

    // Function to fetch JSON data
    function ambilDataCuaca($url) {
        $json_data = @file_get_contents($url);
        if ($json_data === false) {
            return null;
        }

        $data = @json_decode($json_data, true); // Decode JSON into an associative array
        if ($data === null) {
            return null;
        }

        return $data;
    }

    // Function to display the weather data
    function tampilkanDataCuaca($data) {
        if ($data === null) {
            echo '<p class="error">Gagal mengambil data cuaca. Cek koneksi internet atau URL API.</p>';
            return;
        }

        // Icon mapping
        $icon_mapping = [
            'Cerah'            => '<span class="weather-icon">☀️</span>',
            'Berawan'          => '<span class="weather-icon">☁️</span>',
            'Hujan Ringan'     => '<span class="weather-icon">🌦️</span>',
            'Hujan Sedang'     => '<span class="weather-icon">🌧️</span>',
            'Hujan Lebat'      => '<span class="weather-icon">🌧️</span>',
            'Hujan Petir'      => '<span class="weather-icon">⛈️</span>',
            'Cerah Berawan'    => '<span class="weather-icon">🌤️</span>',
            'Awan Tebal'       => '<span class="weather-icon">🌥️</span>',
            'Udara Kabur'      => '<span class="weather-icon">🌫️</span>',
            'Angin Kencang'    => '<span class="weather-icon">🌪️</span>',
            'Kabut'            => '<span class="weather-icon">🌫️</span>',
            'Asap'             => '<span class="weather-icon">🌫️</span>',
            'Berawan Tebal'    => '<span class="weather-icon">🌥️</span>',
            'Cloudy'           => '<span class="weather-icon">☁️</span>',
            'Light Rain'       => '<span class="weather-icon">🌦️</span>',
            'Moderate Rain'    => '<span class="weather-icon">🌧️</span>',
            'Heavy Rain'       => '<span class="weather-icon">🌧️</span>',
            'Thunderstorm'     => '<span class="weather-icon">⛈️</span>',
            'Clear'            => '<span class="weather-icon">☀️</span>',
            'Partly Cloudy'    => '<span class="weather-icon">🌤️</span>',
            'Fog'              => '<span class="weather-icon">🌫️</span>',
            'Smoke'            => '<span class="weather-icon">🌫️</span>',
            'Overcast'         => '<span class="weather-icon">🌥️</span>',
            'Haze'             => '<span class="weather-icon">🌫️</span>',
            'Light Snow'       => '<span class="weather-icon">🌨️</span>',
            'Moderate Snow'    => '<span class="weather-icon">🌨️</span>',
            'Heavy Snow'       => '<span class="weather-icon">🌨️</span>',
            'Snow'             => '<span class="weather-icon">🌨️</span>',
            'Sleet'            => '<span class="weather-icon">🌧️</span>',
            'Freezing Rain'    => '<span class="weather-icon">🌧️</span>',
            'Drizzle'          => '<span class="weather-icon">🌦️</span>',
            'Rain'             => '<span class="weather-icon">🌧️</span>',
            'Thunder'          => '<span class="weather-icon">⛈️</span>',
            'Windy'            => '<span class="weather-icon">🌪️</span>',
            'Clear Sky'        => '<span class="weather-icon">☀️</span>',
            'Few Clouds'       => '<span class="weather-icon">🌤️</span>',
            'Scattered Clouds' => '<span class="weather-icon">☁️</span>',
            'Broken Clouds'    => '<span class="weather-icon">🌥️</span>',
            'Shower Rain'      => '<span class="weather-icon">🌦️</span>',
            'Rain Shower'      => '<span class="weather-icon">🌦️</span>',
            'Snow Shower'      => '<span class="weather-icon">🌨️</span>',
            'Ice Pellets'      => '<span class="weather-icon">🌧️</span>',
            'Mist'             => '<span class="weather-icon">🌫️</span>',
            'Sand'             => '<span class="weather-icon">🏜️</span>',
            'Dust'             => '<span class="weather-icon">🌫️</span>',
            'Squall'           => '<span class="weather-icon">🌪️</span>',
            'Tornado'          => '<span class="weather-icon">🌪️</span>',
            'Volcanic Ash'     => '<span class="weather-icon">🌋</span>',
            'Sandstorm'        => '<span class="weather-icon">🏜️</span>',
            'Duststorm'        => '<span class="weather-icon">🌫️</span>',
            'Funnel Cloud'     => '<span class="weather-icon">🌪️</span>',
            'Hail'             => '<span class="weather-icon">🌧️</span>',
            'Small Hail'       => '<span class="weather-icon">🌧️</span>',
            'Unknown'          => ''
        ];

        if (isset($data['data'])) {
            foreach ($data['data'] as $location_data) {
                $adm2 = isset($location_data['lokasi']['adm2']) ? $location_data['lokasi']['adm2'] : 'N/A';
                $provinsi = isset($location_data['lokasi']['provinsi']) ? $location_data['lokasi']['provinsi'] : 'N/A';
                $kotkab = isset($location_data['lokasi']['kotkab']) ? $location_data['lokasi']['kotkab'] : 'N/A';

                echo '<div class="cuaca-item">';
                echo '<h3 style="color: #fff; margin-top: 21px">' . $kotkab . ', ' . $provinsi . '</h3>';
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
                foreach ($location_data['cuaca'] as $forecast_set) {
                    foreach ($forecast_set as $forecast) {
                        $weather_desc = isset($forecast['weather_desc']) ? $forecast['weather_desc'] : 'Unknown';
                        $icon_html = isset($icon_mapping[$weather_desc]) ? $icon_mapping[$weather_desc] : '';

                        $local_datetime = isset($forecast['local_datetime']) ? $forecast['local_datetime'] : null;
                        $formatted_time = 'N/A';
                        $formatted_date = 'N/A';

                        if ($local_datetime) {
                            try {
                                $date = new DateTime($local_datetime);
                                $formatted_time = $date->format('H:i'); // Only the hour
                                $formatted_date = $date->format('Y-m-d'); // Only the date
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
                echo '</div>';
            }
        } else {
            echo '<p class="error">Struktur data JSON tidak sesuai</p>';
        }
    }

    // Fetch and display the weather data
    $dataCuaca = ambilDataCuaca($url);
    tampilkanDataCuaca($dataCuaca);
    ?>

</section>

<?php include 'footer.php'; ?>
</body>
</html>