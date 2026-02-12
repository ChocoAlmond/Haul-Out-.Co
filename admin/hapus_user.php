<?php
session_start();
include '../config/db.php';
if($_SESSION['role'] != 'Admin') header("location:../index.php");

$id = $_GET['id'];
// Jangan hapus diri sendiri (Safety Check)
if($id == $_SESSION['id_user']) {
    echo "<script>alert('Gak bisa hapus akun sendiri!'); window.location='data_user.php';</script>";
} else {
    mysqli_query($conn, "DELETE FROM users WHERE id_user = '$id'");
    header("location:data_user.php");
}
?>