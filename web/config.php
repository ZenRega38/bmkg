<?php
// Global Security & App Configuration

// Admin Credentials (Stored as secure Bcrypt Hash)
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD_HASH', '$2y$10$SyUuAK0SOHASDBM8Ga/KOe0r4nK9t1IJE0cK1iAeeVIU/2/51vGOW');

/**
 * Configure secure session parameters
 */
function initSecureSession() {
    if (session_status() === PHP_SESSION_NONE) {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_strict_mode', 1);
        session_start();
    }
}

/**
 * Sanitize strings against XSS attacks
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(trim((string)$data), ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize path parameters against Path Traversal attacks (../)
 */
function sanitizePathSegment($segment) {
    return preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$segment);
}

/**
 * Verify admin session authorization
 */
function requireAdminAuth() {
    initSecureSession();
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
}
?>
