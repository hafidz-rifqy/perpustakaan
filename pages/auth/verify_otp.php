<?php
require_once __DIR__ . '/../../config/env_parser.php';
$page_title = 'Verifikasi OTP - Perpustakaan Hafidz';
require_once __DIR__ . '/../../includes/header.php';
$type = $_GET['type'] ?? 'register';
?>
<div class="container d-flex">
    <div class="auth-card" style="text-align: center;">
        <i class="fas fa-envelope-open-text" style="font-size: 50px; color: var(--tertiary); margin-bottom:20px;"></i>
        <h2>Verifikasi OTP</h2>
        <p>Masukkan 4 digit kode OTP yang dikirim ke nomor WhatsApp Anda.</p>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="<?= $_ENV['APP_URL'] ?>/actions/auth_process.php?type=<?= $type ?>" method="POST" id="otpForm">
            <input type="hidden" name="action" value="verify_otp">
            
            <div class="otp-container">
                <input type="text" name="otp1" maxlength="1" class="otp-box" required>
                <input type="text" name="otp2" maxlength="1" class="otp-box" required>
                <input type="text" name="otp3" maxlength="1" class="otp-box" required>
                <input type="text" name="otp4" maxlength="1" class="otp-box" required>
            </div>

            <button type="submit" class="btn-submit" style="margin-top:20px;">
                <i class="fas fa-check-circle"></i> <span>Verifikasi</span>
            </button>
        </form>
    </div>
</div>
<script>
    const inputs = document.querySelectorAll('.otp-box');
    inputs.forEach((input, index) => {
        input.addEventListener('keyup', (e) => {
            if(e.target.value.length > 0 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
            if(e.key === "Backspace" && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });
</script>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
