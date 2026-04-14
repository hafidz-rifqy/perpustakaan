<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Akses ditolak.");
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$app_url = $_ENV['APP_URL'] ?? 'http://localhost/hafiddev';

if ($action === 'tambah_buku') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
    $stok = (int)$_POST['stok'];

    $sql = "INSERT INTO buku (judul, penulis, penerbit, stok) VALUES ('$judul', '$penulis', '$penerbit', $stok)";
    if (mysqli_query($conn, $sql)) {
        header("Location: $app_url/pages/admin/kelola_buku.php?success=1");
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} elseif ($action === 'tambah_anggota') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);

    $sql = "INSERT INTO anggota (nama, alamat, telp) VALUES ('$nama', '$alamat', '$telp')";
    if (mysqli_query($conn, $sql)) {
        header("Location: $app_url/pages/admin/kelola_anggota.php?success=1");
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} elseif ($action === 'tambah_pinjam') {
    $id_buku = (int)$_POST['id_buku'];
    $id_anggota = (int)$_POST['id_anggota'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];

    // Cek stok buku
    $check_stok = mysqli_query($conn, "SELECT stok FROM buku WHERE id_buku = $id_buku");
    $buku = mysqli_fetch_assoc($check_stok);

    if ($buku && $buku['stok'] > 0) {
        $sql = "INSERT INTO peminjaman (id_buku, id_anggota, tgl_pinjam, tgl_kembali) 
                VALUES ($id_buku, $id_anggota, '$tgl_pinjam', '$tgl_kembali')";
        
        if (mysqli_query($conn, $sql)) {
            // Kurangi stok
            mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE id_buku = $id_buku");
            header("Location: $app_url/pages/admin/kelola_peminjaman.php?success=1");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Maaf, stok buku habis!";
    }
}
?>
