<?php
session_start();
include '../config/db.php';

// Proteksi: Cek apakah yang masuk benar-benar Admin
if ($_SESSION['role'] != 'Admin') {
    header("location:../index.php");
    exit;
}

// Mengambil data statistik untuk ringkasan di Dashboard
$count_truk = mysqli_query($conn, "SELECT COUNT(*) as total FROM truk");
$data_truk = mysqli_fetch_assoc($count_truk);

$count_user = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$data_user = mysqli_fetch_assoc($count_user);

$count_pinjam = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status_approval = 'Disetujui'");
$data_pinjam = mysqli_fetch_assoc($count_pinjam);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Haul Out .Co</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
    <style>
        /* Tambahan style khusus dashboard agar lebih visual */
        .grid-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card-stat {
            background: #34495e;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .card-stat h3 { margin: 0; font-size: 2em; }
        .menu-admin {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>

<div class="container">
    <p>Haul Out .Co</p>
    <h2>Dashboard Admin</h2>
    <p>Selamat datang, <strong><?php echo $_SESSION['username']; ?></strong>. Panel ini digunakan untuk mengelola data master sistem.</p>

    <div class="grid-stats">
        <div class="card-stat">
            <p>Total Armada</p>
            <h3><?php echo $data_truk['total']; ?></h3>
        </div>
        <div class="card-stat" style="background: #27ae60;">
            <p>Total Pengguna</p>
            <h3><?php echo $data_user['total']; ?></h3>
        </div>
        <div class="card-stat" style="background: #2980b9;">
            <p>Truk Sedang Jalan</p>
            <h3><?php echo $data_pinjam['total']; ?></h3>
        </div>
    </div>

    <hr>

    <h3>Menu Navigasi Utama</h3>
    <div class="menu-admin">
        <a href="data_truk.php" class="btn btn-tambah">Kelola Truk</a>
        <a href="data_kategori.php" class="btn btn-tambah">Kelola Kategori</a>
        <a href="data_user.php" class="btn btn-tambah">Manajemen User</a>
        <a href="log_aktivitas.php" class="btn btn-edit">Log Aktivitas</a>
        <a href="../auth/logout.php" class="btn btn-hapus">Logout</a>
    </div>
</div>

</body>
</html>