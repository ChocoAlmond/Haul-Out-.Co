<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Admin') header("location:../index.php");

// Proses Tambah Kategori
if(isset($_POST['tambah'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    mysqli_query($conn, "INSERT INTO kategori_truk (nama_kategori) VALUES ('$nama')");
    header("location:data_kategori.php");
}

$result = mysqli_query($conn, "SELECT * FROM kategori_truk");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kategori</title>
    <link rel="stylesheet" href="../config/style.css">
</head>
<body>
<div class="container">
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
    <h2>Master Kategori Truk</h2>
    
    <form method="POST" style="margin: 20px 0;">
        <input type="text" name="nama_kategori" placeholder="Nama Kategori Baru" required style="padding: 10px; width: 250px;">
        <button type="submit" name="tambah" class="btn btn-tambah">Tambah Kategori</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id_kategori'] ?></td>
                <td><?= $row['nama_kategori'] ?></td>
                <td>
                    <a href="hapus_kategori.php?id=<?= $row['id_kategori'] ?>" class="btn btn-hapus" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn btn-tambah">Kembali ke Dashboard</a>
</div>
</body>
</html>