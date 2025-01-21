<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citra Satelit</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .gambar img {
            max-height: auto;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h5 class="text-center">
                    <i class="fa-solid fa-satellite-dish"></i> Citra Satelit
                </h5>
                <hr>
                <div class="gambar text-center">
                    <?php
                    // URL sumber citra satelit
                    $satelit_url = "http://satelit.bmkg.go.id/IMAGE/ANIMASI/H08_EH_Region3_m18.gif";

                    // Cek apakah URL valid atau bisa diakses
                    if (@get_headers($satelit_url)) {
                        echo '<img src="' . $satelit_url . '" class="card-img img-fluid" alt="Citra Satelit">';
                    } else {
                        echo '<p class="text-danger">Citra satelit tidak dapat dimuat. Silakan coba lagi nanti.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
