<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Petugas') header("location:../index.php");

// Ambil data peminjaman yang masih 'Pending'
$query = "SELECT peminjaman.*, users.username, truk.plat_nomor 
          FROM peminjaman 
          JOIN users ON peminjaman.id_user = users.id_user 
          JOIN truk ON peminjaman.id_truk = truk.id_truk 
          WHERE status_approval = 'Pending'";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Peminjaman - Haul Out .Co</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
</head>
<body class="page-shell">
<div class="container">
    <div class="panel-card">
        <div class="panel-body">
            <div class="section-header">
                <div>
                    <h1 class="page-title">Persetujuan Peminjaman</h1>
                    <p class="page-subtitle">Kelola pengajuan peminjaman yang masih menunggu keputusan.</p>
                </div>
            </div>
            <div class="table-wrapper">
                <table>
    <tr>
        <th>Peminjam</th>
        <th>Truk</th>
        <th>Tgl Pinjam</th>
        <th>Aksi</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['username']; ?></td>
        <td><?= $row['plat_nomor']; ?></td>
        <td><?= $row['tgl_pinjam']; ?></td>
        <td>
            <a href="aksi_approval.php?id=<?= $row['id_pinjam']; ?>&status=Disetujui" class="btn btn-edit">Setujui</a> | 
            <a href="aksi_approval.php?id=<?= $row['id_pinjam']; ?>&status=Ditolak" class="btn btn-hapus">Tolak</a>
        </td>
    </tr>
    <?php endwhile; ?>
                </table>
            </div>
            <div class="page-actions">
                <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
