<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>BMKG Tarakan - Stasiun Meteorologi JUWATA</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/tes-beranda.css">
    <link rel="stylesheet" href="css/outer.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script type="text/javascript">
        $(window).on('scroll', function(){
            if ($(window).scrollTop()) {
                $('header').addClass('black');
            } else {
                $('header').removeClass('black');
            }
        })
    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <!-- Cuaca Saat Ini Section -->
    <section class="cuaca-terkini" id="cuaca-terkini">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Cuaca Saat Ini</h1>
                    <p>Informasi cuaca terkini di Tarakan dan sekitarnya.</p>
                    <a href="Tentang Kami.html" class="btn btn-primary">Baca Selengkapnya</a>
                </div>
                <div class="col-md-6">
                    <video src="images/demo_video.mp4" loop autoplay muted></video>
                </div>
            </div>
        </div>
    </section>

    <!-- Weather Magazine Section -->
    <section class="weather-magazine">
        <div class="container">
            <h1>Weather Magazine</h1>
            <p>Baca Majalah Cuaca Terkini di W'Mag.</p>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="magazine_january_2025/viewer.html">
                            <img src="magazine_january_2025/pages/1.jpg" alt="W'Mag January 2025">
                            <h2>W'Magz January 2025</h2>
                            <p>Kilas Balik Desember 2024</p>
                        </a>
                    </div>
                    <!-- Additional slides as needed -->
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>

    <!-- Visualisasi Citra Satelit Section -->
    <section class="citra-satelit">
        <div class="container text-center">
            <h1>Visualisasi Citra Satelit</h1>
            <div class="image-container">
                <?php
                $satelit_url = "http://satelit.bmkg.go.id/IMAGE/ANIMASI/H08_EH_Region3_m18.gif";
                if (@get_headers($satelit_url)) {
                    echo '<img src="' . $satelit_url . '" alt="Citra Satelit">';
                } else {
                    echo '<p class="text-danger">Citra satelit tidak dapat dimuat. Silakan coba lagi nanti.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Info Gempa Terkini Section -->
    <section class="info-gempa">
        <div class="container">
            <h1>Info Gempa Terkini</h1>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="<?= 'https://data.bmkg.go.id/DataMKG/TEWS/' . $gempa['Shakemap']; ?>" alt="Shakemap">
                </div>
                <div class="col-md-6">
                    <p><strong>Pusat Gempa:</strong> <?= $gempa['Wilayah']; ?></p>
                    <p><strong>Tanggal:</strong> <?= $gempa['Tanggal']; ?>, <?= $gempa['Jam']; ?> WIB</p>
                    <p><strong>Magnitudo:</strong> <?= $gempa['Magnitude']; ?></p>
                    <p><strong>Kedalaman:</strong> <?= $gempa['Kedalaman']; ?></p>
                    <p><strong>Koordinat:</strong> <?= $gempa['Coordinates']; ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cuaca Bandara Section -->
    <section class="cuaca-bandara">
        <div class="container text-center">
            <h1>METAR Juwata</h1>
            <a href="https://metar-taf.com/WAQQ" id="metartaf-8NNSRaLU" style="font-size:18px; font-weight:500; color:#000; width:300px; height:435px; display:block">METAR Juwata</a>
            <script async defer crossorigin="anonymous" src="https://metar-taf.com/embed-js/WAQQ?qnh=hPa&rh=rh&target=8NNSRaLU"></script>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            coverflowEffect: {
                rotate: 10,
                stretch: 0,
                depth: 200,
                modifier: 1,
                slideShadows: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            loop: true
        });
    </script>
</body>
</html>
