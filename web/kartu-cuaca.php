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
            flex:auto;
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
            <div class="cuaca-col">
                <a href="#"><img src="images/kelurahan_a.png" alt="Kelurahan A"></a>
                <h3>Kelurahan A</h3>
                <p>Suhu: 30°C</p>
                <p>Kecepatan Angin: 15 km/jam</p>
                <p>Kelembapan: 80%</p>
            </div>
            <div class="cuaca-col">
                <a href="#"><img src="images/kelurahan_b.png" alt="Kelurahan B"></a>
                <h3>Kelurahan B</h3>
                <p>Suhu: 28°C</p>
                <p>Kecepatan Angin: 12 km/jam</p>
                <p>Kelembapan: 85%</p>
            </div>
            <div class="cuaca-col">
                <a href="#"><img src="images/kelurahan_c.png" alt="Kelurahan C"></a>
                <h3>Kelurahan C</h3>
                <p>Suhu: 32°C</p>
                <p>Kecepatan Angin: 10 km/jam</p>
                <p>Kelembapan: 75%</p>
            </div>
            <div class="cuaca-col">
                <a href="#"><img src="images/kelurahan_d.png" alt="Kelurahan D"></a>
                <h3>Kelurahan D</h3>
                <p>Suhu: 29°C</p>
                <p>Kecepatan Angin: 18 km/jam</p>
                <p>Kelembapan: 70%</p>
            </div>
        </div>

        <button class="arrow-button arrow-right" onclick="scrollRight()">
            <i class="fa-solid fa-arrow-right"></i>
        </button>
    </section>

    <script>
        const row = document.getElementById('cuacaRow');
        const cardWidth = document.querySelector('.cuaca-col').offsetWidth + 20; // Lebar kartu + gap
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
                row.style.transition = 'none';
                row.insertBefore(lastCard, cards[0]);
                position -= cardWidth;
                row.style.transform = `translateX(${position}px)`;
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
                row.style.transition = 'none';
                row.appendChild(firstCard);
                position += cardWidth;
                row.style.transform = `translateX(${position}px)`;
                isScrolling = false;
            }, 500);
        }
    </script>
</body>
</html>
