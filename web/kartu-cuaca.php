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
            align-items: flex-start;
            gap: 20px;
            overflow: hidden;
            padding-bottom: 20px;
            position: relative;
            transition: transform 0.5s ease-in-out;
        }

         .cuaca-col {
            flex: auto;
             width: 10rem;
            border-radius: 10px;
             margin-bottom: 5%;
           text-align: left;
            background-color: #f4f7fc;
           box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
             display: flex;
             flex-direction: column;
             align-items: center; /* Center items horizontally */
        }

        .cuaca-col img {
            width: 80%; /* Reduced image width */
            border-radius: 10px;
              margin-bottom: 10px;
             align-self: center; /* center image in their own container */
        }



        .cuaca-col h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #1976d2;
            font-size: 1.2em;
        }

        .cuaca-col p {
            font-size: 1em;
            color: #616161;
            margin: 5px 0;
        }

    </style>
</head>
<body>
    <section class="cuaca" id="kartu-cuaca">
       </section>
</body>
</html>