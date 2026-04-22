<?php
session_start();
include '../config/db.php';

// Proteksi: Hanya Peminjam yang boleh akses
if($_SESSION['role'] != 'Peminjam') {
    header("location:../index.php");
    exit;
}

$id_user = intval($_SESSION['id_user'] ?? 0);

// Query untuk mengambil riwayat pinjam user ini (Relasi ke tabel truk)
$stmt = mysqli_prepare($conn, "SELECT p.*, t.plat_nomor, t.merk FROM peminjaman p JOIN truk t ON p.id_truk = t.id_truk WHERE p.id_user = ? ORDER BY p.id_pinjam DESC");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id_user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
} else {
    $result = mysqli_query($conn, "SELECT p.*, t.plat_nomor, t.merk FROM peminjaman p JOIN truk t ON p.id_truk = t.id_truk WHERE p.id_user = $id_user ORDER BY p.id_pinjam DESC");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pinjaman Saya</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
</head>
<body class="page-shell">

<div class="container">
    <div class="panel-card">
        <div class="panel-body">
            <div class="section-header">
                <div>
                    <h1 class="page-title">Riwayat Peminjaman Saya</h1>
                    <p class="page-subtitle">Lihat status semua peminjamanmu, dari pending sampai selesai.</p>
                </div>
            </div>
            <div class="table-wrapper">
                <table>
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
                        <span class="text-muted">Sudah Dikembalikan</span>
                    <?php else: ?>
                        <small class="text-muted">Menunggu ACC</small>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
            
            <?php if(mysqli_num_rows($result) == 0): ?>
            <tr>
                <td colspan="6" class="text-center">Belum ada riwayat peminjaman.</td>
            </tr>
            <?php endif; ?>
        </tbody>
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