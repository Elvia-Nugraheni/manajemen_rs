<?php
session_start();
include_once("config.php");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data dokter berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM dokter WHERE id=$id");
    $data = mysqli_fetch_assoc($result);
}

// Proses update data dokter
if (isset($_POST['update_dokter'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $spesialisasi = $_POST['spesialisasi'];
    $jadwal_praktek = $_POST['jadwal_praktek'];
    $kontak = $_POST['kontak'];

    $result = mysqli_query($mysqli, "UPDATE dokter SET nama='$nama', spesialisasi='$spesialisasi', jadwal_praktek='$jadwal_praktek', kontak='$kontak' WHERE id=$id");
    if ($result) {
        header("Location: data_dokter.php");
    } else {
        echo "Terjadi kesalahan saat mengupdate data dokter.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dokter</title>
</head>
<body>
    <h1>Edit Data Dokter</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <label>Nama:</label>
        <input type="text" name="nama" value="<?php echo $data['nama']; ?>" required><br>
        <label>Spesialisasi:</label>
        <input type="text" name="spesialisasi" value="<?php echo $data['spesialisasi']; ?>" required><br>
        <label>Jadwal Praktek:</label>
        <input type="text" name="jadwal_praktek" value="<?php echo $data['jadwal_praktek']; ?>"><br>
        <label>Kontak:</label>
        <input type="text" name="kontak" value="<?php echo $data['kontak']; ?>"><br>
        <button type="submit" name="update_dokter">Update</button>
    </form>
</body>
</html>
