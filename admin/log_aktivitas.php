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
<body class="page-shell">
<div class="container">
    <div class="panel-card">
        <div class="panel-body">
            <div class="section-header">
                <div>
                    <h1 class="page-title">Log Aktivitas</h1>
                    <p class="page-subtitle">Catatan aktivitas pengguna dan aksi sistem yang terekam secara real-time.</p>
                </div>
            </div>
            <div class="table-wrapper">
                <table>
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
            </div>
            <div class="page-actions">
                <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>