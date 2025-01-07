<?php
$host = "localhost"; // Host database
$username = "root"; // Username MySQL (default XAMPP)
$password = ""; // Password MySQL (default kosong di XAMPP)
$dbname = "manajemen_rs"; // Nama database yang telah kamu buat

// Membuat koneksi ke database
$mysqli = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
?>
