<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $captcha = strtoupper(trim($_POST['captcha'] ?? ''));
    
    // Verifikasi Captcha Gambar
    if (!isset($_SESSION['captcha_code']) || $captcha !== $_SESSION['captcha_code']) {
        // Hapus session captcha agar user harus merefresh gambar baru
        unset($_SESSION['captcha_code']);
        
        echo json_encode(['success' => false, 'message' => 'Kode Captcha salah atau sudah kedaluwarsa. Halaman akan dimuat ulang.']);
        exit;
    }

    // Cek Autentikasi (Hardcoded untuk anti SQL Injection)
    if ($username === 'admin' && $password === 'adminbmkg123') {
        $_SESSION['admin_logged_in'] = true;
        unset($_SESSION['captcha_code']); // Bersihkan captcha setelah sukses
        echo json_encode(['success' => true]);
    } else {
        // Hapus session captcha jika password salah
        unset($_SESSION['captcha_code']);
        
        echo json_encode(['success' => false, 'message' => 'Username atau Password salah. Halaman akan dimuat ulang.']);
    }
}
?>
