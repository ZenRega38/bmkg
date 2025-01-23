<?php
// URL citra satelit BMKG
$satelitUrl = "http://satelit.bmkg.go.id/IMAGE/ANIMASI/H08_EH_Region3_m18.gif";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citra Satelit, Curah Hujan & METAR Juwata</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
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
            margin-bottom: 20px;
        }

        .card img {
            border-radius: 8px;
            max-width: 80%;
            cursor: pointer;
            display: block; /* ensures margin auto works */
            margin: 10px auto; /* centers the image */
        }

        .card-body {
            text-align: center;
        }

         .container-metar {
            text-align: center;
        }

        .metar-title {
            font-size: 1.8em;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        #metartaf-8NNSRaLU {
           font-size:18px;
           font-weight:500;
           color:#000;
           width:300px;
           height:435px;
           display:block;
           margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row">
            <!-- Bagian Citra Satelit -->
            <div class="col-md-4">
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
            <!-- Bagian Kondisi Curah Hujan -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa-solid fa-cloud-rain"></i> Kondisi Curah Hujan
                        </h5>
                        <hr>
                        <div id="curah-hujan-container">
                            <img id="curah-hujan-image" src="" alt="Kondisi Curah Hujan">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Bagian METAR Juwata -->
            <div class="col-md-4">
                 <div class="card">
                    <div class="card-body">
                         <h5 class="metar-title">METAR Juwata</h5>
                         <div class="container-metar">
                           <a href="https://metar-taf.com/WAQQ" id="metartaf-8NNSRaLU">METAR Juwata</a>
                           <script async defer crossorigin="anonymous" src="https://metar-taf.com/embed-js/WAQQ?qnh=hPa&rh=rh&target=8NNSRaLU"></script>
                         </div>
                    </div>
                 </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const curahHujanUrl = 'https://dataweb.bmkg.go.id/iklim/pch/pch.bulan.1.cond1.png';
            const curahHujanImage = document.getElementById('curah-hujan-image');
            curahHujanImage.src = curahHujanUrl;

            // Optional: Handle image loading error
            curahHujanImage.onerror = function() {
                curahHujanImage.src = 'placeholder-image.png'; // Replace with a placeholder image path
                curahHujanImage.alt = "Gagal Memuat Gambar";
                console.error('Failed to load the curah hujan image from the API.');
            }
        });
    </script>
</body>
</html>