<?php
session_start();
session_destroy();
require_once __DIR__ . '/../../config/env_parser.php';
header("Location: " . ($_ENV['APP_URL'] ?? 'http://localhost/hafiddev') . "/pages/auth/login.php");
exit;
?>
