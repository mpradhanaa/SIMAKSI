<?php
session_start();
include 'koneksi.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Simaksi UPAS HILL</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- header -->
    <header>
        <div>
            <h1>E-Simaksi UPAS HILL</h1>
        </div>
        <!-- nav header -->
        <nav class="nav-header">
            <ul class="nav-header-ul">
                <?php if(isset($_SESSION['nama'])): ?>
                <div class="nav-user" style="display:flex; align-items:center; position:absolute; right:32px; top:24px; gap:14px;">
                    <span class="nav-user-name">hello, <?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                    <form action="logout.php" method="post" style="display:inline;">
                        <button type="submit" class="btn-logout" style="background:#d90429; color:#fff; border:none; border-radius:6px; padding:6px 16px; font-weight:600; cursor:pointer; margin-left:8px;">Logout</button>
                    </form>
                </div>
                <?php endif; ?>
                <li class="nav-header-li dropdown">
                    <a href="#home">Beranda</a>
                    <ul class="dropdown-menu">
                        <li><a href="#tatacara-esimaksi">Tata Cara Pengajuan Simaksi</a></li>
                        <li><a href="#syarat-ketentuan">Syarat dan Ketentuan</a></li>
                    </ul>
                </li>
                <li class="nav-header-li dropdown">
                    <a href="#about">Simaksi</a>
                    <ul class="dropdown-menu">
                        <li><a href="form-simaksi.php">Formulir E-SIMAKSI</a></li>
                    </ul>
                </li>

                <li class="nav-header-li dropdown">
                    <a href="#contact">Registrasi</a>
                    <ul class="dropdown-menu">
                        <li><a href="login.php">Login</a></li>
                        <li><a href="registrasi.php">Register</a></li>
                    </ul>
                </li>
            </ul>
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
                        <form class="nav-list-ul" action="cek-status.php" method="get">
                            <input  type="text" name="nomor" placeholder="Masukkan Nomor Formulir" required>
                            <button type="submit">Cek Status</button>
                        </form>
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
                    <div class="row">
                        <div id="tatacara-esimaksi" class="col-md-6">
                            <div class="card-header">
                                <h5>
                                    <b>Tata Cara Pengajuan E-Simaksi</b>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline-custom">
                                    <div class="outer-custom">
                                        <div class="card-custom">
                                            <div class="info-custom">
                                                <h3>Registrasi Online</h3>
                                                <p>Pengguna dapat melakukan registrasi secara online melalui website E-Simaksi TNGTP Upas Hill. 
                                                    Anda perlu mengisi informasi dasar seperti nama dan alamat email. 
                                                    Jika sudah memiliki akun maka silahkan LOGIN untuk melakukan pengajuan E-Simaksi.</p>
                                            </div>
                                        </div>
                                        <div class="card-custom">
                                            <div class="info-custom">
                                                <h3>Verifikasi Akun</h3>
                                                <p>Setelah berhasil mendaftar, akan diminta untuk melakukan verifikasi akun melalui email. 
                                                    Anda akan menerima email berupa kode ataupun tautan yang bisa digunakan untuk verifikasi. 
                                                    Konfirmasi ini memastikan keamanan dan validasi informasi sebagai pengguna yang sah.</p>
                                            </div>
                                        </div>
                                        <div class="card-custom">
                                            <div class="info-custom">
                                                <h3>Pilih Jenis Kegiatan</h3>
                                                <p>Terdapat dua Jenis Kegiatan yang dapat dipilih ketika mengajukan
                                                    E-Simaksi, Pilih salah satu jenis kegiatan diantaranya Camping, dan TekTok.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="card-custom">
                                            <div class="info-custom">
                                                <h3>Isi Data permohonan</h3>
                                                <p>Anda diminta untuk mengisi formulir data diri serta detail kegiatan yang akan anda ajukan. 
                                                    Pastikan untuk memberikan informasi yang akurat dan lengkap. 
                                                    Jika diperlukan periksa kembali data untuk menghindari kesalahan input.</p>
                                            </div>
                                        </div>
                                        <div class="card-custom">
                                            <div class="info-custom">
                                                <h3>Persetujuan Form Pernyataan</h3>
                                                <p>Setelah mengisi formulir, Anda diminta untuk menyetujui pernyataan persetujuan yang berisi komitmen untuk mematuhi semua aturan dan regulasi
                                                    yang berlaku terkait dengan kegiatan yang diajukan. 
                                                    Pastikan membaca dengan seksama dan memahamai persyaratan yang tercantum.</p>
                                            </div>
                                        </div>
                                        <div class="card-custom">
                                            <div class="info-custom">
                                                <h3>Pengajuan E-Simaksi</h3>
                                                <p>Setelah semua langkah di atas selesai, Anda dapat mengirimkan permohonan E-Simaksi. 
                                                    Pastikan semua informasi sudah benar dan lengkap sebelum mengirimkan permohonan.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6" id="syarat-ketentuan">
        <div class="card-custom" style="margin-top:24px;">
            <div class="info-custom">
                <h3 class="s-k">Syarat dan Ketentuan</h3>
                    <div class="columns">
                            <div class="column">
                                <h4>Persyaratan Umum</h4>
                                    <ul>
                                        <li>Pakaian yang Nyaman<br>
                                                <span class="note">Pakaian yang nyaman dan bisa menyerap keringat</span>
                                            </li>
                                        <li>Sepatu yang tepat<br>
                                                <span class="note">Apabika melakukan trekking gunakan sepatu yang nyaman, dengan desain untuk berjalan dimedan
                                                    yang tidak rata, dan bisa melindungi atau menjaga kaki dari medan.
                                                </span>
                                            </li>
                                        <li>Persiapan Fisik<br>
                                                <span class="note">Trekking di Upas Hill membutuhkan stamina yang cukup, jadi pastikan Anda memiliki
                                                    persiapan yang siap dan memadai.</span>
                                            </li>
                                        <li>Perlengkapan Tambahan <br>
                                                <span class="note">Perlengkapan tambahan seperti jaket, topi, sarung tangan, mantel hujan, dan 
                                                    perlindungan lainnya sesuai kebutuhan
                                                </span>
                                            </li>
                                        <li>Peraturan UMUM<br>
                                                <span class="note">Jaga kebersihan lingkungan, jangan merusak tanaman, dan ikuti aturan yang berlaku
                                                    dilokasi.
                                                </span>
                                            </li>
                                        <li>Adminitrasi<br>
                                                <span class="note">Biaya Adminitrasi terbagi dalam beberapa yang Pertama,
                                                    adalah biaya SIMAKSI sebesar Rp. 20.000,00 per orang, dan yang Kedua biaya Parkir 
                                                    sebesar Rp. 5.000,00 untuk motor, dan Rp. 10.000,00 untuk mobil.
                                                </span>
                                        </ul>
                                    </div>
                                    <div class="column">
                                        <h4>Ketentuan Umum</h4>
                                        <ul>
                                            <li>Penyewaan Pemandu (Opsional)<br>
                                                <span class="note">Meskipun trekking di Upas Hill relatif landai dan mudah,
                                                    penyewaan pemandu bisa membantu Anda mengenal rute dengan lebih baik dan memastikan keamanan ketika trekking.</span>
                                            </li>
                                        <li>Rute Trekking<br>
                                                <span class="note"> Ada beberapa rute yang bisa dipilih, termasuk Trekk 11 yang terkenal yang bisa memakan waktu sekitar
                                                    1,5 jam untuk mencapai puncak. dan yang kami tawarkan untuk saat ini melalui Trek 11 Sukawana.
                                                </span>
                                            </li>
                                        <li>Perawatan Kesehatan<br>
                                                <span class="note">Pastikan Anda dalam kondisi kesehatan yang baik sebelum memulai trekking, dan jangan lupa membawa obat-obatan pribadi jika 
                                                    diperlukan.</span>
                                            </li>
                                        <li>Pengalaman Trekking<br>
                                                <span class="note">Upas Hill cocok untuk pendaki pemula dan menawarkan pemandangan alam yang menakjubkan.</span>
                                            </li>
                                        <li>Ketinggian<br>
                                                <span class="note">Upas Hill terletak di ketinggian 2.084 meter diatas permukaan laut.
                                                </span>
                                            </li>
                                        <li>Kawasan Camping Ground<br>
                                                <span class="note">Anda dapat melakukan camping diarea yang telah ditentukan yaitu, dikawasan camping ground. Anda tidak diperkenankan
                                                    melakukan camping dipuncak Upas Hill.
                                                </span>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
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
</html>
