<?php
require_once __DIR__ . '/../config.php';
requireAdminAuth();

header('Content-Type: application/json');

function deleteDirectory($dir) {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir)) return unlink($dir);
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') continue;
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) return false;
    }
    return rmdir($dir);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitasi ketat cegah Path Traversal (../)
    $year  = sanitizePathSegment($_POST['year'] ?? '');
    $month = sanitizePathSegment($_POST['month'] ?? '');

    if (empty($year) || empty($month)) {
        echo json_encode(['success' => false, 'message' => 'Tahun dan bulan diperlukan.']);
        exit;
    }

    $jsonFile = __DIR__ . '/../assets/json/data-wmagz.json';
    if (!file_exists($jsonFile)) {
        echo json_encode(['success' => false, 'message' => 'Data wmagz tidak ditemukan.']);
        exit;
    }

    $data = json_decode(file_get_contents($jsonFile), true);
    $webDir = dirname(__DIR__);
    $monthLower = strtolower($month);

    if (isset($data['magazines'][$year][$month])) {
        $magz = $data['magazines'][$year][$month];

        // 1. Hapus Cover Image
        if (!empty($magz['coverImage'])) {
            $coverPath = $webDir . '/' . ltrim($magz['coverImage'], '/');
            if (file_exists($coverPath)) {
                @unlink($coverPath);
            }
        }

        // 2. Hapus PDF Source
        if (!empty($magz['pdfSource'])) {
            $pdfPath = $webDir . '/' . ltrim($magz['pdfSource'], '/');
            if (file_exists($pdfPath)) {
                @unlink($pdfPath);
            }
        }
        $defaultPdf = $webDir . "/assets/pdf/wmagz/{$year}/wmagz_{$month}.pdf";
        if (file_exists($defaultPdf)) {
            @unlink($defaultPdf);
        }

        // 3. Hapus folder viewer & halaman webp majalah
        $folderViewer = $webDir . "/assets/wmagz/magazine_{$monthLower}_{$year}";
        if (is_dir($folderViewer)) {
            deleteDirectory($folderViewer);
        }

        if (!empty($magz['link']) && strpos($magz['link'], 'assets/wmagz/') !== false) {
            $linkPath = $webDir . '/' . ltrim($magz['link'], '/');
            $dirPath  = is_file($linkPath) ? dirname($linkPath) : $linkPath;
            if (is_dir($dirPath) && strpos(realpath($dirPath), realpath($webDir . '/assets/wmagz')) === 0) {
                deleteDirectory($dirPath);
            }
        }

        // 4. Bersihkan folder tahun jika kosong
        $pdfYearDir = $webDir . "/assets/pdf/wmagz/{$year}";
        if (is_dir($pdfYearDir) && count(array_diff(scandir($pdfYearDir), ['.', '..'])) === 0) {
            @rmdir($pdfYearDir);
        }
        $imgYearDir = $webDir . "/assets/image/wmagz/{$year}";
        if (is_dir($imgYearDir) && count(array_diff(scandir($imgYearDir), ['.', '..'])) === 0) {
            @rmdir($imgYearDir);
        }

        // 5. Hapus dari JSON
        unset($data['magazines'][$year][$month]);
        if (empty($data['magazines'][$year])) {
            unset($data['magazines'][$year]);
        }

        file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        echo json_encode(['success' => true, 'message' => "Majalah {$month} {$year} dan seluruh filenya berhasil dihapus permanen."]);
    } else {
        // Pembersihan sisa file orphan jika data JSON sudah terhapus
        $folderViewer = $webDir . "/assets/wmagz/magazine_{$monthLower}_{$year}";
        $defaultPdf   = $webDir . "/assets/pdf/wmagz/{$year}/wmagz_{$month}.pdf";
        $defaultImg   = $webDir . "/assets/image/wmagz/{$year}/cover_{$month}.webp";

        if (file_exists($defaultPdf)) @unlink($defaultPdf);
        if (file_exists($defaultImg)) @unlink($defaultImg);
        if (is_dir($folderViewer)) deleteDirectory($folderViewer);

        $pdfYearDir = $webDir . "/assets/pdf/wmagz/{$year}";
        if (is_dir($pdfYearDir) && count(array_diff(scandir($pdfYearDir), ['.', '..'])) === 0) {
            @rmdir($pdfYearDir);
        }
        $imgYearDir = $webDir . "/assets/image/wmagz/{$year}";
        if (is_dir($imgYearDir) && count(array_diff(scandir($imgYearDir), ['.', '..'])) === 0) {
            @rmdir($imgYearDir);
        }

        echo json_encode(['success' => true, 'message' => "Pembersihan file sisa majalah {$month} {$year} selesai."]);
    }
}
?>
