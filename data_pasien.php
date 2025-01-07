<?php
session_start();
include_once("config.php");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Proses tambah data
if (isset($_POST['add_pasien'])) {
    $nama = $_POST['nama'];
    $usia = $_POST['usia'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $keluhan = $_POST['keluhan'];

    $result = mysqli_query($mysqli, "INSERT INTO pasien (nama, usia, jenis_kelamin, keluhan) VALUES ('$nama', '$usia', '$jenis_kelamin', '$keluhan')");
    if ($result) {
        header("Location: data_pasien.php");
    } else {
        echo "Terjadi kesalahan saat menambahkan data pasien.";
    }
}

// Proses hapus data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = mysqli_query($mysqli, "DELETE FROM pasien WHERE id=$id");
    if ($result) {
        header("Location: data_pasien.php");
    } else {
        echo "Terjadi kesalahan saat menghapus data pasien.";
    }
}

// Mendapatkan semua data pasien
$result = mysqli_query($mysqli, "SELECT * FROM pasien ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien 🌟</title>
    <style>
        body {
            background-color: #9a606c; /* Senada dengan warna yang diminta */
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color:rgb(224, 214, 148); /* Warna latar tabel yang kontras */
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
            background-color:rgb(225, 98, 136);
        }
        td {
            background-color:#f9e2ae(204, 163, 170);
        }
        .form-container {
            margin: 20px 0;
            background-color: #d48d98; /* Background form senada */
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
            background-color:rgba(238, 97, 135, 0.86);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
            display: inline-block;
        }
        a:hover {
            background-color:rgb(249, 136, 146);
        }
    </style>
</head>
<body>
    <h1>Data Pasien 🏥✨</h1>
    <a href="index.php" style="background-color: lightblue; padding: 10px 20px; text-decoration: none; border-radius: 5px; color: black;">🏠 Kembali ke Halaman Utama</a>

    <!-- Form Tambah Pasien -->
    <div class="form-container">
        <form method="POST">
            <h3>Tambah Pasien 🌈</h3>
            <label>Nama:</label>
            <input type="text" name="nama" required><br>
            <label>Usia:</label>
            <input type="number" name="usia" required><br>
            <label>Jenis Kelamin:</label>
            <select name="jenis_kelamin" required>
                <option value="Laki-laki">Laki-laki 🧑‍🦱</option>
                <option value="Perempuan">Perempuan 👩‍🦰</option>
            </select><br>
            <label>Keluhan:</label>
            <textarea name="keluhan" required></textarea><br>
            <button type="submit" name="add_pasien">Tambah Pasien 💖</button>
        </form>
    </div>

    <!-- Tabel Data Pasien -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Usia</th>
            <th>Jenis Kelamin</th>
            <th>Keluhan</th>
            <th>Aksi</th>
        </tr>
        <?php while ($data = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $data['id']; ?></td>
            <td><?php echo $data['nama']; ?></td>
            <td><?php echo $data['usia']; ?></td>
            <td><?php echo $data['jenis_kelamin']; ?></td>
            <td><?php echo $data['keluhan']; ?></td>
            <td>
                <a href="edit_pasien.php?id=<?php echo $data['id']; ?>">✏️ Edit</a> |
                <a href="data_pasien.php?delete=<?php echo $data['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">❌ Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
