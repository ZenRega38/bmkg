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

    $jsonFile = '../assets/json/data-berita.json';
    if (!file_exists($jsonFile)) {
        echo json_encode(['success' => false, 'message' => 'Data berita tidak ditemukan.']);
        exit;
    }

    $data = json_decode(file_get_contents($jsonFile), true);
    $found = false;

    foreach ($data as $index => $item) {
        if ($item['id'] === $id) {
            // Hapus gambar jika ada
            if (!empty($item['image']) && file_exists('../' . $item['image'])) {
                unlink('../' . $item['image']);
            }
            array_splice($data, $index, 1);
            $found = true;
            break;
        }
    }

    if ($found) {
        file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true, 'message' => 'Berita berhasil dihapus.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Berita tidak ditemukan.']);
    }
}
?>
