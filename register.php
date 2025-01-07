<?php
session_start();
include_once("config.php");

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi password menggunakan MD5
    $confirm_password = md5($_POST['confirm_password']);

    // Validasi input
    if ($password !== $confirm_password) {
        echo "Password dan Konfirmasi Password tidak cocok!";
    } else {
        // Cek apakah username sudah ada
        $check_user = mysqli_query($mysqli, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($check_user) > 0) {
            echo "Username sudah digunakan, pilih username lain!";
        } else {
            // Masukkan data pengguna ke database
            $result = mysqli_query($mysqli, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
            if ($result) {
                echo "Registrasi berhasil! <a href='login.php'>Login di sini</a>";
            } else {
                echo "Terjadi kesalahan saat registrasi. Coba lagi.";
            }
        }
    }
}
?>

<form method="POST">
    <h2>Registrasi Pengguna</h2>
    <label>Username:</label>
    <input type="text" name="username" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <label>Konfirmasi Password:</label>
    <input type="password" name="confirm_password" required><br>
    <button type="submit" name="register">Register</button>
</form>
