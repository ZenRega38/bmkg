/* ==========================================================================
   BMKG TARAKAN PORTAL - INTERACTIVE SCRIPTS & CORE LOGIC
   ========================================================================== */

document.addEventListener("DOMContentLoaded", () => {
    // 1. Initialize Navigation & Header Scroll effects
    initNavigation();
    
    // 2. Initialize Clocks (UTC & WITA)
    initClocks();
    
    // 3. Initialize Swiper coverflow for W'Magz
    initMagazineSwiper();
    
    // 4. Initialize Map (Leaflet) with secure radar tile layer
    initWeatherMap();
    
    // 5. Initialize Sub-District weather cards & Current weather fetching
    initWeatherFetch();
    
    // 6. Initialize Satellite Image Modal Zoom (Panzoom)
    initSatelliteZoom();
});

/* ==========================================================================
   1. Navigation & Hamburger Menu
   ========================================================================== */
function initNavigation() {
    const header = document.getElementById('nav-menu');
    const hamburger = document.getElementById('hamburger');
    const nav = document.querySelector('.menu');

    // Sticky transparent navigation scroll behavior
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('nav-scrolled');
        } else {
            header.classList.remove('nav-scrolled');
        }
    });

    // Mobile Hamburger Toggle
    if (hamburger && nav) {
        hamburger.addEventListener('click', () => {
            const expanded = hamburger.getAttribute('aria-expanded') === 'true';
            hamburger.setAttribute('aria-expanded', !expanded);
            nav.classList.toggle('active');
        });
    }

    // Dropdown handling for mobile
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const dropdownId = btn.dataset.dropdown;
            const dropdown = document.getElementById(dropdownId);
            
            if (dropdown) {
                const expanded = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', !expanded);
                dropdown.classList.toggle('show');
            }
            e.stopPropagation();
        });
    });
}

/* ==========================================================================
   2. Real-Time clocks (UTC & WITA)
   ========================================================================== */
function initClocks() {
    const dateDayEl = document.getElementById("dateDay");
    const utcTimeEl = document.getElementById("utcTime");
    const witaTimeEl = document.getElementById("witaTime");
    
    if (!dateDayEl || !utcTimeEl || !witaTimeEl) return;

    const formatTime = (unit) => (unit < 10 ? `0${unit}` : unit);

    const updateClocks = () => {
        const now = new Date();

        // Date and Day
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const dayName = days[now.getDay()];
        const dateString = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        dateDayEl.textContent = `${dayName}, ${dateString}`;

        // UTC Time
        const utcHours = now.getUTCHours();
        const utcMinutes = now.getUTCMinutes();
        const utcSeconds = now.getUTCSeconds();
        utcTimeEl.textContent = `${formatTime(utcHours)}:${formatTime(utcMinutes)}:${formatTime(utcSeconds)}`;

        // WITA Time (UTC + 8)
        const witaHours = (utcHours + 8) % 24;
        witaTimeEl.textContent = `${formatTime(witaHours)}:${formatTime(utcMinutes)}:${formatTime(utcSeconds)}`;
    };

    setInterval(updateClocks, 1000);
    updateClocks();
}

/* ==========================================================================
   3. Leaflet Map with Secure Weather Radar Tile Layer
   ========================================================================== */
function initWeatherMap() {
    const mapEl = document.getElementById('map');
    if (!mapEl) return;

    // Initialize Map at Juata Tarakan Coordinates
    const map = L.map('map', { scrollWheelZoom: false }).setView([3.353339, 117.582684], 12);

    // Standard OpenStreetMap base layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Marker pointing to Tarakan Station
    L.marker([3.353339, 117.582684]).addTo(map)
        .bindPopup('<b>Stasiun Meteorologi Juwata Tarakan</b><br>Kaltara.')
        .openPopup();

    // Secure OpenWeatherMap tile layers via local server proxy
    L.tileLayer('weather-proxy.php?z={z}&x={x}&y={y}', {
        zIndex: 50,
        maxZoom: 18,
        opacity: 0.7
    }).addTo(map);

    // Map/Satellite View toggling logic
    const changeMapBtn = document.getElementById('changeMapButton');
    const mapContainer = document.getElementById('map');
    const citraSatelitContainer = document.getElementById('citraSatelitContainer');

    if (changeMapBtn && mapContainer && citraSatelitContainer) {
        changeMapBtn.addEventListener('click', () => {
            if (mapContainer.style.display !== 'none') {
                mapContainer.style.display = 'none';
                citraSatelitContainer.style.display = 'block';
                changeMapBtn.textContent = 'Lihat Peta Cuaca';
            } else {
                mapContainer.style.display = 'block';
                citraSatelitContainer.style.display = 'none';
                changeMapBtn.textContent = 'Lihat Citra Satelit';
                // Trigger Leaflet map invalidate size to adjust tiles correctly
                setTimeout(() => { map.invalidateSize(); }, 50);
            }
        });
    }
}

/* ==========================================================================
   4. Weather API Fetching & Rendering (Kecamatan Tarakan)
   ========================================================================== */
