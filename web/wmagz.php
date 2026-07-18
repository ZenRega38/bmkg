<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>W'Magazine - BMKG Tarakan</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="css/wmagz.css">
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
    <?php include 'widget/header.php'; ?>
    <script src="assets/script/nav.js"></script>
    <section>
        <div class="content">
            <div class="textBox">
                <h2 style="color: #F4BE37;">W'<a href="wmagz.php" style="color: #000; text-decoration: none;">Magazines</a></h2>
                <p style="color: #000;">Weather Magazine merupakan publikasi meteorologi yang memberikan prakiraan cuaca akurat, analisis tren iklim, dan wawasan ilmiah dari Stasiun Meteorologi Juwata Tarakan.</p>
                <a class="Btn"href="wmagz-full.php">Learn More</a>
            </div>

            <div class="imgBox">
                <div class="swiper-container">
                    <img class="swiper-button-prev" src="assets/image/prev_btn.png"> <!-- Added -->
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
                    <img class="swiper-button-next" src="assets/image/next_btn.png"> <!-- Added -->
                </div>
            </div>

        </div>
    </section>
    <script src="assets/script/nav.js"></script>
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
    <?php include 'widget/footer.php'; ?>
</body>
</html>

