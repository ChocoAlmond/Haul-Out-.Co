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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Haul Out .Co</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
</head>
<body class="page-shell">

<div class="container">
    <div class="panel-card">
        <div class="panel-body">
            <div class="section-header">
                <div>
                    <h1 class="page-title">Dashboard Admin</h1>
                    <p class="page-subtitle">Selamat datang, <strong><?php echo $_SESSION['username']; ?></strong>. Gunakan panel ini untuk mengelola armada, pengguna, dan laporan.</p>
                </div>
            </div>

            <div class="grid-stats">
        <div class="card-stat card-stat--info">
            <p>Total Armada</p>
            <h3><?php echo $data_truk['total']; ?></h3>
        </div>
        <div class="card-stat card-stat--success">
            <p>Total Pengguna</p>
            <h3><?php echo $data_user['total']; ?></h3>
        </div>
        <div class="card-stat card-stat--warning">
            <p>Truk Sedang Jalan</p>
            <h3><?php echo $data_pinjam['total']; ?></h3>
        </div>
    </div>

    <div class="page-actions">
        <a href="data_truk.php" class="btn btn-tambah">Kelola Truk</a>
        <a href="data_kategori.php" class="btn btn-tambah">Kelola Kategori</a>
        <a href="data_user.php" class="btn btn-tambah">Manajemen User</a>
        <a href="log_aktivitas.php" class="btn btn-edit">Log Aktivitas</a>
        <a href="../auth/logout.php" class="btn btn-hapus">Logout</a>
    </div>
        </div>
    </div>
</div>

</body>
</html>