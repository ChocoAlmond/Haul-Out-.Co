<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Admin') header("location:../index.php");

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = mysqli_prepare($conn, "DELETE FROM kategori_truk WHERE id_kategori = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

header("location:data_kategori.php");
exit;
?>