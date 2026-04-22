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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas - Haul Out .Co</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
</head>
<body class="page-shell">

<div class="container">
    <div class="panel-card">
        <div class="panel-body">
            <div class="section-header">
                <div>
                    <h1 class="page-title">Dashboard Petugas</h1>
                    <p class="page-subtitle">Halo <strong><?= $_SESSION['username']; ?></strong>, pantau pengajuan dan kondisi armada secara real-time.</p>
                </div>
            </div>

            <div class="grid-stats">
        <div class="card-stat card-stat--warning">
            <p>Butuh Persetujuan</p>
            <h3><?= $data_pending['total']; ?></h3>
        </div>
        <div class="card-stat card-stat--success">
            <p>Truk Sedang Jalan</p>
            <h3><?= $data_jalan['total']; ?></h3>
        </div>
            </div>

            <div class="page-actions">
        <a href="approval.php" class="btn btn-tambah">Persetujuan Peminjaman</a>
        <a href="laporan.php" class="btn btn-edit">Laporan Transaksi</a>
        <a href="../auth/logout.php" class="btn btn-hapus">Logout</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>