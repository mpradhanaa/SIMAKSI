<?php
include 'koneksi.php'; // koneksi ke database
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php'); // Redirect ke halaman login jika belum login
    exit();
}
$user_id = $_SESSION['user_id'];

$alertMsg = '';
$nomor_formulir = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $jenis_kegiatan = $_POST['jenis_kegiatan'];
    $tgl_berangkat = $_POST['tgl_berangkat'];
    $tgl_pulang = $_POST['tgl_pulang'];

    // Generate nomor unik: SIMAKSI-YYYYMMDD-xxxx
    $tgl = date('Ymd');
    $query = mysqli_query($conn, "SELECT COUNT(*) as total FROM simaksi WHERE DATE(created_at)=CURDATE()");
    $row = mysqli_fetch_assoc($query);
    $urut = str_pad($row['total'] + 1, 4, '0', STR_PAD_LEFT);
    $nomor_formulir = "SIMAKSI-$tgl-$urut";

    // Simpan ke tabel simaksi
    $sql = "INSERT INTO simaksi (user_id, jenis_kegiatan, tgl_berangkat, tgl_pulang, nomor_formulir, status)
            VALUES (?, ?, ?, ?, ?, 'pending')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issss", $user_id, $jenis_kegiatan, $tgl_berangkat, $tgl_pulang, $nomor_formulir);
    mysqli_stmt_execute($stmt);
    $simaksi_id = mysqli_insert_id($conn);

    // Simpan data ketua
    $nama_ketua = $_POST['nama_ketua'];
    $kebangsaan_ketua = $_POST['kebangsaan_ketua'];
    $tgl_lahir_ketua = $_POST['tgl_lahir_ketua'];
    $jk_ketua = $_POST['jk_ketua'];
    $telp_ketua = $_POST['telp_ketua'];
    $pekerjaan_ketua = $_POST['pekerjaan_ketua'];
    $email_ketua = $_POST['email_ketua'];

    $sql_ketua = "INSERT INTO anggota (simaksi_id, nama, kebangsaan, tgl_lahir, jk, telp, pekerjaan, email, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'ketua')";
    $stmt_ketua = mysqli_prepare($conn, $sql_ketua);
    mysqli_stmt_bind_param($stmt_ketua, "isssssss", $simaksi_id, $nama_ketua, $kebangsaan_ketua, $tgl_lahir_ketua, $jk_ketua, $telp_ketua, $pekerjaan_ketua, $email_ketua);
    mysqli_stmt_execute($stmt_ketua);

    // Simpan data anggota
    $nama_anggota = $_POST['anggota_nama'];
    $jk_anggota = $_POST['anggota_jk'];
    $tgl_lahir_anggota = $_POST['anggota_tgl_lahir'];
    $telp_anggota = $_POST['anggota_telp'];
    $pekerjaan_anggota = $_POST['anggota_pekerjaan'];
    $kebangsaan_anggota = $_POST['anggota_kebangsaan'];

    foreach ($nama_anggota as $key => $value) {
        if (!empty($value)) {
            $sql_anggota = "INSERT INTO anggota (simaksi_id, nama, jk, tgl_lahir, telp, pekerjaan, kebangsaan, status)
                            VALUES (?, ?, ?, ?, ?, ?, ?, 'anggota')";
            $stmt_anggota = mysqli_prepare($conn, $sql_anggota);
            mysqli_stmt_bind_param($stmt_anggota, "issssss", $simaksi_id, $value, $jk_anggota[$key], $tgl_lahir_anggota[$key], $telp_anggota[$key], $pekerjaan_anggota[$key], $kebangsaan_anggota[$key]);
            mysqli_stmt_execute($stmt_anggota);
        }
    }

    // Set pesan alert untuk JavaScript
    $alertMsg = "Formulir berhasil dikirim! Nomor Formulir Anda: $nomor_formulir";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Kegiatan | E-SIMAKSI UPAS HILL</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form-simaksi.css">
