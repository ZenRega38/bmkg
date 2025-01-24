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

        .card {
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 20px auto;
            max-width: 500px;
        }

        .card img {
            border-radius: 8px;
            max-width: 80%;
            cursor: pointer;
            display: block;
            margin: 10px auto;
        }

        .card-body {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fa-solid fa-satellite-dish"></i> Citra Satelit
                </h5>
                <hr>
                <?php if (@get_headers($satelitUrl)): ?>
                    <img src="<?= $satelitUrl; ?>" class="img-fluid" alt="Citra Satelit" data-bs-toggle="modal" data-bs-target="#modalSatelit">
                <?php else: ?>
                    <p class="text-danger">Citra satelit tidak dapat dimuat. Silakan coba lagi nanti.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal untuk Citra Satelit -->
    <div class="modal fade" id="modalSatelit" tabindex="-1" aria-labelledby="modalSatelitLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSatelitLabel">Citra Satelit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="<?= $satelitUrl; ?>" class="img-fluid" alt="Citra Satelit">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
