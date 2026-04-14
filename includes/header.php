<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
// Set initial variables so there are no undefined notices
$page_title = $page_title ?? 'Perpustakaan Hafidz';
$app_url = $_ENV['APP_URL'] ?? 'http://localhost/hafiddev';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Global CSS -->
    <link rel="stylesheet" href="<?= $app_url ?>/public/assets/css/style.css">
    <style>
        /* Optional inline tweaks */
    </style>
</head>
<body>
    <div class="bg-animation" id="bgAnimation"></div>
    <div class="cursor" id="cursor"></div>
    <div class="cursor-trail" id="cursorTrail"></div>
