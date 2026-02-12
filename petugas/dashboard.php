<?php
session_start();
include '../config/db.php';

// Proteksi: Hanya Petugas yang boleh masuk
if ($_SESSION['role'] != 'Petugas') {
    header("location:../login.php");
    exit;
}

// Statistik Petugas: Hitung pengajuan yang masih 'Pending'
$count_pending = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status_approval = 'Pending'");
$data_pending = mysqli_fetch_assoc($count_pending);

// Hitung total truk yang sedang jalan (Disetujui)
$count_jalan = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE status_approval = 'Disetujui'");
$data_jalan = mysqli_fetch_assoc($count_jalan);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Petugas - Haul Out .Co</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
</head>
<body>

<div class="container">
    <p>Haul Out .Co</p>
    <h2>Panel Petugas Operasional</h2>
    <p>Halo <strong><?= $_SESSION['username']; ?></strong>, selamat bertugas! Pantau terus pengajuan driver di bawah ini.</p>

    <div class="grid-stats">
        <div class="card-stat" style="background: #f39c12;">
            <p>Butuh Persetujuan</p>
            <h3><?= $data_pending['total']; ?></h3>
        </div>
        <div class="card-stat" style="background: #27ae60;">
            <p>Truk Sedang Jalan</p>
            <h3><?= $data_jalan['total']; ?></h3>
        </div>
    </div>

    <hr>

    <h3>Menu Kendali</h3>
    <div style="display: flex; gap: 10px; margin-top: 15px;">
        <a href="approval.php" class="btn btn-tambah">Persetujuan Peminjaman</a>
        <a href="laporan.php" class="btn btn-edit">Laporan Transaksi</a>
        <a href="../auth/logout.php" class="btn btn-hapus">Logout</a>
    </div>
</div>

</body>
</html>