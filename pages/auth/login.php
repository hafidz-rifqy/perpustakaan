<?php
require_once __DIR__ . '/../../config/env_parser.php';
$page_title = 'Login - Perpustakaan Hafidz';
require_once __DIR__ . '/../../includes/header.php';
?>
<div class="container d-flex">
    <div class="auth-card">
        <div class="text-center">
            <img src="<?= $_ENV['APP_URL'] ?>/public/assets/images/logo.png" alt="Logo" class="auth-logo">
            <h2>Welcome Back</h2>
            <p>Login to Perpustakaan Hafidz</p>
        </div>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="<?= $_ENV['APP_URL'] ?>/actions/auth_process.php" method="POST">
            <input type="hidden" name="action" value="login">
            
            <div class="form-group">
                <label><i class="fas fa-phone"></i> Whatsapp / Username</label>
                <input type="text" name="username_wa" placeholder="No WA atau Username Admin" required>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>
            
            <div class="text-right" style="margin-bottom:20px;">
                <a href="forgot_password.php" class="auth-link">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-sign-in-alt"></i> <span>Login Sekarang</span>
            </button>
            <div class="text-center" style="margin-top: 20px;">
                <p>Belum punya akun? <a href="register.php" class="auth-link">Daftar disini</a></p>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
