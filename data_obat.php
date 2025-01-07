<?php
session_start();
include_once("config.php");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Proses tambah data
if (isset($_POST['add_obat'])) {
    $nama_obat = $_POST['nama_obat'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];

    $result = mysqli_query($mysqli, "INSERT INTO obat (nama_obat, kategori, stok, tanggal_kadaluarsa) VALUES ('$nama_obat', '$kategori', '$stok', '$tanggal_kadaluarsa')");
    if ($result) {
        header("Location: data_obat.php");
    } else {
        echo "Terjadi kesalahan saat menambahkan data obat.";
    }
}

// Proses hapus data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $result = mysqli_query($mysqli, "DELETE FROM obat WHERE id=$id");
    if ($result) {
        header("Location: data_obat.php");
    } else {
        echo "Terjadi kesalahan saat menghapus data obat.";
    }
}

// Proses edit data
if (isset($_POST['edit_obat'])) {
    $id = $_POST['id'];
    $nama_obat = $_POST['nama_obat'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $tanggal_kadaluarsa = $_POST['tanggal_kadaluarsa'];

    $result = mysqli_query($mysqli, "UPDATE obat SET nama_obat='$nama_obat', kategori='$kategori', stok='$stok', tanggal_kadaluarsa='$tanggal_kadaluarsa' WHERE id=$id");
    if ($result) {
        header("Location: data_obat.php");
    } else {
        echo "Terjadi kesalahan saat mengedit data obat.";
    }
}

// Mendapatkan semua data obat
$result = mysqli_query($mysqli, "SELECT * FROM obat ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat</title>
    <style>
        body {
            background-color: #9a606c; /* Senada dengan warna halaman sebelumnya */
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f5f5f5;
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
            background-color: #f9e2ae;
        }
        .form-container {
            margin: 20px 0;
            background-color: #d48d98;
            padding: 20px;
            border-radius: 10px;
        }
        button {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button.delete-button {
            background-color: red;
            color: white;
        }
        button.edit-button {
            background-color: orange;
            color: white;
        }
        button:hover {
            background-color: limegreen;
        }
        a {
            background-color: #ff6b6b;
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
    <h1>Data Obat 💊✨</h1>
    <a href="index.php" style="background-color: lightblue; padding: 10px 20px; text-decoration: none; border-radius: 5px; color: black;">🏠 Kembali ke Halaman Utama</a>

    <!-- Form Tambah/Edit Obat -->
    <div class="form-container">
        <form method="POST">
            <h3 id="form-title">Tambah Obat 🌈</h3>
            <input type="hidden" name="id" id="id">
            <label>Nama Obat:</label>
            <input type="text" name="nama_obat" id="nama_obat" required><br>
            <label>Kategori:</label>
            <input type="text" name="kategori" id="kategori"><br>
            <label>Stok:</label>
            <input type="number" name="stok" id="stok" required><br>
            <label>Tanggal Kadaluarsa:</label>
            <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" required><br>
            <button type="submit" name="add_obat" id="submit-button">Tambah</button>
            <button type="submit" name="edit_obat" id="edit-button" style="display: none;">Simpan Perubahan</button>
        </form>
    </div>

    <!-- Tabel Data Obat -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Obat</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Tanggal Kadaluarsa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nama_obat'] . "</td>";
                    echo "<td>" . $row['kategori'] . "</td>";
                    echo "<td>" . $row['stok'] . "</td>";
                    echo "<td>" . $row['tanggal_kadaluarsa'] . "</td>";
                    echo "<td>
                        <button class='edit-button' onclick='editData(" . json_encode($row) . ")'>Edit</button>
                        <a href='data_obat.php?delete=" . $row['id'] . "'><button class='delete-button'>Hapus</button></a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data obat.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function editData(data) {
            document.getElementById("form-title").innerText = "Edit Obat";
            document.getElementById("id").value = data.id;
            document.getElementById("nama_obat").value = data.nama_obat;
            document.getElementById("kategori").value = data.kategori;
            document.getElementById("stok").value = data.stok;
            document.getElementById("tanggal_kadaluarsa").value = data.tanggal_kadaluarsa;
            document.getElementById("submit-button").style.display = "none";
            document.getElementById("edit-button").style.display = "inline";
        }
    </script>
</body>
</html>
