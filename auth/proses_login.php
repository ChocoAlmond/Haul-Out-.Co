<?php
session_start();
include '../config/db.php';
include '.../config/style.css';

echo"<h2>Memprosess Login...</h2>";

if (isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = mysqli_prepare($conn, "SELECT id_user, username, role FROM users WHERE username = ? AND password = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 1) {
            mysqli_stmt_bind_result($stmt, $id_user, $db_username, $role);
            mysqli_stmt_fetch($stmt);

            $_SESSION['id_user']  = $id_user;
            $_SESSION['username'] = $db_username;
            $_SESSION['role']     = $role;

            if ($role === "Admin") {
                header("location:../admin/dashboard.php");
            } elseif ($role === "Petugas") {
                header("location:../petugas/dashboard.php");
            } else {
                header("location:../peminjam/dashboard.php");
            }
        } else {
            echo "<script>alert('Username/Password Salah!'); window.location='../login.php';</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}