<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Mengambil nama pengguna dari session
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #9a606c ;
            color: #ffcece ;
        }
        .header {
            background-color: #d4afb9; (0, 255, 251);
            color: #f0efeb;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
        }
        .menu {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .menu a {
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #d4afb9;
            color: white;
            border-radius: 5px;
            transition: 0.3s;
        }
        .menu a:hover {
            background-color: #d1cfe2;
        }
        .welcome {
            text-align: center;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Selamat Datang, <?php echo ucfirst($username); ?>!</h1>
        <p>Ini adalah halaman utama aplikasi.</p>
    </div>

    <div class="menu">
        <a href="data_pasien.php">Data Pasien</a>
        <a href="data_dokter.php">Data Dokter</a>
        <a href="data_obat.php">Data Obat</a>
        <a href="data_jadwal.php">Jadwal Pemeriksaan</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="welcome">
        <h2>Selamat datang di Sistem Manajemen RS</h2>
        <p>Gunakan menu di atas untuk mengakses fitur yang tersedia.</p>
    </div>
</body>
</html>
