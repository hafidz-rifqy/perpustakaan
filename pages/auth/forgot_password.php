<?php
require_once __DIR__ . '/../../config/env_parser.php';
$page_title = 'Lupa Password - Perpustakaan Hafidz';
require_once __DIR__ . '/../../includes/header.php';
?>
<div class="container d-flex">
    <div class="auth-card">
        <div class="text-center">
            <h2>Lupa Password</h2>
            <p>Masukkan Nomor Whatsapp Anda untuk reset sandi.</p>
        </div>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="<?= $_ENV['APP_URL'] ?>/actions/auth_process.php" method="POST">
            <input type="hidden" name="action" value="forgot_password">
            
            <div class="form-group">
                <label><i class="fab fa-whatsapp"></i> Nomor Whatsapp yang terdaftar</label>
                <input type="text" name="whatsapp" placeholder="Misal: 08123xxxx" required>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> <span>Kirim OTP Reset</span>
            </button>
            <div class="text-center" style="margin-top: 20px;">
                <p>Ingat password? <a href="login.php" class="auth-link">Login disini</a></p>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
