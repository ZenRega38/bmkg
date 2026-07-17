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

    if (empty($year) || empty($month)) {
        echo json_encode(['success' => false, 'message' => 'Tahun dan bulan diperlukan.']);
        exit;
    }

    $jsonFile = '../assets/json/data-wmagz.json';
    if (!file_exists($jsonFile)) {
        echo json_encode(['success' => false, 'message' => 'Data wmagz tidak ditemukan.']);
        exit;
    }

    $data = json_decode(file_get_contents($jsonFile), true);
    
    if (isset($data['magazines'][$year][$month])) {
        $magz = $data['magazines'][$year][$month];
        
        // Hapus Cover Image
        if (!empty($magz['coverImage']) && file_exists('../' . $magz['coverImage'])) {
            unlink('../' . $magz['coverImage']);
        }
        // Hapus PDF File (cek jika link lokal)
        if (!empty($magz['link']) && strpos($magz['link'], 'assets/pdf/wmagz') === 0 && file_exists('../' . $magz['link'])) {
            unlink('../' . $magz['link']);
        }

        unset($data['magazines'][$year][$month]);
        
        // Hapus array tahun jika sudah kosong
        if (empty($data['magazines'][$year])) {
            unset($data['magazines'][$year]);
        }

        file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true, 'message' => 'Majalah berhasil dihapus.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Data majalah tidak ditemukan.']);
    }
}
?>
