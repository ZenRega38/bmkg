<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Clocks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .clock {
            margin: 20px;
            font-size: 2em;
        }
    </style>
</head>
<body>
    <h1>Real-Time Clocks</h1>
    <div class="clock" id="utcClock">UTC: </div>
    <div class="clock" id="utcPlus8Clock">UTC+8: </div>

    <script>
        function updateClocks() {
            const now = new Date();

            // UTC time
            const utcHours = now.getUTCHours();
            const utcMinutes = now.getUTCMinutes();
            const utcSeconds = now.getUTCSeconds();

            document.getElementById("utcClock").textContent = `UTC: ${formatTime(utcHours)}:${formatTime(utcMinutes)}:${formatTime(utcSeconds)}`;

            // UTC+8 time
            const utcPlus8Hours = (utcHours + 8) % 24;
            document.getElementById("utcPlus8Clock").textContent = `UTC+8: ${formatTime(utcPlus8Hours)}:${formatTime(utcMinutes)}:${formatTime(utcSeconds)}`;
        }

        function formatTime(unit) {
            return unit < 10 ? `0${unit}` : unit;
        }

        setInterval(updateClocks, 1000);
        updateClocks(); // Initialize immediately
    </script>
</body>
</html>
