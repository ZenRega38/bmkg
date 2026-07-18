<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
        exit;
    }

    $jsonFile = __DIR__ . '/../assets/json/data-berita.json';
    if (!file_exists($jsonFile)) {
        echo json_encode(['success' => false, 'message' => 'Data berita tidak ditemukan.']);
        exit;
    }

    $data = json_decode(file_get_contents($jsonFile), true) ?? [];
    $found = false;
    $webDir = dirname(__DIR__);

    foreach ($data as $index => $item) {
        if ($item['id'] === $id) {
            // Hapus file gambar pendukung
            if (!empty($item['image'])) {
                $imagePath = $webDir . '/' . ltrim($item['image'], '/');
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                    // Bersihkan folder bulan & tahun jika kosong
                    $dirMonth = dirname($imagePath);
                    if (is_dir($dirMonth) && count(array_diff(scandir($dirMonth), ['.', '..'])) === 0) {
                        @rmdir($dirMonth);
                        $dirYear = dirname($dirMonth);
                        if (is_dir($dirYear) && count(array_diff(scandir($dirYear), ['.', '..'])) === 0) {
                            @rmdir($dirYear);
                        }
                    }
                }
            }
            array_splice($data, $index, 1);
            $found = true;
            break;
        }
    }

    if ($found) {
        file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        echo json_encode(['success' => true, 'message' => 'Berita beserta gambarnya berhasil dihapus permanen.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Berita tidak ditemukan.']);
    }
}
?>
