<?php
require 'koneksi.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $konfirmasi = $_POST['konfirmasi'] ?? '';

    // Validasi sederhana
    if ($fullname === '' || $username === '' || $email === '' || $password === '' || $konfirmasi === '') {
        $error = 'Semua field wajib diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid!';
    } elseif ($password !== $konfirmasi) {
        $error = 'Konfirmasi password tidak sesuai!';
    } else {
        // Hash password sebelum simpan ke database
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Cek username/email sudah ada
        $cek = mysqli_query($conn, "SELECT id FROM users WHERE username='$username' OR email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            $error = 'Username atau email sudah terdaftar!';
        } else {
            $query_sql = "INSERT INTO users (fullname, username, email, password) 
                        VALUES ('$fullname', '$username', '$email', '$password_hash')";
            if (mysqli_query($conn, $query_sql)) {
                $success = 'Registrasi berhasil! Silakan login.';
            } else {
                $error = 'Gagal menyimpan data: ' . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Akun | E-SIMAKSI UPAS HILL</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/registrasi.css">
</head>
<body>
    <div class="register-container">
        <div class="register-title">Registrasi Akun E-SIMAKSI</div>
        <?php if ($error): ?>
            <div class="register-error"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif ($success): ?>
            <div class="register-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <form class="register-form" method="post" autocomplete="off">
            <input type="text" name="fullname" class="register-input" placeholder="Nama Lengkap" required>
            <input type="text" name="username" class="register-input" placeholder="Username" required>
            <input type="email" name="email" class="register-input" placeholder="Email" required>
            <input type="password" name="password" class="register-input" placeholder="Password" required>
            <input type="password" name="konfirmasi" class="register-input" placeholder="Konfirmasi Password" required>
            <button type="submit" class="register-btn">Registrasi</button>
        </form>
        <div class="text-login">
            Sudah punya akun? 
            <a href="login.php" style="color:#b7e4c7; text-decoration:underline;">Login di sini</a>
            <br>
            <a href="index.php" style="color:#fff; text-decoration:underline; font-weight:600;">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>