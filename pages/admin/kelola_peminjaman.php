<?php
require_once __DIR__ . '/../../config/env_parser.php';
require_once __DIR__ . '/../../config/database.php';
$page_title = 'Kelola Peminjaman - Perpustakaan Hafidz';
require_once __DIR__ . '/../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil data peminjaman dengan join
$sql = "SELECT p.*, b.judul, a.nama 
        FROM peminjaman p 
        LEFT JOIN buku b ON p.id_buku = b.id_buku 
        LEFT JOIN anggota a ON p.id_anggota = a.id_anggota 
        ORDER BY p.id_pinjam DESC";
$query = mysqli_query($conn, $sql);

// Untuk dropdown di modal
$buku_list = mysqli_query($conn, "SELECT id_buku, judul FROM buku WHERE stok > 0");
$anggota_list = mysqli_query($conn, "SELECT id_anggota, nama FROM anggota");
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
            <h2><i class="fas fa-exchange-alt"></i> Transaksi Peminjaman</h2>
            <button onclick="document.getElementById('modalPinjam').style.display='block'" class="btn-submit" style="width:auto; padding:10px 25px;">
                <i class="fas fa-plus"></i> Pinjam Buku
            </button>
        </div>

        <?php if(mysqli_num_rows($query) > 0): ?>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #ddd; text-align:left;">
                    <th style="padding:15px;">Buku</th>
                    <th style="padding:15px;">Peminjam</th>
                    <th style="padding:15px;">Tgl Pinjam</th>
                    <th style="padding:15px;">Tgl Kembali</th>
                    <th style="padding:15px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($pjm = mysqli_fetch_assoc($query)): ?>
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:15px;"><?= htmlspecialchars($pjm['judul'] ?? 'Buku Dihapus') ?></td>
                    <td style="padding:15px;"><?= htmlspecialchars($pjm['nama'] ?? 'Anggota Dihapus') ?></td>
                    <td style="padding:15px;"><?= $pjm['tgl_pinjam'] ?></td>
                    <td style="padding:15px;"><?= $pjm['tgl_kembali'] ?></td>
                    <td style="padding:15px;">
                        <a href="hapus_pinjam.php?id=<?= $pjm['id_pinjam'] ?>" onclick="return confirm('Yakin ingin menghapus?')" style="color:var(--danger);"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-center">Belum ada transaksi peminjaman.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Tambah Peminjaman -->
<div id="modalPinjam" style="display:none; position:fixed; z-index:100; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); backdrop-filter:blur(5px);">
    <div class="auth-card" style="margin: 5% auto; max-width:500px;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h3>Input Peminjaman</h3>
            <span onclick="document.getElementById('modalPinjam').style.display='none'" style="cursor:pointer; font-size:24px;">&times;</span>
        </div>
        <form action="../../actions/admin_process.php" method="POST" style="margin-top:20px;">
            <input type="hidden" name="action" value="tambah_pinjam">
            <div class="form-group">
                <label>Pilih Buku</label>
                <select name="id_buku" style="width:100%; border:2px solid #e1e1e1; border-radius:15px; padding:15px;" required>
                    <?php while($b = mysqli_fetch_assoc($buku_list)): ?>
                        <option value="<?= $b['id_buku'] ?>"><?= htmlspecialchars($b['judul']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Pilih Anggota</label>
                <select name="id_anggota" style="width:100%; border:2px solid #e1e1e1; border-radius:15px; padding:15px;" required>
                    <?php while($a = mysqli_fetch_assoc($anggota_list)): ?>
                        <option value="<?= $a['id_anggota'] ?>"><?= htmlspecialchars($a['nama']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tgl_pinjam" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label>Tanggal Kembali</label>
                <input type="date" name="tgl_kembali" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" required>
            </div>
            <button type="submit" class="btn-submit">Simpan Transaksi</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
