<?php
session_start(); // Memulai sesi
session_destroy(); // Menghapus semua data sesi
header("Location: login.php"); // Redirect ke halaman login
exit(); // Hentikan script
?>
