<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two Column Content</title>
    <style>
        /* CSS untuk Container Utama */
        .content-container {
            display: flex;
            gap: 20px; /* Memberikan jarak antara kolom */
            justify-content: space-between; /* Menjaga jarak yang sama antara kolom */
            flex-wrap: wrap; /* Memungkinkan kolom untuk turun ke bawah pada layar kecil */
            margin: 20px;
        }

        /* CSS untuk Kolom Kiri */
        .content-left, .content-right {
            flex: 1; /* Membuat setiap kolom mengambil ruang yang sama */
            min-width: 250px; /* Minimum lebar setiap kolom */
            padding: 20px;
            border-radius: 8px; /* Membuat sudut lebih halus */
        }

        .content-left {
            background-color: #f4f4f4; /* Background untuk kolom kiri */
        }

        .content-right {
            background-color: #e9e9e9; /* Background untuk kolom kanan */
        }

        /* Responsif untuk layar kecil */
        @media (max-width: 768px) {
            .content-container {
                flex-direction: column; /* Menumpuk kolom secara vertikal pada layar kecil */
                text-align: center; /* Teks rata tengah pada layar kecil */
            }

            .content-left, .content-right {
                min-width: 100%; /* Kolom mengambil 100% lebar pada layar kecil */
            }
        }
    </style>
</head>
<body>

    <section class="content-section">
        <div class="content-container">
            <div class="content-left">
            <a href="https://metar-taf.com/WAQQ" id="metartaf-Qe7DZ9QK" style="font-size:18px; font-weight:500; color:#000; width:1000px; height:px; display:block">METAR Juwata</a>
            <script async defer crossorigin="anonymous" src="https://metar-taf.com/embed-js/WAQQ?layout=landscape&qnh=hPa&rh=rh&target=Qe7DZ9QK"></script>
            </div>
            <div class="content-right">
            <?php include 'tes-skm.php'; ?>
            </div>
            </div>
        </div>
    </section>

</body>
</html>
