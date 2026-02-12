<?php
session_start();
include '../config/db.php';

// Proteksi: Hanya Peminjam yang boleh akses
if($_SESSION['role'] != 'Peminjam') {
    header("location:../index.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Query untuk mengambil riwayat pinjam user ini (Relasi ke tabel truk)
$query = "SELECT p.*, t.plat_nomor, t.merk 
          FROM peminjaman p 
          JOIN truk t ON p.id_truk = t.id_truk 
          WHERE p.id_user = '$id_user' 
          ORDER BY p.id_pinjam DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pinjaman Saya</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
</head>
<body>

<div class="container">
    <p>Haul Out .Co</p>
    <h2>Riwayat Peminjaman Saya</h2>
    
    <table style="margin-top: 20px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Unit Truk</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali (Rencana)</th>
                <th>Status Approval</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while($row = mysqli_fetch_assoc($result)): 
                // Logika warna badge status
                $status = $row['status_approval'];
                $class_badge = "";
                if($status == 'Pending') $class_badge = "dipinjam"; // Warna merah/kuning
                if($status == 'Disetujui') $class_badge = "tersedia"; // Warna hijau
                if($status == 'Selesai') $class_badge = "tersedia";
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><strong><?= $row['plat_nomor']; ?></strong><br><small><?= $row['merk']; ?></small></td>
                <td><?= $row['tgl_pinjam']; ?></td>
                <td><?= $row['tgl_kembali_rencana']; ?></td>
                <td>
                    <span class="badge <?= $class_badge; ?>"><?= $status; ?></span>
                </td>
                <td>
                    <?php if($status == 'Disetujui'): ?>
                        <a href="kembalikan.php?id=<?= $row['id_pinjam']; ?>" class="btn btn-hapus">Kembalikan</a>
                    <?php elseif($status == 'Selesai'): ?>
                        <span style="color: gray;">Sudah Dikembalikan</span>
                    <?php else: ?>
                        <small>Menunggu ACC</small>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
            
            <?php if(mysqli_num_rows($result) == 0): ?>
            <tr>
                <td colspan="6" style="text-align: center;">Belum ada riwayat peminjaman.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn btn-tambah">Kembali ke Dashboard</a>
</div>

</body>
</html>