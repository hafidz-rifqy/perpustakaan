<?php
require_once __DIR__ . '/../../config/env_parser.php';
require_once __DIR__ . '/../../config/database.php';
$page_title = 'Kelola Buku - Perpustakaan Hafidz';
require_once __DIR__ . '/../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil data buku
$query = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku DESC");
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
            <h2><i class="fas fa-book"></i> Daftar Buku</h2>
            <button onclick="document.getElementById('modalBuku').style.display='block'" class="btn-submit" style="width:auto; padding:10px 25px;">
                <i class="fas fa-plus"></i> Tambah Buku
            </button>
        </div>

        <?php if(mysqli_num_rows($query) > 0): ?>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd; text-align:left;">
                    <th style="padding:15px;">Judul</th>
                    <th style="padding:15px;">Penulis</th>
                    <th style="padding:15px;">Penerbit</th>
                    <th style="padding:15px;">Stok</th>
                    <th style="padding:15px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($buku = mysqli_fetch_assoc($query)): ?>
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:15px;"><?= htmlspecialchars($buku['judul']) ?></td>
                    <td style="padding:15px;"><?= htmlspecialchars($buku['penulis']) ?></td>
                    <td style="padding:15px;"><?= htmlspecialchars($buku['penerbit']) ?></td>
                    <td style="padding:15px;"><?= $buku['stok'] ?></td>
                    <td style="padding:15px;">
                        <a href="hapus_buku.php?id=<?= $buku['id_buku'] ?>" onclick="return confirm('Yakin ingin menghapus?')" style="color:var(--danger);"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-center">Belum ada data buku.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Tambah Buku -->
<div id="modalBuku" style="display:none; position:fixed; z-index:100; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); backdrop-filter:blur(5px);">
    <div class="auth-card" style="margin: 5% auto; max-width:500px;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h3>Tambah Buku Baru</h3>
            <span onclick="document.getElementById('modalBuku').style.display='none'" style="cursor:pointer; font-size:24px;">&times;</span>
        </div>
        <form action="../../actions/admin_process.php" method="POST" style="margin-top:20px;">
            <input type="hidden" name="action" value="tambah_buku">
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" name="judul" required>
            </div>
            <div class="form-group">
                <label>Penulis</label>
                <input type="text" name="penulis" required>
            </div>
            <div class="form-group">
                <label>Penerbit</label>
                <input type="text" name="penerbit" required>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" required>
            </div>
            <button type="submit" class="btn-submit">Simpan Buku</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
