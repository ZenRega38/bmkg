<?php
// Set zona waktu
date_default_timezone_set('Asia/Jakarta');

// Nama file penyimpanan data
$filename = "assets/script/hasil.json";
$lockfile = "$filename.lock";

// 🔄 Tunggu hingga lock tersedia (hindari race condition)
while (file_exists($lockfile)) {
    usleep(100); // Tunggu 100 mikrodetik agar tidak membebani server
}

// 🔒 Buat lock file
file_put_contents($lockfile, "");

// Ambil data terbaru dari file JSON
if (!file_exists($filename)) {
    file_put_contents($filename, json_encode(["total" => 0, "daily" => [], "monthly" => []]));
}

$data = json_decode(file_get_contents($filename), true);

// Format tanggal
$today = date("Y-m-d");
$currentMonth = date("Y-m");

// Pastikan data dalam format yang benar
if (!is_array($data) || !isset($data["daily"])) {
    $data = ["total" => 0, "daily" => [], "monthly" => []];
}

// Jika belum ada data untuk hari ini, inisialisasi 0
if (!isset($data["daily"][$today])) {
    $data["daily"][$today] = 0;
}

// ✅ Update jumlah pengunjung
$data["daily"][$today]++;
$data["total"]++;

// Hitung kunjungan bulanan
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
krsort($data["monthly"]);

// Simpan data baru ke file JSON
file_put_contents($filename, json_encode($data));

// 🔓 Hapus lock file setelah selesai
unlink($lockfile);

// Kirim data dalam format JSON ke frontend
header("Content-Type: application/json");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Expires: 0");
header("Pragma: no-cache");

echo json_encode([
    "today" => $data["daily"][$today],  
    "month" => $monthlyVisits[$currentMonth] ?? 0, 
    "total" => $data["total"],           
    "monthly" => $data["monthly"],       
]);
exit;
