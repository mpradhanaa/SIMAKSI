<?php
$host = "localhost";
$user = "root";     // sesuaikan dengan user MySQL kamu
$pass = "";         // sesuaikan juga jika ada password
$db   = "e-simaksi";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>