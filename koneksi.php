<?php
$host     = "localhost";
$user     = "root";
$password = "";
$db       = "sekolah";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $password, $db);

// Cek Koneksi
if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

echo "Koneksi Berhasil!";
?>