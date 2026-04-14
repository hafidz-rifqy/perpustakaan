<?php
session_start();
require_once __DIR__ . '/config/env_parser.php';

// Gateway Redirector
if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header("Location: " . $_ENV['APP_URL'] . "/pages/admin/dashboard.php");
    } else {
        header("Location: " . $_ENV['APP_URL'] . "/pages/user/dashboard.php");
    }
} else {
    header("Location: " . $_ENV['APP_URL'] . "/pages/auth/login.php");
}
exit();
?>