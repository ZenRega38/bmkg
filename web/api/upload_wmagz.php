<?php
header('Content-Type: application/json');

session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Include pipeline processor
require_once __DIR__ . '/process_wmagz_pdf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $year    = $_POST['year']    ?? '';
    $month   = $_POST['month']   ?? '';
    $title   = $_POST['title']   ?? '';
    $summary = $_POST['summary'] ?? '';
    $pdfFile = $_FILES['pdfFile'] ?? null;
    $coverBase64 = $_POST['coverImageBase64'] ?? '';

    if (empty($year) || empty($month) || empty($title) || empty($summary)) {
        echo json_encode(['success' => false, 'message' => 'Semua kolom teks harus diisi.']);
        exit;
    }

    $jsonFile    = '../assets/json/data-wmagz.json';
    $currentData = [];
    if (file_exists($jsonFile)) {
        $currentData = json_decode(file_get_contents($jsonFile), true) ?? ['magazines' => []];
    }
    if (!isset($currentData['magazines'])) {
        $currentData['magazines'] = [];
    }

    // ---------------------------------------------------------------
    // 1. Simpan file PDF
    // ---------------------------------------------------------------
    if (!$pdfFile || $pdfFile['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'File PDF wajib diunggah.']);
        exit;
    }

    $pdfUploadDir = dirname(__DIR__) . "/assets/pdf/wmagz/$year/";
    if (!is_dir($pdfUploadDir)) {
        mkdir($pdfUploadDir, 0755, true);
    }

    $pdfFilename  = "wmagz_{$month}.pdf";
    $pdfAbsPath   = $pdfUploadDir . $pdfFilename;
    $pdfRelPath   = "assets/pdf/wmagz/$year/$pdfFilename";

    if (!move_uploaded_file($pdfFile['tmp_name'], $pdfAbsPath)) {
        echo json_encode(['success' => false, 'message' => 'Gagal mengunggah file PDF.']);
        exit;
    }

    // ---------------------------------------------------------------
    // 2. Simpan cover image (dari PDF.js base64 yang digenerate client)
    // ---------------------------------------------------------------
    $imagePath = '';
    if (!empty($coverBase64)) {
        $imgUploadDir = dirname(__DIR__) . "/assets/image/wmagz/$year/";
        if (!is_dir($imgUploadDir)) {
            mkdir($imgUploadDir, 0755, true);
        }

        $imgFilename  = "cover_{$month}.webp";
        $targetImgPath = $imgUploadDir . $imgFilename;
        $imagePath    = "assets/image/wmagz/$year/$imgFilename";

        if (preg_match('/^data:image\/(\w+);base64,/', $coverBase64, $type)) {
            $coverBase64Clean = substr($coverBase64, strpos($coverBase64, ',') + 1);
            $coverData = base64_decode($coverBase64Clean);
            if ($coverData !== false) {
                $sourceImage = imagecreatefromstring($coverData);
                if ($sourceImage !== false) {
                    imagewebp($sourceImage, $targetImgPath, 82);
                    imagedestroy($sourceImage);
                }
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal membuat kover dari PDF.']);
        exit;
    }

    // ---------------------------------------------------------------
    // 3. Jalankan pipeline: PDF → WebP per halaman → viewer.html
    // ---------------------------------------------------------------
    $result = processMagazinePdf($pdfAbsPath, $year, $month, $title);

    if (!$result['success']) {
        // Pipeline gagal — tetap simpan entry tapi link ke PDF langsung
        $viewerLink = $pdfRelPath;
        $warnMsg    = " (Catatan: konversi halaman gagal — link ke PDF. " . $result['message'] . ")";
    } else {
        // Link ke viewer.html edisi ini
        $viewerLink = $result['viewerPath'];
        $warnMsg    = '';
    }

    // ---------------------------------------------------------------
    // 4. Simpan entry ke data-wmagz.json
    // ---------------------------------------------------------------
    if (!isset($currentData['magazines'][$year])) {
        $currentData['magazines'][$year] = [];
    }

    $currentData['magazines'][$year][$month] = [
        'title'      => $title,
        'summary'    => $summary,
        'coverImage' => $imagePath,
        'link'       => $viewerLink,
        'pdfSource'  => $pdfRelPath,       // Simpan path PDF asli juga
        'pages'      => $result['pages'] ?? 0,
    ];

    if (file_put_contents($jsonFile, json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))) {
        echo json_encode([
            'success' => true,
            'message' => "Edisi W'Magz '{$title}' berhasil ditambahkan! ({$result['pages']} halaman){$warnMsg}",
            'pages'   => $result['pages'] ?? 0,
            'viewer'  => $viewerLink,
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan ke data JSON.']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
