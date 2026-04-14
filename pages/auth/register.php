<?php
require_once __DIR__ . '/../../config/env_parser.php';
$page_title = 'Register - Perpustakaan Hafidz';
require_once __DIR__ . '/../../includes/header.php';
?>
<div class="container d-flex">
    <div class="auth-card">
        <div class="text-center">
            <h2>Buat Akun Baru</h2>
            <p>Registrasi Anggota Perpustakaan</p>
        </div>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="<?= $_ENV['APP_URL'] ?>/actions/auth_process.php" method="POST">
            <input type="hidden" name="action" value="register">
            
            <div class="form-group">
                <label><i class="fas fa-user"></i> Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Sesuai KTP/Kartu Pelajar" required minlength="3">
            </div>

            <div class="form-group">
                <label><i class="fas fa-school"></i> Kelas / Jabatan</label>
                <input type="text" name="kelas" placeholder="Misal: X IPA 1 atau Umum" required>
            </div>
            
            <div class="form-group">
                <label><i class="fab fa-whatsapp"></i> Nomor Whatsapp (Aktif)</label>
                <input type="text" name="whatsapp" placeholder="Misal: 08123xxxx" required>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password</label>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required minlength="6">
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-user-plus"></i> <span>Daftar & Kirim OTP</span>
            </button>
            <div class="text-center" style="margin-top: 20px;">
                <p>Sudah punya akun? <a href="login.php" class="auth-link">Login disini</a></p>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
