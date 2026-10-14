<?php
declare(strict_types=1);
session_start();

$DB_HOST = '127.0.0.1';
$DB_NAME = 'portal_akademik';
$DB_USER = 'root';
$DB_PASS = ''; // Default XAMPP. Sesuaikan jika MySQL Anda memakai password.

try {
    $pdo = new PDO(
        "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('Koneksi database gagal. Pastikan MySQL aktif dan database portal_akademik sudah diimpor melalui phpMyAdmin.');
}
