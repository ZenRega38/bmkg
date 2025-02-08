<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Konfigurasi
$url = 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm1=65';

// Fungsi untuk mengambil data JSON
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

// Mengambil data cuaca
$dataCuaca = ambilDataCuaca($url);

if ($dataCuaca === null || !isset($dataCuaca['data'])) {
    echo '<p class="error">Gagal mengambil data cuaca.</p>';
    exit;
}

// Mempersiapkan array asosiatif data kota
$citiesData = [];
foreach ($dataCuaca['data'] as $location_data) {
    $adm2 = isset($location_data['lokasi']['adm2']) ? $location_data['lokasi']['adm2'] : 'N/A';
    $provinsi = isset($location_data['lokasi']['provinsi']) ? $location_data['lokasi']['provinsi'] : 'N/A';
    $kotkab = isset($location_data['lokasi']['kotkab']) ? $location_data['lokasi']['kotkab'] : 'N/A';
    $timezone = isset($location_data['lokasi']['timezone']) && !empty($location_data['lokasi']['timezone'])
        ? $location_data['lokasi']['timezone']
        : 'Asia/Jakarta'; //Default timezone
    $citiesData[$kotkab] = [
        'adm2' => $adm2,
        'provinsi' => $provinsi,
        'cuaca' => $location_data['cuaca'],
        'timezone' => $timezone
    ];
}

// Mendapatkan kota yang dipilih
$defaultCity = array_key_last($citiesData); // Get the last key
$selectedCity = $_GET['kota'] ?? $defaultCity;

