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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>Wisata - BMKG Tarakan</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        /* Styles for the popup */
        .popup-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 80%; /* Adjust width as needed */
            max-width: 800px;
        }

        .popup-container.active {
            display: flex;
        }

        .blurred {
            filter: blur(5px);
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

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
    <div class="card-item" data-card-id="<?= $cardId ?>">
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
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</section>

<!-- Popup Container -->
<div class="popup-container" id="popupContainer">
    <div class="popup-content" id="popupContent">
        <!-- Content will be dynamically inserted here -->
    </div>
</div>

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

    // Mobile Card Click Functionality
    const cardItems = document.querySelectorAll('.card-item');
    const popupContainer = document.getElementById('popupContainer');
    const popupContent = document.getElementById('popupContent');

    cardItems.forEach(card => {
        card.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                const cardId = card.dataset.cardId;
                const cardData = currentCards.find((c, index) => generateUniqueId(c.title, index) === cardId);

                if (cardData) {
                    // Populate the popup with the full card content
                    popupContent.innerHTML = `
                        <div class="card-item">
                            <div class="card-image">
                                <div class="image-container">
                                    ${cardData.images.map(image => `<img src="${image}" alt="${cardData.title}">`).join('')}
                                </div>
                            </div>
                            <div class="card-content">
                                <h2 class="card-title">${cardData.title}</h2>
                                <div class="card-rating">
                                    <span class="rating-stars">
                                        ${'★'.repeat(cardData.rating)}${'☆'.repeat(6 - cardData.rating)}
                                    </span>
                                    <span class="rating-count">(${Number(cardData.rating_count).toLocaleString()})</span>
                                </div>
                                <p class="card-description">${cardData.type} · <span class="open-status">${cardData.status}</span></p>
                                <p class="card-description">${cardData.location}</p>
                                <div class="card-actions">
                                    <a href="${cardData.map_link}" class="navigation-button">
                                        <img src="assets/image/direction.png" alt="Directions">
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;

                    // Show the popup
                    popupContainer.classList.add('active');
                    document.body.classList.add('blurred');

                    // Close popup functionality
                    popupContainer.addEventListener('click', function(event) {
                        if (event.target === popupContainer) {
                            popupContainer.classList.remove('active');
                            document.body.classList.remove('blurred');
                        }
                    });
                }
            }
        });
    });

    // Utility function to generate unique ID (same as PHP)
    function generateUniqueId(title, index) {
        const baseString = title.toLowerCase().trim();
        const stringWithoutSpaces = baseString.replace(/\s+/g, '-');
        return stringWithoutSpaces + '-' + index;
    }
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>