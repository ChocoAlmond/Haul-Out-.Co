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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Truk Tersedia - Haul Out CO</title>
    <link rel="stylesheet" href="../config/style.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Truk Tersedia</h2>
        <p style="color: var(--gray-500); margin-bottom: 30px; font-size: 1.05rem;">Pilih truk yang sesuai dengan kebutuhan Anda</p>
        
        <div class="cards-grid">
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <div class="truck-card">
                    <div class="truck-card-header">
                        <div class="truck-card-title"><?= htmlspecialchars($row['plat_nomor']) ?></div>
                        <span class="badge tersedia">Tersedia</span>
                    </div>

                    <div class="truck-card-info">
                        <div class="truck-card-info-item">
                            <span class="truck-card-info-label">Merk</span>
                            <span class="truck-card-info-value"><?= htmlspecialchars($row['merk']) ?></span>
                        </div>
                        <div class="truck-card-info-item">
                            <span class="truck-card-info-label">Kategori</span>
                            <span class="truck-card-info-value"><?= htmlspecialchars($row['nama_kategori']) ?></span>
                        </div>
                        <div class="truck-card-info-item">
                            <span class="truck-card-info-label">Harga/Hari</span>
                            <span class="truck-card-info-value">Rp <?= number_format($row['harga_per_hari'], 0, ',', '.') ?></span>
                        </div>
                    </div>

                    <div class="truck-card-actions">
                        <form action="proses_pinjam.php" method="POST">
                            <input type="hidden" name="id_truk" value="<?= $row['id_truk'] ?>">
                            
                            <label style="margin-bottom: 8px;">📅 Rencana Tanggal Pengembalian </label>
                            <input type="date" name="tgl_kembali_rencana" required style="margin-bottom: 12px;">
                            
                            <button type="submit" class="btn btn-tambah">Ajukan Peminjaman</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div style="margin-top: 40px; text-align: center;">
            <a href="dashboard.php" class="btn btn-tambah" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-color-light)); margin-right: 10px;">← Kembali ke Dashboard</a>
        </div>
    </div>
    <script src="../config/mobile-menu.js"></script>
</body>
</html>