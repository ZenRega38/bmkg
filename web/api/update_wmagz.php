<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $year = $_POST['year'] ?? '';
    $month = $_POST['month'] ?? '';
    $title = $_POST['title'] ?? '';
    $summary = $_POST['summary'] ?? '';
    
    $pdfFile = $_FILES['pdfFile'] ?? null;
    $coverBase64 = $_POST['coverImageBase64'] ?? '';

    if (empty($year) || empty($month) || empty($title) || empty($summary)) {
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
        exit;
    }

    $jsonFile = '../assets/json/data-wmagz.json';
    $data = json_decode(file_get_contents($jsonFile), true) ?? ['magazines' => []];

    if (!isset($data['magazines'][$year][$month])) {
        echo json_encode(['success' => false, 'message' => 'Data majalah tidak ditemukan.']);
        exit;
    }

    $currentMagz = $data['magazines'][$year][$month];
    $pdfPath = $currentMagz['link'];
    $imagePath = $currentMagz['coverImage'];

    // Jika ada PDF baru
    if ($pdfFile && $pdfFile['error'] === UPLOAD_ERR_OK) {
        $pdfUploadDir = "../assets/pdf/wmagz/$year/";
        if (!is_dir($pdfUploadDir)) { mkdir($pdfUploadDir, 0777, true); }
        
        $pdfFilename = "wmagz_{$month}_" . time() . ".pdf";
        $targetPdfPath = $pdfUploadDir . $pdfFilename;
        $newPdfPath = "assets/pdf/wmagz/$year/$pdfFilename";

        if (move_uploaded_file($pdfFile['tmp_name'], $targetPdfPath)) {
            // Hapus PDF lama
            if (!empty($pdfPath) && strpos($pdfPath, 'assets/pdf') === 0 && file_exists('../' . $pdfPath)) {
                unlink('../' . $pdfPath);
            }
            $pdfPath = $newPdfPath;
            
            // Proses cover base64
            if (!empty($coverBase64) && preg_match('/^data:image\/(\w+);base64,/', $coverBase64, $type)) {
                $coverBase64 = substr($coverBase64, strpos($coverBase64, ',') + 1);
                $coverData = base64_decode($coverBase64);
                
                if ($coverData !== false) {
                    $sourceImage = imagecreatefromstring($coverData);
                    if ($sourceImage !== false) {
                        $imgUploadDir = "../assets/image/wmagz/$year/";
                        if (!is_dir($imgUploadDir)) { mkdir($imgUploadDir, 0777, true); }
                        $imgFilename = "cover_{$month}_" . time() . ".webp";
                        
                        imagewebp($sourceImage, $imgUploadDir . $imgFilename, 80);
                        imagedestroy($sourceImage);
                        
                        // Hapus cover lama
                        if (!empty($imagePath) && file_exists('../' . $imagePath)) {
                            unlink('../' . $imagePath);
                        }
                        $imagePath = "assets/image/wmagz/$year/$imgFilename";
                    }
                }
            }
        }
    }

    $data['magazines'][$year][$month] = [
        'title' => $title,
        'summary' => $summary,
        'coverImage' => $imagePath,
        'link' => $pdfPath
    ];

    if (file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true, 'message' => 'Majalah berhasil diperbarui!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data JSON.']);
    }
}
?>
