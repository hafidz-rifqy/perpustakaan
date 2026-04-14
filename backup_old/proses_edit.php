<?php
include 'koneksi.php';

// Tangkap semua data dari form
$id     = $_POST['id'];
$nama   = $_POST['nama'];
$kelas  = $_POST['kelas'];
$alamat = $_POST['alamat'];

// Query UPDATE dengan WHERE
$sql = "UPDATE siswa SET 
        nama   = '$nama', 
        kelas  = '$kelas', 
        alamat = '$alamat' 
        WHERE id = '$id'";

// Jalankan query
if (mysqli_query($conn, $sql)) {
    header("location:index.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>