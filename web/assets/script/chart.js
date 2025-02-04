document.addEventListener("DOMContentLoaded", function () {
    fetch("counter.php")
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
                                text: 'Bulan'
                            },
                            ticks: {
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
                                max: 200,           // Nilai maksimum skala (200)
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

