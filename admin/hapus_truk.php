<?php
session_start();
include '../config/db.php';

if($_SESSION['role'] != 'Admin') header("location:../index.php");

$id = $_GET['id'];

if (isset($id)) {
    // 1. Hapus dulu data di tabel pengembalian yang nyambung ke peminjaman truk ini
    mysqli_query($conn, "DELETE FROM pengembalian WHERE id_pinjam IN (SELECT id_pinjam FROM peminjaman WHERE id_truk = '$id')");

    // 2. Hapus data di tabel peminjaman yang nyambung ke truk ini
    mysqli_query($conn, "DELETE FROM peminjaman WHERE id_truk = '$id'");

    // 3. Baru hapus truknya
    $query = mysqli_query($conn, "DELETE FROM truk WHERE id_truk = '$id'");

    if($query) {
        echo "<script>
                alert('Truk dan semua riwayatnya berhasil dihapus!');
                window.location='data_truk.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("location:data_truk.php");
}
?>