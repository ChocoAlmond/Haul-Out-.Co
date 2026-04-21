<?php
session_start();
include '../config/db.php';

if (isset($_POST['id_truk'])) {
    $id_user = intval($_SESSION['id_user'] ?? 0);
    $id_truk = intval($_POST['id_truk']);
    $tgl_pinjam = date('Y-m-d');
    $tgl_kembali = trim($_POST['tgl_kembali_rencana'] ?? '');

    $stmt = mysqli_prepare($conn, "INSERT INTO peminjaman (id_user, id_truk, tgl_pinjam, tgl_kembali_rencana, status_approval) VALUES (?, ?, ?, ?, 'Pending')");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iiss", $id_user, $id_truk, $tgl_pinjam, $tgl_kembali);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Berhasil diajukan!'); window.location='daftar_truk.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}