function initWeatherFetch() {
    const kartuCuacaEl = document.getElementById('kartu-cuaca');
    if (!kartuCuacaEl) return;

    // Set up the container structure
    kartuCuacaEl.innerHTML = `
        <h1>Cuaca Terkini di Kecamatan Tarakan</h1>
        <p>Periksa kondisi cuaca terkini secara realtime di setiap kecamatan.</p>
        <div class="row" id="cuacaRow">
            <p class="loading-text">Sedang memuat data cuaca...</p>
        </div>
    `;

    const fetchWeatherData = async () => {
        const BMKG_URL = 'https://api.bmkg.go.id/publik/prakiraan-cuaca?adm2=65.71';
        const PROXY_URL = 'proxy-cuaca.php?adm2=65.71';

        let data = null;

        // Coba fetch langsung dari browser ke BMKG (browser tidak diblok Cloudflare)
        try {
            const response = await fetch(BMKG_URL, {
                headers: {
                    'Accept': 'application/json'
                }
            });
            const text = await response.text();
            const parsed = JSON.parse(text.replace(/^\uFEFF/, ''));
            if (parsed && parsed.data && parsed.data.length > 0) {
                data = parsed;
                console.log('[BMKG] ✅ Data realtime dari API BMKG langsung, total lokasi:', parsed.data.length);
            }
        } catch (e) {
            console.warn('[BMKG] ⚠️ Fetch langsung gagal (mungkin CORS), mencoba proxy...', e.message);
        }

        // Fallback ke proxy PHP jika BMKG langsung gagal
        if (!data) {
            try {
                const response = await fetch(PROXY_URL);
                const text = await response.text();
                data = JSON.parse(text.replace(/^\uFEFF/, ''));
                console.log('[BMKG] 🔄 Data dari proxy-cuaca.php');
            } catch (error) {
                console.error('[BMKG] ❌ Semua sumber gagal:', error);
                const row = document.getElementById('cuacaRow');
                if (row) {
                    row.innerHTML = '<p class="text-danger">Gagal memuat data cuaca. Silakan coba lagi nanti.</p>';
                }
                return;
            }
        }

        updateWeatherInfo(data);
        updateWeatherDisplay(data);
    };

    // Update the main dashboard weather widget (content-section)
    const updateWeatherDisplay = (data) => {
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
            const suhuEl = document.getElementById('suhu');
            const cuacaEl = document.getElementById('cuaca');
            const windSpeedEl = document.getElementById('kecepatan-angin');
            const windDirEl = document.getElementById('arah-angin');
            const humidityEl = document.getElementById('kelembaban');

            if (suhuEl) suhuEl.textContent = closestData.t + '°C';
            if (cuacaEl) cuacaEl.textContent = closestData.weather_desc;
            if (windSpeedEl) windSpeedEl.textContent = closestData.ws + ' km/jam';
            if (windDirEl) windDirEl.textContent = closestData.wd;
            if (humidityEl) humidityEl.textContent = closestData.hu + '%';
        }
    };

    // Generate individual widgets per Kecamatan
    const updateWeatherInfo = (data) => {
        const cuacaRow = document.getElementById('cuacaRow');
        if (!cuacaRow) return;
        
        cuacaRow.innerHTML = '';
        const now = new Date();
        const localTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Makassar' }));
        const localHour = localTime.getHours();

        data.data.forEach((locationData) => {
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
                    <img src="${imagePath}" alt="${kecamatanName}" loading="lazy">
                    <h3>${kecamatanName}</h3>
                    <p><strong>${closestData.weather_desc}</strong></p>
                    <p>Suhu: ${closestData.t}°C</p>
                    <p>Angin: ${closestData.ws} km/jam (${closestData.wd})</p>
                    <p>Kelembapan: ${closestData.hu}%</p>
                `;
                cuacaRow.appendChild(cuacaCol);
            }
        });
    };

    // Run weather service
    fetchWeatherData();
}

/* ==========================================================================
   5. Swiper Coverflow Slider (Weather Magazine)
   ========================================================================== */
function initMagazineSwiper() {
    if (typeof Swiper === 'undefined') return;

    new Swiper('.swiper-container', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        coverflowEffect: {
            rotate: 15,
            stretch: 0,
            depth: 180,
            modifier: 1,
            slideShadows: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        loop: true,
        on: {
            slideChangeTransitionStart: function () {
                const slides = this.slides;
                slides.forEach(slide => {
                    const h2 = slide.querySelector('h2');
                    const p = slide.querySelector('p');
                    if (slide.classList.contains('swiper-slide-active')) {
                        if (h2) h2.style.opacity = '1';
                        if (p) p.style.opacity = '1';
                    } else {
                        if (h2) h2.style.opacity = '0';
                        if (p) p.style.opacity = '0';
                    }
                });
            },
        },
    });
}

/* ==========================================================================
   6. Satellite Modal Panzoom handler
   ========================================================================== */
function initSatelliteZoom() {
    const modalSatelit = document.getElementById('modalSatelit');
    if (!modalSatelit || typeof Panzoom === 'undefined') return;

    let panzoomInstance = null;

    modalSatelit.addEventListener('show.bs.modal', () => {
        const image = document.querySelector('.satellite-image');
        const container = document.getElementById('satellite-container');
        
        if (image && container) {
            // Initialize Panzoom on image
            panzoomInstance = Panzoom(image, {
                contain: 'outside',
                maxScale: 5,
                canvas: true
            });
            
            // Enable mousewheel zoom
            container.addEventListener('wheel', panzoomInstance.zoomWithWheel);
            
            // Set button zoom controls
            const zoomInBtn = document.querySelector('.zoom-in');
            const zoomOutBtn = document.querySelector('.zoom-out');
            
            if (zoomInBtn) zoomInBtn.addEventListener('click', () => panzoomInstance.zoomIn());
            if (zoomOutBtn) zoomOutBtn.addEventListener('click', () => panzoomInstance.zoomOut());
        }
    });

    // Cleanup when modal closes
    modalSatelit.addEventListener('hidden.bs.modal', () => {
        if (panzoomInstance) {
            panzoomInstance.dispose();
            panzoomInstance = null;
        }
    });
}
