<?php
// URL citra satelit BMKG
$satelitUrl = "http://satelit.bmkg.go.id/IMAGE/ANIMASI/H08_EH_Region3_m18.gif";
?>
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
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        .container-info {
            margin-top: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .card img {
            border-radius: 8px;
            max-width: 80%; /* Membuat gambar lebih kecil */
            cursor: pointer;
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
    <div class="container my-5">
        <div class="row container-info">
            <!-- Bagian Citra Satelit -->
            <div class="col-md-12">
                <div class="card p-3">
                    <h5 class="text-center">
                        <i class="fa-solid fa-satellite-dish"></i> Citra Satelit
                    </h5>
                    <hr>
                    <div class="text-center">
                        <?php if (@get_headers($satelitUrl)): ?>
                            <img src="<?= $satelitUrl; ?>" class="img-fluid" alt="Citra Satelit" data-bs-toggle="modal" data-bs-target="#modalSatelit">
                        <?php else: ?>
                            <p class="text-danger">Citra satelit tidak dapat dimuat. Silakan coba lagi nanti.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Citra Satelit -->
    <div class="modal fade" id="modalSatelit" tabindex="-1" aria-labelledby="modalSatelitLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSatelitLabel">Citra Satelit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img s
