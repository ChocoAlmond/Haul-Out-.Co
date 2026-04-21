<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Admin') header("location:../index.php");

$id = intval($_GET['id'] ?? 0);
// Jangan hapus diri sendiri (Safety Check)
if ($id === intval($_SESSION['id_user'] ?? 0)) {
    echo "<script>alert('Gak bisa hapus akun sendiri!'); window.location='data_user.php';</script>";
    exit;
}

if ($id > 0) {
    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id_user = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

header("location:data_user.php");
exit;
?>