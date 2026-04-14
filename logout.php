<?php
session_start(); // Mulai session
session_destroy(); // Hapus semua data session

// Alihkan kembali ke halaman login
header("Location: login.php");
?>