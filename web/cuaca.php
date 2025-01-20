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
            background-color: rgba(255, 255, 255, 0.9); /* Ditambahkan untuk meningkatkan keterbacaan */
        }
        
        .weather-table th {
            background-color: #5f9ea0;
            color: white;
            padding: 10px;
            text-align: center;
        }
        
        .weather-table td {
            background-color: rgba(95, 158, 160, 0.8); /* Diubah untuk transparansi */
            color: white;
            padding: 10px;
            text-align: center;
            border: 1px solid #4682b4;
        }
        
        .weather-icons {
            background-color: rgba(70, 130, 180, 0.9); /* Diubah untuk transparansi */
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
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<section>
<h2 class="forecast-title">
        Prakiraan Cuaca Kalimantan Utara
    </h2>
    
    <table class="weather-table">
        <thead>
            <tr>
                <th rowspan="2">Lokasi</th>
                <th colspan="4">Cuaca</th>
                <th rowspan="2">Angin</th>
                <th rowspan="2">Kelembapan</th>
                <th rowspan="2">Suhu</th>
                <th rowspan="2">Prakiraan Tinggi Gelombang</th>
            </tr>
            <tr>
                <th>Pagi</th>
                <th>Siang</th>
                <th>Sore</th>
                <th>Dini Hari</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tanjung Selor</td>
                <td>☀️</td>
                <td>☁️</td>
                <td>🌦️</td>
                <td>🌧️</td>
                <td>30 - 55</td>
                <td>30 - 55</td>
                <td>30 - 55</td>
                <td</td>
                <td rowspan="5">
                    <img src="icon/w_maps.PNG" alt="Weather Map">
                </td>
            </tr>

            <tr>
                <td>Nunukan</td>
                <td>☀️</td>
                <td>☁️</td>
                <td>🌦️</td>
                <td>🌧️</td>
                <td>30 - 55</td>
                <td>30 - 55</td>
                <td>30 - 55</td>
            </tr>

            <tr>
                <td>Malinau</td>
                <td>☀️</td>
                <td>☁️</td>
                <td>🌦️</td>
                <td>🌧️</td>
                <td>30 - 55</td>
                <td>30 - 55</td>
                <td>30 - 55</td>
            </tr>

            <tr>
                <td>Tanah Tidung</td>
                <td>☀️</td>
                <td>☁️</td>
                <td>🌦️</td>
                <td>🌧️</td>
                <td>30 - 55</td>
                <td>30 - 55</td>
                <td>30 - 55</td> 
            </tr>

            <tr>
                <td>Tarakan</td>
                <td>☀️</td>
                <td>☁️</td>
                <td>🌦️</td>
                <td>🌧️</td>
                <td>30 - 55</td>
                <td>30 - 55</td>
                <td>30 - 55</td>
            </tr>
            <!-- Repeat similar rows for other locations -->
        </tbody>
    </table>
    
    <div class="weather-icons">
        <span>☀️ = Cerah</span>
        <span>☁️ = Berawan</span>
        <span>⛈️ = Hujan petir</span>
        <span>🌧️ = Hujan</span>
    </div>
</section>

    <?php include 'footer.php'; ?>
</body>
</html>      ][]