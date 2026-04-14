<?php
require_once __DIR__ . '/../../config/env_parser.php';
require_once __DIR__ . '/../../config/database.php';
$page_title = 'Kelola Anggota - Perpustakaan Hafidz';
require_once __DIR__ . '/../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil data anggota
$query = mysqli_query($conn, "SELECT * FROM anggota ORDER BY id_anggota DESC");
?>

<nav class="navbar" style="background:linear-gradient(90deg, #2c3e50, #000);">
    <a href="dashboard.php" class="navbar-brand"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
    <div class="nav-links">
        <span>Admin Panel</span>
        <a href="../auth/logout.php" style="background:#e74c3c;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</nav>

<div class="dashboard-content">
    <div class="glass-panel">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
            <h2><i class="fas fa-users"></i> Daftar Anggota</h2>
            <button onclick="document.getElementById('modalAnggota').style.display='block'" class="btn-submit" style="width:auto; padding:10px 25px;">
                <i class="fas fa-plus"></i> Tambah Anggota
            </button>
        </div>

        <?php if(mysqli_num_rows($query) > 0): ?>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd; text-align:left;">
                    <th style="padding:15px;">Nama</th>
                    <th style="padding:15px;">Alamat</th>
                    <th style="padding:15px;">Telp</th>
                    <th style="padding:15px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($agt = mysqli_fetch_assoc($query)): ?>
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:15px;"><?= htmlspecialchars($agt['nama']) ?></td>
                    <td style="padding:15px;"><?= htmlspecialchars($agt['alamat']) ?></td>
                    <td style="padding:15px;"><?= htmlspecialchars($agt['telp']) ?></td>
                    <td style="padding:15px;">
                        <a href="hapus_anggota.php?id=<?= $agt['id_anggota'] ?>" onclick="return confirm('Yakin ingin menghapus?')" style="color:var(--danger);"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-center">Belum ada data anggota.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Tambah Anggota -->
<div id="modalAnggota" style="display:none; position:fixed; z-index:100; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); backdrop-filter:blur(5px);">
    <div class="auth-card" style="margin: 5% auto; max-width:500px;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h3>Tambah Anggota Baru</h3>
            <span onclick="document.getElementById('modalAnggota').style.display='none'" style="cursor:pointer; font-size:24px;">&times;</span>
        </div>
        <form action="../../actions/admin_process.php" method="POST" style="margin-top:20px;">
            <input type="hidden" name="action" value="tambah_anggota">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" required>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" style="width:100%; border:2px solid #e1e1e1; border-radius:15px; padding:15px;" required></textarea>
            </div>
            <div class="form-group">
                <label>No. Telp</label>
                <input type="text" name="telp" required>
            </div>
            <button type="submit" class="btn-submit">Simpan Anggota</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
