<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Peminjam') header("location:../index.php");

// Ambil truk yang statusnya cuma 'Tersedia'
$query = "SELECT truk.*, kategori_truk.nama_kategori 
          FROM truk 
          JOIN kategori_truk ON truk.id_kategori = kategori_truk.id_kategori 
          WHERE status = 'Tersedia'";
$result = mysqli_query($conn, $query);
?>
<link rel="stylesheet" href="../config/style.css">
<div class="container">
<p>Haul Out .Co</p>
<h2>Daftar Truk Tersedia</h2>
<table>
    <tr>
        <th>Plat</th>
        <th>Merk</th>
        <th>Kategori</th>
        <th>Aksi</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $row['plat_nomor'] ?></td>
        <td><?= $row['merk'] ?></td>
        <td><?= $row['nama_kategori'] ?></td>
        <td>
            <form action="proses_pinjam.php" method="POST">
                <input type="hidden" name="id_truk" value="<?= $row['id_truk'] ?>">
                <label>Target Tanggal Pengembalian:</label>
                <input type="date" name="tgl_kembali_rencana" required>
                <button type="submit" class="btn btn-tambah">Ajukan Pinjam</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="dashboard.php" class="btn btn-tambah">Kembali ke Dashboard</a>
</div>