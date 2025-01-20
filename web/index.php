<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>BMKG Tarakan - Stasiun Meteorologi JUWATA</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" href="css/outer.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script type="text/javascript">
        $(window).on('scroll', function(){
            if ($(window).scrollTop()) {
                $('header').addClass('black');
            } else {
                $('header').removeClass('black');
            }
        })
    </script>
</head>
<body>
    <?php include 'header.php'; ?>
    <section class="Cuacaterkini" id="Cuacaterkini">
        <div class="row">
            <!-- Bagian Konten -->
            <div class="content-section">
                <div class="title"><h1>Cuaca Saat ini</span></h1>
                </div>
                <div class="content">
                    <h3></h3>
                    <p>
                    </p>
                    <div class="button"><a href="Tentang Kami.html"class ="button-btn">Baca selengkapnya</a>
                    </div>
                </div>
            </div>
            <!-- Bagian Gambar -->
            <div class="images-section">
                <video src="images/" loop autoplay ="About TarakTrade">
            </div>
        </div>
    </section>
    <section class="UMKM">
        <h1>Weather Magazine</h1>
        <p>Baca Majalah Cuaca Terkini di W'Mag.</p>
        <div class="imgBox">
    </section>
    <section class="SKM">
        <h1>SKM</h1>
        <!-- <p>Apakah UMKM Kesukaan kamu sudah kami datangi?</p> -->
        <div class="row">
            <div class="berita-col">
            </div>
    
        </div>
    </section>
    <?php include 'footer.php'; ?>
</body>
</html>