<?php
include 'koneksi.php';

echo "<h2>Informasi Koneksi Database</h2>";

// Cek apakah koneksi berhasil
if($conn) {
    echo "✅ Koneksi database BERHASIL<br>";
} else {
    echo "❌ Koneksi database GAGAL: " . mysqli_connect_error() . "<br>";
}

// Cek database yang dipilih
$result = mysqli_query($conn, "SELECT DATABASE()");
$row = mysqli_fetch_array($result);
echo "📁 Database yang sedang digunakan: <strong>" . $row[0] . "</strong><br><br>";

// Cek semua tabel yang ada
echo "<h3>Daftar Tabel dalam Database:</h3>";
$result = mysqli_query($conn, "SHOW TABLES");
if(mysqli_num_rows($result) > 0) {
    echo "<ul>";
    while($row = mysqli_fetch_array($result)) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
} else {
    echo "❌ Tidak ada tabel dalam database ini<br>";
}

// Cek khusus tabel admin
echo "<h3>Cek Tabel Admin:</h3>";
$result = mysqli_query($conn, "SHOW TABLES LIKE 'admin'");
if(mysqli_num_rows($result) > 0) {
    echo "✅ Tabel 'admin' ADA<br><br>";
    
    // Cek struktur tabel admin
    $result = mysqli_query($conn, "DESCRIBE admin");
    echo "<h4>Struktur Tabel Admin:</h4>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Kolom</th><th>Tipe</th><th>Null</th><th>Key</th></tr>";
    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
    
    // Cek data di tabel admin
    $result = mysqli_query($conn, "SELECT * FROM admin");
    if(mysqli_num_rows($result) > 0) {
        echo "✅ Data dalam tabel admin:<br>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Username</th><th>Password</th><th>Nama Lengkap</th></tr>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['password'] . "</td>";
            echo "<td>" . $row['nama_lengkap'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "❌ Tabel 'admin' KOSONG (tidak ada data)<br>";
    }
} else {
    echo "❌ Tabel 'admin' TIDAK ADA dalam database<br>";
}

mysqli_close($conn);
?>