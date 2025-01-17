<!DOCTYPE html>
<html lang="id">
<head>
<link rel="stylesheet" href="css/outer.css">
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f8ff;
        }
        
        .header {
            background-color: #5f9ea0;
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
        }
        
        .logo {
            width: 100px;
            height: 100px;
            margin-right: 20px;
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
            background-color: #4682b4;
            color: white;
            padding: 10px;
            text-align: center;
            margin-top: 20px;
        }
        
        .weather-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .weather-table th {
            background-color: #5f9ea0;
            color: white;
            padding: 10px;
            text-align: center;
        }
        
        .weather-table td {
            background-color: #5f9ea0;
            color: white;
            padding: 10px;
            text-align: center;
            border: 1px solid #4682b4;
        }
        
        .weather-icons {
            background-color: #4682b4;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        
        .footer {
            background-color: #2F4F4F;
            color: white;
            padding: 20px;
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
    <div class="header">
        <img src="c:\Users\ASUS\Downloads\IMG_3213-removebg-preview.png" alt="BMKG Logo" class="logo">
        <div class="title">
            <h1>Badan Meteorologi, Klimatologi, dan Geofisika Tarakan</h1>
            <div class="subtitle">Cepat, Tepat, Akurat, Luas, dan Mudah Dipahami</div>
        </div>
    </div>
    
    <div class="address">
        JL. MULAWARMAN,TARAKAN - 77111, KALIMANTAN UTARA
    </div>
    
    <div class="forecast-title">
        Prakiraan Cuaca Kalimantan Utara
    </div>
    
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

    
    <div class="footer">
        <div>
            KANTOR PUSAT<br>
            Stasiun Meteorologi Juata Tarakan<br>
            JL.Mulawarman - (0551) 21629/51606<br>
            Telp. 08115396509
        </div>
        <div class="social-icons">
            <img src="icon/838d85ce-ad66-44e8-b9eb-87d238ff6d27-removebg-preview.png" alt="Instagram">
            <img src="icon/facebook.png" alt="Facebook">
            <img src="icon/twitter.png" alt="Twitter">
            <img src="icon/gmail.png" alt="Email">
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>      ][]