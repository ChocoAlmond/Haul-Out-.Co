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

<link rel="stylesheet" href="../config/style.css">
<div class="container">
<p>Haul Out .Co</p>
<h2>Daftar Persetujuan Peminjaman Truk</h2>
<table border="1">
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
<a href="dashboard.php" class="btn btn-tambah">Kembali ke Dashboard</a>
</div>