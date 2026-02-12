<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Admin') header("location:../index.php");

// Query JOIN biar kita bisa nampilin Nama Kategori, bukan cuma ID-nya
$query = "SELECT truk.*, kategori_truk.nama_kategori 
          FROM truk 
          LEFT JOIN kategori_truk ON truk.id_kategori = kategori_truk.id_kategori";
$res = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Armada - Haul Out .Co</title>
    <link rel="stylesheet" href="../config/style.css">
</head>
<body>
<div class="container" style="max-width: 1100px;">
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
    <h2>Manajemen Armada Truk</h2>
    <div style="margin-bottom: 20px;">
        <a href="tambah_truk.php" class="btn btn-tambah">+ Tambah Armada</a>
        <a href="dashboard.php" class="btn" style="background: #6c757d; color: white; text-decoration: none;">Kembali</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Plat Nomor</th>
                <th>Merk</th>
                <th>Kategori</th>
                <th>Harga / Hari</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while($row = mysqli_fetch_assoc($res)) : 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><strong><?= $row['plat_nomor']; ?></strong></td>
                <td><?= $row['merk']; ?></td>
                <td><?= $row['nama_kategori']; ?></td>
                <td>
                    <span style="color: #27ae60; font-weight: bold;">
                        Rp <?= number_format($row['harga_per_hari'], 0, ',', '.'); ?>
                    </span>
                </td>
                <td>
                    <?php 
                        $status_class = '';
                        if($row['status'] == 'Tersedia') $status_class = 'tersedia';
                        elseif($row['status'] == 'Dipinjam') $status_class = 'dipinjam';
                        else $status_class = 'perbaikan'; // Pastikan CSS lu ada class perbaikan
                    ?>
                    <span class="badge <?= $status_class; ?>"><?= $row['status']; ?></span>
                </td>
                <td>
                    <a href="edit_truk.php?id=<?= $row['id_truk']; ?>" class="btn btn-edit">Edit</a>
                    <a href="hapus_truk.php?id=<?= $row['id_truk']; ?>" class="btn btn-hapus" onclick="return confirm('Yakin hapus armada ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>