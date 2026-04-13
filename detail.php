<?php
include 'koneksi.php';

// Pastikan ID tersedia
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM siswa WHERE id = '$id'");
    $data = mysqli_fetch_array($query);
    
    // Jika data tidak ditemukan
    if(!$data) {
        echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa - Modern Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --gradient-5: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gradient-5);
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Background animasi dengan partikel */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .bg-animation span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 6s infinite;
            pointer-events: none;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-100px) rotate(180deg); opacity: 0.8; }
        }

        .container {
            width: 100%;
            max-width: 500px;
            position: relative;
            z-index: 1;
            animation: containerAppear 1s ease-out;
        }

        @keyframes containerAppear {
            from { opacity: 0; transform: scale(0.9) translateY(-50px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.3);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(90deg, #00d2ff 0%, #3a47d5 100%);
        }

        .profile-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #00d2ff, #3a47d5);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 30px;
            color: white;
            font-size: 40px;
            box-shadow: 0 15px 30px rgba(58, 71, 213, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 15px 30px rgba(58, 71, 213, 0.4); }
            50% { transform: scale(1.05); box-shadow: 0 20px 40px rgba(58, 71, 213, 0.6); }
        }

        .detail-info {
            margin-bottom: 35px;
            text-align: left;
            background: rgba(248, 249, 250, 0.5);
            padding: 25px;
            border-radius: 20px;
        }

        .info-group {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px dashed rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .info-group:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-group:hover {
            transform: translateX(10px);
        }

        .info-label {
            font-size: 13px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .info-label i {
            margin-right: 8px;
            color: #3a47d5;
            width: 20px;
            text-align: center;
        }

        .info-value {
            font-size: 18px;
            color: #2c3e50;
            font-weight: 600;
            padding-left: 28px;
        }

        .btn-kembali {
            display: inline-flex;
            align-items: center;
            padding: 14px 35px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .btn-kembali i {
            margin-right: 10px;
            transition: transform 0.3s ease;
        }

        .btn-kembali:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        }

        .btn-kembali:hover i {
            transform: translateX(-5px);
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="bg-animation" id="bgAnimation"></div>

    <div class="container">
        <div class="card">
            <div class="profile-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            
            <h2 style="margin-bottom: 25px; color: #2c3e50; font-weight: 700;">Detail Siswa</h2>
            
            <div class="detail-info">
                <div class="info-group">
                    <div class="info-label"><i class="fas fa-id-badge"></i> ID Siswa</div>
                    <div class="info-value">#<?= htmlspecialchars($data['id']) ?></div>
                </div>
                <div class="info-group">
                    <div class="info-label"><i class="fas fa-user"></i> Nama Lengkap</div>
                    <div class="info-value"><?= htmlspecialchars($data['nama']) ?></div>
                </div>
                <div class="info-group">
                    <div class="info-label"><i class="fas fa-chalkboard-teacher"></i> Kelas</div>
                    <div class="info-value"><?= htmlspecialchars($data['kelas']) ?></div>
                </div>
                <!-- Jika Anda memiliki kolom lain di database (misal: alamat, no_hp), Anda bisa menambahkannya di sini -->
                <!--
                <div class="info-group">
                    <div class="info-label"><i class="fas fa-map-marker-alt"></i> Alamat</div>
                    <div class="info-value"><?= htmlspecialchars($data['alamat'] ?? '-') ?></div>
                </div>
                -->
            </div>

            <a href="index.php" class="btn-kembali">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <script>
        // Background animation script
        const bgAnimation = document.getElementById('bgAnimation');
        for (let i = 0; i < 30; i++) {
            const span = document.createElement('span');
            span.style.left = Math.random() * 100 + '%';
            span.style.top = Math.random() * 100 + '%';
            span.style.animationDelay = Math.random() * 5 + 's';
            span.style.animationDuration = Math.random() * 10 + 5 + 's';
            span.style.width = Math.random() * 30 + 10 + 'px';
            span.style.height = span.style.width;
            span.style.background = `linear-gradient(135deg, 
                hsl(${Math.random() * 360}, 100%, 70%), 
                hsl(${Math.random() * 360}, 100%, 50%))`;
            bgAnimation.appendChild(span);
        }
    </script>
</body>
</html>