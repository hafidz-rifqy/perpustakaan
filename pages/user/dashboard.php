<?php
require_once __DIR__ . '/../../config/env_parser.php';
$page_title = 'User Dashboard - Perpustakaan Hafidz';
require_once __DIR__ . '/../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}
?>

<nav class="navbar">
    <a href="#" class="navbar-brand"><i class="fas fa-book-reader"></i> Perpustakaan Hafidz</a>
    <div class="nav-links">
        <span>Halo, <?= htmlspecialchars($_SESSION['name']) ?>!</span>
        <a href="../auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</nav>

<div class="dashboard-content">
    <div class="glass-panel text-center">
        <img src="<?= $_ENV['APP_URL'] ?>/public/assets/images/logo.png" alt="Logo" style="width:150px; border-radius:20px; margin-bottom: 20px;">
        <h2>Selamat Datang di Dashboard Anggota!</h2>
        <p style="margin-bottom:30px; color:#555;">Ini adalah rancangan antarmuka pengguna Perpustakaan Hafidz dengan fitur sesi OTP.</p>
        
        <div style="display:flex; justify-content:center; gap:20px; flex-wrap:wrap;">
            <!-- Example Cards -->
            <div style="background:white; padding:30px; border-radius:20px; width:250px; box-shadow:0 10px 20px rgba(0,0,0,0.1);">
                <i class="fas fa-book" style="font-size:40px; color:var(--primary); margin-bottom:15px;"></i>
                <h3>Katalog Buku</h3>
                <p>Cari buku favorit</p>
            </div>
            
            <div style="background:white; padding:30px; border-radius:20px; width:250px; box-shadow:0 10px 20px rgba(0,0,0,0.1);">
                <i class="fas fa-history" style="font-size:40px; color:var(--secondary); margin-bottom:15px;"></i>
                <h3>Riwayat Pinjam</h3>
                <p>Buku yang sedang dipinjam</p>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
