<?php
include 'koneksi.php';
session_start();

// login dan role admin
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit;
}

// Proses update status simaksi jika ada POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi_konfirmasi'], $_POST['simaksi_id'], $_POST['status'])) {
    $simaksi_id = intval($_POST['simaksi_id']);
    $status = $_POST['status'];
    if (in_array($status, ['disetujui', 'ditolak', 'pending'])) {
        $stmt = mysqli_prepare($conn, "UPDATE simaksi SET status=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "si", $status, $simaksi_id);
        mysqli_stmt_execute($stmt);
    }
}

// Ambil data pengajuan simaksi beserta jumlah peserta
$sql = "SELECT s.id, s.nomor_formulir, s.jenis_kegiatan, s.tgl_berangkat, s.tgl_pulang, s.status, u.fullname, u.email,
        (SELECT COUNT(*) FROM anggota a WHERE a.simaksi_id = s.id) AS jumlah_peserta
        FROM simaksi s
        JOIN users u ON s.user_id = u.id
        ORDER BY s.created_at DESC";
$result = mysqli_query($conn, $sql);

// Ambil detail anggota jika ada permintaan detail
$anggota_list = [];
if (isset($_GET['detail']) && is_numeric($_GET['detail'])) {
    $simaksi_id_detail = intval($_GET['detail']);
    $q_anggota = mysqli_query($conn, "SELECT * FROM anggota WHERE simaksi_id=$simaksi_id_detail");
    while ($anggota = mysqli_fetch_assoc($q_anggota)) {
        $anggota_list[] = $anggota;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Simaksi UPAS HILL</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>
<body>
    <!-- header -->
    <header>
        <div>
            <h1>E-Simaksi UPAS HILL</h1>
        </div>
        <!-- nav header -->
        <nav class="nav-header">
            <ul class="nav-header-ul"></ul>
            <?php if(isset($_SESSION['nama'])): ?>
            <div class="nav-user-admin">
                <span class="nav-user-name">Hello, <?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                <form action="logout.php" method="post" style="display:inline;">
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
            <?php endif; ?>
        </nav>

        <div class="page-header">
            <div class="page-header-content">
                <h3 class="text-white">E-SIMAKSI UPAS HILL</h3>
                <P class="text-white">Aplikasi Perizinan Masuk Kawasan Konservasi Online (e-SIMAKSI) merupakan aplikasi digital layanan publik yang 
                    digunakan untuk mengajukan permohonan surat izin masuk kawasan konservasi di Taman Nasional Gunung Tangkuban Perahu
                    Puncak UPAS HILL.</P>
            </div>
        </div>
        <div class="row">
            <div class="nav-list">
                <ul class="nav-list-ul">
                </ul>
            </div>
        </div>

        <div class="container-fluid">
            <div class="tab-content">
                <div class="tab-pane-active">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <img src="foto/foto 1.jpg" alt="foto" class="card-img">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <img src="foto/foto 2.jpg" alt="foto" class="card-img">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <img src="foto/foto 3.jpg" alt="foto" class="card-img">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <img src="foto/foto 4.jpg" alt="foto" class="card-img">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <img src="foto/foto 5.jpg" alt="foto" class="card-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- main content -->
    <div class="container-main">
        <div class="row-main">
            <div class="col-md-12">
                <div class="card-main">
                    <h3 style="color:#40916c; margin-bottom:18px;">Daftar Pengajuan SIMAKSI</h3>
                    <div style="overflow-x:auto;">
                        <table class="table-simaksi" data-aos="fade-up">
                            <thead>
                                <tr>
                                    <th>No. Formulir</th>
                                    <th>Nama Pemohon</th>
                                    <th>Email</th>
                                    <th>Jenis Kegiatan</th>
                                    <th>Tgl Berangkat</th>
                                    <th>Tgl Pulang</th>
                                    <th>Jumlah Peserta</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['nomor_formulir']); ?></td>
                                    <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['jenis_kegiatan']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tgl_berangkat']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tgl_pulang']); ?></td>
                                    <td>
                                        <span style="font-weight:600; color:#40916c;">
                                            <?php echo (int)$row['jumlah_peserta']; ?> Orang
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                            $status = $row['status'];
                                            $badgeClass = $status === 'disetujui' ? 'badge-disetujui' : ($status === 'ditolak' ? 'badge-ditolak' : 'badge-pending');
                                        ?>
                                        <span class="badge-status <?php echo $badgeClass; ?>">
                                            <?php echo ucfirst($status); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form method="post" style="display:flex; gap:6px; align-items:center; justify-content:center;">
                                            <input type="hidden" name="simaksi_id" value="<?php echo $row['id']; ?>">
                                            <select name="status" style="padding:4px 8px; border-radius:5px;">
                                                <option value="disetujui" <?php if($status=='disetujui') echo 'selected'; ?>>Disetujui</option>
                                                <option value="ditolak" <?php if($status=='ditolak') echo 'selected'; ?>>Ditolak</option>
                                                <option value="pending" <?php if($status=='pending') echo 'selected'; ?>>Pending</option>
                                            </select>
                                            <button type="submit" name="aksi_konfirmasi" style="padding:4px 10px; border-radius:5px; background:#40916c; color:#fff; border:none; cursor:pointer;">Simpan</button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="?detail=<?php echo $row['id']; ?>" style="color:#40916c; font-weight:600; text-decoration:underline;">Lihat</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if (!empty($anggota_list)): ?>
                    <!-- Modal/Box Detail Data SIMAKSI -->
                    <div style="margin:32px 0; background:#f8fafb; border-radius:10px; box-shadow:0 2px 8px #b7e4c7; padding:24px;">
                        <h4 style="color:#40916c; margin-bottom:16px;">Detail Peserta SIMAKSI</h4>
                        <table style="width:100%; border-collapse:collapse;">
                            <thead>
                                <tr style="background:#b7e4c7;">
                                    <th style="padding:6px;">Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tgl Lahir</th>
                                    <th>Telp</th>
                                    <th>Pekerjaan</th>
                                    <th>Kebangsaan</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($anggota_list as $a): ?>
                                <tr>
                                    <td style="padding:6px;"><?php echo htmlspecialchars($a['nama']); ?></td>
                                    <td><?php echo htmlspecialchars($a['jk']); ?></td>
                                    <td><?php echo htmlspecialchars($a['tgl_lahir']); ?></td>
                                    <td><?php echo htmlspecialchars($a['telp']); ?></td>
                                    <td><?php echo htmlspecialchars($a['pekerjaan']); ?></td>
                                    <td><?php echo htmlspecialchars($a['kebangsaan']); ?></td>
                                    <td><?php echo htmlspecialchars($a['email']); ?></td>
                                    <td><?php echo htmlspecialchars(ucfirst($a['status'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div style="margin-top:18px;">
                            <a href="admin.php" style="background:#40916c; color:#fff; padding:8px 18px; border-radius:6px; text-decoration:none;">Tutup Detail</a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-social">
            <a href="#" target="_blank" aria-label="Instagram" class="footer-icon">
                <img src="foto/ig.png" alt="Instagram Icon" class="footer-icon-img">
            </a>
            <a href="#" target="_blank" aria-label="WhatsApp" class="footer-icon">
                <img src="foto/wa.png" alt="WhatsApp Icon" class="footer-icon-img-wa">
            </a>
            <a href="#" target="_blank" aria-label="YouTube" class="footer-icon">
                <img src="foto/yt.png" alt="YouTube Icon" class="footer-icon-img">
            </a>
        </div>
        <span class="copyright">Copyright&copy; 2025 E-Simaksi UPAS HILL By mpradhanaa</span>
    </div>
</footer>
</body>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init();
</script>
</html>
