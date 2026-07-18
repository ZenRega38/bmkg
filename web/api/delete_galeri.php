<?php
require_once __DIR__ . '/../config.php';
requireAdminAuth();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids = [];
    if (isset($_POST['ids']) && is_array($_POST['ids'])) {
        $ids = array_map('intval', $_POST['ids']);
    } elseif (isset($_POST['id'])) {
        $ids = [intval($_POST['id'])];
    }

    $ids = array_filter($ids, function($id) { return $id > 0; });

    if (empty($ids)) {
        echo json_encode(['success' => false, 'message' => 'ID foto tidak valid atau kosong.']);
        exit;
    }

    $jsonFile = __DIR__ . '/../assets/json/data-galeri.json';
    if (!file_exists($jsonFile)) {
        echo json_encode(['success' => false, 'message' => 'Data galeri tidak ditemukan.']);
        exit;
    }

    $data = json_decode(file_get_contents($jsonFile), true) ?? [];
    $webDir = dirname(__DIR__);
    $deletedCount = 0;

    $newData = [];
    foreach ($data as $item) {
        $itemId = intval($item['id'] ?? 0);
        if (in_array($itemId, $ids)) {
            // Hapus file gambar fisik dari disk
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
            $deletedCount++;
        } else {
            $newData[] = $item;
        }
    }

    if ($deletedCount > 0) {
        file_put_contents($jsonFile, json_encode($newData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        echo json_encode([
            'success' => true,
            'message' => "Berhasil menghapus {$deletedCount} foto galeri beserta file fisiknya."
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Foto yang dipilih tidak ditemukan.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
