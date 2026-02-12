<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Petugas') header("location:../index.php");

// Query Relasional untuk Laporan Lengkap [cite: 48]
$query = "SELECT p.*, u.username, t.plat_nomor, k.tgl_kembali_aktual, k.denda 
          FROM peminjaman p
          JOIN users u ON p.id_user = u.id_user
          JOIN truk t ON p.id_truk = t.id_truk
          LEFT JOIN pengembalian k ON p.id_pinjam = k.id_pinjam";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman Truk</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
</head>
<body>
<div class="container">
    <p>Haul Out .Co</p>
    <h2>Laporan Peminjaman & Pengembalian</h2><br>
    <button onclick="window.print()" class="btn btn-tambah">Cetak Laporan (Print)</button>
    
    <table>
        <thead>
            <tr>
                <th>Peminjam</th>
                <th>Truk</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali (Rencana)</th>
                <th>Tgl Kembali (Realisasi)</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['username'] ?></td>
                <td><?= $row['plat_nomor'] ?></td>
                <td><?= $row['tgl_pinjam'] ?></td>
                <td><?= $row['tgl_kembali_rencana'] ?></td>
                <td><?= $row['tgl_kembali_aktual'] ?? '-' ?></td>
                <td>Rp <?= number_format($row['denda'] ?? 0, 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn btn-tambah">Kembali ke Dashboard</a>
</div>
</body>
</html>