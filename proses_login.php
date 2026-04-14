<?php
session_start();
include 'koneksi.php';

// Cek apakah form sudah disubmit
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Ambil input
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Buat query dengan prepared statement
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    // CEK APAKAH PREPARED STATEMENT BERHASIL
    if(!$stmt) {
        die("Error prepared statement: " . mysqli_error($conn));
    }
    
    // Bind parameter
    mysqli_stmt_bind_param($stmt, "s", $username);
    
    // Eksekusi
    mysqli_stmt_execute($stmt);
    
    // Ambil hasil
    $result = mysqli_stmt_get_result($stmt);
    
    // Cek apakah query berhasil
    if($result) {
        $cek = mysqli_num_rows($result);
        
        if($cek > 0) {
            $data = mysqli_fetch_assoc($result);
            
            // Bandingkan password (asumsi plain text dulu)
            if($password == $data['password']) {
                $_SESSION['username'] = $username;
                $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
                $_SESSION['status_login'] = true;
                
                header("Location: index.php");
                exit();
            } else {
                echo "<script>
                        alert('Login gagal! Username atau password salah.');
                        window.location.href='login.php';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Login gagal! Username atau password salah.');
                    window.location.href='login.php';
                  </script>";
        }
    } else {
        die("Error mengambil hasil: " . mysqli_error($conn));
    }
    
    mysqli_stmt_close($stmt);
} else {
    header("Location: login.php");
    exit();
}

mysqli_close($conn);
?>