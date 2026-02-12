<?php
include '../config/db.php';
$id = $_GET['id'];
$status = $_GET['status'];

// Query update status pinjam
mysqli_query($conn, "UPDATE peminjaman SET status_approval = '$status' WHERE id_pinjam = '$id'");

// TRIGGER di MySQL akan otomatis mengubah status TRUK menjadi 'Dipinjam'
header("location:dashboard.php");