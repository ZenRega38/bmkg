<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>Pelayanan Publik - BMKG Tarakan</title>
    <link rel="stylesheet" href="css/pelayanan-publik.css">
    <link rel="stylesheet" href="css/outer.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <?php include 'header.php'; ?>

    <video autoplay muted loop id="background-video">
        <source src="assets/video/bg.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

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
                    <p class="card-description">Weather Magazine: Majalah cuaca dan iklim terbaru untuk Anda!</p>
                    <a class="card-button" href="wmagz.php" style="text-decoration: none;">Klik disini</a>
                </div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fa fa-phone"></i>
                </div>
                <div class="card-content">
                    <h2 class="card-title">Call Center</h2>
                    <p class="card-description">Butuh bantuan? Kami siap menjawab pertanyaan Anda!</p>
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
                    <p class="card-description"> Laporkan masalah Anda, kami siap membantu!</p>
                    <a class="card-button" href="aduan.php" style="text-decoration: none;">Form Pengaduan</a>
                </div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="card-content">
                    <h2 class="card-title">Permintaan Data</h2>
                    <p class="card-description"> Ajukan permintaan informasi yang Anda butuhkan!</p>
                    <a class="card-button" href="PermohonanData.php" style="text-decoration: none;">Klik disini</a>   
                </div>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fa fa-bolt"></i>
                </div>
                <div class="card-content">
                    <h2 class="card-title">Kritik dan Saran</h2>
                    <p class="card-description">Bantu kami berkembang dengan masukan Anda!</p>
                    <a class="card-button" href="kritik-saran.php" style="text-decoration: none;">Form Kritik & Saran</a>
                </div>
            </div>

            </div>
        </div>
    </section>

    <section>
        <div class="counter">
            <h1>Counter Visitor</h1>
            <div class="content">
                <div class="content-icon">
                        <j class="fa fa-laptop"></j>
                    </div>
                <div class="chart-container">
                    <h2>Grafik Kunjungan 6 Bulan Terakhir</h2>
                    <canvas id="visitsChart" width="400" height="200"></canvas>
                </div>
                <div class="metrics">
                    <div class="metric">
                        <h3>Kunjungan Hari Ini</h3>
                        <p id="todayVisits">Loading...</p>
                    </div>
                    <div class="metric">
                        <h3>Kunjungan Bulan Ini</h3>
                        <p id="monthVisits">Loading...</p>
                    </div>
                    <div class="metric">
                        <h3>Total Kunjungan</h3>
                        <p id="totalVisits">Loading...</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                fetch("Counterr.php")
                    .then(response => response.json())
                    .then(data => {
                        // Menampilkan data kunjungan
                        document.getElementById("todayVisits").textContent = data.today;
                        document.getElementById("monthVisits").textContent = data.month;
                        document.getElementById("totalVisits").textContent = data.total;

                        // Menyiapkan data untuk grafik
                        const months = Object.keys(data.monthly);  // Kunci bulan (YYYY-MM)
                        const visitsData = months.map(month => data.monthly[month] || 0);  // Kunjungan per bulan

                        // Mengurutkan bulan dari yang paling lama ke yang paling baru
                        months.reverse();  // Mengurutkan bulan dari yang paling lama ke yang paling baru
                        visitsData.reverse(); // Mengurutkan data sesuai bulan

                        const chartData = {
                            labels: months, // Menampilkan bulan yang sudah terbalik
                            datasets: [{
                                label: 'Jumlah Kunjungan',
                                data: visitsData,  // Data kunjungan sesuai urutan bulan
                                fill: true,  // Mengisi area di bawah garis
                                borderColor: 'rgb(75, 192, 192)', // Warna garis
                                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna area di bawah garis (transparan)
                                tension: 0.1 
                            }]
                        };

                        const config = {
                            type: 'line',
                            data: chartData,
                            options: {
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Bulan-Tahun'
                                        },
                                        ticks: {
                                            // Mengatur urutan bulan
                                            reverse: false,  // Membuat bulan terbaru berada di sebelah kanan
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Jumlah Kunjungan'
                                        },
                                        min: 0,
                                        ticks: {
                                            beginAtZero: true,  // Memulai sumbu Y dari 0
                                            stepSize: 50,       // Langkah antara angka (0, 50, 100, 150, 200)
                                            max: 1000,           // Nilai maksimum skala (200)
                                            min: 0,             // Nilai minimum skala (0)
                                            callback: function(value) {
                                                if (value % 50 === 0) {
                                                    return value;
                                                }
                                                return '';  // Tidak menampilkan angka lain selain kelipatan 50
                                            }
                                        }
                                    }
                                }
                            }
                        };

                        new Chart(document.getElementById('visitsChart'), config);
                    })
                    .catch(error => console.error("Error fetching visitor data:", error));
            });
        </script>
    </section>

    <script src="assets/script/nav.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>