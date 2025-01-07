<?php
session_start();
include_once("config.php");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Proses tambah data
if (isset($_POST['add_dokter'])) {
    $nama = $_POST['nama'];
    $spesialisasi = $_POST['spesialisasi'];
    $jadwal_praktek = $_POST['jadwal_praktek'];
    $kontak = $_POST['kontak'];

    $result = mysqli_query($mysqli, "INSERT INTO dokter (nama, spesialisasi, jadwal_praktek, kontak) VALUES ('$nama', '$spesialisasi', '$jadwal_praktek', '$kontak')");
    if ($result) {
        header("Location: data_dokter.php");
    } else {
        echo "Terjadi kesalahan saat menambahkan data dokter.";
    }
}

// Proses hapus data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = mysqli_query($mysqli, "DELETE FROM dokter WHERE id=$id");
    if ($result) {
        header("Location: data_dokter.php");
    } else {
        echo "Terjadi kesalahan saat menghapus data dokter.";
    }
}

// Mendapatkan semua data dokter
$result = mysqli_query($mysqli, "SELECT * FROM dokter ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dokter</title>
    <style>
        body {
            background-color: #9a606c; /* Senada dengan warna sebelumnya */
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f5f5f5; /* Kontras dengan latar belakang */
            color: #333;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #e1a6b4;
        }
        td {
            background-color:rgb(236, 211, 152);
        }
        .form-container {
            margin: 20px 0;
            background-color: #d48d98; /* Warna latar belakang form senada */
            padding: 20px;
            border-radius: 10px;
        }
        button {
            background-color: lightgreen;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: limegreen;
        }
        a {
            background-color:rgb(190, 111, 111);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
            display: inline-block;
        }
        a:hover {
            background-color: #ff4757;
        }
    </style>
</head>
<body>
    <h1>Data Dokter 🩺✨</h1>
    <!-- Link Kembali ke Halaman Utama -->
    <a href="index.php" style="background-color: lightblue; padding: 10px 20px; text-decoration: none; border-radius: 5px; color: black;">🏠 Kembali ke Halaman Utama</a>

    <!-- Form Tambah Dokter -->
    <div class="form-container">
        <form method="POST">
            <h3>Tambah Dokter 🌈</h3>
            <label>Nama:</label>
            <input type="text" name="nama" required><br>
            <label>Spesialisasi:</label>
            <input type="text" name="spesialisasi" required><br>
            <label>Jadwal Praktek:</label>
            <input type="text" name="jadwal_praktek"><br>
            <label>Kontak:</label>
            <input type="text" name="kontak"><br>
            <button type="submit" name="add_dokter">Tambah Dokter 💖</button>
        </form>
    </div>

    <!-- Tabel Data Dokter -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Spesialisasi</th>
            <th>Jadwal Praktek</th>
            <th>Kontak</th>
            <th>Aksi</th>
        </tr>
        <?php while ($data = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $data['id']; ?></td>
            <td><?php echo $data['nama']; ?></td>
            <td><?php echo $data['spesialisasi']; ?></td>
            <td><?php echo $data['jadwal_praktek']; ?></td>
            <td><?php echo $data['kontak']; ?></td>
            <td>
                <a href="edit_dokter.php?id=<?php echo $data['id']; ?>">✏️ Edit</a> |
                <a href="data_dokter.php?delete=<?php echo $data['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">❌ Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
