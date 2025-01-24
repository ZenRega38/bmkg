<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>BMKG Tarakan - Stasiun Meteorologi JUWATA</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/beranda.css">
    <link rel="stylesheet" href="css/outer.css">
    <link rel="stylesheet" href="css/berita.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">


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
    <style>
        .clock-container {
            width: 91%; /* Adjusted to 100% */
            display: flex;
            justify-content: right;
            align-items: center;
            margin-bottom: 10px; /* Tambahkan margin jika perlu */
            padding: 0 20px; /* Add some horizontal padding */
        }
        .clock {
            align-items: right ;
            margin: 5px; /* Mengurangi margin di antara jam */
            font-size: 1em;
            color: #333; /* Warna teks default */
            font-weight: bold;
           white-space: nowrap; /* Prevent line break */
           text-align: right; /* Make sure time is right-aligned */
        }
        .date-day {
             font-size: 1em;
            color: #555;
            white-space: nowrap; /* Prevent line break */
            text-align: left; /* Make sure date/day is left-aligned */
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="clock-container">
        <div class="date-day" id="dateDay"></div>
        <div class="clock" id="utcClock">UTC: <span id="utcTime"></span></div>
        <div class="clock" id="witaClock">WITA: <span id="witaTime"></span></div>
    </div>
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
        
    </section>
    <script>
        function updateClocks() {
            const now = new Date();

             // Date and Day
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const dayName = days[now.getDay()];
            const date = now.toLocaleDateString();
            document.getElementById("dateDay").textContent = `${dayName}, ${date}`;

            // UTC time
            const utcHours = now.getUTCHours();
            const utcMinutes = now.getUTCMinutes();
            const utcSeconds = now.getUTCSeconds();

            document.getElementById("utcTime").textContent = `${formatTime(utcHours)}:${formatTime(utcMinutes)}:${formatTime(utcSeconds)}`;

             // WITA time (UTC+8)
            const witaHours = (utcHours + 8) % 24;
            document.getElementById("witaTime").textContent = `${formatTime(witaHours)}:${formatTime(utcMinutes)}:${formatTime(utcSeconds)}`;
        }

        function formatTime(unit) {
            return unit < 10 ? `0${unit}` : unit;
        }

        setInterval(updateClocks, 1000);
        updateClocks(); // Initialize immediately
        
        async function fetchWeatherData() {
            try {
                const response = await fetch('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm2=65.71');
                const data = await response.json();
                updateWeatherInfo(data);
            } catch (error) {
                console.error('Error fetching weather data:', error);
            }
        }

        function updateWeatherInfo(data) {
            const now = new Date();
            const localTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Makassar' }));
            const localHour = localTime.getHours();

             // Cari data cuaca untuk kecamatan dengan waktu terdekat
            let closestData = null;
            let timeDiff = Infinity;
                
            for (const locationData of data.data) {
            for (const forecast of locationData.cuaca) {
                for (const item of forecast) {
                    const forecastTime = new Date(item.local_datetime);
                    const forecastHour = forecastTime.getHours();
                    const diff = Math.abs(localHour - forecastHour);
    
                    if (diff < timeDiff) {
                        timeDiff = diff;
                        closestData = item;
                    }
                }
               }
           }

                if (closestData) {
                document.getElementById('suhu').textContent = closestData.t + '°C';
                document.getElementById('cuaca').textContent = closestData.weather_desc;
                document.getElementById('kecepatan-angin').textContent = closestData.ws + ' km/h';
                document.getElementById('arah-angin').textContent = closestData.wd;
                document.getElementById('kelembaban').textContent = closestData.hu + '%';
            } else {
                console.log('Data cuaca tidak ditemukan untuk jam saat ini.');
            }
           
        }

       fetchWeatherData();
    </script>
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
    <section class="kegiatan-bmkg">
    <h1>Kegiatan Stasiun Meterologi JUWATA</h1>
      <p>Berita Terbaru Stasiun Meterologi Juwata Tarakan</p>
      <main class="row">
        <div class="news-item">
            <img src="gambar1.jpg" alt="Ravalnas 2024">
            <div class="news-content">
                <p class="date">22 Januari 2025</p>
                <h3>Ravalnas 2024, Transformasi BMKG Menuju Indonesia Emas 2045</h3>
                <p>Badan Meteorologi, Klimatologi, dan Geofisika (BMKG) menyelenggarakan Rapat Evaluasi Nasional (Ravalnas) Tahun 2024 sebagai bentuk reformasi birokrasi dalam transformasi BMKG menuju Indonesia Emas 2045.</p>
                <a href="#">Baca selengkapnya →</a>
            </div>
        </div>
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
        <!-- Tambahkan lebih banyak news-item di sini -->
    </main>
    </section>
    <section class="cuacabandara">
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>