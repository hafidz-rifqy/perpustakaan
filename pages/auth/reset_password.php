<?php
require_once __DIR__ . '/../../config/env_parser.php';
$page_title = 'Reset Password - Perpustakaan Hafidz';
require_once __DIR__ . '/../../includes/header.php';
if (!isset($_SESSION['reset_whatsapp'])) {
    header("Location: login.php");
    exit;
}
?>
<div class="container d-flex">
    <div class="auth-card">
        <div class="text-center">
            <h2>Reset Password</h2>
            <p>Masukkan kata sandi baru Anda.</p>
        </div>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="<?= $_ENV['APP_URL'] ?>/actions/auth_process.php" method="POST">
            <input type="hidden" name="action" value="reset_password">
            
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password Baru</label>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required minlength="6">
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> <span>Simpan Password Baru</span>
            </button>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
