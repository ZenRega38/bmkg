<?php
header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $title = $_POST['title'] ?? '';
    $date = $_POST['date'] ?? '';
    $summary = $_POST['summary'] ?? '';
    $details = $_POST['details'] ?? '';
    $imageFile = $_FILES['image'] ?? null;

    if ($id <= 0 || empty($title) || empty($date) || empty($summary) || empty($details)) {
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
        exit;
    }

    $jsonFile = '../assets/json/data-berita.json';
    $currentData = json_decode(file_get_contents($jsonFile), true) ?? [];
    
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
        
        $uploadDir = "../assets/image/berita/$year/$month/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = "berita_{$id}_" . time() . ".webp";
        $targetPath = $uploadDir . $filename;
        $newImagePath = "assets/image/berita/$year/$month/$filename";

        $tmpName = $imageFile['tmp_name'];
        $imageType = exif_imagetype($tmpName);
        $sourceImage = null;

        switch ($imageType) {
            case IMAGETYPE_JPEG: $sourceImage = imagecreatefromjpeg($tmpName); break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($tmpName);
                imagepalettetotruecolor($sourceImage);
                imagealphablending($sourceImage, true);
                imagesavealpha($sourceImage, true);
                break;
            case IMAGETYPE_GIF: $sourceImage = imagecreatefromgif($tmpName); break;
            case IMAGETYPE_WEBP: $sourceImage = imagecreatefromwebp($tmpName); break;
        }

        if ($sourceImage) {
            imagewebp($sourceImage, $targetPath, 80);
            imagedestroy($sourceImage);
            
            // Hapus gambar lama
            if (!empty($imagePath) && file_exists('../' . $imagePath)) {
                unlink('../' . $imagePath);
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

    if (file_put_contents($jsonFile, json_encode($currentData, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true, 'message' => 'Berita berhasil diperbarui!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan perubahan.']);
    }
}
?>
