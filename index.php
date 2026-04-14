<?php
session_start();

// Cek apakah pengguna belum login
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// PERBAIKAN: Tambahkan pengecekan error pada query
$query = mysqli_query($conn, "SELECT * FROM siswa");

// Cek apakah query berhasil
if (!$query) {
    die("Error query: " . mysqli_error($conn));
}

// Cek apakah ada data
$jumlah_data = mysqli_num_rows($query);
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

        /* Style tombol Tambah Data */
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
        }

        .btn-tambah:hover i {
            transform: rotate(360deg) scale(1.2);
        }

        /* Style tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 30px 60px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.3);
        }

        /* Style header tabel */
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
        }

        /* Style sel tabel */
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

        /* Efek hover pada baris */
        table tr {
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
        }

        table tr:hover {
            background: var(--gradient-3);
            transform: scale(1.02) translateX(5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            z-index: 10;
        }

        table tr:hover td {
            color: var(--dark);
            font-weight: 600;
        }

        /* Style untuk link aksi */
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
        }

        table td a[href*="edit"]:hover {
            background: linear-gradient(135deg, #C850C0, #4158D0);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 25px rgba(65, 88, 208, 0.6);
        }

        /* Style link Hapus */
        table td a[href*="hapus"] {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }

        table td a[href*="hapus"]:hover {
            background: linear-gradient(135deg, #c0392b, #e74c3c);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 25px rgba(231, 76, 60, 0.6);
        }

        /* Style untuk link Detail */
        table td a[href*="detail"] {
            background: linear-gradient(135deg, #00d2ff, #3a47d5);
            color: white;
        }

        table td a[href*="detail"]:hover {
            background: linear-gradient(135deg, #3a47d5, #00d2ff);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 210, 255, 0.6);
        }

        /* Pesan ketika tidak ada data */
        .no-data {
            text-align: center;
            padding: 40px;
            background: rgba(255,255,255,0.95);
            border-radius: 30px;
            font-size: 18px;
            color: #666;
        }

        .no-data i {
            font-size: 50px;
            margin-bottom: 20px;
            color: var(--primary);
        }

        /* Efek zebra stripe */
        table tr:nth-child(even) {
            background: rgba(248, 249, 250, 0.8);
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
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📚 DATA SISWA</h1>
        </div>

        <!-- Tombol Tambah Data -->
        <div style="text-align: center;">
            <a href="tambah.php" class="btn-tambah">
                <i class="fas fa-plus-circle"></i> Tambah Data
            </a>
        </div>

        <!-- Tabel Data Siswa -->
        <?php if($jumlah_data > 0): ?>
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
                        <a href="detail.php?id=<?= $data['id'] ?>">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="edit.php?id=<?= $data['id'] ?>">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="hapus.php?id=<?= $data['id'] ?>" 
                           onclick="return confirm('⚠️ Yakin ingin menghapus data ini? Aksi ini tidak dapat dibatalkan!')">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="no-data" style="text-align: center; padding: 60px; background: rgba(255,255,255,0.95); border-radius: 30px;">
            <i class="fas fa-database" style="font-size: 60px; color: #4158D0;"></i>
            <h3 style="margin-top: 20px; color: #666;">Belum ada data siswa</h3>
            <p style="margin-top: 10px; color: #999;">Silakan tambah data siswa terlebih dahulu</p>
            <a href="tambah.php" style="display: inline-block; margin-top: 20px; padding: 12px 30px; background: linear-gradient(135deg, #4158D0, #C850C0); color: white; text-decoration: none; border-radius: 30px;">
                <i class="fas fa-plus-circle"></i> Tambah Data Sekarang
            </a>
        </div>
        <?php endif; ?>
    </div>

    <script>
        // Konfirmasi hapus dengan efek
        document.querySelectorAll('a[href*="hapus"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (!confirm('⚠️ Yakin ingin menghapus data ini? Aksi ini tidak dapat dibatalkan!')) {
                    e.preventDefault();
                }
            });
        });

        // Efek smooth pada tombol
        document.querySelectorAll('.btn-tambah, table td a').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>