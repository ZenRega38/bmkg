<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>Pelayanan Publik - BMKG Tarakan</title>
    <link rel="stylesheet" href="css/pelayanan-publik.css">
    <link rel="stylesheet" href="css/outer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <?php include 'header.php'; ?>

    <video autoplay muted loop id="background-video">
        <source src="assets/video/bmkgvid.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div id="overlay"></div>
    <section class="judul-layanan">
        <div class="judul-container">
        <h1>Layanan Publik BMKG</h1>
        <div class="garis"></div>
        <h2>Kami berkomitmen untuk menghadirkan layanan yang handal dan responsif guna memastikan informasi dan layanan BMKG dapat dimanfaatkan secara efektif oleh masyarakat</h2>
    </section>

    <section>
        <div class="box">
            <div class="container-pelpub">
            <div class="card">
                <div class="card-icon">
                    <i class="fa fa-book"></i>
                </div>
                <div class="card-content">
                    <h2 class="card-title">W'Mag</h2>
                    <p class="card-description">Weather Magazine: publikasi meteorologi yang menyajikan prakiraan cuaca, analisis iklim, dan wawasan ilmiah dari Stasiun Meteorologi Juwata Tarakan.</p>
                    <a class="card-button" href="wmagz.php" style="text-decoration: none;">Klik disini</a>
                </div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fa fa-phone"></i>
                </div>
                <div class="card-content">
                    <h2 class="card-title">Caldssdl Center</h2>
                    <p class="card-description">Butuh bantuan atau informasi lebih lanjut? Tim kami siap membantu Anda dengan segala pertanyaan atau permasalahan yang Anda hadapi.</p>
                    <a class="card-button" href="https://wa.me/6281241416409" style="text-decoration: none;">Contact Center</a>
                </div>            
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fa fa-door-open"></i>
                </div>
                <div class="card-content">
                    <h2 class="card-title">PTSP</h2>
                    <p class="card-description">Apabila ada pengaduan silahkan ajukan disini</p>
                    <a class="card-button" href="https://ptsp.bmkg.go.id/">Klik disini</a>
                </div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fa fa-question"></i>
                </div>
                <div class="card-content">
                    <h2 class="card-title">Pengaduan</h2>
                    <p class="card-description">Apabila ada pengaduan silahkan ajukan disini</p>
                    <a class="card-button" href="aduan.php" style="text-decoration: none;">Form Pengaduan</a>
                </div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="card-content">
                    <h2 class="card-title">Permintaan Data</h2>
                    <p class="card-description">Apabila ada pengaduan silahkan ajukan disini</p>
                    <button class="card-button">Klik disini</button>   
                </div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fa fa-bolt"></i>
                </div>
                <div class="card-content">
                    <h2 class="card-title">Kritik dan Saran</h2>
                    <p class="card-description">Ajukan kritik dan Saran</p>
                    <a class="card-button" href="kritik-saran.php" style="text-decoration: none;">Form Kritik & Saran</a>
                </div>
            </div>

            </div>
        </div>
    </section>
    <script src="assets/script/nav.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>