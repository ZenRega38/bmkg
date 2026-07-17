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
                    <div class="swiper-slide">
                        <a href="assets/wmagz/magazine_january_2025/viewer.html">
                            <img src="assets/wmagz/magazine_january_2025/pages/1.webp" alt="W'Magz January 2025 Page 1">
                        </a>
                        <h2>W'Magz January 2025</h2>
                        <p>Kilas Balik Desember 2024</p>
                    </div>
                    <div class="swiper-slide">
                        <a href="assets/wmagz/magazine_january_2025/viewer.html">
                            <img src="assets/wmagz/magazine_january_2025/pages/1.webp" alt="W'Magz January 2025 Page 2">
                        </a>
                        <h2>W'Magz January 2025</h2>
                        <p>Kilas Balik Desember 2024</p>
                    </div>
                    <div class="swiper-slide">
                        <a href="assets/wmagz/magazine_january_2025/viewer.html">
                            <img src="assets/wmagz/magazine_january_2025/pages/1.webp" alt="W'Magz January 2025 Page 3">
                        </a>
                        <h2>W'Magz January 2025</h2>
                        <p>Kilas Balik Desember 2024</p>
                    </div>
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
            <div class="news-item">
                 <img src="gambar1.jpg" alt="Ravalnas 2024" onerror="this.src='assets/image/map_satelite.png'">
                 <div class="news-content">
                     <p class="date">22 Januari 2025</p>
                     <h3>Ravalnas 2024, Transformasi BMKG Menuju Indonesia Emas 2045</h3>
                     <p>Badan Meteorologi, Klimatologi, dan Geofisika (BMKG) menyelenggarakan Rapat Evaluasi Nasional (Ravalnas) Tahun 2024 sebagai bentuk reformasi birokrasi dalam transformasi BMKG menuju Indonesia Emas 2045.</p>
                     <a href="#">Baca selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                 </div>
            </div>
            <div class="news-item">
                 <img src="gambar2.jpg" alt="Rekonsiliasi Laporan Keuangan" onerror="this.src='assets/image/map_satelite.png'">
                 <div class="news-content">
                     <p class="date">18 Januari 2025</p>
                     <h3>Balai Besar MKG Wilayah IV Makassar Adakan Rekonsiliasi Laporan Keuangan Semester II TA 2024</h3>
                     <p>Balai Besar MKG Wilayah IV Makassar menyelenggarakan kegiatan rekonsiliasi penyusunan Laporan Keuangan Semester II Tahun Anggaran 2024 secara akuntabel.</p>
                     <a href="#">Baca selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                 </div>
            </div>
            <div class="news-item">
                 <img src="gambar3.jpg" alt="Natal Oikumene" onerror="this.src='assets/image/map_satelite.png'">
                 <div class="news-content">
                     <p class="date">18 Januari 2025</p>
                      <h3>BMKG Gelar Perayaan Natal Oikumene dengan Penuh Kehangatan</h3>
                      <p>Keluarga besar BMKG menggelar ibadah perayaan Natal Oikumene bersama untuk memperkuat persaudaraan, cinta kasih, dan kinerja dalam harmoni.</p>
                     <a href="#">Baca selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                 </div>
            </div>
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


