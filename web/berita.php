

<body>
<main class="container">
    <div class="news-row">
        <?php foreach ($newsItems as $item): ?>
            <div class="news-item">
                <img src="<?= $item['image'] ?>" alt="<?= $item['title'] ?>">
                <div class="news-content">
                    <p class="date"><?= $item['date'] ?></p>
                    <h3><?= $item['title'] ?></h3>
                    <p><?= $item['summary'] ?></p>
                    <a href="detail-berita.php?id=<?= $item['id'] ?>">Baca selengkapnya →</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>