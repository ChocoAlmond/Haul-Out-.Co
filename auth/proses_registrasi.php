<?php
include '../config/db.php';

echo"<h2>Memprosess Registrasi...</h2>";

if (isset($_POST['register'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role     = trim($_POST['role'] ?? '');

    $stmt = mysqli_prepare($conn, "SELECT 1 FROM users WHERE username = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_close($stmt);
            header("location:../registrasi.php?pesan=gagal");
            exit;
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $username, $password, $role);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='../login.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("location:../registrasi.php");
    exit;
}
?>