<?php
session_start();
include '../config/db.php';

if ($_SESSION['role'] != 'Admin') header("location:../index.php");

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = mysqli_prepare($conn, "DELETE FROM pengembalian WHERE id_pinjam IN (SELECT id_pinjam FROM peminjaman WHERE id_truk = ?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    $stmt = mysqli_prepare($conn, "DELETE FROM peminjaman WHERE id_truk = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    $stmt = mysqli_prepare($conn, "DELETE FROM truk WHERE id_truk = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                    alert('Truk dan semua riwayatnya berhasil dihapus!');
                    window.location='data_truk.php';
                  </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
} else {
    header("location:data_truk.php");
    exit;
}
?>