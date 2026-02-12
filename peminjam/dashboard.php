<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Peminjam') header("location:../index.php");

$id_user = $_SESSION['id_user'];
// Hitung berapa truk yang sedang dipinjam user ini
$cek_pinjam = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE id_user = '$id_user' AND status_approval = 'Disetujui'");
$data = mysqli_fetch_assoc($cek_pinjam);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Peminjam</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
</head>
<body>
<div class="container">
    <p>Haul Out .Co</p>
    <h2>Selamat Datang, <?= $_SESSION['username']; ?>!</h2>
    <p>Status kamu saat ini sedang meminjam <strong><?= $data['total']; ?></strong> truk.</p>
    
    <div style="margin-top: 20px;">
        <a href="daftar_truk.php" class="btn btn-tambah">Cari & Pinjam Truk</a>
        <a href="kembalikan.php" class="btn btn-tambah">Pengembalian</a>
        <a href="riwayat_pinjam.php" class="btn btn-edit">Riwayat Peminjaman</a>
        <a href="../auth/logout.php" class="btn btn-hapus">Logout</a>
    </div>
</div>
</body>
</html>