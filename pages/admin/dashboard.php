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
        <h2 style="margin-bottom:20px;"><i class="fas fa-cogs"></i> Sistem Manajemen</h2>
        <p style="margin-bottom:30px;">Overview data perpustakaan.</p>
        
        <div style="display:flex; gap:20px;">
            <div style="background:linear-gradient(135deg, #00d2ff, #3a47d5); padding:30px; border-radius:20px; width:250px; color:white; box-shadow:0 10px 20px rgba(0,0,0,0.2);">
                <i class="fas fa-users" style="font-size:40px; margin-bottom:15px;"></i>
                <h3>Total Anggota</h3>
                <h1 style="font-size:48px;"><?= $total_users ?></h1>
            </div>
            
            <div style="background:linear-gradient(135deg, #f2994a, #f2c94c); padding:30px; border-radius:20px; width:250px; color:white; box-shadow:0 10px 20px rgba(0,0,0,0.2);">
                <i class="fas fa-book" style="font-size:40px; margin-bottom:15px;"></i>
                <h3>Statistik Buku</h3>
                <h1 style="font-size:48px;">-</h1>
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
