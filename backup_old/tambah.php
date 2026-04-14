<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa - Modern Form</title>
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
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
            max-width: 700px;
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

        .header h2 {
            color: white;
            font-size: 2.5em;
            font-weight: 700;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
        }

        .header h2::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
            top: 0;
            left: -100%;
            animation: shine 3s infinite;
        }

        .header h2 i {
            margin-right: 15px;
            animation: iconSpin 5s infinite linear;
        }

        @keyframes iconSpin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
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

        /* Card form dengan efek glassmorphism */
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 50px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
            animation: cardFloat 6s infinite ease-in-out;
            border: 1px solid rgba(255,255,255,0.3);
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent 30%,
                rgba(255,255,255,0.1) 50%,
                transparent 70%
            );
            animation: cardShine 8s infinite;
        }

        @keyframes cardShine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }
            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        @keyframes cardFloat {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-10px) rotate(0.5deg);
            }
        }

        /* Style untuk setiap group form */
        .form-group {
            margin-bottom: 30px;
            position: relative;
            animation: groupAppear 0.5s ease-out;
            animation-fill-mode: both;
        }

        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.4s; }
        .form-group:nth-child(3) { animation-delay: 0.6s; }

        @keyframes groupAppear {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Style label */
        .form-group label {
            display: block;
            margin-bottom: 12px;
            color: var(--dark);
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 1px;
            text-transform: uppercase;
            position: relative;
            padding-left: 25px;
        }

        .form-group label i {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 18px;
            animation: labelIcon 2s infinite;
        }

        @keyframes labelIcon {
            0%, 100% {
                transform: translateY(-50%) scale(1);
            }
            50% {
                transform: translateY(-50%) scale(1.2);
                color: var(--secondary);
            }
        }

        /* Style input field */
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 18px 25px;
            border: 2px solid #e1e1e1;
            border-radius: 20px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            color: var(--dark);
            position: relative;
            z-index: 1;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(65, 88, 208, 0.3);
            transform: translateY(-3px) scale(1.02);
        }

        .form-group input:hover,
        .form-group textarea:hover {
            border-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(200, 80, 192, 0.2);
        }

        /* Style untuk textarea */
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* Efek glow pada input yang aktif */
        .form-group.focused::after {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            background: var(--gradient-1);
            border-radius: 25px;
            z-index: 0;
            animation: glowPulse 2s infinite;
            opacity: 0.3;
        }

        @keyframes glowPulse {
            0%, 100% {
                opacity: 0.3;
                filter: blur(10px);
            }
            50% {
                opacity: 0.6;
                filter: blur(15px);
            }
        }

        /* Style untuk tombol submit */
        .btn-submit {
            background: var(--gradient-1);
            color: white;
            border: none;
            padding: 18px 40px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            width: 100%;
            letter-spacing: 2px;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin-top: 20px;
            animation: buttonPulse 2s infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        @keyframes buttonPulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            }
            50% {
                transform: scale(1.02);
                box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            }
        }

        .btn-submit i {
            font-size: 20px;
            transition: transform 0.5s ease;
            animation: buttonIcon 2s infinite;
        }

        @keyframes buttonIcon {
            0%, 100% {
                transform: translateX(0);
            }
            50% {
                transform: translateX(5px);
            }
        }

        .btn-submit:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 30px 50px rgba(0,0,0,0.4);
            animation: none;
        }

        .btn-submit:hover i {
            transform: translateX(10px) rotate(360deg);
        }

        .btn-submit::before {
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

        .btn-submit:active::before {
            width: 300px;
            height: 300px;
        }

        /* Tombol kembali */
        .btn-back {
            display: inline-block;
            padding: 12px 30px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            margin-bottom: 30px;
            border: 2px solid rgba(255,255,255,0.3);
            transition: all 0.4s ease;
            animation: backAppear 1s ease-out;
        }

        .btn-back i {
            margin-right: 10px;
            transition: transform 0.3s ease;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-5px);
            border-color: white;
        }

        .btn-back:hover i {
            transform: translateX(-5px);
        }

        @keyframes backAppear {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Efek validasi */
        .form-group input:valid,
        .form-group textarea:valid {
            border-color: var(--success);
        }

        .form-group input:invalid:not(:placeholder-shown),
        .form-group textarea:invalid:not(:placeholder-shown) {
            border-color: var(--danger);
        }

        /* Style untuk placeholder */
        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #999;
            font-style: italic;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .form-group input:focus::placeholder,
        .form-group textarea:focus::placeholder {
            transform: translateX(10px);
            opacity: 0.5;
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

        /* Responsive design */
        @media screen and (max-width: 768px) {
            .header h2 {
                font-size: 2em;
            }
            
            .form-card {
                padding: 30px 20px;
            }
            
            .form-group input,
            .form-group textarea {
                padding: 15px 20px;
                font-size: 14px;
            }
            
            .btn-submit {
                padding: 15px 30px;
                font-size: 16px;
            }
            
            .cursor, .cursor-trail {
                display: none;
            }
            
            body {
                cursor: auto;
            }
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

        /* Loading spinner */
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

        /* Progress bar */
        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: var(--gradient-1);
            z-index: 10002;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- Progress bar -->
    <div class="progress-bar" id="progressBar"></div>
    
    <!-- Background Animation -->
    <div class="bg-animation" id="bgAnimation"></div>
    
    <!-- Custom Cursor -->
    <div class="cursor" id="cursor"></div>
    <div class="cursor-trail" id="cursorTrail"></div>
    
    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner"></div>

    <div class="container">
        <!-- Tombol Kembali -->
        <a href="index.php" class="btn-back" data-tooltip="Kembali ke halaman utama">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <!-- Header -->
        <div class="header">
            <h2>
                <i class="fas fa-user-plus"></i>
                Tambah Data Siswa
            </h2>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <form action="proses_tambah.php" method="POST" id="tambahForm">
                <!-- Field Nama -->
                <div class="form-group" id="namaGroup">
                    <label>
                        <i class="fas fa-user"></i>
                        Nama Lengkap
                    </label>
                    <input type="text" 
                           name="nama" 
                           placeholder="Masukkan nama lengkap siswa..."
                           required
                           data-tooltip="Minimal 3 karakter"
                           pattern=".{3,}"
                           title="Nama harus minimal 3 karakter"
                           id="namaInput">
                </div>

                <!-- Field Kelas -->
                <div class="form-group" id="kelasGroup">
                    <label>
                        <i class="fas fa-school"></i>
                        Kelas
                    </label>
                    <input type="text" 
                           name="kelas" 
                           placeholder="Contoh: X IPA 1, XI IPS 2, XII RPL..."
                           required
                           data-tooltip="Masukkan kelas dengan format yang benar"
                           id="kelasInput">
                </div>

                <!-- Field Alamat -->
                <div class="form-group" id="alamatGroup">
                    <label>
                        <i class="fas fa-map-marker-alt"></i>
                        Alamat
                    </label>
                    <textarea name="alamat" 
                              placeholder="Masukkan alamat lengkap..."
                              required
                              data-tooltip="Masukkan alamat dengan detail"
                              id="alamatInput"></textarea>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-save"></i>
                    <span>Simpan Data</span>
                    <i class="fas fa-chevron-right"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        // Custom cursor dengan efek trail
        const cursor = document.getElementById('cursor');
        const cursorTrail = document.getElementById('cursorTrail');
        
        document.addEventListener('mousemove', function(e) {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
            cursorTrail.style.left = e.clientX + 'px';
            cursorTrail.style.top = e.clientY + 'px';
        });

        // Efek hover pada input mengubah ukuran cursor
        document.querySelectorAll('input, textarea, button, a').forEach(element => {
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

        // Efek focus pada form group
        const inputs = document.querySelectorAll('.form-group input, .form-group textarea');
        
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.closest('.form-group').classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.closest('.form-group').classList.remove('focused');
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

        // Progress bar saat scroll
        window.addEventListener('scroll', function() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById('progressBar').style.width = scrolled + '%';
        });

        // Validasi form real-time
        document.getElementById('namaInput').addEventListener('input', function() {
            if (this.value.length < 3) {
                this.setCustomValidity('Nama minimal 3 karakter');
                this.style.borderColor = 'var(--danger)';
            } else {
                this.setCustomValidity('');
                this.style.borderColor = 'var(--success)';
            }
        });

        // Animasi submit form
        document.getElementById('tambahForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
            
            // Tampilkan loading spinner
            document.getElementById('loadingSpinner').style.display = 'block';
            
            // Form akan tetap disubmit
            return true;
        });

        // Efek parallax pada background
        document.addEventListener('mousemove', function(e) {
            const moveX = (e.clientX - window.innerWidth / 2) * 0.01;
            const moveY = (e.clientY - window.innerHeight / 2) * 0.01;
            
            document.querySelector('.bg-animation').style.transform = 
                `translate(${moveX}px, ${moveY}px)`;
        });

        // Counter karakter untuk textarea
        const alamatInput = document.getElementById('alamatInput');
        const charCounter = document.createElement('div');
        charCounter.style.cssText = `
            font-size: 12px;
            margin-top: 5px;
            color: #666;
            text-align: right;
        `;
        alamatInput.parentNode.appendChild(charCounter);
        
        alamatInput.addEventListener('input', function() {
            const remaining = 500 - this.value.length;
            charCounter.textContent = `${remaining} karakter tersisa`;
            
            if (remaining < 50) {
                charCounter.style.color = 'var(--warning)';
            } else {
                charCounter.style.color = '#666';
            }
            
            if (remaining < 0) {
                charCounter.style.color = 'var(--danger)';
            }
        });

        // Efek ripple pada tombol submit
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255,255,255,0.5);
                width: 10px;
                height: 10px;
                left: ${e.offsetX}px;
                top: ${e.offsetY}px;
                transform: translate(-50%, -50%);
                animation: ripple 1s ease-out;
                pointer-events: none;
            `;
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 1000);
        });

        // Animasi untuk form group saat halaman dimuat
        window.addEventListener('load', function() {
            document.getElementById('loadingSpinner').style.display = 'none';
            
            // Trigger animation for form groups
            const groups = document.querySelectorAll('.form-group');
            groups.forEach((group, index) => {
                group.style.animation = `slideIn 0.5s ease-out ${index * 0.2}s forwards`;
            });
        });

        // Konfirmasi sebelum meninggalkan halaman jika form sudah diisi
        let formChanged = false;
        
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                formChanged = true;
            });
        });

        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
    </script>

    <style>
        /* Tambahan animasi */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Style untuk karakter counter */
        .form-group:last-child {
            margin-bottom: 10px;
        }

        /* Efek untuk input yang valid */
        .form-group input:valid:not(:placeholder-shown),
        .form-group textarea:valid:not(:placeholder-shown) {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2300b09b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 20px;
            padding-right: 45px;
        }

        /* Efek untuk input yang invalid */
        .form-group input:invalid:not(:placeholder-shown),
        .form-group textarea:invalid:not(:placeholder-shown) {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23e74c3c' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='12' cy='12' r='10'%3E%3C/circle%3E%3Cline x1='12' y1='8' x2='12' y2='12'%3E%3C/line%3E%3Cline x1='12' y1='16' x2='12.01' y2='16'%3E%3C/line%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 20px;
            padding-right: 45px;
        }
    </style>
</body>
</html>