// Memeriksa apakah kota ada
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
    <link rel="stylesheet" href="css/outer.css">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>Cuaca - BMKG Tarakan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="../nav/assets-nav/css/styles.css">
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

        .current-weather {
            margin: 20px auto;
            padding: 20px;
            max-width: 400px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;

        }
        .current-weather-container{
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

         .current-weather-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .current-weather-table th {
            background-color: #5f9ea0;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .current-weather-table td {
            background-color: rgba(95, 158, 160, 0.8);
            color: white;
            padding: 10px;
            text-align: center;
            border: 1px solid #4682b4;
        }
         .weather-table-container {
             overflow-x: auto;
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
<?php include '../nav/nav.php';?>
<script src="assets/script/nav.js"></script>

<section>
    <h2 class="forecast-title">
        Prakiraan Cuaca <?= $selectedCity . ', ' . $selectedCityData['provinsi'] ?>
    </h2>
        <div class="swiper-container">
            <div class="swiper">
                <div class="swiper-wrapper">
                   <div class="swiper-slide">
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                           <a href="cuaca.php?kota=<?= $prevCity ?>"  onclick="reloadPage(event)" style="text-decoration: none; color: #000; font-size: 20px; display:flex;align-items: center;">
                                <img style="width:16px;height:22px;margin-right: 16px;" src="assets/image/prev_btn.png" class="swiper-button-prev"/>
                           </a>

                           <a style="text-decoration: none; color: #000; font-size: 20px;" href="cuaca.php?kota=<?= $selectedCity ?>">
                                 <?= $selectedCity ?>
                           </a>
                           <a href="cuaca.php?kota=<?= $nextCity ?>" onclick="reloadPage(event)" style="text-decoration: none; color: #000; font-size: 20px; display:flex;align-items: center;">
                              <img style="width:16px;height:22px;margin-left: 16px;" src="assets/image/next_btn.png" class="swiper-button-next"/>
                           </a>
                       </div>
                  </div>
              </div>
            </div>
       </div>

      <div class="current-weather-container">
        <?php
             // Pemetaan ikon
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


            $timezone = $selectedCityData['timezone'] ?? 'Asia/Jakarta';
            $now = new DateTime('now', new DateTimeZone($timezone));

            $currentForecast = null;
            $minDiff = PHP_INT_MAX;

           if (isset($selectedCityData['cuaca'])){
                 foreach ($selectedCityData['cuaca'] as $forecast_set) {
                    foreach ($forecast_set as $forecast) {
                         if (isset($forecast['local_datetime'])){
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
               echo '<div class="current-weather-time" style =" font-size: 20px; text-align : center;" id="realtime-clock">' . $formatted_time . ' WIB</div>';
                  echo '<div class="current-weather-temp" style =" display: flex; justify-content: center; align-items: center; font-size: 30px;">' . (isset($currentForecast['t']) ? $currentForecast['t'] : 'N/A') . '°C</div>';
                 echo '<div class="current-weather-icon" style="display: flex; justify-content: center; align-items: center; font-size: 30px; flex-direction:row;">
                          <span style="margin-right: 18px; margin-top: -24px">' . $icon_html . '</span>
                         <span>' . $weather_desc . '</span>
                     </div>';
                echo '<div class="current-weather-humidity" style="display: flex; justify-content: center; align-items: center; font-size: 16px;">💧' . (isset($currentForecast['hu']) ? $currentForecast['hu'] : 'N/A') . ' %</div>';
              echo '</div>';
          }
         ?>
      </div>
    <div class="filter-container">
       <select onchange="filterTable(this.value)">
            <option value="all">Tiga Hari Kedepan</option>
            <option value="today">Hari Ini</option>
           <option value="tomorrow">Besok</option>
            <option value="today-tomorrow">Hari Ini & Besok</option>
        </select>
   </div>
    <div class="weather-table-container">
        <table class="weather-table" id="weatherTable">
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
                if (isset($selectedCityData['cuaca'])){
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

                            echo '<tr data-date="' . $formatted_date . '">';
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
                }

                ?>
            </tbody>
        </table>
    </div>
</section>
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper', {
        // Optional parameters
        direction: 'horizontal',
        loop: false,

        // If we need pagination
    });
    function updateClock() {
      const clockElement = document.getElementById('realtime-clock');
        const timezone = '<?php echo $selectedCityData['timezone']; ?>'; // Get the timezone from PHP
       const date = new Date();
       const options = {
           timeZone: timezone,
            hour: '2-digit',
            minute: '2-digit',
       };
        const formattedTime = date.toLocaleTimeString(undefined, options);

       clockElement.textContent = formattedTime + ' WITA';
  }

    // Update the clock every second
   setInterval(updateClock, 1000);

    // Initial clock update
    updateClock();
    function filterTable(filter) {
            const table = document.getElementById('weatherTable');
            const rows = table.getElementsByTagName('tr');
            const today = new Date();
           const tomorrow = new Date(today);
           tomorrow.setDate(today.getDate() + 1);
            const threeDaysAhead = new Date(today);
            threeDaysAhead.setDate(today.getDate() + 3)
           for (let i = 1; i < rows.length; i++) { // start from 1 to skip header row
                const row = rows[i];
               const rowDate = new Date(row.getAttribute('data-date'));

               if (rowDate && filter !== 'all') {
                    let showRow = false;
                   if (filter === 'today' && rowDate.toDateString() === today.toDateString()) {
                        showRow = true;
                  }else if (filter === 'tomorrow' && rowDate.toDateString() === tomorrow.toDateString()){
                        showRow = true;
                   } else if (filter === 'today-tomorrow' && (rowDate.toDateString() === today.toDateString() || rowDate.toDateString() === tomorrow.toDateString())) {
                       showRow = true;
                   }

                    if (showRow){
                        row.style.display = '';
                    } else{
                       row.style.display = 'none';
                  }
               }else{
                    row.style.display = ''; // Show all if filter is 'all'
                }
            }
       }

   function reloadPage(event) {
        event.preventDefault();
       window.location.href = event.currentTarget.getAttribute('href');
   }
</script>
<script src="../nav/assets-nav/js/main.js"></script>

</body>
</html>