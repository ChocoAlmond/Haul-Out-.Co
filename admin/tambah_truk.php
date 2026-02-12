<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Admin') header("location:../index.php");

if(isset($_POST['simpan'])) {
    $plat  = $_POST['plat_nomor'];
    $merk  = $_POST['merk'];
    $kat   = $_POST['id_kategori'];
    $harga = $_POST['harga_per_hari']; // Ambil data harga

    $sql = "INSERT INTO truk (plat_nomor, merk, id_kategori, harga_per_hari, status) 
            VALUES ('$plat', '$merk', '$kat', '$harga', 'Tersedia')";
    
    if(mysqli_query($conn, $sql)) {
        header("location:data_truk.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Truk</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
</head>
<body>
<div class="container">
    <p>Haul Out .Co</p>
    <h2>Tambah Armada Baru</h2>
    <form method="POST">
        <label>Plat Nomor</label>
        <input type="text" name="plat_nomor" placeholder="B 1234 ABC" required>
        
        <label>Merk Truk</label>
        <input type="text" name="merk" placeholder="Hino / Fuso / Isuzu" required>

        <label>Kategori</label>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php 
            $res = mysqli_query($conn, "SELECT * FROM kategori_truk");
            while($row = mysqli_fetch_assoc($res)) {
                echo "<option value='".$row['id_kategori']."'>".$row['nama_kategori']."</option>";
            }
            ?>
        </select>

        <label>Harga Per Hari (Rp)</label>
        <input type="number" name="harga_per_hari" placeholder="Contoh: 500000" required>

        <button type="submit" name="simpan" class="btn btn-tambah">Simpan Armada</button>
        <a href="data_truk.php" class="btn btn-hapus" style="text-decoration:none">Batal</a>
    </form>
</div>
</body>
</html>