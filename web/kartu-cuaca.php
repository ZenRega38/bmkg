<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuaca Terkini di Kelurahan Tarakan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .cuaca {
            width: 90%;
            margin: auto;
            text-align: center;
            padding-top: 20px;
            padding-bottom: 5px;
            position: relative;
        }

        .cuaca h1 {
            font-size: 2.5em;
            margin-bottom: 15px;
        }

        .cuaca p {
            font-size: 1.1em;
            margin-bottom: 40px;
        }

        .row {
            display: flex;
            align-items: center;
            gap: 20px;
            overflow: hidden;
            padding-bottom: 20px;
            position: relative;
            transition: transform 0.5s ease-in-out;
        }

        .cuaca-col {
            height: 150px;
            flex: auto;
            align-items: center;
            width: 10rem;
            border-radius: 10px;
            margin-bottom: 5%;
            text-align: left;
            background-color: #f4f7fc;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .cuaca-col img {
            width: 100%;
            border-radius: 10px;
        }

        .cuaca-col h3 {
            margin-top: 16px;
            margin-bottom: 10px;
            color: #1976d2;
            font-size: 1.2em;
        }

        .cuaca-col p {
            font-size: 1em;
            color: #616161;
            margin: 5px 0;
        }

        .arrow-button {
            background-color: #1976d2;
            color: white;
            border: none;
            padding: 15px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            transform: translateY(10%);
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .arrow-left {
            left: -40px;
        }

        .arrow-right {
            right: -40px;
        }

        @media (max-width: 768px) {
            .arrow-button {
                padding: 10px;
                font-size: 1.2em;
            }

            .arrow-left {
                left: -20px;
            }

            .arrow-right {
                right: -20px;
            }
        }
    </style>
</head>
<body>
    <section class="cuaca">
        <h1>Cuaca Terkini di Kelurahan Tarakan</h1>
        <p>Periksa cuaca terkini di setiap kelurahan.</p>

        <button class="arrow-button arrow-left" onclick="scrollLeft()">
            <i class="fa-solid fa-arrow-left"></i>
        </button>

        <div class="row" id="cuacaRow">
           <!-- Data cuaca akan dimasukkan di sini oleh JavaScript -->
        </div>

        <button class="arrow-button arrow-right" onclick="scrollRight()">
            <i class="fa-solid fa-arrow-right"></i>
        </button>
    </section>

    <script>
        const row = document.getElementById('cuacaRow');
        const cardWidth = document.querySelector('.cuaca-col')?.offsetWidth + 20; // Lebar kartu + gap
        let position = 0;
        let isScrolling = false;

        function scrollLeft() {
            if (isScrolling) return;
             isScrolling = true;

            position += cardWidth;
            row.style.transition = 'transform 0.5s ease-in-out';
            row.style.transform = `translateX(${position}px)`;

            setTimeout(() => {
                const cards = document.querySelectorAll('.cuaca-col');
                const lastCard = cards[cards.length - 1];
                 if (lastCard){
                    row.style.transition = 'none';
                    row.insertBefore(lastCard, cards[0]);
                    position -= cardWidth;
                    row.style.transform = `translateX(${position}px)`;
                   }
                isScrolling = false;
            }, 500);
        }

        function scrollRight() {
              if (isScrolling) return;
            isScrolling = true;

            position -= cardWidth;
            row.style.transition = 'transform 0.5s ease-in-out';
            row.style.transform = `translateX(${position}px)`;

            setTimeout(() => {
                const cards = document.querySelectorAll('.cuaca-col');
                const firstCard = cards[0];
                 if (firstCard){
                    row.style.transition = 'none';
                    row.appendChild(firstCard);
                    position += cardWidth;
                    row.style.transform = `translateX(${position}px)`;
                    }
                isScrolling = false;
            }, 500);
        }
    </script>
    <script>
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

                const imagePath = `images/kecamatan_${index + 1}.png`;

                cuacaCol.innerHTML = `
                    <a href="#"><img src="${imagePath}" alt="${kecamatanName}"></a>
                    <h3>${kecamatanName}</h3>
                    <p>Suhu: ${closestData.t}°C</p>
                    <p>Kecepatan Angin: ${closestData.ws} km/jam</p>
                    <p>Kelembapan: ${closestData.hu}%</p>
                `;
                cuacaRow.appendChild(cuacaCol);
            } else {
                console.log(`Data cuaca tidak ditemukan untuk ${kecamatanName}.`);
            }
        });
    }


        fetchWeatherData();
        </script>
</body>
</html>