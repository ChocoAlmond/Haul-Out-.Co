<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Admin') header("location:../index.php");

$id = $_GET['id'];
$data_truk = mysqli_query($conn, "SELECT * FROM truk WHERE id_truk = '$id'");
$truk = mysqli_fetch_assoc($data_truk);

if(isset($_POST['update'])) {
    $plat  = $_POST['plat_nomor'];
    $merk  = $_POST['merk'];
    $kat   = isset($_POST['id_kategori']) ? $_POST['id_kategori'] : '';
    $status = $_POST['status'];
    $harga = $_POST['harga_per_hari']; // Ambil data harga

    if($kat != '') {
        // Query Update lengkap dengan harga
        $sql = "UPDATE truk SET 
                plat_nomor='$plat', 
                merk='$merk', 
                id_kategori='$kat', 
                harga_per_hari='$harga', 
                status='$status' 
                WHERE id_truk='$id'";
        
        if(mysqli_query($conn, $sql)) {
            echo "<script>alert('Berhasil Update!'); window.location='data_truk.php';</script>";
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