</head>
<body>
<div class="form-container">
    <div class="form-title">Formulir E-SIMAKSI UPAS HILL</div>
    <?php if (!empty($alertMsg)): ?>
        <div class="alert-success" id="alertSimaksi">
            <?php echo htmlspecialchars($alertMsg); ?>
        </div>
        <a href="index.php" class="btn-beranda">Kembali ke Beranda</a>
        <script>
            // Tampilkan alert pop-up juga
            alert("<?php echo addslashes($alertMsg); ?>");
        </script>
    <?php endif; ?>
    <?php if (empty($alertMsg)): ?>
    <form method="post" action="">
        <!-- Jadwal Kegiatan -->
        <div class="form-section">
            <h4>Jadwal Kegiatan</h4>
            <div class="form-group">
                <label for="tgl_berangkat">Tanggal Berangkat</label>
                <input type="date" id="tgl_berangkat" name="tgl_berangkat" required>
            </div>
            <div class="form-group">
                <label for="tgl_pulang">Tanggal Pulang</label>
                <input type="date" id="tgl_pulang" name="tgl_pulang" required>
            </div>
            <div class="form-group">
                <label for="jenis_kegiatan">Jenis Kegiatan</label>
                <select id="jenis_kegiatan" name="jenis_kegiatan" required>
                    <option value="">Pilih Jenis Kegiatan</option>
                    <option value="Camping">Camping</option>
                    <option value="Hiking">Hiking</option>
                    <option value="Camping+Hiking">Camping + Hiking</option>
                </select>
            </div>
        </div>
        <!-- Data Ketua Kelompok -->
        <div class="form-section">
            <h4>Data Diri Ketua Kelompok</h4>
            <div class="form-group">
                <label for="nama_ketua">Nama</label>
                <input type="text" id="nama_ketua" name="nama_ketua" required>
            </div>
            <div class="form-group">
                <label for="kebangsaan_ketua">Kebangsaan</label>
                <input type="text" id="kebangsaan_ketua" name="kebangsaan_ketua" required>
            </div>
            <div class="form-group">
                <label for="tgl_lahir_ketua">Tanggal Lahir</label>
                <input type="date" id="tgl_lahir_ketua" name="tgl_lahir_ketua" required>
            </div>
            <div class="form-group">
                <label for="jk_ketua">Jenis Kelamin</label>
                <select id="jk_ketua" name="jk_ketua" required>
                    <option value="">Pilih</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="telp_ketua">No. Telp</label>
                <input type="text" id="telp_ketua" name="telp_ketua" required>
            </div>
            <div class="form-group">
                <label for="pekerjaan_ketua">Pekerjaan</label>
                <input type="text" id="pekerjaan_ketua" name="pekerjaan_ketua" required>
            </div>
            <div class="form-group">
                <label for="email_ketua">Email</label>
                <input type="email" id="email_ketua" name="email_ketua" required>
            </div>
        </div>
        <!-- Data Anggota -->
        <div class="form-section">
            <h4>Data Anggota Kelompok</h4>
            <table class="anggota-table" id="anggotaTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>No. Telp</th>
                        <th>Pekerjaan</th>
                        <th>Kebangsaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Baris anggota akan ditambah lewat JS -->
                </tbody>
            </table>
            <button type="button" class="btn-tambah" onclick="tambahAnggota()">+ Tambah Anggota</button>
        </div>
        <button type="submit" class="btn-submit">Kirim Formulir</button>
        <a href="index.php" class="btn-beranda" style="margin-left:16px; background:#b7e4c7; color:#222;">Kembali ke Beranda</a>
    </form>
    <?php endif; ?>
</div>
<script>
function tambahAnggota(data = {}) {
    const table = document.getElementById('anggotaTable').getElementsByTagName('tbody')[0];
    const row = table.insertRow();
    row.innerHTML = `
        <td><input type="text" name="anggota_nama[]" value="${data.nama||''}" required></td>
        <td>
            <select name="anggota_jk[]" required>
                <option value="">Pilih</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </td>
        <td><input type="date" name="anggota_tgl_lahir[]" value="${data.tgl_lahir||''}" required></td>
        <td><input type="text" name="anggota_telp[]" value="${data.telp||''}" required></td>
        <td><input type="text" name="anggota_pekerjaan[]" value="${data.pekerjaan||''}" required></td>
        <td><input type="text" name="anggota_kebangsaan[]" value="${data.kebangsaan||''}" required></td>
        <td><button type="button" class="btn-hapus" onclick="hapusBaris(this)">Hapus</button></td>
    `;
}
function hapusBaris(btn) {
    const row = btn.closest('tr');
    row.parentNode.removeChild(row);
}
</script>
</body>
</html>