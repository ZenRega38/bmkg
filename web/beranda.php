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
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>BMKG Tarakan - Stasiun Meteorologi JUWATA</title>
    
    <link rel="stylesheet" href="css/outer.css">
    <link rel="stylesheet" href="css/beranda.css">
    <link rel="stylesheet" href="css/berita.css">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

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
        body {
            overflow-x: hidden;
        }

        /* **IMPORTANT:** Override styles from outer.css if needed */
        .container {
            width: 100%; /* Ensure it fills the available space */
            max-width: 1200px; /* Limit its maximum width if desired */
            margin: 0 auto; /* Center the container */
            padding-left: 5%; /* Adjust padding as needed */
            padding-right: 5%; /* Adjust padding as needed */
            box-sizing: border-box; /* Ensure padding doesn't add to the width */
        }
        /* Reset margin on elements */
        .gempa,
        .kegiatan-bmkg {
            margin: 0; /* Reset any default margins */
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 10px;
            box-sizing: border-box;
           width:100%;
        }

        /* Add this to ensure beranda code isn't overflowing, especially for container-gempa */
        .container-gempa { width: 100% !important; box-sizing: border-box;}

        /* Ensure map takes full width */
        .images-section #map {
            height: 500px;
            width: 100%;
            border-radius : 15px;
        }
        /* The following were already here and look OK: */
        .clock-container {
            width: 92%;
            display: flex;
            justify-content: right;
            align-items: center;
            margin-bottom: 10px;
        }
        .clock {
            align-items: right ;
            margin: 5px;
            font-size: 1em;
            color: #333;
            font-weight: bold;
           white-space: nowrap;
           text-align: right;
        }
        .date-day {
             font-size: 1em;
            color: #555;
            white-space: nowrap;
            text-align: left;
        }
        .images-section iframe {
            border-radius : 15px;
        }
        .images-section {
            position: relative;
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        /* Set fixed height for both map and satellite containers */
        #map,
        #citraSatelitContainer .card {
            height: 500px;
        }

        #changeMapButton {
            margin-top: 20px; /* Space between map/satellite and button */
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: auto;
            align-self: flex-end; /* Right alignment */
            position: relative; /* Remove absolute positioning */
            z-index: 1;
        }

        #changeMapButton:hover {
            background-color: #0056b3;
        }

        #changeMapButton:hover {
            background-color: #0056b3;
        }
        /* Styles for citra satelit */
        .card {
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 0 auto;
            margin-top: -25px;
           max-width: 100%;
           height: 500px;
        }

        .card img {
            border-radius: 8px;
            max-width: 80%;
            max-height: 80%;
            cursor: pointer;
            display: block;
            margin: 0 auto;
            object-fit: contain;
        }

         .card-body {
            text-align: center;
            display: flex;
            justify-content: center;
             align-items: center;
             height: 100%;
        }
        ul {
            margin-bottom: 0rem;
        }
        .satellite-image {
            cursor: move;
            transition: transform 0.1s;
            max-width: none !important;
        }

        #satellite-container {
            width: 100%;
            height: 70vh;
            overflow: auto;
        }

        /* Styles for beranda */
         .kegiatan-bmkg .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .kegiatan-bmkg .news-item {
            flex-basis: calc(50% - 20px); /* Two items per row on larger screens */
            margin: 10px;
            min-width: 250px; /* Minimum width for smaller screens */
            box-sizing: border-box;

        }

        @media (max-width: 768px) {
            .kegiatan-bmkg .news-item {
                flex-basis: 100%; /* One item per row on smaller screens */
            }
            .clock {
                font-size: 0.8em;
            }
            .date-day {
                font-size: 0.8em;
            }
        }

        /* The following additions ensure the correct number of items show  and look good on large and small screens */
        .UMKM .swiper-container {
            width: 100%;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            overflow: hidden; /* Ensure slides don't overflow */
        }

        .UMKM .swiper-wrapper {
            display: flex;
        }

        .UMKM .swiper-slide {
            display: flex;
            flex-direction: column;
            align-items: center;
           
            height: auto;
            background: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(255, 253, 253, 0.726);
            transition: transform 0.3s ease, opacity 0.5s ease;
            box-sizing: border-box; /* Add this! */
            margin: 10px;
        }

        .UMKM .swiper-slide img {
            width: 100%;
            display: block;
            max-height: 300px;
            object-fit: cover;
        }

        .UMKM .swiper-slide h2 {
            margin: 10px 0;
            font-size: 1.2em;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .UMKM .swiper-slide p {
            font-size: 0.9em;
            color: #777;
            margin-bottom: 15px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .UMKM .swiper-slide.swiper-slide-active h2,
        .UMKM .swiper-slide.swiper-slide-active p {
            opacity: 1;
        }

        .UMKM .swiper-button-next,
        .UMKM .swiper-button-prev {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 24px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            cursor: pointer;
            z-index: 10;
        }

        .UMKM .swiper-button-next {
            right: 10px;
            background-image: url('assets/image/next_btn.png');
        }

        .UMKM .swiper-button-prev {
            left: 10px;
            background-image: url('assets/image/prev_btn.png');
        }

        /* Responsif */
        @media (max-width: 768px) {
            .UMKM h1 {
                font-size: 2em;
            }

            .UMKM p {
                font-size: 1em;
            }

           .UMKM .swiper-slide {
                flex: 0 0 60%; /* 1 item, taking up 80% of the width for readability */
            }

            .UMKM .swiper-button-next,
            .UMKM .swiper-button-prev {
                width: 16px;
                height: 20px;
            }
        }

    </style>
</head>
<body>
    <script src="assets/script/nav.js"></script>
    <?php include 'header.php'; ?>
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
        <div class="content">
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
                            $satelitUrl = "http://satelit.bmkg.go.id/IMAGE/ANIMASI/H08_EH_Region3_m18.gif";
                             if (@get_headers($satelitUrl)): ?>
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
        updateClocks();

        function kartuCuacaHTML(){
          return `
         <h1>Cuaca Terkini di Kecamatan Tarakan</h1>
            <p>Periksa cuaca terkini di setiap kecamatan.</p>
            <div class="row" id="cuacaRow">
            </div>
        `
        }

         document.getElementById('kartu-cuaca').innerHTML = kartuCuacaHTML();

          async function fetchWeatherData() {
            try {
                 const response = await fetch('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm2=65.71');
                 const data = await response.json();
                updateWeatherInfo(data);
                 updateWeatherDisplay(data)
              } catch (error) {
                console.error('Error fetching weather data:', error);
            }
        }

        function updateWeatherDisplay(data) {
           const now = new Date();
           const localTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Makassar' }));
           const localHour = localTime.getHours();

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
                 // Translate wind direction
                const windDirection = translateWindDirection(closestData.wd);
                document.getElementById('arah-angin').textContent = 'dari ' + windDirection;
               document.getElementById('kelembaban').textContent = closestData.hu + '%';
            } else {
              console.log('Data cuaca tidak ditemukan untuk jam saat ini.');
            }
        }

    function translateWindDirection(wd) {
        switch (wd) {
            case 'N': return 'Utara';
            case 'NNE': return 'Utara-Timur Laut';
            case 'NE': return 'Timur Laut';
            case 'ENE': return 'Timur-Timur Laut';
            case 'E': return 'Timur';
            case 'ESE': return 'Timur-Tenggara';
            case 'SE': return 'Tenggara';
            case 'SSE': return 'Selatan-Tenggara';
            case 'S': return 'Selatan';
            case 'SSW': return 'Selatan-Barat Daya';
            case 'SW': return 'Barat Daya';
            case 'WSW': return 'Barat-Barat Daya';
            case 'W': return 'Barat';
            case 'WNW': return 'Barat-Barat Laut';
            case 'NW': return 'Barat Laut';
            case 'NNW': return 'Utara-Barat Laut';
            default: return wd;  // Return original if not found
        }
    }

       function updateWeatherInfo(data) {
             const now = new Date();
             const localTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Makassar' }));
             const localHour = localTime.getHours();

            const cuacaRow = document.getElementById('cuacaRow');
             cuacaRow.innerHTML = '';

            data.data.forEach((locationData, index) => {
              const kecamatanName = locationData.lokasi.kecamatan;
                let closestData = null;
                let timeDiff = Infinity;

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

               if (closestData) {
                   const cuacaCol = document.createElement('div');
                     cuacaCol.classList.add('cuaca-col');
                   const imagePath = closestData.image;

                     cuacaCol.innerHTML = `
                        <a href="#"><img src="${imagePath}" alt="${kecamatanName}"></a>
                        <h3>${kecamatanName}</h3>
                        <p>${closestData.weather_desc}</p>
                        <p>Suhu: ${closestData.t}°C</p>
                        <p>Angin: ${closestData.ws} km/jam</p>
                        <p>Kelembapan: ${closestData.hu}%</p>
                    `;
                   cuacaRow.appendChild(cuacaCol);
               } else {
                 console.log(`Data cuaca tidak ditemukan untuk ${kecamatanName}.`);
                }
           });
        }
         // Call fetchWeatherData only after the page is loaded, and more specifically after the HTML elements that will be updated exist
        document.addEventListener('DOMContentLoaded', function() {
           fetchWeatherData();
         });
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
    <section class="gempa">
       <?php include 'gempa.php'; ?>
    </section>
    <section class="kegiatan-bmkg">
        <?php include 'berita.php'; ?>
    </section>
        <section class="cuacabandara">
    </section>
    <?php include 'footer.php'; ?>
      <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
       <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
         var map = L.map('map').setView([3.353339, 117.582684], 13);

         L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
           maxZoom: 19,
        }).addTo(map);

        var marker = L.marker([3.353339, 117.582684]).addTo(map);
         const apiKey = 'f1749350b540a2ca3c0b6a869d96894e';
        L.tileLayer(`https://tile.openweathermap.org/map/precipitation_new/{z}/{x}/{y}.png?appid=${apiKey}`, {
             zIndex : 50,
              maxZoom : 19
         }).addTo(map);

    </script>
    <script>
        document.getElementById('changeMapButton').addEventListener('click', function() {
            var mapContainer = document.getElementById('map');
            var citraSatelitContainer = document.getElementById('citraSatelitContainer');

             if (mapContainer.style.display !== 'none') {
                 mapContainer.style.display = 'none';
                  citraSatelitContainer.style.display = 'block';
               } else {
                    mapContainer.style.display = 'block';
                    citraSatelitContainer.style.display = 'none';
               }
           });
    </script>
    <script>
        // Initialize Panzoom when modal is shown
        const modalSatelit = document.getElementById('modalSatelit');
        let panzoomInstance = null;

        modalSatelit.addEventListener('show.bs.modal', function (event) {
            const image = document.querySelector('.satellite-image');
            const container = document.getElementById('satellite-container');

            // Initialize Panzoom
            panzoomInstance = Panzoom(image, {
                contain: 'outside',
                maxScale: 5,
                canvas: true
            });

            // Enable wheel zoom
            container.addEventListener('wheel', panzoomInstance.zoomWithWheel);

            // Button controls
            document.querySelector('.zoom-in').addEventListener('click', () => panzoomInstance.zoomIn());
            document.querySelector('.zoom-out').addEventListener('click', () => panzoomInstance.zoomOut());
        });

        // Cleanup when modal is hidden
        modalSatelit.addEventListener('hidden.bs.modal', function (event) {
            if (panzoomInstance) {
                panzoomInstance.dispose();
                panzoomInstance = null;
            }
        });
    </script>

</body>
</html>