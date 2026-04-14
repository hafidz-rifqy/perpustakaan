<?php
require_once __DIR__ . '/../../config/env_parser.php';
require_once __DIR__ . '/../../config/database.php';
$page_title = 'Admin Dashboard - Perpustakaan Hafidz';
require_once __DIR__ . '/../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Fetch basic stats
$q = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='user'");
$res = $q->fetch_assoc();
$total_users = $res['total'];
?>

<nav class="navbar" style="background:linear-gradient(90deg, #2c3e50, #000);">
    <a href="#" class="navbar-brand"><i class="fas fa-user-shield"></i> Admin Panel</a>
    <div class="nav-links">
        <span>Owner Admin</span>
        <a href="../auth/logout.php" style="background:#e74c3c;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</nav>

<div class="dashboard-content">
    <div class="glass-panel">
        <h2 style="margin-bottom:20px;"><i class="fas fa-cogs"></i> Sistem Manajemen Perpustakaan</h2>
        <p style="margin-bottom:30px;">Selamat datang di panel kontrol. Silakan pilih kategori untuk dikelola.</p>
        
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:25px;">
            <!-- Kelola Buku -->
            <div style="background:linear-gradient(135deg, #4158D0, #C850C0); padding:30px; border-radius:25px; color:white; box-shadow:0 15px 35px rgba(65, 88, 208, 0.4); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:20px;">
                    <i class="fas fa-book" style="font-size:40px; opacity:0.8;"></i>
                    <a href="kelola_buku.php" style="color:white; background:rgba(255,255,255,0.2); padding:10px 15px; border-radius:12px; text-decoration:none; font-size:14px;">Lihat <i class="fas fa-arrow-right"></i></a>
                </div>
                <h3>Kelola Buku</h3>
                <p style="margin:10px 0 20px; font-size:14px; opacity:0.9;">Koleksi buku perpustakaan.</p>
                <a href="kelola_buku.php" style="display:block; text-align:center; background:white; color:#4158D0; padding:12px; border-radius:15px; text-decoration:none; font-weight:600;"><i class="fas fa-plus-circle"></i> Tambah Buku</a>
            </div>

            <!-- Kelola Anggota -->
            <div style="background:linear-gradient(135deg, #00b09b, #96c93d); padding:30px; border-radius:25px; color:white; box-shadow:0 15px 35px rgba(0, 176, 155, 0.4); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:20px;">
                    <i class="fas fa-users" style="font-size:40px; opacity:0.8;"></i>
                    <a href="kelola_anggota.php" style="color:white; background:rgba(255,255,255,0.2); padding:10px 15px; border-radius:12px; text-decoration:none; font-size:14px;">Lihat <i class="fas fa-arrow-right"></i></a>
                </div>
                <h3>Kelola Anggota</h3>
                <p style="margin:10px 0 20px; font-size:14px; opacity:0.9;">Manajemen data anggota.</p>
                <a href="kelola_anggota.php" style="display:block; text-align:center; background:white; color:#00b09b; padding:12px; border-radius:15px; text-decoration:none; font-weight:600;"><i class="fas fa-plus-circle"></i> Tambah Anggota</a>
            </div>

            <!-- Kelola Peminjaman -->
            <div style="background:linear-gradient(135deg, #FF512F, #DD2476); padding:30px; border-radius:25px; color:white; box-shadow:0 15px 35px rgba(221, 36, 118, 0.4); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:20px;">
                    <i class="fas fa-exchange-alt" style="font-size:40px; opacity:0.8;"></i>
                    <a href="kelola_peminjaman.php" style="color:white; background:rgba(255,255,255,0.2); padding:10px 15px; border-radius:12px; text-decoration:none; font-size:14px;">Lihat <i class="fas fa-arrow-right"></i></a>
                </div>
                <h3>Peminjaman</h3>
                <p style="margin:10px 0 20px; font-size:14px; opacity:0.9;">Transaksi pinjam buku.</p>
                <a href="kelola_peminjaman.php" style="display:block; text-align:center; background:white; color:#DD2476; padding:12px; border-radius:15px; text-decoration:none; font-weight:600;"><i class="fas fa-plus-circle"></i> Pinjam Buku</a>
            </div>
        </div>
        
        <br><br>
        <h3>Data Anggota Terbaru</h3>
        <table style="width:100%; text-align:left; border-collapse:collapse; margin-top:15px;">
            <tr style="border-bottom:2px solid #ddd;">
                <th style="padding:10px;">Nama</th>
                <th style="padding:10px;">Whatsapp</th>
                <th style="padding:10px;">Kelas</th>
                <th style="padding:10px;">Tgl Daftar</th>
            </tr>
            <?php
            $users = $conn->query("SELECT * FROM users WHERE role='user' ORDER BY id DESC LIMIT 5");
            while($u = $users->fetch_assoc()):
            ?>
            <tr style="border-bottom:1px solid #eee;">
                <td style="padding:10px;"><?= htmlspecialchars($u['nama']) ?></td>
                <td style="padding:10px;"><?= htmlspecialchars($u['whatsapp']) ?></td>
                <td style="padding:10px;"><?= htmlspecialchars($u['kelas']) ?></td>
                <td style="padding:10px;"><?= htmlspecialchars($u['created_at']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
