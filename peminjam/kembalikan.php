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

$id_pinjam = intval($_GET['id']);
if ($id_pinjam <= 0) {
    header("location:riwayat_pinjam.php");
    exit;
}

// 1. Ambil detail pinjaman
$stmt = mysqli_prepare($conn, "SELECT p.*, t.plat_nomor, t.merk FROM peminjaman p JOIN truk t ON p.id_truk = t.id_truk WHERE p.id_pinjam = ?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id_pinjam);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($conn);
    exit;
}

// Jika data tidak ditemukan
if (!$data) {
    echo "Data peminjaman tidak ditemukan.";
    exit;
}

$tgl_kembali_sekarang = date('Y-m-d');
$tgl_rencana = $data['tgl_kembali_rencana'];

// 2. Hitung denda pakai FUNCTION SQL
$stmt = mysqli_prepare($conn, "SELECT hitung_denda(?, ?) AS total_denda");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $tgl_rencana, $tgl_kembali_sekarang);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row_denda = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    $denda = $row_denda['total_denda'];
} else {
    echo "Error: " . mysqli_error($conn);
    exit;
}

// 3. Logika Proses Simpan
if(isset($_POST['proses_kembali'])) {
    $id_truk = intval($data['id_truk']);
    $id_user = intval($_SESSION['id_user'] ?? 0);
    
    // Simpan ke tabel pengembalian
    $stmt = mysqli_prepare($conn, "INSERT INTO pengembalian (id_pinjam, tgl_kembali_aktual, denda) VALUES (?, ?, ?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iss", $id_pinjam, $tgl_kembali_sekarang, $denda);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            
            $stmt = mysqli_prepare($conn, "UPDATE truk SET status = 'Tersedia' WHERE id_truk = ?");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $id_truk);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
            
            $stmt = mysqli_prepare($conn, "UPDATE peminjaman SET status_approval = 'Selesai' WHERE id_pinjam = ?");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $id_pinjam);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
            
            $msg_log = "Mengembalikan truk " . $data['plat_nomor'] . " dengan denda Rp " . number_format($denda, 0, ',', '.');
            $stmt = mysqli_prepare($conn, "INSERT INTO log_aktivitas (id_user, aktivitas) VALUES (?, ?)");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "is", $id_user, $msg_log);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
            
            echo "<script>alert('Berhasil dikembalikan! " . ($denda > 0 ? "Denda Anda: Rp " . number_format($denda,0,',','.') : "Tidak ada denda.") . "'); window.location='riwayat_pinjam.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
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
<body class="page-shell">
<div class="container">
    <div class="panel-card">
        <div class="panel-body">
            <div class="section-header">
                <div>
                    <h1 class="page-title">Konfirmasi Pengembalian</h1>
                    <p class="page-subtitle">Pastikan detail pengembalian benar sebelum menyelesaikan proses.</p>
                </div>
            </div>

            <div class="detail-panel">
        <p><strong>Plat Nomor:</strong> <?= $data['plat_nomor']; ?></p>
        <p><strong>Merk Unit:</strong> <?= $data['merk']; ?></p>
        <p><strong>Tanggal Pinjam:</strong> <?= $data['tgl_pinjam']; ?></p>
        <p><strong>Jatuh Tempo:</strong> <?= $data['tgl_kembali_rencana']; ?></p>
        <p><strong>Tanggal Kembali:</strong> <?= $tgl_kembali_sekarang; ?></p>
        <hr>
        <h3 style="font-size: 1.6rem; color: <?= $denda > 0 ? '#fb7185' : '#2dd4bf'; ?>;">
            Total Denda: Rp <?= number_format($denda, 0, ',', '.'); ?>
        </h3>
        <?php if($denda > 0): ?>
            <p class="alert alert-danger">*Terlambat mengembalikan akan dikenakan denda sesuai kebijakan sistem.</p>
        <?php else: ?>
            <p class="alert alert-success">Tepat waktu! Tidak ada denda.</p>
        <?php endif; ?>
    </div>

    <form method="POST">
        <button type="submit" name="proses_kembali" class="btn btn-hapus">Selesaikan Pengembalian</button>
    </form>
    <div class="page-actions" style="margin-top: 20px;">
        <a href="riwayat_pinjam.php" class="btn btn-secondary">← Batal</a>
    </div>
        </div>
    </div>
</div>
</body>
</html>