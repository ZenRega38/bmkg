<?php
// URL JSON dari BMKG
$jsonUrl = 'https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json';

// Mendapatkan data JSON
$jsonData = file_get_contents($jsonUrl);
$data = json_decode($jsonData, true);

// Mendapatkan informasi gempa
$gempa = $data['Infogempa']['gempa'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Gempa Terkini</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        .container-gempa {
            max-width: 1200px;
            margin: 20px auto;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            display: flex;
            gap: 20px;
        }

        .shakemap {
            flex: 1;
        }

        .shakemap img {
            width: 100%;
            border-radius: 8px;
        }

        .info {
            flex: 2;
            padding: 15px;
        }

        .info h2 {
            font-size: 1.8em;
            margin-bottom: 10px;
            color: #333;
        }

        .info p {
            margin: 8px 0;
            font-size: 1.1em;
            line-height: 1.5;
        }

        .badge {
            background-color: #4CAF50;
            color: #fff;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9em;
            display: inline-block;
            margin-bottom: 15px;
        }

        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .stat-box {
            flex: 1 1 calc(33.333% - 15px);
            background-color: #f4f4f9;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-box strong {
            display: block;
            font-size: 1.2em;
            color: #0057a3;
            margin-bottom: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        }

        .footer a {
            color: #0057a3;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container-gempa">
        <!-- Bagian Shakemap -->
        <div class="shakemap">
            <img src="<?= 'https://data.bmkg.go.id/DataMKG/TEWS/' . $gempa['Shakemap']; ?>" alt="Shakemap">
        </div>

        <!-- Bagian Informasi Gempa -->
        <div class="info">
            <h2>Gempa Bumi Terkini</h2>
            <p class="badge">Gempa Dirasakan</p>
            <p><strong>Pusat Gempa:</strong> <?= $gempa['Wilayah']; ?></p>
            <p><strong>Tanggal:</strong> <?= $gempa['Tanggal']; ?>, <?= $gempa['Jam']; ?> WIB</p>
            <p><strong>Saran BMKG:</strong> Hati-hati terhadap gempa bumi susulan yang mungkin terjadi.</p>

            <div class="stats">
                <div class="stat-box">
                    <strong><?= $gempa['Magnitude']; ?></strong>
                    Magnitudo
                </div>
                <div class="stat-box">
                    <strong><?= $gempa['Kedalaman']; ?></strong>
                    Kedalaman
                </div>
                <div class="stat-box">
                    <strong><?= $gempa['Coordinates']; ?></strong>
                    Koordinat
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <p><a href="https://www.bmkg.go.id/gempabumi">Lihat Selengkapnya</a></p>
    </footer>
</body>
</html>
