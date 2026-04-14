<?php
session_start();
include 'koneksi.php';

// Ambil data dari form login
$username = $_POST['username'];
$password = $_POST['password'];

// Query ke database (sesuaikan dengan struktur tabel admin)
$query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if(!$result) {
    die("Error query: " . mysqli_error($conn));
}

// Cek apakah ada data yang cocok
if(mysqli_num_rows($result) > 0) {
    // Ambil data admin
    $data = mysqli_fetch_assoc($result);
    
    // Buat session
    $_SESSION['id_admin'] = $data['id_admin'];
    $_SESSION['username'] = $username;
    $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
    $_SESSION['status_login'] = true;
    
    // Alihkan ke halaman dashboard/index
    header("Location: index.php");
    exit();
} else {
    // Login gagal
    echo "<script>
            alert('Login gagal! Username atau password salah.');
            window.location.href='login.php';
          </script>";
    exit();
}
?>