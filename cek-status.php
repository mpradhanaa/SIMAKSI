<?php
include 'koneksi.php';
$statusMsg = '';
$alertClass = '';

if (isset($_GET['nomor'])) {
    $nomor = htmlspecialchars($_GET['nomor']);
    $q = mysqli_query($conn, "SELECT status FROM simaksi WHERE nomor_formulir='$nomor'");
    if ($row = mysqli_fetch_assoc($q)) {
        $status = ucfirst($row['status']);
        if ($row['status'] == 'disetujui') {
            $alertClass = 'alert-success';
        } elseif ($row['status'] == 'ditolak') {
            $alertClass = 'alert-danger';
        } else {
            $alertClass = 'alert-warning';
        }
        $statusMsg = "Status Formulir <b>$nomor</b>: <b>$status</b>";
    } else {
        $alertClass = 'alert-danger';
        $statusMsg = "Nomor formulir <b>$nomor</b> tidak ditemukan.";
    }
} else {
    // Jika tidak ada nomor, redirect ke halaman utama
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Formulir | E-SIMAKSI UPAS HILL</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cek-status.css">
</head>
<body>
    <div class="cek-status-container">
        <div class="cek-status-title">Informasi Status Pengajuan SIMAKSI</div>
        <?php if ($statusMsg): ?>
            <div class="<?php echo $alertClass; ?>"><?php echo $statusMsg; ?></div>
        <?php endif; ?>
        <a href="index.php" style="margin-top:18px; background:#40916c; color:#fff; padding:8px 22px; border-radius:6px; text-decoration:none; font-weight:600; display:inline-block;">Kembali ke Beranda</a>
    </div>
</body>
</html>

