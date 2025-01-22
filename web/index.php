<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>BMKG Tarakan - Stasiun Meteorologi JUWATA</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/beranda.css">
    <link rel="stylesheet" href="css/outer.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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
    <section class="Cuacaterkini" id="Cuacaterkini">
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
                        <span class="value" id="suhu">28°C</span>
                    </div>
                    <div class="info-item large">
                        <span class="label">Cuaca:</span>
                        <span class="value" id="cuaca">Cerah</span>
                    </div>
                    <div class="info-item small">
                        <span class="label">Kecepatan Angin:</span>
                        <span class="value" id="kecepatan-angin">15 km/h</span>
                    </div>
                    <div class="info-item small">
                        <span class="label">Arah Angin:</span>
                        <span class="value" id="arah-angin">Timur Laut</span>
                    </div>
                    <div class="info-item small">
                        <span class="label">Kelembaban:</span>
                        <span class="value" id="kelembaban">80%</span>
                    </div>
                </div>
                <div class="button">
                    <a href="cuaca.php" class="button-btn">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
        <!-- Bagian Gambar -->
        <div class="images-section">
            <video src="images/cuaca-video.mp4" loop autoplay></video>
        </div>
    </div>
</section>
    <?php include 'kartu-cuaca.php'; ?>
    <section class="UMKM">
        <h1>Weather Magazine</h1>
        <p>Baca Majalah Cuaca Terkini di W'Mag.</p>
        <div class="imgBox">
                <div class="swiper-container">
                    <img class="swiper-button-prev" src="assets/image/prev_btn.png"> <!-- Added -->
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="magazine_january_2025/viewer.html">
                                <img src="magazine_january_2025/pages/1.png">
                            </a>
                            <h2>W'Magz January 2025</h2>
                            <p>Kilas Balik Desember 2024</p>
                        </div>
                        <div class="swiper-slide">
                            <a href="magazine_january_2025/viewer.html">
                                <img src="magazine_january_2025/pages/1.png">
                            </a>
                            <h2>W'Magz January 2025</h2>
                            <p>Kilas Balik Desember 2024</p>
                        </div>
                        <div class="swiper-slide">
                            <a href="magazine_january_2025/viewer.html">
                                <img src="magazine_january_2025/pages/1.png">
                            </a>
                            <h2>W'Magz January 2025</h2>
                            <p>Kilas Balik Desember 2024</p>
                        </div>
                        <div class="swiper-slide">
                            <a href="magazine_january_2025/viewer.html">
                                <img src="magazine_january_2025/pages/1.png">
                            </a>
                            <h2>W'Magz January 2025</h2>
                            <p>Kilas Balik Desember 2024</p>
                        </div>
                        <div class="swiper-slide">
                            <a href="magazine_january_2025/viewer.html">
                                <img src="magazine_january_2025/pages/1.png">
                            </a>
                            <h2>W'Magz January 2025</h2>
                            <p>Kilas Balik Desember 2024</p>
                        </div>
                    </div>
                    <img class="swiper-button-next" src="assets/image/next_btn.png"> <!-- Added -->
                </div>
            </div>
        </div>
    </section>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
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
                slideShadows: false,
            },
            navigation: {
             nextEl: ".swiper-button-next",
             prevEl: ".swiper-button-prev",
             },
            pagination: {
                el: '.swiper-pagination',
            },
            loop: true,
            on: {
                slideChangeTransitionStart: function () {
                var slides = this.slides;
                for (var i = 0; i < slides.length; i++) {
                    var slide = slides[i];
                    if (slide.classList.contains('swiper-slide-active')) {
                    slide.querySelector('h2').style.opacity = '1';
                    slide.querySelector('p').style.opacity = '1';
                    } else {
                    slide.querySelector('h2').style.opacity = '0';
                    slide.querySelector('p').style.opacity = '0';
                    }
                }
                },
            },
        });

    </script>
    <section class="SKM">
        <h1>Visualisasi Citra Satelit</h1>
        <p>Isi Deskripsi disini</p>
    </section>
    <section class="gempa">
        <?php include 'tes-gempa.php'; ?>
    </section>
    <section class="cuacabandara">
        <?php include 'tes-cuacabandara.php'; ?>
    </section>
    <?php include 'footer.php'; ?>
</body>
