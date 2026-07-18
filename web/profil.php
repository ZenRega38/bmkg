<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>Profil - BMKG Tarakan</title>
    <link rel="stylesheet" href="css/profil.css">
    <link rel="stylesheet" href="css/outer.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php
        include 'widget/header.php';
    ?>
    <main>
       <section class="section-content content-flex">
            <div class="section-content-inner" id="sejarah">
                <h2>Sejarah BMKG Juwata Tarakan</h2>
                <p>

                    Stasiun Meteorologi Juwata Tarakan merupakan salah satu unit pelaksana teknis di bawah naungan Badan Meteorologi, Klimatologi, dan Geofisika (BMKG) yang bertugas dalam melakukan pengamatan, analisis, serta penyebarluasan informasi meteorologi, klimatologi, dan geofisika. Stasiun ini memiliki peran penting dalam mendukung berbagai sektor, termasuk penerbangan, perikanan, pertanian, serta mitigasi bencana di wilayah Kalimantan Utara.

                    Sebagai bagian dari jaringan stasiun meteorologi di Indonesia, Stasiun Meteorologi Juwata Tarakan menjalankan berbagai tugas utama, seperti melakukan pengamatan cuaca secara berkala, menganalisis data klimatologi, serta memberikan peringatan dini terhadap potensi cuaca ekstrem. Informasi yang dihasilkan tidak hanya bermanfaat bagi dunia penerbangan, tetapi juga bagi masyarakat umum, terutama dalam menghadapi perubahan iklim dan potensi bencana alam seperti badai, banjir, atau gelombang tinggi.

                    Dengan perannya yang semakin krusial, Stasiun Meteorologi Juwata Tarakan terus berupaya meningkatkan kualitas layanan melalui modernisasi peralatan serta penguatan sumber daya manusia. Kolaborasi dengan berbagai instansi pemerintah, akademisi, dan masyarakat juga menjadi bagian dari strategi dalam meningkatkan akurasi serta kecepatan penyampaian informasi meteorologi dan klimatologi.                </p>
            </div>

             <div class="section-content-inner" id="video" style="text-align: justify;">
                <h2>Video Profil BMKG Juwata Tarakan</h2>
                 <div class="video-container">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/uep9J0hvjVo?si=In2E7tbpOMjGKVT9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>                </div>

            </div>
       </section>

        <section class="section-content" id="struktural">
            <h2>Struktur Organisasi BMKG Juwata Tarakan</h2>
            <div class="struktural-container">
                <img src="assets/image/diagram-struktural.png" alt="Galeri struktural" style="max-width: 50%; height: auto; display: block; margin: 0 auto;">
                <p>    
                    Stasiun Meteorologi Juwata Tarakan merupakan unit pelaksana teknis di bawah Badan Meteorologi, Klimatologi, dan Geofisika (BMKG) yang berada pada tingkat 3 dalam struktur organisasi BMKG. Ini berarti bahwa Stasiun Meteorologi Juwata Tarakan termasuk dalam kategori stasiun meteorologi kelas II, yang memiliki tugas utama dalam melakukan pengamatan, analisis, dan penyebarluasan informasi meteorologi, klimatologi, dan geofisika di wilayahnya. Struktur organisasi tingkat 3 dalam BMKG umumnya mencakup kepala stasiun sebagai pimpinan, yang dibantu oleh beberapa kepala seksi atau sub-koordinator yang menangani bidang operasional seperti meteorologi penerbangan, klimatologi, dan pelayanan informasi cuaca. Selain itu, terdapat staf teknis dan administratif yang bertanggung jawab dalam mendukung kegiatan operasional stasiun. Dengan struktur ini, Stasiun Meteorologi Juwata Tarakan berperan penting dalam menyediakan data dan informasi cuaca yang akurat, terutama bagi penerbangan serta kepentingan masyarakat di wilayah Kalimantan Utara.
                </p>
            </div>

        </section>

        <section class="section-content" id="galeri">
            <h2>Galeri BMKG Juwata Tarakan</h2>
            <div class="gallery">
                <?php
                $galeriFile = __DIR__ . '/assets/json/data-galeri.json';
                $galeriItems = [];
                if (file_exists($galeriFile)) {
                    $galeriItems = json_decode(file_get_contents($galeriFile), true) ?? [];
                }
                // Urutkan berdasarkan tanggal foto terbaru
                usort($galeriItems, function($a, $b) {
                    $tA = isset($a['rawDate']) ? strtotime($a['rawDate']) : 0;
                    $tB = isset($b['rawDate']) ? strtotime($b['rawDate']) : 0;
                    if ($tA == $tB) {
                        return ($b['id'] ?? 0) <=> ($a['id'] ?? 0);
                    }
                    return $tB <=> $tA;
                });

                if (!empty($galeriItems)):
                    foreach ($galeriItems as $g):
                ?>
                <div class="gallery-item" onclick="openGalleryModal(<?= htmlspecialchars(json_encode($g), ENT_QUOTES, 'UTF-8') ?>)">
                    <img src="<?= htmlspecialchars($g['image']) ?>" alt="<?= htmlspecialchars($g['title']) ?>">
                    <div class="gallery-overlay">
                        <span class="gallery-date"><?= htmlspecialchars($g['date']) ?></span>
                        <h4 class="gallery-title"><?= htmlspecialchars($g['title']) ?></h4>
                    </div>
                </div>
                <?php
                    endforeach;
                else:
                ?>
                    <p style="width: 100%; text-align: center; color: #666;">Belum ada foto galeri.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- Lightbox Modal Gallery -->
    <div id="galleryModal" class="gallery-modal" onclick="closeGalleryModal(event)">
        <div class="gallery-modal-content" onclick="event.stopPropagation()">
            <button type="button" class="gallery-modal-close" onclick="closeGalleryModal()">&times;</button>
            <img id="modalImg" src="" alt="Galeri Photo">
            <div class="gallery-modal-info">
                <span class="gallery-modal-date" id="modalDate"></span>
                <h3 id="modalTitle"></h3>
                <p id="modalSubtitle"></p>
            </div>
        </div>
    </div>

    <script src="assets/script/nav.js"></script>
    <script>
        function openGalleryModal(data) {
            const modal = document.getElementById('galleryModal');
            document.getElementById('modalImg').src = data.image;
            document.getElementById('modalTitle').innerText = data.title;
            document.getElementById('modalSubtitle').innerText = data.subtitle;
            document.getElementById('modalDate').innerText = data.date;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeGalleryModal(e) {
            if (!e || e.target.id === 'galleryModal' || e.target.classList.contains('gallery-modal-close')) {
                const modal = document.getElementById('galleryModal');
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeGalleryModal();
            }
        });
    </script>
    
    <?php include 'widget/footer.php'; ?>
</body>
</html>

