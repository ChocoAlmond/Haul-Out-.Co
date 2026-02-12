<?php
session_start();
include '../config/db.php';
include '.../config/style.css';

echo"<h2>Memprosess Login...</h2>";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        
        // SET SESSION PENTING
        $_SESSION['id_user']  = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role']     = $data['role'];

        if ($data['role'] == "Admin") {
            header("location:../admin/dashboard.php");
        } elseif ($data['role'] == "Petugas") {
            header("location:../petugas/dashboard.php");
        } else {
            header("location:../peminjam/dashboard.php");
        }
    } else {
        echo "<script>alert('Username/Password Salah!'); window.location='../login.php';</script>";
    }
}