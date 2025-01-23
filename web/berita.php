<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita BMKG Stasiun Juwata Tarakan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
        }

        .news-row {
            display: flex;
            flex-wrap: wrap;
        }

        .highlight-news {
            width: 65%;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 15px;
        }

        .highlight-news img {
            width: 100%;
            height: auto;
            display: block;
        }

        .highlight-news .news-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .side-news {
            width: 35%;
            display: flex;
            flex-direction: column;
            padding: 15px;
        }

        .news-item {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 15px;
        }

         .news-item:last-child {
            margin-bottom: 0; /* Menghapus margin bawah di item terakhir */
        }

        .news-item img {
            width: 100%;
            height: auto;
            display: block;
        }

        .news-item .news-content {
            padding: 15px;
        }

       .news-content p.date {
            color: #777;
            font-size: 0.9em;
            margin-bottom: 8px;
        }

        .news-content h3 {
            margin-bottom: 10px;
            font-size: 1.2em;
        }

        .news-content p {
            margin-bottom: 15px;
        }

        .news-content a {
            color: #104a7b;
            text-decoration: none;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .news-content a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .news-row {
                flex-direction: column;
            }
          .highlight-news,
            .side-news {
                width: 100%;
                padding: 0;
            }

             .news-item {
                  margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="news-row">
            <div class="highlight-news">
                <img src="gambar1.jpg" alt="Ravalnas 2024">
                <div class="news-content">
                    <p class="date">22 Januari 2025</p>
                    <h3>Ravalnas 2024, Transformasi BMKG Menuju Indonesia Emas 2045</h3>
                    <p>Badan Meteorologi, Klimatologi, dan Geofisika (BMKG) menyelenggarakan Rapat Evaluasi Nasional (Ravalnas) Tahun 2024 sebagai bentuk reformasi birokrasi dalam transformasi BMKG menuju Indonesia Emas 2045.</p>
                    <a href="#">Baca selengkapnya →</a>
                </div>
            </div>
            <div class="side-news">
                <div class="news-item">
                    <img src="gambar2.jpg" alt="Rekonsiliasi Laporan Keuangan">
                    <div class="news-content">
                        <p class="date">18 Januari 2025</p>
                        <h3>Balai Besar MKG Wilayah IV Makassar Adakan Rekonsiliasi Laporan Keuangan Semester II Tahun Anggaran 2024</h3>
                        <a href="#">Baca selengkapnya →</a>
                    </div>
                </div>
                <div class="news-item">
                    <img src="gambar3.jpg" alt="Natal Oikumene">
                    <div class="news-content">
                        <p class="date">18 Januari 2025</p>
                        <h3>BMKG Gelar Perayaan Natal Oikumene dengan Penuh Kehangatan dan Sukacita</h3>
                        <a href="#">Baca selengkapnya →</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>