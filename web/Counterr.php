<?php
// Set timezone ke lokasi Anda
date_default_timezone_set('Asia/Jakarta');

// Nama file penyimpanan data
$filename = "assets/script/hasil.json";

// Cek apakah file sudah ada, jika tidak buat file default
if (!file_exists($filename)) {
    file_put_contents($filename, json_encode(["total" => 0, "daily" => [], "monthly" => []]));
}

// Ambil data dari file
$data = json_decode(file_get_contents($filename), true);

// Pastikan format data JSON valid
if (!is_array($data) || !isset($data["daily"])) {
    $data = ["total" => 0, "daily" => [], "monthly" => []];
}

// Tanggal hari ini
$today = date("Y-m-d");
$currentMonth = date("Y-m"); // Format bulan-tahun (YYYY-MM)

// Jika tidak ada data untuk hari ini, inisialisasi 0
if (!isset($data["daily"][$today])) {
    $data["daily"][$today] = 0;
}

// Tambahkan kunjungan hari ini
$data["daily"][$today]++;

// Tambahkan total kunjungan
$data["total"]++;

// Menghitung kunjungan bulanan dari data harian
$months = [];
for ($i = 5; $i >= 0; $i--) {
    $month = date("Y-m", strtotime("-$i month"));
    $months[] = $month;
}

$monthlyVisits = array_fill_keys($months, 0);
foreach ($data["daily"] as $date => $count) {
    $month = date("Y-m", strtotime($date));
    if (isset($monthlyVisits[$month])) {
        $monthlyVisits[$month] += $count;
    }
}

$data["monthly"] = $monthlyVisits;

// Urutkan bulan dari yang paling kecil (terakhir) ke yang lebih besar (awal)
krsort($data["monthly"]);

// Simpan data baru ke file
file_put_contents($filename, json_encode($data));

// Kirim data dalam format JSON
header("Content-Type: application/json");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Expires: 0");
header("Pragma: no-cache");

echo json_encode([
    "today" => $data["daily"][$today],  // Kunjungan hari ini
    "month" => $monthlyVisits[$currentMonth] ?? 0, // Kunjungan bulan ini
    "total" => $data["total"],           // Total kunjungan
    "monthly" => $data["monthly"],       // Kunjungan per bulan untuk 6 bulan terakhir
]);
exit;
