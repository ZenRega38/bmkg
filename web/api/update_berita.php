<?php
require_once __DIR__ . '/../config.php';
requireAdminAuth();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id      = intval($_POST['id'] ?? 0);
    $title   = sanitizeInput($_POST['title'] ?? '');
    $date    = sanitizeInput($_POST['date'] ?? '');
    $summary = sanitizeInput($_POST['summary'] ?? '');
    $details = sanitizeInput($_POST['details'] ?? '');
    $imageFile = $_FILES['image'] ?? null;

    if ($id <= 0 || empty($title) || empty($date) || empty($summary) || empty($details)) {
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
        exit;
    }

    $jsonFile = __DIR__ . '/../assets/json/data-berita.json';
    if (!file_exists($jsonFile)) {
        echo json_encode(['success' => false, 'message' => 'Data berita tidak ditemukan.']);
        exit;
    }

    $currentData = json_decode(file_get_contents($jsonFile), true) ?? [];
    $webDir = dirname(__DIR__);
    
    $foundIndex = -1;
    foreach ($currentData as $index => $item) {
        if ($item['id'] === $id) {
            $foundIndex = $index;
            break;
        }
    }

    if ($foundIndex === -1) {
        echo json_encode(['success' => false, 'message' => 'Berita tidak ditemukan.']);
        exit;
    }

    $imagePath = $currentData[$foundIndex]['image']; // Default ke gambar lama
    
    // Jika ada upload gambar baru
    if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        
        $uploadDir = $webDir . "/assets/image/berita/$year/$month/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = "berita_{$id}_" . time() . ".webp";
        $targetPath = $uploadDir . $filename;
        $newImagePath = "assets/image/berita/$year/$month/$filename";

        $tmpName = $imageFile['tmp_name'];
        $imageType = @exif_imagetype($tmpName);
        $sourceImage = null;

        switch ($imageType) {
            case IMAGETYPE_JPEG: $sourceImage = @imagecreatefromjpeg($tmpName); break;
            case IMAGETYPE_PNG:
                $sourceImage = @imagecreatefrompng($tmpName);
                if ($sourceImage) {
                    imagepalettetotruecolor($sourceImage);
                    imagealphablending($sourceImage, true);
                    imagesavealpha($sourceImage, true);
                }
                break;
            case IMAGETYPE_GIF: $sourceImage = @imagecreatefromgif($tmpName); break;
            case IMAGETYPE_WEBP: $sourceImage = @imagecreatefromwebp($tmpName); break;
            default:
                $fileBytes = @file_get_contents($tmpName);
                if ($fileBytes) $sourceImage = @imagecreatefromstring($fileBytes);
                break;
        }

        if ($sourceImage) {
            imagewebp($sourceImage, $targetPath, 80);
            imagedestroy($sourceImage);
            
            // Hapus gambar lama
            if (!empty($imagePath)) {
                $oldImgPath = $webDir . '/' . ltrim($imagePath, '/');
                if (file_exists($oldImgPath)) {
                    @unlink($oldImgPath);
                }
            }
            $imagePath = $newImagePath;
        }
    }

    $currentData[$foundIndex] = [
        'id' => $id,
        'title' => $title,
        'date' => $date,
        'image' => $imagePath,
        'summary' => $summary,
        'details' => $details
    ];

    if (file_put_contents($jsonFile, json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES))) {
        echo json_encode(['success' => true, 'message' => 'Berita berhasil diperbarui!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan perubahan.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
