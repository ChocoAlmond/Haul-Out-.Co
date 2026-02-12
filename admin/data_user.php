<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Admin') header("location:../index.php");

$result = mysqli_query($conn, "SELECT * FROM users");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen User</title>
    <link rel="stylesheet" href="../config/style.css">
</head>
<body>
<div class="container">
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
    <h2>Daftar Pengguna Sistem</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['username'] ?></td>
            <td><?= $row['role'] ?></td>
            <td>
                <a href="hapus_user.php?id=<?= $row['id_user'] ?>" class="btn btn-hapus" onclick="return confirm('Hapus user ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="dashboard.php" class="btn btn-tambah">Kembali</a>
</div>
</body>
</html>