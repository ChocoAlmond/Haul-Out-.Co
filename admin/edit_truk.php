<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Admin') header("location:../index.php");

$id = intval($_GET['id'] ?? 0);
$truk = null;

if ($id > 0) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM truk WHERE id_truk = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $truk = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
    }
}

if (!$truk) {
    header("location:data_truk.php");
    exit;
}

if(isset($_POST['update'])) {
    $plat   = trim($_POST['plat_nomor'] ?? '');
    $merk   = trim($_POST['merk'] ?? '');
    $kat    = intval($_POST['id_kategori'] ?? 0);
    $status = trim($_POST['status'] ?? '');
    $harga  = floatval($_POST['harga_per_hari'] ?? 0);

    if ($kat > 0) {
        $stmt = mysqli_prepare($conn, "UPDATE truk SET plat_nomor = ?, merk = ?, id_kategori = ?, harga_per_hari = ?, status = ? WHERE id_truk = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssidsi", $plat, $merk, $kat, $harga, $status, $id);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Berhasil Update!'); window.location='data_truk.php';</script>";
                mysqli_stmt_close($stmt);
                exit;
            } else {
                echo "Gagal Update: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Gagal Update: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Pilih Kategori dulu!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Armada</title>
    <link rel="stylesheet" href="../config/style.css">
</head>
<body>
<div class="container">
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
    <h2>Edit Data Truk</h2>
    <form method="POST">
        <label>Plat Nomor</label>
        <input type="text" name="plat_nomor" value="<?= $truk['plat_nomor'] ?>" required>
        
        <label>Merk</label>
        <input type="text" name="merk" value="<?= $truk['merk'] ?>" required>

        <label>Kategori</label>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php 
            $ambil_kat = mysqli_query($conn, "SELECT * FROM kategori_truk");
            while($k = mysqli_fetch_assoc($ambil_kat)) {
                $select = ($k['id_kategori'] == $truk['id_kategori']) ? 'selected' : '';
                echo "<option value='".$k['id_kategori']."' $select>".$k['nama_kategori']."</option>";
            }
            ?>
        </select>
        
        <label>Status</label>
        <select name="status">
            <option value="Tersedia" <?= $truk['status'] == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
            <option value="Dipinjam" <?= $truk['status'] == 'Dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
            <option value="Perbaikan" <?= $truk['status'] == 'Perbaikan' ? 'selected' : '' ?>>Perbaikan</option>
        </select>

        <label>Harga Per Hari (Rp)</label>
        <input type="number" name="harga_per_hari" value="<?= $truk['harga_per_hari'] ?>" required>

        <button type="submit" name="update" class="btn btn-tambah">Update Data</button>
        <a href="data_truk.php" class="btn btn-hapus" style="text-decoration:none">Batal</a>
    </form>
</div>
</body>
</html>