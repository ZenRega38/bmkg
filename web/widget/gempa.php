<?php
/**
 * BMKG Tarakan - Earthquake Info Fragment
 * Fetches TEWS earthquake data from BMKG and outputs a clean dashboard block.
 */

// TEWS autogempa JSON endpoint
$jsonUrl = 'https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json';

// Fetch JSON data gracefully via cURL to avoid file_get_contents SSL issues
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $jsonUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$jsonData = curl_exec($ch);
curl_close($ch);

if ($jsonData) {
    $data = json_decode($jsonData, true);
    $gempa = isset($data['Infogempa']['gempa']) ? $data['Infogempa']['gempa'] : null;
} else {
    $gempa = null;
}

if ($gempa):
?>
<div class="container-gempa">
    <!-- Shakemap Image Panel -->
    <div class="shakemap">
        <img src="<?= 'https://data.bmkg.go.id/DataMKG/TEWS/' . $gempa['Shakemap']; ?>" alt="Shakemap" loading="lazy">
    </div>

    <!-- Seismological Information Panel -->
    <div class="info">
        <div>
            <h2>Gempa Bumi Terkini</h2>
            <p class="badge">Gempa Dirasakan</p>
            <p><strong>Pusat Gempa:</strong> <?= htmlspecialchars($gempa['Wilayah']); ?></p>
            <p><strong>Tanggal:</strong> <?= htmlspecialchars($gempa['Tanggal']); ?>, <?= htmlspecialchars($gempa['Jam']); ?> WITA/WIB</p>
            <p><strong>Saran BMKG:</strong> <?= htmlspecialchars($gempa['Potensi']); ?></p>
        </div>

        <div class="stats">
            <div class="stat-box">
                <i class="fa-solid fa-chart-line"></i>
                <strong><?= htmlspecialchars($gempa['Magnitude']); ?></strong>
                <span>Magnitudo</span>
            </div>
            <div class="stat-box">
                <i class="fa-solid fa-water"></i>
                <strong><?= htmlspecialchars($gempa['Kedalaman']); ?></strong>
                <span>Kedalaman</span>
            </div>
            <div class="stat-box">
                <i class="fa-solid fa-location-arrow"></i>
                <strong><?= htmlspecialchars($gempa['Coordinates']); ?></strong>
                <span>Koordinat</span>
            </div>
        </div>

        <a class="link-selengkapnya" href="https://www.bmkg.go.id/gempabumi" target="_blank" rel="noopener noreferrer">
            Lihat Selengkapnya di BMKG Pusat <i class="fa-solid fa-arrow-up-right-from-square"></i>
        </a>
    </div>
</div>
<?php else: ?>
<div class="container-gempa" style="justify-content: center; align-items: center; min-height: 200px;">
    <p class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Gagal memuat informasi gempa bumi terkini dari BMKG.</p>
</div>
<?php endif; ?>