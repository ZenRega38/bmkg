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
            <!-- Bagian Konten -->
            <div class="content-section">
                <div class="title"><h1>Cuaca Saat ini</span></h1>
                </div>
                <div class="content">
                    <h3></h3>
                    <p>
                    </p>
                    <div class="button"><a href="Tentang Kami.html"class ="button-btn">Baca selengkapnya</a>
                    </div>
                </div>
            </div>
            <!-- Bagian Gambar -->
            <div class="images-section">
                <video src="images/" loop autoplay ="About TarakTrade">
            </div>
        </div>
    </section>
    <section class="UMKM">
        <h1>Weather Magazine</h1>
        <p>Baca Majalah Cuaca Terkini di W'Mag.</p>
        <div class="imgBox">
                <div class="swiper-container">
                    <img class="swiper-button-prev" src="assets/image/prev_btn.png"> <!-- Added -->
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="magazine_january_2025/viewer.html">
                                <img src="magazine_january_2025/pages/1.jpg">
                            </a>
                            <h2>W'Magz January 2025</h2>
                            <p>Kilas Balik Desember 2024</p>
                        </div>
                        <div class="swiper-slide">
                            <a href="magazine_january_2025/viewer.html">
                                <img src="magazine_january_2025/pages/1.jpg">
                            </a>
                            <h2>W'Magz January 2025</h2>
                            <p>Kilas Balik Desember 2024</p>
                        </div>
                        <div class="swiper-slide">
                            <a href="magazine_january_2025/viewer.html">
                                <img src="magazine_january_2025/pages/1.jpg">
                            </a>
                            <h2>W'Magz January 2025</h2>
                            <p>Kilas Balik Desember 2024</p>
                        </div>
                        <div class="swiper-slide">
                            <a href="magazine_january_2025/viewer.html">
                                <img src="magazine_january_2025/pages/1.jpg">
                            </a>
                            <h2>W'Magz January 2025</h2>
                            <p>Kilas Balik Desember 2024</p>
                        </div>
                        <div class="swiper-slide">
                            <a href="magazine_january_2025/viewer.html">
                                <img src="magazine_january_2025/pages/1.jpg">
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
                slideShadows: true,
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
        <h1>SKM</h1>
        <p>Isi Deskripsi disini</p>
    </section>

    <section class="gempa">
        <?php include 'tes-gempa.php'; ?>
    </section>
    <script src="assets/script/nav.js"></script>
    <?php include 'footer.php'; ?>
</body>
