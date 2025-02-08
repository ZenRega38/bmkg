<?php
// Read data from JSON file
$jsonData = file_get_contents('assets/json/data-wisata.json');
$allData = json_decode($jsonData, true);

// Check for errors during JSON decoding
if ($allData === null && json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON: ' . json_last_error_msg()); // Handle the error appropriately
}

$selectedDataset = $_GET['dataset'] ?? 'tarakan';

// Check if the selected dataset exists in the JSON data
if (!isset($allData[$selectedDataset])) {
    $selectedDataset = 'tarakan'; // Default to tarakan if the selected one is not found
}

$currentCards = $allData[$selectedDataset];

// Function to generate a unique ID based on title and index
function generateUniqueId($title, $index) {
    $baseString = strtolower(trim($title));
    $stringWithoutSpaces = preg_replace('/\s+/', '-', $baseString);
    return $stringWithoutSpaces . '-' . $index;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>Wisata - BMKG Tarakan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/wisata.css">
    <link rel="stylesheet" href="css/outer.css">
    <style>
        .dataset-selector {
            margin-top: 30px;
            text-align: center;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dataset-selector select {
            background-color: #4682b4;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
             margin-bottom: 10px;
        }
        .dataset-selector select:hover {
             background-color: #5f9ea0;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<script src="assets/script/nav.js"></script>

<div class="dataset-selector">
    <form id="datasetForm">
        <select name="dataset" id="datasetSelect" onchange="this.form.submit()">
            <option value="tarakan" <?= $selectedDataset === 'tarakan' ? 'selected' : '' ?>>Kota Tarakan</option>
            <option value="bulungan" <?= $selectedDataset === 'bulungan' ? 'selected' : '' ?>>Kab. Bulungan</option>
            <option value="nunukan" <?= $selectedDataset === 'nunukan' ? 'selected' : '' ?>>Kab. Nunukan</option>
            <option value="tana_tidung" <?= $selectedDataset === 'tana_tidung' ? 'selected' : '' ?>>Kab. Tana Tidung</option>
            <option value="malinau" <?= $selectedDataset === 'malinau' ? 'selected' : '' ?>>Kab. Malinau</option>
        </select>
    </form>
</div>

<section class="card-grid">
    <?php foreach ($currentCards as $index => $card):
         $cardId = generateUniqueId($card['title'], $index);
     ?>
    <div class="card-item">
        <div class="card-image">
            <div class="image-container">
                <?php foreach ($card['images'] as $image): ?>
                <img src="<?= $image ?>" alt="<?= $card['title'] ?>">
                <?php endforeach; ?>
            </div>
        </div>
        <div id="map-container<?= $index + 1 ?>" class="map-container"></div>
        <div class="card-content">
            <h2 class="card-title"><?= $card['title'] ?></h2>
            <div class="card-rating">
                <span class="rating-stars">
                    <?=
                        $fullStars = ($card['rating']);
                        $emptyStars = 6 - $fullStars;
                        echo str_repeat('★', $fullStars);
                        echo str_repeat('☆', $emptyStars);

                    ?>
                </span>
                <span class="rating-count">(<?= number_format($card['rating_count']) ?>)</span>
            </div>
            <p class="card-description"><?= $card['type'] ?> · <span class="open-status"><?= $card['status'] ?></span></p>
            <p class="card-description"><?= $card['location'] ?></p>
            <div class="card-weather">
                <span class="weather-temp"></span>
                <span class="weather-desc"></span>
                <p class="weather-advice"></p>
            </div>
            <div class="card-actions">
                <a href="<?= $card['map_link'] ?>" class="navigation-button">
                    <img src="assets/image/direction.png" alt="Directions">
                </a>
                <a href="detail-wisata.php?dataset=<?= $selectedDataset ?>&id=<?= $cardId ?>" class="view-details-button">View Details</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</section>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Map initialization
    const currentCards = <?= json_encode($currentCards) ?>;
    const mapContainers = document.querySelectorAll('.map-container');

    mapContainers.forEach((container, index) => {
        const uniqueMapId = `map${index + 1}`;
        container.innerHTML = `<div id="${uniqueMapId}"></div>`;
        const map = L.map(uniqueMapId, {
            zoomControl: false,
            attributionControl: false
        }).setView([currentCards[index].lat, currentCards[index].lng], currentCards[index].zoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        const apiKey = 'f1749350b540a2ca3c0b6a869d96894e';
        L.tileLayer(`https://tile.openweathermap.org/map/precipitation_new/{z}/{x}/{y}.png?appid=${apiKey}`, {
            zIndex: 50,
            maxZoom: 19
        }).addTo(map);
    });

    // Weather data fetching
    document.querySelectorAll('.card-item').forEach((card, index) => {
        const weatherContainer = card.querySelector('.card-weather');
        const tempSpan = weatherContainer.querySelector('.weather-temp');
        const descSpan = weatherContainer.querySelector('.weather-desc');
        const adviceP = weatherContainer.querySelector('.weather-advice');

        fetch(`https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=${currentCards[index].adm4}`)
            .then(response => response.json())
            .then(data => {
              if (data && data.data && data.data.length > 0 && data.data[0].cuaca) {
                const currentWeather = data.data[0].cuaca[0][0];
                tempSpan.innerHTML = `<img src="${currentWeather.image}" alt="Weather Icon"><span>${currentWeather.t}°C</span>`;
                descSpan.textContent = currentWeather.weather_desc;

                const nextHours = data.data[0].cuaca[0].slice(1, 7);
                const rainyHours = nextHours.filter(f => [61, 95, 97].includes(f.weather));
                let advice = `Saat ini cuaca ${currentWeather.weather_desc.toLowerCase()}. `;

                if([60, 61, 95, 97].includes(currentWeather.weather)) {
                    const clearTime = nextHours.find(f => ![60, 61, 95, 97].includes(f.weather));
                    advice += clearTime ?
                        `Sebaiknya datang setelah jam ${new Date(clearTime.local_datetime).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}!` :
                        "Hujan mungkin berlanjut, pertimbangkan untuk menunda kunjungan!";
                } else if(rainyHours.length) {
                    const rainTime = new Date(rainyHours[0].local_datetime);
                    advice += `Membawa payung disarankan, kemungkinan hujan sekitar jam ${rainTime.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}!`;
                } else {
                    advice += "Nikmati aktivitas Anda!";
                }
                adviceP.textContent = advice;
              }
              else {
                  tempSpan.textContent = 'N/A';
                  descSpan.textContent = 'Tidak ada data cuaca';
                  adviceP.textContent = '';
                }
            })
            .catch(error => {
                console.error('Weather fetch error:', error);
                tempSpan.textContent = 'N/A';
                descSpan.textContent = 'Gagal memuat data';
                adviceP.textContent = '';
            });
    });

    // Image carousel
    document.querySelectorAll('.card-image').forEach(cardImage => {
        let currentIndex = 0;
        const container = cardImage.querySelector('.image-container');
        const images = container.querySelectorAll('img');
        let interval;

        cardImage.addEventListener('mouseenter', () => {
            interval = setInterval(() => {
                currentIndex = (currentIndex + 1) % images.length;
                container.style.transform = `translateX(-${currentIndex * 100}%)`;
            }, 1500);
        });

        cardImage.addEventListener('mouseleave', () => {
            clearInterval(interval);
            currentIndex = 0;
            container.style.transform = 'translateX(0)';
        });
    });
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>