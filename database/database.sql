-- File: database.sql

-- Tabel users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role ENUM('admin','user') DEFAULT 'user'
);

-- Tabel simaksi (pengajuan)
CREATE TABLE simaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    users_id INT NOT NULL,
    jenis_kegiatan ENUM('Camping', 'Hiking', 'Camping+Hiking') NOT NULL,
    tgl_berangkat DATE NOT NULL,
    tgl_pulang DATE NOT NULL,
    nomor_formulir VARCHAR(50) UNIQUE,
    status ENUM('pending','disetujui','ditolak') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

-- Tabel anggota (untuk ketua dan anggota, status: 'ketua'/'anggota')
CREATE TABLE anggota (
    id INT AUTO_INCREMENT PRIMARY KEY,
    simaksi_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    jk ENUM('Laki-laki', 'Perempuan') NOT NULL,
    tgl_lahir DATE NOT NULL,
    telp VARCHAR(20) NOT NULL,
    pekerjaan VARCHAR(100) NOT NULL,
    kebangsaan VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    status ENUM('ketua','anggota') NOT NULL,
    FOREIGN KEY (simaksi_id) REFERENCES simaksi(id) ON DELETE CASCADE
);

-- Contoh data admin
INSERT INTO users (fullname, username, email, password, role)
VALUES ('Admin Upas Hill', 'admin', 'admin@upashill.com', 'admin123', 'admin');

