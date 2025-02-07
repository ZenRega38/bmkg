<?php
// Read data from JSON file
$jsonData = file_get_contents('assets/json/data-berita.json');

// Decode the JSON data into a PHP array
$newsItems = json_decode($jsonData, true);

// Check for errors during JSON decoding
if ($newsItems === null && json_last_error() !== JSON_ERROR_NONE) {
    die('Error decoding JSON: ' . json_last_error_msg()); // Handle the error appropriately
}
?>
<div class="berita">
    <h1>Berita BMKG Tarakan</h1>
    <p>Berita Terkini Seputar BMKG Tarakan.</p>
    <div class="row-berita">
        <?php foreach ($newsItems as $item): ?>
            <div class="news-item">
                <img src="<?= htmlspecialchars($item['image'] ?? '') ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>">
                <div class="news-content">
                    <p class="date"><?= htmlspecialchars($item['date'] ?? '') ?></p>
                    <h3><?= htmlspecialchars($item['title'] ?? '') ?></h3>
                    <p><?= htmlspecialchars($item['summary'] ?? '') ?></p>
                    <a href="detail-berita.php?id=<?= htmlspecialchars($item['id'] ?? '') ?>">Baca selengkapnya →</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>