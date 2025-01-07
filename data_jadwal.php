<?php
session_start();
include_once("config.php");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Proses tambah data
if (isset($_POST['add_jadwal'])) {
    $pasien_id = $_POST['pasien_id'];
    $dokter_id = $_POST['dokter_id'];
    $tanggal_pemeriksaan = $_POST['tanggal_pemeriksaan'];
    $waktu_pemeriksaan = $_POST['waktu_pemeriksaan'];

    $result = mysqli_query($mysqli, "INSERT INTO jadwal (pasien_id, dokter_id, tanggal_pemeriksaan, waktu_pemeriksaan) VALUES ('$pasien_id', '$dokter_id', '$tanggal_pemeriksaan', '$waktu_pemeriksaan')");
    if ($result) {
        header("Location: data_jadwal.php");
    } else {
        echo "Terjadi kesalahan saat menambahkan data jadwal.";
    }
}

// Mendapatkan semua data jadwal
$result = mysqli_query($mysqli, "SELECT jadwal.*, pasien.nama AS pasien_nama, dokter.nama AS dokter_nama FROM jadwal 
                                 JOIN pasien ON jadwal.pasien_id = pasien.id 
                                 JOIN dokter ON jadwal.dokter_id = dokter.id ORDER BY jadwal.id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jadwal</title>
    <style>
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 2px solid #f2a6c4; /* Darker pink border for better visibility */
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8d8e1; /* Light pastel pink for header */
            color: #6b4f3d; /* Darker text for better contrast */
        }
        td {
            background-color: #ffffff;
        }

        /* Form Container Styling */
        .form-container {
            margin: 20px 0;
        }
        .form-container h3 {
            color: #333;
        }
        label {
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }
        select, input {
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 8px;
            font-size: 14px;
        }

        /* Button Styling */
        button {
            background-color: #f8d8e1; /* Pastel pink button */
            color: #6b4f3d; /* Darker text for visibility */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #f3b7d4; /* Slightly darker pink for hover */
        }

        /* Link Styling */
        a {
            background-color: #f8d8e1; /* Pastel pink */
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            color: #6b4f3d;
            font-weight: bold;
            margin-bottom: 20px;
            display: inline-block;
        }
        a:hover {
            background-color: #f3b7d4; /* Hover effect */
        }

        /* Button Styling for Delete and Edit */
        .delete-button {
            background-color: #ff4d4d; /* Red for delete */
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: #e60000; /* Darker red for delete hover */
        }
        .edit-button {
            background-color: #ffcc66; /* Yellow-orange for edit */
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-button:hover {
            background-color: #e6b800; /* Darker yellow-orange */
        }

        /* Hover Effects for Table Rows */
        tr:hover {
            background-color: #ffe6f1; /* Light pink when hovered */
        }

        /* Emoji Styling */
        .emoji {
            font-size: 20px;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; color: #333;">Data Jadwal Pemeriksaan <span class="emoji">📅</span></h1>

    <!-- Link Kembali ke Halaman Utama -->
    <a href="index.php"><span class="emoji">🏠</span> Kembali ke Halaman Utama</a>

    <!-- Form Tambah Jadwal -->
    <div class="form-container">
        <form method="POST">
            <h3>Tambah Jadwal <span class="emoji">➕</span></h3>
            <label>Pasien:</label>
            <select name="pasien_id" required>
                <?php
                $pasien_result = mysqli_query($mysqli, "SELECT * FROM pasien");
                while ($pasien = mysqli_fetch_assoc($pasien_result)) {
                    echo "<option value='".$pasien['id']."'>".$pasien['nama']."</option>";
                }
                ?>
            </select><br>
            <label>Dokter:</label>
            <select name="dokter_id" required>
                <?php
                $dokter_result = mysqli_query($mysqli, "SELECT * FROM dokter");
                while ($dokter = mysqli_fetch_assoc($dokter_result)) {
                    echo "<option value='".$dokter['id']."'>".$dokter['nama']."</option>";
                }
                ?>
            </select><br>
            <label>Tanggal Pemeriksaan:</label>
            <input type="date" name="tanggal_pemeriksaan" required><br>
            <label>Waktu Pemeriksaan:</label>
            <input type="time" name="waktu_pemeriksaan" required><br>
            <button type="submit" name="add_jadwal"><span class="emoji">➕</span> Tambah</button>
        </form>
    </div>

    <!-- Tabel Data Jadwal -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Waktu Pemeriksaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($data = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $data['id']; ?></td>
                <td><?php echo $data['pasien_nama']; ?></td>
                <td><?php echo $data['dokter_nama']; ?></td>
                <td><?php echo $data['tanggal_pemeriksaan']; ?></td>
                <td><?php echo $data['waktu_pemeriksaan']; ?></td>
                <td>
                    <button class="edit-button"><span class="emoji">✏️</span> Edit</button>
                    <a href="data_jadwal.php?delete=<?php echo $data['id']; ?>">
                        <button class="delete-button"><span class="emoji">🗑️</span> Hapus</button>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
