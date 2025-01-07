<?php
session_start();
include_once("config.php");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pasien berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($mysqli, "SELECT * FROM pasien WHERE id=$id");
    $data = mysqli_fetch_assoc($result);
}

// Proses update data pasien
if (isset($_POST['update_pasien'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $usia = $_POST['usia'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $keluhan = $_POST['keluhan'];

    $result = mysqli_query($mysqli, "UPDATE pasien SET nama='$nama', usia='$usia', jenis_kelamin='$jenis_kelamin', keluhan='$keluhan' WHERE id=$id");
    if ($result) {
        header("Location: data_pasien.php");
    } else {
        echo "Terjadi kesalahan saat mengupdate data pasien.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pasien</title>
</head>
<body>
    <h1>Edit Data Pasien</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <label>Nama:</label>
        <input type="text" name="nama" value="<?php echo $data['nama']; ?>" required><br>
        <label>Usia:</label>
        <input type="number" name="usia" value="<?php echo $data['usia']; ?>" required><br>
        <label>Jenis Kelamin:</label>
        <select name="jenis_kelamin" required>
            <option value="Laki-laki" <?php if ($data['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
            <option value="Perempuan" <?php if ($data['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
        </select><br>
        <label>Keluhan:</label>
        <textarea name="keluhan" required><?php echo $data['keluhan']; ?></textarea><br>
        <button type="submit" name="update_pasien">Update</button>
    </form>
</body>
</html>
