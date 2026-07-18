<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

function formatIndonesianDate($dateStr) {
    $timestamp = strtotime($dateStr);
    if (!$timestamp) return $dateStr;
    
    $bulanIndo = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    
    $day = date('d', $timestamp);
    $month = (int)date('m', $timestamp);
    $year = date('Y', $timestamp);
    
    return "{$day} {$bulanIndo[$month]} {$year}";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $dateInput = trim($_POST['date'] ?? date('Y-m-d'));
    
    if (empty($title) || empty($subtitle) || empty($dateInput)) {
        echo json_encode(['success' => false, 'message' => 'Judul, Subtitle, dan Tanggal Foto harus diisi.']);
        exit;
    }

    // Normalisasi array file unggahan
    $files = [];
    if (isset($_FILES['images']) && is_array($_FILES['images']['name'])) {
        $fileCount = count($_FILES['images']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                $files[] = [
                    'name'     => $_FILES['images']['name'][$i],
                    'tmp_name' => $_FILES['images']['tmp_name'][$i],
                    'type'     => $_FILES['images']['type'][$i],
                    'error'    => $_FILES['images']['error'][$i],
                    'size'     => $_FILES['images']['size'][$i],
                ];
            }
        }
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $files[] = $_FILES['image'];
    }

    if (empty($files)) {
        echo json_encode(['success' => false, 'message' => 'Harap pilih minimal satu file gambar valid.']);
        exit;
    }

    $jsonFile = __DIR__ . '/../assets/json/data-galeri.json';
    $currentData = [];
    if (file_exists($jsonFile)) {
        $jsonContent = file_get_contents($jsonFile);
        $currentData = json_decode($jsonContent, true) ?? [];
    }

    // Generate Base ID
    $maxId = 0;
    foreach ($currentData as $item) {
        if (isset($item['id']) && $item['id'] > $maxId) {
            $maxId = $item['id'];
        }
    }

    $year = date('Y', strtotime($dateInput));
    $month = date('m', strtotime($dateInput));
    $uploadDir = __DIR__ . "/../assets/image/galeri/$year/$month/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $formattedDate = formatIndonesianDate($dateInput);
    $addedItems = 0;

    foreach ($files as $index => $file) {
        $tmpName   = $file['tmp_name'];
        $imageType = @exif_imagetype($tmpName);

        $sourceImage = null;
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $sourceImage = @imagecreatefromjpeg($tmpName);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = @imagecreatefrompng($tmpName);
                if ($sourceImage) {
                    imagepalettetotruecolor($sourceImage);
                    imagealphablending($sourceImage, true);
                    imagesavealpha($sourceImage, true);
                }
                break;
            case IMAGETYPE_GIF:
                $sourceImage = @imagecreatefromgif($tmpName);
                break;
            case IMAGETYPE_WEBP:
                $sourceImage = @imagecreatefromwebp($tmpName);
                break;
            case IMAGETYPE_BMP:
                $sourceImage = @imagecreatefrombmp($tmpName);
                break;
            default:
                // Coba gunakan imagecreatefromstring sebagai fallback
                $fileBytes = @file_get_contents($tmpName);
                if ($fileBytes) {
                    $sourceImage = @imagecreatefromstring($fileBytes);
                }
                break;
        }

        if (!$sourceImage) {
            continue; // Skip file jika bukan gambar valid
        }

        $maxId++;
        $randStr = substr(md5(uniqid(mt_rand(), true)), 0, 6);
        $filename = "galeri_{$maxId}_{$randStr}.webp";
        $targetPath = $uploadDir . $filename;
        $relPath = "assets/image/galeri/$year/$month/$filename";

        // Simpan sebagai WebP terkompresi (kualitas 82%)
        imagewebp($sourceImage, $targetPath, 82);
        imagedestroy($sourceImage);

        $newItem = [
            'id'       => $maxId,
            'title'    => $title,
            'subtitle' => $subtitle,
            'date'     => $formattedDate,
            'rawDate'  => $dateInput,
            'image'    => $relPath
        ];

        // Masukkan item baru di depan array
        array_unshift($currentData, $newItem);
        $addedItems++;
    }

    if ($addedItems > 0) {
        file_put_contents($jsonFile, json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        echo json_encode([
            'success' => true,
            'message' => "Berhasil mengunggah {$addedItems} foto dokumentasi!"
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memproses file gambar. Harap gunakan file gambar valid.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
