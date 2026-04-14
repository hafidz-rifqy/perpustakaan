<?php
session_start(); // Wajib dipanggil untuk memulai session
include 'koneksi.php'; // Panggil file koneksi database Anda

// Ambil data dari form login
$username = $_POST['username'];
$password = $_POST['password'];

// Cek kecocokan data di database
$query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");

// Menghitung jumlah baris yang ditemukan
$cek = mysqli_num_rows($query);

if($cek > 0) {
    // Jika cocok, ambil data dan buat session
    $data = mysqli_fetch_assoc($query);
    $_SESSION['username'] = $username;
    $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
    $_SESSION['status_login'] = true;
    
    // Alihkan ke halaman dashboard
    header("Location: index.php");
} else {
    // Jika salah, kembalikan ke halaman login dengan pesan
    echo "<script>
            alert('Login gagal! Username atau password salah.');
            window.location.href='login.php';
          </script>";
}
?>