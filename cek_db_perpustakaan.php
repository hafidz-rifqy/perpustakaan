<?php
include 'koneksi.php';

echo "<h2>Cek Database db_perpustakaan</h2>";

// Cek database yang aktif
$result = mysqli_query($conn, "SELECT DATABASE()");
$row = mysqli_fetch_array($result);
echo "Database aktif: <strong>" . $row[0] . "</strong><br><br>";

// Cek semua tabel
echo "<h3>Daftar Tabel:</h3>";
$result = mysqli_query($conn, "SHOW TABLES");
if(mysqli_num_rows($result) > 0) {
    echo "<ul>";
    while($row = mysqli_fetch_array($result)) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
} else {
    echo "❌ Tidak ada tabel dalam database<br>";
}

// Cek tabel admin (mungkin namanya berbeda)
echo "<h3>Cek Tabel Admin/Petugas:</h3>";
$tables = ['admin', 'petugas', 'user', 'login'];
foreach($tables as $table) {
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    if(mysqli_num_rows($result) > 0) {
        echo "✅ Tabel '$table' ADA<br>";
        
        // Lihat struktur
        $desc = mysqli_query($conn, "DESCRIBE $table");
        echo "<table border='1' cellpadding='5' style='margin-left:20px'>";
        while($col = mysqli_fetch_array($desc)) {
            echo "<tr><td>" . $col['Field'] . "</td><td>" . $col['Type'] . "</td></tr>";
        }
        echo "</table><br>";
    }
}

mysqli_close($conn);
?>