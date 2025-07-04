<?php
require 'koneksi.php';
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Ambil data user dari database
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' LIMIT 1");
    if ($row = mysqli_fetch_assoc($query)) {
        // Verifikasi password hash
        if (password_verify($password, $row['password'])) {
            $_SESSION['nama'] = $row['fullname'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            if ($row['role'] === 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            $error = 'Username atau password salah!';
        }
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | E-SIMAKSI UPAS HILL</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-title">Login E-SIMAKSI UPAS HILL</div>
        <?php if ($error): ?>
            <div class="login-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form class="login-form" method="post" autocomplete="off">
            <input type="text" name="username" class="login-input" placeholder="Username" required autofocus>
            <input type="password" name="password" class="login-input" placeholder="Password" required>
            <button type="submit" class="login-btn">Login</button>
        </form>
        <div class="text-register">
            Belum punya akun? 
            <a href="registrasi.php" style="color:#b7e4c7; text-decoration:underline;">Registrasi di sini</a>
            <br>
            <a href="index.php" style="color:#fff; text-decoration:underline; font-weight:600;">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>