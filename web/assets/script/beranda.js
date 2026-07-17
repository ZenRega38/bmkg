// =========================================================
// Real-time Clock
// =========================================================
function updateClocks() {
    const now = new Date();

    // Date and Day
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const dayName = days[now.getDay()];
    const date = now.toLocaleDateString();
    
    const dateDayEl = document.getElementById("dateDay");
    if(dateDayEl) dateDayEl.textContent = `${dayName}, ${date}`;

    // UTC time
    const utcHours = now.getUTCHours();
    const utcMinutes = now.getUTCMinutes();
    const utcSeconds = now.getUTCSeconds();

    const utcTimeEl = document.getElementById("utcTime");
    if(utcTimeEl) utcTimeEl.textContent = `${formatTime(utcHours)}:${formatTime(utcMinutes)}:${formatTime(utcSeconds)}`;

    // WITA time (UTC+8)
    const witaHours = (utcHours + 8) % 24;
    const witaTimeEl = document.getElementById("witaTime");
    if(witaTimeEl) witaTimeEl.textContent = `${formatTime(witaHours)}:${formatTime(utcMinutes)}:${formatTime(utcSeconds)}`;
}

function formatTime(unit) {
    return unit < 10 ? `0${unit}` : unit;
}

setInterval(updateClocks, 1000);
updateClocks();


// =========================================================
// Weather Data Fetching (Current & Sub-districts)
// =========================================================
async function fetchWeatherData() {
    try {
        const response = await fetch('https://api.bmkg.go.id/publik/prakiraan-cuaca?adm2=65.71');
        const data = await response.json();
        updateWeatherInfo(data);
        updateWeatherDisplay(data);
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
        default: return wd;
    }
}

function updateWeatherInfo(data) {
    const now = new Date();
    const localTime = new Date(now.toLocaleString('en-US', { timeZone: 'Asia/Makassar' }));
    const localHour = localTime.getHours();

    const cuacaRow = document.getElementById('cuacaRow');
    if(!cuacaRow) return;
    
    cuacaRow.innerHTML = '';

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
                <a href="#"><img src="${imagePath}" alt="${kecamatanName}"></a>
                <h3>${kecamatanName}</h3>
                <p>${closestData.weather_desc}</p>
                <p>Suhu: ${closestData.t}°C</p>
                <p>Angin: ${closestData.ws} km/jam</p>
                <p>Kelembapan: ${closestData.hu}%</p>
            `;
            cuacaRow.appendChild(cuacaCol);
        }
    });
}

// Call fetchWeatherData only after the page is loaded
document.addEventListener('DOMContentLoaded', function() {
    fetchWeatherData();

    // Setup Swiper
    var swiperContainer = document.querySelector('.swiper-container');
    if (swiperContainer && typeof Swiper !== 'undefined') {
        new Swiper('.swiper-container', {
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
            loop: true,
        });
    }

    // Setup Leaflet Map
    var mapEl = document.getElementById('map');
    if (mapEl && typeof L !== 'undefined') {
        var map = L.map('map').setView([3.353339, 117.582684], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        L.marker([3.353339, 117.582684]).addTo(map);
        
        const apiKey = 'f1749350b540a2ca3c0b6a869d96894e';
        L.tileLayer(`https://tile.openweathermap.org/map/precipitation_new/{z}/{x}/{y}.png?appid=${apiKey}`, {
            zIndex : 50,
            maxZoom : 19
        }).addTo(map);
    }

    // Change Map View Button
    var changeMapBtn = document.getElementById('changeMapButton');
    if (changeMapBtn) {
        changeMapBtn.addEventListener('click', function() {
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
    }

    // Initialize Panzoom for Satelit Modal
    const modalSatelit = document.getElementById('modalSatelit');
    let panzoomInstance = null;

    if(modalSatelit) {
        modalSatelit.addEventListener('show.bs.modal', function () {
            const image = document.querySelector('.satellite-image');
            const container = document.getElementById('satellite-container');

            if(image && typeof Panzoom !== 'undefined') {
                panzoomInstance = Panzoom(image, {
                    contain: 'outside',
                    maxScale: 5,
                    canvas: true
                });

                container.addEventListener('wheel', panzoomInstance.zoomWithWheel);

                document.querySelector('.zoom-in')?.addEventListener('click', () => panzoomInstance.zoomIn());
                document.querySelector('.zoom-out')?.addEventListener('click', () => panzoomInstance.zoomOut());
            }
        });

        modalSatelit.addEventListener('hidden.bs.modal', function () {
            if (panzoomInstance) {
                panzoomInstance.dispose();
                panzoomInstance = null;
            }
        });
    }
});
