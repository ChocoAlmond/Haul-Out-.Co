<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Admin') header("location:../index.php");

// Proses Tambah Kategori
if(isset($_POST['tambah'])){
    $nama = trim($_POST['nama_kategori'] ?? '');
    if ($nama !== '') {
        $stmt = mysqli_prepare($conn, "INSERT INTO kategori_truk (nama_kategori) VALUES (?)");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $nama);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
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
<body class="page-shell">
<div class="container">
    <div class="panel-card">
        <div class="panel-body">
            <div class="section-header">
                <div>
                    <h1 class="page-title">Master Kategori Truk</h1>
                    <p class="page-subtitle">Tambahkan dan kelola kategori truk untuk memudahkan pencarian armada.</p>
                </div>
            </div>
            <form method="POST" class="form-inline">
                <input type="text" name="nama_kategori" placeholder="Nama Kategori Baru" required>
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