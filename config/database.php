<?php
// Pastikan env_parser dipanggil agar $_ENV tersedia
require_once __DIR__ . '/env_parser.php';

$host = $_ENV['DB_HOST'] ?? 'localhost';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? '';
$db   = $_ENV['DB_NAME'] ?? 'db_perpustakaan';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>
