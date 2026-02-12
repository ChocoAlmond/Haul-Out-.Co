<?php
session_start();
include '../config/db.php';

// Proteksi Level
if($_SESSION['role'] != 'Peminjam') {
    header("location:../index.php");
    exit;
}

// Cek ID Pinjam di URL
if(!isset($_GET['id'])) {
    header("location:riwayat_pinjam.php");
    exit;
}

$id_pinjam = $_GET['id'];

// 1. Ambil detail pinjaman
$query = "SELECT p.*, t.plat_nomor, t.merk 
          FROM peminjaman p 
          JOIN truk t ON p.id_truk = t.id_truk 
          WHERE p.id_pinjam = '$id_pinjam'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan
if(!$data) {
    echo "Data peminjaman tidak ditemukan.";
    exit;
}

$tgl_kembali_sekarang = date('Y-m-d');
$tgl_rencana = $data['tgl_kembali_rencana'];

// 2. Hitung denda pakai FUNCTION SQL
$sql_denda = mysqli_query($conn, "SELECT hitung_denda('$tgl_rencana', '$tgl_kembali_sekarang') AS total_denda");
$row_denda = mysqli_fetch_assoc($sql_denda);
$denda = $row_denda['total_denda'];

// 3. Logika Proses Simpan
if(isset($_POST['proses_kembali'])) {
    $id_truk = $data['id_truk'];
    $id_user = $_SESSION['id_user'];
    
    // Simpan ke tabel pengembalian
    $insert = "INSERT INTO pengembalian (id_pinjam, tgl_kembali_aktual, denda) 
               VALUES ('$id_pinjam', '$tgl_kembali_sekarang', '$denda')";
    
    if(mysqli_query($conn, $insert)) {
        // Update status truk jadi 'Tersedia'
        mysqli_query($conn, "UPDATE truk SET status = 'Tersedia' WHERE id_truk = '$id_truk'");
        
        // Update status peminjaman jadi 'Selesai'
        mysqli_query($conn, "UPDATE peminjaman SET status_approval = 'Selesai' WHERE id_pinjam = '$id_pinjam'");
        
        // Catat ke Log Aktivitas
        $msg_log = "Mengembalikan truk " . $data['plat_nomor'] . " dengan denda Rp " . number_format($denda, 0, ',', '.');
        mysqli_query($conn, "INSERT INTO log_aktivitas (id_user, aktivitas) VALUES ('$id_user', '$msg_log')");
        
        echo "<script>alert('Berhasil dikembalikan! " . ($denda > 0 ? "Denda Anda: Rp " . number_format($denda,0,',','.') : "Tidak ada denda.") . "'); window.location='riwayat_pinjam.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pengembalian</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
</head>
<body>
<div class="container">
    <p>Haul Out .Co</p>
    <h2>Konfirmasi Pengembalian Truk</h2>
    
    <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 20px; line-height: 1.6;">
        <p><strong>Plat Nomor:</strong> <?= $data['plat_nomor']; ?></p>
        <p><strong>Merk Unit:</strong> <?= $data['merk']; ?></p>
        <p><strong>Tanggal Pinjam:</strong> <?= $data['tgl_pinjam']; ?></p>
        <p><strong>Jatuh Tempo:</strong> <?= $data['tgl_kembali_rencana']; ?></p>
        <p><strong>Tanggal Kembali:</strong> <?= $tgl_kembali_sekarang; ?></p>
        <hr>
        <h3 style="color: <?= $denda > 0 ? '#e74c3c' : '#27ae60'; ?>;">
            Total Denda: Rp <?= number_format($denda, 0, ',', '.'); ?>
        </h3>
        <?php if($denda > 0): ?>
            <p style="color: #e74c3c; font-size: 13px;">*Terlambat mengembalikan akan dikenakan denda sesuai kebijakan sistem.</p>
        <?php else: ?>
            <p style="color: #27ae60; font-size: 13px;">Tepat waktu! Tidak ada denda.</p>
        <?php endif; ?>
    </div>

    <form method="POST">
        <button type="submit" name="proses_kembali" class="btn btn-hapus" style="width: 100%; font-size: 16px;">Selesaikan Pengembalian</button>
        <br><br>
        <center><a href="riwayat_pinjam.php" style="color: #7f8c8d; text-decoration: none;">← Batal</a></center>
    </form>
</div>
</body>
</html>