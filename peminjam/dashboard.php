<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Peminjam') header("location:../index.php");

$id_user = $_SESSION['id_user'];
// Ambil daftar truk yang sedang dipinjam user ini
$cek_pinjam = mysqli_query($conn, "SELECT peminjaman.*, truk.*, kategori_truk.nama_kategori 
                                    FROM peminjaman 
                                    JOIN truk ON peminjaman.id_truk = truk.id_truk 
                                    JOIN kategori_truk ON truk.id_kategori = kategori_truk.id_kategori
                                    WHERE peminjaman.id_user = '$id_user' AND peminjaman.status_approval = 'Disetujui'");
$total_pinjam = mysqli_num_rows($cek_pinjam);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peminjam</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
</head>
<body class="page-shell">
<div class="container">
    <div class="panel-card">
        <div class="panel-body">
            <div class="section-header">
                <div>
                    <h1 class="page-title">Dashboard Peminjam</h1>
                    <p class="page-subtitle">Halo <strong><?= $_SESSION['username']; ?></strong>, kamu sedang meminjam <strong><?= $total_pinjam; ?></strong> truk saat ini.</p>
                </div>
            </div>
            <?php if($total_pinjam > 0) { ?>
            <div class="panel-block">
        <h3>📦 Truk yang Sedang Dipinjam</h3>
        <div class="cards-grid">
            <?php while($truck = mysqli_fetch_assoc($cek_pinjam)) { ?>
                <div class="truck-card">
                    <div class="truck-card-header">
                        <div class="truck-card-title"><?= htmlspecialchars($truck['plat_nomor']) ?></div>
                        <span class="badge dipinjam">Dipinjam</span>
                    </div>
                    
                    <div class="truck-card-info">
                        <div class="truck-card-info-item">
                            <span class="truck-card-info-label">Merk</span>
                            <span class="truck-card-info-value"><?= htmlspecialchars($truck['merk']) ?></span>
                        </div>
                        <div class="truck-card-info-item">
                            <span class="truck-card-info-label">Kategori</span>
                            <span class="truck-card-info-value"><?= htmlspecialchars($truck['nama_kategori']) ?></span>
                        </div>
                        <div class="truck-card-info-item">
                            <span class="truck-card-info-label">Tanggal Peminjaman</span>
                            <span class="truck-card-info-value"><?= htmlspecialchars($truck['tgl_pinjam']) ?></span>
                        </div>
                        <div class="truck-card-info-item">
                            <span class="truck-card-info-label">Rencana Pengembalian</span>
                            <span class="truck-card-info-value"><?= htmlspecialchars($truck['tgl_kembali_rencana']) ?></span>
                        </div>
                        <div class="truck-card-info-item">
                            <span class="truck-card-info-label">Harga/Hari</span>
                            <span class="truck-card-info-value">Rp <?= number_format($truck['harga_per_hari'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
    
    <div class="dashboard-nav">
        <a href="daftar_truk.php" class="btn btn-tambah">Cari & Pinjam Truk</a>
        <a href="kembalikan.php" class="btn btn-tambah">Pengembalian</a>
        <a href="riwayat_pinjam.php" class="btn btn-edit">Riwayat Peminjaman</a>
        <a href="../auth/logout.php" class="btn btn-hapus">Logout</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>