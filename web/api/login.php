<?php
require_once __DIR__ . '/../config.php';
initSecureSession();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $captcha  = strtoupper(trim($_POST['captcha'] ?? ''));
    
    // 1. Verifikasi Captcha Gambar
    if (!isset($_SESSION['captcha_code']) || $captcha !== $_SESSION['captcha_code']) {
        unset($_SESSION['captcha_code']); // Invalidate captcha after attempt
        echo json_encode(['success' => false, 'message' => 'Kode Captcha salah atau sudah kedaluwarsa. Halaman akan dimuat ulang.']);
        exit;
    }

    // 2. Verifikasi Autentikasi secara Kriptografis (Bcrypt Hash)
    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        session_regenerate_id(true); // Prevent Session Fixation
        $_SESSION['admin_logged_in'] = true;
        unset($_SESSION['captcha_code']); // Clean up captcha session
        echo json_encode(['success' => true]);
    } else {
        unset($_SESSION['captcha_code']);
        echo json_encode(['success' => false, 'message' => 'Username atau Password salah. Halaman akan dimuat ulang.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
