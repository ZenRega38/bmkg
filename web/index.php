<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>BMKG Tarakan - Stasiun Meteorologi JUWATA</title>

    <!-- Library Stylesheets -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Icons & Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Panzoom Library -->
    <script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>

    <!-- Custom Modernized Stylesheet -->
    <link rel="stylesheet" href="css/beranda.css">
    <link rel="stylesheet" href="css/outer.css">
    <link rel="stylesheet" href="css/berita.css">
</head>

<body>

    <!-- Header & Navigation Menu -->
    <?php include 'widget/header.php'; ?>

    <!-- Real-Time Time clocks Banner -->
    <div class="clock-container">
        <div class="date-day" id="dateDay">Loading...</div>
        <div class="clock" id="utcClock">UTC: <span id="utcTime">00:00:00</span></div>
        <div class="clock" id="witaClock">WITA: <span id="witaTime">00:00:00</span></div>
    </div>

    <!-- Weather Dashboard (Cuaca Saat Ini) -->
    <section class="Cuacaterkini" id="Cuacaterkini">
        <div class="row">
            <!-- Left Panel: Current Weather Stats -->
            <div class="content-section">
                <div class="title">
                    <h1>Cuaca Saat Ini</h1>
                </div>
                <div class="content">
                    <div class="weather-info">
                        <div class="info-item large">
                            <span class="label">Suhu</span>
                            <span class="value" id="suhu">- Â°C</span>
                        </div>
                        <div class="info-item large">
                            <span class="label">Keadaan Cuaca</span>
                            <span class="value" id="cuaca">-</span>
                        </div>
                        <div class="info-item small">
                            <span class="label">Kecepatan Angin</span>
                            <span class="value" id="kecepatan-angin">-</span>
                        </div>
                        <div class="info-item small">
                            <span class="label">Arah Angin</span>
                            <span class="value" id="arah-angin">-</span>
                        </div>
                        <div class="info-item small">
                            <span class="label">Kelembapan</span>
                            <span class="value" id="kelembaban">-</span>
                        </div>
                    </div>
                    <div class="button">
                        <a href="cuaca.php" class="button-btn">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Right Panel: Weather Radar Map / Satellite Imagery -->
            <div class="images-section">
                <!-- Interactive Leaflet Map -->
                <div id="map"></div>
                
                <!-- Satellite Animation Image Card -->
                <div id="citraSatelitContainer" style="display:none">
                    <div class="card">
                        <div class="card-body">
                             <?php
                                $satelitUrl = "proxy-image.php";
                                 if (true): // Always attempt to load since proxy handles it ?>
                                    <img src="<?= $satelitUrl; ?>" class="img-fluid" alt="Citra Satelit" data-bs-toggle="modal" data-bs-target="#modalSatelit">
                                 <?php else: ?>
                                    <div class="alert alert-danger m-3" role="alert">
                                        <i class="fa-solid fa-circle-exclamation"></i> Citra satelit tidak dapat dimuat saat ini.
                                    </div>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <button id="changeMapButton">Lihat Citra Satelit</button>

                <!-- Fullscreen Zoomable Satellite Modal -->
                <div class="modal fade" id="modalSatelit" tabindex="-1" aria-labelledby="modalSatelitLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content" style="background: #111827; border: 1px solid var(--bmkg-border);">
                             <div class="modal-header" style="border-bottom: 1px solid var(--bmkg-border);">
                                <h5 class="modal-title" id="modalSatelitLabel" style="color: #fff;"><i class="fa-solid fa-satellite"></i> Citra Satelit BMKG Tarakan</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="overflow: hidden; position: relative; background: #0b1120;">
                                <div id="satellite-container" style="overflow: hidden; min-height: 400px; display: flex; align-items: center; justify-content: center;">
                                    <img src="<?= $satelitUrl; ?>" class="img-fluid satellite-image" alt="Citra Satelit Animation" style="border-radius: 8px;">
                                </div>
                                <div class="zoom-controls" style="position: absolute; top: 20px; right: 20px; z-index: 1000; display: flex; flex-direction: column; gap: 8px;">
                                    <button class="btn btn-primary btn-sm zoom-in" style="background: rgba(14, 165, 233, 0.85); border: none;"><i class="fas fa-search-plus"></i></button>
                                    <button class="btn btn-primary btn-sm zoom-out" style="background: rgba(14, 165, 233, 0.85); border: none;"><i class="fas fa-search-minus"></i></button>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top: 1px solid var(--bmkg-border);">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sub-District Weather Grid (Kecamatan Tarakan) -->
    <?php include 'widget/kartu-cuaca.php'; ?>

    <!-- Weather Magazine Carousel Section -->
    <section class="UMKM">
        <h1>Weather Magazine</h1>
        <p>Baca Majalah Cuaca Terkini di W'Mag Juwata Tarakan.</p>
        <div class="imgBox">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php
                    $wmagzFile = __DIR__ . '/assets/json/data-wmagz.json';
                    $latestMagazines = [];
                    if (file_exists($wmagzFile)) {
                        $wmagzJson = json_decode(file_get_contents($wmagzFile), true);
                        if ($wmagzJson && isset($wmagzJson['magazines'])) {
                            foreach ($wmagzJson['magazines'] as $year => $months) {
                                foreach ($months as $month => $item) {
                                    $item['_timestamp'] = strtotime("1 $month $year");
                                    $latestMagazines[] = $item;
                                }
                            }
                        }
                    }
                    
                    usort($latestMagazines, function($a, $b) {
                        return $b['_timestamp'] <=> $a['_timestamp'];
                    });
                    
                    $latestMagazines = array_slice($latestMagazines, 0, 5); // Ambil 5 terbaru
                    $latestMagazines = array_reverse($latestMagazines); // Urutkan terlama -> terbaru (terbaru ada di paling kanan / index terakhir)
                    
                    if (!empty($latestMagazines)):
                        foreach ($latestMagazines as $mag):
                    ?>
                    <div class="swiper-slide">
                        <a href="<?= htmlspecialchars($mag['link'] ?? '#') ?>">
                            <img src="<?= htmlspecialchars($mag['coverImage'] ?? '') ?>" alt="<?= htmlspecialchars($mag['title'] ?? '') ?>">
                        </a>
                        <h2><?= htmlspecialchars($mag['title'] ?? '') ?></h2>
                        <p><?= htmlspecialchars($mag['summary'] ?? '') ?></p>
                    </div>
                    <?php 
                        endforeach;
                    else:
                    ?>
                    <div class="swiper-slide">
                        <p style="text-align: center; color: white;">Belum ada majalah tersedia.</p>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- Swiper Navigation Buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Latest Earthquake Information -->
    <section class="gempa">
       <?php include 'widget/gempa.php'; ?>
    </section>

    <!-- News & Station Activities Section -->
    <section class="kegiatan-bmkg">
        <h1>Kegiatan Stasiun Meteorologi JUWATA</h1>
        <p>Berita Terbaru Stasiun Meteorologi Juwata Tarakan</p>
        <main class="row-berita">
            <?php
            $beritaFile = __DIR__ . '/assets/json/data-berita.json';
            $beritaList = [];
            if (file_exists($beritaFile)) {
                $beritaList = json_decode(file_get_contents($beritaFile), true) ?? [];
            }
            // Urutkan berita berdasarkan id terbesar (terbaru)
            usort($beritaList, function($a, $b) {
                return ($b['id'] ?? 0) <=> ($a['id'] ?? 0);
            });
            // Ambil 3 berita terbaru saja
            $latestBerita = array_slice($beritaList, 0, 3);
            
            if (!empty($latestBerita)):
                foreach ($latestBerita as $news):
            ?>
            <div class="news-item">
                 <img src="<?= htmlspecialchars($news['image'] ?? 'assets/image/map_satelite.png') ?>" alt="<?= htmlspecialchars($news['title'] ?? '') ?>" onerror="this.src='assets/image/map_satelite.png'">
                 <div class="news-content">
                     <p class="date"><?= htmlspecialchars($news['date'] ?? '') ?></p>
                     <h3><?= htmlspecialchars($news['title'] ?? '') ?></h3>
                     <p><?= htmlspecialchars($news['summary'] ?? '') ?></p>
                     <a href="detail-berita.php?id=<?= $news['id'] ?>">Baca selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                 </div>
            </div>
            <?php 
                endforeach;
            else:
            ?>
            <p style="width: 100%; text-align: center; color: #666;">Belum ada berita terbaru.</p>
            <?php endif; ?>
        </main>
    </section>

    <!-- Footer -->
    <?php include 'widget/footer.php'; ?>

    <!-- Core Library Scripts -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Core Custom JavaScript -->
    <script src="assets/script/nav.js"></script>
    <script src="assets/script/modern-bmkg.js" defer></script>
</body>

</html>


