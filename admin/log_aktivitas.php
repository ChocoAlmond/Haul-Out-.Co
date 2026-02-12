<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Admin') header("location:../index.php");

// Ambil data log digabung dengan username
$query = "SELECT l.*, u.username FROM log_aktivitas l 
          JOIN users u ON l.id_user = u.id_user 
          ORDER BY l.waktu DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log Aktivitas Sistem</title>
    <link rel="stylesheet" href="../config/style.css">
    <link rel="icon" type="image/x-icon" href="../HaulOut.ico">
</head>
<body>
<div class="container">
    <p>Haul Out .Co</p>
    <h2>Log Aktivitas Pengguna</h2>

    <table style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>User</th>
                <th>Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['waktu'] ?></td>
                <td><strong><?= $row['username'] ?></strong></td>
                <td><?= $row['aktivitas'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn btn-tambah">Kembali ke Dashboard</a>
</div>
</body>
</html>