<?php
// Function to read and decode JSON data from a file
function loadJsonData($filePath) {
    $jsonData = file_get_contents($filePath);
    $data = json_decode($jsonData, true);

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        die('Error decoding JSON from ' . $filePath . ': ' . json_last_error_msg());
    }

    return $data;
}

// Load news items data
$newsItems = loadJsonData('assets/json/data-berita.json');

// Load wmagz data
$magazinesData = loadJsonData('assets/json/data-wmagz.json');

// Access the magazines array
$magazinesByYear = $magazinesData['magazines'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/outer.css">
    <link rel="stylesheet" href="css/beranda.css">
    <link rel="stylesheet" href="css/berita.css">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>BMKG Tarakan - Stasiun Meteorologi JUWATA</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    <script src="assets/script/nav.js"></script>
    <div class="clock-container">
        <div class="date-day" id="dateDay"></div>
        <div class="clock" id="utcClock">UTC: <span id="utcTime"></span></div>
        <div class="clock" id="witaClock">WITA: <span id="witaTime"></span></div>
    </div>

    <section class="Cuacaterkini" id="Cuacaterkini" style="background: none">
    <div class="row">
        <!-- Bagian Konten Cuaca Terkini -->
        <div class="content-section">
        <div class="title">
            <h1>Cuaca Saat Ini</h1>
        </div>
        <div class="content">
            <div class="weather-info">
                <div class="info-item large">
                    <span class="label">Suhu:</span>
                    <span class="value" id="suhu"></span>
                </div>
                <div class="info-item large">
                    <span class="label">Cuaca:</span>
                    <span class="value" id="cuaca"></span>
                </div>
                <div class="info-item small">
                    <span class="label">Kecepatan Angin:</span>
                    <span class="value" id="kecepatan-angin"></span>
                </div>
                <div class="info-item small">
                    <span class="label">Arah Angin:</span>
                    <span class="value" id="arah-angin"></span>
                </div>
                <div class="info-item small">
                    <span class="label">Kelembaban:</span>
                    <span class="value" id="kelembaban"></span>
                </div>
            </div>
            <div class="button">
                <a href="cuaca.php" class="button-btn">Baca Selengkapnya</a>
            </div>
        </div>
        <div class="content" style="margin-top: 25px">
            <div class="weather-info">
                <a href="https://metar-taf.com/WAQQ" id="metartaf-lNcdCBQc" class="metar">METAR Juwata</a>
                <script async defer crossorigin="anonymous" src="https://metar-taf.com/embed-js/WAQQ?layout=landscape&qnh=hPa&rh=rh&target=lNcdCBQc"></script>
            </div>
        </div>
    </div>

        <!-- Bagian Gambar -->
        <div class="images-section">
            <div id="map" style="z-index: 0;"></div>
             <!-- Satelite Image Card-->
             <div id="citraSatelitContainer" style="display:none">
                 <div class="card">
                    <div class="card-body">
                         <?php
                            $satelitUrl = "proxy-image.php";
                             if (true): // Always attempt to load since proxy handles it ?>
                                <img src="<?= $satelitUrl; ?>" class="img-fluid" alt="Citra Satelit" data-bs-toggle="modal" data-bs-target="#modalSatelit">
                             <?php else: ?>
                                <p class="text-danger">Citra satelit tidak dapat dimuat. Silakan coba lagi nanti.</p>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
             <button id="changeMapButton">Change Map View</button>

             <!-- Modal untuk Citra Satelit -->
             <div class="modal fade" id="modalSatelit" tabindex="-1" aria-labelledby="modalSatelitLabel" aria-hidden="true">
                 <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                         <div class="modal-header">
                            <h5 class="modal-title" id="modalSatelitLabel">Citra Satelit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="overflow: hidden; position: relative;">
                            <div id="satellite-container" style="overflow: hidden;">
                                <img src="<?= $satelitUrl; ?>" class="img-fluid satellite-image" alt="Citra Satelit">
                            </div>
                            <div class="zoom-controls" style="position: absolute; top: 10px; right: 10px; z-index: 1000;">
                                <button class="btn btn-primary btn-sm zoom-in"><i class="fas fa-search-plus"></i></button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                     </div>
                 </div>
            </div>
        </div>

    </div>
</section>
    <?php include 'kartu-cuaca.php'; ?>
    <section class="UMKM">
        <h1>Weather Magazine</h1>
        <p>Baca Majalah Cuaca Terkini di W'Mag.</p>
        <div class="imgBox">
            <div class="swiper-container">
                <img class="swiper-button-prev" src="assets/image/prev_btn.png" alt="Previous">
                <div class="swiper-wrapper">
                    <?php foreach ($magazinesByYear as $year => $months): ?>
                         <?php foreach ($months as $month => $magazine): ?>
                                <div class="swiper-slide">
                                    <a href="<?= htmlspecialchars($magazine['link']) ?>">
                                        <img src="<?= htmlspecialchars($magazine['coverImage']) ?>" alt="<?= htmlspecialchars($magazine['title']) ?>">
                                    </a>
                                    <h2><?= htmlspecialchars($magazine['title']) ?></h2>
                                    <p><?= htmlspecialchars($magazine['summary']) ?></h2>
                                </div>
                        <?php endforeach; ?>
                 <?php endforeach; ?>
                </div>
                <img class="swiper-button-next" src="assets/image/next_btn.png" alt="Next">
            </div>
        </div>
    </section>
    <section class="gempa">
       <?php include 'gempa.php'; ?>
    </section>
    <section class="kegiatan-bmkg">
        <?php include 'berita.php'; ?>
    </section>
        <section class="cuacabandara">
    </section>
    <?php include 'footer.php'; ?>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/script/nav.js"></script>
    <script src="assets/script/modern-bmkg.js" defer></script>


</body>
</html>