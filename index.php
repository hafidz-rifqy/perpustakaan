<?php
include 'koneksi.php';
$query = mysqli_query($conn, "SELECT * FROM siswa");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Modern Dashboard</title>
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Style link Detail */
        table td a[href*="detail"] {
            background: linear-gradient(135deg, #00d2ff, #3a47d5);
            color: white;
            animation: detailGlow 2s infinite;
        }

        @keyframes detailGlow {
            0%, 100% {
                box-shadow: 0 5px 20px rgba(0, 210, 255, 0.4);
            }
            50% {
                box-shadow: 0 5px 30px rgba(58, 71, 213, 0.8);
            }
        }

        table td a[href*="detail"]:hover {
            background: linear-gradient(135deg, #3a47d5, #00d2ff);
            transform: translateY(-5px) rotate(3deg) scale(1.1);
            box-shadow: 0 15px 30px rgba(0, 210, 255, 0.6);
            border-color: white;
        }
        /* Import font Google */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        /* CSS Variables untuk warna-warna menarik */
        :root {
            --primary: #4158D0;
            --secondary: #C850C0;
            --tertiary: #FFCC70;
            --success: #00b09b;
            --warning: #f39c12;
            --danger: #e74c3c;
            --dark: #2c3e50;
            --light: #f8f9fa;
            --gradient-1: linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);
            --gradient-2: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%);
            --gradient-3: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
            --gradient-4: linear-gradient(90deg, #00d2ff 0%, #3a47d5 100%);
            --gradient-5: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Reset dan style dasar dengan efek smooth */
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
            position: relative;
            overflow-x: hidden;
            cursor: none; /* Sembunyikan kursor default */
        }

        /* Custom cursor dengan efek trail */
        .cursor {
            width: 20px;
            height: 20px;
            border: 3px solid white;
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            mix-blend-mode: difference;
            transition: all 0.1s ease;
            transition-property: width, height, border;
            will-change: width, height, transform, border;
            transform: translate(-50%, -50%);
            animation: cursorPulse 2s infinite;
        }

        .cursor-trail {
            width: 8px;
            height: 8px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9998;
            transition: 0.1s;
            will-change: transform;
            box-shadow: 0 0 20px rgba(255,255,255,0.5);
        }

        @keyframes cursorPulse {
            0%, 100% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 1;
            }
            50% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0.5;
            }
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
            0%, 100% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.3;
            }
            50% {
                transform: translateY(-100px) rotate(180deg);
                opacity: 0.8;
            }
        }

        /* Container utama */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            animation: containerAppear 1s ease-out;
        }

        @keyframes containerAppear {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-50px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Header dengan judul */
        .header {
            text-align: center;
            margin-bottom: 40px;
            animation: headerGlow 3s infinite;
        }

        .header h1 {
            color: white;
            font-size: 2.5em;
            font-weight: 700;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
        }

        .header h1::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
            top: 0;
            left: -100%;
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0%, 100% {
                left: -100%;
            }
            50% {
                left: 100%;
            }
        }

        @keyframes headerGlow {
            0%, 100% {
                text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            }
            50% {
                text-shadow: 0 0 20px rgba(255,255,255,0.8);
            }
        }

        /* Style tombol Tambah Data dengan animasi lebih menarik */
        .btn-tambah {
            display: inline-block;
            padding: 16px 40px;
            background: var(--gradient-1);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 35px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            letter-spacing: 1px;
            animation: buttonPulse 2s infinite;
        }

        @keyframes buttonPulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            }
        }

        .btn-tambah i {
            margin-right: 12px;
            font-size: 20px;
            transition: transform 0.5s ease;
            display: inline-block;
        }

        .btn-tambah:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 30px 50px rgba(0,0,0,0.4);
            animation: none;
        }

        .btn-tambah:hover i {
            transform: rotate(360deg) scale(1.2);
        }

        .btn-tambah::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-tambah:hover::before {
            width: 300px;
            height: 300px;
        }

        /* Style tabel dengan efek glassmorphism */
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
            animation: tableAppear 1s ease-out, tableFloat 6s infinite ease-in-out;
            transform-origin: center;
            border: 1px solid rgba(255,255,255,0.3);
        }

        @keyframes tableAppear {
            0% {
                opacity: 0;
                transform: perspective(1000px) rotateX(-20deg) translateY(50px);
            }
            100% {
                opacity: 1;
                transform: perspective(1000px) rotateX(0) translateY(0);
            }
        }

        @keyframes tableFloat {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-10px) rotate(0.5deg);
            }
        }

        /* Style header tabel dengan gradien dinamis */
        table th {
            background: var(--gradient-4);
            color: white;
            font-weight: 600;
            padding: 20px 15px;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            overflow: hidden;
            border: none;
            animation: headerWave 10s infinite linear;
        }

        @keyframes headerWave {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        table th::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: rgba(255,255,255,0.2);
            transform: rotate(25deg);
            animation: headerShine 8s infinite;
        }

        @keyframes headerShine {
            0%, 100% {
                left: -60%;
            }
            20% {
                left: 100%;
            }
        }

        /* Style sel tabel dengan efek hover */
        table td {
            padding: 18px 15px;
            border: none;
            font-size: 16px;
            color: #333;
            background: transparent;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        /* Efek hover pada baris dengan animasi kompleks */
        table tr {
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
            animation: rowAppear 0.5s ease-out;
            animation-fill-mode: both;
        }

        table tr:nth-child(1) { animation-delay: 0.1s; }
        table tr:nth-child(2) { animation-delay: 0.2s; }
        table tr:nth-child(3) { animation-delay: 0.3s; }
        table tr:nth-child(4) { animation-delay: 0.4s; }
        table tr:nth-child(5) { animation-delay: 0.5s; }
        table tr:nth-child(6) { animation-delay: 0.6s; }
        table tr:nth-child(7) { animation-delay: 0.7s; }
        table tr:nth-child(8) { animation-delay: 0.8s; }
        table tr:nth-child(9) { animation-delay: 0.9s; }
        table tr:nth-child(10) { animation-delay: 1s; }

        @keyframes rowAppear {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Efek glow dan partikel saat hover */
        table tr::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.7s ease;
            pointer-events: none;
            z-index: 1;
        }

        table tr:hover::before {
            left: 100%;
        }

        table tr:hover {
            background: var(--gradient-3);
            transform: scale(1.03) translateX(10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            z-index: 10;
            animation: rowGlow 0.5s infinite alternate;
        }

        @keyframes rowGlow {
            from {
                box-shadow: 0 15px 40px rgba(65, 88, 208, 0.3);
            }
            to {
                box-shadow: 0 25px 50px rgba(200, 80, 192, 0.5);
            }
        }

        table tr:hover td {
            color: var(--dark);
            font-weight: 600;
            transform: scale(1.02);
        }

        /* Efek khusus untuk sel individual */
        table td:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.05) rotate(0.5deg);
            transition: all 0.3s ease;
            z-index: 20;
        }

        /* Style untuk link aksi dengan animasi 3D */
        table td a {
            display: inline-block;
            padding: 10px 25px;
            margin: 0 5px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: 2px solid transparent;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Style link Edit */
        table td a[href*="edit"] {
            background: linear-gradient(135deg, #4158D0, #C850C0);
            color: white;
            animation: editGlow 2s infinite;
        }

        @keyframes editGlow {
            0%, 100% {
                box-shadow: 0 5px 20px rgba(65, 88, 208, 0.4);
            }
            50% {
                box-shadow: 0 5px 30px rgba(200, 80, 192, 0.8);
            }
        }

        table td a[href*="edit"]:hover {
            background: linear-gradient(135deg, #C850C0, #4158D0);
            transform: translateY(-5px) rotate(5deg) scale(1.1);
            box-shadow: 0 15px 30px rgba(65, 88, 208, 0.6);
            border-color: white;
        }

        /* Style link Hapus */
        table td a[href*="hapus"] {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            animation: hapusGlow 2s infinite;
        }

        @keyframes hapusGlow {
            0%, 100% {
                box-shadow: 0 5px 20px rgba(231, 76, 60, 0.4);
            }
            50% {
                box-shadow: 0 5px 30px rgba(192, 57, 43, 0.8);
            }
        }

        table td a[href*="hapus"]:hover {
            background: linear-gradient(135deg, #c0392b, #e74c3c);
            transform: translateY(-5px) rotate(-5deg) scale(1.1);
            box-shadow: 0 15px 30px rgba(231, 76, 60, 0.6);
            border-color: white;
        }

        /* Efek ripple pada link */
        table td a::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255,255,255,0.8);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        table td a:active::after {
            animation: ripple 0.6s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.8;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }

        /* Efek zebra stripe dengan animasi */
        table tr:nth-child(even) {
            background: rgba(248, 249, 250, 0.8);
            animation: stripePulse 5s infinite;
        }

        @keyframes stripePulse {
            0%, 100% {
                background: rgba(248, 249, 250, 0.8);
            }
            50% {
                background: rgba(255, 255, 255, 0.95);
            }
        }

        /* Responsive design */
        @media screen and (max-width: 768px) {
            .header h1 {
                font-size: 2em;
            }
            
            table {
                font-size: 14px;
            }
            
            table td, table th {
                padding: 15px 10px;
            }
            
            table td a {
                padding: 8px 15px;
                font-size: 12px;
                margin: 2px;
            }
            
            .btn-tambah {
                padding: 14px 30px;
                font-size: 16px;
            }
            
            .cursor, .cursor-trail {
                display: none; /* Sembunyikan custom cursor di mobile */
            }
            
            body {
                cursor: auto;
            }
        }

        /* Animasi loading untuk konten */
        .loading-spinner {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            z-index: 10000;
        }

        @keyframes spin {
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Efek particle saat klik */
        .click-particle {
            position: fixed;
            width: 10px;
            height: 10px;
            background: white;
            border-radius: 50%;
            pointer-events: none;
            z-index: 10001;
            animation: particleExplode 0.5s ease-out forwards;
        }

        @keyframes particleExplode {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(3);
                opacity: 0;
            }
        }

        /* Tooltip modern */
        [data-tooltip] {
            position: relative;
        }

        [data-tooltip]:before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(-10px);
            padding: 8px 15px;
            background: var(--gradient-1);
            color: white;
            border-radius: 20px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            pointer-events: none;
            z-index: 1000;
        }

        [data-tooltip]:hover:before {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-15px);
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="bg-animation" id="bgAnimation"></div>
    
    <!-- Custom Cursor -->
    <div class="cursor" id="cursor"></div>
    <div class="cursor-trail" id="cursorTrail"></div>
    
    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner"></div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📚 DATA SISWA</h1>
        </div>

        <!-- Tombol Tambah Data dengan tooltip -->
        <a href="tambah.php" class="btn-tambah" data-tooltip="Klik untuk menambah data baru">
            <i class="fas fa-plus-circle"></i> Tambah Data
        </a>

        <!-- Tabel Data Siswa -->
        <table>
            <thead>
                <tr>
                    <th>👤 Nama</th>
                    <th>🏫 Kelas</th>
                    <th>⚡ Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($data = mysqli_fetch_array($query)): ?>
                <tr>
                    <td><?= htmlspecialchars($data['nama']) ?></td>
                    <td><?= htmlspecialchars($data['kelas']) ?></td>
                    <td>
                        <a href="detail.php?id=<?= $data['id'] ?>" data-tooltip="Lihat detail siswa">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="edit.php?id=<?= $data['id'] ?>" data-tooltip="Edit data siswa">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="hapus.php?id=<?= $data['id'] ?>" 
                           onclick="return confirm('Yakin ingin hapus?')"
                           data-tooltip="Hapus data siswa">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Custom cursor dengan efek trail
        const cursor = document.getElementById('cursor');
        const cursorTrail = document.getElementById('cursorTrail');
        
        // Array untuk menyimpan posisi trail
        let trailPositions = [];
        const trailLength = 10;
        
        document.addEventListener('mousemove', function(e) {
            // Update posisi cursor utama
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
            
            // Simpan posisi untuk trail
            trailPositions.push({x: e.clientX, y: e.clientY});
            
            // Batasi panjang trail
            if (trailPositions.length > trailLength) {
                trailPositions.shift();
            }
            
            // Update posisi trail
            if (trailPositions.length > 0) {
                const lastPos = trailPositions[trailPositions.length - 1];
                cursorTrail.style.left = lastPos.x + 'px';
                cursorTrail.style.top = lastPos.y + 'px';
            }
        });

        // Efek hover pada link mengubah ukuran cursor
        document.querySelectorAll('a, button, [data-tooltip]').forEach(element => {
            element.addEventListener('mouseenter', () => {
                cursor.style.width = '40px';
                cursor.style.height = '40px';
                cursor.style.borderColor = '#FFCC70';
                cursor.style.background = 'rgba(255,204,112,0.1)';
            });
            
            element.addEventListener('mouseleave', () => {
                cursor.style.width = '20px';
                cursor.style.height = '20px';
                cursor.style.borderColor = 'white';
                cursor.style.background = 'transparent';
            });
        });

        // Efek particle saat klik
        document.addEventListener('click', function(e) {
            for (let i = 0; i < 5; i++) {
                const particle = document.createElement('div');
                particle.className = 'click-particle';
                particle.style.left = e.clientX + 'px';
                particle.style.top = e.clientY + 'px';
                particle.style.background = `hsl(${Math.random() * 360}, 100%, 50%)`;
                document.body.appendChild(particle);
                
                setTimeout(() => {
                    particle.remove();
                }, 500);
            }
        });

        // Background animation dengan partikel
        const bgAnimation = document.getElementById('bgAnimation');
        for (let i = 0; i < 50; i++) {
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

        // Loading spinner effect
        window.addEventListener('load', function() {
            const spinner = document.getElementById('loadingSpinner');
            spinner.style.display = 'none';
        });
        // Smooth scroll untuk semua link
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Efek parallax pada background
        document.addEventListener('mousemove', function(e) {
            const moveX = (e.clientX - window.innerWidth / 2) * 0.01;
            const moveY = (e.clientY - window.innerHeight / 2) * 0.01;
            
            document.querySelector('.bg-animation').style.transform = 
                `translate(${moveX}px, ${moveY}px)`;
        });

        // Konfirmasi hapus dengan efek
        document.querySelectorAll('a[href*="hapus"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (!confirm('⚠️ Yakin ingin menghapus data ini? Aksi ini tidak dapat dibatalkan!')) {
                    e.preventDefault();
                }
            });
        });

        // Efek glow pada baris tabel saat di-scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'rowGlow 1s';
                }
            });
        });

        document.querySelectorAll('table tr').forEach(row => {
            observer.observe(row);
        });
    </script>
</body>
</html>