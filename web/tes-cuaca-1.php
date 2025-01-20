<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prakiraan Cuaca BMKG</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: auto;
        }
        h1 {
            text-align: center;
        }
         .cuaca-item {
           margin-bottom: 10px;
           border: 1px solid #ddd;
          padding: 10px;
           border-radius: 4px;
            overflow-x: auto; /* Enable horizontal scrolling for long items */
        }
        .cuaca-item h3 {
            margin-top: 0;
        }
       .error {
           color: red;
           margin-top: 10px;
            text-align: center;
        }
       table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
           padding: 8px;
           text-align: left;
        }
       th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Prakiraan Cuaca BMKG</h1>
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
           //  var_dump($data); // Debugging: display the structure of the data

            if (isset($data['data'])) {
                foreach ($data['data'] as $location_data) {
                  $adm2 = isset($location_data['lokasi']['adm2']) ? $location_data['lokasi']['adm2'] : 'N/A';
                  $provinsi = isset($location_data['lokasi']['provinsi']) ? $location_data['lokasi']['provinsi'] : 'N/A';
                  $kotkab = isset($location_data['lokasi']['kotkab']) ? $location_data['lokasi']['kotkab'] : 'N/A';
                  
                  echo '<div class="cuaca-item">';
                  echo '<h3>' . $kotkab . ', ' . $provinsi . '</h3>';
                  echo '<table>';
                   echo '<thead>';
                   echo '<tr>';
                     echo '<th>Waktu</th>';
                     echo '<th>Suhu</th>';
                     echo '<th>Tutupan Awan</th>';
                     echo '<th>Tekanan Udara</th>';
                     echo '<th>Cuaca</th>';
                     echo '<th>Deskripsi Cuaca (ID)</th>';
                      echo '<th>Deskripsi Cuaca (EN)</th>';
                    echo '<th>Arah Angin</th>';
                     echo '<th>Arah Angin ke</th>';
                    echo '<th>Kecepatan Angin</th>';
                   echo '<th>Kelembapan Udara</th>';
                    echo '<th>Jarak Pandang</th>';
                    echo '<th>Waktu Analisis</th>';
                     echo '<th>UTC Datetime</th>';
                     echo '<th>Local Datetime</th>';
                   echo '</tr>';
                   echo '</thead>';
                   echo '<tbody>';
                   foreach ($location_data['cuaca'] as $forecast_set) {
                      foreach ($forecast_set as $forecast) {
                       echo '<tr>';
                            echo '<td>' . (isset($forecast['datetime']) ? $forecast['datetime'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($forecast['t']) ? $forecast['t'] : 'N/A') . ' °C</td>';
                            echo '<td>' . (isset($forecast['tcc']) ? $forecast['tcc'] : 'N/A') . ' %</td>';
                           echo '<td>' . (isset($forecast['tp']) ? $forecast['tp'] : 'N/A') . '</td>';
                           echo '<td>' . (isset($forecast['weather']) ? $forecast['weather'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($forecast['weather_desc']) ? $forecast['weather_desc'] : 'N/A') . '</td>';
                           echo '<td>' . (isset($forecast['weather_desc_en']) ? $forecast['weather_desc_en'] : 'N/A') . '</td>';
                           echo '<td>' . (isset($forecast['wd']) ? $forecast['wd'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($forecast['wd_to']) ? $forecast['wd_to'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($forecast['ws']) ? $forecast['ws'] : 'N/A') . ' km/jam</td>';
                            echo '<td>' . (isset($forecast['hu']) ? $forecast['hu'] : 'N/A') . ' %</td>';
                            echo '<td>' . (isset($forecast['vs_text']) ? $forecast['vs_text'] : 'N/A') . '</td>';
                             echo '<td>' . (isset($forecast['analysis_date']) ? $forecast['analysis_date'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($forecast['utc_datetime']) ? $forecast['utc_datetime'] : 'N/A') . '</td>';
                            echo '<td>' . (isset($forecast['local_datetime']) ? $forecast['local_datetime'] : 'N/A') . '</td>';
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
    </div>
</body>
</html>