<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METAR Juwata</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Arialwifi', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container-metar {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            /* text-align: ; */
        }

        .metar-title {
            font-size: 1.8em;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .metar-content {
            font-size: 1em;
            font-weight: 500;
            color: #000;
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
            height: auto;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        }

        .footer a {
            color: #0057a3;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container-metar">
    <a href="https://metar-taf.com/WAQQ" id="metartaf-8NNSRaLU" style="font-size:18px; font-weight:500; color:#000; width:300px; height:435px; display:block">METAR Juwata</a>
    <script async defer crossorigin="anonymous" src="https://metar-taf.com/embed-js/WAQQ?qnh=hPa&rh=rh&target=8NNSRaLU"></script>
    </div>
</body>
</html>
