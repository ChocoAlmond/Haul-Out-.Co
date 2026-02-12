<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Admin') header("location:../index.php");

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM kategori_truk WHERE id_kategori = '$id'");
header("location:data_kategori.php");
exit;
?>