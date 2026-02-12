<?php
session_start();
include '../config/db.php';

if(isset($_POST['id_truk'])) {
    $id_user = $_SESSION['id_user'];
    $id_truk = $_POST['id_truk'];
    $tgl_pinjam = date('Y-m-d');
    $tgl_kembali = $_POST['tgl_kembali_rencana'];

    $sql = "INSERT INTO peminjaman (id_user, id_truk, tgl_pinjam, tgl_kembali_rencana, status_approval) 
            VALUES ('$id_user', '$id_truk', '$tgl_pinjam', '$tgl_kembali', 'Pending')";
    
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Berhasil diajukan!'); window.location='daftar_truk.php';</script>";
    }
}