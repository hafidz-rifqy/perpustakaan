<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/fonnte.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$app_url = $_ENV['APP_URL'] ?? 'http://localhost/hafiddev';

if ($action === 'login') {
    $username_wa = trim($_POST['username_wa']);
    $password = $_POST['password'];

    // Check if it's admin login via .env
    $admin_user = trim($_ENV['ADMIN_USERNAME']);
    $admin_pass = trim($_ENV['ADMIN_PASS']);

    if ($username_wa === $admin_user && $password === $admin_pass) {
        $_SESSION['user_id'] = 0;
        $_SESSION['role'] = 'admin';
        $_SESSION['name'] = 'System Administrator';
        $_SESSION['whatsapp'] = 'admin';
        header("Location: $app_url/pages/admin/dashboard.php");
        exit;
    }

    // Normal User Login
    $stmt = $conn->prepare("SELECT id, nama, password, role FROM users WHERE whatsapp = ?");
    $stmt->bind_param("s", $username_wa);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['name'] = $row['nama'];
            $_SESSION['whatsapp'] = $username_wa;
            header("Location: $app_url/pages/user/dashboard.php");
            exit;
        }
    }

    $_SESSION['error'] = "Whatsapp / Username atau Password salah.";
    header("Location: $app_url/pages/auth/login.php");
    exit;

} elseif ($action === 'register') {
    $nama = trim($_POST['nama']);
    $kelas = trim($_POST['kelas']);
    $whatsapp = trim($_POST['whatsapp']);
    $password = $_POST['password'];

    // Ensure whatsapp doesn't exist
    $stmt = $conn->prepare("SELECT id FROM users WHERE whatsapp = ?");
    $stmt->bind_param("s", $whatsapp);
    $stmt->execute();
    if($stmt->get_result()->num_rows > 0){
        $_SESSION['error'] = "Nomor Whatsapp sudah terdaftar.";
        header("Location: $app_url/pages/auth/register.php");
        exit;
    }

    $otp = sprintf("%04d", mt_rand(1000, 9999));
    $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    $stmt2 = $conn->prepare("INSERT INTO otps (whatsapp, otp_code, expires_at) VALUES (?, ?, ?)");
    $stmt2->bind_param("sss", $whatsapp, $otp, $expires);
    $stmt2->execute();

    // Send via fonnte
    sendFonnteOTP($whatsapp, $otp);

    // Save partial data into session
    $_SESSION['temp_reg'] = [
        'nama' => $nama,
        'kelas' => $kelas,
        'whatsapp' => $whatsapp,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ];

    $_SESSION['success'] = "Kode OTP telah dikirim ke WA Anda.";
    header("Location: $app_url/pages/auth/verify_otp.php?type=register");
    exit;

} elseif ($action === 'verify_otp') {
    $otp_input = trim($_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4']);
    $type = $_GET['type'] ?? 'register';

    if($type === 'register' && isset($_SESSION['temp_reg'])){
        $whatsapp = $_SESSION['temp_reg']['whatsapp'];
        
        $stmt = $conn->prepare("SELECT id, expires_at FROM otps WHERE whatsapp = ? AND otp_code = ? AND is_used = 0 ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("ss", $whatsapp, $otp_input);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if($row = $res->fetch_assoc()){
            if(strtotime($row['expires_at']) < time()){
                $_SESSION['error'] = "Kode OTP sudah kadaluarsa.";
                header("Location: $app_url/pages/auth/verify_otp.php?type=register");
                exit;
            }
            
            // Mark used
            $conn->query("UPDATE otps SET is_used = 1 WHERE id = ".$row['id']);
            
            // Create User
            $temp = $_SESSION['temp_reg'];
            $ins = $conn->prepare("INSERT INTO users (nama, whatsapp, password, kelas) VALUES (?, ?, ?, ?)");
            $ins->bind_param("ssss", $temp['nama'], $temp['whatsapp'], $temp['password'], $temp['kelas']);
            if($ins->execute()){
                // Auto login
                $_SESSION['user_id'] = $ins->insert_id;
                $_SESSION['role'] = 'user';
                $_SESSION['name'] = $temp['nama'];
                $_SESSION['whatsapp'] = $temp['whatsapp'];
                unset($_SESSION['temp_reg']);
                header("Location: $app_url/pages/user/dashboard.php");
                exit;
            } else {
                $_SESSION['error'] = "Terjadi kesalahan sistem, gagal daftar.";
                header("Location: $app_url/pages/auth/register.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Kode OTP tidak valid atau kadaluarsa.";
            header("Location: $app_url/pages/auth/verify_otp.php?type=register");
            exit;
        }
    } elseif ($type === 'forgot' && isset($_SESSION['reset_wa_temp'])) {
        $whatsapp = $_SESSION['reset_wa_temp'];
        
        $stmt = $conn->prepare("SELECT id, expires_at FROM otps WHERE whatsapp = ? AND otp_code = ? AND is_used = 0 ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("ss", $whatsapp, $otp_input);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if($row = $res->fetch_assoc()){
            if(strtotime($row['expires_at']) < time()){
                $_SESSION['error'] = "Kode OTP sudah kadaluarsa.";
                header("Location: $app_url/pages/auth/verify_otp.php?type=forgot");
                exit;
            }
            
            // Mark used
            $conn->query("UPDATE otps SET is_used = 1 WHERE id = ".$row['id']);
            
            $_SESSION['reset_whatsapp'] = $whatsapp;
            unset($_SESSION['reset_wa_temp']);
            header("Location: $app_url/pages/auth/reset_password.php");
            exit;
        } else {
            $_SESSION['error'] = "Kode OTP tidak valid.";
            header("Location: $app_url/pages/auth/verify_otp.php?type=forgot");
            exit;
        }
    }

} elseif ($action === 'forgot_password') {
    $whatsapp = trim($_POST['whatsapp']);
    
    // Ensure whatsapp exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE whatsapp = ?");
    $stmt->bind_param("s", $whatsapp);
    $stmt->execute();
    if($stmt->get_result()->num_rows == 0){
        $_SESSION['error'] = "Nomor Whatsapp tidak terdaftar.";
        header("Location: $app_url/pages/auth/forgot_password.php");
        exit;
    }

    $otp = sprintf("%04d", mt_rand(1000, 9999));
    $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    $stmt2 = $conn->prepare("INSERT INTO otps (whatsapp, otp_code, expires_at) VALUES (?, ?, ?)");
    $stmt2->bind_param("sss", $whatsapp, $otp, $expires);
    $stmt2->execute();

    // Send via fonnte
    sendFonnteOTP($whatsapp, $otp);

    // Save temp session
    $_SESSION['reset_wa_temp'] = $whatsapp;

    $_SESSION['success'] = "Kode OTP reset password telah dikirim ke WA Anda.";
    header("Location: $app_url/pages/auth/verify_otp.php?type=forgot");
    exit;

} elseif ($action === 'reset_password') {
    if (!isset($_SESSION['reset_whatsapp'])) {
        header("Location: $app_url/pages/auth/login.php");
        exit;
    }
    
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $whatsapp = $_SESSION['reset_whatsapp'];
    
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE whatsapp = ?");
    $stmt->bind_param("ss", $password, $whatsapp);
    $stmt->execute();
    
    unset($_SESSION['reset_whatsapp']);
    $_SESSION['success'] = "Password berhasil diubah. Silahkan login.";
    header("Location: $app_url/pages/auth/login.php");
    exit;

} elseif ($action === 'logout') {
    session_destroy();
    header("Location: $app_url/pages/auth/login.php");
    exit;
} else {
    header("Location: $app_url/index.php");
}
?>
