<?php
require_once __DIR__ . '/../config.php';
requireAdminAuth();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = sanitizeInput($_POST['title'] ?? '');
    $date    = sanitizeInput($_POST['date'] ?? '');
    $summary = sanitizeInput($_POST['summary'] ?? '');
    $details = sanitizeInput($_POST['details'] ?? '');
    $imageFile = $_FILES['image'] ?? null;

    if (empty($title) || empty($date) || empty($summary) || empty($details)) {
        echo json_encode(['success' => false, 'message' => 'Semua kolom teks harus diisi.']);
        exit;
    }

    $jsonFile = '../assets/json/data-berita.json';
    $currentData = [];
    if (file_exists($jsonFile)) {
        $jsonContent = file_get_contents($jsonFile);
        $currentData = json_decode($jsonContent, true) ?? [];
    }

    // Generate new ID
    $newId = 1;
    foreach ($currentData as $item) {
        if (isset($item['id']) && $item['id'] >= $newId) {
            $newId = $item['id'] + 1;
        }
    }

    $imagePath = '';
    
    if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
        // Image Processing to WebP
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        
        $uploadDir = "../assets/image/berita/$year/$month/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = "berita_{$newId}.webp";
        $targetPath = $uploadDir . $filename;
        $imagePath = "assets/image/berita/$year/$month/$filename";

        $tmpName = $imageFile['tmp_name'];
        $imageType = exif_imagetype($tmpName);

        $sourceImage = null;
        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($tmpName);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($tmpName);
                // Handle transparency
                imagepalettetotruecolor($sourceImage);
                imagealphablending($sourceImage, true);
                imagesavealpha($sourceImage, true);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($tmpName);
                break;
            case IMAGETYPE_WEBP:
                $sourceImage = imagecreatefromwebp($tmpName);
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Format gambar tidak didukung. Harap gunakan JPG, PNG, atau WEBP.']);
                exit;
        }

        if ($sourceImage) {
            // Convert to WebP and save with 80% quality
            imagewebp($sourceImage, $targetPath, 80);
            imagedestroy($sourceImage);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal memproses gambar.']);
            exit;
        }
    } else {
         echo json_encode(['success' => false, 'message' => 'Gambar wajib diunggah.']);
         exit;
    }

    $newItem = [
        'id' => $newId,
        'title' => $title,
        'date' => $date,
        'image' => $imagePath,
        'summary' => $summary,
        'details' => $details
    ];

    // Put new item at the beginning
    array_unshift($currentData, $newItem);

    // Save to JSON
    if (file_put_contents($jsonFile, json_encode($currentData, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true, 'message' => 'Berita berhasil ditambahkan!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan ke data JSON.']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
